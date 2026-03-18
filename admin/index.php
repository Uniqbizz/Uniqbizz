<?php
session_start();
if (!isset($_SESSION['username'])) {
    echo '<script>location.href = "login.php";</script>';
}

require 'connect.php';
$date = date('Y');

// get current date to show next payout amount  and pass it in sql @ line 129
$date = date('F,Y'); //month and year. 'F' - month in Text form : March, 2026
$Month = date('m'); //month in number form : 03
$Year = date('Y'); //year : 2026
// echo "Next Date ".$date .' ;' ;
// echo "Next Month ".$Month.' ;';
// echo "Next Year ".$Year.' ;';
// echo '<br>';
$formatted_date = date('d M Y');

// get last login details
require 'test_data/lastLogin.php';

//convert long number to short number with 2 decimal points and currency indication
function formatIndianCurrency($num) {
    $num = str_replace(',', '', $num);
    if ($num >= 10000000) {
        return number_format($num / 10000000, 2) . ' Cr';
    } elseif ($num >= 100000) {
        return number_format($num / 100000, 2) . ' L';
    } elseif ($num >= 1000) {
        return number_format($num / 1000, 2) . ' K';
    } else {
        return $num;
    }
}
?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Uniqbizz - Admin Dashboard</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- App favicon -->
        <link rel="shortcut icon" href="assets/images/fav.png">
        <!-- Bootstrap Css -->
        <link href="assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
        <!-- Icons Css -->
        <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
        <!-- App Css-->
        <link href="assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />
        <!-- Css-->
        <link href="assets/css/loadingScreen.css" id="app-style" rel="stylesheet" type="text/css" />
        <script src="https://unpkg.com/@dotlottie/player-component@latest/dist/dotlottie-player.js"></script>

        <!-- DataTables CSS -->
        <!-- <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css"> -->

        <!-- App js -->
        <!-- <script src="assets/js/plugin.js"></script> -->

        <!-- FontAwesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <style>
            .card-equal {
                height: 90% !important;
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
            /* full calendar start */
            .calendarheight {
                height: 375px !important;
            }
            /* full calendar end */
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
            /* latest dashboard design 16/2/2026 */
            .peraAdmin {
                position: absolute;
                top: 0px;
                left: 38px;
            }
            .peraAdmin1 {
                position: absolute;
                top: 0px;
                left: 50px;
            }
            .avatar-title1{
                -webkit-box-align: center;
                -ms-flex-align: center;
                align-items: center;
                background-color: #34c38f !important;
                color: #fff;
                display: flex;
                font-weight: 500;
                height: 100%;
                -webkit-box-pack: center;
                -ms-flex-pack: center;
                justify-content: center;
                width: 100%;
            }
            .avatar-title2{
                -webkit-box-align: center;
                -ms-flex-align: center;
                align-items: center;
                background-color: #f1b44c !important;
                color: #fff;
                display: flex;
                font-weight: 500;
                height: 100%;
                -webkit-box-pack: center;
                -ms-flex-pack: center;
                justify-content: center;
                width: 100%;
            }
            .avatar-title3{
                -webkit-box-align: center;
                -ms-flex-align: center;
                align-items: center;
                background-color: #f46a6a !important;
                color: #fff;
                display: flex;
                font-weight: 500;
                height: 100%;
                -webkit-box-pack: center;
                -ms-flex-pack: center;
                justify-content: center;
                width: 100%;
            }
            .revenueCardViewButton {
                position: absolute;
                top: 70px;
            }
            .viewDetailsButton1:hover {
                background-color: #222c5c !important;
                color: #fff !important;
            }
            .viewDetailsButton2:hover {
                background-color: #154e39 !important;
                color: #fff !important;
            }
            .viewDetailsButton3:hover {
                background-color: #60481e !important;
                color: #fff !important;
            }
            .viewDetailsButton4:hover {
                background-color: #622a2a !important;
                color: #fff !important;
            }
            /* Latest transaction section */
            .fontSizeTransaction {
                font-size: 11px !important;
            }
            /* Latest transaction section */

            @media (max-width: 1154px){
                .revenueCardViewButton {
                    position: absolute;
                    top: 90px;
                }
                .commissionAmount {
                    font-size: 20px !important;
                }
            }
            @media (max-width: 1110px){
                .flex-fill img {
                    width: 110px !important;
                }
                .revenueCardViewButton {
                    position: absolute;
                    top: 70px;
                }
            }
            @media (max-width: 1044px){
                .revenueCardViewButton {
                    position: absolute;
                    top: 90px;
                }
            }
            @media (max-width: 992px){
                .revenueCardViewButton {
                    position: absolute;
                    top: 70px;
                }
                .flex-fill img {
                    width: 140px !important;
                    height: 100px !important;
                }
            }
            @media (max-width: 854px){
                .revenueCardViewButton {
                    position: absolute;
                    top: 90px;
                }
            }
            @media (max-width: 767px){
                .dayField {
                    border: none !important;
                }
                .timeField {
                    padding: 10px 0px 0px 12px !important;
                }
                .peraAdmin1 {
                    position: absolute;
                    top: 12px;
                    left: 40px;
                }
                .revenueCardViewButton {
                    position: absolute;
                    top: 60px;
                }
            }
            @media (max-width: 575px){
                .dotlottie-player {
                    width: 250px !important;
                }
                .revenueCardViewButton {
                    position: absolute;
                    top: 60px;
                }
            }
            @media (max-width: 439px){
                .flex-fill img {
                    width: 100px !important;
                    height: 100px !important;
                }
            }
            @media (max-width: 399px){
                .flex-fill img {
                   display: none;
                }
                .flex-fill {
                   height: 100px !important;
                }
            }
            
            /* latest dashboard design 16/2/2026 */
        </style>
    </head>
    <!-- DataTables -->
        <link href="assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />

        <!-- Responsive datatable examples -->
        <link href="assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />
        
    <body data-sidebar="dark">
        
        <!-- Begin page -->
        <div id="layout-wrapper">

            <?php
            // top header logo, hamberger menu, fullscreen icon, profile
            include_once 'headerIndex.php';

            // sidebar navigation menu 
            include_once 'sidebarIndex.php';
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
                        <div class="row">
                            <!-- welcome banner with last login -->
                            <?php include 'index_welcome_card.php'; ?>
                            <!-- system user count, total revenue, pending and paid commission  -->
                            <?php include 'index_user_cards.php'; ?>
                            <!-- user count with revenue and commission paid and pending -->
                            <?php include 'index_user_count_table.php'; ?>
                            <!-- line chart -->
                            <?php include 'customer_line_chart.php'; ?>
                            <!-- doughnut user revenue chart  -->
                            <?php include 'user_revenue_chart.php'; ?>
                            <!-- Membership overview  -->
                            <?php include 'customer_membership_overview.php'; ?>
                            <!-- doughnut holidays packages chart  -->
                            <?php include 'holidays_package_chart.php'; ?>
                            <!-- Top performer -->
                            <?php include 'top_performer.php'; ?>
                            <!-- Calender   -->
                            <?php include 'calender_transaction.php'; ?>
                            <!-- upcoming birthdays -->
                            <?php include 'upcoming_birthdays.php'; ?>
                        </div>
                    
                    </div>
                    <!-- container-fluid -->
                </div>
                <!-- End Page-content -->

                <?php include_once "footer.php" ?>
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
        <script src="assets/libs/jquery/jquery.min.js"></script>
        <script src="assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="assets/libs/metismenu/metisMenu.min.js"></script>
        <script src="assets/libs/simplebar/simplebar.min.js"></script>
        <script src="assets/libs/node-waves/waves.min.js"></script>

        <!-- Chart JS -->
        <script src="assets/libs/chart.js/Chart-2.5.0.min.js"></script>

        <!-- dashboard init -->
        <!-- <script src="assets/js/pages/dashboard.init.js"></script> -->
        <!-- plugin js -->
        <script src="assets/libs/moment/min/moment.min.js"></script>
        <script src="assets/libs/jquery-ui-dist/jquery-ui.min.js"></script>

        <!-- Calendar init -->
        <script src="assets/libs/fullcalendar/index.global.min.js"></script>
        <!-- <script src="assets/js/pages/calendars-full.init.js"></script> -->
        <!-- Required datatable js -->
        <script src="assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
        <script src="assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>

        <!-- Responsive examples -->
        <script src="assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
        <script src="assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>

        <!-- App js -->
        <script src="assets/js/app.js"></script>
        
        <!-- echarts js -->
        <script src="assets/libs/echarts/echarts.min.js"></script>
        <!-- echarts init -->
        <!-- <script src="assets/js/pages/echarts.init.js"></script> -->
        
        <script src="index_custom.js"></script>
        
    </body>
</html>