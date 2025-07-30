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
                                    <h2 class="mb-sm-0 fw-bolder ps-4">Payouts</h2>
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
                                                        $previousPayout = $conn -> prepare("SELECT SUM(commision_bc + commision_ca) as previousPayout FROM ca_ta_payout WHERE YEAR(created_date) = '".$prevDateYear."' AND MONTH(created_date) = '".$prevDateMonth."' ");
                                                        $previousPayout -> execute();
                                                        $previousPayout -> setFetchMode(PDO::FETCH_ASSOC);
                                                        if($previousPayout -> rowCount()>0){
                                                            foreach(($previousPayout -> fetchAll()) as $key => $row){
                                                                $previousPayout = $row['previousPayout'];
                                                                $previousPayoutTDS = $previousPayout * 5/100;
                                                                $TotalpreviousPayout = $previousPayout - $previousPayoutTDS;
                                                                echo'<p class="fs-5 fw-bolder mt-n2">Rs. ' .round($TotalpreviousPayout). '/- <span class="badge badge-pill badge-soft-success font-size-10 fw-bold ms-4">Paid</span> </p>';
                                                            }
                                                        }
                                                    ?>
                                                    <a type="button" data-bs-toggle="modal" data-bs-target="#previousPayout" style=" cursor: pointer;">
                                                        <p class="mt-n2 mb-1 fw-bold p1" style="color: #0096FF;">View Payout</p>
                                                    </a>
                                                    <a href="forms/recruitment_payout/download_exel_ca?payoutYear=<?php echo $prevDateYear; ?>&payoutMonth=<?php echo $prevDateMonth; ?>&payoutmessage=PreviousPayout">
                                                        <i class="bx bx-download download-icon1" style="font-size: 20px; color: black; margin-left: 20%;"></i>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-sm-6 col-6 ">
                                                <div class="page-title-box p-3">
                                                    <p class="font-size-14">Next Payout<span class="fw-bold font-size-10 ms-5 date-layout "><?php echo "$date" ?></span></p>
                                                    <?php 
                                                        $nextPayout = $conn -> prepare("SELECT SUM(commision_bc + commision_ca) as nextPayout FROM ca_ta_payout WHERE YEAR(created_date) = '".$nextDateYear."' AND MONTH(created_date) = '".$nextDateMonth."' ");
                                                        $nextPayout -> execute();
                                                        $nextPayout -> setFetchMode(PDO::FETCH_ASSOC);
                                                        if($nextPayout -> rowCount()>0){
                                                            foreach(($nextPayout -> fetchAll()) as $key => $row2){
                                                                $nextPayoutTotal = $row2['nextPayout'];
                                                                $nextPayoutTDS = $nextPayoutTotal * 5/100;
                                                                $TotalNextPayout = $nextPayoutTotal - $nextPayoutTDS;
                                                                echo'<p class="fs-5 fw-bolder mt-n2">Rs.' .round($TotalNextPayout). '/- <span class="badge badge-pill badge-soft-warning font-size-10 fw-bold ms-4">Pending</span> </p>';
                                                            }
                                                        }
                                                    ?>
                                                    <a type="button" data-bs-toggle="modal" data-bs-target="#nextPayout" style=" cursor: pointer;">
                                                        <p class="mt-n2 mb-1 fw-bold p1" style="color: #0096FF;">View Payout</p>
                                                    </a>
                                                    <a href="forms/recruitment_payout/download_exel_ca?payoutYear=<?php echo $nextDateYear; ?>&payoutMonth=<?php echo $nextDateMonth; ?>&payoutmessage=NextPayout">
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
                                                    $totalPayout = "SELECT SUM(total_payable) as total_payable FROM ca_ta_payout_paid";
                                                    $Payout = $conn -> prepare($totalPayout);
                                                    $Payout -> execute();
                                                    $Payout -> setFetchMode(PDO::FETCH_ASSOC);
                                                    if($Payout->rowCount()>0){
                                                        foreach(($Payout->fetchAll()) as $key => $row){
                                                            $total_payable = $row["total_payable"] ?? '0';
                                                            echo'<p class="fs-5 fw-bolder mt-n2 content1" id="TotalPayoutAmountDate">Rs.'.$total_payable.'/-</p>';
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
                                                    <option value="business_consultant">Business Consultant</option>
                                                    <option value="corporate_agency">Corporate Agency</option>
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
                                                            $sql = "SELECT * FROM `ca_ta_payout`  ORDER BY `ca_ta_payout`.`id` DESC";
                                                            $stmt = $conn -> prepare($sql);
                                                            $stmt -> execute();
                                                            $stmt -> setFetchMode(PDO::FETCH_ASSOC);
                                                            if( $stmt -> rowCount()>0 ){
                                                                foreach( ($stmt -> fetchALL()) as $key => $row ){

                                                                    // date in proper formate
                                                                    $dt = new DateTime($row['created_date']);
                                                                    $dt = $dt->format('Y-m-d');

                                                                    // replace dot at end of the line with break statement
                                                                    $message1 = $row['message_bc'];
                                                                    $message1 =  str_replace('.','<br>',$message1); 

                                                                    // replace dot at end of the line with break statement
                                                                    $message2 = $row['message_ca'];
                                                                    $message2 =  str_replace('.','<br>',$message2);  

                                                                    // total Amt Cal for BC 
                                                                    $CommAmtBc = $row['commision_bc'];
                                                                    $tdsBc = $CommAmtBc * 5/100;
                                                                    $totalAmtBc = $CommAmtBc - $tdsBc;

                                                                    // total Amt Cal for CA
                                                                    $CommAmtCa = $row['commision_ca'];
                                                                    $tdsCa = $CommAmtCa * 5/100;
                                                                    $totalAmtCa = $CommAmtCa - $tdsCa;

                                                                    echo '<tr>
                                                                            <td>'.$dt.'</td>
                                                                            <td>'.$message1.'</td>
                                                                            <td class="text-end">'.$CommAmtBc.'</td>
                                                                            <td class="text-end">'.$tdsBc.'</td>
                                                                            <td class="text-end">'.$totalAmtBc.'
                                                                                <a href="forms/recruitment_payout/download_ca_payout.php?vkvbvjfgfikix='.$row['id'].'&bc='.$row['business_consultant'].'&ca='.$row['corporate_agency'].'&ta_ca='.$row['ca_travelagency'].'&date='.$dt.'&message='.$message1.'&message_status='.$row['status_bc'].'&commission='.$row['commision_bc'].'">
                                                                                    <i class="bx bx-download" style="font-size: 18px; color: black; padding-left: 5px;"></i>
                                                                                </a>
                                                                            </td>';
                                                                            if($row['status_bc'] == '1'){
                                                                                echo'<td><span class="badge badge-pill badge-soft-success font-size-10 fw-bold ms-4">Paid</span></td>';
                                                                            }else{
                                                                                echo'<td><span class="badge badge-pill badge-soft-warning font-size-10 fw-bold ms-4" data-bs-toggle="modal" data-bs-target=".bs-example-modal-center" onclick=\'paymentId("' .$row["id"]. '","' .$row["business_consultant"]. '","'.$row["message_bc"]. '","'.$CommAmtBc. '","'.$row["status_bc"].'","messageBC")\'>Pending</span></td>';
                                                                            }
                                                                    echo'</tr>';

                                                                    echo '<tr>
                                                                            <td>'.$dt.'</td>
                                                                            <td>'.$message2.'</td>
                                                                            <td class="text-end">'.$CommAmtCa.'</td>
                                                                            <td class="text-end">'.$tdsCa.'</td>
                                                                            <td class="text-end">'.$totalAmtCa.'
                                                                                <a href="forms/recruitment_payout/download_ca_payout.php?vkvbvjfgfikix='.$row['id'].'&bc='.$row['business_consultant'].'&ca='.$row['corporate_agency'].'&ta_ca='.$row['ca_travelagency'].'&date='.$dt.'&message='.$message2.'&message_status='.$row['status_ca'].'&commission='.$row['commision_ca'].'">
                                                                                    <i class="bx bx-download" style="font-size: 18px; color: black; padding-left: 5px;"></i>
                                                                                </a>
                                                                            </td>';
                                                                            if($row['status_ca'] == '1'){
                                                                                echo'<td><span class="badge badge-pill badge-soft-success font-size-10 fw-bold ms-4">Paid</span></td>';
                                                                            }else{
                                                                                echo'<td><span class="badge badge-pill badge-soft-warning font-size-10 fw-bold ms-4" data-bs-toggle="modal" data-bs-target=".bs-example-modal-center" onclick=\'paymentId("' .$row["id"]. '","' .$row["corporate_agency"]. '","'.$row["message_ca"]. '","'.$CommAmtCa. '","'.$row["status_ca"].'","messageCA")\'>Pending</span></td>';
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
                                <div class="page-title-box p-3">
                                    <p class="font-size-18 pt-3">Previous Payout<span class="fw-bold font-size-12 date-layout layout-1"><?php echo "$prevdate" ?></span></p>
                                    <div class="d-flex">
                                        <?php 
                                            $previousPayout = $conn -> prepare("SELECT SUM(commision_bc + commision_ca) as previousPayout FROM ca_ta_payout WHERE YEAR(created_date) = '".$prevDateYear."' AND MONTH(created_date) = '".$prevDateMonth."' ");
                                            $previousPayout -> execute();
                                            $previousPayout -> setFetchMode(PDO::FETCH_ASSOC);
                                            if($previousPayout -> rowCount()>0){
                                                foreach(($previousPayout -> fetchAll()) as $key => $row){
                                                    $previousPayout = $row['previousPayout'];
                                                    $previousPayoutTDS = $previousPayout * 5/100;
                                                    $TotalpreviousPayout = $previousPayout - $previousPayoutTDS;
                                                    echo'<p class="fs-5 font fw-bolder mt-n2 icon">Rs.' .round($TotalpreviousPayout). '/- </p><span class="badge badge-pill badge-soft-success font-size-10 fw-bold status1" style="height: 15px !important; margin-top: 16px;" readonly>Paid</span>';
                                                }
                                            }
                                        ?>
                                        
                                        <a href="forms/recruitment_payout/download_exel_ca?payoutYear=<?php echo $prevDateYear; ?>&payoutMonth=<?php echo $prevDateMonth; ?>&payoutmessage=PreviousPayout">
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
                                            <option value="none">--Select Filter Option--</option>
                                            <option value="business_consultant">Business Consultant</option>
                                            <option value="corporate_agency">Corporate Agency</option>
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
                                                    $stmt2 = "SELECT * FROM ca_ta_payout WHERE YEAR(created_date) = '".$prevDateYear."' AND MONTH(created_date) = '".$prevDateMonth."' ";
                                                    $stmt2 = $conn -> prepare($stmt2);
                                                    $stmt2 -> execute();
                                                    $stmt2 ->setFetchMode(PDO::FETCH_ASSOC);
                                                    if($stmt2 -> rowCount()>0){
                                                        foreach($stmt2->fetchAll() as $key2 => $row){
                                                            // date in proper formate
                                                            $dt = new DateTime($row['created_date']);
                                                            $dt = $dt->format('Y-m-d');

                                                            // replace dot at end of the line with break statement
                                                            $message1 = $row['message_bc'];
                                                            $message1 =  str_replace('.','<br>',$message1); 

                                                            // replace dot at end of the line with break statement
                                                            $message2 = $row['message_ca'];
                                                            $message2 =  str_replace('.','<br>',$message2);  

                                                            // total Amt Cal for BC 
                                                            $CommAmtBc = $row['commision_bc'];
                                                            $tdsBc = $CommAmtBc * 5/100;
                                                            $totalAmtBc = $CommAmtBc - $tdsBc;

                                                            // total Amt Cal for CA
                                                            $CommAmtCa = $row['commision_ca'];
                                                            $tdsCa = $CommAmtCa * 5/100;
                                                            $totalAmtCa = $CommAmtCa - $tdsCa;

                                                            echo '<tr>
                                                                    <td>'.$dt.'</td>
                                                                    <td>'.$message1.'</td>
                                                                    <td class="text-end">'.$CommAmtBc.'</td>
                                                                    <td class="text-end">'.$tdsBc.'</td>
                                                                    <td class="text-end">'.$totalAmtBc.'
                                                                        <a href="forms/recruitment_payout/download_ca_payout.php?vkvbvjfgfikix='.$row['id'].'&bc='.$row['business_consultant'].'&ca='.$row['corporate_agency'].'&ta_ca='.$row['ca_travelagency'].'&date='.$dt.'&message='.$message1.'&message_status='.$row['status_bc'].'&commission='.$row['commision_bc'].'">
                                                                                    <i class="bx bx-download" style="font-size: 18px; color: black; padding-left: 5px;"></i>
                                                                        </a>
                                                                    </td>';
                                                                    if($row['status_bc'] == '1'){
                                                                        echo'<td><span class="badge badge-pill badge-soft-success font-size-10 fw-bold ms-4">Paid</span></td>';
                                                                    }else{
                                                                        echo'<td><span class="badge badge-pill badge-soft-warning font-size-10 fw-bold ms-4" data-bs-toggle="modal" data-bs-target=".bs-example-modal-center" onclick=\'paymentId("' .$row["id"]. '","' .$row["business_consultant"]. '","'.$row["message_bc"]. '","'.$CommAmtBc. '","'.$row["status_bc"].'","messageBC")\'>Pending</span></td>';
                                                                    }
                                                            echo'</tr>';

                                                            echo '<tr>
                                                                    <td>'.$dt.'</td>
                                                                    <td>'.$message2.'</td>
                                                                    <td class="text-end">'.$CommAmtCa.'</td>
                                                                    <td class="text-end">'.$tdsCa.'</td>
                                                                    <td class="text-end">'.$totalAmtCa.'
                                                                        <a href="forms/recruitment_payout/download_ca_payout.php?vkvbvjfgfikix='.$row['id'].'&bc='.$row['business_consultant'].'&ca='.$row['corporate_agency'].'&ta_ca='.$row['ca_travelagency'].'&date='.$dt.'&message='.$message2.'&message_status='.$row['status_ca'].'&commission='.$row['commision_ca'].'">
                                                                                    <i class="bx bx-download" style="font-size: 18px; color: black; padding-left: 5px;"></i>
                                                                        </a>
                                                                    </td>';
                                                                    if($row['status_ca'] == '1'){
                                                                        echo'<td><span class="badge badge-pill badge-soft-success font-size-10 fw-bold ms-4">Paid</span></td>';
                                                                    }else{
                                                                        echo'<td><span class="badge badge-pill badge-soft-warning font-size-10 fw-bold ms-4" data-bs-toggle="modal" data-bs-target=".bs-example-modal-center" onclick=\'paymentId("' .$row["id"]. '","' .$row["corporate_agency"]. '","'.$row["message_ca"]. '","'.$CommAmtCa. '","'.$row["status_ca"].'","messageCA")\'>Pending</span></td>';
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
                                <div class="page-title-box p-3">
                                    <p class="font-size-18 pt-3">Next Payout<span class="fw-bold font-size-12 date-layout layout-1"><?php echo "$date" ?></span></p>
                                    <div class="d-flex">
                                        <?php 
                                            $nextPayout = $conn -> prepare("SELECT SUM(commision_bc + commision_ca) as nextPayout FROM ca_ta_payout WHERE YEAR(created_date) = '".$nextDateYear."' AND MONTH(created_date) = '".$nextDateMonth."' ");
                                            $nextPayout -> execute();
                                            $nextPayout -> setFetchMode(PDO::FETCH_ASSOC);
                                            if($nextPayout -> rowCount()>0){
                                                foreach(($nextPayout -> fetchAll()) as $key => $row2){
                                                    $nextPayoutTotal = $row2['nextPayout'];
                                                    $nextPayoutTDS = $nextPayoutTotal * 5/100;
                                                    $TotalNextPayout = $nextPayoutTotal - $nextPayoutTDS;
                                                    echo'<p class="fs-5 font fw-bolder mt-n2 icon">Rs.' .round($TotalNextPayout). '/- </p>
                                                    <span class="badge badge-pill badge-soft-success font-size-10 fw-bold status1" style="height: 15px !important; margin-top: 16px;" readonly>Paid</span>';
                                                }
                                            }
                                        ?>
                                        
                                        <a href="forms/recruitment_payout/download_exel_ca?payoutYear=<?php echo $prevDateYear; ?>&payoutMonth=<?php echo $prevDateMonth; ?>&payoutmessage=PreviousPayout">
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
                                            <option value="none">--Select Filter Option--</option>
                                            <option value="business_consultant">Business Consultant</option>
                                            <option value="corporate_agency">Corporate Agency</option>
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
                                                    $stmt2 = "SELECT * FROM ca_ta_payout WHERE YEAR(created_date) = '".$nextDateYear."' AND MONTH(created_date) = '".$nextDateMonth."' ";
                                                    $stmt2 = $conn -> prepare($stmt2);
                                                    $stmt2 -> execute();
                                                    $stmt2 ->setFetchMode(PDO::FETCH_ASSOC);
                                                    if($stmt2 -> rowCount()>0){
                                                        foreach($stmt2->fetchAll() as $key2 => $row){
                                                            // date in proper formate
                                                            $dt = new DateTime($row['created_date']);
                                                            $dt = $dt->format('Y-m-d');

                                                            // replace dot at end of the line with break statement
                                                            $message1 = $row['message_bc'];
                                                            $message1 =  str_replace('.','<br>',$message1); 

                                                            // replace dot at end of the line with break statement
                                                            $message2 = $row['message_ca'];
                                                            $message2 =  str_replace('.','<br>',$message2);  

                                                            // total Amt Cal for BC 
                                                            $CommAmtBc = $row['commision_bc'];
                                                            $tdsBc = $CommAmtBc * 5/100;
                                                            $totalAmtBc = $CommAmtBc - $tdsBc;

                                                            // total Amt Cal for CA
                                                            $CommAmtCa = $row['commision_ca'];
                                                            $tdsCa = $CommAmtCa * 5/100;
                                                            $totalAmtCa = $CommAmtCa - $tdsCa;

                                                            echo '<tr>
                                                                    <td>'.$dt.'</td>
                                                                    <td>'.$message1.'</td>
                                                                    <td class="text-end">'.$CommAmtBc.'</td>
                                                                    <td class="text-end">'.$tdsBc.'</td>
                                                                    <td class="text-end">'.$totalAmtBc.'
                                                                        <a href="forms/recruitment_payout/download_ca_payout.php?vkvbvjfgfikix='.$row['id'].'&bc='.$row['business_consultant'].'&ca='.$row['corporate_agency'].'&ta_ca='.$row['ca_travelagency'].'&date='.$dt.'&message='.$message1.'&message_status='.$row['status_bc'].'&commission='.$row['commision_bc'].'">
                                                                                    <i class="bx bx-download" style="font-size: 18px; color: black; padding-left: 5px;"></i>
                                                                        </a>
                                                                    </td>';
                                                                    if($row['status_bc'] == '1'){
                                                                        echo'<td><span class="badge badge-pill badge-soft-success font-size-10 fw-bold ms-4">Paid</span></td>';
                                                                    }else{
                                                                            echo'<td><span class="badge badge-pill badge-soft-warning font-size-10 fw-bold ms-4" data-bs-toggle="modal" data-bs-target=".bs-example-modal-center" onclick=\'paymentId("' .$row["id"]. '","' .$row["business_consultant"]. '","'.$row["message_bc"]. '","'.$CommAmtBc. '","'.$row["status_bc"].'","messageBC")\'>Pending</span></td>';
                                                                    }
                                                            echo'</tr>';

                                                            echo '<tr>
                                                                    <td>'.$dt.'</td>
                                                                    <td>'.$message2.'</td>
                                                                    <td class="text-end">'.$CommAmtCa.'</td>
                                                                    <td class="text-end">'.$tdsCa.'</td>
                                                                    <td class="text-end">'.$totalAmtCa.'
                                                                        <a href="forms/recruitment_payout/download_ca_payout.php?vkvbvjfgfikix='.$row['id'].'&bc='.$row['business_consultant'].'&ca='.$row['corporate_agency'].'&ta_ca='.$row['ca_travelagency'].'&date='.$dt.'&message='.$message2.'&message_status='.$row['status_ca'].'&commission='.$row['commision_ca'].'">
                                                                                    <i class="bx bx-download" style="font-size: 18px; color: black; padding-left: 5px;"></i>
                                                                        </a>
                                                                    </td>';
                                                                    if($row['status_ca'] == '1'){
                                                                        echo'<td><span class="badge badge-pill badge-soft-success font-size-10 fw-bold ms-4">Paid</span></td>';
                                                                    }else{
                                                                            echo'<td><span class="badge badge-pill badge-soft-warning font-size-10 fw-bold ms-4" data-bs-toggle="modal" data-bs-target=".bs-example-modal-center" onclick=\'paymentId("' .$row["id"]. '","' .$row["corporate_agency"]. '","'.$row["message_ca"]. '","'.$CommAmtCa. '","'.$row["status_ca"].'","messageCA")\'>Pending</span></td>';
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
                                <div class="page-title-box p-3">
                                    <p class="font-size-18 pt-3">Total Payout<span class="fw-bold font-size-12 date-layout layout-1"><?php echo "$date" ?></span></p>
                                    <div class="d-flex">
                                        <?php 
                                            $totalPayout = "SELECT SUM(total_payable) as total_payable FROM ca_ta_payout_paid";
                                            $Payout = $conn -> prepare($totalPayout);
                                            $Payout -> execute();
                                            $Payout -> setFetchMode(PDO::FETCH_ASSOC);
                                            if($Payout->rowCount()>0){
                                                foreach(($Payout->fetchAll()) as $key => $row){
                                                    $total_payable = $row["total_payable"] ?? '0';
                                                    echo'
                                                    <p class="fs-5 font fw-bolder mt-n2 icon">Rs.'.$total_payable.'/- </p>
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
                                            <option value="none">--Select Filter Option--</option>
                                            <option value="business_consultant">Business Consultant</option>
                                            <option value="corporate_agency">Corporate Agency</option>
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
                                        <table class="table table-hover" id="previous_payout_table">
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
                                                    $stmt2 = "SELECT * FROM ca_ta_payout_paid WHERE status = '1' ";
                                                    $stmt2 = $conn -> prepare($stmt2);
                                                    $stmt2 -> execute();
                                                    $stmt2 ->setFetchMode(PDO::FETCH_ASSOC);
                                                    if($stmt2 -> rowCount()>0){
                                                        foreach($stmt2->fetchAll() as $key2 => $row){
                                                            // date in proper formate
                                                            $dt = new DateTime($row['date']);
                                                            $dt = $dt->format('Y-m-d');

                                                            // replace dot at end of the line with break statement
                                                            $message1 = $row['payout_message'];
                                                            $message1 =  str_replace('.','<br>',$message1); 

                                                            // replace dot at end of the line with break statement
                                                            $message2 = $row['payout_details'];
                                                            $message2 =  str_replace('.','<br>',$message2);  

                                                            echo '<tr>
                                                                    <td>'.$dt.'</td>
                                                                    <td>'.$message1.'</td>
                                                                    <td>'.$message2.'</td>
                                                                    <td class="text-end">'.$row['amount'].'</td>
                                                                    <td class="text-end">'.$row['tds'].'</td>
                                                                    <td class="text-end">'.$row['total_payable'].'</td>';
                                                                    if($row['status'] == '1'){
                                                                        echo'<td><span class="badge badge-pill badge-soft-success font-size-10 fw-bold ms-4">Paid</span></td>';
                                                                    }else{
                                                                        echo'<td><span class="badge badge-pill badge-soft-warning font-size-10 fw-bold ms-4" >Pending</span></td>';
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
                        <div>
                            <label class="text-muted d-block">Payment Message</label>
                            <textarea id="paymentMessage" name="paymentMessage" rows="4" cols="70" class="input2" ></textarea>
                        </div>  
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
        <script src="payout.js"></script>

    </body>

</html>