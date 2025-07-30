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
$user_type = "16";
$status = null;

if ($action == 'pending') {
    $ta_id = ""; // Set corporate_agency id to empty
    $identifier_name = 'id=';
    $status = '0';
} elseif ($action == 'registered') {
    $identifier_name = 'corporate_agency_id=';
    $status = '3';
} elseif ($action == 'deactivate') {
    $identifier_name = 'corporate_agency_id=';
    $status = '1'; // Deactivate user
    $today = null;
} elseif ($action == 'deleted') {
    $identifier_name = 'corporate_agency_id=';
    $status = '2'; // Delete user
    $today = null;
}

$title="Techno Enterprise";
if($ta_id ==''){
	$message="Deleted Techno Enterprise from ".$action. " list";
	$message2="Deleted Techno Enterprise from ".$action. " list";
}else{
	$message="Deleted Techno Enterprise(".$ta_id.") from ".$action. " list";
	$message2="Deleted Techno Enterprise(".$ta_id.") from ".$action. " list";
}

$fromWhom="1";
$register_by="1"; 
$operation = "Delete";

$sql1 = "UPDATE corporate_agency SET status=:status, deleted_date=:deleted_date WHERE id=:id";
$stmt = $conn->prepare($sql1);
$result = $stmt->execute([
    ':status' => $status,
    ':deleted_date' => $today,
    ':id' => $id
]);

if (!empty($ta_id)) {
    $sql2 = "UPDATE login SET status=:status WHERE user_id=:travel_agent_id AND user_type_id=:user_type";
    $stmt2 = $conn->prepare($sql2);
    $result2 = $stmt2->execute([
        ':status' => $status,
        ':user_type' => $user_type,
        ':travel_agent_id' => $ta_id
    ]);

    if ($result2) {
        $sql3 = "INSERT INTO logs (title,message,message2, reference_no, register_by, from_whom, operation) VALUES (:title ,:message, :message2, :reference_no, :register_by, :from_whom, :operation)";
        $stmt3 = $conn->prepare($sql3);

        $stmt3->execute([
            ':title' => $title,
			':message' => $message,
			':message2' =>$message2,
			':reference_no' => $id,
			':register_by' => $register_by,
			':from_whom' => $fromWhom,
            ':operation' => $operation
        ]);
    }
}

if ($result) {
    echo json_encode(['status' => 'success', 'message' => 'Action completed successfully']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Database operation failed']);
}
?>
