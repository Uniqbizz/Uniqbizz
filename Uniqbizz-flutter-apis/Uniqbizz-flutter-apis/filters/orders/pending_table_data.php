<?php
require '../../connect.php';
header('Content-Type: application/json');

try {
    $input = json_decode(file_get_contents("php://input"), true);
    if (!$input) $input = $_POST;

    if (!isset($input['id']) || !isset($input['userType'])) {
        echo json_encode(["status" => "error", "message" => "userId and userType are required"]);
        exit;
    }

    $userId   = $input['id'];
    $userType = $input['userType'];

    // REQUIRED FILTER INPUT (as you asked)
    $search    = isset($input['search']) ? trim($input['search']) : "";
    $fromDate  = isset($input['fromDate']) ? $input['fromDate'] : "";
    $toDate    = isset($input['toDate']) ? $input['toDate'] : "";

    $customer_fil   = "";
    $booking_filter = "";

    // ---------------- USER TYPE SQL (UNCHANGED) ----------------
    if ($userType == '24') {
        $sql0 = "SELECT ca.ca_travelagency_id, ca.firstname, ca.lastname, ca.email, ca.contact_no
                 FROM ca_travelagency ca
                 INNER JOIN corporate_agency co ON co.corporate_agency_id = ca.reference_no AND co.status = 1
                 INNER JOIN business_mentor bm ON co.reference_no = bm.business_mentor_id AND bm.status = 1
                 INNER JOIN employees bdm ON bdm.employee_id = bm.reference_no AND bdm.status = 1
                 INNER JOIN employees bcm ON bcm.employee_id = bdm.reporting_manager AND bcm.status = 1
                 WHERE ca.status = 1 AND bcm.employee_id = '$userId'";
    } elseif ($userType == '25') {
        $sql0 = "SELECT ca.ca_travelagency_id, ca.firstname, ca.lastname, ca.email, ca.contact_no
                 FROM ca_travelagency ca
                 INNER JOIN corporate_agency co ON co.corporate_agency_id = ca.reference_no AND co.status = 1
                 INNER JOIN business_mentor bm ON co.reference_no = bm.business_mentor_id AND bm.status = 1
                 INNER JOIN employees bdm ON bdm.employee_id = bm.reference_no AND bdm.status = 1
                 WHERE ca.status = 1 AND bdm.employee_id = '$userId'
                 UNION
                 SELECT ca.ca_travelagency_id, ca.firstname, ca.lastname, ca.email, ca.contact_no
                 FROM ca_travelagency ca
                 INNER JOIN corporate_agency co ON co.corporate_agency_id = ca.reference_no AND co.status = 1
                 INNER JOIN employees te ON co.corporate_agency_id = te.employee_id AND te.status = 1
                 WHERE ca.status = 1 AND te.reporting_manager = '$userId'";
    } elseif ($userType == '26') {
        $sql0 = "SELECT ca.ca_travelagency_id, ca.firstname, ca.lastname, ca.email, ca.contact_no
                 FROM ca_travelagency ca
                 INNER JOIN corporate_agency co ON co.corporate_agency_id = ca.reference_no AND co.status = 1
                 INNER JOIN business_mentor bm ON co.reference_no = bm.business_mentor_id AND bm.status = 1
                 WHERE ca.status = 1 AND bm.business_mentor_id = '$userId'
                 UNION
                 SELECT ca.ca_travelagency_id, ca.firstname, ca.lastname, ca.email, ca.contact_no
                 FROM ca_travelagency ca
                 WHERE ca.status = 1 AND ca.reference_no = '$userId'";
    } elseif ($userType == '28') {
        $sql0 = "SELECT ca.ca_travelagency_id, ca.firstname, ca.lastname, ca.email, ca.contact_no
                 FROM ca_travelagency ca
                 INNER JOIN sub_franchisee co ON co.sub_franchisee_id = ca.reference_no AND co.status = 1
                 INNER JOIN master_franchisee bm ON co.reference_no = bm.master_franchisee_id AND bm.status = 1
                 WHERE ca.status = 1 AND bm.master_franchisee_id = '$userId'
                 UNION
                 SELECT ca.ca_travelagency_id, ca.firstname, ca.lastname, ca.email, ca.contact_no
                 FROM ca_travelagency ca
                 WHERE ca.status = 1 AND ca.reference_no = '$userId'";
    } elseif ($userType == '16' || $userType == '29') {
        $sql0 = "SELECT ca.ca_travelagency_id, ca.firstname, ca.lastname, ca.email, ca.contact_no
                 FROM ca_travelagency ca
                 WHERE ca.status = 1 AND ca.reference_no = '$userId'";
    } elseif ($userType == '11') {
        $sql0 = "SELECT ca.ca_travelagency_id, ca.firstname, ca.lastname, ca.email, ca.contact_no
                 FROM ca_travelagency ca
                 WHERE ca.status = 1 AND ca.ca_travelagency_id = '$userId'";
    } elseif ($userType == '10') {
        $sql0 = "SELECT ca.ca_travelagency_id, ca.firstname, ca.lastname, ca.email, ca.contact_no
                 FROM ca_travelagency ca
                 INNER JOIN ca_customer cc ON cc.ta_reference_no = ca.ca_travelagency_id AND cc.status = 1
                 WHERE ca.status = 1 AND cc.ca_customer_id = '$userId'";
        $customer_fil = " AND b.customer_id = '$userId'";
    }else {
        echo json_encode(["status" => "error", "message" => "Invalid userType"]);
        exit;
    }

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
    if (!empty($fromDate) && !empty($toDate)) {
        $booking_filter .= " AND DATE(b.date) BETWEEN '$fromDate' AND '$toDate'";
    }

    if (!empty($search)) {
        $booking_filter .= " AND (
            b.id LIKE '%$search%' OR
            b.order_id LIKE '%$search%' OR
            b.customer_id LIKE '%$search%' OR
            b.name LIKE '%$search%' OR
            b.phone LIKE '%$search%' OR
            b.email LIKE '%$search%' OR
            p.name LIKE '%$search%'
        )";
    }

    // ---------------- MAIN QUERY ----------------
    $sql = "SELECT b.id, b.order_id, b.customer_id, b.package_id, p.name AS package_name,
                   p.tour_days, b.name AS c_name, b.phone, b.email, b.date, b.ta_id, 
                   b.status, b.confirm_status,
                   bd.pay_type, bd.part_pay_1, bd.part_pay_2, bd.part_pay_3,
                   bd.part_pay_1_status, bd.part_pay_2_status, bd.part_pay_3_status,
                   bd.final_price, bd.amount
            FROM bookings b
            JOIN package p ON b.package_id = p.id
            LEFT JOIN booking_direct_bill bd ON b.id = bd.bookings_id
            WHERE b.ta_id IN ($ta_ids_str)
              AND b.status NOT IN ('2','3') AND b.confirm_status=0
              $customer_fil
              $booking_filter
            GROUP BY b.id, b.order_id, b.customer_id, b.package_id, p.name, p.tour_days, 
                     b.name, b.phone, b.email, b.date, b.ta_id, b.status, b.confirm_status,
                     bd.pay_type, bd.part_pay_1, bd.part_pay_2, bd.part_pay_3,
                     bd.part_pay_1_status, bd.part_pay_2_status, bd.part_pay_3_status,
                     bd.final_price, bd.amount
            ORDER BY b.date";

    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (empty($bookings)) {
        echo json_encode(["status" => "success", "bookings" => []]);
        exit;
    }

    $result = [];

    foreach ($bookings as $booking) {

        $ta_details = null;
        foreach ($ta_list as $ta) {
            if ($ta['ca_travelagency_id'] == $booking['ta_id']) {
                $ta_details = $ta;
                break;
            }
        }

        $perecent_fill = 0;
        $booking_paid_amt = 0;
        $booking_full_amt = 0;

        // PAYMENT LOGIC (UNCHANGED)
        if ($booking['pay_type'] == 2) {
            if ($booking['part_pay_1_status'] == 1 && $booking['part_pay_2_status'] == 1) {
                $perecent_fill = 100;
                $booking_paid_amt = $booking['part_pay_1'] + $booking['part_pay_2'];
                $booking_full_amt = $booking['final_price'];
            } else continue;
        } elseif ($booking['pay_type'] == 3) {
            if ($booking['part_pay_1_status'] == 1 && $booking['part_pay_2_status'] == 1 && $booking['part_pay_3_status'] == 1) {
                $perecent_fill = 100;
                $booking_paid_amt = $booking['part_pay_1'] + $booking['part_pay_2'] + $booking['part_pay_3'];
                $booking_full_amt = $booking['final_price'];
            } else continue;
        } else {
            $perecent_fill = 100;
            $booking_paid_amt = $booking['amount'];
            $booking_full_amt = $booking['final_price'];
        }

        if ($perecent_fill !== 100) continue;

        // STATUS LOGIC (UNCHANGED)
        $startDate = new DateTime($booking['date']);
        $tourDays = (int)($booking['tour_days'] ?? 0);
        $endDate = clone $startDate;
        $endDate->modify("+$tourDays days");
        $today = new DateTime();
        $today->setTime(0, 0);

        $status = ($booking['confirm_status'] == 0)
            ? "Pending"
            : (($booking['confirm_status'] == 1 && $today >= $startDate && $today <= $endDate)
                ? "In Transit"
                : "Confirmed");

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
            "status" => $status
        ];
    }

    echo json_encode([
        "status" => "success",
        "bookings" => $result
    ]);

} catch (Exception $e) {
    echo json_encode([
        "status" => "error",
        "message" => $e->getMessage()
    ]);
}