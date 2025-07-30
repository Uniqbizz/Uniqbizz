<?php
require '../../connect.php';

$designation = $_POST['designation'] ?? '';
$month_year = $_POST['month_year'] ?? date('Y-m'); // Default to current YYYY-MM if empty
$user_id = $_POST['user_id'] ?? '';
$payout_type = $_POST['payout_type'] ?? '';

$response = [];

// Table mapping for different designations
$tableMapping = [
    'bm'  => ['table' => 'bm_payout_history', 'user_col' => 'bm_user_id', 'message_col' => 'message_bm'],
    'bdm' => ['table' => 'bdm_payout_history', 'user_col' => 'bdm_user_id', 'message_col' => 'message_bdm'],
    'bcm' => ['table' => 'bcm_payout_history', 'user_col' => 'bcm_user_id', 'message_col' => 'message_bcm']
];

if ($designation && isset($tableMapping[$designation])) {
    $table = $tableMapping[$designation]['table'];
    $user_col = $tableMapping[$designation]['user_col'];
    $message_col = $tableMapping[$designation]['message_col'];

    // Include ca_user_id only for BM
    $ca_user_id_select = ($designation == 'bm') ? "p.ca_user_id," : ""; 

    // Monthly Payout Query
    if ($payout_type == 'monthly' && !empty($month_year)) {
        list($year, $month) = explode('-', $month_year);
        $year = (int) $year;
        $month = (int) $month;

        $stmt = $conn->prepare("
            SELECT 
                p.id,
                p.release_date,
                p.paymentid,
                p.payment_message,
                p.$user_col AS user_id, 
                $ca_user_id_select
                p.payout_amount,
                p.payout_status,
                p.$message_col AS message,
                ROUND(p.payout_amount * 0.02, 2) AS tds, 
                ROUND(p.payout_amount - (p.payout_amount * 0.02), 2) AS total
            FROM $table p
            WHERE p.$user_col = ? 
            AND MONTH(p.payout_date) = ? 
            AND YEAR(p.payout_date) = ?
        ");
        $stmt->execute([$user_id, $month, $year]);

    } else { // View All Payout Query
        $stmt = $conn->prepare("
            SELECT 
                p.id,
                p.$user_col AS user_id, 
                $ca_user_id_select
                p.payout_amount,
                p.payout_status,
                p.$message_col AS message,
                ROUND(p.payout_amount * 0.02, 2) AS tds, 
                ROUND(p.payout_amount - (p.payout_amount * 0.02), 2) AS total
            FROM $table p
            WHERE p.$user_col = ? 
        ");
        $stmt->execute([$user_id]);
    }

    $response = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Return JSON response
echo json_encode($response);
?>
