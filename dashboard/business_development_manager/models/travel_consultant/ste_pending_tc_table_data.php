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
                    ta.user_type,
                    ca.corporate_agency_id AS reference_id,
                    ca.firstname AS ref_firstname,
                    ca.lastname AS ref_lastname

                FROM ca_travelagency ta

                INNER JOIN corporate_agency ca
                    ON ta.reference_no = ca.corporate_agency_id

                WHERE ca.reference_no = :user_id
                AND ta.status IN (0,2,4)
                AND ca.status IN (1,3)

                UNION ALL
                SELECT
                    ta.id,
                    ta.ca_travelagency_id,
                    ta.firstname,
                    ta.lastname,
                    ta.contact_no,
                    ta.email,
                    ta.added_on,
                    ta.status,
                    ta.user_type,
                    ca.corporate_agency_id AS reference_id,
                    ca.firstname AS ref_firstname,
                    ca.lastname AS ref_lastname

                FROM ca_travelagency ta

                INNER JOIN corporate_agency ca
                    ON ta.reference_no = ca.corporate_agency_id
                INNER JOIN business_mentor bm
                    ON ca.reference_no = bm.business_mentor_id

                WHERE bm.reference_no = :user_id
                AND ta.status IN (0,2,4)
                AND ca.status IN (1,3)
                AND bm.status IN (1,3)

                UNION ALL
                SELECT
                    ta.id,
                    ta.ca_travelagency_id,
                    ta.firstname,
                    ta.lastname,
                    ta.contact_no,
                    ta.email,
                    ta.added_on,
                    ta.status,
                    ta.user_type,
                    ca.sub_franchisee_id AS reference_id,
                    ca.firstname AS ref_firstname,
                    ca.lastname AS ref_lastname

                FROM ca_travelagency ta

                INNER JOIN sub_franchisee ca
                    ON ta.reference_no = ca.sub_franchisee_id

                WHERE ca.reference_no = :user_id
                AND ta.status IN (0,2,4)
                AND ca.status IN (1,3)

                UNION ALL
                SELECT
                    ta.id,
                    ta.ca_travelagency_id,
                    ta.firstname,
                    ta.lastname,
                    ta.contact_no,
                    ta.email,
                    ta.added_on,
                    ta.status,
                    ta.user_type,
                    ca.sub_franchisee_id AS reference_id,
                    ca.firstname AS ref_firstname,
                    ca.lastname AS ref_lastname

                FROM ca_travelagency ta

                INNER JOIN sub_franchisee ca
                    ON ta.reference_no = ca.sub_franchisee_id
                INNER JOIN business_mentor bm
                    ON ca.reference_no = bm.business_mentor_id

                WHERE bm.reference_no = :user_id
                AND ta.status IN (0,2,4)
                AND ca.status IN (1,3)
                AND bm.status IN (1,3)

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
                    ta.user_type,
                    ca.institution_id AS reference_id,
                    ca.name AS ref_firstname,
                    '' AS ref_lastname

                FROM institution_branch_manager ta

                INNER JOIN institution ca
                    ON ta.reference_no = ca.institution_id

                WHERE ca.reference_no = :user_id
                AND ta.status IN (0,2,4)
                AND ca.status IN (1,3)

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
                    ta.user_type,
                    ca.institution_id AS reference_id,
                    ca.name AS ref_firstname,
                    '' AS ref_lastname

                FROM institution_branch_manager ta

                INNER JOIN institution ca
                    ON ta.reference_no = ca.institution_id
                INNER JOIN business_mentor bm
                    ON ca.reference_no = bm.business_mentor_id

                WHERE bm.reference_no = :user_id
                AND ta.status IN (0,2,4)
                AND ca.status IN (1,3)
                AND bm.status IN (1,3)

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