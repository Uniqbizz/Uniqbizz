<!-- total payout Model and section amount change and add date to model  -->
<?php
require '../../../../connect.php';

$TotalYear = $_POST['TotalYear'];
$TotalMonth = $_POST['TotalMonth'];
$userID = $_POST['userID'];
$userType = $_POST['userType'];
$totalAmountMessage = $_POST['totalAmountMessage'] ?? '';
$totalTableMessage = $_POST['totalTableMessage'] ?? '';
$tdsPercentage=2/100;

if($userType =='28' || $userType == '30' || $userType == '35'){//MF/SF
    $userIdCommi = 'master_franchisee';
    $amtCal = 'commission_mf';
}
$columnDesignation = $userType == '28'?'master_franchisee':($userType == '30'?'sponsor_franchisee':($userType == '35' ? 'super_techno_enterprise':''));
if($totalAmountMessage){
    $stmt = " SELECT SUM($amtCal) as TotalPayout FROM sub_franchisee_payout WHERE $userIdCommi = '".$userID."' AND YEAR(created_date) = '".$TotalYear."' AND MONTH(created_date) = '".$TotalMonth."'  ";
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
                <th class="ceterText fw-bolder sub-title">Payout Details</th>
                <th class="ceterText fw-bolder sub-title">Total </th>
                <th class="ceterText fw-bolder sub-title">TDS</th>
                <th class="ceterText fw-bolder sub-title">Total Payable</th>
                <th class="ceterText fw-bolder sub-title">Remark</th>
            </tr>
        </thead>
        <tbody >';
           
            $model2 = "SELECT * FROM sub_franchisee_payout WHERE $userIdCommi = '".$userID."' AND YEAR(created_date) = '".$TotalYear."' AND MONTH(created_date) = '".$TotalMonth."' ";
            $model2 = $conn -> prepare($model2);
            $model2 -> execute();
            $model2 -> setFetchMode(PDO::FETCH_ASSOC);
            if($model2 -> rowCount()>0){
                foreach($model2 -> fetchAll() as $key => $row){

                    if($userType == '28' || $userType =='30' || $userType == '35'){
                        $id = $row['master_franchisee'];
                        $message = $row['message_mf'];
                        $amt = $row['commission_mf'];
                        $status = $row['status_mf'];
                        $tds = $amt * $tdsPercentage;
                        $total = $amt - $tds;
                    }

                    // date in proper formate
                    $dt = new DateTime($row['created_date']);
                    $dt = $dt->format('Y-m-d');
                    echo '<tr>
                            <td>'.$dt.'</td>
                            <td>'.$message.'</td>
                            <td >'.$amt.'</td>
                            <td >'.$tds.'</td>
                            <td >'.$total.'
                            <a href="payout/forms/sub_franchisee_payout/download_ca_payout.php?vkvbvjfgfikix='.$row['id'].'&bc='.$id.'&ca='.$row['sub_franchisee'].'&designation='.$columnDesignation.'&date='.$dt.'&message='.$message.'&message_status='.$status.'&commission='.$amt.'">
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