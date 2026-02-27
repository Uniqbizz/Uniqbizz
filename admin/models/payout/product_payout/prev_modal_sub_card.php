<?php 
    $previousPayout = $conn -> prepare("SELECT SUM(ta_markup+ta_amt+te_amt+bm_amt+bdm_amt+bch_amt+cu1_amt+cu2_amt+cu3_amt) as previousPayout FROM product_payout WHERE YEAR(created_date) = '".$prevDateYear."' AND MONTH(created_date) = '".$prevDateMonth."' ");
    $previousPayout -> execute();
    $previousPayout -> setFetchMode(PDO::FETCH_ASSOC);
    if($previousPayout -> rowCount()>0){
        foreach(($previousPayout -> fetchAll()) as $key => $row){
            $previousPayout = $row['previousPayout'];
            $previousPayoutTDS = $previousPayout * $tdsPercentage;
            $TotalpreviousPayout = $previousPayout - $previousPayoutTDS;
            $truncatedPrevAmount = floor($TotalpreviousPayout * 100) / 100;
            echo'<p class="fs-5 font fw-bolder mt-n2 icon">Rs.' .number_format($truncatedPrevAmount,2). '/- </p><span class="badge badge-pill badge-soft-warning font-size-10 fw-bold status1" style="height: 15px !important; margin-top: 16px;" readonly>Pending</span>';
        }
    }
?>