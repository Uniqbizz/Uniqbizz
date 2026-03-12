<?php 
    session_start();
?>
<!DOCTYPE html>
<html lang="zxx" dir="lrt">

<!-- Mirrored from Bizzmirth Holidayso.vercel.app/template/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 12 Jul 2024 06:52:28 GMT -->
<!-- Added by HTTrack --><meta http-equiv="content-type" content="text/html;charset=utf-8" /><!-- /Added by HTTrack -->
<head>
    <script>
        const setTheme = (theme) => {
            theme ??= localStorage.theme || "light";
            document.documentElement.dataset.theme = theme;
            localStorage.theme = theme;
        };
        setTheme();
    </script>
    <meta logo="assets/images/logo/logo1.png">
    <meta white-logo="assets/images/logo/logo1.png">

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description" content="Bizzmirth Holidays - Multipurpose travel and tour booking.These template is suitable for  travel agency , tour, travel website , tour operator , tourism , booking  trip or adventure website. ">
    <meta name="keywords" content="travel, trip booking,tour, hotel, tour guide, tourism, blog, flight, travel agency, tourism agency, accommodation, tour website">
    <meta name="author" content="inittheme">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta property="og:type" content="website">
    <meta property="og:title" content="Multipurpose travel and tour booking">
    <meta property="og:site_name" content="Bizzmirth Holidays">
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
    <link rel="stylesheet" type="text/css" href="assets/css/remixicon.css">
    <!-- Plugin -->
    <link rel="stylesheet" type="text/css" href="assets/css/plugin.css">
    <!-- Main CSS -->
    <link rel="stylesheet" type="text/css" href="assets/css/main-style.css">
    <!-- Dashboard CSS -->
    <link rel="stylesheet" type="text/css" href="assets/css/dashboard.css">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.0/css/all.min.css" integrity="sha512-DxV+EoADOkOygM4IR9yXP8Sb2qwgidEmeqAEmDKIOfPRQZOWbXCzLC6vjbZyy0vPisbH2SyW27+ddLVCN+OMzQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- RTL CSS::When Need RTL Uncomments File -->
    <!-- <link rel="stylesheet" type="text/css" href="assets/css/rtl.css"> -->
    <style>
        .carousel-section {
            width: 350px !important;
            height: 400px !important;
            border: 2px solid white;
            border-radius: 15px !important;
            position: absolute;
            top: 150px;
            right: 250px;
        }
        .carousel-section2 {
            width: 150px !important;
            height: 400px !important;
            border: 2px solid white;
            border-radius: 15px !important;
            position: absolute;
            top: 150px;
            right: 80px;
        }
        .carousalBackgroundTitle {
            position: absolute;
            top: 130px !important;
        }
        .carousalBackgroundTitle .pera {
            font-size: 60px !important;
            color: white;
            font-weight: bolder; 
            padding-left: 50px !important;
            width: 550px !important;
        }
        .peraDescription {
            font-size: 14px !important;
            color: white;
            padding-left: 50px !important;
            width: 550px !important;
        }
        #mainCarousel,
        #previewCarousel {
            pointer-events: auto;
            cursor: pointer;
        }
        /* testimonial start 6/3/2026 */
        #testimonialBanner{
            transition: all 0.5s ease;
            width: 100% !important;
            height: 400px !important;
            overflow: hidden !important;
            object-fit: fill !important;
        }
        /* testimonial end*/
        @media screen and (max-width: 1184px) {
            .carousel-section {
                width: 300px !important;
                height: 350px !important;
                border: 2px solid white;
                border-radius: 15px !important;
                position: absolute;
                top: 150px;
                right: 230px;
            }
            .carousel-section2 {
                width: 130px !important;
                height: 350px !important;
                border: 2px solid white;
                border-radius: 15px !important;
                position: absolute;
                top: 150px;
                right: 80px;
            }
            .sliderWidth {
                width: 100%;
                height: 346px;
                object-fit: cover; /* or 'contain' based on design preference */
                object-position: center;
                border-radius: 15px;
            }
            .prevIcon {
                border: none;
                background-color: transparent;
                position: absolute;
                top: 320px;
                right: 525px !important;
                opacity: 1;
            }
            .nextIcon {
                border: none;
                background-color: transparent;
                position: absolute;
                top: 320px;
                right: 35px !important;
                opacity: 1;
            }
        }
        @media screen and (max-width: 1100px) {
            .carousel-section {
                width: 260px !important;
                height: 300px !important;
                position: absolute;
                top: 150px;
                right: 180px;
            }
            .carousel-section2 {
                width: 115px !important;
                height: 300px !important;
                position: absolute;
                top: 150px;
                right: 50px;
            }
            .sliderWidth {
                width: 100%;
                height: 296px;
            }
            .prevIcon {
                position: absolute;
                top: 290px;
                right: 435px !important;
            }
            .nextIcon {
                position: absolute;
                top: 290px;
                right: 5px !important;
            }
        }
        @media screen and (max-width: 992px) {
            .carousel-section {
                width: 260px !important;
                height: 300px !important;
                position: absolute;
                top: 150px;
                right: 180px;
            }
            .carousel-section2 {
                width: 115px !important;
                height: 300px !important;
                position: absolute;
                top: 150px;
                right: 50px;
            }
            .sliderWidth {
                width: 100%;
                height: 296px !important;
            }
            .prevIcon {
                position: absolute;
                top: 290px;
                right: 435px !important;
            }
            .nextIcon {
                top: 290px;
                right: 5px !important;
                opacity: 1;
            }
            .carousalBackgroundTitle .pera {
                font-size: 45px !important;
                padding-left: 50px !important;
                width: 450px !important;
            }
            .peraDescription {
                font-size: 14px !important;
                padding-left: 50px !important;
                width: 450px !important;
            }
        }
        @media screen and (max-width: 910px) {
            .carousel-section {
                width: 260px !important;
                height: 300px !important;
                position: absolute;
                top: 150px;
                right: 160px;
            }
            .carousel-section2 {
                width: 115px !important;
                height: 300px !important;
                position: absolute;
                top: 150px;
                right: 35px;
            }
            .sliderWidth {
                width: 100%;
                height: 296px !important;
            }
            .prevIcon {
                position: absolute;
                top: 285px;
                right: 410px !important;
            }
            .nextIcon {
                position: absolute;
                top: 285px;
                right: -5px !important;
            }
            .carousalBackgroundTitle .pera {
                font-size: 40px !important;
                padding-left: 50px !important;
                width: 400px !important;
            }
            .peraDescription {
                font-size: 14px !important;
                padding-left: 50px !important;
                width: 395px !important;
            }
            .captionPosition {
                position: absolute;
                bottom: 0px !important;
            }
        }
        @media screen and (max-width: 840px) {
            .carousel-section {
                width: 260px !important;
                height: 300px !important;
                position: absolute;
                top: 380px;
                left: 80px;
            }
            .carousel-section2 {
                width: 130px !important;
                height: 300px !important;
                position: absolute;
                top: 380px;
                left: 370px;
            }
            .sliderWidth {
                width: 100%;
                height: 296px !important;
            }
            .prevIcon {
                display: none;
            }
            .nextIcon {
                display: none;
            }
            .heroHeight {
                height: 750px !important;
                padding-top: 0px !important;
            }
            .carousalBackgroundTitle .pera {
                font-size: 40px !important;
                padding-right: 50px !important;
                padding-left: 50px !important;
                width: 100% !important;
            }
            .peraDescription {
                font-size: 14px !important;
                padding-right: 50px !important;
                padding-left: 50px !important;
                width: 100% !important;
            }
        }
        @media screen and (max-width: 575px) {
            .heroHeight {
                height: 750px !important;
                padding-top: 0px !important;
            }
            .carousalBackgroundTitle .pera {
                font-size: 40px !important;
                padding-right: 50px !important;
                padding-left: 50px !important;
                width: 100% !important;
            }
            .peraDescription {
                font-size: 14px !important;
                padding-left: 50px !important;
                padding-right: 50px !important;
                width: 100% !important;
            }
            .carousel-section {
                width: 220px !important;
                height: 280px !important;
                position: absolute;
                top: 430px;
                left: 50px;
            }
            .carousel-section2 {
                width: 115px !important;
                height: 280px !important;
                position: absolute;
                top: 430px;
                left: 285px;
            }
            .sliderWidth {
                width: 100%;
                height: 276px !important;
            }
        }
        @media screen and (max-width: 400px) {
            .heroHeight {
                height: 780px !important;
                padding-top: 0px !important;
            }
            .carousel-section {
                width: 245px !important;
                height: 280px !important;
                position: absolute;
                top: 450px;
                left: 50px;
            }
            .carousel-section2 {
                display: none !important;
            }
            .sliderWidth {
                width: 100%;
                height: 276px !important;
            }
        }
    </style>
</head>
<body>
    <main>
        <!-- Hero area S t a r t-->
        <section class="hero-padding-for-three position-relative heroHeight">
            <?php include_once "headerIndex.php" ?>
            <!-- Video -->
            <div class="hero-bg-video">
                <img src="assets/images/slider/carousel-background2.png" alt="" width="100%" height="100%">
                <div class="carousalBackgroundTitle">
                    <p class="pera">Explore The World with Us</p>
                    <p class="peraDescription">Crafting memorable travel experiences with curated holiday packages, seamless bookings, and trusted support. Explore the world your way—smart planning, great value, unforgettable journeys.</p>
                    <div class="d-inline-block ps-5 mt-4">
                        <a href="tour-list.php">
                            <div class="btn-primary-icon-sm rounded-2">
                                <p class="text-white">View Packages</p>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="carousel-section">
                    <div id="mainCarousel" class="carousel slide">
                        <div class="carousel-inner" style="border-radius: 15px !important;">
                            <div class="carousel-item active">
                                <img src="assets/images/slider/Dubai_1.png" class="d-block sliderWidth" alt="...">
                                <div class="carousel-caption captionPosition">
                                    <div class="container">
                                        <div class="row align-items-center justify-content-center g-4">
                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 d-flex justify-content-start">
                                                <div class="hero-caption-three position-relative z-3">
                                                    <h5 class="wow fadeInUp mb-0 fontFamily text-white text-start fw-bolder" data-wow-delay="0.1s">
                                                        Dubai
                                                    </h5>
                                                    <h5 class="fontFamily text-white wow fadeInUp mt-2 text-start" data-wow-delay="0.3s"><span class="fw-bolder">&#8377; 20905/</span>person</h5>
                                                    <div class="wow fadeInUp mt-2 text-start" data-wow-delay="0.4s">
                                                        <a href="#" class="btn rounded-2 fontFamily fw-bolder capitalText packageBtn" onclick = viewPackage(218);>Take a Tour <i class="fa-solid fa-arrow-right fa-lg"></i></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="carousel-item">
                                <img src="assets/images/slider/Rajasthan-pic.png" class="d-block sliderWidth" alt="...">
                                <div class="carousel-caption captionPosition">
                                    <div class="container">
                                        <div class="row align-items-center justify-content-center g-4">
                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 d-flex justify-content-start">
                                                <div class="hero-caption-three position-relative z-3">
                                                    <h5 class="wow fadeInUp mb-0 fontFamily text-white text-start fw-bolder" data-wow-delay="0.1s">
                                                        Rajasthan Royal Tour
                                                    </h5>
                                                    <h5 class="fontFamily text-white wow fadeInUp mt-2 text-start" data-wow-delay="0.3s"><span class="fw-bolder">&#8377; 12190/</span>person</h5>
                                                    <div class="wow fadeInUp mt-2 text-start" data-wow-delay="0.4s">
                                                        <a href="#" class="btn rounded-2 fontFamily fw-bolder capitalText packageBtn" onclick = viewPackage(238);>Take a Tour <i class="fa-solid fa-arrow-right fa-lg"></i></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="carousel-item">
                                <img src="assets/images/slider/Delhi_1.png" class="d-block sliderWidth" alt="...">
                                <div class="carousel-caption captionPosition">
                                    <div class="container">
                                        <div class="row align-items-center justify-content-center g-4">
                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 d-flex justify-content-start">
                                                <div class="hero-caption-three position-relative z-3">
                                                    <h5 class="wow fadeInUp mb-0 fontFamily text-white text-start fw-bolder" data-wow-delay="0.1s">
                                                        Golden Triangle (Delhi–Agra–Jaipur)
                                                    </h5>
                                                    <h5 class="fontFamily text-white wow fadeInUp mt-2 text-start" data-wow-delay="0.3s"> <span class="fw-bolder">&#8377; 14,000/</span>person</h5>
                                                    <div class="wow fadeInUp mt-2 text-start" data-wow-delay="0.4s">
                                                        <a href="#" class="btn rounded-2 fontFamily fw-bolder capitalText packageBtn" onclick = viewPackage(199);>Take a Tour <i class="fa-solid fa-arrow-right fa-lg"></i></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="carousel-item">
                                <img src="assets/images/slider/Munnar.png" class="d-block sliderWidth" alt="...">
                                <div class="carousel-caption captionPosition">
                                    <div class="container">
                                        <div class="row align-items-center justify-content-center g-4">
                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 d-flex justify-content-start">
                                                <div class="hero-caption-three position-relative z-3">
                                                    <h5 class="wow fadeInUp mb-0 fontFamily text-white text-start fw-bolder" data-wow-delay="0.1s">
                                                        Kerala Backwaters & Hills
                                                    </h5>
                                                    <h5 class="fontFamily text-white wow fadeInUp mt-2 text-start" data-wow-delay="0.3s"><span class="fw-bolder">&#8377; 12345/</span>person</h5>
                                                    <div class="wow fadeInUp mt-2 text-start" data-wow-delay="0.4s">
                                                        <a href="#" class="btn rounded-2 fontFamily fw-bolder capitalText packageBtn" onclick = viewPackage(209);>Take a Tour <i class="fa-solid fa-arrow-right fa-lg"></i></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="carousel-item">
                                <img src="assets/images/slider/Shimla.png" class="d-block sliderWidth" alt="...">
                                <div class="carousel-caption captionPosition">
                                    <div class="container">
                                        <div class="row align-items-center justify-content-center g-4">
                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 d-flex justify-content-start">
                                                <div class="hero-caption-three position-relative z-3">
                                                    <h5 class="wow fadeInUp mb-0 fontFamily text-white text-start fw-bolder" data-wow-delay="0.1s">
                                                        Shimla–Manali Escape
                                                    </h5>
                                                    <h5 class="fontFamily text-white wow fadeInUp mt-2 text-start" data-wow-delay="0.3s"><span class="fw-bolder">&#8377; 16,649/</span>person</h5>
                                                    <div class="wow fadeInUp mt-2 text-start" data-wow-delay="0.4s">
                                                        <a href="#" class="btn rounded-2 fontFamily fw-bolder capitalText packageBtn" onclick = viewPackage(202);>Take a Tour <i class="fa-solid fa-arrow-right fa-lg"></i></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="carousel-section2">
                    <div id="previewCarousel" class="carousel slide">
                        <div class="carousel-inner" style="border-radius: 15px !important;">
                            <div class="carousel-item active">
                                <img src="assets/images/slider/Rajasthan-pic.png" class="d-block sliderWidth" alt="...">
                            </div>
                            <div class="carousel-item">
                                <img src="assets/images/slider/Delhi_1.png" class="d-block sliderWidth" alt="...">
                            </div>
                            <div class="carousel-item">
                                <img src="assets/images/slider/Munnar.png" class="d-block sliderWidth" alt="...">
                            </div>
                            <div class="carousel-item">
                                <img src="assets/images/slider/Shimla.png" class="d-block sliderWidth" alt="...">
                            </div>
                            <div class="carousel-item">
                                <img src="assets/images/slider/Dubai_1.png" class="d-block sliderWidth" alt="...">
                            </div>
                        </div>
                    </div>
                </div>
                <button class="prevIcon" type="button" id="prevBtn">
                    <span aria-hidden="true"><i class="fa-solid fa-angle-left fa-2xl" style="color: #ffffff;"></i></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="nextIcon" type="button" id="nextBtn">
                    <span aria-hidden="true"><i class="fa-solid fa-angle-right fa-2xl" style="color: #ffffff;"></i></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
            <!-- <div class="container">
                <div class="row align-items-center justify-content-center g-4">
                    <div class="col-xl-6">
                        <div class="hero-caption-three position-relative z-3">
                            <h4 class="title wow fadeInUp" data-wow-delay="0.0s">
                                Plan tours to dream locations in just a click!
                            </h4>
                            <p class="pera wow fadeInUp" data-wow-delay="0.1s">
                                Travel is a transformative and enriching experience that
                                allows individuals to explore new destinations, cultures, and
                                landscapes
                            </p>
                        </div> -->
                        <!-- <div class="hero-footer position-relative z-3 wow fadeInUp" data-wow-delay="0.3s">
                            <div class="all-user">
                                <div class="happy-user">
                                    <img src="assets/images/hero/user-1.jpeg" alt="Bizzmirth Holidays">
                                </div>
                                <div class="happy-user">
                                    <img src="assets/images/hero/user-2.png" alt="Bizzmirth Holidays">
                                </div>
                                <div class="happy-user">
                                    <img src="assets/images/hero/user-3.png" alt="Bizzmirth Holidays">
                                </div>
                                <div class="happy-user">
                                    <img src="assets/images/hero/user-4.jpeg" alt="Bizzmirth Holidays">
                                </div>
                                <div class="happy-user-count">
                                    <p class="user-count">5k+</p>
                                </div>
                                <p class="pera">Happy Customer</p>
                                <span class="wave-emoji">
                                    <img src="assets/images/icon/hand.png" alt="Bizzmirth Holidays">
                                </span>
                            </div>
                        </div> -->
                    <!-- </div>
                </div>
            </div> -->
        </section>
        <!--/ End-of Hero-->

        <!-- Plan area S t a r t -->
        <!-- <section class="plan-area-three">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="plan-section-three plan-shadow">
                            <div class="choose-plan-nav"> -->

                                <!-- Buttons Type Select -->
                                <!-- <ul class="nav nav-tabs" id="myTab" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="plan-link active" id="tour-tab" data-bs-toggle="tab"
                                            data-bs-target="#tour" type="button" role="tab" aria-controls="tour"
                                            aria-selected="true">
                                            <i class="ri-ship-line"></i> Tour
                                        </button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="plan-link" id="book-tab" data-bs-toggle="tab" data-bs-target="#book"
                                            type="button" role="tab" aria-controls="book" aria-selected="false">
                                            <i class="ri-flight-takeoff-fill"></i> Book
                                        </button>
                                    </li>
                                </ul> -->
                                <!-- / End-of Buttons -->

                                <!-- Tab Search Contents -->
                                <!-- <div class="tab-content" id="tourTab">
                                    <div class="tab-pane fade show active" id="tour" role="tabpanel" aria-labelledby="tour-tab">
                                        <div class="d-flex gap-16 flex-wrap mb-26">
                                            <label class="one-way-label">
                                                <input class="one-way-input" type="radio" name="radio">
                                                <span class="circle"></span>
                                                <span class="radio-text">One Way</span>
                                            </label>
                                            <label class="round-trip-label">
                                                <input class="round-trip-input" type="radio" name="radio" checked>
                                                <span class="circle"></span>
                                                <span class="radio-text">Round Trip</span>
                                            </label>
                                        </div>
                                        <div class="row g-4 justify-content-end">
                                            <div class="col-xl-5 col-lg-12">
                                                <div class="destination-flex">
                                                    <div class="select-dropdown-section">
                                                        <div class="d-flex gap-10 align-items-center">
                                                            <div class="destination-dropdown-two"></div>
                                                        </div>
                                                        <div class="destination-result line-clamp-1">
                                                            Istanbul Airport...
                                                        </div>
                                                    </div>
                                                    <div class="select-dropdown-section">
                                                        <div class="d-flex gap-10 align-items-center">
                                                            <div class="destination-dropdown-three"></div>
                                                        </div>
                                                        <div class="destination-result-three line-clamp-1">
                                                            Istanbul Airport...
                                                        </div>
                                                    </div>
                                                    <div class="swap-icon">
                                                        <i class="ri-arrow-left-right-line"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-5 col-lg-12">
                                                <div class="destination-flex">
                                                    <div class="dropdown-section">
                                                        <div class="d-flex gap-10 align-items-center">
                                                            <div class="custom-date-three">
                                                                <h4 class="month-title month-result">February</h4>
                                                                <div class="year-title year-result">
                                                                    Tuesday, 6, 2023
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="dropdown-section">
                                                        <div class="d-flex gap-10 align-items-center">
                                                            <div class="custom-date-three">
                                                                <h4 class="month-title text-right month-result-two">
                                                                    March
                                                                </h4>
                                                                <div class="year-title text-right year-result-two">
                                                                    Tuesday, 6, 2023
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="swap-icon">
                                                        <i class="ri-calendar-2-line"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-2 col-lg-3">
                                                <div class="sign-btn text-right">
                                                    <a href="tour-list.html" class="btn-secondary-lg w-100 text-center">
                                                        <i   class="ri-search-line mr-10 font-20"></i> Search Plan
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="book" role="tabpanel" aria-labelledby="book-tab">
                                        <div class="d-flex gap-16 flex-wrap mb-26">
                                            <label class="one-way-label">
                                                <input class="one-way-input" type="radio" name="radio">
                                                <span class="circle"></span>
                                                <span class="radio-text">One Way</span>
                                            </label>
                                            <label class="round-trip-label">
                                                <input class="round-trip-input" type="radio" name="radio">
                                                <span class="circle"></span>
                                                <span class="radio-text">Round Trip</span>
                                            </label>
                                        </div>
                                        <div class="row g-4 justify-content-end">
                                            <div class="col-xl-5 col-lg-12">
                                                <div class="destination-flex">
                                                    <div class="select-dropdown-section">
                                                        <div class="d-flex gap-10 align-items-center">
                                                            <div class="destination-dropdown-two"></div>
                                                        </div>
                                                        <div class="destination-result line-clamp-1">
                                                            Istanbul Airport...
                                                        </div>
                                                    </div>
                                                    <div class="select-dropdown-section">
                                                        <div class="d-flex gap-10 align-items-center">
                                                            <div class="destination-dropdown-three"></div>
                                                        </div>
                                                        <div class="destination-result-three line-clamp-1">
                                                            Istanbul Airport...
                                                        </div>
                                                    </div>
                                                    <div class="swap-icon">
                                                        <i class="ri-arrow-left-right-line"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-5 col-lg-12">
                                                <div class="destination-flex">
                                                    <div class="dropdown-section">
                                                        <div class="d-flex gap-10 align-items-center">
                                                            <div class="custom-date-three">
                                                                <h4 class="month-title month-result">February</h4>
                                                                <div class="year-title year-result">
                                                                    Tuesday, 6, 2023
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="dropdown-section">
                                                        <div class="d-flex gap-10 align-items-center">
                                                            <div class="custom-date-three">
                                                                <h4 class="month-title text-right month-result-two">
                                                                    March
                                                                </h4>
                                                                <div class="year-title text-right year-result-two">
                                                                    Tuesday, 6, 2023
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="swap-icon">
                                                        <i class="ri-calendar-2-line"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-2 col-lg-3">
                                                <div class="sign-btn">
                                                    <a href="tour-list.html" class="btn-secondary-lg w-100 text-center">
                                                        <i class="ri-search-line mr-10 font-20"></i> Search Plan
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div> -->
                                <!-- / End-of Search Contents -->
                            <!-- </div>
                        </div>
                    </div>
                </div>
            </div>
        </section> -->
        <!--/ End-of Plan-->

        <!-- Destination area S t a r t -->
        <section class="destination-area destination-bg-before">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xl-7 col-lg-7">
                        <div class="section-title text-center mx-auto position-relative">
                            <span class="highlights">Destination List</span>
                            <h4 class="title">
                                Popular Travel Destinations <br />Available Worldwide
                            </h4>
                        </div>
                    </div>
                </div>
                <div class="row g-4">
                    <div class="col-xl-4 col-lg-7 col-md-7">
                        <a href="destination-details/destination-details-kerala.php" class="destination-banner">
                            <img src="assets/images/destination/Kerala-main.jpg" alt="Bizzmirth Holidays" style="  object-fit: cover;">
                            <div class="destination-content">
                              
                                <div class="destination-info">
                                    <div class="destination-name">
                                        <p class="pera">Kerala</p>
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
                    <div class="col-xl-4 col-lg-7 col-md-7">
                        <a href="destination-details/destination-details-goa.php" class="destination-banner">
                            <img src="assets/images/destination/Goa.jpg" alt="Bizzmirth Holidays" style="  object-fit: cover;">
                            <div class="destination-content">
                                <div class="destination-info">
                                    <div class="destination-name">
                                        <p class="pera">Goa</p>
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
                    <div class="col-xl-4 col-lg-7 col-md-7">
                        <a href="destination-details/destination-details-gujarat.php" class="destination-banner">
                            <img src="assets/images/destination/Gujarat.jpg" alt="Bizzmirth Holidays" style="  object-fit: cover;">
                            <div class="destination-content">
                               
                                <div class="destination-info">
                                    <div class="destination-name">
                                        <p class="pera">Gujarat</p>
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
                            <div class="col-lg-3 col-md-6 col-sm-6">
                                <a href="destination-details/destination-details-uttarakhand.php" class="destination-banner">
                                    <img src="assets/images/destination/Uttarakhand.jpg" alt="Bizzmirth Holidays" style="  object-fit: cover;">
                                    <div class="destination-content">
                                     
                                        <div class="destination-info">
                                            <div class="destination-name">
                                                <p class="pera">Uttarakhand</p>
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
                            <div class="col-lg-3 col-md-6 col-sm-6">
                                <a href="#" class="destination-banner">
                                    <img src="assets/images/destination/Dubai.jpg" alt="Bizzmirth Holidays" style="  object-fit: cover;">
                                    <div class="destination-content">
                                      
                                        <div class="destination-info">
                                            <div class="destination-name">
                                                <p class="pera">Dubai</p>
                                                
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
                            <div class="col-lg-3 col-md-6 col-sm-6">
                                <a href="#" class="destination-banner">
                                        <img src="assets/images/destination/Thailand.jpg" alt="Bizzmirth Holidays" style="  object-fit: cover;">
                                    <div class="destination-content">
                                        
                                        <div class="destination-info">
                                            <div class="destination-name">
                                                <p class="pera">Thailand</p>
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
                            <div class="col-lg-3 col-md-6 col-sm-6">
                                <a href="destination-details/destination-details-rajasthan.php" class="destination-banner">
                                        <img src="assets/images/destination/Rajasthan.jpg" alt="Bizzmirth Holidays" style="  object-fit: cover;">
                                    <div class="destination-content">
                                        <div class="destination-info">
                                            <div class="destination-name">
                                                <p class="pera">Rajasthan</p>
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
            <!-- shape -->
            <div class="shape">
                <img src="assets/images/icon/shape.png" alt="Bizzmirth Holidays">
            </div>
        </section>
        <!--/ End-of Destination -->

         <!-- About Us area S t a r t -->
        <section class="about-area-two about-bg-before section-padding2 mt-4">
            <div class="container">
                <div class="row align-items-center position-relative">
                    <div class="col-lg-8">
                        <div class="section-title mx-526 mb-30">
                            <span class="highlights">about us</span>
                            <h4 class="title">Get The Best Travel Experience With Bizzmirth Holidays</h4>
                            <p class="pera">
                                Bizzmirth Holidays Pvt. Ltd. is a leading travel industry enabler, 
                                offering entrepreneurs a complete business platform. 
                            </p>
                            <p class="pera">
                                With enterprise solutions, inventory systems, compliance, training, customer portfolio management, 
                                and revenue support, we provide technology-driven strategies and expert guidance, 
                                ensuring seamless operations, growth, and profitability for our partners in the holiday and business sector.
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="discover-circle ">
                            <a href="about.php" class="discover-btn">Discover More <i class="ri-arrow-right-up-line"></i></a>
                        </div>
                    </div>
                </div>
                <div class="about-banner-two">
                    <h4 class="watermark-text ">7+ years of experience</h4>
                    <div class="video-section">
                        <!-- Video -->
                        <div class="hero-bg-video">
                            <video class="hero-slider-video video-cover radius-30" 
                                poster="assets/images/gallery/about-curve-banner.png" loop autoplay muted>
                                <source src="assets/images/videos/travel4.mp4" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>
                        </div>

                        <img src="assets/images/gallery/about-curve-banner.png" alt="Bizzmirth Holidays">
                        <div class="rectangle-shape d-none d-sm-block">
                            <div class="sticky-corner right-corner">
                                <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" viewBox="0 0 35 35"
                                    fill="none">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M35 0V35C35 15.67 19.33 0 -1.53184e-05 0H35Z" fill="#daedef"></path>
                                </svg>
                            </div>
                            <div class="sticky-corner bottom-corner">
                                <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" viewBox="0 0 35 35"
                                    fill="none">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M35 0V35C35 15.67 19.33 0 -1.53184e-05 0H35Z" fill="#daedef"></path>
                                </svg>
                            </div>
                        </div>
                        <a href="../../www.youtube.com/watcha076.html?v=Cn4G2lZ_g2I" class="d-none d-sm-block " data-fancybox="video-gallery">
                            <div class="video-player">
                                <i class="ri-play-fill"></i>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </section>
        <!--/ End-of About US-->

        <!-- Feature S t a r t -->
        <section class="feature-area feature-area-bg mt-0 pt-0">
            <div class="container">
                <div class="row justify-content-center position-relative z-10">
                    <div class="col-xl-7 col-lg-7">
                        <div class="section-title mx-430 mx-auto text-center">
                            <span class="highlights fancy-font font-400">Popular Packages</span>
                            <h4 class="title">
                                Explore The Beautiful Places Around World
                            </h4>
                        </div>
                    </div>
                </div>
                <div class="row g-4 position-relative z-10">
                    <div class="swiper favSwiper-active">
                        <div class="swiper-wrapper">
                            
                        <?php 

                            require 'connect.php';
                            
                            $user_id = 0;
                            $ta_id = 0;
                            // get TA id
                            if ( $user_id ) {
                                if (  $user_type == '2' ) {
                                    $ta_data = $conn->prepare("SELECT * FROM ca_customer WHERE ca_customer_id = '".$user_id."' " );
                                    $ta_data->execute();
                                    $ta = $ta_data->fetch();
                                    $ta_id = $ta['ta_reference_no'];
                                } else if (  $user_type == '3' ) {
                                    $ta_id = $user_id;
                                }
                            }

                            $stmt = $conn->prepare(" SELECT p.id, p.description, p.description, p.destination, p.location, p.name, p.tour_days, t.total_package_price_per_adult, t.total_package_price_per_child, t.markup_total FROM package p, package_pricing t, category c WHERE p.id = t.package_id AND p.category_id = c.id AND p.status = '1' ORDER BY p.id DESC LIMIT 10 ");
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

                                    $adult_price = (int)$row['total_package_price_per_adult'];
                                    $markup_price = (int)$row['markup_total'];
                                    
                                    $tourDay = (int)$row['tour_days'] - 1;
                                    $tourNight = (int)$row['tour_days'] - 2;

                                    $total_base_price = $adult_price + $markup_price;

                                    if ( $ta_id ) {
                                        $ta_markup_data = $conn->prepare("SELECT * FROM package_markup_travelagent WHERE travelagent_id = '".$ta_id."' AND package_id = '".$row['id']."' AND status='1' LIMIT 1" );
                                        $ta_markup_data->execute();
                                        $ta_markup = $ta_markup_data->fetch();

                                        $total_price = $ta_markup['selling_price'] ?? $total_base_price;
                                    } else {
                                        $total_price = $total_base_price;
                                    }

                                    echo' <div class="swiper-slide">
                                        <div class="package-card">
                                            <div class="package-img imgEffect4">
                                                <a href="#" onclick=\'viewPackage("' .$row['id']. '")\'>
                                                    <img src="'.$value['image'].'" alt="Bizzmirth Holidays">
                                                </a>
                                            </div>
                                            <div class="package-content">
                                                <div class="location">
                                                    <i class="ri-map-pin-line"></i>
                                                    <div class="name">'.$row['destination'].'</div>
                                                </div>
                                                <h4 class="area-name">
                                                    <a href="#" onclick=\'viewPackage("' .$row['id']. '")\'>'.$row['name'].'</a>
                                                </h4>
                                                <div class="packages-person mb-16">
                                                    <div class="count">
                                                        <i class="ri-time-line"></i>
                                                        <p class="pera"> '.$tourNight.' Night '.$tourDay.' Days</p>
                                                    </div>
                                                    <div class="count">
                                                        <i class="ri-user-line"></i>
                                                        <p class="pera">1 Person</p>
                                                    </div>
                                                </div>
                                                <div class="price-review mb-0">
                                                    <div class="d-flex gap-10">
                                                        <p class="light-pera">From</p>
                                                        <p class="pera"><span>&#8377</span>'.$total_price.'</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>';
                                }
                            }
                        ?>
                        </div>
                        <!-- <div class="swiper-button-next">
                            <i class="ri-arrow-right-s-line"></i>
                        </div>
                        <div class="swiper-button-prev">
                            <i class="ri-arrow-left-s-line"></i>
                        </div> -->
                    </div>
                </div>
                <div class="row position-relative z-10">
                    <div class="col-12 text-center">
                        <div class="section-button d-inline-block">
                            <a href="tour-list.php">
                                <div class="btn-primary-icon-sm border-radius-20">
                                    <p class="pera">View All Tour</p>
                                    <i class="ri-arrow-right-up-line"></i>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--/ End of Feature -->

        <!-- Testimonial S t a r t 6/3/2026 -->
        <section class="testimonial-area-three position-relative section-bg-before-two top-padding bottom-padding">
            <div class="container">
                <div class="row justify-content-center position-relative">
                    <div class="col-xl-7 col-lg-7">
                        <div class="section-title mx-430 mx-auto text-center">
                            <span class="highlights fancy-font font-400">Testimonial</span>
                            <h4 class="title">
                                What People Have Said About Our Service
                            </h4>
                        </div>
                    </div>
                </div>
                <div class="row g-4 align-items-center">
                    <div class="col-xl-6 col-lg-6 col-md-6">
                        <div class="swiper testimonialThree-active">
                            <div class="swiper-wrapper">
                                <div class="swiper-slide testimonial-card">
                                    <div class="testimonial-header">
                                        <div class="user-img">
                                            <img src="assets/images/testimonial/img-5.png" alt="Bizzmirth Holidays">
                                        </div>
                                        <div class="user-info">
                                            <p class="name">Vasudev Hadkonkar</p>
                                            <p class="destination">Rajasthan</p>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                       <div class="rattings">
                                            <i class="ri-star-fill"></i><i class="ri-star-fill"></i><i
                                                class="ri-star-fill"></i><i class="ri-star-fill"></i><i
                                                class="ri-star-fill"></i>
                                        </div> 
                                        <p class="date">September 2025</p>
                                    </div>
                                    
                                    <div class="testimonial-body">
                                        <p class="pera">
                                            Rajasthan's Royal charm, historic landmarks, and colourful traditions left us amazed.
                                            Bizzmirth Holidays Pvt Ltd delivered excellent hospitality, and well organised arrangements, 
                                            making our tour a truly memorable one, Looking forward to book with them again, With Regards , Vasudev Hadkonkar.
                                        </p>
                                    </div>
                                </div>
                                <div class="swiper-slide testimonial-card">
                                    <div class="testimonial-header">
                                        <div class="user-img">
                                            <img src="assets/images/testimonial/img-5.png" alt="Bizzmirth Holidays">
                                        </div>
                                        <div class="user-info">
                                            <p class="name">Vivek Naik</p>
                                            <p class="destination">Kashmir</p>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <div class="rattings">
                                            <i class="ri-star-fill"></i><i class="ri-star-fill"></i><i
                                                class="ri-star-fill"></i><i class="ri-star-fill"></i><i
                                                class="ri-star-fill"></i>
                                        </div>
                                        <p class="date">December 2024</p>
                                    </div>
                                    <div class="testimonial-body">
                                        <p class="pera">
                                            Good Quality of Accomodation
                                        </p>
                                    </div>
                                </div>
                                <div class="swiper-slide testimonial-card">
                                    <div class="testimonial-header">
                                        <div class="user-img">
                                            <img src="assets/images/testimonial/img-5.png" alt="Bizzmirth Holidays">
                                        </div>
                                        <div class="user-info">
                                            <p class="name">Keshav Gaude</p>
                                            <p class="destination">Shimla Manali</p>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <div class="rattings">
                                            <i class="ri-star-fill"></i><i class="ri-star-fill"></i><i
                                                class="ri-star-fill"></i><i class="ri-star-fill"></i><i
                                                class="ri-star-fill"></i>
                                        </div>
                                        <p class="date">May 2025</p>
                                    </div>
                                    <div class="testimonial-body">
                                        <p class="pera">
                                            Thanks to Bizzmirth Holidays Pvt Ltd for their exceptional and proffessional service during 
                                            our trip to Shimla-Manali. You made our trip safe, relaxing, memorable with perfect itinerary , 
                                            timely pickups and quality hotels. Impressed with the quality service provided by 
                                            Bizzmirth Holidays Pvt Ltd and definitely will use again and also will recommend to our friends and family. 
                                            With Regards K.G & family.
                                        </p>
                                    </div>
                                </div>
                                <div class="swiper-slide testimonial-card">
                                    <div class="testimonial-header">
                                        <div class="user-img">
                                            <img src="assets/images/testimonial/img-5.png" alt="Bizzmirth Holidays">
                                        </div>
                                        <div class="user-info">
                                            <p class="name">Milind Kumbhar</p>
                                            <p class="destination">Hyderabad</p>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <div class="rattings">
                                            <i class="ri-star-fill"></i><i class="ri-star-fill"></i><i
                                                class="ri-star-fill"></i><i class="ri-star-fill"></i><i 
                                                class="ri-star-line"></i>
                                        </div>
                                        <p class="date">December 2025</p>
                                    </div>
                                    <div class="testimonial-body">
                                        <p class="pera">
                                            We booked our holiday with Bizzmirth  Holidays pvt ltd.Everything was perfect and went smoothly. 
                                            Great communication and information provided. Enjoyed our Family Tour, Thanks for all your help,
                                            Arranging holiday was great.Milind kumbhar
                                        </p>
                                    </div>
                                </div>
                                <div class="swiper-slide testimonial-card">
                                    <div class="testimonial-header">
                                        <div class="user-img">
                                            <img src="assets/images/testimonial/img-5.png" alt="Bizzmirth Holidays">
                                        </div>
                                        <div class="user-info">
                                            <p class="name">Teja Hadkonkar</p>
                                            <p class="destination">Bhuj</p>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <div class="rattings">
                                            <i class="ri-star-fill"></i><i class="ri-star-fill"></i><i
                                                class="ri-star-fill"></i><i class="ri-star-fill"></i><i 
                                                class="ri-star-line"></i>
                                        </div>
                                        <p class="date">Jan 2026</p>
                                    </div>
                                    <div class="testimonial-body">
                                        <p class="pera">
                                            Amazing Bhuj Tour with Bizzmirth Holidays beautifully covered the White Rann, Historic places, 
                                            and vibrant local cultures with complete facilities and smooth arrangements. 
                                            looking forward to book with them again.
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-pagination"></div>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-6">
                        <div class="hero-banner imgEffect2 o-hidden radius-20">
                            <img id="testimonialBanner" src="assets/images/hero/testimonial-banner-1.jpg" alt="Bizzmirth Holidays" width="100%" height="500px">
                        </div>
                    </div>
                    <!-- / End Slider -->
                </div>
            </div>
            <div class="shape-testimonial">
                <img src="assets/images/icon/graphic.png" alt="Bizzmirth Holidays">
            </div>
        </section>
        <!--/ End of Testimonial -->

        <!-- Special area S t a r t -->
        <!-- <section class="special-area section-padding2">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xl-7 col-lg-7">
                        <div class="section-title mx-430 mx-auto text-center">
                            <span class="highlights fancy-font font-400">special offers</span>
                            <h4 class="title">
                                Winter Our Big Offers to Inspire You
                            </h4>
                        </div>
                    </div>
                </div>
                <div class="row g-4">
                    <div class="col-lg-6 col-md-6">
                        <a href="tour-list.html" class="offer-banner imgEffect4 wow fadeInLeft" data-wow-delay="0.0s">
                            <img src="assets/images/gallery/offercard-1.jpg" alt="Bizzmirth Holidays">
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
                            <img src="assets/images/gallery/offercard-2.jpg" alt="Bizzmirth Holidays">
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
        </section> -->
        <!--/ End-of special-->

        <!-- Trip area S t a r t -->
        <!-- <section class="special-area">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xl-7 col-lg-7">
                        <div class="section-title mx-430 mx-auto text-center">
                            <span class="highlights fancy-font font-400">Enjoy Trip</span>
                            <h4 class="title">
                                Top Domestic & International Tour
                            </h4>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12"> -->

                        <!-- Trip Buttons -->
                        <!-- <ul class="nav nav-pills trip-pills" id="pills-tab" role="tablist">
                            <li class="nav-item trip-item" role="presentation">
                                <button class="nav-link trip-nav active" id="pills-domestic-tab" data-bs-toggle="pill"
                                    data-bs-target="#pills-domestic" type="button" role="tab" aria-controls="pills-domestic"
                                    aria-selected="true">
                                    Domestic
                                </button>
                            </li>
                            <li class="nav-item trip-item" role="presentation">
                                <button class="nav-link trip-nav" id="pills-international-tab" data-bs-toggle="pill"
                                    data-bs-target="#pills-international" type="button" role="tab"
                                    aria-controls="pills-international" aria-selected="false">
                                    International
                                </button>
                            </li>
                        </ul> -->
                        <!-- / End-of Trip Buttons -->

                        <!-- Tab Contents -->
                        <!-- <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane fade show active" id="pills-domestic" role="tabpanel"
                                aria-labelledby="pills-domestic-tab">
                                <div class="row g-4">
                                    <div class="col-xl-4 col-md-6">
                                        <a href="tour-details.html" class="trip-card">
                                            <div class="from-flex">
                                                <h4 class="from-title">USA</h4>
                                                <p class="from-pera line-clamp-1">Istanbul Airport...</p>
                                            </div>
                                            <div class="trip-icon-flex">
                                                <div class="trip-icon"><i class="ri-flight-takeoff-fill"></i></div>
                                            </div>
                                            <div class="from-flex">
                                                <h4 class="from-title">Sylhet</h4>
                                                <p class="from-pera line-clamp-1">Osman Internatin...</p>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col-xl-4 col-md-6">
                                        <a href="tour-details.html" class="trip-card">
                                            <div class="from-flex">
                                                <h4 class="from-title">USA</h4>
                                                <p class="from-pera line-clamp-1">Istanbul Airport...</p>
                                            </div>
                                            <div class="trip-icon-flex">
                                                <div class="trip-icon"><i class="ri-flight-takeoff-fill"></i></div>
                                            </div>
                                            <div class="from-flex">
                                                <h4 class="from-title">kolkata</h4>
                                                <p class="from-pera line-clamp-1">kolkata Airport</p>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col-xl-4 col-md-6">
                                        <a href="tour-details.html" class="trip-card">
                                            <div class="from-flex">
                                                <h4 class="from-title">USA</h4>
                                                <p class="from-pera line-clamp-1">Istanbul Airport...</p>
                                            </div>
                                            <div class="trip-icon-flex">
                                                <div class="trip-icon"><i class="ri-flight-takeoff-fill"></i></div>
                                            </div>
                                            <div class="from-flex">
                                                <h4 class="from-title">india</h4>
                                                <p class="from-pera line-clamp-1">Shah Amanat Inter...</p>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col-xl-4 col-md-6">
                                        <a href="tour-details.html" class="trip-card">
                                            <div class="from-flex">
                                                <h4 class="from-title">USA</h4>
                                                <p class="from-pera line-clamp-1">Istanbul Airport...</p>
                                            </div>
                                            <div class="trip-icon-flex">
                                                <div class="trip-icon"><i class="ri-flight-takeoff-fill"></i></div>
                                            </div>
                                            <div class="from-flex">
                                                <h4 class="from-title">india</h4>
                                                <p class="from-pera line-clamp-1">Shah Amanat Inter...</p>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col-xl-4 col-md-6">
                                        <a href="tour-details.html" class="trip-card">
                                            <div class="from-flex">
                                                <h4 class="from-title">USA</h4>
                                                <p class="from-pera line-clamp-1">Istanbul Airport...</p>
                                            </div>
                                            <div class="trip-icon-flex">
                                                <div class="trip-icon"><i class="ri-flight-takeoff-fill"></i></div>
                                            </div>
                                            <div class="from-flex">
                                                <h4 class="from-title">canada</h4>
                                                <p class="from-pera line-clamp-1">canada Airport</p>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col-xl-4 col-md-6">
                                        <a href="tour-details.html" class="trip-card">
                                            <div class="from-flex">
                                                <h4 class="from-title">USA</h4>
                                                <p class="from-pera line-clamp-1">Istanbul Airport...</p>
                                            </div>
                                            <div class="trip-icon-flex">
                                                <div class="trip-icon"><i class="ri-flight-takeoff-fill"></i></div>
                                            </div>
                                            <div class="from-flex">
                                                <h4 class="from-title">kolkata</h4>
                                                <p class="from-pera line-clamp-1">kolkata Airport</p>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="pills-international" role="tabpanel"
                                aria-labelledby="pills-international-tab">
                                <div class="row g-4">
                                    <div class="col-xl-4 col-md-6">
                                        <a href="tour-details.html" class="trip-card">
                                            <div class="from-flex">
                                                <h4 class="from-title">USA</h4>
                                                <p class="from-pera line-clamp-1">Istanbul Airport...</p>
                                            </div>
                                            <div class="trip-icon-flex">
                                                <div class="trip-icon"><i class="ri-flight-takeoff-fill"></i></div>
                                            </div>
                                            <div class="from-flex">
                                                <h4 class="from-title">Australia</h4>
                                                <p class="from-pera line-clamp-1">
                                                    Australia Internatin...
                                                </p>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col-xl-4 col-md-6">
                                        <a href="tour-details.html" class="trip-card">
                                            <div class="from-flex">
                                                <h4 class="from-title">USA</h4>
                                                <p class="from-pera line-clamp-1">Istanbul Airport...</p>
                                            </div>
                                            <div class="trip-icon-flex">
                                                <div class="trip-icon"><i class="ri-flight-takeoff-fill"></i></div>
                                            </div>
                                            <div class="from-flex">
                                                <h4 class="from-title">Usa</h4>
                                                <p class="from-pera line-clamp-1">Usa Airport</p>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col-xl-4 col-md-6">
                                        <a href="tour-details.html" class="trip-card">
                                            <div class="from-flex">
                                                <h4 class="from-title">USA</h4>
                                                <p class="from-pera line-clamp-1">Istanbul Airport...</p>
                                            </div>
                                            <div class="trip-icon-flex">
                                                <div class="trip-icon"><i class="ri-flight-takeoff-fill"></i></div>
                                            </div>
                                            <div class="from-flex">
                                                <h4 class="from-title">Japan</h4>
                                                <p class="from-pera line-clamp-1">Narita Inter...</p>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col-xl-4 col-md-6">
                                        <a href="tour-details.html" class="trip-card">
                                            <div class="from-flex">
                                                <h4 class="from-title">USA</h4>
                                                <p class="from-pera line-clamp-1">Istanbul Airport...</p>
                                            </div>
                                            <div class="trip-icon-flex">
                                                <div class="trip-icon"><i class="ri-flight-takeoff-fill"></i></div>
                                            </div>
                                            <div class="from-flex">
                                                <h4 class="from-title">Hongkok</h4>
                                                <p class="from-pera line-clamp-1">Hongkok Inter...</p>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col-xl-4 col-md-6">
                                        <a href="tour-details.html" class="trip-card">
                                            <div class="from-flex">
                                                <h4 class="from-title">USA</h4>
                                                <p class="from-pera line-clamp-1">Istanbul Airport...</p>
                                            </div>
                                            <div class="trip-icon-flex">
                                                <div class="trip-icon"><i class="ri-flight-takeoff-fill"></i></div>
                                            </div>
                                            <div class="from-flex">
                                                <h4 class="from-title">Japan</h4>
                                                <p class="from-pera line-clamp-1">Narita Inter...</p>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col-xl-4 col-md-6">
                                        <a href="tour-details.html" class="trip-card">
                                            <div class="from-flex">
                                                <h4 class="from-title">USA</h4>
                                                <p class="from-pera line-clamp-1">Istanbul Airport...</p>
                                            </div>
                                            <div class="trip-icon-flex">
                                                <div class="trip-icon"><i class="ri-flight-takeoff-fill"></i></div>
                                            </div>
                                            <div class="from-flex">
                                                <h4 class="from-title">Canada</h4>
                                                <p class="from-pera line-clamp-1">Canada Airport</p>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div> -->
                        <!-- / End-of Tab contents -->
                    <!-- </div>
                </div>
            </div>
        </section> -->
        <!--/ End-of trip-->

        <!-- About Us area S t a r t -->
        <!-- <section class="about-area">
            <div class="container">
                <div class="row g-4">
                    <div class="col-xl-5 col-lg-6">
                        <div class="section-title mx-430 mb-30 w-md-100">
                            <span class="highlights fancy-font font-400">About Us</span>
                            <h4 class="title">
                                Get The Best Travel Experience With Bizzmirth Holidays
                            </h4>
                            <p class="pera">
                                Travel is a transformative and enriching experience that
                                allows individuals to explore new destinations, cultures, and
                                landscapes. It is a fundamental human activity that has been
                                practiced for centuries and continues to be a source of joy,
                                learning, and personal growth.
                            </p>
                            <p class="pera">
                                Travel is a transformative and enriching experience that
                                allows individuals to explore new destinations, cultures.
                            </p>
                            <div class="section-button mt-27 d-inline-block">
                                <a href="about.html" class="btn-primary-icon-sm radius-20">
                                    <p class="pera mt-0">Learn More</p>
                                    <i class="ri-arrow-right-up-line"></i>
                                </a>
                            </div>
                            <div class="about-imp-link mt-40">
                                <div class="icon">
                                    <i class="ri-user-line"></i>
                                </div>
                                <div class="content">
                                    <p class="pera font-16">
                                        <span class="font-700">2,500</span> People Booked Tomorrow
                                        Land Event in the Last 24 hours
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-7 col-lg-6">
                        <div class="about-count-section about-count-before-bg">
                            <div class="banner">
                                <img src="assets/images/gallery/about-banner-three.png" alt="Bizzmirth Holidays">
                            </div>
                            <div class="all-count-list">
                                <div class="details">
                                    <h4 class="count">150k</h4>
                                    <p class="pera">Happy Traveler</p>
                                </div>
                                <div class="divider"></div>
                                <div class="details">
                                    <h4 class="count">95.7%</h4>
                                    <p class="pera">Satisfaction Rate</p>
                                </div>
                                <div class="divider"></div>
                                <div class="details">
                                    <h4 class="count">5000+</h4>
                                    <p class="pera">Tour Completed</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section> -->
        <!--/ End-of About US-->

       

        
        <!-- Explore S t a r t -->
        <!-- <section class="explore-area section-padding2">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xl-7 col-lg-7">
                        <div class="section-title text-center mx-430 mx-auto position-relative mb-60">
                            <span class="highlights">Explore The Word</span>
                            <h4 class="title">
                                Our Best Offer Package For You
                            </h4>
                        </div>
                    </div>
                </div>
                <div class="row g-4">
                    <div class="col-xl-5 col-lg-5 col-md-6">
                        <div class="all-explore" id="v-pills-tab-three" role="tablist" aria-orientation="vertical">
                            <div class="explore-btn active" id="pills-explore-one-tab" data-bs-toggle="pill"
                                data-bs-target="#pills-explore-one" role="tab" aria-controls="pills-explore-one"
                                aria-selected="true">
                                <div class="d-flex gap-16 align-items-center">
                                    <div class="explore-icon">
                                        <img src="assets/images/icon/explore-1.svg" alt="Bizzmirth Holidays">
                                    </div>
                                    <h4 class="name">Fishing & Swimming</h4>
                                </div>
                            </div>
                            <div class="explore-btn" id="pills-explore-two-tab" data-bs-toggle="pill"
                                data-bs-target="#pills-explore-two" role="tab" aria-controls="pills-explore-two"
                                aria-selected="true">
                                <div class="d-flex gap-16 align-items-center">
                                    <div class="explore-icon">
                                        <img src="assets/images/icon/explore-2.svg" alt="Bizzmirth Holidays">
                                    </div>
                                    <h4 class="name">Music & Relaxing</h4>
                                </div>
                            </div>
                            <div class="explore-btn" id="pills-explore-three-tab" data-bs-toggle="pill"
                                data-bs-target="#pills-explore-three" role="tab" aria-controls="pills-explore-three"
                                aria-selected="true">
                                <div class="d-flex gap-16 align-items-center">
                                    <div class="explore-icon">
                                        <img src="assets/images/icon/explore-3.svg" alt="Bizzmirth Holidays">
                                    </div>
                                    <h4 class="name">Trailers & Sports</h4>
                                </div>
                            </div>
                            <div class="explore-btn" id="pills-explore-four-tab" data-bs-toggle="pill"
                                data-bs-target="#pills-explore-four" role="tab" aria-controls="pills-explore-four"
                                aria-selected="true">
                                <div class="d-flex gap-16 align-items-center">
                                    <div class="explore-icon">
                                        <img src="assets/images/icon/explore-4.svg" alt="Bizzmirth Holidays">
                                    </div>
                                    <h4 class="name">Mountain & Hill Hiking</h4>
                                </div>
                            </div>
                            <div class="explore-btn" id="pills-explore-five-tab" data-bs-toggle="pill"
                                data-bs-target="#pills-explore-five" role="tab" aria-controls="pills-explore-five"
                                aria-selected="true">
                                <div class="d-flex gap-16 align-items-center">
                                    <div class="explore-icon">
                                        <img src="assets/images/icon/explore-5.svg" alt="Bizzmirth Holidays">
                                    </div>
                                    <h4 class="name">Paragliding Tours</h4>
                                </div>
                            </div>
                            <div class="explore-btn" id="pills-explore-six-tab" data-bs-toggle="pill"
                                data-bs-target="#pills-explore-six" role="tab" aria-controls="pills-explore-six"
                                aria-selected="true">
                                <div class="d-flex gap-16 align-items-center">
                                    <div class="explore-icon">
                                        <img src="assets/images/icon/explore-1.svg" alt="Bizzmirth Holidays">
                                    </div>
                                    <h4 class="name">Music & Relaxing</h4>
                                </div>
                            </div>
                            <div class="explore-btn" id="pills-explore-seven-tab" data-bs-toggle="pill"
                                data-bs-target="#pills-explore-seven" role="tab" aria-controls="pills-explore-seven"
                                aria-selected="true">
                                <div class="d-flex gap-16 align-items-center">
                                    <div class="explore-icon">
                                        <img src="assets/images/icon/explore-2.svg" alt="Bizzmirth Holidays">
                                    </div>
                                    <h4 class="name">Mountain & Hill Hiking</h4>
                                </div>
                            </div>
                            <div class="explore-btn" id="pills-explore-eight-tab" data-bs-toggle="pill"
                                data-bs-target="#pills-explore-eight" role="tab" aria-controls="pills-explore-eight"
                                aria-selected="true">
                                <div class="d-flex gap-16 align-items-center">
                                    <div class="explore-icon">
                                        <img src="assets/images/icon/explore-1.svg" alt="Bizzmirth Holidays">
                                    </div>
                                    <h4 class="name">Fishing & Swimming</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-7 col-lg-7 col-md-6">
                        <div class="tab-content" id="v-pills-tabContent-three">
                            <div class="tab-pane fade show active" id="pills-explore-one" role="tabpanel"
                                aria-labelledby="pills-explore-one">
                                <div class="explore-conntent">
                                    <h4 class="title">Trailers & Sports</h4>
                                    <p class="pera">
                                        Lorem ipsum dolor sit amet consectetur. Nullam amet at sed
                                        dui tellus tempor pretium tincidunt. Id amet sit viverra
                                        dolor consectetur elementum. Non at volutpat aliquam ac ac
                                        at amet. Ut semper semper sit aliquam penatibus dolor
                                        tortor nisl.
                                    </p>
                                    <ul class="expect-list">
                                        <li class="list">
                                            Lorem ipsum dolor sit amet consectetur. Platea urna
                                            hendrerit dui eget velit sollicitudin orci. Non sit
                                            lorem dolor placerat faucibus.
                                        </li>
                                        <li class="list">
                                            Lorem ipsum dolor sit amet consectetur. Platea urna
                                            hendrerit dui eget velit sollicitudin orci.
                                        </li>
                                    </ul>
                                </div>
                                <div class="explore-banner">
                                    <img src="assets/images/gallery/about.png" alt="Bizzmirth Holidays">
                                </div>
                            </div>
                            <div class="tab-pane fade" id="pills-explore-two" role="tabpanel"
                                aria-labelledby="pills-explore-two">
                                <div class="explore-conntent">
                                    <h4 class="title">Trailers & Sports</h4>
                                    <p class="pera">
                                        Lorem ipsum dolor sit amet consectetur. Nullam amet at sed
                                        dui tellus tempor pretium tincidunt. Id amet sit viverra
                                        dolor consectetur elementum. Non at volutpat aliquam ac ac
                                        at amet. Ut semper semper sit aliquam penatibus dolor
                                        tortor nisl.
                                    </p>
                                    <ul class="expect-list">
                                        <li class="list">
                                            Lorem ipsum dolor sit amet consectetur. Platea urna
                                            hendrerit dui eget velit sollicitudin orci. Non sit
                                            lorem dolor placerat faucibus.
                                        </li>
                                        <li class="list">
                                            Lorem ipsum dolor sit amet consectetur. Platea urna
                                            hendrerit dui eget velit sollicitudin orci.
                                        </li>
                                    </ul>
                                </div>
                                <div class="explore-banner">
                                    <img src="assets/images/gallery/music.png" alt="Bizzmirth Holidays">
                                </div>
                            </div>
                            <div class="tab-pane fade" id="pills-explore-three" role="tabpanel"
                                aria-labelledby="pills-explore-three">
                                <div class="explore-conntent">
                                    <h4 class="title">Trailers & Sports</h4>
                                    <p class="pera">
                                        Lorem ipsum dolor sit amet consectetur. Nullam amet at sed
                                        dui tellus tempor pretium tincidunt. Id amet sit viverra
                                        dolor consectetur elementum. Non at volutpat aliquam ac ac
                                        at amet. Ut semper semper sit aliquam penatibus dolor
                                        tortor nisl.
                                    </p>
                                    <ul class="expect-list">
                                        <li class="list">
                                            Lorem ipsum dolor sit amet consectetur. Platea urna
                                            hendrerit dui eget velit sollicitudin orci. Non sit
                                            lorem dolor placerat faucibus.
                                        </li>
                                        <li class="list">
                                            Lorem ipsum dolor sit amet consectetur. Platea urna
                                            hendrerit dui eget velit sollicitudin orci.
                                        </li>
                                    </ul>
                                </div>
                                <div class="explore-banner">
                                    <img src="assets/images/gallery/sports.png" alt="Bizzmirth Holidays">
                                </div>
                            </div>
                            <div class="tab-pane fade" id="pills-explore-four" role="tabpanel"
                                aria-labelledby="pills-explore-four">
                                <div class="explore-conntent">
                                    <h4 class="title">Trailers & Sports</h4>
                                    <p class="pera">
                                        Lorem ipsum dolor sit amet consectetur. Nullam amet at sed
                                        dui tellus tempor pretium tincidunt. Id amet sit viverra
                                        dolor consectetur elementum. Non at volutpat aliquam ac ac
                                        at amet. Ut semper semper sit aliquam penatibus dolor
                                        tortor nisl.
                                    </p>
                                    <ul class="expect-list">
                                        <li class="list">
                                            Lorem ipsum dolor sit amet consectetur. Platea urna
                                            hendrerit dui eget velit sollicitudin orci. Non sit
                                            lorem dolor placerat faucibus.
                                        </li>
                                        <li class="list">
                                            Lorem ipsum dolor sit amet consectetur. Platea urna
                                            hendrerit dui eget velit sollicitudin orci.
                                        </li>
                                    </ul>
                                </div>
                                <div class="explore-banner">
                                    <img src="assets/images/gallery/hiking.png" alt="Bizzmirth Holidays">
                                </div>
                            </div>
                            <div class="tab-pane fade" id="pills-explore-five" role="tabpanel"
                                aria-labelledby="pills-explore-five">
                                <div class="explore-conntent">
                                    <h4 class="title">Trailers & Sports</h4>
                                    <p class="pera">
                                        Lorem ipsum dolor sit amet consectetur. Nullam amet at sed
                                        dui tellus tempor pretium tincidunt. Id amet sit viverra
                                        dolor consectetur elementum. Non at volutpat aliquam ac ac
                                        at amet. Ut semper semper sit aliquam penatibus dolor
                                        tortor nisl.
                                    </p>
                                    <ul class="expect-list">
                                        <li class="list">
                                            Lorem ipsum dolor sit amet consectetur. Platea urna
                                            hendrerit dui eget velit sollicitudin orci. Non sit
                                            lorem dolor placerat faucibus.
                                        </li>
                                        <li class="list">
                                            Lorem ipsum dolor sit amet consectetur. Platea urna
                                            hendrerit dui eget velit sollicitudin orci.
                                        </li>
                                    </ul>
                                </div>
                                <div class="explore-banner">
                                    <img src="assets/images/gallery/paragliding.png" alt="Bizzmirth Holidays">
                                </div>
                            </div>
                            <div class="tab-pane fade" id="pills-explore-six" role="tabpanel"
                                aria-labelledby="pills-explore-six">
                                <div class="explore-conntent">
                                    <h4 class="title">Trailers & Sports</h4>
                                    <p class="pera">
                                        Lorem ipsum dolor sit amet consectetur. Nullam amet at sed
                                        dui tellus tempor pretium tincidunt. Id amet sit viverra
                                        dolor consectetur elementum. Non at volutpat aliquam ac ac
                                        at amet. Ut semper semper sit aliquam penatibus dolor
                                        tortor nisl.
                                    </p>
                                    <ul class="expect-list">
                                        <li class="list">
                                            Lorem ipsum dolor sit amet consectetur. Platea urna
                                            hendrerit dui eget velit sollicitudin orci. Non sit
                                            lorem dolor placerat faucibus.
                                        </li>
                                        <li class="list">
                                            Lorem ipsum dolor sit amet consectetur. Platea urna
                                            hendrerit dui eget velit sollicitudin orci.
                                        </li>
                                    </ul>
                                </div>
                                <div class="explore-banner">
                                    <img src="assets/images/gallery/music.png" alt="Bizzmirth Holidays">
                                </div>
                            </div>
                            <div class="tab-pane fade" id="pills-explore-seven" role="tabpanel"
                                aria-labelledby="pills-explore-seven">
                                <div class="explore-conntent">
                                    <h4 class="title">Trailers & Sports</h4>
                                    <p class="pera">
                                        Lorem ipsum dolor sit amet consectetur. Nullam amet at sed
                                        dui tellus tempor pretium tincidunt. Id amet sit viverra
                                        dolor consectetur elementum. Non at volutpat aliquam ac ac
                                        at amet. Ut semper semper sit aliquam penatibus dolor
                                        tortor nisl.
                                    </p>
                                    <ul class="expect-list">
                                        <li class="list">
                                            Lorem ipsum dolor sit amet consectetur. Platea urna
                                            hendrerit dui eget velit sollicitudin orci. Non sit
                                            lorem dolor placerat faucibus.
                                        </li>
                                        <li class="list">
                                            Lorem ipsum dolor sit amet consectetur. Platea urna
                                            hendrerit dui eget velit sollicitudin orci.
                                        </li>
                                    </ul>
                                </div>
                                <div class="explore-banner">
                                    <img src="assets/images/gallery/hiking.png" alt="Bizzmirth Holidays">
                                </div>
                            </div>
                            <div class="tab-pane fade" id="pills-explore-eight" role="tabpanel"
                                aria-labelledby="pills-explore-eight">
                                <div class="explore-conntent">
                                    <h4 class="title">Trailers & Sports</h4>
                                    <p class="pera">
                                        Lorem ipsum dolor sit amet consectetur. Nullam amet at sed
                                        dui tellus tempor pretium tincidunt. Id amet sit viverra
                                        dolor consectetur elementum. Non at volutpat aliquam ac ac
                                        at amet. Ut semper semper sit aliquam penatibus dolor
                                        tortor nisl.
                                    </p>
                                    <ul class="expect-list">
                                        <li class="list">
                                            Lorem ipsum dolor sit amet consectetur. Platea urna
                                            hendrerit dui eget velit sollicitudin orci. Non sit
                                            lorem dolor placerat faucibus.
                                        </li>
                                        <li class="list">
                                            Lorem ipsum dolor sit amet consectetur. Platea urna
                                            hendrerit dui eget velit sollicitudin orci.
                                        </li>
                                    </ul>
                                </div>
                                <div class="explore-banner">
                                    <img src="assets/images/gallery/about.png" alt="Bizzmirth Holidays">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section> -->
        <!--/ End of Explore -->

        

        <!-- Brand S t a r t -->
        <!-- <div class="brand-area">
            <div class="container">
                <div class="swiper brandSwiper-active">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <img src="assets/images/brand/brand-1.jpeg" alt="Bizzmirth Holidays">
                        </div>
                        <div class="swiper-slide">
                            <img src="assets/images/brand/brand-2.jpg" alt="Bizzmirth Holidays">
                        </div>
                        <div class="swiper-slide">
                            <img src="assets/images/brand/brand-3.jpg" alt="Bizzmirth Holidays">
                        </div>
                        <div class="swiper-slide">
                            <img src="assets/images/brand/brand-4.png" alt="Bizzmirth Holidays">
                        </div>
                        <div class="swiper-slide">
                            <img src="assets/images/brand/brand-5.png" alt="Bizzmirth Holidays">
                        </div>
                        <div class="swiper-slide">
                            <img src="assets/images/brand/brand-1.jpeg" alt="Bizzmirth Holidays">
                        </div>
                        <div class="swiper-slide">
                            <img src="assets/images/brand/brand-2.jpg" alt="Bizzmirth Holidays">
                        </div>
                    </div>
                </div>
            </div>
        </div> -->
        <!--/ End of Brand -->

        <!-- News S t a r t -->
        <!-- <section class="news-area section-padding2">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xl-7 col-lg-7">
                        <div class="section-title text-center mx-605 mx-auto position-relative mb-60">
                            <span class="highlights">Destination</span>
                            <h4 class="title">
                                Latest News & Articles From The Blog Posts
                            </h4>
                        </div>
                    </div>
                </div>
                <div class="row g-4">
                    <div class="col-xl-4 col-lg-4 col-sm-6">
                        <article class="news-card-two">
                            <figure class="news-banner-two imgEffect">
                                <a href="#"><img src="assets/images/news/news-4.png"
                                        alt="Bizzmirth Holidays"></a>
                            </figure>
                            <div class="news-content">
                                <div class="heading">
                                    <span class="heading-pera">Tour Guide</span>
                                </div>
                                <h4 class="title">
                                    <a href="#">The World is a Book and Those Who do not Travel Read
                                        Only
                                        One Page.</a>
                                </h4>
                                <div class="news-info">
                                    <div class="d-flex gap-10 align-items-center">
                                        <div class="all-user">
                                            <div class="happy-user">
                                                <img src="assets/images/hero/user-1.jpeg" alt="Bizzmirth Holidays">
                                            </div>
                                            <div class="happy-user">
                                                <img src="assets/images/hero/user-2.png" alt="Bizzmirth Holidays">
                                            </div>
                                            <div class="happy-user">
                                                <img src="assets/images/hero/user-3.png" alt="Bizzmirth Holidays">
                                            </div>
                                            <div class="happy-user">
                                                <img src="assets/images/hero/user-4.jpeg" alt="Bizzmirth Holidays">
                                            </div>
                                        </div>
                                    </div>
                                    <p class="time">10 min read</p>
                                </div>
                            </div>
                        </article>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-sm-6">
                        <article class="news-card-two">
                            <figure class="news-banner-two imgEffect">
                                <a href="#"><img src="assets/images/news/news-5.png"
                                        alt="Bizzmirth Holidays"></a>
                            </figure>
                            <div class="news-content">
                                <div class="heading">
                                    <span class="heading-pera">Tour Guide</span>
                                </div>
                                <h4 class="title">
                                    <a href="#">The World is a Book and Those Who do not Travel Read
                                        Only
                                        One Page.</a>
                                </h4>
                                <div class="news-info">
                                    <div class="d-flex gap-10 align-items-center">
                                        <div class="all-user">
                                            <div class="happy-user">
                                                <img src="assets/images/hero/user-1.jpeg" alt="Bizzmirth Holidays">
                                            </div>
                                            <div class="happy-user">
                                                <img src="assets/images/hero/user-2.png" alt="Bizzmirth Holidays">
                                            </div>
                                            <div class="happy-user">
                                                <img src="assets/images/hero/user-3.png" alt="Bizzmirth Holidays">
                                            </div>
                                            <div class="happy-user">
                                                <img src="assets/images/hero/user-4.jpeg" alt="Bizzmirth Holidays">
                                            </div>
                                        </div>
                                    </div>
                                    <p class="time">10 min read</p>
                                </div>
                            </div>
                        </article>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-sm-6">
                        <article class="news-card-two">
                            <figure class="news-banner-two imgEffect">
                                <a href="#"><img src="assets/images/news/news-6.png"
                                        alt="Bizzmirth Holidays"></a>
                            </figure>
                            <div class="news-content">
                                <div class="heading">
                                    <span class="heading-pera">Tour Guide</span>
                                </div>
                                <h4 class="title">
                                    <a href="#">The World is a Book and Those Who do not Travel Read
                                        Only
                                        One Page.</a>
                                </h4>
                                <div class="news-info">
                                    <div class="d-flex gap-10 align-items-center">
                                        <div class="all-user">
                                            <div class="happy-user">
                                                <img src="assets/images/hero/user-1.jpeg" alt="Bizzmirth Holidays">
                                            </div>
                                            <div class="happy-user">
                                                <img src="assets/images/hero/user-2.png" alt="Bizzmirth Holidays">
                                            </div>
                                            <div class="happy-user">
                                                <img src="assets/images/hero/user-3.png" alt="Bizzmirth Holidays">
                                            </div>
                                            <div class="happy-user">
                                                <img src="assets/images/hero/user-4.jpeg" alt="Bizzmirth Holidays">
                                            </div>
                                        </div>
                                    </div>
                                    <p class="time">10 min read</p>
                                </div>
                            </div>
                        </article>
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
        </section> -->
        <!--/ End of News -->

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
    </script>
    <!-- Carousel section start -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {

            const mainCarouselEl = document.querySelector('#mainCarousel');
            const previewCarouselEl = document.querySelector('#previewCarousel');

            const AUTO_PLAY_INTERVAL = 4000;

            const mainCarousel = new bootstrap.Carousel(mainCarouselEl, {
                interval: AUTO_PLAY_INTERVAL,
                wrap: true,
                ride: false
            });

            const previewCarousel = new bootstrap.Carousel(previewCarouselEl, {
                interval: false,
                wrap: true,
                ride: false
            });

            // Start autoplay ONLY on main carousel
            mainCarousel.cycle();

            // ==========================
            // SYNC PREVIEW WITH MAIN
            // ==========================
            mainCarouselEl.addEventListener('slide.bs.carousel', function (e) {
                previewCarousel.to(e.to);
            });

            // ==========================
            // PREV / NEXT BUTTONS
            // ==========================
            document.getElementById('nextBtn').addEventListener('click', () => {
                mainCarousel.next();
            });

            document.getElementById('prevBtn').addEventListener('click', () => {
                mainCarousel.prev();
            });

            // ==========================
            // PAUSE ON HOVER (ONLY CAROUSELS)
            // ==========================
            const pauseOnHover = (el) => {
                el.addEventListener('mouseenter', () => {
                    mainCarousel.pause();
                });

                el.addEventListener('mouseleave', () => {
                    mainCarousel.cycle();
                });
            };

            pauseOnHover(mainCarouselEl);
            pauseOnHover(previewCarouselEl);

        });
    </script>
    <!-- Carousel section end -->
</body>

<!-- Mirrored from Bizzmirth Holidayso.vercel.app/template/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 12 Jul 2024 06:52:47 GMT -->
</html>