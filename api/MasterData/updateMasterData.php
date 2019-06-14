<?php

class UpdateMasterData
{
    private $conn;
    private $stateTable = "state" ;
    private $cityTable = "city" ;
    private $pincodeTable = "pincode" ;
    private $roleTable = "role" ;
    private $amenitiesTable = "amenities" ;
    private $documentTypeTable = "documentType" ;
    private $configurationTable = "configuration" ;
    private $propertyTypeTable = "propertyType" ;
    private $socialMediaTable = "socialMedia";
    private $unitTable = "unit";
    public function __construct($db)
    {
        $this->conn = $db;
    }

    //user related
    function addState($state,$countryId)
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

    function addCity($city,$stateId)
    {
        $query4 = "INSERT INTO $this->cityTable(city,stateId) VALUES (:city,:stateId)";
        $stmt4 = $this->conn->prepare($query4);
        $stmt4->bindParam(":city", $city);
        $stmt4->bindParam(":stateId", $stateId);
        if($stmt4->execute())
            return true;
        else
            return false ;
    }

    function addPincode($pincode , $cityId)
    {
        $query = "INSERT INTO $this->pincodeTable(pincode,cityId) VALUES (:pincode,:cityId)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":pincode", $pincode);
        $stmt->bindParam(":cityId", $cityId);
        if($stmt->execute())
            return true;
        else
            return false ;
    }

    //property related
    function addUserRole($roleType)
    {
        $query = "INSERT INTO $this->roleTable (roleType) values (:roleType)" ;
        $stmt = $this->conn->prepare($query) ;
        $stmt->bindParam(":roleType" , $roleType ) ;
        if($stmt->execute())
            return true;
        else
            return false;

    }

    function addAmenity($amenity)
    {
        $query = "INSERT INTO $this->amenitiesTable(amenity) values (:amenity)" ;
        $stmt = $this->conn->prepare($query) ;
        $stmt->bindParam(":amenity" , $amenity ) ;
        if($stmt->execute())
            return true;
        else
            return false;

    }

    function addDocumentType($documentName)
    {
        $query = "INSERT INTO $this->documentTypeTable (documentName) values (:documentName)" ;
        $stmt = $this->conn->prepare($query) ;
        $stmt->bindParam(":documentName" , $documentName ) ;
        if($stmt->execute())
            return true;
        else
            return false;

    }

    function addPropertyType($propertyType)
    {
        $query = "INSERT INTO $this->propertyTypeTable (propertyType) VALUES (:propertyType)" ;
        $stmt = $this->conn->prepare($query) ;
        $stmt->bindParam(":propertyType" , $propertyType ) ;
        if($stmt->execute())
            return true ;
        else
            return false ;
    }

    //inserting new configuration
    function addConfigurationType($configurationType)
    {
        $query = "INSERT INTO $this->configurationTable (configurationType) VALUES (:configurationType)" ;
        $stmt = $this->conn->prepare($query) ;
        $stmt->bindParam(":configurationType" , $configurationType ) ;
        if($stmt->execute())
            return true ;
        else
            return false;
    }

    //inserting social media
    function addSocialMedia($socialMediaName)
    {
        $query = "INSERT INTO $this->socialMediaTable (socialMediaName) VALUES (:socialMediaName)" ;
        $stmt = $this->conn->prepare($query) ;
        $stmt->bindParam(":socialMediaName" , $socialMediaName ) ;
        if($stmt->execute())
            return true ;
        else
            return false;

    }

    //inserting unit
    function addUnit($unitName)
    {
        $query = "INSERT INTO $this->unitTable (unitName) VALUES (:unitName)" ;
        $stmt = $this->conn->prepare($query) ;
        $stmt->bindParam(":unitName" , $unitName ) ;
        if($stmt->execute())
            return true ;
        else
            return false;
    }



}