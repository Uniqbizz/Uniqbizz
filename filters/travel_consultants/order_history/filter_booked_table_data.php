<?php
require '../../../connect.php';
header('Content-Type: application/json');

try {
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
    $fromDate = $input['fromDate'] ?? '';
    $toDate = $input['toDate'] ?? '';

    $customer_fil = "";
    $booking_filter = "";

    // ONLY userType 11 logic
    $sql0 = "SELECT ca.ca_travelagency_id, ca.firstname, ca.lastname, ca.email, ca.contact_no
             FROM ca_travelagency ca
             WHERE ca.status = 1 AND ca.ca_travelagency_id = '$userId'
             GROUP BY ca.ca_travelagency_id, ca.firstname, ca.lastname, ca.email, ca.contact_no";

    $stmt0 = $conn->prepare($sql0);
    $stmt0->execute();
    $ta_list = $stmt0->fetchAll(PDO::FETCH_ASSOC);

    // ✅ No TA found
    if (empty($ta_list)) {
        echo json_encode([
            "status" => "success",
            "message" => "No Travel Agencies Found",
            "bookings" => []
        ]);
        exit;
    }

    $ta_ids = array_column($ta_list, 'ca_travelagency_id');
    $ta_ids_str = "'" . implode("','", $ta_ids) . "'";

    // Date filter
    if (!empty($fromDate) && !empty($toDate)) {
        $booking_filter = " AND DATE(b.date) BETWEEN '$fromDate' AND '$toDate'";
    }

    // Search filter
    $search_filter = "";
    if (!empty($search)) {
        $search_filter = " AND (
            b.order_id LIKE '%$search%' OR
            b.name LIKE '%$search%' OR
            b.email LIKE '%$search%' OR
            b.phone LIKE '%$search%' OR
            p.name LIKE '%$search%'
        )";
    }

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
              AND b.status='1'
              $booking_filter
              $search_filter
              $customer_fil
            GROUP BY b.id, b.order_id, b.customer_id, b.package_id, p.name, p.tour_days, 
                     b.name, b.phone, b.email, b.date, b.ta_id, b.status, b.confirm_status,
                     bd.pay_type, bd.part_pay_1, bd.part_pay_2, bd.part_pay_3,
                     bd.part_pay_1_status, bd.part_pay_2_status, bd.part_pay_3_status,
                     bd.final_price, bd.amount
            ORDER BY b.date";

    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // ✅ No bookings fetched from DB
    if (empty($bookings)) {
        echo json_encode([
            "status" => "success",
            "message" => "No Bookings Found",
            "bookings" => []
        ]);
        exit;
    }

    $result = [];

    foreach ($bookings as $booking) {

        // --- SAME LOGIC (UNCHANGED) ---
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

    // ✅ FINAL EMPTY CHECK (important because of continues)
    if (empty($result)) {
        echo json_encode([
            "status" => "success",
            "message" => "No Bookings Found After Applying Conditions",
            "bookings" => []
        ]);
        exit;
    }

    echo json_encode([
        "status" => "success",
        "bookings" => $result
    ]);

} catch (PDOException $e) {
    echo json_encode([
        "status" => "error",
        "message" => "Database error: " . $e->getMessage()
    ]);
}