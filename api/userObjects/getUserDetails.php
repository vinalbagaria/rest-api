<?php
require_once '../propertyObjects/registerPropertyDetails.php' ;

class GetUserDetails
{
    //DATABASE CONNECTION AND TABLE NAME
    private $conn;
    private $userTable = "user";
    private $userRoleTable = " userRole ";
    private $roleTable = "role" ;
    private $data ;
    private $update ;

    //DATABASE CONNECTION
    public function __construct($db)
    {
        $this->conn = $db;
        $this->update = new RegisterPropertyDetails($db) ;
    }

    //FUNCTION FOR GETTTING ROLES OF A PARTICULAR USER
    public function getUserRoles( $userId )
    {
        $query = "SELECT roleType from $this->roleTable WHERE roleId IN (SELECT roleId FROM $this->userRoleTable where userId = :userId)";
        $stat = $this->conn->prepare($query);
        $stat->bindparam(":userId" , $userId);
        $stat->execute();
        while($row = $stat->fetch( PDO::FETCH_ASSOC))
        {
            $this->data[] = $row;
        }
        return $this->data;
    }

    //FUNCTION FOR GETTING USER ROLE ID
    function getUserRoleId($userId , $roleId )
    {
        $query = "SELECT userRoleId from $this->userRoleTable WHERE userId = :userId && roleId = :roleId " ;
        $stmt = $this->conn->prepare($query) ;
        $stmt->bindParam( ":userId" , $userId ) ;
        $stmt->bindParam( ":roleId" , $roleId ) ;
        $stmt->execute();
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        //IF userRoleId DOES NOT EXIST
        if(!$data)
        {
            //INSERT FUNCTION CALL
            $this->update->addUserRole($userId,$roleId) ;
            $stmt->execute();
            $data = $stmt->fetch(PDO::FETCH_ASSOC);
        }
        return $data["userRoleId"] ;
    }

    // GETTING USER DETAILS USING A PARTICULAR USERID
    function getUserDetails($userId)
    {
        $query = "SELECT firstName,lastName,contactNo,emailId,countryId FROM $this->userTable WHERE userId = :userId";
        $stmt = $this->conn->prepare($query) ;
        $stmt->bindParam( ":userId" , $userId ) ;
        $stmt-> execute();
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        return $data;
    }

}
