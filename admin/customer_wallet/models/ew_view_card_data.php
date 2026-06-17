<?php
    include(__DIR__ . '/../../connect.php');

    $cust_id = $_POST['customer_id'];
    /*
    |--------------------------------------------------------------------------
    | Discount Wallet Utilization
    |--------------------------------------------------------------------------
    */
    $sqlExtWalletCurBal = $conn->prepare("
        SELECT
            COALESCE(
                (
                    SELECT balance
                    FROM customer_extended_wallet_utilization
                    WHERE customer_id = :user_id
                    ORDER BY id DESC
                    LIMIT 1
                ),
                0
            ) AS total_balance,

            COALESCE(SUM(earn_amount),0) AS earn_total,

            COALESCE(SUM(used_amount),0) AS total_used_amount

        FROM customer_extended_wallet_utilization
        WHERE customer_id = :user_id
    ");

    $sqlExtWalletCurBal->execute([
        ":user_id" => $cust_id
    ]);
    $extWalletCurBalData = $sqlExtWalletCurBal->fetch(PDO::FETCH_ASSOC);

    /*
    |--------------------------------------------------------------------------
    | Discount Wallet Statistics
    |--------------------------------------------------------------------------
    */
    $sqlExtWallet = $conn->prepare("
        SELECT
            COUNT(*) AS ref_count,

            COALESCE(SUM(earn_amount),0) AS ref_total_earning

        FROM customer_extended_wallet
        WHERE referral_level = 'Level1'
        AND earn_amount IS NOT NULL
        AND customer_id =:user_id
    ");

    $sqlExtWallet->execute([
        ":user_id" => $cust_id
    ]);
    $extWalletData = $sqlExtWallet->fetch(PDO::FETCH_ASSOC);
    /*
    |--------------------------------------------------------------------------
    | Total Customers
    |--------------------------------------------------------------------------
    */
    $sqlcust = $conn->prepare("
        SELECT
            c.ca_customer_id,
            CONCAT(c.firstname,' ',c.lastname) AS cust_name,
            c.country_code,
            c.contact_no,
            c.email,
            c.customer_type,
            c.register_date,
            c.profile_pic,
            CAST(COALESCE(bt.total_trips,0) AS UNSIGNED) AS total_trips 
        FROM ca_customer c
        LEFT JOIN (
            SELECT
                b.customer_id,
                COUNT(*) AS total_trips
            FROM bookings b
            INNER JOIN package p
                ON p.id = b.package_id
            WHERE b.status = 0
                AND b.confirm_status = 1
                AND DATE_ADD(b.date, INTERVAL p.tour_days DAY) > NOW()
            GROUP BY b.customer_id
        ) bt ON bt.customer_id = c.ca_customer_id
        WHERE status=1 AND ca_customer_id = :user_id
    ");

    $sqlcust->execute([
        ":user_id" => $cust_id
    ]);
    $custData = $sqlcust->fetch(PDO::FETCH_ASSOC);

    /*
    |--------------------------------------------------------------------------
    | Safe Defaults
    |--------------------------------------------------------------------------
    */
    $extWalletCurBalData = $extWalletCurBalData ?: [
        'total_balance' => 0,
        'ref_booking_total' => 0
    ];

    $extWalletData = $extWalletData ?: [
        'ref_count' => 0,
        'ref_total_earning' => 0,
        'total_used_amount' =>0
    ];
?>