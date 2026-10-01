<!-- total payout Model and section amount change and add date to model  -->
<?php
require '../../../connect.php';

$TotalYear = $_POST['TotalYear'];
$TotalMonth = $_POST['TotalMonth'];
$totalAmountMessage = $_POST['totalAmountMessage'] ?? '';
$totalTableMessage = $_POST['totalTableMessage'] ?? '';

if($totalAmountMessage){

    $sqlIdAmt = "SELECT SUM(comm_amt) as payout FROM `goa_bdm_payout` WHERE YEAR(created_date) = '".$TotalYear."' AND MONTH(created_date) = '".$TotalMonth."'  UNION ALL
                SELECT SUM(comm_amt) as payout FROM `goa_bm_payout` WHERE YEAR(created_date) = '".$TotalYear."' AND MONTH(created_date) = '".$TotalMonth."'  UNION ALL
                SELECT SUM(comm_amt) as payout FROM `ca_payout` WHERE YEAR(created_date) = '".$TotalYear."' AND MONTH(created_date) = '".$TotalMonth."'  UNION ALL
                SELECT SUM(payout_amount) as payout FROM `bm_payout_history` WHERE YEAR(payout_date) = '".$TotalYear."' AND MONTH(payout_date) = '".$TotalMonth."' UNION ALL
                SELECT SUM(cte_amount + ete_amount + ste_amount) as payout FROM `techno_enterprise_payout` WHERE YEAR(created_date) = '".$TotalYear."' AND MONTH(created_date) = '".$TotalMonth."' ";

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
           
            $model_2 = "SELECT id, bdm_id as userId, message, message_details, comm_amt, techno_enterprise, created_date, status, 'goaBdm' as identity FROM `goa_bdm_payout` WHERE YEAR(created_date) = '".$TotalYear."' AND MONTH(created_date) = '".$TotalMonth."'  UNION ALL
                    SELECT id, bm_id as userId, message, message_details, comm_amt, techno_enterprise, created_date, status, 'goaBm' as identity FROM `goa_bm_payout` WHERE YEAR(created_date) = '".$TotalYear."' AND MONTH(created_date) = '".$TotalMonth."'   UNION ALL
                    SELECT id, business_mentor as userId, message, message_details, comm_amt, techno_enterprise, created_date, status, 'caPayout' as identity FROM `ca_payout` WHERE YEAR(created_date) = '".$TotalYear."' AND MONTH(created_date) = '".$TotalMonth."'   UNION ALL
                    SELECT id, bm_user_id as userId, message_bm as message, payment_message as message_details, payout_amount as comm_amt, ca_user_id as techno_enterprise, payout_date as created_date, payout_status as status, 'bmPayoutHistory' as identity FROM `bm_payout_history` WHERE YEAR(payout_date) = '".$TotalYear."' AND MONTH(payout_date) = '".$TotalMonth."'  UNION ALL
                    SELECT id, cte_id as userId, cte_message as message, '' as message_details,  cte_amount as comm_amt, te_id as techno_enterprise, created_date, cte_status as status, 'CTE' as identity FROM `techno_enterprise_payout` WHERE YEAR(created_date) = '".$TotalYear."' AND MONTH(created_date) = '".$TotalMonth."' UNION ALL
                    SELECT id, ete_id as userId, ete_message as message, '' as message_details, ete_amount as comm_amt, te_id as techno_enterprise, created_date, ete_status as status, 'ETE' as identity FROM `techno_enterprise_payout` WHERE YEAR(created_date) = '".$TotalYear."' AND MONTH(created_date) = '".$TotalMonth."' UNION ALL
                    SELECT id, ste_id as userId, ste_message as message, '' as message_details, ste_amount as comm_amt, te_id as techno_enterprise, created_date, ste_status as status, 'STE' as identity FROM `techno_enterprise_payout` WHERE YEAR(created_date) = '".$TotalYear."' AND MONTH(created_date) = '".$TotalMonth."' 
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