<?php
        // required headers
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");

        // database connection will be here
        // include database and object files
        include_once '../config/database.php';
        include_once '../objects/login.php';

        // instantiate database and Login object
        $database = new Database();
        $db = $database->getConnection();

        // initialize object
        $user = new Login($db);
        $data = json_decode(file_get_contents("php://input"));

        //checking data is empty or not
        if(
            !empty($data->email) &&
            !empty($data->password)
        )
        {
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





