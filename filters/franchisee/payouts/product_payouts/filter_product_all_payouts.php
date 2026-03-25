<?php
header("Content-Type: application/json");

// Database connection
require '../../../../connect.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['status' => false, 'message' => 'Method not allowed']);
    exit;
}

// Inputs (simplified)
$request = json_decode(file_get_contents('php://input'), true);

if (!is_array($request)) {
    echo json_encode([
        'status' => false,
        'message' => 'Invalid JSON body'
    ]);
    exit;
}

$userId = $request['id'] ?? null;
$search = $request['search'] ?? '';  // search term
$fromDate = $request['fromDate'] ?? '';  // from date
$toDate = $request['toDate'] ?? '';  // to date
$tdsPercentage = 0.02; // example: 2% TDS

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

$sql = "SELECT * FROM product_payout WHERE te_id = :uid";

// Add date range to SQL for better performance
if (!empty($fromDate) && !empty($toDate)) {
    $sql .= " AND DATE(created_date) BETWEEN :from_date AND :to_date";
} elseif (!empty($fromDate)) {
    $sql .= " AND DATE(created_date) >= :from_date";
} elseif (!empty($toDate)) {
    $sql .= " AND DATE(created_date) <= :to_date";
}

$stmt = $conn->prepare($sql);
$params = [':uid' => $userId];

// Add date parameters
if (!empty($fromDate)) {
    $params[':from_date'] = $fromDate;
}
if (!empty($toDate)) {
    $params[':to_date'] = $toDate;
}

$stmt->execute($params);
$data = [];
$filteredData = [];

if ($stmt->rowCount() > 0) {
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($rows as $row) {
        $dt = (new DateTime($row['created_date']))->format('Y-m-d');

        // Package name
        $stmt1 = $conn->prepare("SELECT name FROM package WHERE id = :pid");
        $stmt1->execute([':pid' => $row['package_id']]);
        $packageName = $stmt1->fetchColumn();

        // Customer name
        $stmt8 = $conn->prepare("SELECT firstname, lastname FROM ca_customer WHERE ca_customer_id = :cid");
        $stmt8->execute([':cid' => $row['cu_id']]);
        $cuData = $stmt8->fetch(PDO::FETCH_ASSOC);
        $cuName = $cuData['firstname'] . ' ' . $cuData['lastname'];

        $no_of_adult = $row['no_of_adult'];
        $no_of_child = $row['no_of_child'];
        $ta_markup = null;

        $message = $row['te_mess'];
        $amt = $row['te_amt'];
        $status = $row['te_status'];

        $tds = $amt * $tdsPercentage;
        $totalPayable = $amt - $tds;
        
        $statusText = ($status == '1' ? "Paid" : "Pending");
        
        // Build message string
        $fullMessage = $message . " on selling " . $packageName . " Package to " . $cuName .
            " | Adults: " . $no_of_adult . " | Children: " . $no_of_child;

        // Create payout item
        $payoutItem = [
            "date" => $dt,
            "message" => $fullMessage,
            "markup" => $ta_markup,
            "amount" => $amt,
            "tds" => $tds,
            "total_payable" => $totalPayable,
            "status" => $statusText
        ];

        // Apply search filter if search term is provided
        if (!empty($search)) {
            $searchLower = strtolower($search);
            $searchableText = strtolower($fullMessage . ' ' . $packageName . ' ' . $cuName . ' ' . $statusText . ' ' . $tds . ' ' . $totalPayable);
            
            if (strpos($searchableText, $searchLower) !== false) {
                $filteredData[] = $payoutItem;
            }
        } else {
            $filteredData[] = $payoutItem;
        }
    }
    
    // Check if filtered data is empty
    if (count($filteredData) === 0) {
        echo json_encode([
            "status" => true,
            "count" => 0,
            "data" => [],
            "message" => "No matching results found for your search criteria"
        ], JSON_PRETTY_PRINT);
        exit;
    }

    echo json_encode([
        "status" => true,
        "count" => count($filteredData),
        "data" => $filteredData,
        "message" => "Results found"
    ], JSON_PRETTY_PRINT);
    
} else {
    echo json_encode([
        "status" => true,
        "count" => 0,
        "data" => [],
        "message" => "No records found for the selected date range"
    ], JSON_PRETTY_PRINT);
}
?>