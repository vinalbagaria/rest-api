<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once '../config/database.php' ;
require_once '../MasterData/getPropertyMasterData.php';

//ESTABLISHING DATABASE CONNECTION
$instance = ConnectDb::getInstance();
$db = $instance->getConnection();

//CREATING OBJECT OF PROPERTY MASTER DATA
$propertyMaster = new GetPropertyMasterData($db);

//CHECKING WHETHER PROPERTY DOCUMENT IS UPLOADED
if(is_uploaded_file($_FILES["propertyDocument"]["tmp_name"])){
    $filename = $_FILES['propertyDocument']['name'];
    $tmp_file = $_FILES["propertyDocument"]["tmp_name"];
    $fileName = $_FILES["propertyDocument"]["name"];
    $fileError = $_FILES["propertyDocument"]["error"];
    $fileSize = $_FILES["propertyDocument"]["size"];

    $fileExt = explode('.',$fileName);
    $fileActualExt = strtolower(end($fileExt));
    $allowed = array('pdf');

    $documentType = $_POST["documentType"];
    $propertyId = $_POST["propertyId"];

    if(in_array($fileActualExt,$allowed)) {

        if($fileError === 0){

            if($fileSize < 100000000000 ){
                $fileNameUnique = uniqid('',true).".".$fileActualExt;

                //URL WHERE THE DOCUMENT IS TO BE UPLOADED
                $upload_dir = "./uploads/documents/".$fileName.$fileNameUnique;

                //GETTING DOCUMENT TYPE ID FOR A PARTICULAR DOCUMENT TYPE
                $documentTypeId = $propertyMaster->getDocumentTypeId($documentType);

                $query = "INSERT INTO documents(propertyId, documentTypeId ,documentLink) VALUES (:propertyId , :documentTypeId ,:upload_dir)";
                $stmt= $db->prepare($query);

                $stmt->bindParam(":propertyId",$propertyId);
                $stmt->bindParam(":documentTypeId",$documentTypeId);
                $stmt->bindParam(":upload_dir",$upload_dir);

                if(move_uploaded_file($tmp_file , $upload_dir) && $stmt->execute()){
                    echo json_encode("UPLOAD SUCCESS");
                }else{
                    echo json_encode("UPLOAD FAILED");
                }

            }else{
                echo json_encode("Your file is too big");
            }
        }else{
            echo json_encode("Error uploading your file");
        }
    }else{
        echo json_encode("You cannot upload files of that type");
    }
}else{
    echo json_encode("File not found");
}
