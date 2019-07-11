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

// Count total files
$propertyId = $_POST["propertyId"];
$countfiles = count($_FILES['propertyImage']['name']);
for($i=0;$i<$countfiles;$i++){
    if(is_uploaded_file($_FILES["propertyImage"]["tmp_name"][$i]))
 {
      $fileName = $_FILES['propertyImage']['name'][$i];
      $tmp_file = $_FILES["propertyImage"]["tmp_name"][$i];
      $fileError = $_FILES["propertyImage"]["error"][$i];
      $fileSize = $_FILES["propertyImage"]["size"][$i];
      $imageName = $_POST["imageName"][$i];

      $fileExt = explode('.',$fileName);
      $fileActualExt = strtolower(end($fileExt));
      $allowed = array ('jpg','jpeg','png') ;
  
      if(in_array($fileActualExt,$allowed)) {

         if($fileError === 0){

            if($fileSize < 100000000000 ){
                $fileNameNew = uniqid('',true).".".$fileActualExt;               
                $upload_dir = "./uploads/images".$fileNameNew;
            
                 $query = "INSERT INTO gallery(propertyId, imageLink ,imageName) VALUES (:propertyId ,:upload_dir, :imageName)";
                 $stmt= $db->prepare($query);
            
                 $stmt->bindParam(":propertyId",$propertyId);
                 $stmt->bindParam(":imageName",$imageName);
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

}

