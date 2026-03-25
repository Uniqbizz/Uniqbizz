<?php
header("Content-Type: application/json");
require '../../../../connect.php';

$request = json_decode(file_get_contents('php://input'), true);

// Inputs
$userId   = $request['user_id'] ?? '';
$search   = trim($request['search'] ?? '');
$fromDate = $request['from_date'] ?? '';
$toDate   = $request['to_date'] ?? '';

$tdsPercentage = 0.02;

if (!$userId) {
    echo json_encode(["status" => "error", "message" => "user_id required"]);
    exit;
}

/**
 * Normalize date (supports d-m-Y & Y-m-d)
 */
function normalizeDate($date) {
    if (!$date) return null;

    $d = DateTime::createFromFormat('Y-m-d', $date)
        ?: DateTime::createFromFormat('d-m-Y', $date);

    return $d ? $d->format('Y-m-d') : null;
}

$fromDate = normalizeDate($fromDate);
$toDate   = normalizeDate($toDate);

// 🔥 Detect search type
$searchLower = strtolower(trim($search));
$isNumericSearch = is_numeric($searchLower);


// ✅ BASE QUERY
$query = "SELECT 
            pp.*,
            p.name AS package_name,
            CONCAT(c.firstname, ' ', c.lastname) AS customer_name
          FROM product_payout pp
          LEFT JOIN package p ON p.id = pp.package_id
          LEFT JOIN ca_customer c ON c.ca_customer_id = pp.cu_id
          WHERE pp.ta_id = :uid";

$params = [':uid' => $userId];


// 🔹 DATE FILTER
if ($fromDate && !$toDate) {
    $query .= " AND pp.created_date >= :fromDate";
    $params[':fromDate'] = $fromDate . " 00:00:00";
}
elseif (!$fromDate && $toDate) {
    $query .= " AND pp.created_date <= :toDate";
    $params[':toDate'] = $toDate . " 23:59:59";
}
elseif ($fromDate && $toDate) {
    $query .= " AND pp.created_date BETWEEN :fromDate AND :toDate";
    $params[':fromDate'] = $fromDate . " 00:00:00";
    $params[':toDate']   = $toDate . " 23:59:59";
}


// 🔹 TEXT SEARCH (ONLY NON-NUMERIC)
if (!empty($searchLower) && !$isNumericSearch) {
    $query .= " AND (
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

$query .= " ORDER BY pp.id DESC";

$stmt = $conn->prepare($query);
$stmt->execute($params);

$data = [];

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

    $dt = (new DateTime($row['created_date']))->format('Y-m-d');

    $amt = (float)$row['ta_amt'];
    $status = $row['ta_status'];
    $ta_markup = (float)$row['ta_markup'];

    $tds = $amt * $tdsPercentage;
    $totalPayable = $amt - $tds;

    // 🔥 FINAL SEARCH FILTER (handles computed fields)
    if ($searchLower !== '') {

        $fullMessage = strtolower(
            $row['ta_mess'] . " on selling " . $row['package_name'] .
            " Package to " . $row['customer_name'] .
            " | Adults: " . $row['no_of_adult'] .
            " | Children: " . $row['no_of_child']
        );

        $statusText = strtolower(($status == '1') ? "paid" : "pending");

        $match = false;

        // 🔹 TEXT MATCH
        if (
            strpos($fullMessage, $searchLower) !== false ||
            strpos($statusText, $searchLower) !== false
        ) {
            $match = true;
        }

        // 🔹 NUMERIC MATCH (FIXES TDS ISSUE)
        if (!$match && is_numeric($searchLower)) {
            $searchNum = (float)$searchLower;

            if (
                $tds == $searchNum ||
                $amt == $searchNum ||
                $totalPayable == $searchNum ||
                $ta_markup == $searchNum
            ) {
                $match = true;
            }
        }

        if (!$match) {
            continue;
        }
    }

    $data[] = [
        "date" => $dt,
        "message" => $row['ta_mess'] . " on selling " . $row['package_name'] .
            " Package to " . $row['customer_name'] .
            " | Adults: " . $row['no_of_adult'] .
            " | Children: " . $row['no_of_child'],
        "markup" => $ta_markup,
        "amount" => $amt,
        "tds" => $tds,
        "total_payable" => $totalPayable,
        "status" => ($status == '1' ? "Paid" : "Pending")
    ];
}

echo json_encode([
    "status" => "success",
    "count" => count($data),
    "payouts" => $data
]);