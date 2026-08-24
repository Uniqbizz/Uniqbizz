<?php

session_start();

if (!isset($_SESSION['username'])) {
    echo '<script>location.href = "../login.php";</script>';
}

require '../connect.php';
$date = date('Y');

$id = $_GET['id'];
$ref = $_GET['ref'];
$tamount='';
$initial_inv='';
$DBtable = $_GET['message'];
$designation = $_GET['designation'];

include 'config/overview.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Overview</title>
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
    <!-- Css-->
    <link href="../assets/css/loadingScreen.css" id="app-style" rel="stylesheet" type="text/css" />
    <!-- App js -->
    <!-- <script src="assets/js/plugin.js"></script> -->
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Date Range Picker CSS Start -->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <!-- Date Range Picker CSS End -->
    <!-- DataTables -->
    <link href="../assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <!-- Responsive datatable examples -->
    <link href="../assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <style>
        #image_preview1 {
            height: 180px;
            width: 180px;
        }

        #preview1 img {
            width: 180px;
            height: 180px;
        }

        #image_preview2 {
            height: 180px;
            width: 180px;
        }

        #preview2 img {
            width: 180px;
            height: 180px;
        }

        #image_preview3 {
            height: 180px;
            width: 180px;
        }

        #preview3 img {
            width: 180px;
            height: 180px;
        }

        #image_preview4 {
            height: 180px;
            width: 180px;
        }

        #preview4 img {
            width: 180px;
            height: 180px;
        }

        #image_preview5 {
            height: 180px;
            width: 180px;
        }

        #preview5 img {
            width: 180px;
            height: 180px;
        }

        #image_preview6 {
            height: 180px;
            width: 180px;
        }

        #preview6 img {
            width: 180px;
            height: 180px;
        }

        input::file-selector-button {
            background-color: #f1b44c;
            background-size: 150%;
            border: 0;
            border-radius: 8px;
            color: #fff;
            padding: 1rem 1.25rem;
            text-shadow: 0 1px 1px #333;
            transition: all 0.25s;
            color: white;
        }

        input::file-selector-button:hover {
            background-color: #ffca04;
        }

        .cardHover:hover {
            background-color: #556ee6 !important;
            border-radius: 6px !important;
            /* padding: 4px !important; */
            border: none !important;
        }

        .faIcon {
            padding: 21px 17px 21px 17px !important;
        }

        .faIcon:hover {
            color: #fff !important
        }

        .pera {
            font-size: 10px !important;
            font-weight: 500 !important;
        }

        .dateRange {
            border-radius: 14px !important;
        }

        .peraPadding {
            padding-left: .75rem !important;
        }

        /* Accordion */
        .accordion {
            cursor: pointer;
            width: 100%;
            border: none;
        }

        .panel {
            padding: 0 0 0 15px;
            display: none;
            overflow: hidden;
        }

        @media screen and (min-width: 993px) and (max-width: 1180px) {
            .cardText {
                font-size: 12px !important;
            }

            .cardProPic {
                width: 35px !important;
                height: 35px !important;
            }

            .card-Img1 {
                width: 70px !important;
                height: 55px !important;
            }

        }

        @media screen and (min-width: 768px) and (max-width: 960px) {
            .cardText {
                font-size: 12px !important;
            }

            .cardProPic {
                width: 35px !important;
                height: 35px !important;
            }

            .card-Img1 {
                width: 70px !important;
                height: 55px !important;
            }
        }

        @media screen and (min-width: 320px) and (max-width: 485px) {
            .cardText {
                font-size: 11px !important;
            }

            .cardProPic {
                width: 35px !important;
                height: 35px !important;
            }

            .card-Img1 {
                width: 65px !important;
                height: 50px !important;
            }
        }

        @media only screen and (max-width: 1180px) {
            .rowAlign {
                display: block !important;
            }

            .dateRangeAlign {
                display: flex !important;
                justify-content: left !important;
            }

        }

        /* Activities */
        .borderAlign {
            border-bottom: 2px solid #919191;
            position: absolute;
            left: 141px;
            top: 15px;
            width: 90px;
        }

        .borderAlignLeft {
            border-left: 2px solid #919191 !important;
            width: 89px;
            position: absolute;
            height: 95px;
            left: 140px;
            top: -32px;
            border: none;
        }

        .position {
            position: relative;
        }
    </style>
</head>

<body data-sidebar="dark">
    <div class="layout-wrapper">
        <?php
        // top header logo, hamberger menu, fullscreen icon, profile
        include_once '../header.php';

        // sidebar navigation menu 
        include_once '../sidebar.php';
        ?>
        <div class="layout-wrapper">
            <div class="main-content">
                <div class="page-content">
                    <div class="container-fluid">
                        <div class="card p-3 rounded-4">
                            <div class="row">
                                <div class="col-xl-1 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <!-- <img src="../assets/images/users/avatar-5.jpg" width="75" height="75" alt="" class="rounded-circle"> -->
                                    <?php
                                    if ($profile_pic) {
                                        echo '<img src="../../uploading/' . $profile_pic . '" alt="Preview" class="avatar-md rounded-circle">';
                                    } else {
                                        echo '<img src="../../uploading/not_uploaded.png" alt="Preview" class="avatar-md rounded-circle">';
                                    }
                                    ?>
                                </div>
                                <div class="col-xl-11 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <div class="row mt-3">
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                            <h4><?= $User_name ?><span> <?= $id ?></span></h4>
                                        </div>
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                            <div class="row">
                                                <div class="<?=$customer_type== 'Premium Plus'?'col-xl-3 col-lg-3':'col-xl-4 col-lg-4'?> col-md-12 col-sm-12 col-12 pe-0">
                                                    <p><span><i class="fa-solid fa-user-tie pe-2"></i></span><?= $designation; ?></p>
                                                </div>
                                                <div class="<?=$customer_type== 'Premium Plus'?'col-xl-3 col-lg-3':'col-xl-3 col-lg-3'?> col-md-12 col-sm-12 col-12 px-0">
                                                    <p class="peraPadding"> Create Date: <span class="fw-bold"><?= $rdate; ?></span></p>
                                                </div>
                                                <?php
                                                    if($customer_type){
                                                        if($customer_type == 'Premium Plus'){
                                                ?>
                                                <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12 col-12">
                                                    <p>Wallet Balance: <span class="fw-bold py-1 px-2 rounded-3 bg-success-subtle text-success-emphasis border-success-subtle">&#8377;0</span></p>
                                                </div>
                                                <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12 col-12">
                                                    <p>Booking Points: <span class="fw-bold py-1 px-2 rounded-3 bg-success-subtle text-success-emphasis border-success-subtle">&#8377;0</span></p>
                                                </div>
                                                <?php
                                                        }else{
                                                ?>
                                                <div class="col-xl-5 col-lg-5 col-md-12 col-sm-12 col-12">
                                                    <p>Wallet Balance: <span class="fw-bold py-1 px-2 rounded-3 bg-success-subtle text-success-emphasis border-success-subtle">&#8377;0</span></p>
                                                </div>
                                                <?php
                                                        }
                                                    } else{
                                                ?>
                                                <div class="col-xl-5 col-lg-5 col-md-12 col-sm-12 col-12">
                                                    <p>
                                                        Commission Earned:
                                                        <span id="commissionTotal" class="fw-bold py-1 px-2 rounded-3 bg-success-subtle text-success-emphasis border-success-subtle">
                                                            ₹0
                                                        </span>
                                                    </p>
                                                </div>
                                                <?php
                                                    }
                                                ?>
                                                <?php
                                                    if($DBtable != 'ca_customer' && $DBtable != 'institution'){//institution and customer account are non transferable
                                                ?>
                                                <!-- <div class="row">
                                                    <div class="col-xl-5 col-lg-5 col-md-12 col-sm-12 col-12">
                                                        <button class="btn btn-warning btn-sm edit-btn"
                                                            data-user='<?= json_encode($edit_arr) ?>'>
                                                            <i class="fa-solid fa-right-left me-1"></i> Transfer
                                                        </button>
                                                    </div>
                                                </div> -->
                                                <?php
                                                    }
                                                ?>
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <nav role="navigation">
                                <ul class="nav nav-underline " role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" data-bs-toggle="tab" role="tab" href="#overview">Overview</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-bs-toggle="tab" role="tab" href="#activities">Activities</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-bs-toggle="tab" role="tab" href="#teams">Team</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-bs-toggle="tab" role="tab" href="#payout">Payout</a>
                                    </li>
                                    <?php 
                                        if($DBtable == 'ca_customer'){
                                    ?>
                                    <li class="nav-item">
                                        <a class="nav-link" data-bs-toggle="tab" role="tab" href="#Coupon">Coupons</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-bs-toggle="tab" role="tab" href="#t_c">Terms And Conditions</a>
                                    </li>
                                    <?php 
                                        } 
                                    ?>
                                    <?php if ($DBtable == 'sub_franchisee' || $DBtable == 'institution') { ?>
                                        <li class="nav-item">
                                            <a class="nav-link" data-bs-toggle="tab" role="tab" href="#s_p">Upgrade History</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-bs-toggle="tab" role="tab" href="#ins_downline">Assign Downline</a>
                                        </li>
                                    <?php } ?>
                                    <!-- <li class="nav-item">
                                        <a class="nav-link" data-bs-toggle="tab" role="tab" href="#editLogs">Edit History</a>
                                    </li> -->
                                    <?php
                                        $excludeTables = ['ca_customer', 'institution'];

                                        if (!in_array($DBtable, $excludeTables)) {
                                    ?>
                                            <!-- <li class="nav-item">
                                                <a class="nav-link" data-bs-toggle="tab" role="tab" href="#transferLogs">Transfer History</a>
                                            </li> -->
                                    <?php
                                        }
                                    ?>

                                </ul>
                            </nav>
                        </div>
                        <div class="tab-content">
                            <!-- Overview Start -->
                            <div class="tab-pane fade show active" id="overview" role="tabpanel">
                                <?php include 'overview_card.php' ?>
                            </div>
                            <!-- Overview End -->

                            <!-- Activities Start -->
                            <div class="tab-pane fade card px-3 rounded-4" id="activities" role="tabpanel">
                                <?php include 'activity.php' ?>
                            </div>
                            <!-- Activities End -->

                            <!-- Team Start -->
                            <?php include 'team.php' ?>
                            <!-- Team End -->
                            
                            <!-- Payout Start -->
                            <div class="tab-pane fade card px-3 rounded-4" id="payout" role="tabpanel">
                                <div class="row">
                                    <div class="d-flex justify-content-end">
                                        <div class="pt-3 pb-2 col-md-7">
                                            <h5>Payout</h5>
                                        </div>
                                        <div class="pt-3 pb-2 col-md-5">
                                            <div class="row d-flex justify-content-end">
                                                <input type="text" id="rangeDate" name="daterange" value="" class="col-md-6 bg-secondary-subtle rounded-3 border-0" />
                                                <div class="ms-3 col-md-3">
                                                    <a href="">
                                                        <button class="bg-success text-white border-0 rounded-3 fw-bold">Download</button>
                                                    </a>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <!-- Table -->
                                <div class="table-responsive table-desi pb-2" id="filterTable">
                                    <!-- table roe limit -->
                                    <table class="table table-hover" id="payoutDetailsTable">
                                        <thead>
                                            <tr>
                                                <th class="ceterText fw-semibold fs-6">Date</th>
                                                <th class="ceterText fw-semibold fs-6">Title</th>
                                                <th class="ceterText fw-semibold fs-6">Payout Details</th>
                                                <th class="ceterText fw-semibold fs-6">Amount</th>
                                                <th class="ceterText fw-semibold fs-6">TDS</th>
                                                <th class="ceterText fw-semibold fs-6">Total Payable</th>
                                                <th class="ceterText fw-semibold fs-6">Status</th>
                                            </tr>
                                        </thead>
                                        <tbody id="payoutDetails">
                                            
                                        </tbody>
                                    </table>
                                </div>
                                
                            </div>
                            <!-- Payout End -->
                            <?php 
                                if($DBtable == 'sub_franchisee' || $DBtable == 'institution'){
                            ?>
                            <!-- upgarde History Start -->
                            <div class="tab-pane fade card px-3 rounded-4" id="s_p" role="tabpanel">
                                <div class="row">
                                    <div class="d-flex justify-content-start">
                                        <div class="pt-3 pb-2 col-md-6">
                                            <h5>Upgarde History</h5>
                                        </div>
                                        <?php
                                            if($DBtable == 'sub_franchisee'){
                                                $sql101= "SELECT old_investment_amt,new_investment_amt,upgrade_amt as upgrade_amt  FROM sub_franchisee_upgrade
                                                                WHERE sub_franchisee_id='".$id."' and upgrade_status=1
                                                                ORDER BY upgrade_approval_date DESC limit 1";
                                            }else if($DBtable == 'institution'){
                                                $sql101= "SELECT old_investment_amt,new_investment_amt,upgrade_amt as upgrade_amt  FROM institution_upgrade
                                                                WHERE institution_id='".$id."' and upgrade_status=1
                                                                ORDER BY upgrade_approval_date DESC limit 1";
                                            }
                                        
                                            $stmt101 = $conn->prepare($sql101);
                                            // print_r($stmt101);
                                            $stmt101->execute();
                                            $stmt101->setFetchMode(PDO::FETCH_ASSOC);
                                            if ($stmt101->rowCount() > 0) {
                                                 foreach (($stmt101->fetchAll()) as $key => $row) {
                                                    $tamount = $row['upgrade_amt'] ?? 0;
                                                 }
                                            }else{
                                                $tamount = $initial_inv;
                                            }
                                        ?>
                                        <div class="pt-3 pb-2 col-md-6">
                                            <div class="row justify-content-end">
                                                <div class="col-md-6 d-flex gap-2">
                                                    <span class="fw-semibold">Total Investment:</span>
                                                    <span class="badge bg-success fs-6 px-3 py-2">
                                                        <?= htmlspecialchars($tamount, ENT_QUOTES, 'UTF-8') ?>
                                                    </span>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <!-- Table -->
                                <div class="table-responsive table-desi pb-2" id="filterTable1">
                                    <!-- table roe limit -->
                                    <table class="table table-hover" id="upgardeHistoryTable">
                                        <thead>
                                            <tr>
                                                <th class="ceterText fw-semibold fs-6">Investment Date</th>
                                                <th class="ceterText fw-semibold fs-6">Invested Amount</th>
                                                <th class="ceterText fw-semibold fs-6">Commission Percentage</th>
                                                <th class="ceterText fw-semibold fs-6">Incentive Percentage</th>
                                                <th class="ceterText fw-semibold fs-6">Payment mode</th>
                                                <th class="ceterText fw-semibold fs-6">Note</th>
                                                <th class="ceterText fw-semibold fs-6">Approved date</th>
                                                <th class="ceterText fw-semibold fs-6">Remark</th>
                                                <th class="ceterText fw-semibold fs-6">Status</th>
                                                <th class="ceterText fw-semibold fs-6">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="upgardeHistory">
                                            <?php
                                            if($DBtable == 'sub_franchisee'){
                                                $sqlUnion = "SELECT id,new_investment_amt,upgrade_amt,upgrade_request_date,upgrade_approval_date,new_commission_per,new_incentive_per,
                                                                payment_mode,cheque_no,cheque_date,bank_name,transaction_no,payment_proof,rejection_reason,
                                                                approved_by,note,upgrade_status, 'SF' as user_type
                                                                FROM sub_franchisee_upgrade
                                                                WHERE sub_franchisee_id='".$id."'
                                                                ORDER BY upgrade_request_date ASC ";
                                            }else if($DBtable == 'institution'){
                                                $sqlUnion = "SELECT id,new_investment_amt,upgrade_amt,upgrade_request_date,upgrade_approval_date,new_commission_per,new_incentive_per,
                                                                payment_mode,cheque_no,cheque_date,bank_name,transaction_no,payment_proof,rejection_reason,
                                                                approved_by,note,upgrade_status, 'I' as user_type
                                                                FROM institution_upgrade
                                                                WHERE institution_id='".$id."'
                                                                ORDER BY upgrade_request_date ASC ";
                                            }
                                            
                                            $stmtUnion = $conn->prepare($sqlUnion);
                                            $stmtUnion->execute();
                                            $stmtUnion->setFetchMode(PDO::FETCH_ASSOC);
                                            if ($stmtUnion->rowCount() > 0) {
                                                foreach (($stmtUnion->fetchAll()) as $key => $row) {
                                                    $ud = new DateTime($row['upgrade_request_date']);
                                                    $udate = $ud->format('d-m-Y');
                                                    $ad = new DateTime($row['upgrade_approval_date']);
                                                    $adate = $ad->format('d-m-Y');

                                                    // replace dot at end of the line with break statement
                                                    // $message = $row['message'];
                                                    // $message1 =  str_replace('.','<br>',$message1); 

                                                    $tamount = $row['upgrade_amt'];
                                                    $amount = $row['new_investment_amt'];
                                                    $comm = $row['new_commission_per'];
                                                    $inc = $row['new_incentive_per'];
                                                    $pay_mode = $row['payment_mode'];
                                                    $aproved_by = $row['approved_by'];
                                                    $note = $row['note'];
                                                    $row_id=$row['id'];
                                                    $user_type=$row['user_type'];
                                                    $rejection_reason = trim($row['rejection_reason'] ?? '');

                                                    if ($rejection_reason === '') {
                                                        $rejection_reason = 'NA';
                                                    }
                                                    $status = $row['upgrade_status'];
                                                    echo '<tr>
                                                                <td>' . $udate . '</td>
                                                                <td>' . $amount . '</td>
                                                                <td>' . $comm . '</td>
                                                                <td>' . $inc . '</td>
                                                                <td>' . $pay_mode . '</td>
                                                                <td style="width: 350px;">' . $note . '</td>
                                                                <td>' . $adate . '</td>
                                                                <td>' . $rejection_reason . '</td>
                                                                <td>';
                                                    if ($status == 0) {
                                                        echo '<span class="badge badge-pill badge-soft-info font-size-10 fw-bold ms-4">Requested</span>';
                                                    }
                                                    if ($status == 1) {
                                                        echo '<span class="badge badge-pill badge-soft-success font-size-10 fw-bold ms-4">Approved</span>';
                                                    }
                                                    if ($status == 2) {
                                                        echo '<span class="badge badge-pill badge-soft-danger font-size-10 fw-bold ms-4">Rejected</span>';
                                                    }
                                                    echo '  </td>
                                                            <td>
                                                                <div class="dropdown">
                                                                    <a href="#" class="dropdown-toggle card-drop" data-bs-toggle="dropdown" aria-expanded="false">
                                                                        <i class="mdi mdi-dots-horizontal font-size-18"></i>
                                                                    </a>
                                                                    <ul class="dropdown-menu">
                                                                        <li><a href="#" onclick=\'upgradeHistoryPage("' . $row_id . '","' .$id. '","' .$user_type. '")\' class="dropdown-item" data-bs-toggle="modal"><i class="mdi mdi-eye font-size-16 text-info me-1"></i>View Details</a></li>
                                                                        <li><a href="#" onclick=\'upgradePage("' . $id . '","' .$reference_no. '")\'  class="dropdown-item" data-bs-toggle="modal"><i class="mdi mdi-arrow-up-bold text-success me-1"></i> Upgrade Franchisee</a></li>
                                                                    </ul>
                                                                </div>
                                                            </td>
                                                            </tr>
                                                            ';
                                                }
                                            }
                                            
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                                
                            </div>
                            <!-- upgarde History End -->
                            <?php 
                                } if($DBtable == 'institution'){
                            ?>
                            <!-- downline -->
                            <div class="tab-pane fade card px-3 rounded-4" id="ins_downline" role="tabpanel">
                                <!-- Header -->
                                <div class="row">
                                    <div class="d-flex justify-content-start">
                                        <div class="pt-3 pb-2 col-md-6">
                                            <h5>Assign Downline</h5>
                                        </div>
                                        <div class="pt-3 pb-2 col-md-6">
                                            <div class="text-end">
                                                <button type="button" class="btn btn-primary" id="editDownlineBtn">
                                                    <i class="mdi mdi-pencil me-1"></i>
                                                    Add
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- =====================================================
                                    EDIT DOWNLINE FORM
                                ====================================================== -->
                                <div class="row pb-4">
                                    <!-- TC -->
                                    <div class="col-md-6 mb-3">
                                        <div class="card border h-100">
                                            <div class="card-header bg-white">
                                                <div class="form-check">
                                                    <input class="form-check-input downline-checkbox" type="checkbox" id="tc_check" value="TC" disabled>
                                                    <label class="form-check-label fw-semibold" for="tc_check">TC</label>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <!-- Holiday Account -->
                                                <div class="mb-4">
                                                    <label class="form-label fw-semibold">Payout for Holiday Account</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text"> ₹ </span>
                                                        <input type="number" class="form-control payout-input" id="tc_holiday_account" value="0" readonly>
                                                    </div>
                                                </div>
                                                <!-- Holiday Booking -->
                                                <div>
                                                    <label class="form-label fw-semibold">Payout for Holiday Booking</label>
                                                    <select class="form-select payout-input" id="tc_holiday_booking_type" disabled>
                                                        <option value="fixed">Fixed Amount</option>
                                                        <option value="package" selected>As per Package</option>
                                                    </select>
                                                </div>
                                                <!-- Fixed Amount -->
                                                <div id="tc_holiday_fixed_account" class="mt-3" style="display:none;">
                                                    <label for="tc_holiday_fixed_amount" class="form-label fw-semibold">Fixed Amount</label>
                                                    <input type="number" class="form-control payout-input" id="tc_holiday_fixed_amount" min="0" step="0.01">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- IBR -->
                                    <div class="col-md-6 mb-3">
                                        <div class="card border h-100">
                                            <div class="card-header bg-white">
                                                <div class="form-check">
                                                    <input class="form-check-input downline-checkbox" type="checkbox" id="br_check" value="BR" disabled>
                                                    <label class="form-check-label fw-semibold" for="br_check">IBR</label>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <!-- Holiday Account -->
                                                <div class="mb-4">
                                                    <label class="form-label fw-semibold">Payout for Holiday Account</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text"> ₹ </span>
                                                        <input type="number" class="form-control payout-input" id="br_holiday_account" value="0" readonly>
                                                    </div>
                                                </div>
                                                <!-- Holiday Booking -->
                                                <div>
                                                    <label class="form-label fw-semibold"> Payout for Holiday Booking </label>
                                                    <div class="input-group">
                                                        <span class="input-group-text"> ₹ </span>
                                                        <input type="number" class="form-control payout-input" id="br_holiday_booking" value="0" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Error -->
                                    <div class="col-md-12">
                                        <div id="downlineError" class="text-danger mt-2" style="display:none;"></div>
                                    </div>
                                    <!-- Save -->
                                    <div class="col-md-12">
                                        <div class="text-end mt-2">
                                            <button type="button" class="btn btn-success" id="saveDownlineBtn" style="display:none;">
                                                <i class="mdi mdi-content-save me-1"></i>
                                                Save Changes
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <!-- =====================================================
                                    DOWNLINE HISTORY
                                ====================================================== -->
                                <div class="row pb-4">
                                    <div class="col-md-12">
                                        <div class="card border">
                                            <div class="card-header bg-white">
                                                <h6 class="mb-0"> Downline History </h6>
                                            </div>
                                            <div class="card-body">
                                                <div class="table-responsive">
                                                    <table id="downlineHistoryTable" class="table table-bordered table-hover align-middle w-100">
                                                        <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <th>TC</th>
                                                                <th>IBR</th>
                                                                <th>TC Holiday Account</th>
                                                                <th>IBR Holiday Account</th>
                                                                <th>TC Holiday Booking</th>
                                                                <th>IBR Holiday Booking</th>
                                                                <th>Activation Date</th>
                                                                <th>Deactivation Date</th>
                                                                <th>Status</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody></tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- downline -->
                            <?php
                                }
                            ?>
                            <?php 
                                if($DBtable == 'ca_customer'){
                            ?>
                                <!-- coupons only for customers -->
                                <div class="tab-pane fade show" id="Coupon" role="tabpanel">
                                    <div class="card rounded-4">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="d-flex justify-content-between">
                                                    <?php
                                                        require '../connect.php';
                                                        $sql='SELECT * FROM cu_coupons WHERE user_id=:fid';
                                                        $stmt = $conn->prepare($sql);
                                                        $stmt->execute([':fid' => $id]);
                                                        $coupons = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                                        //print_r($coupons);
                                                        if(count($coupons) > 0){   
                                                    ?>
                                                    <div class="pt-3 pb-2 col-md-7">
                                                        <h5>Available Coupons</h5>
                                                    </div>
                                                    <?php }else{?>
                                                    <div class="pt-3 pb-2 col-md-7">
                                                        <h5>No Coupons Available </h5>
                                                    </div>
                                                    <div class="pt-3 pb-2 col-md-5">
                                                        <div class="row">
                                                            <!-- Generate Coupons Button -->
                                                            <div class="col-12">
                                                                <div class="d-flex justify-content-end align-items-center gap-3 flex-wrap">

                                                                    <!-- Checkbox Card -->
                                                                    <div class="form-check d-flex align-items-center bg-light px-4 py-2 rounded-3 shadow-sm mb-0">
                                                                        <input 
                                                                            class="form-check-input me-2" 
                                                                            type="checkbox" 
                                                                            name="couponRegen" 
                                                                            id="couponRegen"
                                                                        >
                                                                        <label class="form-check-label fw-semibold text-dark mb-0" for="couponRegen">
                                                                            Regenerate Coupons
                                                                        </label>
                                                                    </div>

                                                                    <!-- Button -->
                                                                    <button 
                                                                        type="button" 
                                                                        class="btn btn-success px-4 py-2 fw-bold rounded-3 shadow-sm"
                                                                        id="generate_coupons"
                                                                    >
                                                                        <i class="fa-solid fa-arrows-spin"></i>
                                                                        Generate Coupons
                                                                    </button>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php }?>
                                                </div>
                                            </div>
                                            <?php
                                                require '../connect.php';
                                                $sql='SELECT * FROM cu_coupons WHERE user_id=:fid';
                                                $stmt = $conn->prepare($sql);
                                                $stmt->execute([':fid' => $id]);
                                                $coupons = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                                //print_r($coupons);
                                                if(count($coupons) == 0){   
                                            ?>
                                            <div class="row">
                                                <div class="col-md-6 col-sm-6" id="couponFee">
                                                    <div class="input-block mb-3">
                                                        <label for="payment_fee" class="col-form-label">Payment Fee<span class="text-danger">*</span></label>
                                                        <select class="form-select" id="payment_fee" aria-label="Floating label select example">
                                                            <option value="null" selected disabled>--Select Payment Fee--</option>
                                                            <!-- <option value="10000">Prime: <span>&#8377 </span>10,000/-</option>
                                                            <option value="30000">Premium: <span>&#8377 </span>30,000/-</option>
                                                            <option value="35000">Premium Plus: <span>&#8377 </span>35,000/-</option> -->
                                                            <option value="11000">Neo Select: <span>&#8377 </span>11,000/-</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-sm-6">
                                                    <div class="input-block mb-3">
                                                        <label for="comp_chek" class="col-form-label">Complementary Type<span class="text-danger">*</span></label>
                                                        <select class="form-select" id="comp_chek" aria-label="Floating label select example">
                                                            <option value="null" selected disabled>--Select Complementary Tpe--</option>
                                                            <option value="2">Non Complementary</option>
                                                            <option value="1">Complementary</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                
                                            </div>
                                            <div class="col-md-12 col-sm-12 d-none" id="paymentMode1">
                                                <div class="input-block mb-3">
                                                    <label class="fw-bold col-form-label">Payment Mode: <span class="text-danger">*</span></label>
                                                    <div class="form-control radioBtn d-flex justify-content-around">
                                                        <label class="mb-0" for="cashPayment"><input type="radio" id="cashPayment" class="form-check-input payment1 me-3" name="payment" value="cash">Cash</label>
                                                        <label class="mb-0" for="chequePayment"><input type="radio" id="chequePayment" class="form-check-input payment1 me-3" name="payment" value="cheque">Cheque</label>
                                                        <label class="mb-0" for="onlinePayment"><input type="radio" id="onlinePayment" class="form-check-input payment1 me-3" name="payment" value="online">UPI/NEFT</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="pb-3 d-none" id="payOpt">
                                                <div class="col-md-12 col-sm-12 d-none" id="chequeOpt1">
                                                    <div class="row d-flex justify-content-center">
                                                        <div class="col-md-4">
                                                            <div class="input-block">
                                                                <label class="col-form-label" for="chequeNo1">Cheque No<span class="text-danger">*</span></label>
                                                                <input type="text" class="form-control" id="chequeNo1" placeholder="Enter Cheque Number">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="input-block">
                                                                <label class="col-form-label" for="chequeDate1">Cheque Date<span class="text-danger">*</span></label>
                                                                <input type="date" class="form-control" id="chequeDate1" placeholder="Enter Date On Cheque">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="input-block">
                                                                <label class="col-form-label" for="bankName1">Bank Name<span class="text-danger">*</span></label>
                                                                <input type="text" class="form-control" id="bankName1" placeholder="Enter your Bank Name">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12 col-sm-12 d-none" id="onlineOpt1">
                                                    <div class="row d-flex justify-content-center">
                                                        <div class="col-md-8">
                                                            <div class="input-block">
                                                                <label class="col-form-label" for="transactionNo1">Transaction No<span class="text-danger">*</span></label>
                                                                <input type="text" class="form-control" id="transactionNo1" placeholder="Enter your Transaction No.">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6 col-sm-6 d-none" id="payProof">
                                                    <div class="mb-3">
                                                        <label class="col-form-label" for="file6">Payment Proof</label><br />
                                                        <input class="form-control" type="file" name="file6" id="upload_file61">
                                                    </div>
                                                    <input type="hidden" id="img_path61" value="">
                                                    <div id="preview61" style="display: none;">
                                                        <div id="image_preview61">
                                                            <img alt="Preview" id="img_pre61">
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                            </div>
                                            <?php
                                                }
                                            ?>
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-hover align-middle mb-0" id="couponsTable">
                                                    <thead class="table-light">
                                                        <tr>
                                                            <th>Coupon Code</th>
                                                            <th>Coupon</th>
                                                            <th>Coupon Value</th>
                                                            <th>Date</th>
                                                            <th>Expiry Date</th>
                                                            <th>Status</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    <?php foreach ($coupons as $coupon): ?>
                                                       
                                                        <tr>
                                                            <td><?= htmlspecialchars($coupon['code']) ?></td>
                                                            <td><?= $customer_type?></td>
                                                            <td>&#8377;<?= $coupon['coupon_amt']?></td>
                                                            <td><?= date('d-m-Y', strtotime($coupon['created_date'])) ?></td>
                                                            <td><?php //echo date('d-m-Y', strtotime($coupon['expiry_date'])) ?> NA</td>
                                                            <td>
                                                                <?php
                                                                    $created_ts = strtotime($coupon['created_date']);
                                                                    // $expiry_ts = strtotime($coupon['expiry_date']);
                                                                    $used_ts = isset($coupon['used_date']) ? strtotime($coupon['used_date']) : null;
                                                                    
                                                                    if ($coupon['usage_status'] == 1 && $used_ts) {
                                                                        echo '<span class="badge bg-danger">Used</span> on ' . date('d-m-Y', $used_ts);
                                                                    } 
                                                                    // elseif ($expiry_ts < time()) {
                                                                    //     echo '<span class="badge bg-secondary">Expired</span> on ' . date('d-m-Y', $expiry_ts);
                                                                    // } 
                                                                    else {
                                                                        echo '<span class="badge bg-success">Unused</span>';
                                                                    }
                                                                ?>

                                                            </td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                        <!-- Example rows, replace with PHP/JS data dynamically -->
                                                        <!-- <tr>
                                                            <td>WELCOME10</td>
                                                            <td>Premium</td>
                                                            <td>01-06-2025</td>
                                                            <td>30-06-2025</td>
                                                            <td><span class="badge bg-success">Unused</span></td>
                                                        </tr>
                                                        <tr>
                                                            <td>SUMMER20</td>
                                                            <td>Premium</td>
                                                            <td>15-05-2025</td>
                                                            <td>17-06-2025</td>
                                                            <td><span class="badge bg-danger">Used</span> on 15-06-2025</td>
                                                        </tr>
                                                        <tr>
                                                            <td>SUMMER21</td>
                                                            <td>Premium</td>
                                                            <td>15-05-2025</td>
                                                            <td>15-06-2025</td>
                                                            <td><span class="badge bg-secondary">Expired</span> on 15-06-2025</td>
                                                        </tr> -->
                                                        <!-- Add more rows dynamically -->
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- coupons only for customers end -->

                                <div class="tab-pane fade show" id="t_c" role="tabpanel">
                                    <div class="card rounded-4">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-12 col-sm-12">
                                                    <div class="input-block mb-3">
                                                        <label class="col-form-label">Terms And Conditions</label>
                                                        <input class="form-control" type="file" name="fileTerms" id="terms_condition" <?php if($row['terms_condition']){echo 'disabled';} ?>>
                                                    </div>
                                                    <input type="hidden" id="img_pathTerms" value="<?php if($row['terms_condition']){echo $row['terms_condition'];} ?>">
                                                    <?php if($row['terms_condition']){ ?>
                                                        <div id="previewTerms">
                                                            <div id="image_previewTerms">
                                                                <img alt="Preview" class="imgSize" id="img_preTerms" width="150px" height="150px" src="../../uploading/<?php echo $row['terms_condition']; ?>">
                                                            </div>
                                                        </div>
                                                    <?php }else{ ?>
                                                        <div id="previewTerms" style = "display:none;">
                                                            <div id="image_previewTerms">
                                                                <img alt="Preview" class="imgSize" id="img_preTerms" width="150px" height="150px">
                                                            </div>
                                                        </div>
                                                    <?php } ?>
                                                </div>
                                                <div class="col-md-12 col-sm-12">
                                                    <div class="d-flex justify-content-center mb-4">
                                                        <button type="submit" class="btn btn-primary px-5 py-2" id="terms_condition_submit" <?php if($row['terms_condition']){echo 'disabled';} ?>>Submit</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php 
                                } 
                            ?>
                            <?php include 'edit_log_history.php' ?>
                            <?php
                                $excludeTables = ['ca_customer', 'institution'];

                                if (!in_array($DBtable, $excludeTables)) {
                                    include 'transfer_log_history.php';
                                }
                            ?>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <?php include_once "../footer.php" ?>
    <input type="hidden" name="user_id" id="user_id" value="<?php echo $id; ?>">
    <input type="hidden" name="user_type" id="user_type" value="<?php echo $user_type??''; ?>">
    <input type="hidden" name="DBtable" id="DBtable" value="<?php echo $DBtable; ?>">
    <!-- END layout-wrapper -->
    <!--start back-to-top-->
    <button onclick="topFunction()" class="scrollToTop scroll-btn show btn" id="back-to-top">
        <i class="mdi mdi-arrow-up"></i>
    </button>
    <!--end back-to-top-->
    <!-- JAVASCRIPT -->
    <script src="../assets/libs/jquery/jquery.min.js"></script>
    <script src="../assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/libs/metismenu/metisMenu.min.js"></script>
    <script src="../assets/libs/simplebar/simplebar.min.js"></script>
    <script src="../assets/libs/node-waves/waves.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <!-- Required datatable js -->
    <script src="../assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="../assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>

    <!-- Responsive examples -->
    <script src="../assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="../assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- App js -->
    <script src="../assets/js/app.js"></script>
    <script src="../../uploading/upload.js"></script>
    <script>
        const cust_id = <?php echo json_encode($id); ?>;
        const selected_div = "<?= $DBtable ?>";
        const id = <?= json_encode($id) ?>;
        const customer_type = <?= json_encode($customer_type) ?>;
    </script>
    <script src="overview.js"></script>
</body>

</html>