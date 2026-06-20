<?php
    include_once(__DIR__ . '/../../../dashboard_user_details.php');

    header('Content-Type: application/json');

    $id = $_GET['id'] ?? '';
    $edittype = $_GET['edittype'] ?? '';

    if (empty($id) || empty($edittype)) {
        echo json_encode([
            'status' => false,
            'message' => 'Missing parameters'
        ]);
        exit;
    }

    switch ($edittype) {

        case '35':
            $table = 'super_techno_enterprise';
            $customField = 'super_techno_enterprise_id';
            break;


        default:
            echo json_encode([
                'status' => false,
                'message' => 'Invalid edit type'
            ]);
            exit;
    }

    $field = preg_match('/^(ST)/i', $id)
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
        echo json_encode([
            'status' => false,
            'message' => 'Record not found'
        ]);
        exit;
    }else{
        $application_id =$row['application_id'];
    }

    /* Country */
    $countryname = '';
    if (!empty($row['country'])) {
        $countryStmt = $conn->prepare("
            SELECT country_name
            FROM countries
            WHERE id = ?
            AND status = '1'
        ");
        $countryStmt->execute([$row['country']]);

        if ($country = $countryStmt->fetch(PDO::FETCH_ASSOC)) {
            $countryname = $country['country_name'];
        }
    }

    /* State */
    $statename = '';
    if (!empty($row['state'])) {
        $stateStmt = $conn->prepare("
            SELECT state_name
            FROM states
            WHERE id = ?
            AND status = '1'
        ");
        $stateStmt->execute([$row['state']]);

        if ($state = $stateStmt->fetch(PDO::FETCH_ASSOC)) {
            $statename = $state['state_name'];
        }
    }

    /* City */
    $cityname = '';
    if (!empty($row['city'])) {
        $cityStmt = $conn->prepare("
            SELECT city_name
            FROM cities
            WHERE id = ?
            AND status = '1'
        ");
        $cityStmt->execute([$row['city']]);

        if ($city = $cityStmt->fetch(PDO::FETCH_ASSOC)) {
            $cityname = $city['city_name'];
        }
    }
    
    // professional_and_educational
    $stmt2 = $conn->prepare("SELECT * FROM `professional_and_educational` WHERE application_id= :application_id");
    $stmt2->execute([':application_id' => $application_id]);
    $stmt2->setFetchMode(PDO::FETCH_ASSOC);

    if ($stmt2->rowCount() > 0) {
        foreach (($stmt2->fetchAll()) as $row2) {
            $current_occupation = $row2['current_occupation'];
            $current_experience = $row2['current_experience'];
            $current_income = $row2['current_income'];
            $managed_team = $row2['managed_team'];
            $team_description = $row2['team_description'];
            $leadership_experience = $row2['leadership_experience'];
            $leadership_experience_other = $row2['leadership_experience_other'];
            $educational_qualification = $row2['educational_qualification'];
        }
    }
    $selectedLeadership = json_decode($leadership_experience, true);
            
    // leadership_assessment
    $stmt3 = $conn->prepare("SELECT * FROM `leadership_assessment` WHERE application_id= :application_id");
    $stmt3->execute([':application_id' => $application_id]);
    $stmt3->setFetchMode(PDO::FETCH_ASSOC);

    if ($stmt3->rowCount() > 0) {
        foreach (($stmt3->fetchAll()) as $row3) {
            $career_objective = $row3['career_objective'];
            $team_expected = $row3['team_expected'];
            $operating_region = $row3['operating_region'];

            // Get state name
            $statesLeader = $conn->prepare("SELECT state_name FROM states WHERE id='$operating_region' AND status='1'");
            $statesLeader->execute();
            if ($statesLeader->rowCount() > 0) {
                $statenameLeader = $statesLeader->fetch()['state_name'];
            }
        }
    }

    // nominee_details
    $stmt4 = $conn->prepare("SELECT * FROM `nominee_details` WHERE application_id= :application_id");
    $stmt4->execute([':application_id' => $application_id]);
    $stmt4->setFetchMode(PDO::FETCH_ASSOC);

    if ($stmt4->rowCount() > 0) {
        foreach (($stmt4->fetchAll()) as $row4) {
            $nominee_name = $row4['nominee_name'];
            $nominee_relation = $row4['nominee_relation'];
            $nominee_contact_cd = $row4['nominee_contact_cd'];
            $nominee_contact_no = $row4['nominee_contact_no'];
            $nominee_date_of_birth = $row4['nominee_date_of_birth'];
            $nominee_address = $row4['nominee_address'];
        }
    }

    // bank_details
    $stmt5 = $conn->prepare("SELECT * FROM `bank_details` WHERE application_id= :application_id");
    $stmt5->execute([':application_id' => $application_id]);
    $stmt5->setFetchMode(PDO::FETCH_ASSOC);

    if ($stmt5->rowCount() > 0) {
        foreach (($stmt5->fetchAll()) as $row5) {
            $account_holder_name = $row5['account_holder_name'];
            $bank_name = $row5['bank_name'];
            $account_number = $row5['account_number'];
            $ifsc_code = $row5['ifsc_code'];
            $branch_name = $row5['branch_name'];
        }
    }

    // documents
    $stmt4 = $conn->prepare("SELECT * FROM `documents` WHERE application_id= :application_id");
    $stmt4->execute([':application_id' => $application_id]);
    $stmt4->setFetchMode(PDO::FETCH_ASSOC);

    if ($stmt4->rowCount() > 0) {
        foreach (($stmt4->fetchAll()) as $row4) {
            $profile_pic = $row4['profile_pic'];
            $aadhar_card = $row4['aadhar_card'];
            $pan_card = $row4['pan_card'];
            $cancelled_cheque_bank_passbook = $row4['cancelled_cheque_bank_passbook'];
            $resume_cv = $row4['resume_cv'];
            $address_proof = $row4['address_proof'];
            $professional_profile = $row4['professional_profile'];
            $business_profile = $row4['business_profile'];
            $income_proof = $row4['income_proof'];
            $other_document = $row4['other_document'];
            $nominee_profile = $row4['nominee_profile'];
        }
    }

    $response = [
        'status' => true,
        'data' => [

            // Main Table
            'id' => $row['id'],
            'application_id' => $row['application_id'] ?? '',
            'super_techno_enterprise_id' => $row['super_techno_enterprise_id'] ?? '',
            'firstname' => $row['firstname'],
            'lastname' => $row['lastname'],
            'father_spouse_name' => $row['father_spouse_name'],
            'email' => $row['email'],
            'contact_no' => $row['contact_no'],
            'reference_no' => $row['reference_no'],
            'registrant' => $row['registrant'],
            'gst_no' => $row['gst_no'],
            'date_of_birth' => $row['date_of_birth'],
            'gender' => $row['gender'],
            'country' => $row['country'],
            'country_name' => $countryname,
            'state' => $row['state'],
            'state_name' => $statename,
            'city' => $row['city'],
            'city_name' => $cityname,
            'address' => $row['address'],
            'pincode' => $row['pincode'],
            'alternative_contact_no' => $row['alternative_contact_no'],
            'alternative_country_code' => $row['alternative_country_code'],
            'aadhar_no' => $row['aadhar_no'],
            'pan_no' => $row['pan_no'],

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
            'nominee_profile' => $nominee_profile
        ]
    ];

    echo json_encode($response);
    exit;