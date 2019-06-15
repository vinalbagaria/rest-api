<?php

// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// get database connection
include_once '../config/database.php';

// instantiate product object
include_once '../userObjects/register.php';

$database = new Database();
$db = $database->getConnection();

$user = new Register($db);

// get posted data
$data = json_decode(file_get_contents("php://input"));

// make sure data is not empty
if (
    !empty($data->firstName) &&
    !empty($data->lastName) &&
    !empty($data->contactNo) &&
    !empty($data->emailId) &&

    !empty($data->country) &&
    !empty($data->state) &&
    !empty($data->city) &&
    !empty($data->pincode) &&
    !empty($data->line1) &&
    !empty($data->line2) &&
    !empty($data->latitude) &&
    !empty($data->longitude) &&
    !empty($data->placeId) &&

    !empty($data->password)
) {

    // set product property values
    $user->firstName = $data->firstName;
    $user->lastName=$data->lastName;
    $user->contactNo=$data->contactNo;
    $user->emailId=$data->emailId;

    $user->country=$data->country;
    $user->state=$data->state;
    $user->city=$data->city;
    $user->pincode=$data->pincode;
    $user->line1=$data->line1;
    $user->line2=$data->line2;
    $user->latitude=$data->latitude;
    $user->longitude=$data->longitude;
    $user->placeId=$data->placeId;

    $user->password=$data->password;

    if ($user->registerUser()) {

        // set response code - 201 created
        http_response_code(201);

        // tell the user
        echo json_encode(array("message" => "user was created."));
    } // if unable to create the product, tell the user
    else {

        // set response code - 503 service unavailable
        http_response_code(503);

        // tell the user
        echo json_encode(array("message" => "Unable to create user."));
    }
} // tell the user data is incomplete
else {

    // set response code - 400 bad request
    http_response_code(400);

    // tell the user
    echo json_encode(array("message" => "Unable to create user. Data is incomplete."));
}

