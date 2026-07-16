<?php
    
    require '../connect.php';
    $current_year = date('Y'); 

    $action_type = $_POST['action_type'];
    $designation = $_POST['designation'];
    $reference_id = $_POST['user_id_name'];
    $reference_name = $_POST['reference_name'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $number_branch = $_POST['number_branch'];
    // $type_of_institution = $_POST['type_of_institution'];
    $institution_type_value = $_POST['institution_type_value'];
    $incorporation_date = $_POST['incorporation_date'];
    $country_code = $_POST['country_code'];
    $phone = $_POST['phone'];
    $institution_pan = $_POST['institution_pan'];

    $country = $_POST['country'];
    $state = $_POST['state'];
    $city = $_POST['city'];
    $pincode = $_POST['pincode'];
    $address = $_POST['address'];

    $account_name = $_POST['account_name'];
    $account_number = $_POST['account_number'];
    $ifsc_code = $_POST['ifsc_code'];
    $branch_name = $_POST['branch_name'];

    // $activation_plan = $_POST['activation_plan'];
    $amount = $_POST['amount'];
    $payment_proof = $_POST['payment_proof'];
    $paymentMode = $_POST['paymentMode'];

    $chequeNo = $_POST['chequeNo'];
    $chequeDate = $_POST['chequeDate'];
    $bankName = $_POST['bankName'];
    $transactionNo = $_POST['transactionNo'];

    $certificate_of_incorporation = $_POST['certificate_of_incorporation'];
    $gstin = $_POST['gstin'];
    $board_resolution = $_POST['board_resolution'];
    $cancelled_cheque_bank_passbook = $_POST['cancelled_cheque_bank_passbook'];
    $pancard = $_POST['pancard'];
    $address_proof = $_POST['address_proof'];
    $payment_proof = $_POST['payment_proof'];

    $user_type="32";
    // $reference_id = substr($user_id_name, 0 , 2);
    // $user_type=$reference_id == 'BH'? 25 : 16;

    $register_by="1";
	$status="2";

    // data insertion for logs tables 
    $title="Institution";
    $message="Added new Institution by admin";
    $message2="Added new Institution by admin";
    $fromWhom="1";
    $operation="Add";

    //commission and incentive 
    //amount = 0/FOC
    if ($amount == 'FOC') {
        $comm_per=0;
        $ins_per=0;
    }
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
    else if($amount >= '500000') {
        $comm_per=30;
        $ins_per=20;
    }
    
    $sql= "INSERT INTO `institution` (`name`, `no_of_branches`, `types_of_institution`, `incorporation_date`, `institution_pan`, 
                                      `email`, `country_code`, `contact_no`, `country`, `state`, `city`, `pincode`, `address`, 
                                      `account_name`, `account_number`, `ifsc_code`, `bank_and_branch_name`,  
                                      `amount`, `current_commission_per`, `current_incentive_per`, `payment_mode`, 
                                      `cheque_no`, `cheque_date`, `bank_name`, `transaction_no`, `certificate_of_incorporation`, 
                                      `gstin`, `pan_card`, `address_proof`, `board_resolution`, `bank_passbook`, `payment_proof`, 
                                      `registrant`, `reference_no`, `register_by`, `status`) 
           VALUES (:name, :no_of_branches, :types_of_institution, :incorporation_date, :institution_pan,  
                                     :email, :country_code, :contact_no, :country, :state, :city, :pincode, :address,  
                                     :account_name, :account_number, :ifsc_code, :bank_and_branch_name,   
                                     :amount, :current_commission_per, :current_incentive_per, :payment_mode,  
                                     :cheque_no, :cheque_date, :bank_name, :transaction_no, :certificate_of_incorporation,  
                                     :gstin, :pan_card, :address_proof, :board_resolution, :bank_passbook, :payment_proof,  
                                     :registrant, :reference_no, :register_by, :status) ";
    $stmt3 =$conn->prepare($sql);

    $result2=$stmt3->execute(array(
        ':name' => $name,
        ':no_of_branches' => $number_branch,
        ':types_of_institution' => $institution_type_value,
        ':incorporation_date' => $incorporation_date,
        ':institution_pan' => $institution_pan,

        ':email' => $email,
        ':country_code' => $country_code,
        ':contact_no' => $phone,
        ':country' => $country,
        ':state' => $state,
        ':city' => $city,
        ':pincode' => $pincode,
        ':address' => $address,

        ':account_name' => $account_name,
        ':account_number' => $account_number,
        ':ifsc_code' => $ifsc_code,
        ':bank_and_branch_name' => $branch_name,

        ':amount' => $amount,
        ':current_commission_per' => $comm_per,
        ':current_incentive_per' => $ins_per,
        ':payment_mode' => $paymentMode,

        ':cheque_no' => $chequeNo,
        ':cheque_date' => $chequeDate,
        ':bank_name' => $bankName,
        ':transaction_no' => $transactionNo,

        ':certificate_of_incorporation' => $certificate_of_incorporation,
        ':gstin' => $gstin,
        ':pan_card' => $pancard,
        ':address_proof' => $address_proof,
        ':board_resolution' => $board_resolution,
        ':bank_passbook' => $cancelled_cheque_bank_passbook,
        ':payment_proof' => $payment_proof,

        ':registrant' => $reference_name,
        ':reference_no' => $reference_id,
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
        ':reference_no' => $reference_id,
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