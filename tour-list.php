<?php
session_start();

if (isset($_SESSION['user_type_id_value'])) {
    $user_type = $_SESSION["user_type_id_value"];
    $user_id = $_SESSION["user_id"];
} else {
    $user_type = 0;
    $user_id = 0;
}
?>
<!DOCTYPE html>
<html lang="zxx" dir="lrt">

<!-- Mirrored from travelloo.vercel.app/template/tour-list.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 12 Jul 2024 06:53:04 GMT -->
<!-- Added by HTTrack -->
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
        <!-- Breadcrumbs S t a r t -->
        <section class="breadcrumbs-area breadcrumb-bg">
            <div class="container">
                <h1 class="title wow fadeInUp" data-wow-delay="0.0s">Tour List</h1>
                <div class="breadcrumb-text">
                    <nav aria-label="breadcrumb" class="breadcrumb-nav wow fadeInUp" data-wow-delay="0.1s">
                        <ul class="breadcrumb listing">
                            <li class="breadcrumb-item single-list"><a href="index.php" class="single">Home</a></li>
                            <li class="breadcrumb-item single-list" aria-current="page"><a href="javascript:void(0)"
                                    class="single active">Tour List</a></li>
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
                            <div class="tour-search">
                                <div class="select-dropdown-section">
                                    <div class="d-flex gap-10 align-items-center">
                                        <i class="ri-map-pin-line"></i>
                                        <h4 class="select2-title">Destination</h4>
                                    </div>
                                    <select class="destination-dropdown">
                                    </select>
                                </div>
                            </div>

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
                                <div class="ratting-checkbox">
                                    <input type="checkbox" id="3" checked>
                                    <div>
                                        <span>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="13"
                                                viewBox="0 0 14 13" fill="none">
                                                <path
                                                    d="M6.09749 0.891366C6.45972 0.132244 7.54028 0.132244 7.90251 0.891366L9.07038 3.33882C9.21616 3.64433 9.5066 3.85534 9.84221 3.89958L12.5308 4.25399C13.3647 4.36391 13.6986 5.39158 13.0885 5.97067L11.1218 7.83768C10.8763 8.07073 10.7653 8.41217 10.827 8.74502L11.3207 11.4115C11.4739 12.2386 10.5997 12.8737 9.86041 12.4725L7.47702 11.1789C7.1795 11.0174 6.8205 11.0174 6.52298 11.1789L4.13959 12.4725C3.40033 12.8737 2.52614 12.2386 2.67929 11.4115L3.17304 8.74502C3.23467 8.41217 3.12373 8.07073 2.87823 7.83768L0.911452 5.97067C0.301421 5.39158 0.635332 4.36391 1.46924 4.25399L4.15779 3.89958C4.4934 3.85534 4.78384 3.64433 4.92962 3.33882L6.09749 0.891366Z"
                                                    fill="#FFB400" />
                                            </svg>
                                            3
                                        </span>
                                    </div>
                                </div>
                                <div class="ratting-checkbox">
                                    <input type="checkbox" id="4">
                                    <div>
                                        <span>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="13"
                                                viewBox="0 0 14 13" fill="none">
                                                <path
                                                    d="M6.09749 0.891366C6.45972 0.132244 7.54028 0.132244 7.90251 0.891366L9.07038 3.33882C9.21616 3.64433 9.5066 3.85534 9.84221 3.89958L12.5308 4.25399C13.3647 4.36391 13.6986 5.39158 13.0885 5.97067L11.1218 7.83768C10.8763 8.07073 10.7653 8.41217 10.827 8.74502L11.3207 11.4115C11.4739 12.2386 10.5997 12.8737 9.86041 12.4725L7.47702 11.1789C7.1795 11.0174 6.8205 11.0174 6.52298 11.1789L4.13959 12.4725C3.40033 12.8737 2.52614 12.2386 2.67929 11.4115L3.17304 8.74502C3.23467 8.41217 3.12373 8.07073 2.87823 7.83768L0.911452 5.97067C0.301421 5.39158 0.635332 4.36391 1.46924 4.25399L4.15779 3.89958C4.4934 3.85534 4.78384 3.64433 4.92962 3.33882L6.09749 0.891366Z"
                                                    fill="#FFB400" />
                                            </svg>
                                            4
                                        </span>
                                    </div>
                                </div>
                                <div class="ratting-checkbox">
                                    <input type="checkbox" id="5">
                                    <div>
                                        <span>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="13"
                                                viewBox="0 0 14 13" fill="none">
                                                <path
                                                    d="M6.09749 0.891366C6.45972 0.132244 7.54028 0.132244 7.90251 0.891366L9.07038 3.33882C9.21616 3.64433 9.5066 3.85534 9.84221 3.89958L12.5308 4.25399C13.3647 4.36391 13.6986 5.39158 13.0885 5.97067L11.1218 7.83768C10.8763 8.07073 10.7653 8.41217 10.827 8.74502L11.3207 11.4115C11.4739 12.2386 10.5997 12.8737 9.86041 12.4725L7.47702 11.1789C7.1795 11.0174 6.8205 11.0174 6.52298 11.1789L4.13959 12.4725C3.40033 12.8737 2.52614 12.2386 2.67929 11.4115L3.17304 8.74502C3.23467 8.41217 3.12373 8.07073 2.87823 7.83768L0.911452 5.97067C0.301421 5.39158 0.635332 4.36391 1.46924 4.25399L4.15779 3.89958C4.4934 3.85534 4.78384 3.64433 4.92962 3.33882L6.09749 0.891366Z"
                                                    fill="#FFB400" />
                                            </svg>
                                            5
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="cover"></div>
                    </div>
                    <div class="col-xl-9">
                        <div class="showing-result d-flex justify-content-end">
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
                                        <option value="popular"> Sort by Popular</option>
                                        <option value="low">Price low to high</option>
                                        <option value="high">Price high to low</option>
                                        <option value="new">Sort by Newset</option>
                                    </select>
                                </div>
                            </div>
                        </div>
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
                                    if ($user_type == '2') {
                                        $ta_data = $conn->prepare("SELECT * FROM customer WHERE cust_id = '" . $user_id . "' ");
                                        $ta_data->execute();
                                        $ta = $ta_data->fetch();
                                        $ta_id = $ta['ta_reference'];
                                    } else if ($user_type == '3') {
                                        $ta_id = $user_id;
                                    }
                                }

                                $stmt = $conn->prepare(" SELECT p.id,p.created_date, p.name,p.description, p.destination, p.location, t.net_price_adult_with_GST, t.markup_total, COUNT(b.package_id) AS booking_count FROM package p JOIN package_pricing t ON p.id = t.package_id JOIN category c ON p.category_id = c.id LEFT JOIN bookings b ON b.package_id = p.id WHERE p.status = '1' GROUP BY p.id, p.description, p.destination, p.location, t.net_price_adult_with_GST, t.markup_total ORDER BY booking_count DESC, p.id  ");
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
                                        $total_base_price = $adult_price + $markup_price;

                                        if ($ta_id) {
                                            $ta_markup_data = $conn->prepare("SELECT * FROM package_markup_travelagent WHERE travelagent_id = '" . $ta_id . "' AND package_id = '" . $row['id'] . "' AND status='1' LIMIT 1");
                                            $ta_markup_data->execute();
                                            $ta_markup = $ta_markup_data->fetch();

                                            $total_price = $ta_markup['selling_price'] ?? $total_base_price;
                                        } else {
                                            $total_price = $total_base_price;
                                        }

                                        echo '
                                            <div class="col-xl-4 col-lg-4 col-sm-6">
                                                <div class="package-card">
                                                    <div class="package-img imgEffect4">
                                                        <a href="#" onclick=\'viewPackage("' . $row['id'] . '")\'>
                                                            <img src="' . $value['image'] . '" alt="BizzMirth">
                                                        </a>
                                                        <!-- <div class="image-badge">
                                                            <p class="pera">Featured</p>
                                                        </div> -->
                                                    </div>
                                                    <div class="package-content">
                                                        <h4 class="area-name">
                                                            <a href="#" onclick=\'viewPackage("' . $row['id'] . '")\'>' . $row['name'] . '</a>
                                                        </h4>
                                                        <div class="location">
                                                            <i class="ri-map-pin-line"></i>
                                                            <div class="name">' . $row['destination'] . '</div>
                                                        </div>
                                                        <div class="packages-person">
                                                            <div class="count">
                                                                <i class="ri-time-line"></i>
                                                                <p class="pera">' . $row['location'] . '</p>
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
            return selected;
        }

        function fetchSortedProducts(sortValue, minPrice, maxPrice, minDuration, maxDuration,destination) {
            let ratings = getSelectedRatings(); // get selected ratings

            $.ajax({
                url: "assets/submit/fetch_sorted_products.php",
                type: "POST",
                data: {
                    sort: sortValue,
                    userid: userid,
                    usertype: usertype,
                    minPrice: minPrice,
                    maxPrice: maxPrice,
                    minDuration: minDuration,
                    maxDuration: maxDuration,
                    ratings: ratings, // send ratings array
                    destination: destination
                },
                success: function(response) {
                    $("#all-tour-list").html(response);
                },
                error: function(xhr, status, error) {
                    console.error("AJAX Error:", error);
                }
            });
        }

        // Run AJAX on sort change
        $(".sort-options").on("change", function() {
            var sortValue = $(this).val();
            var priceRange = $("#amount").val();
            let prices = extractPrices(priceRange);

            let minDuration = $("#slider-range-duration").slider("values", 0);
            let maxDuration = $("#slider-range-duration").slider("values", 1);
            let selectedDescription = $(".destination-dropdown").find("option:selected").data("description") ?? null;


            fetchSortedProducts(sortValue, prices.minPrice, prices.maxPrice, minDuration, maxDuration, selectedDescription);
        });

        // Run AJAX on price change
        $("#amount").on("change", function() {
            var priceRange = $(this).val();
            let prices = extractPrices(priceRange);
            var sortValue = $(".sort-options").val();

            let minDuration = $("#slider-range-duration").slider("values", 0);
            let maxDuration = $("#slider-range-duration").slider("values", 1);

            let selectedDescription = $(".destination-dropdown").find("option:selected").data("description") ?? null;


            fetchSortedProducts(sortValue, prices.minPrice, prices.maxPrice, minDuration, maxDuration, selectedDescription);
        });

        // Run AJAX on rating checkbox change
        $(".ratting-section input[type='checkbox']").on("change", function() {
            var priceRange = $("#amount").val();
            let prices = extractPrices(priceRange);
            var sortValue = $(".sort-options").val();

            let minDuration = $("#slider-range-duration").slider("values", 0);
            let maxDuration = $("#slider-range-duration").slider("values", 1);

            let selectedDescription = $(".destination-dropdown").find("option:selected").data("description") ?? null;


            fetchSortedProducts(sortValue, prices.minPrice, prices.maxPrice, minDuration, maxDuration, selectedDescription);
        });

        $(document).ready(function() {
            //loadDestinations();

            var priceRange = $("#amount").val();
            let prices = extractPrices(priceRange);
            var sortValue = $(".sort-options").val();
            let minDuration = $("#slider-range-duration").slider("values", 0);
            let maxDuration = $("#slider-range-duration").slider("values", 1);
            let selectedDescription = $(".destination-dropdown").find("option:selected").data("description") ?? null;


            console.log("Description:", selectedDescription);
            fetchSortedProducts(sortValue, prices.minPrice, prices.maxPrice, minDuration, maxDuration,selectedDescription);
        });
        $(document).on("change", ".destination-dropdown", function() {
            let selectedId = $(this).val(); // gets the selected ID
            let selectedText = $(this).find("option:selected").text(); // gets the selected text
            let selectedDescription = $(this).find("option:selected").data("description");
            var priceRange = $("#amount").val();
            let prices = extractPrices(priceRange);
            var sortValue = $(".sort-options").val();
            let minDuration = $("#slider-range-duration").slider("values", 0);
            let maxDuration = $("#slider-range-duration").slider("values", 1);
            
            console.log("Destination Changed:");
            console.log("ID:", selectedId);
            console.log("Text:", selectedText);
            console.log("Description:", selectedDescription);

            fetchSortedProducts(sortValue, prices.minPrice, prices.maxPrice, minDuration, maxDuration, selectedDescription);
        });

        // duration slider
        // $("#slider-range-duration").slider({
        //     range: true,
        //     min: 1,
        //     max: 10,
        //     values: [1, 8],
        //     slide: function(event, ui) {
        //         $("#duration-min").text(ui.values[0]);
        //         $("#duration-max").text(ui.values[1]);
        //         var sortValue = $(".sort-options").val();
        //         var priceRange = $("#amount").val();
        //         let prices = extractPrices(priceRange);
        //         let selectedDescription = $(".destination-dropdown").find("option:selected").data("description") ?? null;


        //         fetchSortedProducts(sortValue, prices.minPrice, prices.maxPrice, minDuration, maxDuration, selectedDescription);
        //         //fetchSortedProducts("popular", prices.minPrice, prices.maxPrice, ui.values[0], ui.values[1]);
        //     },
        //     change: function(event, ui) {
        //         var priceRange = $("#amount").val();
        //         let prices = extractPrices(priceRange);
        //         let selectedDescription = $(".destination-dropdown").find("option:selected").data("description") ?? null;

        //         var sortValue = $(".sort-options").val();
        //         fetchSortedProducts(sortValue, prices.minPrice, prices.maxPrice, minDuration, maxDuration, selectedDescription);
        //     }
        // });
    </script>

</body>

</html>