<?php
require "../connect.php";
date_default_timezone_set('Asia/Kolkata');

$current_year = date('Y');

// additional information to check if user is registered or not
$ref_id = $_POST["ref_id"]; // reference of the user - ETE260003
$editfor = $_POST["editfor"]; // pending or confirm
$identifier_id = $_POST["id"]; // SuperTE id value if user is not confirmed - 11 , if confirmed - STE2600011

// Personal Details
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
$nominee_profile                = $_POST['nominee_profile'] ?? '';

$title = "Super Techno Enterprise";
$register_by = "1";
$fromWhom = "1";
$operation = "Update";
$user_type_id = "35";

$birthYear = !empty($bdate) ? date('Y', strtotime($bdate)) : $current_year;
$age = $current_year - $birthYear;

try {

    if ($editfor == 'pending') {
        $stmt = $conn->prepare("SELECT application_id FROM super_techno_enterprise WHERE id = :id");
        $stmt->execute([':id' => $identifier_id]);
    } else {
        $stmt = $conn->prepare("SELECT application_id FROM super_techno_enterprise WHERE super_techno_enterprise_id = :id");
        $stmt->execute([':id' => $identifier_id]);
    }
    $appData = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$appData) {
        echo 0;
        exit;
    }

    $application_id = $appData['application_id'];

    $conn->beginTransaction();

    // super_techno_enterprise
    $stmt1 = $conn->prepare("UPDATE super_techno_enterprise SET
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
        address=:address
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
        other_document=:other_document,
        nominee_profile=:nominee_profile
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
        ':nominee_profile' => $nominee_profile,
        ':application_id'=>$application_id
    ]);

    $message = ($editfor == 'pending')
        ? "Updated Super Techno Enterprise details from pending list"
        : $identifier_id . " details updated from registered list";

    $stmt7 = $conn->prepare("INSERT INTO logs
        (title,message,message2,reference_no,register_by,from_whom,operation)
        VALUES
        (:title,:message,:message2,:reference_no,:register_by,:from_whom,:operation)");

    $stmt7->execute([
        ':title'=>$title,
        ':message'=>$message,
        ':message2'=>$message,
        ':reference_no'=>$ref_id,
        ':register_by'=>$register_by,
        ':from_whom'=>$fromWhom,
        ':operation'=>$operation
    ]);

    if($editfor == 'registered'){
        $sql8 = "UPDATE login SET username = :email WHERE user_id = :user_id AND user_type_id = :user_type_id";
        $stmt8 = $conn->prepare($sql8);
        $result8 = $stmt8->execute([
            ':email' => $email,
            ':user_id' => $ref_id,
            ':user_type_id' => $user_type_id
        ]);
    }

    $conn->commit();
    echo 1;

} catch (Exception $e) {

    if ($conn->inTransaction()) {
        $conn->rollBack();
    }

    echo 0;
}
?>