<?php
header('Content-Type: application/json');
require '../connect.php';
$current_year = date('Y'); 

$data = json_decode(file_get_contents('php://input'), true);

if (!$data) {
    echo json_encode(['status' => 0, 'message' => 'Invalid JSON data']);
    exit;
}

$fid = $data['ref_id'] ?? null;
$editfor = $data['editfor'] ?? null;

if ($editfor == 'pending') {
    $identifier_id = $data['id'] ?? null;
    $identifier_name = 'id=';
    $message = "Updated Corporate Agency details from $editfor list";
    $message2 = $message;
} elseif ($editfor == 'registered') {
    $identifier_id = $data['id'] ?? null;
    $identifier_name = 'corporate_agency_id=';
    $message = "$identifier_id Details has been updated from $editfor list";
    $message2 = $message;
} else {
    echo json_encode(['status' => 0, 'message' => 'Invalid editfor value']);
    exit;
}

// Extract Data
$firstname = $data['firstname'] ?? null;
$lastname = $data['lastname'] ?? null;
$nominee_name = $data['nominee_name'] ?? null;
$nominee_relation = $data['nominee_relation'] ?? null;
$email = $data['email'] ?? null;
$gender = $data['gender'] ?? null;
$country_code = $data['country_code'] ?? null;
$phone = $data['phone'] ?? null;
$dob = $data['dob'] ?? null;

$birthYear = str_split($dob, 4);
$birth_year = $birthYear[0];
$age = $current_year - $birth_year;

$gst_no = $data['gst_no'] ?? null;
$amount = $data['amount'] ?? null;
$profile_pic = $data['profile_pic'] ?? null;
$pan_card = $data['pan_card'] ?? null;
$aadhar_card = $data['aadhar_card'] ?? null;
$voting_card = $data['voting_card'] ?? null;
$bank_passbook = $data['passbook'] ?? null;
$payment_proof = $data['payment_proof'] ?? null;
$payment_mode = $data['paymentMode'] ?? null;
$cheque_no = $data['chequeNo'] ?? null;
$cheque_date = $data['chequeDate'] ?? null;
$bank_name = $data['bankName'] ?? null;
$transaction_no = $data['transactionNo'] ?? null;
$address = $data['address'] ?? null;
$pincode = $data['pincode'] ?? null;
$country = $data['country'] ?? null;
$state = $data['state'] ?? null;
$city = $data['city'] ?? null;

$user_type_id = '16';
$title="Techno Enterprise";

$fromWhom="1";
$register_by="1";
$operation = "Update";

if($firstname !='' ||$lastname !='' ||$phone !='' ||$email !='' ||$gender !='' ||$dob !='' ||$address !='' ||$profile_pic !=''){
	
    $sql1 = "UPDATE corporate_agency SET firstname=:firstname,lastname=:lastname,nominee_name=:nominee_name,nominee_relation=:nominee_relation,country_code=:country_code,contact_no=:contact_no,email=:email,gender=:gender,date_of_birth=:date_of_birth,age=:age, gst_no=:gst_no, amount=:amount, country=:country,state=:state,city=:city,pincode=:pincode,address=:address,profile_pic=:profile_pic,pan_card=:pan_card,aadhar_card=:aadhar_card,voting_card=:voting_card ,bank_passbook=:passbook, payment_proof=:payment_proof, payment_mode=:payment_mode, cheque_no=:cheque_no, cheque_date=:cheque_date, bank_name=:bank_name, transaction_no=:transaction_no WHERE $identifier_name:identifier_id ";
        $stmt = $conn->prepare($sql1);
        $result=  $stmt->execute(array(
            ':firstname' => $firstname,
            ':lastname' => $lastname,
            ':nominee_name' => $nominee_name,
            ':nominee_relation' => $nominee_relation,
            ':country_code' => $country_code,
            ':contact_no' => $phone,
            ':email' => $email,
            ':gst_no' => $gst_no,
			':amount' => $amount,
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

			$sql3= "INSERT INTO logs (user_id,title,message,message2,reference_no, register_by, from_whom,operation) VALUES (:user_id,:title ,:message, :message2,:reference_no, :register_by, :from_whom,:operation)";
			$stmt3 =$conn->prepare($sql3);

			$result3=$stmt3->execute(array(
			':user_id' => $identifier_id,
			':title' => $title,
			':message' => $message,
			':message2' =>$message2,
			':reference_no' => $fid,
			':register_by' => $register_by,
			':from_whom' => $fromWhom,
			':operation' => $operation
			));

			echo json_encode(['status' => 1, 'message' => 'Update successful']);
		}
		else{
            echo json_encode(['status' => 0, 'message' => 'Error: ' . $e->getMessage()]);
		}

	}
	else{
		echo json_encode(['status' => 0, 'message' => 'Error: ' . $e->getMessage()]);
	}

}else{
	echo json_encode(['status' => 0, 'message' => 'Missing required fields']);

}

?>