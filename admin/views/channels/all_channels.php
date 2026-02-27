<?php
session_start();

if (!isset($_SESSION['username'])) {
    echo '<script>location.href = "../../index";</script>';
}
$date = date('Y');
?>
<!DOCTYPE html>
<html lang="en">


<!-- Mirrored from rn53themes.net/themes/demo/travelz/admin/user-all.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 20 Apr 2021 08:21:19 GMT -->

<head>
    <title>Channels | Admin Dashboard</title>
    <!--== META TAGS ==-->
    <!-- <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    == FAV ICON ==-->
    <!-- <link rel="shortcut icon" href="../../images/fav.ico"> -->

    <!-- GOOGLE FONTS -->
    <!-- <link href="../../../../../../../../../../fonts.googleapis.com/cssbcc5.css?family=Open+Sans:300,400,600|Quicksand:300,400,500" rel="stylesheet"> -->

    <!-- FONT-AWESOME ICON CSS -->
    <!-- <link rel="stylesheet" href="../../css/font-awesome.min.css"> -->

    <!--== ALL CSS FILES ==-->
    <!--<link rel="stylesheet" href="../../css/mob.css">
    <link rel="stylesheet" href="../../css/bootstrap.css">-->
    <link rel="stylesheet" href="../../assets/css/materialize.css" />
    <!-- <link rel="stylesheet" href="../../css/style.css">
    <link rel="stylesheet" href="../../css/styles2.css"> -->
    <link rel="stylesheet" href="../../assets/css/level-accordian.css"> 
    <!-- App favicon -->
    <link rel="shortcut icon" href="../../assets/images/fav.png">

    <!-- bootstrap-datepicker css -->
    <link href="../../assets/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css">

    <!-- Bootstrap Css -->
    <link href="../../assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="../../assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="../../assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />
    <!-- Loading Screen and Images size css  -->
    <link rel="stylesheet" href="../../assets/css/loadingScreen.css" rel="stylesheet" type="text/css" />
    <!-- App js -->
    <!-- <script src="../../assets/js/plugin.js"></script> -->

    <!-- Font awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
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
    </style>

</head>

<body data-sidebar="dark">
    <!--== MAIN CONTRAINER ==-->
    <?php include '../../sidebar.php'; ?>

    <!--== BODY CONTNAINER ==-->
    <!--       <div class="container-fluid sb2">
        <div class="row"> -->
    <?php include '../../header.php'; ?>

    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0 font-size-18">Channels</h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row mb-2">
                                <div class="col-sm-6">
                                    <div class="search-box me-2 mb-2 d-inline-block">
                                        <div class="position-relative">
                                            <h4>Pending Customers List</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <form>
                                <div class="row">
                                    <div class="form-group col-md-6 col-sm-12">
                                        <label class="text-dark fs-5"> Designation</label>
                                        <select id="designation" class="selectdesign">
                                            <option value="">--Select Designation--</option>
                                            <option value="bcm">Business Channel manager</option>
                                            <option value="bdm">Business Development manager</option>
                                            <option value="business_mentor">Business Mentor</option>
                                            <option value="master_franchisee">Master Franchisee</option>
                                            <option value="sponsor_franchisee">Sponsor Franchisee</option>
                                            <option value="corporate_agency">Techno Enterprise</option>
                                            <option value="sub_franchisee">Franchisee</option>
                                            <option value="ca_travelagency">Travel Consultant</option>
                                            <option value="ca_customer">Customer</option>
                                            <!-- <option value="business_trainee">Business Trainee</option> -->
                                        </select>
                                    </div>
                                    <div class="form-group col-md-6 col-sm-12">
                                        <label class="text-dark fs-5">User ID & Name</label>
                                        <select id="user_id_name" class="selectdesign">
                                            <option value="">--Select Designation First--</option>
                                        </select>
                                    </div>
                                </div>
                            </form>
                            <div class="row">
                                <!-- accordian starts -->
                                <div id="accordian_container">
                                    <span id="display-accordian"></span>
                                </div>
                                <!-- accordian ends -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php include_once "../../footer.php" ?>
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


    <!--======== SCRIPT FILES =========-->
    <!-- <script src="../../js/jquery.min.js"></script>
    <script src="../../js/bootstrap.min.js"></script>
    <script src="../../js/custom.js"></script> -->
    <!-- JAVASCRIPT -->
    <script src="../../assets/js/materialize.min.js"></script>
    <script src="../../assets/libs/jquery/jquery.min.js"></script>
    <script src="../../assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../../assets/libs/metismenu/metisMenu.min.js"></script>
    <script src="../../assets/libs/simplebar/simplebar.min.js"></script>
    <script src="../../assets/libs/node-waves/waves.min.js"></script>
    <!-- bootstrap-datepicker js -->
    <script src="../../assets/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>

    <!-- ecommerce-customer-list init -->
    <!-- <script src="../../assets/js/pages/ecommerce-customer-list.init.js"></script> -->

    <!-- App js -->
    <script src="../../assets/js/app.js"></script>
    <!-- <script type="text/javascript" src="../../payout/forms/payout_details.js"></script> -->

    <script src="../../resources/common_resources/top_function.js"></script>
    <script src="../../resources/channels/channels_custom.js"></script>
</body>
</html>