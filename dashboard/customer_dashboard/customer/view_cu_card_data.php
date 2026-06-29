<?php

include_once(__DIR__ . '/../../dashboard_user_details.php');

header('Content-Type: application/json');

try {

    $sql = "SELECT
                (SELECT COUNT(*)
                 FROM ca_customer
                 WHERE reference_no = :userId
                 AND status IN (2,0)) AS pending_cu,

                (SELECT COUNT(*)
                 FROM ca_customer
                 WHERE reference_no = :userId
                 AND status IN (1,3)) AS registered_cu,

                (SELECT COUNT(*)
                 FROM ca_customer
                 WHERE reference_no = :userId) AS total_cu,

                (SELECT COALESCE(SUM(referral_amount),0)
                 FROM customer_reference_payout
                 WHERE customer_id = :userId) AS rewards_earned";

    $stmt = $conn->prepare($sql);
    $stmt->execute([
        ':userId' => $userId
    ]);

    $data = $stmt->fetch(PDO::FETCH_ASSOC);

    echo json_encode([
        "status" => true,
        "data"   => $data
    ]);

} catch (Exception $e) {

    echo json_encode([
        "status" => false,
        "message" => $e->getMessage()
    ]);

}