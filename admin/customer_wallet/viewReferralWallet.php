<?php
    session_start();
    if(!isset($_SESSION['username'])){
        echo '<script>location.href = "../login.php";</script>';
    }
    require '../connect.php';
    $date = date('Y'); 
    include (__DIR__.'/models/rw_view_card_data.php'); 
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
        <!-- added on 03-06-2026  by SV-->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css">
        <!-- added on 03-06-2026  by SV End-->
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
            #pendingCustomerList-table {
                width: 100% !important;
            }

            /* ONLY truncate specific cells, NOT all */
            #pendingCustomerList-table td {
                overflow: hidden;
                text-overflow: ellipsis;
                white-space: nowrap;
            }

            /* Allow first column to stay readable */
            #pendingCustomerList-table td:nth-child(1),
            #pendingCustomerList-table td:nth-child(2) {
                white-space: nowrap;
            }
            /* added on 02-06-2026 by SV */
            .text-break{
                white-space: normal;
                word-wrap: break-word;
                overflow-wrap: break-word;
            }
            /* added on 02-06-2026 by SV END */
            @media (max-width: 540px) {
                .referralDetails {
                    display: block !important;
                    margin-bottom: 10px;
                }
                .referralDetails .linkBtn {
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
                                    Back to Referral Wallet
                                </p>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between mb-3 referralDetails">
                            <h2 class="fw-bolder text-dark">Referral Wallet Details</h2>
                            <a href="#" onclick="downloadWalletSummary()">
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
                                        <h4 class="fw-bolder text-dark "><?= $custData['cust_name'] ?><i class="ri-verified-badge-fill"></i></h4>
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
                            <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-12">
                                <div class="rounded-4 p-3 card loyaltyCard1">
                                    <div class="d-flex gap-3">
                                        <div class="loyalty1">
                                            <i class="fa-solid fa-wallet"></i>
                                        </div>
                                        <div class="">
                                            <h1 class="fs-6 fw-bolder">Total Earned</h1>
                                            <p class="fs-2 fw-bolder mb-0 text-dark"> &#8377;
                                                <span class="">
                                                    <?= number_format(
                                                        ($refWalletData['ref_total_earning'] ?? 0) +
                                                        ($refWalletCurBalData['ref_booking_total'] ?? 0)
                                                    ) ?>
                                                </span>
                                            </p>
                                            <p class="fs-6 textColor1 loyaltyAmt1 fw-bolder mb-1">Lifetime Earnings</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-12">
                                <div class="rounded-4 p-3 card loyaltyCard2">
                                    <div class="d-flex gap-3">
                                        <div class="loyalty2">
                                            <i class="fa-solid fa-wallet"></i>
                                        </div>
                                        <div class="">
                                            <h1 class="fs-6 fw-bolder">Available Balance</h1>
                                            <p class="fs-2 fw-bolder mb-0 text-dark">&#8377;<span class=""><?= number_format($refWalletCurBalData['total_balance'] ?? 0) ?></span></p>
                                            <p class="fs-6 textColor2 loyaltyAmt2 fw-bolder mb-1">Ready to Use </p>
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
                                            <h1 class="fs-6 fw-bolder">Used Amount</h1>
                                            <p class="fs-2 fw-bolder mb-0 text-dark">&#8377;<span class=""><?= number_format($refWalletCurBalData['total_used_amount']) ?></span></p>
                                            <p class="fs-6 textColor3 loyaltyAmt3 fw-bolder mb-1">Total Utilized</p>
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
                                            <h1 class="fs-6 fw-bolder">Pending Withdrawal</h1>
                                            <p class="fs-2 fw-bolder mb-0 text-dark">&#8377;<span class=""><?= number_format($refWalletData['ref_total_earning']) ?></span></p>
                                            <p class="fs-6 textColor4 loyaltyAmt4 fw-bolder mb-1">Under Process</p>
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
                                                                Credit
                                                            </button>
                                                        </li>
                                                        <li>
                                                            <button class="filter-btn" data-filter="bank">
                                                                Debit
                                                            </button>
                                                        </li>
                                                    </ul>
                                                </nav>
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
                                        </div>
                                        <div class="table-responsive">
                                            <table class="table align-middle table-nowrap dt-responsive nowrap w-100" id="pendingCustomerList-table">
                                                <h4 class="fw-bolder text-dark">Wallet Transaction</h4>
                                                <thead class="table-light">
                                                    <tr>
                                                        <th>Date & Time </th>
                                                        <th>Transaction Type</th>
                                                        <th>Description</th>
                                                        <th>Credit (&#8377;)</th>
                                                        <th>Debit (&#8377;)</th>
                                                        <th>Balance (&#8377;)</th>
                                                        <th>Payment Method / Ref ID</th>
                                                        <th>Status</th>
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
                                                                Referral Income
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <p class="mb-0 fw-bold">Rahul Sharma Joined</p>
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
                                                            <p class="fw-bold mb-0">REF10001</p>
                                                        </td>
                                                        <td>
                                                            <div class="p-1 text-success-emphasis bg-success-subtle border border-success-subtle rounded-3 text-center fw-bolder">
                                                                Credited
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
                                                            <div class="p-1 text-success-emphasis bg-success-subtle border border-success-subtle rounded-3 text-center fw-bolder">
                                                                Booking Wallet Transfer
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <p class="mb-0 fw-bold">Used for Booking #BK1020</p>
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
                                                            <p class="fw-bold mb-0">BK1020</p>
                                                        </td>
                                                        <td>
                                                            <div class="p-1 text-primary-emphasis bg-primary-subtle border border-primary-subtle rounded-3 text-center fw-bolder">
                                                                Used
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
                                                            <div class="p-1 text-success-emphasis bg-success-subtle border border-success-subtle rounded-3 text-center fw-bolder">
                                                                Package Discount
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <p class="mb-0 fw-bold">Used for Package Discount</p>
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
                                                            <p class="fw-bold mb-0">PKD3344</p>
                                                        </td>
                                                        <td>
                                                            <div class="p-1 text-primary-emphasis bg-primary-subtle border border-primary-subtle rounded-3 text-center fw-bolder">
                                                                Used
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
                                                            <div class="p-1 text-warning-emphasis bg-warning-subtle border border-warning-subtle rounded-3 text-center fw-bolder">
                                                                Withdrawal
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <p class="mb-0 fw-bold">Withdrawal to Bank (Txn ID: 4587)</p>
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
                                                            <p class="fw-bold mb-0">UP14587</p>
                                                        </td>
                                                        <td>
                                                            <div class="p-1 text-primary-emphasis bg-primary-subtle border border-primary-subtle rounded-3 text-center fw-bolder">
                                                                Apporved
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

                    loadWalletTransactions(
                        window.startDate,
                        window.endDate,
                        currentFilter
                    );
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
            /* =========================
            UTF-8 SAFE BASE64
            ========================= */
            function encodeBase64Unicode(str)
            {
                return btoa(unescape(encodeURIComponent(str)));
            }

            function decodeBase64Unicode(str)
            {
                return decodeURIComponent(escape(atob(str)));
            }

            /* =========================
            GLOBAL VARIABLE
            ========================= */
            let walletTable;

            /* =========================
            LOAD TRANSACTIONS
            ========================= */
            function loadWalletTransactions(startDate = '', endDate = '', filter = 'all')
            {
                $.ajax({
                    url: 'models/rw_view_table_data.php',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        customer_id: CUSTOMER_ID,
                        start_date: startDate,
                        end_date: endDate
                    },

                    beforeSend: function ()
                    {
                        if ($.fn.DataTable.isDataTable('#pendingCustomerList-table')) {
                            $('#pendingCustomerList-table').DataTable().destroy();
                        }

                        $('#pendingCustomerList-table tbody').html(`
                            <tr>
                                <td colspan="9" class="text-center py-4">
                                    Loading...
                                </td>
                            </tr>
                        `);
                    },

                    success: function (response)
                    {
                        let html = '';

                        if (!response.status || !response.data || response.data.length === 0)
                        {
                            $('#pendingCustomerList-table tbody').empty();

                            initializeDataTable();

                            return;
                        }

                        $.each(response.data, function(index, item)
                        {
                            let credit = '-';
                            let debit = '-';

                            const isDebit = item.entry_type === 'Withdrawal Request';

                            if (isDebit) {
                                debit = item.amount;
                            } else {
                                credit = item.amount;
                            }

                            /* FILTER */
                            if (filter === 'credit' && isDebit) return true;
                            if (filter === 'debit' && !isDebit) return true;

                            /* TYPE BADGE */
                            let typeClass = 'text-success-emphasis bg-success-subtle border border-success-subtle';

                            if (item.entry_type === 'Withdrawal Request') {
                                typeClass = 'text-warning-emphasis bg-warning-subtle border border-warning-subtle';
                            }

                            /* STATUS BADGE */
                            let statusClass = 'text-primary-emphasis bg-primary-subtle border border-primary-subtle';

                            if (item.status === 'Paid' || item.status === 'Success') {
                                statusClass = 'text-success-emphasis bg-success-subtle border border-success-subtle';
                            }

                            if (item.status === 'Cancelled') {
                                statusClass = 'text-danger-emphasis bg-danger-subtle border border-danger-subtle';
                            }

                            /* MEMBERS */
                            let membersHtml = '';

                            if (item.members && item.members.length > 0)
                            {
                                $.each(item.members, function(k, member)
                                {
                                    membersHtml += `
                                        <tr>
                                            <td>${member.name}</td>
                                            <td>${member.age}</td>
                                            <td>${member.gender}</td>
                                        </tr>
                                    `;
                                });
                            }
                            else
                            {
                                membersHtml = `
                                    <tr>
                                        <td colspan="3" class="text-center">No passenger details</td>
                                    </tr>
                                `;
                            }

                            /* DETAIL HTML */
                            let detailHtml = '';

                            if (item.entry_type === 'Trip Completed Bonus')
                            {
                                detailHtml = `
                                    <div class="row g-4">

                                        <div class="col-lg-4">
                                            <div class="card border-0 shadow-sm">
                                                <div class="card-body">

                                                    <h5 class="mb-4">
                                                        <i class="fa-solid fa-suitcase me-2"></i>
                                                        Trip Details
                                                    </h5>

                                                    <p><strong>Tour Name:</strong> ${item.trip_name}</p>
                                                    <p><strong>Destination:</strong><span class="text-break"> ${item.trip_destination}</span></p>
                                                    <p><strong>Travel Date:</strong> ${item.trip_start_date}</p>
                                                    <p><strong>Booking ID:</strong> ${item.reference_id}</p>
                                                    <p><strong>Booking Date:</strong> ${item.booking_date}</p>

                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-4">

                                            <div class="card border-0 shadow-sm">
                                                <div class="card-body">

                                                    <h5 class="mb-4">
                                                        <i class="fa-solid fa-users me-2"></i>
                                                        Passenger Details
                                                    </h5>

                                                    <div class="table-responsive">
                                                        <table class="table table-bordered">
                                                            <thead>
                                                                <tr>
                                                                    <th>Name</th>
                                                                    <th>Age</th>
                                                                    <th>Gender</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                ${membersHtml}
                                                            </tbody>
                                                        </table>
                                                    </div>

                                                </div>
                                            </div>

                                        </div>

                                    </div>
                                `;
                            }
                            else if (item.entry_type === 'Membership Activation Bonus')
                            {
                                detailHtml = `
                                    <div class="card border-0 shadow-sm">
                                        <div class="card-body">

                                            <h5 class="mb-3">Referral Bonus Details</h5>

                                            <div class="row">

                                                <div class="col-md-3">
                                                    <p><strong>Reference ID:</strong> ${item.reference_id}</p>
                                                    <p><strong>Reference Message:</strong> ${item.referral_message}</p>
                                                </div>

                                                <div class="col-md-3">
                                                    <p><strong>Bonus Earned:</strong> ₹${item.amount}</p>
                                                </div>

                                            </div>

                                        </div>
                                    </div>
                                `;
                            }
                            else
                            {
                                detailHtml = `
                                    <div class="card border-0 shadow-sm">
                                        <div class="card-body">

                                            <h5 class="mb-3">Withdrawal Details</h5>

                                            <div class="row">

                                                <div class="col-md-3">
                                                    <p><strong>Transaction ID:</strong> ${item.reference_id}</p>
                                                    <p><strong>Transaction Details:</strong> ${item.referral_message}</p>
                                                </div>

                                                <div class="col-md-3">
                                                    <p><strong>Amount:</strong> ₹${item.amount}</p>
                                                    <p><strong>Status:</strong> ${item.status}</p>
                                                </div>

                                            </div>

                                        </div>
                                    </div>
                                `;
                            }
                            const formattedMessage = (item.message ?? '')
                                .split(' ')
                                .reduce((result, word, index) => {
                                    return result + word + ((index + 1) % 8 === 0 ? '<br>' : ' ');
                                }, '');
                            html += `
                                <tr data-details="${encodeBase64Unicode(detailHtml)}">

                                    <td>${item.created_date}</td>

                                    <td>
                                        <div class="${typeClass} rounded-3 text-center fw-bolder p-1">
                                            ${item.entry_type}
                                        </div>
                                    </td>

                                    <td>${formattedMessage}</td>

                                    <td class="text-end text-success fw-bold">
                                        ${credit !== '-' ? '+' + credit : '-'}
                                    </td>

                                    <td class="text-end text-danger fw-bold">
                                        ${debit !== '-' ? '-' + debit : '-'}
                                    </td>
                                    <td class="text-end fw-bold">${item.balance}</td>

                                    <td>${item.reference_id}</td>

                                    <td>
                                        <div class="p-1 ${statusClass} rounded-3 text-center fw-bolder">
                                            ${item.status}
                                        </div>
                                    </td>

                                    <td class="text-center">
                                        <button class="toggle-btn btn btn-sm btn-light">
                                            <i class="fa-solid fa-chevron-down"></i>
                                        </button>
                                    </td>

                                </tr>
                            `;
                        });

                        $('#pendingCustomerList-table tbody').html(html);

                        initializeDataTable();
                    }
                });
            }

            /* =========================
            DATATABLE INIT (FIXED)
            ========================= */
            function initializeDataTable()
            {
                walletTable = $('#pendingCustomerList-table').DataTable({
                    responsive: false,
                    scrollX: true,
                    autoWidth: false,
                    pageLength: 10,
                    searching: true,
                    ordering: true,
                    info: true,
                    destroy: true,
                    order: [[0, 'desc']],
                    language: {
                        emptyTable: "No wallet transactions found.",
                        zeroRecords: "No matching records found."
                    },
                    columnDefs: [
                        { targets: 0, width: "140px" },
                        { targets: 1, width: "180px" },
                        { targets: 2, width: "260px" },
                        { targets: 3, width: "120px" },
                        { targets: 4, width: "120px" },
                        { targets: 5, width: "120px" },
                        { targets: 6, width: "160px" },
                        { targets: 7, width: "140px" },
                        { targets: 8, width: "80px" }
                    ]
                });
            }

            /* =========================
            ROW EXPAND
            ========================= */
            $(document).on('click', '.toggle-btn', function ()
            {
                const tr = $(this).closest('tr');
                const row = walletTable.row(tr);
                const icon = $(this).find('i');

                if (row.child.isShown())
                {
                    row.child.hide();
                    tr.removeClass('shown');

                    icon.removeClass('fa-chevron-up')
                        .addClass('fa-chevron-down');
                }
                else
                {
                    row.child(
                        decodeBase64Unicode(tr.attr('data-details'))
                    ).show();

                    tr.addClass('shown');

                    icon.removeClass('fa-chevron-down')
                        .addClass('fa-chevron-up');
                }
            });

            /* =========================
            FILTER
            ========================= */
            let currentFilter = 'all';

            $('.filter-btn').on('click', function ()
            {
                $('.filter-btn').removeClass('active');
                $(this).addClass('active');

                currentFilter = $(this).data('filter');

                if (currentFilter === 'travel') currentFilter = 'credit';
                if (currentFilter === 'bank') currentFilter = 'debit';

                loadWalletTransactions(startDate, endDate, currentFilter);
            });

            /* =========================
            INIT
            ========================= */
            $(document).ready(function ()
            {
                window.startDate = startDate;
                window.endDate = endDate;
                loadWalletTransactions(startDate, endDate,currentFilter);
            });
           function downloadWalletSummary()
            {
                let form = $('<form>', {
                    action: 'models/export_referral_wallet_summary.php',
                    method: 'POST'
                });

                form.append(
                    $('<input>', {
                        type: 'hidden',
                        name: 'customer_id',
                        value: CUSTOMER_ID
                    })
                );

                form.append(
                    $('<input>', {
                        type: 'hidden',
                        name: 'start_date',
                        value: window.startDate
                    })
                );

                form.append(
                    $('<input>', {
                        type: 'hidden',
                        name: 'end_date',
                        value: window.endDate
                    })
                );

                $('body').append(form);

                form.submit();

                form.remove();
            }
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