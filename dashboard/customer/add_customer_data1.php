<?php
// session_start();
require '../connect.php';
$current_year = date('Y');

$cu_ref_id = $_POST['cu_ref_id'];
$cu_ref_name = $_POST['cu_ref_name'];
$user_id_name = $_POST['user_id_name'];
$registrant = $_POST['reference_name'];
$firstname = $_POST['firstname'];
$lastname = $_POST['lastname'];
$nominee_name = $_POST['nominee_name'];
$nominee_relation = $_POST['nominee_relation'];
$email = $_POST['email'];
$gender = $_POST['gender'];
$payment_fee = $_POST['payment_fee'];
// $complimentary=$_POST['complimentary'];
// $converted=$_POST['converted'];
$country_code = $_POST['country_code'];
$phone_no = $_POST['phone'];
// $gst_no=$_POST['gst_no'];
// $business_package=$_POST['business_package'];
$paid_amount=$_POST['payment_fee'];
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
$register_by = $_POST['register_by']; //11 or 10
$registrant_id = $_POST['registrant_id']; // TC250001 or CU250001
$user_type = "10";
$editfor = $_POST['editfor'];
$userId = $_POST['userId']; // BH250001 
$userType = $_POST['userType']; //25
$customer_type=$_POST['customer_type'];
$payment_label=$_POST['payment_label'];


// get age of the user
$birthYear = str_split($bdate, 4);
$birth_year = $birthYear[0];
$age = $current_year - $birth_year;

// data insertion for logs tables 
$title = "Customer";
//checking user type and add referance for logs message
if ($register_by == 11 && $editfor != 'addreff') {
    $message = "Added new Customer by Travel Consultant";
    $message2 = "Added new Customer by Travel Consultant";
} else if ($register_by == 10) {
    $message = "Added new Customer by Customer";
    $message2 = "Added new Customer by Customer";
} else if ($editfor == 'addreff' && $register_by == 11) {
    $message = "Added new Customer by Travel Consultant through Add Reference";
    $message2 = "Added new Customer by Travel Consultant through Add Reference";;
} else {
    $message = "Added new Customer by Business Consultant";
    $message2 = "Added new Customer by Business Consultant";
}
$fromWhom = $register_by;
$operation = "Add";

//part division
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

$sql = "INSERT INTO `ca_customer` (firstname, lastname, nominee_name, nominee_relation, email, country_code, contact_no , 
        date_of_birth, age, gender, profile_pic, pan_card, aadhar_card, voting_card, passbook, payment_proof,payment_mode, 
        cheque_no, cheque_date, bank_name, transaction_no, country, state, city, pincode, address,  user_type, registrant, 
        reference_no, register_by, ta_reference_no, ta_reference_name,paid_amount,customer_type) 
    VALUES (:firstname ,:lastname, :nominee_name, :nominee_relation, :email, :country_code, :contact_no, :bdate, :age, :gender , 
        :profile_pic, :pan_card, :aadhar_card, :voting_card, :passbook, :payment_proof,:payment_mode, :cheque_no, :cheque_date, 
        :bank_name, :transaction_no, :country, :state, :city, :pincode,:address, :user_type,:registrant,  :reference_no, :register_by , 
        :ta_reference_no, :ta_reference_name,:paid_amount,:customer_type)";
$stmt3 = $conn->prepare($sql);

$result2 = $stmt3->execute(array(
    ':firstname' => $firstname,
    ':lastname' => $lastname,
    ':nominee_name' => $nominee_name,
    ':nominee_relation' => $nominee_relation,
    // ':gst_no' => $gst_no,
    // ':complimentary' => $complimentary,
    // ':converted' => $converted,
    ':customer_type' => $payment_label,
    ':paid_amount' => $paid_amount,
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
    ':profile_pic' => $profile_pic,
    // ':kyc' => $kyc,
    ':pan_card' => $pan_card,
    ':aadhar_card' => $aadhar_card,
    ':voting_card' => $voting_card,
    ':passbook' => $passbook,
    ':payment_proof' => $payment_proof,
    ':payment_mode' =>$paymentMode,
    ':cheque_no' =>$chequeNo,
    ':cheque_date' =>$chequeDate,
    ':bank_name' =>$bankName,
    ':transaction_no' =>$transactionNo,
    ':user_type' => $user_type,
    ':registrant' => $cu_ref_name,
    ':reference_no' => $cu_ref_id,
    ':register_by' => $register_by,
    ':ta_reference_no' => $user_id_name,
    ':ta_reference_name' => $registrant
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

    $sql2 = "INSERT INTO logs (title,message,message2,reference_no, register_by, from_whom, operation) VALUES (:title ,:message, :message2, :reference_no, :register_by, :from_whom, :operation)";
    $stmt = $conn->prepare($sql2);

    $result = $stmt->execute(array(
        ':title' => $title,
        ':message' => $message,
        ':message2' => $message2,
        ':reference_no' => $registrant_id,
        ':register_by' => $register_by,
        ':from_whom' => $register_by,
        ':operation' => $operation
    ));

    if ($result) {
        echo 1;
    } else {
        echo 0;
    }
} else {
    echo 0;
}
