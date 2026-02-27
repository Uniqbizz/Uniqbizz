<?php
    $previousPayout = $conn->prepare("SELECT SUM(payout_amount) as previousPayout FROM bdm_payout_history WHERE bdm_user_id = '" . $userId . "' AND YEAR(payout_date) = '" . $prevDateYear . "' AND MONTH(payout_date) = '" . $prevDateMonth . "' ");
    $previousPayout->execute();
    $previousPayout->setFetchMode(PDO::FETCH_ASSOC);
    if ($previousPayout->rowCount() > 0) {
        foreach (($previousPayout->fetchAll()) as $key => $row) {
            $previousPayout = $row['previousPayout'];
            $previousPayoutTDS = $previousPayout * $tds_percentage;
            $TotalpreviousPayout = $previousPayout - $previousPayoutTDS;
            $truncatedPrevAmount = floor($TotalpreviousPayout * 100) / 100;
            echo '<p class="fs-5 font fw-bolder mt-n2 icon">Rs.' .number_format($truncatedPrevAmount,2). '/- </p>
                    <span class="badge bg-success font-size-10 fw-bold status1 paystatus" style="height: 15px !important; margin-top: 16px;" readonly>Paid</span>';
        }
    }
?>