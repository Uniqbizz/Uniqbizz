<?php

include_once(__DIR__ . '/../../../dashboard_user_details.php');

header('Content-Type: application/json');

try {

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

    $data = $sql->fetch(PDO::FETCH_ASSOC);

    echo json_encode([
        'status' => true,
        'data'   => $data
    ]);

} catch (Exception $e) {

    echo json_encode([
        'status' => false,
        'message' => $e->getMessage(),
        'data' => []
    ]);

}