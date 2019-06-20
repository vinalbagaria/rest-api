<?php


header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once 'getPropertyMasterData.php';
require_once 'updateMasterData.php';
include '../config/database.php';

$instance = ConnectDb::getInstance();
$db = $instance->getConnection();

$setMaster = new UpdateMasterData($db);
$getPropertyMaster = new getPropertyMasterData($db);
$data = json_decode(file_get_contents("php://input"));


//FOR ADMIN  TO CHECK STATE AND COUNTRY ID
if (
    !empty($data->state) &&
    !empty($data->countryId)
) {
    if ($setMaster->addState($data->state, $data->countryId))
        echo json_encode("State updated successfully");
    else
        echo json_encode("Update Unsuccessful");

}

//if (
//!empty($data->roleType)
//) {
//    if ($setMaster->addUserRole($data->roleType))
//        echo json_encode("Roletype updated successfully");
//    else
//        echo json_encode("Update Unsuccessful");
//}

if (
    !empty($data->amenity)
) {
    if ($setMaster->addAmenity($data->amenity))
        echo json_encode("Amenity uploaded successfully");
    else
        echo json_encode("Update Unsuccessful");
}

if (
    !empty($data->documentName)
) {
    if ($setMaster->addDocumentType($data->documentName))
        echo json_encode("Document uploaded successfully");
    else
        echo json_encode("Update Unsuccessful");
}

if (
    !empty($data->propertyType)
) {
    if ($setMaster->addPropertyType($data->propertyType))
        echo json_encode("Property Type is inserted successfully");
    else
        echo json_encode("cannot be inserted");
}

//if (
//!empty($data->configurationType)
//) {
//    if ($setMaster->addConfigurationType($data->configurationType))
//        echo json_encode("Configuration Type is inserted successfully");
//    else
//        echo json_encode("cannot be inserted");
//}

if (
    !empty($data->socialMediaName)
) {
    if ($setMaster->addSocialMedia($data->socialMediaName))
        echo json_encode("Social Media Type is inserted successfully");
    else
        echo json_encode("cannot be inserted");
}

if (
    !empty($data->unitName)
) {
    if ($setMaster->addUnit($data->unitName))
        echo json_encode("Unit Type is inserted successfully");
    else
        echo json_encode("cannot be inserted");
}

if
(
    !empty($data->roleType)
){
    $roleId = $getPropertyMaster->getRoleId($data->roleType);
    if ($roleId)
        echo json_encode($roleId);
    else
        echo json_encode("cannot be inserted");
}

if
(
    !empty($data->configurationType)
){
    $configurationId = $getPropertyMaster->getConfigurationId($data->configurationType);
    if ($configurationId)
        echo json_encode($configurationId);
    else
        echo json_encode("cannot be inserted");
}


