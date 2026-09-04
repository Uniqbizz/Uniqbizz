<?php

include_once(__DIR__ . '/../../dashboard_user_details.php');

header('Content-Type: application/json');


// =========================================================
// GET POST DATA
// =========================================================

$customerId = $_POST['customer_id'] ?? '';
$amount     = $_POST['amount'] ?? '';


// =========================================================
// MESSAGE
// =========================================================

$message = "User request";


// =========================================================
// GENERATE UNIQUE WITHDRAWAL ID
// =========================================================

function generateUniqueId()
{
    // PREFIX
    $prefix = "WD";

    // CURRENT YEAR
    $year = date("Y");

    // GENERATE RANDOM HEX STRING
    // 6 bytes = 12 hex characters
    $uniquePart = strtoupper(
        bin2hex(random_bytes(6))
    );

    // FINAL ID
    return $prefix .
        $year .
        substr($uniquePart, 0, 8);
}


// =========================================================
// BASIC REQUEST CHECK
// =========================================================

if ($customerId === '' || $amount === '') {

    echo json_encode([
        "status" => false,
        "message" => "Invalid withdrawal request."
    ]);

    exit;
}


// =========================================================
// CONVERT AMOUNT
// =========================================================

$amount = (float)$amount;


// =========================================================
// GENERATE TRANSACTION ID
// =========================================================

$transactionId = generateUniqueId();


// =========================================================
// INSERT WITHDRAWAL REQUEST
// =========================================================

try {

    $sqlWithdrawal = $conn->prepare("

        INSERT INTO customer_reference_wallet_encashed
        (
            customer_id,
            enchased_id,
            encashed_amount,
            message,
            status
        )

        VALUES
        (
            :customer_id,
            :enchased_id,
            :encashed_amount,
            :message,
            :status
        )

    ");


    $sqlWithdrawal->execute([

        ":customer_id" =>
            $customerId,

        ":enchased_id" =>
            $transactionId,

        ":encashed_amount" =>
            $amount,

        ":message" =>
            $message,

        ":status" =>
            2

    ]);


    // =====================================================
    // SUCCESS
    // =====================================================

    echo json_encode([

        "status" => true,

        "message" =>
            "Your withdrawal request has been submitted successfully.",

        "transaction_id" =>
            $transactionId,

        "amount" =>
            number_format($amount, 2)

    ]);

    exit;


} catch (PDOException $e) {

    // =====================================================
    // ERROR LOG
    // =====================================================

    error_log(
        "Referral Wallet Withdrawal Error: " .
        $e->getMessage()
    );


    // =====================================================
    // ERROR RESPONSE
    // =====================================================

    echo json_encode([

        "status" => false,

        "message" =>
            "Unable to submit your withdrawal request. Please try again."

    ]);

    exit;
}

?>