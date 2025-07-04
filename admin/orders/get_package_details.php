<?php
require '../connect.php';
header('Content-Type: application/json');

$response = ['status' => 'error'];

if (isset($_POST['package_id'])) {
    $packageId = $_POST['package_id'];

    // Fetch package price
    $stmt = $conn->prepare("SELECT total_package_price_per_adult,total_package_price_per_child FROM package_pricing WHERE package_id = ?");
    $stmt->execute([$packageId]);
    $package = $stmt->fetch(PDO::FETCH_ASSOC);

    // Fetch images
    $stmtImg = $conn->prepare("SELECT image FROM package_pictures WHERE package_id = ?");
    $stmtImg->execute([$packageId]);
    $images = $stmtImg->fetchAll(PDO::FETCH_COLUMN);

    if ($package) {
        $response = [
            'status' => 'success',
            'aprice' => $package['total_package_price_per_adult'],
            'cprice' => $package['total_package_price_per_child'],
            'gst'    => $package['net_gst']??0,
            'images' => array_map(function($img) {
                return '../../' . $img; // adjust path if needed
            }, $images)
        ];
    }
}

echo json_encode($response);
?>