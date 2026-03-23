<?php
    session_start();

    include '../../models/common_models/session_check.php';

    require '../../connect.php';
    //current full date
    $today = date('Y-m-d');

    //current year
    $date = date('Y'); 

    // Calculate 20 years before the current date
    $dateTwentyYearsAgo = strtotime("-20 years");

    // Format the result as a human-readable date
    $ageLimit = date("Y-m-d", $dateTwentyYearsAgo);  // Outputs the date 20 years before today
    $id=$_REQUEST['id'];
    $subId='';
    $frname='';
    $amount='';
    $id_str=substr($id,0,1);
    if ($id_str == 'F') {
        $sql1 = "SELECT sub_franchisee_id, CONCAT(firstname,' ',lastname) AS fname,amount,current_commission_per,current_incentive_per,upgrade_status 
         FROM sub_franchisee 
         WHERE sub_franchisee_id = :id";

        $stmt = $conn->prepare($sql1);

        $stmt->bindParam(':id', $id, PDO::PARAM_STR);  // $id must have the value before execute

        $stmt->execute();

        $franchisee = $stmt->fetch(PDO::FETCH_ASSOC);

        // get fname and sub_franchisee_id
        if ($franchisee) {
            $subId = $franchisee['sub_franchisee_id'];
            $frname = $franchisee['fname'];
            $amount = $franchisee['amount'];
            $prev_comm = $franchisee['current_commission_per'];
            $prev_ins = $franchisee['current_incentive_per'];
            $prev_upgrade=$franchisee['upgrade_status'];
            if($prev_upgrade == 2){
                $sql2 = "SELECT upgrade_amt 
                    FROM sub_franchisee_upgrade 
                    WHERE sub_franchisee_id = :id and upgrade_status=1 ORDER BY id DESC limit 1";

                $stmt = $conn->prepare($sql2);

                $stmt->bindParam(':id', $id, PDO::PARAM_STR);  // $id must have the value before execute

                $stmt->execute();

                $franchisee_upgrade = $stmt->fetch(PDO::FETCH_ASSOC);
                if ($franchisee_upgrade) {
                    $amount = $franchisee_upgrade['upgrade_amt'];
                }
            }
        }
    }else if ($id_str == 'I') {
        $sql1 = "SELECT institution_id, CONCAT(firstname,' ',lastname) AS fname,amount,current_commission_per,current_incentive_per,upgrade_status 
         FROM institution 
         WHERE institution_id = :id";

        $stmt = $conn->prepare($sql1);

        $stmt->bindParam(':id', $id, PDO::PARAM_STR);  // $id must have the value before execute

        $stmt->execute();

        $franchisee = $stmt->fetch(PDO::FETCH_ASSOC);

        // get fname and institution_id
        if ($franchisee) {
            $subId = $franchisee['institution_id'];
            $frname = $franchisee['fname'];
            $amount = $franchisee['amount'];
            $prev_comm = $franchisee['current_commission_per'];
            $prev_ins = $franchisee['current_incentive_per'];
            $prev_upgrade=$franchisee['upgrade_status'];
            if($prev_upgrade == 2){
                $sql2 = "SELECT upgrade_amt 
                    FROM institution_upgrade 
                    WHERE institution_id = :id and upgrade_status=1 ORDER BY id DESC limit 1";

                $stmt = $conn->prepare($sql2);

                $stmt->bindParam(':id', $id, PDO::PARAM_STR);  // $id must have the value before execute

                $stmt->execute();

                $franchisee_upgrade = $stmt->fetch(PDO::FETCH_ASSOC);
                if ($franchisee_upgrade) {
                    $amount = $franchisee_upgrade['upgrade_amt'];
                }
            }
        }
    }
    
    


?>
<!doctype html>
<html lang="en">

    <head>
        
        <meta charset="utf-8" />
        <title>Upgarde Franchisee | Admin Dashboard </title>
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

                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                    <h4 class="mb-sm-0 font-size-18">Franchisee</h4>
                                </div>
                            </div>
                        </div>

                        <!-- add customer form start -->
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <form id="upgradeForm">
                                            <h3>Upgrade Franchisee</h3>
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
                                                        <select id="new_select_amount" class="form-select"> 
                                                            <option value="">--Select New Amount--</option> 
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
                                                        <input type="text" class="form-control" id="update_amount" placeholder="Enter Updated Amount" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 col-sm-6">
                                                    <div class="input-block mb-3">
                                                        <label class="col-form-label" for="commission">New Commission<span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" id="commission" placeholder="Enter New Commission" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 col-sm-6">
                                                    <div class="input-block mb-3">
                                                        <label class="col-form-label" for="incentive">New Incentive<span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" id="incentive" placeholder="Enter New Incentive" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-md-12 col-sm-12">
                                                    <div class="input-block mb-3">
                                                        <label class="col-form-label" for="flex_amount">Extra Notes<span class="text-danger">*</span></label>
                                                        <textarea class="form-control" placeholder="Enter Note" id="floatingTextarea"></textarea>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-sm-6">
                                                    <label class="fw-bold col-form-label">Payment Mode: <span class="text-danger">*</span></label>
                                                    <div class="form-control radioBtn d-flex justify-content-around" id="paymentMode">
                                                        <label class="mb-0" for="cashPayment"><input type="radio" id="cashPayment" class="form-check-input payment me-3" name="payment" value="cash">Cash</label>
                                                        <label class="mb-0" for="chequePayment"><input type="radio" id="chequePayment"  class="form-check-input payment me-3" name="payment" value="cheque">Cheque</label>
                                                        <label class="mb-0" for="onlinePayment"><input type="radio" id="onlinePayment"  class="form-check-input payment me-3" name="payment" value="online">UPI/NEFT</label>
                                                    </div>
                                                </div>
                                                <div class="pb-3">
                                                    <div class="col-md-12 col-sm-12 d-none" id="chequeOpt">
                                                        <div class="row d-flex justify-content-center">
                                                            <div class="col-md-4 py-1">
                                                                <div class="input-block">
                                                                    <label class="col-form-label" for="chequeNo">Cheque No<span class="text-danger">*</span></label>
                                                                    <input type="text" class="form-control" id="chequeNo" placeholder="Enter Cheque Number">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4 py-1">
                                                                <div class="input-block">
                                                                    <label class="col-form-label" for="chequeDate">Cheque Date<span class="text-danger">*</span></label>
                                                                    <input type="text" class="form-control" id="chequeDate" placeholder="YYYY-MM-DD">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4 py-1">
                                                                <div class="input-block">
                                                                    <label class="col-form-label" for="bankName">Bank Name<span class="text-danger">*</span></label>
                                                                    <input type="text" class="form-control" id="bankName" placeholder="Enter your Bank Name">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 col-sm-12 d-none" id="onlineOpt">
                                                        <div class="row d-flex justify-content-center">
                                                            <div class="col-md-8">
                                                                <div class="input-block">
                                                                    <label class="col-form-label" for="transactionNo">Transaction No<span class="text-danger">*</span></label>
                                                                    <input type="text" class="form-control" id="transactionNo" placeholder="Enter your Transaction No.">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Attachments -->
												<h4 class="my-2">Attachments</h4>
                                                <div class="col-md-6 col-sm-6">
                                                    <div class="input-block mb-3">
                                                        <label class="col-form-label"><b>Payment Proof</b></label><br/>
                                                        <input class="form-control" type="file" name="file6" id="upload_file6">
                                                    </div>
                                                    <input type="hidden" id="img_path6" value="">
                                                    <div id="preview6" style="display: none;">
                                                        <div id="image_preview6">
                                                            <img alt="Preview" class="imgSize" id="img_pre6">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="d-flex justify-content-evenly mb-4">
                                                <button type="submit" class="btn btn-primary px-5 py-2" id="upgradeFranchisee">Submit</button>
                                                <button type="reset" class="btn btn-primary px-5 py-2" id="clear">Clear All</button>
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
        <!-- <script src="assets/js/pages/dashboard.init.js"></script> -->

        <!-- App js -->
        <script src="../../assets/js/app.js"></script>

        <!-- file upload code js file -->
        <script src="../../../uploading/upload.js"></script>

        <script src="../../resources/common_resources/top_function.js"></script>
        <!-- ** designation user, user name on designation select / get country, state, city, pincode **  -->
        <script>
            $("#new_select_amount").on('change', function () {
                var prev = parseInt($("#prev_amount").val()) || 0;
                var added = parseInt($(this).val()) || 0;

                var updateAmount = prev + added;
                $("#update_amount").val(updateAmount).trigger('input'); // trigger next calc
            });

            $("#clear").on('click',function(){
                window.location.reload();
            })
            $('#update_amount').on('input', function () {
                var amount = parseInt($(this).val()) || 0;

                if (amount == 300000) {
                    $("#commission").val('15');
                    $("#incentive").val('15');
                } else if (amount == 400000) {
                    $("#commission").val('20');
                    $("#incentive").val('20');
                } else if (amount >= 500000) {
                    $("#commission").val('30');
                    $("#incentive").val('20');
                } else {
                    $("#commission").val('');
                    $("#incentive").val('');
                }
            });


            $('#paymentMode').on('click', function(){
                var paymentMode = $(".payment:checked").val();
                // console.log(paymentMode);
                if(paymentMode == "cheque"){
                    $("#chequeOpt").removeClass("d-none");
                    $("#onlineOpt").addClass("d-none");
                    $("#transactionNo").val("");
                }else if(paymentMode == "online"){
                    $("#onlineOpt").removeClass("d-none");
                    $("#chequeOpt").addClass("d-none");
                    $("#chequeNo").val("");
                    $("#chequeDate").val("");
                    $("#bankName").val("");
                } else {
                    $("#chequeOpt").addClass("d-none");
                    $("#onlineOpt").addClass("d-none");
                    $("#chequeNo").val("");
                    $("#chequeDate").val("");
                    $("#bankName").val("");
                    $("#transactionNo").val("");
                }
            });
            $("#upgradeForm").on("submit", function(e){
                e.preventDefault();
                let paymentMode     = $(".payment:checked").val() || "";
                let upgradeSlection = $("#new_select_amount").val();
                let paymentProof    = $(":hidden#img_path6").val().trim();

                /* 1. Upgrade */
                if (upgradeSlection == '') {
                    alert('Please select Upgrade amount');
                    return false;   // STOP here
                }

                /* 2. Mode */
                if (paymentMode == '') {
                    alert('Please select payment mode');
                    return false;   // STOP here
                }

                /* 3. Cheque validations */
                if (paymentMode == "cheque") {
                    if (
                        $("#chequeNo").val().trim() == "" ||
                        $("#chequeDate").val().trim() == "" ||
                        $("#bankName").val().trim() == ""
                    ) {
                        alert("Please enter all Cheque details");
                        return false;   // STOP here
                    }
                }

                /* 4. Online validations */
                if (paymentMode == "online") {
                    if ($("#transactionNo").val().trim() == "") {
                        alert("Please enter Transaction Number");
                        return false;   // STOP here
                    }
                }

                /* 5. Proof (mandatory for all) */
                if (paymentProof == '') {
                    alert("Please Upload Payment Proof");
                    return false;   // STOP here
                }

                let formData = new FormData();

                formData.append("id", $("#franchiseeID").val());
                formData.append("prev_amount", $("#prev_amount").val());
                formData.append("new_amount", $("#new_select_amount").val());
                formData.append("update_amount", $("#update_amount").val());
                formData.append("commission", $("#commission").val());
                formData.append("incentive", $("#incentive").val());
                formData.append("note", $("#floatingTextarea").val());

                
                formData.append("payment_mode", paymentMode);

                formData.append("cheque_no", $("#chequeNo").val());
                formData.append("cheque_date", $("#chequeDate").val());
                formData.append("bank_name", $("#bankName").val());
                formData.append("transaction_no", $("#transactionNo").val());

                formData.append("payment_proof", $(":hidden#img_path6").val().trim());
                formData.append("prev_commission", <?= $prev_comm ?>);
                formData.append("prev_incentive", <?= $prev_ins ?>);
                
                console.log(formData);
                
                $.ajax({
                    url: "../../controllers/corporate_agency/upgrade_franchisee_action.php",   // create this file
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    beforeSend: function(){
                        $("#loading-overlay").show();
                    },
                    success: function(res){
                        $("#loading-overlay").hide();

                        if(res == 1){
                            alert("Franchisee Upgrade Requested Successfully!");
                            window.location.href = "view_corporate_agency.php";
                        }else{
                            alert("Franchisee Upgrade Request Failed!");
                        }
                    },
                    error: function(){
                        $("#loading-overlay").hide();
                        alert("Server Error!");
                    }
                });
            });
            </script>

        
    </body>

</html>