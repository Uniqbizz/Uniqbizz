<?php

    include (__DIR__.'/../../connect.php');
    $cust_id=$_POST['customer_id'];

    $sqlViewCustLoyaltyCoupon = $conn->prepare("
        SELECT
            c.ca_customer_id,
            CONCAT(c.firstname,' ',c.lastname) AS cust_name,
            c.contact_no,
            c.country_code,
            c.email,
            c.customer_type,
            c.register_date,
            c.profile_pic,
            CAST(COALESCE(bt.total_trips,0) AS UNSIGNED) AS total_trips, 
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

        WHERE lc.confirm_status = 1
        AND lc.user_id=:user_id
        GROUP BY
            c.ca_customer_id,
            c.firstname,
            c.lastname,
            c.contact_no,
            c.country_code,
            c.email,
            c.customer_type,
            c.register_date,
            c.profile_pic,
            bt.total_trips
    ");

    

    $sqlViewCustLoyaltyCoupon->execute([
        ":user_id" =>$cust_id
    ]);

    $viewCustLoyaltyCoupondata = $sqlViewCustLoyaltyCoupon->fetch(PDO::FETCH_ASSOC);
    
?>