<?php

    require '../../connect.php';
    include __DIR__ . '/../common_models/get_table_user_type.php';
    $id = $_GET['vkvbvjfgfikix'];
    $user_id = $_GET['fyfyfregby'];
    $reference_no = $_GET['nohbref'];
    $country_id = $_GET['ncy'];
    $state_id = $_GET['mst'];
    $city_id = $_GET['hct'];
    $reference_id = '';
    $testValue = $user_type  = $_GET['usertype'];
    $editfor = $_GET['editfor'];
    $transfer_check = $_GET['tr_check'] ?? 0;
    $transfer_status=0;

    // $testValue = $user_type  == 'te' ? '16' : ($user_type  == 'sf' ? '29' : ($user_type  == 'in' ? '32' : '')); //important
    /* --------------------------------------------------
    HELPER FUNCTIONS (no logic change)
    -------------------------------------------------- */

    function getName($conn,$table,$column,$id,$field){
        $stmt=$conn->prepare("SELECT $field FROM $table WHERE $column=? LIMIT 1");
        $stmt->execute([$id]);
        $res=$stmt->fetch(PDO::FETCH_ASSOC);
        return $res[$field]??null;
    }

    function getLocation($conn,$table,$id,$field){
        if(!$id) return null;

        $stmt=$conn->prepare("SELECT $field FROM $table WHERE id=? AND status='1'");
        $stmt->execute([$id]);
        $row=$stmt->fetch(PDO::FETCH_ASSOC);

        return $row[$field]??null;
    }

    function getValue($update_data,$update_data_prev,$key){
        return $update_data[$key] ?? $update_data_prev[$key] ?? null;
    }


    /* --------------------------------------------------
    CHECK TRANSFER REQUEST
    -------------------------------------------------- */

    $sql="SELECT pending_payload,transfer_status
    FROM transfered_users
    WHERE transfer_user_id=? AND transfer_status=1";

    $stmt=$conn->prepare($sql);
    $stmt->execute([$id]);
    $employees=$stmt->fetchAll(PDO::FETCH_ASSOC);


    if(!empty($employees)){

        foreach($employees as $row){

            $payload=json_decode($row['pending_payload'],true);

            $table=$payload['table'] ?? null;
            $identifier_column=$payload['identifier_column'] ?? null;
            $identifier_id=$payload['identifier_id'] ?? null;

            $fid=$identifier_id;

            $update_data=$payload['update_data'] ?? [];
            $update_data_prev=json_decode($update_data['prev_user_data'],true);

            $transfer_status=$row['transfer_status'];


            /* --------------------------------------------------
            COMMON FIELD FETCH
            -------------------------------------------------- */

            $firstname=getValue($update_data,$update_data_prev,'firstname');
            $lastname=getValue($update_data,$update_data_prev,'lastname');
            $nominee_name=getValue($update_data,$update_data_prev,'nominee_name');
            $nominee_relation=getValue($update_data,$update_data_prev,'nominee_relation');
            $email=getValue($update_data,$update_data_prev,'email');
            $contact_no=getValue($update_data,$update_data_prev,'contact_no');
            $note=getValue($update_data,$update_data_prev,'note');

            $converted=getValue($update_data,$update_data_prev,'converted');
            $amount=getValue($update_data,$update_data_prev,'amount');
            $amtGST=getValue($update_data,$update_data_prev,'amtGST');

            $reference_no=getValue($update_data,$update_data_prev,'reference_no');
            $gst_no=getValue($update_data,$update_data_prev,'gst_no');

            $date_of_birth=getValue($update_data,$update_data_prev,'date_of_birth');
            $gender=getValue($update_data,$update_data_prev,'gender');

            $country=getValue($update_data,$update_data_prev,'country');
            $state=getValue($update_data,$update_data_prev,'state');
            $city=getValue($update_data,$update_data_prev,'city');

            $address=getValue($update_data,$update_data_prev,'address');

            $payment_mode=getValue($update_data,$update_data_prev,'payment_mode');
            $cheque_no=getValue($update_data,$update_data_prev,'cheque_no');
            $cheque_date=getValue($update_data,$update_data_prev,'cheque_date');

            $bank_name=getValue($update_data,$update_data_prev,'bank_name');
            $transaction_no=getValue($update_data,$update_data_prev,'transaction_no');

            $profile_pic=getValue($update_data,$update_data_prev,'profile_pic');
            $pan_card=getValue($update_data,$update_data_prev,'pan_card');
            $aadhar_card=getValue($update_data,$update_data_prev,'aadhar_card');
            $voting_card=getValue($update_data,$update_data_prev,'voting_card');
            $bank_passbook=getValue($update_data,$update_data_prev,'bank_passbook');
            $payment_proof=getValue($update_data,$update_data_prev,'payment_proof');

            $pincode=getValue($update_data,$update_data_prev,'pincode');

            $status=getValue($update_data,$update_data_prev,'status');

            $assign_status=getValue($update_data,$update_data_prev,'tc_assign_status');
            $assign_TCs=getValue($update_data,$update_data_prev,'no_tc_alloted');
            $assign_tenure=getValue($update_data,$update_data_prev,'repay_tenure');
            $assign_roi=getValue($update_data,$update_data_prev,'roi');
            $assign_tax=getValue($update_data,$update_data_prev,'tax');
            $assign_repay_amount=getValue($update_data,$update_data_prev,'repay_amount');

            $comm_per=getValue($update_data,$update_data_prev,'current_commission_per');
            $ins_per=getValue($update_data,$update_data_prev,'current_incentive_per');

            $date_of_joning=getValue($update_data,$update_data_prev,'register_date');


            /* --------------------------------------------------
            LOCATION NAMES
            -------------------------------------------------- */

            $countryname=getLocation($conn,'countries',$country,'country_name');
            $statename=getLocation($conn,'states',$state,'state_name');
            $city_name=getLocation($conn,'cities',$city,'city_name');


            /* --------------------------------------------------
            REFERENCE NAME
            -------------------------------------------------- */

            $reference_id=substr($reference_no,0,2);

            if($reference_id=="BM"){

            $reference_no_fname=getName($conn,'business_mentor','business_mentor_id',$reference_no,'firstname');
            $reference_no_lname=getName($conn,'business_mentor','business_mentor_id',$reference_no,'lastname');

            }

            elseif($reference_id=="BH"){

            $reference_no_name=getName($conn,'employees','employee_id',$reference_no,'name');

            }

            elseif($reference_id=="MF"){

            $reference_no_fname=getName($conn,'master_franchisee','master_franchisee_id',$reference_no,'firstname');
            $reference_no_lname=getName($conn,'master_franchisee','master_franchisee_id',$reference_no,'lastname');

            }

            elseif($reference_id=="SF"){

            $reference_no_fname=getName($conn,'sponsor_franchisee','sponsor_franchisee_id',$reference_no,'firstname');
            $reference_no_lname=getName($conn,'sponsor_franchisee','sponsor_franchisee_id',$reference_no,'lastname');

            }


            /* --------------------------------------------------
            LOGIN DATA
            -------------------------------------------------- */

            $login_data=$payload['login_data'] ?? [];
            $username=$login_data['username'] ?? null;
            $user_id=$login_data['user_id'] ?? null;

        }

    }


    /* --------------------------------------------------
    NO TRANSFER REQUEST → LOAD NORMAL USER
    -------------------------------------------------- */

    else{

        if($user_type =='16'){

            $table='corporate_agency';
            $id_col='corporate_agency_id';

        }

        elseif($user_type =='29'){

            $table='sub_franchisee';
            $id_col='sub_franchisee_id';

        }

        elseif($user_type =='32'){

            $table='institution';
            $id_col='institution_id';

        }


        $stmt=$conn->prepare("SELECT * FROM $table WHERE $id_col=? OR id=?");
        $stmt->execute([$id,$id]);

        $row=$stmt->fetch(PDO::FETCH_ASSOC);

        if($row){

            $fid=$row['id'];
            $firstname=$row['firstname'];
            $lastname=$row['lastname'];
            $nominee_name=$row['nominee_name'];
            $nominee_relation=$row['nominee_relation'];
            $email=$row['email'];
            $contact_no=$row['contact_no'];
            $note=$row['note'];

            $converted = null;

            if($user_type == '16'){
                $converted = $row['converted'] ?? null;
            }

            $amount=$row['amount'];
            $amtGST=$row['amtGST'];

            $reference_no=$row['reference_no'];
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

            $status=$row['status'];

            $assign_status=$row['tc_assign_status'] ?? null;
            $assign_TCs=$row['no_tc_alloted'] ?? null;
            $assign_tenure=$row['repay_tenure'] ?? null;
            $assign_roi=$row['roi'] ?? null;
            $assign_tax=$row['tax'] ?? null;
            $assign_repay_amount=$row['repay_amount'] ?? null;

            $comm_per=$row['current_commission_per'] ?? null;
            $ins_per=$row['current_incentive_per'] ?? null;
            $date_of_joning=$row['register_date'];

            $countryname=getLocation($conn,'countries',$country,'country_name');
            $statename=getLocation($conn,'states',$state,'state_name');
            $city_name=getLocation($conn,'cities',$city,'city_name');


            /* --------------------------------------------------
            REFERENCE NAME
            -------------------------------------------------- */

            $reference_id=substr($reference_no,0,2);
            $reference_no_fname = null;
            $reference_no_lname = null;
            $reference_no_name  = null;
            if($reference_id=="BM"){

            $reference_no_fname=getName($conn,'business_mentor','business_mentor_id',$reference_no,'firstname');
            $reference_no_lname=getName($conn,'business_mentor','business_mentor_id',$reference_no,'lastname');

            }

            elseif($reference_id=="BH"){

            $reference_no_name=getName($conn,'employees','employee_id',$reference_no,'name');

            }

            elseif($reference_id=="MF"){

            $reference_no_fname=getName($conn,'master_franchisee','master_franchisee_id',$reference_no,'firstname');
            $reference_no_lname=getName($conn,'master_franchisee','master_franchisee_id',$reference_no,'lastname');

            }

            elseif($reference_id=="SF"){

                $reference_no_fname=getName($conn,'sponsor_franchisee','sponsor_franchisee_id',$reference_no,'firstname');
                $reference_no_lname=getName($conn,'sponsor_franchisee','sponsor_franchisee_id',$reference_no,'lastname');

            }
            /* --------------------------------------------------
                PREVIOUS USER DATA ARRAY
            -------------------------------------------------- */

            $prev_user_data = [

                "id" => $row['id'],
                "firstname" => $row['firstname'],
                "lastname" => $row['lastname'],

                "nominee_name" => $row['nominee_name'],
                "nominee_relation" => $row['nominee_relation'],

                "email" => $row['email'],
                "contact_no" => $row['contact_no'],

                "note" => $row['note'],

                "converted" => ($user_type == '16') ? ($row['converted'] ?? null) : null,

                "amount" => $row['amount'],
                "amtGST" => $row['amtGST'],

                "reference_no" => $row['reference_no'],
                "reference_firstname" => $reference_no_fname,
                "reference_lastname" => $reference_no_lname,
                "reference_name" => $reference_no_name,

                "gst_no" => $row['gst_no'],

                "date_of_birth" => $row['date_of_birth'],
                "gender" => $row['gender'],

                "country" => $row['country'],
                "state" => $row['state'],
                "city" => $row['city'],

                "country_name" => getLocation($conn,'countries',$row['country'],'country_name'),
                "state_name" => getLocation($conn,'states',$row['state'],'state_name'),
                "city_name" => getLocation($conn,'cities',$row['city'],'city_name'),

                "address" => $row['address'],
                "pincode" => $row['pincode'],

                "payment_mode" => $row['payment_mode'],
                "cheque_no" => $row['cheque_no'],
                "cheque_date" => $row['cheque_date'],

                "bank_name" => $row['bank_name'],
                "transaction_no" => $row['transaction_no'],

                "profile_pic" => $row['profile_pic'],

                "pan_card" => $row['pan_card'],
                "aadhar_card" => $row['aadhar_card'],
                "voting_card" => $row['voting_card'],
                "bank_passbook" => $row['bank_passbook'],
                "payment_proof" => $row['payment_proof'],

                "status" => $row['status'],

                "tc_assign_status" => $row['tc_assign_status'] ?? null,
                "no_tc_alloted" => $row['no_tc_alloted'] ?? null,
                "repay_tenure" => $row['repay_tenure'] ?? null,
                "roi" => $row['roi'] ?? null,
                "tax" => $row['tax'] ?? null,
                "repay_amount" => $row['repay_amount'] ?? null,

                "current_commission_per" => $row['current_commission_per'] ?? null,
                "current_incentive_per" => $row['current_incentive_per'] ?? null,

                "register_date" => $row['register_date']

            ];

        }

    }

?>