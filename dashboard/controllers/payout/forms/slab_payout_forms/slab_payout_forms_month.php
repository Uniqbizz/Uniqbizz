<!-- total payout Model and section amount change and add date to model  -->
<?php
require '../../../connect.php';

$TotalYear = $_POST['TotalYear'];
$TotalMonth = $_POST['TotalMonth'];
$userID = $_POST['userID'];
$totalAmountMessage = $_POST['totalAmountMessage'] ?? '';
$totalTableMessage = $_POST['totalTableMessage'] ?? '';
$tds_percentage = 2 / 100;

if($totalAmountMessage){
    $stmt = " SELECT SUM(payout_amount) as TotalPayout FROM bm_payout_history WHERE bm_user_id = '".$userID."' AND YEAR(payout_date) = '".$TotalYear."' AND MONTH(payout_date) = '".$TotalMonth."'  ";
    $stmt = $conn -> prepare($stmt);
    $stmt -> execute();
    $stmt -> setFetchMode(PDO::FETCH_ASSOC);
    if($stmt -> rowCount()>0){
        foreach($stmt -> fetchAll() as $key => $row){
            // total Amt Cal for BM 
            $CommAmt = $row['TotalPayout'];
            $tds = $CommAmt * $tds_percentage;
            $TotalPayout = $CommAmt - $tds;
            if($TotalPayout == null){
                echo 0;
            }else{
                $truncatedTotalPayable = floor($TotalPayout * 100) / 100;
                echo number_format($truncatedTotalPayable,2);
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
                <th style="text-align:center;" class="mobile_view tab_view">Amount</th>
                <th style="text-align:center;" class="mobile_view" >TDS</th>
                <th style="text-align:center;">Total Payable</th>
              
            </tr>
        </thead>
        <tbody >';
           
            $model2 = "SELECT * FROM bm_payout_history WHERE bm_user_id = '".$userID."' AND YEAR(payout_date) = '".$TotalYear."' AND MONTH(payout_date) = '".$TotalMonth."' ";
            $model2 = $conn -> prepare($model2);
            $model2 -> execute();
            $model2 -> setFetchMode(PDO::FETCH_ASSOC);
            if($model2 -> rowCount()>0){
                foreach($model2 -> fetchAll() as $key => $row){

                    // date in proper formate
                    $dt = new DateTime($row['payout_date']);
                    $dt = $dt->format('Y-m-d');

                    // replace dot at end of the line with break statement
                    $message = $row['message_bm'];
                    
                    // total Amt Cal for BC 
                    $CommAmt = $row['payout_amount'];
                    $tds = $CommAmt * $tds_percentage;
                    $totalAmt = $CommAmt - $tds;

                    echo'<tr>
                        <td>'.$dt.'</td>
                        <td >'.$message.'</td>
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