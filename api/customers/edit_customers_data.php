<?php
require "../connect.php";
header('Content-Type: application/json');
$current_year = date('Y'); 

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

// Helper function to fetch data
function getData($key, $default = null) {
    global $data;
    return isset($data[$key]) ? trim($data[$key]) : $default;
}

$fid = getData("ref_id");
$editfor = getData("editfor");
$identifier_id = getData("id");

if ($editfor === 'pending') {
    $identifier_name = 'id=';
    $message = "Updated Customer details from $editfor list";
    $message2 = "Updated Customer details from $editfor list";
} elseif ($editfor === 'registered') {
    $identifier_name = 'ca_customer_id=';
    $message = "$identifier_id Details has been updated from $editfor list";
    $message2 = "$identifier_id Details has been updated from $editfor list";
} else {
    echo json_encode(["status" => "error", "message" => "Invalid editfor value"]);
    exit;
}

// Fetch all data
$firstname = getData('firstname');
$lastname = getData('lastname');
$nominee_name = getData('nominee_name');
$nominee_relation = getData('nominee_relation');
$email = getData('email');
$gender = getData('gender');
$country_code = getData('country_code');
$phone = getData('phone');
$dob = getData('dob');
$profile_pic = getData('profile_pic');
$pan_card = getData('pan_card');
$aadhar_card = getData('aadhar_card');
$voting_card = getData('voting_card');
$bank_passbook = getData('passbook');
$payment_proof = getData('payment_proof');
$payment_mode = getData('paymentMode');
$cheque_no = getData('chequeNo');
$cheque_date = getData('chequeDate');
$bank_name = getData('bankName');
$transaction_no = getData('transactionNo');
$address = getData('address');
$pincode = getData('pincode');
$country = getData('country');
$state = getData('state');
$city = getData('city');

// Calculate age
$birthYear = str_split($dob, 4);
$birth_year = $birthYear[0];
$age = $current_year - $birth_year;

$user_type_id = '11';
$title = "Customer";
$fromWhom = "1";
$register_by = "1";
$operation="Edit";

try {
    $sql1 = "UPDATE ca_customer 
    SET firstname=:firstname, lastname=:lastname, nominee_name=:nominee_name, 
    nominee_relation=:nominee_relation, country_code=:country_code, contact_no=:phone, 
    email=:email, gender=:gender, date_of_birth=:dob, age=:age, country=:country, 
    state=:state, city=:city, pincode=:pincode, address=:address, profile_pic=:profile_pic, 
    pan_card=:pan_card, aadhar_card=:aadhar_card, voting_card=:voting_card, 
    passbook=:bank_passbook, payment_proof=:payment_proof, payment_mode=:payment_mode, 
    cheque_no=:cheque_no, cheque_date=:cheque_date, bank_name=:bank_name, 
    transaction_no=:transaction_no 
    WHERE $identifier_name :identifier_id";

$stmt = $conn->prepare($sql1);
$result = $stmt->execute([
    ':firstname' => $firstname,
    ':lastname' => $lastname,
    ':nominee_name' => $nominee_name,
    ':nominee_relation' => $nominee_relation,
    ':country_code' => $country_code,
    ':phone' => $phone,
    ':email' => $email,
    ':gender' => $gender,
    ':dob' => $dob,
    ':age' => $age,
    ':country' => $country,
    ':state' => $state,
    ':city' => $city,
    ':pincode' => $pincode,
    ':address' => $address,
    ':profile_pic' => $profile_pic,
    ':pan_card' => $pan_card,
    ':aadhar_card' => $aadhar_card,
    ':voting_card' => $voting_card,
    ':bank_passbook' => $bank_passbook,
    ':payment_proof' => $payment_proof,
    ':payment_mode' => $payment_mode,
    ':cheque_no' => $cheque_no,
    ':cheque_date' => $cheque_date,
    ':bank_name' => $bank_name,
    ':transaction_no' => $transaction_no,
    ':identifier_id' => $identifier_id
]);


    $sql = "UPDATE login SET username=:email WHERE user_id=:user_id and user_type_id=:user_type_id";
    $stmt2 = $conn->prepare($sql);
    $stmt2->execute(['email' => $email, 'user_type_id' => $user_type_id, 'user_id' => $identifier_id]);

    $sql3 = "INSERT INTO logs (user_id,title,message,message2,reference_no,register_by, from_whom, operation) VALUES (:user_id,:title ,:message, :message2, :reference_no,:register_by, :from_whom,:operation)";
    $stmt3 = $conn->prepare($sql3);
    $stmt3->execute([			
    ':user_id' => $identifier_id,
    ':title' => $title,
    ':message' => $message,
    ':message2' =>$message2,
    ':reference_no' => $fid,
    ':register_by' => $register_by,
    ':from_whom' => $fromWhom,
    ':operation' => $operation]);

    echo json_encode(["status" => "success", "message" => "Customer details updated successfully"]);
} catch (Exception $e) {
    echo json_encode(["status" => "error", "message" => $e->getMessage()]);
}
?>
