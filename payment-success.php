<?php

require 'connect.php';
require 'assets/submit/config.php'; // HDFC credentials

date_default_timezone_set('Asia/Calcutta');
    
$today = date('Y-m-d H:i:s');
$today_date = date('j') . '-' . date('n') . '-' . date('Y');

// echo "<h2>Payment Response</h2>";

/**
 * =========================
 * 1. CAPTURE GATEWAY DATA
 * =========================
 */
$order_id = $_POST['order_id'] ?? $_GET['order_id'] ?? '';
$status_from_gateway = $_POST['status'] ?? $_GET['status'] ?? 'UNKNOWN';
$booking_direct_bill_status = "";

// print_r($order_id);
// print_r($status_from_gateway);

/**
 * Log raw response (VERY IMPORTANT for debugging)
 */
file_put_contents(
    "gateway_log.txt",
    date('Y-m-d H:i:s') . "\n" . print_r($_POST + $_GET, true) . "\n\n",
    FILE_APPEND
);

if (!$order_id) {
    die("Invalid request: Order ID missing");
}


/**
 * =========================
 * 2. FETCH BOOKING
 * =========================
 */
$pg_bookingSelectStmt = $conn->prepare("SELECT * FROM pg_bookings WHERE order_id = :order_id");
$pg_bookingSelectStmt->execute([':order_id' => $order_id]);

$booking = $pg_bookingSelectStmt->fetch();

if (!$booking) {
    die("Order not found in database");
}


/**
 * =========================
 * 3. PREVENT DUPLICATE PAYMENT
 * =========================
 */
if ($booking['status'] === 'PAID') {
    echo "<h3>Payment already completed</h3>";
    exit;
}


/**
 * =========================
 * 4. CALL HDFC VERIFY API
 * =========================
 */
$headers = [
    "Authorization: Basic " . HDFC_API_KEY,
    "x-merchantid: " . HDFC_MERCHANT_ID,
    "Content-Type: application/json"
];

$verify_url = HDFC_STATUS_URL . "/" . $order_id;

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $verify_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);

$response = curl_exec($ch);
$curlError = curl_error($ch);

curl_close($ch);

if ($curlError) {
    die("Verification API error: " . $curlError);
}

$result = json_decode($response, true);


// /**
//  * Debug response (remove in production)
//  */
// echo "<h3>Gateway Raw Status</h3>";
// echo "<pre>";
// print_r($_POST);
// echo "</pre>";

// echo "<h3>Verification Response</h3>";
// echo "<pre>";
// print_r($result);
// echo "</pre>";


/**
 * =========================
 * 5. DECIDE FINAL STATUS
 * =========================
 */
$status_from_api = strtoupper(trim($result['status'] ?? 'FAILED')); // output - CHARGED OR FAILED
$payment_id = $result['id'] ?? null; // payment id from payment Gateway response.
$amount = $result['amount'];
$bookings_id = $result['udf1']; // passing booking_id in udf1 from create page and getting it here from hdfc orders api call
$date = $result['date_created'];

// print_r($status_from_api);
// print_r($payment_id);

if ($status_from_api === "CHARGED") {
    $final_status = "PAID";
    $booking_direct_bill_status = 1;
} elseif ($status_from_api === "PENDING") {
    $final_status = "PENDING";
    $booking_direct_bill_status = 0;
} else {
    $final_status = "FAILED";
    $booking_direct_bill_status = 2;
}


/**
 * =========================
 * 6. UPDATE DATABASE
 * =========================
 */

// Payment Gateway Table response update

$pg_booking_update_stmt = $conn->prepare("
    UPDATE pg_bookings 
    SET status = :status,
        payment_id = :payment_id,
        payment_response = :response
    WHERE order_id = :order_id
");

$pg_booking_update_stmt_status = $pg_booking_update_stmt->execute([
    ':status' => $final_status,
    ':payment_id' => $payment_id,
    ':response' => json_encode($result),
    ':order_id' => $order_id
]);

// Booking Direct Bill payment status update

$booking_direct_bill_update_stmt = $conn->prepare("
    UPDATE booking_direct_bill 
    SET pg_status = :pg_status,
        pg_payment_id = :pg_payment_id,
        status = :booking_direct_bill_status
    WHERE bookings_id = :bookings_id
");

$booking_direct_bill_update_status = $booking_direct_bill_update_stmt->execute([
    ':pg_status' => $final_status,
    ':pg_payment_id' => $payment_id,
    ':booking_direct_bill_status' => $booking_direct_bill_status,
    ':bookings_id' => $bookings_id
]);

if (!$pg_booking_update_stmt_status || !$booking_direct_bill_update_status) {

    echo "<pre>";
    print_r($pg_booking_update_stmt->errorInfo());
    print_r($booking_direct_bill_update_stmt->errorInfo());
    echo "</pre>";

    die("DB update failed");
}


/**
 * =========================
 * 7. USER OUTPUT
 * =========================
 */
// if ($final_status === 'PAID') {
//     echo "<h2 style='color:green;'>✅ Payment Successful</h2>";
// } elseif ($final_status === 'PENDING') {
//     echo "<h2 style='color:orange;'>⏳ Payment Pending</h2>";
// } else {
//     echo "<h2 style='color:red;'>❌ Payment Failed</h2>";
// }

// echo "<h3>Order ID: $order_id</h3>";
// echo "<p>Thank you! Your booking is being processed.</p>";

$page_title = "";
$heading = "";
$message = "";
$icon_color = "";
$icon_bg = "";
$button_color = "";
$svg_icon = "";

if ($final_status === 'PAID') {

    $page_title = "Payment Successful";
    $heading = "Payment Successful!";
    $message = "Your transaction was processed successfully.";
    $icon_color = "#22c55e";
    $icon_bg = "#f0fdf4";
    $button_color = "#22c55e";

    $svg_icon = '
        <svg class="status-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
        </svg>
    ';

} elseif ($final_status === 'PENDING') {

    $page_title = "Payment Pending";
    $heading = "Payment Pending";
    $message = "Your payment is currently under processing. Please wait a few minutes and check your order history.";
    $icon_color = "#f59e0b";
    $icon_bg = "#fffbeb";
    $button_color = "#f59e0b";

    $svg_icon = '
        <svg class="status-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3"></path>
            <circle cx="12" cy="12" r="9" stroke-width="2"></circle>
        </svg>
    ';

} else {

    $page_title = "Payment Failed";
    $heading = "Payment Failed!";
    $message = "Unfortunately your transaction could not be completed. ";
    $icon_color = "#ef4444";
    $icon_bg = "#fef2f2";
    $button_color = "#ef4444";

    $svg_icon = '
        <svg class="status-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"></path>
        </svg>
    ';
}

//convert long number to short number with 2 decimal points and currency indication
function formatIndianCurrency($amount) {
    $amount = str_replace(',', '', $amount);
    if ($amount >= 10000000) {
        return number_format($amount / 10000000, 2) . ' Cr';
    } elseif ($amount >= 100000) {
        return number_format($amount / 100000, 2) . ' L';
    } elseif ($amount >= 1000) {
        return number_format($amount / 1000, 2) . ' K';
    } else {
        return $amount;
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?></title>

    <link rel="icon" type="image/x-icon" sizes="20x20" href="assets/images/icon/fav.png">

    <style>

        :root {
            --primary: <?php echo $button_color; ?>;
            --icon-bg: <?php echo $icon_bg; ?>;
            --icon-color: <?php echo $icon_color; ?>;

            --text-main: #1f2937;
            --text-muted: #6b7280;
            --bg: #f9fafb;
        }

        body {
            font-family: 'Inter', -apple-system, system-ui, sans-serif;
            background-color: var(--bg);
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            margin: 0;
            padding: 20px;
        }

        .card {
            background: white;
            padding: 2.5rem;
            border-radius: 1.5rem;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05);
            text-align: center;
            max-width: 420px;
            width: 100%;
            animation: slideUp 0.5s ease;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(25px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .icon-container {
            width: 85px;
            height: 85px;
            background: var(--icon-bg);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            color: var(--icon-color);
        }

        .status-icon {
            width: 42px;
            height: 42px;
        }

        h1 {
            color: var(--text-main);
            font-size: 1.6rem;
            margin-bottom: 10px;
        }

        p {
            color: var(--text-muted);
            line-height: 1.6;
            font-size: 0.95rem;
            margin-bottom: 2rem;
        }

        .details {
            background: #f8fafc;
            border: 1px solid #eef2f7;
            border-radius: 1rem;
            padding: 1.2rem;
            margin-bottom: 2rem;
            text-align: left;
        }

        .detail-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 0.9rem;
            font-size: 0.92rem;
        }

        .detail-row:last-child {
            margin-bottom: 0;
        }

        .label {
            color: var(--text-muted);
        }

        .value {
            color: var(--text-main);
            font-weight: 600;
            word-break: break-word;
            text-align: right;
        }

        .btn {
            display: block;
            background: var(--primary);
            color: white;
            text-decoration: none;
            padding: 0.9rem 1.5rem;
            border-radius: 0.8rem;
            font-weight: 600;
            transition: 0.2s ease;
            margin-bottom: 0.8rem;
        }

        .btn:hover {
            opacity: 0.92;
            transform: translateY(-1px);
        }

        .btn-secondary {
            background: transparent;
            border: 1px solid #dbe3ea;
            color: #374151;
        }

        .btn-secondary:hover {
            background: #f8fafc;
        }

    </style>
</head>

<body>

<div class="card">

    <div class="icon-container">
        <?php echo $svg_icon; ?>
    </div>

    <h1><?php echo $heading; ?></h1>

    <p><?php echo $message; ?></p>

    <div class="details">

        <div class="detail-row">
            <span class="label">Amount</span>
            <span class="value">₹<?php echo $amount; ?>/-</span>
        </div>

        <div class="detail-row">
            <span class="label">Order ID</span>
            <span class="value"><?php echo $order_id; ?></span>
        </div>

        <?php if ($payment_id) { ?>

        <div class="detail-row">
            <span class="label">Payment ID</span>
            <span class="value"><?php echo $payment_id; ?></span>
        </div>

        <?php } ?>

        <div class="detail-row">
            <span class="label">Date</span>
            <span class="value"><?php echo date('d M Y h:i A', strtotime($date)); ?></span>
        </div>

        <div class="detail-row">
            <span class="label">Status</span>
            <span class="value"><?php echo $final_status; ?></span>
        </div>

    </div>

    <a href="dashboard/order_history.php" class="btn">
        View Order History
    </a>

    <a href="tour-list.php" class="btn btn-secondary">
        Back to Home
    </a>

</div>

</body>
</html>
