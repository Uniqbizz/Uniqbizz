<?php

    include '../connect.php';

    $editfor= $_POST["editfor"];

    if($editfor == 'pending'){
        $identifier_id= $_POST["id"];
        $identifier_name = 'id=';
        $title = "Employee";
        $message="Updated Employee details from ".$editfor. " list";
        $message2="Updated Employee details from ".$editfor. " list";
    }else if($editfor == 'registered') {
        $identifier_id= $_POST["id"];
        $identifier_name = 'employee_id=';
        $title = "Employee";
        $message=$identifier_id. " Details has been updated from ".$editfor. " list";
        $message2=$identifier_id. " Details has been updated from ".$editfor. " list";
    }

    // $id = $_POST['id'];
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
    $note = $_POST['note'];

    if($designation == '1'){
        $user_type = '24'; //BCM
    }else if($designation == '2'){
        $user_type = '25'; //BDM
    }

    $register_by = '15'; //admin
    $fromWhom = '15'; 
    $operation = 'Update';
    $reference_no = '1';
    // $status = '1';

    // $sql = "INSERT INTO employees (name, date_of_birth, country_code, contact, email, address, gender, date_of_joining, department, designation, zone, branch, reporting_manager, profile_pic, id_proof, bank_details, register_by, user_type, status) VALUES (:name, :date_of_birth, :country_code, :contact, :email, :address, :gender, :date_of_joining, :department, :designation, :zone, :branch, :reporting_manager, :profile_pic, :id_proof, :bank_details, :register_by, :user_type, :status)"; 
    // $stmt = $conn->prepare($sql);
    // $result = $stmt->execute(array(
    //     ':name' => $name,
    //     ':date_of_birth' => $birth_date,
    //     ':country_code' => $country_cd,
    //     ':contact' => $contact,
    //     ':email' => $email,
    //     ':address' => $address,
    //     ':gender' => $gender,
    //     ':date_of_joining' => $joining_date,
    //     ':department' => $department,
    //     ':designation' => $designation,
    //     ':zone' => $zone,
    //     ':branch' => $branch,
    //     ':reporting_manager' => $reporting_manager,
    //     ':profile_pic' => $profile_pic,
    //     ':id_proof' => $id_proof,
    //     ':bank_details' => $bank_details,
    //     ':register_by' => $register_by,
    //     ':user_type' => $user_type,
    //     ':status' => $status
    // ));

    $sql = "UPDATE employees SET name = :name, date_of_birth = :date_of_birth, country_code = :country_code, contact = :contact, email = :email, address = :address, gender =:gender, date_of_joining = :date_of_joining, department = :department, designation = :designation, zone = :zone, branch = :branch, reporting_manager = :reporting_manager, note = :note, profile_pic = :profile_pic, id_proof = :id_proof, bank_details = :bank_details, user_type = :user_type WHERE $identifier_name:identifier_id";
    $stmt = $conn->prepare($sql);
    $result = $stmt->execute(array(
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
        // ':register_by' => $register_by,
        ':user_type' => $user_type,
        // ':status' => $status,
        ':identifier_id' => $identifier_id	
    ));
   
    if($editfor == 'registered'){
        $sql1 = "UPDATE login SET username=:username WHERE user_id=:user_id";
	    $stmt1 = $conn->prepare($sql1);
	    $result1=  $stmt1->execute(array(
            ':username' => $email,
            // ':employee_id' => $uid,
            // ':deleted_date' => $today,
            ':user_id' => $identifier_id		
        ));  

        $sql4= "INSERT INTO logs (user_id,title,message,message2, reference_no, register_by, from_whom, operation) VALUES (:user_id,:title ,:message, :message2, :reference_no, :register_by, :from_whom, :operation)";
        $stmt4 =$conn->prepare($sql4);
        $result2=$stmt4->execute(array(
            ':user_id' => $identifier_id,
            ':title' => $title,
            ':message' => $message,
            ':message2' =>$message2,
            ':reference_no' => $reporting_manager,
            ':register_by' => $register_by,
            ':from_whom' => $fromWhom,
            ':operation' => $operation
        ));

        if($result2){
            echo 1;
        }else{
            echo 0;
        }          
    }else{
        $sql4= "INSERT INTO logs (user_id,title,message,message2, reference_no, register_by, from_whom, operation) VALUES (:user_id,:title ,:message, :message2, :reference_no, :register_by, :from_whom, :operation)";
        $stmt4 =$conn->prepare($sql4);
        $result3=$stmt4->execute(array(
            ':user_id' => $identifier_id,
            ':title' => $title,
            ':message' => $message,
            ':message2' =>$message2,
            ':reference_no' => $reporting_manager,
            ':register_by' => $register_by,
            ':from_whom' => $fromWhom,
            ':operation' => $operation
        ));
        if($result3){
            echo 1;
        }else{
            echo 0;
        }
    }

    

?>