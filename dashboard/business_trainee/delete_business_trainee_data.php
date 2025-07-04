<?php 
date_default_timezone_set('Asia/Calcutta');
$today = date('Y-m-d H:i:s' );

require "../connect.php";

$id= $_POST["id"];
$action= $_POST["action"];

$user_type="10";
$status;


if($action == 'pending'){
	$ca_cu_id = ""; //set business_trainee_id to empty
    $identifier_name = 'id=';
	$status= '0';
}else if($action == 'registered') {
	$ca_cu_id = $_POST["fid"]; //set business_trainee_id
    $identifier_name = 'business_trainee_id=';
	$status= '3';
} else if($action == 'deactivate') {
	$ca_cu_id = $_POST["fid"]; //set business_trainee_id
    $identifier_name = 'business_trainee_id=';
	$status= '1';					// activate user
	$today = null;
} else if($action == 'deleted') {
	$ca_cu_id = ""; //set business_trainee_id
    $identifier_name = 'business_trainee_id=';
	$status= '2';					// activate user
	$today = null;
}

$title="business_trainee";
if($ca_cu_id ==''){
	$message="Deleted business_trainee from ".$action. " list";
	$message2="Deleted business_trainee from ".$action. " list";
}else{
	$message="Deleted business_trainee(".$ca_cu_id.") from ".$action. " list";
	$message2="Deleted business_trainee(".$ca_cu_id.") from ".$action. " list";
}

$fromWhom="1";
$register_by="1"; 


$sql1 = "UPDATE business_trainee SET status=:status, deleted_date=:deleted_date WHERE id='".$id."' ";
$stmt = $conn->prepare($sql1);
$result=  $stmt->execute(array(
	':status' => $status,
	':deleted_date' => $today	
));

if(isset($_POST["fid"])){
	$business_trainee_id = $_POST["fid"];

	$sql2 = "UPDATE login SET status=:status WHERE user_id=:business_trainee_id and user_type_id=:user_type";
	$stmt2 = $conn->prepare($sql2);
	$result2=  $stmt2->execute(array(
		':status' => $status,
		':user_type' => $user_type,
		':business_trainee_id' => $business_trainee_id		
	));

	if ($result2) {
		$sql3= "INSERT INTO logs (title,message,message2, register_by, from_whom) VALUES (:title ,:message, :message2,  :register_by, :from_whom)";
		$stmt3 =$conn->prepare($sql3);

		$result3=$stmt3->execute(array(
			':title' => $title,
			':message' => $message,
			':message2' =>$message2,
			// ':reference_no' => $f_id,
			':register_by' => $register_by,
			':from_whom' => $fromWhom
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