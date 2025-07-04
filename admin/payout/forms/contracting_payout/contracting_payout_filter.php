<!-- all payout section filter  -->
<?php

require "../../../connect.php";

$cap_id = $_POST['cap_id'];
$designation = $_POST['designation'];
$cap_year = $_POST['year_split']?? '';
$cap_month = $_POST['month_split']?? '';
$TotalPayoutFilter = $_POST['TotalPayoutFilter']?? '';
$tdsPer = 2/100;

    if($TotalPayoutFilter){
        
        if($designation == 'business_development_manager'){

            $sqlId = "SELECT id, bdm_id as userId, message, message_details, comm_amt, techno_enterprise, created_date, status, 'goaBdm' as identity FROM goa_bdm_payout WHERE bdm_id = '".$cap_id."' AND status = '1' order by created_date DESC";

        }else if($designation == 'business_mentor'){

            $sqlId = "SELECT id, bm_id as userId, message, message_details, comm_amt, techno_enterprise, created_date, status, 'goaBm' as identity FROM `goa_bm_payout` WHERE bm_id = '".$cap_id."'  AND status = '1' UNION ALL
                    SELECT id, business_mentor as userId, message, message_details, comm_amt, techno_enterprise, created_date, status, 'caPayout' as identity FROM `ca_payout`  WHERE business_mentor = '".$cap_id."'  AND status = '1' UNION ALL
                    SELECT id, bm_user_id as userId, message_bm as message, payment_message as message_details, payout_amount as comm_amt, ca_user_id as techno_enterprise, payout_date as created_date, payout_status as status, 'bmPayoutHistory' as identity FROM `bm_payout_history` WHERE bm_user_id = '".$cap_id."' AND payout_status = '1'
                    order by created_date desc";

        }else if($designation == 'corporate_agency'){

            $sqlId = "SELECT id, bdm_id as userId, message, message_details, comm_amt, techno_enterprise, created_date, status, 'goaBdm' as identity FROM `goa_bdm_payout` WHERE techno_enterprise = '".$cap_id."'  AND status = '1' UNION ALL
                    SELECT id, bm_id as userId, message, message_details, comm_amt, techno_enterprise, created_date, status, 'goaBm' as identity FROM `goa_bm_payout` WHERE techno_enterprise = '".$cap_id."'  AND status = '1' UNION ALL
                    SELECT id, business_mentor as userId, message, message_details, comm_amt, techno_enterprise, created_date, status, 'caPayout' as identity FROM `ca_payout` WHERE techno_enterprise = '".$cap_id."'  AND status = '1' UNION ALL
                    SELECT id, bm_user_id as userId, message_bm as message, payment_message as message_details, payout_amount as comm_amt, ca_user_id as techno_enterprise, payout_date as created_date, payout_status as status, 'bmPayoutHistory' as identity FROM `bm_payout_history` WHERE ca_user_id = '".$cap_id."' AND payout_status = '1'
                    order by created_date desc ";
                    
        }

        echo'<div class="table-responsive table-desi" id="filterTable">
            <table class="table table-hover" id="filteredTotalTables">
                <thead>
                    <tr>
                        <th class="ceterText fw-bolder font-size-16">Date</th>
                        <th class="ceterText fw-bolder font-size-16">Payout Message</th>
                        <th class="ceterText fw-bolder font-size-16">Payout Details</th>
                        <th class="ceterText fw-bolder font-size-16">Amount</th>
                        <th class="ceterText fw-bolder font-size-16">TDS</th>
                        <th class="ceterText fw-bolder font-size-16">Total Payable</th>
                        <th class="ceterText fw-bolder font-size-16">Remark</th>
                    </tr>
                </thead>
                <tbody>';
                        
                $stmt = $conn -> prepare($sqlId);
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

                        $message_details = $row['message_details'];
                        $message_details =  str_replace('.','<br>',$message_details);

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
                                <td>'.$message_details.'</td>
                                <td class="text-end">'.$CommAmt.'</td>
                                <td class="text-end">'.$tds.'</td>
                                <td class="text-end">'.$totalAmt.'
                                    <a href="forms/contracting_payout/download_ca_payout.php?vkvbvjfgfikix='.$row['id'].'&userId='.$row['userId'].'&te='.$row['techno_enterprise'].'&date='.$dt.'&message='.$message1.'&message_status='.$row['status'].'&commission='.$row['comm_amt'].'">
                                        <i class="bx bx-download" style="font-size: 18px; color: black; padding-left: 5px;"></i>
                                    </a>
                                </td>';
                                if($row['status'] == '1'){
                                    echo'<td><span class="badge badge-pill badge-soft-success font-size-10 fw-bold ms-4">Paid</span></td>';
                                }else{
                                    echo'<td><span class="badge badge-pill badge-soft-warning font-size-10 fw-bold ms-4" data-bs-toggle="modal" data-bs-target=".bs-example-modal-center" onclick=\'paymentId("' .$row['id']. '","'.$row['userId'].'","'.$message1.'","'.$row['comm_amt'].'","'.$row['status'].'","'.$row['identity'].'")\'>Pending</span></td>';
                                }
                        echo'</tr>';
                    }
                }
                    
                echo'</tbody>
            </table>
        </div>';
    }else if(!$cap_year && !$cap_month){

        if($designation == 'business_development_manager'){
            $sqlId = "SELECT id, bdm_id as userId, message, comm_amt, techno_enterprise, created_date, status, 'goaBdm' as identity FROM goa_bdm_payout WHERE bdm_id = '".$cap_id."' order by created_date DESC";
        }else if($designation == 'business_mentor'){
            // $sqlId = "SELECT * FROM ca_payout WHERE business_consultant = '".$cap_id."' order by id DESC";
            $sqlId = "SELECT id, bm_id as userId, message, comm_amt, techno_enterprise, created_date, status, 'goaBm' as identity FROM `goa_bm_payout` WHERE bm_id = '".$cap_id."' UNION ALL
                    SELECT id, business_mentor as userId, message, comm_amt, techno_enterprise, created_date, status, 'caPayout' as identity FROM `ca_payout`  WHERE business_mentor = '".$cap_id."' UNION ALL
                    SELECT id, bm_user_id as userId, message_bm as message, payout_amount as comm_amt, ca_user_id as techno_enterprise, payout_date as created_date, payout_status as status, 'bmPayoutHistory' as identity FROM `bm_payout_history` WHERE bm_user_id = '".$cap_id."'
                    order by created_date desc";
        }else if($designation == 'corporate_agency'){
            $sqlId = "SELECT id, bdm_id as userId, message, comm_amt, techno_enterprise, created_date, status, 'goaBdm' as identity FROM `goa_bdm_payout` WHERE techno_enterprise = '".$cap_id."' UNION ALL
                    SELECT id, bm_id as userId, message, comm_amt, techno_enterprise, created_date, status, 'goaBm' as identity FROM `goa_bm_payout` WHERE techno_enterprise = '".$cap_id."' UNION ALL
                    SELECT id, business_mentor as userId, message, comm_amt, techno_enterprise, created_date, status, 'caPayout' as identity FROM `ca_payout` WHERE techno_enterprise = '".$cap_id."' UNION ALL
                    SELECT id, bm_user_id as userId, message_bm as message, payout_amount as comm_amt, ca_user_id as techno_enterprise, payout_date as created_date, payout_status as status, 'bmPayoutHistory' as identity FROM `bm_payout_history` WHERE ca_user_id = '".$cap_id."'
                    order by created_date desc ";
        }

        echo'<div class="table-responsive table-desi" id="filterTable">
            <table class="table table-hover" id="payoutDetailsTable">
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
                        
                $stmt = $conn -> prepare($sqlId);
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
                                    <a href="forms/contracting_payout/download_ca_payout.php?vkvbvjfgfikix='.$row['id'].'&userId='.$row['userId'].'&te='.$row['techno_enterprise'].'&date='.$dt.'&message='.$message1.'&message_status='.$row['status'].'&commission='.$row['comm_amt'].'">
                                        <i class="bx bx-download" style="font-size: 18px; color: black; padding-left: 5px;"></i>
                                    </a>
                                </td>';
                                if($row['status'] == '1'){
                                    echo'<td><span class="badge badge-pill badge-soft-success font-size-10 fw-bold ms-4">Paid</span></td>';
                                }else{
                                    echo'<td><span class="badge badge-pill badge-soft-warning font-size-10 fw-bold ms-4" data-bs-toggle="modal" data-bs-target=".bs-example-modal-center" onclick=\'paymentId("' .$row['id']. '","'.$row['userId'].'","'.$message1.'","'.$row['comm_amt'].'","'.$row['status'].'","'.$row['identity'].'")\'>Pending</span></td>';
                                }
                        echo'</tr>';
                    }
                }
                    
                echo'</tbody>
            </table>
        </div>';

    }else{    

        if($designation == 'business_development_manager'){
            $sqlId = "SELECT id, bdm_id as userId, message, comm_amt, techno_enterprise, created_date, status, 'goaBdm' as identity FROM goa_bdm_payout WHERE bdm_id = '".$cap_id."' AND YEAR(created_date) = '".$cap_year."' AND MONTH(created_date) = '".$cap_month."' order by created_date DESC";
        }else if($designation == 'business_mentor'){
            // $sqlId = "SELECT * FROM ca_payout WHERE business_consultant = '".$cap_id."' order by id DESC";
            $sqlId = "SELECT id, bm_id as userId, message, comm_amt, techno_enterprise, created_date, status, 'goaBm' as identity FROM `goa_bm_payout` WHERE bm_id = '".$cap_id."' AND YEAR(created_date) = '".$cap_year."' AND MONTH(created_date) = '".$cap_month."' UNION ALL
                    SELECT id, business_mentor as userId, message, comm_amt, techno_enterprise, created_date, status, 'caPayout' as identity FROM `ca_payout`  WHERE business_mentor = '".$cap_id."' AND YEAR(created_date) = '".$cap_year."' AND MONTH(created_date) = '".$cap_month."' UNION ALL
                    SELECT id, bm_user_id as userId, message_bm as message, payout_amount as comm_amt, ca_user_id as techno_enterprise, payout_date as created_date, payout_status as status, 'bmPayoutHistory' as identity FROM `bm_payout_history` WHERE bm_user_id = '".$cap_id."' AND YEAR(payout_date) = '".$cap_year."' AND MONTH(payout_date) = '".$cap_month."'
                    order by created_date desc";
        }else if($designation == 'corporate_agency'){
            $sqlId = "SELECT id, bdm_id as userId, message, comm_amt, techno_enterprise, created_date, status, 'goaBdm' as identity FROM `goa_bdm_payout` WHERE techno_enterprise = '".$cap_id."' AND YEAR(created_date) = '".$cap_year."' AND MONTH(created_date) = '".$cap_month."' UNION ALL
                    SELECT id, bm_id as userId, message, comm_amt, techno_enterprise, created_date, status, 'goaBm' as identity FROM `goa_bm_payout` WHERE techno_enterprise = '".$cap_id."' AND YEAR(created_date) = '".$cap_year."' AND MONTH(created_date) = '".$cap_month."' UNION ALL
                    SELECT id, business_mentor as userId, message, comm_amt, techno_enterprise, created_date, status, 'caPayout' as identity FROM `ca_payout` WHERE techno_enterprise = '".$cap_id."' AND YEAR(created_date) = '".$cap_year."' AND MONTH(created_date) = '".$cap_month."' UNION ALL
                    SELECT id, bm_user_id as userId, message_bm as message, payout_amount as comm_amt, ca_user_id as techno_enterprise, payout_date as created_date, payout_status as status, 'bmPayoutHistory' as identity FROM `bm_payout_history` WHERE bm_user_id = '".$cap_id."' AND YEAR(payout_date) = '".$cap_year."' AND MONTH(payout_date) = '".$cap_month."'
                    order by created_date desc ";
        }

        echo'<div class="table-responsive table-desi" id="filterTable">
            <table class="table table-hover" id="payoutDetailsTable">
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
                        
                $stmt = $conn -> prepare($sqlId);
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
                                    <a href="forms/contracting_payout/download_ca_payout.php?vkvbvjfgfikix='.$row['id'].'&userId='.$row['userId'].'&te='.$row['techno_enterprise'].'&date='.$dt.'&message='.$message1.'&message_status='.$row['status'].'&commission='.$row['comm_amt'].'">
                                        <i class="bx bx-download" style="font-size: 18px; color: black; padding-left: 5px;"></i>
                                    </a>
                                </td>';
                                if($row['status'] == '1'){
                                    echo'<td><span class="badge badge-pill badge-soft-success font-size-10 fw-bold ms-4">Paid</span></td>';
                                }else{
                                    echo'<td><span class="badge badge-pill badge-soft-warning font-size-10 fw-bold ms-4" data-bs-toggle="modal" data-bs-target=".bs-example-modal-center" onclick=\'paymentId("' .$row['id']. '","'.$row['userId'].'","'.$message1.'","'.$row['comm_amt'].'","'.$row['status'].'","'.$row['identity'].'")\'>Pending</span></td>';
                                }
                        echo'</tr>';
                    }
                }
                    
                echo'</tbody>
            </table>
        </div>';
    }
          
    
?>