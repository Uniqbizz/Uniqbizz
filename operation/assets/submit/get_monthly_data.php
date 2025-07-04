<?php
    require '../../connect.php'; 
    //get users count for right side row(beside chart)    
    // get data
    $get_month_year = $_POST['month_year']; //month and year
    $year = substr($get_month_year,0,4);    //year
    $month = substr($get_month_year,5,7);   //month
    $partner_cust_count=0;
    $partner_consultant_count=0;
    $cust_count=0;
    $directCust_count =0;
    $consultant_count=0;
    $partner_count=0;
    $corporate_partner_count=0;
    $business_trainee_count=0;
    $corporate_agency_count=0;
    $ca_travelagency_count=0;
    $ca_customer_count=0;
    $channel_business_director_count=0;
    $userTypeId = $_POST['userType'];
    $userId = $_POST['userId'];
    $sql="";
    $total_customer_partner=0;
    $total_referal_count =0; $level1_count =0; $level2_count =0; $level3_count =0; $level4_count =0; $level5_count =0; $level6_count =0; $level7_count=0;

   
    

        //for admin
        if($userTypeId=='0'){
            // customer count for admin
            $sql = $conn->prepare("SELECT COUNT(cust_id) as totalCount FROM customer where MONTH(register_date)='".$month."' AND YEAR(register_date)='".$year."' AND status='1' ");
            $sql->execute();
            $sql->setFetchMode(PDO::FETCH_ASSOC);
            if($sql->rowCount()>0){
                
                foreach ($sql->fetchAll() as $key => $row) {
                    $cust_count = $row['totalCount'] ;
                }
            }
            // consultant count for admin
            $sql2 = $conn->prepare("SELECT COUNT(business_consultant_id) as totalCount FROM business_consultant where MONTH(register_date)='".$month."' AND YEAR(register_date)='".$year."' AND status='1' ");
            $sql2->execute();
            $sql2->setFetchMode(PDO::FETCH_ASSOC);
            if($sql2->rowCount()>0){
                
                foreach ($sql2->fetchAll() as $key => $row) {
                    $consultant_count = $row['totalCount'] ;
                }
            }

            // partner count for admin
            $sql3 = $conn->prepare("SELECT COUNT(franchisee_id) as totalCount FROM franchisee where MONTH(register_date)='".$month."' AND YEAR(register_date)='".$year."' AND status='1' ");
            $sql3->execute();
            $sql3->setFetchMode(PDO::FETCH_ASSOC);
            if($sql3->rowCount()>0){
                
                foreach ($sql3->fetchAll() as $key => $row) {
                    $partner_count = $row['totalCount'] ;
                }
            }

            // partner count for corporate Partner
            $sql4 = $conn->prepare("SELECT COUNT(super_franchisee_id) as totalCount FROM super_franchisee where MONTH(register_date)='".$month."' AND YEAR(register_date)='".$year."' AND status='1' ");
            $sql4->execute();
            $sql4->setFetchMode(PDO::FETCH_ASSOC);
            if($sql4->rowCount()>0){
                
                foreach ($sql4->fetchAll() as $key => $row) {
                    $corporate_partner_count = $row['totalCount'] ;
                }
            }

            // partner count for Business Trainee
            $sql5 = $conn->prepare("SELECT COUNT(business_trainee_id) as totalCount FROM business_trainee where MONTH(register_date)='".$month."' AND YEAR(register_date)='".$year."' AND status='1' ");
            $sql5->execute();
            $sql5->setFetchMode(PDO::FETCH_ASSOC);
            if($sql5->rowCount()>0){
                
                foreach ($sql5->fetchAll() as $key => $row) {
                    $business_trainee_count = $row['totalCount'] ;
                }
            }

            //  count of Corporate Agency
            $sql5 = $conn->prepare("SELECT COUNT(corporate_agency_id) as totalCount FROM corporate_agency where MONTH(register_date)='".$month."' AND YEAR(register_date)='".$year."' AND status='1' ");
            $sql5->execute();
            $sql5->setFetchMode(PDO::FETCH_ASSOC);
            if($sql5->rowCount()>0){
                
                foreach ($sql5->fetchAll() as $key => $row) {
                    $corporate_agency_count = $row['totalCount'] ;
                }
            }

            //  count of CA Travel Agent
            $sql5 = $conn->prepare("SELECT COUNT(ca_travelagency_id) as totalCount FROM ca_travelagency where MONTH(register_date)='".$month."' AND YEAR(register_date)='".$year."' AND status='1' ");
            $sql5->execute();
            $sql5->setFetchMode(PDO::FETCH_ASSOC);
            if($sql5->rowCount()>0){
                
                foreach ($sql5->fetchAll() as $key => $row) {
                    $ca_travelagency_count = $row['totalCount'] ;
                }
            }

            //  count of CBD
            $sql5 = $conn->prepare("SELECT COUNT(channel_business_director_id) as totalCount FROM channel_business_director where MONTH(register_date)='".$month."' AND YEAR(register_date)='".$year."' AND status='1' ");
            $sql5->execute();
            $sql5->setFetchMode(PDO::FETCH_ASSOC);
            if($sql5->rowCount()>0){
                
                foreach ($sql5->fetchAll() as $key => $row) {
                    $channel_business_director_count = $row['totalCount'] ;
                }
            }

            //  count of CA Customer
            $sql5 = $conn->prepare("SELECT COUNT(ca_customer_id) as totalCount FROM ca_customer where MONTH(register_date)='".$month."' AND YEAR(register_date)='".$year."' AND status='1' ");
            $sql5->execute();
            $sql5->setFetchMode(PDO::FETCH_ASSOC);
            if($sql5->rowCount()>0){
                
                foreach ($sql5->fetchAll() as $key => $row) {
                    $ca_customer_count = $row['totalCount'] ;
                }
            }

        }else if($userTypeId=='3'){
            // refferal customer count for cunsultant in dashboard
            $sql6 = $conn->prepare("SELECT COUNT(cust_id) as totalCount FROM customer where ta_reference='".$userId."' AND MONTH(register_date)='".$month."' AND YEAR(register_date)='".$year."' AND status='1' ");
            $sql6->execute();
            $sql6->setFetchMode(PDO::FETCH_ASSOC);
            if($sql6->rowCount()>0){
                
                foreach ($sql6->fetchAll() as $key => $row) {
                    $cust_count = $row['totalCount'] ;
                }
            }
        }
        // else if($userTypeId=='4'){
        //    // consultant count for partner in dashboard
        //     //    $sql7 = $conn->prepare("SELECT travel_agent_id, COUNT(travel_agent_id) as totalConsultantCount FROM travel_agent where reference_no='".$userId."' AND MONTH(register_date)='".$month."' AND YEAR(register_date)='".$year."' AND status='1' ");
        //     $sql7 = $conn->prepare("SELECT * FROM travel_agent where reference_no='".$userId."' AND MONTH(register_date)='".$month."' AND YEAR(register_date)='".$year."' AND status='1' ");
        //     $sql7->execute();
        //     $sql7->setFetchMode(PDO::FETCH_ASSOC);
        //     if($sql7->rowCount()>0){
                
        //         foreach ($sql7->fetchAll() as $key => $row1) {
        //             $partner_consultant_count = $partner_consultant_count + 1 ;

        //             // $partner_consultant_count = $row['totalConsultantCount'] ;
        //             // $ta_id = $row['travel_agent_id'];
        //             // $sql8 = $conn->prepare("SELECT COUNT(cust_id) as totalCustCount FROM customer where ta_reference='".$ta_id."' AND MONTH(register_date)='".$month."' AND YEAR(register_date)='".$year."' AND status='1' ");

        //             $sql8 = $conn->prepare("SELECT * FROM customer where ta_reference='".$row1['travel_agent_id']."' AND MONTH(register_date)='".$month."' AND YEAR(register_date)='".$year."' AND status='1' ");
        //             $sql8->execute();
        //             $sql8->setFetchMode(PDO::FETCH_ASSOC);
        //             if($sql8->rowCount()>0){
        //                 foreach ($sql8->fetchAll() as $key => $row2) {
        //                     // $partner_cust_count = $row['totalCustCount'] ;
        //                     $partner_cust_count = $partner_cust_count + 1 ;

        //                 }
        //             }

        //         }
        //         $total_customer_partner = $partner_consultant_count + $partner_cust_count;
        //     }
        // }

        else if($userTypeId=='2'){
           // direct cust count for customer in dashboard
           $sql9 = $conn->prepare("SELECT * FROM customer where reference_no='".$userId."' AND MONTH(register_date)='".$month."' AND YEAR(register_date)='".$year."' AND status='1' ");
           $sql9->execute();
           $sql9->setFetchMode(PDO::FETCH_ASSOC);
           if($sql9->rowCount()>0){
               foreach ($sql9->fetchAll() as $key => $row1) {
                   $level1_count = $level1_count + 1 ;

                   //  level 2
                    $sql10 = $conn->prepare("SELECT cust_id FROM customer where reference_no='".$row1['cust_id']."' AND MONTH(register_date)='".$month."' AND YEAR(register_date)='".$year."' AND status='1' ");
                    $sql10->execute();
                    $sql10->setFetchMode(PDO::FETCH_ASSOC);
                    if($sql10->rowCount()>0){
                        foreach ($sql10->fetchAll() as $key => $row2) {
                            $level2_count = $level2_count + 1;
                            // level 3
                            $sql11 = $conn->prepare("SELECT cust_id FROM customer where reference_no='".$row2['cust_id']."' AND MONTH(register_date)='".$month."' AND YEAR(register_date)='".$year."' AND status='1' ");
                            $sql11->execute();
                            $sql11->setFetchMode(PDO::FETCH_ASSOC);
                            if($sql11->rowCount()>0){
                                foreach ($sql11->fetchAll() as $key => $row3) {
                                      $level3_count = $level3_count + 1;
                                    // level 4
                                    $sql12 = $conn->prepare("SELECT cust_id FROM customer where reference_no='".$row3['cust_id']."' AND MONTH(register_date)='".$month."' AND YEAR(register_date)='".$year."' AND status='1' ");
                                    $sql12->execute();
                                    $sql12->setFetchMode(PDO::FETCH_ASSOC);
                                    if($sql12->rowCount()>0){
                                        foreach ($sql12->fetchAll() as $key => $row4) {
                                              $level4_count = $level4_count + 1;
                                            // level 5
                                            $sql13 = $conn->prepare("SELECT cust_id FROM customer where reference_no='".$row4['cust_id']."' AND MONTH(register_date)='".$month."' AND YEAR(register_date)='".$year."' AND status='1' ");
                                            $sql13->execute();
                                            $sql13->setFetchMode(PDO::FETCH_ASSOC);
                                            if($sql13->rowCount()>0){
                                                foreach ($sql13->fetchAll() as $key => $row5) {
                                                      $level5_count = $level5_count + 1;

                                                    // level 6
                                                    $sql14 = $conn->prepare("SELECT cust_id FROM customer where reference_no='".$row5['cust_id']."' AND MONTH(register_date)='".$month."' AND YEAR(register_date)='".$year."' AND status='1' ");
                                                    $sql14->execute();
                                                    $sql14->setFetchMode(PDO::FETCH_ASSOC);
                                                    if($sql14->rowCount()>0){
                                                        foreach ($sql14->fetchAll() as $key => $row6) {
                                                                 $level6_count = $level6_count + 1;

                                                            // level 7
                                                            $sql15 = $conn->prepare("SELECT cust_id FROM customer where reference_no='".$row6['cust_id']."' AND MONTH(register_date)='".$month."' AND YEAR(register_date)='".$year."' AND status='1' ");
                                                            $sql15->execute();
                                                            $sql15->setFetchMode(PDO::FETCH_ASSOC);
                                                            if($sql15->rowCount()>0){
                                                                foreach ($sql15->fetchAll() as $key => $row7) {
                                                                       $level7_count = $level7_count + 1; ;
                                                                    }
                                                            }  // level 7   
                                                        }
                                                    }   // level 6  
                                                }
                                            }       // level 5
                                        }
                                    }      // level 4  
                                }
                            }     // level 3
                        }
                    }    //level 2
                }
                $total_referal_count = $level1_count + $level2_count + $level3_count + $level4_count + $level5_count + $level6_count + $level7_count;

            }        //level 1  
        }

        $data = ""  .$cust_count.","                    //customer count for admin 
                    .$consultant_count.","
                    .$partner_count.","
                    .$corporate_partner_count.","
                    .$business_trainee_count.","
                    .$directCust_count.","
                    .$partner_consultant_count.","
                    .$total_customer_partner.","
                    .$level1_count.","
                    .$total_referal_count.","
                    .$corporate_agency_count.","
                    .$ca_travelagency_count.","
                    .$ca_customer_count.","
                    .$channel_business_director_count."";


        $data = explode(',', $data);
        $data_ar =  json_encode($data);

        echo $data_ar;

?>
    