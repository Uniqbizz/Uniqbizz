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
    // echo "prev Date ".$prevdate.' ;';
    // echo "prev Month ".$prevDateMonth.' ;';
    // echo "prev year ".$prevDateYear.' ;';

    $tdsPercentage = 2/100;

    // for displaying result for specific loged in user 
    if($userType == '3'){
        $columnDesignation = 'business_mentor';
        $columnMessage = 'message_bm';
        $columnCommision = 'commision_bm';
        $columnStatus = 'status_bm';
    }else if($userType == '16'){
        $columnDesignation = 'techno_enterprise';
        $columnMessage = 'message_te';
        $columnCommision = 'commision_te';
        $columnStatus = 'status_te';
    }
?>

<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable">
    <head>

        <meta charset="utf-8" />
        <title> Dashboard | Business Consultant</title>
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
                                        <h4 class="mb-sm-0">T.A. Recruitment Payout</h4>
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
                                                                            $previousPayout = $conn -> prepare("SELECT SUM($columnCommision) as previousPayout FROM ca_ta_payout WHERE $columnDesignation = '".$userId."'  AND YEAR(created_date) = '".$prevDateYear."' AND MONTH(created_date) = '".$prevDateMonth."' ");
                                                                            $previousPayout -> execute();
                                                                            $previousPayout -> setFetchMode(PDO::FETCH_ASSOC);
                                                                            if($previousPayout -> rowCount()>0){
                                                                                foreach(($previousPayout -> fetchAll()) as $key => $row){
                                                                                    $previousPayout = $row['previousPayout'];
                                                                                    $previousPayoutTDS = $previousPayout * $tdsPercentage;
                                                                                    $TotalpreviousPayout = $previousPayout - $previousPayoutTDS;
                                                                                    echo'<p class="fs-5 fw-bolder mt-n2">Rs. ' .round($TotalpreviousPayout). '/- <span class="badge bg-success font-size-10 fw-bold ms-4">Paid</span> </p>';
                                                                                }
                                                                            }
                                                                        ?>
                                                                        <a type="button" data-bs-toggle="modal" data-bs-target="#previousPayout" style=" cursor: pointer;">
                                                                            <p class="mt-n2 mb-1 fw-bold p1" style="color: #0096FF;">View Payout</p>
                                                                        </a>
                                                                        <a href="payout/forms/recruitment_payout/download_exel_ca.php?payoutYear=<?php echo $prevDateYear; ?>&payoutMonth=<?php echo $prevDateMonth; ?>&payoutmessage=PreviousPayout&user_id=<?php echo $userId; ?>&designation=<?php echo $columnDesignation ?>">
                                                                            <i class="bx bx-download download-icon1" style="font-size: 20px; color: black; margin-left: 20%;"></i>
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-6 col-md-6 col-sm-6 col-6 ">
                                                                    <div class="m-0 mt-2 p-2">
                                                                        <p class="font-size-14">Next Payout<span class="fw-bold font-size-10 date-layout "><?php echo "$date" ?></span></p>
                                                                        <?php 
                                                                            $nextPayout = $conn -> prepare("SELECT SUM($columnCommision) as nextPayout FROM ca_ta_payout WHERE $columnDesignation = '".$userId."'  AND  YEAR(created_date) = '".$nextDateYear."' AND MONTH(created_date) = '".$nextDateMonth."' ");
                                                                            $nextPayout -> execute();
                                                                            $nextPayout -> setFetchMode(PDO::FETCH_ASSOC);
                                                                            if($nextPayout -> rowCount()>0){
                                                                                foreach(($nextPayout -> fetchAll()) as $key => $row2){
                                                                                    $nextPayoutTotal = $row2['nextPayout'];
                                                                                    $nextPayoutTDS = $nextPayoutTotal * $tdsPercentage;
                                                                                    $TotalNextPayout = $nextPayoutTotal - $nextPayoutTDS;
                                                                                    echo'<p class="fs-5 fw-bolder mt-n2">Rs.' .round($TotalNextPayout). '/- <span class="badge bg-warning font-size-10 fw-bold ms-4">Pending</span> </p>';
                                                                                }
                                                                            }
                                                                        ?>
                                                                        <a type="button" data-bs-toggle="modal" data-bs-target="#nextPayout" style=" cursor: pointer;">
                                                                            <p class="mt-n2 mb-1 fw-bold p1" style="color: #0096FF;">View Payout</p>
                                                                        </a>
                                                                        <a href="payout/forms/recruitment_payout/download_exel_ca.php?payoutYear=<?php echo $nextDateYear; ?>&payoutMonth=<?php echo $nextDateMonth; ?>&payoutmessage=NextPayout&user_id=<?php echo $userId; ?>&designation=<?php echo $columnDesignation ?>">
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
                                                                        $totalPayout = "SELECT SUM($columnCommision) as total_payable FROM ca_ta_payout WHERE $columnDesignation = '".$userId."'  AND  $columnStatus = '1'";
                                                                        $Payout = $conn -> prepare($totalPayout);
                                                                        $Payout -> execute();
                                                                        $Payout -> setFetchMode(PDO::FETCH_ASSOC);
                                                                        if($Payout->rowCount()>0){
                                                                            foreach(($Payout->fetchAll()) as $key => $row){
                                                                                $total_payable = $row["total_payable"];
                                                                                $tds = $total_payable * $tdsPercentage;
                                                                                $total_payables = $total_payable - $tds;
                                                                                echo'<p class="fs-5 fw-bolder mt-n2 content1" id="TotalPayoutAmountDate">Rs.'.$total_payables.'/-</p>';
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
                                                    <div class="row">   
                                                        <div class="col-12">
                                                            <div class="d-sm-flex align-items-center justify-content-between">
                                                                <h2 class="mb-sm-0 fw-bolder ps-4">All Payouts</h2>
                                                            </div>   
                                                        </div>
                                                        <!-- monthly user details table  -->
                                                        <div class="row" style="padding-top: 25px;" id="user-box">
                                                            <div class="col-md-12"> 
                                                                <div class="table-responsive table-desi" id="filterTable">
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
                                                                                $sql = "SELECT * FROM `ca_ta_payout` WHERE $columnDesignation = '".$userId."'  AND  status = '1' ORDER BY `ca_ta_payout`.`id` DESC";
                                                                                $stmt = $conn -> prepare($sql);
                                                                                $stmt -> execute();
                                                                                $stmt -> setFetchMode(PDO::FETCH_ASSOC);
                                                                                if( $stmt -> rowCount()>0 ){
                                                                                    foreach( ($stmt -> fetchALL()) as $key => $row ){

                                                                                        // date in proper formate
                                                                                        $dt = new DateTime($row['created_date']);
                                                                                        $dt = $dt->format('Y-m-d');

                                                                                        // replace dot at end of the line with break statement
                                                                                        $message1 = $row[$columnMessage];
                                                                                        $message1 =  str_replace('.','<br>',$message1);  

                                                                                        // total Amt Cal for BC 
                                                                                        $CommAmt = $row[$columnCommision];
                                                                                        $tds = $CommAmt * $tdsPercentage;
                                                                                        $totalAmt = $CommAmt - $tds;

                                                                                        echo '<tr>
                                                                                                <td>'.$dt.'</td>
                                                                                                <td>'.$message1.'</td>
                                                                                                <td class="text-end">'.$CommAmt.'</td>
                                                                                                <td class="text-end">'.$tds.'</td>
                                                                                                <td class="text-end">'.$totalAmt.'
                                                                                                    <a href="payout/forms/recruitment_payout/download_ca_payout.php?vkvbvjfgfikix='.$row['id'].'&designation='.$row[$columnDesignation].'&date='.$dt.'&message='.$message1.'&message_status='.$row[$columnStatus].'&commission='.$row[$columnCommision].'">
                                                                                                        <i class="bx bx-download" style="font-size: 18px; color: black; padding-left: 5px;"></i>
                                                                                                    </a>
                                                                                                </td>';
                                                                                                if($row[$columnStatus] == '1'){
                                                                                                    echo'<td><span class="badge bg-success font-size-10 fw-bold ms-4">Paid</span></td>';
                                                                                                }else{
                                                                                                    echo'<td><span class="badge bg-warning font-size-10 fw-bold ms-4">Pending</span></td>';
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
                                            <!-- end row -->
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
        
        <div style="display: none;">
            <input type="text" name="" id="totalUserId" value="<?php echo $userId ?>">
            <input type="text" name="" id="totalUserDesignation" value="<?php echo $columnDesignation ?>">
            <input type="text" name="" id="totalUserCommision" value="<?php echo $columnCommision ?>">
        </div>

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
                                            $previousPayout = $conn -> prepare("SELECT SUM($columnCommision) as previousPayout FROM ca_ta_payout WHERE $columnDesignation = '".$userId."'  AND YEAR(created_date) = '".$prevDateYear."' AND MONTH(created_date) = '".$prevDateMonth."' ");
                                            $previousPayout -> execute();
                                            $previousPayout -> setFetchMode(PDO::FETCH_ASSOC);
                                            if($previousPayout -> rowCount()>0){
                                                foreach(($previousPayout -> fetchAll()) as $key => $row){
                                                    $previousPayout = $row['previousPayout'];
                                                    $previousPayoutTDS = $previousPayout * $tdsPercentage;
                                                    $TotalpreviousPayout = $previousPayout - $previousPayoutTDS;
                                                    echo'<p class="fs-5 font fw-bolder mt-n2 icon">Rs.' .round($TotalpreviousPayout). '/- </p>
                                                    <span class="badge bg-success font-size-10 fw-bold status1 paystatus" style="height: 15px !important; margin-top: 16px;" readonly>Paid</span>';
                                                }
                                            }
                                        ?>
                                        
                                        <a href="payout/forms/recruitment_payout/download_exel_ca.php?payoutYear=<?php echo $prevDateYear; ?>&payoutMonth=<?php echo $prevDateMonth; ?>&payoutmessage=PreviousPayout&user_id=<?php echo $userId; ?>&designation=<?php echo $columnDesignation ?>">
                                            <i class="bx bx-download download-icon status1 paystatus" style="font-size: 20px; color: black; margin-left: 20%;"></i>
                                        </a>
                                    </div>
                                    
                                    
                                </div>
                            </div>
                            <div class="col-lg-7 col-md-7 col-sm-7">
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
                                    <div class="table-responsive table-desi" id="filterTablePrev">
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
                                                    $sql = "SELECT * FROM `ca_ta_payout` WHERE $columnDesignation = '".$userId."'  AND YEAR(created_date) = '".$prevDateYear."' AND MONTH(created_date) = '".$prevDateMonth."'";
                                                    $stmt = $conn -> prepare($sql);
                                                    $stmt -> execute();
                                                    $stmt -> setFetchMode(PDO::FETCH_ASSOC);
                                                    if( $stmt -> rowCount()>0 ){
                                                        foreach( ($stmt -> fetchALL()) as $key => $row ){

                                                            // date in proper formate
                                                            $dt = new DateTime($row['created_date']);
                                                            $dt = $dt->format('Y-m-d');

                                                            // replace dot at end of the line with break statement
                                                            $message1 = $row[$columnMessage];
                                                            $message1 =  str_replace('.','<br>',$message1);  

                                                            // total Amt Cal for BC 
                                                            $CommAmt = $row[$columnCommision];
                                                            $tds = $CommAmt * $tdsPercentage;
                                                            $totalAmt = $CommAmt - $tds;

                                                            echo '<tr>
                                                                    <td>'.$dt.'</td>
                                                                    <td>'.$message1.'</td>
                                                                    <td class="text-end">'.$CommAmt.'</td>
                                                                    <td class="text-end">'.$tds.'</td>
                                                                    <td class="text-end">'.$totalAmt.'
                                                                        <a href="payout/forms/recruitment_payout/download_ca_payout.php?vkvbvjfgfikix='.$row['id'].'&designation='.$row[$columnDesignation].'&date='.$dt.'&message='.$message1.'&message_status='.$row[$columnStatus].'&commission='.$row[$columnCommision].'">
                                                                            <i class="bx bx-download" style="font-size: 18px; color: black; padding-left: 5px;"></i>
                                                                        </a>
                                                                    </td>';
                                                                    if($row[$columnStatus] == '1'){
                                                                        echo'<td><span class="badge bg-success font-size-10 fw-bold ms-4">Paid</span></td>';
                                                                    }else{
                                                                        echo'<td><span class="badge bg-warning font-size-10 fw-bold ms-4">Pending</span></td>';
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
                                            $nextPayout = $conn -> prepare("SELECT SUM($columnCommision) as nextPayout FROM ca_ta_payout WHERE $columnDesignation = '".$userId."'  AND  YEAR(created_date) = '".$nextDateYear."' AND MONTH(created_date) = '".$nextDateMonth."' ");
                                            $nextPayout -> execute();
                                            $nextPayout -> setFetchMode(PDO::FETCH_ASSOC);
                                            if($nextPayout -> rowCount()>0){
                                                foreach(($nextPayout -> fetchAll()) as $key => $row2){
                                                    $nextPayoutTotal = $row2['nextPayout'];
                                                    $nextPayoutTDS = $nextPayoutTotal * $tdsPercentage;
                                                    $TotalNextPayout = $nextPayoutTotal - $nextPayoutTDS;
                                                    echo'<p class="fs-5 font fw-bolder mt-n2 icon">Rs.' .round($TotalNextPayout). '/- </p>
                                                    <span class="badge bg-success font-size-10 fw-bold status1 paystatus" style="height: 15px !important; margin-top: 16px;" readonly>Paid</span>';
                                                }
                                            }
                                        ?>
                                        
                                        <a href="payout/forms/recruitment_payout/download_exel_ca.php?payoutYear=<?php echo $nextDateYear; ?>&payoutMonth=<?php echo $nextDateMonth; ?>&payoutmessage=NextPayout&user_id=<?php echo $userId; ?>&designation=<?php echo $columnDesignation ?>">
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
                                        </div>
                                    </span>
                            
                                </div>    
                            </div>
                            <!-- monthly user details table  -->
                            <div class="row" style="padding-top: 25px;" id="user-box">
                                <div class="col-md-12"> 
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
                                                    $sql = "SELECT * FROM `ca_ta_payout` WHERE $columnDesignation = '".$userId."' AND YEAR(created_date) = '".$nextDateYear."' AND MONTH(created_date) = '".$nextDateMonth."'";
                                                    $stmt = $conn -> prepare($sql);
                                                    $stmt -> execute();
                                                    $stmt -> setFetchMode(PDO::FETCH_ASSOC);
                                                    if( $stmt -> rowCount()>0 ){
                                                        foreach( ($stmt -> fetchALL()) as $key => $row ){

                                                            // date in proper formate
                                                            $dt = new DateTime($row['created_date']);
                                                            $dt = $dt->format('Y-m-d');

                                                            // replace dot at end of the line with break statement
                                                            $message1 = $row[$columnMessage];
                                                            $message1 =  str_replace('.','<br>',$message1);  

                                                            // total Amt Cal for BC 
                                                            $CommAmt = $row[$columnCommision];
                                                            $tds = $CommAmt * $tdsPercentage;
                                                            $totalAmt = $CommAmt - $tds;

                                                            echo '<tr>
                                                                    <td>'.$dt.'</td>
                                                                    <td>'.$message1.'</td>
                                                                    <td class="text-end">'.$CommAmt.'</td>
                                                                    <td class="text-end">'.$tds.'</td>
                                                                    <td class="text-end">'.$totalAmt.'
                                                                        <a href="payout/forms/recruitment_payout/download_ca_payout.php?vkvbvjfgfikix='.$row['id'].'&designation='.$row[$columnDesignation].'&date='.$dt.'&message='.$message1.'&message_status='.$row[$columnStatus].'&commission='.$row[$columnCommision].'">
                                                                            <i class="bx bx-download" style="font-size: 18px; color: black; padding-left: 5px;"></i>
                                                                        </a>
                                                                    </td>';
                                                                    if($row[$columnStatus] == '1'){
                                                                        echo'<td><span class="badge bg-success font-size-10 fw-bold ms-4">Paid</span></td>';
                                                                    }else{
                                                                        echo'<td><span class="badge bg-warning font-size-10 fw-bold ms-4">Pending</span></td>';
                                                                    }
                                                            echo'</tr>';

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
                                            $totalPayout = "SELECT SUM($columnCommision) as total_payable FROM ca_ta_payout WHERE $columnDesignation = '".$userId."'  AND  $columnStatus = '1'";
                                            $Payout = $conn -> prepare($totalPayout);
                                            $Payout -> execute();
                                            $Payout -> setFetchMode(PDO::FETCH_ASSOC);
                                            if($Payout->rowCount()>0){
                                                foreach(($Payout->fetchAll()) as $key => $row){
                                                    $total_payable = $row["total_payable"] ?? '0';
                                                    echo'
                                                    <p class="fs-5 font fw-bolder mt-n2 icon">Rs.'.$total_payable.'/- </p>
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
                                                    $sql = "SELECT * FROM `ca_ta_payout` WHERE $columnDesignation = '".$userId."' AND $columnStatus = '1' ";
                                                    $stmt = $conn -> prepare($sql);
                                                    $stmt -> execute();
                                                    $stmt -> setFetchMode(PDO::FETCH_ASSOC);
                                                    if( $stmt -> rowCount()>0 ){
                                                        foreach( ($stmt -> fetchALL()) as $key => $row ){

                                                            // date in proper formate
                                                            $dt = new DateTime($row['created_date']);
                                                            $dt = $dt->format('Y-m-d');

                                                            // replace dot at end of the line with break statement
                                                            $message1 = $row[$columnMessage];
                                                            $message1 =  str_replace('.','<br>',$message1);  

                                                            // total Amt Cal for BC 
                                                            $CommAmt = $row[$columnCommision];
                                                            $tds = $CommAmt * $tdsPercentage;
                                                            $totalAmt = $CommAmt - $tds;

                                                            echo '<tr>
                                                                    <td>'.$dt.'</td>
                                                                    <td>'.$message1.'</td>
                                                                    <td class="text-end">'.$CommAmt.'</td>
                                                                    <td class="text-end">'.$tds.'</td>
                                                                    <td class="text-end">'.$totalAmt.'
                                                                        <a href="payout/forms/recruitment_payout/download_ca_payout.php?vkvbvjfgfikix='.$row['id'].'&designation='.$row[$columnDesignation].'&date='.$dt.'&message='.$message1.'&message_status='.$row[$columnStatus].'&commission='.$row[$columnCommision].'">
                                                                            <i class="bx bx-download" style="font-size: 18px; color: black; padding-left: 5px;"></i>
                                                                        </a>
                                                                    </td>';
                                                                    if($row[$columnStatus] == '1'){
                                                                        echo'<td><span class="badge bg-success font-size-10 fw-bold ms-4">Paid</span></td>';
                                                                    }else{
                                                                        echo'<td><span class="badge bg-warning font-size-10 fw-bold ms-4">Pending</span></td>';
                                                                    }
                                                            echo'</tr>';

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
        <script src="payout/payout.js"></script>
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
            $(document).ready(function(){
                $("#payoutDetailsTable").DataTable();
                $("#previous_payout_table").DataTable();
                $("#next_payout_table").DataTable();
                $("#total_payout_table").DataTable();
            });

        </script>
    </body>
</html>