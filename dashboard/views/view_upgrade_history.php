<?php
include_once '../dashboard_user_details.php';
$tamount='';
$initial_inv='';
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
        /* Accordion */
        .accordion {
            cursor: pointer;
            width: 100%;
            border: none;
        }
        /* Card Wrapper */
        .upgrade-table-wrapper {
            background: #ffffff;
            border-radius: 16px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.06);
        }

        /* Table header */
        #upgardeHistoryTable thead th {
            background: #f8f9fb;
            font-weight: 600;
            font-size: 14px;
            padding: 14px;
            border-bottom: none;
        }

        /* Table rows */
        #upgardeHistoryTable tbody tr {
            background: #fff;
            transition: all 0.25s ease;
        }

        #upgardeHistoryTable tbody tr:hover {
            background: #f9fbfd;
            transform: scale(1.01);
            box-shadow: 0 4px 12px rgba(0,0,0,0.06);
        }

        /* Table cells */
        #upgardeHistoryTable tbody td {
            padding: 14px;
            vertical-align: middle;
            font-size: 14px;
        }

        /* Modern Badges */
        .badge-soft-info {
            background: #e7f3ff;
            color: #007bff;
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 12px;
        }

        .badge-soft-success {
            background: #e6f9f0;
            color: #00a86b;
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 12px;
        }

        .badge-soft-danger {
            background: #fdecea;
            color: #dc3545;
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 12px;
        }

        /* Dropdown */
        .card-drop {
            color: #6c757d;
            transition: 0.2s;
        }

        .card-drop:hover {
            color: #000;
        }

    </style>
</head>

<body>

    <!-- Begin page -->
    <div id="layout-wrapper">

        <?php include_once '../header.php'; ?>

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

        <?php include_once '../sidebar.php'; ?>

        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">
                    <!-- start page title -->
                    <!-- data load from models file -->
                    <?php include '../models/upgrade_franchisee/view_upgrade_f.php' ?>
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                <h4 class="mb-sm-0">Upgarde History</h4>
                                
                                <div class="pt-3 pb-2 col-md-6">
                                    <div class="row justify-content-end">
                                        <div class="col-md-6 d-flex gap-2">
                                            <span class="fw-semibold">Total Investment:</span>
                                            <span class="badge bg-success fs-6 px-3 py-2">
                                                <?= htmlspecialchars($tamount, ENT_QUOTES, 'UTF-8') ?>
                                            </span>
                                        </div>
                                    </div>
    
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end page title -->

                    <div class="row">
                        <div class="col">

                            <div class="h-100">

                                <div class="table-responsive p-3 upgrade-table-wrapper" id="filterTable1">

                                    <table class="table align-middle mb-0" id="upgardeHistoryTable">

                                        <thead>
                                            <tr>
                                                <th>Investment Date</th>
                                                <th style="width:250px;">Invested Amount</th>
                                                <th>Commission %</th>
                                                <th>Incentive %</th>
                                                <th>Payment Mode</th>
                                                <th style="width:250px;">Note</th>
                                                <th>Approved Date</th>
                                                <th>Remark</th>
                                                <th>Status</th>
                                                <th class="text-center">Action</th>
                                            </tr>
                                        </thead>

                                        <tbody id="upgardeHistory">

                                        <!-- data load from models file -->
                                        <?php include '../models/upgrade_franchisee/upgrade_list.php' ?>

                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            
                        </div>


                    </div>

                </div>

            </div>

            <div class="btn" style="width: 25px; height: 25px; padding: 0px; position: fixed; bottom: 120px; right: 35px; border-radius: 50%;">
                <a href="add_ta_top_up.php" style="display: flex; justify-content: center; align-items: center; height: -webkit-fill-available;">
                    <i class="fa-solid fa-circle-plus fa-beat-fade fa-3x" style="color: #4b38b3;"></i>
                </a>
            </div>

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

    <script src="../resources/upgrade_franchisee/view_upgrade_f_custom.js"></script>
</body>

</html>