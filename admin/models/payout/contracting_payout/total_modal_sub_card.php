<?php
    $query = "
        SELECT SUM(comm_amt) as payout FROM goa_bdm_payout WHERE status = :status
        UNION ALL
        SELECT SUM(comm_amt) as payout FROM goa_bm_payout WHERE status = :status
        UNION ALL
        SELECT SUM(comm_amt) as payout FROM ca_payout WHERE status = :status
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
        $netTotalPayout = $totalPayout - $tds;
        echo'<p class="fs-5 font fw-bolder mt-n2 icon">Rs.'.$netTotalPayout.'/- </p>
            <span class="badge badge-pill badge-soft-success font-size-10 fw-bold status1" style="height: 15px !important; margin-top: 16px;" readonly>Paid</span>';
    }else{
        echo'<p class="fs-5 fw-bolder mt-n2 content1" id="TotalPayoutAmountDate">Rs. 0/-</p>';
    }
?>