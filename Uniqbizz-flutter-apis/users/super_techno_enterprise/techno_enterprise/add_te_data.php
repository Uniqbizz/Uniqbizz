
<?php
    /* 
    Last updated by SV on 12-11-2026
    Payload example
    {
        "userId":"STE2600002",
        "userFname":"Priyali Damodar",
        "userLname":"Patkar",
        "register_by":"35",
        "action_type": "submit",
        "firstname": "Jhon",
        "lastname": "Wade",
        "email": "mygJon@mailinator.com",
        "dob": "1988-07-16",
        "gender": "male",
        "country_cd": "91",
        "phone": "5951236530",
        "business_package": "500000",
        "gst_no": "Dolore incididunt eo",
        "paymentMode": "online",
        "chequeNo": "",
        "chequeDate": "",
        "bankName": "",
        "transactionNo": "Sed rerum enim dolor",
        "country": "1",
        "state": "6",
        "city": "12",
        "pincode": "403 201",
        "address": "Reprehenderit hic c",
        "nominee_name": "Alan Dunlap",
        "nominee_relation": "wypoli@mailinator.com",
        "profile_pic": "profile_pic/e67eb556-f125-4e24-95ad-8aff21b9926a_592022858.jpg",
        "aadhar_card": "aadhar/11539820_14272277.png",
        "pan_card": "pancard/11539820_1743503845.png",
        "passbook": "passbook/11539820_788075671.png",
        "voting_card": "voting/11539820_1470740793.png",
        "payment_proof": "payment/11539820_1715335025.png"
        }
    */
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST, OPTIONS");
    header("Access-Control-Allow-Headers: Content-Type");

    require '../../../../connect.php';

    $response = [
        'success' => false,
        'message' => '',
        'data' => null
    ];

    // ==========================================
    // 1. REQUEST METHOD VALIDATION
    // ==========================================

    if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
        http_response_code(204);
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {

        http_response_code(405);

        $response['message'] = 'Only POST method is allowed.';

        echo json_encode($response);
        exit;
    }

    try {

        // ==========================================
        // 2. GET INPUT DATA
        // ==========================================

        $json = file_get_contents('php://input');

        $input = json_decode($json, true);

        if (!is_array($input)) {
            $input = $_POST;
        }

        if (!is_array($input) || empty($input)) {
            throw new Exception('Invalid or empty request data.');
        }

        // ==========================================
        // 3. FETCH INPUT VALUES
        // ==========================================

        $actionType = trim($input['action_type'] ?? '');

        // Logged-in user details supplied by frontend
        $userId = trim($input['userId'] ?? '');

        $userFname = trim($input['userFname'] ?? '');
        $userLname = trim($input['userLname'] ?? '');

        $userType = trim($input['register_by'] ?? '');

        // Registrant details
        $user_id_name = $userId;

        $registrant = trim($userFname . ' ' . $userLname);

        // Techno Enterprise details
        $fname = trim($input['firstname'] ?? '');
        $lname = trim($input['lastname'] ?? '');

        $nominee_name = $input['nominee_name'] ?? '';
        $nominee_relation = $input['nominee_relation'] ?? '';

        $email = trim($input['email'] ?? '');

        $gender = $input['gender'] ?? '';

        $country_code = $input['country_cd'] ?? '';
        $phone_no = $input['phone'] ?? '';

        $gst_no = $input['gst_no'] ?? '';

        $amount = $input['business_package'] ?? 0;

        $dob = trim($input['dob'] ?? '');

        $profile_pic = $input['profile_pic'] ?? '';
        $pan_card = $input['pan_card'] ?? '';
        $aadhar_card = $input['aadhar_card'] ?? '';
        $voting_card = $input['voting_card'] ?? '';
        $passbook = $input['passbook'] ?? '';
        $payment_proof = $input['payment_proof'] ?? '';

        $address = $input['address'] ?? '';
        $pincode = $input['pincode'] ?? '';

        $country = $input['country'] ?? '';
        $state = $input['state'] ?? '';
        $city = $input['city'] ?? '';

        $paymentMode = $input['paymentMode'] ?? '';

        $chequeNo = $input['chequeNo'] ?? '';
        $chequeDate = $input['chequeDate'] ?? '';
        $bankName = $input['bankName'] ?? '';
        $transactionNo = $input['transactionNo'] ?? '';

        // ==========================================
        // 4. VALIDATE REQUIRED DETAILS
        // ==========================================

        if ($userId === '') {
            throw new Exception('User ID is required.');
        }

        if ($userType === '') {
            throw new Exception('Register by user type is required.');
        }

        if ($fname === '' || $lname === '') {
            throw new Exception('First name and last name are required.');
        }

        if ($dob === '') {
            throw new Exception('Date of birth is required.');
        }

        // ==========================================
        // 5. FORMAT DATE OF BIRTH AND CALCULATE AGE
        // ==========================================

        $timestamp = strtotime($dob);

        if ($timestamp === false) {
            throw new Exception('Invalid date of birth.');
        }

        $bdate = date('Y-m-d', $timestamp);

        $current_year = (int) date('Y');

        $birth_year = (int) date('Y', $timestamp);

        $age = $current_year - $birth_year;

        // ==========================================
        // 6. SET CONSTANT VALUES
        // ==========================================

        $user_type = '16';

        $register_by = $userType;

        $title = 'Techno Enterprise';

        $fromWhom = $userType;

        $operation = 'Add';

        // ==========================================
        // 7. SET STATUS AND LOG MESSAGES
        // ==========================================

        if ($actionType === 'draft') {

            $status = '4';

            $message = "Techno Enterprise form saved as draft by "
                . $userId . " (" . $registrant . ") from Add Page";

            $message2 = '';

        } else {

            $status = '2';

            $message = "Added new Techno Enterprise. TE name - "
                . $fname . " " . $lname;

            $message2 = 'Added new Techno Enterprise by Super Techno Enterprise';

        }

        // ==========================================
        // 8. START DATABASE TRANSACTION
        // ==========================================

        $conn->beginTransaction();

        // ==========================================
        // 9. INSERT INTO CORPORATE_AGENCY
        // ==========================================

        $sql = "
            INSERT INTO `corporate_agency` (
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
                gst_no,
                amount,
                profile_pic,
                pan_card,
                aadhar_card,
                voting_card,
                bank_passbook,
                payment_proof,
                country,
                state,
                city,
                pincode,
                address,
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
            ) VALUES (
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
                :gst_no,
                :amount,
                :profile_pic,
                :pan_card,
                :aadhar_card,
                :voting_card,
                :bank_passbook,
                :payment_proof,
                :country,
                :state,
                :city,
                :pincode,
                :address,
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

            ':firstname' => $fname,
            ':lastname' => $lname,

            ':nominee_name' => $nominee_name,
            ':nominee_relation' => $nominee_relation,

            ':email' => $email,

            ':country_code' => $country_code,
            ':contact_no' => $phone_no,

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

            ':user_type' => $user_type,

            ':registrant' => $registrant,
            ':reference_no' => $user_id_name,
            ':register_by' => $register_by,

            ':status' => $status

        ]);

        if (!$result) {
            throw new Exception('Failed to add Techno Enterprise.');
        }

        // ==========================================
        // 10. GET LAST INSERTED ID
        // ==========================================

        $last_id = $conn->lastInsertId();

        if (!$last_id) {
            throw new Exception('Unable to retrieve inserted record ID.');
        }

        // ==========================================
        // 11. INSERT INTO LOGS
        // ==========================================

        $sql2 = "
            INSERT INTO logs (
                title,
                message,
                message2,
                reference_no,
                register_by,
                from_whom,
                operation
            ) VALUES (
                :title,
                :message,
                :message2,
                :reference_no,
                :register_by,
                :from_whom,
                :operation
            )
        ";

        $stmt2 = $conn->prepare($sql2);

        $result2 = $stmt2->execute([

            ':title' => $title,
            ':message' => $message,
            ':message2' => $message2,

            ':reference_no' => $userId,
            ':register_by' => $register_by,
            ':from_whom' => $fromWhom,
            ':operation' => $operation

        ]);

        if (!$result2) {
            throw new Exception('Techno Enterprise added but log creation failed.');
        }

        // ==========================================
        // 12. COMMIT TRANSACTION
        // ==========================================

        $conn->commit();

        // ==========================================
        // 13. SUCCESS RESPONSE
        // ==========================================

        $response['success'] = true;

        $response['message'] = ($actionType === 'draft')
            ? 'Techno Enterprise draft saved successfully.'
            : 'Techno Enterprise added successfully.';

        $response['data'] = [
            'id' => $last_id,
            'name' => $fname . ' ' . $lname,
            'reference_no' => $user_id_name,
            'email' => $email,
            'status' => $status,
            'action_type' => $actionType
        ];

    } catch (PDOException $e) {

        // ==========================================
        // 14. DATABASE ERROR
        // ==========================================

        if ($conn->inTransaction()) {
            $conn->rollBack();
        }

        error_log('Techno Enterprise API PDO Error: ' . $e->getMessage());

        $response['message'] = 'Database error occurred.';

    } catch (Exception $e) {

        // ==========================================
        // 15. GENERAL ERROR
        // ==========================================

        if ($conn->inTransaction()) {
            $conn->rollBack();
        }

        $response['message'] = $e->getMessage();

    }

    // ==========================================
    // 16. RETURN JSON RESPONSE
    // ==========================================

    echo json_encode($response);

    exit;

?>