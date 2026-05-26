<?php
    include_once(__DIR__ . '/../../dashboard_user_details.php');
    $coupon_card_type = $_POST['card_type'];

    if($coupon_card_type == 'pcw'){

        /*
        GET USED ENTRIES FIRST
        */
        $sqlUsedCoupons = $conn->prepare("

            SELECT 
                c.code,
                c.coupon_amt,
                c.usage_status,
                c.created_date,
                c.used_date,
                c.user_id,
                cu.used_on,
                cu.transaction_id

            FROM cu_coupons c

            LEFT JOIN coupon_utilization cu 
                ON c.code = cu.coupon_code

            WHERE c.user_id = :user_id
            AND c.usage_status = 1

            ORDER BY c.used_date DESC

            LIMIT 3
        ");

        $sqlUsedCoupons->execute([
            ":user_id" => $userId
        ]);

        $usedCoupons =
            $sqlUsedCoupons->fetchAll(PDO::FETCH_ASSOC);


        /*
        TOTAL COUPON DATA
        */
        $sqlCouponTotal = $conn->prepare("

            SELECT 

                COUNT(*) AS total_coupon_count,

                COALESCE(SUM(coupon_amt), 0)
                AS total_coupon_amount,

                COUNT(
                    CASE 
                        WHEN usage_status = 1 
                        THEN 1
                    END
                ) AS used_coupon_count,

                COALESCE(SUM(
                    CASE 
                        WHEN usage_status = 1 
                        THEN coupon_amt 
                        ELSE 0 
                    END
                ), 0) AS used_coupon_amount

            FROM cu_coupons

            WHERE user_id = :user_id
        ");

        $sqlCouponTotal->execute([
            ":user_id" => $userId
        ]);

        $couponTotals =
            $sqlCouponTotal->fetch(PDO::FETCH_ASSOC);


        /*
        FINAL ARRAY
        */
        $allCoupons = [];


        /*
        ADD USED ENTRIES
        */
        foreach($usedCoupons as $coupon){

            $allCoupons[] = $coupon;
        }


        /*
        IF USED ENTRIES ARE LESS THAN 3
        ADD MEMBERSHIP ACTIVATION ENTRY
        */
        if(count($usedCoupons) < 3){

            $remainingSlots =
                3 - count($usedCoupons);

            // ONLY ADD ONCE
            $allCoupons[] = [

                "code" => "MEMBERSHIP",

                "coupon_amt" =>
                    $couponTotals['total_coupon_amount'],

                "coupon_count" =>
                    $couponTotals['total_coupon_count'],

                "usage_status" => 0,

                "created_date" =>
                    !empty($usedCoupons)
                    ? $usedCoupons[0]['created_date']
                    : date("Y-m-d H:i:s"),

                "used_date" => null,

                "user_id" => $userId,

                "used_on" => null,

                "transaction_id" => null,

                "entry_type" => "membership_activation"
            ];
        }


        /*
        LIMIT TOTAL TO 3
        */
        $allCoupons =
            array_slice($allCoupons, 0, 3);


        /*
        FINAL RESPONSE
        */
        echo json_encode([

            "status" => true,

            "data" => [

                "all_coupons" => $allCoupons,

                "total_coupon_amount" =>
                    $couponTotals['total_coupon_amount'],

                "used_coupon_amount" =>
                    $couponTotals['used_coupon_amount']
            ]
        ]);
    }elseif ($coupon_card_type == 'lcw') {

    }

?>