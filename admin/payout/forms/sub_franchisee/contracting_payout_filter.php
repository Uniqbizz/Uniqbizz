<!-- all payout section filter  -->
<?php

require "../../../connect.php";

$cap_id = $_POST['cap_id']??'';
$designation = $_POST['designation']??'';
$cap_year = $_POST['year_split']?? '';
$cap_month = $_POST['month_split']?? '';
$TotalPayoutFilter = $_POST['TotalPayoutFilter']?? '';
$tdsPer = 2/100;

    if($TotalPayoutFilter){
        
        if($designation == 'zonal_manager'){

            $sqlId = "SELECT s.id, s.zonal_manager as userId, s.message_zm as message, sp.payout_details, s.commision_zm as comm_amt, s.sub_franchisee, s.created_date, s.status, 'zonal_manager' as identity 
                        FROM sub_franchisee_payout s
                        LEFT JOIN sub_franchisee_payout_paid sp on sp.user_id=s.zonal_manager
                        WHERE s.zonal_manager = '".$cap_id."' AND (s.zonal_manager <> 'NA' AND s.zonal_manager <> 'Not Applicable' AND s.zonal_manager IS NOT NULL) 
                        order by s.created_date DESC";

        }else if($designation == 'master_franchisee'){

            $sqlId = "SELECT s.id, s.master_franchisee as userId, s.message_mf as message, sp.payout_details, s.commision_mf as comm_amt, s.sub_franchisee, s.created_date, s.status, '".$designation."' as identity 
                        FROM sub_franchisee_payout s
                        LEFT JOIN sub_franchisee_payout_paid sp on sp.user_id=s.master_franchisee 
                        WHERE s.master_franchisee = '".$cap_id."' AND master_franchisee LIKE 'MF%' AND (s.master_franchisee <> 'NA' AND s.master_franchisee <> 'Not Applicable' AND s.master_franchisee IS NOT NULL)
                        order by s.created_date DESC";

        }else if($designation == 'sponsor_franchisee'){
            $sqlId = "SELECT s.id, s.master_franchisee as userId, s.message_mf as message, sp.payout_details, s.commision_mf as comm_amt, s.sub_franchisee, s.created_date, s.status, '".$designation."' as identity 
                        FROM sub_franchisee_payout s
                        LEFT JOIN sub_franchisee_payout_paid sp on sp.user_id=s.master_franchisee 
                        WHERE s.master_franchisee = '".$cap_id."' AND master_franchisee LIKE 'SF%' AND (s.master_franchisee <> 'NA' AND s.master_franchisee <> 'Not Applicable' AND s.master_franchisee IS NOT NULL)
                        order by s.created_date DESC";
        }else{
            $sqlId = "  (SELECT id, zonal_manager as userId, message_zm as message, commision_zm as comm_amt, sub_franchisee, created_date, status, 'zonal_manager' as identity 
                        FROM sub_franchisee_payout 
                        WHERE zonal_manager = '".$cap_id."' AND YEAR(created_date) = '".$cap_year."' AND MONTH(created_date) = '".$cap_month."' AND (zonal_manager <> 'NA' AND zonal_manager <> 'Not Applicable' AND zonal_manager IS NOT NULL))
                        UNION
                        (SELECT id, master_franchisee as userId, message_mf as message, commision_mf as comm_amt, sub_franchisee, created_date, status, 'master_franchisee' as identity 
                        FROM sub_franchisee_payout 
                        WHERE master_franchisee = '".$cap_id."' AND YEAR(created_date) = '".$cap_year."' AND MONTH(created_date) = '".$cap_month."' AND (master_franchisee <> 'NA' AND master_franchisee <> 'Not Applicable' AND master_franchisee IS NOT NULL))
                        order by created_date DESC";
            
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

                        $message_details = $row['payout_details'];
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
                                    <a href="forms/contracting_payout/download_ca_payout.php?vkvbvjfgfikix='.$row['id'].'&userId='.$row['userId'].'&te='.$row['sub_franchisee'].'&date='.$dt.'&message='.$message1.'&message_status='.$row['status'].'&commission='.$row['comm_amt'].'">
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

        if($designation == 'zonal_manager'){
            $sqlId = "SELECT id, zonal_manager as userId, message_zm as message, commision_zm as comm_amt, sub_franchisee, created_date, status, 'zonal_manager' as identity 
                        FROM sub_franchisee_payout
                        WHERE zonal_manager = '".$cap_id."' AND (zonal_manager <> 'NA' AND zonal_manager <> 'Not Applicable' AND zonal_manager IS NOT NULL)
                        order by created_date DESC";
        }else if($designation == 'master_franchisee' || $designation == 'sponsor_franchisee'){    
            $sqlId = "SELECT id, master_franchisee as userId, message_mf as message, commision_mf as comm_amt, sub_franchisee, created_date, status, 'master_franchisee' as identity 
                        FROM sub_franchisee_payout 
                        WHERE master_franchisee = '".$cap_id."' AND master_franchisee LIKE 'MF%' AND (master_franchisee <> 'NA' AND master_franchisee <> 'Not Applicable' AND master_franchisee IS NOT NULL)
                        order by created_date DESC";
        }else if($designation == 'sponsor_franchisee'){
            $sqlId = "SELECT id, master_franchisee as userId, message_mf as message, commision_mf as comm_amt, sub_franchisee, created_date, status, 'master_franchisee' as identity 
                        FROM sub_franchisee_payout 
                        WHERE master_franchisee = '".$cap_id."' AND master_franchisee LIKE 'SF%' AND (master_franchisee <> 'NA' AND master_franchisee <> 'Not Applicable' AND master_franchisee IS NOT NULL)
                        order by created_date DESC";
        }else{
            $sqlId = "  (SELECT id, zonal_manager as userId, message_zm as message, commision_zm as comm_amt, sub_franchisee, created_date, status, 'zonal_manager' as identity 
                        FROM sub_franchisee_payout 
                        WHERE zonal_manager = '".$cap_id."' AND YEAR(created_date) = '".$cap_year."' AND MONTH(created_date) = '".$cap_month."' AND (zonal_manager <> 'NA' AND zonal_manager <> 'Not Applicable' AND zonal_manager IS NOT NULL))
                        UNION
                        (SELECT id, master_franchisee as userId, message_mf as message, commision_mf as comm_amt, sub_franchisee, created_date, status, 'master_franchisee' as identity 
                        FROM sub_franchisee_payout 
                        WHERE master_franchisee = '".$cap_id."' AND YEAR(created_date) = '".$cap_year."' AND MONTH(created_date) = '".$cap_month."' AND (master_franchisee <> 'NA' AND master_franchisee <> 'Not Applicable' AND master_franchisee IS NOT NULL))
                        order by created_date DESC";
            
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
                                    <a href="forms/contracting_payout/download_ca_payout.php?vkvbvjfgfikix='.$row['id'].'&userId='.$row['userId'].'&te='.$row['sub_franchisee'].'&date='.$dt.'&message='.$message1.'&message_status='.$row['status'].'&commission='.$row['comm_amt'].'">
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

        if($designation == 'zonal_manager'){
            if($cap_id){
                $sqlId = "SELECT id, zonal_manager as userId, message_zm as message, commision_zm as comm_amt, sub_franchisee, created_date, status, 'zonal_manager' as identity 
                            FROM sub_franchisee_payout 
                            WHERE zonal_manager = '".$cap_id."' AND YEAR(created_date) = '".$cap_year."' AND MONTH(created_date) = '".$cap_month."' AND (zonal_manager <> 'NA' AND zonal_manager <> 'Not Applicable' AND zonal_manager IS NOT NULL) order by created_date DESC";
            }else{
                $sqlId = "SELECT id, zonal_manager as userId, message_zm as message, commision_zm as comm_amt, sub_franchisee, created_date, status, 'zonal_manager' as identity 
                            FROM sub_franchisee_payout 
                            WHERE YEAR(created_date) = '".$cap_year."' AND MONTH(created_date) = '".$cap_month."' AND (zonal_manager <> 'NA' AND zonal_manager <> 'Not Applicable' AND zonal_manager IS NOT NULL) order by created_date DESC";
            }
        }else if($designation == 'master_franchisee'){ 
            if($cap_id){
                $sqlId = "SELECT id, master_franchisee as userId, message_mf as message, commision_mf as comm_amt, sub_franchisee, created_date, status, 'master_franchisee' as identity 
                            FROM sub_franchisee_payout 
                            WHERE master_franchisee = '".$cap_id."' AND master_franchisee LIKE 'MF%' AND YEAR(created_date) = '".$cap_year."' AND MONTH(created_date) = '".$cap_month."' AND (master_franchisee <> 'NA' AND master_franchisee <> 'Not Applicable' AND master_franchisee IS NOT NULL) order by created_date desc";
            }else{
                $sqlId = "SELECT id, master_franchisee as userId, message_mf as message, commision_mf as comm_amt, sub_franchisee, created_date, status, 'master_franchisee' as identity 
                            FROM sub_franchisee_payout 
                            WHERE master_franchisee LIKE 'MF%' AND YEAR(created_date) = '".$cap_year."' AND MONTH(created_date) = '".$cap_month."' AND (master_franchisee <> 'NA' AND master_franchisee <> 'Not Applicable' AND master_franchisee IS NOT NULL) order by created_date desc";
            }
        }else if($designation == 'sponsor_franchisee'){
            if($cap_id){
                $sqlId = "SELECT id, master_franchisee as userId, message_mf as message, commision_mf as comm_amt, sub_franchisee, created_date, status, 'master_franchisee' as identity 
                            FROM sub_franchisee_payout 
                            WHERE master_franchisee = '".$cap_id."' AND master_franchisee LIKE 'SF%' AND YEAR(created_date) = '".$cap_year."' AND MONTH(created_date) = '".$cap_month."' AND (master_franchisee <> 'NA' AND master_franchisee <> 'Not Applicable' AND master_franchisee IS NOT NULL) order by created_date desc";
            }else{
                $sqlId = "SELECT id, master_franchisee as userId, message_mf as message, commision_mf as comm_amt, sub_franchisee, created_date, status, 'master_franchisee' as identity 
                            FROM sub_franchisee_payout 
                            WHERE master_franchisee LIKE 'SF%' AND YEAR(created_date) = '".$cap_year."' AND MONTH(created_date) = '".$cap_month."' AND (master_franchisee <> 'NA' AND master_franchisee <> 'Not Applicable' AND master_franchisee IS NOT NULL) order by created_date desc";
            }
        }else{
            $sqlId = "  (SELECT id, zonal_manager as userId, message_zm as message, commision_zm as comm_amt, sub_franchisee, created_date, status, 'zonal_manager' as identity 
                        FROM sub_franchisee_payout 
                        WHERE YEAR(created_date) = '".$cap_year."' AND MONTH(created_date) = '".$cap_month."' AND (zonal_manager <> 'NA' AND zonal_manager <> 'Not Applicable' AND zonal_manager IS NOT NULL))
                        UNION
                        (SELECT id, master_franchisee as userId, message_mf as message, commision_mf as comm_amt, sub_franchisee, created_date, status, 'master_franchisee' as identity 
                        FROM sub_franchisee_payout 
                        WHERE YEAR(created_date) = '".$cap_year."' AND MONTH(created_date) = '".$cap_month."' AND (master_franchisee <> 'NA' AND master_franchisee <> 'Not Applicable' AND master_franchisee IS NOT NULL))
                        order by created_date DESC";
            
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
                                    <a href="forms/contracting_payout/download_ca_payout.php?vkvbvjfgfikix='.$row['id'].'&userId='.$row['userId'].'&te='.$row['sub_franchisee'].'&date='.$dt.'&message='.$message1.'&message_status='.$row['status'].'&commission='.$row['comm_amt'].'">
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