<?php
    include_once (__DIR__.'/../dashboard_user_details.php');
?>
<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable">
    <head>

        <meta charset="utf-8" />
        <title>Profile | Dashboard</title>
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
        <link rel="stylesheet" href="css/profile.css" />
        <!-- Customer Dashboard CSS -->
        <link rel="stylesheet" href="../assets/css/super_techno_enterprise.css" />
        <!-- FontAwesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <!-- add on 11-06-2026 by SV -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css">
    </head>
    <body>
 
        <!-- Begin page -->
        <div id="layout-wrapper">

            <?php 
                    include_once 'super_techno_header.php'; 
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
                    include_once 'super_techno_sidebar.php'; 
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
                                    <h4 class="mb-sm-0">Profile</h4>
                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="super_techno_dashboard.php">Dashboard</a></li>
                                            <li class="breadcrumb-item active">View Profile</li>
                                        </ol>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end page title -->
                        <div class="image-wrapper rounded-4 mb-3">
                            <img src="../assets/images/profileBackgroundImg.png" alt="" class="rounded-4 profileBackgroundImg">
                            <div class="profileDetails">
                                <div class="row">
                                    <div class="col-lg-2 col-md-2 col-sm-3 col-12 profilePicUserCol">
                                        <img src="../assets/images/users/avatar-4.jpg" alt="" class="profilePicUser">
                                    </div>
                                    <div class="col-lg-10 col-md-10 col-sm-9 col-12 profilePicDetails">
                                        <div class="d-flex gap-3">
                                            <h2 class="fw-bolder text-white">Uriel Roberts</h2>
                                            <p class="rounded-pill bg-success text-white fs-6 text-center px-2 py-1">Verified<i class="fa-solid fa-check ms-2"></i></span>  
                                        </div>
                                        <p class="fs-5 text-white mb-2">STE26003 | <span>Super Techno Enterprise</span></p>
                                        <p class="fs-5 text-white mb-2">Building Dreams <i class="fa-solid fa-circle mx-2 fa-2xs"></i> Exploring Destinations <i class="fa-solid fa-circle mx-2 fa-2xs"></i> Creating Leaders</p>
                                        <div class="d-flex gap-3 mb-2 profilePicCard1">
                                            <p class="fs-5 text-white"><i class="fa-regular fa-envelope"></i> nkjsfdghs@gmail.com |</p> 
                                            <p class="fs-5 text-white"><i class="fa-solid fa-phone"></i> +91 9876543210 |</p> 
                                            <p class="fs-5 text-white"><i class="fa-solid fa-location-dot"></i> Dempo Towers, Panjim - Goa</p>
                                        </div>
                                        <p class="fs-5 text-white"><i class="fa-regular fa-calendar-days"></i> Member Since: 10 July 2026 </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- card section1 -->
                        <div class="card border rounded-4">
                            <div class="row cardSection1 d-flex justify-content-around">
                                <div class="col-lg-2 col-md-3 col-sm-4 col-6">
                                    <div class="d-flex gap-2 py-3 px-1">
                                        <div class="icon1">
                                            <i class="fa-solid fa-circle-check fa-2xl"></i>
                                        </div>
                                        <div class="align-content-center">
                                            <p class="fs-6 text-dark mb-0">Account Status</p>
                                            <p class="fs-5 fw-bold text-success mb-0">Approved</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-3 col-sm-4 col-6">
                                    <div class="d-flex gap-2 py-3 px-1">
                                        <div class="icon2">
                                            <i class="fa-solid fa-square-check fa-2xl"></i>
                                        </div>
                                        <div class="align-content-center">
                                            <p class="fs-6 text-dark mb-0">KYC Status</p>
                                            <p class="fs-5 fw-bold text-dark mb-0">Completed</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-3 col-sm-4 col-6">
                                    <div class="d-flex gap-2 py-3 px-1">
                                        <div class="icon3">
                                            <i class="fa-solid fa-file fa-2xl"></i>
                                        </div>
                                        <div class="align-content-center">
                                            <p class="fs-6 text-dark mb-0">Total Documents</p>
                                            <p class="fs-5 fw-bold text-dark mb-0">5 / 6</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-3 col-sm-4 col-6">
                                    <div class="d-flex gap-2 py-3 px-1">
                                        <div class="icon4">
                                            <i class="fa-solid fa-users fa-2xl"></i>
                                        </div>
                                        <div class="align-content-center">
                                            <p class="fs-6 text-dark mb-0">Team Capacity</p>
                                            <p class="fs-5 fw-bold text-dark mb-0">0</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-3 col-sm-4 col-6">
                                    <div class="d-flex gap-2 py-3 px-1">
                                        <div class="icon5">
                                            <i class="fa-solid fa-star fa-2xl"></i>
                                        </div>
                                        <div class="align-content-center">
                                            <p class="fs-6 text-dark mb-0">Leadership Score</p>
                                            <p class="fs-5 fw-bold text-dark mb-0">NA</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> <!-- container-fluid -->
                </div><!-- End Page-content -->
                <?php 
                        include_once "super_techno_footer.php"; 
                ?>
            </div><!-- end main content-->
        </div><!-- END layout-wrapper -->

        <!--start back-to-top-->
        <button onclick="topFunction()" class="scrollToTop scroll-btn show btn" id="back-to-top">
            <i class="ri-arrow-up-line"></i>
        </button>
        <!--end back-to-top-->
        <!-- contact card pop up  start-->
        <button type="button" class="contactBtn btn" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
            <i class="ri-phone-fill"></i>
        </button>
        <?php include (__DIR__.'/../contact_modal.php') ?>
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
        
        <!-- App js -->
        <script src="../assets/js/app.js"></script>
        <!-- add on 11-06-2026 by SV -->
        <script src="https://cdn.jsdelivr.net/npm/moment/min/moment.min.js"></script>

        <script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
        <!-- add on 11-06-2026 by SV END-->
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