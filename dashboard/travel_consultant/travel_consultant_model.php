<?php

include_once(__DIR__ . '/../dashboard_user_details.php');

header('Content-Type: application/json');

try {

    // User Details
    $stmt = $conn->prepare("
        SELECT *
        FROM ca_travelagency
        WHERE ca_travelagency_id = ?
    ");

    $stmt->execute([$userId]);
    $customer = $stmt->fetch(PDO::FETCH_ASSOC);

    // Packages
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
            'packid'    => $package['id'],
            'packname'  => $package['name'],
            'duration'  => ($days - 1).'N / '.$days.'D',
            'price'     => $price ?: 0,
            'image'     => $image ?: ''
        ];
    }

    echo json_encode([
        'status'   => true,
        'customer' => $customer,
        'packages' => $package_array
    ]);

} catch (Exception $e) {

    echo json_encode([
        'status' => false,
        'message' => $e->getMessage()
    ]);
}