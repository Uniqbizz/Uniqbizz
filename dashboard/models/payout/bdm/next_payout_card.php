<?php
    $nextPayout = $conn->prepare("SELECT SUM(payout_amount) as nextPayout FROM bdm_payout_history WHERE  bdm_user_id = '" . $userId . "' AND YEAR(payout_date) = '" . $nextDateYear . "' AND MONTH(payout_date) = '" . $nextDateMonth . "'  ");
    $nextPayout->execute();
    $nextPayout->setFetchMode(PDO::FETCH_ASSOC);
    if ($nextPayout->rowCount() > 0) {
        foreach (($nextPayout->fetchAll()) as $key => $row2) {
            $nextPayoutTotal = $row2['nextPayout'];
            $nextPayoutTDS = $nextPayoutTotal * $tds_percentage;
            $TotalNextPayout = $nextPayoutTotal - $nextPayoutTDS;
            $truncatedNextAmount = floor($TotalNextPayout * 100) / 100;
            echo '<p class="fs-5 fw-bolder mt-n2">Rs.' .number_format($truncatedNextAmount,2). '/- <span class="badge bg-warning font-size-10 fw-bold ms-4">Pending</span> </p>';
        }
    }
?>