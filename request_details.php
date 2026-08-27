<?php

// Start the session only if it's not already started
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

$userId = $_SESSION['user_id']??'0';

require 'connect.php';
include 'assets/submit/tour_details_data.php';

$vehicleOptions = [
    [
        'value' => 4,
        'name'  => '4 Seater',
        'type'  => 'Sedan',
        'icon'  => 'ri-car-line'
    ],
    [
        'value' => 6,
        'name'  => '6 Seater',
        'type'  => 'SUV',
        'icon'  => 'ri-car-line'
    ],
    [
        'value' => 7,
        'name'  => '7 Seater',
        'type'  => 'SUV / Innova',
        'icon'  => 'ri-car-line'
    ],
    [
        'value' => 9,
        'name'  => '9 Seater',
        'type'  => 'Luxury Van',
        'icon'  => 'ri-bus-line'
    ],
    [
        'value' => 12,
        'name'  => '12 Seater',
        'type'  => 'Tempo Traveller',
        'icon'  => 'ri-bus-line'
    ],
    [
        'value' => 15,
        'name'  => '15 Seater',
        'type'  => 'Tempo Traveller',
        'icon'  => 'ri-bus-line'
    ],
    [
        'value' => 17,
        'name'  => '17 Seater',
        'type'  => 'Mini Bus',
        'icon'  => 'ri-bus-line'
    ],
    [
        'value' => 20,
        'name'  => '20 Seater',
        'type'  => 'Mini Bus',
        'icon'  => 'ri-bus-line'
    ],
    [
        'value' => 25,
        'name'  => '25 Seater',
        'type'  => 'Mini Bus',
        'icon'  => 'ri-bus-line'
    ],
    [
        'value' => 27,
        'name'  => '27 Seater',
        'type'  => 'Bus',
        'icon'  => 'ri-bus-line'
    ],
    [
        'value' => 32,
        'name'  => '32 Seater',
        'type'  => 'Bus',
        'icon'  => 'ri-bus-line'
    ],
    [
        'value' => 35,
        'name'  => '35 Seater',
        'type'  => 'Bus',
        'icon'  => 'ri-bus-line'
    ],
    [
        'value' => 40,
        'name'  => '40 Seater',
        'type' => 'Bus',
        'icon'  => 'ri-bus-line'
    ],
    [
        'value' => 45,
        'name'  => '45 Seater',
        'type'  => 'Bus',
        'icon'  => 'ri-bus-line'
    ],
    [
        'value' => 50,
        'name'  => '50 Seater',
        'type'  => 'Bus',
        'icon'  => 'ri-bus-line'
    ]
];

?>
<!DOCTYPE html>
<html lang="zxx" dir="lrt">

    <!-- Mirrored from travelloo.vercel.app/template/tour-details.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 12 Jul 2024 06:53:04 GMT -->
    <!-- Added by HTTrack -->
    <meta http-equiv="content-type" content="text/html;charset=utf-8" /><!-- /Added by HTTrack -->

    <head>
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
        
        <!-- added code for share model start 30-07-2026-->
        <meta name="description" content="<?php echo htmlspecialchars($description); ?>">
        <!-- Open Graph -->
        <meta property="og:type" content="website">
        <meta property="og:title" content="<?php echo htmlspecialchars($title); ?>">
        <meta property="og:description" content="<?php echo htmlspecialchars($description); ?>">
        <meta property="og:url" content="<?php echo htmlspecialchars($url); ?>">
        <meta property="og:image" content="<?php echo htmlspecialchars($image); ?>">
        <meta property="og:site_name" content="<?php echo htmlspecialchars($siteName); ?>">
        <!-- Twitter Card -->
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:title" content="<?php echo htmlspecialchars($title); ?>">
        <meta name="twitter:description" content="<?php echo htmlspecialchars($description); ?>">
        <meta name="twitter:image" content="<?php echo htmlspecialchars($image); ?>">
        <!-- added code for share model  end-->

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
        <!-- share model css file 30-07-2026 -->
        <link rel="stylesheet" type="text/css" href="assets/css/tour_details_share.css">
        <!-- User Profile CSS -->
        <link rel="stylesheet" type="text/css" href="assets/css/user-profile.css">
        <!-- Request Details CSS -->
        <link rel="stylesheet" type="text/css" href="assets/css/request-details.css">
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
                </nav>
            </div>
            <!--/ End-of Breadcrumbs-->
            <!-- Request Details Page Start -->
            <section>
                <div class="request-details-container">
                    <div class="container">
                        <div class="title-section mb-3">
                            <div>
                                <h3 class="fw-bolder" id="pack_name">Request Best Quote</h3>
                                <p class="fw-bolder text-black" id="pack_name"><?= $package['name'] ?></p>
                            </div>
                        </div>
                        <!-- Card Section 1 -->
                        <div class="row">
                            <div class="col-xl-8 col-lg-9 mb-3">
                                <div class="card cardShadow">
                                    <div class="d-flex tabDisplayBlock">
                                        <div>
                                            <img src="<?= $galleryImages[0]['image'] ?>" alt="" class="requestQuotePackageImg">
                                        </div>
                                        <div class="p-3 widthStretch">
                                            <p class="fw-bolder text-black mb-1 fs-5" id="pack_name"><?= $package['name'] ?></p>
                                            <div class="d-flex justify-content-between mobileDisplayBlock">
                                                <p class="fontSize10 mb-3">
                                                    <i class="ri-map-pin-line destination-title fs-6"></i>
                                                    <?php echo $package['destination'] ?>
                                                </p>
                                                <p class="fontSize10 mb-3">
                                                    <i class="ri-time-line destination-title fs-6"></i>
                                                    <?= $tour_nights ?> Nights / <?= $tour_days ?> Days
                                                </p>
                                                <p class="fontSize10 mb-3">
                                                    <i class="ri-restaurant-line destination-title fs-6"></i>
                                                    Meals: <?= $meal_cat['name'] ?>
                                                </p>
                                            </div>
                                            <p class="fontSize10 mb-3">
                                                <?= $package['description'] ?>
                                            </p>
                                            <div class="p-2 priceGreenBtn">
                                                <div class="d-flex justify-content-center align-items-end">Starting from 
                                                    <div class="d-block mx-2">
                                                        <?php if ($showGuestPrice && $adultDisplayPrice < $adultPrice): ?>
                                                            <p class="priceTextGreen1 fontSize10 text-center d-block">
                                                                &#8377; <?= number_format($adultPrice, 2) ?> /-
                                                            </p>
                                                        <?php endif; ?>
                                                        <p class="priceTextGreen">&#8377;<?= number_format($adultDisplayPrice, 2) ?> /-</p>
                                                    </div>
                                                     per adult
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Traveller & Trip Details -->
                                <div class="card cardShadow p-3 mt-3">
                                    <div class="d-flex gap-2 mb-3">
                                        <p class="travellerTittleNum">1</p>
                                        <h5 class="mb-0 fw-bold">Traveller & Trip Details</h5>
                                    </div>
                                    <div class="row">
                                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12">
                                            <div class="mb-3">
                                                <label for="travelStartDate" class="form-label fontSize10">Travel Start Date</label>
                                                <input type="date" class="form-control fontSize10" id="travelStartDate">
                                            </div>
                                        </div>
                                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12">
                                            <div class="mb-3">
                                                <label for="travelEndDate" class="form-label fontSize10">Travel End Date</label>
                                                <input type="date" class="form-control fontSize10" id="travelEndDate">
                                            </div>
                                        </div>
                                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12">
                                            <div class="mb-3">
                                                <label for="dayInput" class="form-label fontSize10">Nights / Days</label>
                                                <div class="icon-select-wrapper">
                                                    <span class="fontSize10 paddingLeft form-control"><i class="ri-moon-line iconPosition iconRed"></i><?= $tour_nights ?> Nights / <?= $tour_days ?> Days</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                            <div class="mb-3">
                                                <label for="pickupLocation" class="fontSize10 form-label">Pickup</label>

                                                <div class="icon-select-wrapper">
                                                    <i class="ri-map-pin-line iconPosition iconRed"></i>

                                                    <input type="text"
                                                        class="fontSize10 form-control paddingLeft location-input"
                                                        id="pickupLocation"
                                                        value="<?= htmlspecialchars($package['travel_from']) ?>"
                                                        data-old-value="<?= htmlspecialchars($package['travel_from']) ?>">

                                                </div>

                                                <small class="old-value-text text-muted" id="pickupOldValue" style="display:none;">
                                                    Old Pickup: <?= htmlspecialchars($package['travel_from']) ?>
                                                </small>
                                            </div>
                                        </div>

                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                            <div class="mb-3">
                                                <label for="dropLocation" class="fontSize10 form-label">Drop</label>

                                                <div class="icon-select-wrapper">
                                                    <i class="ri-map-pin-line iconPosition iconRed"></i>

                                                    <input type="text"
                                                        class="fontSize10 form-control paddingLeft location-input"
                                                        id="dropLocation"
                                                        value="<?= htmlspecialchars($package['travel_to']) ?>"
                                                        data-old-value="<?= htmlspecialchars($package['travel_to']) ?>">

                                                </div>

                                                <small class="old-value-text text-muted" id="dropOldValue" style="display:none;">
                                                    Old Drop: <?= htmlspecialchars($package['travel_to']) ?>
                                                </small>
                                            </div>
                                        </div>
                                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12">
                                            <div class="guest-counter">
                                                <label class="guest-label">Adults (12+ yrs)</label>
                                                <div class="counter-box">
                                                    <button type="button" class="counter-btn minus">−</button>
                                                    <input type="number" id="adultCount" name="adults" class="counter-value" value="1" min="1">
                                                    <button type="button" class="counter-btn plus">+</button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12">
                                            <div class="guest-counter">
                                                <label class="guest-label">Children (2-11 yrs)</label>
                                                <div class="counter-box">
                                                    <button type="button" class="counter-btn minus">−</button>
                                                    <input type="number" id="childrenCount" name="children" class="counter-value" value="0" min="0">
                                                    <button type="button" class="counter-btn plus">+</button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12">
                                            <div class="guest-counter">
                                                <label class="guest-label">Infants (0-1 yrs)</label>
                                                <div class="counter-box">
                                                    <button type="button" class="counter-btn minus">−</button>
                                                    <input type="number" id="infantCount" name="infants" class="counter-value" value="0" min="0">
                                                    <button type="button" class="counter-btn plus">+</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card cardRoom mt-3 p-3" id="roomRecommendation">
                                        <p class="fontSize10 fw-bold">Room 1</p>
                                        <div class="row">
                                            <div class="col-xl-9 col-lg-8 col-md-8 col-sm-7 col-12 mb-3">
                                                <div class="d-flex justify-content-between mobileDisplayBlock">
                                                    <div>
                                                        <p class="fontSize10 fw-bold"><i class="ri-hotel-bed-fill destination-title fs-6"></i> 1 Double Bed</p>
                                                        <p class="fontSize10">1 Pax will be accommendated in 1 room.</p>
                                                    </div>
                                                    <div class="py-1 px-2 text-center text-success-emphasis bg-success-subtle border border-success-subtle rounded-3 recommendedBtn fw-bold fontSize10">
                                                        Recommended
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-3 col-lg-4 col-md-4 col-sm-5 col-12 mb-3">
                                                <button class="btn modifyBtn" type="button">Modify Rooms</button>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-center">
                                            <button class="btn addRoomBtn" type="button">
                                                Add Room (If more travellers)
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <!-- Preferences Details -->
                                <div class="card cardShadow p-3 mt-3">
                                    <div class="d-flex gap-2 mb-3">
                                        <p class="travellerTittleNum">2</p>
                                        <h5 class="mb-0 fw-bold">Preferences (Optional)</h5>
                                    </div>
                                    <div class="row">
                                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12">
                                            <div class="mb-3">
                                                <label for="hotelCategory" class="form-label fontSize10">Hotel Category</label>
                                                <div class="icon-select-wrapper">
                                                    <i class="ri-hotel-line iconPosition iconRed"></i>
                                                    <?php

                                                        $sql = $conn->prepare("
                                                            SELECT id, name
                                                            FROM category_hotel
                                                            WHERE status = 1
                                                            ORDER BY id DESC
                                                        ");

                                                        $sql->execute();

                                                        $hotelCategories = $sql->fetchAll(PDO::FETCH_ASSOC);

                                                    ?>

                                                    <select class="form-select fontSize10 paddingLeft" aria-label="Select Hotel" name="hotel_category">

                                                        <option value="">Select Hotel</option>
                                                        
                                                        <?php foreach ($hotelCategories as $hotel): ?>

                                                            <option value="<?= htmlspecialchars($hotel['id']) ?>"
                                                                <?= ($hotel['id'] == $hotel_cat_id) ? 'selected' : '' ?>>

                                                                <?= htmlspecialchars($hotel['name']) ?>

                                                            </option>

                                                        <?php endforeach; ?>

                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12">
                                            <div class="mb-3">
                                                <label for="mealPreference" class="form-label fontSize10">Meal Preference</label>
                                                <div class="icon-select-wrapper">
                                                    <i class="ri-restaurant-line iconPosition iconRed"></i>
                                                    <?php
                                                    $sql = $conn->prepare("SELECT * FROM category_meal WHERE status = 1");
                                                    $sql->execute();
                                                    $mealCategories = $sql->fetchAll(PDO::FETCH_ASSOC);
                                                    ?>

                                                    <select class="form-select fontSize10 paddingLeft" aria-label="Select Meal">

                                                        <option value="">Select Meal</option>

                                                        <?php foreach ($mealCategories as $meal_cat): ?>

                                                            <option
                                                                value="<?= htmlspecialchars($meal_cat['id']) ?>"
                                                                <?= (isset($meal_cat_id) && $meal_cat_id == $meal_cat['id']) ? 'selected' : '' ?>
                                                            >
                                                                <?= htmlspecialchars($meal_cat['name']) ?>
                                                            </option>

                                                        <?php endforeach; ?>

                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12">
                                            <div class="mb-3">
                                                <label for="transportPreference" class="form-label fontSize10">Transport Preference</label>
                                                <div class="icon-select-wrapper">
                                                    <i class="ri-car-line iconPosition iconRed"></i>
                                                    <?php
                                                    $sql = $conn->prepare("SELECT * FROM category_vehicle WHERE status = 1");
                                                    $sql->execute();
                                                    $vehicleCategories = $sql->fetchAll(PDO::FETCH_ASSOC);
                                                    ?>

                                                    <select class="form-select fontSize10 paddingLeft" aria-label="Select Vehicle">

                                                        <option value="">Select Vehicle</option>

                                                        <?php foreach ($vehicleCategories as $vehicle_cat): ?>

                                                            <option
                                                                value="<?= htmlspecialchars($vehicle_cat['id']) ?>"
                                                                <?= (isset($category_vehicle_id) && $category_vehicle_id == $vehicle_cat['id']) ? 'selected' : '' ?>
                                                            >
                                                                <?= htmlspecialchars($vehicle_cat['name']) ?>
                                                            </option>

                                                        <?php endforeach; ?>

                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                            <div class="mb-0">
                                                <label for="specialRequirement" class="form-label fontSize10">Special Requirements (Optional)</label>
                                                <textarea class="form-control fontSize10" id="specialRequirement" placeholder="Eg. Wheelchair, extra bed, high floor, adjoining rooms, etc."></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Pricing Section -->
                            <div class="col-xl-4 col-lg-3 mb-3 pricing-sidebar" id="pricingSidebar">
                                <div class="card cardShadow">
                                    <div class="pricing-header">
                                        <h5 class="fw-bold mb-0">Package Price Calculation</h5>
                                        <button type="button" class="pricing-close-btn" id="closePricing">
                                            <i class="ri-close-line"></i>
                                        </button>
                                    </div>
                                    <hr class="my-1 border border-2 mx-3">
                                    <div class="p-3">
                                        <p class="fw-bold">Base Price (Per Person)</p>
                                        <div class="d-flex justify-content-between">
                                            <div>
                                                <p class="fontSize10">Adult (12+ yrs)</p>
                                                <p class="fontSize10">Child (2-11 yrs)</p>
                                                <p class="fontSize10">Infant</p>
                                            </div>
                                            <div>
                                                <p class="fontSize10 text-end">&#8377; <?= number_format($adultDisplayPrice, 2) ?></p>
                                                <p class="fontSize10 text-end">&#8377; <?= number_format($childDisplayPrice, 2) ?></p>
                                                <p class="fontSize10 text-end">FREE</p>
                                            </div>
                                        </div>
                                    </div>
                                    <hr class="my-1 border border-2 mx-3">
                                    <div class="p-3">
                                        <p class="fw-bold">Price Based on Travelers</p>
                                        <div class="d-flex justify-content-between">
                                            <div>
                                                <p class="fontSize10">Adult: <span class="" id="totalAdultCount">1</span> x &#8377; <?= number_format($adultDisplayPrice, 2) ?></p>
                                                <p class="fontSize10">Children: <span class="" id="totalChildrenCount">0</span> x &#8377; <?= number_format($childDisplayPrice, 2) ?></p>
                                                <p class="fontSize10">Infant: <span class="" id="totalInfantCount">0</span> x FREE</p>
                                            </div>
                                            <div>
                                                <p class="fontSize10 text-end" id="adultTotal">&#8377; <?= number_format($adultDisplayPrice, 2) ?></p>
                                                <p class="fontSize10 text-end" id="childrenTotal">&#8377; 0</p>
                                                <p class="fontSize10 text-end">&#8377; 0</p>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-between">
                                            <p class="fw-bold">Subtotal</p>
                                            <p class="fontSize13 fw-bold" id="subTotal">&#8377; <?= number_format($adultDisplayPrice, 2) ?></p>
                                        </div>
                                    </div>
                                    <hr class="my-1 border border-2 mx-3">
                                    <div class="p-3">
                                        <p class="fw-bold">Transport</p>
                                        <div class="d-flex justify-content-between">
                                            <div>
                                                <p class="fontSize10" id="selectedVehicleText">4 Seater AC Vehicle (For 3 Pax)</p>
                                                <a href="#" class="fontSize10 text-primary" id="changeVehicle">Change Vehicle</a>
                                            </div>
                                            <div>
                                                <p class="fontSize10 text-end">Included</p>
                                            </div>
                                        </div>
                                    </div>
                                    <hr class="my-1 border border-2 mx-3">
                                    <div class="p-3">
                                        <p class="fw-bold">Other Charges</p>
                                        <div class="d-flex justify-content-between">
                                            <div>
                                                <p class="fontSize10">Convenience Fee</p>
                                                <p class="fontSize10">GST (<?= $gst['gst'] ?>%)</p>
                                            </div>
                                            <div>
                                                <p class="fontSize10 text-end" id="convenienceFeee">&#8377; 0</p>
                                                <p class="fontSize10 text-end" id="gstValue">&#8377; 0</p>
                                            </div>
                                        </div>
                                    </div>
                                    <?php if($_SESSION['user_type_id_value'] == 10 && $_SESSION['customer_type'] == 'Neo Select'){  ?>
                                    <hr class="my-1 border border-2 mx-3">
                                    <div class="p-3 pb-0">

                                        <p class="fontSize10 fw-bold mb-2">
                                            Apply Coupons
                                            <span class="text-muted fw-normal">
                                                (One coupon per passenger)
                                                <i class="ri-error-warning-line"></i>
                                            </span>
                                        </p>

                                        <div id="couponPassengerContainer"></div>

                                    </div>
                                    <hr class="my-1 border border-2 mx-3">
                                    <div class="d-flex justify-content-between px-3">
                                        <p class="fontSize10 discountGreen fw-bold">
                                            Discounts (Coupons)
                                        </p>

                                        <p class="fontSize10 discountGreen fw-bold text-end"
                                        id="totalCouponDiscount">
                                            - ₹ 0
                                        </p>
                                    </div>
                                    <?php } elseif ($_SESSION['user_type_id_value'] == 10 && $_SESSION['customer_type'] != 'Neo Select') {?>
                                    <hr class="my-2 border border-2 mx-3">
                                    <div class="p-3">
                                        <!-- HEADER -->
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <div>
                                                <p class="fontSize10 fw-bold mb-1">Apply Coupon</p>
                                                <small class="text-muted fontSize10">
                                                    Only one coupon can be applied per package
                                                    <i class="ri-information-line"></i>
                                                </small>
                                            </div>
                                            <div class="coupon-package-icon">
                                                <i class="ri-coupon-3-line"></i>
                                            </div>
                                        </div>
                                        <!-- COUPON SELECT -->
                                        <div class="package-coupon-box">
                                            <div class="coupon-select-wrapper">
                                                <i class="ri-coupon-3-line"></i>
                                                <select id="packageCouponSelect" class="form-select fontSize10 selectPadding coupon-select1">
                                                    <option value="">Select Coupon</option>
                                                    <?php if (!empty($cuCoupons)): ?>
                                                        <optgroup label="Primary Coupons">
                                                            <?php foreach ($cuCoupons as $coupon): ?>
                                                                <option value="<?= htmlspecialchars($coupon['code']) ?>" data-type="primary" data-amount="<?= htmlspecialchars($coupon['coupon_amount']) ?>">
                                                                    <?= htmlspecialchars($coupon['code']) ?>
                                                                </option>
                                                            <?php endforeach; ?>
                                                        </optgroup>
                                                    <?php endif; ?>
                                                    <?php if (!empty($loyaltyCoupons)): ?>
                                                        <optgroup label="Loyalty Coupons">
                                                            <?php foreach ($loyaltyCoupons as $coupon): ?>
                                                                <option value="<?= htmlspecialchars($coupon['code']) ?>" data-type="loyalty" data-amount="<?= htmlspecialchars($coupon['coupon_amount']) ?>">
                                                                    <?= htmlspecialchars($coupon['code']) ?>
                                                                </option>
                                                            <?php endforeach; ?>
                                                        </optgroup>
                                                    <?php endif; ?>
                                                </select>
                                            </div>
                                            <!-- DISCOUNT -->
                                            <div class="package-discount">
                                                <span class="text-muted fontSize10">Discount</span>
                                                <span class="discountGreen fw-bold fontSize10" id="packageCouponDiscount"> ₹ 0</span>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- TOTAL -->
                                    <hr class="my-1 border border-2 mx-3">
                                    <div class="d-flex justify-content-between align-items-center px-3 pb-2">
                                        <p class="fontSize10 discountGreen fw-bold mb-0">
                                            <i class="ri-price-tag-3-line"></i>
                                            Discounts (Coupon)
                                        </p>
                                        <p class="fontSize10 discountGreen fw-bold text-end mb-0" id="totalCouponDiscount">- ₹ 0</p>
                                    </div>
                                    <?php } ?>
                                    <hr class="my-1 border border-2 mx-3">
                                    <div class="p-3">
                                        <div class="d-flex justify-content-between">
                                            <div>
                                                <p class="fs-6">Total Estimated Price</p>
                                                <!-- <p class="fontSize10">Per Adult</p>
                                                <p class="fontSize10">Per Child</p> -->
                                            </div>
                                            <div>
                                                <p class="fs-5 text-danger fw-bolder text-end" id="finalPackagePrice">&#8377; 0</p>
                                                <!-- <p class="fontSize10 text-end">&#8377; <?= number_format($adultDisplayPrice, 2) ?></p>
                                                <p class="fontSize10 text-end">&#8377; <?= number_format($childDisplayPrice, 2) ?></p> -->
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-center align-items-center">
                                        <button id="submitRequst" class="submit-request-btn">
                                            <p class="fs-6 text-white fw-bold">Total Estimated Price:</p>
                                            <p class="fs-6 text-white fw-bold" id="finalPackagePrice2">&#8377; 0 /-</p>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- Request Details Page End -->
            <button id="openPricingBtn" class="floating-price-btn">
                <p class="fs-6 text-white fw-bold">Total Estimated Price:</p>
                <p class="fs-6 text-white fw-bold" id="finalPackagePrice1">&#8377; 0 /-</p>
            </button>

            <div class="pricing-overlay" id="pricingOverlay"></div>
        </main>

        <!-- share model 30-07-2026 end-->
        <!-- =========================================================
            MODIFY ROOMS MODAL
        ========================================================= -->
        <div class="modal fade" id="modifyRoomsModal" tabindex="-1" aria-labelledby="modifyRoomsModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title fw-bold" id="modifyRoomsModalLabel">Modify Rooms</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row g-3 ms-4">
                            <!-- Adults -->
                            <div class="col-md-4">
                                <label class="form-label fontSize10 fw-bold">
                                    Adults(12+ yrs): <span id="totalAdults">1</span>
                                </label>
                            </div>

                            <!-- Children -->
                            <div class="col-md-4">
                                <label class="form-label fontSize10 fw-bold">
                                    Children (2-11 yrs): <span id="totalChildren">0</span>
                                </label>
                            </div>

                            <!-- Infants -->
                            <div class="col-md-4">
                                <label class="form-label fontSize10 fw-bold">
                                    Infants: <span id="totalInfants">0</span>
                                </label>
                            </div>

                        </div>
                        <div id="modifyRoomsContainer">
                            <!-- ROOM 1 -->
                            <div class="modify-room-card mb-3" data-room="1">
                                <div class="room-content-row">
                                    <!-- ROOM TITLE -->
                                    <div class="room-title">
                                        <p class="fontSize10 fw-bold mb-0">
                                            Room 1
                                        </p>
                                    </div>

                                    <!-- ROOM OCCUPANCY -->
                                    <div class="occupancy-section">

                                        <label class="fontSize10 fw-bold mb-0">
                                            Room Occupancy
                                        </label>

                                        <div class="occupancy-control">

                                            <button type="button"
                                                    class="occupancy-minus">
                                                -
                                            </button>

                                            <input type="text"
                                                class="form-control text-center room-occupancy"
                                                value="3"
                                                readonly>

                                            <button type="button"
                                                    class="occupancy-plus">
                                                +
                                            </button>

                                        </div>

                                    </div>

                                    <!-- EXTRA MATTRESS -->
                                    <div class="mattress-section">

                                        <div class="form-check mb-0">

                                            <input class="form-check-input extra-mattress"
                                                type="checkbox"
                                                id="extraMattress1"
                                                checked>

                                            <label class="form-check-label fontSize10"
                                                for="extraMattress1">
                                                With Extra Mattress
                                            </label>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>
                        <!-- Add Room -->
                        <div class="text-center">
                            <button type="button" class="btn addModifyRoom" id="addModifyRoom">
                                <i class="ri-add-line me-1"></i>
                                Add Room
                            </button>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary" id="applyRoomModification">Apply Changes</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- vehicle modal -->
        <div class="modal fade"
            id="vehicleSelectionModal"
            tabindex="-1"
            aria-labelledby="vehicleSelectionModalLabel"
            aria-hidden="true">

            <div class="modal-dialog modal-dialog-centered modal-lg">

                <div class="modal-content">

                    <div class="modal-header">

                        <h5 class="modal-title fw-bold"
                            id="vehicleSelectionModalLabel">
                            Select Vehicle
                        </h5>

                        <button type="button"
                                class="btn-close"
                                data-bs-dismiss="modal">
                        </button>

                    </div>


                    <div class="modal-body">

                        <div class="row g-3">

                            <?php foreach ($vehicleOptions as $vehicle): ?>

                                <div class="col-md-6 col-lg-4">

                                    <div class="vehicle-option border rounded-3 p-3 h-100"
                                        data-value="<?= $vehicle['value'] ?>"
                                        data-name="<?= htmlspecialchars($vehicle['name'] . ' - ' . $vehicle['type']) ?>">

                                        <div class="d-flex align-items-center">

                                            <i class="<?= htmlspecialchars($vehicle['icon']) ?> fs-3 me-3"></i>

                                            <div>

                                                <p class="fontSize10 fw-bold mb-1">
                                                    <?= htmlspecialchars($vehicle['name']) ?>
                                                </p>

                                                <p class="fontSize10 mb-0">
                                                    <?= htmlspecialchars($vehicle['type']) ?>
                                                </p>

                                            </div>

                                        </div>

                                    </div>

                                </div>

                            <?php endforeach; ?>

                        </div>

                    </div>


                    <div class="modal-footer">

                        <button type="button"
                                class="btn btn-light"
                                data-bs-dismiss="modal">
                            Cancel
                        </button>

                        <button type="button"
                                class="btn btn-primary"
                                id="applyVehicleSelection">
                            Select Vehicle
                        </button>

                    </div>

                </div>

            </div>

        </div>
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
        <!-- SweetAlert2 -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <!-- Swiper -->
        <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
        <!-- Plugin -->
        <script src="assets/js/plugin.js"></script>
        <!-- Main js-->
        <script src="assets/js/main.js"></script>
        <script type="text/javascript" src="logout/logout.js"></script>
        <!--New Design 17/7/26 -->
        <script>
            // Price values from PHP
            const perAdultPrice = <?= json_encode((float)$adultDisplayPrice) ?>;
            const perChildPrice = <?= json_encode((float)$childDisplayPrice) ?>;
            const tourDays = <?= json_encode($tour_days_total) ?>;
            const totalPrimaryCoupons = <?= count($cuCoupons) ?>;
            const totalLoyaltyCoupons = <?= count($loyaltyCoupons) ?>;
        </script>
        <script>
            // Animate price
            function animatePrice($element, finalValue, duration = 800) {

                let currentValue = $element.data('current-price') || 0;

                // Stop previous animation
                $element.stop(true, false);

                $({ count: currentValue }).animate(
                    {
                        count: finalValue
                    },
                    {
                        duration: duration,

                        step: function (now) {

                            $element.text(
                                '₹ ' +
                                Math.round(now).toLocaleString('en-IN')
                            );
                        },

                        complete: function () {

                            $element.text(
                                '₹ ' +
                                Math.round(finalValue).toLocaleString('en-IN')
                            );

                            $element.data(
                                'current-price',
                                finalValue
                            );
                        }
                    }
                );
            }
            function updateSubTotal() {

                const adultCount =
                    parseInt($('#adultCount').val()) || 0;

                const childrenCount =
                    parseInt($('#childrenCount').val()) || 0;

                const adultTotal =
                    adultCount * perAdultPrice;

                const childrenTotal =
                    childrenCount * perChildPrice;

                const subTotal =
                    adultTotal + childrenTotal;

                animatePrice(
                    $('#subTotal'),
                    subTotal
                );
            }
            //rooom recomendation
            function updateRecommendedRooms() {
                const adults = parseInt($('#adultCount').val()) || 0;
                const children = parseInt($('#childrenCount').val()) || 0;
                const totalPax = adults + children;
                if (totalPax <= 0) {return;}
                /*
                =====================================================
                ROOM CALCULATION
                2 normal members per room
                Maximum 1 extra mattress per room
                1-2 = 1 room
                3   = 1 room + mattress
                4   = 2 rooms
                5   = 2 rooms (one mattress)
                6   = 2 rooms (both mattress)
                7   = 3 rooms (one mattress)
                =====================================================
                */
                const rooms = Math.ceil(totalPax / 3);
                let remainingPax = totalPax;
                let roomsHTML = '';
                for (let i = 1; i <= rooms; i++) {
                    let roomPax = Math.min(remainingPax, 3);
                    remainingPax -= roomPax;
                    const extraMattress = roomPax === 3;
                    let bedText = '1 Double Bed';
                    if (extraMattress) {
                        bedText += ' + 1 Extra Mattress';
                    }
                    let accommodationText =
                        roomPax + ' Pax will be accommodated in 1 room';
                    if (extraMattress) {
                        accommodationText += ' with extra mattress.';
                    } else {
                        accommodationText += '.';
                    }
                    roomsHTML += `
                        <p class="fontSize10 fw-bold">Room ${i}</p>
                        <div class="row">
                            <div class="col-xl-9 col-lg-8 col-md-8 col-sm-7 col-12 mb-3">
                                <div class="d-flex justify-content-between mobileDisplayBlock">
                                    <div>
                                        <p class="fontSize10 fw-bold">
                                            <i class="ri-hotel-bed-fill destination-title fs-6"></i>
                                            ${bedText}
                                        </p>
                                        <p class="fontSize10">
                                            ${accommodationText}
                                        </p>
                                    </div>
                                    <div class="py-1 px-2 text-center text-success-emphasis bg-success-subtle border border-success-subtle rounded-3 recommendedBtn fw-bold fontSize10">
                                        Recommended
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-4 col-md-4 col-sm-5 col-12 mb-3">
                                <button class="btn modifyBtn" type="button" data-room="${i}">Modify Rooms</button>
                            </div>
                        </div>
                    `;
                }
                /*
                =====================================================
                ADD ROOM BUTTON
                KEEP IT INSIDE THE SAME CARD
                =====================================================
                */
                roomsHTML += `
                    <div class="d-flex justify-content-center">
                        <button class="btn addRoomBtn" type="button">Add Room (If more travellers)</button>
                    </div>
                `;
                /*
                =====================================================
                IMPORTANT:
                Do NOT replace #roomRecommendation itself.
                Only replace its contents.
                =====================================================
                */
                $('#roomRecommendation').html(roomsHTML);
            }
            //load modify rooms
            function loadModifyRooms(adults, children, infants) {

                const container = $('#modifyRoomsContainer');

                container.empty();

                // Total counts
                $('#totalAdults').text(adults);
                $('#totalChildren').text(children);
                $('#totalInfants').text(infants);


                // Infants do not consume room occupancy
                const totalOccupancy = adults + children;


                // Max 3 occupants per room
                const rooms = Math.max(
                    1,
                    Math.ceil(totalOccupancy / 3)
                );


                let remainingOccupancy = totalOccupancy;


                // Create rooms
                for (let i = 1; i <= rooms; i++) {

                    const occupancy = Math.min(
                        remainingOccupancy,
                        3
                    );

                    remainingOccupancy -= occupancy;


                    // Extra mattress default
                    const extraMattress = occupancy === 3;


                    const roomHTML = `
                        <div class="modify-room-card mb-3" data-room="${i}">

                            <div class="room-content-row">

                                <!-- ROOM TITLE -->
                                <div class="room-title">
                                    <p class="fontSize10 fw-bold mb-0">
                                        Room ${i}
                                    </p>
                                </div>


                                <!-- ROOM OCCUPANCY -->
                                <div class="occupancy-section">

                                    <label class="fontSize10 fw-bold mb-0">
                                        Room Occupancy
                                    </label>

                                    <div class="occupancy-control">

                                        <button type="button"
                                                class="occupancy-minus">
                                            -
                                        </button>

                                        <input type="text"
                                            class="form-control text-center room-occupancy"
                                            value="${occupancy}"
                                            readonly>

                                        <button type="button"
                                                class="occupancy-plus">
                                            +
                                        </button>

                                    </div>

                                </div>


                                <!-- EXTRA MATTRESS -->
                                <div class="mattress-section">

                                    <div class="form-check mb-0">

                                        <input class="form-check-input extra-mattress"
                                            type="checkbox"
                                            id="extraMattress${i}"
                                            ${extraMattress ? 'checked' : ''}>

                                        <label class="form-check-label fontSize10"
                                            for="extraMattress${i}">
                                            With Extra Mattress
                                        </label>

                                    </div>

                                </div>


                                <!-- REMOVE ROOM -->
                                ${i > 1 ? `
                                    <div class="ms-auto">

                                        <button type="button"
                                                class="removeModifyRoom">
                                            Remove
                                        </button>

                                    </div>
                                ` : ''}

                            </div>

                        </div>
                    `;

                    container.append(roomHTML);
                }
            }
            // =====================================================
            // RENUMBER ROOMS
            // =====================================================

            function renumberModifyRooms() {
                $('#modifyRoomsContainer .modify-room-card').each(function (index) {
                        const roomNumber = index + 1;
                        const roomCard = $(this);
                        // Update data-room
                        roomCard.attr(
                            'data-room',
                            roomNumber
                        );
                        // Update Room X text
                        roomCard
                            .find('p.fontSize10.fw-bold.mb-0')
                            .first()
                            .text(
                                'Room ' + roomNumber
                            );
                        // Update checkbox ID
                        const checkbox =
                            roomCard.find('.extra-mattress');
                        const checkboxId =
                            'extraMattress' + roomNumber;
                        checkbox.attr(
                            'id',
                            checkboxId
                        );
                        // Update label's for attribute
                        roomCard
                            .find('label.form-check-label')
                            .attr(
                                'for',
                                checkboxId
                            );
                        // Room 1 should not have Remove button
                        if (roomNumber === 1) {
                            roomCard
                                .find('.removeModifyRoom')
                                .remove();
                        }
                    });

            }
            // =====================================================
            // GET TOTAL TRAVELLERS
            // =====================================================

            function getTotalTravellers() {
                return {
                    adults: parseInt($('#adultCount').val()) || 0,
                    children: parseInt($('#childrenCount').val()) || 0,
                    infants: parseInt($('#infantCount').val()) || 0
                };
            }

            // =====================================================
            // UPDATE EXTRA MATTRESS BASED ON OCCUPANCY
            // =====================================================

            function updateRoomExtraMattress(roomCard) {
                const occupancy =parseInt(roomCard.find('.room-occupancy').val()) || 0;
                const checkbox =roomCard.find('.extra-mattress');
                /*
                3 people = extra mattress recommended
                1 or 2 people = no extra mattress
                */
                if (occupancy === 3) {
                    checkbox.prop('checked', true);
                } else {
                    checkbox.prop('checked', false);
                }
            }

            // =====================================================
            // UPDATE RECOMMENDATION FROM USER MODIFICATION
            // =====================================================

            function updateRecommendedRoomsFromModification(roomOccupancies,adults,children,infants) {
                let roomsHTML = '';
                roomOccupancies.forEach(function (room, index) {
                    const roomNumber =index + 1;
                    const occupancy =room.occupancy;
                    const extraMattress =room.extraMattress;

                    // =================================================
                    // BED TEXT
                    // =================================================

                    let bedText ='1 Double Bed';
                    if (extraMattress) {
                        bedText +=
                            ' + 1 Extra Mattress';
                    }

                    // =================================================
                    // ACCOMMODATION TEXT
                    // =================================================

                    let accommodationText =occupancy +' Pax will be accommodated in 1 room';

                    if (extraMattress) {
                        accommodationText +=
                            ' with extra mattress.';
                    } else {
                        accommodationText += '.';
                    }

                    // =================================================
                    // RECOMMENDATION HTML
                    // =================================================
                    roomsHTML += `
                        <p class="fontSize10 fw-bold">Room ${roomNumber}</p>
                        <div class="row">
                            <div class="col-xl-9 col-lg-8 col-md-8 col-sm-7 col-12 mb-3">
                                <div class="d-flex justify-content-between mobileDisplayBlock">
                                    <div>
                                        <p class="fontSize10 fw-bold">
                                            <i class="ri-hotel-bed-fill destination-title fs-6"></i>
                                            ${bedText}
                                        </p>
                                        <p class="fontSize10">${accommodationText}</p>
                                    </div>
                                    <div class="py-1 px-2 text-center text-info-emphasis bg-info-subtle border border-info-subtle rounded-3 userpreferenceBtn fw-bold fontSize10">
                                        <span>User Preference</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-4 col-md-4 col-sm-5 col-12 mb-3">
                                <button class="btn modifyBtn" type="button" data-room="${roomNumber}">Modify Rooms</button>
                            </div>
                        </div>

                    `;
                });

                // =====================================================
                // ADD ROOM BUTTON
                // =====================================================

                roomsHTML += `
                    <div class="d-flex justify-content-center">
                        <button class="btn addRoomBtn" type="button">Add Room (If more travellers)</button>
                    </div>
                `;

                // =====================================================
                // UPDATE ONLY CONTENT
                // =====================================================

                $('#roomRecommendation').html(roomsHTML);
            }
            //coupon drop down
            function updateCouponDropdowns() {
                const selectedCoupons = [];
                let selectedPrimaryCoupons = 0;
                /*
                |--------------------------------------------------------------------------
                | Get all currently selected coupons
                |--------------------------------------------------------------------------
                */
                $('.coupon-select').each(function () {
                    const value = $(this).val();
                    if (value !== '') {
                        selectedCoupons.push(value);
                        const type = $(this)
                            .find('option:selected')
                            .data('type');
                        if (type === 'primary') {
                            selectedPrimaryCoupons++;
                        }
                    }
                });
                /*
                |--------------------------------------------------------------------------
                | Primary coupons are considered exhausted
                | when all available primary coupons are selected
                |--------------------------------------------------------------------------
                */
                const primaryCouponsExhausted =
                    totalPrimaryCoupons === 0 ||
                    selectedPrimaryCoupons >= totalPrimaryCoupons;
                /*
                |--------------------------------------------------------------------------
                | Update all dropdowns
                |--------------------------------------------------------------------------
                */
                $('.coupon-select').each(function () {
                    const $select = $(this);
                    const currentValue = $select.val();
                    $select.find('option').each(function () {
                        const $option = $(this);
                        const value = $option.val();
                        const type = $option.data('type');
                        // Skip placeholder
                        if (!value) {
                            return;
                        }
                        /*
                        |--------------------------------------------------------------------------
                        | Disable coupon already selected in another dropdown
                        |--------------------------------------------------------------------------
                        */
                        if (
                            selectedCoupons.includes(value) &&
                            value !== currentValue
                        ) {

                            $option.prop('disabled', true);

                            return;
                        }


                        /*
                        |--------------------------------------------------------------------------
                        | Loyalty coupons
                        |--------------------------------------------------------------------------
                        */

                        if (type === 'loyalty') {

                            /*
                            * Enable loyalty only when all
                            * available primary coupons are selected
                            */
                            if (!primaryCouponsExhausted) {

                                $option.prop('disabled', true);

                            } else {

                                $option.prop('disabled', false);

                            }

                        } else {

                            /*
                            * Primary coupon is available
                            */
                            $option.prop('disabled', false);

                        }

                    });

                });

                // calculate total selected coupon discount
                let totalDiscount = 0;

                $('.coupon-select').each(function () {

                    const selectedOption =
                        $(this).find('option:selected');

                    const amount =
                        parseFloat(selectedOption.data('amount')) || 0;

                    if ($(this).val() !== '') {
                        totalDiscount += amount;
                    }
                });

                // Update discount display
                $('#totalCouponDiscount').text(
                    '- ₹ ' + totalDiscount.toLocaleString('en-IN')
                );

                // Update final package price
                updateFinalPackagePrice();

            }
            // =====================================================
            // GENERATE COUPON DROPDOWNS
            // =====================================================

            function generateCouponDropdowns() {

                const adults =
                    parseInt($('#adultCount').val()) || 0;

                const children =
                    parseInt($('#childrenCount').val()) || 0;

                const container =
                    $('#couponPassengerContainer');

                container.empty();

                // Create Adult rows
                for (let i = 1; i <= adults; i++) {

                    container.append(
                        createCouponRow('Adult', i)
                    );

                }

                // Create Child rows
                for (let i = 1; i <= children; i++) {

                    container.append(
                        createCouponRow('Child', i)
                    );

                }

                updateCouponDropdowns();

                // Reset total coupon discount
                updateTotalCouponDiscount();

            }
            //coupon row
            function createCouponRow(type, number) {

                return `
                    <div class="d-flex justify-content-between mb-2 coupon-passenger-row">

                        <div class="d-flex gap-3 largeDisplay">

                            <p class="fontSize10 align-content-end mb-0">
                                ${type} ${number}
                            </p>

                            <p class="mb-0">

                                <select
                                    class="form-select fontSize10 selectPadding coupon-select">

                                    <option value="">
                                        Select Coupon
                                    </option>

                                    <?php if (!empty($cuCoupons)): ?>

                                        <optgroup label="Primary Coupons">

                                            <?php foreach ($cuCoupons as $coupon): ?>

                                                <option
                                                    value="<?= htmlspecialchars($coupon['code']) ?>"
                                                    data-type="primary"
                                                    data-amount="<?= htmlspecialchars($coupon['coupon_amt']) ?>">

                                                    <?= htmlspecialchars($coupon['code']) ?>

                                                </option>

                                            <?php endforeach; ?>

                                        </optgroup>

                                    <?php endif; ?>


                                    <?php if (!empty($loyaltyCoupons)): ?>

                                        <optgroup label="Loyalty Coupons">

                                            <?php foreach ($loyaltyCoupons as $coupon): ?>

                                                <option
                                                    value="<?= htmlspecialchars($coupon['code']) ?>"
                                                    data-type="loyalty"
                                                    data-amount="<?= htmlspecialchars($coupon['coupon_amt']) ?>">

                                                    <?= htmlspecialchars($coupon['code']) ?>

                                                </option>

                                            <?php endforeach; ?>

                                        </optgroup>

                                    <?php endif; ?>

                                </select>

                            </p>

                        </div>


                        <p class="fontSize10 discountGreen fw-bold text-end align-content-end coupon-discount mb-0">
                            - ₹ 0
                        </p>

                    </div>
                `;
            }
            // =====================================================
            // UPDATE TOTAL COUPON DISCOUNT
            // =====================================================

            function updateTotalCouponDiscount() {

                let totalDiscount = 0;

                $('.coupon-select').each(function () {

                    const selectedOption =
                        $(this).find('option:selected');

                    const amount =
                        parseFloat(
                            selectedOption.data('amount')
                        ) || 0;

                    totalDiscount += amount;

                });

                $('#totalCouponDiscount').text(
                    '- ₹ ' + totalDiscount.toLocaleString('en-IN')
                );

            }
            // =====================================================
            // UPDATE FINAL PACKAGE PRICE
            // =====================================================
            function updateFinalPackagePrice() {

                const adults =
                    parseInt($('#adultCount').val()) || 0;

                const children =
                    parseInt($('#childrenCount').val()) || 0;


                // =====================================================
                // ADULT TOTAL
                // =====================================================

                const adultTotal =
                    adults * perAdultPrice;


                // =====================================================
                // CHILD TOTAL
                // =====================================================

                const childrenTotal =
                    children * perChildPrice;


                // =====================================================
                // COUPON DISCOUNT
                // Always convert to POSITIVE amount
                // =====================================================

                const couponDiscount =
                    Math.abs(
                        parseFloat(
                            $('#totalCouponDiscount')
                                .text()
                                .replace(/[^\d.-]/g, '')
                        ) || 0
                    );


                // =====================================================
                // TOTAL AFTER COUPON
                // =====================================================

                const totalAfterCoupon =
                    Math.max(
                        0,
                        adultTotal +
                        childrenTotal -
                        couponDiscount
                    );


                // =====================================================
                // CONVENIENCE FEE - 1%
                // Calculated on amount after coupon
                // =====================================================

                const convenienceFee =
                    totalAfterCoupon * 0.01;


                // =====================================================
                // GST
                // GST is calculated on Convenience Fee
                // =====================================================

                const gstPercentage =
                    parseFloat('<?= $gst['gst'] ?>') || 0;

                const gstValue =
                    convenienceFee *
                    (gstPercentage / 100);


                // =====================================================
                // FINAL PAYABLE AMOUNT
                // =====================================================

                const finalAmount =
                    totalAfterCoupon +
                    convenienceFee +
                    gstValue;


                // =====================================================
                // FORMAT FINAL AMOUNT
                // =====================================================

                const formattedFinalAmount =
                    finalAmount.toLocaleString('en-IN', {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    });


                // =====================================================
                // UPDATE FINAL PACKAGE PRICE
                // =====================================================

                $('#finalPackagePrice').text(
                    '₹ ' + formattedFinalAmount
                );

                $('#finalPackagePrice1').text(
                    '₹ ' + formattedFinalAmount
                );

                $('#finalPackagePrice2').text(
                    '₹ ' + formattedFinalAmount
                );


                // =====================================================
                // UPDATE CONVENIENCE FEE
                // =====================================================

                $('#convenienceFeee').text(
                    '₹ ' + convenienceFee.toLocaleString('en-IN', {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    })
                );


                // =====================================================
                // UPDATE GST VALUE
                // =====================================================

                $('#gstValue').text(
                    '₹ ' + gstValue.toLocaleString('en-IN', {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    })
                );

            }
            // Guest Counter
            $('.guest-counter').each(function () {

                const $counter = $(this);

                const $minusBtn = $counter.find('.minus');
                const $plusBtn = $counter.find('.plus');
                const $input = $counter.find('.counter-value');


                // Minus button
                $minusBtn.on('click', function () {

                    let value = parseInt($input.val()) || 0;

                    const minValue = $counter
                        .find('.guest-label')
                        .text()
                        .includes('Adults') ? 1 : 0;


                    if (value > minValue) {

                        $input.val(value - 1);

                        // Trigger price calculation
                        $input.trigger('change');

                    }

                });


                // Plus button
                $plusBtn.on('click', function () {

                    let value = parseInt($input.val()) || 0;

                    $input.val(value + 1);

                    // Trigger price calculation
                    $input.trigger('change');

                });

            });
            // =====================================================
            // Adult Count Change
            // =====================================================

            $('#adultCount').on('change', function () {

                const adultCount =
                    parseInt($(this).val()) || 0;

                const adultTotal =
                    adultCount * perAdultPrice;

                $('#totalAdultCount').text(adultCount);

                animatePrice(
                    $('#adultTotal'),
                    adultTotal,
                    '₹ '
                );

                // Update subtotal
                updateSubTotal();

                // Update room recommendation
                updateRecommendedRooms();

                // Update coupon passenger rows
                generateCouponDropdowns();
                
                //update final price
                updateFinalPackagePrice();
            });


            // =====================================================
            // Children Count Change
            // =====================================================

            $('#childrenCount').on('change', function () {

                const childrenCount =
                    parseInt($(this).val()) || 0;

                const childrenTotal =
                    childrenCount * perChildPrice;

                $('#totalChildrenCount').text(childrenCount);

                animatePrice(
                    $('#childrenTotal'),
                    childrenTotal,
                    '₹ '
                );

                // Update subtotal
                updateSubTotal();

                // Update room recommendation
                updateRecommendedRooms();

                // Update coupon passenger rows
                generateCouponDropdowns();

                //update final price
                updateFinalPackagePrice();

            });

            // =====================================================
            // Children Count Change
            // =====================================================

            $('#infantCount').on('change', function () {

                const infantCount =
                    parseInt($(this).val()) || 0;

                const childrenTotal =
                    infantCount * perChildPrice;

                $('#totalInfantCount').text(infantCount);

                animatePrice(
                    $('#childrenTotal'),
                    childrenTotal,
                    '₹ '
                );

                // Update subtotal
                updateSubTotal();

                // Update room recommendation
                updateRecommendedRooms();

                // Update coupon passenger rows
                generateCouponDropdowns();

                //update final price
                updateFinalPackagePrice();

            });
            // Travel Date Update
            $('#travelStartDate').on('change', function () {

                const startDate = $(this).val();

                if (!startDate || !tourDays) {
                    return;
                }

                const totalDays = parseInt(tourDays);

                if (totalDays <= 0) {
                    return;
                }

                const $endDate = $('#travelEndDate');

                // Stop previous animation
                clearInterval($endDate.data('dateAnimation'));

                const start = new Date(startDate);

                let currentDate = new Date(start);
                let currentDay = 1;

                // Show starting date
                $endDate.val(
                    currentDate.toISOString().split('T')[0]
                );

                // Day 1 means no calculation needed
                if (totalDays === 1) {
                    return;
                }

                const dateAnimation = setInterval(function () {

                    // Add exactly one day
                    currentDate.setDate(
                        currentDate.getDate() + 1
                    );

                    currentDay++;

                    // Update the input directly
                    $endDate.val(
                        currentDate.toISOString().split('T')[0]
                    );

                    // Stop at final day
                    if (currentDay >= totalDays) {

                        clearInterval(dateAnimation);

                        $endDate.data(
                            'dateAnimation',
                            null
                        );
                    }

                }, 120);

                // Store animation
                $endDate.data(
                    'dateAnimation',
                    dateAnimation
                );
            });
            //pickup drop change value 
            $('.location-input').on('blur', function () {

                const $input = $(this);

                const oldValue = $input.data('old-value');
                const newValue = $.trim($input.val());

                // Show old value only if changed
                if (newValue !== oldValue) {

                    if ($input.attr('id') === 'pickupLocation') {
                        $('#pickupOldValue')
                            .text('Old: ' + oldValue)
                            .show();
                    }

                    if ($input.attr('id') === 'dropLocation') {
                        $('#dropOldValue')
                            .text('Old: ' + oldValue)
                            .show();
                    }

                } else {

                    if ($input.attr('id') === 'pickupLocation') {
                        $('#pickupOldValue').hide();
                    }

                    if ($input.attr('id') === 'dropLocation') {
                        $('#dropOldValue').hide();
                    }
                }
            });
            //trigger room modification modal
            $(document).on('click', '.modifyBtn', function (e) {

                e.preventDefault();

                const roomNumber = parseInt($(this).data('room')) || 1;

                const adults =
                    parseInt($('#adultCount').val()) || 0;

                const children =
                    parseInt($('#childrenCount').val()) || 0;

                const infants =
                    parseInt($('#infantCount').val()) || 0;

                console.log('Total Adults:', adults);
                console.log('Total Children:', children);
                console.log('Total Infants:', infants);

                loadModifyRooms(
                    adults,
                    children,
                    infants
                );

                const modalElement =
                    document.getElementById('modifyRoomsModal');

                const modal =
                    bootstrap.Modal.getOrCreateInstance(modalElement);

                modal.show();

            });
            // =====================================================
            // APPLY ROOM MODIFICATION
            // =====================================================

            $(document).on('click', '#applyRoomModification', function () {
                const adults =parseInt($('#adultCount').val()) || 0;
                const children =parseInt($('#childrenCount').val()) || 0;
                const infants =parseInt($('#infantCount').val()) || 0;
                const totalTravellers =adults + children;
                let roomOccupancies = [];
                let totalRoomOccupancy = 0;

                // =================================================
                // READ ROOMS
                // =================================================

                $('#modifyRoomsContainer .modify-room-card').each(function () {
                    const occupancy =parseInt($(this).find('.room-occupancy').val()) || 0;
                    const extraMattress =$(this).find('.extra-mattress').is(':checked');
                    roomOccupancies.push({
                        occupancy: occupancy,
                        extraMattress: extraMattress
                    });
                    totalRoomOccupancy += occupancy;
                });

                // =================================================
                // VALIDATE ROOM OCCUPANCY
                // =================================================

                if (totalRoomOccupancy !== totalTravellers) {

                    Swal.fire({
                        icon: 'warning',
                        title: 'Invalid Room Occupancy',
                        text: 'Room occupancy must match the total number of Adults and Children.',
                        confirmButtonText: 'Okay'
                    });

                    return;
                }

                // =================================================
                // UPDATE RECOMMENDATION
                // USING USER'S ROOM ARRANGEMENT
                // =================================================

                updateRecommendedRoomsFromModification(
                    roomOccupancies,
                    adults,
                    children,
                    infants
                );


                // =================================================
                // CLOSE MODAL
                // =================================================

                const modalElement =document.getElementById('modifyRoomsModal');
                const modalInstance =bootstrap.Modal.getInstance(modalElement);
                if (modalInstance) {
                    modalInstance.hide();
                }

            });
            // =====================================================
            // ROOM OCCUPANCY PLUS
            // =====================================================

            $(document).on('click', '.occupancy-plus', function () {
                const roomCard =$(this).closest('.modify-room-card');
                const occupancyInput =roomCard.find('.room-occupancy');
                let occupancy = parseInt(occupancyInput.val()) || 0;

                // =================================================
                // MAX 3 PEOPLE PER ROOM
                // =================================================

                if (occupancy >= 3) {
                    return;
                }

                // =================================================
                // TOTAL AVAILABLE OCCUPANCY
                // ADULTS + CHILDREN
                // =================================================

                const adults =parseInt($('#adultCount').val()) || 0;
                const children =parseInt($('#childrenCount').val()) || 0;
                const totalTravellers =adults + children;

                // =================================================
                // CURRENT OCCUPANCY OF ALL ROOMS
                // =================================================

                let currentTotal = 0;
                $('#modifyRoomsContainer .room-occupancy').each(function () {
                    currentTotal +=parseInt($(this).val()) || 0;
                });

                // =================================================
                // DON'T EXCEED TOTAL TRAVELLERS
                // =================================================

                if (currentTotal >= totalTravellers) {
                    return;
                }

                // =================================================
                // INCREASE
                // =================================================
                occupancy++;
                occupancyInput.val(occupancy);

                // =================================================
                // UPDATE EXTRA MATTRESS
                // =================================================

                updateRoomExtraMattress(roomCard);
            });
            // =====================================================
            // ROOM OCCUPANCY MINUS
            // =====================================================

            $(document).on('click', '.occupancy-minus', function () {
                const roomCard = $(this).closest('.modify-room-card');
                const occupancyInput =roomCard.find('.room-occupancy');
                let occupancy =parseInt(occupancyInput.val()) || 0;

                // =================================================
                // MINIMUM 1 PERSON PER ROOM
                // =================================================

                if (occupancy <= 1) {
                    return;
                }

                occupancy--;
                occupancyInput.val(occupancy);

                // =================================================
                // UPDATE EXTRA MATTRESS
                // =================================================

                updateRoomExtraMattress(roomCard);
            });
            // =====================================================
            // ADD ROOM
            // =====================================================

            $(document).on('click', '#addModifyRoom', function () {

                const container = $('#modifyRoomsContainer');

                const roomCount = container.find('.modify-room-card').length;

                const newRoomNumber = roomCount + 1;


                const roomHTML = `
                    <div class="modify-room-card mb-3"
                        data-room="${newRoomNumber}">

                        <div class="room-content-row">

                            <!-- ROOM TITLE -->
                            <div class="room-title">

                                <p class="fontSize10 fw-bold mb-0">
                                    Room ${newRoomNumber}
                                </p>

                            </div>


                            <!-- ROOM OCCUPANCY -->
                            <div class="occupancy-section">

                                <label class="fontSize10 fw-bold mb-0">
                                    Room Occupancy
                                </label>

                                <div class="occupancy-control">

                                    <button type="button"
                                            class="occupancy-minus">
                                        -
                                    </button>

                                    <input type="text"
                                        class="form-control text-center room-occupancy"
                                        value="1"
                                        readonly>

                                    <button type="button"
                                            class="occupancy-plus">
                                        +
                                    </button>

                                </div>

                            </div>


                            <!-- EXTRA MATTRESS -->
                            <div class="mattress-section">

                                <div class="form-check mb-0">

                                    <input class="form-check-input extra-mattress"
                                        type="checkbox"
                                        id="extraMattress${newRoomNumber}">

                                    <label class="form-check-label fontSize10"
                                        for="extraMattress${newRoomNumber}">
                                        With Extra Mattress
                                    </label>

                                </div>

                            </div>


                            <!-- REMOVE ROOM -->
                            <div class="ms-auto">

                                <button type="button"
                                        class="removeModifyRoom">
                                    Remove
                                </button>

                            </div>

                        </div>

                    </div>
                `;

                container.append(roomHTML);

            });
            // =====================================================
            // REMOVE ROOM
            // =====================================================

            $(document).on('click', '.removeModifyRoom', function () {

                $(this)
                    .closest('.modify-room-card')
                    .remove();

                renumberModifyRooms();
            });
            //add button
            $(document).on('click', '.addRoomBtn', function () {
                const adults =parseInt($('#adultCount').val()) || 0;
                const children =parseInt($('#childrenCount').val()) || 0;
                const infants =parseInt($('#infantCount').val()) || 0;
                loadModifyRooms(
                    adults,
                    children,
                    infants
                );
                const modalElement =document.getElementById('modifyRoomsModal');
                const modal =bootstrap.Modal.getOrCreateInstance(modalElement);
                modal.show();
            });
            //vechel modal show
            $(document).on('click', '#changeVehicle', function (e) {

                e.preventDefault();

                const modalElement =
                    document.getElementById('vehicleSelectionModal');

                const modal =
                    bootstrap.Modal.getOrCreateInstance(modalElement);

                modal.show();

            });
            let selectedVehicle = null;


            // =====================================================
            // SELECT VEHICLE
            // =====================================================

            $(document).on('click', '.vehicle-option', function () {

                $('.vehicle-option').removeClass('active');

                $(this).addClass('active');

                selectedVehicle = {
                    value: $(this).data('value'),
                    name: $(this).data('name')
                };

            });


            // =====================================================
            // APPLY VEHICLE
            // =====================================================

            $(document).on('click', '#applyVehicleSelection', function () {

                if (!selectedVehicle) {

                    alert('Please select a vehicle.');

                    return;
                }

                // Get total travellers
                const adults =
                    parseInt($('#adultCount').val()) || 0;

                const children =
                    parseInt($('#childrenCount').val()) || 0;

                const infants =
                    parseInt($('#infantCount').val()) || 0;

                // Pax for vehicle
                const totalPax = adults + children + infants;


                // Update vehicle text
                $('#selectedVehicleText').text(
                    selectedVehicle.name + ' (For ' + totalPax + ' Pax)'
                );


                // Store selected vehicle
                $('#vehicle_id').val(selectedVehicle.value);


                // Close modal
                const modalElement =
                    document.getElementById('vehicleSelectionModal');

                const modal =
                    bootstrap.Modal.getInstance(modalElement);

                if (modal) {
                    modal.hide();
                }

            });

            // =====================================================
            // COUPON CHANGE
            // =====================================================

            $(document).on('change', '.coupon-select', function () {
                const $select = $(this);
                const selectedOption =
                    $select.find('option:selected');
                const amount =
                    parseFloat(
                        selectedOption.data('amount')
                    ) || 0;
                // Update individual passenger discount
                const row =
                    $select.closest('.coupon-passenger-row');
                row.find('.coupon-discount').text(
                    '- ₹ ' + amount.toLocaleString('en-IN')
                );

                // Update coupon restrictions
                updateCouponDropdowns();

                // Update total coupon discount
                updateTotalCouponDiscount();

                //update final price
                updateFinalPackagePrice();

            });
            
            // =====================================================
            // PACKAGE COUPON CHANGE
            // =====================================================

            $(document).on('change', '#packageCouponSelect', function () {

                const $select = $(this);

                const amount =
                    parseFloat(
                        $select.find('option:selected').data('amount')
                    ) || 0;

                // Individual coupon discount
                $('#packageCouponDiscount').text(
                    '₹ ' + amount.toLocaleString('en-IN')
                );

                // Total coupon discount
                $('#totalCouponDiscount').text(
                    '- ₹ ' + amount.toLocaleString('en-IN')
                );

                //update final price
                updateFinalPackagePrice();

            });
            // =====================================================
            // ON PAGE LOAD
            // =====================================================

            $(document).ready(function () {

                // =====================================================
                // PASSENGER COUPONS
                // =====================================================

                generateCouponDropdowns();


                // =====================================================
                // PACKAGE COUPON
                // =====================================================

                $('#packageCouponDiscount').text('₹ 0');

                $('#totalCouponDiscount').text('- ₹ 0');

            });
        </script>
        <!-- Pricing Section -->
        <script>
            document.addEventListener("DOMContentLoaded", function () {

                const pricingSidebar = document.getElementById("pricingSidebar");
                const openBtn = document.getElementById("openPricingBtn");
                const closeBtn = document.getElementById("closePricing");
                const overlay = document.getElementById("pricingOverlay");

                function openPricing() {
                    pricingSidebar.classList.add("show");
                    overlay.classList.add("show");
                    document.body.style.overflow = "hidden";
                }

                function closePricing() {
                    pricingSidebar.classList.remove("show");
                    overlay.classList.remove("show");
                    document.body.style.overflow = "";
                }

                openBtn.addEventListener("click", openPricing);

                closeBtn.addEventListener("click", closePricing);

                overlay.addEventListener("click", closePricing);

                window.addEventListener("resize", function () {
                    if (window.innerWidth > 991) {
                        closePricing();
                    }
                });

            });
        </script>
        <!-- Request Details Age Incrementer And Decrementer End -->

    </body>

</html>