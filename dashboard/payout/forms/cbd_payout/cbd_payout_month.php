<!-- total payout Model and section amount change and add date to model  -->
<?php
require '../../../connect.php';

$TotalYear = $_POST['TotalYear'];
$TotalMonth = $_POST['TotalMonth'];
$userID = $_POST['userID'];
$totalAmountMessage = $_POST['totalAmountMessage'] ?? '';
$totalTableMessage = $_POST['totalTableMessage'] ?? '';

if($totalAmountMessage){
    $stmt = " SELECT SUM(amount) as TotalPayout FROM cbd_payout WHERE cbd_id = '".$userID."' AND YEAR(created_date) = '".$TotalYear."' AND MONTH(created_date) = '".$TotalMonth."' AND status = '1' ";
    $stmt = $conn -> prepare($stmt);
    $stmt -> execute();
    $stmt -> setFetchMode(PDO::FETCH_ASSOC);
    if($stmt -> rowCount()>0){
        foreach($stmt -> fetchAll() as $key => $row){
            $TotalPayout = $row['TotalPayout'];
            $TotalPayoutTDS = $TotalPayout *5/100;
            $TotalPayable = $TotalPayout - $TotalPayoutTDS;
            if($TotalPayable == null){
                echo 0;
            }else{
                echo round($TotalPayable);
            }
        }
    }
}    

if($totalTableMessage){
    echo '<table class="table table-hover table-responsive" id="totalPayoutTable">
        <thead>
            <tr>
                <th class="mobile_view">Date</th>
                <th >Payout Message</th>
                <th >Payout type</th>
                <th style="text-align:center;" class="mobile_view tab_view">Amount</th>
                <th style="text-align:center;" class="mobile_view" >TDS</th>
                <th style="text-align:center;">Total Payable</th>
              
            </tr>
        </thead>
        <tbody >';
           
            $model2 = "SELECT * FROM cbd_payout WHERE cbd_id = '".$userID."' AND YEAR(created_date) = '".$TotalYear."' AND MONTH(created_date) = '".$TotalMonth."' AND status = '1'";
            $model2 = $conn -> prepare($model2);
            $model2 -> execute();
            $model2 -> setFetchMode(PDO::FETCH_ASSOC);
            if($model2 -> rowCount()>0){
                foreach($model2 -> fetchAll() as $key => $row){

                    // date in proper formate
                    $dt = new DateTime($row['created_date']);
                    $dt = $dt->format('Y-m-d');

                    // replace dot at end of the line with break statement
                    $message = $row['message'];
                    $message =  str_replace('.','<br>',$message);  

                    // $message_details = $row['message_details'];
                    // $message_details =  str_replace('.','<br>',$message_details);  
                    $payout_type = $row['payout_type'];

                    // total Amt Cal for BC 
                    $CommAmt = $row['amount'];
                    $tds = $CommAmt * 5/100;
                    $totalAmt = $CommAmt - $tds;

                    echo'<tr>
                        <td>'.$dt.'</td>
                        <td >'.$message.'</td>
                        <td >'.$payout_type.'</td>
                        <td style="text-align:center;">'.$CommAmt.'</td>
                        <td style="text-align:center;">'.$tds.'</td>
                        <td style="text-align:center;">'.$totalAmt.'</td>
                    </tr>';
                }
            }
        echo'</tbody>
    </table>';

}
?>