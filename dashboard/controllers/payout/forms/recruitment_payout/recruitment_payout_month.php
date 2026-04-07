<!-- total payout Model and section amount change and add date to model  -->
<?php
require '../../../../connect.php';

$TotalYear = $_POST['TotalYear'];
$TotalMonth = $_POST['TotalMonth'];
$totalAmountMessage = $_POST['totalAmountMessage'] ?? '';
$totalTableMessage = $_POST['totalTableMessage'] ?? '';
$designation = $_POST['designation'] ?? '';
$user_id = $_POST['user_id'] ?? '';
$commision = $_POST['Commision'] ?? '';

$user_id_str=substr($user_id,0,1) == 'F'?substr($user_id,0,1):substr($user_id,0,2);
if($user_id_str =='MF' || $user_id_str =='SF' || $user_id_str=='BM' || $user_id_str=='BH' || $user_id_str=='RM'){
    $message = "message_bm";
}else if ($user_id_str =='F' || $user_id_str =='CA' || $user_id_str=='TE'){
    $message = "message_te";
}

if($totalAmountMessage){
    $stmt = " SELECT SUM($commision) as TotalPayout FROM ca_ta_payout WHERE $designation = '".$user_id."' AND YEAR(created_date) = '".$TotalYear."' AND MONTH(created_date) = '".$TotalMonth."' ";
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
                <th  class="mobile_view">ID</th>
                <th style="text-align:center;">Date</th> 
                <th  class="mobile_view">payout_message</th>
                <th style="text-align:center;" class="mobile_view tab_view">Amount</th>
                <th style="text-align:center;" class="mobile_view" >TDS</th>
                <th style="text-align:center;">Total Payable</th>
                <th style="text-align:center;">Remark</th>
            </tr>
        </thead>
        <tbody >';
            //to get all entries paid and pending payout
            $model2 = " SELECT 
                            ca.created_date,
                            ca.status,
                            ca.id,
                            ca.message_bm,
                            ca.message_te,
                            ca.commision_te,
                            ca.commision_bm,
                            cap.status,
                            cap.date AS paydate
                        FROM ca_ta_payout ca
                        LEFT JOIN ca_ta_payout_paid cap ON cap.$designation = ca.$designation AND cap.techno_enterprise = ca.techno_enterprise
                        WHERE ca.$designation = '".$user_id."' 
                        AND YEAR(ca.created_date) = '".$TotalYear."' 
                        AND MONTH(ca.created_date) = '".$TotalMonth."'
                        ";
            $model2 = $conn -> prepare($model2);
            $model2 -> execute();
            $model2 -> setFetchMode(PDO::FETCH_ASSOC);
            if($model2 -> rowCount()>0){
                foreach($model2 -> fetchAll() as $key => $row){

                    // date in proper formate
                    $dt = new DateTime($row['created_date']);
                    $dt = $dt->format('Y-m-d');

                    $Commision = $row[$commision];
                    $CommisionTDS = $Commision * 2/100;
                    $CommisionTotal = $Commision - $CommisionTDS;
                    $status=$row['status'];

                echo'<tr>
                        <td>'.$row['id'].'</td>
                        <td>'.$dt.'</td>
                        <td>'.$row[$message].'</td>
                        <td style="text-align:center;">'.$Commision.'</td>
                        <td style="text-align:center;">'.$CommisionTDS.'</td>
                        <td style="text-align:center;">'.$CommisionTotal.'
                        <a href="payout/forms/recruitment_payout/download_ca_payout.php?vkvbvjfgfikix='.$row['id'].'&designation='.$user_id.'&date='.$dt.'&message='.$row[$message].'&message_status='.$status.'&commission='.$Commision.'&paydate='.$row['paydate'].'">
                                <i class="bx bx-download" style="font-size: 18px; color: black; padding-left: 5px;"></i>
                            </a>
                        </td>';
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