<?php
require '../../connect.php';

// Get month and year
$month_year = $_POST['month_year'] ?? '';
if (empty($month_year)) {
    $month_year = date('Y-m'); // Default to current month-year (YYYY-MM)
}
list($year, $month) = explode('-', $month_year);
$year = (int) $year;
$month = str_pad((int) $month, 2, '0', STR_PAD_LEFT); // Ensure MM format

// Get first and last date of the selected month
$start_date = "$year-$month-01";
$end_date = date("Y-m-t", strtotime($start_date)); // Gets last day of the month

// Get other POST parameters
$design = $_POST['designation'] ?? '';
$user_id = trim($_POST['user_id'] ?? ''); // Trim to remove unwanted spaces
$pay_id = trim($_POST['pay_id'] ?? '');
$pay_mess = trim($_POST['payment_message'] ?? '');
$pay_status = trim($_POST['status'] ?? '');
$te = trim($_POST['te'] ?? ''); // Ensure no leading/trailing spaces
$payment_date = trim($_POST['payment_date'] ?? '');

// Define mapping of designations to tables and columns
$mapping = [
    'bm'  => [
        'table' => 'bm_payout_history',
        'user_col' => 'bm_user_id',
        'payment_message' => 'payment_message',
        'paymentid' => 'paymentid',
        'release_date' => 'release_date',
        'payout_status' => 'payout_status',
        'user_te' => 'ca_user_id'
    ],
    'bdm' => [
        'table' => 'bdm_payout_history',
        'user_col' => 'bdm_user_id',
        'payment_message' => 'payment_message',
        'paymentid' => 'paymentid',
        'release_date' => 'release_date',
        'payout_status' => 'payout_status'
    ],
    'bcm' => [
        'table' => 'bcm_payout_history',
        'user_col' => 'bcm_user_id',
        'payment_message' => 'payment_message',
        'paymentid' => 'paymentid',
        'release_date' => 'release_date',
        'payout_status' => 'payout_status'
    ]
];

if (isset($mapping[$design]) && !empty($user_id)) {
    $map = $mapping[$design];

    // Ensure `ca_user_id` is available for `bm`
    if ($design == 'bm' && empty($te)) {
        die("Error: Missing ca_user_id for BM.");
    }

    // Build the update query dynamically
    if ($design == 'bm') {
        $query = "
            UPDATE {$map['table']} 
            SET {$map['paymentid']} = ?, 
                {$map['payment_message']} = ?, 
                {$map['release_date']} = ?, 
                {$map['payout_status']} = ? 
            WHERE payout_date BETWEEN ? AND ?
              AND {$map['user_te']} = ? 
              AND {$map['user_col']} = ?
        ";
        $params = [$pay_id, $pay_mess, $payment_date, $pay_status, $start_date, $end_date, $te, $user_id];
    } else {
        $query = "
            UPDATE {$map['table']} 
            SET {$map['paymentid']} = ?, 
                {$map['payment_message']} = ?, 
                {$map['release_date']} = ?, 
                {$map['payout_status']} = ? 
            WHERE payout_date BETWEEN ? AND ?
              AND {$map['user_col']} = ?
        ";
        $params = [$pay_id, $pay_mess, $payment_date, $pay_status, $start_date, $end_date, $user_id];
    }

    // Debugging: Log SQL query for debugging
    $query_for_log = $query;
    foreach ($params as $param) {
        $query_for_log = preg_replace('/\?/', "'" . addslashes($param) . "'", $query_for_log, 1);
    }

    // error_log("Executing SQL Query: " . $query_for_log);
    // echo "<script>console.log('SQL Query: " . addslashes($query_for_log) . "');</script>";

    // Prepare and execute the statement
    $stmt = $conn->prepare($query);
    if (!$stmt) {
        die("Error preparing statement: " . implode(" | ", $conn->errorInfo()));
    }

    $execute_status = $stmt->execute($params);
    if (!$execute_status) {
        die("Execution failed: " . implode(" | ", $stmt->errorInfo()));
    }

    // Check rows updated
    if ($stmt->rowCount() > 0) {
        echo $pay_status; // Success
    } else {
        echo "No rows updated. Check your conditions.";
    }
} else {
    echo "Invalid designation or missing user ID.";
}
?>
