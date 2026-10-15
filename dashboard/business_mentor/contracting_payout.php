<?php

    include_once (__DIR__.'/../dashboard_user_details.php');

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
    // echo "prev Date ".$prevdate.' ;';
    // echo "prev Month ".$prevDateMonth.' ;';
    // echo "prev year ".$prevDateYear.' ;';
    $columnDesignation = ['bm_id','ste_id','bm_user_id','business_mentor'];
    $columnMessage = ['message','ste_message','message_bm','message'];
    $columnCommision = ['comm_amt','ste_amount','payout_amount','comm_amt'];
    $columnStatus = ['status','ste_status','payout_status','status'];
    $tablename=['goa_bm_payout','techno_enterprise_payout','bm_payout_history','ca_payout'];
    $tablename_paid=['goa_bm_payout','techno_enterprise_payout_paid','bm_payout_history','ca_payout'];
?>

<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable">
    <head>

        <meta charset="utf-8" />
        <title>Business Mentor | TE Contracting Payout</title>
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
        <!-- custom Css-->
        <link href="../assets/css/custom.min.css" rel="stylesheet" type="text/css" />
        <!-- App Css-->
        <link href="../assets/css/app.min.css" rel="stylesheet" type="text/css" />
        <!-- custom Css developer-->
        <link rel="stylesheet" href="../assets/css/custom.css" />
        <link rel="stylesheet" href="../assets/css/business_mentor.css" />
        <link href="payout/payout.css" rel="stylesheet" type="text/css" /> 

        <!-- DataTables -->
        <link href="../assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
        <!-- Responsive datatable examples -->
        <link href="../assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" href="../assets/fontawesome/css/all.min.css" />
        <!-- FontAwesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" /> 
    </head>
    <body>

        <!-- Begin page -->
        <div id="layout-wrapper">

            <?php include_once 'business_mentor_header.php'; ?>

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

            <?php include_once 'business_mentor_sidebar.php'; ?>

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
                                        <h4 class="mb-sm-0">TE Contracting Payout</h4>
                                        <!-- <div class="page-title-right">
                                            <ol class="breadcrumb m-0">
                                                <li class="breadcrumb-item">
                                                    <a href="view_$columnDesignation.php">View</a>
                                                </li>
                                                <li class="breadcrumb-item active">Payout</li>
                                            </ol>
                                        </div> -->
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

                                                                            $previousPayout = $conn->prepare("
                                                                                SELECT SUM(previousPayout) AS previousPayout
                                                                                FROM (
                                                                                    SELECT SUM($columnCommision[0]) AS previousPayout
                                                                                    FROM $tablename[0]
                                                                                    WHERE $columnDesignation[0] = :userId
                                                                                    AND YEAR(created_date) = :prevYear
                                                                                    AND MONTH(created_date) = :prevMonth

                                                                                    UNION ALL

                                                                                    SELECT SUM($columnCommision[1]) AS previousPayout
                                                                                    FROM $tablename[1]
                                                                                    WHERE $columnDesignation[1] = :userId
                                                                                    AND YEAR(created_date) = :prevYear
                                                                                    AND MONTH(created_date) = :prevMonth

                                                                                    UNION ALL

                                                                                    SELECT SUM($columnCommision[2]) AS previousPayout
                                                                                    FROM $tablename[2]
                                                                                    WHERE $columnDesignation[2] = :userId
                                                                                    AND YEAR(payout_date) = :prevYear
                                                                                    AND MONTH(payout_date) = :prevMonth

                                                                                    UNION ALL

                                                                                    SELECT SUM($columnCommision[3]) AS previousPayout
                                                                                    FROM $tablename[3]
                                                                                    WHERE $columnDesignation[3] = :userId
                                                                                    AND YEAR(created_date) = :prevYear
                                                                                    AND MONTH(created_date) = :prevMonth
                                                                                ) AS payout_data
                                                                            ");

                                                                            $previousPayout->execute([
                                                                                ':userId'   => $userId,
                                                                                ':prevYear' => $prevDateYear,
                                                                                ':prevMonth' => $prevDateMonth
                                                                            ]);

                                                                            $row = $previousPayout->fetch(PDO::FETCH_ASSOC);

                                                                            $previousPayoutAmount = (float) ($row['previousPayout'] ?? 0);

                                                                            $previousPayoutTDS = $previousPayoutAmount * 2 / 100;

                                                                            $TotalpreviousPayout = $previousPayoutAmount - $previousPayoutTDS;

                                                                            echo '<p class="fs-5 fw-bolder mt-n2">
                                                                                    Rs. ' . round($TotalpreviousPayout) . '/-
                                                                                    <span class="badge bg-success font-size-10 fw-bold ms-4">Paid</span>
                                                                                </p>';

                                                                        ?>
                                                                        <a type="button" data-bs-toggle="modal" data-bs-target="#previousPayout" style=" cursor: pointer;">
                                                                            <p class="mt-n2 mb-1 fw-bold p1" style="color: #0096FF;">View Payout</p>
                                                                        </a>
                                                                        <a href="payout/forms/contracting_payout/download_exel_ca.php?payoutYear=<?php echo $prevDateYear; ?>&payoutMonth=<?php echo $prevDateMonth; ?>&payoutmessage=PreviousPayout&user_id=<?php echo $userId; ?>">
                                                                            <i class="bx bx-download download-icon1" style="font-size: 20px; color: black; margin-left: 20%;"></i>
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-6 col-md-6 col-sm-6 col-6 ">
                                                                    <div class="m-0 mt-2 p-2">
                                                                        <p class="font-size-14">Next Payout<span class="fw-bold font-size-10 date-layout "><?php echo "$date" ?></span></p>
                                                                        
                                                                        <?php

                                                                            $nextPayout = $conn->prepare("
                                                                                SELECT SUM(nextPayout) AS nextPayout
                                                                                FROM (
                                                                                    SELECT SUM($columnCommision[0]) AS nextPayout
                                                                                    FROM $tablename[0]
                                                                                    WHERE $columnDesignation[0] = :userId
                                                                                    AND YEAR(created_date) = :nextYear
                                                                                    AND MONTH(created_date) = :nextMonth

                                                                                    UNION ALL

                                                                                    SELECT SUM($columnCommision[1]) AS nextPayout
                                                                                    FROM $tablename[1]
                                                                                    WHERE $columnDesignation[1] = :userId
                                                                                    AND YEAR(created_date) = :nextYear
                                                                                    AND MONTH(created_date) = :nextMonth

                                                                                    UNION ALL

                                                                                    SELECT SUM($columnCommision[2]) AS nextPayout
                                                                                    FROM $tablename[2]
                                                                                    WHERE $columnDesignation[2] = :userId
                                                                                    AND YEAR(payout_date) = :nextYear
                                                                                    AND MONTH(payout_date) = :nextMonth

                                                                                    UNION ALL

                                                                                    SELECT SUM($columnCommision[3]) AS nextPayout
                                                                                    FROM $tablename[3]
                                                                                    WHERE $columnDesignation[3] = :userId
                                                                                    AND YEAR(created_date) = :nextYear
                                                                                    AND MONTH(created_date) = :nextMonth
                                                                                ) AS payout_data
                                                                            ");

                                                                            $nextPayout->execute([
                                                                                ':userId'   => $userId,
                                                                                ':nextYear' => $nextDateYear,
                                                                                ':nextMonth' => $nextDateMonth
                                                                            ]);

                                                                            $row2 = $nextPayout->fetch(PDO::FETCH_ASSOC);

                                                                            $nextPayoutTotal = (float) ($row2['nextPayout'] ?? 0);

                                                                            $nextPayoutTDS = $nextPayoutTotal * 2 / 100;

                                                                            $TotalNextPayout = $nextPayoutTotal - $nextPayoutTDS;

                                                                            echo '<p class="fs-5 fw-bolder mt-n2">
                                                                                    Rs. ' . round($TotalNextPayout) . '/-
                                                                                    <span class="badge bg-warning font-size-10 fw-bold ms-4">Pending</span>
                                                                                </p>';

                                                                        ?>
                                                                        <a type="button" data-bs-toggle="modal" data-bs-target="#nextPayout" style=" cursor: pointer;">
                                                                            <p class="mt-n2 mb-1 fw-bold p1" style="color: #0096FF;">View Payout</p>
                                                                        </a>
                                                                        <a href="payout/forms/contracting_payout/download_exel_ca.php?payoutYear=<?php echo $nextDateYear; ?>&payoutMonth=<?php echo $nextDateMonth; ?>&payoutmessage=NextPayout&user_id=<?php echo $userId; ?>">
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
                                                                                <span  class="font-size-10 rounded-4 d-block border-round">
                                                                                    <p class="fw-bold">Select month, year <span class="bx bx-calendar-alt callogo"></span></p> 
                                                                                </span>
                                                                            </div>
                                                                            <input type="month" id="month_year" value="" min="2020-01" max="" class="font-size-10 fw-bold rounded-4 d-none border-round">
                                                                        </p>
                                                                    </div>
                                                                    <?php

                                                                        $totalPayout = $conn->prepare("
                                                                            SELECT SUM(total_payable) AS total_payable
                                                                            FROM (
                                                                                SELECT SUM($columnCommision[0]) AS total_payable
                                                                                FROM $tablename[0]
                                                                                WHERE $columnDesignation[0] = :userId
                                                                                AND $columnStatus[0] = '1'

                                                                                UNION ALL

                                                                                SELECT SUM($columnCommision[1]) AS total_payable
                                                                                FROM $tablename[1]
                                                                                WHERE $columnDesignation[1] = :userId
                                                                                AND $columnStatus[1] = '1'

                                                                                UNION ALL

                                                                                SELECT SUM($columnCommision[2]) AS total_payable
                                                                                FROM $tablename[2]
                                                                                WHERE $columnDesignation[2] = :userId
                                                                                AND $columnStatus[2] = '1'

                                                                                UNION ALL

                                                                                SELECT SUM($columnCommision[3]) AS total_payable
                                                                                FROM $tablename[3]
                                                                                WHERE $columnDesignation[3] = :userId
                                                                                AND $columnStatus[3] = '1'
                                                                            ) AS payout_data
                                                                        ");

                                                                        $totalPayout->execute([
                                                                            ':userId' => $userId
                                                                        ]);

                                                                        $row = $totalPayout->fetch(PDO::FETCH_ASSOC);

                                                                        $total_payable = (float) ($row['total_payable'] ?? 0);

                                                                        $total_payableTDS = $total_payable * 2 / 100;

                                                                        $TotalPayout = $total_payable - $total_payableTDS;

                                                                        echo '<p class="fs-5 fw-bolder mt-n2 content1" id="TotalPayoutAmountDate">
                                                                                Rs. ' . number_format($TotalPayout, 2) . '/-
                                                                            </p>';

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

                                                                                $sql = "
                                                                                    SELECT
                                                                                        $columnDesignation[0] AS bm_id,
                                                                                        id,
                                                                                        techno_enterprise,
                                                                                        $columnCommision[0] AS commission,
                                                                                        $columnStatus[0] AS status,
                                                                                        $columnMessage[0] AS message,
                                                                                        created_date
                                                                                    FROM `$tablename[0]`
                                                                                    WHERE $columnDesignation[0] = :userId0

                                                                                    UNION ALL

                                                                                    SELECT
                                                                                        $columnDesignation[1] AS bm_id,
                                                                                        id,
                                                                                        te_id AS techno_enterprise,
                                                                                        $columnCommision[1] AS commission,
                                                                                        $columnStatus[1] AS status,
                                                                                        $columnMessage[1] AS message,
                                                                                        created_date
                                                                                    FROM `$tablename[1]`
                                                                                    WHERE $columnDesignation[1] = :userId1

                                                                                    UNION ALL

                                                                                    SELECT
                                                                                        $columnDesignation[2] AS bm_id,
                                                                                        id,
                                                                                        ca_user_id AS techno_enterprise,
                                                                                        $columnCommision[2] AS commission,
                                                                                        $columnStatus[2] AS status,
                                                                                        $columnMessage[2] AS message,
                                                                                        payout_date AS created_date
                                                                                    FROM `$tablename[2]`
                                                                                    WHERE $columnDesignation[2] = :userId2

                                                                                    UNION ALL

                                                                                    SELECT
                                                                                        $columnDesignation[3] AS bm_id,
                                                                                        id,
                                                                                        techno_enterprise,
                                                                                        $columnCommision[3] AS commission,
                                                                                        $columnStatus[3] AS status,
                                                                                        $columnMessage[3] AS message,
                                                                                        created_date
                                                                                    FROM `$tablename[3]`
                                                                                    WHERE $columnDesignation[3] = :userId3
                                                                                ";

                                                                                $stmt = $conn->prepare($sql);

                                                                                $stmt->execute([
                                                                                    ':userId0' => $userId,
                                                                                    ':userId1' => $userId,
                                                                                    ':userId2' => $userId,
                                                                                    ':userId3' => $userId
                                                                                ]);

                                                                                $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                                                                foreach ($rows as $row) {

                                                                                    // Format date
                                                                                    $dt = !empty($row['created_date'])
                                                                                        ? (new DateTime($row['created_date']))->format('Y-m-d')
                                                                                        : '';

                                                                                    // Format message
                                                                                    $message1 = str_replace('.', '<br>', $row['message'] ?? '');

                                                                                    // Commission amount
                                                                                    $CommAmt = is_numeric($row['commission'])
                                                                                        ? (float) $row['commission']
                                                                                        : 0;

                                                                                    // TDS deduction
                                                                                    $tds = $CommAmt * 2 / 100;

                                                                                    // Net payout
                                                                                    $totalAmt = $CommAmt - $tds;

                                                                                    // Download URL
                                                                                    $downloadUrl = 'payout/forms/contracting_payout/download_ca_payout.php?' .
                                                                                        http_build_query([
                                                                                            'vkvbvjfgfikix' => $row['id'],
                                                                                            'bc' => $row['bm_id'],
                                                                                            'ca' => $row['techno_enterprise'],
                                                                                            'date' => $dt,
                                                                                            'message' => $row['message'] ?? '',
                                                                                            'message_status' => $row['status'],
                                                                                            'commission' => $row['commission']
                                                                                        ]);

                                                                                    echo '<tr>
                                                                                            <td>' . htmlspecialchars($dt) . '</td>
                                                                                            <td>' . $message1 . '</td>
                                                                                            <td class="text-end">' . number_format($CommAmt, 2) . '</td>
                                                                                            <td class="text-end">' . number_format($tds, 2) . '</td>
                                                                                            <td class="text-end">' . number_format($totalAmt, 2) . '
                                                                                                <a href="' . htmlspecialchars($downloadUrl, ENT_QUOTES, 'UTF-8') . '">
                                                                                                    <i class="bx bx-download"
                                                                                                    style="font-size:18px;color:black;padding-left:5px;"></i>
                                                                                                </a>
                                                                                            </td>';

                                                                                    if ((string) $row['status'] === '1') {
                                                                                        echo '<td>
                                                                                                <span class="badge bg-success font-size-10 fw-bold ms-4">
                                                                                                    Paid
                                                                                                </span>
                                                                                            </td>';
                                                                                    } else {
                                                                                        echo '<td>
                                                                                                <span class="badge bg-warning font-size-10 fw-bold ms-4">
                                                                                                    Pending
                                                                                                </span>
                                                                                            </td>';
                                                                                    }

                                                                                    echo '</tr>';
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
                                    <input type="text" name="" id="userIDHidden" value="<?php echo $userId ?>" >
                                    <input type="text" name="" id="userTypeHidden" value="<?php echo $userType ?>" >
                                    <input type="text" name="" id="userFnameHidden" value="<?php echo $userFname ?>" >
                                    <input type="text" name="" id="userLnameHidden" value="<?php echo $userLname ?>" >
                                </div>

                            </div>
                        </div>
                    </div> <!-- container-fluid -->
                </div><!-- End Page-content -->
                <?php include_once "business_mentor_footer.php" ?> 
            </div><!-- end main content-->
        </div><!-- END layout-wrapper -->


        <!-- sample modal content -->
        <div id="previousPayout" class="modal fade" tabindex="-1" aria-labelledby="#exampleModalFullscreenLabel" aria-hidden="true" data-bs-backdrop="static"  data-bs-keyboard="false" style=" border-radus: 20px !important;">
            <div class="modal-dialog modal-fullscreen" style="width: 80%; margin: auto; margin-top: 30px; margin-bottom: 30px; height: 90vh;" >
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

                                            $previousPayout = $conn->prepare("
                                                SELECT SUM(previousPayout) AS previousPayout
                                                FROM (
                                                    SELECT SUM($columnCommision[0]) AS previousPayout
                                                    FROM $tablename[0]
                                                    WHERE $columnDesignation[0] = :userId0
                                                    AND YEAR(created_date) = :prevYear0
                                                    AND MONTH(created_date) = :prevMonth0

                                                    UNION ALL

                                                    SELECT SUM($columnCommision[1]) AS previousPayout
                                                    FROM $tablename[1]
                                                    WHERE $columnDesignation[1] = :userId1
                                                    AND YEAR(created_date) = :prevYear1
                                                    AND MONTH(created_date) = :prevMonth1

                                                    UNION ALL

                                                    SELECT SUM($columnCommision[2]) AS previousPayout
                                                    FROM $tablename[2]
                                                    WHERE $columnDesignation[2] = :userId2
                                                    AND YEAR(payout_date) = :prevYear2
                                                    AND MONTH(payout_date) = :prevMonth2

                                                    UNION ALL

                                                    SELECT SUM($columnCommision[3]) AS previousPayout
                                                    FROM $tablename[3]
                                                    WHERE $columnDesignation[3] = :userId3
                                                    AND YEAR(created_date) = :prevYear3
                                                    AND MONTH(created_date) = :prevMonth3
                                                ) AS payout_data
                                            ");

                                            $previousPayout->execute([
                                                ':userId0' => $userId,
                                                ':prevYear0' => $prevDateYear,
                                                ':prevMonth0' => $prevDateMonth,

                                                ':userId1' => $userId,
                                                ':prevYear1' => $prevDateYear,
                                                ':prevMonth1' => $prevDateMonth,

                                                ':userId2' => $userId,
                                                ':prevYear2' => $prevDateYear,
                                                ':prevMonth2' => $prevDateMonth,

                                                ':userId3' => $userId,
                                                ':prevYear3' => $prevDateYear,
                                                ':prevMonth3' => $prevDateMonth
                                            ]);

                                            $row = $previousPayout->fetch(PDO::FETCH_ASSOC);

                                            $previousPayoutAmount = (float) ($row['previousPayout'] ?? 0);

                                            $previousPayoutTDS = $previousPayoutAmount * 2 / 100;

                                            $TotalpreviousPayout = $previousPayoutAmount - $previousPayoutTDS;

                                            echo '<p class="fs-5 font fw-bolder mt-n2 icon">
                                                    Rs.' . round($TotalpreviousPayout) . '/-
                                                </p>
                                                <span class="badge bg-success font-size-10 fw-bold status1 paystatus"
                                                        style="height: 15px !important; margin-top: 16px;"
                                                        readonly>Paid</span>';

                                        ?>
                                        
                                        <a href="payout/forms/contracting_payout/download_exel_ca.php?payoutYear=<?php echo $prevDateYear; ?>&payoutMonth=<?php echo $prevDateMonth; ?>&payoutmessage=PreviousPayout">
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
                                        <input type="text" name="" class="selectdesign filter-opt-1 fw-bolder" id="designationPrevious" value="<?php echo 'ID: ' .$userId; ?>" readonly>
                                    </div>
                                    <div class="name-filter no-space col-lg-5 col-md-5 col-sm-12" >
                                        <input type="text" name="" class="sselectdesign filter-opt-2 minimal fw-bolder" id="user_id_namePrevious" value="<?php echo 'Name: ' .$firstname.' '.$lastname; ?>" readonly>
                                    </div>
                                    <span id="prevDiv" class="col-md-10 card border-2 border-black" style="border-radius: 10px; padding: 10px">
                                        <div  id="download_icon " >
                                            <p class="font-size-14">Name: <span><?php echo $firstname.' '.$lastname; ?></span><span class="fw-bold font-size-10 ms-4 date-layout layout-2 date-align"><?php echo "$prevdate" ?></span></p>
                                            <p class="fs-5 fw-bolder mt-n2 icon">Rs. <?php echo round($TotalpreviousPayout); ?>/- </p>
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

                                                    $sql2 = "
                                                        SELECT
                                                            $columnDesignation[0] AS bm_id,
                                                            id,
                                                            techno_enterprise,
                                                            $columnCommision[0] AS commission,
                                                            $columnStatus[0] AS status,
                                                            $columnMessage[0] AS message,
                                                            created_date
                                                        FROM `$tablename[0]`
                                                        WHERE $columnDesignation[0] = :userId0
                                                        AND YEAR(created_date) = :year0
                                                        AND MONTH(created_date) = :month0

                                                        UNION ALL

                                                        SELECT
                                                            $columnDesignation[1] AS bm_id,
                                                            id,
                                                            te_id AS techno_enterprise,
                                                            $columnCommision[1] AS commission,
                                                            $columnStatus[1] AS status,
                                                            $columnMessage[1] AS message,
                                                            created_date
                                                        FROM `$tablename[1]`
                                                        WHERE $columnDesignation[1] = :userId1
                                                        AND YEAR(created_date) = :year1
                                                        AND MONTH(created_date) = :month1

                                                        UNION ALL

                                                        SELECT
                                                            $columnDesignation[2] AS bm_id,
                                                            id,
                                                            ca_user_id AS techno_enterprise,
                                                            $columnCommision[2] AS commission,
                                                            $columnStatus[2] AS status,
                                                            $columnMessage[2] AS message,
                                                            payout_date AS created_date
                                                        FROM `$tablename[2]`
                                                        WHERE $columnDesignation[2] = :userId2
                                                        AND YEAR(payout_date) = :year2
                                                        AND MONTH(payout_date) = :month2

                                                        UNION ALL

                                                        SELECT
                                                            $columnDesignation[3] AS bm_id,
                                                            id,
                                                            techno_enterprise,
                                                            $columnCommision[3] AS commission,
                                                            $columnStatus[3] AS status,
                                                            $columnMessage[3] AS message,
                                                            created_date
                                                        FROM `$tablename[3]`
                                                        WHERE $columnDesignation[3] = :userId3
                                                        AND YEAR(created_date) = :year3
                                                        AND MONTH(created_date) = :month3
                                                    ";

                                                    $stmt = $conn->prepare($sql2);

                                                    $stmt->execute([
                                                        ':userId0' => $userId,
                                                        ':year0'   => $prevDateYear,
                                                        ':month0'  => $prevDateMonth,

                                                        ':userId1' => $userId,
                                                        ':year1'   => $prevDateYear,
                                                        ':month1'  => $prevDateMonth,

                                                        ':userId2' => $userId,
                                                        ':year2'   => $prevDateYear,
                                                        ':month2'  => $prevDateMonth,

                                                        ':userId3' => $userId,
                                                        ':year3'   => $prevDateYear,
                                                        ':month3'  => $prevDateMonth
                                                    ]);

                                                    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                                    foreach ($rows as $row) {

                                                        // Format date
                                                        $dt = !empty($row['created_date'])
                                                            ? (new DateTime($row['created_date']))->format('Y-m-d')
                                                            : '';

                                                        // Format message
                                                        $message1 = str_replace(
                                                            '.',
                                                            '<br>',
                                                            $row['message'] ?? ''
                                                        );

                                                        // Commission amount
                                                        $CommAmt = is_numeric($row['commission'])
                                                            ? (float) $row['commission']
                                                            : 0;

                                                        // TDS calculation
                                                        $tds = $CommAmt * 2 / 100;

                                                        // Net amount
                                                        $totalAmt = $CommAmt - $tds;

                                                        // Common row values
                                                        $bmId = $row['bm_id'];
                                                        $commission = $row['commission'] ?? 0;
                                                        $message = $row['message'] ?? '';
                                                        $status = $row['status'];

                                                        // Download URL
                                                        $downloadUrl = 'payout/forms/contracting_payout/download_ca_payout.php?' .
                                                            http_build_query([
                                                                'vkvbvjfgfikix' => $row['id'],
                                                                'bc' => $bmId,
                                                                'ca' => $row['techno_enterprise'],
                                                                'date' => $dt,
                                                                'message' => $message,
                                                                'message_status' => $status,
                                                                'commission' => $commission
                                                            ]);

                                                        echo '<tr>
                                                            <td>' . htmlspecialchars($dt) . '</td>
                                                            <td>' . $message1 . '</td>
                                                            <td class="text-end">' . number_format($CommAmt, 2) . '</td>
                                                            <td class="text-end">' . number_format($tds, 2) . '</td>
                                                            <td class="text-end">' . number_format($totalAmt, 2) . '
                                                                <a href="' . htmlspecialchars($downloadUrl, ENT_QUOTES, 'UTF-8') . '">
                                                                    <i class="bx bx-download"
                                                                    style="font-size:18px;color:black;padding-left:5px;"></i>
                                                                </a>
                                                            </td>';

                                                        if ((string) $status === '1') {

                                                            echo '<td>
                                                                <span class="badge bg-success font-size-10 fw-bold ms-4">
                                                                    Paid
                                                                </span>
                                                            </td>';

                                                        } else {

                                                            echo '<td>
                                                                <span class="badge bg-warning font-size-10 fw-bold ms-4"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target=".bs-example-modal-center"
                                                                    onclick=\'paymentId(' .
                                                                        json_encode((string) $row['id']) . ',' .
                                                                        json_encode((string) $bmId) . ',' .
                                                                        json_encode((string) $message) . ',' .
                                                                        json_encode((string) $commission) . ',' .
                                                                        json_encode((string) $status) . ',"PrevPayout")\'>
                                                                    Pending
                                                                </span>
                                                            </td>';
                                                        }

                                                        echo '</tr>';
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
                        <input type="text" name="" id="prevMonth" value="<?php echo $prevDateMonth ?>" >
                        <input type="text" name="" id="prevYear" value="<?php echo $prevDateYear ?>" >
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Close</button>
                        <!-- <button type="button" class="btn btn-primary waves-effect waves-light">Save changes</button> -->
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
        <!-- sample modal content -->
        <div id="nextPayout" class="modal fade" tabindex="-1" aria-labelledby="#exampleModalFullscreenLabel" aria-hidden="true" data-bs-backdrop="static"  data-bs-keyboard="false" style=" border-radus: 20px !important;">
            <div class="modal-dialog modal-fullscreen" style="width: 80%; margin: auto; margin-top: 30px; margin-bottom: 30px; height: 90vh;" >
                <div class="modal-content modal-radius">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalFullscreenLabel">Next Payout</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row d-flex justify-content-evenly">   
                            <div class="col-lg-4 col-md-4 col-sm-7 card" style="border: 2px solid black; border-radius: 10px;">
                                <div class="mt-3">
                                    <p class="font-size-18 pt-3">Next Payout<span class="fw-bold font-size-12 date-layout layout-1"><?php echo "$date" ?></span></p>
                                    <div class="d-flex">
                                        <?php

                                            $nextPayout = $conn->prepare("
                                                SELECT SUM(nextPayout) AS nextPayout
                                                FROM (
                                                    SELECT SUM($columnCommision[0]) AS nextPayout
                                                    FROM $tablename[0]
                                                    WHERE $columnDesignation[0] = :userId0
                                                    AND YEAR(created_date) = :year0
                                                    AND MONTH(created_date) = :month0

                                                    UNION ALL

                                                    SELECT SUM($columnCommision[1]) AS nextPayout
                                                    FROM $tablename[1]
                                                    WHERE $columnDesignation[1] = :userId1
                                                    AND YEAR(created_date) = :year1
                                                    AND MONTH(created_date) = :month1

                                                    UNION ALL

                                                    SELECT SUM($columnCommision[2]) AS nextPayout
                                                    FROM $tablename[2]
                                                    WHERE $columnDesignation[2] = :userId2
                                                    AND YEAR(payout_date) = :year2
                                                    AND MONTH(payout_date) = :month2

                                                    UNION ALL

                                                    SELECT SUM($columnCommision[3]) AS nextPayout
                                                    FROM $tablename[3]
                                                    WHERE $columnDesignation[3] = :userId3
                                                    AND YEAR(created_date) = :year3
                                                    AND MONTH(created_date) = :month3
                                                ) AS payout_data
                                            ");

                                            $nextPayout->execute([
                                                ':userId0' => $userId,
                                                ':year0'   => $nextDateYear,
                                                ':month0'  => $nextDateMonth,

                                                ':userId1' => $userId,
                                                ':year1'   => $nextDateYear,
                                                ':month1'  => $nextDateMonth,

                                                ':userId2' => $userId,
                                                ':year2'   => $nextDateYear,
                                                ':month2'  => $nextDateMonth,

                                                ':userId3' => $userId,
                                                ':year3'   => $nextDateYear,
                                                ':month3'  => $nextDateMonth
                                            ]);

                                            $row2 = $nextPayout->fetch(PDO::FETCH_ASSOC);

                                            $nextPayoutTotal = (float) ($row2['nextPayout'] ?? 0);

                                            $nextPayoutTDS = $nextPayoutTotal * 2 / 100;

                                            $TotalNextPayout = $nextPayoutTotal - $nextPayoutTDS;

                                            echo '<p class="fs-5 font fw-bolder mt-n2 icon">
                                                    Rs.' . round($TotalNextPayout) . '/-
                                                </p>
                                                <span class="badge bg-success font-size-10 fw-bold status1 paystatus"
                                                        style="height: 15px !important; margin-top: 16px;"
                                                        readonly>Paid</span>';

                                        ?>
                                        
                                        <a href="payout/forms/contracting_payout/download_exel_ca.php?payoutYear=<?php echo $prevDateYear; ?>&payoutMonth=<?php echo $prevDateMonth; ?>&payoutmessage=PreviousPayout">
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
                                        <input type="text" name="" class="selectdesign filter-opt-1 fw-bolder" id="designationNext" value="<?php echo 'ID: ' .$userId; ?>" readonly>
                                    </div>
                                    <div class="name-filter no-space col-lg-5 col-md-5 col-sm-12">
                                        <input type="text" name="" class="selectdesign filter-opt-2 minimal fw-bolder" id="user_id_nameNext" value="<?php echo 'Name: ' .$firstname.' '.$lastname; ?>" readonly>
                                    </div>
                                    <span id="nextDiv" class="col-md-10 card border-2 border-black" style="border-radius: 10px; padding: 10px">
                                        <div  id="download_icon " >
                                            <p class="font-size-14">Name: <span><?php echo $firstname.' '.$lastname; ?></span><span class="fw-bold font-size-10 ms-4 date-layout layout-2 date-align"><?php echo "$date" ?></span></p>
                                            <p class="fs-5 fw-bolder mt-n2 icon">Rs. <?php echo round($TotalNextPayout); ?>/- </p>
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

                                                    $sql3 = "
                                                        SELECT
                                                            $columnDesignation[0] AS bm_id,
                                                            id,
                                                            techno_enterprise,
                                                            $columnCommision[0] AS commission,
                                                            $columnStatus[0] AS status,
                                                            $columnMessage[0] AS message,
                                                            created_date
                                                        FROM `$tablename[0]`
                                                        WHERE $columnDesignation[0] = :userId0
                                                        AND YEAR(created_date) = :year0
                                                        AND MONTH(created_date) = :month0

                                                        UNION ALL

                                                        SELECT
                                                            $columnDesignation[1] AS bm_id,
                                                            id,
                                                            te_id AS techno_enterprise,
                                                            $columnCommision[1] AS commission,
                                                            $columnStatus[1] AS status,
                                                            $columnMessage[1] AS message,
                                                            created_date
                                                        FROM `$tablename[1]`
                                                        WHERE $columnDesignation[1] = :userId1
                                                        AND YEAR(created_date) = :year1
                                                        AND MONTH(created_date) = :month1

                                                        UNION ALL

                                                        SELECT
                                                            $columnDesignation[2] AS bm_id,
                                                            id,
                                                            ca_user_id AS techno_enterprise,
                                                            $columnCommision[2] AS commission,
                                                            $columnStatus[2] AS status,
                                                            $columnMessage[2] AS message,
                                                            payout_date AS created_date
                                                        FROM `$tablename[2]`
                                                        WHERE $columnDesignation[2] = :userId2
                                                        AND YEAR(payout_date) = :year2
                                                        AND MONTH(payout_date) = :month2

                                                        UNION ALL

                                                        SELECT
                                                            $columnDesignation[3] AS bm_id,
                                                            id,
                                                            techno_enterprise,
                                                            $columnCommision[3] AS commission,
                                                            $columnStatus[3] AS status,
                                                            $columnMessage[3] AS message,
                                                            created_date
                                                        FROM `$tablename[3]`
                                                        WHERE $columnDesignation[3] = :userId3
                                                        AND YEAR(created_date) = :year3
                                                        AND MONTH(created_date) = :month3
                                                    ";

                                                    $stmt = $conn->prepare($sql3);

                                                    $stmt->execute([
                                                        ':userId0' => $userId,
                                                        ':year0'   => $nextDateYear,
                                                        ':month0'  => $nextDateMonth,

                                                        ':userId1' => $userId,
                                                        ':year1'   => $nextDateYear,
                                                        ':month1'  => $nextDateMonth,

                                                        ':userId2' => $userId,
                                                        ':year2'   => $nextDateYear,
                                                        ':month2'  => $nextDateMonth,

                                                        ':userId3' => $userId,
                                                        ':year3'   => $nextDateYear,
                                                        ':month3'  => $nextDateMonth
                                                    ]);

                                                    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                                    foreach ($rows as $row) {

                                                        // Format date
                                                        $dt = !empty($row['created_date'])
                                                            ? (new DateTime($row['created_date']))->format('Y-m-d')
                                                            : '';

                                                        // Format message
                                                        $message = $row['message'] ?? '';
                                                        $message1 = str_replace('.', '<br>', $message);

                                                        // Commission amount
                                                        $CommAmt = is_numeric($row['commission'])
                                                            ? (float) $row['commission']
                                                            : 0;

                                                        // TDS calculation
                                                        $tds = $CommAmt * 2 / 100;

                                                        // Net payout
                                                        $totalAmt = $CommAmt - $tds;

                                                        $bmId = $row['bm_id'];
                                                        $commission = $row['commission'] ?? 0;
                                                        $status = $row['status'];

                                                        // Download URL
                                                        $downloadUrl = 'payout/forms/contracting_payout/download_ca_payout.php?' .
                                                            http_build_query([
                                                                'vkvbvjfgfikix' => $row['id'],
                                                                'bc' => $bmId,
                                                                'ca' => $row['techno_enterprise'],
                                                                'date' => $dt,
                                                                'message' => $message,
                                                                'message_status' => $status,
                                                                'commission' => $commission
                                                            ]);

                                                        echo '<tr>
                                                            <td>' . htmlspecialchars($dt) . '</td>
                                                            <td>' . $message1 . '</td>
                                                            <td class="text-end">' . number_format($CommAmt, 2) . '</td>
                                                            <td class="text-end">' . number_format($tds, 2) . '</td>
                                                            <td class="text-end">' . number_format($totalAmt, 2) . '
                                                                <a href="' . htmlspecialchars($downloadUrl, ENT_QUOTES, 'UTF-8') . '">
                                                                    <i class="bx bx-download"
                                                                    style="font-size:18px;color:black;padding-left:5px;"></i>
                                                                </a>
                                                            </td>';

                                                        if ((string) $status === '1') {

                                                            echo '<td>
                                                                <span class="badge bg-success font-size-10 fw-bold ms-4">
                                                                    Paid
                                                                </span>
                                                            </td>';

                                                        } else {

                                                            echo '<td>
                                                                <span class="badge bg-warning font-size-10 fw-bold ms-4"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target=".bs-example-modal-center"
                                                                    onclick=\'paymentId(' .
                                                                        json_encode((string) $row['id']) . ',' .
                                                                        json_encode((string) $bmId) . ',' .
                                                                        json_encode((string) $message) . ',' .
                                                                        json_encode((string) $commission) . ',' .
                                                                        json_encode((string) $status) . ',"NextPayout")\'>
                                                                    Pending
                                                                </span>
                                                            </td>';
                                                        }

                                                        echo '</tr>';
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
                        <input type="text" name="" id="nextMonth" value="<?php echo $nextDateMonth ?>" >
                        <input type="text" name="" id="nextYear" value="<?php echo $nextDateYear ?>" >
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Close</button>
                        <!-- <button type="button" class="btn btn-primary waves-effect waves-light">Save changes</button> -->
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
        <!-- sample modal content -->
        <div id="totalPayout" class="modal fade" tabindex="-1" aria-labelledby="#exampleModalFullscreenLabel" aria-hidden="true" data-bs-backdrop="static"  data-bs-keyboard="false" style=" border-radus: 20px !important;">
            <div class="modal-dialog modal-fullscreen" style="width: 80%; margin: auto; margin-top: 30px; margin-bottom: 30px; height: 90vh;" >
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

                                            $totalPayout = $conn->prepare("
                                                SELECT SUM(total_payable) AS total_payable
                                                FROM (
                                                    SELECT SUM($columnCommision[0]) AS total_payable
                                                    FROM $tablename[0]
                                                    WHERE $columnDesignation[0] = :userId0
                                                    AND $columnStatus[0] = '1'

                                                    UNION ALL

                                                    SELECT SUM($columnCommision[1]) AS total_payable
                                                    FROM $tablename[1]
                                                    WHERE $columnDesignation[1] = :userId1
                                                    AND $columnStatus[1] = '1'

                                                    UNION ALL

                                                    SELECT SUM($columnCommision[2]) AS total_payable
                                                    FROM $tablename[2]
                                                    WHERE $columnDesignation[2] = :userId2
                                                    AND $columnStatus[2] = '1'

                                                    UNION ALL

                                                    SELECT SUM($columnCommision[3]) AS total_payable
                                                    FROM $tablename[3]
                                                    WHERE $columnDesignation[3] = :userId3
                                                    AND $columnStatus[3] = '1'
                                                ) AS payout_data
                                            ");

                                            $totalPayout->execute([
                                                ':userId0' => $userId,
                                                ':userId1' => $userId,
                                                ':userId2' => $userId,
                                                ':userId3' => $userId
                                            ]);

                                            $totalPayout->setFetchMode(PDO::FETCH_ASSOC);

                                            $row = $totalPayout->fetch();

                                            $total_payable = $row['total_payable'] ?? 0;

                                            echo '
                                                <p class="fs-5 font fw-bolder mt-n2 icon">
                                                    Rs.' . number_format((float)$total_payable, 2) . '/-
                                                </p>

                                                <span class="badge bg-success font-size-10 fw-bold status1 paystatus"
                                                    style="height: 15px !important; margin-top: 16px;"
                                                    readonly>
                                                    Paid
                                                </span>
                                            ';

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
                                        <input type="text" name="" class="selectdesign filter-opt-1 fw-bolder" id="designationNext" value="<?php echo 'ID: ' .$userId; ?>" readonly>
                                    </div>
                                    <div class="name-filter no-space col-lg-5 col-md-5 col-sm-12">
                                        <input type="text" name="" class="selectdesign filter-opt-2 minimal fw-bolder" id="user_id_nameNext" value="<?php echo 'Name: ' .$firstname.' '.$lastname; ?>" readonly>
                                    </div>
                                    <!-- <form class=" col-md-4 app-search d-lg-block">
                                        <div class="position-relative">
                                            <span class="bx bx-search-alt"></span>
                                            <input type="text" class="form-control search control" placeholder="Search...">
                                        </div>
                                    </form> -->
                                    <span id="totalDiv" class="col-md-10 card border-2 border-black" style="border-radius: 10px; padding: 10px">
                                        <div  id="download_icon " >
                                            <p class="font-size-14">Name: <span><?php echo $firstname.' '.$lastname; ?></span><span class="fw-bold font-size-10 ms-4 date-layout layout-2 date-align"><?php echo "$date" ?></span></p>
                                            <p class="fs-5 fw-bolder mt-n2 icon">Rs. <?php echo $total_payable; ?>/- </p>
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
                                                    <th class="ceterText fw-bolder font-size-16">Payout Details</th>
                                                    <th class="ceterText fw-bolder font-size-16">Amount</th>
                                                    <th class="ceterText fw-bolder font-size-16">TDS</th>
                                                    <th class="ceterText fw-bolder font-size-16">Total Payable</th>
                                                    <th class="ceterText fw-bolder font-size-16">Remark</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php

                                                    $sql4 = "
                                                        SELECT *
                                                        FROM (
                                                            SELECT
                                                                id,
                                                                $columnDesignation[0] AS bm_id,
                                                                $columnCommision[0] AS commission,
                                                                $columnStatus[0] AS status,
                                                                $columnMessage[0] AS message,
                                                                '' AS message_details,
                                                                created_date,
                                                                techno_enterprise
                                                            FROM $tablename_paid[0]
                                                            WHERE $columnDesignation[0] = :userId0
                                                            AND $columnStatus[0] = '1'

                                                            UNION ALL

                                                            SELECT
                                                                id,
                                                                $columnDesignation[1] AS bm_id,
                                                                paid_amount AS commission,
                                                                status,
                                                                payment_message AS message,
                                                                payment_message AS message_details,
                                                                date AS created_date,
                                                                te_id AS techno_enterprise
                                                            FROM $tablename_paid[1]
                                                            WHERE $columnDesignation[1] = :userId1
                                                            AND status = '1'

                                                            UNION ALL

                                                            SELECT
                                                                id,
                                                                $columnDesignation[2] AS bm_id,
                                                                $columnCommision[2] AS commission,
                                                                $columnStatus[2] AS status,
                                                                $columnMessage[2] AS message,
                                                                '' AS message_details,
                                                                payout_date AS created_date,
                                                                ca_user_id AS techno_enterprise
                                                            FROM $tablename_paid[2]
                                                            WHERE $columnDesignation[2] = :userId2
                                                            AND $columnStatus[2] = '1'

                                                            UNION ALL

                                                            SELECT
                                                                id,
                                                                $columnDesignation[3] AS bm_id,
                                                                $columnCommision[3] AS commission,
                                                                $columnStatus[3] AS status,
                                                                $columnMessage[3] AS message,
                                                                message_details,
                                                                created_date,
                                                                techno_enterprise
                                                            FROM $tablename_paid[3]
                                                            WHERE $columnDesignation[3] = :userId3
                                                            AND $columnStatus[3] = '1'
                                                        ) AS payout_data
                                                        ORDER BY created_date DESC
                                                    ";

                                                    $stmt = $conn->prepare($sql4);

                                                    $stmt->execute([
                                                        ':userId0' => $userId,
                                                        ':userId1' => $userId,
                                                        ':userId2' => $userId,
                                                        ':userId3' => $userId
                                                    ]);

                                                    $stmt->setFetchMode(PDO::FETCH_ASSOC);

                                                    while ($row = $stmt->fetch()) {

                                                        // Date formatting
                                                        $dt = !empty($row['created_date'])
                                                            ? (new DateTime($row['created_date']))->format('Y-m-d')
                                                            : '';

                                                        // Message formatting
                                                        $message1 = str_replace('.', '.<br>', $row['message'] ?? '');
                                                        $message_details = str_replace('.', '.<br>', $row['message_details'] ?? '');

                                                        // Commission and TDS calculation
                                                        $CommAmt = is_numeric($row['commission'])
                                                            ? (float) $row['commission']
                                                            : 0;

                                                        $tds = $CommAmt * 2 / 100;
                                                        $totalAmt = $CommAmt - $tds;

                                                        // Download URL
                                                        $downloadParams = http_build_query([
                                                            'vkvbvjfgfikix' => $row['id'],
                                                            'bc' => $row['bm_id'],
                                                            'ca' => $row['techno_enterprise'],
                                                            'date' => $dt,
                                                            'message' => $row['message'],
                                                            'message_status' => $row['status'],
                                                            'commission' => $row['commission']
                                                        ]);

                                                        $downloadUrl = 'payout/forms/contracting_payout/download_ca_payout.php?' . $downloadParams;

                                                        echo '
                                                            <tr>
                                                                <td>' . htmlspecialchars($dt) . '</td>
                                                                <td>' . $message1 . '</td>
                                                                <td>' . $message_details . '</td>
                                                                <td class="text-end">' . number_format($CommAmt, 2) . '</td>
                                                                <td class="text-end">' . number_format($tds, 2) . '</td>
                                                                <td class="text-end">
                                                                    ' . number_format($totalAmt, 2) . '
                                                                    <a href="' . htmlspecialchars($downloadUrl, ENT_QUOTES, 'UTF-8') . '">
                                                                        <i class="bx bx-download"
                                                                        style="font-size: 18px; color: black; padding-left: 5px;"></i>
                                                                    </a>
                                                                </td>';

                                                        if ($row['status'] == '1') {
                                                            echo '
                                                                <td>
                                                                    <span class="badge bg-success font-size-10 fw-bold ms-4">
                                                                        Paid
                                                                    </span>
                                                                </td>';
                                                        } else {
                                                            echo '
                                                                <td>
                                                                    <span class="badge bg-warning font-size-10 fw-bold ms-4"
                                                                        data-bs-toggle="modal"
                                                                        data-bs-target=".bs-example-modal-center"
                                                                        onclick=\'paymentId(' .
                                                                            json_encode((string) $row['id']) . ',' .
                                                                            json_encode((string) $row['bm_id']) . ',' .
                                                                            json_encode((string) $row['message']) . ',' .
                                                                            json_encode((string) $row['commission']) . ',' .
                                                                            json_encode((string) $row['status']) . ',"TotalPayout")\'>
                                                                        Pending
                                                                    </span>
                                                                </td>';
                                                        }

                                                        echo '</tr>';
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
        <div class="modal fade bs-example-modal-center" tabindex="-1" role="dialog" aria-hidden="true"  data-bs-backdrop="static"  data-bs-keyboard="false">
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
                            <textarea id="paymentMessage" name="paymentMessage" rows="4" cols="65" class="input2 w-100" ></textarea>
                        </div>  
                        <div class="modal-footer">
                            <button type="button" id="submitPayment" class="btn btn-success rounded-3" data-dismiss="modal">Submit</button>
                        </div> 
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
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
        <!-- <script src="../assets/js/pages/plugins/lord-icon-2.1.0.js"></script> -->
        <!-- <script src="../assets/js/plugins.js"></script> -->

        <script src="../assets/js/submitdata.js"></script>

        <!-- !-- materialdesign icon js- -->
        <script src="../assets/js/pages/remix-icons-listing.js"></script>

        <!-- apexcharts -->
        <script src="../assets/libs/apexcharts/apexcharts.min.js"></script>

        <!-- Vector map-->
        <script src="../assets/libs/jsvectormap/js/jsvectormap.min.js"></script>
        <script src="../assets/libs/jsvectormap/maps/world-merc.js"></script>

        <!--Swiper slider js-->
        <script src="../assets/libs/swiper/swiper-bundle.min.js"></script>

        <!-- Dashboard init -->
        <!-- <script src="../assets/js/pages/dashboard-ecommerce.init.js"></script> -->

        <!-- App js -->
        <script src="../assets/js/app.js"></script>

        <!-- custom js  -->
        <script src="payout/payout_contracting.js"></script>
        <!-- Chart JS -->
        <!-- <script src="../assets/libs/chart.js/chart.umd.js"></script> -->

        <!-- chartjs init -->
        <!-- <script src="../assets/js/pages/chartjs.init.js"></script> -->

        <!-- Dashboard init -->
        <!-- <script src="../assets/js/pages/dashboard-job.init.js"></script> -->

        <!-- ** designation user, user name on designation select / get country, state, city, pincode **  -->

        <!-- Required datatable js -->
        <script src="../assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
        <script src="../assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>

        <!-- Responsive examples -->
        <script src="../assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
        <script src="../assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>
        <script>
            $(document).ready(function () {

                const tableIds = [
                    '#payoutDetailsTable',
                    '#previous_payout_table',
                    '#next_payout_table',
                    '#total_payout_table'
                ];

                tableIds.forEach(function (tableId) {

                    const $table = $(tableId);

                    // Skip if the table does not exist.
                    if (!$table.length) {
                        return;
                    }

                    // Skip if DataTables is already initialized.
                    if ($.fn.DataTable.isDataTable(tableId)) {
                        return;
                    }

                    // Initialize DataTables even when the table has no data.
                    $table.DataTable({
                        responsive: true,
                        pageLength: 10,
                        lengthChange: true,
                        lengthMenu: [10, 25, 50, 100],
                        language: {
                            emptyTable: 'No payout records found.',
                            zeroRecords: 'No matching payout records found.'
                        }
                    });
                });

            });

        </script>
        <!-- Sidebar Start -->
        <script>
            document.addEventListener("DOMContentLoaded", function () {

                const sidebar = document.querySelector(".navbar-menu");
                const hamburger = document.getElementById("topnav-hamburger-icon");
                const hamburgerIcon = document.querySelector(".hamburger-icon");
                const overlay = document.querySelector(".vertical-overlay");

                if (window.innerWidth > 1024) {
                    sidebar.classList.remove("sidebar-hidden");
                }

                hamburger.addEventListener("click", function () {

                    if (window.innerWidth <= 1024) {

                        /* BELOW 767 - YOUR ORIGINAL WORKING LOGIC */
                        if (window.innerWidth <= 767) {

                            sidebar.classList.toggle("sidebar-mobile-show");
                            hamburgerIcon.classList.toggle("open");

                            if (overlay) {
                                overlay.classList.toggle("active");
                            }
                        }

                        /* 768px TO 1024px */
                        else {

                            if (!sidebar.classList.contains("sidebar-mobile-show")) {

                                sidebar.classList.add("sidebar-mobile-show");

                                if (overlay) {
                                    overlay.classList.add("active");
                                }

                                /* SHOW 3 LINES */
                                hamburgerIcon.classList.add("open");

                            } else {

                                sidebar.classList.remove("sidebar-mobile-show");

                                if (overlay) {
                                    overlay.classList.remove("active");
                                }

                                /* SHOW ARROW */
                                hamburgerIcon.classList.remove("open");
                            }
                        }

                    } else {

                        /* DESKTOP */
                        sidebar.classList.toggle("sidebar-hidden");
                    }
                });

                if (overlay) {

                    overlay.addEventListener("click", function () {

                        sidebar.classList.remove("sidebar-mobile-show");
                        overlay.classList.remove("active");
                        hamburgerIcon.classList.remove("open");

                    });
                }

            });
        </script>
        <!-- Sidebar End -->
    </body>
</html>

