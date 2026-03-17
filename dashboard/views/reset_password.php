<?php
    require '../dashboard_user_details.php';
    include '../models/reset_password/reset_pass.php'

?>

<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable">

<head>

    <meta charset="utf-8" />
    <title>Dashboard | Uniqbizz</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesbrand" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="../assets/images/fav.png">

    <!-- jsvectormap css -->
    <link href="../assets/libs/jsvectormap/css/jsvectormap.min.css" rel="stylesheet" type="text/css" />

    <!--Swiper slider css-->
    <link href="../assets/libs/swiper/swiper-bundle.min.css" rel="stylesheet" type="text/css" />

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
    <style>
        .upload-documents {
            display: flex !important;
            justify-content: space-between !important;
        }

        .top-space {
            margin-top: 60px;
        }

        @media (max-width: 768px) {
            .upload-documents {
                width: 100%;
                display: block !important;
            }
        }

        @media (min-width: 1400px) {
            .upload-documents {
                display: block !important;
            }

            .column {
                margin-top: -530px;
            }
        }
    </style>

</head>

<body>
    <!-- Begin page -->
    <div id="layout-wrapper">

        <?php include_once "../header.php" ?>

        <?php include '../notification_card.php'?>
        <!-- ========== App Menu ========== -->

        <?php include_once "../sidebar.php" ?>

        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">

            <div class="page-content">
                <div class="container-fluid ">

                    <form>
                        <div class="row top-space mb-5">
                            <div class="col-xxl-3 ">
                                <div class="card mt-n5 z-1">
                                    <div class="card-body p-4">
                                        <div class="text-center">
                                            <div class="profile-user position-relative d-inline-block mx-auto mb-4">
                                                <!-- Preview image -->
                                                <img id="img_pre1" src="<?php echo "../../uploading/" . $profile_pic; ?>" class="rounded-circle avatar-xl img-thumbnail user-profile-image shadow" alt="user-profile-image">

                                                <div class="avatar-xs p-0 rounded-circle profile-photo-edit position-absolute bottom-0 end-0">
                                                    <!-- File input: ID must be profile_pic to match your JS -->
                                                    <input id="pupload_file1" type="file" class="d-none profile-img-file-input">

                                                    <!-- Hidden input for filename after upload -->
                                                    <input id="img_path1" type="hidden" value="<?= $profile_pic ?>">

                                                    <!-- Label triggers file input -->
                                                    <label for="pupload_file11" class="avatar-xs rounded-circle bg-light text-body shadow d-flex align-items-center justify-content-center" style="cursor: pointer; width: 32px; height: 32px;">
                                                        <i class="ri-camera-fill"></i>
                                                    </label>
                                                </div>
                                            </div>
                                            <h5 class="fs-16 mb-1"><?php echo $fname . ' ' . $middle . ($middle ? ' ' : '') . $lname; ?></h5>
                                            <p class="text-muted mb-0 fs-16 ">Profile Pic</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--end col-->
                            <div class="col-xxl-9">
                                <div class="card mt-xxl-n5">
                                    <div class="card-header">
                                        <ul class="nav nav-tabs-custom rounded card-header-tabs border-bottom-0" role="tablist">
                                            <li class="nav-item">
                                                <a class="nav-link active" data-bs-toggle="tab" href="#changePassword" role="tab">
                                                    <i class="far fa-user"></i> Change Password
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="card-body p-4">
                                        <div class="tab-content">
                                            <div class="tab-pane active" id="changePassword" role="tabpanel">
                                                <div class="row d-flex justify-content-center">
                                                    <!-- Current Password -->
                                                    <div class="col-lg-8 col-md-8 col-sm-12 col-12">
                                                        <div class="input-group my-3">
                                                            <input type="hidden" id="user_type" value="<?php echo $userType; ?>">
                                                            <input type="hidden" id="user_id" value="<?php echo $userId; ?>">
                                                            <input type="password" class="form-control" id="currentPassword" placeholder="Enter Current Password" aria-label="Enter Current Password" aria-describedby="basic-addon2">
                                                            <span class="input-group-text" id="basic-addon2">
                                                                <button type="button" class="border-0"
                                                                    onclick="togglePassword('currentPassword', this)" title="Show Password">
                                                                    <i class="fas fa-eye"></i>
                                                                </button>
                                                            </span>
                                                        </div>
                                                    </div>

                                                    <!-- New Password -->
                                                    <div class="col-lg-8 col-md-8 col-sm-12 col-12">
                                                        <div class="input-group">
                                                            <input type="password" class="form-control" id="newPassword" placeholder="Enter New Password" aria-label="Enter New Password" aria-describedby="basic-addon2">
                                                            <span class="input-group-text" id="basic-addon2">
                                                                <button type="button" class="border-0"
                                                                    onclick="togglePassword('newPassword', this)" title="Show Password">
                                                                    <i class="fas fa-eye"></i>
                                                                </button>
                                                            </span>
                                                        </div>
                                                        <!-- Password Requirements -->
                                                        <div id="passwordFeedback" class="form-text my-2">
                                                            <ul class="list-unstyled mb-0">
                                                                <li id="lengthCheck">❌ <span style="color: red;">At least 8 characters</span></li>
                                                                <li id="letterCheck">❌ <span style="color: red;">At least one letter (a-z, A-Z)</span></li>
                                                                <li id="numberCheck">❌ <span style="color: red;">At least one number (0-9)</span></li>
                                                                <li id="symbolCheck">❌ <span style="color: red;">At least one symbol (!@#$%^&*)</span></li>
                                                            </ul>
                                                        </div>
                                                    </div>

                                                    <!-- Confirm Password -->
                                                    <div class="col-lg-8 col-md-8 col-sm-12 col-12">
                                                        <div class="input-group mb-3">
                                                            <input type="password" class="form-control" id="confirmPassword" placeholder="Enter Confirm Password" aria-label="Enter Confirm Password" aria-describedby="basic-addon2">
                                                            <span class="input-group-text" id="basic-addon2">
                                                                <button type="button" class="border-0"
                                                                    onclick="togglePassword('confirmPassword', this)" title="Show Password">
                                                                    <i class="fas fa-eye"></i>
                                                                </button>
                                                            </span>
                                                        </div>
                                                    </div>

                                                    <!-- Save Button -->
                                                    <div class="col-lg-8 col-md-8 col-sm-12 col-12">
                                                        <div class="hstack gap-2 justify-content-end mb-2">
                                                            <button id="edit_profile" type="submit" class="btn btn-primary">Save Changes</button>
                                                        </div>
                                                    </div>
                                                </div> <!-- end row -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!--end col-->
                        </div>
                        <!--end row-->  
                    </form>

                </div>
                <!-- container-fluid -->
            </div><!-- End Page-content -->

            <?php include_once "../footer.php" ?>
        </div>
        <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->

    <!--start back-to-top-->
    <button onclick="topFunction()" class="scrollToTop scroll-btn show btn" id="back-to-top">
        <i class="ri-arrow-up-line"></i>
    </button>
    <!--end back-to-top-->

    <!-- Theme Settings -->

    <!-- JAVASCRIPT -->
    <script src="../assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/libs/simplebar/simplebar.min.js"></script>
    <script src="../assets/libs/node-waves/waves.min.js"></script>
    <script src="../assets/libs/feather-icons/feather.min.js"></script>
    <script src="../assets/js/jquery/jquery-3.7.1.min.js"></script>


    <!-- App js -->
    <script src="../assets/js/app.js"></script>

    <script src="../resources/reset_password/reset_pass_custom.js"></script>


</body>

</html>