<?php
    include_once(__DIR__.'/../../../dashboard_user_details.php');
    $current_year = date('Y'); 
    $reference_no         = $userId;
    $registrant           = $userFname .' '.$userLname;
    $firstname=$_POST['firstname'];
    $lastname=$_POST['lastname'];
    $nominee_name=$_POST['nominee_name'];
    $nominee_relation=$_POST['nominee_relation'];
    $email=$_POST['email'];
    $gender=$_POST['gender'];
    $country_code=$_POST['country_code'];
    $phone_no=$_POST['phone'];
    $bdate=$_POST['dob'];
    $profile_pic=$_POST['profile_pic'];
    $pan_card=$_POST['pan_card'];
    $aadhar_card=$_POST['aadhar_card'];
    $voting_card=$_POST['voting_card'];
    $passbook=$_POST['passbook'];
    $address=$_POST['address'];
    $pincode=$_POST['pincode'];
    $country=$_POST['country'];
    $state=$_POST['state'];
    $city=$_POST['city'];
    $zone=$_POST['zone'];
    $branch=$_POST['branch'];

	$userId = $_POST['userId']; // BH250001 
	$userType = $_POST['userType']; //25

    $user_type=26;
    $register_by = $userType;
	$status= '2';

    // get age of the user
    $birthYear = str_split($bdate,4);
    $birth_year = $birthYear[0];
    $age = $current_year - $birth_year;

    // data insertion for logs tables 
		$title="Business Mentor";
		$message="Added new Business Mentor by User. BM name - " .$firstname." ".$lastname;
		$message2="Added new Business Mentor by User";
		$operation = "Add";
		$fromWhom = $userType;

	$sql= "INSERT INTO `business_mentor` ( 
				firstname,lastname,nominee_name,nominee_relation,email,country_code,contact_no ,date_of_birth,age,gender, 
				country,state,city,pincode,address,zone,branch,profile_pic,
				pan_card,aadhar_card,voting_card,bank_passbook,user_type,registrant,reference_no,register_by,status) 
			VALUES ( 
				:firstname ,:lastname,:nominee_name,:nominee_relation,:email,:country_code,:contact_no,:bdate,:age,:gender , 
				:country,:state,:city,:pincode,:address,:zone,:branch,:profile_pic,
				:pan_card,:aadhar_card,:voting_card,:bank_passbook,:user_type,:registrant,:reference_no,:register_by,:status)";
			$stmt3 =$conn->prepare($sql);

			$result=$stmt3->execute(array(
				':firstname' => $firstname, 
				':lastname' => $lastname, 
				':nominee_name' => $nominee_name,
				':nominee_relation' => $nominee_relation,
				':email' => $email,
				':country_code' => $country_code, 
				':contact_no' => $phone_no,
				':country' => $country,
				':state' => $state,
				':city' => $city,
				':pincode' => $pincode,
				':address' => $address,  
				':zone' => $zone,
				':branch' => $branch,
				':bdate' => $bdate,
				':age' => $age,  
				':gender' => $gender,
				':profile_pic' => $profile_pic, 
				':pan_card' => $pan_card,
				':aadhar_card' => $aadhar_card,
				':voting_card' => $voting_card,
				':bank_passbook' => $passbook,  
				':user_type' => $user_type,
				':registrant' =>$registrant,
				':reference_no' => $reference_no,
				':register_by' => $register_by,
				':status' => $status
			));

    if ($result) {
		$sql3= "INSERT INTO logs ( title,message,message2,reference_no, register_by, from_whom, operation) VALUES (:title ,:message, :message2, :reference_no, :register_by, :from_whom , :operation)";
		$stmt =$conn->prepare($sql3);

		$result3=$stmt->execute(array(
			':title' => $title,
			':message' => $message,
			':message2' =>$message2,
			':reference_no' => $reference_no,
			':register_by' => $register_by,
			':from_whom' => $fromWhom,
			':operation' => $operation
		));

		if($result3){		
			echo 1;
		}else{  
			echo 0	;
		}
	}else{
		echo 0	;
	}
?>