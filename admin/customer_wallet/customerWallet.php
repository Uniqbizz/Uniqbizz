<?php
    session_start();
    if(!isset($_SESSION['username'])){
        echo '<script>location.href = "../login.php";</script>';
    }
    require '../connect.php';
    $date = date('Y'); 
?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Customers View | Admin Dashboard </title>
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
        <style>
            .fontSize1 {
                font-size: 12px;
            }
            .fontSize2 {
                font-size: 10px;
            }
            .fontSize3 {
                font-size: 8px;
            }
            .walletIcon1 {
                font-size: 20px !important;
                color: #fff;
                background: #35239a;
                border-radius: 8px;
                padding: 8px 10px;
                width: 45px;
                height: 45px;
            }
            .walletIcon2 {
                font-size: 20px !important;
                color: #fff;
                background: #136bd8;
                border-radius: 8px;
                padding: 8px 10px;
                width: 45px;
                height: 45px;
            }
            .walletIcon3 {
                font-size: 20px !important;
                color: #fff;
                background: #067b40;
                border-radius: 8px;
                padding: 8px 10px;
                width: 45px;
                height: 45px;
            }
            .walletIcon4 {
                font-size: 20px !important;
                color: #fff;
                background: #d54a0a;
                border-radius: 8px;
                padding: 8px 10px;
                width: 45px;
                height: 45px;
            }
            .walletCard1 {
                background: #f5f3fd;
                border: 1px solid #35239a;
            }
            .walletCard2 {
                background: #eaf4ff;
                border: 1px solid #136bd8;
            }
            .walletCard3 {
                background: #ecfff5;
                border: 1px solid #067b40;
            }
            .walletCard4 {
                background: #fff4ef;
                border: 1px solid #d54a0a;
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
                        <div class="">
                            <h2 class="fw-bolder text-dark">Customer Wallet Management</h2>
                            <p class="fs-6 text-muted">
                                Manage, monitor and control all customer wallets from one place.
                            </p>
                        </div>
                        <div class="row">
                            <div class="col-xl-3 col-lg-3">
                                <div class="rounded-3 px-3 py-2 walletCard1">
                                    <div class="d-flex gap-2">
                                        <div class="walletIcon1">
                                            <i class="fa-solid fa-wallet"></i>
                                        </div>
                                        <div class="">
                                            <h1 class="fontSize1 fw-bolder">Total Wallet Balance</h1>
                                            <p class="fs-5 fw-bolder mb-1">&#8377; 12,50,000.00</p>
                                            <p class="fontSize2 text-muted fw-bolder">Across 1,250 customers</p>
                                        </div>
                                    </div>
                                    <p class="text-success fontSize1 mb-0 fw-bolder"><i class="fa-solid fa-arrow-up me-1"></i>12.6% 
                                        <span class="fontSize3 text-muted fw-bolder">vs last month</span>
                                    </p>
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-3">
                                <div class="rounded-3 px-3 py-2 walletCard2">
                                    <div class="d-flex gap-2">
                                        <div class="walletIcon2">
                                            <i class="fa-solid fa-ticket"></i>
                                        </div>
                                        <div class="">
                                            <h1 class="fontSize1 fw-bolder">Total Coupons</h1>
                                            <p class="fs-5 fw-bolder mb-1">15,230</p>
                                            <p class="fontSize2 text-muted fw-bolder">Across all customers</p>
                                        </div>
                                    </div>
                                    <p class="text-success fontSize1 mb-0 fw-bolder"><i class="fa-solid fa-arrow-up me-1"></i>8.3% 
                                        <span class="fontSize3 text-muted fw-bolder">vs last month</span>
                                    </p>
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-3">
                                <div class="rounded-3 px-3 py-2 walletCard3">
                                    <div class="d-flex gap-2">
                                        <div class="walletIcon3">
                                            <i class="fa-solid fa-money-bill-transfer"></i>
                                        </div>
                                        <div class="">
                                            <h1 class="fontSize1 fw-bolder">Pending Withdrawals</h1>
                                            <p class="fs-5 fw-bolder mb-1">&#8377; 2,30,450.00</p>
                                            <p class="fontSize2 text-muted fw-bolder">18 requests pending</p>
                                        </div>
                                    </div>
                                    <p class="text-success fontSize1 mb-0 fw-bolder"><i class="fa-solid fa-arrow-up me-1"></i>9.2% 
                                        <span class="fontSize3 text-muted fw-bolder">vs last month</span>
                                    </p>
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-3">
                                <div class="rounded-3 px-3 py-2 walletCard4">
                                    <div class="d-flex gap-2">
                                        <div class="walletIcon4">
                                            <i class="fa-solid fa-gift"></i>
                                        </div>
                                        <div class="">
                                            <h1 class="fontSize1 fw-bolder">Loyalty Issued (This Month)</h1>
                                            <p class="fs-5 fw-bolder mb-1">&#8377; 1,20,000.00</p>
                                            <p class="fontSize2 text-muted fw-bolder">320 Transactions</p>
                                        </div>
                                    </div>
                                    <p class="text-danger fontSize1 mb-0 fw-bolder"><i class="fa-solid fa-arrow-up me-1"></i>10.1% 
                                        <span class="fontSize3 text-muted fw-bolder">vs last month</span>
                                    </p>
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-3">
                                <div class="rounded-3 px-3 py-2 walletCard2">
                                    <div class="d-flex gap-2">
                                        <div class="walletIcon2">
                                            <i class="fa-solid fa-arrow-trend-up"></i>
                                        </div>
                                        <div class="">
                                            <h1 class="fontSize1 fw-bolder">Extended Wallet Usage</h1>
                                            <p class="fs-5 fw-bolder mb-1">&#8377; 3,40,000.00</p>
                                            <p class="fontSize2 text-muted fw-bolder">45 Adjustments</p>
                                        </div>
                                    </div>
                                    <p class="text-success fontSize1 mb-0 fw-bolder"><i class="fa-solid fa-arrow-up me-1"></i>14.6% 
                                        <span class="fontSize3 text-muted fw-bolder">vs last month</span>
                                    </p>
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
        <div class="btn" data-bs-toggle="modal" data-bs-target="#newCustomerModal" style="width: 25px; height: 25px; padding: 0px; position: fixed; bottom: 120px; right: 43px; border-radius: 50%;">
            <a style="display: flex; justify-content: center; align-items: center; height: -webkit-fill-available;">
                <i class="fa-solid fa-circle-plus fa-beat-fade fa-3x" style="color: #4b38b3;"></i>
            </a>
        </div>
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
                $("#registeredCustomerList-table").DataTable();
                $("#deletedCustomerList-table").DataTable();
            });
            
            function editfuncCust(id,refno,regby,cut,st,ct,editfor){ 
                window.location.href='edit_customers.php?vkvbvjfgfikix='+id+'&nohbref='+refno+'&fyfyfregby='+regby+'&ncy='+cut+'&mst='+st+'&hct='+ct+'&editfor='+editfor;
            };

            function addCustRef(id,fullname,taRef,status){ 
                window.location.href='add_customers.php?id='+id+'&taRef='+taRef+'&fullname='+fullname+'&status='+status;
            };

        </script>
    </body>
</html>