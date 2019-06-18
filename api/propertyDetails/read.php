<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/database.php';
include_once '../propertyObjects/getPropertyDetails.php';
include_once '../userObjects/getUserDetails.php';

//INSTANTIATE DATABASE OBJECT
$database = new Database();
$db = $database->getConnection();

//INITIALIZE PROPERTY DETAILS OBJECT
$propertyDetails = new GetPropertyDetails($db);
$data = json_decode(file_get_contents("php://input"));
$userId = $data->userId;
echo json_encode(array("userId"=> $userId));



//CHECKING DATA IS EMPTY OR NOT
if(
    !empty($data->userId)
)
{
    $propertyId = $propertyDetails->getPropertyId($data->userId);
    echo json_encode(array("propertyId" =>$propertyId ));

    $propertyName = $propertyDetails->getPropertyName($propertyId);
    echo json_encode(array("propertyName" =>$propertyName ));

    $propertyStatus = $propertyDetails->getPropertyStatus($propertyId);
    echo json_encode(array("propertyStatus" =>$propertyStatus ));

    $reraNo = $propertyDetails->getReraNo($propertyId);
    echo json_encode(array("reraNo" =>$reraNo ));

    $floorNo = $propertyDetails->getFloorNo($propertyId);
    echo json_encode(array("floorNo" =>$floorNo ));

    $floors = $propertyDetails->getFloors($propertyId);
    echo json_encode(array("floors" =>$floors ));

    $facing = $propertyDetails->getFacing($propertyId);
    echo json_encode(array("facing" =>$facing ));

    $noOfBathrooms = $propertyDetails->getBathrooms($propertyId);
    echo json_encode(array("noOfBathrooms" =>$noOfBathrooms ));

    $noOfBalconies = $propertyDetails->getBalconies($propertyId);
    echo json_encode(array("noOfBalconies" =>$noOfBalconies ));

    $carParking = $propertyDetails->getCarParking($propertyId);
    echo json_encode(array("carParking" =>$carParking ));

    $possessionDate = $propertyDetails->getPossessionDate($propertyId);
    echo json_encode(array("possessionDate" =>$possessionDate ));

    $furnishedType = $propertyDetails->getFurnishedType($propertyId);
    echo json_encode(array("furnishedType" =>$furnishedType ));

    $description = $propertyDetails->getDescription($propertyId);
    echo json_encode(array("description" =>$description ));

    $ageOfProperty = $propertyDetails->getAgeOfProperty($propertyId);
    echo json_encode(array("ageOfProperty" =>$ageOfProperty ));
}
else
{
    http_response_code(400);
    echo json_encode(array("message" => "Incomplete Information please fill again."));
}
?>






