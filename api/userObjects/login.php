<?php
class Login
{

    // DATABASE CONNECTION AND TABLE NAME
    private $conn;
    private $userTable = "user";
    private $userCredentialsTable = "userCredentials";

    // OBJECT PROPERTIES
    public $userId;
    public $email;
    public $password;

    // DATABASE CONNECTION
    public function __construct($db)
    {
        $this->conn = $db;
    }

    // READ USER
    public function checkLogin($emailId,$password)
    {
        $query = "SELECT userId FROM $this->userTable WHERE emailId = :emailId ";
        $findUserId = $this->conn->prepare($query);
        $findUserId->bindParam(":emailId", $emailId);
        $findUserId->execute();
        $temp = $findUserId->fetch(PDO::FETCH_ASSOC);
        $this->userId = $temp["userId"];

        //CHECKING VALID OR INVALID
        if($this->userId == NULL)
        {
            return false;
        }

        // IF USER ENTERS VALID EMAILID THEN
        $getPassword = "SELECT userId,password FROM $this->userCredentialsTable WHERE userId = :userId && password = :password";
        $checkPassword = $this->conn->prepare($getPassword);
        $checkPassword->bindParam(":userId",  $this->userId );
        $checkPassword->bindParam(":password", $password);
        $checkPassword->execute();
        $temp = $checkPassword->fetch(PDO::FETCH_ASSOC);

        //CHECKING OF PASSWORD
        if(!$temp)
        {
            return false;
        }

        // IF BOTH MATCHES
        else
        {
            return true;
        }

    }
}
