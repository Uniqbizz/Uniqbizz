<?php
require '../../connect.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    if (!$data) {
        echo json_encode(["status" => "error", "message" => "Invalid JSON data"]);
        exit;
    }

    $zone_id = $data['zone_id'];

    if (empty($zone_id)) {
        echo json_encode(["status" => "error", "message" => "Zone ID is required"]);
        exit;
    }

    $sql = "SELECT * FROM branch WHERE zone_id = :zone_id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':zone_id', $zone_id, PDO::PARAM_INT);
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);

    if ($stmt->rowCount() > 0) {
        echo json_encode(["status" => "success", "branches" => $stmt->fetchAll()]);
    } else {
        echo json_encode(["status" => "success", "message" => "No branches available for the selected zone"]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request method"]);
}
?>