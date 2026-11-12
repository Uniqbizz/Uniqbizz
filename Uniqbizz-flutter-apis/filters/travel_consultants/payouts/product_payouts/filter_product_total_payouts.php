<?php
require '../../../../connect.php';
header('Content-Type: application/json');

$request = json_decode(file_get_contents('php://input'), true);

// ✅ INPUT (as you requested)
$userId = $request['id'] ?? null;
$search = trim($request['search'] ?? '');
$month  = isset($request['month']) ? (int)$request['month'] : null;
$year   = isset($request['year']) ? (int)$request['year'] : null;

// 🔥 FORCE userType = 11
$userType = '11';

$tdsPercentage = 2 / 100;
$isAllTime = empty($month) && empty($year);

$response = [
    'status' => 'error',
    'message' => '',
    'month' => $month,
    'year' => $year,
    'data' => []
];

function truncateToTwoDecimals($num) {
    return floor($num * 100) / 100;
}

try {

    if (!$userId) {
        throw new Exception("Missing id");
    }

    // 🔥 FIXED FOR TA ONLY
    $col = 'ta';

    // ✅ WHERE
    $where = "p.ta_id = :userId";

    if (!$isAllTime) {
        $where .= " AND YEAR(p.created_date) = :year AND MONTH(p.created_date) = :month";
    }

    // 🔥 SEARCH SETUP
    $searchLower = strtolower(trim($search));
    $isNumeric = is_numeric($searchLower);

    // ✅ MAIN QUERY
    $sql = "
        SELECT 
            p.*,
            pkg.name AS package_name,
            cu.firstname,
            cu.lastname
        FROM product_payout p
        LEFT JOIN package pkg ON pkg.id = p.package_id
        LEFT JOIN ca_customer cu ON cu.ca_customer_id = p.cu_id
        WHERE $where
    ";

    // 🔹 TEXT SEARCH ONLY (NOT numeric)
    if ($searchLower !== '' && !$isNumeric) {
        $sql .= " AND (
            LOWER(p.ta_mess) LIKE :search OR
            LOWER(pkg.name) LIKE :search OR
            LOWER(cu.firstname) LIKE :search OR
            LOWER(cu.lastname) LIKE :search OR
            CASE 
                WHEN p.ta_status = '1' THEN 'paid'
                ELSE 'pending'
            END LIKE :search
        )";
    }

    $sql .= " ORDER BY p.created_date DESC";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':userId', $userId);

    if (!$isAllTime) {
        $stmt->bindParam(':year', $year);
        $stmt->bindParam(':month', $month);
    }

    if ($searchLower !== '' && !$isNumeric) {
        $searchParam = "%" . $searchLower . "%";
        $stmt->bindParam(':search', $searchParam);
    }

    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $transactions = [];
    $totalPayout = 0;

    foreach ($rows as $row) {

        $dt = (new DateTime($row['created_date']))->format('Y-m-d');

        $packageName = $row['package_name'] ?? 'Unknown Package';
        $customerName = trim(($row['firstname'] ?? '') . ' ' . ($row['lastname'] ?? ''));

        // ✅ YOUR ORIGINAL LOGIC (UNCHANGED)
        $amt = $row['ta_amt'] + $row['ta_markup'];
        $message = $row['ta_mess'];
        $status = $row['ta_status'];

        $amt = (float)$amt;
        $tds = $amt * $tdsPercentage;
        $payable = truncateToTwoDecimals($amt - $tds);

        $statusText = ($status == '1') ? 'Paid' : 'Pending';

        // 🔥 FINAL SEARCH (handles computed fields)
        if ($searchLower !== '') {

            $fullMessage = strtolower(
                $message . " on selling " . $packageName .
                " Package to " . $customerName .
                " | Adults: " . $row['no_of_adult'] .
                " | Children: " . $row['no_of_child']
            );

            $statusLower = strtolower($statusText);

            $match = false;

            // TEXT
            if (
                strpos($fullMessage, $searchLower) !== false ||
                strpos($statusLower, $searchLower) !== false
            ) {
                $match = true;
            }

            // NUMERIC (tds, total, amount)
            if (!$match && $isNumeric) {
                $num = (float)$searchLower;

                if (
                    $tds == $num ||
                    $amt == $num ||
                    $payable == $num ||
                    $row['ta_markup'] == $num
                ) {
                    $match = true;
                }
            }

            if (!$match) continue;
        }

        $txn = [
            'date' => $dt,
            'packageName' => $packageName,
            'customerName' => $customerName,
            'noOfAdults' => $row['no_of_adult'],
            'noOfChildren' => $row['no_of_child'],
            'message' => $message,
            'amount' => $amt,
            'tds' => $tds,
            'totalPayable' => $payable,
            'status' => $statusText,
            'markup' => $row['ta_markup']
        ];

        $transactions[] = $txn;
        $totalPayout += $amt;
    }

    // ✅ TOTALS (UNCHANGED)
    $totalTDS = $totalPayout * $tdsPercentage;
    $finalPayout = truncateToTwoDecimals($totalPayout - $totalTDS);

    $response['status'] = 'success';
    $response['message'] = 'Filtered payouts fetched successfully';

    $response['data'] = [
        'userId' => $userId,
        'totalAmount' => (float)$totalPayout,
        'totalTDS' => (float)$totalTDS,
        'totalPayable' => (float)$finalPayout,
        'transactions' => $transactions
    ];

} catch (Exception $e) {
    $response['message'] = $e->getMessage();
}

echo json_encode($response, JSON_PRETTY_PRINT);