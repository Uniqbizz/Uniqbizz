<?php

include '../../connect.php';

header('Content-Type: application/json');

// Read JSON input correctly
$json = file_get_contents("php://input");
$data = json_decode($json, true);

// Debugging: Check if JSON decoding worked
if (!$data) {
    echo json_encode(["status" => "error", "message" => "Invalid JSON input"]);
    exit;
}

// Check required keys
if (!isset($data["editfor"]) || !isset($data["id"])) {
    echo json_encode(["status" => "error", "message" => "Missing required fields"]);
    exit;
}

// Proceed with normal script execution
$editfor = $data["editfor"];

if($editfor == 'pending'){
    $identifier_id= $data["id"];
    $identifier_name = 'id=';
    $title = "Employee";
    $message="Updated Employee details from ".$editfor. " list";
    $message2="Updated Employee details from ".$editfor. " list";
}else if($editfor == 'registered') {
    $identifier_id= $data["id"];
    $identifier_name = 'employee_id=';
    $title = "Employee";
    $message=$identifier_id. " Details has been updated from ".$editfor. " list";
    $message2=$identifier_id. " Details has been updated from ".$editfor. " list";
}

// $id = $_POST['id'];
$name = $data['name'];
$birth_date = $data['birth_date'];
$country_cd = $data['country_cd'];
$contact = $data['contact'];
$email = $data['email'];
$address = $data['address'];
$gender = $data['gender'];
$joining_date = $data['joining_date'];
$department = $data['department'];
$designation = $data['designation'];
$zone = $data['zone'];
$branch = $data['branch'];
$reporting_manager = $data['reporting_manager'];
$profile_pic = $data['profile_pic'];
$id_proof = $data['id_proof'];
$bank_details = $data['bank_details'];

if($designation == '1'){
    $user_type = '24'; //BCM
}else if($designation == '2'){
    $user_type = '25'; //BDM
}

$register_by = '1'; //admin
    $fromWhom = '1'; 
    $operation = 'Update';
    $reference_no = '1';

// Update employee details query
$sql = "UPDATE employees SET name = :name, date_of_birth = :date_of_birth, country_code = :country_code, contact = :contact, email = :email, address = :address, gender =:gender, date_of_joining = :date_of_joining, department = :department, designation = :designation, zone = :zone, branch = :branch, reporting_manager = :reporting_manager, profile_pic = :profile_pic, id_proof = :id_proof, bank_details = :bank_details, user_type = :user_type WHERE $identifier_name:identifier_id";
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
            ':reference_no' => $reference_no,
            ':register_by' => $register_by,
            ':from_whom' => $fromWhom,
            ':operation' => $operation
        ));
    }else{
        $sql4= "INSERT INTO logs (user_id,title,message,message2, reference_no, register_by, from_whom, operation) VALUES (:user_id,:title ,:message, :message2, :reference_no, :register_by, :from_whom, :operation)";
        $stmt4 =$conn->prepare($sql4);
        $result3=$stmt4->execute(array(
            ':user_id' => $identifier_id,
            ':title' => $title,
            ':message' => $message,
            ':message2' =>$message2,
            ':reference_no' => $reference_no,
            ':register_by' => $register_by,
            ':from_whom' => $fromWhom,
            ':operation' => $operation
        ));        
    }

// Response
if ($result) {
    echo json_encode(["status" => "success", "message" => "Employee details updated successfully"]);
} else {
    echo json_encode(["status" => "error", "message" => "Failed to update employee details"]);
}

?>
