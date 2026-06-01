<?php

    include (__DIR__.'/../../connect.php');

    $sqlCustCoupon = $conn->prepare("
        SELECT
            CAST(COALESCE(SUM(coupon_amt), 0) AS UNSIGNED) AS total_amt,

            CAST(COALESCE(COUNT(id), 0) AS UNSIGNED) AS total_coupons,

            CAST(COALESCE(SUM(
                CASE
                    WHEN confirm_status = 1 AND usage_status = 0
                    THEN coupon_amt
                    ELSE 0
                END
            ), 0) AS UNSIGNED) AS available_amt,

            CAST(COALESCE(COUNT(
                CASE
                    WHEN confirm_status = 1 AND usage_status = 0
                    THEN id
                END
            ), 0) AS UNSIGNED) AS available_coupons,

            CAST(COALESCE(SUM(
                CASE
                    WHEN confirm_status = 1 AND usage_status = 1
                    THEN coupon_amt
                    ELSE 0
                END
            ), 0) AS UNSIGNED) AS used_amt,

            CAST(COALESCE(COUNT(
                CASE
                    WHEN confirm_status = 1 AND usage_status = 1
                    THEN id
                END
            ), 0) AS UNSIGNED) AS used_coupons,

            CAST(COALESCE(COUNT(DISTINCT user_id), 0) AS UNSIGNED) AS total_customers

        FROM cu_coupons
        WHERE confirm_status = 1
    ");

    $sqlCustCoupon->execute();

    $custCoupondata = $sqlCustCoupon->fetch(PDO::FETCH_ASSOC);
?>