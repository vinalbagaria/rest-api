<?php
include_once '../MasterData/getMasterData.php';

class Register
{
    //database connection and table name
    private $conn;
    private $userTable = "user";
    private $userAddressTable = "userAddress";
    private $userCredentialsTable = "userCredentials";


    //OBJECT PROPERTIES
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

    //OBJECT OF GETMASTERDATA TABLE
    public $master;

    // constructor with $db as database connection
    public function __construct($db)
    {
        $this->conn = $db;
        $this->master=new GetMasterData($this->conn);
    }

    public function getUserId()
    {
        $userIdFetch ="SELECT userId FROM $this->userTable WHERE contactNo=:contactNo";
        $userIdFetchx=$this->conn->prepare($userIdFetch);
        $userIdFetchx->bindParam(":contactNo",$this->contactNo);
        $userIdFetchx->execute();
        $forUserId = $userIdFetchx->fetch(PDO::FETCH_ASSOC);
        $this->userId=$forUserId["userId"];
    }
    function registerUser()
    {
        $query1 = "INSERT INTO  $this->userTable (firstName,lastName,contactNo,emailId,countryId) VALUES(:firstName,:lastName,:contactNo,:emailId,:countryId)";
        $query2 ="INSERT INTO $this->userCredentialsTable(userId,password) VALUES(:userId,:password)";

        $stmt1 = $this->conn->prepare($query1);
        $stmt2 = $this->conn->prepare($query2);

        $this->firstName = htmlspecialchars(strip_tags($this->firstName));
        $this->lastName = htmlspecialchars(strip_tags($this->lastName));
        $this->contactNo = htmlspecialchars(strip_tags($this->contactNo));
        $this->emailId = htmlspecialchars(strip_tags($this->emailId));
        $this->countryId = htmlspecialchars(strip_tags(($this->master)->getCountryId($this->country)));
        $this->password = htmlspecialchars(strip_tags($this->password));

        $stmt1->bindParam(":firstName", $this->firstName);
        $stmt1->bindParam(":lastName", $this->lastName);
        $stmt1->bindParam(":contactNo", $this->contactNo);
        $stmt1->bindParam(":emailId", $this->emailId);
        $stmt1->bindParam(":countryId", $this->countryId);

        if($stmt1->execute())
        {
            $this->getUserId();
            $stmt2->bindParam("userId", $this->userId);
            $stmt2->bindParam("password", $this->password);

            if( $stmt2->execute())
                    return true;
            //IF DATA GETS ONLY INSERTED IN USER TABLE
            else
                {

                }
            }
            return false ;
    }

    // FUNCTION FOR ADDING ADDRESS
    function addUserAddress()
    {
        $query="INSERT INTO $this->userAddressTable(userId,line1,line2,latitude,longitude,placeId,pincodeId) VALUES (:userId,:line1,:line2,:latitude,:longitude,:placeId,:pincodeId)";
        $stmt= $this->conn->prepare($query);
        $this->getUserId();

        $stmt->bindParam(":userId", $this->userId);
        $stmt->bindParam(":line1", $this->line1);
        $stmt->bindParam(":line2", $this->line2);
        $stmt->bindParam(":latitude", $this->latitude);
        $stmt->bindParam(":longitude", $this->longitude);
        $stmt->bindParam(":placeId", $this->placeId);
        $stmt->bindParam(":pincodeId", $this->pincodeId);

        if($stmt->execute())
        {
            return true ;
        }

        return false ;
    }
}
