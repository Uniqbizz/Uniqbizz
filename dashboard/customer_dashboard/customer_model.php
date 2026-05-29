<?php
    $sqlCust = $conn->prepare("SELECT * FROM ca_customer WHERE ca_customer_id = ?");

    $sqlCust->execute([$userId]);
    $customer = $sqlCust->fetch(PDO::FETCH_ASSOC);
    //coupons
    $sqlCoupons = $conn->prepare("
        SELECT 
            COUNT(id) AS coupon_total,
            SUM(CASE WHEN usage_status = 0 THEN 1 ELSE 0 END) AS active_coupon_total
        FROM cu_coupons
        WHERE user_id = ?
    ");

    $sqlCoupons->execute([$userId]);

    $couponData = $sqlCoupons->fetch(PDO::FETCH_ASSOC);
    //coupons
    $sqlCoupons = $conn->prepare("
        SELECT 
            *,
            (
                SELECT COUNT(*)
                FROM cu_coupons
                WHERE user_id = :user_id
            ) AS coupon_total,

            (
                SELECT COUNT(*)
                FROM cu_coupons
                WHERE user_id = :user_id
                AND usage_status = 0
            ) AS active_coupon_total,

            (
                SELECT COUNT(*)
                FROM cu_coupons
                WHERE user_id = :user_id
                AND usage_status = 1
            ) AS used_coupon_total,

            (
                SELECT COALESCE(SUM(coupon_amt), 0)
                FROM cu_coupons
                WHERE user_id = :user_id
            ) AS coupon_total_value

        FROM cu_coupons

        WHERE user_id = :user_id
    ");

    $sqlCoupons->execute([":user_id" => $userId]);

    $couponData = $sqlCoupons->fetch(PDO::FETCH_ASSOC);
    $cust_regiter_date=date('j M Y', strtotime($customer['register_date']));
    $expiry_date = date('j M Y', strtotime($couponData['expiry_date']));
    //loyaty coupons
    $sqlLoyaltyCoupons = $conn->prepare("
        SELECT 
            *,
            (
                SELECT COUNT(*)
                FROM loyalty_coupon
                WHERE user_id = :user_id
            ) AS coupon_total,

            (
                SELECT COUNT(*)
                FROM loyalty_coupon
                WHERE user_id = :user_id
                AND usage_status = 0
                AND expiry_date >= NOW()
            ) AS active_coupon_total,

            (
                SELECT COUNT(*)
                FROM loyalty_coupon
                WHERE user_id = :user_id
                AND usage_status = 1
            ) AS used_coupon_total,
            (
                SELECT COUNT(*)
                FROM loyalty_coupon
                WHERE user_id = :user_id
                AND expiry_date < NOW()
                AND usage_status = 0
            ) AS expired_coupon_total,
            (
                SELECT COALESCE(SUM(coupon_amt), 0)
                FROM loyalty_coupon
                WHERE user_id = :user_id
            ) AS coupon_total_value,
            (
                SELECT COALESCE(SUM(coupon_amt), 0)
                FROM loyalty_coupon
                WHERE user_id = :user_id
                AND usage_status = 0
                AND expiry_date >= NOW()
            ) AS active_total_value,
            (
                SELECT COALESCE(SUM(coupon_amt), 0)
                FROM loyalty_coupon
                WHERE user_id = :user_id
                AND usage_status = 1
            ) AS used_total_value,
             (
                SELECT COALESCE(SUM(coupon_amt), 0)
                FROM loyalty_coupon
                WHERE user_id = :user_id
                AND expiry_date < NOW()
                AND usage_status = 0
            ) AS expired_total_value

        FROM loyalty_coupon

        WHERE user_id = :user_id
    ");

    $sqlLoyaltyCoupons->execute([":user_id" => $userId]);

    $loyaltyCouponData = $sqlLoyaltyCoupons->fetch(PDO::FETCH_ASSOC);
    if($loyaltyCouponData){
        $loyaltyexpiry_date = date('j M Y', strtotime($loyaltyCouponData['expiry_date'])) ;
    }else{
        $loyaltyexpiry_date = '';
    }
    //reference wallet utilization 
    $sqlRefWalletCurBal = $conn->prepare("

        SELECT 
            balance,
            created_date,

            (
                SELECT COALESCE(SUM(earned_amount), 0)

                FROM customer_reference_wallet_utilization

                WHERE customer_id = :user_id

                AND transaction_id NOT LIKE 'CU%'

                AND transaction_id NOT LIKE 'WD%'

            ) AS ref_booking_total

        FROM customer_reference_wallet_utilization

        WHERE customer_id = :user_id

        ORDER BY created_date DESC

        LIMIT 1
    ");

    $sqlRefWalletCurBal->execute([":user_id" => $userId]);

    $refWalletCurBalData = $sqlRefWalletCurBal->fetch(PDO::FETCH_ASSOC);
    //
    //reference wallet
    $sqlRefWallet = $conn->prepare("
        SELECT 
            *,
            (
                SELECT COUNT(*)
                FROM customer_reference_payout
                WHERE referral_level = 'Level1'
                AND referral_amount IS NOT NULL
                AND customer_id=:user_id
            ) AS ref_count,
            (
                SELECT COALESCE(SUM(referral_amount), 0)
                FROM customer_reference_payout
                WHERE referral_level = 'Level1'
                AND customer_id=:user_id
            ) AS ref_total_earning

        FROM customer_reference_payout

        WHERE customer_id = :user_id
    ");

    $sqlRefWallet->execute([":user_id" => $userId]);

    $refWalletData = $sqlRefWallet->fetch(PDO::FETCH_ASSOC);
    //reference wallet encashment
    $sqlRefWalletEncash = $conn->prepare("
        SELECT 
            *,
            (
                SELECT COALESCE(SUM(encashed_amount), 0)
                FROM customer_reference_wallet_encashed
                WHERE customer_id=:user_id
            ) AS total_earning_echased

        FROM customer_reference_payout

        WHERE customer_id = :user_id
    ");

    $sqlRefWalletEncash->execute([":user_id" => $userId]);
    $refWalletEncashData = $sqlRefWalletEncash->fetch(PDO::FETCH_ASSOC);
    //discount wallet encashment
    $sqlDisWallet = $conn->prepare("
        SELECT balance,id,
        (   SELECT COALESCE(SUM(earned_amount), 0)
            FROM customer_discount_wallet_utilization
            WHERE customer_id=:user_id
        ) AS total_discount_earned,
        (   SELECT COALESCE(SUM(used_amount), 0)
            FROM customer_discount_wallet_utilization
            WHERE customer_id=:user_id
        ) AS total_discount_used
        FROM customer_discount_wallet_utilization
        WHERE customer_id=:user_id
        ORDER BY id DESC
        LIMIT 1
    ");

    $sqlDisWallet->execute([":user_id" => $userId]);

    $disWalletData = $sqlDisWallet->fetch(PDO::FETCH_ASSOC);
    //customers tc
    $sqlCustTa = $conn->prepare("SELECT ca_travelagency_id AS user_id,email,contact_no,firstname,lastname,country_code,user_type,profile_pic FROM ca_travelagency WHERE ca_travelagency_id = :userID
                                    UNION
                                SELECT institution_branch_manager_id AS user_id,email,contact_no,firstname,lastname,country_code,user_type,profile_pic FROM institution_branch_manager WHERE institution_branch_manager_id = :userID
    ");

    $sqlCustTa->execute([
        ":userID" => $customer['ta_reference_no']]);
    $customerTa = $sqlCustTa->fetch(PDO::FETCH_ASSOC);
    // Get latest 12 packages
    $sqlPack = $conn->prepare("
        SELECT * 
        FROM package 
        ORDER BY id DESC 
        LIMIT 12
    ");
    
    $sqlPack->execute();
    
    $packages = $sqlPack->fetchAll(PDO::FETCH_ASSOC);
    
    $package_array = [];
    
    foreach ($packages as $package) {
    
        // Get package price
        $sqlPackPrice = $conn->prepare("
            SELECT total_package_price_per_adult
            FROM package_pricing
            WHERE package_id = ?
            ORDER BY id DESC
            LIMIT 1
        ");
    
        $sqlPackPrice->execute([$package['id']]);
    
        $packagePrice = $sqlPackPrice->fetch(PDO::FETCH_ASSOC);
    
        // Get first package image
        $sqlPackImage = $conn->prepare("
            SELECT image
            FROM package_pictures
            WHERE package_id = ?
            ORDER BY id ASC
            LIMIT 1
        ");
    
        $sqlPackImage->execute([$package['id']]);
    
        $packageImage = $sqlPackImage->fetch(PDO::FETCH_ASSOC);
    
        // Calculate duration
        $days = (int)$package['tour_days'];
        $nights = $days - 1;
    
        $package_duration = $nights . "N / " . $days . "D";
    
        // Store in multidimensional array
        $package_array[] = [
            "packid"    => $package['id'],
            "packname"  => $package['name'],
            "duration"  => $package_duration,
            "price"     => $packagePrice['total_package_price_per_adult'] ?? 0,
            "image"     => $packageImage['image'] ?? ''
        ];
    }

    //customer total ref amount
    $sqlRefTotal = $conn->prepare("
        SELECT 
            COALESCE(SUM(referral_amount), 0) AS total_referral_earning
        FROM customer_reference_payout
        WHERE customer_id = :user_id
    ");

    $sqlRefTotal->execute([
        ":user_id" => $userId
    ]);

    $refTotal = $sqlRefTotal->fetch(PDO::FETCH_ASSOC);

    // ACCESS VALUE
    $totalReferralAmount =
        $refTotal['total_referral_earning'];
       
    
?>