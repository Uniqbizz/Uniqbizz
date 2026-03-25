<?php
header('Content-Type: application/json');
require '../../../connect.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(["status" => "error", "message" => "Invalid request method"]);
    exit;
}

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

function divideAmount($totalAmount, $fixedAmount = 3000)
{
    $parts = [];
    if ($totalAmount == 10000) $fixedAmount = 2500;
    $fullParts = floor($totalAmount / $fixedAmount);
    $remaining = $totalAmount % $fixedAmount;
    for ($i = 0; $i < $fullParts; $i++) $parts[] = $fixedAmount;
    if ($remaining > 0) $parts[] = $remaining;
    return $parts;
}

function generatePaymentID()
{
    return "PAID" . date("YmdHis");
}

function generateUniqueCoupon()
{
    $year = date("Y");
    $uniquePart = bin2hex(random_bytes(6));
    return strtoupper($year . substr($uniquePart, 0, 11));
}

// === INPUT DATA ===
$current_year = date('Y');

$ta_user_id_name = getData('ta_user_id_name'); // ta ref id
$ta_registrant = getData('ta_reference_name'); // ta ref name
$cu_user_id_name = getData('cu_user_id_name'); // cu ref id
$cu_registrant = getData('cu_reference_name'); // cu ref name
$firstname = getData('firstname');
$lastname = getData('lastname');
$email = getData('email');
$gender = getData('gender');
$payment_fee = getData('payment_fee');
$payment_label = getData('payment_label');
$comp_chek = getData('isComplementary');
$country_code = getData('country_code');
$phone_no = getData('phone');
$bdate = getData('dob');
$profile_pic = getData('profile_pic');
$pan_card = getData('pan_card');
$aadhar_card = getData('aadhar_card');
$voting_card = getData('voting_card');
$passbook = getData('passbook');
$payment_proof = getData('payment_proof');
$paymentMode = getData('paymentMode');
$chequeNo = getData('chequeNo');
$chequeDate = getData('chequeDate');
$bankName = getData('bankName');
$transactionNo = getData('transactionNo');
$address = getData('address');
$pincode = getData('pincode');
$country = getData('country');
$state = getData('state');
$city = getData('city');
$note = getData('note');

$status = "2";
$user_type = "10";
$register_by = getData('register_by');
$birthYear = substr($bdate, 0, 4);
$age = $current_year - intval($birthYear);

// === CUSTOMER INSERT ===
$sql = "INSERT INTO `ca_customer` (firstname, lastname, email, country_code, contact_no , date_of_birth, age, gender, country, state, city, pincode, address, note, profile_pic, pan_card, aadhar_card, voting_card, passbook, payment_proof, payment_mode, cheque_no, cheque_date, bank_name, transaction_no, user_type, ta_reference_no, ta_reference_name, reference_no, registrant, paid_amount, customer_type, comp_chek, register_by, status)
        VALUES (:firstname ,:lastname, :email, :country_code, :contact_no, :bdate, :age, :gender , :country, :state, :city, :pincode, :address, :note, :profile_pic ,:pan_card,:aadhar_card,:voting_card,:passbook, :payment_proof, :payment_mode, :cheque_no, :cheque_date, :bank_name, :transaction_no, :user_type, :ta_reference_no, :ta_reference_name , :reference_no, :registrant, :paid_amount, :customer_type, :comp_chek, :register_by, :status)";
$stmt3 = $conn->prepare($sql);

$result2 = $stmt3->execute([
    ':firstname' => $firstname,
    ':lastname' => $lastname,
    ':email' => $email,
    ':country_code' => $country_code,
    ':contact_no' => $phone_no,
    ':bdate' => $bdate,
    ':age' => $age,
    ':gender' => $gender,
    ':country' => $country,
    ':state' => $state,
    ':city' => $city,
    ':pincode' => $pincode,
    ':address' => $address,
    ':note' => $note,
    ':profile_pic' => $profile_pic,
    ':pan_card' => $pan_card,
    ':aadhar_card' => $aadhar_card,
    ':voting_card' => $voting_card,
    ':passbook' => $passbook,
    ':payment_proof' => $payment_proof,
    ':payment_mode' => $paymentMode,
    ':cheque_no' => $chequeNo,
    ':cheque_date' => $chequeDate,
    ':bank_name' => $bankName,
    ':transaction_no' => $transactionNo,
    ':user_type' => $user_type,
    ':ta_reference_no' => $ta_user_id_name,
    ':ta_reference_name' => $ta_registrant,
    ':reference_no' => $cu_user_id_name,
    ':registrant' => $cu_registrant,
    ':paid_amount' => $payment_fee,
    ':customer_type' => $payment_label,
    ':comp_chek' => $comp_chek,
    ':register_by' => $register_by,
    ':status' => $status
]);

$title = "Customer";
$message = "Added new Customer by Customer";
$message2 = "Added new Customer by Customer";
$user_id_name = $ta_user_id_name ?: $cu_user_id_name;
$fromWhom = "10"; // You can customize this if needed


if ($result2) {
    $customerId = $conn->lastInsertId();

    if (in_array($payment_label, ['Prime', 'Premium', 'Premium Plus'])) {
        $cp_parts = ($payment_label == 'Premium Plus') ? divideAmount(30000) : divideAmount($payment_fee);
        $payment_id = generatePaymentID();

        $sqlInsertCoupon = "INSERT INTO cu_coupons (user_id, payment_id, code, coupon_amt, usage_status, confirm_status) VALUES (:user_id, :payment_id, :code, :coupon_amt, :usage_status, :confirm_status)";
        $stmt = $conn->prepare($sqlInsertCoupon);

        foreach ($cp_parts as $coupon_amt) {
            $stmt->execute([
                ':user_id' => $customerId,
                ':payment_id' => $payment_id,
                ':code' => generateUniqueCoupon(),
                ':coupon_amt' => $coupon_amt,
                ':usage_status' => 0,
                ':confirm_status' => 0
            ]);
        }
    }

    // === LOGGING ===
    $sql3 = "INSERT INTO logs (title,message,message2,reference_no, register_by, from_whom, operation)
        VALUES (:title ,:message, :message2, :reference_no, :register_by, :from_whom, :operation)";
    $stmt1 = $conn->prepare($sql3);

    $result = $stmt1->execute(array(
        ':title' => $title,
        ':message' => $message,
        ':message2' => $message2,
        ':reference_no' => $user_id_name,
        ':register_by' => $register_by,
        ':from_whom' => $fromWhom,
        ':operation' => 'Add'
    ));

    echo json_encode(["status" => "success", "message" => "Customer added successfully"]);
} else {
    echo json_encode(["status" => "error", "message" => "Failed to add customer"]);
}
