<?php
require "../connect.php";
date_default_timezone_set('Asia/Kolkata');

$current_year = date('Y');

// additional information to check if user is registered or not
$ref_id = $_POST["ref_id"]; // reference of the user - ETE260003
$editfor = $_POST["editfor"]; // pending or confirm
$identifier_id = $_POST["id"]; // ChiefTE id value if user is not confirmed - 11 , if confirmed - STE2600011
$application_id_no = $_POST["application_id"]; // application_id

// Personal Details
$verification_status  = $_POST['verification_status'] ?? '';
$reject_reason        = $_POST['reject_reason'] ?? '';
$actionType           = $_POST['action_type'] ?? ''; // submit OR draft
$designation          = $_POST['designation'] ?? '';
$user_id_name         = $_POST['user_id_name'] ?? '';
$reference_name       = $_POST['reference_name'] ?? '';
$firstname            = $_POST['firstname'] ?? '';
$lastname             = $_POST['lastname'] ?? '';
$father_spouse_name   = $_POST['father_spouse_name'] ?? '';
$email                = $_POST['email'] ?? '';
$bdate                = $_POST['dob'] ?? '';
$gender               = $_POST['gender'] ?? '';
$country_code         = $_POST['country_code'] ?? '';
$phone                = $_POST['phone'] ?? '';
$country_code_alt     = $_POST['country_code_alt'] ?? '';
$alt_phone            = $_POST['alt_phone'] ?? '';
$aadhar_no            = $_POST['aadhar_no'] ?? '';
$pan_no               = $_POST['pan_no'] ?? '';
$country              = $_POST['country'] ?? '';
$state                = $_POST['state'] ?? '';
$city                 = $_POST['city'] ?? '';
$pincode              = $_POST['pincode'] ?? '';
$address              = $_POST['address'] ?? '';

// Professional
$current_occupation           = $_POST['occupation'] ?? '';
$current_experience           = $_POST['experience'] ?? '';
$current_income               = $_POST['annual_income'] ?? '';
$managed_team                 = $_POST['team_managed'] ?? '';
$team_description             = $_POST['team_size'] ?? '';
$leadership_experience        = $_POST['leadership_json'] ?? '[]';
$leadership_experience_other  = $_POST['other_lead'] ?? '';
$educational_qualification    = $_POST['qualification'] ?? '';

// Leadership
$career_objective = $_POST['career_objective'] ?? '';
$team_expected    = $_POST['team_expected'] ?? '';
$operating_region = $_POST['operating_state'] ?? '';

// Nominee
$nominee_name          = $_POST['nominee_name'] ?? '';
$nominee_relation      = $_POST['nominee_relation'] ?? '';
$nominee_contact_cd    = $_POST['country_cd_nominee'] ?? '';
$nominee_contact_no    = $_POST['nominee_phone'] ?? '';
$nominee_date_of_birth = $_POST['nominee_dob'] ?? '';
$nominee_address       = $_POST['nominee_address'] ?? '';

// Bank
$account_holder_name = $_POST['acc_holder_name'] ?? '';
$bank_name           = $_POST['bank_name'] ?? '';
$account_number      = $_POST['account_number'] ?? '';
$ifsc_code           = $_POST['ifsc_code'] ?? '';
$branch_name         = $_POST['branch_name'] ?? '';

// Documents
$profile_pic                    = $_POST['profile_pic'] ?? '';
$aadhar_card                    = $_POST['aadhar_card'] ?? '';
$pan_card                       = $_POST['pan_card'] ?? '';
$cancelled_cheque_bank_passbook = $_POST['passbook'] ?? '';
$resume_cv                      = $_POST['resume_cv'] ?? '';
$address_proof                  = $_POST['address_proof'] ?? '';
$professional_profile           = $_POST['professional_profile'] ?? '';
$business_profile               = $_POST['business_profile'] ?? '';
$income_proof                   = $_POST['income_proof'] ?? '';
$other_document                 = $_POST['other_document'] ?? '';

$register_by = "1";
$fromWhom = "1";
$user_type_id = "34";
$operation = "Update";
$title="Chief Techo Enterprise";
$message2 = "";
$resubmittedStatus = "";

// check if at least one rejected field found - will be used for inserting data in user_verification table
$verificationStatus = json_decode($verification_status, true);
$hasRejected = in_array('rejected', $verificationStatus ?? []);
$hasApproved = in_array('approved', $verificationStatus ?? []) && !in_array('rejected', $verificationStatus ?? []);

$birthYear = !empty($bdate) ? date('Y', strtotime($bdate)) : $current_year;
$age = $current_year - $birthYear;

$stmtResubmit = $conn->prepare("SELECT * FROM `user_verification` WHERE application_id= :application_id ORDER BY id DESC LIMIT 1");
$stmtResubmit->execute([':application_id' => $application_id_no]);
$stmtResubmit->setFetchMode(PDO::FETCH_ASSOC);
if ($stmtResubmit->rowCount() > 0) {
    foreach (($stmtResubmit->fetchAll()) as $rowResubmitted) {
        $actionType = 'Resubmitted';
    }
}

try {

    if ($editfor == 'pending') {
        if($actionType == 'draft'){
            $message = "Chief Techno Enterprise Form Saved as draft by Admin from Pending list";
            $status= '4';
        }else if($actionType == 'Resubmitted'){
            $message = "Chief Techno Enterprise Form Resubmitted by Admin from Pending list";
            $status= '2';
        }else if($actionType == 'submit'){
            $message = "Chief Techno Enterprise Form Edited by Admin from Pending list";
            $status= '2';
        }
        $stmt = $conn->prepare("SELECT application_id FROM chief_techno_enterprise WHERE id = :id");
        $stmt->execute([':id' => $identifier_id]);
    } else {
        $message = "Chief Techno Enterprise Form Edited by Admin from Registed List";
        $status= '1';
        $stmt = $conn->prepare("SELECT application_id FROM chief_techno_enterprise WHERE chief_techno_enterprise_id = :id");
        $stmt->execute([':id' => $identifier_id]);
    }
    $appData = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$appData) {
        echo 0;
        exit;
    }

    $application_id = $appData['application_id'];

    $conn->beginTransaction();

    // chief_techno_enterprise
    $stmt1 = $conn->prepare("UPDATE chief_techno_enterprise SET
        firstname=:firstname,
        lastname=:lastname,
        father_spouse_name=:father_spouse_name,
        email=:email,
        country_code=:country_code,
        contact_no=:contact_no,
        alternative_country_code=:alternative_country_code,
        alternative_contact_no=:alternative_contact_no,
        aadhar_no=:aadhar_no,
        pan_no=:pan_no,
        date_of_birth=:date_of_birth,
        age=:age,
        gender=:gender,
        country=:country,
        state=:state,
        city=:city,
        pincode=:pincode,
        address=:address,
        status=:status
        WHERE application_id=:application_id");

    $stmt1->execute([
        ':firstname'=>$firstname,
        ':lastname'=>$lastname,
        ':father_spouse_name'=>$father_spouse_name,
        ':email'=>$email,
        ':country_code'=>$country_code,
        ':contact_no'=>$phone,
        ':alternative_country_code'=>$country_code_alt,
        ':alternative_contact_no'=>$alt_phone,
        ':aadhar_no'=>$aadhar_no,
        ':pan_no'=>$pan_no,
        ':date_of_birth'=>$bdate,
        ':age'=>$age,
        ':gender'=>$gender,
        ':country'=>$country,
        ':state'=>$state,
        ':city'=>$city,
        ':pincode'=>$pincode,
        ':address'=>$address,
        ':status'=>$status,
        ':application_id'=>$application_id
    ]);

    // professional_and_educational
    $stmt2 = $conn->prepare("UPDATE professional_and_educational SET
        current_occupation=:current_occupation,
        current_experience=:current_experience,
        current_income=:current_income,
        managed_team=:managed_team,
        team_description=:team_description,
        leadership_experience=:leadership_experience,
        leadership_experience_other=:leadership_experience_other,
        educational_qualification=:educational_qualification
        WHERE application_id=:application_id");

    $stmt2->execute([
        ':current_occupation'=>$current_occupation,
        ':current_experience'=>$current_experience,
        ':current_income'=>$current_income,
        ':managed_team'=>$managed_team,
        ':team_description'=>$team_description,
        ':leadership_experience'=>$leadership_experience,
        ':leadership_experience_other'=>$leadership_experience_other,
        ':educational_qualification'=>$educational_qualification,
        ':application_id'=>$application_id
    ]);

    // leadership_assessment
    $stmt3 = $conn->prepare("UPDATE leadership_assessment SET
        career_objective=:career_objective,
        team_expected=:team_expected,
        operating_region=:operating_region
        WHERE application_id=:application_id");

    $stmt3->execute([
        ':career_objective'=>$career_objective,
        ':team_expected'=>$team_expected,
        ':operating_region'=>$operating_region,
        ':application_id'=>$application_id
    ]);

    // nominee_details
    $stmt4 = $conn->prepare("UPDATE nominee_details SET
        nominee_name=:nominee_name,
        nominee_relation=:nominee_relation,
        nominee_contact_cd=:nominee_contact_cd,
        nominee_contact_no=:nominee_contact_no,
        nominee_date_of_birth=:nominee_date_of_birth,
        nominee_address=:nominee_address
        WHERE application_id=:application_id");

    $stmt4->execute([
        ':nominee_name'=>$nominee_name,
        ':nominee_relation'=>$nominee_relation,
        ':nominee_contact_cd'=>$nominee_contact_cd,
        ':nominee_contact_no'=>$nominee_contact_no,
        ':nominee_date_of_birth'=>$nominee_date_of_birth,
        ':nominee_address'=>$nominee_address,
        ':application_id'=>$application_id
    ]);

    // bank_details
    $stmt5 = $conn->prepare("UPDATE bank_details SET
        account_holder_name=:account_holder_name,
        bank_name=:bank_name,
        account_number=:account_number,
        ifsc_code=:ifsc_code,
        branch_name=:branch_name
        WHERE application_id=:application_id");

    $stmt5->execute([
        ':account_holder_name'=>$account_holder_name,
        ':bank_name'=>$bank_name,
        ':account_number'=>$account_number,
        ':ifsc_code'=>$ifsc_code,
        ':branch_name'=>$branch_name,
        ':application_id'=>$application_id
    ]);

    // documents
    $stmt6 = $conn->prepare("UPDATE documents SET
        profile_pic=:profile_pic,
        aadhar_card=:aadhar_card,
        pan_card=:pan_card,
        cancelled_cheque_bank_passbook=:cancelled_cheque_bank_passbook,
        resume_cv=:resume_cv,
        address_proof=:address_proof,
        professional_profile=:professional_profile,
        business_profile=:business_profile,
        income_proof=:income_proof,
        other_document=:other_document
        WHERE application_id=:application_id");

    $stmt6->execute([
        ':profile_pic'=>$profile_pic,
        ':aadhar_card'=>$aadhar_card,
        ':pan_card'=>$pan_card,
        ':cancelled_cheque_bank_passbook'=>$cancelled_cheque_bank_passbook,
        ':resume_cv'=>$resume_cv,
        ':address_proof'=>$address_proof,
        ':professional_profile'=>$professional_profile,
        ':business_profile'=>$business_profile,
        ':income_proof'=>$income_proof,
        ':other_document'=>$other_document,
        ':application_id'=>$application_id
    ]);

    $message = ($editfor == 'pending')
        ? "Updated Chief Techno Enterprise details from pending list111"
        : $identifier_id . " details updated from registered list";

    $stmt7 = $conn->prepare("INSERT INTO logs
        (title,message,message2,reference_no,register_by,from_whom,operation)
        VALUES
        (:title,:message,:message2,:reference_no,:register_by,:from_whom,:operation)");

    $stmt7->execute([
        ':title'=>$title,
        ':message'=>$message,
        ':message2'=>$message2,
        ':reference_no'=>$ref_id,
        ':register_by'=>$register_by,
        ':from_whom'=>$fromWhom,
        ':operation'=>$operation
    ]);

    if($editfor == 'registered'){
        $sql8 = "UPDATE login SET username = :email WHERE user_id = :user_id AND user_type_id = :user_type_id";
        $stmt8 = $conn->prepare($sql8);
        $stmt8->execute([
            ':email' => $email,
            ':user_id' => $register_by,
            ':user_type_id' => $user_type_id
        ]);
    }

    $stmt9 = $conn->prepare("INSERT INTO user_logs
        (application_id,title,message,reference_no,operation,from_whom)
        VALUES
        (:application_id,:title,:message,:reference_no,:operation,:from_whom)");

    $stmt9->execute([
        ':application_id'=>$application_id,
        ':title'=>$title,
        ':message'=>$message,
        ':reference_no'=>$register_by,
        ':operation'=>$operation,
        ':from_whom'=>$fromWhom
    ]);

    // 11-06-2026 $actionType update on line 101 so will not enter this block, make seperate block, take care of the message at line 286
    if($actionType == "submit"){
        if($hasRejected){
            $stmt10 = $conn->prepare("INSERT INTO user_verification
                (application_id,rejection_reason,payload,verified_by,status)
                VALUES
                (:application_id,:rejection_reason,:payload,:verified_by,:status)");

            $stmt10->execute([
                ':application_id'=>$application_id,
                ':rejection_reason'=>$reject_reason,
                ':payload'=>$verification_status,
                ':verified_by'=>$fromWhom,
                ':status'=> 2
            ]);
        }else if($hasRejected && $actionType == 'Resubmitted'){
            $stmt10 = $conn->prepare("INSERT INTO user_verification
                (application_id,rejection_reason,payload,verified_by,status)
                VALUES
                (:application_id,:rejection_reason,:payload,:verified_by,:status)");

            $stmt10->execute([
                ':application_id'=>$application_id,
                ':rejection_reason'=>$reject_reason,
                ':payload'=>$verification_status,
                ':verified_by'=>$fromWhom,
                ':status'=> 3
            ]);
        } else if($hasApproved){
            $stmt10 = $conn->prepare("INSERT INTO user_verification
                (application_id,approved_reason,payload,verified_by,status)
                VALUES
                (:application_id,:approved_reason,:payload,:verified_by,:status)");

            $stmt10->execute([
                ':application_id'=>$application_id,
                ':approved_reason'=>"Admin has approved all the fields",
                ':payload'=>$verification_status,
                ':verified_by'=>$fromWhom,
                ':status'=> 1
            ]);
        }else {
            $stmt10 = $conn->prepare("INSERT INTO user_verification
                (application_id,approved_reason,payload,verified_by,status)
                VALUES
                (:application_id,:approved_reason,:payload,:verified_by,:status)");

            $stmt10->execute([
                ':application_id'=>$application_id,
                ':approved_reason'=>"Approved without Marking Varification checks",
                ':payload'=>$verification_status,
                ':verified_by'=>$fromWhom,
                ':status'=> 1
            ]);
        }
    }

    $conn->commit();
    echo 1;

} catch (Exception $e) {

    if ($conn->inTransaction()) {
        $conn->rollBack();
    }

    // Uncomment for debugging
    echo $e->getMessage();

    echo 0;
}
?>