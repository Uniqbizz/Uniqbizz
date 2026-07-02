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
        <link rel="stylesheet" href="../assets/css/sponsor_franchisee_dashboard.css" />
        <!-- FontAwesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <!-- add on 11-06-2026 by SV -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    </head>
    <body>
 
        <!-- Begin page -->
        <div id="layout-wrapper">

            <?php 
                    include_once 'sponsor_franchisee_header.php'; 
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
                    include_once 'sponsor_franchisee_sidebar.php'; 
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
                                            <li class="breadcrumb-item"><a href="sponsor_franchisee_dashboard.php">Dashboard</a></li>
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
                                        <img id="profilePic" src="../assets/images/users/avatar-4.jpg" alt="" class="profilePicUser">
                                    </div>
                                    <div class="col-lg-10 col-md-10 col-sm-9 col-12 profilePicDetails">
                                        <div class="d-flex gap-3">
                                            <h2 class="fw-bolder text-white" id="profileName"></h2>
                                            <p class="rounded-pill bg-success text-white fs-6 text-center mb-0 verificationIcon" id="verification_status"></span>  
                                        </div>
                                        <p class="fs-5 text-white mb-2" id="profileId"><span id="profileType"></span></p>
                                        <p class="fs-5 text-white mb-2">Building Dreams <i class="fa-solid fa-circle mx-2 fa-2xs"></i> Exploring Destinations <i class="fa-solid fa-circle mx-2 fa-2xs"></i> Creating Leaders</p>
                                        <div class="row mb-2 profilePicCard1">
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-12 d-flex gap-3 profilePicCard2">
                                                <p class="fs-5 text-white" id="profileEmail"><i class="fa-regular fa-envelope"></i></p> 
                                                <p class="fs-5 text-white" id="profilePhone"><i class="fa-solid fa-phone"></i></p> 
                                            </div>
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-12 d-flex gap-1">
                                                <p class="text-white"><i class="fa-solid fa-location-dot mt-1"></i></p>
                                                <p class="fs-5 text-white mb-0" id="profileAddress"></p>
                                            </div>
                                        </div>
                                        <p class="fs-5 text-white" id="profileSince"><i class="fa-regular fa-calendar-days"></i></p>
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
                                            <p class="fs-5 fw-bold text-dark mb-0" id="kycStatus">Completed</p>
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
                                            <p class="fs-5 fw-bold text-dark mb-0" id="docCount"></p>
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
                                                        <td class="fw-bolder text-dark fontSize1 ps-0" id="perInfoFname"></td>
                                                    </tr>
                                                    <tr>
                                                        <th class="text-muted fontSize1 pe-0" scope="row">Last Name</th>
                                                        <td class="fw-bolder text-dark fontSize1 ps-0" id="perInfoLname"></td>
                                                    </tr>
                                                    <tr>
                                                        <th class="text-muted fontSize1 pe-0" scope="row">Date of Birth</th>
                                                        <td class="fw-bolder text-dark fontSize1 ps-0" id="perInfoDob"></td>
                                                    </tr>
                                                    <tr>
                                                        <th class="text-muted fontSize1 pe-0" scope="row">Gender</th>
                                                        <td class="fw-bolder text-dark fontSize1 ps-0" id="perInfoGender"></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="col-lg-7 col-md-7 col-sm-7 col-7 ps-0">
                                            <table class="table">
                                                <tbody>
                                                    <tr>
                                                        <th class="text-muted fontSize1 pe-0" scope="row">Mobile Number</th>
                                                        <td class="fw-bolder text-dark fontSize1 ps-0" id="perInfoPhone">9812334568</td>
                                                    </tr>
                                                    <tr>
                                                        <th class="text-muted fontSize1 pe-0" scope="row">Email Address</th>
                                                        <td class="fw-bolder text-dark fontSize1 ps-0" id="perInfoEmail">goswamiab@gmail.com</td>
                                                    </tr>
                                                    <tr>
                                                        <th class="text-muted fontSize1 pe-0" scope="row">Nationality</th>
                                                        <td class="fw-bolder text-dark fontSize1 ps-0" id="perInfoNatinality">Indian</td>
                                                    </tr>
                                                    <tr>
                                                        <th class="text-muted fontSize1 pe-0" scope="row">Father / Spouse Name</th>
                                                        <td class="fw-bolder text-dark fontSize1 ps-0" id="perInfoFs"></td>
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
                                            <p class="text-dark fw-bolder mb-2" id="resAdd">Lal Darwaja, Salabatpura</p>
                                        </div>
                                        <div class="col-lg-5 col-md-5 col-sm-5 col-5 pe-0">
                                            <table class="table">
                                                <tbody>
                                                    <tr>
                                                        <th class="text-muted fontSize1 pe-0" >City</th>
                                                    </tr>
                                                    <tr>
                                                        <th class="text-muted fontSize1 pe-0" scope="row" >State</th>
                                                    </tr>
                                                    <tr>
                                                        <th class="text-muted fontSize1 pe-0" scope="row" >Country</th>
                                                    </tr>
                                                    <tr>
                                                        <th class="text-muted fontSize1 pe-0" scope="row" >Pincode</th>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="col-lg-7 col-md-7 col-sm-7 col-7 ps-0">
                                            <table class="table">
                                                <tbody>
                                                    <tr>
                                                        <th class="text-dark fw-bolder fontSize1 pe-0" scope="row" id="city">-</th>
                                                    </tr>
                                                    <tr>
                                                        <th class="text-dark fw-bolder fontSize1 pe-0" scope="row" id="state">-</th>
                                                    </tr>
                                                    <tr>
                                                        <th class="text-dark fw-bolder fontSize1 pe-0" scope="row" id="country">-</th>
                                                    </tr>
                                                    <tr>
                                                        <th class="text-dark fw-bolder fontSize1 pe-0" scope="row" id="pincode">-</th>
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
                                                        <td class="fw-bolder text-dark fontSize1 ps-0" id="occName">NA</td>
                                                    </tr>
                                                    <tr>
                                                        <th class="text-muted fontSize1 pe-0" scope="row">Designation</th>
                                                        <td class="fw-bolder text-dark fontSize1 ps-0" id="occDes">NA</td>
                                                    </tr>
                                                    <tr>
                                                        <th class="text-muted fontSize1 pe-0" scope="row">Experience</th>
                                                        <td class="fw-bolder text-dark fontSize1 ps-0" id="occExp">NA</td>
                                                    </tr>
                                                    <tr>
                                                        <th class="text-muted fontSize1 pe-0" scope="row">Monthly Income</th>
                                                        <td class="fw-bolder text-dark fontSize1 ps-0" id="occIncome">&#8377; 0</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-6 ps-0">
                                            <table class="table">
                                                <tbody>
                                                    <tr>
                                                        <th class="text-muted fontSize1 pe-0" scope="row">Industry</th>
                                                        <td class="fw-bolder text-dark fontSize1 ps-0" id="occInd">NA</td>
                                                    </tr>
                                                    <tr>
                                                        <th class="text-muted fontSize1 pe-0" scope="row">Organisation / Business</th>
                                                        <td class="fw-bolder text-dark fontSize1 ps-0" id="occOrg">NA</td>
                                                    </tr>
                                                    <tr>
                                                        <th class="text-muted fontSize1 pe-0" scope="row">Professional Summary</th>
                                                        <td class="fw-bolder text-dark fontSize1 ps-0" id="occSum">NA</td>
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
                                                        <th class="text-muted fontSize1 pe-0">Relationship</th>
                                                    </tr>
                                                    <tr>
                                                        <th class="text-muted fontSize1 pe-0">Mobile Number</th>
                                                    </tr>
                                                    <tr>
                                                        <th class="text-muted fontSize1 pe-0">Date of Birth</th>
                                                    </tr>
                                                    <tr>
                                                        <th class="text-muted fontSize1 pe-0">Address</th>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="col-lg-7 col-md-7 col-sm-7 col-7 ps-0">
                                            <table class="table">
                                                <tbody>
                                                    <tr>
                                                        <th class="text-dark fw-bolder fontSize1 pe-0" scope="row" id="nomineeName">NA</th>
                                                    </tr>
                                                    <tr>
                                                        <th class="text-dark fw-bolder fontSize1 pe-0" scope="row" id="nomineeRelation">NA</th>
                                                    </tr>
                                                    <tr>
                                                        <th class="text-dark fw-bolder fontSize1 pe-0" scope="row" id="nomineePhone">NA</th>
                                                    </tr>
                                                    <tr>
                                                        <th class="text-dark fw-bolder fontSize1 pe-0" scope="row" id="nomineeDob">NA</th>
                                                    </tr>
                                                    <tr>
                                                        <th class="text-dark fw-bolder fontSize1 pe-0" scope="row" id="nomineeAddress">NA</th>
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
                                                        <th class="text-dark fw-bolder fontSize1 pe-0" scope="row" id="accHolderName">NA</th>
                                                    </tr>
                                                    <tr>
                                                        <th class="text-dark fw-bolder fontSize1 pe-0" scope="row" id="bankName">NA</th>
                                                    </tr>
                                                    <tr>
                                                        <th class="text-dark fw-bolder fontSize1 pe-0" scope="row" id="accountNumber">NA</th>
                                                    </tr>
                                                    <tr>
                                                        <th class="text-dark fw-bolder fontSize1 pe-0" scope="row" id="ifscCode"></th>
                                                    </tr>
                                                    <tr>
                                                        <th class="text-dark fw-bolder fontSize1 pe-0" scope="row" id="branchName">NA</th>
                                                    </tr>
                                                    <tr>
                                                        <th class="text-dark fw-bolder fontSize1 pe-0" scope="row" id="upiId">NA</th>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- card section5 -->
                        <div class="card border rounded-4">
                            <div class="p-3">
                                <p class="align-content-center fs-4 fw-bold mb-0"><i class="fa-solid fa-file-arrow-up fa-xl me-2" style="color: #43079e;"></i>Documents Gallery</p>
                            </div>
                            <hr class="text-muted border-3 mt-0 mx-3">
                            <div class="row mx-2">
                                <!-- Profile Photo -->
                                <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 mb-3">
                                    <div class="document-card">
                                        <!-- <input type="file" id="file1" class="file-input d-none" accept="image/*,.pdf" data-preview="preview1" data-view="view1" data-download="download1" disabled> -->
                                        <label for="file1" class="upload-area">
                                            <span class="document-status verified"  data-document="profile_pic">Verified</span>
                                            <img id="preview1" src="https://placehold.co/300x180?text=Profile+Photo" class="doc-preview">
                                            <div class="upload-overlay">
                                                <!-- <i class="fa-solid fa-cloud-arrow-up"></i>
                                                <span>Drag & Drop</span>
                                                <small>or click to upload</small> -->
                                            </div>
                                        </label>
                                        <p class="text-center fw-semibold mt-2">Profile Photo</p>
                                        <div class="d-flex gap-2">
                                            <a id="view1" class="py-1 btn btn-outline-secondary flex-fill disabled" target="_blank">
                                                View
                                            </a>
                                            <a id="download1" class="py-1 btn btn-success disabled" download>
                                                <i class="fa-solid fa-download"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <!-- Aadhaar -->
                                <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 mb-3">
                                    <div class="document-card">
                                        <!-- <input type="file" id="file2" class="file-input d-none" accept="image/*,.pdf" data-preview="preview2" data-view="view2" data-download="download2" disabled> -->
                                        <label for="file2" class="upload-area">
                                            <span class="document-status pending" data-document="aadhar_card">Pending</span>
                                            <img id="preview2" src="https://placehold.co/300x180?text=Profile+Photo" class="doc-preview">
                                            <div class="upload-overlay">
                                                <!-- <i class="fa-solid fa-cloud-arrow-up"></i>
                                                <span>Drag & Drop</span>
                                                <small>or click to upload</small> -->
                                            </div>
                                        </label>
                                        <p class="text-center fw-semibold mt-2">Aadhaar Card</p>
                                        <div class="d-flex gap-2">
                                            <a id="view2" class="py-1 btn btn-outline-secondary flex-fill disabled" target="_blank">
                                                View
                                            </a>
                                            <a id="download2" class="py-1 btn btn-success disabled" download>
                                                <i class="fa-solid fa-download"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <!-- PAN -->
                                <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 mb-3">
                                    <div class="document-card">
                                        <!-- <input type="file" id="file3" class="file-input d-none" accept="image/*,.pdf" data-preview="preview3" data-view="view3" data-download="download3" disabled> -->
                                        <label for="file3" class="upload-area">
                                            <span class="document-status verified" data-document="pan_card">Verified</span>
                                            <img id="preview3" src="https://placehold.co/300x180?text=Profile+Photo" class="doc-preview">
                                            <div class="upload-overlay">
                                                <!-- <i class="fa-solid fa-cloud-arrow-up"></i>
                                                <span>Drag & Drop</span>
                                                <small>or click to upload</small> -->
                                            </div>
                                        </label>
                                        <p class="text-center fw-semibold mt-2">PAN Card</p>
                                        <div class="d-flex gap-2">
                                            <a id="view3" class="py-1 btn btn-outline-secondary flex-fill disabled" target="_blank">
                                                View
                                            </a>
                                            <a id="download3" class="py-1 btn btn-success disabled" download>
                                                <i class="fa-solid fa-download"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <!-- Passbook -->
                                <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 mb-3">
                                    <div class="document-card">
                                        <!-- <input type="file" id="file4" class="file-input d-none" accept="image/*,.pdf" data-preview="preview4" data-view="view4" data-download="download4" disabled> -->
                                        <label for="file4" class="upload-area">
                                            <span class="document-status pending" data-document="cancelled_cheque_bank_passbook">Pending</span>
                                            <img id="preview4" src="https://placehold.co/300x180?text=Profile+Photo" class="doc-preview">
                                            <div class="upload-overlay">
                                                <!-- <i class="fa-solid fa-cloud-arrow-up"></i>
                                                <span>Drag & Drop</span>
                                                <small>or click to upload</small> -->
                                            </div>
                                        </label>
                                        <p class="text-center fw-semibold mt-2">Bank Passbook</p>
                                        <div class="d-flex gap-2">
                                            <a id="view4" class="py-1 btn btn-outline-secondary flex-fill disabled" target="_blank">
                                                View
                                            </a>
                                            <a id="download4" class="py-1 btn btn-success disabled" download>
                                                <i class="fa-solid fa-download"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <!-- Resume CV -->
                                <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 mb-3">
                                    <div class="document-card">
                                        <!-- <input type="file" id="file5" class="file-input d-none" accept="image/*,.pdf" data-preview="preview5" data-view="view5" data-download="download5" disabled> -->
                                        <label for="file5" class="upload-area">
                                            <span class="document-status verified" data-document="resume_cv">Verified</span>
                                            <img id="preview5" src="https://placehold.co/300x180?text=Profile+Photo" class="doc-preview">
                                            <div class="upload-overlay">
                                                <!-- <i class="fa-solid fa-cloud-arrow-up"></i>
                                                <span>Drag & Drop</span>
                                                <small>or click to upload</small> -->
                                            </div>
                                        </label>
                                        <p class="text-center fw-semibold mt-2">Resume/CV</p>
                                        <div class="d-flex gap-2">
                                            <a id="view5" class="py-1 btn btn-outline-secondary flex-fill disabled" target="_blank">
                                                View
                                            </a>
                                            <a id="download5" class="py-1 btn btn-success disabled" download>
                                                <i class="fa-solid fa-download"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <!-- Address Proof -->
                                <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 mb-3">
                                    <div class="document-card">
                                        <!-- <input type="file" id="file6" class="file-input d-none" accept="image/*,.pdf" data-preview="preview6" data-view="view6" data-download="download6" disabled> -->
                                        <label for="file6" class="upload-area">
                                            <span class="document-status rejected" data-document="address_proof">Rejected</span>
                                            <img id="preview6" src="https://placehold.co/300x180?text=Profile+Photo" class="doc-preview">
                                            <div class="upload-overlay">
                                                <!-- <i class="fa-solid fa-cloud-arrow-up"></i>
                                                <span>Drag & Drop</span>
                                                <small>or click to upload</small> -->
                                            </div>
                                        </label>
                                        <p class="text-center fw-semibold mt-2">Address Proof</p>
                                        <div class="d-flex gap-2">
                                            <a id="view6" class="py-1 btn btn-outline-secondary flex-fill disabled" target="_blank">
                                                View
                                            </a>
                                            <a id="download6" class="py-1 btn btn-success disabled" download>
                                                <i class="fa-solid fa-download"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <!-- Professional Profile -->
                                <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 mb-3">
                                    <div class="document-card">
                                        <!-- <input type="file" id="file6" class="file-input d-none" accept="image/*,.pdf" data-preview="preview6" data-view="view6" data-download="download6" disabled> -->
                                        <label for="file7" class="upload-area">
                                            <span class="document-status rejected" data-document="professional_profile">Rejected</span>
                                            <img id="preview6" src="https://placehold.co/300x180?text=Profile+Photo" class="doc-preview">
                                            <div class="upload-overlay">
                                                <!-- <i class="fa-solid fa-cloud-arrow-up"></i>
                                                <span>Drag & Drop</span>
                                                <small>or click to upload</small> -->
                                            </div>
                                        </label>
                                        <p class="text-center fw-semibold mt-2">Professional Profile</p>
                                        <div class="d-flex gap-2">
                                            <a id="view7" class="py-1 btn btn-outline-secondary flex-fill disabled" target="_blank">
                                                View
                                            </a>
                                            <a id="download7" class="py-1 btn btn-success disabled" download>
                                                <i class="fa-solid fa-download"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <!-- Business Profile -->
                                <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 mb-3">
                                    <div class="document-card">
                                        <!-- <input type="file" id="file6" class="file-input d-none" accept="image/*,.pdf" data-preview="preview6" data-view="view6" data-download="download6" disabled> -->
                                        <label for="file8" class="upload-area">
                                            <span class="document-status rejected" data-document="business_profile">Rejected</span>
                                            <img id="preview8" src="https://placehold.co/300x180?text=Profile+Photo" class="doc-preview">
                                            <div class="upload-overlay">
                                                <!-- <i class="fa-solid fa-cloud-arrow-up"></i>
                                                <span>Drag & Drop</span>
                                                <small>or click to upload</small> -->
                                            </div>
                                        </label>
                                        <p class="text-center fw-semibold mt-2">Business Profile</p>
                                        <div class="d-flex gap-2">
                                            <a id="view8" class="py-1 btn btn-outline-secondary flex-fill disabled" target="_blank">
                                                View
                                            </a>
                                            <a id="download8" class="py-1 btn btn-success disabled" download>
                                                <i class="fa-solid fa-download"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <!-- Income Proof -->
                                <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 mb-3">
                                    <div class="document-card">
                                        <!-- <input type="file" id="file6" class="file-input d-none" accept="image/*,.pdf" data-preview="preview6" data-view="view6" data-download="download6" disabled> -->
                                        <label for="file9" class="upload-area">
                                            <span class="document-status rejected" data-document="income_proof">Rejected</span>
                                            <img id="preview9" src="https://placehold.co/300x180?text=Profile+Photo" class="doc-preview">
                                            <div class="upload-overlay">
                                                <!-- <i class="fa-solid fa-cloud-arrow-up"></i>
                                                <span>Drag & Drop</span>
                                                <small>or click to upload</small> -->
                                            </div>
                                        </label>
                                        <p class="text-center fw-semibold mt-2">Income Proof</p>
                                        <div class="d-flex gap-2">
                                            <a id="view9" class="py-1 btn btn-outline-secondary flex-fill disabled" target="_blank">
                                                View
                                            </a>
                                            <a id="download9" class="py-1 btn btn-success disabled" download>
                                                <i class="fa-solid fa-download"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <!-- Other Document -->
                                <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 mb-3">
                                    <div class="document-card">
                                        <!-- <input type="file" id="file6" class="file-input d-none" accept="image/*,.pdf" data-preview="preview6" data-view="view6" data-download="download6" disabled> -->
                                        <label for="file10" class="upload-area">
                                            <span class="document-status rejected" data-document="other_document">Rejected</span>
                                            <img id="preview10" src="https://placehold.co/300x180?text=Profile+Photo" class="doc-preview">
                                            <div class="upload-overlay">
                                                <!-- <i class="fa-solid fa-cloud-arrow-up"></i>
                                                <span>Drag & Drop</span>
                                                <small>or click to upload</small> -->
                                            </div>
                                        </label>
                                        <p class="text-center fw-semibold mt-2">Other Document</p>
                                        <div class="d-flex gap-2">
                                            <a id="view10" class="py-1 btn btn-outline-secondary flex-fill disabled" target="_blank">
                                                View
                                            </a>
                                            <a id="download10" class="py-1 btn btn-success disabled" download>
                                                <i class="fa-solid fa-download"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <!-- Nominee Profile -->
                                <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 mb-3">
                                    <div class="document-card">
                                        <!-- <input type="file" id="file6" class="file-input d-none" accept="image/*,.pdf" data-preview="preview6" data-view="view6" data-download="download6" disabled> -->
                                        <label for="file11" class="upload-area">
                                            <span class="document-status rejected" data-document="nominee_profile">Rejected</span>
                                            <img id="preview11" src="https://placehold.co/300x180?text=Profile+Photo" class="doc-preview">
                                            <div class="upload-overlay">
                                                <!-- <i class="fa-solid fa-cloud-arrow-up"></i>
                                                <span>Drag & Drop</span>
                                                <small>or click to upload</small> -->
                                            </div>
                                        </label>
                                        <p class="text-center fw-semibold mt-2">Nominee Profile</p>
                                        <div class="d-flex gap-2">
                                            <a id="view11" class="py-1 btn btn-outline-secondary flex-fill disabled" target="_blank">
                                                View
                                            </a>
                                            <a id="download11" class="py-1 btn btn-success disabled" download>
                                                <i class="fa-solid fa-download"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div> <!-- container-fluid -->
                </div><!-- End Page-content -->
                <?php 
                        include_once "sponsor_franchisee_footer.php"; 
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
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
            document.querySelectorAll('.file-input').forEach(input => {
                const uploadArea = input.nextElementSibling;

                input.addEventListener('change', function () {
                    if (this.files.length) {
                        handleFile(this.files[0], this);
                    }
                });

                ['dragenter', 'dragover'].forEach(event => {
                    uploadArea.addEventListener(event, e => {
                        e.preventDefault();
                        uploadArea.classList.add('drag-over');
                    });
                });

                ['dragleave', 'drop'].forEach(event => {
                    uploadArea.addEventListener(event, e => {
                        e.preventDefault();
                        uploadArea.classList.remove('drag-over');
                    });
                });

                uploadArea.addEventListener('drop', e => {

                    const file = e.dataTransfer.files[0];

                    if (!file) return;

                    const dt = new DataTransfer();
                    dt.items.add(file);

                    input.files = dt.files;

                    handleFile(file, input);
                });
            });

            function handleFile(file, input) {

                const preview = document.getElementById(
                    input.dataset.preview
                );

                const viewBtn = document.getElementById(
                    input.dataset.view
                );

                const downloadBtn = document.getElementById(
                    input.dataset.download
                );

                const fileURL = URL.createObjectURL(file);

                preview.src = fileURL;

                viewBtn.href = fileURL;
                viewBtn.classList.remove('disabled');

                downloadBtn.href = fileURL;
                downloadBtn.download = file.name;
                downloadBtn.classList.remove('disabled');
            }
        </script>
        <script>

            $(document).ready(function () {
                //title card
                $.ajax({
                    url: 'models/profile/title_card.php',
                    type: 'GET',
                    dataType: 'json',
                    data: {
                        user_id: '<?= $userId ?>'
                    },
                    success: function (response) {

                        if (response.status) {

                            let profile = response.data;

                            $('#profilePic').attr(
                                'src',
                                profile.profile_pic
                                    ? '../../uploading/'+profile.profile_pic
                                    : '../assets/images/users/avatar-4.jpg'
                            );

                            $('#profileName').text(profile.profile_name || '');

                            $('#profileId').html(
                                (profile.profile_id || '') +
                                ' | <span id="profileType">' +
                                (profile.profile_type || '') +
                                '</span>'
                            );

                            $('#profileEmail').html(
                                '<i class="fa-regular fa-envelope"></i> ' +
                                (profile.profile_email || '') +
                                ' |'
                            );

                            $('#profilePhone').html(
                                '<i class="fa-solid fa-phone"></i> ' +
                                (profile.profile_phone_prefix || '') +
                                ' ' +
                                (profile.profile_phone || '') +
                                ' |'
                            );

                            $('#profileAddress').html(
                                '<i class="fa-solid fa-location-dot"></i> ' +
                                (profile.profile_address || '')
                            );

                            let memberSince = '';

                            if(profile.verification_status === 'Verified'){

                                $('#verification_status')
                                    .removeClass('bg-warning bg-danger')
                                    .addClass('bg-success')
                                    .html('<i class="fa-solid fa-check me-2"></i>Verified');

                            }else if(profile.verification_status === 'Rejected'){

                                $('#verification_status')
                                    .removeClass('bg-success bg-warning')
                                    .addClass('bg-danger')
                                    .html('<i class="fa-solid fa-times me-2"></i>Rejected');

                            }else{

                                $('#verification_status')
                                    .removeClass('bg-success bg-danger')
                                    .addClass('bg-warning')
                                    .html('<i class="fa-solid fa-exclamation me-2"></i>Pending');
                            }

                            if (profile.profile_since) {
                                let date = new Date(profile.profile_since);

                                memberSince = date.toLocaleDateString('en-GB', {
                                    day: 'numeric',
                                    month: 'long',
                                    year: 'numeric'
                                });
                            }

                            $('#profileSince').html(
                                '<i class="fa-regular fa-calendar-days"></i> Member Since: ' +
                                memberSince
                            );
                        }
                    },
                    error: function (xhr, status, error) {
                        console.log(error);
                    }
                });

                //status card
                $.ajax({
                    url: 'models/profile/sub_title_card.php',
                    type: 'GET',
                    dataType: 'json',
                    data: {
                        user_id: '<?= $userId ?>'
                    },
                    success: function (response) {

                        if (response.status) {

                            let sub_profile = response.data;
                            $('#docCount').text(sub_profile.uploaded_files+' / '+sub_profile.total_documents);
                            $('#kycStatus').text(sub_profile.kyc_status)
                        }
                            
                    },
                    error: function (xhr, status, error) {
                        console.log(error);
                    }
                });
                //personal information card
                loadPersonalInfo('<?= $userId ?>');
                //residential address
                loadResidentialInfo('<?= $userId ?>');
                //professional details
                loadProfessionalInfo('<?= $userId ?>');
                //nominee detals
                loadNomineeInfo('<?= $userId ?>');
                //bank details
                loadBankInfo('<?= $userId ?>');
                //documents
                loadDocuments('<?= $userId ?>');
            });
            function loadPersonalInfo(userId) {

                $.ajax({
                    url: 'models/profile/personal_info_card.php',
                    type: 'GET',
                    dataType: 'json',
                    data: {
                        user_id: userId
                    },
                    success: function(response) {

                        if (response.status) {

                            let data = response.data;

                            $('#perInfoFname').text(data.per_info_fname || '');
                            $('#perInfoLname').text(data.per_info_lname || '');
                            $('#perInfoDob').text(data.per_info_dob || '');
                            $('#perInfoGender').text(data.per_info_gender || '');

                            $('#perInfoPhone').text(
                                (data.per_info_phone_prefix || '') + ' ' +
                                (data.per_info_phone || '')
                            );

                            $('#perInfoEmail').text(data.per_info_email || '');
                            $('#perInfoNatinality').text(data.per_info_nationality || '');
                            $('#perInfoFs').text(data.per_info_father_spouse_name || '');

                        } else {

                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: response.message
                            });

                        }
                    },
                    error: function(xhr, status, error) {

                        console.error(error);

                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Unable to fetch personal information.'
                        });

                    }
                });

            }
            function loadResidentialInfo(userId){
                $.ajax({
                    url: 'models/profile/residential_address.php',
                    type: 'GET',
                    dataType: 'json',
                    data: {
                        user_id: userId
                    },
                    success: function(response){

                        if(response.status){

                            $('#city').text(response.data.city_name);
                            $('#state').text(response.data.state_name);
                            $('#country').text(response.data.country_name);
                            $('#pincode').text(response.data.pincode);
                            $('#resAdd').text(response.data.resAdd);

                        }

                    }
                });
            }
            function loadProfessionalInfo(userId){
                $.ajax({
                    url: 'models/profile/professional_details.php',
                    type: 'GET',
                    dataType: 'json',
                    data: {
                        user_id: userId
                    },
                    success: function(response) {

                        if (response.status) {

                            $('#occName').text(response.data.current_occupation);
                            $('#occExp').text(response.data.current_experience);
                            $('#occIncome').html('&#8377; ' + (response.data.current_income || 0));

                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: response.message
                            });
                        }
                    },
                    error: function() {
                        alert('Unable to fetch professional details.');
                    }
                });
            }
            function loadNomineeInfo(userId){
                $.ajax({
                    url: 'models/profile/nominee_details.php',
                    type: 'GET',
                    dataType: 'json',
                    data: {
                        user_id: userId
                    },
                    success: function(response){

                        if(response.status){

                            $('#nomineeName').text(response.data.nominee_name || '');
                            $('#nomineeRelation').text(response.data.nominee_relation || '');

                            $('#nomineePhone').text(
                                (response.data.nominee_contact_cd || '') +
                                ' ' +
                                (response.data.nominee_contact_no || '')
                            );

                            $('#nomineeDob').text(response.data.nominee_date_of_birth || '');
                            $('#nomineeAddress').text(response.data.nominee_address || '');

                        }else{
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: response.message
                            });
                        }
                    },
                    error: function(){
                        alert('Unable to fetch nominee details.');
                    }
                });
            }
            function loadBankInfo(userId){
                $.ajax({
                    url: 'models/profile/bank_info_card.php',
                    type: 'GET',
                    dataType: 'json',
                    data: {
                        user_id: userId
                    },
                    success: function(response){

                        if(response.status){

                            $('#accHolderName').text(response.data.account_holder_name || '');
                            $('#bankName').text(response.data.bank_name || '');
                            $('#accountNumber').text(response.data.account_number || '');
                            $('#ifscCode').text(response.data.ifsc_code || '');
                            $('#branchName').text(response.data.branch_name || '');
                            $('#upiId').text(response.data.upi_id || '');

                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: response.message
                            });
                        }
                    },
                    error: function(){
                        alert('Unable to fetch bank details.');
                    }
                });
            }
            function loadDocuments(userId){

                $.ajax({
                    url: 'models/profile/document_details.php',
                    type: 'GET',
                    dataType: 'json',
                    data: {
                        user_id: userId
                    },
                    success: function(response){

                        if(!response.status){
                            alert(response.message);
                            return;
                        }

                        const data = response.documents;
                        const verification = response.verification || {};

                        const docs = [
                            {
                                url: data.profile_pic?'../../uploading/'+data.profile_pic:'',
                                status: verification.profile_pic,
                                preview: 'preview1',
                                view: 'view1',
                                download: 'download1',
                                docKey: 'profile_pic'
                            },
                            {
                                url: data.aadhar_card?'../../uploading/'+data.aadhar_card:'',
                                status: verification.aadhar_card,
                                preview: 'preview2',
                                view: 'view2',
                                download: 'download2',
                                docKey: 'aadhar_card'
                            },
                            {
                                url: data.pan_card?'../../uploading/'+data.pan_card:'',
                                status: verification.pan_card,
                                preview: 'preview3',
                                view: 'view3',
                                download: 'download3',
                                docKey: 'pan_card'
                            },
                            {
                                url: data.cancelled_cheque_bank_passbook?'../../uploading/'+data.cancelled_cheque_bank_passbook:'',
                                status: verification.bank_passbook,
                                preview: 'preview4',
                                view: 'view4',
                                download: 'download4',
                                docKey: 'cancelled_cheque_bank_passbook'
                            },
                            {
                                url: data.resume_cv?'../../uploading/'+data.resume_cv:'',
                                status: verification.resume_cv,
                                preview: 'preview5',
                                view: 'view5',
                                download: 'download5',
                                docKey: 'resume_cv'
                            },
                            {
                                url: data.address_proof?'../../uploading/'+data.address_proof:'',
                                status: verification.address_proof,
                                preview: 'preview6',
                                view: 'view6',
                                download: 'download6',
                                docKey: 'address_proof'
                            },
                            {
                                url: data.professional_profile?'../../uploading/'+data.professional_profile:'',
                                status: verification.professional_profile,
                                preview: 'preview7',
                                view: 'view7',
                                download: 'download7',
                                docKey: 'professional_profile'
                            },
                            {
                                url: data.business_profile?'../../uploading/'+data.business_profile:'',
                                status: verification.business_profile,
                                preview: 'preview8',
                                view: 'view8',
                                download: 'download8',
                                docKey: 'business_profile'
                            },
                            {
                                url: data.income_proof?'../../uploading/'+data.income_proof:'',
                                status: verification.income_proof,
                                preview: 'preview9',
                                view: 'view9',
                                download: 'download9',
                                docKey: 'income_proof'
                            },
                            {
                                url: data.other_document?'../../uploading/'+data.other_document:'',
                                status: verification.other_document,
                                preview: 'preview10',
                                view: 'view10',
                                download: 'download10',
                                docKey: 'other_document'
                            },
                            {
                                url: data.nominee_profile?'../../uploading/'+data.nominee_profile:'',
                                status: verification.nominee_profile,
                                preview: 'preview11',
                                view: 'view11',
                                download: 'download11',
                                docKey: 'nominee_profile'
                            }
                            
                        ];

                        docs.forEach(function(doc){

                            if(doc.url){

                                $('#' + doc.view)
                                    .attr('href', doc.url)
                                    .removeClass('disabled');

                                $('#' + doc.download)
                                    .attr('href', doc.url)
                                    .attr('download', '')
                                    .removeClass('disabled');

                                const ext = doc.url.split('.').pop().toLowerCase();

                                if([
                                    'jpg',
                                    'jpeg',
                                    'png',
                                    'gif',
                                    'webp',
                                    'pdf'
                                ].includes(ext)){

                                    $('#' + doc.preview).attr('src', doc.url);
                                }
                            }

                            const badge = document.querySelector(
                                '[data-document="' + doc.docKey + '"]'
                            );

                            if(badge){

                                badge.classList.remove(
                                    'verified',
                                    'approved',
                                    'pending',
                                    'rejected'
                                );

                                if (!doc.url) {

                                    badge.innerHTML = 'Pending';
                                    badge.classList.add('pending');

                                } else {

                                    switch ((doc.status || 'approved').toLowerCase()) {

                                        case 'approved':
                                            badge.innerHTML = 'Approved';
                                            badge.classList.add('verified');
                                            break;

                                        case 'rejected':
                                            badge.innerHTML = 'Rejected';
                                            badge.classList.add('rejected');
                                            break;

                                        default:
                                            badge.innerHTML = 'Approved';
                                            badge.classList.add('verified');
                                    }

                                }
                            }

                        });

                    },
                    error: function(xhr, status, error){

                        console.error(error);

                        alert('Unable to load documents.');
                    }
                });

            }
        </script>
    </body>
</html>