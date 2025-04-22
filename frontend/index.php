<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("тест-тайм-слоты");
// $this->addExternalCss("./patients/test-timeSlot/style.css");
$APPLICATION->SetAdditionalCSS("https://semashko.nnov.ru/patients/test-timeSlot/style.css", true);
$APPLICATION->AddHeadScript("https://semashko.nnov.ru/patients/test-timeSlot/mainScript.js", true);
?>

<div class="pContainer">

    <div class="headSl">

        <div class="photo">
            <img class="photoImg" src="./imgs/pic2.png" alt="фото врача">
        </div>


        <div class="info">
            <div class="nameSl">Айболит Корней Иванович</div>
            <div class="role">Педиатр</div>
        </div>


    </div>
    <div class="main">
        <div class="dayTitle">
            Выберете день:
        </div>

        <div class="day">
            <!--  -->
            <div class="oneDay">
                <div class="d_o_week">пн</div>
                <div class="date">24.02</div>
            </div>
            <div class="oneDay">
                <div class="d_o_week">вт</div>
                <div class="date">25.02</div>
            </div>
            <div class="oneDay">
                <div class="d_o_week">ср</div>
                <div class="date">26.02</div>
            </div>
            <div class="oneDay">
                <div class="d_o_week">чт</div>
                <div class="date">27.02</div>
            </div>
            <div class="oneDay">
                <div class="d_o_week">пт</div>
                <div class="date">28.02</div>
            </div>
            <div class="oneDay">
                <div class="d_o_week">сб</div>
                <div class="date">01.03</div>
            </div>
            <div class="oneDay">
                <div class="d_o_week">вс</div>
                <div class="date">02.03</div>
            </div>
            <div class="oneDay">
                <div class="d_o_week">пн</div>
                <div class="date">03.03</div>
            </div>
            <div class="oneDay">
                <div class="d_o_week">вт</div>
                <div class="date">04.03</div>
            </div>
            <div class="oneDay">
                <div class="d_o_week">ср</div>
                <div class="date">05.03</div>
            </div>
            <div class="oneDay">
                <div class="d_o_week">чт</div>
                <div class="date">06.03</div>
            </div>
            <div class="oneDay">
                <div class="d_o_week">пт</div>
                <div class="date">07.03</div>
            </div>
        </div>

        <div class="freeTimeTitle">
            Доступное время для записи:
        </div>

        <div class="freeTime">
            <div class="oneTime none">
                <p>9.00</p>

            </div>
            <div class="oneTime none">
                <p>9.20</p>
            </div>
            <div class="oneTime none">
                <p>12.00</p>
            </div>
            <div class="oneTime none">
                <p>12.40</p>

            </div>
            <div class="oneTime none">
                <p>13.00</p>
            </div>
            <div class="oneTime none">
                <p>13.20</p>
            </div>


        </div>

        <div class="okButton none">
            <img src="./imgs/note.png" alt="записаться" width="60px">
            <p>Записаться на приём</p>
        </div>

    </div>
</div>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>