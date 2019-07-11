
<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// database connection will be here
// include database and object files
require_once '../config/database.php';
require_once '../propertyObjects/getPropertyDetails.php';
require_once '../userObjects/getUserDetails.php';

$data = json_decode(file_get_contents("php://input"));

$propertyId = $_GET['propertyId'];
$flag = $_GET['flag'];

// instantiate database and Login object
// initialize object
$instance = ConnectDb::getInstance();
$db = $instance->getConnection();

//GET PROPERTYID FROM USERID
$propertyDetails = new GetPropertyDetails($db);
//$propertyId = $propertyDetails->getPropertyId($userId);
//echo json_encode(array("propertyId" =>$propertyId ));


switch($flag)
{

    case "amenity" :
        $amenity = $propertyDetails->getAmenityId($propertyId) ;
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
        $amenity = $propertyDetails->getAmenityId($propertyId) ;
        array_push($propertyDetailsinfo , $amenity ) ;
        echo json_encode($propertyDetailsinfo);
        break;

    default :
        echo json_encode("Invalid choice");

}

?>
