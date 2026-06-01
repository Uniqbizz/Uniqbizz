<?php
    include (__DIR__.'/../../connect.php');
    header('Content-Type: application/json; charset=utf-8');
    $sqlCustCoupon = $conn->prepare("
        SELECT
            c.ca_customer_id,
            CONCAT(c.firstname,' ',c.lastname) AS customer_name,
            c.customer_type,
            c.profile_pic,
            c.status,
            c.profile_pic,
            CAST(COALESCE(SUM(cc.coupon_amt),0) AS UNSIGNED) AS total_amt,

            CAST(COALESCE(COUNT(cc.id),0) AS UNSIGNED) AS total_coupons,

            CAST(COALESCE(SUM(
                CASE
                    WHEN cc.confirm_status = 1
                    AND cc.usage_status = 0
                    THEN cc.coupon_amt
                    ELSE 0
                END
            ),0) AS UNSIGNED) AS available_amt,

            CAST(COALESCE(COUNT(
                CASE
                    WHEN cc.confirm_status = 1
                    AND cc.usage_status = 0
                    THEN cc.id
                END
            ),0) AS UNSIGNED) AS available_coupons,

            CAST(COALESCE(SUM(
                CASE
                    WHEN cc.confirm_status = 1
                    AND cc.usage_status = 1
                    THEN cc.coupon_amt
                    ELSE 0
                END
            ),0) AS UNSIGNED) AS used_amt,

            CAST(COALESCE(COUNT(
                CASE
                    WHEN cc.confirm_status = 1
                    AND cc.usage_status = 1
                    THEN cc.id
                END
            ),0) AS UNSIGNED) AS used_coupons

        FROM ca_customer c

        INNER JOIN cu_coupons cc
            ON cc.user_id = c.ca_customer_id

        WHERE
            c.status IN (1,3)
            AND cc.confirm_status = 1

        GROUP BY
            c.ca_customer_id,
            c.firstname,
            c.lastname,
            c.customer_type,
            c.profile_pic,
            c.status

        ORDER BY c.id DESC
    ");

    $sqlCustCoupon->execute();

    $rows = $sqlCustCoupon->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode([
        "data" => $rows
    ], JSON_NUMERIC_CHECK);

?>