<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("Платный приём - направления");

$location_uuid = '2d760ee7-a3f9-4930-b984-32cb05ec02ce'; //miac

function req_services($location_uuid)
{
  $curl = curl_init();

  curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://my.easyweek.io/api/public/v2/locations/'. $location_uuid .'/services?category_uuid=5ceebb43-b425-4bdb-964e-e4b6e97e398f',
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


$_services=req_services($location_uuid);

foreach ($_services['data'] as $type) {
  echo '<hr>';
  echo '<a href = ./detailed.php?i=' . $type['uuid'] . '&n=' . $type['name'] . '&d=' . $type['duration']['value'] . '><img width="60" src="' . $type['images'][0] . '" alt="платное направление">' . $type['name'] . '</a>';
  echo '<hr><br>';
}


?>





<?php require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>