<?php
$headers = getallheaders();
if ($headers['Authorizat'] === 'simpleDefence12052025') {
    $data = json_decode(file_get_contents('php://input'), true);
    print_r($data['customer_name'].', Вы успешно записались на приём!');
} else {
    if (isset($headers['Authorizat'])) {
        print_r('внутренняя ошибка авторизации');
    } else {
        header('Location: https://semashko.nnov.ru/');
    }
}
