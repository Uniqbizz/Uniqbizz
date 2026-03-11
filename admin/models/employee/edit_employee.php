<?php
    require '../../connect.php';
    include __DIR__ . '/../common_models/get_table_user_type.php'; //refers to current directory
    $date = date('Y');

    $id = $_GET['vkvbvjfgfikix'];
    $user_id = $_GET['fyfyfregby'];
    $reference_no = $_GET['nohbref'];
    $dept = $_GET['dept'];
    $desig = $_GET['desig'];
    $zn = $_GET['zn'];
    $br = $_GET['br'];
    $usertype=$_GET['usertype'];
    

    $editfor = $_GET['editfor'];
    $transfer_check=$_GET['tr_check']??0;
    $transfer_status=0;

    if ($editfor == 'pending') {
        // $identifier_id= $_POST["vkvbvjfgfikix"];
        $identifier_name = 'id=';
    } else if ($editfor == 'registered') {
        // $identifier_id= $_POST["vkvbvjfgfikix"];
        $identifier_name = 'employee_id=';
    }
    // 0. Fetch transfer request pending load
    $sql = "SELECT pending_payload,transfer_status FROM transfered_users WHERE transfer_user_id ='". $id."' AND transfer_status=1";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $employees = $stmt->fetchAll();
    
    if (!empty($employees)) {
        foreach ($employees as $row) {
            // Decode the JSON payload
            $payload = json_decode($row['pending_payload'], true); // true = associative array

            // Extract table info (optional)
            $table = $payload['table'] ?? null;
            $identifier_column = $payload['identifier_column'] ?? null;
            $identifier_id = $payload['identifier_id'] ?? null;

            // Extract updated data
            $update_data = $payload['update_data'] ?? [];

            $fid = $update_data['id'] ?? null;
            $name = $update_data['name'] ?? null;
            $update_data = $payload['update_data'] ?? [];
            $email = $update_data['email'] ?? null;
            $update_data_prev = json_decode($update_data['prev_user_data'], true);
            $contact = $update_data['contact']?? $update_data_prev['contact'] ?? null;
            $country_cd = $update_data['country_code'] ??$update_data_prev['country_code'] ?? null;
            $reporting_manager_id = $update_data_prev['reporting_manager'] ?? null;
            $date_of_birth = $update_data['date_of_birth'] ??$update_data_prev['date_of_birth'] ?? null;
            $date_of_joining = $update_data['date_of_joining'] ??$update_data_prev['date_of_joining'] ?? null;
            $gender = $update_data['gender'] ??$update_data_prev['gender'] ?? null;

            // Department / Designation / Zone / Branch (nested in JSON)
            //get dept
            $departmentname = $update_data_prev['dept_name'] ?? ($update_data_prev['department']['dept_name'] ?? null);
            $departments = $conn->prepare("SELECT id FROM department where dept_name='" . $departmentname . "' and status='1' ");
            $departments->execute();
            $departments->setFetchMode(PDO::FETCH_ASSOC);
            if ($departments->rowCount() > 0) {
                $department = $departments->fetch();
                $dept = $department['id'];
            }

            //get desig
            $designationname = $update_data_prev['designation_name']??($update_data_prev['designation']['designation_name'] ?? null);
            $designations = $conn->prepare("SELECT id FROM designation where designation_name='" . $designationname. "' and status='1' ");
            $designations->execute();
            $designations->setFetchMode(PDO::FETCH_ASSOC);
            if ($designations->rowCount() > 0) {
                $designation = $designations->fetch();
                $desig = $designation['id'];
            }
            //get zone
            $zone_name = $update_data_prev['zone_name']?? ($update_data_prev['zone']['zone_name'] ?? null);
            $zones = $conn->prepare("SELECT id FROM zone where zone_name='" .$zone_name . "' and status='1' ");
            $zones->execute();
            $zones->setFetchMode(PDO::FETCH_ASSOC);
            if ($zones->rowCount() > 0) {
                $zone = $zones->fetch();
                $zn = $zone['id'];
            }

            //get branch
            $branch_name = $update_data_prev['branch_name'] ?? ($update_data_prev['branch']['branch_name'] ?? null);
            $branchs = $conn->prepare("SELECT id FROM branch where branch_name='" . $branch_name . "' and status='1' ");
            $branchs->execute();
            $branchs->setFetchMode(PDO::FETCH_ASSOC);
            if ($branchs->rowCount() > 0) {
                $branch = $branchs->fetch();
                $br = $branch['id'];
            }

            // Get Reporting Manager Name
            if ($reporting_manager_id == 'null' || empty($reporting_manager_id)) {
                $reporting_manager_name = 'Not Selected';
            } else {
                $reporting_managers = $conn->prepare("SELECT * FROM employees WHERE employee_id = :reporting_manager");
                $reporting_managers->execute(['reporting_manager' => $reporting_manager_id]);
                $reporting_managers->setFetchMode(PDO::FETCH_ASSOC);
                if ($reporting_managers->rowCount() > 0) {
                    $reporting_manager = $reporting_managers->fetch();
                    $reporting_manager_name = $reporting_manager['name'];
                }
            }
            

            $address = $update_data['address'] ?? $update_data_prev['address'] ?? null;
            $profile_pic = $update_data['profile_pic'] ?? $update_data_prev['profile_pic'] ?? null;
            $id_proof = $update_data['id_proof'] ?? $update_data_prev['id_proof'] ?? null;
            $bank_details = $update_data['bank_details'] ?? $update_data_prev['bank_details'] ?? null;
            $register_by = $update_data['register_by'] ?? $update_data_prev['register_by'] ?? null;
            $user_type = $update_data['user_type'] ?? $update_data_prev['user_type'] ?? null;
            $register_date = $update_data['register_date'] ?? $update_data_prev['register_date'] ?? null;
            $note = $update_data['note'] ?? $update_data_prev['note'] ?? null;

            // Extract login data if needed
            $login_data = $payload['login_data'] ?? [];
            $username = $login_data['username'] ?? null;
            $user_id = $login_data['user_id'] ?? null;

            $transfer_status=$row['transfer_status'];
            echo $transfer_status;
        }
    }else{
        if($usertype == 27){
            $stmt = $conn->prepare("SELECT * FROM `zonal_manager` where zonal_manager_id='" . $id . "' OR id = '" . $id . "'");
            $stmt->execute();
            // set the resulting array to associative
            $stmt->setFetchMode(PDO::FETCH_ASSOC);

            if ($stmt->rowCount() > 0) {
                foreach (($stmt->fetchAll()) as $key => $row) {
                    $fid = $row['id'];
                    $name = $row['name'];
                    $email = $row['email'];
                    $contact = $row['contact'];
                    $date_of_birth = $row['date_of_birth'];
                    $gender = $row['gender'];
                    $country = $row['country'];
                    $country_cd = $row['country_code'];
                    $state = $row['state'];
                    $city = $row['city'];
                    $pincode = $row['pincode'];
                    $zone = $row['zone'];
                    $address = $row['address'];
                    $profile_pic = $row['profile_pic'];
                    $pan_card = $row['pan_card'];
                    $aadhar_card = $row['aadhar_card'];
                    $bank_details = $row['bank_passbook'];
                    $register_by = $row['register_by'];
                    $user_type = $row['user_type'];
                    $register_date = $row['register_date'];
                    $note = $row['note'];

                    //get zone
                    $zones = $conn->prepare("SELECT id,zone FROM zonal where id='" . $zone . "' and status='1' ");
                    $zones->execute();
                    $zones->setFetchMode(PDO::FETCH_ASSOC);
                    if ($zones->rowCount() > 0) {
                        $zone = $zones->fetch();
                        $zone_name = $zone['zone'];
                        $zone_id = $zone['id'];
                    }
                    //get country
                    $country_stmt = $conn->prepare("SELECT id,country_name FROM countries where id='" . $country . "' and status='1' ");
                    $country_stmt->execute();
                    $country_stmt->setFetchMode(PDO::FETCH_ASSOC);
                    if ($country_stmt->rowCount() > 0) {
                        $country_res = $country_stmt->fetch();
                        $country_name = $country_res['country_name'];
                        $country_id =$country_res['id'];
                    }
                    
                    //get state
                    $states = $conn->prepare("SELECT id,state_name FROM states where id='" . $state . "' and status='1' ");
                    $states->execute();
                    $states->setFetchMode(PDO::FETCH_ASSOC);
                    if ($states->rowCount() > 0) {
                        $state = $states->fetch();
                        $state_name = $state['state_name'];
                        $state_id = $state['id'];
                    }
                    //get city
                    $citys = $conn->prepare("SELECT id,city_name FROM cities where id='" . $city . "' and status='1' ");
                    $citys->execute();
                    $citys->setFetchMode(PDO::FETCH_ASSOC);
                    if ($citys->rowCount() > 0) {
                        $city = $citys->fetch();
                        $city_name = $city['city_name'];
                        $city_id = $city['id'];
                    }

                }
            }
        }else{
            $stmt = $conn->prepare("SELECT * FROM `employees` where employee_id='" . $id . "' OR id = '" . $id . "'");
            $stmt->execute();
            // set the resulting array to associative
            $stmt->setFetchMode(PDO::FETCH_ASSOC);

            if ($stmt->rowCount() > 0) {
                foreach (($stmt->fetchAll()) as $key => $row) {
                    $fid = $row['id'];
                    $name = $row['name'];
                    $email = $row['email'];
                    $contact = $row['contact'];
                    $country_cd = $row['country_code'];
                    $reporting_manager_id = $row['reporting_manager'];
                    $date_of_birth = $row['date_of_birth'];
                    $date_of_joining = $row['date_of_joining'];
                    $gender = $row['gender'];
                    $department = $row['department'];
                    $designation = $row['designation'];
                    $zone = $row['zone'];
                    $branch = $row['branch'];
                    $address = $row['address'];
                    $profile_pic = $row['profile_pic'];
                    $id_proof = $row['id_proof'];
                    $bank_details = $row['bank_details'];
                    $register_by = $row['register_by'];
                    $user_type = $row['user_type'];
                    $register_date = $row['register_date'];
                    $note = $row['note'];

                    //get country
                    $departments = $conn->prepare("SELECT dept_name FROM department where id='" . $dept . "' and status='1' ");
                    $departments->execute();
                    $departments->setFetchMode(PDO::FETCH_ASSOC);
                    if ($departments->rowCount() > 0) {
                        $department = $departments->fetch();
                        $departmentname = $department['dept_name'];
                    }

                    //get state
                    $designations = $conn->prepare("SELECT designation_name FROM designation where id='" . $desig . "' and status='1' ");
                    $designations->execute();
                    $designations->setFetchMode(PDO::FETCH_ASSOC);
                    if ($designations->rowCount() > 0) {
                        $designation = $designations->fetch();
                        $designationname = $designation['designation_name'];
                    }
                    //get city
                    $zones = $conn->prepare("SELECT zone_name FROM zone where id='" . $zn . "' and status='1' ");
                    $zones->execute();
                    $zones->setFetchMode(PDO::FETCH_ASSOC);
                    if ($zones->rowCount() > 0) {
                        $zone = $zones->fetch();
                        $zone_name = $zone['zone_name'];
                    }

                    //get city
                    $branchs = $conn->prepare("SELECT branch_name FROM branch where id='" . $br . "' and status='1' ");
                    $branchs->execute();
                    $branchs->setFetchMode(PDO::FETCH_ASSOC);
                    if ($branchs->rowCount() > 0) {
                        $branch = $branchs->fetch();
                        $branch_name = $branch['branch_name'];
                    }

                    // Get Reporting Manager Name
                    if ($reporting_manager_id == 'null' || empty($reporting_manager_id)) {
                        $reporting_manager_name = 'Not Selected';
                    } else {
                        $reporting_managers = $conn->prepare("SELECT * FROM employees WHERE employee_id = :reporting_manager");
                        $reporting_managers->execute(['reporting_manager' => $reporting_manager_id]);
                        $reporting_managers->setFetchMode(PDO::FETCH_ASSOC);
                        if ($reporting_managers->rowCount() > 0) {
                            $reporting_manager = $reporting_managers->fetch();
                            $reporting_manager_name = $reporting_manager['name'];
                        }
                    }
                
                }
                $prev_user_data = [
                    "id" => $fid,
                    "name" => $name,
                    "email" => $email,
                    "contact" => $contact,
                    "country_code" => $country_cd,
                    "reporting_manager" => $reporting_manager_id,
                    "date_of_birth" => $date_of_birth,
                    "date_of_joining" => $date_of_joining,
                    "gender" => $gender,
                    "department" => $department,
                    "department_name" => $departmentname,
                    "designation" => $designation,
                    "designation_name" => $designationname,
                    "zone" => $zone,
                    "zone_name" => $zone_name,
                    "branch" => $branch,
                    "branch_name" => $branch_name,
                    "address" => $address,
                    "profile_pic" => $profile_pic,
                    "id_proof" => $id_proof,
                    "bank_details" => $bank_details,
                    "register_by" => $register_by,
                    "user_type" => $user_type,
                    "register_date" => $register_date,
                    "note" => $note
                ];
            }   
        }
    }

    
    
?>