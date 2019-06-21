<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../propertyObjects/registerPropertyDetails.php';
include_once '../config/database.php' ;
$instance = ConnectDb::getInstance();
$db = $instance->getConnection();
$property = new registerPropertyDetails($db);

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
    !empty($data->placeId)
){
    $register = new RegisterPropertyDetails($db) ;
    // $register->propertyName = $data->propertyName ;
    // $register->propertyStatus = $data->propertyStatus ;
    // $register->propertyType = $data->propertyType ;
    // $register->configurationType = $data->configurationType ;
    // $register->reraNo = $data->reraNo;
    // $register->userId = $data->userId ;
    // $register->roleType = $data->roleType ;
    // $register->floorNo = $data->floorNo ;
    // $register->floors = $data->floors ;
    // $register->carParking = $data->carParking ;
    // $register->furnishedType = $data->furnishedType ;
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
    
    // $register->amenity = $data->amenity;
    // if(!empty($data->facing))
    //     $register->facing = $data->facing ;
    // if(!empty($data->ageOfProperty))
    //     $register->ageOfProperty = $data->ageOfProperty ;
    // if(!empty($data->description))
    //     $register->description= $data->description ;
    // if(!empty($data->possessionDate))
    //     $register->possessionDate = $data->possessionDate ;
    // if(!empty($data->noOfBathrooms))
    //     $register->noOfBathrooms  = $data->noOfBathrooms ;
    // if(!empty($data->noOfBalconies))
    //     $register->noOfBalconies =$data->noOfBalconies ;

    //INSERTING INTO PROPERTY ADDRESS TABLE 
    if($register->addPropertyAddress()){
        echo json_encode(array("address" => "Updated Successfully"));
    }else{
        echo json_encode(array("address" => "Update Unsuccessful"));
    }

    // if($register->registerPropertyDetails())
    // {
    //     echo json_encode(array("message" => "Updated Successfully"));
    // }
    // else
    // {
    //     echo json_encode(array("message" => "Update Unsuccessful"));
    // }


    // if($register->addPropertyAmenity())
    // {
    //     echo json_encode(array("message" => "Updated Successfully"));
    // }
    // else
    // {
    //     echo json_encode(array("message" => "Update Unsuccessful"));
    // }
}
else
{
    echo json_encode(array("message" =>"Incomplete Data"));
}
