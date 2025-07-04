<?php
require '../../connect.php';

$month_year = $_POST['month_year'] ?? date('Y-m'); // Default to current month
list($year, $month) = explode('-', $month_year);
$user_id = $_POST['user_id'] ?? '';
$designation = $_POST['designation'] ?? '';

$total_entries = 0;

if (!empty($user_id) && !empty($designation)) {
    if ($designation === 'bm') {
        // Get count for BM
        $stmt = $conn->prepare("
            SELECT COUNT(*) AS total_entries 
            FROM bm_payout_history 
            WHERE MONTH(payout_date) = ? 
              AND YEAR(payout_date) = ? 
              AND bm_user_id = ?
        ");
        $stmt->execute([$month, $year, $user_id]);
    } elseif ($designation === 'bdm') {
        // Get all BM IDs under this BDM
        $stmt = $conn->prepare("
            SELECT COUNT(*) AS total_entries 
            FROM bm_payout_history 
            WHERE MONTH(payout_date) = ? 
              AND YEAR(payout_date) = ? 
              AND bm_user_id IN (SELECT business_mentor_id FROM business_mentor WHERE reference_no = ?)
        ");
        $stmt->execute([$month, $year, $user_id]);
    } elseif ($designation === 'bcm') {
        // Get all BM IDs under this BCM (via BDM)
        $stmt = $conn->prepare("
            SELECT COUNT(*) AS total_entries 
            FROM bm_payout_history 
            WHERE MONTH(payout_date) = ? 
              AND YEAR(payout_date) = ? 
              AND bm_user_id IN (
                  SELECT business_mentor_id FROM business_mentor WHERE reference_no IN (
                      SELECT employee_id FROM employees WHERE reporting_manager IN (
                          SELECT employee_id FROM employees WHERE employee_id=? 
                      )
                    )
              )
        ");
        $stmt->execute([$month, $year, $user_id]);
    }

    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $total_entries = $result['total_entries'] ;
}

echo $total_entries;
?>
