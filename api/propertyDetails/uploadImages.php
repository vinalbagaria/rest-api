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

//Count total files
$countfiles = count($_FILES['propertyImage']['name']);

$propertyId = $_POST["propertyId"];

//LOOP TO GO THROUGH THE ARRAY OF IMAGES
for($i=0;$i<$countfiles;$i++){
    if(is_uploaded_file($_FILES["propertyImage"]["tmp_name"][$i]))
    {
        $fileName = $_FILES['propertyImage']['name'][$i];
        $tmp_file = $_FILES["propertyImage"]["tmp_name"][$i];
        $fileError = $_FILES["propertyImage"]["error"][$i];
        $fileSize = $_FILES["propertyImage"]["size"][$i];

        $fileExt = explode('.',$fileName);
        $fileActualExt = strtolower(end($fileExt));
        $allowed = array ('jpg','jpeg','png') ;

        if(in_array($fileActualExt,$allowed)) {

            if($fileError === 0){

                if($fileSize < 100000000000 ){
                    $fileNameUnique = uniqid('',true).".".$fileActualExt;

                    //URL WHERE THE IMAGES ARE  TO BE UPLOADED
                    $upload_dir = "./uploads/images/".$fileName.$fileNameUnique;

                    $query = "INSERT INTO gallery(propertyId, imageLink ,imageName) VALUES (:propertyId ,:upload_dir, :imageName)";
                    $stmt= $db->prepare($query);

                    $stmt->bindParam(":propertyId",$propertyId);
                    $stmt->bindParam(":imageName",$fileName);
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
        }
        else{
            echo json_encode("You cannot upload files of that type");
        }
    }else{
        echo json_encode("File not found");
    }

}
