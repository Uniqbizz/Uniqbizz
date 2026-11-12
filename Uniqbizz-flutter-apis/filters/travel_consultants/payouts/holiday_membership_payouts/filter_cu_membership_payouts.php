<?php
require '../../../../connect.php';
header('Content-Type: application/json');
date_default_timezone_set("Asia/Kolkata");

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(["success" => false, "message" => "Invalid request method"]);
    exit;
}

// Input
$data = json_decode(file_get_contents("php://input"), true);

$userId = $data['userId'] ?? '';
$month  = $data['month'] ?? '';
$year   = $data['year'] ?? '';
$search = trim($data['search'] ?? '');

if (empty($userId) || empty($month) || empty($year)) {
    echo json_encode(["success" => false, "message" => "Missing parameters"]);
    exit;
}

// Columns
$columnDesignation = 'travel_consultant';
$columnMessage     = 'message_tc';
$columnCommision   = 'commision_tc';
$columnStatus      = 'status_tc';

$tdsPercentage = 0.02;

// 🔥 Search setup
$searchLower = strtolower(trim($search));
$isNumeric = is_numeric($searchLower);

try {

    // ✅ TOTAL (unchanged)
    $sumSql = "SELECT SUM($columnCommision) as totalPayout 
               FROM ca_cu_payout 
               WHERE $columnDesignation = :userId 
               AND YEAR(created_date) = :year 
               AND MONTH(created_date) = :month";

    $sumStmt = $conn->prepare($sumSql);
    $sumStmt->bindParam(':userId', $userId);
    $sumStmt->bindParam(':year', $year);
    $sumStmt->bindParam(':month', $month);
    $sumStmt->execute();

    $totalPayout = 0;
    $tdsTotal = 0;
    $netPayout = 0;

    if ($row = $sumStmt->fetch(PDO::FETCH_ASSOC)) {
        $totalPayout = floatval($row['totalPayout']);
        $tdsTotal = $totalPayout * $tdsPercentage;
        $netPayout = $totalPayout - $tdsTotal;
    }

    // ✅ BASE QUERY
    $sql = "SELECT * FROM ca_cu_payout 
            WHERE $columnDesignation = :userId 
            AND YEAR(created_date) = :year 
            AND MONTH(created_date) = :month";

    // 🔹 TEXT SEARCH (SQL only for text)
    if ($searchLower !== '' && !$isNumeric) {
        $sql .= " AND (
            LOWER($columnMessage) LIKE :search OR
            CASE 
                WHEN $columnStatus = '1' THEN 'paid'
                ELSE 'pending'
            END LIKE :search
        )";
    }

    $sql .= " ORDER BY id DESC";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':userId', $userId);
    $stmt->bindParam(':year', $year);
    $stmt->bindParam(':month', $month);

    if ($searchLower !== '' && !$isNumeric) {
        $searchParam = "%" . $searchLower . "%";
        $stmt->bindParam(':search', $searchParam);
    }

    $stmt->execute();

    $payouts = [];

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

        $dt = (new DateTime($row['created_date']))->format('Y-m-d');

        // Message
        $message1 = str_replace('Rs.', 'Rs ', $row[$columnMessage]);
        $message2 = str_replace('.', '<br>', $message1);

        $CommAmt = floatval($row[$columnCommision]);
        $tds = $CommAmt * $tdsPercentage;
        $totalAmt = $CommAmt - $tds;

        $status = ($row[$columnStatus] == '1') ? "Paid" : "Pending";

        // 🔥 FINAL SEARCH (handles numeric + computed)
        if ($searchLower !== '') {

            $fullMessage = strtolower($message2);
            $statusLower = strtolower($status);

            $match = false;

            // TEXT MATCH
            if (
                strpos($fullMessage, $searchLower) !== false ||
                strpos($statusLower, $searchLower) !== false
            ) {
                $match = true;
            }

            // NUMERIC MATCH (tds, amount, total)
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
        "month" => $month,
        "year" => $year,
        "total_payout" => number_format($totalPayout, 2),
        "total_tds" => number_format($tdsTotal, 2),
        "net_payout" => number_format($netPayout, 2),
        "total_records" => count($payouts),
        "data" => $payouts
    ]);

} catch (Exception $e) {
    echo json_encode([
        "success" => false,
        "message" => $e->getMessage()
    ]);
}