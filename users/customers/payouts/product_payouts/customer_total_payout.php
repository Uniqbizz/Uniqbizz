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
    $where = "userID = ? AND status = '1'";
    $params = [$userId];

    if ($month !== null && $year !== null) {
        $where .= " AND MONTH(created_date) = ? AND YEAR(created_date) = ?";
        $params[] = $month;
        $params[] = $year;

        $stmt = $conn->prepare("
        SELECT SUM(Commi_amt) AS payout 
        FROM product_payout_paid 
        WHERE $where
    ");
    } else {
        // Total payout
        $stmt = $conn->prepare("
        SELECT SUM(Commi_amt) AS payout 
        FROM product_payout_paid 
        WHERE userID = ? AND status = '1'
    ");
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
            userID,
            userName 
            message, 
            Commi_amt, 
            Commi_amt_tds, 
            Commi_amt_total, 
            created_date, 
            status
        FROM product_payout_paid 
        WHERE $where 
        ORDER BY created_date DESC
    ");
    $stmt->execute($params);

    $records = [];
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $dt = (new DateTime($row['created_date']))->format('Y-m-d');

        // Messages
        $message1 = $row['message'];
        $message1 = str_replace('.', "\n", $message1);

        // Commission logic

        $commission = floatval($row['Commi_amt']);
        $tdsValue = floatval($row['Commi_amt_tds']);
        $total = floatval($row['Commi_amt_total']);

        $records[] = [
            "date"           => $dt,
            "message" => $message1,
            "amount"         => round($commission, 2),
            "tds"            => round($tdsValue, 2),
            "total_payable"  => round($total, 2),
            "status"         => ($row['status'] == '1' || $row['status'] == '3') ? "Paid" : "Pending",
            "download_link"  => ($row['status'] != '3')
                ? "payout/forms/customer_reference/download_cu_payout.php?vkvbvjfgfikix={$row['id']}&userId={$row['userID']}&date={$dt}&message=" . urlencode($message1) . "status={$row['status']}&commission={$commission}"
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
