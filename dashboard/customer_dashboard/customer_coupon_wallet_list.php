<?php
    include_once '../dashboard_user_details.php';
    include 'customer_model.php';

?>
<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable">
    <head>
        <meta charset="utf-8" />
        <title>Dashboard | Uniqbizz</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- App favicon -->
        <link rel="shortcut icon" href="../assets/images/fav.png">

        <!-- jsvectormap css -->
        <link href="../assets/libs/jsvectormap/css/jsvectormap.min.css" rel="stylesheet" type="text/css" />

        <!--Swiper slider css-->
        <link href="../assets/libs/swiper/swiper-bundle.min.css" rel="stylesheet" type="text/css" />

        <!-- Layout config Js -->
        <script src="../assets/js/layout.js"></script>
        <!-- Bootstrap Css -->
        <link href="../assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <!-- Icons Css -->
        <link href="../assets/css/icons.min.css" rel="stylesheet" type="text/css" />
        <!-- App Css-->
        <link href="../assets/css/app.min.css" rel="stylesheet" type="text/css" />
        <!-- custom Css-->
        <link href="../assets/css/custom.min.css" rel="stylesheet" type="text/css" />
        <!-- custom Css developer-->
        <link rel="stylesheet" href="../assets/css/custom.css" />
        <!-- Customer Dashboard CSS -->
        <link rel="stylesheet" href="../assets/css/customer_dashboard.css" />

        <!-- FontAwesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel="stylesheet" href="../assets/css/customer_coupon_wallet.css" />
    </head>

    <body class="twocolumn-panel">
        <!-- Begin page -->
        <div id="layout-wrapper">
            <?php include_once "customer_header.php" ?>

            <!-- removeNotificationModal -->
            <div id="removeNotificationModal" class="modal fade zoomIn" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="NotificationModalbtn-close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mt-2 text-center">
                                <lord-icon src="../../../../cdn.lordicon.com/gsqxdxog.json" trigger="loop" colors="primary:#f7b84b,secondary:#f06548" style="width:100px;height:100px"></lord-icon>
                                <div class="mt-4 pt-2 fs-15 mx-4 mx-sm-5">
                                    <h4>Are you sure ?</h4>
                                    <p class="text-muted mx-4 mb-0">Are you sure you want to remove this Notification ?</p>
                                </div>
                            </div>
                            <div class="d-flex gap-2 justify-content-center mt-4 mb-2">
                                <button type="button" class="btn w-sm btn-light" data-bs-dismiss="modal">Close</button>
                                <button type="button" class="btn w-sm btn-danger" id="delete-notification">Yes, Delete It!</button>
                            </div>
                        </div>

                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->
            <!-- ========== App Menu ========== -->

            <?php include_once "customer_sidebar.php" ?>
            <!-- ============================================================== -->
            <!-- Start of Customer Dashboard here -->
            <!-- ============================================================== -->
            <div class="main-content">
                <div class="page-content">
                    <div class="container-fluid ps-0">
                        <div class="coupon-page">

                            <!-- TITLE -->

                            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">

                                <div>
                                    <h1 class="coupon-title">My Coupons</h1>
                                    <div class="coupon-subtitle">
                                        Use your coupons to save more on your next trip.
                                    </div>
                                </div>

                                <button class="btn help-btn">
                                    <i class="fa-regular fa-circle-play me-2"></i>
                                    How to Use Coupons
                                </button>

                            </div>

                            <!-- SUMMARY -->

                            <div class="summary-card">

                                <div class="summary-top">

                                    <div class="row align-items-center g-4">

                                        <div class="col-lg-3">

                                            <div class="coupon-ticket">

                                                <div class="ticket-count">30</div>

                                                <div class="ticket-label">
                                                    COUPONS
                                                </div>

                                            </div>

                                        </div>

                                        <div class="col-lg-9">

                                            <div class="row">

                                                <div class="col-md-3 summary-stat">

                                                    <div class="stat-label">
                                                        Total Coupons
                                                    </div>

                                                    <div class="stat-value">
                                                        30
                                                    </div>

                                                </div>

                                                <div class="col-md-3 summary-stat">

                                                    <div class="stat-label">
                                                        Used Coupons
                                                    </div>

                                                    <div class="stat-value">
                                                        12
                                                    </div>

                                                </div>

                                                <div class="col-md-3 summary-stat">

                                                    <div class="stat-label">
                                                        Available Coupons
                                                    </div>

                                                    <div class="stat-value green">
                                                        18
                                                    </div>

                                                </div>

                                                <div class="col-md-3 summary-stat">

                                                    <div class="stat-label">
                                                        Total Value
                                                    </div>

                                                    <div class="stat-value purple">
                                                        ₹15,000
                                                    </div>

                                                </div>

                                            </div>

                                        </div>

                                    </div>

                                </div>

                                <!-- FEATURE STRIP -->

                                <div class="feature-strip">

                                    <div class="row text-center g-3">

                                        <div class="col-md-4">
                                            <div class="feature-item">
                                                <i class="fa-solid fa-ticket"></i>
                                                1 Coupon = ₹500
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="feature-item">
                                                <i class="fa-regular fa-user"></i>
                                                1 Coupon per passenger per booking
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="feature-item">
                                                <i class="fa-solid fa-ban"></i>
                                                Cannot be encashed or transferred
                                            </div>
                                        </div>

                                    </div>

                                </div>

                            </div>

                            <!-- TABLE CARD -->

                            <div class="coupon-tabs">

                                <!-- TABS -->

                                <!-- =========================
                                COUPON TABLE TABS
                                ========================= -->

                                <div class="tabs-wrapper">

                                    <div class="coupon-tabs-nav mb-2">

                                        <button class="coupon-tab active" data-filter="all">
                                            <span class="tab-title">All Coupons</span>
                                            <span class="tab-count">13</span>
                                        </button>

                                        <button class="coupon-tab available-tab" data-filter="available">
                                            <span class="tab-title">Available</span>
                                            <span class="tab-count">6</span>
                                        </button>

                                        <button class="coupon-tab used-tab" data-filter="used">
                                            <span class="tab-title">Used</span>
                                            <span class="tab-count">4</span>
                                        </button>

                                        <button class="coupon-tab expired-tab" data-filter="expired">
                                            <span class="tab-title">Expired</span>
                                            <span class="tab-count">3</span>
                                        </button>

                                    </div>

                                </div>

                                <!-- =========================
                                TABLE
                                ========================= -->

                                <div class="table-responsive">

                                    <table class="coupon-table">

                                        <thead>

                                            <tr>
                                                <th>Coupon Code</th>
                                                <th>Value</th>
                                                <th>Status</th>
                                                <th>Credited On</th>
                                                <th>Applied On</th>
                                                <th>Used On</th>
                                            </tr>

                                        </thead>

                                        <tbody id="couponTableBody">

                                            <!-- AVAILABLE -->

                                            <tr data-status="available">

                                                <td>
                                                    <div class="coupon-box">
                                                        NSC25050001
                                                        <div>₹500</div>
                                                    </div>
                                                </td>

                                                <td class="coupon-price">₹500</td>

                                                <td>
                                                    <span class="status-badge status-available">
                                                        Available
                                                    </span>
                                                </td>

                                                <td>
                                                    30 Jun 2025
                                                    <div class="days-left">40 Days Left</div>
                                                </td>

                                                <td>
                                                    <div class="applicable-item">
                                                        <i class="fa-solid fa-gift"></i>
                                                        Holiday Packages
                                                    </div>

                                                    <div class="applicable-item">
                                                        <i class="fa-solid fa-mountain"></i>
                                                        Weekend Escapes
                                                    </div>
                                                </td>

                                                <td class="text-muted">—</td>

                                            </tr>

                                            <!-- AVAILABLE -->

                                            <tr data-status="available">

                                                <td>
                                                    <div class="coupon-box">
                                                        NSC25050002
                                                        <div>₹500</div>
                                                    </div>
                                                </td>

                                                <td class="coupon-price">₹500</td>

                                                <td>
                                                    <span class="status-badge status-available">
                                                        Available
                                                    </span>
                                                </td>

                                                <td>
                                                    18 Jul 2025
                                                    <div class="days-left">58 Days Left</div>
                                                </td>

                                                <td>
                                                    <div class="applicable-item">
                                                        <i class="fa-solid fa-plane"></i>
                                                        Flights
                                                    </div>

                                                    <div class="applicable-item">
                                                        <i class="fa-solid fa-hotel"></i>
                                                        Hotels
                                                    </div>
                                                </td>

                                                <td class="text-muted">—</td>

                                            </tr>

                                            <!-- AVAILABLE -->

                                            <tr data-status="available">

                                                <td>
                                                    <div class="coupon-box">
                                                        NSC25050003
                                                        <div>₹1,000</div>
                                                    </div>
                                                </td>

                                                <td class="coupon-price">₹1,000</td>

                                                <td>
                                                    <span class="status-badge status-available">
                                                        Available
                                                    </span>
                                                </td>

                                                <td>
                                                    25 Aug 2025
                                                    <div class="days-left">96 Days Left</div>
                                                </td>

                                                <td>

                                                    <div class="applicable-item">
                                                        <i class="fa-solid fa-calendar-days"></i>
                                                        Events
                                                    </div>

                                                    <div class="applicable-item">
                                                        <i class="fa-solid fa-ship"></i>
                                                        Cruise Packages
                                                    </div>

                                                </td>

                                                <td class="text-muted">—</td>

                                            </tr>

                                            <!-- USED -->

                                            <tr data-status="used">

                                                <td>
                                                    <div class="coupon-box">
                                                        NSC25050004
                                                        <div>₹500</div>
                                                    </div>
                                                </td>

                                                <td class="coupon-price">₹500</td>

                                                <td>
                                                    <span class="status-badge status-used">
                                                        Used
                                                    </span>
                                                </td>

                                                <td>
                                                    25 May 2025
                                                    <div class="text-muted">Expired After Use</div>
                                                </td>

                                                <td>

                                                    <div class="applicable-item">
                                                        <i class="fa-solid fa-umbrella-beach"></i>
                                                        Goa Beach Escape
                                                    </div>

                                                    <small class="text-muted">
                                                        Booking ID: BK240518
                                                    </small>

                                                </td>

                                                <td>
                                                    26 May 2025
                                                    <div class="text-muted">
                                                        04:45 PM
                                                    </div>
                                                </td>

                                            </tr>

                                            <!-- USED -->

                                            <tr data-status="used">

                                                <td>
                                                    <div class="coupon-box">
                                                        NSC25050005
                                                        <div>₹750</div>
                                                    </div>
                                                </td>

                                                <td class="coupon-price">₹750</td>

                                                <td>
                                                    <span class="status-badge status-used">
                                                        Used
                                                    </span>
                                                </td>

                                                <td>
                                                    15 Apr 2025
                                                    <div class="text-muted">
                                                        Expired After Use
                                                    </div>
                                                </td>

                                                <td>

                                                    <div class="applicable-item">
                                                        <i class="fa-solid fa-tree"></i>
                                                        Kerala Retreat
                                                    </div>

                                                    <small class="text-muted">
                                                        Booking ID: BK240411
                                                    </small>

                                                </td>

                                                <td>
                                                    21 Apr 2025
                                                    <div class="text-muted">
                                                        08:20 PM
                                                    </div>
                                                </td>

                                            </tr>

                                            <!-- AVAILABLE -->

                                            <tr data-status="available">

                                                <td>
                                                    <div class="coupon-box">
                                                        NSC25050006
                                                        <div>₹2,000</div>
                                                    </div>
                                                </td>

                                                <td class="coupon-price">₹2,000</td>

                                                <td>
                                                    <span class="status-badge status-available">
                                                        Available
                                                    </span>
                                                </td>

                                                <td>
                                                    10 Sep 2025
                                                    <div class="days-left">112 Days Left</div>
                                                </td>

                                                <td>

                                                    <div class="applicable-item">
                                                        <i class="fa-solid fa-earth-asia"></i>
                                                        International Packages
                                                    </div>

                                                </td>

                                                <td class="text-muted">—</td>

                                            </tr>

                                            <!-- USED -->

                                            <tr data-status="used">

                                                <td>
                                                    <div class="coupon-box">
                                                        NSC25050007
                                                        <div>₹1,500</div>
                                                    </div>
                                                </td>

                                                <td class="coupon-price">₹1,500</td>

                                                <td>
                                                    <span class="status-badge status-used">
                                                        Used
                                                    </span>
                                                </td>

                                                <td>
                                                    12 Mar 2025
                                                    <div class="text-muted">
                                                        Expired After Use
                                                    </div>
                                                </td>

                                                <td>

                                                    <div class="applicable-item">
                                                        <i class="fa-solid fa-snowflake"></i>
                                                        Kashmir Winter Tour
                                                    </div>

                                                    <small class="text-muted">
                                                        Booking ID: BK240303
                                                    </small>

                                                </td>

                                                <td>
                                                    23 Mar 2025
                                                    <div class="text-muted">
                                                        10:05 AM
                                                    </div>
                                                </td>

                                            </tr>

                                            <!-- AVAILABLE -->

                                            <tr data-status="available">

                                                <td>
                                                    <div class="coupon-box">
                                                        NSC25050008
                                                        <div>₹300</div>
                                                    </div>
                                                </td>

                                                <td class="coupon-price">₹300</td>

                                                <td>
                                                    <span class="status-badge status-available">
                                                        Available
                                                    </span>
                                                </td>

                                                <td>
                                                    14 Oct 2025
                                                    <div class="days-left">146 Days Left</div>
                                                </td>

                                                <td>

                                                    <div class="applicable-item">
                                                        <i class="fa-solid fa-bus"></i>
                                                        Bus Packages
                                                    </div>

                                                </td>

                                                <td class="text-muted">—</td>

                                            </tr>

                                            <!-- USED -->

                                            <tr data-status="used">

                                                <td>
                                                    <div class="coupon-box">
                                                        NSC25050009
                                                        <div>₹900</div>
                                                    </div>
                                                </td>

                                                <td class="coupon-price">₹900</td>

                                                <td>
                                                    <span class="status-badge status-used">
                                                        Used
                                                    </span>
                                                </td>

                                                <td>
                                                    28 Feb 2025
                                                    <div class="text-muted">
                                                        Expired After Use
                                                    </div>
                                                </td>

                                                <td>

                                                    <div class="applicable-item">
                                                        <i class="fa-solid fa-city"></i>
                                                        Dubai Escape
                                                    </div>

                                                    <small class="text-muted">
                                                        Booking ID: BK240225
                                                    </small>

                                                </td>

                                                <td>
                                                    02 Mar 2025
                                                    <div class="text-muted">
                                                        07:40 PM
                                                    </div>
                                                </td>

                                            </tr>

                                            <!-- AVAILABLE -->

                                            <tr data-status="available">

                                                <td>
                                                    <div class="coupon-box">
                                                        NSC25050010
                                                        <div>₹500</div>
                                                    </div>
                                                </td>

                                                <td class="coupon-price">₹500</td>

                                                <td>
                                                    <span class="status-badge status-available">
                                                        Available
                                                    </span>
                                                </td>

                                                <td>
                                                    30 Dec 2025
                                                    <div class="days-left">190 Days Left</div>
                                                </td>

                                                <td>

                                                    <div class="applicable-item">
                                                        <i class="fa-solid fa-person-hiking"></i>
                                                        Adventure Tours
                                                    </div>

                                                </td>

                                                <td class="text-muted">—</td>

                                            </tr>
                                            <!-- EXPIRED -->

                                            <tr data-status="expired">

                                                <td>
                                                    <div class="coupon-box">
                                                        NSC25050011
                                                        <div>₹500</div>
                                                    </div>
                                                </td>

                                                <td class="coupon-price">₹500</td>

                                                <td>
                                                    <span class="status-badge status-expired">
                                                        Expired
                                                    </span>
                                                </td>

                                                <td>
                                                    10 Jan 2025

                                                    <div class="text-danger small fw-semibold">
                                                        Expired 45 Days Ago
                                                    </div>
                                                </td>

                                                <td>

                                                    <div class="applicable-item">
                                                        <i class="fa-solid fa-umbrella-beach"></i>
                                                        Beach Packages
                                                    </div>

                                                </td>

                                                <td class="text-muted">
                                                    Not Used
                                                </td>

                                            </tr>

                                            <!-- EXPIRED -->

                                            <tr data-status="expired">

                                                <td>
                                                    <div class="coupon-box">
                                                        NSC25050012
                                                        <div>₹1,000</div>
                                                    </div>
                                                </td>

                                                <td class="coupon-price">₹1,000</td>

                                                <td>
                                                    <span class="status-badge status-expired">
                                                        Expired
                                                    </span>
                                                </td>

                                                <td>
                                                    22 Feb 2025

                                                    <div class="text-danger small fw-semibold">
                                                        Expired 12 Days Ago
                                                    </div>
                                                </td>

                                                <td>

                                                    <div class="applicable-item">
                                                        <i class="fa-solid fa-plane-departure"></i>
                                                        International Flights
                                                    </div>

                                                </td>

                                                <td class="text-muted">
                                                    Not Used
                                                </td>

                                            </tr>

                                            <!-- EXPIRED -->

                                            <tr data-status="expired">

                                                <td>
                                                    <div class="coupon-box">
                                                        NSC25050013
                                                        <div>₹750</div>
                                                    </div>
                                                </td>

                                                <td class="coupon-price">₹750</td>

                                                <td>
                                                    <span class="status-badge status-expired">
                                                        Expired
                                                    </span>
                                                </td>

                                                <td>
                                                    05 Mar 2025

                                                    <div class="text-danger small fw-semibold">
                                                        Expired 5 Days Ago
                                                    </div>
                                                </td>

                                                <td>

                                                    <div class="applicable-item">
                                                        <i class="fa-solid fa-hotel"></i>
                                                        Hotel Bookings
                                                    </div>

                                                </td>

                                                <td class="text-muted">
                                                    Not Used
                                                </td>

                                            </tr>

                                        </tbody>

                                    </table>

                                </div>

                            </div>

                            <!-- IMPORTANT -->

                            <div class="important-box">

                                <div class="important-title">
                                    Important Information
                                </div>

                                <div class="row g-4">

                                    <div class="col-lg-4">

                                        <div class="important-item">

                                            <i class="fa-solid fa-ticket"></i>

                                            <div>
                                                Coupons are applicable on Holiday Packages, Weekend Escapes & Events only.
                                            </div>

                                        </div>

                                    </div>

                                    <div class="col-lg-4">

                                        <div class="important-item">

                                            <i class="fa-regular fa-calendar-check"></i>

                                            <div>
                                                Coupons must be applied at the time of booking confirmation.
                                            </div>

                                        </div>

                                    </div>

                                    <div class="col-lg-4">

                                        <div class="important-item">

                                            <i class="fa-solid fa-ban"></i>

                                            <div>
                                                Expired coupons cannot be reactivated or refunded.
                                            </div>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>
                    </div>
                </div>
                <?php include_once "customer_footer.php" ?>
            </div>

            <!-- end main content-->
            <!-- End of Customer Dashboard here -->
            <!-- ============================================================== -->
        </div>
        <!--start back-to-top-->
        <button onclick="topFunction()" class="scrollToTop scroll-btn show btn" id="back-to-top">
            <i class="ri-arrow-up-line"></i>
        </button>
        <!--end back-to-top-->
        <!-- contact card pop up  start-->
        <button type="button" class="contactBtn btn" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
            <i class="ri-phone-fill"></i>
        </button>
        <div class="modal fade" id="staticBackdrop" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel">
            <div class="modal-dialog modal-sm me-4">
                <div class="modal-content rounded-4 border-1">
                    <div class="modal-header border-0">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center">
                        <img src="assets/images/img-bot.png" alt="image-bot" class="mb-3">
                        <h5 class="fw-bold" id="staticBackdropLabel">
                            Hi, how can we help?
                        </h5>
                        <p class="text-muted px-1">
                            Contact us if you need assistance.
                            We will respond as soon as possible.
                        </p>
                        <div class="d-grid col-10 mx-auto">
                            <a class="btn btn-primary rounded-3" href="tel:8010892265" id="callBtn">
                                <i class="ri-phone-fill"></i>
                                8010892265
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- contact card pop up end-->

        <!-- JAVASCRIPT -->
        <script src="../assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="../assets/libs/simplebar/simplebar.min.js"></script>
        <script src="../assets/libs/node-waves/waves.min.js"></script>
        <script src="../assets/libs/feather-icons/feather.min.js"></script>
        <script src="../assets/js/jquery/jquery-3.7.1.min.js"></script>

        <!-- !-- materialdesign remix icon js- -->
        <script src="../assets/js/pages/remix-icons-listing.js"></script>

        <!-- Vector map-->
        <script src="../assets/libs/jsvectormap/js/jsvectormap.min.js"></script>
        <script src="../assets/libs/jsvectormap/maps/world-merc.js"></script>

        <!--Swiper slider js-->
        <script src="../assets/libs/swiper/swiper-bundle.min.js"></script>

        <!-- App js -->
        <script src="../assets/js/app.js"></script>

        <script src="../assets/libs/chart.js/Chart-2.5.0.min.js"></script>


        <!-- Dashboard init  popular candidates section js file-->
        <script src="../assets/js/pages/dashboard-job.init.js"></script>

        <script src="../assets/js/js-confetti.js"></script>

        <script>
            var userType= document.getElementById("user_type").value;
            function highlightSelected(id) {
                // Remove highlight from all list items
                document.querySelectorAll("li[id^='list-item-']").forEach(function(el) {
                    el.classList.remove("selected-li");
                });

                // Add highlight to the selected one
                const selected = document.getElementById(id);
                if (selected) {
                    selected.classList.add("selected-li");
                }
            }
        </script>
        
        <script>
            function highlightSelected(id) {
                // Remove highlight from all items
                document.querySelectorAll('li[id^="list-item-"]').forEach(function(el) {
                    el.classList.remove('active-highlight');
                });

                // Add highlight to the clicked item
                const selectedItem = document.getElementById(id);
                if (selectedItem) {
                    selectedItem.classList.add('active-highlight');
                }
            }
        </script>
        
        <script>
            document.addEventListener("DOMContentLoaded", function () {

                const callBtn = document.getElementById("callBtn");

                if (callBtn) {
                    callBtn.addEventListener("click", function(e) {

                        let isMobile = /iPhone|iPad|iPod|Android/i.test(navigator.userAgent);

                        if (!isMobile) {
                            e.preventDefault();

                            alert("📞 Calling works only on mobile devices.\nPlease dial 8010892265 from your phone.");
                            location.reload();

                            // Optional clipboard copy (safe fallback)
                            if (navigator.clipboard) {
                                navigator.clipboard.writeText("8010892265");
                            }
                        }
                    });
                }

            });
        </script>

        <script>
            var modal = document.getElementById('staticBackdrop');

            // Store the element that opened the modal
            let lastFocusedElement;

            document.addEventListener('click', function(e) {
                if (e.target.closest('[data-bs-toggle="modal"]')) {
                    lastFocusedElement = e.target;
                }
            });

            modal.addEventListener('hidden.bs.modal', function () {
                if (lastFocusedElement) {
                    lastFocusedElement.focus();
                } else {
                    document.body.focus();
                }
            });
        </script>
        <script>
            document.addEventListener("DOMContentLoaded", function () {

                const sidebar = document.querySelector(".navbar-menu");
                const hamburger = document.getElementById("topnav-hamburger-icon");
                const overlay = document.querySelector(".vertical-overlay");

                /* DEFAULT DESKTOP */
                if (window.innerWidth > 1024) {
                    sidebar.classList.remove("sidebar-hidden");
                }

                hamburger.addEventListener("click", function () {

                    /* BELOW 1024 */
                    if (window.innerWidth <= 1024) {

                        sidebar.classList.toggle("sidebar-mobile-show");

                        /* OVERLAY ONLY BELOW 768 */
                        if (window.innerWidth <= 768) {
                            overlay.classList.toggle("active");
                        }

                    } else {

                        /* DESKTOP */
                        sidebar.classList.toggle("sidebar-hidden");
                    }
                });

                /* CLOSE ONLY MOBILE */
                if (window.innerWidth <= 768) {

                    overlay.addEventListener("click", function () {

                        sidebar.classList.remove("sidebar-mobile-show");
                        overlay.classList.remove("active");

                    });
                }

            });

        </script>
        <script>
            // Get values directly from HTML
            const completed = parseInt(document.getElementById("completedYears").innerText);
            const total = parseInt(document.getElementById("totalYears").innerText);

            // Calculate percentage
            const percentage = (completed / total) * 100;

            // Update progress bar
            document.getElementById("yearProgressBar").style.width = percentage + "%";
        </script>

        <!-- dialer logic -->

        <!-- table tabs -->
         <!-- =========================
            JS FILTER
            ========================= -->

            <script>

                const tabs = document.querySelectorAll('.coupon-tab');
                const rows = document.querySelectorAll('#couponTableBody tr');

                tabs.forEach(tab => {

                    tab.addEventListener('click', function () {

                        // REMOVE ACTIVE CLASS
                        tabs.forEach(btn => {
                            btn.classList.remove('active');
                        });

                        // ADD ACTIVE CLASS
                        this.classList.add('active');

                        // GET FILTER VALUE
                        const filter = this.dataset.filter;

                        // FILTER TABLE ROWS
                        rows.forEach(row => {

                            const status = row.dataset.status;

                            if(filter === 'all' || status === filter){

                                row.style.display = 'table-row';

                            }else{

                                row.style.display = 'none';

                            }

                        });

                    });

                });

            </script>
    </body>
</html>