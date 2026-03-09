<?php
include_once '../dashboard_user_details.php';

// get current date to show next payout amount  and pass it in sql @ line 129
$date = date('F,Y'); //month and year. 'F' - month in Text form
$DateMonth = date('m'); //month in number form
$DateYear = date('Y'); //year
$usedCount=0 ;
if ($userType == 10){
    $sqlcust = 'SELECT customer_type FROM ca_customer WHERE ca_customer_id = :user';
    $stmt = $conn->prepare($sqlcust);
    $stmt->execute([':user' => $userId]);

    $customerType = $stmt->fetchColumn();
    $usedCount = 0;

}
if ($userType == '29') {
    $sqlf = 'SELECT upgrade_status, amount 
             FROM sub_franchisee 
             WHERE sub_franchisee_id = :user';

    $stmt = $conn->prepare($sqlf);
    $stmt->execute([':user' => $userId]);

    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        $fran_upgrade_status = $result['upgrade_status'];
        $fran_amount         = $result['amount'];
    } else {
        $fran_upgrade_status = null;
        $fran_amount = 0;
    }
}

?>
<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable">

<head>

    <meta charset="utf-8" />
    <title>Dashboard | Uniqbizz</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- App favicon -->
    <link rel="shortcut icon" href="../assets/images/fav.png">

    <!-- jsvectormap css -->
    <link href="../assets/libs/jsvectormap/css/jsvectormap.min.css" rel="stylesheet" type="text/css" />

    <!--Swiper slider css-->
    <link href="../assets/libs/swiper/swiper-bundle.min.css" rel="stylesheet" type="text/css" />

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

    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <style>
        /* card icon */
        .icon {
            width: 60px;
            height: 60px;
            margin-right: 15px;
        }

        .icon-content {
            padding-bottom: 20px;
        }

        @media screen and (max-width: 992px) {
            .icon-content {
                width: 50%;
            }
        }

        .cardBg1 {
            background: linear-gradient(45deg, #0e7efdff, #73b4ff) !important;
        }
 
        .cardBg2 {
            background: linear-gradient(45deg, #0aa486ff, #6de2caff) !important;
        }
 
        .cardBg3 {
            background: linear-gradient(45deg, #ffa21fff, #ffcb80) !important;
        }
 
        .cardBg4 {
            background: linear-gradient(45deg, #ed2042ff, #ff869a) !important;
        }
        .cardBg5 {
            background: linear-gradient(45deg, #3c2ff6ff, #8aa9d9ff) !important;
        }
        .cardBg6 {
            background: linear-gradient(45deg, #a800fbff, #be80ddff) !important;
        }
        .cardBg7 {
            background: linear-gradient(45deg, #ee5630ff, #feb47b) !important;
        }
        .cardBg8 {
            background: linear-gradient(45deg, #0518efff, #4d7ce3ff) !important;
        }
        .selected-li {
            border-left: 4px solid #0d6efd; /* Bootstrap primary blue */
            background-color: #f0f8ff; /* optional: light background */
            padding-left: 12px; /* left padding */
        }
        .active-highlight {
            background-color: #d8ecff !important; /*Light blue */
            border-left: 4px solid #0d6efd;  /*Optional: adds a blue border */
            border-radius: 5px;
            padding: 5px;
        }
        .couponCount {
            width: 240px;
            padding: 10px 5px;
        }

        /* for upgrade card */
        /* Main Card Styling */
        .upgrade-card {
            background: linear-gradient(135deg, #e6f9f0, #ffffff);
            box-shadow: 0 10px 30px rgba(0, 150, 80, 0.15);
            border: 1px solid rgba(0, 200, 120, 0.2);
            transition: all 0.3s ease;
            overflow: hidden;
        }

        .upgrade-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(0, 150, 80, 0.25);
        }

        /* Highlight Text */
        .highlight-upgrade {
            color: #00a86b;
        }

        /* Button */
        .upgrade-btn {
            background: linear-gradient(45deg, #00c97b, #00a86b);
            border: none;
            color: #fff;
            font-weight: 600;
            border-radius: 30px;
            box-shadow: 0 5px 15px rgba(0, 200, 120, 0.4);
            transition: all 0.3s ease;
        }

        .upgrade-btn:hover {
            transform: scale(1.05);
            box-shadow: 0 8px 20px rgba(0, 200, 120, 0.6);
        }

        /* Popper Icon */
        .upgrade-icon {
            width: 75px;
            height: 75px;
        }

        /* Floating animation */
        .floating-img {
            max-height: 180px;
            animation: float 3s ease-in-out infinite;
        }

        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
            100% { transform: translateY(0px); }
        }
        /* Card Background */
        .pre-upgrade-card {
            background: linear-gradient(135deg, #fff8e6, #ffffff);
            border: 1px solid rgba(255, 170, 0, 0.25);
            box-shadow: 0 10px 30px rgba(255, 170, 0, 0.15);
            transition: all 0.3s ease;
        }

        .pre-upgrade-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(255, 170, 0, 0.25);
        }

        /* Icon */
        .pre-icon {
            width: 75px;
            height: 75px;
        }

        /* Benefits list */
        .upgrade-benefits {
            list-style: none;
            padding-left: 0;
        }

        .upgrade-benefits li {
            margin-bottom: 6px;
            font-weight: 500;
            position: relative;
            padding-left: 25px;
        }

        .upgrade-benefits li::before {
            content: "✔";
            position: absolute;
            left: 0;
            color: #f4a000;
            font-weight: bold;
        }

        /* Upgrade Button */
        .upgrade-now-btn {
            background: linear-gradient(45deg, #ffb000, #ff8c00);
            border: none;
            color: #fff;
            font-weight: 600;
            border-radius: 30px;
            box-shadow: 0 5px 15px rgba(255, 140, 0, 0.4);
            transition: all 0.3s ease;
        }

        .upgrade-now-btn:hover {
            transform: scale(1.05);
            box-shadow: 0 8px 20px rgba(255, 140, 0, 0.6);
        }

        /* Subtle pulse animation */
        .pulse-img {
            max-height: 180px;
            animation: pulse 2.5s infinite;
        }

        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }

        /* for upgrade card */
    </style>

</head>

<body class="twocolumn-panel">

    <!-- Begin page -->
    <div id="layout-wrapper">

        <?php include_once "../header.php" ?>

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

        <?php include_once "../sidebar.php" ?>
        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">
        <input type="hidden" value="<?= $userType?>" id="user_type"/>
            <div class="page-content">
                <div class="container-fluid">

                    <div class="row">
                        <div class="col">

                            <div class="h-100">
                                <!-- Greeting section  -->
                                <div class="row mb-3 pb-1">
                                    <div class="col-12">
                                        <div class="d-flex align-items-lg-center flex-lg-row flex-column">
                                            <div class="flex-grow-1">
                                                <h4 class="fs-16 mb-1">Welcome, <?php echo $userFname . ' ' . $userLname; ?>!</h4>
                                                <p class="text-muted mb-0">Here's what's happening on your dashboard.</p>
                                            </div>

                                        </div><!-- end card header -->
                                    </div>
                                    <!--end col-->
                                </div><!--end row-->

                                <?php if ($userType == '3') { ?> <!--Business Consultent => 3  -->
                                    <!-- Statistic col group of 4 -->
                                    <div class="row">
                                        <!-- <div class="col-xl-3 col-md-6">
                                                <div class="card card-animate">
                                                    <div class="card-body">
                                                        <div class="d-flex align-items-center">
                                                            <div class="flex-grow-1 overflow-hidden">
                                                                <p class="text-uppercase fw-medium text-muted text-truncate mb-0"> Corporate Agency Lead</p>
                                                            </div>
                                                        </div>
                                                        <div class="d-flex align-items-end justify-content-between mt-4">
                                                            <div>
                                                                <?php
                                                                $sql3 = "SELECT COUNT(corporate_agency_id) as id FROM corporate_agency WHERE reference_no = '" . $userId . "' AND status = '2'";
                                                                $stmt3 = $conn->prepare($sql3);
                                                                $stmt3->execute();
                                                                $stmt3->setFetchMode(PDO::FETCH_ASSOC);
                                                                if ($stmt3->rowCount() > 0) {
                                                                    foreach (($stmt3->fetchAll()) as $key => $row) {
                                                                        $id = $row['id'];
                                                                        echo '<h4 class="fs-22 fw-semibold ff-secondary mb-4"><span class="counter-value" data-target="' . $id . '"></span></h4>';
                                                                    }
                                                                }
                                                                ?>
                                                                <a href="view_corporate_agency.php" class="text-decoration-underline">View  </a>
                                                            </div>
                                                            <div class="avatar-sm flex-shrink-0">
                                                                <span class="avatar-title bg-success rounded fs-3">
                                                                    <i class="bx bx-user-circle"></i>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> -->

                                        <div class="col-xl-4 col-md-6">
                                            <!-- card -->
                                            <div class="card card-animate">
                                                <div class="card-body">
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-grow-1 overflow-hidden">
                                                            <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Corporate Agency </p>
                                                        </div>
                                                        <!-- <div class="flex-shrink-0">
                                                                <h5 class="text-danger fs-14 mb-0">
                                                                    <i class="ri-arrow-right-down-line fs-13 align-middle"></i> -3.57 %
                                                                </h5>
                                                            </div> -->
                                                    </div>
                                                    <div class="d-flex align-items-end justify-content-between mt-4">
                                                        <div>
                                                            <?php
                                                            $sql3 = "SELECT COUNT(corporate_agency_id) as id FROM corporate_agency WHERE reference_no = '" . $userId . "' AND status = '1'";
                                                            $stmt3 = $conn->prepare($sql3);
                                                            $stmt3->execute();
                                                            $stmt3->setFetchMode(PDO::FETCH_ASSOC);
                                                            if ($stmt3->rowCount() > 0) {
                                                                foreach (($stmt3->fetchAll()) as $key => $row) {
                                                                    $id = $row['id'];
                                                                    echo '<h4 class="fs-22 fw-semibold ff-secondary mb-4"><span id="activeID" class="counter-value" data-target="' . $id . '"></span></h4>';
                                                                }
                                                            }
                                                            ?>
                                                            <a href="view_corporate_agency.php" class="text-decoration-underline">View </a>
                                                        </div>
                                                        <div class="avatar-sm flex-shrink-0">
                                                            <span class="avatar-title bg-info rounded fs-3">
                                                                <i class="bx bx-user-circle"></i>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div><!-- end card body -->
                                            </div><!-- end card -->
                                        </div><!-- end col -->

                                        <div class="col-xl-4 col-md-6">
                                            <!-- card -->
                                            <div class="card card-animate">
                                                <div class="card-body">
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-grow-1 overflow-hidden">
                                                            <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Travel Agency</p>
                                                        </div>
                                                        <!-- <div class="flex-shrink-0">
                                                                <h5 class="text-success fs-14 mb-0">
                                                                    <i class="ri-arrow-right-up-line fs-13 align-middle"></i> +29.08 %
                                                                </h5>
                                                            </div> -->
                                                    </div>
                                                    <div class="d-flex align-items-end justify-content-between mt-4">
                                                        <div>
                                                            <?php
                                                            $stmt2 = $conn->prepare("SELECT * FROM `corporate_agency` WHERE reference_no = ? ");
                                                            $stmt2->execute([$userId]);
                                                            $referrals = $stmt2->fetchAll(PDO::FETCH_ASSOC);

                                                            $count = 0; // Initialize count

                                                            foreach ($referrals as $referral) {
                                                                $userCA = $referral['corporate_agency_id'];

                                                                $stmt4 = $conn->prepare("SELECT ca_travelagency_id FROM ca_travelagency WHERE reference_no = ?");
                                                                $stmt4->execute([$referral['corporate_agency_id']]);
                                                                $stmt4->setFetchMode(PDO::FETCH_ASSOC);
                                                                if ($stmt4->rowCount() > 0) {
                                                                    foreach (($stmt4->fetchAll()) as $userCATAs => $userCATA) {
                                                                        $userTA = $userCATA['ca_travelagency_id'] . ' ';
                                                                        $count++; // Increment count for each ca_travelagency_id
                                                                    } //CATA foreach ends
                                                                } //CATA if loop ends
                                                            } //CA foreach ends 

                                                            echo '<h4 class="fs-22 fw-semibold ff-secondary mb-4"><span class="counter-value" data-target="' . $count . '"></span></h4>';
                                                            ?>
                                                            <!-- <h4 class="fs-22 fw-semibold ff-secondary mb-4"><span class="counter-value" data-target="5">0</span></h4> -->
                                                            <a href="view_travel_agent.php" class="text-decoration-underline">View </a>
                                                        </div>
                                                        <div class="avatar-sm flex-shrink-0">
                                                            <span class="avatar-title bg-warning rounded fs-3">
                                                                <i class="bx bx-shopping-bag"></i>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div><!-- end card body -->
                                            </div><!-- end card -->
                                        </div><!-- end col -->

                                        <div class="col-xl-4 col-md-6">
                                            <!-- card -->
                                            <div class="card card-animate">
                                                <div class="card-body">
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-grow-1 overflow-hidden">
                                                            <p class="text-uppercase fw-medium text-muted text-truncate mb-0"> My Wallet</p>
                                                        </div>
                                                        <!-- <div class="flex-shrink-0">
                                                                <h5 class="text-muted fs-14 mb-0">
                                                                    +0.00 %
                                                                </h5>
                                                            </div> -->
                                                    </div>
                                                    <div class="d-flex align-items-end justify-content-between mt-4">
                                                        <div>
                                                            <?php

                                                            $sqlCAP = $conn->prepare("SELECT SUM(comm_amtTotal) as CommAmt FROM ca_payout WHERE business_consultant = '" . $userId . "' AND status='1' ");
                                                            $sqlCAP->execute();
                                                            $sqlCAP->setFetchMode(PDO::FETCH_ASSOC);
                                                            if ($sqlCAP->rowCount() > 0) {
                                                                foreach (($sqlCAP->fetchAll()) as $key => $row) {
                                                                    $amt = $row['CommAmt'];
                                                                }
                                                            }

                                                            $sqlTAP = $conn->prepare("SELECT SUM(commision_bc) as Comm FROM ca_ta_payout WHERE business_consultant = '" . $userId . "' AND status_bc= '1' ");
                                                            $sqlTAP->execute();
                                                            $sqlTAP->setFetchMode(PDO::FETCH_ASSOC);
                                                            if ($sqlTAP->rowCount() > 0) {
                                                                foreach (($sqlTAP->fetchAll()) as $key => $row) {
                                                                    $Comm = $row['Comm'];
                                                                    $tds = $Comm * 5 / 100;
                                                                    $walletBal = $Comm - $tds;
                                                                }
                                                            }

                                                            $walletBal = $amt + $Comm;
                                                            echo '<h4 class="fs-22 fw-semibold ff-secondary mb-4">&#8377<span class="counter-value" data-target="' . $walletBal . '"></span></h4>';

                                                            ?>

                                                            <a href="contracting_payout.php" class="text-decoration-underline">View Wallet Details</a>
                                                        </div>
                                                        <div class="avatar-sm flex-shrink-0">
                                                            <span class="avatar-title bg-danger rounded fs-3">
                                                                <i class="bx bx-wallet"></i>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div><!-- end card body -->
                                            </div><!-- end card -->
                                        </div><!-- end col -->
                                    </div> <!-- end row-->
                                <?php } ?>

                                <?php if ($userType == '10') { 
                                        include '../models/home_model/cards/customer.php';  
                                      } 
                                ?>

                                <?php if ($userType == '11' || $userType == '33') { 
                                        include '../models/home_model/cards/tc.php';
                                      } 
                                ?>

                                <?php if ($userType == '16' || $userType == '29' || $userType == '32') { 
                                        include '../models/home_model/cards/te_f.php';
                                      } 
                                 ?>

                                <?php if ($userType == '15') { ?> <!--Business Trainee => 15  Hold -->
                                    <!-- Statistic col group of 4 -->
                                    <div class="row">
                                        <div class="col-xl-3 col-md-6">
                                            <!-- card -->
                                            <div class="card card-animate">
                                                <div class="card-body">
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-grow-1 overflow-hidden">
                                                            <p class="text-uppercase fw-medium text-muted text-truncate mb-0"> Customer Lead</p>
                                                        </div>
                                                        <!-- <div class="flex-shrink-0">
                                                                <h5 class="text-success fs-14 mb-0">
                                                                    <i class="ri-arrow-right-up-line fs-13 align-middle"></i> +16.24 %
                                                                </h5>
                                                            </div> -->
                                                    </div>
                                                    <div class="d-flex align-items-end justify-content-between mt-4">
                                                        <div>
                                                            <h4 class="fs-22 fw-semibold ff-secondary mb-4"><span class="counter-value" data-target="220">0</span></h4>
                                                            <a href="#" class="text-decoration-underline">View </a>
                                                        </div>
                                                        <div class="avatar-sm flex-shrink-0">
                                                            <span class="avatar-title bg-success rounded fs-3">
                                                                <i class="bx bx-user-circle"></i>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div><!-- end card body -->
                                            </div><!-- end card -->
                                        </div><!-- end col -->

                                        <div class="col-xl-3 col-md-6">
                                            <!-- card -->
                                            <div class="card card-animate">
                                                <div class="card-body">
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-grow-1 overflow-hidden">
                                                            <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Customer Registered </p>
                                                        </div>
                                                        <!-- <div class="flex-shrink-0">
                                                                <h5 class="text-danger fs-14 mb-0">
                                                                    <i class="ri-arrow-right-down-line fs-13 align-middle"></i> -3.57 %
                                                                </h5>
                                                            </div> -->
                                                    </div>
                                                    <div class="d-flex align-items-end justify-content-between mt-4">
                                                        <div>
                                                            <h4 class="fs-22 fw-semibold ff-secondary mb-4"><span class="counter-value" data-target="115">0</span></h4>
                                                            <a href="#" class="text-decoration-underline">View </a>
                                                        </div>
                                                        <div class="avatar-sm flex-shrink-0">
                                                            <span class="avatar-title bg-info rounded fs-3">
                                                                <i class="bx bx-user-circle"></i>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div><!-- end card body -->
                                            </div><!-- end card -->
                                        </div><!-- end col -->

                                        <div class="col-xl-3 col-md-6">
                                            <!-- card -->
                                            <div class="card card-animate">
                                                <div class="card-body">
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-grow-1 overflow-hidden">
                                                            <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Total Booking</p>
                                                        </div>
                                                        <!-- <div class="flex-shrink-0">
                                                                <h5 class="text-success fs-14 mb-0">
                                                                    <i class="ri-arrow-right-up-line fs-13 align-middle"></i> +29.08 %
                                                                </h5>
                                                            </div> -->
                                                    </div>
                                                    <div class="d-flex align-items-end justify-content-between mt-4">
                                                        <div>
                                                            <h4 class="fs-22 fw-semibold ff-secondary mb-4"><span class="counter-value" data-target="0">0</span></h4>
                                                            <a href="#" class="text-decoration-underline">View </a>
                                                        </div>
                                                        <div class="avatar-sm flex-shrink-0">
                                                            <span class="avatar-title bg-warning rounded fs-3">
                                                                <i class="bx bx-shopping-bag"></i>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div><!-- end card body -->
                                            </div><!-- end card -->
                                        </div><!-- end col -->

                                        <div class="col-xl-3 col-md-6">
                                            <!-- card -->
                                            <div class="card card-animate">
                                                <div class="card-body">
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-grow-1 overflow-hidden">
                                                            <p class="text-uppercase fw-medium text-muted text-truncate mb-0"> My Wallet</p>
                                                        </div>
                                                        <!-- <div class="flex-shrink-0">
                                                                <h5 class="text-muted fs-14 mb-0">
                                                                    +0.00 %
                                                                </h5>
                                                            </div> -->
                                                    </div>
                                                    <div class="d-flex align-items-end justify-content-between mt-4">
                                                        <div>
                                                            <h4 class="fs-22 fw-semibold ff-secondary mb-4">&#8377<span class="counter-value" data-target="0000">0</span></h4>
                                                            <a href="#" class="text-decoration-underline">View Wallet Details</a>
                                                        </div>
                                                        <div class="avatar-sm flex-shrink-0">
                                                            <span class="avatar-title bg-danger rounded fs-3">
                                                                <i class="bx bx-wallet"></i>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div><!-- end card body -->
                                            </div><!-- end card -->
                                        </div><!-- end col -->
                                    </div> <!-- end row-->
                                <?php } ?>

                                <?php if ($userType == '24') { 
                                        include '../models/home_model/cards/bcm.php';
                                      } 
                                ?>

                                <?php if ($userType == '25' || $userType == '31') { 
                                        include '../models/home_model/cards/bdm_rm.php';
                                      } 
                                ?>

                                <?php if ($userType == '26' || $userType == '28' || $userType == '30') { 
                                        include '../models/home_model/cards/bm_mf_sf.php';
                                      } 
                                 ?>

                                <!-- progress Bar -->
                                <?php if ($userType == '11' || $userType == '16') { 
                                        include '../models/home_model/progress_bar/te_tc.php';
                                      } 
                                ?>

                                <!-- !-- Line Chart and top 5 user table -->
                                <?php if ($userType == '3' || $userType == '11' || $userType == '16' || $userType == '26' || $userType == '25' || $userType == '24' || $userType == '28' || $userType =='29' || $userType =='30' || $userType =='31' || $userType == '33') { 
                                        include '../models/home_model/line_chart/all_users.php';
                                      } 
                                 ?>

                                <?php if (!$userType == "19" || !$userType == "24" || !$userType == "25" || !$userType == "26") { 
                                        include '../models/home_model/recent_booking/bm_bdm_bm.php';
                                      } 
                                 ?>

                                <!-- top customer engagment -->
                                
                                <?php include '../models/home_model/cust_engage.php' ?>
                                <!-- recents 5 bookings -->
                                <!-- booking id,customer name,package name,amount,booking date,travel date -->
                                <?php if($userType == "11" || $userType == '33'){ 
                                        include '../models/home_model/recent_booking/tc.php';
                                      } 
                                 ?>
                                <!-- end recent 5 booking -->
                            </div>
                        </div>
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
     <!-- contact card pop up  start-->
    <?php include '../models/home_model/contact.php' ?>

    <!-- contact card pop up end-->

    <!-- JAVASCRIPT -->
    <script src="../assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/libs/simplebar/simplebar.min.js"></script>
    <script src="../assets/libs/node-waves/waves.min.js"></script>
    <script src="../assets/libs/feather-icons/feather.min.js"></script>
    <script src="../assets/js/jquery/jquery-3.7.1.min.js"></script>

    <!-- !-- materialdesign remix icon js- -->
    <script src="../assets/js/pages/remix-icons-listing.js"></script>

    <!-- Vector map-->
    <script src="../assets/libs/jsvectormap/js/jsvectormap.min.js"></script>
    <script src="../assets/libs/jsvectormap/maps/world-merc.js"></script>

    <!--Swiper slider js-->
    <script src="../assets/libs/swiper/swiper-bundle.min.js"></script>

    <!-- App js -->
    <script src="../assets/js/app.js"></script>

    <script src="../assets/libs/chart.js/Chart-2.5.0.min.js"></script>


    <!-- Dashboard init  popular candidates section js file-->
    <script src="../assets/js/pages/dashboard-job.init.js"></script>

    <script src="../assets/js/js-confetti.js"></script>
    <script src="../resources/home_res/home_res_custom.js"></script>
    <script>
        $(function() {
            // get min and max month for input tag
            const date = new Date()
            const month = ("0" + (date.getMonth() + 1)).slice(-2)
            const year = date.getFullYear()
            monthControl.value = `${year}-${month}`;
            // console.log(monthControl.value);

            userId = <?php echo json_encode($_SESSION['user_id'], JSON_HEX_TAG); ?>;
            userType = <?php echo json_encode($_SESSION['user_type_id_value'], JSON_HEX_TAG); ?>;

            // Set Default value for years
            for (let index = 2024; index <= getCurrentYear; index++) {
                if (index == getCurrentYear) {
                    $("#years").append('<option selected="selected" value="' + index + '">' + index + '</option>');
                } else {
                    $("#years").append('<option value="' + index + '">' + index + '</option>');
                }
            }
            // get chart data
            getMonthlyUserData(getCurrentYear);
            // monthYear = monthControl.value;
        });
    </script>
    <?php 
        if ($userType == 10) {

    ?>
    <!-- Coupon section for customer start -->
    <script>
        window.onload = function () {
            const originalCard = document.getElementById('coupon_card1');
            const parentRow = document.getElementById('couponRow');
            const couponUnlockCount = <?=$usedCount?>

            const couponIcons = [
                { lib: "fa", class: "fa-tag" },              // Coupon 1
                { lib: "ri", class: "ri-gift-line" },        // Coupon 2
                { lib: "fa", class: "fa-tags" },             // Coupon 3
                { lib: "ri", class: "ri-flight-takeoff-line" } // Coupon 4
            ];

            // Set icon for Coupon 1
            const icon1 = originalCard.querySelector('i');
            if (icon1) {
                const iconInfo = couponIcons[0];
                icon1.className = `couponIcon fa-2xl text-white ${iconInfo.lib === 'fa' ? 'fa-solid' : ''} ${iconInfo.class}`;
            }

            // Clone for Coupons 2–4
            for (let i = 2; i <= couponIcons.length; i++) {
                const newCard = originalCard.cloneNode(true);
                newCard.id = `coupon_card${i}`;

                // Update cardCoupon class
                const cardDiv = newCard.querySelector('.card');
                cardDiv.classList.forEach(cls => {
                    if (cls.startsWith('cardCoupon')) cardDiv.classList.remove(cls);
                });
                cardDiv.classList.add(`cardCoupon${i}`);

                // Update title
                const couponTitle = newCard.querySelector('.fw-bolder');
                if (couponTitle) couponTitle.textContent = `Coupon ${i}`;

                // Update icon
                const icon = newCard.querySelector('.couponIcon');
                if (icon) {
                    const iconInfo = couponIcons[i - 1];
                    icon.className = `couponIcon fa-2xl text-white ${iconInfo.lib === 'fa' ? 'fa-solid' : ''} ${iconInfo.class}`;
                }

                parentRow.appendChild(newCard);
            }

            if(couponUnlockCount == 1){
                let lockDiv=originalCard.querySelector('#cardCouponLockId')//get div by its id that is in the parent div
                if (lockDiv) {
                    lockDiv.classList.add('d-none');
                }
            }
            else if(couponUnlockCount == 2){
                let Card1=document.getElementById('coupon_card1');
                let Card2=document.getElementById('coupon_card2');
                let lockDiv1=Card1.querySelector('#cardCouponLockId')//get div by its id that is in the parent div
                if (lockDiv1) {
                    lockDiv1.classList.add('d-none');
                }
                let lockDiv2=Card2.querySelector('#cardCouponLockId')//get div by its id that is in the parent div
                if (lockDiv2) {
                    lockDiv2.classList.add('d-none');
                }
            }
            else if(couponUnlockCount == 3){
                let Card1=document.getElementById('coupon_card1');
                let Card2=document.getElementById('coupon_card2');
                let Card3=document.getElementById('coupon_card3');
                let Card4=document.getElementById('coupon_card4');
                let lockDiv1=Card1.querySelector('#cardCouponLockId')//get div by its id that is in the parent div
                if (lockDiv1) {
                    lockDiv1.classList.add('d-none');
                }
                let lockDiv2=Card2.querySelector('#cardCouponLockId')//get div by its id that is in the parent div
                if (lockDiv2) {
                    lockDiv2.classList.add('d-none');
                }
                let lockDiv3=Card3.querySelector('#cardCouponLockId')//get div by its id that is in the parent div
                if (lockDiv3) {
                    lockDiv3.classList.add('d-none');
                }
                let lockDiv4=Card4.querySelector('#cardCouponLockId')//get div by its id that is in the parent div
                if (lockDiv4) {
                    lockDiv4.classList.add('d-none');
                }
            }
        };
    </script>
    <?php 
        }
    ?>
    <!-- Coupon section for customer end -->
</body>

</html>