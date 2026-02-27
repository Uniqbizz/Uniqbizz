<?php
    require '../../connect.php';
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

    if ($editfor == 'pending') {
        // $identifier_id= $_POST["vkvbvjfgfikix"];
        $identifier_name = 'id=';
    } else if ($editfor == 'registered') {
        // $identifier_id= $_POST["vkvbvjfgfikix"];
        $identifier_name = 'employee_id=';
    }

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

                //get city
                $employees = $conn->prepare("SELECT name FROM employees where employee_id='" . $reference_no . "' and status='1' ");
                $employees->execute();
                $employees->setFetchMode(PDO::FETCH_ASSOC);
                if ($employees->rowCount() > 0) {
                    $employee = $employees->fetch();
                    $employee_name = $employee['name'];
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
        }   
    }
?>