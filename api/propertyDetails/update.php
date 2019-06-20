<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods:PUT");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once '../propertyObjects/updatePropertyDetails.php';
require_once '../config/database.php' ;

$data = json_decode(file_get_contents("php://input"));

//CHECKING DATA IS EMPTY OR NOT
if(
    !empty($data->propertyName) &&
    !empty($data->propertyStatus) &&
    !empty($data->propertyType) &&
    !empty($data->configurationType) &&
    !empty( $data->userId) &&
    !empty($data->floorNo) &&
    !empty($data->roleType) &&
    !empty( $data->floors) &&
    !empty($data->carParking) &&
    !empty( $data->furnishedType) &&
    !empty($data->facing) &&
    !empty($data->ageOfProperty) &&
    !empty($data->description) &&
    !empty($data->possessionDate) &&
    !empty($data->noOfBathrooms) &&
    !empty($data->noOfBalconies) &&
    !empty($data->reraNo)
){
    $instance = ConnectDb::getInstance();
    $db = $instance->getConnection();
    
    $update = new UpdatePropertyDetails($db) ;
    $update->propertyName = $data->propertyName ;
    $update->propertyStatus = $data->propertyStatus ;
    $update->propertyType = $data->propertyType ;
    $update->configurationType = $data->configurationType ;
    $update->reraNo = $data->reraNo;
    $update->userId = $data->userId ;
    $update->roleType = $data->roleType ;
    $update->floorNo = $data->floorNo ;
    $update->floors = $data->floors ;
    $update->carParking = $data->carParking ;
    $update->furnishedType = $data->furnishedType ;
    if(!empty($data->facing))
        $update->facing = $data->facing ;
    if(!empty($data->ageOfProperty))
        $update->ageOfProperty = $data->ageOfProperty ;
    if(!empty($data->description))
        $update->description= $data->description ;
    if(!empty($data->possessionDate))
        $update->possessionDate = $data->possessionDate ;
    if(!empty($data->noOfBathrooms))
        $update->noOfBathrooms  = $data->noOfBathrooms ;
    if(!empty($data->noOfBalconies))
        $update->noOfBalconies =$data->noOfBalconies ;

    if($update->updatePropertyDetails())
    {
        echo json_encode("Updated Successfully");
    }
    else
        echo json_encode("Update Unsuccessful");
}else
{
    echo json_encode("Incomplete Data");
}