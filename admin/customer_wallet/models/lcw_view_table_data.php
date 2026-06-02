<?php

    include (__DIR__.'/../../connect.php');

    $cust_id = $_POST['customer_id'] ?? '';
    $status      = $_POST['status'] ?? 'all';
    $start_date  = $_POST['start_date'] ?? '';
    $end_date    = $_POST['end_date'] ?? '';

    $statusCondition = '';

    switch(strtolower($status))
    {
        case 'available':
            $statusCondition = "
                AND lc.usage_status = 0
                AND lc.expiry_date >= NOW()
                AND NOT EXISTS (
                    SELECT 1
                    FROM cu_coupons cc
                    WHERE cc.user_id = lc.user_id
                    AND cc.confirm_status = 1
                    AND cc.usage_status = 0
                )
            ";
        break;

        case 'used':
            $statusCondition = "
                AND lc.usage_status = 1
            ";
        break;

        case 'expired':
            $statusCondition = "
                AND lc.usage_status = 0
                AND lc.expiry_date < NOW()
            ";
        break;

        case 'locked':
            $statusCondition = "
                AND lc.usage_status = 0
                AND lc.expiry_date >= NOW()
                AND EXISTS (
                    SELECT 1
                    FROM cu_coupons cc
                    WHERE cc.user_id = lc.user_id
                    AND cc.confirm_status = 1
                    AND cc.usage_status = 0
                )
            ";
        break;
    }
    $dateCondition = '';

    if(!empty($start_date) && !empty($end_date))
    {
        $dateCondition = "
            AND DATE(lc.created_date)
            BETWEEN :start_date AND :end_date
        ";
    }
    $sqlViewCustLoyaltyCoupon = $conn->prepare("
        SELECT
            lc.id,
            lc.code,
            lc.coupon_amt,
            lc.created_date AS earned_date,
            lc.expiry_date,

            bt.id AS booking_id,
            bt.order_id,
            bt.date AS travel_date,
            bt.created_date AS booking_date,

            p.name AS package_name,
            p.destination,

            GROUP_CONCAT(
                DISTINCT CONCAT(
                    bm.name,
                    '||',
                    bm.age,
                    '||',
                    bm.gender
                )
                SEPARATOR '##'
            ) AS travellers,

            CASE

                WHEN lc.usage_status = 1
                THEN 'Used'

                WHEN lc.usage_status = 0
                AND lc.expiry_date < NOW()
                THEN 'Expired'

                WHEN lc.usage_status = 0
                AND EXISTS (
                    SELECT 1
                    FROM cu_coupons cc
                    WHERE cc.user_id = lc.user_id
                    AND cc.confirm_status = 1
                    AND cc.usage_status = 0
                )
                THEN 'Locked'

                ELSE 'Available'

            END AS coupon_status

        FROM loyalty_coupon lc

        LEFT JOIN bookings bt
            ON bt.order_id = lc.payment_id

        LEFT JOIN package p
            ON p.id = bt.package_id

        LEFT JOIN booking_member_details bm
            ON bm.bookings_id = bt.id

        WHERE lc.confirm_status = 1
        AND lc.user_id = :user_id
        {$statusCondition}
        {$dateCondition}

        GROUP BY
            lc.id,
            lc.code,
            lc.coupon_amt,
            lc.created_date,
            lc.expiry_date,
            bt.id,
            bt.order_id,
            bt.date,
            bt.created_date,
            p.name,
            p.destination

        ORDER BY lc.created_date DESC
    ");

    $params = [
        ':user_id' => $cust_id
    ];

    if(!empty($start_date) && !empty($end_date))
    {
        $params[':start_date'] = $start_date;
        $params[':end_date']   = $end_date;
    }

    $sqlViewCustLoyaltyCoupon->execute($params);
    $rows = $sqlViewCustLoyaltyCoupon->fetchAll(PDO::FETCH_ASSOC);

    $data = [];

    foreach($rows as $row)
    {
        $travellers = [];

        if(!empty($row['travellers']))
        {
            foreach(explode('##', $row['travellers']) as $traveller)
            {
                $parts = explode('||', $traveller);

                $travellers[] = [
                    'name'   => $parts[0] ?? '',
                    'age'    => $parts[1] ?? '',
                    'gender' => $parts[2] ?? ''
                ];
            }
        }

        /* Days Left */
        if($row['coupon_status'] === 'Expired')
        {
            $daysLeft = 'Expired';
        }
        else
        {
            $days = floor(
                (strtotime($row['expiry_date']) - time()) / 86400
            );

            $daysLeft = $days . ' Days Left';
        }

        $data[] = [

            /* Main Table */
            'earned_date' => date(
                'd M Y, h:i A',
                strtotime($row['earned_date'])
            ),

            'coupon_count' => 1,

            'coupon_total' => (int)$row['coupon_amt'],

            'coupon_status' => $row['coupon_status'],

            'expiry_date' => date(
                'd M Y',
                strtotime($row['expiry_date'])
            ),

            'days_left' => $daysLeft,

            /* Booking Info */
            'order_id' => $row['order_id'] ?? '',

            'booking_id' => $row['booking_id'] ?? '',

            'package_name' => $row['package_name'] ?? 'N/A',

            'destination' => $row['destination'] ?? '',

            'travel_date' => !empty($row['travel_date'])
                ? date('d M Y', strtotime($row['travel_date']))
                : '',

            'booking_date' => !empty($row['booking_date'])
                ? date('d M Y', strtotime($row['booking_date']))
                : '',

            /* Child Table */
            'traveller_count' => count($travellers),

            'travellers' => $travellers,
            'coupon_total' => (int)$row['coupon_amt'] * count($travellers),

            'coupons' => [
                [
                    'code' => $row['code'],
                    'coupon_amt' => (int)$row['coupon_amt']
                    
                ]
            ]
        ];
    }

    header('Content-Type: application/json');

    echo json_encode([
        'data' => $data
    ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

    exit;
?>