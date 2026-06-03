<?php
    session_start();
    if(!isset($_SESSION['username'])){
        echo '<script>location.href = "../login.php";</script>';
    }
    require '../connect.php';
    $date = date('Y'); 
    include (__DIR__.'/models/rw_card_data.php'); 
?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Referral Wallet | Admin Dashboard </title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- App favicon -->
        <link rel="shortcut icon" href="../assets/images/fav.png">
        <!-- bootstrap-datepicker css -->
        <link href="../assets/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css">
        <!-- DataTables -->
        <link href="../assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
        <!-- Responsive datatable examples -->
        <link href="../assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />  
        <!-- Bootstrap Css -->
        <link href="../assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
        <!-- Icons Css -->
        <link href="../assets/css/icons.min.css" rel="stylesheet" type="text/css" />
        <!-- App Css-->
        <link href="../assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />
        <!-- Loading Screen and Images size css  -->
        <link rel="stylesheet" href="../assets/css/loadingScreen.css" rel="stylesheet" type="text/css" />
        <!-- App js -->
        <!-- <script src="../assets/js/plugin.js"></script> -->

        <!-- Font awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <!-- added on 02-06-2026  by SV-->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css">
        <!-- added on 02-06-2026  by SV End-->
        <style>
            .fontSize1 {
                font-size: 12px;
            }
            .walletIcon1 {
                font-size: 20px !important;
                color: #fff;
                background: #35239a;
                border-radius: 8px;
                display: flex;
                justify-content: center;
                align-items: center;
                width: 45px;
                height: 45px;
            }
            .walletIcon2 {
                font-size: 20px !important;
                color: #fff;
                background: #136bd8;
                border-radius: 8px;
                display: flex;
                justify-content: center;
                align-items: center;
                width: 45px;
                height: 45px;
            }
            .walletIcon3 {
                font-size: 20px !important;
                color: #fff;
                background: #067b40;
                border-radius: 8px;
                display: flex;
                justify-content: center;
                align-items: center;
                width: 45px;
                height: 45px;
            }
            .walletIcon4 {
                font-size: 20px !important;
                color: #fff;
                background: #fbaa06;
                border-radius: 8px;
                display: flex;
                justify-content: center;
                align-items: center;
                width: 45px;
                height: 45px;
            }
            .walletIcon5 {
                font-size: 20px !important;
                color: #fff;
                background: #fb7c06;
                border-radius: 8px;
                display: flex;
                justify-content: center;
                align-items: center;
                width: 45px;
                height: 45px;
            }
            .profileImage {
                width:40px !important;
                height: 40px !important;
                border-radius: 100% !important;
                object-fit: fill;
            }
            .linkBtn {
                background-color: #fff;
                color:#4b38b3;
                border: 2px solid #4b38b3;
                padding: 6px 12px;
                border-radius: 6px;
                display: flex;
                justify-content: center;
            }
            .linkBtn:hover {
                background-color: #4b38b3;
                border: 2px solid #4b38b3;
                color:#fff;
                padding: 6px 12px;
                border-radius: 6px;
                display: flex;
                justify-content: center;
            }
            @media (max-width: 770px) {
                /* code by NC */
                /* .referralWallet {
                    display: block !important;
                    margin-bottom: 10px;
                } */
                /* end code by NC */
                /* code by SV */
                .referralWallet{
                    flex-direction: column;
                    gap: 15px;
                }

                .referralWallet > div:last-child{
                    width: 100%;
                    flex-direction: column;
                }

                #reportrange{
                    width: 100%;
                }

                .linkBtn{
                    width: 100%;
                    justify-content: center;
                }
                /* end code by SV */
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
                <div class="page-content">
                    <div class="container-fluid">
                        <div class="d-inline-block" onclick="history.back()" style="cursor:pointer;">
                            <div class="viewBtn rounded-2 py-2">
                                <p class="text-muted mb-0 fw-bolder">
                                    <i class="fa-solid fa-arrow-left me-2 fw-bolder"></i>
                                    Back to Customer Wallet Management
                                </p>
                            </div>
                        </div>
                        <!-- Date Range -->
                        <!-- <div class="d-flex justify-content-between referralWallet">
                            <div>
                                <h2 class="fw-bolder text-dark">Referral Wallet</h2>
                                <p class="fs-6 text-muted">
                                    Manage customer referral earnings, balances and usage
                                </p>
                            </div>
                            <div class="d-flex gap-3">
                                <div class="col-12 col-md-6 col-lg-5">
                                    <div id="reportrange"
                                        class="bg-primary text-white px-3 py-2 text-center dateRange w-100"
                                        style="border-radius:6px; cursor:pointer;">
                                        <i class="fa fa-calendar"></i>
                                        &nbsp;
                                        <span id="selectedDate"></span>
                                        <i class="fa-solid fa-angle-down"></i>
                                    </div>
                                </div>
                                <a href="#">
                                    <div class="linkBtn gap-2 align-items-center">
                                        <i class="fa-solid fa-download"></i>
                                        <p class="fs-6 mb-0 fw-bolder pe-1">Export Statement</p>
                                    </div>
                                </a>
                            </div>
                        </div> -->
                        <!-- /* code by SV */ -->
                        <div class="d-flex justify-content-between align-items-start flex-wrap referralWallet">

                            <div class="me-2">
                                <h2 class="fw-bolder text-dark">Referral Wallet</h2>
                                <p class="fs-6 text-muted">
                                    Manage customer referral earnings, balances and usage
                                </p>
                            </div>

                            <div class="d-flex gap-3 align-items-stretch flex-grow-1 justify-content-end">

                                <!-- Date Range -->
                                <div class="flex-grow-1" style="max-width:500px;">
                                    <div id="reportrange"
                                        class="bg-primary text-white px-3 py-2 d-flex justify-content-between align-items-center h-100"
                                        style="border-radius:6px; cursor:pointer; min-height:56px;">
                                        
                                        <div>
                                            <i class="fa fa-calendar me-2"></i>
                                            <span id="selectedDate"></span>
                                        </div>

                                        <i class="fa-solid fa-angle-down"></i>
                                    </div>
                                </div>
                                <!-- Export -->
                                <a href="#" class="text-decoration-none">
                                    <div class="linkBtn d-flex align-items-center gap-2 px-4 h-100">
                                        <i class="fa-solid fa-download"></i>
                                        <p class="fs-6 mb-0 fw-bolder">Export Statement</p>
                                    </div>
                                </a>


                            </div>
                            <!-- /* end code by SV */ -->

                        </div>
                        <div class="row">
                            <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-12">
                                <div class="rounded-3 p-3 card border border-2">
                                    <div class="d-flex gap-2">
                                        <div class="walletIcon1">
                                            <i class="fa-solid fa-wallet"></i>
                                        </div>
                                        <div class="">
                                            <h1 class="fs-6 fw-bolder">Total Referral Wallet Balance</h1>
                                            <p class="fs-4 text-dark fw-bolder mb-1">&#8377;
                                                <span class="">
                                                    <?= number_format(
                                                        ($refWalletData['ref_total_earning'] ?? 0) +
                                                        ($refWalletCurBalData['ref_booking_total'] ?? 0)
                                                    ) ?>
                                                </span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-12">
                                <div class="rounded-3 p-3 card border border-2">
                                    <div class="d-flex gap-2">
                                        <div class="walletIcon2">
                                            <i class="fa-solid fa-user-group"></i>
                                        </div>
                                        <div class="">
                                            <h1 class="fs-6 fw-bolder">Total Customers</h1>
                                            <p class="fs-4 text-dark fw-bolder">
                                                    <?= number_format($custCountData['total_cust']) ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-12">
                                <div class="rounded-3 p-3 card border border-2">
                                    <div class="d-flex gap-2">
                                        <div class="walletIcon3">
                                            <i class="fa-solid fa-wallet"></i>
                                        </div>
                                        <div class="">
                                            <h1 class="fs-6 fw-bolder">Available Balance</h1>
                                            <p class="fs-4 text-dark fw-bolder">&#8377;<span class=""><?= number_format($refWalletCurBalData['total_balance'] ?? 0) ?></span></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-12">
                                <div class="rounded-3 p-3 card border border-2">
                                    <div class="d-flex gap-2">
                                        <div class="walletIcon5">
                                            <i class="fa-solid fa-wallet"></i>
                                        </div>
                                        <div class="">
                                            <h1 class="fs-6 fw-bolder">Used Balance</h1>
                                            <p class="fs-4 text-dark fw-bolder">&#8377;<span class=""><?= number_format($refWalletCurBalData['total_used_amount']) ?></span></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-12">
                                <div class="rounded-3 p-3 card border border-2">
                                    <div class="d-flex gap-2">
                                        <div class="walletIcon4">
                                            <i class="fa-regular fa-clock"></i>
                                        </div>
                                        <div class="">
                                            <h1 class="fs-6 fw-bolder">Pending Withdrawals</h1>
                                            <p class="fs-4 text-dark fw-bolder">&#8377;<span class=""><?= number_format($refWalletEncashData['total_earning_pending'] ?? 0) ?></span></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table align-middle table-nowrap dt-responsive nowrap w-100" id="pendingCustomerList-table">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th>Customer</th>
                                                        <th>Membership</th>
                                                        <th>Total Earned</th>
                                                        <th>Available Balance</th>
                                                        <th>Used Balance</th>
                                                        <th>Pending Withdrawal</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            <div class="d-flex gap-2 align-items-center mb-2">
                                                                <div class="">
                                                                    <img src="../assets/images/users/avatar-7.jpg" alt="Package" class="profileImage">
                                                                </div>
                                                                <div class="">
                                                                    <p class="mb-0 fw-bolder fontSize1">Rahul Mehta</p>
                                                                    <p class="fontSize1 fw-bold mb-0">CUST10001</p>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="p-1 text-success-emphasis bg-success-subtle border border-success-subtle rounded-3 text-center fw-bolder">
                                                                Neo Select
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <p class="mb-0 fw-bolder fs-6 text-center">&#8377;12,500</p>
                                                        </td>
                                                        <td>
                                                            <p class="mb-0 fw-bolder fs-6 text-center">&#8377;4,500</p>
                                                        </td>
                                                        <td>
                                                            <p class="mb-0 fw-bolder fs-6 text-center">&#8377;8,000</p>
                                                        </td>
                                                        <td>
                                                            <p class="mb-0 fw-bolder fs-6 text-center">&#8377;2,000</p>
                                                        </td>
                                                        <td>
                                                            <a href="viewReferralWallet.php" class="">
                                                                <div class="p-1 text-primary-emphasis bg-primary-subtle border border-primary-subtle rounded-3 text-center fw-bolder">
                                                                    View
                                                                </div>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <div class="d-flex gap-2 align-items-center mb-2">
                                                                <div class="">
                                                                    <img src="../assets/images/users/avatar-7.jpg" alt="Package" class="profileImage">
                                                                </div>
                                                                <div class="">
                                                                    <p class="mb-0 fw-bolder fontSize1">Rahul Mehta</p>
                                                                    <p class="fontSize1 fw-bold mb-0">CUST10001</p>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="p-1 text-primary-emphasis bg-primary-subtle border border-primary-subtle rounded-3 text-center fw-bolder">
                                                                Neo Select Plus
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <p class="mb-0 fw-bolder fs-6 text-center">&#8377;12,500</p>
                                                        </td>
                                                        <td>
                                                            <p class="mb-0 fw-bolder fs-6 text-center">&#8377;4,500</p>
                                                        </td>
                                                        <td>
                                                            <p class="mb-0 fw-bolder fs-6 text-center">&#8377;8,000</p>
                                                        </td>
                                                        <td>
                                                            <p class="mb-0 fw-bolder fs-6 text-center">&#8377;2,000</p>
                                                        </td>
                                                        <td>
                                                            <a href="viewReferralWallet.php" class="">
                                                                <div class="p-1 text-primary-emphasis bg-primary-subtle border border-primary-subtle rounded-3 text-center fw-bolder">
                                                                    View
                                                                </div>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <div class="d-flex gap-2 align-items-center mb-2">
                                                                <div class="">
                                                                    <img src="../assets/images/users/avatar-7.jpg" alt="Package" class="profileImage">
                                                                </div>
                                                                <div class="">
                                                                    <p class="mb-0 fw-bolder fontSize1">Rahul Mehta</p>
                                                                    <p class="fontSize1 fw-bold mb-0">CUST10001</p>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="p-1 text-warning-emphasis bg-warning-subtle border border-warning-subtle rounded-3 text-center fw-bolder">
                                                                Neo Premium
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <p class="mb-0 fw-bolder fs-6 text-center">&#8377;12,500</p>
                                                        </td>
                                                        <td>
                                                            <p class="mb-0 fw-bolder fs-6 text-center">&#8377;4,500</p>
                                                        </td>
                                                        <td>
                                                            <p class="mb-0 fw-bolder fs-6 text-center">&#8377;8,000</p>
                                                        </td>
                                                        <td>
                                                            <p class="mb-0 fw-bolder fs-6 text-center">&#8377;2,000</p>
                                                        </td>
                                                        <td>
                                                            <a href="viewReferralWallet.php" class="">
                                                                <div class="p-1 text-primary-emphasis bg-primary-subtle border border-primary-subtle rounded-3 text-center fw-bolder">
                                                                    View
                                                                </div>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> <!-- container-fluid -->
                </div> <!-- End Page-content -->

                
                <?php include_once "../footer.php" ?>
            </div>
            <!-- end main content-->
        </div>
        <!-- END layout-wrapper -->

        <!-- loading screen -->
        <div id="loading-overlay">
            <div class="loading-icon"></div>
        </div>
        <!-- Add button icon -->
        <!-- <div class="btn" data-bs-toggle="modal" data-bs-target="#newCustomerModal" style="width: 25px; height: 25px; padding: 0px; position: fixed; bottom: 120px; right: 43px; border-radius: 50%;">
            <a style="display: flex; justify-content: center; align-items: center; height: -webkit-fill-available;">
                <i class="fa-solid fa-circle-plus fa-beat-fade fa-3x" style="color: #4b38b3;"></i>
            </a>
        </div> -->
        <!-- End button icon -->
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
        <!-- bootstrap-datepicker js -->
        <script src="../assets/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>

        <!-- Required datatable js -->
        <script src="../assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
        <script src="../assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
        
        <!-- Responsive examples -->
        <script src="../assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
        <script src="../assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>
        
        <!-- ecommerce-customer-list init -->
        <!-- <script src="../assets/js/pages/ecommerce-customer-list.init.js"></script> -->
        
        <!-- App js -->
        <script src="../assets/js/app.js"></script>
        <!-- add on 02-06-2026 by SV -->
        <script src="https://cdn.jsdelivr.net/npm/moment/min/moment.min.js"></script>

        <script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
        <!-- add on 02-06-2026 by SV END-->
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
            }
            );

        </script>

        <!-- dataTable -->
        <script>
            $(document).ready(function(){
                $("#pendingCustomerList-table").DataTable();
            });
            
            function editfuncCust(id,refno,regby,cut,st,ct,editfor){ 
                window.location.href='edit_customers.php?vkvbvjfgfikix='+id+'&nohbref='+refno+'&fyfyfregby='+regby+'&ncy='+cut+'&mst='+st+'&hct='+ct+'&editfor='+editfor;
            };

            function addCustRef(id,fullname,taRef,status){ 
                window.location.href='add_customers.php?id='+id+'&taRef='+taRef+'&fullname='+fullname+'&status='+status;
            };
            //date range filter
            $(function () {

                let firstLoad = true;

                const urlParams = new URLSearchParams(window.location.search);

                let start = urlParams.get('start_date')
                    ? moment(urlParams.get('start_date'))
                    : moment('2020-01-01');

                let end = urlParams.get('end_date')
                    ? moment(urlParams.get('end_date'))
                    : moment();

                function cb(start, end) {

                    $('#selectedDate').html(
                        start.format('MMMM D, YYYY') +
                        ' - ' +
                        end.format('MMMM D, YYYY')
                    );

                    window.startDate = start.format('YYYY-MM-DD');
                    window.endDate = end.format('YYYY-MM-DD');

                    // Prevent redirect on initial load
                    if (firstLoad) {
                        firstLoad = false;
                        return;
                    }

                    const newUrl =
                        window.location.pathname +
                        '?start_date=' + window.startDate +
                        '&end_date=' + window.endDate;

                    window.location.href = newUrl;
                }

                $('#reportrange').daterangepicker({

                    startDate: start,
                    endDate: end,

                    showDropdowns: true,
                    opens: 'left',

                    ranges: {

                        'Today': [
                            moment(),
                            moment()
                        ],

                        'Yesterday': [
                            moment().subtract(1, 'days'),
                            moment().subtract(1, 'days')
                        ],

                        'Last 7 Days': [
                            moment().subtract(6, 'days'),
                            moment()
                        ],

                        'Last 30 Days': [
                            moment().subtract(29, 'days'),
                            moment()
                        ],

                        'This Month': [
                            moment().startOf('month'),
                            moment().endOf('month')
                        ],

                        'Last Month': [
                            moment().subtract(1, 'month').startOf('month'),
                            moment().subtract(1, 'month').endOf('month')
                        ],

                        'Last Year': [
                            moment().subtract(1, 'year').startOf('year'),
                            moment().subtract(1, 'year').endOf('year')
                        ]
                    }

                }, cb);

                cb(start, end);

            });
            $('#reportrange').on('change', function () {

                const newUrl =
                    window.location.pathname +
                    '?start_date=' + window.startDate +
                    '&end_date=' + window.endDate;

                window.location.href = newUrl;

            });
            $('#pendingCustomerList-table').DataTable({
                processing: true,
                destroy: true,
                responsive: true,

                ajax: {
                    url: 'models/rw_table_data.php',
                    type: 'GET',
                    data: function(d){

                        const params = new URLSearchParams(window.location.search);

                        d.start_date = params.get('start_date');
                        d.end_date   = params.get('end_date');
                    }
                },

                columns: [

                    {
                        data: null,
                        render: function(data){
                            
                            let profilePic = data.profile_pic
                                ? '../../uploading/'+data.profile_pic
                                : '../assets/images/users/avatar-7.jpg';

                            return `
                                <div class="d-flex gap-2 align-items-center mb-2">
                                    <div>
                                        <img src="${profilePic}" class="profileImage">
                                    </div>
                                    <div>
                                        <p class="mb-0 fw-bolder fontSize1">${data.customer_name}</p>
                                        <p class="fontSize1 fw-bold mb-0">${data.ca_customer_id}</p>
                                    </div>
                                </div>
                            `;
                        }
                    },

                    {
                        data: 'customer_type',
                        render: function(data){
                            const classes = {
                                'Premium Select Lite': 'secondary',
                                'Neo Select': 'success',
                                'Neo Select Ultra': 'primary',
                                'Premium': 'warning',
                                'Premium Plus': 'danger',
                                'Premium Select': 'info',
                                'Prime': 'dark'
                            };

                            const badgeClass = classes[data] || 'secondary';
                            return `
                                <div class="p-1 text-${badgeClass}-emphasis bg-${badgeClass}-subtle border border-${badgeClass}-subtle rounded-3 text-center fw-bolder">
                                    ${data}
                                </div>
                            `;
                        }
                    },

                    {
                        data: 'total_earned',
                        render: function(data){
                            return `<p class="mb-0 fw-bolder fs-6 text-center">₹${Number(data).toLocaleString()}</p>`;
                        }
                    },

                    {
                        data: 'available_balance',
                        render: function(data){
                            return `<p class="mb-0 fw-bolder fs-6 text-center">₹${Number(data).toLocaleString()}</p>`;
                        }
                    },

                    {
                        data: 'used_balance',
                        render: function(data){
                            return `<p class="mb-0 fw-bolder fs-6 text-center">₹${Number(data).toLocaleString()}</p>`;
                        }
                    },

                    {
                        data: 'pending_withdrawal',
                        render: function(data){
                            return `<p class="mb-0 fw-bolder fs-6 text-center">₹${Number(data).toLocaleString()}</p>`;
                        }
                    },

                    {
                        data: 'ca_customer_id',
                        render: function(data){
                            return `
                                <form action="viewReferralWallet.php" method="POST" class="m-0">
                                    <input type="hidden" name="customer_id" value="${data}">
                                    <button type="submit" class="p-1 text-primary-emphasis bg-primary-subtle border border-primary-subtle rounded-3 text-center fw-bolder w-100">
                                        View
                                    </button>
                                </form>
                            `;
                        }
                    }
                ]
            });
        </script>
    </body>
</html>