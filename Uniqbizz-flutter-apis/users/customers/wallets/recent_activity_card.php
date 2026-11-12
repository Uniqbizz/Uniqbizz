<?php
header('Content-Type: application/json');
require '../../../../connect.php';

$response = [
    'status' => false,
    'message' => '',
    'data' => []
];

try {
    // Validate request method
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception("Invalid request method. Only POST allowed.");
    }
    
    // Get JSON input
    $input = json_decode(file_get_contents("php://input"), true);
    
    if (!$input) {
        throw new Exception("Invalid JSON input");
    }
    
    // Get required parameters - keep as string
    $user_id = $input['user_id'] ?? '';
    $wallet_type = $input['wallet_type'] ?? '';
    
    // Validate user_id - not empty
    if (empty($user_id)) {
        throw new Exception("user_id is required");
    }
    
    // Validate wallet type
    $valid_wallet_types = ['pcw', 'lcw', 'rw', 'dw'];
    if (empty($wallet_type)) {
        throw new Exception("wallet_type is required");
    }
    
    if (!in_array($wallet_type, $valid_wallet_types)) {
        throw new Exception("Invalid wallet_type. Allowed: " . implode(', ', $valid_wallet_types));
    }
    
    // Process based on wallet type
    switch($wallet_type) {
        case 'pcw':
            $response['data'] = getPCWActivity($conn, $user_id);
            break;
        case 'lcw':
            $response['data'] = getLCWActivity($conn, $user_id);
            break;
        case 'rw':
            $response['data'] = getRWActivity($conn, $user_id);
            break;
        case 'dw':
            $response['data'] = getDWActivity($conn, $user_id);
            break;
    }
    
    $response['status'] = true;
    $response['message'] = 'Wallet activity retrieved successfully';
    
} catch (Exception $e) {
    $response['status'] = false;
    $response['message'] = $e->getMessage();
}

echo json_encode($response);

// ==================== HELPER FUNCTIONS ====================

/**
 * Get PCW (Premium Coupon Wallet) - Latest 3 used coupons + membership placeholder
 */
function getPCWActivity($conn, $userId) {
    // Get used coupons (limited to 3)
    $sqlUsedCoupons = $conn->prepare("
        SELECT 
            c.code,
            c.coupon_amt,
            c.usage_status,
            c.created_date,
            c.used_date,
            c.user_id,
            cu.used_on,
            cu.transaction_id,
            'used_coupon' as entry_type
        FROM cu_coupons c
        LEFT JOIN coupon_utilization cu ON c.code = cu.coupon_code
        WHERE c.user_id = :user_id AND c.usage_status = 1
        ORDER BY c.used_date DESC
        LIMIT 3
    ");
    
    $sqlUsedCoupons->execute([':user_id' => $userId]);
    $usedCoupons = $sqlUsedCoupons->fetchAll(PDO::FETCH_ASSOC);
    
    // Get totals
    $sqlTotal = $conn->prepare("
        SELECT 
            COUNT(*) AS total_coupon_count,
            COALESCE(SUM(coupon_amt), 0) AS total_coupon_amount,
            COUNT(CASE WHEN usage_status = 1 THEN 1 END) AS used_coupon_count,
            COALESCE(SUM(CASE WHEN usage_status = 1 THEN coupon_amt ELSE 0 END), 0) AS used_coupon_amount
        FROM cu_coupons
        WHERE user_id = :user_id
    ");
    $sqlTotal->execute([':user_id' => $userId]);
    $totals = $sqlTotal->fetch(PDO::FETCH_ASSOC);
    
    $allCoupons = $usedCoupons;
    
    // If less than 3, add membership activation entry
    if(count($usedCoupons) < 3) {
        $allCoupons[] = [
            "code" => "MEMBERSHIP",
            "coupon_amt" => $totals['total_coupon_amount'],
            "coupon_count" => $totals['total_coupon_count'],
            "usage_status" => 0,
            "created_date" => !empty($usedCoupons) ? $usedCoupons[0]['created_date'] : date("Y-m-d H:i:s"),
            "used_date" => null,
            "user_id" => $userId,
            "used_on" => null,
            "transaction_id" => null,
            "entry_type" => "membership_activation"
        ];
    }
    
    return [
        "all_coupons" => array_slice($allCoupons, 0, 3),
        "total_coupon_amount" => $totals['total_coupon_amount'],
        "used_coupon_amount" => $totals['used_coupon_amount']
    ];
}

/**
 * Get LCW (Loyalty Coupon Wallet) - Latest 3 coupons (used + unused)
 */
function getLCWActivity($conn, $userId) {
    $sqlCoupons = $conn->prepare("
        SELECT 
            c.code,
            c.coupon_amt,
            c.usage_status,
            c.created_date,
            c.used_date,
            c.user_id,
            cu.used_on,
            cu.transaction_id,
            CASE WHEN c.usage_status = 1 THEN 'used_coupon' ELSE 'credited' END as entry_type
        FROM loyalty_coupon c
        LEFT JOIN loyalty_coupon_utilization cu ON c.code = cu.coupon_code
        WHERE c.user_id = :user_id
        ORDER BY c.usage_status DESC,
                 CASE WHEN c.usage_status = 1 THEN c.used_date ELSE c.created_date END DESC
        LIMIT 3
    ");
    
    $sqlCoupons->execute([':user_id' => $userId]);
    $coupons = $sqlCoupons->fetchAll(PDO::FETCH_ASSOC);
    
    $allCoupons = [];
    foreach ($coupons as $coupon) {
        $allCoupons[] = $coupon;
    }
    
    // Fill remaining with placeholder if needed
    while (count($allCoupons) < 3) {
        $allCoupons[] = [
            "code" => "Credited",
            "coupon_amt" => null,
            "usage_status" => 0,
            "created_date" => date("Y-m-d H:i:s"),
            "used_date" => null,
            "user_id" => $userId,
            "used_on" => null,
            "transaction_id" => null,
            "entry_type" => "credited"
        ];
    }
    
    return ["all_coupons" => $allCoupons];
}

/**
 * Get RW (Referral Wallet) activity
 */
function getRWActivity($conn, $userId) {
    $sqlRefEntries = $conn->prepare("
        SELECT 
            ru.created_date,
            CASE WHEN ru.used_on IS NULL OR ru.used_on = '' THEN ru.earned_on ELSE ru.used_on END AS message,
            CASE WHEN ru.used_amount IS NULL THEN ru.earned_amount ELSE ru.used_amount END AS amount,
            ru.transaction_id AS enchased_id,
            ru.balance,
            CASE 
                WHEN SUBSTRING(ru.transaction_id,1,2) = 'CU' THEN 'Direct Referral Bonus'
                WHEN SUBSTRING(ru.transaction_id,1,2) = 'WD' THEN 'Withdrawal Request'
                ELSE 'Referred Customer Trip Completed'
            END AS entry_type,
            CASE 
                WHEN SUBSTRING(ru.transaction_id,1,2) = 'CU' THEN
                    (SELECT status FROM customer_reference_payout WHERE ru.transaction_id = refered_customer_id LIMIT 1)
                WHEN SUBSTRING(ru.transaction_id,1,2) = 'WD' THEN
                    (SELECT status FROM customer_reference_wallet_encashed WHERE ru.transaction_id = transaction_id LIMIT 1)
                ELSE
                    (SELECT cu1_status FROM product_payout WHERE ru.transaction_id = order_id LIMIT 1)
            END AS status
        FROM customer_reference_wallet_utilization ru
        WHERE ru.customer_id = :user_id
        ORDER BY ru.created_date DESC
    ");
    
    $sqlRefEntries->execute([':user_id' => $userId]);
    $rows = $sqlRefEntries->fetchAll(PDO::FETCH_ASSOC);
    
    $data = [];
    foreach ($rows as $row) {
        $data[] = [
            "entry_type" => $row['entry_type'],
            "created_date" => date('d M Y h:i A', strtotime($row['created_date'])),
            "message" => $row['message'],
            "amount" => number_format((float)$row['amount'], 2),
            "balance" => $row['balance'],
            "status" => $row['status'] ?? '-',
            "reference_id" => $row['enchased_id'] ?? '-'
        ];
    }
    
    return $data;
}

/**
 * Get DW (Discount Wallet) activity
 */
function getDWActivity($conn, $userId) {
    $sqlDiscountWallet = $conn->prepare("
        SELECT 
            cwu.*,
            CASE WHEN cwu.used_amount IS NOT NULL AND cwu.used_amount != '' THEN cwu.used_amount ELSE cwu.earned_amount END AS amount,
            CASE WHEN cwu.used_on IS NOT NULL AND cwu.used_on != '' THEN cwu.used_on ELSE cwu.earned_on END AS message,
            CASE
                WHEN cwu.used_on IS NOT NULL AND cwu.used_on != '' THEN 'Used'
                WHEN cdw.status IS NULL OR cdw.status = 0 THEN 'Pending'
                WHEN cdw.status = 1 THEN 'Credited'
                ELSE 'Unknown'
            END AS wallet_status
        FROM customer_discount_wallet_utilization cwu
        LEFT JOIN customer_discount_wallet cdw ON cwu.transaction_id = cdw.id
        WHERE cwu.customer_id = :user_id
        ORDER BY cwu.created_date DESC
    ");
    
    $sqlDiscountWallet->execute([':user_id' => $userId]);
    $rows = $sqlDiscountWallet->fetchAll(PDO::FETCH_ASSOC);
    
    $data = [];
    foreach ($rows as $row) {
        $data[] = [
            "id" => $row['id'] ?? null,
            "amount" => $row['amount'],
            "message" => $row['message'],
            "wallet_status" => $row['wallet_status'],
            "earned_amount" => $row['earned_amount'],
            "used_amount" => $row['used_amount'],
            "earned_on" => $row['earned_on'],
            "used_on" => $row['used_on'],
            "balance" => $row['balance'],
            "created_date" => $row['created_date'],
            "created_date_text" => date("d M Y h:i A", strtotime($row['created_date']))
        ];
    }
    
    return $data;
}
?>