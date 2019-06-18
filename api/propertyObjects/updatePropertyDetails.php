<?php

include_once '../MasterData/getPropertyMasterData.php' ;

class UpdatePropertyDetails

{
    public $conn ;

    public $userRoleId ;
    public $propertyName ;
    public $propertyStatus ;
    public $reraNo ;
    public $propertyTypeId;
    public $propertyType ;
    public $configurationType ;
    public $configurationId ;
    public $userId;
//    public $developerId;
    public $floorNo ;
    public $floors;
    public $carParking ;
    public $furnishedType;
    public $ageOfProperty;
    public $description;
    public $possessionDate ;
    public $facing;
    public $noOfBathrooms;
    public $noOfBalconies;
    public $master;
    public $roleType;
    private $propertyDetailsTable = "propertyDetails" ;

    function __construct($db)
    {
        $this->conn = $db ;
        $this->master = new GetPropertyMasterData($db) ;

    }

    function updatePropertyDetails()
    {
        $query = "UPDATE $this->propertyDetailsTable SET propertyName = :propertyName, propertyStatus = :propertyStatus,reraNo = :reraNo,
         userRoleId = :userRoleId , configurationId = :configurationId , userRoleId = :userRoleId ,
         floorNo = :floorNo , floors = :floors , carParking = :carParking , furnishedType = :furnishedType,
         ageOfProperty = :ageOfProperty  , description = :description ,
       possessionDate = :possessionDate  , facing = :facing , noOfBathrooms = :noOfBathrooms , noOfBalconies = :noOfBalconies 
         WHERE userId = :userId" ;
        $stmt = $this->conn->prepare($query) ;

        //SANITIZE DATA
        $this->userId = htmlspecialchars(strip_tags($this->userId)) ;
        $this->propertyName = htmlspecialchars(strip_tags($this->propertyName)) ;
        $this->propertyStatus = htmlspecialchars(strip_tags($this->propertyStatus))  ;
        $this->reraNo = htmlspecialchars(strip_tags($this->reraNo)) ;
        $this->configurationId = $this->master->getConfigurationId($this->configurationType) ;
        $this->userRoleId = $this->master->getRoleId($this->roleType) ;
        $this->propertyTypeId = $this->master->getPropertyTypeId($this->propertyType) ;
        $this->floorNo = htmlspecialchars(strip_tags($this->floorNo)) ;
        $this->floors = htmlspecialchars(strip_tags($this->floors)) ;
        $this->carParking = htmlspecialchars(strip_tags($this->carParking)) ;
        $this->furnishedType = htmlspecialchars(strip_tags($this->furnishedType)) ;
        $this->ageOfProperty = htmlspecialchars(strip_tags($this->ageOfProperty)) ;
        $this->description = htmlspecialchars(strip_tags($this->description)) ;
        $this->possessionDate = htmlspecialchars(strip_tags($this->possessionDate)) ;
        $this->facing = htmlspecialchars(strip_tags($this->facing)) ;
        $this->noOfBathrooms = htmlspecialchars(strip_tags($this->noOfBathrooms)) ;
        $this->noOfBalconies = htmlspecialchars(strip_tags($this->noOfBathrooms)) ;

        //BINDING PARAMETERS
        $stmt->bindParam(":propertyName" , $this->propertyName);
        $stmt->bindParam(":propertyStatus" , $this->propertyStatus);
        $stmt->bindParam(":reraNo" , $this->reraNo);
        $stmt->bindParam(":configurationId" , $this->configurationId);
        $stmt->bindParam(":userRoleId" , $this->userRoleId);
        $stmt->bindParam(":propertyTypeId" , $this->propertyTypeId);
        $stmt->bindParam(":floorNo" , $this->floorNo);
        $stmt->bindParam(":floors" , $this->floors);
        $stmt->bindParam(":carParking" , $this->carParking);
        $stmt->bindParam(":furnishedType" , $this->furnishedType);
        $stmt->bindParam(":ageOfProperty" , $this->ageOfProperty);
        $stmt->bindParam(":description" , $this->description);
        $stmt->bindParam(":possessionDate" , $this->possessionDate);
        $stmt->bindParam(":facing" , $this->facing);
        $stmt->bindParam(":noOfBathrooms" , $this->noOfBathrooms);
        $stmt->bindParam(":noOfBalconies" , $this->noOfBalconies);
        $stmt->bindParam(":userId",$this->userId);

        //EXECUTION COMMAND
        if($stmt->execute())
            return true ;
        else
            return false ;
    }

}