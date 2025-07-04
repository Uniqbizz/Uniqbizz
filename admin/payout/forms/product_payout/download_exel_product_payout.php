<?php
require '../../../connect.php';
$payoutYear = $_GET['payoutYear'];
$payoutMonth = $_GET['payoutMonth'];
$payoutmessage = $_GET['payoutmessage'];
$designation = $_GET['designation'] ?? '';
$user_id = $_GET['user_id'] ?? '';

if($designation == "business_channel_manager"){
    $userType = '24';
    $userIdCommi = 'bch_id';
}else if($designation == "business_development_manager"){
    $userType = '25';
    $userIdCommi = 'bdm_id';
}else if($designation == "business_mentor"){
    $userType = '26';
    $userIdCommi = 'bm_id';
}else if($designation == "corporate_agency"){
    $userType = '16';
    $userIdCommi = 'te_id';
}else if($designation == "ca_travelagency"){
    $userType = '11';
    $userIdCommi = 'ta_id';
}else if($designation == "ca_customer"){
    $userType = '10';
    $userIdCommi = 'cu1_id';
}

$tdsPercentage = 2/100;

$dateObj   = DateTime::createFromFormat('!m', $payoutMonth);
$monthName = $dateObj->format('F'); 

if($payoutmessage == 'PreviousPayout' || $payoutmessage == 'NextPayout' || $payoutmessage == 'TotalPayout'){
    $output="";
    $sql = "SELECT * FROM product_payout WHERE YEAR(created_date) = '".$payoutYear."' AND MONTH(created_date) = '".$payoutMonth."' ";
    $stmt = $conn -> prepare($sql);
    $stmt -> execute();
    $stmt -> setFetchMode(PDO::FETCH_ASSOC);
    if( $stmt -> rowCount()>0 ){
        if($payoutmessage == 'PreviousPayout'){
            $output .= '<h2 style="text-align:center">Previous Payout List as of '.$monthName.','.$payoutYear.'</h2>';
        }else if($payoutmessage == 'NextPayout'){
            $output .= '<h2 style="text-align:center">Next Payout List as of '.$monthName.','.$payoutYear.'</h2>';
        }else if($payoutmessage == 'TotalPayout'){
            $output .= '<h2 style="text-align:center">Total Payout List as of '.$monthName.','.$payoutYear.'</h2>';
        }
        $output .= '<table border="1" style="text-align:center">
            <tr>
                <th class="fw-bolder font-size-16" style="display: none;">ID</th>
                <th class="fw-bolder font-size-16">Date</th>
                <th class="fw-bolder font-size-16">Payout Details</th>
                <th class="fw-bolder font-size-16">Amount</th>
                <th class="fw-bolder font-size-16">TDS</th>
                <th class="fw-bolder font-size-16">Total Payable</th>
                <th class="fw-bolder font-size-16">Remark</th>
            </tr>';

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

                $cu3_id = $row['cu3_id'];
                $cu2_id = $row['cu2_id'];
                $cu1_id = $row['cu1_id'];
                $bdm_id = $row['bdm_id'];
                $bch_id = $row['bch_id'];

                // ta message
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
                    $output .='<tr>
                            <td style="display: none;">'.$row['id'].'</td>
                            <td>'.$dt.'</td>
                            <td>'.$cu3_mess.'<br/> on selling '.$packageName.' package to  Customer ->'.$cuName.'<br/> No of Adult -> '.$no_of_adult.'. No of child ->'. $no_of_child.'</td>
                            <td>'.$cu3_amt.'</td>
                            <td>'.$cu3_tds.'</td>
                            <td>'.$cu3_total.'</td>';
                            if($cu3_status == '1'){
                                $output .='<td><span class="badge badge-pill badge-soft-success font-size-10 fw-bold ms-4">Paid</span></td>';
                            }else{
                                $output .='<td><span class="badge badge-pill badge-soft-warning font-size-10 fw-bold ms-4" data-bs-toggle="modal" data-bs-target=".bs-example-modal-center" onclick=\'paymentId("' .$row['id']. '","' .$row['cu3_id']. '","' .$row['cu3_mess']. '","' .$row['cu3_amt']. '","cu3_status","AllPayoutCaCu3")\'>Pending</span></td>';
                            }
                    $output .='</tr>';
                }

                if($cu2_id){
                    $output .='<tr>
                            <td style="display: none;">'.$row['id'].'</td>
                            <td>'.$dt.'</td>
                            <td>'.$cu2_mess.'<br/> on selling '.$packageName.' package to  Customer ->'.$cuName.'<br/> No of Adult -> '.$no_of_adult.'. No of child ->'. $no_of_child.'</td>
                            <td>'.$cu2_amt.'</td>
                            <td>'.$cu2_tds.'</td>
                            <td>'.$cu2_total.'</td>';
                            if($cu2_status == '1'){
                                $output .='<td><span class="badge badge-pill badge-soft-success font-size-10 fw-bold ms-4">Paid</span></td>';
                            }else{
                                $output .='<td><span class="badge badge-pill badge-soft-warning font-size-10 fw-bold ms-4" data-bs-toggle="modal" data-bs-target=".bs-example-modal-center" onclick=\'paymentId("' .$row['id']. '","' .$row['cu2_id']. '","' .$row['cu2_mess']. '","' .$row['cu2_amt']. '","cu2_status","AllPayoutCaCu2")\'>Pending</span></td>';
                            }
                    $output .='</tr>';
                }

                if($cu1_id){
                    $output .='<tr>
                            <td style="display: none;">'.$row['id'].'</td>
                            <td>'.$dt.'</td>
                            <td>'.$cu1_mess.'<br/> on selling '.$packageName.' package to  Customer ->'.$cuName.'<br/> No of Adult -> '.$no_of_adult.'. No of child ->'. $no_of_child.'</td>
                            <td>'.$cu1_amt.'</td>
                            <td>'.$cu1_tds.'</td>
                            <td>'.$cu1_total.'</td>';
                            if($cu1_status == '1'){
                                $output .='<td><span class="badge badge-pill badge-soft-success font-size-10 fw-bold ms-4">Paid</span></td>';
                            }else{
                                $output .='<td><span class="badge badge-pill badge-soft-warning font-size-10 fw-bold ms-4" data-bs-toggle="modal" data-bs-target=".bs-example-modal-center" onclick=\'paymentId("' .$row['id']. '","' .$row['cu1_id']. '","' .$row['cu1_mess']. '","' .$row['cu1_amt']. '","cu1_status","AllPayoutCaCu1")\'>Pending</span></td>';
                            }
                    $output .='</tr>';
                }

                $output .= '<tr>
                        <td style="display: none;">'.$row['id'].'</td>
                        <td>'.$dt.'</td>
                        <td>'.$ta_mess.'<br/> on selling '.$packageName.' package to  Customer ->'.$cuName.'<br/> No of Adult -> '.$no_of_adult.'. No of child ->'. $no_of_child.'<br/> Travel Consultant Markup ->Rs. '.$ta_markup.'</td>
                        <td>'.$ta_amt.'</td>
                        <td>'.$ta_tds.'</td>
                        <td>'.$ta_total.'</td>';
                        if($ta_status == '1'){
                            $output .='<td><span class="badge badge-pill badge-soft-success font-size-10 fw-bold ms-4">Paid</span></td>';
                        }else{
                            $output .='<td><span class="badge badge-pill badge-soft-warning font-size-10 fw-bold ms-4" data-bs-toggle="modal" data-bs-target=".bs-example-modal-center" onclick=\'paymentId("' .$row['id']. '","' .$row['ta_id']. '","' .$row['ta_mess']. '","' .$row['ta_amt']. '","ta_status","AllPayoutTa")\'>Pending</span></td>';
                        }
                $output .='</tr>';
                $output .='<tr>
                        <td style="display: none;">'.$row['id'].'</td>
                        <td>'.$dt.'</td>
                        <td>'.$te_mess.'<br/> on selling '.$packageName.' package to  Customer ->'.$cuName.'<br/> No of Adult -> '.$no_of_adult.'. No of child ->'. $no_of_child.'</td>
                        <td>'.$te_amt.'</td>
                        <td>'.$te_tds.'</td>
                        <td>'.$te_total.'</td>';
                        if($te_status == '1'){
                            $output .='<td><span class="badge badge-pill badge-soft-success font-size-10 fw-bold ms-4">Paid</span></td>';
                        }else{
                            $output .='<td><span class="badge badge-pill badge-soft-warning font-size-10 fw-bold ms-4" data-bs-toggle="modal" data-bs-target=".bs-example-modal-center" onclick=\'paymentId("' .$row['id']. '","' .$row['te_id']. '","' .$row['te_mess']. '","' .$row['te_amt']. '","te_status","AllPayoutTe")\'>Pending</span></td>';
                        }
                $output .='</tr>';
                $output .='<tr>
                        <td style="display: none;">'.$row['id'].'</td>
                        <td>'.$dt.'</td>
                        <td>'.$bm_mess.'<br/> on selling '.$packageName.' package to  Customer ->'.$cuName.'<br/> No of Adult -> '.$no_of_adult.'. No of child ->'. $no_of_child.'</td>
                        <td>'.$bm_amt.'</td>
                        <td>'.$bm_tds.'</td>
                        <td>'.$bm_total.'</td>';
                        if($bm_status == '1'){
                            $output .='<td><span class="badge badge-pill badge-soft-success font-size-10 fw-bold ms-4">Paid</span></td>';
                        }else{
                            $output .='<td><span class="badge badge-pill badge-soft-warning font-size-10 fw-bold ms-4" data-bs-toggle="modal" data-bs-target=".bs-example-modal-center" onclick=\'paymentId("' .$row['id']. '","' .$row['bm_id']. '","' .$row['bm_mess']. '","' .$row['bm_amt']. '","bm_status","AllPayoutBm")\'>Pending</span></td>';
                        }
                $output .='</tr>';

                if($row['bdm_id']){
                    $output .='<tr>
                            <td style="display: none;">'.$row['id'].'</td>
                            <td>'.$dt.'</td>
                            <td>'.$bdm_mess.'<br/> on selling '.$packageName.' package to  Customer ->'.$cuName.'<br/> No of Adult -> '.$no_of_adult.'. No of child ->'. $no_of_child.'</td>
                            <td>'.$bdm_amt.'</td>
                            <td>'.$bdm_tds.'</td>
                            <td>'.$bdm_total.'</td>';
                            if($bdm_status == '1'){
                                $output .='<td><span class="badge badge-pill badge-soft-success font-size-10 fw-bold ms-4">Paid</span></td>';
                            }else{
                                $output .='<td><span class="badge badge-pill badge-soft-warning font-size-10 fw-bold ms-4" data-bs-toggle="modal" data-bs-target=".bs-example-modal-center" onclick=\'paymentId("' .$row['id']. '","' .$row['bdm_id']. '","' .$row['bdm_mess']. '","' .$row['bdm_amt']. '","bdm_status","AllPayoutBdm")\'>Pending</span></td>';
                            }
                    $output .='</tr>';
                }

                if($row['bch_id']){
                    $output .='<tr>
                            <td style="display: none;">'.$row['id'].'</td>
                            <td>'.$dt.'</td>
                            <td>'.$bch_mess.'<br/> on selling '.$packageName.' package to  Customer ->'.$cuName.'<br/> No of Adult -> '.$no_of_adult.'. No of child ->'. $no_of_child.'</td>
                            <td>'.$bch_amt.'</td>
                            <td>'.$bch_tds.'</td>
                            <td>'.$bch_total.'</td>';
                            if($bch_status == '1'){
                                $output .='<td><span class="badge badge-pill badge-soft-success font-size-10 fw-bold ms-4">Paid</span></td>';
                            }else{
                                $output .='<td><span class="badge badge-pill badge-soft-warning font-size-10 fw-bold ms-4" data-bs-toggle="modal" data-bs-target=".bs-example-modal-center" onclick=\'paymentId("' .$row['id']. '","' .$row['bch_id']. '","' .$row['bch_mess']. '","' .$row['bch_amt']. '","bch_status","AllPayoutBch")\'>Pending</span></td>';
                            }
                    $output .='</tr>';
                }
                
                
            }
        $output .= '</table>';
        header("Content-Type: application/xls");
        if($payoutmessage == 'PreviousPayout'){
            header("Content-Disposition: attachment;filename=Previous_Product_Payout_List.xls");
        }else if($payoutmessage == 'NextPayout'){
            header("Content-Disposition: attachment;filename=Next_Payout_List.xls");
        }else if($payoutmessage == 'TotalPayout'){
            header("Content-Disposition: attachment;filename=Total_Payout_List.xls");
        } 
        echo $output;
    }else{
        echo 'No Previous Payout Data';                                                    
    }
}

if($payoutmessage == 'allPayout'){
    $output="";
    $model2 = "SELECT * FROM product_payout WHERE $userIdCommi = '".$user_id."' AND YEAR(created_date) = '".$payoutYear."' AND MONTH(created_date) = '".$payoutMonth."' ";
    $model2 = $conn -> prepare($model2);
    $model2 -> execute();
    $model2 -> setFetchMode(PDO::FETCH_ASSOC);
    if($model2 -> rowCount()>0){
        $output .= '<h2 style="text-align:center">All Payout List as of '.$monthName.','.$payoutYear.'</h2>';
        $output .=  '<table border="1" style="text-align:center">
            <tr>
                <th class="fw-bolder font-size-16">Date</th>
                <th class="fw-bolder font-size-16">Payout Details</th>';
                if($userType == '11'){ 
                    $output .= '<th class="fw-bolder font-size-16">Markup</th>';
                }
                $output .= '<th class="fw-bolder font-size-16">Total </th>
                <th class="fw-bolder font-size-16">TDS</th>
                <th class="fw-bolder font-size-16">Total Payable</th>
                <th class="fw-bolder font-size-16">Remark</th>
            </tr>';
                foreach($model2 -> fetchAll() as $key => $row){

                    if($userType == '10'){
                        $id = $row['cu1_id'];
                        $ta_markup = $row['cu1_markup'];
                        $message = $row['cu1_mess'];
                        $amt = $row['cu1_amt'];
                        $status = $row['cu1_status'];
                        $tds = $amt * $tdsPercentage;
                        $total = $amt - $tds;
                    }else if($userType == '11'){
                        $id = $row['ta_id'];
                        $ta_markup = $row['ta_markup'];
                        $message = $row['ta_mess'];
                        $amt = $row['ta_amt'];
                        $status = $row['ta_status'];
                        $tds = $amt * $tdsPercentage;
                        $total = $amt - $tds;
                    }else if($userType == '16'){
                        $id = $row['te_id'];
                        $message = $row['te_mess'];
                        $amt = $row['te_amt'];
                        $status = $row['te_status'];
                        $tds = $amt * $tdsPercentage;
                        $total = $amt - $tds;
                    }else if($userType == '24'){
                        $id = $row['bch_id'];
                        $message = $row['bch_mess'];
                        $amt = $row['bch_amt'];
                        $status = $row['bch_status'];
                        $tds = $amt * $tdsPercentage;
                        $total = $amt - $tds;
                    }else if($userType == '25'){
                        $id = $row['bdm_id'];
                        $message = $row['bdm_mess'];
                        $amt = $row['bdm_amt'];
                        $status = $row['bdm_status'];
                        $tds = $amt * $tdsPercentage;
                        $total = $amt - $tds;
                    }else if($userType == '26'){
                        $id = $row['bm_id'];
                        $message = $row['bm_mess'];
                        $amt = $row['bm_amt'];
                        $status = $row['bm_status'];
                        $tds = $amt * $tdsPercentage;
                        $total = $amt - $tds;
                    }

                    // date in proper formate
                    $dt = new DateTime($row['created_date']);
                    $dt = $dt->format('Y-m-d');

                    // replace dot at end of the line with break statement
                    $stmt1 = $conn -> prepare(" SELECT name FROM package WHERE id = '".$row['package_id']."' ");
                    $stmt1 -> execute();
                    $pkgName = $stmt1 -> fetch();
                    $packageName = $pkgName['name'];
                    
                    //get customer Name
                    $stmt8 = $conn -> prepare(" SELECT firstname, lastname FROM ca_customer WHERE ca_customer_id = '".$row['cu_id']."' ");
                    $stmt8 -> execute();
                    $cu_name = $stmt8 -> fetch();
                    $cuName = $cu_name['firstname'].' '.$cu_name['lastname']; 

                    $no_of_adult = $row['no_of_adult'] ;
                    $no_of_child = $row['no_of_child'] ;

                    $output .=  '<tr>
                            <td>'.$dt.'</td>';
                            if($userType == '11'){
                                $output .= '<td>'.$message.' <br/> on selling '.$packageName.' Package to '.$cuName.'<br/> No of Adult -> '.$no_of_adult.'. No of child ->'. $no_of_child.'<br> Markup Price -> Rs '.$ta_markup.'</td>
                                <td >'.$ta_markup.'</td>';
                            }else{
                                $output .=  '<td>'.$message.' <br/> on selling '.$packageName.' Package to '.$cuName.'<br/> No of Adult -> '.$no_of_adult.'. No of child ->'. $no_of_child.'</td>';
                            }
                            $output .= '
                            <td >'.$amt.'</td>
                            <td >'.$tds.'</td>
                            <td >'.$total.'</td>';
                            if($status == '1'){
                                $output .= '<td><span class="badge bg-success fw-bold ms-4">Paid</span></td>';
                            }else{
                                $output .= '<td><span class="badge bg-warning fw-bold ms-4">Pending</span></td>';
                            }
                    $output .= '</tr>';
                }
            }
        $output .= '</tbody>';
        $output .= '</table>';
        header("Content-Type: application/xls");
        header("Content-Disposition: attachment;filename=All_Payout_List.xls");
        echo $output;
    }else{
        echo 'No All Payout Data';                                                    
    }


// if($payoutmessage == 'TotalPayout'){
    
//     $stmt = " SELECT * FROM product_payout_paid WHERE YEAR(created_date) = '".$payoutYear."' AND MONTH(created_date) = '".$payoutMonth."' ";
//     $output="";
//     $stmt = $conn -> prepare($stmt);
//     $stmt -> execute();
//     $stmt ->setFetchMode(PDO::FETCH_ASSOC);
//     if($stmt -> rowCount()>0){
//     	$output .= '<h2 style="text-align:center">All Payout List as of '.$monthName.','.$payoutYear.'</h2>
//         <table border="1" style="text-align:center">
//             <tr>
//                 <th class="fw-bolder font-size-16">Date</th>
//                 <th class="fw-bolder font-size-16">Payout Details</th>
//                 <th class="fw-bolder font-size-16">Amount</th>
//                 <th class="fw-bolder font-size-16">TDS</th>
//                 <th class="fw-bolder font-size-16">Total Payable</th>
//                 <th class="fw-bolder font-size-16">Remark</th>
//             </tr>';
//             foreach($stmt->fetchAll() as $key => $row){

//                 // date in proper formate
//                 $dt = new DateTime($row['created_date']);
//                 $dt = $dt->format('Y-m-d');
                
//                 $output .='<tr>
//                     <td>'.$dt.'</td>
//                     <td>'.$row['userID'].' '.$row['userName'].' -> '.$row['message'].' <br/> on selling '.$row['package_name'].' 
//                             package .</td>
//                     <td>'.$row['Commi_amt'].'</td>
//                     <td>'.$row['Commi_amt_tds'].'</td>
//                     <td>'.$row['Commi_amt_total'].'</td>
//                     <td><span class="badge badge-pill badge-soft-success font-size-10 fw-bold ms-4">Paid</span></td>
//                 </tr>';
               
//             }
//         $output .= '</table>';
//         header("Content-Type: application/xls");
//         header("Content-Disposition: attachment;filename=Total_Payout_List.xls");
//         echo $output;
//     }else{
//         echo 'No All Payout Data';                                                    
//     }
// }
    
?>