<?php

class UpdateMasterData
{
    private $conn;
    private $stateTable = "state" ;
    private $roleTable = "role" ;
    public function __construct($db)
    {
        $this->conn = $db;
    }
    function updateState($state,$countryId)
    {
        $query = "INSERT INTO $this->stateTable(state , countryId) VALUES (:state , :countryId)";
        $stmt= $this->conn->prepare( $query );
        $stmt->bindParam(":state", $state);
        $stmt->bindParam(":countryId",$countryId );
        if($stmt->execute())
        {
            return true;
        }
        else
            return false;
    }

    function userRole($roleType)
    {
        $query = "INSERT INTO $this->roleTable (roleType) values (:roleType)" ;
        $stmt = $this->conn->prepare($query) ;
        $stmt->bindParam(":roleType" , $roleType ) ;
        if($stmt->execute())
            return true ;
        else
            return false ;

    }
}