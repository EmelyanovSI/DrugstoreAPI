<?php

header('Content-Type: text/html; charset=utf-8');

$response = array();

require_once './app/resources/strings.php';

if (isset($_GET['table_name'])) {

    require_once './app/config/db_connect.php';
    $db = new DB_CONNECT();
    $con = $db->connect();

    switch ($_GET['table_name']) {
        case 'all':
        {
            getDrugs($con, $response, $messageAllOk, $messageAllNotOk);
            break;
        }
        case 'drugsbel':
        {
            $result1 = mysqli_query($con, "SELECT * FROM drugsbel") or die(mysqil_error($con));
            if (mysqli_num_rows($result1) > 0) {
                list($response, $row, $drug) = extracted($response, $messageDrugsBelOk, $result1);
            } else {
                $response['success'] = 0;
                $response['message'] = $messageDrugsBelNotOk;
            }
            echo json_encode($response, JSON_UNESCAPED_UNICODE);
            break;
        }
        case 'drugsturkey':
        {
            $result2 = mysqli_query($con, "SELECT * FROM drugsturkey") or die(mysqli_error($con));
            if (mysqli_num_rows($result2) > 0) {
                $response['success'] = 1;
                $response['message'] = $messageDrugsTurkeyOk;
                $response['drugs'] = array();
                while ($row = mysqli_fetch_array($result2)) {
                    $drug = array();
                    $drug['id'] = intval($row['id']);
                    $drug['name'] = $row['name'];
                    $drug['composition'] = $row['composition'];
                    $drug['country'] = 'Турция';
                    $response['drugs'][] = $drug;
                }
            } else {
                $response['success'] = 0;
                $response['message'] = $messageDrugsTurkeyNotOk;
            }
            echo json_encode($response, JSON_UNESCAPED_UNICODE);
            break;
        }
        case 'drugsusa':
        {
            $result3 = mysqli_query($con, "SELECT * FROM drugsusa") or die(mysqli_error($con));
            if (mysqli_num_rows($result3) > 0) {
                $response['success'] = 1;
                $response['message'] = $messageDrugsUsaOk;
                $response['drugs'] = array();
                $response = getArr($result3, $drug, $response);
            } else {
                $response['success'] = 0;
                $response['message'] = $messageDrugsUsaNotOk;
            }
            echo json_encode($response, JSON_UNESCAPED_UNICODE);
            break;
        }
        default:
        {
            $response['success'] = 0;
            $response['message'] = $messageTableNotOk;
            echo json_encode($response, JSON_UNESCAPED_UNICODE);
        }
    }
} else {
    $response['success'] = 0;
    $response['message'] = $messageNotOk;
    echo json_encode($response, JSON_UNESCAPED_UNICODE);
}
