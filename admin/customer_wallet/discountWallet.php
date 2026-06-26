<?php
    session_start();
    if(!isset($_SESSION['username'])){
        echo '<script>location.href = "../login.php";</script>';
    }
    require '../connect.php';
    $date = date('Y'); 
    $start_date = $_GET['start_date'] ?? '2020-01-01';
    $end_date   = $_GET['end_date'] ?? date('Y-m-d');
    include (__DIR__.'/models/dw_card_data.php'); 
?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Discount Wallet | Admin Dashboard </title>
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
            .fontSize2 {
                font-size: 10px;
            }
            .loyaltyAmt1 {
                color: #35239a;
                background: #e0dbf9;
                padding: 5px;
                display: flex;
                justify-content: center;
                align-items: center;
                width: 45px;
                height: 45px;
                border-radius: 40%;
            }
            .loyaltyAmt2 {
                background-color: #c5f2cd;
                color: #067b40;
                padding: 5px;
                display: flex;
                justify-content: center;
                align-items: center;
                width: 45px;
                height: 45px;
                border-radius: 40%;
            }
            .loyaltyAmt3 {
                color: #fbaa06;
                background: #f3e9ce;
                padding: 5px;
                display: flex;
                justify-content: center;
                align-items: center;
                width: 45px;
                height: 45px;
                border-radius: 40%;
            }
            .loyaltyAmt4 {
                color: #136bd8;
                background: #d2e0f1;
                padding: 5px;
                display: flex;
                justify-content: center;
                align-items: center;
                width: 45px;
                height: 45px;
                border-radius: 40%;
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
            @media (max-width: 687px) {
                /* .discountWallet {
                    display: block !important;
                    margin-bottom: 10px;
                } code by NC*/
                /* code by SV */
                .discountWallet{
                    flex-direction: column;
                    gap: 15px;
                }

                .discountWallet > div:last-child{
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
                        <!-- <div class="d-flex justify-content-between discountWallet">
                            <div>
                                <h2 class="fw-bolder text-dark">Discount Wallet</h2>
                                <p class="fs-6 text-muted">
                                    Manage customer discount balances and usage
                                </p>
                            </div>
                            <div class="d-flex gap-3">
                                <div class="text-end">
                                    <input type="date" value="" min="2020-01" max="" class="rounded-3 border border-secondary-subtle p-2">
                                </div>
                                <a href="#">
                                    <div class="linkBtn gap-2 align-items-center">
                                        <i class="fa-solid fa-download"></i>
                                        <p class="fs-6 mb-0 fw-bolder pe-1">Export Statement</p>
                                    </div>
                                </a>
                            </div>
                        </div> -->
                        <div class="d-flex justify-content-between align-items-start flex-wrap discountWallet">

                            <div class="me-2">
                                <h2 class="fw-bolder text-dark">Discount Wallet</h2>
                                <p class="fs-6 text-muted">
                                    Manage customer discount balances and usage
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
                                <a href="#" id="exportExcel" class="text-decoration-none">
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
                                        <div class="loyaltyAmt4">
                                            <i class="fa-solid fa-wallet fa-xl"></i>
                                        </div>
                                        <div class="">
                                            <h1 class="fontSize1 fw-bolder">Total Discount Wallet Balance</h1>
                                            <p class="fs-4 text-dark fw-bolder mb-1">&#8377;<span class=""><?= number_format($disWalletData['ref_total_earning']) ?></span></p>
                                            <p class="fontSize2 text-muted fw-bolder mb-1">Total Available</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-12">
                                <div class="rounded-3 p-3 card border border-2">
                                    <div class="d-flex gap-2">
                                        <div class="loyaltyAmt2">
                                            <i class="fa-solid fa-user-group fa-xl"></i>
                                        </div>
                                        <div class="">
                                            <h1 class="fontSize1 fw-bolder">Active Customers</h1>
                                            <p class="fs-4 text-dark fw-bolder"><?= number_format($custCountData['total_cust']) ?></p>
                                            <p class="fontSize2 text-muted fw-bolder mb-1">Total Customers</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-12">
                                <div class="rounded-3 p-3 card border border-2">
                                    <div class="d-flex gap-2">
                                        <div class="loyaltyAmt3">
                                            <i class="fa-solid fa-tag fa-xl"></i>
                                        </div>
                                        <div class="">
                                            <h1 class="fontSize1 fw-bolder">Total Discount Used</h1>
                                            <p class="fs-4 text-dark fw-bolder">&#8377;<span class=""><?= number_format($disWalletCurBalData['total_used_amount']) ?></span></p>
                                            <p class="fontSize2 text-muted fw-bolder mb-1">All Time Used</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-12">
                                <div class="rounded-3 p-3 card border border-2">
                                    <div class="d-flex gap-2">
                                        <div class="loyaltyAmt1">
                                            <i class="fa-solid fa-wallet fa-xl"></i>
                                        </div>
                                        <div class="">
                                            <h1 class="fontSize1 fw-bolder">Available Discount Balance</h1>
                                            <p class="fs-4 text-dark fw-bolder">&#8377;<span class=""><?= number_format($disWalletCurBalData['balance']) ?></span></p>
                                            <p class="fontSize2 text-muted fw-bolder mb-1">Ready to Use</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row my-3">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table align-middle table-nowrap dt-responsive nowrap w-100" id="pendingCustomerList-table">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th>Customer</th>
                                                        <th>Membership</th>
                                                        <th>Discount Earned (&#8377;)</th>
                                                        <th>Discount Used (&#8377;)</th>
                                                        <th>Available Balance (&#8377;)</th>
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
                                                            <p class="fontSize1 fw-bold mb-0 text-dark text-center">6,000</p>
                                                        </td>
                                                        <td>
                                                            <p class="fontSize1 fw-bold mb-0 text-warning text-center">4,000</p>
                                                        </td>
                                                        <td>
                                                            <p class="fontSize1 fw-bold mb-0 text-success text-center">2,000</p>
                                                        </td>
                                                        <td>
                                                            <a href="viewDiscountWallet.php" class="">
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
                                                            <p class="fontSize1 fw-bold mb-0 text-dark text-center">6,000</p>
                                                        </td>
                                                        <td>
                                                            <p class="fontSize1 fw-bold mb-0 text-warning text-center">4,000</p>
                                                        </td>
                                                        <td>
                                                            <p class="fontSize1 fw-bold mb-0 text-success text-center">2,000</p>
                                                        </td>
                                                        <td>
                                                            <a href="viewDiscountWallet.php" class="">
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
                                                            <p class="fontSize1 fw-bold mb-0 text-dark text-center">6,000</p>
                                                        </td>
                                                        <td>
                                                            <p class="fontSize1 fw-bold mb-0 text-warning text-center">4,000</p>
                                                        </td>
                                                        <td>
                                                            <p class="fontSize1 fw-bold mb-0 text-success text-center">2,000</p>
                                                        </td>
                                                        <td>
                                                            <a href="viewDiscountWallet.php" class="">
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

            $(function () {

                const urlParams = new URLSearchParams(window.location.search);

                let start = urlParams.get('start_date')
                    ? moment(urlParams.get('start_date'))
                    : moment('2020-01-01');

                let end = urlParams.get('end_date')
                    ? moment(urlParams.get('end_date'))
                    : moment();

                // First page load without dates in URL
                if (!urlParams.has('start_date') || !urlParams.has('end_date')) {

                    window.location.replace(
                        window.location.pathname +
                        '?start_date=' + start.format('YYYY-MM-DD') +
                        '&end_date=' + end.format('YYYY-MM-DD')
                    );

                    return;
                }

                $('#reportrange').daterangepicker({
                    startDate: start,
                    endDate: end,
                    showDropdowns: true,
                    opens: 'left'
                });

                $('#selectedDate').html(
                    start.format('MMMM D, YYYY') +
                    ' - ' +
                    end.format('MMMM D, YYYY')
                );

                $('#reportrange').on('apply.daterangepicker', function (ev, picker) {

                    window.location.href =
                        window.location.pathname +
                        '?start_date=' + picker.startDate.format('YYYY-MM-DD') +
                        '&end_date=' + picker.endDate.format('YYYY-MM-DD');
                });

            });
            $('#pendingCustomerList-table').DataTable({
                processing: true,
                destroy: true,
                responsive: true,

                ajax: {
                    url: 'models/dw_table_data.php',
                    type: 'GET',
                    data: function(d) {

                        const params = new URLSearchParams(window.location.search);

                        d.start_date = params.get('start_date');
                        d.end_date = params.get('end_date');
                    }
                },

                columns: [

                    // Customer
                    {
                        data: null,
                        render: function(data) {

                            let profilePic = data.profile_pic
                                ? '../../uploading/' + data.profile_pic
                                : '../assets/images/users/avatar-7.jpg';

                            return `
                                <div class="d-flex gap-2 align-items-center mb-2">
                                    <div>
                                        <img src="${profilePic}" alt="Customer" class="profileImage">
                                    </div>
                                    <div>
                                        <p class="mb-0 fw-bolder fontSize1">${data.customer_name}</p>
                                        <p class="fontSize1 fw-bold mb-0">${data.ca_customer_id}</p>
                                    </div>
                                </div>
                            `;
                        }
                    },

                    // Membership
                    {
                        data: 'customer_type',
                        render: function(data) {

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

                    // Discount Earned
                    {
                        data: 'total_earned',
                        render: function(data) {
                            return `
                                <p class="fontSize1 fw-bold mb-0 text-dark text-center">
                                    ₹${Number(data || 0).toLocaleString()}
                                </p>
                            `;
                        }
                    },

                    // Discount Used
                    {
                        data: 'used_balance',
                        render: function(data) {
                            return `
                                <p class="fontSize1 fw-bold mb-0 text-warning text-center">
                                    ₹${Number(data || 0).toLocaleString()}
                                </p>
                            `;
                        }
                    },

                    // Available Balance
                    {
                        data: 'available_balance',
                        render: function(data) {
                            return `
                                <p class="fontSize1 fw-bold mb-0 text-success text-center">
                                    ₹${Number(data || 0).toLocaleString()}
                                </p>
                            `;
                        }
                    },

                    // Action
                    {
                        data: null,
                        orderable: false,
                        searchable: false,
                        render: function(data) {
                            return `
                                <form action="viewDiscountWallet.php" method="POST" class="m-0">
                                    <input type="hidden" name="customer_id" value="${data.ca_customer_id}">
                                    <button type="submit"
                                        class="p-1 text-primary-emphasis bg-primary-subtle border border-primary-subtle rounded-3 text-center fw-bolder w-100">
                                        View
                                    </button>
                                </form>
                            `;
                        }
                    }
                ]
            });
            $('#exportExcel').on('click', function () {

                const params = new URLSearchParams(window.location.search);

                const startDate = params.get('start_date') || '';
                const endDate = params.get('end_date') || '';

                window.location.href =
                    'models/dw_export_excel.php?start_date=' +
                    encodeURIComponent(startDate) +
                    '&end_date=' +
                    encodeURIComponent(endDate);
            });
        </script>
    </body>
</html>