<?php
    include (__DIR__.'/../../connect.php');
    //coupon wallet
    $sql = "
        SELECT 
            COUNT(id) AS total_coupons,
            COALESCE(SUM(coupon_amt), 0) AS total_amt,
            (
                SELECT COUNT(id)
                FROM ca_customer c
                WHERE c.status = 1
            ) AS customer_count
        FROM cu_coupons
        WHERE confirm_status = 1
    ";

    $stmt = $conn->prepare($sql);
    $stmt->execute();

    $couponData = $stmt->fetch(PDO::FETCH_ASSOC);
    //loyalty coupon wallet
    $sqlLoyal = "
        SELECT 
            COALESCE(COUNT(lc.id),0) AS total_coupons,
            COALESCE(SUM(lc.coupon_amt), 0) AS total_amt,
            COALESCE(COUNT(DISTINCT c.ca_customer_id),0) AS customer_count
        FROM loyalty_coupon lc
        INNER JOIN ca_customer c 
            ON lc.user_id = c.ca_customer_id
            AND c.status = 1
        WHERE lc.confirm_status = 1
    ";

    $stmtLoyal = $conn->prepare($sqlLoyal);
    $stmtLoyal->execute();

    $loyalCouponData = $stmtLoyal->fetch(PDO::FETCH_ASSOC);

    //referral wallet
    $sqlRef = "
        SELECT 
            COALESCE(SUM(lc.earned_amount), 0) AS total_amt,
            COALESCE(COUNT(DISTINCT c.id), 0) AS pending_encashed_count,
            COALESCE(COUNT(DISTINCT lc.customer_id), 0) AS ref_cust_count
        FROM customer_reference_wallet_utilization lc
        LEFT JOIN customer_reference_wallet_encashed c
            ON lc.customer_id = c.customer_id
            AND c.status = 2
        WHERE lc.earned_amount IS NOT NULL;
    ";

    $stmtRef = $conn->prepare($sqlRef);
    $stmtRef->execute();

    $refWalletData = $stmtRef->fetch(PDO::FETCH_ASSOC);

    //discount wallet
    $sqlDis = "
        SELECT 
            COALESCE(SUM(lc.earn_amount), 0) AS total_amt,
            COALESCE(COUNT(DISTINCT lc.customer_id),0) AS dis_cust_count
        FROM customer_discount_wallet lc
        WHERE status =1
    ";

    $stmtDis = $conn->prepare($sqlDis);
    $stmtDis->execute();

    $disWalletData = $stmtDis->fetch(PDO::FETCH_ASSOC);
?>