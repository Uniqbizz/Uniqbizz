<?php 
// session_start();
require '../../connect.php';

    $id= $_POST["id"];

    $response = $conn->prepare("DELETE FROM package_pictures WHERE id = '".$id."'");
    $result = $response->execute(array());   
	if($result){
        echo "success";
    }else{
        echo "fail";
	}

?>