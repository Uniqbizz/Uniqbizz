<?php
require '../../connect.php';
header('Content-Type: application/json');

try {
    $input = json_decode(file_get_contents("php://input"), true);
    if (!$input) {
        $input = $_POST;
    }

    if (!isset($input['id']) || !isset($input['userType'])) {
        echo json_encode(["status" => "error", "message" => "userId and userType are required"]);
        exit;
    }

    $userId = $input['id'];
    $userType = $input['userType'];

    // FILTER PARAMS
    $search = isset($input['search']) ? trim($input['search']) : "";
    $fromDate = isset($input['fromDate']) ? trim($input['fromDate']) : "";
    $toDate = isset($input['toDate']) ? trim($input['toDate']) : "";

    $customer_fil = "";

    // ---------------- USER TYPE SQL (UNCHANGED) ----------------
    if ($userType == '24') {
        $sql0 = "SELECT ca.ca_travelagency_id, ca.firstname, ca.lastname, ca.email, ca.contact_no
                 FROM ca_travelagency ca
                 INNER JOIN corporate_agency co ON co.corporate_agency_id = ca.reference_no AND co.status = 1
                 INNER JOIN business_mentor bm ON co.reference_no = bm.business_mentor_id AND bm.status = 1
                 INNER JOIN employees bdm ON bdm.employee_id = bm.reference_no AND bdm.status = 1
                 INNER JOIN employees bcm ON bcm.employee_id = bdm.reporting_manager AND bcm.status = 1
                 WHERE ca.status = 1 AND bcm.employee_id = '$userId'
                 GROUP BY ca.ca_travelagency_id, ca.firstname, ca.lastname, ca.email, ca.contact_no";
    } elseif ($userType == '25') {
        $sql0 = "SELECT ca.ca_travelagency_id, ca.firstname, ca.lastname, ca.email, ca.contact_no
                 FROM ca_travelagency ca
                 INNER JOIN corporate_agency co ON co.corporate_agency_id = ca.reference_no AND co.status = 1
                 INNER JOIN business_mentor bm ON co.reference_no = bm.business_mentor_id AND bm.status = 1
                 INNER JOIN employees bdm ON bdm.employee_id = bm.reference_no AND bdm.status = 1
                 WHERE ca.status = 1 AND bdm.employee_id = '$userId'
                 GROUP BY ca.ca_travelagency_id, ca.firstname, ca.lastname, ca.email, ca.contact_no
                 UNION
                 SELECT ca.ca_travelagency_id, ca.firstname, ca.lastname, ca.email, ca.contact_no
                 FROM ca_travelagency ca
                 INNER JOIN corporate_agency co ON co.corporate_agency_id = ca.reference_no AND co.status = 1
                 INNER JOIN employees te ON co.corporate_agency_id = te.employee_id AND te.status = 1
                 WHERE ca.status = 1 AND te.reporting_manager = '$userId'
                 GROUP BY ca.ca_travelagency_id, ca.firstname, ca.lastname, ca.email, ca.contact_no";
    } elseif ($userType == '26') {
        $sql0 = "SELECT ca.ca_travelagency_id, ca.firstname, ca.lastname, ca.email, ca.contact_no
                 FROM ca_travelagency ca
                 INNER JOIN corporate_agency co ON co.corporate_agency_id = ca.reference_no AND co.status = 1
                 INNER JOIN business_mentor bm ON co.reference_no = bm.business_mentor_id AND bm.status = 1
                 WHERE ca.status = 1 AND bm.business_mentor_id = '$userId'
                 GROUP BY ca.ca_travelagency_id, ca.firstname, ca.lastname, ca.email, ca.contact_no
                 UNION
                 SELECT ca.ca_travelagency_id, ca.firstname, ca.lastname, ca.email, ca.contact_no
                 FROM ca_travelagency ca
                 WHERE ca.status = 1 AND ca.reference_no = '$userId'
                 GROUP BY ca.ca_travelagency_id, ca.firstname, ca.lastname, ca.email, ca.contact_no";
    } elseif ($userType == '28') {
        $sql0 = "SELECT ca.ca_travelagency_id, ca.firstname, ca.lastname, ca.email, ca.contact_no
                 FROM ca_travelagency ca
                 INNER JOIN sub_franchisee co ON co.sub_franchisee_id = ca.reference_no AND co.status = 1
                 INNER JOIN master_franchisee bm ON co.reference_no = bm.master_franchisee_id AND bm.status = 1
                 WHERE ca.status = 1 AND bm.master_franchisee_id = '$userId'
                 GROUP BY ca.ca_travelagency_id, ca.firstname, ca.lastname, ca.email, ca.contact_no
                 UNION
                 SELECT ca.ca_travelagency_id, ca.firstname, ca.lastname, ca.email, ca.contact_no
                 FROM ca_travelagency ca
                 WHERE ca.status = 1 AND ca.reference_no = '$userId'
                 GROUP BY ca.ca_travelagency_id, ca.firstname, ca.lastname, ca.email, ca.contact_no";
    } elseif ($userType == '16' || $userType == '29') {
        $sql0 = "SELECT ca.ca_travelagency_id, ca.firstname, ca.lastname, ca.email, ca.contact_no
                 FROM ca_travelagency ca
                 WHERE ca.status = 1 AND ca.reference_no = '$userId'
                 GROUP BY ca.ca_travelagency_id, ca.firstname, ca.lastname, ca.email, ca.contact_no";
    } elseif ($userType == '11') {
        $sql0 = "SELECT ca.ca_travelagency_id, ca.firstname, ca.lastname, ca.email, ca.contact_no
                 FROM ca_travelagency ca
                 WHERE ca.status = 1 AND ca.ca_travelagency_id = '$userId'
                 GROUP BY ca.ca_travelagency_id, ca.firstname, ca.lastname, ca.email, ca.contact_no";
    } elseif ($userType == '10') {
        $sql0 = "SELECT ca.ca_travelagency_id, ca.firstname, ca.lastname, ca.email, ca.contact_no
                 FROM ca_travelagency ca
                 INNER JOIN ca_customer cc ON cc.ta_reference_no = ca.ca_travelagency_id AND cc.status = 1
                 WHERE ca.status = 1 AND cc.ca_customer_id = '$userId'
                 GROUP BY ca.ca_travelagency_id, ca.firstname, ca.lastname, ca.email, ca.contact_no";
        $customer_fil = " AND b.customer_id = '$userId'";
    } else {
        echo json_encode(["status" => "error", "message" => "Invalid userType"]);
        exit;
    }

    // ---------------- FETCH TA ----------------
    $stmt0 = $conn->prepare($sql0);
    $stmt0->execute();
    $ta_list = $stmt0->fetchAll(PDO::FETCH_ASSOC);

    if (empty($ta_list)) {
        echo json_encode(["status" => "success", "bookings" => []]);
        exit;
    }

    $ta_ids = array_column($ta_list, 'ca_travelagency_id');
    $ta_ids_str = "'" . implode("','", $ta_ids) . "'";

    // ---------------- FILTERS ----------------
    $filters = "";

    if (!empty($search)) {
        $filters .= " AND (
            b.id LIKE '%$search%' OR
            b.order_id LIKE '%$search%' OR
            b.customer_id LIKE '%$search%' OR
            b.name LIKE '%$search%' OR
            b.phone LIKE '%$search%' OR
            b.email LIKE '%$search%' OR
            p.name LIKE '%$search%'
        )";
    }

    if (!empty($fromDate) && !empty($toDate)) {
        $filters .= " AND DATE(b.date) BETWEEN '$fromDate' AND '$toDate'";
    }

    // ---------------- MAIN QUERY (UNCHANGED STRUCTURE) ----------------
    $sql = "SELECT 
                b.id, 
                b.order_id, 
                b.customer_id, 
                b.package_id, 
                p.name AS package_name, 
                p.tour_days,
                b.name AS c_name, 
                b.phone, 
                b.email, 
                b.date, 
                b.ta_id, 
                b.status,
                b.confirm_status,
                bd.pay_type,
                bd.final_price,
                bd.amount,
                bd.part_pay_1,
                bd.part_pay_2,
                bd.part_pay_3,
                bd.part_pay_1_status,
                bd.part_pay_2_status,
                bd.part_pay_3_status
            FROM bookings b
            INNER JOIN package p ON b.package_id = p.id
            LEFT JOIN booking_direct_bill bd ON b.id = bd.bookings_id
            WHERE b.ta_id IN ($ta_ids_str)
              $customer_fil
              $filters
            GROUP BY 
                b.id, b.order_id, b.customer_id, b.package_id, p.name, p.tour_days,
                b.name, b.phone, b.email, b.date, b.ta_id, b.status, b.confirm_status,
                bd.pay_type, bd.final_price, bd.amount, bd.part_pay_1, bd.part_pay_2,
                bd.part_pay_3, bd.part_pay_1_status, bd.part_pay_2_status, bd.part_pay_3_status
            ORDER BY b.date";

    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (empty($bookings)) {
        echo json_encode([
            "status" => "success",
            "bookings" => []
        ]);
        exit;
    }

    $result = [];

    foreach ($bookings as $booking) {

        // PAYMENT (UNCHANGED)
        $perecent_fill = 0;
        $booking_paid_amt = 0;
        $booking_full_amt = $booking['final_price'];

        if ($booking['pay_type'] == 2) {
            if ($booking['part_pay_1_status'] == 1 && $booking['part_pay_2_status'] == 0) {
                $perecent_fill = 50;
                $booking_paid_amt = $booking['part_pay_1'];
            } elseif ($booking['part_pay_1_status'] == 1 && $booking['part_pay_2_status'] == 1) {
                $perecent_fill = 100;
                $booking_paid_amt = $booking['part_pay_1'] + $booking['part_pay_2'];
            }
        } elseif ($booking['pay_type'] == 3) {
            if ($booking['part_pay_1_status'] == 1 && $booking['part_pay_2_status'] == 0 && $booking['part_pay_3_status'] == 0) {
                $perecent_fill = 40;
                $booking_paid_amt = $booking['part_pay_1'];
            } elseif ($booking['part_pay_1_status'] == 1 && $booking['part_pay_2_status'] == 1 && $booking['part_pay_3_status'] == 0) {
                $perecent_fill = 70;
                $booking_paid_amt = $booking['part_pay_1'] + $booking['part_pay_2'];
            } elseif ($booking['part_pay_1_status'] == 1 && $booking['part_pay_2_status'] == 1 && $booking['part_pay_3_status'] == 1) {
                $perecent_fill = 100;
                $booking_paid_amt = $booking['part_pay_1'] + $booking['part_pay_2'] + $booking['part_pay_3'];
            }
        } else {
            $perecent_fill = 100;
            $booking_paid_amt = $booking['amount'];
        }

        // STATUS (UNCHANGED)
        $startDate = new DateTime($booking['date']);
        $tourDays = !empty($booking['tour_days']) ? (int)$booking['tour_days'] : 0;
        $endDate = clone $startDate;
        $endDate->modify("+$tourDays days");
        $today = new DateTime();
        $today->setTime(0, 0);

        if ($booking['status'] === '2') {
            $booking_status = "Canceled";
        } elseif ($booking['status'] === '3') {
            $booking_status = "Refunded";
        } elseif ($booking['status'] === '0') {
            $booking_status = "Pending";
        } elseif ($booking['status'] === '1' && $today < $startDate) {
            $booking_status = "Confirmed";
        } elseif ($booking['status'] === '1' && ($today == $startDate || $today <= $endDate)){
            $booking_status = "Traveling";
        } elseif ($booking['status'] === '1' && $today > $endDate) {
            $booking_status = "Completed";
        } else {
            $booking_status = "Unknown";
        }

        // TA DETAILS (UNCHANGED)
        $ta_details = null;
        foreach ($ta_list as $ta) {
            if ($ta['ca_travelagency_id'] == $booking['ta_id']) {
                $ta_details = $ta;
                break;
            }
        }

        // FINAL RESPONSE (EXACTLY YOUR FORMAT)
        $result[] = [
            "id" => $booking['id'],
            "booking_id" => $booking['order_id'],
            "date" => $booking['date'],
            "package_name" => $booking['package_name'],
            "customer" => [
                "id" => $booking['customer_id'],
                "name" => $booking['c_name'],
                "phone" => $booking['phone'],
                "email" => $booking['email']
            ],
            "travel_agency" => $ta_details,
            "payment" => [
                "percent_fill" => $perecent_fill,
                "paid_amount" => $booking_paid_amt,
                "full_amount" => $booking_full_amt
            ],
            "status" => $booking_status,
        ];
    }

    echo json_encode([
        "status" => "success",
        "bookings" => $result
    ], JSON_PRETTY_PRINT);

} catch (Exception $e) {
    echo json_encode([
        "status" => "error",
        "message" => $e->getMessage()
    ]);
}