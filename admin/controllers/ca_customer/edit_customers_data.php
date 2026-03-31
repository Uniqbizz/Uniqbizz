<?php
require "../../connect.php";
$current_year = date('Y');

$refid = $_POST["ref_id"];
$editfor = $_POST["editfor"];

/* -------------------------
IDENTIFIER FIX
------------------------- */

if ($editfor == 'pending') {
    $identifier_id = $_POST["id"];
    $identifier_column = 'id';
    $coupon_status = 0;
    $message = "Updated Customer details from pending list";
    $message2 = $message;
} else if ($editfor == 'registered') {
    $identifier_id = $_POST["id"];
    $identifier_column = 'ca_customer_id';
    $coupon_status = 1;
    $message = $identifier_id . " Details has been updated from registered list";
    $message2 = $message;
}

/* -------------------------
FORM DATA
------------------------- */

$cust_id_name = $_POST['cust_id_name'];
$cust_name = $_POST['cust_name'];
$firstname = $_POST['firstname'];
$lastname = $_POST['lastname'];
$email = $_POST['email'];
$gender = $_POST['gender'];
$country_code = $_POST['country_code'];
$phone = $_POST['phone'];
$dob = $_POST['dob'];

$birthYear = str_split($dob, 4);
$age = $current_year - $birthYear[0];

$payment_fee = $_POST['payment_fee'];
$payment_label = $_POST['payment_label'];
$comp_chek = $_POST['isComplementary'];

$profile_pic = $_POST['profile_pic'];
$pan_card = $_POST['pan_card'];
$aadhar_card = $_POST['aadhar_card'];
$voting_card = $_POST['voting_card'];
$bank_passbook = $_POST['passbook'];

$payment_proof = $_POST['payment_proof'] ?? '';
$payment_mode = $_POST['paymentMode'];
$cheque_no = $_POST['chequeNo'] ?? '';
$cheque_date = $_POST['chequeDate'] ?? '';
$bank_name = $_POST['bankName'] ?? '';
$transaction_no = $_POST['transactionNo'] ?? '';

$address = $_POST['address'];
$pincode = $_POST['pincode'];
$country = $_POST['country'];
$state = $_POST['state'];
$city = $_POST['city'];

$note = $_POST['note'];

$user_type_id = '11';
$title = "Customer";
$fromWhom = "1";
$register_by = "1";
$ip_address = 'NA';

$edit_reason = $_POST['edit_reason'] ?? '';

/* -------------------------
FETCH OLD DATA
------------------------- */

$stmt = $conn->prepare("SELECT * FROM ca_customer WHERE $identifier_column = :id");
$stmt->execute(['id'=>$identifier_id]);
$prevUserData = $stmt->fetch(PDO::FETCH_ASSOC) ?? [];

/* -------------------------
NEW DATA ARRAY
------------------------- */

$newUserData = [
    "firstname"=>$firstname,
    "lastname"=>$lastname,
    "country_code"=>$country_code,
    "contact_no"=>$phone,
    "email"=>$email,
    "gender"=>$gender,
    "date_of_birth"=>$dob,
    "age"=>$age,
    "country"=>$country,
    "state"=>$state,
    "city"=>$city,
    "pincode"=>$pincode,
    "address"=>$address,
    "note"=>$note,
    "profile_pic"=>$profile_pic,
    "pan_card"=>$pan_card,
    "aadhar_card"=>$aadhar_card,
    "voting_card"=>$voting_card,
    "passbook"=>$bank_passbook,
    "paid_amount"=>$payment_fee,
    "payment_mode"=>$payment_mode,
    "cheque_no"=>$cheque_no,
    "cheque_date"=>$cheque_date,
    "bank_name"=>$bank_name,
    "transaction_no"=>$transaction_no,
    "payment_proof"=>$payment_proof,
    "customer_type"=>$payment_label,
    "comp_chek"=>$comp_chek,
    "registrant"=>$cust_name,
    "reference_no"=>$cust_id_name
];

/* -------------------------
COMPARE CHANGES
------------------------- */

$ignoreColumns = [
    'age','paid_amount','payment_mode','cheque_no',
    'cheque_date','bank_name','transaction_no','payment_proof'
];

$changes = [];

foreach($newUserData as $column=>$newValue){

    if(in_array($column,$ignoreColumns)) continue;

    $oldValue = $prevUserData[$column] ?? '';

    $oldValue = trim((string)$oldValue);
    $newValue = trim((string)$newValue);

    if($oldValue === $newValue) continue;

    $changes[] = [
        "column"=>$column,
        "old"=>$oldValue,
        "new"=>$newValue
    ];
}

/* -------------------------
UPDATE CUSTOMER
------------------------- */

if ($firstname != '' || $lastname != '' || $phone != '' || $email != '' || $gender != '' || $dob != '' || $address != '' || $profile_pic != '') {

    $sql1 = "UPDATE ca_customer SET 
        firstname=:firstname,
        lastname=:lastname,
        country_code=:country_code,
        contact_no=:contact_no,
        email=:email,
        gender=:gender,
        date_of_birth=:date_of_birth,
        age=:age,
        country=:country,
        state=:state,
        city=:city,
        pincode=:pincode,
        address=:address,
        note=:note,
        profile_pic=:profile_pic,
        pan_card=:pan_card,
        aadhar_card=:aadhar_card,
        voting_card=:voting_card,
        passbook=:passbook,
        payment_proof=:payment_proof,
        payment_mode=:payment_mode,
        cheque_no=:cheque_no,
        cheque_date=:cheque_date,
        bank_name=:bank_name,
        transaction_no=:transaction_no,
        paid_amount=:paid_amount,
        customer_type=:customer_type,
        comp_chek=:comp_chek,
        registrant=:registrant,
        reference_no=:reference_no
    WHERE $identifier_column = :identifier_id";

    $stmt = $conn->prepare($sql1);

    $result = $stmt->execute([
        ':firstname'=>$firstname,
        ':lastname'=>$lastname,
        ':country_code'=>$country_code,
        ':contact_no'=>$phone,
        ':email'=>$email,
        ':gender'=>$gender,
        ':date_of_birth'=>$dob,
        ':age'=>$age,
        ':country'=>$country,
        ':state'=>$state,
        ':city'=>$city,
        ':pincode'=>$pincode,
        ':address'=>$address,
        ':note'=>$note,
        ':profile_pic'=>$profile_pic,
        ':pan_card'=>$pan_card,
        ':aadhar_card'=>$aadhar_card,
        ':voting_card'=>$voting_card,
        ':passbook'=>$bank_passbook,
        ':payment_proof'=>$payment_proof,
        ':payment_mode'=>$payment_mode,
        ':cheque_no'=>$cheque_no,
        ':cheque_date'=>$cheque_date,
        ':bank_name'=>$bank_name,
        ':transaction_no'=>$transaction_no,
        ':paid_amount'=>$payment_fee,
        ':customer_type'=>$payment_label,
        ':comp_chek'=>$comp_chek,
        ':registrant'=>$cust_name,
        ':reference_no'=>$cust_id_name,
        ':identifier_id'=>$identifier_id
    ]);

    /* -------------------------
    INSERT EDIT LOGS
    ------------------------- */

    if($result && !empty($changes)){
        foreach($changes as $change){

            $stmtLog = $conn->prepare("
                INSERT INTO field_edit_logs
                (table_name,record_id,column_name,old_value,new_value,change_reason,changed_by,changed_role,ip_address)
                VALUES
                (:table_name,:record_id,:column_name,:old_value,:new_value,:change_reason,:changed_by,:changed_role,:ip_address)
            ");

            $stmtLog->execute([
                ':table_name'=>'ca_customer',
                ':record_id'=>$identifier_id,
                ':column_name'=>$change['column'],
                ':old_value'=>$change['old'],
                ':new_value'=>$change['new'],
                ':change_reason'=>$edit_reason,
                ':changed_by'=>$register_by,
                ':changed_role'=>'admin',
                ':ip_address'=>$ip_address
            ]);
        }
    }

    /* -------------------------
    LOGIN UPDATE
    ------------------------- */

    $stmt2 = $conn->prepare("UPDATE login SET username=:email WHERE user_id=:user_id AND user_type_id=:user_type_id");

    $result22 = $stmt2->execute([
        ':email'=>$email,
        ':user_type_id'=>$user_type_id,
        ':user_id'=>$identifier_id
    ]);

    /* -------------------------
    SYSTEM LOG
    ------------------------- */

    if ($result22) {

        $stmt3 = $conn->prepare("INSERT INTO logs 
        (user_id,title,message,message2,reference_no, register_by, from_whom, operation) 
        VALUES 
        (:user_id,:title,:message,:message2,:reference_no,:register_by,:from_whom,:operation)");

        $result3 = $stmt3->execute([
            ':user_id'=>$identifier_id,
            ':title'=>$title,
            ':message'=>$message,
            ':message2'=>$message2,
            ':reference_no'=>$refid,
            ':register_by'=>$register_by,
            ':from_whom'=>$fromWhom,
            ':operation'=>'Edit'
        ]);

        echo $result3 ? 1 : 0;

    } else {
        echo 0;
    }

} else {
    echo 0;
}
?>