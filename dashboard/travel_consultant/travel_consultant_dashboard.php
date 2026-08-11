<?php
    include_once(__DIR__ . '/../dashboard_user_details.php');
    // include 'travel_consultant_model.php';
    include 'urls.php';
?>
<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable">
    <head>
        <meta charset="utf-8" />
        <title>Travel Consultant | Uniqbizz</title>
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
        <!-- custom Css-->
        <link href="../assets/css/custom.min.css" rel="stylesheet" type="text/css" />
        <!-- App Css-->
        <link href="../assets/css/app.min.css" rel="stylesheet" type="text/css" />
        <!-- custom Css developer-->
        <link rel="stylesheet" href="../assets/css/custom.css" />
        <!-- Travel Consultant CSS -->
        <link rel="stylesheet" href="../assets/css/travel_consultant.css" />
        
        <!-- FontAwesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        
    </head>
    <body class="twocolumn-panel">
        <!-- Begin page -->
        <div id="layout-wrapper">
            <?php include_once "travel_consultant_header.php" ?>

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

            <?php include_once "travel_consultant_sidebar.php" ?>
            <!-- ============================================================== -->
            <!-- Start of Travel Consultant here -->
            <!-- ============================================================== -->
            <div class="main-content">
                <div class="page-content">
                    <div class="container-fluid ps-0">
                        <!-- Travel Consultant Greeting Card -->
                        <div class="card border rounded-4 shadow-sm overflow-hidden">
                            <div class="greetingImageWrapper">
                                <img src="../assets/images/travelConsultantImage.png" alt="Package" class="greetingImage img-fluid w-100">
                            </div>
                            <div class="greetingCard">
                                <p class="fw-bold text-dark gap-3 fs-4">Welcome Back,<span class="" id="userName"></span>! &#128075;</p>
                                <h1 class="fw-bold text-dark gap-3">Travel Consultant</h1>
                                <p class="text-dark fs-4 mb-0">Let's Create Beautiful Journey</p>
                                <p class="text-dark fs-4">Earn more with every happy traveler</p>
                            </div>
                        </div>
                        <!-- Card section 1 -->
                        <div class="row mb-3">
                            <div class="col-lg-6 col-md-6 col-sm-12 col-12 mb-2">
                                <div class="activationCard border border-2 rounded-4 p-3">
                                    <!-- Background Icon -->
                                    <i class="fa-solid fa-address-card activationCardIcon"></i>
                                    <!-- Content Wrapper -->
                                    <div class="activationContent">
                                        <div class="d-flex gap-3">
                                            <div class="">
                                                <div class="activationIcon1">
                                                    <i class="fa-solid fa-user-group"></i>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1">
                                                <div class="align-content-center">
                                                    <p class="mb-0 fw-bold text-black activationTitle">Holiday Account Activation</p>
                                                    <p class="mb-0 fw-normal text-black fs-6">(Neo Select Customers)</p>
                                                </div>
                                                <p class="fs-2 text-dark fw-bolder" id="reg_cu_count">22</p>
                                                <p class="fw-normal text-black fs-6">Total Active Customers</p>
                                                <a href="customers_list.php" class="text-decoration-none text-reset">
                                                    <div class="activationBtn fw-bolder">
                                                        View Customers <i class="fa-solid fa-arrow-right"></i>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="activationIcon2">
                                            <i class="fa-solid fa-circle-check fa-2xl"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-12 mb-2">
                                <div class="earnedCard border border-2 rounded-4 p-3">
                                    <!-- Background Icon -->
                                    <i class="fa-solid fa-coins earnedCardIcon"></i>
                                    <!-- Content Wrapper -->
                                    <div class="earnedContent">
                                        <div class="d-flex gap-3">
                                            <div class="">
                                                <div class="earnedIcon1">
                                                    <i class="fa-solid fa-indian-rupee-sign"></i>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1">
                                                <div class="align-content-center">
                                                    <p class="mb-0 fw-bold text-black earnedTitle">Commission Earned</p>
                                                    <p class="mb-0 fw-bolder text-black fs-4" id="total_comm">&#8377;24,000</p>
                                                </div>
                                                <!-- <p class="text-dark fw-bolder fs-6"></p> -->
                                                <div class="d-flex gap-3 cardSmallScreen">
                                                    <div class="card p-2 mb-2 rounded-4 justify-content-center">
                                                        <p class="mb-0 fs-6">From Activation</p>
                                                        <p class="mb-0 fs-5 fw-bolder" id="activation_amount">&#8377; 18,00,000</p>
                                                    </div>
                                                    <div class="card p-2 mb-2 rounded-4 justify-content-center">
                                                        <p class="mb-0 fs-6">From Trip Completed</p>
                                                        <p class="mb-0 fs-5 fw-bolder" id="trip_amount">&#8377; 6,000</p>
                                                    </div>
                                                </div>
                                                <a href="#" class="text-decoration-none text-reset">
                                                    <div class="earnedBtn fw-bolder">
                                                        View Commission <i class="fa-solid fa-arrow-right"></i>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Card section 2 -->
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                                <div class="cardChart card border-1">
                                    <div class="card-title d-flex justify-content-between p-2">
                                        <p class="commission-title fs-5">Neo Select Customer Growth</p>
                                        <p class="">
                                            <select class="form-select yearSelect py-1" id="yearFilter">
                                                
                                            </select>
                                        </p>
                                    </div>
                                    <div class="card-body">
                                        <canvas id="customerTrendChart">
                                        </canvas>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                                <div class="card rounded-4 border-1 p-3">
                                    <div class="card-title d-flex justify-content-between p-2">
                                        <p class="commission-title fs-5 mb-1">
                                            Recent Neo Select Customers
                                        </p>
                                        <p class="viewLink">
                                            <a href="#">View All <i class="fa-solid fa-arrow-right"></i></a>
                                        </p>
                                    </div>
                                    <div class="cardDetails table-responsive">
                                        <table class="table">
                                            <thead>
                                                <tr class="table-active">
                                                    <th scope="col" class="text-muted">Customer</th>
                                                    <th scope="col" class="text-muted">Mobile</th>
                                                    <th scope="col" class="text-muted">Enrolled On</th>
                                                    <th scope="col" class="text-muted">Status</th>
                                                    <th scope="col" class="text-muted">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody id="recentNeoSelectCustomer">
                                                
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Card section 3 -->
                        <div class="row">
                            <div class="col-lg-7 col-md-7 col-sm-12 col-12">
                                <h4 class="d-flex justify-content-between mb-0 textColor fw-bolder mb-2">Most Trending Packages
                                    <a href="<?= $home_url ?>tour-list.php" class="fs-6">View All Packages</a>
                                </h4>
                                <div id="packageCarousel" class="carousel slide" data-bs-ride="false">

                                    <div class="carousel-inner" id="carouselInner"></div>

                                    <div class="carousel-indicators customIndicators"
                                        id="carouselIndicators"></div>

                                </div>

                                <div id="packageCards" class="d-none"></div>

                            </div>
                            <div class="col-lg-5 col-md-5 col-sm-12 col-12">
                                <div class="card rounded-4 border-1 p-3">
                                    <div class="card-title">
                                        <p class="commission-title fs-5 mb-1">
                                            Package Benefits
                                        </p>
                                    </div>
                                    <hr class="mt-0">
                                    <div class="cardDetails">
                                        <div class="d-flex justify-content-between mb-3">
                                            <div class="d-flex gap-2">
                                                <div class="tcPackageIcon tcPackageIcon1">
                                                    <i class="fa-solid fa-ranking-star fa-xl"></i>
                                                </div>
                                                <div class="">
                                                    <p class="mb-1 fs-6 fw-bold">Best Price Guarantee</p>
                                                    <p class="mb-1 fs-6 text-muted">Get the best deals and save more.</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-between mb-3">
                                            <div class="d-flex gap-2">
                                                <div class="tcPackageIcon tcPackageIcon2">
                                                    <i class="fa-solid fa-money-check-dollar fa-xl"></i>
                                                </div>
                                                <div class="">
                                                    <p class="mb-1 fs-6 fw-bold">Easy EMI Options</p>
                                                    <p class="mb-1 fs-6 text-muted">Book now and pay in easy installments.</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-between mb-3">
                                            <div class="d-flex gap-2">
                                                <div class="tcPackageIcon tcPackageIcon3">
                                                    <i class="fa-solid fa-hotel fa-xl"></i>
                                                </div>
                                                <div class="">
                                                    <p class="mb-1 fs-6 fw-bold">Premium Stay</p>
                                                    <p class="mb-1 fs-6 text-muted">Handpicked hotels for a comfortable stay.</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-between mb-3">
                                            <div class="d-flex gap-2">
                                                <div class="tcPackageIcon tcPackageIcon4">
                                                    <i class="fa-solid fa-face-grin-stars fa-xl"></i>
                                                </div>
                                                <div class="">
                                                    <p class="mb-1 fs-6 fw-bold">Exciting Experiences</p>
                                                    <p class="mb-1 fs-6 text-muted">Curated tours and activities included.</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-between mb-3">
                                            <div class="d-flex gap-2">
                                                <div class="tcPackageIcon tcPackageIcon5">
                                                    <i class="fa-solid fa-phone fa-xl"></i>
                                                </div>
                                                <div class="">
                                                    <p class="mb-1 fs-6 fw-bold">24x7 Travel Support</p>
                                                    <p class="mb-1 fs-6 text-muted">We are with you always.</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Card section 4 -->
                        <div class="card rounded-4 border-1 p-3">
                            <div class="card-title d-flex justify-content-between p-2">
                                <p class="commission-title fs-5 mb-1">
                                    Recent Bookings from Customers
                                </p>
                                <p class="viewLink">
                                    <a href="#">View All <i class="fa-solid fa-arrow-right"></i></a>
                                </p>
                            </div>
                            <div class="cardDetails table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr class="table-active">
                                            <th scope="col" class="text-muted">Customer</th>
                                            <th scope="col" class="text-muted">Package</th>
                                            <th scope="col" class="text-muted">Travel Date</th>
                                            <th scope="col" class="text-muted">Amount</th>
                                            <th scope="col" class="text-muted">Status</th>
                                            <th scope="col" class="text-muted">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="recentCustomerBooking">
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- Card section 5 -->
                         <div class="row">
                            <div class="col-lg-5 col-md-5 col-sm-12 col-12 mb-3">
                                <div class="card rounded-4 border-1 p-3 mb-0">
                                    <div class="card-title d-flex justify-content-between align-items-center">
                                        <p class="commission-title fs-5 mb-0">
                                            Recent Activities
                                        </p>
                                        <!-- <a href="#" class="fs-6 fw-bold">
                                            View All
                                        </a> -->
                                    </div>
                                    <div class="cardDetails" id="recentActivities">
                                        <!-- kept the code for future  scope -->
                                        <!-- <div class="d-flex justify-content-between mb-1">
                                            <div class="d-flex gap-2">
                                                <div class="tcPackageIcon tcPackageIcon1">
                                                    <i class="fa-solid fa-user fa-xl"></i>
                                                </div>
                                                <p class="mb-0 align-content-center fs-6 fw-bold">Follow up done with Anita Mehta</p>
                                            </div>
                                            <p class="text-muted mb-0 align-content-center">Yesterday</p>
                                        </div> -->
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-7 col-md-7 col-sm-12 col-12 mb-3">
                                <div class="card border-1 p-3 rounded-4 mb-0">
                                    <h5 class="fw-bold mb-4">Commission Breakdown</h5>
                                    <div class="row align-items-center">
                                        <!-- Donut Chart -->
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-12 text-center">
                                            <div class="chart-wrapper">
                                                <div id="commissionChart"></div>

                                                <div class="chart-center">
                                                    <h4 id="totalCommission">₹ 0</h4>
                                                    <p>Total Commission</p>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Legend -->
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                                            <div class="mb-4">
                                                <div class="d-flex align-items-center mb-2">
                                                    <span class="legend-dot bg-primary"></span>
                                                    <span class="fw-semibold ms-2">From Activation</span>
                                                </div>
                                                <p class="mb-0 text-secondary ms-4" id="activationCommission">
                                                    ₹ 0 (0%)
                                                </p>
                                            </div>
                                            <div>
                                                <div class="d-flex align-items-center mb-2">
                                                    <span class="legend-dot bg-success"></span>
                                                    <span class="fw-semibold ms-2">From Trip Completed</span>
                                                </div>
                                                <p class="mb-0 text-secondary ms-4" id="tripCommission">
                                                    ₹ 0 (0%)
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-4 fw-medium text-secondary">
                                        More activations and completed trips = More earnings! 🎉
                                    </div>
                                </div>
                            </div>
                         </div>
                        <!-- card section 6 -->
                        <div class="supportImagePosition mt-2">
                            <img src="../assets/images/supportImage.png" alt="Referral Image" class="supportImage">
                            <div class="supportDetails">
                                <h3 class="text-white fw-bolder fs-2">Need Help Planning?</h3>
                                <p class="text-white fw-normal fs-5">Our travel experts are here for you.</p>
                                <a href="#">
                                    <div class="supportBtn" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                                        <p class="fs-5 mb-0 fw-bolder">Contact Support</p>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php include_once "travel_consultant_footer.php" ?>
            </div>

            <!-- end main content-->
            <!-- End of Travel Consultant here -->
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
        <?php include (__DIR__.'/../contact_modal.php') ?>

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
        <!-- Chart -->
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

        <script src="../assets/js/js-confetti.js"></script>

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
        <!-- Sidebar Start -->
        <script>
            document.addEventListener("DOMContentLoaded", function () {

                const sidebar = document.querySelector(".navbar-menu");
                const hamburger = document.getElementById("topnav-hamburger-icon");
                const hamburgerIcon = document.querySelector(".hamburger-icon");
                const overlay = document.querySelector(".vertical-overlay");

                if (window.innerWidth > 1024) {
                    sidebar.classList.remove("sidebar-hidden");
                }

                hamburger.addEventListener("click", function () {

                    if (window.innerWidth <= 1024) {

                        /* BELOW 767 - YOUR ORIGINAL WORKING LOGIC */
                        if (window.innerWidth <= 767) {

                            sidebar.classList.toggle("sidebar-mobile-show");
                            hamburgerIcon.classList.toggle("open");

                            if (overlay) {
                                overlay.classList.toggle("active");
                            }
                        }

                        /* 768px TO 1024px */
                        else {

                            if (!sidebar.classList.contains("sidebar-mobile-show")) {

                                sidebar.classList.add("sidebar-mobile-show");

                                if (overlay) {
                                    overlay.classList.add("active");
                                }

                                /* SHOW 3 LINES */
                                hamburgerIcon.classList.add("open");

                            } else {

                                sidebar.classList.remove("sidebar-mobile-show");

                                if (overlay) {
                                    overlay.classList.remove("active");
                                }

                                /* SHOW ARROW */
                                hamburgerIcon.classList.remove("open");
                            }
                        }

                    } else {

                        /* DESKTOP */
                        sidebar.classList.toggle("sidebar-hidden");
                    }
                });

                if (overlay) {

                    overlay.addEventListener("click", function () {

                        sidebar.classList.remove("sidebar-mobile-show");
                        overlay.classList.remove("active");
                        hamburgerIcon.classList.remove("open");

                    });
                }

            });
        </script>
        <!-- Sidebar End -->
        <!-- Most Trending Packages -->
        <script>
            function buildCarousel() {
                const carouselInner = document.getElementById("carouselInner");
                const indicators = document.getElementById("carouselIndicators");
                const cards = document.querySelectorAll(".package-card");
                carouselInner.innerHTML = "";
                indicators.innerHTML = "";
                let cardsPerSlide = 3;
                // xl
                if (window.innerWidth >= 1280) {
                    cardsPerSlide = 3;
                }
                // lg
                else if (window.innerWidth >= 992) {
                    cardsPerSlide = 2;
                }

                // md
                else if (window.innerWidth >= 768) {
                    cardsPerSlide = 2;
                }

                // sm
                else if (window.innerWidth >=575 ) {
                    cardsPerSlide = 2;
                }
                else {
                    cardsPerSlide = 1;
                }

                // CREATE SLIDES
                for (let i = 0; i < cards.length; i += cardsPerSlide) {
                    // Slide
                    const carouselItem = document.createElement("div");
                    carouselItem.classList.add("carousel-item");
                    if (i === 0) {
                        carouselItem.classList.add("active");
                    }

                    // Row
                    const row = document.createElement("div");
                    row.classList.add("row", "g-3");

                    // ADD CARDS
                    for (
                        let j = i;
                        j < i + cardsPerSlide && j < cards.length;
                        j++
                    ) {

                        const col = document.createElement("div");

                        // Dynamic bootstrap columns
                        if (cardsPerSlide === 3) {
                            col.className =
                                "col-lg-4 col-md-6 col-sm-6 col-12";
                        }
                        else if (cardsPerSlide === 2) {
                            col.className =
                                "col-md-6 col-sm-6 col-12";
                        }
                        else {
                            col.className =
                                "col-12";
                        }

                        col.innerHTML = cards[j].innerHTML;
                        row.appendChild(col);
                    }
                    carouselItem.appendChild(row);
                    carouselInner.appendChild(carouselItem);

                    // INDICATORS
                    const button = document.createElement("button");
                    button.type = "button";
                    button.setAttribute(
                        "data-bs-target",
                        "#packageCarousel"
                    );

                    button.setAttribute(
                        "data-bs-slide-to",
                        i / cardsPerSlide
                    );
                    if (i === 0) {
                        button.classList.add("active");
                    }
                    indicators.appendChild(button);
                }
            }

            // buildCarousel();
            // Destroy old instance if exists
            const carouselEl = document.getElementById('packageCarousel');

            let carousel = bootstrap.Carousel.getInstance(carouselEl);

            if (carousel) {
                carousel.dispose();
            }

            // Create new instance
            carousel = new bootstrap.Carousel(carouselEl, {
                interval: false,
                ride: false,
                touch: true,
                wrap: true
            });
            // Rebuild on Resize
            window.addEventListener(
                "resize",
                buildCarousel
            );

        </script>
        <script>
            function toggleWishlist(button) {

                button.classList.toggle("active");

                const icon = button.querySelector("i");

                if (button.classList.contains("active")) {
                    icon.classList.remove("fa-regular");
                    icon.classList.add("fa-solid");
                } else {
                    icon.classList.remove("fa-solid");
                    icon.classList.add("fa-regular");
                }
            }
        </script>
        <script>
            const home_url='<?= $home_url ?>';
            $(function () {
                //title card plus trip slider
                $.ajax({
                    url: 'travel_consultant_model.php',
                    type: 'GET',
                    dataType: 'json',

                    success: function(res) {

                        if (!res.status) return;

                        $('#userName').text(res.customer.firstname+' '+res.customer.lastname);

                        let html = '';

                        res.packages.forEach(function(pkg){

                            html += `
                                <div class="package-card">
                                    <div class="card border border-1 rounded-4 mb-0">

                                        <div class="packageCard">

                                            <img src="${home_url}${pkg.image}"
                                                alt="TripsImage"
                                                class="packageImage">

                                            <!--<div class="heartIcon"
                                                onclick="toggleWishlist(this)">
                                                <i class="fa-regular fa-heart"></i>
                                            </div>-->

                                        </div>

                                        <div class="packageDetails p-3">

                                            <h6 class="text-dark fw-bolder">
                                                ${pkg.packname}
                                            </h6>

                                            <p class="text-muted fs-6 d-flex justify-content-between">

                                                ${pkg.duration}

                                                <!--<span class="fs-6 text-muted fw-normal">
                                                    <i class="fa-solid fa-star" style="color:#fdd611;"></i>
                                                    4.8 (120)
                                                </span>-->

                                            </p>

                                            <p class="mb-3 fw-bolder textColor fs-5">

                                                ₹ ${Number(pkg.price).toLocaleString('en-IN')}

                                                <span class="fs-6 text-muted fw-normal">
                                                    /person
                                                </span>

                                            </p>

                                            <a href="${home_url}tour-details.php?pacId=${pkg.packid}">

                                                <div class="packageDetailBtn p-2 mb-0">

                                                    <span class="fs-6 mb-0 fw-bolder">
                                                        View Details
                                                    </span>

                                                </div>

                                            </a>

                                        </div>

                                    </div>
                                </div>
                            `;
                        });

                        $('#packageCards').html(html);

                        if (res.packages.length === 0) {

                            $('#carouselInner').html(`
                                <div class="carousel-item active">
                                    <div class="text-center py-5">
                                        <img src="../assets/images/registerData.png"
                                            class="img-fluid"
                                            style="max-width:220px">

                                        <h5 class="mt-3">No packages available</h5>

                                        <p class="text-muted">
                                            Packages will appear here.
                                        </p>
                                    </div>
                                </div>
                            `);

                            $('#carouselIndicators').empty();

                        } else {

                            buildCarousel();

                        }

                    }
                });
                //customer count plus commission cards
                $.ajax({
                    url: 'ajax/dashboard/card_data.php', 
                    type: 'GET',
                    dataType: 'json',

                    beforeSend: function () {
                        // Optional: Show loader
                    },

                    success: function (res) {

                        if (res.status) {

                            $('#reg_cu_count').text(res.data.reg_cu_count || 0);

                            $('#activation_amount').html(
                                '&#8377; ' + Number(res.data.activation_amount || 0).toLocaleString('en-IN')
                            );

                            $('#trip_amount').html(
                                '&#8377; ' + Number(res.data.trip_amount || 0).toLocaleString('en-IN')
                            );

                            $('#total_comm').html(
                                '&#8377; ' + Number(res.data.total_comm || 0).toLocaleString('en-IN')
                            );

                        } else {

                            console.log(res.message);

                            $('#reg_cu_count').text('0');
                            $('#activation_amount').html('&#8377; 0');
                            $('#trip_amount').html('&#8377; 0');
                            $('#total_comm').html('&#8377; 0');
                        }
                    },

                    error: function (xhr, status, error) {

                        console.error(error);

                        $('#reg_cu_count').text('0');
                        $('#activation_amount').html('&#8377; 0');
                        $('#trip_amount').html('&#8377; 0');
                        $('#total_comm').html('&#8377; 0');
                    }

                });
                //customer count chart 
                let customerTrendChart = null;

                function loadCustomerGrowth(year = ''){

                    $.ajax({

                        url:'ajax/dashboard/cust_growth_chart_data.php',
                        type:'POST',
                        data:{
                            year:year
                        },
                        dataType:'json',

                        success:function(res){

                            if(!res.status){
                                return;
                            }

                            // Populate Year Dropdown
                            if($('#yearFilter option').length==0){

                                let option='';

                                $.each(res.years,function(i,yr){

                                    option += `<option value="${yr}">${yr}</option>`;

                                });

                                $('#yearFilter').html(option);
                            }

                            $('#yearFilter').val(res.selectedYear);

                            if(customerTrendChart){
                                customerTrendChart.destroy();
                            }

                            const ctx=document.getElementById('customerTrendChart');
                            const maxValue = Math.max(...res.data);

                            customerTrendChart=new Chart(ctx,{

                                type:'line',

                                data:{

                                    labels:res.labels,

                                    datasets:[{

                                        data:res.data,

                                        borderColor:'#3B82F6',

                                        borderWidth:3,

                                        pointBackgroundColor:'#3B82F6',

                                        pointBorderColor:'#3B82F6',

                                        pointRadius:4,

                                        pointHoverRadius:6,

                                        fill:true,

                                        tension:0.4,

                                        backgroundColor:(context)=>{

                                            const chart=context.chart;
                                            const {ctx,chartArea}=chart;

                                            if(!chartArea) return null;

                                            const gradient=ctx.createLinearGradient(
                                                0,
                                                chartArea.top,
                                                0,
                                                chartArea.bottom
                                            );

                                            gradient.addColorStop(0,'rgba(59,130,246,0.20)');
                                            gradient.addColorStop(1,'rgba(59,130,246,0.01)');

                                            return gradient;
                                        }

                                    }]

                                },

                                options:{

                                    responsive:true,

                                    maintainAspectRatio:false,

                                    plugins:{

                                        legend:{
                                            display:false
                                        },

                                        tooltip:{
                                            enabled:true
                                        }

                                    },

                                    scales:{

                                        x:{

                                            grid:{
                                                display:false
                                            },

                                            border:{
                                                display:false
                                            },

                                            ticks:{

                                                color:'#6B7280',

                                                font:{
                                                    weight:'600'
                                                }

                                            }

                                        },

                                        

                                        y: {
                                            beginAtZero: true,
                                            max: maxValue === 0 ? 10 : undefined,
                                            suggestedMax: maxValue === 0 ? undefined : maxValue + 1,
                                            ticks: {
                                                stepSize: 1,
                                                precision: 0,
                                                color: '#6B7280',
                                                font: {
                                                    weight: '600'
                                                }
                                            },
                                            grid: {
                                                color: '#EEF2F7'
                                            },
                                            border: {
                                                display: false
                                            }
                                        }

                                    }

                                },

                                plugins:[{

                                    id:'valueLabels',

                                    afterDatasetsDraw(chart){

                                        const {ctx}=chart;

                                        chart.data.datasets.forEach((dataset,datasetIndex)=>{

                                            const meta=chart.getDatasetMeta(datasetIndex);

                                            meta.data.forEach((point,index)=>{

                                                ctx.save();

                                                ctx.fillStyle='#3B82F6';

                                                ctx.font='bold 14px Arial';

                                                ctx.textAlign='center';

                                                ctx.fillText(
                                                    dataset.data[index],
                                                    point.x,
                                                    point.y-12
                                                );

                                                ctx.restore();

                                            });

                                        });

                                    }

                                }]

                            });

                        }

                    });

                }

                loadCustomerGrowth();
                //on year chage for customet count chart
                $('#yearFilter').on('change',function(){
    
                    loadCustomerGrowth($(this).val());
    
                });
                //recent neo customers
                function loadRecentNeoSelectCustomers(){

                    $.ajax({

                        url: 'ajax/dashboard/recent_cu_list.php', //change to your php file

                        type: 'POST',

                        dataType: 'json',

                        success:function(res){

                            let html = '';

                            if(res.status && res.data.length > 0){

                                $.each(res.data,function(i,row){

                                    let statusClass = '';

                                    switch(row.status.toLowerCase()){

                                        case 'active':
                                            statusClass = 'teActiveBtn';
                                            break;

                                        case 'pending':
                                            statusClass = 'tePendingBtn';
                                            break;

                                        case 'deactive':
                                            statusClass = 'teDeletedBtn';
                                            break;

                                        case 'deleted':
                                            statusClass = 'teDeletedBtn';
                                            break;

                                        default:
                                            statusClass = 'tePendingBtn';

                                    }

                                    let date = new Date(row.register_date);

                                    let enrolledDate = date.toLocaleDateString('en-GB',{
                                        day:'2-digit',
                                        month:'short',
                                        year:'numeric'
                                    });

                                    html += `
                                        <tr>

                                            <td>
                                                <p class="fw-bolder align-content-center fs-6 mb-0">
                                                    ${row.cust_name}
                                                </p>
                                            </td>

                                            <td>
                                                <p class="fw-bolder fs-6 mb-0">
                                                    ${row.phone}
                                                </p>
                                            </td>

                                            <td>
                                                <p class="fw-bolder fs-6 mb-0">
                                                    ${enrolledDate}
                                                </p>
                                            </td>

                                            <td>
                                                <p class="fw-bolder ${statusClass} rounded-pill text-center mb-0">
                                                    ${row.status}
                                                </p>
                                            </td>

                                            <td>
                                                <form id="viewCustomerForm${row.ca_customer_id}" action="edit_customer.php" method="POST" style="display:none;">
                                                    <input type="hidden" name="id" value="${row.ca_customer_id}">
                                                    <input type="hidden" name="status" value="${row.status}">
                                                </form>

                                                <a href="javascript:void(0);" onclick="document.getElementById('viewCustomerForm${row.ca_customer_id}').submit();">
                                                    <p class="fw-bolder teViewBtn text-center mb-0">
                                                        <i class="fa-solid fa-eye me-2 mt-1"></i>View
                                                    </p>
                                                </a>
                                            </td>

                                        </tr>
                                    `;

                                });

                            }else{

                                html = `
                                    <tr>
                                        <td colspan="5" class="text-center py-4">
                                            No Customers Found
                                        </td>
                                    </tr>
                                `;

                            }

                            $('#recentNeoSelectCustomer').html(html);

                        },

                        error:function(){

                            $('#recentNeoSelectCustomer').html(`
                                <tr>
                                    <td colspan="5" class="text-center py-4">
                                        Unable to load data.
                                    </td>
                                </tr>
                            `);

                        }

                    });

                }
                loadRecentNeoSelectCustomers();
                //recent bookings
                function loadRecentBookings() {

                    $.ajax({

                        url: 'ajax/dashboard/recent_booking.php', 
                        type: 'POST',
                        dataType: 'json',

                        success: function(res) {

                            let html = '';

                            if (res.status && res.data.length > 0) {

                                $.each(res.data, function(i, booking) {

                                    let statusClass = '';

                                    switch (booking.booking_status.toLowerCase()) {

                                        case 'confirmed':
                                        case 'completed':
                                        case 'traveling':
                                            statusClass = 'teActiveBtn';
                                            break;

                                        case 'pending':
                                            statusClass = 'tePendingBtn';
                                            break;

                                        case 'canceled':
                                        case 'cancelled':
                                        case 'refunded':
                                            statusClass = 'teDeletedBtn';
                                            break;

                                        default:
                                            statusClass = 'tePendingBtn';

                                    }

                                    let travelDate = new Date(booking.travel_date).toLocaleDateString('en-GB', {
                                        day: '2-digit',
                                        month: 'short',
                                        year: 'numeric'
                                    });

                                    let amount = parseFloat(booking.amount || 0).toLocaleString('en-IN', {
                                        minimumFractionDigits: 0,
                                        maximumFractionDigits: 2
                                    });

                                    html += `
                                        <tr>

                                            <td>
                                                <p class="fw-bolder align-content-center fs-6 mb-0">
                                                    ${booking.name}
                                                </p>
                                                <p class="fw-bolder align-content-center fs-6 mb-0">
                                                    ${booking.customer_id}
                                                </p>
                                            </td>

                                            <td>
                                                <div class="d-flex align-items-center gap-2">
                                                    <img src="${'../../'+booking.package_image}"
                                                        alt="${booking.package_name}"
                                                        class="rounded-3"
                                                        style="width:40px;height:40px;object-fit:cover;">

                                                    <p class="fw-bolder fs-6 mb-0">
                                                        ${booking.package_name}
                                                    </p>
                                                </div>
                                            </td>

                                            <td>
                                                <p class="fw-bolder fs-6 mb-0">
                                                    ${travelDate}
                                                </p>
                                            </td>

                                            <td>
                                                <p class="fw-bolder fs-6 mb-0">
                                                    &#8377; ${amount}
                                                </p>
                                            </td>

                                            <td>
                                                <p class="fw-bolder ${statusClass} rounded-pill text-center mb-0">
                                                    ${booking.booking_status}
                                                </p>
                                            </td>

                                            <td>
                                                <a href="booking-details.php?order_id=${booking.order_id}">
                                                    <p class="fw-bolder teViewBtn text-center mb-0">
                                                        <i class="fa-solid fa-eye me-2 mt-1"></i>View
                                                    </p>
                                                </a>
                                            </td>

                                        </tr>
                                    `;

                                });

                            } else {

                                html = `
                                    <tr>
                                        <td colspan="6" class="text-center py-4 fw-bold">
                                            No Recent Bookings Found
                                        </td>
                                    </tr>
                                `;

                            }

                            $('#recentCustomerBooking').html(html);

                        },

                        error: function() {

                            $('#recentCustomerBooking').html(`
                                <tr>
                                    <td colspan="6" class="text-center py-4 text-danger fw-bold">
                                        Unable to load bookings.
                                    </td>
                                </tr>
                            `);

                        }

                    });

                }

                loadRecentBookings();

                //recent activities
                function loadRecentActivities() {

                    $.ajax({

                        url: 'ajax/dashboard/recent_activities_data.php', 
                        type: 'POST',
                        dataType: 'json',

                        success: function(res) {

                            let html = '';

                            if (res.status && res.data.length > 0) {

                                $.each(res.data, function(index, activity) {

                                    let icon = '';
                                    let iconClass = '';

                                    switch (activity.type) {

                                        case 'pending_customer':
                                            icon = 'fa-user-group';
                                            iconClass = 'tcPackageIcon1';
                                            break;

                                        case 'customer_activation':
                                            icon = 'fa-user-check';
                                            iconClass = 'tcPackageIcon2';
                                            break;

                                        case 'commission':
                                            icon = 'fa-indian-rupee-sign';
                                            iconClass = 'tcPackageIcon3';
                                            break;

                                        case 'booking':
                                            icon = 'fa-plane-departure';
                                            iconClass = 'tcPackageIcon5';
                                            break;

                                        default:
                                            icon = 'fa-circle-info';
                                            iconClass = 'tcPackageIcon1';

                                    }

                                    let activityTime = formatActivityTime(activity.date);

                                    html += `
                                        <div class="d-flex justify-content-between mb-1">

                                            <div class="d-flex gap-2">

                                                <div class="tcPackageIcon ${iconClass}">
                                                    <i class="fa-solid ${icon} fa-xl"></i>
                                                </div>

                                                <p class="mb-0 align-content-center fs-6 fw-bold">
                                                    ${activity.title}
                                                </p>

                                            </div>

                                            <p class="text-muted mb-0 align-content-center text-nowrap">
                                                ${activityTime}
                                            </p>

                                        </div>
                                    `;

                                });

                            } else {

                                html = `
                                    <div class="text-center py-4 fw-bold text-muted">
                                        No Recent Activities
                                    </div>
                                `;

                            }

                            $('#recentActivities').html(html);

                        },

                        error: function() {

                            $('#recentActivities').html(`
                                <div class="text-center py-4 text-danger fw-bold">
                                    Unable to load activities.
                                </div>
                            `);

                        }

                    });

                }


                /*
                |--------------------------------------------------------------------------
                | Format Time
                |--------------------------------------------------------------------------
                */

                function formatActivityTime(dateString) {

                    const activityDate = new Date(dateString);
                    const now = new Date();

                    const today = new Date(now.getFullYear(), now.getMonth(), now.getDate());
                    const activityDay = new Date(activityDate.getFullYear(), activityDate.getMonth(), activityDate.getDate());

                    const diffDays = Math.floor((today - activityDay) / (1000 * 60 * 60 * 24));

                    if (diffDays === 0) {

                        return activityDate.toLocaleTimeString('en-IN', {
                            hour: '2-digit',
                            minute: '2-digit',
                            hour12: true
                        });

                    }

                    if (diffDays === 1) {

                        return 'Yesterday';

                    }

                    return activityDate.toLocaleDateString('en-IN', {
                        day: '2-digit',
                        month: 'short'
                    });

                }


                loadRecentActivities();

                //commission chart
                let commissionChart;

                function loadCommissionBreakdown(){

                    $.ajax({

                        url:'ajax/dashboard/pie_chart_data.php',

                        type:'POST',

                        dataType:'json',

                        success:function(res){

                            if(!res.status) return;

                            $('#totalCommission').html(
                                '₹ '+Number(res.total).toLocaleString('en-IN')
                            );

                            $('#activationCommission').html(
                                '₹ '+Number(res.activation).toLocaleString('en-IN')+
                                ' ('+res.activationPercentage+'%)'
                            );

                            $('#tripCommission').html(
                                '₹ '+Number(res.trip).toLocaleString('en-IN')+
                                ' ('+res.tripPercentage+'%)'
                            );

                            let series;

                            if(res.total==0){

                                // Show grey donut instead of empty chart
                                series=[100];

                            }else{

                                series=[
                                    res.activationPercentage,
                                    res.tripPercentage
                                ];

                            }

                            if(commissionChart){
                                commissionChart.destroy();
                            }

                            commissionChart = new ApexCharts(
                                document.querySelector("#commissionChart"),
                                {

                                    series:series,

                                    chart:{
                                        type:'donut',
                                        height:200
                                    },

                                    colors:res.total==0
                                        ? ['#E5E7EB']
                                        : ['#3366F5','#A8E6B8'],

                                    legend:{
                                        show:false
                                    },

                                    dataLabels:{
                                        enabled:false
                                    },

                                    stroke:{
                                        width:0
                                    },

                                    plotOptions:{
                                        pie:{
                                            donut:{
                                                size:'75%'
                                            }
                                        }
                                    },

                                    tooltip:{
                                        enabled:res.total>0
                                    }

                                }
                            );

                            commissionChart.render();

                        }

                    });

                }

                loadCommissionBreakdown();
            });
        </script>
    </body>
</html>