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

    // ✅ Only userId is required now
    if (!isset($input['userId'])) {
        throw new Exception("Missing required field: userId");
    }

    $userId = $input['userId'];

    $columnDesignation = 'travel_consultant';
    $columnMessage = 'message_tc';
    $columnCommision = 'commision_tc';
    $columnStatus = 'status_tc';

    $tdsPercentage = 0.02;

    $totalDateMonth = $input['totalDateMonth'] ?? null;
    $totalDateYear = $input['totalDateYear'] ?? null;

    // ✅ Detect mode
    $isAllTime = empty($totalDateMonth) && empty($totalDateYear);

    // ====== BUILD WHERE CLAUSE ======
    $where = "$columnDesignation = :userId";

    if (!$isAllTime) {
        $where .= " AND YEAR(created_date) = :year AND MONTH(created_date) = :month";
    }

    // ====== TOTAL PAYOUT ======
    $query = "SELECT SUM($columnCommision) AS total_payable 
              FROM ca_cu_payout 
              WHERE $where";

    $stmt = $conn->prepare($query);
    $stmt->bindParam(':userId', $userId);

    if (!$isAllTime) {
        $stmt->bindParam(':year', $totalDateYear);
        $stmt->bindParam(':month', $totalDateMonth);
    }

    $stmt->execute();
    $totalRow = $stmt->fetch(PDO::FETCH_ASSOC);
    $total_payable = (float)($totalRow['total_payable'] ?? 0);

    // ====== FETCH PAYOUTS ======
    $sql = "SELECT * FROM ca_cu_payout WHERE $where ORDER BY created_date DESC";

    $stmt2 = $conn->prepare($sql);
    $stmt2->bindParam(':userId', $userId);

    if (!$isAllTime) {
        $stmt2->bindParam(':year', $totalDateYear);
        $stmt2->bindParam(':month', $totalDateMonth);
    }

    $stmt2->execute();

    $payouts = [];
    $totalTDS = 0;

    while ($row = $stmt2->fetch(PDO::FETCH_ASSOC)) {
        $dt = date('Y-m-d', strtotime($row['created_date']));

        $message = str_replace('Rs.', 'Rs ', $row[$columnMessage]);
        $message2 = str_replace('.', '<br>', $message);

        $CommAmt = (float)$row[$columnCommision];
        $tds = $CommAmt * $tdsPercentage;
        $totalAmt = $CommAmt - $tds;

        $totalTDS += $tds;

        $status = $row[$columnStatus] == '1' ? 'Paid' : 'Pending';

        $payouts[] = [
            "date" => $dt,
            "message" => $message2,
            "commission" => $CommAmt,
            "tds" => $tds,
            "total_payable" => $totalAmt,
            "remark" => $status,
        ];
    }

    // ====== FINAL TOTAL PAYABLE AFTER TDS ======
    $finalPayable = $total_payable - $totalTDS;

    // ====== RESPONSE ======
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