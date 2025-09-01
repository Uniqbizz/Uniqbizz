<?php
require '../../../connect.php';

$designation = $_POST['designation'] ?? '';
$month_year = $_POST['month_year'] ?? '';
if (empty($month_year)) {
    $month_year = date('Y-m'); // Gets current year and month (YYYY-MM)
}
$user_id = $_POST['user_id'] ?? '';

$response = [
    'bm_list' => [],
    'bdm_list' => []
];

// Extract year and month
list($year, $month) = explode('-', $month_year);
$year = (int) $year;
$month = (int) $month;

// Fetch BMs if BDM is selected
if ($designation === 'bdm') {
    $stmt_bm = $conn->prepare("
        SELECT DISTINCT 
            bm.business_mentor_id AS user_id, 
            CONCAT(bm.firstname, ' ', bm.lastname) AS name,
            COALESCE(
                (SELECT COUNT(*) FROM bm_payout_history p 
                 WHERE p.bm_user_id = bm.business_mentor_id 
                 AND MONTH(p.payout_date) = ? 
                 AND YEAR(p.payout_date) = ?), 0
            ) AS active_te_count
        FROM business_mentor bm
        JOIN bm_payout_history p ON bm.business_mentor_id = p.bm_user_id
        WHERE bm.reference_no = ? 
        AND MONTH(p.payout_date) = ? 
        AND YEAR(p.payout_date) = ?
    ");
    $stmt_bm->execute([$month, $year, $user_id, $month, $year]);
    $response['bm_list'] = $stmt_bm->fetchAll(PDO::FETCH_ASSOC) ?: [];
}

// Fetch BMs & BDMs if BCM is selected
if ($designation === 'bcm') {
    // Fetch BDMs reporting to BCM
    $stmt_bdm = $conn->prepare("
        SELECT DISTINCT 
            e.employee_id AS user_id, 
            e.name, 
            COALESCE(
                (SELECT COUNT(*) FROM bm_payout_history p 
                 WHERE p.bm_user_id IN (
                     SELECT bm.business_mentor_id FROM business_mentor bm 
                     WHERE bm.reference_no = e.employee_id
                 ) 
                 AND MONTH(p.payout_date) = ? 
                 AND YEAR(p.payout_date) = ?), 0
            ) AS active_te_count
        FROM employees e
        JOIN bdm_payout_history p ON e.employee_id = p.bdm_user_id
        WHERE e.reporting_manager = ? 
        AND MONTH(p.payout_date) = ? 
        AND YEAR(p.payout_date) = ?
    ");
    $stmt_bdm->execute([$month, $year, $user_id, $month, $year]);
    $bdms = $stmt_bdm->fetchAll(PDO::FETCH_ASSOC) ?: [];
    $response['bdm_list'] = $bdms;

    // Fetch BMs under the fetched BDMs
    if (!empty($bdms)) {
        $bdm_ids = array_column($bdms, 'user_id'); // Get all BDM IDs
        $placeholders = implode(',', array_fill(0, count($bdm_ids), '?')); // Prepare SQL placeholders

        $stmt_bm = $conn->prepare("
            SELECT DISTINCT 
                bm.business_mentor_id AS user_id, 
                CONCAT(bm.firstname, ' ', bm.lastname) AS name,
                COALESCE(
                    (SELECT COUNT(*) FROM bm_payout_history p 
                     WHERE p.bm_user_id = bm.business_mentor_id 
                     AND MONTH(p.payout_date) = ? 
                     AND YEAR(p.payout_date) = ?), 0
                ) AS active_te_count
            FROM business_mentor bm
            JOIN bm_payout_history p ON bm.business_mentor_id = p.bm_user_id
            WHERE bm.reference_no IN ($placeholders)
            AND MONTH(p.payout_date) = ? 
            AND YEAR(p.payout_date) = ?
        ");
        $stmt_bm->execute(array_merge([$month, $year], $bdm_ids, [$month, $year]));
        $response['bm_list'] = $stmt_bm->fetchAll(PDO::FETCH_ASSOC) ?: [];
    }
}

echo json_encode($response);
?>
