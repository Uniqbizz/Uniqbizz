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
            COUNT(id) AS coupon_total,
            SUM(CASE WHEN usage_status = 0 THEN 1 ELSE 0 END) AS active_coupon_total
        FROM cu_coupons
        WHERE user_id = ?
    ");

    $sqlCoupons->execute([$userId]);

    $couponData = $sqlCoupons->fetch(PDO::FETCH_ASSOC);
    $cust_regiter_date=date('j F Y', strtotime($customer['register_date']));

    //customers tc
    $sqlCustTa = $conn->prepare("SELECT * FROM ca_travelagency WHERE ca_travelagency_id = :userID
                                    UNION
                                SELECT * FROM institution_branch_manager WHERE institution_branch_manager_id = :userID
    ");

    $sqlCustTa->execute([
        ":userID" => $customer['ta_reference_no']]);
    $customerTa = $sqlCustTa->fetch(PDO::FETCH_ASSOC);
?>