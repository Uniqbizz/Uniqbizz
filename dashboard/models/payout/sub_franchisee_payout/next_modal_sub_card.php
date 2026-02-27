<?php 
    if($userType == '28' || $userType == '30'){ //MF/SF
        $userIdCommi = 'master_franchisee';
        $amtCal = 'commision_mf';
    }
    $nextPayout = $conn -> prepare("SELECT SUM(($amtCal)) as nextPayout FROM sub_franchisee_payout WHERE $userIdCommi = '".$userId."' AND YEAR(created_date) = '".$nextDateYear."' AND MONTH(created_date) = '".$nextDateMonth."' ");
    $nextPayout -> execute();
    $nextPayout -> setFetchMode(PDO::FETCH_ASSOC);
    if($nextPayout -> rowCount()>0){
        foreach(($nextPayout -> fetchAll()) as $key => $row2){
            $nextPayoutTotal = $row2['nextPayout'];
            $nextPayoutTDS = $nextPayoutTotal * $tdsPercentage;
            $TotalNextPayout = $nextPayoutTotal - $nextPayoutTDS;
            $truncatedNextAmount = floor($TotalNextPayout * 100) / 100;
            echo'<p class="fs-5 font fw-bolder mt-n2 icon">Rs.' .number_format($truncatedNextAmount,2). '/- </p>
            <span class="badge bg-success fw-bold status1 paystatus" style="height: 15px !important; margin-top: 16px;" readonly>Paid</span>';
        }
    }
?>