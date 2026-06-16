<?php
    include_once (__DIR__.'/../dashboard_user_details.php');
    if ($userType == '34') {
        $base_url_sidebar = "/ca.uniqbizz.com/dashboard/executive_techno_enterprise/";
        $base_url_asset = "/ca.uniqbizz.com/dashboard/";
        $home_url = "/ca.uniqbizz.com/";
    }else{
        // $base_url_sidebar = "/ca.uniqbizz.com/dashboard/customer_dashboard/";
        $base_url_asset = "/ca.uniqbizz.com/dashboard/";
        $home_url = "/ca.uniqbizz.com/"; 
    }
?>
<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable">
    <head>

        <meta charset="utf-8" />
        <title>Customers List | Dashboard</title>
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
        <!-- font-awesome -->
        <link rel="stylesheet" href="../assets/fontawesome/css/all.min.css" />
        
        <!-- Customer Dashboard CSS -->
        <link rel="stylesheet" href="../assets/css/executive_techno_enterprise.css" />
        <!-- FontAwesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    </head>
    <body>
 
        <!-- Begin page -->
        <div id="layout-wrapper">

            <?php 
                if ($userType == 34) {
                    include_once(__DIR__ . '/executive_techno_header.php');
                }else{

                    include_once 'executive_techno_header.php'; 
                }
            ?>

            <!-- removeNotificationModal -->
            <div id="removeNotificationModal" class="modal fade zoomIn" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="NotificationModalbtn-close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mt-2 text-center">
                                <lord-icon src="../../../../cdn.lordicon.com/gsqxdxog.json" trigger="loop" colors="primary:#f7b84b,secondary:#f06548" style="width:100px;height:100px"></lord-icon>
                                <div class="mt-4 pt-2 fs-15 mx-4 mx-sm-5">
                                    <h4>Are you sure ?</h4>
                                    <p class="text-muted mx-4 mb-0">Are you sure you want to remove this Notification ?</p>
                                </div>
                            </div>
                            <div class="d-flex gap-2 justify-content-center mt-4 mb-2">
                                <button type="button" class="btn w-sm btn-light" data-bs-dismiss="modal">Close</button>
                                <button type="button" class="btn w-sm btn-danger" id="delete-notification">Yes, Delete It!</button>
                            </div>
                        </div>

                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->
            <!-- ========== App Menu ========== -->
            <?php 
                if ($userType == 34) {
                    include_once(__DIR__ . '/executive_techno_sidebar.php');
                }else{

                    include_once 'executive_techno_sidebar.php'; 
                }
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
                                    <h4 class="mb-sm-0">Customers</h4>

                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="executive_techno_dashboard.php">Dashboard</a></li>
                                            <li class="breadcrumb-item active">View Customers</li>
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
                                            <div class="card rounded-4 border-1">
                                                <div class="card-header border-bottom-dashed rounded-top-4 d-flex gap-3">
                                                    <div class="tePendingIcon tePendingIcon1">
                                                        <i class="fa-solid fa-hourglass-half fa-xl"></i>
                                                    </div>
                                                    <div class="align-content-end">
                                                        <h5 class="card-title text-dark mb-0">Pending Customers List</h5>
                                                        <p class="text-muted fs-6 mb-0">Customers pending for approval</p>
                                                    </div>
                                                </div>    
                                                <div class="card-body">
                                                    <table id="example-dataTable" class="table table-striped table-bordered dt-responsive nowrap align-middle" style="width:100%">
                                                        <thead>
                                                            <tr class="table-primary">
                                                                <th data-ordering="false">Full Name</th>
                                                                <th data-ordering="false">Reference ID & Name</th>
                                                                <th data-ordering="false">Phone & Email</th>
                                                                <th data-ordering="false">Joining Date</th>
                                                                <th data-ordering="false">Status</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td>
                                                                    <p class="fs-6 mb-0">Rajesh Kumar</p>
                                                                </td>
                                                                <td>
                                                                    <div class="">
                                                                        <p class="fs-6 mb-0">Pandurang Naik</p>
                                                                        <p class="fs-6 mb-0">STE-REF-00023</p>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="">
                                                                        <p class="fs-6 mb-0"><i class="fa-solid fa-phone me-2"></i>+91 9876543210</p>
                                                                        <p class="fs-6 mb-0"><i class="fa-regular fa-envelope me-2"></i>rajesh.kumar@email.com</p>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <p class="fs-6 mb-0"><i class="fa-solid fa-calendar-days me-2"></i>20 May 2024</p>
                                                                </td>
                                                                <td>
                                                                    <p class="tePendingBtn rounded-pill text-center">Pending</p>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    <p class="fs-6 mb-0">Rajesh Kumar</p>
                                                                </td>
                                                                <td>
                                                                    <div class="">
                                                                        <p class="fs-6 mb-0">Pandurang Naik</p>
                                                                        <p class="fs-6 mb-0">STE-REF-00023</p>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="">
                                                                        <p class="fs-6 mb-0"><i class="fa-solid fa-phone me-2"></i>+91 9876543210</p>
                                                                        <p class="fs-6 mb-0"><i class="fa-regular fa-envelope me-2"></i>rajesh.kumar@email.com</p>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <p class="fs-6 mb-0"><i class="fa-solid fa-calendar-days me-2"></i>20 May 2024</p>
                                                                </td>
                                                                <td>
                                                                    <p class="tePendingBtn rounded-pill text-center">Pending</p>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    <p class="fs-6 mb-0">Rajesh Kumar</p>
                                                                </td>
                                                                <td>
                                                                    <div class="">
                                                                        <p class="fs-6 mb-0">Pandurang Naik</p>
                                                                        <p class="fs-6 mb-0">STE-REF-00023</p>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="">
                                                                        <p class="fs-6 mb-0"><i class="fa-solid fa-phone me-2"></i>+91 9876543210</p>
                                                                        <p class="fs-6 mb-0"><i class="fa-regular fa-envelope me-2"></i>rajesh.kumar@email.com</p>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <p class="fs-6 mb-0"><i class="fa-solid fa-calendar-days me-2"></i>20 May 2024</p>
                                                                </td>
                                                                <td>
                                                                    <p class="tePendingBtn rounded-pill text-center">Pending</p>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    <p class="fs-6 mb-0">Rajesh Kumar</p>
                                                                </td>
                                                                <td>
                                                                    <div class="">
                                                                        <p class="fs-6 mb-0">Pandurang Naik</p>
                                                                        <p class="fs-6 mb-0">STE-REF-00023</p>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="">
                                                                        <p class="fs-6 mb-0"><i class="fa-solid fa-phone me-2"></i>+91 9876543210</p>
                                                                        <p class="fs-6 mb-0"><i class="fa-regular fa-envelope me-2"></i>rajesh.kumar@email.com</p>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <p class="fs-6 mb-0"><i class="fa-solid fa-calendar-days me-2"></i>20 May 2024</p>
                                                                </td>
                                                                <td>
                                                                    <p class="tePendingBtn rounded-pill text-center">Pending</p>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="card rounded-4 border-1">
                                                <div class="card-header border-bottom-dashed rounded-top-4">
                                                    <div class="row">
                                                        <div class="col-xl-6 col-lg-5 col-md-12 col-sm-12 col-12 mb-2">
                                                            <div class="d-flex gap-3">
                                                                <div class="tePendingIcon tePendingIcon2">
                                                                    <i class="ri-verified-badge-line" style="font-size: 30px;"></i>
                                                                </div>
                                                                <div class="align-content-end">
                                                                    <h5 class="card-title text-dark mb-0">Registered Customers List</h5>
                                                                    <p class="text-muted fs-6 mb-0">All approved and active Customers</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-6 col-lg-7 col-md-12 col-sm-12 col-12 mb-2">
                                                            <div class="row d-flex justify-content-end gap-2 teSectionSize">
                                                                <div class="col-lg-3 col-md-4 col-sm-4 col-6 mb-2">
                                                                    <!-- <div> -->
                                                                        <input type="date" id="date" name="date" class="dateInput">
                                                                    <!-- </div>   -->
                                                                </div>
                                                                <div class="col-lg-4 col-md-4 col-sm-4 col-6 mb-2">
                                                                    <div class="d-flex gap-2">
                                                                        <p class="fs-6 text-dark mb-1 align-content-center">Count</p>
                                                                        <input type="number" class="dateInput" value="50">
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-4 col-md-4 col-sm-4 col-12 mb-2">
                                                                    <a href="#" class="text-decoration-none" id="#">
                                                                        <div class="stWalletBtn rounded-3 py-2 align-items-center justify-content-center justify-content-lg-start">
                                                                            <i class="fa-solid fa-download me-2"></i>
                                                                            <p class="fs-6 mb-0 fw-bolder pe-1">Download</p>
                                                                        </div>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card-body">
                                                    <table id="example-dataTable-2" class="table table-striped table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%">
                                                        <thead>
                                                            <tr class="table-primary">
                                                                <th data-ordering="false">TE ID & Full Name</th>
                                                                <th data-ordering="false">Reference ID & Name</th>
                                                                <th data-ordering="false">Phone & Email</th>
                                                                <th data-ordering="false">Membership (&#8377;)</th>
                                                                <th data-ordering="false">Joining Date</th>
                                                                <th data-ordering="false">Status</th>
                                                                <th data-ordering="false">Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td>
                                                                    <div class="">
                                                                        <p class="fs-6 mb-0">Rajesh Kumar</p>
                                                                        <p class="fs-6 mb-0">STE-REF-00023</p>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="">
                                                                        <p class="fs-6 mb-0">Pandurang Naik</p>
                                                                        <p class="fs-6 mb-0">STE-REF-00023</p>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="">
                                                                        <p class="fs-6 mb-0"><i class="fa-solid fa-phone me-2"></i>+91 9876543210</p>
                                                                        <p class="fs-6 mb-0"><i class="fa-regular fa-envelope me-2"></i>rajesh.kumar@email.com</p>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="">
                                                                        <p class="fs-6 mb-0">Neo Select</p>
                                                                        <p class="fs-6 mb-0">11,000</p>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <p class="fs-6 mb-0"><i class="fa-solid fa-calendar-days me-2"></i>20 May 2024</p>
                                                                </td>
                                                                <td>
                                                                    <p class="teActiveBtn rounded-pill text-center">Active</p>
                                                                </td>
                                                                <td>
                                                                    <a href="edit_techno_enterprise.php">
                                                                        <p class="teViewBtn text-center fw-bold"><i class="fa-solid fa-eye me-2 mt-1"></i>View</p>
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    <div class="">
                                                                        <p class="fs-6 mb-0">Rajesh Kumar</p>
                                                                        <p class="fs-6 mb-0">STE-REF-00023</p>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="">
                                                                        <p class="fs-6 mb-0">Pandurang Naik</p>
                                                                        <p class="fs-6 mb-0">STE-REF-00023</p>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="">
                                                                        <p class="fs-6 mb-0"><i class="fa-solid fa-phone me-2"></i>+91 9876543210</p>
                                                                        <p class="fs-6 mb-0"><i class="fa-regular fa-envelope me-2"></i>rajesh.kumar@email.com</p>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="">
                                                                        <p class="fs-6 mb-0">Neo Select</p>
                                                                        <p class="fs-6 mb-0">11,000</p>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <p class="fs-6 mb-0"><i class="fa-solid fa-calendar-days me-2"></i>20 May 2024</p>
                                                                </td>
                                                                <td>
                                                                    <p class="teActiveBtn rounded-pill text-center">Active</p>
                                                                </td>
                                                                <td>
                                                                    <a href="edit_techno_enterprise.php">
                                                                        <p class="teViewBtn text-center fw-bold"><i class="fa-solid fa-eye me-2 mt-1"></i>View</p>
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    <div class="">
                                                                        <p class="fs-6 mb-0">Rajesh Kumar</p>
                                                                        <p class="fs-6 mb-0">STE-REF-00023</p>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="">
                                                                        <p class="fs-6 mb-0">Pandurang Naik</p>
                                                                        <p class="fs-6 mb-0">STE-REF-00023</p>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="">
                                                                        <p class="fs-6 mb-0"><i class="fa-solid fa-phone me-2"></i>+91 9876543210</p>
                                                                        <p class="fs-6 mb-0"><i class="fa-regular fa-envelope me-2"></i>rajesh.kumar@email.com</p>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="">
                                                                        <p class="fs-6 mb-0">Neo Select</p>
                                                                        <p class="fs-6 mb-0">11,000</p>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <p class="fs-6 mb-0"><i class="fa-solid fa-calendar-days me-2"></i>20 May 2024</p>
                                                                </td>
                                                                <td>
                                                                    <p class="teActiveBtn rounded-pill text-center">Active</p>
                                                                </td>
                                                                <td>
                                                                    <a href="edit_techno_enterprise.php">
                                                                        <p class="teViewBtn text-center fw-bold"><i class="fa-solid fa-eye me-2 mt-1"></i>View</p>
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    <div class="">
                                                                        <p class="fs-6 mb-0">Rajesh Kumar</p>
                                                                        <p class="fs-6 mb-0">STE-REF-00023</p>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="">
                                                                        <p class="fs-6 mb-0">Pandurang Naik</p>
                                                                        <p class="fs-6 mb-0">STE-REF-00023</p>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="">
                                                                        <p class="fs-6 mb-0"><i class="fa-solid fa-phone me-2"></i>+91 9876543210</p>
                                                                        <p class="fs-6 mb-0"><i class="fa-regular fa-envelope me-2"></i>rajesh.kumar@email.com</p>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="">
                                                                        <p class="fs-6 mb-0">Neo Select</p>
                                                                        <p class="fs-6 mb-0">11,000</p>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <p class="fs-6 mb-0"><i class="fa-solid fa-calendar-days me-2"></i>20 May 2024</p>
                                                                </td>
                                                                <td>
                                                                    <p class="teActiveBtn rounded-pill text-center">Active</p>
                                                                </td>
                                                                <td>
                                                                    <a href="edit_techno_enterprise.php">
                                                                        <p class="teViewBtn text-center fw-bold"><i class="fa-solid fa-eye me-2 mt-1"></i>View</p>
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div> <!-- container-fluid -->

                </div><!-- End Page-content -->
                <?php 
                    if ($userType == 34) {
                        include_once(__DIR__ . '/executive_techno_footer.php');
                    }else{

                        include_once "executive_techno_footer.php"; 
                    }
                ?>
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
        <!-- !-- materialdesign icon js- -->
        <script src="../assets/js/pages/remix-icons-listing.js"></script>
        <?php 
            //if ($userType == 34) {
        ?>
        <!-- Vector map-->
        <script src="<?= $base_url ?>../assets/libs/jsvectormap/js/jsvectormap.min.js"></script>
        <script src="<?= $base_url ?>../assets/libs/jsvectormap/maps/world-merc.js"></script>

        <!--Swiper slider js-->
        <script src="<?= $base_url ?>../assets/libs/swiper/swiper-bundle.min.js"></script>
        <?php
           // }
        ?>

        <!-- App js -->
        <script src="../assets/js/app.js"></script>

        <script>
            $(document).ready(function(){
                $("#example-dataTable").DataTable();
                $("#example-dataTable-2").DataTable();
            });

            // function editfunc(id,cut,st,ct,editfor){
            //     window.location.href='edit_customer.php?vkvbvjfgfikix='+id+'&ncy='+cut+'&mst='+st+'&hct='+ct+'&editfor='+editfor;
            // };

            // function addRefFunc(id,taID,cut,st,ct,editfor){
            //     window.location.href='add_customer.php?vkvbvjfgfikix='+id+'&taId='+taID+'&ncy='+cut+'&mst='+st+'&hct='+ct+'&editfor='+editfor;
            // };
            
            // function deletefunc(id,refid,action,userId,userType){
            //     var dataString = 'id='+id+'&refid='+refid+'&action='+action+'&userId='+userId+'&userType='+userType

            //     $.ajax({
            //         type: "POST",
            //         url: "customer/delete_customer_data.php",
            //         data: dataString,
            //         cache: false,
            //         success:function(data){
            //             console.log(data);
            //             if( data == 0 ){
            //                 alert("Deleted Succesfully");
            //                 window.location.reload();
            //             }else if( data == 1 ){
            //                 alert("User Activated Succesfully");
            //                 window.location.reload();
            //             }else if( data == 2 ){
            //                 alert("User Restored Succesfully");
            //                 window.location.reload();
            //             }else if( data == 3 ){
            //                 alert("User Deactivated Succesfully");
            //                 window.location.reload();
            //             } else {
            //                 alert("Request Failed !!");
            //             }
            //         }
            //     });
            // };


            // function overviewPage(id,ref,cut,st,ct,message){
            //     var designation = 'ca_customer';
            //     window.location.href='overview.php?id='+id+'&ref='+ref+'&cut='+cut+'&st='+st+'&ct='+ct+'&message='+message+'&designation='+designation;
            // }
        </script>
        <!-- dialer logic scripts -->
        <script>
            document.addEventListener("DOMContentLoaded", function () {

                const callBtn = document.getElementById("callBtn");

                if (callBtn) {
                    callBtn.addEventListener("click", function(e) {

                        let isMobile = /iPhone|iPad|iPod|Android/i.test(navigator.userAgent);

                        if (!isMobile) {
                            e.preventDefault();

                            alert("📞 Calling works only on mobile devices.\nPlease dial 8010892265 from your phone.");
                            location.reload();

                            // Optional clipboard copy (safe fallback)
                            if (navigator.clipboard) {
                                navigator.clipboard.writeText("8010892265");
                            }
                        }
                    });
                }

            });
        </script>

        <script>
            var modal = document.getElementById('staticBackdrop');

            // Store the element that opened the modal
            let lastFocusedElement;

            document.addEventListener('click', function(e) {
                if (e.target.closest('[data-bs-toggle="modal"]')) {
                    lastFocusedElement = e.target;
                }
            });

            modal.addEventListener('hidden.bs.modal', function () {
                if (lastFocusedElement) {
                    lastFocusedElement.focus();
                } else {
                    document.body.focus();
                }
            });
        </script>
        <!-- end dialer logic scripts -->
    </body>
</html>