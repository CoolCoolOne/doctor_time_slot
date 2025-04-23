let first_stuffer_days = document.querySelector("div.days");
let buttonsD = first_stuffer_days.querySelectorAll("div.oneDay");

let timeslots_area = document.querySelector("div.freeTime");
// let buttons = document.querySelectorAll("div.oneTime");
// let approveBtn = document.querySelector("div.okButton");


for (let buttonD of buttonsD) {
    buttonD.addEventListener('click', function () {
        buttonsD.forEach(i => i.classList.remove('chosen'));
        this.classList.toggle('chosen');
        let slots = (buttonD.querySelector("div.date").querySelector("div.none").childNodes);
        while (timeslots_area.firstChild) {
            timeslots_area.removeChild(timeslots_area.firstChild);
        }


        slots.forEach((slot) => {
            oneTime = document.createElement("div");
            oneTime.classList.add('oneTime');
            oneTime_p = document.createElement("p");

            timeslots_area.appendChild(oneTime);
            oneTime.appendChild(oneTime_p);

            oneTime_p.innerText = slot.outerText
            // console.log(slot.outerText);
            // console.log(oneTime_p);
        });

    });
};





// for (let buttonD of buttonsD) {
//     buttonD.addEventListener('click', function () {
//         buttonsD.forEach(i => i.classList.remove('chosen'));
//         buttons.forEach(i => i.classList.remove('chosen'));
//         // approveBtn.classList.add('none');
//         this.classList.toggle('chosen');

//         for (let button of buttons) {
//             button.classList.remove('none');
//         };
//     });
// };




// for (let button of buttons) {
//     button.addEventListener('click', function () {
//         buttons.forEach(i => i.classList.remove('chosen'));

//         this.classList.toggle('chosen');
//         approveBtn.classList.remove('none');
//     });
// };


// approveBtn.addEventListener('click', function () {
//     console.log('запись на приём');
// });