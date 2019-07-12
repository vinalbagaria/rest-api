<?php

require_once '../MasterData/getPropertyMasterData.php' ;
require_once 'getPropertyDetails.php';
require_once '../MasterData/getMasterData.php';
require_once '../propertyObjects/getPropertyDetails.php';

class RegisterPropertyDetails

{
    //ALL TABLES
    private $propertyDetailsTable = "propertyDetails";
    private $userRoleTable = "userRole";
    private $propertyAddress = "propertyAddress";
    private $propertyAmenityTable = "propertyAmenity" ;
    private $propertyPriceTable = "propertyPrice" ;

    //CONNECTION VARIABLE
    public $conn;

    //OBJECTS
    public $getPropertyMasterData;  //OBJECT OF GET PROPERTY MASTER DATA
    public $getPropertyDetails;     //OBJECT OF GET PROPERTY DETAILS
    public $masterDetails;          //OBJECT OF GET MASTER DATA

    //PROPERTY DETAILS TABLE VARIABLES
    public $propertyId ;
    public $userRoleId;
    public $propertyName;
    public $propertyStatus;
    public $reraNo;
    public $propertyTypeId;
    public $propertyType;
    public $configurationType;
    public $configurationId;
    public $userId;
    public $floorNo;
    public $floors;
    public $carParking;
    public $furnishedType;
    public $ageOfProperty = NULL ;
    public $description = NULL ;
    public $possessionDate = NULL ;
    public $facing = NULL ;
    public $noOfBathrooms = NULL ;
    public $noOfBalconies = NULL ;
    public $roleType;
    public $roleId;

    //PROPERTY AMENITY TABLE
    public $amenity ;
    public $amenityId ;
    public $temp;
    public $iterator=0 ;

    //PROPERTY ADDRESS TABLE
    public $country;
    public $countryId;
    public $state;
    public $stateId;
    public $city;
    public $cityId;
    public $pincode;
    public $pincodeId;
    public $line2;
    public $line1;
    public $latitude;
    public $longitude;
    public $placeId;

    //PROPERTY PRICE TABLE ;
    public $carpetArea ;
    public $pricePerUnit ;
    public $buildUpArea ;
    public $baseValue ;
    public $registration ;
    public $stampDuty ;
    public $maintenance ;
    public $unitName ;
    public $unitId ;

    function __construct($db)
    {
        //CONNECTION ESTABLISHED
        $this->conn = $db;
        //CREATION OF OBJECTS
        $this->getPropertyMasterData = new GetPropertyMasterData($db);
        $this->getPropertyDetails = new GetPropertyDetails($db);
        $this->masterDetails=new GetMasterData($db);
    }

    //INSERTING ROLE FOR A PARTICULAR USER INTO USER ROLE TABLE
    function addUserRole($userId,$roleId)
    {
        $query = "INSERT INTO $this->userRoleTable(userId,roleId) VALUES (:userId,:roleId)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":userId",$userId);
        $stmt->bindParam(":roleId",$roleId);
        $stmt->execute();
    }

    //FOR ADDING PROPERTY ADDRESS
    function addPropertyAddress()
    {
        $query = "INSERT INTO $this->propertyAddress(propertyId,line1,line2,latitude,longitude,placeId,pincodeId) VALUES (:propertyId,:line1,:line2,:latitude,:longitude,:placeId,:pincodeId)";
        $stmt = $this->conn->prepare($query);

        //SANITIZE
        //FOR COUNTRY
        $this->countryId=htmlspecialchars(strip_tags(($this->masterDetails)->getCountryId($this->country)));
        //FOR STATE
        $this->state=htmlspecialchars(strip_tags($this->state));
        $this->stateId=htmlspecialchars(strip_tags(($this->masterDetails)->getStateId($this->state , $this->countryId)));
        //FOR CITY
        $this->city=htmlspecialchars(strip_tags($this->city));
        $this->cityId=htmlspecialchars(strip_tags(($this->masterDetails)->getCityId($this->city , $this->stateId)));
        //FOR PINCODE
        $this->pincode=htmlspecialchars(strip_tags($this->pincode));
        $this->pincodeId=htmlspecialchars(strip_tags(($this->masterDetails)->getpincodeId($this->pincode , $this->cityId)));
        //FOR REMAINING ADDRESS
        $this->line1=htmlspecialchars(strip_tags($this->line1));
        $this->line2=htmlspecialchars(strip_tags($this->line2));
        $this->latitude=htmlspecialchars(strip_tags($this->latitude));
        $this->longitude=htmlspecialchars(strip_tags($this->longitude));
        $this->placeId=htmlspecialchars(strip_tags($this->placeId));

        $stmt->bindParam(":line1", $this->line1);
        $stmt->bindParam(":line2", $this->line2);
        $stmt->bindParam(":latitude", $this->latitude);
        $stmt->bindParam(":longitude", $this->longitude);
        $stmt->bindParam(":placeId", $this->placeId);
        $stmt->bindParam(":pincodeId", $this->pincodeId);
        $stmt->bindParam(":propertyId" , $this->propertyId);

        if($stmt->execute())
            return true ;
        else
            return false ;
    }

    //ADDING NEW PROPERTY DETAILS
    function registerPropertyDetails()
    {
        $query = " INSERT INTO $this->propertyDetailsTable(propertyName,propertyStatus,reraNo,propertyTypeId,configurationId,userId,userRoleId,floorNo,floors,carParking,furnishedType,ageOfProperty,description,possessionDate,facing,noOfBathrooms,noOfBalconies) VALUES(:propertyName,:propertyStatus,:reraNo,:propertyTypeId,
        :configurationId,:userId,:userRoleId,:floorNo,:floors,:carParking,:furnishedType,:ageOfProperty,:description,
       :possessionDate,:facing,:noOfBathrooms,:noOfBalconies) ";
        $stmt = $this->conn->prepare($query);

        //SANITIZE
        $this->propertyName = htmlspecialchars(strip_tags($this->propertyName));
        $this->propertyStatus = htmlspecialchars(strip_tags($this->propertyStatus));
        $this->reraNo = htmlspecialchars(strip_tags($this->reraNo));
        $this->propertyTypeId = htmlspecialchars(strip_tags(($this->getPropertyMasterData)->getPropertyTypeId($this->propertyType)));
        $this->configurationId = htmlspecialchars(strip_tags(($this->getPropertyMasterData)->getConfigurationId($this->configurationType)));
        $this->userId = htmlspecialchars(strip_tags($this->userId));
        $this->roleId = htmlspecialchars(strip_tags(($this->getPropertyMasterData)->getRoleId($this->roleType)));

        //FOR INSERTING NEW USER ROLE
        $this->addUserRole($this->userId,$this->roleId);

        $this->userRoleId = htmlspecialchars(strip_tags(($this->getPropertyDetails)->getUserRoleId($this->userId)));
        $this->floors = htmlspecialchars(strip_tags($this->floors));
        $this->floorNo = htmlspecialchars(strip_tags($this->floorNo));
        $this->carParking = htmlspecialchars(strip_tags($this->carParking));
        $this->furnishedType = htmlspecialchars(strip_tags($this->furnishedType));
        $this->ageOfProperty = htmlspecialchars(strip_tags($this->ageOfProperty));
        $this->description = htmlspecialchars(strip_tags($this->description));
        $this->possessionDate = htmlspecialchars(strip_tags($this->possessionDate));
        $this->facing = htmlspecialchars(strip_tags($this->facing));
        $this->noOfBathrooms = htmlspecialchars(strip_tags($this->noOfBathrooms));
        $this->noOfBalconies = htmlspecialchars(strip_tags($this->noOfBalconies));

        //BINDING PARAMS
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

        //EXECUTION OF QUERY
        if($stmt->execute()) {
            //GETTING AUTOINCREMENT PROPERTY ID FROM DATABASE
            $this->propertyId = $this->conn->lastInsertId();
            return true;
        } else
            return false ;
    }

    //INSERT AMENITY INTO PROPERTY AMENITY TABLE
    function addPropertyAmenity()
    {
        //INSERTING INTO AMENITY ID ARRAY FROM AMENITY TABLE WITH AMENITY ID
        foreach($this->amenity as $key => $value)
        {
            $this->temp = $value;
            $this->amenityId[] = htmlspecialchars(strip_tags(($this->getPropertyMasterData)->getAmenityId($this->temp)));
            $this->iterator += 1;
        }
        //FOR EACH AMENITY ID THERE WILL BE INSERTION
        foreach($this->amenityId as $key => $value)
        {
            $this->temp = $value;
            $query = "INSERT INTO $this->propertyAmenityTable (amenityId,propertyId) VALUES( :temp , :propertyId )";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":temp", $this->temp);
            $stmt->bindParam(":propertyId",$this->propertyId);
            $stmt->execute();
            $this->iterator -= 1;
        }
        if( $this->iterator == 0)
            return true;
        else
            return false;
    }

    //ADDING PROPERTY PRICE IN PROPERTY PRICE TABLE
    function addPropertyPrice()
    {
         $query = "INSERT INTO $this->propertyPriceTable
        ( pricePerUnit , carpetArea , propertyId , buildUpArea , baseValue , registration , stampDuty , maintenance , unitId) 
        VALUES ( :pricePerUnit , :carpetArea , :propertyId , :buildUpArea , :baseValue , :registration , :stampDuty ,
        :maintenance , :unitId ) ";

         //GETTING THE UNIT ID FOR A PARTICULAR UNIT
        $this->unitId = $this->getPropertyMasterData->getUnitId($this->unitName);
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":pricePerUnit" , $this->pricePerUnit );
        $stmt->bindParam(":carpetArea" , $this->carpetArea );
        $stmt->bindParam(":propertyId" , $this->propertyId );
        $stmt->bindParam(":buildUpArea" , $this->buildUpArea );
        $stmt->bindParam(":baseValue" , $this->baseValue );
        $stmt->bindParam(":registration" , $this->registration );
        $stmt->bindParam(":stampDuty" , $this->stampDuty );
        $stmt->bindParam(":maintenance" , $this->maintenance );
        $stmt->bindParam(":unitId" , $this->unitId );
        if($stmt->execute())
                return true ;
        else
            return false;
    }

    //DELETE A PROPERTY
    function deleteProperty($propertyId)
    {
        $query = "DELETE FROM $this->propertyDetailsTable WHERE propertyId = :propertyId " ;
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":propertyId" , $propertyId ) ;
        $stmt->execute();
    }
}

