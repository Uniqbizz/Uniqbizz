<?php
    require '../../connect.php';
    $date = date('Y'); 

    $id = $_GET['vkvbvjfgfikix'];
    $user_id = $_GET['fyfyfregby'];
    $reference_no = $_GET['nohbref'];
    $country_id = $_GET['ncy'];
    $state_id = $_GET['mst'];
    $city_id = $_GET['hct'];
    $user_type = $_GET['usertype'];
    $comp_check= '';
    $editfor = $_GET['editfor'];

    if ($user_type == 'tc') {
        if($editfor == 'pending'){
            // $identifier_id= $_POST["vkvbvjfgfikix"];
            $identifier_name = 'id=';
        }else if($editfor == 'registered') {
            // $identifier_id= $_POST["vkvbvjfgfikix"];
            $identifier_name = 'ca_travelagency_id=';
        }

        $stmt = $conn->prepare("SELECT * FROM `ca_travelagency` where ca_travelagency_id='".$id."' OR id = '".$id."'");
        $stmt->execute();
        // set the resulting array to associative
        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        if($stmt->rowCount()>0){
            foreach (($stmt->fetchAll()) as $key => $row) {
                $fid=$row['id'];
                // $sales_manager_name=$row['fname'];
                $firstname=$row['firstname'];
                // $username=$row['username'];
                $lastname=$row['lastname'];
                $nominee_name=$row['nominee_name'];
                $nominee_relation=$row['nominee_relation'];
                $email=$row['email'];
                $contact_no=$row['contact_no'];
                // $business_package=$row['business_package'];
                $payment_fee=$row['amount'];
                $reference_no = $row['reference_no'];
                // $gst_no=$row['gst_no'];
                $date_of_birth=$row['date_of_birth'];
                $gender=$row['gender'];
                $country=$row['country'];
                $state=$row['state'];
                $city=$row['city'];
                $address=$row['address'];
                // $id_proof=$row['id_proof'];
                $profile_pic=$row['profile_pic'];
                // $kyc=$row['kyc'];
                $pan_card=$row['pan_card'];
                $aadhar_card=$row['aadhar_card'];
                $voting_card=$row['voting_card'];
                $bank_passbook=$row['passbook'];
                $payment_proof=$row['payment_proof'];
                $payment_mode=$row['payment_mode'];
                $cheque_no=$row['cheque_no'];
                $cheque_date=$row['cheque_date'];
                $bank_name=$row['bank_name'];
                $transaction_no=$row['transaction_no'];
                $pincode=$row['pincode'];
                $note=$row['note'];
                $comp_check=$row['comp_check'];
                // $complimentary=$row['complimentary'];
                // $converted=$row['converted'];

                //get country
                $countries = $conn->prepare("SELECT country_name FROM countries where id='".$country."' and status='1' ");
                $countries->execute();
                $countries->setFetchMode(PDO::FETCH_ASSOC);
                if($countries->rowCount()>0){
                    $country = $countries->fetch();
                    $countryname = $country['country_name'];
                }

                //get state
                $states = $conn->prepare("SELECT state_name FROM states where id='".$state."' and status='1' ");
                $states->execute();
                $states->setFetchMode(PDO::FETCH_ASSOC);
                if($states->rowCount()>0){
                    $state = $states->fetch();
                    $statename = $state['state_name'];
                }
                //get city
                $cities = $conn->prepare("SELECT city_name FROM cities where id='".$city."' and status='1' ");
                $cities->execute();
                $cities->setFetchMode(PDO::FETCH_ASSOC);
                if($cities->rowCount()>0){
                    $city = $cities->fetch();
                    $city_name = $city['city_name'];
                }

                $reference_id = (substr($reference_no, 0, 1) === 'F') 
                                ? substr($reference_no, 0, 1) 
                                : substr($reference_no, 0, 2);
                if($reference_id == "BM"){
                    // business Mentor name
                    $business_mentors = $conn->prepare("SELECT firstname, lastname FROM business_mentor where business_mentor_id='".$reference_no."'");
                    $business_mentors ->execute();
                    $business_mentors ->setFetchMode(PDO::FETCH_ASSOC);
                    if(  $business_mentors->rowCount()>0 ){
                        $business_mentor = $business_mentors->fetch();
                        $reference_no_fname = $business_mentor['firstname'];
                        $reference_no_lname = $business_mentor['lastname'];
                    }
                }else if($reference_id == "BH"){
                    // business Mentor name
                    $business_mentors = $conn->prepare("SELECT name FROM employees where employee_id='".$reference_no."'");
                    $business_mentors ->execute();
                    $business_mentors ->setFetchMode(PDO::FETCH_ASSOC);
                    if(  $business_mentors->rowCount()>0 ){
                        $business_mentor = $business_mentors->fetch();
                        $ref_fullname=$business_mentor['name'];
                        $parts = explode(' ', trim($ref_fullname));
                        $reference_no_fname = implode(' ', $parts);
                        $reference_no_lname = array_pop($parts);
                    }
                }
                else if($reference_id == "TE" || $reference_id == "CA"){
                    // corporate agency name
                    $corporate_agencys = $conn->prepare("SELECT firstname, lastname FROM corporate_agency where corporate_agency_id='".$reference_no."'");
                    $corporate_agencys ->execute();
                    $corporate_agencys ->setFetchMode(PDO::FETCH_ASSOC);
                    if(  $corporate_agencys->rowCount()>0 ){
                        $corporate_agencys = $corporate_agencys->fetch();
                        $reference_no_fname = $corporate_agencys['firstname'];
                        $reference_no_lname = $corporate_agencys['lastname'];
                    }
                }else if($reference_id == "F"){
                    // corporate agency name
                    $corporate_agencys = $conn->prepare("SELECT firstname, lastname FROM sub_franchisee where sub_franchisee_id='".$reference_no."'");
                    $corporate_agencys ->execute();
                    $corporate_agencys ->setFetchMode(PDO::FETCH_ASSOC);
                    if(  $corporate_agencys->rowCount()>0 ){
                        $corporate_agencys = $corporate_agencys->fetch();
                        $reference_no_fname = $corporate_agencys['firstname'];
                        $reference_no_lname = $corporate_agencys['lastname'];
                    }
                }else if($reference_id == "MF"){
                    // corporate agency name
                    $corporate_agencys = $conn->prepare("SELECT firstname,lastname FROM master_franchisee where master_franchisee_id='".$reference_no."'");
                    $corporate_agencys ->execute();
                    $corporate_agencys ->setFetchMode(PDO::FETCH_ASSOC);
                    if(  $corporate_agencys->rowCount()>0 ){
                        $corporate_agencys = $corporate_agencys->fetch();
                        $reference_no_fname = $corporate_agencys['firstname'];
                        $reference_no_lname = $corporate_agencys['lastname'];
                    }
                }
                else if($reference_id == "NA"){
                    $reference_no_fname = "Not Applicable";
                    $reference_no_lname = "";
                }
            }
        }
    }elseif ($user_type == 'ibr') {
        if($editfor == 'pending'){
            // $identifier_id= $_POST["vkvbvjfgfikix"];
            $identifier_name = 'id=';
        }else if($editfor == 'registered') {
            // $identifier_id= $_POST["vkvbvjfgfikix"];
            $identifier_name = 'institution_branch_manager_id=';
        }

        $stmt = $conn->prepare("SELECT * FROM `institution_branch_manager` where institution_branch_manager_id='".$id."' OR id = '".$id."'");
        $stmt->execute();
        // set the resulting array to associative
        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        if($stmt->rowCount()>0){
            foreach (($stmt->fetchAll()) as $key => $row) {
                $fid=$row['id'];
                $firstname=$row['firstname'];
                $lastname=$row['lastname'];
                $nominee_name=$row['nominee_name'];
                $nominee_relation=$row['nominee_relation'];
                $email=$row['email'];
                $contact_no=$row['contact_no'];
                $payment_fee=$row['amount'];
                $reference_no = $row['reference_no'];
                $date_of_birth=$row['date_of_birth'];
                $gender=$row['gender'];
                $country=$row['country'];
                $state=$row['state'];
                $city=$row['city'];
                $address=$row['address'];
                $profile_pic=$row['profile_pic'];
                $pan_card=$row['pan_card'];
                $aadhar_card=$row['aadhar_card'];
                $voting_card=$row['voting_card'];
                $bank_passbook=$row['passbook'];
                $payment_proof=$row['payment_proof'];
                $payment_mode=$row['payment_mode'];
                $cheque_no=$row['cheque_no'];
                $cheque_date=$row['cheque_date'];
                $bank_name=$row['bank_name'];
                $transaction_no=$row['transaction_no'];
                $pincode=$row['pincode'];
                $note=$row['note'];
                $comp_check=$row['comp_check'];

                //get country
                $countries = $conn->prepare("SELECT country_name FROM countries where id='".$country."' and status='1' ");
                $countries->execute();
                $countries->setFetchMode(PDO::FETCH_ASSOC);
                if($countries->rowCount()>0){
                    $country = $countries->fetch();
                    $countryname = $country['country_name'];
                }

                //get state
                $states = $conn->prepare("SELECT state_name FROM states where id='".$state."' and status='1' ");
                $states->execute();
                $states->setFetchMode(PDO::FETCH_ASSOC);
                if($states->rowCount()>0){
                    $state = $states->fetch();
                    $statename = $state['state_name'];
                }
                //get city
                $cities = $conn->prepare("SELECT city_name FROM cities where id='".$city."' and status='1' ");
                $cities->execute();
                $cities->setFetchMode(PDO::FETCH_ASSOC);
                if($cities->rowCount()>0){
                    $city = $cities->fetch();
                    $city_name = $city['city_name'];
                }

                $reference_id = substr($reference_no, 0, 1);
                if($reference_id == "I"){
                    // institution name
                    $institution = $conn->prepare("SELECT firstname, lastname FROM institution where institution_id='".$reference_no."'");
                    $institution ->execute();
                    $institution ->setFetchMode(PDO::FETCH_ASSOC);
                    if(  $institution->rowCount()>0 ){
                        $business_mentor = $institution->fetch();
                        $reference_no_fname = $business_mentor['firstname'];
                        $reference_no_lname = $business_mentor['lastname'];
                    }
                }
            }
        }
    }
    
?>