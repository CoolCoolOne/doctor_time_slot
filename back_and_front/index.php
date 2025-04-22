<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("Запись на платный приём");

$serv_uuid = $_GET['uuid'];
$serv_name = $_GET['name'];


?>

<?php


function req_stuffers()
{
    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://my.easyweek.io/api/public/v2/locations/2d760ee7-a3f9-4930-b984-32cb05ec02ce/staffers/',
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

function req_timeslots($serv_id, $stuffer_id, $range_start, $range_end)
{
    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://my.easyweek.io/api/public/v2/locations/2d760ee7-a3f9-4930-b984-32cb05ec02ce/time-slots/?service_uuid=' . $serv_id . '&staffer_uuid=' . $stuffer_id . '&range_start='.$range_start.'&range_end='.$range_end,
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

function parse_timeslots($timeslots_info)
{
    
    foreach ($timeslots_info as $timeslots) {
        print_r($timeslots['date']);
        echo ' принимает с ';
        print_r($timeslots['intervals'][0]['start']);
        echo ' по ';
        print_r($timeslots['intervals'][0]['end']);
        echo '<br>';

        echo '<div class="oneTime none">
                <p>9.20</p>
            </div>';
    }
}

$today = date('Y-m-d');
$week_after = date("Y-m-d", strtotime("+7 days"));

//parse stuffers
$all_stuffers = req_stuffers();
foreach ($all_stuffers['data'] as $stuffer) {
    if ($stuffer['position'] === $serv_name) {
        echo '<hr>';
        echo  '<img width="80" src="' . $stuffer['avatar'] . '" alt="врач_фото">' . ' ';
        echo  $stuffer['first_name'] . ' ';
        echo  $stuffer['last_name'];
        echo '<br>';



        $timeslots_info = req_timeslots($serv_uuid, $stuffer['uuid'], $today, $week_after);
        parse_timeslots($timeslots_info['dates']);

        echo '<hr><br>';
    }
}



?>

<?php

?>


<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>