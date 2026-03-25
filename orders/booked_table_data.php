<?php
require '../connect.php';
header('Content-Type: application/json');

try {
    // Get input data
    $input = json_decode(file_get_contents("php://input"), true);
    if (!$input) {
        $input = $_POST;
    }

    if (!isset($input['userId']) || !isset($input['userType'])) {
        echo json_encode(["status" => "error", "message" => "userId and userType are required"]);
        exit;
    }

    $userId   = $input['userId'];
    $userType = $input['userType'];
    $start_date_formatted = isset($input['startDate']) ? $input['startDate'] : date("Y-m-01");
    $end_date_formatted   = isset($input['endDate']) ? $input['endDate'] : date("Y-m-t");
    $tab_name             = isset($input['tabName']) ? $input['tabName'] : 'booked';
    $customer_fil         = "";
    $booking_filter       = "";

    // Determine SQL based on user type
    if ($userType == '24') {
        // BCM
        $sql0 = "SELECT ca.ca_travelagency_id, ca.firstname, ca.lastname, ca.email, ca.contact_no
                 FROM ca_travelagency ca
                 INNER JOIN corporate_agency co ON co.corporate_agency_id = ca.reference_no AND co.status = 1
                 INNER JOIN business_mentor bm ON co.reference_no = bm.business_mentor_id AND bm.status = 1
                 INNER JOIN employees bdm ON bdm.employee_id = bm.reference_no AND bdm.status = 1
                 INNER JOIN employees bcm ON bcm.employee_id = bdm.reporting_manager AND bcm.status = 1
                 WHERE ca.status = 1 AND bcm.employee_id = '$userId'
                 GROUP BY ca.ca_travelagency_id, ca.firstname, ca.lastname, ca.email, ca.contact_no";
    } elseif ($userType == '25') {
        // BDM
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
        // BM
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
        // MF
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
        // TE/F
        $sql0 = "SELECT ca.ca_travelagency_id, ca.firstname, ca.lastname, ca.email, ca.contact_no
                 FROM ca_travelagency ca
                 WHERE ca.status = 1 AND ca.reference_no = '$userId'
                 GROUP BY ca.ca_travelagency_id, ca.firstname, ca.lastname, ca.email, ca.contact_no";
    } elseif ($userType == '11') {
        // TC
        $sql0 = "SELECT ca.ca_travelagency_id, ca.firstname, ca.lastname, ca.email, ca.contact_no
                 FROM ca_travelagency ca
                 WHERE ca.status = 1 AND ca.ca_travelagency_id = '$userId'
                 GROUP BY ca.ca_travelagency_id, ca.firstname, ca.lastname, ca.email, ca.contact_no";
    } elseif ($userType == '10') {
        // Customer
        $sql0 = "SELECT ca.ca_travelagency_id, ca.firstname, ca.lastname, ca.email, ca.contact_no
                 FROM ca_travelagency ca
                 INNER JOIN ca_customer cc ON cc.ta_reference_no = ca.ca_travelagency_id AND cc.status = 1
                 WHERE ca.status = 1 AND cc.ca_customer_id = '$userId'
                 GROUP BY ca.ca_travelagency_id, ca.firstname, ca.lastname, ca.email, ca.contact_no";
        $customer_fil = " AND b.customer_id = '$userId'";
    }

    $stmt0 = $conn->prepare($sql0);
    $stmt0->execute();
    $ta_list = $stmt0->fetchAll(PDO::FETCH_ASSOC);

    if (empty($ta_list)) {
        echo json_encode(["status" => "success", "data" => [], "message" => "No Travel Agencies Found"]);
        exit;
    }

    $ta_details = [];
    $ta_ids = [];
        
    foreach ($ta_list as $ta) {
        $ta_ids[] = $ta['ca_travelagency_id'];
        $ta_details[$ta['ca_travelagency_id']] = [
            'ca_travelagency_id' => $ta['ca_travelagency_id'],
            'firstname' => $ta['firstname'],
            'lastname' => $ta['lastname'],
            'email' => $ta['email'],
            'contact_no' => $ta['contact_no']
        ];
    }

    $ta_ids_str = "'" . implode("','", $ta_ids) . "'";
    if($start_date_formatted && $end_date_formatted){
        $booking_filter=" BETWEEN '$start_date_formatted' AND '$end_date_formatted' ";
    }
    
    // Modified query with FULL GROUP BY compliance
    $sql = "SELECT b.id, b.order_id, b.customer_id, b.package_id, p.name AS package_name,
                   p.tour_days, b.name AS c_name, b.phone, b.email, b.date, b.ta_id, 
                   b.status, b.confirm_status,
                   bd.pay_type, bd.part_pay_1, bd.part_pay_2, bd.part_pay_3,
                   bd.part_pay_1_status, bd.part_pay_2_status, bd.part_pay_3_status,
                   bd.final_price, bd.amount
            FROM bookings b
            JOIN package p ON b.package_id = p.id
            LEFT JOIN booking_direct_bill bd ON b.id = bd.bookings_id
            WHERE b.ta_id IN ($ta_ids_str) AND b.status='1'
            AND b.date $booking_filter $customer_fil
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
        echo json_encode(["status" => "success", "bookings" => [], "message" => "No Bookings Found"]);
        exit;
    }

    $result = [];
    foreach ($bookings as $booking) {
        // No separate query for booking_bill - data already included in main query
        
        // $formattedDate = date("d-m-Y", strtotime($booking['date']));
        // $agency_info = $ta_details[$booking['ta_id']] ?? ['firstname' => '', 'lastname' => '', 'email' => '', 'phone' => ''];

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

        // Payment logic using data from main query
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

        // Tour status
        $startDate = new DateTime($booking['date']);
        $tourDays = (int)($booking['tour_days'] ?? 0);
        $endDate = clone $startDate;
        $endDate->modify("+$tourDays days");
        $today = new DateTime();
        $today->setTime(0, 0);

        if ($booking['status'] === '2') {
            $booking_status = "Canceled";
        } elseif ($booking['status'] === '3') {
            $booking_status = "Refunded";
        } elseif ($booking['confirm_status'] === '0') {
            $booking_status = "Pending";
        } elseif ($booking['confirm_status'] === '1' && $today < $startDate) {
            $booking_status = "Confirmed";
        } elseif ($today > $endDate) {
            $booking_status = "Completed";
        } elseif ($today >= $startDate && $today <= $endDate) {
            $booking_status = "In Transit";
        } else {
            $booking_status = "Unknown";
        }

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
            "status" => $booking_status
        ];
    }

    echo json_encode(["status" => "success", "bookings" => $result]);
} catch (PDOException $e) {
    echo json_encode(["status" => "error", "message" => "Database error: " . $e->getMessage()]);
}