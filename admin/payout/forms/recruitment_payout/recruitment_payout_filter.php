<!-- all payout section filter  -->
<?php

require "../../../connect.php";

$cap_id = $_POST['cap_id'] ?? '';
$designation = $_POST['designation'] ;
$cap_year = $_POST['year_split']?? '';
$cap_month = $_POST['month_split']?? '';
$TotalPayoutFilter = $_POST['TotalPayoutFilter']?? '';
$perTDS = 2/100;
$tdsPer = 2/100;

    if($TotalPayoutFilter){
        if($designation == 'business_mentor'){
            $sqlId = "SELECT * FROM ca_ta_payout_paid WHERE business_mentor = '".$cap_id."' order by id DESC";
        }else if($designation == 'corporate_agency'){
            $sqlId = "SELECT * FROM ca_ta_payout_paid WHERE techno_enterprise <> '' AND techno_enterprise = '".$cap_id."' order by id DESC";
        }else if($designation == 'ca_travelagency'){
            $sqlId = "SELECT * FROM ca_ta_payout_paid WHERE travel_consultant = '".$cap_id."' order by id DESC";
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
    }else if(!$cap_id && !$cap_year && !$cap_month){ // if only designation filter

        $sqlId = "";
        if ($designation == 'business_mentor') {
            $sqlId = "SELECT * FROM ca_ta_payout ORDER BY id DESC";
        } else if ($designation == 'corporate_agency') {
            $sqlId = "SELECT * FROM ca_ta_payout WHERE techno_enterprise <> '' ORDER BY id DESC";
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
                            <th class="ceterText fw-bolder font-size-16 d-none">Id</th>
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
                $dt = (new DateTime($row['created_date']))->format('Y-m-d');

                if ($designation == 'business_mentor') {
                    $message = str_replace('.', '<br>', $row['message_bm']);
                    $amount = $row['commision_bm'] ?: 0;
                    $tds = $amount * $tdsPer;
                    $total = $amount - $tds;
                    $status = $row['status_bm'];
                } else if ($designation == 'corporate_agency') {
                    $message = str_replace('.', '<br>', $row['message_te']);
                    $amount = $row['commision_te'] ?: 0;
                    $tds = $amount * $tdsPer;
                    $total = $amount - $tds;
                    $status = $row['status_te'];
                } 

                echo '<tr>
                        <td class="d-none">'.$row['id'].'</td>
                        <td>'.$dt.'</td>
                        <td>'.$message.'</td>
                        <td class="text-end">'.$amount.'</td>
                        <td class="text-end">'.$tds.'</td>
                        <td class="text-end">'.$total.'
                            <a href="forms/recruitment_payout/download_cu_payout.php?vkvbvjfgfikix='.$row['id'].'&bm='.$row['business_mentor'].'&te='.$row['techno_enterprise'].'&tc='.$row['travel_consultant'].'&date='.$dt.'&message='.$message.'&message_status='.$status.'&commission='.$amount.'">
                                <i class="bx bx-download" style="font-size: 18px; color: black; padding-left: 5px;"></i>
                            </a>
                        </td>';

                if ($status == '1') {
                    echo '<td><span class="badge badge-pill badge-soft-success font-size-10 fw-bold ms-4">Paid</span></td>';
                } else {
                    echo '<td><span class="badge badge-pill badge-soft-warning font-size-10 fw-bold ms-4" data-bs-toggle="modal" data-bs-target=".bs-example-modal-center" onclick=\'paymentId("'.$row["id"].'","'.$cap_id.'","'.$message.'","'.$amount.'","'.$status.'","message")\'>Pending</span></td>';
                }

                echo '</tr>';
            }

            echo '</tbody></table></div>';
        } else {
            echo '<div class="alert alert-info">No payout data available for this designation.</div>';
        }

    }else if(!$cap_year && !$cap_month){ // if only id filter

        if($designation == 'business_mentor'){
            $sqlId = "SELECT * FROM ca_ta_payout WHERE business_mentor = '".$cap_id."' order by id DESC";
        }else if($designation == 'corporate_agency'){
            $sqlId = "SELECT * FROM ca_ta_payout WHERE techno_enterprise <> '' AND techno_enterprise = '".$cap_id."' order by id DESC";
        }else if($designation == 'ca_travelagency'){
            $sqlId = "SELECT * FROM ca_ta_payout WHERE ca_travelagency = '".$cap_id."' order by id DESC";
        }

        echo'<div class="table-responsive table-desi" id="filterTable">
            <table class="table table-hover" id="payoutDetailsTable">
                <thead>
                    <tr>
                        <th class="ceterText fw-bolder font-size-16 d-none">Id</th>
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
                    foreach ($stmt->fetchAll() as $row) {
                        $dt = (new DateTime($row['created_date']))->format('Y-m-d');

                        if ($designation == 'business_mentor') {
                            $message = str_replace('.', '<br>', $row['message_bm']);
                            $amount = $row['commision_bm'] ?: 0;
                            $tds = $amount * $tdsPer;
                            $total = $amount - $tds;
                            $status = $row['status_bm'];
                        } else if ($designation == 'corporate_agency') {
                            $message = str_replace('.', '<br>', $row['message_te']);
                            $amount = $row['commision_te'] ?: 0;
                            $tds = $amount * $tdsPer;
                            $total = $amount - $tds;
                            $status = $row['status_te'];
                        } 

                        echo '<tr>
                                <td class="d-none">'.$row['id'].'</td>
                                <td>'.$dt.'</td>
                                <td>'.$message.'</td>
                                <td class="text-end">'.$amount.'</td>
                                <td class="text-end">'.$tds.'</td>
                                <td class="text-end">'.$total.'
                                    <a href="forms/recruitment_payout/download_cu_payout.php?vkvbvjfgfikix='.$row['id'].'&bm='.$row['business_mentor'].'&te='.$row['techno_enterprise'].'&tc='.$row['travel_consultant'].'&date='.$dt.'&message='.$message.'&message_status='.$status.'&commission='.$amount.'">
                                        <i class="bx bx-download" style="font-size: 18px; color: black; padding-left: 5px;"></i>
                                    </a>
                                </td>';

                        if ($status == '1') {
                            echo '<td><span class="badge badge-pill badge-soft-success font-size-10 fw-bold ms-4">Paid</span></td>';
                        } else {
                            echo '<td><span class="badge badge-pill badge-soft-warning font-size-10 fw-bold ms-4" data-bs-toggle="modal" data-bs-target=".bs-example-modal-center" onclick=\'paymentId("'.$row["id"].'","'.$cap_id.'","'.$message.'","'.$amount.'","'.$status.'","message")\'>Pending</span></td>';
                        }

                        echo '</tr>';
                    }
                }
                    
                echo'</tbody>
            </table>
        </div>';

    }else if(!$cap_id && !$designation){    // if only date filter are their 
        // check datatable not working when date filter applied
        // if($designation == 'business_mentor'){
        //     $sqlId = "SELECT * FROM ca_ta_payout WHERE YEAR(created_date) = '".$cap_year."' AND MONTH(created_date) = '".$cap_month."' order by id DESC";
        // }else if($designation == 'corporate_agency'){
        //     $sqlId = "SELECT * FROM ca_ta_payout WHERE YEAR(created_date) = '".$cap_year."' AND MONTH(created_date) = '".$cap_month."' order by id DESC";
        // }else if($designation == 'ca_travelagency'){
        //     $sqlId = "SELECT * FROM ca_ta_payout WHERE YEAR(created_date) = '".$cap_year."' AND MONTH(created_date) = '".$cap_month."' order by id DESC";
        // }

        echo'<div class="table-responsive table-desi" id="filterTable">
            <table class="table table-hover" id="payoutDetailsTable ">
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
                        
                $stmt = $conn -> prepare("SELECT * FROM ca_ta_payout WHERE YEAR(created_date) = '".$cap_year."' AND MONTH(created_date) = '".$cap_month."' order by id DESC");
                $stmt -> execute();
                $stmt -> setFetchMode(PDO::FETCH_ASSOC);
                if( $stmt -> rowCount()>0 ){
                    foreach( ($stmt -> fetchALL()) as $key => $row ){

                        // date in proper formate
                        $dt = new DateTime($row['created_date']);
                        $dt = $dt->format('Y-m-d');

                        // replace dot at end of the line with break statement
                        $message1 = $row['message_bm'];
                        $message1 =  str_replace('.','<br>',$message1); 

                        // replace dot at end of the line with break statement
                        $message2 = $row['message_te'];
                        $message2 =  str_replace('.','<br>',$message2);  

                        // total Amt Cal for BC 
                        $CommAmtBc = $row['commision_bm'];
                        $tdsBc = $CommAmtBc * $perTDS;
                        $totalAmtBc = $CommAmtBc - $tdsBc;

                        // total Amt Cal for CA
                        $CommAmtCa = $row['commision_te'];
                        $tdsCa = $CommAmtCa * $perTDS;
                        $totalAmtCa = $CommAmtCa - $tdsCa;

                        echo '<tr>
                                <td>'.$dt.'</td>
                                <td>'.$message1.'</td>
                                <td class="text-end">'.$CommAmtBc.'</td>
                                <td class="text-end">'.$tdsBc.'</td>
                                <td class="text-end">'.$totalAmtBc.'
                                    <a href="forms/recruitment_payout/download_ca_payout.php?vkvbvjfgfikix='.$row['id'].'&bc='.$row['business_mentor'].'&ca='.$row['techno_enterprise'].'&ta_ca='.$row['travel_consultant'].'&date='.$dt.'&message='.$message1.'&message_status='.$row['status_bm'].'&commission='.$row['commision_bm'].'">
                                                <i class="bx bx-download" style="font-size: 18px; color: black; padding-left: 5px;"></i>
                                    </a>
                                </td>';
                                if($row['status_bm'] == '1'){
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
                                    <a href="forms/recruitment_payout/download_ca_payout.php?vkvbvjfgfikix='.$row['id'].'&bc='.$row['business_mentor'].'&ca='.$row['techno_enterprise'].'&ta_ca='.$row['travel_consultant'].'&date='.$dt.'&message='.$message2.'&message_status='.$row['status_te'].'&commission='.$row['commision_te'].'">
                                                <i class="bx bx-download" style="font-size: 18px; color: black; padding-left: 5px;"></i>
                                    </a>
                                </td>';
                                if($row['status_te'] == '1'){
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
    }else{    // if all filter are their i.e date, and id
        // check datatable not working when date filter applied
        if($designation == 'business_mentor'){
            $sqlId = "SELECT * FROM ca_ta_payout WHERE business_mentor = '".$cap_id."' AND YEAR(created_date) = '".$cap_year."' AND MONTH(created_date) = '".$cap_month."' order by id DESC";
        }else if($designation == 'corporate_agency'){
            $sqlId = "SELECT * FROM ca_ta_payout WHERE techno_enterprise = '".$cap_id."' AND YEAR(created_date) = '".$cap_year."' AND MONTH(created_date) = '".$cap_month."' order by id DESC";
        }else if($designation == 'ca_travelagency'){
            $sqlId = "SELECT * FROM ca_ta_payout WHERE ca_travelagency = '".$cap_id."' AND YEAR(created_date) = '".$cap_year."' AND MONTH(created_date) = '".$cap_month."' order by id DESC";
        }

        echo'<div class="table-responsive table-desi" id="filterTable">
            <table class="table table-hover" id="payoutDetailsTable ">
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
                        $message1 = $row['message_bm'];
                        $message1 =  str_replace('.','<br>',$message1); 

                        // replace dot at end of the line with break statement
                        $message2 = $row['message_te'];
                        $message2 =  str_replace('.','<br>',$message2);  

                        // total Amt Cal for BC 
                        $CommAmtBc = $row['commision_bm'];
                        $tdsBc = $CommAmtBc * $perTDS;
                        $totalAmtBc = $CommAmtBc - $tdsBc;

                        // total Amt Cal for CA
                        $CommAmtCa = $row['commision_te'];
                        $tdsCa = $CommAmtCa * $perTDS;
                        $totalAmtCa = $CommAmtCa - $tdsCa;

                        echo '<tr>
                                <td>'.$dt.'</td>
                                <td>'.$message1.'</td>
                                <td class="text-end">'.$CommAmtBc.'</td>
                                <td class="text-end">'.$tdsBc.'</td>
                                <td class="text-end">'.$totalAmtBc.'
                                    <a href="forms/recruitment_payout/download_ca_payout.php?vkvbvjfgfikix='.$row['id'].'&bc='.$row['business_mentor'].'&ca='.$row['techno_enterprise'].'&ta_ca='.$row['travel_consultant'].'&date='.$dt.'&message='.$message1.'&message_status='.$row['status_bm'].'&commission='.$row['commision_bm'].'">
                                                <i class="bx bx-download" style="font-size: 18px; color: black; padding-left: 5px;"></i>
                                    </a>
                                </td>';
                                if($row['status_bm'] == '1'){
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
                                    <a href="forms/recruitment_payout/download_ca_payout.php?vkvbvjfgfikix='.$row['id'].'&bc='.$row['business_mentor'].'&ca='.$row['techno_enterprise'].'&ta_ca='.$row['travel_consultant'].'&date='.$dt.'&message='.$message2.'&message_status='.$row['status_te'].'&commission='.$row['commision_te'].'">
                                                <i class="bx bx-download" style="font-size: 18px; color: black; padding-left: 5px;"></i>
                                    </a>
                                </td>';
                                if($row['status_te'] == '1'){
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