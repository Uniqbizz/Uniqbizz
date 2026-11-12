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
        throw new Exception("userId is required.");
    }

    $userId = trim($data['userId']);

    $sql = $conn->prepare("
        SELECT
            (
                SELECT COUNT(*)
                FROM ca_customer ca
                WHERE ca.ta_reference_no = :userId
                AND ca.status = 1
            ) AS reg_cu_count,

            (
                SELECT IFNULL(SUM(cu.commision_tc),0)
                FROM ca_cu_payout cu
                WHERE cu.travel_consultant = :userId
            ) AS activation_amount,

            (
                SELECT IFNULL(SUM(pu.ta_amt),0)
                FROM product_payout pu
                WHERE pu.ta_id = :userId
            ) AS trip_amount,

            (
                (
                    SELECT IFNULL(SUM(cu.commision_tc),0)
                    FROM ca_cu_payout cu
                    WHERE cu.travel_consultant = :userId
                ) +
                (
                    SELECT IFNULL(SUM(pu.ta_amt),0)
                    FROM product_payout pu
                    WHERE pu.ta_id = :userId
                )
            ) AS total_comm
    ");

    $sql->execute([
        ':userId' => $userId
    ]);

    $result = $sql->fetch(PDO::FETCH_ASSOC);

    echo json_encode([
        "status" => true,
        "message" => "Data fetched successfully.",
        "data" => [
            "total_active_customers" => (int)$result['reg_cu_count'],
            "commission_earned" => (float)$result['total_comm'],
            "from_activation" => (float)$result['activation_amount'],
            "from_trips_completed" => (float)$result['trip_amount']
        ]
    ]);

} catch (Exception $e) {

    echo json_encode([
        "status" => false,
        "message" => $e->getMessage(),
        "data" => []
    ]);
}