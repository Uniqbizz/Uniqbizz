<?php
    require '../../connect.php';
    // get Row data
    $data = stripslashes(file_get_contents("php://input"));
    // json Decoding, true -> for getting data in associative manner
    $mydata = json_decode($data, true);
    // print_r($mydata);
    
    $customer_id = $mydata['cuID'];
    $travel_agenct_id = $mydata['userID'];
    $packageID = $mydata['packageID'];
    $no_of_adult = $mydata['no_of_adult'];
    $no_of_child = $mydata['no_of_child'];
    $total_passenger = $no_of_adult + $no_of_child;
    $cuIds = [];
    $cuName = [];
    
    
    //new
    $sql1 = $conn -> prepare("SELECT * FROM ca_customer WHERE ca_customer_id = '".$customer_id."' AND status= '1' ");
    $sql1 -> execute();
    $sql1 -> setFetchMode(PDO::FETCH_ASSOC);
    if( $sql1 -> rowCount()>0 ){
        foreach( ($sql1 -> fetchAll()) as $key => $row ){
            $cu_ref1 = $row['reference_no'];
            $cu_ref1_name = $row['registrant'];
            $cuIds[] = $cu_ref1;
            $cuName[] = $cu_ref1_name;

            if(!$cu_ref1){
                $ca_ta_ref = $row['ta_reference_no'];
                $ca_ta_ref_name = $row['ta_reference_name'];
                levelConti($ca_ta_ref,$ca_ta_ref_name);
            }else{
                // corporate_agency customer level 1
                $sql2 = $conn -> prepare("SELECT * FROM ca_customer WHERE ca_customer_id = '".$cu_ref1."' AND status= '1' ");
                $sql2 -> execute();
                $sql2 -> setFetchMode(PDO::FETCH_ASSOC);
                if( $sql2 -> rowCount()>0 ){
                    foreach( ($sql2 -> fetchAll()) as $key => $row ){
                        $cu_ref2 = $row['reference_no'];
                        $cu_ref2_name = $row['registrant'];
                        $cuIds[] = $cu_ref2;
                        $cuName[] = $cu_ref2_name;

                        if(!$cu_ref2){
                            $ca_ta_ref = $row['ta_reference_no'];
                            $ca_ta_ref_name = $row['ta_reference_name'];
                            levelConti($ca_ta_ref,$ca_ta_ref_name);
                        }else{
                            // corporate_agency customer level 2
                            $sql3 = $conn -> prepare("SELECT * FROM ca_customer WHERE ca_customer_id = '".$cu_ref2."' AND status= '1' ");
                            $sql3 -> execute();
                            $sql3 -> setFetchMode(PDO::FETCH_ASSOC);
                            if( $sql3 -> rowCount()>0 ){
                                foreach( ($sql3 -> fetchAll()) as $key => $row ){
                                    $cu_ref3 = $row['reference_no'];
                                    $cu_ref3_name = $row['registrant'];
                                    $cuIds[] = $cu_ref3; 
                                    $cuName[] = $cu_ref3_name;

                                    if(!$cu_ref3){
                                        $ca_ta_ref = $row['ta_reference_no'];
                                        $ca_ta_ref_name = $row['ta_reference_name'];
                                        levelConti($ca_ta_ref,$ca_ta_ref_name);

                                    }else{
                                        $ca_ta_ref = $row['ta_reference_no'];
                                        $ca_ta_ref_name = $row['ta_reference_name'];
                                        levelConti($ca_ta_ref,$ca_ta_ref_name);

                                        // corporate_agency customer level 3
                                        // $sql4 = $conn -> prepare("SELECT * FROM ca_customer WHERE ca_customer_id = '".$cu_ref3."' AND status= '1' ");
                                        // $sql4 -> execute();
                                        // $sql4 -> setFetchMode(PDO::FETCH_ASSOC);
                                        // if( $sql4 -> rowCount()>0 ){
                                        //     foreach( ($sql4 -> fetchAll()) as $key => $row ){
                                        //         $cu_ref4 = $row['reference_no'];

                                        //         if(!$cu_ref4){
                                        //             $ca_ta_ref = $row['ta_reference_no'];
                                        //             levelConti($ca_ta_ref);
                                        //         }else{
                                        //             $ca_ta_ref = $row['ta_reference_no'];
                                        //             levelConti($ca_ta_ref);
                                        //         }
                                        //     }
                                        // }
                                        
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }

    function levelConti($ca_ta_ref,$ca_ta_ref_name){
        
        global $conn;

        $cuIds2 = [];
        $cuName2 = [];

        $cuIds2[] = $ca_ta_ref; 
        $cuName2[] = $ca_ta_ref_name; // value not pushing in array

        // corporate_agency travel_agent
        $sql4 = $conn -> prepare("SELECT * FROM ca_travelagency WHERE ca_travelagency_id = '".$ca_ta_ref."' AND status= '1' ");
        $sql4 -> execute();
        $sql4 -> setFetchMode(PDO::FETCH_ASSOC);
        if( $sql4 -> rowCount()>0 ){
            foreach( ($sql4 -> fetchAll()) as $key => $row ){
                $ca_ref = $row['reference_no'];
                $ca_name = $row['registrant'];
                $cuIds2[] = $ca_ref; 
                $cuName2[] = $ca_name;
            }
        }

        // corporate_agency / Techno Enterprise
        $sql5 = $conn -> prepare("SELECT * FROM corporate_agency WHERE corporate_agency_id = '".$ca_ref."' AND status= '1' ");
        $sql5 -> execute();
        $sql5 -> setFetchMode(PDO::FETCH_ASSOC);
        if( $sql5 -> rowCount()>0 ){
            foreach( ($sql5 -> fetchAll()) as $key => $row ){
                $bm_ref = $row['reference_no'];
                $bm_name = $row['registrant'];
                $cuIds2[] = $bm_ref; 
                $cuName2[] = $bm_name;
            }
        }

        // Business Mentor
        $sql6 = $conn -> prepare("SELECT * FROM business_mentor WHERE business_mentor_id = '".$bm_ref."' AND status= '1' ");
        $sql6 -> execute();
        $sql6 -> setFetchMode(PDO::FETCH_ASSOC);
        if( $sql6 -> rowCount()>0 ){
            foreach( ($sql6 -> fetchAll()) as $key => $row ){
                $bdm_ref = $row['reference_no'];
                $bdm_name = $row['registrant'];
                $cuIds2[] = $bdm_ref; 
                $cuName2[] = $bdm_name;
            }
        }

        // Business Development manager
        $sql7 = $conn -> prepare("SELECT * FROM employees WHERE employee_id = '".$bdm_ref."' AND user_type = '25' AND status= '1' ");
        $sql7 -> execute();
        $sql7 -> setFetchMode(PDO::FETCH_ASSOC);
        if( $sql7 -> rowCount()>0 ){
            foreach( ($sql7 -> fetchAll()) as $key => $row ){
                $bcm_ref = $row['reporting_manager'];

                $bcm_name ='';
                $sqlBchName = $conn -> prepare("SELECT * FROM employees WHERE employee_id = '".$bcm_ref."' AND user_type = '24' AND status= '1' ");
                $sqlBchName -> execute();
                $sqlBchName -> setFetchMode(PDO::FETCH_ASSOC);  
                if( $sqlBchName -> rowCount()>0 ){
                    foreach( ($sqlBchName -> fetchAll()) as $key => $row ){
                        $bcm_name = $row['name'];
                    }
                }

                $cuIds2[] = $bcm_ref; 
                $cuName2[] = $bcm_name;
            }
        }

        // return $cuIds2 ;
        // return $cuName2 ;
        return array($cuIds2,$cuName2);
    }

    list($cuIds2,$cuName2) = levelConti($ca_ta_ref,$ca_ta_ref_name);

    // Now you can access $cuIds2 and $cuName2 separately
    // echo "Customer IDs: ";
    // print_r($cuIds2);

    // echo "Customer Names: ";
    // print_r($cuName2);

    $CU_l1 = $cuIds[0] ?? '';
    $CU_l2 = $cuIds[1] ?? '';
    $CU_l3 = $cuIds[2] ?? '';

    $CU_l1_name = $cuName[0] ?? '';
    $CU_l2_name = $cuName[1] ?? '';
    $CU_l3_name = $cuName[2] ?? '';


    if($CU_l1){
        $cu_level_1 = $CU_l1;
        $cu_level_1_message = 'Customer '. $CU_l1_name.' ('.$CU_l1.') Has Earned Rs.500 X '.$total_passenger.' = '.$total_passenger*500;
        $cu_level_1_amt = $total_passenger*500;
    }

    if($CU_l2){
        $cu_level_2 = $CU_l2;
        $cu_level_2_message = 'Customer '. $CU_l2_name.' ('.$CU_l2.') Has Earned Rs.250 X '.$total_passenger.' = '.$total_passenger*250;
        $cu_level_2_amt = $total_passenger*250;
    }

    if($CU_l3){
        $cu_level_3 = $CU_l3;
        $cu_level_3_message = 'Customer '. $CU_l3_name.' ('.$CU_l3.') Has Earned Rs.125 X '.$total_passenger.' = '.$total_passenger*125;
        $cu_level_3_amt = $total_passenger*125;
    }

    $sql8 = $conn -> prepare("SELECT * FROM package_pricing_markup WHERE package_id = '".$packageID."'  ");
    $sql8 -> execute();
    $sql8 -> setFetchMode(PDO::FETCH_ASSOC);
    if( $sql8 -> rowCount()>0 ){
        foreach( ($sql8 -> fetchAll()) as $key => $row ){
            $te_commi = $row['ca_direct_commission'];
            $bm_commi = $row['bm_direct_commission'];
            $bdm_commi = $row['bdm_direct_commission'];
            $bcm_commi = $row['bcm_direct_commission'];
            $ta_commi = $row['ta_markup'];
        }
    }

    $ta = $cuIds2[0];
    $ta_message = 'Travel consultant '. $cuIds2[0].' ('.$cuName2[0].') Has Earned Rs.'.$ta_commi.' X '.$total_passenger.' =  '.$total_passenger*$ta_commi.'/-';
    $ta_amt = $total_passenger*$ta_commi;

    $te = $cuIds2[1];
    $te_message = 'Techno Enterprise '. $cuIds2[1].' ('.$cuName2[1].') Has Earned Rs.'.$te_commi.' X '.$total_passenger.' =  '.$total_passenger*$te_commi.'/-';
    $te_amt = $total_passenger*$te_commi;

    $bm = $cuIds2[2];
    $bm_message = 'Business Mentor '. $cuIds2[2].' ('.$cuName2[2].') Has Earned Rs.'.$bm_commi.' X '.$total_passenger.' =  '.$total_passenger*$bm_commi.'/-';
    $bm_amt = $total_passenger*$bm_commi;

    $bdm = $cuIds2[3];
    $bdm_message = 'Business Development Manager '. $cuIds2[3].' ('.$cuName2[3].') Has Earned Rs.'.$bdm_commi.' X '.$total_passenger.' =  '.$total_passenger*$bdm_commi.'/-';
    $bdm_amt = $total_passenger*$bdm_commi;

    $bcm = $cuIds2[4];
    $bcm_message = 'Business Channel Manager '. $cuIds2[4].' ('.$cuName2[4].') Has Earned Rs.'.$bcm_commi.' X '.$total_passenger.' =  '.$total_passenger*$bcm_commi.'/-';
    $bcm_amt = $total_passenger*$bcm_commi;

    // Create an associative array with all the messages
    // $messages = [
    //     'cu_level_1_message' => $cu_level_1_message ?? '',
    //     'cu_level_2_message' => $cu_level_2_message ?? '',
    //     'cu_level_3_message' => $cu_level_3_message ?? '',
    //     'CA_Travel_agency_message' => $CA_Travel_agency_message ?? '',
    //     'techno_enterprise_message' => $techno_enterprise_message ?? '',
    //     'business_mentor_message' => $business_mentor_message ?? '',
    //     'business_development_manager_message' => $business_development_manager_message ?? '',
    //     'business_channel_manager_message' => $business_channel_manager_message ?? '',
    // ];
    // Encode the messages array as JSON
    // echo json_encode($messages);
    //cu = "customer", ta = "travel associate", te = "techno enterprise", bm = "business mentor", bdm = "business development manager", bcm = "business channel manager"
    $sql = "INSERT INTO product_payout (package_id, no_of_adult, no_of_child, ta_markup, cu_id, ta_id, ta_mess, ta_amt, te_id, te_mess, te_amt, bm_id,	bm_mess, bm_amt, bdm_id, bdm_mess, bdm_amt,  bch_id, bch_mess, bch_amt,  cu1_id, cu1_mess, cu1_amt, cu2_id, cu2_mess, cu2_amt,  cu3_id, cu3_mess, cu3_amt) VALUES (:package_id, :no_of_adult, :no_of_child, :ta_markup, :cu_id, :ta_id, :ta_mess, :ta_amt,  :te_id, :te_mess, :te_amt,  :bm_id, :bm_mess, :bm_amt,  :bdm_id, :bdm_mess, :bdm_amt,  :bch_id, :bch_mess, :bch_amt,  :cu1_id, :cu1_mess, :cu1_amt,  :cu2_id, :cu2_mess, :cu2_amt,  :cu3_id, :cu3_mess, :cu3_amt)";
    $stmt = $conn -> prepare($sql);
    $result = $stmt -> execute(array(
        ':package_id' => $mydata['packageID'], 
        ':no_of_adult' => $mydata['no_of_adult'],
        ':no_of_child' => $mydata['no_of_child'] ?? '0',
        ':ta_markup' => $mydata['ta_markup'] ?? '0',
        ':cu_id' => $mydata['cuID'],
        ':ta_id' => $ta,
        ':ta_mess' => $ta_message,
        ':ta_amt' => $ta_amt, 
        ':te_id' => $te, 
        ':te_mess' => $te_message, 
        ':te_amt' => $te_amt, 
        ':bm_id' => $bm,
        ':bm_mess' => $bm_message,
        ':bm_amt' => $bm_amt,
        ':bdm_id' => $bdm ?? '',
        ':bdm_mess' => $bdm_message ?? '',
        ':bdm_amt' => $bdm_amt ?? '0',
        ':bch_id' => $bcm ?? '',
        ':bch_mess' => $bcm_message ?? '',
        ':bch_amt' => $bcm_amt ?? '0',
        ':cu1_id' => $cu_level_1 ?? '',
        ':cu1_mess' => $cu_level_1_message ?? '',
        ':cu1_amt' => $cu_level_1_amt ?? '0',
        ':cu2_id' => $cu_level_2 ?? '',
        ':cu2_mess' => $cu_level_2_message ?? '',
        ':cu2_amt' => $cu_level_2_amt ?? '0',
        ':cu3_id' => $cu_level_3 ?? '',
        ':cu3_mess' => $cu_level_3_message ?? '',
        ':cu3_amt' => $cu_level_3_amt ?? '0'
    ));

    // if($result){

        // $sql11 = $conn->prepare("SELECT * FROM business_consultant WHERE business_consultant_id = '".$business_consultant."'");
        // $sql11->execute();
        // $sql11->setFetchMode(PDO::FETCH_ASSOC);
        // if($sql11->rowCount()>0){
        //     foreach(($sql11->fetchAll()) as $key11 => $row11){
        //         $BcId = $row11['business_consultant_id'];
        //         $BcName = $row11['firstname']. ' ' .$row11['lastname'];
        //         $BcRef = $row11['reference_no'];
        //     }
        // }
        // $sql12 = $conn->prepare("SELECT * FROM channel_business_director WHERE channel_business_director_id = '".$BcRef."'");
        // $sql12->execute();
        // $sql12->setFetchMode(PDO::FETCH_ASSOC);
        // if($sql12->rowCount()>0){
        //     foreach(($sql12->fetchAll()) as $key12 => $row12){
        //         $cbd_id = $row12['channel_business_director_id'];
        //         $cbd_name = $row12['firstname']. ' ' .$row12['lastname'];
        //     }
        // }
        // $stmt1 = $conn -> prepare(" SELECT name FROM package WHERE id = '".$mydata['packageID']."' ");
        // $stmt1 -> execute();
        // $pkgName = $stmt1 -> fetch();
        // $packageName = $pkgName['name'];

        // $message_cbd = "CBD - ".$cbd_name." ".$cbd_id." earned 75/- of BC - ".$BcName." ".$BcId." on selling ".$packageName." Package to Customer. Corporate Agency -> " .$corporate_agency." . Travel Agency -> ".$CA_Travel_agency. ".";
		// $payout_type = "Product Payout";
        // $cbdCommiAmt = "75";

        // $insertCBDPaySQL = " INSERT INTO cbd_payout (cbd_id, cbd_name, payout_type, user_id, user_name, message, amount, status) VALUES (:cbd_id, :cbd_name, :payout_type, :user_id, :user_name, :message, :amount, :status) ";
        // $insertCBDPay = $conn -> prepare($insertCBDPaySQL);
        // $result2 = $insertCBDPay -> execute( array(
        //     ':cbd_id' => $cbd_id,
        //     ':cbd_name' => $cbd_name,
        //     ':payout_type' => $payout_type,
        //     ':user_id' => $BcId, 
        //     ':user_name' => $BcName, 
        //     ':message' => $message_cbd, 
        //     ':amount' => $cbdCommiAmt, 
        //     ':status' => '2'
        // ));
    // }

    if($result){
        echo 1;
    }else{
        echo 0;
    }
?>