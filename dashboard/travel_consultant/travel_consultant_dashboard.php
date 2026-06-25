<?php
    include_once '../dashboard_user_details.php';
    include 'travel_consultant_model.php';
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
        <!-- App Css-->
        <link href="../assets/css/app.min.css" rel="stylesheet" type="text/css" />
        <!-- custom Css-->
        <link href="../assets/css/custom.min.css" rel="stylesheet" type="text/css" />
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
                                                <p class="fs-2 text-dark fw-bolder">22</p>
                                                <p class="fw-normal text-black fs-6">Total Active Customers</p>
                                                <div class="activationBtn fw-bolder">
                                                    View Customers <i class="fa-solid fa-arrow-right"></i>
                                                </div>
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
                                                    <p class="mb-0 fw-bolder text-black fs-4">&#8377;24,000</p>
                                                </div>
                                                <p class="text-dark fw-bolder fs-6">This Month</p>
                                                <div class="d-flex gap-3 cardSmallScreen">
                                                    <div class="card p-2 mb-2 rounded-4 justify-content-center">
                                                        <p class="mb-0 fs-6">From Activation</p>
                                                        <p class="mb-0 fs-5 fw-bolder">&#8377; 18,00,000</p>
                                                    </div>
                                                    <div class="card p-2 mb-2 rounded-4 justify-content-center">
                                                        <p class="mb-0 fs-6">From Trip Completed</p>
                                                        <p class="mb-0 fs-5 fw-bolder">&#8377; 6,000</p>
                                                    </div>
                                                </div>
                                                <div class="earnedBtn fw-bolder">
                                                    View Commission <i class="fa-solid fa-arrow-right"></i>
                                                </div>
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
                                                <tr>
                                                    <td>
                                                        <p class="fw-bolder align-content-center fs-6 mb-0">Rahul Naik</p>
                                                    </td>
                                                    <td>
                                                        <p class="fw-bolder fs-6 mb-0">98XXXXXX10</p>
                                                    </td>
                                                    <td>
                                                        <p class="fw-bolder fs-6 mb-0">23 May 2024</p>
                                                    </td>
                                                    <td>
                                                        <p class="fw-bolder teActiveBtn rounded-pill text-center mb-0">Active</p>
                                                    </td>
                                                    <td>
                                                        <a href="#">
                                                            <p class="fw-bolder teViewBtn text-center mb-0"><i class="fa-solid fa-eye me-2 mt-1"></i>View</p>
                                                        </a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <p class="fw-bolder align-content-center fs-6 mb-0">Rahul Naik</p>
                                                    </td>
                                                    <td>
                                                        <p class="fw-bolder fs-6 mb-0">98XXXXXX10</p>
                                                    </td>
                                                    <td>
                                                        <p class="fw-bolder fs-6 mb-0">23 May 2024</p>
                                                    </td>
                                                    <td>
                                                        <p class="fw-bolder teActiveBtn rounded-pill text-center mb-0">Active</p>
                                                    </td>
                                                    <td>
                                                        <a href="#">
                                                            <p class="fw-bolder teViewBtn text-center mb-0"><i class="fa-solid fa-eye me-2 mt-1"></i>View</p>
                                                        </a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <p class="fw-bolder align-content-center fs-6 mb-0">Rahul Naik</p>
                                                    </td>
                                                    <td>
                                                        <p class="fw-bolder fs-6 mb-0">98XXXXXX10</p>
                                                    </td>
                                                    <td>
                                                        <p class="fw-bolder fs-6 mb-0">23 May 2024</p>
                                                    </td>
                                                    <td>
                                                        <p class="fw-bolder teDeletedBtn rounded-pill text-center mb-0">Deactive</p>
                                                    </td>
                                                    <td>
                                                        <a href="#">
                                                            <p class="fw-bolder teViewBtn text-center mb-0"><i class="fa-solid fa-eye me-2 mt-1"></i>View</p>
                                                        </a>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Card section 3 -->
                        <div class="row">
                            <div class="col-lg-7 col-md-7 col-sm-12 col-12">
                                <div class="card rounded-4 p-3 border border-1">
                                    <h4 class="d-flex justify-content-between mb-0 textColor fw-bolder">Most Trending Packages
                                        <a href="<?= $home_url ?>tour-list.php" class="fs-6">View All Packages</a>
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
                                                    <img src="<?= $home_url ?><?=$package_array[0]['image']?>" alt="TripsImage" class="packageImage">
                                                    <div class="heartIcon" onclick="toggleWishlist(this)">
                                                        <i class="fa-regular fa-heart"></i>
                                                    </div>
                                                </div>
                                                <div class="packageDetails p-3">
                                                    <h6 class="text-dark fw-bolder"><?=$package_array[0]['packname']?></h6>
                                                    <p class="text-muted fs-6 d-flex justify-content-between"><?=$package_array[0]['duration']?>
                                                        <!--<span class="fs-6 text-muted fw-normal"><i class="fa-solid fa-star" style="color: #fdd611;"></i> 4.8(120)</span>-->
                                                    </p>
                                                    <p class="mb-3 fw-bolder textColor fs-5">&#8377;<?=$package_array[0]['price']?><span class="fs-6 text-muted fw-normal">/person</span></p>
                                                    <a href="#">
                                                        <div class="packageDetailBtn p-2 mb-0 ">
                                                            <a href="<?= $home_url ?>tour-details.php?pacId=<?=$package_array[0]['packid']?>" class="fs-6 mb-0 fw-bolder">View Details</a>
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- CARD 2 -->
                                        <div class="package-card">
                                            <div class="card border border-1 rounded-4 mb-0">
                                                <div class="packageCard">
                                                    <img src="<?= $home_url ?><?=$package_array[1]['image']?>" alt="TripsImage" class="packageImage">
                                                    <div class="heartIcon" onclick="toggleWishlist(this)">
                                                        <i class="fa-regular fa-heart"></i>
                                                    </div>
                                                </div>
                                                <div class="packageDetails p-3">
                                                    <h6 class="text-dark fw-bolder"><?=$package_array[1]['packname']?></h6>
                                                    <p class="text-muted fs-6 d-flex justify-content-between"><?=$package_array[1]['duration']?>
                                                        <!--<span class="fs-6 text-muted fw-normal"><i class="fa-solid fa-star" style="color: #fdd611;"></i> 4.8(120)</span>-->
                                                    </p>
                                                    <p class="mb-3 fw-bolder textColor fs-5">&#8377;<?=$package_array[1]['price']?><span class="fs-6 text-muted fw-normal">/person</span></p>
                                                    <a href="#">
                                                        <div class="packageDetailBtn p-2 mb-0 ">
                                                            <a href="<?= $home_url ?>tour-details.php?pacId=<?=$package_array[1]['packid']?>" class="fs-6 mb-0 fw-bolder">View Details</a>
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- CARD 3 -->
                                        <div class="package-card">
                                            <div class="card border border-1 rounded-4 mb-0">
                                                <div class="packageCard">
                                                    <img src="<?= $home_url ?><?=$package_array[2]['image']?>" alt="TripsImage" class="packageImage">
                                                    <div class="heartIcon" onclick="toggleWishlist(this)">
                                                        <i class="fa-regular fa-heart"></i>
                                                    </div>
                                                </div>
                                                <div class="packageDetails p-3">
                                                    <h6 class="text-dark fw-bolder"><?=$package_array[2]['packname']?></h6>
                                                    <p class="text-muted fs-6 d-flex justify-content-between"><?=$package_array[2]['duration']?>
                                                        <!--<span class="fs-6 text-muted fw-normal"><i class="fa-solid fa-star" style="color: #fdd611;"></i> 4.8(120)</span>-->
                                                    </p>
                                                    <p class="mb-3 fw-bolder textColor fs-5">&#8377;<?=$package_array[2]['price']?><span class="fs-6 text-muted fw-normal">/person</span></p>
                                                    <a href="#">
                                                        <div class="packageDetailBtn p-2 mb-0 ">
                                                            <a href="<?= $home_url ?>tour-details.php?pacId=<?=$package_array[2]['packid']?>" class="fs-6 mb-0 fw-bolder">View Details</a>
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- CARD 4 -->
                                        <div class="package-card">
                                            <div class="card border border-1 rounded-4 mb-0">
                                                <div class="packageCard">
                                                    <img src="<?= $home_url ?><?=$package_array[3]['image']?>" alt="TripsImage" class="packageImage">
                                                    <div class="heartIcon" onclick="toggleWishlist(this)">
                                                        <i class="fa-regular fa-heart"></i>
                                                    </div>
                                                </div>
                                                <div class="packageDetails p-3">
                                                    <h6 class="text-dark fw-bolder"><?=$package_array[3]['packname']?></h6>
                                                    <p class="text-muted fs-6 d-flex justify-content-between"><?=$package_array[3]['duration']?>
                                                        <!--<span class="fs-6 text-muted fw-normal"><i class="fa-solid fa-star" style="color: #fdd611;"></i> 4.8(120)</span>-->
                                                    </p>
                                                    <p class="mb-3 fw-bolder textColor fs-5">&#8377;<?=$package_array[3]['price']?><span class="fs-6 text-muted fw-normal">/person</span></p>
                                                    <a href="#">
                                                        <div class="packageDetailBtn p-2 mb-0 ">
                                                            <a href="<?= $home_url ?>tour-details.php?pacId=<?=$package_array[3]['packid']?>" class="fs-6 mb-0 fw-bolder">View Details</a>
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- CARD 5 -->
                                        <div class="package-card">
                                            <div class="card border border-1 rounded-4 mb-0">
                                                <div class="packageCard">
                                                    <img src="<?= $home_url ?><?=$package_array[4]['image']?>" alt="TripsImage" class="packageImage">
                                                    <div class="heartIcon" onclick="toggleWishlist(this)">
                                                        <i class="fa-regular fa-heart"></i>
                                                    </div>
                                                </div>
                                                <div class="packageDetails p-3">
                                                    <h6 class="text-dark fw-bolder"><?=$package_array[4]['packname']?></h6>
                                                    <p class="text-muted fs-6 d-flex justify-content-between"><?=$package_array[4]['duration']?>
                                                        <!--<span class="fs-6 text-muted fw-normal"><i class="fa-solid fa-star" style="color: #fdd611;"></i> 4.8(120)</span>-->
                                                    </p>
                                                    <p class="mb-3 fw-bolder textColor fs-5">&#8377;<?=$package_array[4]['price']?><span class="fs-6 text-muted fw-normal">/person</span></p>
                                                    <a href="#">
                                                        <div class="packageDetailBtn p-2 mb-0 ">
                                                            <a href="<?= $home_url ?>tour-details.php?pacId=<?=$package_array[4]['packid']?>" class="fs-6 mb-0 fw-bolder">View Details</a>
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- CARD 6 -->
                                        <div class="package-card">
                                            <div class="card border border-1 rounded-4 mb-0">
                                                <div class="packageCard">
                                                    <img src="<?= $home_url ?><?=$package_array[5]['image']?>" alt="TripsImage" class="packageImage">
                                                    <div class="heartIcon" onclick="toggleWishlist(this)">
                                                        <i class="fa-regular fa-heart"></i>
                                                    </div>
                                                </div>
                                                <div class="packageDetails p-3">
                                                    <h6 class="text-dark fw-bolder"><?=$package_array[5]['packname']?></h6>
                                                    <p class="text-muted fs-6 d-flex justify-content-between"><?=$package_array[5]['duration']?>
                                                        <!--<span class="fs-6 text-muted fw-normal"><i class="fa-solid fa-star" style="color: #fdd611;"></i> 4.8(120)</span>-->
                                                    </p>
                                                    <p class="mb-3 fw-bolder textColor fs-5">&#8377;<?=$package_array[5]['price']?><span class="fs-6 text-muted fw-normal">/person</span></p>
                                                    <a href="#">
                                                        <div class="packageDetailBtn p-2 mb-0 ">
                                                            <a href="<?= $home_url ?>tour-details.php?pacId=<?=$package_array[5]['packid']?>" class="fs-6 mb-0 fw-bolder">View Details</a>
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- CARD 7 -->
                                        <div class="package-card">
                                            <div class="card border border-1 rounded-4 mb-0">
                                                <div class="packageCard">
                                                    <img src="<?= $home_url ?><?=$package_array[6]['image']?>" alt="TripsImage" class="packageImage">
                                                    <div class="heartIcon" onclick="toggleWishlist(this)">
                                                        <i class="fa-regular fa-heart"></i>
                                                    </div>
                                                </div>
                                                <div class="packageDetails p-3">
                                                    <h6 class="text-dark fw-bolder"><?=$package_array[6]['packname']?></h6>
                                                    <p class="text-muted fs-6 d-flex justify-content-between"><?=$package_array[6]['duration']?>
                                                        <!--<span class="fs-6 text-muted fw-normal"><i class="fa-solid fa-star" style="color: #fdd611;"></i> 4.8(120)</span>-->
                                                    </p>
                                                    <p class="mb-3 fw-bolder textColor fs-5">&#8377;<?=$package_array[6]['price']?><span class="fs-6 text-muted fw-normal">/person</span></p>
                                                    <a href="#">
                                                        <div class="packageDetailBtn p-2 mb-0 ">
                                                            <a href="<?= $home_url ?>tour-details.php?pacId=<?=$package_array[6]['packid']?>" class="fs-6 mb-0 fw-bolder">View Details</a>
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- CARD 8 -->
                                        <div class="package-card">
                                            <div class="card border border-1 rounded-4 mb-0">
                                                <div class="packageCard">
                                                    <img src="<?= $home_url ?><?=$package_array[7]['image']?>" alt="TripsImage" class="packageImage">
                                                    <div class="heartIcon" onclick="toggleWishlist(this)">
                                                        <i class="fa-regular fa-heart"></i>
                                                    </div>
                                                </div>
                                                <div class="packageDetails p-3">
                                                    <h6 class="text-dark fw-bolder"><?=$package_array[7]['packname']?></h6>
                                                    <p class="text-muted fs-6 d-flex justify-content-between"><?=$package_array[7]['duration']?>
                                                        <!--<span class="fs-6 text-muted fw-normal"><i class="fa-solid fa-star" style="color: #fdd611;"></i> 4.8(120)</span>-->
                                                    </p>
                                                    <p class="mb-3 fw-bolder textColor fs-5">&#8377;<?=$package_array[7]['price']?><span class="fs-6 text-muted fw-normal">/person</span></p>
                                                    <a href="#">
                                                        <div class="packageDetailBtn p-2 mb-0 ">
                                                            <a href="<?= $home_url ?>tour-details.php?pacId=<?=$package_array[7]['packid']?>" class="fs-6 mb-0 fw-bolder">View Details</a>
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- CARD 9 -->
                                        <div class="package-card">
                                            <div class="card border border-1 rounded-4 mb-0">
                                                <div class="packageCard">
                                                    <img src="<?= $home_url ?><?=$package_array[8]['image']?>" alt="TripsImage" class="packageImage">
                                                    <div class="heartIcon" onclick="toggleWishlist(this)">
                                                        <i class="fa-regular fa-heart"></i>
                                                    </div>
                                                </div>
                                                <div class="packageDetails p-3">
                                                    <h6 class="text-dark fw-bolder"><?=$package_array[8]['packname']?></h6>
                                                    <p class="text-muted fs-6 d-flex justify-content-between"><?=$package_array[8]['duration']?>
                                                        <!--<span class="fs-6 text-muted fw-normal"><i class="fa-solid fa-star" style="color: #fdd611;"></i> 4.8(120)</span>-->
                                                    </p>
                                                    <p class="mb-3 fw-bolder textColor fs-5">&#8377;<?=$package_array[8]['price']?><span class="fs-6 text-muted fw-normal">/person</span></p>
                                                    <a href="#">
                                                        <div class="packageDetailBtn p-2 mb-0 ">
                                                            <a href="<?= $home_url ?>tour-details.php?pacId=<?=$package_array[8]['packid']?>" class="fs-6 mb-0 fw-bolder">View Details</a>
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- CARD 10 -->
                                        <div class="package-card">
                                            <div class="card border border-1 rounded-4 mb-0">
                                                <div class="packageCard">
                                                    <img src="<?= $home_url ?><?=$package_array[9]['image']?>" alt="TripsImage" class="packageImage">
                                                    <div class="heartIcon" onclick="toggleWishlist(this)">
                                                        <i class="fa-regular fa-heart"></i>
                                                    </div>
                                                </div>
                                                <div class="packageDetails p-3">
                                                    <h6 class="text-dark fw-bolder"><?=$package_array[9]['packname']?></h6>
                                                    <p class="text-muted fs-6 d-flex justify-content-between"><?=$package_array[9]['duration']?>
                                                        <!--<span class="fs-6 text-muted fw-normal"><i class="fa-solid fa-star" style="color: #fdd611;"></i> 4.8(120)</span>-->
                                                    </p>
                                                    <p class="mb-3 fw-bolder textColor fs-5">&#8377;<?=$package_array[9]['price']?><span class="fs-6 text-muted fw-normal">/person</span></p>
                                                    <a href="#">
                                                        <div class="packageDetailBtn p-2 mb-0 ">
                                                            <a href="<?= $home_url ?>tour-details.php?pacId=<?=$package_array[9]['packid']?>" class="fs-6 mb-0 fw-bolder">View Details</a>
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- CARD 11 -->
                                        <div class="package-card">
                                            <div class="card border border-1 rounded-4 mb-0">
                                                <div class="packageCard">
                                                    <img src="<?= $home_url ?><?=$package_array[10]['image']?>" alt="TripsImage" class="packageImage">
                                                    <div class="heartIcon" onclick="toggleWishlist(this)">
                                                        <i class="fa-regular fa-heart"></i>
                                                    </div>
                                                </div>
                                                <div class="packageDetails p-3">
                                                    <h6 class="text-dark fw-bolder"><?=$package_array[10]['packname']?></h6>
                                                    <p class="text-muted fs-6 d-flex justify-content-between"><?=$package_array[10]['duration']?>
                                                        <!--<span class="fs-6 text-muted fw-normal"><i class="fa-solid fa-star" style="color: #fdd611;"></i> 4.8(120)</span>-->
                                                    </p>
                                                    <p class="mb-3 fw-bolder textColor fs-5">&#8377;<?=$package_array[10]['price']?><span class="fs-6 text-muted fw-normal">/person</span></p>
                                                    <a href="#">
                                                        <div class="packageDetailBtn p-2 mb-0 ">
                                                            <a href="<?= $home_url ?>tour-details.php?pacId=<?=$package_array[10]['packid']?>" class="fs-6 mb-0 fw-bolder">View Details</a>
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- CARD 12 -->
                                        <div class="package-card">
                                            <div class="card border border-1 rounded-4 mb-0">
                                                <div class="packageCard">
                                                    <img src="<?= $home_url ?><?=$package_array[11]['image']?>" alt="TripsImage" class="packageImage">
                                                    <div class="heartIcon" onclick="toggleWishlist(this)">
                                                        <i class="fa-regular fa-heart"></i>
                                                    </div>
                                                </div>
                                                <div class="packageDetails p-3">
                                                    <h6 class="text-dark fw-bolder"><?=$package_array[11]['packname']?></h6>
                                                    <p class="text-muted fs-6 d-flex justify-content-between"><?=$package_array[11]['duration']?>
                                                        <span class="fs-6 text-muted fw-normal"><i class="fa-solid fa-star" style="color: #fdd611;"></i> 4.8(120)</span>
                                                    </p>
                                                    <p class="mb-3 fw-bolder textColor fs-5">&#8377;<?=$package_array[11]['price']?><span class="fs-6 text-muted fw-normal">/person</span></p>
                                                    <a href="#">
                                                        <div class="packageDetailBtn p-2 mb-0 ">
                                                            <a href="<?= $home_url ?>tour-details.php?pacId=<?=$package_array[11]['packid']?>" class="fs-6 mb-0 fw-bolder">View Details</a>
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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
                                    <tbody id="recentNeoSelectCustomer">
                                        <tr>
                                            <td>
                                                <p class="fw-bolder align-content-center fs-6 mb-0">Rahul Naik</p>
                                            </td>
                                            <td>
                                                <p class="fw-bolder fs-6 mb-0">Dubai Delight</p>
                                            </td>
                                            <td>
                                                <p class="fw-bolder fs-6 mb-0">23 May 2024</p>
                                            </td>
                                            <td>
                                                <p class="fw-bolder fs-6 mb-0">&#8377; 24,999</p>
                                            </td>
                                            <td>
                                                <p class="fw-bolder teActiveBtn rounded-pill text-center mb-0">Confirmed</p>
                                            </td>
                                            <td>
                                                <a href="#">
                                                    <p class="fw-bolder teViewBtn text-center mb-0"><i class="fa-solid fa-eye me-2 mt-1"></i>View</p>
                                                </a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <p class="fw-bolder align-content-center fs-6 mb-0">Rahul Naik</p>
                                            </td>
                                            <td>
                                                <p class="fw-bolder fs-6 mb-0">Dubai Delight</p>
                                            </td>
                                            <td>
                                                <p class="fw-bolder fs-6 mb-0">23 May 2024</p>
                                            </td>
                                            <td>
                                                <p class="fw-bolder fs-6 mb-0">&#8377; 24,999</p>
                                            </td>
                                            <td>
                                                <p class="fw-bolder tePendingBtn rounded-pill text-center mb-0">Pending</p>
                                            </td>
                                            <td>
                                                <a href="#">
                                                    <p class="fw-bolder teViewBtn text-center mb-0"><i class="fa-solid fa-eye me-2 mt-1"></i>View</p>
                                                </a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <p class="fw-bolder align-content-center fs-6 mb-0">Rahul Naik</p>
                                            </td>
                                            <td>
                                                <p class="fw-bolder fs-6 mb-0">Dubai Delight</p>
                                            </td>
                                            <td>
                                                <p class="fw-bolder fs-6 mb-0">23 May 2024</p>
                                            </td>
                                            <td>
                                                <p class="fw-bolder fs-6 mb-0">&#8377; 24,999</p>
                                            </td>
                                            <td>
                                                <p class="fw-bolder teActiveBtn rounded-pill text-center mb-0">Confirmed</p>
                                            </td>
                                            <td>
                                                <a href="#">
                                                    <p class="fw-bolder teViewBtn text-center mb-0"><i class="fa-solid fa-eye me-2 mt-1"></i>View</p>
                                                </a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <p class="fw-bolder align-content-center fs-6 mb-0">Rahul Naik</p>
                                            </td>
                                            <td>
                                                <p class="fw-bolder fs-6 mb-0">Dubai Delight</p>
                                            </td>
                                            <td>
                                                <p class="fw-bolder fs-6 mb-0">23 May 2024</p>
                                            </td>
                                            <td>
                                                <p class="fw-bolder fs-6 mb-0">&#8377; 24,999</p>
                                            </td>
                                            <td>
                                                <p class="fw-bolder tePendingBtn rounded-pill text-center mb-0">Pending</p>
                                            </td>
                                            <td>
                                                <a href="#">
                                                    <p class="fw-bolder teViewBtn text-center mb-0"><i class="fa-solid fa-eye me-2 mt-1"></i>View</p>
                                                </a>
                                            </td>
                                        </tr>
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
                                        <a href="#" class="fs-6 fw-bold">
                                            View All
                                        </a>
                                    </div>
                                    <div class="cardDetails" id="#">
                                        <div class="d-flex justify-content-between mb-1">
                                            <div class="d-flex gap-2">
                                                <div class="tcPackageIcon tcPackageIcon1">
                                                    <i class="fa-solid fa-user-group fa-xl"></i>
                                                </div>
                                                <p class="mb-0 align-content-center fs-6 fw-bold">Added a new Neo Select Cusomer</p>
                                            </div>
                                            <p class="text-muted mb-0 align-content-center">10:30 AM</p>
                                        </div>
                                        <div class="d-flex justify-content-between mb-1">
                                            <div class="d-flex gap-2">
                                                <div class="tcPackageIcon tcPackageIcon1">
                                                    <i class="fa-solid fa-user-group fa-xl"></i>
                                                </div>
                                                <p class="mb-0 align-content-center fs-6 fw-bold">Customer Priya Dessai activated holiday account</p>
                                            </div>
                                            <p class="text-muted mb-0 align-content-center">09:45 AM</p>
                                        </div>
                                        <div class="d-flex justify-content-between mb-1">
                                            <div class="d-flex gap-2">
                                                <div class="tcPackageIcon tcPackageIcon1">
                                                    <i class="fa-solid fa-user-group fa-xl"></i>
                                                </div>
                                                <p class="mb-0 align-content-center fs-6 fw-bold">New booking from Rahul Kumar</p>
                                            </div>
                                            <p class="text-muted mb-0 align-content-center">Yesterday</p>
                                        </div>
                                        <div class="d-flex justify-content-between mb-1">
                                            <div class="d-flex gap-2">
                                                <div class="tcPackageIcon tcPackageIcon1">
                                                    <i class="fa-solid fa-user-group fa-xl"></i>
                                                </div>
                                                <p class="mb-0 align-content-center fs-6 fw-bold">Commission of &#8377;500 earned from activation</p>
                                            </div>
                                            <p class="text-muted mb-0 align-content-center">Yesterday</p>
                                        </div>
                                        <div class="d-flex justify-content-between mb-1">
                                            <div class="d-flex gap-2">
                                                <div class="tcPackageIcon tcPackageIcon1">
                                                    <i class="fa-solid fa-user-group fa-xl"></i>
                                                </div>
                                                <p class="mb-0 align-content-center fs-6 fw-bold">Follow up done with Anita Mehta</p>
                                            </div>
                                            <p class="text-muted mb-0 align-content-center">Yesterday</p>
                                        </div>
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
                                                    <h4>₹ 24,000</h4>
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
                                                <p class="mb-0 text-secondary ms-4">
                                                    ₹ 18,000 (75%)
                                                </p>
                                            </div>
                                            <div>
                                                <div class="d-flex align-items-center mb-2">
                                                    <span class="legend-dot bg-success"></span>
                                                    <span class="fw-semibold ms-2">From Trip Completed</span>
                                                </div>
                                                <p class="mb-0 text-secondary ms-4">
                                                    ₹ 6,000 (25%)
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
        <!-- <script src="../assets/libs/chart.js/Chart-2.5.0.min.js"></script> -->


        <!-- Dashboard init  popular candidates section js file-->
        <!-- <script src="../assets/js/pages/dashboard-job.init.js"></script> -->

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

            // Initial Load
            buildCarousel();

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
            var options = {
                series: [75, 25],
                chart: {
                    type: 'donut',
                    height: 200
                },
                colors: ['#3366F5', '#A8E6B8'],
                legend: {
                    show: false
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    width: 0
                },
                plotOptions: {
                    pie: {
                        donut: {
                            size: '75%'
                        }
                    }
                }
            };

            new ApexCharts(
                document.querySelector("#commissionChart"),
                options
            ).render();
        </script>
        <script>
            const ctx = document.getElementById('customerTrendChart');

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                    datasets: [{
                        data: [4, 8, 12, 15, 18, 22],
                        borderColor: '#3B82F6',
                        borderWidth: 3,
                        pointBackgroundColor: '#3B82F6',
                        pointBorderColor: '#3B82F6',
                        pointRadius: 4,
                        pointHoverRadius: 6,
                        fill: true,
                        tension: 0.4,
                        backgroundColor: (context) => {
                            const chart = context.chart;
                            const { ctx, chartArea } = chart;

                            if (!chartArea) return null;

                            const gradient = ctx.createLinearGradient(
                                0,
                                chartArea.top,
                                0,
                                chartArea.bottom
                            );

                            gradient.addColorStop(0, 'rgba(59,130,246,0.20)');
                            gradient.addColorStop(1, 'rgba(59,130,246,0.01)');

                            return gradient;
                        }
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,

                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            enabled: true
                        }
                    },

                    scales: {
                        x: {
                            grid: {
                                display: false
                            },
                            border: {
                                display: false
                            },
                            ticks: {
                                color: '#6B7280',
                                font: {
                                    weight: '600'
                                }
                            }
                        },

                        y: {
                            beginAtZero: true,
                            max: 40,
                            ticks: {
                                stepSize: 10,
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

                plugins: [{
                    id: 'valueLabels',
                    afterDatasetsDraw(chart) {
                        const { ctx } = chart;

                        chart.data.datasets.forEach((dataset, datasetIndex) => {
                            const meta = chart.getDatasetMeta(datasetIndex);

                            meta.data.forEach((point, index) => {
                                ctx.save();

                                ctx.fillStyle = '#3B82F6';
                                ctx.font = 'bold 14px Arial';
                                ctx.textAlign = 'center';

                                ctx.fillText(
                                    dataset.data[index],
                                    point.x,
                                    point.y - 12
                                );

                                ctx.restore();
                            });
                        });
                    }
                }]
            });
        </script>
    </body>
</html>