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
            pro.current_occupation,
            pro.current_experience,
            pro.current_income
        FROM professional_and_educational pro
        INNER JOIN master_franchisee ste
            ON pro.application_id = ste.application_id
        WHERE ste.master_franchisee_id = :user_id
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
                'current_occupation' => $userDetails['current_occupation'] ?? '',
                'current_experience' => $userDetails['current_experience'] ?? '',
                'current_income'     => $userDetails['current_income'] ?? ''
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