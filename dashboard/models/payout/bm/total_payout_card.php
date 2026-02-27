<?php
    $totalPayout = "SELECT SUM(payout_amount) as total_payable FROM bm_payout_history WHERE  bm_user_id = '" . $userId . "' ";
    $Payout = $conn->prepare($totalPayout);
    $Payout->execute();
    $Payout->setFetchMode(PDO::FETCH_ASSOC);
    if ($Payout->rowCount() > 0) {
        foreach (($Payout->fetchAll()) as $key => $row) {
            $total_payable = $row["total_payable"] ?? '0';
            $total_payableTDS = $total_payable * $tds_percentage;
            $TotalPayout = $total_payable - $total_payableTDS;
            $truncatedTotalAmount = floor($TotalPayout * 100) / 100;
            echo '<p class="fs-5 fw-bolder mt-n2 content1" id="TotalPayoutAmountDate">Rs.' .number_format($truncatedTotalAmount,2). '/-</p>';
        }
    }
?>