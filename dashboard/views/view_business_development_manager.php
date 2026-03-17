<?php
    // only CBD can add BC thats why no conditions require for pending and register tables
    include_once '../dashboard_user_details.php';
?>
<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable">
    <head>

        <meta charset="utf-8" />
        <title> Dashboard | Business Development Manager</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- App favicon -->
        <link rel="shortcut icon" href="../assets/images/fav.png">

        <!-- jsvectormap css -->
        <link href="../assets/libs/jsvectormap/css/jsvectormap.min.css" rel="stylesheet" type="text/css" />

        <!--Swiper slider css-->
        <link href="../assets/libs/swiper/swiper-bundle.min.css" rel="stylesheet" type="text/css" />

        <!-- DataTables -->
        <link href="../assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
        <!-- Responsive datatable examples -->
        <link href="../assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />  

        <!-- Layout config Js -->
        <script src="../assets/js/layout.js"></script>
        <!-- Bootstrap Css -->
        <link href="../assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <!-- Icons Css -->
        <link href="../assets/css/icons.min.css" rel="stylesheet" type="text/css" />
        <!-- App Css-->
        <link href="../assets/css/app.min.css" rel="stylesheet" type="text/css" />
        <!-- custom Css-->
        <link href="../assets/css/custom.min.css" rel="stylesheet" type="text/css" />
        <!-- custom Css developer-->
        <link rel="stylesheet" href="../assets/css/custom.css" />
        <link rel="stylesheet" href="../assets/fontawesome/css/all.min.css" />
    </head>

    <body>
 
        <!-- Begin page -->
        <div id="layout-wrapper">

            <?php include_once '../header.php'; ?>

            <?php include '../notification_card.php'?>
            <!-- ========== App Menu ========== -->
           
            <?php include_once '../sidebar.php'; ?>

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
                                <h4 class="mb-sm-0">View Business Development Manager</h4> 
                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="index.php">Dashboard </a></li>
                                        <li class="breadcrumb-item active">View Business Development Manager</li>
                                    </ol>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- end page title -->

                        <div class="row">
                            <div class="col">

                                <div class="h-100">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="card">
                                                <div class="card-header border-bottom-dashed">
                                                    <div class="row g-4 align-items-center">
                                                        <div class="col-sm">
                                                            <div>
                                                                <h5 class="card-title mb-0">Pending List</h5>
                                                            </div>
                                                        </div>
                                                    </div>   
                                                </div>    
                                                <div class="card-body">
                                                    <table id="example-dataTable" class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%">
                                                        <thead>
                                                            <tr>
                                                                <th data-ordering="false">SR No.</th>
                                                                <th data-ordering="false">Name</th>
                                                                <th data-ordering="false">Reference</th>
                                                                <th data-ordering="false">Phone</th>
                                                                <th data-ordering="false">Joining Date</th>
                                                                <th data-ordering="false">Status</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <!-- data load from models file -->
                                                            <?php include '../models/bdm/pending_bdm_list.php' ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="card">
                                                <div class="card-header">
                                                    <h5 class="card-title mb-0">Registered List</h5>
                                                </div>
                                                <div class="card-body">
                                                    <table id="example-dataTable-2" class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%">
                                                        <thead>
                                                            <tr>
                                                                <th data-ordering="false">BDM ID & Name</th>
                                                                <th data-ordering="false">Reporting Manager ID </th>
                                                                <th data-ordering="false">Phone</th>
                                                                <th data-ordering="false">Joining Date</th>
                                                                <th data-ordering="false">Status</th>
                                                                <th data-ordering="false">Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <!-- data load from models file -->
                                                            <?php include '../models/bdm/registered_bdm_list.php' ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            
                            </div>

                        </div>
                        
                        <?php if($userType == '24'){ ?> 
                            <div class="btn" style="width: 25px; height: 25px; padding: 0px; position: fixed; bottom: 120px; right: 35px; border-radius: 50%;">
                                <a href="add_business_development_manager.php" style="display: flex; justify-content: center; align-items: center; height: -webkit-fill-available;">
                                    <i class="fa-solid fa-circle-plus fa-beat-fade fa-3x" style="color: #4b38b3;"></i>
                                </a>
                            </div>
                        <?php } ?> 
                    </div> <!-- container-fluid -->

                </div><!-- End Page-content -->

                <?php include_once "../footer.php" ?>
                
            </div><!-- end main content-->
        
        </div><!-- END layout-wrapper -->

        <!--start back-to-top-->
        <button onclick="topFunction()" class="scrollToTop scroll-btn show btn" id="back-to-top">
            <i class="ri-arrow-up-line"></i>
        </button>
        <!--end back-to-top-->
        
        <!-- JAVASCRIPT -->
        <script src="../assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="../assets/libs/simplebar/simplebar.min.js"></script>
        <script src="../assets/libs/node-waves/waves.min.js"></script>
        <script src="../assets/libs/feather-icons/feather.min.js"></script>
        <script src="../assets/js/jquery/jquery-3.7.1.min.js"></script>

        <!-- Required datatable js -->
        <script src="../assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
        <script src="../assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
        
        <!-- Responsive examples -->
        <script src="../assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
        <script src="../assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>

    <!-- <script src="../assets/js/pages/datatables.init.js"></script> -->

        <!-- <script src="../assets/js/pages/plugins/lord-icon-2.1.0.js"></script> -->
        <!-- <script src="../assets/js/plugins.js"></script> -->

        <!-- !-- materialdesign icon js- -->
        <script src="../assets/js/pages/remix-icons-listing.js"></script>

        <!-- apexcharts -->
        <!-- <script src="../assets/libs/apexcharts/apexcharts.min.js"></script> -->
<!--  -->
        <!-- Vector map-->
        <!-- <script src="../assets/libs/jsvectormap/js/jsvectormap.min.js"></script> -->
        <!-- <script src="../assets/libs/jsvectormap/maps/world-merc.js"></script> -->

        <!--Swiper slider js-->
        <!-- <script src="../assets/libs/swiper/swiper-bundle.min.js"></script> -->

        <!-- Dashboard init -->
        <!-- <script src="../assets/js/pages/dashboard-ecommerce.init.js"></script> -->

        <!-- App js -->
        <script src="../assets/js/app.js"></script>

        <!-- Chart JS -->
        <!-- <script src="../assets/libs/chart.js/chart.umd.js"></script>// -->

        <!-- chartjs init -->
        <!-- <script src="../assets/js/pages/chartjs.init.js"></script>// -->

         <!-- Dashboard init -->
         <!-- <script src="../assets/js/pages/dashboard-job.init.js"></script> -->

         <script src="../resources/bdm/bdm_custom.js"></script>
    </body>
</html>