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
            .profileImage {
                width:40px !important;
                height: 40px !important;
                border-radius: 100% !important;
                object-fit: fill;
            }
            .memberShipType {
                width: 90px;
            }
            .textOrange {
                color: #d54a0a;
            }
            .textViolet {
                color: #35239a;
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
                            <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-12 mb-2">
                                <a href="couponWallet.php">
                                    <div class="rounded-3 px-3 py-2 walletCard1">
                                        <div class="d-flex gap-2">
                                            <div class="walletIcon1">
                                                <i class="fa-solid fa-wallet"></i>
                                            </div>
                                            <div class="">
                                                <h1 class="fontSize1 fw-bolder text-dark">Total Wallet Balance</h1>
                                                <p class="fs-5 fw-bolder mb-1 text-dark">&#8377; 12,50,000.00</p>
                                                <p class="fontSize2 text-muted fw-bolder">Across 1,250 customers</p>
                                            </div>
                                        </div>
                                        <p class="text-success fontSize1 mb-0 fw-bolder"><i class="fa-solid fa-arrow-up me-1"></i>12.6% 
                                            <span class="fontSize3 text-muted fw-bolder">vs last month</span>
                                        </p>
                                    </div>
                                </a>
                            </div>
                            <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-12 mb-2">
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
                            <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-12 mb-2">
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
                            <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-12 mb-2">
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
                            <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-12 mb-2">
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
                        <div class="row my-3">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row mb-2 d-flex justify-content-end">
                                            <div class="col-xl-4 col-lg-5 col-md-6 col-sm-8 col-12 d-flex justify-content-between">
                                                <div>
                                                    <select class="form-select mb-3" aria-label="Large select example">
                                                        <option selected>Wallet Type</option>
                                                        <option value="1">All</option>
                                                        <option value="2">Two</option>
                                                        <option value="3">Three</option>
                                                    </select>
                                                </div>
                                                <div>
                                                    <select class="form-select mb-3" aria-label="Large select example">
                                                        <option selected>Status</option>
                                                        <option value="1">All</option>
                                                        <option value="2">Two</option>
                                                        <option value="3">Three</option>
                                                    </select>
                                                </div>
                                                <a href="#">
                                                    <div class="linkBtn gap-2 align-items-center">
                                                        <i class="fa-solid fa-download"></i>
                                                        <p class="fs-6 mb-0 fw-bolder pe-1">Export</p>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="table-responsive">
                                            <table class="table align-middle table-nowrap dt-responsive nowrap w-100" id="pendingCustomerList-table">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th>Customer</th>
                                                        <th>Membership</th>
                                                        <th>Mobile</th>
                                                        <th>Coupon Wallet</th>
                                                        <th>loyalty Coupon</th>
                                                        <th>Referral Wallet</th>
                                                        <th>Discount Wallet</th>
                                                        <th>Extended Wallet</th>
                                                        <th>Status</th>
                                                        <th>Actions</th>
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
                                                            9876543210
                                                        </td>
                                                        <td>
                                                            <div class="">
                                                                <p class="mb-0 fw-bolder fs-6 text-center">3</p>
                                                                <p class="fontSize1 fw-bold mb-0 text-muted text-center">&#8377;15,000</p>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="">
                                                                <p class="mb-0 fw-bolder fs-6 text-center">12</p>
                                                                <p class="fontSize1 fw-bold mb-0 text-success text-center">&#8377;3,500</p>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="">
                                                                <p class="mb-0 fw-bolder fs-6 textOrange text-center">&#8377;2,300.00</p>
                                                                <p class="fontSize1 fw-bold mb-0 text-muted text-center">Withdrawable</p>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <p class="mb-0 fw-bolder fs-6 text-center text-primary">&#8377;1,200.00</p>
                                                        </td>
                                                        <td>
                                                            <p class="mb-0 fw-bolder fs-6 text-center textViolet">&#8377;4,500.00</p>
                                                        </td>
                                                        <td>
                                                            <div class="p-1 text-success-emphasis bg-success-subtle border border-success-subtle rounded-3 text-center fw-bolder memberShipType">
                                                                Active
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="p-1 text-primary-emphasis bg-primary-subtle border border-primary-subtle rounded-3 text-center fw-bolder memberShipType">
                                                                View
                                                            </div>
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
                                                            9876543210
                                                        </td>
                                                        <td>
                                                            <div class="">
                                                                <p class="mb-0 fw-bolder fs-6 text-center">3</p>
                                                                <p class="fontSize1 fw-bold mb-0 text-muted text-center">&#8377;15,000</p>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="">
                                                                <p class="mb-0 fw-bolder fs-6 text-center">12</p>
                                                                <p class="fontSize1 fw-bold mb-0 text-success text-center">&#8377;3,500</p>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="">
                                                                <p class="mb-0 fw-bolder fs-6 textOrange text-center">&#8377;2,300.00</p>
                                                                <p class="fontSize1 fw-bold mb-0 text-muted text-center">Withdrawable</p>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <p class="mb-0 fw-bolder fs-6 text-center text-primary">&#8377;1,200.00</p>
                                                        </td>
                                                        <td>
                                                            <p class="mb-0 fw-bolder fs-6 text-center textViolet">&#8377;4,500.00</p>
                                                        </td>
                                                        <td>
                                                            <div class="p-1 text-success-emphasis bg-success-subtle border border-success-subtle rounded-3 text-center fw-bolder memberShipType">
                                                                Active
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="p-1 text-primary-emphasis bg-primary-subtle border border-primary-subtle rounded-3 text-center fw-bolder memberShipType">
                                                                View
                                                            </div>
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
                                                            9876543210
                                                        </td>
                                                        <td>
                                                            <div class="">
                                                                <p class="mb-0 fw-bolder fs-6 text-center">3</p>
                                                                <p class="fontSize1 fw-bold mb-0 text-muted text-center">&#8377;15,000</p>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="">
                                                                <p class="mb-0 fw-bolder fs-6 text-center">12</p>
                                                                <p class="fontSize1 fw-bold mb-0 text-success text-center">&#8377;3,500</p>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="">
                                                                <p class="mb-0 fw-bolder fs-6 textOrange text-center">&#8377;2,300.00</p>
                                                                <p class="fontSize1 fw-bold mb-0 text-muted text-center">Withdrawable</p>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <p class="mb-0 fw-bolder fs-6 text-center text-primary">&#8377;1,200.00</p>
                                                        </td>
                                                        <td>
                                                            <p class="mb-0 fw-bolder fs-6 text-center textViolet">&#8377;4,500.00</p>
                                                        </td>
                                                        <td>
                                                            <div class="p-1 text-danger-emphasis bg-danger-subtle border border-danger-subtle rounded-3 text-center fw-bolder memberShipType">
                                                                Inactive
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="p-1 text-primary-emphasis bg-primary-subtle border border-primary-subtle rounded-3 text-center fw-bolder memberShipType">
                                                                View
                                                            </div>
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