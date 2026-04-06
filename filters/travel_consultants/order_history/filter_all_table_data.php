<?php
require '../../../connect.php';
header('Content-Type: application/json');

try {
    // Capture input
    $input = json_decode(file_get_contents("php://input"), true);
    if (!$input) {
        $input = $_POST;
    }

    if (!isset($input['id'])) {
        echo json_encode(["status" => "error", "message" => "id is required"]);
        exit;
    }

    // FORCE userType = 11
    $userId = $input['id'];
    $userType = '11';

    // Filters
    $search = isset($input['search']) ? trim($input['search']) : '';
    $fromDate = isset($input['fromDate']) ? $input['fromDate'] : '';
    $toDate = isset($input['toDate']) ? $input['toDate'] : '';

    $customer_fil = "";

    // SAME LOGIC (unchanged)
    $sql0 = "SELECT ca.ca_travelagency_id, ca.firstname, ca.lastname, ca.email, ca.contact_no
             FROM ca_travelagency ca
             WHERE ca.status = 1 AND ca.ca_travelagency_id = '$userId'
             GROUP BY ca.ca_travelagency_id, ca.firstname, ca.lastname, ca.email, ca.contact_no";

    $stmt0 = $conn->prepare($sql0);
    $stmt0->execute();
    $ta_list = $stmt0->fetchAll(PDO::FETCH_ASSOC);

    if (empty($ta_list)) {
    echo json_encode([
        "status" => "success",
        "message" => "No travel agency found",
        "total" => 0,
        "bookings" => []
    ], JSON_PRETTY_PRINT);
    exit;
    }

    $ta_ids = array_column($ta_list, 'ca_travelagency_id');
    $ta_ids_str = "'" . implode("','", $ta_ids) . "'";

    // 🔥 FILTER CONDITIONS
    $filter_sql = "";

    // Booking ID filter
    if (!empty($userId)) {
        $filter_sql .= " AND b.ta_id = '$userId'";
    }

    // Date filter
    if (!empty($fromDate) && !empty($toDate)) {
        $filter_sql .= " AND DATE(b.date) BETWEEN '$fromDate' AND '$toDate'";
    }

    // Search filter
    if (!empty($search)) {
        $filter_sql .= " AND (
            b.order_id LIKE '%$search%' OR
            b.name LIKE '%$search%' OR
            b.email LIKE '%$search%' OR
            b.phone LIKE '%$search%' OR
            p.name LIKE '%$search%'
        )";
    }

    // MAIN QUERY (only added $filter_sql)
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
              $filter_sql
            GROUP BY 
                b.id, b.order_id, b.customer_id, b.package_id, p.name, p.tour_days,
                b.name, b.phone, b.email, b.date, b.ta_id, b.status, b.confirm_status,
                bd.pay_type, bd.final_price, bd.amount, bd.part_pay_1, bd.part_pay_2,
                bd.part_pay_3, bd.part_pay_1_status, bd.part_pay_2_status, bd.part_pay_3_status
            ORDER BY b.date DESC";

    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // ✅ ADD THIS BLOCK
    if (empty($bookings)) {
        echo json_encode([
            "status" => "success",
            "message" => "No bookings found for given filters",
            "total" => 0,
            "bookings" => []
        ], JSON_PRETTY_PRINT);
        exit;
    }

    $result = [];

    foreach ($bookings as $booking) {

        // ---- PAYMENT LOGIC (UNCHANGED) ----
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

        // ---- STATUS LOGIC (UNCHANGED) ----
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

        // TA DETAILS
        $ta_details = null;
        foreach ($ta_list as $ta) {
            if ($ta['ca_travelagency_id'] == $booking['ta_id']) {
                $ta_details = $ta;
                break;
            }
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
            "status" => $booking_status,
        ];
    }

    echo json_encode([
        "status" => "success",
        "message" => "Bookings retrieved successfully",
        "total" => count($result),
        "bookings" => $result
    ], JSON_PRETTY_PRINT);

} catch (Exception $e) {
    echo json_encode([
        "status" => "error",
        "message" => $e->getMessage()
    ]);
}