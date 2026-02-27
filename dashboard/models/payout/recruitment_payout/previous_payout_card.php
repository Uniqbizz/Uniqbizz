<?php 
    $previousPayout = $conn -> prepare("SELECT SUM($columnCommision) as previousPayout FROM ca_ta_payout WHERE $columnDesignation = '".$userId."'  AND YEAR(created_date) = '".$prevDateYear."' AND MONTH(created_date) = '".$prevDateMonth."' ");
    $previousPayout -> execute();
    $previousPayout -> setFetchMode(PDO::FETCH_ASSOC);
    if($previousPayout -> rowCount()>0){
        foreach(($previousPayout -> fetchAll()) as $key => $row){
            $previousPayout = $row['previousPayout'];
            $previousPayoutTDS = $previousPayout * $tdsPercentage;
            $TotalpreviousPayout = $previousPayout - $previousPayoutTDS;
            echo'<p class="fs-5 fw-bolder mt-n2">Rs. ' .round($TotalpreviousPayout). '/- <span class="badge bg-success font-size-10 fw-bold ms-4">Paid</span> </p>';
        }
    }
?>