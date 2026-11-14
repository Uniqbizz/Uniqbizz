<?php

    /*
    Last updated by SV on 12-11-2026
    Payload example
    {
        "userId":"STE2600002",
        "userFname":"Priyali Damodar",
        "userLname":"Patkar",
        "register_by":"35",
        "action_type": "submit",//draft
        "editfor": "16",
        "id": "31",
        "firstname": "Solomon",
        "lastname": "Wall",
        "email": "dosoxisomu@mailinator.com",
        "dob": "1979-08-03",
        "gender": "others",
        "country_code": "91",
        "phone": "3941236547",
        "business_package": "500000",
        "gst_no": "Quos corrupti archi",
        "paymentMode": "cash",
        "chequeNo": "",
        "chequeDate": "",
        "bankName": "",
        "transactionNo": "",
        "country": "1",
        "state": "6",
        "city": "2",
        "pincode": "403 508",
        "address": "Neque quidem porro e",
        "nominee_name": "Alexander Houston",
        "nominee_relation": "nosefaryd@mailinator.com",
        "profile_pic": "profile_pic/e67eb556-f125-4e24-95ad-8aff21b9926a_1780653882.jpg",
        "aadhar_card": "aadhar/11539820_379403416.png",
        "pan_card": "pancard/11539820_455252501.png",
        "passbook": "passbook/11539820_277509050.png",
        "voting_card": "voting/11539820_1960998451.png",
        "payment_proof": "payment/11539820_2042940759.png"
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

        $response['message'] = 'Only POST method is allowed';

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

        // Keep status as a STRING because your validation uses strict comparison.
        if ($actionType === 'submit') {
            $action_type = '2';
        } elseif ($actionType === 'draft') {
            $action_type = '4';
        } else {
            throw new Exception('Invalid action type.');
        }

        $editfor = trim($input['editfor'] ?? '');
        $identifier_id = trim($input['id'] ?? '');

        $userId = trim($input['userId'] ?? '');
        $userFname = trim($input['userFname'] ?? '');
        $userLname = trim($input['userLname'] ?? '');
        $userType = trim($input['register_by'] ?? '');

        $user_id_name = $userId;
        $registrant = trim($userFname . ' ' . $userLname);

        // ==========================================
        // 4. VALIDATE REQUIRED PARAMETERS
        // ==========================================

        if ($identifier_id === '') {
            throw new Exception('Record ID is required.');
        }

        if ($userId === '') {
            throw new Exception('User ID is required.');
        }

        if ($userType === '') {
            throw new Exception('Register by user type is required.');
        }

        if (!in_array($action_type, ['1', '2', '4'], true)) {
            throw new Exception('Invalid record status.');
        }

        if (!in_array($actionType, ['draft', 'submit'], true)) {
            throw new Exception('Invalid action type.');
        }

        // ==========================================
        // 5. FETCH FORM DETAILS
        // ==========================================

        $fname = trim($input['firstname'] ?? '');
        $lname = trim($input['lastname'] ?? '');

        $nominee_name = $input['nominee_name'] ?? '';
        $nominee_relation = $input['nominee_relation'] ?? '';

        $email = trim($input['email'] ?? '');

        $gender = $input['gender'] ?? '';

        $country_code = ($input['country_code'] ?? '');
        $phone_no = $input['phone'] ?? '';

        $gst_no = $input['gst_no'] ?? '';
        $amount = $input['business_package'] ?? '';

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
        // 6. DATE AND AGE CALCULATION
        // ==========================================

        $bdate = null;
        $age = 0;

        if ($dob !== '') {

            $timestamp = strtotime($dob);

            if ($timestamp === false) {
                throw new Exception('Invalid date of birth.');
            }

            $bdate = date('Y-m-d', $timestamp);

            $age = (new DateTime($bdate))
                ->diff(new DateTime())
                ->y;
        }

        // ==========================================
        // 7. SET USER TYPE AND REGISTER BY
        // ==========================================

        $user_type = '16';

        $register_by = $userType;

        // ==========================================
        // 8. DETERMINE NEW STATUS AND LOG MESSAGE
        // ==========================================

        if ($actionType === 'draft') {

            $status = '4';

            $message = "Techno Enterprise form saved as draft by "
                . $userId . " (" . $registrant . ") from Edit Page";

            $message2 = "Updated Techno Enterprise draft details";

        } else {

            $status = '2';

            $message = "Updated Techno Enterprise details. TE name - "
                . $fname . " " . $lname;

            $message2 = "Updated Techno Enterprise details from pending list";

        }

        // ==========================================
        // 9. DETERMINE IDENTIFIER COLUMN
        // ==========================================

        if ($action_type === '4' || $action_type === '2') {

            // Draft / Pending
            $identifier_field = 'id';

        } elseif ($action_type === '1') {

            // Registered
            $identifier_field = 'corporate_agency_id';

        }

        // ==========================================
        // 10. START DATABASE TRANSACTION
        // ==========================================

        $conn->setAttribute(
            PDO::ATTR_ERRMODE,
            PDO::ERRMODE_EXCEPTION
        );

        $conn->beginTransaction();

        // ==========================================
        // 11. UPDATE CORPORATE AGENCY
        // ==========================================

        $sql = "
            UPDATE corporate_agency SET

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

                status = :status

            WHERE {$identifier_field} = :identifier_id
            LIMIT 1
        ";

        $stmt = $conn->prepare($sql);

        $result = $stmt->execute([

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

            ':identifier_id' => $identifier_id

        ]);

        if (!$result) {
            throw new Exception('Failed to update Techno Enterprise.');
        }

        // ==========================================
        // 12. CHECK WHETHER RECORD EXISTS
        // ==========================================

        if ($stmt->rowCount() === 0) {

            // A zero row count can also mean unchanged values.
            // Verify that the record actually exists.

            $checkSql = "
                SELECT {$identifier_field}
                FROM corporate_agency
                WHERE {$identifier_field} = :identifier_id
                LIMIT 1
            ";

            $checkStmt = $conn->prepare($checkSql);

            $checkStmt->execute([
                ':identifier_id' => $identifier_id
            ]);

            if (!$checkStmt->fetch(PDO::FETCH_ASSOC)) {
                throw new Exception('Techno Enterprise record not found.');
            }
        }

        // ==========================================
        // 13. INSERT INTO LOGS
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

            ':title' => 'Techno Enterprise',

            ':message' => $message,
            ':message2' => $message2,

            ':reference_no' => $userId,
            ':register_by' => $register_by,
            ':from_whom' => $userType,

            ':operation' => 'Update'

        ]);

        if (!$result2) {
            throw new Exception('Failed to create update log.');
        }

        // ==========================================
        // 14. COMMIT TRANSACTION
        // ==========================================

        $conn->commit();

        // ==========================================
        // 15. SUCCESS RESPONSE
        // ==========================================

        $response['success'] = true;

        $response['message'] = 'Techno Enterprise updated successfully.';

        $response['data'] = [
            'id' => $identifier_id,
            'identifier_field' => $identifier_field,
            'previous_status' => $action_type,
            'status' => $status,
            'name' => $fname . ' ' . $lname,
            'reference_no' => $user_id_name,
            'email' => $email
        ];

    } catch (PDOException $e) {

        // ==========================================
        // 16. DATABASE ERROR
        // ==========================================

        if ($conn->inTransaction()) {
            $conn->rollBack();
        }

        error_log('Techno Enterprise Update PDO Error: ' . $e->getMessage());

        $response['message'] = 'Database error occurred.';

    } catch (Exception $e) {

        // ==========================================
        // 17. GENERAL ERROR
        // ==========================================

        if ($conn->inTransaction()) {
            $conn->rollBack();
        }

        $response['message'] = $e->getMessage();

    }

    // ==========================================
    // 18. RETURN JSON RESPONSE
    // ==========================================

    echo json_encode($response);

    exit;

?>
