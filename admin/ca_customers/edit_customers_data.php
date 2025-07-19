<?php
require "../connect.php";
$current_year = date('Y');

$refid = $_POST["ref_id"];
$editfor = $_POST["editfor"];

if ($editfor == 'pending') {
	$identifier_id = $_POST["id"];
	$identifier_name = 'id=';
	$coupon_status = 0;
	$message = "Updated Customer details from " . $editfor . " list";
	$message2 = "Updated Customer details from " . $editfor . " list";
} else if ($editfor == 'registered') {
	$identifier_id = $_POST["id"];
	$identifier_name = 'ca_customer_id=';
	$coupon_status = 1;
	$message = $identifier_id . " Details has been updated from " . $editfor . " list";
	$message2 = $identifier_id . " Details has been updated from " . $editfor . " list";
}

$firstname = $_POST['firstname'];
$lastname = $_POST['lastname'];
// $nominee_name = $_POST['nominee_name'];
// $nominee_relation = $_POST['nominee_relation'];
$email = $_POST['email'];
$gender = $_POST['gender'];
$country_code = $_POST['country_code'];
$phone = $_POST['phone'];
// $age=$_POST['age'];
$dob = $_POST['dob'];
// get age of the user
$birthYear = str_split($dob, 4);
$birth_year = $birthYear[0];
$age = $current_year - $birth_year;
// $gst_no=$_POST['gst_no'];
// $kyc=$_POST['kyc'];
$payment_fee = $_POST['payment_fee'];
$payment_label = $_POST['payment_label'];
$comp_chek = $_POST['isComplementary'];
$profile_pic = $_POST['profile_pic'];
$pan_card = $_POST['pan_card'];
$aadhar_card = $_POST['aadhar_card'];
$voting_card = $_POST['voting_card'];
$bank_passbook = $_POST['passbook'];
$payment_proof = $_POST['payment_proof'] ?? '';
$payment_mode = $_POST['paymentMode'];
$cheque_no = $_POST['chequeNo'] ?? '';
$cheque_date = $_POST['chequeDate'] ?? '';
$bank_name = $_POST['bankName'] ?? '';
$transaction_no = $_POST['transactionNo'] ?? '';
$address = $_POST['address'];
$pincode = $_POST['pincode'];
$country = $_POST['country'];
$state = $_POST['state'];
$city = $_POST['city'];
$note = $_POST['note'];
$ta_reference_no=$refid;
$customer_type=$_POST['payment_label'];
$name=$lastname.' '.$lastname;
$uid=$_POST["id"];
$user_type_id = '11';
$amount=$payment_fee;

$title = "Customer";

$fromWhom = "1";
$register_by = "1";

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

if ($firstname != '' || $lastname != '' || $phone != '' || $email != '' || $gender != '' || $dob != '' || $address != '' || $profile_pic != '') {

	$sql1 = "UPDATE ca_customer SET firstname=:firstname,lastname=:lastname,country_code=:country_code,contact_no=:contact_no,
					email=:email,gender=:gender,date_of_birth=:date_of_birth,age=:age,country=:country,
					state=:state,city=:city,pincode=:pincode,address=:address,note=:note,profile_pic=:profile_pic,
					pan_card=:pan_card,aadhar_card=:aadhar_card,voting_card=:voting_card ,passbook=:passbook, 
					payment_proof=:payment_proof, payment_mode=:payment_mode, cheque_no=:cheque_no, cheque_date=:cheque_date, 
					bank_name=:bank_name, transaction_no=:transaction_no,paid_amount=:paid_amount,
					customer_type=:customer_type,comp_chek=:comp_chek 
					WHERE $identifier_name:identifier_id" ;
	$stmt = $conn->prepare($sql1);
	$result =  $stmt->execute(array(
		':firstname' => $firstname,
		':lastname' => $lastname,
// 		':nominee_name' => $nominee_name,
// 		':nominee_relation' => $nominee_relation,
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
		':note' => $note,
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
		':cheque_date' => $cheque_date,
		':bank_name' => $bank_name,
		':transaction_no' => $transaction_no,
		':paid_amount' => $payment_fee,
    	':customer_type' => $payment_label,
    	':comp_chek' => $comp_chek,
		':identifier_id' => $identifier_id
	));

	if ($result) {
		$sql = "UPDATE login SET username=:email WHERE user_id=:user_id and user_type_id=:user_type_id";
		$stmt2 = $conn->prepare($sql);
		$result22 =  $stmt2->execute(array(
			':email' => $email,
			':user_type_id' => $user_type_id,
			':user_id' => $identifier_id
		));

		if ($result22) {

			$sql3 = "INSERT INTO logs (user_id,title,message,message2,reference_no, register_by, from_whom, operation) 
			VALUES (:user_id,:title ,:message, :message2,:reference_no, :register_by, :from_whom, :operation)";
			$stmt3 = $conn->prepare($sql3);

			$result3 = $stmt3->execute(array(
				':user_id' => $identifier_id,
				':title' => $title,
				':message' => $message,
				':message2' => $message2,
				':reference_no' => $refid,
				':register_by' => $register_by,
				':from_whom' => $fromWhom,
				':operation' => 'Edit'
			));

			if ($result3) {
				echo 1;
			} else {
				echo 0;
			}
			// echo 1;
		} else {
			echo 0;
		}
	} else {
		echo 0;
	}
} else {
	echo 0;
}
?>