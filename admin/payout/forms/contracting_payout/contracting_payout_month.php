<!-- total payout Model and section amount change and add date to model  -->
<?php
require '../../../connect.php';

$TotalYear = $_POST['TotalYear'];
$TotalMonth = $_POST['TotalMonth'];
$totalAmountMessage = $_POST['totalAmountMessage'] ?? '';
$totalTableMessage = $_POST['totalTableMessage'] ?? '';

if($totalAmountMessage){

    $sqlIdAmt = "SELECT SUM(comm_amt) as payout FROM `goa_bdm_payout` WHERE YEAR(created_date) = '".$TotalYear."' AND MONTH(created_date) = '".$TotalMonth."' AND status = '1' UNION ALL
                SELECT SUM(comm_amt) as payout FROM `goa_bm_payout` WHERE YEAR(created_date) = '".$TotalYear."' AND MONTH(created_date) = '".$TotalMonth."' AND status = '1' UNION ALL
                SELECT SUM(comm_amt) as payout FROM `ca_payout` WHERE YEAR(created_date) = '".$TotalYear."' AND MONTH(created_date) = '".$TotalMonth."' AND status = '1' UNION ALL
                SELECT SUM(payout_amount) as payout FROM `bm_payout_history` WHERE YEAR(payout_date) = '".$TotalYear."' AND MONTH(payout_date) = '".$TotalMonth."' AND payout_status = '1' ";

    $stmt = $conn->prepare($sqlIdAmt);
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $totalPayout = 0;
    while ($row = $stmt->fetch()) {
        $totalPayout += $row['payout'] ?? 0;
    }

    if ($totalPayout > 0) {
        $tds = $totalPayout * 0.02; //tds
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
           
            $model_2 = "SELECT id, bdm_id as userId, message, message_details, comm_amt, techno_enterprise, created_date, status, 'goaBdm' as identity FROM `goa_bdm_payout` WHERE YEAR(created_date) = '".$TotalYear."' AND MONTH(created_date) = '".$TotalMonth."'   AND status = '1' UNION ALL
                    SELECT id, bm_id as userId, message, message_details, comm_amt, techno_enterprise, created_date, status, 'goaBm' as identity FROM `goa_bm_payout` WHERE YEAR(created_date) = '".$TotalYear."' AND MONTH(created_date) = '".$TotalMonth."'   AND status = '1' UNION ALL
                    SELECT id, business_mentor as userId, message, message_details, comm_amt, techno_enterprise, created_date, status, 'caPayout' as identity FROM `ca_payout` WHERE YEAR(created_date) = '".$TotalYear."' AND MONTH(created_date) = '".$TotalMonth."'   AND status = '1' UNION ALL
                    SELECT id, bm_user_id as userId, message_bm as message, payment_message as message_details, payout_amount as comm_amt, ca_user_id as techno_enterprise, payout_date as created_date, payout_status as status, 'bmPayoutHistory' as identity FROM `bm_payout_history` WHERE YEAR(payout_date) = '".$TotalYear."' AND MONTH(payout_date) = '".$TotalMonth."'  AND payout_status = '1'
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
                    $message = $row['message'];
                    $message =  str_replace('.','<br>',$message);  

                    $message_details = $row['message_details'];
                    $message_details =  str_replace('.','<br>',$message_details);  

                    // total Amt Cal for BC 
                    $CommAmt = $row['comm_amt'];
                    $tds = $CommAmt * 2/100;
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