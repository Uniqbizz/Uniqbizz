<?php

header('Content-Type: application/json');
require '../../../../connect.php';

$response = [
    'status' => false,
    'message' => '',
    'data' => []
];

try {

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception("Invalid request method");
    }

    $data = json_decode(file_get_contents("php://input"), true);

    $userId = $data['userId'] ?? '';

    if (empty($userId)) {
        throw new Exception("Missing 'userId' parameter.");
    }

    /* ================= CUSTOMER ================= */

    $sqlCust = $conn->prepare("
        SELECT *
        FROM ca_customer
        WHERE ca_customer_id = ?
    ");

    $sqlCust->execute([$userId]);
    $customer = $sqlCust->fetch(PDO::FETCH_ASSOC);

    if (!$customer) {
        throw new Exception("Customer not found.");
    }

    $custRegisterDate = !empty($customer['register_date'])
        ? date('j M Y', strtotime($customer['register_date']))
        : '';

    /* ================= COUPONS ================= */

    $sqlCoupons = $conn->prepare("
        SELECT
            COUNT(*) AS coupon_total,

            SUM(
                CASE
                    WHEN usage_status = 0 THEN 1
                    ELSE 0
                END
            ) AS active_coupon_total,

            SUM(
                CASE
                    WHEN usage_status = 1 THEN 1
                    ELSE 0
                END
            ) AS used_coupon_total,

            COALESCE(SUM(coupon_amt),0) AS coupon_total_value,

            MAX(expiry_date) AS expiry_date

        FROM cu_coupons

        WHERE user_id = :user_id
    ");

    $sqlCoupons->execute([
        ':user_id' => $userId
    ]);

    $couponData = $sqlCoupons->fetch(PDO::FETCH_ASSOC);

    $expiryDate = !empty($couponData['expiry_date'])
        ? date('j M Y', strtotime($couponData['expiry_date']))
        : '';

    /* ================= LOYALTY COUPONS ================= */

    $sqlLoyaltyCoupons = $conn->prepare("
        SELECT

            COUNT(*) AS coupon_total,

            SUM(
                CASE
                    WHEN usage_status = 0
                    AND expiry_date >= NOW()
                    THEN 1 ELSE 0
                END
            ) AS active_coupon_total,

            SUM(
                CASE
                    WHEN usage_status = 1
                    THEN 1 ELSE 0
                END
            ) AS used_coupon_total,

            SUM(
                CASE
                    WHEN usage_status = 0
                    AND expiry_date < NOW()
                    THEN 1 ELSE 0
                END
            ) AS expired_coupon_total,

            COALESCE(SUM(coupon_amt),0) AS coupon_total_value,

            COALESCE(
                SUM(
                    CASE
                        WHEN usage_status = 0
                        AND expiry_date >= NOW()
                        THEN coupon_amt
                    END
                ),
                0
            ) AS active_total_value,

            COALESCE(
                SUM(
                    CASE
                        WHEN usage_status = 1
                        THEN coupon_amt
                    END
                ),
                0
            ) AS used_total_value,

            COALESCE(
                SUM(
                    CASE
                        WHEN usage_status = 0
                        AND expiry_date < NOW()
                        THEN coupon_amt
                    END
                ),
                0
            ) AS expired_total_value,

            MAX(expiry_date) AS expiry_date

        FROM loyalty_coupon

        WHERE user_id = :user_id
    ");

    $sqlLoyaltyCoupons->execute([
        ':user_id' => $userId
    ]);

    $loyaltyCouponData = $sqlLoyaltyCoupons->fetch(PDO::FETCH_ASSOC);

    $loyaltyExpiryDate = !empty($loyaltyCouponData['expiry_date'])
        ? date('j M Y', strtotime($loyaltyCouponData['expiry_date']))
        : '';

    /* ================= REFERENCE WALLET ================= */

    $sqlRefWalletCurBal = $conn->prepare("
        SELECT
            balance,

            (
                SELECT COALESCE(SUM(earned_amount),0)
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

    $sqlRefWalletCurBal->execute([
        ':user_id' => $userId
    ]);

    $refWalletCurBalData = $sqlRefWalletCurBal->fetch(PDO::FETCH_ASSOC);

    $sqlRefWallet = $conn->prepare("
        SELECT

            COUNT(*) AS ref_count,

            COALESCE(SUM(referral_amount),0) AS ref_total_earning

        FROM customer_reference_payout

        WHERE customer_id = :user_id
        AND referral_level = 'Level1'
    ");

    $sqlRefWallet->execute([
        ':user_id' => $userId
    ]);

    $refWalletData = $sqlRefWallet->fetch(PDO::FETCH_ASSOC);

    $sqlRefWalletEncash = $conn->prepare("
        SELECT
            COALESCE(SUM(encashed_amount),0) AS total_earning_echased
        FROM customer_reference_wallet_encashed
        WHERE customer_id = :user_id
    ");

    $sqlRefWalletEncash->execute([
        ':user_id' => $userId
    ]);

    $refWalletEncashData = $sqlRefWalletEncash->fetch(PDO::FETCH_ASSOC);

    /* ================= DISCOUNT WALLET ================= */

    $sqlDisWallet = $conn->prepare("
        SELECT
            balance,

            (
                SELECT COALESCE(SUM(earned_amount),0)
                FROM customer_discount_wallet_utilization
                WHERE customer_id = :user_id
            ) AS total_discount_earned,

            (
                SELECT COALESCE(SUM(used_amount),0)
                FROM customer_discount_wallet_utilization
                WHERE customer_id = :user_id
            ) AS total_discount_used

        FROM customer_discount_wallet_utilization

        WHERE customer_id = :user_id

        ORDER BY id DESC

        LIMIT 1
    ");

    $sqlDisWallet->execute([
        ':user_id' => $userId
    ]);

    $disWalletData = $sqlDisWallet->fetch(PDO::FETCH_ASSOC);

    /* ================= TRAVEL CONSULTANT ================= */

    $sqlCustTa = $conn->prepare("
        SELECT
            ca_travelagency_id AS user_id,
            email,
            contact_no,
            firstname,
            lastname,
            country_code,
            user_type,
            profile_pic
        FROM ca_travelagency
        WHERE ca_travelagency_id = :userID

        UNION

        SELECT
            institution_branch_manager_id AS user_id,
            email,
            contact_no,
            firstname,
            lastname,
            country_code,
            user_type,
            profile_pic
        FROM institution_branch_manager
        WHERE institution_branch_manager_id = :userID
    ");

    $sqlCustTa->execute([
        ':userID' => $customer['ta_reference_no']
    ]);

    $customerTa = $sqlCustTa->fetch(PDO::FETCH_ASSOC);

    /* ================= PACKAGES ================= */

    $sqlPack = $conn->prepare("
        SELECT *
        FROM package
        ORDER BY id DESC
        LIMIT 12
    ");

    $sqlPack->execute();

    $packages = $sqlPack->fetchAll(PDO::FETCH_ASSOC);

    $packageArray = [];

    foreach ($packages as $package) {

        $sqlPackPrice = $conn->prepare("
            SELECT total_package_price_per_adult
            FROM package_pricing
            WHERE package_id = ?
            ORDER BY id DESC
            LIMIT 1
        ");

        $sqlPackPrice->execute([$package['id']]);
        $packagePrice = $sqlPackPrice->fetch(PDO::FETCH_ASSOC);

        $sqlPackImage = $conn->prepare("
            SELECT image
            FROM package_pictures
            WHERE package_id = ?
            ORDER BY id ASC
            LIMIT 1
        ");

        $sqlPackImage->execute([$package['id']]);
        $packageImage = $sqlPackImage->fetch(PDO::FETCH_ASSOC);

        $days = (int)$package['tour_days'];
        $nights = max(0, $days - 1);

        $packageArray[] = [
            "packid" => $package['id'],
            "packname" => $package['name'],
            "duration" => $nights . "N / " . $days . "D",
            "price" => (float)($packagePrice['total_package_price_per_adult'] ?? 0),
            "image" => $packageImage['image'] ?? ''
        ];
    }

    /* ================= REFERRAL TOTAL ================= */

    $sqlRefTotal = $conn->prepare("
        SELECT
            COALESCE(SUM(referral_amount),0) AS total_referral_earning
        FROM customer_reference_payout
        WHERE customer_id = :user_id
    ");

    $sqlRefTotal->execute([
        ':user_id' => $userId
    ]);

    $refTotal = $sqlRefTotal->fetch(PDO::FETCH_ASSOC);

    /* ================= RESPONSE ================= */

    $response['status'] = true;
    $response['message'] = 'Customer dashboard wallet data fetched successfully';

    $response['data'] = [

        "coupons" => [
            "total_coupons" => (int)($couponData['coupon_total'] ?? 0),
            "available_coupons" => (int)($couponData['active_coupon_total'] ?? 0),
            "total_value" => (float)($couponData['coupon_total_value'] ?? 0),
        ],

        "loyalty_coupons" => [
            "total_coupons" => (int)($loyaltyCouponData['coupon_total'] ?? 0),
            "available_coupons" => (int)($loyaltyCouponData['active_coupon_total'] ?? 0),
            "total_value" => (float)($loyaltyCouponData['coupon_total_value'] ?? 0),

        ],

        "reference_wallet" => [
            "current_balance" => (float)($refWalletData['ref_total_earning'] + (float)$refWalletCurBalData['ref_booking_total']),
            "withdrawable_balance" => ((float)($refWalletData['ref_total_earning'] + (float)$refWalletCurBalData['ref_booking_total']) - (float)($refWalletEncashData['total_earning_echased']))
        ],

        "discount_wallet" => [
            "current_balance" => (float)($disWalletData['balance'] ?? 0),
            "total_discount_earned" => (float)($disWalletData['total_discount_earned'] ?? 0)
        ],
    ];

} catch (Exception $e) {

    $response['status'] = false;
    $response['message'] = $e->getMessage();

}

echo json_encode(
    $response,
    JSON_UNESCAPED_UNICODE |
    JSON_UNESCAPED_SLASHES
);

?>