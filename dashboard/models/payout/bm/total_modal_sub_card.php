<?php
    $totalPayout = "SELECT SUM(payout_amount) as total_payable FROM bm_payout_history WHERE bm_user_id = '" . $userId . "' AND payout_status='2' OR payout_status='3'";
    $Payout = $conn->prepare($totalPayout);
    $Payout->execute();
    $Payout->setFetchMode(PDO::FETCH_ASSOC);
    if ($Payout->rowCount() > 0) {
        foreach (($Payout->fetchAll()) as $key => $row) {
            $total_payable = $row["total_payable"];
            $truncatedTotalAmount = floor($total_payable * 100) / 100;
            echo '
                    <p class="fs-5 font fw-bolder mt-n2 icon">Rs.' .number_format($truncatedTotalAmount,2). '/- </p>
                    <span class="badge bg-success font-size-10 fw-bold status1 paystatus" style="height: 15px !important; margin-top: 16px;" readonly>Paid</span>
                    ';
        }
    }
?>