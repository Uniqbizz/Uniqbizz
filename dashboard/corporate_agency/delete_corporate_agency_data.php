<?php 
date_default_timezone_set('Asia/Calcutta');
$today = date('Y-m-d H:i:s' );

require "../connect.php";

$id= $_POST["id"];
$action= $_POST["action"];
$refid = $_POST["refid"];
$user_type="16";
$userId = $_POST['userId']; //BH250001
$userType = $_POST['userType']; //24
$status;


if($action == 'pending'){
	$te_id = ""; //set corporate_agency to empty
    $identifier_name = 'id=';
	$status= '0';
	$operation = "deleted";
}else if($action == 'registered') {
	$te_id = $_POST["fid"]; //set corporate_agency
    $identifier_name = 'corporate_agency=';
	$status= '3';
	$operation = "deactivated";
} else if($action == 'deactivate') {
	$te_id = $_POST["fid"]; //set corporate_agency
    $identifier_name = 'corporate_agency=';
	$status= '1';					// activate user
	$today = null;
	$operation = "activated";
} else if($action == 'deleted') {
	$te_id = ""; //set corporate_agency
    $identifier_name = 'corporate_agency=';
	$status= '2';					// activate user
	$today = null;
	$operation = "pending";
}

$title="Techno Enterprise";
if($te_id ==''){
	$message="Deleted Techno Enterprise from ".$action. " list";
	$message2="Deleted Techno Enterprise from ".$action. " list";
}else{
	$message="Deleted Techno Enterprise(".$te_id.") from ".$action. " list";
	$message2="Deleted Techno Enterprise(".$te_id.") from ".$action. " list";
}

$fromWhom=$userType;
$register_by=$userType; 
// $operation="Delete";

$sql1 = "UPDATE corporate_agency SET status=:status, deleted_date=:deleted_date WHERE id='".$id."' ";
$stmt = $conn->prepare($sql1);
$result=  $stmt->execute(array(
	':status' => $status,
	':deleted_date' => $today	
));

if(isset($_POST["fid"])){
	$corporate_agency_id = $_POST["fid"];

	$sql2 = "UPDATE login SET status=:status WHERE user_id=:corporate_agency_id and user_type_id=:user_type";
	$stmt2 = $conn->prepare($sql2);
	$result2=  $stmt2->execute(array(
		':status' => $status,
		':user_type' => $user_type,
		':corporate_agency_id' => $corporate_agency_id		
	));

	if ($result2) {
		$sql3= "INSERT INTO logs (user_id,title,message,message2,reference_no, register_by, from_whom, operation) VALUES (:user_id,:title ,:message, :message2,:reference_no,  :register_by, :from_whom, :operation)";
		$stmt3 =$conn->prepare($sql3);

		$result3=$stmt3->execute(array(
			':user_id' => $corporate_agency_id,
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