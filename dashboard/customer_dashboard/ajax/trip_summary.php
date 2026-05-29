<?php
    include_once(__DIR__ . '/../../dashboard_user_details.php');
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
        "user_id"=>$userId
    ]);
    //get data
    $bookingArray = $sqlBooking->fetch(PDO::FETCH_ASSOC);
    // return json
    header('Content-Type: application/json');

    echo json_encode([
        "status" => true,
        "data" => $bookingArray
    ]);
?>