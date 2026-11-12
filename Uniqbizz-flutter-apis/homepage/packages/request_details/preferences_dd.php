<?php
header('Content-Type: application/json; charset=utf-8');

require '../../../../connect.php';

// =====================================================
// INPUTS
// =====================================================
$data = json_decode(file_get_contents('php://input'), true);

$id = isset($data['pacId']) ? (int)$data['pacId'] : 0;

if ($id <= 0) {
    http_response_code(400);
    echo json_encode(['status' => false, 'message' => 'Invalid package ID']);
    exit;
}

try {

    // package
    $stmt = $conn->prepare("SELECT * FROM package WHERE id = $id AND status = '1' AND visibility = 1 AND DATE(validity) >= CURRENT_DATE");
    $stmt->execute();
    $package = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$package) {
        http_response_code(404);
        echo json_encode(['status' => false, 'message' => 'Package not found, expired or not visible']);
        exit;
    }

    $hotel_cat_id = $package['category_hotel_id'];
    $meal_cat_id = $package['category_meal_id'];
    $category_vehicle_id = $package['category_vehicle_id'] ?? '';

    // HOTEL CATEGORY
    $sql = $conn->prepare("
        SELECT id, name
        FROM category_hotel
        WHERE status = 1
        ORDER BY id DESC
    ");
    $sql->execute();
    $hotelCategories = $sql->fetchAll(PDO::FETCH_ASSOC);

    // MEAL PREFERENCE
    $sql = $conn->prepare("
        SELECT id, name
        FROM category_meal
        WHERE status = 1
        ORDER BY id DESC
    ");
    $sql->execute();
    $mealCategories = $sql->fetchAll(PDO::FETCH_ASSOC);

    // TRANSPORT
    $sql = $conn->prepare("
        SELECT id, name
        FROM category_vehicle
        WHERE status = 1
        ORDER BY id DESC
    ");
    $sql->execute();
    $vehicleCategories = $sql->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode([
        'status'  => true,
        'message' => 'Preferences fetched successfully',
        'data'    => [
            'hotelCategories'     => $hotelCategories,
            'hotel_cat_id'        => $hotel_cat_id,
            'mealCategories'      => $mealCategories,
            'meal_cat_id'         => $meal_cat_id,
            'vehicleCategories'   => $vehicleCategories,
            'category_vehicle_id' => $category_vehicle_id
        ]
    ]);

} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode([
        'status'  => false,
        'message' => 'Server error',
        'error'   => $e->getMessage()
    ]);
}