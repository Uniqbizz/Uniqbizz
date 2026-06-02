<!-- query -->
SELECT
    lc.id,
    bt.id,
    lc.code,
    lc.coupon_amt,
    lc.created_date AS earned_date,
    lc.expiry_date,

    bt.order_id,
    bt.date AS travel_date,
    bt.created_date AS booking_date,

    p.name AS package_name,
    p.destination,

    bm.name AS traveller_name,
    bm.age,
    bm.gender,

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
AND lc.user_id = 'CU250042'

ORDER BY lc.created_date DESC