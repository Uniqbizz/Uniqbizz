<?php
header('Content-Type: application/json');

require '../../../connect.php';
date_default_timezone_set("Asia/Kolkata");

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(["status" => "error", "message" => "Invalid request method"]);
    exit;
}

// Helper function to generate payment ID
function generatePaymentID()
{
    return "PAID" . date("YmdHis"); // Format: PAIDYYYYMMDDHHMMSS
}

// Read and decode JSON input (for JSON-based POST requests)
$data = json_decode(file_get_contents('php://input'), true);
if (!$data) {
    echo json_encode(["status" => "error", "message" => "Invalid JSON data"]);
    exit;
}

function getData($key, $default = null)
{
    global $data;
    return isset($data[$key]) ? trim($data[$key]) : $default;
}

try {
    $ta_id = getData('ta_id');
    $ta_fname = getData('ta_fname');
    $ta_lname = getData('ta_lname');
    $ta_topup_amt = getData('ta_topup_amt');
    $ta_pay_mode = getData('ta_pay_mode');
    $ta_cheque_no = getData('ta_cheque_no') ?? null;
    $ta_cheque_date = getData('ta_cheque_date') ?? null;
    $ta_bank_name = getData('ta_bank_name') ?? null;
    $ta_transaction_id = getData('ta_transaction_id') ?? null;
    $ta_ref_img = getData('ta_ref_img');
    $ta_created_date = date('Y-m-d H:i:s');
    $ta_status = 1;
    $payment_id = generatePaymentID();
    $ta_name = $ta_fname . ' ' . $ta_lname;

    // Insert into ta_top_up_payment
    $stmt1 = $conn->prepare("
        INSERT INTO ta_top_up_payment 
        (ta_id, ta_fname, ta_lname, top_up_amt, paymentid, pay_mode, cheque_no, cheque_date, bank_name, 
         transaction_id, ref_img, updated_date, updated_by, status) 
        VALUES 
        (:ta_id, :ta_fname, :ta_lname, :top_up_amt, :paymentid, :pay_mode, :cheque_no, :cheque_date, 
         :bank_name, :transaction_id, :ref_img, :updated_date, :updated_by, :status)
    ");

    $result1 = $stmt1->execute([
        ':ta_id' => $ta_id,
        ':ta_fname' => $ta_fname,
        ':ta_lname' => $ta_lname,
        ':top_up_amt' => $ta_topup_amt,
        ':paymentid' => $payment_id,
        ':pay_mode' => $ta_pay_mode,
        ':cheque_no' => $ta_cheque_no,
        ':cheque_date' => $ta_cheque_date,
        ':bank_name' => $ta_bank_name,
        ':transaction_id' => $ta_transaction_id,
        ':ref_img' => $ta_ref_img,
        ':updated_date' => $ta_created_date,
        ':updated_by' => $ta_id,
        ':status' => $ta_status
    ]);

    if ($result1) {
        // Insert into logs
        $stmt2 = $conn->prepare("
            INSERT INTO topup_logs 
            (ta_id, ta_name, title, message, message2, from_whom, operation, updated_date, status)
            VALUES
            (:ta_id, :ta_name, :title, :message, :message2, :from_whom, :operation, :updated_date, :status)
        ");

        $result2 = $stmt2->execute([
            ':ta_id' => $ta_id,
            ':ta_name' => $ta_name,
            ':title' => 'TA top up',
            ':message' => 'Added TA top up balance',
            ':message2' => '',
            ':from_whom' => $ta_id,
            ':operation' => '',
            ':updated_date' => $ta_created_date,
            ':status' => 'Pending'
        ]);

        if ($result2) {
            echo json_encode([
                'success' => true,
                'message' => 'TA top-up added successfully.',
                'data' => [
                    'payment_id' => $payment_id,
                    'ta_id' => $ta_id,
                    'topup_amount' => $ta_topup_amt,
                    'status' => $ta_status
                ]
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Failed to insert top-up logs.'
            ]);
        }
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Failed to insert TA top-up data.'
        ]);
    }
} catch (PDOException $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Database error: ' . $e->getMessage()
    ]);
}
