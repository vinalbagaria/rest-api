<?php

class GetUserDetails
{
    private $conn;
    private $user = "user";
    private $userAddress = "userAddress";
    private $userCredentials = "userCredentials";
    private $userRoleTable = " userRole ";
    private $countryTable = "country";
    private $stateTable = "state";
    private $cityTable = "city";
    private $pincodeTable = "pincode";
    private $updateMaster;
    private $roleTable = "role" ;

    public function __construct($db)
    {
        $this->conn = $db;
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
            $data[] = $row;
        }
        return $data;
    }

}