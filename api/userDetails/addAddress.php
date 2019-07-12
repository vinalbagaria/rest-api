<?php
/// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// get database connection
require_once '../config/database.php';

// instantiate product object
require_once '../userObjects/register.php';

//GET POSTED DATA
$data = json_decode(file_get_contents("php://input"));

if (!empty($data->state) &&
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
    $user = new Register($db);

    $user->state = $data->state;
    $user->city = $data->city;
    $user->pincode = $data->pincode;
    $user->line1 = $data->line1;
    $user->line2 = $data->line2;
    $user->latitude = $data->latitude;
    $user->longitude = $data->longitude;
    $user->placeId = $data->placeId;

    if ($user->addUserAddress()) {
        echo json_encode( "user was created.");

    }
    else {
        echo json_encode("Unable to create user.");
    }
}
else {
    echo json_encode("Unable to create user. Data is incomplete.");
}


