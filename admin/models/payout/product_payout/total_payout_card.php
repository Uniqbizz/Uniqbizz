<?php 
    $totalPayout = "SELECT SUM(ta_markup+ta_amt+te_amt+bm_amt+bdm_amt+bch_amt+cu1_amt+cu2_amt+cu3_amt) as total_payable FROM product_payout";
    $Payout = $conn -> prepare($totalPayout);
    $Payout -> execute();
    $Payout -> setFetchMode(PDO::FETCH_ASSOC);
    if($Payout->rowCount()>0){
        foreach(($Payout->fetchAll()) as $key => $row){
            $total_payable = $row["total_payable"] ?? '0';
            $totalPayoutTDS = $total_payable * $tdsPercentage;
            $TotalPayout = $total_payable - $totalPayoutTDS;
            $truncatedTotalAmount = floor($TotalPayout * 100) / 100;
            echo'<p class="fs-5 fw-bolder mt-n2 content1" id="TotalPayoutAmountDate">Rs.'.number_format($truncatedTotalAmount,2).'/-</p>';
        }
    }
?>