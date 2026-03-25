<?php
require '../../../../connect.php';

// Get JSON input from Flutter app
$request = json_decode(file_get_contents('php://input'), true);

// Extract required parameters (exactly as in original POST)
$TotalYear = $request['year'] ?? '';
$TotalMonth = $request['month'] ?? '';
$user_id = $request['userId'] ?? '';

// Fixed parameters - EXACTLY as in your original code
$designation = 'techno_enterprise';
$commision = 'commision_te';  

// Determine message type - EXACT same logic as original
$user_id_str = substr($user_id, 0, 1) == 'F' ? substr($user_id, 0, 1) : substr($user_id, 0, 2);
if ($user_id_str == 'MF' || $user_id_str == 'SF' || $user_id_str == 'BM') {
    $message = "message_bm";
} else if ($user_id_str == 'F' || $user_id_str == 'CA' || $user_id_str == 'TE') {
    $message = "message_te";
} else if ($user_id_str == 'TA') {
    $message = "message_tc";
}

// Prepare response array
$response = [
    'success' => false,
    'message' => '',
    'totalPayout' => 0,
    'payoutRecords' => []
];

try {
    // Validate required inputs
    if (empty($TotalYear) || empty($TotalMonth) || empty($user_id)) {
        $response['message'] = 'Missing required parameters';
        echo json_encode($response);
        exit;
    }

    // 1. Calculate Total Payout - EXACT same logic as original $totalAmountMessage
    // Note: Using the exact same column names as original
    $totalStmt = $conn->prepare("
        SELECT SUM($commision) as TotalPayout 
        FROM ca_cu_payout 
        WHERE $designation = :user_id 
        AND YEAR(created_date) = :year 
        AND MONTH(created_date) = :month
    ");
    
    $totalStmt->execute([
        ':user_id' => $user_id,
        ':year' => $TotalYear,
        ':month' => $TotalMonth
    ]);
    
    $totalResult = $totalStmt->fetch(PDO::FETCH_ASSOC);
    $TotalPayout = $totalResult['TotalPayout'] ?? 0;
    
    // Handle null as in original
    if ($TotalPayout == null) {
        $TotalPayout = 0;
    }
    
    // 2. Get Payout Records - EXACT same query as original $totalTableMessage
    $model2 = $conn->prepare("
        SELECT 
            ca.created_date,
            ca.status,
            ca.id,
            ca.message_bm,
            ca.message_te,
            ca.commision_te,
            ca.commision_bm,
            ca.travel_consultant,
            ca.message_tc,
            ca.commision_tc,
            ca.status_tc,
            cap.status,
            cap.date AS paydate
        FROM ca_cu_payout ca
        LEFT JOIN ca_cu_payout_paid cap 
            ON cap.$designation = ca.$designation 
            AND cap.travel_consultant = ca.travel_consultant
        WHERE ca.$designation = :user_id 
        AND YEAR(ca.created_date) = :year 
        AND MONTH(ca.created_date) = :month
    ");
    
    $model2->execute([
        ':user_id' => $user_id,
        ':year' => $TotalYear,
        ':month' => $TotalMonth
    ]);
    
    $model2->setFetchMode(PDO::FETCH_ASSOC);
    
    // Process records with EXACT same logic as original
    $payoutRecords = [];
    if ($model2->rowCount() > 0) {
        foreach ($model2->fetchAll() as $key => $row) {
            // Date format - exactly as original
            $dt = new DateTime($row['created_date']);
            $dt = $dt->format('Y-m-d');

            // Replace dots with line breaks as in your code
                $message = str_replace('.', " ", $row[$message]);
            
            // Commission calculation - using exact same column reference
            $Commision = $row[$commision] ?? 0;  // Note: $commision = 'commission_te'
            $CommisionTDS = $Commision * 2 / 100;
            $CommisionTotal = $Commision - $CommisionTDS;
            $status = $row['status'];
            
            $record = [
                'date' => $dt,
                'payout_details' => $message,
                'amount' => $Commision,
                'tds' => $CommisionTDS,
                'totalPayable' => $CommisionTotal,
                'status' => $status == '1' ? 'Paid' : 'Pending',
                'id' => $row['id'],
            ];
            
            $payoutRecords[] = $record;
        }
    }
    
    // Prepare final response
    $response['success'] = true;
    $response['message'] = 'Data retrieved successfully';
    $response['totalPayout'] = $TotalPayout;  // Note: capital 'P' as in original
    $response['payoutRecords'] = $payoutRecords;
    
} catch (Exception $e) {
    $response['message'] = 'Error: ' . $e->getMessage();
    $response['error'] = $e->getMessage();
}

// Send JSON response
header('Content-Type: application/json');
echo json_encode($response, JSON_PRETTY_PRINT);
?>