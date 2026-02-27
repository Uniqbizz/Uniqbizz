<?php 
    $totalPayout = "SELECT SUM($columnCommision) as total_payable FROM ca_ta_payout WHERE $columnDesignation = '".$userId."'  AND  $columnStatus = '1'";
    $Payout = $conn -> prepare($totalPayout);
    $Payout -> execute();
    $Payout -> setFetchMode(PDO::FETCH_ASSOC);
    if($Payout->rowCount()>0){
        foreach(($Payout->fetchAll()) as $key => $row){
            $total_payable = $row["total_payable"];
            $tds = $total_payable * $tdsPercentage;
            $total_payables = $total_payable - $tds;
            echo'<p class="fs-5 fw-bolder mt-n2 content1" id="TotalPayoutAmountDate">Rs.'.$total_payables.'/-</p>';
        }
    }
?>