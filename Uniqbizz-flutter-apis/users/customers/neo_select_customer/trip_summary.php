<?php

header('Content-Type: application/json');
require '../../../../../connect.php';

try {

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception("Invalid request method");
    }

    $requestData = json_decode(file_get_contents("php://input"), true);

    if (!$requestData) {
        throw new Exception("Invalid JSON data");
    }

    if (!isset($requestData['userId']) || empty(trim($requestData['userId']))) {
        throw new Exception("userId is required");
    }

    $userId = trim($requestData['userId']);

    $sqlBooking = $conn->prepare("
        SELECT 
            COALESCE(SUM(CASE WHEN p.category_id = 2 THEN 1 ELSE 0 END), 0) AS domestic_trip,
            
            COALESCE(SUM(CASE WHEN p.category_id = 1 THEN 1 ELSE 0 END), 0) AS international_trip,
            
            COALESCE(SUM(CASE WHEN b.date > CURDATE() THEN 1 ELSE 0 END), 0) AS upcoming_trip

        FROM bookings b
        INNER JOIN package p ON p.id = b.package_id
        WHERE b.customer_id = :user_id
    ");

    $sqlBooking->execute([
        ':user_id' => $userId
    ]);

    $bookingArray = $sqlBooking->fetch(PDO::FETCH_ASSOC);

    echo json_encode([
        "status" => true,
        "data"   => $bookingArray
    ]);

} catch (Exception $e) {

    echo json_encode([
        "status"  => false,
        "message" => $e->getMessage()
    ]);

}