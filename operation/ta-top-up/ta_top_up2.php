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
    <title>Ta Top-up | Admin</title>
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

        .prev-img {
            width: 200px;
            height: 150px;
        }

        .prev-img:hover {
            width: 250px;
            height: 180px;
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
                                        <div class="col-lg-12 col-md-12 col-sm-12 p-3" style="background-color: #0036A2;">
                                            <h4 class="text-white">Pending TopUp</h4>
                                        </div>
                                    </div>

                                    <div class="table-responsive">
                                        <table class="table align-middle table-nowrap dt-responsive nowrap w-100" id="pendingTopUp-table">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>Id</th>
                                                    <th>Name of TA</th>
                                                    <th>TopUp Amount</th>
                                                    <th>Payment Method</th>
                                                    <th>Created Date</th>
                                                    <th>Updated Date</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                require '../connect.php';
                                                $stmt = $conn->prepare("SELECT * FROM `ta_top_up_payment` WHERE status=1  ORDER BY ID DESC");
                                                $stmt->execute();
                                                $referrals = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                                $i = 0;
                                                foreach ($referrals as $referral) {
                                                    echo '<tr>
                                                                  <td>' . ++$i . '</td>
                                                                  <td>' . $referral['ta_fname'] . ' ' . $referral['ta_lname'] . '</td>
                                                                  <td>' . $referral['top_up_amt'] . '</td>
                                                                  <td>' . $referral['pay_mode'] . '</td>
                                                                  <td>' . $referral['created_date'] . '</td>
                                                                  <td>' . $referral['updated_date'] . '</td>';

                                                    if ($referral['status'] == '1') {
                                                        echo '<td><span class="badge bg-warning">Pending</span></td>';
                                                    } else if ($referral['status'] == '2') {
                                                        echo '<td><span class="badge bg-success">Approved</span></td>';
                                                    } else if ($referral['status'] == '3') {
                                                        echo '<td><span class="badge bg-danger">Rejected</span></td>';
                                                    }
                                                    echo '<td>
                                                            <div class="dropdown">
                                                                <a class="" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false"><i class="mdi mdi-dots-horizontal mdi-24px" style="color: grey;"></i></a>
                                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                                    <a class="dropdown-item" href="#"  data-bs-toggle="modal" data-bs-target="#viewpay" onclick=\'showoverlay("' . $referral['ta_id'] . '","' . $referral['ta_fname'] . '","' . $referral['ta_lname'] . '","' . $referral['top_up_amt'] . '","' . $referral['pay_mode'] . '","' . $referral['cheque_no'] . '","' . $referral['cheque_date'] . '","' . $referral['bank_name'] . '","' . $referral['transaction_id'] . '","' . $referral['ref_img'] . '","' . $referral['created_date'] . '","1","'.$referral['id'] . '")\'><i class="mdi mdi-eye font-size-16 text-primary me-1"></i>View</a>
                                                                </div>
                                                            </div>
                                                          </td>';

                                                    echo '</tr>';
                                                }


                                                ?>
                                            </tbody>
                                        </table>
                                        <!-- end table -->
                                    </div>
                                    <!-- end table responsive -->
                                </div>
                                <!-- end card body -->
                            </div>
                            <!-- end card -->
                        </div>
                        <!-- end col -->
                    </div>
                    <!-- end row -->
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row mb-2">
                                        <div class="col-lg-12 col-md-12 col-sm-12 p-3" style="background-color: #0036A2;">
                                            <h4 class="text-white">Approved TopUp</h4>
                                        </div>
                                    </div>

                                    <div class="table-responsive">
                                        <table class="table align-middle table-nowrap dt-responsive nowrap w-100" id="approvedTopUp-table">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>Id</th>
                                                    <th>Name of TA</th>
                                                    <th>TopUp Amount</th>
                                                    <th>Payment Method</th>
                                                    <th>Created Date</th>
                                                    <th>Updated Date</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                require '../connect.php';
                                                $stmt = $conn->prepare("SELECT * FROM `ta_top_up_payment` WHERE status=2 or status=3  ORDER BY ID DESC");
                                                $stmt->execute();
                                                $referrals = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                                $i = 0;
                                                foreach ($referrals as $referral) {
                                                    echo '<tr>
                                                                  <td>' . ++$i . '</td>
                                                                  <td>' . $referral['ta_fname'] . ' ' . $referral['ta_lname'] . '</td>
                                                                  <td>' . $referral['top_up_amt'] . '</td>
                                                                  <td>' . $referral['pay_mode'] . '</td>
                                                                  <td>' . $referral['created_date'] . '</td>
                                                                  <td>' . $referral['updated_date'] . '</td>';

                                                    if ($referral['status'] == '2') {
                                                        echo '<td><span class="badge bg-success">Approved</span></td>';
                                                    } else if ($referral['status'] == '3') {
                                                        echo '<td><span class="badge bg-danger">Rejected</span></td>';
                                                    }
                                                    echo '<td>
                                                            <div class="dropdown">
                                                                <a class="" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false"><i class="mdi mdi-dots-horizontal mdi-24px" style="color: grey;"></i></a>
                                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                                    <a class="dropdown-item" href="#"  data-bs-toggle="modal" data-bs-target="#viewpay" onclick=\'showoverlay("' . $referral['ta_id'] . '","' . $referral['ta_fname'] . '","' . $referral['ta_lname'] . '","' . $referral['top_up_amt'] . '","' . $referral['pay_mode'] . '","' . $referral['cheque_no'] . '","' . $referral['cheque_date'] . '","' . $referral['bank_name'] . '","' . $referral['transaction_id'] . '","' . $referral['ref_img'] . '","' . $referral['created_date'] . '","' . $referral['status'] . '")\'><i class="mdi mdi-eye font-size-16 text-primary me-1"></i>View</a>
                                                                </div>
                                                            </div>
                                                          </td>';
                                                    echo '</tr>';
                                                }


                                                ?>
                                            </tbody>
                                        </table>
                                        <!-- end table -->
                                    </div>
                                    <!-- end table responsive -->
                                </div>
                                <!-- end card body -->
                            </div>
                            <!-- end card -->
                        </div>
                        <!-- end col -->
                    </div>
                    <!-- end row -->

                </div> <!-- container-fluid -->
            </div> <!-- End Page-content -->
            <div id="viewpay" class="modal fade" tabindex="-1" aria-labelledby="#exampleModalFullscreenLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false" style=" border-radus: 20px !important;">
                <div class="modal-dialog modal-fullscreen" style="width: 80%; margin: auto; margin-top: 30px; margin-bottom: 30px; height: 90vh;">
                    <div class="modal-content modal-radius">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalFullscreenLabel">Previous Payout</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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
                                                    <input type="text" class="form-control" id="user_id_name" value="" readonly>
                                                    <label for="user_id_name">TA ID</label>
                                                </div>
                                            </div>

                                            <div class="col-md-3 col-12 ">
                                                <div class="form-floating mb-2">
                                                    <input type="text" class="form-control" id="reference_name" value="" readonly>
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
                                                    <input type="text" class="form-control" id="ta_pay_mode" readonly>
                                                    <label for="ta_pay_mode">Payment Mode</label>
                                                </div>
                                            </div>
                                            <div class="py-3">
                                                <div class="row d-flex justify-content-center align-itmes-center" id="chequeOpt" >
                                                    <div class="col-md-3 col-12 ">
                                                        <div class="form-floating mb-3">
                                                            <input type="text" class="form-control required" id="chequeNo" readonly>
                                                            <label for="chequeNo">Cheque No</label>

                                                        </div>

                                                    </div>

                                                    <div class="col-md-3 col-12 ">
                                                        <div class="form-floating mb-3">
                                                            <input type="text" class="form-control" id="chequeDate" readonly>
                                                            <label for="chequeDate">Cheque Date</label>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-3 col-12 ">
                                                        <div class="form-floating mb-3">
                                                            <input type="text" class="form-control" id="bankName" value="" readonly>
                                                            <label for="bankName">Bank Name</label>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-12 col-sm-12 d-none" id="onlineOpt" >
                                                    <div class="col-md-3 col-12">
                                                        <div class="form-floating mb-2">
                                                            <input type="text" class="form-control" id="transactionNo" readonly>
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
                                        <button type="button" class="btn btn-success waves-effect waves-light" onclick="actionMarkup(2)">Accept</button>
                                        <button type="button" class="btn btn-danger waves-effect" data-bs-dismiss="modal" onclick="actionMarkup(3)">Reject</button>
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
    <!-- <script src="../../uploading/upload.js"></script> -->
    <!-- dataTable -->
    <script>
        function showoverlay(ta_id, ta_fname, ta_lname, ta_amount, ta_pay_mode, ta_cheque_no, ta_cheque_date, ta_bank_name, ta_transac_id, ta_ref_img, ta_created_date, status,ta_amt_id) {
            console.log('id:'+ta_amt_id);
            
            $('#user_id_name').val(ta_id);
            $('#reference_name').val(ta_fname + ' ' + ta_lname);
            $('#ta_amt').val(ta_amount)
            $('#ta_pay_mode').val(ta_pay_mode);
            $('#created_date').val(ta_created_date);
            $('#status').val(status);
            $('#ta_top_amt_id').val(ta_amt_id);
            if (ta_pay_mode == 'cash') {
                $("#previewcheque1").attr("src", "../../uploading/" + ta_ref_img);
                $("#previewcheque2").val(ta_ref_img);
                $('#chequeOpt').addClass("d-none");
                $('#onlineOpt').addClass("d-none");
            } else if (ta_pay_mode == 'cheque') {
                $('#chequeOpt').removeClass("d-none");
                $('#onlineOpt').addClass("d-none");
                $('#chequeNo').val(ta_cheque_no);
                $('#chequeDate').val(ta_cheque_date);
                $('#bankName').val(ta_bank_name);
                $("#previewcheque1").attr("src", "../../uploading/" + ta_ref_img);
                $("#previewcheque2").val(ta_ref_img);
            } else if (ta_pay_mode == 'online') {
                $('#chequeOpt').addClass("d-none");
                $('#onlineOpt').removeClass("d-none");
                $('#transactionNo').val(ta_transac_id);
                $("#previewcheque1").attr("src", "../../uploading/" + ta_ref_img);
                $("#previewcheque2").val(ta_ref_img);
            }
            //to show/hide accept reject div
            var status = $('#status').val();
            console.log('status:' + status);

            if (status == 1) {
                $('#payaction_div').removeClass("d-none");
            } else if (status != 1) {

                $('#payaction_div').addClass("d-none");
            }
            //------------

        }
        $(document).ready(function() {
            $("#pendingTopUp-table").DataTable();
            $("#approvedTopUp-table").DataTable();
        });

        function actionMarkup(status) {

            var taid = $('#user_id_name').val();
            var created_date = $('#created_date').val();
            var ta_amt_id= $('#ta_top_amt_id').val();
            var ta_amount=$('#ta_amt').val();
            var dataString = 'created_date=' + created_date + '&taid=' + taid + '&status=' + status+'&ta_amount='+ta_amount+'&ta_amt_id='+ta_amt_id;
            console.log(dataString);
            
            $.ajax({
                type: "POST",
                url: "ta_top_up_action.php",
                data: dataString,
                cache: false,
                success: function(data) {
                    console.log('data' + data);
                    if (data == '2') {
                        alert("Top Up Aproved");
                        window.location.reload();
                    } else if (data == '3') {
                        alert("Top Up Rejected");
                        window.location.reload();
                    } else {
                        alert("Request Failed !!");
                        window.location.reload();
                    }
                }
            });

        };
    </script>
</body>

</html>