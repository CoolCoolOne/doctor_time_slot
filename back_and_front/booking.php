<?php
$headers = getallheaders();
if ($headers['Authorizat'] === 'simpleDefence12052025') {
    $booking_params = json_decode(file_get_contents('php://input'), true);



    $booking_params['datetime'] = substr($booking_params['datetime'], 0, -6) . '0Z';
    $hours= substr($booking_params['datetime'], 11, -7);
    $hours = $hours-3;
    if (strlen($hours)==1){
        $hours = '0' . $hours;
    }
    $booking_params['datetime'] = substr($booking_params['datetime'], 0, -9) . $hours . substr($booking_params['datetime'], -7);


    

    if ($booking_params['customer_email'] == '') {
        $booking_params['customer_email'] = 'не_указан';
    } else {
        $booking_params['customer_email'] = str_replace(" ", "_", $booking_params['customer_email']);
    }

    $booking_params['customer_phone'] = str_replace(" ", "_", $booking_params['customer_phone']);

    $usr_customer_name = $booking_params['customer_name'];
    $booking_params['customer_name'] = str_replace(" ", "_", $booking_params['customer_name']);


    $url = 'https://my.easyweek.io/api/public/v2/bookings?' .
        'location_uuid=' . $booking_params['location'] . '&' .
        'service_uuid=' . $booking_params['service'] . '&' .
        'reserved_on=' . $booking_params['datetime'] . '&' .
        'customer_phone=' . $booking_params['customer_phone'] . '&' .
        'customer_first_name=' . $booking_params['customer_name'] . '&' .
        'staffer_uuid=' . $booking_params['stuffer'];


    $curl = curl_init();



    curl_setopt_array($curl, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_HTTPHEADER => array(
            'Workspace: meditsinskiy-informatsionno-analiticheskiy-tsentr',
            'Authorization: Bearer secret_S6D6NNlCI9EwabGMcX7p0zRiPDgyJhRQfrDjiTPrmcg'
        ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);

    $responseObj = json_decode($response);

    if (isset($responseObj->uuid)) {
        print_r('good');
    } else if ($responseObj->errors->booking[0] == 'validation.booking.spot_booked') {
        print_r('spot_booked');
    } else {
        print_r('error');
    }
} else {
    if (isset($headers['Authorizat'])) {
        print_r('внутренняя ошибка авторизации');
    } else {
        header('Location: https://semashko.nnov.ru/');
    }
}
