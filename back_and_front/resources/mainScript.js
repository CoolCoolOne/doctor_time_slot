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


                while (popup_info.firstChild) {
                    popup_info.removeChild(popup_info.firstChild);
                }

                info1 = document.createElement("p");
                info1.innerText = okButton.dataset.time;
                info2 = document.createElement("p");
                info2.innerText = okButton.dataset.day;
                info3 = document.createElement("p");
                info3.innerText = okButton.parentNode.parentNode.parentNode.dataset.uuidstuf;
                info4 = document.createElement("p");
                info4.innerText = okButton.parentNode.parentNode.parentNode.dataset.uuidloc;
                info5 = document.createElement("p");
                info5.innerText = okButton.parentNode.parentNode.parentNode.dataset.uuidserv;


                popup_info.appendChild(info1);
                popup_info.appendChild(info2);
                popup_info.appendChild(info3);
                popup_info.appendChild(info4);
                popup_info.appendChild(info5);

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


