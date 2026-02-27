<?php 
    $nextPayout = $conn -> prepare("SELECT SUM($columnCommision) as nextPayout FROM ca_ta_payout WHERE $columnDesignation = '".$userId."'  AND  YEAR(created_date) = '".$nextDateYear."' AND MONTH(created_date) = '".$nextDateMonth."' ");
    $nextPayout -> execute();
    $nextPayout -> setFetchMode(PDO::FETCH_ASSOC);
    if($nextPayout -> rowCount()>0){
        foreach(($nextPayout -> fetchAll()) as $key => $row2){
            $nextPayoutTotal = $row2['nextPayout'];
            $nextPayoutTDS = $nextPayoutTotal * $tdsPercentage;
            $TotalNextPayout = $nextPayoutTotal - $nextPayoutTDS;
            echo'<p class="fs-5 font fw-bolder mt-n2 icon">Rs.' .round($TotalNextPayout). '/- </p>
            <span class="badge bg-success font-size-10 fw-bold status1 paystatus" style="height: 15px !important; margin-top: 16px;" readonly>Paid</span>';
        }
    }
?>