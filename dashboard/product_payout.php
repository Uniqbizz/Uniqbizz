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
    $tdsPercentage=2/100;

    function truncateToTwoDecimals($num) {
    return floor($num * 100) / 100;
}
?>

<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable">
    <head>

        <meta charset="utf-8" />
        <title> Dashboard </title>
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
                                        <p class="mb-sm-0 head fw-bold text-uppercase">Product Payout</p>
                                        <div class="page-title-right sub-title">
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
                                                                        <p>Previous Payout<span class="fw-bold ms-4"><?php echo "$prevdate" ?></span></p>
                                                                        <?php 

                                                                            if($userType == '11'){ //travel_consultant
                                                                                $userIdCommi = 'ta_id';
                                                                                $amtCal = 'ta_markup + ta_amt';
                                                                            }elseif($userType == '16'){ //Techno Enterprise/ corporate agency
                                                                                $userIdCommi = 'te_id';
                                                                                $amtCal = 'te_amt';
                                                                            }elseif($userType == '10'){ //customer
                                                                                $userIdCommi = 'cu1_id';
                                                                                $amtCal = 'cu1_amt';
                                                                            }elseif($userType == '26'){//business Mentor
                                                                                $userIdCommi = 'bm_id';
                                                                                $amtCal = 'bm_amt';
                                                                            }elseif($userType == '25'){// business Development manager
                                                                                $userIdCommi = 'bdm_id';
                                                                                $amtCal = 'bdm_amt';
                                                                            }elseif($userType == '24'){ // business channel manager
                                                                                $userIdCommi = 'bch_id';
                                                                                $amtCal = 'bch_amt';
                                                                            }

                                                                            $previousPayout = $conn -> prepare("SELECT SUM(($amtCal)) as previousPayout FROM product_payout WHERE $userIdCommi = '".$userId."' AND YEAR(created_date) = '".$prevDateYear."' AND MONTH(created_date) = '".$prevDateMonth."' ");
                                                                            $previousPayout -> execute();
                                                                            $previousPayout -> setFetchMode(PDO::FETCH_ASSOC);
                                                                            if($previousPayout -> rowCount()>0){
                                                                                foreach(($previousPayout -> fetchAll()) as $key => $row){
                                                                                    $previousPayout = $row['previousPayout'];
                                                                                    $previousPayoutTDS = $previousPayout * $tdsPercentage;
                                                                                    $TotalpreviousPayout = $previousPayout - $previousPayoutTDS;
                                                                                    $truncatedPrevAmount = floor($TotalpreviousPayout * 100) / 100;
                                                                                    echo'<p class="fs-5 fw-bolder mt-n2">Rs. ' .number_format($truncatedPrevAmount,2). '/- <span class="badge bg-success fw-bold ms-4">Paid</span> </p>';
                                                                                }
                                                                            }
                                                                        ?>
                                                                        <a type="button" data-bs-toggle="modal" data-bs-target="#previousPayout" style=" cursor: pointer;">
                                                                            <p class="mt-n2 mb-1 fw-bold p1" style="color: #0096FF;">View Payout</p>
                                                                        </a>
                                                                        <a href="payout/forms/product_payout/download_exel_ca.php?payoutYear=<?php echo $prevDateYear; ?>&payoutMonth=<?php echo $prevDateMonth; ?>&payoutmessage=PreviousPayout&user_id=<?php echo $userId; ?>&userType=<?php echo $userType ?>">
                                                                            <i class="bx bx-download download-icon1" style="font-size: 20px; color: black; margin-left: 20%;"></i>
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-6 col-md-6 col-sm-6 col-6 ">
                                                                    <div class="m-0 mt-2 p-2">
                                                                        <p>Next Payout<span class="fw-bold date-layout "><?php echo "$date" ?></span></p>
                                                                        <?php 
                                                                            if($userType == '11'){ //travel_consultant
                                                                                $userIdCommi = 'ta_id';
                                                                                $amtCal = 'ta_markup + ta_amt';
                                                                            }elseif($userType == '16'){ //Techno Enterprise/ corporate agency
                                                                                $userIdCommi = 'te_id';
                                                                                $amtCal = 'te_amt';
                                                                            }elseif($userType == '10'){ //customer
                                                                                $userIdCommi = 'cu1_id';
                                                                                $amtCal = 'cu1_amt';
                                                                            }elseif($userType == '26'){//business Mentor
                                                                                $userIdCommi = 'bm_id';
                                                                                $amtCal = 'bm_amt';
                                                                            }elseif($userType == '25'){// business Development manager
                                                                                $userIdCommi = 'bdm_id';
                                                                                $amtCal = 'bdm_amt';
                                                                            }elseif($userType == '24'){ // business channel manager
                                                                                $userIdCommi = 'bch_id';
                                                                                $amtCal = 'bch_amt';
                                                                            }
                                                                            $nextPayout = $conn -> prepare("SELECT SUM(($amtCal)) as nextPayout FROM product_payout WHERE $userIdCommi = '".$userId."' AND YEAR(created_date) = '".$nextDateYear."' AND MONTH(created_date) = '".$nextDateMonth."' ");
                                                                            $nextPayout -> execute();
                                                                            $nextPayout -> setFetchMode(PDO::FETCH_ASSOC);
                                                                            if($nextPayout -> rowCount()>0){
                                                                                foreach(($nextPayout -> fetchAll()) as $key => $row2){
                                                                                    $nextPayoutTotal = $row2['nextPayout'];
                                                                                    $nextPayoutTDS = $nextPayoutTotal * $tdsPercentage;
                                                                                    $TotalNextPayout = $nextPayoutTotal - $nextPayoutTDS;
                                                                                    $truncatedNextAmount = floor($TotalNextPayout * 100) / 100;
                                                                                    echo'<p class="fs-5 fw-bolder mt-n2">Rs.' .number_format($truncatedNextAmount,2). '/- <span class="badge bg-warning fw-bold ms-4">Pending</span> </p>';
                                                                                }
                                                                            }
                                                                        ?>
                                                                        <a type="button" data-bs-toggle="modal" data-bs-target="#nextPayout" style=" cursor: pointer;">
                                                                            <p class="mt-n2 mb-1 fw-bold p1" style="color: #0096FF;">View Payout</p>
                                                                        </a>
                                                                        <a href="payout/forms/product_payout/download_exel_ca.php?payoutYear=<?php echo $nextDateYear; ?>&payoutMonth=<?php echo $nextDateMonth; ?>&payoutmessage=NextPayout&user_id=<?php echo $userId; ?>&userType=<?php echo $userType ?>">
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
                                                                        <p>Total Payout
                                                                            <div id="cap_text_1" class="filter-opt-4">
                                                                                <span  class="rounded-4 d-block border-round">
                                                                                    <p class="fw-bold">Select month, year <span class="bx bx-calendar-alt callogo"></span></p> 
                                                                                </span>
                                                                            </div>
                                                                            <input type="month" id="month_year" value="" min="2020-01" max="" class="fw-bold rounded-4 d-none border-round">
                                                                        </p>
                                                                    </div>
                                                                    <?php 
                                                                        if($userType == '11'){ //travel_consultant
                                                                            $userIdCommi = 'ta_id';
                                                                            $amtCal = 'ta_markup + ta_amt';
                                                                        }elseif($userType == '16'){ //Techno Enterprise/ corporate agency
                                                                            $userIdCommi = 'te_id';
                                                                            $amtCal = 'te_amt';
                                                                        }elseif($userType == '10'){ //customer
                                                                            $userIdCommi = 'cu1_id';
                                                                            $amtCal = 'cu1_amt';
                                                                        }elseif($userType == '26'){//business Mentor
                                                                            $userIdCommi = 'bm_id';
                                                                            $amtCal = 'bm_amt';
                                                                        }elseif($userType == '25'){// business Development manager
                                                                            $userIdCommi = 'bdm_id';
                                                                            $amtCal = 'bdm_amt';
                                                                        }elseif($userType == '24'){ // business channel manager
                                                                            $userIdCommi = 'bch_id';
                                                                            $amtCal = 'bch_amt';
                                                                        }

                                                                        $totalPayout = "SELECT SUM($amtCal) as total_payable FROM product_payout WHERE $userIdCommi = '".$userId."' ";
                                                                        $Payout = $conn -> prepare($totalPayout);
                                                                        $Payout -> execute();
                                                                        $Payout -> setFetchMode(PDO::FETCH_ASSOC);
                                                                        if($Payout->rowCount()>0){
                                                                            foreach(($Payout->fetchAll()) as $key => $row){
                                                                                $total_payable = $row["total_payable"] ?? '0';
                                                                                $totalPayoutTDS = $total_payable * $tdsPercentage;
                                                                                $TotalPayoutFinal = $total_payable - $totalPayoutTDS;
                                                                                $truncatedTotalAmount = floor($TotalPayoutFinal * 100) / 100;
                                                                                echo'<p class="fs-5 fw-bolder mt-n2 content1" id="TotalPayoutAmountDate">Rs.'.number_format($truncatedTotalAmount,2).'/-</p>';
                                                                            }
                                                                        }
                                                                    ?>
                                                                    <a type="button" data-bs-toggle="modal" data-bs-target="#totalPayout" style=" cursor: pointer;">
                                                                        <p class="mt-n2 mb-1 fw-bold p1" style="color: #0096FF;"> View Payout</p>
                                                                    </a>
                                                                    <p id="userIdTotalPay" style="display: none"><?php echo $userType ?></p>
                                                                    <i onclick="totalPayoutExel();" class="bx bx-download download-icon1" style="font-size: 20px; color: black; margin-left: 20%; cursor: pointer;"></i>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <hr style="border: 2px solid grey;">
                                                    <div class="row">   
                                                        <div class="col-12">
                                                            <div class="d-sm-flex align-items-center justify-content-between">
                                                                <p class="mb-sm-0 head fw-bold ps-4">All Payouts</p>
                                                            </div>   
                                                        </div>
                                                        <!-- monthly user details table  -->
                                                        <div class="row" style="padding-top: 25px;" id="user-box">
                                                            <div class="col-md-12">
                                                                <!-- <input type="hidden" name="user_table_count" id="user_table_count" value="" /> -->
                                                                <div class="table-responsive table-desi" id="filterTable">
                                                                    <!-- table roe limit -->
                                                                
                                                                    <table class="table table-hover" id="payoutDetailsTable">
                                                                        <thead>
                                                                            <tr>
                                                                                <th class="ceterText fw-bolder sub-title">Date</th>
                                                                                <th class="ceterText fw-bolder sub-title">Payout Details</th>
                                                                                <?php if($userType == '11'){ ?>
                                                                                    <th class="ceterText fw-bolder sub-title">Markup</th>
                                                                                <?php } ?>
                                                                                <!-- <th class="ceterText fw-bolder sub-title">Product Payout </th> -->
                                                                                <th class="ceterText fw-bolder sub-title">Total </th>
                                                                                <th class="ceterText fw-bolder sub-title">TDS</th>
                                                                                <th class="ceterText fw-bolder sub-title">Total Payable</th>
                                                                                <th class="ceterText fw-bolder sub-title">Remark</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <?php

                                                                                if($userType == '10'){
                                                                                    $sql = "SELECT * FROM `product_payout` WHERE  (cu1_id = '".$userId."') OR (cu2_id = '".$userId."') OR (cu3_id = '".$userId."')   ";
                                                                                }else if($userType == '11'){
                                                                                    $sql = "SELECT * FROM `product_payout` WHERE  ta_id = '".$userId."' ";
                                                                                }else if($userType == '16'){
                                                                                    $sql = "SELECT * FROM `product_payout` WHERE  te_id = '".$userId."'   ";
                                                                                }else if($userType == '26'){
                                                                                    $sql = "SELECT * FROM `product_payout` WHERE  bm_id = '".$userId."'   ";
                                                                                }else if($userType == '25'){
                                                                                    $sql = "SELECT * FROM `product_payout` WHERE  bdm_id = '".$userId."'   ";
                                                                                }else if($userType == '24'){
                                                                                    $sql = "SELECT * FROM `product_payout` WHERE  bch_id = '".$userId."'   ";
                                                                                }
                                                                                
                                                                                $stmt = $conn -> prepare($sql);
                                                                                $stmt -> execute();
                                                                                $stmt -> setFetchMode(PDO::FETCH_ASSOC);
                                                                                if( $stmt -> rowCount()>0 ){
                                                                                    foreach( ($stmt -> fetchALL()) as $key => $row ){
                                                                                        // print_r($stmt);
                                                                                        // print_r($row);
                                                                                        // echo '</br>';
                                                                                        // date in proper formate
                                                                                        $dt = new DateTime($row['created_date']);
                                                                                        $dt = $dt->format('Y-m-d');
                                                                                        
                                                                                        //get package Name
                                                                                        $stmt1 = $conn -> prepare(" SELECT name FROM package WHERE id = '".$row['package_id']."' ");
                                                                                        $stmt1 -> execute();
                                                                                        $pkgName = $stmt1 -> fetch();
                                                                                        $packageName = $pkgName['name'];

                                                                                        //get customer Name
                                                                                        $stmt8 = $conn -> prepare(" SELECT firstname, lastname FROM ca_customer WHERE ca_customer_id = '".$row['cu_id']."' ");
                                                                                        $stmt8 -> execute();
                                                                                        $cu_name = $stmt8 -> fetch();
                                                                                        $cuName = $cu_name['firstname'].' '.$cu_name['lastname']; 
                                                                                        
                                                                                        $no_of_adult = $row['no_of_adult'] ;
                                                                                        $no_of_child = $row['no_of_child'] ;

                                                                                        //customer part remaining
                                                                                        if($userType == '10'){
                                                                                            $cu1 = $row['cu1_id'];
                                                                                            $cu2 = $row['cu2_id'];
                                                                                            $cu3 = $row['cu3_id'];
                                                                                            if($cu1 == $userId){
                                                                                                $message = $row['cu1_mess']; 
                                                                                                $amt = $row['cu1_amt'];
                                                                                                $status = $row['cu1_status'];
                                                                                            }else if($cu2 == $userId){
                                                                                                $message = $row['cu2_mess'];
                                                                                                $amt = $row['cu2_amt'];
                                                                                                $status = $row['cu2_status'];
                                                                                            }else{
                                                                                                $message = $row['cu3_mess'];
                                                                                                $amt = $row['cu3_amt'];
                                                                                                $status = $row['cu3_status'];
                                                                                            }
                                                                                            $tds = $amt * $tdsPercentage;
                                                                                            $total = $amt - $tds;
                                                                                        }else if($userType == '11'){
                                                                                            $id = $row['ta_id'];
                                                                                            $ta_markup = $row['ta_markup'];
                                                                                            $message = $row['ta_mess'];
                                                                                            $amt = $row['ta_amt'];
                                                                                            $status = $row['ta_status'];
                                                                                            $tds = $amt * $tdsPercentage;
                                                                                            $total = $amt - $tds;
                                                                                        }else if($userType == '16'){
                                                                                            $id = $row['te_id'];
                                                                                            $message = $row['te_mess'];
                                                                                            $amt = $row['te_amt'];
                                                                                            $status = $row['te_status'];
                                                                                            $tds = $amt * $tdsPercentage;
                                                                                            $total = $amt - $tds;
                                                                                        }else if($userType == '24'){
                                                                                            $id = $row['bch_id'];
                                                                                            $message = $row['bch_mess'];
                                                                                            $amt = $row['bch_amt'];
                                                                                            $status = $row['bch_status'];
                                                                                            $tds = $amt * $tdsPercentage;
                                                                                            $total = $amt - $tds;
                                                                                        }else if($userType == '25'){
                                                                                            $id = $row['bdm_id'];
                                                                                            $message = $row['bdm_mess'];
                                                                                            $amt = $row['bdm_amt'];
                                                                                            $status = $row['bdm_status'];
                                                                                            $tds = $amt * $tdsPercentage;
                                                                                            $total = $amt - $tds;
                                                                                        }else if($userType == '26'){
                                                                                            $id = $row['bm_id'];
                                                                                            $message = $row['bm_mess'];
                                                                                            $amt = $row['bm_amt'];
                                                                                            $status = $row['bm_status'];
                                                                                            $tds = $amt * $tdsPercentage;
                                                                                            $total = $amt - $tds;
                                                                                        }

                                                                                        echo '<tr>
                                                                                                <td>'.$dt.'</td>';
                                                                                                if($userType == '11'){
                                                                                                    echo'<td>'.$message.' <br/> on selling '.$packageName.' Package to '.$cuName.'<br/> No of Adult -> '.$no_of_adult.'. No of child ->'. $no_of_child.'<br> Markup Price -> Rs '.$ta_markup.'</td>
                                                                                                    <td >'.$ta_markup.'</td>';
                                                                                                }else{
                                                                                                    echo '<td>'.$message.' <br/> on selling '.$packageName.' Package to '.$cuName.'<br/> No of Adult -> '.$no_of_adult.'. No of child ->'. $no_of_child.'</td>';
                                                                                                }
                                                                                                echo'
                                                                                                <td >'.$amt.'</td>
                                                                                                <td >'.$tds.'</td>
                                                                                                <td >'.$total.'</td>';
                                                                                                if($status == '1'){
                                                                                                    echo'<td><span class="badge bg-success fw-bold ms-4">Paid</span></td>';
                                                                                                }else{
                                                                                                    echo'<td><span class="badge bg-warning fw-bold ms-4">Pending</span></td>';
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
                                    <p class="pt-2">Previous Payout<span class="fw-bold date-layout1 layout-1"><?php echo "$prevdate" ?></span></p>
                                    <div class="d-flex">
                                        <?php 

                                            if($userType == '11'){ //travel_consultant
                                                $userIdCommi = 'ta_id';
                                                $amtCal = 'ta_markup + ta_amt';
                                            }elseif($userType == '16'){ //Techno Enterprise/ corporate agency
                                                $userIdCommi = 'te_id';
                                                $amtCal = 'te_amt';
                                            }elseif($userType == '10'){ //customer
                                                $userIdCommi = 'cu1_id';
                                                $amtCal = 'cu1_amt';
                                            }elseif($userType == '26'){//business Mentor
                                                $userIdCommi = 'bm_id';
                                                $amtCal = 'bm_amt';
                                            }elseif($userType == '25'){// business Development manager
                                                $userIdCommi = 'bdm_id';
                                                $amtCal = 'bdm_amt';
                                            }elseif($userType == '24'){ // business channel manager
                                                $userIdCommi = 'bch_id';
                                                $amtCal = 'bch_amt';
                                            }

                                            $previousPayout = $conn -> prepare("SELECT SUM(($amtCal)) as previousPayout FROM product_payout WHERE $userIdCommi = '".$userId."' AND YEAR(created_date) = '".$prevDateYear."' AND MONTH(created_date) = '".$prevDateMonth."' ");
                                            $previousPayout -> execute();
                                            $previousPayout -> setFetchMode(PDO::FETCH_ASSOC);
                                            if($previousPayout -> rowCount()>0){
                                                foreach(($previousPayout -> fetchAll()) as $key => $row){
                                                    $previousPayout = $row['previousPayout'];
                                                    $previousPayoutTDS = $previousPayout * $tdsPercentage;
                                                    $TotalpreviousPayout = $previousPayout - $previousPayoutTDS;
                                                    $truncatedPrevAmount = floor($TotalpreviousPayout * 100) / 100;
                                                    echo'<p class="fs-5 font fw-bolder mt-n2 icon">Rs.' .number_format($truncatedPrevAmount,2). '/- </p>
                                                    <span class="badge bg-success fw-bold status1 paystatus" style="height: 15px !important; margin-top: 16px;" readonly>Paid</span>';
                                                }
                                            }
                                        ?>
                                        
                                        <!-- <a href="payout/forms/product_payout/download_exel_ca.php?payoutYear=<?php echo $prevDateYear; ?>&payoutMonth=<?php echo $prevDateMonth; ?>&payoutmessage=PreviousPayout">
                                            <i class="bx bx-download download-icon status1 paystatus" style="font-size: 20px; color: black; margin-left: 20%;"></i>
                                        </a> -->
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
                                            <p>Name: <span><?php echo $firstname.' '.$lastname; ?></span><span class="fw-bold ms-4 date-layout layout-2 date-align"><?php echo "$prevdate" ?></span></p>
                                            <p class="fs-5 fw-bolder mt-n2 icon">Rs. <?php echo number_format($truncatedPrevAmount,2); ?>/- </p>
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
                                    <!-- <input type="hidden" name="user_table_count" id="user_table_count" value="" /> -->
                                    <div class="table-responsive table-desi" id="filterTablePrev">
                                        <!-- table roe limit -->
                                    
                                        <table class="table table-hover" id="previous_payout_table">
                                            <thead>
                                                <tr>
                                                    <th class="ceterText fw-bolder sub-title">Date</th>
                                                    <th class="ceterText fw-bolder sub-title">Payout Details</th>
                                                    <?php if($userType == '11'){ ?>
                                                        <th class="ceterText fw-bolder sub-title">Markup</th>
                                                    <?php } ?>
                                                    <th class="ceterText fw-bolder sub-title">Amount</th>
                                                    <th class="ceterText fw-bolder sub-title">TDS</th>
                                                    <th class="ceterText fw-bolder sub-title">Total Payable</th>
                                                    <th class="ceterText fw-bolder sub-title">Remark</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php

                                                    if($userType == '10'){
                                                        $sql = "SELECT * FROM `product_payout` WHERE  (cu1_id = '".$userId."') OR (cu2_id = '".$userId."') OR (cu3_id = '".$userId."') AND YEAR(created_date) = '".$prevDateYear."' AND MONTH(created_date) = '".$prevDateMonth."'  ";
                                                    }else if($userType == '11'){
                                                        $sql = "SELECT * FROM `product_payout` WHERE  ta_id = '".$userId."' AND YEAR(created_date) = '".$prevDateYear."' AND MONTH(created_date) = '".$prevDateMonth."' ";
                                                    }else if($userType == '16'){
                                                        $sql = "SELECT * FROM `product_payout` WHERE  te_id = '".$userId."' AND YEAR(created_date) = '".$prevDateYear."' AND MONTH(created_date) = '".$prevDateMonth."'  ";
                                                    }else if($userType == '26'){
                                                        $sql = "SELECT * FROM `product_payout` WHERE  bm_id = '".$userId."'  AND YEAR(created_date) = '".$prevDateYear."' AND MONTH(created_date) = '".$prevDateMonth."' ";
                                                    }else if($userType == '25'){
                                                        $sql = "SELECT * FROM `product_payout` WHERE  bdm_id = '".$userId."' AND YEAR(created_date) = '".$prevDateYear."' AND MONTH(created_date) = '".$prevDateMonth."'  ";
                                                    }else if($userType == '24'){
                                                        $sql = "SELECT * FROM `product_payout` WHERE  bch_id = '".$userId."'  AND YEAR(created_date) = '".$prevDateYear."' AND MONTH(created_date) = '".$prevDateMonth."' ";
                                                    }
                                                    
                                                    $stmt = $conn -> prepare($sql);
                                                    $stmt -> execute();
                                                    $stmt -> setFetchMode(PDO::FETCH_ASSOC);
                                                    // print_r($stmt);
                                                    if( $stmt -> rowCount()>0 ){
                                                        foreach( ($stmt -> fetchALL()) as $key => $row ){
                                                            // print_r($stmt);
                                                            // print_r($row);
                                                            // echo '</br>';
                                                            // date in proper formate
                                                            $dt = new DateTime($row['created_date']);
                                                            $dt = $dt->format('Y-m-d');
                                                            
                                                            //get package Name
                                                            $stmt1 = $conn -> prepare(" SELECT name FROM package WHERE id = '".$row['package_id']."' ");
                                                            $stmt1 -> execute();
                                                            $pkgName = $stmt1 -> fetch();
                                                            $packageName = $pkgName['name'];

                                                            //get customer Name
                                                            $stmt8 = $conn -> prepare(" SELECT firstname, lastname FROM ca_customer WHERE ca_customer_id = '".$row['cu_id']."' ");
                                                            $stmt8 -> execute();
                                                            $cu_name = $stmt8 -> fetch();
                                                            $cuName = $cu_name['firstname'].' '.$cu_name['lastname']; 
                                                            
                                                            $no_of_adult = $row['no_of_adult'] ;
                                                            $no_of_child = $row['no_of_child'] ;

                                                            //customer part remaining
                                                            if($userType == '10'){
                                                                $cu1 = $row['cu1_id'];
                                                                $cu2 = $row['cu2_id'];
                                                                $cu3 = $row['cu3_id'];
                                                                if($cu1 == $userId){
                                                                    $message = $row['cu1_mess']; 
                                                                    $amt = $row['cu1_amt'];
                                                                    $status = $row['cu1_status'];
                                                                }else if($cu2 == $userId){
                                                                    $message = $row['cu2_mess'];
                                                                    $amt = $row['cu2_amt'];
                                                                    $status = $row['cu2_status'];
                                                                }else{
                                                                    $message = $row['cu3_mess'];
                                                                    $amt = $row['cu3_amt'];
                                                                    $status = $row['cu3_status'];
                                                                }
                                                                $tds = $amt * $tdsPercentage;
                                                                $total = $amt - $tds;
                                                            }else if($userType == '11'){
                                                                $id = $row['ta_id'];
                                                                $ta_markup = $row['ta_markup'];
                                                                $message = $row['ta_mess'];
                                                                $amt = $row['ta_amt'];
                                                                $status = $row['ta_status'];
                                                                $tds = $amt * $tdsPercentage;
                                                                $total = $amt - $tds;
                                                            }else if($userType == '16'){
                                                                $id = $row['te_id'];
                                                                $message = $row['te_mess'];
                                                                $amt = $row['te_amt'];
                                                                $status = $row['te_status'];
                                                                $tds = $amt * $tdsPercentage;
                                                                $total = $amt - $tds;
                                                            }else if($userType == '24'){
                                                                $id = $row['bch_id'];
                                                                $message = $row['bch_mess'];
                                                                $amt = $row['bch_amt'];
                                                                $status = $row['bch_status'];
                                                                $tds = $amt * $tdsPercentage;
                                                                $total = $amt - $tds;
                                                            }else if($userType == '25'){
                                                                $id = $row['bdm_id'];
                                                                $message = $row['bdm_mess'];
                                                                $amt = $row['bdm_amt'];
                                                                $status = $row['bdm_status'];
                                                                $tds = $amt * $tdsPercentage;
                                                                $total = $amt - $tds;
                                                            }else if($userType == '26'){
                                                                $id = $row['bm_id'];
                                                                $message = $row['bm_mess'];
                                                                $amt = $row['bm_amt'];
                                                                $status = $row['bm_status'];
                                                                $tds = $amt * $tdsPercentage;
                                                                $total = $amt - $tds;
                                                            }

                                                            echo '<tr>
                                                                    <td>'.$dt.'</td>';
                                                                    if($userType == '11'){
                                                                        echo'<td>'.$message.' <br/> on selling '.$packageName.' Package to '.$cuName.'<br/> No of Adult -> '.$no_of_adult.'. No of child ->'. $no_of_child.'<br> Markup Price -> Rs '.$ta_markup.'</td>
                                                                        <td >'.$ta_markup.'</td>';
                                                                    }else{
                                                                        echo '<td>'.$message.' <br/> on selling '.$packageName.' Package to '.$cuName.'<br/> No of Adult -> '.$no_of_adult.'. No of child ->'. $no_of_child.'</td>';
                                                                    }
                                                                    echo'
                                                                    <td >'.$amt.'</td>
                                                                    <td >'.$tds.'</td>
                                                                    <td >'.$total.'</td>';
                                                                    if($status == '1'){
                                                                        echo'<td><span class="badge bg-success fw-bold ms-4">Paid</span></td>';
                                                                    }else{
                                                                        echo'<td><span class="badge bg-warning fw-bold ms-4">Pending</span></td>';
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
                                    <p class="pt-3">Next Payout<span class="fw-bold date-layout layout-1"><?php echo "$date" ?></span></p>
                                    <div class="d-flex">
                                        <?php 
                                            if($userType == '11'){ //travel_consultant
                                                $userIdCommi = 'ta_id';
                                                $amtCal = 'ta_markup + ta_amt';
                                            }elseif($userType == '16'){ //Techno Enterprise/ corporate agency
                                                $userIdCommi = 'te_id';
                                                $amtCal = 'te_amt';
                                            }elseif($userType == '10'){ //customer
                                                $userIdCommi = 'cu1_id';
                                                $amtCal = 'cu1_amt';
                                            }elseif($userType == '26'){//business Mentor
                                                $userIdCommi = 'bm_id';
                                                $amtCal = 'bm_amt';
                                            }elseif($userType == '25'){// business Development manager
                                                $userIdCommi = 'bdm_id';
                                                $amtCal = 'bdm_amt';
                                            }elseif($userType == '24'){ // business channel manager
                                                $userIdCommi = 'bch_id';
                                                $amtCal = 'bch_amt';
                                            }
                                            $nextPayout = $conn -> prepare("SELECT SUM(($amtCal)) as nextPayout FROM product_payout WHERE $userIdCommi = '".$userId."' AND YEAR(created_date) = '".$nextDateYear."' AND MONTH(created_date) = '".$nextDateMonth."' ");
                                            $nextPayout -> execute();
                                            $nextPayout -> setFetchMode(PDO::FETCH_ASSOC);
                                            if($nextPayout -> rowCount()>0){
                                                foreach(($nextPayout -> fetchAll()) as $key => $row2){
                                                    $nextPayoutTotal = $row2['nextPayout'];
                                                    $nextPayoutTDS = $nextPayoutTotal * $tdsPercentage;
                                                    $TotalNextPayout = $nextPayoutTotal - $nextPayoutTDS;
                                                    $truncatedNextAmount = floor($TotalNextPayout * 100) / 100;
                                                    echo'<p class="fs-5 font fw-bolder mt-n2 icon">Rs.' .number_format($truncatedNextAmount,2). '/- </p>
                                                    <span class="badge bg-success fw-bold status1 paystatus" style="height: 15px !important; margin-top: 16px;" readonly>Paid</span>';
                                                }
                                            }
                                        ?>
                                        
                                        <!-- <a href="payout/forms/product_payout/download_exel_ca.php?payoutYear=<?php echo $prevDateYear; ?>&payoutMonth=<?php echo $prevDateMonth; ?>&payoutmessage=PreviousPayout">
                                            <i class="bx bx-download download-icon status1 paystatus" style="font-size: 20px; color: black; margin-left: 20%;"></i>
                                        </a> -->
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
                                            <p>Name: <span><?php echo $firstname.' '.$lastname; ?></span><span class="fw-bold ms-4 date-layout layout-2 date-align"><?php echo "$date" ?></span></p>
                                            <p class="fs-5 fw-bolder mt-n2 icon">Rs. <?php echo number_format($truncatedNextAmount,2); ?>/- </p>
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
                                    <!-- <input type="hidden" name="user_table_count" id="user_table_count" value="" /> -->
                                    <div class="table-responsive table-desi" id="filterTableNext">
                                        <!-- table roe limit -->
                                        <table class="table table-hover" id="next_payout_table">
                                            <thead>
                                                <tr>
                                                    <th class="ceterText fw-bolder sub-title">Date</th>
                                                    <th class="ceterText fw-bolder sub-title">Payout Details</th>
                                                    <?php if($userType == '11'){ ?>
                                                        <th class="ceterText fw-bolder sub-title">Markup</th>
                                                    <?php } ?>
                                                    <th class="ceterText fw-bolder sub-title">Amount</th>
                                                    <th class="ceterText fw-bolder sub-title">TDS</th>
                                                    <th class="ceterText fw-bolder sub-title">Total Payable</th>
                                                    <th class="ceterText fw-bolder sub-title">Remark</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php

                                                    if($userType == '10'){
                                                        $sql = "SELECT * FROM `product_payout` WHERE  (cu1_id = '".$userId."') OR (cu2_id = '".$userId."') OR (cu3_id = '".$userId."')  AND YEAR(created_date) = '".$nextDateYear."' AND MONTH(created_date) = '".$nextDateMonth."' ";
                                                    }else if($userType == '11'){
                                                        $sql = "SELECT * FROM `product_payout` WHERE  ta_id = '".$userId."' AND YEAR(created_date) = '".$nextDateYear."' AND MONTH(created_date) = '".$nextDateMonth."' ";
                                                    }else if($userType == '16'){
                                                        $sql = "SELECT * FROM `product_payout` WHERE  te_id = '".$userId."'  AND YEAR(created_date) = '".$nextDateYear."' AND MONTH(created_date) = '".$nextDateMonth."' ";
                                                    }else if($userType == '26'){
                                                        $sql = "SELECT * FROM `product_payout` WHERE  bm_id = '".$userId."' AND YEAR(created_date) = '".$nextDateYear."' AND MONTH(created_date) = '".$nextDateMonth."'  ";
                                                    }else if($userType == '25'){
                                                        $sql = "SELECT * FROM `product_payout` WHERE  bdm_id = '".$userId."' AND YEAR(created_date) = '".$nextDateYear."' AND MONTH(created_date) = '".$nextDateMonth."'  ";
                                                    }else if($userType == '24'){
                                                        $sql = "SELECT * FROM `product_payout` WHERE  bch_id = '".$userId."'  AND YEAR(created_date) = '".$nextDateYear."' AND MONTH(created_date) = '".$nextDateMonth."' ";
                                                    }
                                                    
                                                    $stmt = $conn -> prepare($sql);
                                                    $stmt -> execute();
                                                    $stmt -> setFetchMode(PDO::FETCH_ASSOC);
                                                    if( $stmt -> rowCount()>0 ){
                                                        foreach( ($stmt -> fetchALL()) as $key => $row ){
                                                            // print_r($stmt);
                                                            // print_r($row);
                                                            // echo '</br>';
                                                            // date in proper formate
                                                            $dt = new DateTime($row['created_date']);
                                                            $dt = $dt->format('Y-m-d');
                                                            
                                                            //get package Name
                                                            $stmt1 = $conn -> prepare(" SELECT name FROM package WHERE id = '".$row['package_id']."' ");
                                                            $stmt1 -> execute();
                                                            $pkgName = $stmt1 -> fetch();
                                                            $packageName = $pkgName['name'];

                                                            //get customer Name
                                                            $stmt8 = $conn -> prepare(" SELECT firstname, lastname FROM ca_customer WHERE ca_customer_id = '".$row['cu_id']."' ");
                                                            $stmt8 -> execute();
                                                            $cu_name = $stmt8 -> fetch();
                                                            $cuName = $cu_name['firstname'].' '.$cu_name['lastname']; 
                                                            
                                                            $no_of_adult = $row['no_of_adult'] ;
                                                            $no_of_child = $row['no_of_child'] ;

                                                            //customer part remaining
                                                            if($userType == '10'){
                                                                $cu1 = $row['cu1_id'];
                                                                $cu2 = $row['cu2_id'];
                                                                $cu3 = $row['cu3_id'];
                                                                if($cu1 == $userId){
                                                                    $message = $row['cu1_mess']; 
                                                                    $amt = $row['cu1_amt'];
                                                                    $status = $row['cu1_status'];
                                                                }else if($cu2 == $userId){
                                                                    $message = $row['cu2_mess'];
                                                                    $amt = $row['cu2_amt'];
                                                                    $status = $row['cu2_status'];
                                                                }else{
                                                                    $message = $row['cu3_mess'];
                                                                    $amt = $row['cu3_amt'];
                                                                    $status = $row['cu3_status'];
                                                                }
                                                                $tds = $amt * $tdsPercentage;
                                                                $total = $amt - $tds;
                                                            }else if($userType == '11'){
                                                                $id = $row['ta_id'];
                                                                $ta_markup = $row['ta_markup'];
                                                                $message = $row['ta_mess'];
                                                                $amt = $row['ta_amt'];
                                                                $status = $row['ta_status'];
                                                                $tds = $amt * $tdsPercentage;
                                                                $total = $amt - $tds;
                                                            }else if($userType == '16'){
                                                                $id = $row['te_id'];
                                                                $message = $row['te_mess'];
                                                                $amt = $row['te_amt'];
                                                                $status = $row['te_status'];
                                                                $tds = $amt * $tdsPercentage;
                                                                $total = $amt - $tds;
                                                            }else if($userType == '24'){
                                                                $id = $row['bch_id'];
                                                                $message = $row['bch_mess'];
                                                                $amt = $row['bch_amt'];
                                                                $status = $row['bch_status'];
                                                                $tds = $amt * $tdsPercentage;
                                                                $total = $amt - $tds;
                                                            }else if($userType == '25'){
                                                                $id = $row['bdm_id'];
                                                                $message = $row['bdm_mess'];
                                                                $amt = $row['bdm_amt'];
                                                                $status = $row['bdm_status'];
                                                                $tds = $amt * $tdsPercentage;
                                                                $total = $amt - $tds;
                                                            }else if($userType == '26'){
                                                                $id = $row['bm_id'];
                                                                $message = $row['bm_mess'];
                                                                $amt = $row['bm_amt'];
                                                                $status = $row['bm_status'];
                                                                $tds = $amt * $tdsPercentage;
                                                                $total = $amt - $tds;
                                                            }

                                                            echo '<tr>
                                                                    <td>'.$dt.'</td>';
                                                                    if($userType == '11'){
                                                                        echo'<td>'.$message.' <br/> on selling '.$packageName.' Package to '.$cuName.'<br/> No of Adult -> '.$no_of_adult.'. No of child ->'. $no_of_child.'<br> Markup Price -> Rs '.$ta_markup.'</td>
                                                                        <td >'.$ta_markup.'</td>';
                                                                    }else{
                                                                        echo '<td>'.$message.' <br/> on selling '.$packageName.' Package to '.$cuName.'<br/> No of Adult -> '.$no_of_adult.'. No of child ->'. $no_of_child.'</td>';
                                                                    }
                                                                    echo'
                                                                    <td >'.$amt.'</td>
                                                                    <td >'.$tds.'</td>
                                                                    <td >'.$total.'</td>';
                                                                    if($status == '1'){
                                                                        echo'<td><span class="badge bg-success fw-bold ms-4">Paid</span></td>';
                                                                    }else{
                                                                        echo'<td><span class="badge bg-warning fw-bold ms-4">Pending</span></td>';
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
                                    <p class="pt-3">Total Payout<span class="fw-bold date-layout layout-1"><?php echo "$date" ?></span></p>
                                    <div class="d-flex">
                                        <?php 
                                            if($userType == '11'){ //travel_consultant
                                                $userIdCommi = 'ta_id';
                                                $amtCal = 'ta_markup + ta_amt';
                                            }elseif($userType == '16'){ //Techno Enterprise/ corporate agency
                                                $userIdCommi = 'te_id';
                                                $amtCal = 'te_amt';
                                            }elseif($userType == '10'){ //customer
                                                $userIdCommi = 'cu1_id';
                                                $amtCal = 'cu1_amt';
                                            }elseif($userType == '26'){//business Mentor
                                                $userIdCommi = 'bm_id';
                                                $amtCal = 'bm_amt';
                                            }elseif($userType == '25'){// business Development manager
                                                $userIdCommi = 'bdm_id';
                                                $amtCal = 'bdm_amt';
                                            }elseif($userType == '24'){ // business channel manager
                                                $userIdCommi = 'bch_id';
                                                $amtCal = 'bch_amt';
                                            }
                                            $totalPayout = "SELECT SUM($amtCal) as total_payable FROM product_payout WHERE $userIdCommi = '".$userId."' ";
                                            $Payout = $conn -> prepare($totalPayout);
                                            $Payout -> execute();
                                            $Payout -> setFetchMode(PDO::FETCH_ASSOC);
                                            if($Payout->rowCount()>0){
                                                foreach(($Payout->fetchAll()) as $key => $row){
                                                    $total_payable = $row["total_payable"] ?? '0';
                                                    $totalPayoutTDS = $total_payable * $tdsPercentage;
                                                    $TotalPayoutFinal = $total_payable - $totalPayoutTDS;
                                                    $truncatedAmount = floor($TotalPayoutFinal * 100) / 100;
                                                   echo'
                                                    <p class="fs-5 font fw-bolder mt-n2 icon">Rs.'.number_format($truncatedAmount,2).'/- </p>
                                                    <span class="badge bg-success fw-bold status1 paystatus" style="height: 15px !important; margin-top: 16px;" readonly>Paid</span>
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
                                            <p>Name: <span><?php echo $firstname.' '.$lastname; ?></span><span class="fw-bold ms-4 date-layout layout-2 date-align"><?php echo "$date" ?></span></p>
                                            <p class="fs-5 fw-bolder mt-n2 icon">Rs. <?php echo  $truncatedAmount; ?>/- </p>
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
                                                    <th class="ceterText fw-bolder">Date</th>
                                                    <th class="ceterText fw-bolder">Payout Message</th>
                                                    <?php if($userType == '11'){ ?>
                                                        <th class="ceterText fw-bolder sub-title">Markup</th>
                                                    <?php } ?>
                                                    <!-- <th class="ceterText fw-bolder">Payout Details</th> -->
                                                    <th class="ceterText fw-bolder">Amount</th>
                                                    <th class="ceterText fw-bolder">TDS</th>
                                                    <th class="ceterText fw-bolder">Total Payable</th>
                                                    <th class="ceterText fw-bolder">Remark</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php

                                                    if($userType == '10'){
                                                        $sql = "SELECT * FROM `product_payout` WHERE  (cu1_id = '".$userId."') OR (cu2_id = '".$userId."') OR (cu3_id = '".$userId."')   ";
                                                    }else if($userType == '11'){
                                                        $sql = "SELECT * FROM `product_payout` WHERE  ta_id = '".$userId."'  ";
                                                    }else if($userType == '16'){
                                                        $sql = "SELECT * FROM `product_payout` WHERE  te_id = '".$userId."'   ";
                                                    }else if($userType == '26'){
                                                        $sql = "SELECT * FROM `product_payout` WHERE  bm_id = '".$userId."'   ";
                                                    }else if($userType == '25'){
                                                        $sql = "SELECT * FROM `product_payout` WHERE  bdm_id = '".$userId."'   ";
                                                    }else if($userType == '24'){
                                                        $sql = "SELECT * FROM `product_payout` WHERE  bch_id = '".$userId."'   ";
                                                    }
                                                    
                                                    $stmt = $conn -> prepare($sql);
                                                    $stmt -> execute();
                                                    $stmt -> setFetchMode(PDO::FETCH_ASSOC);
                                                    if( $stmt -> rowCount()>0 ){
                                                        foreach( ($stmt -> fetchALL()) as $key => $row ){
                                                            // print_r($stmt);
                                                            // print_r($row);
                                                            // echo '</br>';
                                                            // date in proper formate
                                                            $dt = new DateTime($row['created_date']);
                                                            $dt = $dt->format('Y-m-d');
                                                            
                                                            //get package Name
                                                            $stmt1 = $conn -> prepare(" SELECT name FROM package WHERE id = '".$row['package_id']."' ");
                                                            $stmt1 -> execute();
                                                            $pkgName = $stmt1 -> fetch();
                                                            $packageName = $pkgName['name'];

                                                            //get customer Name
                                                            $stmt8 = $conn -> prepare(" SELECT firstname, lastname FROM ca_customer WHERE ca_customer_id = '".$row['cu_id']."' ");
                                                            $stmt8 -> execute();
                                                            $cu_name = $stmt8 -> fetch();
                                                            $cuName = $cu_name['firstname'].' '.$cu_name['lastname']; 
                                                            
                                                            $no_of_adult = $row['no_of_adult'] ;
                                                            $no_of_child = $row['no_of_child'] ;

                                                            //customer part remaining
                                                            if($userType == '10'){
                                                                $cu1 = $row['cu1_id'];
                                                                $cu2 = $row['cu2_id'];
                                                                $cu3 = $row['cu3_id'];
                                                                if($cu1 == $userId){
                                                                    $message = $row['cu1_mess']; 
                                                                    $amt = $row['cu1_amt'];
                                                                    $status = $row['cu1_status'];
                                                                }else if($cu2 == $userId){
                                                                    $message = $row['cu2_mess'];
                                                                    $amt = $row['cu2_amt'];
                                                                    $status = $row['cu2_status'];
                                                                }else{
                                                                    $message = $row['cu3_mess'];
                                                                    $amt = $row['cu3_amt'];
                                                                    $status = $row['cu3_status'];
                                                                }
                                                                $tds = $amt * $tdsPercentage;
                                                                $total = $amt - $tds;
                                                            }else if($userType == '11'){
                                                                $id = $row['ta_id'];
                                                                $ta_markup = $row['ta_markup'];
                                                                $message = $row['ta_mess'];
                                                                $amt = $row['ta_amt'];
                                                                $status = $row['ta_status'];
                                                                $tds = $amt * $tdsPercentage;
                                                                $total = $amt - $tds;
                                                            }else if($userType == '16'){
                                                                $id = $row['te_id'];
                                                                $message = $row['te_mess'];
                                                                $amt = $row['te_amt'];
                                                                $status = $row['te_status'];
                                                                $tds = $amt * $tdsPercentage;
                                                                $total = $amt - $tds;
                                                            }else if($userType == '24'){
                                                                $id = $row['bch_id'];
                                                                $message = $row['bch_mess'];
                                                                $amt = $row['bch_amt'];
                                                                $status = $row['bch_status'];
                                                                $tds = $amt * $tdsPercentage;
                                                                $total = $amt - $tds;
                                                            }else if($userType == '25'){
                                                                $id = $row['bdm_id'];
                                                                $message = $row['bdm_mess'];
                                                                $amt = $row['bdm_amt'];
                                                                $status = $row['bdm_status'];
                                                                $tds = $amt * $tdsPercentage;
                                                                $total = $amt - $tds;
                                                            }else if($userType == '26'){
                                                                $id = $row['bm_id'];
                                                                $message = $row['bm_mess'];
                                                                $amt = $row['bm_amt'];
                                                                $status = $row['bm_status'];
                                                                $tds = $amt * $tdsPercentage;
                                                                $total = $amt - $tds;
                                                            }

                                                            echo '<tr>
                                                                    <td>'.$dt.'</td>';
                                                                    if($userType == '11'){
                                                                        echo'<td>'.$message.' <br/> on selling '.$packageName.' Package to '.$cuName.'<br/> No of Adult -> '.$no_of_adult.'. No of child ->'. $no_of_child.'<br> Markup Price -> Rs '.$ta_markup.'</td>
                                                                        <td >'.$ta_markup.'</td>';
                                                                    }else{
                                                                        echo '<td>'.$message.' <br/> on selling '.$packageName.' Package to '.$cuName.'<br/> No of Adult -> '.$no_of_adult.'. No of child ->'. $no_of_child.'</td>';
                                                                    }
                                                                    echo'
                                                                    <td >'.$amt.'</td>
                                                                    <td >'.$tds.'</td>
                                                                    <td >'.$total.'</td>';
                                                                    if($status == '1'){
                                                                        echo'<td><span class="badge bg-success fw-bold ms-4">Paid</span></td>';
                                                                    }else{
                                                                        echo'<td><span class="badge bg-warning fw-bold ms-4">Pending</span></td>';
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
        <script src="payout/payout_product.js"></script>

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

                //for keeping 2 decimals without rounding added on 25-Jan-2025 by SV
                function truncateToTwoDecimals(num) {
                    return Math.trunc(num * 100) / 100;
                }
            });

        </script>
    </body>
</html>

