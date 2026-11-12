<?php

require '../../../../connect.php';
header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo json_encode([
        "status" => false,
        "message" => "Invalid request method.",
        "data" => []
    ]);
    exit;
}

try {

    $json = file_get_contents("php://input");
    $data = json_decode($json, true);

    if (!$data) {
        throw new Exception("Invalid JSON data.");
    }

    if (!isset($data['userId']) || empty(trim($data['userId']))) {
        throw new Exception("User ID is required.");
    }

    $userId = trim($data['userId']);

    /*
    |--------------------------------------------------------------------------
    | User Details
    |--------------------------------------------------------------------------
    */

    $stmt = $conn->prepare("
        SELECT *
        FROM ca_travelagency
        WHERE ca_travelagency_id = ?
    ");

    $stmt->execute([$userId]);
    $customer = $stmt->fetch(PDO::FETCH_ASSOC);

    /*
    |--------------------------------------------------------------------------
    | Packages
    |--------------------------------------------------------------------------
    */

    $stmt = $conn->prepare("
        SELECT *
        FROM package
        ORDER BY id DESC
        LIMIT 12
    ");

    $stmt->execute();
    $packages = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $package_array = [];

    foreach ($packages as $package) {

        // Price
        $priceStmt = $conn->prepare("
            SELECT total_package_price_per_adult
            FROM package_pricing
            WHERE package_id = ?
            ORDER BY id DESC
            LIMIT 1
        ");

        $priceStmt->execute([$package['id']]);
        $price = $priceStmt->fetchColumn();

        // Image
        $imageStmt = $conn->prepare("
            SELECT image
            FROM package_pictures
            WHERE package_id = ?
            ORDER BY id ASC
            LIMIT 1
        ");

        $imageStmt->execute([$package['id']]);
        $image = $imageStmt->fetchColumn();

        $days = (int)$package['tour_days'];

        $package_array[] = [
            'packid'   => (int)$package['id'],
            'packname' => $package['name'],
            'duration' => ($days - 1) . 'N / ' . $days . 'D',
            'price'    => (float)($price ?: 0),
            'image'    => $image ?: ''
        ];
    }

    echo json_encode([
        "status" => true,
        "message" => "Data fetched successfully.",
        "data" => [
            // "customer" => $customer ?: new stdClass(),
            "packages" => $package_array
        ]
    ]);

} catch (Exception $e) {

    echo json_encode([
        "status" => false,
        "message" => $e->getMessage(),
        "data" => []
    ]);
}