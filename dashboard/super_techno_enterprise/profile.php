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
                        <div class="card border rounded-4 mb-3">
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
                        <!-- card section2 -->
                        <div class="row">
                            <div class="col-lg-6 col-md-6 colsm-12 col-12">
                                <div class="card border rounded-4 cardHeight">
                                    <div class="d-flex justify-content-between p-3">
                                        <p class="align-content-center fs-4 fw-bold mb-0"><i class="fa-solid fa-user fa-xl me-2" style="color: #43079e;"></i>Personal Information</p>
                                        <p class="editBtn mb-0">Edit</p>
                                    </div>
                                    <hr class="text-muted border-3 mt-0 mx-3">
                                    <div class="row">
                                        <div class="col-lg-5 col-md-5 col-sm-5 col-5 pe-0">
                                            <table class="table">
                                                <tbody>
                                                    <tr>
                                                        <th class="text-muted fontSize1 pe-0">Frist Name</th>
                                                        <td class="fw-bolder text-dark fontSize1 ps-0">Uriel</td>
                                                    </tr>
                                                    <tr>
                                                        <th class="text-muted fontSize1 pe-0" scope="row">Last Name</th>
                                                        <td class="fw-bolder text-dark fontSize1 ps-0">Roberts</td>
                                                    </tr>
                                                    <tr>
                                                        <th class="text-muted fontSize1 pe-0" scope="row">Date of Birth</th>
                                                        <td class="fw-bolder text-dark fontSize1 ps-0">20-10-1990</td>
                                                    </tr>
                                                    <tr>
                                                        <th class="text-muted fontSize1 pe-0" scope="row">Gender</th>
                                                        <td class="fw-bolder text-dark fontSize1 ps-0">Male</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="col-lg-7 col-md-7 col-sm-7 col-7 ps-0">
                                            <table class="table">
                                                <tbody>
                                                    <tr>
                                                        <th class="text-muted fontSize1 pe-0" scope="row">Mobile Number</th>
                                                        <td class="fw-bolder text-dark fontSize1 ps-0">9812334568</td>
                                                    </tr>
                                                    <tr>
                                                        <th class="text-muted fontSize1 pe-0" scope="row">Email Address</th>
                                                        <td class="fw-bolder text-dark fontSize1 ps-0">goswamiab@gmail.com</td>
                                                    </tr>
                                                    <tr>
                                                        <th class="text-muted fontSize1 pe-0" scope="row">Nationality</th>
                                                        <td class="fw-bolder text-dark fontSize1 ps-0">Indian</td>
                                                    </tr>
                                                    <tr>
                                                        <th class="text-muted fontSize1 pe-0" scope="row">Marital Status</th>
                                                        <td class="fw-bolder text-dark fontSize1 ps-0">Married</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 colsm-12 col-12">
                                <div class="card border rounded-4 cardHeight">
                                    <div class="d-flex justify-content-between p-3">
                                        <p class="align-content-center fs-4 fw-bold mb-0"><i class="fa-solid fa-location-dot fa-xl me-2" style="color: #43079e;"></i>Residential Address</p>
                                        <p class="editBtn mb-0">Edit</p>
                                    </div>
                                    <hr class="text-muted border-3 mt-0 mx-3">
                                    <div class="row">
                                        <div class="mx-3">
                                            <p class="text-muted mb-1">Address</p>
                                            <p class="text-dark fw-bolder mb-2">Lal Darwaja, Salabatpura</p>
                                        </div>
                                        <div class="col-lg-5 col-md-5 col-sm-5 col-5 pe-0">
                                            <table class="table">
                                                <tbody>
                                                    <tr>
                                                        <th class="text-muted fontSize1 pe-0">City</th>
                                                    </tr>
                                                    <tr>
                                                        <th class="text-muted fontSize1 pe-0" scope="row">State</th>
                                                    </tr>
                                                    <tr>
                                                        <th class="text-muted fontSize1 pe-0" scope="row">Country</th>
                                                    </tr>
                                                    <tr>
                                                        <th class="text-muted fontSize1 pe-0" scope="row">Pincode</th>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="col-lg-7 col-md-7 col-sm-7 col-7 ps-0">
                                            <table class="table">
                                                <tbody>
                                                    <tr>
                                                        <th class="text-dark fw-bolder fontSize1 pe-0" scope="row">Surat</th>
                                                    </tr>
                                                    <tr>
                                                        <th class="text-dark fw-bolder fontSize1 pe-0" scope="row">Gujarat</th>
                                                    </tr>
                                                    <tr>
                                                        <th class="text-dark fw-bolder fontSize1 pe-0" scope="row">India</th>
                                                    </tr>
                                                    <tr>
                                                        <th class="text-dark fw-bolder fontSize1 pe-0" scope="row">441460</th>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- card section3 -->
                        <div class="row">
                            <div class="col-lg-6 col-md-6 colsm-12 col-12">
                                <div class="card border rounded-4 cardHeight">
                                    <div class="d-flex justify-content-between p-3">
                                        <p class="align-content-center fs-4 fw-bold mb-0"><i class="fa-solid fa-briefcase fa-xl me-2" style="color: #43079e;"></i>Professional Details</p>
                                        <p class="editBtn mb-0">Edit</p>
                                    </div>
                                    <hr class="text-muted border-3 mt-0 mx-3">
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-6 pe-0">
                                            <table class="table">
                                                <tbody>
                                                    <tr>
                                                        <th class="text-muted fontSize1 pe-0">Occupation</th>
                                                        <td class="fw-bolder text-dark fontSize1 ps-0">At enum a official vel</td>
                                                    </tr>
                                                    <tr>
                                                        <th class="text-muted fontSize1 pe-0" scope="row">Designation</th>
                                                        <td class="fw-bolder text-dark fontSize1 ps-0">Super Techno Enterprise</td>
                                                    </tr>
                                                    <tr>
                                                        <th class="text-muted fontSize1 pe-0" scope="row">Experience</th>
                                                        <td class="fw-bolder text-dark fontSize1 ps-0">10+ Years</td>
                                                    </tr>
                                                    <tr>
                                                        <th class="text-muted fontSize1 pe-0" scope="row">Monthly Income</th>
                                                        <td class="fw-bolder text-dark fontSize1 ps-0">&#8377;50,000</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-6 ps-0">
                                            <table class="table">
                                                <tbody>
                                                    <tr>
                                                        <th class="text-muted fontSize1 pe-0" scope="row">Industry</th>
                                                        <td class="fw-bolder text-dark fontSize1 ps-0">Travel</td>
                                                    </tr>
                                                    <tr>
                                                        <th class="text-muted fontSize1 pe-0" scope="row">Organisation / Business</th>
                                                        <td class="fw-bolder text-dark fontSize1 ps-0">NA</td>
                                                    </tr>
                                                    <tr>
                                                        <th class="text-muted fontSize1 pe-0" scope="row">Professional Summary</th>
                                                        <td class="fw-bolder text-dark fontSize1 ps-0">NA</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 colsm-12 col-12">
                                <div class="card border rounded-4 cardHeight">
                                    <div class="d-flex justify-content-between p-3">
                                        <p class="align-content-center fs-4 fw-bold mb-0"><i class="fa-solid fa-user-tie fa-xl me-2" style="color: #43079e;"></i>Leadership Assessment</p>
                                        <p class="align-content-center fs-4 fw-bold mb-0"><i class="fa-solid fa-spinner fa-xl me-2" style="color: #43079e;"></i></p>
                                    </div>
                                    <hr class="text-muted border-3 mt-0 mx-3">
                                    <div class="row px-3">
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-6 mb-2">
                                            <div class="d-flex gap-3 leaderCard">
                                                <div class="align-content-center">
                                                    <i class="fa-solid fa-users fa-2xl" style="color: #ffa600;"></i>
                                                </div>
                                                <div class="align-content-center">
                                                    <p class="fs-4 fw-bold text-dark mb-0">0</p>
                                                    <p class="fs-6 text-muted mb-0">Team Capacity</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-6 mb-2">
                                            <div class="d-flex gap-3 leaderCard">
                                                <div class="align-content-center">
                                                    <i class="fa-solid fa-user-tie fa-2xl" style="color: #ffa600;"></i>
                                                </div>
                                                <div class="align-content-center">
                                                    <p class="fs-4 fw-bold text-dark mb-0">NA</p>
                                                    <p class="fs-6 text-muted mb-0">Leadership</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-6 mb-2">
                                            <div class="d-flex gap-3 leaderCard">
                                                <div class="align-content-center">
                                                    <i class="fa-solid fa-bullhorn fa-2xl" style="color: #ffa600;"></i>
                                                </div>
                                                <div class="align-content-center">
                                                    <p class="fs-4 fw-bold text-dark mb-0">NA</p>
                                                    <p class="fs-6 text-muted mb-0">Public Speaking</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-6 mb-2">
                                            <div class="d-flex gap-3 leaderCard">
                                                <div class="align-content-center">
                                                    <i class="fa-solid fa-handshake fa-2xl" style="color: #ffa600;"></i>
                                                </div>
                                                <div class="align-content-center">
                                                    <p class="fs-4 fw-bold text-dark mb-0">NA</p>
                                                    <p class="fs-6 text-muted mb-0">Networking</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mx-3 mt-2">
                                        <p class="fs-6 text-muted mb-2">Leadership Index</p>
                                        <div class="progress" role="progressbar" aria-label="Warning example" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100">
                                            <div class="progress-bar bg-warning" style="width: 85%"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- card section4 -->
                        <div class="row">
                            <div class="col-lg-6 col-md-6 colsm-12 col-12">
                                <div class="card border rounded-4 cardHeight2">
                                    <div class="d-flex justify-content-between p-3">
                                        <p class="align-content-center fs-4 fw-bold mb-0"><i class="fa-solid fa-user-group fa-xl me-2" style="color: #43079e;"></i>Nominee Details</p>
                                        <p class="editBtn mb-0">Edit</p>
                                    </div>
                                    <hr class="text-muted border-3 mt-0 mx-3">
                                    <div class="row">
                                        <div class="col-lg-5 col-md-5 col-sm-5 col-5 pe-0">
                                            <table class="table">
                                                <tbody>
                                                    <tr>
                                                        <th class="text-muted fontSize1 pe-0">Nominee Name</th>
                                                    </tr>
                                                    <tr>
                                                        <th class="text-muted fontSize1 pe-0" scope="row">Relationship</th>
                                                    </tr>
                                                    <tr>
                                                        <th class="text-muted fontSize1 pe-0" scope="row">Mobile Number</th>
                                                    </tr>
                                                    <tr>
                                                        <th class="text-muted fontSize1 pe-0" scope="row">Date of Birth</th>
                                                    </tr>
                                                    <tr>
                                                        <th class="text-muted fontSize1 pe-0" scope="row">Address</th>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="col-lg-7 col-md-7 col-sm-7 col-7 ps-0">
                                            <table class="table">
                                                <tbody>
                                                    <tr>
                                                        <th class="text-dark fw-bolder fontSize1 pe-0" scope="row">Aquila Mejia</th>
                                                    </tr>
                                                    <tr>
                                                        <th class="text-dark fw-bolder fontSize1 pe-0" scope="row">Voluptas ad utue app</th>
                                                    </tr>
                                                    <tr>
                                                        <th class="text-dark fw-bolder fontSize1 pe-0" scope="row">+919850325145</th>
                                                    </tr>
                                                    <tr>
                                                        <th class="text-dark fw-bolder fontSize1 pe-0" scope="row">20-05-1980</th>
                                                    </tr>
                                                    <tr>
                                                        <th class="text-dark fw-bolder fontSize1 pe-0" scope="row">Nilhil similique ipsa</th>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 colsm-12 col-12">
                                <div class="card border rounded-4 cardHeight2">
                                    <div class="d-flex justify-content-between p-3">
                                        <p class="align-content-center fs-4 fw-bold mb-0"><i class="fa-solid fa-building-columns fa-xl me-2" style="color: #03730f;"></i>Banking Information</p>
                                        <p class="editBtn mb-0">Edit</p>
                                    </div>
                                    <hr class="text-muted border-3 mt-0 mx-3">
                                    <div class="row">
                                        <div class="col-lg-5 col-md-5 col-sm-5 col-5 pe-0">
                                            <table class="table">
                                                <tbody>
                                                    <tr>
                                                        <th class="text-muted fontSize1 pe-0">Account Holder Name</th>
                                                    </tr>
                                                    <tr>
                                                        <th class="text-muted fontSize1 pe-0" scope="row">Bank Name</th>
                                                    </tr>
                                                    <tr>
                                                        <th class="text-muted fontSize1 pe-0" scope="row">Account Number</th>
                                                    </tr>
                                                    <tr>
                                                        <th class="text-muted fontSize1 pe-0" scope="row">IFSC Code</th>
                                                    </tr>
                                                    <tr>
                                                        <th class="text-muted fontSize1 pe-0" scope="row">Branch</th>
                                                    </tr>
                                                    <tr>
                                                        <th class="text-muted fontSize1 pe-0" scope="row">UPI ID</th>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="col-lg-7 col-md-7 col-sm-7 col-7 ps-0">
                                            <table class="table">
                                                <tbody>
                                                    <tr>
                                                        <th class="text-dark fw-bolder fontSize1 pe-0" scope="row">Eden Andrews</th>
                                                    </tr>
                                                    <tr>
                                                        <th class="text-dark fw-bolder fontSize1 pe-0" scope="row">Ocus sunt laborumd id</th>
                                                    </tr>
                                                    <tr>
                                                        <th class="text-dark fw-bolder fontSize1 pe-0" scope="row">xxxxxxxx6688</th>
                                                    </tr>
                                                    <tr>
                                                        <th class="text-dark fw-bolder fontSize1 pe-0" scope="row">SBIN0001234</th>
                                                    </tr>
                                                    <tr>
                                                        <th class="text-dark fw-bolder fontSize1 pe-0" scope="row">Asher Olsen</th>
                                                    </tr>
                                                    <tr>
                                                        <th class="text-dark fw-bolder fontSize1 pe-0" scope="row">eden.andrews@upi</th>
                                                    </tr>
                                                </tbody>
                                            </table>
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