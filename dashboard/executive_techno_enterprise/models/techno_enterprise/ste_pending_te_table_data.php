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
                ca.user_type,
                'TE' AS userTypeStr,
                DATE_FORMAT(ca.deleted_date, '%d %b %Y') AS deleted_date,
                ste.firstname AS ref_firstname,
                ste.lastname AS ref_lastname,
                ste.super_techno_enterprise_id AS reference_id,

                'corporate_agency' AS source_table

            FROM corporate_agency ca

            INNER JOIN super_techno_enterprise ste
                ON ca.reference_no = ste.super_techno_enterprise_id

            WHERE ste.reference_no = :user_id
            AND ca.status IN (0,2,4)
            AND ste.status IN (1)

            ORDER BY id DESC;
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