<?php
    include_once(__DIR__ . '/../../dashboard_user_details.php');
    $coupon_card_type = $_POST['card_type'];
    header('Content-Type: application/json');
    if($coupon_card_type == 'pcw'){

        /*
        GET USED ENTRIES FIRST
        */
        $sqlUsedCoupons = $conn->prepare("

            SELECT
                cu.transaction_id,
                COUNT(c.code) AS coupon_count,
                SUM(c.coupon_amt) AS coupon_amt,
                MAX(c.used_date) AS used_date,
                MAX(c.created_date) AS created_date,
                MAX(cu.used_on) AS used_on,
                c.user_id,
                1 AS usage_status

            FROM cu_coupons c

            INNER JOIN coupon_utilization cu
                ON c.code = cu.coupon_code

            WHERE c.user_id = :user_id
            AND c.usage_status = 1

            GROUP BY
                cu.transaction_id,
                c.user_id

            ORDER BY MAX(c.used_date) DESC

            LIMIT 3
        ");

        $sqlUsedCoupons->execute([
            ":user_id" => $userId
        ]);

        $usedCoupons = $sqlUsedCoupons->fetchAll(PDO::FETCH_ASSOC);


        /*
        TOTAL COUPON DATA
        */
        $sqlCouponTotal = $conn->prepare("

            SELECT

                COUNT(*) AS total_coupon_count,

                COALESCE(
                    SUM(coupon_amt),
                    0
                ) AS total_coupon_amount,

                COUNT(
                    CASE
                        WHEN usage_status = 1
                        THEN 1
                    END
                ) AS used_coupon_count,

                COALESCE(
                    SUM(
                        CASE
                            WHEN usage_status = 1
                            THEN coupon_amt
                            ELSE 0
                        END
                    ),
                    0
                ) AS used_coupon_amount

            FROM cu_coupons

            WHERE user_id = :user_id
        ");

        $sqlCouponTotal->execute([
            ":user_id" => $userId
        ]);

        $couponTotals = $sqlCouponTotal->fetch(PDO::FETCH_ASSOC);


        /*
        FINAL ARRAY
        */
        $allCoupons = [];

        foreach ($usedCoupons as $coupon) {

            $coupon['entry_type'] = 'used_coupon';

            $allCoupons[] = $coupon;
        }


        /*
        IF LESS THAN 3 ENTRIES
        ADD MEMBERSHIP ENTRY
        */
        if (count($allCoupons) < 3) {

            $allCoupons[] = [

                "transaction_id" => null,

                "coupon_count" =>
                    $couponTotals['total_coupon_count'],

                "coupon_amt" =>
                    $couponTotals['total_coupon_amount'],

                "usage_status" => 0,

                "created_date" =>
                    !empty($usedCoupons)
                        ? $usedCoupons[0]['created_date']
                        : date("Y-m-d H:i:s"),

                "used_date" => null,

                "user_id" => $userId,

                "used_on" => null,

                "entry_type" => "membership_activation",

                "code" => "MEMBERSHIP"
            ];
        }

        $allCoupons = array_slice($allCoupons, 0, 3);


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

        /*
        GET LATEST COUPONS
        USED + UNUSED
        EACH COUPON IS A SEPARATE ENTRY
        */
        $sqlCoupons = $conn->prepare("

            SELECT
                c.code,
                c.coupon_amt,
                c.usage_status,
                c.created_date,
                c.used_date,
                c.user_id,
                cu.used_on,
                cu.transaction_id,
                1 AS coupon_count

            FROM loyalty_coupon c

            LEFT JOIN loyalty_coupon_utilization cu
                ON c.code = cu.coupon_code

            WHERE c.user_id = :user_id

            ORDER BY
                CASE
                    WHEN c.usage_status = 1 THEN c.used_date
                    ELSE c.created_date
                END DESC

            LIMIT 3
        ");

        $sqlCoupons->execute([
            ":user_id" => $userId
        ]);

        $coupons = $sqlCoupons->fetchAll(PDO::FETCH_ASSOC);


        /*
        FINAL ARRAY
        */
        $allCoupons = [];


        /*
        FORMAT ENTRIES
        */
        foreach ($coupons as $coupon) {

            $coupon['entry_type'] =
                ($coupon['usage_status'] == 1)
                ? 'used_coupon'
                : 'credited';

            $allCoupons[] = $coupon;
        }


        /*
        IF TOTAL ENTRIES ARE LESS THAN 3
        FILL REMAINING WITH PLACEHOLDER
        */
        if ($allCoupons) {
            while (count($allCoupons) < 3) {
    
                $allCoupons[] = [
    
                    "code" => "Credited",
    
                    "coupon_amt" => null,
    
                    "usage_status" => 0,
    
                    "created_date" => date("Y-m-d H:i:s"),
    
                    "used_date" => null,
    
                    "user_id" => $userId,
    
                    "used_on" => null,
    
                    "transaction_id" => null,
    
                    "coupon_count" => 1,
    
                    "entry_type" => "credited"
                ];
            }
        }


        /*
        FINAL RESPONSE
        */
        echo json_encode([

            "status" => true,

            "data" => [

                "all_coupons" => $allCoupons
            ]
        ]);
    }elseif ($coupon_card_type == 'rw'){
        $sqlRefEntries = $conn->prepare("

            SELECT 
                ru.created_date,

                CASE 
                    WHEN ru.used_on IS NULL 
                        OR ru.used_on = ''
                    THEN ru.earned_on
                    ELSE ru.used_on
                END AS message,

                CASE 
                    WHEN ru.used_amount IS NULL
                    THEN ru.earned_amount
                    ELSE ru.used_amount
                END AS amount,

                ru.transaction_id AS enchased_id,
                ru.balance,

                CASE 
                
                    WHEN SUBSTRING(ru.transaction_id,1,2) = 'CU' THEN
                        'Direct Referral Bonus'

                    WHEN SUBSTRING(ru.transaction_id,1,2) = 'WD' THEN
                        'Withdrawal Request'

                    ELSE
                        'Referred Customer Trip Completed'

                END AS entry_type,

                CASE 
                
                    WHEN SUBSTRING(ru.transaction_id,1,2) = 'CU' THEN
                        (
                            SELECT status 
                            FROM customer_reference_payout 
                            WHERE ru.transaction_id = refered_customer_id
                            LIMIT 1
                        )

                    WHEN SUBSTRING(ru.transaction_id,1,2) = 'WD' THEN
                        (
                            SELECT status 
                            FROM customer_reference_wallet_encashed 
                            WHERE ru.transaction_id = transaction_id
                            LIMIT 1
                        )

                    ELSE
                        (
                            SELECT cu1_status 
                            FROM product_payout 
                            WHERE ru.transaction_id = order_id
                            LIMIT 1
                        )

                END AS status

            FROM customer_reference_wallet_utilization ru

            WHERE ru.customer_id = :user_id

            ORDER BY ru.created_date DESC

        ");

        $sqlRefEntries->execute([
            ":user_id" => $userId
        ]);

        $rows = $sqlRefEntries->fetchAll(PDO::FETCH_ASSOC);

        $data = [];

        foreach ($rows as $row) {

            $data[] = [

                "entry_type" => $row['entry_type'],

                "created_date" => date(
                    'd M Y h:i A',
                    strtotime($row['created_date'])
                ),

                "message" => $row['message'],

                "amount" => number_format(
                    (float)$row['amount'],
                    2
                ),
                "balance"=>$row['balance'],

                "status" => $row['status'] ?? '-',

                "reference_id" => $row['enchased_id'] ?? '-'
            ];
        }

        echo json_encode([
            "status" => true,
            "data" => $data
        ]);
    }elseif ($coupon_card_type == 'dw') {

        $sqlDiscountWallet = $conn->prepare("

            SELECT 
                cwu.*,

                CASE 
                    WHEN cwu.used_amount IS NOT NULL 
                        AND cwu.used_amount != ''
                    THEN cwu.used_amount

                    ELSE cwu.earned_amount
                END AS amount,

                CASE 
                    WHEN cwu.used_on IS NOT NULL 
                        AND cwu.used_on != ''
                    THEN cwu.used_on

                    ELSE cwu.earned_on
                END AS message,

                CASE 

                    WHEN cwu.used_on IS NOT NULL 
                        AND cwu.used_on != ''
                    THEN 'Used'

                    WHEN cdw.status = 0
                    THEN 'Pending'

                    WHEN cdw.status = 1
                    THEN 'Credited'

                    ELSE 'Unknown'

                END AS wallet_status

            FROM customer_discount_wallet_utilization cwu

            LEFT JOIN customer_discount_wallet cdw
                ON cwu.transaction_id = cdw.id

            WHERE cwu.customer_id = :user_id

            ORDER BY cwu.created_date DESC
        ");

        $sqlDiscountWallet->execute([
            ":user_id" => $userId
        ]);

        $discountWallet =
            $sqlDiscountWallet->fetchAll(PDO::FETCH_ASSOC);

        /*
        FINAL ARRAY
        */
        $data = [];

        foreach ($discountWallet as $row) {

            $data[] = [

                "id"                => $row['id'] ?? null,

                "amount"            => $row['amount'],

                "message"           => $row['message'],

                "wallet_status"     => $row['wallet_status'],

                "earned_amount"     => $row['earned_amount'],

                "used_amount"       => $row['used_amount'],

                "earned_on"         => $row['earned_on'],

                "used_on"           => $row['used_on'],

                "balance"           => $row['balance'],

                "created_date"      => $row['created_date'],

                "created_date_text" => date(
                    "d M Y h:i A",
                    strtotime($row['created_date'])
                )
            ];
        }

        echo json_encode([

            "status" => true,

            "data" => $data
        ]);
    }else {
        echo json_encode([

            "status" => false,

            "data" => "Invalid Params"
        ]);
    }
?>