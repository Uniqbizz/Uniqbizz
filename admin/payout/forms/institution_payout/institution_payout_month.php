<!-- total payout Model and section amount change and add date to model  -->
<?php
require '../../../connect.php';

$TotalYear = $_POST['TotalYear'];
$TotalMonth = $_POST['TotalMonth'];
$totalAmountMessage = $_POST['totalAmountMessage'] ?? '';
$totalTableMessage = $_POST['totalTableMessage'] ?? '';

if($totalAmountMessage){

    $sqlIdAmt = "SELECT SUM(commission_emp+commission_bm_mf_sf) as payout 
                 FROM `institution_payout` 
                 WHERE YEAR(created_date) = '".$TotalYear."' AND MONTH(created_date) = '".$TotalMonth."'";

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
// worked till here
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
           
            $model_2 = "(SELECT s.id, s.employees as userId, s.message_emp as message, sp.payout_details, s.commission_emp as comm_amt, s.institution, s.created_date, s.status, 'employees' as identity 
                        FROM institution_payout s
                        LEFT JOIN institution_payout_paid sp on sp.user_id=s.employees and sp.status='1'
                        WHERE YEAR(s.created_date) = '".$TotalYear."' AND MONTH(s.created_date) = '".$TotalMonth."'   AND (s.employees <> 'NA' AND s.employees <> 'Not Applicable' AND s.employees IS NOT NULL)) 
                        UNION
                        (SELECT s.id, s.bm_mf_sf as userId, s.message_bm_mf_sf as message, sp.payout_details, s.commission_bm_mf_sf as comm_amt, s.institution, s.created_date, s.status, 'bm_mf_sf' as identity 
                        FROM institution_payout s
                        LEFT JOIN institution_payout_paid sp on sp.user_id=s.bm_mf_sf and sp.status='1'
                        WHERE YEAR(s.created_date) = '".$TotalYear."' AND MONTH(s.created_date) = '".$TotalMonth."'   AND (s.bm_mf_sf <> 'NA' AND s.bm_mf_sf <> 'Not Applicable' AND s.bm_mf_sf IS NOT NULL)) 
                        order by created_date desc ";
            $model2 = $conn -> prepare($model_2);
            // print_r($model2);
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

                    $message_details = $row['payout_details'];
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