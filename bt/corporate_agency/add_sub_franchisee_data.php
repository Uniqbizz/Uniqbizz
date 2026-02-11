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
    $gst_no=$_POST['gst_no'];
    $country_code=$_POST['country_code'];
    $phone_no=$_POST['phone'];
    $amount=$_POST['amount'];
    $bdate=$_POST['dob'];
    $profile_pic=$_POST['profile_pic'];
    $pan_card=$_POST['pan_card'];
    $aadhar_card=$_POST['aadhar_card'];
    $voting_card=$_POST['voting_card'];
    $passbook=$_POST['passbook'];
    $payment_proof=$_POST['payment_proof'];
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
    $note=$_POST['note'];

    $user_type="29";
    // $reference_id = substr($user_id_name, 0 , 2);
    // $user_type=$reference_id == 'BH'? 25 : 16;

    $register_by="1";
	$status="2";

    // get age of the user
    $birthYear = str_split($bdate,4);
    $birth_year = $birthYear[0];
    $age = $current_year - $birth_year;

    // data insertion for logs tables 
    $title="Franchisee";
    $message="Added new Franchisee by admin";
    $message2="Added new Franchisee by admin";
    $fromWhom="1";
    $operation="Add";

    //commission and incentive 
    $comm_per=0;
    $ins_per=0;
    //amount = 2,00,000
    if ($amount == '200000') {
        $comm_per=10;
        $ins_per=10;
    } 
    //amount = 3,00,000
    else if($amount == '300000') {
        $comm_per=15;
        $ins_per=15;
    }
    //amount = 4,00,000
    else if($amount == '400000') {
        $comm_per=20;
        $ins_per=20;
    }
    //amount = 5,00,000
    else if($amount == '500000') {
        $comm_per=30;
        $ins_per=30;
    }
    
    $sql= "INSERT INTO `sub_franchisee` (firstname, lastname, nominee_name, nominee_relation, email, country_code, contact_no , date_of_birth, age, gender, country, state, city, pincode, address, note, profile_pic, gst_no, amount,current_commission_per,current_incentive_per,  pan_card, aadhar_card, voting_card, bank_passbook, payment_proof, user_type, registrant, payment_mode, cheque_no, cheque_date, bank_name, transaction_no, reference_no, register_by, status) 
           VALUES (:firstname ,:lastname, :nominee_name, :nominee_relation, :email, :country_code, :contact_no, :bdate, :age, :gender , :country, :state, :city, :pincode,:address,:note,:profile_pic, :gst_no, :amount,:current_commission_per,:current_incentive_per, :pan_card,:aadhar_card,:voting_card,:bank_passbook, :payment_proof, :user_type,:registrant, :payment_mode, :cheque_no, :cheque_date, :bank_name, :transaction_no, :reference_no, :register_by, :status)";
    $stmt3 =$conn->prepare($sql);

    $result2=$stmt3->execute(array(
        ':firstname' => $firstname, 
        ':lastname' => $lastname, 
        ':nominee_name' => $nominee_name,
        ':nominee_relation' => $nominee_relation,
        ':gst_no' => $gst_no,
        ':amount' => $amount,
        ':current_commission_per' => $comm_per,
        ':current_incentive_per' => $ins_per,
        ':email' => $email,
        ':country_code' => $country_code, 
        ':contact_no' => $phone_no,
        ':country' => $country,
        ':state' => $state,
        ':city' => $city,
        ':pincode' => $pincode,
        ':address' => $address,  
        ':note' => $note, 
        ':bdate' => $bdate,
        ':age' => $age,  
        ':gender' => $gender,
        ':profile_pic' => $profile_pic,
        ':pan_card' => $pan_card,
        ':aadhar_card' => $aadhar_card,
        ':voting_card' => $voting_card,
        ':bank_passbook' => $passbook,  
        ':payment_proof' => $payment_proof,  
        ':user_type' => $user_type,
        ':registrant' =>$registrant,
        ':payment_mode' => $paymentMode, 
        ':cheque_no' => $chequeNo, 
        ':cheque_date' => $chequeDate, 
        ':bank_name' => $bankName, 
        ':transaction_no' => $transactionNo,
        ':reference_no' => $user_id_name,
        ':register_by' => $register_by,
		':status' => $status
    ));

    if($result2){

        $sql2= "INSERT INTO logs (title,message,message2,reference_no, register_by, from_whom,operation) VALUES (:title ,:message, :message2, :reference_no, :register_by, :from_whom,:operation)";
        $stmt =$conn->prepare($sql2);

        $result=$stmt->execute(array(
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