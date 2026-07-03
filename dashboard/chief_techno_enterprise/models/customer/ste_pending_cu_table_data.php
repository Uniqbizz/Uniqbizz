<?php

    include_once(__DIR__.'/../../../dashboard_user_details.php');

    header('Content-Type: application/json');

    try {

        $sql = $conn->prepare("
            SELECT *
            FROM (

                SELECT
                    cu.id,
                    cu.ca_customer_id,
                    cu.firstname,
                    cu.lastname,
                    cu.contact_no,
                    cu.email,
                    cu.added_on AS register_date,
                    cu.status,

                    ta.ca_travelagency_id AS ref_id,
                    ta.firstname AS ref_firstname,
                    ta.lastname AS ref_lastname,

                    'TE' AS ref_type

                FROM ca_customer cu

                INNER JOIN ca_travelagency ta
                    ON cu.ta_reference_no = ta.ca_travelagency_id

                INNER JOIN corporate_agency ca
                    ON ta.reference_no = ca.corporate_agency_id

                INNER JOIN super_techno_enterprise ste
                    ON ca.reference_no = ste.super_techno_enterprise_id

                INNER JOIN executive_techno_enterprise ete
                    ON ste.reference_no = ete.executive_techno_enterprise_id

                WHERE ete.reference_no = :user_id
                AND cu.status IN (2,3)

                UNION ALL

                SELECT
                    cu.id,
                    cu.ca_customer_id,
                    cu.firstname,
                    cu.lastname,
                    cu.contact_no,
                    cu.email,
                    cu.added_on AS register_date,
                    cu.status,

                    ta.institution_branch_manager_id AS ref_id,
                    ta.firstname AS ref_firstname,
                    ta.lastname AS ref_lastname,

                    'I' AS ref_type

                FROM ca_customer cu

                INNER JOIN institution_branch_manager ta
                    ON cu.ta_reference_no = ta.institution_branch_manager_id

                INNER JOIN institution sf
                    ON ta.reference_no = sf.institution_id

                INNER JOIN executive_techno_enterprise ete
                    ON ta.reference_no = ete.executive_techno_enterprise_id

                WHERE ete.reference_no = :user_id
                AND cu.status IN (2,3)

            ) x

            ORDER BY x.id DESC
        ");

        $sql->execute([
            ':user_id' => $userId
        ]);

        $data = $sql->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode([
            'status'  => true,
            'message' => 'CU data fetched successfully',
            'data'    => $data
        ]);

    } catch (Exception $e) {

        echo json_encode([
            'status'  => false,
            'message' => $e->getMessage(),
            'data'    => []
        ]);
    }

    exit;
?>