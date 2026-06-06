<?php

    include(__DIR__ . '/../../connect.php');

    $conditions = [];
    $having = [];
    $params = [];

    // Date filter
    if (!empty($_GET['start_date']) && !empty($_GET['end_date'])) {
        $fromDateObj = DateTime::createFromFormat('Y-m-d', $_GET['start_date']);
        $toDateObj   = DateTime::createFromFormat('Y-m-d', $_GET['end_date']);

        //changed on 28-05-2026 by SV
        if ($fromDateObj && $toDateObj) {

            // Same date
            if ($fromDateObj->format('Y-m-d') == $toDateObj->format('Y-m-d')) {

                $conditions[] = "register_date >= :from_start
                                AND register_date < :from_end";

                $params[':from_start'] = $fromDateObj->format('Y-m-d') . ' 00:00:00';

                $nextDay = clone $fromDateObj;
                $nextDay->modify('+1 day');

                $params[':from_end'] = $nextDay->format('Y-m-d') . ' 00:00:00';

            }
            // Different dates
            else {

                $conditions[] = "register_date BETWEEN :from AND :to";

                $params[':from'] = $fromDateObj->format('Y-m-d') . ' 00:00:00';
                $params[':to']   = $toDateObj->format('Y-m-d') . ' 23:59:59';
            }
        }
    }

    $status = $_GET['status'] ?? '';

    $sql = "
    SELECT
        c.ca_customer_id,
        CONCAT(c.firstname,' ',c.lastname) AS cust_name,
        c.customer_type,
        c.register_date,

        /* Total */
        COUNT(lc.id) AS total_coupons,
        COALESCE(SUM(lc.coupon_amt),0) AS total_amt,

        /* Available / Unlocked */
        COUNT(
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
                THEN 1
            END
        ) AS available_coupons,

        COALESCE(SUM(
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
        ),0) AS available_amt,

        /* Used */
        COUNT(
            CASE
                WHEN lc.usage_status = 1
                THEN 1
            END
        ) AS used_coupons,

        COALESCE(SUM(
            CASE
                WHEN lc.usage_status = 1
                THEN lc.coupon_amt
                ELSE 0
            END
        ),0) AS used_amt,

        /* Expired */
        COUNT(
            CASE
                WHEN lc.usage_status = 0
                AND lc.expiry_date < NOW()
                THEN 1
            END
        ) AS expired_coupons,

        COALESCE(SUM(
            CASE
                WHEN lc.usage_status = 0
                AND lc.expiry_date < NOW()
                THEN lc.coupon_amt
                ELSE 0
            END
        ),0) AS expired_amt,

        /* Locked */
        COUNT(
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
                THEN 1
            END
        ) AS locked_coupons,

        COALESCE(SUM(
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
        ),0) AS locked_amt,

        /* Customer Status */
        CASE

            WHEN COUNT(
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
                    THEN 1
                END
            ) > 0
            THEN 'Locked'

            WHEN COUNT(
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
                    THEN 1
                END
            ) > 0
            THEN 'Eligible / Unlocked'

            WHEN COUNT(
                CASE
                    WHEN lc.usage_status = 0
                    AND lc.expiry_date < NOW()
                    THEN 1
                END
            ) > 0
            THEN 'Expired'

            ELSE 'Used'

        END AS coupon_status

    FROM loyalty_coupon lc

    INNER JOIN ca_customer c
        ON c.ca_customer_id = lc.user_id
        AND c.status = 1

    WHERE lc.confirm_status = 1
    ";

    /* Additional WHERE Conditions */
    if (!empty($conditions))
    {
        $sql .= " AND " . implode(" AND ", $conditions);
    }

    /* Group By */
    $sql .= "
    GROUP BY
        c.ca_customer_id,
        c.firstname,
        c.lastname,
        c.customer_type,
        c.register_date
    ";

    /* Status Filter */
    if (!empty($status))
    {
        switch ($status)
        {
            case 'available':
                $having[] = "available_coupons > 0";
            break;

            case 'used':
                $having[] = "used_coupons > 0";
            break;

            case 'expired':
                $having[] = "expired_coupons > 0";
            break;

            case 'locked':
                $having[] = "locked_coupons > 0";
            break;
        }
    }

    /* HAVING */
    if (!empty($having))
    {
        $sql .= " HAVING " . implode(" AND ", $having);
    }

    /* Order */
    $sql .= " ORDER BY c.register_date DESC";

    $stmt = $conn->prepare($sql);
    $stmt->execute($params);

    header('Content-Type: application/json');
    $custLoyaltyCouponListdata = $stmt->fetchAll(PDO::FETCH_ASSOC);


    echo json_encode([
        'data' => $custLoyaltyCouponListdata
    ]);
    exit;
?>