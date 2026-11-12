<?php
header('Content-Type: application/json');
require '../connect.php';

$response = [
    "status" => false,
    "message" => "",
    "data" => []
];

try {
    $request = json_decode(file_get_contents('php://input'), true);
    $userId = $request['userId'] ?? $userId;
    $userType = $request['userType'] ?? $userType;

    if (empty($userId) || empty($userType)) {
        throw new Exception("Missing required parameters: userId or userType");
    }

    // Build hierarchy filter based on user type
    $filter = "";
    switch ($userType) {
        case '24': // BCM
            $filter = " AND b.ta_id IN (
                SELECT ca.ca_travelagency_id FROM ca_travelagency ca
                INNER JOIN corporate_agency co ON co.corporate_agency_id = ca.reference_no AND co.status = 1
                INNER JOIN business_mentor bm ON bm.business_mentor_id = co.reference_no AND bm.status = 1
                INNER JOIN employees bdm ON bdm.employee_id = bm.reference_no AND bdm.status = 1
                INNER JOIN employees bcm ON bcm.employee_id = bdm.reporting_manager AND bcm.status = 1
                WHERE ca.status = 1 AND bcm.employee_id = '$userId'

                UNION

                SELECT ca.ca_travelagency_id FROM ca_travelagency ca
                INNER JOIN business_mentor bm ON bm.business_mentor_id = ca.reference_no AND bm.status = 1
                INNER JOIN employees bdm ON bdm.employee_id = bm.reference_no AND bdm.status = 1
                INNER JOIN employees bcm ON bcm.employee_id = bdm.reporting_manager AND bcm.status = 1
                WHERE ca.status = 1 AND bcm.employee_id = '$userId'

                UNION

                SELECT ca.ca_travelagency_id FROM ca_travelagency ca
                INNER JOIN master_franchisee mf ON mf.master_franchisee_id = ca.reference_no AND mf.status = 1
                INNER JOIN employees bdm ON bdm.employee_id = mf.reference_no AND bdm.status = 1
                INNER JOIN employees bcm ON bcm.employee_id = bdm.reporting_manager AND bcm.status = 1
                WHERE ca.status = 1 AND bcm.employee_id = '$userId'

                UNION

                SELECT ca.ca_travelagency_id FROM ca_travelagency ca
                INNER JOIN sub_franchisee f ON f.sub_franchisee_id = ca.reference_no AND f.status = 1
                INNER JOIN master_franchisee mf ON mf.master_franchisee_id = f.reference_no AND mf.status = 1
                INNER JOIN employees bdm ON bdm.employee_id = mf.reference_no AND bdm.status = 1
                INNER JOIN employees bcm ON bcm.employee_id = bdm.reporting_manager AND bcm.status = 1
                WHERE ca.status = 1 AND bcm.employee_id = '$userId'

                UNION

                SELECT ca.ca_travelagency_id FROM ca_travelagency ca
                INNER JOIN sub_franchisee f ON f.sub_franchisee_id = ca.reference_no AND f.status = 1
                INNER JOIN sponsor_franchisee sf ON sf.sponsor_franchisee_id = f.reference_no AND sf.status = 1
                INNER JOIN employees bdm ON bdm.employee_id = sf.reference_no AND bdm.status = 1
                INNER JOIN employees bcm ON bcm.employee_id = bdm.reporting_manager AND bcm.status = 1
                WHERE ca.status = 1 AND bcm.employee_id = '$userId'

                UNION

                SELECT ca.ca_travelagency_id FROM ca_travelagency ca
                INNER JOIN employees bdm ON bdm.employee_id = ca.reference_no AND bdm.status = 1
                INNER JOIN employees bcm ON bcm.employee_id = bdm.reporting_manager AND bcm.status = 1
                WHERE ca.status = 1 AND bcm.employee_id = '$userId'
            )";
            break;

        case '25': // BDM
            $filter = " AND b.ta_id IN (
                SELECT ca.ca_travelagency_id FROM ca_travelagency ca
                INNER JOIN corporate_agency co ON co.corporate_agency_id = ca.reference_no AND co.status = 1
                INNER JOIN business_mentor bm ON bm.business_mentor_id = co.reference_no AND bm.status = 1
                INNER JOIN employees bdm ON bdm.employee_id = bm.reference_no AND bdm.status = 1
                WHERE ca.status = 1 AND bdm.employee_id = '$userId'

                UNION

                SELECT ca.ca_travelagency_id FROM ca_travelagency ca
                INNER JOIN business_mentor bm ON bm.business_mentor_id = ca.reference_no AND bm.status = 1
                INNER JOIN employees bdm ON bdm.employee_id = bm.reference_no AND bdm.status = 1
                WHERE ca.status = 1 AND bdm.employee_id = '$userId'

                UNION

                SELECT ca.ca_travelagency_id FROM ca_travelagency ca
                INNER JOIN master_franchisee mf ON mf.master_franchisee_id = ca.reference_no AND mf.status = 1
                INNER JOIN employees bdm ON bdm.employee_id = mf.reference_no AND bdm.status = 1
                WHERE ca.status = 1 AND bdm.employee_id = '$userId'

                UNION

                SELECT ca.ca_travelagency_id FROM ca_travelagency ca
                INNER JOIN sub_franchisee f ON f.sub_franchisee_id = ca.reference_no AND f.status = 1
                INNER JOIN master_franchisee mf ON mf.master_franchisee_id = f.reference_no AND mf.status = 1
                INNER JOIN employees bdm ON bdm.employee_id = mf.reference_no AND bdm.status = 1
                WHERE ca.status = 1 AND bdm.employee_id = '$userId'

                UNION

                SELECT ca.ca_travelagency_id FROM ca_travelagency ca
                INNER JOIN sub_franchisee f ON f.sub_franchisee_id = ca.reference_no AND f.status = 1
                INNER JOIN sponsor_franchisee sf ON sf.sponsor_franchisee_id = f.reference_no AND sf.status = 1
                INNER JOIN employees bdm ON bdm.employee_id = sf.reference_no AND bdm.status = 1
                WHERE ca.status = 1 AND bdm.employee_id = '$userId'

                UNION

                SELECT ca.ca_travelagency_id FROM ca_travelagency ca
                INNER JOIN employees bdm ON bdm.employee_id = ca.reference_no AND bdm.status = 1
                WHERE ca.status = 1 AND bdm.employee_id = '$userId'
            )";
            break;

        case '31': // RM
            $filter = " AND b.ta_id IN (
                SELECT ca.ca_travelagency_id FROM ca_travelagency ca
                INNER JOIN master_franchisee mf ON mf.master_franchisee_id = ca.reference_no AND mf.status = 1
                INNER JOIN employees bdm ON bdm.employee_id = mf.reference_no AND bdm.status = 1
                WHERE ca.status = 1 AND bdm.employee_id = '$userId'

                UNION

                SELECT ca.ca_travelagency_id FROM ca_travelagency ca
                INNER JOIN sub_franchisee f ON f.sub_franchisee_id = ca.reference_no AND f.status = 1
                INNER JOIN master_franchisee mf ON mf.master_franchisee_id = f.reference_no AND mf.status = 1
                INNER JOIN employees bdm ON bdm.employee_id = mf.reference_no AND bdm.status = 1
                WHERE ca.status = 1 AND bdm.employee_id = '$userId'

                UNION

                SELECT ca.ca_travelagency_id FROM ca_travelagency ca
                INNER JOIN sub_franchisee f ON f.sub_franchisee_id = ca.reference_no AND f.status = 1
                INNER JOIN sponsor_franchisee sf ON sf.sponsor_franchisee_id = f.reference_no AND sf.status = 1
                INNER JOIN employees bdm ON bdm.employee_id = sf.reference_no AND bdm.status = 1
                WHERE ca.status = 1 AND bdm.employee_id = '$userId'

                UNION

                SELECT ca.ca_travelagency_id FROM ca_travelagency ca
                INNER JOIN employees bdm ON bdm.employee_id = ca.reference_no AND bdm.status = 1
                WHERE ca.status = 1 AND bdm.employee_id = '$userId'
            )";
            break;

        case '26': // BM
            $filter = " AND b.ta_id IN (
                SELECT ca.ca_travelagency_id FROM ca_travelagency ca
                INNER JOIN corporate_agency co ON co.corporate_agency_id = ca.reference_no AND co.status = 1
                INNER JOIN business_mentor bm ON co.reference_no = bm.business_mentor_id AND bm.status = 1
                WHERE ca.status = 1 AND bm.business_mentor_id = '$userId'

                UNION

                SELECT ca.ca_travelagency_id FROM ca_travelagency ca
                WHERE ca.status = 1 AND ca.reference_no = '$userId'
            )";
            break;

        case '28': // MF
            $filter = " AND b.ta_id IN (
                SELECT ca.ca_travelagency_id FROM ca_travelagency ca
                INNER JOIN master_franchisee mf ON mf.master_franchisee_id = ca.reference_no AND mf.status = 1
                WHERE ca.status = 1 AND mf.master_franchisee_id = '$userId'
            )";
            break;

        case '30': // SF
            $filter = " AND b.ta_id IN (
                SELECT ca.ca_travelagency_id FROM ca_travelagency ca
                INNER JOIN sub_franchisee f ON f.sub_franchisee_id = ca.reference_no AND f.status = 1
                INNER JOIN sponsor_franchisee sf ON sf.sponsor_franchisee_id = f.reference_no AND sf.status = 1
                WHERE ca.status = 1 AND sf.sponsor_franchisee_id = '$userId'
            )";
            break;

        case '29': // F
            $filter = " AND b.ta_id IN (
                SELECT ca.ca_travelagency_id FROM ca_travelagency ca
                INNER JOIN sub_franchisee f ON f.sub_franchisee_id = ca.reference_no AND f.status = 1
                WHERE ca.status = 1 AND f.sub_franchisee_id = '$userId'
            )";
            break;

        case '16': // TE
            $filter = " AND b.ta_id IN (
                SELECT ca.ca_travelagency_id FROM ca_travelagency ca
                INNER JOIN corporate_agency co ON co.corporate_agency_id = ca.reference_no AND co.status = 1
                WHERE ca.status = 1 AND co.corporate_agency_id = '$userId'
            )";
            break;

        case '11': // TC
            $filter = " AND b.ta_id = '$userId'";
            break;

        case '10': // Customer
            $filter = " AND b.customer_id = '$userId'";
            break;

        default:
            throw new Exception("Invalid user type: $userType");
    }

    // Single SQL query with full GROUP BY
    $sql = "SELECT 
                COUNT(*) as total_bookings,
                SUM(CASE 
                    WHEN b.status = '2' THEN 1 
                    ELSE 0 
                END) as canceled_booking_count,
                SUM(CASE 
                    WHEN b.confirm_status = '0' THEN 1 
                    ELSE 0 
                END) as pending_booking_count,
                SUM(CASE 
                    WHEN b.confirm_status = '1' 
                    AND CURDATE() BETWEEN b.date AND DATE_ADD(b.date, INTERVAL COALESCE(p.tour_days, 0) DAY) 
                    THEN 1 
                    ELSE 0 
                END) as in_transit_booking_count,
                SUM(CASE 
                    WHEN CURDATE() > DATE_ADD(b.date, INTERVAL COALESCE(p.tour_days, 0) DAY) 
                    THEN 1 
                    ELSE 0 
                END) as completed_booking_count,
                SUM(CASE 
                    WHEN b.status = '1' 
                    AND bd.status = 1 
                    THEN COALESCE(bd.final_price, 0) 
                    ELSE 0 
                END) as completed_payment_amt,
                SUM(CASE 
                    WHEN bd.part_pay_2_status = 0 THEN COALESCE(bd.part_pay_2, 0)
                    ELSE 0 
                END) + 
                SUM(CASE 
                    WHEN bd.part_pay_3_status = 0 THEN COALESCE(bd.part_pay_3, 0)
                    ELSE 0 
                END) as pending_payment_amt
            FROM bookings b
            LEFT JOIN package p ON b.package_id = p.id
            LEFT JOIN booking_direct_bill bd ON b.id = bd.bookings_id
            WHERE 1=1 
            $filter
            GROUP BY NULL";

    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        $response['status'] = true;
        $response['message'] = "Booking summary fetched successfully";
        $response['data'] = [
            "pending_booking_count" => (int)$result['pending_booking_count'],
            "in_transit_booking_count" => (int)$result['in_transit_booking_count'],
            "completed_booking_count" => (int)$result['completed_booking_count'],
            "canceled_booking_count" => (int)$result['canceled_booking_count'],
            "pending_payment_amt" => number_format((float)$result['pending_payment_amt'], 2, '.', ''),
            "completed_payment_amt" => number_format((float)$result['completed_payment_amt'], 2, '.', ''),
        ];
    } else {
        $response['status'] = true;
        $response['message'] = "No bookings found";
        $response['data'] = [
            "pending_booking_count" => 0,
            "in_transit_booking_count" => 0,
            "completed_booking_count" => 0,
            "canceled_booking_count" => 0,
            "pending_payment_amt" => "0.00",
            "completed_payment_amt" => "0.00",
        ];
    }
} catch (Exception $e) {
    $response['message'] = $e->getMessage();
}

echo json_encode($response, JSON_PRETTY_PRINT);