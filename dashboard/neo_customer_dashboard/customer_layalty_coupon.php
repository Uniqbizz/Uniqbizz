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
        <link rel="stylesheet" href="assets/css/customer_loyalty_coupon.css" />
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
                        <!-- =========================
                        LOYALTY PAGE CONTENT
                        (EXCLUDING HEADER & SIDEBAR)
                        ========================= -->

                        <div class="container-fluid loyalty-page">

                            <!-- TITLE -->

                            <div class="d-flex justify-content-between align-items-start flex-wrap gap-3">

                                <div>

                                    <div class="d-flex align-items-center gap-2">

                                        <h2 class="loyalty-title mb-0">
                                            My Loyalty Coupons
                                        </h2>

                                        <i class="fa-solid fa-award loyalty-title-icon"></i>

                                    </div>

                                    <p class="loyalty-subtitle">
                                        Earn loyalty coupons after completing your trips and use them on your next bookings.
                                    </p>

                                </div>

                                <button class="btn loyalty-help-btn">
                                    <i class="fa-regular fa-circle-play me-2"></i>
                                    How Loyalty Coupons Work?
                                </button>

                            </div>

                            <!-- SUMMARY -->

                            <div class="row g-4 mt-1">

                                <!-- TOTAL -->

                                <div class="col-lg-3 col-md-6">
                                    <div class="loyalty-summary-card green-card position-relative overflow-hidden">

                                        <!-- Watermark Icon -->
                                        <div class="watermark-icon">
                                            <i class="fa-solid fa-gift"></i>
                                        </div>

                                        <!-- Main Icon -->
                                        <div class="summary-icon green-bg">
                                            <i class="fa-solid fa-gift"></i>
                                        </div>

                                        <!-- Content -->
                                        <div class="summary-label d-flex justify-content-between align-items-center">
                                            <span>Total Loyalty Coupons</span>
                                            <span class="summary-value">5</span>
                                        </div>

                                    </div>
                                </div>

                                <!-- AVAILABLE -->
                                <div class="col-lg-3 col-md-6">
                                    <div class="loyalty-summary-card mint-card position-relative overflow-hidden">

                                        <!-- Watermark -->
                                        <div class="watermark-icon mint-watermark">
                                            <i class="fa-solid fa-circle-check"></i>
                                        </div>

                                        <div class="summary-icon mint-bg">
                                            <i class="fa-solid fa-circle-check"></i>
                                        </div>
                                        <!-- Content -->
                                        <div class="summary-label d-flex justify-content-between align-items-center mb-n3">
                                            <span>Available Coupons</span>
                                            <span class="summary-value">3</span>
                                        </div>

                                        <div class="summary-sub-value green-text">
                                            Value ₹1,500
                                        </div>

                                    </div>
                                </div>

                                <!-- USED -->
                                <div class="col-lg-3 col-md-6">
                                    <div class="loyalty-summary-card yellow-card position-relative overflow-hidden">

                                        <!-- Watermark -->
                                        <div class="watermark-icon yellow-watermark">
                                            <i class="fa-regular fa-clock"></i>
                                        </div>

                                        <div class="summary-icon yellow-bg">
                                            <i class="fa-regular fa-clock"></i>
                                        </div>
                                        <!-- Content -->
                                        <div class="summary-label d-flex justify-content-between align-items-center mb-n2">
                                            <span>Used / Expired Coupons</span>
                                            <span class="summary-value">2</span>
                                        </div>

                                        <div class="summary-sub-value">
                                            Value ₹1,000
                                        </div>

                                    </div>
                                </div>

                                <!-- TOTAL VALUE -->
                                <div class="col-lg-3 col-md-6">
                                    <div class="loyalty-summary-card purple-card position-relative overflow-hidden">

                                        <!-- Watermark -->
                                        <div class="watermark-icon purple-watermark">
                                            <i class="fa-regular fa-calendar-days"></i>
                                        </div>

                                        <div class="summary-icon purple-bg">
                                            <i class="fa-regular fa-calendar-days"></i>
                                        </div>

                                        <div class="summary-label">
                                            Total Value
                                        </div>

                                        <div class="summary-big-value">
                                            ₹2,500
                                        </div>

                                    </div>
                                </div>

                            </div>

                            <!-- FEATURE STRIP -->

                            <div class="feature-strip mt-4">

                                <div class="row text-center">

                                    <div class="col-lg-4">
                                        <div class="feature-item">
                                            <i class="fa-solid fa-user"></i>
                                            ₹500 per passenger travelled
                                        </div>
                                    </div>

                                    <div class="col-lg-4">
                                        <div class="feature-item">
                                            <i class="fa-regular fa-calendar"></i>
                                            Valid for 12 months from the date of credit
                                        </div>
                                    </div>

                                    <div class="col-lg-4">
                                        <div class="feature-item">
                                            <i class="fa-solid fa-tags"></i>
                                            Usable on eligible bookings only
                                        </div>
                                    </div>

                                </div>

                            </div>

                            <!-- TABLE CARD -->

                            <div class="table-card mt-4 position-relative overflow-hidden">

                                <!-- Watermark -->
                                <div class="table-watermark">
                                    <i class="fa-solid fa-ticket"></i>
                                </div>

                                <!-- TABS -->

                                <div class="tabs-wrapper py-2">

                                    <div class="coupon-tabs-nav">

                                        <button class="coupon-tab active" data-filter="all">
                                            All Loyalty Coupons
                                            <span class="tab-count">5</span>
                                        </button>

                                        <button class="coupon-tab available-tab" data-filter="available">
                                            Available
                                            <span class="tab-count">3</span>
                                        </button>

                                        <button class="coupon-tab used-tab" data-filter="used">
                                            Used
                                            <span class="tab-count">1</span>
                                        </button>

                                        <button class="coupon-tab expired-tab" data-filter="expired">
                                            Expired
                                            <span class="tab-count">1</span>
                                        </button>

                                    </div>

                                </div>

                                <!-- FILTERS -->

                                <div class="filter-area">

                                    <div class="row align-items-end g-3">

                                        <div class="col-lg-3">
                                            <label class="filter-label">
                                                Sort by
                                            </label>

                                            <select class="form-select">
                                                <option>Latest First</option>
                                                <option>Oldest First</option>
                                            </select>
                                        </div>

                                        <div class="col-lg-3">
                                            <label class="filter-label">
                                                Status
                                            </label>

                                            <select class="form-select">
                                                <option>All</option>
                                                <option>Available</option>
                                                <option>Used</option>
                                                <option>Expired</option>
                                            </select>
                                        </div>

                                        <div class="col-lg-3">
                                            <label class="filter-label">
                                                Valid Till
                                            </label>

                                            <input type="date" class="form-control form-select">
                                        </div>

                                        <div class="col-lg-3 text-lg-end">

                                            <button class="btn download-btn">
                                                <i class="fa-solid fa-download me-2"></i>
                                                Download List
                                            </button>

                                        </div>

                                    </div>

                                </div>

                                <!-- TABLE -->

                                <div class="table-responsive">

                                    <table class="table loyalty-table align-middle">

                                        <thead>

                                            <tr>

                                                <th>Coupon Code</th>
                                                <th>Value</th>
                                                <th>Status</th>
                                                <th>Valid Till</th>
                                                <th>Earned On</th>
                                                <th>Earned For</th>
                                                <th>Used On</th>

                                            </tr>

                                        </thead>

                                        <tbody id="loyaltyTableBody">

                                            <!-- AVAILABLE -->

                                            <tr data-status="available">

                                                <td>
                                                    <div class="coupon-box">
                                                        LOY25050001
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
                                                    28 May 2026
                                                    <div class="days-left">
                                                        9 Days Left
                                                    </div>
                                                </td>

                                                <td>28 May 2025</td>

                                                <td>
                                                    Bali Bliss Trip
                                                    <div class="small text-muted">
                                                        3 Passengers
                                                    </div>
                                                </td>

                                                <td class="text-muted">—</td>

                                            </tr>

                                            <!-- AVAILABLE -->

                                            <tr data-status="available">

                                                <td>
                                                    <div class="coupon-box">
                                                        LOY25050002
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
                                                    28 May 2026
                                                    <div class="days-left">
                                                        9 Days Left
                                                    </div>
                                                </td>

                                                <td>28 May 2025</td>

                                                <td>
                                                    Bali Bliss Trip
                                                    <div class="small text-muted">
                                                        3 Passengers
                                                    </div>
                                                </td>

                                                <td class="text-muted">—</td>

                                            </tr>
                                            
                                            <tr data-status="available">

                                                <td>
                                                    <div class="coupon-box">
                                                        LOY25050003
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
                                                    28 May 2026
                                                    <div class="days-left">
                                                        9 Days Left
                                                    </div>
                                                </td>

                                                <td>28 May 2025</td>

                                                <td>
                                                    Bali Bliss Trip
                                                    <div class="small text-muted">
                                                        3 Passengers
                                                    </div>
                                                </td>

                                                <td class="text-muted">—</td>

                                            </tr>
                                            
                                            <!-- USED -->

                                            <tr data-status="used">

                                                <td>
                                                    <div class="coupon-box">
                                                        LOY25050004
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
                                                    18 Jun 2025
                                                    <div class=" text-danger">
                                                        used
                                                    </div>
                                                </td>

                                                <td>15 Jun 2026</td>

                                                <td>
                                                    Goa Beach Escape
                                                    <div class="small text-muted">
                                                        2 Passengers
                                                    </div>
                                                </td>

                                                <td>
                                                    10 May 2025
                                                    <div class="small text-muted">
                                                        BK250101234
                                                    </div>
                                                </td>

                                            </tr>

                                           
                                            <!-- EXPIRED -->

                                            <tr data-status="expired">

                                                <td>
                                                    <div class="coupon-box">
                                                        LOY25050005
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
                                                    12 Jan 2025
                                                    <div class="text-danger small">
                                                        Expired 70 Weeks Ago
                                                    </div>
                                                </td>

                                                <td>12 Jan 2024</td>

                                                <td class>—</td>

                                                <td class="text-muted">
                                                    Not Used
                                                </td>

                                            </tr>



                                        </tbody>

                                    </table>

                                </div>
                                <div class="mt-3">
                                    <div class="neo-info-strip-wrapper">
                                    <!-- TOP LEFT HEADING -->
                                    <div class="neo-info-strip-heading">
                                        Important Information
                                    </div>
                                    <div class="neo-info-strip">
                                        <div class="neo-info-item">
                                            <div class="neo-info-icon">
                                                <i class="fa-solid fa-ticket"></i>
                                            </div>
                                            <p>
                                                Loyalty coupons are credited after the successful completion of your trip.
                                            </p>
                                        </div>
                                        <div class="neo-info-divider"></div>
                                        <div class="neo-info-item">
                                            <div class="neo-info-icon">
                                                <i class="fa-solid fa-calendar-days"></i>
                                            </div>
                                            <p>
                                                Each loyalty coupon is valid for12 months from the date of credit.
                                            </p>
                                        </div>
                                        <div class="neo-info-divider"></div>
                                        <div class="neo-info-item">
                                            <div class="neo-info-icon">
                                                <i class="fa-solid fa-circle-check"></i>
                                            </div>
                                            <p>
                                                These coupons cannot be exchanged for cash or transferred.
                                            </p>
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
         <!-- =========================
        JAVASCRIPT
        ========================= -->

        <script>

            const tabs = document.querySelectorAll('.coupon-tab');
            const rows = document.querySelectorAll('#loyaltyTableBody tr');

            tabs.forEach(tab => {

                tab.addEventListener('click', function () {

                    tabs.forEach(btn => {
                        btn.classList.remove('active');
                    });

                    this.classList.add('active');

                    const filter = this.dataset.filter;

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