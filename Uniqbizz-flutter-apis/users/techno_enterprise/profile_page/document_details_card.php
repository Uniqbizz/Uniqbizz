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
    | Documents
    |--------------------------------------------------------------------------
    */

    $sql = $conn->prepare("
        SELECT
            ste.profile_pic,
            ste.aadhar_card,
            ste.pan_card,
            ste.bank_passbook,
            ste.voting_card,
            ste.payment_proof
        FROM corporate_agency ste
        WHERE ste.corporate_agency_id = :user_id
        LIMIT 1
    ");

    $sql->execute([
        ':user_id' => $userId
    ]);

    $row = $sql->fetch(PDO::FETCH_ASSOC);

    if (!$row) {
        throw new Exception("Documents not found.");
    }

    $verification = [];

    // Uncomment if payload is added back to the SELECT query
    /*
    if (!empty($row['payload'])) {
        $verification = json_decode($row['payload'], true);

        if (!is_array($verification)) {
            $verification = [];
        }
    }

    unset($row['payload']);
    */

    echo json_encode([
        "status" => true,
        "message" => "Documents fetched successfully.",
        "data" => [
            "documents" => $row,
            "verification" => $verification
        ]
    ]);

} catch (Exception $e) {

    echo json_encode([
        "status" => false,
        "message" => $e->getMessage(),
        "data" => []
    ]);
}