<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: PUT");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once '../config/database.php';
require_once '../userObjects/updatePassword.php';

$data = json_decode(file_get_contents("php://input"));

//CHECKING DATA IS EMPTY OR NOT
if(
    !empty($data->userId) &&
    !empty($data->oldPassword) &&
    !empty($data->newPassword)
){
    $instance = ConnectDb::getInstance();
    $db = $instance->getConnection();
    $update = new UpdatePassword($db);
    $update->changePassword($data->userId,$data->oldPassword,$data->newPassword);

}
else
{
    echo json_encode( "incomplete data") ;
}
