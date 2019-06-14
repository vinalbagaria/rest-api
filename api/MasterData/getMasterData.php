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

    public function __construct($db)
    {
        $this->conn = $db;
        $this->updateMaster = new UpdateMasterData( $db ) ;
    }

    //function for getting countryId
    public function getCountryId($country)
    {
        $query = "SELECT countryId FROM $this->countryTable WHERE country=:country";
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
            $this->updateMaster->updateState($state,$countryId);
        $exist1->execute();
        $stateExist=$exist1->fetch(PDO::FETCH_ASSOC);
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
            $query4 = "INSERT INTO $this->cityTable(city,stateId) VALUES (:city,:stateId)";
            $stmt4 = $this->conn->prepare($query4);
            $stmt4->bindParam(":city", $city);
            $stmt4->bindParam(":stateId", $stateId);
            $stmt4->execute();
        }

        $exist2->execute();
        $cityExist=$exist2->fetch(PDO::FETCH_ASSOC);
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
            $query5 = "INSERT INTO $this->pincodeTable(pincode,cityId) VALUES (:pincode,:cityId)";
            $stmt5 = $this->conn->prepare($query5);
            $stmt5-> bindParam(":pincode",$pincode);
            $stmt5-> bindParam(":cityId",$cityId);
            $stmt5-> execute();
        }
        $exist3->execute();
        $pincode = $exist3->fetch(PDO::FETCH_ASSOC);
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