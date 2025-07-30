<!-- all payout section filter  -->
<?php

require "../../../connect.php";

$cap_id = $_POST['cap_id'];
$designation = $_POST['designation'];
$cap_year = $_POST['year_split']?? '';
$cap_month = $_POST['month_split']?? '';
$TotalPayoutFilter = $_POST['TotalPayoutFilter']?? '';

    if($TotalPayoutFilter){
        if($designation == 'business_consultant'){
            $sqlId = "SELECT * FROM ca_ta_payout_paid WHERE business_consultant = '".$cap_id."' order by id DESC";
        }else if($designation == 'corporate_agency'){
            $sqlId = "SELECT * FROM ca_ta_payout_paid WHERE corporate_agency = '".$cap_id."' order by id DESC";
        }else if($designation == 'ca_travelagency'){
            $sqlId = "SELECT * FROM ca_ta_payout_paid WHERE ca_travelagency = '".$cap_id."' order by id DESC";
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
                        <th class="ceterText fw-bolder font-size-16">Status</th>
                    </tr>
                </thead>
                <tbody>';
                        
                $stmt = $conn -> prepare($sqlId);
                $stmt -> execute();
                $stmt -> setFetchMode(PDO::FETCH_ASSOC);
                if( $stmt -> rowCount()>0 ){
                    foreach( ($stmt -> fetchALL()) as $key => $row ){

                        // date in proper formate
                        $dt = new DateTime($row['date']);
                        $dt = $dt->format('Y-m-d');

                        // replace dot at end of the line with break statement
                        $message1 = $row['payout_message'];
                        $message1 =  str_replace('.','<br>',$message1); 

                        // replace dot at end of the line with break statement
                        $message2 = $row['payout_details'];
                        $message2 =  str_replace('.','<br>',$message2);  

                        echo '<tr>
                                <td>'.$dt.'</td>
                                <td>'.$message1.'</td>
                                <td>'.$message2.'</td>
                                <td class="text-end">'.$row['amount'].'</td>
                                <td class="text-end">'.$row['tds'].'</td>
                                <td class="text-end">'.$row['total_payable'].'</td>';
                                if($row['status'] == '1'){
                                    echo'<td><span class="badge badge-pill badge-soft-success font-size-10 fw-bold ms-4">Paid</span></td>';
                                }else{
                                    echo'<td><span class="badge badge-pill badge-soft-warning font-size-10 fw-bold ms-4" >Pending</span></td>';
                                }
                        echo'</tr>';
                    }
                }
                    
                echo'</tbody>
            </table>
        </div>';
    }else if(!$cap_year && !$cap_month){

        if($designation == 'business_consultant'){
            $sqlId = "SELECT * FROM ca_ta_payout WHERE business_consultant = '".$cap_id."' order by id DESC";
        }else if($designation == 'corporate_agency'){
            $sqlId = "SELECT * FROM ca_ta_payout WHERE corporate_agency = '".$cap_id."' order by id DESC";
        }else if($designation == 'ca_travelagency'){
            $sqlId = "SELECT * FROM ca_ta_payout WHERE ca_travelagency = '".$cap_id."' order by id DESC";
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
                        $message1 = $row['message_bc'];
                        $message1 =  str_replace('.','<br>',$message1); 

                        // replace dot at end of the line with break statement
                        $message2 = $row['message_ca'];
                        $message2 =  str_replace('.','<br>',$message2);  

                        // total Amt Cal for BC 
                        $CommAmtBc = $row['commision_bc'];
                        $tdsBc = $CommAmtBc * 5/100;
                        $totalAmtBc = $CommAmtBc - $tdsBc;

                        // total Amt Cal for CA
                        $CommAmtCa = $row['commision_ca'];
                        $tdsCa = $CommAmtCa * 5/100;
                        $totalAmtCa = $CommAmtCa - $tdsCa;

                        echo '<tr>
                                <td>'.$dt.'</td>
                                <td>'.$message1.'</td>
                                <td class="text-end">'.$CommAmtBc.'</td>
                                <td class="text-end">'.$tdsBc.'</td>
                                <td class="text-end">'.$totalAmtBc.'
                                    <a href="forms/recruitment_payout/download_ca_payout.php?vkvbvjfgfikix='.$row['id'].'&bc='.$row['business_consultant'].'&ca='.$row['corporate_agency'].'&ta_ca='.$row['ca_travelagency'].'&date='.$dt.'&message='.$message1.'&message_status='.$row['status_bc'].'&commission='.$row['commision_bc'].'">
                                                <i class="bx bx-download" style="font-size: 18px; color: black; padding-left: 5px;"></i>
                                    </a>
                                </td>';
                                if($row['status_bc'] == '1'){
                                    echo'<td><span class="badge badge-pill badge-soft-success font-size-10 fw-bold ms-4">Paid</span></td>';
                                }else{
                                    echo'<td><span class="badge badge-pill badge-soft-warning font-size-10 fw-bold ms-4" data-bs-toggle="modal" data-bs-target=".bs-example-modal-center">Pending</span></td>';
                                }
                        echo'</tr>';

                        echo '<tr>
                                <td>'.$dt.'</td>
                                <td>'.$message2.'</td>
                                <td class="text-end">'.$CommAmtCa.'</td>
                                <td class="text-end">'.$tdsCa.'</td>
                                <td class="text-end">'.$totalAmtCa.'
                                    <a href="forms/recruitment_payout/download_ca_payout.php?vkvbvjfgfikix='.$row['id'].'&bc='.$row['business_consultant'].'&ca='.$row['corporate_agency'].'&ta_ca='.$row['ca_travelagency'].'&date='.$dt.'&message='.$message2.'&message_status='.$row['status_ca'].'&commission='.$row['commision_ca'].'">
                                                <i class="bx bx-download" style="font-size: 18px; color: black; padding-left: 5px;"></i>
                                    </a>
                                </td>';
                                if($row['status_ca'] == '1'){
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

        if($designation == 'business_consultant'){
            $sqlId = "SELECT * FROM ca_ta_payout WHERE business_consultant = '".$cap_id."' AND YEAR(created_date) = '".$cap_year."' AND MONTH(created_date) = '".$cap_month."' order by id DESC";
        }else if($designation == 'corporate_agency'){
            $sqlId = "SELECT * FROM ca_ta_payout WHERE corporate_agency = '".$cap_id."' AND YEAR(created_date) = '".$cap_year."' AND MONTH(created_date) = '".$cap_month."' order by id DESC";
        }else if($designation == 'ca_travelagency'){
            $sqlId = "SELECT * FROM ca_ta_payout WHERE ca_travelagency = '".$cap_id."' AND YEAR(created_date) = '".$cap_year."' AND MONTH(created_date) = '".$cap_month."' order by id DESC";
        }

        echo'<div class="table-responsive table-desi" id="filterTable">
            <table class="table table-hover" id="payoutDetailsTable payoutDetailsTable2">
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
                        $message1 = $row['message_bc'];
                        $message1 =  str_replace('.','<br>',$message1); 

                        // replace dot at end of the line with break statement
                        $message2 = $row['message_ca'];
                        $message2 =  str_replace('.','<br>',$message2);  

                        // total Amt Cal for BC 
                        $CommAmtBc = $row['commision_bc'];
                        $tdsBc = $CommAmtBc * 5/100;
                        $totalAmtBc = $CommAmtBc - $tdsBc;

                        // total Amt Cal for CA
                        $CommAmtCa = $row['commision_ca'];
                        $tdsCa = $CommAmtCa * 5/100;
                        $totalAmtCa = $CommAmtCa - $tdsCa;

                        echo '<tr>
                                <td>'.$dt.'</td>
                                <td>'.$message1.'</td>
                                <td class="text-end">'.$CommAmtBc.'</td>
                                <td class="text-end">'.$tdsBc.'</td>
                                <td class="text-end">'.$totalAmtBc.'
                                    <a href="forms/recruitment_payout/download_ca_payout.php?vkvbvjfgfikix='.$row['id'].'&bc='.$row['business_consultant'].'&ca='.$row['corporate_agency'].'&ta_ca='.$row['ca_travelagency'].'&date='.$dt.'&message='.$message1.'&message_status='.$row['status_bc'].'&commission='.$row['commision_bc'].'">
                                        <i class="bx bx-download" style="font-size: 18px; color: black; padding-left: 5px;"></i>
                                    </a>
                                </td>';
                                if($row['status_bc'] == '1'){
                                    echo'<td><span class="badge badge-pill badge-soft-success font-size-10 fw-bold ms-4">Paid</span></td>';
                                }else{
                                    echo'<td><span class="badge badge-pill badge-soft-warning font-size-10 fw-bold ms-4" data-bs-toggle="modal" data-bs-target=".bs-example-modal-center">Pending</span></td>';
                                }
                        echo'</tr>';

                        echo '<tr>
                                <td>'.$dt.'</td>
                                <td>'.$message2.'</td>
                                <td class="text-end">'.$CommAmtCa.'</td>
                                <td class="text-end">'.$tdsCa.'</td>
                                <td class="text-end">'.$totalAmtCa.'
                                    <a href="forms/recruitment_payout/download_ca_payout.php?vkvbvjfgfikix='.$row['id'].'&bc='.$row['business_consultant'].'&ca='.$row['corporate_agency'].'&ta_ca='.$row['ca_travelagency'].'&date='.$dt.'&message='.$message2.'&message_status='.$row['status_ca'].'&commission='.$row['commision_ca'].'">
                                        <i class="bx bx-download" style="font-size: 18px; color: black; padding-left: 5px;"></i>
                                    </a>
                                </td>';
                                if($row['status_ca'] == '1'){
                                    echo'<td><span class="badge badge-pill badge-soft-success font-size-10 fw-bold ms-4">Paid</span></td>';
                                }else{
                                    echo'<td><span class="badge badge-pill badge-soft-warning font-size-10 fw-bold ms-4" data-bs-toggle="modal" data-bs-target=".bs-example-modal-center">Pending</span></td>';
                                }
                        echo'</tr>';
                    }
                }
                    
                echo'</tbody>
            </table>
            <!-- pegination start -->
            <div class="center text-center" id="pagination_row"></div>
        </div>';
    }
          
    
?>