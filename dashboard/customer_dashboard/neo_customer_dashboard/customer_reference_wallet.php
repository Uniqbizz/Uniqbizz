<?php
    include_once (__DIR__ .'/../../dashboard_user_details.php');
    include (__DIR__ .'../customer_model.php');
    $base_url = "/ca.uniqbizz.com/dashboard/";
    $base_url_cust = "/ca.uniqbizz.com/dashboard/customer_dashboard/";
    $home_url = "/ca.uniqbizz.com/";

?>
<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable">
    <head>
        <meta charset="utf-8" />
        <title>Dashboard | Uniqbizz</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- App favicon -->
        <link rel="shortcut icon" href="<?= $base_url ?>assets/images/fav.png">

        <!-- jsvectormap css -->
        <link href="<?= $base_url ?>assets/libs/jsvectormap/css/jsvectormap.min.css" rel="stylesheet" type="text/css" />

        <!--Swiper slider css-->
        <link href="<?= $base_url ?>assets/libs/swiper/swiper-bundle.min.css" rel="stylesheet" type="text/css" />

        <!-- Layout config Js -->
        <script src="<?= $base_url ?>assets/js/layout.js"></script>
        <!-- Bootstrap Css -->
        <link href="<?= $base_url ?>assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <!-- Icons Css -->
        <link href="<?= $base_url ?>assets/css/icons.min.css" rel="stylesheet" type="text/css" />
        <!-- App Css-->
        <link href="<?= $base_url ?>assets/css/app.min.css" rel="stylesheet" type="text/css" />
        <!-- custom Css-->
        <link href="<?= $base_url ?>assets/css/custom.min.css" rel="stylesheet" type="text/css" />
        <!-- custom Css developer-->
        <link rel="stylesheet" href="<?= $base_url ?>assets/css/custom.css" />
        <!-- Customer Dashboard CSS -->
        <link rel="stylesheet" href="<?= $base_url ?>assets/css/customer_dashboard.css" />

        <!-- FontAwesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel="stylesheet" href="<?= $base_url ?>assets/css/neo_select/customer_reference_wallet.css" />
    </head>

    <body class="twocolumn-panel">
        <!-- Begin page -->
        <div id="layout-wrapper">
            <?php include_once(__DIR__ . '/../customer_header.php'); ?>

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

            <?php include_once (__DIR__ . '/../customer_sidebar.php') ?>
            <!-- ============================================================== -->
            <!-- Start of Customer Dashboard here -->
            <!-- ============================================================== -->
            <div class="main-content">
                <div class="page-content">
                    <div class="container-fluid ps-0">
                        <!-- customer reference wallet -->
                        <section class="wallet-wrapper">

                            <!-- PAGE TITLE -->
                            <div class="wallet-topbar">
                                <div>
                                <h2><i class="fa-solid fa-users"></i> Referral Customer Wallet</h2>
                                <p>View all transactions and earnings from your referred customers.</p>
                                </div>

                                <button class="benefit-btn">
                                <i class="fa-regular fa-circle-question"></i>
                                How Referral Benefits Work?
                                </button>
                            </div>


                            <!-- STATS CARDS -->
                            <div class="stats-grid">

                                <div class="stats-card orange">
                                <div class="stats-icon">
                                    <i class="fa-solid fa-hand-holding-dollar"></i>
                                </div>

                                <div>
                                    <h4>Total Earnings</h4>
                                    <h2>₹4,100</h2>
                                </div>

                                <!--<div class="card-footer-data">-->
                                <!--    <div>-->
                                <!--    <span>This Year</span>-->
                                <!--    <strong>₹3,400</strong>-->
                                <!--    </div>-->

                                <!--    <div>-->
                                <!--    <span>Last Year</span>-->
                                <!--    <strong>₹700</strong>-->
                                <!--    </div>-->
                                <!--</div>-->
                                </div>


                                <div class="stats-card green">
                                <div class="stats-icon">
                                    <i class="fa-solid fa-arrow-trend-up"></i>
                                </div>

                                <div>
                                    <h4>Available Balance</h4>
                                    <h2>₹2,300</h2>
                                </div>

                                <!--<div class="card-footer-data">-->
                                <!--    <div>-->
                                <!--    <span>Withdrawable</span>-->
                                <!--    <strong>₹1,800</strong>-->
                                <!--    </div>-->

                                <!--    <div>-->
                                <!--    <span>On Hold</span>-->
                                <!--    <strong>₹500</strong>-->
                                <!--    </div>-->
                                <!--</div>-->
                                </div>


                                <div class="stats-card blue">
                                <div class="stats-icon">
                                    <i class="fa-solid fa-gift"></i>
                                </div>

                                <div>
                                    <h4>Total Referrals</h4>
                                    <h2>8</h2>
                                </div>

                                <!--<div class="card-footer-data">-->
                                <!--    <div>-->
                                <!--    <span>Active Referrals</span>-->
                                <!--    <strong>6</strong>-->
                                <!--    </div>-->

                                <!--    <div>-->
                                <!--    <span>Completed Trips</span>-->
                                <!--    <strong>10</strong>-->
                                <!--    </div>-->
                                <!--</div>-->
                                </div>


                                <div class="stats-card purple">
                                <div class="stats-icon">
                                    <i class="fa-solid fa-wallet"></i>
                                </div>

                                <div>
                                    <h4>Total Withdrawn</h4>
                                    <h2>₹1,800</h2>
                                </div>

                                <!--<div class="card-footer-data">-->
                                <!--    <div>-->
                                <!--    <span>This Year</span>-->
                                <!--    <strong>₹1,300</strong>-->
                                <!--    </div>-->

                                <!--    <div>-->
                                <!--    <span>Last Year</span>-->
                                <!--    <strong>₹500</strong>-->
                                <!--    </div>-->
                                <!--</div>-->
                                </div>

                            </div>


                            <!-- INFO STRIP -->
                            <div class="info-strip">
                                <div><i class="fa-solid fa-coins"></i> Earn ₹1,000 on successful membership activation by your referral</div>
                                <div><i class="fa-solid fa-plane-departure"></i> Earn additional benefits on trip completion</div>
                                <div><i class="fa-solid fa-circle-check"></i> Benefits applicable on all travel services</div>
                            </div>


                            <!-- FILTER SECTION -->
                            <!-- FILTER BOX -->

                            <div class="filter-box">

                                <div class="row g-4 align-items-end">

                                    <!-- TRANSACTION TYPE -->

                                    <div class="col-lg-3 col-md-6">

                                        <div class="input-group-custom">

                                            <label>
                                                Transaction Type
                                            </label>

                                            <select
                                                class="form-select"
                                                id="transactionFilter"
                                            >

                                                <option value="all">All</option>

                                                <option value="membership activation bonus">
                                                    Holiday Account Activation
                                                </option>

                                                <option value="trip completed bonus">
                                                    Trip Completed 
                                                </option>

                                                <option value="withdrawal request">
                                                    Withdrawal Request
                                                </option>

                                                <option value="pending clearance">
                                                    Pending Clearance
                                                </option>

                                            </select>

                                        </div>

                                    </div>

                                    <!-- STATUS -->

                                    <div class="col-lg-3 col-md-6">

                                        <div class="input-group-custom">

                                            <label>
                                                Status
                                            </label>

                                            <select
                                                class="form-select"
                                                id="statusFilter"
                                            >

                                                <option value="all">All</option>

                                                <option value="credited">
                                                    Credited
                                                </option>

                                                <option value="pending">
                                                    Pending
                                                </option>

                                                <option value="processed">
                                                    Processed
                                                </option>

                                                <option value="cancelled">
                                                    Cancelled
                                                </option>

                                                <option value="rejected">
                                                    Rejected
                                                </option>

                                            </select>

                                        </div>

                                    </div>

                                    <!-- DATE -->

                                    <div class="col-lg-3 col-md-6">

                                        <div class="input-group-custom">

                                            <label>
                                                Date
                                            </label>

                                            <input
                                                type="date"
                                                class="form-control"
                                                id="dateFilter"
                                            >

                                        </div>

                                    </div>

                                    <!-- DOWNLOAD -->

                                    <div class="col-lg-3 col-md-6">

                                        <div class="download-area">

                                            <button
                                                class="download-btn w-100"
                                                id="downloadBtn"
                                            >

                                                <i class="fa-solid fa-download me-2"></i>

                                                Download Statement

                                            </button>

                                        </div>

                                    </div>

                                </div>

                            </div>


                            <!-- TRANSACTION TABLE -->
                            <!-- ========================= -->
                            <!-- TABLE CONTAINER -->
                            <!-- ========================= -->

                            <div class="table-container">

                                <!-- TITLE -->

                                <div class="table-title d-flex justify-content-between align-items-center mb-4">

                                    <h3 class="mb-0">
                                        All Transactions (8)
                                    </h3>

                                </div>

                                <!-- TABLE -->

                                <div class="table-responsive">

                                    <table class="wallet-table table align-middle">

                                        <thead>

                                            <tr>

                                                <th>Date & Time</th>
                                                <th>Description</th>
                                                <th>Referred Customer</th>
                                                <th>Trip Details</th>
                                                <th>Pax</th>
                                                <th>Per Pax Benefit</th>
                                                <th>Amount</th>
                                                <th>Status</th>
                                                <!--<th>Balance</th>-->
                                                <th>Action</th>

                                            </tr>

                                        </thead>

                                        <tbody id="transactionTableBody">

                                            <!-- ========================= -->
                                            <!-- ROW 1 -->
                                            <!-- ========================= -->

                                            <tr
                                                class="clickable-row"
                                                data-target="details-1"
                                                data-transaction="trip completed bonus"
                                                data-status="credited"
                                                data-date="2024-05-18"
                                            >

                                                <td>
                                                    <strong>18 May 2024</strong><br>
                                                    10:15 AM
                                                </td>

                                                <td>
                                                    <strong>Trip Completed Bonus</strong><br>
                                                    Kerala Backwaters
                                                </td>

                                                <td>
                                                    Rahul Sharma<br>
                                                    <small>(CU2500089)</small>
                                                </td>

                                                <td>
                                                    Kerala Backwaters<br>
                                                    <small>BK24051278</small>
                                                </td>

                                                <td>3</td>

                                                <td>₹500</td>

                                                <td class="text-success fw-bold">
                                                    +₹1,500
                                                </td>

                                                <td>
                                                    <span class="badge bg-success">
                                                        Credited
                                                    </span>
                                                </td>

                                                <!--<td class="fw-bold">-->
                                                <!--    ₹2,300-->
                                                <!--</td>-->

                                                <td>

                                                    <button class="toggle-btn btn btn-sm btn-light">

                                                        <i class="fa-solid fa-chevron-down"></i>

                                                    </button>

                                                </td>

                                            </tr>

                                            <!-- DETAILS -->

                                            <tr
                                                class="details-row"
                                                id="details-1"
                                                style="display:none;"
                                            >

                                                <td colspan="10">

                                                    <div class="details-wrapper p-4 bg-light rounded">

                                                        <div class="row g-4">

                                                            <div class="col-lg-6">

                                                                <div class="detail-card">

                                                                    <h5 class="mb-3">

                                                                        <i class="fa-solid fa-suitcase me-2"></i>

                                                                        Trip Details

                                                                    </h5>
                                                                    <div class="mb-2">
                                                                        <strong>Tour Name:</strong>
                                                                        Kerala Backwaters
                                                                    </div>

                                                                    <div class="mb-2">
                                                                        <strong>Destination:</strong>
                                                                        Kochi, Alleppey, Kumarakom
                                                                    </div>

                                                                    <div class="mb-2">
                                                                        <strong>Travel Date:</strong>
                                                                        10 May - 14 May 2024
                                                                    </div>

                                                                    <div class="mb-2">
                                                                        <strong>Booking ID:</strong>
                                                                        BK24051278
                                                                    </div>
                                                                    
                                                                    <div class="mb-2">
                                                                        <strong>Booking Date:</strong>
                                                                        02 May 2024
                                                                    </div>

                                                                </div>

                                                            </div>

                                                            <div class="col-lg-6">

                                                                <div class="detail-card">

                                                                    <h5 class="mb-3">

                                                                        <i class="fa-solid fa-users me-2"></i>

                                                                        Passenger Details

                                                                    </h5>

                                                                    <table class="table table-bordered">

                                                                        <thead>

                                                                            <tr>

                                                                                <th>Name</th>
                                                                                <th>Age</th>
                                                                                <th>Amount</th>

                                                                            </tr>

                                                                        </thead>

                                                                        <tbody>

                                                                            <tr>
                                                                                <td>Rahul Sharma</td>
                                                                                <td>34</td>
                                                                                <td>₹500</td>
                                                                            </tr>

                                                                            <tr>
                                                                                <td>Priya Sharma</td>
                                                                                <td>31</td>
                                                                                <td>₹500</td>
                                                                            </tr>

                                                                            <tr>
                                                                                <td>Aarav Sharma</td>
                                                                                <td>8</td>
                                                                                <td>₹500</td>
                                                                            </tr>
                                                                            
                                                                             <tr>
                                                                                <td colspan="2">Total Amount Earned</td>
                                                                                <td>₹1,500</td>
                                                                            </tr>

                                                                        </tbody>

                                                                    </table>

                                                                </div>

                                                            </div>

                                                        </div>

                                                    </div>

                                                </td>

                                            </tr>

                                            <!-- ========================= -->
                                            <!-- ROW 2 -->
                                            <!-- ========================= -->

                                            <tr
                                                data-transaction="membership activation bonus"
                                                data-status="credited"
                                                data-date="2024-05-05"
                                            >

                                                <td>
                                                    <strong>05 May 2024</strong><br>
                                                    09:30 AM
                                                </td>

                                                <td>
                                                    <strong>Membership Activation Bonus</strong><br>
                                                    Referred Customer Joined
                                                </td>

                                                <td>
                                                    Neha Kapoor<br>
                                                    <small>(CU2500089)</small>
                                                </td>

                                                <td>-</td>

                                                <td>-</td>

                                                <td>₹1,000</td>

                                                <td class="text-success fw-bold">
                                                    +₹1,000
                                                </td>

                                                <td>
                                                    <span class="badge bg-success">
                                                        Credited
                                                    </span>
                                                </td>

                                                <!--<td>₹800</td>-->

                                                <td>

                                                    <button class="toggle-btn btn btn-sm btn-light">

                                                        <i class="fa-solid fa-minus"></i>

                                                    </button>

                                                </td>

                                            </tr>

                                            <!-- ROW 3 -->

                                            <tr
                                                data-transaction="refund"
                                                data-status="processed"
                                                data-date="2024-05-02"
                                            >

                                                <td>
                                                    <strong>02 May 2024</strong><br>
                                                    04:45 PM
                                                </td>

                                                <td>
                                                    <strong>Refund</strong><br>
                                                    Trip Cancellation Refund
                                                </td>

                                                <td>
                                                    Amit Verma
                                                </td>

                                                <td>
                                                    Goa Beach Escape
                                                </td>

                                                <td>2</td>

                                                <td>₹500</td>

                                                <td class="text-danger fw-bold">
                                                    -₹1,000
                                                </td>

                                                <td>
                                                    <span class="badge bg-primary">
                                                        Processed
                                                    </span>
                                                </td>

                                                <!--<td>₹1,200</td>-->

                                                <td>

                                                    <button class="toggle-btn btn btn-sm btn-light">

                                                        <i class="fa-solid fa-minus"></i>

                                                    </button>

                                                </td>

                                            </tr>

                                            <!-- ROW 4 -->

                                            

                                            <!-- ROW 5 -->

                                            <tr
                                                data-transaction="withdrawal request"
                                                data-status="processed"
                                                data-date="2024-04-28"
                                            >

                                                <td>
                                                    <strong>28 Apr 2024</strong><br>
                                                    06:10 PM
                                                </td>

                                                <td>
                                                    <strong>Withdrawal Request</strong><br>
                                                    To Bank Account
                                                </td>

                                                <td>-</td>

                                                <td>-</td>

                                                <td>-</td>

                                                <td>-</td>

                                                <td class="text-danger fw-bold">
                                                    -₹1,800
                                                </td>

                                                <td>
                                                    <span class="badge bg-info">
                                                        Processed
                                                    </span>
                                                </td>

                                                <!--<td>₹2,200</td>-->

                                                <td>

                                                    <button class="toggle-btn btn btn-sm btn-light">

                                                        <i class="fa-solid fa-building-columns"></i>

                                                    </button>

                                                </td>

                                            </tr>

                                            <!-- ROW 6 -->

                                            <tr
                                                data-transaction="trip completed bonus"
                                                data-status="credited"
                                                data-date="2024-04-22"
                                            >

                                                <td>
                                                    <strong>22 Apr 2024</strong><br>
                                                    02:30 PM
                                                </td>

                                                <td>
                                                    <strong>Trip Completed Bonus</strong><br>
                                                    Dubai Extravaganza
                                                </td>

                                                <td>
                                                    Sneha Iyer
                                                </td>

                                                <td>
                                                    Dubai Extravaganza
                                                </td>

                                                <td>4</td>

                                                <td>₹500</td>

                                                <td class="text-success fw-bold">
                                                    +₹2,000
                                                </td>

                                                <td>
                                                    <span class="badge bg-success">
                                                        Credited
                                                    </span>
                                                </td>

                                                <!--<td>₹4,000</td>-->

                                                <td>

                                                    <button class="toggle-btn btn btn-sm btn-light">

                                                        <i class="fa-solid fa-minus"></i>

                                                    </button>

                                                </td>

                                            </tr>

                                            <!-- ROW 7 -->

                                            

                                            <!-- ROW 8 -->

                                          

                                        </tbody>

                                    </table>

                                </div>

                            </div>


                            <!-- NOTE -->
                            <div class="note-box">
                                <i class="fa-solid fa-circle-info"></i>
                                Referral benefits are credited after successful membership activation or trip completion by your referred customer. Withdrawals are subject to verification and company policy.
                            </div>


                            <!-- HOW YOU EARN -->
                            <div class="earn-grid">

                                <div class="earn-card">
                                <div class="earn-icon orange-bg">
                                    <i class="fa-solid fa-user-plus"></i>
                                </div>

                                <div>
                                    <h4>₹1,000 on Membership Activation</h4>
                                    <p>When your referred customer joins Neo Select Membership successfully.</p>
                                </div>
                                </div>


                                <div class="earn-card">
                                <div class="earn-icon blue-bg">
                                    <i class="fa-solid fa-plane"></i>
                                </div>

                                <div>
                                    <h4>Earn on Trip Completion</h4>
                                    <p>Earn commission for each passenger when your referred customer completes a trip.</p>
                                </div>
                            </div>


                            <div class="earn-card">
                            <div class="earn-icon green-bg">
                                <i class="fa-solid fa-repeat"></i>
                            </div>

                            <div>
                                <h4>More Benefits on Repeated Bookings</h4>
                                <p>Earn additional benefits when your referred customer travels repeatedly.</p>
                            </div>
                            </div>

                        </div>

                        </section>

                        
                    </div>
                </div>
                <?php include_once (__DIR__ . '/../customer_footer.php') ?>
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
        <?php include (__DIR__ .'/../../contact_modal.php') ?>

        <!-- contact card pop up end-->

        <!-- JAVASCRIPT -->
        <script src="<?= $base_url ?>assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="<?= $base_url ?>assets/libs/simplebar/simplebar.min.js"></script>
        <script src="<?= $base_url ?>assets/libs/node-waves/waves.min.js"></script>
        <script src="<?= $base_url ?>assets/libs/feather-icons/feather.min.js"></script>
        <script src="<?= $base_url ?>assets/js/jquery/jquery-3.7.1.min.js"></script>

        <!-- !-- materialdesign remix icon js- -->
        <script src="<?= $base_url ?>assets/js/pages/remix-icons-listing.js"></script>

        <!-- Vector map-->
        <script src="<?= $base_url ?>assets/libs/jsvectormap/js/jsvectormap.min.js"></script>
        <script src="<?= $base_url ?>assets/libs/jsvectormap/maps/world-merc.js"></script>

        <!--Swiper slider js-->
        <script src="<?= $base_url ?>assets/libs/swiper/swiper-bundle.min.js"></script>

        <!-- App js -->
        <script src="<?= $base_url ?>assets/js/app.js"></script>

        <script src="<?= $base_url ?>assets/libs/chart.js/Chart-2.5.0.min.js"></script>


        <!-- Dashboard init  popular candidates section js file-->
        <script src="<?= $base_url ?>assets/js/pages/dashboard-job.init.js"></script>

        <script src="<?= $base_url ?>assets/js/js-confetti.js"></script>

        <!-- <script>
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
        </script> -->
        
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
        <!-- <script>
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
        </script> -->

        <!-- dialer logic -->

        <!-- table tabs -->
        <script>

            document.addEventListener('DOMContentLoaded', function(){

                // =========================================
                // EXPANDABLE TABLE ROWS
                // =========================================

                const clickableRows =
                    document.querySelectorAll('.clickable-row');

                clickableRows.forEach(row => {

                    row.addEventListener('click', function(){

                        const target =
                            this.getAttribute('data-target');

                        if(!target) return;

                        const details =
                            document.getElementById(target);

                        if(!details) return;

                        const icon =
                            this.querySelector('.toggle-btn i');

                        const isVisible =
                            details.style.display === 'table-row';

                        // HIDE ALL DETAIL ROWS

                        document
                            .querySelectorAll('.details-row')
                            .forEach(detailRow => {

                                detailRow.style.display = 'none';

                            });

                        // RESET ALL ICONS

                        document
                            .querySelectorAll('.toggle-btn i')
                            .forEach(i => {

                                i.classList.remove(
                                    'fa-chevron-up'
                                );

                                i.classList.add(
                                    'fa-chevron-down'
                                );

                            });

                        // OPEN CURRENT ROW

                        if(!isVisible){

                            details.style.display =
                                'table-row';

                            if(icon){

                                icon.classList.remove(
                                    'fa-chevron-down'
                                );

                                icon.classList.add(
                                    'fa-chevron-up'
                                );

                            }

                        }

                    });

                });

                // =========================================
                // FILTER ELEMENTS
                // =========================================

                const transactionFilter =
                    document.getElementById(
                        'transactionFilter'
                    );

                const statusFilter =
                    document.getElementById(
                        'statusFilter'
                    );

                const dateFilter =
                    document.getElementById(
                        'dateFilter'
                    );

                const tableBody =
                    document.getElementById(
                        'transactionTableBody'
                    );

                // SAFETY CHECK

                if(
                    !transactionFilter ||
                    !statusFilter ||
                    !dateFilter ||
                    !tableBody
                ){

                    console.log(
                        'Missing filter elements'
                    );

                    return;

                }

                const rows =
                    tableBody.querySelectorAll('tr');

                // =========================================
                // FILTER EVENTS
                // =========================================

                transactionFilter.addEventListener(
                    'change',
                    applyFilters
                );

                statusFilter.addEventListener(
                    'change',
                    applyFilters
                );

                dateFilter.addEventListener(
                    'change',
                    applyFilters
                );

                // =========================================
                // APPLY FILTERS
                // =========================================

                function applyFilters(){

                    const transactionValue =
                        transactionFilter.value.toLowerCase();

                    const statusValue =
                        statusFilter.value.toLowerCase();

                    const dateValue =
                        dateFilter.value;

                    rows.forEach(row => {

                        // SKIP DETAIL ROWS

                        if(
                            row.classList.contains(
                                'details-row'
                            )
                        ){
                            return;
                        }

                        const rowTransaction =
                            row.dataset.transaction
                            ? row.dataset.transaction.toLowerCase()
                            : '';

                        const rowStatus =
                            row.dataset.status
                            ? row.dataset.status.toLowerCase()
                            : '';

                        const rowDate =
                            row.dataset.date || '';

                        let visible = true;

                        // =================================
                        // TRANSACTION FILTER
                        // =================================

                        if(
                            transactionValue !== 'all' &&
                            rowTransaction !== transactionValue
                        ){
                            visible = false;
                        }

                        // =================================
                        // STATUS FILTER
                        // =================================

                        if(
                            statusValue !== 'all' &&
                            rowStatus !== statusValue
                        ){
                            visible = false;
                        }

                        // =================================
                        // DATE FILTER
                        // =================================

                        if(
                            dateValue &&
                            rowDate !== dateValue
                        ){
                            visible = false;
                        }

                        // =================================
                        // SHOW / HIDE MAIN ROW
                        // =================================

                        row.style.display =
                            visible
                            ? 'table-row'
                            : 'none';

                        // =================================
                        // HIDE DETAILS ROW
                        // =================================

                        const target =
                            row.getAttribute('data-target');

                        if(target){

                            const detailRow =
                                document.getElementById(
                                    target
                                );

                            if(detailRow){

                                detailRow.style.display =
                                    'none';

                            }

                        }

                    });

                }

                // =========================================
                // DOWNLOAD BUTTON
                // =========================================

                const downloadBtn =
                    document.getElementById(
                        'downloadBtn'
                    );

                if(downloadBtn){

                    downloadBtn.addEventListener(
                        'click',
                        function(){

                            alert(
                                'Statement download started!'
                            );

                        }
                    );

                }

            });

        </script>

    </body>
</html>