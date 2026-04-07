<!-- total payout Model and section amount change and add date to model  -->
<?php
require '../../../../connect.php';

$TotalYear = $_POST['TotalYear'];
$TotalMonth = $_POST['TotalMonth'];
$totalAmountMessage = $_POST['totalAmountMessage'] ?? '';
$totalTableMessage = $_POST['totalTableMessage'] ?? '';
$tdsper=0.02;

if($totalAmountMessage){

    $sqlIdAmt = "SELECT SUM(referral_amount) as payout FROM `customer_reference_payout` WHERE YEAR(created_date) = '".$TotalYear."' AND MONTH(created_date) = '".$TotalMonth."' AND status = '1' ";

    $stmt = $conn->prepare($sqlIdAmt);
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $totalPayout = 0;
    while ($row = $stmt->fetch()) {
        $totalPayout += $row['payout'] ?? 0;
    }

    if ($totalPayout > 0) {
        $tds = $totalPayout * $tdsper; //tds
        $TotalPayout = $totalPayout - $tds;
        echo $TotalPayout;
    }else{
        echo 0;
    }

}    

if($totalTableMessage){
    echo '<table class="table table-hover table-responsive" id="totalPayoutTable">
        <thead>
            <tr>
                <th class="mobile_view">Date</th>
                <th >Payout Message</th>
                <th >Payout Details</th>
                <th style="text-align:center;" class="mobile_view tab_view">Amount</th>
                <th style="text-align:center;" class="mobile_view" >TDS</th>
                <th style="text-align:center;">Total Payable</th>
              
            </tr>
        </thead>
        <tbody >';
           
            $model_2 = "SELECT id, customer_id as userId, referral_message as message1,booking_message as message2, referral_amount as comm_amt1,booking_points as comm_amt2, created_date, status FROM `customer_reference_payout` WHERE YEAR(created_date) = '".$TotalYear."' AND MONTH(created_date) = '".$TotalMonth."'  AND status = '1'
                    order by created_date desc ";
            $model2 = $conn -> prepare($model_2);
            $model2 -> execute();
            $model2 -> setFetchMode(PDO::FETCH_ASSOC);
            if($model2 -> rowCount()>0){
                foreach($model2 -> fetchAll() as $key => $row){

                    // date in proper formate
                    $dt = new DateTime($row['created_date']);
                    $dt = $dt->format('Y-m-d');

                    // replace dot at end of the line with break statement
                    $message = $row['message1']?$row['message1']:$row['message2'];
                    $message =  str_replace('.','<br>',$message);  

                    $message_details = $row['message_details']??'NA';
                    $message_details =  str_replace('.','<br>',$message_details);  

                    // total Amt Cal for BC 
                    $CommAmt = $row['comm_amt1']?$row['comm_amt1']:$row['comm_amt2'];
                    $tds = $CommAmt * $tdsper;
                    $totalAmt = $CommAmt - $tds;

                    echo'<tr>
                        <td>'.$dt.'</td>
                        <td >'.$message.'</td>
                        <td >'.$message_details.'</td>
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