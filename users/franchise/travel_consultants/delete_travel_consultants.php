<?php
header('Content-Type: application/json');

date_default_timezone_set('Asia/Calcutta');
$today = date('Y-m-d H:i:s');

require "../../../connect.php";

// Initialize response array
$response = [];

// Only accept POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $response['success'] = false;
    $response['message'] = 'Only POST requests are allowed';
    echo json_encode($response);
    exit;
}

// Get input data
$input = json_decode(file_get_contents('php://input'), true) ?: $_POST;

$id = $input["id"];
$action = $input["action"];
$refid = $input["refid"];
$user_type = "11";
$userId = $input['userId']; //BH250001
$userType = $input['userType']; //24
$status;

if ($action == 'pending') {
    $tc_id = ""; //set ca_travelagency_id to empty
    $identifier_name = 'id=';
    $status = '0';
    $operation = "deleted";
} else if ($action == 'registered') {
    if (!isset($input["fid"])) {
        $response['success'] = false;
        $response['message'] = 'Missing fid parameter for registered action';
        echo json_encode($response);
        exit;
    }
    $tc_id = $input["fid"]; //set ca_travelagency_id
    $identifier_name = 'ca_travelagency_id=';
    $status = '3';
    $operation = "deactivated";
} else if ($action == 'deactivate') {
    if (!isset($input["fid"])) {
        $response['success'] = false;
        $response['message'] = 'Missing fid parameter for deactivate action';
        echo json_encode($response);
        exit;
    }
    $tc_id = $input["fid"]; //set ca_travelagency_id
    $identifier_name = 'ca_travelagency_id=';
    $status = '1';                    // activate user
    $today = null;
    $operation = "activated";
} else if ($action == 'deleted') {
    $tc_id = ""; //set ca_travelagency_id
    $identifier_name = 'ca_travelagency_id=';
    $status = '2';                    // activate user
    $today = null;
    $operation = "pending";
} else {
    $response['success'] = false;
    $response['message'] = 'Invalid action';
    echo json_encode($response);
    exit;
}

$title = "Travel Consultant";
if ($tc_id == '') {
    $message = "Deleted Travel Consultant from " . $action . " list";
    $message2 = "Deleted Travel Consultant from " . $action . " list";
} else {
    $message = "Deleted Travel Consultant(" . $tc_id . ") from " . $action . " list";
    $message2 = "Deleted Travel Consultant(" . $tc_id . ") from " . $action . " list";
}

$fromWhom = $userType;
$register_by = $userType;

$sql1 = "UPDATE ca_travelagency SET status=:status, deleted_date=:deleted_date WHERE id='" . $id . "' ";
$stmt = $conn->prepare($sql1);
$result = $stmt->execute(array(
    ':status' => $status,
    ':deleted_date' => $today
));

if (isset($input["fid"])) {
    $ca_travelagency_id = $input["fid"];

    $sql2 = "UPDATE login SET status=:status WHERE user_id=:ca_travelagency_id and user_type_id=:user_type";
    $stmt2 = $conn->prepare($sql2);
    $result2 = $stmt2->execute(array(
        ':status' => $status,
        ':user_type' => $user_type,
        ':ca_travelagency_id' => $ca_travelagency_id
    ));

    if ($result2) {
        $sql3 = "INSERT INTO logs (user_id,title,message,message2,reference_no, register_by, from_whom,operation) VALUES (:user_id,:title ,:message, :message2,:reference_no, :register_by, :from_whom,:operation)";
        $stmt3 = $conn->prepare($sql3);

        $result3 = $stmt3->execute(array(
            ':user_id' => $ca_travelagency_id,
            ':title' => $title,
            ':message' => $message,
            ':message2' => $message2,
            ':reference_no' => $userId,
            ':register_by' => $register_by,
            ':from_whom' => $fromWhom,
            ':operation' => $operation
        ));

        if ($result3) {
            $response['success'] = true;
            $response['message'] = 'Logs updated successfully';
            $response['status'] = $status;
            echo json_encode($response);
        } else {
            $response['success'] = true;
            $response['message'] = 'Travel consultant updated but log entry failed';
            $response['status'] = $status;
            echo json_encode($response);
        }
    } else {
        $response['success'] = true;
        $response['message'] = 'Travel consultant updated but login update failed';
        $response['status'] = $status;
        echo json_encode($response);
    }
} else if ($result) {
    $response['success'] = true;
    $response['message'] = 'Operation completed successfully';
    $response['status'] = $status;
    echo json_encode($response);
} else {
    $response['success'] = false;
    $response['message'] = 'Operation failed';
    $response['status'] = $status;
    echo json_encode($response);
}
?>