<?php
require "../connect.php";
$current_year = date('Y');

$refid = $_POST["ref_id"];
$editfor = $_POST["editfor"];
$tc_count = $_POST['tcCount'];

if ($editfor == 'pending') {
	$identifier_id = $_POST["id"];
	$identifier_name = 'id=';
	$message = "Updated Techno Enterprise details from " . $editfor . " list";
	$message2 = "Updated Techno Enterprise details from " . $editfor . " list";
} else if ($editfor == 'registered') {
	$identifier_id = $_POST["id"];
	$identifier_name = 'corporate_agency_id=';
	$message = $identifier_id . " Details has been updated from " . $editfor . " list";
	$message2 = $identifier_id . " Details has been updated from " . $editfor . " list";
	$tc_message = $identifier_id . ": ".$tc_count." TC has been Allotted from " . $editfor . " list";
	$tc_message2 = $identifier_id . ": ".$tc_count." TC has been Alloted from " . $editfor . " list";
}

$firstname = $_POST['firstname'];
$lastname = $_POST['lastname'];
$nominee_name = $_POST['nominee_name'];
$nominee_relation = $_POST['nominee_relation'];
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
$gst_no = $_POST['gst_no'];
$amount = $_POST['amount'];

// if($totalAmt == "590000"){
// 	$amount = "500000";
// 	$amtGST = "590000";
// }else{
// 	$amount = "null";
//     $amtGST = "null";
// }
// $kyc=$_POST['kyc'];
$profile_pic = $_POST['profile_pic'];
$pan_card = $_POST['pan_card'];
$aadhar_card = $_POST['aadhar_card'];
$voting_card = $_POST['voting_card'];
$bank_passbook = $_POST['passbook'];
$payment_proof = $_POST['payment_proof'];
$payment_mode = $_POST['paymentMode'];
$cheque_no = $_POST['chequeNo'];
$cheque_date = $_POST['chequeDate'];
$bank_name = $_POST['bankName'];
$transaction_no = $_POST['transactionNo'];
$address = $_POST['address'];
$pincode = $_POST['pincode'];
$country = $_POST['country'];
$state = $_POST['state'];
$city = $_POST['city'];
$note=$_POST['note'];
$tc_ids = [];

if (isset($_POST['selectedIds'])) {
    if (is_array($_POST['selectedIds'])) {
        // Already an array, use as-is
        $tc_ids = $_POST['selectedIds'];
    } else {
        // It's a string, possibly comma-separated
        $tc_ids = explode(',', $_POST['selectedIds']);
    }
}
if($tc_ids){
	$tc_assign_status=1;
}else{
	$tc_assign_status=0;
}
$tenure=$_POST['tenure'];
$roi=$_POST['roi'];
$tax=$_POST['tax'];
$repayAmount=$_POST['repayAmount'];
$user_type_id = '16';

$title = "Techno Enterprise";

$fromWhom = "1";
$register_by = "1";
$operation = "Update";

if ($firstname != '' || $lastname != '' || $phone != '' || $email != '' || $gender != '' || $dob != '' || $address != '' || $profile_pic != '') {

	$sql1 = "UPDATE corporate_agency SET firstname=:firstname,lastname=:lastname,
	nominee_name=:nominee_name,nominee_relation=:nominee_relation,country_code=:country_code,
	contact_no=:contact_no,email=:email,gender=:gender,date_of_birth=:date_of_birth,age=:age, 
	gst_no=:gst_no, amount=:amount, country=:country,state=:state,city=:city,pincode=:pincode,
	address=:address,note=:note,profile_pic=:profile_pic,pan_card=:pan_card,aadhar_card=:aadhar_card,voting_card=:voting_card ,
	bank_passbook=:passbook, payment_proof=:payment_proof, payment_mode=:payment_mode, cheque_no=:cheque_no, 
	cheque_date=:cheque_date, bank_name=:bank_name, transaction_no=:transaction_no,
	no_tc_alloted=:no_tc_alloted,repay_tenure=:repay_tenure,roi=:roi,tax=:tax,
	repay_amount=:repay_amount,tc_assign_status=:tc_assign_status
	WHERE $identifier_name:identifier_id ";
	$stmt = $conn->prepare($sql1);
	$result =  $stmt->execute(array(
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
		':no_tc_alloted' => $tc_count,
		':repay_tenure' =>$tenure,
		':roi' =>$roi,
		':tax' =>$tax,
		':repay_amount' =>$repayAmount,
		':tc_assign_status'=>$tc_assign_status,
		':identifier_id' => $identifier_id
	));

	if ($result) {

		$sql = "UPDATE login SET username=:email WHERE user_id=:user_id and user_type_id=:user_type_id";
		$stmt2 = $conn->prepare($sql);
		$result2 =  $stmt2->execute(array(
			':email' => $email,
			':user_type_id' => $user_type_id,
			':user_id' => $identifier_id
		));

		//add selected number of TC's for the TE
		//find the bm/bdm who registred the TE and get the TC'c who dont have TE alloted to them
		//based on the number of TC's sletect update the TC'c ref id with this TE's id

		//getting the ref_no of the TE (registered only)
		$sql1 = "SELECT reference_no,user_type,corporate_agency_id FROM corporate_agency WHERE $identifier_name:identifier_id AND status=1";
		$stmt3 = $conn->prepare($sql1);
		$stmt3->execute(array(
			':identifier_id' => $identifier_id
		));
		// Fetch single row
		$row = $stmt3->fetch(PDO::FETCH_ASSOC);
		$reference_no = $row['reference_no'];
		$ref_user_type = $row['user_type'];
		$corporate_agency_id = $row['corporate_agency_id'];


		if (!empty($tc_ids)) {
			foreach ($tc_ids as $tc_id) {
				$sql = "UPDATE ca_travelagency 
						SET registrant = :registrant, reference_no = :new_reference_no 
						WHERE ca_travelagency_id = :tc_id AND status=1";

				$stmt = $conn->prepare($sql);
				$stmt->execute([
					':registrant' => $firstname . ' ' . $lastname,
					':new_reference_no' => $corporate_agency_id,
					':tc_id' => $tc_id
				]);
			}
		}
		//|| strpos($reference_no, 'BM') !== false


		if ($result2) {

			$sql3 = "INSERT INTO logs (user_id,title,message,message2,reference_no, register_by, from_whom,operation) VALUES (:user_id,:title ,:message, :message2,:reference_no, :register_by, :from_whom,:operation)";
			$stmt3 = $conn->prepare($sql3);

			$result3 = $stmt3->execute(array(
				':user_id' => $identifier_id,
				':title' => $title,
				':message' => $message,
				':message2' => $message2,
				':reference_no' => $refid,
				':register_by' => $register_by,
				':from_whom' => $fromWhom,
				':operation' => $operation
			));
			//log only if TC are alloted
			if ($tc_count) {
				$sql3_1 = "INSERT INTO logs (user_id,title,message,message2,reference_no, register_by, from_whom,operation) VALUES (:user_id,:title ,:message, :message2,:reference_no, :register_by, :from_whom,:operation)";
				$stmt3_1 = $conn->prepare($sql3_1);
	
				$result3_1 = $stmt3->execute(array(
					':user_id' => $identifier_id,
					':title' => 'TC Allotment',
					':message' => $tc_message,
					':message2' => $tc_message2,
					':reference_no' => $refid,
					':register_by' => $register_by,
					':from_whom' => $fromWhom,
					':operation' => 'TC Allotment'
				));
			}

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
