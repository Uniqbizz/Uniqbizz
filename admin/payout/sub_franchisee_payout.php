<?php
    session_start();
    if(!isset($_SESSION['username'])){
        echo '<script>location.href = "../login.php";</script>';
    }

    require '../connect.php';
    $dateYear = date('Y'); 

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

?>
<!doctype html>
<html lang="en">

    <head>
        
        <meta charset="utf-8" />
        <title>Uniqbizz - Admin Dashboard</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- App favicon -->
        <link rel="shortcut icon" href="../assets/images/fav.png">
        <!-- custom css file -->
        <!-- <link href="../assets/css/styles.css" rel="stylesheet" type="text/css" /> -->
        <!-- Bootstrap Css -->
        <link href="../assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
        <!-- Icons Css -->
        <link href="../assets/css/icons.min.css" rel="stylesheet" type="text/css" />
        <!-- App Css-->
        <link href="../assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />

        <link href="payout.css" rel="stylesheet" type="text/css" /> 

        <!-- App js -->
        <!-- <script src="assets/js/plugin.js"></script> --> 
        <!-- DataTables -->
        <link href="../assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />

        <!-- Responsive datatable examples -->
        <link href="../assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />  
  
        <style>
            /* font size */
            .head{
                font-size: 18px!important;
            }
            .sub-head{
                font-size: 16px!important;
            }
            .cursor{
                cursor: pointer;
            }
        </style>
    </head>
    

    <body data-sidebar="dark">

        <!-- <body data-layout="horizontal" data-topbar="dark"> -->

        <!-- Begin page -->
        <div id="layout-wrapper">

            <?php 
                // top header logo, hamberger menu, fullscreen icon, profile
                include_once '../header.php';

                // sidebar navigation menu 
                include_once '../sidebar.php';
            ?>
            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->
            <div class="main-content">
                <div class="page-content card">
                    <div class="container-fluid">
                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                    <h2 class="mb-sm-0 fw-bolder ps-4">Product Payouts</h2>
                                </div>
                                
                            </div>
                        </div>
                        <!-- end page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="row d-flex justify-content-evenly">
                                    <div class="col-lg-6 col-md-6 col-sm-6 card border-2 border-dark rounded-4">
                                        <div class="row">
                                            <div class="col-lg-6 col-sm-6 col-6  border-4 border-end border-end-dashed">
                                                <div class="page-title-box p-3">
                                                    <p class="font-size-14">Previous Payout<span class="fw-bold font-size-10 ms-5"><?php echo "$prevdate" ?></span></p>
                                                    <?php 
                                                        $previousPayout = $conn -> prepare("SELECT SUM(ta_markup+ta_amt+te_amt+bm_amt+bdm_amt+bch_amt+cu1_amt+cu2_amt+cu3_amt) as previousPayout FROM product_payout WHERE YEAR(created_date) = '".$prevDateYear."' AND MONTH(created_date) = '".$prevDateMonth."' ");
                                                        $previousPayout -> execute();
                                                        $previousPayout -> setFetchMode(PDO::FETCH_ASSOC);
                                                        if($previousPayout -> rowCount()>0){
                                                            foreach(($previousPayout -> fetchAll()) as $key => $row){
                                                                $previousPayout = $row['previousPayout'];
                                                                $previousPayoutTDS = $previousPayout * $tdsPercentage;
                                                                $TotalpreviousPayout = $previousPayout - $previousPayoutTDS;
                                                                $truncatedPrevAmount = floor($TotalpreviousPayout * 100) / 100;
                                                                echo'<p class="fs-5 fw-bolder mt-n2">Rs. ' .number_format($truncatedPrevAmount,2). '/- <span class="badge badge-pill badge-soft-warning font-size-10 fw-bold ms-4">Pending</span> </p>';
                                                            }
                                                        }
                                                    ?>
                                                    <a type="button" data-bs-toggle="modal" data-bs-target="#previousPayout" style=" cursor: pointer;">
                                                        <p class="mt-n2 mb-1 fw-bold p1" style="color: #0096FF;">View Payout</p>
                                                    </a>
                                                    <a href="forms/product_payout/download_exel_product_payout?payoutYear=<?php echo $prevDateYear; ?>&payoutMonth=<?php echo $prevDateMonth; ?>&payoutmessage=PreviousPayout">
                                                        <i class="bx bx-download download-icon1" style="font-size: 20px; color: black; margin-left: 20%;"></i>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-sm-6 col-6 ">
                                                <div class="page-title-box p-3">
                                                    <p class="font-size-14">Next Payout<span class="fw-bold font-size-10 ms-5 date-layout "><?php echo "$date" ?></span></p>
                                                    <?php 
                                                        $nextPayout = $conn -> prepare("SELECT SUM(ta_markup+ta_amt+te_amt+bm_amt+bdm_amt+bch_amt+cu1_amt+cu2_amt+cu3_amt) as nextPayout FROM product_payout WHERE YEAR(created_date) = '".$nextDateYear."' AND MONTH(created_date) = '".$nextDateMonth."' ");
                                                        $nextPayout -> execute();
                                                        $nextPayout -> setFetchMode(PDO::FETCH_ASSOC);
                                                        if($nextPayout -> rowCount()>0){
                                                            foreach(($nextPayout -> fetchAll()) as $key => $row2){
                                                                $nextPayoutTotal = $row2['nextPayout'];
                                                                $nextPayoutTDS = $nextPayoutTotal * $tdsPercentage;
                                                                $TotalNextPayout = $nextPayoutTotal - $nextPayoutTDS;
                                                                $truncatedNextAmount = floor($TotalNextPayout * 100) / 100;
                                                                echo'<p class="fs-5 fw-bolder mt-n2">Rs.' .number_format($truncatedNextAmount,2). '/- <span class="badge badge-pill badge-soft-warning font-size-10 fw-bold ms-4">Pending</span> </p>';
                                                            }
                                                        }
                                                    ?>
                                                    <a type="button" data-bs-toggle="modal" data-bs-target="#nextPayout" style=" cursor: pointer;">
                                                        <p class="mt-n2 mb-1 fw-bold p1" style="color: #0096FF;">View Payout</p>
                                                    </a>
                                                    <a href="forms/product_payout/download_exel_product_payout?payoutYear=<?php echo $nextDateYear; ?>&payoutMonth=<?php echo $nextDateMonth; ?>&payoutmessage=NextPayout">
                                                        <i class="bx bx-download download-icon1" style="font-size: 20px; color: black; margin-left: 20%;"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>    
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-4 card border-2 border-dark rounded-4">
                                        <div class="col-sm-12">
                                            <div class="page-title-box container p-3">
                                                <div class="align-middle month-format">
                                                    <p class="font-size-14">Total Payout
                                                        <div id="cap_text_1" class="filter-opt-4">
                                                            <span  class="font-size-10 rounded-4 d-block border-round">
                                                                <p class="fw-bold">Select month, year <span class="bx bx-calendar-alt"></span></p> 
                                                            </span>
                                                        </div>
                                                        <input type="month" id="month_year" value="" min="2020-01" max="" class="font-size-10 fw-bold rounded-4 d-none border-round">
                                                    </p>
                                                </div>
                                                <?php 
                                                    // $totalPayout = "SELECT SUM(
                                                    //                     CASE WHEN bc_status = '1' THEN bc_amt ELSE 0 END +
                                                    //                     CASE WHEN ca_status = '1' THEN ca_amt ELSE 0 END +
                                                    //                     CASE WHEN ca_ta_status = '1' THEN ca_ta_amt ELSE 0 END +
                                                    //                     CASE WHEN ca_cu1_status = '1' THEN ca_cu1_amt ELSE 0 END +
                                                    //                     CASE WHEN ca_cu2_status = '1' THEN ca_cu2_amt ELSE 0 END +
                                                    //                     CASE WHEN ca_cu3_status = '1' THEN ca_cu3_amt ELSE 0 END +
                                                    //                     CASE WHEN ca_ta_status = '1' THEN ta_markup ELSE 0 END
                                                    //                 ) as total_payable 
                                                    //             FROM product_payout";
                                                    $totalPayout = "SELECT SUM(ta_markup+ta_amt+te_amt+bm_amt+bdm_amt+bch_amt+cu1_amt+cu2_amt+cu3_amt) as total_payable FROM product_payout";
                                                    $Payout = $conn -> prepare($totalPayout);
                                                    $Payout -> execute();
                                                    $Payout -> setFetchMode(PDO::FETCH_ASSOC);
                                                    if($Payout->rowCount()>0){
                                                        foreach(($Payout->fetchAll()) as $key => $row){
                                                            $total_payable = $row["total_payable"] ?? '0';
                                                            $totalPayoutTDS = $total_payable * $tdsPercentage;
                                                            $TotalPayout = $total_payable - $totalPayoutTDS;
                                                            $truncatedTotalAmount = floor($TotalPayout * 100) / 100;
                                                            echo'<p class="fs-5 fw-bolder mt-n2 content1" id="TotalPayoutAmountDate">Rs.'.number_format($truncatedTotalAmount,2).'/-</p>';
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
                                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                            <h2 class="mb-sm-0 fw-bolder ps-4">All Payouts</h2>
                                        </div>
                                        <div class="row filter-options">
                                            <div class="designation-filter no-space col-md-2 col-sm-12">
                                                <!-- <label> Filter Payouts</label> -->
                                                <select id="designation" class="selectdesign filter-opt-1 fw-bolder">
                                                    <option value="">--Select Filter Option--</option>
                                                    <option value="business_channel_manager">Business Channel Manager</option>
                                                    <option value="business_development_manager">Business Development Manager</option>
                                                    <option value="business_mentor">Business Mentor</option>
                                                    <option value="corporate_agency">Techno Enterprise</option>
                                                    <option value="ca_travelagency">Travel Consultant</option>
                                                    <option value="ca_customer">Customer</option>
                                                    <!-- <option value="base_agency">Base Agency</option> -->
                                                </select>
                                            </div>
                                            <div class="name-filter no-space col-md-2 col-sm-12 " >
                                                <!-- <label>User ID & Name</label> -->
                                                <select id="user_id_name" class="selectdesign filter-opt-2 minimal fw-bolder" > 
                                                    <option style="text-align:center;" value="">--Select Name First--</option>
                                                </select>
                                            </div>
                                            <div class="month-filter no-space col-md-2 col-sm-12">
                                                <!-- <label>User ID & Name</label> -->
                                                <!-- <input type="text" id="cap_text" class="filter-opt-3" placeholder="Select Month, Year"> -->
                                                <div id="cap_text" class="filter-opt-3-1">
                                                    <span  class="span-middle-align">
                                                        <p>Select Month, Year <span class="bx bx-calendar-alt"></span></p> 
                                                    </span>
                                                </div>
                                                <input name="date" id="cap_date" class="filter-opt-3 d-none" type="month" placeholder="Select Month, Year">    
                                            </div>
                                            <form class="col-md-4 app-search d-lg-block">
                                                <div class="position-relative">
                                                    <span class="bx bx-search-alt"></span>
                                                    <input type="text" class="form-control search control" placeholder="Search...">
                                                </div>
                                            </form>
                                            <div class="col-lg-1" id="download_icon" style="display: none;">
                                                <i class="bx bx-download" onclick="allPayoutExel()" style="font-size: 20px; color: black; margin-left: 40%; cursor: pointer;"></i>
                                            </div>
                                            
                                            <!-- <div class="download_payout_exel no-space col-md-1 col-sm-12" style="">
                                                <i id="download_exel" onclick="allPayoutExel()" style="color: #263238; background: #b6b6b64d; border-radius: 4px; font-size:25px; padding:0; display: none; cursor:pointer;" class="material-icons">play_for_work</i>
                                            </div> -->
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
                                                            <th class="fw-bolder font-size-16" style="display: none;">ID</th>
                                                            <th class="fw-bolder font-size-16">Date</th>
                                                            <!-- <th class="fw-bolder font-size-16">ID</th>
                                                            <th class="fw-bolder font-size-16">Pkg ID</th> -->
                                                            <th class="fw-bolder font-size-16">Payout Details</th>
                                                            <th class="fw-bolder font-size-16">Amount</th>
                                                            <th class="fw-bolder font-size-16">TDS</th>
                                                            <th class="fw-bolder font-size-16">Total Payable</th>
                                                            <th class="fw-bolder font-size-16">Remark</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                            $sql = "SELECT * FROM `product_payout` ORDER BY `created_date` ASC";
                                                            $stmt = $conn -> prepare($sql);
                                                            $stmt -> execute();
                                                            $stmt -> setFetchMode(PDO::FETCH_ASSOC);
                                                            if( $stmt -> rowCount()>0 ){
                                                                foreach( ($stmt -> fetchALL()) as $key => $row ){

                                                                    // date in proper formate
                                                                    $dt = new DateTime($row['created_date']);
                                                                    $dt = $dt->format('Y-m-d');

                                                                    $ta_markup = $row['ta_markup'] ;
                                                                    $no_of_adult = $row['no_of_adult'] ;
                                                                    $no_of_child = $row['no_of_child'] ;
                                                                    $customer_id = $row['cu_id'] ;

                                                                    $stmt1 = $conn -> prepare(" SELECT name FROM package WHERE id = '".$row['package_id']."' ");
                                                                    $stmt1 -> execute();
                                                                    $pkgName = $stmt1 -> fetch();
                                                                    $packageName = $pkgName['name'];

                                                                    $stmt8 = $conn -> prepare(" SELECT firstname, lastname FROM ca_customer WHERE ca_customer_id = '".$customer_id."' ");
                                                                    $stmt8 -> execute();
                                                                    $cu_name = $stmt8 -> fetch();
                                                                    $cuName = $cu_name['firstname'].' '.$cu_name['lastname'];

                                                                    $cu3_id = $row['cu3_id'];
                                                                    $cu2_id = $row['cu2_id'];
                                                                    $cu1_id = $row['cu1_id'];
                                                                    $bdm_id = $row['bdm_id'];
                                                                    $bch_id = $row['bch_id'];

                                                                    // ta message
                                                                    $ta_id = $row['ta_id'];
                                                                    $ta_mess = $row['ta_mess'];
                                                                    $ta_amt = $row['ta_amt'];
                                                                    $ta_status = $row['ta_status'];
                                                                    $ta_tds = $ta_amt * $tdsPercentage;
                                                                    $ta_total = $ta_amt - $ta_tds;

                                                                    // te message
                                                                    $te_id = $row['te_id'];
                                                                    $te_mess = $row['te_mess'];
                                                                    $te_amt = $row['te_amt'];
                                                                    $te_status = $row['te_status'];
                                                                    $te_tds = $te_amt * $tdsPercentage;
                                                                    $te_total = $te_amt - $te_tds;

                                                                    // bm message
                                                                    $bm_id = $row['bm_id'];
                                                                    $bm_mess = $row['bm_mess'];
                                                                    $bm_amt = $row['bm_amt'];
                                                                    $bm_status = $row['bm_status'];
                                                                    $bm_tds = $bm_amt * $tdsPercentage;
                                                                    $bm_total = $bm_amt - $bm_tds;

                                                                    // bdm message
                                                                    if($bdm_id){
                                                                        // $bdm_id = $row['bdm_id'];
                                                                        $bdm_mess = $row['bdm_mess'];
                                                                        $bdm_amt = $row['bdm_amt'];
                                                                        $bdm_status = $row['bdm_status'];
                                                                        $bdm_tds = $bdm_amt * $tdsPercentage;
                                                                        $bdm_total = $bdm_amt - $bdm_tds;
                                                                    }

                                                                    // bcm message
                                                                    if($bch_id){
                                                                        // $bch_id = $row['bch_id'];
                                                                        $bch_mess = $row['bch_mess'];
                                                                        $bch_amt = $row['bch_amt'];
                                                                        $bch_status = $row['bch_status'];
                                                                        $bch_tds = $bch_amt * $tdsPercentage;
                                                                        $bch_total = $bch_amt - $bch_tds;
                                                                    }

                                                                    // cu1 message
                                                                    if($cu1_id){
                                                                        // $cu1_id = $row['cu1_id'];
                                                                        $cu1_mess = $row['cu1_mess'];
                                                                        $cu1_amt = $row['cu1_amt'];
                                                                        $cu1_status = $row['cu1_status'];
                                                                        $cu1_tds = $cu1_amt * $tdsPercentage;
                                                                        $cu1_total = $cu1_amt - $cu1_tds;
                                                                    }

                                                                    // cu2 message
                                                                    if($cu2_id){
                                                                        // $cu2_id = $row['cu2_id'];
                                                                        $cu2_mess = $row['cu2_mess'];
                                                                        $cu2_amt = $row['cu2_amt'];
                                                                        $cu2_status = $row['cu2_status'];
                                                                        $cu2_tds = $cu2_amt * $tdsPercentage;
                                                                        $cu2_total = $cu2_amt - $cu2_tds;
                                                                    }

                                                                    // cu3 message
                                                                    if($cu3_id){
                                                                        // $cu3_id = $row['cu3_id'];
                                                                        $cu3_mess = $row['cu3_mess'];
                                                                        $cu3_amt = $row['cu3_amt'];
                                                                        $cu3_status = $row['cu3_status'];
                                                                        $cu3_tds = $cu3_amt * $tdsPercentage;
                                                                        $cu3_total = $cu3_amt - $cu3_tds;
                                                                    }

                                                                    if($cu3_id){
                                                                        echo'<tr>
                                                                                <td style="display: none;">'.$row['id'].'</td>
                                                                                <td>'.$dt.'</td>
                                                                                <td>'.$cu3_mess.'<br/> on selling '.$packageName.' package to  Customer ->'.$cuName.'<br/> No of Adult -> '.$no_of_adult.'. No of child ->'. $no_of_child.'</td>
                                                                                <td>'.$cu3_amt.'</td>
                                                                                <td>'.$cu3_tds.'</td>
                                                                                <td>'.$cu3_total.'</td>';
                                                                                if($cu3_status == '1'){
                                                                                    echo'<td><span class="badge badge-pill badge-soft-success font-size-10 fw-bold ms-4">Paid</span></td>';
                                                                                }else{
                                                                                    echo'<td><span class="badge badge-pill badge-soft-warning font-size-10 fw-bold ms-4" data-bs-toggle="modal" data-bs-target=".bs-example-modal-center" onclick=\'paymentId("' .$row['id']. '","' .$row['cu3_id']. '","' .$row['cu3_mess']. '","' .$row['cu3_amt']. '","cu3_status","AllPayoutCaCu3")\'>Pending</span></td>';
                                                                                }
                                                                        echo'</tr>';
                                                                    }

                                                                    if($cu2_id){
                                                                        echo'<tr>
                                                                                <td style="display: none;">'.$row['id'].'</td>
                                                                                <td>'.$dt.'</td>
                                                                                <td>'.$cu2_mess.'<br/> on selling '.$packageName.' package to  Customer ->'.$cuName.'<br/> No of Adult -> '.$no_of_adult.'. No of child ->'. $no_of_child.'</td>
                                                                                <td>'.$cu2_amt.'</td>
                                                                                <td>'.$cu2_tds.'</td>
                                                                                <td>'.$cu2_total.'</td>';
                                                                                if($cu2_status == '1'){
                                                                                    echo'<td><span class="badge badge-pill badge-soft-success font-size-10 fw-bold ms-4">Paid</span></td>';
                                                                                }else{
                                                                                    echo'<td><span class="badge badge-pill badge-soft-warning font-size-10 fw-bold ms-4" data-bs-toggle="modal" data-bs-target=".bs-example-modal-center" onclick=\'paymentId("' .$row['id']. '","' .$row['cu2_id']. '","' .$row['cu2_mess']. '","' .$row['cu2_amt']. '","cu2_status","AllPayoutCaCu2")\'>Pending</span></td>';
                                                                                }
                                                                        echo'</tr>';
                                                                    }

                                                                    if($cu1_id){
                                                                        echo'<tr>
                                                                                <td style="display: none;">'.$row['id'].'</td>
                                                                                <td>'.$dt.'</td>
                                                                                <td>'.$cu1_mess.'<br/> on selling '.$packageName.' package to  Customer ->'.$cuName.'<br/> No of Adult -> '.$no_of_adult.'. No of child ->'. $no_of_child.'</td>
                                                                                <td>'.$cu1_amt.'</td>
                                                                                <td>'.$cu1_tds.'</td>
                                                                                <td>'.$cu1_total.'</td>';
                                                                                if($cu1_status == '1'){
                                                                                    echo'<td><span class="badge badge-pill badge-soft-success font-size-10 fw-bold ms-4">Paid</span></td>';
                                                                                }else{
                                                                                    echo'<td><span class="badge badge-pill badge-soft-warning font-size-10 fw-bold ms-4" data-bs-toggle="modal" data-bs-target=".bs-example-modal-center" onclick=\'paymentId("' .$row['id']. '","' .$row['cu1_id']. '","' .$row['cu1_mess']. '","' .$row['cu1_amt']. '","cu1_status","AllPayoutCaCu1")\'>Pending</span></td>';
                                                                                }
                                                                        echo'</tr>';
                                                                    }

                                                                    echo '<tr>
                                                                            <td style="display: none;">'.$row['id'].'</td>
                                                                            <td>'.$dt.'</td>
                                                                            <td>'.$ta_mess.'<br/> on selling '.$packageName.' package to  Customer ->'.$cuName.'<br/> No of Adult -> '.$no_of_adult.'. No of child ->'. $no_of_child.'<br/> Travel Consultant Markup ->Rs. '.$ta_markup.'</td>
                                                                            <td>'.$ta_amt.'</td>
                                                                            <td>'.$ta_tds.'</td>
                                                                            <td>'.$ta_total.'</td>';
                                                                            if($ta_status == '1'){
                                                                                echo'<td><span class="badge badge-pill badge-soft-success font-size-10 fw-bold ms-4">Paid</span></td>';
                                                                            }else{
                                                                                echo'<td><span class="badge badge-pill badge-soft-warning font-size-10 fw-bold ms-4" data-bs-toggle="modal" data-bs-target=".bs-example-modal-center" onclick=\'paymentId("' .$row['id']. '","' .$row['ta_id']. '","' .$row['ta_mess']. '","' .$row['ta_amt']. '","ta_status","AllPayoutTa")\'>Pending</span></td>';
                                                                            }
                                                                    echo'</tr>';
                                                                    echo'<tr>
                                                                            <td style="display: none;">'.$row['id'].'</td>
                                                                            <td>'.$dt.'</td>
                                                                            <td>'.$te_mess.'<br/> on selling '.$packageName.' package to  Customer ->'.$cuName.'<br/> No of Adult -> '.$no_of_adult.'. No of child ->'. $no_of_child.'</td>
                                                                            <td>'.$te_amt.'</td>
                                                                            <td>'.$te_tds.'</td>
                                                                            <td>'.$te_total.'</td>';
                                                                            if($te_status == '1'){
                                                                                echo'<td><span class="badge badge-pill badge-soft-success font-size-10 fw-bold ms-4">Paid</span></td>';
                                                                            }else{
                                                                                echo'<td><span class="badge badge-pill badge-soft-warning font-size-10 fw-bold ms-4" data-bs-toggle="modal" data-bs-target=".bs-example-modal-center" onclick=\'paymentId("' .$row['id']. '","' .$row['te_id']. '","' .$row['te_mess']. '","' .$row['te_amt']. '","te_status","AllPayoutTe")\'>Pending</span></td>';
                                                                            }
                                                                    echo'</tr>';
                                                                    echo'<tr>
                                                                            <td style="display: none;">'.$row['id'].'</td>
                                                                            <td>'.$dt.'</td>
                                                                            <td>'.$bm_mess.'<br/> on selling '.$packageName.' package to  Customer ->'.$cuName.'<br/> No of Adult -> '.$no_of_adult.'. No of child ->'. $no_of_child.'</td>
                                                                            <td>'.$bm_amt.'</td>
                                                                            <td>'.$bm_tds.'</td>
                                                                            <td>'.$bm_total.'</td>';
                                                                            if($bm_status == '1'){
                                                                                echo'<td><span class="badge badge-pill badge-soft-success font-size-10 fw-bold ms-4">Paid</span></td>';
                                                                            }else{
                                                                                echo'<td><span class="badge badge-pill badge-soft-warning font-size-10 fw-bold ms-4" data-bs-toggle="modal" data-bs-target=".bs-example-modal-center" onclick=\'paymentId("' .$row['id']. '","' .$row['bm_id']. '","' .$row['bm_mess']. '","' .$row['bm_amt']. '","bm_status","AllPayoutBm")\'>Pending</span></td>';
                                                                            }
                                                                    echo'</tr>';

                                                                    if($row['bdm_id']){
                                                                        echo'<tr>
                                                                                <td style="display: none;">'.$row['id'].'</td>
                                                                                <td>'.$dt.'</td>
                                                                                <td>'.$bdm_mess.'<br/> on selling '.$packageName.' package to  Customer ->'.$cuName.'<br/> No of Adult -> '.$no_of_adult.'. No of child ->'. $no_of_child.'</td>
                                                                                <td>'.$bdm_amt.'</td>
                                                                                <td>'.$bdm_tds.'</td>
                                                                                <td>'.$bdm_total.'</td>';
                                                                                if($bdm_status == '1'){
                                                                                    echo'<td><span class="badge badge-pill badge-soft-success font-size-10 fw-bold ms-4">Paid</span></td>';
                                                                                }else{
                                                                                    echo'<td><span class="badge badge-pill badge-soft-warning font-size-10 fw-bold ms-4" data-bs-toggle="modal" data-bs-target=".bs-example-modal-center" onclick=\'paymentId("' .$row['id']. '","' .$row['bdm_id']. '","' .$row['bdm_mess']. '","' .$row['bdm_amt']. '","bdm_status","AllPayoutBdm")\'>Pending</span></td>';
                                                                                }
                                                                        echo'</tr>';
                                                                    }

                                                                    if($row['bch_id']){
                                                                        echo'<tr>
                                                                                <td style="display: none;">'.$row['id'].'</td>
                                                                                <td>'.$dt.'</td>
                                                                                <td>'.$bch_mess.'<br/> on selling '.$packageName.' package to  Customer ->'.$cuName.'<br/> No of Adult -> '.$no_of_adult.'. No of child ->'. $no_of_child.'</td>
                                                                                <td>'.$bch_amt.'</td>
                                                                                <td>'.$bch_tds.'</td>
                                                                                <td>'.$bch_total.'</td>';
                                                                                if($bch_status == '1'){
                                                                                    echo'<td><span class="badge badge-pill badge-soft-success font-size-10 fw-bold ms-4">Paid</span></td>';
                                                                                }else{
                                                                                    echo'<td><span class="badge badge-pill badge-soft-warning font-size-10 fw-bold ms-4" data-bs-toggle="modal" data-bs-target=".bs-example-modal-center" onclick=\'paymentId("' .$row['id']. '","' .$row['bch_id']. '","' .$row['bch_mess']. '","' .$row['bch_amt']. '","bch_status","AllPayoutBch")\'>Pending</span></td>';
                                                                                }
                                                                        echo'</tr>';
                                                                    }
                                                                    
                                                                    
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

        
        <!-- sample modal content -->
        <div id="previousPayout" class="modal fade" tabindex="-1" aria-labelledby="#exampleModalFullscreenLabel" aria-hidden="true" data-bs-backdrop="static"  data-bs-keyboard="false" style="border-radius: 20px !important;">
            <div class="modal-dialog modal-fullscreen" style="width: 80%; margin: auto; margin-top: 30px; margin-bottom: 30px; height: 90vh;" >
                <div class="modal-content modal-radius">
                    <div class="modal-header">
                        <h5 class="modal-title head fw-bold" id="exampleModalFullscreenLabel">Previous Payout</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row d-flex justify-content-evenly">   
                            <div class="col-lg-4 col-md-4 col-sm-7 card" style="border: 2px solid black; border-radius: 10px;">
                                <div class="page-title-box p-3">
                                    <p class="head pt-3">Previous Payout<span class="fw-bold font-size-12 date-layout layout-1"><?php echo "$prevdate" ?></span></p>
                                    <div class="d-flex">
                                        <?php 
                                            $previousPayout = $conn -> prepare("SELECT SUM(ta_markup+ta_amt+te_amt+bm_amt+bdm_amt+bch_amt+cu1_amt+cu2_amt+cu3_amt) as previousPayout FROM product_payout WHERE YEAR(created_date) = '".$prevDateYear."' AND MONTH(created_date) = '".$prevDateMonth."' ");
                                            $previousPayout -> execute();
                                            $previousPayout -> setFetchMode(PDO::FETCH_ASSOC);
                                            if($previousPayout -> rowCount()>0){
                                                foreach(($previousPayout -> fetchAll()) as $key => $row){
                                                    $previousPayout = $row['previousPayout'];
                                                    $previousPayoutTDS = $previousPayout * $tdsPercentage;
                                                    $TotalpreviousPayout = $previousPayout - $previousPayoutTDS;
                                                    $truncatedPrevAmount = floor($TotalpreviousPayout * 100) / 100;
                                                    echo'<p class="fs-5 font fw-bolder mt-n2 icon">Rs.' .number_format($truncatedPrevAmount,2). '/- </p><span class="badge badge-pill badge-soft-warning font-size-10 fw-bold status1" style="height: 15px !important; margin-top: 16px;" readonly>Pending</span>';
                                                }
                                            }
                                        ?>
                                        
                                        <a href="forms/product_payout/download_exel_product_payout?payoutYear=<?php echo $prevDateYear; ?>&payoutMonth=<?php echo $prevDateMonth; ?>&payoutmessage=PreviousPayout">
                                            <i class="bx bx-download download-icon status1" style="font-size: 20px; color: black; margin-left: 20%;"></i>
                                        </a>
                                    </div>
                                    
                                    
                                </div>
                            </div>
                            <div class="col-lg-7 col-md-7 col-sm-7">
                                <!-- <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                    <h2 class="mb-sm-0 fw-bolder ps-4">All Payouts</h2>
                                </div> -->
                                <div class="row filter-options filter">
                                    <div class="designation-filter no-space1 col-lg-5 col-md-5 col-sm-12">
                                        <!-- <label> Filter Payouts</label> -->
                                        <select id="designationPrevious" class="selectdesign filter-opt-1 fw-bolder">
                                            <option value="">--Select Filter Option--</option>
                                            <option value="business_channel_manager">Business Channel Manager</option>
                                            <option value="business_development_manager">Business Development Manager</option>
                                            <option value="business_mentor">Business Mentor</option>
                                            <option value="corporate_agency">Techno Enterprise</option>
                                            <option value="ca_travelagency">Travel Consultant</option>
                                            <option value="ca_customer">Customer</option>
                                            <!-- <option value="base_agency">Base Agency</option> -->
                                        </select>
                                    </div>
                                    <div class="name-filter no-space1 col-md-5 col-sm-12 " >
                                        <!-- <label>User ID & Name</label> -->
                                        <select id="user_id_namePrevious" class="selectdesign filter-opt-2-1 minimal fw-bolder" > 
                                            <option style="text-align:center;" value="">--Select Name First--</option>
                                        </select>
                                    </div>
                                    <!-- <form class=" col-md-4 app-search d-lg-block">
                                        <div class="position-relative">
                                            <span class="bx bx-search-alt"></span>
                                            <input type="text" class="form-control search control" placeholder="Search...">
                                        </div>
                                    </form> -->
                                    <span id="prevDiv" class="col-md-10 card border-2 border-black" style="border-radius: 10px; padding-top: 10px; margin-top: 10px">
                                        <div  id="download_icon " >
                                            <p class="font-size-14">Name: <span>------</span><span class="fw-bold font-size-10 ms-4 date-layout layout-2"><?php echo "$prevdate" ?></span></p>
                                            <p class="fs-5 fw-bolder mt-n2 icon">Rs. 0/- </p>
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
                                                    <tr>
                                                        
                                                        <th class="fw-bolder font-size-16">Date</th>
                                                        <!--<th class="fw-bolder font-size-16">Pkg ID</th> -->
                                                        <th class="fw-bolder font-size-16">Payout Details</th>
                                                        <th class="fw-bolder font-size-16">Amount</th>
                                                        <th class="fw-bolder font-size-16">TDS</th>
                                                        <th class="fw-bolder font-size-16">Total Payable</th>
                                                        <th class="fw-bolder font-size-16">Remark</th>
                                                    </tr>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                    <?php
                                                        $sql = "SELECT * FROM `product_payout` WHERE YEAR(created_date) = '".$prevDateYear."' AND MONTH(created_date) = '".$prevDateMonth."' ORDER BY `created_date` ASC";
                                                        $stmt = $conn -> prepare($sql);
                                                        $stmt -> execute();
                                                        $stmt -> setFetchMode(PDO::FETCH_ASSOC);
                                                        if( $stmt -> rowCount()>0 ){
                                                            foreach( ($stmt -> fetchALL()) as $key => $row ){

                                                                // date in proper formate
                                                                $dt = new DateTime($row['created_date']);
                                                                $dt = $dt->format('Y-m-d');

                                                                $ta_markup = $row['ta_markup'] ;
                                                                $no_of_adult = $row['no_of_adult'] ;
                                                                $no_of_child = $row['no_of_child'] ;
                                                                $customer_id = $row['cu_id'] ;

                                                                $stmt1 = $conn -> prepare(" SELECT name FROM package WHERE id = '".$row['package_id']."' ");
                                                                $stmt1 -> execute();
                                                                $pkgName = $stmt1 -> fetch();
                                                                $packageName = $pkgName['name'];

                                                                $stmt8 = $conn -> prepare(" SELECT firstname, lastname FROM ca_customer WHERE ca_customer_id = '".$customer_id."' ");
                                                                $stmt8 -> execute();
                                                                $cu_name = $stmt8 -> fetch();
                                                                $cuName = $cu_name['firstname'].' '.$cu_name['lastname'];


                                                                // ta message
                                                                $cu3_id = $row['cu3_id'];
                                                                $cu2_id = $row['cu2_id'];
                                                                $cu1_id = $row['cu1_id'];
                                                                $bdm_id = $row['bdm_id'];
                                                                $bch_id = $row['bch_id'];
                                                                $ta_id = $row['ta_id'];
                                                                $ta_mess = $row['ta_mess'];
                                                                $ta_amt = $row['ta_amt'];
                                                                $ta_status = $row['ta_status'];
                                                                $ta_tds = $ta_amt * $tdsPercentage;
                                                                $ta_total = $ta_amt - $ta_tds;

                                                                // te message
                                                                $te_id = $row['te_id'];
                                                                $te_mess = $row['te_mess'];
                                                                $te_amt = $row['te_amt'];
                                                                $te_status = $row['te_status'];
                                                                $te_tds = $te_amt * $tdsPercentage;
                                                                $te_total = $te_amt - $te_tds;

                                                                // bm message
                                                                $bm_id = $row['bm_id'];
                                                                $bm_mess = $row['bm_mess'];
                                                                $bm_amt = $row['bm_amt'];
                                                                $bm_status = $row['bm_status'];
                                                                $bm_tds = $bm_amt * $tdsPercentage;
                                                                $bm_total = $bm_amt - $bm_tds;

                                                                // bdm message
                                                                if($bdm_id){
                                                                    // $bdm_id = $row['bdm_id'];
                                                                    $bdm_mess = $row['bdm_mess'];
                                                                    $bdm_amt = $row['bdm_amt'];
                                                                    $bdm_status = $row['bdm_status'];
                                                                    $bdm_tds = $bdm_amt * $tdsPercentage;
                                                                    $bdm_total = $bdm_amt - $bdm_tds;
                                                                }

                                                                // bcm message
                                                                if($bch_id){
                                                                    // $bch_id = $row['bch_id'];
                                                                    $bch_mess = $row['bch_mess'];
                                                                    $bch_amt = $row['bch_amt'];
                                                                    $bch_status = $row['bch_status'];
                                                                    $bch_tds = $bch_amt * $tdsPercentage;
                                                                    $bch_total = $bch_amt - $bch_tds;
                                                                }

                                                                // cu1 message
                                                                if($cu1_id){
                                                                    // $cu1_id = $row['cu1_id'];
                                                                    $cu1_mess = $row['cu1_mess'];
                                                                    $cu1_amt = $row['cu1_amt'];
                                                                    $cu1_status = $row['cu1_status'];
                                                                    $cu1_tds = $cu1_amt * $tdsPercentage;
                                                                    $cu1_total = $cu1_amt - $cu1_tds;
                                                                }

                                                                // cu2 message
                                                                if($cu2_id){
                                                                    // $cu2_id = $row['cu2_id'];
                                                                    $cu2_mess = $row['cu2_mess'];
                                                                    $cu2_amt = $row['cu2_amt'];
                                                                    $cu2_status = $row['cu2_status'];
                                                                    $cu2_tds = $cu2_amt * $tdsPercentage;
                                                                    $cu2_total = $cu2_amt - $cu2_tds;
                                                                }

                                                                // cu3 message
                                                                if($cu3_id){
                                                                    // $cu3_id = $row['cu3_id'];
                                                                    $cu3_mess = $row['cu3_mess'];
                                                                    $cu3_amt = $row['cu3_amt'];
                                                                    $cu3_status = $row['cu3_status'];
                                                                    $cu3_tds = $cu3_amt * $tdsPercentage;
                                                                    $cu3_total = $cu3_amt - $cu3_tds;
                                                                }

                                                                if($cu3_id){
                                                                    echo'<tr>
                                                                            
                                                                            <td>'.$dt.'</td>
                                                                            <td>'.$cu3_mess.'<br/> on selling '.$packageName.' package to  Customer ->'.$cuName.'<br/> No of Adult -> '.$no_of_adult.'. No of child ->'. $no_of_child.'</td>
                                                                            <td>'.$cu3_amt.'</td>
                                                                            <td>'.$cu3_tds.'</td>
                                                                            <td>'.$cu3_total.'</td>';
                                                                            if($cu3_status == '1'){
                                                                                echo'<td><span class="badge badge-pill badge-soft-success font-size-10 fw-bold ms-4">Paid</span></td>';
                                                                            }else{
                                                                                echo'<td><span class="badge badge-pill badge-soft-warning font-size-10 fw-bold ms-4" data-bs-toggle="modal" data-bs-target=".bs-example-modal-center" onclick=\'paymentId("' .$row['id']. '","' .$row['cu3_id']. '","' .$row['cu3_mess']. '","' .$row['cu3_amt']. '","cu3_status","AllPayoutCaCu3")\'>Pending</span></td>';
                                                                            }
                                                                    echo'</tr>';
                                                                }

                                                                if($cu2_id){
                                                                    echo'<tr>
                                                                            
                                                                            <td>'.$dt.'</td>
                                                                            <td>'.$cu2_mess.'<br/> on selling '.$packageName.' package to  Customer ->'.$cuName.'<br/> No of Adult -> '.$no_of_adult.'. No of child ->'. $no_of_child.'</td>
                                                                            <td>'.$cu2_amt.'</td>
                                                                            <td>'.$cu2_tds.'</td>
                                                                            <td>'.$cu2_total.'</td>';
                                                                            if($cu2_status == '1'){
                                                                                echo'<td><span class="badge badge-pill badge-soft-success font-size-10 fw-bold ms-4">Paid</span></td>';
                                                                            }else{
                                                                                echo'<td><span class="badge badge-pill badge-soft-warning font-size-10 fw-bold ms-4" data-bs-toggle="modal" data-bs-target=".bs-example-modal-center" onclick=\'paymentId("' .$row['id']. '","' .$row['cu2_id']. '","' .$row['cu2_mess']. '","' .$row['cu2_amt']. '","cu2_status","AllPayoutCaCu2")\'>Pending</span></td>';
                                                                            }
                                                                    echo'</tr>';
                                                                }

                                                                if($cu1_id){
                                                                    echo'<tr>
                                                                            
                                                                            <td>'.$dt.'</td>
                                                                            <td>'.$cu1_mess.'<br/> on selling '.$packageName.' package to  Customer ->'.$cuName.'<br/> No of Adult -> '.$no_of_adult.'. No of child ->'. $no_of_child.'</td>
                                                                            <td>'.$cu1_amt.'</td>
                                                                            <td>'.$cu1_tds.'</td>
                                                                            <td>'.$cu1_total.'</td>';
                                                                            if($cu1_status == '1'){
                                                                                echo'<td><span class="badge badge-pill badge-soft-success font-size-10 fw-bold ms-4">Paid</span></td>';
                                                                            }else{
                                                                                echo'<td><span class="badge badge-pill badge-soft-warning font-size-10 fw-bold ms-4" data-bs-toggle="modal" data-bs-target=".bs-example-modal-center" onclick=\'paymentId("' .$row['id']. '","' .$row['cu1_id']. '","' .$row['cu1_mess']. '","' .$row['cu1_amt']. '","cu1_status","AllPayoutCaCu1")\'>Pending</span></td>';
                                                                            }
                                                                    echo'</tr>';
                                                                }

                                                                echo '<tr>
                                                                        
                                                                        <td>'.$dt.'</td>
                                                                        <td>'.$ta_mess.'<br/> on selling '.$packageName.' package to  Customer ->'.$cuName.'<br/> No of Adult -> '.$no_of_adult.'. No of child ->'. $no_of_child.'</td>
                                                                        <td>'.$ta_amt.'</td>
                                                                        <td>'.$ta_tds.'</td>
                                                                        <td>'.$ta_total.'</td>';
                                                                        if($ta_status == '1'){
                                                                            echo'<td><span class="badge badge-pill badge-soft-success font-size-10 fw-bold ms-4">Paid</span></td>';
                                                                        }else{
                                                                            echo'<td><span class="badge badge-pill badge-soft-warning font-size-10 fw-bold ms-4" data-bs-toggle="modal" data-bs-target=".bs-example-modal-center" onclick=\'paymentId("' .$row['id']. '","' .$row['ta_id']. '","' .$row['ta_mess']. '","' .$row['ta_amt']. '","ta_status","AllPayoutTa")\'>Pending</span></td>';
                                                                        }
                                                                echo'</tr>';
                                                                echo'<tr>
                                                                        
                                                                        <td><input id="product_id" type="hidden" value="'.$row['id'].'">'.$dt.'</td>
                                                                        <td>'.$te_mess.'<br/> on selling '.$packageName.' package to  Customer ->'.$cuName.'<br/> No of Adult -> '.$no_of_adult.'. No of child ->'. $no_of_child.'</td>
                                                                        <td>'.$te_amt.'</td>
                                                                        <td>'.$te_tds.'</td>
                                                                        <td>'.$te_total.'</td>';
                                                                        if($te_status == '1'){
                                                                            echo'<td><span class="badge badge-pill badge-soft-success font-size-10 fw-bold ms-4">Paid</span></td>';
                                                                        }else{
                                                                            echo'<td><span class="badge badge-pill badge-soft-warning font-size-10 fw-bold ms-4" data-bs-toggle="modal" data-bs-target=".bs-example-modal-center" onclick=\'paymentId("' .$row['id']. '","' .$row['te_id']. '","' .$row['te_mess']. '","' .$row['te_amt']. '","te_status","AllPayoutTe")\'>Pending</span></td>';
                                                                        }
                                                                echo'</tr>';
                                                                echo'<tr>
                                                                        
                                                                        <td>'.$dt.'</td>
                                                                        <td>'.$bm_mess.'<br/> on selling '.$packageName.' package to  Customer ->'.$cuName.'<br/> No of Adult -> '.$no_of_adult.'. No of child ->'. $no_of_child.'</td>
                                                                        <td>'.$bm_amt.'</td>
                                                                        <td>'.$bm_tds.'</td>
                                                                        <td>'.$bm_total.'</td>';
                                                                        if($bm_status == '1'){
                                                                            echo'<td><span class="badge badge-pill badge-soft-success font-size-10 fw-bold ms-4">Paid</span></td>';
                                                                        }else{
                                                                            echo'<td><span class="badge badge-pill badge-soft-warning font-size-10 fw-bold ms-4" data-bs-toggle="modal" data-bs-target=".bs-example-modal-center" onclick=\'paymentId("' .$row['id']. '","' .$row['bm_id']. '","' .$row['bm_mess']. '","' .$row['bm_amt']. '","bm_status","AllPayoutBm")\'>Pending</span></td>';
                                                                        }
                                                                echo'</tr>';

                                                                if($row['bdm_id']){
                                                                    echo'<tr>
                                                                            
                                                                            <td>'.$dt.'</td>
                                                                            <td>'.$bdm_mess.'<br/> on selling '.$packageName.' package to  Customer ->'.$cuName.'<br/> No of Adult -> '.$no_of_adult.'. No of child ->'. $no_of_child.'</td>
                                                                            <td>'.$bdm_amt.'</td>
                                                                            <td>'.$bdm_tds.'</td>
                                                                            <td>'.$bdm_total.'</td>';
                                                                            if($bdm_status == '1'){
                                                                                echo'<td><span class="badge badge-pill badge-soft-success font-size-10 fw-bold ms-4">Paid</span></td>';
                                                                            }else{
                                                                                echo'<td><span class="badge badge-pill badge-soft-warning font-size-10 fw-bold ms-4" data-bs-toggle="modal" data-bs-target=".bs-example-modal-center" onclick=\'paymentId("' .$row['id']. '","' .$row['bdm_id']. '","' .$row['bdm_mess']. '","' .$row['bdm_amt']. '","bdm_status","AllPayoutBdm")\'>Pending</span></td>';
                                                                            }
                                                                    echo'</tr>';
                                                                }

                                                                if($row['bch_id']){
                                                                    echo'<tr>
                                                                            
                                                                            <td>'.$dt.'</td>
                                                                            <td>'.$bch_mess.'<br/> on selling '.$packageName.' package to  Customer ->'.$cuName.'<br/> No of Adult -> '.$no_of_adult.'. No of child ->'. $no_of_child.'</td>
                                                                            <td>'.$bch_amt.'</td>
                                                                            <td>'.$bch_tds.'</td>
                                                                            <td>'.$bch_total.'</td>';
                                                                            if($bch_status == '1'){
                                                                                echo'<td><span class="badge badge-pill badge-soft-success font-size-10 fw-bold ms-4">Paid</span></td>';
                                                                            }else{
                                                                                echo'<td><span class="badge badge-pill badge-soft-warning font-size-10 fw-bold ms-4" data-bs-toggle="modal" data-bs-target=".bs-example-modal-center" onclick=\'paymentId("' .$row['id']. '","' .$row['bch_id']. '","' .$row['bch_mess']. '","' .$row['bch_amt']. '","bch_status","AllPayoutBch")\'>Pending</span></td>';
                                                                            }
                                                                    echo'</tr>';
                                                                }
                                                                
                                                                
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
        <div id="nextPayout" class="modal fade" tabindex="-1" aria-labelledby="#exampleModalFullscreenLabel" aria-hidden="true" data-bs-backdrop="static"  data-bs-keyboard="false" style=" border-radius: 20px !important;">
            <div class="modal-dialog modal-fullscreen" style="width: 80%; margin: auto; margin-top: 30px; margin-bottom: 30px; height: 90vh;" >
                <div class="modal-content modal-radius">
                    <div class="modal-header">
                        <h5 class="modal-title head fw-bold" id="exampleModalFullscreenLabel">Next Payout</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row d-flex justify-content-evenly">   
                            <div class="col-lg-4 col-md-4 col-sm-7 card" style="border: 2px solid black; border-radius: 10px;">
                                <div class="page-title-box p-3">
                                    <p class="head pt-3">Next Payout<span class="fw-bold font-size-12 date-layout layout-1"><?php echo "$date" ?></span></p>
                                    <div class="d-flex">
                                        <?php 
                                            $nextPayout = $conn -> prepare("SELECT SUM(ta_markup+ta_amt+te_amt+bm_amt+bdm_amt+bch_amt+cu1_amt+cu2_amt+cu3_amt) as nextPayout FROM product_payout WHERE YEAR(created_date) = '".$nextDateYear."' AND MONTH(created_date) = '".$nextDateMonth."' ");
                                            $nextPayout -> execute();
                                            $nextPayout -> setFetchMode(PDO::FETCH_ASSOC);
                                            if($nextPayout -> rowCount()>0){
                                                foreach(($nextPayout -> fetchAll()) as $key => $row2){
                                                    $nextPayoutTotal = $row2['nextPayout'];
                                                    $nextPayoutTDS = $nextPayoutTotal * $tdsPercentage;
                                                    $TotalNextPayout = $nextPayoutTotal - $nextPayoutTDS;
                                                    $truncatedNextAmount = floor($TotalNextPayout * 100) / 100;
                                                    echo'<p class="fs-5 font fw-bolder mt-n2 icon">Rs.' .number_format($truncatedNextAmount,2). '/- </p>
                                                    <span class="badge badge-pill badge-soft-success font-size-10 fw-bold status1" style="height: 15px !important; margin-top: 16px;" readonly>Paid</span>';
                                                }
                                            }
                                        ?>
                                        
                                        <a href="forms/product_payout/download_exel_product_payout?payoutYear=<?php echo $prevDateYear; ?>&payoutMonth=<?php echo $prevDateMonth; ?>&payoutmessage=NextPayout">
                                            <i class="bx bx-download download-icon status1" style="font-size: 20px; color: black; margin-left: 20%;"></i>
                                        </a>
                                    </div>
                                    
                                    
                                </div>
                            </div>
                            <div class="col-lg-7 col-md-7 col-sm-7">
                                <!-- <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                    <h2 class="mb-sm-0 fw-bolder ps-4">All Payouts</h2>
                                </div> -->
                                <div class="row filter-options filter">
                                    <div class="designation-filter no-space1 col-lg-5 col-md-5 col-sm-12">
                                        <!-- <label> Filter Payouts</label> -->
                                        <select id="designationNext" class="selectdesign filter-opt-1 fw-bolder">
                                            <option value="">--Select Filter Option--</option>
                                            <option value="business_channel_manager">Business Channel Manager</option>
                                            <option value="business_development_manager">Business Development Manager</option>
                                            <option value="business_mentor">Business Mentor</option>
                                            <option value="corporate_agency">Techno Enterprise</option>
                                            <option value="ca_travelagency">Travel Consultant</option>
                                            <option value="ca_customer">Customer</option>
                                            <!-- <option value="base_agency">Base Agency</option> -->
                                        </select>
                                    </div>
                                    <div class="name-filter no-space1 col-md-5 col-sm-12" >
                                        <!-- <label>User ID & Name</label> -->
                                        <select id="user_id_nameNext" class="selectdesign filter-opt-2-1 minimal fw-bolder" > 
                                            <option style="text-align:center;" value="">--Select Name First--</option>
                                        </select>
                                    </div>
                                    <!-- <form class=" col-md-4 app-search d-lg-block">
                                        <div class="position-relative">
                                            <span class="bx bx-search-alt"></span>
                                            <input type="text" class="form-control search control" placeholder="Search...">
                                        </div>
                                    </form> -->
                                    <span id="nextDiv" class="col-md-10 card border-2 border-black" style="border-radius: 10px; padding-top: 10px; margin-top: 10px">
                                        <div  id="download_icon " >
                                            <p class="font-size-14">Name: <span>------</span><span class="fw-bold font-size-10 ms-4 date-layout layout-2"><?php echo "$prevdate" ?></span></p>
                                            <p class="fs-5 fw-bolder mt-n2 icon">Rs. 0/- </p>
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
                                                    <tr>
                                                        
                                                        <th class="fw-bolder font-size-16">Date</th>
                                                        <!-- <th class="fw-bolder font-size-16">Pkg ID</th> -->
                                                        <th class="fw-bolder font-size-16">Payout Details</th>
                                                        <th class="fw-bolder font-size-16">Amount</th>
                                                        <th class="fw-bolder font-size-16">TDS</th>
                                                        <th class="fw-bolder font-size-16">Total Payable</th>
                                                        <th class="fw-bolder font-size-16">Remark</th>
                                                    </tr>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                 <?php
                                                    $sql = "SELECT * FROM `product_payout` WHERE YEAR(created_date) = '".$nextDateYear."' AND MONTH(created_date) = '".$nextDateMonth."' ORDER BY `created_date` ASC ";
                                                    $stmt = $conn -> prepare($sql);
                                                        $stmt -> execute();
                                                        $stmt -> setFetchMode(PDO::FETCH_ASSOC);
                                                        if( $stmt -> rowCount()>0 ){
                                                            foreach( ($stmt -> fetchALL()) as $key => $row ){

                                                                // date in proper formate
                                                                $dt = new DateTime($row['created_date']);
                                                                $dt = $dt->format('Y-m-d');

                                                                $ta_markup = $row['ta_markup'] ;
                                                                $no_of_adult = $row['no_of_adult'] ;
                                                                $no_of_child = $row['no_of_child'] ;
                                                                $customer_id = $row['cu_id'] ;

                                                                $stmt1 = $conn -> prepare(" SELECT name FROM package WHERE id = '".$row['package_id']."' ");
                                                                $stmt1 -> execute();
                                                                $pkgName = $stmt1 -> fetch();
                                                                $packageName = $pkgName['name'];

                                                                $stmt8 = $conn -> prepare(" SELECT firstname, lastname FROM ca_customer WHERE ca_customer_id = '".$customer_id."' ");
                                                                $stmt8 -> execute();
                                                                $cu_name = $stmt8 -> fetch();
                                                                $cuName = $cu_name['firstname'].' '.$cu_name['lastname'];


                                                                // ta message
                                                                $cu3_id = $row['cu3_id'];
                                                                $cu2_id = $row['cu2_id'];
                                                                $cu1_id = $row['cu1_id'];
                                                                $bdm_id = $row['bdm_id'];
                                                                $bch_id = $row['bch_id'];
                                                                $ta_id = $row['ta_id'];
                                                                $ta_mess = $row['ta_mess'];
                                                                $ta_amt = $row['ta_amt'];
                                                                $ta_status = $row['ta_status'];
                                                                $ta_tds = $ta_amt * $tdsPercentage;
                                                                $ta_total = $ta_amt - $ta_tds;

                                                                // te message
                                                                $te_id = $row['te_id'];
                                                                $te_mess = $row['te_mess'];
                                                                $te_amt = $row['te_amt'];
                                                                $te_status = $row['te_status'];
                                                                $te_tds = $te_amt * $tdsPercentage;
                                                                $te_total = $te_amt - $te_tds;

                                                                // bm message
                                                                $bm_id = $row['bm_id'];
                                                                $bm_mess = $row['bm_mess'];
                                                                $bm_amt = $row['bm_amt'];
                                                                $bm_status = $row['bm_status'];
                                                                $bm_tds = $bm_amt * $tdsPercentage;
                                                                $bm_total = $bm_amt - $bm_tds;

                                                                // bdm message
                                                                if($bdm_id){
                                                                    // $bdm_id = $row['bdm_id'];
                                                                    $bdm_mess = $row['bdm_mess'];
                                                                    $bdm_amt = $row['bdm_amt'];
                                                                    $bdm_status = $row['bdm_status'];
                                                                    $bdm_tds = $bdm_amt * $tdsPercentage;
                                                                    $bdm_total = $bdm_amt - $bdm_tds;
                                                                }

                                                                // bcm message
                                                                if($bch_id){
                                                                    // $bch_id = $row['bch_id'];
                                                                    $bch_mess = $row['bch_mess'];
                                                                    $bch_amt = $row['bch_amt'];
                                                                    $bch_status = $row['bch_status'];
                                                                    $bch_tds = $bch_amt * $tdsPercentage;
                                                                    $bch_total = $bch_amt - $bch_tds;
                                                                }

                                                                // cu1 message
                                                                if($cu1_id){
                                                                    // $cu1_id = $row['cu1_id'];
                                                                    $cu1_mess = $row['cu1_mess'];
                                                                    $cu1_amt = $row['cu1_amt'];
                                                                    $cu1_status = $row['cu1_status'];
                                                                    $cu1_tds = $cu1_amt * $tdsPercentage;
                                                                    $cu1_total = $cu1_amt - $cu1_tds;
                                                                }

                                                                // cu2 message
                                                                if($cu2_id){
                                                                    // $cu2_id = $row['cu2_id'];
                                                                    $cu2_mess = $row['cu2_mess'];
                                                                    $cu2_amt = $row['cu2_amt'];
                                                                    $cu2_status = $row['cu2_status'];
                                                                    $cu2_tds = $cu2_amt * $tdsPercentage;
                                                                    $cu2_total = $cu2_amt - $cu2_tds;
                                                                }

                                                                // cu3 message
                                                                if($cu3_id){
                                                                    // $cu3_id = $row['cu3_id'];
                                                                    $cu3_mess = $row['cu3_mess'];
                                                                    $cu3_amt = $row['cu3_amt'];
                                                                    $cu3_status = $row['cu3_status'];
                                                                    $cu3_tds = $cu3_amt * $tdsPercentage;
                                                                    $cu3_total = $cu3_amt - $cu3_tds;
                                                                }

                                                                if($cu3_id){
                                                                    echo'<tr>
                                                                            
                                                                            <td>'.$dt.'</td>
                                                                            <td>'.$cu3_mess.'<br/> on selling '.$packageName.' package to  Customer ->'.$cuName.'<br/> No of Adult -> '.$no_of_adult.'. No of child ->'. $no_of_child.'</td>
                                                                            <td>'.$cu3_amt.'</td>
                                                                            <td>'.$cu3_tds.'</td>
                                                                            <td>'.$cu3_total.'</td>';
                                                                            if($cu3_status == '1'){
                                                                                echo'<td><span class="badge badge-pill badge-soft-success font-size-10 fw-bold ms-4">Paid</span></td>';
                                                                            }else{
                                                                                echo'<td><span class="badge badge-pill badge-soft-warning font-size-10 fw-bold ms-4" data-bs-toggle="modal" data-bs-target=".bs-example-modal-center" onclick=\'paymentId("' .$row['id']. '","' .$row['cu3_id']. '","' .$row['cu3_mess']. '","' .$row['cu3_amt']. '","cu3_status","AllPayoutCaCu3")\'>Pending</span></td>';
                                                                            }
                                                                    echo'</tr>';
                                                                }

                                                                if($cu2_id){
                                                                    echo'<tr>
                                                                            
                                                                            <td>'.$dt.'</td>
                                                                            <td>'.$cu2_mess.'<br/> on selling '.$packageName.' package to  Customer ->'.$cuName.'<br/> No of Adult -> '.$no_of_adult.'. No of child ->'. $no_of_child.'</td>
                                                                            <td>'.$cu2_amt.'</td>
                                                                            <td>'.$cu2_tds.'</td>
                                                                            <td>'.$cu2_total.'</td>';
                                                                            if($cu2_status == '1'){
                                                                                echo'<td><span class="badge badge-pill badge-soft-success font-size-10 fw-bold ms-4">Paid</span></td>';
                                                                            }else{
                                                                                echo'<td><span class="badge badge-pill badge-soft-warning font-size-10 fw-bold ms-4" data-bs-toggle="modal" data-bs-target=".bs-example-modal-center" onclick=\'paymentId("' .$row['id']. '","' .$row['cu2_id']. '","' .$row['cu2_mess']. '","' .$row['cu2_amt']. '","cu2_status","AllPayoutCaCu2")\'>Pending</span></td>';
                                                                            }
                                                                    echo'</tr>';
                                                                }

                                                                if($cu1_id){
                                                                    echo'<tr>
                                                                            
                                                                            <td>'.$dt.'</td>
                                                                            <td>'.$cu1_mess.'<br/> on selling '.$packageName.' package to  Customer ->'.$cuName.'<br/> No of Adult -> '.$no_of_adult.'. No of child ->'. $no_of_child.'</td>
                                                                            <td>'.$cu1_amt.'</td>
                                                                            <td>'.$cu1_tds.'</td>
                                                                            <td>'.$cu1_total.'</td>';
                                                                            if($cu1_status == '1'){
                                                                                echo'<td><span class="badge badge-pill badge-soft-success font-size-10 fw-bold ms-4">Paid</span></td>';
                                                                            }else{
                                                                                echo'<td><span class="badge badge-pill badge-soft-warning font-size-10 fw-bold ms-4" data-bs-toggle="modal" data-bs-target=".bs-example-modal-center" onclick=\'paymentId("' .$row['id']. '","' .$row['cu1_id']. '","' .$row['cu1_mess']. '","' .$row['cu1_amt']. '","cu1_status","AllPayoutCaCu1")\'>Pending</span></td>';
                                                                            }
                                                                    echo'</tr>';
                                                                }

                                                                echo '<tr>
                                                                        
                                                                        <td>'.$dt.'</td>
                                                                        <td>'.$ta_mess.'<br/> on selling '.$packageName.' package to  Customer ->'.$cuName.'<br/> No of Adult -> '.$no_of_adult.'. No of child ->'. $no_of_child.'</td>
                                                                        <td>'.$ta_amt.'</td>
                                                                        <td>'.$ta_tds.'</td>
                                                                        <td>'.$ta_total.'</td>';
                                                                        if($ta_status == '1'){
                                                                            echo'<td><span class="badge badge-pill badge-soft-success font-size-10 fw-bold ms-4">Paid</span></td>';
                                                                        }else{
                                                                            echo'<td><span class="badge badge-pill badge-soft-warning font-size-10 fw-bold ms-4" data-bs-toggle="modal" data-bs-target=".bs-example-modal-center" onclick=\'paymentId("' .$row['id']. '","' .$row['ta_id']. '","' .$row['ta_mess']. '","' .$row['ta_amt']. '","ta_status","AllPayoutTa")\'>Pending</span></td>';
                                                                        }
                                                                echo'</tr>';
                                                                echo'<tr>
                                                                        
                                                                        <td>'.$dt.'</td>
                                                                        <td>'.$te_mess.'<br/> on selling '.$packageName.' package to  Customer ->'.$cuName.'<br/> No of Adult -> '.$no_of_adult.'. No of child ->'. $no_of_child.'</td>
                                                                        <td>'.$te_amt.'</td>
                                                                        <td>'.$te_tds.'</td>
                                                                        <td>'.$te_total.'</td>';
                                                                        if($te_status == '1'){
                                                                            echo'<td><span class="badge badge-pill badge-soft-success font-size-10 fw-bold ms-4">Paid</span></td>';
                                                                        }else{
                                                                            echo'<td><span class="badge badge-pill badge-soft-warning font-size-10 fw-bold ms-4" data-bs-toggle="modal" data-bs-target=".bs-example-modal-center" onclick=\'paymentId("' .$row['id']. '","' .$row['te_id']. '","' .$row['te_mess']. '","' .$row['te_amt']. '","te_status","AllPayoutTe")\'>Pending</span></td>';
                                                                        }
                                                                echo'</tr>';
                                                                echo'<tr>
                                                                        
                                                                        <td>'.$dt.'</td>
                                                                        <td>'.$bm_mess.'<br/> on selling '.$packageName.' package to  Customer ->'.$cuName.'<br/> No of Adult -> '.$no_of_adult.'. No of child ->'. $no_of_child.'</td>
                                                                        <td>'.$bm_amt.'</td>
                                                                        <td>'.$bm_tds.'</td>
                                                                        <td>'.$bm_total.'</td>';
                                                                        if($bm_status == '1'){
                                                                            echo'<td><span class="badge badge-pill badge-soft-success font-size-10 fw-bold ms-4">Paid</span></td>';
                                                                        }else{
                                                                            echo'<td><span class="badge badge-pill badge-soft-warning font-size-10 fw-bold ms-4" data-bs-toggle="modal" data-bs-target=".bs-example-modal-center" onclick=\'paymentId("' .$row['id']. '","' .$row['bm_id']. '","' .$row['bm_mess']. '","' .$row['bm_amt']. '","bm_status","AllPayoutBm")\'>Pending</span></td>';
                                                                        }
                                                                echo'</tr>';

                                                                if($row['bdm_id']){
                                                                    echo'<tr>
                                                                            
                                                                            <td>'.$dt.'</td>
                                                                            <td>'.$bdm_mess.'<br/> on selling '.$packageName.' package to  Customer ->'.$cuName.'<br/> No of Adult -> '.$no_of_adult.'. No of child ->'. $no_of_child.'</td>
                                                                            <td>'.$bdm_amt.'</td>
                                                                            <td>'.$bdm_tds.'</td>
                                                                            <td>'.$bdm_total.'</td>';
                                                                            if($bdm_status == '1'){
                                                                                echo'<td><span class="badge badge-pill badge-soft-success font-size-10 fw-bold ms-4">Paid</span></td>';
                                                                            }else{
                                                                                echo'<td><span class="badge badge-pill badge-soft-warning font-size-10 fw-bold ms-4" data-bs-toggle="modal" data-bs-target=".bs-example-modal-center" onclick=\'paymentId("' .$row['id']. '","' .$row['bdm_id']. '","' .$row['bdm_mess']. '","' .$row['bdm_amt']. '","bdm_status","AllPayoutBdm")\'>Pending</span></td>';
                                                                            }
                                                                    echo'</tr>';
                                                                }

                                                                if($row['bch_id']){
                                                                    echo'<tr>
                                                                            
                                                                            <td>'.$dt.'</td>
                                                                            <td>'.$bch_mess.'<br/> on selling '.$packageName.' package to  Customer ->'.$cuName.'<br/> No of Adult -> '.$no_of_adult.'. No of child ->'. $no_of_child.'</td>
                                                                            <td>'.$bch_amt.'</td>
                                                                            <td>'.$bch_tds.'</td>
                                                                            <td>'.$bch_total.'</td>';
                                                                            if($bch_status == '1'){
                                                                                echo'<td><span class="badge badge-pill badge-soft-success font-size-10 fw-bold ms-4">Paid</span></td>';
                                                                            }else{
                                                                                echo'<td><span class="badge badge-pill badge-soft-warning font-size-10 fw-bold ms-4" data-bs-toggle="modal" data-bs-target=".bs-example-modal-center" onclick=\'paymentId("' .$row['id']. '","' .$row['bch_id']. '","' .$row['bch_mess']. '","' .$row['bch_amt']. '","bch_status","AllPayoutBch")\'>Pending</span></td>';
                                                                            }
                                                                    echo'</tr>';
                                                                }
                                                                
                                                                
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
        <div id="totalPayout" class="modal fade" tabindex="-1" aria-labelledby="#exampleModalFullscreenLabel" aria-hidden="true" data-bs-backdrop="static"  data-bs-keyboard="false" style=" border-radius: 20px !important;">
            <div class="modal-dialog modal-fullscreen" style="width: 80%; margin: auto; margin-top: 30px; margin-bottom: 30px; height: 90vh;" >
                <div class="modal-content modal-radius">
                    <div class="modal-header">
                        <h5 class="modal-title head fw-bold" id="exampleModalFullscreenLabel">Total Payout</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row d-flex justify-content-evenly">   
                            <div class="col-lg-4 col-md-4 col-sm-7 card" style="border: 2px solid black; border-radius: 10px;">
                                <div class="page-title-box p-3">
                                    <p class="head pt-3">Total Payout<span class="fw-bold font-size-12 date-layout layout-1"><?php echo "$date" ?></span></p>
                                    <div class="d-flex">
                                        <?php 
                                            // $totalPayout = "SELECT SUM(
                                            //                             CASE WHEN bc_status = '1' THEN bc_amt ELSE 0 END +
                                            //                             CASE WHEN ca_status = '1' THEN ca_amt ELSE 0 END +
                                            //                             CASE WHEN ca_ta_status = '1' THEN ca_ta_amt ELSE 0 END +
                                            //                             CASE WHEN ca_cu1_status = '1' THEN ca_cu1_amt ELSE 0 END +
                                            //                             CASE WHEN ca_cu2_status = '1' THEN ca_cu2_amt ELSE 0 END +
                                            //                             CASE WHEN ca_cu3_status = '1' THEN ca_cu3_amt ELSE 0 END +
                                            //                             CASE WHEN ca_ta_status = '1' THEN ta_markup ELSE 0 END
                                            //                         ) as total_payable 
                                            //                     FROM product_payout";
                                            $totalPayout = "SELECT SUM(ta_markup+ta_amt+te_amt+bm_amt+bdm_amt+bch_amt+cu1_amt+cu2_amt+cu3_amt) as total_payable FROM product_payout";
                                            $Payout = $conn -> prepare($totalPayout);
                                            $Payout -> execute();
                                            $Payout -> setFetchMode(PDO::FETCH_ASSOC);
                                            if($Payout->rowCount()>0){
                                                foreach(($Payout->fetchAll()) as $key => $row){
                                                    $total_payable = $row["total_payable"] ?? '0';
                                                    $totalPayoutTDS = $total_payable * $tdsPercentage;
                                                    $TotalPayout = $total_payable - $totalPayoutTDS;
                                                    $truncatedTotalAmount = floor($TotalPayout * 100) / 100;
                                                    echo'
                                                    <p class="fs-5 font fw-bolder mt-n2 icon">Rs.'.number_format($truncatedTotalAmount,2).'/- </p>
                                                    <span class="badge badge-pill badge-soft-success font-size-10 fw-bold status1" style="height: 15px !important; margin-top: 16px;" readonly>Paid</span>
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
                                    <div class="designation-filter no-space1 col-lg-5 col-md-5 col-sm-12">
                                        <!-- <label> Filter Payouts</label> -->
                                        <select id="designationTotal" class="selectdesign filter-opt-1 fw-bolder">
                                            <option value="">--Select Filter Option--</option>
                                            <option value="business_channel_manager">Business Channel Manager</option>
                                            <option value="business_development_manager">Business Development Manager</option>
                                            <option value="business_mentor">Business Mentor</option>
                                            <option value="corporate_agency">Techno Enterprise</option>
                                            <option value="ca_travelagency">Travel Consultant</option>
                                            <option value="ca_customer">Customer</option>
                                            <!-- <option value="base_agency">Base Agency</option> -->
                                        </select>
                                    </div>
                                    <div class="name-filter no-space1 col-md-5 col-sm-12" >
                                        <!-- <label>User ID & Name</label> -->
                                        <select id="user_id_nameTotal" class="selectdesign filter-opt-2-1 minimal fw-bolder" > 
                                            <option style="text-align:center;" value="">--Select Name First--</option>
                                        </select>
                                    </div>
                                    <!-- <form class=" col-md-4 app-search d-lg-block">
                                        <div class="position-relative">
                                            <span class="bx bx-search-alt"></span>
                                            <input type="text" class="form-control search control" placeholder="Search...">
                                        </div>
                                    </form> -->
                                    
                                    <span id="totalDiv" class="col-md-10 card border-2 border-black" style="border-radius: 10px; padding-top: 10px; margin-top: 10px">
                                        <div  id="download_icon " >
                                            <p class="font-size-14">Name: <span>------</span><span class="fw-bold font-size-10 ms-4 date-layout layout-2"><?php echo "$date" ?></span></p>
                                            <p class="fs-5 fw-bolder mt-n2 icon">Rs. 0/- </p>
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
                                         <!-- <table class="table table-hover" id="total_payout_table"> -->
                                        <table class="table table-hover" id="total_payout_table">
                                            <thead>
                                                <tr>
                                                    <tr>
                                                        
                                                        <th class="fw-bolder font-size-16">Date</th>
                                                        <!--<th class="fw-bolder font-size-16">Pkg ID</th> -->
                                                        <th class="fw-bolder font-size-16">Payout Details</th>
                                                        <th class="fw-bolder font-size-16">Amount</th>
                                                        <th class="fw-bolder font-size-16">TDS</th>
                                                        <th class="fw-bolder font-size-16">Total Payable</th>
                                                        <th class="fw-bolder font-size-16">Remark</th>
                                                    </tr>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                    $sql = "SELECT * FROM `product_payout`  ORDER BY `created_date` ASC";
                                                    $stmt = $conn -> prepare($sql);
                                                    $stmt -> execute();
                                                    $stmt -> setFetchMode(PDO::FETCH_ASSOC);
                                                    if( $stmt -> rowCount()>0 ){
                                                        foreach( ($stmt -> fetchALL()) as $key => $row ){

                                                            // date in proper formate
                                                            $dt = new DateTime($row['created_date']);
                                                            $dt = $dt->format('Y-m-d');

                                                            $ta_markup = $row['ta_markup'] ;
                                                            $no_of_adult = $row['no_of_adult'] ;
                                                            $no_of_child = $row['no_of_child'] ;
                                                            $customer_id = $row['cu_id'] ;

                                                            $stmt1 = $conn -> prepare(" SELECT name FROM package WHERE id = '".$row['package_id']."' ");
                                                            $stmt1 -> execute();
                                                            $pkgName = $stmt1 -> fetch();
                                                            $packageName = $pkgName['name'];

                                                            $stmt8 = $conn -> prepare(" SELECT firstname, lastname FROM ca_customer WHERE ca_customer_id = '".$customer_id."' ");
                                                            $stmt8 -> execute();
                                                            $cu_name = $stmt8 -> fetch();
                                                            $cuName = $cu_name['firstname'].' '.$cu_name['lastname'];


                                                            // ta message
                                                            $cu3_id = $row['cu3_id'];
                                                            $cu2_id = $row['cu2_id'];
                                                            $cu1_id = $row['cu1_id'];
                                                            $bdm_id = $row['bdm_id'];
                                                            $bch_id = $row['bch_id'];
                                                            $ta_id = $row['ta_id'];
                                                            $ta_mess = $row['ta_mess'];
                                                            $ta_amt = $row['ta_amt'];
                                                            $ta_status = $row['ta_status'];
                                                            $ta_tds = $ta_amt * $tdsPercentage;
                                                            $ta_total = $ta_amt - $ta_tds;

                                                            // te message
                                                            $te_id = $row['te_id'];
                                                            $te_mess = $row['te_mess'];
                                                            $te_amt = $row['te_amt'];
                                                            $te_status = $row['te_status'];
                                                            $te_tds = $te_amt * $tdsPercentage;
                                                            $te_total = $te_amt - $te_tds;

                                                            // bm message
                                                            $bm_id = $row['bm_id'];
                                                            $bm_mess = $row['bm_mess'];
                                                            $bm_amt = $row['bm_amt'];
                                                            $bm_status = $row['bm_status'];
                                                            $bm_tds = $bm_amt * $tdsPercentage;
                                                            $bm_total = $bm_amt - $bm_tds;

                                                            // bdm message
                                                            if($bdm_id){
                                                                // $bdm_id = $row['bdm_id'];
                                                                $bdm_mess = $row['bdm_mess'];
                                                                $bdm_amt = $row['bdm_amt'];
                                                                $bdm_status = $row['bdm_status'];
                                                                $bdm_tds = $bdm_amt * $tdsPercentage;
                                                                $bdm_total = $bdm_amt - $bdm_tds;
                                                            }

                                                            // bcm message
                                                            if($bch_id){
                                                                // $bch_id = $row['bch_id'];
                                                                $bch_mess = $row['bch_mess'];
                                                                $bch_amt = $row['bch_amt'];
                                                                $bch_status = $row['bch_status'];
                                                                $bch_tds = $bch_amt * $tdsPercentage;
                                                                $bch_total = $bch_amt - $bch_tds;
                                                            }

                                                            // cu1 message
                                                            if($cu1_id){
                                                                // $cu1_id = $row['cu1_id'];
                                                                $cu1_mess = $row['cu1_mess'];
                                                                $cu1_amt = $row['cu1_amt'];
                                                                $cu1_status = $row['cu1_status'];
                                                                $cu1_tds = $cu1_amt * $tdsPercentage;
                                                                $cu1_total = $cu1_amt - $cu1_tds;
                                                            }

                                                            // cu2 message
                                                            if($cu2_id){
                                                                // $cu2_id = $row['cu2_id'];
                                                                $cu2_mess = $row['cu2_mess'];
                                                                $cu2_amt = $row['cu2_amt'];
                                                                $cu2_status = $row['cu2_status'];
                                                                $cu2_tds = $cu2_amt * $tdsPercentage;
                                                                $cu2_total = $cu2_amt - $cu2_tds;
                                                            }

                                                            // cu3 message
                                                            if($cu3_id){
                                                                // $cu3_id = $row['cu3_id'];
                                                                $cu3_mess = $row['cu3_mess'];
                                                                $cu3_amt = $row['cu3_amt'];
                                                                $cu3_status = $row['cu3_status'];
                                                                $cu3_tds = $cu3_amt * $tdsPercentage;
                                                                $cu3_total = $cu3_amt - $cu3_tds;
                                                            }

                                                            if($cu3_id){
                                                                echo'<tr>
                                                                        
                                                                        <td>'.$dt.'</td>
                                                                        <td>'.$cu3_mess.'<br/> on selling '.$packageName.' package to  Customer ->'.$cuName.'<br/> No of Adult -> '.$no_of_adult.'. No of child ->'. $no_of_child.'</td>
                                                                        <td>'.$cu3_amt.'</td>
                                                                        <td>'.$cu3_tds.'</td>
                                                                        <td>'.$cu3_total.'</td>';
                                                                        if($cu3_status == '1'){
                                                                            echo'<td><span class="badge badge-pill badge-soft-success font-size-10 fw-bold ms-4">Paid</span></td>';
                                                                        }else{
                                                                            echo'<td><span class="badge badge-pill badge-soft-warning font-size-10 fw-bold ms-4" data-bs-toggle="modal" data-bs-target=".bs-example-modal-center" onclick=\'paymentId("' .$row['id']. '","' .$row['cu3_id']. '","' .$row['cu3_mess']. '","' .$row['cu3_amt']. '","cu3_status","AllPayoutCaCu3")\'>Pending</span></td>';
                                                                        }
                                                                echo'</tr>';
                                                            }

                                                            if($cu2_id){
                                                                echo'<tr>
                                                                        
                                                                        <td>'.$dt.'</td>
                                                                        <td>'.$cu2_mess.'<br/> on selling '.$packageName.' package to  Customer ->'.$cuName.'<br/> No of Adult -> '.$no_of_adult.'. No of child ->'. $no_of_child.'</td>
                                                                        <td>'.$cu2_amt.'</td>
                                                                        <td>'.$cu2_tds.'</td>
                                                                        <td>'.$cu2_total.'</td>';
                                                                        if($cu2_status == '1'){
                                                                            echo'<td><span class="badge badge-pill badge-soft-success font-size-10 fw-bold ms-4">Paid</span></td>';
                                                                        }else{
                                                                            echo'<td><span class="badge badge-pill badge-soft-warning font-size-10 fw-bold ms-4" data-bs-toggle="modal" data-bs-target=".bs-example-modal-center" onclick=\'paymentId("' .$row['id']. '","' .$row['cu2_id']. '","' .$row['cu2_mess']. '","' .$row['cu2_amt']. '","cu2_status","AllPayoutCaCu2")\'>Pending</span></td>';
                                                                        }
                                                                echo'</tr>';
                                                            }

                                                            if($cu1_id){
                                                                echo'<tr>
                                                                        
                                                                        <td>'.$dt.'</td>
                                                                        <td>'.$cu1_mess.'<br/> on selling '.$packageName.' package to  Customer ->'.$cuName.'<br/> No of Adult -> '.$no_of_adult.'. No of child ->'. $no_of_child.'</td>
                                                                        <td>'.$cu1_amt.'</td>
                                                                        <td>'.$cu1_tds.'</td>
                                                                        <td>'.$cu1_total.'</td>';
                                                                        if($cu1_status == '1'){
                                                                            echo'<td><span class="badge badge-pill badge-soft-success font-size-10 fw-bold ms-4">Paid</span></td>';
                                                                        }else{
                                                                            echo'<td><span class="badge badge-pill badge-soft-warning font-size-10 fw-bold ms-4" data-bs-toggle="modal" data-bs-target=".bs-example-modal-center" onclick=\'paymentId("' .$row['id']. '","' .$row['cu1_id']. '","' .$row['cu1_mess']. '","' .$row['cu1_amt']. '","cu1_status","AllPayoutCaCu1")\'>Pending</span></td>';
                                                                        }
                                                                echo'</tr>';
                                                            }

                                                            echo '<tr>
                                                                    
                                                                    <td>'.$dt.'</td>
                                                                    <td>'.$ta_mess.'<br/> on selling '.$packageName.' package to  Customer ->'.$cuName.'<br/> No of Adult -> '.$no_of_adult.'. No of child ->'. $no_of_child.'</td>
                                                                    <td>'.$ta_amt.'</td>
                                                                    <td>'.$ta_tds.'</td>
                                                                    <td>'.$ta_total.'</td>';
                                                                    if($ta_status == '1'){
                                                                        echo'<td><span class="badge badge-pill badge-soft-success font-size-10 fw-bold ms-4">Paid</span></td>';
                                                                    }else{
                                                                        echo'<td><span class="badge badge-pill badge-soft-warning font-size-10 fw-bold ms-4" data-bs-toggle="modal" data-bs-target=".bs-example-modal-center" onclick=\'paymentId("' .$row['id']. '","' .$row['ta_id']. '","' .$row['ta_mess']. '","' .$row['ta_amt']. '","ta_status","AllPayoutTa")\'>Pending</span></td>';
                                                                    }
                                                            echo'</tr>';
                                                            echo'<tr>
                                                                    
                                                                    <td><input id="product_id" type="hidden" value="'.$row['id'].'">'.$dt.'</td>
                                                                    <td>'.$te_mess.'<br/> on selling '.$packageName.' package to  Customer ->'.$cuName.'<br/> No of Adult -> '.$no_of_adult.'. No of child ->'. $no_of_child.'</td>
                                                                    <td>'.$te_amt.'</td>
                                                                    <td>'.$te_tds.'</td>
                                                                    <td>'.$te_total.'</td>';
                                                                    if($te_status == '1'){
                                                                        echo'<td><span class="badge badge-pill badge-soft-success font-size-10 fw-bold ms-4">Paid</span></td>';
                                                                    }else{
                                                                        echo'<td><span class="badge badge-pill badge-soft-warning font-size-10 fw-bold ms-4" data-bs-toggle="modal" data-bs-target=".bs-example-modal-center" onclick=\'paymentId("' .$row['id']. '","' .$row['te_id']. '","' .$row['te_mess']. '","' .$row['te_amt']. '","te_status","AllPayoutTe")\'>Pending</span></td>';
                                                                    }
                                                            echo'</tr>';
                                                            echo'<tr>
                                                                    
                                                                    <td>'.$dt.'</td>
                                                                    <td>'.$bm_mess.'<br/> on selling '.$packageName.' package to  Customer ->'.$cuName.'<br/> No of Adult -> '.$no_of_adult.'. No of child ->'. $no_of_child.'</td>
                                                                    <td>'.$bm_amt.'</td>
                                                                    <td>'.$bm_tds.'</td>
                                                                    <td>'.$bm_total.'</td>';
                                                                    if($bm_status == '1'){
                                                                        echo'<td><span class="badge badge-pill badge-soft-success font-size-10 fw-bold ms-4">Paid</span></td>';
                                                                    }else{
                                                                        echo'<td><span class="badge badge-pill badge-soft-warning font-size-10 fw-bold ms-4" data-bs-toggle="modal" data-bs-target=".bs-example-modal-center" onclick=\'paymentId("' .$row['id']. '","' .$row['bm_id']. '","' .$row['bm_mess']. '","' .$row['bm_amt']. '","bm_status","AllPayoutBm")\'>Pending</span></td>';
                                                                    }
                                                            echo'</tr>';

                                                            if($row['bdm_id']){
                                                                echo'<tr>
                                                                        
                                                                        <td>'.$dt.'</td>
                                                                        <td>'.$bdm_mess.'<br/> on selling '.$packageName.' package to  Customer ->'.$cuName.'<br/> No of Adult -> '.$no_of_adult.'. No of child ->'. $no_of_child.'</td>
                                                                        <td>'.$bdm_amt.'</td>
                                                                        <td>'.$bdm_tds.'</td>
                                                                        <td>'.$bdm_total.'</td>';
                                                                        if($bdm_status == '1'){
                                                                            echo'<td><span class="badge badge-pill badge-soft-success font-size-10 fw-bold ms-4">Paid</span></td>';
                                                                        }else{
                                                                            echo'<td><span class="badge badge-pill badge-soft-warning font-size-10 fw-bold ms-4" data-bs-toggle="modal" data-bs-target=".bs-example-modal-center" onclick=\'paymentId("' .$row['id']. '","' .$row['bdm_id']. '","' .$row['bdm_mess']. '","' .$row['bdm_amt']. '","bdm_status","AllPayoutBdm")\'>Pending</span></td>';
                                                                        }
                                                                echo'</tr>';
                                                            }

                                                            if($row['bch_id']){
                                                                echo'<tr>
                                                                        
                                                                        <td>'.$dt.'</td>
                                                                        <td>'.$bch_mess.'<br/> on selling '.$packageName.' package to  Customer ->'.$cuName.'<br/> No of Adult -> '.$no_of_adult.'. No of child ->'. $no_of_child.'</td>
                                                                        <td>'.$bch_amt.'</td>
                                                                        <td>'.$bch_tds.'</td>
                                                                        <td>'.$bch_total.'</td>';
                                                                        if($bch_status == '1'){
                                                                            echo'<td><span class="badge badge-pill badge-soft-success font-size-10 fw-bold ms-4">Paid</span></td>';
                                                                        }else{
                                                                            echo'<td><span class="badge badge-pill badge-soft-warning font-size-10 fw-bold ms-4" data-bs-toggle="modal" data-bs-target=".bs-example-modal-center" onclick=\'paymentId("' .$row['id']. '","' .$row['bch_id']. '","' .$row['bch_mess']. '","' .$row['bch_amt']. '","bch_status","AllPayoutBch")\'>Pending</span></td>';
                                                                        }
                                                                echo'</tr>';
                                                            }
                                                            
                                                            
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
                            <textarea name="paymentMessage" id="paymentMessageDetails" class="input2" cols="70" rows="4" readonly></textarea>
                        </div>
                        <!-- <div>
                            <label class="text-muted d-block">Payment Message</label>
                            <textarea id="paymentMessage" name="paymentMessage" rows="4" cols="70" class="input2" ></textarea>
                        </div>   -->
                        <div class="modal-footer">
                            <button type="button" id="submitPayment" class="btn btn-success rounded-3" data-dismiss="modal">Submit</button>
                        </div> 
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
           
         
        <!-- JAVASCRIPT -->
        <script src="../assets/libs/jquery/jquery.min.js"></script>
        <script src="../assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="../assets/libs/metismenu/metisMenu.min.js"></script>
        <script src="../assets/libs/simplebar/simplebar.min.js"></script>
        <script src="../assets/libs/node-waves/waves.min.js"></script>
        <!-- Required datatable js -->
        <script src="../assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
        <script src="../assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
        
        <!-- Responsive examples -->
        <script src="../assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
        <script src="../assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>

        <!-- App js -->
        <script src="../assets/js/app.js"></script>

        <!-- custom js  -->
        <script src="payout_product.js"></script>

    </body>

</html>