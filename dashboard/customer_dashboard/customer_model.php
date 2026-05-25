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