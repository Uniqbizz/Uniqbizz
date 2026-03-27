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
$search = trim($request['search'] ?? '');
$year   = $request['year'] ?? null;
$month  = $request['month'] ?? null;

if (!$userId) {
    echo json_encode([
        "status" => false,
        "message" => "Missing user_id"
    ]);
    exit;
}

$isAllTime = empty($year) && empty($month);

$checkStmt = $conn->prepare("
    SELECT 1 
    FROM ca_travelagency 
    WHERE reference_no = :user_ref 
    LIMIT 1
");
$checkStmt->execute([':user_ref' => $userId]);

if (!$checkStmt->fetchColumn()) {
    echo json_encode([
        "status" => false,
        "message" => "franchisee id invalid"
    ]);
    exit;
}

$tdsPercentage = 2 / 100;

function truncateToTwoDecimals($num)
{
    return floor($num * 100) / 100;
}

try {

    $col = 'te';

    // =========================
    // WHERE CLAUSE
    // =========================
    $where = ["p.{$col}_id = :userId"];

    if (!$isAllTime) {
        $where[] = "YEAR(p.created_date) = :year";
        $where[] = "MONTH(p.created_date) = :month";
    }

    if (!empty($search)) {
        $where[] = "(
            pkg.name LIKE :search OR
            CONCAT(cu.firstname, ' ', cu.lastname) LIKE :search OR
            p.{$col}_mess LIKE :search OR
            DATE(p.created_date) LIKE :search OR
            CAST(p.{$col}_amt AS CHAR) LIKE :search OR
            CAST((p.{$col}_amt * 0.02) AS CHAR) LIKE :search OR
            CAST((p.{$col}_amt - (p.{$col}_amt * 0.02)) AS CHAR) LIKE :search
        )";
    }

    $whereSql = implode(" AND ", $where);

    // =========================
    // MAIN QUERY (JOIN)
    // =========================
    $sql = "
        SELECT 
            p.*,
            pkg.name AS packageName,
            cu.firstname,
            cu.lastname
        FROM product_payout p
        LEFT JOIN package pkg ON pkg.id = p.package_id
        LEFT JOIN ca_customer cu ON cu.ca_customer_id = p.cu_id
        WHERE $whereSql
        ORDER BY p.created_date DESC
    ";

    $stmt = $conn->prepare($sql);

    $stmt->bindValue(':userId', $userId);

    if (!$isAllTime) {
        $stmt->bindValue(':year', $year);
        $stmt->bindValue(':month', $month);
    }

    if (!empty($search)) {
        $stmt->bindValue(':search', '%' . $search . '%');
    }

    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $transactions = [];
    $totalAmount = 0;

    foreach ($rows as $row) {

        $dt = (new DateTime($row['created_date']))->format('Y-m-d');

        $customerName = trim(($row['firstname'] ?? '') . ' ' . ($row['lastname'] ?? ''));

        $amt = (float)$row["{$col}_amt"];
        $tds = $amt * $tdsPercentage;
        $total = truncateToTwoDecimals($amt - $tds);

        $totalAmount += $amt;

        $transactions[] = [
            'date' => $dt,
            'packageName' => $row['packageName'] ?? 'Unknown Package',
            'customerName' => $customerName,
            'noOfAdults' => $row['no_of_adult'],
            'noOfChildren' => $row['no_of_child'],
            'message' => $row["{$col}_mess"],
            'amount' => $amt,
            'tds' => $tds,
            'totalPayable' => $total,
            'status' => ($row["{$col}_status"] == '1') ? 'Paid' : 'Pending',
            'statusCode' => $row["{$col}_status"]
        ];
    }

    if (empty($transactions)) {
        echo json_encode([
            "status" => true,
            "count" => 0,
            "data" => [],
            "message" => $isAllTime ? "No records found" : "No records found for this month"
        ], JSON_PRETTY_PRINT);
        exit;
    }

    $response = [
        "status" => true,
        "count" => count($transactions),
        "data" => $transactions,
        "message" => "Results found"
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