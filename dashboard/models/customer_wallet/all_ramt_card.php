<?php
    $stmt = $conn->prepare("SELECT
        SUM(COALESCE(credit_amount, 0)) AS credit_amt,
        SUM(COALESCE(debit_amount, 0)) AS debit_amt,
        (SUM(COALESCE(credit_amount, 0)) - SUM(COALESCE(debit_amount, 0))) AS net_balance
    FROM customer_reference_wallet_utilization
    WHERE customer_id = :userId");
    $stmt->execute(['userId' => $userId]);
    $redeemableTotal = $stmt->fetch(PDO::FETCH_ASSOC)['net_balance'] ?? 0;
    echo '<h1 class="mb-0 text-white">' . $redeemableTotal . '</h1>';                                           
?>