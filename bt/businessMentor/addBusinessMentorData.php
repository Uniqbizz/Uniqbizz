<?php
    // session_start();
    require '../connect.php';
    $current_year = date('Y'); 

    // Email files
    include('../../e-mail/phpmailer_smtp/smtp/PHPMailerAutoload.php');

    $user_id_name=$_POST['user_id_name'];
    $registrant=$_POST['reference_name'];
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
    $payment_fee=$_POST['payment_fee'];
    $payment_proof=$_POST['payment_proof'];
    $payment_mode=$_POST['paymentMode'];
    $cheque_no=$_POST['chequeNo'];
    $cheque_date=$_POST['chequeDate'];
    $bank_name=$_POST['bankName'];
    $transaction_no=$_POST['transactionNo'];
	$note = $_POST['note'];

    $user_type="26";
    $register_by="15";
	$status= '2';

    // get age of the user
    $birthYear = str_split($bdate,4);
    $birth_year = $birthYear[0];
    $age = $current_year - $birth_year;

    // data insertion for logs tables 
    $title="Business Mentor";
    $message="Added new Business Mentor by admin";
    $message2="Added new Business Mentor by admin";
    $fromWhom="15";
	$operation="Add";

    $sql= "INSERT INTO `business_mentor` ( 
		firstname, 
		lastname, 
		nominee_name, 
		nominee_relation,
		paid_amount, 
		email, 
		country_code, 
		contact_no , 
		date_of_birth, 
		age, 
		gender, 
		country, 
		state, 
		city, 
		pincode, 
		address, 
		zone, 
		branch, 
		note,
		profile_pic,
		payment_mode,
		cheque_no, 
		cheque_date,
		bank_name,
		transaction_no,
		payment_proof,
		pan_card, 
		aadhar_card, 
		voting_card, 
		bank_passbook, 
		user_type, 
		registrant, 
		reference_no, 
		register_by, 
		status)
	VALUES ( 
		:firstname ,
		:lastname, 
		:nominee_name, 
		:nominee_relation,
		:paid_amount, 
		:email, 
		:country_code, 
		:contact_no, 
		:bdate, 
		:age, 
		:gender , 
		:country, 
		:state, 
		:city, 
		:pincode,
		:address, 
		:zone, 
		:branch, 
		:note,
		:profile_pic,
		:payment_mode,
		:cheque_no, 
		:cheque_date,
		:bank_name,
		:transaction_no,
		:payment_proof, 
		:pan_card,
		:aadhar_card,
		:voting_card,
		:bank_passbook, 
		:user_type,
		:registrant,  
		:reference_no, 
		:register_by, 
		:status)";
    $stmt3 =$conn->prepare($sql);

    $result=$stmt3->execute(array(
        ':firstname' => $firstname, 
        ':lastname' => $lastname, 
        ':nominee_name' => $nominee_name,
        ':nominee_relation' => $nominee_relation,
        ':paid_amount' => $payment_fee,
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
		':note' => $note,
        ':profile_pic' => $profile_pic,
		':payment_mode'=>$payment_mode,
		':cheque_no'=>$cheque_no, 
		':cheque_date'=>$cheque_date,
		':bank_name'=>$bank_name,
		':transaction_no'=>$transaction_no,
		':payment_proof'=>$payment_proof, 
        ':pan_card' => $pan_card,
        ':aadhar_card' => $aadhar_card,
        ':voting_card' => $voting_card,
        ':bank_passbook' => $passbook,  
        ':user_type' => $user_type,
        ':registrant' =>$registrant,
        ':reference_no' => $user_id_name,
        ':register_by' => $register_by,
        ':status' => $status
    ));

    if ($result) {

		$result2 = "1";

        if($result2){

            $sql3= "INSERT INTO logs ( title,message,message2,reference_no, register_by, from_whom,operation) VALUES (:title ,:message, :message2, :reference_no, :register_by, :from_whom, :operation)";
            $stmt =$conn->prepare($sql3);

            $result3=$stmt->execute(array(
                ':title' => $title,
                ':message' => $message,
                ':message2' =>$message2,
                ':reference_no' => $user_id_name,
                ':register_by' => $register_by,
                ':from_whom' => $fromWhom,
				':operation' => $operation
            ));

            if($result3){
				echo 1;
			}else{  //email
				echo 0	;
			}

        }else{
            echo 0	;
        }
        
    }else{
        echo 0	;
    }

?>