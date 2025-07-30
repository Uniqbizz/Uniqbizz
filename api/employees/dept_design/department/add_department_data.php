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

    $deptName = getData('name');
    $status = '1';

    $sql = "INSERT INTO `department` (dept_name,status) VALUES (:dept_name,:status)";
    $stmt = $conn->prepare($sql);
    $result = $stmt->execute(array(
        ':dept_name' => $deptName,
        ':status' => $status
    ));

    if($result){
        echo json_encode(["status" => "success", "message" => "Department Added successfully!"]);
    }else{
        echo json_encode(["status" => "success", "message" => "Failed to insert Department!"]);
    }
?>