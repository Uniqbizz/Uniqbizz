<?php

header('Content-Type: application/json');

include_once(__DIR__ . '/../../../dashboard_user_details.php');

try {

    $userId = $_GET['user_id'] ?? '';

    if (empty($userId)) {
        echo json_encode([
            'status' => false,
            'message' => 'User ID is required'
        ]);
        exit;
    }

    $sql = $conn->prepare("
        SELECT
            bd.account_holder_name,
            bd.bank_name,
            bd.account_number,
            bd.ifsc_code,
            bd.branch_name,
            'NA' AS upi_id
        FROM bank_details bd
        INNER JOIN super_techno_enterprise ste
            ON ste.application_id = bd.application_id
        WHERE ste.super_techno_enterprise_id = :user_id
        LIMIT 1
    ");

    $sql->execute([
        ':user_id' => $userId
    ]);

    $data = $sql->fetch(PDO::FETCH_ASSOC);

    if ($data) {

        echo json_encode([
            'status' => true,
            'data' => $data
        ]);

    } else {

        echo json_encode([
            'status' => false,
            'message' => 'Bank details not found'
        ]);
    }

} catch(PDOException $e) {

    echo json_encode([
        'status' => false,
        'message' => $e->getMessage()
    ]);
}