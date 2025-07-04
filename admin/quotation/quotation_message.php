<?php
    require '../connect.php';

    $id = $_POST['id'];
    $message = $_POST['message'];

    // echo $id;
    // echo $message;
    $sql = $conn -> prepare(" INSERT INTO `quotations_info` (quotation_id, message) VALUES (:quotation_id, :message) ");
    $result = $sql -> execute(array(
        ':quotation_id' => $id,
        ':message' => $message
    ));

    if($result){
		echo "1";
	}else{
		echo "0";
	}
?>