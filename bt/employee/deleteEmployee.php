<?php 
date_default_timezone_set('Asia/Calcutta');
$today = date('Y-m-d H:i:s');

require "../connect.php";

$id         = $_POST["id"];
$user_type  = $_POST["userType"]; // 27 for Zonal Manager
$action     = $_POST["action"];

$status = '';
$identifier_field = '';
$employee_id = '';  // will be used as user_id in login and logs
$ta_id = '';
$deleted_date = $today;

// Determine table and identifier field
if ($user_type == 27) {
    $table_name = 'zonal_manager';
    $identifier_field = 'zonal_manager_id';
    $title = "Zonal Manager";
} else {
    $table_name = 'employees';
    $identifier_field = 'employee_id';
    $title = $user_type == 31?"Relationship Manager":"Employee";
}

// Action-specific behavior
switch ($action) {
    case 'pending':
        $status = '0';
        $employee_id = ''; // Blank in logs for pending
        break;

    case 'registered':
        $status = '3';
        $ta_id = $_POST["fid"] ?? '';
        $employee_id = $ta_id;
        break;

    case 'deactivate':
        $status = '1';
        $ta_id = $_POST["fid"] ?? '';
        $employee_id = $ta_id;
        $deleted_date = null;
        break;

    case 'deleted':
        $status = '2';
        $ta_id = "";
        $employee_id = $_POST["fid"] ?? '';
        $deleted_date = null;
        break;

    default:
        echo "Invalid action.";
        exit;
}

// Generate log messages
if ($user_type == 27) {
    $message  = $employee_id ? "Zonal Manager ($employee_id) has been removed from the $action list" : "Zonal Manager removed from the $action list";
    $operation = "Zonal $action";
} else {
    $message = $employee_id
    ? ($user_type == 31 
        ? "Relationship Manager ($employee_id) has been removed from the $action list"
        : "Employee ($employee_id) has been removed from the $action list")
    : "Employee removed from the $action list";
    $operation = "Employee $action";
}
$message2 = $message;

$fromWhom    = "15";
$register_by = "15";

// Update main table (employees or zonal_manager)
$sql1 = "UPDATE `$table_name` SET status = :status, deleted_date = :deleted_date WHERE id = :id";
$stmt1 = $conn->prepare($sql1);
$result = $stmt1->execute([
    ':status'       => $status,
    ':deleted_date' => $deleted_date,
    ':id'           => $id
]);

// If not pending, update login table
if ($employee_id !== '') {
    $sql2 = "UPDATE login SET status = :status WHERE user_id = :employee_id AND user_type_id = :user_type";
    $stmt2 = $conn->prepare($sql2);
    $stmt2->execute([
        ':status'      => $status,
        ':user_type'   => $user_type,
        ':employee_id' => $employee_id
    ]);
}

// Always insert log (user_id will be blank if pending)
$sql3 = "INSERT INTO logs (user_id, title, message, message2, reference_no, register_by, from_whom, operation)
         VALUES (:user_id, :title, :message, :message2, '', :register_by, :from_whom, :operation)";
$stmt3 = $conn->prepare($sql3);
$stmt3->execute([
    ':user_id'     => $employee_id, // blank if pending
    ':title'       => $title,
    ':message'     => $message,
    ':message2'    => $message2,
    ':register_by' => $register_by,
    ':from_whom'   => $fromWhom,
    ':operation'   => $operation
]);

echo $status;
?>
