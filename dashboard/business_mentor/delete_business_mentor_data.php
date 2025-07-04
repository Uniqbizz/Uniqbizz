<?php 
date_default_timezone_set('Asia/Calcutta');
$today = date('Y-m-d H:i:s' );

require "../connect.php";

$f_id= $_POST["fid"];
$id= $_POST["id"];
$user_type="26";
$userId = $_POST['userId']; //BH250001
$userType = $_POST['userType']; //24

$status;
$action= $_POST["action"];

if($action == 'pending'){
	$ta_id = ""; //set business_mentor id to empty
    $identifier_name = 'id=';
	$status= '0';
	$operation = "deleted";
}else if($action == 'registered') {
	$ta_id = $_POST["fid"]; //set business_mentor id
    $identifier_name = 'business_mentor_id=';
	$status= '3';
	$operation = "deactivated";
} else if($action == 'deactivate') {
	$ta_id = $_POST["fid"]; //set business_mentor id
    $identifier_name = 'business_mentor_id=';
	$status= '1';					// activate user
	$today = null;
	$operation = "activated";
} else if($action == 'deleted') {
	$ta_id = ""; //set business_mentor id
    $identifier_name = 'business_mentor_id=';
	$status= '2';					// activate user
	$today = null;
	$operation = "pending";
}


 $title="Business Mentor";
if($ta_id ==''){
	$message="Deleted Business Mentor from ".$action. " list";
	$message2="Deleted Business Mentor from ".$action. " list";
}else{
	$message="Deleted Business Mentor(".$ta_id.") from ".$action. " list";
	$message2="Deleted Business Mentor(".$ta_id.") from ".$action. " list";
}

$fromWhom=$userType;
$register_by=$userType; 
// $operation = "Delete";

$sql1 = "UPDATE business_mentor SET status=:status, deleted_date=:deleted_date WHERE id='".$id."' ";
$stmt = $conn->prepare($sql1);
$result=  $stmt->execute(array(
	':status' => $status,
	':deleted_date' => $today	
));

if(isset($_POST["fid"])){
	$business_mentor_id= $_POST["fid"];

	$sql2 = "UPDATE login SET status=:status WHERE user_id=:business_mentor_id and user_type_id=:user_type";
	$stmt2 = $conn->prepare($sql2);
	$result2=  $stmt2->execute(array(
		':status' => $status,
		':user_type' => $user_type,
		':business_mentor_id' => $business_mentor_id		
	));

	if ($result2) {
		$sql3= "INSERT INTO logs (title,message,message2, reference_no, register_by, from_whom, operation) VALUES (:title ,:message, :message2, :reference_no, :register_by, :from_whom, :operation)";
		$stmt3 =$conn->prepare($sql3);

		$result3=$stmt3->execute(array(
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