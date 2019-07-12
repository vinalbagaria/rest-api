<?php
require_once 'updateMasterData.php';

class   GetMasterData
{
    // DATABSAE CONNECTION WITH TABLE NAMES
    private $conn;
    private $countryTable = "country";
    private $stateTable = "state";
    private $cityTable = "city";
    private $pincodeTable = "pincode";
    private $updateMaster;
    private $roleTable = "role" ;
    private $amenitiesTable = "amenities" ;
    private $documentTypeTable = "documentType" ;
    private $configurationTable = "configuration" ;
    private $propertyTypeTable = "propertyType" ;
    private $socialMediaTable = "socialMedia";
    private $unitTable = "unit";
    private $propertyAddressTable = "propertyAddress" ;

    // CONSTRUCTOR WITH $db AS DATABASE CONNECTION
    public function __construct($db)
    {
        $this->conn = $db;
        $this->updateMaster = new UpdateMasterData( $db );        // OBJECT OF UpdateMasterData
    }

    //FUNCTION FOR GETTING COUNTRYID
    public function getCountryId($country)
    {
        $query = "SELECT countryId FROM $this->countryTable WHERE country = :country";
        $countryId = $this->conn->prepare($query);
        $countryId->bindParam(":country", $country);
        $countryId->execute();
        $forCountry = $countryId->fetch(PDO::FETCH_ASSOC);
        return $forCountry["countryId"];
    }

    //FUNCTION FOR GETTING STATEID
    public function getStateId($state , $countryId)
    {
        $query="SELECT stateId FROM $this->stateTable WHERE state = :state";
        $existState = $this->conn->prepare($query);
        $existState->bindParam(":state",  $state);
        $existState->execute();
        $stateExist = $existState->fetch(PDO::FETCH_ASSOC);

        if(!$stateExist)
        {
            $this->updateMaster->addState($state, $countryId);
            $existState->execute();
            $stateExist = $existState->fetch(PDO::FETCH_ASSOC);
        }
        return $stateExist["stateId"];
    }

    //FUNCTION FOR GETTING CITYID
    public function getCityId($city, $stateId)
    {
        $existCity = "SELECT cityId FROM  $this->cityTable WHERE city=:city";
        $existCity = $this->conn->prepare($existCity);
        $existCity->bindParam(":city",$city);
        $existCity->execute();
        $cityExist = $existCity->fetch(PDO::FETCH_ASSOC);

        if(!$cityExist)
        {
            $this->updateMaster->addCity($city, $stateId) ;
            $existCity->execute();
            $cityExist=$existCity->fetch(PDO::FETCH_ASSOC);
        }
        return $cityExist["cityId"];
    }

    //FUNCTION FOR GETTING PINCODEID
    public function getPincodeId($pincode, $cityId )
    {
        $query = "SELECT pincodeId FROM $this->pincodeTable WHERE pincode = :pincode" ;
        $existPincodeId = $this->conn->prepare($query);
        $existPincodeId->bindParam(":pincode",$pincode);
        $existPincodeId->execute();
        $pincodeExist = $existPincodeId->fetch(PDO::FETCH_ASSOC);

        if(!$pincodeExist)
        {
            $this->updateMaster->addPincode($pincode , $cityId);
            $existPincodeId->execute();
            $pincodeExist = $existPincodeId->fetch(PDO::FETCH_ASSOC);
        }
        return $pincodeExist["pincodeId"];
    }

    //FUNCTION FOR GETTING LIST OF COUNTRIES
    public function getCountries()
    {
        $query = " SELECT country FROM $this->countryTable ";
        $exist = $this->conn->prepare($query);
        $exist->execute();
        while($row = $exist->fetch(PDO::FETCH_ASSOC)){
            $data[]=$row["country"];
        }
        return $data;
    }

    //FUNCTION FOR GETTING LIST OF ROLES
    public function getRoles()
    {
        $query = " SELECT roleType FROM $this->roleTable ";
        $exist = $this->conn->prepare($query);
        $exist->execute();
        while($row = $exist->fetch(PDO::FETCH_ASSOC)){
            $data[]=$row["roleType"];

        }
        return $data;
    }

    //FUNCTION FOR GETTING LIST OF DOCUMENTS
    public function getDocuments()
    {
        $query = " SELECT documentName FROM  $this->documentTypeTable";
        $exist = $this->conn->prepare($query);
        $exist->execute();
        while($row = $exist->fetch(PDO::FETCH_ASSOC)){
            $data[]=$row["documentName"];

        }
        return $data;
    }

    //FUNCTION FOR GETTING LIST OF UNITS
    public function getUnits()
    {
        $query = " SELECT unitName FROM $this->unitTable";
        $exist = $this->conn->prepare($query);
        $exist->execute();
        while($row = $exist->fetch(PDO::FETCH_ASSOC)){
            $data[]=$row["unitName"];
        }
        return $data;
    }

    //FUNCTION FOR GETTING LIST OF AMENITIES
    public function getAmenities()
    {
        $query = " SELECT amenity FROM  $this->amenitiesTable";
        $exist = $this->conn->prepare($query);
        $exist->execute();
        while($row = $exist->fetch(PDO::FETCH_ASSOC)){
            $data[]=$row["amenity"];
        }
        return $data;
    }

    //FUNCTION FOR GETTING LIST OF PROPERTY TYPE
    public function getPropertyType()
    {
        $query = " SELECT propertyType FROM  $this->propertyTypeTable";
        $exist = $this->conn->prepare($query);
        $exist->execute();
        while($row = $exist->fetch(PDO::FETCH_ASSOC)){
            $data[]=$row["propertyType"];
        }
        return $data;
    }

    //FUNCTION FOR GETTING LIST OF CONFIGURATIONS
    public function getConfiguration()
    {
        $query = " SELECT configurationType FROM  $this->configurationTable";
        $exist = $this->conn->prepare($query);
        $exist->execute();
        while($row = $exist->fetch(PDO::FETCH_ASSOC)){
            $data[]=$row["configurationType"];
        }
        return $data;
    }

    //FUNCTION FOR GETTING LIST OF SOCIAL MEDIA NAMES
    public function getSocialMediaName()
    {
        $query = " SELECT socialMediaName FROM $this->socialMediaTable";
        $exist = $this->conn->prepare($query);
        $exist->execute();
        while($row = $exist->fetch(PDO::FETCH_ASSOC)){
            $data[]=$row["socialMediaName"];
        }
        return $data;
    }

    //FUNCTION FOR GETTING LIST OF STATES
    public function getStates( $countryId )
    {
        $query = "SELECT state FROM $this->stateTable WHERE countryId = :countryId";
        $exist = $this->conn->prepare($query);
        $exist->bindParam(":countryId",$countryId);
        $exist->execute();
        while($row = $exist->fetch(PDO::FETCH_ASSOC)){
            $data[]=$row["state"];
        }
        return $data;
    }

    //FUNCTION FOR GETTING LIST OF CITIES
    public function getCities($stateId)
    {
        $query = " SELECT city FROM $this->cityTable WHERE stateId = :stateId ";
        $exist = $this->conn->prepare($query);
        $exist->bindParam(":stateId",$stateId);
        $exist->execute();
        while($row = $exist->fetch(PDO::FETCH_ASSOC)){
            $data[]=$row["city"];
        }
        return $data;
    }

    public function getCountry($countryId)
    {
        $query = "SELECT country FROM $this->countryTable WHERE countryId = :countryId";
        $exist = $this->conn->prepare($query);
        $exist->bindParam(":countryId",$countryId);
        $exist->execute();
        while($row = $exist->fetch(PDO::FETCH_ASSOC)){
            $data = $row ;
        }
        return $data ;
    }
    //FUNCTION TO GET PINCODE USING PINCODE ID
    function getPincode($pincodeId)
    {
        $query = "SELECT pincode,cityId FROM $this->pincodeTable WHERE pincodeId = :pincodeId " ;
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":pincodeId" , $pincodeId);
        $stmt->execute();
        $data = $stmt->fetch(PDO::FETCH_ASSOC) ;
        return $data ;
    }

    //FUNCTION TO GET CITY USING CITY ID
    function getCity($cityId)
    {
        $query = "SELECT city,stateId FROM $this->cityTable WHERE cityId = :cityId " ;
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":cityId" , $cityId);
        $stmt->execute();
        $data = $stmt->fetch(PDO::FETCH_ASSOC) ;
        return $data ;
    }

    //FUNCTION TO GET STATE USING STATE ID
    function getState($stateId)
    {
        $query = "SELECT state,countryId FROM $this->stateTable WHERE stateId = :stateId " ;
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":stateId" , $stateId);
        $stmt->execute();
        $data = $stmt->fetch(PDO::FETCH_ASSOC) ;
        return $data ;
    }
}
