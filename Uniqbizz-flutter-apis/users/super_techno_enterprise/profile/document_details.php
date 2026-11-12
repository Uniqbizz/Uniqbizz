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
            doc.profile_pic,
            doc.aadhar_card,
            doc.pan_card,
            doc.cancelled_cheque_bank_passbook,
            doc.resume_cv,
            doc.address_proof,
            doc.professional_profile,
            doc.business_profile,
            doc.income_proof,
            doc.other_document,
            doc.nominee_profile,

            uv.payload

        FROM super_techno_enterprise ste

        LEFT JOIN documents doc
            ON doc.application_id = ste.application_id

        LEFT JOIN user_verification uv
            ON uv.application_id = ste.application_id

        WHERE ste.super_techno_enterprise_id = :user_id

        LIMIT 1
    ");

    $sql->execute([
        ':user_id' => $userId
    ]);

    $row = $sql->fetch(PDO::FETCH_ASSOC);

    if (!$row) {
        echo json_encode([
            'status' => false,
            'message' => 'Documents not found'
        ]);
        exit;
    }

    $verification = [];

    if (!empty($row['payload'])) {
        $verification = json_decode($row['payload'], true);

        if (!is_array($verification)) {
            $verification = [];
        }
    }

    unset($row['payload']);

    echo json_encode([
        'status' => true,
        'documents' => $row
        // 'verification' => $verification
    ]);

} catch (PDOException $e) {

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
