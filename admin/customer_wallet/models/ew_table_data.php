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

            COALESCE(lb.available_balance,0) AS available_balance,

            COALESCE(rwu.total_used_amount,0) AS used_balance

        FROM ca_customer c

        LEFT JOIN (
            SELECT
                customer_id,
                SUM(earn_amount) AS ref_total_earning
            FROM customer_discount_wallet
            WHERE referral_level = 'Level1'
            AND earn_amount IS NOT NULL
            AND created_date BETWEEN :date_from AND :date_to
            GROUP BY customer_id
        ) rp
            ON rp.customer_id = c.ca_customer_id

        LEFT JOIN (
            SELECT
                customer_id,
                COALESCE(SUM(used_amount),0) AS total_used_amount
            FROM customer_extended_wallet_utilization
            WHERE created_date BETWEEN :date_from2 AND :date_to2
            GROUP BY customer_id
        ) rwu
            ON rwu.customer_id = c.ca_customer_id

        LEFT JOIN (
            SELECT
                t.customer_id,
                t.balance AS available_balance
            FROM customer_extended_wallet_utilization t
            INNER JOIN (
                SELECT
                    customer_id,
                    MAX(id) AS max_id
                FROM customer_extended_wallet_utilization
                GROUP BY customer_id
            ) x
                ON x.customer_id = t.customer_id
                AND x.max_id = t.id
        ) lb
            ON lb.customer_id = c.ca_customer_id

        WHERE c.status = 1

        ORDER BY c.id DESC
    ");

    $sql->execute([
        ':date_from'  => $dateFrom,
        ':date_to'    => $dateTo,
        ':date_from2' => $dateFrom,
        ':date_to2'   => $dateTo
    ]);

    echo json_encode([
        'data' => $sql->fetchAll(PDO::FETCH_ASSOC)
    ]);
?>