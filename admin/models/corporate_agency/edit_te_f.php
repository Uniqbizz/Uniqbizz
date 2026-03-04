<?php

require '../../connect.php';

$id = $_GET['vkvbvjfgfikix'];
$user_id = $_GET['fyfyfregby'];
$reference_no = $_GET['nohbref'];
$country_id = $_GET['ncy'];
$state_id = $_GET['mst'];
$city_id = $_GET['hct'];
$reference_id = '';
$user_type=$_GET['usertype'];

$editfor = $_GET['editfor'];
//corporate_agency
if($user_type == 'te'){
    $stmt = $conn->prepare("SELECT * FROM `corporate_agency` where corporate_agency_id='" . $id . "' OR id = '" . $id . "'");
    $stmt->execute();
    // set the resulting array to associative
    $stmt->setFetchMode(PDO::FETCH_ASSOC);

    if ($stmt->rowCount() > 0) {
        foreach (($stmt->fetchAll()) as $key => $row) {
            $fid = $row['id'];
            // $sales_manager_name=$row['fname'];
            $firstname = $row['firstname'];
            // $username=$row['username'];
            $lastname = $row['lastname'];
            $nominee_name = $row['nominee_name'];
            $nominee_relation = $row['nominee_relation'];
            $email = $row['email'];
            $contact_no = $row['contact_no'];
            $note=$row['note'];
            $converted = $row['converted'];
            $amount = $row['amount'];
            $amtGST = $row['amtGST'];
            $reference_no = $row['reference_no'];
            $gst_no = $row['gst_no'];
            $date_of_birth = $row['date_of_birth'];
            $gender = $row['gender'];
            $country = $row['country'];
            $state = $row['state'];
            $city = $row['city'];
            $address = $row['address'];
            $payment_mode = $row['payment_mode'];
            $cheque_no = $row['cheque_no'];
            $cheque_date = $row['cheque_date'];
            $bank_name = $row['bank_name'];
            $transaction_no = $row['transaction_no'];
            // $id_proof=$row['id_proof'];
            $profile_pic = $row['profile_pic'];
            // $kyc=$row['kyc'];
            $pan_card = $row['pan_card'];
            $aadhar_card = $row['aadhar_card'];
            $voting_card = $row['voting_card'];
            $bank_passbook = $row['bank_passbook'];
            $payment_proof = $row['payment_proof'];
            $pincode = $row['pincode'];
            $status=$row['status'];
            $assign_status=$row['tc_assign_status']??null;
            $assign_TCs=$row['no_tc_alloted']??null;
            $assign_tenure=$row['repay_tenure']??null;
            $assign_roi=$row['roi']??null;
            $assign_tax=$row['tax']??null;
            $assign_repay_amount=$row['repay_amount']??null;
            // $complimentary=$row['complimentary'];
            // $converted=$row['converted'];

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
                $city_name = $city['city_name'];
            }
            //#3
            $reference_id = substr($reference_no, 0, 2);
            if ($reference_id == "BM") {
                // business Mentor name
                $business_mentors = $conn->prepare("SELECT firstname, lastname, reference_no FROM business_mentor where business_mentor_id='" . $reference_no . "'");
                $business_mentors->execute();
                $business_mentors->setFetchMode(PDO::FETCH_ASSOC);
                if ($business_mentors->rowCount() > 0) {
                    $business_mentor = $business_mentors->fetch();
                    $reference_no_fname = $business_mentor['firstname'];
                    $reference_no_lname = $business_mentor['lastname'];
                    // $business_trainees_reference_no = $business_trainee['reference_no'];
                }
            } else if ($reference_id == "BH") {
                // business development manger name
                $business_development_manager = $conn->prepare("SELECT name, employee_id FROM employees where employee_id='" . $reference_no . "'");
                $business_development_manager->execute();
                $business_development_manager->setFetchMode(PDO::FETCH_ASSOC);
                if ($business_development_manager->rowCount() > 0) {
                    $business_development_manager = $business_development_manager->fetch();
                    $reference_no_name = $business_development_manager['name'];
                    // $business_trainees_reference_no = $business_trainee['reference_no'];
                }
            } else {
                // business_consultant name
                $business_consultants = $conn->prepare("SELECT firstname, lastname FROM business_consultant where business_consultant_id='" . $reference_no . "'");
                $business_consultants->execute();
                $business_consultants->setFetchMode(PDO::FETCH_ASSOC);
                if ($business_consultants->rowCount() > 0) {
                    $business_consultants = $business_consultants->fetch();
                    $reference_no_fname = $business_consultants['firstname'];
                    $reference_no_lname = $business_consultants['lastname'];
                }
            }
        }
    }
}
//sub_franchisee
else if($user_type == 'sf'){
    $stmt = $conn->prepare("SELECT * FROM `sub_franchisee` where sub_franchisee_id='" . $id . "' OR id = '" . $id . "'");
    $stmt->execute();
    // set the resulting array to associative
    $stmt->setFetchMode(PDO::FETCH_ASSOC);

    if ($stmt->rowCount() > 0) {
        foreach (($stmt->fetchAll()) as $key => $row) {
            $fid = $row['id'];
            // $sales_manager_name=$row['fname'];
            $firstname = $row['firstname'];
            // $username=$row['username'];
            $lastname = $row['lastname'];
            $nominee_name = $row['nominee_name'];
            $nominee_relation = $row['nominee_relation'];
            $email = $row['email'];
            $contact_no = $row['contact_no'];
            $note=$row['note'];
            $converted = $row['converted'];
            $amount = $row['amount'];
            $amtGST = $row['amtGST'];
            $reference_no = $row['reference_no'];
            $gst_no = $row['gst_no'];
            $date_of_birth = $row['date_of_birth'];
            $gender = $row['gender'];
            $country = $row['country'];
            $state = $row['state'];
            $city = $row['city'];
            $address = $row['address'];
            $payment_mode = $row['payment_mode'];
            $cheque_no = $row['cheque_no'];
            $cheque_date = $row['cheque_date'];
            $bank_name = $row['bank_name'];
            $transaction_no = $row['transaction_no'];
            // $id_proof=$row['id_proof'];
            $profile_pic = $row['profile_pic'];
            // $kyc=$row['kyc'];
            $pan_card = $row['pan_card'];
            $aadhar_card = $row['aadhar_card'];
            $voting_card = $row['voting_card'];
            $bank_passbook = $row['bank_passbook'];
            $payment_proof = $row['payment_proof'];
            $pincode = $row['pincode'];
            $status=$row['status'];
            $assign_status=$row['tc_assign_status']??null;
            $assign_TCs=$row['no_tc_alloted']??null;
            $assign_tenure=$row['repay_tenure']??null;
            $assign_roi=$row['roi']??null;
            $assign_tax=$row['tax']??null;
            $assign_repay_amount=$row['repay_amount']??null;
            $comm_per=$row['current_commission_per']??null;
            $ins_per=$row['current_incentive_per']??null;
            $f_status=$row['status'];
            // $complimentary=$row['complimentary'];
            // $converted=$row['converted'];

            if($f_status == '1'){
                // franchisee upgrade
                $f_upgrade = $conn->prepare("
                    SELECT upgrade_amt, new_commission_per, new_incentive_per 
                    FROM sub_franchisee_upgrade 
                    WHERE sub_franchisee_id = :id AND upgrade_status = '1' 
                    ORDER BY id DESC 
                    LIMIT 1
                ");
                $f_upgrade->execute([':id' => $id]);
                $f_upgrade->setFetchMode(PDO::FETCH_ASSOC);

                if ($f_upgrade->rowCount() > 0) {
                    $upgrade_f = $f_upgrade->fetch();

                    $amount   = $upgrade_f['upgrade_amt'];
                    $comm_per = $upgrade_f['new_commission_per'];
                    $ins_per  = $upgrade_f['new_incentive_per'];
                }
            }

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
                $city_name = $city['city_name'];
            }

            //#3
            $reference_id = substr($reference_no, 0, 2);
            if ($reference_id == "MF") {
                // business Mentor name
                $business_mentors = $conn->prepare("SELECT firstname, lastname, reference_no FROM master_franchisee where master_franchisee_id='" . $reference_no . "'");
                $business_mentors->execute();
                //print_r($business_mentors);
                $business_mentors->setFetchMode(PDO::FETCH_ASSOC);
                if ($business_mentors->rowCount() > 0) {
                    $business_mentor = $business_mentors->fetch();
                    $reference_no_fname = $business_mentor['firstname'];
                    $reference_no_lname = $business_mentor['lastname'];
                    // $business_trainees_reference_no = $business_trainee['reference_no'];
                }
            } else if ($reference_id == "SF") {
                // business development manger name
                $business_development_manager = $conn->prepare("SELECT firstname, lastname FROM sponsor_franchisee where sponsor_franchisee_id='" . $reference_no . "'");
                $business_development_manager->execute();
                $business_development_manager->setFetchMode(PDO::FETCH_ASSOC);
                if ($business_development_manager->rowCount() > 0) {
                    $business_development_manager = $business_development_manager->fetch();
                    $reference_no_fname = $business_development_manager['firstname'];
                    $reference_no_lname = $business_development_manager['lastname'];
                    // $business_trainees_reference_no = $business_trainee['reference_no'];
                }
            }
        }
    }
}
//institution
else if($user_type == 'in'){
    $stmt = $conn->prepare("SELECT * FROM `institution` where institution_id='" . $id . "' OR id = '" . $id . "'");
    $stmt->execute();
    // set the resulting array to associative
    $stmt->setFetchMode(PDO::FETCH_ASSOC);

    if ($stmt->rowCount() > 0) {
        foreach (($stmt->fetchAll()) as $key => $row) {
            $fid = $row['id'];
            // $sales_manager_name=$row['fname'];
            $firstname = $row['firstname'];
            // $username=$row['username'];
            $lastname = $row['lastname'];
            $nominee_name = $row['nominee_name'];
            $nominee_relation = $row['nominee_relation'];
            $email = $row['email'];
            $contact_no = $row['contact_no'];
            $note=$row['note'];
            $converted = $row['converted'];
            $amount = $row['amount'];
            $amtGST = $row['amtGST'];
            $reference_no = $row['reference_no'];
            $gst_no = $row['gst_no'];
            $date_of_birth = $row['date_of_birth'];
            $gender = $row['gender'];
            $country = $row['country'];
            $state = $row['state'];
            $city = $row['city'];
            $address = $row['address'];
            $payment_mode = $row['payment_mode'];
            $cheque_no = $row['cheque_no'];
            $cheque_date = $row['cheque_date'];
            $bank_name = $row['bank_name'];
            $transaction_no = $row['transaction_no'];
            // $id_proof=$row['id_proof'];
            $profile_pic = $row['profile_pic'];
            // $kyc=$row['kyc'];
            $pan_card = $row['pan_card'];
            $aadhar_card = $row['aadhar_card'];
            $voting_card = $row['voting_card'];
            $bank_passbook = $row['bank_passbook'];
            $payment_proof = $row['payment_proof'];
            $pincode = $row['pincode'];
            $status=$row['status'];
            $assign_status=$row['tc_assign_status']??null;
            $assign_TCs=$row['no_tc_alloted']??null;
            $assign_tenure=$row['repay_tenure']??null;
            $assign_roi=$row['roi']??null;
            $assign_tax=$row['tax']??null;
            $assign_repay_amount=$row['repay_amount']??null;
            $comm_per=$row['current_commission_per']??null;
            $ins_per=$row['current_incentive_per']??null;
            $f_status=$row['status'];
            // $complimentary=$row['complimentary'];
            // $converted=$row['converted'];

            if($f_status == '1'){
                // franchisee upgrade
                $f_upgrade = $conn->prepare("
                    SELECT upgrade_amt, new_commission_per, new_incentive_per 
                    FROM institution_upgrade 
                    WHERE institution_id = :id AND upgrade_status = '1' 
                    ORDER BY id DESC 
                    LIMIT 1
                ");
                $f_upgrade->execute([':id' => $id]);
                $f_upgrade->setFetchMode(PDO::FETCH_ASSOC);

                if ($f_upgrade->rowCount() > 0) {
                    $upgrade_f = $f_upgrade->fetch();

                    $amount   = $upgrade_f['upgrade_amt'];
                    $comm_per = $upgrade_f['new_commission_per'];
                    $ins_per  = $upgrade_f['new_incentive_per'];
                }
            }

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
                $city_name = $city['city_name'];
            }

            //#3
            $reference_id = substr($reference_no, 0, 2);
            if ($reference_id == "MF") {
                // business Mentor name
                $business_mentors = $conn->prepare("SELECT firstname, lastname, reference_no FROM master_franchisee where master_franchisee_id='" . $reference_no . "'");
                $business_mentors->execute();
                //print_r($business_mentors);
                $business_mentors->setFetchMode(PDO::FETCH_ASSOC);
                if ($business_mentors->rowCount() > 0) {
                    $business_mentor = $business_mentors->fetch();
                    $reference_no_fname = $business_mentor['firstname'];
                    $reference_no_lname = $business_mentor['lastname'];
                    // $business_trainees_reference_no = $business_trainee['reference_no'];
                }
            } else if ($reference_id == "SF") {
                // business development manger name
                $business_development_manager = $conn->prepare("SELECT firstname, lastname FROM sponsor_franchisee where sponsor_franchisee_id='" . $reference_no . "'");
                $business_development_manager->execute();
                $business_development_manager->setFetchMode(PDO::FETCH_ASSOC);
                if ($business_development_manager->rowCount() > 0) {
                    $business_development_manager = $business_development_manager->fetch();
                    $reference_no_fname = $business_development_manager['firstname'];
                    $reference_no_lname = $business_development_manager['lastname'];
                    // $business_trainees_reference_no = $business_trainee['reference_no'];
                }
            }
        }
    }
}


?>