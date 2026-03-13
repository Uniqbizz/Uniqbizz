<?php

    include '../../connect.php';

    $editfor = $_POST["editfor"];

    if($editfor == 'pending'){
        $identifier_id = $_POST["id"];
        $identifier_column = 'id';
        $title = "Employee";
        $message="Updated Employee details from ".$editfor." list";
        $message2="Updated Employee details from ".$editfor." list";
    }
    else if($editfor == 'registered'){
        $identifier_id = $_POST["id"];
        $identifier_column = 'employee_id';
        $title = "Employee";
        $message=$identifier_id." Details has been updated from ".$editfor." list";
        $message2=$identifier_id." Details has been updated from ".$editfor." list";
    }

    /* -------------------------
    NEW FORM DATA
    ------------------------- */

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
    $user_type = $_POST['user_type'];
    $edit_reason = $_POST['edit_reason'];

    $register_by = '1';
    $fromWhom = '1';
    $operation = 'Update';
    $reference_no = '1';

    $ip_address = 'NA';

    /* -------------------------
    FETCH ORIGINAL DATA FROM DB
    ------------------------- */

    $stmt = $conn->prepare("SELECT * FROM employees WHERE $identifier_column = :id");
    $stmt->execute(['id'=>$identifier_id]);
    $prevUserData = $stmt->fetch(PDO::FETCH_ASSOC) ?? [];

    /* -------------------------
    FETCH LOOKUP NAMES
    ------------------------- */

    $departmentname = '';
    $designationname = '';
    $zone_name = '';
    $branch_name = '';
    $reporting_manager_name = '';

    $stmt = $conn->prepare("SELECT dept_name FROM department WHERE id=:id");
    $stmt->execute(['id'=>$department]);
    if($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        $departmentname = $row['dept_name'];
    }

    $stmt = $conn->prepare("SELECT designation_name FROM designation WHERE id=:id");
    $stmt->execute(['id'=>$designation]);
    if($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        $designationname = $row['designation_name'];
    }

    $stmt = $conn->prepare("SELECT zone_name FROM zone WHERE id=:id");
    $stmt->execute(['id'=>$zone]);
    if($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        $zone_name = $row['zone_name'];
    }

    $stmt = $conn->prepare("SELECT branch_name FROM branch WHERE id=:id");
    $stmt->execute(['id'=>$branch]);
    if($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        $branch_name = $row['branch_name'];
    }

    if(empty($reporting_manager)){
        $reporting_manager_name = 'Not Selected';
    }
    else{
        $stmt = $conn->prepare("SELECT name FROM employees WHERE employee_id=:id");
        $stmt->execute(['id'=>$reporting_manager]);
        if($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            $reporting_manager_name = $row['name'];
        }
    }

    /* -------------------------
    NEW DATA ARRAY
    ------------------------- */

    $newUserData = [
    "name"=>$name,
    "email"=>$email,
    "contact"=>$contact,
    "country_code"=>$country_cd,
    "reporting_manager"=>$reporting_manager,
    "date_of_birth"=>$birth_date,
    "date_of_joining"=>$joining_date,
    "gender"=>$gender,
    "department"=>$department,
    "designation"=>$designation,
    "zone"=>$zone,
    "branch"=>$branch,
    "address"=>$address,
    "profile_pic"=>$profile_pic,
    "id_proof"=>$id_proof,
    "bank_details"=>$bank_details,
    "note"=>$note
    ];

    /* -------------------------
    COMPARE CHANGES
    ------------------------- */

    $changes = [];

    foreach($newUserData as $column=>$newValue){

        $oldValue = $prevUserData[$column] ?? '';

        $oldValue = trim((string)$oldValue);
        $newValue = trim((string)$newValue);

        if($oldValue === $newValue){
            continue;
        }

        $oldDisplay = $oldValue;
        $newDisplay = $newValue;

        if($column == 'department'){
            $oldDisplay = $departmentname;
        }

        if($column == 'designation'){
            $oldDisplay = $designationname;
        }

        if($column == 'zone'){
            $oldDisplay = $zone_name;
        }

        if($column == 'branch'){
            $oldDisplay = $branch_name;
        }

        if($column == 'reporting_manager'){
            $oldDisplay = $reporting_manager_name;
        }

        $changes[] = [
            "column"=>$column,
            "old"=>$oldDisplay,
            "new"=>$newDisplay
        ];
    }

    /* -------------------------
    UPDATE EMPLOYEE
    ------------------------- */

    $sql = "UPDATE employees SET
    name = :name,
    date_of_birth = :date_of_birth,
    country_code = :country_code,
    contact = :contact,
    email = :email,
    address = :address,
    gender = :gender,
    date_of_joining = :date_of_joining,
    department = :department,
    designation = :designation,
    zone = :zone,
    branch = :branch,
    reporting_manager = :reporting_manager,
    note = :note,
    profile_pic = :profile_pic,
    id_proof = :id_proof,
    bank_details = :bank_details,
    user_type = :user_type
    WHERE $identifier_column = :identifier_id";

    $stmt = $conn->prepare($sql);

    $result = $stmt->execute([
    ':name'=>$name,
    ':date_of_birth'=>$birth_date,
    ':country_code'=>$country_cd,
    ':contact'=>$contact,
    ':email'=>$email,
    ':address'=>$address,
    ':gender'=>$gender,
    ':date_of_joining'=>$joining_date,
    ':department'=>$department,
    ':designation'=>$designation,
    ':zone'=>$zone,
    ':branch'=>$branch,
    ':reporting_manager'=>$reporting_manager,
    ':note'=>$note,
    ':profile_pic'=>$profile_pic,
    ':id_proof'=>$id_proof,
    ':bank_details'=>$bank_details,
    ':user_type'=>$user_type,
    ':identifier_id'=>$identifier_id
    ]);

    /* -------------------------
    INSERT EDIT LOGS
    ------------------------- */

    if($result && !empty($changes)){

        foreach($changes as $change){

            $stmtLog = $conn->prepare("
                INSERT INTO field_edit_logs
                (table_name,record_id,column_name,old_value,new_value,change_reason,changed_by,changed_role,ip_address)
                VALUES
                (:table_name,:record_id,:column_name,:old_value,:new_value,:change_reason,:changed_by,:changed_role,:ip_address)
            ");

            $stmtLog->execute([
                ':table_name'     => 'employees',
                ':record_id'      => $identifier_id,
                ':column_name'    => $change['column'],
                ':old_value'      => $change['old'],
                ':new_value'      => $change['new'],
                ':change_reason'  => $edit_reason,
                ':changed_by'     => $register_by,
                ':changed_role'   => 'admin',
                ':ip_address'     => $ip_address
            ]);
        }
    }

    /* -------------------------
    UPDATE LOGIN
    ------------------------- */

    if($editfor == 'registered'){

        $stmt1=$conn->prepare("UPDATE login SET username=:username WHERE user_id=:user_id");

        $stmt1->execute([
        ':username'=>$email,
        ':user_id'=>$identifier_id
        ]);
    }

    /* -------------------------
    SYSTEM LOG
    ------------------------- */

    $stmt4=$conn->prepare("INSERT INTO logs
    (user_id,title,message,message2,reference_no,register_by,from_whom,operation)
    VALUES
    (:user_id,:title,:message,:message2,:reference_no,:register_by,:from_whom,:operation)");

    $result2=$stmt4->execute([
    ':user_id'=>$identifier_id,
    ':title'=>$title,
    ':message'=>$message,
    ':message2'=>$message2,
    ':reference_no'=>$reference_no,
    ':register_by'=>$register_by,
    ':from_whom'=>$fromWhom,
    ':operation'=>$operation
    ]);

    if($result2){
        echo 1;
    }else{
        echo 0;
    }

?>