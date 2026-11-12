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
    | Activation Commission
    |--------------------------------------------------------------------------
    */

    $sqlActivation = $conn->prepare("
        SELECT COALESCE(SUM(commision_tc),0) AS activation_commission
        FROM ca_cu_payout
        WHERE travel_consultant = :user_id
    ");

    $sqlActivation->execute([
        ':user_id' => $userId
    ]);

    $activation = (float)$sqlActivation->fetch(PDO::FETCH_ASSOC)['activation_commission'];

    /*
    |--------------------------------------------------------------------------
    | Trip Commission
    |--------------------------------------------------------------------------
    */

    $sqlTrip = $conn->prepare("
        SELECT COALESCE(SUM(ta_amt),0) AS trip_commission
        FROM product_payout
        WHERE ta_id = :user_id
    ");

    $sqlTrip->execute([
        ':user_id' => $userId
    ]);

    $trip = (float)$sqlTrip->fetch(PDO::FETCH_ASSOC)['trip_commission'];

    $total = $activation + $trip;

    if ($total > 0) {

        $activationPercentage = round(($activation / $total) * 100);
        $tripPercentage = 100 - $activationPercentage;

    } else {

        $activationPercentage = 0;
        $tripPercentage = 0;
    }

    echo json_encode([
        "status" => true,
        "message" => "Commission summary fetched successfully.",
        "data" => [
            "total_commission" => $total,
            "activation" => $activation,
            "activationPercentage" => $activationPercentage,
            "trip" => $trip,
            "tripPercentage" => $tripPercentage
        ]
    ]);

} catch (Exception $e) {

    echo json_encode([
        "status" => false,
        "message" => $e->getMessage(),
        "data" => []
    ]);
}