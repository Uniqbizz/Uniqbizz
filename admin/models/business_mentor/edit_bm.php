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
    $zone_id = $_GET['zone'];
    $branch_id = $_GET['branch'];
    $editfor = $_GET['editfor'];
    $transfer_check = $_GET['tr_check'] ?? 0;
    $transfer_status = 0;


    /* ---------------------------------
    USER TYPE
    --------------------------------- */

    if ($transfer_check == 1) {
        $usertype_id = $_GET['usertype'];
        $usertype = $usertype_id == '26' ? 'BM' : ($usertype_id == '28' ? 'MF' : ($usertype_id == '30' ? 'SF' : ''));
    } else {
        $usertype = $_GET['usertype'];
    }

    if ($editfor == 'pending') {
        $identifier_name = 'id=';
    } else if ($editfor == 'registered') {
        $identifier_name = $usertype == '28' ? 'master_franchisee_id=' :
            ($usertype == '26' ? 'business_mentor_id=' :
            ($usertype == '30' ? 'sponsor_franchisee_id=' : ''));
    }

    $user_type=$testValue = $usertype; //important


    /* ---------------------------------
    HELPER FUNCTIONS
    --------------------------------- */

    function getNameById($conn,$table,$id,$field){
        if(!$id) return null;

        $stmt=$conn->prepare("SELECT $field FROM $table WHERE id=? AND status='1'");
        $stmt->execute([$id]);

        if($stmt->rowCount()>0){
            return $stmt->fetch()[$field];
        }
        return null;
    }

    function getManagerName($conn,$reference_no,$usertype){

        if ($reference_no == "Not Applicable") {
            return "Not Applicable";
        }

        if ($usertype == 'MF') {
            $stmt = $conn->prepare("SELECT name FROM zonal_manager WHERE zonal_manager_id=?");
        } else {
            $stmt = $conn->prepare("SELECT name FROM employees WHERE employee_id=?");
        }

        $stmt->execute([$reference_no]);

        if ($stmt->rowCount() > 0) {
            return $stmt->fetch()['name'];
        }

        return "Unknown";
    }

    function getValue($update_data,$update_data_prev,$key){
        return $update_data[$key] ?? $update_data_prev[$key] ?? null;
    }


    /* ---------------------------------
    CHECK TRANSFER REQUEST
    --------------------------------- */

    $sql="SELECT pending_payload,transfer_status 
    FROM transfered_users 
    WHERE transfer_user_id=? AND transfer_status=1";

    $stmt=$conn->prepare($sql);
    $stmt->execute([$id]);
    $employees=$stmt->fetchAll(PDO::FETCH_ASSOC);


    if (!empty($employees)) {

        foreach ($employees as $row) {

            $payload=json_decode($row['pending_payload'],true);

            $table=$payload['table'] ?? null;
            $identifier_column=$payload['identifier_column'] ?? null;
            $identifier_id=$payload['identifier_id'] ?? null;

            $update_data=$payload['update_data'] ?? [];
            $update_data_prev=json_decode($update_data['prev_user_data'],true);

            $fid=$identifier_id;


            /* ---------------------------------
            FIELDS
            --------------------------------- */

            $firstname=getValue($update_data,$update_data_prev,'firstname');
            $lastname=getValue($update_data,$update_data_prev,'lastname');
            $nominee_name=getValue($update_data,$update_data_prev,'nominee_name');
            $nominee_relation=getValue($update_data,$update_data_prev,'nominee_relation');
            $email=getValue($update_data,$update_data_prev,'email');
            $contact_no=getValue($update_data,$update_data_prev,'contact_no');
            $paid_amount=$update_data['paid_amount'] ?? null;

            $reference_no=$update_data_prev['reference_no'] ?? null;

            $date_of_birth=getValue($update_data,$update_data_prev,'date_of_birth');
            $gender=getValue($update_data,$update_data_prev,'gender');
            $address=getValue($update_data,$update_data_prev,'address');

            $profile_pic=getValue($update_data,$update_data_prev,'profile_pic');

            $payment_mode=$update_data['payment_mode'] ?? null;
            $payment_proof=$update_data['payment_proof'] ?? null;

            $pan_card=getValue($update_data,$update_data_prev,'pan_card');
            $aadhar_card=getValue($update_data,$update_data_prev,'aadhar_card');
            $voting_card=getValue($update_data,$update_data_prev,'voting_card');
            $bank_passbook=getValue($update_data,$update_data_prev,'bank_passbook');

            $pincode=getValue($update_data,$update_data_prev,'pincode');

            $cheque_no=$update_data['cheque_no'] ?? null;
            $cheque_date=$update_data['cheque_date'] ?? null;
            $bank_name=$update_data['bank_name'] ?? null;
            $transaction_no=$update_data['transaction_no'] ?? null;

            $note=getValue($update_data,$update_data_prev,'note');

            $country=getValue($update_data,$update_data_prev,'country');
            $state=getValue($update_data,$update_data_prev,'state');
            $city=getValue($update_data,$update_data_prev,'city');
            $zone=getValue($update_data,$update_data_prev,'zone');
            $branch=getValue($update_data,$update_data_prev,'branch');


            /* ---------------------------------
            LOCATION NAMES
            --------------------------------- */

            $countryname=getNameById($conn,'countries',$country,'country_name');
            $statename=getNameById($conn,'states',$state,'state_name');
            $city_name=getNameById($conn,'cities',$city,'city_name');
            $zone_name=getNameById($conn,'zone',$zone,'zone_name');
            $branch_name=getNameById($conn,'branch',$branch,'branch_name');


            /* ---------------------------------
            REFERENCE NAME
            --------------------------------- */

            $reference_no_fname=getManagerName($conn,$reference_no,$usertype);

            $date_of_joning=$update_data['register_date'] ?? $update_data_prev['register_date'];

            $login_data=$payload['login_data'] ?? [];
            $username=$login_data['username'] ?? null;
            $user_id=$login_data['user_id'] ?? null;

            $transfer_status=$row['transfer_status'];

        }

    }


    /* ---------------------------------
    NORMAL USER LOAD
    --------------------------------- */

    else {

        if ($usertype == '28') {
            $stmt = $conn->prepare("SELECT * FROM master_franchisee WHERE master_franchisee_id=? OR id=?");
        }

        else if ($usertype == '26') {
            $stmt = $conn->prepare("SELECT * FROM business_mentor WHERE business_mentor_id=? OR id=?");
        }

        else if ($usertype == '30') {
            $stmt = $conn->prepare("SELECT * FROM sponsor_franchisee WHERE sponsor_franchisee_id=? OR id=?");
        }

        $stmt->execute([$id,$id]);

        if ($stmt->rowCount() > 0) {

            foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {

                $fid=$row['id'];

                $firstname=$row['firstname'];
                $lastname=$row['lastname'];
                $nominee_name=$row['nominee_name'];
                $nominee_relation=$row['nominee_relation'];
                $email=$row['email'];
                $contact_no=$row['contact_no'];
                $paid_amount=$row['paid_amount'];

                $reference_no=$row['reference_no'];

                $date_of_birth=$row['date_of_birth'];
                $gender=$row['gender'];

                $country=$row['country'];
                $state=$row['state'];
                $city=$row['city'];
                $zone=$row['zone'];
                $branch=$row['branch'];

                $address=$row['address'];

                $profile_pic=$row['profile_pic'];

                $payment_mode=$row['payment_mode'];
                $payment_proof=$row['payment_proof'];

                $pan_card=$row['pan_card'];
                $aadhar_card=$row['aadhar_card'];
                $voting_card=$row['voting_card'];
                $bank_passbook=$row['bank_passbook'];

                $pincode=$row['pincode'];

                $cheque_no=$row['cheque_no'];
                $cheque_date=$row['cheque_date'];
                $bank_name=$row['bank_name'];
                $transaction_no=$row['transaction_no'];

                $note=$row['note'];

                $date_of_joning=$row['register_date'];


                /* LOCATION NAMES */

                $countryname=getNameById($conn,'countries',$country,'country_name');
                $statename=getNameById($conn,'states',$state,'state_name');
                $city_name=getNameById($conn,'cities',$city,'city_name');
                $zone_name=getNameById($conn,'zone',$zone,'zone_name');
                $branch_name=getNameById($conn,'branch',$branch,'branch_name');

                $reference_no_fname=getManagerName($conn,$reference_no,$usertype);


                /* PREVIOUS USER DATA */

                $prev_user_data=[
                    'id'=>$row['id'],
                    'firstname'=>$row['firstname'],
                    'lastname'=>$row['lastname'],
                    'nominee_name'=>$row['nominee_name'],
                    'nominee_relation'=>$row['nominee_relation'],
                    'email'=>$row['email'],
                    'contact_no'=>$row['contact_no'],
                    'paid_amount'=>$row['paid_amount'],
                    'reference_no'=>$row['reference_no'],
                    'date_of_birth'=>$row['date_of_birth'],
                    'gender'=>$row['gender'],
                    'country'=>$row['country'],
                    'state'=>$row['state'],
                    'city'=>$row['city'],
                    'address'=>$row['address'],
                    'zone'=>$row['zone'],
                    'branch'=>$row['branch'],
                    'profile_pic'=>$row['profile_pic'],
                    'payment_mode'=>$row['payment_mode'],
                    'payment_proof'=>$row['payment_proof'],
                    'pan_card'=>$row['pan_card'],
                    'aadhar_card'=>$row['aadhar_card'],
                    'voting_card'=>$row['voting_card'],
                    'bank_passbook'=>$row['bank_passbook'],
                    'pincode'=>$row['pincode'],
                    'cheque_no'=>$row['cheque_no'],
                    'cheque_date'=>$row['cheque_date'],
                    'bank_name'=>$row['bank_name'],
                    'transaction_no'=>$row['transaction_no'],
                    'note'=>$row['note'],
                    'country_name'=>$countryname,
                    'state_name'=>$statename,
                    'city_name'=>$city_name,
                    'zone_name'=>$zone_name,
                    'branch_name'=>$branch_name,
                    'reference_no_name'=>$reference_no_fname,
                    'register_date'=>$row['register_date']
                ];

            }

        }

    }

?>