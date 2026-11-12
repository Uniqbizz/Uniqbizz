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
        throw new Exception("User ID is required.");
    }

    $userId = trim($data['userId']);

    /*
    |--------------------------------------------------------------------------
    | KYC Details
    |--------------------------------------------------------------------------
    */

    $sqlUserDetails = $conn->prepare("
        SELECT
            6 AS total_documents,
            (
                CASE WHEN ste.profile_pic IS NOT NULL AND ste.profile_pic <> '' THEN 1 ELSE 0 END +
                CASE WHEN ste.aadhar_card IS NOT NULL AND ste.aadhar_card <> '' THEN 1 ELSE 0 END +
                CASE WHEN ste.pan_card IS NOT NULL AND ste.pan_card <> '' THEN 1 ELSE 0 END +
                CASE WHEN ste.voting_card IS NOT NULL AND ste.voting_card <> '' THEN 1 ELSE 0 END +
                CASE WHEN ste.bank_passbook IS NOT NULL AND ste.bank_passbook <> '' THEN 1 ELSE 0 END +
                CASE WHEN ste.payment_proof IS NOT NULL AND ste.payment_proof <> '' THEN 1 ELSE 0 END
            ) AS uploaded_files,
            CASE
                WHEN ste.profile_pic IS NOT NULL
                    AND ste.profile_pic <> ''
                    AND ste.aadhar_card IS NOT NULL
                    AND ste.aadhar_card <> ''
                    AND ste.payment_proof IS NOT NULL
                    AND ste.payment_proof <> ''
                THEN 'Completed'
                ELSE 'Incomplete'
            END AS kyc_status
        FROM sub_franchisee ste
        WHERE ste.sub_franchisee_id = :user_id
        LIMIT 1
    ");

    $sqlUserDetails->execute([
        ':user_id' => $userId
    ]);

    $userDetails = $sqlUserDetails->fetch(PDO::FETCH_ASSOC);

    if (!$userDetails) {
        throw new Exception("User not found.");
    }

    /*
    |--------------------------------------------------------------------------
    | Verification Status
    |--------------------------------------------------------------------------
    */

    // $verificationStatus = 'Pending';
    $verificationStatus = 'Verified';

    // if (!empty($userDetails['payload'])) {
    //
    //     $payload = json_decode($userDetails['payload'], true);
    //
    //     if (is_array($payload) && !empty($payload)) {
    //
    //         $statuses = array_map(function ($value) {
    //             return strtolower(trim($value));
    //         }, $payload);
    //
    //         if (in_array('rejected', $statuses, true)) {
    //             $verificationStatus = 'Rejected';
    //         } elseif (count(array_filter($statuses, function ($value) {
    //             return $value === 'approved';
    //         })) === count($statuses)) {
    //             $verificationStatus = 'Verified';
    //         }
    //     }
    // }
    //
    // unset($userDetails['payload']);

    $userDetails['total_documents'] = (int)$userDetails['total_documents'];
    $userDetails['uploaded_files'] = (int)$userDetails['uploaded_files'];
    $userDetails['verification_status'] = $verificationStatus;

    echo json_encode([
        "status" => true,
        "message" => "KYC details fetched successfully.",
        "data" => $userDetails
    ]);

} catch (Exception $e) {

    echo json_encode([
        "status" => false,
        "message" => $e->getMessage(),
        "data" => []
    ]);
}