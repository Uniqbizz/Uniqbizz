<?php

require '../../../../connect.php'; // Include your database connection

header('Content-Type: application/json');

// Get request parameters
$request = json_decode(file_get_contents('php://input'), true);
$userId = $request['userId'] ?? $userId;
$userType = $request['userType'] ?? $userType;
$month = isset($request['month']) ? (int)$request['month'] : null; // force int
$year = isset($request['year']) ? (int)$request['year'] : null;
$action = $request['action'] ?? '';

// Initialize response
$response = [
    'status' => 'error',
    'message' => '',
    'data' => []
];

// TDS percentage (same as in your original code)
$tdsPercentage = 2 / 100;

// Function to truncate decimals (same as in your original code)
function truncateToTwoDecimals($num)
{
    return floor($num * 100) / 100;
}

try {
    // Determine user type and corresponding fields (same logic as your original code)
    if ($userType == '11') { //travel_consultant
        $userIdCommi = 'ta_id';
        $amtCal = 'ta_markup + ta_amt';
    } elseif ($userType == '16') { //Techno Enterprise/ corporate agency
        $userIdCommi = 'te_id';
        $amtCal = 'te_amt';
    } elseif ($userType == '10') { //customer
        $userIdCommi = 'cu1_id';
        $amtCal = 'cu1_amt';
    } elseif ($userType == '26') { //business Mentor
        $userIdCommi = 'bm_id';
        $amtCal = 'bm_amt';
    } elseif ($userType == '25') { // business Development manager
        $userIdCommi = 'bdm_id';
        $amtCal = 'bdm_amt';
    } elseif ($userType == '24') { // business channel manager
        $userIdCommi = 'bch_id';
        $amtCal = 'bch_amt';
    } elseif ($userType == '28') { //master franchisee
        $userIdCommi = 'bm_id';
        $amtCal = 'bm_amt';
    } elseif ($userType == '29') { //franchisee (sub_franchisee)
        $userIdCommi = 'te_id';
        $amtCal = 'te_amt';
    } else {
        throw new Exception("Invalid user type");
    }

    // Determine date ranges based on action
    if ($action === 'previous') {
        if ($month && $year) {
            // Calculate previous month relative to the given month/year
            $date = strtotime("-1 month", strtotime("$year-$month-01"));
        } else {
            // No month/year given → fall back to previous month from today
            $date = strtotime("-1 month");
        }
        $month = (int)date('n', $date);
        $year = (int)date('Y', $date);
        $period = date("F,Y", $date);
    } elseif ($action === 'next') {
        if ($month && $year) {
            // Keep same month/year — no increment
            $date = strtotime("$year-$month-01");
        } else {
            // Default to current month
            $date = strtotime(date('Y-m-01'));
        }
        $month = (int)date('n', $date);
        $year = (int)date('Y', $date);
        $period = date('F,Y', $date);
    } elseif ($action === 'specific' && $month && $year) {
        $period = date('F,Y', mktime(0, 0, 0, $month, 1, $year));
    } elseif ($action === 'total') {
        $period = 'All Time';
    } else {
        throw new Exception("Invalid action or missing month/year parameters");
    }


    // Build the base SQL query (same logic as your original code)
    if ($userType == '10') {
        $sql = "SELECT * FROM `product_payout` WHERE (cu1_id = :userId OR cu2_id = :userId OR cu3_id = :userId)";
    } else {
        $sql = "SELECT * FROM `product_payout` WHERE $userIdCommi = :userId";
    }

    // Add date filter if not requesting all payouts
    if ($action !== 'total') {
        $sql .= " AND YEAR(created_date) = :year AND MONTH(created_date) = :month";
    }

    // Prepare and execute the query
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':userId', $userId);
    if ($action !== 'total') {
        $stmt->bindParam(':year', $year);
        $stmt->bindParam(':month', $month);
    }
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);

    // Process results (same logic as your original code)
    $transactions = [];
    $totalAmount = 0;

    while ($row = $stmt->fetch()) {
        // Date formatting (same as original)
        $dt = new DateTime($row['created_date']);
        $date = $dt->format('Y-m-d');

        // Get package name (same as original)
        $stmt1 = $conn->prepare("SELECT name FROM package WHERE id = :packageId");
        $stmt1->bindParam(':packageId', $row['package_id']);
        $stmt1->execute();
        $pkgName = $stmt1->fetch();
        $packageName = $pkgName['name'] ?? 'Unknown Package';

        // Get customer name (same as original)
        $stmt8 = $conn->prepare("SELECT firstname, lastname FROM ca_customer WHERE ca_customer_id = :customerId");
        $stmt8->bindParam(':customerId', $row['cu_id']);
        $stmt8->execute();
        $cu_name = $stmt8->fetch();
        $cuName = ($cu_name['firstname'] ?? '') . ' ' . ($cu_name['lastname'] ?? '');

        // Determine payout details based on user type (same as original)
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
        } else {
            $message = $row['te' . '_mess'];
            $amt = $row['te' . '_amt'];
            $status = $row['te' . '_status'];
        }

        $tds = $amt * $tdsPercentage;
        $total = truncateToTwoDecimals($amt - $tds);
        $totalAmount += $amt;

        // Build transaction data (same structure as your table rows)
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
            'status' => ($status == '1') ? 'Paid' : 'Pending'
        ];

        // Add markup for travel consultants (same as original)
        if ($userType == '11') {
            $transaction['markup'] = $row['ta_markup'];
        }

        $transactions[] = $transaction;
    }

    // Calculate totals (same as original)
    $totalTDS = $totalAmount * $tdsPercentage;
    $totalPayable = truncateToTwoDecimals($totalAmount - $totalTDS);

    // Prepare response
    $response = [
        'status' => 'success',
        'data' => [
            'period' => $period,
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
