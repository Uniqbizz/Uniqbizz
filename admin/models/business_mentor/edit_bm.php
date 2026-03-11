<?php

    require '../../connect.php';
    $date = date('Y'); 

    $id = $_GET['vkvbvjfgfikix'];
    $user_id = $_GET['fyfyfregby'];
    $reference_no = $_GET['nohbref'];
    $country_id = $_GET['ncy'];
    $state_id = $_GET['mst'];
    $city_id = $_GET['hct'];
    $zone_id = $_GET['zone'];
    $branch_id = $_GET['branch'];
    $editfor = $_GET['editfor'];
    $usertype = $_GET['usertype']; // 'MF' for master franchisee, 'BM' for business mentor
    $transfer_check=$_GET['tr_check']??0;

    if ($editfor == 'pending') {
        $identifier_name = 'id=';
    } else if ($editfor == 'registered') {
        $identifier_name = $usertype == 'MF' ? 'master_franchisee_id=' :($usertype == 'BM' ? 'business_mentor_id=' : ($usertype == 'SF' ? 'sponsor_franchisee_id=' : ''));
    }

    $testValue = $usertype == 'BM' ? '26' : ($usertype == 'MF' ? '28' : ($usertype == 'SF' ? '30' : ''));

    if ($usertype == 'MF') {
        $stmt = $conn->prepare("SELECT * FROM `master_franchisee` WHERE master_franchisee_id='" . $id . "' OR id = '" . $id . "'");
    } else if($usertype == 'BM') {
        $stmt = $conn->prepare("SELECT * FROM `business_mentor` WHERE business_mentor_id='" . $id . "' OR id = '" . $id . "'");
    } else if($usertype == 'SF') {
        $stmt = $conn->prepare("SELECT * FROM `sponsor_franchisee` WHERE sponsor_franchisee_id='" . $id . "' OR id = '" . $id . "'");
    }

    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);

    if ($stmt->rowCount() > 0) {
        foreach (($stmt->fetchAll()) as $row) {
            $fid = $row['id'];
            $firstname = $row['firstname'];
            $lastname = $row['lastname'];
            $nominee_name = $row['nominee_name'];
            $nominee_relation = $row['nominee_relation'];
            $email = $row['email'];
            $contact_no = $row['contact_no'];
            $paid_amount = $row['paid_amount'];
            $reference_no = $row['reference_no'];
            $date_of_birth = $row['date_of_birth'];
            $gender = $row['gender'];
            $country = $row['country'];
            $state = $row['state'];
            $city = $row['city'];
            $address = $row['address'];
            $zone = $row['zone'];
            $branch = $row['branch'];
            $profile_pic = $row['profile_pic'];
            $payment_mode = $row['payment_mode'];
            $payment_proof = $row['payment_proof'];
            $pan_card = $row['pan_card'];
            $aadhar_card = $row['aadhar_card'];
            $voting_card = $row['voting_card'];
            $bank_passbook = $row['bank_passbook'];
            $pincode = $row['pincode'];
            $cheque_no = $row['cheque_no'];
            $cheque_date = $row['cheque_date'];
            $bank_name = $row['bank_name'];
            $transaction_no = $row['transaction_no'];
            $note = $row['note'];

            // Get country name
            $countries = $conn->prepare("SELECT country_name FROM countries WHERE id='$country' AND status='1'");
            $countries->execute();
            if ($countries->rowCount() > 0) {
                $countryname = $countries->fetch()['country_name'];
            }

            // Get state name
            $states = $conn->prepare("SELECT state_name FROM states WHERE id='$state' AND status='1'");
            $states->execute();
            if ($states->rowCount() > 0) {
                $statename = $states->fetch()['state_name'];
            }

            // Get city name
            $cities = $conn->prepare("SELECT city_name FROM cities WHERE id='$city' AND status='1'");
            $cities->execute();
            if ($cities->rowCount() > 0) {
                $city_name = $cities->fetch()['city_name'];
            }

            // Get zone name
            $zones = $conn->prepare("SELECT zone_name FROM zone WHERE id='$zone' AND status='1'");
            $zones->execute();
            if ($zones->rowCount() > 0) {
                $zone_name = $zones->fetch()['zone_name'];
            }

            // Get branch name
            $branchs = $conn->prepare("SELECT branch_name FROM branch WHERE id='$branch' AND status='1'");
            $branchs->execute();
            if ($branchs->rowCount() > 0) {
                $branch_name = $branchs->fetch()['branch_name'];
            }

            // Get reporting manager (BM or ZM)
            if ($reference_no == "Not Applicable") {
                $reference_no_fname = "Not Applicable";
            } else {
                if ($usertype == 'MF') {
                    // Master Franchisee → Get reporting manager (Zonal Manager) from `zonal_manager` table
                    $stmt_manager = $conn->prepare("SELECT name FROM zonal_manager WHERE zonal_manager_id = :ref");
                } else {
                    // Business Mentor → Get reporting manager (BDM/BCM) from `employees` table
                    $stmt_manager = $conn->prepare("SELECT name FROM employees WHERE employee_id = :ref");
                }

                $stmt_manager->execute([':ref' => $reference_no]);

                if ($stmt_manager->rowCount() > 0) {
                    $reference_no_fname = $stmt_manager->fetch()['name'];
                } else {
                    $reference_no_fname = "Unknown";
                }
            }
        }
    }

?>