<?php
require '../connect.php';

$year = $_POST['year'] ?? '';
$month = $_POST['month'] ?? '';
$type = $_POST['type'] ?? 'all';

$filterQuery = "";
$params = [];

$useDateFilter = !empty($month) && !empty($year);

if ($useDateFilter) {
    $filterQuery .= " AND MONTH(added_on) = :month AND YEAR(added_on) = :year ";
    $params[':month'] = $month;
    $params[':year'] = $year;

    $start_date = "$year-$month-01";
    $end_date = date("Y-m-t", strtotime($start_date));
} else {
    $start_date = '2000-01-01'; // fallback default
    $end_date = date("Y-m-d"); // current date
}

/** ================= TE ================= */
$unique_tes = [];
$te_paid = 0;
$te_pending = 0;

function processTE($rows) {
    global $unique_tes, $te_paid, $te_pending;
    foreach ($rows as $row) {
        $te_id = $row['techno_enterprise'];
        $amount = floatval($row['commision_te']);
        $status = $row['status_te'];
        $unique_tes[$te_id] = true;
        if ($status == 1) {
            $te_paid += $amount;
        } elseif ($status == 2) {
            $te_pending += $amount;
        }
    }
}

$sql1 = "SELECT techno_enterprise, commision_te, status_te FROM ca_cu_payout";
$sql2 = "SELECT techno_enterprise, commision_te, status_te FROM ca_ta_payout";
if ($useDateFilter) {
    $sql1 .= " WHERE DATE(created_date) BETWEEN ? AND ?";
    $sql2 .= " WHERE DATE(created_date) BETWEEN ? AND ?";
}

$stmt1 = $conn->prepare($sql1);
$stmt2 = $conn->prepare($sql2);
if ($useDateFilter) {
    $stmt1->execute([$start_date, $end_date]);
    $stmt2->execute([$start_date, $end_date]);
} else {
    $stmt1->execute();
    $stmt2->execute();
}
processTE($stmt1->fetchAll(PDO::FETCH_ASSOC));
processTE($stmt2->fetchAll(PDO::FETCH_ASSOC));
$total_unique_tes = count($unique_tes);

/** ================= BM ================= */
$all_bms = [];
$bm_paid = 0;
$bm_pending = 0;

function processResults($rows, $id_key, $amount_key, $status_key) {
    global $all_bms, $bm_paid, $bm_pending;
    foreach ($rows as $row) {
        $bm_id = $row[$id_key];
        $amount = floatval($row[$amount_key]);
        $status = $row[$status_key];
        $all_bms[$bm_id] = true;
        if ($status == 1) {
            $bm_paid += $amount;
        } elseif ($status == 2) {
            $bm_pending += $amount;
        }
    }
}

$bm_sqls = [
    ["SELECT business_mentor, comm_amt, status FROM ca_payout", "created_date"],
    ["SELECT bm_id, comm_amt, comm_amtTotal, status FROM goa_bm_payout", "created_date"],
    ["SELECT bm_user_id, payout_amount, payout_status FROM bm_payout_history", "payout_date"],
    ["SELECT business_mentor, commision_bm, status_bm FROM ca_cu_payout", "created_date"],
    ["SELECT business_mentor, commision_bm, status_bm FROM ca_ta_payout", "created_date"]
];

foreach ($bm_sqls as $index => [$sql, $date_col]) {
    if ($useDateFilter) {
        $sql .= " WHERE DATE($date_col) BETWEEN ? AND ?";
    }
    $stmt = $conn->prepare($sql);
    if ($useDateFilter) {
        $stmt->execute([$start_date, $end_date]);
    } else {
        $stmt->execute();
    }
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Special handling for goa_bm_payout (index 1)
    if ($index == 1) {
        foreach ($rows as $row) {
            $bm_id = $row['bm_id'];
            $status = $row['status'];
            $amount = ($status == 1) ? floatval($row['comm_amtTotal']) : floatval($row['comm_amt']);
            $all_bms[$bm_id] = true;
            if ($status == 1) {
                $bm_paid += $amount;
            } elseif ($status == 2) {
                $bm_pending += $amount;
            }
        }
    } else {
        $key_map = [
            0 => ['business_mentor', 'comm_amt', 'status'],
            2 => ['bm_user_id', 'payout_amount', 'payout_status'],
            3 => ['business_mentor', 'commision_bm', 'status_bm'],
            4 => ['business_mentor', 'commision_bm', 'status_bm']
        ];
        processResults($rows, ...$key_map[$index]);
    }
}
$total_unique_bms = count($all_bms);

/** ================= TC ================= */
$unique_tcs = [];
$tc_paid = 0;
$tc_pending = 0;

$sql = "SELECT travel_consultant, commision_tc, status_tc FROM ca_cu_payout";
if ($useDateFilter) {
    $sql .= " WHERE DATE(created_date) BETWEEN ? AND ?";
}
$stmt = $conn->prepare($sql);
if ($useDateFilter) {
    $stmt->execute([$start_date, $end_date]);
} else {
    $stmt->execute();
}
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
foreach ($result as $row) {
    $tc_id = $row['travel_consultant'];
    $amount = floatval($row['commision_tc']);
    $status = $row['status_tc'];
    $unique_tcs[$tc_id] = true;
    if ($status == 1) {
        $tc_paid += $amount;
    } elseif ($status == 2) {
        $tc_pending += $amount;
    }
}
$total_unique_tcs = count($unique_tcs);

/** ================= Customer ================= */
$sql_cust = $conn->prepare("
    SELECT 
        COUNT(ca_customer_id) AS total_customer,
        COALESCE(SUM(CASE WHEN status = 1 THEN paid_amount ELSE 0 END), 0) AS total_customer_paid,
        COALESCE(SUM(CASE WHEN status = 2 THEN paid_amount ELSE 0 END), 0) AS total_customer_pending
    FROM ca_customer 
    WHERE 1=1 $filterQuery");
$sql_cust->execute($params);
$customer = $sql_cust->fetch(PDO::FETCH_ASSOC);

/** ================= Final Aggregated Arrays ================= */
$te = [
    'total_te' => $total_unique_tes,
    'total_te_amount' => $te_paid + $te_pending,
    'total_te_pending' => $te_pending
];

$bm = [
    'total_bm' => $total_unique_bms,
    'total_bm_paid' => $bm_paid,
    'total_bm_pending' => $bm_pending
];

$tc = [
    'total_tc' => $total_unique_tcs,
    'total_tc_paid' => $tc_paid,
    'total_tc_pending' => $tc_pending
];

/** ================= Final JSON Response ================= */
$response = array(
    'total_te' => (int)$te['total_te'],
    'total_te_amount' => (float)$te['total_te_amount'],
    'total_te_pending' => (float)$te['total_te_pending'],

    'total_bm' => (int)$bm['total_bm'],
    'total_bm_paid' => (float)$bm['total_bm_paid'],
    'total_bm_pending' => (float)$bm['total_bm_pending'],

    'total_tc' => (int)$tc['total_tc'],
    'total_tc_paid' => (float)$tc['total_tc_paid'],
    'total_tc_pending' => (float)$tc['total_tc_pending'],

    'total_customer' => (int)$customer['total_customer'],
    'total_customer_paid' => (float)$customer['total_customer_paid'],
    'total_customer_pending' => (float)$customer['total_customer_pending'],
);

echo json_encode($response);
?>
