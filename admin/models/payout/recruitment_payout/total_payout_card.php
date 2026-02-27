<?php 
    $totalPayout = "SELECT SUM(total_payable) as total_payable FROM ca_ta_payout_paid";
    $Payout = $conn -> prepare($totalPayout);
    $Payout -> execute();
    $Payout -> setFetchMode(PDO::FETCH_ASSOC);
    if($Payout->rowCount()>0){
        foreach(($Payout->fetchAll()) as $key => $row){
            $total_payable = $row["total_payable"] ?? '0';
            echo'<p class="fs-5 fw-bolder mt-n2 content1" id="TotalPayoutAmountDate">Rs.'.$total_payable.'/-</p>';
        }
    }
?>