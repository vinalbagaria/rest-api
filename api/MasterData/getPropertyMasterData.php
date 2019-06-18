<?php

include_once 'updateMasterData.php';
class getPropertyMasterData
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

    function getPropertyTypeId($propertyType)
    {
        $query = "SELECT propertyTypeId from $this->propertyTypeTable WHERE propertyType = :propertyType";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":propertyType",$propertyType);
        $stmt->execute();
        $existPropertyTypeId = $stmt->fetch(PDO::FETCH_ASSOC);

        if(!$existPropertyTypeId)
        {
            $this->updateMaster->addPropertyType($propertyType);
            $stmt->execute();
            $existPropertyTypeId=$stmt->fetch(PDO::FETCH_ASSOC);

        }
        return $existPropertyTypeId["propertyTypeId"];
    }

}

