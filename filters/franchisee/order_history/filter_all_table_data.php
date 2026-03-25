<?php
require '../../../connect.php';
header('Content-Type: application/json');

try {

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        http_response_code(405);
        echo json_encode(['status' => false, 'message' => 'Method not allowed']);
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
        echo json_encode([
            "status" => false,
            "message" => "Missing user_id"
        ]);
        exit;
    }

    // Fix date format
    if ($fromDate) {
        $fromDate = date('Y-m-d 00:00:00', strtotime($fromDate));
    }

    if ($toDate) {
        $toDate = date('Y-m-d 23:59:59', strtotime($toDate));
    }


    $checkStmt = $conn->prepare("
        SELECT 1 
        FROM ca_travelagency 
        WHERE reference_no = :user_ref 
        LIMIT 1
    ");
    $checkStmt->bindValue(':user_ref', $userId, PDO::PARAM_STR);
    $checkStmt->execute();

    if (!$checkStmt->fetchColumn()) {
        echo json_encode([
            "status" => false,
            "message" => "franchisee id invalid"
        ]);
        exit;
    }

    // 2️⃣ Get Travel Agencies under this franchise
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
            "message" => "No travel agencies found under this franchise"
        ], JSON_PRETTY_PRINT);
        exit;
    }

    $ta_ids = array_column($ta_list, 'ca_travelagency_id');
    $ta_ids_str = "'" . implode("','", $ta_ids) . "'";

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
    ";

    // DATE FILTER
    if (!empty($fromDate)) {
        $sql .= " AND b.date >= :fromDate";
    }

    if (!empty($toDate)) {
        $sql .= " AND b.date <= :toDate";
    }

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

    $result = [];

    foreach ($bookings as $booking) {

        $percent_fill = 0;
        $booking_paid_amt = 0;
        $booking_full_amt = $booking['final_price'];

        if ($booking['pay_type'] == 2) {
            if ($booking['part_pay_1_status'] == 1 && $booking['part_pay_2_status'] == 0) {
                $percent_fill = 50;
                $booking_paid_amt = $booking['part_pay_1'];
            } elseif ($booking['part_pay_1_status'] == 1 && $booking['part_pay_2_status'] == 1) {
                $percent_fill = 100;
                $booking_paid_amt = $booking['part_pay_1'] + $booking['part_pay_2'];
            }
        } elseif ($booking['pay_type'] == 3) {
            if ($booking['part_pay_1_status'] == 1 && $booking['part_pay_2_status'] == 1 && $booking['part_pay_3_status'] == 1) {
                $percent_fill = 100;
                $booking_paid_amt = $booking['part_pay_1'] + $booking['part_pay_2'] + $booking['part_pay_3'];
            }
        } else {
            $percent_fill = 100;
            $booking_paid_amt = $booking['amount'];
        }

        $startDate = new DateTime($booking['date']);
        $tourDays = (int)$booking['tour_days'];
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
            "status" => $booking_status,
        ];
    }

    // 🔎 Proper response handling
    $hasDateFilter = (!empty($fromDate) || !empty($toDate));
    $hasSearch     = (!empty($search));

    if (count($result) === 0) {

        if ($hasSearch) {
            echo json_encode([
                "status" => "success",
                "count" => 0,
                "bookings" => [],
                "message" => "No matching results found for your search criteria"
            ], JSON_PRETTY_PRINT);
            exit;
        }

        if ($hasDateFilter) {
            echo json_encode([
                "status" => "success",
                "count" => 0,
                "bookings" => [],
                "message" => "No records found for the selected date range"
            ], JSON_PRETTY_PRINT);
            exit;
        }

        echo json_encode([
            "status" => "success",
            "count" => 0,
            "bookings" => [],
            "message" => "No records found"
        ], JSON_PRETTY_PRINT);
        exit;
    }

    echo json_encode([
        "status" => "success",
        "count" => count($result),
        "bookings" => $result,
        "message" => ($hasSearch || $hasDateFilter) ? "Filtered results found" : "All records"
    ], JSON_PRETTY_PRINT);

} catch (Exception $e) {
    echo json_encode([
        "status" => "error",
        "message" => $e->getMessage()
    ]);
}