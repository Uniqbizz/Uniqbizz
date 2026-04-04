<?php
require '../connect.php';
include '../dashboard_user_details.php';
include '../models/overview_profile/overview_custom.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Overview</title>
    <!-- App favicon -->
    <link rel="shortcut icon" href="../assets/images/fav.png">
    <!-- custom css file -->
    <!-- <link href="../assets/css/styles.css" rel="stylesheet" type="text/css" /> -->
    <!-- Bootstrap Css -->
    <link href="../assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="../assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="../assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />
    <!-- custom Css developer-->
    <link rel="stylesheet" href="../assets/css/custom.css" />
    <!-- <script src="../assets/js/plugin.js"></script> -->
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Date Range Picker CSS Start -->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <!-- Date Range Picker CSS End -->
    <!-- DataTables -->
    <link href="../assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <!-- Responsive datatable examples -->
    <link href="../assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />

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
        include_once '../header.php';
        include '../notification_card.php';
        // sidebar navigation menu 
        include_once '../sidebar.php';
        ?>
        <div class="layout-wrapper">
            <div class="main-content">
                <div class="page-content">
                    <div class="container-fluid">
                        <div class="card p-3 rounded-4">
                            <?php include '../models/overview_profile/overview_user_card.php'?>
                            <?php include '../models/overview_profile/nav_link.php'?>
                        </div>
                        <div class="tab-content">
                            <!-- Overview Start -->
                            <?php include '../models/overview_profile/overview_tab.php'?>
                            <!-- Overview End -->

                            <!-- Activities Start -->
                            <?php include '../models/overview_profile/activity_tab.php'?>
                            <!-- Activities End -->

                            <!-- Team Start -->
                            <?php include '../models/overview_profile/team_tab.php'?>
                            <!-- Team End -->

                            <!-- Payout Start -->
                            <?php include '../controllers/overview_profile/payout_tab.php'?>
                            <!-- Payout End -->
                            <?php 
                                if($DBtable == 'sub_franchisee' || $DBtable == 'institution'){
                            ?>
                            <!-- upgarde History Start -->
                            <!-- data load from controllers file -->
                            <?php include '../controllers/overview_profile/upgrade_franchisee.php' ?>
                            <!-- upgarde History End -->
                            <?php
                                }
                            ?>
                            <?php 
                                if($DBtable == 'ca_customer'){
                            ?>
                                <!-- coupons only for customers -->
                                <!-- data load from models file -->
                                <?php include '../models/overview_profile/coupons_tab.php' ?>
                                <!-- coupons only for customers end -->
                                <!-- terms and conditions -->
                                <!-- data load from views file -->
                                <?php include '../models/overview_profile/terms_condition_tab.php' ?>
                                <!-- terms and conditions -->
                                
                            <?php 
                                } 
                            ?>
                            <?php include '../controllers/overview_profile/edit_log_history.php' ?>
                            <?php
                                $excludeTables = ['ca_customer', 'institution'];

                                if (!in_array($DBtable, $excludeTables)) {
                                    include '../controllers/overview_profile/transfer_log_history.php';
                                }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" name="user_id" id="user_id" value="<?php echo $id; ?>">
    <input type="hidden" name="user_type" id="user_type" value="<?php echo $user_type; ?>">
    <input type="hidden" name="DBtable" id="DBtable" value="<?php echo $DBtable; ?>">
    <!-- END layout-wrapper -->
    <!--start back-to-top-->
    <button onclick="topFunction()" class="scrollToTop scroll-btn show btn" id="back-to-top">
        <i class="mdi mdi-arrow-up"></i>
    </button>
    <?php include_once "../footer.php" ?>
    <!--end back-to-top-->
    <!-- JAVASCRIPT -->
    <script src="../assets/libs/jquery/jquery.min.js"></script>
    <!-- <script src="../assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/libs/metismenu/metisMenu.min.js"></script>
    <script src="../assets/libs/simplebar/simplebar.min.js"></script>
    <script src="../assets/libs/node-waves/waves.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <!-- Required datatable js -->
    <script src="../assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="../assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>

    <!-- Responsive examples -->
    <script src="../assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="../assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>
    <script src="../resources/common/top_function.js"></script>
    <script src="../resources/overview_profile/overview_custom.js"></script>
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
    </script>
</body>

</html>