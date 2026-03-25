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
$search = $request['search'] ?? '';
$year   = $request['year'] ?? null;
$month  = $request['month'] ?? null;

if (!$userId) {
    echo json_encode([
        "status" => false,
        "message" => "Missing user_id"
    ]);
    exit;
}

if (!$year || !$month) {
    echo json_encode([
        "status" => false,
        "message" => "year and month required"
    ]);
    exit;
}

$checkStmt = $conn->prepare("
    SELECT 1 
    FROM ca_travelagency 
    WHERE reference_no = :user_ref 
    LIMIT 1
");

$checkStmt->bindValue(':user_ref', $userId, PDO::PARAM_STR);
$checkStmt->execute();

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

    $user_id_str = substr($userId, 0, 1) == 'F' ? substr($userId, 0, 1) : substr($userId, 0, 2);

    if ($user_id_str == 'MF' || $user_id_str == 'SF' || $user_id_str == 'BM') {
        $message = "message_bm";
    } else if ($user_id_str == 'F' || $user_id_str == 'CA' || $user_id_str == 'TE') {
        $message = "message_te";
    } else if ($user_id_str == 'TA') {
        $message = "message_tc";
    } else {
        $message = "message_te";
    }

    /*
    ------------------------------------------------
    ONLY CHANGE: month + year filter
    ------------------------------------------------
    */

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
            cap.status,
            cap.date AS paydate
        FROM ca_cu_payout ca
        LEFT JOIN ca_cu_payout_paid cap 
            ON cap.$designation = ca.$designation 
            AND cap.travel_consultant = ca.travel_consultant
        WHERE ca.$designation = :user_id
        AND YEAR(ca.created_date) = :year
        AND MONTH(ca.created_date) = :month
        ORDER BY ca.id DESC
    ";

    $model2 = $conn->prepare($sql);

    $model2->bindParam(':user_id', $userId);
    $model2->bindParam(':year', $year);
    $model2->bindParam(':month', $month);

    $model2->execute();
    $model2->setFetchMode(PDO::FETCH_ASSOC);

    $payoutRecords = [];
    $totalPayout = 0;

    if ($model2->rowCount() > 0) {

        foreach ($model2->fetchAll() as $row) {

            $dt = new DateTime($row['created_date']);
            $dt = $dt->format('Y-m-d');

            $messageText = str_replace('.', " ", $row[$message] ?? '');

            $Commision = floatval($row[$commision] ?? 0);
            $CommisionTDS = $Commision * 2 / 100;
            $CommisionTotal = $Commision - $CommisionTDS;

            $status = $row['status'] ?? '0';

            $record = [
                'id' => $row['id'],
                'date' => $dt,
                'payout_details' => $messageText,
                'amount' => $Commision,
                'tds' => $CommisionTDS,
                'totalPayable' => $CommisionTotal,
                'status' => $status == '1' ? 'Paid' : 'Pending'
            ];

            $payoutRecords[] = $record;
            $totalPayout += $Commision;
        }
    }

    if (count($payoutRecords) === 0) {

        echo json_encode([
            'success' => true,
            'count' => 0,
            'data' => [],
            'message' => 'No records found for this month'
        ], JSON_PRETTY_PRINT);

        exit;
    }

    /*
    ------------------------------------------------
    SEARCH LOGIC (UNCHANGED)
    ------------------------------------------------
    */

    if (!empty($search)) {

        $filteredRecords = array_filter($payoutRecords, function($record) use ($search) {

            $searchLower = strtolower($search);

            return
                stripos($record['payout_details'], $searchLower) !== false ||
                stripos($record['status'], $searchLower) !== false ||
                stripos($record['date'], $searchLower) !== false ||
                stripos((string)$record['amount'], $searchLower) !== false ||
                stripos((string)$record['tds'], $searchLower) !== false ||
                stripos((string)$record['totalPayable'], $searchLower) !== false ||
                stripos((string)$record['id'], $searchLower) !== false;
        });

        $payoutRecords = array_values($filteredRecords);

        $totalPayout = array_sum(array_column($payoutRecords, 'amount'));

        if (count($payoutRecords) === 0) {

            echo json_encode([
                'success' => true,
                'count' => 0,
                'data' => [],
                'message' => 'No matching results found for your search criteria'
            ], JSON_PRETTY_PRINT);

            exit;
        }
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