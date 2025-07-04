<?php

header('Content-Type: application/json');
date_default_timezone_set('Asia/Calcutta');
$today = date('Y-m-d H:i:s');

require '../connect.php';

$current_year = date('Y'); 

// Get JSON input
$data = json_decode(file_get_contents('php://input'), true);

function clean_input($data) {
    return htmlspecialchars(strip_tags(trim($data)));
}

if (!$data) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid JSON format']);
    exit();
}

if (!$data || !isset($data['id']) || !isset($data['editfor'])) {
    echo json_encode(['status' => 'error', 'message' => 'Missing required parameters']);
    exit();
}

$id = $data['id'];
$editfor = $data['editfor'];
$fid = $data['ref_id'] ?? null;
$user_type_id = '11';


if($editfor == 'pending'){
	$identifier_id= clean_input($data["id"]);
	$identifier_name = 'id=';
	$message="Updated Travel Consultant details from ".$editfor. " list";
	$message2="Updated Travel Consultant details from ".$editfor. " list";
}else if($editfor == 'registered') {
	$identifier_id= clean_input($data["id"]);
	$identifier_name = 'ca_travelagency_id=';
	$message=$identifier_id. " Details has been updated from ".$editfor. " list";
	$message2=$identifier_id. " Details has been updated from ".$editfor. " list";
}

$firstname=clean_input($data['firstname']);
$lastname=clean_input($data['lastname']);
$nominee_name=clean_input($data['nominee_name']);
$nominee_relation=clean_input($data['nominee_relation']);
$email=clean_input($data['email']);
$gender=clean_input($data['gender']);
$country_code=clean_input($data['country_code']);
$phone=clean_input($data['phone']);
// $age=clean_input($data['age'];
$dob=clean_input($data['dob']);
// get age of the user
$birthYear = str_split($dob,4);
$birth_year = $birthYear[0];
$age = $current_year - $birth_year;
// $gst_no=clean_input($data['gst_no'];
// $kyc=clean_input($data['kyc'];
$profile_pic=clean_input($data['profile_pic']);
$pan_card=clean_input($data['pan_card']);
$aadhar_card=clean_input($data['aadhar_card']);
$voting_card=clean_input($data['voting_card']);
$bank_passbook=clean_input($data['passbook']);
$payment_proof=clean_input($data['payment_proof']);
$payment_mode=clean_input($data['paymentMode']);
$cheque_no=clean_input($data['chequeNo']);
$cheque_date=clean_input($data['chequeDate']);
$bank_name=clean_input($data['bankName']);
$transaction_no=clean_input($data['transactionNo']);
$address=clean_input($data['address']);
$pincode=clean_input($data['pincode']);
$country=clean_input($data['country']);
$state=clean_input($data['state']);
$city=clean_input($data['city']);

$user_type_id = '11';

$title="Travel Consultant";

$fromWhom="1";
$register_by="1";
$operation="Edit";

if($firstname !='' ||$lastname !='' ||$phone !='' ||$email !='' ||$gender !='' ||$dob !='' ||$address !='' ||$profile_pic !=''){
	
    $sql1 = "UPDATE ca_travelagency SET firstname=:firstname,lastname=:lastname,nominee_name=:nominee_name,nominee_relation=:nominee_relation,country_code=:country_code,contact_no=:contact_no,email=:email,gender=:gender,date_of_birth=:date_of_birth,age=:age,country=:country,state=:state,city=:city,pincode=:pincode,address=:address,profile_pic=:profile_pic,pan_card=:pan_card,aadhar_card=:aadhar_card,voting_card=:voting_card ,passbook=:passbook, payment_proof=:payment_proof, payment_mode=:payment_mode, cheque_no=:cheque_no, cheque_date=:cheque_date, bank_name=:bank_name, transaction_no=:transaction_no WHERE $identifier_name:identifier_id ";
        $stmt = $conn->prepare($sql1);
        $result=  $stmt->execute(array(
            ':firstname' => $firstname,
            ':lastname' => $lastname,
            ':nominee_name' => $nominee_name,
            ':nominee_relation' => $nominee_relation,
            ':country_code' => $country_code,
            ':contact_no' => $phone,
            ':email' => $email,
            // ':gst_no' => $gst_no,
            ':gender' => $gender,
            ':date_of_birth' => $dob,
            ':country' => $country,
            ':state' => $state,
            ':city' => $city,
            ':pincode' => $pincode,
            ':address' => $address,
            ':profile_pic' => $profile_pic,
            // ':kyc' => $kyc,
            ':age' => $age,
            ':pan_card' => $pan_card,
            ':aadhar_card' => $aadhar_card,
            ':voting_card' => $voting_card,
            ':passbook' => $bank_passbook,
			':payment_proof' => $payment_proof,
			':payment_mode' => $payment_mode, 
			':cheque_no' => $cheque_no, 
			':cheque_date' => $cheque_date , 
			':bank_name' => $bank_name, 
			':transaction_no' => $transaction_no,
            ':identifier_id' => $identifier_id	
        ));

	if ($result) {
		
		$sql = "UPDATE login SET username=:email WHERE user_id=:user_id and user_type_id=:user_type_id";
		$stmt2 = $conn->prepare($sql);
		$result2=  $stmt2->execute(array(
			':email' => $email,
			':user_type_id' => $user_type_id,
			':user_id' => $identifier_id		
		));

		if($result2){

			$sql3= "INSERT INTO logs (user_id,title,message,message2,reference_no,register_by, from_whom, operation) VALUES (:user_id,:title ,:message, :message2, :reference_no,:register_by, :from_whom,:operation)";
			$stmt3 =$conn->prepare($sql3);

			$result3=$stmt3->execute(array(
			':user_id' => $identifier_id,
			':title' => $title,
			':message' => $message,
			':message2' =>$message2,
			':reference_no' => $id,
			':register_by' => $register_by,
			':from_whom' => $fromWhom,
			':operation' => $operation
			));

			echo json_encode(["status" => $result3 ? "success" : "error", "message" => "Travel Consultant edited successfully"]);
		}
		else{
            echo json_encode(["status" => "Login Table Insertion Failed"]);
		}

	}
	else{
		echo json_encode(["status" => "Update Failed"]);
	}

}else{
	echo json_encode(["status" => "error", "message" => "Missing required fields"]);

}




?>