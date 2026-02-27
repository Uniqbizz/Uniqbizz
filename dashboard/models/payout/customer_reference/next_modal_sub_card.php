<?php
    $query = "
        SELECT SUM(referral_amount) as payout FROM customer_reference_payout WHERE customer_id='".$userId."' AND YEAR(created_date) = :year AND MONTH(created_date) = :month
    ";

    $stmt = $conn->prepare($query);
    $stmt->execute(['year' => $nextDateYear, 'month' => $nextDateMonth]);
    $stmt->setFetchMode(PDO::FETCH_ASSOC);

    $totalPayout = 0;
    while ($row = $stmt->fetch()) {
        $totalPayout += $row['payout'] ?? 0;
        $truncatedAmount = truncateToTwoDecimals($totalPayout);
    }

    if ($totalPayout > 0) {
        $tds = $totalPayout * $tdsPer;
        $netPayout = $totalPayout - $tds;
        $truncatedAmount = truncateToTwoDecimals($netPayout);
        echo'<p class="fs-5 font fw-bolder mt-n2 icon">Rs.' .number_format($truncatedAmount ,2). '/- </p>
            <span class="badge bg-success fw-bold status1 paystatus" style="height: 15px !important; margin-top: 16px;" readonly>Paid</span>';
    }else{
        echo'<p class="fs-5 font fw-bolder mt-n2 icon">Rs 0/- </p>
            <span class="badge bg-success fw-bold status1 paystatus" style="height: 15px !important; margin-top: 16px;" readonly>Paid</span>';
    }
?>