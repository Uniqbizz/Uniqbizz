<?php
header("Content-Type: application/json");

require '../../../../connect.php';

$request = json_decode(file_get_contents('php://input'), true);

// ✅ Inputs
$userId   = $request['id'] ?? '';
$userType = 10; // FORCE customer type
$search   = trim($request['search'] ?? '');
$month    = (isset($request['month']) && $request['month'] !== '') ? (int)$request['month'] : null;
$year     = (isset($request['year']) && $request['year'] !== '') ? (int)$request['year'] : null;

$tdsPercentage = 0.02;

if (!$userId) {
    echo json_encode(["status" => "error", "message" => "Missing id"]);
    exit;
}

// ✅ Base SQL
switch ($userType) {
    case '10':
        $sql = "SELECT * FROM product_payout WHERE (cu1_id = :uid OR cu2_id = :uid OR cu3_id = :uid)";
        break;
    case '11':
        $sql = "SELECT * FROM product_payout WHERE ta_id = :uid";
        break;
    case '16':
    case '29':
        $sql = "SELECT * FROM product_payout WHERE te_id = :uid";
        break;
    case '26':
    case '28':
        $sql = "SELECT * FROM product_payout WHERE bm_id = :uid";
        break;
    case '25':
        $sql = "SELECT * FROM product_payout WHERE bdm_id = :uid";
        break;
    case '24':
        $sql = "SELECT * FROM product_payout WHERE bch_id = :uid";
        break;
    default:
        echo json_encode(["status" => "error", "message" => "Invalid user type"]);
        exit;
}

// ✅ Month/year filter
if ($month !== null && $year !== null) {
    $sql .= " AND MONTH(created_date) = :month AND YEAR(created_date) = :year";
}

$stmt = $conn->prepare($sql);

// ✅ Bind params
$stmt->bindParam(':uid', $userId);
if ($month !== null && $year !== null) {
    $stmt->bindParam(':month', $month);
    $stmt->bindParam(':year', $year);
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

        // ✅ Existing logic untouched
        if ($userType == '10') {
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
        } elseif ($userType == '11') {
            $message = $row['ta_mess'];
            $amt = $row['ta_amt'];
            $status = $row['ta_status'];
            $ta_markup = $row['ta_markup'];
        } elseif ($userType == '16' || $userType == '29') {
            $message = $row['te_mess'];
            $amt = $row['te_amt'];
            $status = $row['te_status'];
        } elseif ($userType == '24') {
            $message = $row['bch_mess'];
            $amt = $row['bch_amt'];
            $status = $row['bch_status'];
        } elseif ($userType == '25') {
            $message = $row['bdm_mess'];
            $amt = $row['bdm_amt'];
            $status = $row['bdm_status'];
        } elseif ($userType == '26' || $userType == '28') {
            $message = $row['bm_mess'];
            $amt = $row['bm_amt'];
            $status = $row['bm_status'];
        }

        $tds = $amt * $tdsPercentage;
        $totalPayable = $amt - $tds;

        $statusText = ($status == '1' ? "Paid" : "Pending");

        // ✅ FINAL MESSAGE (same as your output)
        $finalMessage = $message . " on selling " . $packageName . " Package to " . $cuName .
            " | Adults: " . $no_of_adult . " | Children: " . $no_of_child;

        // ✅ GLOBAL SEARCH (NEW)
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
        echo json_encode(["status" => "success", "message" => "No data found", "payouts" => []]);
        exit;
    }

    echo json_encode(["status" => "success", "payouts" => $data], JSON_PRETTY_PRINT);

} else {
    echo json_encode(["status" => "success", "payouts" => []]);
}