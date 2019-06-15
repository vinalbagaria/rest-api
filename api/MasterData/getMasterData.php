<?php


include_once 'updateMasterData.php';

class GetMasterData
{
    private $conn;
    private $user = "user";
    private $userAddress = "userAddress";
    private $userCredentials = "userCredentials";
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

    public function __construct($db)
    {
        $this->conn = $db;
        $this->updateMaster = new UpdateMasterData( $db ) ;
    }

    //function for getting countryId
    public function getCountryId($country)
    {
        $query = "SELECT countryId FROM $this->countryTable WHERE country = :country";
        $countryId = $this->conn->prepare($query);
        $countryId->bindParam(":country", $country);
        $countryId->execute();
        $forCountry = $countryId->fetch(PDO::FETCH_ASSOC);

        return $forCountry["countryId"];
    }

    //function for getting stateId
    public function getStateId($state , $countryId)
    {
        $query="SELECT stateId FROM $this->stateTable WHERE state = :state";
        $exist1= $this->conn->prepare($query);
        $exist1->bindParam(":state",  $state);
        $exist1->execute();
        $stateExist=$exist1->fetch(PDO:: FETCH_ASSOC);

        if( !$stateExist )
        {
            $this->updateMaster->addState($state, $countryId);

            $exist1->execute();
            $stateExist = $exist1->fetch(PDO::FETCH_ASSOC);
        }
        return $stateExist["stateId"];

    }

    //function for getting cityId
    public function getCityId($city , $stateId)
    {
        $existCity = "SELECT cityId FROM  $this->cityTable WHERE city=:city";
        $exist2 = $this->conn->prepare($existCity);
        $exist2->bindParam(":city",$city);
        $exist2->execute();
        $cityExist = $exist2->fetch(PDO::FETCH_ASSOC);

        if(!$cityExist)
        {
            $this->updateMaster->addCity($city,$stateId) ;

            $exist2->execute();
            $cityExist=$exist2->fetch(PDO::FETCH_ASSOC);
        }
        return $cityExist["cityId"];
    }

    //function for getting pincodeId
    public function getPincodeId( $pincode ,$cityId )
    {
        $query = "SELECT pincodeId FROM $this->pincodeTable WHERE pincode=:pincode" ;
        $exist3 = $this->conn->prepare($query);
        $exist3->bindParam(":pincode",$pincode);
        $exist3->execute();

        $pincodeExist = $exist3->fetch(PDO::FETCH_ASSOC);
        if(!$pincodeExist)
        {
            $this->updateMaster->addPincode($pincode, $cityId);
            $exist3->execute();
            $pincode = $exist3->fetch(PDO::FETCH_ASSOC);
        }
        return $pincode["pincodeId"];
    }

    //function for getting list of countries
    public function getCountries()
    {
        $query = " SELECT country FROM $this->countryTable ";
        $exist = $this->conn->prepare($query);
        $exist->execute();
        while($row = $exist->fetch(PDO::FETCH_ASSOC)){
            $data[]=$row;
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
             $data[]=$row;
             
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
              $data[]=$row;
              
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
              $data[]=$row;   
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
              $data[]=$row;
              
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
              $data[]=$row;
              
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
               $data[]=$row;
               
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
                $data[]=$row;
                
            }
            return $data;
        }

    //function for getting list of states
    public function getStates( $countryId )
    {
        $query = "SELECT state FROM $this->stateTable WHERE countryId = :countryId";
        $exist = $this->conn->prepare($query);
        $exist->bindParam(":countryId",$countryId);
        $exist->execute();
        while($row = $exist->fetch(PDO::FETCH_ASSOC)){
            $data[]=$row;
        }
        return $data;
    }

    //function for getting list of cities
    public function getCities( $stateId )
    {
        $query = " SELECT city FROM $this->cityTable WHERE stateId = :stateId ";
        $exist = $this->conn->prepare($query);
        $exist->bindParam(":stateId",$stateId);
        $exist->execute();
        while($row = $exist->fetch(PDO::FETCH_ASSOC)){
            $data[]=$row;
        }
        return $data;
    }

}