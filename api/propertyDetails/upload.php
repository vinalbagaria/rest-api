<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once '../propertyObjects/getPropertyDetails.php';
require_once '../config/database.php' ;
$instance = ConnectDb::getInstance();
$db = $instance->getConnection();

$propertyDetails = new GetPropertyDetails($db);


$data = json_decode(file_get_contents("php://input"));

// //CHECKING DATA IS EMPTY OR NOT
// if(
//     !empty($data->propertyName) &&
//     !empty($data->propertyStatus) &&
//     !empty($data->propertyType) &&
//     !empty($data->configurationType) &&
//     !empty( $data->userId) &&
//     !empty($data->floorNo) &&
//     !empty($data->roleType) &&
//     !empty( $data->floors) &&
//     !empty($data->carParking) &&
//     !empty( $data->furnishedType) &&
//     !empty($data->facing) &&
//     !empty($data->ageOfProperty) &&
//     !empty($data->description) &&
//     !empty($data->possessionDate) &&
//     !empty($data->noOfBathrooms) &&
//     !empty($data->noOfBalconies) &&
//     !empty($data->reraNo)
// ){
//     $register = new RegisterPropertyDetails($db) ;
//     $register->propertyName = $data->propertyName ;
//     $register->propertyStatus = $data->propertyStatus ;
//     $register->propertyType = $data->propertyType ;
//     $register->configurationType = $data->configurationType ;
//     $register->reraNo = $data->reraNo;
//     $register->userId = $data->userId ;
//     $register->roleType = $data->roleType ;
//     $register->floorNo = $data->floorNo ;
//     $register->floors = $data->floors ;
//     $register->carParking = $data->carParking ;
//     $register->furnishedType = $data->furnishedType ;
    
//     if(!empty($data->facing))
//         $register->facing = $data->facing ;
//     if(!empty($data->ageOfProperty))
//         $register->ageOfProperty = $data->ageOfProperty ;
//     if(!empty($data->description))
//         $register->description= $data->description ;
//     if(!empty($data->possessionDate))
//         $register->possessionDate = $data->possessionDate ;
//     if(!empty($data->noOfBathrooms))
//         $register->noOfBathrooms  = $data->noOfBathrooms ;
//     if(!empty($data->noOfBalconies))
//         $register->noOfBalconies =$data->noOfBalconies ;

//     //INSERTING INTO USER ROLE TABLE
//     if($register->registerPropertyDetails())
//     {
//         echo json_encode(array("message" => "Updated Successfully"));
//     }
//     else
//         echo json_encode(array("message" => "Update Unsuccessful"));
// }else
// {
//     echo json_encode(array("message" =>"Incomplete Data"));
// }

if(is_uploaded_file($_FILES["property_document"]["tmp_name"]  && @$_POST["userId"]))
{
    $tmp_file = $_FILES["property_document"]["tmp_name"] ;
    $documentName = $_FILES["property_document"]["name"];
    $upload_dir = "uploads/".$documentName;
    $userId = $_POST["userId"] ;

    $propertyDetails->getPropertyId()
    $query = "INSERT INTO doucments ";
}