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

function displaySlots(buttonD, slotsArea) {
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

            oneTime_p.innerText = slot.outerText
        });
    };
};

function renderDBtnsToggling(DBtns, thisBtn) {
    DBtns.forEach(i => i.classList.remove('chosen'));
    thisBtn.classList.toggle('chosen');
};



const DBtnsAreas = getDBtnsAreas();
const timeslotsAreas = getTimeslotsAreas();



DBtnsAreas.forEach((DBtnsArea, AreaIndex) => {
    DBtnsArea.forEach((DBtn) => {


        DBtn.addEventListener('click', function () {

            renderDBtnsToggling(DBtnsArea, this);
            displaySlots(DBtn, timeslotsAreas[AreaIndex]);

        });


    });
});