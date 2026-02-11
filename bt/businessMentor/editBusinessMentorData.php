<?php
require "../connect.php";
$current_year = date('Y'); 

$fid = $_POST["ref_id"];
$editfor = $_POST["editfor"];
$identifier_id = $_POST["id"];
$firstname = $_POST['firstname'];
$lastname = $_POST['lastname'];
$nominee_name = $_POST['nominee_name'];
$nominee_relation = $_POST['nominee_relation'];
$email = $_POST['email'];
$gender = $_POST['gender'];
$country_code = $_POST['country_code'];
$phone = $_POST['phone'];
$dob = $_POST['dob'];
$profile_pic = $_POST['profile_pic'];
$pan_card = $_POST['pan_card'];
$aadhar_card = $_POST['aadhar_card'];
$voting_card = $_POST['voting_card'];
$bank_passbook = $_POST['passbook'];
$address = $_POST['address'];
$pincode = $_POST['pincode'];
$country = $_POST['country'];
$state = $_POST['state'];
$city = $_POST['city'];
$zone = $_POST['zone'];
$branch = $_POST['branch'];
$payment_fee = $_POST['payment_fee'];
$payment_proof = $_POST['payment_proof'];
$payment_mode = $_POST['paymentMode'];
$cheque_no = $_POST['chequeNo'];
$cheque_date = $_POST['chequeDate'];
$bank_name = $_POST['bankName'];
$transaction_no = $_POST['transactionNo'];
$note = $_POST['note'];

$user_type_id = '26';
$title = "Business Mentor";
$fromWhom = "1";
$register_by = "1";
$operation = 'Update';

// Calculate Age
$birthYear = str_split($dob, 4);
$age = $current_year - $birthYear[0];

// Prepare the message and identifier name
if ($editfor == 'pending') {
    $identifier_name = 'id=';
    $message = "Updated Business Mentor details from the pending list";
} else {
    $identifier_name = 'business_mentor_id=';
    $message = "{$identifier_id} Details has been updated from the registered list";
}

if ($firstname != '' || $lastname != '' || $phone != '' || $email != '' || $gender != '' || $dob != '' || $address != '' || $profile_pic != '') {
    // SQL Update Query
    $sql1 = "UPDATE business_mentor SET 
        firstname = :firstname,
        lastname = :lastname,
        nominee_name = :nominee_name,
        nominee_relation = :nominee_relation,
        country_code = :country_code,
        contact_no = :contact_no,
        email = :email,
        gender = :gender,
        date_of_birth = :date_of_birth,
        age = :age, 
        country = :country,
        state = :state,
        city = :city,
        pincode = :pincode,
        address = :address,
        zone = :zone,
        branch = :branch,
        note = :note,
        profile_pic = :profile_pic,
        pan_card = :pan_card,
        aadhar_card = :aadhar_card,
        voting_card = :voting_card,
        paid_amount = :paid_amount,
        payment_mode = :payment_mode,
        cheque_no = :cheque_no, 
        cheque_date = :cheque_date,
        bank_name = :bank_name,
        transaction_no = :transaction_no,
        payment_proof = :payment_proof
    WHERE $identifier_name :identifier_id";

    // Execute Update Query
    $stmt = $conn->prepare($sql1);
    $result = $stmt->execute([
        ':firstname' => $firstname,
        ':lastname' => $lastname,
        ':nominee_name' => $nominee_name,
        ':nominee_relation' => $nominee_relation,
        ':country_code' => $country_code,
        ':contact_no' => $phone,
        ':email' => $email,
        ':gender' => $gender,
        ':date_of_birth' => $dob,
        ':age' => $age,
        ':country' => $country,
        ':state' => $state,
        ':city' => $city,
        ':pincode' => $pincode,
        ':address' => $address,
        ':zone' => $zone,
        ':branch' => $branch,
        ':note' => $note,
        ':profile_pic' => $profile_pic,
        ':pan_card' => $pan_card,
        ':aadhar_card' => $aadhar_card,
        ':voting_card' => $voting_card,
        ':paid_amount' => $payment_fee,
        ':payment_mode' => $payment_mode,
        ':cheque_no' => $cheque_no,
        ':cheque_date' => $cheque_date,
        ':bank_name' => $bank_name,
        ':transaction_no' => $transaction_no,
        ':payment_proof' => $payment_proof,
        ':identifier_id' => $identifier_id
    ]);

    // If Update Successful, Update Login Table
    if ($result) {
        $sql2 = "UPDATE login SET username = :email WHERE user_id = :user_id AND user_type_id = :user_type_id";
        $stmt2 = $conn->prepare($sql2);
        $result2 = $stmt2->execute([
            ':email' => $email,
            ':user_id' => $identifier_id,
            ':user_type_id' => $user_type_id
        ]);

        if ($result2) {
            // Log the update action
            $sql3 = "INSERT INTO logs (user_id, title, message, message2, reference_no, register_by, from_whom, operation) VALUES (:user_id, :title, :message, :message2, :reference_no, :register_by, :from_whom, :operation)";
            $stmt3 = $conn->prepare($sql3);
            $result3 = $stmt3->execute([
                ':user_id' => $identifier_id,
                ':title' => $title,
                ':message' => $message,
                ':message2' => $message,
                ':reference_no' => $fid,
                ':register_by' => $register_by,
                ':from_whom' => $fromWhom,
                ':operation' => $operation
            ]);

            if ($result3) {
                echo 1;
            } else {
                echo 0;
            }
        } else {
            echo 0;
        }
    } else {
        echo 0;
    }
} else {
    echo 0;
}
?>
