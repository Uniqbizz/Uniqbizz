<?php
session_start();
if (!isset($_SESSION['username'])) {
    echo '<script>location.href = "../../login.php";</script>';
}

require '../../connect.php';
$date = date('Y');

// get current date to show next payout amount  and pass it in sql @ line 129
$date = date('F,Y'); //month and year. 'F' - month in Text form
$Month = date('m'); //month in number form
$Year = date('Y'); //year

?>
<!doctype html>
<html lang="en">

<head>

    <meta charset="utf-8" />
    <title>Uniqbizz - Admin Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- App favicon -->
    <link rel="shortcut icon" href="../../assets/images/fav.png">

    <!-- Bootstrap Css -->
    <link href="../../assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="../../assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="../../assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />
    <!-- Css-->
    <link href="../../assets/css/loadingScreen.css" id="app-style" rel="stylesheet" type="text/css" />
    <!-- DataTables CSS -->
    <!-- <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css"> -->

    <!-- App js -->
    <!-- <script src="../../assets/js/plugin.js"></script> -->

    <!-- FontAwesome -->
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" integrity="sha512-5A8nwdMOWrSz20fDsjczgUidUBR8liPYU+WymTZP1lmY9G6Oc7HlZv156XqnsgNUzTyMefFTcsFH/tnJE/+xBg==" crossorigin="anonymous" referrerpolicy="no-referrer" /> -->
    <style>
        .card-equal {
            height: 80% !important;
            width: 100% !important;
        }

        h4 {
            font-size: 16px !important;
            margin-top: 10px !important;
        }

        hr {
            padding: 0 !important;
        }

        .cpn_btn {
            box-shadow: none;
            background: #ffffff00;
            border: none;
            border-radius: 3px;
            color: #f9f6f6;
        }

        .box-btn {
            font-weight: 600;
            float: right;
            height: 35px;
            width: 90px;
            /* display: inline-block; */
            background: #167ee6;

        }

        .count-col {
            display: flex;
            padding-top: 8px;
            align-items: center;
        }

        .card p {
            color: #9a9a9a;
            margin-bottom: 5px;
        }

        .card h3 {
            margin-bottom: -5px;
        }

        .card {
            margin-bottom: 10px;
            position: relative;
        }

        .page_nums {
            background-color: #d9d9d9;
            color: black;
            padding: 5px 10px;
            border-radius: 4px;
            font-weight: 500;
        }

        .pagination>.active {
            border-color: #177ee6;
            border-style: solid;
            font-weight: 600;
            color: white;
            background-color: #177ee6;
        }

        .disable_click {
            pointer-events: none;
            cursor: default;
            color: #04040459;
            background-color: #afafaf4a;
        }

        #user_table>thead .ceterText {
            cursor: pointer;
        }

        .middle {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .contentDiv {
            display: none;
        }
        .contentCountDiv {
            display: none;
        }

        .transaction-dot {
            position: absolute;
            top: 4px;
            left: 4px;
            width: 8px;
            height: 8px;
            background-color: blue;
            border-radius: 50%;
            z-index: 10;
        }

        .fc-daygrid-day {
            position: relative;
        }
        /* top performer section start */
        .bg-indigo-subtle {
            background: #9054f1ff !important;
        }
        .text-indigo-emphasis {
            color: #0d0220ff !important;
        }
        .bg-orange-subtle {
            background: #ee9f5eff !important;
        }
        .text-orange-emphasis {
            color: #311803ff !important;
        }
        .bg-teal-subtle {
            background: #77eecaff !important;
        }
        .text-teal-emphasis {
            color: #02251bff !important;
        }
        /*  top performer section end */
    </style>
</head>
<!-- DataTables -->
    <link href="../../assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />

    <!-- Responsive datatable examples -->
    <link href="../../assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    
<body data-sidebar="dark">

    <!-- Begin page -->
    <div id="layout-wrapper">

        <?php
        // top header logo, hamberger menu, fullscreen icon, profile
        include_once '../../headerIndex.php';

        // sidebar navigation menu 
        include_once '../../sidebarIndex.php';
        ?>
        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">

            <div class="page-content">
                <div class="container-fluid">
                    <!-- start page title -->
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                <h4 class="mb-sm-0 font-size-18">Dashboard</h4>
                            </div>
                        </div>
                    </div>
                    <!-- end page title -->
                    <!-- welcome card and user cards -->
                    <!-- data load from controllers -->
                    <?php include '../../controllers/home/cards.php' ?>
                    <!--end welcome card and user cards -->
                    <!-- customer type custom cards -->
                    <!-- data load from controllers -->
                    <?php include '../../controllers/home/customer_custom_cards.php' ?>
                    <!--end customer type custom cards -->
                    <!-- pie charts payout/cu membership -->
                    <!-- data load from cotrollers -->
                    <?php include '../../controllers/home/pie_charts.php' ?>
                    <!--end pie charts payout/cu membership -->
                    
                    <!-- all users monthly data -->
                    <!-- data load from controllers -->
                    <?php include '../../controllers/home/all_user_monthly_data.php' ?>
                    <!--end all users monthly data -->
                    

                    <!-- Full Calender -->
                    <!-- data load from controllers file -->
                    <?php include '../../controllers/home/full_calender.php' ?>
                    <!-- End Full Calender -->

                    <!-- Top Performer start -->
                    <?php include '../../controllers/home/top_performers.php' ?>
                    <!-- Top Performer end -->

                    <!-- recent 5 all users -->
                    <!-- data load from controllers -->
                    <?php include '../../controllers/home/recent_all_users.php' ?>
                    <!-- end recent 5 all users -->

                </div>
                <!-- container-fluid -->
            </div>
            <!-- End Page-content -->

            <?php include_once "../../footer.php" ?>
        </div>
        <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->
    <!--start back-to-top-->
    <button onclick="topFunction()" class="scrollToTop scroll-btn show btn" id="back-to-top">
        <i class="mdi mdi-arrow-up"></i>
    </button>
    <!--end back-to-top-->

    <!-- JAVASCRIPT -->
    <script src="../../assets/libs/jquery/jquery.min.js"></script>
    <script src="../../assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../../assets/libs/metismenu/metisMenu.min.js"></script>
    <script src="../../assets/libs/simplebar/simplebar.min.js"></script>
    <script src="../../assets/libs/node-waves/waves.min.js"></script>

    <!-- Chart JS -->
    <!-- <script src="../../assets/libs/chart.js/chart.umd.js"></script> -->
    <script src="../../assets/libs/chart.js/Chart-2.5.0.min.js"></script>
    <!-- <script src="../../assets/js/pages/chartjs.init.js"></script>  -->

    <!-- dashboard init -->
    <!-- <script src="../../assets/js/pages/dashboard.init.js"></script> -->
    <!-- plugin js -->
    <script src="../../assets/libs/moment/min/moment.min.js"></script>
    <script src="../../assets/libs/jquery-ui-dist/jquery-ui.min.js"></script>

    <!-- Calendar init -->
    <script src="../../assets/libs/fullcalendar/index.global.min.js"></script>
    <!-- <script src="../../assets/js/pages/calendars-full.init.js"></script> -->
       <!-- Required datatable js -->
    <script src="../../assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="../../assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>

    <!-- Responsive examples -->
    <script src="../../assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="../../assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>

    <!-- App js -->
    <script src="../../assets/js/app.js"></script>
    
    <script src="../../resources/common_resources/top_function.js"></script>
    <script src="../../resources/home/home_custom.js"></script>

</body>

</html>