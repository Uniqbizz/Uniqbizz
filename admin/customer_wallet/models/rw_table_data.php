<?php

    include(__DIR__ . '/../../connect.php');

    $start_date = $_GET['start_date'] ?? date('Y-m-01');
    $end_date   = $_GET['end_date'] ?? date('Y-m-d');

    $dateFrom = $start_date . ' 00:00:00';
    $dateTo   = $end_date . ' 23:59:59';

    $sql = $conn->prepare("
        SELECT
            c.ca_customer_id,
            CONCAT(c.firstname,' ',c.lastname) AS customer_name,
            c.profile_pic,
            c.customer_type,

            COALESCE(rp.ref_total_earning,0) AS total_earned,

            COALESCE(rwu.total_balance,0) AS available_balance,

            COALESCE(rwu.total_used_amount,0) AS used_balance,

            COALESCE(rwe.pending_withdrawal,0) AS pending_withdrawal

        FROM ca_customer c

        LEFT JOIN (
            SELECT
                customer_id,
                SUM(referral_amount) AS ref_total_earning
            FROM customer_reference_payout
            WHERE referral_level='Level1'
            AND referral_amount IS NOT NULL
            AND created_date BETWEEN :date_from AND :date_to
            GROUP BY customer_id
        ) rp ON rp.customer_id = c.ca_customer_id

        LEFT JOIN (
            SELECT
                customer_id,
                SUM(balance) AS total_balance,
                SUM(used_amount) AS total_used_amount
            FROM customer_reference_wallet_utilization
            WHERE created_date BETWEEN :date_from2 AND :date_to2
            GROUP BY customer_id
        ) rwu ON rwu.customer_id = c.ca_customer_id

        LEFT JOIN (
            SELECT
                customer_id,
                SUM(encashed_amount) AS pending_withdrawal
            FROM customer_reference_wallet_encashed
            WHERE status = 2
            GROUP BY customer_id
        ) rwe ON rwe.customer_id = c.ca_customer_id

        WHERE c.status = 1
    ");

    $sql->execute([
        ':date_from'  => $dateFrom,
        ':date_to'    => $dateTo,
        ':date_from2' => $dateFrom,
        ':date_to2'   => $dateTo
    ]);

    echo json_encode([
        "data" => $sql->fetchAll(PDO::FETCH_ASSOC)
    ]);
?>