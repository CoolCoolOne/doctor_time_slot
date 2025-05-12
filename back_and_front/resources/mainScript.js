// DBtn = day button
// ABtn = approve button

function getDBtnsAreas() {
    const stuffers_days = document.querySelectorAll("div.days");
    let DBtnsAreas = [];
    stuffers_days.forEach((item, index) => {
        DBtnsAreas[index] = item.querySelectorAll("div.oneDay");
    })
    return DBtnsAreas;
};

function getTimeslotsAreas() {
    const timeslotsAreas = document.querySelectorAll("div.freeTime");
    return timeslotsAreas;
};

function getABtnsAreas() {
    const ABtnsAreas = document.querySelectorAll("div.approveBtnArea");
    return ABtnsAreas;
};

function displaySlots(buttonD, slotsArea, ABtnsArea) {
    let slots = (buttonD.querySelector("div.date").querySelector("div.none").childNodes);

    let day = (buttonD.querySelector("div.date").dataset.day)

    removeSlots(slotsArea);
    renderSlots(slots, slotsArea, day);

    function removeSlots(slotsArea) {
        while (slotsArea.firstChild) {
            slotsArea.removeChild(slotsArea.firstChild);
        }
    };

    function renderSlots(slots, slotsArea, day) {
        slots.forEach((slot) => {
            oneTime = document.createElement("div");
            oneTime.classList.add('oneTime');
            oneTime_p = document.createElement("p");

            slotsArea.appendChild(oneTime);
            oneTime.appendChild(oneTime_p);

            oneTime_p.innerText = slot.outerText;

            // передаём данные для записи
            oneTime.dataset.time = slot.dataset.time;
            oneTime.dataset.day = day;

            addListenerToTimeBtn(oneTime, ABtnsArea);
        });

        function addListenerToAbtn(okButton) {
            okButton.addEventListener('click', function (e) {
                let popupBg = document.querySelector('.popup__bg');
                let popup = document.querySelector('.popup');
                let popup_info = document.querySelector('div.popup_info');
                let closePopupButton = document.querySelector('.close-popup');

                document.getElementById('customer_button').classList.remove('noneRes');
                document.getElementById('customer_back_info').classList.add('noneRes');

                setDataForBooking(okButton);



                function setDataForBooking(okButton) {
                    popup_info.dataset.uuidstuf = okButton.parentNode.parentNode.parentNode.dataset.uuidstuf;
                    popup_info.dataset.uuidloc = okButton.parentNode.parentNode.parentNode.dataset.uuidloc;
                    popup_info.dataset.uuidserv = okButton.parentNode.parentNode.parentNode.dataset.uuidserv;

                    let datetime = new Date(okButton.dataset.day);
                    datetime.setSeconds(okButton.dataset.time);
                    datetime = datetime.toISOString();


                    popup_info.dataset.datetime = datetime;
                }



                e.preventDefault();
                popupBg.classList.add('active');
                popup.classList.add('active');





                closePopupButton.addEventListener('click', () => {
                    popupBg.classList.remove('active');
                    popup.classList.remove('active');
                });

                document.addEventListener('click', (e) => {
                    if (e.target === popupBg) {
                        popupBg.classList.remove('active');
                        popup.classList.remove('active');
                    }
                });
            })
        }

        function addListenerToTimeBtn(timeBtn, ABtnsArea) {
            timeBtn.addEventListener('click', function () {

                renderABtnsToggling(this);
                displayABtn(ABtnsArea);


                function renderABtnsToggling(thisB) {
                    let childrens = thisB.parentNode.childNodes;
                    for (var i = 0; i < childrens.length; ++i) {
                        childrens[i].classList.remove('chosen');
                    }
                    thisB.classList.add('chosen');
                };
                function displayABtn(ABtnsArea) {

                    removeABtns(ABtnsArea);
                    renderABtns(ABtnsArea, timeBtn.dataset);

                    function removeABtns(ABtnsArea) {
                        while (ABtnsArea.firstChild) {
                            ABtnsArea.removeChild(ABtnsArea.firstChild);
                        }
                    };

                    function renderABtns(ABtnsArea, thisB) {

                        let okButton = document.createElement("div");
                        okButton.classList.add('okButton');
                        let okButton_p = document.createElement("p");
                        let okButton_img = document.createElement("img");



                        ABtnsArea.appendChild(okButton);
                        okButton.appendChild(okButton_img);
                        okButton.appendChild(okButton_p);

                        // передаём данные для записи
                        okButton.dataset.time = thisB.time;
                        okButton.dataset.day = thisB.day;

                        okButton_img.src = './resources/imgs/note.png';
                        okButton_img.width = '60';
                        okButton_p.innerText = 'Записаться на приём';

                        addListenerToAbtn(okButton);

                    };


                };

            });
        };
    };


};



function renderDBtnsToggling(DBtns, thisBtn) {
    DBtns.forEach(i => i.classList.remove('chosen'));
    thisBtn.classList.toggle('chosen');
};

function removeABtn(ABtnsArea) {
    while (ABtnsArea.firstChild) {
        ABtnsArea.removeChild(ABtnsArea.firstChild);
    }
};




const DBtnsAreas = getDBtnsAreas();
const timeslotsAreas = getTimeslotsAreas();
const ABtnsAreas = getABtnsAreas();



DBtnsAreas.forEach((DBtnsArea, AreaIndex) => {
    DBtnsArea.forEach((DBtn) => {


        DBtn.addEventListener('click', function () {

            renderDBtnsToggling(DBtnsArea, this);
            removeABtn(ABtnsAreas[AreaIndex]);
            displaySlots(DBtn, timeslotsAreas[AreaIndex], ABtnsAreas[AreaIndex]);

        });


    });
});






const booking_dataAr = document.getElementById('booking_data');
const customer_name = document.getElementById('customer_name');
const customer_phone = document.getElementById('customer_phone');
const customer_email = document.getElementById('customer_email');
const customer_button = document.getElementById('customer_button');
const customer_back_info = document.getElementById('customer_back_info');


customer_button.addEventListener('click', function () {

    if (customer_name.value == '' && customer_phone.value == '') {
        showErrorCustomer(customer_name);
        showErrorCustomer(customer_phone);
    }
    else if (customer_name.value == '') {
        showErrorCustomer(customer_name);
    } else if (customer_phone.value == '') {
        showErrorCustomer(customer_phone);
    } else {

        

        let info = {
            customer_name:  customer_name.value,
            customer_phone: customer_phone.value,
            customer_email: customer_email.value,
            stuffer: booking_dataAr.dataset.uuidstuf,
            location: booking_dataAr.dataset.uuidloc,
            service: booking_dataAr.dataset.uuidserv,
            datetime: booking_dataAr.dataset.datetime,
        };

        fetch('https://semashko.nnov.ru/patients/bronirovanie1/booking.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Authorizat': 'simpleDefence12052025'
            },
            body: JSON.stringify(info)
        })
            .then(response => {
                return response.text();
            })
            .then(data => {
                console.dir(data);
                customer_button.classList.add('noneRes');
                customer_back_info.classList.remove('noneRes');
                customer_back_info.textContent = data;
            });
    }

});

function showErrorCustomer(input) {
    input.classList.add('customerError');
    setTimeout(() => {
        input.classList.remove('customerError');
    }, "5000");
}
