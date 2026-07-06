<?php

    include_once(__DIR__.'/../../../dashboard_user_details.php');

    $current_year = date('Y');

    $editfor      = $_POST["editfor"] ?? '';
    $actionType   = $_POST['action_type'] ?? '';

    $user_id_name = $userId;
    $registrant   = $userFname . ' ' . $userLname;

    $fname             = $_POST['firstname'] ?? '';
    $lname             = $_POST['lastname'] ?? '';
    $nominee_name      = $_POST['nominee_name'] ?? '';
    $nominee_relation  = $_POST['nominee_relation'] ?? '';
    $email             = $_POST['email'] ?? '';
    $gender            = $_POST['gender'] ?? '';
    $country_code      = $_POST['country_code'] ?? '';
    $phone_no          = $_POST['phone'] ?? '';
    $gst_no            = $_POST['gst_no'] ?? '';
    $amount            = $_POST['business_package'] ?? '';

    $bdate = !empty($_POST['dob'])
        ? date('Y-m-d', strtotime($_POST['dob']))
        : null;

    $profile_pic   = $_POST['profile_pic'] ?? '';
    $pan_card      = $_POST['pan_card'] ?? '';
    $aadhar_card   = $_POST['aadhar_card'] ?? '';
    $voting_card   = $_POST['voting_card'] ?? '';
    $passbook      = $_POST['passbook'] ?? '';
    $payment_proof = $_POST['payment_proof'] ?? '';

    $address  = $_POST['address'] ?? '';
    $pincode  = $_POST['pincode'] ?? '';
    $country  = $_POST['country'] ?? '';
    $state    = $_POST['state'] ?? '';
    $city     = $_POST['city'] ?? '';

    $paymentMode  = $_POST['paymentMode'] ?? '';
    $chequeNo     = $_POST['chequeNo'] ?? '';
    $chequeDate   = $_POST['chequeDate'] ?? '';
    $bankName     = $_POST['bankName'] ?? '';
    $transactionNo = $_POST['transactionNo'] ?? '';

    $message2 = '';

    $user_type  = "29";
    $register_by = $userType;

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
    else if($amount >= '500000') {
        $comm_per=30;
        $ins_per=20;
    }

    /* ---------------- AGE ---------------- */

    $age = 0;

    if (!empty($bdate)) {
        $age = (new DateTime($bdate))
            ->diff(new DateTime())
            ->y;
    }

    /* ---------------- STATUS ---------------- */

    if ($actionType == 'draft') {

        $status = '4';

        $message =
            "Franchisee form saved as draft by {$userId} ({$userFname} {$userLname}) from Add Page";

    } else {

        $status = '2';

        $message =
            "Added new Franchisee. Franchisee name - {$fname} {$lname}";

        $message2 =
            "Added new Franchisee by Sponsor Franchisee ";
    }

    /* ---------------- EDIT MODE ---------------- */

    if ($status == '4' || $status == '2') {

        $identifier_id = $_POST["id"] ?? '';

        $identifier_field = 'id';

        $message =
            "Updated Franchisee details from pending list";

        $message2 =
            "Updated Franchisee details from pending list";

    } elseif ($status == '1') {

        $identifier_id = $_POST["id"] ?? '';

        $identifier_field = 'sub_franchisee_id';

        $message =
            $identifier_id . " Details has been updated from registered list";

        $message2 =
            $identifier_id . " Details has been updated from registered list";

    } else {

        echo 0;
        exit;
    }

    /* ---------------- UPDATE ---------------- */

    try {

        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "
            UPDATE sub_franchisee SET

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

                gst_no = :gst_no,
                amount = :amount,

                country = :country,
                state = :state,
                city = :city,
                pincode = :pincode,
                address = :address,

                profile_pic = :profile_pic,
                pan_card = :pan_card,
                aadhar_card = :aadhar_card,
                voting_card = :voting_card,
                bank_passbook = :bank_passbook,
                payment_proof = :payment_proof,

                payment_mode = :payment_mode,
                cheque_no = :cheque_no,
                cheque_date = :cheque_date,
                bank_name = :bank_name,
                transaction_no = :transaction_no,
                current_commission_per=:current_commission_per,
                current_incentive_per=:current_incentive_per,

                status = :status

            WHERE {$identifier_field} = :identifier_id
        ";

        $stmt3 = $conn->prepare($sql);
        
        $result2 = $stmt3->execute([

            ':firstname' => $fname,
            ':lastname' => $lname,

            ':nominee_name' => $nominee_name,
            ':nominee_relation' => $nominee_relation,

            ':country_code' => $country_code,
            ':contact_no' => $phone_no,
            ':email' => $email,

            ':gender' => $gender,
            ':date_of_birth' => $bdate,
            ':age' => $age,

            ':gst_no' => $gst_no,
            ':amount' => $amount,

            ':country' => $country,
            ':state' => $state,
            ':city' => $city,
            ':pincode' => $pincode,
            ':address' => $address,

            ':profile_pic' => $profile_pic,
            ':pan_card' => $pan_card,
            ':aadhar_card' => $aadhar_card,
            ':voting_card' => $voting_card,
            ':bank_passbook' => $passbook,
            ':payment_proof' => $payment_proof,

            ':payment_mode' => $paymentMode,
            ':cheque_no' => $chequeNo,
            ':cheque_date' => $chequeDate,
            ':bank_name' => $bankName,
            ':transaction_no' => $transactionNo,

            ':status' => $status,
            ':current_commission_per' => $comm_per,
            ':current_incentive_per' => $ins_per,

            ':identifier_id' => $identifier_id

        ]);


        if ($result2) {

            $sql2 = "
                INSERT INTO logs
                (
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
                    :title,
                    :message,
                    :message2,
                    :reference_no,
                    :register_by,
                    :from_whom,
                    :operation
                )
            ";

            $stmt = $conn->prepare($sql2);

            $result = $stmt->execute([

                ':title' => 'Franchisee',
                ':message' => $message,
                ':message2' => $message2,
                ':reference_no' => $userId,
                ':register_by' => $register_by,
                ':from_whom' => $userType,
                ':operation' => 'Update'

            ]);

            echo $result ? 1 : 0;

        } else {

            echo 0;
        }

    } catch (PDOException $e) {

        echo $e->getMessage();
    }
?>