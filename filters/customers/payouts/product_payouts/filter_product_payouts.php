<?php

require '../../../../connect.php';

header('Content-Type: application/json');

$request = json_decode(file_get_contents('php://input'), true);

// Keep request same
$userId = $request['id'] ?? '';
$search = trim($request['search'] ?? '');
$fromDate = $request['fromDate'] ?? null;
$toDate = $request['toDate'] ?? null;

// FORCE userType = 10
$userType = '10';

$response = [
    'status' => 'error',
    'message' => '',
    'data' => []
];

$tdsPercentage = 2 / 100;

function truncateToTwoDecimals($num)
{
    return floor($num * 100) / 100;
}

try {

    // Base query (ONLY customer logic)
    $sql = "SELECT *,
    CASE
        WHEN cu1_id = :userId THEN 'Level_1'
        WHEN cu2_id = :userId THEN 'Level_2'
        WHEN cu3_id = :userId THEN 'Level_3'
    END AS user_level
FROM product_payout
WHERE (cu1_id = :userId OR cu2_id = :userId OR cu3_id = :userId);";

    // Date range filter
    if (!empty($fromDate) && !empty($toDate)) {
        $sql .= " AND DATE(created_date) BETWEEN :fromDate AND :toDate";
    }

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':userId', $userId);

    if (!empty($fromDate) && !empty($toDate)) {
        $stmt->bindParam(':fromDate', $fromDate);
        $stmt->bindParam(':toDate', $toDate);
    }

    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);

    $transactions = [];
    $totalAmount = 0;

    while ($row = $stmt->fetch()) {

        $dt = new DateTime($row['created_date']);
        $date = $dt->format('Y-m-d');

        // Package name
        $stmt1 = $conn->prepare("SELECT name FROM package WHERE id = :packageId");
        $stmt1->bindParam(':packageId', $row['package_id']);
        $stmt1->execute();
        $pkgName = $stmt1->fetch();
        $packageName = $pkgName['name'] ?? 'Unknown Package';

        // Customer name
        $stmt8 = $conn->prepare("SELECT firstname, lastname FROM ca_customer WHERE ca_customer_id = :customerId");
        $stmt8->bindParam(':customerId', $row['cu_id']);
        $stmt8->execute();
        $cu_name = $stmt8->fetch();
        $cuName = trim(($cu_name['firstname'] ?? '') . ' ' . ($cu_name['lastname'] ?? ''));

        // payout selection logic (UNCHANGED)
        if ($row['cu1_id'] == $userId) {
            $message = $row['cu1_mess'];
            $amt = $row['cu1_amt'];
            $status = $row['cu1_status'];
        } elseif ($row['cu2_id'] == $userId) {
            $message = $row['cu2_mess'];
            $amt = $row['cu2_amt'];
            $status = $row['cu2_status'];
        } else {
            $message = $row['cu3_mess'];
            $amt = $row['cu3_amt'];
            $status = $row['cu3_status'];
        }

        $tds = $amt * $tdsPercentage;
        $total = truncateToTwoDecimals($amt - $tds);

        // ✅ SEARCH FILTER (applied AFTER data prep — safer)
        // ✅ IMPROVED SEARCH FILTER (covers ALL fields)
if (!empty($search)) {
    $searchLower = strtolower($search);

    $searchableString = strtolower(
        $date . ' ' .
        $packageName . ' ' .
        $cuName . ' ' .
        $message . ' ' .
        $row['no_of_adult'] . ' ' .
        $row['no_of_child'] . ' ' .
        $amt . ' ' .
        $tds . ' ' .
        $total . ' ' .
        (($status == '1') ? 'paid' : 'pending')
    );

    if (strpos($searchableString, $searchLower) === false) {
        continue;
    }
}

        $totalAmount += $amt;

        $transaction = [
            'date' => $date,
            'packageName' => $packageName,
            'customerName' => $cuName,
            'noOfAdults' => $row['no_of_adult'],
            'noOfChildren' => $row['no_of_child'],
            'message' => $message,
            'amount' => $amt,
            'tds' => $tds,
            'totalPayable' => $total,
            'status' => ($status == '1') ? 'Paid' : 'Pending',
           // 'level' => $row['user_level']  For showing level for customer payouts
        ];

        $transactions[] = $transaction;
    }

    // ✅ HANDLE NO DATA CASE
    if (empty($transactions)) {
        $response = [
            'status' => 'success',
            'message' => 'No data found',
            'data' => [
                'totalAmount' => 0,
                'totalTDS' => 0,
                'totalPayable' => 0,
                'transactions' => [],
            ]
        ];
        echo json_encode($response);
        exit;
    }

    // totals
    $totalTDS = $totalAmount * $tdsPercentage;
    $totalPayable = truncateToTwoDecimals($totalAmount - $totalTDS);

    $response = [
        'status' => 'success',
        'data' => [
            'totalAmount' => $totalAmount,
            'totalTDS' => $totalTDS,
            'totalPayable' => $totalPayable,
            'transactions' => $transactions
        ]
    ];

} catch (PDOException $e) {
    $response['message'] = "Database error: " . $e->getMessage();
} catch (Exception $e) {
    $response['message'] = $e->getMessage();
}

echo json_encode($response);