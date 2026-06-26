<?php

    include_once(__DIR__ . '/../../dashboard_user_details.php');

    $sqlMemOver = $conn->prepare("

        SELECT 

            (
                SELECT COUNT(*)
                FROM cu_coupons
                WHERE user_id = :user_id
            ) AS coupon_total,

            (
                SELECT COUNT(*)
                FROM cu_coupons
                WHERE user_id = :user_id
                AND usage_status = 0
            ) AS active_coupon_total,

            (
                SELECT COUNT(*)
                FROM cu_coupons
                WHERE user_id = :user_id
                AND usage_status = 1
            ) AS used_coupon_total,

            (
                SELECT COALESCE(SUM(coupon_amt), 0)
                FROM cu_coupons
                WHERE user_id = :user_id
            ) AS coupon_total_value,

            (
                SELECT COALESCE(SUM(coupon_amt), 0)
                FROM cu_coupons
                WHERE user_id = :user_id
                AND usage_status = 0
            ) AS active_coupon_value,

            (
                SELECT COALESCE(SUM(coupon_amt), 0)
                FROM cu_coupons
                WHERE user_id = :user_id
                AND usage_status = 1
            ) AS used_coupon_value,

            (
                SELECT COUNT(b.id)
                FROM bookings b
                WHERE b.customer_id = :user_id
            ) AS total_trips

    ");

    $sqlMemOver->execute([
        ":user_id" => $userId
    ]);

    $memberOverview = $sqlMemOver->fetch(PDO::FETCH_ASSOC);

    // JSON RESPONSE
    header('Content-Type: application/json');

    echo json_encode([
        "status" => true,
        "data"   => $memberOverview
    ]);

?>