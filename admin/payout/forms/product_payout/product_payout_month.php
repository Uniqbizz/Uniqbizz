<!-- total payout Model and section amount change and add date to model  -->
<?php
require '../../../connect.php';

$TotalYear = $_POST['TotalYear'];
$TotalMonth = $_POST['TotalMonth'];
$totalAmountMessage = $_POST['totalAmountMessage'] ?? '';
$totalTableMessage = $_POST['totalTableMessage'] ?? '';

$tdsPercentage = 2/100;

if($totalAmountMessage){
    $stmt = " SELECT SUM(ta_markup+ta_amt+te_amt+bm_amt+bdm_amt+bch_amt+cu1_amt+cu2_amt+cu3_amt) as TotalPayout FROM product_payout WHERE YEAR(created_date) = '".$TotalYear."' AND MONTH(created_date) = '".$TotalMonth."'  ";
    $stmt = $conn -> prepare($stmt);
    $stmt -> execute();
    $stmt -> setFetchMode(PDO::FETCH_ASSOC);
    if($stmt -> rowCount()>0){
        foreach($stmt -> fetchAll() as $key => $row){
            $TotalPayable = $row['TotalPayout'];
            $totalPayoutTDS = $TotalPayable * $tdsPercentage;
            $TotalPayout = $TotalPayable - $totalPayoutTDS;
            $truncatedTotalAmount = floor($TotalPayout * 100) / 100;
            if($TotalPayout == null){
                echo 0;
            }else{
                echo number_format($truncatedTotalAmount,2);
            }
        }
    }
}    

if($totalTableMessage){
    // echo '<table class="table table-hover table-responsive" id="totalPayoutTable">
    //     <thead>
    //         <tr>
    //             <th class="fw-bolder font-size-16">Date</th>
    //             <th class="fw-bolder font-size-16">Payout Details</th>
    //             <th class="fw-bolder font-size-16">Amount</th>
    //             <th class="fw-bolder font-size-16">TDS</th>
    //             <th class="fw-bolder font-size-16">Total Payable</th>
    //             <th class="fw-bolder font-size-16">Remark</th>
    //         </tr>
    //     </thead>
    //     <tbody>';
           
    //         // $model2 = "SELECT * FROM product_payout WHERE YEAR(created_date) = '".$TotalYear."' AND MONTH(created_date) = '".$TotalMonth."' AND status = '1'";
    //         $sql = "SELECT * FROM `product_payout_paid` WHERE YEAR(created_date) = '".$TotalYear."' AND MONTH(created_date) = '".$TotalMonth."'  ";
    //         // $sqlId = "SELECT * FROM product_payout_paid WHERE userID = '".$cap_id."'  order by id DESC";
    //         $stmt = $conn -> prepare($sql);
    //             $stmt -> execute();
    //             $stmt -> setFetchMode(PDO::FETCH_ASSOC);
    //             if( $stmt -> rowCount()>0 ){
    //                 foreach( ($stmt -> fetchALL()) as $key => $row ){

    //                     // date in proper formate
    //                     $dt = new DateTime($row['created_date']);
    //                     $dt = $dt->format('Y-m-d');

    //                     $id = $row['id'];
    //                     echo '<tr>
    //                         <td>'.$dt.'</td>
    //                         <td>'.$row['userID'].' '.$row['userName'].' -> '.$row['message'].' <br/> on selling '.$row['package_name'].' 
    //                                 package .</td>
    //                         <td>'.$row['Commi_amt'].'</td>
    //                         <td>'.$row['Commi_amt_tds'].'</td>
    //                         <td>'.$row['Commi_amt_total'].'</td>
    //                         <td><span class="badge badge-pill badge-soft-success font-size-10 fw-bold ms-4">Paid</span></td>
    //                     </tr>';
    //                 }
    //             }
    //     echo'</tbody>
    // </table>';


    echo'<table class="table table-hover" id="totalPayoutTable">
        <thead>
            <tr>
                <tr>
                    
                    <th class="fw-bolder font-size-16">Date</th>
                    <!--<th class="fw-bolder font-size-16">Pkg ID</th> -->
                    <th class="fw-bolder font-size-16">Payout Details</th>
                    <th class="fw-bolder font-size-16">Amount</th>
                    <th class="fw-bolder font-size-16">TDS</th>
                    <th class="fw-bolder font-size-16">Total Payable</th>
                    <th class="fw-bolder font-size-16">Remark</th>
                </tr>
            </tr>
        </thead>
        <tbody>';
            
            $sql = "SELECT * FROM `product_payout`  WHERE YEAR(created_date) = '".$TotalYear."' AND MONTH(created_date) = '".$TotalMonth."'  ORDER BY `created_date` ASC";
            $stmt = $conn -> prepare($sql);
            $stmt -> execute();
            $stmt -> setFetchMode(PDO::FETCH_ASSOC);
            if( $stmt -> rowCount()>0 ){
                foreach( ($stmt -> fetchALL()) as $key => $row ){

                    // date in proper formate
                    $dt = new DateTime($row['created_date']);
                    $dt = $dt->format('Y-m-d');

                    $ta_markup = $row['ta_markup'] ;
                    $no_of_adult = $row['no_of_adult'] ;
                    $no_of_child = $row['no_of_child'] ;
                    $customer_id = $row['cu_id'] ;

                    $stmt1 = $conn -> prepare(" SELECT name FROM package WHERE id = '".$row['package_id']."' ");
                    $stmt1 -> execute();
                    $pkgName = $stmt1 -> fetch();
                    $packageName = $pkgName['name'];

                    $stmt8 = $conn -> prepare(" SELECT firstname, lastname FROM ca_customer WHERE ca_customer_id = '".$customer_id."' ");
                    $stmt8 -> execute();
                    $cu_name = $stmt8 -> fetch();
                    $cuName = $cu_name['firstname'].' '.$cu_name['lastname'];


                    // ta message
                    $cu3_id = $row['cu3_id'];
                    $cu2_id = $row['cu2_id'];
                    $cu1_id = $row['cu1_id'];
                    $bdm_id = $row['bdm_id'];
                    $bch_id = $row['bch_id'];
                    $ta_id = $row['ta_id'];
                    $ta_mess = $row['ta_mess'];
                    $ta_amt = $row['ta_amt'];
                    $ta_status = $row['ta_status'];
                    $ta_tds = $ta_amt * $tdsPercentage;
                    $ta_total = $ta_amt - $ta_tds;

                    // te message
                    $te_id = $row['te_id'];
                    $te_mess = $row['te_mess'];
                    $te_amt = $row['te_amt'];
                    $te_status = $row['te_status'];
                    $te_tds = $te_amt * $tdsPercentage;
                    $te_total = $te_amt - $te_tds;

                    // bm message
                    $bm_id = $row['bm_id'];
                    $bm_mess = $row['bm_mess'];
                    $bm_amt = $row['bm_amt'];
                    $bm_status = $row['bm_status'];
                    $bm_tds = $bm_amt * $tdsPercentage;
                    $bm_total = $bm_amt - $bm_tds;

                    // bdm message
                    if($bdm_id){
                        // $bdm_id = $row['bdm_id'];
                        $bdm_mess = $row['bdm_mess'];
                        $bdm_amt = $row['bdm_amt'];
                        $bdm_status = $row['bdm_status'];
                        $bdm_tds = $bdm_amt * $tdsPercentage;
                        $bdm_total = $bdm_amt - $bdm_tds;
                    }

                    // bcm message
                    if($bch_id){
                        // $bch_id = $row['bch_id'];
                        $bch_mess = $row['bch_mess'];
                        $bch_amt = $row['bch_amt'];
                        $bch_status = $row['bch_status'];
                        $bch_tds = $bch_amt * $tdsPercentage;
                        $bch_total = $bch_amt - $bch_tds;
                    }

                    // cu1 message
                    if($cu1_id){
                        // $cu1_id = $row['cu1_id'];
                        $cu1_mess = $row['cu1_mess'];
                        $cu1_amt = $row['cu1_amt'];
                        $cu1_status = $row['cu1_status'];
                        $cu1_tds = $cu1_amt * $tdsPercentage;
                        $cu1_total = $cu1_amt - $cu1_tds;
                    }

                    // cu2 message
                    if($cu2_id){
                        // $cu2_id = $row['cu2_id'];
                        $cu2_mess = $row['cu2_mess'];
                        $cu2_amt = $row['cu2_amt'];
                        $cu2_status = $row['cu2_status'];
                        $cu2_tds = $cu2_amt * $tdsPercentage;
                        $cu2_total = $cu2_amt - $cu2_tds;
                    }

                    // cu3 message
                    if($cu3_id){
                        // $cu3_id = $row['cu3_id'];
                        $cu3_mess = $row['cu3_mess'];
                        $cu3_amt = $row['cu3_amt'];
                        $cu3_status = $row['cu3_status'];
                        $cu3_tds = $cu3_amt * $tdsPercentage;
                        $cu3_total = $cu3_amt - $cu3_tds;
                    }

                    if($cu3_id){
                        echo'<tr>
                                
                                <td>'.$dt.'</td>
                                <td>'.$cu3_mess.'<br/> on selling '.$packageName.' package to  Customer ->'.$cuName.'<br/> No of Adult -> '.$no_of_adult.'. No of child ->'. $no_of_child.'</td>
                                <td>'.$cu3_amt.'</td>
                                <td>'.$cu3_tds.'</td>
                                <td>'.$cu3_total.'</td>';
                                if($cu3_status == '1'){
                                    echo'<td><span class="badge badge-pill badge-soft-success font-size-10 fw-bold ms-4">Paid</span></td>';
                                }else{
                                    echo'<td><span class="badge badge-pill badge-soft-warning font-size-10 fw-bold ms-4" data-bs-toggle="modal" data-bs-target=".bs-example-modal-center" onclick=\'paymentId("' .$row['id']. '","' .$row['cu3_id']. '","' .$row['cu3_mess']. '","' .$row['cu3_amt']. '","cu3_status","AllPayoutCaCu3")\'>Pending</span></td>';
                                }
                        echo'</tr>';
                    }

                    if($cu2_id){
                        echo'<tr>
                                
                                <td>'.$dt.'</td>
                                <td>'.$cu2_mess.'<br/> on selling '.$packageName.' package to  Customer ->'.$cuName.'<br/> No of Adult -> '.$no_of_adult.'. No of child ->'. $no_of_child.'</td>
                                <td>'.$cu2_amt.'</td>
                                <td>'.$cu2_tds.'</td>
                                <td>'.$cu2_total.'</td>';
                                if($cu2_status == '1'){
                                    echo'<td><span class="badge badge-pill badge-soft-success font-size-10 fw-bold ms-4">Paid</span></td>';
                                }else{
                                    echo'<td><span class="badge badge-pill badge-soft-warning font-size-10 fw-bold ms-4" data-bs-toggle="modal" data-bs-target=".bs-example-modal-center" onclick=\'paymentId("' .$row['id']. '","' .$row['cu2_id']. '","' .$row['cu2_mess']. '","' .$row['cu2_amt']. '","cu2_status","AllPayoutCaCu2")\'>Pending</span></td>';
                                }
                        echo'</tr>';
                    }

                    if($cu1_id){
                        echo'<tr>
                                
                                <td>'.$dt.'</td>
                                <td>'.$cu1_mess.'<br/> on selling '.$packageName.' package to  Customer ->'.$cuName.'<br/> No of Adult -> '.$no_of_adult.'. No of child ->'. $no_of_child.'</td>
                                <td>'.$cu1_amt.'</td>
                                <td>'.$cu1_tds.'</td>
                                <td>'.$cu1_total.'</td>';
                                if($cu1_status == '1'){
                                    echo'<td><span class="badge badge-pill badge-soft-success font-size-10 fw-bold ms-4">Paid</span></td>';
                                }else{
                                    echo'<td><span class="badge badge-pill badge-soft-warning font-size-10 fw-bold ms-4" data-bs-toggle="modal" data-bs-target=".bs-example-modal-center" onclick=\'paymentId("' .$row['id']. '","' .$row['cu1_id']. '","' .$row['cu1_mess']. '","' .$row['cu1_amt']. '","cu1_status","AllPayoutCaCu1")\'>Pending</span></td>';
                                }
                        echo'</tr>';
                    }

                    echo '<tr>
                            
                            <td>'.$dt.'</td>
                            <td>'.$ta_mess.'<br/> on selling '.$packageName.' package to  Customer ->'.$cuName.'<br/> No of Adult -> '.$no_of_adult.'. No of child ->'. $no_of_child.'</td>
                            <td>'.$ta_amt.'</td>
                            <td>'.$ta_tds.'</td>
                            <td>'.$ta_total.'</td>';
                            if($ta_status == '1'){
                                echo'<td><span class="badge badge-pill badge-soft-success font-size-10 fw-bold ms-4">Paid</span></td>';
                            }else{
                                echo'<td><span class="badge badge-pill badge-soft-warning font-size-10 fw-bold ms-4" data-bs-toggle="modal" data-bs-target=".bs-example-modal-center" onclick=\'paymentId("' .$row['id']. '","' .$row['ta_id']. '","' .$row['ta_mess']. '","' .$row['ta_amt']. '","ta_status","AllPayoutTa")\'>Pending</span></td>';
                            }
                    echo'</tr>';
                    echo'<tr>
                            
                            <td><input id="product_id" type="hidden" value="'.$row['id'].'">'.$dt.'</td>
                            <td>'.$te_mess.'<br/> on selling '.$packageName.' package to  Customer ->'.$cuName.'<br/> No of Adult -> '.$no_of_adult.'. No of child ->'. $no_of_child.'</td>
                            <td>'.$te_amt.'</td>
                            <td>'.$te_tds.'</td>
                            <td>'.$te_total.'</td>';
                            if($te_status == '1'){
                                echo'<td><span class="badge badge-pill badge-soft-success font-size-10 fw-bold ms-4">Paid</span></td>';
                            }else{
                                echo'<td><span class="badge badge-pill badge-soft-warning font-size-10 fw-bold ms-4" data-bs-toggle="modal" data-bs-target=".bs-example-modal-center" onclick=\'paymentId("' .$row['id']. '","' .$row['te_id']. '","' .$row['te_mess']. '","' .$row['te_amt']. '","te_status","AllPayoutTe")\'>Pending</span></td>';
                            }
                    echo'</tr>';
                    echo'<tr>
                            
                            <td>'.$dt.'</td>
                            <td>'.$bm_mess.'<br/> on selling '.$packageName.' package to  Customer ->'.$cuName.'<br/> No of Adult -> '.$no_of_adult.'. No of child ->'. $no_of_child.'</td>
                            <td>'.$bm_amt.'</td>
                            <td>'.$bm_tds.'</td>
                            <td>'.$bm_total.'</td>';
                            if($bm_status == '1'){
                                echo'<td><span class="badge badge-pill badge-soft-success font-size-10 fw-bold ms-4">Paid</span></td>';
                            }else{
                                echo'<td><span class="badge badge-pill badge-soft-warning font-size-10 fw-bold ms-4" data-bs-toggle="modal" data-bs-target=".bs-example-modal-center" onclick=\'paymentId("' .$row['id']. '","' .$row['bm_id']. '","' .$row['bm_mess']. '","' .$row['bm_amt']. '","bm_status","AllPayoutBm")\'>Pending</span></td>';
                            }
                    echo'</tr>';

                    if($row['bdm_id']){
                        echo'<tr>
                                
                                <td>'.$dt.'</td>
                                <td>'.$bdm_mess.'<br/> on selling '.$packageName.' package to  Customer ->'.$cuName.'<br/> No of Adult -> '.$no_of_adult.'. No of child ->'. $no_of_child.'</td>
                                <td>'.$bdm_amt.'</td>
                                <td>'.$bdm_tds.'</td>
                                <td>'.$bdm_total.'</td>';
                                if($bdm_status == '1'){
                                    echo'<td><span class="badge badge-pill badge-soft-success font-size-10 fw-bold ms-4">Paid</span></td>';
                                }else{
                                    echo'<td><span class="badge badge-pill badge-soft-warning font-size-10 fw-bold ms-4" data-bs-toggle="modal" data-bs-target=".bs-example-modal-center" onclick=\'paymentId("' .$row['id']. '","' .$row['bdm_id']. '","' .$row['bdm_mess']. '","' .$row['bdm_amt']. '","bdm_status","AllPayoutBdm")\'>Pending</span></td>';
                                }
                        echo'</tr>';
                    }

                    if($row['bch_id']){
                        echo'<tr>
                                
                                <td>'.$dt.'</td>
                                <td>'.$bch_mess.'<br/> on selling '.$packageName.' package to  Customer ->'.$cuName.'<br/> No of Adult -> '.$no_of_adult.'. No of child ->'. $no_of_child.'</td>
                                <td>'.$bch_amt.'</td>
                                <td>'.$bch_tds.'</td>
                                <td>'.$bch_total.'</td>';
                                if($bch_status == '1'){
                                    echo'<td><span class="badge badge-pill badge-soft-success font-size-10 fw-bold ms-4">Paid</span></td>';
                                }else{
                                    echo'<td><span class="badge badge-pill badge-soft-warning font-size-10 fw-bold ms-4" data-bs-toggle="modal" data-bs-target=".bs-example-modal-center" onclick=\'paymentId("' .$row['id']. '","' .$row['bch_id']. '","' .$row['bch_mess']. '","' .$row['bch_amt']. '","bch_status","AllPayoutBch")\'>Pending</span></td>';
                                }
                        echo'</tr>';
                    }
                    
                    
                }
            }
            
            
        echo'</tbody>
    </table>';
}