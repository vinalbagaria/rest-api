<?php

class UpdatePassword
{
    // DATABASE CONNECTION AND TABLE NAME
    private $userCredentials="userCredentials";
    private $conn;

    // CONSTRUCTOR WITH $db AS DATABASE CONNECTION
    public function __construct($db)
    {
        $this->conn = $db;
    }

    // TO CHANGE PASSWORD
    public function changePassword($userId, $oldPassword, $newPassword)
    {
        $query ="SELECT password FROM $this->userCredentials WHERE userId = :userId ";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":userId",$userId);
        $stmt->execute();
        $password=$stmt->fetch(PDO::FETCH_ASSOC);

        //IF PASSWORD MATCHES WITH THE OLD PASSWORD
        if( $oldPassword == $password['password'] )
        {
            $query = "UPDATE userCredentials SET password = :newPassword WHERE userId = :userId";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":userId",$userId);
            $stmt->bindParam(":newPassword",$newPassword);
            if($stmt->execute())
                echo json_encode("Password Updated successfully.");
            else
                echo json_encode("Error in updating password.try again");

        } else
        {
            echo json_encode("invalid password");
        }
    }
}
