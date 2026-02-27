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
            $truncatedAmount = floor($TotalPayoutFinal * 100) / 100;
            echo'
            <p class="fs-5 font fw-bolder mt-n2 icon">Rs.'.number_format($truncatedAmount,2).'/- </p>
            <span class="badge bg-success fw-bold status1 paystatus" style="height: 15px !important; margin-top: 16px;" readonly>Paid</span>
            ';
        }
    }
?>