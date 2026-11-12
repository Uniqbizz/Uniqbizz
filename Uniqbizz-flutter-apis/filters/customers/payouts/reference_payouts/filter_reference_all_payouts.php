<?php
require '../../../../connect.php';

header('Content-Type: application/json');

$request = json_decode(file_get_contents("php://input"), true);

// ✅ Inputs
$userId   = $request['id'] ?? '';
$search   = trim($request['search'] ?? '');
$fromDate = $request['fromDate'] ?? '';
$toDate   = $request['toDate'] ?? '';

if (empty($userId)) {
    echo json_encode([
        "status" => false,
        "message" => "Missing id"
    ]);
    exit;
}

try {

    // ✅ Base query
    $sql = "SELECT id, customer_id as userId, referral_message as message1, booking_message as message2, 
                   referral_amount as comm_amt1, booking_points as comm_amt2, created_date, status 
            FROM customer_reference_payout 
            WHERE customer_id = :userId AND status IN ('1', '2')";

    // ✅ Date filter (all cases handled)
    if (!empty($fromDate) && !empty($toDate)) {
        $sql .= " AND DATE(created_date) BETWEEN :fromDate AND :toDate";
    } elseif (!empty($fromDate)) {
        $sql .= " AND DATE(created_date) >= :fromDate";
    } elseif (!empty($toDate)) {
        $sql .= " AND DATE(created_date) <= :toDate";
    }

    $sql .= " ORDER BY created_date DESC";

    $stmt = $conn->prepare($sql);

    // ✅ Bind params
    $stmt->bindParam(':userId', $userId);

    if (!empty($fromDate) && !empty($toDate)) {
        $stmt->bindParam(':fromDate', $fromDate);
        $stmt->bindParam(':toDate', $toDate);
    } elseif (!empty($fromDate)) {
        $stmt->bindParam(':fromDate', $fromDate);
    } elseif (!empty($toDate)) {
        $stmt->bindParam(':toDate', $toDate);
    }

    $stmt->execute();

    $tdsPer = 0.02;

    $data = [];

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

        $dt = (new DateTime($row['created_date']))->format('Y-m-d');

        $message = $row['message1'] ?: $row['message2'];

        if (!$row['comm_amt1']) {
            $CommAmt = $row['comm_amt2'];
            $tds = "NA";
            $totalAmt = $CommAmt;
        } else {
            $CommAmt = $row['comm_amt1'];
            $tds = $CommAmt * $tdsPer;
            $totalAmt = $CommAmt - $tds;
        }

        switch ($row['status']) {
            case '1':
                $statusText = 'Paid';
                break;
            case '3':
                $statusText = 'Credited';
                break;
            default:
                $statusText = 'Pending';
                break;
        }

        // ✅ GLOBAL SEARCH
        if (!empty($search)) {
            $searchLower = strtolower($search);

            $searchableString = strtolower(
                $dt . ' ' .
                $message . ' ' .
                $CommAmt . ' ' .
                $tds . ' ' .
                $totalAmt . ' ' .
                $statusText
            );

            if (strpos($searchableString, $searchLower) === false) {
                continue;
            }
        }

        $data[] = [
            'date' => $dt,
            'message' => $message,
            'amount' => (float) $CommAmt,
            'tds' => $tds,
            'total_payable' => $totalAmt,
            'status' => $statusText
        ];
    }

    // ✅ No data after filtering
    if (empty($data)) {
        echo json_encode([
            "status" => true,
            "message" => "No data found",
            "data" => []
        ]);
        exit;
    }

    echo json_encode([
        "status" => true,
        "message" => "Data fetched successfully",
        "data" => $data
    ]);

} catch (PDOException $e) {
    echo json_encode([
        "status" => false,
        "message" => "Database error: " . $e->getMessage()
    ]);
}