<?php

class UpdatePassword
{
    private $userCredentials="userCredentials";
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function changePassword($userId, $oldPassword, $newPassword)
    {
        $query1="SELECT password FROM $this->userCredentials WHERE userId=:userId ";
        $stmt = $this->conn->prepare($query1);
        $stmt->bindParam(":userId",$userId);
        $stmt->execute();
        $password=$stmt->fetch(PDO::FETCH_ASSOC);

        if( $oldPassword == $password )
        {
            $query2 = "UPDATE userCredentials SET password = :newPassword WHERE userId = :userId";
            $stmt1 = $this->conn->prepare($query2);

            $stmt1->bindParam(":userId",$userId);
            $stmt1->bindParam(":newPassword",$newPassword);
            if($stmt1->execute())
                //return true;
                echo json_encode(array("message"=>"Password Updated successfully."));
            else
                //return false;
                echo json_encode(array("message"=>"Error in updating password.try again"));

        } else
        {
            echo json_encode(array("message"=> "invalid password"));
        }
    }

}