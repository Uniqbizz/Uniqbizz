<!-- all payout section filter  -->
<?php

require "../../../connect.php";

$cap_id = $_POST['cap_id'];
$designation = $_POST['designation'];
$cap_year = $_POST['year_split']?? '';
$cap_month = $_POST['month_split']?? '';
$TotalPayoutFilter = $_POST['TotalPayoutFilter']?? '';

$tdsPercentage=2/100;

    if($TotalPayoutFilter){
        
        if($designation == 'business_channel_manager'){
            $sqlId = "SELECT * FROM product_payout WHERE bch_id = '".$cap_id."'  order by id DESC";
        }else if($designation == 'business_development_manager'){
            $sqlId = "SELECT * FROM product_payout WHERE bdm_id = '".$cap_id."'  order by id DESC";
        }else if($designation == 'business_mentor'){
            $sqlId = "SELECT * FROM product_payout WHERE bm_id = '".$cap_id."'  order by id DESC";
        }else if($designation == 'corporate_agency'){
            $sqlId = "SELECT * FROM product_payout WHERE te_id = '".$cap_id."'  order by id DESC";
        }else if($designation == 'ca_travelagency'){
            $sqlId = "SELECT * FROM product_payout WHERE ta_id = '".$cap_id."'  order by id DESC";
        }else if($designation == 'ca_customer'){
            $sqlId = "SELECT * FROM product_payout WHERE (cu1_id = '".$cap_id."' OR cu2_id = '".$cap_id."' OR cu3_id = '".$cap_id."')  order by id DESC";
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
                // print_r($stmt);
                if( $stmt -> rowCount()>0 ){
                    foreach( ($stmt -> fetchALL()) as $key => $row ){

                        // date in proper formate
                        $dt = new DateTime($row['created_date']);
                        $dt = $dt->format('Y-m-d');

                        $id = $row['id'];

                        // replace dot at end of the line with break statement
                        if($designation == 'business_channel_manager'){
                            $userId = $row['bch_id'];
                            $message1 = $row['bch_mess'];
                            $comm_amt = $row['bch_amt'];
                            $status = $row['bch_status'];
                            $status_col = "bch_status";
                            $identifier = "AllPayoutFilterBch";
                        }else if($designation == 'business_development_manager'){
                            $userId = $row['bdm_id'];
                            $message1 = $row['bdm_mess'];
                            $comm_amt = $row['bdm_amt'];
                            $status = $row['bdm_status'];
                            $status_col = "bdm_status";
                            $identifier = "AllPayoutFilterBdm";
                        }else if($designation == 'business_mentor'){
                            $userId = $row['bm_id'];
                            $message1 = $row['bm_mess'];
                            $comm_amt = $row['bm_amt'];
                            $status = $row['bm_status'];
                            $status_col = "bm_status";
                            $identifier = "AllPayoutFilterBm";
                        }else if($designation == 'corporate_agency'){
                            $userId = $row['te_id'];
                            $message1 = $row['te_mess'];
                            $comm_amt = $row['te_amt'];
                            $status = $row['te_status'];
                            $status_col = "te_status";
                            $identifier = "AllPayoutFilterCa";
                        }else if($designation == 'ca_travelagency'){
                            $userId = $row['ta_id'];
                            $message1 = $row['ta_mess'];
                            $comm_amt = $row['ta_amt'];
                            $status = $row['ta_status'];
                            $status_col = "ta_status";
                            $identifier = "AllPayoutFilterCaTa";
                        } else if($designation == 'ca_customer'){
                            if ($row['cu1_id'] == $cap_id) {
                                // If cu1_id matches, get cu1 related data
                                $userId = $row['cu1_id'];
                                $message1 = $row['cu1_mess'];
                                $comm_amt = $row['cu1_amt'];
                                $status = $row['cu1_status'];
                                $status_col = "cu1_status";
                                $identifier = "AllPayoutCaCu1";
                            } else if ($row['cu2_id'] == $cap_id) {
                                // If cu2_id matches, get cu2 related data
                                $userId = $row['cu2_id'];
                                $message1 = $row['cu2_mess'];
                                $comm_amt = $row['cu2_amt'];
                                $status = $row['cu2_status'];
                                $status_col = "cu2_status";
                                $identifier = "AllPayoutCaCu2";
                            } else if ($row['cu3_id'] == $cap_id) {
                                // If cu3_id matches, get cu3 related data
                                $userId = $row['cu3_id'];
                                $message1 = $row['cu3_mess'];
                                $comm_amt = $row['cu3_amt'];
                                $status = $row['cu3_status'];
                                $status_col = "cu3_status";
                                $identifier = "AllPayoutCaCu3";
                            }
                        }
                        // else if($designation == 'ca_customer'){
                        //     $userId = $row['cu1_id'];
                        //     $message1 = $row['cu1_mess'];
                        //     $comm_amt = $row['cu1_amt'];
                        //     $status = $row['cu1_status'];
                        //     $status_col = "cu1_status";
                        //     $identifier = "AllPayoutCaCu1";
                        // }

                        // $message1 = $row['message'];
                        // $message1 =  str_replace('.','<br>',$message1);

                        // $message_details = $row['message_details'];
                        // $message_details =  str_replace('.','<br>',$message_details);

                        // total Amt Cal for BC 
                        // $comm_amt = $row['comm_amt'];
                        $tds = $comm_amt * $tdsPercentage;
                        $totalAmt = $comm_amt - $tds;

                        echo '<tr>
                                <td>'.$dt.'</td>
                                <td>'.$message1.'</td>
                                <td class="text-end">'.$comm_amt.'</td>
                                <td class="text-end">'.$tds.'</td>
                                <td class="text-end">'.$totalAmt.'</td>';
                                if($status == '1'){
                                    echo'<td><span class="badge badge-pill badge-soft-success font-size-10 fw-bold ms-4">Paid</span></td>';
                                }else{
                                    echo'<td><span class="badge badge-pill badge-soft-warning font-size-10 fw-bold ms-4" data-bs-toggle="modal" data-bs-target=".bs-example-modal-center" onclick=\'paymentId("'.$id.'","'.$userId. '","'.$message1.'","'.$comm_amt.'","'.$status_col.'","'.$identifier.'")\'>Pending</span></td>';
                                }
                        echo'</tr>';
                    }
                }
                    
                echo'</tbody>
            </table>
        </div>';
    }else if(!$cap_year && !$cap_month){

        if($designation == 'business_channel_manager'){
            $sqlId = "SELECT * FROM product_payout WHERE bch_id = '".$cap_id."'  order by id DESC";
        }else if($designation == 'business_development_manager'){
            $sqlId = "SELECT * FROM product_payout WHERE bdm_id = '".$cap_id."'  order by id DESC";
        }else if($designation == 'business_mentor'){
            $sqlId = "SELECT * FROM product_payout WHERE bm_id = '".$cap_id."'  order by id DESC";
        }else if($designation == 'corporate_agency'){
            $sqlId = "SELECT * FROM product_payout WHERE te_id = '".$cap_id."'  order by id DESC";
        }else if($designation == 'ca_travelagency'){
            $sqlId = "SELECT * FROM product_payout WHERE ta_id = '".$cap_id."'  order by id DESC";
        }else if($designation == 'ca_customer'){
            $sqlId = "SELECT * FROM product_payout WHERE (cu1_id = '".$cap_id."' OR cu2_id = '".$cap_id."' OR cu3_id = '".$cap_id."')  order by id DESC";
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
                // print_r($stmt);
                if( $stmt -> rowCount()>0 ){
                    foreach( ($stmt -> fetchALL()) as $key => $row ){

                        // date in proper formate
                        $dt = new DateTime($row['created_date']);
                        $dt = $dt->format('Y-m-d');

                        $id = $row['id'];

                        // replace dot at end of the line with break statement
                        if($designation == 'business_channel_manager'){
                            $userId = $row['bch_id'];
                            $message1 = $row['bch_mess'];
                            $comm_amt = $row['bch_amt'];
                            $status = $row['bch_status'];
                            $status_col = "bch_status";
                            $identifier = "AllPayoutFilterBch";
                        }else if($designation == 'business_development_manager'){
                            $userId = $row['bdm_id'];
                            $message1 = $row['bdm_mess'];
                            $comm_amt = $row['bdm_amt'];
                            $status = $row['bdm_status'];
                            $status_col = "bdm_status";
                            $identifier = "AllPayoutFilterBdm";
                        }else if($designation == 'business_mentor'){
                            $userId = $row['bm_id'];
                            $message1 = $row['bm_mess'];
                            $comm_amt = $row['bm_amt'];
                            $status = $row['bm_status'];
                            $status_col = "bm_status";
                            $identifier = "AllPayoutFilterBm";
                        }else if($designation == 'corporate_agency'){
                            $userId = $row['te_id'];
                            $message1 = $row['te_mess'];
                            $comm_amt = $row['te_amt'];
                            $status = $row['te_status'];
                            $status_col = "te_status";
                            $identifier = "AllPayoutFilterCa";
                        }else if($designation == 'ca_travelagency'){
                            $userId = $row['ta_id'];
                            $message1 = $row['ta_mess'];
                            $comm_amt = $row['ta_amt'];
                            $status = $row['ta_status'];
                            $status_col = "ta_status";
                            $identifier = "AllPayoutFilterCaTa";
                        } else if($designation == 'ca_customer'){
                            if ($row['cu1_id'] == $cap_id) {
                                // If cu1_id matches, get cu1 related data
                                $userId = $row['cu1_id'];
                                $message1 = $row['cu1_mess'];
                                $comm_amt = $row['cu1_amt'];
                                $status = $row['cu1_status'];
                                $status_col = "cu1_status";
                                $identifier = "AllPayoutCaCu1";
                            } else if ($row['cu2_id'] == $cap_id) {
                                // If cu2_id matches, get cu2 related data
                                $userId = $row['cu2_id'];
                                $message1 = $row['cu2_mess'];
                                $comm_amt = $row['cu2_amt'];
                                $status = $row['cu2_status'];
                                $status_col = "cu2_status";
                                $identifier = "AllPayoutCaCu2";
                            } else if ($row['cu3_id'] == $cap_id) {
                                // If cu3_id matches, get cu3 related data
                                $userId = $row['cu3_id'];
                                $message1 = $row['cu3_mess'];
                                $comm_amt = $row['cu3_amt'];
                                $status = $row['cu3_status'];
                                $status_col = "cu3_status";
                                $identifier = "AllPayoutCaCu3";
                            }
                        }
                        // else if($designation == 'ca_customer'){
                        //     $userId = $row['cu1_id'];
                        //     $message1 = $row['cu1_mess'];
                        //     $comm_amt = $row['cu1_amt'];
                        //     $status = $row['cu1_status'];
                        //     $status_col = "cu1_status";
                        //     $identifier = "AllPayoutCaCu1";
                        // }

                        // $message1 = $row['message'];
                        // $message1 =  str_replace('.','<br>',$message1);

                        // $message_details = $row['message_details'];
                        // $message_details =  str_replace('.','<br>',$message_details);

                        // total Amt Cal for BC 
                        // $comm_amt = $row['comm_amt'];
                        $tds = $comm_amt * $tdsPercentage;
                        $totalAmt = $comm_amt - $tds;

                        echo '<tr>
                                <td>'.$dt.'</td>
                                <td>'.$message1.'</td>
                                <td class="text-end">'.$comm_amt.'</td>
                                <td class="text-end">'.$tds.'</td>
                                <td class="text-end">'.$totalAmt.'</td>';
                                if($status == '1'){
                                    echo'<td><span class="badge badge-pill badge-soft-success font-size-10 fw-bold ms-4">Paid</span></td>';
                                }else{
                                    echo'<td><span class="badge badge-pill badge-soft-warning font-size-10 fw-bold ms-4" data-bs-toggle="modal" data-bs-target=".bs-example-modal-center" onclick=\'paymentId("'.$id.'","'.$userId. '","'.$message1.'","'.$comm_amt.'","'.$status_col.'","'.$identifier.'")\'>Pending</span></td>';
                                }
                        echo'</tr>';
                    }
                }
                    
                echo'</tbody>
            </table>
        </div>';

    }else{    

        if($designation == 'business_channel_manager'){
            $sqlId = "SELECT * FROM product_payout WHERE bch_id = '".$cap_id."' AND YEAR(created_date) = '".$cap_year."' AND MONTH(created_date) = '".$cap_month."' order by id DESC";
        }else if($designation == 'business_development_manager'){
            $sqlId = "SELECT * FROM product_payout WHERE bdm_id = '".$cap_id."' AND YEAR(created_date) = '".$cap_year."' AND MONTH(created_date) = '".$cap_month."' order by id DESC";
        }else if($designation == 'business_mentor'){
            $sqlId = "SELECT * FROM product_payout WHERE bm_id = '".$cap_id."' AND YEAR(created_date) = '".$cap_year."' AND MONTH(created_date) = '".$cap_month."' order by id DESC";
        }else if($designation == 'corporate_agency'){
            $sqlId = "SELECT * FROM product_payout WHERE te_id = '".$cap_id."' AND YEAR(created_date) = '".$cap_year."' AND MONTH(created_date) = '".$cap_month."' order by id DESC";
        }else if($designation == 'ca_travelagency'){
            $sqlId = "SELECT * FROM product_payout WHERE ta_id = '".$cap_id."' AND YEAR(created_date) = '".$cap_year."' AND MONTH(created_date) = '".$cap_month."' order by id DESC";
        }else if($designation == 'ca_customer'){
            $sqlId = "SELECT * FROM product_payout WHERE (cu1_id = '".$cap_id."' OR cu2_id = '".$cap_id."' OR cu3_id = '".$cap_id."') AND YEAR(created_date) = '".$cap_year."' AND MONTH(created_date) = '".$cap_month."' order by id DESC";
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
                // print_r($stmt);
                if( $stmt -> rowCount()>0 ){
                    foreach( ($stmt -> fetchALL()) as $key => $row ){

                        // date in proper formate
                        $dt = new DateTime($row['created_date']);
                        $dt = $dt->format('Y-m-d');

                        $id = $row['id'];

                        // replace dot at end of the line with break statement
                        if($designation == 'business_channel_manager'){
                            $userId = $row['bch_id'];
                            $message1 = $row['bch_mess'];
                            $comm_amt = $row['bch_amt'];
                            $status = $row['bch_status'];
                            $status_col = "bch_status";
                            $identifier = "AllPayoutFilterBch";
                        }else if($designation == 'business_development_manager'){
                            $userId = $row['bdm_id'];
                            $message1 = $row['bdm_mess'];
                            $comm_amt = $row['bdm_amt'];
                            $status = $row['bdm_status'];
                            $status_col = "bdm_status";
                            $identifier = "AllPayoutFilterBdm";
                        }else if($designation == 'business_mentor'){
                            $userId = $row['bm_id'];
                            $message1 = $row['bm_mess'];
                            $comm_amt = $row['bm_amt'];
                            $status = $row['bm_status'];
                            $status_col = "bm_status";
                            $identifier = "AllPayoutFilterBm";
                        }else if($designation == 'corporate_agency'){
                            $userId = $row['te_id'];
                            $message1 = $row['te_mess'];
                            $comm_amt = $row['te_amt'];
                            $status = $row['te_status'];
                            $status_col = "te_status";
                            $identifier = "AllPayoutFilterCa";
                        }else if($designation == 'ca_travelagency'){
                            $userId = $row['ta_id'];
                            $message1 = $row['ta_mess'];
                            $comm_amt = $row['ta_amt'];
                            $status = $row['ta_status'];
                            $status_col = "ta_status";
                            $identifier = "AllPayoutFilterCaTa";
                        } else if($designation == 'ca_customer'){
                            if ($row['cu1_id'] == $cap_id) {
                                // If cu1_id matches, get cu1 related data
                                $userId = $row['cu1_id'];
                                $message1 = $row['cu1_mess'];
                                $comm_amt = $row['cu1_amt'];
                                $status = $row['cu1_status'];
                                $status_col = "cu1_status";
                                $identifier = "AllPayoutCaCu1";
                            } else if ($row['cu2_id'] == $cap_id) {
                                // If cu2_id matches, get cu2 related data
                                $userId = $row['cu2_id'];
                                $message1 = $row['cu2_mess'];
                                $comm_amt = $row['cu2_amt'];
                                $status = $row['cu2_status'];
                                $status_col = "cu2_status";
                                $identifier = "AllPayoutCaCu2";
                            } else if ($row['cu3_id'] == $cap_id) {
                                // If cu3_id matches, get cu3 related data
                                $userId = $row['cu3_id'];
                                $message1 = $row['cu3_mess'];
                                $comm_amt = $row['cu3_amt'];
                                $status = $row['cu3_status'];
                                $status_col = "cu3_status";
                                $identifier = "AllPayoutCaCu3";
                            }
                        }
                        // else if($designation == 'ca_customer'){
                        //     $userId = $row['cu1_id'];
                        //     $message1 = $row['cu1_mess'];
                        //     $comm_amt = $row['cu1_amt'];
                        //     $status = $row['cu1_status'];
                        //     $status_col = "cu1_status";
                        //     $identifier = "AllPayoutCaCu1";
                        // }

                        // $message1 = $row['message'];
                        // $message1 =  str_replace('.','<br>',$message1);

                        // $message_details = $row['message_details'];
                        // $message_details =  str_replace('.','<br>',$message_details);

                        // total Amt Cal for BC 
                        // $comm_amt = $row['comm_amt'];
                        $tds = $comm_amt * $tdsPercentage;
                        $totalAmt = $comm_amt - $tds;

                        echo '<tr>
                                <td>'.$dt.'</td>
                                <td>'.$message1.'</td>
                                <td class="text-end">'.$comm_amt.'</td>
                                <td class="text-end">'.$tds.'</td>
                                <td class="text-end">'.$totalAmt.'</td>';
                                if($status == '1'){
                                    echo'<td><span class="badge badge-pill badge-soft-success font-size-10 fw-bold ms-4">Paid</span></td>';
                                }else{
                                    echo'<td><span class="badge badge-pill badge-soft-warning font-size-10 fw-bold ms-4" data-bs-toggle="modal" data-bs-target=".bs-example-modal-center" onclick=\'paymentId("'.$id.'","'.$userId. '","'.$message1.'","'.$comm_amt.'","'.$status_col.'","'.$identifier.'")\'>Pending</span></td>';
                                }
                        echo'</tr>';
                    }
                }
                    
                echo'</tbody>
            </table>
        </div>';
    }
          
    
?>