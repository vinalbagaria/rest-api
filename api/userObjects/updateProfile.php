<?php
require_once '../MasterData/getMasterData.php';

class updateProfile
{
    // DATABASE CONNECTION AND TABLE NAME
    private $userTable = "user" ;
    private $userAddress = "userAddress" ;
    private $conn;
    private $master;
    private $pincodeId;
    private $cityId;
    private $stateId;
    private $countryId;

    // CONSTRUCTOR WITH $db AS DATABASE CONNECTION
    public function __construct($db)
    {
        $this->conn = $db;
        $this->master = new GetMasterData($db);      //OBJECT OF GET MASTER DATA
    }

    //Update First Name
    public function changeFirstName($userId,$firstName)
    {
        $query = "UPDATE $this->userTable SET firstName = :firstName WHERE userId = :userId";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":firstName",$firstName );
        $stmt->bindParam(":userId",$userId);

        if($stmt->execute())
            return true;
        else
            return false;
    }

    //Update Last Name
    public function changeLastName($userId,$lastName)
    {
        $query = "UPDATE $this->userTable SET lastName = :lastName WHERE userId = :userId";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":lastName",$lastName );
        $stmt->bindParam(":userId",$userId);

        if($stmt->execute())
            return true;
        else
            return false;
    }

    //UPDATE EMAIL ID
    public function changeEmailId($userId,$emailId)
    {
        $query = "UPDATE $this->userTable SET emailId = :emailId WHERE userId = :userId";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":emailId",$emailId );
        $stmt->bindParam(":userId",$userId);

        if($stmt->execute())
            return true;
        else
            return false;
    }

    //UPDATE CONTACT NO
    public function changeContactNo($userId,$contactNo)
    {
        $query = "UPDATE $this->userTable SET contactNo = :contactNo WHERE userId = :userId";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":contactNo",$contactNo );
        $stmt->bindParam(":userId",$userId);

        if($stmt->execute())
            return true;
        else
            return false;

    }

    //UPDATE ADDRESS
    public function changeAddress($userAddressId,$line1,$line2,$latitude,$longitude,$placeId)
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

    // TO CHANGE PINCODE ID
    public function changePincodeId( $userId , $pincode , $city , $state , $country )
    {
        $this->countryId = $this->master->getCountryId( $country ) ;
        $this->stateId = $this->master->getStateId( $state , $this->countryId ) ;
        $this->cityId = $this->master->getCityId( $city , $this->stateId ) ;
        $this->pincodeId = $this->master->getPincodeId( $pincode,$this->cityId ) ;
        $query = "UPDATE $this->userAddress SET pincodeId=:pincodeId WHERE userId = :userId " ;
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":userId" , $userId) ;
        $stmt->bindParam(":pincodeId" , $this->pincodeId) ;
        if($stmt->execute())
            return true ;
        else
            return false ;

    }

    // CHANGE COUNTRY ID
    public function changeCountryId($userId,$country)
    {
        $this->countryId = $this->master->getCountryId($country);

        //UPDATE COUNTRY ID FOR USER TABLE
        $query2 = "UPDATE $this->userTable SET countryId = :countryId WHERE userId = :userId " ;
        $stmt2 = $this->conn->prepare($query2);
        $stmt2->bindParam(":countryId" , $this->countryId ) ;
        $stmt2->bindParam(":userId" , $userId ) ;
        $stmt2->execute();
    }

    public function deleteUser($userId)
    {
        $query3 = "DELETE FROM $this->userTable WHERE userId = :userId " ;
        $stmt3 = $this->conn->prepare($query3) ;
        $stmt3->bindParam(":userId" , $userId ) ;
        $stmt3->execute();

        return false ;
    }
}
