<?php
require "../../connect.php";
$current_year = date('Y'); 

$fid= $_POST["ref_id"];
$editfor= $_POST["editfor"];

if($editfor == 'pending'){
	$identifier_id= $_POST["id"];
	$identifier_name = 'id=';
	$message="Updated Training Manager details from ".$editfor. " list";
	$message2="Updated Training Manager details from ".$editfor. " list";
}else if($editfor == 'registered') {
	$identifier_id= $_POST["id"];
	$identifier_name = 'training_manager_id=';
	$message=$identifier_id. " Details has been updated from ".$editfor. " list";
	$message2=$identifier_id. " Details has been updated from ".$editfor. " list";
}

$firstname=$_POST['firstname'];
$lastname=$_POST['lastname'];
$nominee_name=$_POST['nominee_name'];
$nominee_relation=$_POST['nominee_relation'];
$email=$_POST['email'];
$gender=$_POST['gender'];
$country_code=$_POST['country_code'];
$phone=$_POST['phone'];
// $age=$_POST['age'];
$dob=$_POST['dob'];
// get age of the user
$birthYear = str_split($dob,4);
$birth_year = $birthYear[0];
$age = $current_year - $birth_year;
$gst_no=$_POST['gst_no'];
// $totalAmt=$_POST['amount'];

// if($totalAmt == "590000"){
// 	$amount = "500000";
// 	$amtGST = "590000";
// }else{
// 	$amount = "null";
//     $amtGST = "null";
// }
// $kyc=$_POST['kyc'];
$profile_pic=$_POST['profile_pic'];
$pan_card=$_POST['pan_card'];
$aadhar_card=$_POST['aadhar_card'];
$voting_card=$_POST['voting_card'];
$bank_passbook=$_POST['passbook'];
// $payment_proof=$_POST['payment_proof'];
$payment_mode=$_POST['paymentMode'];
$cheque_no=$_POST['chequeNo'];
$cheque_date=$_POST['chequeDate'];
$bank_name=$_POST['bankName'];
$transaction_no=$_POST['transactionNo'];
$address=$_POST['address'];
$pincode=$_POST['pincode'];
$country=$_POST['country'];
$state=$_POST['state'];
$city=$_POST['city'];

$user_type_id = '21';

$title="Training Manager";

$fromWhom="1";
$register_by="1";
 
if($firstname !='' ||$lastname !='' ||$phone !='' ||$email !='' ||$gender !='' ||$dob !='' ||$address !='' ||$profile_pic !=''){
	
    $sql1 = "UPDATE training_manager SET firstname=:firstname,lastname=:lastname,nominee_name=:nominee_name,nominee_relation=:nominee_relation,country_code=:country_code,contact_no=:contact_no,email=:email,gender=:gender,date_of_birth=:date_of_birth,age=:age, gst_no=:gst_no, country=:country,state=:state,city=:city,pincode=:pincode,address=:address,profile_pic=:profile_pic,pan_card=:pan_card,aadhar_card=:aadhar_card,voting_card=:voting_card ,bank_passbook=:passbook, payment_mode=:payment_mode, cheque_no=:cheque_no, cheque_date=:cheque_date, bank_name=:bank_name, transaction_no=:transaction_no WHERE $identifier_name:identifier_id ";
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
			// ':amount' => $amount,
			// ':amtGST' => $amtGST,
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
			// ':payment_proof' => $payment_proof,
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

			$sql3= "INSERT INTO logs (user_id,title,message,message2, register_by, from_whom) VALUES (:user_id,:title ,:message, :message2, :register_by, :from_whom)";
			$stmt3 =$conn->prepare($sql3);

			$result3=$stmt3->execute(array(
			':user_id' => $identifier_id,
			':title' => $title,
			':message' => $message,
			':message2' =>$message2,
			// ':reference_no' => $smid,
			':register_by' => $register_by,
			':from_whom' => $fromWhom
			));

			if($result3){
				echo 1;
			}
			else{
				echo 0	;
			}
			// echo 1;
		}
		else{
		echo 0	;
		}

	}
	else{
		echo 0;
	}

}else{
	echo 0;

}




?>