<?php

    include_once(__DIR__.'/../../../dashboard_user_details.php');

    header('Content-Type: application/json');

    try {

        $sql = $conn->prepare("
            SELECT *
            FROM (

                /*----------------------------------------------------------
                | Direct Corporate Agency
                ----------------------------------------------------------*/
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

                /*----------------------------------------------------------
                | BM -> Corporate Agency
                ----------------------------------------------------------*/
                SELECT
                    ca.corporate_agency_id,

                    CONCAT(
                        COALESCE(ca.firstname,''),
                        ' ',
                        COALESCE(ca.lastname,'')
                    ),

                    COUNT(DISTINCT ta.ca_travelagency_id),

                    COUNT(DISTINCT cu.ca_customer_id)

                FROM corporate_agency ca

                INNER JOIN business_mentor bm
                    ON ca.reference_no = bm.business_mentor_id

                LEFT JOIN ca_travelagency ta
                    ON ta.reference_no = ca.corporate_agency_id
                    AND ta.status IN (1,3)

                LEFT JOIN ca_customer cu
                    ON cu.ta_reference_no = ta.ca_travelagency_id
                    AND cu.status IN (1,3)

                WHERE bm.reference_no = :user_id
                AND bm.status IN (1,3)
                AND ca.status IN (1,3)

                GROUP BY
                    ca.corporate_agency_id,
                    ca.firstname,
                    ca.lastname

                UNION ALL

                /*----------------------------------------------------------
                | Direct Sub Franchisee
                ----------------------------------------------------------*/
                SELECT
                    sf.sub_franchisee_id,

                    CONCAT(
                        COALESCE(sf.firstname,''),
                        ' ',
                        COALESCE(sf.lastname,'')
                    ),

                    COUNT(DISTINCT ta.ca_travelagency_id),

                    COUNT(DISTINCT cu.ca_customer_id)

                FROM sub_franchisee sf

                LEFT JOIN ca_travelagency ta
                    ON ta.reference_no = sf.sub_franchisee_id
                    AND ta.status IN (1,3)

                LEFT JOIN ca_customer cu
                    ON cu.ta_reference_no = ta.ca_travelagency_id
                    AND cu.status IN (1,3)

                WHERE sf.reference_no = :user_id
                AND sf.status IN (1,3)

                GROUP BY
                    sf.sub_franchisee_id,
                    sf.firstname,
                    sf.lastname

                UNION ALL

                /*----------------------------------------------------------
                | BM -> Sub Franchisee
                ----------------------------------------------------------*/
                SELECT
                    sf.sub_franchisee_id,

                    CONCAT(
                        COALESCE(sf.firstname,''),
                        ' ',
                        COALESCE(sf.lastname,'')
                    ),

                    COUNT(DISTINCT ta.ca_travelagency_id),

                    COUNT(DISTINCT cu.ca_customer_id)

                FROM sub_franchisee sf

                INNER JOIN business_mentor bm
                    ON sf.reference_no = bm.business_mentor_id

                LEFT JOIN ca_travelagency ta
                    ON ta.reference_no = sf.sub_franchisee_id
                    AND ta.status IN (1,3)

                LEFT JOIN ca_customer cu
                    ON cu.ta_reference_no = ta.ca_travelagency_id
                    AND cu.status IN (1,3)

                WHERE bm.reference_no = :user_id
                AND bm.status IN (1,3)
                AND sf.status IN (1,3)

                GROUP BY
                    sf.sub_franchisee_id,
                    sf.firstname,
                    sf.lastname

                UNION ALL

                /*----------------------------------------------------------
                | Direct Institution
                ----------------------------------------------------------*/
                SELECT
                    i.institution_id,

                    CONCAT(
                        COALESCE(i.firstname,''),
                        ' ',
                        COALESCE(i.lastname,'')
                    ),

                    COUNT(DISTINCT ibm.institution_branch_manager_id),

                    COUNT(DISTINCT cu.ca_customer_id)

                FROM institution i

                LEFT JOIN institution_branch_manager ibm
                    ON ibm.reference_no = i.institution_id
                    AND ibm.status IN (1,3)

                LEFT JOIN ca_customer cu
                    ON cu.ta_reference_no = ibm.institution_branch_manager_id
                    AND cu.status IN (1,3)

                WHERE i.reference_no = :user_id
                AND i.status IN (1,3)

                GROUP BY
                    i.institution_id,
                    i.firstname,
                    i.lastname

                UNION ALL

                /*----------------------------------------------------------
                | BM -> Institution
                ----------------------------------------------------------*/
                SELECT
                    i.institution_id,

                    CONCAT(
                        COALESCE(i.firstname,''),
                        ' ',
                        COALESCE(i.lastname,'')
                    ),

                    COUNT(DISTINCT ibm.institution_branch_manager_id),

                    COUNT(DISTINCT cu.ca_customer_id)

                FROM institution i

                INNER JOIN business_mentor bm
                    ON i.reference_no = bm.business_mentor_id

                LEFT JOIN institution_branch_manager ibm
                    ON ibm.reference_no = i.institution_id
                    AND ibm.status IN (1,3)

                LEFT JOIN ca_customer cu
                    ON cu.ta_reference_no = ibm.institution_branch_manager_id
                    AND cu.status IN (1,3)

                WHERE bm.reference_no = :user_id
                AND bm.status IN (1,3)
                AND i.status IN (1,3)

                GROUP BY
                    i.institution_id,
                    i.firstname,
                    i.lastname

            ) AS combined

            ORDER BY
                cu_count DESC,
                tc_count DESC,
                te_name ASC

            LIMIT 7
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
?>