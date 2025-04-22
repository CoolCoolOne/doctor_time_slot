let buttonsD = document.querySelectorAll("div.oneDay");
let buttons = document.querySelectorAll("div.oneTime");
let approveBtn = document.querySelector("div.okButton");

for (let buttonD of buttonsD) {
    buttonD.addEventListener('click', function () {
        buttonsD.forEach(i => i.classList.remove('chosen'));
        buttons.forEach(i => i.classList.remove('chosen'));
        approveBtn.classList.add('none');
        this.classList.toggle('chosen');

        for (let button of buttons) {
            button.classList.remove('none');
        };
    });
};




for (let button of buttons) {
    button.addEventListener('click', function () {
        buttons.forEach(i => i.classList.remove('chosen'));

        this.classList.toggle('chosen');
        approveBtn.classList.remove('none');
    });
};


approveBtn.addEventListener('click', function () {
    console.log('запись на приём');
});