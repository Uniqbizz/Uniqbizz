<?php 
date_default_timezone_set('Asia/Calcutta');
$today = date('Y-m-d H:i:s' );

require "../connect.php";

$id= $_POST["id"];
$refid= $_POST["refid"];
$action= $_POST["action"];
$userId = $_POST['userId']; //BH250001
$userType = $_POST['userType']; //24
$user_type="10";
$status;


if($action == 'pending'){
	$ca_cu_id = ""; //set ca_customer_id to empty
    $identifier_name = 'id=';
	$status= '0';
	$operation = "deleted";
}else if($action == 'registered') {
	$ca_cu_id = $_POST["fid"]; //set ca_customer_id
    $identifier_name = 'ca_customer_id=';
	$status= '3';
	$operation = "deactivated";
} else if($action == 'deactivate') {
	$ca_cu_id = $_POST["fid"]; //set ca_customer_id
    $identifier_name = 'ca_customer_id=';
	$status= '1';					// activate user
	$today = null;
	$operation = "activated";
} else if($action == 'deleted') {
	$ca_cu_id = ""; //set ca_customer_id
    $identifier_name = 'ca_customer_id=';
	$status= '2';					// activate user
	$today = null;
	$operation = "pending";
}

$title="ca_customer";
if($ca_cu_id ==''){
	$message="Deleted ca_customer from ".$action. " list";
	$message2="Deleted ca_customer from ".$action. " list";
}else{
	$message="Deleted ca_customer(".$ca_cu_id.") from ".$action. " list";
	$message2="Deleted ca_customer(".$ca_cu_id.") from ".$action. " list";
}

$fromWhom=$userType;
$register_by=$userType; 


$sql1 = "UPDATE ca_customer SET status=:status, deleted_date=:deleted_date WHERE id='".$id."' ";
$stmt = $conn->prepare($sql1);
$result=  $stmt->execute(array(
	':status' => $status,
	':deleted_date' => $today	
));

if(isset($_POST["fid"])){
	$ca_customer_id = $_POST["fid"];

	$sql2 = "UPDATE login SET status=:status WHERE user_id=:ca_customer_id and user_type_id=:user_type";
	$stmt2 = $conn->prepare($sql2);
	$result2=  $stmt2->execute(array(
		':status' => $status,
		':user_type' => $user_type,
		':ca_customer_id' => $ca_customer_id		
	));

	if ($result2) {
		$sql3= "INSERT INTO logs (user_id,title,message,message2, reference_no, register_by, from_whom,operation) VALUES (:user_id,:title ,:message, :message2, :reference_no, :register_by, :from_whom, :operation)";
		$stmt3 =$conn->prepare($sql3);

		$result3=$stmt3->execute(array(
			':user_id'=> $ca_customer_id,
			':title' => $title,
			':message' => $message,
			':message2' =>$message2,
			':reference_no' => $userId,
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