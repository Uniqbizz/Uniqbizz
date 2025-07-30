<?php
header('Content-Type: application/json');
require '../connect.php';

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

// Safe data retrieval function
function getData($key, $default = null) {
    global $data;
    return isset($data[$key]) ? trim($data[$key]) : $default;
}

$current_year = date('Y'); 

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
$status = "2";

$user_type = "10";
$register_by = "1";

// Calculate age
$birthYear = substr($bdate, 0, 4);
$age = $current_year - intval($birthYear);

    // data insertion for logs tables 
    $title="Customer";
    $message="Added new Customer by admin";
    $message2="Added new Customer by admin";
    $fromWhom="1";
    $operation="Add";

    $sql= "INSERT INTO `ca_customer` (firstname, lastname, nominee_name, nominee_relation, email, country_code, contact_no , date_of_birth, age, gender, country, state, city, pincode, address, profile_pic, pan_card, aadhar_card, voting_card, passbook,payment_proof, payment_mode, cheque_no, cheque_date, bank_name, transaction_no, user_type, ta_reference_no, ta_reference_name, register_by, status) VALUES (:firstname ,:lastname, :nominee_name, :nominee_relation, :email, :country_code, :contact_no, :bdate, :age, :gender , :country, :state, :city, :pincode,:address,:profile_pic ,:pan_card,:aadhar_card,:voting_card,:passbook, :payment_proof, :payment_mode, :cheque_no, :cheque_date, :bank_name, :transaction_no, :user_type, :ta_reference_no,  :ta_reference_name, :register_by, :status)";
    $stmt3 =$conn->prepare($sql);

    $result2=$stmt3->execute(array(
        ':firstname' => $firstname, 
        ':lastname' => $lastname, 
        ':nominee_name' => $nominee_name,
        ':nominee_relation' => $nominee_relation,
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
        ':register_by' => $register_by,
		':status' => $status
    ));

    if($result2){

        $sql2= "INSERT INTO logs (title,message,message2,reference_no, register_by, from_whom,operation) VALUES (:title ,:message, :message2, :reference_no, :register_by, :from_whom, :operation)";
        $stmt =$conn->prepare($sql2);

        $result=$stmt->execute(array(
            ':title' => $title,
            ':message' => $message,
            ':message2' =>$message2,
            ':reference_no' => $user_id_name,
            ':register_by' => $register_by,
            ':from_whom' => $fromWhom,
            ':operation' => $operation
        ));

        echo json_encode(["status" => "success", "message" => "Customer added successfully!"]);
        
    }else{
        echo json_encode(["status" => "error", "message" => "Customer wasnt inserted!"]);
    }

?>