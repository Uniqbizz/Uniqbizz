<?php
    session_start();
    if(!isset($_SESSION['username'])){
        echo '<script>location.href = "../login.php";</script>';
    }
    require '../connect.php';
    $date = date('Y'); 
    include (__DIR__.'/models/dw_view_card_data.php'); 
?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>View Referral Wallet Details | Admin Dashboard </title>
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
        <!-- added on 05-06-2026  by SV-->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css">
        <!-- added on 05-06-2026  by SV End-->
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
            .profileImage {
                width:40px !important;
                height: 40px !important;
                border-radius: 100% !important;
                object-fit: fill;
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
            @media (max-width: 540px) {
                .discountDetails {
                    display: block !important;
                    margin-bottom: 10px;
                }
                .discountDetails .linkBtn {
                    width: 200px;
                }
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
                                    Back to Discount Wallet
                                </p>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between mb-3 discountDetails">
                            <h2 class="fw-bolder text-dark">Discount Wallet Details</h2>
                            <a href="#" id="exportExcel">
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
                                        <img src="../../uploading/<?= $custData['profile_pic'] ?>" alt="" class="profileImgLoyalty">
                                        <p class="p-1 rounded-pill fw-bolder text-center statusBtn"><i class="fa-solid fa-circle me-1"></i>Active</p>
                                    </div>
                                    <div class="cardLoyaltyDetails">
                                        <h4 class="fw-bolder text-dark "><?= $custData['cust_name'] ?> <i class="ri-verified-badge-fill"></i></h4>
                                        <p class="fw-bold textColor mb-2"><?= $custData['ca_customer_id'] ?></p>
                                        <p class="fw-bold textColor mb-2"><i class="ri-phone-line me-2 textColor"></i>+<?= $custData['country_code'].$custData['contact_no'] ?></p>
                                        <p class="fw-bold textColor mb-2"><i class="fa-regular fa-envelope me-2 textColor"></i><?= $custData['email'] ?></p>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-4 col-sm-4 col-12 border-start border-3 gap-3 d-flex justify-content-center align-items-center mb-2">
                                    <div class="iconLoyalty1">
                                        <i class="fa-solid fa-crown"></i>
                                    </div>
                                    <div>
                                        <p class="fw-bold textColor mb-1">Membership</p>
                                        <p class="fw-bold textColor1 mb-2"><?= $custData['customer_type'] ?></p>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-4 col-sm-4 col-12 border-start border-3 gap-3 d-flex justify-content-center align-items-center mb-2">
                                    <div class="iconLoyalty2">
                                        <i class="fa-solid fa-calendar-days"></i>
                                    </div>
                                    <div>
                                        <p class="fw-bold textColor mb-1">Joined On</p>
                                        <p class="fw-bold text-dark mb-2"><?= date('d M Y', strtotime($custData['register_date'])) ?></p>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-4 col-sm-4 col-12 border-start border-3 gap-3 d-flex justify-content-center align-items-center mb-2">
                                    <div class="iconLoyalty1">
                                        <i class="fa-solid fa-plane-departure"></i>
                                    </div>
                                    <div>
                                        <p class="fw-bold textColor mb-1">Total Trips</p>
                                        <p class="fw-bold text-dark mb-2"><?= number_format($custData['total_trips']) ?> Trips</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12">
                                <div class="rounded-4 p-3 card loyaltyCard1">
                                    <div class="d-flex gap-3">
                                        <div class="loyalty1">
                                            <i class="fa-solid fa-wallet"></i>
                                        </div>
                                        <div class="">
                                            <h1 class="fs-6 fw-bolder">Total Earned</h1>
                                            <p class="fs-2 fw-bolder mb-0 text-dark"> &#8377;<span class=""><?= number_format($disWalletCurBalData['earn_total']) ?></span></p>
                                            <p class="fs-6 textColor1 loyaltyAmt1 fw-bolder mb-1">Lifetime Earnings</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12">
                                <div class="rounded-4 p-3 card loyaltyCard2">
                                    <div class="d-flex gap-3">
                                        <div class="loyalty2">
                                            <i class="fa-solid fa-wallet"></i>
                                        </div>
                                        <div class="">
                                            <h1 class="fs-6 fw-bolder">Available Balance</h1>
                                            <p class="fs-2 fw-bolder mb-0 text-dark">&#8377;<span class=""><?= number_format($disWalletCurBalData['total_balance']) ?></span></p>
                                            <p class="fs-6 textColor2 loyaltyAmt2 fw-bolder mb-1">Ready to Use </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12">
                                <div class="rounded-4 p-3 card loyaltyCard3">
                                    <div class="d-flex gap-3">
                                        <div class="loyalty3">
                                            <i class="fa-solid fa-wallet"></i>
                                        </div>
                                        <div class="">
                                            <h1 class="fs-6 fw-bolder">Total Used</h1>
                                            <p class="fs-2 fw-bolder mb-0 text-dark">&#8377;<span class=""><?= number_format($disWalletCurBalData['total_used_amount']) ?></span></p>
                                            <p class="fs-6 textColor3 loyaltyAmt3 fw-bolder mb-1">Total Utilized</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row my-3">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table align-middle table-nowrap dt-responsive nowrap w-100" id="pendingCustomerList-table">
                                                <div class="d-flex justify-content-between mb-2 discountDetails">
                                                    <h4 class="fw-bolder text-dark">Wallet Transaction</h4>
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
                                                </div>
                                                <thead class="table-light">
                                                    <tr>
                                                        <th>Date & Time </th>
                                                        <th>Transaction Type</th>
                                                        <th>Description</th>
                                                        <th>Credit (&#8377;)</th>
                                                        <th>Debit (&#8377;)</th>
                                                        <th>Balance (&#8377;)</th>
                                                        <th>Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            <p class="mb-0 fw-bold">10 jan 2026, 10:30 AM</p>
                                                        </td>
                                                        <td>
                                                            <div class="p-1 text-success-emphasis bg-success-subtle border border-success-subtle rounded-3 text-center fw-bolder">
                                                                Discount Credit
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <p class="mb-0 fw-bold">Membership Benefit</p>
                                                        </td>
                                                        <td>
                                                            <p class="fw-bold mb-0 text-success text-end">1,000</p>
                                                        </td>
                                                        <td>
                                                            <p class="mb-0 fw-bold text-danger text-end">-</p>
                                                        </td>
                                                        <td>
                                                            <p class="fw-bold mb-0 text-end">1,000</p>
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
                                                            <div class="p-1 text-success-emphasis bg-success-subtle border border-success-subtle rounded-3 text-center fw-bolder">
                                                                Discount Credit
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <p class="mb-0 fw-bold">Membership Benefit</p>
                                                        </td>
                                                        <td>
                                                            <p class="fw-bold mb-0 text-success text-end">-</p>
                                                        </td>
                                                        <td>
                                                            <p class="mb-0 fw-bold text-danger text-end">500</p>
                                                        </td>
                                                        <td>
                                                            <p class="fw-bold mb-0 text-end">2,000</p>
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
                                                            <div class="p-1 text-success-emphasis bg-success-subtle border border-success-subtle rounded-3 text-center fw-bolder">
                                                                Discount Credit
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <p class="mb-0 fw-bold">Membership Benefit</p>
                                                        </td>
                                                        <td>
                                                            <p class="fw-bold mb-0 text-success text-end">-</p>
                                                        </td>
                                                        <td>
                                                            <p class="mb-0 fw-bold text-danger text-end">1,500</p>
                                                        </td>
                                                        <td>
                                                            <p class="fw-bold mb-0 text-end">500</p>
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
                                                            <div class="p-1 text-warning-emphasis bg-warning-subtle border border-warning-subtle rounded-3 text-center fw-bolder">
                                                                Discount Used
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <p class="mb-0 fw-bold">Goa Package(BK1001)</p>
                                                        </td>
                                                        <td>
                                                            <p class="fw-bold mb-0 text-success text-end">-</p>
                                                        </td>
                                                        <td>
                                                            <p class="mb-0 fw-bold text-danger text-end">1,000</p>
                                                        </td>
                                                        <td>
                                                            <p class="fw-bold mb-0 text-end text-danger">-500</p>
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
        <!-- add on 02-06-2026 by SV -->
        <script src="https://cdn.jsdelivr.net/npm/moment/min/moment.min.js"></script>

        <script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
        <!-- add on 02-06-2026 by SV END-->

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
            
            const CUSTOMER_ID = <?= json_encode($_POST['customer_id']) ?>;            
            
            //date range filter
            $(function () {

                let start = moment('2020-01-01');
                let end = moment();

                window.startDate = start.format('YYYY-MM-DD');
                window.endDate = end.format('YYYY-MM-DD');

                function cb(start, end)
                {
                    $('#selectedDate').html(
                        start.format('MMMM D, YYYY') +
                        ' - ' +
                        end.format('MMMM D, YYYY')
                    );

                    window.startDate = start.format('YYYY-MM-DD');
                    window.endDate = end.format('YYYY-MM-DD');

                    if ($.fn.DataTable.isDataTable('#pendingCustomerList-table'))
                    {
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
            
            function formatChild(rowData) {

                return `
                    <div class="row g-3 p-3">

                        <div class="col-md-6">
                            <div class="card shadow-sm border-0">
                                <div class="card-body">

                                    <h5 class="text-primary mb-3">
                                        <i class="mdi mdi-wallet"></i>
                                        Transaction Details
                                    </h5>

                                    <p class="mb-1">
                                        Description
                                        <strong>${rowData.child.description}</strong>
                                    </p>

                                    <p class="mb-1">
                                        Booking ID
                                        <strong>${rowData.child.booking_id}</strong>
                                    </p>

                                    <p class="mb-0">
                                        Created On
                                        <strong>${rowData.child.created_on}</strong>
                                    </p>

                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card shadow-sm border-0">
                                <div class="card-body">

                                    <h5 class="text-primary mb-3">
                                        <i class="mdi mdi-cash"></i>
                                        Amount Details
                                    </h5>

                                    <p class="mb-1">
                                        Transaction Amount
                                        <strong>₹${Number(rowData.child.transaction_amount).toLocaleString()}</strong>
                                    </p>

                                    <p class="mb-1">
                                        Wallet Balance
                                        <strong>₹${Number(rowData.child.wallet_balance).toLocaleString()}</strong>
                                    </p>

                                    <p class="mb-0">
                                        Status
                                        <strong>${rowData.child.status}</strong>
                                    </p>

                                </div>
                            </div>
                        </div>

                    </div>
                `;
            }

            var table = $('#pendingCustomerList-table').DataTable({

                processing: true,
                destroy: true,
                responsive: false,

                ajax: {
                    url: 'models/dw_view_table_data.php',
                    type: 'POST',
                    data: function(d) {

                        d.customer_id = CUSTOMER_ID;
                        d.start_date = window.startDate;
                        d.end_date = window.endDate;

                        // console.log(d.start_date, d.end_date); // debug
                    },
                    dataSrc: 'data'
                },

                columns: [

                    {
                        data: 'created_date',
                        render: function(data) {

                            let parts = data.split(' ');

                            return `
                                <div>
                                    <div class="fw-bold">${parts[0]} ${parts[1]} ${parts[2]}</div>
                                    <small>${parts[3]} ${parts[4]}</small>
                                </div>
                            `;
                        }
                    },

                    {
                        data: null,
                        render: function(row) {

                            return `
                                <div>
                                    <div class="fw-bold">${row.entry_type}</div>
                                    <small>${row.message}</small>
                                </div>
                            `;
                        }
                    },

                    {
                        data: null,
                        render: function(row) {

                            return `
                                <div>
                                    <div class="fw-bold">${row.trip_name}</div>
                                    <small>${row.transaction_id}</small>
                                </div>
                            `;
                        }
                    },

                    {
                        data: 'entry_type',
                        render: function(data) {

                            let cls =
                                data === 'Discount Earned'
                                ? 'success'
                                : 'danger';

                            let txt =
                                data === 'Discount Earned'
                                ? 'Earned'
                                : 'Used';

                            return `
                                <span class="badge bg-${cls}-subtle text-${cls}">
                                    ${txt}
                                </span>
                            `;
                        }
                    },

                    {
                        data: 'amount',
                        render: function(data, type, row) {

                            let sign =
                                row.entry_type === 'Discount Earned'
                                ? '+'
                                : '-';

                            let color =
                                row.entry_type === 'Discount Earned'
                                ? 'success'
                                : 'danger';

                            return `
                                <span class="fw-bold text-${color}">
                                    ${sign}₹${Number(data).toLocaleString()}
                                </span>
                            `;
                        }
                    },

                    {
                        data: 'balance',
                        render: function(data) {

                            return `
                                <span class="fw-bold">
                                    ₹${Number(data).toLocaleString()}
                                </span>
                            `;
                        }
                    },
                    {
                        className: 'details-control text-center',
                        orderable: false,
                        data: null,
                        defaultContent: `
                            <i class="mdi mdi-chevron-down fs-5 text-dark"></i>
                        `
                    },
                ],

                order: [[1, 'desc']]
            });
            
            $('#pendingCustomerList-table tbody').on(
                'click',
                'td.details-control',
                function () {

                    let tr = $(this).closest('tr');
                    let row = table.row(tr);

                    if (row.child.isShown()) {

                        row.child.hide();

                        tr.removeClass('shown');

                        $(this)
                            .find('i')
                            .removeClass('mdi-chevron-up')
                            .addClass('mdi-chevron-down');

                    } else {

                        row.child(
                            formatChild(row.data())
                        ).show();

                        tr.addClass('shown');

                        $(this)
                            .find('i')
                            .removeClass('mdi-chevron-down')
                            .addClass('mdi-chevron-up');
                    }
                }
            );
            $('#exportExcel').on('click', function () {

                const customerId = CUSTOMER_ID;

                const params = new URLSearchParams(window.location.search);

                const startDate = params.get('start_date') || '';
                const endDate = params.get('end_date') || '';

                window.location.href =
                    'models/export_discount_wallet.php'
                    + '?customer_id=' + encodeURIComponent(customerId)
                    + '&start_date=' + encodeURIComponent(startDate)
                    + '&end_date=' + encodeURIComponent(endDate);
            });
        </script>
    </body>
</html>