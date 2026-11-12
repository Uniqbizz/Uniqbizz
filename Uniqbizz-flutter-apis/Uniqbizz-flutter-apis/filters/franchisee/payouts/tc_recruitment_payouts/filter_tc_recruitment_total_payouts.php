<?php
header('Content-Type: application/json');
require '../../../../connect.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit();
}

$request = json_decode(file_get_contents('php://input'), true);

if (!is_array($request)) {
    echo json_encode([
        'status' => false,
        'message' => 'Invalid JSON body'
    ]);
    exit;
}

$userId = $request['userId'] ?? '';
$search = trim($request['search'] ?? '');
$year   = $request['year'] ?? null;
$month  = $request['month'] ?? null;

if (!$userId) {
    echo json_encode([
        "status" => false,
        "message" => "Missing user_id"
    ]);
    exit;
}

$isAllTime = empty($year) && empty($month);

// Validate user
$checkStmt = $conn->prepare("
    SELECT 1 
    FROM ca_travelagency 
    WHERE reference_no = :user_ref 
    LIMIT 1
");
$checkStmt->execute([':user_ref' => $userId]);

if (!$checkStmt->fetchColumn()) {
    echo json_encode([
        "status" => false,
        "message" => "franchisee id invalid"
    ]);
    exit;
}

$designation = 'techno_enterprise';
$commision = 'commision_te';

$response = [
    'success' => false,
    'count' => 0,
    'data' => [],
    'message' => ''
];

try {

    // Detect message column
    $user_id_str = substr($userId, 0, 1) == 'F' ? substr($userId, 0, 1) : substr($userId, 0, 2);

    if ($user_id_str == 'MF' || $user_id_str == 'SF' || $user_id_str == 'BM') {
        $messageCol = "message_bm";
    } else if ($user_id_str == 'F' || $user_id_str == 'CA' || $user_id_str == 'TE') {
        $messageCol = "message_te";
    } else {
        $messageCol = "message_tc";
    }

    // =========================
    // WHERE CLAUSE
    // =========================
    $where = ["ca.$designation = :user_id"];

    if (!$isAllTime) {
        $where[] = "YEAR(ca.created_date) = :year";
        $where[] = "MONTH(ca.created_date) = :month";
    }

    if (!empty($search)) {
        $where[] = "(
            ca.$messageCol LIKE :search OR
            ca.id LIKE :search OR
            DATE(ca.created_date) LIKE :search OR
            CAST(ca.$commision AS CHAR) LIKE :search OR
            CAST((ca.$commision * 0.02) AS CHAR) LIKE :search OR
            CAST((ca.$commision - (ca.$commision * 0.02)) AS CHAR) LIKE :search
        )";
    }

    $whereSql = implode(" AND ", $where);

    $sql = "
        SELECT 
            ca.id,
            ca.created_date,
            ca.status,
            ca.$messageCol,
            ca.$commision
        FROM ca_ta_payout ca
        WHERE $whereSql
        ORDER BY ca.id DESC
    ";

    $stmt = $conn->prepare($sql);

    $stmt->bindValue(':user_id', $userId);

    if (!$isAllTime) {
        $stmt->bindValue(':year', $year);
        $stmt->bindValue(':month', $month);
    }

    if (!empty($search)) {
        $stmt->bindValue(':search', '%' . $search . '%');
    }

    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $payoutRecords = [];
    $totalPayout = 0;

    foreach ($rows as $row) {

        $dt = (new DateTime($row['created_date']))->format('Y-m-d');

        $messageText = str_replace('.', " ", $row[$messageCol] ?? '');

        $amount = (float)$row[$commision];
        $tds = $amount * 0.02;
        $total = $amount - $tds;

        $payoutRecords[] = [
            'id' => $row['id'],
            'date' => $dt,
            'payout_details' => $messageText,
            'amount' => $amount,
            'tds' => $tds,
            'totalPayable' => $total,
            'status' => $row['status'] == '1' ? 'Paid' : 'Pending'
        ];

        $totalPayout += $amount;
    }

    if (empty($payoutRecords)) {
        echo json_encode([
            'success' => true,
            'count' => 0,
            'data' => [],
            'message' => $isAllTime 
                ? 'No records found'
                : 'No records found for this month'
        ], JSON_PRETTY_PRINT);
        exit;
    }

    $response['success'] = true;
    $response['count'] = count($payoutRecords);
    $response['data'] = $payoutRecords;
    $response['message'] = 'Results found';

} catch (Exception $e) {

    $response['message'] = 'Error: ' . $e->getMessage();
}

echo json_encode($response, JSON_PRETTY_PRINT);
?>