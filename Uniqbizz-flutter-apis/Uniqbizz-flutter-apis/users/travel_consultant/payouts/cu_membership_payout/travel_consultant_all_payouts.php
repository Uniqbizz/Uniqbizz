<?php
require '../../../../connect.php';
header('Content-Type: application/json');
date_default_timezone_set("Asia/Kolkata");

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(["status" => "error", "message" => "Invalid request method"]);
    exit;
}
 

$response = [];

$getdata = stripslashes(file_get_contents("php://input"));
$data = json_decode($getdata, true);

// $columnDesignation = isset($data['columnDesignation']) ? $data['columnDesignation'] : '';
$userId = isset($data['userId']) ? $data['userId'] : '';
$userType = 11;
$columnDesignation = 'travel_consultant';
$columnMessage = 'message_tc';
$columnCommision = 'commision_tc';
$columnStatus = 'status_tc';


$tdsPercentage = 0.02;

if ($userType == '' || $userId == '') {
    echo json_encode(["success" => false, "message" => "Missing parameters"]);
    exit;
}

try {
    $sql = "SELECT * FROM `ca_cu_payout` WHERE $columnDesignation = :userId ORDER BY id DESC";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':userId', $userId);
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
            "success" => true,
            "count" => count($payouts),
            "payouts" => $payouts
        ];
    } else {
        $response = ["success" => true, "message" => "No payouts found"];
    }
} catch (Exception $e) {
    $response = ["success" => false, "error" => $e->getMessage()];
}

echo json_encode($response);
?>
