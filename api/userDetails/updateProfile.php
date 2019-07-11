<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: PUT");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once '../config/database.php';
require_once '../userObjects/updateProfile.php';

$data = json_decode(file_get_contents("php://input"));

if(
    !empty($data->userId) &&
    !empty($data->firstName)&&
    !empty($data->lastName)
){
    $instance = ConnectDb::getInstance();
    $db = $instance->getConnection();
    $updateProfile = new UpdateProfile($db);
    if($updateProfile->changeFirstName($data->userId,$data->firstName) && $updateProfile->changeLastName($data->userId , $data->lastName))
        echo json_encode("Update Successful");
    else
        echo json_encode("Update Unsuccessful");
}

if(
    !empty($data->userId) &&
    !empty($data->contactNo)
){
    //    Verify otp
    if($updateProfile->changeContactNo($data->userId,$data->contactNo))
        echo json_encode($data->contactNo);
    else
        echo json_encode("Update Unsuccessful");
}
if(
    !empty($data->userId)  &&
    !empty($data->emailId)
){
    //    Verify otp
    if($updateProfile->changeEmailId($data->userId,$data->emailId))
        echo json_encode($data->emailId);
    else
        echo json_encode("Update Unsuccessful");
}
if(
    !empty($data->userAddressId) &&
    !empty($data->line1) &&
    !empty($data->line2) &&
    !empty($data->latitude) &&
    !empty($data->longitude) &&
    !empty($data->placeId)
){
    if( $updateProfile->changeAddress($data->userAddressId,$data->line1,$data->line2,$data->latitude,$data->longitude,$data->placeId ))
        echo json_encode("Update Successful");
    else
        echo json_encode("Update Unsuccessful");
}
if(
    !empty($data->pincode) &&
    !empty($data->userAddressId) &&
    !empty($data->city) &&
    !empty($data->state) &&
    !empty($data->country) &&
    !empty($data->userId) &&
    !empty($data->userAddressId)
){
    if( $updateProfile->changeCountryId($data->userId,$data->country) && $updateProfile->changePincodeId($data->userAddressId,$data->pincode,$data->city,$data->state,$data->country))
        echo json_encode("Update Successful");
    else
        echo json_encode("Update Unsuccessful");
}

