<?php

header('Content-Type: application/json');

include_once(__DIR__ . '/../../../dashboard_user_details.php');

try {

    $userId = $_GET['user_id'] ?? '';

    if (empty($userId)) {
        echo json_encode([
            'status' => false,
            'message' => 'User ID is required'
        ]);
        exit;
    }

    $sql = $conn->prepare("
        SELECT
            ste.profile_pic,
            ste.aadhar_card,
            ste.pan_card,
            ste.bank_passbook,
            ste.voting_card,
            ste.payment_proof

        FROM sub_franchisee ste

        WHERE ste.sub_franchisee_id = :user_id

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
        'documents' => $row,
        'verification' => $verification
    ]);

} catch (PDOException $e) {

    echo json_encode([
        'status' => false,
        'message' => $e->getMessage()
    ]);
}