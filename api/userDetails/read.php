<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// database connection will be here
// include database and object files
require_once '../config/database.php';
require_once '../userObjects/login.php';

$data = json_decode(file_get_contents("php://input"));
//$emailId =  $_GET['emailId'] ;
//$password = $_GET['password'] ;
//CHECKING DATA IS EMPTY OR NOT
if(
    !empty($data->emailId) &&
    !empty($data->password)
)
{
    $emailId = $data->emailId ;
    $password = $data->password ;
    // INSTANTIATE DATABASE
    $instance = ConnectDb::getInstance();
    $db = $instance->getConnection();

    $user = new Login($db);
    //checkLogin function to validate the user
    if($user->checkLogin($emailId,$password))
    {
        echo json_encode("user exists.");
    }

    else
    {
        echo json_encode( "Invalid username or password" );
    }

}

else
{
    echo json_encode( "Incomplete Information please fill again.");
}
?>






