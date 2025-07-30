<?php
    require '../../connect.php';
    $customer_id = 'CU240005';
    $cuIds = [];
    $cuIds2 = [];
    // corporate_agency customer get ref id for levels
    $sql1 = $conn -> prepare("SELECT * FROM ca_customer WHERE ca_customer_id = '".$customer_id."' AND status= '1' ");
    $sql1 -> execute();
    $sql1 -> setFetchMode(PDO::FETCH_ASSOC);
    if( $sql1 -> rowCount()>0 ){
        foreach( ($sql1 -> fetchAll()) as $key => $row ){
            $cu_ref1 = $row['reference_no'];
            $cuIds[] = $cu_ref1;

            if(!$cu_ref1){
                $ca_ta_ref = $row['ta_reference_no'];
                levelConti($ca_ta_ref);
            }else{
                // corporate_agency customer level 1
                $sql2 = $conn -> prepare("SELECT * FROM ca_customer WHERE ca_customer_id = '".$cu_ref1."' AND status= '1' ");
                $sql2 -> execute();
                $sql2 -> setFetchMode(PDO::FETCH_ASSOC);
                if( $sql2 -> rowCount()>0 ){
                    foreach( ($sql2 -> fetchAll()) as $key => $row ){
                        $cu_ref2 = $row['reference_no'];
                        $cuIds[] = $cu_ref2;

                        if(!$cu_ref2){
                            $ca_ta_ref = $row['ta_reference_no'];
                            levelConti($ca_ta_ref);
                        }else{
                            // corporate_agency customer level 2
                            $sql3 = $conn -> prepare("SELECT * FROM ca_customer WHERE ca_customer_id = '".$cu_ref2."' AND status= '1' ");
                            $sql3 -> execute();
                            $sql3 -> setFetchMode(PDO::FETCH_ASSOC);
                            if( $sql3 -> rowCount()>0 ){
                                foreach( ($sql3 -> fetchAll()) as $key => $row ){
                                    $cu_ref3 = $row['reference_no'];
                                    $cuIds[] = $cu_ref3; 

                                    if(!$cu_ref3){
                                        $ca_ta_ref = $row['ta_reference_no'];
                                        levelConti($ca_ta_ref);
                                    }else{
                                        $ca_ta_ref = $row['ta_reference_no'];
                                        levelConti($ca_ta_ref);

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

    function levelConti($ca_ta_ref){
        
        global $conn;
        global $cuIds2;

        $cuIds2[] = $ca_ta_ref; 

        // corporate_agency travel_agent
        $sql4 = $conn -> prepare("SELECT * FROM ca_travelagency WHERE ca_travelagency_id = '".$ca_ta_ref."' AND status= '1' ");
        $sql4 -> execute();
        $sql4 -> setFetchMode(PDO::FETCH_ASSOC);
        if( $sql4 -> rowCount()>0 ){
            foreach( ($sql4 -> fetchAll()) as $key => $row ){
                $ca_ref = $row['reference_no'];
                $cuIds2[] = $ca_ref; '<br>';
            }
        }

        // corporate_agency
        $sql5 = $conn -> prepare("SELECT * FROM corporate_agency WHERE corporate_agency_id = '".$ca_ref."' AND status= '1' ");
        $sql5 -> execute();
        $sql5 -> setFetchMode(PDO::FETCH_ASSOC);
        if( $sql5 -> rowCount()>0 ){
            foreach( ($sql5 -> fetchAll()) as $key => $row ){
                $bc_ref = $row['reference_no'];
                $cuIds2[] = $bc_ref; '<br>';
            }
        }
        
        return $cuIds2 ;
    }

    // echo $cu_ref1.'->'.$cu_ref2.'->'.$cu_ref3
    // print_r($cuIds);
    // print_r($cuIds2);
?>