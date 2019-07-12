
<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once '../config/database.php';
require_once '../propertyObjects/getPropertyDetails.php';
require_once '../userObjects/getUserDetails.php';
require_once '../MasterData/getMasterData.php' ;
require_once '../MasterData/getPropertyMasterData.php' ;

$data = json_decode(file_get_contents("php://input"));

$propertyId = $_GET['propertyId'];
$flag = $_GET['flag'];

// instantiate database and Login object
// initialize object
$instance = ConnectDb::getInstance();
$db = $instance->getConnection();

$propertyAddress = new GetMasterData($db) ;
$propertyDetails = new GetPropertyDetails($db);
$propertyData = new GetPropertyMasterData($db) ;

switch($flag)
{

    case "amenity" :
        $amenity = $propertyDetails->getAmenity($propertyId) ;
        echo json_encode($amenity) ;
        break ;

    case "propertyName":
        //GETTING PROPERTYNAME FROM PROPERTYID
        $propertyName = $propertyDetails->getPropertyName($propertyId);
        echo json_encode($propertyName);
        break;

    case "propertyStatus":
        //GETTING PROPERTYSTATUS FROM PROPERTYID
        $propertyStatus = $propertyDetails->getPropertyStatus($propertyId);
        echo json_encode($propertyStatus );
        break;

    case "reraNo":
        //GETTING RERANO FROM PROPERTYID
        $reraNo = $propertyDetails->getReraNo($propertyId);
        echo json_encode($reraNo );
        break;

    case "floorNo":
        //GETTING floorNo FROM PROPERTYID
        $floorNo = $propertyDetails->getFloorNo($propertyId);
        echo json_encode($floorNo );
        break;

    case "floors":
        //GETTING FLOORS FROM PROPERTYID
        $floors = $propertyDetails->getFloors($propertyId);
        echo json_encode($floors );
        break;

    case "facing":
        //GETTING facing FROM PROPERTYID
        $facing = $propertyDetails->getFacing($propertyId);
        echo json_encode($facing );
        break;

    case "noOfBathrooms":
        //GETTING NOOFBATHROOMS FROM PROPERTYID
        $noOfBathrooms = $propertyDetails->getBathrooms($propertyId);
        echo json_encode($noOfBathrooms );
        break;
    case "noOfBalconies":
        //GETTING NOOFBALCONIES FROM PROPERTYID
        $noOfBalconies = $propertyDetails->getBalconies($propertyId);
        echo json_encode($noOfBalconies );
        break;

    case "carParking":
        //GETTING CARParking FROM PROPERTYID
        $carParking = $propertyDetails->getCarParking($propertyId);
        echo json_encode($carParking );
        break;

    case "possessionDate":
        //GETTING POSSESSIONDATE FROM PROPERTYID
        $possessionDate = $propertyDetails->getPossessionDate($propertyId);
        echo json_encode($possessionDate );
        break;

    case "furnishedType":
        //GETTING FURNISHEDTYPE FROM PROPERTYID
        $furnishedType = $propertyDetails->getFurnishedType($propertyId);
        echo json_encode($furnishedType );
        break;

    case "description":
        //GETTING DESCRIPTION FROM PROPERTYID
        $description = $propertyDetails->getDescription($propertyId);
        echo json_encode($description);
        break;

    case "ageOfProperty":
        //GETTING ageOfProperty FROM PROPERTYID
        $ageOfProperty = $propertyDetails->getAgeOfProperty($propertyId);
        echo json_encode($ageOfProperty);
        break;

    case "all":
        //GETTING ALL DETAILS FROM PROPERTYID
        $propertyDetailsinfo = $propertyDetails->getPropertyDetails($propertyId);
//        echo json_encode($propertyDetailsinfo)."<br/>";
        $amenity = $propertyDetails->getAmenity($propertyId) ;
        $propertyDetailsinfo['amenity'] = $amenity ;
        $address = $propertyDetails->getPropertyAddress($propertyId);
        $pincode = $propertyAddress->getPincode($address['pincodeId']);
        $city = $propertyAddress->getCity($pincode['cityId']);
        $state = $propertyAddress->getState($city['stateId']) ;
        $country = $propertyAddress->getCountry($state['countryId']) ;
        $propertyPrice = $propertyDetails->getPropertyPrice($propertyId) ;
        $propertyType = $propertyData->getPropertyType($propertyDetailsinfo['propertyTypeId']) ;
        $role = $propertyData->getRoleType($propertyDetailsinfo['userRoleId']) ;
        $configuration = $propertyData->getConfiguration($propertyDetailsinfo['configurationId']);
        $unit = $propertyData->getUnit($propertyPrice['unitId']) ;

        $propertyDetailsinfo['carpetArea'] = $propertyPrice['carpetArea'] ;
        $propertyDetailsinfo['baseValue'] = $propertyPrice['baseValue'] ;
        $propertyDetailsinfo['pricePerUnit'] = $propertyPrice['pricePerUnit'] ;
        $propertyDetailsinfo['buildUpArea'] = $propertyPrice['buildUpArea'] ;
        $propertyDetailsinfo['registration'] = $propertyPrice['registration'] ;
        $propertyDetailsinfo['stampDuty'] = $propertyPrice['stampDuty'] ;
        $propertyDetailsinfo['maintenance'] = $propertyPrice['maintenance'] ;

        $propertyDetailsinfo['unitName'] = $unit['unitName'] ;
        $propertyDetailsinfo['roleType'] = $role['roleType'] ;
        $propertyDetailsinfo['configurationType'] = $configuration['configurationType'] ;
        $propertyDetailsinfo['propertyType'] = $propertyType['propertyType'] ;

        $propertyDetailsinfo['line1'] = $address['line1'] ;
        $propertyDetailsinfo['line2'] = $address['line2'] ;
        $propertyDetailsinfo['latitude'] = $address['latitude'] ;
        $propertyDetailsinfo['longitude'] = $address['longitude'] ;
        $propertyDetailsinfo['placeId'] = $address['placeId'] ;

        $propertyDetailsinfo['pincode'] = $pincode['pincode'] ;
        $propertyDetailsinfo['city'] = $city['city'] ;
        $propertyDetailsinfo['state'] = $state['state'] ;
        $propertyDetailsinfo['country'] = $country['country'] ;
        echo json_encode($propertyDetailsinfo);
        break;

    default :
        echo json_encode("Invalid choice");

}

?>
