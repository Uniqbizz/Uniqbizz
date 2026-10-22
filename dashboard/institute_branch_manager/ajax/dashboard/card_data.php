<?php

include_once(__DIR__ . '/../../../dashboard_user_details.php');

header('Content-Type: application/json');

try {

    // Dashboard summary
    $sql = $conn->prepare("
        SELECT

            (
                SELECT CONCAT(ca.firstname, ' ', ca.lastname)
                FROM institution_branch_manager ca
                WHERE ca.institution_branch_manager_id = :customerUserId
                LIMIT 1
            ) AS name,
            (
                SELECT COUNT(*)
                FROM ca_customer ca
                WHERE ca.ta_reference_no = :customerUserId
                  AND ca.status = 1
            ) AS reg_cu_count,

            (
                SELECT IFNULL(SUM(cu.commision_tc), 0)
                FROM ca_cu_payout cu
                WHERE cu.travel_consultant = :activationUserId
            ) AS activation_amount,

            (
                SELECT IFNULL(SUM(pu.ta_amt), 0)
                FROM product_payout pu
                WHERE pu.ta_id = :tripUserId
            ) AS trip_amount,

            (
                SELECT COUNT(*)
                FROM bookings b
                WHERE b.ta_id = :bookingUserId
            ) AS booking_count
    ");

    $sql->execute([
        ':customerUserId'   => $userId,
        ':activationUserId' => $userId,
        ':tripUserId'       => $userId,
        ':bookingUserId'    => $userId
    ]);

    $data = $sql->fetch(PDO::FETCH_ASSOC);

    // Destination-wise booking counts
    $destinationSql = $conn->prepare("
        SELECT
            p.destination,
            COUNT(*) AS trip_count
        FROM bookings b
        INNER JOIN package p
            ON p.id = b.package_id
        WHERE b.ta_id = :destinationUserId
        GROUP BY p.destination
        ORDER BY trip_count DESC, p.destination ASC
    ");

    $destinationSql->execute([
        ':destinationUserId' => $userId
    ]);

    $destinations = $destinationSql->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode([
        'status' => true,
        'data' => [
            'name'    => $data['name'],
            'reg_cu_count'    => (int) $data['reg_cu_count'],
            'activation_amount' => (float) $data['activation_amount'],
            'trip_amount'     => (float) $data['trip_amount'],
            'total_comm'      => (float) $data['activation_amount']
                                + (float) $data['trip_amount'],
            'booking_count'   => (int) $data['booking_count'],
            'destinations'    => $destinations
        ]
    ]);

} catch (Exception $e) {

    http_response_code(500);

    echo json_encode([
        'status' => false,
        'message' => $e->getMessage(),
        'data' => []
    ]);
}