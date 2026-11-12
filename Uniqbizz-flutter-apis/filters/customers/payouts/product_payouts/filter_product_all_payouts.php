<?php
header("Content-Type: application/json");

require '../../../../connect.php';

// ✅ Inputs
$request = json_decode(file_get_contents('php://input'), true);

$userId   = $request['id'] ?? '';
$search   = trim($request['search'] ?? '');
$fromDate = $request['fromDate'] ?? null;
$toDate   = $request['toDate'] ?? null;

// ✅ Force userType = 10
$userType = '10';

$tdsPercentage = 0.02;

if (!$userId) {
    echo json_encode(["status" => "error", "message" => "Missing id"]);
    exit;
}

// ✅ Base query
$sql = "SELECT * FROM product_payout 
        WHERE (cu1_id = :uid OR cu2_id = :uid OR cu3_id = :uid)";

// ✅ Flexible date filter
if (!empty($fromDate) && !empty($toDate)) {
    $sql .= " AND DATE(created_date) BETWEEN :fromDate AND :toDate";
} elseif (!empty($fromDate)) {
    $sql .= " AND DATE(created_date) >= :fromDate";
} elseif (!empty($toDate)) {
    $sql .= " AND DATE(created_date) <= :toDate";
}

$stmt = $conn->prepare($sql);

// ✅ Bind params
$stmt->bindParam(':uid', $userId);

if (!empty($fromDate) && !empty($toDate)) {
    $stmt->bindParam(':fromDate', $fromDate);
    $stmt->bindParam(':toDate', $toDate);
} elseif (!empty($fromDate)) {
    $stmt->bindParam(':fromDate', $fromDate);
} elseif (!empty($toDate)) {
    $stmt->bindParam(':toDate', $toDate);
}

$stmt->execute();

$data = [];

if ($stmt->rowCount() > 0) {
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($rows as $row) {

        $dt = (new DateTime($row['created_date']))->format('Y-m-d');

        // Package name
        $stmt1 = $conn->prepare("SELECT name FROM package WHERE id = :pid");
        $stmt1->execute([':pid' => $row['package_id']]);
        $packageName = $stmt1->fetchColumn();

        // Customer name
        $stmt8 = $conn->prepare("SELECT firstname, lastname FROM ca_customer WHERE ca_customer_id = :cid");
        $stmt8->execute([':cid' => $row['cu_id']]);
        $cuData = $stmt8->fetch(PDO::FETCH_ASSOC);
        $cuName = ($cuData['firstname'] ?? '') . ' ' . ($cuData['lastname'] ?? '');

        $no_of_adult = $row['no_of_adult'];
        $no_of_child = $row['no_of_child'];
        $ta_markup = null;

        // ✅ Existing logic
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
        $totalPayable = $amt - $tds;

        $statusText = ($status == '1') ? "Paid" : "Pending";

        $finalMessage = $message . " on selling " . $packageName . " Package to " . $cuName .
            " | Adults: " . $no_of_adult . " | Children: " . $no_of_child;

        // ✅ GLOBAL SEARCH
        if (!empty($search)) {
            $searchLower = strtolower($search);

            $searchableString = strtolower(
                $dt . ' ' .
                $finalMessage . ' ' .
                $ta_markup . ' ' .
                $amt . ' ' .
                $tds . ' ' .
                $totalPayable . ' ' .
                $statusText
            );

            if (strpos($searchableString, $searchLower) === false) {
                continue;
            }
        }

        $data[] = [
            "date" => $dt,
            "message" => $finalMessage,
            "markup" => $ta_markup,
            "amount" => $amt,
            "tds" => $tds,
            "total_payable" => $totalPayable,
            "status" => $statusText
        ];
    }

    // ✅ No data after filtering
    if (empty($data)) {
        echo json_encode([
            "status" => "success",
            "message" => "No data found",
            "payouts" => []
        ]);
        exit;
    }

    echo json_encode([
        "status" => "success",
        "payouts" => $data
    ], JSON_PRETTY_PRINT);

} else {
    echo json_encode([
        "status" => "success",
        "payouts" => []
    ]);
}