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
    | Residential Address Details
    |--------------------------------------------------------------------------
    */

    $sqlUserDetails = $conn->prepare("
        SELECT
            cty.city_name,
            sta.state_name,
            cun.country_name,
            ste.pincode,
            ste.address AS resAdd
        FROM corporate_agency ste
        LEFT JOIN cities cty
            ON cty.id = ste.city
        LEFT JOIN states sta
            ON sta.id = ste.state
        LEFT JOIN countries cun
            ON cun.id = ste.country
        WHERE ste.corporate_agency_id = :user_id
        LIMIT 1
    ");

    $sqlUserDetails->execute([
        ':user_id' => $userId
    ]);

    $userDetails = $sqlUserDetails->fetch(PDO::FETCH_ASSOC);

    if (!$userDetails) {
        throw new Exception("User not found.");
    }

    echo json_encode([
        "status" => true,
        "message" => "Residential address fetched successfully.",
        "data" => [
            "city_name"    => $userDetails['city_name'] ?? '',
            "state_name"   => $userDetails['state_name'] ?? '',
            "country_name" => $userDetails['country_name'] ?? '',
            "pincode"      => $userDetails['pincode'] ?? '',
            "resAdd"       => $userDetails['resAdd'] ?? ''
        ]
    ]);

} catch (Exception $e) {

    echo json_encode([
        "status" => false,
        "message" => $e->getMessage(),
        "data" => []
    ]);
}