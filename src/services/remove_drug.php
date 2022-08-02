<?php

header('Content-Type: text/html; charset=utf-8');

$response = array();

require_once './src/resources/strings.php';

if (isset($_GET['id']) && isset($_GET['country'])) {

    $id = $_GET['id'];
    $country = $_GET['country'];

    require_once './src/config/db_connect.php';

    $db = new DB_CONNECT();
    $con = $db->connect();

    switch ($country) {
        case 'Беларусь':
            $country = 'drugsbel';
            break;
        case 'США':
            $country = 'drugsusa';
            break;
        case 'Турция':
            $country = 'drugsturkey';
            break;
        default:
            $country = 'drugsbel';
    }

    $sql = "DELETE FROM " . $country . " WHERE id='" . $id . "'";
    $result = mysqli_query($con, $sql) or die(mysqli_error($con));

    if ($result) {
        $response['success'] = 1;
        $response['message'] = $deleted;
    } else {
        $response['success'] = 0;
        $response['message'] = $notDeleted;
    }
} else {
    $response['success'] = 0;
    $response['message'] = $messageNotOk;
}
echo json_encode($response, JSON_UNESCAPED_UNICODE);
