<?php 
date_default_timezone_set('Asia/Calcutta');
$today = date('Y-m-d H:i:s');

require "../connect.php";

$f_id = $_POST["refid"];
$id = $_POST["id"];
$usertype = $_POST['usertype']; // 'bm' or 'mf'

// Determine user_type_id
$user_type = $usertype == 'bm' ? "26" : ($usertype == 'mf' ? "28" : '');

$status = '';
$action = $_POST["action"];

// Define common status logic
if ($action == 'pending') {
	$ta_id = "";
	$status = '0';
} else if ($action == 'registered') {
	$ta_id = $_POST["refid"];
	$status = '3';
} else if ($action == 'deactivate') {
	$ta_id = $_POST["refid"];
	$status = '1';
	$today = null;
} else if ($action == 'deleted') {
	$ta_id = "";
	$status = '2';
	$today = null;
}

// Prepare logs
$title = ($usertype == 'mf') ? "Master Franchisee" : "Business Mentor";

if ($ta_id == '') {
	$message = "Deleted $title from $action list";
	$message2 = $message;
} else {
	$message = "Deleted $title ($ta_id) from $action list";
	$message2 = $message;
}

$fromWhom = "1";
$register_by = "1";

// Choose table based on user type
if ($usertype == 'bm') {
	$sql1 = "UPDATE business_mentor SET status=:status, deleted_date=:deleted_date WHERE id=:id";
} else if ($usertype == 'mf') {
	$sql1 = "UPDATE master_franchisee SET status=:status, deleted_date=:deleted_date WHERE id=:id";
}

$stmt = $conn->prepare($sql1);
$result = $stmt->execute(array(
	':status' => $status,
	':deleted_date' => $today,
	':id' => $id
));

if (isset($_POST["refid"])) {
	$refid = $_POST["refid"];
	$operation = "Delete";

	// Update login status
	$sql2 = "UPDATE login SET status=:status WHERE user_id=:refid AND user_type_id=:user_type";
	$stmt2 = $conn->prepare($sql2);
	$result2 = $stmt2->execute(array(
		':status' => $status,
		':refid' => $refid,
		':user_type' => $user_type
	));

	if ($result2) {
		// Insert log entry
		$sql3 = "INSERT INTO logs (user_id,title, message, message2, register_by, from_whom, operation)
		         VALUES (:user_id,:title, :message, :message2, :register_by, :from_whom, :operation)";
		$stmt3 = $conn->prepare($sql3);
		$result3 = $stmt3->execute(array(
			':user_id'=>$refid,
			':title' => $title,
			':message' => $message,
			':message2' => $message2,
			':register_by' => $register_by,
			':from_whom' => $fromWhom,
			':operation' => $operation
		));

		echo $status;
	} else {
		echo $status;
	}
} else if ($result) {
	echo $status;
} else {
	echo $status;
}
?>
