<?php
require '../../../../connect.php';
header('Content-Type: application/json');
date_default_timezone_set("Asia/Kolkata");

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(["status" => "error", "message" => "Invalid request method"]);
    exit;
}

$data = json_decode(file_get_contents("php://input"), true);

// ✅ INPUT
$userId = $data['userId'] ?? '';
$search = trim($data['search'] ?? '');
$month  = isset($data['month']) ? (int)$data['month'] : null;
$year   = isset($data['year']) ? (int)$data['year'] : null;

// 🔥 FORCE userType = 11
$userType = 11;
$columnDesignation = 'travel_consultant';
$columnMessage = 'message_tc';
$columnCommision = 'commision_tc';
$columnStatus = 'status_tc';

$tdsPercentage = 0.02;

if ($userId == '') {
    echo json_encode(["success" => false, "message" => "Missing userId"]);
    exit;
}

try {

    // 🔹 BASE QUERY
    $sql = "SELECT * FROM `ca_cu_payout` WHERE $columnDesignation = :userId";

    $params = [':userId' => $userId];

    // 🔹 MONTH + YEAR FILTER
    if ($month && $year) {
        $sql .= " AND YEAR(created_date) = :year AND MONTH(created_date) = :month";
        $params[':year'] = $year;
        $params[':month'] = $month;
    }

    // 🔹 SEARCH SETUP
    $searchLower = strtolower(trim($search));
    $isNumeric = is_numeric($searchLower);

    // 🔹 TEXT SEARCH ONLY (SQL)
    if ($searchLower !== '' && !$isNumeric) {
        $sql .= " AND (
            LOWER($columnMessage) LIKE :search OR
            CASE 
                WHEN $columnStatus = '1' THEN 'paid'
                ELSE 'pending'
            END LIKE :search
        )";

        $params[':search'] = "%" . $searchLower . "%";
    }

    $sql .= " ORDER BY id DESC";

    $stmt = $conn->prepare($sql);
    $stmt->execute($params);

    $payouts = [];

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

        // ✅ DATE
        $dt = (new DateTime($row['created_date']))->format('Y-m-d');

        // ✅ MESSAGE
        $message1 = str_replace('Rs.', 'Rs ', $row[$columnMessage]);
        $message2 = str_replace('.', '<br>', $message1);

        // ✅ AMOUNT LOGIC (UNCHANGED)
        $CommAmt = floatval($row[$columnCommision]);
        $tds = $CommAmt * $tdsPercentage;
        $totalAmt = $CommAmt - $tds;

        $status = ($row[$columnStatus] == '1') ? "Paid" : "Pending";

        // 🔥 FINAL SEARCH (handles computed fields)
        if ($searchLower !== '') {

            $fullMessage = strtolower($message2);
            $statusLower = strtolower($status);

            $match = false;

            // TEXT
            if (
                strpos($fullMessage, $searchLower) !== false ||
                strpos($statusLower, $searchLower) !== false
            ) {
                $match = true;
            }

            // NUMERIC (tds, total, amount)
            if (!$match && $isNumeric) {
                $num = (float)$searchLower;

                if (
                    $CommAmt == $num ||
                    $tds == $num ||
                    $totalAmt == $num
                ) {
                    $match = true;
                }
            }

            if (!$match) continue;
        }

        $payouts[] = [
            "id" => $row['id'],
            "date" => $dt,
            "payout_details" => $message2,
            "amount" => number_format($CommAmt, 2),
            "tds" => number_format($tds, 2),
            "total_payable" => number_format($totalAmt, 2),
            "remark" => $status
        ];
    }

    echo json_encode([
        "success" => true,
        "count" => count($payouts),
        "payouts" => $payouts
    ]);

} catch (Exception $e) {
    echo json_encode([
        "success" => false,
        "error" => $e->getMessage()
    ]);
}