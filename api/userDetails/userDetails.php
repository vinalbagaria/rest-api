<?php

// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/database.php';
include_once '../userObjects/getUserDetails.php';

$database = new Database();
$db = $database->getConnection();

$userDetails = new GetUserDetails($db);
$data = json_decode(file_get_contents("php://input"));

//DISPLAY ROLES FOR A USER
$userId = $data->userId;
echo json_encode(array("userId"=> $userId));
$userRoles[] = $userDetails->getUserRoles($userId);
echo json_encode(array("userRoles"=> $userRoles));

