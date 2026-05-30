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
        <!-- remix icon -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.6.0/remixicon.css" integrity="sha512-kJlvECunwXftkPwyvHbclArO8wszgBGisiLeuDFwNM8ws+wKIw0sv1os3ClWZOcrEB2eRXULYUsm8OVRGJKwGA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
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
            .loyalty1 {
                font-size: 20px !important;
                color: #35239a;
                background: #e0dbf9;
                border-radius: 100%;
                padding: 8px 10px;
                width: 60px;
                height: 60px;
                display: flex;
                justify-content: center;
                align-items: center;
            }
            .loyalty2 {
                font-size: 20px !important;
                color: #067b40;
                background: #c5f2cd;
                border-radius: 100%;
                padding: 8px 10px;
                width: 60px;
                height: 60px;
                display: flex;
                justify-content: center;
                align-items: center;
            }
            .loyalty3 {
                font-size: 20px !important;
                color: #fbaa06;
                background: #f3e9ce;
                border-radius: 100%;
                padding: 8px 10px;
                width: 60px;
                height: 60px;
                display: flex;
                justify-content: center;
                align-items: center;
            }
            .loyalty4 {
                font-size: 20px !important;
                color: #136bd8;
                background: #d2e0f1;
                border-radius: 100%;
                padding: 8px 10px;
                width: 60px;
                height: 60px;
                display: flex;
                justify-content: center;
                align-items: center;
            }
            .loyalty5 {
                font-size: 20px !important;
                color: #fb2306;
                background: #fbdad5;
                border-radius: 100%;
                padding: 8px 10px;
                width: 60px;
                height: 60px;
                display: flex;
                justify-content: center;
                align-items: center;
            }
            .loyaltyCard1 {
                background: #f4f2ff;
                border: 1px solid #c5bdf4;
            }
            .loyaltyCard2 {
                background: #e5ffe6;
                border: 1px solid #a9d8aa;
            }
            .loyaltyCard3 {
                background: #fffcf4;
                border: 1px solid #ddd0ac;
            }
            .loyaltyCard4 {
                background: #eef3f9;
                border: 1px solid #aecaec;
            }
            .loyaltyCard5 {
                background: #fff6f4;
                border: 1px solid #f9d6ce;
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
                color: #4b38b3;
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
            /* profile section */
            .profileImgLoyalty {
                width: 80px !important;
                height: 80px !important;
                object-fit: fill !important;
                border-radius: 100% !important;
                position: relative;
            }
            .statusBtn {
                width: 90px;
                border: 1px solid #03730f;
                background-color: #dafdde;
                color: #03730f;
                position: absolute;
                top: 68px !important;
            }
            .statusBtn i{
                color: #03730f;
            }
            .cardLoyaltyDetails i{
                color: #4b38b3;
            }
            .textColor {
                color: #3c3f91;
            }
            .textColor1 {
                color: #4b38b3;
            }
            .textColor2 {
                color: #067b40;
            }
            .iconLoyalty1 {
                border-radius: 40%;
                background-color: #e1def3; 
                width: 45px;
                height: 45px;
                display: flex;
                justify-content: center;
                align-items: center;
            }
            .iconLoyalty1 i{
                color: #4b38b3;
            }
            .iconLoyalty2 {
                border-radius: 40%;
                background-color: #eef3f9; 
                width: 45px;
                height: 45px;
                display: flex;
                justify-content: center;
                align-items: center;
            }
            .iconLoyalty2 i{
                color: #136bd8;
            }
            .loyaltyAmt1 {
                color: #35239a;
                background: #e0dbf9;
                padding: 5px;
                display: flex;
                justify-content: center;
                border-radius: 8px;
            }
            .loyaltyAmt2 {
                background-color: #c5f2cd;
                padding: 5px;
                display: flex;
                justify-content: center;
                border-radius: 8px;
            }
            .loyaltyAmt3 {
                color: #fbaa06;
                background: #f3e9ce;
                padding: 5px;
                display: flex;
                justify-content: center;
                border-radius: 8px;
            }
            .loyaltyAmt4 {
                color: #136bd8;
                background: #d2e0f1;
                padding: 5px;
                display: flex;
                justify-content: center;
                border-radius: 8px;
            }
            .loyaltyAmt5 {
                color: #fb2306;
                background: #fbdad5;
                padding: 5px;
                display: flex;
                justify-content: center;
                border-radius: 8px;
            }
            .filter-btn {
                padding: 8px;
                border-radius: 8px;
                background-color: #fff; 
                color: #5442ba;
                border: 1px solid #5442ba;
            }
            .filter-btn:hover {
                padding: 8px;
                border-radius: 8px;
                background-color: #5442ba; 
                color: #fff;
                border: 1px solid #5442ba;
            }
            .filter-btn.active {
                background-color: #5442ba; 
                color: #fff;
                border: 1px solid #5442ba;
            }
            .navMenu {
                list-style: none;
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
                        <div class="d-inline-block" onclick="history.back()" style="cursor:pointer;">
                            <div class="viewBtn rounded-2 py-2">
                                <p class="text-muted mb-0 fw-bolder">
                                    <i class="fa-solid fa-arrow-left me-2 fw-bolder"></i>
                                    Back to Loyalty Coupon Wallet
                                </p>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <h2 class="fw-bolder text-dark">Customer Loyalty Details</h2>
                            <a href="#">
                                <div class="linkBtn gap-2 align-items-center">
                                    <i class="fa-solid fa-download"></i>
                                    <p class="fs-6 mb-0 fw-bolder pe-1">Export Statement</p>
                                </div>
                            </a>
                        </div>
                        <div class="card rounded-4 p-3">
                            <div class="row d-flex justify-content-evenly">
                                <div class="col-lg-4 col-md-12 col-sm-12 col-12 d-flex justify-content-center gap-4 mb-2">
                                    <div class="d-flex justify-content-center">
                                        <img src="../assets/images/users/avatar-5.jpg" alt="" class="profileImgLoyalty">
                                        <p class="p-1 rounded-pill fw-bolder text-center statusBtn"><i class="fa-solid fa-circle me-1"></i>Active</p>
                                    </div>
                                    <div class="cardLoyaltyDetails">
                                        <h4 class="fw-bolder text-dark ">Pratiksha Gawas <i class="ri-verified-badge-fill"></i></h4>
                                        <p class="fw-bold textColor mb-2">CUST10001</p>
                                        <p class="fw-bold textColor mb-2"><i class="ri-phone-line me-2 textColor"></i>9876543210</p>
                                        <p class="fw-bold textColor mb-2"><i class="fa-regular fa-envelope me-2 textColor"></i>pratiksha@gmail.com</p>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-4 col-sm-4 col-12 border-start border-3 gap-3 d-flex justify-content-center align-items-center mb-2">
                                    <div class="iconLoyalty1">
                                        <i class="fa-solid fa-crown"></i>
                                    </div>
                                    <div>
                                        <p class="fw-bold textColor mb-1">Membership</p>
                                        <p class="fw-bold textColor1 mb-2">Neo Select</p>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-4 col-sm-4 col-12 border-start border-3 gap-3 d-flex justify-content-center align-items-center mb-2">
                                    <div class="iconLoyalty2">
                                        <i class="fa-solid fa-calendar-days"></i>
                                    </div>
                                    <div>
                                        <p class="fw-bold textColor mb-1">Joined On</p>
                                        <p class="fw-bold text-dark mb-2">15 Jan 2025</p>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-4 col-sm-4 col-12 border-start border-3 gap-3 d-flex justify-content-center align-items-center mb-2">
                                    <div class="iconLoyalty1">
                                        <i class="fa-solid fa-plane-departure"></i>
                                    </div>
                                    <div>
                                        <p class="fw-bold textColor mb-1">Total Trips</p>
                                        <p class="fw-bold text-dark mb-2">5 Trips</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-12">
                                <div class="rounded-4 p-3 card loyaltyCard2">
                                    <div class="d-flex gap-3">
                                        <div class="loyalty2">
                                            <i class="fa-solid fa-wallet"></i>
                                        </div>
                                        <div class="">
                                            <h1 class="fs-6 fw-bolder">Earned Coupon</h1>
                                            <p class="fs-2 fw-bolder mb-0 text-dark">8</p>
                                            <p class="fs-6 textColor2 loyaltyAmt2 fw-bolder"> &#8377;<span class="">4,000</span></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-12">
                                <div class="rounded-4 p-3 card loyaltyCard1">
                                    <div class="d-flex gap-3">
                                        <div class="loyalty1">
                                            <i class="fa-solid fa-wallet"></i>
                                        </div>
                                        <div class="">
                                            <h1 class="fs-6 fw-bolder">Available Coupon</h1>
                                            <p class="fs-2 fw-bolder mb-0 text-dark">2</p>
                                            <p class="fs-6 textColor1 loyaltyAmt1 fw-bolder"> &#8377;<span class="">1,000</span></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-12">
                                <div class="rounded-4 p-3 card loyaltyCard3">
                                    <div class="d-flex gap-3">
                                        <div class="loyalty3">
                                            <i class="fa-solid fa-wallet"></i>
                                        </div>
                                        <div class="">
                                            <h1 class="fs-6 fw-bolder">Used Coupon</h1>
                                            <p class="fs-2 fw-bolder mb-0 text-dark">2</p>
                                            <p class="fs-6 textColor3 loyaltyAmt3 fw-bolder"> &#8377;<span class="">1,000</span></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-12">
                                <div class="rounded-4 p-3 card loyaltyCard4">
                                    <div class="d-flex gap-3">
                                        <div class="loyalty4">
                                            <i class="fa-solid fa-wallet"></i>
                                        </div>
                                        <div class="">
                                            <h1 class="fs-6 fw-bolder">Locked Coupon</h1>
                                            <p class="fs-2 fw-bolder mb-0 text-dark">3</p>
                                            <p class="fs-6 textColor4 loyaltyAmt4 fw-bolder"> &#8377;<span class="">1,500</span></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-12">
                                <div class="rounded-4 p-3 card loyaltyCard5">
                                    <div class="d-flex gap-3">
                                        <div class="loyalty5">
                                            <i class="fa-solid fa-wallet"></i>
                                        </div>
                                        <div class="">
                                            <h1 class="fs-6 fw-bolder">Deleted / Expired</h1>
                                            <p class="fs-2 fw-bolder mb-0 text-dark">1</p>
                                            <p class="fs-6 textColor5 loyaltyAmt5 fw-bolder"> &#8377;<span class="">500</span></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row my-3">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row mb-2 d-flex justify-content-between">
                                            <div class="col-xl-6 col-lg-8 col-md-8 col-sm-9 col-12 d-flex justify-content-between">
                                                <nav class="customLoyaltyNavbar mt-2 mb-4">
                                                    <ul class="navMenu d-flex justify-content-evenly flex-wrap gap-2 ps-0 mb-0">
                                                        <li>
                                                            <button class="filter-btn active px-3" data-filter="all">
                                                                All Transaction
                                                            </button>
                                                        </li>
                                                        <li>
                                                            <button class="filter-btn" data-filter="travel">
                                                                Earned
                                                            </button>
                                                        </li>
                                                        <li>
                                                            <button class="filter-btn" data-filter="bank">
                                                                Used
                                                            </button>
                                                        </li>
                                                        <li>
                                                            <button class="filter-btn" data-filter="seminar">
                                                                Locked
                                                            </button>
                                                        </li>
                                                        <li>
                                                            <button class="filter-btn" data-filter="engagement">
                                                                Deleted
                                                            </button>
                                                        </li>
                                                    </ul>
                                                </nav>
                                            </div>
                                            <div class="col-xl-2">
                                                <div class="text-end">
                                                    <input type="month" value="" min="2020-01" max="" class="rounded-3 border border-secondary-subtle py-2">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="table-responsive">
                                            <table class="table align-middle table-nowrap dt-responsive nowrap w-100" id="pendingCustomerList-table">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th>Date & Time </th>
                                                        <th>Coupons</th>
                                                        <th>Value</th>
                                                        <th>Source / Reason</th>
                                                        <th>Status</th>
                                                        <th>Expiry Date</th>
                                                        <th>Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            <p class="mb-0 fw-bold">10 jan 2026, 10:30 AM</p>
                                                        </td>
                                                        <td>
                                                            <p class="mb-0 fw-bold text-center">+2</p>
                                                        </td>
                                                        <td>
                                                            <p class="fontSize1 fw-bold mb-0">&#8377;1,000</p>
                                                        </td>
                                                        <td>
                                                            <p class="mb-0 fw-bold">Goa Trip <span>(Booking #BK10001)</span></p>
                                                        </td>
                                                        <td>
                                                            <div class="p-1 text-success-emphasis bg-success-subtle border border-success-subtle rounded-3 text-center fw-bolder">
                                                                <i class="fa-solid fa-circle me-1"></i>
                                                                Active
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="">
                                                                <p class="mb-0 fw-bolder fs-6 text-center">10 Jan 2027</p>
                                                                <p class="fontSize1 fw-bold mb-0 text-success text-center">180 Days Left</p>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="text-center">
                                                                <button class="toggle-btn btn btn-sm btn-light">
                                                                    <i class="fa-solid fa-chevron-down"></i>
                                                                </button>
                                                                <!-- <button class="toggle-btn btn btn-sm btn-light">
                                                                    <i class="fa-solid fa-minus"></i>
                                                                </button> -->
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <p class="mb-0 fw-bold">10 jan 2026, 10:30 AM</p>
                                                        </td>
                                                        <td>
                                                            <p class="mb-0 fw-bold text-center text-warning">+2</p>
                                                        </td>
                                                        <td>
                                                            <p class="fontSize1 fw-bold mb-0 fw-bold">&#8377;1,000</p>
                                                        </td>
                                                        <td>
                                                            <p class="mb-0 fw-bold">Goa Trip <span>(Booking #BK10001)</span></p>
                                                        </td>
                                                        <td>
                                                            <div class="p-1 text-warning-emphasis bg-warning-subtle border border-warning-subtle rounded-3 text-center fw-bolder">
                                                                <i class="fa-solid fa-circle me-1"></i>
                                                                Active
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="">
                                                                <p class="mb-0 fw-bolder fs-6 text-center">10 Jan 2027</p>
                                                                <p class="fontSize1 fw-bold mb-0 text-warning text-center">180 Days Left</p>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="text-center">
                                                                <button class="toggle-btn btn btn-sm btn-light">
                                                                    <i class="fa-solid fa-chevron-down"></i>
                                                                </button>
                                                                <!-- <button class="toggle-btn btn btn-sm btn-light">
                                                                    <i class="fa-solid fa-minus"></i>
                                                                </button> -->
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <p class="mb-0 fw-bold">10 jan 2026, 10:30 AM</p>
                                                        </td>
                                                        <td>
                                                            <p class="mb-0 fw-bold text-center text-danger">+2</p>
                                                        </td>
                                                        <td>
                                                            <p class="fontSize1 fw-bold mb-0 fw-bold">&#8377;1,000</p>
                                                        </td>
                                                        <td>
                                                            <p class="mb-0 fw-bold">Goa Trip <span>(Booking #BK10001)</span></p>
                                                        </td>
                                                        <td>
                                                            <div class="p-1 text-danger-emphasis bg-danger-subtle border border-danger-subtle rounded-3 text-center fw-bolder">
                                                                <i class="fa-solid fa-circle me-1"></i>
                                                                Active
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="">
                                                                <p class="mb-0 fw-bolder fs-6 text-center">10 Jan 2027</p>
                                                                <p class="fontSize1 fw-bold mb-0 text-danger text-center">180 Days Left</p>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="text-center">
                                                                <button class="toggle-btn btn btn-sm btn-light">
                                                                    <i class="fa-solid fa-chevron-down"></i>
                                                                </button>
                                                                <!-- <button class="toggle-btn btn btn-sm btn-light">
                                                                    <i class="fa-solid fa-minus"></i>
                                                                </button> -->
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
        <script>
            document.querySelectorAll('.filter-btn').forEach(button => {
                button.addEventListener('click', function () {

                    document.querySelectorAll('.filter-btn').forEach(btn => {
                        btn.classList.remove('active');
                    });

                    this.classList.add('active');
                });
            });
        </script>
    </body>
</html>