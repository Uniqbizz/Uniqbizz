<?php
    include(__DIR__ . '/../../connect.php');

    $cust_id = $_POST['customer_id'];
    /*
    |--------------------------------------------------------------------------
    | Reference Wallet Utilization
    |--------------------------------------------------------------------------
    */
    $sqlRefWalletCurBal = $conn->prepare("
        SELECT
            COALESCE(
                (
                    SELECT balance
                    FROM customer_reference_wallet_utilization
                    WHERE customer_id = :user_id
                    ORDER BY id DESC
                    LIMIT 1
                ),
                0
            ) AS total_balance,

            COALESCE(
                SUM(
                    CASE
                        WHEN transaction_id NOT LIKE 'CU%'
                        AND transaction_id NOT LIKE 'WD%'
                        THEN earned_amount
                        ELSE 0
                    END
                ),
                0
            ) AS ref_booking_total,

            COALESCE(SUM(used_amount),0) AS total_used_amount

        FROM customer_reference_wallet_utilization
        WHERE customer_id = :user_id
    ");

    $sqlRefWalletCurBal->execute([
        ":user_id" => $cust_id
    ]);
    $refWalletCurBalData = $sqlRefWalletCurBal->fetch(PDO::FETCH_ASSOC);

    /*
    |--------------------------------------------------------------------------
    | Reference Wallet Statistics
    |--------------------------------------------------------------------------
    */
    $sqlRefWallet = $conn->prepare("
        SELECT
            COUNT(*) AS ref_count,

            COALESCE(SUM(referral_amount),0) AS ref_total_earning

        FROM customer_reference_payout
        WHERE referral_level = 'Level1'
        AND referral_amount IS NOT NULL
        AND customer_id =:user_id
    ");

    $sqlRefWallet->execute([
        ":user_id" => $cust_id
    ]);
    $refWalletData = $sqlRefWallet->fetch(PDO::FETCH_ASSOC);
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
    | Reference wallet encashment
    |--------------------------------------------------------------------------
    */
    $sqlRefWalletEncash = $conn->prepare("
        SELECT COALESCE(SUM(encashed_amount), 0) AS total_earning_pending
        FROM customer_reference_wallet_encashed
        WHERE status=2 AND customer_id=:user_id
    ");

    $sqlRefWalletEncash->execute([
        ":user_id" => $cust_id
    ]);
    $refWalletEncashData = $sqlRefWalletEncash->fetch(PDO::FETCH_ASSOC);
    /*
    |--------------------------------------------------------------------------
    | Safe Defaults
    |--------------------------------------------------------------------------
    */
    $refWalletCurBalData = $refWalletCurBalData ?: [
        'total_balance' => 0,
        'ref_booking_total' => 0
    ];

    $refWalletData = $refWalletData ?: [
        'ref_count' => 0,
        'ref_total_earning' => 0,
        'total_used_amount' =>0
    ];

    $refWalletEncashData=$refWalletEncashData?:[
        'total_earning_pending' =>0
    ];
?>