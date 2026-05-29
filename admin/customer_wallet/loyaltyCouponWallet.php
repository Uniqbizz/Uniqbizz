<?php
    session_start();
    if(!isset($_SESSION['username'])){
        echo '<script>location.href = "../login.php";</script>';
    }
    require '../connect.php';
    $date = date('Y'); 
?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Loyalty Coupon Wallet | Admin Dashboard </title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- App favicon -->
        <link rel="shortcut icon" href="../assets/images/fav.png">
        <!-- bootstrap-datepicker css -->
        <link href="../assets/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css">
        <!-- DataTables -->
        <link href="../assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
        <!-- Responsive datatable examples -->
        <link href="../assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />  
        <!-- Bootstrap Css -->
        <link href="../assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
        <!-- Icons Css -->
        <link href="../assets/css/icons.min.css" rel="stylesheet" type="text/css" />
        <!-- App Css-->
        <link href="../assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />
        <!-- Loading Screen and Images size css  -->
        <link rel="stylesheet" href="../assets/css/loadingScreen.css" rel="stylesheet" type="text/css" />
        <!-- App js -->
        <!-- <script src="../assets/js/plugin.js"></script> -->

        <!-- Font awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <style>
            .fontSize1 {
                font-size: 12px;
            }
            .fontSize2 {
                font-size: 10px;
            }
            .fontSize3 {
                font-size: 8px;
            }
            .icon1 {
                font-size: 20px !important;
                color: #fff;
                background: #35239a;
                border-radius: 100%;
                padding: 8px 10px;
                width: 45px;
                height: 45px;
                display: flex;
                justify-content: center;
                align-items: center;
            }
            .icon2 {
                font-size: 20px !important;
                color: #fff;
                background: #067b40;
                border-radius: 100%;
                padding: 8px 10px;
                width: 45px;
                height: 45px;
                display: flex;
                justify-content: center;
                align-items: center;
            }
            .icon3 {
                font-size: 20px !important;
                color: #fff;
                background: #fbaa06;
                border-radius: 100%;
                padding: 8px 10px;
                width: 45px;
                height: 45px;
                display: flex;
                justify-content: center;
                align-items: center;
            }
            .icon4 {
                font-size: 20px !important;
                color: #fff;
                background: #136bd8;
                border-radius: 100%;
                padding: 8px 10px;
                width: 45px;
                height: 45px;
                display: flex;
                justify-content: center;
                align-items: center;
            }
            .icon5 {
                font-size: 20px !important;
                color: #fff;
                background: #fb2306;
                border-radius: 100%;
                padding: 8px 10px;
                width: 45px;
                height: 45px;
                display: flex;
                justify-content: center;
                align-items: center;
            }
            .icon6 {
                font-size: 20px !important;
                color: #fff;
                background: #d1690e;
                border-radius: 100%;
                padding: 8px 10px;
                width: 45px;
                height: 45px;
                display: flex;
                justify-content: center;
                align-items: center;
            }
            .walletIcon1 {
                background: #f4f2ff;
                border: 1px solid #35239a;
            }
            .walletCase1 {
                position: absolute;
                right: 10px;
                bottom: 10px;
                font-size: 100px;
                color: #5b5ff6;
                opacity: 0.15;
                z-index: 1;
                pointer-events: none;
            }
            .walletIcon2 {
                background: #ecfff7;
                border: 1px solid #067b40;
            }
            .walletCase2 {
                position: absolute;
                right: 10px;
                bottom: 10px;
                font-size: 100px;
                color: #067b40;
                opacity: 0.15;
                z-index: 1;
                pointer-events: none;
            }
            .walletIcon3 {
                background: #fffcf4;
                border: 1px solid #fbaa06;
            }
            .walletCase3 {
                position: absolute;
                right: 10px;
                bottom: 10px;
                font-size: 100px;
                color: #fbaa06;
                opacity: 0.15;
                z-index: 1;
                pointer-events: none;
            }
            .walletIcon4 {
                background: #eef3f9;
                border: 1px solid #136bd8;
            }
            .walletCase4 {
                position: absolute;
                right: 10px;
                bottom: 10px;
                font-size: 100px;
                color: #136bd8;
                opacity: 0.15;
                z-index: 1;
                pointer-events: none;
            }
            .walletIcon5 {
                background: #fff1ef;
                border: 1px solid #fb2306;
            }
            .walletCase5 {
                position: absolute;
                right: 10px;
                bottom: 10px;
                font-size: 100px;
                color: #fb2306;
                opacity: 0.15;
                z-index: 1;
                pointer-events: none;
            }
            .walletIcon6 {
                background: #f9ede3;
                border: 1px solid #d1690e;
            }
            .walletCase6 {
                position: absolute;
                right: 10px;
                bottom: 10px;
                font-size: 100px;
                color: #d1690e;
                opacity: 0.15;
                z-index: 1;
                pointer-events: none;
            }
            .profileImage {
                width:40px !important;
                height: 40px !important;
                border-radius: 100% !important;
                object-fit: fill;
            }
            .textOrange {
                color: #d54a0a;
            }
            .textViolet {
                color: #35239a;
            }
            .linkBtn {
                background-color: #fff;
                color:#4b38b3;
                border: 2px solid #4b38b3;
                padding: 6px 12px;
                border-radius: 6px;
                display: flex;
                justify-content: center;
            }
            .linkBtn:hover {
                background-color: #4b38b3;
                border: 2px solid #4b38b3;
                color:#fff;
                padding: 6px 12px;
                border-radius: 6px;
                display: flex;
                justify-content: center;
            }
        </style>
    </head>
    <body data-sidebar="dark">
    <!-- <body data-layout="horizontal" data-topbar="dark"> -->
        <!-- Begin page -->
        <div id="layout-wrapper">
            <?php 
                // top header logo, hamberger menu, fullscreen icon, profile
                include_once '../header.php';

                // sidebar navigation menu 
                include_once '../sidebar.php';
            ?>
            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->
            <div class="main-content">
                <div class="page-content">
                    <div class="container-fluid">
                        <div class="">
                            <h2 class="fw-bolder text-dark">Loyalty Coupon Wallet</h2>
                            <p class="fs-6 text-muted">
                                Loyalty coupons are earned after a successful trip. Each coupon is worth &#8377;500 and valid for 12 months. Coupons are unclocked only after all membership coupons are used.
                            </p>
                        </div>
                        <div class="row">
                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12">
                                <div class="rounded-4 p-3 card walletIcon1">
                                    <!-- Background Icon -->
                                    <i class="fa-solid fa-gift walletCase1"></i>
                                    <div class="d-flex gap-2">
                                        <div class="icon1">
                                            <i class="fa-solid fa-gift"></i>
                                        </div>
                                        <div class="">
                                            <h1 class="fs-6 fw-bolder">Total Loyalty Coupons Issued</h1>
                                            <p class="fs-5 fw-bolder mb-0">15,230</p>
                                            <p class="fontSize1 fw-normal mb-1">Coupons</p>
                                            <p class="fs-6 text-muted fw-bolder">Value: &#8377;<span class="">41,25,000</span></p>
                                        </div>
                                    </div>
                                    <p class="text-success fontSize1 mb-2 fw-bolder"><i class="fa-solid fa-arrow-up me-1"></i>12.4% 
                                        <span class="fontSize2 text-muted fw-bolder">vs last month</span>
                                    </p>
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12">
                                <div class="rounded-4 p-3 card walletIcon2">
                                    <!-- Background Icon -->
                                    <i class="fa-solid fa-wallet walletCase2"></i>
                                    <div class="d-flex gap-2">
                                        <div class="icon2">
                                            <i class="fa-solid fa-wallet"></i>
                                        </div>
                                        <div class="">
                                            <h1 class="fs-6 fw-bolder">Available Loyalty Coupons</h1>
                                            <p class="fs-5 fw-bolder mb-0">1,550</p>
                                            <p class="fontSize1 fw-normal mb-1">Coupons</p>
                                            <p class="fs-6 text-muted fw-bolder">Value: &#8377;<span class="">7,75,000</span></p>
                                        </div>
                                    </div>
                                    <p class="text-success fontSize1 mb-2 fw-bolder"><i class="fa-solid fa-arrow-up me-1"></i>22.7% 
                                        <span class="fontSize2 text-muted fw-bolder">vs last month</span>
                                    </p>
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12">
                                <div class="rounded-4 p-3 card walletIcon3">
                                    <!-- Background Icon -->
                                    <i class="fa-solid fa-lock walletCase3"></i>
                                    <div class="d-flex gap-2">
                                        <div class="icon3">
                                            <i class="fa-solid fa-lock"></i>
                                        </div>
                                        <div class="">
                                            <h1 class="fs-6 fw-bolder">Locked Loyalty Coupons</h1>
                                            <p class="fs-5 fw-bolder mb-0">6,470</p>
                                            <p class="fontSize1 fw-normal mb-1">Coupons</p>
                                            <p class="fs-6 text-muted fw-bolder">Value: &#8377;<span class="">32,35,000</span></p>
                                        </div>
                                    </div>
                                    <p class="text-success fontSize1 mb-2 fw-bolder"><i class="fa-solid fa-arrow-up me-1"></i>8.2% 
                                        <span class="fontSize2 text-muted fw-bolder">vs last month</span>
                                    </p>
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12">
                                <div class="rounded-4 p-3 card walletIcon4">
                                    <!-- Background Icon -->
                                    <i class="fa-brands fa-uikit walletCase4"></i>
                                    <div class="d-flex gap-2">
                                        <div class="icon4">
                                            <i class="fa-brands fa-uikit"></i>
                                        </div>
                                        <div class="">
                                            <h1 class="fs-6 fw-bolder">Used Loyalty Coupons</h1>
                                            <p class="fs-5 fw-bolder mb-0">1,980</p>
                                            <p class="fontSize1 fw-normal mb-1">Coupons</p>
                                            <p class="fs-6 text-muted fw-bolder">Value: &#8377;<span class="">9,90,000</span></p>
                                        </div>
                                    </div>
                                    <p class="text-success fontSize1 mb-2 fw-bolder"><i class="fa-solid fa-arrow-up me-1"></i>15.3% 
                                        <span class="fontSize2 text-muted fw-bolder">vs last month</span>
                                    </p>
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12">
                                <div class="rounded-4 p-3 card walletIcon5">
                                    <!-- Background Icon -->
                                    <i class="fa-solid fa-trash walletCase5"></i>
                                    <div class="d-flex gap-2">
                                        <div class="icon5">
                                            <i class="fa-solid fa-trash"></i>
                                        </div>
                                        <div class="">
                                            <h1 class="fs-6 fw-bolder">Expired Loyalty Coupons</h1>
                                            <p class="fs-5 fw-bolder mb-0">15,230</p>
                                            <p class="fontSize1 fw-normal mb-1">Coupons</p>
                                            <p class="fs-6 text-muted fw-bolder">Value: &#8377;<span class="">41,25,000</span></p>
                                        </div>
                                    </div>
                                    <p class="text-success fontSize1 mb-2 fw-bolder"><i class="fa-solid fa-arrow-up me-1"></i>12.4% 
                                        <span class="fontSize2 text-muted fw-bolder">vs last month</span>
                                    </p>
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12">
                                <div class="rounded-4 p-3 card walletIcon6">
                                    <!-- Background Icon -->
                                    <i class="fa-solid fa-hourglass walletCase6"></i>
                                    <div class="d-flex gap-2">
                                        <div class="icon6">
                                            <i class="fa-solid fa-hourglass"></i>
                                        </div>
                                        <div class="">
                                            <h1 class="fs-6 fw-bolder">Expiring within 30 days</h1>
                                            <p class="fs-5 fw-bolder mb-0">15,230</p>
                                            <p class="fontSize1 fw-normal mb-1">Coupons</p>
                                            <p class="fs-6 text-muted fw-bolder">Value: &#8377;<span class="">41,25,000</span></p>
                                        </div>
                                    </div>
                                    <p class="text-success fontSize1 mb-2 fw-bolder"><i class="fa-solid fa-arrow-up me-1"></i>12.4% 
                                        <span class="fontSize2 text-muted fw-bolder">vs last month</span>
                                    </p>
                                </div>
                            </div>
                            
                        </div>
                        <div class="row my-3">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row mb-2 d-flex justify-content-end">
                                            <div class="col-xl-6 col-lg-8 col-md-8 col-sm-9 col-12 d-flex justify-content-between">
                                                <div>
                                                    <select class="form-select mb-3" aria-label="Large select example">
                                                        <option selected>Coupon Status</option>
                                                        <option value="available">Available</option>
                                                        <option value="used">Used</option>
                                                        <option value="expired">Expired</option>
                                                    </select>
                                                </div>
                                                <div class="text-end">
                                                    <input type="month" value="" min="2020-01" max="" class="rounded-3 border border-secondary-subtle py-2">
                                                </div>
                                                <a href="#">
                                                    <div class="linkBtn gap-2 align-items-center">
                                                        <i class="fa-solid fa-download"></i>
                                                        <p class="fs-6 mb-0 fw-bolder pe-1">Download</p>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="table-responsive">
                                            <table class="table align-middle table-nowrap dt-responsive nowrap w-100" id="pendingCustomerList-table">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th>Customer</th>
                                                        <th>Membership</th>
                                                        <th>Total Coupons <span class="d-flex justify-content-center text-muted">(Issued)</span></th>
                                                        <th>Available <span class="d-flex justify-content-center text-muted">(Unlocked)</span></th>
                                                        <th>Used</th>
                                                        <th>Expired</th>
                                                        <th>Locked</th>
                                                        <th>Status</th>
                                                        <th>Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            <div class="d-flex gap-2 align-items-center mb-2">
                                                                <div class="">
                                                                    <img src="../assets/images/users/avatar-7.jpg" alt="Package" class="profileImage">
                                                                </div>
                                                                <div class="">
                                                                    <p class="mb-0 fw-bolder fontSize1">Rahul Mehta</p>
                                                                    <p class="fontSize1 fw-bold mb-0">CUST10001</p>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="p-1 text-success-emphasis bg-success-subtle border border-success-subtle rounded-3 text-center fw-bolder">
                                                                Neo Select
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="">
                                                                <p class="mb-0 fw-bolder fs-6 text-center">8</p>
                                                                <p class="fontSize1 fw-bold mb-0 text-muted text-center">(&#8377;15,000)</p>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="">
                                                                <p class="mb-0 fw-bolder fs-6 text-success text-center">6</p>
                                                                <p class="fontSize1 fw-bold mb-0 text-success text-center">(&#8377;3,500)</p>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="">
                                                                <p class="mb-0 fw-bolder fs-6 text-center">2</p>
                                                                <p class="fontSize1 fw-bold mb-0 text-muted text-center">(&#8377;1,000)</p>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="">
                                                                <p class="mb-0 fw-bolder fs-6 text-danger text-center">0</p>
                                                                <p class="fontSize1 fw-bold mb-0 text-danger text-center">(&#8377;0)</p>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="">
                                                                <p class="mb-0 fw-bolder fs-6 text-warning text-center">0</p>
                                                                <p class="fontSize1 fw-bold mb-0 text-warning text-center">(&#8377;0)</p>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="p-1 text-success-emphasis bg-success-subtle border border-success-subtle rounded-3 text-center fw-bolder">
                                                                Eligible / Unlocked
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="p-1 text-primary-emphasis bg-primary-subtle border border-primary-subtle rounded-3 text-center fw-bolder">
                                                                View
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <div class="d-flex gap-2 align-items-center mb-2">
                                                                <div class="">
                                                                    <img src="../assets/images/users/avatar-7.jpg" alt="Package" class="profileImage">
                                                                </div>
                                                                <div class="">
                                                                    <p class="mb-0 fw-bolder fontSize1">Rahul Mehta</p>
                                                                    <p class="fontSize1 fw-bold mb-0">CUST10001</p>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="p-1 text-primary-emphasis bg-primary-subtle border border-primary-subtle rounded-3 text-center fw-bolder">
                                                                Neo Select Plus
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="">
                                                                <p class="mb-0 fw-bolder fs-6 text-center">8</p>
                                                                <p class="fontSize1 fw-bold mb-0 text-muted text-center">(&#8377;15,000)</p>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="">
                                                                <p class="mb-0 fw-bolder fs-6 text-success text-center">6</p>
                                                                <p class="fontSize1 fw-bold mb-0 text-success text-center">(&#8377;3,500)</p>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="">
                                                                <p class="mb-0 fw-bolder fs-6 text-center">2</p>
                                                                <p class="fontSize1 fw-bold mb-0 text-muted text-center">(&#8377;1,000)</p>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="">
                                                                <p class="mb-0 fw-bolder fs-6 text-danger text-center">0</p>
                                                                <p class="fontSize1 fw-bold mb-0 text-danger text-center">(&#8377;0)</p>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="">
                                                                <p class="mb-0 fw-bolder fs-6 text-warning text-center">0</p>
                                                                <p class="fontSize1 fw-bold mb-0 text-warning text-center">(&#8377;0)</p>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="p-1 text-danger-emphasis bg-danger-subtle border border-danger-subtle rounded-3 text-center fw-bolder">
                                                                Locked
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="p-1 text-primary-emphasis bg-primary-subtle border border-primary-subtle rounded-3 text-center fw-bolder">
                                                                View
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <div class="d-flex gap-2 align-items-center mb-2">
                                                                <div class="">
                                                                    <img src="../assets/images/users/avatar-7.jpg" alt="Package" class="profileImage">
                                                                </div>
                                                                <div class="">
                                                                    <p class="mb-0 fw-bolder fontSize1">Rahul Mehta</p>
                                                                    <p class="fontSize1 fw-bold mb-0">CUST10001</p>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="p-1 text-warning-emphasis bg-warning-subtle border border-warning-subtle rounded-3 text-center fw-bolder">
                                                                Neo Premium
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="">
                                                                <p class="mb-0 fw-bolder fs-6 text-center">8</p>
                                                                <p class="fontSize1 fw-bold mb-0 text-muted text-center">(&#8377;15,000)</p>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="">
                                                                <p class="mb-0 fw-bolder fs-6 text-success text-center">6</p>
                                                                <p class="fontSize1 fw-bold mb-0 text-success text-center">(&#8377;3,500)</p>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="">
                                                                <p class="mb-0 fw-bolder fs-6 text-center">2</p>
                                                                <p class="fontSize1 fw-bold mb-0 text-muted text-center">(&#8377;1,000)</p>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="">
                                                                <p class="mb-0 fw-bolder fs-6 text-danger text-center">0</p>
                                                                <p class="fontSize1 fw-bold mb-0 text-danger text-center">(&#8377;0)</p>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="">
                                                                <p class="mb-0 fw-bolder fs-6 text-warning text-center">0</p>
                                                                <p class="fontSize1 fw-bold mb-0 text-warning text-center">(&#8377;0)</p>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="p-1 text-success-emphasis bg-success-subtle border border-success-subtle rounded-3 text-center fw-bolder">
                                                                Eligible / Unlocked
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="p-1 text-primary-emphasis bg-primary-subtle border border-primary-subtle rounded-3 text-center fw-bolder">
                                                                View
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> <!-- container-fluid -->
                </div> <!-- End Page-content -->

                
                <?php include_once "../footer.php" ?>
            </div>
            <!-- end main content-->
        </div>
        <!-- END layout-wrapper -->

        <!-- loading screen -->
        <div id="loading-overlay">
            <div class="loading-icon"></div>
        </div>
        <!-- Add button icon -->
        <div class="btn" data-bs-toggle="modal" data-bs-target="#newCustomerModal" style="width: 25px; height: 25px; padding: 0px; position: fixed; bottom: 120px; right: 43px; border-radius: 50%;">
            <a style="display: flex; justify-content: center; align-items: center; height: -webkit-fill-available;">
                <i class="fa-solid fa-circle-plus fa-beat-fade fa-3x" style="color: #4b38b3;"></i>
            </a>
        </div>
        <!-- End button icon -->
        <!--start back-to-top-->
        <button onclick="topFunction()" class="scrollToTop scroll-btn show btn" id="back-to-top">
            <i class="mdi mdi-arrow-up"></i>
        </button>
        <!--end back-to-top-->                                                

        <!-- JAVASCRIPT -->
        <script src="../assets/libs/jquery/jquery.min.js"></script>
        <script src="../assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="../assets/libs/metismenu/metisMenu.min.js"></script>
        <script src="../assets/libs/simplebar/simplebar.min.js"></script>
        <script src="../assets/libs/node-waves/waves.min.js"></script>
        <!-- bootstrap-datepicker js -->
        <script src="../assets/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>

        <!-- Required datatable js -->
        <script src="../assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
        <script src="../assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
        
        <!-- Responsive examples -->
        <script src="../assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
        <script src="../assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>
        
        <!-- ecommerce-customer-list init -->
        <!-- <script src="../assets/js/pages/ecommerce-customer-list.init.js"></script> -->
        
        <!-- App js -->
        <script src="../assets/js/app.js"></script>

        <script>
            var mybutton = document.getElementById("back-to-top");
            function scrollFunction() {
                100 < document.body.scrollTop || 100 < document.documentElement.scrollTop ? mybutton.style.display = "block" : mybutton.style.display = "none"
            }
            function topFunction() {
                document.body.scrollTop = 0,
                document.documentElement.scrollTop = 0
            }
            mybutton && (window.onscroll = function() {
                scrollFunction()
            }
            );

        </script>

        <!-- dataTable -->
        <script>
            $(document).ready(function(){
                $("#pendingCustomerList-table").DataTable();
            });
            
            function editfuncCust(id,refno,regby,cut,st,ct,editfor){ 
                window.location.href='edit_customers.php?vkvbvjfgfikix='+id+'&nohbref='+refno+'&fyfyfregby='+regby+'&ncy='+cut+'&mst='+st+'&hct='+ct+'&editfor='+editfor;
            };

            function addCustRef(id,fullname,taRef,status){ 
                window.location.href='add_customers.php?id='+id+'&taRef='+taRef+'&fullname='+fullname+'&status='+status;
            };

        </script>
    </body>
</html>