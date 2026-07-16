<?php

    include_once(__DIR__.'/../../../dashboard_user_details.php');

    header('Content-Type: application/json');

    try {

        $sql = $conn->prepare("
            SELECT *
            FROM (

                SELECT
                    ca.corporate_agency_id AS te_id,

                    CONCAT(
                        COALESCE(ca.firstname,''),
                        ' ',
                        COALESCE(ca.lastname,'')
                    ) AS te_name,

                    COUNT(DISTINCT ta.ca_travelagency_id) AS tc_count,

                    COUNT(DISTINCT cu.ca_customer_id) AS cu_count

                FROM corporate_agency ca

                LEFT JOIN ca_travelagency ta
                    ON ta.reference_no = ca.corporate_agency_id
                    AND ta.status IN (1,3)

                LEFT JOIN ca_customer cu
                    ON cu.ta_reference_no = ta.ca_travelagency_id
                    AND cu.status IN (1,3)

                WHERE ca.reference_no = :user_id
                AND ca.status IN (1,3)

                GROUP BY
                    ca.corporate_agency_id,
                    ca.firstname,
                    ca.lastname

                UNION ALL

                SELECT
                    ca.sub_franchisee_id AS te_id,

                    CONCAT(
                        COALESCE(ca.firstname,''),
                        ' ',
                        COALESCE(ca.lastname,'')
                    ) AS te_name,

                    COUNT(DISTINCT ta.ca_travelagency_id) AS tc_count,

                    COUNT(DISTINCT cu.ca_customer_id) AS cu_count

                FROM sub_franchisee ca

                LEFT JOIN ca_travelagency ta
                    ON ta.reference_no = ca.sub_franchisee_id
                    AND ta.status IN (1,3)

                LEFT JOIN ca_customer cu
                    ON cu.ta_reference_no = ta.ca_travelagency_id
                    AND cu.status IN (1,3)

                WHERE ca.reference_no = :user_id
                AND ca.status IN (1,3)

                GROUP BY
                    ca.sub_franchisee_id,
                    ca.firstname,
                    ca.lastname

                UNION ALL

                SELECT
                    ca.institution_id AS te_id,

                    CONCAT(
                        COALESCE(ca.firstname,''),
                        ' ',
                        COALESCE(ca.lastname,'')
                    ) AS te_name,

                    COUNT(DISTINCT ta.institution_branch_manager_id) AS tc_count,

                    COUNT(DISTINCT cu.ca_customer_id) AS cu_count

                FROM institution ca

                LEFT JOIN institution_branch_manager ta
                    ON ta.reference_no = ca.institution_id
                    AND ta.status IN (1,3)

                LEFT JOIN ca_customer cu
                    ON cu.ta_reference_no = ta.institution_branch_manager_id
                    AND cu.status IN (1,3)

                WHERE ca.reference_no = :user_id
                AND ca.status IN (1,3)

                GROUP BY
                    ca.institution_id,
                    ca.firstname,
                    ca.lastname

                
            ) AS combined

            ORDER BY
                cu_count DESC,
                tc_count DESC

            LIMIT 12
        ");

        $sql->execute([
            ':user_id' => $userId
        ]);

        $data = $sql->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode([
            'status' => true,
            'message' => 'Performance data fetched successfully',
            'data' => $data
        ]);

    } catch(Exception $e) {

        echo json_encode([
            'status' => false,
            'message' => $e->getMessage()
        ]);
    }
    // UNION ALL

    //             SELECT
    //                 ca.sub_franchisee_id AS te_id,

    //                 CONCAT(
    //                     COALESCE(ca.firstname,''),
    //                     ' ',
    //                     COALESCE(ca.lastname,'')
    //                 ) AS te_name,

    //                 COUNT(DISTINCT ta.ca_travelagency_id) AS tc_count,

    //                 COUNT(DISTINCT cu.ca_customer_id) AS cu_count

    //             FROM sub_franchisee ca

    //             LEFT JOIN ca_travelagency ta
    //                 ON ta.reference_no = ca.sub_franchisee_id
    //                 AND ta.status IN (1,3)

    //             LEFT JOIN ca_customer cu
    //                 ON cu.ta_reference_no = ta.ca_travelagency_id
    //                 AND cu.status IN (1,3)

    //             WHERE ca.reference_no = :user_id
    //             AND ca.status IN (1,3)

    //             GROUP BY
    //                 ca.sub_franchisee_id,
    //                 ca.firstname,
    //                 ca.lastname

?>