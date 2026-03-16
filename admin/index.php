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
                            <div class="col-xl-12">
                                <div class="card overflow-hidden rounded-4 mb-3">
                                    <div class="row">
                                        <div class="col-lg-8 col-md-7 col-sm-8 col-12 pe-0">
                                            <div class="p-3 pb-4">
                                                <h3 class="px-4 py-2 text-dark"><span style='font-size:30px;'>&#128075;</span>&nbsp;&nbsp;Welcome back, Admin</h3>
                                                <p class="px-4 pt-3">Here's a quick overview of business performance. Track revenue, commissions, memberships, and network activity across all roles from one dashboard.</p> 
                                                <div class="row px-4 pt-2">
                                                    <div class="col-lg-6 col-md-6 col-sm-12 col-12 border-end border-2 dayField">
                                                        <div class="rounded-2 bg-primary-subtle text-center" style="width: 20px";>
                                                            <i class="fa-regular fa-calendar fa-sm" style="color: rgba(85, 110, 230, 1.00);"></i>
                                                        </div>
                                                        <p class="peraAdmin text-dark fw-bold">Today: <span><?php echo $formatted_date ?></span></p>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-12 col-12 ps-4 timeField">
                                                        <div class="rounded-2 bg-primary-subtle text-center" style="width: 20px";>
                                                            <i class="fa-regular fa-clock fa-sm" style="color: rgba(85, 110, 230, 1.00);"></i>
                                                        </div>
                                                        <p class="peraAdmin1 text-dark fw-bold">Last Login: <span><?php echo $lastLogin ?></span></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-5 col-sm-4 col-12 align-self-end d-flex justify-content-center">
                                            <div class="dotlottie-player" style="width: 200px;">
                                                <dotlottie-player
                                                    src="assets/images/Service.lottie"
                                                    background="transparent"
                                                    speed="1"
                                                    style="width: 100%; height: auto;"
                                                    loop
                                                    autoplay>
                                                </dotlottie-player>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- <div class="card-body pt-0">
                                        <div class="row"> -->
                                            <!-- <div class="col-sm-4 col-4"> -->
                                                <!-- <div class="avatar-lg mb-3 mt-n5">
                                                    <img src="assets/images/users/avatar-1.jpg" alt="" class="img-thumbnail rounded-circle">
                                                </div> -->
                                                <!-- <h5 class="font-size-14 text-truncate fw-bolder">Admin</h5> -->
                                            <!-- </div> -->

                                            <!-- <div class="col-sm-12 col-12">
                                                <div class="pt-4">
                                                    <div class="row">
                                                        <div class="col-7 p-0">
                                                            <p class="text-muted font-size-13 ps-2">Packages Sold</p>
                                                            <p class="text-muted font-size-13 ps-2">Techno Enterprise</p>
                                                            <p class="text-muted font-size-13 ps-2">Franchise</p>
                                                            <p class="text-muted font-size-13 ps-2">Master Franchise</p>
                                                            <p class="text-muted font-size-13 ps-2">Sponsor Franchise</p>
                                                        </div>
                                                        <div class="col-5 p-0"> -->
                                                            <!-- Packages Sold  -->
                                                            <!-- <?php
                                                                // $sqlbooking = "SELECT COUNT(id) AS booked FROM `bookings` WHERE confirm_status = '1' ";
                                                                // $sqlBooked = $conn->prepare($sqlbooking);
                                                                // $sqlBooked->execute();
                                                                // $sqlBooked->setFetchMode(PDO::FETCH_ASSOC);
                                                                // if (($sqlBooked->rowCount() > 0)) {
                                                                //     foreach ($sqlBooked->fetchAll() as $key => $value) {
                                                                //         $totalBooked = $value['booked'];
                                                                    //     echo '<h5 class="font-size-13">' . $totalBooked . '</h5>';
                                                                    // }
                                                                // }
                                                            ?> -->
                                                            <!-- Techno Enterprise -->
                                                            <!-- <?php
                                                                // $Amt = 0;

                                                                // Prepare and execute query
                                                                // $sql = "SELECT SUM(CASE WHEN amount IS NULL THEN 0 ELSE amount END) AS total_amount FROM corporate_agency WHERE status = '1'";
                                                                // $stmt = $conn->prepare($sql);
                                                                // $stmt->execute();
                                                                // $result = $stmt->fetch(PDO::FETCH_ASSOC);

                                                                // // Fetch total amount
                                                                // $Amt = $result['total_amount'] ?? 0;

                                                                // // Format in Indian currency style (e.g., 12,34,567)
                                                                // $formattedAmt = preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $Amt);

                                                                // // Output
                                                                // echo '<h5 class="font-size-13"><span>&#8377;</span>' . $formattedAmt . '/-</h5>';
                                                            // ?>

                                                            sub_franchisee
                                                            <?php
                                                                // $Amt = 0;

                                                                // Prepare and execute query
                                                            //     $sql = "SELECT SUM(CASE WHEN amount IS NULL THEN 0 ELSE amount END) AS total_amount FROM sub_franchisee WHERE status = '1'";
                                                            //     $stmt = $conn->prepare($sql);
                                                            //     $stmt->execute();
                                                            //     $result = $stmt->fetch(PDO::FETCH_ASSOC);

                                                            //     // Fetch total amount
                                                            //     $Amt = $result['total_amount'] ?? 0;

                                                            //     // Format in Indian currency style (e.g., 12,34,567)
                                                            //     $formattedAmt = preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $Amt);

                                                            //     // Output
                                                            //     echo '<h5 class="font-size-13"><span>&#8377;</span>' . $formattedAmt . '/-</h5>';
                                                            // ?>

                                                            Master Franchisee
                                                            <?php
                                                                // $Amt = 0;

                                                                // Prepare and execute query
                                                                // $sql = "SELECT SUM(CASE WHEN paid_amount IS NULL THEN 0 ELSE paid_amount END) AS total_amount FROM master_franchisee WHERE status = '1'";
                                                                // $stmt = $conn->prepare($sql);
                                                                // $stmt->execute();
                                                                // $result = $stmt->fetch(PDO::FETCH_ASSOC);

                                                                // Fetch total amount
                                                                // $Amt = $result['total_amount'] ?? 0;

                                                                // // Format in Indian currency style (e.g., 12,34,567)
                                                                // $formattedAmt = preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $Amt);

                                                                // // Output
                                                                // echo '<h5 class="font-size-13"><span>&#8377;</span>' . $formattedAmt . '/-</h5>';
                                                            // ?>

                                                            Sponsor Franchise
                                                            <?php
                                                                // $Amt = 0;

                                                                // // Prepare and execute query
                                                                // $sql = "SELECT SUM(CASE WHEN paid_amount IS NULL THEN 0 ELSE paid_amount END) AS total_amount FROM sponsor_franchisee WHERE status = '1'";
                                                                // $stmt = $conn->prepare($sql);
                                                                // $stmt->execute();
                                                                // $result = $stmt->fetch(PDO::FETCH_ASSOC);

                                                                // // Fetch total amount
                                                                // $Amt = $result['total_amount'] ?? 0;

                                                                // // Format in Indian currency style (e.g., 12,34,567)
                                                                // $formattedAmt = preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $Amt);

                                                                // // Output
                                                                // echo '<h5 class="font-size-13"><span>&#8377;</span>' . $formattedAmt . '/-</h5>';
                                                            // ?>
                                                            
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div> -->
                                </div>
                            </div>

                            <!-- system user count, total revenue, pending and paid commission  -->
                            <div class="col-xl-12">
                                <div class="row">
                                    <div class="col-lg-3 col-md-3 col-sm-6 col-12">
                                        <div class="card card-equal mini-stats-wid rounded-4">
                                            <div class="card-body">
                                                <div class="d-flex">
                                                    <div class="flex-shrink-1">
                                                        <div class="mini-stat-icon avatar-sm rounded-circle bg-primary">
                                                            <span class="avatar-title">
                                                                <i class="fas fa-user-alt font-size-24"></i>
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="flex-grow-1 ps-2">
                                                        <p class="text-muted fw-medium">Total Customers</p>
                                                        <?php
                                                            $stmt = $conn->prepare("SELECT count(ca_customer_id) as totalca_customer FROM ca_customer where user_type='10' and status='1' ");
                                                            $stmt->execute();
                                                            $stmt->setFetchMode(PDO::FETCH_ASSOC);
                                                            if ($stmt->rowCount() > 0) {
                                                                foreach (($stmt->fetchAll()) as $key => $row) {
                                                                    $totalca_customer = $row['totalca_customer'];
                                                                    echo '<h3 class="mb-0 text-dark">'.$totalca_customer.'</h3>';
                                                                }
                                                            } else {
                                                                echo '<h3 class="mb-0 text-dark">0</h3>';
                                                            }
                                                        ?>
                                                    </div>
                                                </div>
                                                <div class="d-flex justify-content-center my-3">
                                                    <a href="ca_customers/view_customers.php" class="text-primary-emphasis bg-primary-subtle border border-primary-subtle rounded-3 fw-bolder text-center py-1 viewDetailsButton1" role="button" style="width: 190px;">View details</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-3 col-sm-6 col-12">
                                        <div class="card card-equal mini-stats-wid rounded-4">
                                            <div class="card-body">
                                                <div class="d-flex">
                                                    <div class="flex-shrink-1">
                                                        <div class="mini-stat-icon avatar-sm rounded-circle bg-success">
                                                            <span class="avatar-title1">
                                                                <i class="fa-solid fa-users-between-lines font-size-24"></i>
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="flex-grow-1 ps-2">
                                                        <p class="text-muted fw-medium">Franchisee | TE | Institution</p>
                                                       <?php
                                                            $stmt = $conn->prepare("
                                                                SELECT 
                                                                    (SELECT COUNT(corporate_agency_id) FROM corporate_agency WHERE user_type='16') +
                                                                    (SELECT COUNT(sub_franchisee_id) FROM sub_franchisee WHERE user_type='29') +
                                                                    (SELECT COUNT(institution_id) FROM institution WHERE user_type='32' AND status='1')
                                                                AS total_users
                                                            ");

                                                            $stmt->execute();
                                                            $row = $stmt->fetch(PDO::FETCH_ASSOC);

                                                            $total_users = $row['total_users'] ?? 0;

                                                            echo '<h3 class="mb-0 text-dark">'.$total_users.'</h3>';
                                                        ?>
                                                    </div>
                                                </div>
                                                <div class="d-flex justify-content-center my-3">
                                                    <a href="corporate_agency/view_corporate_agency.php" class="text-success-emphasis bg-success-subtle border border-success-subtle rounded-3 fw-bolder text-center py-1 viewDetailsButton2" role="button" style="width: 190px;">View details</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-9 col-12">
                                        <div class="card card-equal mini-stats-wid rounded-4">
                                            <div class="card-body">
                                                <div class="d-flex">
                                                    <div class="flex-fill">
                                                        <div class="mini-stat-icon avatar-sm rounded-circle bg-warning">
                                                            <span class="avatar-title2">
                                                                <i class="fa-solid fa-wallet font-size-24"></i>
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="flex-fill">
                                                        <p class="text-muted fw-medium ps-2">Revenue Generated Full</p>
                                                        <!-- <h3 class="mb-0 text-dark ps-2">&#8377; 302Cr</h3> -->
                                                        <?php
                                                            
                                                            $stmt = $conn->prepare("
                                                                SELECT 
                                                                    (SELECT SUM(amount) FROM corporate_agency WHERE user_type='16') +
                                                                    (SELECT SUM(amount) FROM sub_franchisee WHERE user_type='29') +
                                                                    (SELECT SUM(amount) FROM institution WHERE user_type='32') +
                                                                    (SELECT SUM(paid_amount) FROM business_mentor WHERE user_type='26') +
                                                                    (SELECT SUM(paid_amount) FROM master_franchisee WHERE user_type='28') +
                                                                    (SELECT SUM(paid_amount) FROM sponsor_franchisee WHERE user_type='30') + 
                                                                    (SELECT SUM(amount) FROM ca_travelagency WHERE user_type='11') + 
                                                                    (SELECT SUM(paid_amount) FROM ca_customer WHERE user_type='10' AND status = '1') 
                                                                AS total_revenue
                                                            ");
                                                            $stmt->execute();
                                                            $row = $stmt->fetch(PDO::FETCH_ASSOC);
                                                            $total_revenue = $row['total_revenue'] ?? 0;
                                                            echo '<h3 class="mb-0 text-dark">&#8377;'.formatIndianCurrency($total_revenue).'</h3>';
                                                        ?>
                                                    </div>
                                                    <div class="flex-fill">
                                                        <!-- <div class="goldCoinImage"> -->
                                                            <img src="assets/images/goldcoin.png" style="width: 165px; height: 110px;" alt="">
                                                        <!-- </div> -->
                                                    </div>
                                                </div>
                                                <div class="d-flex justify-content-center my-3 revenueCardViewButton">
                                                    <a href="payout/sub_franchisee_payout.php" class="text-warning-emphasis bg-warning-subtle border border-warning-subtle rounded-3 fw-bolder text-center py-1 viewDetailsButton3" role="button" style="width: 190px;">View details</a>
                                                </div>
                                                
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-6 col-12">
                                        <div class="card card-equal mini-stats-wid rounded-4">
                                            <div class="card-body">
                                                <div class="d-flex">
                                                    <div class="flex-shrink-1">
                                                        <div class="mini-stat-icon avatar-sm rounded-circle bg-primary">
                                                            <span class="avatar-title">
                                                                <i class="fas fa-user-alt font-size-24"></i>
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="flex-grow-1 ps-2">
                                                        <p class="text-muted fw-medium">Travel Consultant</p>
                                                        <?php
                                                            $stmt = $conn->prepare("SELECT count(ca_travelagency_id) as totalca_travelagency FROM ca_travelagency where user_type='11' and status='1' ");
                                                            $stmt->execute();
                                                            $stmt->setFetchMode(PDO::FETCH_ASSOC);
                                                            if ($stmt->rowCount() > 0) {
                                                                foreach (($stmt->fetchAll()) as $key => $row) {
                                                                    $totalca_travelagency = $row['totalca_travelagency'];
                                                                    echo '<h3 class="mb-0 text-dark">'.$totalca_travelagency.'</h3>';
                                                                }
                                                            } else {
                                                                echo '<h3 class="mb-0 text-dark">0</h3>';
                                                            }
                                                        ?>
                                                    </div>
                                                </div>
                                                <div class="d-flex justify-content-center my-3">
                                                    <a href="ca_travelAgency/view_ca_travelAgency.php" class="text-primary-emphasis bg-primary-subtle border border-primary-subtle rounded-3 fw-bolder text-center py-1 viewDetailsButton1" role="button" style="width: 190px;">View details</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-6 col-12">
                                        <div class="card card-equal mini-stats-wid rounded-4">
                                            <div class="card-body">
                                                <div class="d-flex">
                                                    <div class="flex-shrink-1">
                                                        <div class="mini-stat-icon avatar-sm rounded-circle bg-success">
                                                            <span class="avatar-title1">
                                                                <i class="fa-solid fa-users-between-lines font-size-24"></i>
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="flex-grow-1 ps-2">
                                                        <p class="text-muted fw-medium">MF | SF | BM</p>
                                                        <?php
                                                            $stmt = $conn->prepare("
                                                                SELECT 
                                                                    (SELECT COUNT(business_mentor_id) FROM business_mentor WHERE user_type='26') +
                                                                    (SELECT COUNT(master_franchisee_id) FROM master_franchisee WHERE user_type='28') +
                                                                    (SELECT COUNT(sponsor_franchisee_id) FROM sponsor_franchisee WHERE user_type='30' AND status='1')
                                                                AS total_users
                                                            ");

                                                            $stmt->execute();
                                                            $row = $stmt->fetch(PDO::FETCH_ASSOC);

                                                            $total_users = $row['total_users'] ?? 0;

                                                            echo '<h3 class="mb-0 text-dark">'.$total_users.'</h3>';
                                                        ?>
                                                    </div>
                                                </div>
                                                <div class="d-flex justify-content-center my-3">
                                                    <a href="businessMentor/businessMentor.php" class="text-success-emphasis bg-success-subtle border border-success-subtle rounded-3 fw-bolder text-center py-1 viewDetailsButton2" role="button" style="width: 190px;">View details</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-6 col-12">
                                        <div class="card card-equal mini-stats-wid rounded-4">
                                            <div class="card-body">
                                                <div class="d-flex">
                                                    <div class="flex-shrink-1">
                                                        <div class="mini-stat-icon avatar-sm rounded-circle bg-warning">
                                                            <span class="avatar-title2">
                                                                <i class="fa-solid fa-wallet font-size-24"></i>
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="flex-grow-1 ps-2">
                                                        <p class="text-muted fw-medium">Commission Paid</p>
                                                        <?php
                                                            $stmt = $conn->prepare("
                                                                SELECT 
                                                                    COALESCE((SELECT SUM(payout_amount) FROM bm_payout_history WHERE payout_status='1'),0) + 
                                                                    COALESCE((SELECT SUM(comm_amt) FROM bm_recruitment_payout WHERE status='1'),0) +
                                                                    COALESCE((SELECT SUM(comm_amt) FROM goa_bm_payout WHERE status='1'),0) +

                                                                    COALESCE((SELECT SUM(comm_amt) FROM ca_payout WHERE status='1'),0) +

                                                                    COALESCE((SELECT 
                                                                        SUM(CASE WHEN status_zm = '1' THEN commission_zm ELSE 0 END) +
                                                                        SUM(CASE WHEN status_mf = '1' THEN commission_mf ELSE 0 END)
                                                                    FROM sub_franchisee_payout),0) +

                                                                    COALESCE((SELECT 
                                                                        SUM(CASE WHEN status_emp = '1' THEN commission_emp ELSE 0 END) +
                                                                        SUM(CASE WHEN status_bm_mf_sf = '1' THEN commission_bm_mf_sf ELSE 0 END)
                                                                    FROM institution_payout),0) +

                                                                    COALESCE((SELECT 
                                                                        SUM(CASE WHEN status_bm = '1' THEN commision_bm ELSE 0 END) +
                                                                        SUM(CASE WHEN status_te = '1' THEN commision_te ELSE 0 END)
                                                                    FROM ca_ta_payout),0) +

                                                                    COALESCE((SELECT 
                                                                        SUM(CASE WHEN status_bdm = '1' THEN commision_bdm ELSE 0 END) +
                                                                        SUM(CASE WHEN status_bm = '1' THEN commision_bm ELSE 0 END) +
                                                                        SUM(CASE WHEN status_te = '1' THEN commision_te ELSE 0 END) 
                                                                    FROM ca_cu_payout),0) +

                                                                    COALESCE((SELECT SUM(referral_amount) FROM customer_reference_payout WHERE status='1'),0) +

                                                                    COALESCE((SELECT 
                                                                        SUM(CASE WHEN ta_status = '1' THEN ta_amt ELSE 0 END) +
                                                                        SUM(CASE WHEN te_status = '1' THEN te_amt ELSE 0 END) +
                                                                        SUM(CASE WHEN bm_status = '1' THEN bm_amt ELSE 0 END) +
                                                                        SUM(CASE WHEN cu1_status = '1' THEN cu1_amt ELSE 0 END) +
                                                                        SUM(CASE WHEN cu2_status = '1' THEN cu2_amt ELSE 0 END) +
                                                                        SUM(CASE WHEN cu3_status = '1' THEN cu3_amt ELSE 0 END) 
                                                                    FROM product_payout),0)

                                                                AS commission_paid;
                                                            ");
                                                            $stmt->execute();
                                                            $row = $stmt->fetch(PDO::FETCH_ASSOC);
                                                            $commission_paid = $row['commission_paid'] ?? 0;
                                                            echo '<h3 class="mb-0 text-dark">&#8377;'.formatIndianCurrency($commission_paid).'</h3>';
                                                        ?>
                                                        <!-- <h3 class="mb-0 text-dark commissionAmount">&#8377; 3,264L</h3> -->
                                                    </div>
                                                </div>
                                                <div class="d-flex justify-content-center my-3">
                                                    <a href="payout/sub_franchisee_payout.php" class="text-warning-emphasis bg-warning-subtle border border-warning-subtle rounded-3 fw-bolder text-center py-1 viewDetailsButton3" role="button" style="width: 190px;">View details</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-6 col-12">
                                        <div class="card card-equal mini-stats-wid rounded-4">
                                            <div class="card-body">
                                                <div class="d-flex">
                                                    <div class="flex-shrink-1">
                                                        <div class="mini-stat-icon avatar-sm rounded-circle bg-danger">
                                                            <span class="avatar-title3">
                                                                <i class="fa-solid fa-wallet font-size-24"></i>
                                                            </span>;
                                                        </div>
                                                    </div>
                                                    <div class="flex-grow-1 ps-2">
                                                        <p class="text-muted fw-medium">Commission Pending</p>
                                                        <?php
                                                            $stmt = $conn->prepare("
                                                                SELECT 
                                                                    COALESCE((SELECT SUM(payout_amount) FROM bm_payout_history WHERE payout_status='2'),0) + 
                                                                    COALESCE((SELECT SUM(comm_amt) FROM bm_recruitment_payout WHERE status='2'),0) +
                                                                    COALESCE((SELECT SUM(comm_amt) FROM goa_bm_payout WHERE status='2'),0) +

                                                                    COALESCE((SELECT SUM(comm_amt) FROM ca_payout WHERE status='2'),0) +

                                                                    COALESCE((SELECT 
                                                                        SUM(CASE WHEN status_zm = '2' THEN commission_zm ELSE 0 END) +
                                                                        SUM(CASE WHEN status_mf = '2' THEN commission_mf ELSE 0 END)
                                                                    FROM sub_franchisee_payout),0) +

                                                                    COALESCE((SELECT 
                                                                        SUM(CASE WHEN status_emp = '2' THEN commission_emp ELSE 0 END) +
                                                                        SUM(CASE WHEN status_bm_mf_sf = '2' THEN commission_bm_mf_sf ELSE 0 END)
                                                                    FROM institution_payout),0) +

                                                                    COALESCE((SELECT 
                                                                        SUM(CASE WHEN status_bm = '2' THEN commision_bm ELSE 0 END) +
                                                                        SUM(CASE WHEN status_te = '2' THEN commision_te ELSE 0 END)
                                                                    FROM ca_ta_payout),0) +

                                                                    COALESCE((SELECT 
                                                                        SUM(CASE WHEN status_bdm = '2' THEN commision_bdm ELSE 0 END) +
                                                                        SUM(CASE WHEN status_bm = '2' THEN commision_bm ELSE 0 END) +
                                                                        SUM(CASE WHEN status_te = '2' THEN commision_te ELSE 0 END) 
                                                                    FROM ca_cu_payout),0) +

                                                                    COALESCE((SELECT SUM(referral_amount) FROM customer_reference_payout WHERE status='2'),0) +

                                                                    COALESCE((SELECT 
                                                                        SUM(CASE WHEN ta_status = '2' THEN ta_amt ELSE 0 END) +
                                                                        SUM(CASE WHEN te_status = '2' THEN te_amt ELSE 0 END) +
                                                                        SUM(CASE WHEN bm_status = '2' THEN bm_amt ELSE 0 END) +
                                                                        SUM(CASE WHEN cu1_status = '2' THEN cu1_amt ELSE 0 END) +
                                                                        SUM(CASE WHEN cu2_status = '2' THEN cu2_amt ELSE 0 END) +
                                                                        SUM(CASE WHEN cu3_status = '2' THEN cu3_amt ELSE 0 END) 
                                                                    FROM product_payout),0)

                                                                AS commission_pending;
                                                            ");
                                                            $stmt->execute();
                                                            $row = $stmt->fetch(PDO::FETCH_ASSOC);
                                                            $commission_pending = $row['commission_pending'] ?? 0;
                                                            echo '<h3 class="mb-0 text-dark">&#8377;'.formatIndianCurrency($commission_pending).'</h3>';
                                                        ?>
                                                        <!-- <h3 class="mb-0 text-dark commissionAmount">&#8377; 15.<span class="text-danger">25%</span></h3> -->
                                                    </div>
                                                </div>
                                                <div class="d-flex justify-content-center my-3">
                                                    <a href="payout/sub_franchisee_payout.php" class="text-danger-emphasis bg-danger-subtle border border-danger-subtle rounded-3 fw-bolder text-center py-1 viewDetailsButton4" role="button" style="width: 190px;">View details</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- <div class="col-md-4 col-sm-6 col-12">
                                        <div class="card card-equal mini-stats-wid rounded-4">
                                            <div class="card-body">
                                                <div class="d-flex">
                                                    <div class="flex-grow-1">
                                                        <p class="text-muted fw-medium">Techno Enterprise</p>
                                                        <?php
                                                        $stmt = $conn->prepare("SELECT count(corporate_agency_id) as totalcorporate_agency FROM corporate_agency where user_type='16' and status='1' ");
                                                        $stmt->execute();
                                                        $stmt->setFetchMode(PDO::FETCH_ASSOC);
                                                        if ($stmt->rowCount() > 0) {
                                                            foreach (($stmt->fetchAll()) as $key => $row) {
                                                                $totalcorporate_agency = $row['totalcorporate_agency'];
                                                                echo '<h4 class="mb-0">' . $totalcorporate_agency . '</h4>';
                                                            }
                                                        } else {
                                                            echo '<h4 class="mb-0">0</h4>';
                                                        }
                                                        ?>
                                                    </div>

                                                    <div class="flex-shrink-0">
                                                        <div class="mini-stat-icon avatar-sm rounded-circle bg-primary">
                                                            <span class="avatar-title">
                                                                <i class="fas fa-user-alt font-size-24"></i>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-4 col-sm-6 col-12">
                                        <div class="card card-equal mini-stats-wid rounded-4">
                                            <div class="card-body">
                                                <div class="d-flex">
                                                    <div class="flex-grow-1">
                                                        <p class="text-muted fw-medium">Travel Consultant</p>
                                                        <?php
                                                        $stmt = $conn->prepare("SELECT count(ca_travelagency_id) as totalca_travelagency FROM ca_travelagency where user_type='11' and status='1' ");
                                                        $stmt->execute();
                                                        $stmt->setFetchMode(PDO::FETCH_ASSOC);
                                                        if ($stmt->rowCount() > 0) {
                                                            foreach (($stmt->fetchAll()) as $key => $row) {
                                                                $totalca_travelagency = $row['totalca_travelagency'];
                                                                echo '<h4 class="mb-0">' . $totalca_travelagency . '</h4>';
                                                            }
                                                        } else {
                                                            echo '<h4 class="mb-0">0</h4>';
                                                        }
                                                        ?>
                                                    </div>

                                                    <div class="flex-shrink-0">
                                                        <div class="mini-stat-icon avatar-sm rounded-circle bg-primary">
                                                            <span class="avatar-title">
                                                                <i class="fas fa-user-alt font-size-24"></i>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-4 col-sm-6 col-12">
                                        <div class="card card-equal mini-stats-wid rounded-4">
                                            <div class="card-body">
                                                <div class="d-flex">
                                                    <div class="flex-grow-1">
                                                        <p class="text-muted fw-medium">Customers</p>
                                                        <?php
                                                        $stmt = $conn->prepare("SELECT count(ca_customer_id) as totalca_customer FROM ca_customer where user_type='10' and status='1' ");
                                                        $stmt->execute();
                                                        $stmt->setFetchMode(PDO::FETCH_ASSOC);
                                                        if ($stmt->rowCount() > 0) {
                                                            foreach (($stmt->fetchAll()) as $key => $row) {
                                                                $totalca_customer = $row['totalca_customer'];
                                                                echo '<h4 class="mb-0">' . $totalca_customer . '</h4>';
                                                            }
                                                        } else {
                                                            echo '<h4 class="mb-0">0</h4>';
                                                        }
                                                        ?>
                                                    </div>

                                                    <div class="flex-shrink-0">
                                                        <div class="mini-stat-icon avatar-sm rounded-circle bg-primary">
                                                            <span class="avatar-title">
                                                                <i class="fas fa-user-alt font-size-24"></i>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-4 col-sm-6 col-12">
                                        <div class="card card-equal mini-stats-wid rounded-4">
                                            <div class="card-body">
                                                <div class="d-flex">
                                                    <div class="flex-grow-1">
                                                        <p class="text-muted fw-medium">Master Franchise</p>
                                                        <?php
                                                        $stmt = $conn->prepare("SELECT count(master_franchisee_id) as totalmaster_franchisee FROM master_franchisee where user_type='28' and status='1' ");
                                                        $stmt->execute();
                                                        $stmt->setFetchMode(PDO::FETCH_ASSOC);
                                                        if ($stmt->rowCount() > 0) {
                                                            foreach (($stmt->fetchAll()) as $key => $row) {
                                                                $totalmaster_franchisee = $row['totalmaster_franchisee'];
                                                                echo '<h4 class="mb-0">' . $totalmaster_franchisee . '</h4>';
                                                            }
                                                        } else {
                                                            echo '<h4 class="mb-0">0</h4>';
                                                        }
                                                        ?>
                                                    </div>

                                                    <div class="flex-shrink-0">
                                                        <div class="mini-stat-icon avatar-sm rounded-circle bg-primary">
                                                            <span class="avatar-title">
                                                                <i class="fas fa-user-alt font-size-24"></i>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-4 col-sm-6 col-12">
                                        <div class="card card-equal mini-stats-wid rounded-4">
                                            <div class="card-body">
                                                <div class="d-flex">
                                                    <div class="flex-grow-1">
                                                        <p class="text-muted fw-medium">Sponsor Franchise</p>
                                                        <?php
                                                        $stmt = $conn->prepare("SELECT count(sponsor_franchisee_id) as totalsponsor_franchisee FROM sponsor_franchisee where user_type='30' and status='1' ");
                                                        $stmt->execute();
                                                        $stmt->setFetchMode(PDO::FETCH_ASSOC);
                                                        if ($stmt->rowCount() > 0) {
                                                            foreach (($stmt->fetchAll()) as $key => $row) {
                                                                $totalsponsor_franchisee = $row['totalsponsor_franchisee'];
                                                                echo '<h4 class="mb-0">' . $totalsponsor_franchisee . '</h4>';
                                                            }
                                                        } else {
                                                            echo '<h4 class="mb-0">0</h4>';
                                                        }
                                                        ?>
                                                    </div>

                                                    <div class="flex-shrink-0">
                                                        <div class="mini-stat-icon avatar-sm rounded-circle bg-primary">
                                                            <span class="avatar-title">
                                                                <i class="fas fa-user-alt font-size-24"></i>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-4 col-sm-6 col-12">
                                        <div class="card card-equal mini-stats-wid rounded-4">
                                            <div class="card-body">
                                                <div class="d-flex">
                                                    <div class="flex-grow-1">
                                                        <p class="text-muted fw-medium">Franchise</p>
                                                        <?php
                                                        $stmt = $conn->prepare("SELECT count(sub_franchisee_id) as totalsub_franchisee FROM sub_franchisee where user_type='29' and status='1' ");
                                                        $stmt->execute();
                                                        $stmt->setFetchMode(PDO::FETCH_ASSOC);
                                                        if ($stmt->rowCount() > 0) {
                                                            foreach (($stmt->fetchAll()) as $key => $row) {
                                                                $totalsub_franchisee = $row['totalsub_franchisee'];
                                                                echo '<h4 class="mb-0">' . $totalsub_franchisee . '</h4>';
                                                            }
                                                        } else {
                                                            echo '<h4 class="mb-0">0</h4>';
                                                        }
                                                        ?>
                                                    </div>

                                                    <div class="flex-shrink-0">
                                                        <div class="mini-stat-icon avatar-sm rounded-circle bg-primary">
                                                            <span class="avatar-title">
                                                                <i class="fas fa-user-alt font-size-24"></i>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div> -->
                                </div>
                            </div>

                            <!-- user count with revenue and commission paid and pending -->
                            <div class="col-xl-12">
                                <div class="card rounded-4 shadow mb-3">
                                    <div class="card-body pt-1">
                                        <div class="card-title pb-1 d-flex justify-content-between ps-3 pe-3">
                                            <div>
                                                <h3 class="text-dark pt-2">User Count Details</h3>
                                            </div>
                                            <div class="text-end d-flex align-items-center">
                                                <span class="fs-6">
                                                    <p>Select Month & Year</p>
                                                    <input type="month" id="userCountCommissionDate" value="" min="2020-01" max="" class="rounded-3 border border-secondary-subtle">
                                                </span>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="col-12 table-responsive text-center">
                                            <table class="table mb-0">
                                                <thead>
                                                    <tr>
                                                        <th class="bg-dark-subtle fs-6">Users</th>
                                                        <th class="bg-dark-subtle">Total</th>
                                                        <th class="bg-dark-subtle text-end">Revenue</th>
                                                        <th class="bg-dark-subtle text-end">Commissions</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="userCountCommission">
                                                    <!-- gets data from ajax call. File name - index_ajax/user_count_commission.php -->
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- line chart -->
                            <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                                <div class="card rounded-4 mb-3">
                                    <div class="card-body pt-2">
                                        <div class="d-flex justify-content-between">
                                            <h3 class="text-dark pt-2">Customer Chart</h3>
                                            <select id="customer_years_id" onchange="customerLineChart()" class="mb-2 rounded-2 px-2 border border-secondary-subtle"></select>
                                        </div>
                                        <div id="line-chart" data-colors='["--bs-success"]' class="e-charts"></div>
                                        <div class="d-flex justify-content-between mt-3">
                                            <select id="customer_month_id" onchange="customerLineChart()" class="mb-2 rounded-2 px-3 border border-secondary-subtle"></select>
                                            <p class="mb-2 rounded-2 px-3 border border-secondary-subtle text-black fw-bold">Count: <span class="text-primary fw-normal" id="count"></span></p>
                                            <p class="mb-2 rounded-2 px-3 border border-secondary-subtle text-black fw-bold">Revenue: <span class="text-success fw-normal" id="revenue">&#8377; </span></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- doughnut chart  -->
                            <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                                <div class="card rounded-4 mb-3">
                                    <div class="card-body pt-2">
                                        <div class="d-flex justify-content-between">
                                            <h3 class="text-dark pt-2">Revenue Chart</h3>
                                            <select id="revenue_years_id" onchange="getAllUserRevenue(this.value)" class="mb-2 rounded-2 px-2 border border-secondary-subtle"></select>
                                        </div>
                                        <h2 class="fw-bold pt-2 pb-3 text-dark ">&#8377;<span class=" fw-normal" id="revenueAllUsers">  </span></h2>
                                        <div id="doughnut-chart"  class="e-charts"></div>
                                    </div>
                                </div>
                            </div>
                            <!-- Membership overview  -->
                            <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                                <div class="card rounded-4 shadow mb-3">
                                    <div class="card-body pt-2">
                                        <h3 class="text-dark pt-2">Membership Overview</h3>
                                        <hr>
                                        <div class="col-12 table-responsive text-center">
                                            <?php
                                                // get custommer count base on membership selected 
                                                $stmt = $conn->prepare("
                                                    SELECT 
                                                        COUNT(CASE WHEN customer_type = 'Free' THEN ca_customer_id END) AS free_customers,
                                                        COUNT(CASE WHEN customer_type = 'Premium' THEN ca_customer_id END) AS premium_customers,
                                                        COUNT(CASE WHEN customer_type = 'Premium plus' THEN ca_customer_id END) AS premium_plus_customers,
                                                        COUNT(CASE WHEN customer_type = 'Premium Select' THEN ca_customer_id END) AS premium_select_customers,
                                                        COUNT(CASE WHEN customer_type = 'Premium Select Lite' THEN ca_customer_id END) AS premium_select_lite_customers,
                                                        COUNT(CASE WHEN customer_type = 'neo select' THEN ca_customer_id END) AS neo_select_customers,
                                                        COUNT(CASE WHEN customer_type = 'neo select ultra' THEN ca_customer_id END) AS neo_select_ultra_customers
                                                    FROM ca_customer
                                                    WHERE user_type = '10' 
                                                    AND status = '1';
                                                ");
                                                $stmt->execute();
                                                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                                                $free_customers = $row['free_customers'] ?? 0;
                                                $premium_customers = $row['premium_customers'] ?? 0;
                                                $premium_plus_customers = $row['premium_plus_customers'] ?? 0;
                                                $premium_select_customers = $row['premium_select_customers'] ?? 0;
                                                $premium_select_lite_customers = $row['premium_select_lite_customers'] ?? 0;
                                                $neo_select_customers = $row['neo_select_customers'] ?? 0;
                                                $neo_select_ultra_customers = $row['premium_select_lite_customers'] ?? 0;

                                                // get custommer count base on membership selected and if complimentary
                                                $stmt2 = $conn->prepare("
                                                    SELECT 
                                                        COUNT(CASE WHEN customer_type = 'Free' THEN ca_customer_id END) AS free_customers_comp,
                                                        COUNT(CASE WHEN customer_type = 'Premium' THEN ca_customer_id END) AS premium_customers_comp,
                                                        COUNT(CASE WHEN customer_type = 'Premium plus' THEN ca_customer_id END) AS premium_plus_customers_comp,
                                                        COUNT(CASE WHEN customer_type = 'Premium Select' THEN ca_customer_id END) AS premium_select_customers_comp,
                                                        COUNT(CASE WHEN customer_type = 'Premium Select Lite' THEN ca_customer_id END) AS premium_select_lite_customers_comp,
                                                        COUNT(CASE WHEN customer_type = 'neo select' THEN ca_customer_id END) AS neo_select_customers_comp,
                                                        COUNT(CASE WHEN customer_type = 'neo select ultra' THEN ca_customer_id END) AS neo_select_ultra_customers_comp
                                                    FROM ca_customer
                                                    WHERE user_type = '10' 
                                                    AND comp_chek = '1'
                                                    AND status = '1';
                                                ");
                                                $stmt2->execute();
                                                $row2 = $stmt2->fetch(PDO::FETCH_ASSOC);
                                                $free_customers_comp = $row2['free_customers_comp'] ?? 0;
                                                $premium_customers_comp = $row2['premium_customers_comp'] ?? 0;
                                                $premium_plus_customers_comp = $row2['premium_plus_customers_comp'] ?? 0;
                                                $premium_select_customers_comp = $row2['premium_select_customers_comp'] ?? 0;
                                                $premium_select_lite_customers_comp = $row2['premium_select_lite_customers_comp'] ?? 0;
                                                $neo_select_customers_comp = $row2['neo_select_customers_comp'] ?? 0;
                                                $neo_select_ultra_customers_comp = $row2['neo_select_ultra_customers_comp'] ?? 0;

                                                // get custommer amount base on membership selected
                                                $stmt3 = $conn->prepare("
                                                    SELECT 
                                                        SUM(CASE WHEN customer_type = 'Premium' THEN paid_amount END) AS premium_customers_amt,
                                                        SUM(CASE WHEN customer_type = 'Premium plus' THEN paid_amount END) AS premium_plus_customers_amt,
                                                        SUM(CASE WHEN customer_type = 'Premium Select' THEN paid_amount END) AS premium_select_customers_amt,
                                                        SUM(CASE WHEN customer_type = 'Premium Select Lite' THEN paid_amount END) AS premium_select_lite_customers_amt,
                                                        SUM(CASE WHEN customer_type = 'neo select' THEN paid_amount END) AS neo_select_customers_amt,
                                                        SUM(CASE WHEN customer_type = 'neo select ultra' THEN paid_amount END) AS neo_select_ultra_customers_amt
                                                    FROM ca_customer
                                                    WHERE user_type = '10' 
                                                    AND status = '1';
                                                ");
                                                $stmt3->execute();
                                                $row3 = $stmt3->fetch(PDO::FETCH_ASSOC);
                                                $premium_customers_amt = $row3['premium_customers_amt'] ?? 0;
                                                $premium_plus_customers_amt = $row3['premium_plus_customers_amt'] ?? 0;
                                                $premium_select_customers_amt = $row3['premium_select_customers_amt'] ?? 0;
                                                $premium_select_lite_customers_amt = $row3['premium_select_lite_customers_amt'] ?? 0;
                                                $neo_select_customers_amt = $row3['neo_select_customers_amt'] ?? 0;
                                                $neo_select_ultra_customers_amt = $row3['neo_select_ultra_customers_amt'] ?? 0;
                                            ?>
                                            <table class="table mb-0">
                                                <thead>
                                                    <tr>
                                                        <th class="bg-dark-subtle fs-6">Type</th>
                                                        <th class="bg-dark-subtle">Value</th>
                                                        <th class="bg-dark-subtle text-end">Count</th>
                                                        <th class="bg-dark-subtle text-end">Complimentary</th>
                                                        <th class="bg-dark-subtle text-end">Total</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td class="py-2 align-content-center">
                                                            <p class="text-dark fs-6 align-content-center ps-2">Regular Customer</p>
                                                        </td>
                                                        <td class="py-2 align-content-center">
                                                            <p class="text-dark fs-6">&#8377; Free</p>
                                                        </td>
                                                        <td class="py-2 align-content-center">
                                                            <p class="text-dark fs-6 text-end"><?php echo $free_customers; ?></p>
                                                        </td>
                                                        <td class="py-2 align-content-center">
                                                            <p class="text-dark fs-6 text-end"><?php echo $free_customers_comp; ?></p>
                                                        </td>
                                                        <td class="py-2 align-content-center">
                                                            <p class="text-success fs-6 text-end">&#8377; Free</p>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="py-2 align-content-center">
                                                            <p class="text-dark fs-6 align-content-center ps-2">Premium Customer</p>
                                                        </td>
                                                        <td class="py-2 align-content-center">
                                                            <p class="text-dark fs-6">&#8377;30000</p>
                                                        </td>
                                                        <td class="py-2 align-content-center">
                                                            <p class="text-dark fs-6 text-end"><?php echo $premium_customers; ?></p>
                                                        </td>
                                                        <td class="py-2 align-content-center">
                                                            <p class="text-dark fs-6 text-end"><?php echo $premium_customers_comp; ?></p>
                                                        </td>
                                                        <td class="py-2 align-content-center">
                                                            <p class="text-success fs-6 text-end">&#8377; <?php echo formatIndianCurrency($premium_customers_amt); ?></p>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="py-2 align-content-center">
                                                            <p class="text-dark fs-6 align-content-center ps-2">Premium Plus Customer</p>
                                                        </td>
                                                        <td class="py-2 align-content-center">
                                                            <p class="text-dark fs-6">&#8377; 35,000</p>
                                                        </td>
                                                        <td class="py-2 align-content-center">
                                                            <p class="text-dark fs-6 text-end"><?php echo $premium_plus_customers; ?></p>
                                                        </td>
                                                        <td class="py-2 align-content-center">
                                                            <p class="text-dark fs-6 text-end"><?php echo $premium_plus_customers_comp; ?></p>
                                                        </td>
                                                        <td class="py-2 align-content-center">
                                                            <p class="text-success fs-6 text-end">&#8377; <?php echo formatIndianCurrency($premium_plus_customers_amt); ?></p>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="py-2 align-content-center">
                                                            <p class="text-dark fs-6 align-content-center ps-2">Premium Select</p>
                                                        </td>
                                                        <td class="py-2 align-content-center">
                                                            <p class="text-dark fs-6">&#8377; 35,000</p>
                                                        </td>
                                                        <td class="py-2 align-content-center">
                                                            <p class="text-dark fs-6 text-end"><?php echo $premium_select_customers; ?></p>
                                                        </td>
                                                        <td class="py-2 align-content-center">
                                                            <p class="text-dark fs-6 text-end"><?php echo $premium_select_customers_comp; ?></p>
                                                        </td>
                                                        <td class="py-2 align-content-center">
                                                            <p class="text-success fs-6 text-end">&#8377; <?php echo formatIndianCurrency($premium_select_customers_amt); ?></p>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="py-2 align-content-center">
                                                            <p class="text-dark fs-6 align-content-center ps-2">Premium Select Lite</p>
                                                        </td>
                                                        <td class="py-2 align-content-center">
                                                            <p class="text-dark fs-6">&#8377; 21,000</p>
                                                        </td>
                                                        <td class="py-2 align-content-center">
                                                            <p class="text-dark fs-6 text-end"><?php echo $premium_select_lite_customers; ?></p>
                                                        </td>
                                                        <td class="py-2 align-content-center">
                                                            <p class="text-dark fs-6 text-end"><?php echo $premium_select_lite_customers_comp; ?></p>
                                                        </td>
                                                        <td class="py-2 align-content-center">
                                                            <p class="text-success fs-6 text-end">&#8377; <?php echo formatIndianCurrency($premium_select_lite_customers_amt); ?></p>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="py-2 align-content-center">
                                                            <p class="text-dark fs-6 align-content-center ps-2">Neo Select</p>
                                                        </td>
                                                        <td class="py-2 align-content-center">
                                                            <p class="text-dark fs-6">&#8377; 11,000</p>
                                                        </td>
                                                        <td class="py-2 align-content-center">
                                                            <p class="text-dark fs-6 text-end"><?php echo $neo_select_customers; ?></p>
                                                        </td>
                                                        <td class="py-2 align-content-center">
                                                            <p class="text-dark fs-6 text-end"><?php echo $neo_select_customers_comp; ?></p>
                                                        </td>
                                                        <td class="py-2 align-content-center">
                                                            <p class="text-success fs-6 text-end">&#8377; <?php echo formatIndianCurrency($neo_select_customers_amt); ?></p>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="py-2 align-content-center">
                                                            <p class="text-dark fs-6 align-content-center ps-2">Neo Select Ultra</p>
                                                        </td>
                                                        <td class="py-2 align-content-center">
                                                            <p class="text-dark fs-6">&#8377; 11,000</p>
                                                        </td>
                                                        <td class="py-2 align-content-center">
                                                            <p class="text-dark fs-6 text-end"><?php echo $neo_select_ultra_customers; ?></p>
                                                        </td>
                                                        <td class="py-2 align-content-center">
                                                            <p class="text-dark fs-6 text-end"><?php echo $neo_select_ultra_customers_comp; ?></p>
                                                        </td>
                                                        <td class="py-2 align-content-center">
                                                            <p class="text-success fs-6 text-end">&#8377; <?php echo formatIndianCurrency($neo_select_ultra_customers_amt); ?></p>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- doughnut chart  -->
                            <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                                <div class="card rounded-4 mb-3">
                                    <div class="card-body pt-2">
                                        <div class="d-flex justify-content-between">
                                            <h3 class="text-dark pt-2">Holiday Packages</h3>
                                            <select id="holiday_years_id" onchange="getHolidayRevenue(this.value)" class="mb-2 rounded-2 px-2 border border-secondary-subtle"></select>
                                        </div>
                                        <h3 class="fw-bold pt-2 pb-3">&#8377;<span class=" fw-normal" id="holiday_revenue">  </span></h3>
                                        <div id="doughnut-chart-2" class="e-charts"></div>
                                    </div>
                                </div>
                            </div>
                            <!-- Top performer   -->
                            <div class="col-lg-12 col-md-12">
                                <div class="card rounded-4 shadow mb-3">
                                    <div class="card-body pt-2">
                                        <div class="card-title pb-1 d-flex justify-content-between ps-3 pe-3">
                                            <div>
                                                <h3 class="text-dark pt-2">Top Performer</h3>
                                            </div>
                                            <div class="text-end d-flex align-items-center">
                                                <span class="fs-6">
                                                    <p>Select Month & Year</p>
                                                    <input type="month" id="topPerformerDate" value="" min="2020-01" max="" class="rounded-3 border border-secondary-subtle">
                                                </span>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="mb-2">
                                            <ul class="nav nav-pills d-flex justify-content-between" id="navMenu">
                                                <li class="nav-item">
                                                    <a class="nav-link top_p active" aria-current="page" href="#" value="bm">Business Mentor</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link top_p" href="#" value="mf">Master Franchisees</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link top_p" href="#" value="sf">Sponsor Franchisees</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link top_p" href="#" value="te">Techno Enterprise</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link top_p" href="#" value="sub_f">Franchisees</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link top_p" href="#" value="ins">Institute</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link top_p" href="#" value="tc">Travel Consultants</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link top_p" href="#" value="cu">Customers</a>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="col-12 table-responsive text-center">
                                            <table class="table mb-0">
                                                <thead>
                                                    <tr>
                                                        <th class="bg-dark-subtle fs-6">ID</th>
                                                        <th class="bg-dark-subtle">Name</th>
                                                        <th class="bg-dark-subtle text-end">Total Count</th>
                                                        <th class="bg-dark-subtle text-end">Amount</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="topPerformer">
                                                    <!-- gets data from ajax call. File name - index_ajax/top_performer.php -->
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Calender   -->
                            <div class="col-xl-8 col-lg-12">
                                <div class="row">
                                    <div class="col-xl-12 col-lg-12" id="eventCalender">
                                        <!-- Full Calender Start-->
                                        <div class="card rounded-4">
                                            <div id="btn-new-event"></div>
                                            <div id='locale-selector' class="d-none"></div>
                                            <div class="card-body">
                                                <div id="external-events">
                                                    <button type="button" data-bs-toggle="modal" data-bs-target="#event-modal" class="btn btn-success btn-rounded waves-effect waves-light mb-2 me-2 addBusinessTraineemodal"><i class="mdi mdi-plus me-1"></i> Add Event</button>
                                                </div>
                                                <div id="calendar" class="calendarheight"></div>
                                            </div>
                                        </div>
                                        <div class="modal fade" id="event-modal" tabindex="-1">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header py-3 px-4 border-bottom-0">
                                                        <h5 class="modal-title" id="modal-title">Event</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                                                    </div>
                                                    <div class="modal-body p-4">
                                                        <form class="needs-validation" name="event-form" id="form-event" novalidate>
                                                            <div class="row">
                                                                <div class="col-12">
                                                                    <div class="mb-3">
                                                                        <label class="form-label">Event Name</label>
                                                                        <input class="form-control" placeholder="Insert Event Name"
                                                                            type="text" name="title" id="event-title" required value="" />

                                                                        <label class="form-label">Add Event Date</label>
                                                                        <input class="form-control" placeholder="Insert Event Data"
                                                                            type="date" name="title" id="event-date" required value="" />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row mt-2">
                                                                <div class=" text-end">
                                                                    <button type="button" class="btn btn-light me-1" data-bs-dismiss="modal">Close</button>
                                                                    <button type="submit" class="btn btn-success" id="btn-save-event">Save</button>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Full Calender end -->
                                    </div>
                                    <div class="col-xl-12 col-lg-12" id="latestTransaction">
                                        <!-- Latest Transaction Start-->
                                        <div class="card rounded-4">
                                            <h2 class="fs-4 p-3">Latest Transaction</h2>
                                            <?php
                                                $sql1 = "SELECT corporate_agency_id as id, firstname, lastname, profile_pic, register_date as date, user_type, amount as amount, payment_mode, status FROM corporate_agency UNION ALL 
                                                        SELECT ca_travelagency_id as id, firstname, lastname, profile_pic, register_date as date, user_type, amount as amount, payment_mode, status FROM ca_travelagency UNION ALL 
                                                        SELECT sub_franchisee_id as id, firstname, lastname, profile_pic, register_date as date, user_type, amount as amount, payment_mode, status FROM sub_franchisee UNION ALL
                                                        SELECT master_franchisee_id as id, firstname, lastname, profile_pic, register_date as date, user_type, paid_amount as amount, payment_mode, status FROM master_franchisee UNION ALL
                                                        SELECT sponsor_franchisee_id as id, firstname, lastname, profile_pic, register_date as date, user_type, paid_amount as amount, payment_mode, status FROM sponsor_franchisee 
                                                        WHERE status='1' order by date desc limit 5";
                                                $stmt1 = $conn->prepare($sql1);
                                                $stmt1->execute();
                                                $stmt1->setFetchMode(PDO::FETCH_ASSOC);
                                                if ($stmt1->rowCount() > 0) {
                                                    foreach (($stmt1->fetchAll()) as $key => $row) {
                                                        if ($row['user_type'] == "16") {
                                                            $designation = "Techno Enterprise";
                                                        } else if ($row['user_type'] == "29") {
                                                            $designation = "Franchisee";
                                                        } else if ($row['user_type'] == "11") {
                                                            $designation = "Travel Consultant";
                                                        }else if ($row['user_type'] == "28") {
                                                            $designation = "Master Franchisee";
                                                        }else if ($row['user_type'] == "30") {
                                                            $designation = "Sponsor Franchisee";
                                                        }
                                                        $rd = new DateTime($row['date']);
                                                        $rdate = $rd->format('d-m-Y');
                                                        $TAmt = $row['amount'];
                                                        $pathFromDB=$row['profile_pic'];
                                                        $dir  = dirname($pathFromDB);   // profile_pic
                                                        $file = basename($pathFromDB);
                                                        $imgPath = "../uploading/" . $dir . "/" . rawurlencode($file);
                                                        $CATAmt = preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $TAmt);
                                                        echo '
                                                                <div class="row mx-0">
                                                                    <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-2">
                                                                        <div class="profile-pic pb-1" style="position: relative; left: 15px;">
                                                                            <img src="' . $imgPath . '" alt="profile pic" class="rounded-circle" width="50px" height="50px">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
                                                                        <div class="name fw-bold">' . $row['id'] . ' ' . $row['firstname'] . ' ' . $row['lastname'] . '</br> <span class="fw-normal fontSizeTransaction">(' . $designation . ')</span></div>
                                                                    </div>
                                                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-4">
                                                                        <div class="row">
                                                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6 px-0">
                                                                                <div class="name fw-bold">Transfered</br> <span class="fw-normal fontSizeTransaction">' . $rdate . '</span></div>
                                                                            </div>
                                                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6 px-0">
                                                                                <div class="name fw-bold text-success">&#8377; ' . $CATAmt . '/-</br> <span class="fw-normal text-dark fontSizeTransaction">' . $row['payment_mode'] . '</span></div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <hr />
                                                                </div>
                                                            ';
                                                    }
                                                } else {
                                                    echo '
                                                            <div><p>No Transaction Found</p></div>
                                                        ';
                                                }
                                            ?>  
                                            <div class="col-md-12 col-sm-12 col-12 pb-3 pe-3">
                                                <a href="latest_transaction/latest_transaction.php"><button class="cpn_btn box-btn float-end">View More</button></a>
                                            </div>
                                        </div>
                                        <!-- Latest Transaction End-->
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-12">
                                <div class="card rounded-4">
                                    <div class="d-flex justify-content-between">
                                        <h2 class="fs-4 p-3 px-2">Upcoming Birthdays</h2>
                                        <div class="mt-2 me-2">
                                            <a href="upcoming_birthday/upcoming_birthday.php"><button class="cpn_btn box-btn">View More</button></a>
                                        </div>
                                    </div>
                                    <div class="row mx-0">
                                    <?php

                                        $stmt = $conn->prepare("SELECT *
                                            FROM (
                                                SELECT business_mentor_id AS user_id, firstname, lastname, date_of_birth, profile_pic, status, 'Business Mentor' AS userName
                                                FROM business_mentor

                                                UNION ALL

                                                SELECT master_franchisee_id AS user_id, firstname, lastname, date_of_birth, profile_pic, status, 'Master Franchisee' AS userName
                                                FROM master_franchisee

                                                UNION ALL

                                                SELECT sponsor_franchisee_id AS user_id, firstname, lastname, date_of_birth, profile_pic, status, 'Sponsor Franchisee' AS userName
                                                FROM sponsor_franchisee

                                                UNION ALL

                                                SELECT corporate_agency_id AS user_id, firstname, lastname, date_of_birth, profile_pic, status, 'Techno Enterprise' AS userName
                                                FROM corporate_agency

                                                UNION ALL

                                                SELECT sub_franchisee_id AS user_id, firstname, lastname, date_of_birth, profile_pic, status, 'Franchisee' AS userName
                                                FROM sub_franchisee

                                                UNION ALL

                                                SELECT institution_id AS user_id, firstname, lastname, date_of_birth, profile_pic, status, 'Institution' AS userName
                                                FROM institution

                                                UNION ALL

                                                SELECT ca_travelagency_id AS user_id, firstname, lastname, date_of_birth, profile_pic, status, 'Travel Consultant' AS userName
                                                FROM ca_travelagency

                                                UNION ALL

                                                SELECT ca_customer_id AS user_id, firstname, lastname, date_of_birth, profile_pic, status, 'Customer' AS userName
                                                FROM ca_customer
                                            ) users
                                            WHERE date_add(date_of_birth,
                                                    INTERVAL YEAR(CURDATE()) - YEAR(date_of_birth)
                                                    + IF(DAYOFYEAR(CURDATE()) > DAYOFYEAR(date_of_birth),1,0)
                                                    YEAR
                                            ) BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 30 DAY)
                                            ORDER BY MONTH(date_of_birth), DAY(date_of_birth)
                                            LIMIT 12;
                                        ");

                                        $stmt->execute();
                                        $stmt->setFetchMode(PDO::FETCH_ASSOC);
                                        if($stmt->rowCount()>0){
                                            foreach (($stmt->fetchAll()) as $key => $row) {
                                                $user_id = $row['user_id'];
                                                $fullname = $row['firstname'].' '.$row['lastname'];
                                                $userName = $row['userName'];

                                                $profile_pic = $row['profile_pic'];
                                                $imgPath = '../uploading/'.$profile_pic;

                                                $today = date("Y-m-d");
                                                $dob = $row['date_of_birth'];
                                                $birthDate = date("d-m-Y", strtotime($dob));
                                                $get_age = date_diff(date_create($birthDate), date_create($today));
                                                
                                                // find days difference from today
                                                $dayMonth = date("d-M", strtotime($dob));
                                                $cust_dob = date("Y").'-'.date("m", strtotime($dob)).'-'.date("d", strtotime($dob));
                                                $now = time(); 
                                                $new_dob = strtotime($cust_dob);
                                                $datediff = $new_dob - $now;
                                                $daysLeft = round($datediff / (60 * 60 * 24));
                                                
                                                //get customer details
                                                // $user = userDetails($conn,$user_id,$type);
                                                // $name = $user[0];
                                                // $fullname = $user[1];

                                                echo '<div class="col-xl-3 col-lg-3 col-md-2 col-sm-2 col-2 pe-0">
                                                    <div class="profile-pic pb-1" style="position: relative; left: 5px;">
                                                        <img src="'.$imgPath.'" alt="profile pic" class="rounded-circle" width="50px" height="50px">
                                                    </div>
                                                </div>
                                                <div class="col-xl-6 col-lg-5 col-md-6 col-sm-6 col-6 px-0">
                                                    <div class="name fw-bold fs-5">'.$fullname.'</br> <span class="fw-normal fontSizeTransaction">('.$userName.')</span></div>
                                                </div>
                                                <div class="col-xl-3 col-lg-4 col-md-4 col-sm-4 col-4 px-0">
                                                    <div class="name fw-bold fs-6 text-primary text-end me-3">'.$dayMonth.' &#127874;</span></div>
                                                </div>
                                                <hr />';
                                            }
                                        }
                                    ?>
                                    </div>
                                </div>
                            </div>
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
            });
        </script>
        <script>
            const currentDate = new Date();
            var getCurrentYear = currentDate.getFullYear();
            var getCurrentMonth = currentDate.getMonth() + 1;
            var userType, monthYear;
            var monthControl = "2020";

            $(function() {
                // get min and max month for input tag
                const date = new Date()
                const month = ("0" + (date.getMonth() + 1)).slice(-2)
                const year = date.getFullYear()
                monthControl.value = `${year}-${month}`;
                // console.log(monthControl.value);

                // Set Default value for years for line chart
                for (let index = 2023; index <= getCurrentYear; index++) {
                    if (index == getCurrentYear) {
                        $("#customer_years_id").append('<option selected="selected" value="' + index + '">' + index + '</option>');
                        $("#revenue_years_id").append('<option  value="' + index + '">' + index + '</option><option selected="selected" value="all">All</option>');
                        $("#holiday_years_id").append('<option value="' + index + '">' + index + '</option><option selected="selected" value="all">All</option>');
                        $("#years").append('<option selected="selected" value="' + index + '">' + index + '</option>');
                        $("#yearsCustMemb").append('<option selected="selected" value="' + index + '">' + index + '</option>');
                        $("#consultant_years").append('<option selected="selected" value="' + index + '">' + index + '</option>');
                        $("#partner_years").append('<option selected="selected" value="' + index + '">' + index + '</option>');
                    } else {
                        $("#customer_years_id").append('<option value="' + index + '">' + index + '</option>');
                        $("#revenue_years_id").append('<option value="' + index + '">' + index + '</option>');
                        $("#holiday_years_id").append('<option value="' + index + '">' + index + '</option>');
                        $("#years").append('<option value="' + index + '">' + index + '</option>');
                        $("#yearsCustMemb").append('<option value="' + index + '">' + index + '</option>');
                        $("#consultant_years").append('<option value="' + index + '">' + index + '</option>');
                        $("#partner_years").append('<option value="' + index + '">' + index + '</option>');
                    }
                }

               // Month selector
                const monthNames = [
                    "All","January", "February", "March", "April",
                    "May", "June", "July", "August",
                    "September", "October", "November", "December"
                ];

                const selects = [
                    "#customer_month_id"
                ];

                monthNames.forEach((monthText, index) => {

                    selects.forEach(id => {
                        $(id).append('<option value="' + index + '">' + monthText + '</option>');
                    });

                });

                monthYear = monthControl.value;
            });

            //customer line chart
            var chartDom = document.getElementById('line-chart');
            var myChart = echarts.init(chartDom);

            async function customerChart(month,year) {
                try {
                    let response = await fetch("charts/get_customer_line_echart.php", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/x-www-form-urlencoded"
                        },
                        body: new URLSearchParams({
                            month: month,
                            year: year
                        })
                    });

                    let data = await response.json();

                    var option = {
                        tooltip: {
                            trigger: 'axis'
                        },
                        xAxis: {
                            type: 'category',
                            data: data.months
                        },
                        yAxis: {
                            type: 'value'
                        },
                        series: [{
                            name: 'Customers',
                            type: 'line',
                            smooth: true,
                            data: data.data,
                            lineStyle: {
                                color: "#2ab57d"
                            },
                            itemStyle: {
                                color: "#2ab57d"
                            }
                        }]
                    };

                    myChart.setOption(option);

                    // update dashboard values
                    document.getElementById("count").innerHTML = data.count;
                    document.getElementById("revenue").innerHTML = data.revenue;

                } catch (error) {
                    console.error("Chart loading error:", error);
                }
            }

            //updated Code for graph 2 start
            var chartDom2 = document.getElementById('doughnut-chart');
            var myChart2 = echarts.init(chartDom2);
            
            async function getAllUserRevenue(year){

                try{
                    let response = await fetch("charts/get_revenue_doughnut_echart.php",
                    {
                        method:"POST",
                        headers:{
                            "Content-Type":"application/x-www-form-urlencoded"
                        },
                        body:"year="+encodeURIComponent(year)
                    });

                    let data = await response.json();

                    let chartData = [];

                    for(let i=0;i<data.labels.length;i++){
                        chartData.push({
                            value:data.values[i],
                            name:data.labels[i]
                        });
                    }

                    var option = {
                        tooltip:{
                            trigger:'item'
                        },
                        legend:{
                            orient:'vertical',
                            left:'0%',
                            top:'middle'
                        },
                        series:[
                            {
                                name:'Users',
                                type:'pie',
                                radius:['40%','70%'],
                                center:['60%','50%'],
                                avoidLabelOverlap:false,
                                itemStyle:{
                                    borderRadius:8,
                                    borderColor:'#fff',
                                    borderWidth:2
                                },
                                data:chartData
                            }
                        ]
                    };
                    myChart2.setOption(option);
                    document.getElementById("revenueAllUsers").innerHTML = data.revenue;
                }catch(error){
                    console.error("Chart loading error:",error);
                }
            }
            //end graph 2

            //Revenue doughnut-chart 2 graph 3
            var chartDom3 = document.getElementById('doughnut-chart-2');
            var myChart3 = echarts.init(chartDom3);

            async function getHolidayRevenue(year){

                try{
                    let response = await fetch("charts/get_holiday_revenue_doughnut_echart.php",
                    {
                        method:"POST",
                        headers:{
                            "Content-Type":"application/x-www-form-urlencoded"
                        },
                        body:"year="+encodeURIComponent(year)
                    });
                
                    let data = await response.json();

                    let chartData = [];

                    for(let i=0;i<data.labels.length;i++){
                        chartData.push({
                            value: data.values[i],
                            name: data.labels[i]
                        });
                    }

                    var option = {
                        tooltip: {
                            trigger: 'item'
                        },
                        legend: {
                            orient: 'vertical',
                            left: '0%',
                            top: 'middle'
                        },
                        series: [
                            {
                                name: 'Users',
                                type: 'pie',
                                radius: ['40%', '70%'],   // makes it doughnut
                                avoidLabelOverlap: false,
                                itemStyle: {
                                    borderRadius: 8,
                                    borderColor: '#fff',
                                    borderWidth: 2
                                },
                                label: {
                                    show: false
                                },
                                emphasis: {
                                    label: {
                                        show: true,
                                        fontSize: 16,
                                        fontWeight: 'bold'
                                    }
                                },
                                labelLine: {
                                    show: false
                                },
                                data: chartData
                            }
                        ]
                    };
                    myChart3.setOption(option);
                    document.getElementById("holiday_revenue").innerHTML = data.holiday_revenue;
                }catch(error){
                    console.error("Chart loading error:",error);
                }
            }   

            // load chart on page load
            document.addEventListener("DOMContentLoaded",()=>{
                year = "all";
                month = "all";
                customerChart(month,year);
                getAllUserRevenue(year);
                getHolidayRevenue(year);
            });

            function customerLineChart(){

                let customerYear = $("#customer_years_id").val();
                let customerMonth = $("#customer_month_id").val();

                // convert month 0 → all
                if(customerMonth == 0){
                    customerMonth = "all";
                }

                console.log(customerYear + " " + customerMonth);

                customerChart(customerMonth, customerYear);
            }
            //end graph 3

        </script>

        <!-- calender get data and insert data  -->
        <script type="text/javascript">
            
            function showCalender() {
                var calendarEl = document.getElementById('calendar');

                var calendar = new FullCalendar.Calendar(calendarEl, {
                    initialView: 'dayGridMonth',

                    // ✅ Called whenever the calendar view changes (e.g. next/prev month)
                    datesSet: function() {
                        fetchAndMarkTransactionDates(); // Custom dots or styles, if any
                    },

                    // ✅ Called when user clicks a date
                    dateClick: function(info) {
                        const clickedDate = info.dateStr; // Format: YYYY-MM-DD
                        fetchTransactionsByDate(clickedDate);
                    },

                    // ✅ Load events for the calendar (optional for dots)
                    events: function(fetchInfo, successCallback, failureCallback) {
                        $.ajax({
                            url: 'calendar/loadEvent.php',
                            type: 'GET',
                            success: function(data) {
                                try {
                                    const events = JSON.parse(data);
                                    successCallback(events); // Pass parsed events to FullCalendar
                                } catch (err) {
                                    console.error("JSON Parse Error:", err);
                                    failureCallback(err);
                                }
                            },
                            error: function(err) {
                                console.error("Event Load Error:", err);
                                failureCallback(err);
                            }
                        });
                    }
                });

                calendar.render();
            }

            function fetchTransactionsByDate(date) {
                $.ajax({
                    url: 'calendar/loadTransactionByDate.php',
                    type: 'POST',
                    data: {
                        date: date
                    },
                    success: function(response) {
                        $('#latestTransaction').html(response);
                    },
                    error: function() {
                        console.error("Failed to load transactions for date:", date);
                        $('#latestTransaction').html('<p>Error loading transactions.</p>');
                    }
                });
            }

            function markTransactionDatesOnCalendar(transactionDates) {
                // Get all date cells in the calendar
                document.querySelectorAll('.fc-daygrid-day').forEach(function(cell) {
                    const cellDate = cell.getAttribute('data-date'); // Format: YYYY-MM-DD
                    if (transactionDates.includes(cellDate)) {
                        // Check if dot already exists
                        if (!cell.querySelector('.transaction-dot')) {
                            const dot = document.createElement('div');
                            dot.classList.add('transaction-dot');
                            cell.appendChild(dot);
                        }
                    }
                });
            }

            function fetchAndMarkTransactionDates() {
                $.ajax({
                    url: 'calendar/loadTransactionDates.php',
                    type: 'GET',
                    success: function(response) {
                        try {
                            const dates = JSON.parse(response); // Should be an array of YYYY-MM-DD
                            // Wait a little to ensure calendar is rendered
                            setTimeout(() => markTransactionDatesOnCalendar(dates), 500);
                        } catch (err) {
                            console.error("Error parsing transaction dates JSON:", err);
                        }
                    },
                    error: function() {
                        console.error("Error loading transaction dates");
                    }
                });
            }

            document.addEventListener('DOMContentLoaded', function() {
                showCalender(); // Your existing function
                setTimeout(fetchAndMarkTransactionDates, 800);
            });

            $('#btn-save-event').on('click', function(e) {
                e.preventDefault();
                // alert('Hello');
                var eventTitle = $('#event-title').val();
                var eventDate = $('#event-date').val();
                // console.log(eventTitle);
                // console.log(eventDate);
                var dataString = {
                    eventTitle,
                    eventDate
                }
                if (eventTitle && eventDate) {
                    $.ajax({
                        type: 'POST',
                        data: dataString,
                        url: 'calendar/insertEvent.php',
                        cache: false,
                        success: function(data) {
                            // console.log(data);
                            if (data == '1') {
                                alert("Event Added Successfully");
                                window.location.reload();
                            } else {
                                alert("Error Adding Event");
                                window.location.reload();
                            }
                        }
                    });
                } else {
                    alert("Insert Valid Values");
                    window.location.reload();
                }
            });
           
            // top performer start 6/3/2026
        
            // Get the parent UL
            const navMenu = document.getElementById('navMenu');

            // Add click listener to all child links
            navMenu.querySelectorAll('.nav-link').forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault(); // prevent page reload if href="#"
                    
                    // Remove 'active' from all links
                    navMenu.querySelectorAll('.nav-link').forEach(item => item.classList.remove('active'));
                    
                    // Add 'active' to the clicked link
                    this.classList.add('active');
                });
            });
        </script>
        <!-- top performer end 6/3/2026 -->
         
        <!-- User Count Details AND Top Performer -->
        <script>
             // Trigger on page load
            $(document).ready(function() {
                fetchUserCountDetails(); //userCountDetails
                fetchTopPerformers(); //Top performers
            });

            // ajax calls for user count details section  
            function fetchUserCountDetails(){
                var userCountDetails = $('#userCountCommissionDate').val();
                // console.log(userCountDetails);
                
                if(userCountDetails) {
                    var month = userCountDetails.split('-')[1];
                    var year = userCountDetails.split('-')[0];
                }else{
                    var month = '';
                    var year = '';
                    
                }   
                dataString = {
                    month,
                    year
                }
                console.log(dataString);
                $.ajax({
                    type: 'POST',
                    data: dataString,
                    url: 'index_ajax/user_count_commission.php',
                    cache: false,
                    success: function(data) {
                        console.log(data);
                        $('#userCountCommission').html(data);
                    }
                });
            };

            // Trigger when month changes for User count details
            $('#userCountCommissionDate').change(fetchUserCountDetails);

            // Ajax call for Top performer 
            // Function to fetch top performers
            function fetchTopPerformers() {
                var userCountDetails = $('#topPerformerDate').val();
                var user = $('.top_p.active').attr('value'); // get currently active tab

                if(userCountDetails) {
                    var month = userCountDetails.split('-')[1];
                    var year = userCountDetails.split('-')[0];

                    var dataString = {
                        month,
                        year,
                        user
                    };
                    console.log(dataString); // replace this with your AJAX call
                }else{
                    var month = "";
                    var year = "";

                    var dataString = {
                        month,
                        year,
                        user
                    };
                    console.log(dataString); // replace this with your AJAX call
                }

                $.ajax({
                type: 'POST',
                data: dataString,
                url: 'index_ajax/top_performer.php',
                cache: false,
                    success: function(data) {
                        console.log(data);
                        $('#topPerformer').html(data);
                    }
                });
            }
            
            // Trigger when month changes for top performers
            $('#topPerformerDate').change(fetchTopPerformers);

            // Trigger when tab changes
            $('.top_p').click(function(e) {
                e.preventDefault();
                $('.top_p').removeClass('active');
                $(this).addClass('active');
                fetchTopPerformers();
            });

        </script>
        
    </body>
</html>