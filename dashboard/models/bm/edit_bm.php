<?php 
    $id = $_GET['id'];
    $country_id = $_GET['cty'];
    $state_id = $_GET['st'];
    $city_id = $_GET['ct'];
    $zone_id = $_GET['zn'];
    $branch_id = $_GET['br'];
    $editfor = $_GET['editfor'];
    
    if ($editfor == 'registered') {
        $identifier_id= substr($_GET["id"],0,2);
        $identifier_name = $identifier_id=='BM'?'business_mentor_id=':($identifier_id=='MF'?'master_franchisee_id=':($identifier_id == 'SF'?'sponsor_franchisee_id=':'NA'));
        $identifier_tablename = $identifier_id=='BM'?'business_mentor':($identifier_id=='MF'?'master_franchisee':($identifier_id == 'SF'?'sponsor_franchisee':'NA'));
    }

    $stmt = $conn->prepare("SELECT *FROM `$identifier_tablename` where $identifier_name'" . $id . "'");
    $stmt->execute();
    // set the resulting array to associative
    $stmt->setFetchMode(PDO::FETCH_ASSOC);

    if ($stmt->rowCount() > 0) {
        foreach (($stmt->fetchAll()) as $key => $row) {
            $fid = $row['id'];
            $firstname = $row['firstname'];
            $lastname = $row['lastname'];
            $nominee_name = $row['nominee_name'];
            $nominee_relation = $row['nominee_relation'];
            $email = $row['email'];
            $contact_no = $row['contact_no'];
            $paid_amount=$row['paid_amount'];
            $reference_no = $row['reference_no'];
            $registrant = $row['registrant'];
            $date_of_birth = $row['date_of_birth'];
            $gender = $row['gender'];
            $country = $row['country'];
            $state = $row['state'];
            $city = $row['city'];
            $address = $row['address'];
            $zone = $row['zone'];
            $branch = $row['branch'];
            $profile_pic1 = $row['profile_pic'];
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

            //get zone
            $zones = $conn->prepare("SELECT zone_name FROM zone where id='" . $zone . "' and status='1' ");
            $zones->execute();
            $zones->setFetchMode(PDO::FETCH_ASSOC);
            if ($zones->rowCount() > 0) {
                $zone = $zones->fetch();
                $zone_name = $zone['zone_name'];
            }

            //get branch
            $branchs = $conn->prepare("SELECT branch_name FROM branch where id='" . $branch . "' and status='1' ");
            $branchs->execute();
            $branchs->setFetchMode(PDO::FETCH_ASSOC);
            if ($branchs->rowCount() > 0) {
                $branch = $branchs->fetch();
                $branch_name = $branch['branch_name'];
            }
        }
    }
?>