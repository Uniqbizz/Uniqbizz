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
    if(!empty($start_date) && !empty($end_date))
    {
        $where[] = "DATE(c.register_date) BETWEEN :start_date AND :end_date";

        $params[':start_date'] = $start_date;
        $params[':end_date']   = $end_date;
    }

    $sql = "
        SELECT
            CONCAT(c.firstname, ' ', c.lastname) AS customer_name,
            c.ca_customer_id,
            c.customer_type,
            c.contact_no,

            COALESCE(cp.coupon_total, 0) AS coupon_total,
            COALESCE(cp.coupon_count, 0) AS coupon_count,

            COALESCE(lp.loyalty_coupon_total, 0) AS loyalty_coupon_total,
            COALESCE(lp.loyalty_count, 0) AS loyalty_count,

            COALESCE(rp.ref_total, 0) AS ref_total,
            COALESCE(rp.ref_count, 0) AS ref_count,

            COALESCE(dp.dis_total, 0) AS dis_total,
            COALESCE(dp.dis_count, 0) AS dis_count,

            0 AS ext_total,

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