<!-- total payout Model and section amount change and add date to model  -->
<?php
require '../../../connect.php';

$TotalYear = $_POST['TotalYear'];
$TotalMonth = $_POST['TotalMonth'];
$userID = $_POST['userID'];
$userType = $_POST['userType'];
$totalAmountMessage = $_POST['totalAmountMessage'] ?? '';
$totalTableMessage = $_POST['totalTableMessage'] ?? '';
$tdsPercentage=2/100;

if($userType == '11'){ //travel_consultant
    $userIdCommi = 'ta_id';
    $amtCal = 'ta_markup + ta_amt';
}elseif($userType == '16'){ //Techno Enterprise/ corporate agency
    $userIdCommi = 'te_id';
    $amtCal = 'te_amt';
}elseif($userType == '10'){ //customer
    $userIdCommi = 'cu1_id';
    $amtCal = 'cu1_amt';
}elseif($userType == '26'){//business Mentor
    $userIdCommi = 'bm_id';
    $amtCal = 'bm_amt';
}elseif($userType == '25'){// business Development manager
    $userIdCommi = 'bdm_id';
    $amtCal = 'bdm_amt';
}elseif($userType == '24'){ // business channel manager
    $userIdCommi = 'bch_id';
    $amtCal = 'bch_amt';
}

if($totalAmountMessage){
    $stmt = " SELECT SUM($amtCal) as TotalPayout FROM product_payout WHERE $userIdCommi = '".$userID."' AND YEAR(created_date) = '".$TotalYear."' AND MONTH(created_date) = '".$TotalMonth."'  ";
    $stmt = $conn -> prepare($stmt);
    $stmt -> execute();
    $stmt -> setFetchMode(PDO::FETCH_ASSOC);
    if($stmt -> rowCount()>0){
        foreach($stmt -> fetchAll() as $key => $row){
            $TotalPayout = $row['TotalPayout'];
            $totalPayoutTDS = $TotalPayout  * $tdsPercentage;
            $TotalPayoutFinal = $TotalPayout  - $totalPayoutTDS;
            $truncatedTotalAmount = floor($TotalPayoutFinal * 100) / 100;
            if($truncatedTotalAmount == null){
                echo 0;
            }else{
                echo number_format($truncatedTotalAmount,2);
            }
        }
    }
}    

if($totalTableMessage){
    echo '<table class="table table-hover table-responsive" id="totalPayoutTable">
        <thead>
            <tr>
                <th class="ceterText fw-bolder sub-title">Date</th>
                <th class="ceterText fw-bolder sub-title">Payout Details</th>';
                if($userType == '11'){ 
                    echo'<th class="ceterText fw-bolder sub-title">Markup</th>';
                }
                echo'<th class="ceterText fw-bolder sub-title">Total </th>
                <th class="ceterText fw-bolder sub-title">TDS</th>
                <th class="ceterText fw-bolder sub-title">Total Payable</th>
                <th class="ceterText fw-bolder sub-title">Remark</th>
            </tr>
        </thead>
        <tbody >';
           
            $model2 = "SELECT * FROM product_payout WHERE $userIdCommi = '".$userID."' AND YEAR(created_date) = '".$TotalYear."' AND MONTH(created_date) = '".$TotalMonth."' ";
            $model2 = $conn -> prepare($model2);
            $model2 -> execute();
            $model2 -> setFetchMode(PDO::FETCH_ASSOC);
            if($model2 -> rowCount()>0){
                foreach($model2 -> fetchAll() as $key => $row){

                    if($userType == '10'){
                        $cu1 = $row['ca_cu1_id'];
                        $cu2 = $row['ca_cu2_id'];
                        $cu3 = $row['ca_cu3_id'];
                        if($cu1 == $userId){
                            $message1 = $row['ca_cu1_message'];
                            $message1 =  str_replace('.','<br>',$message1);  
                            $CommAmt = $row['ca_cu1_amt'];// total Amt Cal for BC 
                            $ta_markup = '0' ;
                            $status = $row['ca_cu1_status'];
                        }else if($cu2 == $userId){
                            $message1 = $row['ca_cu2_message'];
                            $message1 =  str_replace('.','<br>',$message1);  
                            $CommAmt = $row['ca_cu2_amt'];// total Amt Cal for BC 
                            $ta_markup = '0' ;
                            $status = $row['ca_cu2_status'];
                        }else{
                            $message1 = $row['ca_cu3_message'];
                            $message1 =  str_replace('.','<br>',$message1);  
                            $CommAmt = $row['ca_cu3_amt'];// total Amt Cal for BC 
                            $ta_markup = '0' ;
                            $status = $row['ca_cu3_status'];
                        }
                        
                        $markup_adult = $ta_markup * $no_of_adult;
                        $markup_child = $ta_markup * $no_of_child;
                        $total_markup = $markup_adult + $markup_child;
                        
                        $CommAmt_adult = $CommAmt * $no_of_adult;
                        $CommAmt_child = $CommAmt * $no_of_child;
                        $total_CommAmt = $CommAmt_adult + $CommAmt_child;

                        $totalAmt = $total_markup + $total_CommAmt;
                        $TdsAmt = $totalAmt * $tdsPercentage;

                        $totalPayable = $totalAmt - $TdsAmt ;
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

                    echo '<tr>
                            <td>'.$dt.'</td>';
                            if($userType == '11'){
                                echo'<td>'.$message.' <br/> on selling '.$packageName.' Package to '.$cuName.'<br/> No of Adult -> '.$no_of_adult.'. No of child ->'. $no_of_child.'<br> Markup Price -> Rs '.$ta_markup.'</td>
                                <td >'.$ta_markup.'</td>';
                            }else{
                                echo '<td>'.$message.' <br/> on selling '.$packageName.' Package to '.$cuName.'<br/> No of Adult -> '.$no_of_adult.'. No of child ->'. $no_of_child.'</td>';
                            }
                            echo'
                            <td >'.$amt.'</td>
                            <td >'.$tds.'</td>
                            <td >'.$total.'</td>';
                            if($status == '1'){
                                echo'<td><span class="badge bg-success fw-bold ms-4">Paid</span></td>';
                            }else{
                                echo'<td><span class="badge bg-warning fw-bold ms-4">Pending</span></td>';
                            }
                    echo'</tr>';
                }
            }
        echo'</tbody>
    </table>';

}
?>