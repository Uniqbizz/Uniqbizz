<?php
    include_once (__DIR__ .'/../../dashboard_user_details.php');
    include (__DIR__ .'/../customer_model.php');
    include (__DIR__.'/../urls.php');
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
        <link rel="stylesheet" href="<?= $base_url ?>assets/css/neo_select/customer_benefit.css" />
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
                        <div class="zmx9-membership-page-wrapper">

                            <!-- HERO SECTION -->
                            <div class="zmx9-membership-hero-section">

                                <!-- LEFT -->
                                <div class="zmx9-hero-left-content">

                                    <h1>NEO SELECT <span class="textColor">MEMBERSHIP</span></h1>

                                    <div class="zmx9-active-member-badge">
                                        <i class="fa-solid fa-circle-check"></i>
                                        ACTIVE MEMBER
                                    </div>

                                    <p>
                                        Thank you for being a valued member! <br>
                                        Enjoy exclusive travel benefits and rewards.
                                    </p>

                                    <!-- BENEFITS -->
                                    <div class="zmx9-top-benefits-row">

                                        <div class="zmx9-top-benefit-item">
                                            <i class="fa-solid fa-circle-check"></i>
                                            <span>Best Prices</span>
                                        </div>

                                        <div class="zmx9-top-benefit-item">
                                            <i class="fa-solid fa-circle-check"></i>
                                            <span>Exclusive Offers</span>
                                        </div>

                                        <div class="zmx9-top-benefit-item">
                                            <i class="fa-solid fa-circle-check"></i>
                                            <span>Priority Support</span>
                                        </div>

                                        <div class="zmx9-top-benefit-item">
                                            <i class="fa-solid fa-circle-check"></i>
                                            <span>Extra Savings</span>
                                        </div>

                                    </div>

                                </div>

                                <!-- RIGHT -->
                                <div class="zmx9-hero-right-image">

                                    <img src="https://cdn-icons-png.flaticon.com/512/2920/2920277.png" alt="membership card">

                                </div>

                            </div>

                            <!-- =========================================
                                TOP INFO CARDS
                            ========================================= -->

                            <div class="zmx9-membership-info-grid">

                                <!-- CARD 1 -->
                                <div class="zmx9-membership-info-card">

                                    <div class="zmx9-card-heading">
                                        Membership Status
                                    </div>

                                    <div class="zmx9-status-row">

                                        <div>

                                            <h2>Active</h2>

                                            <div class="zmx9-date-grid">

                                                <div>
                                                    <span>Member Since</span>
                                                    <strong><?= $cust_regiter_date ?></strong>
                                                </div>

                                                <div>
                                                    <span>Valid Till</span>
                                                    <strong> 11 April 2034</strong>
                                                </div>

                                            </div>

                                        </div>

                                        <div class="zmx9-shield-icon">
                                            <i class="fa-solid fa-star"></i>
                                        </div>

                                    </div>

                                </div>

                                <!-- CARD 2 -->
                                <div class="zmx9-membership-info-card zmx9-membership-id-card">

                                    <!-- LEFT CONTENT -->
                                    <div class="zmx9-membership-id-left">

                                        <div class="zmx9-card-heading">
                                            Membership ID
                                        </div>

                                        <h3 class="zmx9-membership-id">
                                            <?= $userId ?>
                                        </h3>

                                    </div>

                                    <!-- RIGHT IMAGE -->
                                    <div class="zmx9-membership-id-image">
                                        <img src="https://cdn-icons-png.flaticon.com/512/942/942748.png" alt="">
                                    </div>

                                </div>

                                <!-- CARD 3 -->
                                <div class="vxq-active-membership-shell">
 
                                    <!-- Left Content -->
                                    <div class="vxq-active-membership-left">
                                    
                                            <h2 class="vxq-active-membership-title">
                                                Your Membership is Active!
                                            </h2>
                                            
                                                    <p class="vxq-active-membership-validity">
                                                        Valid till 11 April 2034
                                            </p>
                                    
                                            <p class="vxq-active-membership-description">
                                                Renew now to continue enjoying uninterrupted
                                                benefits and exclusive offers.
                                            </p>
                                    
                                    </div>
                                    
                                    <!-- Center Icon -->
                                    <div class="vxq-active-membership-middle">
                                    
                                        <div class="vxq-calendar-card-box">
                                    
                                           <div class="vxq-calendar-top-pins">
                                                <span></span>
                                                <span></span>
                                            </div>
                                    
                                            <div class="vxq-calendar-inner-content">
                                                <i class="fa-solid fa-check"></i>
                                                <i class="fa-solid fa-circle-check"></i>
                                            </div>
                                    
                                        </div>
                                    
                                    </div>
                                
                                </div>
                                <!-- <div class="zmx9-membership-info-card zmx9-benefit-card-style">

                                    <div>

                                        <div class="zmx9-card-heading">
                                            Membership Benefits
                                        </div>

                                        <h2 class="zmx9-benefit-amount">
                                            Upto ₹25,000*
                                        </h2>

                                        <span class="zmx9-small-text">
                                            Total Benefits Unlocked
                                        </span>

                                        <a href="customer_wallet.php" class="zmx9-outline-btn">

                                            <i class="fa-light fa-gift"></i>

                                            View Benefits

                                        </a>

                                    </div>

                                    <img src="https://cdn-icons-png.flaticon.com/512/4213/4213958.png" alt="gift">

                                </div> -->

                            </div>

                            <!-- =========================================
                                MEMBERSHIP BENEFITS
                            ========================================= -->

                            <div class="zmx9-main-white-card">

                                <div class="zmx9-section-heading">
                                    <h2>Your Membership Benefits</h2>
                                    <p>
                                        Enjoy these exclusive benefits as a Neo Select Member
                                    </p>
                                </div>

                                <div class="zmx9-benefit-feature-grid">

                                    <div class="zmx9-feature-box">
                                        <div class="zmx9-feature-icon">
                                            <i class="fa-solid fa-tags"></i>
                                        </div>

                                        <h4>Exclusive Discounts</h4>

                                        <p>
                                            Get exclusive member discounts on all bookings.
                                        </p>
                                    </div>

                                    <div class="zmx9-feature-box">
                                        <div class="zmx9-feature-icon">
                                            <i class="fa-solid fa-headset"></i>
                                        </div>

                                        <h4>Priority Support</h4>

                                        <p>
                                            Priority support on all queries.
                                        </p>
                                    </div>

                                    <div class="zmx9-feature-box">
                                        <div class="zmx9-feature-icon">
                                            <i class="fa-solid fa-percent"></i>
                                        </div>

                                        <h4>Special Offers</h4>

                                        <p>
                                            Access member-only deals & flash sales.
                                        </p>
                                    </div>

                                    <div class="zmx9-feature-box">
                                        <div class="zmx9-feature-icon">
                                            <i class="fa-solid fa-wallet"></i>
                                        </div>

                                        <h4>Extra Savings</h4>

                                        <p>
                                            Earn more with loyalty coupons & cashback.
                                        </p>
                                    </div>

                                    <div class="zmx9-feature-box">
                                        <div class="zmx9-feature-icon">
                                            <i class="fa-solid fa-lock"></i>
                                        </div>

                                        <h4>Early Access</h4>

                                        <p>
                                            Be the first to know about new launches.
                                        </p>
                                    </div>

                                    <div class="zmx9-feature-box">
                                        <div class="zmx9-feature-icon">
                                            <i class="fa-solid fa-users"></i>
                                        </div>

                                        <h4>Invite & Earn</h4>

                                        <p>
                                            Refer friends & earn exciting rewards.
                                        </p>
                                    </div>

                                </div>

                                <!-- <div class="zmx9-view-benefit-btn-wrap">

                                    <button class="zmx9-outline-big-btn">
                                        View All Benefits
                                        <i class="fa-light fa-arrow-right"></i>
                                    </button>

                                </div> -->

                            </div>

                            <!-- Membership Highlights Section -->
                            <div class="svz-membership-highlight-wrapper mt-4">
                                <h4>Your Membership Highlights</h4>
                                <div class="svz-membership-highlight-card">
                                    
                                    <!-- Box 1 -->
                                    <div class="svz-highlight-item svz-highlight-green">
                                        <div class="svz-highlight-icon-box">
                                            <i class="fas fa-wallet"></i>
                                        </div>

                                        <div class="svz-highlight-content">
                                            <h3>₹21,500</h3>
                                            <p>Total Savings</p>
                                            <span>All time savings till date</span>
                                        </div>
                                    </div>

                                    <!-- Box 2 -->
                                    <div class="svz-highlight-item svz-highlight-blue">
                                        <div class="svz-highlight-icon-box">
                                            <i class="fas fa-suitcase"></i>
                                        </div>

                                        <div class="svz-highlight-content">
                                            <h3>4</h3>
                                            <p>Trips Booked</p>
                                            <span>All trips booked till date</span>
                                        </div>
                                    </div>

                                    <!-- Box 3 -->
                                    <div class="svz-highlight-item svz-highlight-pink">
                                        <div class="svz-highlight-icon-box">
                                            <i class="fas fa-receipt"></i>
                                        </div>

                                        <div class="svz-highlight-content">
                                            <h3>₹6,250</h3>
                                            <p>Cashback Earned</p>
                                            <span>Total cashback till date</span>
                                        </div>
                                    </div>

                                    <!-- Box 4 -->
                                    <div class="svz-highlight-item svz-highlight-purple">
                                        <div class="svz-highlight-icon-box">
                                            <i class="fas fa-ticket-alt"></i>
                                        </div>

                                        <div class="svz-highlight-content">
                                            <h3>12</h3>
                                            <p>Coupons Unlocked</p>
                                            <span>Total coupons unlocked</span>
                                        </div>
                                    </div>

                                </div>
                            </div>

                        </div>

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

        <script src="<?= $base_url ?>assets/js/js-confetti.js"></script>
        
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

        <!-- <script>
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
        </script> -->

        <!-- dialer logic -->

        <!-- table tabs -->
         
    </body>
</html>