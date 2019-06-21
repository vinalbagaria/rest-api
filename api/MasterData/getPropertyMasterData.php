<?php

require_once 'updateMasterData.php';
class GetPropertyMasterData
{
    private $conn ;
    private $roleTable = "role" ;
    private $amenitiesTable = "amenities" ;
    private $documentTypeTable = "documentType" ;
    private $configurationTable = "configuration" ;
    private $propertyTypeTable = "propertyType" ;
    private $socialMediaTable = "socialMedia";
    private $unitTable = "unit";
    private $updateMaster ;
    
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
            $this->updateMaster->addDocumentType($unitName);
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
        $query = "SELECT  amenityId from $this->amenitiesTable WHERE amenity  = :amenity ";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":amenity ",$amenity );
        $stmt->execute();
        $existAmenity=$stmt->fetch(PDO::FETCH_ASSOC);

        if(!$existAmenity)
        {
            $this->updateMaster->addAmenity($amenity);
            $stmt->execute();
            $existAmenity=$stmt->fetch(PDO::FETCH_ASSOC);

        }
        return $existAmenity["amenity"];
    }
}

