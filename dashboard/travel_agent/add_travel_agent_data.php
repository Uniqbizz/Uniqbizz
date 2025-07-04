<?php
    // session_start();
    require '../connect.php';
    $current_year = date('Y'); 

    $user_id_name=$_POST['user_id_name'];
    $registrant=$_POST['reference_name'];
    $firstname=$_POST['firstname'];
    $lastname=$_POST['lastname'];
    $nominee_name=$_POST['nominee_name'];
    $nominee_relation=$_POST['nominee_relation'];
    $email=$_POST['email'];
    $gender=$_POST['gender'];
    // $complimentary=$_POST['complimentary'];
    // $converted=$_POST['converted'];
    $country_code=$_POST['country_code'];
    $phone_no=$_POST['phone'];
    // $gst_no=$_POST['gst_no'];
    // $business_package=$_POST['business_package'];
    // $amount=$_POST['amount'];
    // $age=$_POST['age'];
    $bdate=$_POST['dob'];
    $profile_pic=$_POST['profile_pic'];
    // $kyc=$_POST['kyc'];
    $pan_card=$_POST['pan_card'];
    $aadhar_card=$_POST['aadhar_card'];
    $voting_card=$_POST['voting_card'];
    $passbook=$_POST['passbook'];
    $payment_proof=$_POST['payment_proof'];
    $payment_fee=$_POST['payment_fee'];
    $paymentMode=$_POST['paymentMode'];
    $chequeNo=$_POST['chequeNo'];
    $chequeDate=$_POST['chequeDate'];
    $bankName=$_POST['bankName'];
    $transactionNo=$_POST['transactionNo'];
    $address=$_POST['address'];
    $pincode=$_POST['pincode'];
    $country=$_POST['country'];
    $state=$_POST['state'];
    $city=$_POST['city'];
    $userId = $_POST['userId']; // BH250001 
	$userType = $_POST['userType']; //25
    $status="2";
    $user_type="11";
    $register_by=$userType;

    // get age of the user
    $birthYear = str_split($bdate,4);
    $birth_year = $birthYear[0];
    $age = $current_year - $birth_year;

    // data insertion for logs tables 
    $title="Travel Consultant";
    $message="Added new Travel Consultant. TC name - " .$firstname." ".$lastname;
    $message2="Added new Travel Consultant. By -".$userId;
    $fromWhom=$userType;
    $operation="Add";

    $sql= "INSERT INTO `ca_travelagency` (firstname, lastname, nominee_name, nominee_relation, email, country_code, contact_no , date_of_birth, age, gender, country, state, city, pincode, address, profile_pic, pan_card, aadhar_card, voting_card, passbook, payment_proof, amount, payment_mode, cheque_no, cheque_date, bank_name, transaction_no, user_type, registrant, reference_no, register_by, status) VALUES (:firstname ,:lastname, :nominee_name, :nominee_relation, :email, :country_code, :contact_no, :bdate, :age, :gender , :country, :state, :city, :pincode,:address,:profile_pic ,:pan_card,:aadhar_card,:voting_card,:passbook,:payment_proof, :amount ,:payment_mode, :cheque_no, :cheque_date, :bank_name, :transaction_no, :user_type,:registrant,  :reference_no, :register_by, :status)";
    $stmt =$conn->prepare($sql);

    $result=$stmt->execute(array(
        ':firstname' => $firstname, 
        ':lastname' => $lastname, 
        ':nominee_name' => $nominee_name,
        ':nominee_relation' => $nominee_relation,
        // ':gst_no' => $gst_no,
        // ':complimentary' => $complimentary,
        // ':converted' => $converted,
        // ':business_package' => $business_package,
        // ':amount' => $amount,
        ':email' => $email,
        ':country_code' => $country_code, 
        ':contact_no' => $phone_no,
        ':country' => $country,
        ':state' => $state,
        ':city' => $city,
        ':pincode' => $pincode,
        ':address' => $address,  
        ':bdate' => $bdate,
        ':age' => $age,  
        ':gender' => $gender,
        ':profile_pic' => $profile_pic,
        // ':kyc' => $kyc,
        ':pan_card' => $pan_card,
        ':aadhar_card' => $aadhar_card,
        ':voting_card' => $voting_card,
        ':passbook' => $passbook,  
        ':payment_proof' => $payment_proof,
        ':amount' => $payment_fee,
        ':payment_mode' => $paymentMode, 
        ':cheque_no' => $chequeNo, 
        ':cheque_date' => $chequeDate, 
        ':bank_name' => $bankName, 
        ':transaction_no' => $transactionNo,
        ':user_type' => $user_type,
        ':registrant' =>$registrant,
        ':reference_no' => $user_id_name,
        ':register_by' => $register_by,
        ':status' => $status
    ));


    if($result){

        $sql2 = $conn->prepare(" SELECT id FROM `ca_travelagency` ORDER BY id DESC LIMIT 1  ");
        $sql2 -> execute();
        $id = $sql2 -> fetch();
        $id = $id['id'];

        $sql3= "INSERT INTO logs (user_id,title,message,message2,reference_no, register_by, from_whom,operation) VALUES (:user_id,:title ,:message, :message2, :reference_no, :register_by, :from_whom,:operation)";
        $stmt =$conn->prepare($sql3);

        $result3=$stmt->execute(array(
            ':user_id' => $id,       
            ':title' => $title,
            ':message' => $message,
            ':message2' =>$message2,
            ':reference_no' => $user_id_name,
            ':register_by' => $register_by,
            ':from_whom' => $fromWhom,
            ':operation' => $operation
        ));

        if($result){
            echo 1;
        }else{
            echo 0	;
        }
        
    }else{
        echo 0	;
    }

?>