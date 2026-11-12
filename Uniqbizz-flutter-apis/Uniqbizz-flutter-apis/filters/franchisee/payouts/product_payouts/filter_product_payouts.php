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
$fromDate = $request['fromDate'] ?? null;
$toDate = $request['toDate'] ?? null;
$year = $request['year'] ?? null;
$month = $request['month'] ?? null;

if (!$userId) {
    echo json_encode([
        "status" => false,
        "message" => "Missing user_id"
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

$tdsPercentage = 2/100;

function truncateToTwoDecimals($num)
{
    return floor($num * 100) / 100;
}

try {

    $userIdCommi = 'te_id';

    /*
    ------------------------------------------
    DATE RANGE MODE
    ------------------------------------------
    */

    $sql = "SELECT * FROM product_payout WHERE $userIdCommi = :userId";

    if ($fromDate || $toDate) {

        if ($fromDate && $toDate) {
            $sql .= " AND DATE(created_date) BETWEEN :fromDate AND :toDate";
        } elseif ($fromDate) {
            $sql .= " AND DATE(created_date) >= :fromDate";
        } elseif ($toDate) {
            $sql .= " AND DATE(created_date) <= :toDate";
        }

    }

    /*
    ------------------------------------------
    MONTH MODE
    ------------------------------------------
    */

    else {

        if (!$year || !$month) {
            echo json_encode([
                "status" => false,
                "message" => "year and month required"
            ]);
            exit;
        }

        $sql .= " AND YEAR(created_date) = :year AND MONTH(created_date) = :month";
    }

    $sql .= " ORDER BY created_date DESC";

    $stmt = $conn->prepare($sql);

    $stmt->bindParam(':userId', $userId);

    if ($fromDate) $stmt->bindParam(':fromDate', $fromDate);
    if ($toDate) $stmt->bindParam(':toDate', $toDate);

    if (!$fromDate && !$toDate) {
        $stmt->bindParam(':year', $year);
        $stmt->bindParam(':month', $month);
    }

    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);

    $transactions = [];
    $totalAmount = 0;

    while ($row = $stmt->fetch()) {

        $dt = new DateTime($row['created_date']);
        $date = $dt->format('Y-m-d');

        $stmt1 = $conn->prepare("SELECT name FROM package WHERE id = :packageId");
        $stmt1->bindParam(':packageId', $row['package_id']);
        $stmt1->execute();
        $pkgName = $stmt1->fetch();
        $packageName = $pkgName['name'] ?? 'Unknown Package';

        $stmt8 = $conn->prepare("SELECT firstname, lastname FROM ca_customer WHERE ca_customer_id = :customerId");
        $stmt8->bindParam(':customerId', $row['cu_id']);
        $stmt8->execute();
        $cu_name = $stmt8->fetch();
        $cuName = ($cu_name['firstname'] ?? '') . ' ' . ($cu_name['lastname'] ?? '');

        $message = $row['te_mess'];
        $amt = $row['te_amt'];
        $status = $row['te_status'];

        $tds = $amt * $tdsPercentage;
        $total = truncateToTwoDecimals($amt - $tds);

        $totalAmount += $amt;

        $transactions[] = [
            'date' => $date,
            'packageName' => $packageName,
            'customerName' => $cuName,
            'noOfAdults' => $row['no_of_adult'],
            'noOfChildren' => $row['no_of_child'],
            'message' => $message,
            'amount' => $amt,
            'tds' => $tds,
            'totalPayable' => $total,
            'status' => ($status == '1') ? 'Paid' : 'Pending'
        ];
    }

    /*
    ------------------------------------------
    SEARCH FILTER
    ------------------------------------------
    */

    if (!empty($search)) {

        $transactions = array_filter($transactions,function($t) use ($search){

            $search = strtolower($search);

            return
                stripos($t['packageName'],$search) !== false ||
                stripos($t['customerName'],$search) !== false ||
                stripos($t['message'],$search) !== false ||
                stripos($t['status'],$search) !== false ||
                stripos($t['date'],$search) !== false ||
                stripos((string)$t['amount'],$search) !== false ||
                stripos((string)$t['tds'],$search) !== false ||
                stripos((string)$t['totalPayable'],$search) !== false;

        });

        $transactions = array_values($transactions);

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

}
catch (Exception $e) {

    $response = [
        'status' => false,
        'message' => $e->getMessage()
    ];
}

echo json_encode($response, JSON_PRETTY_PRINT);