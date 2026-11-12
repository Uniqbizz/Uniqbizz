<?php
    require '../../../../connect.php';
    header('Content-Type: application/json');

    if ($_SERVER["REQUEST_METHOD"] !== "POST") {
        echo json_encode([
            "status" => false,
            "message" => "Invalid request method.",
            "data" => []
        ]);
        exit;
    }

    try {

        $json = file_get_contents("php://input");
        $data = json_decode($json, true);

        if (!$data) {
            throw new Exception("Invalid JSON data.");
        }

        if (!isset($data['userId']) || empty(trim($data['userId']))) {
            throw new Exception("User ID is required.");
        }

        if (!isset($data['period']) || empty(trim($data['period']))) {
            throw new Exception("Period is required.");
        }

        $userId = trim($data['userId']);
        $period = trim(strtolower($data['period']));

        /*
        |--------------------------------------------------------------------------
        | Date Filter
        |--------------------------------------------------------------------------
        */

        $dateWhere = '';

        switch ($period) {

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

            case 'year':
                $dateWhere = "
                    AND cu.register_date >= DATE_SUB(CURDATE(), INTERVAL 1 YEAR)
                    AND cu.register_date <= CURDATE()
                ";
                break;

            default:
                throw new Exception("Invalid period. Allowed values are: today, week, month, year.");
        }

        /*
        |--------------------------------------------------------------------------
        | Top Travel Consultants
        |--------------------------------------------------------------------------
        */

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

        $result = $sql->fetchAll(PDO::FETCH_ASSOC);

        $formattedData = array_map(function ($item) {
            return [
                "tc_id" => $item["tc_id"],
                "tc_name" => $item["tc_name"],
                "cu_count" => $item["cu_count"],
                "tc_revenue" => $item["tc_revenue"],
                "tc_earning" => $item["tc_earning"]
            ];
        }, $result);

        echo json_encode([
            "status" => true,
            "message" => "Data fetched successfully.",
            "data" => $formattedData
        ]);

    } catch (Exception $e) {

        echo json_encode([
            "status" => false,
            "message" => $e->getMessage(),
            "data" => []
        ]);
    }
?>