<?php 
date_default_timezone_set('Asia/Calcutta');
$today = date('Y-m-d H:i:s');

require "../connect.php";

// Capture JSON data
$data = json_decode(file_get_contents('php://input'), true);
if (!$data) {
    echo json_encode(["status" => "error", "message" => "Invalid JSON data"]);
    exit;
}

$id = $data["id"] ?? null;
$user_type = "10";
$status = null;
$action = $data["action"] ?? null;
$ta_id = $data["refid"] ?? "";

if (!$id || !$action) {
    echo json_encode(["status" => "error", "message" => "Missing required fields"]);
    exit;
}

// Determine action and status
switch ($action) {
    case 'pending':
        $ta_id = "";
        $status = '0';
        break;
    case 'registered':
        $status = '3';
        break;
    case 'deactivate':
        $status = '1';
        $today = null;
        break;
    case 'deleted':
        $ta_id = "";
        $status = '2';
        $today = null;
        break;
    default:
        echo json_encode(["status" => "error", "message" => "Invalid action"]);
        exit;
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
$operation = "Delete";


$sql1 = "UPDATE ca_customer SET status=:status, deleted_date=:deleted_date WHERE id='".$id."' ";
$stmt = $conn->prepare($sql1);
$result=  $stmt->execute(array(
	':status' => $status,
	':deleted_date' => $today	
));

if(isset($data["refid"])){
	$ca_customer_id= $data["refid"];

	$sql2 = "UPDATE login SET status=:status WHERE user_id=:ca_customer_id and user_type_id=:user_type";
	$stmt2 = $conn->prepare($sql2);
	$result2=  $stmt2->execute(array(
		':status' => $status,
		':user_type' => $user_type,
		':ca_customer_id' => $ca_customer_id		
	));

	if ($result2) {
		$sql3= "INSERT INTO logs (user_id,title,message,message2, reference_no, register_by, from_whom,operation) VALUES (:user_id,:title ,:message, :message2, :reference_no, :register_by, :from_whom,:operation)";
		$stmt3 =$conn->prepare($sql3);

		$result3=$stmt3->execute(array(
            ':user_id' => $ca_customer_id,
			':title' => $title,
			':message' => $message,
			':message2' =>$message2,
			':reference_no' => $ta_id,
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