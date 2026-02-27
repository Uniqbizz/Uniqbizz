<?php
    session_start();

    if(!isset($_SESSION['username'])){
        echo '<script>location.href = "../../index.php";</script>';
    }
    require '../../connect.php';
    $date1 = date('Y'); 
?>
<!doctype html>
<html lang="en">
    <head>
        
        <meta charset="utf-8" />
        <title>Quotation | Admin</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- App favicon -->
        <link rel="shortcut icon" href="../../assets/images/fav.png">

        <!-- bootstrap-datepicker css -->
        <link href="../../assets/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css">

        <!-- DataTables -->
        <link href="../../assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />

        <!-- Responsive datatable examples -->
        <link href="../../assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />   

        <!-- Bootstrap Css -->
        <link href="../../assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
        <!-- Icons Css -->
        <link href="../../assets/css/icons.min.css" rel="stylesheet" type="text/css" />
        <!-- App Css-->
        <link href="../../assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />
        <!-- App js -->
        <!-- <script src="../../assets/js/plugin.js"></script> -->
        <style>
            .custom_btn {
            border: none;
            color: white;
            padding: 5px 8px;
            text-align: center;
            text-decoration: none;
            display: inline-flex;
            font-size: 13px;
            cursor: pointer;
            border-radius: 5px;
            }
            .btn1 {
                background-color: #21a827; /* Green */
            }
            .btn2 {
                background-color: #337ab7; /* blue */
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
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row mb-2">
                                            <div class="col-sm-6">
                                                <div class="search-box me-2 mb-2 d-inline-block">
                                                    <div class="position-relative">
                                                        <h4>Pending Quotations</h4>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="table-responsive">
                                            <table class="table align-middle table-nowrap dt-responsive nowrap w-100" id="tablePegination">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th>Sr No.</th>
                                                        <th>Name</th>
                                                        <th>Email</th>
                                                        <th>Destination</th>
                                                        <th>Date</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <!-- data load on models file -->
                                                    <?php include '../../models/quotation/pending_quotation_table.php' ?>
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
                                            <div class="col-sm-6">
                                                <div class="search-box me-2 mb-2 d-inline-block">
                                                    <div class="position-relative">
                                                        <h4>Verified Quotations</h4>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="table-responsive">
                                            <table class="table align-middle table-nowrap dt-responsive nowrap w-100" id="tablePegination2">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th>Sr No.</th>
                                                        <th>Name</th>
                                                        <th>Email</th>
                                                        <th>Destination</th>
                                                        <th>Date</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <!-- data load from models file -->
                                                     <?php include '../../models/quotation/verified_quotation_table.php' ?>
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
                
                <?php include_once "../../footer.php" ?>
            </div>
            <!-- end main content-->
        </div>
        <!-- END layout-wrapper -->
        <!--start back-to-top-->
        <button onclick="topFunction()" class="scrollToTop scroll-btn show btn" id="back-to-top">
            <i class="mdi mdi-arrow-up"></i>
        </button>
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
        
        <script type="text/javascript">
            $(document).ready(function(){
                $('#tablePegination').DataTable();
                $('#tablePegination2').DataTable();

            });
            //  Table Pegination
            
            function updateQuotations(id)
            {
                var response = confirm( "Action completed successfully!");

                if ( response == true ) {
                    $.ajax({
                        type:'POST',
                        url:'../../assets/submit/update_quotations.php',
                        data:'id='+id,
                        success:function (e) {

                            //  console.log(e);
                            if(e=="success")
                            {
                                location.reload();
                            }
                            else{
                                alert("Failed to update!");
                            }
                        },
                        error: function(err){
                            console.log(err);
                        },
                    });
                }
            };
        </script>
    </body>
</html>