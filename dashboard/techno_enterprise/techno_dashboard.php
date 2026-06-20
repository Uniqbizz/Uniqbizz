<?php
    include_once '../dashboard_user_details.php';
?>
<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable">
    <head>
        <meta charset="utf-8" />
        <title>Techno Enterprisee Dashboard | Uniqbizz</title>
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
        <!-- Super Techno Enterprisee Dashboard CSS -->
        <link rel="stylesheet" href="../assets/css/techno_enterprise.css" />
        
        <!-- FontAwesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <!-- TE dashboard cards -->
        <style>
            .nav-pills .nav-link {
                border-radius: 50px;
                padding: 4px 12px !important;
                margin-right: 0px !important;
                background-color: #fff !important;
                color: #4b38b3 !important;
                border: 2px solid #4b38b3 !important;
                transition: 0.3s;
            }
 
            .nav-pills .nav-link.active {
                background-color: #4b38b3 !important;
                color: #fff !important;
                border: 2px solid #4b38b3 !important;
            }
            .cardDisplay {
                display: flex;
                justify-content: space-between;
            }
            .iconTE {
                background-color: #ffc8c8;
                color: #d60c0c;
                border-radius: 8px;
                padding: 8px 10px;
                align-content: center;
            }
            @media (max-width: 1170px) {
                .cardDisplay {
                    display: block;
                    justify-content: space-between;
                }
            }
            @media (max-width: 1024px) {
                .cardDisplay {
                    display: flex !important;
                    justify-content: space-between;
                }
            }
            @media (max-width: 992px) {
                .cardDisplay {
                    display: block !important;
                    justify-content: space-between;
                }
            }
            @media (max-width: 767px) {
                .cardDisplay {
                    display: flex !important;
                    justify-content: space-between;
                }
            }
            @media (max-width: 598px) {
                .cardDisplay {
                    display: block !important;
                    justify-content: space-between;
                }
            }
        </style>
    </head>
    <body class="twocolumn-panel">
        <!-- Begin page -->
        <div id="layout-wrapper">
            <?php include_once "techno_header.php" ?>

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

            <?php include_once "techno_sidebar.php" ?>
            <!-- ============================================================== -->
            <!-- Start of Super Techno Enterprisee Dashboard here -->
            <!-- ============================================================== -->
            <div class="main-content">
                <div class="page-content">
                    <div class="container-fluid ps-0">
                        <!-- Super Techno Enterprisee Dashboard Greeting Card -->
                        <div class="card border rounded-4 shadow-sm overflow-hidden">
                            <div class="greetingImageWrapper">
                                <img src="../assets/images/superTechnoImage.png" alt="Package" class="greetingImage img-fluid w-100">
                            </div>
                            <div class="greetingCard">
                                <p class="fw-bold text-dark gap-3 fs-4">Welcome Back,<span class="" id="userName"></span>! &#128075;</p>
                                <h1 class="fw-bold text-dark gap-3">Techno Enterprise</h1>
                                <p class="text-dark fs-4 mb-0">You're building something great.</p>
                                <p class="text-dark fs-4">Here's your business overview.</p>
                            </div>
                        </div>
                        <!-- Card section 2 -->
                        <div class="row">
                            <div class="col-lg-3 col-md-3 col-sm-6 col-12">
                                <div class="card rounded-4 p-3 stCard2">
                                    <div class="d-flex gap-3">
                                        <div class="stIcon stIcon2">
                                            <i class="fa-solid fa-user-group fa-xl"></i>
                                        </div>
                                        <div class="">
                                            <p class="mb-1 fs-6 fw-bold">Travel Consultants</p>
                                            <h4 class="fw-bolder text-dark mb-1" id="tcCount">0</h4>
                                            <a href="travel_consultants_list.php" class="mb-1 fs-6 fw-bold">View All <i class="fa-solid fa-arrow-right"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-6 col-12">
                                <div class="card rounded-4 p-3 stCard3">
                                    <div class="d-flex gap-3">
                                        <div class="stIcon stIcon3">
                                            <i class="fa-solid fa-user-group fa-xl"></i>
                                        </div>
                                        <div class="">
                                            <p class="mb-1 fs-6 fw-bold">Customers</p>
                                            <h4 class="fw-bolder text-dark mb-1" id="cuCount">0</h4>
                                            <a href="customers_list.php" class="mb-1 fs-6 fw-bold">View All <i class="fa-solid fa-arrow-right"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-6 col-12">
                                <div class="card rounded-4 p-3 stCard4">
                                    <div class="d-flex gap-3">
                                        <div class="stIcon stIcon4">
                                            <i class="fa-solid fa-wallet fa-xl"></i>
                                        </div>
                                        <div class="">
                                            <p class="mb-1 fs-6 fw-bold">Total Revenue</p>
                                            <h4 class="fw-bolder text-dark mb-1" id="total_revenue">&#8377; 2,00,00,000</h4>
                                            <a href="product_payout.php" class="mb-1 fs-6 fw-bold">View All <i class="fa-solid fa-arrow-right"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-6 col-12">
                                <div class="card rounded-4 p-3 stCard4">
                                    <div class="d-flex gap-3">
                                        <div class="stIcon stIcon4">
                                            <i class="fa-solid fa-wallet fa-xl"></i>
                                        </div>
                                        <div class="">
                                            <p class="mb-1 fs-6 fw-bold">Total Commission</p>
                                            <h4 class="fw-bolder text-dark mb-1" id="total_com">&#8377; 0</h4>
                                            <a href="holiday_payout.php" class="mb-1 fs-6 fw-bold">View All <i class="fa-solid fa-arrow-right"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Card section 3 -->
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-12 col-12 mb-2">
                                <div class="commission-card px-2">
                                    <div class="commission-title">
                                        Commission Earned This Month
                                    </div>
                                    <div class="commission-wrapper gap-2">
                                        <div class="chart-container">
                                            <canvas id="commissionChart"></canvas>
                                            <div class="center-text">
                                                <p>Total Earnings</p>
                                                <h2 id="paidEarnings">&#8377; 0</h2>
                                            </div>
                                        </div>
                                        <div class="legend-section-details">
                                            <div class="legend-section">
                                                <div class="legend-item">
                                                    <div class="legend-left">
                                                        <span class="dot" style="background:#2563EB"></span>
                                                        <span>Neo Select Commission</span>
                                                    </div>
                                                    <div class="amount" id="neoAmount"> &#8377; 0</div>
                                                    <div class="percent" id="neoPercent">0%</div>
                                                </div>
                                                <div class="legend-item">
                                                    <div class="legend-left">
                                                        <span class="dot" style="background:#00C46A"></span>
                                                        <span>Booking Commission</span>
                                                    </div>
                                                    <div class="amount" id="bookingAmount"> &#8377; 0</div>
                                                    <div class="percent" id="bookingPercent">0%</div>
                                                </div>
                                                <!-- <div class="report-link">
                                                    <a href="#">
                                                        View Commission Report →
                                                    </a>
                                                </div> -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-12 mb-2">
                                <div class="commission-card px-2">
                                    <div class="commission-title">
                                        My Wallet
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6 col-md-12 col-sm-6 col-12">
                                            <div class="card rounded-4 p-3 stWalletCard1">
                                                <div class="d-flex justify-content-between">
                                                    <div class="">
                                                        <p class="mb-1 fs-6 fw-bold">Paid Payout</p>
                                                        <h4 class="fw-bolder text-dark mb-1" id="total_paid_earning">&#8377; 0</h4>
                                                    </div>
                                                    <div class="stWalletIcon1">
                                                        <i class="fa-solid fa-wallet"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-12 col-sm-6 col-12">
                                            <div class="card rounded-4 p-3 stWalletCard2">
                                                <div class="d-flex justify-content-between">
                                                    <div class="">
                                                        <p class="mb-1 fs-6 fw-bold">Pending Payout</p>
                                                        <h4 class="fw-bolder text-dark mb-1" id="total_pending_earning">&#8377; 0</h4>
                                                    </div>
                                                    <div class="stWalletIcon2">
                                                        <i class="fa-regular fa-hourglass"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- <div class="row d-flex justify-content-center">
                                        <div class="col-lg-5">
                                            <a href="#">
                                                <div class="stWalletBtn">
                                                    <p class="fs-5 mb-0 fw-bolder">Withdraw <i class="fa-solid fa-arrow-right"></i></p>
                                                </div>
                                            </a>
                                        </div>
                                    </div> -->
                                </div>
                            </div>
                        </div>
                        <!-- Card section 4 -->
                        <div class="row mt-3">
                            <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                                <div class="cardChart card border-1">
                                    <div class="card-title d-flex justify-content-between p-2">
                                        <p class="commission-title fs-5">Customer Count (Yearly)</p>
                                        <p class="">
                                            <select class="form-select yearSelect py-1" id="yearFilter">
                                                
                                            </select>
                                        </p>
                                    </div>
                                    <div class="card-body">
                                        <canvas id="customerTrendChart"></canvas>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                                <div class="cardChart card border-1">
                                    <div class="card-title d-flex justify-content-between p-2">
                                        <p class="commission-title fs-5">TC Enrollment Count (Yearly)</p>
                                        <p class="">
                                            <select class="form-select yearSelect py-1" id="enrollmentYearFilter">
                                            </select>
                                        </p>
                                    </div>
                                    <div class="card-body">
                                        <canvas id="enrollmentTrendChart"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Card section 5 -->
                        <!-- TE Dashborad Cards -->
                        <div class="row mt-3">
                            <div class="col-lg-8 col-md-6 col-sm-12 col-12">
                                <div class="card rounded-4 border-1 p-3">
                                    <div class="card-title cardDisplay">
                                        <p class="commission-title fs-5 mb-1">
                                            Team Performance <br>(On Holiday Account Activation)
                                        </p>
                                        <ul class="nav nav-pills mb-3 gap-1" id="pills-tab" role="tablist">
                                            <li class="nav-item m-0">
                                                <button class="nav-link active" data-bs-toggle="pill"
                                                    data-bs-target="#today">Today</button>
                                            </li>
                                            <li class="nav-item m-0">
                                                <button class="nav-link" data-bs-toggle="pill"
                                                    data-bs-target="#week">Week</button>
                                            </li>
                                            <li class="nav-item m-0">
                                                <button class="nav-link" data-bs-toggle="pill"
                                                    data-bs-target="#month">Month</button>
                                            </li>
                                            <li class="nav-item m-0">
                                                <button class="nav-link" data-bs-toggle="pill"
                                                    data-bs-target="#year">Year</button>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="cardDetails">
                                        <table class="table">
                                            <thead>
                                                <tr class="table-active">
                                                    <th scope="col">TC Code & Travel Consultant</th>
                                                    <th scope="col">Neo Select Members</th>
                                                    <th scope="col">Revenue (&#8377;)</th>
                                                    <th scope="col">Earnings (&#8377;)</th>
                                                </tr>
                                            </thead>
                                            <tbody id="#">
                                                <tr class="">
                                                    <td>
                                                        <p class="mb-0">TC001</p>
                                                        <p class="mb-0">Rohit Sharma</p>
                                                    </td>
                                                    <td>
                                                        <p class="mb-0 text-center">22</p>
                                                    </td>
                                                    <td>
                                                        <p class="mb-0 text-center">55,000</p>
                                                    </td>
                                                    <td>
                                                        <p class="mb-0 text-center">11,000</p>
                                                    </td>
                                                </tr>
                                                <tr class="">
                                                    <td>
                                                        <p class="mb-0">TC001</p>
                                                        <p class="mb-0">Rohit Sharma</p>
                                                    </td>
                                                    <td>
                                                        <p class="mb-0 text-center">22</p>
                                                    </td>
                                                    <td>
                                                        <p class="mb-0 text-center">55,000</p>
                                                    </td>
                                                    <td>
                                                        <p class="mb-0 text-center">11,000</p>
                                                    </td>
                                                </tr>
                                                <tr class="">
                                                    <td>
                                                        <p class="mb-0">TC001</p>
                                                        <p class="mb-0">Rohit Sharma</p>
                                                    </td>
                                                    <td>
                                                        <p class="mb-0 text-center">22</p>
                                                    </td>
                                                    <td>
                                                        <p class="mb-0 text-center">55,000</p>
                                                    </td>
                                                    <td>
                                                        <p class="mb-0 text-center">11,000</p>
                                                    </td>
                                                </tr>
                                                <tr class="">
                                                    <td>
                                                        <p class="mb-0">TC001</p>
                                                        <p class="mb-0">Rohit Sharma</p>
                                                    </td>
                                                    <td>
                                                        <p class="mb-0 text-center">22</p>
                                                    </td>
                                                    <td>
                                                        <p class="mb-0 text-center">55,000</p>
                                                    </td>
                                                    <td>
                                                        <p class="mb-0 text-center">11,000</p>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6 col-sm-12 col-12">
                                <div class="card rounded-4 border-1 p-3">
                                    <div class="card-title cardDisplay">
                                        <p class="commission-title fs-5 mb-1">
                                            Consultants Need Attention
                                        </p>
                                    </div>
                                    <div class="d-flex gap-2 mt-2">
                                        <div class="iconTE">
                                            <i class="fa-solid fa-tree fa-xl"></i>
                                        </div>
                                        <div>
                                            <p class="fs-5 mb-0 fw-bold">TC014</p>
                                            <p class="fs-6 mb-0">No Neo Select in last 15 days</p>
                                        </div>
                                    </div>
                                    <div class="d-flex gap-2 mt-2">
                                        <div class="iconTE">
                                            <i class="fa-solid fa-tree fa-xl"></i>
                                        </div>
                                        <div>
                                            <p class="fs-5 mb-0 fw-bold">TC014</p>
                                            <p class="fs-6 mb-0">No Neo Select in last 15 days</p>
                                        </div>
                                    </div>
                                    <div class="d-flex gap-2 mt-2">
                                        <div class="iconTE">
                                            <i class="fa-solid fa-tree fa-xl"></i>
                                        </div>
                                        <div>
                                            <p class="fs-5 mb-0 fw-bold">TC014</p>
                                            <p class="fs-6 mb-0">No Neo Select in last 15 days</p>
                                        </div>
                                    </div>
                                    <div class="d-flex gap-2 mt-2">
                                        <div class="iconTE">
                                            <i class="fa-solid fa-tree fa-xl"></i>
                                        </div>
                                        <div>
                                            <p class="fs-5 mb-0 fw-bold">TC014</p>
                                            <p class="fs-6 mb-0">No Neo Select in last 15 days</p>
                                        </div>
                                    </div>
                                    <div class="d-flex gap-2 mt-2">
                                        <div class="iconTE">
                                            <i class="fa-solid fa-tree fa-xl"></i>
                                        </div>
                                        <div>
                                            <p class="fs-5 mb-0 fw-bold">TC014</p>
                                            <p class="fs-6 mb-0">No Neo Select in last 15 days</p>
                                        </div>
                                    </div>
                                    <div class="d-flex gap-2 mt-2">
                                        <div class="iconTE">
                                            <i class="fa-solid fa-tree fa-xl"></i>
                                        </div>
                                        <div>
                                            <p class="fs-5 mb-0 fw-bold">TC014</p>
                                            <p class="fs-6 mb-0">No Neo Select in last 15 days</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="card rounded-4 border-1 p-3">
                                    <div class="card-title cardDisplay">
                                        <p class="commission-title fs-5 mb-1">
                                            Team Performance <br>(On Holiday Account Activation)
                                        </p>
                                        <ul class="nav nav-pills mb-3 gap-1" id="pills-tab" role="tablist">
                                            <li class="nav-item m-0">
                                                <button class="nav-link active" data-bs-toggle="pill"
                                                    data-bs-target="#today">Today</button>
                                            </li>
                                            <li class="nav-item m-0">
                                                <button class="nav-link" data-bs-toggle="pill"
                                                    data-bs-target="#week">Week</button>
                                            </li>
                                            <li class="nav-item m-0">
                                                <button class="nav-link" data-bs-toggle="pill"
                                                    data-bs-target="#month">Month</button>
                                            </li>
                                            <li class="nav-item m-0">
                                                <button class="nav-link" data-bs-toggle="pill"
                                                    data-bs-target="#year">Year</button>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="cardDetails">
                                        <table class="table">
                                            <thead>
                                                <tr class="table-active">
                                                    <th scope="col">TC Code & Travel Consultant</th>
                                                    <th scope="col">Neo Select Members</th>
                                                    <th scope="col">Revenue (&#8377;)</th>
                                                    <th scope="col">Earnings (&#8377;)</th>
                                                    <th scope="col">Target Achievement</th>
                                                    <th scope="col">Performance</th>
                                                </tr>
                                            </thead>
                                            <tbody id="#">
                                                <tr class="">
                                                    <td>
                                                        <p class="mb-0">TC001</p>
                                                        <p class="mb-0">Rohit Sharma</p>
                                                    </td>
                                                    <td>
                                                        <p class="mb-0 text-center">22</p>
                                                    </td>
                                                    <td>
                                                        <p class="mb-0 text-center">55,000</p>
                                                    </td>
                                                    <td>
                                                        <p class="mb-0 text-center">11,000</p>
                                                    </td>
                                                    <td>
                                                        <p class="mb-0 text-center text-success fw-bold">110%</p>
                                                        <div class="progress" role="progressbar" aria-label="Success example" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">
                                                            <div class="progress-bar bg-success" style="width: 100%"></div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="p-1 text-success-emphasis bg-success-subtle border border-success-subtle rounded-3 fw-bold text-center">
                                                            Star Performer
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr class="">
                                                    <td>
                                                        <p class="mb-0">TC001</p>
                                                        <p class="mb-0">Rohit Sharma</p>
                                                    </td>
                                                    <td>
                                                        <p class="mb-0 text-center">22</p>
                                                    </td>
                                                    <td>
                                                        <p class="mb-0 text-center">55,000</p>
                                                    </td>
                                                    <td>
                                                        <p class="mb-0 text-center">11,000</p>
                                                    </td>
                                                    <td>
                                                        <p class="mb-0 text-center text-success fw-bold">95%</p>
                                                        <div class="progress" role="progressbar" aria-label="Success example" aria-valuenow="95" aria-valuemin="0" aria-valuemax="100">
                                                            <div class="progress-bar bg-success" style="width: 95%"></div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="p-1 text-success-emphasis bg-success-subtle border border-success-subtle rounded-3 fw-bold text-center">
                                                            Good
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr class="">
                                                    <td>
                                                        <p class="mb-0">TC001</p>
                                                        <p class="mb-0">Rohit Sharma</p>
                                                    </td>
                                                    <td>
                                                        <p class="mb-0 text-center">22</p>
                                                    </td>
                                                    <td>
                                                        <p class="mb-0 text-center">55,000</p>
                                                    </td>
                                                    <td>
                                                        <p class="mb-0 text-center">11,000</p>
                                                    </td>
                                                    <td>
                                                        <p class="mb-0 text-center text-warning fw-bold">70%</p>
                                                        <div class="progress" role="progressbar" aria-label="Success example" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100">
                                                            <div class="progress-bar bg-warning" style="width: 70%"></div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="p-1 text-warning-emphasis bg-warning-subtle border border-warning-subtle rounded-3 fw-bold text-center">
                                                            Average
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr class="">
                                                    <td>
                                                        <p class="mb-0">TC001</p>
                                                        <p class="mb-0">Rohit Sharma</p>
                                                    </td>
                                                    <td>
                                                        <p class="mb-0 text-center">22</p>
                                                    </td>
                                                    <td>
                                                        <p class="mb-0 text-center">55,000</p>
                                                    </td>
                                                    <td>
                                                        <p class="mb-0 text-center">11,000</p>
                                                    </td>
                                                    <td>
                                                        <p class="mb-0 text-center text-danger fw-bold">25%</p>
                                                        <div class="progress" role="progressbar" aria-label="Success example" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                                                            <div class="progress-bar bg-danger" style="width: 25%"></div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="p-1 text-danger-emphasis bg-danger-subtle border border-danger-subtle rounded-3 fw-bold text-center">
                                                            Need Support
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
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
                <?php include_once "techno_footer.php" ?>
            </div>

            <!-- end main content-->
            <!-- End of Super Techno Enterprisee Dashboard here -->
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
        <!-- dialer logic -->
        
        <script>
            
            let commissionChart = null;
            let customerTrendChart;

            function initializeCustomerTrendChart() {

                const months = [
                    'Jan','Feb','Mar','Apr','May','Jun',
                    'Jul','Aug','Sep','Oct','Nov','Dec'
                ];

                customerTrendChart = new Chart(
                    document.getElementById('customerTrendChart'),
                    {
                        type: 'line',
                        data: {
                            labels: months,
                            datasets: [{
                                label: 'Customers',
                                data: Array(12).fill(0),
                                borderColor: '#2F6BFF',
                                backgroundColor: function(context) {

                                    const chart = context.chart;
                                    const ctx = chart.ctx;
                                    const chartArea = chart.chartArea;

                                    if (!chartArea) {
                                        return null;
                                    }

                                    const gradient = ctx.createLinearGradient(
                                        0,
                                        chartArea.top,
                                        0,
                                        chartArea.bottom
                                    );

                                    gradient.addColorStop(
                                        0,
                                        'rgba(47,107,255,0.30)'
                                    );

                                    gradient.addColorStop(
                                        1,
                                        'rgba(47,107,255,0.02)'
                                    );

                                    return gradient;
                                },
                                fill: true,
                                tension: 0.4,
                                pointRadius: 4,
                                pointHoverRadius: 6,
                                pointBackgroundColor: '#2F6BFF'
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
                                    grid: {
                                        color: '#edf1f7'
                                    }
                                }
                            }
                        }
                    }
                );

            }
            let yearsLoaded = false;

            function loadCustomerTrendChart(year = '') {

                $.ajax({
                    url: 'models/dashboard/ste_cust_line_chart_data.php',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        year: year
                    },
                    success: function(res) {

                        if (!res.status) {
                            return;
                        }

                        /*
                        |--------------------------------------------------------------------------
                        | Load Years Only Once
                        |--------------------------------------------------------------------------
                        */

                        if (!yearsLoaded) {

                            let options = '';

                            $.each(res.data.years, function(i, year) {

                                options += `
                                    <option value="${year}">
                                        ${year}
                                    </option>
                                `;

                            });

                            $('#yearFilter').html(options);

                            $('#yearFilter').val(
                                res.data.selected_year
                            );

                            yearsLoaded = true;
                        }

                        /*
                        |--------------------------------------------------------------------------
                        | Chart Data
                        |--------------------------------------------------------------------------
                        */

                        let chartData = Array(12).fill(0);

                        $.each(res.data.customer_trend, function(index, item) {

                            let monthIndex = parseInt(item.month) - 1;

                            chartData[monthIndex] = parseInt(item.total) || 0;

                        });

                        customerTrendChart.data.datasets[0].data =
                            chartData;

                        customerTrendChart.update();

                    }
                });

            }
            function initializeChart() {

                const canvas = document.getElementById('commissionChart');

                if (!canvas) {
                    return;
                }

                const ctx = canvas.getContext('2d');

                // Destroy existing chart if any
                if (commissionChart) {
                    commissionChart.destroy();
                }

                commissionChart = new Chart(ctx, {
                    type: 'doughnut',
                    data: {
                        labels: [
                            'Neo Select Commission',
                            'Booking Commission'
                        ],
                        datasets: [{
                            data: [1],
                            backgroundColor: ['#E5E7EB'],
                            borderWidth: 3,
                            borderColor: '#fff'
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        cutout: '70%',
                        plugins: {
                            legend: {
                                display: false
                            }
                        }
                    }
                });
            }

            function loadData() {

                /*
                |--------------------------------------------------------------------------
                | User & Dashboard Counts
                |--------------------------------------------------------------------------
                */

                $.when(

                    $.ajax({
                        url: 'models/dashboard/ste_model.php',
                        type: 'POST',
                        dataType: 'json'
                    }),

                    $.ajax({
                        url: 'models/dashboard/ste_dash_card_data.php',
                        type: 'POST',
                        dataType: 'json'
                    })

                ).done(function (userRes, dashRes) {

                    const user = userRes[0];
                    const dash = dashRes[0];

                    if (user.status && user.data) {

                        $('#userName').text(
                            (user.data.firstname || '') +
                            ' ' +
                            (user.data.lastname || '')
                        );

                    }

                    if (dash.status && dash.data) {

                        $('#teCount').text(dash.data.te_count || 0);
                        $('#tcCount').text(dash.data.tc_count || 0);
                        $('#cuCount').text(dash.data.cu_count || 0);
                        $('#total_revenue').text('\u20B9' + (dash.data.all_revenue || 0));
                        $('#total_com').text('\u20B9' + (dash.data.all_earning || 0));
                        $('#total_paid_earning').text('\u20B9' + (dash.data.all_paid_earning || 0));
                        $('#total_pending_earning').text('\u20B9' + (dash.data.all_pending_earning || 0));

                    }

                }).fail(function (xhr, status, error) {

                    console.error('Dashboard Error:', error);

                });


                /*
                |--------------------------------------------------------------------------
                | Commission Chart Data
                |--------------------------------------------------------------------------
                */

                $.ajax({
                    url: 'models/dashboard/ste_com_piechart_data.php',
                    type: 'POST',
                    dataType: 'json',

                    success: function (res) {

                        if (!res.status || !res.data) {
                            return;
                        }

                        const neoAmount =
                            Number(res.data.neo_select?.amount || 0);

                        const bookingAmount =
                            Number(res.data.booking?.amount || 0);

                        const totalEarnings =
                            Number(res.data.total_earnings || 0);


                        /*
                        |--------------------------------------------------------------------------
                        | Amounts
                        |--------------------------------------------------------------------------
                        */

                        $('#neoAmount').text(
                            '\u20B9' + neoAmount.toLocaleString('en-IN')
                        );

                        $('#bookingAmount').text(
                            '\u20B9' + bookingAmount.toLocaleString('en-IN')
                        );

                        $('#paidEarnings').text(
                            '\u20B9' + totalEarnings.toLocaleString('en-IN')
                        );


                        /*
                        |--------------------------------------------------------------------------
                        | Percentages
                        |--------------------------------------------------------------------------
                        */

                        const neoPercent =
                            Number(res.data.neo_select?.percentage || 0);

                        const bookingPercent =
                            Number(res.data.booking?.percentage || 0);


                        $('#neoPercent').text(
                            neoPercent.toFixed(1) + '%'
                        );

                        $('#bookingPercent').text(
                            bookingPercent.toFixed(1) + '%'
                        );


                        /*
                        |--------------------------------------------------------------------------
                        | Growth Percentage (Optional)
                        |--------------------------------------------------------------------------
                        */

                        if ($('#growthPercentage').length) {

                            const growth =
                                Number(
                                    res.data.month_comparison?.growth_percentage || 0
                                );

                            $('#growthPercentage').text(
                                growth.toFixed(1) + '%'
                            );

                        }


                        /*
                        |--------------------------------------------------------------------------
                        | Center Text
                        |--------------------------------------------------------------------------
                        */

                        if (totalEarnings <= 0) {
                            $('.center-text p').text('No Earnings Yet');
                        } else {
                            $('.center-text p').text('Total Earnings');
                        }


                        /*
                        |--------------------------------------------------------------------------
                        | Update Doughnut Chart
                        |--------------------------------------------------------------------------
                        */

                        if (commissionChart) {

                            const chartTotal =
                                neoPercent +
                                bookingPercent;

                            if (chartTotal <= 0) {

                                commissionChart.data.datasets[0].data = [1];

                                commissionChart.data.datasets[0].backgroundColor = [
                                    '#E5E7EB'
                                ];

                            } else {

                                commissionChart.data.datasets[0].data = [
                                    neoPercent,
                                    bookingPercent
                                ];

                                commissionChart.data.datasets[0].backgroundColor = [
                                    '#2563EB',
                                    '#00C46A'
                                ];

                            }

                            commissionChart.update();

                        }

                    },

                    error: function (xhr, status, error) {

                        console.error(
                            'Commission Chart Error:',
                            error
                        );

                    }

                });

            }

            let enrollmentTrendChart;
            let enrollmentYearsLoaded = false;

            function initializeEnrollmentTrendChart() {

                const months = [
                    'Jan','Feb','Mar','Apr','May','Jun',
                    'Jul','Aug','Sep','Oct','Nov','Dec'
                ];

                const ctx = document.getElementById('enrollmentTrendChart');

                enrollmentTrendChart = new Chart(ctx, {

                    type: 'line',

                    data: {

                        labels: months,

                        datasets: [

                                {
                                    label: 'Tc',
                                    data: Array(12).fill(0),
                                    borderColor: '#1DB56C',
                                    backgroundColor: '#1DB56C',
                                    backgroundColor: function(context) {

                                        const chart = context.chart;
                                        const ctx = chart.ctx;
                                        const chartArea = chart.chartArea;

                                        if (!chartArea) {
                                            return null;
                                        }

                                        const gradient = ctx.createLinearGradient(
                                            0,
                                            chartArea.top,
                                            0,
                                            chartArea.bottom
                                        );

                                        gradient.addColorStop(
                                            0,
                                            'rgba(47, 255, 64, 0.3)'
                                        );

                                        gradient.addColorStop(
                                            1,
                                            'rgba(47, 255, 71, 0.02)'
                                        );

                                        return gradient;
                                    },
                                    fill: true,
                                    tension: 0.4,
                                    pointRadius: 4,
                                    pointHoverRadius: 6,
                                    pointBackgroundColor: '#1DB56C'
                                }

                            ]
                    },

                    options: {

                        responsive: true,
                        maintainAspectRatio: false,

                        plugins: {
                            legend: {
                                display: true
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
                                grid: {
                                    color: '#edf1f7'
                                }
                            }

                        }

                    }

                });
            }
            function loadEnrollmentTrendChart(year = '') {

                $.ajax({

                    url: 'models/dashboard/ste_te_line_chart_data.php',

                    type: 'POST',

                    dataType: 'json',

                    data: {
                        year: year
                    },

                    success: function(res) {

                        if (!res.status) {
                            return;
                        }

                        /*
                        |--------------------------------------------------------------------------
                        | Populate Year Dropdown
                        |--------------------------------------------------------------------------
                        */

                        if (!enrollmentYearsLoaded) {

                            let options = '';

                            $.each(res.data.years, function(i, year) {

                                options += `
                                    <option value="${year}">
                                        ${year}
                                    </option>
                                `;

                            });

                            $('#enrollmentYearFilter')
                                .html(options)
                                .val(res.data.selected_year);

                            enrollmentYearsLoaded = true;
                        }

                        /*
                        |--------------------------------------------------------------------------
                        | TC Data
                        |--------------------------------------------------------------------------
                        */

                        let tcData = Array(12).fill(0);

                        $.each(res.data.tc_trend, function(i, row) {

                            let monthIndex =
                                parseInt(row.month_no) - 1;

                            tcData[monthIndex] =
                                parseInt(row.tc_count) || 0;

                        });

                        

                        /*
                        |--------------------------------------------------------------------------
                        | Update Chart
                        |--------------------------------------------------------------------------
                        */

                        enrollmentTrendChart.data.datasets[0].data = tcData;

                        enrollmentTrendChart.update();

                    },

                    error: function(xhr, status, error) {

                        console.error('Chart Load Error:', error);
                        console.log(xhr.responseText);

                    }

                });

            }
            
            $(document).on(
                'change',
                '#enrollmentYearFilter',
                function() {

                    loadEnrollmentTrendChart(
                        $(this).val()
                    );

                }
            );
            $(document).on(
                'change',
                '#yearFilter',
                function() {

                    loadCustomerTrendChart(
                        $(this).val()
                    );

                }
            );
            $(document).ready(function() {

                initializeChart();

                initializeCustomerTrendChart();

                loadData();

                loadCustomerTrendChart();
                
                initializeEnrollmentTrendChart();

                loadEnrollmentTrendChart();

            });
        </script>
        <!-- TE dashboard card -->
        <script>
            document.querySelectorAll('#filterNav .nav-link').forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
 
                    // Remove active class from all links
                    document.querySelectorAll('#filterNav .nav-link').forEach(item => {
                        item.classList.remove('active');
                    });
 
                    // Add active class to clicked link
                    this.classList.add('active');
 
                    // Example: Update heading/content
                    document.getElementById('selectedPeriod').textContent =
                        this.textContent + ' Data';
                });
            });
        </script>
    </body>
</html>