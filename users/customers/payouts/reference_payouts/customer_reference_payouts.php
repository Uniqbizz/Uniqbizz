<?php
header('Content-Type: application/json');
require '../../../../connect.php';

function truncateToTwoDecimals($number)
{
    return floor($number * 100) / 100;
}

$response = [
    'status' => 'error',
    'message' => 'Invalid request',
    'data' => []
];

$data = json_decode(file_get_contents("php://input"), true);

$userId = $data['userId'] ?? '';
$month  = isset($data['month']) && $data['month'] !== '' ? (int)$data['month'] : null;
$year   = isset($data['year']) && $data['year'] !== '' ? (int)$data['year'] : null;

$tdsPer = 0.02;

if (!$userId) {
    echo json_encode(["status" => false, "message" => "Missing userId"]);
    exit;
}

try {

    // ✅ Base WHERE
    $where = "customer_id = :userId";
    $params = ['userId' => $userId];

    // ✅ Apply month/year ONLY if both exist
    if ($month !== null && $year !== null) {
        $where .= " AND YEAR(created_date) = :year AND MONTH(created_date) = :month";
        $params['year'] = $year;
        $params['month'] = $month;
    }

    // ✅ Total payout
    $stmt = $conn->prepare("
        SELECT SUM(referral_amount) as payout 
        FROM customer_reference_payout 
        WHERE $where
    ");
    $stmt->execute($params);

    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $totalPayout = $result['payout'] ?? 0;

    $tdsAmount = $totalPayout * $tdsPer;
    $netPayout = truncateToTwoDecimals($totalPayout - $tdsAmount);

    // ✅ Records
    $stmt = $conn->prepare("
        SELECT id, customer_id as userId, referral_message as message1, booking_message as message2, 
               referral_amount as comm_amt1, booking_points as comm_amt2, created_date, status 
        FROM customer_reference_payout 
        WHERE $where
        ORDER BY created_date DESC
    ");
    $stmt->execute($params);

    $rows = [];

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

        $date = (new DateTime($row['created_date']))->format('Y-m-d');

        $message = $row['message1'] ?: $row['message2'];
        $message = str_replace('.', '<br>', $message);

        if (!$row['comm_amt1']) {
            $commission = $row['comm_amt2'];
            $tds = null;
            $total = $commission;
        } else {
            $commission = $row['comm_amt1'];
            $tds = $commission * $tdsPer;
            $total = $commission - $tds;
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
        }

        $rows[] = [
            'date' => $date,
            'message' => strip_tags($message),
            'amount' => $commission,
            'tds' => $tds !== null ? round($tds, 2) : null,
            'total_payable' => round($total, 2),
            'status' => $statusText
        ];
    }

    // ✅ No data case
    if (empty($rows)) {
        echo json_encode([
            'status' => 'success',
            'message' => 'No data found',
            'data' => [
                'total_payout' => 0,
                'tds' => 0,
                'net_payout' => 0,
                'records' => []
            ]
        ]);
        exit;
    }

    $response = [
        'status' => 'success',
        'data' => [
            'month' => $month,
            'year' => $year,
            'total_payout' => round($totalPayout, 2),
            'tds' => round($tdsAmount, 2),
            'net_payout' => round($netPayout, 2),
            'records' => $rows
        ]
    ];

} catch (PDOException $e) {
    $response = [
        'status' => 'error',
        'message' => 'Database error: ' . $e->getMessage()
    ];
}

echo json_encode($response);