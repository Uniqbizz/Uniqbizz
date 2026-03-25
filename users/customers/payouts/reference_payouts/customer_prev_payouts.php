<?php
require '../../../../connect.php'; // Adjust if your DB connection file path differs

header('Content-Type: application/json');

$data = json_decode(file_get_contents("php://input"), true);
$userId = isset($data['userId']) ? $data['userId'] : '';
$prevMonth = isset($data['month']) ? $data['month'] : '';
$prevYear = isset($data['year']) ? $data['year'] : '';

if (empty($userId) || empty($prevMonth) || empty($prevYear)) {
    echo json_encode([
        "status" => false,
        "message" => "Missing required parameters"
    ]);
    exit;
}

try {
    $tdsPer = 0.02; // Adjust if TDS % differs

    // Get monthly total payout
    $query = "SELECT SUM(referral_amount) as payout 
              FROM customer_reference_payout 
              WHERE customer_id = :userId 
              AND YEAR(created_date) = :year 
              AND MONTH(created_date) = :month";

    $stmt = $conn->prepare($query);
    $stmt->execute([
        'userId' => $userId,
        'year' => $prevYear,
        'month' => $prevMonth
    ]);

    $totalPayout = 0;
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($row && $row['payout']) {
        $totalPayout = $row['payout'];
    }

    if ($totalPayout > 0) {
        $tdsAmount = $totalPayout * $tdsPer;
        $netPayout = $totalPayout - $tdsAmount;
    } else {
        $tdsAmount = 0;
        $netPayout = 0;
    }

    // Get payout breakdown
    $sql = "SELECT id, customer_id as userId, referral_message as message1, booking_message as message2, 
                   referral_amount as comm_amt1, booking_points as comm_amt2, created_date, status 
            FROM customer_reference_payout 
            WHERE customer_id = :userId 
            AND YEAR(created_date) = :year 
            AND MONTH(created_date) = :month 
            ORDER BY created_date DESC";

    $stmt = $conn->prepare($sql);
    $stmt->execute([
        'userId' => $userId,
        'year' => $prevYear,
        'month' => $prevMonth
    ]);

    $data = [];

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $dt = (new DateTime($row['created_date']))->format('Y-m-d');
        $message = $row['message1'] ?: $row['message2'];
        $message = str_replace('.', '<br>', $message);

        if (!$row['comm_amt1']) {
            $CommAmt = $row['comm_amt2'];
            $tds = "NA";
            $totalAmt = $CommAmt;
        } else {
            $CommAmt = $row['comm_amt1'];
            $tds = $CommAmt * $tdsPer;
            $totalAmt = $CommAmt - $tds;
        }

        switch ($row['status']) {
            case '1':
                $statusText = 'Paid';
                break;
            case '3':
                $statusText = 'Credited';
                break;
            default:
                $statusText = 'Pending';
                break;
        }

        $data[] = [
            'date' => $dt,
            'message' => $message,
            'amount' => (float) $CommAmt,
            'tds' => $tds,
            'total_payable' => $totalAmt,
            'status' => $statusText
        ];
    }

    echo json_encode([
        "status" => true,
        "message" => "Previous payout data fetched",
        "summary" => [
            "month" => $prevMonth,
            "year" => $prevYear,
            "total_payout" => $totalPayout,
            "tds" => $tdsAmount,
            "net_payout" => $netPayout
        ],
        "data" => $data
    ]);
} catch (PDOException $e) {
    echo json_encode([
        "status" => false,
        "message" => "Database error: " . $e->getMessage()
    ]);
}
