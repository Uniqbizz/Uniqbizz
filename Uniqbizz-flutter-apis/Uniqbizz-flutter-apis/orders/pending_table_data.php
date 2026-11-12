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
    $tab_name             = isset($input['tabName']) ? $input['tabName'] : 'pending';
    $customer_fil         = "";
    $booking_filter       ='';

    // User type-based query - Made ONLY_FULL_GROUP_BY compatible by ensuring all UNION queries have same columns
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
    }

    $stmt0 = $conn->prepare($sql0);
    $stmt0->execute();
    $ta_list = $stmt0->fetchAll(PDO::FETCH_ASSOC);

    if (empty($ta_list)) {
        echo json_encode(["status" => "success", "data" => [], "message" => "No Travel Agencies Found"]);
        exit;
    }

    // Map TA details
    $ta_details = [];
    $ta_ids = [];
    foreach ($ta_list as $ta) {
        $ta_ids[] = $ta['ca_travelagency_id'];
        $ta_details[$ta['ca_travelagency_id']] = [
            'firstname' => $ta['firstname'],
            'lastname'  => $ta['lastname'],
            'email'     => $ta['email'],
            'phone'     => $ta['contact_no']
        ];
    }
    
    $ta_ids_str = "'" . implode("','", $ta_ids) . "'";
    if($start_date_formatted && $end_date_formatted){
        $booking_filter=" BETWEEN '$start_date_formatted' AND '$end_date_formatted' ";
    }

    // Get bookings - Fixed for ONLY_FULL_GROUP_BY by using b.ta_id in GROUP BY
    $sql = "SELECT b.id, b.order_id, b.customer_id, b.package_id, p.name AS package_name, 
                   p.tour_days, b.name AS c_name, b.phone, b.email, b.date, b.ta_id, b.confirm_status 
            FROM bookings b
            JOIN package p ON b.package_id = p.id
            WHERE b.ta_id IN ($ta_ids_str) AND b.status NOT IN ('2','3') AND b.confirm_status=0
            AND b.date $booking_filter $customer_fil 
            GROUP BY b.id, b.order_id, b.customer_id, b.package_id, p.name, 
                     p.tour_days, b.name, b.phone, b.email, b.date, b.ta_id, b.confirm_status
            ORDER BY b.date";

    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if (empty($bookings)) {
        echo json_encode(["status" => "success", "bookings" => [], "message" => "No Bookings Found"]);
        exit;
    }

    $result = [];
    $today = new DateTime();
    $today->setTime(0, 0);

    foreach ($bookings as $booking) {

        $ta_details = null;
        foreach ($ta_list as $ta) {
            if ($ta['ca_travelagency_id'] == $booking['ta_id']) {
                $ta_details = $ta;
                break;
            }
        }
        // Fetch billing
        $stmt3 = $conn->prepare("SELECT * FROM booking_direct_bill WHERE bookings_id = ?");
        $stmt3->execute([$booking['id']]);
        $booking_bill = $stmt3->fetch(PDO::FETCH_ASSOC);
        
        $startDate = new DateTime($booking['date']);
        $endDate = clone $startDate;
        $endDate->modify("+" . (int)$booking['tour_days'] . " days")->setTime(0, 0);

        // Payment calculation
        $perecent_fill = 0;
        $booking_paid_amt = 0;
        $booking_full_amt = 0;
        
        if ($booking_bill) {
            $pay_type = $booking_bill['pay_type'];
            $final_price = $booking_bill['final_price'];

            if ($pay_type == 2) {
                if ($booking_bill['part_pay_1_status'] == 1 && $booking_bill['part_pay_2_status'] == 0) {
                    $perecent_fill = 50;
                    $booking_paid_amt = $booking_bill['part_pay_1'];
                } elseif ($booking_bill['part_pay_1_status'] == 1 && $booking_bill['part_pay_2_status'] == 1) {
                    $perecent_fill = 100;
                    $booking_paid_amt = $booking_bill['part_pay_1'] + $booking_bill['part_pay_2'];
                }
            } elseif ($pay_type == 3) {
                if ($booking_bill['part_pay_1_status'] == 1 && $booking_bill['part_pay_2_status'] == 0 && $booking_bill['part_pay_3_status'] == 0) {
                    $perecent_fill = 40;
                    $booking_paid_amt = $booking_bill['part_pay_1'];
                } elseif ($booking_bill['part_pay_1_status'] == 1 && $booking_bill['part_pay_2_status'] == 1 && $booking_bill['part_pay_3_status'] == 0) {
                    $perecent_fill = 70;
                    $booking_paid_amt = $booking_bill['part_pay_1'] + $booking_bill['part_pay_2'];
                } elseif ($booking_bill['part_pay_1_status'] == 1 && $booking_bill['part_pay_2_status'] == 1 && $booking_bill['part_pay_3_status'] == 1) {
                    $perecent_fill = 100;
                    $booking_paid_amt = $booking_bill['part_pay_1'] + $booking_bill['part_pay_2'] + $booking_bill['part_pay_3'];
                }
            } else if($pay_type==1) {
                $perecent_fill = 100;
                $booking_paid_amt = $booking_bill['amount'];
            }
            $booking_full_amt = $final_price;
        }

        // Status
        $status = ($booking['confirm_status'] == 0)
            ? "Pending"
            : (($booking['confirm_status'] == 1 && $today >= $startDate && $today <= $endDate)
                ? "In Transit"
                : "Confirmed");
        
        $result[] = [
            "id"            => $booking['id'],
            "booking_id"      => $booking['order_id'],
            "date"          => $booking['date'],
            "package_name"  => $booking['package_name'],
            "customer"      => [
                "id"    => $booking['customer_id'],
                "name"  => $booking['c_name'],
                "phone" => $booking['phone'],
                "email" => $booking['email']
            ],
            "travel_agency" => $ta_details,
            "payment" => [
                "percent_fill" => $perecent_fill,
                "paid_amount" => $booking_paid_amt,
                "full_amount" => $booking_full_amt
            ],
            "status"        => $status
        ];
    }
    echo json_encode(["status" => "success", "bookings" => $result]);
} catch (PDOException $e) {
    echo json_encode(["status" => "error", "message" => "Database error: " . $e->getMessage()]);
}