<?php
header('Content-Type: text/html; charset=utf-8');
$response = array();
$response["success"] = 1;
$response["message"] = "WELCOME";
echo json_encode($response, JSON_UNESCAPED_UNICODE);
