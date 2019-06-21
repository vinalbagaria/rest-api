<?php
 header("Access-Control-Allow-Origin: *");
 header("Content-Type: application/json; charset=UTF-8");
 header("Access-Control-Max-Age: 3600");
 header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

 $response = array();
require_once '../config/database.php' ;
require_once '../propertyObjects/getPropertyDetails.php';
require_once '../MasterData/getPropertyMasterData.php';

$instance = ConnectDb::getInstance();
$db = $instance->getConnection();
$propertyDetails = new GetPropertyDetails($db);
$propertyMaster = new GetPropertyMasterData($db);

if(is_uploaded_file($_FILES["propertyDocument"]["tmp_name"]))
{

    $tmp_file = $_FILES["propertyDocument"]["tmp_name"] ;
    $documentName = $_FILES["propertyDocument"]["name"];
    $upload_dir = "uploads/".$documentName;
    $userId = $_POST["userId"] ;

    $propertyId = $propertyDetails->getPropertyId($userId) ;
    echo json_encode(array("propertyId" =>$propertyId )) ;
    $documentTypeId = $propertyMaster->getDocumentTypeId($documentName);
    echo json_encode(array("documentTypeId" =>$documentTypeId )) ;

     $query = "INSERT INTO documents(propertyId, documentTypeId ,documentLink) VALUES (:propertyId , :documentTypeId ,:upload_dir)";
     $stmt= $db->prepare($query);

     $stmt->bindParam(":propertyId",$propertyId);
     $stmt->bindParam(":documentTypeId",$documentTypeId);
     $stmt->bindParam(":upload_dir",$upload_dir);
     
     if(move_uploaded_file($tmp_file , $upload_dir) && $stmt->execute()){
            $response["MESSAGE"] = "UPLOAD SUCCESS";
            $response["STATUS"] = 200;
     }else{

        $response["MESSAGE"] = "UPLOAD FAILED";
        $response["STATUS"] = 404;
     }
     echo json_encode($response);
}
