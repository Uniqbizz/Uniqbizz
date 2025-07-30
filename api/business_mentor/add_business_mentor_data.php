<?php
require '../connect.php';
header('Content-Type: application/json');

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(["status" => "error", "message" => "Invalid request method"]);
    exit;
}

// Capture JSON data
$data = json_decode(file_get_contents('php://input'), true);
if (!$data) {
    echo json_encode(["status" => "error", "message" => "Invalid JSON data"]);
    exit;
}

function getData($key, $default = null) {
    global $data;
    return isset($data[$key]) ? trim($data[$key]) : $default;
}

// Collect data
$user_id_name = getData('user_id_name');
$registrant = getData('reference_name');
$firstname = getData('firstname');
$lastname = getData('lastname');
$nominee_name = getData('nominee_name');
$nominee_relation = getData('nominee_relation');
$email = getData('email');
$gender = getData('gender');
$country_code = getData('country_code');
$phone_no = getData('phone');
$bdate = getData('dob');
$profile_pic = getData('profile_pic');
$pan_card = getData('pan_card');
$aadhar_card = getData('aadhar_card');
$voting_card = getData('voting_card');
$passbook = getData('passbook');
$address = getData('address');
$pincode = getData('pincode');
$country = getData('country');
$state = getData('state');
$city = getData('city');
$zone = getData('zone');
$branch = getData('branch');
$payment_fee=getData('payment_fee');
$payment_proof=getData('payment_proof');
$payment_mode=getData('paymentMode');
$cheque_no=getData('chequeNo');
$cheque_date=getData('chequeDate');
$bank_name=getData('bankName');
$transaction_no=getData('transactionNo');

$user_type = "26";
$register_by = "1";
$status = '2';

// data insertion for logs tables 
$title="Business Mentor";
$message="Added new Business Mentor by admin";
$message2="Added new Business Mentor by admin";
$fromWhom="1";
$operation="Add";

// Validate required fields
if (!$user_id_name || !$firstname || !$lastname || !$email || !$phone_no || !$bdate) {
    echo json_encode(["status" => "error", "message" => "Required fields are missing."]);
    exit;
}

// Calculate Age
$current_year = date('Y');
$birth_year = (int)date('Y', strtotime($bdate));
$age = $current_year - $birth_year;

try {
    // Insert into business_mentor table
    $sql= "INSERT INTO `business_mentor` ( 
		firstname, 
		lastname, 
		nominee_name, 
		nominee_relation,
		paid_amount, 
		email, 
		country_code, 
		contact_no , 
		date_of_birth, 
		age, 
		gender, 
		country, 
		state, 
		city, 
		pincode, 
		address, 
		zone, 
		branch, 
		profile_pic,
		payment_mode,
		cheque_no, 
		cheque_date,
		bank_name,
		transaction_no,
		payment_proof,
		pan_card, 
		aadhar_card, 
		voting_card, 
		bank_passbook, 
		user_type, 
		registrant, 
		reference_no, 
		register_by, 
		status)
	VALUES ( 
		:firstname ,
		:lastname, 
		:nominee_name, 
		:nominee_relation,
		:paid_amount, 
		:email, 
		:country_code, 
		:contact_no, 
		:bdate, 
		:age, 
		:gender , 
		:country, 
		:state, 
		:city, 
		:pincode,
		:address, 
		:zone, 
		:branch, 
		:profile_pic,
		:payment_mode,
		:cheque_no, 
		:cheque_date,
		:bank_name,
		:transaction_no,
		:payment_proof, 
		:pan_card,
		:aadhar_card,
		:voting_card,
		:bank_passbook, 
		:user_type,
		:registrant,  
		:reference_no, 
		:register_by, 
		:status)";

    $stmt = $conn->prepare($sql);
    $stmt->execute([
        ':firstname' => $firstname, 
        ':lastname' => $lastname, 
        ':nominee_name' => $nominee_name,
        ':nominee_relation' => $nominee_relation,
        // ':gst_no' => $gst_no,
        // ':complimentary' => $complimentary,
        // ':converted' => $converted,
        // ':business_package' => $business_package,
        ':paid_amount' => $payment_fee,
        ':email' => $email,
        ':country_code' => $country_code, 
        ':contact_no' => $phone_no,
        ':country' => $country,
        ':state' => $state,
        ':city' => $city,
        ':pincode' => $pincode,
        ':address' => $address,  
        ':zone' => $zone,
        ':branch' => $branch,
        ':bdate' => $bdate,
        ':age' => $age,  
        ':gender' => $gender,
        ':profile_pic' => $profile_pic,
		':payment_mode'=>$payment_mode,
		':cheque_no'=>$cheque_no, 
		':cheque_date'=>$cheque_date,
		':bank_name'=>$bank_name,
		':transaction_no'=>$transaction_no,
		':payment_proof'=>$payment_proof, 
        // ':kyc' => $kyc,
        ':pan_card' => $pan_card,
        ':aadhar_card' => $aadhar_card,
        ':voting_card' => $voting_card,
        ':bank_passbook' => $passbook,  
        ':user_type' => $user_type,
        ':registrant' =>$registrant,
        ':reference_no' => $user_id_name,
        ':register_by' => $register_by,
        ':status' => $status
    ]);

    // Insert into logs table
    $logSql = "INSERT INTO logs ( title,message,message2,reference_no, register_by, from_whom,operation) VALUES (:title ,:message, :message2, :reference_no, :register_by, :from_whom, :operation)";

    $logStmt = $conn->prepare($logSql);
    $logStmt->execute([
        ':title' => $title,
        ':message' => $message,
        ':message2' =>$message2,
        ':reference_no' => $user_id_name,
        ':register_by' => $register_by,
        ':from_whom' => $fromWhom,
		':operation' => $operation
    ]);

    echo json_encode(["status" => "success", "message" => "Business mentor added successfully!"]);
} catch (PDOException $e) {
    echo json_encode(["status" => "error", "message" => $e->getMessage()]);
}
?>