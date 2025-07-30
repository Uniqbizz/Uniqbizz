<?php
    session_start();
    if(!isset($_SESSION['username'])){
        echo '<script>location.href = "login.php";</script>';
    }

    require 'connect.php';
    $date = date('Y'); 

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
                                <div class="card overflow-hidden">
                                    <div class="bg-primary-subtle">
                                        <div class="row">
                                            <div class="col-7">
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
                                            <div class="col-sm-4">
                                                <div class="avatar-md profile-user-wid mb-4">
                                                    <img src="assets/images/users/avatar-1.jpg" alt="" class="img-thumbnail rounded-circle">
                                                </div>
                                                <h5 class="font-size-14 text-truncate">Admin</h5>
                                            </div>

                                            <div class="col-sm-8">
                                                <div class="pt-4">

                                                    <div class="row">
                                                        <div class="col-6">
                                                            <?php
                                                                $sqlbooking = "SELECT COUNT(id) AS booked FROM `bookings` WHERE status='1'";
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
                                                        <div class="col-6">
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
                                                            <p class="text-muted mb-0 font-size-11">Corporate Agency</p>
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

                                    <div class="col-md-4">
                                        <div class="card card-equal mini-stats-wid">
                                            <div class="card-body">
                                                <div class="d-flex">
                                                    <div class="flex-grow-1">
                                                        <p class="text-muted fw-medium">Employees</p>
                                                        <?php
                                                            $stmt = $conn->prepare("SELECT COUNT(regional_manager_id) as totalRM, ( SELECT COUNT(sales_manager_id) FROM  sales_manager WHERE user_type = '5' AND status = '1' ) as totalSM, ( SELECT COUNT(branch_manager_id) FROM branch_manager WHERE user_type = '6' AND status ='1') as totalBR FROM regional_manager WHERE user_type = '7' AND status = '1' ");
                                                            $stmt->execute();
                                                            $stmt->setFetchMode(PDO::FETCH_ASSOC);
                                                            if($stmt->rowCount()>0){
                                                                foreach (($stmt->fetchAll()) as $key => $row) {
                                                                    $totalRM = $row['totalRM'];
                                                                    $totalSM = $row['totalSM'];
                                                                    $totalBR = $row['totalBR'];
                                                                    $totalEmp =  $totalRM + $totalSM + $totalBR;
                                                                    echo '<h4 class="mb-0">'.$totalEmp.'</h4>';
                                                                }
                                                            } else{
                                                                echo '<h4 class="mb-0">0</h4>';
                                                            }
                                                        ?> 
                                                    </div>

                                                    <div class="flex-shrink-0 align-self-center">
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

                                    <div class="col-md-4">
                                        <div class="card card-equal mini-stats-wid">
                                            <div class="card-body">
                                                <div class="d-flex">
                                                    <div class="flex-grow-1">
                                                        <p class="text-muted fw-medium">Channel Business Director</p>
                                                        <?php
                                                            $stmt = $conn->prepare("SELECT count(channel_business_director_id) as totalchannel_business_director FROM channel_business_director where user_type='18' and status='1' ");
                                                            $stmt->execute();
                                                            $stmt->setFetchMode(PDO::FETCH_ASSOC);
                                                            if($stmt->rowCount()>0){
                                                                foreach (($stmt->fetchAll()) as $key => $row) {
                                                                    $totalchannel_business_director=$row['totalchannel_business_director'];
                                                                    echo '<h4 class="mb-0">'.$totalchannel_business_director.'</h4>';
                                                                }
                                                            } else{
                                                                echo '<h4 class="mb-0">0</h4>';
                                                            }
                                                        ?> 
                                                    </div>

                                                    <div class="flex-shrink-0 align-self-center">
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

                                    <div class="col-md-4" style="display: none;">
                                        <div class="card card-equal mini-stats-wid">
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

                                                    <div class="flex-shrink-0 align-self-center">
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

                                    <div class="col-md-4">
                                        <div class="card card-equal mini-stats-wid">
                                            <div class="card-body">
                                                <div class="d-flex">
                                                    <div class="flex-grow-1">
                                                        <p class="text-muted fw-medium">Business Consultant</p>
                                                        <?php
                                                            $stmt = $conn->prepare("SELECT count(travel_agent_id) as totaltravel_agent FROM travel_agent where user_type='3' and status='1' ");
                                                            $stmt->execute();
                                                            $stmt->setFetchMode(PDO::FETCH_ASSOC);
                                                            if($stmt->rowCount()>0){
                                                                foreach (($stmt->fetchAll()) as $key => $row) {
                                                                    $totaltravel_agent=$row['totaltravel_agent'];
                                                                    echo '<h4 class="mb-0">'.$totaltravel_agent.'</h4>';
                                                                }
                                                            } else{
                                                                echo '<h4 class="mb-0">0</h4>';
                                                            }
                                                        ?> 
                                                    </div>

                                                    <div class="flex-shrink-0 align-self-center">
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

                                     <div class="col-md-4">
                                        <div class="card card-equal mini-stats-wid">
                                            <div class="card-body">
                                                <div class="d-flex">
                                                    <div class="flex-grow-1">
                                                        <p class="text-muted fw-medium">Corporate Agency</p>
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

                                                    <div class="flex-shrink-0 align-self-center">
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

                                    <div class="col-md-4">
                                        <div class="card card-equal mini-stats-wid">
                                            <div class="card-body">
                                                <div class="d-flex">
                                                    <div class="flex-grow-1">
                                                        <p class="text-muted fw-medium">Travel  Agent</p>
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

                                                    <div class="flex-shrink-0 align-self-center">
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

                                    <div class="col-md-4 ">
                                        <div class="card card-equal mini-stats-wid">
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

                                                    <div class="flex-shrink-0 align-self-center">
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

                        <!-- Count--Section -->
                        <div class="card">
                            <div class="row">
                                <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 p-2">
                                    <div class="p-3">
                                        <div class="row">
                                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4">
                                                <div class="row">
                                                    <div class="col-md-2"><label for="dateInput">Date:</label></div>
                                                    <div class="col-md-4"><p type="none" class="date border border-top-0 border-end-0 border-start-0 me-2" id="dateInput">03/09/2024</p></div>
                                                    <div class="col-md-4"><input type="date" id="dateInput"></div>
                                                </div>
                                            </div>
                                            <div class="col-xl-8 col-lg-8 col-md-8 col-sm-8">
                                                <div class="row">
                                                    <div class="col-md-4"><label for="dateInput">Total Business on this day:</label></div>
                                                    <div class="col-md-2"><p type="none" class="date border border-top-0 border-end-0 border-start-0 me-2" id="dateInput">03/09/2024</p></div>
                                                    <div class="col-md-1"><label for="dateInput">CA</label>/</div>
                                                    <div class="col-md-1"><label for="dateInput">TA</label>/</div>
                                                    <div class="col-md-2"><label for="dateInput">Franchisee</label>/</div>
                                                    <div class="col-md-2"><p type="none" class="date border border-top-0 border-end-0 border-start-0 me-2" id="dateInput">75000/-</p></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="card mt-3">
                                                    <div class="row">
                                                        <div class="col-md-5"><label for="franchiseeCount">Total Franchisee:</label></div>
                                                        <div class="col-md-6"><p type="none" class="date border border-top-0 border-end-0 border-start-0 me-2" id="franchiseeCount">00</p></div>
                                                        <div class="col-md-5"><label for="caCount">Total CA:</label></div>
                                                        <div class="col-md-6"><p type="none" class="date border border-top-0 border-end-0 border-start-0 me-2" id="caCount">00</p></div>
                                                        <div class="col-md-5"><label for="taCount">Total TA:</label></div>
                                                        <div class="col-md-6"><p type="none" class="date border border-top-0 border-end-0 border-start-0 me-2" id="taCount">00</p></div>
                                                        <div class="col-md-5"><label for="bcCount">Total BC:</label></div>
                                                        <div class="col-md-6"><p type="none" class="date border border-top-0 border-end-0 border-start-0 me-2" id="bcCount">00</p></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-8">
                                                <div class="row">
                                                    <div class="card mt-3">
                                                        <table class="table">
                                                            <thead>
                                                                <tr>
                                                                    <th scope="col">Id</th>
                                                                    <th scope="col">CA Name</th>
                                                                    <th scope="col">Ref.Name</th>
                                                                    <th scope="col">Amount</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td>01</td>
                                                                    <td>Nishant CM</td>
                                                                    <td>Saibaj</td>
                                                                    <td>75000</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>01</td>
                                                                    <td>Nishant CM</td>
                                                                    <td>Saibaj</td>
                                                                    <td>75000</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>01</td>
                                                                    <td>Nishant CM</td>
                                                                    <td>Saibaj</td>
                                                                    <td>75000</td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row chart-count">
                            <div class="col-xl-12 card mb-4">
                                <div class="row mb-3">
                                    <div class="col-lg-7 col-md-12 col-sm-12">
                                        <!-- <div class=""> -->
                                            <div class="card-body">
                
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
                                                
                                            </div>
                                        <!-- </div> -->
                                    </div>
                                    
                                    <!-- monthly count of all -->
                                    <div class="col-lg-5 col-md-12 col-sm-12">
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
                                                    <p><i class="mdi  mdi-arrow-up-thick mdi-18px"></i> <span style="font-size: 12px;">Channel Business Director</span></p>
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
                                                    <p><i class="mdi  mdi-arrow-up-thick mdi-18px"></i> <span style="font-size: 12px;">Corporate Agency</span></p>
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
                                                    <p><i class="mdi  mdi-arrow-up-thick mdi-18px"></i> <span style="font-size: 12px;">Travel Agent</span></p>
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
                                    </div>

                                    <!-- monthly user details table  -->
                                    <div class="row" style="padding-top: 25px; display: none;" id="user-box">
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
                                            <div class="table-responsive table-desi">
                                                <!-- table roe limit -->
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
                                                </table>
                                                <!-- pegination start -->
                                                <div class="center text-center" id="pagination_row"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> <!-- end col -->
                        </div> <!-- end row -->

                        <div class="row">
                            <div class="col-xl-6">
                                <div class="card">
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
                            </div> <!-- end col -->
                            <div class="col-xl-6">
                                <div class="card" id="ca_chart_box">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="tab-inn">
                                                    <h6>Corporate Agency</h6>
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
                                </div>
                            </div> <!-- end col -->
                        </div> <!-- end row -->

                        <!-- Full Calender -->
                        <div class="row">
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-xl-8" id="eventCalender">
                                        <div class="card">
                                            <div id="btn-new-event"></div>
                                            <div id='locale-selector' class="d-none"></div>
                                            <div class="card-body">
                                                <div id="external-events">
                                                    <button type="button" data-bs-toggle="modal" data-bs-target="#event-modal" class="btn btn-success btn-rounded waves-effect waves-light mb-2 me-2 addBusinessTraineemodal"><i class="mdi mdi-plus me-1"></i> Add Event</button>
                                                </div>
                                                <div id="calendar"></div>
                                            </div>
                                        </div>
                                    </div> <!-- end col -->
                                    <!-- Latest Transaction -->
                                    <div class="col-xl-4" id="latestTransaction">
                                        <div class="card">
                                            <h2 class="fs-4 p-3">Latest Transaction</h2>
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
                                            </div>
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
                                            <div class="col-md-6 col-sm-6 col-6 pb-3 ps-2">
                                                <button class="cpn_btn box-btn float-start" type="button" onclick="showUserBox1('latest_transaction');">View More</button>
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div> 
                                <div class="row bg-white" style="padding-top: 25px; display: none;" id="user-box1">
                                    <div class="col-md-12"> 
                                        <div>
                                            <hr>
                                            <div class="MonthlyDetailsHeading ps-3">
                                                <span id="table-heading" class="fs-5 fw-bold ps-2">Latest Transaction</span>
                                            </div>
                                            <!-- close--Button -->
                                            <!-- <div class="MonthlyDetailsHeadingClose pe-3">
                                                <span class="close-btn" style="float:right; padding: 0px 10px 10px 10px; font-weight: 600; font-size: initial; cursor:pointer; color:red"> X </span>
                                            </div> -->
                                        </div>
                                        <input type="hidden" name="user_table_count" id="user_table_count" value="" />
                                        <div class="table-responsive table-desi">

                                            <!-- table roe limit -->
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
                                            <!-- <table class="table table-hover" id="user_table">
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
                                            <!-- pegination start -->
                                            <div class="center text-center" id="pagination_row"></div>
                                        </div>
                                    </div>
                                </div>
                                <div style='clear:both'></div>

                                <!-- Add New Event MODAL -->
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
                                        </div> <!-- end modal-content-->
                                    </div> <!-- end modal dialog-->
                                </div>
                                <!-- end modal-->
                            </div>
                        </div>
                        <!-- End Full Calender -->
                    
                        <div class="row">
                            
                            <div class="col-xl-6 col-md-6 col-sm-12 p-3">
                                <div class="card">
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
                                                        // $sql1 = "SELECT * FROM customer where user_type='2' and (status='1' or status='0' or status='3') and cust_id != '' order by cust_id desc limit 5";
                                                        $sql1 = "SELECT regional_manager_id as id, firstname, lastname, status FROM regional_manager UNION ALL 
                                                                 SELECT sales_manager_id as id, firstname, lastname, status FROM sales_manager UNION ALL 
                                                                 SELECT branch_manager_id as id, firstname, lastname, status FROM branch_manager 
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

                            <div class="col-xl-6 col-md-6 col-sm-12 p-3">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="card-title pb-2 d-flex justify-content-between ps-3 pe-3">
                                            <div class="heading">
                                                <h4>Channel Business Director</h4>
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
                                <div class="card">
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
                                <div class="card">
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
                                                        $sql1 = "SELECT * FROM travel_agent where user_type='3' and (status='1' or status='0' or status='3') and travel_agent_id != '' order by travel_agent_id desc limit 6";
                                                        $stmt1 = $conn -> prepare($sql1);
                                                        $stmt1 -> execute();
                                                        $stmt1 -> setFetchMode(PDO::FETCH_ASSOC);
                                                        if( $stmt1 -> rowCount()>0){
                                                            foreach( ($stmt1 -> fetchAll()) as $key => $row ){
                                                                echo'<tr>
                                                                    <td>'.$row['travel_agent_id'].'</td>
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
                                <div class="card">
                                    <div class="card-body">
                                        <div class="card-title pb-2 d-flex justify-content-between ps-3 pe-3">
                                            <div class="heading">
                                                <h4>Corporate Agency</h4>
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
                                <div class="card">
                                    <div class="card-body">
                                        <div class="card-title pb-2 d-flex justify-content-between ps-3 pe-3">
                                            <div class="heading">
                                                <h4>Travel Agent</h4>
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
                                <div class="card">
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
                    // console.log(data);
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
                            {
                                label: "Channel Business Director",
                                data: values_cbd,
                                borderColor: "yellow",
                                fill: true
                            },
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
                            {
                                label: "Consultant",
                                data: values_ta,
                                borderColor: "blue",
                                fill: true
                            },
                            {
                                label: "Corporate Agency",
                                data: values_ca,
                                borderColor: "green",
                                fill: true
                            },
                            {
                                label: "Travel Agency",
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
                    document.getElementById("table-heading").innerHTML = "Monthly Corporate Agency Details"; 
                    
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
            $(".close-btn").click(function(){
                document.getElementById("user-box1").style.display = "none"; 
            });
            
            function showUserBox1(value){
                if (value=='latest_transaction'){
                    userType='latest_transaction';
                    document.getElementById("user-box1").style.display = "block";
                    document.getElementById("latestTransaction").style.display="none";
                    document.getElementById("eventCalender").classList.remove('col-xl-8');
                    document.getElementById("eventCalender").classList.add('col-xl-12');
                    document.getElementById("table-heading").innerHTML = "Monthly Latest Transaction Details"; 
                    
                    showCalender();
                }
                // fetch records
                // getMonthlyUserDetails(monthYear,userType,startRowfrom,limitCount,columnName,orderBy);
                // getMonthlyUsersCount(monthYear,userType);
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

        <!-- show calender when page loads  -->
        <script type="text/javascript">
            document.addEventListener('DOMContentLoaded', function() {
                showCalender();
            });

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

        </script>

    </body>

</html>