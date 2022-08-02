<?php

header('Content-Type: text/html; charset=utf-8');

$response = array();
require_once 'config/db_connect.php';
$db = new DB_CONNECT();
$con = $db->connect();

require_once 'res/strings.php';

/**
 * @param mysqli $con
 * @param array $response
 * @param $messageOk
 * @param $messageAllNotOk
 * @return void
 */
function getDrugs(mysqli $con, array $response, $messageOk, $messageAllNotOk)
{
    $result1 = mysqli_query($con, "SELECT * FROM drugsbel") or die(mysqli_error($con));
    $result2 = mysqli_query($con, "SELECT * FROM drugsturkey") or die(mysqli_error($con));
    $result3 = mysqli_query($con, "SELECT * FROM drugsusa") or die(mysqli_error($con));
    if (mysqli_num_rows($result1) > 0 || mysqli_num_rows($result2) > 0 || mysqli_num_rows($result3) > 0) {

        list($response, $row, $drug) = extracted($response, $messageOk, $result1);
        while ($row = mysqli_fetch_array($result2)) {
            $drug = array();
            $drug['id'] = intval($row['id']);
            $drug['name'] = $row['name'];
            $drug['composition'] = $row['composition'];
            $drug['country'] = 'Турция';
            $response['drugs'][] = $drug;
        }
        $response = getArr($result3, $drug, $response);

    } else {
        $response['success'] = 0;
        $response['message'] = $messageAllNotOk;

    }
    echo json_encode($response, JSON_UNESCAPED_UNICODE);
}

/**
 * @param array $response
 * @param $messageOk
 * @param mysqli_result $result1
 * @return array
 */
function extracted(array $response, $messageOk, mysqli_result $result1)
{
    $response['success'] = 1;
    $response['message'] = $messageOk;

    $response['drugs'] = array();
    while ($row = mysqli_fetch_array($result1)) {
        $drug = array();
        $drug['id'] = intval($row['id']);
        $drug['name'] = $row['name'];
        $drug['composition'] = $row['composition'];
        $drug['country'] = 'Беларусь';
        $response['drugs'][] = $drug;
    }
    return array($response, $row, $drug);
}

getDrugs($con, $response, $messageOk, $messageAllNotOk);
