<?php
    // session_start();
    include_once(__DIR__.'/../../../dashboard_user_details.php');
    $current_year = date('Y'); 
    $actionType           = $_POST['action_type'] ?? '';
    $user_id_name=$userId;
    $registrant=$userFname .' '.$userLname;
    $fname=$_POST['firstname'];
    $lname=$_POST['lastname'];
    $nominee_name=$_POST['nominee_name'];
    $nominee_relation=$_POST['nominee_relation'];
    $email=$_POST['email'];
    $gender=$_POST['gender'];
    $country_code=$_POST['country_code'];
    $phone_no=$_POST['phone'];
    $gst_no=$_POST['gst_no'];
    $amount=$_POST['business_package'];
    $bdate=date('Y-m-d', strtotime($_POST['dob']));
    $profile_pic=$_POST['profile_pic'];
    $pan_card=$_POST['pan_card'];
    $aadhar_card=$_POST['aadhar_card'];
    $voting_card=$_POST['voting_card'];
    $passbook=$_POST['passbook'];
    $payment_proof=$_POST['payment_proof'];
    $address=$_POST['address'];
    $pincode=$_POST['pincode'];
    $country=$_POST['country'];
    $state=$_POST['state'];
    $city=$_POST['city'];
    $paymentMode=$_POST['paymentMode'];
    $chequeNo=$_POST['chequeNo'];
    $chequeDate=$_POST['chequeDate'];
    $bankName=$_POST['bankName'];
    $transactionNo=$_POST['transactionNo'];
    $message2='';
    $user_type="16"; 
    $register_by=$userType;

    if($actionType == 'draft'){
        // data insertion for logs tables
        $status= '4';
        $message="Techno Enterprise form saved as draft by $userId($userFname' '$userLname) from Add Page";
    }else{
        // data insertion for logs tables
        $status= '2';
        $message="Added new Techno Enterprise. TE name - " .$fname." ".$lname;
        $message2="Added new Techno Enterprise by Super Techno Eenterprise";
    }

    // get age of the user
    $birthYear = str_split($bdate,4);
    $birth_year = $birthYear[0];
    $age = $current_year - $birth_year;

    // data insertion for logs tables 
    $title="Techno Enterprise";
    
    $fromWhom=$userType;
    $operation="Add";

    $sql= "INSERT INTO `corporate_agency` (firstname, lastname, nominee_name, nominee_relation, email, country_code, 
            contact_no , date_of_birth, age, gender, gst_no, amount, profile_pic, pan_card, aadhar_card, voting_card, 
            bank_passbook, payment_proof,country, state, city, pincode, address, payment_mode, cheque_no, cheque_date, 
            bank_name, transaction_no, user_type, registrant, reference_no, register_by, status) 
            VALUES (:firstname ,:lastname, :nominee_name, :nominee_relation, :email, :country_code, :contact_no, :bdate, 
            :age, :gender , :gst_no, :amount, :profile_pic, :pan_card, :aadhar_card, :voting_card, :bank_passbook, 
            :payment_proof, :country, :state, :city, :pincode,:address, :payment_mode, :cheque_no, :cheque_date, :bank_name, 
            :transaction_no, :user_type,:registrant,  :reference_no, :register_by, :status)";
    $stmt3 =$conn->prepare($sql);

    $result2=$stmt3->execute(array(
        ':firstname' => $fname, 
        ':lastname' => $lname, 
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
        ':payment_mode' => $paymentMode, 
        ':cheque_no' => $chequeNo, 
        ':cheque_date' => $chequeDate, 
        ':bank_name' => $bankName, 
        ':transaction_no' => $transactionNo,
        ':bdate' => $bdate,
        ':age' => $age,  
        ':gender' => $gender,
        ':gst_no' => $gst_no,
        ':amount' => $amount,
        ':profile_pic' => $profile_pic,
        ':pan_card' => $pan_card,
        ':aadhar_card' => $aadhar_card,
        ':voting_card' => $voting_card,
        ':bank_passbook' => $passbook,  
        ':payment_proof' => $payment_proof,  
        ':user_type' => $user_type,
        ':registrant' =>$registrant,
        ':reference_no' => $user_id_name,
        ':register_by' => $register_by,
        ':status' => $status
    ));

    if($result2){

        $sql2= "INSERT INTO logs (title,message,message2,reference_no, register_by, from_whom, operation) VALUES (:title ,:message, :message2, :reference_no, :register_by, :from_whom, :operation)";
        $stmt =$conn->prepare($sql2);

        $result=$stmt->execute(array(
        ':title' => $title,
        ':message' => $message,
        ':message2' =>$message2,
        ':reference_no' => $userId,
        ':register_by' => $register_by,
        ':from_whom' => $fromWhom,
        'operation' => $operation
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