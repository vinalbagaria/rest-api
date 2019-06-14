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
if($data->country && !$data->state){
    $countryId=$master->getCountryId($data->country);
    $stateList[] = $master->getStates($countryId);
    echo json_encode(array("stateList"=> $stateList));

}

//DISPLAY LIST OF CITIES
if($data->state && $data->country){
    $countryId=$master->getCountryId($data->country);
    $stateList[] = $master->getStates($countryId);
    echo json_encode(array("stateList"=> $stateList));

    $stateId=$master->getStateId($data->state,$countryId);
    $cityList[] = $master->getCities( $stateId);
    echo json_encode(array("cityList"=> $cityList));

}