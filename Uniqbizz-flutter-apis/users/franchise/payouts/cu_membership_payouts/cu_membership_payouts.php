<?php
require '../../../../connect.php';

// Only allow POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['status' => 'error', 'message' => 'Method not allowed']);
    exit();
}

// Get request parameters
$request = json_decode(file_get_contents('php://input'), true);

// Validate required parameters
if (!isset($request['userId']) || !isset($request['type'])) {
    http_response_code(400);
    echo json_encode(['status' => 'error', 'message' => 'Missing required parameters']);
    exit();
}

$userId = $request['userId'];
$type = $request['type']; // 'previous', 'next', or 'total'

// Use your fixed values
$columnDesignation = 'techno_enterprise';
$columnMessage = 'message_te';
$columnCommision = 'commision_te';
$columnStatus = 'status_te';
$tdsPercentage = 2/100; // Exactly as you have

try {
    $response = [];
    
    if ($type === 'previous' || $type === 'next') {
        // For previous/next payout, need year and month
        if (!isset($request['year']) || !isset($request['month'])) {
            http_response_code(400);
            echo json_encode(['status' => 'error', 'message' => 'Year and month required for previous/next payout']);
            exit();
        }
        
        $year = $request['year'];
        $month = $request['month'];

        // Determine period
        if ($type === 'previous') {
            $date = strtotime("-1 month", strtotime("$year-$month-01"));
            $month = (int)date('n', $date);
            $year = (int)date('Y', $date);
            $period = date("F,Y", $date);

        } elseif ($type === 'next') {
            $date = strtotime("$year-$month-01");
            $month = (int)date('n', $date);
            $year = (int)date('Y', $date);
            $period = date("F,Y", $date);

        } else {
            throw new Exception("Invalid type");
        }
        
        // Get total payout for the month (your exact query)
        $payoutSql = "SELECT SUM($columnCommision) as payout FROM ca_cu_payout 
                     WHERE $columnDesignation = ? AND YEAR(created_date) = ? AND MONTH(created_date) = ?";
        $payoutStmt = $conn->prepare($payoutSql);
        $payoutStmt->execute([$userId, $year, $month]);
        $payoutStmt->setFetchMode(PDO::FETCH_ASSOC);
        
        $totalPayout = 0;
        $totalPayable = 0;
        
        if($payoutStmt->rowCount() > 0) {
            $row = $payoutStmt->fetch();
            $totalPayout = $row['payout'] ?? 0;
            $tdsAmount = $totalPayout * $tdsPercentage;
            $totalPayable = $totalPayout - $tdsAmount;
        }
        
        // Get payout details (your exact query)
        $sql = "SELECT 
                    ca.created_date,
                    ca.status,
                    ca.id,
                    ca.$columnMessage,
                    ca.$columnCommision,
                    ca.$columnStatus,
                    COALESCE(cap.status, 0) AS status,
                    cap.date AS paydate
                FROM ca_cu_payout ca
                LEFT JOIN ca_cu_payout_paid cap 
                    ON cap.$columnDesignation = ca.$columnDesignation
                    AND cap.techno_enterprise = ca.techno_enterprise
                    AND YEAR(cap.date) = ?
                    AND MONTH(cap.date) = ?
                WHERE ca.$columnDesignation = ? 
                AND YEAR(ca.created_date) = ? 
                AND MONTH(ca.created_date) = ?";
        
        $stmt = $conn->prepare($sql);
        $stmt->execute([$year, $month, $userId, $year, $month]);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        
        $payoutDetails = [];
        if($stmt->rowCount() > 0) {
            foreach($stmt->fetchAll() as $row) {
                // Format date as in your code
                $dt = new DateTime($row['created_date']);
                $formattedDate = $dt->format('Y-m-d');
                
                // Replace dots with line breaks as in your code
                $message = str_replace('.', " ", $row[$columnMessage]);
                
                // Calculate amounts exactly as in your code
                $commission = $row[$columnCommision];
                $tds = $commission * $tdsPercentage;
                $total = $commission - $tds;
                
                $payoutDetails[] = [
                    'date' => $formattedDate,
                    'payout_details' => $message,
                    'amount' => floatval($commission),
                    'tds' => floatval($tds),
                    'total_payable' => floatval($total),
                    'status' => $row[$columnStatus] == '1' ? 'Paid' : 'Pending',
                    'id' => $row['id']
                ];
            }
        }
        
        $response = [
            'status' => 'success',
            'data' => [
                'period' => $period,
                'total_payout' => floatval($totalPayout),
                'tds_amount' => floatval($tdsAmount),
                'total_payable' => floatval($totalPayable),
                'tds_percentage' => floatval($tdsPercentage * 100),
                'year' => $year,
                'month' => $month,
                'transactions'=> $payoutDetails
            ],
        ];
        
    }else {
        http_response_code(400);
        echo json_encode(['status' => 'error', 'message' => 'Invalid type. Use: previous or next']);
        exit();
    }
    
    // Return JSON response
    header('Content-Type: application/json');
    echo json_encode([
        'status' => 'success',
        'data' => $response
    ]);
    
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => 'Server error: ' . $e->getMessage()]);
}