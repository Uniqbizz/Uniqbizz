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
            nd.nominee_name,
            nd.nominee_relation,
            nd.nominee_contact_cd,
            nd.nominee_contact_no,
            nd.nominee_date_of_birth,
            nd.nominee_address
        FROM nominee_details nd
        INNER JOIN chief_techno_enterprise ste
            ON ste.application_id = nd.application_id
        WHERE ste.chief_techno_enterprise_id = :user_id
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
            'message' => 'Nominee details not found'
        ]);
    }

} catch(PDOException $e) {

    echo json_encode([
        'status' => false,
        'message' => $e->getMessage()
    ]);
}
