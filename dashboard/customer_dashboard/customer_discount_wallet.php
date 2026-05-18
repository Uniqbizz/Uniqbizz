<?php
    include_once 'dashboard_user_details.php';
    include 'customer_model.php';

?>
<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable">
    <head>
        <meta charset="utf-8" />
        <title>Dashboard | Uniqbizz</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- App favicon -->
        <link rel="shortcut icon" href="assets/images/fav.png">

        <!-- jsvectormap css -->
        <link href="assets/libs/jsvectormap/css/jsvectormap.min.css" rel="stylesheet" type="text/css" />

        <!--Swiper slider css-->
        <link href="assets/libs/swiper/swiper-bundle.min.css" rel="stylesheet" type="text/css" />

        <!-- Layout config Js -->
        <script src="assets/js/layout.js"></script>
        <!-- Bootstrap Css -->
        <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <!-- Icons Css -->
        <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
        <!-- App Css-->
        <link href="assets/css/app.min.css" rel="stylesheet" type="text/css" />
        <!-- custom Css-->
        <link href="assets/css/custom.min.css" rel="stylesheet" type="text/css" />
        <!-- custom Css developer-->
        <link rel="stylesheet" href="assets/css/custom.css" />
        <!-- Customer Dashboard CSS -->
        <link rel="stylesheet" href="assets/css/customer_dashboard.css" />

        <!-- FontAwesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SZ4qk6V... (auto-generated)" crossorigin="anonymous" referrerpolicy="no-referrer">
        <link rel="stylesheet" href="assets/css/customer_discount_wallet.css" />
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
                        <!-- customer discount wallet -->

                        <div class="page-title">

                            <div class="title-left">

                                <div class="title-icon">
                                    <i class="fa-solid fa-percent"></i>
                                </div>

                                <div>
                                    <h1>Discount Wallet Transactions</h1>
                                    <p>Track all your wallet activities and savings.</p>
                                </div>

                            </div>

                            <button class="info-btn">
                                <i class="fa-solid fa-circle-info"></i>
                                How Discount Wallet Works?
                            </button>

                        </div>

                        <!-- STATS -->
                        <div class="stats-grid">

                            <div class="stat-card">

                                <div class="stat-top">
                                    <div class="stat-icon purple">
                                        <i class="fa-solid fa-wallet"></i>
                                    </div>
                                </div>

                                <p>Total Savings</p>
                                <h2 class="purple-text mb-n3">₹1,875</h2>

                                <!--<div class="sub-data">-->
                                <!--    <div>-->
                                <!--        This Year-->
                                <!--        <strong>₹2,000</strong>-->
                                <!--    </div>-->

                                <!--    <div>-->
                                <!--        Last Year-->
                                <!--        <strong>₹400</strong>-->
                                <!--    </div>-->
                                <!--</div>-->

                            </div>

                            <div class="stat-card">

                                <div class="stat-top">
                                    <div class="stat-icon green">
                                        <i class="fa-solid fa-sack-dollar"></i>
                                    </div>
                                </div>

                                <p>Available Balance</p>
                                <h2 class="green-text mb-n3">₹1,175</h2>

                                <!--<div class="sub-data">-->
                                <!--    <div>-->
                                <!--        Used This Year-->
                                <!--        <strong>₹800</strong>-->
                                <!--    </div>-->

                                <!--    <div>-->
                                <!--        On Hold-->
                                <!--        <strong>₹400</strong>-->
                                <!--    </div>-->
                                <!--</div>-->

                            </div>

                            <div class="stat-card">

                                <div class="stat-top">
                                    <div class="stat-icon blue">
                                        <i class="fa-solid fa-tags"></i>
                                    </div>
                                </div>

                                <p>Total Discounts Used</p>
                                <h2 style="color:#2563eb;" class="mb-n3">₹700</h2>

                                <!--<div class="sub-data">-->
                                <!--    <div>-->
                                <!--        Bookings-->
                                <!--        <strong>6</strong>-->
                                <!--    </div>-->

                                <!--    <div>-->
                                <!--        Passengers-->
                                <!--        <strong>14</strong>-->
                                <!--    </div>-->
                                <!--</div>-->

                            </div>

                            <!--<div class="stat-card">-->

                            <!--    <div class="stat-top">-->
                            <!--        <div class="stat-icon orange">-->
                            <!--            <i class="fa-solid fa-calendar-xmark"></i>-->
                            <!--        </div>-->
                            <!--    </div>-->

                            <!--    <p>Total Expired</p>-->
                            <!--    <h2 class="orange-text mb-n3">₹400</h2>-->

                            <!--    <div class="sub-data">-->
                            <!--        <div>-->
                            <!--            This Year-->
                            <!--            <strong>₹400</strong>-->
                            <!--        </div>-->

                            <!--        <div>-->
                            <!--            Last Year-->
                            <!--            <strong>₹0</strong>-->
                            <!--        </div>-->
                            <!--    </div>-->

                            <!--</div>-->

                        </div>

                        <!-- NOTICE -->
                        <div class="notice-bar">

                            <div class="notice-item">
                                <i class="fa-solid fa-tag"></i>
                                Discounts can be used on eligible bookings only
                            </div>

                            <div class="notice-item">
                                <i class="fa-solid fa-ban"></i>
                                Cannot be withdrawn or transferred
                            </div>

                            <div class="notice-item">
                                <i class="fa-solid fa-calendar-days"></i>
                                Valid for 12 months from date of credit
                            </div>

                        </div>

                        <!-- FILTERS -->
                        <div class="filter-bar">

                            <div class="filters">

                                <div class="filter-group">
                                    <label>Transaction Type</label>

                                    <select id="typeFilter">
                                        <option value="all">All</option>
                                        <option value="earned">Earned</option>
                                        <option value="used">Used</option>
                                        <!--<option value="expired">Expired</option>-->
                                    </select>
                                </div>

                                <div class="filter-group">
                                    <label>Status</label>

                                    <select id="statusFilter">
                                        <option value="all">All</option>
                                        <option value="credited">Credited</option>
                                        <option value="used">Used</option>
                                        <!--<option value="expired">Expired</option>-->
                                    </select>
                                </div>

                                <div class="filter-group">
                                    <label>Date Range</label>

                                    <input type="date">
                                </div>

                            </div>

                            <button class="download-btn">
                                <i class="fa-solid fa-download"></i>
                                Download Statement
                            </button>

                        </div>

                        <!-- TABLE -->
                        <div class="table-card">

                            <div class="table-header">
                                <h2>All Transactions (10)</h2>
                            </div>

                            <table class="transaction-table">

                                <thead>

                                    <tr>
                                        <th>Date & Time</th>
                                        <th>Description</th>
                                        <th>Trip Details</th>
                                        <th>Type</th>
                                        <th>Amount</th>
                                        <th>Status</th>
                                        <!--<th>Balance</th>-->
                                        <th></th>
                                    </tr>

                                </thead>

                                <tbody id="transactionBody">

                                    <!-- ROW 1 -->

                                    <tr class="transaction-row" data-type="earned" data-status="credited">

                                        <td>18 May 2024<br><small>10:15 AM</small></td>

                                        <td>
                                            <strong>Discount Earned</strong><br>
                                            <small>For repeat booking</small>
                                        </td>

                                        <td>
                                            <strong>Kerala Backwaters</strong><br>
                                            <small>Booking ID: BK2405182578</small>
                                        </td>

                                        <td>
                                            <span class="badge earned">Earned</span>
                                        </td>

                                        <td class="green-text"><strong>+₹375</strong></td>

                                        <td>
                                            <span class="badge earned">Credited</span>
                                        </td>

                                        <!--<td><strong>₹1,200</strong></td>-->

                                        <td>
                                            <i class="fa-solid fa-chevron-down"></i>
                                        </td>

                                    </tr>

                                    <tr class="details-row">

                                        <td colspan="8">

                                            <div class="details-content">

                                                <div class="details-box">

                                                    <h4>
                                                        <i class="fa-solid fa-suitcase"></i>
                                                        Trip Details
                                                    </h4>
                                                    
                                                    <div class="detail-item">
                                                        <span>Customer Name</span>
                                                        <strong>Mohit Naik (CU260053)</strong>
                                                    </div>

                                                    <div class="detail-item">
                                                        <span>Tour Name</span>
                                                        <strong>Kerala Backwaters</strong>
                                                    </div>

                                                    <div class="detail-item">
                                                        <span>Destination</span>
                                                        <strong>Kochi, Alleppey</strong>
                                                    </div>

                                                    <div class="detail-item">
                                                        <span>Travel Date</span>
                                                        <strong>10 May 2024 - 14 May 2024</strong>
                                                    </div>
                                                    
                                                    <div class="detail-item">
                                                        <span>Booking ID</span>
                                                        <strong>BK2405182578</strong>
                                                    </div>
                                                    
                                                      <div class="detail-item">
                                                        <span>Booking Date</span>
                                                        <strong>02 May 2024</strong>
                                                    </div>


                                                </div>

                                                <div class="details-box">

                                                    <h4>
                                                        <i class="fa-solid fa-money-bill-wave"></i>
                                                        Earning Details
                                                    </h4>

                                                    <div class="detail-item">
                                                        <span>Reason</span>
                                                        <strong>Repeat Booking Benefit</strong>
                                                    </div>

                                                    <div class="detail-item">
                                                        <span>Passengers</span>
                                                        <strong>3</strong>
                                                    </div>

                                                    <div class="detail-item">
                                                        <span>Per Pax Discount</span>
                                                        <strong>₹125</strong>
                                                    </div>

                                                    <div class="detail-item">
                                                        <span>Total Earned</span>
                                                        <strong class="green-text">₹375</strong>
                                                    </div>

                                                </div>

                                            </div>

                                        </td>

                                    </tr>

                                    <!-- MORE ROWS -->

                                    <tr class="transaction-row" data-type="used" data-status="used">
                                        <td>15 May 2024<br><small>09:20 AM</small></td>
                                        <td><strong>Discount Used</strong></td>
                                        <td><strong>Goa Beach Escape</strong></td>
                                        <td><span class="badge used">Used</span></td>
                                        <td class="red-text"><strong>-₹700</strong></td>
                                        <td><span class="badge used">Used</span></td>
                                        <!--<td><strong>₹700</strong></td>-->
                                        <td><i class="fa-solid fa-chevron-down"></i></td>
                                    </tr>

                                     <tr class="details-row">

                                        <td colspan="8">

                                            <div class="details-content">

                                                <div class="details-box">

                                                    <h4>
                                                        <i class="fa-solid fa-suitcase"></i>
                                                        Trip Details
                                                    </h4>
                                                    
                                                    <!--<div class="detail-item">-->
                                                    <!--    <span>Customer Name</span>-->
                                                    <!--    <strong>Mohit Naik (CU260053)</strong>-->
                                                    <!--</div>-->

                                                    <div class="detail-item">
                                                        <span>Tour Name</span>
                                                        <strong>Goa Beach Escape</strong>
                                                    </div>

                                                    <div class="detail-item">
                                                        <span>Destination</span>
                                                        <strong>Goa</strong>
                                                    </div>

                                                    <div class="detail-item">
                                                        <span>Travel Date</span>
                                                        <strong>10 May 2025 - 14 May 2025</strong>
                                                    </div>
                                                    
                                                    <div class="detail-item">
                                                        <span>Booking ID</span>
                                                        <strong>BK2405182999</strong>
                                                    </div>
                                                    
                                                      <div class="detail-item">
                                                        <span>Booking Date</span>
                                                        <strong>02 May 2025</strong>
                                                    </div>


                                                </div>

                                                <div class="details-box">

                                                    <h4>
                                                        <i class="fa-solid fa-money-bill-wave"></i>
                                                        Usage Details
                                                    </h4>

                                                    <div class="detail-item">
                                                        <span>Reason</span>
                                                        <strong>Used on booking Goa Beach Escape Package</strong>
                                                    </div>

                                                    <div class="detail-item">
                                                        <span>Passengers</span>
                                                        <strong>3</strong>
                                                    </div>

                                                  
                                                    <div class="detail-item">
                                                        <span>Total Used</span>
                                                        <strong class="green-text">₹700</strong>
                                                    </div>

                                                </div>

                                            </div>

                                        </td>

                                    </tr>

                                    <tr class="transaction-row" data-type="earned" data-status="credited">
                                        <td>02 May 2024<br><small>04:45 PM</small></td>
                                        <td><strong>Discount Earned</strong></td>
                                        <td><strong>Dubai Extravaganza</strong></td>
                                        <td><span class="badge earned">Earned</span></td>
                                        <td class="green-text"><strong>+₹800</strong></td>
                                        <td><span class="badge earned">Credited</span></td>
                                        <!--<td><strong>₹1,400</strong></td>-->
                                        <td><i class="fa-solid fa-chevron-down"></i></td>
                                    </tr>

                                    <tr class="details-row">
                                        <td colspan="8">
                                            <div class="details-content">
                                                <div class="details-box">
                                                    <h4>Tour Information</h4>
                                                    <div class="detail-item">
                                                        <span>Destination</span>
                                                        <strong>Dubai</strong>
                                                    </div>
                                                    <div class="detail-item">
                                                        <span>Booking ID</span>
                                                        <strong>BK2405022091</strong>
                                                    </div>
                                                </div>

                                                <div class="details-box">
                                                    <h4>Reward Info</h4>
                                                    <div class="detail-item">
                                                        <span>Reward Type</span>
                                                        <strong>Premium Member</strong>
                                                    </div>
                                                    <div class="detail-item">
                                                        <span>Total Credit</span>
                                                        <strong class="green-text">₹800</strong>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>

                                    <!-- EXTRA DATA -->

                                    <!--<tr class="transaction-row" data-type="expired" data-status="expired">-->
                                    <!--    <td>18 Mar 2024<br><small>05:15 PM</small></td>-->
                                    <!--    <td><strong>Discount Expired</strong></td>-->
                                    <!--    <td><strong>Unused Wallet Bonus</strong></td>-->
                                    <!--    <td><span class="badge expired">Expired</span></td>-->
                                    <!--    <td class="orange-text"><strong>-₹200</strong></td>-->
                                    <!--    <td><span class="badge expired">Expired</span></td>-->
                                        <!--<td><strong>₹300</strong></td>-->
                                    <!--    <td><i class="fa-solid fa-chevron-down"></i></td>-->
                                    <!--</tr>-->

                                    <tr class="details-row">
                                        <td colspan="8">
                                            <div class="details-content">
                                                <div class="details-box">
                                                    <h4>Expiration Details</h4>
                                                    <div class="detail-item">
                                                        <span>Expiry Date</span>
                                                        <strong>18 Mar 2024</strong>
                                                    </div>
                                                    <div class="detail-item">
                                                        <span>Validity</span>
                                                        <strong>12 Months</strong>
                                                    </div>
                                                </div>

                                                <div class="details-box">
                                                    <h4>Balance Impact</h4>
                                                    <div class="detail-item">
                                                        <span>Expired Amount</span>
                                                        <strong class="orange-text">₹200</strong>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>

                                </tbody>

                            </table>

                        </div>

                        <!-- NOTE -->

                        <div class="bottom-note">
                            <strong>Note:</strong>
                            Discount wallet balance can be used on eligible bookings only.
                            Discounts cannot be withdrawn or transferred.
                        </div>

                        <!-- HOW TO USE -->

                        <div class="how-use">

                            <h2>How You Can Use Your Discount Wallet?</h2>

                            <div class="how-grid">

                                <div class="how-card">
                                    <i class="fa-solid fa-ticket"></i>
                                    <h4>Use on Eligible Bookings</h4>
                                    <p>
                                        Apply your discount on holiday packages,
                                        group tours and events.
                                    </p>
                                </div>

                                <div class="how-card">
                                    <i class="fa-solid fa-user-group"></i>
                                    <h4>One Discount Per Passenger</h4>
                                    <p>
                                        Discount is applicable per passenger
                                        per booking.
                                    </p>
                                </div>

                                <div class="how-card">
                                    <i class="fa-solid fa-bolt"></i>
                                    <h4>Auto Apply at Checkout</h4>
                                    <p>
                                        Eligible discounts are automatically
                                        applied during booking.
                                    </p>
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
        <script src="assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="assets/libs/simplebar/simplebar.min.js"></script>
        <script src="assets/libs/node-waves/waves.min.js"></script>
        <script src="assets/libs/feather-icons/feather.min.js"></script>
        <script src="assets/js/jquery/jquery-3.7.1.min.js"></script>

        <!-- !-- materialdesign remix icon js- -->
        <script src="assets/js/pages/remix-icons-listing.js"></script>

        <!-- Vector map-->
        <script src="assets/libs/jsvectormap/js/jsvectormap.min.js"></script>
        <script src="assets/libs/jsvectormap/maps/world-merc.js"></script>

        <!--Swiper slider js-->
        <script src="assets/libs/swiper/swiper-bundle.min.js"></script>

        <!-- App js -->
        <script src="assets/js/app.js"></script>

        <script src="assets/libs/chart.js/Chart-2.5.0.min.js"></script>


        <!-- Dashboard init  popular candidates section js file-->
        <script src="assets/js/pages/dashboard-job.init.js"></script>

        <script src="assets/js/js-confetti.js"></script>

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
        <script>

            // EXPANDABLE TABLE

            const transactionRows = document.querySelectorAll(".transaction-row");

            transactionRows.forEach(row => {

                row.addEventListener("click", () => {

                    const details = row.nextElementSibling;

                    if(details.style.display === "table-row"){
                        details.style.display = "none";
                    }else{
                        details.style.display = "table-row";
                    }

                });

            });

            // FILTERS

            const typeFilter = document.getElementById("typeFilter");
            const statusFilter = document.getElementById("statusFilter");

            function filterTransactions(){

                const rows = document.querySelectorAll(".transaction-row");

                rows.forEach(row => {

                    const type = row.dataset.type;
                    const status = row.dataset.status;

                    const typeValue = typeFilter.value;
                    const statusValue = statusFilter.value;

                    const typeMatch =
                        typeValue === "all" || type === typeValue;

                    const statusMatch =
                        statusValue === "all" || status === statusValue;

                    if(typeMatch && statusMatch){

                        row.style.display = "";

                        if(row.nextElementSibling.classList.contains("details-row")){
                            row.nextElementSibling.style.display = "none";
                        }

                    }else{

                        row.style.display = "none";

                        if(row.nextElementSibling.classList.contains("details-row")){
                            row.nextElementSibling.style.display = "none";
                        }

                    }

                });

            }

            typeFilter.addEventListener("change", filterTransactions);
            statusFilter.addEventListener("change", filterTransactions);

            // DOWNLOAD BUTTON

            document.querySelector(".download-btn")
            .addEventListener("click", () => {

                alert("Statement Download Started!");

            });

            // MEMBERSHIP BUTTON

            document.querySelector(".membership button")
            .addEventListener("click", () => {

                alert("Redirecting to Membership Details");

            });

            // INFO BUTTON

            document.querySelector(".info-btn")
            .addEventListener("click", () => {

                alert(
                    "Discount Wallet allows you to earn and use discounts on eligible travel bookings."
                );

            });

        </script>

    </body>
</html>