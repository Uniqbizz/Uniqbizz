<?php 
date_default_timezone_set('Asia/Calcutta');
$today = date('Y-m-d H:i:s' );

require "../connect.php";

header('Content-Type: application/json');

// Read JSON input correctly
$json = file_get_contents("php://input");
$data = json_decode($json, true);

// Debugging: Check if JSON decoding worked
if (!$data) {
    echo json_encode(["status" => "error", "message" => "Invalid JSON input"]);
    exit;
}

$id = $data['id'] ?? null;
$f_id = $data['refid'] ?? null;
$action = $data['action'] ?? null;

if (!$id || !$f_id || !$action) {
    echo json_encode(["status" => "error", "message" => "Invalid input data"]);
    exit;
}

$user_type="26";

$status;

if($action == 'pending'){
	$ta_id = ""; //set business_mentor id to empty
    $identifier_name = 'id=';
	$status= '0';
	// echo json_encode(["status" => "success", "message" => "Status updated to $status"]);
}else if($action == 'registered') {
	$ta_id = $data['refid'];
    $identifier_name = 'business_mentor_id=';
	$status= '3';
	// echo json_encode(["status" => "success", "message" => "Status updated to $status"]);
} else if($action == 'deactivate') {
	$ta_id = $data["refid"]; //set business_mentor id
    $identifier_name = 'business_mentor_id=';
	$status= '1';					// activate user
	// echo json_encode(["status" => "success", "message" => "Status updated to $status"]);
	$today = null;
} else if($action == 'deleted') {
	$ta_id = ""; //set business_mentor id
    $identifier_name = 'business_mentor_id=';
	$status= '2';					// activate user
	// echo json_encode(["status" => "success", "message" => "Status updated to $status"]);
	$today = null;
}


$title="Business Mentor";
if($ta_id ==''){
	$message="Deleted Business Mentor from ".$action. " list";
	$message2="Deleted Business Mentor from ".$action. " list";
}else{
	$message="Deleted Business Mentor(".$ta_id.") from ".$action. " list";
	$message2="Deleted Business Mentor(".$ta_id.") from ".$action. " list";
}

$fromWhom="1";
$register_by="1"; 

$sql1 = "UPDATE business_mentor SET status=:status, deleted_date=:deleted_date WHERE id='".$id."' ";
$stmt = $conn->prepare($sql1);
$result=  $stmt->execute(array(
	':status' => $status,
	':deleted_date' => $today	
));

if(isset($data["refid"])){
	$business_mentor_id= $data["refid"];
	$operation = "Delete";

	$sql2 = "UPDATE login SET status=:status WHERE user_id=:business_mentor_id and user_type_id=:user_type";
	$stmt2 = $conn->prepare($sql2);
	$result2=  $stmt2->execute(array(
		':status' => $status,
		':user_type' => $user_type,
		':business_mentor_id' => $business_mentor_id		
	));

	if ($result2) {
		$sql3= "INSERT INTO logs (title,message,message2, register_by, from_whom, operation) VALUES (:title ,:message, :message2, :register_by, :from_whom, :operation)";
		$stmt3 =$conn->prepare($sql3);

		$result3=$stmt3->execute(array(
			':title' => $title,
			':message' => $message,
			':message2' =>$message2,
			// ':reference_no' => $f_id,
			':register_by' => $register_by,
			':from_whom' => $fromWhom,
			':operation' => $operation
		));
	} 
}

if ($result) {
    echo json_encode(["status" => "success", "message" => "Action completed successfully", "action" => $action]);
} else {
    echo json_encode(["status" => "error", "message" => "Failed to update customer status"]);
}

?>