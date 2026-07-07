<?php

    include_once(__DIR__.'/../../../dashboard_user_details.php');

    header('Content-Type: application/json');

    try {

        $sql = $conn->prepare("
            SELECT *
            FROM (

                SELECT
                    ta.id,
                    ta.ca_travelagency_id,
                    ta.firstname,
                    ta.lastname,
                    ta.contact_no,
                    ta.email,
                    ta.added_on,
                    ta.status,

                    ca.corporate_agency_id AS reference_id,
                    ca.firstname AS ref_firstname,
                    ca.lastname AS ref_lastname

                FROM ca_travelagency ta

                INNER JOIN corporate_agency ca
                    ON ta.reference_no = ca.corporate_agency_id

                INNER JOIN super_techno_enterprise ste
                    ON ca.reference_no = ste.super_techno_enterprise_id

                WHERE ste.reference_no = :user_id
                AND ta.status IN (0,2,4)
                AND ca.status IN (1)
                AND ste.status IN (1)

                UNION ALL

                SELECT
                    ta.id,
                    ta.institution_branch_manager_id,
                    ta.firstname,
                    ta.lastname,
                    ta.contact_no,
                    ta.email,
                    ta.added_on,
                    ta.status,

                    ca.institution_id AS reference_id,
                    ca.firstname AS ref_firstname,
                    ca.lastname AS ref_lastname

                FROM institution_branch_manager ta

                INNER JOIN institution ca
                    ON ta.reference_no = ca.institution_id

                WHERE ca.reference_no = :user_id
                AND ta.status IN (0,2,4)
                AND ca.status IN (1)

            ) AS combined

            ORDER BY id DESC
        ");

        $sql->execute([
            ':user_id' => $userId
        ]);

        $data = $sql->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode([
            'status'  => true,
            'message' => 'TC data fetched successfully',
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