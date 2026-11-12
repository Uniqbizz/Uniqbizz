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
            ste.super_techno_enterprise_id AS profile_id,
            CONCAT(ste.firstname, ' ', ste.lastname) AS profile_name,
            'Super Techno Enterprise' AS profile_type,
            ste.address AS profile_address,
            ste.email AS profile_email,
            ste.country_code AS profile_phone_prefix,
            ste.contact_no AS profile_phone,
            ste.register_date AS profile_since,
            doc.profile_pic
            #uv.payload
        FROM super_techno_enterprise ste
        #INNER JOIN user_verification uv
        #    ON uv.application_id = ste.application_id
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

catch (Exception $e) {

    echo json_encode([
        'status'  => false,
        'message' => $e->getMessage(),
        'data' => null
    ]);

}

exit;

?>
