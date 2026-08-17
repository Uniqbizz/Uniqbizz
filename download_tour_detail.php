<?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    $id = isset($_GET['pacId']) ? (int) $_GET['pacId'] : 0;

    if ($id <= 0) {
        die("Invalid package ID");
    }

    $format = $_GET['format'] ?? 'pdf';

    if (!in_array($format, ['pdf', 'word'], true)) {
        $format = 'pdf';
    }
    $username2 = $_SESSION['username2'] ?? null;
    $user_type_id_value = $_SESSION['user_type_id_value'] ?? null;
    $user_id = $_SESSION['user_id'] ?? null;
    require 'connect.php';


    /*
    |--------------------------------------------------------------------------
    | Load package data
    |--------------------------------------------------------------------------
    */

    include __DIR__ . '/assets/submit/download_tour_detail_data.php';

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

    <!-- <link rel="stylesheet"
        href="assets/css/main-style.css"> -->

    <link rel="stylesheet"
        href="assets/css/tour-details.css">

    <link rel="stylesheet"
        href="assets/css/tour_details_share.css">
    <link rel="stylesheet"
        href="assets/css/download_tour_detail.css">

    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">

    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.6.0/remixicon.css">
</head>
<body>
    <!-- PRINT HEADER -->
    <!-- <div class="print-header">
        Your Company Name
    </div> -->
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
                            // $packageName = $package['name'];
                            // $words = preg_split('/\s+/', trim($packageName));

                            // foreach ($words as $index => $word) {
                            //     echo htmlspecialchars($word) . ' ';

                            //     if (($index + 1) % 3 === 0) {
                            //         echo '<br>';
                            //     }
                            // }
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
                    <!-- <div class="hero-price-card">

                        <small>Starting from</small>

                        <div class="hero-price">
                            ₹9,765
                            <span>/ Adult</span>
                        </div>

                        <button class="btn btn-primary w-100">
                            Enquire Now
                            <i class="ri-arrow-right-line"></i>
                        </button>

                    </div> -->

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
                        <!-- <div class="package-section">

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

                        </div> -->


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
                                    LIMIT 2
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
                                        ₹<?= number_format($adultDisplayPrice, 2) ?>
                                        <small>/ adult</small>
                                    </h2>

                                    <p>
                                        Best available price for this package
                                    </p>

                                </div>


                                <!-- ADULT -->
                                <div class="price-row">

                                    <span>Adult</span>

                                    <strong>

                                        <?php if ($showGuestPrice && $adultDisplayPrice < $adultPrice): ?>

                                            <span class="text-decoration-line-through"
                                                style="font-size: 13px; opacity: .55; margin-right: 5px;">

                                                ₹<?= number_format($adultPrice, 2) ?>

                                            </span><br>

                                        <?php endif; ?>

                                        ₹<?= number_format($adultDisplayPrice, 2) ?>

                                    </strong>

                                </div>


                                <!-- CHILD -->
                                <div class="price-row">

                                    <span>Child</span>

                                    <strong>

                                        <?php if ($showGuestPrice && $childDisplayPrice < $childPrice): ?>

                                            <span class="text-decoration-line-through"
                                                style="font-size: 13px; opacity: .55; margin-right: 5px;">

                                                ₹<?= number_format($childPrice, 2) ?>

                                            </span><br/>

                                        <?php endif; ?>

                                        ₹<?= number_format($childDisplayPrice, 2) ?>

                                    </strong>

                                </div>


                                <!-- EXTRA MATTRESS -->
                                <!-- <div class="price-row">

                                    <span>Extra Mattress</span>

                                    <strong>
                                        ₹<?= number_format($amount['extra_mattress'] ?? 0, 2) ?>
                                    </strong>

                                </div> -->


                                <!-- <hr> -->

                            </div>


                            <!-- QUICK INFO -->
                            <div class="quick-info-card">

                                <h4>Quick Information</h4>


                                <div class="quick-info-item">

                                    <i class="ri-hotel-line"></i>

                                    <div>
                                        <small>Hotel Category</small>
                                        <strong>
                                            <?= htmlspecialchars($hotel_cat['name'] ?? 'Not Available') ?>
                                        </strong>
                                    </div>

                                </div>


                                <div class="quick-info-item">

                                    <i class="ri-restaurant-line"></i>

                                    <div>
                                        <small>Meal Plan</small>
                                        <strong>
                                            <?= htmlspecialchars($meal_cat['name'] ?? 'Not Available') ?>
                                        </strong>
                                    </div>

                                </div>

                                <?php
                                    $vehicleName = $vehicle_type['name'] ?? 'Not Available';

                                    $vehicleIcon = match (strtolower(trim($vehicleName))) {
                                        'car'            => 'ri-car-line',
                                        'bus'            => 'ri-bus-line',
                                        'train'          => 'ri-train-line',
                                        'volvo bus'      => 'ri-bus-2-line',
                                        'tempo traveler' => 'ri-bus-2-line',
                                        'seat in coach'  => 'ri-roadster-line',
                                        'speedboat'      => 'ri-ship-line',
                                        default          => 'ri-roadster-line'
                                    };
                                ?>
                                <div class="quick-info-item">

                                    <i class="<?= $vehicleIcon ?>"></i>

                                    <div>
                                        <small>Vehicle</small>

                                        <strong>
                                            <?= htmlspecialchars($vehicleName) ?>
                                        </strong>
                                    </div>

                                </div>


                                <?php if (!empty($package['language_type'])): ?>

                                    <!-- <div class="quick-info-item">

                                        <i class="ri-translate-2"></i>

                                        <div>
                                            <small>Language</small>

                                            <strong>
                                                <?= htmlspecialchars($package['language_type']) ?>
                                            </strong>
                                        </div>

                                    </div> -->

                                <?php endif; ?>


                            </div>


                            <!-- HELP -->
                            <div class="help-card">
                                <div class="d-flex gap-3">
                                    <div class="">

                                        <h4>Need Help Planning?</h4>
        
                                        <p>
                                            Our travel experts are here to help
                                            you create the perfect trip.
                                        </p>
        
                                        <a href="tel:+918010892265">
                                            <i class="ri-phone-line"></i>
                                            +91 8010892265
                                        </a>
                                    </div>
                                    <div class="help-icon">
                                        <i class="ri-customer-service-2-line"></i>
                                    </div>
                                </div>



                            </div>

                        </div>

                    </div>
                    <!-- PACKAGE DETAILS -->
                    <!-- <div class="package-section">

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

                    </div> -->


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

                            <?php

                            $data4 = $conn->prepare("
                                SELECT *
                                FROM package_trip_days
                                WHERE package_id = ?
                                ORDER BY id ASC
                            ");

                            $data4->execute([$id]);

                            $days = $data4->fetchAll(PDO::FETCH_ASSOC);

                            ?>


                            <?php if (!empty($days)): ?>

                                <?php foreach ($days as $key_3 => $day): ?>

                                    <?php

                                    $count = $key_3 + 1;

                                    /*
                                    * Description
                                    */
                                    $description = trim($day['day_details'] ?? '');

                                    /*
                                    * Meal
                                    */
                                    $meal = trim($day['meal_plan'] ?? '');

                                    /*
                                    * Transport
                                    */
                                    $transport = trim($day['day_tansport'] ?? '');

                                    /*
                                    * Stay
                                    */
                                    $stay = trim($day['stay'] ?? '');

                                    ?>


                                    <!-- TIMELINE ITEM -->
                                    <div class="timeline-item">


                                        <!-- NUMBER -->
                                        <div class="timeline-number">

                                            <?= str_pad($count, 2, '0', STR_PAD_LEFT) ?>

                                        </div>


                                        <!-- CONTENT -->
                                        <div class="timeline-content">


                                            <!-- DAY LABEL -->
                                            <div class="day-label">

                                                DAY <?= $count ?>

                                            </div>


                                            <!-- TITLE -->
                                            <h3>

                                                <?= htmlspecialchars($day['title'] ?? 'Day ' . $count) ?>

                                            </h3>


                                            <!-- DESCRIPTION -->
                                            <?php if ($description !== ''): ?>

                                                <p>
                                                    <?= nl2br(htmlspecialchars($description)) ?>
                                                </p>

                                            <?php else: ?>

                                                <p>
                                                    No Details available
                                                </p>

                                            <?php endif; ?>


                                            <!-- DAY INFO -->
                                            <div class="day-highlight">
                                                <div class="day-info">


                                                    <?php if ($meal !== ''): ?>

                                                        <span>

                                                            <i class="ri-restaurant-line"></i>

                                                            <?= htmlspecialchars($meal) ?>

                                                        </span>

                                                    <?php endif; ?>


                                                    <?php if ($transport !== ''): ?>

                                                        <span>

                                                            <i class="ri-car-line"></i>

                                                            <?= htmlspecialchars($transport) ?>

                                                        </span>

                                                    <?php endif; ?>


                                                    <?php if ($stay !== ''): ?>

                                                        <span>

                                                            <i class="ri-hotel-line"></i>

                                                            <?= htmlspecialchars($stay) ?>

                                                        </span>

                                                    <?php endif; ?>


                                                </div>
                                            </div>


                                            <!-- HIGHLIGHT -->

                                        </div>

                                    </div>


                                <?php endforeach; ?>


                            <?php else: ?>


                                <div class="timeline-item">

                                    <div class="timeline-number">
                                        01
                                    </div>

                                    <div class="timeline-content">

                                        <div class="day-label">
                                            ITINERARY
                                        </div>

                                        <h3>
                                            No Details Available
                                        </h3>

                                        <p>
                                            No itinerary details are available for this package.
                                        </p>

                                    </div>

                                </div>


                            <?php endif; ?>


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

                                        <h3>Inclusion</h3>
                                    </div>

                                    <ul>

                                        <?php
                                        $inclusionData = $itinery['inclusion'] ?? '';

                                        $inclusions = json_decode($inclusionData, true);

                                        if (!is_array($inclusions)) {
                                            $inclusions = [];
                                        }

                                        // Remove empty values
                                        $inclusions = array_filter($inclusions, function ($inclusion) {
                                            return trim($inclusion) !== '';
                                        });
                                        ?>

                                        <?php if (!empty($inclusions)): ?>

                                            <?php foreach ($inclusions as $inclusion): ?>

                                                <li>
                                                    <i class="ri-checkbox-circle-fill"></i>
                                                    <?= htmlspecialchars(trim($inclusion)) ?>
                                                </li>

                                            <?php endforeach; ?>

                                        <?php else: ?>

                                            <li>
                                                <i class="ri-checkbox-circle-fill"></i>
                                                No Details available
                                            </li>

                                        <?php endif; ?>

                                    </ul>

                                </div>

                            </div>
                            <div class="col-md-6">

                                <div class="included-card excluded">

                                    <div class="list-title">
                                        <div class="list-icon">
                                            <i class="ri-close-line"></i>
                                        </div>

                                        <h3>Exclusion</h3>
                                    </div>

                                    <ul>

                                        <?php
                                        $inclusionData = $itinery['exclusion'] ?? '';

                                        $inclusions = json_decode($inclusionData, true);

                                        if (!is_array($inclusions)) {
                                            $inclusions = [];
                                        }

                                        // Remove empty values
                                        $inclusions = array_filter($inclusions, function ($inclusion) {
                                            return trim($inclusion) !== '';
                                        });
                                        ?>

                                        <?php if (!empty($inclusions)): ?>

                                            <?php foreach ($inclusions as $inclusion): ?>

                                                <li>
                                                    <i class="ri-close-circle-fill"></i>
                                                    <?= htmlspecialchars(trim($inclusion)) ?>
                                                </li>

                                            <?php endforeach; ?>

                                        <?php else: ?>

                                            <li>
                                                <i class="ri-checkbox-circle-fill"></i>
                                                No Details available
                                            </li>

                                        <?php endif; ?>

                                    </ul>

                                </div>

                            </div>

                            <div class="col-md-6">

                                <div class="included-card included">

                                    <div class="list-title">

                                        <div class="list-icon">
                                            <i class="ri-error-warning-line"></i>
                                        </div>

                                        <h3>Important Notes / Remarks</h3>

                                    </div>

                                    <ul>

                                        <?php
                                        $travelInfo = $itinery['remark'] ?? '';

                                        $thingsToKnow = json_decode($travelInfo, true);

                                        if (!is_array($thingsToKnow)) {
                                            $thingsToKnow = [];
                                        }

                                        // Remove empty values
                                        $thingsToKnow = array_filter($thingsToKnow, function ($thing) {
                                            return trim($thing) !== '';
                                        });
                                        ?>

                                        <?php if (!empty($thingsToKnow)): ?>

                                            <?php foreach ($thingsToKnow as $thing): ?>

                                                <li>
                                                    <i class="ri-error-warning-fill"></i>
                                                    <?= htmlspecialchars(trim($thing)) ?>
                                                </li>

                                            <?php endforeach; ?>

                                        <?php else: ?>

                                            <li>
                                                <i class="ri-suitcase-3-fill"></i>
                                                No Details available
                                            </li>

                                        <?php endif; ?>

                                    </ul>

                                </div>

                            </div>
                            <div class="col-md-6">

                                <div class="included-card included">

                                    <div class="list-title">

                                        <div class="list-icon">
                                            <i class="ri-suitcase-3-line"></i>
                                        </div>

                                        <h3>Things to Know Before You Go</h3>

                                    </div>

                                    <ul>

                                        <?php
                                        $travelInfo = $itinery['travel_info'] ?? '';

                                        $thingsToKnow = json_decode($travelInfo, true);

                                        if (!is_array($thingsToKnow)) {
                                            $thingsToKnow = [];
                                        }

                                        // Remove empty values
                                        $thingsToKnow = array_filter($thingsToKnow, function ($thing) {
                                            return trim($thing) !== '';
                                        });
                                        ?>

                                        <?php if (!empty($thingsToKnow)): ?>

                                            <?php foreach ($thingsToKnow as $thing): ?>

                                                <li>
                                                    <i class="ri-suitcase-3-fill"></i>
                                                    <?= htmlspecialchars(trim($thing)) ?>
                                                </li>

                                            <?php endforeach; ?>

                                        <?php else: ?>

                                            <li>
                                                <i class="ri-suitcase-3-fill"></i>
                                                No Details available
                                            </li>

                                        <?php endif; ?>

                                    </ul>

                                </div>

                            </div>
                            

                        </div>

                    </div>


                    <!-- PACKING -->
                    <!-- <div class="package-section">

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

                    </div> -->


                    <!-- POLICIES -->
                    <!-- <div class="package-section">

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

                    </div> -->

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
                            <strong><?= $destination ?>?</strong>
                        </h2>

                        <p>
                            Let us help you turn this travel dream
                            into a beautiful memory.
                        </p>

                    </div>

                    <!-- <div class="cta-buttons">

                        <button class="btn btn-light">
                            Enquire Now
                            <i class="ri-arrow-right-line"></i>
                        </button>

                        <button class="btn btn-outline-light">
                            <i class="ri-phone-line"></i>
                            Talk to Expert
                        </button>

                    </div> -->

                </div>

            </div>

        </section>

    </div>

    <!-- PRINT FOOTER -->
    <!-- <div class="print-footer">
        <span>Your Company Name</span>
        &nbsp; | &nbsp;
        <?= htmlspecialchars($package['name'] ?? 'Travel Package') ?>
        &nbsp; | &nbsp;
        Page <span class="page-number"></span>
    </div> -->
</body>
</html>
<?php

    if ($format === 'pdf') {
?>
        <script>

            window.addEventListener('load', function () {

                setTimeout(function () {

                    window.print();

                }, 1500);

            });

        </script>
<?php
    }
?>

