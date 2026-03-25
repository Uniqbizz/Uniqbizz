<?php
require '../../../../connect.php';
header('Content-Type: application/json');
date_default_timezone_set("Asia/Kolkata");

$response = [];

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(["status" => "error", "message" => "Invalid request method"]);
    exit;
}
 
$getdata = stripslashes(file_get_contents("php://input"));
$data = json_decode($getdata, true);
$userType = 11;
$columnDesignation = 'travel_consultant';
$columnMessage = 'message_tc';
$columnCommision = 'commision_tc';
$columnStatus = 'status_tc';
$userId = isset($data['userId']) ? $data['userId'] : '';
$prevDateMonth = isset($data['prevDateMonth']) ? $data['prevDateMonth'] : '';
$prevDateYear = isset($data['prevDateYear']) ? $data['prevDateYear'] : '';

$tdsPercentage = 0.02;

if ($columnDesignation == '' || $userId == '' || $prevDateMonth == '' || $prevDateYear == '') {
    echo json_encode(["success" => false, "message" => "Missing parameters"]);
    exit;
}

try {
    // // ✅ Calculate total previous payout (same as your modal top card)
    $sumSql = "SELECT SUM($columnCommision) as previousPayout FROM ca_cu_payout WHERE $columnDesignation = :userId AND YEAR(created_date) = :year AND MONTH(created_date) = :month";

    $sumStmt = $conn->prepare($sumSql);
    $sumStmt->bindParam(':userId', $userId);
    $sumStmt->bindParam(':year', $prevDateYear);
    $sumStmt->bindParam(':month', $prevDateMonth);
    $sumStmt->execute();

    $previousPayout = 0;
    $previousPayoutTDS = 0;
    $TotalpreviousPayout = 0;

    if ($sumStmt->rowCount() > 0) {
        $row = $sumStmt->fetch(PDO::FETCH_ASSOC);
        $previousPayout = floatval($row['previousPayout']);
        $previousPayoutTDS = $previousPayout * $tdsPercentage;
        $TotalpreviousPayout = $previousPayout - $previousPayoutTDS;
    }

    // ✅ Fetch detailed payout records
    $sql = "SELECT * FROM `ca_cu_payout` WHERE $columnDesignation = :userId AND YEAR(created_date) = :year AND MONTH(created_date) = :month ORDER BY id DESC";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':userId', $userId);
    $stmt->bindParam(':year', $prevDateYear);
    $stmt->bindParam(':month', $prevDateMonth);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $payouts = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
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
            'totalpreviousPayout' => $TotalpreviousPayout,
            'prevDateMonth' => $prevDateMonth,
            'prevDateYear' => $prevDateYear,
            'total_records' => count($payouts),
            'data' => $payouts
        ];
    } else {
        $response = ["success" => true, "message" => "No previous payouts found"];
    }
} catch (Exception $e) {
    $response = ["success" => false, "error" => $e->getMessage()];
}

echo json_encode($response);
?>
