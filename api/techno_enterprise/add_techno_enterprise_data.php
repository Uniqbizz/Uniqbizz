<?php
require "../connect.php";

header('Content-Type: application/json');

$current_year = date('Y');

// Validate request method
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
    exit();
}

// Function to sanitize input
function clean_input($data) {
    return htmlspecialchars(strip_tags(trim($data)));
}

// Get raw POST data
$data = json_decode(file_get_contents("php://input"), true);

// Check if data is valid JSON
if (!$data) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid JSON format']);
    exit();
}

// Required fields
$required_fields = [
    'user_id_name', 'reference_name', 'firstname', 'lastname', 'nominee_name', 'nominee_relation',
    'email', 'gender', 'gst_no', 'country_code', 'phone', 'amount', 'dob', 'profile_pic',
    'pan_card', 'aadhar_card', 'voting_card', 'passbook', 'payment_proof', 'paymentMode',
    'chequeNo', 'chequeDate', 'bankName', 'transactionNo', 'address', 'pincode', 'country',
    'state', 'city'
];
// Check for missing fields
foreach ($required_fields as $field) {
    if (!isset($data[$field]) || empty($data[$field])) {
        echo json_encode(['status' => 'error', 'message' => "Missing field: $field"]);
        exit();
    }
}

$user_id_name=clean_input($data['user_id_name']);
$registrant=clean_input($data['reference_name']);
$firstname=clean_input($data['firstname']);
$lastname=clean_input($data['lastname']);
$nominee_name=clean_input($data['nominee_name']);
$nominee_relation=clean_input($data['nominee_relation']);
$email=clean_input($data['email']);
$gender=clean_input($data['gender']);
$gst_no=clean_input($data['gst_no']);
$country_code=clean_input($data['country_code']);
$phone_no=clean_input($data['phone']);
$amount=clean_input($data['amount']);
$bdate=clean_input($data['dob']);
$profile_pic=clean_input($data['profile_pic']);
$pan_card=clean_input($data['pan_card']);
$aadhar_card=clean_input($data['aadhar_card']);
$voting_card=clean_input($data['voting_card']);
$passbook=clean_input($data['passbook']);
$payment_proof=clean_input($data['payment_proof']);
$paymentMode=clean_input($data['paymentMode']);
$chequeNo=clean_input($data['chequeNo']);
$chequeDate=clean_input($data['chequeDate']);
$bankName=clean_input($data['bankName']);
$transactionNo=clean_input($data['transactionNo']);
$address=clean_input($data['address']);
$pincode=clean_input($data['pincode']);
$country=clean_input($data['country']);
$state=clean_input($data['state']);
$city=clean_input($data['city']);

$user_type="16";
$register_by = '1'; // Admin
$status = '2';

// Calculate age
$birth_year = substr($bdate, 0, 4);
$age = $current_year - intval($birth_year);

// data insertion for logs tables 
$title="Techno Enterprise";
$message="Added new Techno Enterprise by admin";
$message2="Added new Techno Enterprise by admin";
$fromWhom="1";
$operation="Add";

// Insert employee data
$sql= "INSERT INTO `corporate_agency` (firstname, lastname, nominee_name, nominee_relation, email, country_code, contact_no , date_of_birth, age, gender, country, state, city, pincode, address, profile_pic, gst_no, amount,  pan_card, aadhar_card, voting_card, bank_passbook, payment_proof, user_type, registrant, payment_mode, cheque_no, cheque_date, bank_name, transaction_no, reference_no, register_by, status) VALUES (:firstname ,:lastname, :nominee_name, :nominee_relation, :email, :country_code, :contact_no, :bdate, :age, :gender , :country, :state, :city, :pincode,:address,:profile_pic, :gst_no, :amount, :pan_card,:aadhar_card,:voting_card,:bank_passbook, :payment_proof, :user_type,:registrant, :payment_mode, :cheque_no, :cheque_date, :bank_name, :transaction_no, :reference_no, :register_by, :status)";

$stmt3 =$conn->prepare($sql);

    $result2=$stmt3->execute(array(
        ':firstname' => $firstname, 
        ':lastname' => $lastname, 
        ':nominee_name' => $nominee_name,
        ':nominee_relation' => $nominee_relation,
        ':gst_no' => $gst_no,
        ':amount' => $amount,
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
        ':pan_card' => $pan_card,
        ':aadhar_card' => $aadhar_card,
        ':voting_card' => $voting_card,
        ':bank_passbook' => $passbook,  
        ':payment_proof' => $payment_proof,  
        ':user_type' => $user_type,
        ':registrant' =>$registrant,
        ':payment_mode' => $paymentMode, 
        ':cheque_no' => $chequeNo, 
        ':cheque_date' => $chequeDate, 
        ':bank_name' => $bankName, 
        ':transaction_no' => $transactionNo,
        ':reference_no' => $user_id_name,
        ':register_by' => $register_by,
		':status' => $status
    ));

    if($result2){

        $sql2= "INSERT INTO logs (title,message,message2,reference_no, register_by, from_whom,operation) VALUES (:title ,:message, :message2, :reference_no, :register_by, :from_whom,:operation)";
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

        echo json_encode(['status' => 'success', 'message' => 'Employee added successfully']);
    }else{
        echo json_encode(['status' => 'error', 'message' => 'Error adding employee']);
    }
?>
