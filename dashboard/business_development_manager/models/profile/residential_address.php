<?php

header('Content-Type: application/json');

include_once(__DIR__ . '/../../../dashboard_user_details.php');

try {

    $userId = $_GET['user_id'] ?? '';

    if (empty($userId)) {
        echo json_encode([
            'status'  => false,
            'message' => 'User ID is required'
        ]);
        exit;
    }

    $sqlUserDetails = $conn->prepare("
        SELECT
            cty.zone_name,
            sta.branch_name,
            cun.country_name,
            ste.address AS resAdd
        FROM employees ste
        LEFT JOIN zone cty
            ON cty.id = ste.zone
        LEFT JOIN branch sta
            ON sta.id = ste.branch
        LEFT JOIN countries cun
            ON cun.country_code = ste.country_code
        WHERE ste.employee_id = :user_id
        LIMIT 1
    ");

    $sqlUserDetails->execute([
        ':user_id' => $userId
    ]);

    $userDetails = $sqlUserDetails->fetch(PDO::FETCH_ASSOC);

    if ($userDetails) {

        echo json_encode([
            'status' => true,
            'data'   => [
                'zone_name'    => $userDetails['zone_name'] ?? '',
                'branch_name'   => $userDetails['branch_name'] ?? '',
                'country_name' => $userDetails['country_name'] ?? '',
                'resAdd'      => $userDetails['resAdd'] ?? ''
            ]
        ]);

    } else {

        echo json_encode([
            'status'  => false,
            'message' => 'User not found'
        ]);
    }

} catch (PDOException $e) {

    echo json_encode([
        'status'  => false,
        'message' => $e->getMessage()
    ]);
}