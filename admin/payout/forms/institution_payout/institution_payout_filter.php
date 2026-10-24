<!-- all payout section filter + previous + next + total card section  -->
<?php

require "../../../connect.php";

$cap_id = $_POST['cap_id'] ?? '';
$designation = $_POST['designation'] ?? '' ;
$cap_year = $_POST['year_split']?? '';
$cap_month = $_POST['month_split']?? '';
$TotalPayoutFilter = $_POST['TotalPayoutFilter']?? '';
$perTDS = 2/100;
$tdsPer = 2/100;
$allPayout = $_POST['allPayout'] ?? '';

    if($allPayout){ // all records will be shown on payout page load 

        $sql = "
        (
            SELECT
                id,
                employees AS userId,
                message_emp AS message,
                commission_emp AS comm_amt,
                status_emp AS status,
                institution,
                created_date
            FROM institution_payout
            WHERE
                employees IS NOT NULL
                AND TRIM(employees) NOT IN ('NA','Not Applicable','')
                AND TRIM(message_emp) NOT IN ('NA','Not Applicable','')
                AND commission_emp > 0
        )
        
        UNION ALL
        
        (
            SELECT
                id,
                bm_mf_sf AS userId,
                message_bm_mf_sf AS message,
                commission_bm_mf_sf AS comm_amt,
                status_bm_mf_sf AS status,
                institution,
                created_date
            FROM institution_payout
            WHERE
                bm_mf_sf IS NOT NULL
                AND TRIM(bm_mf_sf) NOT IN ('NA','Not Applicable','')
                AND TRIM(message_bm_mf_sf) NOT IN ('NA','Not Applicable','')
                AND commission_bm_mf_sf > 0
        )
        
        ORDER BY created_date DESC
        ";
        $stmt = $conn -> prepare($sql);
        $stmt -> execute();
        $stmt -> setFetchMode(PDO::FETCH_ASSOC);
        if( $stmt -> rowCount()>0 ){
            foreach( ($stmt -> fetchALL()) as $key => $row ){

                // date in proper formate
                $dt = new DateTime($row['created_date']);
                $dt = $dt->format('Y-m-d');

                // replace dot at end of the line with break statement
                $message1 = $row['message'];
                $message1 =  str_replace('.','<br>',$message1);  

                $user_desig = "NA";
                //to get the prefix charater before first -
                preg_match('/^(.*?)\s*-\s*/', $message1, $match);

                if (!empty($match[1])) {
                    $user_desig = trim($match[1]); // Output only the text before the first dash
                } 
                ///-------

                // total Amt Cal for BC 
                if($row['comm_amt'] == "null"){
                    $CommAmt = "null";
                    $tds = "null";
                    $totalAmt = "null";
                }else{
                    $CommAmt = $row['comm_amt'];
                    $tds = $CommAmt * $tdsPer;
                    $totalAmt = $CommAmt - $tds;
                }
                
                echo '<tr>
                        <td>'.$dt.'</td>
                        <td>'.$message1.'</td>
                        <td class="text-end">'.$CommAmt.'</td>
                        <td class="text-end">'.$tds.'</td>
                        <td class="text-end">'.$totalAmt.'
                            <a href="forms/institution_payout/download_institution_payout.php?
                                vkvbvjfgfikix='.urlencode($row['id']).'
                                &userId='.urlencode($row['userId']).'
                                &te='.urlencode($row['institution']).'
                                &date='.urlencode($dt).'
                                &message='.urlencode($message1).'
                                &message_status='.urlencode($row['status']).'
                                &commission='.urlencode($row['comm_amt']).'">
                                <i class="bx bx-download" style="font-size:18px; color:black; padding-left:5px;"></i>
                            </a>
                        </td>';
                        if($row['status'] == '1'){
                            echo'<td><span class="badge badge-pill badge-soft-success font-size-10 fw-bold ms-4">Paid</span></td>';
                        }else{
                            echo '<td><span class="badge badge-pill badge-soft-warning font-size-10 fw-bold ms-4" 
                                data-bs-toggle="modal" 
                                data-bs-target=".bs-example-modal-center" 
                                onclick=\'paymentId('
                                . json_encode($row['id']) . ','
                                . json_encode($row['userId']) . ','
                                . json_encode($row['institution']) . ','
                                . json_encode($message1) . ','
                                . json_encode($row['comm_amt']) . ','
                                . json_encode($row['status']) . ','
                                . json_encode($user_desig) . ')\'>' 
                                . 'Pending</span></td>';
                        }
                echo'</tr>';

            }
        } else {
            echo '<div class="alert alert-info">No payout data available.</div>';
        }
    
    }else if($TotalPayoutFilter && empty($allPayout)){ // when admin selects filter from inside total payout card section 
        $sqlId = "";
        if ($designation == 'zonal_manager' || $designation == 'business_development_manager') {
            $sqlId = "SELECT id, zonal_manager AS userId, message_zm AS message, commission_zm as comm_amt, status_zm as status, sub_franchisee, created_date FROM sub_franchisee_payout WHERE (zonal_manager <> 'NA' AND zonal_manager <> 'Not Applicable' AND zonal_manager IS NOT NULL) AND zonal_manager = '".$cap_id."' AND YEAR(created_date) = '".$cap_year."' AND MONTH(created_date) = '".$cap_month."' ORDER BY id DESC";
        } else if ($designation == 'master_franchisee' || $designation == 'sponsor_franchisee' || $designation == 'business_mentor') {
            $sqlId = "SELECT id, master_franchisee AS userId, message_mf AS message, commission_mf AS comm_amt, status_mf as status, sub_franchisee, created_date FROM sub_franchisee_payout WHERE master_franchisee = '".$cap_id."' AND YEAR(created_date) = '".$cap_year."' AND MONTH(created_date) = '".$cap_month."' ORDER BY id DESC";
        } 

        $stmt = $conn->prepare($sqlId);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        // print_r($stmt);
        if ($stmt->rowCount() > 0) {
            echo '<div class="table-responsive table-desi" id="filterTable">';
            echo '<table class="table table-hover" id="payoutDetailsTable">
                    <thead>
                        <tr>
                            <th class="ceterText fw-bolder font-size-16">Date</th>
                            <th class="ceterText fw-bolder font-size-16">Payout Details</th>
                            <th class="ceterText fw-bolder font-size-16">Amount</th>
                            <th class="ceterText fw-bolder font-size-16">TDS</th>
                            <th class="ceterText fw-bolder font-size-16">Total Payable</th>
                            <th class="ceterText fw-bolder font-size-16">Remark</th>
                        </tr>
                    </thead>
                    <tbody>';

            foreach ($stmt->fetchAll() as $row) {
                // date in proper formate
                $dt = new DateTime($row['created_date']);
                $dt = $dt->format('Y-m-d');

                // replace dot at end of the line with break statement
                $message1 = $row['message'];
                $message1 =  str_replace('.','<br>',$message1);  

                $user_desig = "NA";
                //to get the prefix charater before first -
                preg_match('/^(.*?)\s*-\s*/', $message1, $match);

                if (!empty($match[1])) {
                    $user_desig = trim($match[1]); // Output only the text before the first dash
                } 
                ///-------

                // total Amt Cal for BC 
                if($row['comm_amt'] == "null"){
                    $CommAmt = "null";
                    $tds = "null";
                    $totalAmt = "null";
                }else{
                    $CommAmt = $row['comm_amt'];
                    $tds = $CommAmt * $tdsPer;
                    $totalAmt = $CommAmt - $tds;
                }
                
                echo '<tr>
                        <td>'.$dt.'</td>
                        <td>'.$message1.'</td>
                        <td class="text-end">'.$CommAmt.'</td>
                        <td class="text-end">'.$tds.'</td>
                        <td class="text-end">'.$totalAmt.'
                            <a href="forms/sub_franchisee/download_ca_payout.php?
                                vkvbvjfgfikix='.urlencode($row['id']).'
                                &userId='.urlencode($row['userId']).'
                                &te='.urlencode($row['sub_franchisee']).'
                                &date='.urlencode($dt).'
                                &message='.urlencode($message1).'
                                &message_status='.urlencode($row['status']).'
                                &commission='.urlencode($row['comm_amt']).'">
                                <i class="bx bx-download" style="font-size:18px; color:black; padding-left:5px;"></i>
                            </a>
                        </td>';
                        if($row['status'] == '1'){
                            echo'<td><span class="badge badge-pill badge-soft-success font-size-10 fw-bold ms-4">Paid</span></td>';
                        }else{
                            echo '<td><span class="badge badge-pill badge-soft-warning font-size-10 fw-bold ms-4" 
                                data-bs-toggle="modal" 
                                data-bs-target=".bs-example-modal-center" 
                                onclick=\'paymentId('
                                . json_encode($row['id']) . ','
                                . json_encode($row['userId']) . ','
                                . json_encode($row['sub_franchisee']) . ','
                                . json_encode($message1) . ','
                                . json_encode($row['comm_amt']) . ','
                                . json_encode($row['status']) . ','
                                . json_encode($user_desig) . ')\'>' 
                                . 'Pending</span></td>';
                        }
                echo'</tr>';
            }

            echo '</tbody></table></div>';
        } else {
            echo '<div class="alert alert-info">No payout data available for this designation.</div>';
        }
    }else if(!$cap_id && !$cap_year && !$cap_month && empty($allPayout)){ // if only designation filter

        $sqlId = "";
        if ($designation == 'zonal_manager' || $designation == 'business_development_manager') {
            $sqlId = "SELECT id, zonal_manager AS userId, message_zm AS message, commission_zm as comm_amt, status_zm as status, sub_franchisee, created_date FROM sub_franchisee_payout WHERE (zonal_manager <> 'NA' AND zonal_manager <> 'Not Applicable' AND zonal_manager IS NOT NULL) ORDER BY id DESC";
        } else if ($designation == 'master_franchisee') {
            $sqlId = "SELECT id, master_franchisee AS userId, message_mf AS message, commission_mf AS comm_amt, status_mf as status, sub_franchisee, created_date FROM sub_franchisee_payout WHERE (master_franchisee <> 'NA' AND master_franchisee <> 'Not Applicable' AND master_franchisee IS NOT NULL) AND master_franchisee LIKE 'MF%' ORDER BY id DESC";
        } else if ($designation == 'sponsor_franchisee') {
            $sqlId = "SELECT id, master_franchisee AS userId, message_mf AS message, commission_mf AS comm_amt, status_mf as status, created_date, sub_franchisee FROM sub_franchisee_payout WHERE (master_franchisee <> 'NA' AND master_franchisee <> 'Not Applicable' AND master_franchisee IS NOT NULL) AND master_franchisee LIKE 'SF%' ORDER BY id DESC";
        } else if ($designation == 'business_mentor') {
            $sqlId = "SELECT id, master_franchisee AS userId, message_mf AS message, commission_mf AS comm_amt, status_mf as status, created_date, sub_franchisee FROM sub_franchisee_payout WHERE (master_franchisee <> 'NA' AND master_franchisee <> 'Not Applicable' AND master_franchisee IS NOT NULL) AND master_franchisee LIKE 'BM%' ORDER BY id DESC";
        } 

        $stmt = $conn->prepare($sqlId);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        // print_r($stmt);
        if ($stmt->rowCount() > 0) {
            echo '<div class="table-responsive table-desi" id="filterTable">';
            echo '<table class="table table-hover" id="payoutDetailsTable">
                    <thead>
                        <tr>
                            <th class="ceterText fw-bolder font-size-16">Date</th>
                            <th class="ceterText fw-bolder font-size-16">Payout Details</th>
                            <th class="ceterText fw-bolder font-size-16">Amount</th>
                            <th class="ceterText fw-bolder font-size-16">TDS</th>
                            <th class="ceterText fw-bolder font-size-16">Total Payable</th>
                            <th class="ceterText fw-bolder font-size-16">Remark</th>
                        </tr>
                    </thead>
                    <tbody>';

            foreach ($stmt->fetchAll() as $row) {
                // date in proper formate
                $dt = new DateTime($row['created_date']);
                $dt = $dt->format('Y-m-d');

                // replace dot at end of the line with break statement
                $message1 = $row['message'];
                $message1 =  str_replace('.','<br>',$message1);  

                $user_desig = "NA";
                //to get the prefix charater before first -
                preg_match('/^(.*?)\s*-\s*/', $message1, $match);

                if (!empty($match[1])) {
                    $user_desig = trim($match[1]); // Output only the text before the first dash
                } 
                ///-------

                // total Amt Cal for BC 
                if($row['comm_amt'] == "null"){
                    $CommAmt = "null";
                    $tds = "null";
                    $totalAmt = "null";
                }else{
                    $CommAmt = $row['comm_amt'];
                    $tds = $CommAmt * $tdsPer;
                    $totalAmt = $CommAmt - $tds;
                }
                
                echo '<tr>
                        <td>'.$dt.'</td>
                        <td>'.$message1.'</td>
                        <td class="text-end">'.$CommAmt.'</td>
                        <td class="text-end">'.$tds.'</td>
                        <td class="text-end">'.$totalAmt.'
                            <a href="forms/sub_franchisee/download_ca_payout.php?
                                vkvbvjfgfikix='.urlencode($row['id']).'
                                &userId='.urlencode($row['userId']).'
                                &te='.urlencode($row['sub_franchisee']).'
                                &date='.urlencode($dt).'
                                &message='.urlencode($message1).'
                                &message_status='.urlencode($row['status']).'
                                &commission='.urlencode($row['comm_amt']).'">
                                <i class="bx bx-download" style="font-size:18px; color:black; padding-left:5px;"></i>
                            </a>
                        </td>';
                        if($row['status'] == '1'){
                            echo'<td><span class="badge badge-pill badge-soft-success font-size-10 fw-bold ms-4">Paid</span></td>';
                        }else{
                            echo '<td><span class="badge badge-pill badge-soft-warning font-size-10 fw-bold ms-4" 
                                data-bs-toggle="modal" 
                                data-bs-target=".bs-example-modal-center" 
                                onclick=\'paymentId('
                                . json_encode($row['id']) . ','
                                . json_encode($row['userId']) . ','
                                . json_encode($row['sub_franchisee']) . ','
                                . json_encode($message1) . ','
                                . json_encode($row['comm_amt']) . ','
                                . json_encode($row['status']) . ','
                                . json_encode($user_desig) . ')\'>' 
                                . 'Pending</span></td>';
                        }
                echo'</tr>';
            }

            echo '</tbody></table></div>';
        } else {
            echo '<div class="alert alert-info">No payout data available for this designation.</div>';
        }

    }else if(!$cap_year && !$cap_month && empty($allPayout)){ // if only id and designation filter

        $sqlId = "";
        if ($designation == 'zonal_manager' || $designation == 'business_development_manager') {
            $sqlId = "SELECT id, zonal_manager AS userId, message_zm AS message, commission_zm as comm_amt, status_zm as status, sub_franchisee, created_date FROM sub_franchisee_payout WHERE (zonal_manager <> 'NA' AND zonal_manager <> 'Not Applicable' AND zonal_manager IS NOT NULL) AND zonal_manager = '".$cap_id."' ORDER BY id DESC";
        } else if ($designation == 'master_franchisee' || $designation == 'sponsor_franchisee' || $designation == 'business_mentor') {
            $sqlId = "SELECT id, master_franchisee AS userId, message_mf AS message, commission_mf AS comm_amt, status_mf as status, sub_franchisee, created_date FROM sub_franchisee_payout WHERE (master_franchisee <> 'NA' AND master_franchisee <> 'Not Applicable' AND master_franchisee IS NOT NULL) AND master_franchisee = '".$cap_id."' ORDER BY id DESC";
        } 

        $stmt = $conn->prepare($sqlId);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        // print_r($stmt);
        if ($stmt->rowCount() > 0) {
            echo '<div class="table-responsive table-desi" id="filterTable">';
            echo '<table class="table table-hover" id="payoutDetailsTable">
                    <thead>
                        <tr>
                            <th class="ceterText fw-bolder font-size-16">Date</th>
                            <th class="ceterText fw-bolder font-size-16">Payout Details</th>
                            <th class="ceterText fw-bolder font-size-16">Amount</th>
                            <th class="ceterText fw-bolder font-size-16">TDS</th>
                            <th class="ceterText fw-bolder font-size-16">Total Payable</th>
                            <th class="ceterText fw-bolder font-size-16">Remark</th>
                        </tr>
                    </thead>
                    <tbody>';

            foreach ($stmt->fetchAll() as $row) {
                // date in proper formate
                $dt = new DateTime($row['created_date']);
                $dt = $dt->format('Y-m-d');

                // replace dot at end of the line with break statement
                $message1 = $row['message'];
                $message1 =  str_replace('.','<br>',$message1);  

                $user_desig = "NA";
                //to get the prefix charater before first -
                preg_match('/^(.*?)\s*-\s*/', $message1, $match);

                if (!empty($match[1])) {
                    $user_desig = trim($match[1]); // Output only the text before the first dash
                } 
                ///-------

                // total Amt Cal for BC 
                if($row['comm_amt'] == "null"){
                    $CommAmt = "null";
                    $tds = "null";
                    $totalAmt = "null";
                }else{
                    $CommAmt = $row['comm_amt'];
                    $tds = $CommAmt * $tdsPer;
                    $totalAmt = $CommAmt - $tds;
                }
                
                echo '<tr>
                        <td>'.$dt.'</td>
                        <td>'.$message1.'</td>
                        <td class="text-end">'.$CommAmt.'</td>
                        <td class="text-end">'.$tds.'</td>
                        <td class="text-end">'.$totalAmt.'
                            <a href="forms/sub_franchisee/download_ca_payout.php?
                                vkvbvjfgfikix='.urlencode($row['id']).'
                                &userId='.urlencode($row['userId']).'
                                &te='.urlencode($row['sub_franchisee']).'
                                &date='.urlencode($dt).'
                                &message='.urlencode($message1).'
                                &message_status='.urlencode($row['status']).'
                                &commission='.urlencode($row['comm_amt']).'">
                                <i class="bx bx-download" style="font-size:18px; color:black; padding-left:5px;"></i>
                            </a>
                        </td>';
                        if($row['status'] == '1'){
                            echo'<td><span class="badge badge-pill badge-soft-success font-size-10 fw-bold ms-4">Paid</span></td>';
                        }else{
                            echo '<td><span class="badge badge-pill badge-soft-warning font-size-10 fw-bold ms-4" 
                                data-bs-toggle="modal" 
                                data-bs-target=".bs-example-modal-center" 
                                onclick=\'paymentId('
                                . json_encode($row['id']) . ','
                                . json_encode($row['userId']) . ','
                                . json_encode($row['sub_franchisee']) . ','
                                . json_encode($message1) . ','
                                . json_encode($row['comm_amt']) . ','
                                . json_encode($row['status']) . ','
                                . json_encode($user_desig) . ')\'>' 
                                . 'Pending</span></td>';
                        }
                echo'</tr>';
            }

            echo '</tbody></table></div>';
        } else {
            echo '<div class="alert alert-info">No payout data available for this designation.</div>';
        }

    }else if(!$cap_id && !$designation && empty($allPayout)){    // if only date filter are their 
       
        // $sqlId = "SELECT id, master_franchisee AS userId, message_mf AS message, commission_mf AS comm_amt, status_mf as status, sub_franchisee, created_date FROM sub_franchisee_payout WHERE (master_franchisee <> 'NA' AND master_franchisee <> 'Not Applicable' AND master_franchisee IS NOT NULL) AND YEAR(created_date) = '".$cap_year."' AND MONTH(created_date) = '".$cap_month."' ORDER BY id DESC";
        $sqlId = "  (SELECT id, zonal_manager AS userId, message_zm AS message, commission_zm as comm_amt, status_zm as status, sub_franchisee, created_date FROM sub_franchisee_payout WHERE (zonal_manager <> 'NA' AND zonal_manager <> 'Not Applicable' AND zonal_manager IS NOT NULL) AND  YEAR(created_date) = '".$cap_year."' AND MONTH(created_date) = '".$cap_month."') 
                    UNION
                    (SELECT id, master_franchisee AS userId, message_mf AS message, commission_mf AS comm_amt, status_mf as status, sub_franchisee, created_date FROM sub_franchisee_payout WHERE (master_franchisee <> 'NA' AND master_franchisee <> 'Not Applicable' AND master_franchisee IS NOT NULL) AND  YEAR(created_date) = '".$cap_year."' AND MONTH(created_date) = '".$cap_month."')
                    ORDER BY created_date DESC ";
        $stmt = $conn->prepare($sqlId);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        // print_r($stmt);
        if ($stmt->rowCount() > 0) {
            echo '<div class="table-responsive table-desi" id="filterTable">';
            echo '<table class="table table-hover" id="payoutDetailsTable">
                    <thead>
                        <tr>
                            <th class="ceterText fw-bolder font-size-16">Date</th>
                            <th class="ceterText fw-bolder font-size-16">Payout Details</th>
                            <th class="ceterText fw-bolder font-size-16">Amount</th>
                            <th class="ceterText fw-bolder font-size-16">TDS</th>
                            <th class="ceterText fw-bolder font-size-16">Total Payable</th>
                            <th class="ceterText fw-bolder font-size-16">Remark</th>
                        </tr>
                    </thead>
                    <tbody>';

            foreach ($stmt->fetchAll() as $row) {
                // date in proper formate
                $dt = new DateTime($row['created_date']);
                $dt = $dt->format('Y-m-d');

                // replace dot at end of the line with break statement
                $message1 = $row['message'];
                $message1 =  str_replace('.','<br>',$message1);  

                $user_desig = "NA";
                //to get the prefix charater before first -
                preg_match('/^(.*?)\s*-\s*/', $message1, $match);

                if (!empty($match[1])) {
                    $user_desig = trim($match[1]); // Output only the text before the first dash
                } 
                ///-------

                // total Amt Cal for BC 
                if($row['comm_amt'] == "null"){
                    $CommAmt = "null";
                    $tds = "null";
                    $totalAmt = "null";
                }else{
                    $CommAmt = $row['comm_amt'];
                    $tds = $CommAmt * $tdsPer;
                    $totalAmt = $CommAmt - $tds;
                }
                
                echo '<tr>
                        <td>'.$dt.'</td>
                        <td>'.$message1.'</td>
                        <td class="text-end">'.$CommAmt.'</td>
                        <td class="text-end">'.$tds.'</td>
                        <td class="text-end">'.$totalAmt.'
                            <a href="forms/sub_franchisee/download_ca_payout.php?
                                vkvbvjfgfikix='.urlencode($row['id']).'
                                &userId='.urlencode($row['userId']).'
                                &te='.urlencode($row['sub_franchisee']).'
                                &date='.urlencode($dt).'
                                &message='.urlencode($message1).'
                                &message_status='.urlencode($row['status']).'
                                &commission='.urlencode($row['comm_amt']).'">
                                <i class="bx bx-download" style="font-size:18px; color:black; padding-left:5px;"></i>
                            </a>
                        </td>';
                        if($row['status'] == '1'){
                            echo'<td><span class="badge badge-pill badge-soft-success font-size-10 fw-bold ms-4">Paid</span></td>';
                        }else{
                            echo '<td><span class="badge badge-pill badge-soft-warning font-size-10 fw-bold ms-4" 
                                data-bs-toggle="modal" 
                                data-bs-target=".bs-example-modal-center" 
                                onclick=\'paymentId('
                                . json_encode($row['id']) . ','
                                . json_encode($row['userId']) . ','
                                . json_encode($row['sub_franchisee']) . ','
                                . json_encode($message1) . ','
                                . json_encode($row['comm_amt']) . ','
                                . json_encode($row['status']) . ','
                                . json_encode($user_desig) . ')\'>' 
                                . 'Pending</span></td>';
                        }
                echo'</tr>';
            }

            echo '</tbody></table></div>';
        } else {
            echo '<div class="alert alert-info">No payout data available for this designation.</div>';
        }

    }else if(!$cap_id && empty($allPayout)){    // if designation and date filter are their 
       
       $sqlId = "";
        if ($designation == 'zonal_manager' || $designation == 'business_development_manager') {
            $sqlId = "SELECT id, zonal_manager AS userId, message_zm AS message, commission_zm as comm_amt, status_zm as status, sub_franchisee, created_date FROM sub_franchisee_payout WHERE (zonal_manager <> 'NA' AND zonal_manager <> 'Not Applicable' AND zonal_manager IS NOT NULL) AND YEAR(created_date) = '".$cap_year."' AND MONTH(created_date) = '".$cap_month."' ORDER BY id DESC";
        } else if ($designation == 'master_franchisee' || $designation == 'sponsor_franchisee' || $designation == 'business_mentor') {
            $sqlId = "SELECT id, master_franchisee AS userId, message_mf AS message, commission_mf AS comm_amt, status_mf as status, sub_franchisee, created_date FROM sub_franchisee_payout WHERE (master_franchisee <> 'NA' AND master_franchisee <> 'Not Applicable' AND master_franchisee IS NOT NULL) AND YEAR(created_date) = '".$cap_year."' AND MONTH(created_date) = '".$cap_month."' ORDER BY id DESC";
        } 

        $stmt = $conn->prepare($sqlId);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        // print_r($stmt);
        if ($stmt->rowCount() > 0) {
            echo '<div class="table-responsive table-desi" id="filterTable">';
            echo '<table class="table table-hover" id="payoutDetailsTable">
                    <thead>
                        <tr>
                            <th class="ceterText fw-bolder font-size-16">Date</th>
                            <th class="ceterText fw-bolder font-size-16">Payout Details</th>
                            <th class="ceterText fw-bolder font-size-16">Amount</th>
                            <th class="ceterText fw-bolder font-size-16">TDS</th>
                            <th class="ceterText fw-bolder font-size-16">Total Payable</th>
                            <th class="ceterText fw-bolder font-size-16">Remark</th>
                        </tr>
                    </thead>
                    <tbody>';

            foreach ($stmt->fetchAll() as $row) {
                // date in proper formate
                $dt = new DateTime($row['created_date']);
                $dt = $dt->format('Y-m-d');

                // replace dot at end of the line with break statement
                $message1 = $row['message'];
                $message1 =  str_replace('.','<br>',$message1);  

                $user_desig = "NA";
                //to get the prefix charater before first -
                preg_match('/^(.*?)\s*-\s*/', $message1, $match);

                if (!empty($match[1])) {
                    $user_desig = trim($match[1]); // Output only the text before the first dash
                } 
                ///-------

                // total Amt Cal for BC 
                if($row['comm_amt'] == "null"){
                    $CommAmt = "null";
                    $tds = "null";
                    $totalAmt = "null";
                }else{
                    $CommAmt = $row['comm_amt'];
                    $tds = $CommAmt * $tdsPer;
                    $totalAmt = $CommAmt - $tds;
                }
                
                echo '<tr>
                        <td>'.$dt.'</td>
                        <td>'.$message1.'</td>
                        <td class="text-end">'.$CommAmt.'</td>
                        <td class="text-end">'.$tds.'</td>
                        <td class="text-end">'.$totalAmt.'
                            <a href="forms/sub_franchisee/download_ca_payout.php?
                                vkvbvjfgfikix='.urlencode($row['id']).'
                                &userId='.urlencode($row['userId']).'
                                &te='.urlencode($row['sub_franchisee']).'
                                &date='.urlencode($dt).'
                                &message='.urlencode($message1).'
                                &message_status='.urlencode($row['status']).'
                                &commission='.urlencode($row['comm_amt']).'">
                                <i class="bx bx-download" style="font-size:18px; color:black; padding-left:5px;"></i>
                            </a>
                        </td>';
                        if($row['status'] == '1'){
                            echo'<td><span class="badge badge-pill badge-soft-success font-size-10 fw-bold ms-4">Paid</span></td>';
                        }else{
                            echo '<td><span class="badge badge-pill badge-soft-warning font-size-10 fw-bold ms-4" 
                                data-bs-toggle="modal" 
                                data-bs-target=".bs-example-modal-center" 
                                onclick=\'paymentId('
                                . json_encode($row['id']) . ','
                                . json_encode($row['userId']) . ','
                                . json_encode($row['sub_franchisee']) . ','
                                . json_encode($message1) . ','
                                . json_encode($row['comm_amt']) . ','
                                . json_encode($row['status']) . ','
                                . json_encode($user_desig) . ')\'>' 
                                . 'Pending</span></td>';
                        }
                echo'</tr>';
            }

            echo '</tbody></table></div>';
        } else {
            echo '<div class="alert alert-info">No payout data available for this designation.</div>';
        }

    }else if(empty($allPayout)){    // if all filter are their i.e date, and id
        // check datatable not working when date filter applied
        // if($designation == 'business_mentor'){
        //     $sqlId = "SELECT * FROM ca_ta_payout WHERE business_mentor = '".$cap_id."' AND YEAR(created_date) = '".$cap_year."' AND MONTH(created_date) = '".$cap_month."' order by id DESC";
        // }else if($designation == 'corporate_agency'){
        //     $sqlId = "SELECT * FROM ca_ta_payout WHERE techno_enterprise = '".$cap_id."' AND YEAR(created_date) = '".$cap_year."' AND MONTH(created_date) = '".$cap_month."' order by id DESC";
        // }else if($designation == 'ca_travelagency'){
        //     $sqlId = "SELECT * FROM ca_ta_payout WHERE ca_travelagency = '".$cap_id."' AND YEAR(created_date) = '".$cap_year."' AND MONTH(created_date) = '".$cap_month."' order by id DESC";
        // }

        $sqlId = "";
        if ($designation == 'zonal_manager' || $designation == 'business_development_manager') {
            $sqlId = "SELECT id, zonal_manager AS userId, message_zm AS message, commission_zm as comm_amt, status_zm as status, sub_franchisee, created_date FROM sub_franchisee_payout WHERE (zonal_manager <> 'NA' AND zonal_manager <> 'Not Applicable' AND zonal_manager IS NOT NULL) AND zonal_manager = '".$cap_id."' AND YEAR(created_date) = '".$cap_year."' AND MONTH(created_date) = '".$cap_month."' ORDER BY id DESC";
        } else if ($designation == 'master_franchisee' || $designation == 'sponsor_franchisee' || $designation == 'business_mentor') {
            $sqlId = "SELECT id, master_franchisee AS userId, message_mf AS message, commission_mf AS comm_amt, status_mf as status, sub_franchisee, created_date FROM sub_franchisee_payout WHERE master_franchisee = '".$cap_id."' AND YEAR(created_date) = '".$cap_year."' AND MONTH(created_date) = '".$cap_month."' ORDER BY id DESC";
        } 

        $stmt = $conn->prepare($sqlId);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        // print_r($stmt);
        if ($stmt->rowCount() > 0) {
            echo '<div class="table-responsive table-desi" id="filterTable">';
            echo '<table class="table table-hover" id="payoutDetailsTable">
                    <thead>
                        <tr>
                            <th class="ceterText fw-bolder font-size-16">Date</th>
                            <th class="ceterText fw-bolder font-size-16">Payout Details</th>
                            <th class="ceterText fw-bolder font-size-16">Amount</th>
                            <th class="ceterText fw-bolder font-size-16">TDS</th>
                            <th class="ceterText fw-bolder font-size-16">Total Payable</th>
                            <th class="ceterText fw-bolder font-size-16">Remark</th>
                        </tr>
                    </thead>
                    <tbody>';

            foreach ($stmt->fetchAll() as $row) {
                // date in proper formate
                $dt = new DateTime($row['created_date']);
                $dt = $dt->format('Y-m-d');

                // replace dot at end of the line with break statement
                $message1 = $row['message'];
                $message1 =  str_replace('.','<br>',$message1);  

                $user_desig = "NA";
                //to get the prefix charater before first -
                preg_match('/^(.*?)\s*-\s*/', $message1, $match);

                if (!empty($match[1])) {
                    $user_desig = trim($match[1]); // Output only the text before the first dash
                } 
                ///-------

                // total Amt Cal for BC 
                if($row['comm_amt'] == "null"){
                    $CommAmt = "null";
                    $tds = "null";
                    $totalAmt = "null";
                }else{
                    $CommAmt = $row['comm_amt'];
                    $tds = $CommAmt * $tdsPer;
                    $totalAmt = $CommAmt - $tds;
                }
                
                echo '<tr>
                        <td>'.$dt.'</td>
                        <td>'.$message1.'</td>
                        <td class="text-end">'.$CommAmt.'</td>
                        <td class="text-end">'.$tds.'</td>
                        <td class="text-end">'.$totalAmt.'
                            <a href="forms/sub_franchisee/download_ca_payout.php?
                                vkvbvjfgfikix='.urlencode($row['id']).'
                                &userId='.urlencode($row['userId']).'
                                &te='.urlencode($row['sub_franchisee']).'
                                &date='.urlencode($dt).'
                                &message='.urlencode($message1).'
                                &message_status='.urlencode($row['status']).'
                                &commission='.urlencode($row['comm_amt']).'">
                                <i class="bx bx-download" style="font-size:18px; color:black; padding-left:5px;"></i>
                            </a>
                        </td>';
                        if($row['status'] == '1'){
                            echo'<td><span class="badge badge-pill badge-soft-success font-size-10 fw-bold ms-4">Paid</span></td>';
                        }else{
                            echo '<td><span class="badge badge-pill badge-soft-warning font-size-10 fw-bold ms-4" 
                                data-bs-toggle="modal" 
                                data-bs-target=".bs-example-modal-center" 
                                onclick=\'paymentId('
                                . json_encode($row['id']) . ','
                                . json_encode($row['userId']) . ','
                                . json_encode($row['sub_franchisee']) . ','
                                . json_encode($message1) . ','
                                . json_encode($row['comm_amt']) . ','
                                . json_encode($row['status']) . ','
                                . json_encode($user_desig) . ')\'>' 
                                . 'Pending</span></td>';
                        }
                echo'</tr>';
            }

            echo '</tbody></table></div>';
        } else {
            echo '<div class="alert alert-info">No payout data available for this designation.</div>';
        }
    }

    // ****** DAILY TASK RECORDS *******
    // 12-10-2026:
    // code merged
    // testing
    // app api udatede

    // 13-10-2026:
    // App code update
    // DB issue solved for app side where files where showing 500 issue.

    // 14-10-2026:
    // mailtrap issue solved 

    // 15-10-2026:
    // Microsoft Authentication problem (contacted ms mailsupport)
    // issue debugging from server side (ms 365 admin)

    // 16-10-2026:
    // app code file changes

    // 17-10-2026:
    // email sent to TC :
    // TA250072 Sangeeta Nitin Phadte - email : sangeetaphadte8@gmail.com , password : KDbHlU1#
    // TA250082 Rama Mauskar - email : m.rama2495@gmail.com , password : ibYzVgju
    // TA250087 Sulaksha Pradeep Patil - email : sulaksha75@gmail.com , password : Prajakta@20
    // TA250167 Pradeep sudhir - email : pradeepsudhir85@gmail.com , password : *tieD8b6
    // TA250171 Sherryl Cardozo - email : sherryl9040@gmail.com , password : vHELotJy

    // 19-10-2026:
    // Institution Payout structure preparation and table connection.
    // app code update and testing on server.

    // 21-10-2026:
    // STE login profile page updated on test. (App Login)
    // institution payout section - all payout, previous payout, next payout and total payout.(data population and testing)

    // 22-10-2026:
    // login issue solved(case sensitivity)
    // app api updated on test site
    // follow up on ms 365 admin Authentication issue

    // 23-10-2026:
    // php security update to fix vaulnarability issue
    // backup taken of live DB and code base.  

    // 24-10-2026:
    // request details page admin side code flow design
    // institution payout filter section.
    // follow up on ms 365 admin Authentication issue

?>