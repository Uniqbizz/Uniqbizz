<?php 
    $date = date('Y');

    $id = $_GET['id'];
    $ref = $_GET['ref'];
    $tamount='';
    $initial_inv='';
    $DBtable = $_GET['message'];
    $designation = $_GET['designation'];

    if ($DBtable == 'business_consultant') { // 3
        $sql = "SELECT * FROM business_consultant WHERE business_consultant_id = '" . $id . "' AND status = '1'";
    } else if ($DBtable == 'business_trainee') { // 15
        $sql = "SELECT * FROM business_trainee WHERE business_trainee_id = '" . $id . "' AND status = '1'";
    } else if ($DBtable == 'corporate_agency') { // 16
        $sql = "SELECT * FROM corporate_agency WHERE corporate_agency_id = '" . $id . "' AND status = '1'";
    } else if ($DBtable == 'ca_travelagency') { // 11
        $sql = "SELECT * FROM ca_travelagency WHERE ca_travelagency_id = '" . $id . "' AND status = '1'";
    } else if ($DBtable == 'channel_business_director') { // 18
        $sql = "SELECT * FROM channel_business_director WHERE channel_business_director_id = '" . $id . "' AND status = '1'";
    } else if ($DBtable == 'ca_customer') { // 10
        $sql = "SELECT * FROM ca_customer WHERE ca_customer_id = '" . $id . "' AND status = '1'";
    } else if ($DBtable == 'business_chanel_manager') { // 24,
        $sql = "SELECT * FROM employees WHERE employee_id = '" . $id . "' AND status = '1' AND user_type=24";
    } else if ($DBtable == 'business_developement_manager') { // 25
        $sql = "SELECT * FROM employees WHERE employee_id = '" . $id . "' AND status = '1' AND user_type=25";
    } 
    else if ($DBtable == 'business_mentor') { // 26
        $sql = "SELECT * FROM business_mentor WHERE business_mentor_id = '" . $id . "' AND status = '1'";
    }
    else if ($DBtable == 'master_franchisee') { // 28
        $sql = "SELECT * FROM master_franchisee WHERE master_franchisee_id = '" . $id . "' AND status = '1'";
    }
    else if ($DBtable == 'sponsor_franchisee') { // 30
        $sql = "SELECT * FROM sponsor_franchisee WHERE sponsor_franchisee_id = '" . $id . "' AND status = '1'";
    }
    else if ($DBtable == 'sub_franchisee') { // 29
        $sql = "SELECT * FROM sub_franchisee WHERE sub_franchisee_id = '" . $id . "' AND status = '1'";

    }
    else if ($DBtable == 'institution'){ // 32
        $sql = "SELECT * FROM institution WHERE institution_id = '" . $id . "' AND status = '1'";
    }
    else if ($DBtable == 'zonal_manager') { // 27
        $sql = "SELECT * FROM zonal_manager WHERE zonal_manager_id = '" . $id . "' AND status = '1'";
    }
    else if ($DBtable == 'relationship_manager') { // 31
        $sql = "SELECT * FROM employees WHERE employee_id = '" . $id . "' AND status = '1' AND user_type=31";
    } else if ($DBtable == 'institution_branch_manager') { // 33
        $sql = "SELECT * FROM institution_branch_manager WHERE institution_branch_manager_id = '" . $id . "' AND status = '1'";
    }
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $reporting_manager_name = '';
    $customer_type='';
    if ($stmt->rowCount() > 0) {
        $statename='';
        $countryname='';
        $cityname='';
        $pincode='';
        $aadhar_card ='';
        foreach (($stmt->fetchAll()) as $key => $row) {
            if ($DBtable == 'business_developement_manager' || $DBtable == 'business_chanel_manager' || $DBtable == 'relationship_manager') {
                $bank_passbook='';
                $pan_card='';
                $fid = $row['id'];
                $name = $row['name'];
                $email = $row['email'];
                $country_code = $row['country_code'];
                $contact_no =$row['contact'];
                $reporting_manager_id = $row['reporting_manager'];
                $date_of_birth = $row['date_of_birth'];
                $date_of_joining = $row['date_of_joining'];
                $gender = $row['gender'];
                $department = $row['department'];
                $design = $row['designation'];
                $zone = $row['zone'];
                $branch = $row['branch'];
                $address = $row['address'];
                $profile_pic = $row['profile_pic'];
                $id_proof = $row['id_proof'];
                $bank_details = $row['bank_details'];
                $register_by = $row['register_by'];
                $user_type = $row['user_type'];
                // $register_date=$row['register_date'];
                $rd = new DateTime($row['register_date']);
                $rdate = $rd->format('d-m-Y');

                //get country
                $departments = $conn->prepare("SELECT dept_name FROM department where id='" . $department . "' and status='1' ");
                $departments->execute();
                $departments->setFetchMode(PDO::FETCH_ASSOC);
                if ($departments->rowCount() > 0) {
                    $department = $departments->fetch();
                    $departmentname = $department['dept_name'];
                }

                //get state
                $designations = $conn->prepare("SELECT designation_name FROM designation where id='" . $design . "' and status='1' ");
                $designations->execute();
                $designations->setFetchMode(PDO::FETCH_ASSOC);
                if ($designations->rowCount() > 0) {
                    $desig = $designations->fetch();
                    $designation = $desig['designation_name'];
                }
                //get city
                $zones = $conn->prepare("SELECT zone_name FROM zone where id='" . $zone . "' and status='1' ");
                $zones->execute();
                $zones->setFetchMode(PDO::FETCH_ASSOC);
                if ($zones->rowCount() > 0) {
                    $zone = $zones->fetch();
                    $zone_name = $zone['zone_name'];
                }

                //get city
                $branchs = $conn->prepare("SELECT branch_name FROM branch where id='" . $branch . "' and status='1' ");
                $branchs->execute();
                $branchs->setFetchMode(PDO::FETCH_ASSOC);
                if ($branchs->rowCount() > 0) {
                    $branch = $branchs->fetch();
                    $branch_name = $branch['branch_name'];
                }

                //get city
                $employees = $conn->prepare("SELECT name FROM employees where employee_id='" . $reporting_manager_id . "' and status='1' ");
                $employees->execute();
                $employees->setFetchMode(PDO::FETCH_ASSOC);
                if ($employees->rowCount() > 0) {
                    $employee = $employees->fetch();
                    $employee_name = $employee['name'];
                }

                // Get Reporting Manager Name

                if (is_null($reporting_manager_id)) {
                    $reporting_manager_name = 'Not Applicable';
                } else {
                    $reporting_managers = $conn->prepare("SELECT * FROM employees WHERE employee_id = :reporting_manager");
                    $reporting_managers->execute(['reporting_manager' => $reporting_manager_id]);
                    $reporting_managers->setFetchMode(PDO::FETCH_ASSOC);
                    if ($reporting_managers->rowCount() > 0) {
                        $reporting_manager = $reporting_managers->fetch();
                        $reporting_manager_name = $reporting_manager['name'];
                    }
                }
                
            } else {
                if ($DBtable == 'sub_franchisee' || $DBtable == 'institution') {
                    $initial_inv = $row['amount'];
                }
                $customer_type= $DBtable == 'ca_customer'?$row['customer_type']:'';
                $rd = new DateTime($row['register_date']);
                $rdate = $rd->format('d-m-Y');
                $fid = $row['id'];
                if($DBtable == 'zonal_manager'){
                    $name = $row['name']; 
                    $nominee_name = 'NA';
                    $nominee_relation = 'NA';
                    $reference_no = 'NA';
                    $contact_no = $row['country_code'] . $row['contact'];
                    $registrant = 'NA';
                    $voting_card = 'NA';
                    $date_of_joining = 'NA';
                    $gender = 'NA';
                    $department = 'NA';
                    $design = 'NA';
                    $zone = 'NA';
                    $branch = 'NA';
                    $zone_name ='NA';
                    $branch_name ='NA';
                    $employee_name ='NA';
                    $departmentname ='NA';
                    $id_proof='NA';
                    $bank_details='NA';
                }else{
                    $firstname = $row['firstname'];
                    $lastname = $row['lastname'];
                    $nominee_name = $row['nominee_name'];
                    $nominee_relation = $row['nominee_relation'];
                    $reference_no = $row['reference_no']??'';
                    $contact_no = $row['country_code'] . $row['contact_no'];
                    $registrant = $row['registrant']??'';
                    $voting_card = $row['voting_card'];
                }
                $email = $row['email'];
                $date_of_birth = $row['date_of_birth'];
                $gender = $row['gender'];
                $country = $row['country'];
                $state = $row['state'];
                $city = $row['city'];
                $address = $row['address'];
                $profile_pic = $row['profile_pic'];
                $pan_card = $row['pan_card'];
                $aadhar_card = $row['aadhar_card'];
                
                // bank passbook field name changed in ca_travelagency table
                if ($DBtable == 'ca_travelagency' || $DBtable == 'ca_customer' || $DBtable == 'institution_branch_manager') {
                    $bank_passbook = $row['passbook'];
                } else {
                    $bank_passbook = $row['bank_passbook'];
                }

                if ($DBtable == 'corporate_agency' || $DBtable == 'ca_travelagency' || $DBtable == 'ca_customer' || $DBtable == 'institution_branch_manager') {
                    $payment_proof = $row['payment_proof'];
                    $payment_mode = $row['payment_mode'];
                    $cheque_no = $row['cheque_no'];
                    $cheque_date = $row['cheque_date'];
                    $bank_name = $row['bank_name'];
                    $transaction_no = $row['transaction_no'];
                }
                if ($DBtable == 'ca_customer') {
                    $ta_ref_no = $row['ta_reference_no'];
                    $ta_name = $row['ta_reference_name'];
                }

                $pincode = $row['pincode'];
                //get country
                $countries = $conn->prepare("SELECT country_name FROM countries where id='" . $country . "' and status='1' ");
                $countries->execute();
                $countries->setFetchMode(PDO::FETCH_ASSOC);
                if ($countries->rowCount() > 0) {
                    $country = $countries->fetch();
                    $countryname = $country['country_name'];
                }

                //get state
                $states = $conn->prepare("SELECT state_name FROM states where id='" . $state . "' and status='1' ");
                $states->execute();
                $states->setFetchMode(PDO::FETCH_ASSOC);
                if ($states->rowCount() > 0) {
                    $state = $states->fetch();
                    $statename = $state['state_name'];
                }
                //get city
                $cities = $conn->prepare("SELECT city_name FROM cities where id='" . $city . "' and status='1' ");
                $cities->execute();
                $cities->setFetchMode(PDO::FETCH_ASSOC);
                if ($cities->rowCount() > 0) {
                    $city = $cities->fetch();
                    $cityname = $city['city_name'];
                }
            }
        }
    }
    $User_name = ($DBtable == 'business_developement_manager' || $DBtable == 'business_chanel_manager' || $DBtable == 'zonal_manager' || $DBtable == 'relationship_manager') ? $name : $firstname . ' ' . $lastname;

?>