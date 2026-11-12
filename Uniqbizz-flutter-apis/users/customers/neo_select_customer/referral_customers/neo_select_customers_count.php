<?php

require '../../../../../connect.php';

header('Content-Type: application/json');

try {

    // Get JSON input
    $input = json_decode(file_get_contents("php://input"), true);

    // Get userId from request
    $userId = $input['userId'] ?? null;

    // Validate userId
    if (empty($userId)) {
        echo json_encode([
            "status" => false,
            "message" => "userId is required"
        ]);
        exit;
    }

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
        "data" => $data
    ]);

} catch (Exception $e) {

    echo json_encode([
        "status" => false,
        "message" => $e->getMessage()
    ]);
}