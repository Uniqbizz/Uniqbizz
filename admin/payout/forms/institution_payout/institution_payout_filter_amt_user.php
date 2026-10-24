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
        if($designation == 'zonal_manager'){
            $sqlId = "SELECT * FROM zonal_manager WHERE zonal_manager_id = '".$cap_id."' ";
        }else if($designation == 'master_franchisee'){
            $sqlId = "SELECT * FROM master_franchisee WHERE master_franchisee_id = '".$cap_id."' ";
        }else if($designation == 'sponsor_franchisee'){
            $sqlId = "SELECT * FROM sponsor_franchisee WHERE sponsor_franchisee_id = '".$cap_id."'";
        }else if($designation == 'business_development_manager'){
            $sqlId = "SELECT * FROM employees WHERE employee_id = '".$cap_id."'";
        }else if($designation == 'business_mentor'){
            $sqlId = "SELECT * FROM business_mentor WHERE business_mentor_id = '".$cap_id."'";
        }

        $stmt = $conn -> prepare($sqlId);
        $stmt -> execute();
        $stmt -> setFetchMode(PDO::FETCH_ASSOC);
        if($stmt->rowCount()>0){
            foreach(($stmt-> fetchALL()) as $key => $row){

                if($designation == 'zonal_manager' || $designation == 'business_development_manager'){
                    $fullName = $row['name'];
                    $sqlIdAmt = "SELECT SUM(commission_zm) as payout FROM sub_franchisee_payout WHERE zonal_manager = '".$cap_id."' AND YEAR(created_date) = '".$cap_year."' AND MONTH(created_date) = '".$cap_month."' ";
                }else if($designation == 'master_franchisee' || $designation == 'sponsor_franchisee' || $designation == 'business_mentor'){
                    $fullName = $row['firstname']. ' ' .$row['lastname'];
                    $sqlIdAmt = "SELECT SUM(commission_mf) as payout FROM `sub_franchisee_payout` WHERE master_franchisee = '".$cap_id."' AND YEAR(created_date) = '".$cap_year."' AND MONTH(created_date) = '".$cap_month."' ";
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

            }
        }
        // get Full name of selected user end 
    }else{
        // get Full name of selected user start 
        if($designation == 'zonal_manager'){
            $sqlId = "SELECT * FROM zonal_manager WHERE zonal_manager_id = '".$cap_id."' ";
        }else if($designation == 'master_franchisee'){
            $sqlId = "SELECT * FROM master_franchisee WHERE master_franchisee_id = '".$cap_id."' ";
        }else if($designation == 'sponsor_franchisee'){
            $sqlId = "SELECT * FROM sponsor_franchisee WHERE sponsor_franchisee_id = '".$cap_id."'";
        }else if($designation == 'business_development_manager'){
            $sqlId = "SELECT * FROM employees WHERE employee_id = '".$cap_id."'";
        }else if($designation == 'business_mentor'){
            $sqlId = "SELECT * FROM business_mentor WHERE business_mentor_id = '".$cap_id."'";
        }

        $stmt = $conn -> prepare($sqlId);
        $stmt -> execute();
        $stmt -> setFetchMode(PDO::FETCH_ASSOC);
        if($stmt->rowCount()>0){
            foreach(($stmt-> fetchALL()) as $key => $row){
                
                if($designation == 'zonal_manager' || $designation == "business_development_manager"){
                    $fullName = $row['name'];
                    $sqlIdAmt = "SELECT SUM(commission_zm) as payout FROM sub_franchisee_payout WHERE zonal_manager = '".$cap_id."' AND YEAR(created_date) = '".$cap_year."' AND MONTH(created_date) = '".$cap_month."'";
                }else if($designation == 'master_franchisee' || $designation == 'sponsor_franchisee' || $designation == 'business_mentor'){
                    $fullName = $row['firstname']. ' ' .$row['lastname'];
                    $sqlIdAmt = "SELECT SUM(commission_mf) as payout FROM `sub_franchisee_payout` WHERE master_franchisee = '".$cap_id."' AND YEAR(created_date) = '".$cap_year."' AND MONTH(created_date) = '".$cap_month."'";
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

                
                // get amount of selected user form sub_franchisee_payout table end 
            }
        }
        // get Full name of selected user end 
    }
      

    
?>