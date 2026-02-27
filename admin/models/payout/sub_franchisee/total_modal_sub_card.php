<?php
    $query = "
        SELECT 
            SUM(
                CASE 
                    WHEN zonal_manager IS NOT NULL 
                        AND zonal_manager NOT IN ('NA','Not Applicable') 
                    THEN commission_zm 
                    ELSE 0 
                END
                +
                CASE 
                    WHEN master_franchisee IS NOT NULL 
                        AND master_franchisee NOT IN ('NA','Not Applicable') 
                    THEN commission_mf 
                    ELSE 0 
                END
            ) AS payout
        FROM sub_franchisee_payout
    ";

    $stmt = $conn->prepare($query);
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);

    $totalPayout = 0;
    while ($row = $stmt->fetch()) {
        $totalPayout += $row['payout'] ?? 0;
    }

    if ($totalPayout > 0) {
        $tds = $totalPayout * 0.02;
        $netTotalPayout = $totalPayout - $tds;
        echo'<p class="fs-5 font fw-bolder mt-n2 icon" >Rs.'.$netTotalPayout.'/- </p>
                ';
    }else{
        echo'<p class="fs-5 fw-bolder mt-n2 content1" id="TotalPayoutAmountDate">Rs. 0/-</p>';
    }
?>