<?php

require_once '../MasterData/getMasterData.php';

class updateProfile
{
    private $user = "user" ;
    private $userAddress = "userAddress" ;
    private $pincode = "pincode" ;
    private $city = "city" ;
    private $state = "state" ;
    private $country = "country" ;
    private $conn;
    private $master;
    private $pincodeId;
    private $cityId;
    private $stateId;
    private $countryId;

    public function __construct($db)
    {
        $this->conn = $db;
        $this->master = new GetMasterData($db);
    }

    public function changeFirstName($userId,$firstName)         //Update First Name
    {
        $query = "UPDATE $this->user SET firstName = :firstName WHERE userId = :userId";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":firstName",$firstName );
        $stmt->bindParam(":userId",$userId);

        if($stmt->execute())
            return true;
        else
            return false;

    }
    public function changeLastName($userId,$lastName)           //Update Last Name
    {
        $query = "UPDATE $this->user SET lastName = :lastName WHERE userId = :userId";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":lastName",$lastName );
        $stmt->bindParam(":userId",$userId);

        if($stmt->execute())
            return true;
        else
            return false;
    }
    public function changeEmailId($userId,$emailId)             //Update emailId
    {
       // call to verify otp from emailId
        $query = "UPDATE $this->user SET emailId = :emailId WHERE userId = :userId";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":emailId",$emailId );
        $stmt->bindParam(":userId",$userId);

        if($stmt->execute())
            return true;
        else
            return false;
    }
    public function changeContactNo($userId,$contactNo)             //Update Contact No
    {
//        Call to verify otp from mobile no.

        $query = "UPDATE $this->user SET contactNo = :contactNo WHERE userId = :userId";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":contactNo",$contactNo );
        $stmt->bindParam(":userId",$userId);

        if($stmt->execute())
            return true;
        else
            return false;

    }
    public function changeAddress($userAddressId,$line1,$line2,$latitude,$longitude,$placeId)   //Update address
    {
        $query = "UPDATE $this->userAddress SET line1 = :line1 , line2 = :line2 , latitude = :latitude ,
                                                longitude = :longitude , placeId = :placeId WHERE userAddressId = :userAddressId";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":userAddressId" , $userAddressId );
        $stmt->bindParam(":line1" , $line1 );
        $stmt->bindParam(":line2" , $line2 );
        $stmt->bindParam(":latitude" , $latitude );
        $stmt->bindParam(":longitude" , $longitude );
        $stmt->bindParam(":placeId" , $placeId );

        if($stmt->execute())
            return true;
        else
            return false;
    }
    public function changePincodeId( $userAddressId , $pincode , $city , $state , $country )
    {
        //        get pincode id from getMasterData.php
        $this->countryId = $this->master->getCountryId( $country ) ;
        $this->stateId = $this->master->getStateId( $state , $this->countryId ) ;
        $this->cityId = $this->master->getCityId( $city , $this->stateId ) ;
        $this->pincodeId = $this->master->getPincodeId( $pincode,$this->cityId ) ;
        $query = "UPDATE $this->userAddress SET pincodeId=:pincodeId WHERE userAddressId = :userAddressId " ;
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":userAddressId" , $userAddressId) ;
        $stmt->bindParam(":pincodeId" , $this->pincodeId) ;
        $stmt->execute();

    }
    public function changeCountryId($userId,$country)
    {
        //        get country id from getMasterData.php
        $this->countryId = $this->master->getCountryId($country);
        //Update country id for state table

        //Update country id for user table
        $query2 = "UPDATE $this->user SET countryId = :countryId WHERE userId = :userId " ;
        $stmt2 = $this->conn->prepare($query2);
        $stmt2->bindParam(":countryId" , $this->countryId ) ;
        $stmt2->bindParam(":userId" , $userId ) ;
        $stmt2->execute();
    }
}