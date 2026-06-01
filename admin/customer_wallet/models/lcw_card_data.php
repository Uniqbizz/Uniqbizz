<?php

    include (__DIR__.'/../../connect.php');

    $sqlCustLoyaltyCoupon = $conn->prepare("
        SELECT

            /* Overall */
            CAST(COALESCE(SUM(lc.coupon_amt),0) AS UNSIGNED) AS total_amt,
            CAST(COALESCE(COUNT(lc.id),0) AS UNSIGNED) AS total_coupons,

            /* Available */
            CAST(COALESCE(COUNT(
                CASE
                    WHEN lc.usage_status = 0
                    AND lc.expiry_date >= NOW()
                    AND NOT EXISTS (
                        SELECT 1
                        FROM cu_coupons cc
                        WHERE cc.user_id = lc.user_id
                        AND cc.confirm_status = 1
                        AND cc.usage_status = 0
                    )
                    THEN lc.id
                END
            ),0) AS UNSIGNED) AS available_coupons,

            CAST(COALESCE(SUM(
                CASE
                    WHEN lc.usage_status = 0
                    AND lc.expiry_date >= NOW()
                    AND NOT EXISTS (
                        SELECT 1
                        FROM cu_coupons cc
                        WHERE cc.user_id = lc.user_id
                        AND cc.confirm_status = 1
                        AND cc.usage_status = 0
                    )
                    THEN lc.coupon_amt
                    ELSE 0
                END
            ),0) AS UNSIGNED) AS available_amt,

            /* Used */
            CAST(COALESCE(COUNT(
                CASE
                    WHEN lc.usage_status = 1
                    THEN lc.id
                END
            ),0) AS UNSIGNED) AS used_coupons,

            CAST(COALESCE(SUM(
                CASE
                    WHEN lc.usage_status = 1
                    THEN lc.coupon_amt
                    ELSE 0
                END
            ),0) AS UNSIGNED) AS used_amt,

            /* Expiring in next 30 days */
            CAST(COALESCE(COUNT(
                CASE
                    WHEN lc.usage_status = 0
                    AND lc.expiry_date >= NOW()
                    AND lc.expiry_date <= DATE_ADD(NOW(), INTERVAL 30 DAY)
                    THEN lc.id
                END
            ),0) AS UNSIGNED) AS expiring_coupons,

            CAST(COALESCE(SUM(
                CASE
                    WHEN lc.usage_status = 0
                    AND lc.expiry_date >= NOW()
                    AND lc.expiry_date <= DATE_ADD(NOW(), INTERVAL 30 DAY)
                    THEN lc.coupon_amt
                    ELSE 0
                END
            ),0) AS UNSIGNED) AS expiring_total,

            /* Expired */
            CAST(COALESCE(COUNT(
                CASE
                    WHEN lc.usage_status = 0
                    AND lc.expiry_date < NOW()
                    THEN lc.id
                END
            ),0) AS UNSIGNED) AS expired_coupons,

            CAST(COALESCE(SUM(
                CASE
                    WHEN lc.usage_status = 0
                    AND lc.expiry_date < NOW()
                    THEN lc.coupon_amt
                    ELSE 0
                END
            ),0) AS UNSIGNED) AS expired_total,

            /* Locked */
            CAST(COALESCE(COUNT(
                CASE
                    WHEN lc.usage_status = 0
                    AND lc.expiry_date >= NOW()
                    AND EXISTS (
                        SELECT 1
                        FROM cu_coupons cc
                        WHERE cc.user_id = lc.user_id
                        AND cc.confirm_status = 1
                        AND cc.usage_status = 0
                    )
                    THEN lc.id
                END
            ),0) AS UNSIGNED) AS locked_coupons,

            CAST(COALESCE(SUM(
                CASE
                    WHEN lc.usage_status = 0
                    AND lc.expiry_date >= NOW()
                    AND EXISTS (
                        SELECT 1
                        FROM cu_coupons cc
                        WHERE cc.user_id = lc.user_id
                        AND cc.confirm_status = 1
                        AND cc.usage_status = 0
                    )
                    THEN lc.coupon_amt
                    ELSE 0
                END
            ),0) AS UNSIGNED) AS locked_coupon_total,

            /* Customers */
            CAST(COALESCE(COUNT(DISTINCT lc.user_id),0) AS UNSIGNED) AS total_customers

        FROM loyalty_coupon lc

        INNER JOIN ca_customer c
            ON c.ca_customer_id = lc.user_id
            AND c.status = 1

        WHERE lc.confirm_status = 1
    ");

    $sqlCustLoyaltyCoupon->execute();

    $custLoyaltyCoupondata = $sqlCustLoyaltyCoupon->fetch(PDO::FETCH_ASSOC);
?>