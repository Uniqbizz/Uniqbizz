<?php
require '../../connect.php'; // Include your database connection
header('Content-Type: application/json');

if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo json_encode(["status" => "error", "message" => "Package ID is required"]);
    exit;
}

$package_id = intval($_GET['id']); // Convert to integer for safety

try {
    // Use parameterized query
    $sql = "SELECT * FROM `package_pricing_markup` WHERE `package_id` = :package_id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':package_id', $package_id, PDO::PARAM_INT);
    $stmt->execute();
    $packages = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($packages) {
        echo json_encode(["status" => "success", "data" => $packages]);
    } else {
        echo json_encode(["status" => "error", "message" => "No package found"]);
    }
} catch (PDOException $e) {
    echo json_encode(["status" => "error", "message" => $e->getMessage()]);
}
?>
