<?php 
header('Content-Type: application/json');
error_reporting(E_ALL);
ini_set('display_errors', 1);
date_default_timezone_set('Asia/Calcutta');
$today = date('Y-m-d H:i:s');

require "../connect.php";

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['id']) || !isset($data['action'])) {
    echo json_encode(['status' => 'error', 'message' => 'Missing required parameters']);
    exit();
}

$id = $data['id'];
$action = $data['action'];
$ta_id = $data['refid'] ?? "";
$user_type="11";

$status;

if($action == 'pending'){
	$ta_id = ""; //set travel agent id to empty
    $identifier_name = 'id=';
	$status= '0';
}else if($action == 'registered') {
    $identifier_name = 'ca_travelagency_id=';
	$status= '3';
} else if($action == 'deactivate') {
    $identifier_name = 'ca_travelagency_id=';
	$status= '1';					// activate user
	$today = null;
} else if($action == 'deleted') {
	$ta_id = ""; //set travel agent id
    $identifier_name = 'ca_travelagency_id=';
	$status= '2';					// activate user
	$today = null;
}


 $title="Travel Consultant";
if($ta_id ==''){
	$message="Deleted Travel Consultant from ".$action. " list";
	$message2="Deleted Travel Consultant from ".$action. " list";
}else{
	$message="Deleted Travel Consultant(".$ta_id.") from ".$action. " list";
	$message2="Deleted Travel Consultant(".$ta_id.") from ".$action. " list";
}

$fromWhom="1";
$register_by="1"; 
$operation = "Delete";


$sql1 = "UPDATE ca_travelagency SET status=:status, deleted_date=:deleted_date WHERE id='".$id."' ";
$stmt = $conn->prepare($sql1);
$result=  $stmt->execute(array(
	':status' => $status,
	':deleted_date' => $today	
));

if(!empty($ta_id)){
	$sql2 = "UPDATE login SET status=:status WHERE user_id=:business_consultant_id and user_type_id=:user_type";
	$stmt2 = $conn->prepare($sql2);
	$result2=  $stmt2->execute(array(
		':status' => $status,
		':user_type' => $user_type,
		':business_consultant_id' => $ta_id		
	));

	if ($result2) {
		$sql3= "INSERT INTO logs (user_id,title,message,message2, reference_no, register_by, from_whom,operation) VALUES (:user_id,:title ,:message, :message2, :reference_no, :register_by, :from_whom,:operation)";
		$stmt3 =$conn->prepare($sql3);

		$result3=$stmt3->execute(array(
			':user_id' => $ta_id,
			':title' => $title,
			':message' => $message,
			':message2' =>$message2,
			':reference_no' => $id,
			':register_by' => $register_by,
			':from_whom' => $fromWhom,
			':operation' => $operation
		));
    }
}

if ($result) {
	echo json_encode(['status' => 'success', 'message' => 'Action completed successfully']);
}else{
	echo json_encode(['status' => 'error', 'message' => 'Database operation failed']);
}

?>