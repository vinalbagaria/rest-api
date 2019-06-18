<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// get database connection
include_once '../config/database.php';
include_once '../propertyObjects/registerPropertyDetails.php' ;


$database = new Database();
$db = $database->getConnection();

$property = new registerPropertyDetails($db);

$data = json_decode(file_get_contents("php://input"));

if(
    !empty($data->propertyName)&&
    !empty($data->propertyStatus)&&
    !empty($data->propertyType )&&
    !empty($data->reraNo)&&
    !empty($data->configurationType)&&
    !empty($data->userId)&&
    !empty($data->floorNo)&&
    !empty($data->roleType)&&
    //!empty($data->developerId)&&
    !empty($data->floors)&&
    !empty($data->carParking)&&
    !empty($data->furnishedType)&&
    !empty($data->ageOfProperty)&&
    !empty($data->possessionDate)&&
    !empty($data->info)&&
    !empty($data->facing)&&
    !empty($data->noOfBathrooms)&&
    !empty($data->noOfBalconies)
){

    $property->propertyName = $data->propertyName;
    $property->propertyStatus = $data->propertyStatus;
    $property->propertyType = $data->propertyType;
    $property->configurationType = $data->configurationType;
    $property->userId = $data->userId;
    $property->floorNo = $data->floorNo;
    $property->roleType = $data->roleType;
    $property->floors = $data->floors;
    $property->carParking = $data->carParking;
    $property->furnishedType = $data->furnishedType;
    $property->ageOfProperty = $data->ageOfProperty;
    $property->possessionDate = $data->possessionDate;
    $property->info = $data->info;
    $property->facing = $data->facing;
    $property->noOfBathrooms = $data->noOfBathrooms;
    $property->noOfBalconies = $data->noOfBalconies;
    $property->reraNo = $data->reraNo;
  //  $property->developerId=$data->developerId;


    if($property->registerProperty()){

        //set response code 201
        http_response_code(201);

        //tell the user
        echo json_encode(array("message" => "property was inserted."));
    }
    else {

        // set response code - 503 service unavailable
        http_response_code(503);

        // tell the user
        echo json_encode(array("message" => "Unable to add property."));
    }

}
 // tell the user data is incomplete
else{
     // set response code - 400 bad request
     http_response_code(400);

     // tell the user
     echo json_encode(array("message" => "Unable to add property. Data is incomplete."));
}