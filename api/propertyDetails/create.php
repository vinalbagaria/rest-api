<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// get database connection
include_once '../config/database.php';
include_once '../propertyObjects/registerProperty.php' ;

$database = new Database();
$db = $database->getConnection();

$data = json_decode(file_get_contents("php://input"));

if(
    !empty($data->propertyName) &&
    !empty($data->propertyStatus) &&
    !empty($data->propertyType ) &&
    !empty($data->configuration) &&
    !empty( $data->userId) &&
    !empty( $data->floorNo) &&
    !empty($data->roleType) &&
    !empty( $data->floors) &&
    !empty( $data->carParking) &&
    !empty( $data->furnishedType)
){

}