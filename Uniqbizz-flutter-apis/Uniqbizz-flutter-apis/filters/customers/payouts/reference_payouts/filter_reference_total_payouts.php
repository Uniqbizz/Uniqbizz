<?php
header("Content-Type: application/json");
require '../../../../connect.php';

$response = [];

try {
    $data = json_decode(file_get_contents("php://input"), true);

    // ✅ Inputs (keep request same)
    $userId = $data['id'] ?? '';
    $search = trim($data['search'] ?? '');

    // ✅ Proper handling of empty month/year
    $month = (isset($data['month']) && $data['month'] !== '') ? (int)$data['month'] : null;
    $year  = (isset($data['year']) && $data['year'] !== '') ? (int)$data['year'] : null;

    $tdsPer = 0.02;

    if (!$userId) {
        echo json_encode(["status" => false, "message" => "User ID is required"]);
        exit;
    }

    // ✅ WHERE clause
    $where = "customer_id = ? AND status IN ('1', '2')";
    $params = [$userId];

    if ($month !== null && $year !== null) {
        $where .= " AND MONTH(created_date) = ? AND YEAR(created_date) = ?";
        $params[] = $month;
        $params[] = $year;
    }

    // ✅ Fetch records
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
    $totalPayout = 0;

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

        $dt = (new DateTime($row['created_date']))->format('Y-m-d');

        $message1 = $row['message1'] ?: $row['message2'];
        $message1 = str_replace('.', "\n", $message1);

        $message2 = $row['message_details'] ?? 'NA';
        $message2 = str_replace('.', "\n", $message2);

        // Commission logic (UNCHANGED)
        if (!$row['comm_amt1']) {
            $commission = floatval($row['comm_amt2']);
            $tdsValue = null;
            $total = $commission;
        } else {
            $commission = floatval($row['comm_amt1']);
            $tdsValue = $commission * $tdsPer;
            $total = $commission - $tdsValue;
        }

        $statusText = ($row['status'] == '1' || $row['status'] == '3') ? "Paid" : "Pending";

        // ✅ GLOBAL SEARCH
        if (!empty($search)) {
            $searchLower = strtolower($search);

            $searchableString = strtolower(
                $dt . ' ' .
                $message1 . ' ' .
                $message2 . ' ' .
                $commission . ' ' .
                $tdsValue . ' ' .
                $total . ' ' .
                $statusText
            );

            if (strpos($searchableString, $searchLower) === false) {
                continue;
            }
        }

        // ✅ accumulate filtered totals
        $totalPayout += $commission;

        $records[] = [
            "date"           => $dt,
            "message"        => $message1,
            "payout_details" => $message2,
            "amount"         => round($commission, 2),
            "tds"            => isset($tdsValue) ? round($tdsValue, 2) : "NA",
            "total_payable"  => round($total, 2),
            "status"         => $statusText
        ];
    }

    // ✅ No data case
    if (empty($records)) {
        echo json_encode([
            "status" => true,
            "message" => "No data found",
            "user" => ["userId" => $userId],
            "total_payout" => 0,
            "tds" => 0,
            "net_payable" => 0,
            "date" => ($month !== null && $year !== null) ? $month . ' ' . $year : null,
            "records" => []
        ]);
        exit;
    }

    // ✅ totals AFTER filtering
    $tds = $totalPayout * $tdsPer;
    $netPayable = $totalPayout - $tds;

    $response = [
        "status"       => true,
        "user"         => ["userId" => $userId],
        "total_payout" => round($totalPayout, 2),
        "tds"          => round($tds, 2),
        "net_payable"  => round($netPayable, 2),
        "date"         => ($month !== null && $year !== null) ? $month . ' ' . $year : null,
        "records"      => $records
    ];

} catch (Exception $e) {
    $response = [
        "status"  => false,
        "message" => "Server error: " . $e->getMessage()
    ];
}

echo json_encode($response);