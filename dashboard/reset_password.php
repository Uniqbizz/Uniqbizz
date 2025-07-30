<?php
require 'dashboard_user_details.php';

//get profile col data (img link) to display in header
$stmt = $conn->prepare($sql2);
$stmt->execute();
$stmt->setFetchMode(PDO::FETCH_ASSOC);

function getNameById($conn, $table, $column, $id)
{
    $stmt = $conn->prepare("SELECT {$column} FROM {$table} WHERE id = ? AND status = '1'");
    $stmt->execute([$id]);
    if ($stmt->rowCount() > 0) {
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result[$column];
    }
    return '';
}

if ($stmt->rowCount() > 0) {
    foreach ($stmt->fetchAll() as $key => $value) {
        $profile_pic = $value['profile_pic'];

        // Default values
        $middle = '';
        $bank_passbook='';
        if ($userType == '25' || $userType == '24') {

            // Handle name split safely
            $nameParts = explode(' ', trim($value['name']));
            $fname = $nameParts[0] ?? '';
            $lname = end($nameParts) ?? '';
            // Extract middle names (excluding first and last)
            
            if (count($nameParts) > 2) {
                $middle = implode(' ', array_slice($nameParts, 1, -1));
            }
        } else {
            // Common for userType 10, 11, and others
            $fname = $value['firstname'];
            $lname = $value['lastname'];
        }
    }
}
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
    <link rel="shortcut icon" href="assets/images/fav.png">

    <!-- jsvectormap css -->
    <link href="assets/libs/jsvectormap/css/jsvectormap.min.css" rel="stylesheet" type="text/css" />

    <!--Swiper slider css-->
    <link href="assets/libs/swiper/swiper-bundle.min.css" rel="stylesheet" type="text/css" />

    <!-- Layout config Js -->
    <script src="assets/js/layout.js"></script>
    <!-- Bootstrap Css -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="assets/css/app.min.css" rel="stylesheet" type="text/css" />
    <!-- custom Css-->
    <link href="assets/css/custom.min.css" rel="stylesheet" type="text/css" />
    <!-- custom Css developer-->
    <link rel="stylesheet" href="assets/css/custom.css" />
    <link rel="stylesheet" href="assets/fontawesome/css/all.min.css" />
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

        <?php include_once "header.php" ?>

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

        <?php include_once "sidebar.php" ?>

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
                                                <img id="img_pre1" src="<?php echo "../uploading/" . $profile_pic; ?>" class="rounded-circle avatar-xl img-thumbnail user-profile-image shadow" alt="user-profile-image">

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

            <footer class="footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-6">
                            <?php echo $date; ?> © Uniqbizz.
                        </div>
                        <div class="col-sm-6">
                            <div class="text-sm-end d-none d-sm-block">
                                Design & Develop by Mirthcon
                            </div>
                        </div>
                    </div>
                </div>
            </footer>
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
    <script src="assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/libs/simplebar/simplebar.min.js"></script>
    <script src="assets/libs/node-waves/waves.min.js"></script>
    <script src="assets/libs/feather-icons/feather.min.js"></script>
    <script src="assets/js/jquery/jquery-3.7.1.min.js"></script>


    <!-- App js -->
    <script src="assets/js/app.js"></script>

<script>
    // Toggle password visibility (default: visible, type="text")
    function togglePassword(fieldId, btn) {
        const input = document.getElementById(fieldId);
        const icon = btn.querySelector('i');
        const isVisible = input.type === "text";

        input.type = isVisible ? "password" : "text";
        icon.classList.toggle('fa-eye', isVisible);
        icon.classList.toggle('fa-eye-slash', !isVisible);
        btn.title = isVisible ? "Show Password" : "Hide Password";
    }

    // Password validation
    function validatePasswordDetails(password) {
        return {
            lengthCheck: password.length >= 8,
            letterCheck: /[A-Za-z]/.test(password),
            numberCheck: /\d/.test(password),
            symbolCheck: /[^A-Za-z0-9]/.test(password),
        };
    }

    function updatePasswordFeedback(checks) {
        updateFeedbackItem('lengthCheck', checks.lengthCheck, 'At least 8 characters');
        updateFeedbackItem('letterCheck', checks.letterCheck, 'At least one letter (a-z, A-Z)');
        updateFeedbackItem('numberCheck', checks.numberCheck, 'At least one number (0–9)');
        updateFeedbackItem('symbolCheck', checks.symbolCheck, 'At least one symbol (!@#$%^&*)');
    }

    function updateFeedbackItem(id, passed, message) {
        const el = document.getElementById(id);
        el.innerHTML = passed
            ? '✔️ <span style="color:green;">' + message + '</span>'
            : '❌ <span style="color:red;">' + message + '</span>';
    }

    document.getElementById('newPassword').addEventListener('input', function () {
        const password = this.value;
        const checks = validatePasswordDetails(password);
        updatePasswordFeedback(checks);
    });

    $('#edit_profile').on('click', function (event) {
        event.preventDefault();

        const currentPassword = $('#currentPassword').val().trim();
        const newPassword = $('#newPassword').val().trim();
        const confirmPassword = $('#confirmPassword').val().trim();
        const user_type = $('#user_type').val().trim();
        const user_id = $('#user_id').val().trim();

        const checks = validatePasswordDetails(newPassword);
        const allPassed = Object.values(checks).every(Boolean);

        if (!allPassed) {
            alert(' Password must be at least 8 characters long and include a letter, a number, and a symbol.');
            return;
        }

        if (newPassword !== confirmPassword) {
            alert(' New Password and Confirm Password do not match.');
            return;
        }

        const formData = new FormData();
        formData.append('currentPassword', currentPassword);
        formData.append('newPassword', newPassword);
        formData.append('confirmPassword', confirmPassword);
        formData.append('user_type', user_type);
        formData.append('user_id', user_id);

        $.ajax({
            url: 'updatedata/reset_password_data.php',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                switch (response.trim()) {
                    case 'success':
                        alert(' Password changed successfully.');
                        location.reload();
                        break;
                    case 'mismatch':
                        alert(' Current Password is incorrect.');
                        break;
                    case 'invalid':
                        alert(' Password validation failed on server.');
                        break;
                    default:
                        alert(' Unknown error occurred. Please try again.');
                        break;
                }
            },
            error: function (xhr, status, error) {
                alert(' AJAX Error: ' + error);
            }
        });
    });

</script>


</body>

</html>