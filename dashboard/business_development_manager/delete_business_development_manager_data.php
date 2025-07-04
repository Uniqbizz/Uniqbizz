<?php 
date_default_timezone_set('Asia/Calcutta');
$today = date('Y-m-d H:i:s' );

require "../connect.php";

$id= $_POST["id"];
$f_id= $_POST["fid"];
$action= $_POST["action"];
$user_type= "25";
$userId = $_POST['userId']; //BH250001
$userType = $_POST['userType']; //24
$status;

if($action == 'pending'){
	$em_id = ""; //set employee id to empty
    $identifier_name = 'id=';
	$status= '0';
	$operation = "deleted";
}else if($action == 'registered') {
	$em_id = $_POST["fid"]; //set employee id
    $identifier_name = 'employee_id=';
	$status= '3';
	$operation = "deactivated";
} else if($action == 'deactivate') {
	$em_id = $_POST["fid"]; //set employee id
    $identifier_name = 'employee_id=';
	$status= '1';					// activate user
	$today = null;
	$operation = "activated";
} else if($action == 'deleted') {
	$em_id = ""; //set employee id
    $identifier_name = 'employee_id=';
	$status= '2';					// activate user
	$today = null;
	$operation = "pending";
}


 $title="Business Development Manager";
if($em_id ==''){
	$message="Deleted Business Development Manager from ".$action. " list";
	$message2="Deleted Business Development Manager from ".$action. " list";
}else{
	$message="Deleted Business Development Manager(".$em_id.") from ".$action. " list";
	$message2="Deleted Business Development Manager(".$em_id.") from ".$action. " list";
}

$fromWhom = $userType;
$register_by = $userType; 


$sql1 = "UPDATE employees SET status=:status, deleted_date=:deleted_date WHERE id='".$id."' ";
$stmt = $conn->prepare($sql1);
$result=  $stmt->execute(array(
	':status' => $status,
	':deleted_date' => $today	
));

if(isset($_POST["fid"])){
	$employee_id= $_POST["fid"];

	$sql2 = "UPDATE login SET status=:status WHERE user_id=:employee_id and user_type_id=:user_type";
	$stmt2 = $conn->prepare($sql2);
	$result2=  $stmt2->execute(array(
		':status' => $status,
		':user_type' => $user_type,
		':employee_id' => $employee_id		
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