<?php
    $query = "
        SELECT SUM(commission_zm+commission_mf) as payout FROM sub_franchisee_payout WHERE YEAR(created_date) = :year AND MONTH(created_date) = :month                                                            
    ";

    $stmt = $conn->prepare($query);
    $stmt->execute(['year' => $prevDateYear, 'month' => $prevDateMonth]);
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $totalPayout = 0;
    while ($row = $stmt->fetch()) {
        $totalPayout += $row['payout'] ?? 0;
    }

    if ($totalPayout > 0) {
        $tds = $totalPayout * 0.02; //tds
        $netPayout = $totalPayout - $tds;
        echo '<p class="fs-5 fw-bolder mt-n2">Rs. ' . round($netPayout) . '/-  </p>';
    }else{
        echo '<p class="fs-5 fw-bolder mt-n2">Rs. 0/-  </p>';
    }
?>