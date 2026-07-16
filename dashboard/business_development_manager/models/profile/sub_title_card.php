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
            3 AS total_documents,
            (
                CASE WHEN ste.profile_pic IS NOT NULL AND ste.profile_pic <> '' THEN 1 ELSE 0 END +
                CASE WHEN ste.id_proof IS NOT NULL AND ste.id_proof <> '' THEN 1 ELSE 0 END +
                CASE WHEN ste.bank_details IS NOT NULL AND ste.bank_details <> '' THEN 1 ELSE 0 END  
            ) AS uploaded_files,
            CASE
                WHEN ste.profile_pic IS NOT NULL
                    AND ste.profile_pic <> ''
                    AND ste.id_proof IS NOT NULL
                    AND ste.id_proof <> ''
                THEN 'Completed'
                ELSE 'Incomplete'
            END AS kyc_status

        FROM employees ste

        WHERE ste.employee_id = :user_id

        LIMIT 1
        
    ");

    $sqlUserDetails->execute([
        ':user_id' => $userId
    ]);

    $userDetails = $sqlUserDetails->fetch(PDO::FETCH_ASSOC);

    if (!$userDetails) {

        echo json_encode([
            'status'  => false,
            'message' => 'User not found'
        ]);
        exit;
    }

    // $verificationStatus = 'Pending';
    $verificationStatus = 'Verified';

    // if (!empty($userDetails['payload'])) {

    //     $payload = json_decode($userDetails['payload'], true);

    //     if (is_array($payload) && !empty($payload)) {

    //         $statuses = array_map(function ($value) {
    //             return strtolower(trim($value));
    //         }, $payload);

    //         if (in_array('rejected', $statuses, true)) {

    //             $verificationStatus = 'Rejected';

    //         } elseif (count(array_filter($statuses, function ($value) {
    //             return $value === 'approved';
    //         })) === count($statuses)) {

    //             $verificationStatus = 'Verified';
    //         }
    //     }
    // }

    // unset($userDetails['payload']);

    $userDetails['verification_status'] = $verificationStatus;

    echo json_encode([
        'status' => true,
        'data'   => $userDetails
    ]);

} catch (PDOException $e) {

    echo json_encode([
        'status'  => false,
        'message' => $e->getMessage()
    ]);
}