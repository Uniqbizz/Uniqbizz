<?php 
date_default_timezone_set('Asia/Calcutta');
$today = date('Y-m-d H:i:s' );

require "../../connect.php";

$action= $_POST["action"];
$id= $_POST["id"];
$user_type="13";

if($action == 'pending'){
	$rmid = "";
	$status= '0'; 	// deleted
}else if($action == 'registered') {
	$rmid = $_POST["rmid"];
	$status= '3';  // deactivate
}else if($action == 'deactivate') {
	$rmid = $_POST["rmid"];
	$status= '1';  // activate
	$today = NULL;
}else if($action == 'deleted') {
	$rmid = '';
	$status= '2';  // activate for lead
	$today = NULL;
}


$title="Trainee Manager";
if($rmid ==''){
	$message="Deleted Trainee Manager from ".$action. " list";
	$message2="Deleted Trainee Manager from ".$action. " list";
}else{
	$message="Deleted Trainee Manager(".$rmid.") from ".$action. " list";
	$message2="Deleted Trainee Manager(".$rmid.") from ".$action. " list";
}

$fromWhom="1";
$register_by="1";
$ref_no="1";

	$sql1 = "UPDATE trainee_manager SET status=:status, deleted_date=:deleted_date WHERE id=:id";
	$stmt = $conn->prepare($sql1);
	$result=  $stmt->execute(array(
		':status' => $status,
		':deleted_date' => $today,
		':id' => $id		
	));

	

	// registered User activate , deactivate
if(isset($_POST["rmid"])){
	$trainee_manager_id= $_POST["rmid"];

	$sql2 = "UPDATE login SET status=:status WHERE user_id=:trainee_manager_id and user_type_id=:user_type";
	$stmt2 = $conn->prepare($sql2);
	$result2 =  $stmt2->execute(array(
		':status' => $status,
		':user_type' => $user_type,
		':trainee_manager_id' => $trainee_manager_id		
	));

	if ($result) {
		$sql3 = "INSERT INTO logs (title,message,message2, reference_no, register_by, from_whom) VALUES (:title ,:message, :message2, :reference_no, :register_by, :from_whom)";
		$stmt3 = $conn->prepare($sql3);
		$result3=$stmt3->execute(array(
			':title' => $title,
			':message' => $message,
			':message2' =>$message2,
			':reference_no' => $ref_no,
			':register_by' => $register_by,
			':from_whom' => $fromWhom
		));

		if($result3){
			echo $status;
		}else{
			echo $status	;
		}
	} else {
		echo $status;
	}
} else if ($result2) {
	echo $status;
} else {
	echo $status;
}


	


?>