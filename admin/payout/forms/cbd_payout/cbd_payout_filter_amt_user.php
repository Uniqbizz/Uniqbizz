 <!-- // next & prev model name & amount section replace  -->
 <?php
    require "../../../connect.php";
   
    $cap_id = $_POST['cap_id'];
    $designation = $_POST['designation'];
    $cap_year = $_POST['year_split']?? '';
    $cap_month = $_POST['month_split']?? '';
    $identify = $_POST['identify'] ?? '';
    
    $fullName = "";
    $AmtFilter = "";

    if($identify == "prev&next"){
        // get Full name of selected user start 
        $sqlId = "SELECT * FROM channel_business_director WHERE channel_business_director_id = '".$cap_id."' AND status = '1'";
        $stmt = $conn -> prepare($sqlId);
        $stmt -> execute();
        $stmt -> setFetchMode(PDO::FETCH_ASSOC);
        if($stmt->rowCount()>0){
            foreach(($stmt-> fetchALL()) as $key => $row){
                $fullName = $row['firstname']. ' ' .$row['lastname'];

                // get amount of selected user form ca_payout table start 
                $sqlIdAmt = "SELECT SUM(amount) as prevPayoutAmt FROM cbd_payout WHERE cbd_id = '".$cap_id."' AND YEAR(created_date) = '".$cap_year."' AND MONTH(created_date) = '".$cap_month."' order by id DESC";
                $stmt2 = $conn -> prepare($sqlIdAmt);
                $stmt2 -> execute();
                $stmt2 -> setFetchMode(PDO::FETCH_ASSOC);
                if($stmt2->rowCount()>0){
                    foreach(($stmt2-> fetchALL()) as $key2 => $row2){
                        $AmtFilter = $row2['prevPayoutAmt'];

                        echo'
                            <div id="download_icon" style="border-radius: 10px; padding: 10px">
                                <p class="font-size-14">Name: <span>'.$fullName.'</span><span class="fw-bold font-size-10 ms-4 date-layout layout-2"><?php echo "$prevdate" ?></span></p>
                                <p class="fs-5 fw-bolder  icon">Rs. '.$AmtFilter.'/- </p>
                            </div>
                        ';
                    }
                }
                // get amount of selected user form ca_ta_payout table end 
            }
        }
        // get Full name of selected user end 
    }else{
        // get Full name of selected user star
        $sqlId = "SELECT * FROM channel_business_director WHERE channel_business_director_id = '".$cap_id."' AND status = '1'";
        $stmt = $conn -> prepare($sqlId);
        $stmt -> execute();
        $stmt -> setFetchMode(PDO::FETCH_ASSOC);
        if($stmt->rowCount()>0){
            foreach(($stmt-> fetchALL()) as $key => $row){
                $fullName = $row['firstname']. ' ' .$row['lastname'];

                // get amount of selected user form ca_ta_payout table start 
                $sqlIdAmt = "SELECT SUM(amount) as PayoutAmt FROM cbd_payout WHERE cbd_id = '".$cap_id."'  AND status = '1' order by id DESC";
                $stmt2 = $conn -> prepare($sqlIdAmt);
                $stmt2 -> execute();
                $stmt2 -> setFetchMode(PDO::FETCH_ASSOC);
                if($stmt2->rowCount()>0){
                    foreach(($stmt2-> fetchALL()) as $key2 => $row2){
                        $AmtFilter = $row2['PayoutAmt'];

                        echo'
                            <div id="download_icon" style="border-radius: 10px; padding: 10px">
                                <p class="font-size-14">Name: <span>'.$fullName.'</span><span class="fw-bold font-size-10 ms-4 date-layout layout-2"><?php echo "$prevdate" ?></span></p>
                                <p class="fs-5 fw-bolder  icon">Rs. '.$AmtFilter.'/- </p>
                            </div>
                        ';
                    }
                }
                // get amount of selected user form ca_ta_payout table end 
            }
        }
        // get Full name of selected user end 
    }
      

    
?>