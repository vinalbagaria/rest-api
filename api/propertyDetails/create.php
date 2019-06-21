<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../propertyObjects/registerPropertyDetails.php';
include_once '../config/database.php' ;

$data = json_decode(file_get_contents("php://input"));

//CHECKING DATA IS EMPTY OR NOT
if(
    !empty($data->userId) &&
    !empty($data->country) &&
    !empty($data->state) &&
    !empty($data->city) &&
    !empty($data->pincode) &&
    !empty($data->line1) &&
    !empty($data->line2) &&
    !empty($data->latitude) &&
    !empty($data->longitude) &&
    !empty($data->placeId) &&
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

    !empty($data->carpetArea) &&
    !empty($data->unitName) &&
    !empty($data->baseValue)
){
    $instance = ConnectDb::getInstance();
    $db = $instance->getConnection();

     $register = new RegisterPropertyDetails($db) ;
     $register->propertyName = $data->propertyName ;
     $register->propertyStatus = $data->propertyStatus ;
     $register->propertyType = $data->propertyType ;
     $register->configurationType = $data->configurationType ;
    
     $register->userId = $data->userId ;
     $register->roleType = $data->roleType ;
     $register->floorNo = $data->floorNo ;
     $register->floors = $data->floors ;
     $register->carParking = $data->carParking ;
     $register->furnishedType = $data->furnishedType ;
    $register->userId = $data->userId ;
    $register->country=$data->country;
    $register->state=$data->state;
    $register->city=$data->city;
    $register->pincode=$data->pincode;
    $register->line1=$data->line1;
    $register->line2=$data->line2;
    $register->latitude=$data->latitude;
    $register->longitude=$data->longitude;
    $register->placeId=$data->placeId;
    $register->amenity = $data->amenity;
    if(!empty($data->facing))
        $register->facing = $data->facing ;
    if(!empty($data->ageOfProperty))
        $register->ageOfProperty = $data->ageOfProperty ;
    if(!empty($data->description))
        $register->description= $data->description ;
    if(!empty($data->possessionDate))
        $register->possessionDate = $data->possessionDate ;
    if(!empty($data->noOfBathrooms))
        $register->noOfBathrooms  = $data->noOfBathrooms ;
    if(!empty($data->noOfBalconies))
        $register->noOfBalconies =$data->noOfBalconies ;
    if(!empty($data->reraNo))
    $register->reraNo = $data->reraNo;

    //INSERTING INTO PROPERTY ADDRESS TABLE 
    if($register->addPropertyAddress()){
        echo json_encode(array("address" => "Updated Successfully"));
    }else{
        echo json_encode(array("address" => "Update Unsuccessful"));
    }

    $register->carpetArea = $data->carpetArea ;
    $register->baseValue = $data->baseValue ;
    $register->unitName = $data->unitName ;

    if(!empty($data->pricePerUnit))
        $register->pricePerUnit = $data->pricePerUnit ;
    if(!empty($data->buildUpArea))
        $register->buildUpArea = $data->buildUpArea ;
    if(!empty($data->registration))
        $register->registration = $data->registration ;
    if(!empty($data->stampDuty))
        $register->stampDuty = $data->stampDuty ;
    if(!empty($data->maintenance))
        $register->maintenance = $data->maintenance ;

    //INSERTING INTO PROPERTY DETAILS TABLE
    if($register->registerPropertyDetails())
    {
        echo json_encode(array("message" => "Property Details filled"));
    }
    else
    {
        echo json_encode(array("message" => "property details unsuccessful"));
    }

    if($register->addPropertyAmenity())
    {
        echo json_encode(array("message" => "Added amenities Successfully"));
    }
    else
    {
        //Delete from propertyDetails Table (left)
        echo json_encode(array("message" => "amenities Unsuccessful"));
    }
    if($register->addPropertyPrice())
    {
        echo json_encode(array("message" => "Added property Price Successfully"));
    }
    else
    {
        //Delete from propertyDetails Table (left)
        echo json_encode(array("message" => "property Price Unsuccessful"));
    }
}
else
{
    echo json_encode(array("message" =>"Incomplete Data"));
}
