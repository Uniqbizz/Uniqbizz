<?php

require '../../../../connect.php';

date_default_timezone_set('Asia/Kolkata');

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

// ==========================================
// RESPONSE STRUCTURE
// ==========================================

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

    // Logged-in user details from session
    $userId=$reference_no = trim($input['userId'] ?? '');
    $userFname  = trim($input['userFname'] ?? '');
    $userLname  = trim($input['userLname'] ?? '');
    $registrant = trim($userFname . ' ' . $userLname);
    // Personal Details
    $firstname          = trim($input['firstname'] ?? '');
    $lastname           = trim($input['lastname'] ?? '');
    $father_spouse_name = $input['father_spouse_name'] ?? '';
    $email              = trim($input['email'] ?? '');
    $bdate              = trim($input['dob'] ?? '');
    $gender             = $input['gender'] ?? '';

    $country_code       = $input['country_code'] ?? '';
    $phone              = $input['phone'] ?? '';

    $country_code_alt   = $input['country_code_alt'] ?? '';
    $alt_phone          = $input['alt_phone'] ?? '';

    $aadhar_no          = $input['aadhar_no'] ?? '';
    $pan_no             = $input['pan_no'] ?? '';

    $country            = $input['country'] ?? '';
    $state              = $input['state'] ?? '';
    $city               = $input['city'] ?? '';
    $pincode            = $input['pincode'] ?? '';
    $address            = $input['address'] ?? '';

    // Professional and Educational Details
    $current_occupation          = $input['occupation'] ?? '';
    $current_experience          = $input['experience'] ?? '';
    $current_income              = $input['annual_income'] ?? '';
    $managed_team                = $input['team_managed'] ?? '';
    $team_description            = $input['team_size'] ?? '';
    $leadershipInput = $input['leadership_json'] ?? [];

    if (is_array($leadershipInput)) {

        $leadership_experience = json_encode(
            $leadershipInput,
            JSON_UNESCAPED_UNICODE
        );

    } elseif (is_string($leadershipInput)) {

        $decodedLeadership = json_decode($leadershipInput, true);

        $leadership_experience = (
            json_last_error() === JSON_ERROR_NONE &&
            is_array($decodedLeadership)
        )
            ? json_encode($decodedLeadership, JSON_UNESCAPED_UNICODE)
            : '[]';

    } else {

        $leadership_experience = '[]';
    }
    $leadership_experience_other = $input['other_lead'] ?? '';
    $educational_qualification   = $input['qualification'] ?? '';

    // Leadership Assessment
    $career_objective = $input['career_objective'] ?? '';
    $team_expected    = $input['team_expected'] ?? '';
    $operating_region = $input['operating_state'] ?? '0';

    // Nominee Details
    $nominee_name          = $input['nominee_name'] ?? '';
    $nominee_relation      = $input['nominee_relation'] ?? '';
    $nominee_contact_cd    = $input['country_cd_nominee'] ?? '';
    $nominee_contact_no    = $input['nominee_phone'] ?? '';
    $nominee_date_of_birth = $input['nominee_dob'] ?? '';
    $nominee_address       = $input['nominee_address'] ?? '';

    // Bank Details
    $account_holder_name = $input['acc_holder_name'] ?? '';
    $bank_name           = $input['bank_name'] ?? '';
    $account_number      = $input['account_number'] ?? '';
    $ifsc_code           = $input['ifsc_code'] ?? '';
    $branch_name         = $input['branch_name'] ?? '';

    // Documents
    $profile_pic                    = $input['profile_pic'] ?? '';
    $aadhar_card                    = $input['aadhar_card'] ?? '';
    $pan_card                       = $input['pan_card'] ?? '';
    $cancelled_cheque_bank_passbook = $input['passbook'] ?? '';
    $resume_cv                      = $input['resume_cv'] ?? '';
    $address_proof                  = $input['address_proof'] ?? '';
    $professional_profile           = $input['professional_profile'] ?? '';
    $business_profile               = $input['business_profile'] ?? '';
    $income_proof                   = $input['income_proof'] ?? '';
    $other_document                 = $input['other_document'] ?? '';
    $nominee_profile                = $input['nominee_profile'] ?? '';

    // Action
    $action_type = trim($input['action_type'] ?? '');

    // ==========================================
    // 4. VALIDATE REQUIRED DETAILS
    // ==========================================

    if (empty($userId)) {
        throw new Exception('Logged-in user details not found.');
    }

    if ($firstname === '' || $lastname === '') {
        throw new Exception('First name and last name are required.');
    }

    if ($bdate === '') {
        throw new Exception('Date of birth is required.');
    }

    if (!in_array($action_type, ['draft', 'submit'], true)) {
        throw new Exception('Invalid action type.');
    }

    // ==========================================
    // 5. FORMAT DOB AND CALCULATE AGE
    // ==========================================

    $timestamp = strtotime($bdate);

    if ($timestamp === false) {
        throw new Exception('Invalid date of birth.');
    }

    $bdate = date('Y-m-d', $timestamp);

    $current_year = (int) date('Y');
    $birth_year   = (int) date('Y', $timestamp);

    $age = $current_year - $birth_year;

    // ==========================================
    // 6. SET CONSTANT VALUES
    // ==========================================

    $user_type  = '35';
    $register_by = $userId;

    $title    = 'Super Techno Enterprise';
    $fromWhom = $userId;
    $operation = 'Add';

    // ==========================================
    // 7. SET STATUS AND LOG MESSAGES
    // ==========================================

    if ($action_type === 'draft') {

        $status = '4';

        $message = 'Super Techno Enterprise application saved as draft by '
            . $reference_no . ' (' . $registrant . ')';

        $message2 = '';

    } else {

        $status = '2';

        $message = 'Added new Super Techno Enterprise. STE name - '
            . $firstname . ' ' . $lastname;

        $message2 = 'Added new Super Techno Enterprise by admin';

    }

    // ==========================================
    // 8. GENERATE APPLICATION ID
    // ==========================================

    function getApplication()
    {
        return 'STEAPP' . strtoupper(bin2hex(random_bytes(4)));
    }

    $application_id = getApplication();

    // ==========================================
    // 9. START DATABASE TRANSACTION
    // ==========================================

    $conn->beginTransaction();

    // ==========================================
    // 10. INSERT INTO SUPER TECHNO ENTERPRISE
    // ==========================================

    $sql1 = "
        INSERT INTO super_techno_enterprise (

            application_id,
            firstname,
            lastname,
            father_spouse_name,
            email,
            country_code,
            contact_no,
            alternative_country_code,
            alternative_contact_no,
            aadhar_no,
            pan_no,
            date_of_birth,
            age,
            gender,
            country,
            state,
            city,
            pincode,
            address,
            user_type,
            registrant,
            reference_no,
            register_by,
            status

        ) VALUES (

            :application_id,
            :firstname,
            :lastname,
            :father_spouse_name,
            :email,
            :country_code,
            :contact_no,
            :alternative_country_code,
            :alternative_contact_no,
            :aadhar_no,
            :pan_no,
            :bdate,
            :age,
            :gender,
            :country,
            :state,
            :city,
            :pincode,
            :address,
            :user_type,
            :registrant,
            :reference_no,
            :register_by,
            :status

        )
    ";

    $stmt1 = $conn->prepare($sql1);

    $result1 = $stmt1->execute([

        ':application_id' => $application_id,
        ':firstname' => $firstname,
        ':lastname' => $lastname,
        ':father_spouse_name' => $father_spouse_name,
        ':email' => $email,
        ':country_code' => $country_code,
        ':contact_no' => $phone,
        ':alternative_country_code' => $country_code_alt,
        ':alternative_contact_no' => $alt_phone,
        ':aadhar_no' => $aadhar_no,
        ':pan_no' => $pan_no,
        ':bdate' => $bdate,
        ':age' => $age,
        ':gender' => $gender,
        ':country' => $country,
        ':state' => $state,
        ':city' => $city,
        ':pincode' => $pincode,
        ':address' => $address,
        ':user_type' => $user_type,
        ':registrant' => $registrant,
        ':reference_no' => $reference_no,
        ':register_by' => $register_by,
        ':status' => $status

    ]);

    if (!$result1) {
        throw new Exception('Failed to insert Super Techno Enterprise details.');
    }

    // ==========================================
    // 11. INSERT INTO PROFESSIONAL AND EDUCATIONAL
    // ==========================================

    $sql2 = "
        INSERT INTO professional_and_educational (

            application_id,
            current_occupation,
            current_experience,
            current_income,
            managed_team,
            team_description,
            leadership_experience,
            leadership_experience_other,
            educational_qualification

        ) VALUES (

            :application_id,
            :current_occupation,
            :current_experience,
            :current_income,
            :managed_team,
            :team_description,
            :leadership_experience,
            :leadership_experience_other,
            :educational_qualification

        )
    ";

    $stmt2 = $conn->prepare($sql2);

    $result2 = $stmt2->execute([

        ':application_id' => $application_id,
        ':current_occupation' => $current_occupation,
        ':current_experience' => $current_experience,
        ':current_income' => $current_income,
        ':managed_team' => $managed_team,
        ':team_description' => $team_description,
        ':leadership_experience' => $leadership_experience,
        ':leadership_experience_other' => $leadership_experience_other,
        ':educational_qualification' => $educational_qualification

    ]);

    if (!$result2) {
        throw new Exception('Failed to insert professional and educational details.');
    }

    // ==========================================
    // 12. INSERT INTO LEADERSHIP ASSESSMENT
    // ==========================================

    $sql3 = "
        INSERT INTO leadership_assessment (

            application_id,
            career_objective,
            team_expected,
            operating_region

        ) VALUES (

            :application_id,
            :career_objective,
            :team_expected,
            :operating_region

        )
    ";

    $stmt3 = $conn->prepare($sql3);

    $result3 = $stmt3->execute([

        ':application_id' => $application_id,
        ':career_objective' => $career_objective,
        ':team_expected' => $team_expected,
        ':operating_region' => $operating_region

    ]);

    if (!$result3) {
        throw new Exception('Failed to insert leadership assessment.');
    }

    // ==========================================
    // 13. INSERT INTO NOMINEE DETAILS
    // ==========================================

    $sql4 = "
        INSERT INTO nominee_details (

            application_id,
            nominee_name,
            nominee_relation,
            nominee_contact_cd,
            nominee_contact_no,
            nominee_date_of_birth,
            nominee_address

        ) VALUES (

            :application_id,
            :nominee_name,
            :nominee_relation,
            :nominee_contact_cd,
            :nominee_contact_no,
            :nominee_date_of_birth,
            :nominee_address

        )
    ";

    $stmt4 = $conn->prepare($sql4);

    $result4 = $stmt4->execute([

        ':application_id' => $application_id,
        ':nominee_name' => $nominee_name,
        ':nominee_relation' => $nominee_relation,
        ':nominee_contact_cd' => $nominee_contact_cd,
        ':nominee_contact_no' => $nominee_contact_no,
        ':nominee_date_of_birth' => $nominee_date_of_birth,
        ':nominee_address' => $nominee_address

    ]);

    if (!$result4) {
        throw new Exception('Failed to insert nominee details.');
    }

    // ==========================================
    // 14. INSERT INTO BANK DETAILS
    // ==========================================

    $sql5 = "
        INSERT INTO bank_details (

            application_id,
            account_holder_name,
            bank_name,
            account_number,
            ifsc_code,
            branch_name

        ) VALUES (

            :application_id,
            :account_holder_name,
            :bank_name,
            :account_number,
            :ifsc_code,
            :branch_name

        )
    ";

    $stmt5 = $conn->prepare($sql5);

    $result5 = $stmt5->execute([

        ':application_id' => $application_id,
        ':account_holder_name' => $account_holder_name,
        ':bank_name' => $bank_name,
        ':account_number' => $account_number,
        ':ifsc_code' => $ifsc_code,
        ':branch_name' => $branch_name

    ]);

    if (!$result5) {
        throw new Exception('Failed to insert bank details.');
    }

    // ==========================================
    // 15. INSERT INTO DOCUMENTS
    // ==========================================

    $sql6 = "
        INSERT INTO documents (

            application_id,
            profile_pic,
            aadhar_card,
            pan_card,
            cancelled_cheque_bank_passbook,
            resume_cv,
            address_proof,
            professional_profile,
            business_profile,
            income_proof,
            other_document,
            nominee_profile

        ) VALUES (

            :application_id,
            :profile_pic,
            :aadhar_card,
            :pan_card,
            :cancelled_cheque_bank_passbook,
            :resume_cv,
            :address_proof,
            :professional_profile,
            :business_profile,
            :income_proof,
            :other_document,
            :nominee_profile

        )
    ";

    $stmt6 = $conn->prepare($sql6);

    $result6 = $stmt6->execute([

        ':application_id' => $application_id,
        ':profile_pic' => $profile_pic,
        ':aadhar_card' => $aadhar_card,
        ':pan_card' => $pan_card,
        ':cancelled_cheque_bank_passbook' => $cancelled_cheque_bank_passbook,
        ':resume_cv' => $resume_cv,
        ':address_proof' => $address_proof,
        ':professional_profile' => $professional_profile,
        ':business_profile' => $business_profile,
        ':income_proof' => $income_proof,
        ':other_document' => $other_document,
        ':nominee_profile' => $nominee_profile

    ]);

    if (!$result6) {
        throw new Exception('Failed to insert document details.');
    }

    // ==========================================
    // 16. INSERT INTO LOGS
    // ==========================================

    $sql7 = "
        INSERT INTO logs (

            title,
            message,
            message2,
            register_by,
            from_whom,
            operation

        ) VALUES (

            :title,
            :message,
            :message2,
            :register_by,
            :from_whom,
            :operation

        )
    ";

    $stmt7 = $conn->prepare($sql7);

    $result7 = $stmt7->execute([

        ':title' => $title,
        ':message' => $message,
        ':message2' => $message2,
        ':register_by' => $register_by,
        ':from_whom' => $fromWhom,
        ':operation' => $operation

    ]);

    if (!$result7) {
        throw new Exception('Failed to insert log details.');
    }

    // ==========================================
    // 17. COMMIT TRANSACTION
    // ==========================================

    $conn->commit();

    // ==========================================
    // 18. SUCCESS RESPONSE
    // ==========================================

    $response['success'] = true;

    $response['message'] = ($action_type === 'draft')
        ? 'Super Techno Enterprise draft saved successfully.'
        : 'Super Techno Enterprise application submitted successfully.';

    $response['data'] = [

        'application_id' => $application_id,
        'firstname' => $firstname,
        'lastname' => $lastname,
        'reference_no' => $reference_no,
        'status' => $status,
        'action_type' => $action_type

    ];

    http_response_code(200);

} catch (PDOException $e) {

    // ==========================================
    // 19. DATABASE ERROR
    // ==========================================

    if ($conn->inTransaction()) {
        $conn->rollBack();
    }

    error_log('Super Techno Enterprise PDO Error: ' . $e->getMessage());

    $response['success'] = false;
    $response['message'] = 'Database error occurred.';

    http_response_code(500);

} catch (Exception $e) {

    // ==========================================
    // 20. GENERAL ERROR
    // ==========================================

    if ($conn->inTransaction()) {
        $conn->rollBack();
    }

    error_log('Super Techno Enterprise Error: ' . $e->getMessage());

    $response['success'] = false;
    $response['message'] = $e->getMessage();

    http_response_code(400);

}

// ==========================================
// 21. RETURN JSON RESPONSE
// ==========================================

echo json_encode($response);
exit;

?>