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

    $sqlMemOver = $conn->prepare("

        SELECT 

            (
                SELECT COUNT(*)
                FROM cu_coupons
                WHERE user_id = :user_id
            ) AS total_vouchers,

            (
                SELECT COALESCE(SUM(coupon_amt), 0)
                FROM cu_coupons
                WHERE user_id = :user_id
            ) AS coupon_total_value,

            (
                SELECT COUNT(*)
                FROM cu_coupons
                WHERE user_id = :user_id
                AND usage_status = 1
            ) AS vouchers_used,

            (
                SELECT COALESCE(SUM(coupon_amt), 0)
                FROM cu_coupons
                WHERE user_id = :user_id
                AND usage_status = 1
            ) AS used_coupon_value,

            (
                SELECT COUNT(*)
                FROM cu_coupons
                WHERE user_id = :user_id
                AND usage_status = 0
            ) AS vouchers_remaining,

            (
                SELECT COALESCE(SUM(coupon_amt), 0)
                FROM cu_coupons
                WHERE user_id = :user_id
                AND usage_status = 0
            ) AS active_coupon_value,

            (
                SELECT COUNT(b.id)
                FROM bookings b
                WHERE b.customer_id = :user_id
            ) AS total_trips          

    ");

    $sqlMemOver->execute([
        ':user_id' => $userId
    ]);

    $memberOverview = $sqlMemOver->fetch(PDO::FETCH_ASSOC);

    echo json_encode([
        "status" => true,
        "data"   => $memberOverview
    ]);

} catch (Exception $e) {

    echo json_encode([
        "status"  => false,
        "message" => $e->getMessage()
    ]);

}