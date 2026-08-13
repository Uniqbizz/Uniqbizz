<?php
    if (session_status() == PHP_SESSION_NONE) {
        @session_start(); // Suppress warnings if headers already sent
    }

    // Define default values for users who are not logged in
    $username2 = $_SESSION['username2'] ?? null;
    $user_type_id_value = $_SESSION['user_type_id_value'] ?? null;
    $user_id = $_SESSION['user_id'] ?? null;

    $id = isset($_GET['pacId']) ? (int)$_GET['pacId'] : 0;

    if ($id <= 0) {
        die("Invalid package ID");
    }

    // echo $userFname = $_SESSION['username2']; //first name of user 'Ryam'.
    // echo $userLname = $_SESSION['lname']; //last name of user 'Cardoso'.
    // echo $userType = $_SESSION['user_type_id_value']; //user type id value '3'.
    // echo $userId = $_SESSION['user_id']; // user id 'TA230030'.
    $userId = $_SESSION['user_id']??'0';

    require 'connect.php';
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
    // package
    $stmt = $conn->prepare("SELECT * FROM package WHERE id = $id");
    $stmt->execute();
    $package = $stmt->fetch();
    $cat_id = $package['category_id'];
    $sub_cat_id = $package['sub_category_id'];
    $hotel_cat_id = $package['category_hotel_id'];
    $meal_cat_id = $package['category_meal_id'];
    $validity = $package['validity'] ?? 0;
    $package_keywords = $package['package_keywords'] ?? '';
    $location  = $package['location'] ?? '';
    $destination = $package['destination'] ?? '';
    $short_discription=$package['description'];

    $tour_days_total = $package['tour_days'] ?? 0;
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

    // Fetch occupancy type for the selected category_occupancy_id

    $data9 = $conn->prepare("
        SELECT name
        FROM category_occupancy
        WHERE id = :id
    ");

    $data9->bindValue(
        ':id',
        $package['category_occupancy_id'],
        PDO::PARAM_INT
    );

    $data9->execute();

    $occu_type = $data9->fetch(PDO::FETCH_ASSOC);

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
    if($user_type_id_value == '11'){
        $ta_markup_data = $conn->prepare("SELECT * FROM package_markup_travelagent WHERE travelagent_id = '" . $user_id . "' AND package_id = '" . $id . "' LIMIT 1");
        $ta_markup_data->execute();
        $ta_markup = $ta_markup_data->fetch();
        if ($ta_markup) {
            $ta_markup_price_val = $ta_markup['markup'] ?? 0;
        }else {
            $ta_markup_price_val = 0;
        } 
    }else {
        $ta_markup_price_val = 0;
    }
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
    $image = "https://ca.uniqbizz.com/admin/assets/images/fav.png";

    $url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on'
        ? "https"
        : "http")
        . "://"
        . $_SERVER['HTTP_HOST']
        . $_SERVER['REQUEST_URI'];

    //share model end
    //package similar list
    // Get latest 10 packages
    $sqlPack = $conn->prepare("
        SELECT *
        FROM package
        WHERE status = 1
        AND id != ?
        AND (
                package_keywords LIKE ?
                OR destination LIKE ?
                OR location LIKE ?
            )
        ORDER BY id DESC
        LIMIT 10
    ");

    $sqlPack->execute([
        $id,
        "%$package_keywords%",
        "%$destination%",
        "%$location%"
    ]);

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
            ORDER BY id ASC
            LIMIT 1
        ");

        $sqlPackImage->execute([$similarPackage['id']]);

        $packageImage = $sqlPackImage->fetch(PDO::FETCH_ASSOC);

        $days = (int)$similarPackage['tour_days'];
        $nights = max(0, $days - 1);

        $package_duration = $nights . "N / " . $days . "D";

        $package_array[] = [
            "packid"   => $similarPackage['id'],
            "title"    => $similarPackage['name'],
            "duration" => $package_duration,
            "price"    => $packagePrice['total_package_price_per_adult'] ?? 0,
            "image"    => $packageImage['image'] ?? '',
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
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="icon"
      type="image/x-icon"
      sizes="20x20"
      href="assets/images/icon/fav.png">

    <link rel="stylesheet"
        href="assets/css/bootstrap-5.3.0.min.css">

    <link rel="stylesheet"
        href="assets/css/plugin.css">

    <link rel="stylesheet"
        href="assets/css/main-style.css">

    <link rel="stylesheet"
        href="assets/css/tour-details.css">

    <link rel="stylesheet"
        href="assets/css/tour_details_share.css">

    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">

    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.6.0/remixicon.css">
    <style>
        /* =========================================================
        PREMIUM TRAVEL PACKAGE DESIGN
        ========================================================= */

        .travel-package-page {
            background: #f7f9fc;
            color: #172033;
            font-family: inherit;
        }


        /* =========================================================
        HERO
        ========================================================= */

        .package-hero {
            padding: 25px 0 0;
        }

        .hero-image-wrapper {
            position: relative;
            height: 600px;
            border-radius: 28px;
            overflow: hidden;
            box-shadow: 0 25px 70px rgba(20, 35, 60, .18);
        }

        .package-hero-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .hero-overlay {
            position: absolute;
            inset: 0;
            background:
                linear-gradient(
                    90deg,
                    rgba(8, 20, 38, .88) 0%,
                    rgba(8, 20, 38, .58) 42%,
                    rgba(8, 20, 38, .08) 100%
                ),
                linear-gradient(
                    0deg,
                    rgba(0, 0, 0, .55),
                    transparent 50%
                );
        }

        .hero-back-btn {
            position: absolute;
            top: 28px;
            left: 28px;

            display: inline-flex;
            align-items: center;
            gap: 8px;

            color: #fff;
            text-decoration: none;

            padding: 11px 17px;

            background: rgba(255, 255, 255, .14);
            backdrop-filter: blur(12px);

            border: 1px solid rgba(255, 255, 255, .25);
            border-radius: 50px;

            font-size: 14px;
            font-weight: 600;

            transition: .3s;
        }

        .hero-back-btn:hover {
            background: #fff;
            color: #172033;
        }

        .hero-content {
            position: absolute;
            left: 60px;
            bottom: 168px;
            max-width: 680px;
            color: #fff;
        }

        .hero-badges {
            display: flex;
            gap: 10px;
            margin-bottom: 18px;
        }

        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;

            padding: 7px 13px;

            background: #ff7a00;
            color: #fff;

            border-radius: 50px;

            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .5px;
        }

        .hero-badge.light {
            background: rgba(255, 255, 255, .15);
            border: 1px solid rgba(255, 255, 255, .3);
        }

        .hero-content h1 {
            font-size: clamp(42px, 5vw, 70px);
            line-height: 1.03;
            font-weight: 800;
            margin-bottom: 18px;
            letter-spacing: -2px;
        }

        .hero-content h1 span {
            font-weight: 400;
        }

        .hero-description {
            max-width: 570px;
            color: rgba(255, 255, 255, .85);
            font-size: 17px;
            line-height: 1.7;
        }

        .hero-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 22px;
            margin-top: 25px;
        }

        .hero-meta div {
            display: flex;
            align-items: center;
            gap: 7px;

            color: #fff;
            font-size: 14px;
        }

        .hero-meta i {
            color: #ff9d42;
            font-size: 20px;
        }


        /* PRICE */

        .hero-price-card {
            position: absolute;
            right: 35px;
            bottom: 200px;

            width: 250px;

            padding: 24px;

            background: rgba(255, 255, 255, .96);
            backdrop-filter: blur(15px);

            border-radius: 20px;

            box-shadow: 0 15px 45px rgba(0, 0, 0, .2);
        }

        .hero-price-card small {
            color: #7b8496;
        }

        .hero-price {
            font-size: 30px;
            font-weight: 800;
            color: #172033;
            margin: 4px 0 18px;
        }

        .hero-price span {
            font-size: 12px;
            font-weight: 500;
            color: #7b8496;
        }


        /* =========================================================
        SUMMARY
        ========================================================= */

        .package-summary {
            position: relative;
            z-index: 5;
            margin-top: -40px;
        }

        .summary-card {
            display: flex;
            align-items: center;
            justify-content: space-between;

            padding: 22px 35px;

            background: #fff;
            border-radius: 20px;

            box-shadow: 0 15px 45px rgba(28, 45, 75, .09);
        }

        .summary-item {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .summary-icon {
            width: 48px;
            height: 48px;

            display: flex;
            align-items: center;
            justify-content: center;

            border-radius: 14px;

            background: #fff2e6;
            color: #f47b20;

            font-size: 22px;
        }

        .summary-item small {
            display: block;
            color: #929aaa;
            font-size: 11px;
            margin-bottom: 3px;
            text-transform: uppercase;
            letter-spacing: .5px;
        }

        .summary-item strong {
            font-size: 14px;
        }

        .summary-divider {
            height: 42px;
            width: 1px;
            background: #e9edf3;
        }


        /* =========================================================
        MAIN
        ========================================================= */

        .package-main {
            padding: 90px 0;
        }

        .package-section {
            margin-bottom: 30px;
        }

        .section-heading {
            margin-bottom: 30px;
        }

        .section-heading > span {
            color: #f47b20;
            font-size: 11px;
            font-weight: 800;
            letter-spacing: 2px;
        }

        .section-heading h2 {
            margin: 7px 0 0;

            font-size: 34px;
            font-weight: 700;
            letter-spacing: -.8px;
        }

        .section-heading h2 strong {
            color: #f47b20;
        }

        .package-text {
            color: #697386;
            line-height: 1.9;
            font-size: 15px;
            margin-bottom: 5px;
        }


        /* =========================================================
        HIGHLIGHTS
        ========================================================= */

        .highlight-card {
            height: 100%;

            display: flex;
            gap: 15px;

            padding: 22px;

            background: #fff;

            border: 1px solid #edf0f5;
            border-radius: 18px;

            transition: .3s;
        }

        .highlight-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(30, 50, 80, .08);
        }

        .highlight-icon {
            min-width: 48px;
            height: 48px;

            display: flex;
            align-items: center;
            justify-content: center;

            background: #fff1e5;
            color: #f47b20;

            border-radius: 14px;
            font-size: 22px;
        }

        .highlight-card h5 {
            font-size: 16px;
            margin: 2px 0 7px;
        }

        .highlight-card p {
            color: #7a8393;
            font-size: 13px;
            line-height: 1.6;
            margin: 0;
        }


        /* =========================================================
        GALLERY
        ========================================================= */

        .destination-gallery {
            margin-top: 10px;
        }

        .gallery-image {
            height: 230px;
            position: relative;
            overflow: hidden;
            border-radius: 18px;
        }

        .gallery-image.large {
            height: 480px;
        }

        .gallery-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: .6s;
        }

        .gallery-image:hover img {
            transform: scale(1.07);
        }

        .gallery-image::after {
            content: "";
            position: absolute;
            inset: 0;

            background: linear-gradient(
                0deg,
                rgba(0,0,0,.65),
                transparent 60%
            );
        }

        .gallery-caption {
            position: absolute;
            z-index: 2;
            left: 20px;
            bottom: 18px;

            color: #fff;
        }

        .gallery-caption span {
            display: block;
            color: #ff9b48;
            font-size: 11px;
            font-weight: 800;
        }

        .gallery-caption strong {
            font-size: 17px;
        }


        /* =========================================================
        DETAILS
        ========================================================= */

        .details-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 12px;
        }

        .detail-box {
            padding: 18px 20px;

            background: #fff;
            border: 1px solid #edf0f5;
            border-radius: 14px;
        }

        .detail-box small {
            display: block;
            color: #939baa;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: .6px;
            margin-bottom: 6px;
        }

        .detail-box strong {
            font-size: 14px;
        }


        /* =========================================================
        ITINERARY
        ========================================================= */

        .timeline {
            position: relative;
        }

        .timeline::before {
            content: "";
            position: absolute;

            left: 26px;
            top: 10px;
            bottom: 10px;

            width: 2px;

            background: #e7ebf1;
        }

        .timeline-item {
            position: relative;

            display: flex;
            gap: 25px;

            margin-bottom: 35px;
        }

        .timeline-number {
            position: relative;
            z-index: 2;

            min-width: 54px;
            height: 54px;

            display: flex;
            align-items: center;
            justify-content: center;

            background: #fff;

            border: 2px solid #f47b20;

            color: #f47b20;

            border-radius: 50%;

            font-weight: 800;
            font-size: 13px;
        }

        .timeline-content {
            flex: 1;

            padding: 25px;

            background: #fff;

            border-radius: 18px;
            border: 1px solid #edf0f5;
        }

        .day-label {
            color: #f47b20;
            font-size: 11px;
            font-weight: 800;
            letter-spacing: 1px;
        }

        .timeline-content h3 {
            font-size: 21px;
            margin: 6px 0 12px;
        }

        .timeline-content p {
            color: #737d8f;
            line-height: 1.75;
            font-size: 14px;
        }

        .day-info {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;

            margin-top: 15px;
        }

        .day-info span {
            display: flex;
            align-items: center;
            gap: 6px;

            color: #697386;
            font-size: 13px;
        }

        .day-info i {
            color: #f47b20;
        }

        .day-highlight {
            margin-top: 16px;
            padding-top: 15px;

            border-top: 1px solid #edf0f5;

            color: #525c6c;
            font-size: 13px;
            font-weight: 600;
        }

        .day-highlight i {
            color: #f47b20;
            margin-right: 5px;
        }


        /* =========================================================
        INCLUDED / EXCLUDED
        ========================================================= */

        .included-card {
            padding: 28px;

            border-radius: 20px;
            background: #fff;

            border: 1px solid #edf0f5;
        }

        .included-card.included {
            border-top: 4px solid #2cad70;
        }

        .included-card.excluded {
            border-top: 4px solid #e05252;
        }

        .list-title {
            display: flex;
            align-items: center;
            gap: 12px;

            margin-bottom: 20px;
        }

        .list-icon {
            width: 42px;
            height: 42px;

            display: flex;
            align-items: center;
            justify-content: center;

            border-radius: 12px;

            font-size: 20px;
        }

        .included .list-icon {
            background: #e9f8f0;
            color: #2cad70;
        }

        .excluded .list-icon {
            background: #fff0f0;
            color: #e05252;
        }

        .list-title h3 {
            font-size: 18px;
            margin: 0;
        }

        .included-card ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .included-card li {
            display: flex;
            gap: 9px;

            padding: 9px 0;

            color: #687284;
            font-size: 13px;
        }

        .included li i {
            color: #2cad70;
        }

        .excluded li i {
            color: #e05252;
        }


        /* =========================================================
        PACKING
        ========================================================= */

        .packing-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 12px;
        }

        .packing-grid > div {
            display: flex;
            align-items: center;
            gap: 12px;

            padding: 16px 18px;

            background: #fff;

            border: 1px solid #edf0f5;
            border-radius: 14px;

            color: #5e6879;
            font-size: 13px;
        }

        .packing-grid i {
            color: #f47b20;
            font-size: 20px;
        }


        /* =========================================================
        ACCORDION
        ========================================================= */

        .custom-accordion .accordion-item {
            margin-bottom: 10px;

            border: 1px solid #e8ecf2 !important;
            border-radius: 14px !important;
            overflow: hidden;
        }

        .custom-accordion .accordion-button {
            padding: 18px 20px;

            background: #fff;

            box-shadow: none !important;

            font-size: 14px;
            font-weight: 600;
        }

        .custom-accordion .accordion-button i {
            margin-right: 12px;
            color: #f47b20;
            font-size: 20px;
        }

        .custom-accordion .accordion-body {
            padding: 0 20px 20px;

            color: #737d8f;
            font-size: 13px;
            line-height: 1.7;
        }


        /* =========================================================
        SIDEBAR
        ========================================================= */

        .package-sidebar {
            position: sticky;
            top: 30px;
        }

        .booking-card {
            background: #fff;

            border-radius: 22px;

            padding: 28px;

            box-shadow: 0 15px 50px rgba(25, 45, 75, .1);

            margin-bottom: 20px;
        }

        .booking-top > span {
            color: #f47b20;
            font-size: 10px;
            font-weight: 800;
            letter-spacing: 1.5px;
        }

        .booking-top h2 {
            margin: 7px 0;

            font-size: 32px;
            font-weight: 800;
        }

        .booking-top h2 small {
            font-size: 12px;
            color: #8b93a2;
            font-weight: 400;
        }

        .booking-top p {
            color: #8a92a1;
            font-size: 12px;
        }

        .price-row {
            display: flex;
            align-items: center;
            justify-content: space-between;

            padding: 12px 0;

            font-size: 13px;
        }

        .price-row span {
            color: #747e8f;
        }

        .price-row strong {
            color: #202b3d;
        }

        .booking-btn {
            background: #f47b20;
            color: #fff;

            border: 0;

            padding: 14px;

            border-radius: 12px;

            font-weight: 700;

            transition: .3s;
        }

        .booking-btn:hover {
            background: #dd6810;
            color: #fff;
            transform: translateY(-2px);
        }

        .secure-booking {
            display: flex;
            align-items: center;
            justify-content: center;

            gap: 7px;

            margin-top: 18px;

            color: #8a92a1;
            font-size: 11px;
        }

        .secure-booking i {
            color: #2cad70;
            font-size: 17px;
        }


        /* QUICK INFO */

        .quick-info-card {
            padding: 25px;

            background: #fff;

            border: 1px solid #edf0f5;
            border-radius: 20px;

            margin-bottom: 20px;
        }

        .quick-info-card h4 {
            font-size: 18px;
            margin-bottom: 18px;
        }

        .quick-info-item {
            display: flex;
            gap: 12px;

            padding: 14px 0;

            border-bottom: 1px solid #edf0f5;
        }

        .quick-info-item:last-child {
            border-bottom: 0;
        }

        .quick-info-item > i {
            color: #f47b20;
            font-size: 21px;
        }

        .quick-info-item small {
            display: block;
            color: #969eac;
            font-size: 10px;
        }

        .quick-info-item strong {
            font-size: 13px;
        }


        /* HELP */

        .help-card {
            padding: 28px;

            background:
                linear-gradient(
                    145deg,
                    #172033,
                    #263650
                );

            color: #fff;

            border-radius: 20px;
        }

        .help-icon {
            width: 48px;
            height: 48px;

            display: flex;
            align-items: center;
            justify-content: center;

            background: rgba(255,255,255,.1);

            border-radius: 14px;

            font-size: 22px;
        }

        .help-card h4 {
            margin: 18px 0 8px;
            font-size: 19px;
        }

        .help-card p {
            color: rgba(255,255,255,.65);
            font-size: 13px;
            line-height: 1.7;
        }

        .help-card a {
            display: inline-flex;
            align-items: center;
            gap: 7px;

            margin-top: 8px;

            color: #fff;
            text-decoration: none;

            font-weight: 700;
            font-size: 14px;
        }


        /* =========================================================
        CTA
        ========================================================= */

        .explore-cta {
            padding: 0 0 80px;
        }

        .cta-inner {
            display: flex;
            align-items: center;
            justify-content: space-between;

            padding: 55px 60px;

            background:
                linear-gradient(
                    120deg,
                    #f47b20,
                    #f99b4d
                );

            border-radius: 28px;

            color: #fff;

            box-shadow: 0 20px 55px rgba(244,123,32,.22);
        }

        .cta-inner > div:first-child > span {
            font-size: 10px;
            font-weight: 800;
            letter-spacing: 2px;
        }

        .cta-inner h2 {
            font-size: 38px;
            margin: 8px 0;
        }

        .cta-inner h2 strong {
            font-weight: 800;
        }

        .cta-inner p {
            margin: 0;
            color: rgba(255,255,255,.8);
        }

        .cta-buttons {
            display: flex;
            gap: 10px;
        }

        .cta-buttons .btn {
            padding: 13px 20px;
            border-radius: 10px;
            font-weight: 700;
        }


        /* =========================================================
        RESPONSIVE
        ========================================================= */

        @media (max-width: 1199px) {

            .hero-image-wrapper {
                height: 560px;
            }

            .hero-content {
                left: 40px;
                bottom: 45px;
            }

            .hero-price-card {
                right: 25px;
            }

        }


        @media (max-width: 991px) {

            .package-hero {
                padding-top: 15px;
            }

            .hero-image-wrapper {
                height: 620px;
            }

            .hero-content {
                left: 30px;
                right: 30px;
                bottom: 35px;
            }

            .hero-price-card {
                display: none;
            }

            .summary-card {
                flex-wrap: wrap;
                gap: 20px;
            }

            .summary-divider {
                display: none;
            }

            .summary-item {
                width: 45%;
            }

            .package-sidebar {
                position: static;
            }

            .package-main {
                padding-top: 65px;
            }

            .cta-inner {
                padding: 40px;
                flex-direction: column;
                align-items: flex-start;
                gap: 25px;
            }

        }


        @media (max-width: 767px) {

            .hero-image-wrapper {
                height: 650px;
                border-radius: 20px;
            }

            .hero-back-btn {
                top: 18px;
                left: 18px;
            }

            .hero-content {
                left: 22px;
                right: 22px;
                bottom: 25px;
            }

            .hero-content h1 {
                font-size: 42px;
                letter-spacing: -1px;
            }

            .hero-description {
                font-size: 14px;
            }

            .hero-meta {
                gap: 10px;
                flex-direction: column;
            }

            .summary-card {
                padding: 20px;
            }

            .summary-item {
                width: 100%;
            }

            .package-main {
                padding: 50px 0;
            }

            .package-section {
                margin-bottom: 30px;
            }

            .section-heading h2 {
                font-size: 28px;
            }

            .gallery-image.large {
                height: 280px;
            }

            .gallery-image {
                height: 210px;
            }

            .details-grid {
                grid-template-columns: 1fr;
            }

            .packing-grid {
                grid-template-columns: 1fr;
            }

            .timeline-item {
                gap: 15px;
            }

            .timeline-number {
                min-width: 45px;
                height: 45px;
                font-size: 11px;
            }

            .timeline::before {
                left: 21px;
            }

            .timeline-content {
                padding: 18px;
            }

            .timeline-content h3 {
                font-size: 18px;
            }

            .cta-inner {
                padding: 30px 25px;
                border-radius: 20px;
            }

            .cta-inner h2 {
                font-size: 29px;
            }

            .cta-buttons {
                width: 100%;
                flex-direction: column;
            }

            .cta-buttons .btn {
                width: 100%;
            }

        }


        @media (max-width: 480px) {

            .hero-image-wrapper {
                height: 600px;
            }

            .hero-content h1 {
                font-size: 35px;
            }

            .hero-badge {
                font-size: 10px;
            }

            .hero-meta div {
                font-size: 12px;
            }

        }
    </style>
</head>
<body>
    <!-- =========================================================
        TRAVEL PACKAGE DETAILS
    ========================================================= -->

    <div class="travel-package-page">

        <!-- ================= HERO ================= -->
        <section class="package-hero">

            <div class="container">

                <div class="hero-image-wrapper">
                    <?php
                        $galleryImages = [];

                        $galleryData = $conn->prepare("
                            SELECT *
                            FROM package_pictures
                            WHERE package_id = ?
                            AND type = 'gallery_image'
                            ORDER BY id
                            LIMIT 1
                        ");

                        $galleryData->execute([$id]);

                        if ($galleryData->rowCount() > 0) {
                            $galleryImages = $galleryData->fetchAll(PDO::FETCH_ASSOC);
                        }

                        $heroImage = !empty($galleryImages[0]['image'])
                            ? $galleryImages[0]['image']
                            : 'assets/images/package/default-package.jpg';
                    ?>

                    <img src="<?= htmlspecialchars($heroImage) ?>"
                        class="package-hero-image"
                        alt="Travel Package">

                    <div class="hero-overlay"></div>

                    <!-- Hero Content -->
                    <div class="hero-content">

                        <div class="hero-badges">
                            <span class="hero-badge">
                                <i class="ri-fire-line"></i>
                                <?= $package['highlight_type'] ?>
                            </span>

                            <span class="hero-badge light">
                                <?= $package['package_type'] ?>
                            </span>
                        </div>
                        <?php
                            $packageName = $package['name'];
                            $words = preg_split('/\s+/', trim($packageName));

                            foreach ($words as $index => $word) {
                                echo htmlspecialchars($word) . ' ';

                                if (($index + 1) % 3 === 0) {
                                    echo '<br>';
                                }
                            }
                        ?>
                        <h1 class="light" style="color: #fff;">
                            <?php
                            $words = preg_split('/\s+/', trim($package['name']));

                            // First 3 words
                            $firstPart = array_slice($words, 0, 3);

                            // Remaining words
                            $remainingPart = array_slice($words, 3);
                            ?>

                            <?= htmlspecialchars(implode(' ', $firstPart)) ?>

                            <?php if (!empty($remainingPart)): ?>
                                <br>
                                <span style="color: #dad7d7;">
                                    <?= htmlspecialchars(implode(' ', $remainingPart)) ?>
                                </span>
                            <?php endif; ?>
                        </h1>

                        <p class="hero-description">
                            <?= $short_discription ?>
                        </p>

                    </div>

                    <!-- Price -->
                    <div class="hero-price-card">

                        <small>Starting from</small>

                        <div class="hero-price">
                            ₹9,765
                            <span>/ Adult</span>
                        </div>
                        <!-- <div class="hero-price">
                            ₹5,765
                            <span>/ child</span>
                        </div> -->

                        <button class="btn btn-primary w-100">
                            Enquire Now
                            <i class="ri-arrow-right-line"></i>
                        </button>

                    </div>

                </div>

            </div>

        </section>


        <!-- ================= PACKAGE SUMMARY ================= -->
        <section class="package-summary">

            <div class="container">

                <div class="summary-card">

                    <div class="summary-item">
                        <div class="summary-icon">
                            <i class="ri-map-pin-2-line"></i>
                        </div>

                        <div>
                            <small>Destination</small>
                            <strong><?= $destination ?></strong>
                        </div>
                    </div>

                    <div class="summary-divider"></div>

                    <div class="summary-item">
                        <div class="summary-icon">
                            <i class="ri-calendar-check-line"></i>
                        </div>

                        <div>
                            <small>Duration</small>
                            <strong><?= $tour_nights ?> Nights / <?= $tour_days ?> Days</strong>
                        </div>
                    </div>

                    <div class="summary-divider"></div>

                    <div class="summary-item">
                        <div class="summary-icon">
                            <i class="ri-hotel-line"></i>
                        </div>

                        <div>
                            <small>Hotel</small>
                            <strong><?= $hotel_cat['name'] ?></strong>
                        </div>
                    </div>

                    <div class="summary-divider"></div>

                    <div class="summary-item">
                        <div class="summary-icon">
                            <i class="ri-restaurant-line"></i>
                        </div>

                        <div>
                            <small>Meals</small>
                            <strong><?= $meal_cat['name'] ?></strong>
                        </div>
                    </div>

                </div>

            </div>

        </section>


        <!-- ================= MAIN CONTENT ================= -->
        <section class="package-main">

            <div class="container">

                <div class="row g-5">

                    <!-- LEFT -->
                    <div class="col-lg-8">

                        <!-- OVERVIEW -->
                        <div class="package-section">

                            <div class="section-heading">

                                <span>DISCOVER THE EXPERIENCE</span>

                                <h2>
                                    A Journey You'll
                                    <strong>Remember</strong>
                                </h2>

                            </div>
                            <?php
                                $description = trim($package['detailed_description'] ?? '');

                                $words = preg_split('/\s+/', $description);

                                $chunks = array_chunk($words, 500);

                                foreach ($chunks as $chunk):
                            ?>

                            <p class="package-text">
                                <?= htmlspecialchars(implode(' ', $chunk)) ?>
                            </p>

                            <?php endforeach; ?>

                        </div>


                        <!-- WHY YOU'LL LOVE -->
                        <div class="package-section">

                            <div class="section-heading">

                                <span>TRAVEL HIGHLIGHTS</span>

                                <h2>
                                    Why You'll
                                    <strong>Love This Trip</strong>
                                </h2>

                            </div>

                            <div class="row g-3">

                                <div class="col-md-6">

                                    <div class="highlight-card">

                                        <div class="highlight-icon">
                                            <i class="ri-sun-line"></i>
                                        </div>

                                        <div>
                                            <h5>Sunrise on the Ganges</h5>
                                            <p>
                                                Witness a magical sunrise
                                                over the sacred river.
                                            </p>
                                        </div>

                                    </div>

                                </div>

                                <div class="col-md-6">

                                    <div class="highlight-card">

                                        <div class="highlight-icon">
                                            <i class="ri-building-4-line"></i>
                                        </div>

                                        <div>
                                            <h5>Ancient Temples</h5>
                                            <p>
                                                Explore Varanasi's iconic
                                                spiritual landmarks.
                                            </p>
                                        </div>

                                    </div>

                                </div>

                                <div class="col-md-6">

                                    <div class="highlight-card">

                                        <div class="highlight-icon">
                                            <i class="ri-water-flash-line"></i>
                                        </div>

                                        <div>
                                            <h5>Ganga Aarti</h5>
                                            <p>
                                                Experience the breathtaking
                                                evening ceremony.
                                            </p>
                                        </div>

                                    </div>

                                </div>

                                <div class="col-md-6">

                                    <div class="highlight-card">

                                        <div class="highlight-icon">
                                            <i class="ri-camera-3-line"></i>
                                        </div>

                                        <div>
                                            <h5>Local Experiences</h5>
                                            <p>
                                                Discover the culture and
                                                traditions of Varanasi.
                                            </p>
                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>


                        <!-- DESTINATION GALLERY -->
                        <div class="package-section">

                            <div class="section-heading">

                                <span>EXPLORE THE DESTINATION</span>

                                <h2>
                                    Destination
                                    <strong>Highlights</strong>
                                </h2>

                            </div>

                            <?php
                                $galleryImages = [];

                                $galleryData = $conn->prepare("
                                    SELECT *
                                    FROM package_pictures
                                    WHERE package_id = ?
                                    AND type NOT IN ('video')
                                    ORDER BY id ASC
                                ");

                                $galleryData->execute([$id]);

                                if ($galleryData->rowCount() > 0) {
                                    $galleryImages = $galleryData->fetchAll(PDO::FETCH_ASSOC);
                                }
                            ?>

                            <div class="row g-3 destination-gallery">

                                <?php foreach (array_slice($galleryImages, 0, 4) as $index => $gallery): 

                                    $columnClass = ($index === 0 || $index === 3)
                                        ? 'col-md-7'
                                        : 'col-md-5';

                                    $imageClass = in_array($index, [0, 1])
                                        ? 'gallery-image large'
                                        : 'gallery-image';

                                    $imageNumber = str_pad($index + 1, 2, '0', STR_PAD_LEFT);
                                ?>

                                <div class="<?= $columnClass ?>">

                                    <div class="<?= $imageClass ?>">

                                        <img src="<?= htmlspecialchars($gallery['image']) ?>"
                                            alt="Destination Image <?= $index + 1 ?>">

                                        <div class="gallery-caption">

                                            <span><?= $imageNumber ?></span>

                                            <strong>
                                                <?= htmlspecialchars($package['name']) ?>
                                            </strong>

                                        </div>

                                    </div>

                                </div>

                                <?php endforeach; ?>

                            </div>

                        </div>

                    </div>
                    <!-- ================= RIGHT SIDEBAR ================= -->
                    <div class="col-lg-4">

                        <div class="package-sidebar">

                            <!-- PRICE -->
                            <div class="booking-card">

                                <div class="booking-top">

                                    <span>PACKAGE PRICE</span>

                                    <h2>
                                        ₹9,765
                                        <small>/ adult</small>
                                    </h2>

                                    <p>
                                        Best available price for this package
                                    </p>

                                </div>


                                <div class="price-row">

                                    <span>Adult</span>

                                    <strong>₹9,765</strong>

                                </div>

                                <div class="price-row">

                                    <span>Child</span>

                                    <strong>₹6,500</strong>

                                </div>

                                <div class="price-row">

                                    <span>Extra Mattress</span>

                                    <strong>₹500</strong>

                                </div>

                                <hr>

                                <button class="btn booking-btn w-100">
                                    Enquire About This Package
                                    <i class="ri-arrow-right-line"></i>
                                </button>

                                <button class="btn btn-outline-secondary w-100 mt-2">
                                    <i class="ri-share-line"></i>
                                    Share Package
                                </button>

                                <div class="secure-booking">

                                    <i class="ri-shield-check-line"></i>

                                    <span>
                                        Your enquiry is safe & secure
                                    </span>

                                </div>

                            </div>


                            <!-- QUICK INFO -->
                            <div class="quick-info-card">

                                <h4>Quick Information</h4>

                                <div class="quick-info-item">

                                    <i class="ri-hotel-line"></i>

                                    <div>
                                        <small>Hotel Category</small>
                                        <strong>3 Star</strong>
                                    </div>

                                </div>

                                <div class="quick-info-item">

                                    <i class="ri-restaurant-line"></i>

                                    <div>
                                        <small>Meal Plan</small>
                                        <strong>Breakfast</strong>
                                    </div>

                                </div>

                                <div class="quick-info-item">

                                    <i class="ri-car-line"></i>

                                    <div>
                                        <small>Vehicle</small>
                                        <strong>AC Vehicle</strong>
                                    </div>

                                </div>

                                <div class="quick-info-item">

                                    <i class="ri-translate-2"></i>

                                    <div>
                                        <small>Language</small>
                                        <strong>Hindi, English</strong>
                                    </div>

                                </div>

                            </div>


                            <!-- HELP -->
                            <div class="help-card">

                                <div class="help-icon">
                                    <i class="ri-customer-service-2-line"></i>
                                </div>

                                <h4>Need Help Planning?</h4>

                                <p>
                                    Our travel experts are here to help
                                    you create the perfect trip.
                                </p>

                                <a href="tel:+919999999999">
                                    <i class="ri-phone-line"></i>
                                    +91 99999 99999
                                </a>

                            </div>

                        </div>

                    </div>
                    <!-- PACKAGE DETAILS -->
                    <div class="package-section">

                        <div class="section-heading">

                            <span>AT A GLANCE</span>

                            <h2>
                                Package
                                <strong>Details</strong>
                            </h2>

                        </div>

                        <div class="details-grid">

                            <div class="detail-box">
                                <small>Package Code</small>
                                <strong>BH25016</strong>
                            </div>

                            <div class="detail-box">
                                <small>Category</small>
                                <strong>Domestic</strong>
                            </div>

                            <div class="detail-box">
                                <small>Sub Category</small>
                                <strong>Spiritual</strong>
                            </div>

                            <div class="detail-box">
                                <small>Travel Theme</small>
                                <strong>Spiritual</strong>
                            </div>

                            <div class="detail-box">
                                <small>Validity</small>
                                <strong>01 Jan 2027</strong>
                            </div>

                            <div class="detail-box">
                                <small>Season</small>
                                <strong>November - December</strong>
                            </div>

                            <div class="detail-box">
                                <small>Cities Covered</small>
                                <strong>Varanasi</strong>
                            </div>

                            <div class="detail-box">
                                <small>Language</small>
                                <strong>Hindi, English</strong>
                            </div>

                        </div>

                    </div>


                    <!-- ITINERARY -->
                    <div class="package-section itinerary-section">

                        <div class="section-heading">

                            <span>YOUR JOURNEY</span>

                            <h2>
                                Day-by-Day
                                <strong>Experience</strong>
                            </h2>

                        </div>

                        <div class="timeline">

                            <!-- DAY 1 -->
                            <div class="timeline-item">

                                <div class="timeline-number">
                                    01
                                </div>

                                <div class="timeline-content">

                                    <div class="day-label">
                                        DAY 1
                                    </div>

                                    <h3>Arrival in Varanasi</h3>

                                    <p>
                                        Arrive in Varanasi and transfer
                                        to your hotel. Spend the evening
                                        exploring the vibrant surroundings
                                        before enjoying your first glimpse
                                        of the sacred Ganges.
                                    </p>

                                    <div class="day-info">

                                        <span>
                                            <i class="ri-restaurant-line"></i>
                                            Dinner
                                        </span>

                                        <span>
                                            <i class="ri-car-line"></i>
                                            Private Transfer
                                        </span>

                                    </div>

                                    <div class="day-highlight">
                                        <i class="ri-star-fill"></i>
                                        Hotel check-in & local exploration
                                    </div>

                                </div>

                            </div>


                            <!-- DAY 2 -->
                            <div class="timeline-item">

                                <div class="timeline-number">
                                    02
                                </div>

                                <div class="timeline-content">

                                    <div class="day-label">
                                        DAY 2
                                    </div>

                                    <h3>Temples & Spiritual Varanasi</h3>

                                    <p>
                                        Begin your day with a peaceful
                                        morning visit to the sacred temples
                                        followed by sightseeing around
                                        the historic city.
                                    </p>

                                    <div class="day-info">

                                        <span>
                                            <i class="ri-restaurant-line"></i>
                                            Breakfast
                                        </span>

                                        <span>
                                            <i class="ri-car-line"></i>
                                            Sightseeing
                                        </span>

                                    </div>

                                    <div class="day-highlight">
                                        <i class="ri-star-fill"></i>
                                        Temple visit & cultural experience
                                    </div>

                                </div>

                            </div>


                            <!-- DAY 3 -->
                            <div class="timeline-item">

                                <div class="timeline-number">
                                    03
                                </div>

                                <div class="timeline-content">

                                    <div class="day-label">
                                        DAY 3
                                    </div>

                                    <h3>Ganges Boat Ride</h3>

                                    <p>
                                        Witness the beauty of Varanasi
                                        from the river as the city comes
                                        alive around the sacred ghats.
                                    </p>

                                    <div class="day-info">

                                        <span>
                                            <i class="ri-restaurant-line"></i>
                                            Breakfast
                                        </span>

                                        <span>
                                            <i class="ri-ship-line"></i>
                                            Boat Ride
                                        </span>

                                    </div>

                                    <div class="day-highlight">
                                        <i class="ri-star-fill"></i>
                                        Sunrise boat ride on the Ganges
                                    </div>

                                </div>

                            </div>


                            <!-- DAY 4 -->
                            <div class="timeline-item">

                                <div class="timeline-number">
                                    04
                                </div>

                                <div class="timeline-content">

                                    <div class="day-label">
                                        DAY 4
                                    </div>

                                    <h3>Culture & Ganga Aarti</h3>

                                    <p>
                                        Spend the day discovering the
                                        local culture before experiencing
                                        the spectacular Ganga Aarti.
                                    </p>

                                    <div class="day-info">

                                        <span>
                                            <i class="ri-restaurant-line"></i>
                                            Breakfast
                                        </span>

                                        <span>
                                            <i class="ri-walk-line"></i>
                                            Walking Tour
                                        </span>

                                    </div>

                                    <div class="day-highlight">
                                        <i class="ri-star-fill"></i>
                                        Evening Ganga Aarti
                                    </div>

                                </div>

                            </div>


                            <!-- DAY 5 -->
                            <div class="timeline-item">

                                <div class="timeline-number">
                                    05
                                </div>

                                <div class="timeline-content">

                                    <div class="day-label">
                                        DAY 5
                                    </div>

                                    <h3>Departure</h3>

                                    <p>
                                        Enjoy your final breakfast before
                                        checking out and departing with
                                        beautiful memories of Varanasi.
                                    </p>

                                    <div class="day-info">

                                        <span>
                                            <i class="ri-restaurant-line"></i>
                                            Breakfast
                                        </span>

                                        <span>
                                            <i class="ri-flight-takeoff-line"></i>
                                            Departure
                                        </span>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>


                    <!-- INCLUSION -->
                    <div class="package-section">

                        <div class="row g-4">

                            <div class="col-md-6">

                                <div class="included-card included">

                                    <div class="list-title">
                                        <div class="list-icon">
                                            <i class="ri-check-line"></i>
                                        </div>

                                        <h3>What's Included</h3>
                                    </div>

                                    <ul>

                                        <li>
                                            <i class="ri-checkbox-circle-fill"></i>
                                            Hotel accommodation
                                        </li>

                                        <li>
                                            <i class="ri-checkbox-circle-fill"></i>
                                            Daily breakfast
                                        </li>

                                        <li>
                                            <i class="ri-checkbox-circle-fill"></i>
                                            Airport / railway transfer
                                        </li>

                                        <li>
                                            <i class="ri-checkbox-circle-fill"></i>
                                            Sightseeing as per itinerary
                                        </li>

                                        <li>
                                            <i class="ri-checkbox-circle-fill"></i>
                                            Professional driver
                                        </li>

                                    </ul>

                                </div>

                            </div>


                            <div class="col-md-6">

                                <div class="included-card excluded">

                                    <div class="list-title">

                                        <div class="list-icon">
                                            <i class="ri-close-line"></i>
                                        </div>

                                        <h3>What's Not Included</h3>

                                    </div>

                                    <ul>

                                        <li>
                                            <i class="ri-close-circle-fill"></i>
                                            Personal expenses
                                        </li>

                                        <li>
                                            <i class="ri-close-circle-fill"></i>
                                            Airfare / train tickets
                                        </li>

                                        <li>
                                            <i class="ri-close-circle-fill"></i>
                                            Travel insurance
                                        </li>

                                        <li>
                                            <i class="ri-close-circle-fill"></i>
                                            Monument entrance fees
                                        </li>

                                    </ul>

                                </div>

                            </div>

                        </div>

                    </div>


                    <!-- PACKING -->
                    <div class="package-section">

                        <div class="section-heading">

                            <span>BE PREPARED</span>

                            <h2>
                                What to
                                <strong>Pack</strong>
                            </h2>

                        </div>

                        <div class="packing-grid">

                            <div>
                                <i class="ri-sun-line"></i>
                                Comfortable clothing
                            </div>

                            <div>
                                <i class="ri-footprint-line"></i>
                                Comfortable footwear
                            </div>

                            <div>
                                <i class="ri-sun-foggy-line"></i>
                                Sunglasses & sunscreen
                            </div>

                            <div>
                                <i class="ri-camera-line"></i>
                                Camera
                            </div>

                            <div>
                                <i class="ri-medicine-bottle-line"></i>
                                Personal medicines
                            </div>

                            <div>
                                <i class="ri-passport-line"></i>
                                Travel documents
                            </div>

                        </div>

                    </div>


                    <!-- POLICIES -->
                    <div class="package-section">

                        <div class="section-heading">

                            <span>PLEASE NOTE</span>

                            <h2>
                                Important
                                <strong>Policies</strong>
                            </h2>

                        </div>

                        <div class="accordion custom-accordion"
                            id="policyAccordion">

                            <div class="accordion-item">

                                <h2 class="accordion-header">

                                    <button class="accordion-button"
                                            type="button"
                                            data-bs-toggle="collapse"
                                            data-bs-target="#bookingPolicy">

                                        <i class="ri-calendar-check-line"></i>
                                        Booking Policy

                                    </button>

                                </h2>

                                <div id="bookingPolicy"
                                    class="accordion-collapse collapse show"
                                    data-bs-parent="#policyAccordion">

                                    <div class="accordion-body">

                                        Booking confirmation is subject
                                        to availability and applicable
                                        payment terms.

                                    </div>

                                </div>

                            </div>


                            <div class="accordion-item">

                                <h2 class="accordion-header">

                                    <button class="accordion-button collapsed"
                                            type="button"
                                            data-bs-toggle="collapse"
                                            data-bs-target="#cancelPolicy">

                                        <i class="ri-close-circle-line"></i>
                                        Cancellation Policy

                                    </button>

                                </h2>

                                <div id="cancelPolicy"
                                    class="accordion-collapse collapse"
                                    data-bs-parent="#policyAccordion">

                                    <div class="accordion-body">

                                        Cancellation charges will apply
                                        according to the booking terms.

                                    </div>

                                </div>

                            </div>


                            <div class="accordion-item">

                                <h2 class="accordion-header">

                                    <button class="accordion-button collapsed"
                                            type="button"
                                            data-bs-toggle="collapse"
                                            data-bs-target="#paymentPolicy">

                                        <i class="ri-secure-payment-line"></i>
                                        Payment Policy

                                    </button>

                                </h2>

                                <div id="paymentPolicy"
                                    class="accordion-collapse collapse"
                                    data-bs-parent="#policyAccordion">

                                    <div class="accordion-body">

                                        Payments must be made according
                                        to the payment schedule provided
                                        at the time of booking.

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </section>


        <!-- ================= CTA ================= -->
        <section class="explore-cta">

            <div class="container">

                <div class="cta-inner">

                    <div>

                        <span>YOUR NEXT ADVENTURE AWAITS</span>

                        <h2>
                            Ready to Explore
                            <strong>Varanasi?</strong>
                        </h2>

                        <p>
                            Let us help you turn this travel dream
                            into a beautiful memory.
                        </p>

                    </div>

                    <div class="cta-buttons">

                        <button class="btn btn-light">
                            Enquire Now
                            <i class="ri-arrow-right-line"></i>
                        </button>

                        <button class="btn btn-outline-light">
                            <i class="ri-phone-line"></i>
                            Talk to Expert
                        </button>

                    </div>

                </div>

            </div>

        </section>

    </div>
</body>
</html>
