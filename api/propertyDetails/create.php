<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

<<<<<<< HEAD
// get database connection
include_once '../config/database.php';
include_once '../propertyObjects/registerPropertyDetails.php' ;


=======
include_once '../propertyObjects/registerPropertyDetails.php';
include_once '../config/database.php' ;
>>>>>>> 7929ef6c44109dd5f347a53024d4b06e1e5e1152
$database = new Database();
$db = $database->getConnection();

$property = new registerPropertyDetails($db);

$data = json_decode(file_get_contents("php://input"));

//CHECKING DATA IS EMPTY OR NOT
if(
<<<<<<< HEAD
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
=======
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
>>>>>>> 7929ef6c44109dd5f347a53024d4b06e1e5e1152
){
    $register = new RegisterPropertyDetails($db) ;
    $register->propertyName = $data->propertyName ;
    $register->propertyStatus = $data->propertyStatus ;
    $register->propertyType = $data->propertyType ;
    $register->configurationType = $data->configurationType ;
    $register->reraNo = $data->reraNo;
    $register->userId = $data->userId ;
    $register->roleType = $data->roleType ;
    $register->floorNo = $data->floorNo ;
    $register->floors = $data->floors ;
    $register->carParking = $data->carParking ;
    $register->furnishedType = $data->furnishedType ;
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

<<<<<<< HEAD
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
=======
    if($register->registerPropertyDetails())
    {
        echo json_encode(array("message" => "Updated Successfully"));
    }
    else
        echo json_encode(array("message" => "Update Unsuccessful"));
}else
{
    echo json_encode(array("message" =>"Incomplete Data"));
>>>>>>> 7929ef6c44109dd5f347a53024d4b06e1e5e1152
}