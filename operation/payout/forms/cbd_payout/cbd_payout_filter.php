<!-- all payout section filter  -->
<?php

require "../../../connect.php";

$cap_id = $_POST['cap_id'];
$designation = $_POST['designation'];
$cap_year = $_POST['year_split']?? '';
$cap_month = $_POST['month_split']?? '';
$TotalPayoutFilter = $_POST['TotalPayoutFilter']?? '';

    if($TotalPayoutFilter){
        // if($designation == 'travel_agent'){
        //     $sqlId = "SELECT * FROM ca_payout WHERE business_consultant = '".$cap_id."' AND status = '1' order by id DESC";
        // }else if($designation == 'corporate_agency'){
        //     $sqlId = "SELECT * FROM ca_payout WHERE corporate_agency = '".$cap_id."' AND status = '1' order by id DESC";
        // }

        echo'<div class="table-responsive table-desi" id="filterTable">
            <table class="table table-hover" id="filteredTotalTables">
                <thead>
                    <tr>
                        <th class="ceterText fw-bolder font-size-16">Date</th>
                        <th class="ceterText fw-bolder font-size-16">Payout Message</th>
                        <th class="ceterText fw-bolder font-size-16">Payout Type</th>
                        <th class="ceterText fw-bolder font-size-16">Amount</th>
                        <th class="ceterText fw-bolder font-size-16">TDS</th>
                        <th class="ceterText fw-bolder font-size-16">Total Payable</th>
                        <th class="ceterText fw-bolder font-size-16">Remark</th>
                    </tr>
                </thead>
                <tbody>';
                $sqlId = "SELECT * FROM cbd_payout WHERE cbd_id = '".$cap_id."' AND status = '1' order by id DESC";     
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

                       $payout_type = $row['payout_type'];

                        // total Amt Cal for BC 
                        $comm_amt = $row['amount'];
                        $tds = $comm_amt * 5/100;
                        $totalAmt = $comm_amt - $tds;

                        echo '<tr>
                                <td>'.$dt.'</td>
                                <td>'.$message1.'</td>
                                <td>'.$payout_type.'</td>
                                <td class="text-end">'.$comm_amt.'</td>
                                <td class="text-end">'.$tds.'</td>
                                <td class="text-end">'.$totalAmt.'
                                    <a href="forms/cbd_payout/download_cbd_payout.php?vkvbvjfgfikix='.$row['id'].'&bc='.$row['cbd_id'].'&date='.$dt.'&message='.$message1.'&message_status='.$row['status'].'&commission='.$row['amount'].'">
                                        <i class="bx bx-download" style="font-size: 18px; color: black; padding-left: 5px;"></i>
                                    </a>
                                </td>';
                                if($row['status'] == '1'){
                                    echo'<td><span class="badge badge-pill badge-soft-success font-size-10 fw-bold ms-4">Paid</span></td>';
                                }else{
                                    echo'<td><span class="badge badge-pill badge-soft-warning font-size-10 fw-bold ms-4" data-bs-toggle="modal" data-bs-target=".bs-example-modal-center">Pending</span></td>';
                                }
                        echo'</tr>';
                    }
                }
                    
                echo'</tbody>
            </table>
        </div>';
    }else if(!$cap_year && !$cap_month){

        // if($designation == 'travel_agent'){
        //     $sqlId = "SELECT * FROM ca_payout WHERE business_consultant = '".$cap_id."' order by id DESC";
        // }else if($designation == 'corporate_agency'){
        //     $sqlId = "SELECT * FROM ca_payout WHERE corporate_agency = '".$cap_id."' order by id DESC";
        // }

        echo'<div class="table-responsive table-desi" id="filterTable">
            <table class="table table-hover" id="payoutDetailsTable">
                <thead>
                    <tr>
                        <th class="ceterText fw-bolder font-size-16">Date</th>
                        <th class="ceterText fw-bolder font-size-16">Payout Type</th>
                        <th class="ceterText fw-bolder font-size-16">Payout Details</th>
                        <th class="ceterText fw-bolder font-size-16">Amount</th>
                        <th class="ceterText fw-bolder font-size-16">TDS</th>
                        <th class="ceterText fw-bolder font-size-16">Total Payable</th>
                        <th class="ceterText fw-bolder font-size-16">Remark</th>
                    </tr>
                </thead>
                <tbody>';
                $sqlId = "SELECT * FROM cbd_payout WHERE cbd_id = '".$cap_id."'  order by id DESC";     
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

                        $payout_type = $row['payout_type'];

                        // total Amt Cal for BC 
                        $comm_amt = $row['amount'];
                        $tds = $comm_amt * 5/100;
                        $totalAmt = $comm_amt - $tds;

                        echo '<tr>
                                <td>'.$dt.'</td>
                                <td>'.$payout_type.'</td>
                                <td>'.$message1.'</td>
                                <td class="text-end">'.$comm_amt.'</td>
                                <td class="text-end">'.$tds.'</td>
                                <td class="text-end">'.$totalAmt.'
                                    <a href="forms/cbd_payout/download_cbd_payout.php?vkvbvjfgfikix='.$row['id'].'&bc='.$row['cbd_id'].'&date='.$dt.'&message='.$message1.'&message_status='.$row['status'].'&commission='.$row['amount'].'">
                                        <i class="bx bx-download" style="font-size: 18px; color: black; padding-left: 5px;"></i>
                                    </a>
                                </td>';
                                if($row['status'] == '1'){
                                    echo'<td><span class="badge badge-pill badge-soft-success font-size-10 fw-bold ms-4">Paid</span></td>';
                                }else{
                                    echo'<td><span class="badge badge-pill badge-soft-warning font-size-10 fw-bold ms-4" data-bs-toggle="modal" data-bs-target=".bs-example-modal-center">Pending</span></td>';
                                }
                        echo'</tr>';
                    }
                }
                    
                echo'</tbody>
            </table>
        </div>';

    }else{    

        // if($designation == 'travel_agent'){
        //     $sqlId = "SELECT * FROM ca_payout WHERE business_consultant = '".$cap_id."' AND YEAR(created_date) = '".$cap_year."' AND MONTH(created_date) = '".$cap_month."' order by id DESC";
        // }else if($designation == 'corporate_agency'){
        //     $sqlId = "SELECT * FROM ca_payout WHERE corporate_agency = '".$cap_id."' AND YEAR(created_date) = '".$cap_year."' AND MONTH(created_date) = '".$cap_month."' order by id DESC";
        // }

       echo'<div class="table-responsive table-desi" id="filterTable">
            <table class="table table-hover" id="payoutDetailsTable">
                <thead>
                    <tr>
                        <th class="ceterText fw-bolder font-size-16">Date</th>
                        <th class="ceterText fw-bolder font-size-16">Payout Type</th>
                        <th class="ceterText fw-bolder font-size-16">Payout Details</th>
                        <th class="ceterText fw-bolder font-size-16">Amount</th>
                        <th class="ceterText fw-bolder font-size-16">TDS</th>
                        <th class="ceterText fw-bolder font-size-16">Total Payable</th>
                        <th class="ceterText fw-bolder font-size-16">Remark</th>
                    </tr>
                </thead>
                <tbody>';
                $sqlId = "SELECT * FROM cbd_payout WHERE cbd_id = '".$cap_id."' AND YEAR(created_date) = '".$cap_year."' AND MONTH(created_date) = '".$cap_month."' order by id DESC"; 
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

                        $payout_type = $row['payout_type'];

                        // total Amt Cal for BC 
                        $comm_amt = $row['amount'];
                        $tds = $comm_amt * 5/100;
                        $totalAmt = $comm_amt - $tds;

                        echo '<tr>
                                <td>'.$dt.'</td>
                                <td>'.$payout_type.'</td>
                                <td>'.$message1.'</td>
                                <td class="text-end">'.$comm_amt.'</td>
                                <td class="text-end">'.$tds.'</td>
                                <td class="text-end">'.$totalAmt.'
                                    <a href="forms/cbd_payout/download_cbd_payout.php?vkvbvjfgfikix='.$row['id'].'&bc='.$row['cbd_id'].'&date='.$dt.'&message='.$message1.'&message_status='.$row['status'].'&commission='.$row['amount'].'">
                                        <i class="bx bx-download" style="font-size: 18px; color: black; padding-left: 5px;"></i>
                                    </a>
                                </td>';
                                if($row['status'] == '1'){
                                    echo'<td><span class="badge badge-pill badge-soft-success font-size-10 fw-bold ms-4">Paid</span></td>';
                                }else{
                                    echo'<td><span class="badge badge-pill badge-soft-warning font-size-10 fw-bold ms-4" data-bs-toggle="modal" data-bs-target=".bs-example-modal-center">Pending</span></td>';
                                }
                        echo'</tr>';
                    }
                }
                    
                echo'</tbody>
            </table>
        </div>';
    }
          
    
?>