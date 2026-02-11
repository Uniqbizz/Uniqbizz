<?php 
date_default_timezone_set('Asia/Calcutta');
$today = date('Y-m-d H:i:s' );

require "../connect.php";

// $f_id= $_POST["refid"];
$id= $_POST["id"];
$user_type="10";

$status;
$action= $_POST["action"];

if($action == 'pending'){
	$ta_id = ""; //set travel agent id to empty
    $identifier_name = 'id=';
	$status= '0';
}else if($action == 'registered') {
	$ta_id = $_POST["refid"]; //set travel agent id
    $identifier_name = 'ca_customer_id=';
	$status= '3';
} else if($action == 'deactivate') {
	$ta_id = $_POST["refid"]; //set travel agent id
    $identifier_name = 'ca_customer_id=';
	$status= '1';					// activate user
	$today = null;
} else if($action == 'deleted') {
	$ta_id = ""; //set travel agent id
    $identifier_name = 'ca_customer_id=';
	$status= '2';					// activate user
	$today = null;
}


 $title="Customer";
if($ta_id ==''){
	$message="Deleted Customer from ".$action. " list";
	$message2="Deleted Customer from ".$action. " list";
}else{
	$message="Deleted Customer(".$ta_id.") from ".$action. " list";
	$message2="Deleted Customer(".$ta_id.") from ".$action. " list";
}

$fromWhom="1";
$register_by="1"; 
$operation="Delete";

$sql1 = "UPDATE ca_customer SET status=:status, deleted_date=:deleted_date WHERE id='".$id."' ";
$stmt = $conn->prepare($sql1);
$result=  $stmt->execute(array(
	':status' => $status,
	':deleted_date' => $today	
));

if(isset($_POST["refid"])){
	$ca_customer_id= $_POST["refid"];

	$sql2 = "UPDATE login SET status=:status WHERE user_id=:ca_customer_id and user_type_id=:user_type";
	$stmt2 = $conn->prepare($sql2);
	$result2=  $stmt2->execute(array(
		':status' => $status,
		':user_type' => $user_type,
		':ca_customer_id' => $ca_customer_id		
	));

	if ($result2) {
		$sql3= "INSERT INTO logs (user_id,title,message,message2, register_by, from_whom, operation) VALUES (:user_id,:title ,:message, :message2, :register_by, :from_whom, :operation)";
		$stmt3 =$conn->prepare($sql3);

		$result3=$stmt3->execute(array(
			':user_id' => $ca_customer_id,
			':title' => $title,
			':message' => $message,
			':message2' =>$message2,
			':register_by' => $register_by,
			':from_whom' => $fromWhom,
			':operation' => $operation
		));

		if($result3){
			echo $status;
		}else{
			echo $status;
		}
	} else{
		echo $status;
	}
} else if ($result) {
	echo $status;
}else{
	echo $status;
}



	


?>