<?php
    session_start();
    if(!isset($_SESSION['username'])){
        echo '<script>location.href = "login.php";</script>';
    }

    require 'connect.php';
    $date = date('Y'); 

    // get current date to show next payout amount  and pass it in sql @ line 129
    $date = date('F,Y'); //month and year. 'F' - month in Text form
    $Month = date('m'); //month in number form
    $Year = date('Y'); //year
    // echo "Next Date ".$date .' ;' ;
    // echo "Next Month ".$Month.' ;';
    // echo "Next Year ".$Year.' ;';
    // echo '<br>';

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
        <!-- App js -->
        <!-- <script src="assets/js/plugin.js"></script> -->
        
        <!-- FontAwesome -->
        <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" integrity="sha512-5A8nwdMOWrSz20fDsjczgUidUBR8liPYU+WymTZP1lmY9G6Oc7HlZv156XqnsgNUzTyMefFTcsFH/tnJE/+xBg==" crossorigin="anonymous" referrerpolicy="no-referrer" /> -->
        <style>
            .card-equal{
                height: 80% !important;
                width: 100% !important;
            }
            h4{
                font-size: 16px !important;
                margin-top: 10px !important;
            }
            hr{
                padding: 0 !important;
            }
            .cpn_btn{
                box-shadow:none;
                background: #ffffff00;
                border:none;
                border-radius:3px;
                color:#f9f6f6;
            }
            .box-btn{
                font-weight: 600;
                float: right;
                height: 35px;
                width: 90px;
                /* display: inline-block; */
                background: #167ee6;
                
            }
            .count-col{
                display: flex; 
                padding-top: 8px; 
                align-items: center; 
            }
            .card p{
                color: #9a9a9a;
                margin-bottom: 5px;
            }
            .card h3{
                margin-bottom: -5px;
            }
            .card {
                margin-bottom: 10px;
                position: relative;
            }

            .chart-count{
                margin-left: 2px;
                margin-right: 2px;
            }

            .page_nums {
                background-color: #d9d9d9;
                color: black;
                padding: 5px 10px;
                border-radius: 4px;
                font-weight: 500;
            }
            .pagination > .active {
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
            #user_table > thead .ceterText {
                cursor:pointer;
            }

            .middle{
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .contentDiv {
                display: none;
            }

        </style>
    </head>

    <body data-sidebar="dark">

        <!-- <body data-layout="horizontal" data-topbar="dark"> -->

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
                            <div class="col-xl-4">
                                <div class="card overflow-hidden rounded-4">
                                    <div class="bg-primary-subtle">
                                        <div class="row">
                                            <div class="col-7 pe-0">
                                                <div class="p-3 pb-4">
                                                    <h5 class="text-primary">Welcome Back !</h5>
                                                    <p class="text-primary">Dashboard</p>
                                                </div>
                                            </div>
                                            <div class="col-5 align-self-end">
                                                <img src="assets/images/profile-img.png" alt="" class="img-fluid">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body pt-0">
                                        <div class="row">
                                            <div class="col-sm-4 col-4">
                                                <div class="avatar-md profile-user-wid mb-4">
                                                    <img src="assets/images/users/avatar-1.jpg" alt="" class="img-thumbnail rounded-circle">
                                                </div>
                                                <h5 class="font-size-14 text-truncate">Admin</h5>
                                            </div>

                                            <div class="col-sm-8 col-8">
                                                <div class="pt-4">

                                                    <div class="row">
                                                        <div class="col-5 p-0">
                                                            <?php
                                                                $sqlbooking = "SELECT COUNT(id) AS booked FROM `product_payout` ";
                                                                $sqlBooked = $conn -> prepare($sqlbooking);
                                                                $sqlBooked -> execute();
                                                                $sqlBooked -> setFetchMode(PDO::FETCH_ASSOC);
                                                                if( ( $sqlBooked -> rowCount()>0 ) ){
                                                                    foreach( $sqlBooked -> fetchAll() as $key => $value) {
                                                                        $totalBooked = $value['booked'];
                                                                        echo'<h5 class="font-size-15">'.$totalBooked .'</h5>';
                                                                    }
                                                                }
                                                            ?>
                                                            <p class="text-muted mb-0 font-size-11">Packages Sold</p>
                                                        </div>
                                                        <div class="col-7 p-0">
                                                            <?php

                                                                $Amt = 0;
                                                                $sqlCaAmt = "SELECT amount FROM `corporate_agency` WHERE status = '1'";
                                                                $sqlTotalAmt = $conn -> prepare($sqlCaAmt);
                                                                $sqlTotalAmt -> execute();
                                                                $sqlTotalAmt -> setFetchMode(PDO::FETCH_ASSOC);
                                                                if( ( $sqlTotalAmt -> rowCount()>0 ) ){
                                                                    foreach( $sqlTotalAmt -> fetchAll() as $key => $value) {
                                                                        $totalAmt = $value['amount'];
                                                                        
                                                                        if($totalAmt == 'null'){
                                                                            $totalAmt = 0;
                                                                        }else{
                                                                            $totalAmt;
                                                                        }
                                                                        
                                                                        $Amt = $Amt + $totalAmt; 
                                                                        
                                                                    }
                                                                }
                                                                $Amt = preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $Amt);
                                                                echo '<h5 class="font-size-15"><span>&#8377;</span>'.$Amt .'/-</h5>';
                                                            ?>
                                                            <p class="text-muted mb-0 font-size-11">Techno Enterprise</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-8 d-flex align-items-center">
                                <div class="row">

                                    <div class="col-md-4 col-sm-6 col-12">
                                        <div class="card card-equal mini-stats-wid rounded-4">
                                            <div class="card-body">
                                                <div class="d-flex">
                                                    <div class="flex-grow-1">
                                                        <p class="text-muted fw-medium">Employees</p>
                                                        <?php
                                                            $stmt = $conn->prepare("SELECT COUNT(employee_id) as totalemployee FROM `employees` WHERE  status = '1' ");
                                                            $stmt->execute();
                                                            $stmt->setFetchMode(PDO::FETCH_ASSOC);
                                                            if($stmt->rowCount()>0){
                                                                foreach (($stmt->fetchAll()) as $key => $row) {
                                                                    $totalemployee = $row['totalemployee'];
                                                                    echo '<h4 class="mb-0">'.$totalemployee.'</h4>';
                                                                }
                                                            } else{
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
                                                        <p class="text-muted fw-medium">Business Mentor</p>
                                                        <?php
                                                            $stmt = $conn->prepare("SELECT count(business_mentor_id) as totalbusiness_mentor FROM business_mentor where user_type='26' and status='1' ");
                                                            $stmt->execute();
                                                            $stmt->setFetchMode(PDO::FETCH_ASSOC);
                                                            if($stmt->rowCount()>0){
                                                                foreach (($stmt->fetchAll()) as $key => $row) {
                                                                    $totalbusiness_mentor=$row['totalbusiness_mentor'];
                                                                    echo '<h4 class="mb-0">'.$totalbusiness_mentor.'</h4>';
                                                                }
                                                            } else{
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

                                    <div class="col-md-4 col-sm-6 col-12" style="display: none;">
                                        <div class="card card-equal mini-stats-wid rounded-4">
                                            <div class="card-body">
                                                <div class="d-flex">
                                                    <div class="flex-grow-1">
                                                        <p class="text-muted fw-medium">Business Trainee</p>
                                                        <?php
                                                            $stmt = $conn->prepare("SELECT count(business_trainee_id) as totalbusiness_trainee FROM business_trainee where user_type='15' and status='1' ");
                                                            $stmt->execute();
                                                            $stmt->setFetchMode(PDO::FETCH_ASSOC);
                                                            if($stmt->rowCount()>0){
                                                                foreach (($stmt->fetchAll()) as $key => $row) {
                                                                    $totalbusiness_trainee=$row['totalbusiness_trainee'];
                                                                    echo '<h4 class="mb-0">'.$totalbusiness_trainee.'</h4>';
                                                                }
                                                            } else{
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
                                                        <p class="text-muted fw-medium">Business Consultant</p>
                                                        <?php
                                                            $stmt = $conn->prepare("SELECT count(business_consultant_id) as totalbusiness_consultant FROM business_consultant where user_type='3' and status='1' ");
                                                            $stmt->execute();
                                                            $stmt->setFetchMode(PDO::FETCH_ASSOC);
                                                            if($stmt->rowCount()>0){
                                                                foreach (($stmt->fetchAll()) as $key => $row) {
                                                                    $totalbusiness_consultant=$row['totalbusiness_consultant'];
                                                                    echo '<h4 class="mb-0">'.$totalbusiness_consultant.'</h4>';
                                                                }
                                                            } else{
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
                                                        <p class="text-muted fw-medium">Techno Enterprise</p>
                                                        <?php
                                                            $stmt = $conn->prepare("SELECT count(corporate_agency_id) as totalcorporate_agency FROM corporate_agency where user_type='16' and status='1' ");
                                                            $stmt->execute();
                                                            $stmt->setFetchMode(PDO::FETCH_ASSOC);
                                                            if($stmt->rowCount()>0){
                                                                foreach (($stmt->fetchAll()) as $key => $row) {
                                                                    $totalcorporate_agency=$row['totalcorporate_agency'];
                                                                    echo '<h4 class="mb-0">'.$totalcorporate_agency.'</h4>';
                                                                }
                                                            } else{
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
                                                            if($stmt->rowCount()>0){
                                                                foreach (($stmt->fetchAll()) as $key => $row) {
                                                                    $totalca_travelagency=$row['totalca_travelagency'];
                                                                    echo '<h4 class="mb-0">'.$totalca_travelagency.'</h4>';
                                                                }
                                                            } else{
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
                                                            if($stmt->rowCount()>0){
                                                                foreach (($stmt->fetchAll()) as $key => $row) {
                                                                    $totalca_customer=$row['totalca_customer'];
                                                                    echo '<h4 class="mb-0">'.$totalca_customer.'</h4>';
                                                                }
                                                            } else{
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
                                    
                                </div>
                                <!-- end row -->
                            </div>
                        </div>
                        <!-- end row -->
                        
                        <!-- <div class="row chart-count">
                            <div class="col-xl-12 card mb-4 rounded-4">
                                <div class="row mb-3">
                                    <div class="col-lg-7 col-md-12 col-sm-12"> -->
                                        <!-- <div class=""> -->
                                            <!-- <div class="card-body">
                
                                                <h4 class="card-title mb-4">Line Chart</h4>
                                                <hr class="mb-5">
                
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div style="float:right; padding: 10px 10px 10px 10px; font-weight:bold; margin-top: -50px; ">
                                                            <span >
                                                                Select Year 
                                                                <select id="years" onchange="getMonthlyUserData(this.value)" ></select>
                                                            </span>
                                                        </div>
                                                        
                                                        <div class="table-responsive table-desi">
                                                            <canvas id="myChart" style="width:100%;max-width:1000px"></canvas>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                            </div> -->
                                        <!-- </div> -->
                                    <!-- </div> -->
                                    
                                    <!-- monthly count of all -->
                                    <!-- <div class="col-lg-5 col-md-12 col-sm-12">
                                        <div class="row">
                                            <div class="col-12" style="padding: 30px; font-weight: 600;">
                                                <span>
                                                    Select Month & Year
                                                    <input type="month" id="month_year" value="" min="2020-01" max="">
                                                </span>
                                            </div>
                                        </div>

                                        <div class="row card" style="width: 98%; height: auto; margin-left: 5px; ">
                                            <div class="col-md-12 card-title count-col">
                                                <div class="col-md-6 col-sm-6 col-6"  style="padding-left: 20px;">
                                                    <p><i class="mdi  mdi-arrow-up-thick mdi-18px"></i> <span style="font-size: 12px;">Business Mentor</span></p>
                                                    <h3><span id="cbd_count"></span></h3> 
                                                </div>
                                                <div class="col-md-6 col-sm-6 col-6">
                                                    <button class="cpn_btn box-btn" type="button" onclick="showUserBox('cbd');">View</button>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row card" style="width: 98%; height: auto; margin-left: 5px; display: none;">
                                            <div class="col-md-12 card-title count-col">
                                                <div class="col-md-6 col-sm-6 col-6"  style="padding-left: 20px;">
                                                    <p><i class="mdi  mdi-arrow-up-thick mdi-18px"></i> <span style="font-size: 12px;">Base Agency</span></p>
                                                    <h3><span id="customer_count"></span></h3> 
                                                </div>
                                                <div class="col-md-6 col-sm-6 col-6">
                                                    <button class="cpn_btn box-btn" type="button" onclick="showUserBox('customer');">View</button>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row card" style="width: 98%; height: auto; margin-left: 5px; display: none;">
                                            <div class="col-md-12 card-title count-col">
                                                <div class="col-md-6 col-sm-6 col-6"  style="padding-left: 20px;">
                                                    <p><i class="mdi  mdi-arrow-up-thick mdi-18px"></i> <span style="font-size: 12px;"> Business Partner</span></p>
                                                    <h3><span id="partner_count"></span></h3> 
                                                </div>
                                                <div class="col-md-6 col-sm-6 col-6 ">
                                                    <button class="cpn_btn box-btn" type="button" onclick="showUserBox('partner');">View</button>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row card" style="width: 98%; height: auto; margin-left: 5px; display: none;">
                                            <div class="col-md-12 card-title count-col">
                                                <div class="col-md-6 col-sm-6 col-6"  style="padding-left: 20px;">
                                                    <p><i class="mdi  mdi-arrow-up-thick mdi-18px"></i> <span style="font-size: 12px;">Corporate Partner</span></p>
                                                    <h3><span id="corporate_partner_count"></span></h3> 
                                                </div>
                                                <div class="col-md-6 col-sm-6 col-6 ">
                                                    <button class="cpn_btn box-btn" type="button" onclick="showUserBox('corporate_partner');">View</button>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row card" style="width: 98%; height: auto; margin-left: 5px ; display: none;">
                                            <div class="col-md-12 card-title count-col">
                                                <div class="col-md-6 col-sm-6 col-6"  style="padding-left: 20px;">
                                                    <p><i class="mdi  mdi-arrow-up-thick mdi-18px"></i> <span style="font-size: 12px;">Business Trainee</span></p>
                                                    <h3><span id="business_trainee_count"></span></h3> 
                                                </div>
                                                <div class="col-md-6 col-sm-6 col-6 ">
                                                    <button class="cpn_btn box-btn" type="button" onclick="showUserBox('business_trainee');">View</button>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row card" style="width: 98%; height: auto; margin-left: 5px">
                                            <div class="col-md-12 card-title count-col">
                                                <div class="col-md-6 col-sm-6 col-6"  style="padding-left: 20px;">
                                                    <p><i class="mdi  mdi-arrow-up-thick mdi-18px"></i> <span style="font-size: 12px;">Business Consultant</span></p>
                                                    <h3><span id="consultant_count"></span></h3> 
                                                </div>
                                                <div class="col-md-6 col-sm-6 col-6 ">
                                                    <button class="cpn_btn box-btn" type="button" onclick="showUserBox('consultant');">View</button>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row card" style="width: 98%; height: auto; margin-left: 5px">
                                            <div class="col-md-12 card-title count-col">
                                                <div class="col-md-6 col-sm-6 col-6"  style="padding-left: 20px;">
                                                    <p><i class="mdi  mdi-arrow-up-thick mdi-18px"></i> <span style="font-size: 12px;">Techno Enterprise</span></p>
                                                    <h3><span id="corporate_agency_count"></span></h3> 
                                                </div>
                                                <div class="col-md-6 col-sm-6 col-6 ">
                                                    <button class="cpn_btn box-btn" type="button" onclick="showUserBox('corporate_agency');">View</button>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row card" style="width: 98%; height: auto; margin-left: 5px">
                                            <div class="col-md-12 card-title count-col">
                                                <div class="col-md-6 col-sm-6 col-6"  style="padding-left: 20px;">
                                                    <p><i class="mdi  mdi-arrow-up-thick mdi-18px"></i> <span style="font-size: 12px;">Travel Consultant</span></p>
                                                    <h3><span id="CA_travel_agent_count"></span></h3> 
                                                </div>
                                                <div class="col-md-6 col-sm-6 col-6 ">
                                                    <button class="cpn_btn box-btn" type="button" onclick="showUserBox('ca_travelagency');">View</button>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row card" style="width: 98%; height: auto; margin-left: 5px">
                                            <div class="col-md-12 card-title count-col">
                                                <div class="col-md-6 col-sm-6 col-6"  style="padding-left: 20px;">
                                                    <p><i class="mdi  mdi-arrow-up-thick mdi-18px"></i> <span style="font-size: 12px;">Customer</span></p>
                                                    <h3><span id="CA_customer_count"></span></h3> 
                                                </div>
                                                <div class="col-md-6 col-sm-6 col-6 ">
                                                    <button class="cpn_btn box-btn" type="button" onclick="showUserBox('ca_customer');">View</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div> -->

                                    <!-- monthly user details table  -->
                                    <!-- <div class="row" style="padding-top: 25px; display: none;" id="user-box">
                                        <div class="col-md-12"> 
                                            <div class="row">
                                                <hr>
                                                <div class="MonthlyDetailsHeading">
                                                    <span id="table-heading" style="padding: 0px 20px; font-weight: 600; font-size: initial;"></span>
                                                </div>

                                                <div class="MonthlyDetailsHeadingClose">
                                                    <span class="close-btn" style="float:right; padding: 0px 10px 10px 10px; font-weight: 600; font-size: initial; cursor:pointer; color:red"> X </span>
                                                </div>
                                                </div>
                                            <input type="hidden" name="user_table_count" id="user_table_count" value="" />
                                            <div class="table-responsive table-desi"> -->
                                                <!-- table roe limit -->
                                                <!-- <div class="col-md-4 col-sm-12">
                                                    <label>
                                                        Show
                                                        <select id="pagination_row_limit" class="selectdesign">
                                                            <option value="5">5</option>
                                                            <option value="10">10</option>
                                                            <option value="25">25</option>
                                                            <option value="50">50</option>
                                                            <option value="100">100</option>
                                                        </select>
                                                        entries
                                                    </label>
                                                </div>
                                                <table class="table table-hover" id="user_table">
                                                    <thead>
                                                        <tr>
                                                            <th class="ceterText" onclick="setRowOrder('id')">Id</th>
                                                            <th class="ceterText" onclick="setRowOrder('firstname')">Name</th>
                                                            <th class="ceterText" onclick="setRowOrder('id')">Refered By</th>
                                                            <th class="ceterText" onclick="setRowOrder('register_date')">Joining Date</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    </tbody>
                                                </table> -->
                                                <!-- pegination start -->
                                                <!-- <div class="center text-center" id="pagination_row"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div> -->
                            <!-- </div> end col -->
                        <!-- </div> --> 
                         <!-- end row -->

                        <!-- <div class="row">
                            <div class="col-xl-6">
                                <div class="card rounded-4">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="tab-inn">
                                                    <h6>Corporate Partner</h6>
                                                    <div class="table-responsive table-desi">
                                                        <canvas id="myCPChart" class="myCPChart" height="100px" weight="100px"></canvas>
                                                        <span class="cp_total_count" id="cp_total_count"></span>
                                                        <span class="cp_total_price" id="cp_total_price"></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>  -->
                            <!-- end col -->
                            <!-- <div class="col-xl-6">
                                <div class="card rounded-4" id="ca_chart_box">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="tab-inn">
                                                    <h6>Techno Enterprise</h6>
                                                    <div class="table-responsive table-desi">
                                                        <canvas id="myCAChart" class="myCAChart" height="100px" weight="100px"></canvas>
                                                        <span class="ca_total_count" id="ca_total_count"></span>
                                                        <span class="ca_total_price" id="ca_total_price"></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card" id="ca_no_chart_box" >
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="tab-inn">
                                                    <h3>No Corporat Agency Data Found</h3>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div> -->
                            <!-- </div> -->
                             <!-- end col -->
                        <!-- </div> -->
                         <!-- end row -->

                        <!-- Full Calender -->
                        <!-- <div class="row">
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-xl-8" id="eventCalender">
                                        <div class="card rounded-4">
                                            <div id="btn-new-event"></div>
                                            <div id='locale-selector' class="d-none"></div>
                                            <div class="card-body">
                                                <div id="external-events">
                                                    <button type="button" data-bs-toggle="modal" data-bs-target="#event-modal" class="btn btn-success btn-rounded waves-effect waves-light mb-2 me-2 addBusinessTraineemodal"><i class="mdi mdi-plus me-1"></i> Add Event</button>
                                                </div>
                                                <div id="calendar"></div>
                                            </div>
                                        </div>
                                    </div> -->
                                    <!-- end col -->

                                    <!-- Latest Transaction -->
                                    <!-- <div class="col-xl-4" id="latestTransaction">
                                        <div class="card rounded-4">
                                            <h2 class="fs-4 p-3">Latest Transaction</h2>
                                            <?php
                                                $sql1 ="SELECT corporate_agency_id as id, firstname, lastname, profile_pic, register_date as date, user_type, amount, payment_mode, status FROM corporate_agency UNION ALL 
                                                        SELECT ca_travelagency_id as id, firstname, lastname, profile_pic, register_date as date, user_type, amount, payment_mode, status FROM ca_travelagency UNION ALL 
                                                        SELECT ca_franchisee_id as id, firstname, lastname, profile_pic, register_date as date, user_type, amount, payment_mode, status FROM ca_franchisee 
                                                        WHERE status='1' order by date desc limit 5";
                                                $stmt1 = $conn -> prepare($sql1);
                                                $stmt1 -> execute();
                                                $stmt1 -> setFetchMode(PDO::FETCH_ASSOC);
                                                if( $stmt1 -> rowCount()>0){
                                                    foreach( ($stmt1 -> fetchAll()) as $key => $row ){
                                                        if($row['user_type'] == "16"){
                                                            $designation = "Techno Enterprise";
                                                        }else if($row['user_type'] == "19"){
                                                            $designation = "Franchisee";
                                                        }else if($row['user_type'] == "11"){
                                                            $designation = "Travel Consultant";
                                                        }
                                                        $rd= new DateTime($row['date']);
                                                        $rdate= $rd->format('d-m-Y');
                                                        $TAmt = $row['amount'];
                                                        $CATAmt = preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $TAmt);
                                                        echo'
                                                            <div class="card pt-3">
                                                                <div class="row">
                                                                    <div class="col-2 col-sm-1 col-md-1 col-lg-1 col-xl-2">
                                                                        <div class="profile-pic pb-1" style="position: relative; left: 15px;">
                                                                            <img src="../uploading/'.$row['profile_pic'].'" alt="profile pic" class="rounded-circle" width="50px" height="50px">
                                                                        </div>
                                                                    </div>
                                                                    
                                                                    <div class="col-10 col-sm-11 col-md-11 col-lg-11 col-xl-10 d-flex justify-content-between align-items-center">
                                                                        <div class="name fw-bold">'.$row['id'].' '.$row['firstname'].' '.$row['lastname'].' <span class="fw-normal">('.$designation.')</span></div>
                                                                    </div>
                                                                    <div class="date text-end fs-6" style="position: absolute; top: 5px; right: 0px;">'.$rdate.'</div>
                                                                </div>
                                                                
                                                                <div class="para ps-3 pb-2">
                                                                    <p>Transfered <span class="amount">'.$CATAmt.'/-</span> to Bizzmirth Holiday Pvt.Ltd via <span class="payment-mode">'.$row['payment_mode'].'</span>.</p>
                                                                </div>
                                                            </div>
                                                        ';
                                                    }
                                                }else{
                                                    echo'
                                                        <div><p>No Transaction Found</p></div>
                                                    ';
                                                }
                                            ?> -->

                                            <!-- <div class="card pt-3">
                                                <div class="row">
                                                    <div class="col-2 col-sm-1 col-md-1 col-lg-1 col-xl-2">
                                                        <div class="profile-pic pb-1" style="position: relative; left: 15px;">
                                                            <img src="assets/images/users/avatar-1.jpg" alt="profile pic" class="w-100 rounded-circle">
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="col-10 col-sm-11 col-md-11 col-lg-11 col-xl-10 d-flex justify-content-between align-items-center">
                                                        <div class="name fw-bold">Adhya Ashok <span class="fw-normal">(Business Consultant)</span></div>
                                                    </div>
                                                    <div class="date text-end fs-6" style="position: absolute; top: 5px; right: 0px;">30/08/2024</div>
                                                </div>
                                                
                                                <div class="para ps-3 pb-2">
                                                    <p>Transfered <span class="amount">50000/-</span> to Bizzmirth Holiday Pvt.Ltd via <span class="payment-mode">Cash</span>.</p>
                                                </div>
                                            </div>
                                            <div class="card pt-3">
                                                <div class="row">
                                                    <div class="col-2 col-sm-1 col-md-1 col-lg-1 col-xl-2">
                                                        <div class="profile-pic pb-1" style="position: relative; left: 15px;">
                                                            <img src="assets/images/users/avatar-1.jpg" alt="profile pic" class="w-100 rounded-circle">
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="col-10 col-sm-11 col-md-11 col-lg-11 col-xl-10 d-flex justify-content-between align-items-center">
                                                        <div class="name fw-bold">Adhya Ashok <span class="fw-normal">(Business Consultant)</span></div>
                                                    </div>
                                                    <div class="date text-end fs-6" style="position: absolute; top: 5px; right: 0px;">30/08/2024</div>
                                                </div>
                                                
                                                <div class="para ps-3 pb-2">
                                                    <p>Transfered <span class="amount">50000/-</span> to Bizzmirth Holiday Pvt.Ltd via <span class="payment-mode">Cash</span>.</p>
                                                </div>
                                            </div>
                                            <div class="card pt-3">
                                                <div class="row">
                                                    <div class="col-2 col-sm-1 col-md-1 col-lg-1 col-xl-2">
                                                        <div class="profile-pic pb-1" style="position: relative; left: 15px;">
                                                            <img src="assets/images/users/avatar-1.jpg" alt="profile pic" class="w-100 rounded-circle">
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="col-10 col-sm-11 col-md-11 col-lg-11 col-xl-10 d-flex justify-content-between align-items-center">
                                                        <div class="name fw-bold">Adhya Ashok <span class="fw-normal">(Business Consultant)</span></div>
                                                    </div>
                                                    <div class="date text-end fs-6" style="position: absolute; top: 5px; right: 0px;">30/08/2024</div>
                                                </div>
                                                
                                                <div class="para ps-3 pb-2">
                                                    <p>Transfered <span class="amount">50000/-</span> to Bizzmirth Holiday Pvt.Ltd via<span class="payment-mode">Cash</span>.</p>
                                                </div>
                                            </div> -->
                                            <!-- <div class="card">
                                                <div class="row">
                                                    <div class="col-xl-3">
                                                        <div class="profile-pic text-center py-2">
                                                            <img src="assets/images/users/avatar-1.jpg" alt="profile pic" class="w-75 rounded-circle">
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-9 d-flex justify-content-around align-items-center">
                                                        <div class="name">Anjali Mani</div>
                                                        <div class="date">20/08/2024</div>
                                                    </div>
                                                </div>
                                                <div class="designation fw-bold fs-5 px-3">Business Consultant</div>
                                                <div class="para ps-3 pb-2">
                                                    <p>Transfered <span class="amount">50000/-</span> to Bizzmirth Holiday Pvt.Ltd via <span class="payment-mode">Cash</span>.</p>
                                                </div>
                                            </div>
                                            <div class="card">
                                                <div class="row">
                                                    <div class="col-xl-3">
                                                        <div class="profile-pic text-center py-2">
                                                            <img src="assets/images/users/avatar-7.jpg" alt="profile pic" class="w-75 rounded-circle">
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-9 d-flex justify-content-around align-items-center">
                                                        <div class="name">Akshay Mani</div>
                                                        <div class="date">20/08/2024</div>
                                                    </div>
                                                </div>
                                                <div class="designation fw-bold fs-5 px-3">Business Consultant</div>
                                                <div class="para ps-3 pb-2">
                                                    <p>Transfered <span class="amount">50000/-</span> to Bizzmirth Holiday Pvt.Ltd via <span class="payment-mode">Cash</span>.</p>
                                                </div>
                                            </div> -->
                                            <!-- <div class="col-md-6 col-sm-6 col-6 pb-3 ps-2"> -->
                                                <!-- <button class="cpn_btn box-btn float-start" type="button" onclick="showUserBox1('latest_transaction');">View More</button> -->
                                                <!-- <a href="latest_transaction/latest_transaction.php"><button class="cpn_btn box-btn float-start" >View More</button></a> -->
                                            <!-- </div> -->
                                        <!-- </div> -->
                                        
                                    <!-- </div> -->
                                <!-- </div>  -->
                                <!-- <div class="row bg-white" style="padding-top: 25px; display: none;" id="user-box1">
                                    <div class="col-md-12"> 
                                        <div>
                                            <hr>
                                            <div class="MonthlyDetailsHeading ps-3">
                                                <span id="table-heading" class="fs-5 fw-bold ps-2">Latest Transaction</span>
                                            </div>
                                        </div>
                                        <input type="hidden" name="user_table_count" id="user_table_count" value="" />
                                        <div class="table-responsive table-desi">
                                            <div class="col-md-4 col-sm-12">
                                                <label>
                                                    Show
                                                    <select id="pagination_row_limit" class="selectdesign">
                                                        <option value="5">5</option>
                                                        <option value="10">10</option>
                                                        <option value="25">25</option>
                                                        <option value="50">50</option>
                                                        <option value="100">100</option>
                                                    </select>
                                                    entries
                                                </label>
                                            </div>
                                            <div class="col-xl-11 col-lg-11 col-md-11 d-flex justify-content-center">
                                                <div class="card" style="width: 90%;">
                                                    <div class="card pt-3">
                                                        <div class="row">
                                                            <div class="col-2 col-sm-1 col-md-1 col-lg-1 col-xl-1">
                                                                <div class="profile-pic pb-1" style="position: relative; left: 15px;">
                                                                    <img src="assets/images/users/avatar-1.jpg" alt="profile pic" class="w-100 rounded-circle">
                                                                </div>
                                                            </div>
                                                            
                                                            <div class="col-10 col-sm-11 col-md-11 col-lg-11 col-xl-11 d-flex justify-content-between align-items-center">
                                                                <div class="name fw-bold">Adhya Ashok <span class="fw-normal">(Business Consultant)</span></div>
                                                            </div>
                                                            <div class="date text-end fs-6" style="position: absolute; top: 5px; right: 0px;">30/08/2024</div>
                                                        </div>
                                                        
                                                        <div class="para ps-3 pb-2">
                                                            <p>Transfered <span class="amount">50000/-</span> to Bizzmirth Holiday Pvt.Ltd via <span class="payment-mode">Cash</span>.</p>
                                                        </div>
                                                    </div>
                                                    <div class="card pt-3">
                                                        <div class="row">
                                                            <div class="col-2 col-sm-1 col-md-1 col-lg-1 col-xl-1">
                                                                <div class="profile-pic pb-1" style="position: relative; left: 15px;">
                                                                    <img src="assets/images/users/avatar-1.jpg" alt="profile pic" class="w-100 rounded-circle">
                                                                </div>
                                                            </div>
                                                            
                                                            <div class="col-10 col-sm-11 col-md-11 col-lg-11 col-xl-11 d-flex justify-content-between align-items-center">
                                                                <div class="name fw-bold">Adhya Ashok <span class="fw-normal">(Business Consultant)</span></div>
                                                            </div>
                                                            <div class="date text-end fs-6" style="position: absolute; top: 5px; right: 0px;">30/08/2024</div>
                                                        </div>
                                                        
                                                        <div class="para ps-3 pb-2">
                                                            <p>Transfered <span class="amount">50000/-</span> to Bizzmirth Holiday Pvt.Ltd via <span class="payment-mode">Cash</span>.</p>
                                                        </div>
                                                    </div>
                                                    <div class="card pt-3">
                                                        <div class="row">
                                                            <div class="col-2 col-sm-1 col-md-1 col-lg-1 col-xl-1">
                                                                <div class="profile-pic pb-1" style="position: relative; left: 15px;">
                                                                    <img src="assets/images/users/avatar-1.jpg" alt="profile pic" class="w-100 rounded-circle">
                                                                </div>
                                                            </div>
                                                            
                                                            <div class="col-10 col-sm-11 col-md-11 col-lg-11 col-xl-11 d-flex justify-content-between align-items-center">
                                                                <div class="name fw-bold">Adhya Ashok <span class="fw-normal">(Business Consultant)</span></div>
                                                            </div>
                                                            <div class="date text-end fs-6" style="position: absolute; top: 5px; right: 0px;">30/08/2024</div>
                                                        </div>
                                                        
                                                        <div class="para ps-3 pb-2">
                                                            <p>Transfered <span class="amount">50000/-</span> to Bizzmirth Holiday Pvt.Ltd via <span class="payment-mode">Cash</span>.</p>
                                                        </div>
                                                    </div>
                                                    <div class="card pt-3">
                                                        <div class="row">
                                                            <div class="col-2 col-sm-1 col-md-1 col-lg-1 col-xl-1">
                                                                <div class="profile-pic pb-1" style="position: relative; left: 15px;">
                                                                    <img src="assets/images/users/avatar-1.jpg" alt="profile pic" class="w-100 rounded-circle">
                                                                </div>
                                                            </div>
                                                            
                                                            <div class="col-10 col-sm-11 col-md-11 col-lg-11 col-xl-11 d-flex justify-content-between align-items-center">
                                                                <div class="name fw-bold">Adhya Ashok <span class="fw-normal">(Business Consultant)</span></div>
                                                            </div>
                                                            <div class="date text-end fs-6" style="position: absolute; top: 5px; right: 0px;">30/08/2024</div>
                                                        </div>
                                                        
                                                        <div class="para ps-3 pb-2">
                                                            <p>Transfered <span class="amount">50000/-</span> to Bizzmirth Holiday Pvt.Ltd via<span class="payment-mode">Cash</span>.</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="center text-center" id="pagination_row"></div>
                                        </div>
                                    </div>
                                </div>
                                <div style='clear:both'></div> -->

                                <!-- Add New Event MODAL -->
                                <!-- <div class="modal fade" id="event-modal" tabindex="-1">
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
                                        </div> -->
                                        <!-- end modal-content-->
                                    <!-- </div>  -->
                                    <!-- end modal dialog-->
                                <!-- </div>  -->
                                <!-- end modal-->
                            <!-- </div> -->
                        <!-- </div>  -->
                        <!-- End Full Calender -->

                        <!-- Top Performer start -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box">
                                    <h4 class="mb-sm-0 font-size-18">Top Performer</h4>
                                </div>
                            </div>
                        </div>
                        
                        <div class="card rounded-4">
                            <div class="row p-4 d-flex justify-content-around">
                                <div class="col-md-3 col-sm-4 col-12 d-grid align-items-center">
                                    <button onclick="showDiv(1, this)" type="button" class="rounded-4 bg-primary-subtle btn fw-bolder fs-5 text-primary-emphasis py-4 w-100 text-center mb-2">
                                        Top 5 BCH
                                    </button>
                                    <button onclick="showDiv(2, this)" type="button" class="rounded-4 bg-success-subtle btn fw-bolder fs-5 text-success-emphasis py-4 w-100 text-center mb-2">
                                        Top 5 BDM
                                    </button>
                                    <button onclick="showDiv(3, this)" type="button" class="rounded-4 bg-warning-subtle btn fw-bolder fs-5 text-warning-emphasis py-4 w-100 text-center mb-2">
                                        Top 5 BM
                                    </button>
                                    <button onclick="showDiv(4, this)" type="button" class="rounded-4 bg-danger-subtle btn fw-bolder fs-5 text-danger-emphasis py-4 w-100 text-center mb-2">
                                        Top 5 TE
                                    </button>
                                    <button onclick="showDiv(5, this)" type="button" class="rounded-4 bg-info-subtle btn fw-bolder fs-5 text-info-emphasis py-4 w-100 text-center mb-2">
                                        Top 5 TC
                                    </button>
                                    <button onclick="showDiv(6, this)" type="button" class="rounded-4 bg-secondary-subtle btn fw-bolder fs-5 text-secondary-emphasis py-4 w-100 text-center mb-2">
                                        Top 5 Customer
                                    </button>
                                </div>
                                <div class="col-md-8 col-sm-7 col-12">
                                    <div class="card-body contentDiv rounded-4 border border-5 border-primary-subtle" id="div1" style="display: block;">
                                        <div class="card-title pb-2 d-flex justify-content-between ps-3 pe-3">
                                            <div class="heading">
                                                <h4>Top 5 Performer BCH</h4>
                                            </div>
                                            <div class="text-end d-flex align-items-center">
                                                <span class="fs-6">
                                                    <p>Select Month & Year</p>
                                                    <input type="month" id="month_year_BCH" value="" min="2020-01" max="">
                                                </span>
                                            </div>
                                        </div>
                                        <hr>        
                                        <div class="col-12 table-responsive text-center">
                                            <table class="table mb-0">
                                                <thead class="bg-primary-subtle">
                                                    <tr class="bg-primary-subtle">
                                                        <th>Ranks</th>
                                                        <th>Profile Pic</th>
                                                        <th>ID - Name</th>
                                                        <th>BDM Count</th>
                                                        <th>Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="bch_top_performer">
                                                    <?php
                                                        $srNo = 1;
                                                        // Prepare the SQL query
                                                        $sql1 = $conn->prepare("
                                                                SELECT e1.employee_id AS BCH_user_id,
                                                                    e1.name AS BCH_user_name,
                                                                    e1.profile_pic,
                                                                    e1.status,
                                                                    COUNT(e2.employee_id) AS BDM_count
                                                                FROM employees e1
                                                                LEFT JOIN employees e2 ON e1.employee_id = e2.reporting_manager
                                                                WHERE e1.user_type = 24 
                                                                AND e2.user_type = 25 
                                                                AND MONTH(e2.register_date) = '".$Month."' 
                                                                AND YEAR(e2.register_date) = '".$Year."'
                                                                AND e1.status = 1
                                                                AND e2.status = 1
                                                                GROUP BY e1.employee_id, e1.name, e1.profile_pic, e1.status
                                                                ORDER BY BDM_count DESC
                                                                LIMIT 5
                                                            ");

                                                        // Execute the query
                                                        $sql1->execute();

                                                        // Set the fetch mode to associative array
                                                        $sql1->setFetchMode(PDO::FETCH_ASSOC);

                                                        if( $sql1 -> rowCount()>0){
                                                            // Loop through the results and display the BCH user details
                                                            foreach ($sql1->fetchAll() as $bch_id) {
                                                                echo '<tr>
                                                                        <td>
                                                                            <div class="profile-pic pb-1">
                                                                                <img src="assets/images/topPerformer/'.$srNo.'.jpg" alt="profile pic" width="50px" height="50px" class="rounded-circle">
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <div class="profile-pic pb-1">
                                                                                <img src="../uploading/' . htmlspecialchars($bch_id['profile_pic']) . '" alt="profile pic" width="50px" height="50px" class="rounded-circle">
                                                                            </div>
                                                                        </td>
                                                                        <td class="align-content-center">
                                                                            <p class="fw-bold text-dark">'. htmlspecialchars($bch_id['BCH_user_name']) .'</p>
                                                                            <p class="text-dark">' . htmlspecialchars($bch_id['BCH_user_id']). '</p> 
                                                                        </td>
                                                                        <td class="align-content-center">' . htmlspecialchars($bch_id['BDM_count']) . '</td>';

                                                                // Display status based on the 'status' field value
                                                                if ($bch_id['status'] == '1') {
                                                                    echo '<td class="align-content-center"><span class="badge badge-pill badge-soft-success font-size-12">Active</span></td>';
                                                                } else {
                                                                    echo '<td class="align-content-center"><span class="badge badge-pill badge-soft-danger font-size-12">Removed</span></td>';
                                                                }
                                                                echo '</tr>';
                                                                $srNo++;
                                                            }
                                                        }else{
                                                            echo '<tr>
                                                                    <td colspan="5" class="align-content-center">No data found</td>
                                                                </tr>';
                                                        }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>

                                    </div>      
                                    <div class="card-body contentDiv rounded-4 border border-5 border-success-subtle" id="div2">
                                        <div class="card-title pb-2 d-flex justify-content-between ps-3 pe-3">
                                            <div class="heading">
                                                <h4>Top 5 Performer BDM</h4>
                                            </div>
                                            <div class="text-end d-flex align-items-center">
                                                <span class="fs-6">
                                                    <p>Select Month & Year</p>
                                                    <input type="month" id="month_year_BDM" value="" min="2020-01" max="">
                                                </span>
                                            </div>
                                        </div>
                                        <hr>        
                                        <div class="col-12 table-responsive text-center">
                                            <table class="table mb-0">
                                                <thead class="bg-primary-subtle">
                                                    <tr class="bg-primary-subtle">
                                                        <th>Ranks</th>
                                                        <th>Profile Pic</th>
                                                        <th>ID - Name</th>
                                                        <th>BM Count</th>
                                                        <th>Referral</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="bdm_top_performer">
                                                    <?php
                                                        $srNo = 1;
                                                        // Prepare the SQL query to get the BDM user who brought the highest number of BM
                                                        $sql1 = $conn->prepare("
                                                            SELECT e1.employee_id AS BDM_user_id,
                                                                e1.name AS BDM_user_name,
                                                                e1.reporting_manager,
                                                                e1.profile_pic,
                                                                e1.status,
                                                                COUNT(e2.business_mentor_id) AS BM_count
                                                            FROM employees e1
                                                            LEFT JOIN business_mentor e2 ON e1.employee_id = e2.reference_no
                                                            WHERE e1.user_type = 25 
                                                            AND e2.user_type = 26 
                                                            AND MONTH(e2.register_date) = '".$Month."' 
                                                            AND YEAR(e2.register_date) = '".$Year."' 
                                                            GROUP BY e1.employee_id, e1.name, e1.profile_pic, e1.reporting_manager, e1.status
                                                            ORDER BY BM_count DESC
                                                            LIMIT 5 
                                                        ");

                                                        // Execute the query
                                                        $sql1->execute();

                                                        // Set the fetch mode to associative array
                                                        $sql1->setFetchMode(PDO::FETCH_ASSOC);

                                                        if ($sql1->rowCount() > 0) {
                                                            // Loop through the results and display the BDM user details
                                                            foreach ($sql1->fetchAll() as $bdm_id) {

                                                                $sql2 = $conn->prepare("SELECT * FROM employees WHERE employee_id = '".$bdm_id['reporting_manager']."'");
                                                                $sql2->execute();
                                                                $sql2->setFetchMode(PDO::FETCH_ASSOC);
                                                                $reporting_manager = $sql2->fetch();
                                                                $reporting_manager_name = $reporting_manager['name'];

                                                                echo '<tr>
                                                                        <td>
                                                                            <div class="profile-pic pb-1">
                                                                                <img src="assets/images/topPerformer/'.$srNo.'.jpg" alt="profile pic" width="50px" height="50px" class="rounded-circle">
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <div class="profile-pic pb-1">
                                                                                <img src="../uploading/' . htmlspecialchars($bdm_id['profile_pic']) . '" alt="profile pic" width="50px" height="50px" class="rounded-circle">
                                                                            </div>
                                                                        </td>
                                                                        <td class="align-content-center">
                                                                            <p class="fw-bold text-dark"> ' . htmlspecialchars($bdm_id['BDM_user_name']) . ' </p>
                                                                            <p class="text-dark">' . htmlspecialchars($bdm_id['BDM_user_id']) . '</p> 
                                                                        </td>
                                                                        <td class="align-content-center">' . htmlspecialchars($bdm_id['BM_count']) . '</td>
                                                                        <td class="align-content-center">
                                                                            <p class="mb-1 fw-bold text-dark">' . htmlspecialchars($reporting_manager_name) . '</p>
                                                                            <p class="mb-1 text-dark">' . htmlspecialchars($bdm_id['reporting_manager']) . '</p>
                                                                        </td>
                                                                </tr>';
                                                                $srNo++;
                                                            }
                                                        } else {
                                                            echo '<tr>
                                                                    <td colspan="5" class="align-content-center">No data found</td>
                                                                </tr>';
                                                        }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>

                                    </div>      
                                    <div class="card-body contentDiv rounded-4 border border-5 border-warning-subtle" id="div3">
                                        <div class="card-title pb-2 d-flex justify-content-between ps-3 pe-3">
                                            <div class="heading">
                                                <h4>Top 5 Performer BM</h4>
                                            </div>
                                            <div class="text-end d-flex align-items-center">
                                                <span class="fs-6">
                                                    <p>Select Month & Year</p>
                                                    <input type="month" id="month_year_BM" value="" min="2020-01" max="">
                                                </span>
                                            </div>
                                        </div>
                                        <hr>        
                                        <div class="col-12 table-responsive text-center">
                                            <table class="table mb-0">
                                                <thead class="bg-primary-subtle">
                                                    <tr class="bg-primary-subtle">
                                                        <th>Ranks</th>
                                                        <th>Profile Pic</th>
                                                        <th>Name</th>
                                                        <th>TE Count</th>
                                                        <th>Referral</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="bm_top_performer">
                                                    <?php
                                                        $srNo = 1;
                                                        // Prepare the SQL query to get the BDM user who brought the highest number of BM
                                                        $sql1 = $conn->prepare("
                                                            SELECT e1.business_mentor_id AS BM_user_id,
                                                                e1.firstname AS BM_user_fname,
                                                                e1.lastname AS BM_user_lname,
                                                                e1.reference_no,
                                                                e1.registrant,
                                                                e1.profile_pic,
                                                                e1.status,
                                                                COUNT(e2.corporate_agency_id) AS TE_count
                                                            FROM business_mentor e1
                                                            LEFT JOIN corporate_agency e2 ON e1.business_mentor_id = e2.reference_no
                                                            WHERE e1.user_type = 26 -- BDM users
                                                            AND e2.user_type = 16 -- BM users
                                                            AND MONTH(e2.register_date) = '".$Month."'
                                                            AND YEAR(e2.register_date) = '".$Year."' 
                                                            GROUP BY e1.business_mentor_id, e1.firstname, e1.lastname, e1.reference_no, e1.registrant, e1.profile_pic, e1.status
                                                            ORDER BY TE_count DESC
                                                            LIMIT 5 -- Limit to top 5 BDM users who brought the most BM;;
                                                        ");

                                                        // Execute the query
                                                        $sql1->execute();

                                                        // Set the fetch mode to associative array
                                                        $sql1->setFetchMode(PDO::FETCH_ASSOC);

                                                        if ($sql1->rowCount() > 0) {
                                                            // Loop through the results and display the BDM user details
                                                            foreach ($sql1->fetchAll() as $bm_id) {
                                                                echo '<tr>
                                                                        <td>
                                                                            <div class="profile-pic pb-1">
                                                                                <img src="assets/images/topPerformer/'.$srNo.'.jpg" alt="profile pic" width="50px" height="50px" class="rounded-circle">
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <div class="profile-pic pb-1">
                                                                                <img src="../uploading/' . htmlspecialchars($bm_id['profile_pic']) . '" alt="profile pic" width="50px" height="50px" class="rounded-circle">
                                                                            </div>
                                                                        </td>
                                                                        <td class="align-content-center">
                                                                            <p class="fw-bold text-dark"> ' . htmlspecialchars($bm_id['BM_user_fname'].' '.$bm_id['BM_user_lname']) . ' </p>
                                                                            <p class="text-dark">' . htmlspecialchars($bm_id['BM_user_id']) . '</p> 
                                                                        </td>
                                                                        <td class="align-content-center">' . htmlspecialchars($bm_id['TE_count']) . '</td>
                                                                        <td class="align-content-center">
                                                                            <p class="mb-0 fw-bold text-dark">' . htmlspecialchars($bm_id['registrant']) . '</p>
                                                                            <p class="mb-1 text-dark">' . htmlspecialchars($bm_id['reference_no']) . '</p>
                                                                        </td>   
                                                                    </tr>';
                                                                $srNo++;
                                                            }
                                                        } else {
                                                            echo '<tr>
                                                                    <td colspan="5" class="align-content-center">No data found</td>
                                                                </tr>';
                                                        }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>

                                    </div>      
                                    <div class="card-body contentDiv rounded-4 border border-5 border-danger-subtle" id="div4">
                                        <div class="card-title pb-2 d-flex justify-content-between ps-3 pe-3">
                                            <div class="heading">
                                                <h4>Top 5 Performer TE</h4>
                                            </div>
                                            <div class="text-end d-flex align-items-center">
                                                <span class="fs-6">
                                                    <p>Select Month & Year</p>
                                                    <input type="month" id="month_year_TE" value="" min="2020-01" max="">
                                                </span>
                                            </div>
                                        </div>
                                        <hr>        
                                        <div class="col-12 table-responsive text-center">
                                            <table class="table mb-0">
                                                <thead class="bg-primary-subtle">
                                                    <tr class="bg-primary-subtle">
                                                        <th>Ranks</th>
                                                        <th>Profile Pic</th>
                                                        <th>Name</th>
                                                        <th>TA Count</th>
                                                        <th>Referral</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="te_top_performer">
                                                    <?php
                                                        $srNo = 1;
                                                        // Prepare the SQL query to get the BDM user who brought the highest number of BM
                                                        $sql1 = $conn->prepare("
                                                            SELECT e1.corporate_agency_id AS TE_user_id,
                                                                e1.firstname AS TE_user_fname,
                                                                e1.lastname AS TE_user_lname,
                                                                e1.reference_no,
                                                                e1.registrant,
                                                                e1.profile_pic,
                                                                e1.status,
                                                                COUNT(e2.ca_travelagency_id) AS TA_count
                                                            FROM corporate_agency e1
                                                            LEFT JOIN ca_travelagency e2 ON e1.corporate_agency_id = e2.reference_no
                                                            WHERE e1.user_type = 16 
                                                            AND e2.user_type = 11 
                                                            AND MONTH(e2.register_date) = '".$Month."'
                                                            AND YEAR(e2.register_date) = '".$Year."' 
                                                            GROUP BY e1.corporate_agency_id, e1.firstname, e1.lastname, e1.reference_no, e1.registrant, e1.profile_pic, e1.status
                                                            ORDER BY TA_count DESC
                                                            LIMIT 5 
                                                        ");

                                                        // Execute the query
                                                        $sql1->execute();

                                                        // Set the fetch mode to associative array
                                                        $sql1->setFetchMode(PDO::FETCH_ASSOC);

                                                        if ($sql1->rowCount() > 0) {
                                                            // Loop through the results and display the BDM user details
                                                            foreach ($sql1->fetchAll() as $te_id) {
                                                                echo '<tr>
                                                                        <td>
                                                                            <div class="profile-pic pb-1">
                                                                                <img src="assets/images/topPerformer/'.$srNo.'.jpg" alt="profile pic" width="50px" height="50px" class="rounded-circle">
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <div class="profile-pic pb-1">
                                                                                <img src="../uploading/' . htmlspecialchars($te_id['profile_pic']) . '" alt="profile pic" width="50px" height="50px" class="rounded-circle">
                                                                            </div>
                                                                        </td>
                                                                        <td class="align-content-center">
                                                                            <p class="fw-bold text-dark"> ' . htmlspecialchars($te_id['TE_user_fname'].' '.$te_id['TE_user_lname']) . ' </p>
                                                                            <p class="text-dark">' . htmlspecialchars($te_id['TE_user_id']) . '</p> 
                                                                        </td>
                                                                        <td class="align-content-center">' . htmlspecialchars($te_id['TA_count']) . '</td>
                                                                        <td class="align-content-center">
                                                                            <p class="mb-0 fw-bold text-dark">' . htmlspecialchars($te_id['registrant']) . '</p>
                                                                            <p class="mb-1 text-dark">' . htmlspecialchars($te_id['reference_no']) . '</p>
                                                                        </td>
                                                                    </tr>';
                                                                $srNo++;
                                                            }
                                                        } else {
                                                            echo '<tr>
                                                                    <td colspan="5" class="align-content-center">No data found</td>
                                                                </tr>';
                                                        }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>

                                    </div>      
                                    <div class="card-body contentDiv rounded-4 border border-5 border-info-subtle" id="div5">
                                        <div class="card-title pb-2 d-flex justify-content-between ps-3 pe-3">
                                            <div class="heading">
                                                <h4>Top 5 Performer TC</h4>
                                            </div>
                                            <div class="text-end d-flex align-items-center">
                                                <span class="fs-6">
                                                    <p>Select Month & Year</p>
                                                    <input type="month" id="month_year_TA" value="" min="2020-01" max="">
                                                </span>
                                            </div>
                                        </div>
                                        <hr>        
                                        <div class="col-12 table-responsive text-center">
                                            <table class="table mb-0">
                                                <thead class="bg-primary-subtle">
                                                    <tr class="bg-primary-subtle">
                                                        <th>Ranks</th>
                                                        <th>Profile Pic</th>
                                                        <th>Name</th>
                                                        <th>CU Count</th>
                                                        <th>Referral</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="ta_top_performer">
                                                    <?php
                                                        $srNo = 1;
                                                        // Prepare the SQL query to get the BDM user who brought the highest number of BM
                                                        $sql1 = $conn->prepare("
                                                            SELECT e1.ca_travelagency_id AS TA_user_id,
                                                                e1.firstname AS TA_user_fname,
                                                                e1.lastname AS TA_user_lname,
                                                                e1.profile_pic,
                                                                e1.reference_no,
                                                                e1.registrant,
                                                                e1.status,
                                                                COUNT(e2.ca_customer_id) AS CU_count
                                                            FROM ca_travelagency e1
                                                            LEFT JOIN ca_customer e2 ON e1.ca_travelagency_id = e2.ta_reference_no
                                                            WHERE e1.user_type = 11 
                                                            AND e2.user_type = 10 
                                                            AND MONTH(e2.register_date) = '".$Month."'
                                                            AND YEAR(e2.register_date) = '".$Year."' 
                                                            GROUP BY e1.ca_travelagency_id, e1.firstname, e1.lastname, e1.profile_pic,  e1.reference_no, e1.registrant, e1.status
                                                            ORDER BY CU_count DESC
                                                            LIMIT 5 
                                                        ");

                                                        // Execute the query
                                                        $sql1->execute();

                                                        // Set the fetch mode to associative array
                                                        $sql1->setFetchMode(PDO::FETCH_ASSOC);

                                                        if ($sql1->rowCount() > 0) {
                                                            // Loop through the results and display the BDM user details
                                                            foreach ($sql1->fetchAll() as $ta_id) {
                                                                echo '<tr>
                                                                        <td>
                                                                            <div class="profile-pic pb-1">
                                                                                <img src="assets/images/topPerformer/'.$srNo.'.jpg" alt="profile pic" width="50px" height="50px" class="rounded-circle">
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <div class="profile-pic pb-1">
                                                                                <img src="../uploading/' . htmlspecialchars($ta_id['profile_pic']) . '" alt="profile pic" width="50px" height="50px" class="rounded-circle">
                                                                            </div>
                                                                        </td>
                                                                        <td class="align-content-center">
                                                                            <p class="fw-bold text-dark">' . htmlspecialchars($ta_id['TA_user_fname'].' '.$ta_id['TA_user_lname']) . '</p>
                                                                            <p class="fw-bold text-dark">' . htmlspecialchars($ta_id['TA_user_id']) . '</p> 
                                                                        </td>
                                                                        <td class="align-content-center">' . htmlspecialchars($ta_id['CU_count']) . '</td>
                                                                        <td class="align-content-center">
                                                                            <p class="mb-0 fw-bold text-dark">' . htmlspecialchars($ta_id['registrant']) . '</p>
                                                                            <p class="mb-1 text-dark">' . htmlspecialchars($ta_id['reference_no']) . '</p>
                                                                        </td>
                                                                
                                                                </tr>';
                                                                $srNo++;
                                                            }
                                                        } else {
                                                            echo '<tr>
                                                                    <td colspan="5" class="align-content-center">No data found</td>
                                                                </tr>';
                                                        }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>

                                    </div>      
                                    <div class="card-body contentDiv rounded-4 border border-5 border-secondary-subtle" id="div6">
                                        <div class="card-title pb-2 d-flex justify-content-between ps-3 pe-3">
                                            <div class="heading">
                                                <h4>Top 5 Performer Customer</h4>
                                            </div>
                                            <div class="text-end d-flex align-items-center">
                                                <span class="fs-6">
                                                    <p>Select Month & Year</p>
                                                    <input type="month" id="month_year_CU" value="" min="2020-01" max="">
                                                </span>
                                            </div>
                                        </div>
                                        <hr>        
                                        <div class="col-12 table-responsive text-center">
                                            <table class="table mb-0">
                                                <thead class="bg-primary-subtle">
                                                    <tr class="bg-primary-subtle">
                                                        <th>Ranks</th>
                                                        <th>Profile Pic</th>
                                                        <th>Name</th>
                                                        <th>CU Count</th>
                                                        <th>Referral</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="cu_top_performer">
                                                    <?php
                                                        $srNo = 1;
                                                        // Prepare the SQL query to get the BDM user who brought the highest number of BM
                                                        $sql1 = $conn->prepare("
                                                            SELECT e1.ca_customer_id AS CU_user_id,
                                                                e1.firstname AS CU_user_fname,
                                                                e1.lastname AS CU_user_lname,
                                                                e1.ta_reference_no,
                                                                e1.ta_reference_name,
                                                                e1.profile_pic,
                                                                e1.status,
                                                                COUNT(e2.ca_customer_id) AS CUL_count
                                                            FROM ca_customer e1
                                                            LEFT JOIN ca_customer e2 ON e1.ca_customer_id = e2.reference_no
                                                            WHERE e1.user_type = 10 
                                                            AND e2.user_type = 10 
                                                            AND MONTH(e2.register_date) = '".$Month."'
                                                            AND YEAR(e2.register_date) = '".$Year."' 
                                                            GROUP BY e1.ca_customer_id, e1.firstname, e1.lastname, e1.ta_reference_no, e1.ta_reference_name, e1.profile_pic, e1.status
                                                            ORDER BY CUL_count DESC
                                                            LIMIT 5 
                                                        ");

                                                        // Execute the query
                                                        $sql1->execute();

                                                        // Set the fetch mode to associative array
                                                        $sql1->setFetchMode(PDO::FETCH_ASSOC);

                                                        if ($sql1->rowCount() > 0) {
                                                            // Loop through the results and display the BDM user details
                                                            foreach ($sql1->fetchAll() as $cu_id) {
                                                                echo '<tr>
                                                                        <td>
                                                                            <div class="profile-pic pb-1">
                                                                                <img src="assets/images/topPerformer/'.$srNo.'.jpg" alt="profile pic" width="50px" height="50px" class="rounded-circle">
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <div class="profile-pic pb-1">
                                                                                <img src="../uploading/' . htmlspecialchars($cu_id['profile_pic']) . '" alt="profile pic" width="50px" height="50px" class="rounded-circle">
                                                                            </div>
                                                                        </td>
                                                                        <td class="align-content-center">
                                                                            <p class="fw-bold text-dark"> ' . htmlspecialchars($cu_id['CU_user_fname'].' '.$cu_id['CU_user_lname']) . ' </p>
                                                                            <p class="text-dark">' . htmlspecialchars($cu_id['CU_user_id']) . '</p> 
                                                                        </td>
                                                                        <td class="align-content-center">' . htmlspecialchars($cu_id['CUL_count']) . '</td>
                                                                        <td class="align-content-center">
                                                                            <p class="mb-0 fw-bold text-dark">' . htmlspecialchars($cu_id['ta_reference_name']) . '</p>
                                                                            <p class="mb-1 text-dark">' . htmlspecialchars($cu_id['ta_reference_no']) . '</p>
                                                                        </td>

                                                                </tr>';
                                                                $srNo++;
                                                            }
                                                        } else {
                                                            echo '<tr>
                                                                    <td colspan="5" class="align-content-center">No data found</td>
                                                                </tr>';
                                                        }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>

                                    </div>      
                                </div>
                            </div>
                        </div>    
                        <!-- Top Performer end -->
                    
                        <div class="row">
                            
                            <div class="col-xl-6 col-md-6 col-sm-12 p-3">
                                <div class="card rounded-4">
                                    <div class="card-body">
                                        <div class="card-title pb-2 d-flex justify-content-between ps-3 pe-3">
                                            <div class="heading">
                                                <h4>Employees</h4>
                                            </div>
                                            <div class="dropdown">
                                                <a class="" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false"><i class="mdi mdi-dots-vertical-circle-outline mdi-24px" style="color: grey;"></i></a>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                    <a class="dropdown-item" href="employee/view_regional_manager.php">View</a>
                                                    <a class="dropdown-item" href="employee/add_regional_manager.php">Add New</a>
                                                </div>
                                            </div>
                                        </div>    
                                        <hr>   
                                        <div class="col-12 table-responsive text-center">
                                            <table class="table mb-0">
                                                <thead>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>Name</th>
                                                        <th>Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                        $sql1 = "SELECT * FROM employees where (status='1' or status='0' or status='3') and employee_id != '' order by employee_id desc limit 6";
                                                        // $sql1 = "SELECT regional_manager_id as id, firstname, lastname, status FROM regional_manager UNION ALL 
                                                        //          SELECT sales_manager_id as id, firstname, lastname, status FROM sales_manager UNION ALL 
                                                        //          SELECT branch_manager_id as id, firstname, lastname, status FROM branch_manager 
                                                        //          WHERE (status='1' or status='0' or status='3') and id != '' order by id desc limit 6";
                                                        $stmt1 = $conn -> prepare($sql1);
                                                        $stmt1 -> execute();
                                                        $stmt1 -> setFetchMode(PDO::FETCH_ASSOC);
                                                        if( $stmt1 -> rowCount()>0){
                                                            foreach( ($stmt1 -> fetchAll()) as $key => $row ){
                                                                echo'<tr>
                                                                    <td>'.$row['employee_id'].'</td>
                                                                    <td>'.$row['name'].'</td>';
                                                                    if($row['status'] == '1'){
                                                                        echo'<td><span class="badge badge-pill badge-soft-success font-size-12">Active</span></td>';
                                                                    }else{
                                                                        echo'<td><span class="badge badge-pill badge-soft-danger font-size-12">Removed</span></td>';
                                                                    }
                                                                echo'</tr>';
                                                            }
                                                        }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-6 col-md-6 col-sm-12 p-3">
                                <div class="card rounded-4">
                                    <div class="card-body">
                                        <div class="card-title pb-2 d-flex justify-content-between ps-3 pe-3">
                                            <div class="heading">
                                                <h4>Business Mentor</h4>
                                            </div>
                                            <div class="dropdown">
                                                <a class="" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false"><i class="mdi mdi-dots-vertical-circle-outline mdi-24px" style="color: grey;"></i></a>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                    <a class="dropdown-item" href="channel_business_director/view_cbd.php">View</a>
                                                    <a class="dropdown-item" href="channel_business_director/add_cbd.php">Add New</a>
                                                </div>
                                            </div>
                                        </div>    
                                        <hr>   
                                        <div class="col-12 table-responsive text-center">
                                            <table class="table mb-0">
                                                <thead>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>Name</th>
                                                        <th>Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                        // $sql1 = "SELECT * FROM customer where user_type='2' and (status='1' or status='0' or status='3') and cust_id != '' order by cust_id desc limit 5";
                                                        $sql1 = "SELECT channel_business_director_id as id, firstname, lastname, status FROM channel_business_director 
                                                                 WHERE (status='1' or status='0' or status='3') and id != '' order by id desc limit 6";
                                                        $stmt1 = $conn -> prepare($sql1);
                                                        $stmt1 -> execute();
                                                        $stmt1 -> setFetchMode(PDO::FETCH_ASSOC);
                                                        if( $stmt1 -> rowCount()>0){
                                                            foreach( ($stmt1 -> fetchAll()) as $key => $row ){
                                                                echo'<tr>
                                                                    <td>'.$row['id'].'</td>
                                                                    <td>'.$row['firstname'].' '.$row['lastname'].'</td>';
                                                                    if($row['status'] == '1'){
                                                                        echo'<td><span class="badge badge-pill badge-soft-success font-size-12">Active</span></td>';
                                                                    }else{
                                                                        echo'<td><span class="badge badge-pill badge-soft-danger font-size-12">Removed</span></td>';
                                                                    }
                                                                echo'</tr>';
                                                            }
                                                        }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-6 col-md-6 col-sm-12 p-3" style="display: none;">
                                <div class="card rounded-4">
                                    <div class="card-body">
                                        <div class="card-title pb-2 d-flex justify-content-between ps-3 pe-3">
                                            <div class="heading">
                                                <h4>Business Trainee</h4>
                                            </div>
                                            <div class="dropdown">
                                                <a class="" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false"><i class="mdi mdi-dots-vertical-circle-outline mdi-24px" style="color: grey;"></i></a>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                    <a class="dropdown-item" href="business_trainee/view_business_trainee.php">View</a>
                                                    <a class="dropdown-item" href="business_trainee/add_business_trainee.php">Add New</a>
                                                </div>
                                            </div>
                                        </div>    
                                        <hr>    
                                        <div class="col-12 table-responsive text-center">
                                            <table class="table mb-0">
                                                <thead>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>Name</th>
                                                        <th>Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                        $sql1 = "SELECT * FROM business_trainee where user_type='15' and (status='1' or status='0' or status='3') and business_trainee_id != '' order by business_trainee_id desc limit 6";
                                                        $stmt1 = $conn -> prepare($sql1);
                                                        $stmt1 -> execute();
                                                        $stmt1 -> setFetchMode(PDO::FETCH_ASSOC);
                                                        if( $stmt1 -> rowCount()>0){
                                                            foreach( ($stmt1 -> fetchAll()) as $key => $row ){
                                                                echo'<tr>
                                                                    <td>'.$row['business_trainee_id'].'</td>
                                                                    <td>'.$row['firstname'].' '.$row['lastname'].'</td>';
                                                                    if($row['status'] == '1'){
                                                                        echo'<td><span class="badge badge-pill badge-soft-success font-size-12">Active</span></td>';
                                                                    }else{
                                                                        echo'<td><span class="badge badge-pill badge-soft-danger font-size-12">Removed</span></td>';
                                                                    }
                                                                echo'</tr>';
                                                            }
                                                        }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-6 col-md-6 col-sm-12 p-3">
                                <div class="card rounded-4">
                                    <div class="card-body">
                                        <div class="card-title pb-2 d-flex justify-content-between ps-3 pe-3">
                                            <div class="heading">
                                                <h4>Business Consultant</h4>
                                            </div>
                                            <div class="dropdown">
                                                <a class="" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false"><i class="mdi mdi-dots-vertical-circle-outline mdi-24px" style="color: grey;"></i></a>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                    <a class="dropdown-item" href="business_consultant/View_business_consultant.php">View</a>
                                                    <a class="dropdown-item" href="business_consultant/add_business_consultant.php">Add New</a>
                                                </div>
                                            </div>
                                        </div>    
                                        <hr>       
                                        <div class="col-12 table-responsive text-center">
                                            <table class="table mb-0">
                                                <thead>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>Name</th>
                                                        <th>Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                        $sql1 = "SELECT * FROM business_consultant where user_type='3' and (status='1' or status='0' or status='3') and business_consultant_id != '' order by business_consultant_id desc limit 6";
                                                        $stmt1 = $conn -> prepare($sql1);
                                                        $stmt1 -> execute();
                                                        $stmt1 -> setFetchMode(PDO::FETCH_ASSOC);
                                                        if( $stmt1 -> rowCount()>0){
                                                            foreach( ($stmt1 -> fetchAll()) as $key => $row ){
                                                                echo'<tr>
                                                                    <td>'.$row['business_consultant_id'].'</td>
                                                                    <td>'.$row['firstname'].' '.$row['lastname'].'</td>';
                                                                    if($row['status'] == '1'){
                                                                        echo'<td><span class="badge badge-pill badge-soft-success font-size-12">Active</span></td>';
                                                                    }else{
                                                                        echo'<td><span class="badge badge-pill badge-soft-danger font-size-12">Removed</span></td>';
                                                                    }
                                                                echo'</tr>';
                                                            }
                                                        }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-6 col-md-6 col-sm-12 p-3">
                                <div class="card rounded-4">
                                    <div class="card-body">
                                        <div class="card-title pb-2 d-flex justify-content-between ps-3 pe-3">
                                            <div class="heading">
                                                <h4>Techno Enterprise</h4>
                                            </div>
                                            <div class="dropdown">
                                                <a class="" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false"><i class="mdi mdi-dots-vertical-circle-outline mdi-24px" style="color: grey;"></i></a>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                    <a class="dropdown-item" href="corporate_agency/view_corporate_agency.php">View</a>
                                                    <a class="dropdown-item" href="corporate_agency/add_corporate_agency.php">Add New</a>
                                                </div>
                                            </div>
                                        </div>    
                                        <hr>         
                                        <div class="col-12 table-responsive text-center">
                                            <table class="table mb-0">
                                                <thead>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>Name</th>
                                                        <th>Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                        $sql1 = "SELECT * FROM corporate_agency where user_type='16' and (status='1' or status='0' or status='3') and corporate_agency_id != '' order by corporate_agency_id desc limit 6";
                                                        $stmt1 = $conn -> prepare($sql1);
                                                        $stmt1 -> execute();
                                                        $stmt1 -> setFetchMode(PDO::FETCH_ASSOC);
                                                        if( $stmt1 -> rowCount()>0){
                                                            foreach( ($stmt1 -> fetchAll()) as $key => $row ){
                                                                echo'<tr>
                                                                    <td>'.$row['corporate_agency_id'].'</td>
                                                                    <td>'.$row['firstname'].' '.$row['lastname'].'</td>';
                                                                    if($row['status'] == '1'){
                                                                        echo'<td><span class="badge badge-pill badge-soft-success font-size-12">Active</span></td>';
                                                                    }else{
                                                                        echo'<td><span class="badge badge-pill badge-soft-danger font-size-12">Removed</span></td>';
                                                                    }
                                                                echo'</tr>';
                                                            }
                                                        }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-6 col-md-6 col-sm-12 p-3">
                                <div class="card rounded-4">
                                    <div class="card-body">
                                        <div class="card-title pb-2 d-flex justify-content-between ps-3 pe-3">
                                            <div class="heading">
                                                <h4>Travel Consultant</h4>
                                            </div>
                                            <div class="dropdown">
                                                <a class="" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false"><i class="mdi mdi-dots-vertical-circle-outline mdi-24px" style="color: grey;"></i></a>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                    <a class="dropdown-item" href="ca_travelAgency/view_ca_travelAgency.php">View</a>
                                                    <a class="dropdown-item" href="ca_travelAgency/add_ca_travelAgency.php">Add New</a>
                                                </div>
                                            </div>
                                        </div>    
                                        <hr>          
                                        <div class="col-12 table-responsive text-center">
                                            <table class="table mb-0">
                                                <thead>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>Name</th>
                                                        <th>Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                        $sql1 = "SELECT * FROM ca_travelagency where user_type='11' and (status='1' or status='0' or status='3') and ca_travelagency_id != '' order by ca_travelagency_id desc limit 6";
                                                        $stmt1 = $conn -> prepare($sql1);
                                                        $stmt1 -> execute();
                                                        $stmt1 -> setFetchMode(PDO::FETCH_ASSOC);
                                                        if( $stmt1 -> rowCount()>0){
                                                            foreach( ($stmt1 -> fetchAll()) as $key => $row ){
                                                                echo'<tr>
                                                                    <td>'.$row['ca_travelagency_id'].'</td>
                                                                    <td>'.$row['firstname'].' '.$row['lastname'].'</td>';
                                                                    if($row['status'] == '1'){
                                                                        echo'<td><span class="badge badge-pill badge-soft-success font-size-12">Active</span></td>';
                                                                    }else{
                                                                        echo'<td><span class="badge badge-pill badge-soft-danger font-size-12">Removed</span></td>';
                                                                    }
                                                                echo'</tr>';
                                                            }
                                                        }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-6 col-md-6 col-sm-12 p-3">
                                <div class="card rounded-4">
                                    <div class="card-body">
                                        <div class="card-title pb-2 d-flex justify-content-between ps-3 pe-3">
                                            <div class="heading">
                                                <h4>Customer</h4>
                                            </div>
                                            <div class="dropdown">
                                                <a class="" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false"><i class="mdi mdi-dots-vertical-circle-outline mdi-24px" style="color: grey;"></i></a>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                    <a class="dropdown-item" href="ca_customers/view_customers.php">View</a>
                                                    <a class="dropdown-item" href="ca_customers/add_customers.php">Add New</a>
                                                </div>
                                            </div>
                                        </div>
                                        <hr>        
                                        <div class="col-12 table-responsive text-center">
                                            <table class="table mb-0">
                                                <thead>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>Name</th>
                                                        <th>Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                        $sql1 = "SELECT * FROM ca_customer where user_type='10' and (status='1' or status='0') and ca_customer_id != '' order by ca_customer_id desc limit 6";
                                                        $stmt1 = $conn -> prepare($sql1);
                                                        $stmt1 -> execute();
                                                        $stmt1 -> setFetchMode(PDO::FETCH_ASSOC);
                                                        if( $stmt1 -> rowCount()>0){
                                                            foreach( ($stmt1 -> fetchAll()) as $key => $row ){
                                                                echo'<tr>
                                                                    <td>'.$row['ca_customer_id'].'</td>
                                                                    <td>'.$row['firstname'].' '.$row['lastname'].'</td>';
                                                                    if($row['status'] == '1'){
                                                                        echo'<td><span class="badge badge-pill badge-soft-success font-size-12">Active</span></td>';
                                                                    }else{
                                                                        echo'<td><span class="badge badge-pill badge-soft-danger font-size-12">Removed</span></td>';
                                                                    }
                                                                echo'</tr>';
                                                            }
                                                        }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>

                                    </div>
                                </div>
                            </div> 

                        </div>

                    </div>
                    <!-- container-fluid -->
                </div>
                <!-- End Page-content -->
                
                <footer class="footer">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-sm-6">
                                <?php echo $date; ?> © Uniqbizz.
                            </div>
                            <div class="col-sm-6">
                                <div class="text-sm-end d-none d-sm-block">
                                    Design & Develop by Mirthcon
                                </div>
                            </div>
                        </div>
                    </div>
                </footer>
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

        <!-- apexcharts -->
        <!-- <script src="assets/libs/apexcharts/apexcharts.min.js"></script> -->

        <!-- Chart JS -->
        <!-- <script src="assets/libs/chart.js/chart.umd.js"></script> -->
        <script src="assets/libs/chart.js/Chart-2.5.0.min.js"></script>
        <!-- <script src="assets/js/pages/chartjs.init.js"></script>  -->

        <!-- dashboard init -->
        <!-- <script src="assets/js/pages/dashboard.init.js"></script> -->
         <!-- plugin js -->
        <script src="assets/libs/moment/min/moment.min.js"></script>
        <script src="assets/libs/jquery-ui-dist/jquery-ui.min.js"></script>
        
        <!-- Calendar init -->
        <script src="assets/libs/fullcalendar/index.global.min.js"></script>
        <!-- <script src="assets/js/pages/calendars-full.init.js"></script> -->

        <!-- App js -->
        <script src="assets/js/app.js"></script>
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
        <script> 

            const currentDate = new Date();
            var getCurrentYear = currentDate.getFullYear();
            var getCurrentMonth = currentDate.getMonth() + 1 ;
            var userType, monthYear;
            // get month for input tag
            var monthControl = document.querySelector('#month_year');

            $(function(){
                // get min and max month for input tag
                const date= new Date()
                const month=("0" + (date.getMonth() + 1)).slice(-2)
                const year=date.getFullYear()
                monthControl.value = `${year}-${month}`;
                    // console.log(monthControl.value);

                // Set Default value for years
                for (let index = 2020; index <= getCurrentYear; index++) {
                    if ( index == getCurrentYear ) {
                        $("#years").append('<option selected="selected" value="'+index+'">'+index+'</option>');
                        $("#consultant_years").append('<option selected="selected" value="'+index+'">'+index+'</option>');
                        $("#partner_years").append('<option selected="selected" value="'+index+'">'+index+'</option>');
                    } else {
                        $("#years").append('<option value="'+index+'">'+index+'</option>');
                        $("#consultant_years").append('<option value="'+index+'">'+index+'</option>');
                        $("#partner_years").append('<option value="'+index+'">'+index+'</option>');
                    }
                }
                // get chart data
                getMonthlyUserData(getCurrentYear);
                // getBIPData(); //BIP pie chart
                getCPData(); //cp Amount Pie Chart
                getCAData(); //ca Amount Pie Chart
                // get monthly user count
                monthYear = monthControl.value;
                monthlyUserCount();
                // get birthday table
                // getBirthdayData('customer');

                // console.log('test 22');
            });

            async function getMonthlyUserData(get_year) {
                let option  = {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json;charset=utf-8' },
                    body: JSON.stringify({
                                year:get_year,
                                current_year:getCurrentYear,
                                current_month:getCurrentMonth,
                                user_id:0,
                                user_type:0
                            })
                }
                const response = await fetch('charts/monthly_customer_count.php', option);
                const data = await response.json();
                    console.log(data);
                length = data[0].length;
                labels = [];
                values_cust = [];
                values_ta = [];
                values_bp = [];
                values_cp = [];
                values_bt = [];
                values_ca = [];
                values_cata = [];
                values_cacu = [];
                values_cbd = [];
                values_emp = [];
                values_bm = [];

                for (i = 0; i < length; i++) {
                    values_cust.push(data[0][i]);
                    values_ta.push(data[1][i]);
                    values_bp.push(data[2][i]);
                    values_cp.push(data[3][i]);
                    values_bt.push(data[4][i]);
                    values_ca.push(data[5][i]);
                    values_cata.push(data[6][i]);
                    values_cacu.push(data[7][i]);
                    values_cbd.push(data[8][i]);
                    values_emp.push(data[9][i]);
                    values_bm.push(data[10][i]);
                }
                var xValues = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov',  'Dec'];
                new Chart(document.getElementById("myChart"), {
                    type: 'line',
                    data: {
                        labels: xValues,
                        datasets: [
                            // {
                            //     label: "Partners",
                            //     data: values_bp,
                            //     borderColor: "green",
                            //     fill: true
                            // },
                            // {
                            //     label: "Channel Business Director",
                            //     data: values_cbd,
                            //     borderColor: "yellow",
                            //     fill: true
                            // },
                            // {
                            //     label: "Base Agency",
                            //     data: values_cust,
                            //     borderColor: "red",
                            //     fill: true
                            // },
                            // {
                            //     label: "Corporate Partner",
                            //     data: values_cp,
                            //     borderColor: "purple",
                            //     fill: true
                            // },
                            // {
                            //     label: "Consultant",
                            //     data: values_ta,
                            //     borderColor: "blue",
                            //     fill: true
                            // },
                            {
                                label: "Employees",
                                data: values_emp,
                                borderColor: "yellow",
                                fill: true
                            },
                            {
                                label: "Mentor",
                                data: values_bm,
                                borderColor: "blue",
                                fill: true
                            },
                            {
                                label: "Techno Enterprise",
                                data: values_ca,
                                borderColor: "green",
                                fill: true
                            },
                            {
                                label: "Travel Consultant",
                                data: values_cata,
                                borderColor: "pink",
                                fill: true
                            },
                            {
                                label: "Customer",
                                data: values_cacu,
                                borderColor: "red",
                                fill: true
                            }
                        ]
                    },
                    options: {
                        legend: { display: true },
                        scales: {
                            yAxes: [{
                                    display: true,
                                    ticks: {
                                        beginAtZero: true
                                    }
                                }]
                        },
                        title: {
                            display: false,
                            text: 'Registered Users'
                        }
                    }
                });
            }
            //CP Chart
            async function getCPData() {
                const response = await fetch('charts/cp_payout.php');
                const data = await response.json();
                
                // console.log(data);

                var xValues = ["Micro", "Basic", "Advance", "Ultra"];
                var yValues = [ data[0], data[1], data[2], data[3] ];
                var total = data[4];
                var total_pay = data[9]
                var barColors = [
                    "#ad2321",
                    "#3EB07E",
                    "#22497E",
                    "#42CFEB"
                ];

                document.getElementById("cp_total_count").innerText = "Total CP = "+total + "\n";
                document.getElementById("cp_total_price").innerText = " Total Amount = ₹ " +total_pay;
                
                new Chart(document.getElementById("myCPChart"), {
                    type: "pie",
                    data: {
                        labels: xValues,
                        datasets: [{ 
                            backgroundColor: barColors,
                            data: yValues
                        }]
                    },
                    options: {
                        title: {
                            display: false,
                            text: "BIP Payout",
                        }
                    }
                });
            }

            async function getCAData() {
                const response = await fetch('charts/ca_payout.php');
                const data = await response.json();
                
                // console.log(data);

                var xValues = ["Paid CA", "Unpaid CA"];
                var yValues = [ data[0], data[1]];
                var total = data[2];
                var totalCA = data[3];
                var barColors = [
                    "#ad2321",
                    "#3EB07E",
                ];

                document.getElementById("ca_total_count").innerText = "Total CA = "+totalCA + "\n";
                document.getElementById("ca_total_price").innerText = " Total Amount = ₹ " +total+"/-";

                if(totalCA == 0){
                    document.getElementById("ca_no_chart_box").style.display = "block";
                    document.getElementById("ca_chart_box").style.display = "none";
                }else{
                    document.getElementById("ca_no_chart_box").style.display = "none";
                    document.getElementById("ca_chart_box").style.display = "block";
                }

                new Chart(document.getElementById("myCAChart"), {
                    type: "pie",
                    data: {
                        labels: xValues,
                        datasets: [{ 
                            backgroundColor: barColors,
                            data: yValues
                        }]
                    },
                    options: {
                        title: {
                            display: false,
                            text: "BIP Payout",
                        }
                    }
                });
            }

            //get monthly count for bc, bp, customer, corporate partner, business trainee
            $("#month_year").on('change', function (){
                monthYear = monthControl.value;
                // console.log(monthYear);
                //    hide user table
                document.getElementById("user-box").style.display = "none"; 
                monthlyUserCount();  
            });
                    
            // get month count
            function monthlyUserCount(){
                $.ajax({
                    type: "POST",
                    url: 'assets/submit/get_monthly_data.php',
                    data: 'month_year='+monthYear+'&userType=0'+'&userId=0',
                    success: function(res){
                        var userCount = JSON.parse(res);
                            //fetch data to innerHTML    
                        document.getElementById("customer_count").innerHTML = userCount[0];
                        document.getElementById("consultant_count").innerHTML = userCount[1];
                        document.getElementById("partner_count").innerHTML = userCount[2];
                        document.getElementById("corporate_partner_count").innerHTML = userCount[3];
                        document.getElementById("business_trainee_count").innerHTML = userCount[4];
                        document.getElementById("corporate_agency_count").innerHTML = userCount[10];
                        document.getElementById("CA_travel_agent_count").innerHTML = userCount[11];
                        document.getElementById("CA_customer_count").innerHTML = userCount[12];
                        document.getElementById("cbd_count").innerHTML = userCount[13];
                            
                    },
                    error: function(err){
                        console.log(err);
                    }
                });
                
            }

            $(".close-btn").click(function(){
                document.getElementById("user-box").style.display = "none"; 
            });
            
            function showUserBox(value){
                if(value=='customer'){
                    userType='customer';
                    document.getElementById("user-box").style.display = "block"; 
                    document.getElementById("table-heading").innerHTML = "Monthly Customer Details"; 
                
                }else if(value=='consultant'){
                    userType='consultant';
                    document.getElementById("user-box").style.display = "block";
                    document.getElementById("table-heading").innerHTML = "Monthly Business Consultant Details"; 
                
                }else if (value=='partner'){
                    userType='partner';
                    document.getElementById("user-box").style.display = "block";
                    document.getElementById("table-heading").innerHTML = "Monthly Business Partner Details"; 

                }else if (value=='business_trainee'){
                    userType='business_trainee';
                    document.getElementById("user-box").style.display = "block";
                    document.getElementById("table-heading").innerHTML = "Monthly Business Trainee Details"; 

                }else if (value=='corporate_partner'){
                    userType='corporate_partner';
                    document.getElementById("user-box").style.display = "block";
                    document.getElementById("table-heading").innerHTML = "Monthly Corporate Partner Details"; 

                }else if (value=='corporate_agency'){
                    userType='corporate_agency';
                    document.getElementById("user-box").style.display = "block";
                    document.getElementById("table-heading").innerHTML = "Monthly Techno Enterprise Details"; 
                    
                }else if (value=='ca_travelagency'){
                    userType='ca_travelagency';
                    document.getElementById("user-box").style.display = "block";
                    document.getElementById("table-heading").innerHTML = "Monthly Travel Agency Details"; 

                }else if (value=='ca_customer'){
                    userType='ca_customer';
                    document.getElementById("user-box").style.display = "block";
                    document.getElementById("table-heading").innerHTML = "Monthly Customers Details"; 
                }else if (value=='cbd'){
                    userType='cbd';
                    document.getElementById("user-box").style.display = "block";
                    document.getElementById("table-heading").innerHTML = "Monthly Channel Business Director Details"; 
                }
                // fetch records
                getMonthlyUserDetails(monthYear,userType,startRowfrom,limitCount,columnName,orderBy);
                getMonthlyUsersCount(monthYear,userType);
            }
            // get user details
            function getMonthlyUserDetails(monthYear,userType,startRowfrom,limitCount,columnName,orderBy)
            {
                $(".user_row").remove();
                $.ajax({
                    type: "POST",
                    url: 'assets/submit/monthly_user_details.php',
                    data: 'month_year='+monthYear+'&userType='+userType+'&userId=0'+'&startfrom='+startRowfrom+'&limitCount='+limitCount+'&column_name='+columnName+'&order_by='+orderBy,
                    success: function(res){
                            //fetch data to innerHTML    
                            $("#user_table").append(res);
                    },
                    error: function(err){
                        console.log(err);x
                    }
                }); 
            }

            var startRowfrom = 0;
            var limitCount = 5;
            var totalRowCount = 0;
            var columnName = 'id';
            var orderBy = 'ASC';

            async function getMonthlyUsersCount(monthYear,userType){
                // get user counts
                let option = {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json;charset=utf-8' },
                    body: JSON.stringify({
                                month_year:monthYear,
                                userType:userType
                            })
                }
                const response = await fetch('assets/submit/monthly_user_counts.php', option);
                totalRowCount = await response.json();
                setNumberOfPages(totalRowCount);
            }
            $("#pagination_row_limit").on('change', function() {
                limitCount = parseInt(this.value);
                startRowfrom = 0;
                
                setNumberOfPages(totalRowCount);
                setActivePeginatedRow(monthYear,userType,startRowfrom,limitCount,columnName,orderBy);
            });
            function setRowOrder(column) {
                // set order by
                if (orderBy == 'ASC') {
                    orderBy = 'DESC';                
                } else {
                    orderBy = 'ASC';                
                }
                columnName = column;
                startRowfrom = 0;

                setActivePeginatedRow(monthYear,userType,startRowfrom,limitCount,columnName,orderBy)            
            }
            function setNumberOfPages(row_count){
                var no_of_pages = Math.ceil(row_count / limitCount);

                var newContainer = document.createElement("div");
                newContainer.classList.add("middle");
                var paginationCount = $('#pagination_row');
                    paginationCount.empty();

                // previous forword pegination link
                var divString1 = '<div class="pagination"><a href="#"';
                var divString2 = 'class="page_nums';
                var divString3 = '';
                    if (no_of_pages<2) {   divString3 = 'disable_click';   }
                var divString41 = '" onclick="getPeginatedRowCount(0, 0);';
                var divString42 = '" onclick="getPeginatedRowCount(0, 1);';
                var divString5 = 'return false;">';
                var divString61 = '&laquo;';
                var divString62 = '&raquo;';
                var divString7 = '</a></div>';

                    newContainer.innerHTML += divString1.concat(" ", divString2, " ", divString3," ", divString41, "", divString5, " ", divString61, "", divString7 );
                    paginationCount.append(newContainer); // for multiple element to append
                    
                    for (let index = 0; index < no_of_pages; index++) {
                        var pagestartfrom = index * limitCount;
                        var pageNo = index + 1;
                        var htmlString2 = '';
                        var htmlString1 =  '<div class="pagination"><a href="#" class="page_nums';
                                            if (pageNo==1) { htmlString2 = 'active'; }
                        var htmlString3 = '" id="page_num_'+pagestartfrom+'" onclick="getPeginatedRowCount(1,'+pagestartfrom+'); return false;">'+pageNo+'</a></div>';
                        var html = htmlString1.concat(" ", htmlString2, " ", htmlString3);

                        newContainer.innerHTML += html;
                        paginationCount.append(newContainer); // for multiple element to append
                    }
                    // next pegination icon
                    newContainer.innerHTML += divString1.concat(" ", divString2, " ", divString3," ", divString42, "", divString5, " ", divString62, "", divString7 );
                    paginationCount.append(newContainer); // for multiple element to append
            }
            function getPeginatedRowCount(type, value) {
                var get_row = false;
                var get_page_count = startRowfrom + limitCount; // set max page limit

                if (type == '1' ) {
                    startRowfrom = value;   
                    get_row = true;
                } else if (startRowfrom == 0 && value==0 ) {
                } else if (get_page_count >= totalRowCount && value==1 ) {
                } else {
                    if(value==1){
                        startRowfrom += limitCount;
                    } else {
                        startRowfrom -= limitCount;
                    }
                    get_row = true;
                }

                if (get_row) {
                    setActivePeginatedRow(monthYear,userType,startRowfrom,limitCount,columnName,orderBy);
                }
            }
            function setActivePeginatedRow(monthYear,userType,startRowfrom,limitCount,columnName,orderBy) {
                const page_num = document.querySelector('#page_num_'+startRowfrom);
                        
                $(".page_nums").removeClass("active");
                page_num.classList.add('active');
                
                getMonthlyUserDetails(monthYear,userType,startRowfrom,limitCount,columnName,orderBy);
            }
        </script>

        <!-- calender get data and insert data  -->
        <script type="text/javascript">

            // $(".close-btn").click(function(){
            //     document.getElementById("user-box1").style.display = "none"; 
            // });
            
            // function showUserBox1(value){
            //     if (value=='latest_transaction'){
            //         userType='latest_transaction';
            //         document.getElementById("user-box1").style.display = "block";
            //         document.getElementById("latestTransaction").style.display="none";
            //         document.getElementById("eventCalender").classList.remove('col-xl-8');
            //         document.getElementById("eventCalender").classList.add('col-xl-12');
            //         document.getElementById("table-heading").innerHTML = "Monthly Latest Transaction Details"; 
                    
            //         showCalender();
            //     }
            //     // fetch records
            //     // getMonthlyUserDetails(monthYear,userType,startRowfrom,limitCount,columnName,orderBy);
            //     // getMonthlyUsersCount(monthYear,userType);
            // }

            // function calender get data and insert data
            function showCalender(){
                var calendarEl = document.getElementById('calendar');

                var calendar = new FullCalendar.Calendar(calendarEl, {
                    initialView: 'dayGridMonth',
                    events: function(fetchInfo, successCallback, failureCallback) {
                        // Use jQuery to fetch events from your PHP script
                        $.ajax({
                            url: 'calendar/loadEvent.php',
                            type: 'GET',
                            success: function(data) {
                                // Parse the returned data to create an array of event objects
                                var events = JSON.parse(data);
                                // Pass the array of events to the successCallback to render them on the calendar
                                successCallback(events);
                            },
                            error: function() {
                                // If there's an error fetching events, call the failureCallback
                                failureCallback();
                            }
                        });
                    }
                });
                calendar.render();
            }

            document.addEventListener('DOMContentLoaded', function() {
                showCalender();
            });

            $('#btn-save-event').on('click', function(e){
                e.preventDefault();
                // alert('Hello');
                var eventTitle = $('#event-title').val();
                var eventDate = $('#event-date').val();
                // console.log(eventTitle);
                // console.log(eventDate);
                var dataString = {
                    eventTitle , eventDate
                }
                if(eventTitle && eventDate){
                    $.ajax({
                        type: 'POST',
                        data: dataString,
                        url: 'calendar/insertEvent.php',
                        cache: false,
                        success: function(data){
                            // console.log(data);
                            if(data == '1'){
                                alert("Event Added Successfully");
                                window.location.reload();
                            }else{
                                alert("Error Adding Event");
                                window.location.reload();
                            }
                        }
                    });
                }else{
                    alert("Insert Valid Values");
                    window.location.reload();
                }
            });

            // Top performer button 
            function showDiv(divNumber) {
                // hide all divs first
                var divs = document.querySelectorAll('.contentDiv');
                divs.forEach(function(div) {
                    div.style.display = 'none';
                });

                // Show the clicked div 
                var activeDiv = document.getElementById('div' + divNumber);
                activeDiv.style.display = 'block';
            }

            // Top performer data change based on Month and Year BCH
            $('#month_year_BCH').change(function(){
                var date = $(this).val();
                var table_update = 'bch_top_performer';
                var month = date.split('-')[1];
                var year = date.split('-')[0];
                dataString = {
                    table_update, month, year
                }

                $.ajax({
                    type: 'POST',
                    data: dataString,
                    url: 'assets/submit/top_performer.php',
                    cache: false,
                    success: function(data){
                        // console.log(data);
                        $('#bch_top_performer').html(data);
                    }
                });
            });

            // Top performer data change based on Month and Year BDM
            $('#month_year_BDM').change(function(){
                var date = $(this).val();
                var table_update = 'bdm_top_performer';
                var month = date.split('-')[1];
                var year = date.split('-')[0];
                dataString = {
                    table_update, month, year
                }

                $.ajax({
                    type: 'POST',
                    data: dataString,
                    url: 'assets/submit/top_performer.php',
                    cache: false,
                    success: function(data){
                        // console.log(data);
                        $('#bdm_top_performer').html(data);
                    }
                });
            });

            // Top performer data change based on Month and Year BM
            $('#month_year_BM').change(function(){
                var date = $(this).val();
                var table_update = 'bm_top_performer';
                var month = date.split('-')[1];
                var year = date.split('-')[0];
                dataString = {
                    table_update, month, year
                }

                $.ajax({
                    type: 'POST',
                    data: dataString,
                    url: 'assets/submit/top_performer.php',
                    cache: false,
                    success: function(data){
                        // console.log(data);
                        $('#bm_top_performer').html(data);
                    }
                });
            });

            // Top performer data change based on Month and Year TE
            $('#month_year_TE').change(function(){
                var date = $(this).val();
                var table_update = 'te_top_performer';
                var month = date.split('-')[1];
                var year = date.split('-')[0];
                dataString = {
                    table_update, month, year
                }

                $.ajax({
                    type: 'POST',
                    data: dataString,
                    url: 'assets/submit/top_performer.php',
                    cache: false,
                    success: function(data){
                        // console.log(data);
                        $('#te_top_performer').html(data);
                    }
                });
            });

            // Top performer data change based on Month and Year TA
            $('#month_year_TA').change(function(){
                var date = $(this).val();
                var table_update = 'ta_top_performer';
                var month = date.split('-')[1];
                var year = date.split('-')[0];
                dataString = {
                    table_update, month, year
                }

                $.ajax({
                    type: 'POST',
                    data: dataString,
                    url: 'assets/submit/top_performer.php',
                    cache: false,
                    success: function(data){
                        // console.log(data);
                        $('#ta_top_performer').html(data);
                    }
                });
            });

            // Top performer data change based on Month and Year CU
            $('#month_year_CU').change(function(){
                var date = $(this).val();
                var table_update = 'cu_top_performer';
                var month = date.split('-')[1];
                var year = date.split('-')[0];
                dataString = {
                    table_update, month, year
                }

                $.ajax({
                    type: 'POST',
                    data: dataString,
                    url: 'assets/submit/top_performer.php',
                    cache: false,
                    success: function(data){
                        // console.log(data);
                        $('#cu_top_performer').html(data);
                    }
                });
            });

        </script>

    </body>

</html>