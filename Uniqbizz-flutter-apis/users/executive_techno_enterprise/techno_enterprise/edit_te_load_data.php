
<?php
include_once(__DIR__ . '/../../../dashboard_user_details.php');

header('Content-Type: application/json; charset=utf-8');

$response = [
    'status' => false,
    'message' => 'Unable to fetch application details.',
    'data' => null
];

try {

    // ==================================================
    // ACCEPT JSON BODY OR NORMAL GET PARAMETERS
    // ==================================================

    $input = [];

    $rawInput = file_get_contents('php://input');

    if (!empty($rawInput)) {
        $decodedInput = json_decode($rawInput, true);

        if (json_last_error() === JSON_ERROR_NONE && is_array($decodedInput)) {
            $input = $decodedInput;
        }
    }

    // GET parameters take priority; JSON is fallback
    $id = $_GET['id'] ?? ($input['id'] ?? '');
    $edittype = $_GET['edittype'] ?? ($input['edittype'] ?? '');

    $id = trim((string)$id);
    $edittype = trim((string)$edittype);

    if ($id === '' || $edittype === '') {
        throw new Exception('Missing id or edittype parameter.');
    }

    // ==================================================
    // TABLE CONFIGURATION
    // ==================================================

    switch ($edittype) {

        case '35':
            $table = 'super_techno_enterprise';
            $customField = 'super_techno_enterprise_id';
            break;

        default:
            throw new Exception('Invalid edit type.');
    }

    // ==================================================
    // FETCH MAIN RECORD
    // ==================================================

    $field = preg_match('/^ST/i', $id)
        ? $customField
        : 'id';

    $stmt = $conn->prepare("
        SELECT *
        FROM {$table}
        WHERE {$field} = ?
        LIMIT 1
    ");

    $stmt->execute([$id]);

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$row) {
        throw new Exception('Record not found.');
    }

    $application_id = $row['application_id'] ?? '';

    if ($application_id === '') {
        throw new Exception('Application ID not found for this record.');
    }

    // ==================================================
    // INITIALIZE OPTIONAL FIELDS
    // ==================================================

    $countryname = '';
    $statename = '';
    $cityname = '';
    $statenameLeader = '';

    $current_occupation = '';
    $current_experience = '';
    $current_income = '';
    $managed_team = '';
    $team_description = '';
    $leadership_experience = '';
    $leadership_experience_other = '';
    $educational_qualification = '';
    $selectedLeadership = [];

    $career_objective = '';
    $team_expected = '';
    $operating_region = '';

    $nominee_name = '';
    $nominee_relation = '';
    $nominee_contact_cd = '';
    $nominee_contact_no = '';
    $nominee_date_of_birth = '';
    $nominee_address = '';

    $account_holder_name = '';
    $bank_name = '';
    $account_number = '';
    $ifsc_code = '';
    $branch_name = '';

    $profile_pic = '';
    $aadhar_card = '';
    $pan_card = '';
    $cancelled_cheque_bank_passbook = '';
    $resume_cv = '';
    $address_proof = '';
    $professional_profile = '';
    $business_profile = '';
    $income_proof = '';
    $other_document = '';
    $nominee_profile = '';

    $payload = [];
    $rejection_reason = '';

    // ==================================================
    // COUNTRY
    // ==================================================

    if (!empty($row['country'])) {

        $countryStmt = $conn->prepare("
            SELECT country_name
            FROM countries
            WHERE id = ?
            AND status = '1'
            LIMIT 1
        ");

        $countryStmt->execute([$row['country']]);

        $country = $countryStmt->fetch(PDO::FETCH_ASSOC);

        $countryname = $country['country_name'] ?? '';
    }

    // ==================================================
    // STATE
    // ==================================================

    if (!empty($row['state'])) {

        $stateStmt = $conn->prepare("
            SELECT state_name
            FROM states
            WHERE id = ?
            AND status = '1'
            LIMIT 1
        ");

        $stateStmt->execute([$row['state']]);

        $state = $stateStmt->fetch(PDO::FETCH_ASSOC);

        $statename = $state['state_name'] ?? '';
    }

    // ==================================================
    // CITY
    // ==================================================

    if (!empty($row['city'])) {

        $cityStmt = $conn->prepare("
            SELECT city_name
            FROM cities
            WHERE id = ?
            AND status = '1'
            LIMIT 1
        ");

        $cityStmt->execute([$row['city']]);

        $city = $cityStmt->fetch(PDO::FETCH_ASSOC);

        $cityname = $city['city_name'] ?? '';
    }

    // ==================================================
    // PROFESSIONAL AND EDUCATIONAL
    // ==================================================

    $stmt2 = $conn->prepare("
        SELECT *
        FROM professional_and_educational
        WHERE application_id = :application_id
        LIMIT 1
    ");

    $stmt2->execute([
        ':application_id' => $application_id
    ]);

    $row2 = $stmt2->fetch(PDO::FETCH_ASSOC);

    if ($row2) {

        $current_occupation = $row2['current_occupation'] ?? '';
        $current_experience = $row2['current_experience'] ?? '';
        $current_income = $row2['current_income'] ?? '';
        $managed_team = $row2['managed_team'] ?? '';
        $team_description = $row2['team_description'] ?? '';
        $leadership_experience = $row2['leadership_experience'] ?? '';
        $leadership_experience_other = $row2['leadership_experience_other'] ?? '';
        $educational_qualification = $row2['educational_qualification'] ?? '';
    }

    $selectedLeadership = json_decode($leadership_experience, true);

    if (!is_array($selectedLeadership)) {
        $selectedLeadership = [];
    }

    // ==================================================
    // LEADERSHIP ASSESSMENT
    // ==================================================

    $stmt3 = $conn->prepare("
        SELECT *
        FROM leadership_assessment
        WHERE application_id = :application_id
        LIMIT 1
    ");

    $stmt3->execute([
        ':application_id' => $application_id
    ]);

    $row3 = $stmt3->fetch(PDO::FETCH_ASSOC);

    if ($row3) {

        $career_objective = $row3['career_objective'] ?? '';
        $team_expected = $row3['team_expected'] ?? '';
        $operating_region = $row3['operating_region'] ?? '';

        if (!empty($operating_region)) {

            $statesLeader = $conn->prepare("
                SELECT state_name
                FROM states
                WHERE id = ?
                AND status = '1'
                LIMIT 1
            ");

            $statesLeader->execute([$operating_region]);

            $leaderState = $statesLeader->fetch(PDO::FETCH_ASSOC);

            $statenameLeader = $leaderState['state_name'] ?? '';
        }
    }

    // ==================================================
    // NOMINEE DETAILS
    // ==================================================

    $stmt4 = $conn->prepare("
        SELECT *
        FROM nominee_details
        WHERE application_id = :application_id
        LIMIT 1
    ");

    $stmt4->execute([
        ':application_id' => $application_id
    ]);

    $row4 = $stmt4->fetch(PDO::FETCH_ASSOC);

    if ($row4) {

        $nominee_name = $row4['nominee_name'] ?? '';
        $nominee_relation = $row4['nominee_relation'] ?? '';
        $nominee_contact_cd = $row4['nominee_contact_cd'] ?? '';
        $nominee_contact_no = $row4['nominee_contact_no'] ?? '';
        $nominee_date_of_birth = $row4['nominee_date_of_birth'] ?? '';
        $nominee_address = $row4['nominee_address'] ?? '';
    }

    // ==================================================
    // BANK DETAILS
    // ==================================================

    $stmt5 = $conn->prepare("
        SELECT *
        FROM bank_details
        WHERE application_id = :application_id
        LIMIT 1
    ");

    $stmt5->execute([
        ':application_id' => $application_id
    ]);

    $row5 = $stmt5->fetch(PDO::FETCH_ASSOC);

    if ($row5) {

        $account_holder_name = $row5['account_holder_name'] ?? '';
        $bank_name = $row5['bank_name'] ?? '';
        $account_number = $row5['account_number'] ?? '';
        $ifsc_code = $row5['ifsc_code'] ?? '';
        $branch_name = $row5['branch_name'] ?? '';
    }

    // ==================================================
    // DOCUMENTS
    // ==================================================

    $stmt6 = $conn->prepare("
        SELECT *
        FROM documents
        WHERE application_id = :application_id
        LIMIT 1
    ");

    $stmt6->execute([
        ':application_id' => $application_id
    ]);

    $row6 = $stmt6->fetch(PDO::FETCH_ASSOC);

    if ($row6) {

        $profile_pic = $row6['profile_pic'] ?? '';
        $aadhar_card = $row6['aadhar_card'] ?? '';
        $pan_card = $row6['pan_card'] ?? '';
        $cancelled_cheque_bank_passbook = $row6['cancelled_cheque_bank_passbook'] ?? '';
        $resume_cv = $row6['resume_cv'] ?? '';
        $address_proof = $row6['address_proof'] ?? '';
        $professional_profile = $row6['professional_profile'] ?? '';
        $business_profile = $row6['business_profile'] ?? '';
        $income_proof = $row6['income_proof'] ?? '';
        $other_document = $row6['other_document'] ?? '';
        $nominee_profile = $row6['nominee_profile'] ?? '';
    }

    // ==================================================
    // USER VERIFICATION
    // ==================================================

    $stmt7 = $conn->prepare("
        SELECT *
        FROM user_verification
        WHERE application_id = :application_id
        LIMIT 1
    ");

    $stmt7->execute([
        ':application_id' => $application_id
    ]);

    $row7 = $stmt7->fetch(PDO::FETCH_ASSOC);

    if ($row7) {

        $verificationPayload = $row7['payload'] ?? '';

        $decodedPayload = json_decode($verificationPayload, true);

        $payload = json_last_error() === JSON_ERROR_NONE
            ? $decodedPayload
            : $verificationPayload;

        $rejection_reason = $row7['rejection_reason'] ?? '';
    }

    // ==================================================
    // FINAL JSON RESPONSE
    // ==================================================

    $response = [
        'status' => true,
        'message' => 'Application details fetched successfully.',
        'data' => [

            // Main Table
            'id' => $row['id'] ?? '',
            'application_id' => $row['application_id'] ?? '',
            'super_techno_enterprise_id' => $row['super_techno_enterprise_id'] ?? '',
            'firstname' => $row['firstname'] ?? '',
            'lastname' => $row['lastname'] ?? '',
            'father_spouse_name' => $row['father_spouse_name'] ?? '',
            'email' => $row['email'] ?? '',
            'contact_no' => $row['contact_no'] ?? '',
            'reference_no' => $row['reference_no'] ?? '',
            'registrant' => $row['registrant'] ?? '',
            'gst_no' => $row['gst_no'] ?? '',
            'date_of_birth' => $row['date_of_birth'] ?? '',
            'gender' => $row['gender'] ?? '',
            'country' => $row['country'] ?? '',
            'country_name' => $countryname,
            'state' => $row['state'] ?? '',
            'state_name' => $statename,
            'city' => $row['city'] ?? '',
            'city_name' => $cityname,
            'address' => $row['address'] ?? '',
            'pincode' => $row['pincode'] ?? '',
            'alternative_contact_no' => $row['alternative_contact_no'] ?? '',
            'alternative_country_code' => $row['alternative_country_code'] ?? '',
            'aadhar_no' => $row['aadhar_no'] ?? '',
            'pan_no' => $row['pan_no'] ?? '',

            // Professional & Educational
            'current_occupation' => $current_occupation,
            'current_experience' => $current_experience,
            'current_income' => $current_income,
            'managed_team' => $managed_team,
            'team_description' => $team_description,
            'leadership_experience' => $selectedLeadership,
            'leadership_experience_other' => $leadership_experience_other,
            'educational_qualification' => $educational_qualification,

            // Leadership Assessment
            'career_objective' => $career_objective,
            'team_expected' => $team_expected,
            'operating_region' => $operating_region,
            'operating_region_name' => $statenameLeader,

            // Nominee
            'nominee_name' => $nominee_name,
            'nominee_relation' => $nominee_relation,
            'nominee_contact_cd' => $nominee_contact_cd,
            'nominee_contact_no' => $nominee_contact_no,
            'nominee_date_of_birth' => $nominee_date_of_birth,
            'nominee_address' => $nominee_address,

            // Bank
            'account_holder_name' => $account_holder_name,
            'bank_name' => $bank_name,
            'account_number' => $account_number,
            'ifsc_code' => $ifsc_code,
            'branch_name' => $branch_name,

            // Documents
            'profile_pic' => $profile_pic,
            'aadhar_card' => $aadhar_card,
            'pan_card' => $pan_card,
            'cancelled_cheque_bank_passbook' => $cancelled_cheque_bank_passbook,
            'resume_cv' => $resume_cv,
            'address_proof' => $address_proof,
            'professional_profile' => $professional_profile,
            'business_profile' => $business_profile,
            'income_proof' => $income_proof,
            'other_document' => $other_document,
            'nominee_profile' => $nominee_profile,

            // Verification
            'payload' => $payload,
            'rejection_reason' => $rejection_reason
        ]
    ];

    echo json_encode($response, JSON_UNESCAPED_UNICODE | JSON_INVALID_UTF8_SUBSTITUTE);
    exit;

} catch (Throwable $e) {

    error_log('STE Edit API Error: ' . $e->getMessage());

    http_response_code(400);

    echo json_encode([
        'status' => false,
        'message' => $e->getMessage(),
        'data' => null
    ], JSON_UNESCAPED_UNICODE | JSON_INVALID_UTF8_SUBSTITUTE);

    exit;
}