<?php
include(__DIR__ . '/../../connect.php');
function parseFaqTxt($filePath)
{
    if (!file_exists($filePath)) {
        return [];
    }

    $content = file_get_contents($filePath);

    preg_match_all('/Q:\s*(.*?)\s*A:\s*(.*?)(?=\n\s*Q:|$)/is', $content, $matches, PREG_SET_ORDER);

    $faqs = [];

    foreach ($matches as $match) {
        $faqs[] = [
            'question' => trim($match[1]),
            'answer'   => trim($match[2])
        ];
    }

    return $faqs;
}
//gst
$stmt = $conn->prepare("SELECT * FROM `gst` ORDER BY id DESC");
$stmt->execute();
$gst=$stmt->fetch();
// =====================================================
// DETERMINE PREFIX AND FETCH USER DETAILS
// =====================================================

$userDetails = [];
$customerType = '';
$prefix = '';

if (preg_match('/^(CU|TA|TE|CA|F|I|BM|BH|CTE|ETE|STE|IBR)/i', (string)$user_id, $matches)) {
    $prefix = strtoupper($matches[1]);
}

// Map prefix to the respective table.
// IMPORTANT: Set each id_column to the actual identifier column
// used by your database table.
$tableMap = [
    'CU'  => ['table' => 'ca_customer',                 'id_column' => 'ca_customer_id',                'type'=>'Customer'],
    'TA'  => ['table' => 'ca_travelagency',             'id_column' => 'ca_travelagency_id',            'type'=>'Travel Consultant'],
    'TE'  => ['table' => 'corporate_agency',            'id_column' => 'corporate_agency_id',           'type'=>'Techno Enterprise'],
    'CA'  => ['table' => 'corporate_agency',            'id_column' => 'corporate_agency_id',           'type'=>'Techno Enterprise'],
    'F'   => ['table' => 'sub_franchisee',              'id_column' => 'sub_franchisee_id',             'type'=>'Franchisee'],
    'I'   => ['table' => 'institution',                 'id_column' => 'institution_id',                'type'=>'Institution'],
    'IBR' => ['table' => 'institution_branch_manager',  'id_column' => 'institution_branch_manager_id', 'type'=>'Institution Branch manager'],
    'BM'  => ['table' => 'business_mentor',             'id_column' => 'business_mentor_id',            'type'=>'Business Mentor'],
    'BH'  => ['table' => 'employees',                   'id_column' => 'employee_id',                   'type'=>'Business Developement manager'],
    'CTE' => ['table' => 'chief_techno_enterprise',     'id_column' => 'chief_techno_enterprise_id',    'type'=>'Chief Techno Enterprise'],
    'ETE' => ['table' => 'executive_techno_enterprise', 'id_column' => 'executive_techno_enterprise_id','type'=>'Executive Techno Enterprise'],
    'STE' => ['table' => 'super_techno_enterprise',     'id_column' => 'super_techno_enterprise_id',    'type'=>'Super Techno Enterprise']
];
$Requester_type = 'Guest User';
if ($prefix !== '' && isset($tableMap[$prefix])) {

    $table = $tableMap[$prefix]['table'];
    $idColumn = $tableMap[$prefix]['id_column'];
    $Requester_type = $tableMap[$prefix]['type'];

    // Remove the prefix to get the numeric database ID.
    $numericId = substr((string)$user_id, strlen($prefix));

    if (ctype_digit($numericId) && (int)$numericId > 0) {

        // Table and column names come only from the fixed whitelist above.
        $sql = "SELECT * FROM `$table` WHERE `$idColumn` = :id LIMIT 1";

        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':id' => (int)$numericId
        ]);

        $userDetails = $stmt->fetch(PDO::FETCH_ASSOC) ?: [];

        // Determine customer type only for CU.
        if ($prefix === 'CU' && !empty($userDetails)) {
            $customerType = trim($userDetails['customer_type'] ?? '');
        }
    }
}

// =====================================================
// COUPONS AND WALLETS FOR CU
// =====================================================

$cuCoupons = [];
$loyaltyCoupons = [];
$referralBalance = 0;
$discountBalance = 0;

if (
    $prefix === 'CU' &&
    !empty($userDetails) &&
    isset($_SESSION['user_type_id_value']) &&
    (int)$_SESSION['user_type_id_value'] === 10
) {
    $stmt1 = $conn->prepare("
        SELECT *
        FROM cu_coupons
        WHERE user_id = :user_id
          AND usage_status = 0
          AND confirm_status = 1
    ");

    $stmt1->execute([':user_id' => $user_id]);
    $cuCoupons = $stmt1->fetchAll(PDO::FETCH_ASSOC);

    $stmt2 = $conn->prepare("
        SELECT *
        FROM loyalty_coupon
        WHERE user_id = :user_id
          AND usage_status = 0
          AND confirm_status = 1
    ");

    $stmt2->execute([':user_id' => $user_id]);
    $loyaltyCoupons = $stmt2->fetchAll(PDO::FETCH_ASSOC);

    // Neo Select customers only.
    if (strcasecmp($customerType, 'Neo Select') === 0) {

        $stmt3 = $conn->prepare("
            SELECT balance
            FROM customer_reference_wallet_utilization
            WHERE customer_id = :user_id
            ORDER BY id DESC
            LIMIT 1
        ");

        $stmt3->execute([':user_id' => $user_id]);
        $referralWallet = $stmt3->fetch(PDO::FETCH_ASSOC);

        $referralBalance = (float)($referralWallet['balance'] ?? 0);

        $stmt4 = $conn->prepare("
            SELECT balance
            FROM customer_discount_wallet_utilization
            WHERE customer_id = :user_id
            ORDER BY id DESC
            LIMIT 1
        ");

        $stmt4->execute([':user_id' => $user_id]);
        $discountWallet = $stmt4->fetch(PDO::FETCH_ASSOC);

        $discountBalance = (float)($discountWallet['balance'] ?? 0);
    }
}
// package
$sql = "SELECT * 
        FROM package 
        WHERE id = :id ";


$stmt = $conn->prepare($sql);
$stmt->execute([
    ':id' => $id
]);
$package = $stmt->fetch();
$cat_id = $package['category_id'];
$sub_cat_id = $package['sub_category_id'];
$hotel_cat_id = $package['category_hotel_id'];
$meal_cat_id = $package['category_meal_id'];
$package_keywords = $package['package_keywords'] ?? '';
$location  = $package['location'] ?? '';
$destination = $package['destination'] ?? '';
$package_type = $package['package_type'] ?? '';
$category_vehicle_id = $package['category_vehicle_id'] ?? '';

$tour_days_total = $package['tour_days'] - 1  ?? 0;
$tour_days = $tour_days_total - 1;
$tour_nights = $tour_days_total - 2;

// itinery 
$data2 = $conn->prepare("SELECT * FROM package_itinerary_details WHERE package_id = $id");
$data2->execute();
$itinery = $data2->fetch();

// package_pricing 
$data3 = $conn->prepare("SELECT * FROM package_pricing WHERE package_id = $id");
$data3->execute();
$amount = $data3->fetch();

// category 
$data5 = $conn->prepare("SELECT * FROM category WHERE id = $cat_id");
$data5->execute();
$category = $data5->fetch();

// sub_cat 
$data6 = $conn->prepare("SELECT * FROM subcategory WHERE id = $sub_cat_id");
$data6->execute();
$sub_cat = $data6->fetch();

// cat hotel 
$data7 = $conn->prepare("SELECT * FROM category_hotel WHERE id = $hotel_cat_id");
$data7->execute();
if ($data7->rowCount() > 0) {
    $hotel_cat = $data7->fetch();
} else {
    $hotel_cat = "null";
}

// cat meal 
$data8 = $conn->prepare("SELECT * FROM category_meal WHERE id = $meal_cat_id");
$data8->execute();
if ($data8->rowCount() > 0) {
    $meal_cat = $data8->fetch();
} else {
    $meal_cat = "null";
}

// Fetch occupancy types for a given package_id
$data9 = $conn->prepare("SELECT * FROM `package_to_category_occupancy` WHERE package_id = :id");
$data9->bindParam(':id', $id, PDO::PARAM_INT);
$data9->execute();
$occu_type = $data9->rowCount() > 0 ? $data9->fetchAll(PDO::FETCH_ASSOC) : [];

// Fetch all occupancy categories
$data10 = $conn->prepare("SELECT id, name FROM `category_occupancy`");
$data10->execute();
$occu_type_id = $data10->rowCount() > 0 ? $data10->fetchAll(PDO::FETCH_ASSOC) : [];

// Fetch vehicle types for a given package_id
$data11 = $conn->prepare("SELECT * FROM `package_to_category_vehicle` WHERE package_id = :id");
$data11->bindParam(':id', $id, PDO::PARAM_INT);
$data11->execute();
$vehicle_type = $data11->rowCount() > 0 ? $data11->fetchAll(PDO::FETCH_ASSOC) : []; // Corrected variable name

// Fetch vehicle types for a given package_id
$data11 = $conn->prepare("
    SELECT *
    FROM package_pricing
    WHERE package_id = :id
    ORDER BY id DESC
    LIMIT 1
");

$data11->bindParam(':id', $id, PDO::PARAM_INT);
$data11->execute();

$pricing = $data11->fetch(PDO::FETCH_ASSOC) ?: [];

// Fetch all vehicle categories
$data12 = $conn->prepare("SELECT id, name FROM `category_vehicle`");
$data12->execute();
$vehicle_type_id = $data12->rowCount() > 0 ? $data12->fetchAll(PDO::FETCH_ASSOC) : []; // Corrected variable name

//cancellation policy
$data9 = $conn->prepare("SELECT * FROM cancel_policy WHERE package_id = $id");
$data9->execute();
if ($data9->rowCount() > 0) {
    $cancel_policy = $data9->fetch();
} else {
    $cancel_policy['policy_1'] = 0;
    $cancel_policy['policy_2'] = 0;
    $cancel_policy['policy_3'] = 0;
}
//ta markup
// if($user_type_id_value == '11'){
//     $ta_markup_data = $conn->prepare("SELECT * FROM package_markup_travelagent WHERE travelagent_id = '" . $user_id . "' AND package_id = '" . $id . "' LIMIT 1");
//     $ta_markup_data->execute();
//     $ta_markup = $ta_markup_data->fetch();
//     if ($ta_markup) {
//         $ta_markup_price_val = $ta_markup['markup'] ?? 0;
//     }else {
//         $ta_markup_price_val = 0;
//     } 
// }else {
//     $ta_markup_price_val = 0;
// }
$stmtPolicy = $conn->prepare("
    SELECT title, file_name
    FROM package_policy_document
    WHERE package_id = ?
    ORDER BY id ASC
");

$stmtPolicy->execute([$id]);
$policies = $stmtPolicy->fetchAll(PDO::FETCH_ASSOC);
//share model start 30-07-2026

$title = "Bizzmirth Holidays Pvt Ltd";
$description = "Get latest and best deal on holiday packages";
$siteName = "Holiday Packages";

/*
|--------------------------------------------------------------------------
| Replace this with your thumbnail image URL
|--------------------------------------------------------------------------
|
| Recommended size: 1200x630 px
| Must be publicly accessible.
|
*/
$image = "http://localhost/ca.uniqbizz.com/admin/assets/images/fav.png";

$url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on'
    ? "https"
    : "http")
    . "://"
    . $_SERVER['HTTP_HOST']
    . $_SERVER['REQUEST_URI'];

//share model end
//package similar list
// Get latest 10 packages
$sql = "
    SELECT *
    FROM package
    WHERE status = 1
    AND id != ?
    AND (
        package_keywords LIKE ?
        OR destination LIKE ?
        OR location LIKE ?
        OR package_type LIKE ?
    )

    ORDER BY
        CASE
            WHEN destination LIKE ? THEN 1
            WHEN location LIKE ? THEN 2
            WHEN package_keywords LIKE ? THEN 3
            WHEN package_type LIKE ? THEN 4
            ELSE 5
        END ASC,

        id DESC

    LIMIT 10
";

$keywordSearch    = "%$package_keywords%";
$destinationSearch = "%$destination%";
$locationSearch    = "%$location%";
$typeSearch        = "%$package_type%";

$bindValues = [
    // WHERE
    $id,
    $keywordSearch,
    $destinationSearch,
    $locationSearch,
    $typeSearch,

    // ORDER BY priority
    $keywordSearch,
    $destinationSearch,
    $locationSearch,
    $typeSearch
];

$sqlPack = $conn->prepare($sql);

$sqlPack->execute($bindValues);

$packages = $sqlPack->fetchAll(PDO::FETCH_ASSOC);

$package_array = [];

foreach ($packages as $similarPackage) {

    $sqlPackPrice = $conn->prepare("
        SELECT total_package_price_per_adult
        FROM package_pricing
        WHERE package_id = ?
        ORDER BY id DESC
        LIMIT 1
    ");

    $sqlPackPrice->execute([$similarPackage['id']]);

    $packagePrice = $sqlPackPrice->fetch(PDO::FETCH_ASSOC);

    $sqlPackImage = $conn->prepare("
        SELECT image
        FROM package_pictures
        WHERE package_id = ?
        AND (type IS NULL OR type IN ('cover_image', 'gallary_image'))
        ORDER BY id ASC
    ");

    $sqlPackImage->execute([$similarPackage['id']]);

    $packageImages = $sqlPackImage->fetchAll(PDO::FETCH_COLUMN);

    $days = (int)$similarPackage['tour_days'];
    $nights = max(0, $days - 1);

    $package_duration = $nights . "N / " . $days . "D";

    $package_array[] = [
        "packid"   => $similarPackage['id'],
        "title"    => $similarPackage['name'],
        "duration" => $package_duration,
        "price"    => $packagePrice['total_package_price_per_adult'] ?? 0,
        'images'    => $packageImages,
        "link"     => "tour-details.php?pacId=" . $similarPackage['id']
    ];
}
//guest princinglogic
$userType = $_SESSION['user_type_id_value'] ?? null;

$showGuestPrice = !empty($userType)
    && !in_array((int)$userType, [1, 17, 15]);

$adultPrice = (float)$pricing['total_package_price_per_adult'];
$childPrice = (float)$pricing['total_package_price_per_child'];

$adultDisplayPrice = $adultPrice;
$childDisplayPrice = $childPrice;

if ($showGuestPrice) {

    if (!empty($pricing['guest_amount'])) {

        $guestAmount = (float)$pricing['guest_amount'];

        // Remove guest fixed amount
        $adultDisplayPrice = $adultPrice - $guestAmount;
        $childDisplayPrice = $childPrice - $guestAmount;

    } elseif (!empty($pricing['guest_percentage'])) {

        $percentage = (float)$pricing['guest_percentage'];

        // Remove guest percentage
        $adultDisplayPrice =
            $adultPrice / (1 + ($percentage / 100));

        $childDisplayPrice =
            $childPrice / (1 + ($percentage / 100));
    }
}
$stmt = $conn->prepare("
    SELECT image
    FROM package_pictures
    WHERE package_id = ?
    AND type = 'video'
    ORDER BY id ASC
");

$stmt->execute([$id]);

$packageVideos = $stmt->fetchAll(PDO::FETCH_COLUMN);

function safeJsonDecode($value)
{
    if (empty($value)) {
        return [];
    }

    $decoded = json_decode($value, true);

    return (json_last_error() === JSON_ERROR_NONE && is_array($decoded))
        ? $decoded
        : [];
}
$galleryImages = [];

$galleryData = $conn->prepare("SELECT * FROM package_pictures WHERE package_id = ? AND (type NOT IN ('video') OR type IS NULL)");
$galleryData->execute([$id]);

if ($galleryData->rowCount() > 0) {
    $galleryImages = $galleryData->fetchAll(PDO::FETCH_ASSOC);
}

$coverImage = '';

$coverData = $conn->prepare("
    SELECT image
    FROM package_pictures
    WHERE package_id = ?
      AND type = 'cover_image'
    LIMIT 1
");
$coverData->execute([$id]);

$coverImage = $coverData->fetchColumn() ?: '';

// If no cover image exists, use the first available image.
if ($coverImage === '') {
    $firstImageData = $conn->prepare("
        SELECT image
        FROM package_pictures
        WHERE package_id = ?
          AND (type NOT IN ('video') OR type IS NULL)
        ORDER BY id ASC
        LIMIT 1
    ");

    $firstImageData->execute([$id]);
    $coverImage = $firstImageData->fetchColumn() ?: '';
}
?>