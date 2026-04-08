<?php

session_start();

include '../../models/common_models/session_check.php';

require '../../connect.php';
include '../../models/overview_profile/overview_custom.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Overview</title>
    <!-- App favicon -->
    <link rel="shortcut icon" href="../../assets/images/fav.png">
    <!-- custom css file -->
    <!-- <link href="../../assets/css/styles.css" rel="stylesheet" type="text/css" /> -->
    <!-- Bootstrap Css -->
    <link href="../../assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="../../assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="../../assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />
    <!-- Css-->
    <link href="../../assets/css/loadingScreen.css" id="app-style" rel="stylesheet" type="text/css" />
    <!-- App js -->
    <!-- <script src="assets/js/plugin.js"></script> -->
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Date Range Picker CSS Start -->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <!-- Date Range Picker CSS End -->
    <!-- DataTables -->
    <link href="../../assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <!-- Responsive datatable examples -->
    <link href="../../assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />

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
        include_once '../../header.php';

        // sidebar navigation menu 
        include_once '../../sidebar.php';
        ?>
        <div class="layout-wrapper">
            <div class="main-content">
                <div class="page-content">
                    <div class="container-fluid">
                        <div class="card p-3 rounded-4">
                            <!-- user info card -->
                            <!-- data load from views file -->
                            <?php include 'user_info_card.php'?>
                            <!-- end user info card -->
                            <!-- nav links  -->
                            <!-- data load from views -->
                            <?php include 'nav_links.php' ?>
                            <!-- end nav links  -->
                        </div>
                        <div class="tab-content">
                            <!-- Overview Start -->
                            <!-- data load from views -->
                            <?php include 'overview_tab.php' ?>
                            <!-- Overview End -->

                            <!-- Activities Start -->
                            <!-- daat load from models -->
                            <?php include '../../models/overview_profile/activities_tab.php' ?>
                            <!-- Activities End -->

                            <!-- Team Start -->
                            <!-- data load from controllers file -->
                            <?php include '../../controllers/overview_profile/team_tab.php' ?>
                            <!-- Team End -->

                            <!-- Payout Start -->
                            <!-- data load from controllers file -->
                            <?php include '../../controllers/overview_profile/payout_tab.php'?>
                            <!-- Payout End -->
                            <?php 
                                if($DBtable == 'sub_franchisee' || $DBtable == 'institution'){
                            ?>
                            <!-- upgarde History Start -->
                            <!-- data load from controllers file -->
                            <?php include '../../controllers/overview_profile/upgrade_franchisee.php' ?>
                            <!-- upgarde History End -->
                            <?php
                                }
                            ?>
                            <?php 
                                if($DBtable == 'ca_customer'){
                            ?>
                                <!-- coupons only for customers -->
                                <!-- data load from models file -->
                                <?php include '../../models/overview_profile/coupons_tab.php' ?>
                                <!-- coupons only for customers end -->
                                <!-- terms and conditions -->
                                <!-- data load from views file -->
                                <?php include 'terms_condition_tab.php' ?>
                                <!-- terms and conditions -->
                                
                            <?php 
                                } 
                            ?>
                            <?php include '../../controllers/overview_profile/edit_log_history.php' ?>
                            <?php
                                $excludeTables = ['ca_customer', 'institution'];

                                if (!in_array($DBtable, $excludeTables)) {
                                    include '../../controllers/overview_profile/transfer_log_history.php';
                                }
                            ?>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <?php include_once "../../footer.php" ?>
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
    <script src="../../assets/libs/jquery/jquery.min.js"></script>
    <script src="../../assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../../assets/libs/metismenu/metisMenu.min.js"></script>
    <script src="../../assets/libs/simplebar/simplebar.min.js"></script>
    <script src="../../assets/libs/node-waves/waves.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <!-- Required datatable js -->
    <script src="../../assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="../../assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>

    <!-- Responsive examples -->
    <script src="../../assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="../../assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>
    

    <!-- App js -->
    <script src="../../assets/js/app.js"></script>
    <script src="../../../uploading/upload.js"></script>
    <script src="../../resources/common_resources/top_function.js"></script>
    <script src = "../../resources/overview_profile/overview_profile_custom.js"></script>
    <script>
        $(document).ready(function () {
            const selected_div = "<?= $DBtable ?>";

            let $empBlock = $('#employee');
            let $zmBlock = $('#zonal_manager');

            // Cache and detach blocks only once
            if (!$empBlock.data('detached')) {
                $empBlock.data('detached', true);
                $empBlock = $empBlock.detach();
            }

            if (!$zmBlock.data('detached')) {
                $zmBlock.data('detached', true);
                $zmBlock = $zmBlock.detach();
            }

            // Clear formParent first
            $('#formParent').empty();

            // Append based on condition
            if (selected_div === 'business_developement_manager' || selected_div === 'business_chanel_manager' || selected_div ==='relationship_manager') {
                $('#formParent').append($empBlock);
            } else if (selected_div === 'zonal_manager') {
                $('#formParent').append($zmBlock);
            }
        });

        $('#generate_coupons').on('click', function () {
            var id = <?= json_encode($id) ?>;
            var customer_type = <?= json_encode($customer_type) ?>;

            var chequeNo = $("#chequeNo1").val().trim();
            var chequeDate = $("#chequeDate1").val().trim();
            var bankName = $("#bankName1").val().trim();
            var transactionNo = $("#transactionNo1").val().trim();
            let payment_fee =$('#payment_fee').val();
            let payment_text = $("#payment_fee option:selected").text().trim();
            var paymentMode = $(".payment1:checked").val()||'FOC';
            let payment_label = payment_text.includes(":")
                ? payment_text.split(":")[0].trim()
                : payment_text;
            let allowed_labels = ["Prime", "Premium", "Premium Plus"];
            let comp_check=$('#comp_chek option:selected').val();

            if (!allowed_labels.includes(payment_label)) {
                alert("Please select a valid Payment Type: Prime, Premium, or Premium Plus.");
                return;
            }
            var payment_proof;
            if (paymentMode === "FOC" || paymentMode === "null") {
                payment_proof = "none";
            } else {
                payment_proof = $("#img_path61").val().trim(); // hidden input
            }
            // Validate payment mode (Cheque or Online)
            if (!paymentMode) {
                alert("Please select a Payment Mode.");
                return;
            }

            // Conditional validation based on payment mode
            if (payment_fee === "Cheque") {
                if (!chequeNo) {
                    alert("Please enter the Cheque Number.");
                    return;
                }
                if (!chequeDate) {
                    alert("Please enter the Cheque Date.");
                    return;
                }
                if (!bankName) {
                    alert("Please enter the Bank Name.");
                    return;
                }
            } else if (payment_fee === "Online") {
                if (!transactionNo) {
                    alert("Please enter the Transaction Number.");
                    return;
                }
            }

            // Payment proof (optional logic)
            if (paymentMode === "FOC" || paymentMode === "null") {
                payment_proof = "none";
            } else {
                payment_proof = $("#img_path61").val().trim();
                if (!payment_proof) {
                    alert("Please upload the Payment Proof.");
                    return;
                }
            }

            // Validate complementary type
            if (!comp_check || comp_check === "null") {
                alert("Please select a Complementary Type.");
                return;
            }

            var data= {
                    id: id,
                    customer_type: customer_type,
                    cheque_no: chequeNo,
                    cheque_date: chequeDate,
                    bank_name: bankName,
                    transaction_no: transactionNo,
                    payment_proof: payment_proof,
                    payment_label: payment_label,
                    payment_fee:payment_fee,
                    paymentMode:paymentMode,
                    comp_chek:comp_check
                }
            //console.log(data);
            
            $.ajax({
                url: '../../models/overview_profile/generate_coupons.php',
                type: 'POST',
                data: data,
                dataType: 'json',
                success: function (response) {
                    if (response==1) {
                        alert('Coupon generated successfully!');
                        location.reload();
                    } else {
                        alert('Failed: ' + response.message);
                    }
                },
                error: function (xhr, status, error) {
                    console.error(error);
                    alert('An error occurred. Check console.');
                }
            });
        });
        $('#terms_condition_submit').on('click', function(e){
            e.preventDefault(); 
            // console.log('terms_condition Clicked');
            var cust_id = <?php echo json_encode($id); ?>;
            var termsAndConditionImg = $('#img_pathTerms').val();
            var termsAndConditionSection = $('#t_c').val();
            // console.log(termsAndConditionImg);
            if(termsAndConditionImg){
                var data = {
                    cust_id : cust_id,
                    termsAndConditionImg : termsAndConditionImg
                }
                // console.log(data);
                $.ajax({
                    url: '../../controllers/overview_profile/forms/upload_terms_condition.php',
                    type: 'POST',
                    data: data,
                    // dataType: 'json',
                    success: function (response) {
                        if (response==1) {
                            alert('Terms And Condition Image updated successfully!');
                            $('#terms_condition_submit').prop('disabled', true);
                            $('#terms_condition').prop('disabled', true);
                        } else {
                            alert('Failed: ' + response.message);
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error(error);
                        alert('An error occurred. Check console.');
                    }
                });
            }else{
                alert("No Terms And Condition Image Found!")
            }
        });
    </script>
</body>

</html>