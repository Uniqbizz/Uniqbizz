<?php
    include_once '../../connect.php';
    include '../../models/upgrade_franchisee/upgrade_f_custom.php';


?>
<!doctype html>
<html lang="en">

    <head>
        
        <meta charset="utf-8" />
        <title>Upgarde Franchisee History | Dashboard </title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- App favicon -->
        <link rel="shortcut icon" href="../../assets/images/fav.png">

        <!-- Bootstrap Css -->
        <link href="../../assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
        <!-- Icons Css -->
        <link href="../../assets/css/icons.min.css" rel="stylesheet" type="text/css" />
        <!-- App Css-->
        <link href="../../assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />
        <!-- Loading Screen and Images size css  -->
        <link href="../../assets/css/loadingScreen.css" rel="stylesheet" type="text/css" />
        <!-- custom Css-->
        <link href="../../assets/css/custom.min.css" rel="stylesheet" type="text/css" />
        <!-- custom Css developer-->
        <link rel="stylesheet" href="../../assets/css/custom.css" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

        <!-- App js -->
        <!-- <script src="../../assets/js/plugin.js"></script> -->

        <!-- Plugins css -->
        <!-- <link href="../../assets/libs/dropzone/dropzone.css" rel="stylesheet" type="text/css" /> -->

    </head>

    <body data-sidebar="dark">

        <div id="testemails"></div>

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
                        <!-- add customer form start -->
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <form id="upgradeForm">
                                            <div class=" d-flex justify-content-between">
                                                <h3>Upgrade Franchisee History</h3>
                                                <span class="badge badge-pill<?= $upgrade_status_val == 1 ? ' badge-soft-success':($upgrade_status_val == 2?' badge-soft-danger':'') ?>  font-size-10 fw-bold ms-4" style="height: fit-content;"><?= $upgrade_status_val == 1 ? 'Approved' : ($upgrade_status_val == 2 ? 'Rejected':'') ?></span>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6 col-sm-6">
                                                    <div class="input-block mb-3">
                                                        <label class="col-form-label" for="franchiseeID">Franchisee ID<span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" id="franchiseeID" placeholder="Enter Franchisee ID" value="<?= $subId ?>" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-sm-6">
                                                    <div class="input-block mb-3">
                                                        <label class="col-form-label" for="firstname">First Name<span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" id="firstname" placeholder="Enter First Name" value="<?= $frname ?>" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-sm-6">
                                                    <div class="input-block mb-3">
                                                        <label class="col-form-label" for="prev_amount">Previous Amount<span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" id="prev_amount" placeholder="Enter Previous Amount" value="<?= $amount ?>" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-sm-6">
                                                    <div class="input-block mb-3">
                                                        <label class="col-form-label" for="new_select_amount">New Amount Select<span class="text-danger">*</span></label>
                                                        <select id="new_select_amount" class="form-select" disabled> 
                                                            <option value="<?php echo $new_amount; ?>"><?php echo $new_amount; ?></option> 
                                                            <option value="100000">1,00,000/-</option> 
                                                            <option value="200000">2,00,000/-</option> 
                                                            <option value="300000">3,00,000/-</option> 
                                                            <option value="400000">4,00,000/-</option> 
                                                            <option value="500000">5,00,000/-</option> 
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-sm-6">
                                                    <div class="input-block mb-3">
                                                        <label class="col-form-label" for="update_amount">Update Amount<span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" id="update_amount" placeholder="Enter Updated Amount" value="<?= $total_amount ?>" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 col-sm-6">
                                                    <div class="input-block mb-3">
                                                        <label class="col-form-label" for="commission">New Commission<span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" id="commission" placeholder="Enter New Commission" value="<?= $commision ?>" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 col-sm-6">
                                                    <div class="input-block mb-3">
                                                        <label class="col-form-label" for="incentive">New Incentive<span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" id="incentive" placeholder="Enter New Incentive" value="<?= $incentive ?>" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-md-12 col-sm-12">
                                                    <div class="input-block mb-3">
                                                        <label class="col-form-label" for="flex_amount">Extra Notes<span class="text-danger">*</span></label>
                                                        <textarea class="form-control" placeholder="Enter Note" id="floatingTextarea" readonly><?= $note ?></textarea>
                                                    </div>
                                                </div>
                                                <?php
                                                    if ($upgrade_status_val == 2) {
                                                ?>
                                                <div class="col-md-12 col-sm-12">
                                                    <div class="input-block mb-3">
                                                        <label class="col-form-label" for="flex_amount">Rejection Reason<span class="text-danger">*</span></label>
                                                        <textarea class="form-control" placeholder="Enter Note" id="floatingTextarea" readonly><?= $rejection_reason ?></textarea>
                                                    </div>
                                                </div>
                                                <?php
                                                    }
                                                ?>
                                                
                                                <div class="col-md-6 col-sm-6">
                                                    <label class="fw-bold col-form-label">Payment Mode: <span class="text-danger">*</span></label>
                                                    <div class="form-control radioBtn d-flex justify-content-around" id="paymentMode">
                                                        <label class="mb-0" for="cashPayment"><input type="radio" id="cashPayment" class="form-check-input payment me-3" name="payment" value="cash" <?= $payment_mode == 'cash' ?'checked':'' ?> disabled>Cash</label>
                                                        <label class="mb-0" for="chequePayment"><input type="radio" id="chequePayment"  class="form-check-input payment me-3" name="payment" value="cheque" <?= $payment_mode == 'cheque' ?'checked':'' ?> disabled>Cheque</label>
                                                        <label class="mb-0" for="onlinePayment"><input type="radio" id="onlinePayment"  class="form-check-input payment me-3" name="payment" value="online" <?= $payment_mode == 'online' ?'checked':'' ?> disabled>UPI/NEFT</label>
                                                    </div>
                                                </div>
                                                <div class="pb-3">
                                                    <div class="col-md-12 col-sm-12 d-none" id="chequeOpt">
                                                        <div class="row d-flex justify-content-center">
                                                            <div class="col-md-4 py-1">
                                                                <div class="input-block">
                                                                    <label class="col-form-label" for="chequeNo">Cheque No<span class="text-danger">*</span></label>
                                                                    <input type="text" class="form-control" id="chequeNo" placeholder="Enter Cheque Number" value="<?= $cheque_no ?>" readonly>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4 py-1">
                                                                <div class="input-block">
                                                                    <label class="col-form-label" for="chequeDate">Cheque Date<span class="text-danger" >*</span></label>
                                                                    <input type="text" class="form-control" id="chequeDate" placeholder="Enter Date On Cheque" value="<?= $cheque_date ?>" readonly>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4 py-1">
                                                                <div class="input-block">
                                                                    <label class="col-form-label" for="bankName">Bank Name<span class="text-danger">*</span></label>
                                                                    <input type="text" class="form-control" id="bankName" placeholder="Enter your Bank Name" value="<?= $bank_name ?>" readonly>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 col-sm-12 d-none" id="onlineOpt">
                                                        <div class="row d-flex justify-content-center">
                                                            <div class="col-md-8">
                                                                <div class="input-block">
                                                                    <label class="col-form-label" for="transactionNo">Transaction No<span class="text-danger">*</span></label>
                                                                    <input type="text" class="form-control" id="transactionNo" placeholder="Enter your Transaction No." value="<?= $transaction_no ?>" readonly>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Attachments -->
												<h4 class="my-2">Attachments</h4>
                                                <div class="col-md-6 col-sm-6">
                                                    <div class="input-block mb-3">
                                                        <label class="col-form-label"><b>Payment Proof</b>
                                                            <a href="<?php echo '../../../uploading/' . $payment_proof; ?>" download class="ms-3" title="Download">
                                                                <i class="fa fa-download fa-1x" aria-hidden="true"></i>
                                                            </a>
                                                        </label><br />
                                                        <!-- <input class="form-control" type="file" name="file6" id="upload_file6" disabled> -->
                                                    </div>
                                                    <input type="hidden" id="img_path6" value="<?php echo 'uploading/'.$payment_proof; ?>">
                                                    <div id="preview6" style="margin-bottom: 50px;">
                                                        <div id="image_preview6">
                                                            <?php
                                                            if ($payment_proof == '') {
                                                                echo '<img src="../../../uploading/not_uploaded.png" alt="Preview" id="img_pre6">';
                                                            } else {
                                                                echo '<img src="../../../uploading/' . $payment_proof . '" alt="Preview" id="img_pre6">'; ?>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="d-flex justify-content-evenly mb-4">
                                                <button type="button" class="btn btn-primary px-5 py-2" id="cancel" onclick="window.history.go(-1);">Cancel</button>
                                            </div>
                                            
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <!-- container-fluid -->
                </div>
                <!-- End Page-content -->
                <?php include_once "../../footer.php" ?>
            </div>
            <!-- end main content-->

        </div>

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
        <script src="../../assets/libs/jquery/jquery.min.js"></script>
        <script src="../../assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="../../assets/libs/metismenu/metisMenu.min.js"></script>
        <script src="../../assets/libs/simplebar/simplebar.min.js"></script>
        <script src="../../assets/libs/node-waves/waves.min.js"></script>

        <!-- add data to database js file -->
        <script type="text/javascript" src="../../assets/js/submitdata.js"></script>

        <!-- apexcharts -->
        <!-- <script src="../../assets/libs/apexcharts/apexcharts.min.js"></script> -->

        <!-- dashboard init -->
        <!-- <script src="../../assets/js/pages/dashboard.init.js"></script> -->

        <!-- App js -->
        <script src="../../assets/js/app.js"></script>

        <!-- file upload code js file -->
        <script src="../../../uploading/upload.js"></script>

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
        <!-- ** designation user, user name on designation select / get country, state, city, pincode **  -->
        <script src="../../resources/upgrade_franchisee/upgrade_f_custom.js"></script>

        
    </body>

</html>