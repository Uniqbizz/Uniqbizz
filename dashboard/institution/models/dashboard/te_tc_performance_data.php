<?php

include_once(__DIR__ . '/../../../dashboard_user_details.php');

header('Content-Type: application/json');

try {

    $period = $_GET['period'] ?? 'month';

    $dateWhere = '';

    switch ($period) {

        case 'today':
            $dateWhere = "AND DATE(cu.register_date) = CURDATE()";
            break;

        case 'week':
            $dateWhere = "AND YEARWEEK(cu.register_date, 1) = YEARWEEK(CURDATE(), 1)";
            break;

        case 'month':
            $dateWhere = "
                AND MONTH(cu.register_date) = MONTH(CURDATE())
                AND YEAR(cu.register_date) = YEAR(CURDATE())
            ";
            break;

        case 'year':
            $dateWhere = "
                AND YEAR(cu.register_date) = YEAR(CURDATE())
            ";
            break;

        default:
            $dateWhere = '';
            break;
    }


    /*
    |--------------------------------------------------------------------------
    | TC + IBR Revenue
    |--------------------------------------------------------------------------
    */

    $sql = $conn->prepare("

        SELECT *
        FROM (

            /* ================================================================
               TRAVEL CONSULTANT / TC
               ================================================================ */

            SELECT
                ca.ca_travelagency_id AS tc_id,

                CONCAT(
                    COALESCE(ca.firstname, ''),
                    ' ',
                    COALESCE(ca.lastname, '')
                ) AS tc_name,

                COUNT(DISTINCT cu.ca_customer_id) AS cu_count,

                COALESCE(
                    SUM(DISTINCT cu.paid_amount),
                    0
                ) AS tc_revenue,

                COALESCE(
                    (
                        SELECT SUM(tc1.commision_tc)
                        FROM ca_cu_payout tc1
                        WHERE tc1.travel_consultant = ca.ca_travelagency_id
                    ),
                    0
                ) AS tc_earning

            FROM ca_travelagency ca

            LEFT JOIN ca_customer cu
                ON cu.ta_reference_no = ca.ca_travelagency_id
                AND cu.status IN (1, 3)
                $dateWhere

            WHERE ca.reference_no = ?
            AND ca.status IN (1, 3)

            GROUP BY
                ca.ca_travelagency_id,
                ca.firstname,
                ca.lastname


            UNION ALL


            /* ================================================================
               INSTITUTION BRANCH MANAGER / IBR
               ================================================================ */

            SELECT
                ca.institution_branch_manager_id AS tc_id,

                CONCAT(
                    COALESCE(ca.firstname, ''),
                    ' ',
                    COALESCE(ca.lastname, '')
                ) AS tc_name,

                COUNT(DISTINCT cu.ca_customer_id) AS cu_count,

                COALESCE(
                    SUM(DISTINCT cu.paid_amount),
                    0
                ) AS tc_revenue,

                COALESCE(
                    (
                        SELECT SUM(tc1.commision_tc)
                        FROM ca_cu_payout tc1
                        WHERE tc1.travel_consultant =
                            ca.institution_branch_manager_id
                    ),
                    0
                ) AS tc_earning

            FROM institution_branch_manager ca

            LEFT JOIN ca_customer cu
                ON cu.ta_reference_no = ca.institution_branch_manager_id
                AND cu.status IN (1, 3)
                $dateWhere

            WHERE ca.reference_no = ?
            AND ca.status IN (1, 3)

            GROUP BY
                ca.institution_branch_manager_id,
                ca.firstname,
                ca.lastname

        ) AS combined_data

        ORDER BY tc_revenue DESC

        LIMIT 6

    ");


    $sql->execute([
        $userId,
        $userId
    ]);


    $data = $sql->fetchAll(PDO::FETCH_ASSOC);


    echo json_encode([
        'status' => true,
        'data'   => $data
    ]);


} catch (Exception $e) {

    echo json_encode([
        'status'  => false,
        'message' => $e->getMessage()
    ]);
}

?>