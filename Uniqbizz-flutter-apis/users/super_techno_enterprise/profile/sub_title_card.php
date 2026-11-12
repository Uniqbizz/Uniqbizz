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
    $requestData = json_decode($json, true);

    if (!$requestData || !is_array($requestData)) {
        throw new Exception("Invalid JSON data.");
    }

    if (
        !isset($requestData['userId']) ||
        !is_string($requestData['userId']) ||
        trim($requestData['userId']) === ''
    ) {
        throw new Exception("User ID is required.");
    }

    $userId = trim($requestData['userId']);

$sqlUserDetails = $conn->prepare("
        SELECT
            11 AS total_documents,
            (
                CASE WHEN doc.profile_pic IS NOT NULL AND doc.profile_pic <> '' THEN 1 ELSE 0 END +
                CASE WHEN doc.aadhar_card IS NOT NULL AND doc.aadhar_card <> '' THEN 1 ELSE 0 END +
                CASE WHEN doc.pan_card IS NOT NULL AND doc.pan_card <> '' THEN 1 ELSE 0 END +
                CASE WHEN doc.cancelled_cheque_bank_passbook IS NOT NULL AND doc.cancelled_cheque_bank_passbook <> '' THEN 1 ELSE 0 END +
                CASE WHEN doc.resume_cv IS NOT NULL AND doc.resume_cv <> '' THEN 1 ELSE 0 END +
                CASE WHEN doc.address_proof IS NOT NULL AND doc.address_proof <> '' THEN 1 ELSE 0 END +
                CASE WHEN doc.professional_profile IS NOT NULL AND doc.professional_profile <> '' THEN 1 ELSE 0 END +
                CASE WHEN doc.business_profile IS NOT NULL AND doc.business_profile <> '' THEN 1 ELSE 0 END +
                CASE WHEN doc.income_proof IS NOT NULL AND doc.income_proof <> '' THEN 1 ELSE 0 END +
                CASE WHEN doc.other_document IS NOT NULL AND doc.other_document <> '' THEN 1 ELSE 0 END +
                CASE WHEN doc.nominee_profile IS NOT NULL AND doc.nominee_profile <> '' THEN 1 ELSE 0 END
            ) AS uploaded_files,
            CASE
                WHEN doc.profile_pic IS NOT NULL
                    AND doc.profile_pic <> ''
                    AND doc.aadhar_card IS NOT NULL
                    AND doc.aadhar_card <> ''
                THEN 'Completed'
                ELSE 'Incomplete'
            END AS kyc_status

        FROM super_techno_enterprise ste

        LEFT JOIN documents doc
            ON doc.application_id = ste.application_id

        WHERE ste.super_techno_enterprise_id = :user_id

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
    $verificationStatus = 'Approved';

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

catch (Exception $e) {

    echo json_encode([
        'status'  => false,
        'message' => $e->getMessage(),
        'data' => null
    ]);

}

exit;

?>
