<!-- total payout Model and section amount change and add date to model  -->
<?php
require '../../../connect.php';

$TotalYear = $_POST['TotalYear'];
$TotalMonth = $_POST['TotalMonth'];
$totalAmountMessage = $_POST['totalAmountMessage'] ?? '';
$totalTableMessage = $_POST['totalTableMessage'] ?? '';
$designation = $_POST['designation'] ?? '';
$user_id = $_POST['user_id'] ?? '';
$commision = $_POST['Commision'] ?? '';

if($designation == "business_consultant"){
    $message = "message_bc";
}else{
    $message = "message_ca";
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
            </tr>
        </thead>
        <tbody >';
           
            $model2 = "SELECT * FROM ca_ta_payout WHERE $designation = '".$user_id."' AND YEAR(created_date) = '".$TotalYear."' AND MONTH(created_date) = '".$TotalMonth."' ";
            $model2 = $conn -> prepare($model2);
            $model2 -> execute();
            $model2 -> setFetchMode(PDO::FETCH_ASSOC);
            if($model2 -> rowCount()>0){
                foreach($model2 -> fetchAll() as $key => $row){

                    // date in proper formate
                    $dt = new DateTime($row['created_date']);
                    $dt = $dt->format('Y-m-d');

                    $Commision = $row[$commision];
                    $CommisionTDS = $Commision * 5/100;
                    $CommisionTotal = $Commision - $CommisionTDS;

                    echo'<tr>
                        <td>'.$row['id'].'</td>
                        <td>'.$dt.'</td>
                        <td>'.$row[$message].'</td>
                        <td style="text-align:center;">'.$Commision.'</td>
                        <td style="text-align:center;">'.$CommisionTDS.'</td>
                        <td style="text-align:center;">'.$CommisionTotal.'</td>
                    </tr>';
                }
            }
            
            
        echo'</tbody>
    </table>';

}
?>