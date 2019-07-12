<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods:POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once '../propertyObjects/updatePropertyDetails.php';
require_once '../config/database.php';

$data = json_decode(file_get_contents("php://input"));

//CHECKING DATA IS EMPTY OR NOT
if(
    !empty($data->propertyName) &&
    !empty($data->propertyStatus) &&
    !empty($data->propertyType) &&
    !empty($data->configurationType) &&
    !empty($data->userId) &&
    !empty($data->floorNo) &&
    !empty($data->roleType) &&
    !empty($data->floors) &&
    !empty($data->carParking) &&
    !empty($data->furnishedType) &&
    !empty($data->amenity) &&
    !empty($data->carpetArea)&&
    !empty($data->baseValue)&&
    !empty($data->unitName) &&
    !empty($data->propertyId) &&
    !empty($data->country) &&
    !empty($data->state) &&
    !empty($data->city) &&
    !empty($data->pincode) &&
    !empty($data->line1) &&
    !empty($data->line2) &&
    !empty($data->latitude) &&
    !empty($data->longitude) &&
    !empty($data->placeId)
){
    $instance = ConnectDb::getInstance();
    $db = $instance->getConnection();

    $update = new UpdatePropertyDetails($db) ;
    $update->propertyName = $data->propertyName ;
    $update->propertyStatus = $data->propertyStatus ;
    $update->propertyType = $data->propertyType ;
    $update->configurationType = $data->configurationType ;
    $update->userId = $data->userId ;
    $update->roleType = $data->roleType ;
    $update->floorNo = $data->floorNo ;
    $update->floors = $data->floors ;
    $update->carParking = $data->carParking ;
    $update->furnishedType = $data->furnishedType ;
    $update->amenity = $data->amenity ;
    $update->carpetArea = $data->carpetArea;
    $update->baseValue = $data->baseValue;
    $update->unitName = $data->unitName;
    $update->propertyId = $data->propertyId ;
    $update->line1 = $data->line1 ;
    $update->line2 = $data->line2 ;
    $update->latitude = $data->latitude ;
    $update->longitude = $data->longitude ;
    $update->placeId = $data->placeId ;
    $update->pincode = $data->pincode ;
    $update->city = $data->city  ;
    $update->state = $data->state ;
    $update->country = $data->country  ;

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
    if(!empty($data->pricePerUnit))
        $update->pricePerUnit = $data->pricePerUnit;
    if(!empty($data->buildUpArea))
        $update->buildUpArea = $data->buildUpArea;
    if(!empty($data->registration))
        $update->registration = $data->registration;
    if(!empty($data->stampDuty))
        $update->stampDuty = $data->stampDuty;
    if(!empty($data->maintenance))
        $update->maintenance = $data->maintenance ;
    if(!empty($data->reraNo))
        $update->reraNo = $data->reraNo;

    if($update->updatePropertyDetails())
    {
        echo json_encode( "Updated property details Successfully ");
    }else
        echo json_encode("property details Unsuccessful ");

    if($update->updatePropertyAmenity())
    {
        echo json_encode( "Updated amenity Successfully ");
    }else
        echo json_encode( "amenity Unsuccessful ");

    if($update->updatePropertyPrice()){
        echo json_encode("Property Price table updated Successfully");
    }else
        echo json_encode("Property Price table not updated Successfully");

    if($update->updatePropertyAddress()){
        echo json_encode( "Address table updated Successfully");
    }else
        echo json_encode( "Address table not updated Successfully");

}else
    echo json_encode( "Incomplete Data");
