<?php
/// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// get database connection
require_once '../config/database.php';

// instantiate product object
require_once '../userObjects/register.php';

//GET POSTED DATA
$data = json_decode(file_get_contents("php://input"));

// CHECKING DATA IS EMPTY OR NOT
if (
    !empty($data->firstName) &&
    !empty($data->lastName) &&
    !empty($data->contactNo) &&
    !empty($data->emailId) &&

    !empty($data->country) &&
//    !empty($data->state) &&
//    !empty($data->city) &&
//    !empty($data->pincode) &&
//    !empty($data->line1) &&
//    !empty($data->line2) &&
//    !empty($data->latitude) &&
//    !empty($data->longitude) &&
//    !empty($data->placeId) &&

    !empty($data->password)
) {
    $instance = ConnectDb::getInstance();
    $db = $instance->getConnection();

    $user = new Register($db);

    // SET PRODUCT PROPERTY VALUES
    $user->firstName = $data->firstName;
    $user->lastName=$data->lastName;
    $user->contactNo=$data->contactNo;
    $user->emailId=$data->emailId;

    $user->country=$data->country;
//    $user->state=$data->state;
//    $user->city=$data->city;
//    $user->pincode=$data->pincode;
//    $user->line1=$data->line1;
//    $user->line2=$data->line2;
//    $user->latitude=$data->latitude;
//    $user->longitude=$data->longitude;
//    $user->placeId=$data->placeId;

    $user->password=$data->password;

    if ($user->registerUser()) {
        echo json_encode( "user was created.");

    }
    else {
        echo json_encode("Unable to create user.");
    }
}
else {
    echo json_encode("Unable to create user. Data is incomplete.");
}












//
//// required headers
//
//header("Access-Control-Allow-Origin: http://localhost:4200");
//////header("Access-Control-Allow-Credentials:true");
////header("Content-Type: application/json; charset=UTF-8");
////header("Access-Control-Allow-Methods: POST,GET,OPTIONS");
////header("Access-Control-Max-Age: 3600");
//header("Content-Type: application/json; charset=UTF-8");
//header("Access-Control-Allow-Methods: POST");
//header("Access-Control-Max-Age: 3600");
//header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
//
//
////header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
//
//// get database connection
//require_once '../config/database.php';
//
//// instantiate product object
//require_once 'register.php';
//
////GET POSTED DATA
//
//$request = json_decode(file_get_contents("php://input"));
////$request = json_decode($_POST['register'],true);
//// SET PRODUCT PROPERTY VALUES
//$firstName = $request->firstName;
//$lastName = $request->lastName;
//$contactNo = $request->contactNo;
//$emailId = $request->emailId;
//$country = $request->country;
//$password = $request->password;
////$req = new Create($firstName,$lastName,$contactNo,$emailId,$country,$password);
////$req->registerUser() ;
//
//class Create
//{
//    private $user = "user";
////    private $userAddress = "userAddress";
//    private $countryTable = "country";
//    private $userCredentials = "userCredentials";
//    private $conn ;
//    private $db ;
//    private $userId ;
//    private $countryId ;
//    // SET PRODUCT PROPERTY VALUES
//    private $firstName ;
//    private $lastName;
//    private $contactNo;
//    private $emailId;
//    private $password;
//    private $country ;
//    public function __construct($firstName,$lastName,$contactNo,$emailId,$country,$password)
//    {
//        $instance = ConnectDb::getInstance();
//        $this->db = $instance->getConnection();
//        $this->firstName = $firstName ;
//        $this->lastName = $lastName ;
//        $this->contactNo = $contactNo ;
//        $this->emailId = $emailId ;
//        $this->country = $country ;
//        $this->password = $password ;
//
////    $user->state=$data->state;
////    $user->city=$data->city;
////    $user->pincode=$data->pincode;
////    $user->line1=$data->line1;
////    $user->line2=$data->line2;
////    $user->latitude=$data->latitude;
////    $user->longitude=$data->longitude;
////    $user->placeId=$data->placeId;
//
////        $this->registerUser();
//
////        $this->master=new GetMasterData($this->conn);
//    }
//    function getUserId()
//    {
//        $query ="SELECT userId FROM $this->user WHERE contactNo = :contactNo";
//        $userIdFetch = $this->db->prepare($query);
//        $userIdFetch->bindParam(":contactNo",$this->contactNo);
//        $userIdFetch->execute();
//        $forUserId = $userIdFetch->fetch(PDO::FETCH_ASSOC);
//        $this->userId=$forUserId["userId"];
//        echo json_encode(array("message"=> $this->userId) );
//    }
//    function registerUser()
//    {
//
//
//        //INSERT STATEMENTS
//        $query1= "INSERT INTO  $this->user (firstName,lastName,contactNo,emailId,countryId) VALUES(:firstName,:lastName,:contactNo,:emailId,:countryId)";
//
////        $query2="INSERT INTO $this->userAddress(userId,line1,line2,latitude,longitude,placeId,pincodeId) VALUES (:userId,:line1,:line2,:latitude,:longitude,:placeId,:pincodeId)";
//
//        $query3="INSERT INTO $this->userCredentials(userId,password) VALUES(:userId,:password)";
//
//        //PREPARE STATEMENTS
//        $stmt1= $this->db->prepare($query1);
////        $stmt2= $this->conn->prepare($query2);
//        $stmt3= $this->db->prepare($query3);
//
//        //SANITIZE
//        //FOR USER DETAILS
//        $this->firstName=htmlspecialchars(strip_tags($this->firstName));
//        $this->lastName=htmlspecialchars(strip_tags($this->lastName));
//        $this->contactNo=htmlspecialchars(strip_tags($this->contactNo));
//        $this->emailId=htmlspecialchars(strip_tags($this->emailId));
//
//        //FOR COUNTRY
//        $this->countryId=htmlspecialchars(strip_tags(($this->getCountryId($this->country))));
////        echo json_encode(array("message" => $this->countryId));
//
//        //FOR STATE
////        $this->state=htmlspecialchars(strip_tags($this->state));
////        $this->stateId=htmlspecialchars(strip_tags(($this->master)->getStateId($this->state , $this->countryId)));
////        echo json_encode(array("message" => $this->stateId));
////
////        //FOR CITY
////        $this->city=htmlspecialchars(strip_tags($this->city));
////        $this->cityId=htmlspecialchars(strip_tags(($this->master)->getCityId($this->city , $this->stateId)));
////        echo json_encode(array("message" => $this->cityId));
////
////        //FOR PINCODE
////        $this->pincode=htmlspecialchars(strip_tags($this->pincode));
////        $this->pincodeId=htmlspecialchars(strip_tags(($this->master)->getpincodeId($this->pincode , $this->cityId)));
////        echo json_encode(array("message" => $this->pincodeId));
////
////        //FOR REMAINING ADDRESS
////        $this->line1=htmlspecialchars(strip_tags($this->line1));
////        $this->line2=htmlspecialchars(strip_tags($this->line2));
////        $this->latitude=htmlspecialchars(strip_tags($this->latitude));
////        $this->longitude=htmlspecialchars(strip_tags($this->longitude));
////        $this->placeId=htmlspecialchars(strip_tags($this->placeId));
//
//        //FOR PASSWORD
//        $this->password=htmlspecialchars(strip_tags($this->password));
//
//        //BINDING PARAMETERS
//        //USER TABLE
//        $stmt1->bindParam(":firstName", $this->firstName);
//        $stmt1->bindParam(":lastName", $this->lastName);
//        $stmt1->bindParam(":contactNo", $this->contactNo);
//        $stmt1->bindParam(":emailId", $this->emailId);
//        $stmt1->bindParam(":countryId", $this->countryId);
//
//        if($stmt1->execute())
//        {
//            $this->getUserId();
//
//            //USER ADDRESS TABLE
////            $stmt2->bindParam(":userId", $this->userId);
////            $stmt2->bindParam(":line1", $this->line1);
////            $stmt2->bindParam(":line2", $this->line2);
////            $stmt2->bindParam(":latitude", $this->latitude);
////            $stmt2->bindParam(":longitude", $this->longitude);
////            $stmt2->bindParam(":placeId", $this->placeId);
////
////            $stmt2->bindParam(":pincodeId", $this->pincodeId);
//
//            //USER CREDENTIALS TABLE
//            $stmt3->bindParam("userId", $this->userId);
//            $stmt3->bindParam("password", $this->password);
//
//            //EXECUTE STATEMENTS
//
//
//            if ( $stmt3->execute())
//                return true;
//            else
//            {
//                $query4 = "DELETE FROM $this->user WHERE userId = :userId " ;
//                $stmt4 = $this->db->prepare($query4) ;
//                $stmt4->bindParam(":userId" , $this->userId ) ;
//                $stmt4->execute();
//
//                return false ;
//
//            }
//
//        }
//        return false ;
//    }
//
//    public function getCountryId($country)
//    {
//        $query = "SELECT countryId FROM $this->countryTable WHERE country = :country";
//        $countryId = $this->db->prepare($query);
//        $countryId->bindParam(":country", $country);
//        $countryId->execute();
//        $forCountry = $countryId->fetch(PDO::FETCH_ASSOC);
//
//        return $forCountry["countryId"];
//    }
//
//
//}
//// CHECKING DATA IS EMPTY OR NOT
////if (
////    !empty($request->firstName) &&
////    !empty($request->lastName) &&
////    !empty($request->contactNo) &&
////    !empty($request->emailId) &&
////    !empty($request->country) &&
////    !empty($request->password)
////
//////    !empty($data->state) &&
//////    !empty($data->city) &&
//////    !empty($data->pincode) &&
//////    !empty($data->line1) &&
//////    !empty($data->line2) &&
//////    !empty($data->latitude) &&
//////    !empty($data->longitude) &&
//////    !empty($data->placeId) &&
//////
////
////) {
////    $instance = new ConnectDb();
////    $db = $instance->getConnection();
////
////    $user = new Register($db);
////
////    // SET PRODUCT PROPERTY VALUES
////    $user->firstName = $request->firstName;
////    $user->lastName=$request->lastName;
////    $user->contactNo=$request->contactNo;
////    $user->emailId=$request->emailId;
////
////    $user->country=$request->country;
//////    $user->state=$data->state;
//////    $user->city=$data->city;
//////    $user->pincode=$data->pincode;
//////    $user->line1=$data->line1;
//////    $user->line2=$data->line2;
//////    $user->latitude=$data->latitude;
//////    $user->longitude=$data->longitude;
//////    $user->placeId=$data->placeId;
////
////    $user->password=$request->password;
//
////    if ($user->registerUser()) {
////
////        // set response code - 201 created
////        http_response_code(201);
////
////
//////        echo json_encode(array("message" => "user was created."));
////    }
////    else {
////
////        // set response code - 503 service unavailable
////        http_response_code(503);
////
////
//////        echo json_encode(array("message" => "Unable to create user."));
////    }
////}
////else {
////
////    // set response code - 400 bad request
////    http_response_code(400);
////
//////    echo json_encode(array("message" => "Unable to create user. Data is incomplete."));
////}
////
//
//
//
//
//
////header("Access-Control-Allow-Origin: *");
////
////// get database connection
////require_once '../config/database.php';
////
////// instantiate product object
////require_once '../userObjects/register.php';
////
////if ($_SERVER['REQUEST_METHOD'] == 'POST' && empty($_POST)){
////    $_POST = json_decode(file_get_contents('php://input'), true);
////
////    $flag = 1 ;
////    $response = array();
////    $instance = ConnectDb::getInstance();
////    $db = $instance->getConnection();
////
////    $user = new Register($db);
////
////    // SET PRODUCT PROPERTY VALUES
////    $user->firstName = $_POST['firstName'];
////    $user->lastName=$_POST['lastName'];;
////    $user->contactNo=$_POST['contactNo'];
////    $user->emailId=$_POST['emailId'];
////
////    $user->country=$_POST['country'];
//////    $user->state=$data->state;
//////    $user->city=$data->city;
//////    $user->pincode=$data->pincode;
//////    $user->line1=$data->line1;
//////    $user->line2=$data->line2;
//////    $user->latitude=$data->latitude;
//////    $user->longitude=$data->longitude;
//////    $user->placeId=$data->placeId;
////
////    $user->password=$_POST['password'];
////
////    if ($user->registerUser()) {
////
////        // set response code - 201 created
////        http_response_code(201);
////
////        $response['message'] = "User was created" ;
//////        echo json_encode(array("message" => "user was created."));
////    }
////    else {
////
////        // set response code - 503 service unavailable
////        http_response_code(503);
////        $flag = 0 ;
////        $response['message'] = "Unable to create user." ;
//////        echo json_encode(array("message" => "Unable to create user."));
////    }
////}
////else {
////    $flag = 0 ;
////    // set response code - 400 bad request
////    http_response_code(400);
////    $response['message'] =  "Unable to create user. Data is incomplete." ;
//////    echo json_encode(array("message" => "Unable to create user. Data is incomplete."));
////    }
////$response['flag'] = $flag ;
////echo json_encode($response);
////
//////$db->close(
//
