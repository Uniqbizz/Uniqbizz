<?php
require "../../connect.php";

$current_year = date('Y');

// $id= $_POST["testiod"];
$bmid= $_POST["ref_id"];
$editfor= $_POST["editfor"];
// $franchisee_id=$_POST['franchisee_id'];
if($editfor == 'pending'){
	$identifier_id= $_POST["testiod"];
	$identifier_name = 'id=';
	$message="Updated Sales Manager Details from ".$editfor. " list";
$message2="Updated Sales Manager Details from ".$editfor. " list";
}else if($editfor == 'registered') {
	$identifier_id= $_POST["testiod"];
	$identifier_name = 'sales_manager_id=';
	$message=$identifier_id. " Details has been updated from ".$editfor. " list";
$message2=$identifier_id. " Details has been updated from ".$editfor. " list";
}

$branch_name=$_POST['branch'];
$zone_name=$_POST['zone'];
$region_name=$_POST['region']; 

$firstname=$_POST['firstname'];
$lastname=$_POST['lastname'];
$email=$_POST['email'];
$gender=$_POST['gender'];
$country_code=$_POST['country_code'];
$phone=$_POST['phone'];
// $age=$_POST['age'];
$bdate=$_POST['dob'];
$profile_pic=$_POST['profile_pic'];
// $kyc=$_POST['kyc'];
$pan_card=$_POST['pan_card'];
$aadhar_card=$_POST['aadhar_card'];
$voting_card=$_POST['voting_card'];
$bank_passbook=$_POST['passbook'];
$address=$_POST['address'];
$pincode=$_POST['pincode'];
$country=$_POST['country'];
$state=$_POST['state'];
$city=$_POST['city'];

// get age of the user
$birthYear = str_split($bdate,4);
$birth_year = $birthYear[0];
$age = $current_year - $birth_year;

$user_type_id = '5';

$title="Sales Manager";


$fromWhom="1";
$register_by="6";


if($firstname !='' ||$lastname !='' ||$phone !='' ||$email !='' ||$gender !='' ||$dob !='' ||$address !='' ||$profile_pic !=''||$country !=''||$state !=''||$city !=''||$branch_name !=''||$zone_name !=''||$region_name !=''){
	


$sql1 = "UPDATE sales_manager SET firstname=:firstname,lastname=:lastname,country_code=:country_code,contact_no=:contact_no,email=:email,gender=:gender,date_of_birth=:date_of_birth,age=:age,country=:country,state=:state,city=:city,pincode=:pincode,address=:address,profile_pic=:profile_pic,pan_card=:pan_card,aadhar_card=:aadhar_card,voting_card=:voting_card ,bank_passbook=:bank_passbook,branch=:branch_name,zone=:zone_name,region=:region_name WHERE $identifier_name:identifier_id";
	$stmt = $conn->prepare($sql1);
	$result=  $stmt->execute(array(
		':firstname' => $firstname,
		':lastname' => $lastname,
		':country_code' => $country_code,
		':contact_no' => $phone,
		':email' => $email,
		':gender' => $gender,
		':date_of_birth' => $bdate,
		':age' => $age,
		':country' => $country,
		':state' => $state,
		':city' => $city,
		':pincode' => $pincode,
		':address' => $address,
		':profile_pic' => $profile_pic,
		// ':kyc' => $kyc,
		':pan_card' => $pan_card,
		':aadhar_card' => $aadhar_card,
		':voting_card' => $voting_card,
		':bank_passbook' => $bank_passbook,
		':branch_name' => $branch_name,
		':zone_name' => $zone_name,
		':region_name' => $region_name,
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
			$sql3= "INSERT INTO logs (user_id,title,message,message2, reference_no, register_by, from_whom) VALUES (:user_id,:title ,:message, :message2, :reference_no, :register_by, :from_whom)";
			$stmt3 =$conn->prepare($sql3);

			$result3=$stmt3->execute(array(
			':user_id' => $identifier_id,
			':title' => $title,
			':message' => $message,
			':message2' =>$message2,
			':reference_no' => $bmid,
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