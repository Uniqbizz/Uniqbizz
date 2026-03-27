<?php
require '../../../../connect.php';

$request = json_decode(file_get_contents('php://input'), true);

$TotalYear = $request['year'] ?? null;
$TotalMonth = $request['month'] ?? null;
$user_id = $request['userId'] ?? null;

$designation = 'techno_enterprise';
$commision = 'commision_te';

$isAllTime = empty($TotalYear) && empty($TotalMonth);

// Detect message column (same logic)
$user_id_str = substr($user_id, 0, 1) == 'F' ? substr($user_id, 0, 1) : substr($user_id, 0, 2);

if ($user_id_str == 'MF' || $user_id_str == 'SF' || $user_id_str == 'BM') {
    $messageCol = "message_bm";
} else if ($user_id_str == 'F' || $user_id_str == 'CA' || $user_id_str == 'TE') {
    $messageCol = "message_te";
} else if ($user_id_str == 'TA') {
    $messageCol = "message_tc";
}

$response = [
    'success' => false,
    'message' => '',
    'totalPayout' => 0,
    'payoutRecords' => []
];

try {

    if (empty($user_id)) {
        throw new Exception("Missing userId");
    }

    // =========================
    // WHERE CLAUSE
    // =========================
    $where = "ca.$designation = :user_id";

    if (!$isAllTime) {
        $where .= " AND YEAR(ca.created_date) = :year AND MONTH(ca.created_date) = :month";
    }

    // =========================
    // TOTAL PAYOUT
    // =========================
    $totalSql = "
        SELECT SUM($commision) as TotalPayout 
        FROM ca_cu_payout ca
        WHERE $where
    ";

    $totalStmt = $conn->prepare($totalSql);
    $totalStmt->bindParam(':user_id', $user_id);

    if (!$isAllTime) {
        $totalStmt->bindParam(':year', $TotalYear);
        $totalStmt->bindParam(':month', $TotalMonth);
    }

    $totalStmt->execute();
    $totalResult = $totalStmt->fetch(PDO::FETCH_ASSOC);

    $TotalPayout = (float)($totalResult['TotalPayout'] ?? 0);

    // =========================
    // FETCH RECORDS
    // =========================
    $sql = "
        SELECT 
            ca.created_date,
            ca.status,
            ca.id,
            ca.message_bm,
            ca.message_te,
            ca.commision_te,
            ca.commision_bm,
            ca.travel_consultant,
            ca.message_tc,
            ca.commision_tc,
            ca.status_tc,
            cap.status AS paid_status,
            cap.date AS paydate
        FROM ca_cu_payout ca
        LEFT JOIN ca_cu_payout_paid cap 
            ON cap.$designation = ca.$designation 
            AND cap.travel_consultant = ca.travel_consultant
        WHERE $where
        ORDER BY ca.created_date DESC
    ";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':user_id', $user_id);

    if (!$isAllTime) {
        $stmt->bindParam(':year', $TotalYear);
        $stmt->bindParam(':month', $TotalMonth);
    }

    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $payoutRecords = [];

    foreach ($rows as $row) {

        $dt = (new DateTime($row['created_date']))->format('Y-m-d');

        // message formatting
        $msg = str_replace('.', " ", $row[$messageCol] ?? '');

        $Commision = (float)($row[$commision] ?? 0);
        $tds = $Commision * 0.02;
        $totalPayable = $Commision - $tds;

        $status = $row['status'];

        $payoutRecords[] = [
            'date' => $dt,
            'payout_details' => $msg,
            'amount' => $Commision,
            'tds' => $tds,
            'totalPayable' => $totalPayable,
            'status' => $status == '1' ? 'Paid' : 'Pending',
            'id' => $row['id'],
        ];
    }

    $response['success'] = true;
    $response['message'] = 'Data retrieved successfully';
    $response['totalPayout'] = $TotalPayout;
    $response['payoutRecords'] = $payoutRecords;

} catch (Exception $e) {
    $response['message'] = 'Error: ' . $e->getMessage();
}

echo json_encode($response, JSON_PRETTY_PRINT);
?>