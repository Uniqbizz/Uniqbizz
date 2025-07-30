<?php
session_start();

if (!isset($_SESSION['username'])) {
    echo '<script>location.href = "../login.php";</script>';
}

require '../connect.php';
$date = date('Y');
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Business Mentor | Admin Dashboard </title>
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
        /* dataTable, action col, dropdown align right  */

        @media screen and (max-width: 1191px) {
            .dropdown-menu-end-1[style] {
                left: 25% !important;
                right: 25% !important;
            }
        }

        @media screen and (max-width: 991px) and (min-width: 941px) {
            .dropdown-menu-end-1[style] {
                left: -250% !important;
                right: -250% !important;
                width: 80px !important;
            }
        }

        @media screen and (max-width: 1345px) and (min-width: 1264px) {
            .dropdown-menu-end-2[style] {
                left: 25% !important;
                right: 25% !important;
            }
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
                    <div id="view_payout">
                        <!-- <div class="sb2-2-2">
                                <ul>
                                    <li><a href="../"><i class="fa fa-home" aria-hidden="true"></i> Home</a></li>
                                    <li class="active-bre"><a href="#">Club Payouts </a></li>
                                    <li class="page-back"><a href="../"><i class="fa fa-backward" aria-hidden="true"></i> Back</a></li>
                                </ul>
                            </div> -->
                        <div class="row" id="searchsection">
                            <div class="col-md-12">
                                <div class="card rounded-4">
                                    <div class="p-3 pb-0">
                                        <h4>Monthly Payout Details</h4>
                                    </div>
                                    <div class="p-3 pt-0">
                                        <form>
                                            <div class="row">

                                                <div class="col-md-6 col-sm-6 col-12 pt-3">
                                                    <label class="form-label"> Designation</label>
                                                    <select class="form-select" id="designation" aria-label="Default select example">
                                                        <option selected>--Select Designation--</option>
                                                        <option value="bm" onchange="showUserDetails(); return false;">Business Mentor</option>
                                                        <option value="bdm">Business Developemnt Manager</option>
                                                        <option value="bcm">Business Channel Head</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-6 col-sm-6 col-12 pt-3">
                                                    <label class="form-label">User ID & Name</label>
                                                    <select id="user_id_name" class="form-select">
                                                        <option value="">--Select Designation First--</option>
                                                    </select>
                                                </div>

                                                <div class="col-md-6 col-sm-6 col-12 pt-3" id="payout_status_field">
                                                    <label class="form-label">Payout Status</label>
                                                    <select id="payout_status" class="form-select" aria-label="Default select example">
                                                        <option value="">--Select Payout Status--</option>
                                                        <option value="0">Payout Pending</option>
                                                        <option value="1">Payout Completed</option>
                                                        <option value="2">View All Payouts</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-6 col-sm-6 col-12 pt-3" id="payout_type_field" style="display:none">
                                                    <label class="form-label"> Payout Type</label>
                                                    <select id="payout_type" class="form-select" aria-label="Default select example">
                                                        <option value="monthly">Monthly Payout</option>
                                                        <!-- <option value="all">View All Payout</option> -->
                                                    </select>
                                                </div>
                                                <div class="col-md-6 col-sm-6 col-12 pt-3" id="month_year_field">
                                                    <label for="month_year" id="month_year_title" class="form-label">Select Month & Year</label>
                                                    <input type="month" class="form-control" id="month_year" name="month_year" min="2018-1" max="" value="">
                                                    <div id="error-message1" style="display:none; color: #f31e1e; font-weight: 500;">Error-Message</div>
                                                </div>
                                                <div class="col-md-6 col-sm-6 col-12" id="active_customer_field" style="display:none">
                                                    <label for="active_customers" class="form-label pt-3">Active Techo enterprise</label>
                                                    <input id="active_customers" class="form-control" type="text" placeholder=" " value=" " readonly>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6 col-sm-6 col-12 pt-3">
                                                    <Label class="btn btn-success rounded-3"><a href="#" class="text-white" onclick="showUserDetails(); return false;"> CLICK to Display User Details </a></Label>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row" id="user_details" style="display: none;">
                            <div class="col-md-12">
                                <div class="card rounded-4">
                                    <div class="p-3">
                                        <h4> User Details
                                            <a href="#" class="text-dark fw-bolder float-end" onclick="showUserDetails(); return false;"> X </a>
                                        </h4>
                                    </div>
                                    <form>
                                        <div class="row p-3 pt-0">
                                            <div class="col-md-6 col-sm-6 col-12">
                                                <label class="form-label pt-3" for="user_name">ID & Name</label>
                                                <input id="user_name" type="text" placeholder=" " class="form-control" readonly>
                                            </div>
                                            <div class="col-md-6 col-sm-6 col-12">
                                                <label class="form-label pt-3" for="address">Address</label>
                                                <input id="address" type="text" placeholder=" " class="form-control" readonly>
                                            </div>
                                            <div class="col-md-6 col-sm-6 col-12">
                                                <label class="form-label pt-3" for="email">Email</label>
                                                <input id="email" type="email" placeholder=" " class="form-control" readonly>
                                            </div>
                                            <div class="col-md-6 col-sm-6 col-12">
                                                <label class="form-label pt-3" for="mobile">Phone No.</label>
                                                <input id="mobile" type="text" placeholder=" " class="form-control" readonly>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- bdm list -->
                        <div class="row d-none" id="bdm_list">
                            <div class="col-md-12">
                                <div class="card rounded-4">
                                    <div class="p-3">
                                        <h4>
                                            BDM List
                                        </h4>
                                    </div>
                                    <div class="p-3 pt-0">
                                        <div class="table-responsive table-desi">
                                            <table class="table table-hover" id="bdmTable">
                                                <thead class="text-center">
                                                    <tr>
                                                        <th >Sr.No.</th>
                                                        <th >ID</th>
                                                        <th >Name</th>
                                                        <th >Active Techno Enterprise</th>
                                                    </tr>
                                                </thead>
                                                <tbody >
                                                    
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- bm list -->
                        <div class="row d-none" id="bm_list">
                            <div class="col-md-12">
                                <div class="card rounded-4">
                                    <div class="p-3">
                                        <h4>
                                            BM List
                                        </h4>
                                    </div>
                                    <div class="p-3 pt-0">
                                        <div class="table-responsive table-desi">
                                            <table class="table table-hover" id="bmTable">
                                                <thead class="text-center">
                                                    <tr>
                                                        <th >Sr.No.</th>
                                                        <th >ID</th>
                                                        <th >Name</th>
                                                        <th >Active Techno Enterprise</th>
                                                    </tr>
                                                </thead>
                                                <tbody >
                                                   
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="card rounded-4">
                                    <div class="p-3">
                                        <h4>
                                            Payout List
                                            <div class="row" id="generate_payout" style="float: right; display:none">
                                                Generate Payout
                                                <span class="payout_btn" id="generate_payout_button"> MAKE PAYOUT </span>
                                            </div>
                                            <div class="row" id="get_total_payout" style="float: right; "></div>
                                        </h4>
                                    </div>
                                    <div class="p-3 pt-0">
                                        <div class="table-responsive table-desi">
                                            <table class="table table-hover" id="userTable">
                                                <thead class="text-center">
                                                    <tr>
                                                        <th id="col_1">Sr.No.</th>
                                                        <th id="col_2">ID</th>
                                                        <th id="col_3">Payout Message</th>
                                                        <th>Payout Amount</th>
                                                        <th>TDS (2%)</th>
                                                        <th>Total</th>
                                                        <th>Action</th>
                                                        <th>Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="text-center">

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card rounded-4 d-none" id="view_payout_details">
                        <div class="sb2-2-3">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="box-inn-sp">
                                        <div class="p-3">
                                            <h4 id="payout_title">Payout</h4>
                                        </div>
                                        <div class="p-3 d-flex justify-content-end">
                                            <button class="rounded-pill bg-primary border-0 text-white px-3 py-1" onclick="hidepayoutdetails()">Back</button>
                                        </div>
                                        <div class="row m-0">
                                            <div class="col-md-6 col-sm-6 col-5 d-flex align-items-end">
                                                <div>
                                                    <button id="payment_status" class="btn btn-primary rounded-3">Status</button>
                                                </div>
                                            </div>
                                            <div id="payment_btn" class="col-md-6 col-sm-6 col-7">
                                                <div class="text-end">
                                                    <div id="get_net_payable_title" class="fw-bolder"> Amount to be paid :</div>
                                                    <button id='paybtn' type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#show_payment_box">
                                                        <a href="#" onclick="paymentType();" class="text-white">Pay ₹ <span id="get_net_payable"></span>/-</a>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- <div class="tab-inn"> -->
                                        <form class="p-3">
                                            <input class="form-control" id="get_payout" type="hidden" value="club" readonly>
                                            <input class="form-control" id="clubPriceDistribution_booking_Id" type="hidden" value="" readonly>

                                            <input class="form-control" id="ca_user_id" type="hidden" value="" readonly>
                                            <input class="form-control" id="c_lname" type="hidden" value="" readonly>
                                            <input class="form-control" id="c_contact" type="hidden" value="" readonly>
                                            <input class="form-control" id="c_level" type="hidden" value="" readonly>
                                            <input class="form-control" id="c_total" type="hidden" value="" readonly>
                                            <input class="form-control" id="c_payout_of" type="hidden" value="" readonly>

                                            <div class="row">
                                                <div class="col-md-6 col-sm-6 col-12 pt-3">
                                                    <label class="form-label" for="c_id" id="c_id_title">ID</label>
                                                    <input class="form-control" id="c_id" type="text" value=" " readonly>
                                                </div>
                                                <div class="col-md-6 col-sm-6 col-12 pt-3">
                                                    <label class="form-label" for="c_name" id="c_name_title">Name</label>
                                                    <input class="form-control" id="c_name" type="text" value=" " readonly>
                                                </div>
                                                <div class="col-md-6 col-sm-6 col-12 pt-3">
                                                    <label class="form-label" for="c_mobile">Phone No.</label>
                                                    <input class="form-control" id="c_mobile" type="text" value=" " readonly>
                                                </div>
                                                <div class="col-md-6 col-sm-6 col-12 pt-3">
                                                    <label class="form-label" for="c_email">Email ID</label>
                                                    <input class="form-control" id="c_email" type="email" value="  " readonly>
                                                </div>
                                                <div class="col-md-6 col-sm-6 col-12 pt-3" id="payout_earned_field">
                                                    <label class="form-label" for="payout_earned">Payout Earned</label>
                                                    <input class="form-control" id="payout_earned" type="text" value=" " readonly>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6 col-sm-6 col-12 pt-3">
                                                    <label class="form-label" for="c_tds">TDS </label>
                                                    <input class="form-control" id="c_tds" type="text" value=" " readonly>
                                                </div>
                                                <div class="col-md-6 col-sm-6 col-12 pt-3">
                                                    <label class="form-label" for="c_amount_share" id="c_amount_share_title">Total Payble Amount</label>
                                                    <input class="form-control" id="c_amount_share" type="text" value=" " readonly>
                                                </div>

                                            </div>
                                            <div class="row" id="club_transc_mode">
                                                <div class="col-md-6 col-sm-6 col-12 pt-3">
                                                    <label class="form-label" for="c_trans_id">Payment ID</label>
                                                    <input class="form-control" id="c_trans_id" type="text" value=" " readonly>
                                                </div>
                                                <div class="col-md-6 col-sm-6 col-12 pt-3">
                                                    <label class="form-label" for="c_trans_mode">Payment Date</label>
                                                    <input class="form-control" id="c_trans_mode" type="text" value=" " readonly>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6 col-sm-6 col-12 pt-3">
                                                    <label class="form-label" for="c_message" id="c_message_title">Message</label>
                                                    <input class="form-control" id="c_message" type="text" value=" " readonly>
                                                </div>
                                            </div>
                                        </form>
                                        <!-- </div> -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Modal for payment type-->
                    <!-- <div class="modal-dialog modal-dialog-centered" id="show_payment_box">
                            <div class="modal-content">
                                <div class=" modal-header">
                                    <div class="d-flex justify-content-center">
                                        <h5 class="modal-title" id="exampleModalCenterTitle">Payment Type</h5>
                                        <a href="#" id="cancel_payment" class="btn-blue xs_padding"><span aria-hidden="true"><i class="fa fa-times" aria-hidden="true"></i></span></a>
                                    </div>
                                </div>   
                                <div class="modal-body">
                                    <input id="payment_message" type="text" value=" " >
                                    <label for="payment_message" >Message (optional)</label>
                                </div>   
                                
                                    <div class="row">
                                        <div c>
                                            
                                        </div>
                                    </div>
                                
                                    <a href="#" onclick="makePayment('block');"  class="custom_btn btn3" style="float:right; margin:5px;">Block Payment</a>
                                    <a href="#" onclick="makePayment('online');"  class="custom_btn btn1" style="float:right; margin:5px;">Online Mode</a>
                                    <a href="#" onclick="makePayment('offline');"  class="custom_btn btn2" style="float:right; margin:5px;">Offline Mode</a>
                                        
                            </div>
                        </div> -->

                    <div class="modal fade" id="show_payment_box" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog modal-dialog-centered modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalCenterTitle">Payment</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    <!-- <a href="#" id="cancel_payment" class="btn-blue xs_padding"><span aria-hidden="true"><i class="fa fa-times" aria-hidden="true"></i></span></a> -->
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label for="payment_message" class="form-label">Payment Message</label>
                                        <input type="text" class="form-control" id="payment_message" value="">
                                        <label for="payment_date" class="form-label">Payment date</label>
                                        <input type="date" class="form-control" id="payment_date" value="">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <!-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="button" class="btn btn-primary">Save changes</button> -->
                                    <button class="btn p-2 rounded-3 bg-danger">
                                        <a href="#" onclick="makePayment('block');" class="text-white custom_btn btn3">Block Payment</a>
                                    </button>
                                    <button class="btn p-2 rounded-3 bg-warning">
                                        <a href="#" onclick="makePayment('online');" class="text-white custom_btn btn1">Online Mode</a>
                                    </button>
                                    <button class="btn p-2 rounded-3 bg-warning">
                                        <a href="#" onclick="makePayment('offline');" class="text-white custom_btn btn2">Offline Mode</a>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                </div> <!-- container-fluid -->
            </div> <!-- End Page-content -->


            <footer class="footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-6">
                            <?php echo $date; ?> © Uniqbizz.
                        </div>
                        <div class="col-sm-6">
                            <div class="text-sm-end d-none d-sm-block">
                                Design & Develop by MirthCon.
                            </div>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
        <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->

    <!-- loading screen -->
    <div id="loading-overlay">
        <div class="loading-icon"></div>
    </div>
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
    <script src="payout_details.js"></script>

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
        });
    </script>

    <!-- dataTable -->
    <script>
        $(document).ready(function() {
            $("#userTable").DataTable();
        });
    </script>

</body>

</html>