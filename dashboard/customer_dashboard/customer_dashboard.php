<?php
    include_once '../dashboard_user_details.php';
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
                        <!-- Customer Dashboard Greeting Card -->
                        <div class="card border rounded-4 shadow-sm overflow-hidden">
                            <div class="greetingImageWrapper">
                                <img src="../assets/images/greetingImage.png" alt="Package" class="greetingImage img-fluid w-100">
                            </div>
                            <div class="greetingCard">
                                <h2 class="fw-bold text-white gap-3">
                                    Good Morning, <span class="">Pratiksha</span>! &#128075;
                                </h2>
                                <p class="text-white fs-5">
                                    Let's make today a day to remember.
                                </p>
                                <div class="d-flex gap-3 mt-4">
                                    <a href="../../tour-list.php">
                                        <div class="exploreBtn gap-3 px-2">
                                            <i class="fa-solid fa-plane-departure d-flex align-items-center"></i>
                                            <p class="fs-6 mb-0 fw-bolder">Explore Packages</p>
                                        </div>
                                    </a>
                                    <a href="../../tour-list.php">
                                        <div class="exploreBtn gap-3 px-2">
                                            <i class="fa-solid fa-suitcase d-flex align-items-center"></i>
                                            <p class="fs-6 mb-0 fw-bolder"> View My Trips</p>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <!-- card section 1 -->
                        <div class="row">
                            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
                                <div class="card1 border border-2 rounded-4 p-3">
                                    <div class="d-flex gap-3 align-items-center">
                                        <div class="custIcon">
                                            <i class="fa-regular fa-address-card "></i>
                                        </div>
                                        <p class="custID mb-0 fw-bold textColor fs-5">
                                            Customer ID <br>
                                            <span class="custID textColor fw-bolder fs-3">BZH1004587</span>
                                        </p>
                                    </div>
                                    <div class="p-3 text-warning-emphasis bg-warning-subtle border border-2 border-warning-subtle rounded-4 d-flex gap-3 mt-3">
                                        <i class="fa-solid fa-crown d-flex align-items-center" style="color: #ffc107;"></i>
                                        <p class="fs-6 mb-0 fw-bolder">Premium Member</p>
                                    </div>
                                    <div class="mt-4">
                                        <p class="fs-6 text-muted mb-1">Member Since</p>
                                        <p class="fs-5 mb-3 fw-bolder textColor">12 May 2024</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-2 col-lg-2 col-md-6 col-sm-6 col-12 px-0">
                                <div class="card2 border border-2 rounded-4 p-3">
                                    <div class="d-flex gap-3 align-items-center">
                                        <i class="fa-solid fa-ticket fa-2xl" style="color: #056649;"></i>
                                        <p class="mb-0 fw-bold textColor fs-5 custID">
                                            Your Coupons
                                        </p>
                                    </div>
                                    <div class="d-flex justify-content-around gap-3 mt-3">
                                        <div class="mt-3">
                                            <p class="fs-6 text-muted mb-1">Total Vouchers</p>
                                            <p class="fs-4 mb-0 fw-bolder textColor">10</p>
                                        </div>
                                        <div class="mt-3">
                                            <p class="fs-6 text-muted mb-1">Active</p>
                                            <p class="fs-4 mb-0 fw-bolder textColor">3</p>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-center mt-3 mb-4">
                                        <a href="#">
                                            <div class="linkBtn p-2 px-3 border border-primary border-2">
                                                <p class="fs-6 mb-0 fw-bolder"> View Coupons</p>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
                                <div class="border border-2 rounded-4">
                                    <div>
                                        <img src="../assets/images/complimentaryImage.png" alt="Package" class="complimentaryImage img-fluid w-100">
                                    </div>
                                    <div class="complimentaryCard p-3 pt-2 card3">
                                        <div class="d-flex gap-3 align-items-center">
                                            <div class="compliBack">
                                                <i class="fa-solid fa-gifts"></i>
                                            </div>
                                            <p class="mb-0 fw-bold textColor fs-5 custID">
                                                Complimentary Europe Trip
                                            </p>
                                        </div>
                                        <p class="fs-6 text-muted mt-2">Unlock in 6th Year</p>
                                        <div class="d-flex gap-3 mt-3">
                                            <div class="mb-3">
                                                <!-- Years text -->
                                                <p class="fs-5 mb-2">
                                                    <span class="fs-5" id="completedYears">3</span>/<span id="totalYears">6</span>
                                                    <span class="fs-6 text-muted">Years Completed</span>
                                                </p>

                                                <!-- Progress bar -->
                                                <div class="progress border border-2">
                                                    <div class="progress-bar bg-bar" id="yearProgressBar"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mt-2">
                                            <p class="fs-6 mb-0 fw-bolder text-muted">Stay tuned! Keep <br> traveling to unlock</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12 ps-0">
                                <div class="card4 border border-2 rounded-4 p-3">
                                    
                                    <div class="d-flex gap-3 align-items-center mb-2">
                                        <div class="custProfile">
                                            <img src="../assets/images/users/avatar-8.jpg" alt="Package" class="profileImage img-fluid w-100">
                                        </div>
                                        <div class="">
                                            <p class="text-muted mb-0">Your Travel Consultant</p>
                                            <p class="mb-0 fw-bolder fs-4 textColor">
                                                Rahul Mehta<br>
                                                <span class="walletAmount fw-bold textColor fs-6">Senior Travel Consultant</span>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="d-flex gap-3 align-items-center">
                                        <i class="fa-solid fa-phone textColor"></i>
                                        <p class="mb-0 textColor fs-6">
                                            +91 9876543210
                                        </p>
                                    </div>
                                    <div class="d-flex gap-3 align-items-center">
                                        <i class="fa-regular fa-envelope textColor"></i>
                                        <p class="mb-0 textColor fs-6">
                                            rahul.mehta@bizzmirth.com
                                        </p>
                                    </div>
                                    <div class="d-flex gap-3 align-items-center">
                                        <i class="fa-regular fa-clock textColor"></i>
                                        <p class="mb-0 textColor fs-6">
                                            Mon - Sat (10:00 AM -7:00 PM)
                                        </p>
                                    </div>
                                    <div class="d-flex justify-content-center gap-2 mt-3 mb-2">
                                        <a href="#">
                                            <div class="linkBtn gap-2 align-items-center border border-primary border-2">
                                                <i class="fa-brands fa-whatsapp"></i>
                                                <p class="fs-6 mb-0 fw-bolder pe-1">Chat on WhatsApp</p>
                                            </div>
                                        </a>
                                        <a href="#">
                                            <div class="linkBtn gap-2 align-items-center border border-primary border-2">
                                                <i class="fa-regular fa-calendar"></i>
                                                <p class="fs-6 mb-0 fw-bolder pe-1">Schedule a Call</p>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- card section 2 -->
                        <div class="row">
                            <div class="col-lg-3 col-md-6 col-sm-6 col-12 mt-2">
                                <div class="tripCard border border-2 rounded-4 p-3">
                                    <!-- Background Icon -->
                                    <i class="ri-briefcase-3-line brifeCase"></i>
                                    <!-- Content Wrapper -->
                                    <div class="tripContent">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div class="d-flex gap-2 align-items-center">
                                                <div class="tripIcon">
                                                    <i class="ri-briefcase-3-line"></i>
                                                </div>
                                                <p class="mb-0 fw-bold text-black tripTitle">My Trips</p>
                                            </div>
                                            <div class="tripBtn">
                                                <i class="fa-solid fa-arrow-right"></i>
                                            </div>
                                        </div>
                                        <p class="my-3 fw-bold text-muted fs-6">
                                            Upcoming Trips<br>
                                            <span class="textColor fw-bolder fs-4">1</span>
                                        </p>
                                        <p class="mb-0 fw-bold text-muted fs-6">
                                            Completed Trips<br>
                                            <span class="textColor fw-bolder fs-4">3</span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-6 col-12 mt-2">
                                <div class="walletCard border border-2 rounded-4 p-3">
                                    <!-- Background Icon -->
                                    <i class="ri-wallet-fill walletCase"></i>
                                    <!-- Content Wrapper -->
                                    <div class="walletContent">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div class="d-flex gap-2 align-items-center">
                                                <div class="walletIcon1">
                                                    <i class="ri-wallet-line"></i>
                                                </div>
                                                <p class="mb-0 fw-bold text-black walletTitle">Wallet Balance</p>
                                            </div>
                                            <div class="walletBtn">
                                                <i class="fa-solid fa-arrow-right"></i>
                                            </div>
                                        </div>
                                        <p class="my-3 fw-bold text-muted fs-6">
                                            Booking Wallet<br>
                                            <span class="greenText fw-bolder fs-4">&#8377; 2,500</span>
                                        </p>
                                        <p class="mb-0 fw-bold text-muted fs-6">
                                            Redemption Wallet<br>
                                            <span class="greenText fw-bolder fs-4">&#8377; 700</span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-6 col-12 mt-2">
                                <div class="couponCard border border-2 rounded-4 p-3">
                                    <!-- Background Icon -->
                                    <i class="fa-solid fa-gift giftCase"></i>
                                    <!-- Content Wrapper -->
                                    <div class="couponContent">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div class="d-flex gap-2 align-items-center">
                                                <div class="couponIcon1">
                                                    <i class="ri-gift-line"></i>
                                                </div>
                                                <p class="mb-0 fw-bold text-black couponTitle">Rewards & Coupons</p>
                                            </div>
                                            <div class="couponBtn">
                                                <i class="fa-solid fa-arrow-right"></i>
                                            </div>
                                        </div>
                                        <p class="my-3 fw-bold text-muted fs-6">
                                            Active Coupons<br>
                                            <span class="orangeText fw-bolder fs-4">3</span>
                                        </p>
                                        <p class="mb-0 fw-bold text-muted fs-6">
                                            Expiring Soon<br>
                                            <span class="orangeText fw-bolder fs-4">1</span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-6 col-12 mt-2">
                                <div class="referralCard border border-2 rounded-4 p-3">
                                    <!-- Background Icon -->
                                    <i class="fa-solid fa-users referralCase"></i>
                                    <!-- Content Wrapper -->
                                    <div class="referralContent">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div class="d-flex gap-2 align-items-center">
                                                <div class="referralIcon">
                                                    <i class="ri-group-line"></i>
                                                </div>
                                                <p class="mb-0 fw-bold text-black referralTitle">Referrals & Earnings</p>
                                            </div>
                                            <div class="referralBtn">
                                                <i class="fa-solid fa-arrow-right"></i>
                                            </div>
                                        </div>
                                        <p class="my-3 fw-bold text-muted fs-6">
                                            Total Earnings<br>
                                            <span class="blueText fw-bolder fs-4">&#8377; 4,500</span>
                                        </p>
                                        <p class="mb-0 fw-bold text-muted fs-6">
                                            Pending Earnings<br>
                                            <span class="blueText fw-bolder fs-4">&#8377; 1,200</span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- card section 3 -->
                        <div class="card border border-2 rounded-4 my-3">
                            <div class="row">
                                <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12">
                                    <img src="../assets/images/medal.png" alt="Medal" class="img-fluid w-100 medal">
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 premiumCard">
                                    <h4 class="textColor fw-bolder my-4 d-flex">Premium Customer Membership 
                                        <div class="premiumIcon ms-3">
                                            <i class="fa-solid fa-web-awesome me-1" style="color: #e0a10d;"></i>Premium
                                        </div>
                                    </h4>
                                    <div class="row">
                                        <div class="col-lg-3 col-md-3 col-sm-3 col-3 d-flex align-items-center border-end">
                                            <div>
                                                <div class="d-flex justify-content-center align-items-center">
                                                    <div class="membershipIcon">
                                                        <i class="fa-solid fa-indian-rupee-sign"></i>
                                                    </div>
                                                </div>
                                                <div class="mt-4">
                                                    <p class="text-muted mb-1 membershipTitle">One-time Payment</p>
                                                    <p class="mb-3 fw-bolder text-center textColor membershipBold">&#8377;30,000</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-3 col-sm-3 col-3 d-flex align-items-center border-end">
                                            <div>
                                                <div class="d-flex justify-content-center align-items-center">
                                                    <div class="membershipIcon">
                                                        <i class="ri-ticket-2-line"></i>
                                                    </div>
                                                </div>
                                                <div class="mt-4">
                                                    <p class="text-muted mb-1 membershipTitle">10 Holiday Vouchers</p>
                                                    <p class="mb-3 fw-bolder text-center textColor membershipBold">Worth &#8377;3,000 each</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-3 col-sm-3 col-3 d-flex align-items-center border-end">
                                            <div>
                                                <div class="d-flex justify-content-center align-items-center">
                                                    <div class="membershipIcon">
                                                        <i class="ri-plane-line"></i>
                                                    </div>
                                                </div>
                                                <div class="mt-4">
                                                    <p class="text-muted mb-1 membershipTitle">Complimentary</p>
                                                    <p class="mb-3 fw-bolder text-center textColor membershipBold">Europe Trip</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-3 col-sm-3 col-3 d-flex align-items-center border-end">
                                            <div>
                                                <div class="d-flex justify-content-center align-items-center">
                                                    <div class="membershipIcon">
                                                        <i class="fa-solid fa-gem"></i>
                                                    </div>
                                                </div>
                                                <div class="mt-4">
                                                    <p class="text-muted mb-1 membershipTitle">Exclusive Privileges</p>
                                                    <p class="mb-3 fw-bolder text-center textColor membershipBold">& much more</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12 d-flex justify-content-center align-items-center px-3">
                                    <a href="#">
                                        <div class="linkBtn p-3 border border-primary border-2 mb-3">
                                            <p class="fs-6 mb-0 fw-bolder"> View Membership Details</p>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <!-- card section 4 -->
                        <div class="row">
                            <div class="col-lg-5 col-md-6 col-sm-12 col-12">
                                <div class="card rounded-4 p-3 border border-1">
                                    <h4 class="d-flex justify-content-between mb-0 textColor fw-bolder">Upcoming Trips
                                        <a href="#" class="fs-6">View All</a>
                                    </h4>
                                    <hr>
                                    <div class="d-flex gap-2">
                                        <div class="">
                                            <img src="../assets/images/packages/dubai.jpg" alt="TripsImage" class="tripsImage">
                                        </div>
                                        <div class="tripDetails">
                                            <h6 class="text-dark fw-bolder">Dubai Extravaganza</h6>
                                            <p class="text-muted fs-6">12 May 2026 - 18 May 2026 <br> 6D / 7D</p>
                                            <a href="#">
                                                <div class="confirmBtn p-1 mb-3">
                                                    <p class="fs-6 mb-0 fw-bolder">Confirmed</p>
                                                </div>
                                            </a>
                                            <div class="d-flex justify-content-between gap-2 exploreBtns">
                                                <a href="#">
                                                    <div class="exploreBtn p-2 border border-primary border-2 mb-2">
                                                        <p class="fs-6 mb-0 fw-bolder">View Itinerary</p>
                                                    </div>
                                                </a>
                                                <a href="#">
                                                    <div class="exploreBtn p-2 border border-primary border-2 mb-2">
                                                        <p class="fs-6 mb-0 fw-bolder">Make Payment</p>
                                                    </div>
                                                </a>
                                            </div>
                                            <hr>
                                        </div>
                                    </div>
                                    <div class="d-flex gap-3">
                                        <div class="">
                                            <img src="../assets/images/packages/dubai.jpg" alt="TripsImage" class="tripsImage1">
                                        </div>
                                        <div class="tripDetails">
                                            <h6 class="text-dark fw-bolder">Bali Bliss</h6>
                                            <div class="d-flex gap-3">
                                                <p class="text-muted fs-6">12 May 2026 - 18 May 2026 <br> 6D / 7D</p>
                                                <a href="#">
                                                    <div class="upcomingBtn p-1 mb-3">
                                                        <p class="fs-6 mb-0 fw-bolder">Upcoming</p>
                                                    </div>
                                                </a>
                                            </div>
                                            <hr class="mt-0">
                                        </div>
                                    </div>
                                    <div class="d-flex gap-3">
                                        <div class="">
                                            <img src="../assets/images/packages/dubai.jpg" alt="TripsImage" class="tripsImage1">
                                        </div>
                                        <div class="tripDetails">
                                            <h6 class="text-dark fw-bolder">Bali Bliss</h6>
                                            <div class="d-flex gap-3">
                                                <p class="text-muted fs-6">12 May 2026 - 18 May 2026 <br> 6D / 7D</p>
                                                <a href="#">
                                                    <div class="upcomingBtn p-1 mb-3">
                                                        <p class="fs-6 mb-0 fw-bolder">Upcoming</p>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-7 col-md-6 col-sm-12 col-12">
                                <div class="card rounded-4 p-3 border border-1">
                                    <h4 class="d-flex justify-content-between mb-0 textColor fw-bolder">Book Your Next Trip
                                        <a href="#" class="fs-6">View All Packages</a>
                                    </h4>
                                    <hr>
                                    <div id="packageCarousel" class="carousel slide" data-bs-ride="false">
                                        <!-- Dynamic Slides -->
                                        <div class="carousel-inner" id="carouselInner"></div>
                                        <!-- Indicators -->
                                        <div class="carousel-indicators customIndicators" id="carouselIndicators"></div>
                                    </div>
                                    <!-- ALL 12 CARDS -->
                                    <div id="allCards" class="d-none">
                                        <!-- CARD 1 -->
                                        <div class="package-card">
                                            <div class="card border border-1 rounded-4 mb-0">
                                                <div class="packageCard">
                                                    <img src="../assets/images/packages/dubai.jpg" alt="TripsImage" class="packageImage">
                                                    <div class="heartIcon" onclick="toggleWishlist(this)">
                                                        <i class="fa-regular fa-heart"></i>
                                                    </div>
                                                </div>
                                                <div class="packageDetails p-3">
                                                    <h6 class="text-dark fw-bolder">Dubai Extravaganza</h6>
                                                    <p class="text-muted fs-6 d-flex justify-content-between">4D / 5D
                                                        <span class="fs-6 text-muted fw-normal"><i class="fa-solid fa-star" style="color: #fdd611;"></i> 4.8(120)</span>
                                                    </p>
                                                    <p class="mb-3 fw-bolder textColor fs-5">&#8377;39,999<span class="fs-6 text-muted fw-normal">/person</span></p>
                                                    <a href="#">
                                                        <div class="packageDetailBtn p-2 mb-0">
                                                            <p class="fs-6 mb-0 fw-bolder">View Details</p>
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- CARD 2 -->
                                        <div class="package-card">
                                            <div class="card border border-1 rounded-4 mb-0">
                                                <div class="packageCard">
                                                    <img src="../assets/images/packages/dubai.jpg" alt="TripsImage" class="packageImage">
                                                    <div class="heartIcon" onclick="toggleWishlist(this)">
                                                        <i class="fa-regular fa-heart"></i>
                                                    </div>
                                                </div>
                                                <div class="packageDetails p-3">
                                                    <h6 class="text-dark fw-bolder">Dubai Extravaganza</h6>
                                                    <p class="text-muted fs-6 d-flex justify-content-between">4D / 5D
                                                        <span class="fs-6 text-muted fw-normal"><i class="fa-solid fa-star" style="color: #fdd611;"></i> 4.8(120)</span>
                                                    </p>
                                                    <p class="mb-3 fw-bolder textColor fs-5">&#8377;39,999<span class="fs-6 text-muted fw-normal">/person</span></p>
                                                    <a href="#">
                                                        <div class="packageDetailBtn p-2 mb-0">
                                                            <p class="fs-6 mb-0 fw-bolder">View Details</p>
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- CARD 3 -->
                                        <div class="package-card">
                                            <div class="card border border-1 rounded-4 mb-0">
                                                <div class="packageCard">
                                                    <img src="../assets/images/packages/dubai.jpg" alt="TripsImage" class="packageImage">
                                                    <div class="heartIcon" onclick="toggleWishlist(this)">
                                                        <i class="fa-regular fa-heart"></i>
                                                    </div>
                                                </div>
                                                <div class="packageDetails p-3">
                                                    <h6 class="text-dark fw-bolder">Dubai Extravaganza</h6>
                                                    <p class="text-muted fs-6 d-flex justify-content-between">4D / 5D
                                                        <span class="fs-6 text-muted fw-normal"><i class="fa-solid fa-star" style="color: #fdd611;"></i> 4.8(120)</span>
                                                    </p>
                                                    <p class="mb-3 fw-bolder textColor fs-5">&#8377;39,999<span class="fs-6 text-muted fw-normal">/person</span></p>
                                                    <a href="#">
                                                        <div class="packageDetailBtn p-2 mb-0">
                                                            <p class="fs-6 mb-0 fw-bolder">View Details</p>
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- CARD 4 -->
                                        <div class="package-card">
                                            <div class="card border border-1 rounded-4 mb-0">
                                                <div class="packageCard">
                                                    <img src="../assets/images/packages/dubai.jpg" alt="TripsImage" class="packageImage">
                                                    <div class="heartIcon" onclick="toggleWishlist(this)">
                                                        <i class="fa-regular fa-heart"></i>
                                                    </div>
                                                </div>
                                                <div class="packageDetails p-3">
                                                    <h6 class="text-dark fw-bolder">Dubai Extravaganza</h6>
                                                    <p class="text-muted fs-6 d-flex justify-content-between">4D / 5D
                                                        <span class="fs-6 text-muted fw-normal"><i class="fa-solid fa-star" style="color: #fdd611;"></i> 4.8(120)</span>
                                                    </p>
                                                    <p class="mb-3 fw-bolder textColor fs-5">&#8377;39,999<span class="fs-6 text-muted fw-normal">/person</span></p>
                                                    <a href="#">
                                                        <div class="packageDetailBtn p-2 mb-0">
                                                            <p class="fs-6 mb-0 fw-bolder">View Details</p>
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- CARD 5 -->
                                        <div class="package-card">
                                            <div class="card border border-1 rounded-4 mb-0">
                                                <div class="packageCard">
                                                    <img src="../assets/images/packages/dubai.jpg" alt="TripsImage" class="packageImage">
                                                    <div class="heartIcon" onclick="toggleWishlist(this)">
                                                        <i class="fa-regular fa-heart"></i>
                                                    </div>
                                                </div>
                                                <div class="packageDetails p-3">
                                                    <h6 class="text-dark fw-bolder">Dubai Extravaganza</h6>
                                                    <p class="text-muted fs-6 d-flex justify-content-between">4D / 5D
                                                        <span class="fs-6 text-muted fw-normal"><i class="fa-solid fa-star" style="color: #fdd611;"></i> 4.8(120)</span>
                                                    </p>
                                                    <p class="mb-3 fw-bolder textColor fs-5">&#8377;39,999<span class="fs-6 text-muted fw-normal">/person</span></p>
                                                    <a href="#">
                                                        <div class="packageDetailBtn p-2 mb-0">
                                                            <p class="fs-6 mb-0 fw-bolder">View Details</p>
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- CARD 6 -->
                                        <div class="package-card">
                                            <div class="card border border-1 rounded-4 mb-0">
                                                <div class="packageCard">
                                                    <img src="../assets/images/packages/dubai.jpg" alt="TripsImage" class="packageImage">
                                                    <div class="heartIcon" onclick="toggleWishlist(this)">
                                                        <i class="fa-regular fa-heart"></i>
                                                    </div>
                                                </div>
                                                <div class="packageDetails p-3">
                                                    <h6 class="text-dark fw-bolder">Dubai Extravaganza</h6>
                                                    <p class="text-muted fs-6 d-flex justify-content-between">4D / 5D
                                                        <span class="fs-6 text-muted fw-normal"><i class="fa-solid fa-star" style="color: #fdd611;"></i> 4.8(120)</span>
                                                    </p>
                                                    <p class="mb-3 fw-bolder textColor fs-5">&#8377;39,999<span class="fs-6 text-muted fw-normal">/person</span></p>
                                                    <a href="#">
                                                        <div class="packageDetailBtn p-2 mb-0">
                                                            <p class="fs-6 mb-0 fw-bolder">View Details</p>
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- CARD 7 -->
                                        <div class="package-card">
                                            <div class="card border border-1 rounded-4 mb-0">
                                                <div class="packageCard">
                                                    <img src="../assets/images/packages/dubai.jpg" alt="TripsImage" class="packageImage">
                                                    <div class="heartIcon" onclick="toggleWishlist(this)">
                                                        <i class="fa-regular fa-heart"></i>
                                                    </div>
                                                </div>
                                                <div class="packageDetails p-3">
                                                    <h6 class="text-dark fw-bolder">Dubai Extravaganza</h6>
                                                    <p class="text-muted fs-6 d-flex justify-content-between">4D / 5D
                                                        <span class="fs-6 text-muted fw-normal"><i class="fa-solid fa-star" style="color: #fdd611;"></i> 4.8(120)</span>
                                                    </p>
                                                    <p class="mb-3 fw-bolder textColor fs-5">&#8377;39,999<span class="fs-6 text-muted fw-normal">/person</span></p>
                                                    <a href="#">
                                                        <div class="packageDetailBtn p-2 mb-0">
                                                            <p class="fs-6 mb-0 fw-bolder">View Details</p>
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- CARD 8 -->
                                        <div class="package-card">
                                            <div class="card border border-1 rounded-4 mb-0">
                                                <div class="packageCard">
                                                    <img src="../assets/images/packages/dubai.jpg" alt="TripsImage" class="packageImage">
                                                    <div class="heartIcon" onclick="toggleWishlist(this)">
                                                        <i class="fa-regular fa-heart"></i>
                                                    </div>
                                                </div>
                                                <div class="packageDetails p-3">
                                                    <h6 class="text-dark fw-bolder">Dubai Extravaganza</h6>
                                                    <p class="text-muted fs-6 d-flex justify-content-between">4D / 5D
                                                        <span class="fs-6 text-muted fw-normal"><i class="fa-solid fa-star" style="color: #fdd611;"></i> 4.8(120)</span>
                                                    </p>
                                                    <p class="mb-3 fw-bolder textColor fs-5">&#8377;39,999<span class="fs-6 text-muted fw-normal">/person</span></p>
                                                    <a href="#">
                                                        <div class="packageDetailBtn p-2 mb-0">
                                                            <p class="fs-6 mb-0 fw-bolder">View Details</p>
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- CARD 9 -->
                                        <div class="package-card">
                                            <div class="card border border-1 rounded-4 mb-0">
                                                <div class="packageCard">
                                                    <img src="../assets/images/packages/dubai.jpg" alt="TripsImage" class="packageImage">
                                                    <div class="heartIcon" onclick="toggleWishlist(this)">
                                                        <i class="fa-regular fa-heart"></i>
                                                    </div>
                                                </div>
                                                <div class="packageDetails p-3">
                                                    <h6 class="text-dark fw-bolder">Dubai Extravaganza</h6>
                                                    <p class="text-muted fs-6 d-flex justify-content-between">4D / 5D
                                                        <span class="fs-6 text-muted fw-normal"><i class="fa-solid fa-star" style="color: #fdd611;"></i> 4.8(120)</span>
                                                    </p>
                                                    <p class="mb-3 fw-bolder textColor fs-5">&#8377;39,999<span class="fs-6 text-muted fw-normal">/person</span></p>
                                                    <a href="#">
                                                        <div class="packageDetailBtn p-2 mb-0">
                                                            <p class="fs-6 mb-0 fw-bolder">View Details</p>
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- CARD 10 -->
                                        <div class="package-card">
                                            <div class="card border border-1 rounded-4 mb-0">
                                                <div class="packageCard">
                                                    <img src="../assets/images/packages/dubai.jpg" alt="TripsImage" class="packageImage">
                                                    <div class="heartIcon" onclick="toggleWishlist(this)">
                                                        <i class="fa-regular fa-heart"></i>
                                                    </div>
                                                </div>
                                                <div class="packageDetails p-3">
                                                    <h6 class="text-dark fw-bolder">Dubai Extravaganza</h6>
                                                    <p class="text-muted fs-6 d-flex justify-content-between">4D / 5D
                                                        <span class="fs-6 text-muted fw-normal"><i class="fa-solid fa-star" style="color: #fdd611;"></i> 4.8(120)</span>
                                                    </p>
                                                    <p class="mb-3 fw-bolder textColor fs-5">&#8377;39,999<span class="fs-6 text-muted fw-normal">/person</span></p>
                                                    <a href="#">
                                                        <div class="packageDetailBtn p-2 mb-0">
                                                            <p class="fs-6 mb-0 fw-bolder">View Details</p>
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- CARD 11 -->
                                        <div class="package-card">
                                            <div class="card border border-1 rounded-4 mb-0">
                                                <div class="packageCard">
                                                    <img src="../assets/images/packages/dubai.jpg" alt="TripsImage" class="packageImage">
                                                    <div class="heartIcon" onclick="toggleWishlist(this)">
                                                        <i class="fa-regular fa-heart"></i>
                                                    </div>
                                                </div>
                                                <div class="packageDetails p-3">
                                                    <h6 class="text-dark fw-bolder">Dubai Extravaganza</h6>
                                                    <p class="text-muted fs-6 d-flex justify-content-between">4D / 5D
                                                        <span class="fs-6 text-muted fw-normal"><i class="fa-solid fa-star" style="color: #fdd611;"></i> 4.8(120)</span>
                                                    </p>
                                                    <p class="mb-3 fw-bolder textColor fs-5">&#8377;39,999<span class="fs-6 text-muted fw-normal">/person</span></p>
                                                    <a href="#">
                                                        <div class="packageDetailBtn p-2 mb-0">
                                                            <p class="fs-6 mb-0 fw-bolder">View Details</p>
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- CARD 12 -->
                                        <div class="package-card">
                                            <div class="card border border-1 rounded-4 mb-0">
                                                <div class="packageCard">
                                                    <img src="../assets/images/packages/dubai.jpg" alt="TripsImage" class="packageImage">
                                                    <div class="heartIcon" onclick="toggleWishlist(this)">
                                                        <i class="fa-regular fa-heart"></i>
                                                    </div>
                                                </div>
                                                <div class="packageDetails p-3">
                                                    <h6 class="text-dark fw-bolder">Dubai Extravaganza</h6>
                                                    <p class="text-muted fs-6 d-flex justify-content-between">4D / 5D
                                                        <span class="fs-6 text-muted fw-normal"><i class="fa-solid fa-star" style="color: #fdd611;"></i> 4.8(120)</span>
                                                    </p>
                                                    <p class="mb-3 fw-bolder textColor fs-5">&#8377;39,999<span class="fs-6 text-muted fw-normal">/person</span></p>
                                                    <a href="#">
                                                        <div class="packageDetailBtn p-2 mb-0">
                                                            <p class="fs-6 mb-0 fw-bolder">View Details</p>
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- card section 5 -->
                        <div class="row g-3">
                            <div class="col-lg-6 col-12">
                                <div class="analyticsCard p-3 h-100">
                                    <!-- Header -->
                                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">
                                        <h5 class="chartTitle fw-bolder mb-0">
                                            Spending Overview
                                            <span class="smallText">(All Time)</span>
                                        </h5>
                                        <select class="form-select yearSelect" id="yearFilter">
                                            <option value="this">This Year</option>
                                            <option value="last">Last Year</option>
                                        </select>
                                    </div>
                                    <!-- Line Chart -->
                                    <div class="chartWrapper">
                                        <canvas id="spendingChart"></canvas>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-12">
                                <div class="analyticsCard p-3 h-100">
                                    <!-- Header -->
                                    <h5 class="chartTitle fw-bolder mb-4">
                                        Trip Summary
                                        <span class="smallText">(All Time)</span>
                                    </h5>
                                    <div class="row align-items-center g-4">
                                        <!-- Donut Chart -->
                                        <div class="col-md-5 text-center">
                                            <div class="donutWrapper">
                                                <canvas id="tripChart"></canvas>
                                                <!-- Center Text -->
                                                <div class="donutCenterText">
                                                    <h2 class="fw-bolder mb-0">8</h2>
                                                    <p class="smallText mb-0">Total Trips</p>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Legend -->
                                        <div class="col-md-7">
                                            <!-- Domestic -->
                                            <div class="legendItem"onclick="tripAction(0, this)">
                                                <div class="legendLeft">
                                                    <span class="legendColor domestic"></span>
                                                    Domestic Trips
                                                </div>
                                                <span>4 (50%)</span>
                                            </div>

                                            <!-- International -->
                                            <div class="legendItem"onclick="tripAction(0, this)">
                                                <div class="legendLeft">
                                                    <span class="legendColor international"></span>
                                                    International Trips
                                                </div>
                                                <span>3 (37.5%)</span>
                                            </div>

                                            <!-- Upcoming -->
                                            <div class="legendItem mb-0"onclick="tripAction(0, this)">
                                                <div class="legendLeft">
                                                    <span class="legendColor upcoming"></span>
                                                    Upcoming Trips
                                                </div>
                                                <span>1 (12.5%)</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- card section 6 -->
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-12 col-12 mt-3">
                                <div class="p-3 border border-2 rounded-4">
                                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-2">
                                        <h5 class="chartTitle fw-bolder mb-0"> Membership Overview</h5>
                                        <select class="form-select yearSelect" id="yearFilterMembership">
                                            <option value="this">This Year</option>
                                            <option value="last">Last Year</option>
                                        </select>
                                    </div>
                                    <div class="row">
                                        <div class="col-xl-3 col-lg-6 col-md-3 col-sm-3 col-6 mt-2">
                                            <div class="membershipCard1">
                                                <p class="text-center textColor fw-bolder">Total Vouchers</p>
                                                <div class="d-flex justify-content-center align-items-center mb-2">
                                                    <div class="membershipOverviewIcon1">
                                                        10
                                                    </div>
                                                </div>
                                                <p class="text-center textColor fw-bolder">1</p>
                                                <p class="text-center textColor fw-bolder">Worth &#8377;30,000</p>
                                            </div>
                                        </div>
                                        <div class="col-xl-3 col-lg-6 col-md-3 col-sm-3 col-6 mt-2">
                                            <div class="membershipCard2">
                                                <p class="text-center textColor fw-bolder">Vouchers Used</p>
                                                <div class="d-flex justify-content-center align-items-center mb-2">
                                                    <div class="membershipOverviewIcon2">
                                                        <i class="ri-ticket-2-line"></i>
                                                    </div>
                                                </div>
                                                <p class="text-center textColor fw-bolder">3</p>
                                                <p class="text-center textColor fw-bolder">Worth &#8377;9,000</p>
                                            </div>
                                        </div>
                                        <div class="col-xl-3 col-lg-6 col-md-3 col-sm-3 col-6 mt-2">
                                            <div class="membershipCard3">
                                                <p class="text-center textColor fw-bolder">Vouchers Remaining</p>
                                                <div class="d-flex justify-content-center align-items-center mb-2">
                                                    <div class="membershipOverviewIcon3">
                                                        <i class="ri-ticket-2-line"></i>
                                                    </div>
                                                </div>
                                                <p class="text-center textColor fw-bolder">7</p>
                                                <p class="text-center textColor fw-bolder">Worth &#8377;21,000</p>
                                            </div>
                                        </div>
                                        <div class="col-xl-3 col-lg-6 col-md-3 col-sm-3 col-6 mt-2">
                                            <div class="membershipCard4">
                                                <p class="text-center textColor fw-bolder">Total Trips Completed</p>
                                                <div class="d-flex justify-content-center align-items-center mb-2">
                                                    <div class="membershipOverviewIcon4">
                                                        <i class="fa-solid fa-plane-arrival"></i>
                                                    </div>
                                                </div>
                                                <p class="text-center textColor fw-bolder">2</p>
                                                <p class="text-center textColor fw-bolder">(All Time)</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-12 mt-3">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="p-3 border border-2 rounded-4">
                                            <h4 class="d-flex justify-content-between mb-0 text-dark fw-bolder">Earn With Referrals
                                                <a href="#" class="fs-6">View All</a>
                                            </h4>
                                            <div class="d-flex">
                                                <div class="referralDetail flex-grow-1">
                                                    <div class="d-flex justify-content-between">
                                                        <p class="my-3 fw-bold text-muted fs-6">Total Earnings<br>
                                                            <span class="textColor fw-bolder fs-4">&#8377;4,500</span>
                                                        </p>
                                                        <p class="my-3 fw-bold text-muted fs-6">Total Earnings<br>
                                                            <span class="textColor fw-bolder fs-4">&#8377;4,500</span>
                                                        </p>
                                                    </div>
                                                    <a href="#">
                                                        <div class="inviteBtn gap-3 px-2">
                                                            <p class="fs-6 mb-0 fw-bolder">Invite Friends & Earn</p>
                                                            <i class="ri-stackshare-line d-flex align-items-center"></i>
                                                        </div>
                                                    </a>
                                                </div>
                                                <div>
                                                    <img src="../assets/images/referralImage.png" alt="Referral Image" class="referralImage">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 mt-2">
                                        <div class="p-3 border border-2 rounded-4">
                                            <h4 class="d-flex justify-content-between mb-0 text-dark fw-bolder">Notifications & Alerts
                                                <a href="#" class="fs-6">View All</a>
                                            </h4>
                                            <div class="d-flex mt-2">
                                                <div class="notificationDetail flex-grow-1">
                                                    <div class="d-flex gap-2">
                                                        <div class="d-flex justify-content-center align-items-center">
                                                            <div class="notificationIcon">
                                                               <i class="ri-ticket-2-line"></i>
                                                            </div>
                                                        </div>
                                                        <p class="text-muted d-flex align-items-center mb-0">Your Coupon &#8377;1500 OFF is expiring in 2 days!</p>
                                                    </div>
                                                </div>
                                                <p class="text-muted fs-6 d-flex align-items-center mb-0 fw-bolder">2h ago</p>
                                            </div>
                                            <div class="d-flex mt-2">
                                                <div class="notificationDetail flex-grow-1">
                                                    <div class="d-flex gap-2">
                                                        <div class="d-flex justify-content-center align-items-center">
                                                            <div class="notificationIcon">
                                                               <i class="ri-ticket-2-line"></i>
                                                            </div>
                                                        </div>
                                                        <p class="text-muted d-flex align-items-center mb-0">Your Coupon &#8377;1500 OFF is expiring in 2 days!</p>
                                                    </div>
                                                </div>
                                                <p class="text-muted fs-6 d-flex align-items-center mb-0 fw-bolder">2h ago</p>
                                            </div>
                                            <div class="d-flex mt-2">
                                                <div class="notificationDetail flex-grow-1">
                                                    <div class="d-flex gap-2">
                                                        <div class="d-flex justify-content-center align-items-center">
                                                            <div class="notificationIcon">
                                                               <i class="ri-ticket-2-line"></i>
                                                            </div>
                                                        </div>
                                                        <p class="text-muted d-flex align-items-center mb-0">Your Coupon &#8377;1500 OFF is expiring in 2 days!</p>
                                                    </div>
                                                </div>
                                                <p class="text-muted fs-6 d-flex align-items-center mb-0 fw-bolder">2h ago</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- card section 7 -->
                        <div class="p-3 border border-2 rounded-4 mt-3">
                            <h4 class="textColor fw-bolder text-center">Why Premium Members Love Us</h4>
                            <div class="row d-flex justify-content-around">
                                <div class="col-lg-2 col-md-4 col-sm-4 col-6">
                                    <div class="d-flex justify-content-center align-items-center mb-2">
                                        <img src="../assets/images/imageIcons1.png" alt="Icon1" class="imageIcons">
                                    </div>
                                    <p class="textColor fw-bolder fs-6 text-center mb-2">Best Price Guarantee</p>
                                    <p class="text-muted fw-normal fs-6 text-center mb-2">Get the best deals always</p>
                                </div>
                                <div class="col-lg-2 col-md-4 col-sm-4 col-6">
                                    <div class="d-flex justify-content-center align-items-center mb-2">
                                        <img src="../assets/images/imageIcons2.png" alt="Icon1" class="imageIcons">
                                    </div>
                                    <p class="textColor fw-bolder fs-6 text-center mb-2">Best Price Guarantee</p>
                                    <p class="text-muted fw-normal fs-6 text-center mb-2">Get the best deals always</p>
                                </div>
                                <div class="col-lg-2 col-md-4 col-sm-4 col-6">
                                    <div class="d-flex justify-content-center align-items-center mb-2">
                                        <img src="../assets/images/imageIcons3.png" alt="Icon1" class="imageIcons">
                                    </div>
                                    <p class="textColor fw-bolder fs-6 text-center mb-2">Best Price Guarantee</p>
                                    <p class="text-muted fw-normal fs-6 text-center mb-2">Get the best deals always</p>
                                </div>
                                <div class="col-lg-2 col-md-4 col-sm-4 col-6">
                                    <div class="d-flex justify-content-center align-items-center mb-2">
                                        <img src="../assets/images/imageIcons4.png" alt="Icon1" class="imageIcons">
                                    </div>
                                    <p class="textColor fw-bolder fs-6 text-center mb-2">Best Price Guarantee</p>
                                    <p class="text-muted fw-normal fs-6 text-center mb-2">Get the best deals always</p>
                                </div>
                                <div class="col-lg-2 col-md-4 col-sm-4 col-6">
                                    <div class="d-flex justify-content-center align-items-center mb-2">
                                        <img src="../assets/images/imageIcons5.png" alt="Icon1" class="imageIcons">
                                    </div>
                                    <p class="textColor fw-bolder fs-6 text-center mb-2">Best Price Guarantee</p>
                                    <p class="text-muted fw-normal fs-6 text-center mb-2">Get the best deals always</p>
                                </div>
                            </div>
                        </div>
                        <!-- card section 8 -->
                        <div class="supportImagePosition mt-3">
                            <img src="../assets/images/supportImage.png" alt="Referral Image" class="supportImage">
                            <div class="supportDetails">
                                <h3 class="text-white fw-bolder fs-2">Need Help Planning?</h3>
                                <p class="text-white fw-normal fs-5">Our travel experts are here for you.</p>
                                <a href="#">
                                    <div class="supportBtn">
                                        <p class="fs-5 mb-0 fw-bolder">Contact Support</p>
                                    </div>
                                </a>
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
        <!-- Chart -->
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <!-- <script src="../assets/libs/chart.js/Chart-2.5.0.min.js"></script> -->


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

            // Initial Load
            buildCarousel();

            // Rebuild on Resize
            window.addEventListener(
                "resize",
                buildCarousel
            );

        </script>
        <script>
            const spendingCtx = document
                .getElementById("spendingChart")
                .getContext("2d");
            // Gradient Fill
            const gradient = spendingCtx.createLinearGradient(0, 0, 0, 300);
            gradient.addColorStop(0, "rgba(91,95,246,0.35)");
            gradient.addColorStop(1, "rgba(91,95,246,0)");

            // Create Line Chart
            const spendingChart = new Chart(spendingCtx, {
                type: "line",
                data: {
                    labels: [
                        "Jan", "Feb", "Mar", "Apr",
                        "May", "Jun", "Jul", "Aug",
                        "Sep", "Oct", "Nov", "Dec"
                    ],
                    datasets: [{
                        label: "Spending",
                        data: [
                            10, 28, 22, 40,
                            48, 38, 35, 50,
                            65, 45, 63, 55
                        ],
                        borderColor: "#5b5ff6",
                        backgroundColor: gradient,
                        fill: true,
                        tension: 0.4,
                        borderWidth: 3,
                        pointRadius: 4,
                        pointHoverRadius: 6,
                        pointBackgroundColor: "#5b5ff6",
                        pointBorderColor: "#ffffff",
                        pointBorderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        x: {
                            grid: {
                                display: false
                            }
                        },
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return "₹" + value + "K";
                                }
                            },
                            grid: {
                                color: "#f0f0f0"
                            }
                        }
                    }
                }
            });

            // Chart Height
            document.getElementById("spendingChart")
                .parentNode.style.height = "300px";

            // DONUT CHART
            const tripCtx = document
                .getElementById("tripChart")
                .getContext("2d");

            const tripChart = new Chart(tripCtx, {
                type: "doughnut",
                data: {
                    labels: [
                        "Domestic Trips",
                        "International Trips",
                        "Upcoming Trips"
                    ],
                    datasets: [{
                        data: [4, 3, 1],
                        backgroundColor: [
                            "#5b5ff6",
                            "#1e88ff",
                            "#10c981"
                        ],
                        borderWidth: 0,
                        hoverOffset: 10
                    }]
                },
                options: {
                    responsive: true,
                    cutout: "72%",
                    plugins: {
                        legend: {
                            display: false
                        }
                    }
                }
            });

            // DONUT LEGEND TOGGLE
            const originalData = [4, 3, 1];
            function tripAction(index, element) {
                const currentValue =
                    tripChart.data.datasets[0].data[index];
                // HIDE
                if(currentValue !== 0) {
                    tripChart.data.datasets[0].data[index] = 0;
                    // ADD CUT EFFECT
                    element.classList.add("inactiveLegend");
                }
                // SHOW AGAIN
                else {
                    tripChart.data.datasets[0].data[index] =
                        originalData[index];

                    // REMOVE CUT EFFECT
                    element.classList.remove("inactiveLegend");
                }
                tripChart.update();
            }

            // YEAR FILTER

            const yearFilter =
                document.getElementById("yearFilter");
            yearFilter.addEventListener("change", function () {
                // THIS YEAR
                if (this.value === "this") {
                    spendingChart.data.datasets[0].data = [
                        10, 28, 22, 40,
                        48, 38, 35, 50,
                        65, 45, 63, 55
                    ];
                }
                // LAST YEAR
                else {
                    spendingChart.data.datasets[0].data = [
                        15, 20, 30, 25,
                        40, 42, 50, 55,
                        48, 60, 70, 68

                    ];
                }
                // Update Chart
                spendingChart.update();
            });
        </script>
        <!-- dialer logic -->
    </body>
</html>
