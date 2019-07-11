<?php
 header("Access-Control-Allow-Origin: *");
 header("Content-Type: application/json; charset=UTF-8");
 header("Access-Control-Max-Age: 3600");
 header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

 $response = array();
require_once '../config/database.php';
require_once '../MasterData/getPropertyMasterData.php';

$instance = ConnectDb::getInstance();
$db = $instance->getConnection();
$propertyMaster = new GetPropertyMasterData($db);

 if(is_uploaded_file($_FILES["propertyDocument"]["tmp_name"]))
 {
      $filename = $_FILES['propertyDocument']['name'];
      $tmp_file = $_FILES["propertyDocument"]["tmp_name"];
      $fileName = $_FILES["propertyDocument"]["name"];
      $fileError = $_FILES["propertyDocument"]["error"];
      $fileSize = $_FILES["propertyDocument"]["size"];
      $documentType = $_POST["documentType"];
      $fileExt = explode('.',$fileName);
      $fileActualExt = strtolower(end($fileExt));
      $allowed = array ('pdf');
      $propertyId = $_POST["propertyId"];
  
      if(in_array($fileActualExt,$allowed)) {

         if($fileError === 0){

            if($fileSize < 100000000000 ){
                $fileNameNew = uniqid('',true).".".$fileActualExt;               
                $upload_dir = "uploads/documents".$fileNameNew;
         
                $documentTypeId = $propertyMaster->getDocumentTypeId($documentType);
                echo json_encode(array("documentTypeId" =>$documentTypeId ));
            
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
           }else{
                echo "Your file is too big " ;
            }
        }
        else
        {
            echo "Error uploading your file " ;
        }
    }
    else{
        echo "You cannot upload files of that type" ;
    }
}
    
   
