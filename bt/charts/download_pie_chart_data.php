<?php
require '../connect.php';

$year = $_POST['year'] ?? '';
$month = $_POST['month'] ?? '';
$type = $_POST['type'] ?? 'all';

$filterQuery = '';
$params = [];

$useDateFilter = !empty($month) && !empty($year);
if ($useDateFilter) {
    $start_date = "$year-$month-01";
    $end_date = date("Y-m-t", strtotime($start_date));
    $filterQuery = " AND DATE(created_date) BETWEEN ? AND ?";
    $dateParams = [$start_date, $end_date];
} else {
    $dateParams = [];
}

$rows = [];
$data = [];

if ($type === 'te') {
    $sql1 = "SELECT created_date, message_te AS details, commision_te AS amount, status_te AS status FROM ca_cu_payout";
    $sql2 = "SELECT created_date, message_te AS details, commision_te AS amount, status_te AS status FROM ca_ta_payout";
    if ($useDateFilter) {
        $sql1 .= " WHERE DATE(created_date) BETWEEN ? AND ?";
        $sql2 .= " WHERE DATE(created_date) BETWEEN ? AND ?";
    }

    $stmt1 = $conn->prepare($sql1);
    $stmt2 = $conn->prepare($sql2);
    $stmt1->execute($dateParams);
    $stmt2->execute($dateParams);

    $rows = array_merge($stmt1->fetchAll(PDO::FETCH_ASSOC), $stmt2->fetchAll(PDO::FETCH_ASSOC));

} elseif ($type === 'bm') {
    $sqls = [
        "SELECT created_date, '' AS details, comm_amt AS amount, status FROM ca_payout",
        "SELECT created_date, '' AS details, CASE WHEN status = 1 THEN comm_amtTotal ELSE comm_amt END AS amount, status FROM goa_bm_payout",
        "SELECT payout_date AS created_date, '' AS details, payout_amount AS amount, payout_status AS status FROM bm_payout_history",
        "SELECT created_date, message_bm AS details, commision_bm AS amount, status_bm AS status FROM ca_cu_payout",
        "SELECT created_date, message_bm AS details, commision_bm AS amount, status_bm AS status FROM ca_ta_payout"
    ];
    $dateColumns = ['created_date', 'created_date', 'payout_date', 'created_date', 'created_date'];

    for ($i = 0; $i < count($sqls); $i++) {
        $sql = $sqls[$i];
        if ($useDateFilter) {
            $sql .= " WHERE DATE(" . $dateColumns[$i] . ") BETWEEN ? AND ?";
        }
        $stmt = $conn->prepare($sql);
        $stmt->execute($dateParams);
        $rows = array_merge($rows, $stmt->fetchAll(PDO::FETCH_ASSOC));
    }

} elseif ($type === 'customer') {
    $sql = "SELECT added_on AS created_date, '' AS details, paid_amount AS amount, status FROM ca_customer WHERE 1=1";
    if ($useDateFilter) {
        $sql .= " AND MONTH(added_on) = :month AND YEAR(added_on) = :year";
        $stmt = $conn->prepare($sql);
        $stmt->execute([':month' => $month, ':year' => $year]);
    } else {
        $stmt = $conn->prepare($sql);
        $stmt->execute();
    }

    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

} elseif ($type === 'tc') {
    $sql = "SELECT created_date, message_tc AS details, commision_tc AS amount, status_tc AS status FROM ca_cu_payout";
    if ($useDateFilter) {
        $sql .= " WHERE DATE(created_date) BETWEEN ? AND ?";
    }

    $stmt = $conn->prepare($sql);
    $stmt->execute($dateParams);
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Set CSV headers
header('Content-Type: text/csv');
header("Content-Disposition: attachment; filename=\"{$type}_payout_data.csv\"");

// Output CSV
$output = fopen("php://output", "w");
fputcsv($output, ['Date', 'Payout Details', 'Amount', 'TDS', 'Total Payable', 'Remark']);

foreach ($rows as $row) {
    $date = $row['created_date'] ?? '';
    $details = $row['details'] ?? '';
    $amount = (float)($row['amount'] ?? 0);
    $tds = round($amount * 0.02, 2);
    $total = round($amount - $tds, 2);
    $status = $row['status'] ?? 0;

    $remark = ($status == 1) ? 'Paid' : (($status == 2) ? 'Pending' : 'Unknown');

    fputcsv($output, [$date, $details, $amount, $tds, $total, $remark]);
}
fclose($output);
exit;
