 <!-- // next & prev model name & amount section replace  -->
 <?php
    require "../../../connect.php";
   
    $cap_id = $_POST['cap_id'];
    $designation = $_POST['designation'];
    $cap_year = $_POST['year_split']?? '';
    $cap_month = $_POST['month_split']?? '';
    $identify = $_POST['identify'] ?? '';
    $tdsPer = 2/100;
    
    $fullName = "";
    $AmtFilter = "";

    if($identify == "prev&next"){
        // get Full name of selected user start 
        if($designation == 'business_mentor'){
            $sqlId = "SELECT * FROM business_mentor WHERE business_mentor_id = '".$cap_id."' ";
        }else if($designation == 'corporate_agency'){
            $sqlId = "SELECT * FROM corporate_agency WHERE corporate_agency_id = '".$cap_id."' ";
        }else if($designation == 'business_development_manager'){
            $sqlId = "SELECT * FROM employees WHERE employee_id = '".$cap_id."' AND user_type = '25' ";
        }

        $stmt = $conn -> prepare($sqlId);
        $stmt -> execute();
        $stmt -> setFetchMode(PDO::FETCH_ASSOC);
        if($stmt->rowCount()>0){
            foreach(($stmt-> fetchALL()) as $key => $row){

                if($designation == 'business_development_manager'){
                    $fullName = $row['name'];
                }else if($designation == 'business_mentor' || $designation == 'corporate_agency'){
                    $fullName = $row['firstname']. ' ' .$row['lastname'];
                }
                
                if($designation == 'business_development_manager'){
                    $sqlIdAmt = "SELECT SUM(comm_amt) as payout FROM goa_bdm_payout WHERE bdm_id = '".$cap_id."' AND YEAR(created_date) = '".$cap_year."' AND MONTH(created_date) = '".$cap_month."' ";
                }else if($designation == 'business_mentor'){
                    $sqlIdAmt = "SELECT SUM(comm_amt) as payout FROM `goa_bm_payout` WHERE bm_id = '".$cap_id."' AND YEAR(created_date) = '".$cap_year."' AND MONTH(created_date) = '".$cap_month."' UNION ALL
                            SELECT SUM(comm_amt) as payout FROM `ca_payout`  WHERE business_mentor = '".$cap_id."' AND YEAR(created_date) = '".$cap_year."' AND MONTH(created_date) = '".$cap_month."' UNION ALL
                            SELECT SUM(payout_amount) as payout FROM `bm_payout_history` WHERE bm_user_id = '".$cap_id."' AND YEAR(payout_amount) = '".$cap_year."' AND MONTH(payout_amount) = '".$cap_month."'
                            ";
                }else if($designation == 'corporate_agency'){
                    $sqlIdAmt = "SELECT SUM(comm_amt) as payout FROM `goa_bdm_payout` WHERE techno_enterprise = '".$cap_id."' AND YEAR(created_date) = '".$cap_year."' AND MONTH(created_date) = '".$cap_month."' UNION ALL
                            SELECT SUM(comm_amt) as payout FROM `goa_bm_payout` WHERE techno_enterprise = '".$cap_id."' AND YEAR(created_date) = '".$cap_year."' AND MONTH(created_date) = '".$cap_month."' UNION ALL
                            SELECT SUM(comm_amt) as payout FROM `ca_payout` WHERE techno_enterprise = '".$cap_id."' AND YEAR(created_date) = '".$cap_year."' AND MONTH(created_date) = '".$cap_month."' UNION ALL
                            SELECT SUM(payout_amount) as payout FROM `bm_payout_history` WHERE ca_user_id = '".$cap_id."' AND YEAR(payout_amount) = '".$cap_year."' AND MONTH(payout_amount) = '".$cap_month."'
                             ";
                }

                $stmt = $conn->prepare($sqlIdAmt);
                $stmt->execute();
                $stmt->setFetchMode(PDO::FETCH_ASSOC);
                $totalPayout = 0;
                while ($row = $stmt->fetch()) {
                    $totalPayout += $row['payout'] ?? 0;
                }

                if ($totalPayout > 0) {
                    $tds = $totalPayout * 0.02; //tds
                    $netPayout = $totalPayout - $tds;
                    echo '<div id="download_icon" style="border-radius: 10px; padding: 10px">
                            <p class="font-size-14">Name: <span>'.$fullName.'</span><span class="fw-bold font-size-10 ms-4 date-layout layout-2"><?php echo "$prevdate" ?></span></p>
                            <p class="fs-5 fw-bolder  icon">Rs. '.$netPayout.'/- </p>
                        </div>';
                }else{
                    echo '<div id="download_icon" style="border-radius: 10px; padding: 10px">
                            <p class="font-size-14">Name: <span>'.$fullName.'</span><span class="fw-bold font-size-10 ms-4 date-layout layout-2"><?php echo "$prevdate" ?></span></p>
                            <p class="fs-5 fw-bolder  icon">Rs. NA/- </p>
                        </div>';
                }

                
                // get amount of selected user form ca_ta_payout table end 
            }
        }
        // get Full name of selected user end 
    }else{
        // get Full name of selected user start 
        if($designation == 'business_mentor'){
            $sqlId = "SELECT * FROM business_mentor WHERE business_mentor_id = '".$cap_id."' ";
        }else if($designation == 'corporate_agency'){
            $sqlId = "SELECT * FROM corporate_agency WHERE corporate_agency_id = '".$cap_id."' ";
        }else if($designation == 'business_development_manager'){
            $sqlId = "SELECT * FROM employees WHERE employee_id = '".$cap_id."' AND user_type = '25' ";
        }

        $stmt = $conn -> prepare($sqlId);
        $stmt -> execute();
        $stmt -> setFetchMode(PDO::FETCH_ASSOC);
        if($stmt->rowCount()>0){
            foreach(($stmt-> fetchALL()) as $key => $row){

                if($designation == 'business_development_manager'){
                    $fullName = $row['name'];
                }else if($designation == 'business_mentor' || $designation == 'corporate_agency'){
                    $fullName = $row['firstname']. ' ' .$row['lastname'];
                }
                
                if($designation == 'business_development_manager'){
                    $sqlIdAmt = "SELECT SUM(comm_amt) as payout FROM goa_bdm_payout WHERE bdm_id = '".$cap_id."' AND YEAR(created_date) = '".$cap_year."' AND MONTH(created_date) = '".$cap_month."' AND status = '1' ";
                }else if($designation == 'business_mentor'){
                    $sqlIdAmt = "SELECT SUM(comm_amt) as payout FROM `goa_bm_payout` WHERE bm_id = '".$cap_id."' AND YEAR(created_date) = '".$cap_year."' AND MONTH(created_date) = '".$cap_month."' AND status = '1' UNION ALL
                            SELECT SUM(comm_amt) as payout FROM `ca_payout`  WHERE business_mentor = '".$cap_id."' AND YEAR(created_date) = '".$cap_year."' AND MONTH(created_date) = '".$cap_month."' AND status = '1' UNION ALL
                            SELECT SUM(payout_amount) as payout FROM `bm_payout_history` WHERE bm_user_id = '".$cap_id."' AND YEAR(payout_amount) = '".$cap_year."' AND MONTH(payout_amount) = '".$cap_month."' AND payout_status = '1'
                            ";
                }else if($designation == 'corporate_agency'){
                    $sqlIdAmt = "SELECT SUM(comm_amt) as payout FROM `goa_bdm_payout` WHERE techno_enterprise = '".$cap_id."' AND YEAR(created_date) = '".$cap_year."' AND MONTH(created_date) = '".$cap_month."' AND status = '1' UNION ALL
                            SELECT SUM(comm_amt) as payout FROM `goa_bm_payout` WHERE techno_enterprise = '".$cap_id."' AND YEAR(created_date) = '".$cap_year."' AND MONTH(created_date) = '".$cap_month."' AND status = '1' UNION ALL
                            SELECT SUM(comm_amt) as payout FROM `ca_payout` WHERE techno_enterprise = '".$cap_id."' AND YEAR(created_date) = '".$cap_year."' AND MONTH(created_date) = '".$cap_month."' AND status = '1' UNION ALL
                            SELECT SUM(payout_amount) as payout FROM `bm_payout_history` WHERE ca_user_id = '".$cap_id."' AND YEAR(payout_amount) = '".$cap_year."' AND MONTH(payout_amount) = '".$cap_month."' AND payout_status = '1'
                             ";
                }

                $stmt = $conn->prepare($sqlIdAmt);
                $stmt->execute();
                $stmt->setFetchMode(PDO::FETCH_ASSOC);
                $totalPayout = 0;
                while ($row = $stmt->fetch()) {
                    $totalPayout += $row['payout'] ?? 0;
                }

                if ($totalPayout > 0) {
                    $tds = $totalPayout * 0.02; //tds
                    $netPayout = $totalPayout - $tds;
                    echo '<div id="download_icon" style="border-radius: 10px; padding: 10px">
                            <p class="font-size-14">Name: <span>'.$fullName.'</span><span class="fw-bold font-size-10 ms-4 date-layout layout-2"><?php echo "$prevdate" ?></span></p>
                            <p class="fs-5 fw-bolder  icon">Rs. '.$netPayout.'/- </p>
                        </div>';
                }else{
                    echo '<div id="download_icon" style="border-radius: 10px; padding: 10px">
                            <p class="font-size-14">Name: <span>'.$fullName.'</span><span class="fw-bold font-size-10 ms-4 date-layout layout-2"><?php echo "$prevdate" ?></span></p>
                            <p class="fs-5 fw-bolder  icon">Rs. NA/- </p>
                        </div>';
                }

                
                // get amount of selected user form ca_ta_payout table end 
            }
        }
        // get Full name of selected user end 
    }
      

    
?>