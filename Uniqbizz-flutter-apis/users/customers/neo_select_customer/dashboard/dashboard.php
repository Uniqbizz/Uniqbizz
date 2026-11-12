<?php
header('Content-Type: application/json');
require '../../../../../connect.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode([
        "status" => "error",
        "message" => "Invalid request method"
    ]);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);

if (!$data) {
    echo json_encode([
        "status" => "error",
        "message" => "Invalid JSON data"
    ]);
    exit;
}

// Get user_id from input data
$userId = isset($data['userId']) ? $data['userId'] : '';

if (empty($userId)) {
    echo json_encode([
        "status" => "error",
        "message" => "User ID is required"
    ]);
    exit;
}

// customer user id is taken from the input
$sqlCust = $conn->prepare("SELECT * FROM ca_customer WHERE ca_customer_id = ?");
$sqlCust->execute([$userId]);
$customer = $sqlCust->fetch(PDO::FETCH_ASSOC);

if (!$customer) {
    echo json_encode([
        "status" => "error",
        "message" => "Customer not found"
    ]);
    exit;
}

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

//coupons detailed
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
        ) AS coupon_total_value,

        (
            SELECT COALESCE(SUM(coupon_amt), 0)
            FROM cu_coupons
            WHERE user_id = :user_id
            AND usage_status = 0
        ) AS coupon_availible_value

    FROM cu_coupons
    WHERE user_id = :user_id
");

$sqlCoupons->execute([":user_id" => $userId]);
$couponData = $sqlCoupons->fetch(PDO::FETCH_ASSOC);

$cust_regiter_date = date('j M Y', strtotime($customer['register_date']));
$expiry_date = isset($couponData['expiry_date']) ? date('j M Y', strtotime($couponData['expiry_date'])) : '';

//loyalty coupons
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

$sqlCustTa->execute([":userID" => $customer['ta_reference_no']]);
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

$sqlRefTotal->execute([":user_id" => $userId]);
$refTotal = $sqlRefTotal->fetch(PDO::FETCH_ASSOC);

// ACCESS VALUE
$totalReferralAmount = $refTotal['total_referral_earning'];

$response = [
    "status" => true,
    "message" => "Customer dashboard data fetched successfully",
    "data" => [
        /* ================= CUSTOMER ================= */
        "customer" => [
            "customer_id"        => $customer['ca_customer_id'] ?? '',
            "firstname"          => $customer['firstname'] ?? '',
            "lastname"           => $customer['lastname'] ?? '',
            "email"              => $customer['email'] ?? '',
            "contact_no"         => $customer['contact_no'] ?? '',
            "country_code"       => $customer['country_code'] ?? '',
            "membership_type"    => $customer['membership_type'] ?? '',
            "profile_pic"        => $customer['profile_pic'] ?? '',
            "register_date"      => $cust_regiter_date,
            "ta_reference_no"    => $customer['ta_reference_no'] ?? ''
        ],

        /* ================= NORMAL COUPONS ================= */
        "coupons" => [
            "total_coupons"      => (int)($couponData['coupon_total'] ?? 0),
            "active_coupons"     => (int)($couponData['active_coupon_total'] ?? 0),
            "used_coupons"       => (int)($couponData['used_coupon_total'] ?? 0),
            "total_value"        => (float)($couponData['coupon_total_value'] ?? 0),
            "availible_value"    => (float)($couponData['coupon_availible_value'] ?? 0)
        ],

        /* ================= Wallet Balance ================= */
         "wallet_balance" => (float)($disWalletData['balance'] ?? 0) + (float)($refWalletCurBalData['ref_booking_total'] ?? 0) + (float)($refWalletData['ref_total_earning'] ?? 0),

        /* ================= TC / TA DETAILS ================= */
        "travel_consultant" => [
            "user_id"       => $customerTa['user_id'] ?? '',
            "firstname"     => $customerTa['firstname'] ?? '',
            "lastname"      => $customerTa['lastname'] ?? '',
            "email"         => $customerTa['email'] ?? '',
            "contact_no"    => $customerTa['contact_no'] ?? '',
            "country_code"  => $customerTa['country_code'] ?? '',
            "profile_pic"   => $customerTa['profile_pic'] ?? ''
        ],

        /* ================= PACKAGES ================= */
        "packages" => $package_array,

        /* ================= REFERENCE WALLET ================= */
        "referral_card" => [
            "total_referrals"       => (int)($refWalletData['ref_count'] ?? 0),
            "total_referral_earnings" => (float)($refWalletData['ref_total_earning'] ?? 0),
        ],
    ]
];

echo json_encode(
    $response,
    JSON_PRETTY_PRINT
);
?>