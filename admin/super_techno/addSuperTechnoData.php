<?php
    // session_start();
    require '../connect.php';
    $current_year = date('Y'); 

    // Email files
    include('../../e-mail/phpmailer_smtp/smtp/PHPMailerAutoload.php');

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
    $occupation           = $_POST['occupation'] ?? '';
    $experience           = $_POST['experience'] ?? '';
    $annual_income        = $_POST['annual_income'] ?? '';
    $team_managed         = $_POST['team_managed'] ?? '';
    $team_size            = $_POST['team_size'] ?? '';
    $leadership_json      = $_POST['leadership_json'] ?? '[]';
    $other_lead           = $_POST['other_lead'] ?? '';
    $qualification        = $_POST['qualification'] ?? '';

    // Leadership assessment - table "leadership_assessment"
    $career_objective     = $_POST['career_objective'] ?? '';
    $team_expected        = $_POST['team_expected'] ?? '';
    $operating_state      = $_POST['operating_state'] ?? '';

    // Nominee Details - table "nominee_details"
    $nominee_name         = $_POST['nominee_name'] ?? '';
    $nominee_relation     = $_POST['nominee_relation'] ?? '';
    $country_cd_nominee   = $_POST['country_cd_nominee'] ?? '';
    $nominee_phone        = $_POST['nominee_phone'] ?? '';
    $nominee_dob          = $_POST['nominee_dob'] ?? '';
    $nominee_address      = $_POST['nominee_address'] ?? '';

    // Bank Details - table "bank_details"
    $acc_holder_name      = $_POST['acc_holder_name'] ?? '';
    $bank_name            = $_POST['bank_name'] ?? '';
    $account_number       = $_POST['account_number'] ?? '';
    $ifsc_code            = $_POST['ifsc_code'] ?? '';
    $branch_name          = $_POST['branch_name'] ?? '';

    // attachments - table "documents"
    $profile_pic          = $_POST['profile_pic'] ?? '';
    $aadhar_card          = $_POST['aadhar_card'] ?? '';
    $pan_card             = $_POST['pan_card'] ?? '';
    $passbook             = $_POST['passbook'] ?? '';
    $resume_cv            = $_POST['resume_cv'] ?? '';
    $address_proof        = $_POST['address_proof'] ?? '';
    $professional_profile = $_POST['professional_profile'] ?? '';
    $business_profile     = $_POST['business_profile'] ?? '';
    $income_proof         = $_POST['income_proof'] ?? '';
    $other_document       = $_POST['other_document'] ?? '';

    $user_type="35";
    $register_by="1";
	$status= '2';

    // get age of the user
    $birthYear = str_split($bdate,4);
    $birth_year = $birthYear[0];
    $age = $current_year - $birth_year;

    // data insertion for logs tables 
    $title="Super Techo Enterprise";
    $message="Added new Super Techo Enterprise by admin";
    $message2="Added new Super Techo Enterprise by admin";
    $fromWhom="1";
	$operation="Add";

    $sql= "INSERT INTO `super_techno_enterprise` ( 
		firstname, 
		lastname, 
        father_spouse_name,
		email, 
		country_code, 
		contact_no , 
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
		:firstname ,
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
		:gender , 
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
    $stmt3 =$conn->prepare($sql);

    $result=$stmt3->execute(array(
        ':firstname' => $firstname, 
        ':lastname' => $lastname, 
        ':father_spouse_name' => $father_spouse_name,
        ':email' => $email,
        ':country_code' => $country_code, 
        ':contact_no' => $phone_no,
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

    if ($result) {

		$sql= "INSERT INTO `super_techno_enterprise` ( 
            firstname, 
            lastname, 
            father_spouse_name,
            email, 
            country_code, 
            contact_no , 
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
            :firstname ,
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
            :gender , 
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
        $stmt3 =$conn->prepare($sql);

        $result2=$stmt3->execute(array(
            ':firstname' => $firstname, 
            ':lastname' => $lastname, 
            ':father_spouse_name' => $father_spouse_name,
            ':email' => $email,
            ':country_code' => $country_code, 
            ':contact_no' => $phone_no,
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

        if($result2){

            $sql3= "INSERT INTO logs ( title,message,message2,reference_no, register_by, from_whom,operation) VALUES (:title ,:message, :message2, :reference_no, :register_by, :from_whom, :operation)";
            $stmt =$conn->prepare($sql3);

            $result3=$stmt->execute(array(
                ':title' => $title,
                ':message' => $message,
                ':message2' =>$message2,
                ':reference_no' => $user_id_name,
                ':register_by' => $register_by,
                ':from_whom' => $fromWhom,
				':operation' => $operation
            ));

            if($result3){
				echo 1;
			}else{  //email
				echo 0	;
			}

        }else{
            echo 0	;
        }
        
    }else{
        echo 0	;
    }

?>