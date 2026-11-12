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
    | User Details
    |--------------------------------------------------------------------------
    */

    $sqlUserDetails = $conn->prepare("
        SELECT
            ste.sub_franchisee_id AS profile_id,
            CONCAT(ste.firstname, ' ', ste.lastname) AS profile_name,
            'Travel Consultant' AS profile_type,
            ste.address AS profile_address,
            ste.email AS profile_email,
            ste.country_code AS profile_phone_prefix,
            ste.contact_no AS profile_phone,
            ste.register_date AS profile_since,
            ste.profile_pic
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
    //
    //             $verificationStatus = 'Rejected';
    //
    //         } elseif (count(array_filter($statuses, function ($value) {
    //             return $value === 'approved';
    //         })) === count($statuses)) {
    //
    //             $verificationStatus = 'Verified';
    //         }
    //     }
    // }
    //
    // unset($userDetails['payload']);

    $userDetails['verification_status'] = $verificationStatus;

    echo json_encode([
        "status" => true,
        "message" => "Profile details fetched successfully.",
        "data" => $userDetails
    ]);

} catch (Exception $e) {

    echo json_encode([
        "status" => false,
        "message" => $e->getMessage(),
        "data" => []
    ]);
}