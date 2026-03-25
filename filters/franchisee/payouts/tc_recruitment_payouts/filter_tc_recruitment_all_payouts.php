<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');

// Include database connection
require '../../../../connect.php';

// Only allow POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['status' => false, 'message' => 'Method not allowed']);
    exit;
}

// Get JSON input
$request = json_decode(file_get_contents('php://input'), true);

if (!is_array($request)) {
    echo json_encode([
        'status' => false,
        'message' => 'Invalid JSON body'
    ]);
    exit;
}

$userId = $request['id'] ?? null; // Using 'id' as per your input format
$search = $request['search'] ?? '';
$fromDate = $request['fromDate'] ?? null;
$toDate = $request['toDate'] ?? null;

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

$columnDesignation = 'techno_enterprise'; // Fixed as per your code

// Prepare SQL with date filtering
$sql = "SELECT * FROM `ca_ta_payout` WHERE $columnDesignation = :userId";

// Add date range filter
if ($fromDate && $toDate) {
    $sql .= " AND DATE(created_date) BETWEEN :fromDate AND :toDate";
} elseif ($fromDate) {
    $sql .= " AND DATE(created_date) >= :fromDate";
} elseif ($toDate) {
    $sql .= " AND DATE(created_date) <= :toDate";
}

// Order by id DESC (as per your original)
$sql .= " ORDER BY `ca_ta_payout`.`id` DESC";

$stmt = $conn->prepare($sql);
$stmt->bindParam(':userId', $userId, PDO::PARAM_STR);

if ($fromDate && $toDate) {
    $stmt->bindParam(':fromDate', $fromDate);
    $stmt->bindParam(':toDate', $toDate);
} elseif ($fromDate) {
    $stmt->bindParam(':fromDate', $fromDate);
} elseif ($toDate) {
    $stmt->bindParam(':toDate', $toDate);
}

$stmt->execute();
$stmt->setFetchMode(PDO::FETCH_ASSOC);

$payouts = [];

if ($stmt->rowCount() > 0) {
    foreach ($stmt->fetchAll() as $row) {
        // Date formatting
        $dt = new DateTime($row['created_date']);
        $dt = $dt->format('Y-m-d');
        
        // Message - replace . with space (as per your code)
        $message1 = str_replace('.', ' ', $row['message_te']);
        
        // Amount calculations
        $tdsPercentage = 0.02;
        $CommAmt = floatval($row['commision_te']);
        $tds = $CommAmt * $tdsPercentage;
        $totalAmt = $CommAmt - $tds;
        
        // Status
        $statusText = ($row['status_te'] == '1') ? 'Paid' : 'Pending';
        
        $payouts[] = [
            'id' => $row['id'],
            'date' => $dt,
            'payout_details' => $message1,
            'amount' => $CommAmt,
            'tds' => $tds,
            'total_payable' => $totalAmt,
            'status' => $statusText
        ];
    }
    
    // Check if any records found from database
    if (count($payouts) === 0) {
        echo json_encode([
            'status' => 'success',
            'count' => 0,
            'data' => [],
            'message' => 'No records found for the selected date range'
        ], JSON_PRETTY_PRINT);
        exit;
    }
    
    // Apply search filter if search term provided
    if (!empty($search)) {
        $filteredPayouts = array_filter($payouts, function($payout) use ($search) {
            $searchLower = strtolower($search);
            
            // Search in relevant fields
            if (stripos($payout['payout_details'], $searchLower) !== false) return true;
            if (stripos($payout['status'], $searchLower) !== false) return true;
            if (stripos($payout['date'], $searchLower) !== false) return true;
            if (stripos((string)$payout['amount'], $searchLower) !== false) return true;
            if (stripos((string)$payout['tds'], $searchLower) !== false) return true;
            if (stripos((string)$payout['total_payable'], $searchLower) !== false) return true;
            if (stripos((string)$payout['id'], $searchLower) !== false) return true;
            
            return false;
        });
        
        $payouts = array_values($filteredPayouts);
        
        // Check if search returned no results
        if (count($payouts) === 0) {
            echo json_encode([
                'status' => 'success',
                'count' => 0,
                'data' => [],
                'message' => 'No matching results found for your search criteria'
            ], JSON_PRETTY_PRINT);
            exit;
        }
    }
    
    // Calculate summary totals
    $totalAmount = array_sum(array_column($payouts, 'amount'));
    $totalTDS = array_sum(array_column($payouts, 'tds'));
    $totalPayable = array_sum(array_column($payouts, 'total_payable'));
    
    // Count by status
    $paidCount = count(array_filter($payouts, function($p) {
        return $p['status'] === 'Paid';
    }));
    
    $pendingCount = count(array_filter($payouts, function($p) {
        return $p['status'] === 'Pending';
    }));
    
    // Determine period string
    if ($fromDate && $toDate) {
        $period = date('d M Y', strtotime($fromDate)) . ' - ' . date('d M Y', strtotime($toDate));
    } elseif ($fromDate) {
        $period = 'From ' . date('d M Y', strtotime($fromDate));
    } elseif ($toDate) {
        $period = 'Until ' . date('d M Y', strtotime($toDate));
    } else {
        $period = 'All Time';
    }
    
    echo json_encode([
        'status' => 'success',
        'count' => count($payouts),
        'data' => $payouts,
        'message' => 'Results found'
    ], JSON_PRETTY_PRINT);
    
} else {
    echo json_encode([
        'status' => 'success',
        'count' => 0,
        'data' => [],
        'message' => 'No records found for the selected date range',
    ], JSON_PRETTY_PRINT);
}
?>