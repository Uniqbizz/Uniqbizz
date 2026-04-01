<?php
require "../../connect.php";

$current_year = date('Y');

$refid = $_POST["ref_id"];
$editfor = $_POST["editfor"];
$tc_count = $_POST['tcCount'];

if ($editfor == 'pending') {
    $identifier_id = $_POST["id"];
    $identifier_name = 'id=';
    $identifier_column = 'id';
    $message = "Updated Techno Enterprise details from pending list";
    $message2 = $message;
} else {
    $identifier_id = $_POST["id"];
    $identifier_name = 'corporate_agency_id=';
    $identifier_column = 'corporate_agency_id';
    $message = $identifier_id . " Details has been updated from registered list";
    $message2 = $message;

    $tc_message = $identifier_id . ": ".$tc_count." TC has been Allotted from registered list";
    $tc_message2 = $tc_message;
}

/* -------------------------
POST DATA
------------------------- */

$firstname = $_POST['firstname'];
$lastname = $_POST['lastname'];
$nominee_name = $_POST['nominee_name'];
$nominee_relation = $_POST['nominee_relation'];
$email = $_POST['email'];
$gender = $_POST['gender'];
$country_code = $_POST['country_code'];
$phone = $_POST['phone'];
$dob = $_POST['dob'];

$birthYear = str_split($dob, 4);
$age = $current_year - $birthYear[0];

$gst_no = $_POST['gst_no'];
$amount = $_POST['amount'];

$profile_pic = $_POST['profile_pic'];
$pan_card = $_POST['pan_card'];
$aadhar_card = $_POST['aadhar_card'];
$voting_card = $_POST['voting_card'];
$bank_passbook = $_POST['passbook'];

$payment_proof = $_POST['payment_proof'];
$payment_mode = $_POST['paymentMode'];
$cheque_no = $_POST['chequeNo'];
$cheque_date = $_POST['chequeDate'];
$bank_name = $_POST['bankName'];
$transaction_no = $_POST['transactionNo'];

$address = $_POST['address'];
$pincode = $_POST['pincode'];
$country = $_POST['country'];
$state = $_POST['state'];
$city = $_POST['city'];
$note = $_POST['note'];

$tc_ids = $_POST['selectedIds'] ?? [];
$tc_ids = is_array($tc_ids) ? array_filter($tc_ids) : array_filter(explode(',', $tc_ids));

$tc_assign_status = !empty($tc_ids) ? 1 : 2;

function postNumber($key) {
    return (isset($_POST[$key]) && is_numeric($_POST[$key])) ? (float)$_POST[$key] : 0;
}

$tenure      = postNumber('tenure');
$roi         = postNumber('roi');
$tax         = postNumber('tax');
$repayAmount = postNumber('repayAmount');

$user_type_id = '16';
$title = "Techno Enterprise";
$fromWhom = "1";
$register_by = "1";
$operation = "Update";
$ip_address = $_SERVER['REMOTE_ADDR'] ?? 'NA';

/* -------------------------
FETCH OLD DATA (FOR FIELD LOGS)
------------------------- */
$stmtPrev = $conn->prepare("SELECT * FROM corporate_agency WHERE $identifier_column=:identifier_id");
$stmtPrev->execute([':identifier_id' => $identifier_id]);
$prevUserData = $stmtPrev->fetch(PDO::FETCH_ASSOC) ?? [];

/* -------------------------
NEW DATA ARRAY
------------------------- */

$newUserData = [
    "firstname"=>$firstname,
    "lastname"=>$lastname,
    "nominee_name"=>$nominee_name,
    "nominee_relation"=>$nominee_relation,
    "country_code"=>$country_code,
    "contact_no"=>$phone,
    "email"=>$email,
    "gender"=>$gender,
    "date_of_birth"=>$dob,
    "age"=>$age,
    "gst_no"=>$gst_no,
    "amount"=>$amount,
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
    "bank_passbook"=>$bank_passbook,
    "payment_proof"=>$payment_proof,
    "payment_mode"=>$payment_mode,
    "cheque_no"=>$cheque_no,
    "cheque_date"=>$cheque_date,
    "bank_name"=>$bank_name,
    "transaction_no"=>$transaction_no,
    "no_tc_alloted"=>$tc_count,
    "repay_tenure"=>$tenure,
    "roi"=>$roi,
    "tax"=>$tax,
    "repay_amount"=>$repayAmount,
    "tc_assign_status"=>$tc_assign_status
];

/* -------------------------
COMPARE CHANGES
------------------------- */

$changes = [];

foreach ($newUserData as $column => $newValue) {

    $oldValue = $prevUserData[$column] ?? '';

    $oldValue = trim((string)$oldValue);
    $newValue = trim((string)$newValue);

    if ($oldValue === $newValue) continue;

    $changes[] = [
        "column"=>$column,
        "old"=>$oldValue,
        "new"=>$newValue
    ];
}

/* -------------------------
UPDATE MAIN TABLE
------------------------- */

if ($firstname != '' || $lastname != '' || $phone != '' || $email != '' || $gender != '' || $dob != '' || $address != '' || $profile_pic != '') {

    $sql1 = "UPDATE corporate_agency SET firstname=:firstname,lastname=:lastname,
    nominee_name=:nominee_name,nominee_relation=:nominee_relation,country_code=:country_code,
    contact_no=:contact_no,email=:email,gender=:gender,date_of_birth=:date_of_birth,age=:age, 
    gst_no=:gst_no, amount=:amount, country=:country,state=:state,city=:city,pincode=:pincode,
    address=:address,note=:note,profile_pic=:profile_pic,pan_card=:pan_card,aadhar_card=:aadhar_card,voting_card=:voting_card ,
    bank_passbook=:passbook, payment_proof=:payment_proof, payment_mode=:payment_mode, cheque_no=:cheque_no, 
    cheque_date=:cheque_date, bank_name=:bank_name, transaction_no=:transaction_no,
    no_tc_alloted=:no_tc_alloted,repay_tenure=:repay_tenure,roi=:roi,tax=:tax,
    repay_amount=:repay_amount,tc_assign_status=:tc_assign_status
    WHERE $identifier_name:identifier_id ";

    $stmt = $conn->prepare($sql1);

    $result = $stmt->execute([
        ':firstname'=>$firstname,
        ':lastname'=>$lastname,
        ':nominee_name'=>$nominee_name,
        ':nominee_relation'=>$nominee_relation,
        ':country_code'=>$country_code,
        ':contact_no'=>$phone,
        ':email'=>$email,
        ':gst_no'=>$gst_no,
        ':amount'=>$amount,
        ':gender'=>$gender,
        ':date_of_birth'=>$dob,
        ':country'=>$country,
        ':state'=>$state,
        ':city'=>$city,
        ':pincode'=>$pincode,
        ':address'=>$address,
        ':note'=>$note,
        ':profile_pic'=>$profile_pic,
        ':age'=>$age,
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
        ':no_tc_alloted'=>$tc_count,
        ':repay_tenure'=>$tenure,
        ':roi'=>$roi,
        ':tax'=>$tax,
        ':repay_amount'=>$repayAmount,
        ':tc_assign_status'=>$tc_assign_status,
        ':identifier_id'=>$identifier_id
    ]);

    /* -------------------------
    FIELD EDIT LOGS (NEW)
    ------------------------- */

    if ($result && !empty($changes)) {

        foreach ($changes as $change) {

            $stmtLog = $conn->prepare("
                INSERT INTO field_edit_logs
                (table_name,record_id,column_name,old_value,new_value,change_reason,changed_by,changed_role,ip_address)
                VALUES
                (:table_name,:record_id,:column_name,:old_value,:new_value,:change_reason,:changed_by,:changed_role,:ip_address)
            ");

            $stmtLog->execute([
                ':table_name'=>'corporate_agency',
                ':record_id'=>$identifier_id,
                ':column_name'=>$change['column'],
                ':old_value'=>$change['old'],
                ':new_value'=>$change['new'],
                ':change_reason'=>'Edit TE',
                ':changed_by'=>$register_by,
                ':changed_role'=>'admin',
                ':ip_address'=>$ip_address
            ]);
        }
    }

    /* -------------------------
    REST OF YOUR ORIGINAL CODE (UNCHANGED)
    ------------------------- */

    $sql = "UPDATE login SET username=:email WHERE user_id=:user_id and user_type_id=:user_type_id";
    $stmt2 = $conn->prepare($sql);
    $result2 = $stmt2->execute([
        ':email' => $email,
        ':user_type_id' => $user_type_id,
        ':user_id' => $identifier_id
    ]);

    if ($result2) {

        $sql3 = "INSERT INTO logs (user_id,title,message,message2,reference_no, register_by, from_whom,operation)
        VALUES (:user_id,:title ,:message, :message2,:reference_no, :register_by, :from_whom,:operation)";

        $stmt3 = $conn->prepare($sql3);

        $result3 = $stmt3->execute([
            ':user_id' => $identifier_id,
            ':title' => $title,
            ':message' => $message,
            ':message2' => $message2,
            ':reference_no' => $refid,
            ':register_by' => $register_by,
            ':from_whom' => $fromWhom,
            ':operation' => $operation
        ]);

        if ($tc_count) {

            $stmt3_1 = $conn->prepare($sql3);

            $stmt3_1->execute([
                ':user_id' => $identifier_id,
                ':title' => 'TC Allotment',
                ':message' => $tc_message,
                ':message2' => $tc_message2,
                ':reference_no' => $refid,
                ':register_by' => $register_by,
                ':from_whom' => $fromWhom,
                ':operation' => 'TC Allotment'
            ]);
        }

        echo $result3 ? 1 : 0;

    } else {
        echo 0;
    }

} else {
    echo 0;
}
?>