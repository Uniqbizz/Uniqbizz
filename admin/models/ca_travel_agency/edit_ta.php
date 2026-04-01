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
    $usertype=$user_type = $_GET['usertype'];
    $editfor = $_GET['editfor'];
    $transfer_check = $_GET['tr_check'] ?? 0;
    $transfer_status = 0;

    $reference_no_fname = "";
    $reference_no_lname = "";
    $comp_check ="";


    /* ---------------------------------
    IDENTIFIER
    --------------------------------- */

    if ($editfor == 'pending') {

        $identifier_name = 'id=';

    } 
    else if ($editfor == 'registered') {

        if ($user_type == '11') {

            $identifier_name = 'ca_travelagency_id=';

        } 
        elseif ($user_type == '33') {

            $identifier_name = 'institution_branch_manager_id=';

        }

    }


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


    if(!empty($employees)){

        foreach($employees as $row){

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
            $comp_check=getValue($update_data,$update_data_prev,'comp_check');

            $cheque_no=$update_data['cheque_no'] ?? null;
            $cheque_date=$update_data['cheque_date'] ?? null;
            $bank_name=$update_data['bank_name'] ?? null;
            $transaction_no=$update_data['transaction_no'] ?? null;

            $note=getValue($update_data,$update_data_prev,'note');

            $country=getValue($update_data,$update_data_prev,'country');
            $state=getValue($update_data,$update_data_prev,'state');
            $city=getValue($update_data,$update_data_prev,'city');


            /* LOCATION */

            $countryname=getNameById($conn,'countries',$country,'country_name');
            $statename=getNameById($conn,'states',$state,'state_name');
            $city_name=getNameById($conn,'cities',$city,'city_name');


            $date_of_joning=$update_data['register_date'] ?? $update_data_prev['register_date'];

            $transfer_status=$row['transfer_status'];


            /* ---------------------------------
            REFERENCE NAME FETCH
            --------------------------------- */

            $reference_id = (substr($reference_no,0,1)=='F' || substr($reference_no,0,1)=='I')
            ? substr($reference_no,0,1)
            : substr($reference_no,0,2);


            if($reference_id=="BM"){

                $stmt=$conn->prepare("SELECT firstname,lastname FROM business_mentor WHERE business_mentor_id=?");
                $stmt->execute([$reference_no]);

                if($stmt->rowCount()>0){

                    $business_mentor=$stmt->fetch(PDO::FETCH_ASSOC);
                    $reference_no_fname=$business_mentor['firstname'];
                    $reference_no_lname=$business_mentor['lastname'];

                }

            }

            else if($reference_id=="BH"){

                $stmt=$conn->prepare("SELECT name FROM employees WHERE employee_id=?");
                $stmt->execute([$reference_no]);

                if($stmt->rowCount()>0){

                    $business_mentor=$stmt->fetch(PDO::FETCH_ASSOC);
                    $ref_fullname=$business_mentor['name'];

                    $parts=explode(' ',trim($ref_fullname));
                    $reference_no_lname=array_pop($parts);
                    $reference_no_fname=implode(' ',$parts);

                }

            }

            else if($reference_id=="TE"){

                $stmt=$conn->prepare("SELECT firstname,lastname FROM corporate_agency WHERE corporate_agency_id=?");
                $stmt->execute([$reference_no]);

                if($stmt->rowCount()>0){

                    $corporate_agencys=$stmt->fetch(PDO::FETCH_ASSOC);
                    $reference_no_fname=$corporate_agencys['firstname'];
                    $reference_no_lname=$corporate_agencys['lastname'];

                }

            }

            else if($reference_id=="F"){

                $stmt=$conn->prepare("SELECT firstname,lastname FROM sub_franchisee WHERE sub_franchisee_id=?");
                $stmt->execute([$reference_no]);

                if($stmt->rowCount()>0){

                    $corporate_agencys=$stmt->fetch(PDO::FETCH_ASSOC);
                    $reference_no_fname=$corporate_agencys['firstname'];
                    $reference_no_lname=$corporate_agencys['lastname'];

                }

            }

            else if($reference_id=="I"){

                $stmt=$conn->prepare("SELECT firstname,lastname FROM institution WHERE institution_id=?");
                $stmt->execute([$reference_no]);

                if($stmt->rowCount()>0){

                    $corporate_agencys=$stmt->fetch(PDO::FETCH_ASSOC);
                    $reference_no_fname=$corporate_agencys['firstname'];
                    $reference_no_lname=$corporate_agencys['lastname'];

                }

            }

            else if($reference_id=="MF"){

                $stmt=$conn->prepare("SELECT firstname,lastname FROM master_franchisee WHERE master_franchisee_id=?");
                $stmt->execute([$reference_no]);

                if($stmt->rowCount()>0){

                    $corporate_agencys=$stmt->fetch(PDO::FETCH_ASSOC);
                    $reference_no_fname=$corporate_agencys['firstname'];
                    $reference_no_lname=$corporate_agencys['lastname'];

                }

            }

            else if($reference_id=="NA"){

                $reference_no_fname="Not Applicable";
                $reference_no_lname="";

            }

        }

    }


    /* ---------------------------------
    NORMAL USER LOAD
    --------------------------------- */

    else{

        if($user_type=='11'){

            $stmt=$conn->prepare("SELECT * FROM ca_travelagency WHERE ca_travelagency_id=? OR id=?");

        }

        elseif($user_type=='33'){

            $stmt=$conn->prepare("SELECT * FROM institution_branch_manager WHERE institution_branch_manager_id=? OR id=?");

        }

        $stmt->execute([$id,$id]);

        if($stmt->rowCount()>0){

            foreach($stmt->fetchAll(PDO::FETCH_ASSOC) as $row){

                $fid=$row['id'];

                $firstname=$row['firstname'];
                $lastname=$row['lastname'];

                $nominee_name=$row['nominee_name'];
                $nominee_relation=$row['nominee_relation'];

                $email=$row['email'];
                $contact_no=$row['contact_no'];

                $reference_no=$row['reference_no'];

                $date_of_birth=$row['date_of_birth'];
                $gender=$row['gender'];

                $country=$row['country'];
                $state=$row['state'];
                $city=$row['city'];

                $address=$row['address'];

                $profile_pic=$row['profile_pic'];

                $payment_mode=$row['payment_mode'];
                $payment_proof=$row['payment_proof'];
                $payment_fee=$row['amount'];
                $pan_card=$row['pan_card'];
                $aadhar_card=$row['aadhar_card'];
                $voting_card=$row['voting_card'];
                $bank_passbook=$row['passbook'];

                $pincode=$row['pincode'];
                $comp_check=$row['comp_check'];

                $cheque_no=$row['cheque_no'];
                $cheque_date=$row['cheque_date'];
                $bank_name=$row['bank_name'];
                $transaction_no=$row['transaction_no'];

                $note=$row['note'];

                $date_of_joning=$row['register_date'];


                /* LOCATION */

                $countryname=getNameById($conn,'countries',$country,'country_name');
                $statename=getNameById($conn,'states',$state,'state_name');
                $city_name=getNameById($conn,'cities',$city,'city_name');


                /* REFERENCE LOOKUP */

                $reference_id = (substr($reference_no,0,1)=='F' || substr($reference_no,0,1)=='I')
                ? substr($reference_no,0,1)
                : substr($reference_no,0,2);

                if($reference_id=="BM"){

                    $stmt=$conn->prepare("SELECT firstname,lastname FROM business_mentor WHERE business_mentor_id=?");
                    $stmt->execute([$reference_no]);

                    if($stmt->rowCount()>0){

                        $business_mentor=$stmt->fetch(PDO::FETCH_ASSOC);
                        $reference_no_fname=$business_mentor['firstname'];
                        $reference_no_lname=$business_mentor['lastname'];

                    }

                }

                else if($reference_id=="BH"){

                    $stmt=$conn->prepare("SELECT name FROM employees WHERE employee_id=?");
                    $stmt->execute([$reference_no]);

                    if($stmt->rowCount()>0){

                        $business_mentor=$stmt->fetch(PDO::FETCH_ASSOC);

                        $ref_fullname=$business_mentor['name'];

                        $parts=explode(' ',trim($ref_fullname));
                        $reference_no_lname=array_pop($parts);
                        $reference_no_fname=implode(' ',$parts);

                    }

                }


                /* PREVIOUS USER DATA */

                $prev_user_data=[

                    'id'=>$row['id'],
                    'firstname'=>$row['firstname'],
                    'lastname'=>$row['lastname'],

                    'nominee_name'=>$row['nominee_name'],
                    'nominee_relation'=>$row['nominee_relation'],

                    'email'=>$row['email'],
                    'contact_no'=>$row['contact_no'],

                    'reference_no'=>$row['reference_no'],

                    'date_of_birth'=>$row['date_of_birth'],
                    'gender'=>$row['gender'],

                    'country'=>$row['country'],
                    'state'=>$row['state'],
                    'city'=>$row['city'],

                    'address'=>$row['address'],

                    'profile_pic'=>$row['profile_pic'],

                    'payment_mode'=>$row['payment_mode'],
                    'payment_proof'=>$row['payment_proof'],

                    'pan_card'=>$row['pan_card'],
                    'aadhar_card'=>$row['aadhar_card'],
                    'voting_card'=>$row['voting_card'],
                    'bank_passbook'=>$row['passbook'],

                    'pincode'=>$row['pincode'],
                    'comp_check'=>$row['comp_check'],

                    'cheque_no'=>$row['cheque_no'],
                    'cheque_date'=>$row['cheque_date'],
                    'bank_name'=>$row['bank_name'],
                    'transaction_no'=>$row['transaction_no'],

                    'note'=>$row['note'],

                    'country_name'=>$countryname,
                    'state_name'=>$statename,
                    'city_name'=>$city_name,

                    'reference_no_fname'=>$reference_no_fname,
                    'reference_no_lname'=>$reference_no_lname,

                    'register_date'=>$row['register_date']

                ];

            }

        }

    }

?>