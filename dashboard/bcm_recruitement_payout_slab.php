<?php

include_once 'dashboard_user_details.php';

// get current date to show next payout amount  and pass it in sql @ line 129
$date = date('F,Y'); //month and year. 'F' - month in Text form
$nextDateMonth = date('m'); //month in number form
$nextDateYear = date('Y'); //year
// echo "Next Date ".$date .' ;' ;
// echo "Next Month ".$nextDateMonth.' ;';
// echo "Next Year ".$nextDateYear.' ;';
// echo '<br>';

// get Previous date to show Previous payout amount  and pass it in sql @ line 111
$prevdate = date(" F,Y", strtotime("-1 months")); //month and year. 'F' - month in Text form. '-1' to get prev month
$prevDateMonth = date('m', strtotime("-1 months")); //month in number form. '-1' to get prev month
$prevDateYear = date('Y');  //Year in number form. 
//tds percentage
$tds_percentage = 2 / 100;
// echo "prev Date ".$prevdate.' ;';
// echo "prev Month ".$prevDateMonth.' ;';
// echo "prev year ".$prevDateYear.' ;';
?>

<?php if ($userType == "24") { ?>
    <!doctype html>
    <html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable">

    <head>

        <meta charset="utf-8" />
        <title>Admin Dashboard |
            Business Development Manager</title>
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

        <link href="payout/payout.css" rel="stylesheet" type="text/css" />

        <!-- DataTables -->
        <link href="assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
        <!-- Responsive datatable examples -->
        <link href="assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" href="assets/fontawesome/css/all.min.css" />
    </head>

    <body>

        <!-- Begin page -->
        <div id="layout-wrapper">

            <?php include_once 'header.php'; ?>

            <!-- removeNotificationModal -->
            <div id="removeNotificationModal" class="modal fade zoomIn" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="NotificationModalbtn-close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mt-2 text-center">
                                <lord-icon src="javascript:void(0);" trigger="loop" colors="primary:#f7b84b,secondary:#f06548" style="width:100px;height:100px"></lord-icon>
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

            <?php include_once 'sidebar.php'; ?>

            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->
            <div class="main-content">
                <div class="page-content">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="col-12"> <!-- Page title -->
                                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                        <h4 class="mb-sm-0">T.E Recruitment Payout (BCM)</h4>
                                        <div class="page-title-right">
                                            <ol class="breadcrumb m-0">
                                                <li class="breadcrumb-item">
                                                    <a href="view_business_consultant.php">View</a>
                                                </li>
                                                <li class="breadcrumb-item active">Payout</li>
                                            </ol>
                                        </div>
                                    </div>
                                </div> <!-- page title end -->
                                <div class="card">
                                    <div class="card-body">
                                        <div class="h-100">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="row d-flex justify-content-evenly">
                                                        <div class="col-lg-6 col-md-6 col-sm-6 card border-2 border-dark rounded-4">
                                                            <div class="row">
                                                                <div class="col-lg-6 col-sm-6 col-6  border-4 border-end border-end-dashed">
                                                                    <div class="m-0 mt-2 p-2 ms-n2">
                                                                        <p class="font-size-14">Previous Payout<span class="fw-bold font-size-10 ms-4"><?php echo "$prevdate" ?></span></p>
                                                                        <?php
                                                                        $previousPayout = $conn->prepare("SELECT SUM(payout_amount) as previousPayout FROM bcm_payout_history WHERE bcm_user_id = '" . $userId . "' AND YEAR(payout_date) = '" . $prevDateYear . "' AND MONTH(payout_date) = '" . $prevDateMonth . "' ");
                                                                        $previousPayout->execute();
                                                                        $previousPayout->setFetchMode(PDO::FETCH_ASSOC);
                                                                        if ($previousPayout->rowCount() > 0) {
                                                                            foreach (($previousPayout->fetchAll()) as $key => $row) {
                                                                                $previousPayout = $row['previousPayout'];
                                                                                $previousPayoutTDS = $previousPayout * $tds_percentage;
                                                                                $TotalpreviousPayout = $previousPayout - $previousPayoutTDS;
                                                                                $truncatedPrevAmount = floor($TotalpreviousPayout * 100) / 100;
                                                                                echo '<p class="fs-5 fw-bolder mt-n2">Rs. ' . number_format($truncatedPrevAmount, 2) . '/- <span class="badge bg-success font-size-10 fw-bold ms-4">Paid</span> </p>';
                                                                            }
                                                                        }
                                                                        ?>
                                                                        <a type="button" data-bs-toggle="modal" data-bs-target="#previousPayout" style=" cursor: pointer;">
                                                                            <p class="mt-n2 mb-1 fw-bold p1" style="color: #0096FF;">View Payout</p>
                                                                        </a>
                                                                        <a href="payout/forms/slab_payout_bdm/download_exel_ca.php?payoutYear=<?php echo $prevDateYear; ?>&payoutMonth=<?php echo $prevDateMonth; ?>&payoutmessage=PreviousPayout&user_id=<?php echo $userId; ?>&userType=<?php echo $userType; ?>">
                                                                            <i class="bx bx-download download-icon1" style="font-size: 20px; color: black; margin-left: 20%;"></i>
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-6 col-md-6 col-sm-6 col-6 ">
                                                                    <div class="m-0 mt-2 p-2">
                                                                        <p class="font-size-14">Next Payout<span class="fw-bold font-size-10 date-layout "><?php echo "$date" ?></span></p>
                                                                        <?php
                                                                        $nextPayout = $conn->prepare("SELECT SUM(payout_amount) as nextPayout FROM bcm_payout_history WHERE  bcm_user_id = '" . $userId . "' AND YEAR(payout_date) = '" . $nextDateYear . "' AND MONTH(payout_date) = '" . $nextDateMonth . "' AND payout_status=1 ");
                                                                        $nextPayout->execute();
                                                                        $nextPayout->setFetchMode(PDO::FETCH_ASSOC);
                                                                        if ($nextPayout->rowCount() > 0) {
                                                                            foreach (($nextPayout->fetchAll()) as $key => $row2) {
                                                                                $nextPayoutTotal = $row2['nextPayout'];
                                                                                $nextPayoutTDS = $nextPayoutTotal * $tds_percentage;
                                                                                $TotalNextPayout = $nextPayoutTotal - $nextPayoutTDS;
                                                                                $truncatedNextAmount = floor($TotalNextPayout * 100) / 100;
                                                                                echo '<p class="fs-5 fw-bolder mt-n2">Rs.' . number_format($truncatedNextAmount, 2) . '/- <span class="badge bg-warning font-size-10 fw-bold ms-4">Pending</span> </p>';
                                                                            }
                                                                        }
                                                                        ?>
                                                                        <a type="button" data-bs-toggle="modal" data-bs-target="#nextPayout" style=" cursor: pointer;">
                                                                            <p class="mt-n2 mb-1 fw-bold p1" style="color: #0096FF;">View Payout</p>
                                                                        </a>
                                                                        <a href="payout/forms/slab_payout_bdm/download_exel_ca.php?payoutYear=<?php echo $nextDateYear; ?>&payoutMonth=<?php echo $nextDateMonth; ?>&payoutmessage=NextPayout&user_id=<?php echo $userId; ?>&userType=<?php echo $userType; ?>">
                                                                            <i class="bx bx-download download-icon1" style="font-size: 20px; color: black; margin-left: 20%;"></i>
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4 col-md-4 col-sm-4 card border-2 border-dark rounded-4">
                                                            <div class="col-sm-12">
                                                                <div class="m-0 mt-2 p-2 ms-n2">
                                                                    <div class="align-middle month-format">
                                                                        <p class="font-size-14">Total Payout
                                                                        <div id="cap_text_1" class="filter-opt-4">
                                                                            <span class="font-size-10 rounded-4 d-block border-round">
                                                                                <p class="fw-bold">Select month, year <span class="bx bx-calendar-alt callogo"></span></p>
                                                                            </span>
                                                                        </div>
                                                                        <input type="month" id="month_year" value="" min="2020-01" max="" class="font-size-10 fw-bold rounded-4 d-none border-round">
                                                                        </p>
                                                                    </div>
                                                                    <?php
                                                                    $totalPayout = "SELECT SUM(payout_amount) as total_payable FROM bcm_payout_history WHERE  bcm_user_id = '" . $userId . "' ";
                                                                    $Payout = $conn->prepare($totalPayout);
                                                                    $Payout->execute();
                                                                    $Payout->setFetchMode(PDO::FETCH_ASSOC);
                                                                    if ($Payout->rowCount() > 0) {
                                                                        foreach (($Payout->fetchAll()) as $key => $row) {
                                                                            $total_payable = $row["total_payable"] ?? '0';
                                                                            $total_payableTDS = $total_payable * $tds_percentage;
                                                                            $TotalPayout = $total_payable - $total_payableTDS;
                                                                            $truncatedTotalAmount = floor($TotalPayout * 100) / 100;
                                                                            echo '<p class="fs-5 fw-bolder mt-n2 content1" id="TotalPayoutAmountDate">Rs.' . number_format($truncatedTotalAmount, 2) . '/-</p>';
                                                                        }
                                                                    }
                                                                    ?>
                                                                    <a type="button" data-bs-toggle="modal" data-bs-target="#totalPayout" style=" cursor: pointer;">
                                                                        <p class="mt-n2 mb-1 fw-bold p1" style="color: #0096FF;"> View Payout</p>
                                                                    </a>
                                                                    <i onclick="totalPayoutExel();" class="bx bx-download download-icon1" style="font-size: 20px; color: black; margin-left: 20%; cursor: pointer;"></i>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <hr style="border: 2px solid grey;">
                                                    <!-- bdm list -->
                                                    <div class="row" id="bdm_list">
                                                        <div class="col-md-12">
                                                            <div class="card rounded-4">
                                                                <div class="p-3">
                                                                    <h4>
                                                                        BDM List
                                                                    </h4>
                                                                </div>
                                                                <div class="p-3 pt-0">
                                                                    <div class="table-responsive table-desi">
                                                                        <table class="table table-hover" id="bdmTable">
                                                                            <thead class="text-center">
                                                                                <tr>
                                                                                    <th>Sr.No.</th>
                                                                                    <th>ID</th>
                                                                                    <th>Name</th>
                                                                                    <th>Active Techno Enterprise</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>

                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- bm list -->
                                                    <div class="row" id="bm_list">
                                                        <div class="col-md-12">
                                                            <div class="card rounded-4">
                                                                <div class="p-3">
                                                                    <h4>
                                                                        BM List
                                                                    </h4>
                                                                </div>
                                                                <div class="p-3 pt-0">
                                                                    <div class="table-responsive table-desi">
                                                                        <table class="table table-hover" id="bmTable">
                                                                            <thead class="text-center">
                                                                                <tr>
                                                                                    <th>Sr.No.</th>
                                                                                    <th>ID</th>
                                                                                    <th>Name</th>
                                                                                    <th>Active Techno Enterprise</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>

                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="d-sm-flex align-items-center justify-content-between">
                                                                <h2 class="mb-sm-0 fw-bolder ps-4">All Payouts</h2>
                                                            </div>
                                                        </div>
                                                        <!-- monthly user details table  -->
                                                        <div class="row" style="padding-top: 25px;" id="user-box">
                                                            <div class="col-md-12">
                                                                <!-- <div class="row">
                                                                        <hr>
                                                                        <div class="MonthlyDetailsHeading">
                                                                            <span id="table-heading" style="padding: 0px 20px; font-weight: 600; font-size: initial;"></span>
                                                                        </div>

                                                                        <div class="MonthlyDetailsHeadingClose">
                                                                            <span class="close-btn" style="float:right; padding: 0px 10px 10px 10px; font-weight: 600; font-size: initial; cursor:pointer; color:red"> X </span>
                                                                        </div>
                                                                    </div> -->
                                                                <!-- <input type="hidden" name="user_table_count" id="user_table_count" value="" /> -->
                                                                <div class="table-responsive table-desi" id="filterTable">
                                                                    <!-- table roe limit -->

                                                                    <table class="table table-hover" id="payoutDetailsTable">
                                                                        <thead>
                                                                            <tr>
                                                                                <th class="ceterText fw-bolder font-size-16">Date</th>
                                                                                <th class="ceterText fw-bolder font-size-16">Payout Details</th>
                                                                                <th class="ceterText fw-bolder font-size-16">Amount</th>
                                                                                <th class="ceterText fw-bolder font-size-16">TDS</th>
                                                                                <th class="ceterText fw-bolder font-size-16">Total Payable</th>
                                                                                <th class="ceterText fw-bolder font-size-16">Remark</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <?php
                                                                            $sql = "SELECT * FROM `bcm_payout_history` WHERE  bcm_user_id = '" . $userId . "'  ";
                                                                            $stmt = $conn->prepare($sql);
                                                                            $stmt->execute();
                                                                            $stmt->setFetchMode(PDO::FETCH_ASSOC);
                                                                            if ($stmt->rowCount() > 0) {
                                                                                foreach (($stmt->fetchALL()) as $key => $row) {

                                                                                    // date in proper formate 
                                                                                    //if payout is paid/decline
                                                                                    if ($row['payout_status'] == 2 || $row['payout_status'] == 3) {
                                                                                        $dt = new DateTime($row['release_date']);
                                                                                        $dt = $dt->format('Y-m-d');
                                                                                    }
                                                                                    //if payout is pending 
                                                                                    else {
                                                                                        $dt = new DateTime($row['payout_date']);
                                                                                        $dt = $dt->format('Y-m-d');
                                                                                    }
                                                                                    // Get Active BDMs
                                                                                    $ids = json_decode($row['bdm_user_id'], true);
                                                                                    $names = [];

                                                                                    if (!empty($ids)) {
                                                                                        $placeholders = rtrim(str_repeat('?,', count($ids)), ','); // ?,?,?
                                                                                        $query = $conn->prepare("SELECT employee_id,  name FROM employees WHERE employee_id IN ($placeholders) AND user_type = 25 AND status = 1");
                                                                                        $query->execute($ids);

                                                                                        while ($bmRow = $query->fetch(PDO::FETCH_ASSOC)) {
                                                                                            $names[] = $bmRow['name'] . " (" . $bmRow['employee_id'] . ")";
                                                                                        }
                                                                                    }

                                                                                    // Append Active BDMs to message
                                                                                    $message1 = $row['message_bcm'];
                                                                                    if (!empty($names)) {
                                                                                        $message1 .= " Active BDMs: " . implode(', ', $names) . ".";
                                                                                    }

                                                                                    // replace dot at end of the line with break statement
                                                                                    //$message1 = $row['message_bcm'];
                                                                                    //$message1 =  str_replace('.', '<br>', $message1);

                                                                                    if ($row['payout_amount'] == "null") {
                                                                                        $CommAmt = '0';
                                                                                        $tds = '0';
                                                                                        $totalAmt = '0';
                                                                                    } else {
                                                                                        $CommAmt = $row['payout_amount'];
                                                                                        $tds = $CommAmt * $tds_percentage;
                                                                                        $totalAmt = $CommAmt - $tds;
                                                                                    }

                                                                                    echo '<tr>
                                                                                                    <td>' . $dt . '</td>
                                                                                                    <td>' . $message1 . '</td>
                                                                                                    <td class="text-end">' . $CommAmt . '</td>
                                                                                                    <td class="text-end">' . $tds . '</td>
                                                                                                    <td class="text-end">' . $totalAmt . '
                                                                                                        <a href="payout/forms/slab_payout_bdm/download_ca_payout.php?vkvbvjfgfikix=' . $row['id'] . '&bc=' . $row['bcm_user_id'] . '&ca=' . urlencode(implode(', ', json_decode($row['bdm_user_id'], true))) .  '&date=' . $dt . '&message=' . $message1 . '&message_status=' . $row['payout_status'] . '&commission=' . $row['payout_amount'] . '&userType=' . $userType . '">
                                                                                                            <i class="bx bx-download" style="font-size: 18px; color: black; padding-left: 5px;"></i>
                                                                                                        </a>
                                                                                                    </td>';
                                                                                    if ($row['payout_status'] == '2') {
                                                                                        echo '<td><span class="badge bg-success font-size-10 fw-bold ms-4">Paid</span></td>';
                                                                                    } else if ($row['payout_status'] == '3') {
                                                                                        echo '<td><span class="badge bg-danger font-size-10 fw-bold ms-4"
                                                                                        data-bs-toggle="modal"  data-bs-target="#rejectTopup" onclick="loadRejectionReason(' . $row['id'] . ')"
                                                                                        style="cursor: pointer";>Blocked</span></td>';
                                                                                    } else {
                                                                                        echo '<td><span class="badge bg-warning font-size-10 fw-bold ms-4">Pending</span></td>';
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
                                            <!-- end row -->
                                        </div>
                                    </div>
                                </div>

                                <div style="display: none;">
                                    <input type="text" name="" id="userIDHidden" value="<?php echo $userId ?>">
                                    <input type="text" name="" id="userTypeHidden" value="<?php echo $userType ?>">
                                    <input type="text" name="" id="userFnameHidden" value="<?php echo $userFname ?>">
                                    <input type="text" name="" id="userLnameHidden" value="<?php echo $userLname ?>">
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


        <!-- sample modal content -->
        <div id="previousPayout" class="modal fade" tabindex="-1" aria-labelledby="#exampleModalFullscreenLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false" style=" border-radus: 20px !important;">
            <div class="modal-dialog modal-fullscreen" style="width: 80%; margin: auto; margin-top: 30px; margin-bottom: 30px; height: 90vh;">
                <div class="modal-content modal-radius">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalFullscreenLabel">Previous Payout</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row d-flex justify-content-evenly">
                            <div class="col-lg-4 col-md-4 col-sm-7 card" style="border: 2px solid black; border-radius: 10px;">
                                <div class="mt-3">
                                    <p class="font-size-18 pt-2">Previous Payout<span class="fw-bold font-size-12 date-layout1 layout-1"><?php echo "$prevdate" ?></span></p>
                                    <div class="d-flex">
                                        <?php
                                        $previousPayout = $conn->prepare("SELECT SUM(payout_amount) as previousPayout FROM bcm_payout_history WHERE bcm_user_id = '" . $userId . "' AND YEAR(payout_date) = '" . $prevDateYear . "' AND MONTH(payout_date) = '" . $prevDateMonth . "' ");
                                        $previousPayout->execute();
                                        $previousPayout->setFetchMode(PDO::FETCH_ASSOC);
                                        if ($previousPayout->rowCount() > 0) {
                                            foreach (($previousPayout->fetchAll()) as $key => $row) {
                                                $previousPayout = $row['previousPayout'];
                                                $previousPayoutTDS = $previousPayout * $tds_percentage;
                                                $TotalpreviousPayout = $previousPayout - $previousPayoutTDS;
                                                $truncatedPrevAmount = floor($TotalpreviousPayout * 100) / 100;
                                                echo '<p class="fs-5 font fw-bolder mt-n2 icon">Rs.' . number_format($truncatedPrevAmount, 2) . '/- </p>
                                                        <span class="badge bg-success font-size-10 fw-bold status1 paystatus" style="height: 15px !important; margin-top: 16px;" readonly>Paid</span>';
                                            }
                                        }
                                        ?>

                                        <a href="payout/forms/slab_payout_bdm/download_exel_ca.php?payoutYear=<?php echo $prevDateYear; ?>&payoutMonth=<?php echo $prevDateMonth; ?>&payoutmessage=PreviousPayout &userType=<?php echo $userType; ?>">
                                            <i class="bx bx-download download-icon status1 paystatus" style="font-size: 20px; color: black; margin-left: 20%;"></i>
                                        </a>
                                    </div>


                                </div>
                            </div>
                            <div class="col-lg-7 col-md-7 col-sm-7">
                                <!-- <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                        <h2 class="mb-sm-0 fw-bolder ps-4">All Payouts</h2>
                                    </div> -->
                                <div class="row filter-options filter">
                                    <div class="designation-filter no-space col-lg-5 col-md-5 col-sm-12">
                                        <input type="text" name="" class="selectdesign filter-opt-1 fw-bolder" id="designationPrevious" value="<?php echo 'ID: ' . $userId; ?>" readonly>
                                    </div>
                                    <div class="name-filter no-space col-lg-5 col-md-5 col-sm-12">
                                        <input type="text" name="" class="sselectdesign filter-opt-2 minimal fw-bolder" id="user_id_namePrevious" value="<?php echo 'Name: ' . $firstname . ' ' . $lastname; ?>" readonly>
                                    </div>
                                    <span id="prevDiv" class="col-md-10 card border-2 border-black" style="border-radius: 10px; padding: 10px">
                                        <div id="download_icon ">
                                            <p class="font-size-14">Name: <span><?php echo $firstname . ' ' . $lastname; ?></span><span class="fw-bold font-size-10 ms-4 date-layout layout-2 date-align"><?php echo "$prevdate" ?></span></p>
                                            <p class="fs-5 fw-bolder mt-n2 icon">Rs. <?php echo number_format($truncatedPrevAmount, 2); ?>/- </p>
                                            <!-- <a href="">
                                                    <i class="bx bx-download layout-3" style="font-size: 20px; color: black;"></i>
                                                </a> -->
                                        </div>
                                    </span>

                                </div>
                            </div>
                            <!-- monthly user details table  -->
                            <div class="row" style="padding-top: 25px;" id="user-box">
                                <div class="col-md-12">
                                    <!-- <div class="row">
                                            <hr>
                                            <div class="MonthlyDetailsHeading">
                                                <span id="table-heading" style="padding: 0px 20px; font-weight: 600; font-size: initial;"></span>
                                            </div>

                                            <div class="MonthlyDetailsHeadingClose">
                                                <span class="close-btn" style="float:right; padding: 0px 10px 10px 10px; font-weight: 600; font-size: initial; cursor:pointer; color:red"> X </span>
                                            </div>
                                        </div> -->
                                    <!-- <input type="hidden" name="user_table_count" id="user_table_count" value="" /> -->
                                    <div class="table-responsive table-desi" id="filterTablePrev">
                                        <!-- table roe limit -->

                                        <table class="table table-hover" id="previous_payout_table">
                                            <thead>
                                                <tr>
                                                    <th class="ceterText fw-bolder font-size-16">Date</th>
                                                    <th class="ceterText fw-bolder font-size-16">Payout Details</th>
                                                    <th class="ceterText fw-bolder font-size-16">Amount</th>
                                                    <th class="ceterText fw-bolder font-size-16">TDS</th>
                                                    <th class="ceterText fw-bolder font-size-16">Total Payable</th>
                                                    <th class="ceterText fw-bolder font-size-16">Remark</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $sql2 = "SELECT * FROM bcm_payout_history WHERE bcm_user_id = '" . $userId . "' AND YEAR(payout_date) = '" . $prevDateYear . "' AND MONTH(payout_date) = '" . $prevDateMonth . "' ";
                                                $stmt = $conn->prepare($sql2);
                                                $stmt->execute();
                                                $stmt->setFetchMode(PDO::FETCH_ASSOC);
                                                if ($stmt->rowCount() > 0) {
                                                    foreach (($stmt->fetchALL()) as $key => $row) {

                                                        // date in proper formate 
                                                        //if payout is paid/decline
                                                        if ($row['payout_status'] == 2 || $row['payout_status'] == 3) {
                                                            $dt = new DateTime($row['release_date']);
                                                            $dt = $dt->format('Y-m-d');
                                                        }
                                                        //if payout is pending 
                                                        else {
                                                            $dt = new DateTime($row['payout_date']);
                                                            $dt = $dt->format('Y-m-d');
                                                        }

                                                        // Get Active BDMs
                                                        $ids = json_decode($row['bdm_user_id'], true);
                                                        $names = [];

                                                        if (!empty($ids)) {
                                                            $placeholders = rtrim(str_repeat('?,', count($ids)), ','); // ?,?,?
                                                            $query = $conn->prepare("SELECT employee_id,  name FROM employees WHERE employee_id  IN ($placeholders) AND user_type = 25 AND status = 1");
                                                            $query->execute($ids);

                                                            while ($bmRow = $query->fetch(PDO::FETCH_ASSOC)) {
                                                                $names[] = $bmRow['name'] . " (" . $bmRow['employee_id'] . ")";
                                                            }
                                                        }

                                                        // Append Active BDMs to message
                                                        $message1 = $row['message_bcm'];
                                                        if (!empty($names)) {
                                                            $message1 .= " Active BDMs: " . implode(', ', $names) . ".";
                                                        }
                                                        // replace dot at end of the line with break statement
                                                        //$message1 = $row['message_bcm'];
                                                        //$message1 =  str_replace('.', '<br>', $message1);

                                                        // total Amt Cal for BC 
                                                        if ($row['payout_amount'] == "null") {
                                                            $CommAmt = '0';
                                                            $tds = '0';
                                                            $totalAmt = '0';
                                                        } else {
                                                            $CommAmt = $row['payout_amount'];
                                                            $tds = $CommAmt * $tds_percentage;
                                                            $totalAmt = $CommAmt - $tds;
                                                        }

                                                        echo '<tr>
                                                                        <td>' . $dt . '</td>
                                                                        <td>' . $message1 . '</td>
                                                                        <td class="text-end">' . $CommAmt . '</td>
                                                                        <td class="text-end">' . $tds . '</td>
                                                                        <td class="text-end">' . $totalAmt . '
                                                                            <a href="payout/forms/slab_payout_bdm/download_ca_payout.php?vkvbvjfgfikix=' . $row['id'] . '&bc=' . $row['bcm_user_id'] . '&ca='  . implode(', ', json_decode($row['bdm_user_id'], true)) . '&date=' . $dt . '&message=' . $message1 . '&message_status=' . $row['payout_status'] . '&commission=' . $row['payout_amount'] . '&userType=' . $userType . '">
                                                                                <i class="bx bx-download" style="font-size: 18px; color: black; padding-left: 5px;"></i>
                                                                            </a>
                                                                        </td>';
                                                        if ($row['payout_status'] == '2') {
                                                            echo '<td><span class="badge bg-success font-size-10 fw-bold ms-4">Paid</span></td>';
                                                        } else if ($row['payout_status'] == '3') {
                                                            echo '<td><span class="badge bg-danger font-size-10 fw-bold ms-4"
                                                            data-bs-toggle="modal" data-bs-target="#rejectTopup" onclick="loadRejectionReason(' . $row['id'] . ')" style="cursor: pointer";>Blocked</span></td>';
                                                        } else {
                                                            echo '<td><span class="badge bg-warning font-size-10 fw-bold ms-4" data-bs-toggle="modal" data-bs-target=".bs-example-modal-center" onclick=\'paymentId("' . $row['id'] . '","' . $row['bcm_user_id'] . '","' . $row['message_bcm'] . '","' . $row['payout_amount'] . '","' . $row['payout_status'] . '","PrevPayout")\'>Pending</span></td>';
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
                    <div style="display: none;">
                        <input type="text" name="" id="prevMonth" value="<?php echo $prevDateMonth ?>">
                        <input type="text" name="" id="prevYear" value="<?php echo $prevDateYear ?>">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Close</button>
                        <!-- <button type="button" class="btn btn-primary waves-effect waves-light">Save changes</button> -->
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
        <!-- sample modal content -->
        <div id="nextPayout" class="modal fade" tabindex="-1" aria-labelledby="#exampleModalFullscreenLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false" style=" border-radus: 20px !important;">
            <div class="modal-dialog modal-fullscreen" style="width: 80%; margin: auto; margin-top: 30px; margin-bottom: 30px; height: 90vh;">
                <div class="modal-content modal-radius">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalFullscreenLabel">Next Payout</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row d-flex justify-content-evenly">
                            <div class="col-lg-4 col-md-4 col-sm-7 card" style="border: 2px solid black; border-radius: 10px;">
                                <div class="mt-3">
                                    <p class="font-size-18 pt-3">Next Payout<span class="fw-bold font-size-12 date-layout layout-1" id="currentMonth"><?php echo "$date" ?></span></p>
                                    <div class="d-flex">
                                        <?php
                                        $nextPayout = $conn->prepare("SELECT SUM(payout_amount) as nextPayout FROM bcm_payout_history WHERE  bcm_user_id = '" . $userId . "' AND YEAR(payout_date) = '" . $nextDateYear . "' AND MONTH(payout_date) = '" . $nextDateMonth . "' ");
                                        $nextPayout->execute();
                                        $nextPayout->setFetchMode(PDO::FETCH_ASSOC);
                                        if ($nextPayout->rowCount() > 0) {
                                            foreach (($nextPayout->fetchAll()) as $key => $row2) {
                                                $nextPayoutTotal = $row2['nextPayout'];
                                                $nextPayoutTDS = $nextPayoutTotal * $tds_percentage;
                                                $TotalNextPayout = $nextPayoutTotal - $nextPayoutTDS;
                                                $truncatedNextAmount = floor($TotalNextPayout * 100) / 100;
                                                echo '<p class="fs-5 font fw-bolder mt-n2 icon">Rs.' . number_format($truncatedNextAmount, 2) . '/- </p>
                                                        <span class="badge bg-success font-size-10 fw-bold status1 paystatus" style="height: 15px !important; margin-top: 16px;" readonly>Paid</span>';
                                            }
                                        }
                                        ?>

                                        <a href="payout/forms/slab_payout_bdm/download_exel_ca.php?payoutYear=<?php echo $nextDateYear; ?>&payoutMonth=<?php echo $nextDateMonth; ?>&payoutmessage=NextPayout&userType=<?php echo $userType; ?>&user_id=<?php echo $userId ?>">
                                            <i class="bx bx-download download-icon status1 paystatus" style="font-size: 20px; color: black; margin-left: 20%;"></i>
                                        </a>
                                    </div>


                                </div>
                            </div>
                            <div class="col-lg-7 col-md-7 col-sm-7">
                                <!-- <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                        <h2 class="mb-sm-0 fw-bolder ps-4">All Payouts</h2>
                                    </div> -->
                                <div class="row filter-options filter">
                                    <div class="designation-filter no-space col-lg-5 col-md-5 col-sm-12">
                                        <input type="text" name="" class="selectdesign filter-opt-1 fw-bolder" id="designationNext" value="<?php echo 'ID: ' . $userId; ?>" readonly>
                                    </div>
                                    <div class="name-filter no-space col-lg-5 col-md-5 col-sm-12">
                                        <input type="text" name="" class="selectdesign filter-opt-2 minimal fw-bolder" id="user_id_nameNext" value="<?php echo 'Name: ' . $firstname . ' ' . $lastname; ?>" readonly>
                                    </div>
                                    <span id="nextDiv" class="col-md-10 card border-2 border-black" style="border-radius: 10px; padding: 10px">
                                        <div id="download_icon ">
                                            <p class="font-size-14">Name: <span><?php echo $firstname . ' ' . $lastname; ?></span><span class="fw-bold font-size-10 ms-4 date-layout layout-2 date-align"><?php echo "$date" ?></span></p>
                                            <p class="fs-5 fw-bolder mt-n2 icon">Rs. <?php echo number_format($truncatedNextAmount, 2) ?>/- </p>
                                            <!-- <a href="">
                                                    <i class="bx bx-download layout-3" style="font-size: 20px; color: black;"></i>
                                                </a> -->
                                        </div>
                                    </span>

                                </div>
                            </div>
                            <!-- monthly user details table  -->
                            <div class="row" style="padding-top: 25px;" id="user-box">
                                <div class="col-md-12">
                                    <!-- <div class="row">
                                            <hr>
                                            <div class="MonthlyDetailsHeading">
                                                <span id="table-heading" style="padding: 0px 20px; font-weight: 600; font-size: initial;"></span>
                                            </div>

                                            <div class="MonthlyDetailsHeadingClose">
                                                <span class="close-btn" style="float:right; padding: 0px 10px 10px 10px; font-weight: 600; font-size: initial; cursor:pointer; color:red"> X </span>
                                            </div>
                                        </div> -->
                                    <!-- <input type="hidden" name="user_table_count" id="user_table_count" value="" /> -->
                                    <div class="table-responsive table-desi" id="filterTableNext">
                                        <!-- table roe limit -->
                                        <table class="table table-hover" id="next_payout_table">
                                            <thead>
                                                <tr>
                                                    <th class="ceterText fw-bolder font-size-16">Date</th>
                                                    <th class="ceterText fw-bolder font-size-16">Payout Details</th>
                                                    <th class="ceterText fw-bolder font-size-16">Amount</th>
                                                    <th class="ceterText fw-bolder font-size-16">TDS</th>
                                                    <th class="ceterText fw-bolder font-size-16">Total Payable</th>
                                                    <th class="ceterText fw-bolder font-size-16">Remark</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $sql3 = "SELECT * FROM bcm_payout_history WHERE bcm_user_id = '" . $userId . "' AND YEAR(payout_date) = '" . $nextDateYear . "' AND MONTH(payout_date) = '" . $nextDateMonth . "' ";
                                                $stmt = $conn->prepare($sql3);
                                                $stmt->execute();
                                                $stmt->setFetchMode(PDO::FETCH_ASSOC);
                                                if ($stmt->rowCount() > 0) {
                                                    foreach (($stmt->fetchALL()) as $key => $row) {

                                                        // date in proper format 
                                                        //if payout is paid/decline
                                                        if ($row['payout_status'] == 2 || $row['payout_status'] == 3) {
                                                            $dt = new DateTime($row['release_date']);
                                                            $dt = $dt->format('Y-m-d');
                                                        }
                                                        //if payout is pending 
                                                        else {
                                                            $dt = new DateTime($row['payout_date']);
                                                            $dt = $dt->format('Y-m-d');
                                                        }
                                                        // Get Active BDMs
                                                        $ids = json_decode($row['bdm_user_id'], true);
                                                        $names = [];

                                                        if (!empty($ids)) {
                                                            $placeholders = rtrim(str_repeat('?,', count($ids)), ','); // ?,?,?
                                                            $query = $conn->prepare("SELECT employee_id,  name FROM employees WHERE employee_id IN ($placeholders) AND user_type = 25 AND status = 1");
                                                            $query->execute($ids);

                                                            while ($bmRow = $query->fetch(PDO::FETCH_ASSOC)) {
                                                                $names[] = $bmRow['name'] . " (" . $bmRow['employee_id'] . ")";
                                                            }
                                                        }

                                                        // Append Active BDMs to message
                                                        $message1 = $row['message_bcm'];
                                                        if (!empty($names)) {
                                                            $message1 .= " Active BDMs: " . implode(', ', $names) . ".";
                                                        }
                                                        // replace dot at end of the line with break statement
                                                        //$message1 = $row['message_bcm'];
                                                        //$message1 =  str_replace('.', '<br>', $message1);

                                                        // total Amt Cal for BC 
                                                        if ($row['payout_amount'] == "null") {
                                                            $CommAmt = '0';
                                                            $tds = '0';
                                                            $totalAmt = '0';
                                                        } else {
                                                            $CommAmt = $row['payout_amount'];
                                                            $tds = $CommAmt * $tds_percentage;
                                                            $totalAmt = $CommAmt - $tds;
                                                        }

                                                        echo '<tr>
                                                                        <td>' . $dt . '</td>
                                                                        <td>' . $message1 . '</td>
                                                                        <td class="text-end">' . $CommAmt . '</td>
                                                                        <td class="text-end">' . $tds . '</td>
                                                                        <td class="text-end">' . $totalAmt . '
                                                                            <a href="payout/forms/slab_payout_bdm/download_ca_payout.php?vkvbvjfgfikix=' . $row['id'] . '&bc=' . $row['bcm_user_id'] . '&ca='  . implode(', ', json_decode($row['bdm_user_id'], true)) . '&date=' . $dt . '&message=' . $message1 . '&message_status=' . $row['payout_status'] . '&commission=' . $row['payout_amount'] . '&userType=' . $userType . '">
                                                                                <i class="bx bx-download" style="font-size: 18px; color: black; padding-left: 5px;"></i>
                                                                            </a>
                                                                        </td>';
                                                        if ($row['payout_status'] == '2') {
                                                            echo '<td><span class="badge bg-success font-size-10 fw-bold ms-4">Paid</span></td>';
                                                        } else if ($row['payout_status'] == '3') {
                                                            echo '<td><span class="badge bg-danger font-size-10 fw-bold ms-4"
                                                            data-bs-toggle="modal" data-bs-target="#rejectTopup" onclick="loadRejectionReason(' . $row['id'] . ')" style="cursor: pointer";>Blocked</span></td>';
                                                        } else {
                                                            echo '<td><span class="badge bg-warning font-size-10 fw-bold ms-4" data-bs-toggle="modal" data-bs-target=".bs-example-modal-center" onclick=\'paymentId("' . $row['id'] . '","' . $row['bcm_user_id'] . '","' . $row['message_bcm'] . '","' . $row['payout_amount'] . '","' . $row['payout_status'] . '","NextPayout")\'>Pending</span></td>';
                                                        }
                                                        echo '</tr>';
                                                    }
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                        <!-- pegination start -->
                                        <div class="center text-center" id="pagination_row"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div style="display: none;">
                        <input type="text" name="" id="nextMonth" value="<?php echo $nextDateMonth ?>">
                        <input type="text" name="" id="nextYear" value="<?php echo $nextDateYear ?>">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Close</button>
                        <!-- <button type="button" class="btn btn-primary waves-effect waves-light">Save changes</button> -->
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
        <!-- sample modal content -->
        <div id="totalPayout" class="modal fade" tabindex="-1" aria-labelledby="#exampleModalFullscreenLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false" style=" border-radus: 20px !important;">
            <div class="modal-dialog modal-fullscreen" style="width: 80%; margin: auto; margin-top: 30px; margin-bottom: 30px; height: 90vh;">
                <div class="modal-content modal-radius">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalFullscreenLabel">Total Payout</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row d-flex justify-content-evenly">
                            <div class="col-lg-4 col-md-4 col-sm-7 card" style="border: 2px solid black; border-radius: 10px;">
                                <div class="mt-3">
                                    <p class="font-size-18 pt-3">Total Payout<span class="fw-bold font-size-12 date-layout layout-1"><?php echo "$date" ?></span></p>
                                    <div class="d-flex">
                                        <?php
                                        $totalPayout = "SELECT SUM(payout_amount) as total_payable FROM bcm_payout_history WHERE bcm_user_id = '" . $userId . "' ";
                                        $Payout = $conn->prepare($totalPayout);
                                        $Payout->execute();
                                        $Payout->setFetchMode(PDO::FETCH_ASSOC);
                                        // print_r($Payout);
                                        if ($Payout->rowCount() > 0) {
                                            foreach (($Payout->fetchAll()) as $key => $row) {
                                                $total_payable = $row["total_payable"] ?? '0';
                                                $total_payableTDS = $total_payable * $tds_percentage;
                                                $TotalPayout = $total_payable - $total_payableTDS;
                                                $truncatedTotalAmount = floor($TotalPayout * 100) / 100;
                                                echo '
                                                    <p class="fs-5 font fw-bolder mt-n2 icon">Rs.' . number_format($truncatedTotalAmount, 2) . '/- </p>
                                                    <span class="badge bg-success font-size-10 fw-bold status1 paystatus" style="height: 15px !important; margin-top: 16px;" readonly>Paid</span>
                                                ';
                                            }
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-7 col-md-7 col-sm-7">
                                <!-- <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                        <h2 class="mb-sm-0 fw-bolder ps-4">All Payouts</h2>
                                    </div> -->
                                <div class="row filter-options filter">
                                    <div class="designation-filter no-space col-lg-5 col-md-5 col-sm-12">
                                        <input type="text" name="" class="selectdesign filter-opt-1 fw-bolder" id="designationNext" value="<?php echo 'ID: ' . $userId; ?>" readonly>
                                    </div>
                                    <div class="name-filter no-space col-lg-5 col-md-5 col-sm-12">
                                        <input type="text" name="" class="selectdesign filter-opt-2 minimal fw-bolder" id="user_id_nameNext" value="<?php echo 'Name: ' . $firstname . ' ' . $lastname; ?>" readonly>
                                    </div>
                                    <!-- <form class=" col-md-4 app-search d-lg-block">
                                            <div class="position-relative">
                                                <span class="bx bx-search-alt"></span>
                                                <input type="text" class="form-control search control" placeholder="Search...">
                                            </div>
                                        </form> -->
                                    <span id="totalDiv" class="col-md-10 card border-2 border-black" style="border-radius: 10px; padding: 10px">
                                        <div id="download_icon ">
                                            <p class="font-size-14">Name: <span><?php echo $firstname . ' ' . $lastname; ?></span><span class="fw-bold font-size-10 ms-4 date-layout layout-2 date-align"><?php echo "$date" ?></span></p>
                                            <p class="fs-5 fw-bolder mt-n2 icon">Rs. <?php echo number_format($truncatedTotalAmount, 2); ?>/- </p>
                                            <!-- <a href="">
                                                    <i class="bx bx-download layout-3" style="font-size: 20px; color: black;"></i>
                                                </a> -->
                                        </div>
                                    </span>

                                </div>
                            </div>
                            <!-- monthly user details table  -->
                            <div class="row" style="padding-top: 25px;" id="user-box">
                                <div class="col-md-12">
                                    <!-- <div class="row">
                                            <hr>
                                            <div class="MonthlyDetailsHeading">
                                                <span id="table-heading" style="padding: 0px 20px; font-weight: 600; font-size: initial;"></span>
                                            </div>

                                            <div class="MonthlyDetailsHeadingClose">
                                                <span class="close-btn" style="float:right; padding: 0px 10px 10px 10px; font-weight: 600; font-size: initial; cursor:pointer; color:red"> X </span>
                                            </div>
                                        </div> -->
                                    <!-- <input type="hidden" name="user_table_count" id="user_table_count" value="" /> -->
                                    <div class="table-responsive table-desi" id="filteredTotalTable">
                                        <!-- table roe limit -->
                                        <table class="table table-hover" id="total_payout_table">
                                            <thead>
                                                <tr>
                                                    <th class="ceterText fw-bolder font-size-16">Date</th>
                                                    <th class="ceterText fw-bolder font-size-16">Payout Message</th>
                                                    <!-- <th class="ceterText fw-bolder font-size-16">Payout Details</th> -->
                                                    <th class="ceterText fw-bolder font-size-16">Amount</th>
                                                    <th class="ceterText fw-bolder font-size-16">TDS</th>
                                                    <th class="ceterText fw-bolder font-size-16">Total Payable</th>
                                                    <th class="ceterText fw-bolder font-size-16">Remark</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $sql4 = "SELECT * FROM bcm_payout_history WHERE bcm_user_id = '" . $userId . "'  ";
                                                $stmt = $conn->prepare($sql4);
                                                $stmt->execute();
                                                $stmt->setFetchMode(PDO::FETCH_ASSOC);
                                                if ($stmt->rowCount() > 0) {
                                                    foreach (($stmt->fetchALL()) as $key => $row) {

                                                        // date in proper format 
                                                        //if payout is paid/decline
                                                        if ($row['payout_status'] == 2 || $row['payout_status'] == 3) {
                                                            $dt = new DateTime($row['release_date']);
                                                            $dt = $dt->format('Y-m-d');
                                                        }
                                                        //if payout is pending 
                                                        else {
                                                            $dt = new DateTime($row['payout_date']);
                                                            $dt = $dt->format('Y-m-d');
                                                        }
                                                        // Get Active BDMs
                                                        $ids = json_decode($row['bdm_user_id'], true);
                                                        $names = [];

                                                        if (!empty($ids)) {
                                                            $placeholders = rtrim(str_repeat('?,', count($ids)), ','); // ?,?,?
                                                            $query = $conn->prepare("SELECT employee_id,  name FROM employees WHERE employee_id IN ($placeholders) AND user_type = 25 AND status = 1");
                                                            $query->execute($ids);

                                                            while ($bmRow = $query->fetch(PDO::FETCH_ASSOC)) {
                                                                $names[] = $bmRow['name'] . " (" . $bmRow['employee_id'] . ")";
                                                            }
                                                        }

                                                        // Append Active BDMs to message
                                                        $message1 = $row['message_bcm'];
                                                        if (!empty($names)) {
                                                            $message1 .= " Active BDMs: " . implode(', ', $names) . ".";
                                                        }
                                                        // replace dot at end of the line with break statement
                                                        //$message1 = $row['message_bcm'];
                                                        //$message1 =  str_replace('.', '<br>', $message1);
                                                        // $message_details = $row['message_details'];
                                                        // $message_details =  str_replace('.', '<br>', $message_details);


                                                        // total Amt Cal for BC 
                                                        if ($row['payout_amount'] == "null") {
                                                            $CommAmt = '0';
                                                            $tds = '0';
                                                            $totalAmt = '0';
                                                        } else {
                                                            $CommAmt = $row['payout_amount'];
                                                            $tds = $CommAmt * $tds_percentage;
                                                            $totalAmt = $CommAmt - $tds;
                                                        }

                                                        echo '<tr>
                                                            <td>' . $dt . '</td>
                                                            <td>' . $message1 . '</td>
                                                            
                                                            <td class="text-end">' . $CommAmt . '</td>
                                                            <td class="text-end">' . $tds . '</td>
                                                            <td class="text-end">' . $totalAmt . '
                                                                <a href="payout/forms/slab_payout_bdm/download_ca_payout.php?vkvbvjfgfikix=' . $row['id'] . '&bc=' . $row['bcm_user_id'] . '&ca='  . implode(', ', json_decode($row['bdm_user_id'], true)) . '&date=' . $dt . '&message=' . $message1 . '&message_status=' . $row['payout_status'] . '&commission=' . $row['payout_amount'] . '&userType=' . $userType . '">
                                                                    <i class="bx bx-download" style="font-size: 18px; color: black; padding-left: 5px;"></i>
                                                                </a>
                                                            </td>';
                                                        if ($row['payout_status'] == '2') {
                                                            echo '<td><span class="badge bg-success font-size-10 fw-bold ms-4">Paid</span></td>';
                                                        } else if ($row['payout_status'] == '3') {
                                                            echo '<td><span class="badge bg-danger font-size-10 fw-bold ms-4" data-bs-toggle="modal" data-bs-target="#rejectTopup" onclick="loadRejectionReason(' . $row['id'] . ')" style="cursor: pointer";>Blocked</span></td>';
                                                        } else {
                                                            echo '<td><span class="badge bg-warning font-size-10 fw-bold ms-4" data-bs-toggle="modal" data-bs-target=".bs-example-modal-center" onclick=\'paymentId("' . $row['id'] . '","' . $row['bcm_user_id'] . '","' . $row['message_bcm'] . '","' . $row['payout_amount'] . '","' . $row['payout_status'] . '","TotalPayout")\'>Pending</span></td>';
                                                        }
                                                        echo '</tr>';
                                                    }
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                        <!-- pegination start -->
                                        <div class="center text-center" id="pagination_row"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Close</button>
                        <!-- <button type="button" class="btn btn-primary waves-effect waves-light">Save changes</button> -->
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
        <!-- center pop up modal for pending status -->
        <div class="modal fade bs-example-modal-center" tabindex="-1" role="dialog" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Payment Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div>
                            <label class="text-muted d-block ">Payment Details</label>
                            <!-- <input type="text" id="paymentIds" value="" class="input1 mb-4" readonly> -->
                            <textarea name="paymentMessage" id="paymentMessageDetails" class="input2 w-100" cols="65" rows="4" readonly></textarea>
                        </div>
                        <div>
                            <label class="text-muted d-block">Payment Message</label>
                            <textarea id="paymentMessage" name="paymentMessage" rows="4" cols="65" class="input2 w-100"></textarea>
                        </div>
                        <div class="modal-footer">
                            <button type="button" id="submitPayment" class="btn btn-success rounded-3" data-dismiss="modal">Submit</button>
                        </div>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
        <!-- Show Blocked Message Modal -->
        <div class="modal fade" id="rejectTopup" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Blocked Reason</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-floating">
                            <p id="floatingTextarea" class="text-danger fw-bold"></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

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

        <script src="assets/js/submitdata.js"></script>

        <!-- !-- materialdesign icon js- -->
        <script src="assets/js/pages/remix-icons-listing.js"></script>

        <!-- apexcharts -->
        <script src="assets/libs/apexcharts/apexcharts.min.js"></script>

        <!-- Vector map-->
        <script src="assets/libs/jsvectormap/js/jsvectormap.min.js"></script>
        <script src="assets/libs/jsvectormap/maps/world-merc.js"></script>

        <!--Swiper slider js-->
        <script src="assets/libs/swiper/swiper-bundle.min.js"></script>

        <!-- Dashboard init -->
        <!-- <script src="assets/js/pages/dashboard-ecommerce.init.js"></script> -->

        <!-- App js -->
        <script src="assets/js/app.js"></script>

        <!-- custom js  -->
        <script src="payout/slab_payout_bdm_bcm.js"></script>
        <!-- Chart JS -->
        <!-- <script src="assets/libs/chart.js/chart.umd.js"></script> -->

        <!-- chartjs init -->
        <!-- <script src="assets/js/pages/chartjs.init.js"></script> -->

        <!-- Dashboard init -->
        <!-- <script src="assets/js/pages/dashboard-job.init.js"></script> -->

        <!-- ** designation user, user name on designation select / get country, state, city, pincode **  -->

        <!-- Required datatable js -->
        <script src="assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
        <script src="assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>

        <!-- Responsive examples -->
        <script src="assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
        <script src="assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>
        <script>
            $(document).ready(function() {
                $("#payoutDetailsTable").DataTable();
                $("#previous_payout_table").DataTable();
                $("#next_payout_table").DataTable();
                $("#total_payout_table").DataTable();
                //bdm bcm list
                let user_id = $("#userIDHidden").val();
                let currentDate = new Date();
                let month = String(currentDate.getMonth() + 1).padStart(2, '0'); // Ensures two-digit format
                let year = currentDate.getFullYear();
                let monthYear = `${year}-${month}`; // Format: MM-YYYY
                //console.log(monthYear); // Example: "03-2025"
                //let month_year=$('#cap_date').val();
                function loadBmBdmTables(monthYear) {
                    let bmTable = $("#bmTable").DataTable();
                    let bdmTable = $("#bdmTable").DataTable();
                    $.ajax({
                        url: "payout/forms/slab_payout_bdm/getbmdetails.php",
                        type: "POST",
                        data: {
                            designation: 'bcm',
                            user_id: user_id,
                            month_year: monthYear
                        },
                        dataType: "json",
                        success: function(response) {
                            // Update BM Table
                            //let bmTable = $("#bmTable").DataTable();


                            bmTable.clear();

                            if (response.bm_list.length > 0) {
                                $.each(response.bm_list, function(index, data) {
                                    bmTable.row.add([
                                        index + 1,
                                        data.user_id,
                                        data.name,
                                        data.active_te_count
                                    ]).draw();
                                });
                            } else {

                                // Add a row that spans all columns
                                bmTable.row.add([
                                    "No Data Available", "", "", ""
                                ]).draw();

                                // Center align the "No Data Available" text
                                $('#bmTable tbody tr td').attr('colspan', 4).css('text-align', 'center');
                            }
                            //let bdmTable = $("#bdmTable").DataTable();
                            bdmTable.clear();

                            if (response.bdm_list.length > 0) {
                                $.each(response.bdm_list, function(index, data) {
                                    bdmTable.row.add([
                                        index + 1,
                                        data.user_id,
                                        data.name,
                                        data.active_te_count
                                    ]).draw();
                                });
                            } else {
                                // Add a row that spans all columns
                                bdmTable.row.add([
                                    "No Data Available", "", "", ""
                                ]).draw();

                                // Center align the "No Data Available" text
                                $('#bdmTable tbody tr td').attr('colspan', 4).css('text-align', 'center');
                            }
                        }
                    });
                }
                loadBmBdmTables(monthYear);
                $("#month_year").on('change',function(){
                    let monthYear=$(this).val();
                    console.log('test');
                    console.log('test'+monthYear);
                    
                    loadBmBdmTables(monthYear);
                });

            });

            function loadRejectionReason(Id) {
                // Make an AJAX call to fetch rejection reason (Optional)
                fetch(`payout/forms/slab_payout_bdm/get_block_reason.php?id=${Id}&userType=<?php echo $userType; ?>`)
                    .then(response => response.text())
                    .then(data => {
                        document.getElementById("floatingTextarea").innerText = data;
                    })
                    .catch(error => console.error('Error:', error));
            }
        </script>
    </body>

    </html>

<?php } else {
    echo '<script>location.href = "index.php";</script>';
} ?>