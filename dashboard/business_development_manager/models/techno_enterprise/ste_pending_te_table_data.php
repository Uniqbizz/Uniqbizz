<?php

    include_once(__DIR__.'/../../../dashboard_user_details.php');

    header('Content-Type: application/json');

    try {

        $sql = $conn->prepare("
            -- Corporate Agency (Direct )
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
                bm.name AS ref_firstname,
                '' AS ref_lastname,
                bm.employee_id AS reference_id,
                'corporate_agency' AS source_table
            FROM corporate_agency ca
            INNER JOIN employees bm
                ON ca.reference_no = bm.employee_id
            WHERE ca.reference_no = :user_id
            AND ca.status IN (0,2,4)

            UNION ALL

            -- Corporate Agency (Through BM)
            SELECT
                ca.id,
                ca.firstname,
                ca.lastname,
                ca.contact_no,
                ca.email,
                ca.added_on,
                ca.status,
                ca.user_type,
                'BM' AS userTypeStr,
                bm.firstname AS ref_firstname,
                bm.lastname AS ref_lastname,
                bm.business_mentor_id AS reference_id,
                'corporate_agency' AS source_table
            FROM corporate_agency ca
            INNER JOIN business_mentor bm
                ON ca.reference_no = bm.business_mentor_id
            WHERE bm.reference_no = :user_id
            AND ca.status IN (0,2,4)
            AND bm.status IN (1,3)

            UNION ALL

            -- Sub Franchisee (Direct )
            SELECT
                sf.id,
                sf.firstname,
                sf.lastname,
                sf.contact_no,
                sf.email,
                sf.added_on,
                sf.status,
                sf.user_type,
                'TE (Direct)' AS userTypeStr,
                ste.firstname AS ref_firstname,
                ste.lastname AS ref_lastname,
                ste.business_mentor_id AS reference_id,
                'sub_franchisee' AS source_table
            FROM sub_franchisee sf
            INNER JOIN business_mentor ste
                ON sf.reference_no = ste.business_mentor_id
            WHERE sf.reference_no = :user_id
            AND sf.status IN (0,2,4)
            AND ste.status IN (1,3)

            UNION ALL

            -- Sub Franchisee (Through BM)
            SELECT
                sf.id,
                sf.firstname,
                sf.lastname,
                sf.contact_no,
                sf.email,
                sf.added_on,
                sf.status,
                sf.user_type,
                'BM' AS userTypeStr,
                bm.name AS ref_firstname,
                '' AS ref_lastname,
                bm.employee_id AS reference_id,
                'sub_franchisee' AS source_table
            FROM sub_franchisee sf
            INNER JOIN employees bm
                ON sf.reference_no = bm.employee_id
            WHERE bm.reference_no = :user_id
            AND sf.status IN (0,2,4)
            AND bm.status IN (1,3)

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