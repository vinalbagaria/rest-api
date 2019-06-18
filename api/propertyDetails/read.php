<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// database connection will be here
// include database and object files
include_once '../config/database.php';
include_once '../propertyObjects/getPropertyDetails.php';
include_once '../userObjects/getUserDetails.php';

// instantiate database and Login object
$database = new Database();
$db = $database->getConnection();

// initialize object
$propertyDetails = new GetPropertyDetails($db);
$data = json_decode(file_get_contents("php://input"));
$userId = $data->userId;
echo json_encode(array("userId"=> $userId));



//checking data is empty or not
if(
    !empty($data->userId && $data->propertyId) 
)
{
    $propertyId = $propertyDetails->getPropertyId($data->userId);
    echo json_encode(array("propertyId" =>$propertyId ));

    $propertyName = $propertyDetails->getPropertyName($data->propertyId);
    echo json_encode(array("propertyName" =>$propertyName ));

    $propertyStatus = $propertyDetails->getPropertyStatus($data->propertyId);
    echo json_encode(array("propertyStatus" =>$propertyStatus ));

    $reraNo = $propertyDetails->getReraNo($data->propertyId);
    echo json_encode(array("reraNo" =>$reraNo ));

    $floorNo = $propertyDetails->getFloorNo($data->propertyId);
    echo json_encode(array("floorNo" =>$floorNo ));

    $floors = $propertyDetails->getFloors($data->propertyId);
    echo json_encode(array("floors" =>$floors ));

    $facing = $propertyDetails->getFacing($data->propertyId);
    echo json_encode(array("facing" =>$facing ));

    $noOfBathrooms = $propertyDetails->getBathrooms($data->propertyId);
    echo json_encode(array("noOfBathrooms" =>$noOfBathrooms ));

    $noOfBalconies = $propertyDetails->getBalconies($data->propertyId);
    echo json_encode(array("noOfBalconies" =>$noOfBalconies ));

    $carParking = $propertyDetails->getCarParking($data->propertyId);
    echo json_encode(array("carParking" =>$carParking ));

    $possessionDate = $propertyDetails->getPossessionDate($data->propertyId);
    echo json_encode(array("possessionDate" =>$possessionDate ));

    $furnishedType = $propertyDetails->getFurnishedType($data->propertyId);
    echo json_encode(array("furnishedType" =>$furnishedType ));

    $description = $propertyDetails->getDescription($data->propertyId);
    echo json_encode(array("description" =>$description ));

    $ageOfProperty = $propertyDetails->getAgeOfProperty($data->propertyId);
    echo json_encode(array("ageOfProperty" =>$ageOfProperty ));
}

//if user inputs incomplete information
else
{
    http_response_code(400);
    echo json_encode(array("message" => "Incomplete Information please fill again."));
}
?>






