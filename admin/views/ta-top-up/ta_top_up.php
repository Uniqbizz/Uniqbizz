<?php
session_start();

if (!isset($_SESSION['username'])) {
    echo '<script>location.href = "../../login.php";</script>';
}

require '../../connect.php';
$date = date('Y');
?>
<!doctype html>
<html lang="en">

<head>

    <meta charset="utf-8" />
    <title>Ta Top-up | Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- App favicon -->
    <link rel="shortcut icon" href="../../assets/images/fav.png">

    <!-- bootstrap-datepicker css -->
    <link href="../../assets/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css">

    <!-- DataTables -->
    <link href="../../assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />

    <!-- Responsive datatable examples -->
    <link href="../../assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet"
        type="text/css" />

    <!-- Bootstrap Css -->
    <link href="../../assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="../../assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="../../assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />
    <!-- App js -->
    <!-- <script src="assets/js/plugin.js"></script> -->

    <style>
        /* dataTable, action col, dropdown align right  */
        @media screen and (max-width: 992px) and (min-width: 914px) {
            .dropdown-menu-end-1[style] {
                left: 25% !important;
                right: 25% !important;
            }
        }

        @media screen and (max-width: 1256px) and (min-width: 1176px) {
            .dropdown-menu-end-1[style] {
                left: 25% !important;
                right: 25% !important;
            }
        }

        @media screen and (max-width: 1345px) and (min-width: 1264px) {
            .dropdown-menu-end-2[style] {
                left: 25% !important;
                right: 25% !important;
            }
        }

        @media screen and (max-width: 375px) {
            .pendingButton {
                display: block !important;
            }
        }

        .prev-img {
            width: 200px;
            height: 150px;
        }

        .prev-img:hover {
            width: 250px;
            height: 180px;
        }

        .details-table {
            margin-left: 50px;
            /* Indent nested table */
            width: 80%;
        }

        .details-control {
            cursor: pointer;
            font-weight: bold;
            color: blue;
        }
    </style>

</head>

<body data-sidebar="dark">

    <!-- <body data-layout="horizontal" data-topbar="dark"> -->

    <!-- Begin page -->
    <div id="layout-wrapper">


        <?php
        // top header logo, hamberger menu, fullscreen icon, profile
        include_once '../../header.php';

        // sidebar navigation menu 
        include_once '../../sidebar.php';
        ?>


        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">

            <div class="page-content">
                <div class="container-fluid">

                    <!-- start page title -->
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                <h4 class="mb-sm-0 font-size-18">TA TopUp</h4>
                            </div>
                        </div>
                    </div>
                    <!-- end page title -->

                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row mb-2">
                                        <div class="col-lg-12 col-md-12 col-sm-12 p-3 d-flex justify-content-between pendingButton"
                                            style="background-color: #0036A2;">
                                            <h4 class="text-white">Pending TopUp</h4>
                                            <button id="exportAllData" class="btn btn-light">Download All</button>
                                        </div>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table align-middle table-nowrap dt-responsive nowrap w-100"
                                            id="pendingTopUp-table">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>#</th> <!-- Expand Button -->
                                                    <th>Name of TA</th>
                                                    <th>Total Pending TopUp</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <!-- data load from models file -->
                                            <?php include '../../models/ta-top-up/pending_list.php' ?>
                                        </table>
                                    </div>

                                    <!-- end card body -->
                                </div>
                                <!-- end card -->
                            </div>
                            <!-- end col -->
                        </div>
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row mb-2">
                                        <div class="col-lg-12 col-md-12 col-sm-12 p-3 d-flex justify-content-between pendingButton"
                                            style="background-color: #0036A2;">
                                            <h4 class="text-white">Approved TopUp</h4>
                                            <button id="exportAllData1" class="btn btn-light">Download All</button>
                                        </div>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table align-middle table-nowrap dt-responsive nowrap w-100"
                                            id="approvedTopUp-table">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>#</th>
                                                    <th>Name of TA</th>
                                                    <th>Total Approved/Rejected TopUp</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <!-- data load from models file -->
                                             <?php include '../../models/ta-top-up/processed_list.php' ?>

                                        </table>
                                    </div>
                                    <!-- end -->

                                    <!-- end table responsive -->
                                </div>
                                <!-- end card body -->
                            </div>
                            <!-- end card -->
                        </div>
                        <!-- end col -->
                    </div> <!-- container-fluid -->
                </div> <!-- End Page-content -->
                <div id="viewpay" class="modal fade" tabindex="-1" aria-labelledby="#exampleModalFullscreenLabel"
                    aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false"
                    style=" border-radius: 20px !important;">
                    <div class="modal-dialog modal-fullscreen"
                        style="width: 80%; margin: auto; margin-top: 30px; margin-bottom: 30px; height: 90vh;">
                        <div class="modal-content modal-radius">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalFullscreenLabel">Previous Payout</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row d-flex justify-content-evenly">
                                    <p class="text-muted font-size-16 mb-6">Payment Details:</p>
                                    <div class="card">
                                        <!-- <div class="card-body"> -->
                                        <!-- <div class="h-100"> -->
                                        <form>
                                            <div class="row g-3">


                                                <div class="col-md-3 col-12 ">
                                                    <div class="form-floating mb-2">
                                                        <input type="text" class="form-control" id="user_id_name"
                                                            value="" readonly>
                                                        <label for="user_id_name">TA ID</label>
                                                    </div>
                                                </div>

                                                <div class="col-md-3 col-12 ">
                                                    <div class="form-floating mb-2">
                                                        <input type="text" class="form-control" id="reference_name"
                                                            value="" readonly>
                                                        <label for="reference_name">TA Name</label>
                                                    </div>
                                                </div>


                                                <div class="col-md-3 col-12 ">
                                                    <div class="form-floating mb-2">
                                                        <input type="text" class="form-control" id="ta_amt" readonly>
                                                        <label for="ta_amt">Top Up amount</label>
                                                        <input type="hidden" value="" id="created_date" readonly>
                                                        <input type="hidden" value="" id="status" readonly>
                                                        <input type="hidden" value="" id="ta_top_amt_id" readonly>
                                                    </div>
                                                </div>

                                                <div class="col-md-3 col-12 ">
                                                    <div class="form-floating mb-2">
                                                        <input type="text" class="form-control" id="ta_pay_mode"
                                                            readonly>
                                                        <label for="ta_pay_mode">Payment Mode</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-12 col-12 d-none" id="ta_reject_reason_div">
                                                    <div class="form-floating mb-2">
                                                        <input type="text" class="form-control" id="ta_reject_reason"
                                                            readonly>
                                                        <label for="ta_reject_reason">Rejection reason</label>
                                                    </div>
                                                </div>
                                                <div class="py-3">
                                                    <div class="row d-flex justify-content-center align-itmes-center"
                                                        id="chequeOpt">
                                                        <div class="col-md-3 col-12 ">
                                                            <div class="form-floating mb-3">
                                                                <input type="text" class="form-control required"
                                                                    id="chequeNo" readonly>
                                                                <label for="chequeNo">Cheque No</label>

                                                            </div>

                                                        </div>

                                                        <div class="col-md-3 col-12 ">
                                                            <div class="form-floating mb-3">
                                                                <input type="text" class="form-control" id="chequeDate"
                                                                    readonly>
                                                                <label for="chequeDate">Cheque Date</label>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-3 col-12 ">
                                                            <div class="form-floating mb-3">
                                                                <input type="text" class="form-control" id="bankName"
                                                                    value="" readonly>
                                                                <label for="bankName">Bank Name</label>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-12 col-sm-12 d-none" id="onlineOpt">
                                                        <div class="col-md-3 col-12">
                                                            <div class="form-floating mb-2">
                                                                <input type="text" class="form-control"
                                                                    id="transactionNo" readonly>
                                                                <label for="transactionNo">Transaction No.</label>
                                                            </div>
                                                        </div>

                                                    </div>
                                                    <!-- check reseting part -->
                                                    <div class="col-lg-8" id="cheque_upl">
                                                        <div class="mb-8">
                                                            <label for="file1"><b>Payment Image</b></label><br />

                                                        </div>
                                                        <div id="feedbackcheque" class="error"></div>
                                                        <input type="hidden" id="previewcheque2" value="">
                                                        <div id="previewcheque">
                                                            <div id="previewcheque3">
                                                                <img alt="Preview" id="previewcheque1" class="prev-img">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                        <div class="modal-footer d-none" id="payaction_div">
                                            <button type="button" class="btn btn-success waves-effect waves-light"
                                                onclick="actionMarkup(2)">Accept</button>
                                            <button type="button" class="btn btn-danger waves-effect"
                                                    data-bs-dismiss="modal" 
                                                    onclick="openRejectReasonModal()">Reject</button>
                                        </div>
                                    </div><!-- /.modal-content -->
                                </div><!-- /.modal-dialog -->
                            </div>
                        </div>
                    </div>
                </div><!-- /.modal -->
                <!-- Modal -->
                <!--  -->
                <!-- end newCustomerModal -->
                <!-- Rejection Reason Modal -->
                    <div class="modal fade" id="rejectReasonModal" tabindex="-1" aria-labelledby="rejectReasonLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                            <div class="modal-header bg-danger text-white">
                                <h5 class="modal-title" id="rejectReasonLabel">Enter Rejection Reason</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>

                            <div class="modal-body">
                                <div class="form-group">
                                <label for="rejectionReason" class="form-label">Reason</label>
                                <textarea id="rejectionReason" class="form-control" rows="3" placeholder="Enter reason..."></textarea>
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="button" class="btn btn-danger" id="confirmReject" onclick="actionMarkup(3)">Confirm Reject</button>
                            </div>
                            </div>
                        </div>
                    </div>
                <!-- end Rejection Reason Modal -->

                
            </div>
            <!-- end main content-->
            <?php include_once "../../footer.php" ?>
        </div>
        <!-- END layout-wrapper -->

        <!-- JAVASCRIPT -->
        <script src="../../assets/libs/jquery/jquery.min.js"></script>
        <script src="../../assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="../../assets/libs/metismenu/metisMenu.min.js"></script>
        <script src="../../assets/libs/simplebar/simplebar.min.js"></script>
        <script src="../../assets/libs/node-waves/waves.min.js"></script>
        <!-- bootstrap-datepicker js -->
        <script src="../../assets/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>

        <!-- Required datatable js -->
        <script src="../../assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
        <script src="../../assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>

        <!-- Responsive examples -->
        <script src="../../assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
        <script src="../../assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>

        <!-- ecommerce-customer-list init -->
        <!-- <script src="../../assets/js/pages/ecommerce-customer-list.init.js"></script> -->

        <!-- App js -->
        <script src="../../assets/js/app.js"></script>
        <script src="../../resources/common_resources/top_function.js"></script>
        <script src="../../resources/ta-top-up/ta_top_up_custom.js"></script>

        <!-- <script src="../../../../uploading/upload.js"></script> -->
        <!-- dataTable -->
        <script>
            
        </script>
</body>

</html>