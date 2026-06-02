<?php

    include (__DIR__.'/../../connect.php');

    $membership_type = $_GET['membership_type'] ?? 'all';
    $start_date      = $_GET['start_date'] ?? '';
    $end_date        = $_GET['end_date'] ?? '';

    $where = ["c.status = 1"];
    $params = [];

    /* Membership Filter */
    if($membership_type != '' && $membership_type != 'all')
    {
        $where[] = "c.customer_type = :customer_type";
        $params[':customer_type'] = $membership_type;
    }

    /* Date Filter */
    if (!empty($start_date) && !empty($end_date )) {
        $fromDateObj = DateTime::createFromFormat('Y-m-d', $start_date);
        $toDateObj   = DateTime::createFromFormat('Y-m-d', $end_date );

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

    $sql = "
        SELECT
            CONCAT(c.firstname, ' ', c.lastname) AS customer_name,
            c.ca_customer_id,
            c.customer_type,
            c.contact_no,

            CAST(COALESCE(cp.coupon_total, 0) AS UNSIGNED) AS coupon_total,
            CAST(COALESCE(cp.coupon_count, 0) AS UNSIGNED) AS coupon_count,

            CAST(COALESCE(lp.loyalty_coupon_total, 0) AS UNSIGNED) AS loyalty_coupon_total,
            CAST(COALESCE(lp.loyalty_count, 0) AS UNSIGNED) AS loyalty_count,

            CAST(COALESCE(rp.ref_total, 0) AS UNSIGNED) AS ref_total,
            CAST(COALESCE(rp.ref_count, 0) AS UNSIGNED) AS ref_count,

            CAST(COALESCE(dp.dis_total, 0) AS UNSIGNED) AS dis_total,
            CAST(COALESCE(dp.dis_count, 0) AS UNSIGNED) AS dis_count,

            CAST(COALESCE(etd.ext_total, 0) AS UNSIGNED) AS ext_total,
            CAST(COALESCE(etd.ext_count, 0) AS UNSIGNED) AS ext_count,

            c.profile_pic,
            c.register_date,
            c.status

        FROM ca_customer c

        LEFT JOIN (
            SELECT
                user_id,
                SUM(coupon_amt) AS coupon_total,
                COUNT(*) AS coupon_count
            FROM cu_coupons
            GROUP BY user_id
        ) cp ON cp.user_id = c.ca_customer_id

        LEFT JOIN (
            SELECT
                user_id,
                SUM(coupon_amt) AS loyalty_coupon_total,
                COUNT(*) AS loyalty_count
            FROM loyalty_coupon
            GROUP BY user_id
        ) lp ON lp.user_id = c.ca_customer_id

        LEFT JOIN (
            SELECT
                customer_id,
                SUM(earned_amount) AS ref_total,
                COUNT(*) AS ref_count
            FROM customer_reference_wallet_utilization
            GROUP BY customer_id
        ) rp ON rp.customer_id = c.ca_customer_id

        LEFT JOIN (
            SELECT
                customer_id,
                SUM(earn_amount) AS dis_total,
                COUNT(*) AS dis_count
            FROM customer_discount_wallet
            GROUP BY customer_id
        ) dp ON dp.customer_id = c.ca_customer_id

        LEFT JOIN (
            SELECT
                customer_id,
                SUM(earn_amount) AS ext_total,
                COUNT(*) AS ext_count
            FROM customer_extended_wallet
            GROUP BY customer_id
        ) etd ON etd.customer_id = c.ca_customer_id

        WHERE ".implode(' AND ', $where)."

        ORDER BY c.id DESC
    ";

    $stmt = $conn->prepare($sql);

    foreach($params as $key => $value)
    {
        $stmt->bindValue($key, $value);
    }

    $stmt->execute();

    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    header('Content-Type: application/json');

    echo json_encode([
        'data' => $data
    ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

exit;