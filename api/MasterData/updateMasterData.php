<?php

class UpdateMasterData
{
    // DATABASE CONNECTION AND TABLE NAMES
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

    // CONSTRUCTOR WITH $db AS DATABASE CONNECTION
    public function __construct($db)
    {
        $this->conn = $db;
    }

    //ADDING NEW STATE
    function addState($state, $countryId)
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

    //ADDING NEW CITY
    function addCity($city, $stateId)
    {
        $query = "INSERT INTO $this->cityTable(city,stateId) VALUES (:city,:stateId)";
        $stmt = $this->conn->prepare($query4);
        $stmt->bindParam(":city", $city);
        $stmt->bindParam(":stateId", $stateId);
        if($stmt->execute())
            return true;
        else
            return false ;
    }

    //ADDING NEW PINCODE
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

    //ADDING NEW USER ROLE
    function addUserRole($roleType)
    {
        $query = "INSERT INTO $this->roleTable (roleType) values (:roleType)";
        $stmt = $this->conn->prepare($query) ;
        $stmt->bindParam(":roleType" , $roleType ) ;
        if($stmt->execute())
            return true;
        else
            return false;

    }

    //ADDING NEW AMENITY
    function addAmenity($amenity)
    {
        $query = "INSERT INTO $this->amenitiesTable(amenity) values (:amenity)";
        $stmt = $this->conn->prepare($query) ;
        $stmt->bindParam(":amenity" , $amenity) ;
        if($stmt->execute())
            return true;
        else
            return false;
    }

    //ADDING NEW DOCUMENT TYPE
    function addDocumentType($documentName)
    {
        $query = "INSERT INTO $this->documentTypeTable (documentName) values (:documentName)" ;
        $stmt = $this->conn->prepare($query) ;
        $stmt->bindParam(":documentName" , $documentName) ;
        if($stmt->execute())
            return true;
        else
            return false;

    }

    //ADDING NEW PROPERTY TYPE
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

    //ADDING NEW CONFIGURATION TYPE
    function addConfigurationType($configurationType)
    {
        $query = "INSERT INTO $this->configurationTable (configurationType) VALUES (:configurationType)" ;
        $stmt = $this->conn->prepare($query) ;
        $stmt->bindParam(":configurationType" , $configurationType) ;
        if($stmt->execute())
            return true ;
        else
            return false;
    }

    //ADDING NEW SOCIAL MEDIA
    function addSocialMedia($socialMediaName)
    {
        $query = "INSERT INTO $this->socialMediaTable (socialMediaName) VALUES (:socialMediaName)" ;
        $stmt = $this->conn->prepare($query) ;
        $stmt->bindParam(":socialMediaName" , $socialMediaName) ;
        if($stmt->execute())
            return true ;
        else
            return false;
    }

    //ADDING NEW UNIT
    function addUnit($unitName)
    {
        $query = "INSERT INTO $this->unitTable (unitName) VALUES (:unitName)";
        $stmt = $this->conn->prepare($query) ;
        $stmt->bindParam(":unitName" , $unitName) ;
        if($stmt->execute())
            return true ;
        else
            return false;
    }

}
