<?php 
    $previousPayout = $conn -> prepare("SELECT SUM(commision_bm + commision_te) as previousPayout FROM ca_ta_payout WHERE YEAR(created_date) = '".$prevDateYear."' AND MONTH(created_date) = '".$prevDateMonth."' ");
    $previousPayout -> execute();
    $previousPayout -> setFetchMode(PDO::FETCH_ASSOC);
    if($previousPayout -> rowCount()>0){
        foreach(($previousPayout -> fetchAll()) as $key => $row){
            $previousPayout = $row['previousPayout'];
            $previousPayoutTDS = $previousPayout * 5/100;
            $TotalpreviousPayout = $previousPayout - $previousPayoutTDS;
            echo'<p class="fs-5 fw-bolder mt-n2">Rs. ' .round($TotalpreviousPayout). '/- <span class="badge badge-pill badge-soft-success font-size-10 fw-bold ms-4">Paid</span> </p>';
        }
    }
?>