<?php

	session_start();

	if(!isset($_SESSION['username'])){
		echo '<script>location.href = "../../login.php";</script>';
	}

    include '../../connect.php';
    $current_year = date('Y'); 

    // Email files
    // include('../../../../e-mail/phpmailer_smtp/smtp/PHPMailerAutoload.php');

    $name = $_POST['name'];
    $birth_date = $_POST['birth_date'];
    $country_cd = $_POST['country_cd'];
    $contact = $_POST['contact'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $gender = $_POST['gender'];
    $joining_date = $_POST['joining_date'];
    $department = $_POST['department'];
    $designation = $_POST['designation'];
    $zone = $_POST['zone'];
    $branch = $_POST['branch'];
    $reporting_manager = $_POST['reporting_manager'];
    $profile_pic = $_POST['profile_pic'];
    $id_proof = $_POST['id_proof'];
    $bank_details = $_POST['bank_details'];
    $register_by = $_POST['userType']; //25
	$userId = $_POST['userId']; // BH250001 taking from reporting manager 
	$status = '2';
	$user_type = '25'; //25
	$designation_name = 'BDM';


    // get age of the user
    $birthYear = str_split($birth_date,4);
    $birth_year = $birthYear[0];
    $age = $current_year - $birth_year;

    
    //log file
    $title="Added Employee -".$name.' '.$designation_name ;
    $message= "Employee has been Added";
    $message2= "Employee has been Added By Admin";
    $fromWhom= $register_by;
	$operation = 'Add';

    $sql = "INSERT INTO employees (name, date_of_birth, country_code, contact, email, address, gender, date_of_joining, department, designation, zone, branch, reporting_manager, profile_pic, id_proof, bank_details, register_by, user_type, status) VALUES (:name, :date_of_birth, :country_code, :contact, :email, :address, :gender, :date_of_joining, :department, :designation, :zone, :branch, :reporting_manager, :profile_pic, :id_proof, :bank_details, :register_by, :user_type, :status)"; 
    $stmt = $conn->prepare($sql);
    $result = $stmt->execute(array(
        // ':employee_id' => $uid,
        ':name' => $name,
        ':date_of_birth' => $birth_date,
        ':country_code' => $country_cd,
        ':contact' => $contact,
        ':email' => $email,
        ':address' => $address,
        ':gender' => $gender,
        ':date_of_joining' => $joining_date,
        ':department' => $department,
        ':designation' => $designation,
        ':zone' => $zone,
        ':branch' => $branch,
        ':reporting_manager' => $reporting_manager,
        ':profile_pic' => $profile_pic,
        ':id_proof' => $id_proof,
        ':bank_details' => $bank_details,
        ':register_by' => $register_by,
        ':user_type' => $user_type,
        ':status' => $status
    ));
   
    if ($result) {
		
		

		$result2 = 1;

        if($result2){

            $sql3= "INSERT INTO logs ( title,message,message2, reference_no, register_by, from_whom, operation) VALUES (:title ,:message, :message2, :reference_no, :register_by, :from_whom, :operation)";
            $stmt =$conn->prepare($sql3);

            $result3=$stmt->execute(array(
                ':title' => $title,
                ':message' => $message,
                ':message2' =>$message2,
                ':reference_no' => $reporting_manager,
                ':register_by' => $register_by,
                ':from_whom' => $fromWhom,
				':operation' => $operation
            ));

           
			echo 1;
        }else{
            echo 0	;
        }
        
    }else{
        echo 0	;
    }

?>