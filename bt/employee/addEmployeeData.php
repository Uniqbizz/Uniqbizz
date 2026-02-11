<?php

	session_start();

	// echo $username = $_SESSION['username'];
	// echo $id = $_SESSION['id'];
	// echo $user_id = $_SESSION['user_id'];

	if(!isset($_SESSION['username'])){
		echo '<script>location.href = "../login.php";</script>';
	}

    include '../connect.php';
    $current_year = date('Y'); 

    // Email files
    // include('../../e-mail/phpmailer_smtp/smtp/PHPMailerAutoload.php');

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
	$note=$_POST['note'];
    $register_by = '1'; //admin
	$status = '2';
    // if($reporting_manager == ''){
    //     $reporting_manager = 'null';
    // }

    if($designation == '1'){
        $user_type = '24'; //BCM
    }else if($designation == '2'){
        $user_type = '25'; //BDM
    }else if($designation == '3'){
        $user_type = '31'; //Relationship  manager
    }else{
        $user_type = '00'; //adding employee without error if usertype not define
    }

    // get age of the user
    $birthYear = str_split($birth_date,4);
    $birth_year = $birthYear[0];
    $age = $current_year - $birth_year;


    //log file
    $title="Employee ";
    $message= "Employee has been Added";
    $message2= "Employee has been Added By Admin";
	$operation = "Add";
    $fromWhom="1";

    $sql = "INSERT INTO employees (name, date_of_birth, country_code, contact, email, address, gender, date_of_joining, department, designation, zone, branch, reporting_manager, note, profile_pic, id_proof, bank_details, register_by, user_type, status) VALUES (:name, :date_of_birth, :country_code, :contact, :email, :address, :gender, :date_of_joining, :department, :designation, :zone, :branch, :reporting_manager, :note,:profile_pic, :id_proof, :bank_details, :register_by, :user_type, :status)"; 
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
		':note' => $note,
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

            $sql3= "INSERT INTO logs ( title,message,message2, register_by, from_whom, operation) VALUES (:title ,:message, :message2, :register_by, :from_whom, :operation)";
            $stmt =$conn->prepare($sql3);

            $result3=$stmt->execute(array(
                // ':user_id' => $uid,
                ':title' => $title,
                ':message' => $message,
                ':message2' =>$message2,
                // ':reference_no' => $user_id_name,
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