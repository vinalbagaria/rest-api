<?php

require_once '../MasterData/getPropertyMasterData.php' ;
require_once 'registerPropertyDetails.php' ;
class UpdatePropertyDetails

{
    public $conn ;
    public $update ;
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
    public $roleId;
    public $amenityId;
    public $i = 0;
    public $temp;
    public $amenity;
    private $propertyDetailsTable = "propertyDetails" ;
    private $userRoleTable = "userRole" ;
    private $propertyAmenityTable = "propertyAmenity";
    function __construct($db)
    {
        $this->conn = $db ;
        $this->master = new GetPropertyMasterData($db) ;
        $this->update = new RegisterPropertyDetails($db) ;
    }

    //FUNCTION FOR UPDATING PROPERTY DETAILS
    function updatePropertyDetails()
    {
        $query = "UPDATE $this->propertyDetailsTable SET propertyName = :propertyName, propertyStatus = :propertyStatus,reraNo = :reraNo,
         userRoleId = :userRoleId , configurationId = :configurationId  ,
         floorNo = :floorNo , floors = :floors , carParking = :carParking , furnishedType = :furnishedType,
         ageOfProperty = :ageOfProperty  , description = :description ,
       possessionDate = :possessionDate  , facing = :facing , noOfBathrooms = :noOfBathrooms , noOfBalconies = :noOfBalconies 
         WHERE userId = :userId" ;
        $stmt = $this->conn->prepare($query) ;

        $this->roleId = $this->master->getRoleId($this->roleType) ;
        //SANITIZE DATA
        $this->userId = htmlspecialchars(strip_tags($this->userId)) ;
        $this->propertyName = htmlspecialchars(strip_tags($this->propertyName)) ;
        $this->propertyStatus = htmlspecialchars(strip_tags($this->propertyStatus))  ;
        $this->reraNo = htmlspecialchars(strip_tags($this->reraNo)) ;
        $this->configurationId = htmlspecialchars(strip_tags($this->master->getConfigurationId($this->configurationType))) ;
        $this->userRoleId = $this->getUserRoleId($this->userId,$this->roleId) ;
        $this->propertyTypeId = htmlspecialchars(strip_tags($this->master->getPropertyTypeId($this->propertyType))) ;
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

    //FUNCTION FOR GETTING USER ROLE ID
    function getUserRoleId()
    {
        $query = "SELECT userRoleId from $this->userRoleTable WHERE userId = :userId && roleId = :roleId " ;
        $stmt = $this->conn->prepare($query) ;
        $stmt->bindParam( ":userId" , $this->userId ) ;
        $stmt->bindParam( ":roleId" , $this->roleId ) ;
        $stmt->execute();
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        //IF userRoleId DOES NOT EXIST
        if(!$data)
        {
            //INSERT FUNCTION CALL
            $this->update->addUserRole($this->userId,$this->roleId) ;
            $stmt->execute();
            $data = $stmt->fetch(PDO::FETCH_ASSOC);
        }
        echo json_encode(array("message" => $data["userRoleId"]));
        return $data["userRoleId"] ;
    }

    function updatePropertyAmenity()
    {
        echo json_encode("hiii");
        foreach($this->amenity as $key => $value)
        {
            $this->amenityId[] = htmlspecialchars(strip_tags(($this->master)->getAmenityId($value)));
            $this->i += 1;
        }

        foreach($this->amenityId as $key => $value)
        {
            echo json_encode($value);
        }

        //FINDING OUT PROPERTYID
        $query= "SELECT propertyId from $this->propertyDetailsTable WHERE userId = :userId"; 
        $stmt = $this->conn->prepare($query) ;
        $stmt->bindParam(":userId",$this->userId);
        $stmt->execute();
        $tempPropertyId = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->propertyId = $tempPropertyId["propertyId"];
        echo json_encode($this->propertyId);

        //UPDATING PROPERTY AMENITY USING PROPERTYID
        foreach($amenityId as $key => $value)
        {
        $this->temp = $value;
        $query1 = "UPDATE $this->propertyAmenityTable SET amenityId = :temp WHERE propertyId = :propertyId";
        $stmt1 = $this->conn->prepare($query1);
        $stmt1->bindParam(":temp",$this->temp);
        $stmt1->bindParam(":propertyId",$this->propertyId);
        $stmt1->execute();
        $this->i -= 1;
        }

        if($this->i == 0)
        return true;
        else
        return false;

    }


}