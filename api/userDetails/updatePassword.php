<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/database.php';
include_once '../userObjects/updatePassword.php';

$database = new Database();
$db = $database->getConnection();
$update = new UpdatePassword($db);
$data = json_decode(file_get_contents("php://input"));

//CHECKING DATA IS EMPTY OR NOT
if(
    !empty($data->userId) &&
    !empty($data->oldPassword) &&
    !empty($data->newPassword)
){

    $update->changePassword($data->userId,$data->oldPassword,$data->newPassword);
}
else
{
    echo json_encode(array("message" => "incomplete data")) ;
}