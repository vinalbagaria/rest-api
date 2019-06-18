<?php



class RegisterProperty
{
    private $propertyDetailsTable = "propertyDetails" ;
    private $propertyTypeTable = "propertyType" ;
    private $configurationTable = "configuration" ;
    private $userTable = "user" ;
    private $userRoleTable = "userRole" ;

    public $propertyName ;
    public $propertyStatus ;
    public $reraNo ;
    public $propertyTypeId;
    public $propertyType ;
    public $configuration ;
    public $configurationId ;
    public $userId;
    public $developerId;
    public $floorNo ;
    public $floors;
    public $carParking ;
    public $furnishedType;
    public $ageOfProperty;
    public $description;
    public $possessionDate;
    public $facing;
    public $noOfBathrooms;
    public $noOfBalconies;



    function __construct($db)
    {
        $this->conn = $db ;
    }
    

    function registerProperty()
    {

    }
}