<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("Запись на платный приём");

$dir = $APPLICATION->GetCurDir();
$APPLICATION->SetAdditionalCSS($dir . "resources/style.css", true);
$APPLICATION->AddHeadScript($dir . "resources/mainScript.js", true);
$servises_page = $dir . "index.php";
if (!((isset($_GET['i'])) and (isset($_GET['n'])) and (isset($_GET['d'])))) {
    header('Location: ' . $servises_page);
    exit();
};


$location_uuid = '2d760ee7-a3f9-4930-b984-32cb05ec02ce'; //miac
$serv_uuid = $_GET['i'];
$serv_name = $_GET['n'];
$slot_length = $_GET['d'] * 60; //только 15 минут пока что, что не ставь всегда 15 минут
$today = date('Y-m-d');
$week_after = date("Y-m-d", strtotime("+7 days"));
?>

<?php

function secToArray($secs)
{
    $res = array();
    $res['hours'] = floor($secs / 3600);
    $secs = $secs % 3600;
    $res['minutes'] = floor($secs / 60);

    //for case 12.0 (converts to 12.00)
    if (iconv_strlen($res['minutes']) === 1) {
        $res['minutes'] = $res['minutes'] . '0';
    }


    return $res;
}
function req_stuffers($location_uuid)
{
    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://my.easyweek.io/api/public/v2/locations/' . $location_uuid . '/staffers/',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
            'Workspace: meditsinskiy-informatsionno-analiticheskiy-tsentr',
            'Authorization: Bearer secret_S6D6NNlCI9EwabGMcX7p0zRiPDgyJhRQfrDjiTPrmcg'
        ),
    ));

    $response = curl_exec($curl);



    curl_close($curl);

    $response = json_decode($response, true);

    return $response;
}
function req_timeslots($location_uuid, $serv_id, $stuffer_id, $range_start, $range_end)
{
    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://my.easyweek.io/api/public/v2/locations/' . $location_uuid . '/time-slots/?service_uuid=' . $serv_id . '&staffer_uuid=' . $stuffer_id . '&range_start=' . $range_start . '&range_end=' . $range_end,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
            'Workspace: meditsinskiy-informatsionno-analiticheskiy-tsentr',
            'Authorization: Bearer secret_S6D6NNlCI9EwabGMcX7p0zRiPDgyJhRQfrDjiTPrmcg'
        ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);
    $response = json_decode($response, true);


    return $response;
}
function det_weekday($timeslots_date)
{
    $time = strtotime($timeslots_date);
    $date = date('w', $time);
    switch ($date) {
        case 0:
            $weekday = 'вс';
            break;
        case 1:
            $weekday = 'пн';
            break;
        case 2:
            $weekday = 'вт';
            break;
        case 3:
            $weekday = 'ср';
            break;
        case 4:
            $weekday = 'чт';
            break;
        case 5:
            $weekday = 'пт';
            break;
        case 6:
            $weekday = 'сб';
            break;
    }
    return $weekday;
}
function get_date_formatted($timeslots_date)
{
    $day = mb_substr($timeslots_date, 8);
    $month = mb_substr($timeslots_date, 5, -3);
    $date_formatted = $day . '.' . $month;
    return $date_formatted;
}


function parse_timeslots_time($intervals, $slot_length, $slots)
{
    

    echo '<div class="none">';
    foreach ($slots as $slot) {

        
            $start_slot = $slot['start_formatted'];
            $start_slotArr = secToArray($start_slot);
            echo '<p data-time=' . $start_slot . '>';
            echo $start_slotArr['hours'] . ':' . $start_slotArr['minutes'];
            echo '</p>';
        
    }
    echo '</div>';

    
}
function parse_timeslots_day($timeslots_info, $slot_length)
{
    if (!$timeslots_info) {
        echo '<b class="no_content">Нет свободных дат</b>';
    } else {
        foreach ($timeslots_info as $timeslots) {
            $d_o_week = det_weekday($timeslots['date']);
            $date_formatted = get_date_formatted($timeslots['date']);


            echo '<div class="oneDay">
            <div class="d_o_week">' . $d_o_week . '</div>
            <div class="date"  data-day=' . $timeslots['date'] . '> ' . $date_formatted;


            parse_timeslots_time($timeslots['intervals'], $slot_length, $timeslots['slots']);

            echo '</div></div>';
        }
    }
}
?>



<h1><a href="<?= $servises_page ?>"><- К выбору направления</a></h1>

<br>
<?php



//parse stuffers
$all_stuffers = req_stuffers($location_uuid);
foreach ($all_stuffers['data'] as $stuffer) {
    if ($stuffer['position'] === $serv_name) {

?>
        <div class="pContainer" id="stuffer" data-uuidStuf=<?= $stuffer['uuid'] ?> data-uuidLoc=<?= $location_uuid ?> data-uuidServ=<?= $serv_uuid ?>>
            <div class="headSl">
                <div class="photo">
                    <img width="120" class="photoImg" src="<?= $stuffer['avatar'] ?>" alt="врач_фото">
                </div>
                <div class="info">
                    <div class="nameSl"><?= $stuffer['first_name'] ?> <?= $stuffer['last_name'] ?></div>
                    <div class="role"><?= $serv_name ?>. <?= $stuffer['description'] ?> </div>
                </div>
            </div>
            <div class="main">
                <div class="dayTitle">
                    Выберете день:
                </div>
                <div class="days">
                    <?php
                    $timeslots_info = req_timeslots($location_uuid, $serv_uuid, $stuffer['uuid'], $today, $week_after);


                    parse_timeslots_day($timeslots_info['dates'], $slot_length);


                    ?>
                </div>
                <div class="freeTimeTitle">
                    Доступное время для записи:
                </div>
                <div class="freeTime">
                </div>
                <div class="approveBtnArea">
                </div>
            </div>

        </div>

<?php
    }
}
?>



<div class="popup__bg">
    <form class="popup">
        <svg class="close-popup" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
            <path fill="#2c435b" d="M23.954 21.03l-9.184-9.095 9.092-9.174-2.832-2.807-9.09 9.179-9.176-9.088-2.81 2.81 9.186 9.105-9.095 9.184 2.81 2.81 9.112-9.192 9.18 9.1z" />
        </svg>

        <div class="popup_info" id="booking_data">

        </div>
        <label>
            <input type="" name="name" id="customer_name">
            <div class="label__text">
                Ваше имя*
            </div>
        </label>
        <label>
            <input type="tel" name="tel" id="customer_phone">
            <div class="label__text">
                Ваш телефон*
            </div>
        </label>
        <label>
            <input type="" name="name" id="customer_email">
            <div class="label__text">
                Электронная почта
            </div>
        </label>

        <div class="button" id="customer_button">Подтвердить запись</div>
        <div class="back_info noneRes" id="customer_back_info"></div>
        <div class="back_info noneRes" id="customer_back_load"></div>
        <div class="rights">Подтверждая запись Вы соглашаетесь с <a target="_blank" href="https://semashko.nnov.ru/upload/2024/politika_obraborki_pers_dan.pdf">политикой обработки персональных данных</a></div>
        <div class="rules">* - обязательное поле</div>
    </form>
</div>




<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>