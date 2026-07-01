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
            cty.city_name,
            sta.state_name,
            cun.country_name,
            ste.pincode,
            ste.address AS resAdd
        FROM chief_techno_enterprise ste
        LEFT JOIN cities cty
            ON cty.id = ste.city
        LEFT JOIN states sta
            ON sta.id = ste.state
        LEFT JOIN countries cun
            ON cun.id = ste.country
        WHERE ste.chief_techno_enterprise_id = :user_id
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
                'city_name'    => $userDetails['city_name'] ?? '',
                'state_name'   => $userDetails['state_name'] ?? '',
                'country_name' => $userDetails['country_name'] ?? '',
                'pincode'      => $userDetails['pincode'] ?? '',
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