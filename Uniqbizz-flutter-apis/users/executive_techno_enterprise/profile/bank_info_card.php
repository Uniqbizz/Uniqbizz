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

$sql = $conn->prepare("
        SELECT
            bd.account_holder_name,
            bd.bank_name,
            bd.account_number,
            bd.ifsc_code,
            bd.branch_name,
            'NA' AS upi_id
        FROM bank_details bd
        INNER JOIN super_techno_enterprise ste
            ON ste.application_id = bd.application_id
        WHERE ste.super_techno_enterprise_id = :user_id
        LIMIT 1
    ");

    $sql->execute([
        ':user_id' => $userId
    ]);

    $data = $sql->fetch(PDO::FETCH_ASSOC);

    if ($data) {

        echo json_encode([
            'status' => true,
            'data' => $data
        ]);

    } else {

        echo json_encode([
            'status' => false,
            'message' => 'Bank details not found'
        ]);
    }

} catch(PDOException $e) {

    echo json_encode([
        'status' => false,
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
