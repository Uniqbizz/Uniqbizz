<?php
header("Content-Type: application/json");
require '../../../../connect.php';

$response = [];

try {
    $data = json_decode(file_get_contents("php://input"), true);

    $userId = isset($data['userId']) ? $data['userId'] : '';
    $month  = isset($data['month']) ? (int)$data['month'] : null; // force int
    $year   = isset($data['year']) ? (int)$data['year'] : null;

    $tdsPer = 0.02; // 2%

    if (!$userId) {
        echo json_encode(["status" => false, "message" => "User ID is required"]);
        exit;
    }

    // Build dynamic WHERE clause
    $where = "customer_id = ? AND status = '1'";
    $params = [$userId];

    if ($month !== null && $year !== null) {
        $where .= " AND MONTH(created_date) = ? AND YEAR(created_date) = ?";
        $params[] = $month;
        $params[] = $year;
        // changes as per month & year if exist
        $stmt = $conn->prepare("
        SELECT SUM(referral_amount) AS payout 
        FROM customer_reference_payout 
        WHERE $where ");
    } else {
        $stmt = $conn->prepare("
        SELECT SUM(referral_amount) AS payout 
        FROM customer_reference_payout 
        WHERE customer_id = ? AND status = '1'");
    }

    $stmt->execute($params);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    $totalPayout = floatval($row['payout'] ?? 0);
    $tds = $totalPayout * $tdsPer;
    $netPayable = $totalPayout - $tds;

    // Fetch records with dynamic conditions
    $stmt = $conn->prepare("
        SELECT 
            id, 
            customer_id AS userId, 
            referral_message AS message1, 
            booking_message AS message2, 
            referral_amount AS comm_amt1, 
            booking_points AS comm_amt2, 
            created_date, 
            status, 
            message_details 
        FROM customer_reference_payout 
        WHERE $where 
        ORDER BY created_date DESC
    ");
    $stmt->execute($params);

    $records = [];
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $dt = (new DateTime($row['created_date']))->format('Y-m-d');

        // Messages
        $message1 = $row['message1'] ?: $row['message2'];
        $message1 = str_replace('.', "\n", $message1);
        $message2 = $row['message_details'] ?? 'NA';
        $message2 = str_replace('.', "\n", $message2);

        // Commission logic
        if (!$row['comm_amt1']) {
            $commission = floatval($row['comm_amt2']);
            $tdsValue = null;
            $total = $commission;
        } else {
            $commission = floatval($row['comm_amt1']);
            $tdsValue = $commission * $tdsPer;
            $total = $commission - $tdsValue;
        }

        $records[] = [
            "date"           => $dt,
            "message" => $message1,
            "payout_details" => $message2,
            "amount"         => round($commission, 2),
            "tds"            => isset($tdsValue) ? round($tdsValue, 2) : "NA",
            "total_payable"  => round($total, 2),
            "status"         => ($row['status'] == '1' || $row['status'] == '3') ? "Paid" : "Pending",
            "download_link"  => ($row['status'] != '3')
                ? "payout/forms/customer_reference/download_cu_payout.php?vkvbvjfgfikix={$row['id']}&userId={$row['userId']}&date={$dt}&message=" . urlencode($message1) . "&message_status={$row['status']}&commission={$commission}"
                : null
        ];
    }

    // Final JSON response
    $response = [
        "status"       => true,
        "user"         => ["userId" => $userId],
        "total_payout" => round($totalPayout, 2),
        "tds"          => round($tds, 2),
        "net_payable"  => round($netPayable, 2),
        "date"         => ($month && $year) ? $month . ' ' . $year : null,
        "records"      => $records
    ];
} catch (Exception $e) {
    $response = [
        "status"  => false,
        "message" => "Server error: " . $e->getMessage()
    ];
}

echo json_encode($response);
