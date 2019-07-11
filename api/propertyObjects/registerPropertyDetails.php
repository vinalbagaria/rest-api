<?php

require_once '../MasterData/getPropertyMasterData.php' ;
require_once 'getPropertyDetails.php';
require_once '../MasterData/getMasterData.php';
require_once '../propertyObjects/getPropertyDetails.php';

class RegisterPropertyDetails

{
    private $propertyDetailsTable = "propertyDetails";
    private $userRoleTable = "userRole";
    private $propertyAddress = "propertyAddress";
    private $propertyAmenityTable = "propertyAmenity" ;
    private $propertyPriceTable = "propertyPrice" ;

    public $conn;
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
    public $master;
    public $findMaster;
    public $roleType;
    public $roleId;
    public $temp;
    public $propertyId ;
    public $amenity ;
    public $amenityId ;

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
    //OBJECT OF getMasterData TABLE
    public $masterDetails;
    public $iterator=0 ;

    // PROPERTYPRICE TABLE ;
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
        $this->conn = $db;
        $this->master = new GetPropertyMasterData($db);
        $this->findMaster = new GetPropertyDetails($db);
        $this->masterDetails=new GetMasterData($db);
    }

    //INSERTING INTO USERROLE TABLE
    function addUserRole($userId,$roleId)
    {
        $query = "INSERT INTO $this->userRoleTable(userId,roleId) VALUES (:userId,:roleId)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":userId",$userId);
        $stmt->bindParam(":roleId",$roleId);
        $stmt->execute();
        
    }

    function addPropertyAddress()
    {
        $this->propertyId = $this->findMaster->getPropertyId($this->userId);
        $query = "INSERT INTO $this->propertyAddress(propertyId,line1,line2,latitude,longitude,placeId,pincodeId) VALUES (:propertyId,:line1,:line2,:latitude,:longitude,:placeId,:pincodeId)";
        $stmt = $this->conn->prepare($query);
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

    //INSERTING NEW PROPERTY
    function registerPropertyDetails()
    {
        $query = " INSERT INTO $this->propertyDetailsTable(propertyName,propertyStatus,reraNo,propertyTypeId,configurationId,userId,userRoleId,floorNo,floors,carParking,furnishedType,ageOfProperty,description,possessionDate,facing,noOfBathrooms,noOfBalconies) VALUES(:propertyName,:propertyStatus,:reraNo,:propertyTypeId,
        :configurationId,:userId,:userRoleId,:floorNo,:floors,:carParking,:furnishedType,:ageOfProperty,:description,
       :possessionDate,:facing,:noOfBathrooms,:noOfBalconies) " ;

        
        $stmt = $this->conn->prepare($query) ;
        $this->configurationId = $this->master->getConfigurationId($this->configurationType) ;
        $this->userRoleId = $this->master->getRoleId($this->roleType) ;
        $this->propertyTypeId = $this->master->getPropertyTypeId($this->propertyType) ;

        //SANITIZE
        $this->propertyName = htmlspecialchars(strip_tags($this->propertyName));
        $this->propertyStatus = htmlspecialchars(strip_tags($this->propertyStatus));
        $this->reraNo = htmlspecialchars(strip_tags($this->reraNo));

        $this->propertyTypeId = htmlspecialchars(strip_tags(($this->master)->getPropertyTypeId($this->propertyType)));

        $this->configurationId = htmlspecialchars(strip_tags(($this->master)->getConfigurationId($this->configurationType)));

        $this->userId = htmlspecialchars(strip_tags($this->userId));

        $this->roleId = htmlspecialchars(strip_tags(($this->master)->getRoleId($this->roleType)));

        $this->addUserRole($this->userId,$this->roleId);        

        $this->userRoleId = htmlspecialchars(strip_tags(($this->findMaster)->getUserRoleId($this->userId)));

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

        //INSERTION COMMAND
        if($stmt->execute())
            return true ;
        else
            return false ;
    }
    //INSERTING INTO PROPERTY AMENITY TABLE
    function addPropertyAmenity()
    {
        //INSERTING INTO AMENITY ID ARRAY FROM AMENITY TABLE WITH AMENITY ID
        foreach($this->amenity as $key => $value)
        {
            $this->temp = $value ;
            $this->amenityId[] = htmlspecialchars(strip_tags(($this->master)->getAmenityId($this->temp)));
            $this->iterator += 1;
        }

        // FINDING OUT PROPERTYID
        $query= "SELECT propertyId from $this->propertyDetailsTable WHERE userId = :userId " ;
        $stmt = $this->conn->prepare($query) ;
        $stmt->bindParam(":userId" , $this->userId );
        $stmt->execute();

        $tempPropertyId = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->propertyId = $tempPropertyId["propertyId"];

        //FOR EACH AMENITY ID THERE WILL BE INSERTION
        foreach($this->amenityId as $key => $value)
        {
            $this->temp = $value;

            $query1 = "INSERT INTO $this->propertyAmenityTable (amenityId,propertyId) VALUES( :temp , :propertyId )";

            $stmt1 = $this->conn->prepare($query1) ;
            $stmt1->bindParam(":temp", $this->temp);
            $stmt1->bindParam(":propertyId",$this->propertyId);
            $stmt1->execute();
            $this->iterator -= 1;
        }

        if( $this->iterator == 0)
            return true;
        else
            return false;

    }

    function addPropertyPrice()
    {
         $query = "INSERT INTO $this->propertyPriceTable
        ( pricePerUnit , carpetArea , propertyId , buildUpArea , baseValue , registration , stampDuty , maintenance , unitId) 
        VALUES ( :pricePerUnit , :carpetArea , :propertyId , :buildUpArea , :baseValue , :registration , :stampDuty ,
        :maintenance , :unitId ) " ;
        $this->unitId = $this->master->getUnitId( $this->unitName );

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":pricePerUnit" , $this->pricePerUnit ) ;
        $stmt->bindParam(":carpetArea" , $this->carpetArea ) ;
        $stmt->bindParam(":propertyId" , $this->propertyId ) ;
        $stmt->bindParam(":buildUpArea" , $this->buildUpArea ) ;
        $stmt->bindParam(":baseValue" , $this->baseValue ) ;
        $stmt->bindParam(":registration" , $this->registration ) ;
        $stmt->bindParam(":stampDuty" , $this->stampDuty ) ;
        $stmt->bindParam(":maintenance" , $this->maintenance ) ;
        $stmt->bindParam(":unitId" , $this->unitId ) ;
        if($stmt->execute())
                return true ;
        else
            return false;
    }

    function deleteProperty($propertyId)
    {
        $query = "DELETE FROM $this->propertyDetailsTable WHERE propertyId = :propertyId " ;
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":propertyId" , $propertyId ) ;
        $stmt->execute();
    }
}

