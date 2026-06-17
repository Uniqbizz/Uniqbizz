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

                ste.firstname AS ref_firstname,
                ste.lastname AS ref_lastname,
                ste.super_techno_enterprise_id,

                'corporate_agency' AS source_table

            FROM corporate_agency ca

            LEFT JOIN super_techno_enterprise ste
                ON ca.reference_no = ste.super_techno_enterprise_id

            WHERE ca.reference_no = :user_id
            AND ca.status IN (2,4)

            UNION ALL

            SELECT
                sf.id,
                sf.firstname,
                sf.lastname,
                sf.contact_no,
                sf.email,
                sf.added_on,
                sf.status,
                sf.user_type,
                'SF' AS userTypeStr,

                ste.firstname AS ref_firstname,
                ste.lastname AS ref_lastname,
                ste.super_techno_enterprise_id,

                'sponsor_franchisee' AS source_table

            FROM sub_franchisee sf

            LEFT JOIN super_techno_enterprise ste
                ON sf.reference_no = ste.super_techno_enterprise_id

            WHERE sf.reference_no = :user_id
            AND sf.status IN (2,4)

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