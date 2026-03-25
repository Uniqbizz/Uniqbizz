<?php
header("Content-Type: application/json");
require '../../../../connect.php';

try {
    // Get the JSON input
    $request = $_SERVER['REQUEST_METHOD'] === 'POST'
        ? json_decode(file_get_contents('php://input'), true)
        : $_GET;

    $userId = $request['userId'] ?? null;

    // Prepare SQL query
    $sql = "SELECT * FROM cu_coupons WHERE user_id = :fid";
    $stmt = $conn->prepare($sql);
    $stmt->execute([':fid' => $userId]);
    $coupons = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (count($coupons) > 0) {
        echo json_encode([
            "status" => "success",
            "coupons" => $coupons
        ]);
    } else {
        echo json_encode([
            "status" => "success",
            "coupons" => [],
            "message" => "No coupons available"
        ]);
    }
} catch (PDOException $e) {
    echo json_encode([
        "status" => "error",
        "message" => $e->getMessage()
    ]);
}
