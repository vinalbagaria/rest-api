<?php

class GetPropertyDetails
{
    private $conn ;
    private $propertyDetailsTable = "propertyDetails" ;
    private $userRoleTable = "userRole" ;
    private $amenitiesTable = "amenities" ;
    private $propertyAmenityTable = "propertyAmenity" ;
    public function __construct($db)
    {
        $this->conn = $db;
    }

    //FUNCTION TO GET  PROPERTY ID BASED ON USER ID
    public function getPropertyId($userId)
    {
        $query = " SELECT propertyId from $this->propertyDetailsTable where userId = :userId";
        $stmt = $this->conn->prepare($query);
        $stmt->bindparam(":userId" , $userId);
        $stmt->execute();
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        return $data['propertyId'];
    }

    //FUNCTION TO GET  PROPERTY NAME BASED ON PROPERTY ID
    public function getPropertyName($propertyId)
    {
        $query = " SELECT propertyName from $this->propertyDetailsTable where propertyId = :propertyId";
        $stmt = $this->conn->prepare($query);
        $stmt->bindparam(":propertyId" , $propertyId);
        $stmt->execute();
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        return $data['propertyName'];
    }
    //FUNCTION TO GET PROPERTY STATUS BASED ON PROPERTY ID
    public function getPropertyStatus($propertyId)
    {
        $query = " SELECT propertyStatus from $this->propertyDetailsTable where propertyId = :propertyId";
        $stmt = $this->conn->prepare($query);
        $stmt->bindparam(":propertyId" , $propertyId);
        $stmt->execute();
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        return $data['propertyStatus'];
    }

    //FUNCTION TO GET PROPERTY RERA NO BASED ON PROPERTY ID
    public function getReraNo($propertyId)
    {
        $query = " SELECT reraNo from $this->propertyDetailsTable where propertyId = :propertyId";
        $stmt = $this->conn->prepare($query);
        $stmt->bindparam(":propertyId" , $propertyId);
        $stmt->execute();
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        return $data['reraNo'];
    }

    //FUNCTION TO GET PROPERTY FLOOR NO BASED ON PROPERTY ID
    public function getFloorNo($propertyId)
    {
        $query = " SELECT floorNo from $this->propertyDetailsTable where propertyId = :propertyId";
        $stmt = $this->conn->prepare($query);
        $stmt->bindparam(":propertyId" , $propertyId);
        $stmt->execute();
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        return $data['floorNo'];
    }

    //FUNCTION TO GET PROPERTY  FLOORS  BASED ON PROPERTY ID
    public function getFloors($propertyId)
    {
        $query = " SELECT floors from $this->propertyDetailsTable where propertyId = :propertyId";
        $stmt = $this->conn->prepare($query);
        $stmt->bindparam(":propertyId" , $propertyId);
        $stmt->execute();
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        return $data['floors'];
    }

    //FUNCTION TO GET PROPERTY FACING BASED ON PROPERTY ID
    public function getFacing($propertyId)
    {
        $query = " SELECT facing from $this->propertyDetailsTable where propertyId = :propertyId";
        $stmt = $this->conn->prepare($query);
        $stmt->bindparam(":propertyId" , $propertyId);
        $stmt->execute();
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        return $data['facing'];
    }

    //FUNCTION TO GET PROPERTY NO OF BATHROOMS BASED ON PROPERTY ID
    public function getBathrooms($propertyId)
    {
        $query = " SELECT noOfBathrooms from $this->propertyDetailsTable where propertyId = :propertyId";
        $stmt = $this->conn->prepare($query);
        $stmt->bindparam(":propertyId" , $propertyId);
        $stmt->execute();
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        return $data['noOfBathrooms'];
    }

    //FUNCTION TO GET PROPERTY NO OF BALCONIES BASED ON PROPERTY ID
    public function getBalconies($propertyId)
    {
        $query = " SELECT noOfBalconies from $this->propertyDetailsTable where propertyId = :propertyId";
        $stmt = $this->conn->prepare($query);
        $stmt->bindparam(":propertyId" , $propertyId);
        $stmt->execute();
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        return $data['noOfBalconies'];
    }

    //FUNCTION TO GET PROPERTY CAR PARKING stmtUS BASED ON PROPERTY ID
    public function getCarParking($propertyId)
    {
        $query = " SELECT carParking from $this->propertyDetailsTable where propertyId = :propertyId";
        $stmt = $this->conn->prepare($query);
        $stmt->bindparam(":propertyId" , $propertyId);
        $stmt->execute();
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        return $data['carParking'];
    }

    //FUNCTION TO GET PROPERTY POSSESION DATE BASED ON PROPERTY ID
    public function getPossessionDate($propertyId)
    {
        $query = " SELECT possessionDate from $this->propertyDetailsTable where propertyId = :propertyId";
        $stmt = $this->conn->prepare($query);
        $stmt->bindparam(":propertyId" , $propertyId);
        $stmt->execute();
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        return $data['possessionDate'];
    }

    //FUNCTION TO GET AGE OF PROPERTY BASED ON PROPERTY ID
    public function getAgeOfProperty($propertyId)
    {
        $query = " SELECT ageOfProperty from $this->propertyDetailsTable where propertyId = :propertyId";
        $stmt = $this->conn->prepare($query);
        $stmt->bindparam(":propertyId" , $propertyId);
        $stmt->execute();
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        return $data['ageOfProperty'];
    }

    //FUNCTION TO GET PROPERTY FURNISHED TYPE BASED ON PROPERTY ID
    public function getFurnishedType($propertyId)
    {
        $query = " SELECT furnishedType from $this->propertyDetailsTable where propertyId = :propertyId";
        $stmt = $this->conn->prepare($query);
        $stmt->bindparam(":propertyId" , $propertyId);
        $stmt->execute();
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        return $data['furnishedType'];
    }

    //FUNCTION TO GET PROPERTY DESCRIPTION BASED ON PROPERTY ID
    public function getDescription($propertyId)
    {
        $query = " SELECT description from $this->propertyDetailsTable WHERE propertyId = :propertyId";
        $stmt = $this->conn->prepare($query);
        $stmt->bindparam(":propertyId" , $propertyId);
        $stmt->execute();
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        return $data['description'];
    }

    // FUNCTION TO GET USERROLEID BASED ON USERID
    public function getUserRoleId($userId)
    {
        $query = " SELECT userRoleId from $this->userRoleTable WHERE userId=:userId";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":userId",$userId);
        $stmt->execute();
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        return $data['userRoleId'];
    }

    function getPropertyDetails($propertyId)
    {
        $query = "SELECT propertyName,propertyStatus,reraNo,propertyTypeId,configurationId,userRoleId,developerId,floorNo,floors,carParking,furnishedType,ageOfProperty,description,possessionDate,
                facing,noOfBathrooms,noOfBalconies FROM $this->propertyDetailsTable WHERE propertyId = :propertyId";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":propertyId",$propertyId);
        $stmt->execute();
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        return $data;
    }

    function getAmenityId($propertyId)
    {
        $query1 = "SELECT amenity FROM $this->amenitiesTable WHERE amenityId IN (SELECT amenityId FROM 
                   $this->propertyAmenityTable WHERE propertyId = :propertyId )" ;


        $stmt = $this->conn->prepare($query1);
        $stmt->bindParam(":propertyId",$propertyId);
        $stmt->execute();

        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            $data[]=$row["amenity"];

//            echo json_encode($row) ;
        }
        return $data;
    }


}


