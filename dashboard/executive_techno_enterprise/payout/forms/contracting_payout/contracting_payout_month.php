<!-- total payout Model and section amount change and add date to model  -->
<?php
    require '../../../../connect.php';

    $TotalYear = $_POST['TotalYear'];
    $TotalMonth = $_POST['TotalMonth'];
    $userID = $_POST['userID'];
    $totalAmountMessage = $_POST['totalAmountMessage'] ?? '';
    $totalTableMessage = $_POST['totalTableMessage'] ?? '';

    if($totalAmountMessage){
        $stmt = " SELECT SUM(ete_amount) as TotalPayout FROM techno_enterprise_payout WHERE ete_id = '".$userID."' AND YEAR(created_date) = '".$TotalYear."' AND MONTH(created_date) = '".$TotalMonth."' ";
        $stmt = $conn -> prepare($stmt);
        $stmt -> execute();
        $stmt -> setFetchMode(PDO::FETCH_ASSOC);
        if($stmt -> rowCount()>0){
            foreach($stmt -> fetchAll() as $key => $row){
                $TotalPayout = $row['TotalPayout'];
                if($TotalPayout == null){
                    echo 0;
                }else{
                    $tds = $TotalPayout* 2/100;
                    $TotalPayout = $TotalPayout - $tds;
                    echo $TotalPayout;
                }
            }
        }
    }    

    if($totalTableMessage){
        echo '<table class="table table-hover table-responsive" id="totalPayoutTable">
            <thead>
                <tr>
                    <th class="mobile_view">Date</th>
                    <th >Payout Details</th>
                    <th style="text-align:center;" class="mobile_view tab_view">Amount</th>
                    <th style="text-align:center;" class="mobile_view" >TDS</th>
                    <th style="text-align:center;">Total Payable</th>
                    <th style="text-align:center;">Status</th>
                
                </tr>
            </thead>
            <tbody >';
            
                $model2 = "SELECT * FROM techno_enterprise_payout WHERE ete_id = '".$userID."' AND YEAR(created_date) = '".$TotalYear."' AND MONTH(created_date) = '".$TotalMonth."'";
                $model2 = $conn -> prepare($model2);
                $model2 -> execute();
                $model2 -> setFetchMode(PDO::FETCH_ASSOC);
                if($model2 -> rowCount()>0){
                    foreach($model2 -> fetchAll() as $key => $row){

                        // date in proper formate
                        $dt = new DateTime($row['created_date']);
                        $dt = $dt->format('Y-m-d');

                        // replace dot at end of the line with break statement
                        $message = $row['ete_message'];
                        $message =  str_replace('.','<br>',$message);  

                        // total Amt Cal for BC 
                        $CommAmt = $row['ete_amount'];
                        $tds = $CommAmt * 2/100;
                        $totalAmt = $CommAmt - $tds;

                        echo'<tr>
                            <td>'.$dt.'</td>
                            <td >'.$message.'</td>
                            <td style="text-align:center;">'.$CommAmt.'</td>
                            <td style="text-align:center;">'.$tds.'</td>
                            <td style="text-align:center;">'.$totalAmt.'
                            <a href="payout/forms/contracting_payout/download_ca_payout.php?vkvbvjfgfikix='.$row['id'].'&bc='.$row['ete_id'].'&ca='.$row['te_id'].'&date='.$dt.'&message='.$message.'&message_status='.$row['status'].'&commission='.$row['ete_amount'].'">
                                <i class="bx bx-download" style="font-size: 18px; color: black; padding-left: 5px;"></i>
                            </a>
                            </td>';
                            if($row['status'] == '1'){
                                echo'<td><span class="badge bg-success font-size-10 fw-bold ms-4">Paid</span></td>';
                            }else{
                                echo'<td><span class="badge bg-warning font-size-10 fw-bold ms-4">Pending</span></td>';
                            }
                        echo '</tr>';
                    }
                }
            echo'</tbody>
        </table>';

    }
?>