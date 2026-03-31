<?php

    require '../../connect.php';
    include __DIR__ . '/../common_models/get_table_user_type.php';
    $date = date('Y');

    $id = $_GET['vkvbvjfgfikix'];
    $user_id = $_GET['fyfyfregby'];
    $reference_no = $_GET['nohbref'];
    $country_id = $_GET['ncy'];
    $state_id = $_GET['mst'];
    $city_id = $_GET['hct'];

    $editfor = $_GET['editfor'];
    $transfer_check=$_GET['tr_check']??0;

    if ($editfor == 'pending') {
        $identifier_name = 'id=';
    } else if ($editfor == 'registered') {
        $identifier_name = 'ca_customer_id=';
    }
    $user_type=10;
    $stmt = $conn->prepare("SELECT * FROM `ca_customer` where ca_customer_id='" . $id . "' OR id = '" . $id . "'");
    $stmt->execute();
    // set the resulting array to associative
    $stmt->setFetchMode(PDO::FETCH_ASSOC);

    if ($stmt->rowCount() > 0) {
        foreach (($stmt->fetchAll()) as $key => $row) {
            $fid = $row['id'];
            $firstname = $row['firstname'];
            $lastname = $row['lastname'];
            $email = $row['email'];
            $contact_no = $row['contact_no'];
            $cust_ref = $row['reference_no']??'';
            $cust_ref_name = $row['registrant']??'';

            $reference_no = $row['ta_reference_no'];
            if (!$reference_no) {
                $reference_no = $row['reference_no'];
            }

            $date_of_birth = $row['date_of_birth'];
            $gender = $row['gender'];
            $country = $row['country'];
            $state = $row['state'];
            $city = $row['city'];
            $address = $row['address'];
            $profile_pic = $row['profile_pic'];
            $pan_card = $row['pan_card'];
            $aadhar_card = $row['aadhar_card'];
            $voting_card = $row['voting_card'];
            $bank_passbook = $row['passbook'];
            $payment_proof = $row['payment_proof'];
            $payment_mode = $row['payment_mode'];
            $customer_type = $row['customer_type'];
            $cheque_no = $row['cheque_no'];
            $cheque_date = $row['cheque_date'];
            $bank_name = $row['bank_name'];
            $transaction_no = $row['transaction_no'];
            $pincode = $row['pincode'];
            $status = $row['status'];
            $comp_check=$row['comp_chek'];
            $note = $row['note'];

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

            $reference_id = substr($reference_no, 0, 2);
            if ($reference_id == "TA") {
                $caTravelAgencys = $conn->prepare("SELECT firstname, lastname, reference_no FROM ca_travelagency WHERE ca_travelagency_id='" . $reference_no . "'");
                $caTravelAgencys->execute();
                $caTravelAgencys->setFetchMode(PDO::FETCH_ASSOC);
                if ($caTravelAgencys->rowCount() > 0) {
                    $caTravelAgency = $caTravelAgencys->fetch();
                    $reference_no_fname = $caTravelAgency['firstname'];
                    $reference_no_lname = $caTravelAgency['lastname'];
                }
            } else {
                $cacustomers = $conn->prepare("SELECT firstname, lastname, reference_no FROM ca_customer WHERE ca_customer_id='" . $reference_no . "'");
                $cacustomers->execute();
                $cacustomers->setFetchMode(PDO::FETCH_ASSOC);
                if ($cacustomers->rowCount() > 0) {
                    $cacustomer = $cacustomers->fetch();
                    $reference_no_fname = $cacustomer['firstname'];
                    $reference_no_lname = $cacustomer['lastname'];
                }
            }
        }
    }
?>