<?php
    // session_start();
    require '../connect.php';
    date_default_timezone_set('Asia/Kolkata');
    $current_year = date('Y'); 

    //personal details - table "super_techno_enterprise"
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

    // professional and educational details - table "professional_and_educational"
    $current_occupation           = $_POST['occupation'] ?? '';
    $current_experience           = $_POST['experience'] ?? '';
    $current_income               = $_POST['annual_income'] ?? '';
    $managed_team                 = $_POST['team_managed'] ?? '';
    $team_description             = $_POST['team_size'] ?? '';
    $leadership_experience        = $_POST['leadership_json'] ?? '[]';
    $leadership_experience_other  = $_POST['other_lead'] ?? '';
    $educational_qualification    = $_POST['qualification'] ?? '';

    // Leadership assessment - table "leadership_assessment"
    $career_objective     = $_POST['career_objective'] ?? '';
    $team_expected        = $_POST['team_expected'] ?? '';
    $operating_region     = $_POST['operating_state'] ?? '0';

    // Nominee Details - table "nominee_details"
    $nominee_name         = $_POST['nominee_name'] ?? '';
    $nominee_relation     = $_POST['nominee_relation'] ?? '';
    $nominee_contact_cd   = $_POST['country_cd_nominee'] ?? '';
    $nominee_contact_no   = $_POST['nominee_phone'] ?? '';
    $nominee_date_of_birth= $_POST['nominee_dob'] ?? '';
    $nominee_address      = $_POST['nominee_address'] ?? '';

    // Bank Details - table "bank_details"
    $account_holder_name  = $_POST['acc_holder_name'] ?? '';
    $bank_name            = $_POST['bank_name'] ?? '';
    $account_number       = $_POST['account_number'] ?? '';
    $ifsc_code            = $_POST['ifsc_code'] ?? '';
    $branch_name          = $_POST['branch_name'] ?? '';

    // attachments - table "documents"
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

    $user_type="35";
    $register_by="1";
	$status= '2';
    $age = '';
    $application_id = '';
    // genarate uniq application id 
    function getApplication() {
        return 'STEAPP' . strtoupper(bin2hex(random_bytes(4)));
    }
    $application_id = getApplication();

    // get age of the user
    if($bdate){
        $birthYear = str_split($bdate,4);
        $birth_year = $birthYear[0];
        $age = $current_year - $birth_year;
    }

    // data insertion for logs tables 
    $title="Super Techo Enterprise";
    $message="Added new Super Techo Enterprise by admin";
    $message2="Added new Super Techo Enterprise by admin";
    $fromWhom="1";
	$operation="Add";

    try {

        $conn->beginTransaction();

        $sql1= "INSERT INTO `super_techno_enterprise` ( 
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
            status)
        VALUES ( 
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
            :status)";
        $stmt1 =$conn->prepare($sql1);

        $stmt1->execute(array(
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
            ':country' => $country,
            ':state' => $state,
            ':city' => $city,
            ':pincode' => $pincode,
            ':address' => $address,  
            ':bdate' => $bdate,
            ':age' => $age,  
            ':gender' => $gender,
            ':user_type' => $user_type,
            ':registrant' =>$reference_name,
            ':reference_no' => $user_id_name,
            ':register_by' => $register_by,
            ':status' => $status
        ));

        $sql2= "INSERT INTO `professional_and_educational` ( 
            application_id,
            current_occupation, 
            current_experience, 
            current_income,
            managed_team, 
            team_description, 
            leadership_experience,
            leadership_experience_other,
            educational_qualification)
        VALUES ( 
            :application_id,
            :current_occupation,
            :current_experience, 
            :current_income,
            :managed_team, 
            :team_description, 
            :leadership_experience,
            :leadership_experience_other,
            :educational_qualification)";
        $stmt2 =$conn->prepare($sql2);

        $stmt2->execute(array(
            ':application_id' => $application_id,
            ':current_occupation' => $current_occupation, 
            ':current_experience' => $current_experience, 
            ':current_income' => $current_income,
            ':managed_team' => $managed_team,
            ':team_description' => $team_description, 
            ':leadership_experience' => $leadership_experience,
            ':leadership_experience_other' => $leadership_experience_other,
            ':educational_qualification' => $educational_qualification
        ));

        $sql3= "INSERT INTO `leadership_assessment` ( 
            application_id,
            career_objective, 
            team_expected, 
            operating_region)
        VALUES ( 
            :application_id,
            :career_objective ,
            :team_expected, 
            :operating_region)";
        $stmt3 =$conn->prepare($sql3);

        $stmt3->execute(array(
            ':application_id' => $application_id,
            ':career_objective' => $career_objective, 
            ':team_expected' => $team_expected, 
            ':operating_region' => $operating_region
        ));


        $sql4= "INSERT INTO `nominee_details` ( 
            application_id,
            nominee_name, 
            nominee_relation, 
            nominee_contact_cd,
            nominee_contact_no,
            nominee_date_of_birth,
            nominee_address)
        VALUES ( 
            :application_id,
            :nominee_name ,
            :nominee_relation, 
            :nominee_contact_cd,
            :nominee_contact_no,
            :nominee_date_of_birth,
            :nominee_address)";
        $stmt4 =$conn->prepare($sql4);

        $stmt4->execute(array(
            ':application_id' => $application_id,
            ':nominee_name' => $nominee_name, 
            ':nominee_relation' => $nominee_relation, 
            ':nominee_contact_cd' => $nominee_contact_cd,
            ':nominee_contact_no' => $nominee_contact_no,
            ':nominee_date_of_birth' => $nominee_date_of_birth,
            ':nominee_address' => $nominee_address,
        ));

        $sql5= "INSERT INTO `bank_details` ( 
            application_id,
            account_holder_name, 
            bank_name, 
            account_number,
            ifsc_code,
            branch_name)
        VALUES ( 
            :application_id,
            :account_holder_name ,
            :bank_name, 
            :account_number,
            :ifsc_code,
            :branch_name)";
        $stmt5 =$conn->prepare($sql5);

        $stmt5->execute(array(
            ':application_id' => $application_id,
            ':account_holder_name' => $account_holder_name, 
            ':bank_name' => $bank_name, 
            ':account_number' => $account_number,
            ':ifsc_code' => $ifsc_code,
            ':branch_name' => $branch_name
        ));

        $sql6= "INSERT INTO `documents` ( 
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
            other_document)
        VALUES ( 
            :application_id,
            :profile_pic ,
            :aadhar_card, 
            :pan_card,
            :cancelled_cheque_bank_passbook,
            :resume_cv,
            :address_proof,
            :professional_profile,
            :business_profile,
            :income_proof,
            :other_document)";
        $stmt6 =$conn->prepare($sql6);

        $stmt6->execute(array(
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
            ':other_document' => $other_document
        ));

        $sql7= "INSERT INTO logs ( title,message,message2,reference_no, register_by, from_whom,operation) VALUES (:title ,:message, :message2, :reference_no, :register_by, :from_whom, :operation)";
        $stmt7 =$conn->prepare($sql7);

        $stmt7->execute(array(
            ':title' => $title,
            ':message' => $message,
            ':message2' =>$message2,
            ':reference_no' => $user_id_name,
            ':register_by' => $register_by,
            ':from_whom' => $fromWhom,
            ':operation' => $operation
        ));

        $conn->commit();

        echo 1;

    } catch (Exception $e) {

        if ($conn->inTransaction()) {
            $conn->rollBack();
        }

        // Uncomment for debugging
        // echo $e->getMessage();

        echo 0;
    }

?>