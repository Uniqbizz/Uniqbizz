<?php
header("Content-Type: application/json");
require '../../../../connect.php';

$request = json_decode(file_get_contents('php://input'), true);

// Inputs
$userId = $request['user_id'] ?? '';
$search = trim($request['search'] ?? '');
$month  = isset($request['month']) ? (int)$request['month'] : null;
$year   = isset($request['year']) ? (int)$request['year'] : null;

$tdsPercentage = 2 / 100;

if (!$userId) {
    echo json_encode(["status" => "error", "message" => "id required"]);
    exit;
}

// Helper
function truncateToTwoDecimals($num) {
    return floor($num * 100) / 100;
}

try {

    // 🔥 FORCE userType = 11 (TA)
    $userIdCommi = 'ta_id';

    // 🔹 BASE QUERY
    $sql = "SELECT 
                pp.*,
                p.name AS package_name,
                CONCAT(c.firstname, ' ', c.lastname) AS customer_name
            FROM product_payout pp
            LEFT JOIN package p ON p.id = pp.package_id
            LEFT JOIN ca_customer c ON c.ca_customer_id = pp.cu_id
            WHERE pp.ta_id = :userId";

    $params = [':userId' => $userId];

    // 🔹 MONTH + YEAR FILTER
    if ($month && $year) {
        $sql .= " AND YEAR(pp.created_date) = :year AND MONTH(pp.created_date) = :month";
        $params[':year'] = $year;
        $params[':month'] = $month;
    }

    // 🔹 TEXT SEARCH ONLY (NOT numeric)
    $searchLower = strtolower(trim($search));
    $isNumeric = is_numeric($searchLower);

    if ($searchLower !== '' && !$isNumeric) {
        $sql .= " AND (
            LOWER(pp.ta_mess) LIKE :search OR
            LOWER(p.name) LIKE :search OR
            LOWER(c.firstname) LIKE :search OR
            LOWER(c.lastname) LIKE :search OR
            CASE 
                WHEN pp.ta_status = '1' THEN 'paid'
                ELSE 'pending'
            END LIKE :search
        )";

        $params[':search'] = "%" . $searchLower . "%";
    }

    $sql .= " ORDER BY pp.id DESC";

    $stmt = $conn->prepare($sql);
    $stmt->execute($params);

    $transactions = [];
    $totalAmount = 0;

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

        $dt = new DateTime($row['created_date']);
        $date = $dt->format('Y-m-d');

        $packageName = $row['package_name'] ?? 'Unknown';
        $cuName = $row['customer_name'] ?? '';

        // TA logic (unchanged)
        $message = $row['ta_mess'];
        $amt = (float)$row['ta_amt'];
        $status = $row['ta_status'];
        $markup = (float)$row['ta_markup'];

        $tds = $amt * $tdsPercentage;
        $total = truncateToTwoDecimals($amt - $tds);

        $statusText = ($status == '1') ? 'Paid' : 'Pending';

        // 🔥 FINAL SEARCH (handles computed fields)
        if ($searchLower !== '') {

            $fullMessage = strtolower(
                $message . " on selling " . $packageName .
                " Package to " . $cuName .
                " | Adults: " . $row['no_of_adult'] .
                " | Children: " . $row['no_of_child']
            );

            $statusTextLower = strtolower($statusText);

            $match = false;

            // TEXT match
            if (
                strpos($fullMessage, $searchLower) !== false ||
                strpos($statusTextLower, $searchLower) !== false
            ) {
                $match = true;
            }

            // NUMERIC match (tds, total, amount, markup)
            if (!$match && $isNumeric) {
                $num = (float)$searchLower;

                if (
                    $tds == $num ||
                    $total == $num ||
                    $amt == $num ||
                    $markup == $num
                ) {
                    $match = true;
                }
            }

            if (!$match) continue;
        }

        $transaction = [
            'date' => $date,
            'packageName' => $packageName,
            'customerName' => $cuName,
            'noOfAdults' => $row['no_of_adult'],
            'noOfChildren' => $row['no_of_child'],
            'message' => $message,
            'amount' => $amt,
            'tds' => $tds,
            'totalPayable' => $total,
            'status' => $statusText,
            'markup' => $markup
        ];

        $transactions[] = $transaction;
        $totalAmount += $amt;
    }

    $totalTDS = $totalAmount * $tdsPercentage;
    $totalPayable = truncateToTwoDecimals($totalAmount - $totalTDS);

    echo json_encode([
        'status' => 'success',
        'data' => [
            'totalAmount' => $totalAmount,
            'totalTDS' => $totalTDS,
            'totalPayable' => $totalPayable,
            'transactions' => $transactions
        ]
    ]);

} catch (Exception $e) {
    echo json_encode([
        'status' => 'error',
        'message' => $e->getMessage()
    ]);
}