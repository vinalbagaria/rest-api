<?php

// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/database.php';
include_once '../objects/getMasterData.php';

$database = new Database();
$db = $database->getConnection();

$master = new GetMasterData($db);
$data = json_decode(file_get_contents("php://input"));


//DISPLAY LIST OF COUNTRIES
$countryList[] = $master->getCountries();
echo json_encode(array("message"=> $countryList));


//DISPLAY LIST OF STATES
//echo json_encode(array("message"=> $data->country));
//echo json_encode(array("message"=>$master->getCountryId($data->country)));
// $stateList[] = $master->getStates( $master->getCountryId($data->country));
// echo json_encode(array("message"=> $stateList));

// $cityList[] = $master->getCities( $master->getStateId($data->state,$master->getCountryId($data->country)));
//  echo json_encode(array("message"=> $cityList));


