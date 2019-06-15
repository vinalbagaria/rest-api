<?php

class Login
{

    // database connection and table name
    private $conn;
    private $userTable = "user";
    private $userCredentialsTable = "userCredentials";

    // object properties
    public $userId;
    public $email;
    public $password;

    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

    // read user
    public function checkLogin($emailId,$password){
        $query = "SELECT userId FROM $this->userTable WHERE emailId = :emailId ";

        // prepare query statement
        $findUserId = $this->conn->prepare($query);
        $findUserId->bindParam(":emailId", $emailId);

        // execute query
        $findUserId->execute();
        $temp = $findUserId->fetch(PDO::FETCH_ASSOC);

        $this->userId = $temp["userId"];

        //if user enters invalid username
        if($this->userId == NULL){
            echo json_encode(array("message" => "Invalid Username"));
            echo json_encode(array("message" => "user  do not exist."));

            return false;
        }

        //if user enters valid email id so checking of password takes place
        $getPassword = "SELECT userId,password FROM $this->userCredentialsTable WHERE userId = :userId && password = :password";
        $checkPassword = $this->conn->prepare($getPassword);
        $checkPassword->bindParam(":userId", $this->userId);
        $checkPassword->bindParam(":password", $password);
        $checkPassword->execute();
        $temp = $checkPassword->fetch(PDO::FETCH_ASSOC);

        //if user enters wrong password
        if(!$temp)
        {
            echo json_encode(array("message" => " Invalid Password"));
            return false;
        }

        //if username and password both matches
        else
        {
            echo json_encode(array("message" => "Successful"));
            return true;
        }

    }
}