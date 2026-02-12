 <!-- // next & prev model name & amount section replace  -->
 <?php
    require "../../../connect.php";
   
    $cap_id = $_POST['cap_id'];
    $designation = $_POST['designation'];
    $cap_year = $_POST['year_split']?? '';
    $cap_month = $_POST['month_split']?? '';
    $identify = $_POST['identify'] ?? '';

    $tdsPercentage=2/100;
    
    $fullName = "";
    $AmtFilter = "";

    if($identify == "prev&next"){
        // get Full name of selected user start 
        if($designation == 'master_franchisee'){
            $sqlId = "SELECT * FROM master_franchisee WHERE master_franchisee_id = '".$cap_id."' AND status = '1'";
        }else if($designation == 'sponsor_franchisee'){
            $sqlId = "SELECT * FROM sponsor_franchisee WHERE sponsor_franchisee_id = '".$cap_id."' AND status = '1'";
        }else if($designation == 'business_mentor'){
            $sqlId = "SELECT * FROM business_mentor WHERE business_mentor_id = '".$cap_id."' AND status = '1'";
        }else if($designation == 'corporate_agency'){
            $sqlId = "SELECT * FROM corporate_agency WHERE corporate_agency_id = '".$cap_id."' AND status = '1'";
        }else if($designation == 'sub_franchisee'){
            $sqlId = "SELECT * FROM sub_franchisee WHERE sub_franchisee_id = '".$cap_id."' AND status = '1'";
        }else if($designation == 'ca_travelagency'){
            $sqlId = "SELECT * FROM ca_travelagency WHERE ca_travelagency_id = '".$cap_id."' AND status = '1'";
        }else if($designation == 'ca_customer'){
            $sqlId = "SELECT * FROM ca_customer WHERE ca_customer_id = '".$cap_id."' AND status = '1'";
        }

        $stmt = $conn -> prepare($sqlId);
        $stmt -> execute();
        $stmt -> setFetchMode(PDO::FETCH_ASSOC);
        if($stmt->rowCount()>0){
            foreach(($stmt-> fetchALL()) as $key => $row){
                
                $fullName = $row['firstname']. ' ' .$row['lastname'];
                
                // get amount of selected user form ca_payout table start 
                if($designation == 'master_franchisee'){
                    $sqlIdAmt = "SELECT SUM(bm_amt) as prevPayoutAmt FROM product_payout WHERE bm_id = '".$cap_id."' AND bm_id LIKE 'MF%' AND YEAR(created_date) = '".$cap_year."' AND MONTH(created_date) = '".$cap_month."' ORDER BY id DESC";
                }else if($designation == 'sponsor_franchisee'){
                    $sqlIdAmt = "SELECT SUM(bm_amt) as prevPayoutAmt FROM product_payout WHERE bm_id = '".$cap_id."' AND bm_id LIKE 'SF%' AND YEAR(created_date) = '".$cap_year."' AND MONTH(created_date) = '".$cap_month."' ORDER BY id DESC";
                }else if($designation == 'business_mentor'){
                    $sqlIdAmt = "SELECT SUM(bm_amt) as prevPayoutAmt FROM product_payout WHERE bm_id = '".$cap_id."' AND bm_id LIKE 'BM%' AND YEAR(created_date) = '".$cap_year."' AND MONTH(created_date) = '".$cap_month."' ORDER BY id DESC";
                }else if($designation == 'corporate_agency'){
                    $sqlIdAmt = "SELECT SUM(te_amt) as prevPayoutAmt FROM product_payout WHERE te_id = '".$cap_id."' AND LEFT(te_id, 2) IN ('TE', 'CA') AND YEAR(created_date) = '".$cap_year."' AND MONTH(created_date) = '".$cap_month."' ORDER BY id DESC";
                }else if($designation == 'sub_franchisee'){
                    $sqlIdAmt = "SELECT SUM(te_amt) as prevPayoutAmt FROM product_payout WHERE te_id = '".$cap_id."' AND te_id LIKE 'F%' AND YEAR(created_date) = '".$cap_year."' AND MONTH(created_date) = '".$cap_month."' ORDER BY id DESC";
                }else if($designation == 'ca_travelagency'){
                    $sqlIdAmt = "SELECT SUM(ta_amt + ta_markup) as prevPayoutAmt FROM product_payout WHERE ta_id = '".$cap_id."' AND YEAR(created_date) = '".$cap_year."' AND MONTH(created_date) = '".$cap_month."' ORDER BY id DESC";
                }else if($designation == 'ca_customer'){
                    $sqlIdAmt = "SELECT  SUM(CASE WHEN cu1_id = '".$cap_id."' THEN cu1_amt ELSE 0 END) + SUM(CASE WHEN cu2_id = '".$cap_id."' THEN cu2_amt ELSE 0 END) + SUM(CASE WHEN cu3_id = '".$cap_id."' THEN cu3_amt ELSE 0 END) as prevPayoutAmt FROM product_payout WHERE (cu1_id = '".$cap_id."' OR cu2_id = '".$cap_id."' OR cu3_id = '".$cap_id."') AND YEAR(created_date) = '".$cap_year."' AND MONTH(created_date) = '".$cap_month."' ORDER BY id DESC";
                }
                $stmt2 = $conn -> prepare($sqlIdAmt);
                $stmt2 -> execute();
                $stmt2 -> setFetchMode(PDO::FETCH_ASSOC);
                // print_r($stmt2);
                if($stmt2->rowCount()>0){
                    foreach(($stmt2-> fetchALL()) as $key2 => $row2){
                        $AmtFilter = $row2['prevPayoutAmt'];
                        $amtFilterTDS = $AmtFilter * $tdsPercentage;
                        $finalAmt =  $AmtFilter - $amtFilterTDS;
                        $truncatedAmount = floor($finalAmt * 100) / 100;
                        echo'
                            <div id="download_icon" style="border-radius: 10px; padding: 10px">
                                <p class="font-size-14">Name: <span>'.$fullName.'</span><span class="fw-bold font-size-10 ms-4 date-layout layout-2"><?php echo "$prevdate" ?></span></p>
                                <p class="fs-5 fw-bolder  icon">Rs. '.number_format($truncatedAmount, 2).'/- </p>
                            </div>
                        ';
                    }
                }
                // get amount of selected user form ca_ta_payout table end 
            }
        }
        // get Full name of selected user end 
    }else{

        if($designation == 'master_franchisee'){
            $sqlId = "SELECT * FROM master_franchisee WHERE master_franchisee_id = '".$cap_id."' AND status = '1'";
        }else if($designation == 'sponsor_franchisee'){
            $sqlId = "SELECT * FROM sponsor_franchisee WHERE sponsor_franchisee_id = '".$cap_id."' AND status = '1'";
        }else if($designation == 'business_mentor'){
            $sqlId = "SELECT * FROM business_mentor WHERE business_mentor_id = '".$cap_id."' AND status = '1'";
        }else if($designation == 'corporate_agency'){
            $sqlId = "SELECT * FROM corporate_agency WHERE corporate_agency_id = '".$cap_id."' AND status = '1'";
        }else if($designation == 'sub_franchisee'){
            $sqlId = "SELECT * FROM sub_franchisee WHERE sub_franchisee_id = '".$cap_id."' AND status = '1'";
        }else if($designation == 'ca_travelagency'){
            $sqlId = "SELECT * FROM ca_travelagency WHERE ca_travelagency_id = '".$cap_id."' AND status = '1'";
        }else if($designation == 'ca_customer'){
            $sqlId = "SELECT * FROM ca_customer WHERE ca_customer_id = '".$cap_id."' AND status = '1'";
        }

        $stmt = $conn -> prepare($sqlId);
        $stmt -> execute();
        $stmt -> setFetchMode(PDO::FETCH_ASSOC);
        if($stmt->rowCount()>0){
            foreach(($stmt-> fetchALL()) as $key => $row){
                
                $fullName = $row['firstname']. ' ' .$row['lastname'];
                
                // get amount of selected user form ca_payout table start 
                if($designation == 'master_franchisee'){
                    $sqlIdAmt = "SELECT SUM(bm_amt) as prevPayoutAmt FROM product_payout WHERE bm_id = '".$cap_id."' AND bm_id LIKE 'MF%'  ORDER BY id DESC";
                }else if($designation == 'sponsor_franchisee'){
                    $sqlIdAmt = "SELECT SUM(bm_amt) as prevPayoutAmt FROM product_payout WHERE bm_id = '".$cap_id."' AND bm_id LIKE 'SF%'  ORDER BY id DESC";
                }else if($designation == 'business_mentor'){
                    $sqlIdAmt = "SELECT SUM(bm_amt) as prevPayoutAmt FROM product_payout WHERE bm_id = '".$cap_id."' AND bm_id LIKE 'BM%'  ORDER BY id DESC";
                }else if($designation == 'corporate_agency'){
                    $sqlIdAmt = "SELECT SUM(te_amt) as prevPayoutAmt FROM product_payout WHERE te_id = '".$cap_id."' AND LEFT(te_id,0,2) IN ('TE','CA')  ORDER BY id DESC";
                }else if($designation == 'sub_franchisee'){
                    $sqlIdAmt = "SELECT SUM(te_amt) as prevPayoutAmt FROM product_payout WHERE te_id = '".$cap_id."' AND te_id LIKE 'F%'  ORDER BY id DESC";
                }else if($designation == 'ca_travelagency'){
                    $sqlIdAmt = "SELECT SUM(ta_amt + ta_markup) as prevPayoutAmt FROM product_payout WHERE ta_id = '".$cap_id."'  ORDER BY id DESC";
                }else if($designation == 'ca_customer'){
                    $sqlIdAmt = "SELECT  SUM(CASE WHEN cu1_id = '".$cap_id."' THEN cu1_amt ELSE 0 END) + SUM(CASE WHEN cu2_id = '".$cap_id."' THEN cu2_amt ELSE 0 END) + SUM(CASE WHEN cu3_id = '".$cap_id."' THEN cu3_amt ELSE 0 END) as prevPayoutAmt FROM product_payout WHERE (cu1_id = '".$cap_id."' OR cu2_id = '".$cap_id."' OR cu3_id = '".$cap_id."')  ORDER BY id DESC";
                }
                $stmt2 = $conn -> prepare($sqlIdAmt);
                $stmt2 -> execute();
                $stmt2 -> setFetchMode(PDO::FETCH_ASSOC);
                // print_r($stmt2);
                if($stmt2->rowCount()>0){
                    foreach(($stmt2-> fetchALL()) as $key2 => $row2){
                        $AmtFilter = $row2['prevPayoutAmt'];
                        $amtFilterTDS = $AmtFilter * $tdsPercentage;
                        $finalAmt =  $AmtFilter - $amtFilterTDS;
                        $truncatedAmount = floor($finalAmt * 100) / 100;
                        echo'
                            <div id="download_icon" style="border-radius: 10px; padding: 10px">
                                <p class="font-size-14">Name: <span>'.$fullName.'</span><span class="fw-bold font-size-10 ms-4 date-layout layout-2"><?php echo "$prevdate" ?></span></p>
                                <p class="fs-5 fw-bolder  icon">Rs. '.number_format($truncatedAmount, 2).'/- </p>
                            </div>
                        ';
                    }
                }
                // get amount of selected user form ca_ta_payout table end 
            }
        }
    }
      

    
?>