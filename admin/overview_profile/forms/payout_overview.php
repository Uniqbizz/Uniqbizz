<?php
require '../../connect.php';

// Receive POST data
$id = $_POST['id'] ?? '';
$DBtable = $_POST['DBtable'] ?? '';
$user_type = $_POST['user_type'] ?? '';
$start_date = $_POST['start_date'] ?? '';
$end_date = $_POST['end_date'] ?? '';

// Default to current month if no dates provided
if (empty($start_date) || empty($end_date)) {
    $start_date = date('Y-m-01');
    $end_date = date('Y-m-t');
}

$dateFilter = " AND created_date BETWEEN '$start_date' AND '$end_date'";

$sqlUnion = '';

if ($DBtable == 'business_developement_manager' || $DBtable == 'business_chanel_manager' || $DBtable == 'relationship_manager' ) {
    if ($user_type == 24) {
        $sqlUnion = "SELECT 'BCM Payout' AS title, bcm_user_id, message_bcm AS message, payout_amount AS amount, payout_date AS date, payout_status AS status
                     FROM bcm_payout_history WHERE bcm_user_id = '$id' AND payout_date BETWEEN '$start_date' AND '$end_date'
                     UNION 
                     SELECT 'Product Payout' AS title, bch_id, bch_mess AS message, bch_amt AS amount, created_date AS date, bch_status AS status
                     FROM product_payout WHERE bch_id = '$id' $dateFilter
                     ORDER BY date DESC";
    } elseif ($user_type == 25 || $user_type == 31) {
        $sqlUnion = "SELECT 'BDM Payout' AS title, bdm_user_id, message_bdm AS message, payout_amount AS amount, payout_date AS date, payout_status AS status
                     FROM bdm_payout_history WHERE bdm_user_id = '$id' AND payout_date BETWEEN '$start_date' AND '$end_date'
                     UNION 
                     SELECT 'CU Payout' AS title, business_development_manager, message_bdm AS message, commision_bdm AS amount, created_date AS date, status_bdm AS status
                     FROM ca_cu_payout WHERE business_development_manager = '$id' and commision_bdm!=0 $dateFilter
                     UNION 
                     SELECT 'Product Payout' AS title, bdm_id, bdm_mess AS message, bdm_amt AS amount, created_date AS date, bdm_status AS status
                     FROM product_payout WHERE bdm_id = '$id' $dateFilter
                     ORDER BY date DESC";
    }
} 
elseif ($DBtable == 'zonal_manager') {
        $sqlUnion = "SELECT 'ZM Payout' AS title, zonal_manager, message_zm AS message, commision_zm AS amount, created_date AS date, status_zm AS status
                     FROM sub_franchisee_payout WHERE zonal_manager = '$id' AND created_date BETWEEN '$start_date' AND '$end_date'
                     UNION 
                     SELECT 'CU Payout' AS title, business_development_manager, message_bdm AS message, commision_bdm AS amount, created_date AS date, status_bdm AS status
                     FROM ca_cu_payout WHERE business_development_manager = '$id' and commision_bdm!=0 $dateFilter
                     UNION 
                     SELECT 'Product Payout' AS title, bdm_id, bdm_mess AS message, bdm_amt AS amount, created_date AS date, bdm_status AS status
                     FROM product_payout WHERE bdm_id = '$id' $dateFilter
                     ORDER BY date DESC";//need to check for product payout
} 
elseif ($DBtable == 'business_mentor') {
    $sqlUnion = "SELECT 'BM Payout' AS title, bm_user_id, message_bm AS message, payout_amount AS amount, payout_date AS date, payout_status AS status
                 FROM bm_payout_history WHERE bm_user_id = '$id' AND payout_date BETWEEN '$start_date' AND '$end_date'
                 UNION 
                 SELECT 'TC Payout' AS title, business_mentor, message_bm AS message, commision_bm AS amount, created_date AS date, status_bm AS status
                 FROM ca_ta_payout WHERE business_mentor = '$id' $dateFilter
                 UNION 
                 SELECT 'CU Payout' AS title, business_mentor, message_bm AS message, commision_bm AS amount, created_date AS date, status_bm AS status
                 FROM ca_cu_payout WHERE business_mentor = '$id' $dateFilter
                 UNION 
                 SELECT 'Product Payout' AS title, bm_id, bm_mess AS message, bm_amt AS amount, created_date AS date, bm_status AS status
                 FROM product_payout WHERE bm_id = '$id' $dateFilter
                 ORDER BY date DESC";
} 
elseif ($DBtable == 'mastert_franchisee') {
    $sqlUnion = "SELECT 'MF Payout' AS title, master_franchisee, message_mf AS message, commision_mf AS amount, created_date AS date, status_mf AS status
                 FROM sub_franchisee_payout WHERE master_franchisee = '$id' AND created_date BETWEEN '$start_date' AND '$end_date'
                 UNION 
                 SELECT 'TC Payout' AS title, business_mentor, message_bm AS message, commision_bm AS amount, created_date AS date, status_bm AS status
                 FROM ca_ta_payout WHERE business_mentor = '$id' $dateFilter
                 UNION 
                 SELECT 'CU Payout' AS title, business_mentor, message_bm AS message, commision_bm AS amount, created_date AS date, status_bm AS status
                 FROM ca_cu_payout WHERE business_mentor = '$id' $dateFilter
                 UNION 
                 SELECT 'Product Payout' AS title, bm_id, bm_mess AS message, bm_amt AS amount, created_date AS date, bm_status AS status
                 FROM product_payout WHERE bm_id = '$id' $dateFilter
                 ORDER BY date DESC";
} 
elseif ($DBtable == 'corporate_agency') {
    $sqlUnion = "SELECT 'TC Payout' AS title, corporate_agency, message_ca AS message, commision_ca AS amount, created_date AS date, status_ca AS status
                 FROM ca_ta_payout WHERE corporate_agency = '$id' $dateFilter
                 UNION 
                 SELECT 'CU Payout' AS title, techno_enterprise, message_te AS message, commision_te AS amount, created_date AS date, status_te AS status
                 FROM ca_cu_payout WHERE techno_enterprise = '$id' $dateFilter
                 UNION 
                 SELECT 'Product Payout' AS title, te_id, te_mess AS message, te_amt AS amount, created_date AS date, te_status AS status
                 FROM product_payout WHERE te_id = '$id' $dateFilter
                 ORDER BY date DESC";
} 
elseif ($DBtable == 'sub_franchisee') {
    $sqlUnion = "SELECT 'TC Payout' AS title, techno_enterprise, message_te AS message, commision_te AS amount, created_date AS date, status_te AS status
                 FROM ca_ta_payout WHERE techno_enterprise = '$id' $dateFilter
                 UNION
                 SELECT 'CU Payout' AS title, techno_enterprise, message_te AS message, commision_te AS amount, created_date AS date, status_te AS status
                 FROM ca_cu_payout WHERE techno_enterprise = '$id' $dateFilter
                 UNION
                 SELECT 'Product Payout' AS title, te_id, te_mess AS message, te_amt AS amount, created_date AS date, te_status AS status
                 FROM product_payout WHERE te_id = '$id' $dateFilter
                 ORDER BY date DESC";
} 
elseif ($DBtable == 'ca_travelagency') {
    $sqlUnion = "SELECT 'CU Payout' AS title, travel_consultant, message_tc AS message, commision_tc AS amount, created_date AS date, status_tc AS status
                 FROM ca_cu_payout WHERE travel_consultant = '$id' $dateFilter
                 UNION 
                 SELECT 'Product Payout' AS title, ta_id, ta_mess AS message, ta_amt AS amount, created_date AS date, ta_status AS status
                 FROM product_payout WHERE ta_id = '$id' $dateFilter
                 ORDER BY date DESC";
} elseif ($DBtable == 'ca_customer') {
    $sqlUnion = "SELECT 'Product Payout cu1' AS title, cu1_id, cu1_mess AS message, cu1_amt AS amount, created_date AS date, cu1_status AS status
                 FROM product_payout WHERE cu1_id = '$id' $dateFilter
                 UNION 
                 SELECT 'Product Payout cu2' AS title, cu2_id, cu2_mess AS message, cu2_amt AS amount, created_date AS date, cu2_status AS status
                 FROM product_payout WHERE cu2_id = '$id' $dateFilter
                 UNION 
                 SELECT 'Product Payout cu3' AS title, cu3_id, cu3_mess AS message, cu3_amt AS amount, created_date AS date, cu3_status AS status
                 FROM product_payout WHERE cu3_id = '$id' $dateFilter
                 ORDER BY date DESC";
}

$stmt = $conn->prepare($sqlUnion);
$stmt->execute();
// print_r($stmt);
$stmt->setFetchMode(PDO::FETCH_ASSOC);

$tableHtml = '';
$totalCommission = 0;

if ($stmt->rowCount() > 0) {
    foreach ($stmt->fetchAll() as $row) {
        $cdate = (new DateTime($row['date']))->format('d-m-Y');
        $message = $row['message'];
        $amount = is_numeric($row['amount']) ? $row['amount'] : 0;//pending+paid
        //$amount = ($row['status'] == 1 && is_numeric($row['amount'])) ? $row['amount'] : 0;//only paid
        $tds = $amount * 0.02;
        $total = $amount - $tds;
        $totalCommission += $amount;

        $tableHtml .= '<tr>
            <td>' . $cdate . '</td>
            <td>' . $row['title'] . '</td>
            <td style="width: 350px;">' . $message . '</td>
            <td>' . $amount . '</td>
            <td>' . $tds . '</td>
            <td>' . $total . '</td>
            <td>';

        if ($row['status'] == 1) {
            $tableHtml .= '<span class="badge badge-pill badge-soft-success">Paid</span>';
        } elseif ($row['status'] == 2) {
            $tableHtml .= '<span class="badge badge-pill badge-soft-warning">Pending</span>';
        } elseif ($row['status'] == 3) {
            $tableHtml .= '<span class="badge badge-pill badge-soft-danger">Rejected</span>';
        }

        $tableHtml .= '</td></tr>';
    }
} else {
    $tableHtml .= '<tr><td></td><td></td><td></td><td>No data found for selected period.</td><td></td><td></td><td></td></tr>';
}

// JSON Output for HTML and total
header('Content-Type: application/json');
echo json_encode([
    'html' => $tableHtml,
    'total' => round($totalCommission, 2)
]);
exit;