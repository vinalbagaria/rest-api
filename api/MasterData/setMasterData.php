<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once 'updateMasterData.php';
include '../config/database.php';

$database = new Database();
$db = $database->getConnection();

$setMaster = new UpdateMasterData($db);
$data = json_decode(file_get_contents("php://input"));

if(
    !empty($data->state) &&
    !empty($data->countryId)
){
    if($setMaster->updateState($data->state,$data->countryId))
        echo json_encode("State updated successfully");
    else
        echo json_encode("Update Unsuccessful");

}

if(
    !empty($data->roleType)
){
    if($setMaster->userRole($data->roleType))
        echo json_encode("State updated successfully");
    else
        echo json_encode("Update Unsuccessful");
}