<?php

require '../../../connect.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(["status" => "error", "message" => "Invalid request method"]);
    exit;
}

// Capture JSON data
$data = json_decode(file_get_contents('php://input'), true);
if (!$data) {
    echo json_encode(["status" => "error", "message" => "Invalid JSON data"]);
    exit;
}

function getData($key, $default = null) {
    global $data;
    return isset($data[$key]) ? trim($data[$key]) : $default;
}

    $id = getData('id');
    $desig_name = getData('name');
    $dept_id = getData('dept_id');
    $dept_name = getData('dept_name');
    $message = getData('message');
    $status = getData('status');

    $sql = "UPDATE `designation` SET status=:status WHERE id=:id ";
    $stmt = $conn->prepare($sql);
    $result = $stmt->execute(array(
        ':status' => $status,
        ':id' => $id
    ));

    if($result){
        echo json_encode(["status" => "success", "message" => "Action successfully!"]);
    }else{
        echo json_encode(["status" => "success", "message" => "Failed to Delete Designation!"]);
    }


?>