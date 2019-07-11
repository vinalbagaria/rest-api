<?php

// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once '../config/database.php';
require_once '../userObjects/getUserDetails.php';
require_once '../MasterData/getMasterData.php';

$instance = ConnectDb::getInstance();
$db = $instance->getConnection();
$userDetails = new GetUserDetails($db);
$data = json_decode(file_get_contents("php://input"));

//DISPLAY ROLES FOR A USER
$userId = $_GET['userId'];
//echo json_encode(array("userId"=> $userId));
//$userRoles = $userDetails->getUserRoles($userId);
//echo json_encode(array("userRoles"=> $userRoles));

if(!empty($userId))
{
    $info = $userDetails->getUserDetails($userId);
//    echo json_encode($info);

    $countryId = $info['countryId'];


    $userCountryDetails = new GetMasterData($db);
    $country = $userCountryDetails->getCountry($countryId);
//    echo json_encode($country) ;
    array_push($info ,$country['country']) ;
    echo json_encode($info);
}

