<?php

require_once '../MasterData/getPropertyMasterData.php' ;
require_once 'registerPropertyDetails.php' ;
require_once '../userObjects/getUserDetails.php' ;
require_once 'getPropertyDetails.php';
require_once '../MasterData/getMasterData.php' ;
class UpdatePropertyDetails

{
    public $amenity ;
    public $amenityId ;
    public $propertyId ;
    public $iterator = 0 ;
    public $temp;
    public $get ;
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
    public $roleId ;

    public $pricePerUnit;
    public $carpetArea;
    public $buildUpArea;
    public $baseValue;
    public $registration;
    public $stampDuty;
    public $maintenance;
    public $unitId;
    public $find;
    public $unitName;

    public $masterDetails ;
    public $line1;
    public $line2;
    public $latitude;
    public $longitude;
    public $placeId;
    public $pincodeId;
    public $pincode;
    public $city;
    public $cityId;
    public $state;
    public $stateId;
    public $country;
    public $countryId;

    private $propertyDetailsTable = "propertyDetails" ;
    private $propertyAmenityTable  = "propertyAmenity" ;
    private $propertyPriceTable = "propertyPrice";
    private $propertyAddressTable = "propertyAddress" ;

    function __construct($db)
    {
        $this->conn = $db ;
        $this->master = new GetPropertyMasterData($db) ;
        $this->get = new GetUserDetails($db)  ;
        $this->update = new RegisterPropertyDetails($db) ;
        $this->find = new GetPropertyDetails($db);
        $this->masterDetails=new GetMasterData($db);
    }

    //FUNCTION FOR UPDATING PROPERTY DETAILS
    function updatePropertyDetails()
    {
        $query = "UPDATE $this->propertyDetailsTable SET propertyName = :propertyName, propertyStatus = :propertyStatus,
        reraNo = :reraNo, propertyTypeId = :propertyTypeId , configurationId = :configurationId , userRoleId = :userRoleId ,
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
        $this->userRoleId = $this->get->getUserRoleId($this->userId,$this->roleId) ;
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


    function updatePropertyAmenity()
    {
//        foreach($this->amenity as $key => $value)
//        {
//            $this->amenityId[] = htmlspecialchars(strip_tags(($this->master)->getAmenityId($value)));
//            $this->iterator += 1;
//        }
//
//        foreach($this->amenityId as $key => $value)
//        {
//            echo json_encode($value);
//        }
//
       // FINDING OUT PROPERTYID
        $query= "SELECT propertyId from $this->propertyDetailsTable WHERE userId = :userId";
        $stmt = $this->conn->prepare($query) ;
        $stmt->bindParam(":userId",$this->userId);
        $stmt->execute();
        $tempPropertyId = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->propertyId = $tempPropertyId["propertyId"];
////        echo json_encode($this->propertyId);
//
//        //UPDATING PROPERTY AMENITY USING PROPERTYID
//        foreach($this->amenityId as $key => $value)
//        {
//            $this->temp = $value;
//            $query1 = "UPDATE $this->propertyAmenityTable SET amenityId = :temp WHERE propertyId = :propertyId ";
//            $stmt1 = $this->conn->prepare($query1);
//            $stmt1->bindParam(":temp",$this->temp);
//            $stmt1->bindParam(":propertyId",$this->propertyId);
//            $stmt1->execute();
//            $this->iterator -= 1;
//        }

        $query = "DELETE FROM $this->propertyAmenityTable WHERE propertyId = :propertyId";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":propertyId",$this->propertyId);


        if($stmt->execute())
        {
            $this->update->amenity = $this->amenity ;
            $this->update->userId = $this->userId ;
            $x = $this->update->addPropertyAmenity() ;
            if($x)
            return true;
        }

        return false;

    }

    function updatePropertyPrice()
    {
        echo json_encode(array("message"=>"property price table"));
        $this->propertyId = $this->find->getPropertyId($this->userId);
        $this->unitId = $this->master->getUnitId($this->unitName);
        echo json_encode($this->unitId);
        echo json_encode($this->userId);
        echo json_encode($this->propertyId);

        $query = "UPDATE $this->propertyPriceTable
        SET pricePerUnit=:pricePerUnit , carpetArea = :carpetArea , buildUpArea = :buildUpArea, baseValue = :baseValue ,
        registration = :registration ,stampDuty = :stampDuty , maintenance = :maintenance ,
        unitId = :unitId WHERE propertyId =:propertyId";
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
            return true;
        else
            return false;
    }
    function updatePropertyAddress()
    {
        $query = "UPDATE $this->propertyAddressTable
        SET line1 = :line1 , line2 = :line2 , latitude = :latitude , longitude = :longitude , placeId = :placeId ,
        pincodeId = :pincodeId WHERE propertyId = :propertyId ";

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

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":line1" , $this->line1 ) ;
        $stmt->bindParam(":line2" , $this->line2 ) ;
        $stmt->bindParam(":latitude" , $this->latitude ) ;
        $stmt->bindParam(":longitude" , $this->longitude ) ;
        $stmt->bindParam(":placeId" , $this->placeId ) ;
        $stmt->bindParam(":propertyId" , $this->propertyId ) ;
        $stmt->bindParam(":pincodeId" , $this->pincodeId) ;
        if($stmt->execute())
            return true ;

        return false ;
    }
}