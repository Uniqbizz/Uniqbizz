<?php
    session_start();
    if(!isset($_SESSION['username'])){
        echo '<script>location.href = "../login.php";</script>';
    }
    require '../connect.php';
    $date = date('Y'); 
    include (__DIR__.'/models/cw_card_data.php');
?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Customer Wallet | Admin Dashboard </title>
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
        <!-- add on 30-05-2026 by SV -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css">
         <!-- add on 30-05-2026 by SV END-->
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
            .walletIcon1 {
                font-size: 20px !important;
                color: #fff;
                background: #35239a;
                border-radius: 8px;
                padding: 8px 10px;
                width: 45px;
                height: 45px;
            }
            .walletIcon2 {
                font-size: 20px !important;
                color: #fff;
                background: #136bd8;
                border-radius: 8px;
                padding: 8px 10px;
                width: 45px;
                height: 45px;
            }
            .walletIcon3 {
                font-size: 20px !important;
                color: #fff;
                background: #067b40;
                border-radius: 8px;
                padding: 8px 10px;
                width: 45px;
                height: 45px;
            }
            .walletIcon4 {
                font-size: 20px !important;
                color: #fff;
                background: #d54a0a;
                border-radius: 8px;
                padding: 8px 10px;
                width: 45px;
                height: 45px;
            }
            .walletCard1 {
                background: #f5f3fd;
                border: 1px solid #35239a;
            }
            .walletCard2 {
                background: #eaf4ff;
                border: 1px solid #136bd8;
            }
            .walletCard3 {
                background: #ecfff5;
                border: 1px solid #067b40;
            }
            .walletCard4 {
                background: #fff4ef;
                border: 1px solid #d54a0a;
            }
            .profileImage {
                width:40px !important;
                height: 40px !important;
                border-radius: 100% !important;
                object-fit: fill;
            }
            .memberShipType {
                width: 90px;
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
                            <h2 class="fw-bolder text-dark">Customer Wallet Management</h2>
                            <p class="fs-6 text-muted">
                                Manage, monitor and control all customer wallets from one place.
                            </p>
                        </div>
                        <div class="row">
                            <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-12 mb-2">
                                <a href="couponWallet.php">
                                    <div class="rounded-3 px-3 py-2 walletCard1">
                                        <div class="d-flex gap-2">
                                            <div class="walletIcon1">
                                                <i class="fa-solid fa-wallet"></i>
                                            </div>
                                            <div class="">
                                                <h1 class="fontSize1 fw-bolder text-dark">Coupon Wallet</h1>
                                                <p class="fs-5 fw-bolder mb-1 text-dark"><?= number_format($couponData['total_coupons']) ?></p>
                                                <p class="fs-6 text-dark fw-bolder">Value: &#8377; <span class=""><?= number_format($couponData['total_amt']) ?></span></p>
                                            </div>
                                        </div>
                                        <p class="text-success fontSize1 mb-0 fw-bolder">Across <?= number_format($couponData['customer_count']) ?> Customers</p>
                                    </div>
                                </a>
                            </div>
                            <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-12 mb-2">
                                <a href="loyaltyCouponWallet.php">
                                    <div class="rounded-3 px-3 py-2 walletCard2">
                                        <div class="d-flex gap-2">
                                            <div class="walletIcon2">
                                                <i class="fa-solid fa-ticket"></i>
                                            </div>
                                            <div class="">
                                                <h1 class="fontSize1 fw-bolder text-dark">Loyalty Coupon Wallet</h1>
                                                <p class="fs-5 fw-bolder mb-1 text-dark"><?= number_format($loyalCouponData['total_coupons']) ?></p>
                                                <p class="fs-6 text-dark fw-bolder">Value: &#8377; <span class=""><?= number_format($loyalCouponData['total_amt']) ?></span></p>
                                            </div>
                                        </div>
                                        <p class="text-success fontSize1 mb-0 fw-bolder">Across <?= number_format($loyalCouponData['customer_count']) ?> Customers</p>
                                    </div>
                                </a>
                            </div>
                            <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-12 mb-2">
                                <a href="referralWallet.php">
                                    <div class="rounded-3 px-3 py-2 walletCard3">
                                        <div class="d-flex gap-2">
                                            <div class="walletIcon3">
                                                <i class="fa-solid fa-money-bill-transfer"></i>
                                            </div>
                                            <div class="">
                                                <h1 class="fontSize1 fw-bolder text-dark">Referral Customer Wallet</h1>
                                                <p class="fs-5 fw-bolder mb-1 text-dark">&#8377; <?= number_format($refWalletData['total_amt']) ?></p>
                                                <p class="fontSize2 fw-bolder text-dark"><?= number_format($refWalletData['pending_encashed_count']) ?> requests withdrawal pending</p>
                                            </div>
                                        </div>
                                        <p class="text-success fontSize1 mb-0 fw-bolder">Across <?= number_format($refWalletData['ref_cust_count']) ?> Customers</p>
                                    </div>
                                </a>
                            </div>
                            <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-12 mb-2">
                                <a href="discountWallet.php">
                                    <div class="rounded-3 px-3 py-2 walletCard4">
                                        <div class="d-flex gap-2">
                                            <div class="walletIcon4">
                                                <i class="fa-solid fa-gift"></i>
                                            </div>
                                            <div class="">
                                                <h1 class="fontSize1 fw-bolder text-dark">Discount Wallet</h1>
                                                <p class="fs-5 fw-bolder mb-1 text-dark">&#8377; <?= number_format($disWalletData['total_amt']) ?></p>
                                            </div>
                                        </div>
                                        <p class="text-danger fontSize1 mb-0 fw-bolder">Across <?= number_format($disWalletData['dis_cust_count']) ?> Customers</p>
                                    </div>
                                </a>
                            </div>
                            <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-12 mb-2">
                                <a href="#">
                                    <div class="rounded-3 px-3 py-2 walletCard2">
                                        <div class="d-flex gap-2">
                                            <div class="walletIcon2">
                                                <i class="fa-solid fa-arrow-trend-up"></i>
                                            </div>
                                            <div class="">
                                                <h1 class="fontSize1 fw-bolder text-dark">Extended Wallet</h1>
                                                <p class="fs-5 fw-bolder mb-1 text-dark">&#8377; <?= number_format($etdWalletData['total_amt']) ?></p>
                                            </div>
                                        </div>
                                        <p class="text-success fontSize1 mb-0 fw-bolder">Across <?= number_format($etdWalletData['etd_cust_count']) ?> Customers</p>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="row my-3">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row mb-2 d-flex justify-content-end">
                                            <div class="row g-2 align-items-center mb-3">

                                                <!-- Wallet Type -->
                                                <div class="col-12 col-md-6 col-lg-3">
                                                    <select class="form-select" id="membershipFilter">
                                                        <option selected>Membership Type</option>
                                                        <option value="all">All</option>
                                                        <option value="Prime">Prime</option>
                                                        <option value="Premium">Premium</option>
                                                        <option value="Premium Plus">Premium Plus</option>
                                                        <option value="Premium Select">Premium Select</option>
                                                        <option value="Premium Select Lite">Premium Select Lite</option>
                                                        <option value="Neo Select">Neo Select</option>
                                                        <option value="Neo Select Ultra">Neo Select Ultra</option>
                                                        <option value="Free">Free</option>
                                                    </select>
                                                </div>

                                                <!-- Date Range -->
                                                <div class="col-12 col-md-6 col-lg-5">
                                                    <div id="reportrange"
                                                        class="bg-primary text-white px-3 py-2 text-center dateRange w-100"
                                                        style="border-radius:6px; cursor:pointer;">
                                                        <i class="fa fa-calendar"></i>
                                                        &nbsp;
                                                        <span id="selectedDate"></span>
                                                        <i class="fa-solid fa-angle-down"></i>
                                                    </div>
                                                </div>

                                                <!-- Export -->
                                                <div class="col-12 col-lg-2 ms-lg-auto">
                                                    <a href="#" class="text-decoration-none" id="exportExcelBtn">
                                                        <div class="linkBtn gap-2 align-items-center justify-content-center justify-content-lg-start">
                                                            <i class="fa-solid fa-download"></i>
                                                            <p class="fs-6 mb-0 fw-bolder pe-1">Export</p>
                                                        </div>
                                                    </a>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="table-responsive">
                                            <table class="table align-middle table-nowrap dt-responsive nowrap w-100" id="pendingCustomerList-table">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th>Customer</th>
                                                        <th>Membership</th>
                                                        <th>Mobile</th>
                                                        <th>Coupon Wallet</th>
                                                        <th>loyalty Coupon</th>
                                                        <th>Referral Wallet</th>
                                                        <th>Discount Wallet</th>
                                                        <th>Extended Wallet</th>
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
                                                            9876543210
                                                        </td>
                                                        <td>
                                                            <div class="">
                                                                <p class="mb-0 fw-bolder fs-6 text-center">3</p>
                                                                <p class="fontSize1 fw-bold mb-0 text-muted text-center">&#8377;15,000</p>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="">
                                                                <p class="mb-0 fw-bolder fs-6 text-center">12</p>
                                                                <p class="fontSize1 fw-bold mb-0 text-success text-center">&#8377;3,500</p>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="">
                                                                <p class="mb-0 fw-bolder fs-6 textOrange text-center">&#8377;2,300.00</p>
                                                                <p class="fontSize1 fw-bold mb-0 text-muted text-center">Withdrawable</p>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <p class="mb-0 fw-bolder fs-6 text-center text-primary">&#8377;1,200.00</p>
                                                        </td>
                                                        <td>
                                                            <p class="mb-0 fw-bolder fs-6 text-center textViolet">&#8377;4,500.00</p>
                                                        </td>
                                                        <td>
                                                            <div class="p-1 text-success-emphasis bg-success-subtle border border-success-subtle rounded-3 text-center fw-bolder memberShipType">
                                                                Active
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="p-1 text-primary-emphasis bg-primary-subtle border border-primary-subtle rounded-3 text-center fw-bolder memberShipType">
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
                                                            9876543210
                                                        </td>
                                                        <td>
                                                            <div class="">
                                                                <p class="mb-0 fw-bolder fs-6 text-center">3</p>
                                                                <p class="fontSize1 fw-bold mb-0 text-muted text-center">&#8377;15,000</p>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="">
                                                                <p class="mb-0 fw-bolder fs-6 text-center">12</p>
                                                                <p class="fontSize1 fw-bold mb-0 text-success text-center">&#8377;3,500</p>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="">
                                                                <p class="mb-0 fw-bolder fs-6 textOrange text-center">&#8377;2,300.00</p>
                                                                <p class="fontSize1 fw-bold mb-0 text-muted text-center">Withdrawable</p>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <p class="mb-0 fw-bolder fs-6 text-center text-primary">&#8377;1,200.00</p>
                                                        </td>
                                                        <td>
                                                            <p class="mb-0 fw-bolder fs-6 text-center textViolet">&#8377;4,500.00</p>
                                                        </td>
                                                        <td>
                                                            <div class="p-1 text-success-emphasis bg-success-subtle border border-success-subtle rounded-3 text-center fw-bolder memberShipType">
                                                                Active
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="p-1 text-primary-emphasis bg-primary-subtle border border-primary-subtle rounded-3 text-center fw-bolder memberShipType">
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
                                                            9876543210
                                                        </td>
                                                        <td>
                                                            <div class="">
                                                                <p class="mb-0 fw-bolder fs-6 text-center">3</p>
                                                                <p class="fontSize1 fw-bold mb-0 text-muted text-center">&#8377;15,000</p>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="">
                                                                <p class="mb-0 fw-bolder fs-6 text-center">12</p>
                                                                <p class="fontSize1 fw-bold mb-0 text-success text-center">&#8377;3,500</p>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="">
                                                                <p class="mb-0 fw-bolder fs-6 textOrange text-center">&#8377;2,300.00</p>
                                                                <p class="fontSize1 fw-bold mb-0 text-muted text-center">Withdrawable</p>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <p class="mb-0 fw-bolder fs-6 text-center text-primary">&#8377;1,200.00</p>
                                                        </td>
                                                        <td>
                                                            <p class="mb-0 fw-bolder fs-6 text-center textViolet">&#8377;4,500.00</p>
                                                        </td>
                                                        <td>
                                                            <div class="p-1 text-danger-emphasis bg-danger-subtle border border-danger-subtle rounded-3 text-center fw-bolder memberShipType">
                                                                Inactive
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="p-1 text-primary-emphasis bg-primary-subtle border border-primary-subtle rounded-3 text-center fw-bolder memberShipType">
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
        <!-- <div class="btn" data-bs-toggle="modal" data-bs-target="#newCustomerModal" style="width: 25px; height: 25px; padding: 0px; position: fixed; bottom: 120px; right: 43px; border-radius: 50%;">
            <a style="display: flex; justify-content: center; align-items: center; height: -webkit-fill-available;">
                <i class="fa-solid fa-circle-plus fa-beat-fade fa-3x" style="color: #4b38b3;"></i>
            </a>
        </div> -->
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
        <!-- add on 30-05-2026 by SV -->
        <script src="https://cdn.jsdelivr.net/npm/moment/min/moment.min.js"></script>

        <script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
         <!-- add on 30-05-2026 by SV END-->

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
            
            function editfuncCust(id,refno,regby,cut,st,ct,editfor){ 
                window.location.href='edit_customers.php?vkvbvjfgfikix='+id+'&nohbref='+refno+'&fyfyfregby='+regby+'&ncy='+cut+'&mst='+st+'&hct='+ct+'&editfor='+editfor;
            };

            function addCustRef(id,fullname,taRef,status){ 
                window.location.href='add_customers.php?id='+id+'&taRef='+taRef+'&fullname='+fullname+'&status='+status;
            };
            //added on 30-05 by SV
            function membershipBadge(type)
            {
                const badges = {
                    'Premium Select Lite'   : 'secondary',
                    'Neo Select'            : 'success',
                    'Neo Select Ultra'      : 'primary',
                    'Premium'               : 'warning',
                    'Premium Plus'          : 'danger',
                    'Premium Select'        : 'info',
                    'Prime'                 : 'dark'
                };

                const color = badges[type] || 'secondary';

                return `
                    <div class="p-1 text-${color}-emphasis bg-${color}-subtle border border-${color}-subtle rounded-3 text-center fw-bolder">
                        ${type}
                    </div>
                `;
            }
            function statusBadge(status)
            {
                if(status == 1)
                {
                    return `
                        <div class="p-1 text-success-emphasis bg-success-subtle border border-success-subtle rounded-3 text-center fw-bolder memberShipType">
                            Active
                        </div>
                    `;
                }

                return `
                    <div class="p-1 text-danger-emphasis bg-danger-subtle border border-danger-subtle rounded-3 text-center fw-bolder memberShipType">
                        Inactive
                    </div>
                `;
            }
            
            $(function () {
                let start = moment('2020-01-01');
                let end = moment();

                function cb(start, end) {

                    $('#selectedDate').html(
                        start.format('MMMM D, YYYY') +
                        ' - ' +
                        end.format('MMMM D, YYYY')
                    );

                    window.startDate = '2020-01-01';
                    window.endDate = moment().format('YYYY-MM-DD');

                    if ($.fn.DataTable.isDataTable('#pendingCustomerList-table')) {
                        $('#pendingCustomerList-table').DataTable().ajax.reload();
                    }
                }
                $('#reportrange').daterangepicker({

                    startDate: start,
                    endDate: end,

                    showDropdowns: true,

                    opens: 'left',

                    ranges: {

                        'Today': [
                            moment(),
                            moment()
                        ],

                        'Yesterday': [
                            moment().subtract(1, 'days'),
                            moment().subtract(1, 'days')
                        ],

                        'Last 7 Days': [
                            moment().subtract(6, 'days'),
                            moment()
                        ],

                        'Last 30 Days': [
                            moment().subtract(29, 'days'),
                            moment()
                        ],

                        'This Month': [
                            moment().startOf('month'),
                            moment().endOf('month')
                        ],

                        'Last Month': [
                            moment().subtract(1, 'month').startOf('month'),
                            moment().subtract(1, 'month').endOf('month')
                        ],

                        'Last Year': [
                            moment().subtract(1, 'year').startOf('year'),
                            moment().subtract(1, 'year').endOf('year')
                        ]
                    }

                }, cb);

                cb(start, end);

            });

            function loadTable(startDate, endDate)
            {
                window.startDate = startDate;
                window.endDate = endDate;
                $('#pendingCustomerList-table').DataTable().ajax.reload();
            }
            window.membershipType = 'all';

            $('#membershipFilter').on('change', function(){

                window.membershipType = $(this).val();

                $('#pendingCustomerList-table')
                    .DataTable()
                    .ajax
                    .reload();
            });
            $('#pendingCustomerList-table').DataTable({
                processing: true,
                ajax: {
                    url: 'models/cw_table_data.php',
                    data: function(d){

                        d.start_date      = window.startDate || '';
                        d.end_date        = window.endDate || '';
                        d.membership_type = window.membershipType || 'all';

                    },
                    dataSrc: 'data'

                },
                columns: [

                    {
                        data: null,
                        render: function(data)
                        {
                            return `
                                <div class="d-flex gap-2 align-items-center mb-2">
                                    <div>
                                        <img src="../../uploading/${data.profile_pic}"
                                            class="profileImage">
                                    </div>

                                    <div>
                                        <p class="mb-0 fw-bolder fontSize1">
                                            ${data.customer_name}
                                        </p>

                                        <p class="fontSize1 fw-bold mb-0">
                                            ${data.ca_customer_id}
                                        </p>
                                    </div>
                                </div>
                            `;
                        }
                    },

                    {
                        data: 'customer_type',
                        render: function(data)
                        {
                            return membershipBadge(data);
                        }
                    },

                    {
                        data: 'contact_no'
                    },

                    {
                        data: null,
                        render: function(data)
                        {
                            return `
                                <div>
                                    <p class="mb-0 fw-bolder fs-6 text-center">
                                        ${Number(data.coupon_count).toLocaleString()}
                                    </p>

                                    <p class="fontSize1 fw-bold mb-0 text-muted text-center">
                                        ₹${Number(data.coupon_total).toLocaleString()}
                                    </p>
                                </div>
                            `;
                        }
                    },

                    {
                        data: null,
                        render: function(data)
                        {
                            return `
                                <div>
                                    <p class="mb-0 fw-bolder fs-6 text-center">
                                        ${Number(data.loyalty_count).toLocaleString()}
                                    </p>

                                    <p class="fontSize1 fw-bold mb-0 text-success text-center">
                                        ₹${Number(data.loyalty_coupon_total).toLocaleString()}
                                    </p>
                                </div>
                            `;
                        }
                    },

                    {
                        data: null,
                        render: function(data)
                        {
                            return `
                                <div>
                                    <p class="mb-0 fw-bolder fs-6 textOrange text-center">
                                        ₹${Number(data.ref_total).toLocaleString()}
                                    </p>

                                    <p class="fontSize1 fw-bold mb-0 text-muted text-center">
                                        ${Number(data.ref_count).toLocaleString()} Entries
                                    </p>
                                </div>
                            `;
                        }
                    },

                    {
                        data: null,
                        render: function(data)
                        {
                            return `
                                <p class="mb-0 fw-bolder fs-6 text-center text-primary">
                                    ₹${Number(data.dis_total).toLocaleString()}
                                </p>
                                <p class="fontSize1 fw-bold mb-0 text-muted text-center">
                                    ${Number(data.dis_count).toLocaleString()} Entries
                                </p>
                            `;
                        }
                    },

                    {
                        data: null,
                        render: function(data)
                        {
                            return `
                                <p class="mb-0 fw-bolder fs-6 text-center textViolet">
                                    ₹${Number(data.ext_total).toLocaleString()}
                                </p>
                                <p class="fontSize1 fw-bold mb-0 text-muted text-center">
                                    ${Number(data.ext_count).toLocaleString()} Entries
                                </p>
                            `;
                        }
                        // ₹${Number(data).toLocaleString()}
                    },

                    {
                        data: 'status',
                        render: function(data)
                        {
                            return statusBadge(data);
                        }
                    },

                    {
                        data: null,
                        orderable: false,
                        searchable: false,
                        render: function(data)
                        {
                            return `
                                <a href="customer-wallet-details.php?id=${data.customer_id}"
                                class="text-decoration-none">

                                    <div class="p-1 text-primary-emphasis bg-primary-subtle border border-primary-subtle rounded-3 text-center fw-bolder memberShipType">
                                        View
                                    </div>

                                </a>
                            `;
                        }
                    }
                ]
            });
            $('#exportExcelBtn').click(function(e){

                e.preventDefault();

                let url =
                    'models/export_customer_wallets.php?' +
                    'start_date=' + encodeURIComponent(window.startDate || '') +
                    '&end_date=' + encodeURIComponent(window.endDate || '') +
                    '&membership_type=' + encodeURIComponent(window.membershipType || 'all');

                window.location.href = url;

            });
            //added on 30-05 by SV END
        </script>
    </body>
</html>