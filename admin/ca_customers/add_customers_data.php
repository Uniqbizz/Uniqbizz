<?php
// session_start();
require '../connect.php';
$current_year = date('Y');

$user_id_name = $_POST['user_id_name'];
$registrant = $_POST['reference_name'];
$firstname = $_POST['firstname'];
$lastname = $_POST['lastname'];
// $nominee_name = $_POST['nominee_name'];
// $nominee_relation = $_POST['nominee_relation'];
$email = $_POST['email'];
$gender = $_POST['gender'];
$payment_fee = $_POST['payment_fee'];
$payment_label = $_POST['payment_label'];
$comp_chek = $_POST['isComplementary'];
// $complimentary=$_POST['complimentary'];
// $converted=$_POST['converted'];
$country_code = $_POST['country_code'];
$phone_no = $_POST['phone'];
// $gst_no=$_POST['gst_no'];
// $business_package=$_POST['business_package'];
// $amount=$_POST['amount'];
// $age=$_POST['age'];
$bdate = $_POST['dob'];
$profile_pic = $_POST['profile_pic'];
// $kyc=$_POST['kyc'];
$pan_card = $_POST['pan_card'];
$aadhar_card = $_POST['aadhar_card'];
$voting_card = $_POST['voting_card'];
$passbook = $_POST['passbook'];
$payment_proof = $_POST['payment_proof'];
$paymentMode = $_POST['paymentMode'];
$chequeNo = $_POST['chequeNo'];
$chequeDate = $_POST['chequeDate'];
$bankName = $_POST['bankName'];
$transactionNo = $_POST['transactionNo'];
$address = $_POST['address'];
$pincode = $_POST['pincode'];
$country = $_POST['country'];
$state = $_POST['state'];
$city = $_POST['city'];
$note = $_POST['note'];
$status = "2";

$user_type = "10";
$register_by = "1";

// get age of the user
$birthYear = str_split($bdate, 4);
$birth_year = $birthYear[0];
$age = $current_year - $birth_year;

// data insertion for logs tables 
$title = "Customer";
$message = "Added new Customer by admin";
$message2 = "Added new Customer by admin";
$fromWhom = "1";
//3 part division
function divideAmount($totalAmount, $fixedAmount = 3000)
{
    $parts = [];

    // How many full ₹3000 parts fit?
    if($totalAmount == 10000){
		$fixedAmount = 2500;
	}
    $fullParts = floor($totalAmount / $fixedAmount);
    $remaining = $totalAmount % $fixedAmount;

    // Add full ₹3000 parts
    for ($i = 0; $i < $fullParts; $i++) {
        $parts[] = $fixedAmount;
    }

    // Add remaining amount to last part if needed
    if ($remaining > 0) {
        $parts[] = $remaining;
    }

    return $parts;
}
//generate payment id
function generatePaymentID()
{
    return "PAID" . date("YmdHis"); // Format: PAIDYYYYMMDDHHMMSS
}
//coupon code genaration
function generateUniqueCoupon()
{
    $year = date("Y"); // Get current year
    $uniquePart = bin2hex(random_bytes(6)); // Generate a unique random string (6 bytes = 12 hex characters)

    return strtoupper($year . substr($uniquePart, 0, 11)); // Ensures it's exactly 15 characters
}

$sql = "INSERT INTO `ca_customer` (firstname, lastname, email, country_code, contact_no , date_of_birth, age, gender, country, state, city, pincode, address, note, profile_pic, pan_card, aadhar_card, voting_card, passbook,payment_proof, payment_mode, cheque_no, cheque_date, bank_name, transaction_no, user_type, ta_reference_no, ta_reference_name,paid_amount,customer_type,comp_chek, register_by, status) 
        VALUES (:firstname ,:lastname, :email, :country_code, :contact_no, :bdate, :age, :gender , :country, :state, :city, :pincode,:address, :note, :profile_pic ,:pan_card,:aadhar_card,:voting_card,:passbook, :payment_proof, :payment_mode, :cheque_no, :cheque_date, :bank_name, :transaction_no, :user_type, :ta_reference_no,  :ta_reference_name,:paid_amount,:customer_type, :comp_chek, :register_by, :status)";
$stmt3 = $conn->prepare($sql);

$result2 = $stmt3->execute(array(
    ':firstname' => $firstname,
    ':lastname' => $lastname,
    // ':nominee_name' => $nominee_name,
    // ':nominee_relation' => $nominee_relation,
    // ':gst_no' => $gst_no,
    // ':complimentary' => $complimentary,
    // ':converted' => $converted,
    // ':business_package' => $business_package,
    // ':amount' => $amount,
    ':email' => $email,
    ':country_code' => $country_code,
    ':contact_no' => $phone_no,
    ':country' => $country,
    ':state' => $state,
    ':city' => $city,
    ':pincode' => $pincode,
    ':address' => $address,
    ':bdate' => $bdate,
    ':age' => $age,
    ':gender' => $gender,
    ':note' => $note,
    ':profile_pic' => $profile_pic,
    // ':kyc' => $kyc,
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
    ':ta_reference_no' => $user_id_name,
    ':ta_reference_name' => $registrant,
    ':paid_amount' => $payment_fee,
    ':customer_type' => $payment_label,
    ':comp_chek' => $comp_chek,
    ':register_by' => $register_by,
    ':status' => $status
));

if ($result2) {
    if ($payment_label =='Prime') {
        //get the inserted customer
        $sql2 = "SELECT id FROM `ca_customer` ORDER BY id DESC LIMIT 1";
        $stmt1 = $conn->prepare($sql2);
        $stmt1->execute();
        $row = $stmt1->fetch(PDO::FETCH_ASSOC);
        $cp_parts = divideAmount($payment_fee);
        $payment_id = generatePaymentID();
        // Define the SQL query once
        $sqlInsertCoupon = "INSERT INTO cu_coupons (user_id, payment_id, code, coupon_amt, usage_status, confirm_status) 
                            VALUES (:user_id, :payment_id, :code, :coupon_amt, :usage_status, :confirm_status)";

        $stmt = $conn->prepare($sqlInsertCoupon); // Prepare the statement once

        // Loop through all coupon parts dynamically
        foreach ($cp_parts as $coupon_amt) {
            $couponCode = generateUniqueCoupon();

            $stmt->execute([
                ':user_id' => $row['id'],
                ':payment_id' => $payment_id,
                ':code' => $couponCode,
                ':coupon_amt' => $coupon_amt,
                ':usage_status' => 0,
                ':confirm_status' => 0
            ]);
        }
    }
    else if ($payment_label == 'Premium') {
        //get the inserted customer
        $sql2 = "SELECT id FROM `ca_customer` ORDER BY id DESC LIMIT 1";
        $stmt1 = $conn->prepare($sql2);
        $stmt1->execute();
        $row = $stmt1->fetch(PDO::FETCH_ASSOC);
        $cp_parts = divideAmount($payment_fee);
        $payment_id = generatePaymentID();
        // Define the SQL query once
        $sqlInsertCoupon = "INSERT INTO cu_coupons (user_id, payment_id, code, coupon_amt, usage_status, confirm_status) 
                            VALUES (:user_id, :payment_id, :code, :coupon_amt, :usage_status, :confirm_status)";

        $stmt = $conn->prepare($sqlInsertCoupon); // Prepare the statement once

        // Loop through all coupon parts dynamically
        foreach ($cp_parts as $coupon_amt) {
            $couponCode = generateUniqueCoupon();

            $stmt->execute([
                ':user_id' => $row['id'],
                ':payment_id' => $payment_id,
                ':code' => $couponCode,
                ':coupon_amt' => $coupon_amt,
                ':usage_status' => 0,
                ':confirm_status' => 0
            ]);
        }
    }
    else if ($payment_label == 'Premium Plus') {
        //get the inserted customer
        $sql2 = "SELECT id FROM `ca_customer` ORDER BY id DESC LIMIT 1";
        $stmt1 = $conn->prepare($sql2);
        $stmt1->execute();
        $row = $stmt1->fetch(PDO::FETCH_ASSOC);
        $cp_parts = divideAmount('30000');
        $payment_id = generatePaymentID();
        // Define the SQL query once
        $sqlInsertCoupon = "INSERT INTO cu_coupons (user_id, payment_id, code, coupon_amt, usage_status, confirm_status) 
                            VALUES (:user_id, :payment_id, :code, :coupon_amt, :usage_status, :confirm_status)";

        $stmt = $conn->prepare($sqlInsertCoupon); // Prepare the statement once

        // Loop through all coupon parts dynamically
        foreach ($cp_parts as $coupon_amt) {
            $couponCode = generateUniqueCoupon();

            $stmt->execute([
                ':user_id' => $row['id'],
                ':payment_id' => $payment_id,
                ':code' => $couponCode,
                ':coupon_amt' => $coupon_amt,
                ':usage_status' => 0,
                ':confirm_status' => 0
            ]);
        }
    }

    $sql3 = "INSERT INTO logs (title,message,message2,reference_no, register_by, from_whom) 
        VALUES (:title ,:message, :message2, :reference_no, :register_by, :from_whom)";
    $stmt1 = $conn->prepare($sql3);

    $result = $stmt1->execute(array(
        ':title' => $title,
        ':message' => $message,
        ':message2' => $message2,
        ':reference_no' => $user_id_name,
        ':register_by' => $register_by,
        ':from_whom' => $fromWhom
    ));

    if ($result) {
        echo 1;
    } else {
        echo 0;
    }
} else {
    echo 0;
}
