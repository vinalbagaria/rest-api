<?php


include_once '../MasterData/getPropertyMasterData.php';

class RegisterPropertyDetails
{
    private $propertyDetailsTable = "propertyDetails" ;
    private $propertyTypeTable = "propertyType" ;
    private $configurationTable = "configuration" ;
    private $userTable = "user" ;
    private $userRoleTable = "userRole" ;
    private $roletable = "role";

    public $propertyName ;
    public $propertyStatus ;
    public $reraNo ;
    public $propertyTypeId;
    public $propertyType ;
    public $configurationType ;
    public $configurationId ;
    public $userId;
    public $userRoleId;
    public $roleType;
    public $developerId;
    public $floorNo ;
    public $floors;
    public $carParking;
    public $furnishedType;
    public $ageOfProperty;
    public $info;
    public $possessionDate;
    public $facing;
    public $noOfBathrooms;
    public $noOfBalconies;



    function __construct($db)
    {
        $this->conn = $db ;
        $this->master=new GetPropertyMasterData($this->conn);
    }
    
    //function to register the property
    function registerProperty()
    {
        $query = "INSERT INTO $this->propertyDetailsTable(propertyName,propertyStatus,reraNo,propertyTypeId,configurationId,userId,userRoleId,floorNo,floors,carParking,furnishedType,ageOfProperty,info,possessionDate,facing,noOfBathrooms,noOfBalconies) VALUES(:propertyName,:propertyStatus,:reraNo,:propertyTypeId,
        :configurationId,:userId,:userRoleId,:floorNo,:floors,:carParking,:furnishedType,:ageOfProperty,:info,
       :possessionDate,:facing,:noOfBathrooms,:noOfBalconies)";
       $stmt = $this->conn->prepare($query);
        
        //sanitize
        $this->propertyName = htmlspecialchars(strip_tags($this->propertyName));
        echo json_encode(array("message" => $this->propertyName));

        $this->propertyStatus = htmlspecialchars(strip_tags($this->propertyStatus));
        echo json_encode(array("message" => $this->propertyStatus));

        $this->reraNo = htmlspecialchars(strip_tags($this->reraNo));
        echo json_encode(array("message" => $this->reraNo));

        $this->propertyTypeId = htmlspecialchars(strip_tags(($this->master)->getPropertyTypeId($this->propertyType)));
        echo json_encode(array("message" => $this->propertyTypeId));

        $this->configurationId = htmlspecialchars(strip_tags(($this->master)->getConfigurationId($this->configurationType)));
        echo json_encode(array("message" => $this->configurationId));

        $this->userId = htmlspecialchars(strip_tags($this->userId));
        echo json_encode(array("message" => $this->userId));


        $this->userRoleId = htmlspecialchars(strip_tags(($this->master)->getRoleId($this->roleType)));
        echo json_encode(array("message" => $this->userRoleId));

        $this->floors = htmlspecialchars(strip_tags($this->floors));
        echo json_encode(array("message" => $this->floors));
        
        $this->floorNo = htmlspecialchars(strip_tags($this->floorNo));
        echo json_encode(array("message" => $this->floorNo));

        $this->carParking = htmlspecialchars(strip_tags($this->carParking));
        echo json_encode(array("message" => $this->carParking));

        $this->furnishedType = htmlspecialchars(strip_tags($this->furnishedType));
        echo json_encode(array("message" => $this->furnishedType));

        $this->ageOfProperty = htmlspecialchars(strip_tags($this->ageOfProperty));
        echo json_encode(array("message" => $this->ageOfProperty));

        $this->info = htmlspecialchars(strip_tags($this->info));
        echo json_encode(array("message" => $this->info));

        

        $this->possessionDate = htmlspecialchars(strip_tags($this->possessionDate));
        echo json_encode(array("message" => $this->possessionDate));


        $this->facing = htmlspecialchars(strip_tags($this->facing));
        echo json_encode(array("message" => $this->facing));


        $this->noOfBathrooms = htmlspecialchars(strip_tags($this->noOfBathrooms));
        echo json_encode(array("message" => $this->noOfBathrooms));

        $this->noOfBalconies = htmlspecialchars(strip_tags($this->noOfBalconies));
        echo json_encode(array("message" => $this->noOfBalconies));

        // $this->developerId = htmlspecialchars(strip_tags($this->developerId));
        // echo json_encode(array("message" => $this->developerId));


        //binding
        
        $stmt->bindParam(":propertyName", $this->propertyName);
        $stmt->bindParam(":propertyStatus", $this->propertyStatus);
        $stmt->bindParam(":reraNo", $this->reraNo);
        $stmt->bindParam(":propertyTypeId", $this->propertyTypeId);
        $stmt->bindParam(":configurationId", $this->configurationId);
        $stmt->bindParam(":userId", $this->userId);
        $stmt->bindParam(":userRoleId", $this->userRoleId);
     //  $stmt->bindParam(":developerId", $this->developerId);
       
       
        $stmt->bindParam(":floorNo", $this->floorNo);
        $stmt->bindParam(":floors", $this->floors);
        $stmt->bindParam(":carParking", $this->carParking);
        $stmt->bindParam(":furnishedType", $this->furnishedType);
        $stmt->bindParam(":ageOfProperty", $this->ageOfProperty);
        $stmt->bindParam(":info", $this->info);
     
        $stmt->bindParam(":possessionDate", $this->possessionDate);
        $stmt->bindParam(":facing", $this->facing);
        $stmt->bindParam(":noOfBathrooms", $this->noOfBathrooms);
        $stmt->bindParam(":noOfBalconies", $this->noOfBalconies);


        if( $stmt->execute()){

            return true;
        }
        else{
            return false;
        }
    
    }
}