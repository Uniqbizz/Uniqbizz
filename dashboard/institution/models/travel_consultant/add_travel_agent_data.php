<?php

include_once(__DIR__ . '/../../../dashboard_user_details.php');

$current_year = date('Y');

$user_id_name = $userId;
$registrant = $firstname . ' ' . $lastname;

/* =========================
   POST DATA
========================= */

$firstname         = $_POST['firstname'] ?? '';
$lastname          = $_POST['lastname'] ?? '';
$nominee_name      = $_POST['nominee_name'] ?? '';
$nominee_relation  = $_POST['nominee_relation'] ?? '';
$email             = $_POST['email'] ?? '';
$gender            = $_POST['gender'] ?? '';
$country_code      = $_POST['country_code'] ?? '';
$phone_no          = $_POST['phone'] ?? '';
$bdate             = $_POST['dob'] ?? '';
$profile_pic       = $_POST['profile_pic'] ?? '';
$pan_card          = $_POST['pan_card'] ?? '';
$aadhar_card       = $_POST['aadhar_card'] ?? '';
$voting_card       = $_POST['voting_card'] ?? '';
$passbook          = $_POST['passbook'] ?? '';
$payment_proof     = $_POST['payment_proof'] ?? '';
$payment_fee       = $_POST['payment_fee'] ?? '';
$paymentMode       = $_POST['paymentMode'] ?? '';
$chequeNo          = $_POST['chequeNo'] ?? '';
$chequeDate        = $_POST['chequeDate'] ?? '';
$bankName          = $_POST['bankName'] ?? '';
$transactionNo     = $_POST['transactionNo'] ?? '';
$address           = $_POST['address'] ?? '';
$pincode           = $_POST['pincode'] ?? '';
$branch            = $_POST['branch'] ?? '';
$country           = $_POST['country'] ?? '';
$state             = $_POST['state'] ?? '';
$city              = $_POST['city'] ?? '';
$actionType        = $_POST['action_type'] ?? '';

/*
 * POST user type
 *
 * 11 = Travel Consultant
 * 33 = Institution Branch Manager
 */
$postUserType = $_POST['user_type'] ?? '';

/* =========================
   VALIDATE USER TYPE
========================= */

if ($postUserType == '11') {

    $user_type = '11';
    $tableName = 'ca_travelagency';

} elseif ($postUserType == '33') {

    $user_type = '33';
    $tableName = 'institution_branch_manager';

} else {

    echo 0;
    exit;
}

/* =========================
   STATUS
========================= */

if ($actionType == 'submit') {

    $status = 2;

} elseif ($actionType == 'draft') {

    $status = 4;

} else {

    echo 0;
    exit;
}

/* =========================
   REGISTER BY
========================= */

$register_by = $userType;

/* =========================
   AGE
========================= */

$age = 0;

if (!empty($bdate)) {

    $birthDate = new DateTime($bdate);
    $today = new DateTime();

    $age = $birthDate->diff($today)->y;
}

/* =========================
   LOG DATA
========================= */

$title = ($user_type == '11')
    ? "Travel Consultant"
    : "Institution Branch Manager";

$message = "Added new " . $title . ". Name - " . $firstname . " " . $lastname;

$message2 = "Added new " . $title . ". By -" . $userId;

$fromWhom = $userType;
$operation = "Add";

/* =========================
   INSERT DATA
========================= */

$sql = "
    INSERT INTO `$tableName`
    (
        firstname,
        lastname,
        nominee_name,
        nominee_relation,
        email,
        country_code,
        contact_no,
        date_of_birth,
        age,
        gender,
        country,
        state,
        city,
        pincode,
        branch,
        address,
        profile_pic,
        pan_card,
        aadhar_card,
        voting_card,
        passbook,
        payment_proof,
        amount,
        payment_mode,
        cheque_no,
        cheque_date,
        bank_name,
        transaction_no,
        user_type,
        registrant,
        reference_no,
        register_by,
        status
    )
    VALUES
    (
        :firstname,
        :lastname,
        :nominee_name,
        :nominee_relation,
        :email,
        :country_code,
        :contact_no,
        :bdate,
        :age,
        :gender,
        :country,
        :state,
        :city,
        :pincode,
        :branch,
        :address,
        :profile_pic,
        :pan_card,
        :aadhar_card,
        :voting_card,
        :passbook,
        :payment_proof,
        :amount,
        :payment_mode,
        :cheque_no,
        :cheque_date,
        :bank_name,
        :transaction_no,
        :user_type,
        :registrant,
        :reference_no,
        :register_by,
        :status
    )
";

$stmt = $conn->prepare($sql);

$result = $stmt->execute([
    ':firstname'        => $firstname,
    ':lastname'         => $lastname,
    ':nominee_name'     => $nominee_name,
    ':nominee_relation' => $nominee_relation,
    ':email'            => $email,
    ':country_code'     => $country_code,
    ':contact_no'       => $phone_no,
    ':bdate'            => $bdate,
    ':age'              => $age,
    ':gender'           => $gender,
    ':country'          => $country,
    ':state'            => $state,
    ':city'             => $city,
    ':pincode'          => $pincode,
    ':branch'           => $branch,
    ':address'          => $address,
    ':profile_pic'      => $profile_pic,
    ':pan_card'         => $pan_card,
    ':aadhar_card'      => $aadhar_card,
    ':voting_card'      => $voting_card,
    ':passbook'         => $passbook,
    ':payment_proof'    => $payment_proof,
    ':amount'           => $payment_fee,
    ':payment_mode'     => $paymentMode,
    ':cheque_no'        => $chequeNo,
    ':cheque_date'      => $chequeDate,
    ':bank_name'        => $bankName,
    ':transaction_no'   => $transactionNo,
    ':user_type'        => $user_type,
    ':registrant'       => $registrant,
    ':reference_no'     => $user_id_name,
    ':register_by'      => $register_by,
    ':status'           => $status
]);

/* =========================
   INSERT LOG
========================= */

if ($result) {

    /*
     * IMPORTANT:
     * Use lastInsertId() instead of
     * SELECT id ORDER BY id DESC.
     */
    $id = $conn->lastInsertId();

    $sql3 = "
        INSERT INTO logs
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
        )
    ";

    $stmt3 = $conn->prepare($sql3);

    $result3 = $stmt3->execute([
        ':user_id'      => $id,
        ':title'        => $title,
        ':message'      => $message,
        ':message2'     => $message2,
        ':reference_no' => $user_id_name,
        ':register_by'  => $register_by,
        ':from_whom'    => $fromWhom,
        ':operation'    => $operation
    ]);

    if ($result3) {

        /*
         * submit:
         * 2 -> return 1
         *
         * draft:
         * 4 -> return 2
         */
        if ($status == 2) {

            $newStatus = 1;

        } elseif ($status == 4) {

            $newStatus = 2;

        } else {

            $newStatus = $status;
        }

        echo $newStatus;

    } else {

        echo 0;
    }

} else {

    echo 0;
}

?>