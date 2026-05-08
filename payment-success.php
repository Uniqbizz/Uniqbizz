<?php

require 'connect.php';
require 'assets/submit/config.php'; // HDFC credentials

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
    <title>Payment Successful</title>
    <link rel="icon" type="image/x-icon" sizes="20x20" href="assets/images/icon/fav.png">
    <style>
        :root {
            --primary: #4f46e5;
            --success: #22c55e;
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
        }

        .card {
            background: white;
            padding: 2.5rem;
            border-radius: 1.5rem;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.04);
            text-align: center;
            max-width: 400px;
            width: 90%;
            animation: slideUp 0.6s cubic-bezier(0.16, 1, 0.3, 1);
        }

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .icon-container {
            width: 80px;
            height: 80px;
            background: #f0fdf4;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
        }

        .checkmark {
            width: 40px;
            height: 40px;
            color: var(--success);
        }

        h1 {
            color: var(--text-main);
            font-size: 1.5rem;
            margin: 0 0 0.5rem;
            font-weight: 700;
        }

        p {
            color: var(--text-muted);
            line-height: 1.6;
            margin: 0 0 2rem;
            font-size: 0.95rem;
        }

        .details {
            background: #f8fafc;
            border-radius: 0.75rem;
            padding: 1.25rem;
            margin-bottom: 2rem;
            text-align: left;
            border: 1px solid #f1f5f9;
        }

        .detail-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 0.75rem;
            font-size: 0.875rem;
        }

        .detail-row:last-child { margin-bottom: 0; }

        .label { color: var(--text-muted); }
        .value { color: var(--text-main); font-weight: 600; }

        .btn {
            display: block;
            background: var(--primary);
            color: white;
            text-decoration: none;
            padding: 0.85rem 1.5rem;
            border-radius: 0.75rem;
            font-weight: 600;
            transition: all 0.2s;
            margin-bottom: 0.75rem;
        }

        .btn:hover { 
            filter: brightness(1.1);
            transform: translateY(-1px);
        }

        .btn-secondary {
            background: transparent;
            color: var(--text-muted);
            border: 1px solid #e2e8f0;
        }

        .btn-secondary:hover {
            background: #f8fafc;
            color: var(--text-main);
        }
    </style>
</head>
<body>
    <div class="card">
        <div class="icon-container">
            <svg class="checkmark" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
            </svg>
        </div>
        <h1>Payment Successful!</h1>
        <p>Your transaction was processed successfully. A confirmation email has been sent to your inbox.</p>
        
        <div class="details">
            <div class="detail-row">
                <span class="label">Amount Paid</span>
                <span class="value"><?php echo $amount; ?>/-</span>
            </div>
            <div class="detail-row">
                <span class="label">Date</span>
                <span class="value"><?php echo $date; ?></span>
            </div>
            <div class="detail-row">
                <span class="label">Order ID</span>
                <span class="value"><?php echo $order_id; ?></span>
            </div>
        </div>

        <a href="dashboard/order_history.php" class="btn">View Order History</a>
        <a href="index.php" class="btn btn-secondary">Back to Home</a>
    </div>
</body>
</html>
