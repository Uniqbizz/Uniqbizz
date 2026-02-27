<?php
    $query = "
        SELECT SUM(referral_amount) as payout FROM customer_reference_payout WHERE YEAR(created_date) = :year AND MONTH(created_date) = :month
    ";

    $stmt = $conn->prepare($query);
    $stmt->execute(['year' => $nextDateYear, 'month' => $nextDateMonth]);
    $stmt->setFetchMode(PDO::FETCH_ASSOC);

    $totalPayout = 0;
    while ($row = $stmt->fetch()) {
        $totalPayout += $row['payout'] ?? 0;
    }

    if ($totalPayout > 0) {
        $tds = $totalPayout * 0.02;
        $netPayout = $totalPayout - $tds;
        echo '<p class="fs-5 fw-bolder mt-n2">Rs. ' . round($netPayout) . '/- <span class="badge badge-pill badge-soft-success font-size-10 fw-bold ms-4">Paid</span> </p>';
    }else{
        echo '<p class="fs-5 fw-bolder mt-n2">Rs. 0/- <span class="badge badge-pill badge-soft-success font-size-10 fw-bold ms-4">Paid</span> </p>';
    }
?>