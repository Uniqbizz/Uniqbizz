<?php
require '../../../../connect.php';
header('Content-Type: application/json');

$response = [
    "status" => false,
    "message" => "",
    "data" => []
];

try {
    if ($_SERVER["REQUEST_METHOD"] !== "POST") {
        throw new Exception("Invalid request method. Use POST.");
    }

    $input = json_decode(file_get_contents("php://input"), true);
    if (!$input) {
        throw new Exception("Invalid JSON input.");
    }

    if (!isset($input['userId'])) {
        throw new Exception("Missing required field: userId");
    }

    $userId = $input['userId'];
    $search = trim($input['search'] ?? '');
    $month  = $input['month'] ?? null;
    $year   = $input['year'] ?? null;

    $columnDesignation = 'travel_consultant';
    $columnMessage = 'message_tc';
    $columnCommision = 'commision_tc';
    $columnStatus = 'status_tc';

    $tdsPercentage = 0.02;

    $isAllTime = empty($month) && empty($year);

    // 🔹 WHERE CLAUSE
    $where = "$columnDesignation = :userId";

    if (!$isAllTime) {
        $where .= " AND YEAR(created_date) = :year AND MONTH(created_date) = :month";
    }

    // 🔹 TOTAL PAYOUT (unchanged)
    $query = "SELECT SUM($columnCommision) AS total_payable 
              FROM ca_cu_payout 
              WHERE $where";

    $stmt = $conn->prepare($query);
    $stmt->bindParam(':userId', $userId);

    if (!$isAllTime) {
        $stmt->bindParam(':year', $year);
        $stmt->bindParam(':month', $month);
    }

    $stmt->execute();
    $totalRow = $stmt->fetch(PDO::FETCH_ASSOC);
    $total_payable = (float)($totalRow['total_payable'] ?? 0);

    // 🔹 FETCH DATA
    $sql = "SELECT * FROM ca_cu_payout WHERE $where ORDER BY created_date DESC";

    $stmt2 = $conn->prepare($sql);
    $stmt2->bindParam(':userId', $userId);

    if (!$isAllTime) {
        $stmt2->bindParam(':year', $year);
        $stmt2->bindParam(':month', $month);
    }

    $stmt2->execute();

    $payouts = [];
    $totalTDS = 0;

    $searchLower = strtolower(trim($search));
    $isNumeric = is_numeric($searchLower);

    while ($row = $stmt2->fetch(PDO::FETCH_ASSOC)) {

        $dt = date('Y-m-d', strtotime($row['created_date']));

        $message = str_replace('Rs.', 'Rs ', $row[$columnMessage]);
        $message2 = str_replace('.', '<br>', $message);

        $CommAmt = (float)$row[$columnCommision];
        $tds = $CommAmt * $tdsPercentage;
        $totalAmt = $CommAmt - $tds;

        $status = $row[$columnStatus] == '1' ? 'Paid' : 'Pending';

        // 🔥 SEARCH FILTER (MAIN FIX)
        if ($searchLower !== '') {

            $fullMessage = strtolower($message2);
            $statusLower = strtolower($status);

            $match = false;

            // TEXT MATCH
            if (
                strpos($fullMessage, $searchLower) !== false ||
                strpos($statusLower, $searchLower) !== false
            ) {
                $match = true;
            }

            // NUMERIC MATCH (commission, tds, total)
            if (!$match && $isNumeric) {
                $num = (float)$searchLower;

                if (
                    $CommAmt == $num ||
                    $tds == $num ||
                    $totalAmt == $num
                ) {
                    $match = true;
                }
            }

            if (!$match) continue;
        }

        $totalTDS += $tds;

        $payouts[] = [
            "date" => $dt,
            "message" => $message2,
            "commission" => $CommAmt,
            "tds" => $tds,
            "total_payable" => $totalAmt,
            "remark" => $status,
        ];
    }

    // 🔹 FINAL TOTAL AFTER TDS
    $finalPayable = $total_payable - $totalTDS;

    $response = [
        "status" => true,
        "message" => "Data fetched successfully",
        "data" => [
            "total_payout" => $total_payable,
            "payouts" => $payouts
        ]
    ];

} catch (Exception $e) {
    $response["message"] = $e->getMessage();
}

echo json_encode($response, JSON_PRETTY_PRINT);
?>