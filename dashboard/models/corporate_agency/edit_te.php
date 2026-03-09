<?php
    $id = $_GET['vkvbvjfgfikix'];
    $ref=$_GET['ncy'];
    $regby=$_GET['regby'];
    $country_id = $_GET['country'];
    $state_id = $_GET['mst'];
    $city_id = $_GET['hct'];
    $editfor = $_GET['editfor'];
    $edittype = $_GET['edittype'];
    $registered_as=$edittype == '16'?'corporate_agency':($edittype == '29'?'sub_franchisee':($edittype == '32' ? 'institution':'NA'));
    if($edittype == '16'){
        $stmt = $conn->prepare("SELECT * FROM `corporate_agency` WHERE corporate_agency_id='".$id."' ");
        
    }else if($edittype == '29'){
        $stmt = $conn->prepare("SELECT * FROM `sub_franchisee` WHERE sub_franchisee_id='".$id."' ");
    }else if($edittype == '32'){
        $stmt = $conn->prepare("SELECT * FROM `institution` WHERE institution_id='".$id."' ");
    }
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
            $amount=$row['amount'];
            $reference_no = $row['reference_no'];
            $registrant = $row['registrant'];
            $gst_no=$row['gst_no'];
            $date_of_birth=$row['date_of_birth'];
            $gender=$row['gender'];
            $country=$row['country'];
            $state=$row['state'];
            $city=$row['city'];
            $address=$row['address'];
            $payment_mode=$row['payment_mode'];
            $cheque_no=$row['cheque_no'];
            $cheque_date=$row['cheque_date'];
            $bank_name=$row['bank_name'];
            $transaction_no=$row['transaction_no'];
            $profile_pic=$row['profile_pic'];
            $pan_card=$row['pan_card'];
            $aadhar_card=$row['aadhar_card'];
            $voting_card=$row['voting_card'];
            $bank_passbook=$row['bank_passbook'];
            $payment_proof=$row['payment_proof'];
            $pincode=$row['pincode'];

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

        }
    }
?>