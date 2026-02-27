<?php
    $query = "
        SELECT SUM(referral_amount) as payout FROM customer_reference_payout WHERE status = :status
    ";

    $stmt = $conn->prepare($query);
    $stmt->execute(['status' => '1']);
    $stmt->setFetchMode(PDO::FETCH_ASSOC);

    $totalPayout = 0;
    while ($row = $stmt->fetch()) {
        $totalPayout += $row['payout'] ?? 0;
    }

    if ($totalPayout > 0) {
        $tds = $totalPayout * 0.02;
        $netPayout = $totalPayout - $tds;
        echo'<p class="fs-5 fw-bolder mt-n2 content1" id="TotalPayoutAmountDate">Rs.'.$netPayout.'/-</p>';
    }else{
        echo'<p class="fs-5 fw-bolder mt-n2 content1" id="TotalPayoutAmountDate">Rs. 0/-</p>';
    }
?>