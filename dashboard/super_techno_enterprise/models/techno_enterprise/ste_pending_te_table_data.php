<?php

    include_once(__DIR__.'/../../../dashboard_user_details.php');

    header('Content-Type: application/json');

    try {

        $sql = $conn->prepare("
            SELECT
                ca.id,
                ca.firstname,
                ca.lastname,
                ca.contact_no,
                ca.email,
                ca.added_on,
                ca.status,

                ste.firstname AS ref_firstname,
                ste.lastname AS ref_lastname,
                ste.super_techno_enterprise_id

            FROM corporate_agency ca

            LEFT JOIN super_techno_enterprise ste
                ON ca.reference_no = ste.super_techno_enterprise_id

            WHERE ca.reference_no = :user_id
            AND ca.status IN (2,4)

            ORDER BY ca.id DESC
        ");

        $sql->execute([
            ':user_id' => $userId
        ]);

        $data = $sql->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode([
            'status' => true,
            'message' => 'Data fetched successfully',
            'data' => $data
        ]);

    } catch (Exception $e) {

        echo json_encode([
            'status' => false,
            'message' => $e->getMessage(),
            'data' => []
        ]);
    }

    exit;
?>