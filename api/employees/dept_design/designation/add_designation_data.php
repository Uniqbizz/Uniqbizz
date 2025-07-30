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

    $designation_name = getData('desig_name');
    $dept_id = getData('dept_id');
    // $dept_name = $_POST['dept_name'];
    $status = '1';

    $stmt2 = $conn->prepare( " SELECT * FROM  `department` WHERE id = '".$dept_id."' AND status = '1' " );
    $stmt2 -> execute();
    $stmt2 -> setFetchMode(PDO::FETCH_ASSOC);
    if($stmt2 -> rowCount()>0){
        foreach( ($stmt2 -> fetchAll()) as $key2 => $row2 ){
            $dept_name = $row2['dept_name'];
        }
    }

    $sql = "INSERT INTO `designation` (designation_name	,dept_id,dept_name,status) VALUES (:designation_name,:dept_id,:dept_name,:status)";
    $stmt = $conn->prepare($sql);
    $result = $stmt->execute(array(
        ':designation_name' =>  $designation_name,
        ':dept_id' => $dept_id,
        ':dept_name' => $dept_name,
        ':status' => $status
    ));

    if($result){
        echo json_encode(["status" => "success", "message" => "Designation Added successfully!"]);
    }else{
        echo json_encode(["status" => "success", "message" => "Failed to insert Designation!"]);
    }
?>