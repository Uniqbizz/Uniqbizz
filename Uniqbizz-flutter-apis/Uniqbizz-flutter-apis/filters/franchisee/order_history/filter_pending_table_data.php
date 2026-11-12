<?php
require '../../../connect.php';
header('Content-Type: application/json');

try {

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        echo json_encode(["status" => "error", "message" => "POST method required"]);
        exit;
    }

    $input = json_decode(file_get_contents("php://input"), true);

    if (!is_array($input)) {
        echo json_encode([
            'status' => false,
            'message' => 'Invalid JSON body'
        ]);
        exit;
    }

    $userId   = $input['id'] ?? null;
    $search   = trim($input['search'] ?? '');
    $fromDate = $input['fromDate'] ?? null;
    $toDate   = $input['toDate'] ?? null;

    if (!$userId) {
        echo json_encode(["status" => "error", "message" => "Missing id"]);
        exit;
    }

     // Fix date format
    if ($fromDate) {
        $fromDate = date('Y-m-d 00:00:00', strtotime($fromDate));
    }

    if ($toDate) {
        $toDate = date('Y-m-d 23:59:59', strtotime($toDate));
    }

    // 1️⃣ Validate Franchise
    $check = $conn->prepare("SELECT 1 FROM ca_travelagency WHERE reference_no = :id LIMIT 1");
    $check->execute([':id' => $userId]);

    if (!$check->fetchColumn()) {
        echo json_encode(["status" => "error", "message" => "Invalid Franchise ID"]);
        exit;
    }

    // 2️⃣ Get Travel Agencies under Franchise (UserType 29 logic)
    $stmtTA = $conn->prepare("
        SELECT ca_travelagency_id, firstname, lastname, email, contact_no
        FROM ca_travelagency
        WHERE status = 1 AND reference_no = :id
    ");
    $stmtTA->execute([':id' => $userId]);
    $ta_list = $stmtTA->fetchAll(PDO::FETCH_ASSOC);

    if (empty($ta_list)) {
        echo json_encode([
            "status" => "success",
            "count" => 0,
            "bookings" => [],
            "message" => "No Travel Agencies Found"
        ]);
        exit;
    }

    $ta_ids = array_column($ta_list, 'ca_travelagency_id');
    $ta_ids_str = "'" . implode("','", $ta_ids) . "'";

    // 3️⃣ Build Pending Booking Query
    $sql = "
        SELECT 
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
            b.confirm_status
        FROM bookings b
        JOIN package p ON b.package_id = p.id
        WHERE b.ta_id IN ($ta_ids_str)
        AND b.status NOT IN ('2','3')
        AND b.confirm_status = 0
    ";

    // DATE FILTER
    if (!empty($fromDate)) {
        $sql .= " AND b.date >= :fromDate";
    }

    if (!empty($toDate)) {
        $sql .= " AND b.date <= :toDate";
    }

    // 🔍 Search filter
    if (!empty($search)) {
        $sql .= " AND (
            LOWER(b.id) LIKE :search
            OR LOWER(b.order_id) LIKE :search
            OR LOWER(p.name) LIKE :search
            OR LOWER(b.customer_id) LIKE :search
            OR LOWER(b.name) LIKE :search
            OR LOWER(b.phone) LIKE :search
            OR LOWER(b.email) LIKE :search
        )";
    }

    $sql .= " ORDER BY b.date DESC";

    $stmt = $conn->prepare($sql);

    if (!empty($fromDate)) {
        $stmt->bindValue(':fromDate', $fromDate);
    }

    if (!empty($toDate)) {
        $stmt->bindValue(':toDate', $toDate);
    }

    if (!empty($search)) {
        $searchParam = '%' . strtolower($search) . '%';
        $stmt->bindParam(':search', $searchParam);
    }

    $stmt->execute();
    $bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (empty($bookings)) {

        $hasDateFilter = (!empty($fromDate) || !empty($toDate));
        $hasSearch     = (!empty($search));

        if ($hasSearch) {
            echo json_encode([
                "status" => "success",
                "count" => 0,
                "bookings" => [],
                "message" => "No matching results found for your search criteria"
            ]);
            exit;
        }

        if ($hasDateFilter) {
            echo json_encode([
                "status" => "success",
                "count" => 0,
                "bookings" => [],
                "message" => "No records found for the selected date range"
            ]);
            exit;
        }

        echo json_encode([
            "status" => "success",
            "count" => 0,
            "bookings" => [],
            "message" => "No Pending Bookings Found"
        ]);
        exit;
    }

    $result = [];

    foreach ($bookings as $booking) {

        // Fetch billing
        $stmt3 = $conn->prepare("SELECT * FROM booking_direct_bill WHERE bookings_id = ?");
        $stmt3->execute([$booking['id']]);
        $booking_bill = $stmt3->fetch(PDO::FETCH_ASSOC);

        $percent_fill = 0;
        $booking_paid_amt = 0;
        $booking_full_amt = 0;

        if ($booking_bill) {
            $pay_type = $booking_bill['pay_type'];
            $final_price = $booking_bill['final_price'];

            if ($pay_type == 2) {
                if ($booking_bill['part_pay_1_status'] == 1 && $booking_bill['part_pay_2_status'] == 1) {
                    $percent_fill = 100;
                    $booking_paid_amt = $booking_bill['part_pay_1'] + $booking_bill['part_pay_2'];
                } elseif ($booking_bill['part_pay_1_status'] == 1) {
                    $percent_fill = 50;
                    $booking_paid_amt = $booking_bill['part_pay_1'];
                }
            } elseif ($pay_type == 3) {
                $paidParts = 0;
                if ($booking_bill['part_pay_1_status'] == 1) $paidParts++;
                if ($booking_bill['part_pay_2_status'] == 1) $paidParts++;
                if ($booking_bill['part_pay_3_status'] == 1) $paidParts++;
                $percent_fill = ($paidParts / 3) * 100;
                $booking_paid_amt =
                    ($booking_bill['part_pay_1_status'] == 1 ? $booking_bill['part_pay_1'] : 0) +
                    ($booking_bill['part_pay_2_status'] == 1 ? $booking_bill['part_pay_2'] : 0) +
                    ($booking_bill['part_pay_3_status'] == 1 ? $booking_bill['part_pay_3'] : 0);
            } else {
                $percent_fill = 100;
                $booking_paid_amt = $booking_bill['amount'];
            }

            $booking_full_amt = $final_price;
        }

        // Find travel agency details
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
                "percent_fill" => $percent_fill,
                "paid_amount" => $booking_paid_amt,
                "full_amount" => $booking_full_amt
            ],
            "status" => "Pending"
        ];
    }

    echo json_encode([
        "status" => "success",
        "count" => count($result),
        "bookings" => $result,
        "message" => (!empty($search) || !empty($fromDate)) ? "Filtered results found" : "All pending bookings"
    ]);

} catch (Exception $e) {
    echo json_encode([
        "status" => "error",
        "message" => $e->getMessage()
    ]);
}