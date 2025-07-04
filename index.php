<?php
    session_start();

    if(isset($_SESSION['user_type_id_value'])){
        $user_type = $_SESSION["user_type_id_value"];
        $user_id = $_SESSION["user_id"];
    } else {
        $user_type = 0;
        $user_id = 0;
    }
?>
<!DOCTYPE html>
<html lang="zxx" dir="lrt">

<meta http-equiv="content-type" content="text/html;charset=utf-8" /><!-- /Added by HTTrack -->
<head>
    <script>
        const setTheme = (theme) => {
            theme ??= localStorage.theme || "light";
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
    <meta name="description" content="Travello - Multipurpose travel and tour booking.These template is suitable for  travel agency , tour, travel website , tour operator , tourism , booking  trip or adventure website. ">
    <meta name="keywords" content="travel, trip booking,tour, hotel, tour guide, tourism, blog, flight, travel agency, tourism agency, accommodation, tour website">
    <meta name="author" content="Mirthcon Technologies">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta property="og:type" content="website">
    <meta property="og:title" content="Multipurpose travel and tour booking">
    <meta property="og:site_name" content="Travello">
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
    <title>Multipurpose travel and tour booking </title>
    <link rel="icon" type="image/x-icon" sizes="20x20" href="assets/images/icon/fav.png">
    <!-- Bootstrap -->
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap-5.3.0.min.css">
    <!-- Fonts & icon -->
    <link rel="stylesheet" type="text/css" href="assets/css/remixicon.css">
    <!-- Plugin -->
    <link rel="stylesheet" type="text/css" href="assets/css/plugin.css">
    <!-- Main CSS -->
    <link rel="stylesheet" type="text/css" href="assets/css/main-style.css">
    <!-- RTL CSS::When Need RTL Uncomments File -->
    <!-- <link rel="stylesheet" type="text/css" href="assets/css/rtl.css"> -->
</head>
<body>
    <?php include_once "header.php" ?>
    <main>
        <!-- Hero area S t a r t-->
        <section class="hero-area-bg hero-padding1">
            <div class="container">
                <div class="row align-items-center justify-content-between g-4">
                    <div class="col-xxl-5 col-xl-6 col-lg-6 col-md-12 col-sm-12">
                        <div class="hero-caption-one position-relative">
                            <h4 class="title wow fadeInUp" data-wow-delay="0.0s">The World's Best Travel Spots</h4>
                            <p class="pera wow fadeInUp" data-wow-delay="0.1s">
                                Bizzmirth Holidays Pvt. Ltd. specializes in selling tailored holiday packages, 
                                offering unforgettable travel experiences designed to suit diverse preferences and budgets.
                            </p>
                        </div>
                        <!-- <div class="hero-footer position-relative">
                            <a href="../../www.youtube.com/watcha076.html?v=Cn4G2lZ_g2I" data-fancybox="video-gallery" class="wow bounceIn" data-wow-delay=".3s">
                                <div class="video-player">
                                    <i class="ri-play-fill"></i>
                                </div>
                            </a>
                            <div class="all-user wow fadeInRight" data-wow-delay="0.5s">
                                <div class="happy-user">
                                    <img src="assets/images/hero/user-1.jpeg" alt="travello">
                                </div>
                                <div class="happy-user">
                                    <img src="assets/images/hero/user-2.png" alt="travello">
                                </div>
                                <div class="happy-user">
                                    <img src="assets/images/hero/user-3.png" alt="travello">
                                </div>
                                <div class="happy-user">
                                    <img src="assets/images/hero/user-4.jpeg" alt="travello">
                                </div>
                                <div class="happy-user-count">
                                    <p class="user-count">5k+</p>
                                </div>
                                <p class="pera">Happy Customer</p>
                            </div>
                        </div> -->
                    </div>
                    <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-sm-12 d-lg-block">
                        <div class="hero-banner wow fadeInRight" data-wow-delay="0.0s">
                            <!-- Slider -->
                            <div class="swiper h1-Hero-active">
                                <div class="swiper-wrapper">
                                    <!-- Single -->
                                    <div class="swiper-slide">
                                        <video class="hero-slider-video" loop autoplay muted>
                                            <source src="assets/images/hero/hero-slider2.mp4" type="video/mp4">
                                            Your browser does not support the video tag.
                                        </video>
                                    </div>
                                    <!-- Single -->
                                    <div class="swiper-slide">
                                        <video class="hero-slider-video" loop autoplay muted>
                                            <source src="assets/images/hero/hero-slider1.mp4" type="video/mp4">
                                            Your browser does not support the video tag.
                                        </video>
                                    </div>
                                    <!-- Single -->
                                    <div class="swiper-slide">
                                        <video class="hero-slider-video" loop autoplay muted>
                                            <source src="assets/images/videos/travel11.html" type="video/mp4">
                                            Your browser does not support the video tag.
                                        </video>
                                    </div>
                                    <!--img-->
                                    <div class="swiper-slide">
                                        <img src="assets/images/hero/hero-banner-1.png" alt="travello">
                                    </div>
                                </div>
                            </div>
                            <!-- / End Slider -->

                            <!-- shape 01 -->
                            <div class="shape">
                                <img src="assets/images/hero/shape-1.png" alt="travello">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--/ End-of Hero-->

        <!-- Plan area S t a r t -->
        <!-- <section class="plan-area">
            <div class="container">
                <div class="plan-section plan-shadow">
                    <div class="select-dropdown-section">
                        <div class="d-flex gap-10 align-items-center">
                            <i class="ri-map-pin-line"></i>
                            <h4 class="select2-title">Destination</h4>
                        </div>
                        <select class="destination-dropdown">
                            <option value="1">Sydney, Australia</option>
                            <option value="2">USA, Turkish </option>
                            <option value="3">Chittagong, Turkish </option>
                        </select>
                    </div>
                    <div class="divider plan-divider d-none d-lg-block"></div>
                    <div class="select-dropdown-section">
                        <div class="d-flex gap-10 align-items-center">
                            <i class="ri-flight-takeoff-fill"></i>
                            <h4 class="select2-title">Tour Type</h4>
                        </div>
                        <select class="destination-dropdown">
                            <option value="1">Booking Type</option>
                            <option value="2">Advance Type</option>
                            <option value="3">Pre-book Type</option>
                        </select>
                    </div>
                    <div class="divider plan-divider d-none d-lg-block"></div>
                    <div class="dropdown-section">
                        <div class="d-flex gap-10 align-items-center">
                            <i class="ri-time-line"></i>
                            <div class="custom-dropdown custom-date">
                                <h4 class="title">Date From</h4>
                                <div class="arrow">
                                    <i class="ri-arrow-down-s-line"></i>
                                </div>
                            </div>
                        </div>
                        <div class="date-result">01/12/2023</div>
                    </div>
                    <div class="divider plan-divider d-none d-lg-block"></div>
                    <div class="dropdown-section position-relative user-picker-dropdown">
                        <div class="d-flex gap-10 align-items-center">
                            <i class="ri-user-line"></i>
                            <div class="custom-dropdown">
                                <h4 class="title">Guests</h4>
                                <div class="arrow">
                                    <i class="ri-arrow-down-s-line"></i>
                                </div>
                            </div>
                        </div>
                        <div class="user-result">02</div>
                        <div class="user-picker dropdown-shadow">
                            <div class="user-category">
                                <div class="category-name">
                                    <h4 class="title">Adults</h4>
                                    <p class="pera">12years and above</p>
                                </div>
                                <div class="qty-container">
                                    <button class="qty-btn-minus mr-1" type="button">
                                        <i class="ri-subtract-fill"></i>
                                    </button>
                                    <input type="text" name="qty" value="0" class="input-qty input-rounded">
                                    <button class="qty-btn-plus ml-1">
                                        <i class="ri-add-fill"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="user-category">
                                <div class="category-name">
                                    <h4 class="title">Children</h4>
                                    <p class="pera">2-11 years</p>
                                </div>
                                <div class="qty-container">
                                    <button class="qty-btn-minus mr-1" type="button">
                                        <i class="ri-subtract-fill"></i>
                                    </button>
                                    <input type="text" name="qty" value="0" class="input-qty input-rounded">
                                    <button class="qty-btn-plus ml-1">
                                        <i class="ri-add-fill"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="user-category">
                                <div class="category-name">
                                    <h4 class="title">infant</h4>
                                    <p class="pera">belwo 2 years</p>
                                </div>
                                <div class="qty-container">
                                    <button class="qty-btn-minus mr-1" type="button">
                                        <i class="ri-subtract-fill"></i>
                                    </button>
                                    <input type="text" name="qty" value="0" class="input-qty input-rounded">
                                    <button class="qty-btn-plus ml-1" type="button">
                                        <i class="ri-add-fill"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="btn-section">
                                <a href="javascript:void(0)" class="done-btn">Done</a>
                            </div>
                        </div>
                    </div>
                    <div class="sign-btn">
                        <a href="tour-list.html" class="btn-secondary-lg">Search Plan</a>
                    </div>
                </div>
            </div>
        </section> -->
        <!--/ End-of Plan-->

        <!-- Special area S t a r t -->
        <!-- <section class="special-area top-padding position-relative">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xl-7 col-lg-7">
                        <div class="section-title mx-430 mx-auto text-center">
                            <span class="highlights">special offers</span>
                            <h4 class="title">
                                Winter Our Big Offers to Inspire You
                            </h4>
                        </div>
                    </div>
                </div>
                <div class="row g-4">
                    <div class="col-lg-6 col-md-6">
                        <a href="tour-list.html" class="offer-banner imgEffect4 wow fadeInLeft" data-wow-delay="0.0s">
                            <img src="assets/images/gallery/offer-1.png" alt="travello">
                            <div class="offer-content">
                                <p class="highlights-text">Save up to</p>
                                <h4 class="title">50%</h4>
                                <p class="pera">Let’s Explore The World</p>
                                <div class="location">
                                    <i class="ri-map-pin-line"></i>
                                    <p class="name">Bangkok, Thailand</p>
                                </div>
                                <div class="btn-secondary-sm radius-30"> Booking Now </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <a href="tour-list.html" class="offer-banner imgEffect4 wow fadeInRight" data-wow-delay="0.0s">
                            <img src="assets/images/gallery/offer-2.png" alt="travello">
                            <div class="offer-content-two">
                                <h4 class="title">Nearby Hotel</h4>
                                <p class="pera">
                                    Up to <span class="highlights-text">50%</span> Off The Best
                                    Hotels Near
                                </p>
                                <div class="location">
                                    <i class="ri-map-pin-line"></i>
                                    <p class="name">Bangkok, Thailand</p>
                                </div>
                                <div class="btn-secondary-sm radius-30"> Booking Now </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <div class="shape-bg">
                <img src="assets/images/icon/bg-shape.png" alt="travello">
            </div>
        </section> -->
        <!--/ End-of special-->

        <!-- About Us area S t a r t -->
        <!-- <section class="about-area bottom-padding1 position-relative">
            <div class="container">
                <div class="row">
                    <div class="col-xl-8">
                        <div class="section-title mx-605 mb-30">
                            <span class="highlights">about us</span>
                            <h4 class="title">Experience The World With Our Company</h4>
                            <p class="pera">
                                Lorem ipsum dolor sit amet consectetur. Platea urna hendrerit
                                dui eget velit sollicitudin orci. Non sit lorem dolor placerat
                                faucibus. Ut tellus feugiat facilisi neque sagittis cursus
                                sagittis.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="row g-4">
                    <div class="col-xl-8 col-lg-7">
                        <div class="tab-content" id="v-pills-tabContent">
                            <div class="tab-pane fade show active" id="v-pills-one" role="tabpanel"
                                aria-labelledby="v-pills-one-tab">
                                <div class="about-banner imgEffect4">
                                    <img src="assets/images/gallery/about.png" alt="travello">
                                </div>
                            </div>
                            <div class="tab-pane fade" id="v-pills-two" role="tabpanel"
                                aria-labelledby="v-pills-two-tab">
                                <div class="about-banner imgEffect4">
                                    <img src="assets/images/gallery/about-banner-2.png" alt="travello">
                                </div>
                            </div>
                            <div class="tab-pane fade" id="v-pills-three" role="tabpanel"
                                aria-labelledby="v-pills-three-tab">
                                <div class="about-banner imgEffect4">
                                    <img src="assets/images/gallery/about-banner-3.png" alt="travello">
                                </div>
                            </div>
                            <div class="tab-pane fade" id="v-pills-four" role="tabpanel"
                                aria-labelledby="v-pills-four-tab">
                                <div class="about-banner imgEffect4">
                                    <img src="assets/images/gallery/about-banner-4.png" alt="travello">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-5">
                        <div class="key-points position-relative z-12" id="v-pills-tab" role="tablist"
                            aria-orientation="vertical">
                            <div class="key-point active" id="v-pills-one-tab" data-bs-toggle="pill"
                                data-bs-target="#v-pills-one" role="tab" aria-controls="v-pills-one"
                                aria-selected="true">
                                <div class="key-icon">
                                    <span>$</span>
                                </div>
                                <div class="key-content">
                                    <h4 class="title">Best Price Guarantee</h4>
                                    <p class="pera">
                                        A "Best Price Guarantee" is a commitment offered by
                                        businesses, typically in the retail or hospitality
                                    </p>
                                </div>
                            </div>
                            <div class="key-point" id="v-pills-two-tab" data-bs-toggle="pill"
                                data-bs-target="#v-pills-two" role="tab" aria-controls="v-pills-two"
                                aria-selected="false">
                                <div class="key-icon">
                                    <span>$</span>
                                </div>
                                <div class="key-content">
                                    <h4 class="title">Easy & Quick Booking</h4>
                                    <p class="pera">
                                        A "Best Price Guarantee" is a commitment offered by
                                        businesses, typically in the retail or hospitality
                                    </p>
                                </div>
                            </div>
                            <div class="key-point" id="v-pills-three-tab" data-bs-toggle="pill"
                                data-bs-target="#v-pills-three" role="tab" aria-controls="v-pills-three"
                                aria-selected="false">
                                <div class="key-icon">
                                    <span>$</span>
                                </div>
                                <div class="key-content">
                                    <h4 class="title">Tour Guide</h4>
                                    <p class="pera">
                                        A "Best Price Guarantee" is a commitment offered by
                                        businesses, typically in the retail or hospitality
                                    </p>
                                </div>
                            </div>
                            <div class="key-point" id="v-pills-four-tab" data-bs-toggle="pill"
                                data-bs-target="#v-pills-four" role="tab" aria-controls="v-pills-four"
                                aria-selected="false">
                                <div class="key-icon">
                                    <span>$</span>
                                </div>
                                <div class="key-content">
                                    <h4 class="title">World Class Travel</h4>
                                    <p class="pera">
                                        A "Best Price Guarantee" is a commitment offered by
                                        businesses, typically in the retail or hospitality
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="shape-bg-about">
                <img src="assets/images/icon/bg-shape-2.png" alt="travello">
            </div>
        </section> -->
        <!--/ End-of About US-->

        <!-- About Us area S t a r t -->
        <section class="about-area">
            <div class="container">
                <div class="row g-4">
                    <div class="col-xl-5 col-lg-6">
                        <div class="section-title mx-430 mb-30 w-md-100">
                            <span class="highlights fancy-font font-400">About Us</span>
                            <h3 class="title">
                                Get The Best Travel Experience With Bizzmirth Holidays
                            </h3>
                            <p class="pera">
                               Bizzmirth Holidays Pvt Ltd is a leading travel and holiday industry enabler, providing a comprehensive business platform for entrepreneurs
                               and businesses to succeed.
                            </p>
                            <p class="pera">
                            Our expertise lies in creating enterprise solutions, inventory systems, strategic planning, business structure, customer support, revenue
                               support systems, customer portfolio management, compliance management, legal business formats, technical support, business trainings and business
                               channel. Our cutting-edge technology and expert team ensure a seamless and profitable experience for our partners.
                            </p>
                            <div class="section-button mt-27 d-inline-block">
                                <a href="about.php" class="btn-primary-icon-sm radius-20">
                                    <p class="pera mt-0">Learn More</p>
                                    <i class="ri-arrow-right-up-line"></i>
                                </a>
                            </div>
                            <!-- <div class="about-imp-link mt-40">
                                <div class="icon">
                                    <i class="ri-user-line"></i>
                                </div>
                                <div class="content">
                                    <p class="pera font-16">
                                        <span class="font-700">2,500</span> People Booked Tomorrow
                                        Land Event in the Last 24 hours
                                    </p>
                                </div>
                            </div> -->
                        </div>
                    </div>
                    <div class="col-xl-7 col-lg-6">
                        <div class="about-count-section about-count-before-bg">
                            <div class="banner">
                                <img src="assets/images/gallery/about-banner-three.png" alt="travello">
                            </div>
                            <div class="all-count-list">
                                <div class="details">
                                    <h4 class="count">3,000+</h4>
                                    <p class="pera">Happy Traveler</p>
                                </div>
                                <div class="divider"></div>
                                <div class="details">
                                    <h4 class="count">95.7%</h4>
                                    <p class="pera">Satisfaction Rate</p>
                                </div>
                                <div class="divider"></div>
                                <div class="details">
                                    <h4 class="count">500+</h4>
                                    <p class="pera">Tour Completed</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--/ End-of About US-->

        <!-- Destination area S t a r t -->
        <!--<section class="destination-area destination-bg-before">
             <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xl-7 col-lg-7">
                        <div class="section-title text-center mx-430 mx-auto position-relative">
                            <span class="highlights">Destination List</span>
                            <h4 class="title">
                                Explore The Beautiful Places Around World
                            </h4>
                        </div>
                    </div>
                </div>
                <div class="row g-4">
                    <div class="col-xl-7 col-lg-7 col-md-7">
                        <a href="destination-details.php" class="destination-banner">
                            <img src="assets/images/destination/destination-1.png" alt="travello">
                            <div class="destination-content">
                                <div class="ratting-badge">
                                    <i class="ri-star-s-fill"></i>
                                    <span>4.5</span>
                                </div>
                                <div class="destination-info">
                                    <div class="destination-name">
                                        <p class="pera">Spain</p>
                                        <div class="location">
                                            <i class="ri-map-pin-line"></i>
                                            <p class="name">Malaga View</p>
                                        </div>
                                    </div>
                                    <div class="button-section">
                                        <div class="arrow-btn">
                                            <i  class="ri-arrow-right-line"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-xl-5 col-lg-5 col-md-5">
                        <a href="destination-details.php" class="destination-banner">
                            <img src="assets/images/destination/destination-2.png" alt="travello">
                            <div class="destination-content">
                                <div class="ratting-badge">
                                    <i class="ri-star-s-fill"></i>
                                    <span>4.5</span>
                                </div>
                                <div class="destination-info">
                                    <div class="destination-name">
                                        <p class="pera">New Zealand</p>
                                        <div class="location">
                                            <i class="ri-map-pin-line"></i>
                                            <p class="name">Auckland View</p>
                                        </div>
                                    </div>
                                    <div class="button-section">
                                        <div class="arrow-btn">
                                            <i  class="ri-arrow-right-line"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="destination-gallery">
                        <div class="row g-4">
                            <div class="col-lg-4 col-md-6 col-sm-6">
                                <a href="destination-details.php" class="destination-banner">
                                    <img src="assets/images/destination/destination-3.png" alt="travello">
                                    <div class="destination-content">
                                        <div class="ratting-badge">
                                            <i class="ri-star-s-fill"></i>
                                            <span>4.5</span>
                                        </div>
                                        <div class="destination-info">
                                            <div class="destination-name">
                                                <p class="pera">Switzerland</p>
                                                <div class="location">
                                                    <i class="ri-map-pin-line"></i>
                                                    <p class="name">Zürich View</p>
                                                </div>
                                            </div>
                                            <div class="button-section">
                                                <div class="arrow-btn">
                                                    <i  class="ri-arrow-right-line"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-lg-4 col-md-6 col-sm-6">
                                <a href="destination-details.php" class="destination-banner">
                                    <img src="assets/images/destination/destination-4.png" alt="travello">
                                    <div class="destination-content">
                                        <div class="ratting-badge">
                                            <i class="ri-star-s-fill"></i>
                                            <span>4.5</span>
                                        </div>
                                        <div class="destination-info">
                                            <div class="destination-name">
                                                <p class="pera">Australia</p>
                                                <div class="location">
                                                    <i class="ri-map-pin-line"></i>
                                                    <p class="name">Melbourne View</p>
                                                </div>
                                            </div>
                                            <div class="button-section">
                                                <div class="arrow-btn">
                                                    <i  class="ri-arrow-right-line"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-lg-4 col-md-6 col-sm-6">
                                <a href="destination-details.php" class="destination-banner">
                                        <img src="assets/images/destination/destination-5.png" alt="travello">
                                    <div class="destination-content">
                                        <div class="ratting-badge">
                                            <i class="ri-star-s-fill"></i>
                                            <span>4.5</span>
                                        </div>
                                        <div class="destination-info">
                                            <div class="destination-name">
                                                <p class="pera">Canada</p>
                                                <div class="location">
                                                    <i class="ri-map-pin-line"></i>
                                                    <p class="name">Toronto View</p>
                                                </div>
                                            </div>
                                            <div class="button-section">
                                                <div class="arrow-btn">
                                                    <i  class="ri-arrow-right-line"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div> 
            <div class="shape">
                <img src="assets/images/icon/shape.png" alt="travello">
            </div>
        </section>-->
        <!--/ End-of Destination -->

        <!-- Brand S t a r t -->
        <!-- <section class="brand-area">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="border-section-title">
                            <h4 class="title">We’ve been mentioned in Below Brands</h4>
                        </div>
                        <div class="swiper brandSwiper-active">
                            <div class="swiper-wrapper">
                                <div class="swiper-slide">
                                    <img src="assets/images/brand/brand-1.jpeg" alt="travello">
                                </div>
                                <div class="swiper-slide">
                                    <img src="assets/images/brand/brand-2.jpg" alt="travello">
                                </div>
                                <div class="swiper-slide">
                                    <img src="assets/images/brand/brand-3.jpg" alt="travello">
                                </div>
                                <div class="swiper-slide">
                                    <img src="assets/images/brand/brand-4.png" alt="travello">
                                </div>
                                <div class="swiper-slide">
                                    <img src="assets/images/brand/brand-5.png" alt="travello">
                                </div>
                                <div class="swiper-slide">
                                    <img src="assets/images/brand/brand-1.jpeg" alt="travello">
                                </div>
                                <div class="swiper-slide">
                                    <img src="assets/images/brand/brand-2.jpg" alt="travello">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section> -->
        <!--/ End of Brand -->

        <!-- Packages S t a r t -->
        <section class="package-area section-padding2">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xl-7 col-lg-7">
                        <div class="section-title mx-430 mx-auto text-center">
                            <span class="highlights">Popular Packages</span>
                            <h4 class="title">
                                Explore The Beautiful Places Around World
                            </h4>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <!-- Tab Buttons -->
                        <!-- <ul class="nav nav-pills package-pills" id="pills-tab" role="tablist">
                            <li class="nav-item package-item" role="presentation">
                                <button class="nav-link package-nav active" id="pills-london-tab" data-bs-toggle="pill"
                                    data-bs-target="#pills-london" role="tab" aria-controls="pills-london" aria-selected="true">
                                    London
                                </button>
                            </li>
                            <li class="nav-item package-item" role="presentation">
                                <button class="nav-link package-nav" id="pills-bangkok-tab" data-bs-toggle="pill"
                                    data-bs-target="#pills-bangkok" role="tab" aria-controls="pills-bangkok"
                                    aria-selected="false">
                                    Bangkok
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link package-nav" id="pills-hongkong-tab" data-bs-toggle="pill"
                                    data-bs-target="#pills-hongkong" role="tab" aria-controls="pills-hongkong"
                                    aria-selected="false">
                                    Hong Kong
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link package-nav" id="pills-manchester-tab" data-bs-toggle="pill"
                                    data-bs-target="#pills-manchester" role="tab" aria-controls="pills-manchester"
                                    aria-selected="false">
                                    Manchester
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link package-nav" id="pills-dubai-tab" data-bs-toggle="pill"
                                    data-bs-target="#pills-dubai" role="tab" aria-controls="pills-dubai" aria-selected="false">
                                    Dubai
                                </button>
                            </li>
                        </ul> -->
                        <!-- Tab contents -->
                        <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane fade show active" id="pills-london" role="tabpanel"
                                aria-labelledby="pills-london-tab">
                                <div class="row g-4">
                                    <?php 

                                        require 'connect.php';

                                        // $user_id = 0;
                                        $ta_id = 0;
                                        // get TA id
                                        if ( $user_id ) {
                                            if (  $user_type == '2' ) {
                                                $ta_data = $conn->prepare("SELECT * FROM customer WHERE cust_id = '".$user_id."' " );
                                                $ta_data->execute();
                                                $ta = $ta_data->fetch();
                                                $ta_id = $ta['ta_reference'];
                                            } else if (  $user_type == '3' ) {
                                                $ta_id = $user_id;
                                            }
                                        }

                                        $stmt = $conn->prepare(" SELECT p.id, p.description, p.description, p.destination, p.location, name, t.net_price_adult_with_GST, t.markup_total FROM package p, package_pricing t, category c WHERE p.id = t.package_id AND p.category_id = c.id AND p.status = '1' ORDER BY p.id DESC LIMIT 4 ");
                                        $stmt->execute();
                                        $stmt->SetFetchMode(PDO::FETCH_ASSOC);
                                        if($stmt->rowCount()>0){
                                            foreach (($stmt->fetchAll()) as $key => $row) {
                                                // $name = $row['name'].''.$row['unique_code'];
                                                // echo $srno.' '.$name.'</br>';

                                                // get images
                                                $data = $conn->prepare("SELECT * FROM package_pictures WHERE package_id = '".$row['id']."' LIMIT 1" );
                                                $data->execute();
                                                $value = $data->fetch();
                                                // echo $value['image'].'-id-'.$value['id'].'-package_id-'.$value['package_id'];

                                                $adult_price = (int)$row['net_price_adult_with_GST'];
                                                $markup_price = (int)$row['markup_total'];
                                                $total_base_price = $adult_price + $markup_price;

                                                if ( $ta_id ) {
                                                    $ta_markup_data = $conn->prepare("SELECT * FROM package_markup_travelagent WHERE travelagent_id = '".$ta_id."' AND package_id = '".$row['id']."' AND status='1' LIMIT 1" );
                                                    $ta_markup_data->execute();
                                                    $ta_markup = $ta_markup_data->fetch();

                                                    $total_price = $ta_markup['selling_price'] ?? $total_base_price;
                                                } else {
                                                    $total_price = $total_base_price;
                                                }

                                                echo'
                                                    <div class="col-xl-3 col-lg-4 col-sm-6">
                                                        <div class="package-card">
                                                            <div class="package-img imgEffect4">
                                                                <a href="#" onclick=\'viewPackage("' .$row['id']. '")\'>
                                                                    <img src="'.$value['image'].'" alt="BizzMirth">
                                                                </a>
                                                            </div>
                                                            <div class="package-content">
                                                                <h4 class="area-name">
                                                                    <a href="#" onclick=\'viewPackage("' .$row['id']. '")\'>'.$row['name'].'</a>
                                                                </h4>
                                                                <div class="location">
                                                                    <i class="ri-map-pin-line"></i>
                                                                    <div class="name">'.$row['destination'].'</div>
                                                                </div>
                                                                <div class="packages-person">
                                                                    <div class="count">
                                                                        <i class="ri-time-line"></i>
                                                                        <p class="pera">'.$row['location'].'</p>
                                                                    </div>
                                                                </div>
                                                                <div class="price-review">
                                                                    <div class="d-flex gap-10">
                                                                        <p class="light-pera">From</p>
                                                                        <p class="pera"><span>&#8377</span>'.$total_price.'</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                ';
                                            }
                                        }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 text-center">
                        <div class="section-button d-inline-block">
                            <a href="tour-list.php">
                                <div class="btn-primary-icon-sm">
                                    <p class="pera">View All Tour</p>
                                    <i class="ri-arrow-right-up-line"></i>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--/ End of Packages -->

        <!-- Start of Get Quotation -->
        <section class="contact margin-nege">
            <div class="container">
                <div class="row d-flex justify-content-center">
                    <div class="col-md-8">
                        <div id="contact-form" class="contact-card section-layout">
                            <div class="section-header fw-bolder"><h2>Get Quotation</h2></div>
                            <div id="contactform-error-msg"></div>
                            <form>
                                <div class="row">
                                    <label class="q_label" for="q_name">Name <span class="text-danger">*</span></label>
                                    <div class="input-box col-sm-12">
                                        <input type="text" class="form-control border-0 fs-6 bg-transparent w-100" name="q_name" id="q_name" placeholder="Full Name" value="">
                                    </div>
                                    <label class="q_label" for="q_phn_no">Mobile <span class="text-danger">*</span></label>
                                    <div class="input-box col-sm-12 ">
                                        <input type="tel" class="form-control border-0 fs-6 bg-transparent w-100" name="q_phn_no" id="q_phn_no" placeholder="Phone Number" value="">
                                    </div>
                                    <label class="q_label" for="q_email">Email <span class="text-danger">*</span></label>
                                    <div class="input-box col-sm-12">
                                        <input type="email" class="form-control border-0 fs-6 bg-transparent w-100" name="q_email" id="q_email" placeholder="Email" value="">
                                    </div>
                                    <label class="q_label" for="q_duration">Trip Duration <span class="text-danger">*</span></label>
                                    <div class="input-box col-sm-12">
                                        <input type="number" class="form-control border-0 fs-6 bg-transparent w-100" name="q_duration" id="q_duration" placeholder="Trip Duration" value="">
                                    </div>
                                    <label class="q_label" for="q_date">Travel Date <span class="text-danger">*</span></label>
                                    <div class="input-box col-sm-12">
                                        <input type="date" class="form-control border-0 fs-6 bg-transparent w-100" name="q_date" id="q_date" value="">
                                    </div>
 
                                    <div class="form-group col-sm-12 px-0">
                                        <div class="row">
                                            <div class="form-group col-sm-4 col-6">
                                                <label class="q_label ps-3" for="q_no_adult">Adults<span class="text-danger">*</span></label>
                                                <div class="input-box p-2 mb-1">
                                                    <input type="number" class="form-control border-0 fs-6 bg-transparent w-100" name="q_no_adult" id="q_no_adult" value="1" placeholder="Adults" min="1">
                                                </div>
                                                <span class="label_txt ps-3 fontSize"> (12+ Yrs) </span>
                                            </div>
                                            <div class="form-group col-sm-4 col-6">
                                                <label class="q_label ps-3" for="q_no_child">Children </label>
                                                <div class="input-box p-2 mb-1">
                                                    <input type="number" class="form-control border-0 fs-6 bg-transparent w-100" name="q_no_child" id="q_no_child" value="0" placeholder="Children" min="0">
                                                </div>
                                                <span class="label_txt ps-3 fontSize"> (3-11 Yrs) </span>
                                            </div>
                                            <div class="form-group col-sm-4 col-6">
                                                <label class="q_label ps-3"
                                                    for="q_no_infants">Infants </label>
                                                <div class="input-box p-2 mb-1">
                                                    <input type="number" class="form-control border-0 fs-6 bg-transparent w-100" name="q_no_infants" id="q_no_infants" min="0" value="0">
                                                </div>
                                                <span class="label_txt ps-3 fontSize"> (Under 2 Yrs)</span>
                                            </div>
                                        </div>
                                    </div>
                                    <label class="q_label" for="q_budget">Approx. Budget (&#8377;) <span class="text-danger">*</span></label>
                                    <div class="input-box col-sm-12">
                                        <input type="text" class="form-control border-0 fs-6 bg-transparent w-100" name="q_budget" id="q_budget" placeholder="Approx Budget" value="">
                                    </div>
                                    <label class="q_label" for="q_meals">Meals Required <span class="text-danger">*</span></label>
                                    <div class="input-box col-sm-12 d-flex justify-content-around">
                                        <div class="form-check form-check-inline fs-6 me-0">
                                            <input class="form-check-input meal-checkbox" type="checkbox" id="inlineCheckbox1" value="breakfast">
                                            <label class="form-check-label" for="inlineCheckbox1">Breakfast</label>
                                        </div>
                                        <div class="form-check form-check-inline fs-6 me-0">
                                            <input class="form-check-input meal-checkbox" type="checkbox" id="inlineCheckbox2" value="lunch">
                                            <label class="form-check-label" for="inlineCheckbox2">Lunch</label>
                                        </div>
                                        <div class="form-check form-check-inline fs-6 me-0">
                                            <input class="form-check-input meal-checkbox" type="checkbox" id="inlineCheckbox3" value="dinner">
                                            <label class="form-check-label" for="inlineCheckbox3">Dinner</label>
                                        </div>
                                    </div>
                                    <label class="q_label" for="q_comment">Additional Remarks(If Any)</label>
                                    <div class="form-floating px-0">
                                        <textarea class="form-control" placeholder="Leave a comment here" id="floatingTextarea2" style="height: 100px"></textarea>
                                        <!-- <label for="floatingTextarea2">Comments</label> -->
                                    </div>
                                    <input type="hidden" value="<?= $userId ?>" id="q_user_id">
                                    <div class="mt-3 px-0">
                                        <button type="button" class="send-button w-100 d-flex justify-content-center" id="submit_quotations" class="text-white">
                                            Submit
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- End of Get Quotation -->

        <!-- Testimonial S t a r t -->
        <!-- <section class="testimonial-area bottom-padding">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xl-7 col-lg-7">
                        <div class="section-title mx-430 mx-auto text-center">
                            <span class="highlights">Testimonial</span>
                            <h4 class="title">
                                What People Have Said About Our Service
                            </h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="d-flex flex-wrap gap-24">
                <div class="swiper bulletLeftSwiper-active">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide testimonial-card">
                            <div class="testimonial-header">
                                <div class="user-img">
                                    <img src="assets/images/testimonial/testimonial-1.jpeg" alt="travello">
                                </div>
                                <div class="user-info">
                                    <p class="name">David Malan</p>
                                    <p class="designation">Traveler</p>
                                </div>
                            </div>
                            <div class="testimonial-body">
                                <p class="pera">
                                    Lorem ipsum dolor sit amet consectetur. Et amet nulla in
                                    adipiscing. Donec tincidunt dui vel adipiscing sit turpis
                                    neque at cursus. Dignissim scelerisque mattis ultricies
                                    vitae.
                                </p>
                            </div>
                            <div class="testimonial-footer">
                                <div class="logo">
                                    <img src="assets/images/logo/logo.png" alt="travello" class="changeLogo">
                                </div>
                                <p class="date">Jan 20, 2025</p>
                            </div>
                        </div>
                        <div class="swiper-slide testimonial-card">
                            <div class="testimonial-header">
                                <div class="user-img">
                                    <img src="assets/images/testimonial/testimonial-1.jpeg" alt="travello">
                                </div>
                                <div class="user-info">
                                    <p class="name">David Malan</p>
                                    <p class="designation">Traveler</p>
                                </div>
                            </div>
                            <div class="testimonial-body">
                                <p class="pera">
                                    Lorem ipsum dolor sit amet consectetur. Et amet nulla in
                                    adipiscing. Donec tincidunt dui vel adipiscing sit turpis
                                    neque at cursus. Dignissim scelerisque mattis ultricies
                                    vitae.
                                </p>
                            </div>
                            <div class="testimonial-footer">
                                <div class="logo">
                                    <img src="assets/images/logo/logo.png" alt="travello" class="changeLogo">
                                </div>
                                <p class="date">Jan 20, 2025</p>
                            </div>
                        </div>
                        <div class="swiper-slide testimonial-card">
                            <div class="testimonial-header">
                                <div class="user-img">
                                    <img src="assets/images/testimonial/testimonial-1.jpeg" alt="travello">
                                </div>
                                <div class="user-info">
                                    <p class="name">David Malan</p>
                                    <p class="designation">Traveler</p>
                                </div>
                            </div>
                            <div class="testimonial-body">
                                <p class="pera">
                                    Lorem ipsum dolor sit amet consectetur. Et amet nulla in
                                    adipiscing. Donec tincidunt dui vel adipiscing sit turpis
                                    neque at cursus. Dignissim scelerisque mattis ultricies
                                    vitae.
                                </p>
                            </div>
                            <div class="testimonial-footer">
                                <div class="logo">
                                    <img src="assets/images/logo/logo.png" alt="travello" class="changeLogo">
                                </div>
                                <p class="date">Jan 20, 2025</p>
                            </div>
                        </div>
                        <div class="swiper-slide testimonial-card">
                            <div class="testimonial-header">
                                <div class="user-img">
                                    <img src="assets/images/testimonial/testimonial-1.jpeg" alt="travello">
                                </div>
                                <div class="user-info">
                                    <p class="name">David Malan</p>
                                    <p class="designation">Traveler</p>
                                </div>
                            </div>
                            <div class="testimonial-body">
                                <p class="pera">
                                    Lorem ipsum dolor sit amet consectetur. Et amet nulla in
                                    adipiscing. Donec tincidunt dui vel adipiscing sit turpis
                                    neque at cursus. Dignissim scelerisque mattis ultricies
                                    vitae.
                                </p>
                            </div>
                            <div class="testimonial-footer">
                                <div class="logo">
                                    <img src="assets/images/logo/logo.png" alt="travello" class="changeLogo">
                                </div>
                                <p class="date">Jan 20, 2025</p>
                            </div>
                        </div>
                        <div class="swiper-slide testimonial-card">
                            <div class="testimonial-header">
                                <div class="user-img">
                                    <img src="assets/images/testimonial/testimonial-1.jpeg" alt="travello">
                                </div>
                                <div class="user-info">
                                    <p class="name">David Malan</p>
                                    <p class="designation">Traveler</p>
                                </div>
                            </div>
                            <div class="testimonial-body">
                                <p class="pera">
                                    Lorem ipsum dolor sit amet consectetur. Et amet nulla in
                                    adipiscing. Donec tincidunt dui vel adipiscing sit turpis
                                    neque at cursus. Dignissim scelerisque mattis ultricies
                                    vitae.
                                </p>
                            </div>
                            <div class="testimonial-footer">
                                <div class="logo">
                                    <img src="assets/images/logo/logo.png" alt="travello" class="changeLogo">
                                </div>
                                <p class="date">Jan 20, 2025</p>
                            </div>
                        </div>
                        <div class="swiper-slide testimonial-card">
                            <div class="testimonial-header">
                                <div class="user-img">
                                    <img src="assets/images/testimonial/testimonial-1.jpeg" alt="travello">
                                </div>
                                <div class="user-info">
                                    <p class="name">David Malan</p>
                                    <p class="designation">Traveler</p>
                                </div>
                            </div>
                            <div class="testimonial-body">
                                <p class="pera">
                                    Lorem ipsum dolor sit amet consectetur. Et amet nulla in
                                    adipiscing. Donec tincidunt dui vel adipiscing sit turpis
                                    neque at cursus. Dignissim scelerisque mattis ultricies
                                    vitae.
                                </p>
                            </div>
                            <div class="testimonial-footer">
                                <div class="logo">
                                    <img src="assets/images/logo/logo.png" alt="travello" class="changeLogo">
                                </div>
                                <p class="date">Jan 20, 2025</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="swiper bulletRightSwiper-active">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide testimonial-card">
                            <div class="testimonial-header">
                                <div class="user-img">
                                    <img src="assets/images/testimonial/testimonial-1.jpeg" alt="travello">
                                </div>
                                <div class="user-info">
                                    <p class="name">David Malan</p>
                                    <p class="designation">Traveler</p>
                                </div>
                            </div>
                            <div class="testimonial-body">
                                <p class="pera">
                                    Lorem ipsum dolor sit amet consectetur. Et amet nulla in
                                    adipiscing. Donec tincidunt dui vel adipiscing sit turpis
                                    neque at cursus. Dignissim scelerisque mattis ultricies
                                    vitae.
                                </p>
                            </div>
                            <div class="testimonial-footer">
                                <div class="logo">
                                    <img src="assets/images/logo/logo.png" alt="travello" class="changeLogo">
                                </div>
                                <p class="date">Jan 20, 2025</p>
                            </div>
                        </div>
                        <div class="swiper-slide testimonial-card">
                            <div class="testimonial-header">
                                <div class="user-img">
                                    <img src="assets/images/testimonial/testimonial-1.jpeg" alt="travello">
                                </div>
                                <div class="user-info">
                                    <p class="name">David Malan</p>
                                    <p class="designation">Traveler</p>
                                </div>
                            </div>
                            <div class="testimonial-body">
                                <p class="pera">
                                    Lorem ipsum dolor sit amet consectetur. Et amet nulla in
                                    adipiscing. Donec tincidunt dui vel adipiscing sit turpis
                                    neque at cursus. Dignissim scelerisque mattis ultricies
                                    vitae.
                                </p>
                            </div>
                            <div class="testimonial-footer">
                                <div class="logo">
                                    <img src="assets/images/logo/logo.png" alt="travello" class="changeLogo">
                                </div>
                                <p class="date">Jan 20, 2025</p>
                            </div>
                        </div>
                        <div class="swiper-slide testimonial-card">
                            <div class="testimonial-header">
                                <div class="user-img">
                                    <img src="assets/images/testimonial/testimonial-1.jpeg" alt="travello">
                                </div>
                                <div class="user-info">
                                    <p class="name">David Malan</p>
                                    <p class="designation">Traveler</p>
                                </div>
                            </div>
                            <div class="testimonial-body">
                                <p class="pera">
                                    Lorem ipsum dolor sit amet consectetur. Et amet nulla in
                                    adipiscing. Donec tincidunt dui vel adipiscing sit turpis
                                    neque at cursus. Dignissim scelerisque mattis ultricies
                                    vitae.
                                </p>
                            </div>
                            <div class="testimonial-footer">
                                <div class="logo">
                                    <img src="assets/images/logo/logo.png" alt="travello" class="changeLogo">
                                </div>
                                <p class="date">Jan 20, 2025</p>
                            </div>
                        </div>
                        <div class="swiper-slide testimonial-card">
                            <div class="testimonial-header">
                                <div class="user-img">
                                    <img src="assets/images/testimonial/testimonial-1.jpeg" alt="travello">
                                </div>
                                <div class="user-info">
                                    <p class="name">David Malan</p>
                                    <p class="designation">Traveler</p>
                                </div>
                            </div>
                            <div class="testimonial-body">
                                <p class="pera">
                                    Lorem ipsum dolor sit amet consectetur. Et amet nulla in
                                    adipiscing. Donec tincidunt dui vel adipiscing sit turpis
                                    neque at cursus. Dignissim scelerisque mattis ultricies
                                    vitae.
                                </p>
                            </div>
                            <div class="testimonial-footer">
                                <div class="logo">
                                    <img src="assets/images/logo/logo.png" alt="travello" class="changeLogo">
                                </div>
                                <p class="date">Jan 20, 2025</p>
                            </div>
                        </div>
                        <div class="swiper-slide testimonial-card">
                            <div class="testimonial-header">
                                <div class="user-img">
                                    <img src="assets/images/testimonial/testimonial-1.jpeg" alt="travello">
                                </div>
                                <div class="user-info">
                                    <p class="name">David Malan</p>
                                    <p class="designation">Traveler</p>
                                </div>
                            </div>
                            <div class="testimonial-body">
                                <p class="pera">
                                    Lorem ipsum dolor sit amet consectetur. Et amet nulla in
                                    adipiscing. Donec tincidunt dui vel adipiscing sit turpis
                                    neque at cursus. Dignissim scelerisque mattis ultricies
                                    vitae.
                                </p>
                            </div>
                            <div class="testimonial-footer">
                                <div class="logo">
                                    <img src="assets/images/logo/logo.png" alt="travello" class="changeLogo">
                                </div>
                                <p class="date">Jan 20, 2025</p>
                            </div>
                        </div>
                        <div class="swiper-slide testimonial-card">
                            <div class="testimonial-header">
                                <div class="user-img">
                                    <img src="assets/images/testimonial/testimonial-1.jpeg" alt="travello">
                                </div>
                                <div class="user-info">
                                    <p class="name">David Malan</p>
                                    <p class="designation">Traveler</p>
                                </div>
                            </div>
                            <div class="testimonial-body">
                                <p class="pera">
                                    Lorem ipsum dolor sit amet consectetur. Et amet nulla in
                                    adipiscing. Donec tincidunt dui vel adipiscing sit turpis
                                    neque at cursus. Dignissim scelerisque mattis ultricies
                                    vitae.
                                </p>
                            </div>
                            <div class="testimonial-footer">
                                <div class="logo">
                                    <img src="assets/images/logo/logo.png" alt="travello" class="changeLogo">
                                </div>
                                <p class="date">Jan 20, 2025</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-12 text-center">
                        <div class="section-button d-inline-block">
                            <a href="javascript:void(0)">
                                <div class="btn-primary-icon-sm">
                                    <p class="pera">All Customers Say</p>
                                    <i class="ri-arrow-right-up-line"></i>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section> -->
        <!--/ End of Testimonial -->

        <!-- Pricing S t a r t -->
        <!-- <section class="pricing-area bottom-padding section-bg-before-two">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xl-7 col-lg-7">
                        <div class="section-title text-center mx-605 mx-auto position-relative">
                            <span class="highlights-primary">Package Pricing Plan</span>
                            <h4 class=" title">
                                Simply Choose The Pricing Plan That Fits You Best
                            </h4>
                        </div>
                    </div>
                </div>
                <div class="position-relative">
                    <div class="row g-4">
                        <div class="col-xl-4 col-lg-6 col-md-6">
                            <div class="price-card h-calc wow fadeInUp" data-wow-delay="0.0s">
                                <div class="price-header">
                                    <div class="d-flex gap-7 mb-2">
                                        <h4 class="title">Basic</h4>
                                        <div class="price-badge d-none">popular</div>
                                    </div>
                                    <p class="pera">Best for personal and basic needs</p>
                                </div>
                                <div class="price-tag-section">
                                    <div class="price-tag">
                                        <h4 class="title">$10</h4>
                                        <p class="pera">One-time payment</p>
                                    </div>
                                </div>
                                <ul class="feature-points">
                                    <li class="feature-point">
                                        <div class="tick-icon">
                                            <i class="ri-check-line"></i>
                                        </div>
                                        <p class="pera">20+ Partners</p>
                                    </li>
                                    <li class="feature-point">
                                        <div class="tick-icon">
                                            <i class="ri-check-line"></i>
                                        </div>
                                        <p class="pera">Mass Messaging</p>
                                    </li>
                                    <li class="feature-point">
                                        <div class="tick-icon">
                                            <i class="ri-check-line"></i>
                                        </div>
                                        <p class="pera">Lorem ipsum dolor sit amet</p>
                                    </li>
                                    <li class="feature-point disable">
                                        <div class="tick-icon">
                                            <i class="ri-check-line"></i>
                                        </div>
                                        <p class="pera">Lorem ipsum dolor</p>
                                    </li>
                                    <li class="feature-point disable">
                                        <div class="tick-icon">
                                            <i class="ri-check-line"></i>
                                        </div>
                                        <p class="pera">Online booking engine</p>
                                    </li>
                                    <li class="feature-point disable">
                                        <div class="tick-icon">
                                            <i class="ri-check-line"></i>
                                        </div>
                                        <p class="pera">Business Card Scanner</p>
                                    </li>
                                </ul>
                                <div class="button-section">
                                    <a href="payment.html">
                                        <div class="btn-primary-icon-outline">
                                            <span class="pera">Try Now</span>
                                            <i class="ri-arrow-right-up-line"></i>
                                        </div>
                                    </a>
                                </div>
                                <div class="imp-note">
                                    <p class="pera">Per month +2% per online Booking</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-6 col-md-6">
                            <div class="price-card h-calc wow fadeInUp" data-wow-delay="0.1s">
                                <div class="price-header">
                                    <div class="d-flex gap-7 mb-2">
                                        <h4 class="title">Pro</h4>
                                        <div class="price-badge">popular</div>
                                    </div>
                                    <p class="pera">Best for personal and basic needs</p>
                                </div>
                                <div class="price-tag-section">
                                    <div class="price-tag">
                                        <h4 class="title">$77</h4>
                                        <p class="pera">One-time payment</p>
                                    </div>
                                </div>
                                <ul class="feature-points">
                                    <li class="feature-point">
                                        <div class="tick-icon">
                                            <i class="ri-check-line"></i>
                                        </div>
                                        <p class="pera">20+ Partners</p>
                                    </li>
                                    <li class="feature-point">
                                        <div class="tick-icon">
                                            <i class="ri-check-line"></i>
                                        </div>
                                        <p class="pera">Mass Messaging</p>
                                    </li>
                                    <li class="feature-point">
                                        <div class="tick-icon">
                                            <i class="ri-check-line"></i>
                                        </div>
                                        <p class="pera">Lorem ipsum dolor sit amet</p>
                                    </li>
                                    <li class="feature-point">
                                        <div class="tick-icon">
                                            <i class="ri-check-line"></i>
                                        </div>
                                        <p class="pera">Lorem ipsum dolor</p>
                                    </li>
                                    <li class="feature-point">
                                        <div class="tick-icon">
                                            <i class="ri-check-line"></i>
                                        </div>
                                        <p class="pera">Online booking engine</p>
                                    </li>
                                    <li class="feature-point disable">
                                        <div class="tick-icon">
                                            <i class="ri-check-line"></i>
                                        </div>
                                        <p class="pera">Business Card Scanner</p>
                                    </li>
                                </ul>
                                <div class="button-section">
                                    <a href="payment.html">
                                        <div class="btn-primary-icon-outline">
                                            <span class="pera">Try Now</span>
                                            <i class="ri-arrow-right-up-line"></i>
                                        </div>
                                    </a>
                                </div>
                                <div class="imp-note">
                                    <p class="pera">Per month +1.9% per online Booking</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-6 col-md-6">
                            <div class="price-card h-calc wow fadeInUp" data-wow-delay="0.2s">
                                <div class="price-header">
                                    <div class="d-flex gap-7 mb-2">
                                        <h4 class="title">Custom</h4>
                                        <div class="price-badge d-none">popular</div>
                                    </div>
                                    <p class="pera">Best for personal and basic needs</p>
                                </div>
                                <ul class="feature-points">
                                    <li class="feature-point">
                                        <div class="tick-icon">
                                            <i class="ri-check-line"></i>
                                        </div>
                                        <p class="pera">Mass Messaging</p>
                                    </li>
                                    <li class="feature-point">
                                        <div class="tick-icon">
                                            <i class="ri-check-line"></i>
                                        </div>
                                        <p class="pera">Lorem ipsum dolor sit amet</p>
                                    </li>
                                    <li class="feature-point">
                                        <div class="tick-icon">
                                            <i class="ri-check-line"></i>
                                        </div>
                                        <p class="pera">Unlimited Everything</p>
                                    </li>
                                    <li class="feature-point">
                                        <div class="tick-icon">
                                            <i class="ri-check-line"></i>
                                        </div>
                                        <p class="pera">Lorem ipsum dolor</p>
                                    </li>
                                    <li class="feature-point">
                                        <div class="tick-icon">
                                            <i class="ri-check-line"></i>
                                        </div>
                                        <p class="pera">Lorem ipsum dolor</p>
                                    </li>
                                    <li class="feature-point">
                                        <div class="tick-icon">
                                            <i class="ri-check-line"></i>
                                        </div>
                                        <p class="pera">Lorem ipsum dolor</p>
                                    </li>
                                    <li class="feature-point">
                                        <div class="tick-icon">
                                            <i class="ri-check-line"></i>
                                        </div>
                                        <p class="pera">Online booking engine</p>
                                    </li>
                                    <li class="feature-point">
                                        <div class="tick-icon">
                                            <i class="ri-check-line"></i>
                                        </div>
                                        <p class="pera">Business Card Scanner</p>
                                    </li>
                                </ul>
                                <div class="button-section">
                                    <a href="payment.html">
                                        <div class="btn-primary-icon-outline">
                                            <span class="pera">Contact</span>
                                            <i class="ri-arrow-right-up-line"></i>
                                        </div>
                                    </a>
                                </div>
                                <div class="imp-note">
                                    <p class="pera">Please contact anytime</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section> -->
        <!--/ End of Pricing -->

        <!-- News S t a r t -->
        <!-- <section class="news-area bottom-padding position-relative">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xl-7 col-lg-7">
                        <div class="section-title text-center mx-605 mx-auto position-relative mb-60">
                            <span class="highlights">News & Article</span>
                            <h4 class="title">
                                Latest News & Articles From The Blog Posts
                            </h4>
                        </div>
                    </div>
                </div>
                <div class="row g-4">
                    <div class="col-xl-7 col-lg-7">
                        <div class="tab-content" id="v-pills-tabContent-two">
                            <div class="tab-pane fade show active" id="pills-news-one" role="tabpanel"
                                aria-labelledby="pills-news-one">
                                <div class="about-banner imgEffect4">
                                    <img src="assets/images/news/news-banner.png" alt="travello">
                                </div>
                            </div>
                            <div class="tab-pane fade" id="pills-news-two" role="tabpanel"
                                aria-labelledby="pills-news-two">
                                <div class="about-banner imgEffect4">
                                    <img src="assets/images/news/banner-1.png" alt="travello">
                                </div>
                            </div>
                            <div class="tab-pane fade" id="pills-news-three" role="tabpanel"
                                aria-labelledby="pills-news-three">
                                <div class="about-banner imgEffect4">
                                    <img src="assets/images/news/banner-2.png" alt="travello">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-5 col-lg-5">
                        <div class="all-contents" id="v-pills-tab-two" role="tablist" aria-orientation="vertical">
                            <div class="news-content active" id="pills-news-one-tab" data-bs-toggle="pill"
                                data-bs-target="#pills-news-one" role="tab" aria-controls="pills-news-one"
                                aria-selected="true">
                                <div class="heading">
                                    <span class="heading-pera">Tour Guide</span>
                                </div>
                                <h4 class="title">
                                    <a href="javascript:void(0)">The World is a Book and Those Who do not Travel Read
                                        Only
                                        One Page.</a>
                                </h4>
                                <div class="news-info">
                                    <div class="d-flex gap-10 align-items-center">
                                        <div class="author-img">
                                            <img src="assets/images/news/news-1.jpeg" alt="travello">
                                        </div>
                                        <p class="name">Crish Jorden</p>
                                    </div>
                                    <p class="time">10 min read</p>
                                </div>
                            </div>
                            <div class="news-content" id="pills-news-two-tab" data-bs-toggle="pill"
                                data-bs-target="#pills-news-two" role="tab" aria-controls="pills-news-two"
                                aria-selected="true">
                                <div class="heading">
                                    <span class="heading-pera">Tour Guide</span>
                                </div>
                                <h4 class="title">
                                    <a href="javascript:void(0)">A Good Traveler Has no Fixed Plans and is Not Intent on
                                        Arriving.</a>
                                </h4>
                                <div class="news-info">
                                    <div class="d-flex gap-10 align-items-center">
                                        <div class="author-img">
                                            <img src="assets/images/news/news-2.jpeg" alt="travello">
                                        </div>
                                        <p class="name">David Warner</p>
                                    </div>
                                    <p class="time">10 min read</p>
                                </div>
                            </div>
                            <div class="news-content" id="pills-news-three-tab" data-bs-toggle="pill"
                                data-bs-target="#pills-news-three" role="tab" aria-controls="pills-news-three"
                                aria-selected="true">
                                <div class="heading">
                                    <span class="heading-pera">Tour Guide</span>
                                </div>
                                <h4 class="title">
                                    <a href="javascript:void(0)">We Travel, Some of us Forever, to Seek Other States,
                                        Other Lives, Other Souls.</a>
                                </h4>
                                <div class="news-info">
                                    <div class="d-flex gap-10 align-items-center">
                                        <div class="author-img">
                                            <img src="assets/images/news/news-3.jpeg" alt="travello">
                                        </div>
                                        <p class="name">David Malan</p>
                                    </div>
                                    <p class="time">10 min read</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 text-center">
                            <div class="section-button d-inline-block">
                                <a href="news.html">
                                    <div class="btn-primary-icon-sm">
                                        <p class="pera">View All News</p>
                                        <i class="ri-arrow-right-up-line"></i>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="shape-news">
                <img src="assets/images/icon/bg-shape-3.png" alt="travello">
            </div>
        </section> -->
        <!--/ End of News -->

        <!-- Promotion S t a r t -->
        <!-- <section class="platform-area platform-area-bg">
            <div class="container">
                <div class="row align-items-end">
                    <div class="col-lg-8">
                        <div class="app-section-padding">
                            <div class="hero-caption-one position-relative">
                                <span class="highlight">Our Platform</span>
                                <h4 class="title">
                                    Enjoy And Book This App All Over The World
                                </h4>
                                <p class="pera">
                                    Lorem ipsum dolor sit amet consectetur. Curabitur volutpat
                                    tellus id vulputate viverra. Sapien non mauris risus
                                </p>
                            </div>
                            <div class="hero-footer position-relative">
                                <a href="../../www.youtube.com/watcha076.html?v=Cn4G2lZ_g2I" data-fancybox="video-gallery" class="wow bounceIn" data-wow-delay=".2s">
                                    <div class="video-player">
                                        <i class="ri-play-fill"></i>
                                    </div>
                                </a>
                                <a href="javascript:void(0)" class="pera position-relative">Download Our Apps</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="hero-banner d-none d-lg-block wow fadeInUp" data-wow-delay="0.2s">
                            <img src="assets/images/gallery/promotion.png" alt="travello">
                        </div>
                    </div>
                </div>
            </div>
        </section> -->
        <!--/ End of Promotion -->
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
        function viewPackage(id)
        { 
            window.location.href='tour-details.php?pacId='+id;  
        }

        function validateForm() {
           // var qoutation = document.forms["myForm"]["fname"].value;
            var name = document.forms["myForm"]["fname"];
            var email = document.forms["myForm"]["email"];
            var phone = document.forms["myForm"]["phone_no"];
            var destination = document.forms["myForm"]["destination"];
            var date = document.forms["myForm"]["date"];
            var package_suggetion = document.forms["myForm"]["package_suggetion"];
            var letters = /^[A-Za-z\s]*$/;
           // var number= /^[0-9]+$/;
           
            if (name.value == "") {
                window.alert("Please enter your name.");
                name.focus();
                return false;
            } else if(!name.value.match(letters)){
                document.getElementById("message").innerHTML = "Please enter valid name!.  ";
                setTimeout(function(){ document.getElementById("message").innerHTML = "";  }, 5000);
                return false;
            } else {
                document.getElementById("message").innerHTML = "";
            }
            
            if (email.value == "") {
                window.alert("Please enter a valid e-mail address.");
                email.focus();
                return false;
            }else if (destination.value == "") {
                window.alert("Please enter your destination");
                destination.focus();
                return false;
            }else if(!destination.value.match(letters)){
                document.getElementById("messages").innerHTML = "Please enter valid destination!.  ";
                
                setTimeout(function(){ 
                    document.getElementById("messages").innerHTML = "";
                }, 5000);
                destination.focus();
                return false;
             }
            else{ 
                 document.getElementById("messages").innerHTML = "";
                 return true;
            }
        }

        //date validation for quotation
        var today = new Date();
        var dd = String(today.getDate()).padStart(2, '0');
        var mm = String(today.getMonth() + 1).padStart(2, '0');
        var yyyy = today.getFullYear();

        today = yyyy + '-' + mm + '-' + dd;
        $('#traveldate').attr('min',today);

        //quotation submit action with validation
        $('#submit_quotations').click(function() {
            var enName = $('#q_name').val().trim();
            var enPhone = $('#q_phn_no').val().trim();
            var enEmail = $('#q_email').val().trim();
            var enDuration = $('#q_duration').val().trim();
            var enTDate = $('#q_date').val().trim();
            var enNadults = $('#q_no_adult').val().trim();
            var enNChild = $('#q_no_child').val().trim();
            var enNInfants = $('#q_no_infants').val().trim();
            var enBudget = $('#q_budget').val().trim();
            var enDestination = $('#pack_name').text();
            var enUserId = $('#q_user_id').val();
            let selectedMeals = [];
            document.querySelectorAll(".meal-checkbox:checked").forEach((checkbox) => {
                selectedMeals.push(checkbox.value);
            });
            var enRemarks = $('#floatingTextarea2').val().trim();
 
            //validation
            const phoneRegex = /^[0-9]{10}$/;
            const alphabetRegex = /^[A-Za-z]+(?:\s[A-Za-z]+)*$/;
            const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
            if (enName == '') {
                alert('Please enter your name');
            } else if (!alphabetRegex.test(enName)) {
                alert('Please enter alphabets only (minimum 3 characters long)');
            } else if (enPhone == '') {
                alert('Please enter your phone number');
            } else if (!phoneRegex.test(enPhone)) {
                alert("Invalid phone number");
            } else if (enEmail == '') {
                alert("Please enter your email");
            } else if (!emailRegex.test(enEmail)) {
                alert("Invalid email");
            } else if (enDuration == '') {
                alert("Please enter duratuion days");
            } else if (enDuration == 0) {
                alert("Duratuion days cannot be 0");
            } else if (enTDate == '') {
                alert("Please select Travel date");
            } else if (enNadults == 0) {
                alert("Number of adults cannot be 0");
            } else if (enBudget == '') {
                alert("Please enter your budget");
            } else if (enBudget == 0) {
                alert("Budget cannot be 0");
            } else if (enDuration == '') {
                alert("Please enter your travel duration days");
            } else if (enDuration == 0) {
                alert("Travel duration days cannot be 0");
            } else if (selectedMeals.length === 0) {
                alert("Select at least one required meal");
            } else {
                var formdata = {
                    enName: enName,
                    enPhone: enPhone,
                    enEmail: enEmail,
                    enDuration: enDuration,
                    enTDate: enTDate,
                    enNadults: enNadults,
                    enNChild: enNChild,
                    enNInfants: enNInfants,
                    enBudget: enBudget,
                    meals: selectedMeals,
                    enDestination: enDestination,
                    enUserId: enUserId,
                    enRemarks:enRemarks
                }
 
                console.log('formdata:');
                console.log(formdata);
                $.ajax({
                    url: "assets/submit/create_quotations.php",
                    type: "POST",
                    data: formdata,
                    success: function(res) {
                        if (res == 1) {
                            alert("Quotation will be sent to your email!");
                        } else {
                            alert("Server Error: " + res);
                        }
                    }
                });
            }
 
        });

    </script>
</body>

</html>