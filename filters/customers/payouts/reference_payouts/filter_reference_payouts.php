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

$request = json_decode(file_get_contents("php://input"), true);

// ✅ Inputs
$userId   = $request['id'] ?? '';
$search   = trim($request['search'] ?? '');
$fromDate = $request['fromDate'] ?? '';
$toDate   = $request['toDate'] ?? '';

$tdsPer = 0.02;

if (!$userId) {
    echo json_encode(["status" => false, "message" => "Missing id"]);
    exit;
}

try {

    // ✅ Base WHERE
    $where = "customer_id = :userId AND status IN ('1', '2')";
    $params = ['userId' => $userId];

    // ✅ Date filter (all cases)
    if (!empty($fromDate) && !empty($toDate)) {
        $where .= " AND DATE(created_date) BETWEEN :fromDate AND :toDate";
        $params['fromDate'] = $fromDate;
        $params['toDate'] = $toDate;
    } elseif (!empty($fromDate)) {
        $where .= " AND DATE(created_date) >= :fromDate";
        $params['fromDate'] = $fromDate;
    } elseif (!empty($toDate)) {
        $where .= " AND DATE(created_date) <= :toDate";
        $params['toDate'] = $toDate;
    }

    // ✅ Fetch records
    $stmt = $conn->prepare("
        SELECT id, customer_id as userId, referral_message as message1, booking_message as message2, 
               referral_amount as comm_amt1, booking_points as comm_amt2, created_date, status 
        FROM customer_reference_payout 
        WHERE $where
        ORDER BY created_date DESC
    ");
    $stmt->execute($params);

    $rows = [];
    $totalPayout = 0;

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

        $cleanMessage = strip_tags($message);

        // ✅ GLOBAL SEARCH
        if (!empty($search)) {
            $searchLower = strtolower($search);

            $searchableString = strtolower(
                $date . ' ' .
                $cleanMessage . ' ' .
                $commission . ' ' .
                $tds . ' ' .
                $total . ' ' .
                $statusText
            );

            if (strpos($searchableString, $searchLower) === false) {
                continue;
            }
        }

        // ✅ accumulate ONLY filtered data
        $totalPayout += $commission;

        $rows[] = [
            'date' => $date,
            'message' => $cleanMessage,
            'amount' => $commission,
            'tds' => $tds !== null ? round($tds, 2) : null,
            'total_payable' => round($total, 2),
            'status' => $statusText
        ];
    }

    // ✅ No data after filtering
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

    // ✅ totals AFTER filtering
    $tdsAmount = $totalPayout * $tdsPer;
    $netPayout = truncateToTwoDecimals($totalPayout - $tdsAmount);

    $response = [
        'status' => 'success',
        'data' => [
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