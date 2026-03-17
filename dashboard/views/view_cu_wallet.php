<?php
include_once '../dashboard_user_details.php';
$date = date('F,Y'); //month and year. 'F' - month in Text form
$DateMonth = date('m'); //month in number form
$DateYear = date('Y'); //year
if ($userType == 10){
    $sqlcust = 'SELECT customer_type FROM ca_customer WHERE ca_customer_id = :user';
    $stmt = $conn->prepare($sqlcust);
    $stmt->execute([':user' => $userId]);

    $customer_type = $stmt->fetchColumn();

}
?>
<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable">

<head>

    <meta charset="utf-8" />
    <title>Admin Dashboard | Customer</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- App favicon -->
    <link rel="shortcut icon" href="../assets/images/fav.png">

    <!-- jsvectormap css -->
    <link href="../assets/libs/jsvectormap/css/jsvectormap.min.css" rel="stylesheet" type="text/css" />

    <!--Swiper slider css-->
    <link href="../assets/libs/swiper/swiper-bundle.min.css" rel="stylesheet" type="text/css" />

    <!-- DataTables -->
    <link href="../assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <!-- Responsive datatable examples -->
    <link href="../assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />

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
    <!-- font-awesome -->
    <link rel="stylesheet" href="../assets/fontawesome/css/all.min.css" />
    <style>
        .wallet-tab {
            cursor: pointer;
            transition: box-shadow 0.3s ease;
        }

        .wallet-tab:hover {
            background-color: #3f5866; /* optional */
        }

        .selected-tab {
            box-shadow: 0 6px 12px rgba(63, 88, 102, 0.9); /* stronger bottom shadow */
        }
    </style>





</head>

<body>

    <!-- Begin page -->
    <div id="layout-wrapper">

        <?php include_once '../header.php'; ?>

        <?php include '../notification_card.php'?>
        <!-- ========== App Menu ========== -->

        <?php include_once '../sidebar.php'; ?>

        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">
            <?php if ($userType == "10") { ?>
                <div class="page-content">
                    <div class="container-fluid">
                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                    <h4 class="mb-sm-0">View Customer Wallets</h4>

                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                                            <li class="breadcrumb-item active">View Customer Wallets</li>
                                        </ol>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div  class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div id='redeemable_wallet_div' class="card rounded-4 pt-3 pb-2 px-4 cardBg1 wallet-tab selected-tab">
                                    <div>
                                        <p class="text-white fw-bold">Redeemable Amount</p>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <span class="">
                                            <i class="fa-regular fa-user fa-2xl" style="color: #ffffff;"></i>
                                        </span>
                                        <div class="ms-4">
                                            <!-- data load from models file -->
                                            <?php include '../models/customer_wallet/all_ramt_card.php' ?>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <p class="text-white">This Month</p>
                                        <!-- data load from models file -->
                                        <?php include '../models/customer_wallet/ramt_month_card.php' ?>

                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12 <?=in_array($customer_type, ['Free', 'Premium', 'Prime']) ? 'd-none' : '' ?>">
                                <div id='booking_wallet_div' class="card rounded-4 pt-3 pb-2 px-4 cardBg2 wallet-tab">
                                    <div>
                                        <p class="text-white fw-bold">Booking Points</p>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <span class="">
                                            <i class="fa-regular fa-map fa-2xl" style="color: #ffffff;"></i>
                                        </span>
                                        <div class="ms-4">
                                            <!-- data load from models file -->
                                            <?php include '../models/customer_wallet/all_booking_points.php' ?>

                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <p class="text-white">This Month</p>
                                        <!-- data load from models file -->
                                        <?php include '../models/customer_wallet/booking_points_month.php' ?>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end page title -->
                        <?php if ($customer_type!='Free' || $customer_type!='Premium' || $customer_type!='Prime'){?>
                        <div class="row ">
                            <!-- booking wallet table -->
                            <div id ='booking_ponits_table_div' class="col <?= in_array($customer_type, ['Free', 'Premium', 'Prime']) ? 'd-none' : '' ?>">

                                <div class="h-100">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="card">
                                                <div class="card-header border-bottom-dashed">
                                                    <div class="row g-4 align-items-center">
                                                        <div class="col-sm">
                                                            <div>
                                                                <h5 class="card-title mb-0">Booking Points Wallet History</h5>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card-body">
                                                    <table id="example-dataTable1" class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%">
                                                        <thead>
                                                            <tr>
                                                                
                                                                <th data-ordering="false">SR No.</th>
                                                                <th data-ordering="false">Points Message</th>
                                                                <th data-ordering="false">Points Value</th>
                                                                <th data-ordering="false">Added On</th>
                                                                <th data-ordering="false">Status</th>

                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <!-- data load from models file -->
                                                            <?php include '../models/customer_wallet/booking_points_table.php' ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                </div>

                            </div>
                            <!-- end booking wallet table -->
                            <!-- redeemable wallet table -->
                            <div id="redeemable_amount_table_div" class="col">

                                <div class="h-100">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="card">
                                                <div class="card-header border-bottom-dashed">
                                                    <div class="row g-4 align-items-center">
                                                        <div class="col-sm">
                                                            <div>
                                                                <h5 class="card-title mb-0">Redeemable Wallet History</h5>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card-body">
                                                    <table id="example-dataTable" class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%">
                                                        <thead>
                                                            <tr>
                                                                <th data-ordering="false">SR No.</th>
                                                                <th data-ordering="false">Payout Message</th>
                                                                <th data-ordering="false">Payout Amount</th>
                                                                <th data-ordering="false">Earned ON</th>
                                                                <th data-ordering="false">Status</th>

                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <!-- data load from models file -->
                                                            <?php include '../models/customer_wallet/ramt_table.php' ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                </div>

                            </div>
                            <!-- end redeemable wallet table -->


                        </div>
                        <?php } 
                     } ?>

                    </div> <!-- container-fluid -->

                </div><!-- End Page-content -->

                <?php include_once "../footer.php" ?>

        </div><!-- end main content-->

    </div><!-- END layout-wrapper -->

    <!--start back-to-top-->
    <button onclick="topFunction()" class="scrollToTop scroll-btn show btn" id="back-to-top">
        <i class="ri-arrow-up-line"></i>
    </button>
    <!--end back-to-top-->

    <!-- JAVASCRIPT -->
    <script src="../assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/libs/simplebar/simplebar.min.js"></script>
    <script src="../assets/libs/node-waves/waves.min.js"></script>
    <script src="../assets/libs/feather-icons/feather.min.js"></script>
    <script src="../assets/js/jquery/jquery-3.7.1.min.js"></script>

    <!-- Required datatable js -->
    <script src="../assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="../assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>

    <!-- Responsive examples -->
    <script src="../assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="../assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>

    <!-- !-- materialdesign icon js- -->
    <script src="../assets/js/pages/remix-icons-listing.js"></script>

    <!-- App js -->
    <script src="../assets/js/app.js"></script>

    <script src="../resources/customer_wallet/wallet.js"></script>
</body>

</html>