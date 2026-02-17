<!-- total payout Model and section amount change and add date to model  -->
<?php
require '../../../connect.php';

$TotalYear = $_POST['TotalYear'];
$TotalMonth = $_POST['TotalMonth'];
$totalAmountMessage = $_POST['totalAmountMessage'] ?? '';
$totalTableMessage = $_POST['totalTableMessage'] ?? '';

if($totalAmountMessage){
    $stmt = " SELECT SUM(total_payable) as TotalPayout FROM ca_ta_payout_paid WHERE YEAR(date) = '".$TotalYear."' AND MONTH(date) = '".$TotalMonth."' ";
    $stmt = $conn -> prepare($stmt);
    $stmt -> execute();
    $stmt -> setFetchMode(PDO::FETCH_ASSOC);
    if($stmt -> rowCount()>0){
        foreach($stmt -> fetchAll() as $key => $row){
            $TotalPayout = $row['TotalPayout'];
            if($TotalPayout == null){
                echo 0;
            }else{
                echo $TotalPayout;
            }
        }
    }
}    

if($totalTableMessage){
    echo '<table class="table table-hover table-responsive" id="totalPayoutTable">
        <thead>
            <tr>
                <th  class="mobile_view">payout_message</th>
                <th >Payout Details</th>
                <th style="text-align:center;" class="mobile_view tab_view">Amount</th>
                <th style="text-align:center;" class="mobile_view" >TDS</th>
                <th style="text-align:center;">Total Payable</th>
                <!-- <th style="text-align:center;">Date</th> -->
            </tr>
        </thead>
        <tbody >';
           
            $model2 = "SELECT * FROM ca_ta_payout_paid WHERE YEAR(date) = '".$TotalYear."' AND MONTH(date) = '".$TotalMonth."'";
            $model2 = $conn -> prepare($model2);
            $model2 -> execute();
            $model2 -> setFetchMode(PDO::FETCH_ASSOC);
            if($model2 -> rowCount()>0){
                foreach($model2 -> fetchAll() as $key => $row){
                    echo'<tr>
                        <td>'.$row['payout_message'].'</td>
                        <td >'.$row['payout_details'].'</td>
                        <td style="text-align:center;">'.$row['amount'].'</td>
                        <td style="text-align:center;">'.$row['tds'].'</td>
                        <td style="text-align:center;">'.$row['total_payable'].'</td>
                    </tr>';
                }
            }else{
                echo '<tr>
                    <td style="display:none;">data</td>
                    <td style="display:none;">data</td>
                    <td style="display:none;">data</td>
                    <td style="display:none;">data</td>
                    <td colspan=7 style="text-align:center;">No data found</td>
                </tr>';
            }
            
            
        echo'</tbody>
    </table>';

}
?>