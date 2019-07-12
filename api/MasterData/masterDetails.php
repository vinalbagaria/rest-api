<?php

// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once '../config/database.php';
require_once 'getMasterData.php';

$data = json_decode(file_get_contents("php://input"));

$instance = ConnectDb::getInstance();
$db = $instance->getConnection();
$master = new GetMasterData($db);
$flag = $_GET['flag'];

switch($flag)
{
    case "countries":
        //DISPLAY LIST OF COUNTRIES
        $countryList = $master->getCountries();
        echo json_encode($countryList);
        break;

    case "states":
        $country = $_GET['country'] ;
        //DISPLAY LIST OF STATES
        if(!empty($country)){
            $countryId=$master->getCountryId($country);
            $stateList = $master->getStates($countryId);
            echo json_encode($stateList);
        }
        break;

    case "cities":
        $country = $_GET['country'] ;
        $state = $_GET['state'] ;
        //DISPLAY LIST OF CITIES
        if(!empty($state) && !empty($country)){
            $countryId=$master->getCountryId($country);
            $stateId=$master->getStateId($state,$countryId);
            $cityList = $master->getCities( $stateId);
            echo json_encode($cityList);
        }
        break;

    case "roles":
        //DISPLAY LIST OF ROLES
        $roleList = $master->getRoles();
        echo json_encode($roleList);
        break;

    case "documents":
        //DISPLAY LIST OF DOCUMENTS
        $documentList = $master->getDocuments();
        echo json_encode($documentList);
        break;

    case "amenities":
        //DISPLAY LIST OF AMENITIES
        $amenitiesList = $master->getAmenities();
        echo json_encode($amenitiesList);
        break;

    case "configuration":
        //DISPLAY LIST OF CONFIGURATION
        $configurationList = $master->getConfiguration();
        echo json_encode($configurationList);
        break;

    case "unitType":
        //DISPLAY LIST OF UNIT TYPE
        $unitList = $master->getUnits();
        echo json_encode($unitList);
        break;

    case "socialMedia":
        //DISPLAY LIST OF SOCIAL MEDIA NAMES
        $socialMediaNameList = $master->getSocialMediaName();
        echo json_encode($socialMediaNameList);
        break;

    case "propertyType":
        //DISPLAY LIST OF PROPERTY TYPE
        $propertyTypeList = $master->getPropertyType();
        echo json_encode($propertyTypeList);
        break;

    default:
        echo json_encode("Invalid choice");

}
