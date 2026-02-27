<?php 
    if($userType == '28' || $userType == '30'){ //MF/SF
        $userIdCommi = 'master_franchisee';
        $amtCal = 'commision_mf';
    }

    $totalPayout = "SELECT SUM($amtCal) as total_payable FROM sub_franchisee_payout WHERE $userIdCommi = '".$userId."' AND status_mf=1 ";
    $Payout = $conn -> prepare($totalPayout);
    $Payout -> execute();
    $Payout -> setFetchMode(PDO::FETCH_ASSOC);
    if($Payout->rowCount()>0){
        foreach(($Payout->fetchAll()) as $key => $row){
            $total_payable = $row["total_payable"] ?? '0';
            $totalPayoutTDS = $total_payable * $tdsPercentage;
            $TotalPayoutFinal = $total_payable - $totalPayoutTDS;
            $truncatedTotalAmount = floor($TotalPayoutFinal * 100) / 100;
            echo'<p class="fs-5 fw-bolder mt-n2 content1" id="TotalPayoutAmountDate">Rs.'.number_format($truncatedTotalAmount,2).'/-</p>';
        }
    }
?>