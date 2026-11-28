
<?php

require '../../../../connect.php';

date_default_timezone_set('Asia/Kolkata');

// ==========================================
// HEADERS
// ==========================================

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

// ==========================================
// RESPONSE
// ==========================================

$response = [
    'success' => false,
    'message' => '',
    'data' => null
];

// ==========================================
// REQUEST METHOD
// ==========================================

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);

    echo json_encode([
        'success' => false,
        'message' => 'Only POST method is allowed.',
        'data' => null
    ]);

    exit;
}

// ==========================================
// ACCEPT JSON / FORM DATA
// ==========================================

$rawInput = file_get_contents('php://input');

$input = json_decode($rawInput, true);

if (!is_array($input)) {
    $input = $_POST;
}

if (!is_array($input) || empty($input)) {
    http_response_code(400);

    echo json_encode([
        'success' => false,
        'message' => 'Invalid or empty request data.',
        'data' => null
    ]);

    exit;
}

// ==========================================
// INPUT HELPER
// ==========================================

function getInputValue($input, $key, $default = '')
{
    if (!isset($input[$key])) {
        return $default;
    }

    $value = $input[$key];

    if (is_array($value) || is_object($value)) {
        return $default;
    }

    return trim((string) $value);
}

$current_year = (int) date('Y');

try {

    // ==========================================
    // ADDITIONAL INFORMATION
    // ==========================================

    $userId = getInputValue($input, 'userId');

    $reference_no = $userId;

    $userFname = getInputValue($input, 'userFname');
    $userLname = getInputValue($input, 'userLname');

    $registrant = trim($userFname . ' ' . $userLname);

    // ref_id is used for logs and login updates.
    // If not supplied separately, use userId.
    $ref_id = getInputValue($input, 'ref_id', $userId);

    // ==========================================
    // PERSONAL DETAILS
    // ==========================================

    $designation        = getInputValue($input, 'designation');
    $user_id_name       = getInputValue($input, 'user_id_name');
    $reference_name     = getInputValue($input, 'reference_name');

    $firstname          = getInputValue($input, 'firstname');
    $lastname           = getInputValue($input, 'lastname');

    $father_spouse_name = getInputValue($input, 'father_spouse_name');
    $email              = getInputValue($input, 'email');
    $bdate              = getInputValue($input, 'dob');
    $gender             = getInputValue($input, 'gender');

    $country_code       = getInputValue($input, 'country_code');
    $phone              = getInputValue($input, 'phone');

    $country_code_alt   = getInputValue($input, 'country_code_alt');
    $alt_phone          = getInputValue($input, 'alt_phone');

    $aadhar_no          = getInputValue($input, 'aadhar_no');
    $pan_no             = getInputValue($input, 'pan_no');

    $country            = getInputValue($input, 'country');
    $state              = getInputValue($input, 'state');
    $city               = getInputValue($input, 'city');
    $pincode            = getInputValue($input, 'pincode');
    $address            = getInputValue($input, 'address');

    // ==========================================
    // PROFESSIONAL DETAILS
    // ==========================================

    $current_occupation = getInputValue($input, 'occupation');
    $current_experience = getInputValue($input, 'experience');
    $current_income     = getInputValue($input, 'annual_income');

    $managed_team       = getInputValue($input, 'team_managed');
    $team_description   = getInputValue($input, 'team_size');

    // Leadership JSON may arrive as an array or JSON string.
    $leadershipInput = $input['leadership_json'] ?? [];

    if (is_array($leadershipInput)) {

        $leadership_experience = json_encode(
            $leadershipInput,
            JSON_UNESCAPED_UNICODE
        );

    } elseif (is_string($leadershipInput)) {

        $decodedLeadership = json_decode($leadershipInput, true);

        if (
            json_last_error() === JSON_ERROR_NONE &&
            is_array($decodedLeadership)
        ) {
            $leadership_experience = json_encode(
                $decodedLeadership,
                JSON_UNESCAPED_UNICODE
            );
        } else {
            $leadership_experience = '[]';
        }

    } else {

        $leadership_experience = '[]';
    }

    if ($leadership_experience === false) {
        throw new Exception('Unable to encode leadership details.');
    }

    $leadership_experience_other = getInputValue($input, 'other_lead');
    $educational_qualification   = getInputValue($input, 'qualification');

    // ==========================================
    // LEADERSHIP DETAILS
    // ==========================================

    $career_objective = getInputValue($input, 'career_objective');
    $team_expected    = getInputValue($input, 'team_expected');
    $operating_region = getInputValue($input, 'operating_state');

    // ==========================================
    // NOMINEE DETAILS
    // ==========================================

    $nominee_name          = getInputValue($input, 'nominee_name');
    $nominee_relation      = getInputValue($input, 'nominee_relation');
    $nominee_contact_cd    = getInputValue($input, 'country_cd_nominee');
    $nominee_contact_no    = getInputValue($input, 'nominee_phone');
    $nominee_date_of_birth = getInputValue($input, 'nominee_dob');
    $nominee_address       = getInputValue($input, 'nominee_address');

    // ==========================================
    // BANK DETAILS
    // ==========================================

    $account_holder_name = getInputValue($input, 'acc_holder_name');
    $bank_name           = getInputValue($input, 'bank_name');
    $account_number      = getInputValue($input, 'account_number');
    $ifsc_code           = getInputValue($input, 'ifsc_code');
    $branch_name         = getInputValue($input, 'branch_name');

    // ==========================================
    // DOCUMENT DETAILS
    // ==========================================

    $profile_pic                    = getInputValue($input, 'profile_pic');
    $aadhar_card                    = getInputValue($input, 'aadhar_card');
    $pan_card                       = getInputValue($input, 'pan_card');
    $cancelled_cheque_bank_passbook = getInputValue($input, 'passbook');
    $resume_cv                      = getInputValue($input, 'resume_cv');
    $address_proof                  = getInputValue($input, 'address_proof');
    $professional_profile           = getInputValue($input, 'professional_profile');
    $business_profile               = getInputValue($input, 'business_profile');
    $income_proof                   = getInputValue($input, 'income_proof');
    $other_document                 = getInputValue($input, 'other_document');
    $nominee_profile                = getInputValue($input, 'nominee_profile');

    // ==========================================
    // COMMON DETAILS
    // ==========================================

    $title        = 'Super Techno Enterprise';
    $register_by  = $userId;
    $fromWhom     = $userId;
    $operation    = 'Update';
    $user_type_id = '35';

    // actionType is for registered login update.
    $editfor = getInputValue($input, 'actionType');

    // action_type is for draft / submit.
    $action_type = getInputValue($input, 'action_type');

    // Backward compatibility:
    // If action_type is absent, accept actionType only
    // when its value is draft or submit.
    if (
        $action_type === '' &&
        in_array($editfor, ['draft', 'submit'], true)
    ) {
        $action_type = $editfor;
    }

    // ==========================================
    // APPLICATION ID
    // ==========================================

    $application_id = getInputValue($input, 'application_id');

    if ($application_id === '') {
        throw new Exception('Application ID is required.');
    }

    if ($userId === '') {
        throw new Exception('User ID is required.');
    }

    if ($ref_id === '') {
        throw new Exception('Reference ID is required.');
    }

    // ==========================================
    // ACTION VALIDATION
    // ==========================================

    if (!in_array($action_type, ['draft', 'submit'], true)) {
        throw new Exception('Invalid action_type. Use draft or submit.');
    }

    // ==========================================
    // APPLICATION STATUS
    // ==========================================

    if ($action_type === 'draft') {

        $status = '4';

    } elseif ($action_type === 'submit') {

        $status = '2';
    }

    // ==========================================
    // AGE CALCULATION
    // ==========================================

    $birthYear = $current_year;

    if (!empty($bdate)) {

        $birthTimestamp = strtotime($bdate);

        if ($birthTimestamp === false) {
            throw new Exception('Invalid date of birth.');
        }

        $bdate = date('Y-m-d', $birthTimestamp);

        $birthYear = (int) date('Y', $birthTimestamp);
    }

    $age = $current_year - $birthYear;

    // ==========================================
    // START TRANSACTION
    // ==========================================

    $conn->beginTransaction();

    // ==========================================
    // 1. SUPER TECHNO ENTERPRISE
    // ==========================================

    $stmt1 = $conn->prepare("
        UPDATE super_techno_enterprise SET
            firstname = :firstname,
            lastname = :lastname,
            father_spouse_name = :father_spouse_name,
            email = :email,
            country_code = :country_code,
            contact_no = :contact_no,
            alternative_country_code = :alternative_country_code,
            alternative_contact_no = :alternative_contact_no,
            aadhar_no = :aadhar_no,
            pan_no = :pan_no,
            date_of_birth = :date_of_birth,
            age = :age,
            gender = :gender,
            country = :country,
            state = :state,
            city = :city,
            pincode = :pincode,
            address = :address,
            status = :status
        WHERE application_id = :application_id
    ");

    $stmt1->execute([
        ':firstname'                => $firstname,
        ':lastname'                 => $lastname,
        ':father_spouse_name'       => $father_spouse_name,
        ':email'                    => $email,
        ':country_code'             => $country_code,
        ':contact_no'               => $phone,
        ':alternative_country_code' => $country_code_alt,
        ':alternative_contact_no'   => $alt_phone,
        ':aadhar_no'                => $aadhar_no,
        ':pan_no'                   => $pan_no,
        ':date_of_birth'            => $bdate,
        ':age'                      => $age,
        ':gender'                   => $gender,
        ':country'                  => $country,
        ':state'                    => $state,
        ':city'                     => $city,
        ':pincode'                  => $pincode,
        ':address'                  => $address,
        ':status'                   => $status,
        ':application_id'           => $application_id
    ]);

    // ==========================================
    // 2. PROFESSIONAL AND EDUCATIONAL
    // ==========================================

    $stmt2 = $conn->prepare("
        UPDATE professional_and_educational SET
            current_occupation = :current_occupation,
            current_experience = :current_experience,
            current_income = :current_income,
            managed_team = :managed_team,
            team_description = :team_description,
            leadership_experience = :leadership_experience,
            leadership_experience_other = :leadership_experience_other,
            educational_qualification = :educational_qualification
        WHERE application_id = :application_id
    ");

    $stmt2->execute([
        ':current_occupation'          => $current_occupation,
        ':current_experience'          => $current_experience,
        ':current_income'              => $current_income,
        ':managed_team'                => $managed_team,
        ':team_description'            => $team_description,
        ':leadership_experience'       => $leadership_experience,
        ':leadership_experience_other' => $leadership_experience_other,
        ':educational_qualification'   => $educational_qualification,
        ':application_id'              => $application_id
    ]);

    // ==========================================
    // 3. LEADERSHIP ASSESSMENT
    // ==========================================

    $stmt3 = $conn->prepare("
        UPDATE leadership_assessment SET
            career_objective = :career_objective,
            team_expected = :team_expected,
            operating_region = :operating_region
        WHERE application_id = :application_id
    ");

    $stmt3->execute([
        ':career_objective' => $career_objective,
        ':team_expected'    => $team_expected,
        ':operating_region' => $operating_region,
        ':application_id'   => $application_id
    ]);

    // ==========================================
    // 4. NOMINEE DETAILS
    // ==========================================

    $stmt4 = $conn->prepare("
        UPDATE nominee_details SET
            nominee_name = :nominee_name,
            nominee_relation = :nominee_relation,
            nominee_contact_cd = :nominee_contact_cd,
            nominee_contact_no = :nominee_contact_no,
            nominee_date_of_birth = :nominee_date_of_birth,
            nominee_address = :nominee_address
        WHERE application_id = :application_id
    ");

    $stmt4->execute([
        ':nominee_name'          => $nominee_name,
        ':nominee_relation'      => $nominee_relation,
        ':nominee_contact_cd'    => $nominee_contact_cd,
        ':nominee_contact_no'    => $nominee_contact_no,
        ':nominee_date_of_birth' => $nominee_date_of_birth,
        ':nominee_address'       => $nominee_address,
        ':application_id'        => $application_id
    ]);

    // ==========================================
    // 5. BANK DETAILS
    // ==========================================

    $stmt5 = $conn->prepare("
        UPDATE bank_details SET
            account_holder_name = :account_holder_name,
            bank_name = :bank_name,
            account_number = :account_number,
            ifsc_code = :ifsc_code,
            branch_name = :branch_name
        WHERE application_id = :application_id
    ");

    $stmt5->execute([
        ':account_holder_name' => $account_holder_name,
        ':bank_name'           => $bank_name,
        ':account_number'      => $account_number,
        ':ifsc_code'            => $ifsc_code,
        ':branch_name'          => $branch_name,
        ':application_id'       => $application_id
    ]);

    // ==========================================
    // 6. DOCUMENTS
    // ==========================================

    $stmt6 = $conn->prepare("
        UPDATE documents SET
            profile_pic = :profile_pic,
            aadhar_card = :aadhar_card,
            pan_card = :pan_card,
            cancelled_cheque_bank_passbook = :cancelled_cheque_bank_passbook,
            resume_cv = :resume_cv,
            address_proof = :address_proof,
            professional_profile = :professional_profile,
            business_profile = :business_profile,
            income_proof = :income_proof,
            other_document = :other_document,
            nominee_profile = :nominee_profile
        WHERE application_id = :application_id
    ");

    $stmt6->execute([
        ':profile_pic'                    => $profile_pic,
        ':aadhar_card'                    => $aadhar_card,
        ':pan_card'                       => $pan_card,
        ':cancelled_cheque_bank_passbook' => $cancelled_cheque_bank_passbook,
        ':resume_cv'                      => $resume_cv,
        ':address_proof'                  => $address_proof,
        ':professional_profile'            => $professional_profile,
        ':business_profile'                => $business_profile,
        ':income_proof'                    => $income_proof,
        ':other_document'                  => $other_document,
        ':nominee_profile'                 => $nominee_profile,
        ':application_id'                  => $application_id
    ]);

    // ==========================================
    // 7. LOGS
    // ==========================================

    $message = "Updated Super Techno Enterprise details from pending list";

    $stmt7 = $conn->prepare("
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
    ");

    $stmt7->execute([
        ':title'        => $title,
        ':message'      => $message,
        ':message2'     => $message,
        ':reference_no' => $ref_id,
        ':register_by'  => $register_by,
        ':from_whom'    => $fromWhom,
        ':operation'    => $operation
    ]);

    // ==========================================
    // 8. UPDATE LOGIN IF REGISTERED
    // ==========================================

    if ($editfor === 'registered') {

        $stmt8 = $conn->prepare("
            UPDATE login
            SET username = :email
            WHERE user_id = :user_id
            AND user_type_id = :user_type_id
        ");

        $stmt8->execute([
            ':email'        => $email,
            ':user_id'      => $ref_id,
            ':user_type_id' => $user_type_id
        ]);
    }

    // ==========================================
    // COMMIT TRANSACTION
    // ==========================================

    $conn->commit();

    // ==========================================
    // SUCCESS RESPONSE
    // ==========================================

    $response['success'] = true;

    $response['message'] = ($action_type === 'draft')
        ? 'Super Techno Enterprise draft updated successfully.'
        : 'Super Techno Enterprise application updated successfully.';

    $response['data'] = [
        'application_id' => $application_id,
        'userId'         => $userId,
        'userFname'      => $userFname,
        'userLname'      => $userLname,
        'registrant'     => $registrant,
        'firstname'      => $firstname,
        'lastname'       => $lastname,
        'reference_no'   => $reference_no,
        'status'         => $status,
        'action_type'    => $action_type
    ];

    http_response_code(200);

} catch (Throwable $e) {

    // ==========================================
    // ROLLBACK TRANSACTION
    // ==========================================

    if ($conn->inTransaction()) {
        $conn->rollBack();
    }

    error_log("STE Update Error: " . $e->getMessage());

    $response['success'] = false;
    $response['message'] = 'Failed to update Super Techno Enterprise application.';
    $response['data'] = null;

    http_response_code(500);
}

// ==========================================
// RETURN JSON RESPONSE
// ==========================================

echo json_encode(
    $response,
    JSON_UNESCAPED_UNICODE
);

exit;

?>