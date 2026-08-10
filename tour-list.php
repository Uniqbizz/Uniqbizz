<?php
require 'connect.php';
session_start();

if (isset($_SESSION['user_type_id_value'])) {
    $user_type = $_SESSION["user_type_id_value"];
    $user_id = $_SESSION["user_id"];
    $username2 = $_SESSION["username2"];
} else {
    $user_type = 0;
    $user_id = 0;
}
$stmtDestination = $conn->prepare("
    SELECT DISTINCT
        TRIM(destination) AS destination,
        name
    FROM package
    WHERE status = 1
      AND destination IS NOT NULL
      AND TRIM(destination) != ''
    ORDER BY destination ASC
");

$stmtDestination->execute();

$destinations = $stmtDestination->fetchAll(PDO::FETCH_ASSOC);
// $page =  1;
// $totalPages =10;
//get the hotel types 
$data7 = $conn->prepare("SELECT * FROM category_hotel");
$data7->execute();

if ($data7->rowCount() > 0) {
    $categoryHotels = $data7->fetchAll(PDO::FETCH_ASSOC);
} else {
    $categoryHotels = [];
}
?>
<!DOCTYPE html>
<html lang="zxx" dir="lrt">

    <meta http-equiv="content-type" content="text/html;charset=utf-8" />
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
        <!-- Font Awesome Icons -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <style>
            .form-check-input {
                width: 18px;
                height: 18px;
                cursor: pointer;
            }

            .form-check-label {
                font-size: 16px;
                color: #999999;
                font-family: var(--Dm);
            }
            .list-desc {
                font-size: 16px;
            }
            .parent-container-badge {
                position: relative;
                overflow: hidden;
                border-top-left-radius: 6px;
                margin-left: 12px;
            }
            .badge-color {
                background-color: #0d81ceff;
                padding: 25px 0px 10px 0px;
                text-align: center;
                width: 130px;
                transform: rotate(312deg);
                position: absolute;
                top: -6px;
                left: -44px;
            }
            .trending{
                color: #fff;
                font-size: 13px;
                font-weight: bolder;
            }

            /* Package Type 1 */
            .badge-trending p {
                background-color: #e03d42;
                color: #fff;
                font-size: 13px;
                font-weight: bolder;
            }

            /* Package Type 2 */
            .badge-bestseller p {
                background-color: #ffb400;
                color: #fff;
                font-size: 13px;
                font-weight: bolder;
            }

            /* Package Type 3 */
            .badge-featured p {
                background-color: #198754;
                color: #fff;
                font-size: 13px;
                font-weight: bolder;
            }

            /* Default */
            .badge-popular p {
                background-color: #6f42c1;
                color: #fff;
                font-size: 13px;
                font-weight: bolder;
            }
            .btn-background-color {
                background-color: #e03d42 !important;
                color: #fff !important;
            }
            .btn-background-color:hover {
                background-color: #fff !important;
                border: 2px solid #e03d42 !important;
                color: #e03d42 !important;
            }
            .imageSize {
                width: 95%;
                height: 265px;
            }
            .page-btn.active {
                background-color: #e03d42 !important;
                color: #fff !important;
            }
            /* ==========================================
            DESTINATION SEARCH
            ========================================== */

            .destination-search-wrapper {
                position: relative;
                width: 100%;
            }


            /* Search input box */

            .destination-search {
                position: relative;

                width: 100%;
                height: 52px;

                display: flex;
                align-items: center;

                background: #fff;

                border: 1px solid #e1e4e8;
                border-radius: 10px;

                transition: all 0.2s ease;
            }


            /* Focus */

            .destination-search:focus-within {
                border-color: #e03d42;

                box-shadow: 0 0 0 3px rgba(224, 61, 66, 0.08);
            }


            /* Location icon */

            .destination-icon {
                position: absolute;

                left: 15px;

                font-size: 20px;

                color: #e03d42;

                pointer-events: none;
            }


            /* Input */

            .destination-input {
                width: 100%;
                height: 100%;

                border: none;
                outline: none;

                background: transparent;

                padding: 0 75px 0 45px;

                font-size: 15px;

                color: #071516;
            }


            /* Placeholder */

            .destination-input::placeholder {
                color: #8a8f94;
            }


            /* Clear button */

            .destination-clear {
                position: absolute;

                right: 40px;

                font-size: 20px;

                color: #999;

                cursor: pointer;

                display: none;

                transition: 0.2s;
            }

            .destination-clear:hover {
                color: #e03d42;
            }


            /* Arrow */

            .destination-dropdown-icon {
                position: absolute;

                right: 14px;

                font-size: 21px;

                color: #071516;

                cursor: pointer;

                transition: transform 0.2s ease;
            }


            /* Rotate arrow when open */

            .destination-search-wrapper.active
            .destination-dropdown-icon {
                transform: rotate(180deg);
            }


            /* ==========================================
            SUGGESTIONS
            ========================================== */

            .destination-suggestions {

                position: absolute;

                top: calc(100% + 8px);

                left: 0;
                right: 0;

                background: #fff;

                border: 1px solid #e5e7eb;

                border-radius: 10px;

                box-shadow:
                    0 10px 30px rgba(0, 0, 0, 0.12);

                z-index: 9999;

                overflow: hidden;

                display: none;
            }


            /* Open */

            .destination-search-wrapper.active
            .destination-suggestions {
                display: block;
            }


            /* Scrollable area */

            .destination-suggestions {
                max-height: 260px;

                overflow-y: auto;

                scrollbar-width: thin;
                scrollbar-color: #c8c8c8 transparent;
            }


            /* Chrome scrollbar */

            .destination-suggestions::-webkit-scrollbar {
                width: 6px;
            }

            .destination-suggestions::-webkit-scrollbar-track {
                background: transparent;
            }

            .destination-suggestions::-webkit-scrollbar-thumb {
                background: #c8c8c8;

                border-radius: 10px;
            }

            .destination-suggestions::-webkit-scrollbar-thumb:hover {
                background: #999;
            }


            /* ==========================================
            OPTION
            ========================================== */

            .destination-option {

                min-height: 48px;

                display: flex;
                align-items: center;

                gap: 10px;

                padding: 11px 15px;

                cursor: pointer;

                color: #333;

                font-size: 14px;

                transition: background 0.15s ease;
            }


            .destination-option i {

                font-size: 17px;

                color: #e03d42;

                flex-shrink: 0;
            }


            .destination-option:hover {

                background: #f8f8f8;

                color: #e03d42;
            }


            /* Selected */

            .destination-option.selected {

                background: rgba(224, 61, 66, 0.08);

                color: #e03d42;

                font-weight: 600;
            }


            /* No results */

            .destination-no-result {

                padding: 18px;

                text-align: center;

                color: #888;

                font-size: 14px;
            }

            .theme-checkbox {
                display: flex;
                align-items: center;
                gap: 8px;
                margin-bottom: 12px;
            }

            .theme-checkbox input[type="checkbox"] {
                width: 15px;
                height: 15px;
                margin: 0;
                flex-shrink: 0;
                cursor: pointer;
            }

            .theme-checkbox > div {
                display: flex;
                align-items: center;
            }

            .theme-checkbox span {
                display: flex;
                align-items: center;
                gap: 6px;
                font-size: 15px;
                color: #444;
                line-height: 1;
                cursor: pointer;
            }

            .theme-checkbox span i {
                font-size: 14px;
                color: #FFB400;
            }
            .theme-section {
                padding-top: 15px;
                display: -webkit-box;
                display: -ms-flexbox;
                display: flex;
                -ms-flex-wrap: wrap;
                    flex-wrap: wrap;
                gap: 4px;
            }
            .theme-section .theme-checkbox {
                position: relative;
                float: left;
                border: 1px solid var(--tertiary-border);
                -webkit-box-sizing: border-box;
                        box-sizing: border-box;
                border-radius: 4px;
                background-color: #ffffff;
                -webkit-transition: background-color 0.5s ease;
                transition: background-color 0.5s ease;
            }
            .theme-section .theme-checkbox span {
                padding: 4px 10px;
                font-size: 14px;
                font-weight: 500;
                line-height: 1.4;
                color: var(--primary-paragraph);
                display: -webkit-box;
                display: -ms-flexbox;
                display: flex;
                -webkit-box-align: center;
                    -ms-flex-align: center;
                        align-items: center;
                gap: 6px;
            }
            .theme-section .theme-checkbox div {
                width: 100%;
                height: 100%;
                display: -webkit-box;
                display: -ms-flexbox;
                display: flex;
                -webkit-box-pack: center;
                    -ms-flex-pack: center;
                        justify-content: center;
                -webkit-box-align: center;
                    -ms-flex-align: center;
                        align-items: center;
                line-height: 25px;
            }
            .theme-section .theme-checkbox input {
                position: absolute;
                top: 0;
                left: 0;
                opacity: 0;
                cursor: pointer;
                width: 100%;
                height: 100%;
            }
            .theme-section .theme-checkbox input[type=checkbox]:checked + div {
                background-color: var(--primary-color);
                border-radius: 4px;
            }
            .theme-section .theme-checkbox input[type=checkbox]:checked + div span {
                color: var(--white);
            }
            /* ==========================================
            MOBILE
            ========================================== */

            @media (max-width: 767px) {

                .destination-search {

                    height: 48px;

                    border-radius: 9px;
                }

                .destination-input {

                    font-size: 14px;

                    padding-left: 42px;
                }

                .destination-icon {

                    left: 13px;

                    font-size: 19px;
                }

                .destination-suggestions {

                    max-height: 220px;

                    border-radius: 9px;
                }

                .destination-option {

                    min-height: 46px;

                    padding: 10px 13px;

                    font-size: 14px;
                }
            }
            @media screen and (max-width: 991px) {
                .imageSize {
                    width: 100%;
                    height: 270px;
                    border-radius: 6px 6px 0px 0px !important;
                }
                .packageTitle{
                    font-size: 20px;
                    padding: 0px 25px;
                }
                .packageLocation {
                    padding: 0px 25px;
                }
                .packageRatings {
                    padding: 0px 25px;
                }
                .packageDesc {
                    padding: 0px 25px;
                }
                .pacakgePrice {
                    font-size: 17px;
                }
                .parent-container-badge {
                    position: relative;
                    overflow: hidden;
                    border-top-left-radius: 6px;
                    margin: 0px 12px;
                }
                .badge-color {
                    background-color: #0d81ceff;
                    padding: 25px 0px 10px 0px;
                    text-align: center;
                    width: 130px;
                    transform: rotate(312deg);
                    position: absolute;
                    top: -6px;
                    left: -44px;
                }
                .borderRemove {
                    border: none !important;
                }
                .packageButton {
                    display: flex !important;
                    justify-content: start !important;
                    padding: 0px 0px 15px 25px !important;
                    gap: 10px;
                }
                .packagePriceDiv {
                    display: flex !important;
                    justify-content: start !important;
                    padding: 0px 0px 10px 25px !important;
                    gap: 10px;
                }
                .packageExplore {
                    position: absolute;
                    left: 243px;
                    bottom: 30px;
                }
            }
            @media screen and (max-width: 767px) {
                .imageSize {
                    width: 100%;
                    height: 250px;
                    padding: 0px;
                    border-radius: 6px 6px 0px 0px !important;
                }
                .packageTitle{
                    font-size: 20px;
                    padding: 0px 25px;
                }
                .packageLocation {
                    padding: 0px 25px;
                }
                .packageRatings {
                    padding: 0px 25px;
                }
                .packageDesc {
                    padding: 0px 25px;
                }
                .pacakgePrice {
                    font-size: 17px;
                }
                .parent-container-badge {
                    position: relative;
                    overflow: hidden;
                    border-top-left-radius: 6px;
                    margin: 0px 12px;
                }
                .badge-color {
                    background-color: #0d81ceff;
                    padding: 25px 0px 10px 0px;
                    text-align: center;
                    width: 130px;
                    transform: rotate(312deg);
                    position: absolute;
                    top: -6px;
                    left: -44px;
                }
                .borderRemove {
                    border: none !important;
                }
                .packageButton {
                    display: flex !important;
                    justify-content: start !important;
                    padding: 0px 0px 15px 25px !important;
                    gap: 10px;
                }
                .packagePriceDiv {
                    display: flex !important;
                    justify-content: start !important;
                    padding: 0px 0px 10px 25px !important;
                    gap: 10px;
                }
                .packageExplore {
                    position: absolute;
                    left: 200px;
                    bottom: 30px;
                }
            }
        </style>
    </head>
    <body>
        <?php include_once "header.php" ?>
        <main>
            <!-- Breadcrumbs S t a r t -->
            <section class="breadcrumbs-area breadcrumb-bg">
                <div class="container">
                    <h1 class="title wow fadeInUp" data-wow-delay="0.0s">Tour List</h1>
                    <div class="breadcrumb-text">
                        <nav aria-label="breadcrumb" class="breadcrumb-nav wow fadeInUp" data-wow-delay="0.1s">
                            <ul class="breadcrumb listing">
                                <li class="breadcrumb-item single-list"><a href="index.php" class="single">Home</a></li>
                                <li class="breadcrumb-item single-list" aria-current="page">
                                    <a href="javascript:void(0)" class="single active">Tour List</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>

            </section>
            <!--/ End-of Breadcrumbs-->

            <!-- Destination area S t a r t -->
            <section class="tour-list-section section-padding2">
                <div class="container">
                    <div class="row g-4">
                        <div class="col-xl-3">
                            <div class="search-filter-section">
                                <div class="expand-icon close-btn block d-xl-none">
                                    <i class="ri-arrow-left-double-line"></i>
                                </div>
                                <div class="heading">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                        fill="none">
                                        <path
                                            d="M3 7H10M10 7C10 8.65685 11.3431 10 13 10H14C15.6569 10 17 8.65685 17 7C17 5.34315 15.6569 4 14 4H13C11.3431 4 10 5.34315 10 7ZM16 17H21M20 7H21M3 17H6M6 17C6 18.6569 7.34315 20 9 20H10C11.6569 20 13 18.6569 13 17C13 15.3431 11.6569 14 10 14H9C7.34315 14 6 15.3431 6 17Z"
                                            stroke="#071516" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                    </svg>
                                    <h4 class="title">Search By Filter</h4>
                                </div>
                                <div class="p-3" style="max-width: 300px;">
                                    <h4 class="title">
                                        <i class="bi bi-ticket-perforated"></i> Tour Type
                                    </h4>
                                    <hr class="my-2">
                                    <div class="form-check mb-2">
                                        <input class="form-check-input tour-type" type="checkbox" value="2" id="dometic" checked>
                                        <label class="form-check-label text-muted" for="dometic">
                                            Domestic
                                        </label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input tour-type" type="checkbox" value="1" id="international" checked>
                                        <label class="form-check-label text-muted" for="international">
                                            International
                                        </label>
                                    </div>
                                </div>
                                <!-- <div class="tour-search">
                                    <div class="select-dropdown-section">
                                        <div class="d-flex gap-10 align-items-center">
                                            <i class="ri-map-pin-line"></i>
                                            <h4 class="select2-title">Destination</h4>
                                        </div>
                                        <select class="destination-dropdown">
                                        </select>
                                    </div>
                                </div> -->

                                <div class="heading">
                                    <h4 class="title">Filter By Price</h4>
                                </div>
                                <div class="price-range-slider">
                                    <div id="slider-range" class="range-bar"></div>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="range-value">
                                            <p class="pera py-2"><b>Price: </b></p><input type="text" id="amount" readonly>
                                            <!-- <span>&#8377; 5000</span> - <span>&#8377; 250000</span> -->
                                        </div>
                                    </div>
                                    <!-- <div class="button-section d-flex justify-content-center">
                                        <a href="javascript:void(0)" class="apply-btn">Apply</a>
                                    </div> -->
                                </div>
                                <div class="heading">
                                    <h4 class="title">Duration (in Nights)</h4>
                                </div>
                                <div class="price-range-slider">
                                    <div id="slider-range-duration" class="range-bar"></div>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <p class="pt-2"><span id="duration-min">1</span>N</p>
                                        <p class="pt-2"><span id="duration-max">10</span>N</p>
                                    </div>
                                </div>
                                <div class="heading">
                                    <h4 class="title">Hotel Category</h4>
                                </div>
                                <div class="ratting-section">

                                    <?php foreach ($categoryHotels as $categoryHotel): ?>

                                        <?php
                                        $id = (int) $categoryHotel['id'];
                                        $name = trim($categoryHotel['name']);

                                        // Check if this is a star category
                                        $isStar = preg_match('/^[1-5]\s*Star$/i', $name);

                                        // Get number for star category
                                        $starNumber = $isStar ? (int) filter_var($name, FILTER_SANITIZE_NUMBER_INT) : null;
                                        ?>

                                        <div class="ratting-checkbox">

                                            <input
                                                type="checkbox"
                                                id="<?= $id ?>"
                                                name="hotel_category[]"
                                                value="<?= $id ?>"
                                                checked
                                            >

                                            <div>
                                                <span>

                                                    <?php if ($isStar): ?>

                                                        <!-- Star Icon -->
                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                            width="14"
                                                            height="13"
                                                            viewBox="0 0 14 13"
                                                            fill="none">

                                                            <path
                                                                d="M6.09749 0.891366C6.45972 0.132244 7.54028 0.132244 7.90251 0.891366L9.07038 3.33882C9.21616 3.64433 9.5066 3.85534 9.84221 3.89958L12.5308 4.25399C13.3647 4.36391 13.6986 5.39158 13.0885 5.97067L11.1218 7.83768C10.8763 8.07073 10.7653 8.41217 10.827 8.74502L11.3207 11.4115C11.4739 12.2386 10.5997 12.8737 9.86041 12.4725L7.47702 11.1789C7.1795 11.0174 6.8205 11.0174 6.52298 11.1789L4.13959 12.4725C3.40033 12.8737 2.52614 12.2386 2.67929 11.4115L3.17304 8.74502C3.23467 8.41217 3.12373 8.07073 2.87823 7.83768L0.911452 5.97067C0.301421 5.39158 0.635332 4.36391 1.46924 4.25399L4.15779 3.89958C4.4934 3.85534 4.78384 3.64433 4.92962 3.33882L6.09749 0.891366Z"
                                                                fill="#FFB400" />

                                                        </svg>

                                                        <?= $starNumber ?>

                                                    <?php elseif (strtolower($name) === 'villa'): ?>

                                                        <!-- Villa Icon -->
                                                        <i class="ri-home-4-line"
                                                            style="font-size:14px; color:#FFB400;"></i>

                                                        Villa

                                                    <?php elseif (strtolower($name) === 'apartment'): ?>

                                                        <!-- Apartment Icon -->
                                                        <i class="ri-building-2-line"
                                                            style="font-size:14px; color:#FFB400;"></i>

                                                        Apartment

                                                    <?php else: ?>

                                                        <!-- Fallback -->
                                                        <?= htmlspecialchars($name) ?>

                                                    <?php endif; ?>

                                                </span>
                                            </div>

                                        </div>

                                    <?php endforeach; ?>

                                </div>

                                <div class="heading">

                                    <h4 class="title">Travel Theme / Type </h4>
                                </div>
                                <div class="theme-section">
                                    <!-- Leisure -->
                                    <div class="theme-checkbox">
                                        <input
                                            type="checkbox"
                                            id="Leisure"
                                            name="travelTheme[]"
                                            value="Leisure"
                                            checked
                                        >

                                        <div>
                                            <span>
                                                <i class="fa-solid fa-mountain-city"
                                                style="font-size:14px; color:#FFB400;"></i>
                                                Leisure
                                            </span>
                                        </div>
                                    </div>


                                    <!-- Adventure -->
                                    <div class="theme-checkbox">
                                        <input
                                            type="checkbox"
                                            id="Adventure"
                                            name="travelTheme[]"
                                            value="Adventure"
                                            checked
                                        >

                                        <div>
                                            <span>
                                                <i class="fa-solid fa-mountain-sun"
                                                style="font-size:14px; color:#FFB400;"></i>
                                                Adventure
                                            </span>
                                        </div>
                                    </div>


                                    <!-- Spiritual -->
                                    <div class="theme-checkbox">
                                        <input
                                            type="checkbox"
                                            id="Spiritual"
                                            name="travelTheme[]"
                                            value="Spiritual"
                                            checked
                                        >

                                        <div>
                                            <span>
                                                <i class="fa-solid fa-place-of-worship"
                                                style="font-size:14px; color:#FFB400;"></i>
                                                Spiritual
                                            </span>
                                        </div>
                                    </div>


                                    <!-- Beach -->
                                    <div class="theme-checkbox">
                                        <input
                                            type="checkbox"
                                            id="Beach"
                                            name="travelTheme[]"
                                            value="Beach"
                                            checked
                                        >

                                        <div>
                                            <span>
                                                <i class="fa-solid fa-umbrella-beach"
                                                style="font-size:14px; color:#FFB400;"></i>
                                                Beach
                                            </span>
                                        </div>
                                    </div>


                                    <!-- Honeymoon -->
                                    <div class="theme-checkbox">
                                        <input
                                            type="checkbox"
                                            id="Honeymoon"
                                            name="travelTheme[]"
                                            value="Honeymoon"
                                            checked
                                        >

                                        <div>
                                            <span>
                                                <i class="fa-solid fa-heart"
                                                style="font-size:14px; color:#FFB400;"></i>
                                                Honeymoon
                                            </span>
                                        </div>
                                    </div>


                                    <!-- Other -->
                                    <div class="theme-checkbox">
                                        <input
                                            type="checkbox"
                                            id="Other"
                                            name="travelTheme[]"
                                            value="Other"
                                            checked
                                        >

                                        <div>
                                            <span>
                                                <i class="fa-solid fa-crosshairs"
                                                style="font-size:14px; color:#FFB400;"></i>
                                                Other
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="mt-4">
                                    <button id="clearAll" class="btn btn-outline-secondary btn-sm">Clear</button>
                                </div>
                            </div>
                            <div class="cover"></div>
                        </div>
                        <div class="col-xl-9">
                            <div class="select-dropdown-section destination-search-wrapper mb-3">

                                <div class="destination-search">

                                    <i class="ri-map-pin-line destination-icon"></i>

                                    <input
                                        type="text"
                                        id="destinationSearch"
                                        class="destination-input"
                                        placeholder="Search destination..."
                                        autocomplete="off"
                                    >

                                    <i class="ri-close-line destination-clear" id="destinationClear"></i>

                                    <i class="ri-arrow-down-s-line destination-dropdown-icon"
                                    id="destinationArrow"></i>

                                </div>

                                <div class="destination-suggestions mb-2" id="destinationSuggestions">

                                    <?php foreach ($destinations as $destination): ?>

                                    <div
                                        class="destination-option"
                                        data-value="<?= htmlspecialchars($destination['destination']) ?>"
                                    >
                                        <i class="ri-map-pin-line"></i>

                                        <span class="destination-option-text">

                                            <strong>
                                                <?= htmlspecialchars($destination['name']) ?>
                                            </strong>
                                            </br>
                                            <small>
                                                <?= htmlspecialchars($destination['destination']) ?>
                                            </small>

                                        </span>
                                    </div>

                                <?php endforeach; ?>

                                </div>

                            </div>
                            <div class="showing-result d-flex justify-content-end">
                                <div class="d-flex">
                                    <div class="pe-2" id="list_column">
                                    <i class="fa-solid fa-table-cells fa-2xl" style="color: #e03d42;"></i>
                                    </div>
                                    <div class="pe-2" id="grid_column">
                                        <i class="fa-solid fa-table-list fa-2xl" style="color: #e03d42;"></i>
                                    </div>
                                </div>
                                <!-- <h4 class="title">Showing 6 of 10 Results</h4> -->
                                <div class="d-flex gap-10 align-items-center">
                                    <div class="expand-icon hamburger block d-xl-none" id="hamburger">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                            fill="none">
                                            <path
                                                d="M3 7H10M10 7C10 8.65685 11.3431 10 13 10H14C15.6569 10 17 8.65685 17 7C17 5.34315 15.6569 4 14 4H13C11.3431 4 10 5.34315 10 7ZM16 17H21M20 7H21M3 17H6M6 17C6 18.6569 7.34315 20 9 20H10C11.6569 20 13 18.6569 13 17C13 15.3431 11.6569 14 10 14H9C7.34315 14 6 15.3431 6 17Z"
                                                stroke="#071516" stroke-width="2" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                        </svg>
                                    </div>
                                    <div class="sorting-dropdown ">
                                        <select class="select2 sort-options">
                                            <option value="Popular"> Sort by Popular</option>
                                            <option value="Trending"> Sort by Trending</option>
                                            <option value="Most Selling"> Sort by Most Selling</option>
                                            <option value="New Arrival"> Sort by New Arrival</option>
                                            <option value="low">Price low to high</option>
                                            <option value="high">Price high to low</option>
                                            <option value="new">Sort by Newset</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="" id="all-tour-container">
                                <div class="all-tour-list" id="all-tour-list">
                                    <input type="hidden" id="userId" value="<?= $user_id ?>" />
                                    <input type="hidden" id="userType" value="<?= $user_type ?>" />
                                    <div class="row g-4">
                                        <?php

                                        require 'connect.php';

                                        // $user_id = 0;
                                        $ta_id = 0;
                                        // get TA id
                                        if ($user_id) {
                                            if ($user_type == '10') {
                                                $ta_data = $conn->prepare("SELECT * FROM ca_customer WHERE ca_customer_id = '" . $user_id . "' ");
                                                $ta_data->execute();
                                                $ta = $ta_data->fetch();
                                                $ta_id = $ta['ta_reference_no'];
                                            } else if ($user_type == '11') {
                                                $ta_id = $user_id;
                                            }
                                        }

                                        $stmt = $conn->prepare(" SELECT p.id,p.created_date, p.name,p.description, p.destination, p.location, p.tour_days, 
                                                                t.net_price_adult_with_GST, t.markup_total, COUNT(b.package_id) AS booking_count,p.highlight_type
                                                                FROM package p JOIN package_pricing t ON p.id = t.package_id 
                                                                JOIN category c ON p.category_id = c.id 
                                                                LEFT JOIN bookings b ON b.package_id = p.id 
                                                                WHERE p.status = '1' 
                                                                GROUP BY p.id, p.description, p.destination, p.location, t.net_price_adult_with_GST, t.markup_total 
                                                                ORDER BY booking_count DESC, p.id  ");
                                        $stmt->execute();
                                        $stmt->SetFetchMode(PDO::FETCH_ASSOC);
                                        if ($stmt->rowCount() > 0) {
                                            foreach (($stmt->fetchAll()) as $key => $row) {
                                                // $name = $row['name'].''.$row['unique_code'];
                                                // echo $srno.' '.$name.'</br>';
                                                $badgeText = 'Popular';
                                                $badgeClass = 'badge-popular';
                                                // get images
                                                $data = $conn->prepare("SELECT * FROM package_pictures WHERE package_id = '" . $row['id'] . "' LIMIT 1");
                                                $data->execute();
                                                $value = $data->fetch();
                                                // echo $value['image'].'-id-'.$value['id'].'-package_id-'.$value['package_id'];

                                                $adult_price = (int)$row['net_price_adult_with_GST'];
                                                $markup_price = (int)$row['markup_total'];

                                                $tourDay = (int)$row['tour_days'] - 1;
                                                $tourNight = (int)$row['tour_days'] - 2;

                                                $total_base_price = $adult_price + $markup_price;

                                                if ($ta_id) {
                                                    $ta_markup_data = $conn->prepare("SELECT * FROM package_markup_travelagent WHERE travelagent_id = '" . $ta_id . "' AND package_id = '" . $row['id'] . "' AND status='1' LIMIT 1");
                                                    $ta_markup_data->execute();
                                                    $ta_markup = $ta_markup_data->fetch();

                                                    $total_price = $ta_markup['selling_price'] ?? $total_base_price;
                                                } else {
                                                    $total_price = $total_base_price;
                                                }

                                                $packageType = trim((string)($row['highlight_type'] ?? ''));
                                                
                                                switch ($packageType) {

                                                    case 'Trending':
                                                        $badgeText = 'Trending';
                                                        $badgeClass = 'badge-trending';
                                                        break;

                                                    case 'Best Seller':
                                                        $badgeText = 'Best Seller';
                                                        $badgeClass = 'badge-bestseller';
                                                        break;

                                                    case 'New Arrival':
                                                        $badgeText = 'New Arrival';
                                                        $badgeClass = 'badge-new-arrival';
                                                        break;

                                                    case '':
                                                        $badgeText = 'Popular';
                                                        $badgeClass = 'badge-popular';
                                                        break;

                                                    default:
                                                        $badgeText = 'Popular';
                                                        $badgeClass = 'badge-popular';
                                                        break;
                                                }

                                
                                                echo '
                                                    <div class="col-xl-4 col-lg-4 col-sm-6">
                                                        <div class="package-card">
                                                            <div class="package-img imgEffect4">
                                                                <a href="#" onclick=\'viewPackage("' . $row['id'] . '")\'>
                                                                    <img src="' . $value['image'] . '" alt="BizzMirth">
                                                                </a>
                                                                <div class="badge-color '.$badgeClass.'">
                                                                    <p>'.htmlspecialchars($badgeText).'</p>
                                                                </div>
                                                            </div>
                                                            <div class="package-content">
                                                                <h4 class="area-name">
                                                                    <a href="#" onclick=\'viewPackage("' . $row['id'] . '")\'>' . $row['name'] . '</a>
                                                                </h4>
                                                                <div class="location">
                                                                    <i class="ri-map-pin-line"></i>
                                                                    <div class="name">' . $row['location'] . '</div>
                                                                </div>
                                                                <div class="packages-person">
                                                                    <div class="count">
                                                                        <i class="ri-time-line"></i>
                                                                        <p class="pera"> '.$tourNight.' Night '.$tourDay.' Days</p>
                                                                    </div>
                                                                    <!-- <div class="count">
                                                                        <i class="ri-user-line"></i>
                                                                        <p class="pera">2 Person</p>
                                                                    </div> -->
                                                                </div>
                                                                <div class="price-review">
                                                                    <div class="d-flex gap-10">
                                                                        <p class="light-pera">From</p>
                                                                        <p class="pera"><span>&#8377</span>' . $total_price . '</p>
                                                                    </div>
                                                                    <!-- <div class="rating">
                                                                        <i class="ri-star-s-fill"></i>
                                                                        <p class="pera">4.7 (20 Reviews)</p>
                                                                    </div> -->
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
                                <div class="all-tour-grid d-none" id="all-tour-grid">
                                    <input type="hidden" id="userId" value="<?= $user_id ?>" />
                                    <input type="hidden" id="userType" value="<?= $user_type ?>" />
                                    <?php

                                        require 'connect.php';

                                        // $user_id = 0;
                                        $ta_id = 0;
                                        // get TA id
                                        if ($user_id) {
                                            if ($user_type == '10') {
                                                $ta_data = $conn->prepare("SELECT * FROM ca_customer WHERE ca_customer_id = '" . $user_id . "' ");
                                                $ta_data->execute();
                                                $ta = $ta_data->fetch();
                                                $ta_id = $ta['ta_reference_no'];
                                            } else if ($user_type == '11') {
                                                $ta_id = $user_id;
                                            }
                                        }

                                        $stmt = $conn->prepare(" SELECT p.id,p.created_date, p.name,p.description, p.destination, p.location, p.tour_days, t.net_price_adult_with_GST, t.markup_total, COUNT(b.package_id) AS booking_count FROM package p JOIN package_pricing t ON p.id = t.package_id JOIN category c ON p.category_id = c.id LEFT JOIN bookings b ON b.package_id = p.id WHERE p.status = '1' GROUP BY p.id, p.description, p.destination, p.location, t.net_price_adult_with_GST, t.markup_total ORDER BY booking_count DESC, p.id  ");
                                        $stmt->execute();
                                        $stmt->SetFetchMode(PDO::FETCH_ASSOC);
                                        if ($stmt->rowCount() > 0) {
                                            foreach (($stmt->fetchAll()) as $key => $row) {
                                                // $name = $row['name'].''.$row['unique_code'];
                                                // echo $srno.' '.$name.'</br>';

                                                // get images
                                                $data = $conn->prepare("SELECT * FROM package_pictures WHERE package_id = '" . $row['id'] . "' LIMIT 1");
                                                $data->execute();
                                                $value = $data->fetch();
                                                // echo $value['image'].'-id-'.$value['id'].'-package_id-'.$value['package_id'];

                                                $adult_price = (int)$row['net_price_adult_with_GST'];
                                                $markup_price = (int)$row['markup_total'];

                                           //calculate nights and days from tour days number
                                            $tourDay = (int)$row['tour_days'] - 1;
                                            $tourNight = (int)$row['tour_days'] - 2;

                                            // show inflated pricing and current price
                                            $total_price_inflated = $adult_price + 5000;
                                            
                                            // tour package description limit words counts to show in list view
                                            $description = $row['description'];
                                            $maxLength = 500;
                                            if (strlen($description) > $maxLength) {
                                                $truncatedString = substr($description, 0, $maxLength) . '...';
                                            } else {
                                                $truncatedString = $description;
                                            }

                                                $total_base_price = $adult_price + $markup_price;

                                                if ($ta_id) {
                                                    $ta_markup_data = $conn->prepare("SELECT * FROM package_markup_travelagent WHERE travelagent_id = '" . $ta_id . "' AND package_id = '" . $row['id'] . "' AND status='1' LIMIT 1");
                                                    $ta_markup_data->execute();
                                                    $ta_markup = $ta_markup_data->fetch();

                                                $total_price = $ta_markup['selling_price'] ?? $total_base_price;
                                            } else {
                                                $total_price = $total_base_price;
                                            }
                                            echo'<div class="card rounded shadow-lg mb-5 bg-body-tertiary rounded-3 mt-5 border-0">
                                                    <div class="row">
                                                        <div class="col-lg-4 col-md-4 col-sm-12 col-12 px-0">
                                                            <div class="parent-container-badge">
                                                                <a href="#" onclick=\'viewPackage("' . $row['id'] . '")\'>
                                                                    <img src="'.$value['image'].'" alt="BizzMirth" class="rounded-start imageSize">
                                                                </a>
                                                                <div class="badge-color">
                                                                    <p class="trending">Trending</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-5 col-md-5 col-sm-12 col-12 py-3 px-0 border-end borderRemove">
                                                            <h4 class="fw-bolder pb-2 packageTitle">
                                                                <a href="#" onclick=\'viewPackage("' . $row['id'] . '")\'>' . $row['name'] . '</a>
                                                            </h4>
                                                            <p class="pb-2 packageLocation">
                                                                <i class="fa-solid fa-location-dot fa-sm" style="color: #e03d42;"></i>
                                                                <span class="text-muted">'.$row['location'].'</span>
                                                            </p>
                                                            <div class="text-start list-desc packageDesc">
                                                               '.$truncatedString.'
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-3 col-md-3 col-sm-12 col-12 ps-0">
                                                            <div class="d-flex justify-content-evenly py-3 packageButton">
                                                                <button class="rounded-2 btn border-danger-subtle border-2">
                                                                    <p><i class="fa-solid fa-user fa-xs" style="color: #e03d42;"></i> <span class="text-danger"> 60</span></p>
                                                                </button>
                                                                <div class="rounded-2 btn border-danger-subtle border-2">
                                                                    <p class="text-danger"><i class="fa-solid fa-clock-rotate-left fa-xs" style="color: #e03d42;"></i> <span class="text-danger">'.$tourNight.' Night '.$tourDay.'</span></p>
                                                                </div>
                                                            </div>
                                                            <div class="d-flex justify-content-evenly py-3 packagePriceDiv">
                                                                <h5 class="fw-bolder pacakgePrice">&#8377; ' . $total_price . '</h5>
                                                                <h5 class="fw-bolder pacakgePrice text-muted text-decoration-line-through">&#8377; 25,000</h5>
                                                            </div>
                                                            <div class="d-flex justify-content-center py-3 packageExplore">
                                                                <a class="btn btn-background-color fw-bolder" href="#" role="button" onclick=\'viewPackage("' . $row['id'] . '")\'>Explore</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>';
                                        }
                                    }
                                ?>
                                
                            </div>
                            
                        </div>

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
        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
        <!-- Include jQuery and jQuery UI -->
        <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
        <!-- <script src="assets/js/jquery-3.7.0.min.js"></script> -->
        <script src="assets/js/popper.min.js"></script>
        <script src="assets/js/bootstrap-5.3.0.min.js"></script>
        <!-- Plugin -->
        <script src="assets/js/plugin.js"></script>
        <!-- Main js-->
        <script src="assets/js/main.js"></script>
        <script type="text/javascript" src="logout/logout.js"></script>
        <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
        <script>
            function viewPackage(id) {
                window.location.href = 'tour-details.php?pacId=' + id;
            }

            //on load show popular packs 
            var userid = $("#userId").val();
            var usertype = $("#userType").val();
            let selectedId = null;
            let selectedText = "";
            let selectedDestination = "";

            var priceRange = $("#amount").val();
            let prices =extractPrices(priceRange);
            let maxPrice =prices.maxPrice ;
            let minPrice =prices.minPrice ;
            var sortValue ;
            var ratings =getSelectedRatings();
            let minDuration ;
            let maxDuration ;
            let tourType =getTourType()??0;
            let destination =selectedDestination;
            let listBtnVal = document.getElementById("all-tour-list");
            let gridBtnVal = document.getElementById("all-tour-grid");
            let viewType = 0;
            let theme=getSelectedTheme();
            let page = 1 ;
            const listView = $("#all-tour-list");
            const gridView = $("#all-tour-grid");

            //extracting the price range
            function extractPrices(priceRange) {
                let prices = priceRange.replace(/₹/g, "").split(" - ");
                let minPrice = parseInt(prices[0], 10);
                let maxPrice = parseInt(prices[1], 10);
                return {
                    minPrice,
                    maxPrice
                };
            }

            //extract selected ratings
            function getSelectedRatings() {
                let selected = [];

                $(".ratting-section input[type='checkbox']:checked").each(function() {
                    selected.push($(this).attr("id"));
                });
                console.log(selected);
                
                return selected;
            }
            //extract selected ratings
            function getSelectedTheme() {
                let selected = [];

                $(".theme-section input[type='checkbox']:checked").each(function() {
                    selected.push($(this).val());
                });
                console.log(selected);
                
                return selected;
            }
            
            //extract tour type
            function getTourType() {
                return $(".tour-type:checked").map(function() {
                    return $(this).val();
                }).get();
            }

            function fetchSortedProducts(page,sortValue, minPrice, maxPrice, minDuration, maxDuration, destination, tourType,viewType) {
                let ratings = getSelectedRatings();
                let theme = getSelectedTheme();

                $.ajax({
                    url: "assets/submit/fetch_sorted_products.php",
                    type: "POST",
                    data: {
                        page: page,
                        sort: sortValue,
                        userid: userid,
                        usertype: usertype,
                        minPrice: minPrice,
                        maxPrice: maxPrice,
                        minDuration: minDuration,
                        maxDuration: maxDuration,
                        ratings: ratings,
                        destination: destination,
                        tourType: tourType,
                        viewType: viewType,
                        theme:theme
                    },
                    success: function(response) {
                        $("#all-tour-container").html(''); // ✅ clear old content to avoid duplicate IDs
                        $("#all-tour-container").html(response); // ✅ insert fresh HTML
                        $("html, body").animate({ scrollTop: $("#all-tour-container").offset().top - 100 }, "slow");
                    },
                    error: function(xhr, status, error) {
                        console.error("AJAX Error:", error);
                    }
                });
            }

            // Run AJAX on sort change
            $(".tour-type").on("change", function() {
                // sortValue = $(".sort-options").val();
                // priceRange = $("#amount").val();
                // prices = extractPrices(priceRange);
                // minDuration = $("#slider-range-duration").slider("values", 0);
                // maxDuration = $("#slider-range-duration").slider("values", 1);
                
                // tourType = getTourType()??0;
                // // console.log("tourType:", tourType);
                // listBtnVal = document.getElementById("all-tour-list");
                // gridBtnVal = document.getElementById("all-tour-grid");
                // viewType = 0;

                // if (!listBtnVal.classList.contains('d-none')) {
                //     viewType = 1; // list view
                // } else if (!gridBtnVal.classList.contains('d-none')) {
                //     viewType = 2; // grid view
                // }
                // fetchSortedProducts(page,sortValue, prices.minPrice, prices.maxPrice, minDuration, maxDuration, selectedDestination,tourType,viewType);
                page = 1;

                applyFilters();
            });

            // Run AJAX on sort change
            $(".sort-options").on("change", function() {
                // sortValue = $(this).val();
                // priceRange = $("#amount").val();
                // prices = extractPrices(priceRange);

                // minDuration = $("#slider-range-duration").slider("values", 0);
                // maxDuration = $("#slider-range-duration").slider("values", 1);
                
                // tourType = getTourType();
                // listBtnVal = document.getElementById("all-tour-list");
                // gridBtnVal = document.getElementById("all-tour-grid");
                // viewType = 0;

                // if (!listBtnVal.classList.contains('d-none')) {
                //     viewType = 1; // list view
                // } else if (!gridBtnVal.classList.contains('d-none')) {
                //     viewType = 2; // grid view
                // }
                
                // fetchSortedProducts(page,sortValue, prices.minPrice, prices.maxPrice, minDuration, maxDuration, selectedDestination,tourType,viewType);
                page = 1;

                applyFilters();
            });


            // Run AJAX on price change
            $("#amount").on("change", function() {
                // priceRange = $(this).val();
                // prices = extractPrices(priceRange);
                // sortValue = $(".sort-options").val();

                // minDuration = $("#slider-range-duration").slider("values", 0);
                // maxDuration = $("#slider-range-duration").slider("values", 1);

                
                // tourType = getTourType();
                // listBtnVal = document.getElementById("all-tour-list");
                // gridBtnVal = document.getElementById("all-tour-grid");
                // viewType = 0;

                // if (!listBtnVal.classList.contains('d-none')) {
                //     viewType = 1; // list view
                // } else if (!gridBtnVal.classList.contains('d-none')) {
                //     viewType = 2; // grid view
                // }

                // fetchSortedProducts(page,sortValue, prices.minPrice, prices.maxPrice, minDuration, maxDuration, selectedDestination,tourType,viewType);
                page = 1;

                applyFilters();
            });

            // Run AJAX on rating checkbox change
            $(".ratting-section input[type='checkbox']").on("change", function() {
                // priceRange = $("#amount").val();
                // prices = extractPrices(priceRange);
                // sortValue = $(".sort-options").val();

                // minDuration = $("#slider-range-duration").slider("values", 0);
                // maxDuration = $("#slider-range-duration").slider("values", 1);

                
                // tourType = getTourType();
                // listBtnVal = document.getElementById("all-tour-list");
                // gridBtnVal = document.getElementById("all-tour-grid");
                // viewType = 0;

                // if (!listBtnVal.classList.contains('d-none')) {
                //     viewType = 1; // list view
                // } else if (!gridBtnVal.classList.contains('d-none')) {
                //     viewType = 2; // grid view
                // }
                // fetchSortedProducts(page,sortValue, prices.minPrice, prices.maxPrice, minDuration, maxDuration, selectedDestination,tourType,viewType);
                page = 1;

                applyFilters();
            });
            // Run AJAX on rating checkbox change
            $(".theme-section input[type='checkbox']").on("change", function() {
                // priceRange = $("#amount").val();
                // prices = extractPrices(priceRange);
                // sortValue = $(".sort-options").val();

                // minDuration = $("#slider-range-duration").slider("values", 0);
                // maxDuration = $("#slider-range-duration").slider("values", 1);

                
                // tourType = getTourType();
                // listBtnVal = document.getElementById("all-tour-list");
                // gridBtnVal = document.getElementById("all-tour-grid");
                // viewType = 0;

                // if (!listBtnVal.classList.contains('d-none')) {
                //     viewType = 1; // list view
                // } else if (!gridBtnVal.classList.contains('d-none')) {
                //     viewType = 2; // grid view
                // }
                // fetchSortedProducts(page,sortValue, prices.minPrice, prices.maxPrice, minDuration, maxDuration, selectedDestination,tourType,viewType);
                page = 1;

                applyFilters();
            });
            
            $("#clearAll").on("click", function() {
                location.reload(); // Or window.location.reload();
            });
            $("#list_column").on("click", function () {
                listView.removeClass("d-none");
                gridView.addClass("d-none");
                viewType = 1;
                // console.log('test1');
                // fetchSortedProducts(page,sortValue, prices.minPrice, prices.maxPrice, minDuration, maxDuration,selectedDestination,tourType,viewType);
                applyFilters(viewType);
            });

            $("#grid_column").on("click", function () {
                gridView.removeClass("d-none");
                listView.addClass("d-none");
                viewType = 2;
                console.log('test2');
                // fetchSortedProducts(page,sortValue, prices.minPrice, prices.maxPrice, minDuration, maxDuration,selectedDestination,tourType,viewType);
                applyFilters(viewType);
            });

            $(document).ready(function() {
                //loadDestinations();

                // priceRange = $("#amount").val();
                // prices = extractPrices(priceRange);
                // sortValue = $(".sort-options").val();
                // minDuration = $("#slider-range-duration").slider("values", 0);
                // maxDuration = $("#slider-range-duration").slider("values", 1);
                
                // tourType = getTourType();
                // listBtnVal = document.getElementById("all-tour-list");
                // gridBtnVal = document.getElementById("all-tour-grid");
                // viewType = 1;
                // console.log("min price:", prices.minPrice);
                // console.log("min price:", prices.maxPrice);
                getCurrentFilters();

                fetchSortedProducts(page,sortValue, prices.minPrice, prices.maxPrice, minDuration, maxDuration,selectedDestination,tourType,viewType);
            });
            // $(document).on("change", ".destination-dropdown", function() {
            //     selectedId = $(this).val(); // gets the selected ID
            //     selectedText = $(this).find("option:selected").text(); // gets the selected text
            //     selectedDestination = $(this).find("option:selected").data("description");
            //     priceRange = $("#amount").val();
            //     prices = extractPrices(priceRange);
            //     sortValue = $(".sort-options").val();
            //     minDuration = $("#slider-range-duration").slider("values", 0);
            //     maxDuration = $("#slider-range-duration").slider("values", 1);
            //     tourType = getTourType();
            //     listBtnVal = document.getElementById("all-tour-list");
            //     gridBtnVal = document.getElementById("all-tour-grid");
            //     viewType = 0;

            //     if (!listBtnVal.classList.contains('d-none')) {
            //         viewType = 1; // list view
            //     } else if (!gridBtnVal.classList.contains('d-none')) {
            //         viewType = 2; // grid view
            //     }
            //     console.log("Destination Changed:");
            //     console.log("ID:", selectedId);
            //     console.log("Text:", selectedText);
            //     console.log("Description:", selectedDestination);

            //     fetchSortedProducts(page,sortValue, prices.minPrice, prices.maxPrice, minDuration, maxDuration, selectedDestination,tourType,viewType);
            // });
            // pagination logic
            // $(document).on('click', '.page-btn, .next-page, .prev-page', function() {
                
            //     page = $(this).data('page');
                
            //     priceRange = $("#amount").val();
            //     prices = extractPrices(priceRange);
            //     sortValue = $(".sort-options").val();
            //     minDuration = $("#slider-range-duration").slider("values", 0);
            //     maxDuration = $("#slider-range-duration").slider("values", 1);
            //     tourType = getTourType();
            //     listBtnVal = document.getElementById("all-tour-list");
            //     gridBtnVal = document.getElementById("all-tour-grid");
            //     viewType = 0;

            //     if (!listBtnVal.classList.contains('d-none')) {
            //         viewType = 1; // list view
            //     } else if (!gridBtnVal.classList.contains('d-none')) {
            //         viewType = 2; // grid view
            //     }
            //     fetchSortedProducts(page,sortValue, prices.minPrice, prices.maxPrice, minDuration, maxDuration,selectedDestination,tourType,viewType);
            // });  
            $(document).on(
                "click",
                ".page-btn, .next-page, .prev-page",
                function () {

                    page = $(this).data("page");

                    priceRange = $("#amount").val();
                    prices = extractPrices(priceRange);

                    sortValue = $(".sort-options").val();

                    minDuration = $("#slider-range-duration")
                        .slider("values", 0);

                    maxDuration = $("#slider-range-duration")
                        .slider("values", 1);

                    tourType = getTourType();

                    listBtnVal = document.getElementById("all-tour-list");
                    gridBtnVal = document.getElementById("all-tour-grid");

                    viewType = 0;

                    if (!listBtnVal.classList.contains("d-none")) {

                        viewType = 1; // list view

                    } else if (!gridBtnVal.classList.contains("d-none")) {

                        viewType = 2; // grid view

                    }

                    fetchSortedProducts(
                        page,
                        sortValue,
                        prices.minPrice,
                        prices.maxPrice,
                        minDuration,
                        maxDuration,
                        selectedDestination,
                        tourType,
                        viewType
                    );
                }
            );

            function getCurrentFilters() {

                priceRange = $("#amount").val();

                prices = extractPrices(priceRange);

                sortValue = $(".sort-options").val();

                minDuration = $("#slider-range-duration").slider("values", 0);

                maxDuration = $("#slider-range-duration").slider("values", 1);

                tourType = getTourType() ?? 0;

                listBtnVal = document.getElementById("all-tour-list");

                gridBtnVal = document.getElementById("all-tour-grid");

                viewType = 0;

                if (listBtnVal && !listBtnVal.classList.contains("d-none")) {

                    viewType = 1;

                } else if (gridBtnVal && !gridBtnVal.classList.contains("d-none")) {

                    viewType = 2;
                }
            } 
            
            function applyFilters(viewType=1) {

                getCurrentFilters();

                fetchSortedProducts(
                    page,
                    sortValue,
                    prices.minPrice,
                    prices.maxPrice,
                    minDuration,
                    maxDuration,
                    selectedDestination,
                    tourType,
                    viewType
                );
            }
            $(document).ready(function () {

                const wrapper = document.querySelector(
                    ".destination-search-wrapper"
                );

                const input = document.getElementById(
                    "destinationSearch"
                );

                const suggestions = document.getElementById(
                    "destinationSuggestions"
                );

                const clearBtn = document.getElementById(
                    "destinationClear"
                );

                const arrow = document.getElementById(
                    "destinationArrow"
                );

                const options = Array.from(
                    document.querySelectorAll(
                        ".destination-option"
                    )
                );


                /* ==========================================
                OPEN DROPDOWN
                ========================================== */

                input.addEventListener("focus", function () {

                    wrapper.classList.add("active");

                    filterDestinations();

                });


                input.addEventListener("click", function () {

                    wrapper.classList.add("active");

                    filterDestinations();

                });


                /* ==========================================
                SEARCH DESTINATIONS
                ========================================== */

                input.addEventListener("input", function () {

                    filterDestinations();

                });


                function filterDestinations() {

                    const searchValue = input.value
                        .trim()
                        .toLowerCase();

                    let matchCount = 0;


                    // options.forEach(function (option) {

                    //     const destination = option
                    //         .dataset.value
                    //         .toLowerCase();

                    //     if (
                    //         searchValue === "" ||
                    //         destination.includes(searchValue)
                    //     ) {

                    //         option.style.display = "flex";

                    //         matchCount++;

                    //     } else {

                    //         option.style.display = "none";

                    //     }

                    // });
                    options.forEach(function (option) {

                        const destination = (option.dataset.value || "").toLowerCase();

                        const name = (
                            option.querySelector(".destination-option-text strong")?.textContent || ""
                        ).trim().toLowerCase();

                        if (
                            searchValue === "" ||
                            destination.includes(searchValue) ||
                            name.includes(searchValue)
                        ) {

                            option.style.display = "flex";
                            matchCount++;

                        } else {

                            option.style.display = "none";

                        }

                    });


                    /* Remove old no-result message */

                    const oldNoResult =
                        suggestions.querySelector(
                            ".destination-no-result"
                        );

                    if (oldNoResult) {
                        oldNoResult.remove();
                    }


                    /* No results */

                    if (matchCount === 0) {

                        const noResult =
                            document.createElement("div");

                        noResult.className =
                            "destination-no-result";

                        noResult.textContent =
                            "No matching destinations found";

                        suggestions.appendChild(noResult);
                    }


                    /* Clear button */

                    clearBtn.style.display =
                        searchValue ? "block" : "none";
                }


                /* ==========================================
                SELECT DESTINATION
                ========================================== */

                options.forEach(function (option) {

                    option.addEventListener("click", function () {

                        const value =
                            this.dataset.value;


                        selectedDestination = value;

                        selectedText = value;

                        selectedId = value;


                        /* Set input */

                        input.value = value;


                        /* Selected class */

                        options.forEach(function (item) {

                            item.classList.remove(
                                "selected"
                            );

                        });

                        this.classList.add("selected");


                        /* Close dropdown */

                        wrapper.classList.remove("active");


                        /* Show clear */

                        clearBtn.style.display = "block";


                        console.log(
                            "Selected destination:",
                            selectedDestination
                        );


                        /* Reset page */

                        page = 1;


                        /* Apply filters */

                        applyFilters();

                    });

                });


                /* ==========================================
                CLEAR DESTINATION
                ========================================== */

                clearBtn.addEventListener("click", function (e) {

                    e.preventDefault();

                    e.stopPropagation();


                    input.value = "";

                    selectedDestination = "";

                    selectedText = "";

                    selectedId = null;


                    options.forEach(function (option) {

                        option.classList.remove(
                            "selected"
                        );

                        option.style.display = "flex";

                    });


                    clearBtn.style.display = "none";


                    page = 1;


                    /* Apply filters without destination */

                    applyFilters();


                    input.focus();

                });


                /* ==========================================
                CLICK ARROW
                ========================================== */

                arrow.addEventListener("click", function (e) {

                    e.preventDefault();

                    e.stopPropagation();

                    input.focus();

                    wrapper.classList.add("active");

                    filterDestinations();

                });


                /* ==========================================
                CLICK OUTSIDE
                ========================================== */

                document.addEventListener("click", function (e) {

                    if (!wrapper.contains(e.target)) {

                        wrapper.classList.remove(
                            "active"
                        );

                    }

                });

            });
        </script>
    </body>
</html>