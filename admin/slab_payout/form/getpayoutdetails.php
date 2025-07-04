<?php
require '../../connect.php';

$designation = $_POST['designation'] ?? '';
$month_year = $_POST['month_year'] ?? '';
if (empty($month_year)) {
    $month_year = date('Y-m'); // Gets current year and month (YYYY-MM)
}
$user_id = $_POST['user_id'] ?? '';
$payout_type = $_POST['payout_type'] ?? '';

$response = [];

// Table mapping for designation
$tableMapping = [
    'bm'  => ['table' => 'bm_payout_history', 'user_col' => 'bm_user_id', 'message_col' => 'message_bm'],
    'bdm' => ['table' => 'bdm_payout_history', 'user_col' => 'bdm_user_id', 'message_col' => 'message_bdm'],
    'bcm' => ['table' => 'bcm_payout_history', 'user_col' => 'bcm_user_id', 'message_col' => 'message_bcm']
];

if ($designation && isset($tableMapping[$designation])) {
    $table = $tableMapping[$designation]['table'];
    $user_col = $tableMapping[$designation]['user_col'];
    $message_col = $tableMapping[$designation]['message_col'];

    if ($payout_type == 'monthly' && $month_year) {
        list($year, $month) = explode('-', $month_year);
        $year = (int) $year;
        $month = (int) $month;
        if ($designation == 'bm') {
            $stmt = $conn->prepare("
                SELECT 
                    p.id,
                    p.$user_col AS user_id, 
                    p.ca_user_id,
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
        } else {

            $stmt = $conn->prepare("
                SELECT 
                    p.id,
                    p.$user_col AS user_id, 
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
        }
    } else {
        if ($designation == 'bm') {
            $stmt = $conn->prepare("
                SELECT 
                    p.id,
                    p.$user_col AS user_id, 
                    p.ca_user_id,
                    p.payout_amount,
                    p.payout_status,
                    p.$message_col AS message,
                    ROUND(p.payout_amount * 0.02, 2) AS tds, 
                    ROUND(p.payout_amount - (p.payout_amount * 0.02), 2) AS total
                FROM $table p
                WHERE p.$user_col = ? 
                
            ");
            $stmt->execute([$user_id]);
        } else {
            $stmt = $conn->prepare("
            SELECT 
                p.id,
                p.$user_col AS user_id, 
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
    }

    $response = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

echo json_encode($response);
