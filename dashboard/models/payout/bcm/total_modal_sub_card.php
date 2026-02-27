<?php
    $totalPayout = "SELECT SUM(payout_amount) as total_payable FROM bcm_payout_history WHERE bcm_user_id = '" . $userId . "' ";
    $Payout = $conn->prepare($totalPayout);
    $Payout->execute();
    $Payout->setFetchMode(PDO::FETCH_ASSOC);
    // print_r($Payout);
    if ($Payout->rowCount() > 0) {
        foreach (($Payout->fetchAll()) as $key => $row) {
            $total_payable = $row["total_payable"] ?? '0';
            $total_payableTDS = $total_payable * $tds_percentage;
            $TotalPayout = $total_payable - $total_payableTDS;
            $truncatedTotalAmount = floor($TotalPayout * 100) / 100;
            echo '
                <p class="fs-5 font fw-bolder mt-n2 icon">Rs.' . number_format($truncatedTotalAmount, 2) . '/- </p>
                <span class="badge bg-success font-size-10 fw-bold status1 paystatus" style="height: 15px !important; margin-top: 16px;" readonly>Paid</span>
            ';
        }
    }
?>