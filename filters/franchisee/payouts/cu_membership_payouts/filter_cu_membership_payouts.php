<?php
require '../../../../connect.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['status'=>'error','message'=>'Method not allowed']);
    exit();
}

$request = json_decode(file_get_contents('php://input'), true);

if (!$request || !isset($request['userId'])) {
    echo json_encode([
        'status'=>'error',
        'message'=>'Missing userId'
    ]);
    exit;
}

$userId   = $request['userId'];
$search   = $request['search'] ?? '';
$fromDate = $request['fromDate'] ?? null;
$toDate   = $request['toDate'] ?? null;
$year     = $request['year'] ?? null;
$month    = $request['month'] ?? null;

$columnDesignation = 'techno_enterprise';
$columnMessage     = 'message_te';
$columnCommision   = 'commision_te';
$columnStatus      = 'status_te';

$tdsPercentage = 2/100;

try {

    $params = [$userId];
    $period = "";

    /*
    --------------------------------------------------
    DATE RANGE MODE
    --------------------------------------------------
    */

    if ($fromDate || $toDate) {

        $where = "WHERE ca.$columnDesignation = ?";

        if ($fromDate && $toDate) {
            $where .= " AND DATE(ca.created_date) BETWEEN ? AND ?";
            $params[] = $fromDate;
            $params[] = $toDate;

            $period = date('d M Y',strtotime($fromDate)) .
                      " - " .
                      date('d M Y',strtotime($toDate));
        }
        elseif ($fromDate) {

            $where .= " AND DATE(ca.created_date) >= ?";
            $params[] = $fromDate;

            $period = "From ".date('d M Y',strtotime($fromDate));
        }
        else {

            $where .= " AND DATE(ca.created_date) <= ?";
            $params[] = $toDate;

            $period = "Until ".date('d M Y',strtotime($toDate));
        }

    }

    /*
    --------------------------------------------------
    MONTH MODE
    --------------------------------------------------
    */

    else {

        if (!$year || !$month) {
            echo json_encode([
                'status'=>'error',
                'message'=>'year and month required'
            ]);
            exit;
        }

        $where = "WHERE ca.$columnDesignation = ?
                  AND YEAR(ca.created_date) = ?
                  AND MONTH(ca.created_date) = ?";

        $params[] = $year;
        $params[] = $month;

        $period = date("F Y",strtotime("$year-$month-01"));
    }

    /*
    --------------------------------------------------
    FETCH DATA
    --------------------------------------------------
    */

    $sql = "SELECT
                ca.id,
                ca.created_date,
                ca.$columnMessage,
                ca.$columnCommision,
                ca.$columnStatus
            FROM ca_cu_payout ca
            $where
            ORDER BY ca.id DESC";

    $stmt = $conn->prepare($sql);
    $stmt->execute($params);

    $transactions = [];

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

        $date = (new DateTime($row['created_date']))->format('Y-m-d');

        $commission = floatval($row[$columnCommision]);
        $tds = $commission * $tdsPercentage;
        $total = $commission - $tds;

        $transactions[] = [
            'id' => $row['id'],
            'date' => $date,
            'payout_details' => str_replace('.', ' ', $row[$columnMessage]),
            'amount' => $commission,
            'tds' => floatval($tds),
            'total_payable' => floatval($total),
            'status' => $row[$columnStatus] == '1' ? 'Paid' : 'Pending'
        ];
    }

    /*
    --------------------------------------------------
    SEARCH
    --------------------------------------------------
    */

    if (!empty($search)) {

        $transactions = array_filter($transactions,function($t) use ($search){

            $search = strtolower($search);

            return
                stripos($t['payout_details'],$search) !== false ||
                stripos($t['status'],$search) !== false ||
                stripos($t['date'],$search) !== false ||
                stripos((string)$t['amount'],$search) !== false ||
                stripos((string)$t['tds'],$search) !== false ||
                stripos((string)$t['total_payable'],$search) !== false ||
                stripos((string)$t['id'],$search) !== false;

        });

        $transactions = array_values($transactions);
    }

    /*
    --------------------------------------------------
    SUMMARY
    --------------------------------------------------
    */

    $totalAmount  = array_sum(array_column($transactions,'amount'));
    $totalTds     = array_sum(array_column($transactions,'tds'));
    $totalPayable = array_sum(array_column($transactions,'total_payable'));

    echo json_encode([
        'status'=>'success',
        'data'=>[
            'period'=>$period,
            'count'=>count($transactions),
            'total_payout'=>$totalAmount,
            'tds_amount'=>$totalTds,
            'total_payable'=>$totalPayable,
            'transactions'=>$transactions
        ]
    ],JSON_PRETTY_PRINT);

}
catch(Exception $e){

    http_response_code(500);

    echo json_encode([
        'status'=>'error',
        'message'=>$e->getMessage()
    ]);
}