<?php 
    $nextPayout = $conn -> prepare("SELECT SUM(ta_markup+ta_amt+te_amt+bm_amt+bdm_amt+bch_amt+cu1_amt+cu2_amt+cu3_amt) as nextPayout FROM product_payout WHERE YEAR(created_date) = '".$nextDateYear."' AND MONTH(created_date) = '".$nextDateMonth."' ");
    $nextPayout -> execute();
    $nextPayout -> setFetchMode(PDO::FETCH_ASSOC);
    if($nextPayout -> rowCount()>0){
        foreach(($nextPayout -> fetchAll()) as $key => $row2){
            $nextPayoutTotal = $row2['nextPayout'];
            $nextPayoutTDS = $nextPayoutTotal * $tdsPercentage;
            $TotalNextPayout = $nextPayoutTotal - $nextPayoutTDS;
            $truncatedNextAmount = floor($TotalNextPayout * 100) / 100;
            echo'<p class="fs-5 fw-bolder mt-n2">Rs.' .number_format($truncatedNextAmount,2). '/- <span class="badge badge-pill badge-soft-warning font-size-10 fw-bold ms-4">Pending</span> </p>';
        }
    }
?>