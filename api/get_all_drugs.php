<?php

header('Content-Type: text/html; charset=utf-8');

$response = array();
require_once 'db_connect.php';
$db = new DB_CONNECT();
$con = $db->connect();

require_once 'strings.php';

$result1 = mysqli_query($con, "SELECT * FROM drugsbel") or die(mysqli_error($con));
$result2 = mysqli_query($con, "SELECT * FROM drugsturkey") or die(mysqli_error($con));
$result3 = mysqli_query($con, "SELECT * FROM drugsusa") or die(mysqli_error($con));
if (mysqli_num_rows($result1) > 0 || mysqli_num_rows($result2) > 0 || mysqli_num_rows($result3) > 0) {

	$response["success"] = "1";
	$response["message"] = $messageOk;

	$response["drugs"] = array();
    while ($row = mysqli_fetch_array($result1)) {
        $drug = array();
        $drug["id"] = $row["id"];
        $drug["name"] = $row["name"];
        $drug["composition"] = $row["composition"];
        $drug["country"] = "Беларусь";
        array_push($response["drugs"], $drug);
    }
    while ($row = mysqli_fetch_array($result2)) {
        $drug = array();
        $drug["id"] = $row["id"];
        $drug["name"] = $row["name"];
        $drug["composition"] = $row["composition"];
		$drug["country"] = "Турция";
        array_push($response["drugs"], $drug);
    }
    while ($row = mysqli_fetch_array($result3)) {
        $drug = array();
        $drug["id"] = $row["id"];
        $drug["name"] = $row["name"];
        $drug["composition"] = $row["composition"];
		$drug["country"] = "США";
        array_push($response["drugs"], $drug);
    }

    echo json_encode($response, JSON_UNESCAPED_UNICODE);
} else {
    $response["success"] = "0";
    $response["message"] = $messageAllNotOk;

    echo json_encode($response, JSON_UNESCAPED_UNICODE);
}
