<?php
include_once '../MasterData/getMasterData.php';

class Register
{
    //database connection and table name
    private $conn;
    private $user = "user";
    private $userAddress = "userAddress";
    private $userCredentials = "userCredentials";
    private $countryTable = "country";
    private $stateTable = "state";
    private $cityTable = "city";
    private $pincodeTable = "pincode";

    //object properties
    public $firstName;
    public $lastName;
    public $contactNo;
    public $emailId;
    public $password;

    public $userId;
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
    public $master;

    // constructor with $db as database connection
    public function __construct($db)
    {
        $this->conn = $db;
        $this->master=new GetMasterData($this->conn);
    }

    public function getUserId()
    {
        $userIdFetch ="SELECT userId FROM $this->user WHERE contactNo=:contactNo";
        $userIdFetchx=$this->conn->prepare($userIdFetch);
        $userIdFetchx->bindParam(":contactNo",$this->contactNo);
        $userIdFetchx->execute();
        $forUserId = $userIdFetchx->fetch(PDO::FETCH_ASSOC);
        $this->userId=$forUserId["userId"];
        echo json_encode(array("message"=> $this->userId) );
    }

    function registerUser(){


        //INSERT STATEMENTS
        $query1= "INSERT INTO  $this->user (firstName,lastName,contactNo,emailId,countryId) VALUES(:firstName,:lastName,:contactNo,:emailId,:countryId)";

        $query2="INSERT INTO $this->userAddress(userId,line1,line2,latitude,longitude,placeId,pincodeId) VALUES (:userId,:line1,:line2,:latitude,:longitude,:placeId,:pincodeId)";

        $query3="INSERT INTO $this->userCredentials(userId,password) VALUES(:userId,:password)";

        //PREPARE STATEMENTS
        $stmt1= $this->conn->prepare($query1);
        $stmt2= $this->conn->prepare($query2);
        $stmt3= $this->conn->prepare($query3);

        //SANITIZE
        //FOR USER DETAILS
        $this->firstName=htmlspecialchars(strip_tags($this->firstName));
        $this->lastName=htmlspecialchars(strip_tags($this->lastName));
        $this->contactNo=htmlspecialchars(strip_tags($this->contactNo));
        $this->emailId=htmlspecialchars(strip_tags($this->emailId));

        //FOR COUNTRY
        $this->countryId=htmlspecialchars(strip_tags(($this->master)->getCountryId($this->country)));
        echo json_encode(array("message" => $this->countryId));

        //FOR STATE
        $this->state=htmlspecialchars(strip_tags($this->state));
        $this->stateId=htmlspecialchars(strip_tags(($this->master)->getStateId($this->state , $this->countryId)));
        echo json_encode(array("message" => $this->stateId));

        //FOR CITY
        $this->city=htmlspecialchars(strip_tags($this->city));
        $this->cityId=htmlspecialchars(strip_tags(($this->master)->getCityId($this->city , $this->stateId)));
        echo json_encode(array("message" => $this->cityId));

        //FOR PINCODE
        $this->pincode=htmlspecialchars(strip_tags($this->pincode));
        $this->pincodeId=htmlspecialchars(strip_tags(($this->master)->getpincodeId($this->pincode , $this->cityId)));
        echo json_encode(array("message" => $this->pincodeId));

        //FOR REMAINING ADDRESS
        $this->line1=htmlspecialchars(strip_tags($this->line1));
        $this->line2=htmlspecialchars(strip_tags($this->line2));
        $this->latitude=htmlspecialchars(strip_tags($this->latitude));
        $this->longitude=htmlspecialchars(strip_tags($this->longitude));
        $this->placeId=htmlspecialchars(strip_tags($this->placeId));

        //FOR PASSWORD
        $this->password=htmlspecialchars(strip_tags($this->password));

        //BINDING PARAMETERS
        //USER TABLE
        $stmt1->bindParam(":firstName", $this->firstName);
        $stmt1->bindParam(":lastName", $this->lastName);
        $stmt1->bindParam(":contactNo", $this->contactNo);
        $stmt1->bindParam(":emailId", $this->emailId);
        $stmt1->bindParam(":countryId", $this->countryId);

        if($stmt1->execute())
        {
            $this->getUserId();

            //USER ADDRESS TABLE
            $stmt2->bindParam(":userId", $this->userId);
            $stmt2->bindParam(":line1", $this->line1);
            $stmt2->bindParam(":line2", $this->line2);
            $stmt2->bindParam(":latitude", $this->latitude);
            $stmt2->bindParam(":longitude", $this->longitude);
            $stmt2->bindParam(":placeId", $this->placeId);

            $stmt2->bindParam(":pincodeId", $this->pincodeId);

            //USER CREDENTIALS TABLE
            $stmt3->bindParam("userId", $this->userId);
            $stmt3->bindParam("passwod", $this->password);

            //EXECUTE STATEMENTS


            if ( $stmt2->execute() && $stmt3->execute())
                return true;
            else
            {
                $query4 = "DELETE FROM $this->user WHERE userId = :userId " ;
                $stmt4 = $this->conn->prepare($query4) ;
                $stmt4->bindParam(":userId" , $this->userId ) ;
                $stmt4->execute();

                return false ;

            }

        }
        return false ;
    }
}