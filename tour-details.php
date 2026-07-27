<?php
// session_start();

// if (!isset($_SESSION['username2']) || !isset($_SESSION['user_type_id_value']) || !isset($_SESSION['user_id'])) {
//     echo '<script>location.href = "login";</script>';
// }

// Start the session only if it's not already started
if (session_status() == PHP_SESSION_NONE) {
    @session_start(); // Suppress warnings if headers already sent
}

// Define default values for users who are not logged in
$username2 = $_SESSION['username2'] ?? null;
$user_type_id_value = $_SESSION['user_type_id_value'] ?? null;
$user_id = $_SESSION['user_id'] ?? null;

// Now you can use these variables safely
// Example usage:
// if ($username2 && $user_type_id_value && $user_id) {
//     // Logged-in user
//     echo "Welcome, $username2!";
// } else {
//     // Guest user
//     echo "Welcome, Guest!";
// }

$id = $_GET['pacId']; //package_id '156'

// echo $userFname = $_SESSION['username2']; //first name of user 'Ryam'.
// echo $userLname = $_SESSION['lname']; //last name of user 'Cardoso'.
// echo $userType = $_SESSION['user_type_id_value']; //user type id value '3'.
// echo $userId = $_SESSION['user_id']; // user id 'TA230030'.
$userId = $_SESSION['user_id']??'0';

require 'connect.php';
// package
$stmt = $conn->prepare("SELECT * FROM package WHERE id = $id");
$stmt->execute();
$package = $stmt->fetch();
$cat_id = $package['category_id'];
$sub_cat_id = $package['sub_category_id'];
$hotel_cat_id = $package['category_hotel_id'];
$meal_cat_id = $package['category_meal_id'];
$validity = $package['validity'] ?? 0;

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

?>

<!DOCTYPE html>
<html lang="zxx" dir="lrt">

    <!-- Mirrored from travelloo.vercel.app/template/tour-details.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 12 Jul 2024 06:53:04 GMT -->
    <!-- Added by HTTrack -->
    <meta http-equiv="content-type" content="text/html;charset=utf-8" /><!-- /Added by HTTrack -->

    <head>
        <!-- <script>
        const setTheme = (theme) => {
            theme ?? = localStorage.theme || "light";
            document.documentElement.dataset.theme = theme;
            localStorage.theme = theme;
        };
        setTheme();
        </script> -->

        <script>
            const setTheme = (theme) => {
                // If theme is undefined or null, set it to localStorage.theme or "light"
                theme = theme || localStorage.theme || "light";
                document.documentElement.dataset.theme = theme;
                localStorage.theme = theme;
            };
            setTheme();
        </script>
        <meta logo="assets/images/logo/logo.png">
        <meta white-logo="assets/images/logo/logo-white.png">

        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta name="description"
            content="Travello - Multipurpose travel and tour booking.These template is suitable for  travel agency , tour, travel website , tour operator , tourism , booking  trip or adventure website. ">
        <meta name="keywords"
            content="travel, trip booking,tour, hotel, tour guide, tourism, blog, flight, travel agency, tourism agency, accommodation, tour website">
        <meta name="author" content="inittheme">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta property="og:type" content="website">
        <meta property="og:title" content="Multipurpose travel and tour booking">
        <meta property="og:site_name" content="Mirthcon">
        <meta property="og:url" content="https://inittheme.com">
        <meta property="og:image" content="https://inittheme.com/images/selfie.jpg">
        <meta property="og:description" content="Multipurpose travel and tour booking, multipurpose template">
        <meta name="twitter:title" content="Multipurpose travel and tour booking">
        <meta name="twitter:description" content="Multipurpose travel and tour booking, multipurpose template">
        <meta name="twitter:image" content="https://twitter.com/inittheme/photo">
        <meta name="twitter:card" content="summary">
        <!-- Google site verification -->
        <meta name="google-site-verification" content="...">
        <meta name="facebook-domain-verification" content="...">
        <meta name="csrf-token" content="...">
        <meta name="currency" content="$">
        <!-- Title -->
        <title>Bizzmirth Holidays Pvt Ltd</title>
        <link rel="icon" type="image/x-icon" sizes="20x20" href="assets/images/icon/fav.png">
        <!-- Bootstrap -->
        <link rel="stylesheet" type="text/css" href="assets/css/bootstrap-5.3.0.min.css">
        <!-- Fonts & icon -->
        <!-- <link rel="stylesheet" type="text/css" href="assets/css/remixicon.css"> -->
        <!-- Plugin -->
        <link rel="stylesheet" type="text/css" href="assets/css/plugin.css">
        <!-- Main CSS -->
        <link rel="stylesheet" type="text/css" href="assets/css/main-style.css">
        <!-- Tour Details CSS 18/7/2026 -->
        <link rel="stylesheet" type="text/css" href="assets/css/tour-details.css">
        <!-- RTL CSS::When Need RTL Uncomments File -->
        <!-- <link rel="stylesheet" type="text/css" href="assets/css/rtl.css"> -->
        <!-- Swiper -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.6.0/remixicon.css" integrity="sha512-kJlvECunwXftkPwyvHbclArO8wszgBGisiLeuDFwNM8ws+wKIw0sv1os3ClWZOcrEB2eRXULYUsm8OVRGJKwGA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    </head>
    
    <body>
        <?php include_once "header.php" ?>
        <main>
            <!-- Breadcrumbs S t a r t -->
            <div class="container">
                <nav aria-label="breadcrumb" class="mt-4">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item">
                            <a href="index.php">Home</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            <?php echo $package['name'] ?>
                        </li>
                    </ol>
                </nav>
            </div>
            <!--/ End-of Breadcrumbs-->

            <!-- Destination area S t a r t -->
            <section class="tour-details-section">
                <div class="tour-details-area">
                    
                    <!-- Details Banner Slider -->
                    <!-- <div class="tour-details-banner">
                        <div class="swiper tourSwiper-active">
                            <div class="swiper-wrapper">
                                <?php
                                // require 'connect.php';
                                // $data = $conn->prepare("SELECT * FROM package_pictures WHERE package_id = $id");
                                // $data->execute();
                                // $data->setFetchMode(PDO::FETCH_ASSOC);
                                // if ($data->rowCount() > 0) {
                                //     $counterimage = 0;
                                //     foreach (($data->fetchAll()) as $key_1 => $image) {
                                //         echo '<div class="swiper-slide">
                                //                 <img src="' . $image['image'] . '" alt="BizzMirth" style="width: 710px !important; height: 400px !important;">
                                //             </div>';
                                //     }
                                // }
                                ?>

                            </div>
                            <div class="swiper-button-next"><i class="ri-arrow-right-s-line"></i></div>
                            <div class="swiper-button-prev"><i class="ri-arrow-left-s-line"></i></div>
                        </div>
                    </div> -->
                    <!-- / Slider-->
                    <div class="tour-details-container">
                        <div class="container">
                            <div>
                                <div class="title-section">
                                    <h3 class="fw-bolder" id="pack_name"><?php echo $package['name'] ?></h3>
                                    <div class="d-flex gap-4">
                                        <div class="share-icon">
                                            <i class="ri-share-line"></i>
                                        </div>
                                        <div class="wishlist-icon">
                                            <i class="ri-heart-line"></i>
                                        </div>
                                    </div>
                                </div>
                                <p class="destination-title fs-5 mb-3">
                                    <i class="ri-map-pin-line"></i>
                                    <?php echo $package['destination'] ?>
                                </p>
                            </div>
                            <?php
                                $galleryImages = [];

                                $galleryData = $conn->prepare("SELECT * FROM package_pictures WHERE package_id = ?");
                                $galleryData->execute([$id]);

                                if ($galleryData->rowCount() > 0) {
                                    $galleryImages = $galleryData->fetchAll(PDO::FETCH_ASSOC);
                                }
                            ?>
                            <div class="desktop-gallery">
                                <div class="row">
                                    <?php if (!empty($galleryImages)) : ?>

                                        <div class="col-xl-7 col-lg-12 mb-3">
                                            <div class="image-wrapper">
                                                <img src="<?= $galleryImages[0]['image'] ?>" alt="<?= $package['name'] ?>" class="image-width">
                                            </div>
                                        </div>
                                        <div class="col-xl-5 col-lg-12 position-relative">
                                            <div class="row">
                                                <?php
                                                foreach (array_slice($galleryImages, 1, 4) as $image) {
                                                    echo '
                                                    <div class="col-xl-6 col-lg-3 mb-3">
                                                        <div class="image-wrapper">
                                                            <img src="' . $image['image'] . '"  alt="' . $package['name'] . '" class="image-width-section">
                                                        </div>
                                                    </div>';
                                                }
                                                ?>

                                            </div>
                                            <button class="btn all-photos-btn" data-bs-toggle="modal" data-bs-target="#allPhotosModal">
                                                <i class="ri-image-line me-2"></i>
                                                All Photos
                                            </button>
                                        </div>

                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="mobile-gallery swiper myGallery mb-3">
                                <div class="swiper-wrapper">
                                    <?php foreach ($galleryImages as $image) : ?>

                                        <div class="swiper-slide">
                                            <img src="<?= $image['image'] ?>" class="slider-image" alt="<?= $package['name'] ?>">
                                        </div>

                                    <?php endforeach; ?>

                                </div>
                                <div class="swiper-pagination"></div>
                            </div>

                            <!-- Modal -->
                            <div class="modal fade" id="allPhotosModal" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-fullscreen">
                                    <div class="modal-content transparant-black border-0">
                                        <div class="gallery-modal">
                                            <!-- Close -->
                                            <button class="gallery-close" data-bs-dismiss="modal" aria-label="Close">
                                                <i class="ri-close-line"></i>
                                            </button>
                                            <!-- Previous -->
                                            <button class="gallery-prev">
                                                <i class="ri-arrow-left-s-line"></i>
                                            </button>
                                            <!-- Gallery Content -->
                                            <div class="gallery-content">
                                                <!-- Main Image -->
                                                <div class="main-image-alignment">
                                                    <img id="mainImage" src="<?= !empty($galleryImages) ? $galleryImages[0]['image'] : '' ?>" class="gallery-main-image" alt="<?= $package['name'] ?>">
                                                </div>
                                                <!-- Thumbnails -->
                                                <div class="gallery-thumbnails">
                                                    <?php foreach ($galleryImages as $index => $image) : ?>
                                                        <img src="<?= $image['image'] ?>"
                                                            class="thumbnail <?= $index === 0 ? 'active-thumb' : '' ?>"
                                                            alt="<?= $package['name'] ?>">

                                                    <?php endforeach; ?>
                                                </div>
                                            </div>
                                            <!-- Next -->
                                            <button class="gallery-next">
                                                <i class="ri-arrow-right-s-line"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Card section start 1 -->
                            <div class="borderColor p-3 pb-0 mb-3">
                                <div class="row">
                                    <div class="col-xl-2 col-lg-4 col-md-4 col-sm-4 col-6 mb-3">
                                        <div class="d-flex gap-2">
                                            <div class="iconColor align-content-center">
                                                <i class="ri-history-line"></i>
                                            </div>
                                            <div class="fontSize1">
                                                <p class="fw-bolder">Duration</p>
                                                <p class="text-muted">5 Nights / 6 Days</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-2 col-lg-4 col-md-4 col-sm-4 col-6 mb-3">
                                        <div class="d-flex gap-2">
                                            <div class="iconColor align-content-center">
                                                <i class="ri-timer-flash-line"></i>
                                            </div>
                                            <div class="fontSize1">
                                                <p class="fw-bolder">Best Time</p>
                                                <p class="text-muted">Oct - May</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-2 col-lg-4 col-md-4 col-sm-4 col-6 mb-3">
                                        <div class="d-flex gap-2">
                                            <div class="iconColor align-content-center">
                                                <i class="ri-passport-line"></i>
                                            </div>
                                            <div class="fontSize1">
                                                <p class="fw-bolder">Visa</p>
                                                <p class="text-muted">Not Required</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-2 col-lg-4 col-md-4 col-sm-4 col-6 mb-3">
                                        <div class="d-flex gap-2">
                                            <div class="iconColor align-content-center">
                                                <i class="ri-restaurant-line"></i>
                                            </div>
                                            <div class="fontSize1">
                                                <p class="fw-bolder">Meal Plan</p>
                                                <p class="text-muted">Breakfast & Dinner</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-2 col-lg-4 col-md-4 col-sm-4 col-6 mb-3">
                                        <div class="d-flex gap-2">
                                            <div class="iconColor align-content-center">
                                                <i class="ri-landscape-line"></i>
                                            </div>
                                            <div class="fontSize1">
                                                <p class="fw-bolder">Tour Type</p>
                                                <p class="text-muted">Group Tour</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-2 col-lg-4 col-md-4 col-sm-4 col-6 mb-3">
                                        <div class="d-flex gap-2">
                                            <div class="iconColor align-content-center">
                                                <i class="ri-car-line"></i>
                                            </div>
                                            <div class="fontSize1">
                                                <p class="fw-bolder">Pickup/Drop</p>
                                                <p class="text-muted">Port Blair Airport</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Card section end 1 -->
                            <!-- Card Section Start 2 -->
                            <div class="row">
                                <div class="col-xl-8 col-lg-9 col-md-12 col-sm-12 col-12 mb-3">
                                    <div class="nav-placeholder"></div>
                                    <div class="sticky-nav-wrapper">
                                        <div class="borderColor1 pt-3">
                                            <ul class="nav nav-underline justify-content-between">
                                                <li class="nav-item navItem">
                                                    <a class="nav-link pt-0 active" aria-current="page" href="#overview">
                                                        <div class="text-center">
                                                            <i class="ri-dashboard-line"></i>
                                                        </div>
                                                        Overview
                                                    </a>
                                                </li>
                                                <li class="nav-item navItem">
                                                    <a class="nav-link pt-0" href="#highlights">
                                                        <div class="text-center">
                                                            <i class="ri-mark-pen-line"></i>
                                                        </div>
                                                        Highlights
                                                    </a>
                                                </li>
                                                <li class="nav-item navItem">
                                                    <a class="nav-link pt-0" href="#itinerary">
                                                        <div class="text-center">
                                                            <i class="ri-route-line"></i>
                                                        </div>
                                                        Itinerary
                                                    </a>
                                                </li>
                                                <li class="nav-item navItem">
                                                    <a class="nav-link pt-0" href="#inclusion">
                                                        <div class="text-center">
                                                            <i class="ri-dashboard-line"></i>
                                                        </div>
                                                        Inclusion
                                                    </a>
                                                </li>
                                                <li class="nav-item navItem">
                                                    <a class="nav-link pt-0" href="#inclusion">
                                                        <div class="text-center">
                                                            <i class="ri-dashboard-line"></i>
                                                        </div>
                                                        Exclusion
                                                    </a>
                                                </li>
                                                <li class="nav-item navItem">
                                                    <a class="nav-link pt-0" href="#policies">
                                                        <div class="text-center">
                                                            <i class="ri-dashboard-line"></i>
                                                        </div>
                                                        Policies
                                                    </a>
                                                </li>
                                                <li class="nav-item navItem">
                                                    <a class="nav-link pt-0" href="#faqs">
                                                        <div class="text-center">
                                                            <i class="ri-question-answer-line"></i>
                                                        </div>
                                                        FAQs
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="content-sections">
                                        <div id="overview" class="section-block">
                                            <div class="card cardBackgroundColor rounded-3 p-3">
                                                <h5 class="fw-bolder">Overview</h5>
                                                <p class="text-muted fw-bold fontSize2 mt-2">
                                                    Experience the best of Thailand with pristine beaches, vibrant nightlife, iconic temples, thrilling water
                                                    activities and world-class shopping. A perfect holiday for families, couples and groups.
                                                </p>
                                                <div class="packageCode mt-2">
                                                    <div class="d-flex gap-2">
                                                        <div class="iconColor align-content-center">
                                                            <i class="ri-barcode-box-fill"></i>
                                                        </div>
                                                        <div class="fontSize1">
                                                            <p class="fw-bolder">Package Code</p>
                                                            <p class="text-muted">TH-EX-001</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="highlights" class="section-block">
                                            <div class="card cardBackgroundColor rounded-3 p-3">
                                                <h5 class="fw-bolder">Highlights</h5>
                                                <div class="d-flex gap-3 mt-2">
                                                    <div class="highlightIcon">
                                                        <i class="ri-arrow-right-up-box-line"></i>
                                                    </div>
                                                    <p class="text-muted fontSize3 align-content-center">Exclusive merchandise available at each show</p>
                                                </div>
                                                <div class="d-flex gap-3 mt-2">
                                                    <div class="highlightIcon">
                                                        <i class="ri-arrow-right-up-box-line"></i>
                                                    </div>
                                                    <p class="text-muted fontSize3 align-content-center">VIP Packages with meet-and-greet options</p>
                                                </div>
                                                <div class="d-flex gap-3 mt-2">
                                                    <div class="highlightIcon">
                                                        <i class="ri-arrow-right-up-box-line"></i>
                                                    </div>
                                                    <p class="text-muted fontSize3 align-content-center">Special acoustic set in select cities</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="itinerary" class="section-block">
                                            <div class="card cardBackgroundColor rounded-3 p-3 pb-0">
                                                <h5 class="fw-bolder">Itinerary</h5>
                                                <div class="tour-details-content">
                                                    <div class="destination-accordion mt-2">
                                                        <div class="accordion" id="accordionItinerary">
                                                            <?php
                                                            $count = 1;

                                                            $data4 = $conn->prepare("SELECT * FROM package_trip_days WHERE package_id = $id");
                                                            $data4->execute();
                                                            $data4->setFetchMode(PDO::FETCH_ASSOC);

                                                            if ($data4->rowCount() > 0) {
                                                                foreach ($data4->fetchAll() as $key_3 => $day) {

                                                                    $decription = $day['day_details'];
                                                                    $decription_1 = explode(".", $decription);
                                                                    $decription_2 = implode(".<br>", $decription_1);
                                                            ?>
                                                                    <div class="accordion-item">
                                                                        <h2 class="accordion-header" id="panelsStayOpen-heading<?= $count; ?>">
                                                                            <button class="accordion-button <?= ($count != 1) ? 'collapsed' : ''; ?>"
                                                                                    type="button"
                                                                                    data-bs-toggle="collapse"
                                                                                    data-bs-target="#panelsStayOpen-collapse<?= $count; ?>"
                                                                                    aria-expanded="<?= ($count == 1) ? 'true' : 'false'; ?>"
                                                                                    aria-controls="panelsStayOpen-collapse<?= $count; ?>">

                                                                                Day <?= $key_3 + 1; ?> - <?= $day['title']; ?>

                                                                            </button>
                                                                        </h2>

                                                                        <div id="panelsStayOpen-collapse<?= $count; ?>"
                                                                            class="accordion-collapse collapse <?= ($count == 1) ? 'show' : ''; ?>"
                                                                            aria-labelledby="panelsStayOpen-heading<?= $count; ?>"
                                                                            data-bs-parent="#accordionItinerary">

                                                                            <div class="accordion-body">

                                                                                <ul class="listing">
                                                                                    <li class="list">
                                                                                        <?= $decription_2; ?>
                                                                                    </li>
                                                                                </ul>

                                                                                <hr class="my-3" style="border-top:1px solid #4b5051;">

                                                                                <div>
                                                                                    <div class="gap-1 d-flex">
                                                                                        <h6 class="fw-bold">Meal:&nbsp;</h6>
                                                                                        <p class="text-muted fontSize3"><?= $day['meal_plan']; ?></p>
                                                                                    </div>

                                                                                    <div class="gap-1 d-flex">
                                                                                        <h6 class="fw-bold">Transport:&nbsp;</h6>
                                                                                        <p class="text-muted fontSize3"><?= $day['day_tansport']; ?></p>
                                                                                    </div>

                                                                                    <div class="gap-1 d-flex">
                                                                                        <h6 class="fw-bold">Stay:&nbsp;</h6>
                                                                                        <p class="text-muted fontSize3"><?= $day['day_tansport']; ?></p>
                                                                                    </div>
                                                                                </div>

                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                            <?php
                                                                    $count++;
                                                                }
                                                            }
                                                            ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="inclusion" class="section-block">
                                            <div class="card cardBackgroundColor rounded-3 p-3">
                                                <h5 class="fw-bolder">Inclusion & Exclusion</h5>
                                                <div class="row">
                                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                                        <div class="d-flex gap-3 mt-2">
                                                            <div class="checkIcon">
                                                                <i class="ri-checkbox-circle-fill"></i>
                                                            </div>
                                                            <p class="text-muted fontSize3 align-content-center">Exclusive Merchandise</p>
                                                        </div>
                                                        <div class="d-flex gap-3 mt-2">
                                                            <div class="checkIcon">
                                                                <i class="ri-checkbox-circle-fill"></i>
                                                            </div>
                                                            <p class="text-muted fontSize3 align-content-center">Early Venue Access</p>
                                                        </div>
                                                        <div class="d-flex gap-3 mt-2">
                                                            <div class="checkIcon">
                                                                <i class="ri-checkbox-circle-fill"></i>
                                                            </div>
                                                            <p class="text-muted fontSize3 align-content-center">Acoustic Performance</p>
                                                        </div>
                                                        <div class="d-flex gap-3 mt-2">
                                                            <div class="checkIcon">
                                                                <i class="ri-checkbox-circle-fill"></i>
                                                            </div>
                                                            <p class="text-muted fontSize3 align-content-center">Tour Program</p>
                                                        </div>
                                                        <div class="d-flex gap-3 mt-2">
                                                            <div class="checkIcon">
                                                                <i class="ri-checkbox-circle-fill"></i>
                                                            </div>
                                                            <p class="text-muted fontSize3 align-content-center">Transportation (if applicable)</p>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                                        <div class="d-flex gap-3 mt-2">
                                                            <div class="closeIcon">
                                                                <i class="ri-close-circle-fill"></i>
                                                            </div>
                                                            <p class="text-muted fontSize3 align-content-center">Travel Expenses</p>
                                                        </div>
                                                        <div class="d-flex gap-3 mt-2">
                                                            <div class="closeIcon">
                                                                <i class="ri-close-circle-fill"></i>
                                                            </div>
                                                            <p class="text-muted fontSize3 align-content-center">Accommodation</p>
                                                        </div>
                                                        <div class="d-flex gap-3 mt-2">
                                                            <div class="closeIcon">
                                                                <i class="ri-close-circle-fill"></i>
                                                            </div>
                                                            <p class="text-muted fontSize3 align-content-center">Food and Beverage</p>
                                                        </div>
                                                        <div class="d-flex gap-3 mt-2">
                                                            <div class="closeIcon">
                                                                <i class="ri-close-circle-fill"></i>
                                                            </div>
                                                            <p class="text-muted fontSize3 align-content-center">Parking Fees</p>
                                                        </div>
                                                        <div class="d-flex gap-3 mt-2">
                                                            <div class="closeIcon">
                                                                <i class="ri-close-circle-fill"></i>
                                                            </div>
                                                            <p class="text-muted fontSize3 align-content-center">Personal Expenses</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="policies" class="section-block">
                                            <div class="card cardBackgroundColor rounded-3 p-3">
                                                <h5 class="fw-bolder mb-3">Policies</h5>
                                                <div class="policyItem">
                                                    <div class="d-flex align-items-center gap-3">
                                                        <div class="highlightIcon">
                                                            <i class="ri-file-pdf-line"></i>
                                                        </div>
                                                        <p class="mb-0">Package Brochure</p>
                                                    </div>
                                                    <a href="<?= $policy_file ?>" target="_blank" class="downloadBtn">
                                                        <i class="ri-download-line"></i>
                                                    </a>
                                                </div>
                                                <div class="policyItem">
                                                    <div class="d-flex align-items-center gap-3">
                                                        <div class="highlightIcon">
                                                            <i class="ri-file-pdf-line"></i>
                                                        </div>
                                                        <p class="mb-0">Detailed Itinerary</p>
                                                    </div>
                                                    <a href="uploads/detailed-itinerary.pdf" download class="downloadBtn">
                                                        <i class="ri-download-line"></i>
                                                    </a>
                                                </div>
                                                <div class="policyItem">
                                                    <div class="d-flex align-items-center gap-3">
                                                        <div class="highlightIcon">
                                                            <i class="ri-file-pdf-line"></i>
                                                        </div>
                                                        <p class="mb-0">Terms & Conditions</p>
                                                    </div>
                                                    <a href="uploads/terms-conditions.pdf" download class="downloadBtn">
                                                        <i class="ri-download-line"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="faqs" class="section-block">
                                            <div class="card cardBackgroundColor rounded-3 p-3 pb-0">
                                                <h5 class="fw-bolder">Frequently Asked Questions</h5>
                                                <div class="faq-wrapper mt-2">
                                                    <div class="faq-item active">
                                                        <div class="faq-header">
                                                            <h5>Does offer free cancellation for a full refund?</h5>
                                                            <i class="ri-eye-line faq-icon"></i>
                                                        </div>
                                                        <div class="faq-body">
                                                            <p>
                                                                Does have fully refundable room rates available to book on our site.
                                                                If you've booked a fully refundable room rate, this can be cancelled
                                                                up to a few days before check-in depending on the property's
                                                                cancellation policy. Just make sure to check this property's cancellation 
                                                                policy for the exact terms and conditions.
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <div class="faq-item">
                                                        <div class="faq-header">
                                                            <h5>Is there a pool?</h5>
                                                            <i class="ri-eye-off-line faq-icon"></i>
                                                        </div>

                                                        <div class="faq-body">
                                                            <p>Pool information goes here.</p>
                                                        </div>
                                                    </div>
                                                    <div class="faq-item">
                                                        <div class="faq-header">
                                                            <h5>Are pets allowed?</h5>
                                                            <i class="ri-eye-off-line faq-icon"></i>
                                                        </div>
                                                        <div class="faq-body">
                                                            <p>Pet policy goes here.</p>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-lg-3 col-md-12 col-sm-12 col-12 mb-3 pricing-wrapper">
                                    <!-- Pricing Section -->
                                    <div class="pricingSection">
                                        <div class="card priceCard rounded-3 mb-3">
                                            <div class="pricingHeader p-3">
                                                <h5 class="text-white fw-bolder mb-2"><?= $package['name'] ?></h5>
                                                <p class="text-white mb-2">Starting From</p>
                                                <div class="row">
                                                    <div class="col-xl-6 col-lg-12 col-md-6 col-sm-6 col-6">
                                                        <div class="border-end">
                                                            <h4 class="fw-bold text-white">&#8377; 22,900</h4>
                                                            <p class="text-white">Adult / Person</p>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-6 col-lg-12 col-md-6 col-sm-6 col-6">
                                                        <div class="">
                                                            <h4 class="fw-bold text-white">&#8377; 18,900</h4>
                                                            <p class="text-white">Child (5-12 yrs)</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="p-3">
                                                <div class="durationCard p-2 mb-3">
                                                    <p class="text-muted fw-bolder">Duration: <span class="text-black fw-bolder fs-5">4 Nights / 5 Days</span></p>
                                                </div>
                                                <button class="request-btn mb-3">
                                                    <i class="ri-image-line me-2"></i>
                                                    Request Details
                                                </button>      
                                                <button class="enquiry-btn mb-3">
                                                    <i class="ri-image-line me-2"></i>
                                                    Send Enquiry
                                                </button>  
                                                <div class="contactNum d-flex justify-content-center gap-2">
                                                    <i class="ri-phone-line"></i>
                                                    <p class="textBlue fw-bolder pb-0">+919677355555</p>    
                                                </div> 
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xl-4 col-lg-6 col-md-4 col-sm-4 col-4 mb-3">
                                                <div class="blueCardBtn text-center rounded-4 p-3">
                                                    <div class="goldBtn">
                                                        <i class="ri-download-2-line"></i>
                                                    </div>
                                                    Download Ininery
                                                </div>
                                            </div>
                                            <div class="col-xl-4 col-lg-6 col-md-4 col-sm-4 col-4 mb-3">
                                                <div class="blueCardBtn text-center rounded-4 p-3">
                                                    <div class="goldBtn">
                                                        <i class="ri-mail-line"></i>
                                                    </div>
                                                    Email Ininery
                                                </div>
                                            </div>
                                            <div class="col-xl-4 col-lg-6 col-md-4 col-sm-4 col-4 mb-3">
                                                <div class="blueCardBtn text-center rounded-4 p-3">
                                                    <div class="goldBtn">
                                                        <i class="ri-send-plane-line"></i>
                                                    </div>
                                                    Send Ininery
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card rounded-3 greenCard p-3 mb-3">
                                            <div class="d-flex gap-3 mb-2">
                                                <div class="greenIcon">
                                                    <i class="ri-calendar-check-line"></i>
                                                </div>
                                                <div class="greenCardText align-content-center">
                                                    <p class="fw-bolder text-black">Best Price Guarantee</p>
                                                    <p class="text-muted pb-0">Competitive pricing with exceptional travel value</p>
                                                </div>
                                            </div>
                                            <div class="d-flex gap-3 mb-2">
                                                <div class="greenIcon">
                                                    <i class="ri-calendar-check-line"></i>
                                                </div>
                                                <div class="greenCardText align-content-center">
                                                    <p class="fw-bolder text-black">Hassle Free Booking</p>
                                                    <p class="text-muted pb-0">Simple, quick and secure reservations</p>
                                                </div>
                                            </div>
                                            <div class="d-flex gap-3">
                                                <div class="greenIcon">
                                                    <i class="ri-calendar-check-line"></i>
                                                </div>
                                                <div class="greenCardText align-content-center">
                                                    <p class="fw-bolder text-black">End-to-End Travel Assistance</p>
                                                    <p class="text-muted pb-0">From planning to return, we've got you covered</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Card Section End 2 -->
                        </div>
                    </div>
                </div>
            </section>
            <!--/ End-of Destination -->
        </main>

        <!-- Footer S t a r t -->
        <?php include_once "footer.php" ?>
        <!--/ End-of Footer -->

        <!-- Scroll Up  -->
        <div class="progressParent" id="back-top">
            <svg class="backCircle svg-inner" width="100%" height="100%" viewBox="-1 -1 102 102">
                <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98" />
            </svg>
        </div>
        <!-- Add an search-overlay element -->
        <div class="search-overlay"></div>
        <!-- jquery-->
        <script src="assets/js/jquery-3.7.0.min.js"></script>
        <script src="assets/js/popper.min.js"></script>
        <script src="assets/js/bootstrap-5.3.0.min.js"></script>
        <!-- Plugin -->
        <script src="assets/js/plugin.js"></script>
        <!-- Main js-->
        <script src="assets/js/main.js"></script>
        <script type="text/javascript" src="logout/logout.js"></script>

        <script>

            function checkCustomerCoupons(cust_id) {
                if (cust_id) {
                    $.ajax({
                        type: "POST",
                        url: "assets/submit/check_customer_coupons.php",
                        data: {
                            cust_id: cust_id
                        },
                        dataType: "json",
                        success: function(response) {
                            const couponSelect = $('#coupon_select');
                            couponSelect.empty().append('<option value="" selected>Select a coupon</option>');

                            if (response.coupons && response.coupons.length > 0) {
                                couponSelect.empty().append('<option value="" disabled selected>Select a coupon</option>');

                                response.coupons.forEach(coupon => {
                                    couponSelect.append(
                                        `<option value="${coupon.code}" data-discount="${coupon.coupon_amt}">
                                            ${coupon.code} (₹${coupon.coupon_amt} off)
                                        </option>`
                                    );
                                });

                                const customerType = $('#specCust').text().toLowerCase();
                                const isPremium = customerType.includes('premium');
                                const total_adults_val = $("#b_no_adult").val()||1;
                                const total_child_val = $("#b_no_child").val()||0;
                                const totalMembers = total_adults_val + total_child_val;

                                //const totalMembers = parseInt($('#total_members').val() || 1); // Add this input in your form if not present

                                // Allow multiple coupon selection if Premium and more than 1 member
                                // if (isPremium && totalMembers > 1) {
                                //     couponSelect.attr('multiple', true);
                                // } else {
                                //     couponSelect.removeAttr('multiple');
                                // }
                                console.log('test');
                                
                                $('#discount_price_box').removeClass('d-none');
                                $('#offer_price_box').removeClass('d-none');
                                $('#primeCustomer').show();
                                $('#primeCustomer_span').removeClass('d-none');
                                $('#nonprimeCustomer').addClass('d-none');
                            } else {
                                $('#discount_price_box, #discount_price_box_amt, #offer_price_box').addClass('d-none');
                                $('#primeCustomer').hide();
                                $('#primeCustomer_span').addClass('d-none');
                                $('#nonprimeCustomer').removeClass('d-none');
                            }
                        },
                        error: function(err) {
                            console.log(err);
                        }
                    });
                }
            }

            // date function
            $(function() {
                var dtToday = new Date();
                var month = dtToday.getMonth() + 1;
                var day = dtToday.getDate() + 2;
                // console.log(day);

                var year = dtToday.getFullYear();
                if (month < 10)
                    month = '0' + month.toString();
                if (day < 10)
                    day = '0' + day.toString();
                var minDate = year + '-' + month + '-' + day;

                var maxToday = new Date(<?php echo json_encode($validity); ?>);
                var month = maxToday.getMonth() + 1;
                var day = maxToday.getDate();
                var year = maxToday.getFullYear();
                if (month < 10)
                    month = '0' + month.toString();
                if (day < 10)
                    day = '0' + day.toString();
                var maxDate = year + '-' + month + '-' + day;
                $('#b_date').attr('min', minDate);
                $('#b_date').attr('max', maxDate);
                $('#b_date').attr('value', '');
            });
            // date function

            // Initialize variables after DOM is loaded
            var adult_price, child_price, net_total, markup_total, coupon_offer = 0,
                total_offer_price = 0;
            let total_adults = 0,
                total_children = 0,
                total_infants = 0;
            let count_members = 0,
                no_adult, no_child;
            let cust_type, user_cust_id, user_type,ta_id;
            let ta_markup_price;

            // DOM elements
            var adult_count = document.getElementById('b_no_adult');
            var child_count = document.getElementById('b_no_child');
            var infant_count = document.getElementById('b_no_infants');
            var package_price = document.getElementById('get_total_package_price');
            var package_price_np = document.getElementById('get_total_package_price_np');
            var single_package_price = document.getElementById('get_single_adult_package_price');
            var single_package_price_np = document.getElementById('get_single_adult_package_price_np');
            var coupon_error = document.getElementById('coupon_error');
            var invalid_coupon_error = document.getElementById('invalid_coupon_error');
            var used_coupon_error = document.getElementById('used_coupon_error');
            var added_adult_price = 0;
            var prime_pack_price;

            $(document).ready(function() {
                //initialization
                $('#nonprimeCustomer').removeClass('d-none');
                // Parse price data
                const price_data = <?php echo json_encode($amount); ?>;
                added_adult_price = parseFloat(price_data['price_up_per_adult']);
                adult_price = parseFloat(price_data['total_package_price_per_adult']);
                child_price = parseFloat(price_data['total_package_price_per_child']);
                ta_markup_price = parseFloat(<?php echo $ta_markup_price_val; ?>);
                $('input[name="cust_type"]').on('change', function() {
                    const selectedValue = $(this).val();
                    handleCustomerType(selectedValue);
                });
                
                // Call once on load if you want to run the function based on default selection
                handleCustomerType($('input[name="cust_type"]:checked').val());

                function handleCustomerType(value) {
                    if (value === "1") {
                        $('#discount_price_box').addClass('d-none');
                        $('#discount_price_box_amt').addClass('d-none');
                        $('#offer_price_box').addClass('d-none');
                        $('#primeCustomer').hide();
                        $('#primeCustomer_span').addClass('d-none');
                        $('#nonprimeCustomer').removeClass('d-none');
                        $('#b_no_adult').val(1);
                        $('#b_no_child').val(0);
                        $('#b_no_infants').val(0);
                        var total1 = parseFloat(adult_price + added_adult_price + ta_markup_price).toFixed(2);
                        if (package_price_np) package_price_np.innerText = total1;
                        if (single_package_price_np) single_package_price_np.innerText = total1;

                        // Your code for registered
                    } else if (value === "2") {
                        $('#discount_price_box').addClass('d-none');
                        $('#discount_price_box_amt').addClass('d-none');
                        $('#offer_price_box').addClass('d-none');
                        $('#primeCustomer').hide();
                        $('#primeCustomer_span').addClass('d-none');
                        $('#nonprimeCustomer').removeClass('d-none');
                        $('#b_no_adult').val(1);
                        $('#b_no_child').val(0);
                        $('#b_no_infants').val(0);
                        var total1 = parseFloat(adult_price + added_adult_price + ta_markup_price).toFixed(2);
                        if (package_price_np) package_price_np.innerText = total1;
                        if (single_package_price_np) single_package_price_np.innerText = total1;
                    }
                }

                // Set initial values
                if (adult_count) adult_count.value = 1;

                var total1 = parseFloat(adult_price + added_adult_price + ta_markup_price).toFixed(2);
                if (package_price) package_price.innerText = total1;
                if (single_package_price) single_package_price.innerText = total1;

                //incase of prime customer
                var total = parseFloat(adult_price + added_adult_price + ta_markup_price).toFixed(2);
                if (package_price_np) package_price_np.innerText = total;
                if (single_package_price_np) single_package_price_np.innerText = total;
                prime_pack_price = parseFloat(adult_price + ta_markup_price).toFixed(2);
                $('#get_total_package_price_actual').text(prime_pack_price);
                var initialTotal = prime_pack_price;
                $('#get_total_offer_price').text(initialTotal);

                console.log('Initial price:', total);
                console.log('Initial offer price:', initialTotal);
                console.log('adult added price:', added_adult_price);

                // Update total on count change
                $('#b_no_adult, #b_no_child, #b_no_infants').on('change', function() {
                    getTotalPrice();
                });

                // Customer setup
                cust_type = $("input[name='cust_type']:checked").val();
                user_cust_id = <?php
                                    $data = json_encode($user_cust_id ?? 0, JSON_HEX_TAG);
                                    echo ($data === false) ? 0 : $data;
                            ?>

            

                getCustomersID(user_cust_id, cust_type);

                $("input[name='cust_type']").on('click', function() {
                    cust_type = $(this).val();
                    getCustomersID(user_cust_id, cust_type);
                    $("#cust_id, #b_name, #b_email, #b_phn_no, #dob, #coupon_code").val('');
                });

                // Travel Agent data setup
                user_type = <?php
                                $data = json_encode($user_type ?? 0, JSON_HEX_TAG);
                                echo ($data === false) ? 0 : $data;
                            ?>
                

            });

            //for seachable dropdown of customer ids
            $('#cust_id').select2({
                placeholder: "Select Customer ID",
                allowClear: true
            });

            // get reference customer for thet perticular travel agent
            function getCustomersID(user_cust_id, cust_type) {
                $.ajax({
                    type: "POST",
                    url: 'assets/submit/customers_id.php',
                    data: { user_cust_id: user_cust_id, status: cust_type },
                    success: function(response) {
                        $("#cust_id").html(response).trigger("change");
                    }
                });
            }


            // get Customer ID - when Travel agent selects Customer Id from dropdown get details of selected Customer and place them in book tour table.
            var cust_id = 0;
            var showButton = document.getElementById("book_tour");
            $("#cust_id").change(function() {
                var customerData;
                cust_id = $("#cust_id").val();
                console.log('customerId:'+cust_id);
                ta_id = <?php
                            $data = json_encode($ta_id ?? 0, JSON_HEX_TAG);
                            echo ($data === false) ? 0 : $data;
                        ?>
                
                if (cust_id && cust_id !="--Select Customer ID--") {
                    $.ajax({
                        type: "POST",
                        url: 'assets/submit/get_customer_details.php',
                        data: 'cust_id=' + cust_id + '&user_type=10&ta_id='+ta_id,
                        success: function(res) {
                            if (res == "fail") {
                                console.log("No Customer Data Found");
                            } else {
                                customerData = JSON.parse(res);
                                // console.log(customerData);
                                $("#b_name").val(customerData.firstname + ' ' + customerData.lastname);
                                $("#b_email").val(customerData.email);
                                $("#b_phn_no").val(customerData.contact_no);
                                $("#dob").val(customerData.age);
                                $("#coupon_code").val('');
                                let customerTypeRaw = customerData.customer_type.trim().toLowerCase(); // e.g., "premium"
                                //let formattedCustomerType = customerTypeRaw.charAt(0).toUpperCase() + customerTypeRaw.slice(1); // "Premium"

                                $("#specCust").text(customerTypeRaw + ' Customer');
                                console.log('customerTypeRaw:'+customerTypeRaw);
                                
                                // Check for customer coupons
                                checkCustomerCoupons(cust_id);
                                
                            }
                        },
                        error: function(err) {
                            console.log(err);
                        }
                    });
                    // let input = this;
                    // let list = document.getElementById("customer_suggestion").options;
                    // let val = input.value;
                    // // Check if selected value exists in suggestions
                    // for (let i = 0; i < list.length; i++) {
                    //     if (val === list[i].value) {
                    //         input.readOnly = true; // disable editing
                    //         break;
                    //     }
                    // }
                } else {
                    $("#cust_id").val('');
                    $("#b_name").val('').attr("placeholder", "Name");
                    $("#b_email").val('');
                    $("#b_phn_no").val('');
                    $("#dob").val('');

                    $("#coupon_code").val('');
                }
            });

            let appliedDiscount = 0;

            function applySelectedCoupon() {
                const selectedOptions = $('#coupon_select option:selected');

                if (selectedOptions.length > 1) {
                    alert("Only one coupon can be applied.");
                    $('#coupon_select').val('').trigger('change');
                    appliedDiscount = 0;
                    updateFinalPrice();
                    return;
                }

                appliedDiscount = 0;
                let selectedCoupons = [];

                selectedOptions.each(function () {
                    const discount = parseFloat($(this).data('discount')) || 0;
                    appliedDiscount += discount;
                    selectedCoupons.push($(this).val());
                });

                $('#get_total_discount_price').text(appliedDiscount.toFixed(2));
                $('#coupon_code').val(selectedCoupons.join(','));
                $('#get_coupon_price').val(appliedDiscount.toFixed(2));

                updateFinalPrice();
            }
            let offerPrice=0
            function updateFinalPrice() {
                const totalPrice = parseFloat($('#get_total_package_price').text()) || 0;
                offerPrice = totalPrice - appliedDiscount;
                $('#get_total_package_price_actual').text(offerPrice.toFixed(2));
            }

            // adults change
            $('#b_no_adult').on('change', function () {
                var adults = parseInt($('#b_no_adult').val(), 10) || 0;
                total_adults = adult_price * adults;
                getTotalPrice();
                updateFinalPrice(); // just recalc with existing discount
            });

            // children change
            $('#b_no_child').on('change', function () {
                var children = parseInt($('#b_no_child').val(), 10) || 0;
                total_children = child_price * children;
                getTotalPrice();
                updateFinalPrice(); // just recalc with existing discount
            });


            function getTotalPrice() {
                var adults = adult_count.value;
                var total_added_adult_price = added_adult_price * adults;
                var total = total_adults + total_children + ta_markup_price;
                var total1 = total_adults + total_added_adult_price + total_children + ta_markup_price;
                package_price.innerText = parseFloat(total).toFixed(2);
                package_price_np.innerText = parseFloat(total1).toFixed(2);
                $('#get_total_offer_price').text(parseFloat(total).toFixed(2));
                // $("#get_total_package_price_actual").text(parseFloat(total).toFixed(2));
                console.log('total:' + total + '--- tptal1:' + total1);
            }

            var coupon_applied_status = 'false';
            var discount_price_box = document.getElementById('discount_price_box');
            var offer_price_box = document.getElementById('offer_price_box');
            var get_total_discount_price = document.getElementById('get_total_discount_price');
            var get_total_offer_price = document.getElementById('get_total_offer_price');


            // check Box
            const gst_check = $("#get_gst");
            const coupons_check = $("#get_coupon");
            var gst_status = 'false';
            var coupon_status = 'false';
            var checkbox_status_coupon;

            gst_check.change(function(event) {
                var checkbox_status = event.target;
                if (checkbox_status.checked) {
                    gst_status = 'true';
                    document.getElementById('gst_number').style.display = "block";
                    // console.log('gst_status'+gst_status);
                } else {
                    gst_status = 'false';
                    document.getElementById('gst_number').style.display = "none";
                    // console.log('gst_status'+gst_status);
                }
            });
            

            // Add members
            var max_fields = 10,
                memberCount = 0;
            var wrapper = $(".input_fields_wrap_members"); // Fields wrapper
            var add_button = $(".add_field_button_member"); // Add button ID
            var x = 1; // Initial text box count

            $(document).ready(function() {
                $(add_button).click(function(e) { // On add input button click
                    e.preventDefault();
                    memberCount += 1;
                    if (x < max_fields) {
                        if (x < no_adult) { // Check for adults
                            x++; // Increment the counter
                            $(wrapper).append(`
                                <div class="row d-flex justify-content-between member-details mt-2 p-3">
                                    <div class="input-box col-12 col-sm-12 col-md-5 col-lg-5 col-xl-5 col-xxl-5">
                                        <label for="m_name">Adult</label>
                                        <input type="text" id="m_name_1" name="m_name[]" class="border-0 fs-6 w-100" placeholder="Name" onInput="validateTourMemberName(this)">
                                    </div>
                                    <div class="input-box col-6 col-sm-6 col-md-3 col-lg-3 col-xl-3 col-xxl-3">
                                        <label for="m_age_1"></label>
                                        <input type="text" id="m_age_1" name="m_age[]" class="border-0 fs-6 w-100" placeholder="Age" onblur="validateAge(this)" maxlength="3">
                                    </div>
                                    <div class="input-box col-6 col-sm-6 col-md-3 col-lg-3 col-xl-3 col-xxl-3">
                                        <label for="m_gender"></label>
                                        <select name="m_gender[]" class="border-0 fs-6 w-100" placeholder="Gender" class="selectdesign">
                                            <option value="male">Male</option>
                                            <option value="female">Female</option>
                                            <option value="other">Other</option>
                                        </select>
                                    </div>
                                    <a href="#" class="remove_field custom_btn btn2 lg_margin form-group col-2 bg-danger rounded-3 text-center text-white" style="padding:14px 10px; align-self:center; width: 100px;">Remove</a>
                                </div>`);
                            //members_error.style.display = "none";
                        } else if (x < no_adult + no_child) { // Check for children
                            x++; // Increment the counter
                            $(wrapper).append(`
                                <div class="row d-flex justify-content-between member-details mt-2 p-3">
                                    <div class="input-box col-12 col-sm-12 col-md-5 col-lg-5 col-xl-5 col-xxl-5">
                                        <label for="m_name">Child</label>
                                        <input type="text" id="m_name_1" name="m_name[]" class="border-0 fs-6 w-100" placeholder="Name" onInput="validateTourMemberName(this)">
                                    </div>
                                    <div class="input-box col-6 col-sm-6 col-md-3 col-lg-3 col-xl-3 col-xxl-3">
                                        <label for="m_age_1"></label>
                                        <input type="text" id="m_age_1" name="m_age[]" class="border-0 fs-6 w-100" placeholder="Age" onblur="validateAge(this)" maxlength="3">
                                    </div>
                                    <div class="input-box col-6 col-sm-6 col-md-3 col-lg-3 col-xl-3 col-xxl-3">
                                        <label for="m_gender"></label>
                                        <select name="m_gender[]" class="border-0 fs-6 w-100" placeholder="Gender" class="selectdesign">
                                            <option value="male">Male</option>
                                            <option value="female">Female</option>
                                            <option value="other">Other</option>
                                        </select>
                                    </div>
                                    <a href="#" class="remove_field custom_btn btn2 lg_margin form-group col-2 bg-danger rounded-3 text-center text-white" style="padding:14px 10px; align-self:center; width: 100px;">Remove</a>
                                </div>`);
                            //members_error.style.display = "none";
                        } else if (x < no_adult + no_child + total_infants) { // Check for infants
                            x++; // Increment the counter
                            $(wrapper).append(`
                                <div class="row d-flex justify-content-between member-details mt-2 p-3">
                                    <div class="input-box col-12 col-sm-12 col-md-5 col-lg-5 col-xl-5 col-xxl-5">
                                        <label for="m_name">Infant</label>
                                        <input type="text" id="m_name_1" name="m_name[]" class="border-0 fs-6 w-100" placeholder="Name" onInput="validateTourMemberName(this)">
                                    </div>
                                    <div class="input-box col-6 col-sm-6 col-md-3 col-lg-3 col-xl-3 col-xxl-3">
                                        <label for="m_age_1"></label>
                                        <input type="text" id="m_age_1" name="m_age[]" class="border-0 fs-6 w-100" placeholder="Age" onblur="validateAge(this)" maxlength="3">
                                    </div>
                                    <div class="input-box col-6 col-sm-6 col-md-3 col-lg-3 col-xl-3 col-xxl-3">
                                        <label for="m_gender"></label>
                                        <select name="m_gender[]" class="border-0 fs-6 w-100" placeholder="Gender" class="selectdesign">
                                            <option value="male">Male</option>
                                            <option value="female">Female</option>
                                            <option value="other">Other</option>
                                        </select>
                                    </div>
                                    <a href="#" class="remove_field custom_btn btn2 lg_margin form-group col-2 bg-danger rounded-3 text-center text-white" style="padding:14px 10px; align-self:center; width: 100px;">Remove</a>
                                </div>`);
                            //members_error.style.display = "none";
                        }
                    }
                    // Reduce add member count onClick
                    reduceMemberCount();
                });

                // User clicks on remove text
                $(wrapper).on("click", ".remove_field", function(e) {
                    e.preventDefault();
                    $(this).parent('div').remove();
                    x--;

                    // Reduce add member count onClick
                    reduceMemberCount();
                });
            });

            // Function to reduce the member count
            function reduceMemberCount() {
                show_count = max_fields - x;
                member_count.innerText = Math.abs(show_count);

                if (show_count == 0) {
                    show_add_button.style.display = "none";
                } else if (show_count < 0) {
                    show_add_button.style.display = "block";
                    show_add_remove_member.innerText = "Remove";
                    show_add_button.style.backgroundColor = "#96a701";
                } else {
                    show_add_button.style.display = "block";
                    show_add_remove_member.innerText = "Add";
                    show_add_button.style.backgroundColor = "#21a827";
                }
            }
            var show_count;
            var show_add_button = document.getElementById("add_field_button_member");
            var show_add_remove_member = document.getElementById("show_add_remove_member");


            $("#cancel_order").click(function(e) {
                e.preventDefault();
                hideTourMemberForm();
            });

            function hideTourMemberForm() {
                $(".page_body").removeClass("parent_disable");
                $(".page_footer").removeClass("parent_footer_disable");
                document.getElementById("show_ticket_book_box").style.display = "none";
            }


            // Booking tickets
            $('#book_tour').click(function(e) {
                e.preventDefault();
                //--------------------------------------------------------------------------------------------
                //--------------------------------------------------------------------------------------------
                //--------------------------------------------------------------------------------------------
                //--------------------------------------------------------------------------------------------
                //--------------------------------------------------------------------------------------------
                //--------------------------------------------------------------------------------------------
                //--------------------------------------------------------------------------------------------
                //--------------------------------------------------------------------------------------------
                // alert("Sorry, Booking are not opend yet !.");
                // return null;
                //----comment
                //--------------------------------------------------------------------------------------------
                //--------------------------------------------------------------------------------------------
                //--------------------------------------------------------------------------------------------
                //--------------------------------------------------------------------------------------------
                //--------------------------------------------------------------------------------------------
                //--------------------------------------------------------------------------------------------
                //--------------------------------------------------------------------------------------------
                //--------------------------------------------------------------------------------------------
                //--------------------------------------------------------------------------------------------
                //--------------------------------------------------------------------------------------------


                if (user_type == '11') {

                    var name = $("#b_name").val();
                    var email = $("#b_email").val();
                    var phone = $("#b_phn_no").val();
                    var date = $("#b_date").val();
                    var no_adult = $("#b_no_adult").val();
                    var gst_number = $("#gst_number").val();
                    var coupon_code = $("#coupon_code").val();

                    if (name == "" || name == " " || email == "" || phone == "" || date == "" || no_adult == "" || gst_status == "true" || coupon_status == "true" || package_terms_status == 'false') {
                        if (name == "" || name == " ") {
                            alert("Please Enter Name !");
                        } else if (email == "") {
                            alert("Please Enter Email !");
                        } else if (phone == "") {
                            alert("Please Enter Phone Number !");
                        } else if (date == "") {
                            alert("Please Select Tour Date !");
                        } else if (no_adult == "") {
                            alert("Please Enter Number of Adults !");
                        } else if (package_terms_status == 'false') {
                            alert("Please, Read and accept terms and condition!!");
                        } else if (gst_status == "true" && gst_number == "") {
                            alert("PLease Enter Valid GST Number, or Uncheck the Check-Box");
                        } else if (coupon_status == "true" && coupon_code == "") {
                            alert("PLease Enter Valid Coupon Code, or Uncheck the Check-Box");
                        } else {
                            if (emailValidation(email)) {
                                getMemberCount();
                                reduceMemberCount();
                            } else {
                                alert('Please, enter valid Email Id !!');
                            }
                        }
                    } else {
                        if (emailValidation(email)) {
                            getMemberCount();
                            reduceMemberCount();
                        } else {
                            alert('Please, enter valid Email Id !!');
                        }
                    }
                } else {
                    alert("Sorry, you are not allowed to Book Tour !! Only Travel Consultant can Book Tour.");
                }
            });

            //accept terms for booking package
            const terms_check = $("#terms_condtion");
            var package_terms_status = 'false';

            terms_check.change(function(event) {
                var terms = event.target;
                if (terms.checked) {
                    package_terms_status = 'true';
                } else {
                    package_terms_status = 'false';
                }
            });

            const member_count = document.getElementById("member_count");

            function getMemberCount() {
                $(".page_body").addClass("parent_disable");
                $(".page_footer").addClass("parent_footer_disable");

                var dob = $("#dob").val();
                // miliseconds from epoch
                //var dob_years;
                if (dob == '') {
                    dob_years = '';
                    adult_age_count = 0;
                } else {
                    adult_age_count = 1;
                //dob_years = Math.abs(age_date.getUTCFullYear() - 1970);
                }
                // document.getElementById("show_ticket_book_box").style.display = "block";
                $('#show_ticket_book_box').modal('show');
                document.getElementById("m_name_1").value = $("#b_name").val();
                document.getElementById("m_age_1").value = dob;

                no_adult = $("#b_no_adult").val();
                no_child = $("#b_no_child").val();
                // get member count
                no_adult = parseInt(no_adult, 10);
                if (no_child) {
                    no_child = parseInt(no_child, 10);
                } else {
                    no_child = 0;
                }
                total_infants = infant_count.value
                if (total_infants) {
                    total_infants = parseInt(total_infants, 10);
                } else {
                    total_infants = 0;
                }
                max_fields = no_adult + no_child + total_infants
                member_count.innerText = max_fields - 1;
                if (max_fields > 1) {
                    document.getElementById("show_add_member").style.display = "block";
                    document.getElementById("hide_add_member").style.display = "none";
                } else {
                    document.getElementById("show_add_member").style.display = "none";
                    document.getElementById("hide_add_member").style.display = "block";
                }
            }

            var members = [];
            var names = document.getElementsByName('m_name[]');
            var ages = document.getElementsByName('m_age[]');
            var genders = document.getElementsByName('m_gender[]');
            var members_error = document.getElementById('members_error');

            var member_validationAdult = document.getElementById('member_validationAdult');
            var member_validationChild = document.getElementById('member_validationChild');
            var member_validationInfant = document.getElementById('member_validationInfant');
            var member_validationName = document.getElementById('member_validationName');
            var member_validation = document.getElementById('member_validation');

            var adult_age_min = 12,
                child_age_max = 11,
                child_age_min = 3,
                infant_age_max = 2;
            var adult_age_count = 0,
                child_age_count = 0,
                infant_age_count = 0;

            function validateTourMemberName(e) {
                if (regexExp.test(e.value)) {
                    e.classList.add('invalid_input');
                    member_validationName.style.display = "block";
                    member_validationName.innerText = "Please Enter valid Name !!";
                } else {
                    e.classList.remove('invalid_input');
                    member_validationName.style.display = "none";
                }
            }


            // Replace the validateAge function with this version
            function validateAge(input) {
                let age = parseInt(input.value, 10);
                let parentDiv = input.closest('.row');
                let labelElement = parentDiv.querySelector('label[for="m_name"]');
                let memberType = labelElement.innerText.trim(); // Get the fixed label (Adult/Child/Infant)

                // Check if the input is a valid number
                if (isNaN(age) || age < 0) {
                    showError(document.getElementById('member_validation'), "Please enter a valid age.");
                    return false;
                }

                // Validate age based on the fixed label
                if (memberType === "Adult" && age < 12) {
                    showError(document.getElementById('member_validationAdult'), "Adult must be 12 years or older");
                    return false;
                } else if (memberType === "Child" && (age < 3 || age > 11)) {
                    showError(document.getElementById('member_validationChild'), "Child must be between 3-11 years");
                    return false;
                } else if (memberType === "Infant" && age > 2) {
                    showError(document.getElementById('member_validationInfant'), "Infant must be 2 years or younger");
                    return false;
                }

                // If validation passed, hide any error messages
                hideError(document.getElementById('member_validation'));
                hideError(document.getElementById('member_validationAdult'));
                hideError(document.getElementById('member_validationChild'));
                hideError(document.getElementById('member_validationInfant'));

                // Validate counts against the allowed numbers
                validateMemberCounts();
                return true;
            }

            // Keep the validateMemberCounts function but modify it to check fixed labels
            function validateMemberCounts() {
                let adultCount = 0;
                let childCount = 0;
                let infantCount = 0;

                // Get all member rows and count based on fixed labels
                $(".row.d-flex.justify-content-between").each(function() {
                    let label = $(this).find('label[for="m_name"]').text().trim();
                    let ageInput = $(this).find('input[name="m_age[]"]');
                    let age = parseInt(ageInput.val(), 10);

                    if (!isNaN(age)) {
                        if (label === "Adult") adultCount++;
                        else if (label === "Child") childCount++;
                        else if (label === "Infant") infantCount++;
                    }
                });

                // Get allowed counts from the form
                let allowedAdults = parseInt($("#b_no_adult").val()) || 0;
                let allowedChildren = parseInt($("#b_no_child").val()) || 0;
                let allowedInfants = parseInt($("#b_no_infants").val()) || 0;

                // Validate counts
                if (adultCount > allowedAdults) {
                    showError(document.getElementById('member_validationAdult'), "Too many adults! Maximum allowed: " + allowedAdults);
                } else {
                    hideError(document.getElementById('member_validationAdult'));
                }

                if (childCount > allowedChildren) {
                    showError(document.getElementById('member_validationChild'), "Too many children! Maximum allowed: " + allowedChildren);
                } else {
                    hideError(document.getElementById('member_validationChild'));
                }

                if (infantCount > allowedInfants) {
                    showError(document.getElementById('member_validationInfant'), "Too many infants! Maximum allowed: " + allowedInfants);
                } else {
                    hideError(document.getElementById('member_validationInfant'));
                }
            }

            // Function to show error messages
            function showError(element, message) {
                element.style.display = 'block';
                element.innerText = message;
            }

            // Function to hide error messages
            function hideError(element) {
                element.style.display = 'none';
            }

            // Function to count members by age range (used for adults, children, infants)
            function countMembersByAge(minAge, maxAge) {
                let ageInputs = document.querySelectorAll("input[name='m_age[]']");
                let count = 0;

                // Loop through the age inputs and count those that match the age range
                ageInputs.forEach(input => {
                    let age = parseInt(input.value, 10);
                    if (!isNaN(age) && age >= minAge && (maxAge ? age <= maxAge : true)) {
                        count++;
                    }
                });

                return count;
            }
            $('#cancel_order').click(function(e) {
                e.preventDefault();
                setTimeout(() => {
                    location.reload();
                }, 2000);
            });

            const fullRadio = document.getElementById('inlineRadio1');
            const partRadio = document.getElementById('inlineRadio2');
            const payTypeSelect = document.getElementById('payTypeSelect');
            const amountInput = document.getElementById('amountInput');
            const divToToggle = document.getElementById('toggleDiv');

            $('#pay_modal').on('click', function () {
                updateFinalPrice()            
                // Part Payment Modal Start
                const amountToBePaidElement = document.getElementById('amountToBePaid');
                var np_total = $('#get_total_package_price_np').text().trim();
                var p_total = offerPrice;
                let final_pack_amount;

                if ($('#offer_price_box').hasClass('d-none')) {
                    if ($('#nonprimeCustomer').hasClass('d-none')) {
                        final_pack_amount = p_total;
                    } else {
                        final_pack_amount = np_total;
                    }
                } else {
                    final_pack_amount = offerPrice;
                }

                $('#amountToBePaid').text(final_pack_amount);
                console.log("modal price: " + final_pack_amount);

                let totalAmount = parseFloat(final_pack_amount) || 0;

                setTimeout(function () {
                    var bal_amt = parseFloat($.trim($('#avalableBalance').text())) || 0;
                    var amountToBePaidVal = parseFloat($('#amountToBePaid').text()) || 0;

                    if (isNaN(bal_amt) || isNaN(amountToBePaidVal)) {
                        console.log('Error: invalid number');
                        return;
                    }

                    console.log('Available Balance:', bal_amt);
                    console.log('Amount To Be Paid:', amountToBePaidVal);

                    if (bal_amt < amountToBePaidVal) {
                        $('#low_bal').removeClass('d-none');
                        partRadio.checked = true;
                        fullRadio.checked = false;
                        fullRadio.disabled = true; // Disable full payment option
                        divToToggle.style.display = 'block';
                        updateAmount();

                        var part1 = totalAmount * 0.4;
                        var partAmount = totalAmount / 2;

                        if (bal_amt < part1 && bal_amt < partAmount) {
                            $('#low_bal').text('Low balance! Please TopUp');
                            $('#payTypeDiv').addClass('d-none');
                            $('#place_order').addClass('d-none');
                        } else {
                            $('#payTypeDiv').removeClass('d-none');
                            $('#place_order').removeClass('d-none');
                        }

                    } else {
                        updateAmount();
                        $('#low_bal').addClass('d-none');
                    }
                }, 500);

                // Initially, hide the "Part" selection
                divToToggle.style.display = 'none';
                amountInput.value = totalAmount;

                // radio & dropdown listeners
                partRadio.addEventListener('change', function () {
                    if (this.checked) {
                        divToToggle.style.display = 'block';
                        updateAmount();
                    }
                });

                fullRadio.addEventListener('change', function () {
                    if (this.checked) {
                        divToToggle.style.display = 'none';
                        amountInput.value = totalAmount;
                    }
                });

                payTypeSelect.addEventListener('change', function () {
                    updateAmount();
                });

                function updateAmount() {
                    const selectedValue = payTypeSelect.value;
                    if (selectedValue === '2') {
                        amountInput.value = (totalAmount / 2).toFixed(2); // 50% each
                    } else if (selectedValue === '3') {
                        amountInput.value = (totalAmount * 0.4).toFixed(2); // First part - 40%
                    } else {
                        amountInput.value = totalAmount.toFixed(2); // Full amount
                    }
                }
                // Part Payment Modal end

                // finally, show the modal
                $('#paymentModal').modal('show');
            });


            $('#place_order').click(async function(e) {
                e.preventDefault();
                console.log("in place order");
                //product_package_payout();
                //valiadtions

                var status = false;
                names = $("input[name='m_name[]']").map(function() {
                    return $(this).val().trim();
                }).get();

                ages = $("input[name='m_age[]']").map(function() {
                    return $(this).val().trim();
                }).get();
                genders = $("select[name='m_gender[]']").map(function() {
                    return $(this).val();
                }).get();
                for (let i = 0; i < names.length; i++) {
                    if (names[i] === "" && ages[i] === "") {
                        alert("Both Name and Age Cannot be Empty!");
                        status = false;
                        break; // Stop checking further since we found an error
                    } else if (names[i] === "") {
                        alert("Name Cannot be Empty!");
                        status = false;
                        break;
                    } else if (ages[i] === "") {
                        alert("Age Cannot be Empty!");
                        status = false;
                        break;
                    } else {
                        status = true;
                    }
                }

                //console.log("status:"+status);

                // get data
                if (status == true) {

                    if (names.length == max_fields) {
                        //members_error.style.display = "none";
                        members = [];
                        //
                        try {
                            // Wait for getTourData to complete first
                            // const tourData = await getTourData();
                            // console.log('Tour Data:', tourData);

                            // // Now, proceed to call product_package_payout
                            // const payoutResult = await product_package_payout();
                            // console.log('Payout Result:', payoutResult);

                            var cust_id = $("#cust_id").val();
                            var package_id = $("#package_id").val();
                            var name = $("#b_name").val();
                            var email = $("#b_email").val();
                            var phone = $("#b_phn_no").val();
                            var date = $("#b_date").val();
                            // will generate current time stamp payment id 
                            var payment_id = makepayid(25)
                            var paid_amount = $('#amountInput').val()
                            var selectedValue = $("input[name='inlineRadioOptions']:checked").val();
                            var paytype
                            //coupon details
                            var selectedOption = $('#coupon_select option:selected');
                            var couponDiscount = selectedOption.data('discount') || 0;
                            var couponCode = $('#coupon_select').val();
                            //payouts part
                            var packageID = $('#package_id').val();
                            var userID = $('#user_id').val();
                            var cuID = $('#cust_id').val();
                            var no_of_adult = $('#b_no_adult').val();
                            var no_of_child = $('#b_no_child').val();
                            var ta_markup = ta_markup_price ?? 0;
                            //var book_id = $('#book_id').val();
                            var tour_start_date = $('#b_date').val();
                            var discounted_price = $('#get_total_offer_price').text();

                            if (selectedValue == 'option1') {
                                pay_type = 1 //full payment
                            } //if part payment is seleted
                            else if (selectedValue == 'option2') {
                                pay_type = $("#payTypeSelect").val(); // 2 for 2 parts and 3 for 2 parts
                            }
                            if (partRadio.checked && (payTypeSelect.value === "" || payTypeSelect.value === "--Select the Pay Type")) {
                                alert("Please select a valid payment type.");
                                event.preventDefault(); // Prevent form submission
                                return false;
                            } else {
                                // get payers details for travel agent
                                if (user_type == 11) {
                                    payee_id = user_cust_id;
                                    payee_name = $("#payee_name").val();
                                    payee_email = $("#payee_email").val();
                                    payee_contact = $("#payee_contact").val();
                                }
                                var formdata = {
                                    user_cust_id: user_cust_id, 
                                    cust_id: cust_id,
                                    package_id: package_id,
                                    name: name,
                                    email: email,
                                    phone: phone,
                                    date: date,
                                    adults: no_adult,
                                    child: no_child,
                                    infants: total_infants,
                                    total_price: package_price.innerText,
                                    ta_markup: ta_markup_price,
                                    members: [],
                                    payee_name: payee_name,
                                    payee_id: payee_id,
                                    payment_id: payment_id,
                                    paid_amount: paid_amount,
                                    pay_type: pay_type,
                                    couponCode: couponCode,
                                    couponDiscount: couponDiscount,
                                    packageID: packageID,
                                    userID: userID, //tc id
                                    cuID: cuID,
                                    no_of_adult: no_of_adult,
                                    no_of_child: no_of_child,
                                    ta_markup: ta_markup,
                                    tour_start_date: tour_start_date,
                                    discounted_price: discounted_price,
                                };
                                names.forEach(function(name, i) {
                                    formdata.members.push({
                                        'name': name,
                                        'age': ages[i],
                                        'gender': genders[i]
                                    });
                                });
                                console.log("formdata");
                                console.log(formdata);
                                //resolve(formdata)
                                // Book Package
                                let data = formdata;
                                $.ajax({
                                    type: "POST",
                                    url: "assets/submit/book-tickets.php",
                                    data: JSON.stringify(data),
                                    contentType: "application/json",
                                    dataType: "json",
                                    // headers: {
                                    //     "Content-Type": "application/json",
                                    //     "X-CSRF-TOKEN": $('meta[name="csrf-token').attr('content')
                                    // },
                                    success: function(res) {

                                        //$('#book_id').val(res.bookid);
                                        if (res.status == 1) {
                                            console.log("success payment");
                                            // ✅ Add invoice_no to data
                                            let secondData = {
                                                ...formdata, // ✅ use original object
                                                invoice_no: res.invoice_no,
                                                booking_id: res.booking_id
                                            };
                                            // hideTourMemberForm();
                                            // // empty fields
                                            // $("#b_name").val('');
                                            // $("#b_email").val('');
                                            // $("#b_phn_no").val('');
                                            // $("#b_date").val('');
                                            // $("#b_no_adult").val('');
                                            // $("#b_no_child").val('');
                                            // $("#b_no_infants").val('');

                                            // names.forEach(function(data, i) {
                                            //     data.value = "";
                                            // });
                                            // ages.forEach(function(data, i) {
                                            //     data.value = "";
                                            // });
                                            // genders.forEach(function(data, i) {
                                            //     data.value = "male";
                                            // });

                                            alert('Booking successful. proceeding to Payment Gateway.');
                                            // resolve(res); // Resolve the promise on success
                                            // location.reload();
                                            //make new snackbar
                                            // showBottomSnackBar("Success !! Order placed for Booking ");
                                            // setTimeout(function() {
                                            //     location.reload();
                                            // }, 4000);

                                            $.ajax({
                                                type: "POST",
                                                url: "assets/submit/create-payment.php",
                                                data: JSON.stringify(secondData),
                                                contentType: "application/json",
                                                dataType: "json",
                                                // headers: {
                                                //     "Content-Type": "application/json",
                                                //     "X-CSRF-TOKEN": $('meta[name="csrf-token').attr('content')
                                                // },
                                                success: function(res) {
                                                    if (res.status === "success") {
                                                        window.location.href = res.payment_url;
                                                    } else {
                                                        $("#status").text(res.message);
                                                        $("#payBtn").prop("disabled", false).text("Book Now");
                                                    }
                                                }
                                            });

                                        } else {
                                            alert("failed to book");
                                            // resolve(res); // Resolve with unsuccessful result
                                            // location.reload();
                                        }
                                    },
                                    error: function(err) {
                                        console.log(err);
                                        // reject(err); // Reject the promise on error
                                    }
                                });
                            }
                            //console.log('paytype:' + paytype);

                            // console.log("Both AJAX calls have completed successfully.");
                            // $("#b_name").val('');
                            // $("#b_email").val('');
                            // $("#b_phn_no").val('');
                            // $("#b_date").val('');
                            // $("#b_no_adult").val('');
                            // $("#b_no_child").val('');
                            // $("#b_no_infants").val('');

                            // names.forEach(function(data, i) {
                            //     data.value = "";
                            // });
                            // ages.forEach(function(data, i) {
                            //     data.value = "";
                            // });
                            // genders.forEach(function(data, i) {
                            //     data.value = "male";
                            // });
                            // location.reload();
                        } catch (error) {
                            console.error("An error occurred:", error);
                        }

                        // console.log('place order');
                    } else if (names.length > max_fields) {
                        members_error.style.display = "block";
                        members_error.innerText = "Please remove extra members !!";
                        // console.log( names.length +' more than total = '+max_fields);
                    } else {
                        members_error.style.display = "block";
                        members_error.innerText = "Please add remaining members !!";
                        // console.log( names.length +' Remaing / of '+max_fields);
                    }
                }
            });

            // function product_package_payout() {
            //     return new Promise((resolve, reject) => {
            //         var packageID = $('#package_id').val();
            //         var userID = $('#user_id').val();
            //         var cuID = $('#cust_id').val();
            //         var no_of_adult = $('#b_no_adult').val();
            //         var no_of_child = $('#b_no_child').val();
            //         var ta_markup = ta_markup_price ?? 0;
            //         var book_id = $('#book_id').val();
            //         var tour_start_date = $('#b_date').val();
            //         // console.log(packageID + ' ' + userID + ' ' + cuID +' '+ no_of_adult + ' ' + ta_markup+ ' '+book_id+' '+tour_start_date);
            //         dataString = {
            //             packageID: packageID,
            //             userID: userID,
            //             cuID: cuID,
            //             no_of_adult: no_of_adult,
            //             no_of_child: no_of_child,
            //             ta_markup: ta_markup,
            //             book_id: book_id,
            //             tour_start_date: tour_start_date,
            //         };
            //         let data = JSON.stringify(dataString);
            //         console.log(data);
            //         $.ajax({
            //             type: "POST",
            //             url: "assets/submit/product_package_payout.php",
            //             data: data,
            //             headers: {
            //                 "Content-Type": "application/json",
            //                 "X-CSRF-TOKEN": $('meta[name="csrf-token').attr('content')
            //             },
            //             success: function(res) {
            //                 // console.log(res);
            //                 if (res == '1') {
            //                     alert("SUCCESS");
            //                     console.log(res);
            //                     // setTimeout(() => {
            //                     //     location.reload();
            //                     // }, 2000);
            //                     resolve(res); // Resolve the promise on success
            //                 } else {
            //                     alert("UNSUCCESS");
            //                     console.log(res);
            //                     // setTimeout(() => {
            //                     //     location.reload();
            //                     // }, 2000);
            //                     resolve(res); // Resolve with unsuccessful result
            //                 }
            //             },
            //             error: function(err) {
            //                 console.log(err);
            //                 reject(err); // Reject the promise on error
            //             }
            //         });
            //     });
            // }

            // function getTourData() {
            //     return new Promise((resolve, reject) => {
            //         var cust_id = $("#cust_id").val();
            //         var package_id = $("#package_id").val();
            //         var name = $("#b_name").val();
            //         var email = $("#b_email").val();
            //         var phone = $("#b_phn_no").val();
            //         var date = $("#b_date").val();
            //         // will generate current time stamp payment id 
            //         var payment_id = makepayid(25)
            //         var paid_amount = $('#amountInput').val()
            //         var selectedValue = $("input[name='inlineRadioOptions']:checked").val();
            //         var paytype
            //         //coupon details
            //         var selectedOption = $('#coupon_select option:selected');
            //         var couponDiscount = selectedOption.data('discount') || 0;
            //         var couponCode = $('#coupon_select').val();
            //         //payouts part
            //         var packageID = $('#package_id').val();
            //         var userID = $('#user_id').val();
            //         var cuID = $('#cust_id').val();
            //         var no_of_adult = $('#b_no_adult').val();
            //         var no_of_child = $('#b_no_child').val();
            //         var ta_markup = ta_markup_price ?? 0;
            //         //var book_id = $('#book_id').val();
            //         var tour_start_date = $('#b_date').val();
            //         var discounted_price = $('#get_total_offer_price').text();

            //         if (selectedValue == 'option1') {
            //             pay_type = 1 //full payment
            //         } //if part payment is seleted
            //         else if (selectedValue == 'option2') {
            //             pay_type = $("#payTypeSelect").val(); // 2 for 2 parts and 3 for 2 parts
            //         }
            //         if (partRadio.checked && (payTypeSelect.value === "" || payTypeSelect.value === "--Select the Pay Type")) {
            //             alert("Please select a valid payment type.");
            //             event.preventDefault(); // Prevent form submission
            //             return false;
            //         } else {
            //             // get payers details for travel agent
            //             if (user_type == 11) {
            //                 payee_id = user_cust_id;
            //                 payee_name = $("#payee_name").val();
            //                 payee_email = $("#payee_email").val();
            //                 payee_contact = $("#payee_contact").val();
            //             }
            //             var formdata = {
            //                 user_cust_id: user_cust_id,
            //                 cust_id: cust_id,
            //                 package_id: package_id,
            //                 name: name,
            //                 email: email,
            //                 phone: phone,
            //                 date: date,
            //                 adults: no_adult,
            //                 child: no_child,
            //                 infants: total_infants,
            //                 total_price: package_price.innerText,
            //                 ta_markup: ta_markup_price,
            //                 members: [],
            //                 payee_name: payee_name,
            //                 payee_id: payee_id,
            //                 payment_id: payment_id,
            //                 paid_amount: paid_amount,
            //                 pay_type: pay_type,
            //                 couponCode: couponCode,
            //                 couponDiscount: couponDiscount,
            //                 packageID: packageID,
            //                 userID: userID,
            //                 cuID: cuID,
            //                 no_of_adult: no_of_adult,
            //                 no_of_child: no_of_child,
            //                 ta_markup: ta_markup,
            //                 tour_start_date: tour_start_date,
            //                 discounted_price: discounted_price,
            //             };
            //             names.forEach(function(name, i) {
            //                 formdata.members.push({
            //                     'name': name,
            //                     'age': ages[i],
            //                     'gender': genders[i]
            //                 });
            //             });
            //             console.log("formdata");
            //             console.log(formdata);
            //             //resolve(formdata)
            //             // Book Package
            //             let data = JSON.stringify(formdata);
            //             $.ajax({
            //                 type: "POST",
            //                 url: "assets/submit/book-tickets.php",
            //                 data: data,
            //                 headers: {
            //                     "Content-Type": "application/json",
            //                     "X-CSRF-TOKEN": $('meta[name="csrf-token').attr('content')
            //                 },
            //                 success: function(res) {

            //                     //$('#book_id').val(res.bookid);
            //                     if (res == 1) {
            //                         console.log("success payment");
            //                         hideTourMemberForm();
            //                         // empty fields
            //                         // $("#b_name").val('');
            //                         // $("#b_email").val('');
            //                         // $("#b_phn_no").val('');
            //                         // $("#b_date").val('');
            //                         // $("#b_no_adult").val('');
            //                         // $("#b_no_child").val('');
            //                         // $("#b_no_infants").val('');

            //                         // names.forEach(function(data, i) {
            //                         //     data.value = "";
            //                         // });
            //                         // ages.forEach(function(data, i) {
            //                         //     data.value = "";
            //                         // });
            //                         // genders.forEach(function(data, i) {
            //                         //     data.value = "male";
            //                         // });

            //                         alert('Booking is successful')
            //                         resolve(res); // Resolve the promise on success
            //                         // location.reload();
            //                         //make new snackbar
            //                         // showBottomSnackBar("Success !! Order placed for Booking ");
            //                         // setTimeout(function() {
            //                         //     location.reload();
            //                         // }, 4000);
            //                     } else {
            //                         alert("failed to book");
            //                         resolve(res); // Resolve with unsuccessful result
            //                     }
            //                 },
            //                 error: function(err) {
            //                     console.log(err);
            //                     reject(err); // Reject the promise on error
            //                 }
            //             });
            //         }
            //         //console.log('paytype:' + paytype);
            //     });
            // }

            // generate order id

            function makeid(length) {
                var result = '';
                var characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
                var charactersLength = characters.length;
                for (var i = 0; i < length; i++) {
                    result += characters.charAt(Math.floor(Math.random() *
                        charactersLength));
                }
                return result;
            }

            function makepayid(length) {
                var result = 'Paid_';
                const timestamp = Date.now();
                var characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
                var charactersLength = characters.length;
                result += timestamp;
                for (var i = 0; i < length; i++) {
                    result += characters.charAt(Math.floor(Math.random() *
                        charactersLength));
                }
                return result;
            }


            var currentdate = new Date();
            var year = currentdate.getFullYear() + "" + "_" + currentdate.getHours();
            var order_id = 'order_' + year + "" + makeid(10); // generate order id


            // comments
            $('#put_comment').click(function(e) {
                e.preventDefault();

                var package_id = $("#package_id").val();
                var name = $("#c_name").val();
                var email = $("#c_email").val();
                var website = $("#c_website").val();
                var message = $("#c_message").val();

                if (name == "" || email == "" || message == "") {
                    if (name == "") {
                        alert("Please Enter Name !");
                    } else if (email == "") {
                        alert("Please Enter Email !");
                    } else if (message == "") {
                        alert("Comment cannot be empty !");
                    }
                } else {
                    // console.log('comments');

                    var formdata = {
                        package_id: package_id,
                        name: name,
                        email: email,
                        website: website,
                        message: message
                    };

                    let data = JSON.stringify(formdata);
                    // console.log(data);
                    $.ajax({
                        type: "POST",
                        url: "assets/submit/comments",
                        data: data,
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": $('meta[name="csrf-token').attr('content')
                        },
                        success: function(res) {
                            if (res.toString() == "success") {
                                // console.log("success");
                                // empty fields
                                $("#c_name").val('')
                                $("#c_email").val('')
                                $("#c_website").val('')
                                $("#c_message").val('')

                                location.reload();
                            } else {
                                console.log("failed to comment");
                            }
                        },
                        error: function(err) {
                            console.log(err);
                        }
                    });
                }
            });

            // show reply comment box
            var comm_id;

            function replyCommentFunction(e, comment_id) {
                e.preventDefault();

                // console.log(comment_id);
                comm_id = comment_id;
                document.getElementById("show_reply_box").style.display = "block";
            }

            $('#cancel_comment').click(function(e) {
                e.preventDefault();
                document.getElementById("show_reply_box").style.display = "none";
            });
            // reply comments
            $('#reply_comment').click(function(e) {
                e.preventDefault();

                var name = $("#r_name").val();
                var email = $("#r_email").val();
                var message = $("#r_message").val();

                if (name == "" || email == "" || message == "") {
                    if (name == "") {
                        alert("Please Enter Name !");
                    } else if (email == "") {
                        alert("Please Enter Email !");
                    } else if (message == "") {
                        alert("Comment Reply cannot be empty !");
                    }
                } else {
                    // console.log('Reply comments');

                    var formdata = {
                        comment_id: comm_id,
                        name: name,
                        email: email,
                        message: message
                    };

                    let data = JSON.stringify(formdata);
                    // console.log(data);
                    $.ajax({
                        type: "POST",
                        url: "assets/submit/comments_reply",
                        data: data,
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": $('meta[name="csrf-token').attr('content')
                        },
                        success: function(res) {
                            if (res.toString() == "success") {
                                // console.log("success");
                                // empty fields
                                $("#r_name").val('');
                                $("#r_email").val('');
                                $("#r_message").val('');
                                document.getElementById("show_reply_box").style.display = "none";

                                location.reload();
                            } else {
                                console.log("failed to comment");
                            }
                        },
                        error: function(err) {
                            console.log(err);
                        }
                    });
                }
            });

            // success message snack bar
            function showBottomSnackBar(textString) {
                var x = document.getElementById("bottom-snackbar");
                x.style.display = "block";
                x.innerText = textString;

                setTimeout(function() {
                    x.style.display = "none";
                }, 4000);
            }

            function emailValidation(email) {
                filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
                if (filter.test(email)) {
                    return true;
                } else {
                    return false;
                }
            }

            var regexExp = /[^a-zA-Z ]/; // letters, space
            var regexExpNum = /[^0-9]/; // nu,ber
        </script>
        <!-- New Design 17/7/26 -->
        <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

        <script>
            new Swiper(".myGallery", {
                slidesPerView: 1,
                spaceBetween: 15,
                loop: true,

                autoplay: {
                    delay: 3000,
                    disableOnInteraction: false
                },

                pagination: {
                    el: ".swiper-pagination",
                    clickable: true
                }
            });
        </script>
        <script>
            document.addEventListener("DOMContentLoaded", function () {

                const thumbnails = document.querySelectorAll(".thumbnail");
                const mainImage = document.getElementById("mainImage");

                if (!thumbnails.length || !mainImage) return;

                let currentIndex = 0;

                function updateGallery(index) {

                    currentIndex = index;

                    mainImage.src = thumbnails[index].src;

                    thumbnails.forEach(item => {
                        item.classList.remove("active-thumb");
                    });

                    thumbnails[index].classList.add("active-thumb");
                }

                thumbnails.forEach((thumb, index) => {

                    thumb.addEventListener("click", function () {
                        updateGallery(index);
                    });

                });

                document.querySelector(".gallery-next")?.addEventListener("click", function () {

                    currentIndex++;

                    if (currentIndex >= thumbnails.length) {
                        currentIndex = 0;
                    }

                    updateGallery(currentIndex);
                });

                document.querySelector(".gallery-prev")?.addEventListener("click", function () {

                    currentIndex--;

                    if (currentIndex < 0) {
                        currentIndex = thumbnails.length - 1;
                    }

                    updateGallery(currentIndex);
                });

            });
        </script>
        <script>
            $(document).ready(function () {

                const $nav = $(".borderColor1");
                const $placeholder = $(".nav-placeholder");
                const $content = $(".content-sections");

                let navTop = $nav.offset().top;

                function updateStickyNav() {
                    if ($(window).width() < 992) {
                        $placeholder.hide();
                        $nav.removeClass("nav-fixed").css("width", "");
                        return;
                    }

                    const headerHeight = $(".sticky-bar").outerHeight() || 90;

                    const contentTop = $content.offset().top;
                    const contentBottom = contentTop + $content.outerHeight();

                    const scrollTop = $(window).scrollTop();

                    if (
                        scrollTop >= navTop - headerHeight &&
                        scrollTop < contentBottom - headerHeight - $nav.outerHeight()
                    ) {

                        $placeholder.show();

                        $nav.addClass("nav-fixed");

                        $nav.css({
                            width: $(".col-xl-8").width() + "px"
                        });

                    } else {

                        $placeholder.hide();

                        $nav.removeClass("nav-fixed");

                        $nav.css("width", "");

                    }
                }

                function updatePricingSticky() {

                    const $pricing = $(".pricingSection");
                    const $wrapper = $(".pricing-wrapper");

                    if ($(window).width() < 992) {
                        $pricing
                            .removeClass("pricing-fixed pricing-bottom")
                            .css({
                                width: "",
                                top: "",
                                left: ""
                            });
                        return;
                    }

                    const headerHeight = $(".sticky-bar").outerHeight() || 90;
                    const navHeight = $(".borderColor1").outerHeight() || 76;

                    const fixedTop = 90;

                    const pricingHeight = $pricing.outerHeight();

                    const startSticky =
                        $(".sticky-nav-wrapper").offset().top - headerHeight;

                    const contentBottom =
                        $(".content-sections").offset().top +
                        $(".content-sections").outerHeight();

                    const stopSticky =
                        contentBottom -
                        pricingHeight -
                        fixedTop;

                    const scrollTop = $(window).scrollTop();
                    const pricingWidth = $pricing[0].getBoundingClientRect().width;

                    // Before sticky
                    if (scrollTop < startSticky) {

                        $pricing
                            .removeClass("pricing-fixed pricing-bottom")
                            .css({
                                width: "",
                                top: "",
                                left: ""
                            });
                    }

                    // Sticky state
                    else if (scrollTop < stopSticky) {

                        $pricing
                            .removeClass("pricing-bottom")
                            .addClass("pricing-fixed")
                            .css({
                                top: "90px",
                                left: $wrapper.offset().left + "px",
                                width: pricingWidth + "px"
                            });
                    }

                    // Stop at bottom of left content
                    else {

                        const absoluteTop =
                            contentBottom -
                            $wrapper.offset().top -
                            pricingHeight;

                        $pricing
                            .removeClass("pricing-fixed")
                            .addClass("pricing-bottom")
                            .css({
                                top: absoluteTop + "px",
                                width: "100%",
                                left: ""
                            });
                    }
                }

                updateStickyNav();
                updatePricingSticky();

                $(window).on("scroll resize", function () {

                    updateStickyNav();
                    updatePricingSticky();

                    const headerHeight = $(".sticky-bar").outerHeight() || 90;
                    const navHeight = $nav.outerHeight() || 76;

                    let scrollPos =
                        $(window).scrollTop() +
                        headerHeight +
                        navHeight +
                        50;

                    $(".section-block").each(function () {

                        let top = $(this).offset().top;
                        let bottom = top + $(this).outerHeight();
                        let id = $(this).attr("id");

                        if (scrollPos >= top && scrollPos < bottom) {

                            $(".nav-link").removeClass("active");

                            $('.nav-link[href="#' + id + '"]').addClass("active");
                        }
                    });

                });

                $(".nav-link").on("click", function (e) {

                    e.preventDefault();

                    $(".nav-link").removeClass("active");
                    $(this).addClass("active");

                    const target = $(this).attr("href");

                    const headerHeight = $(".sticky-bar").outerHeight() || 90;
                    const navHeight = $nav.outerHeight() || 76;

                    $("html, body").animate({
                        scrollTop:
                            $(target).offset().top -
                            headerHeight -
                            navHeight +
                            20
                    }, 500);

                });

            });
        </script>
        <script>
            $(document).ready(function () {

                $(".faq-header").click(function () {

                    const currentItem = $(this).closest(".faq-item");

                    $(".faq-item").not(currentItem).removeClass("active");

                    $(".faq-item").not(currentItem)
                        .find(".faq-icon")
                        .removeClass("ri-eye-line")
                        .addClass("ri-eye-off-line");

                    currentItem.toggleClass("active");

                    if (currentItem.hasClass("active")) {

                        currentItem.find(".faq-icon")
                            .removeClass("ri-eye-off-line")
                            .addClass("ri-eye-line");

                    } else {

                        currentItem.find(".faq-icon")
                            .removeClass("ri-eye-line")
                            .addClass("ri-eye-off-line");
                    }
                });

            });
        </script>
        <!-- New Design /7/26 -->
    </body>

</html>