<?php
include_once 'dashboard_user_details.php';

// get current date to show next payout amount  and pass it in sql @ line 129
$date = date('F,Y'); //month and year. 'F' - month in Text form
$DateMonth = date('m'); //month in number form
$DateYear = date('Y'); //year
// echo "Next Date ".$date .' ;' ;
// echo "Next Month ".$nextDateMonth.' ;';
// echo "Next Year ".$nextDateYear.' ;';
// echo '<br>';

?>
<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable">

<head>

    <meta charset="utf-8" />
    <title>Dashboard | Uniqbizz</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- App favicon -->
    <link rel="shortcut icon" href="assets/images/fav.png">

    <!-- jsvectormap css -->
    <link href="assets/libs/jsvectormap/css/jsvectormap.min.css" rel="stylesheet" type="text/css" />

    <!--Swiper slider css-->
    <link href="assets/libs/swiper/swiper-bundle.min.css" rel="stylesheet" type="text/css" />

    <!-- Layout config Js -->
    <script src="assets/js/layout.js"></script>
    <!-- Bootstrap Css -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="assets/css/app.min.css" rel="stylesheet" type="text/css" />
    <!-- custom Css-->
    <link href="assets/css/custom.min.css" rel="stylesheet" type="text/css" />
    <!-- custom Css developer-->
    <link rel="stylesheet" href="assets/css/custom.css" />

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
            background: linear-gradient(45deg, #4099ff, #73b4ff) !important;
        }

        .cardBg2 {
            background: linear-gradient(45deg, #2ed8b6, #59e0c5) !important;
        }

        .cardBg3 {
            background: linear-gradient(45deg, #ffb64d, #ffcb80) !important;
        }

        .cardBg4 {
            background: linear-gradient(45deg, #ff5370, #ff869a) !important;
        }
    </style>

</head>

<body class="twocolumn-panel">

    <!-- Begin page -->
    <div id="layout-wrapper">

        <?php include_once "header.php" ?>

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

        <?php include_once "sidebar.php" ?>
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

                                <?php if ($userType == '10') { ?> <!--customer => 10  -->
                                    <!-- Upgrade section  -->

                                    <div class="row">
                                        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-12">
                                            <div class="card rounded-3 pt-3 pb-2 px-4 cardBg1">
                                                <div>
                                                    <p class="text-white fw-bold">Registered Customer</p>
                                                </div>
                                                <div class="d-flex justify-content-between align-items-center mb-1">
                                                    <span class="">
                                                        <i class="fa-regular fa-user fa-2xl" style="color: #ffffff;"></i>
                                                    </span>
                                                    <div class="ms-4">
                                                        <?php
                                                        $sql3 = "SELECT COUNT(ca_customer_id) as id FROM ca_customer WHERE reference_no = '" . $userId . "' AND status = '1'";
                                                        $stmt3 = $conn->prepare($sql3);
                                                        $stmt3->execute();
                                                        $stmt3->setFetchMode(PDO::FETCH_ASSOC);
                                                        if ($stmt3->rowCount() > 0) {
                                                            foreach (($stmt3->fetchAll()) as $key => $row) {
                                                                $id = $row['id'];
                                                                echo '<h1 class="mb-0 text-white">' . $id . '</h1>';
                                                            }
                                                        }
                                                        ?>
                                                    </div>
                                                </div>
                                                <div class="d-flex justify-content-between">
                                                    <p class="text-white">This Month</p>
                                                    <?php
                                                    $sql3 = "SELECT COUNT(ca_customer_id) as id FROM ca_customer WHERE reference_no = '" . $userId . "' AND YEAR(register_date) = '" . $DateYear . "' AND MONTH(register_date) = '" . $DateMonth . "'  AND status = '1'";
                                                    $stmt3 = $conn->prepare($sql3);
                                                    $stmt3->execute();
                                                    $stmt3->setFetchMode(PDO::FETCH_ASSOC);
                                                    if ($stmt3->rowCount() > 0) {
                                                        foreach (($stmt3->fetchAll()) as $key => $row) {
                                                            $id2 = $row['id'];
                                                            echo '<p class="text-white">' . $id2 . '</p>';
                                                        }
                                                    }
                                                    ?>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-12">
                                            <div class="card rounded-3 pt-3 pb-2 px-4 cardBg2">
                                                <div>
                                                    <p class="text-white fw-bold">Completed Tours</p>
                                                </div>
                                                <div class="d-flex justify-content-between align-items-center mb-1">
                                                    <span class="">
                                                        <i class="fa-regular fa-map fa-2xl" style="color: #ffffff;"></i>
                                                    </span>
                                                    <div class="ms-4">
                                                        <?php
                                                        $stmt = $conn->prepare("SELECT COUNT(cu_id) as completedTour FROM product_payout WHERE cu_id = ? AND end_date < NOW()");
                                                        $stmt->execute([$userId]);
                                                        $stmt->setFetchMode(PDO::FETCH_ASSOC);
                                                        if ($stmt->rowCount() > 0) {
                                                            foreach (($stmt->fetchAll()) as $key => $row) {
                                                                $completedTour = $row['completedTour'];
                                                                echo '<h1 class="mb-0 text-white">' . $completedTour . '</h1>';
                                                            }
                                                        }
                                                        ?>

                                                    </div>
                                                </div>
                                                <div class="d-flex justify-content-between">
                                                    <p class="text-white">This Month</p>
                                                    <?php
                                                    $stmt = $conn->prepare("SELECT COUNT(cu_id) as completedTourThisMonth FROM product_payout WHERE cu_id = ? AND end_date < NOW() AND  YEAR(end_date) = '" . $DateYear . "' AND MONTH(end_date) = '" . $DateMonth . "'");
                                                    $stmt->execute([$userId]);
                                                    $stmt->setFetchMode(PDO::FETCH_ASSOC);
                                                    if ($stmt->rowCount() > 0) {
                                                        foreach (($stmt->fetchAll()) as $key => $row) {
                                                            $completedTourThisMonth = $row['completedTourThisMonth'];
                                                            echo '<p class="text-white">' . $completedTourThisMonth . '</p>';
                                                        }
                                                    }
                                                    ?>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-12">
                                            <div class="card rounded-3 pt-3 pb-2 px-4 cardBg3">
                                                <div>
                                                    <p class="text-white fw-bold">Upcoming Tours</p>
                                                </div>
                                                <div class="d-flex justify-content-between align-items-center mb-1">
                                                    <span class="">
                                                        <i class="fa-solid fa-clock-rotate-left fa-2xl" style="color: #ffffff;"></i>
                                                    </span>
                                                    <div class="ms-4">
                                                        <?php
                                                        $stmt = $conn->prepare("SELECT COUNT(cu_id) as upcomingTour FROM product_payout WHERE cu_id = ? AND start_date > NOW()");
                                                        $stmt->execute([$userId]);
                                                        $stmt->setFetchMode(PDO::FETCH_ASSOC);
                                                        if ($stmt->rowCount() > 0) {
                                                            foreach (($stmt->fetchAll()) as $key => $row) {
                                                                $upcomingTour = $row['upcomingTour'];
                                                                echo '<h1 class="mb-0 text-white">' . $upcomingTour . '</h1>';
                                                            }
                                                        }
                                                        ?>
                                                    </div>
                                                </div>
                                                <div class="d-flex justify-content-between">
                                                    <p class="text-white">This Month</p>
                                                    <?php
                                                    $stmt = $conn->prepare("SELECT COUNT(cu_id) as upcomingTourThisMonth FROM product_payout WHERE cu_id = ? AND start_date > NOW() AND  YEAR(start_date) = '" . $DateYear . "' AND MONTH(start_date) = '" . $DateMonth . "'");
                                                    $stmt->execute([$userId]);
                                                    $stmt->setFetchMode(PDO::FETCH_ASSOC);
                                                    if ($stmt->rowCount() > 0) {
                                                        foreach (($stmt->fetchAll()) as $key => $row) {
                                                            $upcomingTourThisMonth = $row['upcomingTourThisMonth'];
                                                            echo '<p class="text-white">' . $upcomingTourThisMonth . '</p>';
                                                        }
                                                    }
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-12">
                                            <div class="card rounded-3 pt-3 pb-2 px-4 cardBg4">
                                                <div>
                                                    <p class="text-white fw-bold">Commission Earned</p>
                                                </div>
                                                <div class="d-flex justify-content-between align-items-center mb-1">
                                                    <span class="">
                                                        <i class="fa-regular fa-money-bill-1 fa-2xl" style="color: #ffffff;"></i>
                                                    </span>
                                                    <div class="ms-4">

                                                        <?php

                                                        //pending amount
                                                        //status = 1 Confirm,  2 pending
                                                        $cust_ids = ['cu1', 'cu2', 'cu2'];  // Customer IDs array
                                                        foreach ($cust_ids as $cust_id) {
                                                            // Prepare the dynamic column name for the query
                                                            // Note: In this case, we're assuming that $cust_id values are safe and predefined
                                                            $column_id = $cust_id . '_id';  // Example: 'cu1_id' or 'cu2_id'
                                                            $column_status = $cust_id . '_status';  // Example: 'cu1_status' or 'cu2_status'
                                                            $column_amt = $cust_id . '_amt';

                                                            // Prepare the SQL query using placeholders for security
                                                            $sqlCAP = $conn->prepare("SELECT SUM($column_amt) as cuAmt FROM product_payout WHERE $column_id = :userId ");

                                                            // Bind the userId parameter
                                                            $sqlCAP->bindParam(':userId', $userId, PDO::PARAM_STR);

                                                            // Output the SQL query for debugging purposes (just for your understanding, not to be done in production)
                                                            // echo "Executing query for $cust_id: ";
                                                            // echo "SELECT SUM($column_amt) as cuAmt FROM product_payout WHERE $column_id = '$userId' AND $column_status = '2'<br>";


                                                            // Execute the query
                                                            $sqlCAP->execute();

                                                            // Check if there are results and fetch the amount
                                                            if ($sqlCAP->rowCount() > 0) {
                                                                $row = $sqlCAP->fetch(PDO::FETCH_ASSOC);
                                                                $PendingAmt = $row['cuAmt'];
                                                                // Do something with $PendingAmt
                                                            }
                                                        }
                                                        // $cust_ids=['cu1','cu2','cu2'];
                                                        // foreach ( $cust_ids as $key =>  $cust_id) {

                                                        //     $sqlCAP = $conn -> prepare("SELECT SUM(".$cust_id."_id) as cuAmt FROM product_payout WHERE ".$cust_id."_id = '".$userId."' AND ".$cust_id."_status='2' ");
                                                        //     $sqlCAP -> execute();
                                                        //     $sqlCAP -> setFetchMode(PDO::FETCH_ASSOC);
                                                        //     if( $sqlCAP -> rowCount()>0 ){
                                                        //         foreach( ( $sqlCAP -> fetchAll() ) as $key => $row ){
                                                        //             $PendingAmt = $row['cuAmt'];
                                                        //         }
                                                        //     }
                                                        // }

                                                        //status = 1 pending,  2 confirm
                                                        // $sqlTAP = $conn -> prepare("SELECT SUM(commision_ca) as teCommiAmt FROM ca_ta_payout WHERE corporate_agency = '".$userId."' AND status_ca = '2' ");
                                                        // $sqlTAP -> execute();
                                                        // $sqlTAP -> setFetchMode(PDO::FETCH_ASSOC);
                                                        // if( $sqlTAP -> rowCount()>0 ){
                                                        //     foreach( ( $sqlTAP -> fetchAll() ) as $key => $row ){
                                                        //         $PendingComm = $row['teCommiAmt'];
                                                        //     }
                                                        // }

                                                        // $AmtTotalPending = $PendingAmt + $PendingComm;
                                                        $tdsAmtPending = $PendingAmt * $tdsPercentage;
                                                        $walletBalPending = $PendingAmt - $tdsAmtPending;
                                                        $truncatedWalletBalP = floor($walletBalPending * 100) / 100;
                                                        $finalAmtP = number_format($truncatedWalletBalP, 2);

                                                        //confirm amount
                                                        //status = 1 Confirm,  2 pending
                                                        $sqlCAP = $conn->prepare("SELECT SUM(ta_amt) as taProductAmt FROM product_payout WHERE ta_id = '" . $userId . "' AND ta_status='1' ");
                                                        $sqlCAP->execute();
                                                        $sqlCAP->setFetchMode(PDO::FETCH_ASSOC);
                                                        if ($sqlCAP->rowCount() > 0) {
                                                            foreach (($sqlCAP->fetchAll()) as $key => $row) {
                                                                $ConfirmAmt = $row['taProductAmt'];
                                                            }
                                                        }
                                                        //status = 1 pending,  2 confirm
                                                        // $sqlTAP = $conn -> prepare("SELECT SUM(commision_ca) as teCommiAmt FROM ca_ta_payout WHERE corporate_agency = '".$userId."' AND status_ca = '1' ");
                                                        // $sqlTAP -> execute();
                                                        // $sqlTAP -> setFetchMode(PDO::FETCH_ASSOC);
                                                        // if( $sqlTAP -> rowCount()>0 ){
                                                        //     foreach( ( $sqlTAP -> fetchAll() ) as $key => $row ){
                                                        //         $ConfirmComm = $row['teCommiAmt'];
                                                        //     }
                                                        // }

                                                        // $AmtTotalConfirm = $ConfirmAmt + $ConfirmComm;
                                                        $tdsAmtConfirm = $ConfirmAmt * $tdsPercentage;
                                                        $walletBalConfirm = $ConfirmAmt - $tdsAmtConfirm;
                                                        $truncatedWalletBalC = floor($walletBalConfirm * 100) / 100;
                                                        $finalAmtC = number_format($truncatedWalletBalC, 2);

                                                        ?>
                                                        <h1 class="mb-0 text-white">&#8377;<?php echo $finalAmtC; ?></h1>
                                                    </div>
                                                </div>
                                                <div class="d-flex justify-content-between">
                                                    <p class="text-white">Pending</p>
                                                    <p class="text-white">&#8377;<?php echo $finalAmtP; ?></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Customer cu1, cu2, cu3 payout calculation -->
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="card">
                                                
                                                <?php
                                                    require 'connect.php';

                                                    $cuponstmt = $conn->prepare("SELECT * FROM cu_coupons WHERE user_id = :id");
                                                    $cuponstmt->execute(['id' => $userId]);
                                                    $cupon = $cuponstmt->fetch(PDO::FETCH_ASSOC);
                                                    
                                                    // to get the query ouput in console
                                                    // $debugQuery = "SELECT * FROM cu_coupons WHERE user_id = '" . $userId."'";
                                                    
                                                    // echo '<script>console.log("Prepared Query: ' . $debugQuery . '");</script>';
                                                    
                                                    // echo '<script>console.log("Coupon:", ' . json_encode($cupon) . ');</script>';
                                                    
                                                    if ($cupon) {
                                                ?>
                                                <div class="card-body p-0">
                                                    <div class="card-body p-3">
                                                        <div class="alert alert-success" role="alert">
                                                            <i data-feather="check-circle" class="text-success me-2 icon-sm"></i>
                                                            Congratulations! You are a <b>Prime Member</b>.
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <div class="px-3">
                                                            <img src="assets/images/user-illustarator-2.png" class="img-fluid" alt="">
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php
                                                    } else {
                                                ?>
                                                <div class="card-body p-0">
                                                    <div class="alert alert-warning border-0 rounded-0 m-0 d-flex align-items-center" role="alert">
                                                        <i data-feather="alert-triangle" class="text-warning me-2 icon-sm"></i>
                                                        <div class="flex-grow-1 text-truncate">
                                                            Upgrade to prime membership.
                                                        </div>
                                                        <!-- <div class="flex-shrink-0">
                                                            <a href="pages-pricing.html" class="text-reset text-decoration-underline"><b>Upgrade</b></a>
                                                        </div> -->
                                                    </div>

                                                    <div class="row align-items-end">
                                                        <div class="col-sm-8">
                                                            <div class="p-3">
                                                                <p class="fs-16 lh-base">Unlock more value – <span class="fw-semibold">Upgrade now</span> to become a <span class="fw-semibold">Prime Customer!</span> Enjoy exclusive benefits, faster support, and premium features tailored just for you.</p>
                                                                <!--<div class="mt-3">-->
                                                                <!--    <a href="pages-pricing.html" class="btn btn-success waves-effect waves-light">Upgrade</a>-->
                                                                <!--</div>-->
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <div class="px-3">
                                                                <img src="assets/images/user-illustarator-2.png" class="img-fluid" alt="">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div> <!-- end card-body-->
                                                <?php
                                                    }
                                                ?>
                                            </div>
                                        </div> <!-- end col-->
                                    </div> <!-- end row-->
                                <?php } ?>

                                <?php if ($userType == '11') { ?> <!--travel Agent => 11  -->

                                    <!-- New Card Template Start -->
                                    <div class="row">
                                        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-12">
                                            <div class="card rounded-3 pt-3 pb-2 px-4 cardBg1">
                                                <div>
                                                    <p class="text-white fw-bold">Registered Customer</p>
                                                </div>
                                                <div class="d-flex justify-content-between align-items-center mb-1">
                                                    <span class="">
                                                        <i class="fa-regular fa-user fa-2xl" style="color: #ffffff;"></i>
                                                    </span>
                                                    <div class="ms-4">
                                                        <?php
                                                        $sql3 = "SELECT COUNT(ca_customer_id) as id FROM ca_customer WHERE ta_reference_no = '" . $userId . "' AND status = '1'";
                                                        $stmt3 = $conn->prepare($sql3);
                                                        $stmt3->execute();
                                                        $stmt3->setFetchMode(PDO::FETCH_ASSOC);
                                                        if ($stmt3->rowCount() > 0) {
                                                            foreach (($stmt3->fetchAll()) as $key => $row) {
                                                                $id = $row['id'];
                                                                echo '<h1 class="mb-0 text-white">' . $id . '</h1>';
                                                            }
                                                        }
                                                        ?>
                                                    </div>
                                                </div>
                                                <div class="d-flex justify-content-between">
                                                    <p class="text-white">This Month</p>
                                                    <?php
                                                    $sql3 = "SELECT COUNT(ca_customer_id) as id FROM ca_customer WHERE ta_reference_no = '" . $userId . "' AND YEAR(register_date) = '" . $DateYear . "' AND MONTH(register_date) = '" . $DateMonth . "'  AND status = '1'";
                                                    $stmt3 = $conn->prepare($sql3);
                                                    $stmt3->execute();
                                                    $stmt3->setFetchMode(PDO::FETCH_ASSOC);
                                                    if ($stmt3->rowCount() > 0) {
                                                        foreach (($stmt3->fetchAll()) as $key => $row) {
                                                            $id2 = $row['id'];
                                                            echo '<p class="text-white">' . $id2 . '</p>';
                                                        }
                                                    }
                                                    ?>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-12">
                                            <div class="card rounded-3 pt-3 pb-2 px-4 cardBg2">
                                                <div>
                                                    <p class="text-white fw-bold">Completed Tours</p>
                                                </div>
                                                <div class="d-flex justify-content-between align-items-center mb-1">
                                                    <span class="">
                                                        <i class="fa-regular fa-map fa-2xl" style="color: #ffffff;"></i>
                                                    </span>
                                                    <div class="ms-4">
                                                        <?php
                                                        $stmt = $conn->prepare("SELECT COUNT(ta_id) as completedTour FROM product_payout WHERE ta_id = ? AND end_date < NOW()");
                                                        $stmt->execute([$userId]);
                                                        $stmt->setFetchMode(PDO::FETCH_ASSOC);
                                                        if ($stmt->rowCount() > 0) {
                                                            foreach (($stmt->fetchAll()) as $key => $row) {
                                                                $completedTour = $row['completedTour'];
                                                                echo '<h1 class="mb-0 text-white">' . $completedTour . '</h1>';
                                                            }
                                                        }
                                                        ?>

                                                    </div>
                                                </div>
                                                <div class="d-flex justify-content-between">
                                                    <p class="text-white">This Month</p>
                                                    <?php
                                                    $stmt = $conn->prepare("SELECT COUNT(ta_id) as completedTourThisMonth FROM product_payout WHERE ta_id = ? AND end_date < NOW() AND  YEAR(end_date) = '" . $DateYear . "' AND MONTH(end_date) = '" . $DateMonth . "'");
                                                    $stmt->execute([$userId]);
                                                    $stmt->setFetchMode(PDO::FETCH_ASSOC);
                                                    if ($stmt->rowCount() > 0) {
                                                        foreach (($stmt->fetchAll()) as $key => $row) {
                                                            $completedTourThisMonth = $row['completedTourThisMonth'];
                                                            echo '<p class="text-white">' . $completedTourThisMonth . '</p>';
                                                        }
                                                    }
                                                    ?>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-12">
                                            <div class="card rounded-3 pt-3 pb-2 px-4 cardBg3">
                                                <div>
                                                    <p class="text-white fw-bold">Upcoming Tours</p>
                                                </div>
                                                <div class="d-flex justify-content-between align-items-center mb-1">
                                                    <span class="">
                                                        <i class="fa-solid fa-clock-rotate-left fa-2xl" style="color: #ffffff;"></i>
                                                    </span>
                                                    <div class="ms-4">
                                                        <?php
                                                        $stmt = $conn->prepare("SELECT COUNT(ta_id) as upcomingTour FROM product_payout WHERE ta_id = ? AND start_date > NOW()");
                                                        $stmt->execute([$userId]);
                                                        $stmt->setFetchMode(PDO::FETCH_ASSOC);
                                                        if ($stmt->rowCount() > 0) {
                                                            foreach (($stmt->fetchAll()) as $key => $row) {
                                                                $upcomingTour = $row['upcomingTour'];
                                                                echo '<h1 class="mb-0 text-white">' . $upcomingTour . '</h1>';
                                                            }
                                                        }
                                                        ?>
                                                    </div>
                                                </div>
                                                <div class="d-flex justify-content-between">
                                                    <p class="text-white">This Month</p>
                                                    <?php
                                                    $stmt = $conn->prepare("SELECT COUNT(ta_id) as upcomingTourThisMonth FROM product_payout WHERE ta_id = ? AND start_date > NOW() AND  YEAR(start_date) = '" . $DateYear . "' AND MONTH(start_date) = '" . $DateMonth . "'");
                                                    $stmt->execute([$userId]);
                                                    $stmt->setFetchMode(PDO::FETCH_ASSOC);
                                                    if ($stmt->rowCount() > 0) {
                                                        foreach (($stmt->fetchAll()) as $key => $row) {
                                                            $upcomingTourThisMonth = $row['upcomingTourThisMonth'];
                                                            echo '<p class="text-white">' . $upcomingTourThisMonth . '</p>';
                                                        }
                                                    }
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-12">
                                            <div class="card rounded-3 pt-3 pb-2 px-4 cardBg4">
                                                <div>
                                                    <p class="text-white fw-bold">Commission Earned</p>
                                                </div>
                                                <div class="d-flex justify-content-between align-items-center mb-1">
                                                    <span class="">
                                                        <i class="fa-regular fa-money-bill-1 fa-2xl" style="color: #ffffff;"></i>
                                                    </span>
                                                    <div class="ms-4">

                                                        <?php

                                                        //pending amount
                                                        //status = 1 Confirm,  2 pending
                                                        $sqlCAP = $conn->prepare("SELECT SUM(ta_amt) as taProductAmt FROM product_payout WHERE ta_id = '" . $userId . "' AND ta_status='2' ");
                                                        $sqlCAP->execute();
                                                        $sqlCAP->setFetchMode(PDO::FETCH_ASSOC);
                                                        if ($sqlCAP->rowCount() > 0) {
                                                            foreach (($sqlCAP->fetchAll()) as $key => $row) {
                                                                $PendingAmt = $row['taProductAmt'];
                                                            }
                                                        }
                                                        //status = 1 pending,  2 confirm
                                                        // $sqlTAP = $conn -> prepare("SELECT SUM(commision_ca) as teCommiAmt FROM ca_ta_payout WHERE corporate_agency = '".$userId."' AND status_ca = '2' ");
                                                        // $sqlTAP -> execute();
                                                        // $sqlTAP -> setFetchMode(PDO::FETCH_ASSOC);
                                                        // if( $sqlTAP -> rowCount()>0 ){
                                                        //     foreach( ( $sqlTAP -> fetchAll() ) as $key => $row ){
                                                        //         $PendingComm = $row['teCommiAmt'];
                                                        //     }
                                                        // }

                                                        // $AmtTotalPending = $PendingAmt + $PendingComm;
                                                        $tdsAmtPending = $PendingAmt * $tdsPercentage;
                                                        $walletBalPending = $PendingAmt - $tdsAmtPending;
                                                        $truncatedWalletBalP = floor($walletBalPending * 100) / 100;
                                                        $finalAmtP = number_format($truncatedWalletBalP, 2);

                                                        //confirm amount
                                                        //status = 1 Confirm,  2 pending
                                                        $sqlCAP = $conn->prepare("SELECT SUM(ta_amt) as taProductAmt FROM product_payout WHERE ta_id = '" . $userId . "' AND ta_status='1' ");
                                                        $sqlCAP->execute();
                                                        $sqlCAP->setFetchMode(PDO::FETCH_ASSOC);
                                                        if ($sqlCAP->rowCount() > 0) {
                                                            foreach (($sqlCAP->fetchAll()) as $key => $row) {
                                                                $ConfirmAmt = $row['taProductAmt'];
                                                            }
                                                        }
                                                        //status = 1 pending,  2 confirm
                                                        // $sqlTAP = $conn -> prepare("SELECT SUM(commision_ca) as teCommiAmt FROM ca_ta_payout WHERE corporate_agency = '".$userId."' AND status_ca = '1' ");
                                                        // $sqlTAP -> execute();
                                                        // $sqlTAP -> setFetchMode(PDO::FETCH_ASSOC);
                                                        // if( $sqlTAP -> rowCount()>0 ){
                                                        //     foreach( ( $sqlTAP -> fetchAll() ) as $key => $row ){
                                                        //         $ConfirmComm = $row['teCommiAmt'];
                                                        //     }
                                                        // }

                                                        // $AmtTotalConfirm = $ConfirmAmt + $ConfirmComm;
                                                        $tdsAmtConfirm = $ConfirmAmt * $tdsPercentage;
                                                        $walletBalConfirm = $ConfirmAmt - $tdsAmtConfirm;
                                                        $truncatedWalletBalC = floor($walletBalConfirm * 100) / 100;
                                                        $finalAmtC = number_format($truncatedWalletBalC, 2);

                                                        ?>
                                                        <h1 class="mb-0 text-white">&#8377;<?php echo $finalAmtC; ?></h1>
                                                    </div>
                                                </div>
                                                <div class="d-flex justify-content-between">
                                                    <p class="text-white">Pending</p>
                                                    <p class="text-white">&#8377;<?php echo $finalAmtP; ?></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- New Card Template end -->

                                <?php } ?>

                                <?php if ($userType == '16') { ?> <!--Corporate Agency => 16 -->

                                    <!-- New Card Template Start -->
                                    <div class="row">

                                        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12">
                                            <div class="card rounded-3 pt-3 pb-2 px-4 cardBg1">
                                                <div>
                                                    <p class="text-white fw-bold">Travel Consultant</p>
                                                </div>
                                                <div class="d-flex justify-content-between align-items-center mb-1">
                                                    <span class="">
                                                        <i class="fa-regular fa-user fa-2xl" style="color: #ffffff;"></i>
                                                    </span>
                                                    <div class="ms-4">
                                                        <?php
                                                        $sql3 = "SELECT COUNT(ca_travelagency_id) as id FROM ca_travelagency WHERE reference_no = '" . $userId . "' AND status = '1'";
                                                        $stmt3 = $conn->prepare($sql3);
                                                        $stmt3->execute();
                                                        $stmt3->setFetchMode(PDO::FETCH_ASSOC);
                                                        if ($stmt3->rowCount() > 0) {
                                                            foreach (($stmt3->fetchAll()) as $key => $row) {
                                                                $id = $row['id'];
                                                                echo '<h1 class="mb-0 text-white">' . $id . '</h1>';
                                                            }
                                                        }
                                                        ?>
                                                        <!-- <h1 class="mb-0 text-white">486</h1> -->
                                                    </div>
                                                </div>
                                                <div class="d-flex justify-content-between">
                                                    <p class="text-white">This Month</p>
                                                    <?php
                                                    $sql3 = "SELECT COUNT(ca_travelagency_id) as id FROM ca_travelagency WHERE reference_no = '" . $userId . "' AND user_type = '11' AND YEAR(register_date) = '" . $DateYear . "' AND MONTH(register_date) = '" . $DateMonth . "' AND status = '1'";
                                                    $stmt3 = $conn->prepare($sql3);
                                                    $stmt3->execute();
                                                    $stmt3->setFetchMode(PDO::FETCH_ASSOC);
                                                    if ($stmt3->rowCount() > 0) {
                                                        foreach (($stmt3->fetchAll()) as $key => $row) {
                                                            $id = $row['id'];
                                                            echo '<p class="text-white">' . $id . '</p>';
                                                        }
                                                    }
                                                    ?>

                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12">
                                            <div class="card rounded-3 pt-3 pb-2 px-4 cardBg2">
                                                <div>
                                                    <p class="text-white fw-bold">Customers</p>
                                                </div>
                                                <div class="d-flex justify-content-between align-items-center mb-1">
                                                    <span class="">
                                                        <i class="fa-regular fa-user fa-2xl" style="color: #ffffff;"></i>
                                                    </span>
                                                    <div class="ms-4">
                                                        <?php
                                                        $stmt2 = $conn->prepare("SELECT * FROM `ca_travelagency` WHERE reference_no = ? ");
                                                        $stmt2->execute([$userId]);
                                                        $referrals = $stmt2->fetchAll(PDO::FETCH_ASSOC);

                                                        $count = 0; // Initialize count

                                                        foreach ($referrals as $referral) {
                                                            $userCA = $referral['ca_travelagency_id'];

                                                            $stmt4 = $conn->prepare("SELECT ca_customer_id FROM ca_customer WHERE ta_reference_no = ? AND status = '1'");
                                                            $stmt4->execute([$referral['ca_travelagency_id']]);
                                                            $stmt4->setFetchMode(PDO::FETCH_ASSOC);
                                                            if ($stmt4->rowCount() > 0) {
                                                                foreach (($stmt4->fetchAll()) as $userCATAs => $userCATA) {
                                                                    $userTA = $userCATA['ca_customer_id'] . ' ';
                                                                    $count++; // Increment count for each ca_travelagency_id
                                                                } //CATA foreach ends
                                                            } //CATA if loop ends
                                                        } //CA foreach ends 

                                                        echo '<h1 class="mb-0 text-white">' . $count . '</h1>';
                                                        ?>
                                                    </div>
                                                </div>
                                                <div class="d-flex justify-content-between">
                                                    <p class="text-white">This Month</p>
                                                    <?php
                                                    $stmt2 = $conn->prepare("SELECT * FROM `ca_travelagency` WHERE reference_no = ? AND user_type = '11'  ");
                                                    $stmt2->execute([$userId]);
                                                    $referrals = $stmt2->fetchAll(PDO::FETCH_ASSOC);

                                                    $count2 = 0; // Initialize count

                                                    foreach ($referrals as $referral) {
                                                        $userBM = $referral['ca_travelagency_id'];

                                                        $stmt4 = $conn->prepare("SELECT ca_customer_id FROM ca_customer WHERE ta_reference_no = ? AND YEAR(register_date) = '" . $DateYear . "' AND MONTH(register_date) = '" . $DateMonth . "' AND status = '1'");
                                                        $stmt4->execute([$userBM]);
                                                        $stmt4->setFetchMode(PDO::FETCH_ASSOC);
                                                        if ($stmt4->rowCount() > 0) {
                                                            foreach (($stmt4->fetchAll()) as $userTEs => $userTE) {
                                                                $userTECHNO = $userTE['ca_customer_id'] . ' ';
                                                                $count2++; // Increment count for each ca_travelagency_id
                                                            } //CATA foreach ends
                                                        } //CATA if loop ends
                                                    } //CA foreach ends 
                                                    echo '<p class="text-white"> ' . $count2 . '</p>';
                                                    ?>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12">
                                            <div class="card rounded-3 pt-3 pb-2 px-4 cardBg4">
                                                <div>
                                                    <p class="text-white fw-bold">Commission Earned</p>
                                                </div>
                                                <div class="d-flex justify-content-between align-items-center mb-1">
                                                    <span class="">
                                                        <i class="fa-regular fa-money-bill-1 fa-2xl" style="color: #ffffff;"></i>
                                                    </span>
                                                    <?php

                                                    //pending amount
                                                    //status = 1 Confirm,  2 pending
                                                    $sqlCAP = $conn->prepare("SELECT SUM(te_amt) as teProductAmt FROM product_payout WHERE te_id = '" . $userId . "' AND te_status='2' ");
                                                    $sqlCAP->execute();
                                                    $sqlCAP->setFetchMode(PDO::FETCH_ASSOC);
                                                    if ($sqlCAP->rowCount() > 0) {
                                                        foreach (($sqlCAP->fetchAll()) as $key => $row) {
                                                            $PendingAmt = $row['teProductAmt'];
                                                        }
                                                    }
                                                    //status = 1 pending,  2 confirm
                                                    $sqlTAP = $conn->prepare("SELECT SUM(commision_te) as teCommiAmt FROM ca_ta_payout WHERE techno_enterprise = '" . $userId . "' AND status_te = '2' ");
                                                    $sqlTAP->execute();
                                                    $sqlTAP->setFetchMode(PDO::FETCH_ASSOC);
                                                    if ($sqlTAP->rowCount() > 0) {
                                                        foreach (($sqlTAP->fetchAll()) as $key => $row) {
                                                            $PendingComm = $row['teCommiAmt'];
                                                        }
                                                    }

                                                    $AmtTotalPending = $PendingAmt + $PendingComm;
                                                    $tdsAmtPending = $AmtTotalPending * $tdsPercentage;
                                                    $walletBalPending = $AmtTotalPending - $tdsAmtPending;
                                                    $truncatedWalletBalP = floor($walletBalPending * 100) / 100;
                                                    $finalAmtP = number_format($truncatedWalletBalP, 2);

                                                    //confirm amount
                                                    //status = 1 Confirm,  2 pending
                                                    $sqlCAP = $conn->prepare("SELECT SUM(te_amt) as teProductAmt FROM product_payout WHERE te_id = '" . $userId . "' AND te_status='1' ");
                                                    $sqlCAP->execute();
                                                    $sqlCAP->setFetchMode(PDO::FETCH_ASSOC);
                                                    if ($sqlCAP->rowCount() > 0) {
                                                        foreach (($sqlCAP->fetchAll()) as $key => $row) {
                                                            $ConfirmAmt = $row['teProductAmt'];
                                                        }
                                                    }
                                                    //status = 1 pending,  2 confirm
                                                    $sqlTAP = $conn->prepare("SELECT SUM(commision_te) as teCommiAmt FROM ca_ta_payout WHERE techno_enterprise = '" . $userId . "' AND status_te = '1' ");
                                                    $sqlTAP->execute();
                                                    $sqlTAP->setFetchMode(PDO::FETCH_ASSOC);
                                                    if ($sqlTAP->rowCount() > 0) {
                                                        foreach (($sqlTAP->fetchAll()) as $key => $row) {
                                                            $ConfirmComm = $row['teCommiAmt'];
                                                        }
                                                    }

                                                    $AmtTotalConfirm = $ConfirmAmt + $ConfirmComm;
                                                    $tdsAmtConfirm = $AmtTotalConfirm * $tdsPercentage;
                                                    $walletBalConfirm = $AmtTotalConfirm - $tdsAmtConfirm;
                                                    $truncatedWalletBalC = floor($walletBalConfirm * 100) / 100;
                                                    $finalAmtC = number_format($truncatedWalletBalC, 2);


                                                    ?>
                                                    <div class="ms-4">
                                                        <h1 class="mb-0 text-white">&#8377;<?php echo $finalAmtC  ?></h1>
                                                    </div>
                                                </div>
                                                <div class="d-flex justify-content-between">
                                                    <p class="text-white">Pending</p>
                                                    <p class="text-white">&#8377;<?php echo $finalAmtP; ?></p>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <!-- New Card Template end -->

                                <?php } ?>

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

                                <?php if ($userType == '24') { ?> <!--Business Channel manager => 24   -->

                                    <!-- New Card Template Start -->
                                    <div class="row">

                                        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12">
                                            <div class="card rounded-3 pt-3 pb-2 px-4 cardBg1">
                                                <div>
                                                    <p class="text-white fw-bold">Business Development Manager</p>
                                                </div>
                                                <div class="d-flex justify-content-between align-items-center mb-1">
                                                    <span class="">
                                                        <i class="fa-regular fa-user fa-2xl" style="color: #ffffff;"></i>
                                                    </span>
                                                    <div class="ms-4">
                                                        <?php
                                                        $sql3 = "SELECT COUNT(employee_id) as id FROM employees WHERE reporting_manager = '" . $userId . "' AND user_type = '25' AND status = '1'";
                                                        $stmt3 = $conn->prepare($sql3);
                                                        $stmt3->execute();
                                                        $stmt3->setFetchMode(PDO::FETCH_ASSOC);
                                                        if ($stmt3->rowCount() > 0) {
                                                            foreach (($stmt3->fetchAll()) as $key => $row) {
                                                                $id = $row['id'];
                                                                echo '<h1 class="mb-0 text-white">' . $id . '</h1>';
                                                            }
                                                        }
                                                        ?>
                                                        <!-- <h1 class="mb-0 text-white">486</h1> -->
                                                    </div>
                                                </div>
                                                <div class="d-flex justify-content-between">
                                                    <p class="text-white">This Month</p>
                                                    <?php
                                                    $sql3 = "SELECT COUNT(employee_id) as id FROM employees WHERE reporting_manager = '" . $userId . "' AND user_type = '25' AND YEAR(register_date) = '" . $DateYear . "' AND MONTH(register_date) = '" . $DateMonth . "' AND status = '1'";
                                                    $stmt3 = $conn->prepare($sql3);
                                                    $stmt3->execute();
                                                    $stmt3->setFetchMode(PDO::FETCH_ASSOC);
                                                    if ($stmt3->rowCount() > 0) {
                                                        foreach (($stmt3->fetchAll()) as $key => $row) {
                                                            $id = $row['id'];
                                                            echo '<p class="text-white">' . $id . '</p>';
                                                        }
                                                    }
                                                    ?>

                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12">
                                            <div class="card rounded-3 pt-3 pb-2 px-4 cardBg2">
                                                <div>
                                                    <p class="text-white fw-bold">Business Mentor</p>
                                                </div>
                                                <div class="d-flex justify-content-between align-items-center mb-1">
                                                    <span class="">
                                                        <i class="fa-regular fa-user fa-2xl" style="color: #ffffff;"></i>
                                                    </span>
                                                    <div class="ms-4">
                                                        <?php
                                                        $sql3 = "SELECT COUNT(business_mentor_id) as id FROM business_mentor WHERE reference_no = '" . $userId . "' AND user_type = '26' AND status = '1'";
                                                        $stmt3 = $conn->prepare($sql3);
                                                        $stmt3->execute();
                                                        $stmt3->setFetchMode(PDO::FETCH_ASSOC);
                                                        if ($stmt3->rowCount() > 0) {
                                                            foreach (($stmt3->fetchAll()) as $key => $row) {
                                                                $id = $row['id'];
                                                                echo '<h1 class="mb-0 text-white">' . $id . '</h1>';
                                                            }
                                                        }
                                                        ?>
                                                        <!-- <h1 class="mb-0 text-white">486</h1> -->
                                                    </div>
                                                </div>
                                                <div class="d-flex justify-content-between">
                                                    <p class="text-white">This Month</p>
                                                    <?php
                                                    $sql3 = "SELECT COUNT(business_mentor_id) as id FROM business_mentor WHERE reference_no = '" . $userId . "' AND user_type = '26' AND YEAR(register_date) = '" . $DateYear . "' AND MONTH(register_date) = '" . $DateMonth . "' AND status = '1'";
                                                    $stmt3 = $conn->prepare($sql3);
                                                    $stmt3->execute();
                                                    $stmt3->setFetchMode(PDO::FETCH_ASSOC);
                                                    if ($stmt3->rowCount() > 0) {
                                                        foreach (($stmt3->fetchAll()) as $key => $row) {
                                                            $id = $row['id'];
                                                            echo '<p class="text-white">' . $id . '</p>';
                                                        }
                                                    }
                                                    ?>

                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12">
                                            <div class="card rounded-3 pt-3 pb-2 px-4 cardBg4">
                                                <div>
                                                    <p class="text-white fw-bold">Commission Earned</p>
                                                </div>
                                                <div class="d-flex justify-content-between align-items-center mb-1">
                                                    <span class="">
                                                        <i class="fa-regular fa-money-bill-1 fa-2xl" style="color: #ffffff;"></i>
                                                    </span>
                                                    <?php

                                                    //pending amount
                                                    //status = 1 Confirm,  2 pending
                                                    $sqlCAP = $conn->prepare("SELECT SUM(bch_amt) as bchProductAmt FROM product_payout WHERE bch_id = '" . $userId . "' AND bch_status='2' ");
                                                    $sqlCAP->execute();
                                                    $sqlCAP->setFetchMode(PDO::FETCH_ASSOC);
                                                    if ($sqlCAP->rowCount() > 0) {
                                                        foreach (($sqlCAP->fetchAll()) as $key => $row) {
                                                            $PendingAmt = $row['bchProductAmt'];
                                                        }
                                                    }
                                                    //status = 1 pending,  2 confirm
                                                    $sqlTAP = $conn->prepare("SELECT SUM(payout_amount) as bchSlabAmt FROM bcm_payout_history WHERE bcm_user_id = '" . $userId . "' AND payout_status = '1' ");
                                                    $sqlTAP->execute();
                                                    $sqlTAP->setFetchMode(PDO::FETCH_ASSOC);
                                                    if ($sqlTAP->rowCount() > 0) {
                                                        foreach (($sqlTAP->fetchAll()) as $key => $row) {
                                                            $PendingComm = $row['bchSlabAmt'];
                                                        }
                                                    }

                                                    $AmtTotalPending = $PendingAmt + $PendingComm;
                                                    $tdsAmtPending = $AmtTotalPending * $tdsPercentage;
                                                    $walletBalPending = $AmtTotalPending - $tdsAmtPending;
                                                    $truncatedWalletBalP = floor($walletBalPending * 100) / 100;
                                                    $finalAmtP = number_format($truncatedWalletBalP, 2);

                                                    //confirm amount
                                                    //status = 1 Confirm,  2 pending
                                                    $sqlCAP2 = $conn->prepare("SELECT SUM(bch_amt) as bchProductAmt FROM product_payout WHERE bch_id = '" . $userId . "' AND bch_status='1' ");
                                                    $sqlCAP2->execute();
                                                    $sqlCAP2->setFetchMode(PDO::FETCH_ASSOC);
                                                    if ($sqlCAP2->rowCount() > 0) {
                                                        foreach (($sqlCAP2->fetchAll()) as $key => $row) {
                                                            $ConfirmAmt = $row['bchProductAmt'];
                                                        }
                                                    }
                                                    //status = 1 pending,  2 confirm
                                                    $sqlTAP2 = $conn->prepare("SELECT SUM(payout_amount) as bchSlabAmt FROM bcm_payout_history WHERE bcm_user_id = '" . $userId . "' AND payout_status = '2' ");
                                                    $sqlTAP2->execute();
                                                    $sqlTAP2->setFetchMode(PDO::FETCH_ASSOC);
                                                    if ($sqlTAP2->rowCount() > 0) {
                                                        foreach (($sqlTAP2->fetchAll()) as $key => $row) {
                                                            $ConfirmComm = $row['bchSlabAmt'];
                                                        }
                                                    }

                                                    $AmtTotalConfirm = $ConfirmAmt + $ConfirmComm;
                                                    $tdsAmtConfirm = $AmtTotalConfirm * $tdsPercentage;
                                                    $walletBalConfirm = $AmtTotalConfirm - $tdsAmtConfirm;
                                                    $truncatedWalletBalC = floor($walletBalConfirm * 100) / 100;
                                                    $finalAmtC = number_format($truncatedWalletBalC, 2);

                                                    ?>
                                                    <div class="ms-4">
                                                        <h1 class="mb-0 text-white">&#8377;<?php echo $finalAmtC  ?></h1>
                                                    </div>
                                                </div>
                                                <div class="d-flex justify-content-between">
                                                    <p class="text-white">Pending</p>
                                                    <p class="text-white">&#8377;<?php echo $finalAmtP; ?></p>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <!-- New Card Template end -->

                                <?php } ?>

                                <?php if ($userType == '25') { ?> <!--Business Development manager => 25   -->

                                    <!-- New Card Template Start -->
                                    <div class="row">

                                        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12">
                                            <div class="card rounded-3 pt-3 pb-2 px-4 cardBg1">
                                                <div>
                                                    <p class="text-white fw-bold">Business Mentor</p>
                                                </div>
                                                <div class="d-flex justify-content-between align-items-center mb-1">
                                                    <span class="">
                                                        <i class="fa-regular fa-user fa-2xl" style="color: #ffffff;"></i>
                                                    </span>
                                                    <div class="ms-4">
                                                        <?php
                                                        $sql3 = "SELECT COUNT(business_mentor_id) as id FROM business_mentor WHERE reference_no = '" . $userId . "' AND user_type = '26' AND status = '1'";
                                                        $stmt3 = $conn->prepare($sql3);
                                                        $stmt3->execute();
                                                        $stmt3->setFetchMode(PDO::FETCH_ASSOC);
                                                        if ($stmt3->rowCount() > 0) {
                                                            foreach (($stmt3->fetchAll()) as $key => $row) {
                                                                $id = $row['id'];
                                                                echo '<h1 class="mb-0 text-white">' . $id . '</h1>';
                                                            }
                                                        }
                                                        ?>
                                                        <!-- <h1 class="mb-0 text-white">486</h1> -->
                                                    </div>
                                                </div>
                                                <div class="d-flex justify-content-between">
                                                    <p class="text-white">This Month</p>
                                                    <?php
                                                    $sql3 = "SELECT COUNT(business_mentor_id) as id FROM business_mentor WHERE reference_no = '" . $userId . "' AND user_type = '26' AND YEAR(register_date) = '" . $DateYear . "' AND MONTH(register_date) = '" . $DateMonth . "' AND status = '1'";
                                                    $stmt3 = $conn->prepare($sql3);
                                                    $stmt3->execute();
                                                    $stmt3->setFetchMode(PDO::FETCH_ASSOC);
                                                    if ($stmt3->rowCount() > 0) {
                                                        foreach (($stmt3->fetchAll()) as $key => $row) {
                                                            $id = $row['id'];
                                                            echo '<p class="text-white">' . $id . '</p>';
                                                        }
                                                    }
                                                    ?>

                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12">
                                            <div class="card rounded-3 pt-3 pb-2 px-4 cardBg2">
                                                <div>
                                                    <p class="text-white fw-bold">Techno Enterprise</p>
                                                </div>
                                                <div class="d-flex justify-content-between align-items-center mb-1">
                                                    <span class="">
                                                        <i class="fa-regular fa-user fa-2xl" style="color: #ffffff;"></i>
                                                    </span>
                                                    <div class="ms-4">
                                                        <?php
                                                        $stmt2 = $conn->prepare("SELECT * FROM `business_mentor` WHERE reference_no = ? AND user_type = '26' ");
                                                        $stmt2->execute([$userId]);
                                                        $referrals = $stmt2->fetchAll(PDO::FETCH_ASSOC);

                                                        $count = 0; // Initialize count

                                                        foreach ($referrals as $referral) {
                                                            $userBM = $referral['business_mentor_id'];

                                                            $stmt4 = $conn->prepare("SELECT corporate_agency_id FROM corporate_agency WHERE reference_no = ?");
                                                            $stmt4->execute([$userBM]);
                                                            $stmt4->setFetchMode(PDO::FETCH_ASSOC);
                                                            if ($stmt4->rowCount() > 0) {
                                                                foreach (($stmt4->fetchAll()) as $userTEs => $userTE) {
                                                                    $userTECHNO = $userTE['corporate_agency_id'] . ' ';
                                                                    $count++; // Increment count for each ca_travelagency_id
                                                                } //CATA foreach ends
                                                            } //CATA if loop ends
                                                        } //CA foreach ends 
                                                        echo '<h1 class="mb-0 text-white"> ' . $count . '</h1>';
                                                        ?>
                                                    </div>
                                                </div>
                                                <div class="d-flex justify-content-between">
                                                    <p class="text-white">This Month</p>
                                                    <?php
                                                    $stmt2 = $conn->prepare("SELECT * FROM `business_mentor` WHERE reference_no = ? AND user_type = '26'  ");
                                                    $stmt2->execute([$userId]);
                                                    $referrals = $stmt2->fetchAll(PDO::FETCH_ASSOC);

                                                    $count = 0; // Initialize count

                                                    foreach ($referrals as $referral) {
                                                        $userBM = $referral['business_mentor_id'];

                                                        $stmt4 = $conn->prepare("SELECT corporate_agency_id FROM corporate_agency WHERE reference_no = ? AND YEAR(register_date) = '" . $DateYear . "' AND MONTH(register_date) = '" . $DateMonth . "' AND status = '1' ");
                                                        $stmt4->execute([$userBM]);
                                                        $stmt4->setFetchMode(PDO::FETCH_ASSOC);
                                                        if ($stmt4->rowCount() > 0) {
                                                            foreach (($stmt4->fetchAll()) as $userTEs => $userTE) {
                                                                $userTECHNO = $userTE['corporate_agency_id'] . ' ';
                                                                $count++; // Increment count for each ca_travelagency_id
                                                            } //CATA foreach ends
                                                        } //CATA if loop ends
                                                    } //CA foreach ends 
                                                    echo '<p class="text-white"> ' . $count . '</p>';
                                                    ?>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12">
                                            <div class="card rounded-3 pt-3 pb-2 px-4 cardBg4">
                                                <div>
                                                    <p class="text-white fw-bold">Commission Earned</p>
                                                </div>
                                                <div class="d-flex justify-content-between align-items-center mb-1">
                                                    <span class="">
                                                        <i class="fa-regular fa-money-bill-1 fa-2xl" style="color: #ffffff;"></i>
                                                    </span>
                                                    <?php

                                                    //pending amount
                                                    //status = 1 Confirm,  2 pending
                                                    $sqlCAP = $conn->prepare("SELECT SUM(bdm_amt) as bdmProductAmt FROM product_payout WHERE bdm_id = '" . $userId . "' AND bdm_status='2' ");
                                                    $sqlCAP->execute();
                                                    $sqlCAP->setFetchMode(PDO::FETCH_ASSOC);
                                                    if ($sqlCAP->rowCount() > 0) {
                                                        foreach (($sqlCAP->fetchAll()) as $key => $row) {
                                                            $PendingAmt = $row['bdmProductAmt'];
                                                        }
                                                    }
                                                    //status = 1 pending,  2 confirm
                                                    $sqlTAP = $conn->prepare("SELECT SUM(payout_amount) as bdmSlabAmt FROM bdm_payout_history WHERE bdm_user_id = '" . $userId . "' AND payout_status = '1' ");
                                                    $sqlTAP->execute();
                                                    $sqlTAP->setFetchMode(PDO::FETCH_ASSOC);
                                                    if ($sqlTAP->rowCount() > 0) {
                                                        foreach (($sqlTAP->fetchAll()) as $key => $row) {
                                                            $PendingComm = $row['bdmSlabAmt'];
                                                        }
                                                    }

                                                    $AmtTotalPending = $PendingAmt + $PendingComm;
                                                    $tdsAmtPending = $AmtTotalPending * $tdsPercentage;
                                                    $walletBalPending = $AmtTotalPending - $tdsAmtPending;
                                                    $truncatedWalletBalP = floor($walletBalPending * 100) / 100;
                                                    $finalAmtP = number_format($truncatedWalletBalP, 2);

                                                    //confirm amount
                                                    //status = 1 Confirm,  2 pending
                                                    $sqlCAP2 = $conn->prepare("SELECT SUM(bdm_amt) as bdmProductAmt FROM product_payout WHERE bdm_id = '" . $userId . "' AND bdm_status='1' ");
                                                    $sqlCAP2->execute();
                                                    $sqlCAP2->setFetchMode(PDO::FETCH_ASSOC);
                                                    if ($sqlCAP2->rowCount() > 0) {
                                                        foreach (($sqlCAP2->fetchAll()) as $key => $row) {
                                                            $ConfirmAmt = $row['bdmProductAmt'];
                                                        }
                                                    }
                                                    //status = 1 pending,  2 confirm
                                                    $sqlTAP2 = $conn->prepare("SELECT SUM(payout_amount) as bdmSlabAmt FROM bdm_payout_history WHERE bdm_user_id = '" . $userId . "' AND payout_status = '2' ");
                                                    $sqlTAP2->execute();
                                                    $sqlTAP2->setFetchMode(PDO::FETCH_ASSOC);
                                                    if ($sqlTAP2->rowCount() > 0) {
                                                        foreach (($sqlTAP2->fetchAll()) as $key => $row) {
                                                            $ConfirmComm = $row['bdmSlabAmt'];
                                                        }
                                                    }

                                                    $AmtTotalConfirm = $ConfirmAmt + $ConfirmComm;
                                                    $tdsAmtConfirm = $AmtTotalConfirm * $tdsPercentage;
                                                    $walletBalConfirm = $AmtTotalConfirm - $tdsAmtConfirm;
                                                    $truncatedWalletBalC = floor($walletBalConfirm * 100) / 100;
                                                    $finalAmtC = number_format($truncatedWalletBalC, 2);

                                                    ?>
                                                    <div class="ms-4">
                                                        <h1 class="mb-0 text-white">&#8377;<?php echo $finalAmtC  ?></h1>
                                                    </div>
                                                </div>
                                                <div class="d-flex justify-content-between">
                                                    <p class="text-white">Pending</p>
                                                    <p class="text-white">&#8377;<?php echo $finalAmtP; ?></p>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <!-- New Card Template end -->

                                <?php } ?>

                                <?php if ($userType == '26') { ?> <!--Business Mentor => 26   -->

                                    <!-- New Card Template Start -->
                                    <div class="row">

                                        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12">
                                            <div class="card rounded-3 pt-3 pb-2 px-4 cardBg1">
                                                <div>
                                                    <p class="text-white fw-bold">Techno Enterprise</p>
                                                </div>
                                                <div class="d-flex justify-content-between align-items-center mb-1">
                                                    <span class="">
                                                        <i class="fa-regular fa-user fa-2xl" style="color: #ffffff;"></i>
                                                    </span>
                                                    <div class="ms-4">
                                                        <?php
                                                        $sql3 = "SELECT COUNT(corporate_agency_id) as id FROM corporate_agency WHERE reference_no = '" . $userId . "' AND user_type = '16' AND status = '1'";
                                                        $stmt3 = $conn->prepare($sql3);
                                                        $stmt3->execute();
                                                        $stmt3->setFetchMode(PDO::FETCH_ASSOC);
                                                        if ($stmt3->rowCount() > 0) {
                                                            foreach (($stmt3->fetchAll()) as $key => $row) {
                                                                $id = $row['id'];
                                                                echo '<h1 class="mb-0 text-white">' . $id . '</h1>';
                                                            }
                                                        }
                                                        ?>
                                                        <!-- <h1 class="mb-0 text-white">486</h1> -->
                                                    </div>
                                                </div>
                                                <div class="d-flex justify-content-between">
                                                    <p class="text-white">This Month</p>
                                                    <?php
                                                    $sql3 = "SELECT COUNT(corporate_agency_id) as id FROM corporate_agency WHERE reference_no = '" . $userId . "' AND user_type = '16' AND YEAR(register_date) = '" . $DateYear . "' AND MONTH(register_date) = '" . $DateMonth . "' AND status = '1'";
                                                    $stmt3 = $conn->prepare($sql3);
                                                    $stmt3->execute();
                                                    $stmt3->setFetchMode(PDO::FETCH_ASSOC);
                                                    if ($stmt3->rowCount() > 0) {
                                                        foreach (($stmt3->fetchAll()) as $key => $row) {
                                                            $id = $row['id'];
                                                            echo '<p class="text-white">' . $id . '</p>';
                                                        }
                                                    }
                                                    ?>

                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12">
                                            <div class="card rounded-3 pt-3 pb-2 px-4 cardBg2">
                                                <div>
                                                    <p class="text-white fw-bold">Travel Consultant</p>
                                                </div>
                                                <div class="d-flex justify-content-between align-items-center mb-1">
                                                    <span class="">
                                                        <i class="fa-regular fa-user fa-2xl" style="color: #ffffff;"></i>
                                                    </span>
                                                    <div class="ms-4">
                                                        <?php
                                                        $stmt2 = $conn->prepare("SELECT * FROM `corporate_agency` WHERE reference_no = ? AND user_type = '16' ");
                                                        $stmt2->execute([$userId]);
                                                        $referrals = $stmt2->fetchAll(PDO::FETCH_ASSOC);

                                                        $count = 0; // Initialize count

                                                        foreach ($referrals as $referral) {
                                                            $userTE = $referral['corporate_agency_id'];

                                                            $stmt4 = $conn->prepare("SELECT ca_travelagency_id FROM ca_travelagency WHERE reference_no = ? AND status = '1'");
                                                            $stmt4->execute([$userTE]);
                                                            $stmt4->setFetchMode(PDO::FETCH_ASSOC);
                                                            if ($stmt4->rowCount() > 0) {
                                                                foreach (($stmt4->fetchAll()) as $userTEs => $userTE) {
                                                                    $userTECHNO = $userTE['ca_travelagency_id'] . ' ';
                                                                    $count++; // Increment count for each ca_travelagency_id
                                                                } //CATA foreach ends
                                                            } //CATA if loop ends
                                                        } //CA foreach ends 

                                                        echo '<h1 class="mb-0 text-white">' . $count . '</h1>';
                                                        ?>
                                                    </div>
                                                </div>
                                                <div class="d-flex justify-content-between">
                                                    <p class="text-white">This Month</p>
                                                    <?php
                                                    $stmt2 = $conn->prepare("SELECT * FROM `corporate_agency` WHERE reference_no = ? AND user_type = '16'  ");
                                                    $stmt2->execute([$userId]);
                                                    $referrals = $stmt2->fetchAll(PDO::FETCH_ASSOC);

                                                    $count = 0; // Initialize count

                                                    foreach ($referrals as $referral) {
                                                        $userBM = $referral['corporate_agency_id'];

                                                        $stmt4 = $conn->prepare("SELECT ca_travelagency_id FROM ca_travelagency WHERE reference_no = ? AND YEAR(register_date) = '" . $DateYear . "' AND MONTH(register_date) = '" . $DateMonth . "' AND status = '1'");
                                                        $stmt4->execute([$userBM]);
                                                        $stmt4->setFetchMode(PDO::FETCH_ASSOC);
                                                        if ($stmt4->rowCount() > 0) {
                                                            foreach (($stmt4->fetchAll()) as $userTEs => $userTE) {
                                                                $userTECHNO = $userTE['ca_travelagency_id'] . ' ';
                                                                $count++; // Increment count for each ca_travelagency_id
                                                            } //CATA foreach ends
                                                        } //CATA if loop ends
                                                    } //CA foreach ends 
                                                    echo '<p class="text-white"> ' . $count . '</p>';
                                                    ?>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12">
                                            <div class="card rounded-3 pt-3 pb-2 px-4 cardBg4">
                                                <div>
                                                    <p class="text-white fw-bold">Commission Earned</p>
                                                </div>
                                                <div class="d-flex justify-content-between align-items-center mb-1">
                                                    <span class="">
                                                        <i class="fa-regular fa-money-bill-1 fa-2xl" style="color: #ffffff;"></i>
                                                    </span>
                                                    <?php

                                                    //pending amount
                                                    //status = 1 Confirm,  2 pending
                                                    $sqlCAP = $conn->prepare("SELECT SUM(bm_amt) as bmProductAmt FROM product_payout WHERE bm_id = '" . $userId . "' AND bm_status='2' ");
                                                    $sqlCAP->execute();
                                                    $sqlCAP->setFetchMode(PDO::FETCH_ASSOC);
                                                    if ($sqlCAP->rowCount() > 0) {
                                                        foreach (($sqlCAP->fetchAll()) as $key => $row) {
                                                            $PendingAmt = $row['bmProductAmt'];
                                                        }
                                                    }
                                                    //status = 1 pending,  2 confirm
                                                    $sqlTAP = $conn->prepare("SELECT SUM(payout_amount) as bmSlabAmt FROM bm_payout_history WHERE bm_user_id = '" . $userId . "' AND payout_status = '1' ");
                                                    $sqlTAP->execute();
                                                    $sqlTAP->setFetchMode(PDO::FETCH_ASSOC);
                                                    if ($sqlTAP->rowCount() > 0) {
                                                        foreach (($sqlTAP->fetchAll()) as $key => $row) {
                                                            $PendingComm = $row['bmSlabAmt'];
                                                        }
                                                    }

                                                    $AmtTotalPending = $PendingAmt + $PendingComm;
                                                    $tdsAmtPending = $AmtTotalPending * $tdsPercentage;
                                                    $walletBalPending = $AmtTotalPending - $tdsAmtPending;
                                                    $truncatedWalletBalP = floor($walletBalPending * 100) / 100;
                                                    $finalAmtP = number_format($truncatedWalletBalP, 2);

                                                    //confirm amount
                                                    //status = 1 Confirm,  2 pending
                                                    $sqlCAP2 = $conn->prepare("SELECT SUM(bm_amt) as bmProductAmt FROM product_payout WHERE bm_id = '" . $userId . "' AND bm_status='1' ");
                                                    $sqlCAP2->execute();
                                                    $sqlCAP2->setFetchMode(PDO::FETCH_ASSOC);
                                                    if ($sqlCAP2->rowCount() > 0) {
                                                        foreach (($sqlCAP2->fetchAll()) as $key => $row) {
                                                            $ConfirmAmt = $row['bmProductAmt'];
                                                        }
                                                    }
                                                    //status = 1 pending,  2 confirm
                                                    $sqlTAP2 = $conn->prepare("SELECT SUM(payout_amount) as bmSlabAmt FROM bm_payout_history WHERE bm_user_id = '" . $userId . "' AND payout_status = '2' ");
                                                    $sqlTAP2->execute();
                                                    $sqlTAP2->setFetchMode(PDO::FETCH_ASSOC);
                                                    if ($sqlTAP2->rowCount() > 0) {
                                                        foreach (($sqlTAP2->fetchAll()) as $key => $row) {
                                                            $ConfirmComm = $row['bmSlabAmt'];
                                                        }
                                                    }

                                                    $AmtTotalConfirm = $ConfirmAmt + $ConfirmComm;
                                                    $tdsAmtConfirm = $AmtTotalConfirm * $tdsPercentage;
                                                    $walletBalConfirm = $AmtTotalConfirm - $tdsAmtConfirm;
                                                    $truncatedWalletBalC = floor($walletBalConfirm * 100) / 100;
                                                    $finalAmtC = number_format($truncatedWalletBalC, 2);


                                                    ?>
                                                    <div class="ms-4">
                                                        <h1 class="mb-0 text-white">&#8377;<?php echo $finalAmtC  ?></h1>
                                                    </div>
                                                </div>
                                                <div class="d-flex justify-content-between">
                                                    <p class="text-white">Pending</p>
                                                    <p class="text-white">&#8377;<?php echo $finalAmtP; ?></p>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <!-- New Card Template end -->

                                <?php } ?>

                                <!-- progress Bar -->
                                <?php if ($userType == '11' || $userType == '16') { ?>
                                    <div class="container-message">
                                        <div class="card p-3">
                                            <div class="row d-flex justify-content-center">
                                                <div class="col-12">
                                                    <ul id="progressbar" class="text-center">
                                                        <li class="step0 step1"></li>
                                                        <li class="step0 step2"></li>
                                                        <li class="step0 step3"></li>
                                                        <li class="step0 step4"></li>
                                                        <li class="step0 step5"></li>
                                                        <li class="step0 step6"></li>
                                                        <li class="step0 step7"></li>
                                                        <li class="step0 step8"></li>
                                                        <li class="step0 step9"></li>
                                                        <li class="step0 step10"></li>
                                                    </ul>
                                                </div>
                                                <div class="card-body" id="messageContent">
                                                    <p class="pgbar1 d-none" id="pgbar1">1<sup>st</sup> milestone achieved long way to go.</p>
                                                    <p class="pgbar2 d-none" id="pgbar2">2<sup>nd</sup> milestone achieved still a long journey ahead.</p>
                                                    <p class="pgbar3 d-none" id="pgbar3">On track keep up the good work.</p>
                                                    <p class="pgbar4 d-none" id="pgbar4">Accomplished nearly half way there.</p>
                                                    <p class="pgbar5 d-none" id="pgbar5">50% achieved Excellent progress.</p>
                                                    <p class="pgbar6 d-none" id="pgbar6">Completed approaching the final stretch.</p>
                                                    <p class="pgbar7 d-none" id="pgbar7">Almost there keep pushing.</p>
                                                    <p class="pgbar8 d-none" id="pgbar8">Very close to your target keep going strongly.</p>
                                                    <p class="pgbar9 d-none" id="pgbar9">A step ahead</p>
                                                    <p class="pgbar10 d-none" id="pgbar10">Congratulation !! <br /> <span class="fs-5">On achieving your target well done.</span></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>

                                <!-- !-- Line Chart and top 5 user table -->
                                <?php if ($userType == '3' || $userType == '11' || $userType == '16' || $userType == '26' || $userType == '25' || $userType == '24') { ?>
                                    <div class="row">
                                        <!-- Line Chart -->
                                        <div class="col-xl-6 col-md-12 col-sm-12">
                                            <div class="card">
                                                <div class="card-header">
                                                    <h4 class="card-title mb-0">Line Chart</h4>
                                                </div>
                                                <div class="card-body">
                                                    <!-- <canvas id="lineChart" class="chartjs-chart" data-colors='["--vz-primary-rgb, 0.2", "--vz-primary", "--vz-success-rgb, 0.2", "--vz-success"]'></canvas> -->
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div style="float:right; padding: 10px 10px 10px 10px; font-weight:bold; margin-top: -50px; ">
                                                                <span>
                                                                    Select Year
                                                                    <select id="years" onchange="getMonthlyUserData(this.value)"></select>
                                                                </span>
                                                            </div>

                                                            <div class="table-responsive table-desi">
                                                                <canvas id="myChart" style="width:100%;max-width:1000px"></canvas>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div> <!-- end col -->
                                        <div style="display: none">
                                            <input type="month" id="month_year" value="" min="2020-01" max="">
                                        </div>
                                        <!-- Top Customers  Active / Inactive User Count -->
                                        <div class="col-xl-6 col-md-12 col-sm-12">
                                            <div class="card">
                                                <div class="card-header align-items-center d-flex">
                                                    <?php
                                                    if ($userType == "3") {
                                                        $topCustomerTableName = "Corporate Agency";
                                                        $topCustomerTableRefCol = "TA";
                                                    } else if ($userType == "16") {
                                                        $topCustomerTableName = "Travel Agency";
                                                        $topCustomerTableRefCol = "CU";
                                                    } else if ($userType == "11") {
                                                        $topCustomerTableName = "Customers";
                                                        $topCustomerTableRefCol = "CU";
                                                    } else if ($userType == "18") {
                                                        $topCustomerTableName = "Business Consultant";
                                                        $topCustomerTableRefCol = "BC";
                                                    } else if ($userType == "10") { //customer can bring customer thay why $topCustomerTableName value is "Customer"
                                                        $topCustomerTableName = "Customers";
                                                        $topCustomerTableRefCol = "CU";
                                                    } else if ($userType == "19") {
                                                        $topCustomerTableName = "Business Operation Executive";
                                                        $topCustomerTableRefCol = "BOE";
                                                    } else if ($userType == "20") {
                                                        $topCustomerTableName = "Training Manager";
                                                        $topCustomerTableRefCol = "TM";
                                                    } else if ($userType == "21") {
                                                        $topCustomerTableName = "Sales Executive";
                                                        $topCustomerTableRefCol = "SE";
                                                    } else if ($userType == "24") {
                                                        $topCustomerTableName = "Business Development Manager";
                                                        $topCustomerTableRefCol = "BDM";
                                                    } else if ($userType == "25") {
                                                        $topCustomerTableName = "Business Mentor";
                                                        $topCustomerTableRefCol = "BM";
                                                    } else if ($userType == "26") {
                                                        $topCustomerTableName = "Corporate Agency";
                                                        $topCustomerTableRefCol = "TA";
                                                    }
                                                    ?>
                                                    <h4 class="card-title mb-0 flex-grow-1">Top <?php echo $topCustomerTableName; ?></h4>
                                                    <!-- <div class="flex-shrink-0">
                                                            <button type="button" class="btn btn-soft-info btn-sm">
                                                                <i class="ri-file-list-3-line align-bottom"></i> Download
                                                            </button>
                                                        </div> -->
                                                </div><!-- end card header -->

                                                <div class="card-body">
                                                    <div class="table-responsive table-card">
                                                        <table class="table table-borderless table-centered align-middle table-nowrap mb-0">
                                                            <thead class="text-muted table-light">
                                                                <tr>
                                                                    <th scope="col">ID</th>
                                                                    <th scope="col">Name</th>
                                                                    <th scope="col">Date Reg</th>
                                                                    <th scope="col">Status</th>
                                                                    <th scope="col">Total <?php echo $topCustomerTableRefCol; ?> Ref</th>
                                                                    <th scope="col">Active/ Inactive</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php
                                                                // business_consultant
                                                                if ($userType == '3') {
                                                                    $tableName1 = 'corporate_agency';
                                                                    $tableId1 = 'corporate_agency_id';
                                                                    $tableNameDesignation = 'Corporate Agency';
                                                                    $tableName2 = 'ca_travelagency';
                                                                    $tableId2 = 'ca_travelagency_id';
                                                                    $tableColumnName = 'reference_no';
                                                                    $tableColumnName2 = 'reference_no';
                                                                }
                                                                // corporate_agency
                                                                if ($userType == '16') {
                                                                    $tableName1 = 'ca_travelagency';
                                                                    $tableId1 = 'ca_travelagency_id';
                                                                    $tableNameDesignation = 'Travel Agency';
                                                                    $tableName2 = 'ca_customer';
                                                                    $tableId2 = 'ca_customer_id';
                                                                    $tableColumnName = 'reference_no';
                                                                    $tableColumnName2 = 'ta_reference_no';
                                                                }
                                                                // travel_agent
                                                                if ($userType == '11') {
                                                                    $tableName1 = 'ca_customer';
                                                                    $tableId1 = 'ca_customer_id';
                                                                    $tableNameDesignation = 'Customer';
                                                                    $tableName2 = 'ca_customer';
                                                                    $tableId2 = 'ca_customer_id';
                                                                    $tableColumnName = 'ta_reference_no';
                                                                    $tableColumnName2 = 'reference_no';
                                                                }
                                                                // customer
                                                                if ($userType == '10') {
                                                                    $tableName1 = 'ca_customer';
                                                                    $tableId1 = 'ca_customer_id';
                                                                    $tableNameDesignation = 'Customer';
                                                                    $tableName2 = 'ca_customer';
                                                                    $tableId2 = 'ca_customer_id';
                                                                    $tableColumnName = 'reference_no';
                                                                    $tableColumnName2 = 'reference_no';
                                                                }
                                                                // channel_business_director
                                                                if ($userType == '18') {
                                                                    $tableName1 = 'business_consultant';
                                                                    $tableId1 = 'business_consultant_id';
                                                                    $tableNameDesignation = 'Business Consultant';
                                                                    $tableName2 = 'corporate_agency';
                                                                    $tableId2 = 'corporate_agency_id';
                                                                    $tableColumnName = 'reference_no';
                                                                    $tableColumnName2 = 'reference_no';
                                                                }
                                                                // CA Franchisee
                                                                if ($userType == '19') {
                                                                    $tableName1 = 'business_operation_executive';
                                                                    $tableId1 = 'business_operation_executive_id';
                                                                    $tableNameDesignation = 'Business Operation Executive';
                                                                    $tableName2 = 'training_manager';
                                                                    $tableId2 = 'training_manager_id';
                                                                    $tableColumnName = 'reference_no';
                                                                    $tableColumnName2 = 'reference_no';
                                                                }
                                                                // Business Operation Executive
                                                                if ($userType == '20') {
                                                                    $tableName1 = 'training_manager';
                                                                    $tableId1 = 'training_manager_id';
                                                                    $tableNameDesignation = 'Training Manager';
                                                                    $tableName2 = 'sales_executive';
                                                                    $tableId2 = 'sales_executive_id';
                                                                    $tableColumnName = 'reference_no';
                                                                    $tableColumnName2 = 'reference_no';
                                                                }
                                                                // Training Manager table 2's id and name put proper 
                                                                if ($userType == '21') {
                                                                    $tableName1 = 'sales_executive';
                                                                    $tableId1 = 'sales_executive_id';
                                                                    $tableNameDesignation = 'Sales Executive';
                                                                    $tableName2 = 'sales_executive';
                                                                    $tableId2 = 'sales_executive_id';
                                                                    $tableColumnName = 'reference_no';
                                                                    $tableColumnName2 = 'reference_no';
                                                                }
                                                                // Business Channel manager
                                                                if ($userType == '24') {
                                                                    $tableName1 = 'employees'; //BDM
                                                                    $tableId1 = 'employee_id'; //BDM ID
                                                                    $tableNameDesignation = 'Business Development Manager';
                                                                    $tableName2 = 'business_mentor';
                                                                    $tableId2 = 'business_mentor_id';
                                                                    $tableColumnName = 'reporting_manager';
                                                                    $tableColumnName2 = 'reference_no';
                                                                }
                                                                // Business Development manager
                                                                if ($userType == '25') {
                                                                    $tableName1 = 'business_mentor'; //TE
                                                                    $tableId1 = 'business_mentor_id'; //TE ID
                                                                    $tableNameDesignation = 'Business Development Manager';
                                                                    $tableName2 = 'corporate_agency';
                                                                    $tableId2 = 'corporate_agency_id';
                                                                    $tableColumnName = 'reference_no';
                                                                    $tableColumnName2 = 'reference_no';
                                                                }
                                                                // Business Mentor
                                                                if ($userType == '26') {
                                                                    $tableName1 = 'corporate_agency'; //BDM
                                                                    $tableId1 = 'corporate_agency_id'; //BDM ID
                                                                    $tableNameDesignation = 'Corporate Agency';
                                                                    $tableName2 = 'ca_travelagency';
                                                                    $tableId2 = 'ca_travelagency_id';
                                                                    $tableColumnName = 'reference_no';
                                                                    $tableColumnName2 = 'reference_no';
                                                                }
                                                                // 21-02-2025 work from here for other 2 users BDM, BM, add user_type for all users - giving problem for BCH and BDM.

                                                                $stmt2 = $conn->prepare("SELECT * FROM $tableName1 WHERE $tableColumnName = ? order by $tableId1 desc limit 5");
                                                                $stmt2->execute([$userId]);
                                                                $referrals = $stmt2->fetchAll(PDO::FETCH_ASSOC);

                                                                $count = 0; // Initialize count
                                                                $activeCount = 0; // Initialize count
                                                                $inactiveCount = 0; // Initialize count

                                                                foreach ($referrals as $referral) {

                                                                    $rd = new DateTime($referral['register_date']);
                                                                    $rdate = $rd->format('d-m-Y');
                                                                    $id = $referral[$tableId1];
                                                                    if ($userType == '24') {
                                                                        $firstName = $referral['name'];
                                                                        $lastName = ' ';
                                                                    } else {
                                                                        $firstName = $referral['firstname'];
                                                                        $lastName = $referral['lastname'];
                                                                    }


                                                                    $status = $referral['status'];

                                                                    // Total Count Loop End $count
                                                                    $stmt4 = $conn->prepare("SELECT $tableId2 FROM $tableName2 WHERE $tableColumnName2 = ? ");
                                                                    $stmt4->execute([$referral[$tableId1]]);
                                                                    $stmt4->setFetchMode(PDO::FETCH_ASSOC);
                                                                    if ($stmt4->rowCount() > 0) {
                                                                        foreach (($stmt4->fetchAll()) as $userCATAs => $userCATA) {
                                                                            // $userTA = $userCATA['ca_travelagency_id'].' ';
                                                                            $count++; // Increment count for each ca_travelagency_id
                                                                        } //CATA foreach ends
                                                                    } //CATA if loop ends

                                                                    // Active Count Loop End $activeCount
                                                                    $stmt4 = $conn->prepare("SELECT $tableId2 FROM $tableName2 WHERE $tableColumnName2 = ? AND status='1' ");
                                                                    $stmt4->execute([$referral[$tableId1]]);
                                                                    $stmt4->setFetchMode(PDO::FETCH_ASSOC);
                                                                    if ($stmt4->rowCount() > 0) {
                                                                        foreach (($stmt4->fetchAll()) as $userCATAs => $userCATA) {
                                                                            // $userTA = $userCATA['ca_travelagency_id'].' ';
                                                                            $activeCount++; // Increment count for each ca_travelagency_id
                                                                        } //CATA foreach ends
                                                                    } //CATA if loop ends

                                                                    // Inactive Count Loop End $inactiveCount
                                                                    $stmt4 = $conn->prepare("SELECT $tableId2 FROM $tableName2 WHERE $tableColumnName2 = ? AND status='2' ");
                                                                    $stmt4->execute([$referral[$tableId1]]);
                                                                    $stmt4->setFetchMode(PDO::FETCH_ASSOC);
                                                                    if ($stmt4->rowCount() > 0) {
                                                                        foreach (($stmt4->fetchAll()) as $userCATAs => $userCATA) {
                                                                            // $userTA = $userCATA['ca_travelagency_id'].' ';
                                                                            $inactiveCount++; // Increment count for each ca_travelagency_id
                                                                        } //CATA foreach ends
                                                                    } //CATA if loop ends

                                                                    echo '<tr>
                                                                                <td>' . $id . '</td>
                                                                                <td>' . $firstName . ' ' . $lastName . '</td>
                                                                                <td>' . $rdate . '</td>';
                                                                    if ($status == "1") {
                                                                        echo '<td><span class="badge bg-success-subtle text-success">Acive</span></td>';
                                                                    } else {
                                                                        echo '<td><span class="badge bg-danger-subtle text-danger">Inacive</span></td>';
                                                                    }
                                                                    echo '<td class="text-center">' . $count . '</td>
                                                                                <td class="text-center">
                                                                                    <span class="badge bg-success-subtle text-success">' . $activeCount . '</span> /
                                                                                    <span class="badge bg-danger-subtle text-danger">' . $inactiveCount . '</span>
                                                                                </td>
                                                                            </tr>';

                                                                    $count = 0; // reInitialize count
                                                                    $activeCount = 0; // reInitialize count
                                                                    $inactiveCount = 0; // reInitialize count

                                                                } //CA foreach ends 
                                                                ?>
                                                            </tbody><!-- end tbody -->
                                                        </table><!-- end table -->
                                                    </div>
                                                </div>
                                            </div> <!-- .card-->
                                        </div> <!-- .col-->
                                    </div><!-- end row-->
                                <?php } ?>

                                <?php if (!$userType == "19" || !$userType == "24" || !$userType == "25" || !$userType == "26") { ?>
                                    <!-- recent booking full table  -->
                                    <div class="row">
                                        <div class="col-xxl-12 col-md-12 col-sm-12">
                                            <div class="card">
                                                <div class="card-header align-items-center d-flex">
                                                    <h4 class="card-title mb-0 flex-grow-1">Recent Bookings</h4>
                                                    <div class="flex-shrink-0">
                                                        <!-- <button type="button" class="btn btn-soft-info btn-sm">
                                                            <i class="ri-file-list-3-line align-bottom"></i> Download
                                                        </button> -->
                                                    </div>
                                                </div><!-- end card header -->

                                                <div class="card-body">
                                                    <div class="table-responsive table-card">
                                                        <table class="table table-borderless table-centered align-middle table-nowrap mb-0">
                                                            <thead class="text-muted table-light">
                                                                <tr>
                                                                    <th scope="col">Order ID</th>
                                                                    <th scope="col">Product Name</th>
                                                                    <th scope="col">Destination</th>
                                                                    <th scope="col">Travel Date</th>
                                                                    <th scope="col">Booking Date</th>
                                                                    <th scope="col">Amount</th>
                                                                    <th scope="col">Payment Status</th>
                                                                    <th scope="col">Status</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php
                                                                $sqlBooking = "SELECT * FROM bookings WHERE customer_id = 'CU2200131' ";
                                                                $booking = $conn->prepare($sqlBooking);
                                                                $booking->execute();
                                                                $booking->setFetchMode(PDO::FETCH_ASSOC);
                                                                if ($booking->rowCount() > 0) {
                                                                    foreach (($booking->fetchAll()) as $key => $row) {
                                                                        $packageName = $row['package_id'];
                                                                        echo '
                                                                                <tr>
                                                                                    <td>' . $row['id'] . '</td>
                                                                                    <td>
                                                                                        <div class="d-flex align-items-center">
                                                                                            <div class="flex-shrink-0 me-2">
                                                                                                <img src="assets/images/users/avatar-1.jpg" alt="" class="avatar-xs rounded-circle" />
                                                                                            </div>
                                                                                            <div class="flex-grow-1">Nicholas Ball</div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>China</td>
                                                                                    <td><span>15-12-2023</span></td>
                                                                                    <td>10-12-2023</td>
                                                                                    <td><span>&#8377 2000</span></td>
                                                                                    <td><h5 class="fs-14 fw-medium mb-0">5.0<span class="text-muted fs-11 ms-1">(245 Rating)</span></h5></td>
                                                                                    <td><span class="badge bg-success-subtle text-success">Completed</span></td>
                                                                                </tr>
                                                                            ';
                                                                    }
                                                                }
                                                                ?>

                                                            </tbody><!-- end tbody -->
                                                        </table><!-- end table -->
                                                    </div>
                                                </div>
                                            </div> <!-- .card-->

                                        </div>
                                    </div><!-- end row-->
                                <?php } ?>

                                <!-- top customer engagment -->
                                <div class="row">
                                    <div class="card">
                                        <div class="card-header">
                                            <div class="d-flex align-items-center">
                                                <h6 class="card-title mb-0 flex-grow-1">Popular Candidates</h6>
                                                <!-- <div class="flex-shrink-0">
                                                        <a href="apps-job-candidate-lists.html" class="link-primary">View All <i class="ri-arrow-right-line"></i></a>
                                                    </div> -->
                                            </div>
                                        </div>
                                        <div class="row g-0">
                                            <div class="col-lg-6">
                                                <div class="card-body border-end">
                                                    <div class="search-box">
                                                        <input type="text" class="form-control bg-light border-light" autocomplete="off" id="searchList" placeholder="Search candidate...">
                                                        <i class="ri-search-line search-icon"></i>
                                                    </div>
                                                    <div data-simplebar style="max-height: 190px" class="px-3 mx-n3">
                                                        <ul class="list-unstyled mb-0 pt-2" id="candidate-list">
                                                            <?php
                                                            // business_consultant
                                                            if ($userType == '3') {
                                                                $tableName = 'corporate_agency';
                                                                $tableId = 'corporate_agency_id';
                                                                $tableNameDesignation = 'Corporate Agency';
                                                                $tableColumn = 'reference_no';
                                                            }
                                                            // corporate_agency
                                                            if ($userType == '16') {
                                                                $tableName = 'ca_travelagency';
                                                                $tableId = 'ca_travelagency_id';
                                                                $tableNameDesignation = 'Travel Agency';
                                                                $tableColumn = 'reference_no';
                                                            }
                                                            // travel_agent
                                                            if ($userType == '11') {
                                                                $tableName = 'ca_customer';
                                                                $tableId = 'ca_customer_id';
                                                                $tableNameDesignation = 'Customer';
                                                                $tableColumn = 'ta_reference_no';
                                                            }
                                                            // customer
                                                            if ($userType == '10') {
                                                                $tableName = 'ca_customer';
                                                                $tableId = 'ca_customer_id';
                                                                $tableNameDesignation = 'Customer';
                                                                $tableColumn = 'reference_no';
                                                            }
                                                            // channel_business_director
                                                            if ($userType == '18') {
                                                                $tableName = 'business_consultant';
                                                                $tableId = 'business_consultant_id';
                                                                $tableNameDesignation = 'Business Consultant';
                                                                $tableColumn = 'reference_no';
                                                            }
                                                            // CA Franchisee
                                                            if ($userType == '19') {
                                                                $tableName = 'business_operation_executive';
                                                                $tableId = 'business_operation_executive_id';
                                                                $tableNameDesignation = 'Business Operation Executive';
                                                                $tableColumn = 'reference_no';
                                                            }
                                                            // Business Operation Executive
                                                            if ($userType == '20') {
                                                                $tableName = 'training_manager';
                                                                $tableId = 'training_manager_id';
                                                                $tableNameDesignation = 'Training Manager';
                                                                $tableColumn = 'reference_no';
                                                            }
                                                            // Training Manager
                                                            if ($userType == '21') {
                                                                $tableName = 'sales_executive';
                                                                $tableId = 'sales_executive_id';
                                                                $tableNameDesignation = 'Sales Executive';
                                                                $tableColumn = 'reference_no';
                                                            }
                                                            // Sales Executive not set for ref table dummy name and id added
                                                            if ($userType == '22') {
                                                                $tableName = 'business_operation_executive';
                                                                $tableId = 'business_operation_executive_id';
                                                                $tableNameDesignation = 'Business Operation Executive';
                                                                $tableColumn = 'reference_no';
                                                            }
                                                            //Business Channel manager
                                                            if ($userType == '24') {
                                                                $tableName = 'employees';
                                                                $tableId = 'employee_id';
                                                                $tableNameDesignation = 'Business Development Manager';
                                                                $tableColumn = 'reporting_manager';
                                                            }
                                                            //Business Development manager
                                                            if ($userType == '25') {
                                                                $tableName = 'business_mentor';
                                                                $tableId = 'business_mentor_id';
                                                                $tableNameDesignation = 'Business Mentor';
                                                                $tableColumn = 'reference_no';
                                                            }
                                                            //Business Mentor
                                                            if ($userType == '26') {
                                                                $tableName = 'corporate_agency';
                                                                $tableId = 'corporate_agency_id';
                                                                $tableNameDesignation = 'Corporate Agency';
                                                                $tableColumn = 'reference_no';
                                                            }

                                                            $sqlCandidates = "SELECT * FROM $tableName WHERE $tableColumn = '$userId' AND status = '1' ";
                                                            $candidates = $conn->prepare($sqlCandidates);
                                                            $candidates->execute();
                                                            $candidates->setFetchMode(PDO::FETCH_ASSOC);
                                                            if ($candidates->rowCount() > 0) {
                                                                foreach (($candidates->fetchAll()) as $key => $row) {
                                                                    if ($userType == '24') {
                                                                        $fname = $row['name'];
                                                                        $lname = '';
                                                                    } else {
                                                                        $fname = $row['firstname'];
                                                                        $lname = $row['lastname'];
                                                                    }

                                                                    echo '
                                                                                <li>
                                                                                    <a href="javascript:void(0);" class="d-flex align-items-center py-2">
                                                                                        <div class="flex-shrink-0 me-2">
                                                                                            <div class="avatar-xs">
                                                                                                <img src="../uploading/' . $row['profile_pic'] . '" alt="" class="img-fluid rounded-circle candidate-img" style="height: 35px; width: 35px;">
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="flex-grow-1">
                                                                                            <h5 class="fs-13 mb-1 text-truncate"><span class="candidate-name">' . $fname . ' ' . $lname . '</span></h5>
                                                                                            <div class="d-none candidate-position">' . $tableNameDesignation . '</div>
                                                                                        </div>
                                                                                    </a>
                                                                                </li>
                                                                            ';
                                                                }
                                                            }
                                                            ?>


                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="card-body text-center">
                                                    <div class="avatar-md mb-4 mx-auto">
                                                        <img src="../uploading/select-user.png" alt="" id="candidate-img" class="img-thumbnail rounded-4 shadow-none" style="height: 80px; width: 80px;">
                                                    </div>

                                                    <h5 id="candidate-name" class="mt-2">----</h5>
                                                    <p id="candidate-position" class="text-muted">----</p>
                                                    <!-- <div>
                                                            <button type="button" class="btn btn-success custom-toggle w-100" data-bs-toggle="button" aria-pressed="false">
                                                                <span class="icon-on"><i class=" ri-code-view align-bottom me-1"></i> View</span>
                                                                <span class="icon-off"><i class=" ri-code-view align-bottom me-1"></i> Views</span>
                                                            </button>
                                                        </div> -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>

                    </div>


                </div> <!-- container-fluid -->

            </div><!-- End Page-content -->

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

        </div><!-- end main content-->

    </div><!-- END layout-wrapper -->

    <!--start back-to-top-->
    <button onclick="topFunction()" class="scrollToTop scroll-btn show btn" id="back-to-top">
        <i class="ri-arrow-up-line"></i>
    </button>
    <!--end back-to-top-->

    <!-- JAVASCRIPT -->
    <script src="assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/libs/simplebar/simplebar.min.js"></script>
    <script src="assets/libs/node-waves/waves.min.js"></script>
    <script src="assets/libs/feather-icons/feather.min.js"></script>
    <script src="assets/js/jquery/jquery-3.7.1.min.js"></script>
    <!-- <script src="assets/js/pages/plugins/lord-icon-2.1.0.js"></script> -->
    <!-- <script src="assets/js/plugins.js"></script> -->

    <!-- !-- materialdesign remix icon js- -->
    <script src="assets/js/pages/remix-icons-listing.js"></script>

    <!-- apexcharts -->
    <!-- <script src="assets/libs/apexcharts/apexcharts.min.js"></script> -->

    <!-- Vector map-->
    <script src="assets/libs/jsvectormap/js/jsvectormap.min.js"></script>
    <script src="assets/libs/jsvectormap/maps/world-merc.js"></script>

    <!--Swiper slider js-->
    <script src="assets/libs/swiper/swiper-bundle.min.js"></script>

    <!-- Dashboard init -->
    <!-- <script src="assets/js/pages/dashboard-ecommerce.init.js"></script> -->

    <!-- App js -->
    <script src="assets/js/app.js"></script>

    <!-- Chart JS -->
    <!-- <script src="assets/libs/chart.js/chart.umd.js"></script> -->
    <!-- chartjs init -->
    <!-- <script src="assets/js/pages/chartjs.init.js"></script> -->

    <script src="assets/libs/chart.js/Chart-2.5.0.min.js"></script>


    <!-- Dashboard init  popular candidates section js file-->
    <script src="assets/js/pages/dashboard-job.init.js"></script>

    <!-- cdn Link 
        <script src="https://cdn.jsdelivr.net/npm/js-confetti@latest/dist/js-confetti.browser.js"></script> -->
    <!-- offline file path for confetti js -->
    <script src="assets/js/js-confetti.js"></script>

    <script>
        var userType= document.getElementById("user_type").value;
        console.log('userType:'+userType);
        
        if(userType != '2' && userType != '10'){
            var count = $('#activeID').attr("data-target");
            console.log(count);
            var listItems = document.getElementById("progressbar").getElementsByTagName("li");
            var pgbar1 = document.getElementById("pgbar1");
            var pgbar2 = document.getElementById("pgbar2");
            var pgbar3 = document.getElementById("pgbar3");
            var pgbar4 = document.getElementById("pgbar4");
            var pgbar5 = document.getElementById("pgbar5");
            var pgbar6 = document.getElementById("pgbar6");
            var pgbar7 = document.getElementById("pgbar7");
            var pgbar8 = document.getElementById("pgbar8");
            var pgbar9 = document.getElementById("pgbar9");
            var pgbar10 = document.getElementById("pgbar10");
    
            for (var i = 0; i < count; i++) {
                listItems[i].className = "active";
            }
            // const div = document.querySelector('#confetti');
            if (count == 0) {
                // messageh5.className = "d-none";
            } else if (count == 1) {
                pgbar1.className = "block text-center fw-bold fs-4";
            } else if (count == 2) {
                pgbar2.className = "block text-center fw-bold fs-4";
            } else if (count == 3) {
                pgbar3.className = "block text-center fw-bold fs-4";
            } else if (count == 4) {
                pgbar4.className = "block text-center fw-bold fs-4";
            } else if (count == 5) {
                pgbar5.className = "block text-center fw-bold fs-4";
            } else if (count == 6) {
                pgbar6.className = "block text-center fw-bold fs-4";
            } else if (count == 7) {
                pgbar7.className = "block text-center fw-bold fs-4";
            } else if (count == 8) {
                pgbar8.className = "block text-center fw-bold fs-4";
            } else if (count == 9) {
                pgbar9.className = "block text-center fw-bold fs-4";
            } else if (count == 10) {
                pgbar10.className = "block text-center fw-bold fs-4";
                const jsConfetti = new JSConfetti();
                jsConfetti.addConfetti();
            } else if (count > 10) {
                alert("You have reached your maximum limit" + count);
                // messageh5.className = "d-none";
            }
    
            $(".navbar-nav .nav-item .nav-link").on("click", function() {
                $(".nav").find(".actives").removeClass("actives");
                $(this).parent().addClass("actives");
            });
        }
    </script>

    <script>
        const currentDate = new Date();
        // console.log(currentDate);
        var getCurrentYear = currentDate.getFullYear();
        // console.log(getCurrentYear);
        var getCurrentMonth = currentDate.getMonth() + 1;
        // console.log(getCurrentMonth);
        var userType, monthYear;
        // get month for input tag
        var monthControl = document.querySelector('#month_year');

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
                    $("#consultant_years").append('<option selected="selected" value="' + index + '">' + index + '</option>');
                    $("#partner_years").append('<option selected="selected" value="' + index + '">' + index + '</option>');
                } else {
                    $("#years").append('<option value="' + index + '">' + index + '</option>');
                    $("#consultant_years").append('<option value="' + index + '">' + index + '</option>');
                    $("#partner_years").append('<option value="' + index + '">' + index + '</option>');
                }
            }
            // get chart data
            getMonthlyUserData(getCurrentYear);
            // monthYear = monthControl.value;
        });

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
                    user_id: userId,
                    user_type: userType
                })
            }
            const response = await fetch('charts/chartData.php', option);
            const data = await response.json();
            console.log(data);
            length = data[0].length;
            values_ca = [];
            // values_ta = [];

            for (i = 0; i < length; i++) {
                values_ca.push(data[0][i]);
                // values_ta.push(data[1][i]);
            }
            var xValues = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
            new Chart(document.getElementById("myChart"), {
                type: 'line',
                data: {
                    labels: xValues,
                    datasets: [{
                        label: <?php echo json_encode($directNext, JSON_HEX_TAG); ?>,
                        data: values_ca,
                        borderColor: "yellow",
                        fill: true
                    }]
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
    </script>
</body>

</html>