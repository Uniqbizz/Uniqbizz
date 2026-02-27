<?php
    $query = "
        SELECT SUM(comm_amt) as payout FROM goa_bdm_payout WHERE YEAR(created_date) = :year AND MONTH(created_date) = :month
        UNION ALL
        SELECT SUM(comm_amt) as payout FROM goa_bm_payout WHERE YEAR(created_date) = :year AND MONTH(created_date) = :month
        UNION ALL
        SELECT SUM(comm_amt) as payout FROM ca_payout WHERE YEAR(created_date) = :year AND MONTH(created_date) = :month
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
        echo'<p class="fs-5 font fw-bolder mt-n2 icon">Rs.' .round($netPayout). '/- </p>
            <span class="badge badge-pill badge-soft-success font-size-10 fw-bold status1" style="height: 15px !important; margin-top: 16px;" readonly>Paid</span>';
    }else{
        echo'<p class="fs-5 font fw-bolder mt-n2 icon">Rs 0/- </p>
            <span class="badge badge-pill badge-soft-success font-size-10 fw-bold status1" style="height: 15px !important; margin-top: 16px;" readonly>Paid</span>';
    }
?>