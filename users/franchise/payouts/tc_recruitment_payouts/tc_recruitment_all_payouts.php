<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');

// Include database connection
require '../../../../connect.php';

// Only allow POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Only POST method is allowed']);
    exit();
}

// Get JSON input
$request = json_decode(file_get_contents('php://input'), true);

// Check for userId
if (!isset($request['userId'])) {
    http_response_code(400);
    echo json_encode(['error' => 'userId is required']);
    exit();
}

$userId = $request['userId'];
$columnDesignation = 'techno_enterprise'; // Fixed as per your code

// Prepare SQL using your exact query
$sql = "SELECT * FROM `ca_ta_payout` WHERE $columnDesignation = :userId ORDER BY `ca_ta_payout`.`id` DESC";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':userId', $userId, PDO::PARAM_STR);
$stmt->execute();
$stmt->setFetchMode(PDO::FETCH_ASSOC);

$payouts = [];

if ($stmt->rowCount() > 0) {
    foreach ($stmt->fetchAll() as $key => $row) {
        // Date formatting
        $dt = new DateTime($row['created_date']);
        $dt = $dt->format('Y-m-d');
        
        // Message - replace . with <br>
    $message1 = str_replace('.', ' ', $row['message_te']);
    
    // Amount calculations
    $tdsPercentage = 0.02;
    $CommAmt  = floatval($row['commision_te']);
    $tds = $CommAmt  * $tdsPercentage;
    $totalAmt  = $CommAmt  - $tds;
    
    // Status
    $statusText  = ($row['status_te'] == '1') ? 'Paid' : 'Pending';
        
        $payouts[] = [
            'date' => $dt,
            'payout_details' => $message1,
            'amount' => $CommAmt,
            'tds' => $tds,
            'total_payable' => $totalAmt,
            'status' => $statusText,
            'id' => $row['id']
        ];
    }
    
    echo json_encode([
        'status' => 'success',
        'count' => count($payouts),
        'payouts' => $payouts
    ]);
} else {
    echo json_encode([
        'status' => 'success',
        'count' => 0,
        'payouts' => []
    ]);
}