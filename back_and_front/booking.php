<?php
$headers = getallheaders();
if ($headers['Authorizat'] === 'simpleDefence12052025') {
    $booking_params = json_decode(file_get_contents('php://input'), true);

    $booking_params['datetime']=substr($booking_params['datetime'], 0, -6).'0Z';



    // if ($booking_params['customer_email']==''){
    //     $booking_params['customer_email']='не указан';
    // } else {

    // }
    // $booking_params['customer_name'];
    // $booking_params['customer_phone'];
    // $booking_params['customer_email'];
    // $booking_params['stuffer'];
    // $booking_params['location'];
    // $booking_params['service'];
    // $booking_params['datetime'];

    // print_r($data['customer_name'].', Вы успешно записались на приём!');

    // $curl = curl_init();

    // curl_setopt_array($curl, array(
    //     CURLOPT_URL => 'https://my.easyweek.io/api/public/v2/bookings?location_uuid=2d760ee7-a3f9-4930-b984-32cb05ec02ce&service_uuid=485da4ef-7633-4bed-bcbe-5905886a49fd&reserved_on=2025-05-19T08%3A25%3A00Z&customer_phone=+7777777&customer_first_name=%D0%90%D0%BB%D0%B5%D0%BA%D1%81%D0%B5%D0%B9&staffer_uuid=c2813612-fc3d-402a-a167-4a0461bf1fe6',
    //     CURLOPT_RETURNTRANSFER => true,
    //     CURLOPT_ENCODING => '',
    //     CURLOPT_MAXREDIRS => 10,
    //     CURLOPT_TIMEOUT => 0,
    //     CURLOPT_FOLLOWLOCATION => true,
    //     CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    //     CURLOPT_CUSTOMREQUEST => 'POST',
    //     CURLOPT_HTTPHEADER => array(
    //         'Workspace: meditsinskiy-informatsionno-analiticheskiy-tsentr',
    //         'Authorization: Bearer secret_S6D6NNlCI9EwabGMcX7p0zRiPDgyJhRQfrDjiTPrmcg'
    //     ),
    // ));

    // $response = curl_exec($curl);

    // curl_close($curl);
    // echo $response;


    print_r($booking_params['datetime']);
    echo '<br>';
    print_r($booking_params['stuffer']);
    echo '<br>';
    print_r($booking_params['service']);
} else {
    if (isset($headers['Authorizat'])) {
        print_r('внутренняя ошибка авторизации');
    } else {
        header('Location: https://semashko.nnov.ru/');
    }
}
