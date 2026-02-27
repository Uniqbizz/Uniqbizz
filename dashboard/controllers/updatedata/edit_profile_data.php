<?php
session_start();
require "../../connect.php";

$user_type = $_POST["user_type"];
$user_id = $_POST["user_id"];

$firstname = $_POST["firstname"];
$lastname = $_POST["lastname"];
$phone = $_POST["phone"];
$email = $_POST["email"];
$gender = $_POST["gender"];
$dob = $_POST["bdate"];
$address = $_POST["address"];

$profile_pic = $_POST["profile_pic"];
$pan_card = $_POST["pan_card"]??'';
$bank_passbook = $_POST["bank_passbook"]??'';
$aadhar_card = $_POST["aadhar_card"]??'';
$voting_card = $_POST["voting_card"]??'';
$id_proof = $_POST["id_proof"]??'';
$nominee_name=$_POST['nominee_name'];
$nominee_relation=$_POST['nominee_relation'];

// $country_code= $_POST["country_code"];
$country = $_POST["country"]??'';
$state = $_POST["state"]??'';
$city = $_POST["city"]??'';
$pincode = $_POST["pincode"]??'';

$title = "Update Profile Details";
$message = "You have updated your profile details";
$operation = "update";


if ($firstname != '' || $lastname != '' || $phone != '' || $email != '' || $gender != '' || $dob != '' || $address != '' || $profile_pic != '' || $country != '' || $state != '' || $city != '' || $pan_card != '' || $bank_passbook != '' || $aadhar_card != '' || $voting_card != '') {


	if ($user_type == '2') {
		updateData('customer', $user_type, $user_id, 'cust_id', $firstname, $lastname, $phone, $email, $gender, $dob, $country, $state, $city, $pincode, $address, $profile_pic, $pan_card, $bank_passbook, $aadhar_card, $voting_card,$id_proof, $title, $message, $operation,$nominee_name,$nominee_relation);
	} else if ($user_type == '3') {
		updateData('travel_agent', $user_type, $user_id, 'travel_agent_id', $firstname, $lastname, $phone, $email, $gender, $dob, $country, $state, $city, $pincode, $address, $profile_pic, $pan_card, $bank_passbook, $aadhar_card, $voting_card,$id_proof, $title, $message, $operation,$nominee_name,$nominee_relation);
	} else if ($user_type == '4') {
		updateData('franchisee', $user_type, $user_id, 'franchisee_id', $firstname, $lastname, $phone, $email, $gender, $dob, $country, $state, $city, $pincode, $address, $profile_pic, $pan_card, $bank_passbook, $aadhar_card, $voting_card,$id_proof, $title, $message, $operation,$nominee_name,$nominee_relation);
	} else if ($user_type == '5') {
		updateData('sales_manager', $user_type, $user_id, 'sales_manager_id', $firstname, $lastname, $phone, $email, $gender, $dob, $country, $state, $city, $pincode, $address, $profile_pic, $pan_card, $bank_passbook, $aadhar_card, $voting_card,$id_proof, $title, $message, $operation,$nominee_name,$nominee_relation);
	} else if ($user_type == '6') {
		updateData('branch_manager', $user_type, $user_id, 'branch_manager_id', $firstname, $lastname, $phone, $email, $gender, $dob, $country, $state, $city, $pincode, $address, $profile_pic, $pan_card, $bank_passbook, $aadhar_card, $voting_card,$id_proof, $title, $message, $operation,$nominee_name,$nominee_relation);
	} else if ($user_type == '7') {
		updateData('regional_manager', $user_type, $user_id, 'regional_manager_id', $firstname, $lastname, $phone, $email, $gender, $dob, $country, $state, $city, $pincode, $address, $profile_pic, $pan_card, $bank_passbook, $aadhar_card, $voting_card,$id_proof, $title, $message, $operation,$nominee_name,$nominee_relation);
	} else if ($user_type == '8') {
		updateData('super_franchisee', $user_type, $user_id, 'super_franchisee_id', $firstname, $lastname, $phone, $email, $gender, $dob, $country, $state, $city, $pincode, $address, $profile_pic, $pan_card, $bank_passbook, $aadhar_card, $voting_card,$id_proof, $title, $message, $operation,$nominee_name,$nominee_relation);
	} else if ($user_type == '9') {
		updateData('employees', $user_type, $user_id, 'employees_id', $firstname, $lastname, $phone, $email, $gender, $dob, $country, $state, $city, $pincode, $address, $profile_pic, $pan_card, $bank_passbook, $aadhar_card, $voting_card,$id_proof, $title, $message, $operation,$nominee_name,$nominee_relation);
	} else if ($user_type == '12') {
		updateData('base_agency', $user_type, $user_id, 'base_agency_id', $firstname, $lastname, $phone, $email, $gender, $dob, $country, $state, $city, $pincode, $address, $profile_pic, $pan_card, $bank_passbook, $aadhar_card, $voting_card,$id_proof, $title, $message, $operation,$nominee_name,$nominee_relation);
	} else if ($user_type == '13') {
		updateData('primary_agency', $user_type, $user_id, 'primary_agency_id', $firstname, $lastname, $phone, $email, $gender, $dob, $country, $state, $city, $pincode, $address, $profile_pic, $pan_card, $bank_passbook, $aadhar_card, $voting_card,$id_proof, $title, $message, $operation,$nominee_name,$nominee_relation);
	} else if ($user_type == '14') {
		updateData('agency', $user_type, $user_id, 'agency_id', $firstname, $lastname, $phone, $email, $gender, $dob, $country, $state, $city, $pincode, $address, $profile_pic, $pan_card, $bank_passbook, $aadhar_card, $voting_card,$id_proof, $title, $message, $operation,$nominee_name,$nominee_relation);
	} else if ($user_type == '15') {
		updateData('business_trainee', $user_type, $user_id, 'business_trainee_id', $firstname, $lastname, $phone, $email, $gender, $dob, $country, $state, $city, $pincode, $address, $profile_pic, $pan_card, $bank_passbook, $aadhar_card, $voting_card,$id_proof, $title, $message, $operation,$nominee_name,$nominee_relation);
	} else if ($user_type == '10') {
		updateData('ca_customer', $user_type, $user_id, 'ca_customer_id', $firstname, $lastname, $phone, $email, $gender, $dob, $country, $state, $city, $pincode, $address, $profile_pic, $pan_card, $bank_passbook, $aadhar_card, $voting_card,$id_proof, $title, $message, $operation,$nominee_name,$nominee_relation);
	} else if ($user_type == '11') {
		updateData('ca_travelagency', $user_type, $user_id, 'ca_travelagency_id', $firstname, $lastname, $phone, $email, $gender, $dob, $country, $state, $city, $pincode, $address, $profile_pic, $pan_card, $bank_passbook, $aadhar_card, $voting_card,$id_proof, $title, $message, $operation,$nominee_name,$nominee_relation);
	} else if ($user_type == '16') {
		updateData('corporate_agency', $user_type, $user_id, 'corporate_agency_id', $firstname, $lastname, $phone, $email, $gender, $dob, $country, $state, $city, $pincode, $address, $profile_pic, $pan_card, $bank_passbook, $aadhar_card, $voting_card,$id_proof, $title, $message, $operation,$nominee_name,$nominee_relation);
	}else if ($user_type == '24') {
		updateData('employees', $user_type, $user_id, 'employee_id', $firstname, $lastname, $phone, $email, $gender, $dob, $country, $state, $city, $pincode, $address, $profile_pic, $pan_card, $bank_passbook, $aadhar_card, $voting_card,$id_proof, $title, $message, $operation,$nominee_name,$nominee_relation);
	} else if ($user_type == '25') {
		updateData('employees', $user_type, $user_id, 'employee_id', $firstname, $lastname, $phone, $email, $gender, $dob, $country, $state, $city, $pincode, $address, $profile_pic, $pan_card, $bank_passbook, $aadhar_card, $voting_card,$id_proof, $title, $message, $operation,$nominee_name,$nominee_relation);
	} else if ($user_type == '26') {
		updateData('business_mentor', $user_type, $user_id, 'business_mentor_id', $firstname, $lastname, $phone, $email, $gender, $dob, $country, $state, $city, $pincode, $address, $profile_pic, $pan_card, $bank_passbook, $aadhar_card, $voting_card,$id_proof, $title, $message, $operation,$nominee_name,$nominee_relation);
	} else {
		echo 0;
	}
} else {
	echo 0;
}



function updateData($tablename, $user_type, $user_id, $user_id_colunmName, $firstname, $lastname, $phone, $email, $gender, $dob, $country, $state, $city, $pincode, $address, $profile_pic, $pan_card, $bank_passbook, $aadhar_card, $voting_card,$id_proof, $title, $message, $operation,$nominee_name,$nominee_relation)
{

	require "../../connect.php";
	
	if ($user_type == '25' || $user_type == '24') { //bcm and bdm
		$sql1 = "UPDATE $tablename SET name=:name,contact=:contact,email=:email,gender=:gender,date_of_birth=:date_of_birth,
		address=:address,profile_pic=:profile_pic,id_proof=:id_proof,bank_details=:bank_details  
		WHERE user_type=:user_type AND $user_id_colunmName=:user_id_colunmName";
		$stmt = $conn->prepare($sql1);
		$result =  $stmt->execute(array(
			':name' => $firstname.' '.$lastname,
			':contact' => $phone,
			':email' => $email,
			':gender' => $gender,
			':date_of_birth' => $dob,
			':address' => $address,
			':profile_pic' => $profile_pic,
			':id_proof' => $id_proof,
			':bank_details' => $bank_passbook,
			':user_type' => $user_type,
			':user_id_colunmName' => $user_id
		));
	} else if ($user_type == '10' || $user_type == '11') {
		$sql1 = "UPDATE $tablename SET firstname=:firstname,lastname=:lastname,contact_no=:contact_no,email=:email,gender=:gender,date_of_birth=:date_of_birth,country=:country,state=:state,city=:city,pincode=:pincode,address=:address,profile_pic=:profile_pic,pan_card=:pan_card,aadhar_card=:aadhar_card,voting_card=:voting_card,passbook=:passbook  WHERE user_type=:user_type AND $user_id_colunmName=:user_id_colunmName";
		$stmt = $conn->prepare($sql1);
		$result =  $stmt->execute(array(
			':firstname' => $firstname,
			':lastname' => $lastname,
			':contact_no' => $phone,
			':email' => $email,
			':gender' => $gender,
			':date_of_birth' => $dob,
			':country' => $country,
			':state' => $state,
			':city' => $city,
			':pincode' => $pincode,
			':address' => $address,
			':profile_pic' => $profile_pic,
			':pan_card' => $pan_card,
			':passbook' => $bank_passbook,
			':aadhar_card' => $aadhar_card,
			':voting_card' => $voting_card,
			':user_type' => $user_type,
			':user_id_colunmName' => $user_id
		));
	} else {
		$sql1 = "UPDATE $tablename SET firstname=:firstname,lastname=:lastname,contact_no=:contact_no,email=:email,gender=:gender,date_of_birth=:date_of_birth,country=:country,state=:state,city=:city,pincode=:pincode,address=:address,profile_pic=:profile_pic,pan_card=:pan_card,aadhar_card=:aadhar_card,voting_card=:voting_card,bank_passbook=:bank_passbook  WHERE user_type=:user_type AND $user_id_colunmName=:user_id_colunmName";
		$stmt = $conn->prepare($sql1);
		$result =  $stmt->execute(array(
			':firstname' => $firstname,
			':lastname' => $lastname,
			':contact_no' => $phone,
			':email' => $email,
			':gender' => $gender,
			':date_of_birth' => $dob,
			':country' => $country,
			':state' => $state,
			':city' => $city,
			':pincode' => $pincode,
			':address' => $address,
			':profile_pic' => $profile_pic,
			':pan_card' => $pan_card,
			':bank_passbook' => $bank_passbook,
			':aadhar_card' => $aadhar_card,
			':voting_card' => $voting_card,
			':user_type' => $user_type,
			':user_id_colunmName' => $user_id
		));
	}


	if ($result) {

		//updating username
		$_SESSION["username2"] = $firstname;
		$_SESSION["lname"] = $lastname;
		// echo $_SESSION["username2"];

		$sql = "UPDATE login SET username=:email WHERE user_id=:user_id and user_type_id=:user_type_id";
		$stmt2 = $conn->prepare($sql);
		$result2 =  $stmt2->execute(array(
			':email' => $email,
			':user_type_id' => $user_type,
			':user_id' => $user_id
		));

		if ($result2) {

			$sql3 = "INSERT INTO logs (title,message,operation, reference_no, register_by, from_whom) VALUES (:title ,:message, :operation, :reference_no, :register_by, :from_whom)";
			$stmt3 = $conn->prepare($sql3);

			$result3 = $stmt3->execute(array(
				':title' => $title,
				':message' => $message,
				':operation' => $operation,
				':reference_no' => $user_id,
				':register_by' => $user_type,
				':from_whom' => $user_type
			));

			if ($result3) {
				echo 1;
			} else {
				echo 0;
			}
			// echo 1;
		} else {
			echo 1;
		}
	} else {
		echo 0;
	}
}
