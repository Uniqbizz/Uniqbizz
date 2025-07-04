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
    $deptName = getData('name');
    $message = getData('message');
    $status = getData('status');

    $sql = "UPDATE `department` SET dept_name=:dept_name WHERE id=:id ";
    $stmt = $conn->prepare($sql);
    $result = $stmt->execute(array(
        ':dept_name' => $deptName,
        ':id' => $id
    ));

    if($result){
        echo json_encode(["status" => "success", "message" => "Department Edited successfully!"]);
    }else{
        echo json_encode(["status" => "success", "message" => "Failed to Edit Department!"]);
    }
?>