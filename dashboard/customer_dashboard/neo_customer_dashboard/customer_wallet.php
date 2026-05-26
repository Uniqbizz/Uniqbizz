<?php
    include_once (__DIR__ .'/../../dashboard_user_details.php');
    include (__DIR__ .'/../customer_model.php');
    include (__DIR__.'/../urls.php');

?>
<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable">
    <head>
        <meta charset="utf-8" />
        <title>Dashboard | Uniqbizz</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- App favicon -->
        <link rel="shortcut icon" href="<?= $base_url ?>assets/images/fav.png">

        <!-- jsvectormap css -->
        <link href="<?= $base_url ?>assets/libs/jsvectormap/css/jsvectormap.min.css" rel="stylesheet" type="text/css" />

        <!--Swiper slider css-->
        <link href="<?= $base_url ?>assets/libs/swiper/swiper-bundle.min.css" rel="stylesheet" type="text/css" />

        <!-- Layout config Js -->
        <script src="<?= $base_url ?>assets/js/layout.js"></script>
        <!-- Bootstrap Css -->
        <link href="<?= $base_url ?>assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <!-- Icons Css -->
        <link href="<?= $base_url ?>assets/css/icons.min.css" rel="stylesheet" type="text/css" />
        <!-- App Css-->
        <link href="<?= $base_url ?>assets/css/app.min.css" rel="stylesheet" type="text/css" />
        <!-- custom Css-->
        <link href="<?= $base_url ?>assets/css/custom.min.css" rel="stylesheet" type="text/css" />
        <!-- custom Css developer-->
        <link rel="stylesheet" href="<?= $base_url ?>assets/css/custom.css" />
        <!-- Customer Dashboard CSS -->
        <link rel="stylesheet" href="<?= $base_url ?>assets/css/customer_dashboard.css" />

        <!-- FontAwesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel="stylesheet" href="<?= $base_url ?>assets/css/neo_select/customer_wallet_custom.css" />
        <link rel="stylesheet" href="<?= $base_url ?>assets/css/neo_select/coupon_wallet_modal.css" />
        <link rel="stylesheet" href="<?= $base_url ?>assets/css/neo_select/earn_coupon_modal.css" />
        <link rel="stylesheet" href="<?= $base_url ?>assets/css/neo_select/customer_reference_modal.css" />
        <link rel="stylesheet" href="<?= $base_url ?>assets/css/neo_select/customer_discount_modal.css" />
    </head>

    <body class="twocolumn-panel">
        <!-- Begin page -->
        <div id="layout-wrapper">
            <?php include_once(__DIR__ . '/../customer_header.php'); ?>

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

            <?php include_once (__DIR__ . '/../customer_sidebar.php') ?>
            <!-- ============================================================== -->
            <!-- Start of Customer Dashboard here -->
            <!-- ============================================================== -->
            <div class="main-content">
                <div class="page-content">
                    <div class="container-fluid ps-0">
                        <div class="wallet-page">

                            <h1 class="page-title">My Wallets</h1>

                            <p class="page-subtitle">
                                All your balances, benefits & rewards in one place.
                            </p>

                            <!-- INFO BAR -->

                            <div class="wallet-info">

                                <div class="wallet-info-left">
                                    <i class="fa-solid fa-circle-info"></i>
                                    <span>Use your wallets while booking packages, flights, hotels, events and weekend escapes.</span>
                                </div>

                                <div class="wallet-info-right">
                                    <i class="fa-solid fa-circle-info"></i>
                                    <span>Benefits are subject to terms & conditions.</span>
                                </div>

                            </div>

                            <!-- SUMMARY CARDS -->

                            <div class="row g-4">

                                <!-- COUPON -->

                                <div class="col-lg-3 col-md-6">

                                    <div class="wallet-summary-card purple coupon-wallet position-relative overflow-hidden">

                                        <!-- Watermark Icon -->
                                        <div class="wallet-watermark purple-watermark">
                                            <i class="fa-solid fa-ticket"></i>
                                        </div>

                                        <div class="d-flex align-items-center gap-3 position-relative z-1">

                                            <div class="wallet-icon flex-shrink-0">
                                                <i class="fa-solid fa-ticket"></i>
                                            </div>

                                            <p class="wallet-heading purple-title mb-0">
                                                Coupon Wallet
                                            </p>

                                        </div>

                                        <div class="position-relative z-1">

                                            <div class="d-flex align-items-center">

                                                <div>
                                                    <div class="wallet-stat-label">
                                                        Total Coupons : <span class="wallet-stat text-dark"><?= $couponData['coupon_total'] ?></span>
                                                    </div>
                                                </div>

                                                
                                            </div>
                                            <div>
                                                <div class="wallet-stat-label">
                                                    Available : <span class="wallet-stat text-dark"><?= $couponData['active_coupon_total'] ?></span>
                                                </div>
                                            </div>

                                            <div class="wallet-divider"></div>

                                            <div class="wallet-stat-label">
                                                Total Value
                                            </div>

                                            <div class="wallet-total purple-title">
                                                ₹15,000
                                            </div>

                                            <a href="customer_coupon_wallet_list.php" class="btn wallet-btn">
                                                View Coupons
                                            </a>

                                        </div>

                                    </div>

                                </div>

                                <!-- LOYALTY -->

                                <div class="col-lg-3 col-md-6">

                                    <div class="wallet-summary-card green loyalty-wallet position-relative overflow-hidden">

                                        <!-- Watermark Icon -->
                                        <div class="wallet-watermark green-watermark">
                                            <i class="fa-solid fa-award"></i>
                                        </div>

                                        <div class="d-flex align-items-center gap-3 position-relative z-1">

                                            <div class="wallet-icon flex-shrink-0">
                                                <i class="fa-solid fa-award"></i>
                                            </div>

                                            <p class="wallet-heading green-title mb-0 pe-4">
                                                Loyalty Coupons
                                            </p>

                                        </div>

                                        <div class="position-relative z-1">

                                            <div class="d-flex align-items-center">

                                                <div>
                                                    <div class="wallet-stat-label">
                                                        Total Coupons : <span class="wallet-stat text-dark">12</span>
                                                    </div>
                                                </div>

                                                
                                            </div>
                                            <div>
                                                <div class="wallet-stat-label">
                                                    Available : <span class="wallet-stat text-dark">7</span>
                                                </div>
                                            </div>

                                            <div class="wallet-divider"></div>

                                            <div class="wallet-stat-label">
                                                Total Value
                                            </div>

                                            <div class="wallet-total green-title">
                                                ₹3,500
                                            </div>
                                            <a href="customer_layalty_coupon.php" class="btn wallet-btn">
                                                View Loyalty Coupons
                                            </a>

                                        </div>

                                    </div>

                                </div>

                                <!-- REFERRAL -->

                                <div class="col-lg-3 col-md-6">

                                    <div class="wallet-summary-card orange referral-wallet position-relative overflow-hidden">

                                        <!-- Watermark Icon -->
                                        <div class="wallet-watermark">
                                            <i class="fa-solid fa-users"></i>
                                        </div>

                                        <div class="d-flex align-items-center gap-3 position-relative z-1">

                                            <div class="wallet-icon flex-shrink-0">
                                                <i class="fa-solid fa-users"></i>
                                            </div>

                                            <p class="wallet-heading orange-title mb-0 pe-4">
                                                Referral Customer Wallet
                                            </p>

                                        </div>

                                        <div class="position-relative z-1">

                                            <div class="wallet-stat-label">Wallet Balance</div>
                                            <div class="wallet-stat orange-title">
                                                <span>₹2,300</span>
                                            </div>

                                            <div class="wallet-stat-label mt-4 custom-tight-space">Withdrawable</div>
                                            <div class="wallet-total">₹1,800</div>
                                            <a href="customer_reference_wallet.php" class="btn wallet-btn">
                                                View Transactions
                                            </a>

                                        </div>

                                    </div>

                                </div>

                                <!-- DISCOUNT -->

                                <div class="col-lg-3 col-md-6">

                                    <div class="wallet-summary-card blue discount-wallet position-relative overflow-hidden">

                                        <!-- Watermark Icon -->
                                        <div class="wallet-watermark blue-watermark">
                                            <i class="fa-solid fa-tags"></i>
                                        </div>

                                        <div class="d-flex align-items-center gap-3 position-relative z-1">

                                            <div class="wallet-icon flex-shrink-0">
                                                <i class="fa-solid fa-tags"></i>
                                            </div>

                                            <p class="wallet-heading blue-title mb-0 pe-4">
                                                Discount Wallet
                                            </p>

                                        </div>

                                        <div class="position-relative z-1">

                                            <div class="wallet-stat-label">Wallet Balance</div>
                                            <div class="wallet-stat blue-title">₹1,200</div>

                                            <div class="wallet-stat-label mt-4 custom-tight-space">Usable Balance</div>
                                            <div class="wallet-total">₹1,200</div>
                                            <a href="customer_discount_wallet.php" class="btn wallet-btn">
                                                View Transactions
                                            </a>

                                        </div>

                                    </div>

                                </div>

                            </div>

                            <!-- ACTIVITY CARD -->

                            <div class="wallet-sections">

                                <!-- ================= COUPON WALLET ================= -->

                                <div class="activity-card purple-border">

                                    <div class="row g-0">

                                        <div class="col-lg-3">

                                            <div class="activity-side">

                                                <div class="activity-side-icon purple-bg">
                                                    <i class="fa-solid fa-ticket"></i>
                                                </div>

                                                <div class="activity-title purple-text">
                                                    Coupon Wallet
                                                </div>

                                                <div class="activity-desc">
                                                    Use coupons to get instant discount on eligible bookings.
                                                </div>

                                                <a href="#" class="activity-link purple-text" id="openCouponModal">
                                                    How to Use?
                                                </a>

                                            </div>

                                        </div>

                                        <div class="col-lg-9">

                                            <div class="activity-body">

                                                <div class="d-flex justify-content-between align-items-center mb-4">

                                                    <h4 class="fw-bold mb-0">Recent Activity</h4>

                                                    <a href="customer_coupon_wallet_list.php" class="text-decoration-none fw-semibold purple-text">
                                                        View All Coupons →
                                                    </a>

                                                </div>

                                                <div class="table-responsive">

                                                    <table class="table align-middle">

                                                        <thead>
                                                            <tr>
                                                                <th>Date</th>
                                                                <th>Description</th>
                                                                <th>Type</th>
                                                                <th>Coupons</th>
                                                                <th>Value</th>
                                                            </tr>
                                                        </thead>

                                                        <tbody id="recentActivityBody" class="recentActivityTableBody" data-card-type="pcw">
                                                            <tr>
                                                                <td>02 Jun 2024</td>

                                                                <td>
                                                                    <strong>Used on Maldives Paradise</strong><br>
                                                                    <small class="text-muted">
                                                                        Booking ID: BK240601
                                                                    </small>
                                                                </td>

                                                                <td>
                                                                    <span class="debited">Used</span>
                                                                </td>

                                                                <td class="text-danger fw-bold">-4</td>

                                                                <td class="text-danger fw-bold">₹2,000</td>
                                                            </tr>
                                                            <tr>
                                                                <td>25 May 2024</td>

                                                                <td>
                                                                    <strong>Used on Bali Bliss Trip</strong><br>
                                                                    <small class="text-muted">
                                                                        Booking ID: BK240521
                                                                    </small>
                                                                </td>

                                                                <td>
                                                                    <span class="debited">Used</span>
                                                                </td>

                                                                <td class="text-danger fw-bold">-8</td>

                                                                <td class="text-danger fw-bold">₹4,000</td>
                                                            </tr>
                                                            <tr>
                                                                <td>20 May 2024</td>

                                                                <td>
                                                                    <strong>Membership Activation Bonus</strong><br>
                                                                    <small class="text-muted">
                                                                        30 Coupons credited on membership activation
                                                                    </small>
                                                                </td>

                                                                <td>
                                                                    <span class="credited">Credited</span>
                                                                </td>

                                                                <td class="text-success fw-bold">+30</td>

                                                                <td class="text-success fw-bold">₹15,000</td>
                                                            </tr>

                                                            

                                                            

                                                        </tbody>

                                                    </table>

                                                </div>

                                            </div>

                                        </div>

                                    </div>

                                    <div class="feature-bar">

                                        <div class="row text-center g-3">

                                            <div class="col-md-4">
                                                <div class="feature-item justify-content-center">
                                                    <i class="fa-solid fa-coins purple-text"></i>
                                                    1 Coupon = ₹500
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="feature-item justify-content-center">
                                                    <i class="fa-solid fa-user-group purple-text"></i>
                                                    1 Coupon per passenger per booking
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="feature-item justify-content-center">
                                                    <i class="fa-solid fa-ban purple-text"></i>
                                                    Cannot be encashed or transferred
                                                </div>
                                            </div>

                                        </div>

                                    </div>

                                </div>

                                <!-- ================= LOYALTY WALLET ================= -->

                                <div class="activity-card green-border">

                                    <div class="row g-0">

                                        <div class="col-lg-3">

                                            <div class="activity-side">

                                                <div class="activity-side-icon green-bg">
                                                    <i class="fa-solid fa-award"></i>
                                                </div>

                                                <div class="activity-title green-text">
                                                    Loyalty Coupons
                                                </div>

                                                <div class="activity-desc">
                                                    Earn loyalty coupons after completing your trips.
                                                </div>

                                                <a href="#" class="activity-link green-text" id="openEarnCouponModal">
                                                    How to Earn?
                                                </a>

                                            </div>

                                        </div>

                                        <div class="col-lg-9">

                                            <div class="activity-body">

                                                <div class="d-flex justify-content-between align-items-center mb-4">

                                                    <h4 class="fw-bold mb-0">Recent Activity</h4>

                                                    <a href="customer_layalty_coupon.php" class="text-decoration-none fw-semibold green-text">
                                                        View All Loyalty Coupons →
                                                    </a>

                                                </div>

                                                <div class="table-responsive">

                                                    <table class="table align-middle">

                                                        <thead>
                                                            <tr>
                                                                <th>Date</th>
                                                                <th>Description</th>
                                                                <th>Type</th>
                                                                <th>Coupons</th>
                                                                <th>Value</th>
                                                            </tr>
                                                        </thead>

                                                        <tbody>
                                                            <tr>
                                                                <td>22 Jun 2024</td>

                                                                <td>
                                                                    <strong>Used on Manali Getaway</strong><br>
                                                                    <small class="text-muted">
                                                                        Booking ID: BK240622
                                                                    </small>
                                                                </td>

                                                                <td>
                                                                    <span class="debited">Used</span>
                                                                </td>

                                                                <td class="text-danger fw-bold">-2</td>

                                                                <td class="text-danger fw-bold">₹1,000</td>
                                                            </tr>
                                                            <tr>
                                                                <td>15 Jun 2024</td>

                                                                <td>
                                                                    <strong>Loyalty Reward – Kerala Backwaters</strong><br>
                                                                    <small class="text-muted">
                                                                        Trip completed for 3 passengers
                                                                    </small>
                                                                </td>

                                                                <td>
                                                                    <span class="credited">Expired</span>
                                                                </td>

                                                                <td class="text-success fw-bold">+3</td>

                                                                <td class="text-success fw-bold">₹1,500</td>
                                                            </tr>
                                                            <tr>
                                                                <td>28 May 2024</td>

                                                                <td>
                                                                    <strong>Loyalty Reward – Bali Bliss</strong><br>
                                                                    <small class="text-muted">
                                                                        Trip completed for 4 passengers
                                                                    </small>
                                                                </td>

                                                                <td>
                                                                    <span class="credited">Credited</span>
                                                                </td>

                                                                <td class="text-success fw-bold">+4</td>

                                                                <td class="text-success fw-bold">₹2,000</td>
                                                            </tr>
                                                        </tbody>

                                                    </table>

                                                </div>

                                            </div>

                                        </div>

                                    </div>

                                    <div class="feature-bar">

                                        <div class="row text-center g-3">

                                            <div class="col-md-4">
                                                <div class="feature-item justify-content-center">
                                                    <i class="fa-solid fa-indian-rupee-sign green-text"></i>
                                                    ₹500 per passenger travelled
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="feature-item justify-content-center">
                                                    <i class="fa-solid fa-calendar green-text"></i>
                                                    Valid for 12 months from date of credit
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="feature-item justify-content-center">
                                                    <i class="fa-solid fa-briefcase green-text"></i>
                                                    Usable on eligible bookings only
                                                </div>
                                            </div>

                                        </div>

                                    </div>

                                </div>

                                <!-- ================= REFERRAL WALLET ================= -->

                                <div class="activity-card orange-border">

                                    <div class="row g-0">

                                        <div class="col-lg-3">

                                            <div class="activity-side">

                                                <div class="activity-side-icon orange-bg">
                                                    <i class="fa-solid fa-users"></i>
                                                </div>

                                                <div class="activity-title orange-text">
                                                    Referral Customer Wallet
                                                </div>

                                                <div class="activity-desc">
                                                    Earn wallet balance by referring customers and their travel.
                                                </div>

                                                <a href="#" class="activity-link orange-text" id="openReferralModal">
                                                    How it Works?
                                                </a>

                                            </div>

                                        </div>

                                        <div class="col-lg-9">

                                            <div class="activity-body">

                                                <div class="d-flex justify-content-between align-items-center mb-4">

                                                    <h4 class="fw-bold mb-0">Recent Activity</h4>

                                                    <a href="customer_reference_wallet.php" class="text-decoration-none fw-semibold orange-text">
                                                        View All Transactions →
                                                    </a>

                                                </div>

                                                <div class="table-responsive">

                                                    <table class="table align-middle">

                                                        <thead>
                                                            <tr>
                                                                <th>Date</th>
                                                                <th>Description</th>
                                                                <th>Type</th>
                                                                <th>Amount</th>
                                                                <th>Balance</th>
                                                            </tr>
                                                        </thead>

                                                        <tbody>
                                                            <tr>
                                                                <td>28 Jun 2024</td>

                                                                <td>
                                                                    <strong>Withdrawal Request</strong><br>
                                                                    <small class="text-muted">
                                                                        Reference ID: WD240628
                                                                    </small>
                                                                </td>

                                                                <td>
                                                                    <span class="debited">Withdrawn</span>
                                                                </td>

                                                                <td class="text-danger fw-bold">-₹1,200</td>

                                                                <td class="text-danger fw-bold">₹1,000</td>
                                                            </tr>
                                                            <tr>
                                                                <td>05 Jun 2024</td>

                                                                <td>
                                                                    <strong>Referred Customer Trip Completed</strong><br>
                                                                    <small class="text-muted">
                                                                        Booking ID: BK240605
                                                                    </small>
                                                                </td>

                                                                <td>
                                                                    <span class="credited">Credited</span>
                                                                </td>

                                                                <td class="text-success fw-bold">+₹1,500</td>

                                                                <td class="text-success fw-bold">₹2,500</td>
                                                            </tr>
                                                            <tr>
                                                                <td>18 May 2024</td>

                                                                <td>
                                                                    <strong>Direct Referral Bonus</strong><br>
                                                                    <small class="text-muted">
                                                                        Referral ID: REF240518
                                                                    </small>
                                                                </td>

                                                                <td>
                                                                    <span class="credited">Credited</span>
                                                                </td>

                                                                <td class="text-success fw-bold">+₹1,000</td>

                                                                <td class="text-success fw-bold">₹3,500</td>
                                                            </tr>
                                                        </tbody>

                                                    </table>

                                                </div>

                                            </div>

                                        </div>

                                    </div>

                                    <div class="feature-bar">

                                        <div class="row text-center g-3">

                                            <div class="col-md-3">
                                                <div class="feature-item justify-content-center">
                                                    <i class="fa-solid fa-users orange-text"></i>
                                                    Earn by referring customers
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="feature-item justify-content-center">
                                                    <i class="fa-solid fa-gift orange-text"></i>
                                                    Additional benefit on trip completion
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="feature-item justify-content-center">
                                                    <i class="fa-solid fa-wallet orange-text"></i>
                                                    Usable on all travel services
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="feature-item justify-content-center">
                                                    <i class="fa-solid fa-money-bill-transfer orange-text"></i>
                                                    Withdrawable as per policy
                                                </div>
                                            </div>

                                        </div>

                                    </div>

                                </div>

                                <!-- ================= DISCOUNT WALLET ================= -->

                                <div class="activity-card blue-border">

                                    <div class="row g-0">

                                        <div class="col-lg-3">

                                            <div class="activity-side">

                                                <div class="activity-side-icon blue-bg">
                                                    <i class="fa-solid fa-tags"></i>
                                                </div>

                                                <div class="activity-title blue-text">
                                                    Discount Wallet
                                                </div>

                                                <div class="activity-desc">
                                                    Earn discount balance on repeat bookings by referrals.
                                                </div>

                                                <a href="#"
                                                    id="neoxdwOpenModalBtn"
                                                    class="activity-link blue-text">
                                                        How it Works?
                                                </a>

                                            </div>

                                        </div>

                                        <div class="col-lg-9">

                                            <div class="activity-body">

                                                <div class="d-flex justify-content-between align-items-center mb-4">

                                                    <h4 class="fw-bold mb-0">Recent Activity</h4>

                                                    <a href="customer_discount_wallet.php" class="text-decoration-none fw-semibold blue-text">
                                                        View All Transactions →
                                                    </a>

                                                </div>

                                                <div class="table-responsive">

                                                    <table class="table align-middle">

                                                        <thead>
                                                            <tr>
                                                                <th>Date</th>
                                                                <th>Description</th>
                                                                <th>Type</th>
                                                                <th>Amount</th>
                                                                <th>Balance</th>
                                                            </tr>
                                                        </thead>

                                                        <tbody>
                                                            <tr>
                                                                <td>30 Jun 2024</td>

                                                                <td>
                                                                    <strong>Used on Goa Beach Escape</strong><br>
                                                                    <small class="text-muted">
                                                                        Booking ID: BK240630
                                                                    </small>
                                                                </td>

                                                                <td>
                                                                    <span class="debited">Debited</span>
                                                                </td>

                                                                <td class="text-danger fw-bold">-₹800</td>

                                                                <td class="text-danger fw-bold">₹400</td>
                                                            </tr>
                                                            <tr>
                                                                <td>25 Jun 2024</td>

                                                                <td>
                                                                    <strong>Repeat Booking by Referred Customer</strong><br>
                                                                    <small class="text-muted">
                                                                        Booking ID: BK240625
                                                                    </small>
                                                                </td>

                                                                <td>
                                                                    <span class="credited">Credited</span>
                                                                </td>

                                                                <td class="text-success fw-bold">+₹500</td>

                                                                <td class="text-success fw-bold">₹1,200</td>
                                                            </tr>
                                                            <tr>
                                                                <td>10 Jun 2024</td>

                                                                <td>
                                                                    <strong>Repeat Booking by Referred Customer</strong><br>
                                                                    <small class="text-muted">
                                                                        Booking ID: BK240610
                                                                    </small>
                                                                </td>

                                                                <td>
                                                                    <span class="credited">Credited</span>
                                                                </td>

                                                                <td class="text-success fw-bold">+₹700</td>

                                                                <td class="text-success fw-bold">₹1,900</td>
                                                            </tr>
                                                        </tbody>

                                                    </table>

                                                </div>

                                            </div>

                                        </div>

                                    </div>

                                    <div class="feature-bar">

                                        <div class="row text-center g-3">

                                            <div class="col-md-4">
                                                <div class="feature-item justify-content-center">
                                                    <i class="fa-solid fa-repeat blue-text"></i>
                                                    Earn on repetitive bookings
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="feature-item justify-content-center">
                                                    <i class="fa-solid fa-calendar-check blue-text"></i>
                                                    Usable on packages, flights & hotels
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="feature-item justify-content-center">
                                                    <i class="fa-solid fa-ban blue-text"></i>
                                                    Cannot be encashed or transferred
                                                </div>
                                            </div>

                                        </div>

                                    </div>

                                </div>

                            </div>

                            <!-- NOTE -->

                            <div class="note-box">
                                <i class="fa-solid fa-circle-info me-2"></i>
                                Note: Wallet balances and benefits are subject to company policy, verification & terms and conditions.
                            </div>
                        </div>
                    </div>
                </div>
                <?php include_once (__DIR__ . '/../customer_footer.php') ?>
            </div>

            <!-- end main content-->
            <!-- End of Customer Dashboard here -->
            <!-- ============================================================== -->
        </div>
        <!--start back-to-top-->
        <button onclick="topFunction()" class="scrollToTop scroll-btn show btn" id="back-to-top">
            <i class="ri-arrow-up-line"></i>
        </button>
        <!-- modals -->
         <?= include 'coupon_wallet_model.php' ?>
         <?= include 'earn_coupon_modal.php' ?>
         <?= include 'customer_discount_modal.php' ?>
         <?= include 'customer_reference_modal.php' ?>
        <!--end back-to-top-->
        <!-- contact card pop up  start-->
        <button type="button" class="contactBtn btn" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
            <i class="ri-phone-fill"></i>
        </button>
        <?php include (__DIR__ .'/../../contact_modal.php') ?>

        <!-- contact card pop up end-->

        <!-- JAVASCRIPT -->
        <script src="<?= $base_url ?>assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="<?= $base_url ?>assets/libs/simplebar/simplebar.min.js"></script>
        <script src="<?= $base_url ?>assets/libs/node-waves/waves.min.js"></script>
        <script src="<?= $base_url ?>assets/libs/feather-icons/feather.min.js"></script>
        <script src="<?= $base_url ?>assets/js/jquery/jquery-3.7.1.min.js"></script>

        <!-- !-- materialdesign remix icon js- -->
        <script src="<?= $base_url ?>assets/js/pages/remix-icons-listing.js"></script>

        <!-- Vector map-->
        <script src="<?= $base_url ?>assets/libs/jsvectormap/js/jsvectormap.min.js"></script>
        <script src="<?= $base_url ?>assets/libs/jsvectormap/maps/world-merc.js"></script>

        <!--Swiper slider js-->
        <script src="<?= $base_url ?>assets/libs/swiper/swiper-bundle.min.js"></script>

        <!-- App js -->
        <script src="<?= $base_url ?>assets/js/app.js"></script>

        <script src="<?= $base_url ?>assets/libs/chart.js/Chart-2.5.0.min.js"></script>


        <!-- Dashboard init  popular candidates section js file-->
        <script src="<?= $base_url ?>assets/js/pages/dashboard-job.init.js"></script>

        <script src="<?= $base_url ?>assets/js/js-confetti.js"></script>

        <!-- <script>
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
        </script> -->
        
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
        <!-- <script>
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
        </script> -->
        <script>
            // RECENT ACTIVITY AJAX
            $(".recentActivityTableBody").each(function(){

                const tableBody =
                    $(this);

                const tableBodyId =
                    tableBody.attr("id");

                const cardType =
                    tableBody.data("card-type");

                $.ajax({

                    url: "<?= $base_url_cust ?>ajax/recent_activity_card.php",

                    type: "POST",

                    data: {
                        card_type: cardType
                    },

                    dataType: "json",

                    success: function(response) {

                        if(response.status && response.data) {

                            const coupons =
                                response.data.all_coupons;

                            let html = "";

                            // EMPTY
                            if(coupons.length === 0) {

                                html += `
                                    <tr>
                                        <td colspan="5"
                                            class="text-center py-4 fw-bold text-muted">
                                            No Recent Activity Found
                                        </td>
                                    </tr>
                                `;
                            }

                            // LOOP
                            else {

                                coupons.forEach(function(item){

                                    const isUsed =
                                        parseInt(item.usage_status) === 1;

                                    // DATE
                                    const activityDate =
                                        item.used_date ||
                                        item.created_date;

                                    const formattedDate =
                                        new Date(activityDate)
                                        .toLocaleDateString("en-GB", {
                                            day: "2-digit",
                                            month: "short",
                                            year: "numeric"
                                        });

                                    // STATUS
                                    const statusText =
                                        isUsed
                                        ? "Used"
                                        : "Credited";

                                    const statusClass =
                                        isUsed
                                        ? "debited"
                                        : "credited";

                                    // VALUE
                                    const valuePrefix =
                                        isUsed
                                        ? "-"
                                        : "+";

                                    // DESCRIPTION
                                    const description =
                                        isUsed
                                        ? `Coupon Utilized On Booking Of ${item.used_on}`
                                        : "Membership Activation Bonus";

                                    // SUBTEXT
                                    const subText =
                                        item.transaction_id
                                        ? `Transaction ID: ${item.transaction_id}`
                                        : "Coupon Credited";

                                    html += `
                                        <tr>

                                            <td>
                                                ${formattedDate}
                                            </td>

                                            <td>

                                                <strong>
                                                    ${description}
                                                </strong>

                                                <br>

                                                <small class="text-muted">
                                                    ${subText}
                                                </small>

                                            </td>

                                            <td>

                                                <span class="${statusClass}">
                                                    ${statusText}
                                                </span>

                                            </td>

                                            <td class="
                                                ${isUsed
                                                    ? 'text-danger'
                                                    : 'text-success'}
                                                fw-bold
                                            ">
                                                ${valuePrefix}1
                                            </td>

                                            <td class="
                                                ${isUsed
                                                    ? 'text-danger'
                                                    : 'text-success'}
                                                fw-bold
                                            ">
                                                ₹${item.coupon_amt}
                                            </td>

                                        </tr>
                                    `;
                                });
                            }

                            // APPEND TO CURRENT TABLE
                            $("#" + tableBodyId).html(html);
                        }
                    }
                });
            });
        </script>

        <!-- dialer logic -->
    </body>
</html>