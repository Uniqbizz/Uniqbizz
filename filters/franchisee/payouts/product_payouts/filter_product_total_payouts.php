<?php

require '../../../../connect.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['status' => false, 'message' => 'Method not allowed']);
    exit;
}

$request = json_decode(file_get_contents('php://input'), true);

if (!is_array($request)) {
    echo json_encode([
        'status' => false,
        'message' => 'Invalid JSON body'
    ]);
    exit;
}

$userId = $request['userId'] ?? null;
$search = $request['search'] ?? '';
$year   = $request['year'] ?? null;
$month  = $request['month'] ?? null;

if (!$userId) {
    echo json_encode([
        "status" => false,
        "message" => "Missing user_id"
    ]);
    exit;
}

if (!$year || !$month) {
    echo json_encode([
        "status" => false,
        "message" => "year and month required"
    ]);
    exit;
}

$checkStmt = $conn->prepare("
    SELECT 1 
    FROM ca_travelagency 
    WHERE reference_no = :user_ref 
    LIMIT 1
");

$checkStmt->bindValue(':user_ref', $userId, PDO::PARAM_STR);
$checkStmt->execute();

if (!$checkStmt->fetchColumn()) {
    echo json_encode([
        "status" => false,
        "message" => "franchisee id invalid"
    ]);
    exit;
}

$tdsPercentage = 2 / 100;

$response = [
    'status' => 'error',
    'message' => '',
    'data' => []
];

function truncateToTwoDecimals($num)
{
    return floor($num * 100) / 100;
}

try {

    $col = 'te';

    /*
    ------------------------------------------------
    ONLY CHANGE: MONTH + YEAR FILTER
    ------------------------------------------------
    */

    $sql = "SELECT * FROM product_payout 
            WHERE {$col}_id = :userId
            AND YEAR(created_date) = :year
            AND MONTH(created_date) = :month
            ORDER BY created_date DESC";

    $stmt = $conn->prepare($sql);

    $stmt->bindParam(':userId', $userId);
    $stmt->bindParam(':year', $year);
    $stmt->bindParam(':month', $month);

    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);

    $transactions = [];
    $totalAmount = 0;

    while ($row = $stmt->fetch()) {

        $dt = (new DateTime($row['created_date']))->format('Y-m-d');

        $stmt1 = $conn->prepare("SELECT name FROM package WHERE id = :pkgId");
        $stmt1->bindParam(':pkgId', $row['package_id']);
        $stmt1->execute();
        $pkg = $stmt1->fetch();
        $packageName = $pkg['name'] ?? 'Unknown Package';

        $stmt2 = $conn->prepare("SELECT firstname, lastname FROM ca_customer WHERE ca_customer_id = :cid");
        $stmt2->bindParam(':cid', $row['cu_id']);
        $stmt2->execute();
        $cu = $stmt2->fetch();
        $customerName = trim(($cu['firstname'] ?? '') . ' ' . ($cu['lastname'] ?? ''));

        $amt = (float)($row["{$col}_amt"] ?? 0);
        $message = $row["{$col}_mess"] ?? '';
        $statusCode = $row["{$col}_status"] ?? '0';
        $statusText = ($statusCode == '1') ? 'Paid' : 'Pending';

        $tds = $amt * $tdsPercentage;
        $total = truncateToTwoDecimals($amt - $tds);
        $totalAmount += $amt;

        $transaction = [
            'date' => $dt,
            'packageName' => $packageName,
            'customerName' => $customerName,
            'noOfAdults' => $row['no_of_adult'],
            'noOfChildren' => $row['no_of_child'],
            'message' => $message,
            'amount' => $amt,
            'tds' => $tds,
            'totalPayable' => $total,
            'status' => $statusText,
            'statusCode' => $statusCode
        ];

        $transactions[] = $transaction;
    }

    if (count($transactions) === 0) {
        $response = [
            "status" => true,
            "count" => 0,
            "data" => [],
            "message" => "No records found for this month"
        ];
        echo json_encode($response, JSON_PRETTY_PRINT);
        exit;
    }

    /*
    ------------------------------------------------
    SEARCH LOGIC (UNCHANGED)
    ------------------------------------------------
    */

    if (!empty($search)) {

        $filteredTransactions = array_filter($transactions,function($transaction) use ($search){

            $searchLower = strtolower($search);

            return
                stripos($transaction['packageName'],$searchLower) !== false ||
                stripos($transaction['customerName'],$searchLower) !== false ||
                stripos($transaction['message'],$searchLower) !== false ||
                stripos($transaction['status'],$searchLower) !== false ||
                stripos($transaction['date'],$searchLower) !== false ||
                stripos((string)$transaction['amount'],$searchLower) !== false ||
                stripos((string)$transaction['tds'],$searchLower) !== false ||
                stripos((string)$transaction['totalPayable'],$searchLower) !== false;
        });

        $transactions = array_values($filteredTransactions);

        if (count($transactions) === 0) {

            $response = [
                "status" => true,
                "count" => 0,
                "data" => [],
                "message" => "No matching results found for your search criteria"
            ];

            echo json_encode($response, JSON_PRETTY_PRINT);
            exit;
        }

        $totalAmount = array_sum(array_column($transactions,'amount'));
    }

    $totalTDS = $totalAmount * $tdsPercentage;
    $totalPayable = truncateToTwoDecimals($totalAmount - $totalTDS);

    $response = [
        "status" => true,
        "count" => count($transactions),
        "data" => $transactions,
        "message" => "Results found"
    ];

} catch (PDOException $e) {

    $response = [
        'status' => 'error',
        'message' => "Database error: " . $e->getMessage(),
        'data' => []
    ];

} catch (Exception $e) {

    $response = [
        'status' => 'error',
        'message' => $e->getMessage(),
        'data' => []
    ];
}

echo json_encode($response, JSON_PRETTY_PRINT);

?>