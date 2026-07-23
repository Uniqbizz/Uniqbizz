<?php

    include_once(__DIR__.'/../../../dashboard_user_details.php');

    header('Content-Type: application/json');

    try {

        $period = $_GET['period'] ?? 'month';

        $dateWhere = '';

        switch($period){

            case 'today':
                $dateWhere = "AND DATE(cu.register_date) = CURDATE()";
            break;

            case 'week':
                $dateWhere = "AND YEARWEEK(cu.register_date,1) = YEARWEEK(CURDATE(),1)";
            break;

            case 'month':
                $dateWhere = "
                    AND MONTH(cu.register_date) = MONTH(CURDATE())
                    AND YEAR(cu.register_date) = YEAR(CURDATE())
                ";
            break;

            // case 'year':
            //     $dateWhere = "
            //         AND YEAR(cu.register_date) = YEAR(CURDATE())
            //     ";
            case 'year':
                $dateWhere = "
                    AND cu.register_date >= DATE_SUB(CURDATE(), INTERVAL 1 YEAR)
                    AND cu.register_date <= CURDATE()
                ";
            break;
        }

        $sql = $conn->prepare("
            SELECT
                ca.ca_travelagency_id AS tc_id,

                CONCAT(
                    COALESCE(ca.firstname,''),
                    ' ',
                    COALESCE(ca.lastname,'')
                ) AS tc_name,

                COUNT(DISTINCT cu.ca_customer_id) AS cu_count,

                COALESCE(SUM(cu.paid_amount), 0) AS tc_revenue,

                COALESCE(SUM(tc.commision_tc), 0) AS tc_earning

            FROM ca_travelagency ca

            LEFT JOIN ca_customer cu
                ON cu.ta_reference_no = ca.ca_travelagency_id
                AND cu.status IN (1,3)
                $dateWhere

            LEFT JOIN ca_cu_payout tc
                ON tc.customer = cu.ca_customer_id
                AND tc.travel_consultant = ca.ca_travelagency_id

            WHERE ca.reference_no = :user_id
            AND ca.status IN (1,3)

            GROUP BY
                ca.ca_travelagency_id,
                ca.firstname,
                ca.lastname

            ORDER BY tc_revenue DESC

            LIMIT 6
        ");

        $sql->execute([
            ':user_id' => $userId
        ]);

        $data = $sql->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode([
            'status' => true,
            'data'   => $data
        ]);

    } catch(Exception $e){

        echo json_encode([
            'status' => false,
            'message' => $e->getMessage()
        ]);
    }
?>