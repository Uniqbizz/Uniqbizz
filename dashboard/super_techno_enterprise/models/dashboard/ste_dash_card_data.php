<?php
    include_once(__DIR__.'/../../../dashboard_user_details.php');

    header('Content-Type: application/json');

    $sql = $conn->prepare("
        SELECT
            (
                SELECT COUNT(*)
                FROM corporate_agency
                WHERE reference_no = :user_id
                AND status IN (1,3)
            ) AS te_count,

            (
                SELECT COUNT(*)
                FROM ca_travelagency ta
                INNER JOIN corporate_agency ca
                    ON ta.reference_no = ca.corporate_agency_id
                WHERE ca.reference_no = :user_id
                AND ta.status IN (1,3)
                AND ca.status IN (1,3)
            ) AS tc_count,

            (
                SELECT COUNT(*)
                FROM ca_customer cu
                INNER JOIN ca_travelagency ta
                    ON cu.ta_reference_no = ta.ca_travelagency_id
                INNER JOIN corporate_agency ca
                    ON ta.reference_no = ca.corporate_agency_id
                WHERE ca.reference_no = :user_id
                AND cu.status IN (1,3)
                AND ta.status IN (1,3)
                AND ca.status IN (1,3)
            ) AS cu_count
    ");

    $sql->execute([
        ':user_id' => $userId
    ]);

    $data = $sql->fetch(PDO::FETCH_ASSOC);

    echo json_encode([
        'status' => true,
        'message' => 'Data fetched successfully',
        'data' => [
            'te_count' => (int)$data['te_count'],
            'tc_count' => (int)$data['tc_count'],
            'cu_count' => (int)$data['cu_count']
        ]
    ], JSON_PRETTY_PRINT);

    exit;
?>