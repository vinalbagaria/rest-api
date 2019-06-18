<?php

// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/database.php';
include_once 'getMasterData.php';

$database = new Database();
$db = $database->getConnection();

$master = new GetMasterData($db);
$data = json_decode(file_get_contents("php://input"));


//DISPLAY LIST OF COUNTRIES
$countryList[] = $master->getCountries();
echo json_encode(array("countryList"=> $countryList));

//DISPLAY LIST OF STATES
if(!empty($data->country)){
    $countryId=$master->getCountryId($data->country);
    $stateList[] = $master->getStates($countryId);
    echo json_encode(array("stateList"=> $stateList));

}

//DISPLAY LIST OF CITIES
if(!empty($data->state) && !empty($data->country)){
    $countryId=$master->getCountryId($data->country);
    $stateList[] = $master->getStates($countryId);
    echo json_encode(array("stateList"=> $stateList));

    $stateId=$master->getStateId($data->state,$countryId);
    $cityList[] = $master->getCities( $stateId);
    echo json_encode(array("cityList"=> $cityList));

}

//DISPLAY LIST OF ROLES
$roleList[] = $master->getRoles();
echo json_encode(array("roleList"=> $roleList));

//DISPLAY LIST OF DOCUMENTS
$documentList[] = $master->getDocuments();
echo json_encode(array("documentList"=> $documentList));

//DISPLAY LIST OF AMENITIES
$amenitiesList[] = $master->getAmenities();
echo json_encode(array("documentList"=> $documentList));

//DISPLAY LIST OF CONFIGURATION
$configurationList[] = $master->getConfiguration();
echo json_encode(array("documentList"=> $configurationList));

//DISPLAY LIST OF UNIT TYPE
$unitList[] = $master->getUnits();
echo json_encode(array("documentList"=> $unitList));

//DISPLAY LIST OF SOCIAL MEDIA NAMES
$socialMediaNameList[] = $master->getSocialMediaName();
echo json_encode(array("documentList"=> $socialMediaNameList));

//DISPLAY LIST OF PROPERTY TYPE 
$propertyTypeList[] = $master->getPropertyType();
echo json_encode(array("documentList"=> $propertyTypeList));



