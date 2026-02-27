<?php 
    $totalPayout = "SELECT SUM(comm_amt) as total_payable FROM ca_payout WHERE  business_consultant = '".$userId."' AND status = '1' ";
    $Payout = $conn -> prepare($totalPayout);
    $Payout -> execute();
    $Payout -> setFetchMode(PDO::FETCH_ASSOC);
    if($Payout->rowCount()>0){
        foreach(($Payout->fetchAll()) as $key => $row){
            $total_payable = $row["total_payable"] ?? '0';
            $total_payableTDS = $total_payable * 5/100;
            $TotalPayout = $total_payable - $total_payableTDS;
            echo'<p class="fs-5 fw-bolder mt-n2 content1" id="TotalPayoutAmountDate">Rs.'.$TotalPayout.'/-</p>';
        }
    }
?>