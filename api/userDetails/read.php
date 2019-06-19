<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/database.php';
include_once '../userObjects/login.php';


$data = json_decode(file_get_contents("php://input"));



//CHECKING DATA IS EMPTY OR NOT
if(
    !empty($data->email) &&
    !empty($data->password)
)
{
    // INSTANTIATE DATABASE
    $database = new Database();
    $db = $database->getConnection();

    $user = new Login($db);
    //checkLogin function to validate the user
    if($user->checkLogin($data->email,$data->password))
    {
        http_response_code(201);
        echo json_encode(array("message" => "user exist."));
    }

    else
    {
        http_response_code(503);
    }

}

//if user inputs incomplete information
else
{
    http_response_code(400);
    echo json_encode(array("message" => "Incomplete Information please fill again."));
}
?>






