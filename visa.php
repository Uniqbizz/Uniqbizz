<?php 
    session_start();
?>
<!DOCTYPE html>
<html lang="zxx" dir="lrt">

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
        <meta logo="assets/images/logo/logo.png">
        <meta white-logo="assets/images/logo/logo-white.png">
        
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta name="description" content="Travello - Multipurpose travel and tour booking.These template is suitable for  travel agency , tour, travel website , tour operator , tourism , booking  trip or adventure website. ">
        <meta name="keywords" content="travel, trip booking,tour, hotel, tour guide, tourism, blog, flight, travel agency, tourism agency, accommodation, tour website">
        <meta name="author" content="inittheme">
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
        <!-- RTL CSS::When Need RTL Uncomments File -->
        <!-- <link rel="stylesheet" type="text/css" href="assets/css/rtl.css"> -->
        <!-- Bootstrap Icons -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
        <!-- Animated Cursor GSAP -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.13.0/gsap.min.js"></script>
        
        <style>
            .visaPackage {
                background: var(--secondary-border);
            }
            .visaPackage .visaPackageCard .visaPackageImg{
                overflow: hidden;
                border-radius: 50%;
            }
            .visaPackage .visaPackageCard .visaPackageImg img {
                width: 270px;
                height: 270px; 
                border-radius: 50%;
            }
            .visaPackageCard {
                position: relative;
            }
            .visaPackageContent {
                position: absolute;
                bottom: -5px;
                left: -2px;
                width: 265px;
            }
            /* image transition */
            .visaPackage .visaPackageCard .visaPackageImg img{
                width: 100%;
                transition: all 0.5s ease-in;
            }

            /* hover image effect */
            .visaPackage .visaPackageCard:hover .visaPackageImg img{
                transform: scale(1.08);
            }

            /* content transition */
            .visaPackage .visaPackageCard .visaPackageContent{
                transition: all 0.5s ease-out;
            }

            /* hover background */
            .visaPackage .visaPackageCard:hover .visaPackageContent{
                background-color: #1781fe;
                color: #fff;
            }

            /* link color on hover */
            .visaPackage .visaPackageCard:hover .visaPackageContent a{
                color: #fff;
            }

            /* processing text color */
            .visaPackage .visaPackageCard:hover .visaPackageContent .text-tertiary{
                color: #fff !important;
            }
            /* Animated Cursor Start */
            * {
                box-sizing: border-box;
                padding: 0;
                margin: 0;
            }

            .cursor {
                width: 100%;
                height: 100%;
                background: transparent;
            }

            .cursor-example {
                position: fixed;
                top: 0;
                left: 0;
                width: 25px;
                height: 25px;
                border-radius: 100%;
                background-color: #73b0f6;
                opacity: 0.3;
                z-index: 1000;
            }
            /* End Animated Cursor */
            .whyChooseBizzmirth .whyChooseCard {
                padding: 40px 20px;
                background-color: #E6F5A9;
                border-radius: 20px;
            }
            .whyChooseBizzmirth .whyChooseCard.two {
                background-color: #F0F0F0;
            }
            .whyChooseBizzmirth .whyChooseCard.three {
                background-color: #E2E2FF;
            }
            .whyChooseBizzmirth .whyChooseCard.four {
                background-color: #BDEBCE;
            }
            .whyChooseBizzmirth .whyChooseCard svg {
                margin-bottom: 50px;
            }

            .whyChooseCard svg {
                transition: transform 0.3s ease;
            }

            /* Hover trigger */
            .whyChooseCard:hover svg {
                animation: bounceIn 0.6s ease;
            }
            
            .visaContactSection .contact-wrapper {
                padding-left: 40px;
            }
            .visaContactSection .contact-wrapper {
                background-image: 
                    linear-gradient(180deg, rgba(242,242,255,0.7) 0%, rgba(242,242,255,0.5) 100%), /* gradient overlay */
                    url('assets/images/visa/visa-contact-bg.png'); /* actual image */
                
                background-size: cover, cover;
                background-repeat: no-repeat, no-repeat;
                background-position: center, center;

                padding-left: 60px;
                border-radius: 20px;
                display: flex;
                align-items: flex-end;
                justify-content: space-between;
                gap: 10px;
            }
            .visaContactSection .contact-wrapper .contact-content {
                max-width: 510px;
                width: 100%;
                padding: 50px 0;
            }
            .contact-content .section-title span {
                color: #1b2072;
                font-family: "Roboto", sans-serif;
                font-weight: 600;
                font-size: 18px;
                line-height: 1;
                display: block;
                margin-bottom: 20px;
            }
            .section-title h2 {
                color: #110f0f;
                font-family: "Poppins", sans-serif;
                font-size: 40px;
                font-weight: 600;
                line-height: 1.1;
                margin-bottom: 0;
            }
            .scheduleBtn {
                background-color: #1b2072;
                font-weight: 600;
                font-size: 15px;
                color: #fff;
                letter-spacing: 0.48px;
                line-height: 1;
                padding: 20px 24px;
                border-radius: 10px;
                position: relative;
                align-items: center;
                display: inline-flex;
                transition: all 0.2s cubic-bezier(0.455, 0.03, 0.515, 0.955);
                overflow: hidden;
                z-index: 1;
                white-space: nowrap;
                margin-top: 50px;
            }
            .scheduleBtn::before {
                content: "";
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background-size: 102% 102%;
                border-radius: inherit;
                transition: all 0.2s cubic-bezier(0.455, 0.03, 0.515, 0.955);
                opacity: 0;
                z-index: -1;
            }
            .scheduleBtn::after {
                content: "";
                position: absolute;
                z-index: 1;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                transform: translateY(110%);
                background-color: #110f0f;
                overflow: hidden;
                transition: opacity 0.5s, transform 0.5s;
                z-index: -1;
            }
            .scheduleBtn:hover::after {
                transform: translateY(0);
            }
            .scheduleBtn span {
                transition: opacity 0.3s, transform 0.3s;
                transition-timing-function: cubic-bezier(0.455, 0.03, 0.515, 0.955);
                background-color: transparent;
                width: 100%;
                display: flex;
                align-items: center;
                justify-content: center;
                gap: 8px;
                position: relative;
                z-index: 2;
            }
            .scheduleBtn span svg {
                fill: #fff;
                transition: 0.5s;
            }
            .scheduleBtn span:nth-child(2) {
                position: absolute;
                top: 50%;
                left: 0;
                opacity: 0;
                transform: translate(0, 100%);
                transition: opacity 0.3s, transform 0.3s;
                transition-timing-function: cubic-bezier(0.455, 0.03, 0.515, 0.955);
                white-space: nowrap;
            }
            .contact-img img {
                width:540px !important;
                height: 350px !important;
            }
            .faq-wrap .accordion .accordion-item {
                border-radius: 10px;
                border: none;
                margin-bottom: 25px;
                background-color: #F0F0F0;
                border: 1px solid transparent;
            }
            .faq-wrap .accordion .accordion-item .accordion-header {
                border-radius: 10px;
                background-color: transparent;
            }
            .faq-wrap .accordion .accordion-item .accordion-header .accordion-button {
                color: #110f0f;
                font-family: "Poppins", sans-serif;
                font-size: 18px;
                font-weight: 600;
                line-height: 1.4;
                text-align: left;
                padding: 18px 30px;
                border-radius: 10px;
                background-color: transparent;
            }
            .faq-wrap .accordion .accordion-item .accordion-header .accordion-button:not(.collapsed) {
                box-shadow: none;
                background-color: #fff;
                border: 1px solid #1781fe;
                border-bottom: none;
                border-radius: 10px 10px 0 0;
            }
            .faq-wrap .accordion .accordion-item .accordion-header .accordion-button:focus {
                border-radius: 10px;
                box-shadow: none;
                border-bottom: none;
                border-radius: 10px 10px 0 0;
            }
            .faq-wrap .accordion .accordion-item .accordion-header .accordion-button::after {
                display: flex;
                align-items: center;
                justify-content: center;
                color: #525252;
                content: "\F229";
                font-family: bootstrap-icons;
                background-image: none;
                font-weight: 600;
                font-size: 12px;
                right: 30px;
                transition: 0.5s;
            }
            .faq-wrap .accordion .accordion-item .accordion-header .accordion-button:not(.collapsed)::after {
                font-family: bootstrap-icons !important;
                content: "\F229";
                color: #1781fe;
                border: none;
            }
            .faq-wrap .accordion .accordion-item .accordion-body {
                padding: 0px 30px 20px 30px;
                font-family: "Roboto", sans-serif;
                font-size: 18px;
                font-weight: 400;
                line-height: 1.5;
                text-align: left;
                color: #525252;
                border: 1px solid #1781fe;
                border-top: none;
                background-color: #fff;
                border-radius: 0 0 10px 10px;
            }
            
            @media (max-width: 1199px) {
                .visaPackageContent {
                    position: absolute;
                    bottom: -5px;
                    left: -2px;
                    width: 275px;
                }
            }
            @media (max-width: 991px) {
                .visaContactSection .contact-wrapper .contact-img img {
                    display: none;
                }
            }

            @media (max-width: 767px) {
                .visaPackage .visaPackageCard .visaPackageImg img {
                    width: 230px;
                    height: 230px; 
                    border-radius: 50%;
                }
                .visaPackageContent {
                    position: absolute;
                    bottom: -5px;
                    left: -6px;
                    width: 245px;
                }
            }
            @media (max-width: 575px) {
                .visaPackage .visaPackageCard .visaPackageImg img {
                    width: 270px;
                    height: 270px; 
                    border-radius: 50%;
                }
                .visaPackageContent {
                    position: absolute;
                    bottom: -5px;
                    left: -35px;
                    width: 340px;
                }
            }
        </style>
    </head>
    <body>
        <!-- /* Animated Cursor Start */ -->
        <div class="cursor"></div>

        <div class="cursor-example"></div>
        <!-- /* End of Animated Cursor */ -->
        <?php include_once "header.php" ?>
        <main>
            
            <!-- Breadcrumbs S t a r t -->
            <section class="breadcrumbs-area breadcrumb-bg">
                <div class="container">
                    <h1 class="title wow fadeInUp" data-wow-delay="0.0s">Visa</h1>
                    <div class="breadcrumb-text">
                        <nav aria-label="breadcrumb" class="breadcrumb-nav wow fadeInUp" data-wow-delay="0.1s">
                            <ul class="breadcrumb listing">
                                <li class="breadcrumb-item single-list"><a href="index.php" class="single">Home</a></li>
                                <li class="breadcrumb-item single-list" aria-current="page">
                                    <a href="javascript:void(0)" class="single active">Visa</a></li>
                            </ul>
                        </nav>
                    </div>
                </div>

            </section>
            <!--/ End-of Breadcrumbs-->

            <!-- Visa Card Section Start -->
            <div class="visaPackage pt-50 pb-50">
                <div class="container">
                    <div class="row gy-5" id="visaCards">
                    </div>
                </div>
            </div>
            <!-- End of Visa Card Section -->
            
            <!-- Why choose Bizzmirth Holidays Start -->
            <div class="whyChooseBizzmirth pt-50 pb-50">
                <div class="container">
                    <div class="row justify-content-center mb-50 wow animate fadeInDown" data-wow-delay="200ms" data-wow-duration="1500ms" >
                        <div class="col-lg-8">
                            <div class="text-center">
                                <h2 class="fw-bold">Why Choose Bizzmirth Holidays?</h2>
                            </div>
                        </div>
                    </div>
                    <div class="row g-xl-4 g-lg-3 g-4">
                        <div class="col-lg-3 col-sm-6 wow animate fadeInDown" data-wow-delay="200ms" data-wow-duration="1500ms">
                            <div class="whyChooseCard">
                                <svg width="50" height="50" viewBox="0 0 50 50" xmlns="http://www.w3.org/2000/svg">
                                    <g>
                                        <path d="M50.0003 25C50.0003 26.7257 48.6007 28.1248 46.875 28.1248C45.1455 28.1248 43.7498 26.7258 43.7498 25.0001C43.7498 23.2749 45.1455 21.8749 46.875 21.8749C48.6007 21.8749 50.0003 23.2748 50.0003 25ZM43.7498 9.375C43.7498 11.0999 42.3508 12.4998 40.6251 12.4998C38.8956 12.4998 37.4999 11.0999 37.4999 9.37512C37.4999 7.6499 38.8956 6.24988 40.6251 6.24988C42.3507 6.24988 43.7498 7.64978 43.7498 9.375ZM40.625 43.7498C38.8975 43.7498 37.5 42.3527 37.5 40.6251C37.5 38.8956 38.8975 37.4999 40.625 37.4999C42.3507 37.4999 43.7498 38.8956 43.7498 40.6251C43.7498 42.3507 42.3508 43.7498 40.6251 43.7498H40.625ZM22.5344 27.0829C21.6727 29.5044 19.3839 31.25 16.6669 31.25C13.2156 31.25 10.4169 28.4504 10.4169 25C10.4169 21.5492 13.2156 18.7502 16.6669 18.7502C19.3844 18.7502 21.6732 20.4954 22.5344 22.9168H29.6874L35.4171 0L0 25L35.4171 50.0003L29.6874 27.0829H22.5344Z"></path>
                                    </g>
                                </svg>
                                <h4 class="fw-bold pb-2">Expert Visa Guidance</h4>
                                <p class="">Our visa specialists guide you through the entire process.</p>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6 wow animate fadeInDown" data-wow-delay="200ms" data-wow-duration="1500ms">
                            <div class="whyChooseCard two">
                                <svg width="50" height="50" viewBox="0 0 50 50" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M29.25 29.2502H47.9996V48.0001H29.25V29.2502Z"></path>
                                    <path d="M25.4997 44.2498C15.1442 44.2498 6.75014 35.8545 6.75014 25.5C6.75014 15.1433 15.1448 6.75019 25.4997 6.75019C35.8541 6.75019 44.2493 15.1438 44.2493 25.5H47.9995C47.9995 13.0744 37.9252 3 25.4997 3C13.0737 3 3 13.0744 3 25.5C3 37.9256 13.0737 48 25.4997 48V44.2498Z"></path>
                                    <path d="M25.5 36.75C19.2867 36.75 14.2501 31.7128 14.2501 25.5C14.2501 19.2855 19.2867 14.25 25.5 14.25C31.7127 14.25 36.7499 19.2855 36.7499 25.5H40.5C40.5 17.2161 33.7838 10.4998 25.5 10.4998C17.2156 10.4998 10.5 17.2161 10.5 25.5C10.5 33.7839 17.2156 40.5002 25.5 40.5002V36.75Z"></path>
                                    <path d="M25.4997 29.2502C24.758 29.2502 24.033 29.0303 23.4163 28.6182C22.7995 28.2062 22.3189 27.6205 22.035 26.9352C21.7512 26.2499 21.6769 25.4959 21.8216 24.7684C21.9663 24.041 22.3235 23.3727 22.848 22.8483C23.3724 22.3238 24.0406 21.9666 24.7681 21.8219C25.4956 21.6772 26.2496 21.7515 26.9348 22.0353C27.6201 22.3192 28.2058 22.7998 28.6179 23.4166C29.0299 24.0333 29.2499 24.7583 29.2499 25.5001H32.9994C32.9994 21.3584 29.6414 18.0002 25.4997 18.0002C21.357 18.0002 18 21.3584 18 25.5001C18 29.6417 21.357 32.9999 25.4997 32.9999V29.2502Z"></path>
                                </svg>
                                <h4 class="fw-bold pb-2">Documentation Accuracy</h4>
                                <p class="">We ensure all documents are verified before submission.</p>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6 wow animate fadeInDown" data-wow-delay="200ms" data-wow-duration="1500ms">
                            <div class="whyChooseCard three">
                                <svg width="50" height="50" viewBox="0 0 50 50" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M25 25V45.2148H18.8477V31.1523H5.66406V25H25ZM12.6953 37.3047H5.66406V45.2148H12.6953V37.3047ZM44.3359 25V18.8477H31.1523V4.78516H25V25H44.3359ZM37.3047 12.6953H44.3359V4.78516H37.3047V12.6953Z"></path>
                                </svg>
                                <h4 class="fw-bold pb-2">Faster Processing Support</h4>
                                <p class="">Quick response and faster documentation assistance.</p>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6 wow animate fadeInDown" data-wow-delay="200ms" data-wow-duration="1500ms">
                            <div class="whyChooseCard four">
                                <svg width="50" height="50" viewBox="0 0 50 50" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M28.278 44.2914C28.1869 44.6838 27.9655 45.0339 27.65 45.2845C27.3345 45.5351 26.9435 45.6715 26.5406 45.6715H23.4595C22.9864 45.6715 22.5327 45.4835 22.1982 45.149C21.8637 44.8145 21.6758 44.3608 21.6758 43.8877V43.3428C21.6758 42.8697 21.8638 42.4161 22.1983 42.0816C22.5328 41.7471 22.9864 41.5591 23.4595 41.559H26.5406C26.9435 41.559 27.3345 41.6954 27.65 41.946C27.9655 42.1966 28.1869 42.5467 28.278 42.9391H33.6433C34.5906 42.9391 35.5287 42.7525 36.4039 42.39C37.2791 42.0275 38.0744 41.4961 38.7443 40.8262C39.4142 40.1564 39.9455 39.3611 40.308 38.4859C40.6706 37.6106 40.8572 36.6726 40.8571 35.7252V33.9105C41.2654 34.0648 41.6982 34.1439 42.1347 34.1438H42.2094V35.7252C42.2093 37.9971 41.3068 40.1759 39.7004 41.7823C38.0939 43.3888 35.9151 44.2913 33.6433 44.2914H28.278ZM7.86299 17.4125C8.22231 13.8269 9.90091 10.5027 12.573 8.08498C15.2451 5.66726 18.7202 4.32849 22.3237 4.32849H27.6764C31.2799 4.32843 34.755 5.66718 37.4271 8.0849C40.0992 10.5026 41.7778 13.8269 42.1371 17.4125H42.1347C41.6742 17.4125 41.2228 17.5004 40.803 17.6668C40.5048 14.3914 38.9929 11.3458 36.5641 9.12813C34.1354 6.91042 30.9653 5.68081 27.6764 5.68076H22.3237C19.0348 5.68079 15.8647 6.91039 13.4359 9.12811C11.0072 11.3458 9.49526 14.3914 9.1971 17.6668C8.77322 17.4988 8.32137 17.4125 7.8654 17.4125H7.86299ZM44.1304 18.7648C46.3679 18.7648 48.1818 20.5786 48.1818 22.8163V28.7401C48.1818 30.9777 46.3679 32.7916 44.1304 32.7916H42.1347C41.8376 32.7916 41.5435 32.7331 41.269 32.6195C40.9946 32.5058 40.7453 32.3392 40.5352 32.1291C40.3252 31.9191 40.1586 31.6698 40.0449 31.3953C39.9313 31.1209 39.8728 30.8267 39.8728 30.5297V21.0266C39.8728 20.7296 39.9313 20.4354 40.0449 20.161C40.1586 19.8866 40.3252 19.6372 40.5352 19.4272C40.7453 19.2171 40.9946 19.0505 41.269 18.9369C41.5435 18.8232 41.8376 18.7647 42.1347 18.7648H44.1304ZM5.86964 18.7648H7.8654C8.16244 18.7647 8.45658 18.8232 8.73101 18.9369C9.00544 19.0505 9.2548 19.2171 9.46484 19.4272C9.67488 19.6372 9.84148 19.8866 9.95514 20.161C10.0688 20.4354 10.1273 20.7296 10.1273 21.0266V30.5297C10.1273 30.8267 10.0688 31.1209 9.95514 31.3953C9.84148 31.6698 9.67488 31.9191 9.46484 32.1291C9.2548 32.3392 9.00544 32.5058 8.73101 32.6195C8.45658 32.7331 8.16244 32.7916 7.8654 32.7916H5.86964C3.63212 32.7916 1.81824 30.9777 1.81824 28.7401V22.8163C1.81824 20.5786 3.63212 18.7648 5.86964 18.7648ZM16.4136 31.9192C14.1685 30.0718 12.7764 27.5063 12.7764 24.672C12.7764 19.0499 18.2536 14.4856 25 14.4856C31.7464 14.4856 37.2237 19.0499 37.2237 24.672C37.2237 30.2939 31.7464 34.8583 25 34.8583C22.8763 34.8583 20.8782 34.406 19.1373 33.6107L15.196 36.0165C15.1051 36.0719 14.9985 36.0958 14.8927 36.0845C14.7869 36.0731 14.6878 36.0271 14.6109 35.9536C14.5339 35.8802 14.4833 35.7833 14.467 35.6782C14.4507 35.573 14.4696 35.4654 14.5208 35.3721L16.4136 31.9192ZM25.0006 31.8849C25.4724 31.8849 25.8575 31.4999 25.8575 31.028C25.8575 30.5551 25.4724 30.1701 25.0006 30.1701C24.5277 30.1701 24.1426 30.5551 24.1426 31.028C24.1426 31.4999 24.5277 31.8849 25.0006 31.8849ZM22.2478 22.1438C22.2478 21.3835 22.5558 20.6958 23.0536 20.1969C23.3091 19.941 23.6126 19.738 23.9467 19.5997C24.2808 19.4614 24.639 19.3905 25.0006 19.3911C25.7598 19.3911 26.4486 19.6991 26.9464 20.1969C27.4443 20.6958 27.7523 21.3835 27.7523 22.1438C27.7523 23.7708 26.813 24.3109 26.0114 24.773C25.1286 25.2806 24.3574 25.7242 24.3574 26.9205V28.2427C24.3574 28.3271 24.3741 28.4107 24.4064 28.4887C24.4388 28.5666 24.4862 28.6375 24.5459 28.6971C24.6056 28.7567 24.6765 28.804 24.7546 28.8362C24.8326 28.8684 24.9162 28.8849 25.0006 28.8848C25.0849 28.8848 25.1684 28.8682 25.2463 28.8359C25.3242 28.8037 25.395 28.7564 25.4546 28.6967C25.5142 28.6371 25.5615 28.5663 25.5938 28.4884C25.6261 28.4105 25.6427 28.327 25.6426 28.2427V26.9205C25.6426 26.4606 26.1112 26.1916 26.6482 25.8825C27.7501 25.2491 29.0375 24.5073 29.0375 22.1438C29.0384 21.6135 28.9345 21.0883 28.7316 20.5983C28.5287 20.1084 28.2309 19.6634 27.8553 19.2891C27.1243 18.5581 26.1145 18.1057 25.0006 18.1057C23.8856 18.1057 22.8758 18.5581 22.1447 19.2891C21.7692 19.6634 21.4714 20.1084 21.2685 20.5983C21.0656 21.0883 20.9616 21.6135 20.9625 22.1438C20.9625 22.4985 21.2499 22.787 21.6046 22.787C21.7752 22.787 21.9387 22.7192 22.0594 22.5986C22.18 22.478 22.2477 22.3144 22.2478 22.1438Z"></path>
                                </svg>
                                <h4 class="fw-bold pb-2">Trusted Travel Experts</h4>
                                <p class="">Professional travel consultancy with reliable support.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End of Why choose Bizzmirth Holidays -->
            
            <!-- Need Visa Assistance Start -->
            <div class="visaContactSection pb-50 pt-50">
                <div class="container">
                    <div class="contact-wrapper">
                        <div class="contact-content">
                            <div class="section-title mb-0">
                                <span>Need Visa Assistance?</span>
                                <h2>To Get Visa Assistance, Join Schedule a Meeting.</h2>
                            </div>
                            <a href="contact.php" class="scheduleBtn">
                                <span class="">Schedule a Consultation 
                                    <svg width="10" height="10" viewBox="0 0 10 10" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M9.73535 1.14746C9.57033 1.97255 9.32924 3.26406 9.24902 4.66797C9.16817 6.08312 9.25559 7.5453 9.70214 8.73633C9.84754 9.12406 9.65129 9.55659 9.26367 9.70215C8.9001 9.83849 8.4969 9.67455 8.32812 9.33398L8.29785 9.26367L8.19921 8.98438C7.73487 7.5758 7.67054 5.98959 7.75097 4.58203C7.77875 4.09598 7.82525 3.62422 7.87988 3.17969L1.53027 9.53027C1.23738 9.82317 0.762615 9.82317 0.469722 9.53027C0.176829 9.23738 0.176829 8.76262 0.469722 8.46973L6.83593 2.10254C6.3319 2.16472 5.79596 2.21841 5.25 2.24902C3.8302 2.32862 2.2474 2.26906 0.958003 1.79102L0.704097 1.68945L0.635738 1.65527C0.303274 1.47099 0.157578 1.06102 0.310542 0.704102C0.463655 0.347333 0.860941 0.170391 1.22363 0.28418L1.29589 0.310547L1.48828 0.387695C2.47399 0.751207 3.79966 0.827571 5.16601 0.750977C6.60111 0.670504 7.97842 0.428235 8.86132 0.262695L9.95312 0.0585938L9.73535 1.14746Z">
                                        </path>
                                    </svg>
                                </span>
                                <span class="">Schedule a Consultation 
                                    <svg width="10" height="10" viewBox="0 0 10 10" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M9.73535 1.14746C9.57033 1.97255 9.32924 3.26406 9.24902 4.66797C9.16817 6.08312 9.25559 7.5453 9.70214 8.73633C9.84754 9.12406 9.65129 9.55659 9.26367 9.70215C8.9001 9.83849 8.4969 9.67455 8.32812 9.33398L8.29785 9.26367L8.19921 8.98438C7.73487 7.5758 7.67054 5.98959 7.75097 4.58203C7.77875 4.09598 7.82525 3.62422 7.87988 3.17969L1.53027 9.53027C1.23738 9.82317 0.762615 9.82317 0.469722 9.53027C0.176829 9.23738 0.176829 8.76262 0.469722 8.46973L6.83593 2.10254C6.3319 2.16472 5.79596 2.21841 5.25 2.24902C3.8302 2.32862 2.2474 2.26906 0.958003 1.79102L0.704097 1.68945L0.635738 1.65527C0.303274 1.47099 0.157578 1.06102 0.310542 0.704102C0.463655 0.347333 0.860941 0.170391 1.22363 0.28418L1.29589 0.310547L1.48828 0.387695C2.47399 0.751207 3.79966 0.827571 5.16601 0.750977C6.60111 0.670504 7.97842 0.428235 8.86132 0.262695L9.95312 0.0585938L9.73535 1.14746Z">
                                        </path>
                                    </svg>
                                </span>
                            </a>
                        </div>
                        <div class="contact-img">
                            <img src="assets/images/visa/visa-contact-img.png" alt="">
                        </div>
                    </div>
                </div>
            </div>
            <!-- End of Need Visa Assistance -->

            <!-- Faq Section Start -->
            <div class="faqSection pt-50 pb-50">
                <div class="container">
                    <div class="row justify-content-center mb-50 wow animate fadeInDown" data-wow-delay="200ms" data-wow-duration="1500ms">
                        <div class="col-xl-6 col-lg-8">
                            <div class="section-title text-center mb-0">
                                <h2>FAQ</h2>
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-xl-8 col-lg-10">
                            <div class="faq-wrap">
                                <div class="accordion accordion-flush" id="accordionFlushExample">
                                    <div class="accordion-item wow animate fadeInDown" data-wow-delay="200ms" data-wow-duration="1500ms">
                                        <h5 class="accordion-header" id="flush-headingOne">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                                                What is a Visa? 
                                            </button>
                                        </h5>
                                        <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                                            <div class="accordion-body">
                                                A Visa is an official authorization issued by a country’s representative, allowing non-residents to enter its border, subject to immigration control. 
                                            </div>
                                        </div>
                                    </div>
                                    <div class="accordion-item wow animate fadeInDown" data-wow-delay="200ms" data-wow-duration="1500ms">
                                        <h5 class="accordion-header" id="flush-headingTwo">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
                                                How do I apply for a Visa? 
                                            </button>
                                        </h5>
                                        <div id="flush-collapseTwo" class="accordion-collapse collapse" aria-labelledby="flush-headingTwo" data-bs-parent="#accordionFlushExample">
                                            <div class="accordion-body">
                                                The application process varies by country. Generally, it involves selecting the country, filling out a form, uploading documents and paying fees online or at a designated visa application center. 
                                            </div>
                                        </div>
                                    </div>
                                    <div class="accordion-item wow animate fadeInDown" data-wow-delay="200ms" data-wow-duration="1500ms">
                                        <h5 class="accordion-header" id="flush-headingThree">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseThree" aria-expanded="false" aria-controls="flush-collapseThree">
                                                What documents are required?
                                            </button>
                                        </h5>
                                        <div id="flush-collapseThree" class="accordion-collapse collapse" aria-labelledby="flush-headingThree" data-bs-parent="#accordionFlushExample">
                                            <div class="accordion-body">
                                                Commonly required documents include a valid passport (usually with at least 6 months validity), completed application forms, passport-sized photographs, flight itineraries, hotel bookings, travel insurance, etc. 
                                            </div>
                                        </div>
                                    </div>
                                    <div class="accordion-item wow animate fadeInDown" data-wow-delay="200ms" data-wow-duration="1500ms">
                                        <h5 class="accordion-header" id="flush-headingFour">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseFour" aria-expanded="false" aria-controls="flush-collapseFour">
                                                How long does the process take? 
                                            </button>
                                        </h5>
                                        <div id="flush-collapseFour" class="accordion-collapse collapse" aria-labelledby="flush-headingFour" data-bs-parent="#accordionFlushExample">
                                            <div class="accordion-body">
                                                Processing time vary based on the country and visa type. It is advised to apply well in advance of your travel date. 
                                            </div>
                                        </div>
                                    </div>
                                    <div class="accordion-item wow animate fadeInDown" data-wow-delay="200ms" data-wow-duration="1500ms">
                                        <h5 class="accordion-header" id="flush-headingFive">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseFive" aria-expanded="false" aria-controls="flush-collapseFive">
                                                What is an e-Visa and who is eligible? 
                                            </button>
                                        </h5>
                                        <div id="flush-collapseFive" class="accordion-collapse collapse" aria-labelledby="flush-headingFive" data-bs-parent="#accordionFlushExample">
                                            <div class="accordion-body">
                                                An e-Visa is an electronic authorization, such as for India, which allows for tourist, business, medical or conference purposes without submitting physical documents to an embassy. 
                                            </div>
                                        </div>
                                    </div>
                                    <div class="accordion-item wow animate fadeInDown" data-wow-delay="200ms" data-wow-duration="1500ms">
                                        <h5 class="accordion-header" id="flush-headingSix">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseSix" aria-expanded="false" aria-controls="flush-collapseSix">
                                                Can I apply for a visa if my passport is expiring soon? 
                                            </button>
                                        </h5>
                                        <div id="flush-collapseSix" class="accordion-collapse collapse" aria-labelledby="flush-headingSix" data-bs-parent="#accordionFlushExample">
                                            <div class="accordion-body">
                                                Generally, a passport must be valid for at least 6 months beyond your intended stay. 
                                            </div>
                                        </div>
                                    </div>
                                    <div class="accordion-item wow animate fadeInDown" data-wow-delay="200ms" data-wow-duration="1500ms">
                                        <h5 class="accordion-header" id="flush-headingSeven">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseSeven" aria-expanded="false" aria-controls="flush-collapseSeven">
                                                How can I track my application status? 
                                            </button>
                                        </h5>
                                        <div id="flush-collapseSeven" class="accordion-collapse collapse" aria-labelledby="flush-headingSeven" data-bs-parent="#accordionFlushExample">
                                            <div class="accordion-body">
                                                You can typically track your application using the reference number provided after submission, through the official consulate or VFS Global website. 
                                            </div>
                                        </div>
                                    </div>
                                    <div class="accordion-item wow animate fadeInDown" data-wow-delay="200ms" data-wow-duration="1500ms">
                                        <h5 class="accordion-header" id="flush-headingEight">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseEight" aria-expanded="false" aria-controls="flush-collapseEight">
                                                What if my Visa application is denied? 
                                            </button>
                                        </h5>
                                        <div id="flush-collapseEight" class="accordion-collapse collapse" aria-labelledby="flush-headingEight" data-bs-parent="#accordionFlushExample">
                                            <div class="accordion-body">
                                                If a visa is refused, fees are usually non-refundable. Applicants may be able to reapply after addressing the reasons for refusal. 
                                            </div>
                                        </div>
                                    </div>
                                    <div class="accordion-item wow animate fadeInDown" data-wow-delay="200ms" data-wow-duration="1500ms">
                                        <h5 class="accordion-header" id="flush-headingNine">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseNine" aria-expanded="false" aria-controls="flush-collapseNine">
                                                Do I need travel medical insurance? 
                                            </button>
                                        </h5>
                                        <div id="flush-collapseNine" class="accordion-collapse collapse" aria-labelledby="flush-headingNine" data-bs-parent="#accordionFlushExample">
                                            <div class="accordion-body">
                                                For many countries, especially in the Schengen area, valid travel medical insurance is a mandatory requirement. 
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End of Faq Section -->
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
        <!-- Visa Package Card Start Js  -->
        <script>
            const visaPackages = [
                {
                    country: "Australia",
                    image: "assets/images/visa/visa-package-img1.jpg",
                    processing: "(15 - 30) Days",
                    link: "visa-details.php"
                },
                {
                    country: "Canada",
                    image: "assets/images/visa/visa-package-img2.jpg",
                    processing: "(10 - 20) Days",
                    link: "#"
                },
                {
                    country: "United Kingdom",
                    image: "assets/images/visa/visa-package-img3.jpg",
                    processing: "(01 - 02) Months",
                    link: "#"
                },
                {
                    country: "United State",
                    image: "assets/images/visa/visa-package-img4.jpg",
                    processing: "(01 - 03) Months",
                    link: "#"
                },
                {
                    country: "France",
                    image: "assets/images/visa/visa-package-img5.jpg",
                    processing: "(01 - 02) Months",
                    link: "#"
                },
                {
                    country: "Germany",
                    image: "assets/images/visa/visa-package-img6.jpg",
                    processing: "(15 - 30) Days",
                    link: "#"
                },
                {
                    country: "Qatar",
                    image: "assets/images/visa/visa-package-img7.jpg",
                    processing: "(15 - 25) Days",
                    link: "#"
                },
                {
                    country: "Switzerland",
                    image: "assets/images/visa/visa-package-img8.jpg",
                    processing: "(10 - 20) Days",
                    link: "#"
                }
            ];

            const visaContainer = document.getElementById("visaCards");

            visaPackages.forEach((visa, index) => {

                const card = document.createElement("div");
                card.className = "col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12 wow animate fadeInDown d-flex justify-content-center";
                card.setAttribute("data-wow-delay", `${index * 200}ms`);
                card.setAttribute("data-wow-duration", "1500ms");

                card.innerHTML = `
                    <div class="visaPackageCard">
                        <div class="visaPackageImg">
                            <img src="${visa.image}" alt="${visa.country}">
                        </div>

                        <div class="visaPackageContent card pt-18 pb-18 border-0 rounded-4">
                            <h5 class="text-center fw-bold">
                                <a href="${visa.link}">${visa.country}</a>
                            </h5>

                            <span class="text-14 text-center">
                                Processing Time -
                                <strong class="text-tertiary">${visa.processing}</strong>
                            </span>
                        </div>
                    </div>
                `;

                visaContainer.appendChild(card);
            });
        </script>
        <!-- End of Visa Package Card Js  -->
        <script>
            let posX = 0,
            posY = 0;

            let mouseX = 0,
            mouseY = 0;

            gsap.to(".cursor-example", {
                duration: 0.018,
                repeat: -1,
                onRepeat: function () {
                    posX += (mouseX - posX) / 8;
                    posY += (mouseY - posY) / 8;

                    gsap.set(".cursor-example", {
                    css: {
                        left: posX - 1,
                        top: posY - 2
                    }
                });
            }
            });

            document.addEventListener("mousemove", (e) => {
                mouseX = e.clientX;
                mouseY = e.clientY;
            });
        </script>
    </body>
</html>