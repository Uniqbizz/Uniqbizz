 <!-- // next & prev model name & amount section replace  -->
 <?php
    require "../../../../connect.php";
   
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
        if($designation == 'Prime'){
            $sqlId = "SELECT * FROM ca_customer WHERE ca_customer_id = '".$cap_id."' AND customer_type='Prime' ";
        }
        if($designation == 'Premium'){
            $sqlId = "SELECT * FROM ca_customer WHERE ca_customer_id = '".$cap_id."' AND customer_type='Premium' ";
        }
        if($designation == 'Premium PLus'){
            $sqlId = "SELECT * FROM ca_customer WHERE ca_customer_id = '".$cap_id."' AND customer_type='Premium Plus' ";
        }
        if($designation == 'Premium Select'){
            $sqlId = "SELECT * FROM ca_customer WHERE ca_customer_id = '".$cap_id."' AND customer_type='Premium Select' ";
        }
        if($designation == 'Premium Select Lite'){
            $sqlId = "SELECT * FROM ca_customer WHERE ca_customer_id = '".$cap_id."' AND customer_type='Premium Select Lite' ";
        }

        $stmt = $conn -> prepare($sqlId);
        $stmt -> execute();
        $stmt -> setFetchMode(PDO::FETCH_ASSOC);
        if($stmt->rowCount()>0){
            foreach(($stmt-> fetchALL()) as $key => $row){

                if($designation == 'Prime' || $designation == 'Premium' || $designation == 'Premium Plus' || $designation == 'Premium Select' || $designation == 'Premium Select Lite'){
                    $fullName = $row['firstname']. ' ' .$row['lastname'];
                }
                
                if($designation == 'Prime'){
                    $sqlIdAmt = "SELECT SUM(referral_amount) as payout FROM customer_reference_payout WHERE customer_id = '".$cap_id."' AND YEAR(created_date) = '".$cap_year."' AND MONTH(created_date) = '".$cap_month."' AND customer_type='Prime' ";
                }
                if($designation == 'Premium'){
                    $sqlIdAmt = "SELECT SUM(referral_amount) as payout FROM customer_reference_payout WHERE customer_id = '".$cap_id."' AND YEAR(created_date) = '".$cap_year."' AND MONTH(created_date) = '".$cap_month."' AND customer_type='Premium' ";
                }
                if($designation == 'Premium Plus'){
                    $sqlIdAmt = "SELECT SUM(referral_amount) as payout FROM customer_reference_payout WHERE customer_id = '".$cap_id."' AND YEAR(created_date) = '".$cap_year."' AND MONTH(created_date) = '".$cap_month."' AND customer_type='Premium Plus' ";
                }
                if($designation == 'Premium Select'){
                    $sqlIdAmt = "SELECT SUM(referral_amount) as payout FROM customer_reference_payout WHERE customer_id = '".$cap_id."' AND YEAR(created_date) = '".$cap_year."' AND MONTH(created_date) = '".$cap_month."' AND customer_type='Premium Select' ";
                }
                if($designation == 'Premium Select Lite'){
                    $sqlIdAmt = "SELECT SUM(referral_amount) as payout FROM customer_reference_payout WHERE customer_id = '".$cap_id."' AND YEAR(created_date) = '".$cap_year."' AND MONTH(created_date) = '".$cap_month."' AND customer_type='Premium Select Lite' ";
                }

                $stmt = $conn->prepare($sqlIdAmt);
                $stmt->execute();
                $stmt->setFetchMode(PDO::FETCH_ASSOC);
                $totalPayout = 0;
                while ($row = $stmt->fetch()) {
                    $totalPayout += $row['payout'] ?? 0;
                }

                if ($totalPayout > 0) {
                    $tds = $totalPayout * $tdsPer; //tds
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
        if($designation == 'Prime'){
            $sqlId = "SELECT * FROM ca_customer WHERE ca_customer_id = '".$cap_id."' AND customer_type='Prime' ";
        }
        if($designation == 'Premium'){
            $sqlId = "SELECT * FROM ca_customer WHERE ca_customer_id = '".$cap_id."' AND customer_type='Premium' ";
        }
        if($designation == 'Premium Plus'){
            $sqlId = "SELECT * FROM ca_customer WHERE ca_customer_id = '".$cap_id."' AND customer_type='Premium Plus' ";
        }
        if($designation == 'Premium Select'){
            $sqlId = "SELECT * FROM ca_customer WHERE ca_customer_id = '".$cap_id."' AND customer_type='Premium Select' ";
        }
        if($designation == 'Premium Select Lite'){
            $sqlId = "SELECT * FROM ca_customer WHERE ca_customer_id = '".$cap_id."' AND customer_type='Premium Select Lite' ";
        }

        $stmt = $conn -> prepare($sqlId);
        $stmt -> execute();
        $stmt -> setFetchMode(PDO::FETCH_ASSOC);
        if($stmt->rowCount()>0){
            foreach(($stmt-> fetchALL()) as $key => $row){

                if($designation == 'Prime' || $designation == 'Premium' || $designation == 'Premium Plus' || $designation == 'Premium Select' || $designation == 'Premium Select Lite'){
                    $fullName = $row['firstname']. ' ' .$row['lastname'];
                }
                
                if($designation == 'Prime'){
                    $sqlIdAmt = "SELECT SUM(referral_amount) as payout FROM customer_reference_payout WHERE customer_id = '".$cap_id."' AND YEAR(created_date) = '".$cap_year."' AND MONTH(created_date) = '".$cap_month."' AND status = '1' AND customer_type='Prime";
                }
                if($designation == 'Premium'){
                    $sqlIdAmt = "SELECT SUM(referral_amount) as payout FROM customer_reference_payout WHERE customer_id = '".$cap_id."' AND YEAR(created_date) = '".$cap_year."' AND MONTH(created_date) = '".$cap_month."' AND status = '1' AND customer_type='Premium";
                }
                if($designation == 'Premium Plus'){
                    $sqlIdAmt = "SELECT SUM(referral_amount) as payout FROM customer_reference_payout WHERE customer_id = '".$cap_id."' AND YEAR(created_date) = '".$cap_year."' AND MONTH(created_date) = '".$cap_month."' AND status = '1' AND customer_type='Premium Plus";
                }
                if($designation == 'Premium Select'){
                    $sqlIdAmt = "SELECT SUM(referral_amount) as payout FROM customer_reference_payout WHERE customer_id = '".$cap_id."' AND YEAR(created_date) = '".$cap_year."' AND MONTH(created_date) = '".$cap_month."' AND status = '1' AND customer_type='Premium Select";
                }
                if($designation == 'Premium Select Lite'){
                    $sqlIdAmt = "SELECT SUM(referral_amount) as payout FROM customer_reference_payout WHERE customer_id = '".$cap_id."' AND YEAR(created_date) = '".$cap_year."' AND MONTH(created_date) = '".$cap_month."' AND status = '1' AND customer_type='Premium Select Lite";
                }

                $stmt = $conn->prepare($sqlIdAmt);
                $stmt->execute();
                $stmt->setFetchMode(PDO::FETCH_ASSOC);
                $totalPayout = 0;
                while ($row = $stmt->fetch()) {
                    $totalPayout += $row['payout'] ?? 0;
                }

                if ($totalPayout > 0) {
                    $tds = $totalPayout * $tdsPer; //tds
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