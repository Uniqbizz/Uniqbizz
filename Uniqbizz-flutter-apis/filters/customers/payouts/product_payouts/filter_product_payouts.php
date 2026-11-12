<?php

require '../../../../../connect.php';

header('Content-Type: application/json');

$request = json_decode(file_get_contents('php://input'), true);

$userId = $request['id'] ?? '';
$search = trim($request['search'] ?? '');
$month = $request['month'] ?? null;
$year = $request['year'] ?? null;

$response = [
    'status' => 'error',
    'message' => '',
    'data' => []
];

$tdsPercentage = 2 / 100;

function truncateToTwoDecimals($num)
{
    return floor($num * 100) / 100;
}

try {

    // ✅ SINGLE OPTIMIZED QUERY (NO INNER QUERIES)
    $sql = "
        SELECT 
            pp.*,
            p.name AS package_name,
            CONCAT(c.firstname, ' ', c.lastname) AS customer_name,
            CASE
                WHEN pp.cu1_id = :userId THEN 'Level_1'
                WHEN pp.cu2_id = :userId THEN 'Level_2'
                WHEN pp.cu3_id = :userId THEN 'Level_3'
            END AS user_level
        FROM product_payout pp
        LEFT JOIN package p ON p.id = pp.package_id
        LEFT JOIN ca_customer c ON c.ca_customer_id = pp.cu_id
        WHERE (pp.cu1_id = :userId OR pp.cu2_id = :userId OR pp.cu3_id = :userId)
    ";

    // ✅ DATE FILTER
    if (!empty($month) && !empty($year)) {
        $sql .= " AND MONTH(pp.created_date) = :month AND YEAR(pp.created_date) = :year";
    }

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':userId', $userId);

    if (!empty($month) && !empty($year)) {
        $stmt->bindParam(':month', $month, PDO::PARAM_INT);
        $stmt->bindParam(':year', $year, PDO::PARAM_INT);
    }

    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC); // ✅ NO pending result issue

    $transactions = [];
    $totalAmount = 0;

    foreach ($rows as $row) {

        $dt = new DateTime($row['created_date']);
        $date = $dt->format('Y-m-d');

        $packageName = $row['package_name'] ?? 'Unknown Package';
        $cuName = trim($row['customer_name'] ?? '');

        // payout selection logic
        if ($row['cu1_id'] == $userId) {
            $message = $row['cu1_mess'];
            $amt = $row['cu1_amt'];
            $status = $row['cu1_status'];
        } elseif ($row['cu2_id'] == $userId) {
            $message = $row['cu2_mess'];
            $amt = $row['cu2_amt'];
            $status = $row['cu2_status'];
        } else {
            $message = $row['cu3_mess'];
            $amt = $row['cu3_amt'];
            $status = $row['cu3_status'];
        }

        $tds = $amt * $tdsPercentage;
        $total = truncateToTwoDecimals($amt - $tds);

        // ✅ SEARCH FILTER
        if (!empty($search)) {
            $searchLower = strtolower($search);

            $searchableString = strtolower(
                $date . ' ' .
                $packageName . ' ' .
                $cuName . ' ' .
                $message . ' ' .
                $row['no_of_adult'] . ' ' .
                $row['no_of_child'] . ' ' .
                $amt . ' ' .
                $tds . ' ' .
                $total . ' ' .
                (($status == '1') ? 'paid' : 'pending')
            );

            if (strpos($searchableString, $searchLower) === false) {
                continue;
            }
        }

        $totalAmount += $amt;

        $transactions[] = [
            'date' => $date,
            'packageName' => $packageName,
            'customerName' => $cuName,
            'noOfAdults' => $row['no_of_adult'],
            'noOfChildren' => $row['no_of_child'],
            'message' => $message,
            'amount' => $amt,
            'tds' => $tds,
            'totalPayable' => $total,
            'status' => ($status == '1') ? 'Paid' : 'Pending',
        ];
    }

    // ✅ NO DATA CASE
    if (empty($transactions)) {
        echo json_encode([
            'status' => 'success',
            'message' => 'No data found',
            'data' => [
                'totalAmount' => 0,
                'totalTDS' => 0,
                'totalPayable' => 0,
                'transactions' => [],
            ]
        ]);
        exit;
    }

    $totalTDS = $totalAmount * $tdsPercentage;
    $totalPayable = truncateToTwoDecimals($totalAmount - $totalTDS);

    $response = [
        'status' => 'success',
        'data' => [
            'totalAmount' => $totalAmount,
            'totalTDS' => $totalTDS,
            'totalPayable' => $totalPayable,
            'transactions' => $transactions
        ]
    ];

} catch (PDOException $e) {
    $response['message'] = "Database error: " . $e->getMessage();
} catch (Exception $e) {
    $response['message'] = $e->getMessage();
}

echo json_encode($response);