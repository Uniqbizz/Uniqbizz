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
                    cu.register_date,
                    cu.status,

                    ta.ca_travelagency_id,
                    ta.firstname AS ref_firstname,
                    ta.lastname AS ref_lastname,

                    'TE' AS ref_type

                FROM ca_customer cu

                INNER JOIN ca_travelagency ta
                    ON cu.ta_reference_no = ta.ca_travelagency_id

                INNER JOIN corporate_agency ca
                    ON ta.reference_no = ca.corporate_agency_id

                WHERE ca.reference_no = :user_id
                AND cu.status IN (0,2,4)

                UNION ALL

                SELECT
                    cu.id,
                    cu.ca_customer_id,
                    cu.firstname,
                    cu.lastname,
                    cu.contact_no,
                    cu.email,
                    cu.register_date,
                    cu.status,

                    ta.ca_travelagency_id,
                    ta.firstname AS ref_firstname,
                    ta.lastname AS ref_lastname,

                    'F' AS ref_type

                FROM ca_customer cu

                INNER JOIN ca_travelagency ta
                    ON cu.ta_reference_no = ta.ca_travelagency_id

                INNER JOIN sub_franchisee sf
                    ON ta.reference_no = sf.sub_franchisee_id

                WHERE sf.reference_no = :user_id
                AND cu.status IN (0,2,4)

                UNION ALL

                SELECT
                    cu.id,
                    cu.ca_customer_id,
                    cu.firstname,
                    cu.lastname,
                    cu.contact_no,
                    cu.email,
                    cu.register_date,
                    cu.status,

                    ta.ca_travelagency_id,
                    ta.firstname AS ref_firstname,
                    ta.lastname AS ref_lastname,

                    'BM' AS ref_type

                FROM ca_customer cu

                INNER JOIN ca_travelagency ta
                    ON cu.ta_reference_no = ta.ca_travelagency_id

                INNER JOIN business_mentor sf
                    ON ta.reference_no = sf.business_mentor_id

                WHERE ta.reference_no = :user_id
                AND cu.status IN (0,2,4)

                UNION ALL

                SELECT
                    cu.id,
                    cu.ca_customer_id,
                    cu.firstname,
                    cu.lastname,
                    cu.contact_no,
                    cu.email,
                    cu.register_date,
                    cu.status,

                    ta.institution_branch_manager_id,
                    ta.firstname AS ref_firstname,
                    ta.lastname AS ref_lastname,

                    'I' AS ref_type

                FROM ca_customer cu

                INNER JOIN institution_branch_manager ta
                    ON cu.ta_reference_no = ta.institution_branch_manager_id

                INNER JOIN institution sf
                    ON ta.reference_no = sf.institution_id

                WHERE sf.reference_no = :user_id
                AND cu.status IN (0,2,4)

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