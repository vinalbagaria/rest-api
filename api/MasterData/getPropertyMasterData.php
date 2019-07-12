<?php
require_once 'updateMasterData.php';

class GetPropertyMasterData
{
    // DATABASE CONNECTION AND TABLE NAME
    private $conn ;
    private $roleTable = "role" ;
    private $amenitiesTable = "amenities" ;
    private $documentTypeTable = "documentType" ;
    private $configurationTable = "configuration" ;
    private $propertyTypeTable = "propertyType" ;
    private $socialMediaTable = "socialMedia";
    private $unitTable = "unit";
    private $userRoleTable = "userRole";

    private $updateMaster ;

    // CONSTRUCTOR WITH $db AS DATABASE CONNECTION
    public function __construct($db)
    {
        $this->conn = $db;
        $this->updateMaster = new UpdateMasterData($db);
    }

    // GET ROLE ID USING ROLETYPE
    function getRoleId($roleType)
    {
        $query = "SELECT roleId FROM $this->roleTable WHERE roleType = :roleType " ;
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":roleType" , $roleType );
        $stmt->execute();
        $existRole = $stmt->fetch(PDO::FETCH_ASSOC);
        if(!$existRole)
        {
            $this->updateMaster->addUserRole($roleType);
            $stmt->execute();
            $existRole = $stmt->fetch(PDO::FETCH_ASSOC);
        }
        return $existRole["roleId"] ;
    }

    // GET CONFIGURATION ID USING CONFIGURATION TYPE
    function getConfigurationId($configurationType)
    {
        $query = "SELECT configurationId from $this->configurationTable WHERE configurationType = :configurationType";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":configurationType",$configurationType);
        $stmt->execute();
        $existConfiguration=$stmt->fetch(PDO::FETCH_ASSOC);

        if(!$existConfiguration)
        {
            $this->updateMaster->addConfigurationType($configurationType);
            $stmt->execute();
            $existConfiguration=$stmt->fetch(PDO::FETCH_ASSOC);
        }
        return $existConfiguration["configurationId"];
    }

    //GET PROPERTY TYPE ID USING PROPERTY TYPE
    function getPropertyTypeId($propertyType)
    {
        $query = "SELECT propertyTypeId from $this->propertyTypeTable WHERE propertyType = :propertyType";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":propertyType",$propertyType);
        $stmt->execute();
        $existPropertyType=$stmt->fetch(PDO::FETCH_ASSOC);

        if(!$existPropertyType)
        {
            $this->updateMaster->addPropertyType($propertyType);
            $stmt->execute();
            $existPropertyType=$stmt->fetch(PDO::FETCH_ASSOC);
        }
        return $existPropertyType["propertyTypeId"];
    }

    //GET DOCUMENT TYPE ID USING DOCUMENT NAME
    function getDocumentTypeId($documentName)
    {
        $query = "SELECT documentTypeId from $this->documentTypeTable WHERE documentName = :documentName";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":documentName",$documentName);
        $stmt->execute();
        $existDocumentName=$stmt->fetch(PDO::FETCH_ASSOC);

        if(!$existDocumentName)
        {
            $this->updateMaster->addDocumentType($documentName);
            $stmt->execute();
            $existDocumentName=$stmt->fetch(PDO::FETCH_ASSOC);
        }
        return $existDocumentName["documentTypeId"];
    }

    //GET UNIT ID FROM UNIT NAME
    function getUnitId($unitName)
    {
        $query = "SELECT unitId from $this->unitTable WHERE unitName = :unitName";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":unitName",$unitName);
        $stmt->execute();
        $existUnitName=$stmt->fetch(PDO::FETCH_ASSOC);

        if(!$existUnitName)
        {
            $this->updateMaster->addUnit($unitName);
            $stmt->execute();
            $existUnitName=$stmt->fetch(PDO::FETCH_ASSOC);
        }
        return $existUnitName["unitId"];
    }

    //GET  SOCIAL MEDIA ID USING SOCIAL MEDIA NAME
    function getSocialMediaId($socialMediaName)
    {
        $query = "SELECT socialMediaId from $this->socialMediaTable WHERE socialMediaName  = :socialMediaName ";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":socialMediaName ",$socialMediaName );
        $stmt->execute();
        $existSocialMediaName=$stmt->fetch(PDO::FETCH_ASSOC);

        if(!$existSocialMediaName)
        {
            $this->updateMaster->addSocialMedia($socialMediaName);
            $stmt->execute();
            $existSocialMediaName=$stmt->fetch(PDO::FETCH_ASSOC);
        }
        return $existSocialMediaName["socialMediaId"];
    }

    //GET AMENITIY ID USING AMENITY NAME
    function getAmenityId($amenity)
    {
        $query = "SELECT amenityId from $this->amenitiesTable WHERE amenity = :amenity ";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":amenity",$amenity);
        $stmt->execute();
        $existAmenity=$stmt->fetch(PDO::FETCH_ASSOC);

        if(!$existAmenity)
        {
            $this->updateMaster->addAmenity($amenity);
            $stmt->execute();
            $existAmenity=$stmt->fetch(PDO::FETCH_ASSOC);
        }
        return $existAmenity["amenityId"];
    }
    function getUnit($unitId)
    {
        $query = "SELECT unitName FROM $this->unitTable WHERE unitId = :unitId ";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":unitId",$unitId);
        $stmt->execute();
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        return $data;
    }

    // GET CONFIGURATION FOR A PARTICULAR CONFIGURATION ID
    function getConfiguration($configurationId)
    {
        $query = "SELECT configuration FROM $this->configurationTable WHERE configurationId = :configurationId ";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":configurationId",$configurationId);
        $stmt->execute();
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        return $data;
    }

    // GET PROPERTY TYPE FOR A PARTICULAR PROPERTY TYPE ID
    function getPropertyType($propertyTypeId)
    {
        $query = "SELECT propertyType FROM $this->propertyTypeTable WHERE propertyTypeId = :propertyTypeId ";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":propertyTypeId",$propertyTypeId);
        $stmt->execute();
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        return $data;
    }

    //FUNCTION TO GET ROLE OF A USER
    function getRoleType($userRoleId)
    {
        $query = "SELECT roleType from $this->roleTable WHERE roleId IN (SELECT roleId FROM $this->userRoleTable WHERE userRoleId = :userRoleId)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":userRoleId",$userRoleId);
        $stmt->execute();
        $data=$stmt->fetch(PDO::FETCH_ASSOC);
        return $data ;
    }
}
