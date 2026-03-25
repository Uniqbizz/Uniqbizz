<?php
require '../../../../connect.php'; // Database connection
 
header('Content-Type: application/json');
 
// Get JSON request body
$request = json_decode(file_get_contents('php://input'), true);
 
$userId = $request['userId'] ?? null;
$userType = $request['userType'] ?? null;
$month = isset($request['month']) ? (int)$request['month'] : null;
$year = isset($request['year']) ? (int)$request['year'] : null;
$tdsPercentage = 2 / 100;
 
$response = [
    'status' => 'error',
    'message' => '',
    'month' => '',
    'year' => '',
    'data' => []
];
 
// Helper function to safely truncate
function truncateToTwoDecimals($num)
{
    return floor($num * 100) / 100;
}
 
try {
    if (!$userId || !$userType) {
        throw new Exception("Missing userId or userType");
    }
 
    // Map userType → payout column structure
    $typeMap = [
        '11' => ['col' => 'ta', 'calc' => 'ta_markup + ta_amt'], // Travel Consultant
        '16' => ['col' => 'te', 'calc' => 'te_amt'],             // Techno Enterprise
        '29' => ['col' => 'te', 'calc' => 'te_amt'],             // Franchisee
        '10' => ['col' => 'cu1', 'calc' => 'cu1_amt'],           // Customer (handled separately)
        '26' => ['col' => 'bm', 'calc' => 'bm_amt'],             // Business Mentor
        '28' => ['col' => 'bm', 'calc' => 'bm_amt'],             // Master Franchisee
        '30' => ['col' => 'bm', 'calc' => 'bm_amt'],             // Sponsor Franchisee
        '25' => ['col' => 'bdm', 'calc' => 'bdm_amt'],           // BDM
        '31' => ['col' => 'bdm', 'calc' => 'bdm_amt'],           // Senior BDM
        '24' => ['col' => 'bch', 'calc' => 'bch_amt']            // BCM
    ];
 
    if (!isset($typeMap[$userType])) {
        throw new Exception("Invalid userType");
    }
 
    $map = $typeMap[$userType];
    $col = $map['col'];
    $amtCal = $map['calc'];
 
    // Build total payout query
    if ($userType == '10') {
        $sqlTotal = "SELECT SUM(cu1_amt + cu2_amt + cu3_amt) as total_payable
                     FROM product_payout
                     WHERE (cu1_id = :userId OR cu2_id = :userId OR cu3_id = :userId) AND YEAR(created_date) = :year AND MONTH(created_date) = :month";
    } else {
        $sqlTotal = "SELECT SUM($amtCal) as total_payable
                     FROM product_payout
                     WHERE {$col}_id = :userId AND YEAR(created_date) = :year AND MONTH(created_date) = :month";
    }
 
    $stmtTotal = $conn->prepare($sqlTotal);
    $stmtTotal->bindParam(':userId', $userId);
    $stmtTotal->bindParam(':year', $year);
    $stmtTotal->bindParam(':month', $month);
    $stmtTotal->execute();
    $rowTotal = $stmtTotal->fetch(PDO::FETCH_ASSOC);
 
    $totalPayout = $rowTotal['total_payable'] ?? 0;
    $totalTDS = $totalPayout * $tdsPercentage;
    $finalPayout = truncateToTwoDecimals($totalPayout - $totalTDS);
 
    // Fetch detailed transactions
    if ($userType == '10') {
        $sql = "SELECT * FROM product_payout
                WHERE (cu1_id = :userId OR cu2_id = :userId OR cu3_id = :userId) AND YEAR(created_date) = :year AND MONTH(created_date) = :month";
    } else {
        $sql = "SELECT * FROM product_payout
                WHERE {$col}_id = :userId AND YEAR(created_date) = :year AND MONTH(created_date) = :month";
    }
 
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':userId', $userId);
    $stmt->bindParam(':year', $year);
    $stmt->bindParam(':month', $month);
    $stmt->execute();
 
    $transactions = [];
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $dt = (new DateTime($row['created_date']))->format('Y-m-d');
 
        // Package name
        $stmt1 = $conn->prepare("SELECT name FROM package WHERE id = :pkgId");
        $stmt1->bindParam(':pkgId', $row['package_id']);
        $stmt1->execute();
        $pkg = $stmt1->fetch();
        $packageName = $pkg['name'] ?? 'Unknown Package';
 
        // Customer name
        $stmt2 = $conn->prepare("SELECT firstname, lastname FROM ca_customer WHERE ca_customer_id = :cid");
        $stmt2->bindParam(':cid', $row['cu_id']);
        $stmt2->execute();
        $cu = $stmt2->fetch();
        $customerName = trim(($cu['firstname'] ?? '') . ' ' . ($cu['lastname'] ?? ''));
 
        // Determine payout info
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
        }
 
        $amt = (float)$amt;
        $tds = $amt * $tdsPercentage;
        $total = truncateToTwoDecimals($amt - $tds);
 
        $txn = [
            'date' => $dt,
            'packageName' => $packageName,
            'customerName' => $customerName,
            'noOfAdults' => $row['no_of_adult'],
            'noOfChildren' => $row['no_of_child'],
            'message' => $message,
            'amount' => $amt,
            'tds' => $tds,
            'totalPayable' => $total,
            'status' => ($status == '1') ? 'Paid' : 'Pending'
        ];
 
        if ($userType == '11') {
            $txn['markup'] = $row['ta_markup'];
        }
 
        $transactions[] = $txn;
    }
 
    // Success response
    $response['status'] = 'success';
    $response['message'] = 'Total payouts fetched successfully';
    $response['month'] = $month;
    $response['year'] = $year;
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