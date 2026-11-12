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
            cty.city_name,
            sta.state_name,
            cun.country_name,
            ste.pincode,
            ste.address AS resAdd
        FROM super_techno_enterprise ste
        LEFT JOIN cities cty
            ON cty.id = ste.city
        LEFT JOIN states sta
            ON sta.id = ste.state
        LEFT JOIN countries cun
            ON cun.id = ste.country
        WHERE ste.super_techno_enterprise_id = :user_id
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

catch (Exception $e) {

    echo json_encode([
        'status'  => false,
        'message' => $e->getMessage(),
        'data' => null
    ]);

}

exit;

?>
