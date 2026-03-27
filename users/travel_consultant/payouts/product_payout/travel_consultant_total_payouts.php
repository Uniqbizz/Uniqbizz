<?php
require '../../../../connect.php';

header('Content-Type: application/json');

$request = json_decode(file_get_contents('php://input'), true);

$userId = $request['userId'] ?? null;
$userType = $request['userType'] ?? null;
$month = isset($request['month']) ? (int)$request['month'] : null;
$year = isset($request['year']) ? (int)$request['year'] : null;

$tdsPercentage = 2 / 100;
$isAllTime = empty($month) && empty($year);

$response = [
    'status' => 'error',
    'message' => '',
    'month' => $month,
    'year' => $year,
    'data' => []
];

function truncateToTwoDecimals($num)
{
    return floor($num * 100) / 100;
}

try {
    if (!$userId || !$userType) {
        throw new Exception("Missing userId or userType");
    }

    $typeMap = [
        '11' => ['col' => 'ta', 'calc' => 'ta_markup + ta_amt'],
        '16' => ['col' => 'te', 'calc' => 'te_amt'],
        '29' => ['col' => 'te', 'calc' => 'te_amt'],
        '10' => ['col' => 'cu', 'calc' => ''], // handled separately
        '26' => ['col' => 'bm', 'calc' => 'bm_amt'],
        '28' => ['col' => 'bm', 'calc' => 'bm_amt'],
        '30' => ['col' => 'bm', 'calc' => 'bm_amt'],
        '25' => ['col' => 'bdm', 'calc' => 'bdm_amt'],
        '31' => ['col' => 'bdm', 'calc' => 'bdm_amt'],
        '24' => ['col' => 'bch', 'calc' => 'bch_amt']
    ];

    if (!isset($typeMap[$userType])) {
        throw new Exception("Invalid userType");
    }

    $map = $typeMap[$userType];
    $col = $map['col'];

    // ✅ BASE QUERY (JOIN instead of N+1)
    if ($userType == '10') {
        $where = "(p.cu1_id = :userId OR p.cu2_id = :userId OR p.cu3_id = :userId)";
    } else {
        $where = "p.{$col}_id = :userId";
    }

    if (!$isAllTime) {
        $where .= " AND YEAR(p.created_date) = :year AND MONTH(p.created_date) = :month";
    }

    $sql = "
        SELECT 
            p.*,
            pkg.name AS package_name,
            cu.firstname,
            cu.lastname
        FROM product_payout p
        LEFT JOIN package pkg ON pkg.id = p.package_id
        LEFT JOIN ca_customer cu ON cu.ca_customer_id = p.cu_id
        WHERE $where
        ORDER BY p.created_date DESC
    ";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':userId', $userId);

    if (!$isAllTime) {
        $stmt->bindParam(':year', $year);
        $stmt->bindParam(':month', $month);
    }

    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // ✅ Single pass calculation
    $transactions = [];
    $totalPayout = 0;

    foreach ($rows as $row) {
        $dt = (new DateTime($row['created_date']))->format('Y-m-d');

        $packageName = $row['package_name'] ?? 'Unknown Package';
        $customerName = trim(($row['firstname'] ?? '') . ' ' . ($row['lastname'] ?? ''));

        // 🔥 Amount logic
        if ($userType == '10') {
            if ($row['cu1_id'] == $userId) {
                $amt = $row['cu1_amt'];
                $message = $row['cu1_mess'];
                $status = $row['cu1_status'];
            } elseif ($row['cu2_id'] == $userId) {
                $amt = $row['cu2_amt'];
                $message = $row['cu2_mess'];
                $status = $row['cu2_status'];
            } else {
                $amt = $row['cu3_amt'];
                $message = $row['cu3_mess'];
                $status = $row['cu3_status'];
            }
        } else {
            $amt = $row["{$col}_amt"];
            $message = $row["{$col}_mess"];
            $status = $row["{$col}_status"];

            if ($userType == '11') {
                $amt += $row['ta_markup']; // include markup
            }
        }

        $amt = (float)$amt;
        $tds = $amt * $tdsPercentage;
        $payable = truncateToTwoDecimals($amt - $tds);

        $totalPayout += $amt;

        $txn = [
            'date' => $dt,
            'packageName' => $packageName,
            'customerName' => $customerName,
            'noOfAdults' => $row['no_of_adult'],
            'noOfChildren' => $row['no_of_child'],
            'message' => $message,
            'amount' => $amt,
            'tds' => $tds,
            'totalPayable' => $payable,
            'status' => ($status == '1') ? 'Paid' : 'Pending'
        ];

        if ($userType == '11') {
            $txn['markup'] = $row['ta_markup'];
        }

        $transactions[] = $txn;
    }

    // ✅ Final totals (correct for both modes)
    $totalTDS = $totalPayout * $tdsPercentage;
    $finalPayout = truncateToTwoDecimals($totalPayout - $totalTDS);

    $response['status'] = 'success';
    $response['message'] = 'Payouts fetched successfully';

    $response['data'] = [
        'userId' => $userId,
        'userType' => $userType,
        'totalAmount' => (float)$totalPayout,
        'totalTDS' => (float)$totalTDS,
        'totalPayable' => (float)$finalPayout,
        'transactions' => $transactions
    ];

} catch (PDOException $e) {
    $response['message'] = "Database error: " . $e->getMessage();
} catch (Exception $e) {
    $response['message'] = $e->getMessage();
}

echo json_encode($response, JSON_PRETTY_PRINT);
?>