<?php
include_once(__DIR__.'/../../../dashboard_user_details.php');

$current_year = date('Y');
$status;
$action_type = $_POST['action_type'] ?? '';

if ($action_type == 'submit') {
    $editfor = 2;
	$status=2;
} elseif ($action_type == 'draft') {
    $editfor = 4;
	$status=4;
}

$identifier_id = $_POST["id"] ?? '';

if ($editfor == 4 || $editfor == 2  ) {

    $identifier_name = 'id=';

    $message = "Updated Travel Consultant details from pending list";
    $message2 = "Updated Travel Consultant details from pending list";
	

} else {

    $identifier_name = 'ca_travelagency_id=';

    $message = "Travel Consultant details updated";
    $message2 = "Travel Consultant details updated";
}


/* -------------------------
   POST DATA
--------------------------*/

$firstname         = $_POST['firstname'] ?? '';
$lastname          = $_POST['lastname'] ?? '';
$nominee_name      = $_POST['nominee_name'] ?? '';
$nominee_relation  = $_POST['nominee_relation'] ?? '';
$email             = $_POST['email'] ?? '';
$gender            = $_POST['gender'] ?? '';
$country_code      = $_POST['country_code'] ?? '';
$phone             = $_POST['phone'] ?? '';
$dob               = $_POST['dob'] ?? '';

$birthYear = explode('-', $dob);
$birth_year = $birthYear[0] ?? $current_year;
$age = $current_year - $birth_year;

$profile_pic    = $_POST['profile_pic'] ?? '';
$pan_card       = $_POST['pan_card'] ?? '';
$aadhar_card    = $_POST['aadhar_card'] ?? '';
$voting_card    = $_POST['voting_card'] ?? '';
$bank_passbook  = $_POST['passbook'] ?? '';

$payment_proof  = $_POST['payment_proof'] ?? '';
$payment_mode   = $_POST['paymentMode'] ?? '';
$cheque_no      = $_POST['chequeNo'] ?? '';
$cheque_date    = $_POST['chequeDate'] ?? '';
$bank_name      = $_POST['bankName'] ?? '';
$transaction_no = $_POST['transactionNo'] ?? '';

$address        = $_POST['address'] ?? '';
$pincode        = $_POST['pincode'] ?? '';

$country        = $_POST['country'] ?? '';
$state          = $_POST['state'] ?? '';
$city           = $_POST['city'] ?? '';

$branch         = $_POST['branch'] ?? '';

$userId         = $_POST['userId'] ?? '';
$userType       = $_POST['userType'] ?? '';

$user_type_id   = '11';

$title = "Travel Consultant";


if (
    $firstname != '' ||
    $lastname != '' ||
    $phone != '' ||
    $email != '' ||
    $gender != '' ||
    $dob != '' ||
    $address != '' ||
    $profile_pic != ''
) {

    $sql1 = "UPDATE ca_travelagency SET

            firstname=:firstname,
            lastname=:lastname,
            nominee_name=:nominee_name,
            nominee_relation=:nominee_relation,
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
            branch=:branch,
            address=:address,

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
			status=:status

            WHERE $identifier_name :identifier_id";

    $stmt = $conn->prepare($sql1);

    $result = $stmt->execute(array(

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
        ':branch' => $branch,
        ':address' => $address,

        ':profile_pic' => $profile_pic,
        ':pan_card' => $pan_card,
        ':aadhar_card' => $aadhar_card,
        ':voting_card' => $voting_card,
        ':passbook' => $bank_passbook,
        ':payment_proof' => $payment_proof,

        ':payment_mode' => $payment_mode,
        ':cheque_no' => $cheque_no,
        ':cheque_date' => $cheque_date,
        ':bank_name' => $bank_name,
        ':transaction_no' => $transaction_no,
        ':status' => $status,

        ':identifier_id' => $identifier_id

    ));
	
    if ($result) {

        $sql = "UPDATE login
                SET username=:email
                WHERE user_id=:user_id
                AND user_type_id=:user_type_id";

        $stmt2 = $conn->prepare($sql);

        $result2 = $stmt2->execute(array(

            ':email' => $email,
            ':user_id' => $identifier_id,
            ':user_type_id' => $user_type_id

        ));

        if ($result2) {

            $sql3 = "INSERT INTO logs
                    (
                        user_id,
                        title,
                        message,
                        message2,
                        reference_no,
                        register_by,
                        from_whom,
                        operation
                    )
                    VALUES
                    (
                        :user_id,
                        :title,
                        :message,
                        :message2,
                        :reference_no,
                        :register_by,
                        :from_whom,
                        :operation
                    )";

            $stmt3 = $conn->prepare($sql3);

            $result3 = $stmt3->execute(array(

                ':user_id' => $identifier_id,
                ':title' => $title,
                ':message' => $message,
                ':message2' => $message2,
                ':reference_no' => $userId,
                ':register_by' => $userType,
                ':from_whom' => $userType,
                ':operation' => 'Update'

            ));

            if($result){

                if ($status == 2) {
                    $newStatus = 1;
                } elseif ($status == 4) {
                    $newStatus = 2;
                } else {
                    $newStatus = $status;
                }

                echo $newStatus;
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