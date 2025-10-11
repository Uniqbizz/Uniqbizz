<?php
session_start();
if (!isset($_SESSION['username'])) {
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
    <!-- DataTables CSS -->
    <!-- <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css"> -->

    <!-- App js -->
    <!-- <script src="assets/js/plugin.js"></script> -->

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

        /* .chart-count {
            margin-left: 2px;
            margin-right: 2px;
        } */

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

        /* image class for profile-img from admin welcome section */
        /* .img-fluid {
            width: 100% !important;
            height: 120px !important;
        } */
    </style>
</head>
<!-- DataTables -->
    <link href="assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />

    <!-- Responsive datatable examples -->
    <link href="assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    
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
                                                <p class="text-primary">Admin</p>
                                            </div>
                                        </div>
                                        <div class="col-5 align-self-end">
                                            <!-- <img src="assets/images/profile-img.png" alt="" class="img-fluid"> -->
                                            <div class="avatar-lg mb-2 mt-2">
                                                <img src="assets/images/users/avatar-1.jpg" alt="" class="img-thumbnail rounded-circle">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body pt-0">
                                    <div class="row">
                                        <!-- <div class="col-sm-4 col-4"> -->
                                            <!-- <div class="avatar-lg mb-3 mt-n5">
                                                <img src="assets/images/users/avatar-1.jpg" alt="" class="img-thumbnail rounded-circle">
                                            </div> -->
                                            <!-- <h5 class="font-size-14 text-truncate fw-bolder">Admin</h5> -->
                                        <!-- </div> -->

                                        <div class="col-sm-12 col-12">
                                            <div class="pt-4">
                                                <div class="row">
                                                    <div class="col-7 p-0">
                                                        <p class="text-muted font-size-13 ps-2">Packages Sold</p>
                                                        <p class="text-muted font-size-13 ps-2">Techno Enterprise</p>
                                                        <p class="text-muted font-size-13 ps-2">Franchise</p>
                                                        <p class="text-muted font-size-13 ps-2">Master Franchise</p>
                                                        <p class="text-muted font-size-13 ps-2">Sponsor Franchise</p>
                                                    </div>
                                                    <div class="col-5 p-0">
                                                        <!-- Packages Sold  -->
                                                        <?php
                                                            $sqlbooking = "SELECT COUNT(id) AS booked FROM `bookings` WHERE confirm_status = '1' ";
                                                            $sqlBooked = $conn->prepare($sqlbooking);
                                                            $sqlBooked->execute();
                                                            $sqlBooked->setFetchMode(PDO::FETCH_ASSOC);
                                                            if (($sqlBooked->rowCount() > 0)) {
                                                                foreach ($sqlBooked->fetchAll() as $key => $value) {
                                                                    $totalBooked = $value['booked'];
                                                                    echo '<h5 class="font-size-13">' . $totalBooked . '</h5>';
                                                                }
                                                            }
                                                        ?>
                                                        <!-- Techno Enterprise -->
                                                        <?php
                                                            $Amt = 0;

                                                            // Prepare and execute query
                                                            $sql = "SELECT SUM(CASE WHEN amount IS NULL THEN 0 ELSE amount END) AS total_amount FROM corporate_agency WHERE status = '1'";
                                                            $stmt = $conn->prepare($sql);
                                                            $stmt->execute();
                                                            $result = $stmt->fetch(PDO::FETCH_ASSOC);

                                                            // Fetch total amount
                                                            $Amt = $result['total_amount'] ?? 0;

                                                            // Format in Indian currency style (e.g., 12,34,567)
                                                            $formattedAmt = preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $Amt);

                                                            // Output
                                                            echo '<h5 class="font-size-13"><span>&#8377;</span>' . $formattedAmt . '/-</h5>';
                                                        ?>

                                                        <!-- sub_franchisee -->
                                                        <?php
                                                            $Amt = 0;

                                                            // Prepare and execute query
                                                            $sql = "SELECT SUM(CASE WHEN amount IS NULL THEN 0 ELSE amount END) AS total_amount FROM sub_franchisee WHERE status = '1'";
                                                            $stmt = $conn->prepare($sql);
                                                            $stmt->execute();
                                                            $result = $stmt->fetch(PDO::FETCH_ASSOC);

                                                            // Fetch total amount
                                                            $Amt = $result['total_amount'] ?? 0;

                                                            // Format in Indian currency style (e.g., 12,34,567)
                                                            $formattedAmt = preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $Amt);

                                                            // Output
                                                            echo '<h5 class="font-size-13"><span>&#8377;</span>' . $formattedAmt . '/-</h5>';
                                                        ?>

                                                        <!-- Master Franchisee -->
                                                        <?php
                                                            $Amt = 0;

                                                            // Prepare and execute query
                                                            $sql = "SELECT SUM(CASE WHEN paid_amount IS NULL THEN 0 ELSE paid_amount END) AS total_amount FROM master_franchisee WHERE status = '1'";
                                                            $stmt = $conn->prepare($sql);
                                                            $stmt->execute();
                                                            $result = $stmt->fetch(PDO::FETCH_ASSOC);

                                                            // Fetch total amount
                                                            $Amt = $result['total_amount'] ?? 0;

                                                            // Format in Indian currency style (e.g., 12,34,567)
                                                            $formattedAmt = preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $Amt);

                                                            // Output
                                                            echo '<h5 class="font-size-13"><span>&#8377;</span>' . $formattedAmt . '/-</h5>';
                                                        ?>

                                                        <!-- Sponsor Franchise -->
                                                        <?php
                                                            $Amt = 0;

                                                            // Prepare and execute query
                                                            $sql = "SELECT SUM(CASE WHEN paid_amount IS NULL THEN 0 ELSE paid_amount END) AS total_amount FROM sponsor_franchisee WHERE status = '1'";
                                                            $stmt = $conn->prepare($sql);
                                                            $stmt->execute();
                                                            $result = $stmt->fetch(PDO::FETCH_ASSOC);

                                                            // Fetch total amount
                                                            $Amt = $result['total_amount'] ?? 0;

                                                            // Format in Indian currency style (e.g., 12,34,567)
                                                            $formattedAmt = preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $Amt);

                                                            // Output
                                                            echo '<h5 class="font-size-13"><span>&#8377;</span>' . $formattedAmt . '/-</h5>';
                                                        ?>
                                                        
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
                                                    if ($stmt->rowCount() > 0) {
                                                        foreach (($stmt->fetchAll()) as $key => $row) {
                                                            $totalemployee = $row['totalemployee'];
                                                            echo '<h4 class="mb-0">' . $totalemployee . '</h4>';
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
                                                    <p class="text-muted fw-medium">Business Mentor</p>
                                                    <?php
                                                    $stmt = $conn->prepare("SELECT count(business_mentor_id) as totalbusiness_mentor FROM business_mentor where user_type='26' and status='1' ");
                                                    $stmt->execute();
                                                    $stmt->setFetchMode(PDO::FETCH_ASSOC);
                                                    if ($stmt->rowCount() > 0) {
                                                        foreach (($stmt->fetchAll()) as $key => $row) {
                                                            $totalbusiness_mentor = $row['totalbusiness_mentor'];
                                                            echo '<h4 class="mb-0">' . $totalbusiness_mentor . '</h4>';
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
                                                    if ($stmt->rowCount() > 0) {
                                                        foreach (($stmt->fetchAll()) as $key => $row) {
                                                            $totalbusiness_trainee = $row['totalbusiness_trainee'];
                                                            echo '<h4 class="mb-0">' . $totalbusiness_trainee . '</h4>';
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

                                <div class="col-md-4 col-sm-6 col-12" style="display: none;">
                                    <div class="card card-equal mini-stats-wid rounded-4">
                                        <div class="card-body">
                                            <div class="d-flex">
                                                <div class="flex-grow-1">
                                                    <p class="text-muted fw-medium">Business Consultant</p>
                                                    <?php
                                                    $stmt = $conn->prepare("SELECT count(business_consultant_id) as totalbusiness_consultant FROM business_consultant where user_type='3' and status='1' ");
                                                    $stmt->execute();
                                                    $stmt->setFetchMode(PDO::FETCH_ASSOC);
                                                    if ($stmt->rowCount() > 0) {
                                                        foreach (($stmt->fetchAll()) as $key => $row) {
                                                            $totalbusiness_consultant = $row['totalbusiness_consultant'];
                                                            echo '<h4 class="mb-0">' . $totalbusiness_consultant . '</h4>';
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
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Customer Types -->
                    <!-- <div class="row">
                        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="card rounded-4">
                                <div class="bg-primary-subtle rounded-top-4 p-3 pb-2">
                                    <h5 class="text-primary-emphasis">Regular Customer</h5>
                                </div>
                                <div class="card-body p-3 pt-2">
                                    <div class="row">
                                        <div class="col-md-8 col-sm-8 col-8">
                                            <p class="fw-bolder text-black">Count</p>
                                        </div>
                                        <div class="col-md-4 col-sm-4 col-4">
                                            <?php
                                                $stmt = $conn->prepare("SELECT COUNT(id) as totalRegularCustomer FROM `ca_customer` WHERE customer_type = 'Free' AND status = '1' ");
                                                $stmt->execute();
                                                $stmt->setFetchMode(PDO::FETCH_ASSOC);
                                                if ($stmt->rowCount() > 0) {
                                                    foreach (($stmt->fetchAll()) as $key => $row) {
                                                        $totalRegularCustomer = $row['totalRegularCustomer'];
                                                        echo '<p class="text-end text-black">'.$totalRegularCustomer.'</p>';
                                                    }
                                                } else {
                                                    echo '<p class="text-end text-black">0</p>';
                                                }
                                            ?>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 col-sm-6 col-6">
                                            <p class="fw-bolder text-black">Amount</p>
                                        </div>
                                        <div class="col-md-6 col-sm-6 col-6">
                                            <p class="text-black text-end">Free</p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-8 col-sm-8 col-8">
                                            <p class="fw-bolder text-black">Complimentary</p>
                                        </div>
                                        <div class="col-md-4 col-sm-4 col-4">
                                            <?php
                                                $stmt = $conn->prepare("SELECT COUNT(id) as totalRegularCompCustomer FROM `ca_customer` WHERE customer_type = 'Free' AND comp_chek = '1' AND status = '1' ");
                                                $stmt->execute();
                                                $stmt->setFetchMode(PDO::FETCH_ASSOC);
                                                if ($stmt->rowCount() > 0) {
                                                    foreach (($stmt->fetchAll()) as $key => $row) {
                                                        $totalRegularCompCustomer = $row['totalRegularCompCustomer'];
                                                        echo '<p class="text-end text-black">'.$totalRegularCompCustomer.'</p>';
                                                    }
                                                } else {
                                                    echo '<p class="text-end text-black">0</p>';
                                                }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="card rounded-4">
                                <div class="bg-primary-subtle rounded-top-4 p-3 pb-2">
                                    <h5 class="text-primary-emphasis">Prime Customer</h5>
                                </div>
                                <div class="card-body p-3 pt-2">
                                    <div class="row">
                                        <div class="col-md-8 col-sm-8 col-8">
                                            <p class="fw-bolder text-black">Count</p>
                                        </div>
                                        <div class="col-md-4 col-sm-4 col-4">
                                            <?php
                                                $stmt = $conn->prepare("SELECT COUNT(id) as totalPrimeCustomer FROM `ca_customer` WHERE customer_type = 'Prime' AND status = '1' ");
                                                $stmt->execute();
                                                $stmt->setFetchMode(PDO::FETCH_ASSOC);
                                                if ($stmt->rowCount() > 0) {
                                                    foreach (($stmt->fetchAll()) as $key => $row) {
                                                        $totalPrimeCustomer = $row['totalPrimeCustomer'];
                                                        echo '<p class="text-end text-black">'.$totalPrimeCustomer.'</p>';
                                                    }
                                                } else {
                                                    echo '<p class="text-end text-black">0</p>';
                                                }
                                            ?>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 col-sm-6 col-6">
                                            <p class="fw-bolder text-black">Amount</p>
                                        </div>
                                        <div class="col-md-6 col-sm-6 col-6">
                                            <?php
                                            $Amt = 0;
                                            $sqlCaAmt = "SELECT paid_amount FROM `ca_customer` WHERE customer_type = 'Prime' AND status = '1'";
                                            $sqlTotalAmt = $conn->prepare($sqlCaAmt);
                                            $sqlTotalAmt->execute();
                                            $sqlTotalAmt->setFetchMode(PDO::FETCH_ASSOC);
                                            if (($sqlTotalAmt->rowCount() > 0)) {
                                                foreach ($sqlTotalAmt->fetchAll() as $key => $value) {
                                                    $totalAmt = $value['paid_amount'];

                                                    if ($totalAmt == 'null') {
                                                        $totalAmt = 0;
                                                    } else {
                                                        $totalAmt;
                                                    }

                                                    $Amt = $Amt + $totalAmt;
                                                }
                                            }
                                            $Amt = preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $Amt);
                                            echo '<p class="text-black text-end">'.$Amt.'</p>';
                                            ?>
                                            
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-8 col-sm-8 col-8">
                                            <p class="fw-bolder text-black">Complimentary</p>
                                        </div>
                                        <div class="col-md-4 col-sm-4 col-4">
                                            <?php
                                                $stmt = $conn->prepare("SELECT COUNT(id) as totalPrimeCompCustomer FROM `ca_customer` WHERE customer_type = 'Prime' AND comp_chek = '1' AND status = '1' ");
                                                $stmt->execute();
                                                $stmt->setFetchMode(PDO::FETCH_ASSOC);
                                                if ($stmt->rowCount() > 0) {
                                                    foreach (($stmt->fetchAll()) as $key => $row) {
                                                        $totalPrimeCompCustomer = $row['totalPrimeCompCustomer'];
                                                        echo '<p class="text-end text-black">'.$totalPrimeCompCustomer.'</p>';
                                                    }
                                                } else {
                                                    echo '<p class="text-end text-black">0</p>';
                                                }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="card rounded-4">
                                <div class="bg-primary-subtle rounded-top-4 p-3 pb-2">
                                    <h5 class="text-primary-emphasis">Premium Customer</h5>
                                </div>
                                <div class="card-body p-3 pt-2">
                                    <div class="row">
                                        <div class="col-md-8 col-sm-8 col-8">
                                            <p class="fw-bolder text-black">Count</p>
                                        </div>
                                        <div class="col-md-4 col-sm-4 col-4">
                                            <?php
                                                $stmt = $conn->prepare("SELECT COUNT(id) as totalPremiumCustomer FROM `ca_customer` WHERE customer_type = 'Premium' AND status = '1' ");
                                                $stmt->execute();
                                                $stmt->setFetchMode(PDO::FETCH_ASSOC);
                                                if ($stmt->rowCount() > 0) {
                                                    foreach (($stmt->fetchAll()) as $key => $row) {
                                                        $totalPremiumCustomer = $row['totalPremiumCustomer'];
                                                        echo '<p class="text-end text-black">'.$totalPremiumCustomer.'</p>';
                                                    }
                                                } else {
                                                    echo '<p class="text-end text-black">0</p>';
                                                }
                                            ?>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 col-sm-6 col-6">
                                            <p class="fw-bolder text-black">Amount</p>
                                        </div>
                                        <div class="col-md-6 col-sm-6 col-6">
                                        <?php
                                            $Amt = 0;
                                            $sqlCaAmt = "SELECT paid_amount FROM `ca_customer` WHERE customer_type = 'Premium' AND status = '1'";
                                            $sqlTotalAmt = $conn->prepare($sqlCaAmt);
                                            $sqlTotalAmt->execute();
                                            $sqlTotalAmt->setFetchMode(PDO::FETCH_ASSOC);
                                            if (($sqlTotalAmt->rowCount() > 0)) {
                                                foreach ($sqlTotalAmt->fetchAll() as $key => $value) {
                                                    $totalAmt = $value['paid_amount'];

                                                    if ($totalAmt == 'null') {
                                                        $totalAmt = 0;
                                                    } else {
                                                        $totalAmt;
                                                    }

                                                    $Amt = $Amt + $totalAmt;
                                                }
                                            }
                                            $Amt = preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $Amt);
                                            echo '<p class="text-black text-end">'.$Amt.'</p>';
                                            ?>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-8 col-sm-8 col-8">
                                            <p class="fw-bolder text-black">Complimentary</p>
                                        </div>
                                        <div class="col-md-4 col-sm-4 col-4">
                                            <?php
                                                $stmt = $conn->prepare("SELECT COUNT(id) as totalPremiumCompCustomer FROM `ca_customer` WHERE customer_type = 'Premium' AND comp_chek = '1' AND status = '1' ");
                                                $stmt->execute();
                                                $stmt->setFetchMode(PDO::FETCH_ASSOC);
                                                if ($stmt->rowCount() > 0) {
                                                    foreach (($stmt->fetchAll()) as $key => $row) {
                                                        $totalPremiumCompCustomer = $row['totalPremiumCompCustomer'];
                                                        echo '<p class="text-end text-black">'.$totalPremiumCompCustomer.'</p>';
                                                    }
                                                } else {
                                                    echo '<p class="text-end text-black">0</p>';
                                                }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="card rounded-4">
                                <div class="bg-primary-subtle rounded-top-4 p-3 pb-2">
                                    <h5 class="text-primary-emphasis">Premium Plus Customer</h5>
                                </div>
                                <div class="card-body p-3 pt-2">
                                    <div class="row">
                                        <div class="col-md-8 col-sm-8 col-8">
                                            <p class="fw-bolder text-black">Count</p>
                                        </div>
                                        <div class="col-md-4 col-sm-4 col-4">
                                            <?php
                                                $stmt = $conn->prepare("SELECT COUNT(id) as totalPremiumPlusCustomer FROM `ca_customer` WHERE customer_type = 'Premium Plus' AND status = '1' ");
                                                $stmt->execute();
                                                $stmt->setFetchMode(PDO::FETCH_ASSOC);
                                                if ($stmt->rowCount() > 0) {
                                                    foreach (($stmt->fetchAll()) as $key => $row) {
                                                        $totalPremiumPlusCustomer = $row['totalPremiumPlusCustomer'];
                                                        echo '<p class="text-end text-black">'.$totalPremiumPlusCustomer.'</p>';
                                                    }
                                                } else {
                                                    echo '<p class="text-end text-black">0</p>';
                                                }
                                            ?>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 col-sm-6 col-6">
                                            <p class="fw-bolder text-black">Amount</p>
                                        </div>
                                        <div class="col-md-6 col-sm-6 col-6">
                                        <?php
                                            $Amt = 0;
                                            $sqlCaAmt = "SELECT paid_amount FROM `ca_customer` WHERE customer_type = 'Premium Plus' AND status = '1'";
                                            $sqlTotalAmt = $conn->prepare($sqlCaAmt);
                                            $sqlTotalAmt->execute();
                                            $sqlTotalAmt->setFetchMode(PDO::FETCH_ASSOC);
                                            if (($sqlTotalAmt->rowCount() > 0)) {
                                                foreach ($sqlTotalAmt->fetchAll() as $key => $value) {
                                                    $totalAmt = $value['paid_amount'];

                                                    if ($totalAmt == 'null') {
                                                        $totalAmt = 0;
                                                    } else {
                                                        $totalAmt;
                                                    }

                                                    $Amt = $Amt + $totalAmt;
                                                }
                                            }
                                            $Amt = preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $Amt);
                                            echo '<p class="text-black text-end">'.$Amt.'</p>';
                                            ?>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-8 col-sm-8 col-8">
                                            <p class="fw-bolder text-black">Complimentary</p>
                                        </div>
                                        <div class="col-md-4 col-sm-4 col-4">
                                            <?php
                                                $stmt = $conn->prepare("SELECT COUNT(id) as totalPremiumCompCustomer FROM `ca_customer` WHERE customer_type = 'Premium Plus' AND comp_chek = '1' AND status = '1' ");
                                                $stmt->execute();
                                                $stmt->setFetchMode(PDO::FETCH_ASSOC);
                                                if ($stmt->rowCount() > 0) {
                                                    foreach (($stmt->fetchAll()) as $key => $row) {
                                                        $totalPremiumCompCustomer = $row['totalPremiumCompCustomer'];
                                                        echo '<p class="text-end text-black">'.$totalPremiumCompCustomer.'</p>';
                                                    }
                                                } else {
                                                    echo '<p class="text-end text-black">0</p>';
                                                }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> -->
                    <!-- end row -->
                    <div class="row">
                        <!-- Customer Types -->
                        <div class="col-lg-6 col-md-12 col-sm-12 mb-2">
                            <div class="row">
                                
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                    <div class="card rounded-4">
                                        <div class="bg-primary-subtle rounded-top-4 p-3 pb-2">
                                            <h5 class="text-primary-emphasis">Regular Customer</h5>
                                        </div>
                                        <div class="card-body p-3 pt-2">
                                            <div class="row">
                                                <div class="col-md-8 col-sm-8 col-8">
                                                    <p class="fw-bolder text-black">Count</p>
                                                </div>
                                                <div class="col-md-4 col-sm-4 col-4">
                                                    <?php
                                                        $stmt = $conn->prepare("SELECT COUNT(id) as totalRegularCustomer FROM `ca_customer` WHERE customer_type = 'Free' AND status = '1' ");
                                                        $stmt->execute();
                                                        $stmt->setFetchMode(PDO::FETCH_ASSOC);
                                                        if ($stmt->rowCount() > 0) {
                                                            foreach (($stmt->fetchAll()) as $key => $row) {
                                                                $totalRegularCustomer = $row['totalRegularCustomer'];
                                                                echo '<p class="text-end text-black">'.$totalRegularCustomer.'</p>';
                                                            }
                                                        } else {
                                                            echo '<p class="text-end text-black">0</p>';
                                                        }
                                                    ?>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6 col-sm-6 col-6">
                                                    <p class="fw-bolder text-black">Amount</p>
                                                </div>
                                                <div class="col-md-6 col-sm-6 col-6">
                                                    <p class="text-black text-end">Free</p>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-8 col-sm-8 col-8">
                                                    <p class="fw-bolder text-black">Complimentary</p>
                                                </div>
                                                <div class="col-md-4 col-sm-4 col-4">
                                                    <?php
                                                        $stmt = $conn->prepare("SELECT COUNT(id) as totalRegularCompCustomer FROM `ca_customer` WHERE customer_type = 'Free' AND comp_chek = '1' AND status = '1' ");
                                                        $stmt->execute();
                                                        $stmt->setFetchMode(PDO::FETCH_ASSOC);
                                                        if ($stmt->rowCount() > 0) {
                                                            foreach (($stmt->fetchAll()) as $key => $row) {
                                                                $totalRegularCompCustomer = $row['totalRegularCompCustomer'];
                                                                echo '<p class="text-end text-black">'.$totalRegularCompCustomer.'</p>';
                                                            }
                                                        } else {
                                                            echo '<p class="text-end text-black">0</p>';
                                                        }
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                    <div class="card rounded-4">
                                        <div class="bg-primary-subtle rounded-top-4 p-3 pb-2">
                                            <h5 class="text-primary-emphasis">Premium Customer</h5>
                                        </div>
                                        <div class="card-body p-3 pt-2">
                                            <div class="row">
                                                <div class="col-md-8 col-sm-8 col-8">
                                                    <p class="fw-bolder text-black">Count</p>
                                                </div>
                                                <div class="col-md-4 col-sm-4 col-4">
                                                    <?php
                                                        $stmt = $conn->prepare("SELECT COUNT(id) as totalPremiumCustomer FROM `ca_customer` WHERE customer_type = 'Premium' AND status = '1' ");
                                                        $stmt->execute();
                                                        $stmt->setFetchMode(PDO::FETCH_ASSOC);
                                                        if ($stmt->rowCount() > 0) {
                                                            foreach (($stmt->fetchAll()) as $key => $row) {
                                                                $totalPremiumCustomer = $row['totalPremiumCustomer'];
                                                                echo '<p class="text-end text-black">'.$totalPremiumCustomer.'</p>';
                                                            }
                                                        } else {
                                                            echo '<p class="text-end text-black">0</p>';
                                                        }
                                                    ?>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6 col-sm-6 col-6">
                                                    <p class="fw-bolder text-black">Amount</p>
                                                </div>
                                                <div class="col-md-6 col-sm-6 col-6">
                                                <?php
                                                    $Amt = 0;
                                                    $sqlCaAmt = "SELECT paid_amount FROM `ca_customer` WHERE customer_type = 'Premium' AND status = '1'";
                                                    $sqlTotalAmt = $conn->prepare($sqlCaAmt);
                                                    $sqlTotalAmt->execute();
                                                    $sqlTotalAmt->setFetchMode(PDO::FETCH_ASSOC);
                                                    if (($sqlTotalAmt->rowCount() > 0)) {
                                                        foreach ($sqlTotalAmt->fetchAll() as $key => $value) {
                                                            $totalAmt = $value['paid_amount'];

                                                            if ($totalAmt == 'null') {
                                                                $totalAmt = 0;
                                                            } else {
                                                                $totalAmt;
                                                            }

                                                            $Amt = $Amt + $totalAmt;
                                                        }
                                                    }
                                                    $Amt = preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $Amt);
                                                    echo '<p class="text-black text-end">'.$Amt.'</p>';
                                                    ?>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-8 col-sm-8 col-8">
                                                    <p class="fw-bolder text-black">Complimentary</p>
                                                </div>
                                                <div class="col-md-4 col-sm-4 col-4">
                                                    <?php
                                                        $stmt = $conn->prepare("SELECT COUNT(id) as totalPremiumCompCustomer FROM `ca_customer` WHERE customer_type = 'Premium' AND comp_chek = '1' AND status = '1' ");
                                                        $stmt->execute();
                                                        $stmt->setFetchMode(PDO::FETCH_ASSOC);
                                                        if ($stmt->rowCount() > 0) {
                                                            foreach (($stmt->fetchAll()) as $key => $row) {
                                                                $totalPremiumCompCustomer = $row['totalPremiumCompCustomer'];
                                                                echo '<p class="text-end text-black">'.$totalPremiumCompCustomer.'</p>';
                                                            }
                                                        } else {
                                                            echo '<p class="text-end text-black">0</p>';
                                                        }
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                    <div class="card rounded-4">
                                        <div class="bg-primary-subtle rounded-top-4 p-3 pb-2">
                                            <h5 class="text-primary-emphasis">Premium Plus Customer</h5>
                                        </div>
                                        <div class="card-body p-3 pt-2">
                                            <div class="row">
                                                <div class="col-md-8 col-sm-8 col-8">
                                                    <p class="fw-bolder text-black">Count</p>
                                                </div>
                                                <div class="col-md-4 col-sm-4 col-4">
                                                    <?php
                                                        $stmt = $conn->prepare("SELECT COUNT(id) as totalPremiumPlusCustomer FROM `ca_customer` WHERE customer_type = 'Premium Plus' AND status = '1' ");
                                                        $stmt->execute();
                                                        $stmt->setFetchMode(PDO::FETCH_ASSOC);
                                                        if ($stmt->rowCount() > 0) {
                                                            foreach (($stmt->fetchAll()) as $key => $row) {
                                                                $totalPremiumPlusCustomer = $row['totalPremiumPlusCustomer'];
                                                                echo '<p class="text-end text-black">'.$totalPremiumPlusCustomer.'</p>';
                                                            }
                                                        } else {
                                                            echo '<p class="text-end text-black">0</p>';
                                                        }
                                                    ?>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6 col-sm-6 col-6">
                                                    <p class="fw-bolder text-black">Amount</p>
                                                </div>
                                                <div class="col-md-6 col-sm-6 col-6">
                                                <?php
                                                    $Amt = 0;
                                                    $sqlCaAmt = "SELECT paid_amount FROM `ca_customer` WHERE customer_type = 'Premium Plus' AND status = '1'";
                                                    $sqlTotalAmt = $conn->prepare($sqlCaAmt);
                                                    $sqlTotalAmt->execute();
                                                    $sqlTotalAmt->setFetchMode(PDO::FETCH_ASSOC);
                                                    if (($sqlTotalAmt->rowCount() > 0)) {
                                                        foreach ($sqlTotalAmt->fetchAll() as $key => $value) {
                                                            $totalAmt = $value['paid_amount'];

                                                            if ($totalAmt == 'null') {
                                                                $totalAmt = 0;
                                                            } else {
                                                                $totalAmt;
                                                            }

                                                            $Amt = $Amt + $totalAmt;
                                                        }
                                                    }
                                                    $Amt = preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $Amt);
                                                    echo '<p class="text-black text-end">'.$Amt.'</p>';
                                                    ?>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-8 col-sm-8 col-8">
                                                    <p class="fw-bolder text-black">Complimentary</p>
                                                </div>
                                                <div class="col-md-4 col-sm-4 col-4">
                                                    <?php
                                                        $stmt = $conn->prepare("SELECT COUNT(id) as totalPremiumCompCustomer FROM `ca_customer` WHERE customer_type = 'Premium Plus' AND comp_chek = '1' AND status = '1' ");
                                                        $stmt->execute();
                                                        $stmt->setFetchMode(PDO::FETCH_ASSOC);
                                                        if ($stmt->rowCount() > 0) {
                                                            foreach (($stmt->fetchAll()) as $key => $row) {
                                                                $totalPremiumCompCustomer = $row['totalPremiumCompCustomer'];
                                                                echo '<p class="text-end text-black">'.$totalPremiumCompCustomer.'</p>';
                                                            }
                                                        } else {
                                                            echo '<p class="text-end text-black">0</p>';
                                                        }
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                    <div class="card rounded-4">
                                        <div class="bg-primary-subtle rounded-top-4 p-3 pb-2">
                                            <h5 class="text-primary-emphasis">Premium Select</h5>
                                        </div>
                                        <div class="card-body p-3 pt-2">
                                            <div class="row">
                                                <div class="col-md-8 col-sm-8 col-8">
                                                    <p class="fw-bolder text-black">Count</p>
                                                </div>
                                                <div class="col-md-4 col-sm-4 col-4">
                                                    <?php
                                                        $stmt = $conn->prepare("SELECT COUNT(id) as totalPremiumSelectCustomer FROM `ca_customer` WHERE customer_type = 'Premium Select' AND status = '1' ");
                                                        $stmt->execute();
                                                        $stmt->setFetchMode(PDO::FETCH_ASSOC);
                                                        if ($stmt->rowCount() > 0) {
                                                            foreach (($stmt->fetchAll()) as $key => $row) {
                                                                $totalPremiumSelectCustomer = $row['totalPremiumSelectCustomer'];
                                                                echo '<p class="text-end text-black">'.$totalPremiumSelectCustomer.'</p>';
                                                            }
                                                        } else {
                                                            echo '<p class="text-end text-black">0</p>';
                                                        }
                                                    ?>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6 col-sm-6 col-6">
                                                    <p class="fw-bolder text-black">Amount</p>
                                                </div>
                                                <div class="col-md-6 col-sm-6 col-6">
                                                    <?php
                                                    $Amt = 0;
                                                    $sqlCaAmt = "SELECT paid_amount FROM `ca_customer` WHERE customer_type = 'Premium Select' AND status = '1'";
                                                    $sqlTotalAmt = $conn->prepare($sqlCaAmt);
                                                    $sqlTotalAmt->execute();
                                                    $sqlTotalAmt->setFetchMode(PDO::FETCH_ASSOC);
                                                    if (($sqlTotalAmt->rowCount() > 0)) {
                                                        foreach ($sqlTotalAmt->fetchAll() as $key => $value) {
                                                            $totalAmt = $value['paid_amount'];

                                                            if ($totalAmt == 'null') {
                                                                $totalAmt = 0;
                                                            } else {
                                                                $totalAmt;
                                                            }

                                                            $Amt = $Amt + $totalAmt;
                                                        }
                                                    }
                                                    $Amt = preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $Amt);
                                                    echo '<p class="text-black text-end">'.$Amt.'</p>';
                                                    ?>
                                                    
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-8 col-sm-8 col-8">
                                                    <p class="fw-bolder text-black">Complimentary</p>
                                                </div>
                                                <div class="col-md-4 col-sm-4 col-4">
                                                    <?php
                                                        $stmt = $conn->prepare("SELECT COUNT(id) as totalPremiumSelectCompCustomer FROM `ca_customer` WHERE customer_type = 'Premium Select' AND comp_chek = '1' AND status = '1' ");
                                                        $stmt->execute();
                                                        $stmt->setFetchMode(PDO::FETCH_ASSOC);
                                                        if ($stmt->rowCount() > 0) {
                                                            foreach (($stmt->fetchAll()) as $key => $row) {
                                                                $totalPremiumSelectCompCustomer = $row['totalPremiumSelectCompCustomer'];
                                                                echo '<p class="text-end text-black">'.$totalPremiumSelectCompCustomer.'</p>';
                                                            }
                                                        } else {
                                                            echo '<p class="text-end text-black">0</p>';
                                                        }
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                    <div class="card rounded-4">
                                        <div class="bg-primary-subtle rounded-top-4 p-3 pb-2">
                                            <h5 class="text-primary-emphasis">Premium Select Lite</h5>
                                        </div>
                                        <div class="card-body p-3 pt-2">
                                            <div class="row">
                                                <div class="col-md-8 col-sm-8 col-8">
                                                    <p class="fw-bolder text-black">Count</p>
                                                </div>
                                                <div class="col-md-4 col-sm-4 col-4">
                                                    <?php
                                                        $stmt = $conn->prepare("SELECT COUNT(id) as totalPremiumSelectLiteCustomer FROM `ca_customer` WHERE customer_type = 'Premium Select Lite' AND status = '1' ");
                                                        $stmt->execute();
                                                        $stmt->setFetchMode(PDO::FETCH_ASSOC);
                                                        if ($stmt->rowCount() > 0) {
                                                            foreach (($stmt->fetchAll()) as $key => $row) {
                                                                $totalPremiumSelectLiteCustomer = $row['totalPremiumSelectLiteCustomer'];
                                                                echo '<p class="text-end text-black">'.$totalPremiumSelectLiteCustomer.'</p>';
                                                            }
                                                        } else {
                                                            echo '<p class="text-end text-black">0</p>';
                                                        }
                                                    ?>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6 col-sm-6 col-6">
                                                    <p class="fw-bolder text-black">Amount</p>
                                                </div>
                                                <div class="col-md-6 col-sm-6 col-6">
                                                    <?php
                                                    $Amt = 0;
                                                    $sqlCaAmt = "SELECT paid_amount FROM `ca_customer` WHERE customer_type = 'Premium Select Lite' AND status = '1'";
                                                    $sqlTotalAmt = $conn->prepare($sqlCaAmt);
                                                    $sqlTotalAmt->execute();
                                                    $sqlTotalAmt->setFetchMode(PDO::FETCH_ASSOC);
                                                    if (($sqlTotalAmt->rowCount() > 0)) {
                                                        foreach ($sqlTotalAmt->fetchAll() as $key => $value) {
                                                            $totalAmt = $value['paid_amount'];

                                                            if ($totalAmt == 'null') {
                                                                $totalAmt = 0;
                                                            } else {
                                                                $totalAmt;
                                                            }

                                                            $Amt = $Amt + $totalAmt;
                                                        }
                                                    }
                                                    $Amt = preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $Amt);
                                                    echo '<p class="text-black text-end">'.$Amt.'</p>';
                                                    ?>
                                                    
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-8 col-sm-8 col-8">
                                                    <p class="fw-bolder text-black">Complimentary</p>
                                                </div>
                                                <div class="col-md-4 col-sm-4 col-4">
                                                    <?php
                                                        $stmt = $conn->prepare("SELECT COUNT(id) as totalPremiumSelectLiteCompCustomer FROM `ca_customer` WHERE customer_type = 'Premium Select Lite' AND comp_chek = '1' AND status = '1' ");
                                                        $stmt->execute();
                                                        $stmt->setFetchMode(PDO::FETCH_ASSOC);
                                                        if ($stmt->rowCount() > 0) {
                                                            foreach (($stmt->fetchAll()) as $key => $row) {
                                                                $totalPremiumSelectLiteCompCustomer = $row['totalPremiumSelectLiteCompCustomer'];
                                                                echo '<p class="text-end text-black">'.$totalPremiumSelectLiteCompCustomer.'</p>';
                                                            }
                                                        } else {
                                                            echo '<p class="text-end text-black">0</p>';
                                                        }
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                    <div class="card rounded-4">
                                        <div class="bg-primary-subtle rounded-top-4 p-3 pb-2">
                                            <h5 class="text-primary-emphasis">Neo Select</h5>
                                        </div>
                                        <div class="card-body p-3 pt-2">
                                            <div class="row">
                                                <div class="col-md-8 col-sm-8 col-8">
                                                    <p class="fw-bolder text-black">Count</p>
                                                </div>
                                                <div class="col-md-4 col-sm-4 col-4">
                                                    <?php
                                                        $stmt = $conn->prepare("SELECT COUNT(id) as totalNeoSelectCustomer FROM `ca_customer` WHERE customer_type = 'Neo Select' AND status = '1' ");
                                                        $stmt->execute();
                                                        $stmt->setFetchMode(PDO::FETCH_ASSOC);
                                                        if ($stmt->rowCount() > 0) {
                                                            foreach (($stmt->fetchAll()) as $key => $row) {
                                                                $totalNeoSelectCustomer = $row['totalNeoSelectCustomer'];
                                                                echo '<p class="text-end text-black">'.$totalNeoSelectCustomer.'</p>';
                                                            }
                                                        } else {
                                                            echo '<p class="text-end text-black">0</p>';
                                                        }
                                                    ?>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6 col-sm-6 col-6">
                                                    <p class="fw-bolder text-black">Amount</p>
                                                </div>
                                                <div class="col-md-6 col-sm-6 col-6">
                                                    <?php
                                                    $Amt = 0;
                                                    $sqlCaAmt = "SELECT paid_amount FROM `ca_customer` WHERE customer_type = 'Neo Select' AND status = '1'";
                                                    $sqlTotalAmt = $conn->prepare($sqlCaAmt);
                                                    $sqlTotalAmt->execute();
                                                    $sqlTotalAmt->setFetchMode(PDO::FETCH_ASSOC);
                                                    if (($sqlTotalAmt->rowCount() > 0)) {
                                                        foreach ($sqlTotalAmt->fetchAll() as $key => $value) {
                                                            $totalAmt = $value['paid_amount'];

                                                            if ($totalAmt == 'null') {
                                                                $totalAmt = 0;
                                                            } else {
                                                                $totalAmt;
                                                            }

                                                            $Amt = $Amt + $totalAmt;
                                                        }
                                                    }
                                                    $Amt = preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $Amt);
                                                    echo '<p class="text-black text-end">'.$Amt.'</p>';
                                                    ?>
                                                    
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-8 col-sm-8 col-8">
                                                    <p class="fw-bolder text-black">Complimentary</p>
                                                </div>
                                                <div class="col-md-4 col-sm-4 col-4">
                                                    <?php
                                                        $stmt = $conn->prepare("SELECT COUNT(id) as totalNeoSelectCompCustomer FROM `ca_customer` WHERE customer_type = 'Neo Select' AND comp_chek = '1' AND status = '1' ");
                                                        $stmt->execute();
                                                        $stmt->setFetchMode(PDO::FETCH_ASSOC);
                                                        if ($stmt->rowCount() > 0) {
                                                            foreach (($stmt->fetchAll()) as $key => $row) {
                                                                $totalNeoSelectCompCustomer = $row['totalNeoSelectCompCustomer'];
                                                                echo '<p class="text-end text-black">'.$totalNeoSelectCompCustomer.'</p>';
                                                            }
                                                        } else {
                                                            echo '<p class="text-end text-black">0</p>';
                                                        }
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                    <div class="card rounded-4">
                                        <div class="bg-primary-subtle rounded-top-4 p-3 pb-2">
                                            <h5 class="text-primary-emphasis">Neo Select Ultra</h5>
                                        </div>
                                        <div class="card-body p-3 pt-2">
                                            <div class="row">
                                                <div class="col-md-8 col-sm-8 col-8">
                                                    <p class="fw-bolder text-black">Count</p>
                                                </div>
                                                <div class="col-md-4 col-sm-4 col-4">
                                                    <?php
                                                        $stmt = $conn->prepare("SELECT COUNT(id) as totalNeoSelectUltraCustomer FROM `ca_customer` WHERE customer_type = 'Neo Select Ultra' AND status = '1' ");
                                                        $stmt->execute();
                                                        $stmt->setFetchMode(PDO::FETCH_ASSOC);
                                                        if ($stmt->rowCount() > 0) {
                                                            foreach (($stmt->fetchAll()) as $key => $row) {
                                                                $totalNeoSelectUltraCustomer = $row['totalNeoSelectUltraCustomer'];
                                                                echo '<p class="text-end text-black">'.$totalNeoSelectUltraCustomer.'</p>';
                                                            }
                                                        } else {
                                                            echo '<p class="text-end text-black">0</p>';
                                                        }
                                                    ?>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6 col-sm-6 col-6">
                                                    <p class="fw-bolder text-black">Amount</p>
                                                </div>
                                                <div class="col-md-6 col-sm-6 col-6">
                                                    <?php
                                                    $Amt = 0;
                                                    $sqlCaAmt = "SELECT paid_amount FROM `ca_customer` WHERE customer_type = 'Neo Select Ultra' AND status = '1'";
                                                    $sqlTotalAmt = $conn->prepare($sqlCaAmt);
                                                    $sqlTotalAmt->execute();
                                                    $sqlTotalAmt->setFetchMode(PDO::FETCH_ASSOC);
                                                    if (($sqlTotalAmt->rowCount() > 0)) {
                                                        foreach ($sqlTotalAmt->fetchAll() as $key => $value) {
                                                            $totalAmt = $value['paid_amount'];

                                                            if ($totalAmt == 'null') {
                                                                $totalAmt = 0;
                                                            } else {
                                                                $totalAmt;
                                                            }

                                                            $Amt = $Amt + $totalAmt;
                                                        }
                                                    }
                                                    $Amt = preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $Amt);
                                                    echo '<p class="text-black text-end">'.$Amt.'</p>';
                                                    ?>
                                                    
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-8 col-sm-8 col-8">
                                                    <p class="fw-bolder text-black">Complimentary</p>
                                                </div>
                                                <div class="col-md-4 col-sm-4 col-4">
                                                    <?php
                                                        $stmt = $conn->prepare("SELECT COUNT(id) as totalNeoSelectUltraCompCustomer FROM `ca_customer` WHERE customer_type = 'Neo Select Ultra' AND comp_chek = '1' AND status = '1' ");
                                                        $stmt->execute();
                                                        $stmt->setFetchMode(PDO::FETCH_ASSOC);
                                                        if ($stmt->rowCount() > 0) {
                                                            foreach (($stmt->fetchAll()) as $key => $row) {
                                                                $totalNeoSelectUltraCompCustomer = $row['totalNeoSelectUltraCompCustomer'];
                                                                echo '<p class="text-end text-black">'.$totalNeoSelectUltraCompCustomer.'</p>';
                                                            }
                                                        } else {
                                                            echo '<p class="text-end text-black">0</p>';
                                                        }
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12 col-sm-12 mb-2">
                            <div class="card p-3 rounded-4">
                                <h4 class="card-title mb-3">Customer Membership Line Chart</h4>
                                <hr class="mb-5">
                                <div class="row">
                                    <div class="col-12">
                                        <div style="float:right; padding: 10px 10px 10px 10px; font-weight:bold; margin-top: -50px; ">
                                            <span>
                                                Select Year
                                                <select id="yearsCustMemb" onchange="getMonthlyUserDataCustMemb(this.value)"></select>
                                            </span>
                                        </div>
                                        <div class="table-responsive table-desi">
                                            <canvas id="myChartCust" style="width:100%; max-width:1000px"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6 col-md-12 col-sm-12 mb-2">
                            <div class="card p-3 rounded-4">
                                <h4 class="card-title mb-3">Line Chart</h4>
                                <hr class="mb-5">
                                <div class="row">
                                    <div class="col-12">
                                        <div style="float:right; padding: 10px 10px 10px 10px; font-weight:bold; margin-top: -50px; ">
                                            <span>
                                                Select Year
                                                <select id="years" onchange="getMonthlyUserData(this.value)"></select>
                                            </span>
                                        </div>
                                        <div class="table-responsive table-desi">
                                            <canvas id="myChart" style="width:100%; max-width:1000px"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6 col-md-12 col-sm-12 mb-2">
                            <div class="card p-3 rounded-4" id="ca_chart_box">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="tab-inn">
                                            <h4 class="card-title mb-4">Techno Enterprise</h4>
                                            <div class="table-responsive table-desi">
                                                <canvas id="myCAChart" class="myCAChart" height="115%" weight="115%"></canvas>
                                            </div>
                                            <div class="mt-4">
                                                <span class="ca_total_count" id="ca_total_count"></span>
                                                <span class="ca_total_price" id="ca_total_price"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card" id="ca_no_chart_box">
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
                        </div>
                    </div> 
                    <div class="row">
                        <div class="col-lg-6 col-md-12 col-sm-12 mb-2">
                            <!-- Chart Section  all commission -->
                            <div class="card p-3 rounded-4">
                                <div class="row">
                                    <!-- Type Selector -->
                                    <div class="col-md-4">
                                        <select id="dataTypeSelect" class="form-control">
                                            <option value="all" selected>All</option>
                                            <option value="tc">TC</option>
                                            <option value="te">TE</option>
                                            <option value="customer">Customer</option>
                                            <option value="bm">BM</option>
                                            <option value="sf">SF</option>
                                            <option value="mf">MF</option>
                                            <option value="f">F</option>
                                        </select>
                                    </div>
    
                                    <!-- Month-Year Selector -->
                                    <div class="col-md-4">
                                        <input type="month" id="monthSelector" class="form-control">
                                    </div>
    
                                    <!-- Download Button (initially hidden) -->
                                    <div class="col-md-4">
                                        <button id="downloadChartBtn" class="btn btn-primary w-100" onclick="downloadChartData()" style="display: none;">
                                            Download Data
                                        </button>
                                    </div>
                                    <!-- Chart Summary and Canvas -->
                                    <div class="col-md-12 mt-4 text-center" id="payout_chart_box">
                                        <h5 class="fw-bolder" id="ca_total_count1"></h5>
                                        <h6 class="fw-bolder" id="ca_total_price1"></h6>
                                        <canvas id="myCAChart1" height="115%" weight="115%"></canvas>
                                    </div>
                                </div>
                            </div>
    
                            <!-- No Data Message -->
                            <div class="card" id="payout_no_chart_box" style="display: none;">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="tab-inn text-center">
                                                <h3>No Data Found</h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12 col-sm-12 mb-2">
                            <!-- Chart Section customer membership-->
                            <div class="card p-3 rounded-4" >
                                <div class="row">
                                    <!-- Type Selector -->
                                    <div class="col-md-4">
                                        <select id="dataTypeSelect1" class="form-control">
                                            <option value="all" selected>All</option>
                                            <option value="Prime">Prime</option>
                                            <option value="Premium">Premium</option>
                                            <option value="Premium Plus">Premium Plus</option>
                                            <option value="Premium Select">Premium Select</option>
                                            <option value="Premium Select Lite">Premium Select Lite</option>
                                            <option value="Neo Select">Neo Select</option>
                                            <option value="Neo Select Ultra">Neo Select Ultra</option>
                                        </select>
                                    </div>
    
                                    <!-- Month-Year Selector -->
                                    <div class="col-md-4">
                                        <input type="month" id="monthSelector1" class="form-control">
                                    </div>
    
                                    <!-- Download Button (initially hidden) -->
                                    <div class="col-md-4">
                                        <button id="downloadChartBtn1" class="btn btn-primary w-100" onclick="downloadChartData1()" style="display: none;">
                                            Download Data
                                        </button>
                                    </div>
                                    <!-- Chart Summary and Canvas -->
                                    <div class="col-md-12 mt-4 text-center" id="ca_chart_box1">
                                        <h5 class="fw-bolder">Customer Membership</h5>
                                        <h6 class="fw-bolder mb-0" id="ca_total_count2"></h6>
                                        <h6 class="fw-bolder" id="ca_total_price2"></h6>
                                        <canvas id="myCAChart2" height="115%" weight="115%"></canvas>
                                    </div>
                                </div>
                            </div>
    
                            <!-- No Data Message -->
                            <div class="card" id="ca_no_chart_box1" style="display: none;">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="tab-inn text-center">
                                                <h3>No Data Found</h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card rounded-4">
                        <div class="row p-4 d-flex justify-content-around">
                            <div class="col-md-12 col-sm-12 col-12 d-grid align-items-center">
                                <div class="row">
                                    <div class="col-md-4 col-sm-6 col-12">
                                        <button onclick="showDivCount(1, this)" type="button" class="rounded-4 bg-primary-subtle btn fw-bolder fs-5 text-primary-emphasis py-4 w-100 text-center mb-2">
                                            Business Mentor<span id="bmCount" class="fs-2 ms-3"></span>
                                        </button>
                                    </div>
                                    <div class="col-md-4 col-sm-6 col-12">
                                        <button onclick="showDivCount(2, this)" type="button" class="rounded-4 bg-success-subtle btn fw-bolder fs-5 text-success-emphasis py-4 w-100 text-center mb-2">
                                            Employees<span id="empCount" class="fs-2 ms-3"></span>
                                        </button>
                                    </div>
                                    <div class="col-md-4 col-sm-6 col-12">
                                        <button onclick="showDivCount(3, this)" type="button" class="rounded-4 bg-warning-subtle btn fw-bolder fs-5 text-warning-emphasis py-4 w-100 text-center mb-2">
                                            Techno Enterprise<span id="teCount" class="fs-2 ms-3"></span>
                                        </button>
                                    </div>
                                    <div class="col-md-4 col-sm-6 col-12">
                                        <button onclick="showDivCount(4, this)" type="button" class="rounded-4 bg-danger-subtle btn fw-bolder fs-5 text-danger-emphasis py-4 w-100 text-center mb-2">
                                            Travel Consultant<span id="tcCount" class="fs-2 ms-3"></span>
                                        </button>
                                    </div>
                                    <div class="col-md-4 col-sm-6 col-12">
                                        <button onclick="showDivCount(5, this)" type="button" class="rounded-4 bg-info-subtle btn fw-bolder fs-5 text-info-emphasis py-4 w-100 text-center mb-2">
                                            Customer<span id="custCount" class="fs-2 ms-3"></span>
                                        </button>
                                    </div>
                                    <div class="col-md-4 col-sm-6 col-12">
                                        <button onclick="showDivCount(6, this)" type="button" class="rounded-4 bg-secondary-subtle btn fw-bolder fs-5 text-secondary-emphasis py-4 w-100 text-center mb-2">
                                            Master Franchise<span id="mfCount" class="fs-2 ms-3"></span>
                                        </button>
                                    </div>
                                    <div class="col-md-4 col-sm-6 col-12">
                                        <button onclick="showDivCount(7, this)" type="button" class="rounded-4 bg-info-subtle btn fw-bolder fs-5 text-info-emphasis py-4 w-100 text-center mb-2">
                                            Sponsor Franchise<span id="sfCount" class="fs-2 ms-3"></span>
                                        </button>
                                    </div>
                                    <div class="col-md-4 col-sm-6 col-12">
                                        <button onclick="showDivCount(8, this)" type="button" class="rounded-4 bg-info-subtle btn fw-bolder fs-5 text-info-emphasis py-4 w-100 text-center mb-2">
                                            Franchise<span id="fCount" class="fs-2 ms-3"></span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 col-sm-12 col-12">
                                <div class="text-end d-flex align-items-center justify-content-end pb-2">
                                    <span class="fs-6">
                                        <p class="fw-bolder text-dark">Select Month & Year</p>
                                        <input type="month" id="month_year_count" min="2020-01" max="" class="rounded-3" onchange="handleMonthClick()">
                                    </span>
                                </div>
                                <div class="card-body contentCountDiv rounded-4 border border-5 border-primary-subtle" id="count1" style="display: block;">
                                    <div class="card-title pb-2 d-flex justify-content-between ps-3 pe-3">
                                        <div class="heading">
                                            <h4>Monthly Business Mentor Details</h4>
                                        </div>
                                        
                                    </div>
                                    <hr>
                                    <div class="col-12 table-responsive text-center">
                                        <table class="table mb-0" id="datatable1">
                                            <thead class="bg-primary-subtle">
                                                <tr class="bg-primary-subtle">
                                                    <th>Sr.No</th>
                                                    <th>Name & Id</th>
                                                    <th>Refered By</th>
                                                    <th>Joining Date</th>
                                                </tr>
                                            </thead>
                                            <tbody id="bm_month_list">
                                                
                                            </tbody>
                                        </table>
                                    </div>

                                </div>
                                <div class="card-body contentCountDiv rounded-4 border border-5 border-success-subtle" id="count2">
                                    <div class="card-title pb-2 d-flex justify-content-between ps-3 pe-3">
                                        <div class="heading">
                                            <h4>Monthly Employees Details</h4>
                                        </div>
                                        
                                    </div>
                                    <hr>
                                    <div class="col-12 table-responsive text-center">
                                        <table class="table mb-0" id="datatable2">
                                            <thead class="bg-primary-subtle">
                                                <tr class="bg-primary-subtle">
                                                    <th>Sr.No</th>
                                                    <th>Name & Id</th>
                                                    <th>Refered By</th>
                                                    <th>Joining Date</th>
                                                </tr>
                                            </thead>
                                            <tbody id="emp_month_list">
                                                
                                            </tbody>
                                        </table>
                                    </div>

                                </div>
                                <div class="card-body contentCountDiv rounded-4 border border-5 border-warning-subtle" id="count3">
                                    <div class="card-title pb-2 d-flex justify-content-between ps-3 pe-3">
                                        <div class="heading">
                                            <h4>Monthly Techno Enterprise Details</h4>
                                        </div>
                                        
                                    </div>
                                    <hr>
                                    <div class="col-12 table-responsive text-center">
                                        <table class="table mb-0" id="datatable3">
                                            <thead class="bg-primary-subtle">
                                                <tr class="bg-primary-subtle">
                                                    <th>Sr.No</th>
                                                    <th>Name & Id</th>
                                                    <th>Refered By</th>
                                                    <th>Joining Date</th>
                                                </tr>
                                            </thead>
                                            <tbody id="te_monthly_list">
                                                
                                            </tbody>
                                        </table>
                                    </div>

                                </div>
                                <div class="card-body contentCountDiv rounded-4 border border-5 border-danger-subtle" id="count4">
                                    <div class="card-title pb-2 d-flex justify-content-between ps-3 pe-3">
                                        <div class="heading">
                                            <h4>Monthly Travel Consultant Details</h4>
                                        </div>
                                        
                                    </div>
                                    <hr>
                                    <div class="col-12 table-responsive text-center">
                                        <table class="table mb-0" id="datatable4">
                                            <thead class="bg-primary-subtle">
                                                <tr class="bg-primary-subtle">
                                                    <th>Sr.No</th>
                                                    <th>Name & Id</th>
                                                    <th>Refered By</th>
                                                    <th>Joining Date</th>
                                                </tr>
                                            </thead>
                                            <tbody id="tc_monthly_list">
                                                
                                            </tbody>
                                        </table>
                                    </div>

                                </div>
                                <div class="card-body contentCountDiv rounded-4 border border-5 border-info-subtle" id="count5">
                                    <div class="card-title pb-2 d-flex justify-content-between ps-3 pe-3">
                                        <div class="heading">
                                            <h4>Monthly Customer Details</h4>
                                        </div>
                                        
                                    </div>
                                    <hr>
                                    <div class="col-12 table-responsive text-center">
                                        <table class="table mb-0" id="datatable5">
                                            <thead class="bg-primary-subtle">
                                                <tr class="bg-primary-subtle">
                                                    <th>Sr.No</th>
                                                    <th>Name & Id</th>
                                                    <th>Refered By</th>
                                                    <th>Joining Date</th>
                                                </tr>
                                            </thead>
                                            <tbody id="cust_monthly_list">
                                                
                                            </tbody>
                                        </table>
                                    </div>

                                </div>
                                <div class="card-body contentCountDiv rounded-4 border border-5 border-secondary-subtle" id="count6">
                                    <div class="card-title pb-2 d-flex justify-content-between ps-3 pe-3">
                                        <div class="heading">
                                            <h4>Monthly Customer Details</h4>
                                        </div>
                                        
                                    </div>
                                    <hr>
                                    <div class="col-12 table-responsive text-center">
                                        <table class="table mb-0" id="datatable6">
                                            <thead class="bg-primary-subtle">
                                                <tr class="bg-primary-subtle">
                                                    <th>Sr.No</th>
                                                    <th>Name & Id</th>
                                                    <th>Refered By</th>
                                                    <th>Joining Date</th>
                                                </tr>
                                            </thead>
                                            <tbody id="mf_monthly_list">
                                                
                                            </tbody>
                                        </table>
                                    </div>

                                </div>
                                <div class="card-body contentCountDiv rounded-4 border border-5 border-info-subtle" id="count7">
                                    <div class="card-title pb-2 d-flex justify-content-between ps-3 pe-3">
                                        <div class="heading">
                                            <h4>Monthly Customer Details</h4>
                                        </div>
                                        
                                    </div>
                                    <hr>
                                    <div class="col-12 table-responsive text-center">
                                        <table class="table mb-0" id="datatable7">
                                            <thead class="bg-primary-subtle">
                                                <tr class="bg-primary-subtle">
                                                    <th>Sr.No</th>
                                                    <th>Name & Id</th>
                                                    <th>Refered By</th>
                                                    <th>Joining Date</th>
                                                </tr>
                                            </thead>
                                            <tbody id="sf_monthly_list">
                                                
                                            </tbody>
                                        </table>
                                    </div>

                                </div>
                                <div class="card-body contentCountDiv rounded-4 border border-5 border-info-subtle" id="count8">
                                    <div class="card-title pb-2 d-flex justify-content-between ps-3 pe-3">
                                        <div class="heading">
                                            <h4>Monthly Customer Details</h4>
                                        </div>
                                        
                                    </div>
                                    <hr>
                                    <div class="col-12 table-responsive text-center">
                                        <table class="table mb-0" id="datatable8">
                                            <thead class="bg-primary-subtle">
                                                <tr class="bg-primary-subtle">
                                                    <th>Sr.No</th>
                                                    <th>Name & Id</th>
                                                    <th>Refered By</th>
                                                    <th>Joining Date</th>
                                                </tr>
                                            </thead>
                                            <tbody id="f_monthly_list">
                                                
                                            </tbody>
                                        </table>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- monthly count of all -->
                    <!-- <div class="col-lg-5 col-md-12 col-sm-12"> -->
                        <!-- <div class="row">
                            <div class="col-12" style="padding: 30px; font-weight: 600;">
                                <span>
                                    Select Month & Year
                                    <input type="month" id="month_year" value="" min="2020-01" max="">
                                </span>
                            </div>
                        </div> -->

                        <!-- <div class="row card" style="width: 98%; height: auto; margin-left: 5px; ">
                            <div class="col-md-12 card-title count-col">
                                <div class="col-md-6 col-sm-6 col-6" style="padding-left: 20px;">
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
                                <div class="col-md-6 col-sm-6 col-6" style="padding-left: 20px;">
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
                                <div class="col-md-6 col-sm-6 col-6" style="padding-left: 20px;">
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
                                <div class="col-md-6 col-sm-6 col-6" style="padding-left: 20px;">
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
                                <div class="col-md-6 col-sm-6 col-6" style="padding-left: 20px;">
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
                                <div class="col-md-6 col-sm-6 col-6" style="padding-left: 20px;">
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
                                <div class="col-md-6 col-sm-6 col-6" style="padding-left: 20px;">
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
                                <div class="col-md-6 col-sm-6 col-6" style="padding-left: 20px;">
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
                                <div class="col-md-6 col-sm-6 col-6" style="padding-left: 20px;">
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
                            <div class="table-responsive table-desi">
                                table roe limit
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
                                pegination start
                                <div class="center text-center" id="pagination_row"></div>
                            </div>
                        </div>
                    </div> -->
                    <!-- end row -->

                    <!-- <div class="row"> -->
                        <!-- <div class="col-xl-6">
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
                        </div> end col -->
                        <!-- <div class="col-xl-6">
                            <div class="card rounded-4" id="ca_chart_box">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="tab-inn">
                                                <h6>Techno Enterprise</h6>
                                                <div class="table-responsive table-desi">
                                                    <canvas id="myCAChart1" class="myCAChart1" height="100px" weight="100px"></canvas>
                                                    <span class="ca_total_count" id="ca_total_count"></span>
                                                    <span class="ca_total_price" id="ca_total_price"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card" id="ca_no_chart_box">
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
                        <!-- </div> end col -->
                    <!-- </div> end row -->

                    <!-- Full Calender -->
                    <div class="row">
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
                                </div> <!-- end col -->

                                <!-- Latest Transaction -->
                                <div class="col-xl-4" id="latestTransaction">
                                    <div class="card rounded-4">
                                        <h2 class="fs-4 p-3">Latest Transaction</h2>
                                        <?php
                                        $sql1 = "SELECT corporate_agency_id as id, firstname, lastname, profile_pic, register_date as date, user_type, amount, payment_mode, status FROM corporate_agency UNION ALL 
                                                        SELECT ca_travelagency_id as id, firstname, lastname, profile_pic, register_date as date, user_type, amount, payment_mode, status FROM ca_travelagency UNION ALL 
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
                                                            <div class="card pt-3">
                                                                <div class="row">
                                                                    <div class="col-2 col-sm-1 col-md-1 col-lg-1 col-xl-2">
                                                                        <div class="profile-pic pb-1" style="position: relative; left: 15px;">
                                                                            <img src="' . $imgPath . '" alt="profile pic" class="rounded-circle" width="50px" height="50px">
                                                                        </div>
                                                                    </div>
                                                                    
                                                                    <div class="col-10 col-sm-11 col-md-11 col-lg-11 col-xl-10 d-flex justify-content-between align-items-center">
                                                                        <div class="name fw-bold">' . $row['id'] . ' ' . $row['firstname'] . ' ' . $row['lastname'] . ' <span class="fw-normal">(' . $designation . ')</span></div>
                                                                    </div>
                                                                    <div class="date text-end fs-6" style="position: absolute; top: 5px; right: 0px;">' . $rdate . '</div>
                                                                </div>
                                                                
                                                                <div class="para ps-3 pb-2">
                                                                    <p>Transfered <span class="amount">' . $CATAmt . '/-</span> to Bizzmirth Holiday Pvt.Ltd via <span class="payment-mode">' . $row['payment_mode'] . '</span>.</p>
                                                                </div>
                                                            </div>
                                                        ';
                                            }
                                        } else {
                                            echo '
                                                        <div><p>No Transaction Found</p></div>
                                                    ';
                                        }
                                        ?>

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
                                        <div class="col-md-6 col-sm-6 col-6 pb-3 ps-2">
                                            <!-- <button class="cpn_btn box-btn float-start" type="button" onclick="showUserBox1('latest_transaction');">View More</button> -->
                                            <a href="latest_transaction/latest_transaction.php"><button class="cpn_btn box-btn float-start">View More</button></a>
                                        </div>
                                    </div>

                                </div>
                            </div>
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
                            <div class="col-md-12 col-sm-12 col-12 d-grid align-items-center mb-3">
                                <div class="row">
                                    <div class="col-md-4 col-sm-6 col-12">
                                        <button onclick="showDiv(1, this)" type="button" class="rounded-4 bg-primary-subtle btn fw-bolder fs-5 text-primary-emphasis py-4 w-100 text-center mb-2">
                                            Top 5 BCH
                                        </button>
                                    </div>
                                    <div class="col-md-4 col-sm-6 col-12">
                                        <button onclick="showDiv(2, this)" type="button" class="rounded-4 bg-success-subtle btn fw-bolder fs-5 text-success-emphasis py-4 w-100 text-center mb-2">
                                            Top 5 BDM
                                        </button>
                                    </div>
                                    <div class="col-md-4 col-sm-6 col-12">
                                        <button onclick="showDiv(3, this)" type="button" class="rounded-4 bg-warning-subtle btn fw-bolder fs-5 text-warning-emphasis py-4 w-100 text-center mb-2">
                                            Top 5 BM
                                        </button>
                                    </div>
                                    <div class="col-md-4 col-sm-6 col-12">
                                        <button onclick="showDiv(4, this)" type="button" class="rounded-4 bg-danger-subtle btn fw-bolder fs-5 text-danger-emphasis py-4 w-100 text-center mb-2">
                                            Top 5 TE
                                        </button>
                                    </div>
                                    <div class="col-md-4 col-sm-6 col-12">
                                        <button onclick="showDiv(5, this)" type="button" class="rounded-4 bg-info-subtle btn fw-bolder fs-5 text-info-emphasis py-4 w-100 text-center mb-2">
                                            Top 5 TC
                                        </button>
                                    </div>
                                    <div class="col-md-4 col-sm-6 col-12">
                                        <button onclick="showDiv(6, this)" type="button" class="rounded-4 bg-secondary-subtle btn fw-bolder fs-5 text-secondary-emphasis py-4 w-100 text-center mb-2">
                                            Top 5 Customer
                                        </button>
                                    </div>
                                    <div class="col-md-4 col-sm-6 col-12">
                                        <button onclick="showDiv(7, this)" type="button" class="rounded-4 bg-secondary-subtle btn fw-bolder fs-5 text-secondary-emphasis py-4 w-100 text-center mb-2">
                                            Top 5 MF
                                        </button>
                                    </div>
                                    <div class="col-md-4 col-sm-6 col-12">
                                        <button onclick="showDiv(8, this)" type="button" class="rounded-4 bg-secondary-subtle btn fw-bolder fs-5 text-secondary-emphasis py-4 w-100 text-center mb-2">
                                            Top 5 SF
                                        </button>
                                    </div>
                                    <div class="col-md-4 col-sm-6 col-12">
                                        <button onclick="showDiv(9, this)" type="button" class="rounded-4 bg-secondary-subtle btn fw-bolder fs-5 text-secondary-emphasis py-4 w-100 text-center mb-2">
                                            Top 5 Franchisee
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 col-sm-12 col-12">
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
                                                                AND MONTH(e2.register_date) = '" . $Month . "' 
                                                                AND YEAR(e2.register_date) = '" . $Year . "'
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

                                                if ($sql1->rowCount() > 0) {
                                                    // Loop through the results and display the BCH user details
                                                    foreach ($sql1->fetchAll() as $bch_id) {
                                                        echo '<tr>
                                                                        <td>
                                                                            <div class="profile-pic pb-1">
                                                                                <img src="assets/images/topPerformer/' . $srNo . '.jpg" alt="profile pic" width="50px" height="50px" class="rounded-circle">
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <div class="profile-pic pb-1">
                                                                                <img src="../uploading/' . htmlspecialchars($bch_id['profile_pic']) . '" alt="profile pic" width="50px" height="50px" class="rounded-circle">
                                                                            </div>
                                                                        </td>
                                                                        <td class="align-content-center">
                                                                            <p class="fw-bold text-dark">' . htmlspecialchars($bch_id['BCH_user_name']) . '</p>
                                                                            <p class="text-dark">' . htmlspecialchars($bch_id['BCH_user_id']) . '</p> 
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
                                                            AND MONTH(e2.register_date) = '" . $Month . "' 
                                                            AND YEAR(e2.register_date) = '" . $Year . "' 
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

                                                        $sql2 = $conn->prepare("SELECT * FROM employees WHERE employee_id = '" . $bdm_id['reporting_manager'] . "'");
                                                        $sql2->execute();
                                                        $sql2->setFetchMode(PDO::FETCH_ASSOC);
                                                        $reporting_manager = $sql2->fetch();
                                                        $reporting_manager_name = $reporting_manager['name'];

                                                        echo '<tr>
                                                                        <td>
                                                                            <div class="profile-pic pb-1">
                                                                                <img src="assets/images/topPerformer/' . $srNo . '.jpg" alt="profile pic" width="50px" height="50px" class="rounded-circle">
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
                                                            AND MONTH(e2.register_date) = '" . $Month . "'
                                                            AND YEAR(e2.register_date) = '" . $Year . "' 
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
                                                                                <img src="assets/images/topPerformer/' . $srNo . '.jpg" alt="profile pic" width="50px" height="50px" class="rounded-circle">
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <div class="profile-pic pb-1">
                                                                                <img src="../uploading/' . htmlspecialchars($bm_id['profile_pic']) . '" alt="profile pic" width="50px" height="50px" class="rounded-circle">
                                                                            </div>
                                                                        </td>
                                                                        <td class="align-content-center">
                                                                            <p class="fw-bold text-dark"> ' . htmlspecialchars($bm_id['BM_user_fname'] . ' ' . $bm_id['BM_user_lname']) . ' </p>
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
                                                            AND MONTH(e2.register_date) = '" . $Month . "'
                                                            AND YEAR(e2.register_date) = '" . $Year . "' 
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
                                                                                <img src="assets/images/topPerformer/' . $srNo . '.jpg" alt="profile pic" width="50px" height="50px" class="rounded-circle">
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <div class="profile-pic pb-1">
                                                                                <img src="../uploading/' . htmlspecialchars($te_id['profile_pic']) . '" alt="profile pic" width="50px" height="50px" class="rounded-circle">
                                                                            </div>
                                                                        </td>
                                                                        <td class="align-content-center">
                                                                            <p class="fw-bold text-dark"> ' . htmlspecialchars($te_id['TE_user_fname'] . ' ' . $te_id['TE_user_lname']) . ' </p>
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
                                                            AND MONTH(e2.register_date) = '" . $Month . "'
                                                            AND YEAR(e2.register_date) = '" . $Year . "' 
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
                                                                                <img src="assets/images/topPerformer/' . $srNo . '.jpg" alt="profile pic" width="50px" height="50px" class="rounded-circle">
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <div class="profile-pic pb-1">
                                                                                <img src="../uploading/' . htmlspecialchars($ta_id['profile_pic']) . '" alt="profile pic" width="50px" height="50px" class="rounded-circle">
                                                                            </div>
                                                                        </td>
                                                                        <td class="align-content-center">
                                                                            <p class="fw-bold text-dark">' . htmlspecialchars($ta_id['TA_user_fname'] . ' ' . $ta_id['TA_user_lname']) . '</p>
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
                                                            AND MONTH(e2.register_date) = '" . $Month . "'
                                                            AND YEAR(e2.register_date) = '" . $Year . "' 
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
                                                                                <img src="assets/images/topPerformer/' . $srNo . '.jpg" alt="profile pic" width="50px" height="50px" class="rounded-circle">
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <div class="profile-pic pb-1">
                                                                                <img src="../uploading/' . htmlspecialchars($cu_id['profile_pic']) . '" alt="profile pic" width="50px" height="50px" class="rounded-circle">
                                                                            </div>
                                                                        </td>
                                                                        <td class="align-content-center">
                                                                            <p class="fw-bold text-dark"> ' . htmlspecialchars($cu_id['CU_user_fname'] . ' ' . $cu_id['CU_user_lname']) . ' </p>
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
                                <div class="card-body contentDiv rounded-4 border border-5 border-warning-subtle" id="div7">
                                    <div class="card-title pb-2 d-flex justify-content-between ps-3 pe-3">
                                        <div class="heading">
                                            <h4>Top 5 Performer MF</h4>
                                        </div>
                                        <div class="text-end d-flex align-items-center">
                                            <span class="fs-6">
                                                <p>Select Month & Year</p>
                                                <input type="month" id="month_year_MF" value="" min="2020-01" max="">
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
                                            <tbody id="mf_top_performer">
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
                                                            AND MONTH(e2.register_date) = '" . $Month . "'
                                                            AND YEAR(e2.register_date) = '" . $Year . "' 
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
                                                                                <img src="assets/images/topPerformer/' . $srNo . '.jpg" alt="profile pic" width="50px" height="50px" class="rounded-circle">
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <div class="profile-pic pb-1">
                                                                                <img src="../uploading/' . htmlspecialchars($bm_id['profile_pic']) . '" alt="profile pic" width="50px" height="50px" class="rounded-circle">
                                                                            </div>
                                                                        </td>
                                                                        <td class="align-content-center">
                                                                            <p class="fw-bold text-dark"> ' . htmlspecialchars($bm_id['BM_user_fname'] . ' ' . $bm_id['BM_user_lname']) . ' </p>
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
                                                <a class="dropdown-item" href="employee/employee.php">View</a>
                                                <a class="dropdown-item" href="employee/addEmployee.php">Add New</a>
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
                                                $stmt1 = $conn->prepare($sql1);
                                                $stmt1->execute();
                                                $stmt1->setFetchMode(PDO::FETCH_ASSOC);
                                                if ($stmt1->rowCount() > 0) {
                                                    foreach (($stmt1->fetchAll()) as $key => $row) {
                                                        echo '<tr>
                                                                    <td>' . $row['employee_id'] . '</td>
                                                                    <td>' . $row['name'] . '</td>';
                                                        if ($row['status'] == '1') {
                                                            echo '<td><span class="badge badge-pill badge-soft-success font-size-12">Active</span></td>';
                                                        } else {
                                                            echo '<td><span class="badge badge-pill badge-soft-danger font-size-12">Removed</span></td>';
                                                        }
                                                        echo '</tr>';
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
                                                <a class="dropdown-item" href="businessMentor/businessMentor.php">View</a>
                                                <a class="dropdown-item" href="businessMentor/addBusinessMentor.php">Add New</a>
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
                                                $sql1 = "SELECT business_mentor_id as id, firstname, lastname, status FROM business_mentor 
                                                                 WHERE (status='1' or status='0' or status='3') and id != '' order by id desc limit 6";
                                                $stmt1 = $conn->prepare($sql1);
                                                $stmt1->execute();
                                                $stmt1->setFetchMode(PDO::FETCH_ASSOC);
                                                if ($stmt1->rowCount() > 0) {
                                                    foreach (($stmt1->fetchAll()) as $key => $row) {
                                                        echo '<tr>
                                                                    <td>' . $row['id'] . '</td>
                                                                    <td>' . $row['firstname'] . ' ' . $row['lastname'] . '</td>';
                                                        if ($row['status'] == '1') {
                                                            echo '<td><span class="badge badge-pill badge-soft-success font-size-12">Active</span></td>';
                                                        } else {
                                                            echo '<td><span class="badge badge-pill badge-soft-danger font-size-12">Removed</span></td>';
                                                        }
                                                        echo '</tr>';
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
                                            <h4>Master Franchisee</h4>
                                        </div>
                                        <div class="dropdown">
                                            <a class="" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false"><i class="mdi mdi-dots-vertical-circle-outline mdi-24px" style="color: grey;"></i></a>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                <a class="dropdown-item" href="businessMentor/businessMentor.php">View</a>
                                                <a class="dropdown-item" href="businessMentor/addBusinessMentor.php">Add New</a>
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
                                                $sql1 = "SELECT master_franchisee_id as id, firstname, lastname, status FROM master_franchisee 
                                                                 WHERE (status='1' or status='0' or status='3') and id != '' order by id desc limit 6";
                                                $stmt1 = $conn->prepare($sql1);
                                                $stmt1->execute();
                                                $stmt1->setFetchMode(PDO::FETCH_ASSOC);
                                                if ($stmt1->rowCount() > 0) {
                                                    foreach (($stmt1->fetchAll()) as $key => $row) {
                                                        echo '<tr>
                                                                    <td>' . $row['id'] . '</td>
                                                                    <td>' . $row['firstname'] . ' ' . $row['lastname'] . '</td>';
                                                        if ($row['status'] == '1') {
                                                            echo '<td><span class="badge badge-pill badge-soft-success font-size-12">Active</span></td>';
                                                        } else {
                                                            echo '<td><span class="badge badge-pill badge-soft-danger font-size-12">Removed</span></td>';
                                                        }
                                                        echo '</tr>';
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
                                            <h4>Sponsor Franchisee</h4>
                                        </div>
                                        <div class="dropdown">
                                            <a class="" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false"><i class="mdi mdi-dots-vertical-circle-outline mdi-24px" style="color: grey;"></i></a>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                <a class="dropdown-item" href="businessMentor/businessMentor.php">View</a>
                                                <a class="dropdown-item" href="businessMentor/addBusinessMentor.php">Add New</a>
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
                                                $sql1 = "SELECT sponsor_franchisee_id as id, firstname, lastname, status FROM sponsor_franchisee 
                                                                 WHERE (status='1' or status='0' or status='3') and id != '' order by id desc limit 6";
                                                $stmt1 = $conn->prepare($sql1);
                                                $stmt1->execute();
                                                $stmt1->setFetchMode(PDO::FETCH_ASSOC);
                                                if ($stmt1->rowCount() > 0) {
                                                    foreach (($stmt1->fetchAll()) as $key => $row) {
                                                        echo '<tr>
                                                                    <td>' . $row['id'] . '</td>
                                                                    <td>' . $row['firstname'] . ' ' . $row['lastname'] . '</td>';
                                                        if ($row['status'] == '1') {
                                                            echo '<td><span class="badge badge-pill badge-soft-success font-size-12">Active</span></td>';
                                                        } else {
                                                            echo '<td><span class="badge badge-pill badge-soft-danger font-size-12">Removed</span></td>';
                                                        }
                                                        echo '</tr>';
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
                                                $stmt1 = $conn->prepare($sql1);
                                                $stmt1->execute();
                                                $stmt1->setFetchMode(PDO::FETCH_ASSOC);
                                                if ($stmt1->rowCount() > 0) {
                                                    foreach (($stmt1->fetchAll()) as $key => $row) {
                                                        echo '<tr>
                                                                    <td>' . $row['business_trainee_id'] . '</td>
                                                                    <td>' . $row['firstname'] . ' ' . $row['lastname'] . '</td>';
                                                        if ($row['status'] == '1') {
                                                            echo '<td><span class="badge badge-pill badge-soft-success font-size-12">Active</span></td>';
                                                        } else {
                                                            echo '<td><span class="badge badge-pill badge-soft-danger font-size-12">Removed</span></td>';
                                                        }
                                                        echo '</tr>';
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
                                                $stmt1 = $conn->prepare($sql1);
                                                $stmt1->execute();
                                                $stmt1->setFetchMode(PDO::FETCH_ASSOC);
                                                if ($stmt1->rowCount() > 0) {
                                                    foreach (($stmt1->fetchAll()) as $key => $row) {
                                                        echo '<tr>
                                                                    <td>' . $row['business_consultant_id'] . '</td>
                                                                    <td>' . $row['firstname'] . ' ' . $row['lastname'] . '</td>';
                                                        if ($row['status'] == '1') {
                                                            echo '<td><span class="badge badge-pill badge-soft-success font-size-12">Active</span></td>';
                                                        } else {
                                                            echo '<td><span class="badge badge-pill badge-soft-danger font-size-12">Removed</span></td>';
                                                        }
                                                        echo '</tr>';
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
                                                $stmt1 = $conn->prepare($sql1);
                                                $stmt1->execute();
                                                $stmt1->setFetchMode(PDO::FETCH_ASSOC);
                                                if ($stmt1->rowCount() > 0) {
                                                    foreach (($stmt1->fetchAll()) as $key => $row) {
                                                        echo '<tr>
                                                                    <td>' . $row['corporate_agency_id'] . '</td>
                                                                    <td>' . $row['firstname'] . ' ' . $row['lastname'] . '</td>';
                                                        if ($row['status'] == '1') {
                                                            echo '<td><span class="badge badge-pill badge-soft-success font-size-12">Active</span></td>';
                                                        } else {
                                                            echo '<td><span class="badge badge-pill badge-soft-danger font-size-12">Removed</span></td>';
                                                        }
                                                        echo '</tr>';
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
                                            <h4>Franchisee</h4>
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
                                                $sql1 = "SELECT * FROM sub_franchisee where user_type='29' and (status='1' or status='0' or status='3') and sub_franchisee_id != '' order by sub_franchisee_id desc limit 6";
                                                $stmt1 = $conn->prepare($sql1);
                                                $stmt1->execute();
                                                $stmt1->setFetchMode(PDO::FETCH_ASSOC);
                                                if ($stmt1->rowCount() > 0) {
                                                    foreach (($stmt1->fetchAll()) as $key => $row) {
                                                        echo '<tr>
                                                                    <td>' . $row['sub_franchisee_id'] . '</td>
                                                                    <td>' . $row['firstname'] . ' ' . $row['lastname'] . '</td>';
                                                        if ($row['status'] == '1') {
                                                            echo '<td><span class="badge badge-pill badge-soft-success font-size-12">Active</span></td>';
                                                        } else {
                                                            echo '<td><span class="badge badge-pill badge-soft-danger font-size-12">Removed</span></td>';
                                                        }
                                                        echo '</tr>';
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
                                                $stmt1 = $conn->prepare($sql1);
                                                $stmt1->execute();
                                                $stmt1->setFetchMode(PDO::FETCH_ASSOC);
                                                if ($stmt1->rowCount() > 0) {
                                                    foreach (($stmt1->fetchAll()) as $key => $row) {
                                                        echo '<tr>
                                                                    <td>' . $row['ca_travelagency_id'] . '</td>
                                                                    <td>' . $row['firstname'] . ' ' . $row['lastname'] . '</td>';
                                                        if ($row['status'] == '1') {
                                                            echo '<td><span class="badge badge-pill badge-soft-success font-size-12">Active</span></td>';
                                                        } else {
                                                            echo '<td><span class="badge badge-pill badge-soft-danger font-size-12">Removed</span></td>';
                                                        }
                                                        echo '</tr>';
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
                                                $stmt1 = $conn->prepare($sql1);
                                                $stmt1->execute();
                                                $stmt1->setFetchMode(PDO::FETCH_ASSOC);
                                                if ($stmt1->rowCount() > 0) {
                                                    foreach (($stmt1->fetchAll()) as $key => $row) {
                                                        echo '<tr>
                                                                    <td>' . $row['ca_customer_id'] . '</td>
                                                                    <td>' . $row['firstname'] . ' ' . $row['lastname'] . '</td>';
                                                        if ($row['status'] == '1') {
                                                            echo '<td><span class="badge badge-pill badge-soft-success font-size-12">Active</span></td>';
                                                        } else {
                                                            echo '<td><span class="badge badge-pill badge-soft-danger font-size-12">Removed</span></td>';
                                                        }
                                                        echo '</tr>';
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
       <!-- Required datatable js -->
    <script src="assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>

    <!-- Responsive examples -->
    <script src="assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>

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
        });
    </script>
    <script>
        const currentDate = new Date();
        var getCurrentYear = currentDate.getFullYear();
        var getCurrentMonth = currentDate.getMonth() + 1;
        var userType, monthYear;
        // get month for input tag
        var monthControl = "2020";

        $(function() {
            // get min and max month for input tag
            const date = new Date()
            const month = ("0" + (date.getMonth() + 1)).slice(-2)
            const year = date.getFullYear()
            monthControl.value = `${year}-${month}`;
            // console.log(monthControl.value);

            // Set Default value for years for line chart
            for (let index = 2020; index <= getCurrentYear; index++) {
                if (index == getCurrentYear) {
                    $("#years").append('<option selected="selected" value="' + index + '">' + index + '</option>');
                    $("#yearsCustMemb").append('<option selected="selected" value="' + index + '">' + index + '</option>');
                    $("#consultant_years").append('<option selected="selected" value="' + index + '">' + index + '</option>');
                    $("#partner_years").append('<option selected="selected" value="' + index + '">' + index + '</option>');
                } else {
                    $("#years").append('<option value="' + index + '">' + index + '</option>');
                    $("#yearsCustMemb").append('<option value="' + index + '">' + index + '</option>');
                    $("#consultant_years").append('<option value="' + index + '">' + index + '</option>');
                    $("#partner_years").append('<option value="' + index + '">' + index + '</option>');
                }
            }
            
            // get chart data
            getMonthlyUserData(getCurrentYear);
            // get chart data Customer Membership
            getMonthlyUserDataCustMemb(getCurrentYear);
            // getBIPData(); //BIP pie chart
            getCAData(); //ca Amount Pie Chart
            //getCAData(); //ca Amount Pie Chart
            // get monthly user count
            monthYear = monthControl.value;
            // monthlyUserCount();
            // get birthday table
            // getBirthdayData('customer');

            // console.log('test 22');
        });
        //line chart for all user, excuding Customer 
        async function getMonthlyUserData(get_year) {
            let option = {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json;charset=utf-8'
                },
                body: JSON.stringify({
                    year: get_year,
                    current_year: getCurrentYear,
                    current_month: getCurrentMonth,
                    user_id: 0,
                    user_type: 0
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
            var xValues = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
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
                    legend: {
                        display: true
                    },
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

        //line chart for customer membership
        async function getMonthlyUserDataCustMemb(get_year) {
            let option = {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json;charset=utf-8'
                },
                body: JSON.stringify({
                    year: get_year,
                    current_year: getCurrentYear,
                    current_month: getCurrentMonth,
                    user_id: 0,
                    user_type: 0
                })
            }
            const response = await fetch('charts/monthly_customer_membership_count.php', option);
            const data = await response.json();
            // console.log(data);
            length = data[0].length;
            labels = [];
            values_custF = [];
            // values_custPR = [];
            values_custP = [];
            values_custPP = [];
            values_custPS = [];
            values_custPSL = [];
            values_custNS = [];
            values_custNSU = [];
            // values_cacu = [];
            // values_cbd = [];
            // values_emp = [];
            // values_bm = [];

            for (i = 0; i < length; i++) {
                values_custF.push(data[0][i]);
                // values_custPR.push(data[1][i]);
                values_custP.push(data[2][i]);
                values_custPP.push(data[3][i]);
                values_custPS.push(data[4][i]);
                values_custPSL.push(data[5][i]);
                values_custNS.push(data[6][i]);
                values_custNSU.push(data[7][i]);
                // values_cacu.push(data[7][i]);
                // values_cbd.push(data[8][i]);
                // values_emp.push(data[9][i]);
                // values_bm.push(data[10][i]);
            }
            var xValues = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
            new Chart(document.getElementById("myChartCust"), {
                type: 'line',
                data: {
                    labels: xValues,
                    datasets: [
                        {
                            label: "Regular",
                            data: values_custF,
                            borderColor: "green",
                            fill: true
                        },
                        // {
                        //     label: "Prime",
                        //     data: values_custPR,
                        //     borderColor: "yellow",
                        //     fill: true
                        // },
                        {
                            label: "Premium",
                            data: values_custP,
                            borderColor: "red",
                            fill: true
                        },
                        {
                            label: "Premium Plus",
                            data: values_custPP,
                            borderColor: "purple",
                            fill: true
                        },
                        {
                            label: "Premium Select",
                            data: values_custPS,
                            borderColor: "blue",
                            fill: true
                        },
                        {
                            label: "Premium Select Lite",
                            data: values_custPSL,
                            borderColor: "orange",
                            fill: true
                        },
                        {
                            label: "Neo Select",
                            data: values_custNS,
                            borderColor: "gray",
                            fill: true
                        },
                        {
                            label: "Neo Select Ultra",
                            data: values_custNSU,
                            borderColor: "black",
                            fill: true
                        },
                        // {
                        //     label: "Travel Consultant",
                        //     data: values_cata,
                        //     borderColor: "pink",
                        //     fill: true
                        // },
                        // {
                        //     label: "Customer",
                        //     data: values_cacu,
                        //     borderColor: "red",
                        //     fill: true
                        // }
                    ]
                },
                options: {
                    legend: {
                        display: true
                    },
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

        //TE pie chart
        async function getCAData() {
            const response = await fetch('charts/ca_payout.php');
            const data = await response.json();

            // console.log(data);

            var xValues = ["2 Lakhs", "3 Lakhs", "5 Lakhs"];
            var yValues = [data[4], data[3], data[2]];
            var total = data[1];
            var totalCA = data[0];
            var barColors = [
                "#ad2321",
                "#3EB07E",
                "#2e51f0"
            ];

            document.getElementById("ca_total_count").innerText = "Total TE = " + totalCA + "\n";
            document.getElementById("ca_total_price").innerText = " Total Amount = ₹ " + total + "/-";

            if (totalCA == 0) {
                document.getElementById("ca_no_chart_box").style.display = "block";
                document.getElementById("ca_chart_box").style.display = "none";
            } else {
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
        //  all employees payout
        let currentChart = null;
        let chartDataCache = {};

        async function fetchData() {
            const type = document.getElementById("dataTypeSelect").value;
            const monthInput = document.getElementById("monthSelector").value;
            const [year, month] = monthInput ? monthInput.split("-") : ["", ""];

            const formData = new FormData();
            formData.append("type", type);
            formData.append("month", month);
            formData.append("year", year);

            const res = await fetch("charts/all_user_payout.php", {

                method: "POST",
                body: formData
            });
            const data = await res.json();
            chartDataCache = data;
            renderChart(type,year, month);
        }

        function renderChart(type, month, year) {
            let label = '', total = 0, paid = 0, pending = 0;

            const dataMap = {
                te: {
                    count: chartDataCache.total_te || 0,
                    paid: chartDataCache.total_te_amount || 0,
                    pending: chartDataCache.total_te_pending || 0,
                    label: 'TE'
                },
                f: {
                    count: chartDataCache.total_f || 0,
                    paid: chartDataCache.total_f_amount || 0,
                    pending: chartDataCache.total_f_pending || 0,
                    label: 'F'
                },
                tc: {
                    count: chartDataCache.total_tc || 0,
                    paid: chartDataCache.total_tc_paid || 0,
                    pending: chartDataCache.total_tc_pending || 0,
                    label: 'TC'
                },
                customer: {
                    count: chartDataCache.total_customer || 0,
                    paid: chartDataCache.total_customer_paid || 0,
                    pending: chartDataCache.total_customer_pending || 0,
                    label: 'Customer'
                },
                bm: {
                    count: chartDataCache.total_bm || 0,
                    paid: chartDataCache.total_bm_paid || 0,
                    pending: chartDataCache.total_bm_pending || 0,
                    label: 'BM'
                },
                mf: {
                    count: chartDataCache.total_mf || 0,
                    paid: chartDataCache.total_mf_paid || 0,
                    pending: chartDataCache.total_mf_pending || 0,
                    label: 'MF'
                },
                sf: {
                    count: chartDataCache.total_sf || 0,
                    paid: chartDataCache.total_sf_paid || 0,
                    pending: chartDataCache.total_sf_pending || 0,
                    label: 'SF'
                }
            };

            let downloadBtn = document.getElementById("downloadChartBtn");
            console.log('type:'+type+'month-year:'+month+'-'+year);
            
            if (type !== 'all' && month && year) {
                downloadBtn.style.display = 'inline-block';
            } else {
                downloadBtn.style.display = 'none';
            }

            if (type === 'all') {
                const totalAmount = Object.values(dataMap).reduce((sum, d) => sum + d.paid, 0);
                if (totalAmount === 0) {
                    document.getElementById("payout_chart_box").style.display = "none";
                    document.getElementById("payout_no_chart_box").style.display = "block";
                    return;
                }

                document.getElementById("payout_chart_box").style.display = "block";
                document.getElementById("payout_no_chart_box").style.display = "none";

                const labels = [];
                const data = [];
                const bgColors = ["#007bff", "#28a745", "#ffc107", "#dc3545","#aaa045", "#cccd07", "#defc45"];
                let displayText = '';

                for (const key in dataMap) {
                    const d = dataMap[key];
                    const total = (d.paid || 0) + (d.pending || 0);
                    if (total > 0) {
                        labels.push(`${d.label}: ${d.count}`);
                        data.push(total);
                        displayText += `${d.label}: ${d.count} (₹${total.toLocaleString()})\n`;
                    }
                }

                document.getElementById("ca_total_count1").innerText = "Payout";
                document.getElementById("ca_total_price1").innerText = displayText.trim();

                if (currentChart) currentChart.destroy();

                currentChart = new Chart(document.getElementById("myCAChart1"), {
                    type: "pie",
                    data: {
                        labels: labels,
                        datasets: [{
                            backgroundColor: bgColors,
                            data: data
                        }]
                    },
                    options: {
                        title: { display: false }
                    }
                });

            } else {
                const selected = dataMap[type];
                total = selected.count;
                paid = selected.paid;
                pending = selected.pending;
                label = selected.label;

                if (total === 0 && paid === 0 && pending === 0) {
                    document.getElementById("payout_chart_box").style.display = "none";
                    document.getElementById("payout_no_chart_box").style.display = "block";
                    return;
                }

                document.getElementById("payout_chart_box").style.display = "block";
                document.getElementById("payout_no_chart_box").style.display = "none";

                document.getElementById("ca_total_count1").innerText = `Total ${label}: ${total}`;
                document.getElementById("ca_total_price1").innerText = `Paid: ₹${paid.toLocaleString()}\nPending: ₹${pending.toLocaleString()}`;

                if (currentChart) currentChart.destroy();

                currentChart = new Chart(document.getElementById("myCAChart1"), {
                    type: "pie",
                    data: {
                        labels: ["Paid", "Pending"],
                        datasets: [{
                            backgroundColor: ["#ad2321", "#3EB07E"],
                            data: [paid, pending]
                        }]
                    },
                    options: {
                        title: { display: false }
                    }
                });
            }
        }
        
        function downloadChartData() {
            const type = document.getElementById("dataTypeSelect").value; // TE / BM / Customer
            const monthInput = document.getElementById("monthSelector").value;
            const [year, month] = monthInput ? monthInput.split("-") : ["", ""];

            const formData = new FormData();
            formData.append("type", type);
            if (month && year) {
                formData.append("month", month);
                formData.append("year", year);
            }

            fetch("cahrts/download_chart_data.php", {
                method: "POST",
                body: formData
            })
            .then(response => {
                if (!response.ok) throw new Error("Failed to generate file");
                return response.blob();
            })
            .then(blob => {
                const url = window.URL.createObjectURL(blob);
                const a = document.createElement("a");
                a.href = url;
                a.download = `${type}_payout_data.csv`;
                document.body.appendChild(a);
                a.click();
                a.remove();
            })
            .catch(error => {
                alert("Error downloading file: " + error.message);
            });
        }

        // Event listeners
        document.getElementById("dataTypeSelect").addEventListener("change", () => {
            const type = document.getElementById("dataTypeSelect").value;
            const [month, year] = document.getElementById("monthSelector").value.split("-");
            fetchData(type, month || '', year || '');
        });

        document.getElementById("monthSelector").addEventListener("change", () => {
            const type = document.getElementById("dataTypeSelect").value;
            const [month, year] = document.getElementById("monthSelector").value.split("-");
            fetchData(type, month || '', year || '');
        });

         // Initial load
        fetchData();

        // for customer member ship
        let currentChart1 = null;
        let chartDataCache1 = {};

        async function fetchData1() {
            const type = document.getElementById("dataTypeSelect1").value;
            const monthInput = document.getElementById("monthSelector1").value;
            const [year, month] = monthInput ? monthInput.split("-") : ["", ""];

            const formData = new FormData();
            formData.append("type", type);
            formData.append("month", month);
            formData.append("year", year);

            const res = await fetch("charts/cust_membership_payout.php", {

                method: "POST",
                body: formData
            });
            const data = await res.json();
            chartDataCache1 = data;
            renderChart1(type,year, month);
        }

        function renderChart1(type, year, month) {
            let label = '', total = 0;
            let complementary = 0, nonComplementary = 0;

            // These will come from the updated PHP response
            complementary = chartDataCache1.complementary_paid || 0;
            nonComplementary = chartDataCache1.non_complementary_paid || 0;
            total = complementary + nonComplementary;
            label = type !== "all" ? type : "Customer";

            let downloadBtn = document.getElementById("downloadChartBtn1");
            if (month && year) {
                downloadBtn.style.display = 'inline-block';
            } 

            if (total === 0) {
                document.getElementById("ca_chart_box1").style.display = "none";
                document.getElementById("ca_no_chart_box1").style.display = "block";
                return;
            }

            document.getElementById("ca_chart_box1").style.display = "block";
            document.getElementById("ca_no_chart_box1").style.display = "none";

            document.getElementById("ca_total_count2").innerText = `Total ${label} Paid: ₹${total.toLocaleString()}`;
            document.getElementById("ca_total_price2").innerText = `Complementary: ₹${complementary.toLocaleString()}\nNon-Complementary: ₹${nonComplementary.toLocaleString()}`;

            if (currentChart1) currentChart1.destroy();

            currentChart1 = new Chart(document.getElementById("myCAChart2"), {
                type: "pie",
                data: {
                    labels: ["Complementary", "Non-Complementary"],
                    datasets: [{
                        backgroundColor: ["#3EB07E", "#ad2321"],
                        data: [complementary, nonComplementary]
                    }]
                },
                options: {
                    title: { display: false }
                }
            });
        }


        function downloadChartData1() {
            const type = document.getElementById("dataTypeSelect1").value; // TE / BM / Customer
            const monthInput = document.getElementById("monthSelector1").value;
            const [year, month] = monthInput ? monthInput.split("-") : ["", ""];

            const formData = new FormData();
            formData.append("type", type);
            if (month && year) {
                formData.append("month", month);
                formData.append("year", year);
            }

            fetch("charts/download_chart_data_cust_membership.php", {
                method: "POST",
                body: formData
            })
            .then(response => {
                if (!response.ok) throw new Error("Failed to generate file");
                return response.blob();
            })
            .then(blob => {
                const url = window.URL.createObjectURL(blob);
                const a = document.createElement("a");
                a.href = url;
                a.download = `${type}_payout_data.csv`;
                document.body.appendChild(a);
                a.click();
                a.remove();
            })
            .catch(error => {
                alert("Error downloading file: " + error.message);
            });
        }
        // Event listeners for customer member ship
        document.getElementById("dataTypeSelect1").addEventListener("change", () => {
            const type = document.getElementById("dataTypeSelect1").value;
            const [month, year] = document.getElementById("monthSelector1").value.split("-");
            fetchData1(type, month || '', year || '');
        });

        document.getElementById("monthSelector1").addEventListener("change", () => {
            const type = document.getElementById("dataTypeSelect1").value;
            const [month, year] = document.getElementById("monthSelector1").value.split("-");
            fetchData1(type, month || '', year || '');
        });

       
        // for customer member ship
        fetchData1();

        //CP Chart
        // async function getCPData() {
        //     const response = await fetch('charts/cp_payout.php');
        //     const data = await response.json();

        //     // console.log(data);

        //     var xValues = ["Micro", "Basic", "Advance", "Ultra"];
        //     var yValues = [data[0], data[1], data[2], data[3]];
        //     var total = data[4];
        //     var total_pay = data[9]
        //     var barColors = [
        //         "#ad2321",
        //         "#3EB07E",
        //         "#22497E",
        //         "#42CFEB"
        //     ];

        //     document.getElementById("cp_total_count").innerText = "Total CP = " + total + "\n";
        //     document.getElementById("cp_total_price").innerText = " Total Amount = ₹ " + total_pay;

        //     new Chart(document.getElementById("myCPChart"), {
        //         type: "pie",
        //         data: {
        //             labels: xValues,
        //             datasets: [{
        //                 backgroundColor: barColors,
        //                 data: yValues
        //             }]
        //         },
        //         options: {
        //             title: {
        //                 display: false,
        //                 text: "BIP Payout",
        //             }
        //         }
        //     });
        // }

        // async function getCAData() {
        //     const response = await fetch('charts/ca_payout.php');
        //     const data = await response.json();

        //     // Extract relevant TE data
        //     const totalCA = data.total_te;
        //     const total = data.total_te_amount;

        //     // Update stats
        //     document.getElementById("ca_total_count").innerText = "Total TE = " + totalCA;
        //     document.getElementById("ca_total_price").innerText = "Total Amount = ₹ " + total.toLocaleString() + "/-";

        //     // Hide/show chart based on data
        //     if (totalCA == 0) {
        //         document.getElementById("ca_no_chart_box").style.display = "block";
        //         document.getElementById("ca_chart_box").style.display = "none";
        //     } else {
        //         document.getElementById("ca_no_chart_box").style.display = "none";
        //         document.getElementById("ca_chart_box").style.display = "block";

        //         // Optional: Pie chart just for fun (TE vs BM vs TC vs Customer)
        //         const labels = ["TE", "BM", "TC", "Customer"];
        //         const values = [
        //             data.total_te_amount,
        //             data.total_bm_paid,
        //             data.total_tc_paid,
        //             data.total_customer_paid
        //         ];
        //         const colors = ["#ad2321", "#3EB07E", "#2e51f0", "#f9c74f"];

        //         new Chart(document.getElementById("myCAChart1"), {
        //             type: "pie",
        //             data: {
        //                 labels: labels,
        //                 datasets: [{
        //                     backgroundColor: colors,
        //                     data: values
        //                 }]
        //             },
        //             options: {
        //                 title: {
        //                     display: true,
        //                     text: "Total Paid Amount Split"
        //                 }
        //             }
        //         });
        //     }
        // }

        //get monthly count for bc, bp, customer, corporate partner, business trainee
        // $("#month_year").on('change', function() {
        //     monthYear = monthControl.value;
        //     // console.log(monthYear);
        //     //    hide user table
        //     document.getElementById("user-box").style.display = "none";
        //     monthlyUserCount();
        // });

        // get month count
        // function monthlyUserCount() {
        //     $.ajax({
        //         type: "POST",
        //         url: 'assets/submit/get_monthly_data.php',
        //         data: 'month_year=' + monthYear + '&userType=0' + '&userId=0',
        //         success: function(res) {
        //             var userCount = JSON.parse(res);
        //             //fetch data to innerHTML    
        //             document.getElementById("customer_count").innerHTML = userCount[0];
        //             document.getElementById("consultant_count").innerHTML = userCount[1];
        //             document.getElementById("partner_count").innerHTML = userCount[2];
        //             document.getElementById("corporate_partner_count").innerHTML = userCount[3];
        //             document.getElementById("business_trainee_count").innerHTML = userCount[4];
        //             document.getElementById("corporate_agency_count").innerHTML = userCount[10];
        //             document.getElementById("CA_travel_agent_count").innerHTML = userCount[11];
        //             document.getElementById("CA_customer_count").innerHTML = userCount[12];
        //             document.getElementById("cbd_count").innerHTML = userCount[13];

        //         },
        //         error: function(err) {
        //             console.log(err);
        //         }
        //     });

        // }

        // $(".close-btn").click(function() {
        //     document.getElementById("user-box").style.display = "none";
        // });

        // function showUserBox(value) {
        //     if (value == 'customer') {
        //         userType = 'customer';
        //         document.getElementById("user-box").style.display = "block";
        //         document.getElementById("table-heading").innerHTML = "Monthly Customer Details";

        //     } else if (value == 'consultant') {
        //         userType = 'consultant';
        //         document.getElementById("user-box").style.display = "block";
        //         document.getElementById("table-heading").innerHTML = "Monthly Business Consultant Details";

        //     } else if (value == 'partner') {
        //         userType = 'partner';
        //         document.getElementById("user-box").style.display = "block";
        //         document.getElementById("table-heading").innerHTML = "Monthly Business Partner Details";

        //     } else if (value == 'business_trainee') {
        //         userType = 'business_trainee';
        //         document.getElementById("user-box").style.display = "block";
        //         document.getElementById("table-heading").innerHTML = "Monthly Business Trainee Details";

        //     } else if (value == 'corporate_partner') {
        //         userType = 'corporate_partner';
        //         document.getElementById("user-box").style.display = "block";
        //         document.getElementById("table-heading").innerHTML = "Monthly Corporate Partner Details";

        //     } else if (value == 'corporate_agency') {
        //         userType = 'corporate_agency';
        //         document.getElementById("user-box").style.display = "block";
        //         document.getElementById("table-heading").innerHTML = "Monthly Techno Enterprise Details";

        //     } else if (value == 'ca_travelagency') {
        //         userType = 'ca_travelagency';
        //         document.getElementById("user-box").style.display = "block";
        //         document.getElementById("table-heading").innerHTML = "Monthly Travel Agency Details";

        //     } else if (value == 'ca_customer') {
        //         userType = 'ca_customer';
        //         document.getElementById("user-box").style.display = "block";
        //         document.getElementById("table-heading").innerHTML = "Monthly Customers Details";
        //     } else if (value == 'cbd') {
        //         userType = 'cbd';
        //         document.getElementById("user-box").style.display = "block";
        //         document.getElementById("table-heading").innerHTML = "Monthly Channel Business Director Details";
        //     }
        //     // fetch records
        //     getMonthlyUserDetails(monthYear, userType, startRowfrom, limitCount, columnName, orderBy);
        //     getMonthlyUsersCount(monthYear, userType);
        // }
        // get user details
        // function getMonthlyUserDetails(monthYear, userType, startRowfrom, limitCount, columnName, orderBy) {
        //     $(".user_row").remove();
        //     $.ajax({
        //         type: "POST",
        //         url: 'assets/submit/monthly_user_details.php',
        //         data: 'month_year=' + monthYear + '&userType=' + userType + '&userId=0' + '&startfrom=' + startRowfrom + '&limitCount=' + limitCount + '&column_name=' + columnName + '&order_by=' + orderBy,
        //         success: function(res) {
        //             //fetch data to innerHTML    
        //             $("#user_table").append(res);
        //         },
        //         error: function(err) {
        //             console.log(err);
        //             x
        //         }
        //     });
        // }

        // var startRowfrom = 0;
        // var limitCount = 5;
        // var totalRowCount = 0;
        // var columnName = 'id';
        // var orderBy = 'ASC';

        // async function getMonthlyUsersCount(monthYear, userType) {
        //     // get user counts
        //     let option = {
        //         method: 'POST',
        //         headers: {
        //             'Content-Type': 'application/json;charset=utf-8'
        //         },
        //         body: JSON.stringify({
        //             month_year: monthYear,
        //             userType: userType
        //         })
        //     }
        //     const response = await fetch('assets/submit/monthly_user_counts.php', option);
        //     totalRowCount = await response.json();
        //     setNumberOfPages(totalRowCount);
        // }
        // $("#pagination_row_limit").on('change', function() {
        //     limitCount = parseInt(this.value);
        //     startRowfrom = 0;

        //     setNumberOfPages(totalRowCount);
        //     setActivePeginatedRow(monthYear, userType, startRowfrom, limitCount, columnName, orderBy);
        // });

        // function setRowOrder(column) {
        //     // set order by
        //     if (orderBy == 'ASC') {
        //         orderBy = 'DESC';
        //     } else {
        //         orderBy = 'ASC';
        //     }
        //     columnName = column;
        //     startRowfrom = 0;

        //     setActivePeginatedRow(monthYear, userType, startRowfrom, limitCount, columnName, orderBy)
        // }

        // function setNumberOfPages(row_count) {
        //     var no_of_pages = Math.ceil(row_count / limitCount);

        //     var newContainer = document.createElement("div");
        //     newContainer.classList.add("middle");
        //     var paginationCount = $('#pagination_row');
        //     paginationCount.empty();

        //     // previous forword pegination link
        //     var divString1 = '<div class="pagination"><a href="#"';
        //     var divString2 = 'class="page_nums';
        //     var divString3 = '';
        //     if (no_of_pages < 2) {
        //         divString3 = 'disable_click';
        //     }
        //     var divString41 = '" onclick="getPeginatedRowCount(0, 0);';
        //     var divString42 = '" onclick="getPeginatedRowCount(0, 1);';
        //     var divString5 = 'return false;">';
        //     var divString61 = '&laquo;';
        //     var divString62 = '&raquo;';
        //     var divString7 = '</a></div>';

        //     newContainer.innerHTML += divString1.concat(" ", divString2, " ", divString3, " ", divString41, "", divString5, " ", divString61, "", divString7);
        //     paginationCount.append(newContainer); // for multiple element to append

        //     for (let index = 0; index < no_of_pages; index++) {
        //         var pagestartfrom = index * limitCount;
        //         var pageNo = index + 1;
        //         var htmlString2 = '';
        //         var htmlString1 = '<div class="pagination"><a href="#" class="page_nums';
        //         if (pageNo == 1) {
        //             htmlString2 = 'active';
        //         }
        //         var htmlString3 = '" id="page_num_' + pagestartfrom + '" onclick="getPeginatedRowCount(1,' + pagestartfrom + '); return false;">' + pageNo + '</a></div>';
        //         var html = htmlString1.concat(" ", htmlString2, " ", htmlString3);

        //         newContainer.innerHTML += html;
        //         paginationCount.append(newContainer); // for multiple element to append
        //     }
        //     // next pegination icon
        //     newContainer.innerHTML += divString1.concat(" ", divString2, " ", divString3, " ", divString42, "", divString5, " ", divString62, "", divString7);
        //     paginationCount.append(newContainer); // for multiple element to append
        // }

        // function getPeginatedRowCount(type, value) {
        //     var get_row = false;
        //     var get_page_count = startRowfrom + limitCount; // set max page limit

        //     if (type == '1') {
        //         startRowfrom = value;
        //         get_row = true;
        //     } else if (startRowfrom == 0 && value == 0) {} else if (get_page_count >= totalRowCount && value == 1) {} else {
        //         if (value == 1) {
        //             startRowfrom += limitCount;
        //         } else {
        //             startRowfrom -= limitCount;
        //         }
        //         get_row = true;
        //     }

        //     if (get_row) {
        //         setActivePeginatedRow(monthYear, userType, startRowfrom, limitCount, columnName, orderBy);
        //     }
        // }

        // function setActivePeginatedRow(monthYear, userType, startRowfrom, limitCount, columnName, orderBy) {
        //     const page_num = document.querySelector('#page_num_' + startRowfrom);

        //     $(".page_nums").removeClass("active");
        //     page_num.classList.add('active');

        //     getMonthlyUserDetails(monthYear, userType, startRowfrom, limitCount, columnName, orderBy);
        // }
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

        // Count of Employee
        function showDivCount(divNumber) {
            // hide all divs first
            var divs = document.querySelectorAll('.contentCountDiv');
            divs.forEach(function(div) {
                div.style.display = 'none';
            });

            // Show the clicked div 
            var activeDiv = document.getElementById('count' + divNumber);
            activeDiv.style.display = 'block';
        }
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
        $('#month_year_BCH').change(function() {
            var date = $(this).val();
            var table_update = 'bch_top_performer';
            var month = date.split('-')[1];
            var year = date.split('-')[0];
            dataString = {
                table_update,
                month,
                year
            }

            $.ajax({
                type: 'POST',
                data: dataString,
                url: 'assets/submit/top_performer.php',
                cache: false,
                success: function(data) {
                    // console.log(data);
                    $('#bch_top_performer').html(data);
                }
            });
        });

        // Top performer data change based on Month and Year BDM
        $('#month_year_BDM').change(function() {
            var date = $(this).val();
            var table_update = 'bdm_top_performer';
            var month = date.split('-')[1];
            var year = date.split('-')[0];
            dataString = {
                table_update,
                month,
                year
            }

            $.ajax({
                type: 'POST',
                data: dataString,
                url: 'assets/submit/top_performer.php',
                cache: false,
                success: function(data) {
                    // console.log(data);
                    $('#bdm_top_performer').html(data);
                }
            });
        });

        // Top performer data change based on Month and Year BM
        $('#month_year_BM').change(function() {
            var date = $(this).val();
            var table_update = 'bm_top_performer';
            var month = date.split('-')[1];
            var year = date.split('-')[0];
            dataString = {
                table_update,
                month,
                year
            }

            $.ajax({
                type: 'POST',
                data: dataString,
                url: 'assets/submit/top_performer.php',
                cache: false,
                success: function(data) {
                    // console.log(data);
                    $('#bm_top_performer').html(data);
                }
            });
        });

        // Top performer data change based on Month and Year TE
        $('#month_year_TE').change(function() {
            var date = $(this).val();
            var table_update = 'te_top_performer';
            var month = date.split('-')[1];
            var year = date.split('-')[0];
            dataString = {
                table_update,
                month,
                year
            }

            $.ajax({
                type: 'POST',
                data: dataString,
                url: 'assets/submit/top_performer.php',
                cache: false,
                success: function(data) {
                    // console.log(data);
                    $('#te_top_performer').html(data);
                }
            });
        });

        // Top performer data change based on Month and Year TA
        $('#month_year_TA').change(function() {
            var date = $(this).val();
            var table_update = 'ta_top_performer';
            var month = date.split('-')[1];
            var year = date.split('-')[0];
            dataString = {
                table_update,
                month,
                year
            }

            $.ajax({
                type: 'POST',
                data: dataString,
                url: 'assets/submit/top_performer.php',
                cache: false,
                success: function(data) {
                    // console.log(data);
                    $('#ta_top_performer').html(data);
                }
            });
        });

        // Top performer data change based on Month and Year CU
        $('#month_year_CU').change(function() {
            var date = $(this).val();
            var table_update = 'cu_top_performer';
            var month = date.split('-')[1];
            var year = date.split('-')[0];
            dataString = {
                table_update,
                month,
                year
            }

            $.ajax({
                type: 'POST',
                data: dataString,
                url: 'assets/submit/top_performer.php',
                cache: false,
                success: function(data) {
                    // console.log(data);
                    $('#cu_top_performer').html(data);
                }
            });
        });

        // Set current month and year as default value
        $(document).ready(function () {
            const monthInput = $("#month_year_count");

            const today = new Date();
            const yyyy = today.getFullYear();
            const mm = String(today.getMonth() + 1).padStart(2, '0');
            const currentMonth = `${yyyy}-${mm}`;

            monthInput.val(currentMonth);
            monthInput.prop('max', currentMonth);

            fetchMountUserCount(currentMonth);
            fetchMonthlyData(currentMonth);
        });
        $(document).on("change", "#month_year_count", function () {
            const monthYear = $(this).val();
            fetchMountUserCount(monthYear);
            fetchMonthlyData(monthYear);
        });

        //Monthly Users Count Table
        function handleMonthClick() {
            const monthYear = document.getElementById('month_year_count').value; // format: "2025-05"
            if (monthYear) {
                fetchMountUserCount(monthYear);
                fetchMonthlyData(monthYear);
            }
        }
        function fetchMountUserCount(monthYear) {
            // console.log('month year:'+monthYear);
            
            $.ajax({
                url: 'assets/submit/fetch_monthly_user_count.php', 
                type: 'POST',
                data: { monthYear: monthYear },
                dataType: 'json',
                success: function (response) {
                    if (!response || typeof response !== 'object') {
                        console.error("Invalid JSON response:", response);
                        return;
                    }
                    // console.log("User count response:", response);

                    // Example: update DOM elements based on the response
                    $("#bmCount").text(response.bm_count || 0);
                    $("#empCount").text(response.emp_count || 0);
                    $("#teCount").text(response.te_count || 0);
                    $("#tcCount").text(response.tc_count || 0);
                    $("#custCount").text(response.cust_count || 0);
                    $("#mfCount").text(response.mf_count || 0);
                    $("#sfCount").text(response.sf_count || 0);
                    $("#fCount").text(response.f_count || 0);
                },
                error: function (xhr, status, error) {
                    console.error("AJAX Error:", status, error);
                }
            });
        }

       

        function fetchMonthlyData(monthYear) {
            $.ajax({
                url: "assets/submit/fetch_monthly_data.php",
                type: "POST",
                data: { monthYear: monthYear },
                dataType: "json",
                success: function (response) {
                    // console.log("Parsed Response:", response);

                    // Destroy existing DataTables BEFORE replacing HTML
                    const tableIds = ['#datatable1', '#datatable2', '#datatable3', '#datatable4', '#datatable5', '#datatable6', '#datatable7', '#datatable8'];
                    tableIds.forEach(function (id) {
                        if ($.fn.DataTable.isDataTable(id)) {
                            $(id).DataTable().destroy();
                        }
                    });

                    // Replace the table HTML
                    $("#bm_month_list").html(response.bm_html);
                    $("#emp_month_list").html(response.emp_html);
                    $("#te_monthly_list").html(response.te_html);
                    $("#tc_monthly_list").html(response.tc_html);
                    $("#cust_monthly_list").html(response.cust_html);
                    $("#mf_monthly_list").html(response.mf_html);
                    $("#sf_monthly_list").html(response.sf_html);
                    $("#f_monthly_list").html(response.f_html);

                    // Re-initialize DataTables after HTML update
                    tableIds.forEach(function (id) {
                        $(id).DataTable({
                            pageLength: 5,
                            lengthChange: false
                        });
                    });
                },
                error: function (xhr, status, error) {
                    console.error("AJAX Error:", status, error);
                    console.log("Response Text:", xhr.responseText);
                }
            });
        }

    </script>

</body>

</html>