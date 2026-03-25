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

    // Fetch JSON input
    $input = json_decode(file_get_contents("php://input"), true);
    if (!$input) {
        throw new Exception("Invalid JSON input.");
    }

    // Required fields
    $required = ['userId','totalDateMonth','totalDateYear'];
    foreach ($required as $key) {
        if (!isset($input[$key])) {
            throw new Exception("Missing required field: $key");
        }
    }

    // Assign variables
    $userId = $input['userId'];
    $columnDesignation = 'travel_consultant';
    $columnMessage = 'message_tc';
    $columnCommision = 'commision_tc';
    $columnStatus = 'status_tc';
    $tdsPercentage = 0.02;
    $totalDateMonth = isset($input['totalDateMonth']) ? $input['totalDateMonth'] : '';
    $totalDateYear = isset($input['totalDateYear']) ? $input['totalDateYear'] : '';

    // ====== TOTAL PAYOUT ======
    $query = "SELECT SUM($columnCommision) AS total_payable 
              FROM ca_cu_payout 
              WHERE $columnDesignation = :userId AND YEAR(created_date) = :year AND MONTH(created_date) = :month AND $columnStatus = '1'";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':userId', $userId);
    $stmt->bindParam(':year', $totalDateYear);
    $stmt->bindParam(':month', $totalDateMonth);
    $stmt->execute();
    $totalRow = $stmt->fetch(PDO::FETCH_ASSOC);
    $total_payable = $totalRow['total_payable'] ?? 0;

    // ====== FETCH ALL PAYOUTS ======
    $sql = "SELECT * FROM ca_cu_payout 
            WHERE $columnDesignation = :userId AND YEAR(created_date) = :year AND MONTH(created_date) = :month AND $columnStatus = '1'";
    $stmt2 = $conn->prepare($sql);
    $stmt2->bindParam(':userId', $userId);
    $stmt2->bindParam(':year', $totalDateYear);
    $stmt2->bindParam(':month', $totalDateMonth);
    $stmt2->execute();

    $payouts = [];
    while ($row = $stmt2->fetch(PDO::FETCH_ASSOC)) {
        $dt = date('Y-m-d', strtotime($row['created_date']));
        $message = str_replace('Rs.', 'Rs ', $row[$columnMessage]);
        $message2 = str_replace('.', '<br>', $message);
        $CommAmt = floatval($row[$columnCommision]);
        $tds = $CommAmt * $tdsPercentage;
        $totalAmt = $CommAmt - $tds;
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

    // ====== BUILD RESPONSE ======
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

// Output JSON
echo json_encode($response, JSON_PRETTY_PRINT);
?>
