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
    removeSlots(slotsArea);
    renderSlots(slots, slotsArea);

    function removeSlots(slotsArea) {
        while (slotsArea.firstChild) {
            slotsArea.removeChild(slotsArea.firstChild);
        }
    };

    function renderSlots(slots, slotsArea) {
        slots.forEach((slot) => {
            oneTime = document.createElement("div");
            oneTime.classList.add('oneTime');
            oneTime_p = document.createElement("p");

            slotsArea.appendChild(oneTime);
            oneTime.appendChild(oneTime_p);

            oneTime_p.innerText = slot.outerText;

            addListenerToTimeBtn(oneTime, ABtnsArea, slots);
        });
    };

    function addListenerToTimeBtn(timeBtn, ABtnsArea, slots) {
        timeBtn.addEventListener('click', function () {
            removeABtns(ABtnsArea);
            renderABtns(ABtnsArea);




            let childrens = this.parentNode.childNodes;

            for (var i = 0; i < childrens.length; ++i) {
                childrens[i].classList.remove('chosen');
            }
            this.classList.add('chosen');

            function removeABtns(ABtnsArea) {
                while (ABtnsArea.firstChild) {
                    ABtnsArea.removeChild(ABtnsArea.firstChild);
                }
            };

            function renderABtns(ABtnsArea) {

                okButton = document.createElement("div");
                okButton.classList.add('okButton');
                okButton_p = document.createElement("p");
                okButton_img = document.createElement("img");



                ABtnsArea.appendChild(okButton);
                okButton.appendChild(okButton_img);
                okButton.appendChild(okButton_p);

                okButton_img.src = './resources/imgs/note.png';
                okButton_img.width = '60';
                okButton_p.innerText = 'Записаться на приём';

            };


        });
    };
};

function displayABtn(ABtnsArea) {
    removeABtns(ABtnsArea);
    renderABtns(ABtnsArea);

    function removeABtns(ABtnsArea) {
        while (ABtnsArea.firstChild) {
            ABtnsArea.removeChild(ABtnsArea.firstChild);
        }
    };

    function renderABtns(ABtnsArea) {

        okButton = document.createElement("div");
        okButton.classList.add('okButton');
        okButton_p = document.createElement("p");
        okButton_img = document.createElement("img");



        ABtnsArea.appendChild(okButton);
        okButton.appendChild(okButton_img);
        okButton.appendChild(okButton_p);

        okButton_img.src = './resources/imgs/note.png';
        okButton_img.width = '60';
        okButton_p.innerText = 'Записаться на приём';

    };
};

function renderDBtnsToggling(DBtns, thisBtn) {
    DBtns.forEach(i => i.classList.remove('chosen'));
    thisBtn.classList.toggle('chosen');
};



const DBtnsAreas = getDBtnsAreas();
const timeslotsAreas = getTimeslotsAreas();
const ABtnsAreas = getABtnsAreas();



DBtnsAreas.forEach((DBtnsArea, AreaIndex) => {
    DBtnsArea.forEach((DBtn) => {


        DBtn.addEventListener('click', function () {

            renderDBtnsToggling(DBtnsArea, this);
            displaySlots(DBtn, timeslotsAreas[AreaIndex], ABtnsAreas[AreaIndex]);

            // displayABtn(ABtnsAreas[AreaIndex]);

        });


    });
});