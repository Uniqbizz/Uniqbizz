<?php
require '../../../../connect.php';
date_default_timezone_set("Asia/Kolkata");

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(["status" => "error", "message" => "Invalid request method"]);
    exit;
}
 
// Get and decode JSON input
$getdata = file_get_contents("php://input");
$data = json_decode($getdata, true);

$userId = isset($data['userId']) ? $data['userId'] : '';
$userType = 11;
$columnDesignation = 'travel_consultant';
$columnMessage = 'message_tc';
$columnCommision = 'commision_tc';
$columnStatus = 'status_tc';
$nextDateMonth = isset($data['nextDateMonth']) ? $data['nextDateMonth'] : '';
$nextDateYear = isset($data['nextDateYear']) ? $data['nextDateYear'] : '';

// TDS percentage (adjust as needed)
$tdsPercentage = 0.02;

$response = [];

// // ✅ Calculate total next payout (same as your modal top card)
    $sumSql = "SELECT SUM($columnCommision) as nextPayout FROM ca_cu_payout WHERE $columnDesignation = :userId AND YEAR(created_date) = :year AND MONTH(created_date) = :month";

    $sumStmt = $conn->prepare($sumSql);
    $sumStmt->bindParam(':userId', $userId);
    $sumStmt->bindParam(':year', $nextDateYear);
    $sumStmt->bindParam(':month', $nextDateMonth);
    $sumStmt->execute();

    $nextPayout = 0;
    $nextPayoutTDS = 0;
    $TotalnextPayout = 0;

    if ($sumStmt->rowCount() > 0) {
        $row = $sumStmt->fetch(PDO::FETCH_ASSOC);
        $nextPayout = floatval($row['nextPayout']);
        $nextPayoutTDS = $nextPayout * $tdsPercentage;
        $TotalnextPayout = $nextPayout - $nextPayoutTDS;
    }

// Query payouts for given month/year
$sql = "SELECT * FROM `ca_cu_payout` 
        WHERE $columnDesignation = :userId 
        AND YEAR(created_date) = :year 
        AND MONTH(created_date) = :month 
        ORDER BY id DESC";

$stmt = $conn->prepare($sql);
$stmt->bindParam(':userId', $userId);
$stmt->bindParam(':year', $nextDateYear);
$stmt->bindParam(':month', $nextDateMonth);
$stmt->execute();

if ($stmt->rowCount() > 0) {
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $payouts = [];

    foreach ($rows as $row) {
        // Date formatting
            $dt = (new DateTime($row['created_date']))->format('Y-m-d');

            // Replace dot with line break
            $message1 = str_replace('Rs.', 'Rs ', $row[$columnMessage]);
            $message2 = str_replace('.', '<br>', $message1);

            // Calculate amounts
            $CommAmt = floatval($row[$columnCommision]);
            $tds = $CommAmt * $tdsPercentage;
            $totalAmt = $CommAmt - $tds;

            $status = ($row[$columnStatus] == '1') ? "Paid" : "Pending";

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

    $response = [
            'success' => true,
            'totalnextPayout' => $TotalnextPayout,
            'nextDateMonth' => $nextDateMonth,
            'nextDateYear' => $nextDateYear,
            'total_records' => count($payouts),
            'data' => $payouts
        ];
} else {
     $response = ["success" => true, "message" => "No payouts found"];
}

echo json_encode($response);
?>
