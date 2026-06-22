<?php
    include_once (__DIR__.'/../dashboard_user_details.php');
    if ($userType == '34') {
        $base_url_sidebar = "/ca.uniqbizz.com/dashboard/super_techno_enterprise/";
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
        <title>Edit Executive Techno Enterprise List | Customer</title>
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
        <link rel="stylesheet" href="../assets/css/chief_techno_enterprise.css" />
        <!-- FontAwesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <style>
            /* ======================================
            FIELD HEADER
            ====================================== */

            .verify-field{
                display:flex;
                align-items:center;
                gap:6px;
                margin-bottom:6px;
                flex-wrap:wrap;
            }

            .verify-field .col-form-label{
                margin:0;
                font-size:13px;
                font-weight:600;
                line-height:1.2;
            }

            /* ======================================
            TOGGLE WRAPPER
            ====================================== */

            .verify-toggle{
                display:inline-flex;
                align-items:center;
                padding:2px;
                background:#f8f9fc;
                border:1px solid #e5e7eb;
                border-radius:16px;
                gap:2px;
                box-shadow:0 1px 3px rgba(0,0,0,.05);
            }

            .verify-toggle input{
                display:none;
            }

            /* ======================================
            BUTTONS
            ====================================== */

            .verify-btn{
                min-width:58px;
                height:22px;
                padding:0 6px;
                display:flex;
                align-items:center;
                justify-content:center;
                gap:4px;
                border-radius:14px;
                cursor:pointer;
                font-size:9px;
                font-weight:700;
                letter-spacing:.3px;
                color:#6b7280;
                margin:0;
                transition:all .2s ease;
                text-transform:uppercase;
                user-select:none;
            }

            .verify-btn i{
                font-size:9px;
            }

            /* Status Dot */

            .verify-btn::before{
                content:'';
                width:4px;
                height:4px;
                border-radius:50%;
                background:currentColor;
                opacity:.7;
            }

            /* ======================================
            APPROVED
            ====================================== */

            .verify-toggle input:checked + .approve-btn{
                background:#22c55e;
                color:#fff;
                box-shadow:0 2px 6px rgba(34,197,94,.25);
            }

            /* ======================================
            REJECTED
            ====================================== */

            .verify-toggle input:checked + .reject-btn{
                background:#ef4444;
                color:#fff;
                box-shadow:0 2px 6px rgba(239,68,68,.25);
            }

            .verify-toggle input:checked + label::before{
                background:#fff;
            }

            /* Hover */

            .verify-btn:hover{
                transform:translateY(-1px);
            }

            /* ======================================
            MOBILE RESPONSIVE
            ====================================== */

            @media (max-width: 768px){

                .verify-field{
                    gap:4px;
                    margin-bottom:5px;
                }

                .verify-field .col-form-label{
                    font-size:12px;
                }

                .verify-btn{
                    min-width:50px;
                    height:20px;
                    font-size:8px;
                    padding:0 5px;
                }

                .verify-btn i{
                    font-size:8px;
                }
            }

            @media (max-width: 480px){

                .verify-field{
                    flex-direction:column;
                    align-items:flex-start;
                }

                .verify-toggle{
                    margin-top:2px;
                }

                .verify-btn{
                    min-width:46px;
                    height:18px;
                    font-size:8px;
                    padding:0 4px;
                }
            }
        </style>
    </head>
    <body>
 
        <!-- Begin page -->
        <div id="layout-wrapper">

            <?php 
                if ($userType == 34) {
                    include_once(__DIR__ . '/chief_techno_header.php');
                }else{

                    include_once 'chief_techno_header.php'; 
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
                    include_once(__DIR__ . '/chief_techno_sidebar.php');
                }else{

                    include_once 'chief_techno_sidebar.php'; 
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
                                    <h4 class="mb-sm-0">Executive Techno Enterprise</h4>
                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="executive_techno_enterprise_list.php">View Executive Techno Enterprise</a></li>
                                            <li class="breadcrumb-item active">Edit Executive Techno Enterprise</li>
                                        </ol>
                                    </div>
                                </div>
                            </div>
                        </div>

                        
						<!-- add customer form start -->
						<div class="row">
							<div class="col-lg-12">
                                <div class="card rounded-4 addTECard">
                                    <div class="d-flex gap-3">
                                        <div class="addTEIconBackground">
                                            <i class="fa-solid fa-user-group addTEIcon"></i>
                                        </div>
                                        <div class="align-content-center">
                                            <h1 class="fw-bolder text-white">Edit Executive Techno Enterprise</h1>
                                            <p class="fs-5 text-white mb-0">Fill in the details below to register a new Edit Executive Techno Enterprise under your network.</p>
                                        </div>
                                    </div>
                                    <img src="../assets/images/addTechnoFileImage.png" alt="" class="addTEImage">
                                </div>
                            </div>
						</div>
                        <!-- Card section 1 -->
						<div class="card rounded-4 p-3 border-1">
							<div class="row">
                                <div class="d-flex gap-2">
                                    <p class="fw-bolder addTENum">01</p>
                                    <h4 class="fw-bolder text-dark align-content-center">Personal Information</h4>
                                </div>
                                <div class="col-lg-9">
									<div class="row">
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                                            <div class="input-block mb-3">
                                                <div class="verify-field">
                                                    <label class="col-form-label"> First Name <span class="text-danger">*</span></label>
                                                    <?php //if ($status == 2) { ?>
                                                    <div class="verify-toggle">
                                                        <input type="radio" name="verification_status[firstname]" id="firstname_approve" class="approve_reason" value="approved" <?php // isChecked($verificationPayload, 'firstname', 'approved'); ?> > 
                                                        <label class="verify-btn approve-btn" for="firstname_approve"> Approved </label>
                                                        <input type="radio" name="verification_status[firstname]" id="firstname_reject" class="reject_reason" value="rejected" <?php // isChecked($verificationPayload, 'firstname', 'rejected'); ?> > 
                                                        <label class="verify-btn reject-btn" for="firstname_reject"> Rejected </label>
                                                    </div>
                                                    <?php //} ?>
                                                </div>
                                                <input class="form-control" type="text" id="firstname" value="<?php //echo $firstname; ?>">
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                                            <div class="input-block mb-3">
                                                <div class="verify-field">
                                                    <label class="col-form-label">Last Name <span class="text-danger">*</span></label>
                                                <?php //if ($status == 2) { ?>
                                                    <div class="verify-toggle">
                                                        <input type="radio" name="verification_status[lastname]" id="lastname_approve" class="approve_reason" value="approved" <?php // isChecked($verificationPayload, 'lastname', 'approved'); ?>>
                                                        <label class="verify-btn approve-btn" for="lastname_approve"> Approved </label>
                                                        <input type="radio" name="verification_status[lastname]" id="lastname_reject" class="reject_reason" value="rejected" <?php // isChecked($verificationPayload, 'lastname', 'rejected'); ?>>
                                                        <label class="verify-btn reject-btn" for="lastname_reject"> Rejected </label>
                                                    </div>
                                                    <?php //} ?>
                                                </div>
                                                <input class="form-control" type="text" id="lastname" value=" <?php //echo $lastname; ?>">
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                                            <div class="input-block mb-3">
                                                <div class="verify-field">
                                                    <label class="col-form-label">Father / Spouse Name<span class="text-danger">*</span></label>
                                                <?php //if ($status == 2) { ?>
                                                    <div class="verify-toggle">
                                                        <input type="radio" name="verification_status[father_spouse_name]" id="father_spouse_name_approve" class="approve_reason" value="approved" <?php // isChecked($verificationPayload, 'father_spouse_name', 'approved'); ?>>
                                                        <label class="verify-btn approve-btn" for="father_spouse_name_approve"> Approved </label>
                                                        <input type="radio" name="verification_status[father_spouse_name]" id="father_spouse_name_reject" class="reject_reason" value="rejected" <?php // isChecked($verificationPayload, 'father_spouse_name', 'rejected'); ?>>
                                                        <label class="verify-btn reject-btn" for="father_spouse_name_reject"> Rejected </label>
                                                    </div>
                                                    <?php //} ?>
                                                </div>
                                                <input class="form-control" type="text" id="father_spouse_name" value=" <?php //echo $father_spouse_name; ?>">
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                                            <div class="input-block mb-3">
                                                <div class="verify-field">
                                                    <label class="col-form-label">Email Address<span class="text-danger">*</span></label>
                                                    <?php //if ($status == 2) { ?>
                                                    <div class="verify-toggle">
                                                        <input type="radio" name="verification_status[email]" id="email_approve" class="approve_reason" value="approved" <?php // isChecked($verificationPayload, 'email', 'approved'); ?>>
                                                        <label class="verify-btn approve-btn" for="email_approve"> Approved </label>
                                                        <input type="radio" name="verification_status[email]" id="email_reject" class="reject_reason" value="rejected" <?php // isChecked($verificationPayload, 'email', 'rejected'); ?>>
                                                        <label class="verify-btn reject-btn" for="email_reject"> Rejected </label>
                                                    </div>
                                                    <?php //} ?>
                                                </div>
                                                <input class="form-control" type="email" id="email" value="<?php //echo $email;?>">
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                                            <div class="input-block mb-3">
                                                <div class="verify-field">
                                                    <label class="col-form-label">Date of Birth <span class="text-danger">*</span></label>
                                                    <?php //if ($status == 2) { ?>
                                                    <div class="verify-toggle">
                                                        <input type="radio" name="verification_status[dob]" id="dob_approve" class="approve_reason" value="approved" <?php // isChecked($verificationPayload, 'dob', 'approved'); ?>>
                                                        <label class="verify-btn approve-btn" for="dob_approve"> Approved </label>
                                                        <input type="radio" name="verification_status[dob]" id="dob_reject" class="reject_reason" value="rejected" <?php // isChecked($verificationPayload, 'dob', 'rejected'); ?>>
                                                        <label class="verify-btn reject-btn" for="dob_reject"> Rejected </label>
                                                    </div>
                                                    <?php //} ?>
                                                </div>
                                                <input class="form-control" type="date" id="dob" value="<?php //echo $date_of_birth ;?>">
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-12">
                                            <div class="form-group">
                                                <div class="verify-field">
                                                    <label class="col-form-label">Gender <span class="text-danger">*</span></label>
                                                    <?php //if ($status == 2) { ?>
                                                    <div class="verify-toggle">
                                                        <input type="radio" name="verification_status[gender]" id="gender_approve" class="approve_reason" value="approved" <?php // isChecked($verificationPayload, 'gender', 'approved'); ?>>
                                                        <label class="verify-btn approve-btn" for="gender_approve"> Approved </label>
                                                        <input type="radio" name="verification_status[gender]" id="gender_reject" class="reject_reason" value="rejected" <?php // isChecked($verificationPayload, 'gender', 'rejected'); ?>>
                                                        <label class="verify-btn reject-btn" for="gender_reject"> Rejected </label>
                                                    </div>
                                                    <?php //} ?>
                                                </div>
                                                <div class="form-control d-flex justify-content-around">
                                                    <label class="radio-inline mb-0 ms-3"><input type="radio" name="gender" class="gender form-check-input" id="test3" value="male" <?php //if ($gender == 'male'){echo ' checked ';} ?>>&nbsp;&nbsp;&nbsp;Male</label>
                                                    <label class="radio-inline mb-0 ms-3"><input type="radio" name="gender" class="gender form-check-input" id="test4" value="female" <?php //if ($gender == 'female'){echo ' checked ';} ?>>&nbsp;&nbsp;&nbsp;Female</label>
                                                    <label class="radio-inline mb-0 ms-3"><input type="radio" name="gender" class="gender form-check-input" id="test5" value="others" <?php //if ($gender == 'others'){echo ' checked ';} ?>>&nbsp;&nbsp;&nbsp;Other</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-12 mb-3">
                                            <div class="row">
                                                <div class="col-md-4 col-sm-4 col-3">
                                                    <div class="input-block">
                                                        <?php
                                                            require '../connect.php';
                                                            $stmt = $conn->prepare("SELECT * FROM countries WHERE status = 1 ORDER BY country_name ASC");
                                                            $stmt->execute();                                            
                                                            $stmt->setFetchMode(PDO::FETCH_ASSOC);
                                                        ?>
                                                        <label for="country_cd" class="col-form-label">Code:</label>
                                                        <select class="form-control" id="country_cd">
                                                            <?php 
                                                                if($stmt->rowCount()>0){
                                                                    foreach (($stmt->fetchAll()) as $key => $row) {  
                                                                        echo '<option value="'.$row['country_code'].'">+'.$row['country_code'].' ('.$row['sortname'].')</option>'; 
                                                                    } 
                                                                }else{ 
                                                                    echo '<option value="">Country not available</option>'; 
                                                                } 
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-8 col-sm-8 col-9">
                                                    <div class="input-block">
                                                        <div class="verify-field">
                                                            <label class="col-form-label">Phone Number <span class="text-danger">*</span></label>
                                                            <?php //if ($status == 2) { ?>
                                                            <div class="verify-toggle">
                                                                <input type="radio" name="verification_status[phone]" id="phone_approve" class="approve_reason" value="approved" <?php // isChecked($verificationPayload, 'phone', 'approved'); ?>>
                                                                <label class="verify-btn approve-btn" for="phone_approve"> Approved </label>
                                                                <input type="radio" name="verification_status[phone]" id="phone_reject" class="reject_reason" value="rejected" <?php // isChecked($verificationPayload, 'phone', 'rejected'); ?>>
                                                                <label class="verify-btn reject-btn" for="phone_reject"> Rejected </label>
                                                            </div>
                                                            <?php //} ?>
                                                        </div>
                                                        <input class="form-control" type="text" id="phone" value=" <?php //echo $contact_no; ?>">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-12 mb-3">
                                            <div class="row">
                                                <div class="col-md-4 col-sm-4 col-3">
                                                    <div class="input-block">
                                                        <?php
                                                            require '../connect.php';
                                                            $stmt = $conn->prepare("SELECT * FROM countries WHERE status = 1 ORDER BY country_name ASC");
                                                            $stmt->execute();                                            
                                                            $stmt->setFetchMode(PDO::FETCH_ASSOC);
                                                        ?>
                                                        <label for="country_cd_alt" class="col-form-label">Code:</label>
                                                        <select class="form-control" id="country_cd_alt">
                                                            <?php 
                                                                if($stmt->rowCount()>0){
                                                                    foreach (($stmt->fetchAll()) as $key => $row) {  
                                                                        echo '<option value="'.$row['country_code'].'">+'.$row['country_code'].' ('.$row['sortname'].')</option>'; 
                                                                    } 
                                                                }else{ 
                                                                    echo '<option value="">Country not available</option>'; 
                                                                } 
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-8 col-sm-8 col-9">
                                                    <div class="input-block">
                                                        <div class="verify-field">
                                                            <label class="col-form-label">Alt Phone Number <span class="text-danger">*</span></label>
                                                            <?php //if ($status == 2) { ?>
                                                            <div class="verify-toggle">
                                                                <input type="radio" name="verification_status[altPhone]" id="altPhone_approve" class="approve_reason" value="approved" <?php // isChecked($verificationPayload, 'altPhone', 'approved'); ?>>
                                                                <label class="verify-btn approve-btn" for="altPhone_approve"> Approved </label>
                                                                <input type="radio" name="verification_status[altPhone]" id="altPhone_reject" class="reject_reason" value="rejected" <?php // isChecked($verificationPayload, 'altPhone', 'rejected'); ?>>
                                                                <label class="verify-btn reject-btn" for="altPhone_reject"> Rejected </label>
                                                            </div>
                                                            <?php //} ?>
                                                        </div>
                                                        <input class="form-control" type="text" id="altPhone" value=" <?php //echo $alternative_contact_no; ?>">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-6">
                                            <div class="input-block mb-3">
                                                <div class="verify-field">
                                                    <label class="col-form-label">Aadhar No<span class="text-danger">*</span></label>
                                                    <?php //if ($status == 2) { ?>
                                                    <div class="verify-toggle">
                                                        <input type="radio" name="verification_status[aadharNo]" id="aadharNo_approve" class="approve_reason" value="approved" <?php // isChecked($verificationPayload, 'aadharNo', 'approved'); ?>>
                                                        <label class="verify-btn approve-btn" for="aadharNo_approve"> Approved </label>
                                                        <input type="radio" name="verification_status[aadharNo]" id="aadharNo_reject" class="reject_reason" value="rejected" <?php // isChecked($verificationPayload, 'aadharNo', 'rejected'); ?>>
                                                        <label class="verify-btn reject-btn" for="aadharNo_reject"> Rejected </label>
                                                    </div>
                                                    <?php //} ?>
                                                </div>
                                                <input class="form-control" type="text" id="aadharNo" value=" <?php //echo $aadhar_no; ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-6">
                                            <div class="input-block mb-3">
                                                <div class="verify-field">
                                                    <label class="col-form-label">PAN No<span class="text-danger">*</span></label>
                                                    <?php //if ($status == 2) { ?>
                                                    <div class="verify-toggle">
                                                        <input type="radio" name="verification_status[panNo]" id="panNo_approve" class="approve_reason" value="approved" <?php // isChecked($verificationPayload, 'panNo', 'approved'); ?>>
                                                        <label class="verify-btn approve-btn" for="panNo_approve"> Approved </label>
                                                        <input type="radio" name="verification_status[panNo]" id="panNo_reject" class="reject_reason" value="rejected" <?php // isChecked($verificationPayload, 'panNo', 'rejected'); ?>>
                                                        <label class="verify-btn reject-btn" for="panNo_reject"> Rejected </label>
                                                    </div>
                                                    <?php //} ?>
                                                </div>
                                                <input class="form-control" type="text" id="panNo" value=" <?php // echo $pan_no; ?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3">
									<div class="row">
										<div class="col-lg-12">
                                            <div class="verify-field">
                                                <?php //if ($status == 2) { ?>
                                                <div class="verify-toggle">
                                                    <input type="radio" name="verification_status[profile]" id="profile_approve" class="approve_reason" value="approved" <?php // isChecked($verificationPayload, 'profile', 'approved'); ?> > 
                                                    <label class="verify-btn approve-btn" for="profile_approve"> Approved </label>
                                                    <input type="radio" name="verification_status[profile]" id="profile_reject" class="reject_reason" value="rejected" <?php // isChecked($verificationPayload, 'profile', 'rejected'); ?> > 
                                                    <label class="verify-btn reject-btn" for="profile_reject"> Rejected </label>
                                                </div>
                                                <?php //} ?>
                                            </div>
											<div class="upload-card" data-title="Profile Photo">
												<input type="file" class="file-input" accept="image/*,.pdf">
												<div class="upload-content">
													<div class="upload-icon">
														<i class="fa-solid fa-user"></i>
													</div>
													<h6>Profile Photo</h6>
													<p>Click to upload<br>or drag and drop</p>
													<small>(JPG, PNG, PDF)</small>
												</div>
											</div>
										</div>
									</div>
								</div>
                            </div>
                        </div>
                        <!-- Card section 2 -->
						<div class="card rounded-4 p-3 border-1">
							<div class="row">
                                <div class="d-flex gap-2">
                                    <p class="fw-bolder addTENum">02</p>
                                    <h4 class="fw-bolder text-dark align-content-center">Residential Information</h4>
                                    <?php //if ($status == 2) { ?>
                                        <div class="verify-toggle">
                                            <input type="radio" name="verification_status[residential]" id="residential_approve" class="approve_reason" value="approved" <?php // isChecked($verificationPayload, 'residential', 'approved'); ?>>
                                            <label class="verify-btn approve-btn" for="residential_approve"> Approved </label>
                                            <input type="radio" name="verification_status[residential]" id="residential_reject" class="reject_reason" value="rejected" <?php // isChecked($verificationPayload, 'residential', 'rejected'); ?>>
                                            <label class="verify-btn reject-btn" for="residential_reject"> Rejected </label>
                                        </div>
                                    <?php //} ?>
                                </div>
                                <div class="col-md-6 col-sm-6">
                                    <div class="input-block mb-3">
                                        <?php
                                            $stmt = $conn->prepare("SELECT * FROM countries WHERE status = 1 ORDER BY country_name ASC");
                                            $stmt->execute();                                         
                                            $stmt->setFetchMode(PDO::FETCH_ASSOC);
                                        ?>
                                        <label class="col-form-label">Country <span class="text-danger">*</span></label>
                                        <select class="form-select" id="country">
                                            <?php   
                                                if($country_id == ''){
                                                    echo '<option value=""> Country Not Selected </option>';
                                                }else{
                                                    echo '<option value=" '.$country_id.' "> '.$countryname. ' (Already Selected) </option>';
                                                }
                                            ?>
                                            <?php 
                                                if($stmt->rowCount()>0){
                                                    foreach (($stmt->fetchAll()) as $key => $row) {  
                                                        echo '<option value="'.$row['id'].'">'.$row['country_name'].'</option>'; 
                                                    } 
                                                }else{ 
                                                    echo '<option value="">Country not available</option>'; 
                                                } 
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6">
                                    <div class="input-block mb-3">
                                        <label class="col-form-label">State<span class="text-danger">*</span></label>
                                        <select class="form-select" id="mystate" aria-label="Floating label select example">
                                            <?php   
                                                if($state_id == ''){
                                                    echo '<option value=""> State Not Selected </option>';
                                                }else{
                                                    echo '<option value=" '.$state_id.' "> '.$statename. ' (Already Selected) </option>';
                                                }
                                            ?>
                                            <option value="">--Select country first--</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6">
                                    <div class="input-block mb-3">
                                        <label class="col-form-label">City<span class="text-danger">*</span></label>
                                        <select class="form-select" id="city" aria-label="Floating label select example">
                                            <?php   
                                                if($city_id == ''){
                                                    echo '<option value=""> City Not Selected </option>';
                                                }else{
                                                    echo '<option value=" '.$city_id.' "> '.$city_name. ' (Already Selected) </option>';
                                                }
                                            ?>
                                            <option value="">--Select state first--</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6">  
                                    <div class="input-block mb-3">
                                        <label class="col-form-label">Pincode<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="pin" placeholder="Pincode" value="<?php //echo $pincode; ?>" readonly >
                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-12">  
                                    <div class="input-block mb-3">
                                        <label class="col-form-label">Address<span class="text-danger">*</span></label>
                                        <textarea class="form-control" type="text" id="address" rows="3"><?php //echo $address ?></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Card section 3 -->
						<div class="card rounded-4 p-3 border-1">
							<div class="row">
                                <div class="d-flex gap-2">
                                    <p class="fw-bolder addTENum">03</p>
                                    <h4 class="fw-bolder text-dark align-content-center">Professional Information</h4>
                                    <?php //if ($status == 2) { ?>
                                        <div class="verify-toggle">
                                            <input type="radio" name="verification_status[professional]" id="professional_approve" class="approve_reason" value="approved" <?php // isChecked($verificationPayload, 'professional', 'approved'); ?>>
                                            <label class="verify-btn approve-btn" for="professional_approve"> Approved </label>
                                            <input type="radio" name="verification_status[professional]" id="professional_reject" class="reject_reason" value="rejected" <?php // isChecked($verificationPayload, 'professional', 'rejected'); ?>>
                                            <label class="verify-btn reject-btn" for="professional_reject"> Rejected </label>
                                        </div>
                                    <?php //} ?>
                                </div>
                                <div class="col-md-6 col-sm-6">
                                    <div class="input-block mb-3">
                                        <label class="col-form-label">Current Occupation / Business<span class="text-danger">*</span></label>
                                        <input class="form-control" type="text" id="occupation" value=" <?php //echo $current_occupation; ?>">
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6">
                                    <div class="input-block mb-3">
                                        <label class="col-form-label">Total Experience<span class="text-danger">*</span></label>
                                        <input class="form-control" type="text" id="experience" value=" <?php //echo $current_experience; ?>">
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6">
                                    <div class="input-block mb-3">
                                        <label class="col-form-label">Current Annual Income<span class="text-danger">*</span></label>
                                        <input class="form-control" type="text" id="annual_income" value=" <?php //echo $current_income; ?>">
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label class="col-form-label">Have You Managed teams Previously <span class="text-danger">*</span></label>
                                        <div class="form-control d-flex justify-content-around">
                                            <label class="radio-inline mb-0 ms-3"><input type="radio" name="teamManaged" class="teamManaged" id="teamManagedYes" value="yes" <?php //if ($managed_team == 'yes'){echo ' checked ';} ?> >&nbsp;&nbsp;&nbsp;Yes</label>
                                            <label class="radio-inline mb-0 ms-3"><input type="radio" name="teamManaged" class="teamManaged" id="teamManagedNo" value="no" <?php //if ($managed_team == 'no'){echo ' checked ';} ?> >&nbsp;&nbsp;&nbsp;No</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6">
                                    <div class="input-block mb-3">
                                        <label class="col-form-label">If Yes, Team size<span class="text-danger">*</span></label>
                                        <textarea class="form-control" id="teamSize" rows="4" cols="50"> <?php //echo htmlspecialchars($team_description); ?> </textarea>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6">
                                    <div class="input-block mb-3">
                                        <label class="col-form-label">
                                            Leadership Experience <span class="text-danger">*</span>
                                        </label>

                                        <div class="row mt-2">
                                            <!-- Left Column -->
                                            <div class="col-md-6">
                                                <div class="mb-2">
                                                    <input type="checkbox" id="lead1" name="leadership[]" value="Sales Leadership" <?php // in_array('Sales Leadership', $selectedLeadership ?? []) ? 'checked' : '' ?>>
                                                    <label for="lead1">Sales Leadership</label>
                                                </div>

                                                <div class="mb-2">
                                                    <input type="checkbox" id="lead2" name="leadership[]" value="Business Development" <?php // in_array('Business Development', $selectedLeadership ?? []) ? 'checked' : '' ?>>
                                                    <label for="lead2">Business Development</label>
                                                </div>

                                                <div class="mb-2">
                                                    <input type="checkbox" id="lead3" name="leadership[]" value="Team Management" <?php // in_array('Team Management', $selectedLeadership ?? []) ? 'checked' : '' ?>>
                                                    <label for="lead3">Team Management</label>
                                                </div>
                                                <div class="mb-2">
                                                    <input type="checkbox" id="lead4" name="leadership[]" value="Enterpreneurship" <?php // in_array('Enterpreneurship', $selectedLeadership ?? []) ? 'checked' : '' ?>>
                                                    <label for="lead4">Enterpreneurship</label>
                                                </div>

                                                <div class="mb-2">
                                                    <input type="checkbox" id="lead5" name="leadership[]" value="Corporate Leader" <?php // in_array('Corporate Leader', $selectedLeadership ?? []) ? 'checked' : '' ?>>
                                                    <label for="lead5">Corporate Leader</label>
                                                </div>

                                                <div class="mb-2">
                                                    <input type="checkbox" id="lead6" name="leadership[]" value="other" <?php // in_array('other', $selectedLeadership ?? []) ? 'checked' : '' ?>>
                                                    <label for="lead6">Other(Please Specify)</label>
                                                    <input type="text" name="other_leadership" id="otherLead" class="form-control mt-2" <?php //in_array('other', $selectedLeadership ?? []) ? 'style="display:block;' : 'style="display:none;' ?> " value="<?php // $leadership_experience_other; ?>">
                                                </div>
                                            </div>
                                            <input type="hidden" name="leadership_json" id="leadership_json">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Card section 4 -->
						<div class="card rounded-4 p-3 border-1">
							<div class="row">
                                <div class="d-flex gap-2">
                                    <p class="fw-bolder addTENum">04</p>
                                    <h4 class="fw-bolder text-dark align-content-center">Educational Information</h4>
                                    <?php //if ($status == 2) { ?>
                                        <div class="verify-toggle">
                                            <input type="radio" name="verification_status[education]" id="education_approve" class="approve_reason" value="approved" <?php // isChecked($verificationPayload, 'education', 'approved'); ?>>
                                            <label class="verify-btn approve-btn" for="education_approve"> Approved </label>
                                            <input type="radio" name="verification_status[education]" id="education_reject" class="reject_reason" value="rejected" <?php // isChecked($verificationPayload, 'education', 'rejected'); ?>>
                                            <label class="verify-btn reject-btn" for="education_reject"> Rejected </label>
                                        </div>
                                    <?php //} ?>
                                </div>
                                <div class="col-md-6 col-sm-6">
                                    <div class="input-block mb-3">
                                        <label class="col-form-label">Educational Qualification<span class="text-danger">*</span></label>
                                        <input class="form-control" type="text" id="qualification" value="<?php // $educational_qualification; ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Card section 5 -->
						<div class="card rounded-4 p-3 border-1">
							<div class="row">
                                <div class="d-flex gap-2">
                                    <p class="fw-bolder addTENum">05</p>
                                    <h4 class="fw-bolder text-dark align-content-center">Leadership Assessment Information</h4>
                                    <?php //if ($status == 2) { ?>
                                        <div class="verify-toggle">
                                            <input type="radio" name="verification_status[leadership]" id="leadership_approve" class="approve_reason" value="approved" <?php // isChecked($verificationPayload, 'leadership', 'approved'); ?> >
                                            <label class="verify-btn approve-btn" for="leadership_approve"> Approved </label>
                                            <input type="radio" name="verification_status[leadership]" id="leadership_reject" class="reject_reason" value="rejected" <?php // isChecked($verificationPayload, 'leadership', 'rejected'); ?> >
                                            <label class="verify-btn reject-btn" for="leadership_reject"> Rejected </label>
                                        </div>
                                    <?php //} ?>
                                </div>
                                <div class="col-md-12 col-sm-12">
                                    <div class="input-block mb-3">
                                        <label class="col-form-label">Why You want to become a Chief Techno Enterprise?<span class="text-danger">*</span></label>
                                        <textarea class="form-control" id="career_objective" rows="4" cols="50"> <?php // $career_objective; ?></textarea>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <div class="input-block mb-3">
                                        <label class="col-form-label">
                                            Expected Team Building Capacity(Within 12 Months) <span class="text-danger">*</span>
                                        </label>
                                        <div class="row mt-2">
                                            <div class="col-md-6">
                                                <div class="mb-2">
                                                    <input type="radio" id="expected1" name="teamExpected" class="teamExpected" value="5" <?php //if ($team_expected == '5'){echo ' checked ';} ?>>
                                                    <label for="expected1">5 Techno Enterprise</label>
                                                </div>

                                                <div class="mb-2">
                                                    <input type="radio" id="expected2" name="teamExpected" class="teamExpected" value="10" <?php //if ($team_expected == '10'){echo ' checked ';} ?>>
                                                    <label for="expected2">10 Techno Enterprise</label>
                                                </div>

                                                <div class="mb-2">
                                                    <input type="radio" id="expected3" name="teamExpected" class="teamExpected" value="15" <?php //if ($team_expected == '15'){echo ' checked ';} ?>>
                                                    <label for="expected3">15 Techno Enterprise</label>
                                                </div>
                                                <div class="mb-2">
                                                    <input type="radio" id="expected4" name="teamExpected" class="teamExpected" value="25+" <?php //if ($team_expected == '25+'){echo ' checked ';} ?>>
                                                    <label for="expected4">25+ Techno Enterprise</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <div class="input-block mb-3">
                                        <label class="col-form-label">Preferred Operating Region <span class="text-danger">*</span></label>
                                        <select class="form-select" id="OperatingState">
                                            <?php   
                                                if($operating_region == ''){
                                                    echo '<option value=""> Operating Region Not Selected </option>';
                                                }else{
                                                    echo '<option value=" '.$operating_region.' "> '.$statenameLeader. ' (Already Selected) </option>';
                                                }
                                                
                                            ?>
                                            <option value=""> ---- Select State ---- </option>
                                            <?php
                                            require '../connect.php';
                                            $sql = "SELECT * FROM `states` WHERE status ='1' ";
                                            $stmt = $conn->prepare($sql);
                                            $stmt->execute();
                                            $stmt->setFetchMode(PDO::FETCH_ASSOC);
                                            if ($stmt->rowCount() > 0) {
                                                foreach (($stmt->fetchAll()) as $key => $row) {
                                                    echo '
                                                                <option value="' . $row['id'] . '">' . $row['state_name'] . '</option>
                                                            ';
                                                }
                                            } else {
                                                echo '<option value="">Department not available</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Card section 6 -->
						<div class="card rounded-4 p-3 border-1">
							<div class="row">
                                <div class="d-flex gap-2">
                                    <p class="fw-bolder addTENum">06</p>
                                    <h4 class="fw-bolder text-dark align-content-center">Nominee Details</h4>
                                </div>
								<div class="col-lg-9">
									<div class="row">
                                        <div class="col-md-6 col-sm-6">
                                            <div class="input-block mb-3">
                                                <div class="verify-field">
                                                    <label class="col-form-label">Nominee Name<span class="text-danger">*</span></label>
                                                    <?php //if ($status == 2) { ?>
                                                    <div class="verify-toggle">
                                                        <input type="radio" name="verification_status[nominee_name]" id="nominee_name_approve" class="approve_reason" value="approved" <?php // isChecked($verificationPayload, 'nominee_name', 'approved'); ?> >
                                                        <label class="verify-btn approve-btn" for="nominee_name_approve"> Approved </label>
                                                        <input type="radio" name="verification_status[nominee_name]" id="nominee_name_reject" class="reject_reason" value="rejected" <?php // isChecked($verificationPayload, 'educnominee_nameation', 'rejected'); ?> >
                                                        <label class="verify-btn reject-btn" for="nominee_name_reject"> Rejected </label>
                                                    </div>
                                                    <?php //} ?>   
                                                </div>
                                                <input class="form-control" type="text" id="nomineeName" value="<?php // $nominee_name; ?>" >
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-6">
                                            <div class="input-block mb-3">
                                                <div class="verify-field">
                                                    <label class="col-form-label">Nominee Relation<span class="text-danger">*</span></label>
                                                    <?php //if ($status == 2) { ?>
                                                    <div class="verify-toggle">
                                                        <input type="radio" name="verification_status[nominee_relation]" id="nominee_relation_approve" class="approve_reason" value="approved" <?php // isChecked($verificationPayload, 'nominee_relation', 'approved'); ?> >
                                                        <label class="verify-btn approve-btn" for="nominee_relation_approve"> Approved </label>
                                                        <input type="radio" name="verification_status[nominee_relation]" id="nominee_relation_reject" class="reject_reason" value="rejected" <?php // isChecked($verificationPayload, 'nominee_relation', 'rejected'); ?> >
                                                        <label class="verify-btn reject-btn" for="nominee_relation_reject"> Rejected </label>
                                                    </div>
                                                    <?php //} ?>
                                                </div>
                                                <input class="form-control" type="text" id="nomineeRelation" value="<?php // $nominee_relation; ?>" >
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-12 mb-3">
                                            <div class="row">
                                                <div class="col-md-4 col-sm-4 col-3">
                                                    <div class="input-block">
                                                        <?php
                                                        require '../connect.php';
                                                        $stmt = $conn->prepare("SELECT * FROM countries WHERE status = 1 ORDER BY country_name ASC");
                                                        $stmt->execute();
                                                        $stmt->setFetchMode(PDO::FETCH_ASSOC);
                                                        ?>
                                                        <label for="countryCdNominee" class="col-form-label">Code:</label>
                                                        <select class="form-control" id="countryCdNominee">
                                                            <?php
                                                            if ($stmt->rowCount() > 0) {
                                                                foreach (($stmt->fetchAll()) as $key => $row) {
                                                                    echo '<option value="' . $row['country_code'] . '">+' . $row['country_code'] . ' (' . $row['sortname'] . ')</option>';
                                                                }
                                                            } else {
                                                                echo '<option value="">Country not available</option>';
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-8 col-sm-8 col-9">
                                                    <div class="input-block">
                                                        <div class="verify-field">
                                                            <label class="col-form-label">Nominee Phone Number <span class="text-danger">*</span></label>
                                                            <?php //if ($status == 2) { ?>
                                                            <div class="verify-toggle">
                                                                <input type="radio" name="verification_status[nominee_phone]" id="nominee_phone_approve" class="approve_reason" value="approved" <?php // isChecked($verificationPayload, 'nominee_phone', 'approved'); ?> >
                                                                <label class="verify-btn approve-btn" for="nominee_phone_approve"> Approved </label>
                                                                <input type="radio" name="verification_status[nominee_phone]" id="nominee_phone_reject" class="reject_reason" value="rejected" <?php // isChecked($verificationPayload, 'nominee_phone', 'rejected'); ?> >
                                                                <label class="verify-btn reject-btn" for="nominee_phone_reject"> Rejected </label>
                                                            </div>
                                                            <?php //} ?>
                                                        </div>
                                                        <input class="form-control" type="number" id="nomineePhone" placeholder="Enter Nominee Phone Number" value="<?php // $nominee_contact_no; ?>" >
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-6">
                                            <div class="input-block mb-3">
                                                <div class="verify-field">
                                                    <label class="col-form-label">Date of Birth <span class="text-danger">*</span></label>
                                                    <?php //if ($status == 2) { ?>
                                                    <div class="verify-toggle">
                                                        <input type="radio" name="verification_status[nominee_dob]" id="nominee_dob_approve" class="approve_reason" value="approved" <?php // isChecked($verificationPayload, 'nominee_dob', 'approved'); ?> >
                                                        <label class="verify-btn approve-btn" for="nominee_dob_approve"> Approved </label>
                                                        <input type="radio" name="verification_status[nominee_dob]" id="nominee_dob_reject" class="reject_reason" value="rejected" <?php // isChecked($verificationPayload, 'nominee_dob', 'rejected'); ?> >
                                                        <label class="verify-btn reject-btn" for="nominee_dob_reject"> Rejected </label>
                                                    </div>
                                                    <?php //} ?>
                                                </div>
                                                <input class="form-control" type="date" id="nomineeDob" value="<?php //echo $nominee_date_of_birth; ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-12 col-sm-6">
                                            <div class="input-block mb-3">
                                                <div class="verify-field">
                                                    <label class="col-form-label">Nominee Address<span class="text-danger">*</span></label>
                                                    <?php //if ($status == 2) { ?>
                                                    <div class="verify-toggle">
                                                        <input type="radio" name="verification_status[nominee_address]" id="nominee_address_approve" class="approve_reason" value="approved" <?php // isChecked($verificationPayload, 'nominee_address', 'approved'); ?> >
                                                        <label class="verify-btn approve-btn" for="nominee_address_approve"> Approved </label>
                                                        <input type="radio" name="verification_status[nominee_address]" id="nominee_address_reject" class="reject_reason" value="rejected" <?php // isChecked($verificationPayload, 'nominee_address', 'rejected'); ?> >
                                                        <label class="verify-btn reject-btn" for="nominee_address_reject"> Rejected </label>
                                                    </div>
                                                    <?php //} ?>
                                                </div>
                                                <textarea class="form-control" type="text" id="nomineeAddress" rows="3"><?php // $nominee_address; ?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3">
									<div class="row">
										<div class="col-lg-12">
                                            <div class="verify-field">
                                                <?php //if ($status == 2) { ?>
                                                <div class="verify-toggle">
                                                    <input type="radio" name="verification_status[nominee]" id="nominee_approve" class="approve_reason" value="approved" <?php // isChecked($verificationPayload, 'nominee', 'approved'); ?> > 
                                                    <label class="verify-btn approve-btn" for="nominee_approve"> Approved </label>
                                                    <input type="radio" name="verification_status[nominee]" id="nominee_reject" class="reject_reason" value="rejected" <?php // isChecked($verificationPayload, 'nominee', 'rejected'); ?> > 
                                                    <label class="verify-btn reject-btn" for="nominee_reject"> Rejected </label>
                                                </div>
                                                <?php //} ?>
                                            </div>
											<div class="upload-card" data-title="Nominee Profile Photo">
												<input type="file" class="file-input" accept="image/*,.pdf">
												<div class="upload-content">
													<div class="upload-icon">
														<i class="fa-solid fa-user"></i>
													</div>
													<h6>Nominee Profile Photo</h6>
													<p>Click to upload<br>or drag and drop</p>
													<small>(JPG, PNG, PDF)</small>
												</div>
											</div>
										</div>
									</div>
								</div>
                            </div>
                        </div>
                        <!-- Card section 7 -->
						<div class="card rounded-4 p-3 border-1">
							<div class="row">
                                <div class="d-flex gap-2">
                                    <p class="fw-bolder addTENum">07</p>
                                    <h4 class="fw-bolder text-dark align-content-center">Bank Details</h4>
                                </div>
                                <div class="col-md-6 col-sm-6">
                                    <div class="input-block mb-3">
                                        <div class="verify-field">
                                            <label class="col-form-label">Account Holder Name<span class="text-danger">*</span></label>
                                            <?php //if ($status == 2) { ?>
                                            <div class="verify-toggle">
                                                <input type="radio" name="verification_status[account_holder]" id="account_holder_approve" class="approve_reason" value="approved" <?php // isChecked($verificationPayload, 'account_holder', 'approved'); ?> >
                                                <label class="verify-btn approve-btn" for="account_holder_approve"> Approved </label>
                                                <input type="radio" name="verification_status[account_holder]" id="account_holder_reject" class="reject_reason" value="rejected" <?php // isChecked($verificationPayload, 'account_holder', 'rejected'); ?>>
                                                <label class="verify-btn reject-btn" for="account_holder_reject"> Rejected </label>
                                            </div>
                                            <?php //} ?>
                                        </div>
                                        <input class="form-control" type="text" id="accHolderName" value="<?php // $account_holder_name;  ?>" >
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6">
                                    <div class="input-block mb-3">
                                        <div class="verify-field">
                                            <label class="col-form-label">Bank Name<span class="text-danger">*</span></label>
                                            <?php //if ($status == 2) { ?>
                                            <div class="verify-toggle">
                                                <input type="radio" name="verification_status[bank_name]" id="bank_name_approve" class="approve_reason" value="approved" <?php // isChecked($verificationPayload, 'bank_name', 'approved'); ?> >
                                                <label class="verify-btn approve-btn" for="bank_name_approve"> Approved </label>
                                                <input type="radio" name="verification_status[bank_name]" id="bank_name_reject" class="reject_reason" value="rejected" <?php // isChecked($verificationPayload, 'bank_name', 'rejected'); ?> >
                                                <label class="verify-btn reject-btn" for="bank_name_reject"> Rejected </label>
                                            </div>
                                            <?php //} ?>
                                        </div>
                                        <input class="form-control" type="text" id="bankName" value="<?php // $bank_name;  ?>" >
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6">
                                    <div class="input-block mb-3">
                                        <div class="verify-field">
                                            <label class="col-form-label">Account Number<span class="text-danger">*</span></label>
                                            <?php //if ($status == 2) { ?>
                                            <div class="verify-toggle">
                                                <input type="radio" name="verification_status[account_number]" id="account_number_approve" class="approve_reason" value="approved" <?php // isChecked($verificationPayload, 'account_number', 'approved'); ?>>
                                                <label class="verify-btn approve-btn" for="account_number_approve"> Approved </label>
                                                <input type="radio" name="verification_status[account_number]" id="account_number_reject" class="reject_reason" value="rejected" <?php // isChecked($verificationPayload, 'account_number', 'rejected'); ?>>
                                                <label class="verify-btn reject-btn" for="account_number_reject"> Rejected </label>
                                            </div>
                                            <?php //} ?>
                                        </div>
                                        <input class="form-control" type="text" id="accountNumber" value="<?php // $account_number;  ?>" >
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6">
                                    <div class="input-block mb-3">
                                        <label class="col-form-label">Confirm Account Number<span class="text-danger">*</span></label>
                                        <input class="form-control" type="text" id="confirmAccountNumber" value="<?php // $account_number;  ?>" >
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6">
                                    <div class="input-block mb-3">
                                        <div class="verify-field">
                                            <label class="col-form-label">IFSC Code<span class="text-danger">*</span></label>
                                            <?php //if ($status == 2) { ?>
                                            <div class="verify-toggle">
                                                <input type="radio" name="verification_status[ifsc_code]" id="ifsc_code_approve" class="approve_reason" value="approved" <?php // isChecked($verificationPayload, 'ifsc_code', 'approved'); ?> >
                                                <label class="verify-btn approve-btn" for="ifsc_code_approve"> Approved </label>
                                                <input type="radio" name="verification_status[ifsc_code]" id="ifsc_code_reject" class="reject_reason" value="rejected" <?php // isChecked($verificationPayload, 'ifsc_code', 'rejected'); ?> >
                                                <label class="verify-btn reject-btn" for="ifsc_code_reject"> Rejected </label>
                                            </div>
                                            <?php //} ?>
                                        </div>
                                        <input class="form-control" type="text" id="ifscCode" value="<?php // $ifsc_code;  ?>" >
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6">
                                    <div class="input-block mb-3">
                                        <div class="verify-field">
                                            <label class="col-form-label">Branch Name<span class="text-danger">*</span></label>
                                            <?php //if ($status == 2) { ?>
                                            <div class="verify-toggle">
                                                <input type="radio" name="verification_status[branch_name]" id="branch_name_approve" class="approve_reason" value="approved" <?php // isChecked($verificationPayload, 'branch_name', 'approved'); ?> >
                                                <label class="verify-btn approve-btn" for="branch_name_approve"> Approved </label>
                                                <input type="radio" name="verification_status[branch_name]" id="branch_name_reject" class="reject_reason" value="rejected" <?php // isChecked($verificationPayload, 'branch_name', 'rejected'); ?> >
                                                <label class="verify-btn reject-btn" for="branch_name_reject"> Rejected </label>
                                            </div>
                                            <?php //} ?>
                                        </div>
                                        <input class="form-control" type="text" id="branchName" value="<?php // $branch_name;  ?>" >
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Card section 8 -->
						<div class="card rounded-4 p-3 border-1">
							<div class="row">
                                <div class="d-flex gap-2">
                                    <p class="fw-bolder addTENum">08</p>
                                    <h4 class="fw-bolder text-dark align-content-center">Upload Documents</h4>
                                </div>
								<div class="row g-3">
									<!-- Aadhaar -->
									<div class="col-lg-4 col-md-4 col-12">
                                        <div class="verify-field">
                                            <?php //if ($status == 2) { ?>
                                            <div class="verify-toggle">
                                                <input type="radio" name="verification_status[aadhar]" id="aadhar_approve" class="approve_reason" value="approved" <?php // isChecked($verificationPayload, 'aadhar', 'approved'); ?> > 
                                                <label class="verify-btn approve-btn" for="aadhar_approve"> Approved </label>
                                                <input type="radio" name="verification_status[aadhar]" id="aadhar_reject" class="reject_reason" value="rejected" <?php // isChecked($verificationPayload, 'aadhar', 'rejected'); ?> > 
                                                <label class="verify-btn reject-btn" for="aadhar_reject"> Rejected </label>
                                            </div>
                                            <?php //} ?>
                                        </div>
										<div class="upload-card" data-title="Aadhaar Card">
											<input type="file" class="file-input" accept="image/*,.pdf">
											<div class="upload-content">
												<div class="upload-icon">
													<i class="fa-regular fa-id-card"></i>
												</div>
												<h6>Aadhaar Card</h6>
												<p>Click to upload<br>or drag and drop</p>
												<small>(JPG, PNG, PDF)</small>
											</div>
										</div>
									</div>

									<!-- PAN -->
									<div class="col-lg-4 col-md-4 col-12">
                                        <div class="verify-field">
                                            <?php //if ($status == 2) { ?>
                                            <div class="verify-toggle">
                                                <input type="radio" name="verification_status[pan]" id="pan_approve" class="approve_reason" value="approved" <?php // isChecked($verificationPayload, 'pan', 'approved'); ?> > 
                                                <label class="verify-btn approve-btn" for="pan_approve"> Approved </label>
                                                <input type="radio" name="verification_status[pan]" id="pan_reject" class="reject_reason" value="rejected" <?php // isChecked($verificationPayload, 'pan', 'rejected'); ?> > 
                                                <label class="verify-btn reject-btn" for="pan_reject"> Rejected </label>
                                            </div>
                                            <?php //} ?>
                                        </div>
										<div class="upload-card" data-title="PAN Card">
											<input type="file" class="file-input" accept="image/*,.pdf">
											<div class="upload-content">
												<div class="upload-icon">
													<i class="fa-regular fa-credit-card"></i>
												</div>
												<h6>PAN Card</h6>
												<p>Click to upload<br>or drag and drop</p>
												<small>(JPG, PNG, PDF)</small>
											</div>
										</div>
									</div>

									<!-- Bank Passbook -->
									<div class="col-lg-4 col-md-4 col-12">
                                        <div class="verify-field">
                                            <?php //if ($status == 2) { ?>
                                            <div class="verify-toggle">
                                                <input type="radio" name="verification_status[bank]" id="bank_approve" class="approve_reason" value="approved" <?php // isChecked($verificationPayload, 'bank', 'approved'); ?> > 
                                                <label class="verify-btn approve-btn" for="bank_approve"> Approved </label>
                                                <input type="radio" name="verification_status[bank]" id="bank_reject" class="reject_reason" value="rejected" <?php // isChecked($verificationPayload, 'bank', 'rejected'); ?> > 
                                                <label class="verify-btn reject-btn" for="bank_reject"> Rejected </label>
                                            </div>
                                            <?php //} ?>
                                        </div>
										<div class="upload-card" data-title="Bank Passbook">
											<input type="file" class="file-input" accept="image/*,.pdf">
											<div class="upload-content">
												<div class="upload-icon">
													<i class="fa-solid fa-building-columns"></i>
												</div>
												<h6>Cancelled Cheque / Bank Passbook</h6>
												<p>Click to upload<br>or drag and drop</p>
												<small>(JPG, PNG, PDF)</small>
											</div>
										</div>
									</div>

									<!-- Resume -->
									<div class="col-lg-4 col-md-4 col-12">
                                        <div class="verify-field">
                                            <?php //if ($status == 2) { ?>
                                            <div class="verify-toggle">
                                                <input type="radio" name="verification_status[resume]" id="resume_approve" class="approve_reason" value="approved" <?php // isChecked($verificationPayload, 'resume', 'approved'); ?> > 
                                                <label class="verify-btn approve-btn" for="resume_approve"> Approved </label>
                                                <input type="radio" name="verification_status[resume]" id="resume_reject" class="reject_reason" value="rejected" <?php // isChecked($verificationPayload, 'resume', 'rejected'); ?> > 
                                                <label class="verify-btn reject-btn" for="resume_reject"> Rejected </label>
                                            </div>
                                            <?php //} ?>
                                        </div>
										<div class="upload-card" data-title="Resume / CV">
											<input type="file" class="file-input" accept="image/*,.pdf">
											<div class="upload-content">
												<div class="upload-icon">
													<i class="fa-regular fa-address-card"></i>
												</div>
												<h6>Resume / CV</h6>
												<p>Click to upload<br>or drag and drop</p>
												<small>(JPG, PNG, PDF)</small>
											</div>
										</div>
									</div>
									<!-- Address Proof -->
									<div class="col-lg-4 col-md-4 col-12">
                                        <div class="verify-field">
                                            <?php //if ($status == 2) { ?>
                                            <div class="verify-toggle">
                                                <input type="radio" name="verification_status[address]" id="address_approve" class="approve_reason" value="approved" <?php // isChecked($verificationPayload, 'address', 'approved'); ?> > 
                                                <label class="verify-btn approve-btn" for="address_approve"> Approved </label>
                                                <input type="radio" name="verification_status[address]" id="address_reject" class="reject_reason" value="rejected" <?php // isChecked($verificationPayload, 'address', 'rejected'); ?> > 
                                                <label class="verify-btn reject-btn" for="address_reject"> Rejected </label>
                                            </div>
                                            <?php //} ?>
                                        </div>
										<div class="upload-card" data-title="Address Proof">
											<input type="file" class="file-input" accept="image/*,.pdf">
											<div class="upload-content">
												<div class="upload-icon">
													<i class="fa-regular fa-address-card"></i>
												</div>
												<h6>Address Proof</h6>
												<p>Click to upload<br>or drag and drop</p>
												<small>(JPG, PNG, PDF)</small>
											</div>
										</div>
									</div>

									<!-- Professional Profile -->
									<div class="col-lg-4 col-md-4 col-12">
                                        <div class="verify-field">
                                            <?php //if ($status == 2) { ?>
                                            <div class="verify-toggle">
                                                <input type="radio" name="verification_status[profile2]" id="profile2_approve" class="approve_reason" value="approved" <?php // isChecked($verificationPayload, 'profile2', 'approved'); ?> > 
                                                <label class="verify-btn approve-btn" for="profile2_approve"> Approved </label>
                                                <input type="radio" name="verification_status[profile2]" id="profile2_reject" class="reject_reason" value="rejected" <?php // isChecked($verificationPayload, 'profile2', 'rejected'); ?> > 
                                                <label class="verify-btn reject-btn" for="profile2_reject"> Rejected </label>
                                            </div>
                                            <?php //} ?>
                                        </div>
										<div class="upload-card" data-title="Professional Profile">
											<input type="file" class="file-input" accept="image/*,.pdf">
											<div class="upload-content">
												<div class="upload-icon">
													<i class="fa-solid fa-file-invoice"></i>
												</div>
												<h6>Professional Profile</h6>
												<p>Click to upload<br>or drag and drop</p>
												<small>(JPG, PNG, PDF)</small>
											</div>
										</div>
									</div>
									<!-- Business Profile -->
									<div class="col-lg-4 col-md-4 col-12">
                                        <div class="verify-field">
                                            <?php //if ($status == 2) { ?>
                                            <div class="verify-toggle">
                                                <input type="radio" name="verification_status[business]" id="business_approve" class="approve_reason" value="approved" <?php // isChecked($verificationPayload, 'business', 'approved'); ?> > 
                                                <label class="verify-btn approve-btn" for="business_approve"> Approved </label>
                                                <input type="radio" name="verification_status[business]" id="business_reject" class="reject_reason" value="rejected" <?php // isChecked($verificationPayload, 'business', 'rejected'); ?> > 
                                                <label class="verify-btn reject-btn" for="business_reject"> Rejected </label>
                                            </div>
                                            <?php //} ?>
                                        </div>
										<div class="upload-card" data-title="Business Profile">
											<input type="file" class="file-input" accept="image/*,.pdf">
											<div class="upload-content">
												<div class="upload-icon">
													<i class="fa-solid fa-file-invoice"></i>
												</div>
												<h6>Business Profile</h6>
												<p>Click to upload<br>or drag and drop</p>
												<small>(JPG, PNG, PDF)</small>
											</div>
										</div>
									</div>
									<!-- Income Proof -->
									<div class="col-lg-4 col-md-4 col-12">
                                        <div class="verify-field">
                                            <?php //if ($status == 2) { ?>
                                            <div class="verify-toggle">
                                                <input type="radio" name="verification_status[income]" id="income_approve" class="approve_reason" value="approved" <?php // isChecked($verificationPayload, 'income', 'approved'); ?> > 
                                                <label class="verify-btn approve-btn" for="income_approve"> Approved </label>
                                                <input type="radio" name="verification_status[income]" id="income_reject" class="reject_reason" value="rejected" <?php // isChecked($verificationPayload, 'income', 'rejected'); ?> > 
                                                <label class="verify-btn reject-btn" for="income_reject"> Rejected </label>
                                            </div>
                                            <?php //} ?>
                                        </div>
										<div class="upload-card" data-title="Income Proof">
											<input type="file" class="file-input" accept="image/*,.pdf">
											<div class="upload-content">
												<div class="upload-icon">
													<i class="fa-solid fa-file-invoice"></i>
												</div>
												<h6>Income Proof</h6>
												<p>Click to upload<br>or drag and drop</p>
												<small>(JPG, PNG, PDF)</small>
											</div>
										</div>
									</div>
									<!-- Other Document -->
									<div class="col-lg-4 col-md-4 col-12">
                                        <div class="verify-field">
                                            <?php //if ($status == 2) { ?>
                                            <div class="verify-toggle">
                                                <input type="radio" name="verification_status[other]" id="other_approve" class="approve_reason" value="approved" <?php // isChecked($verificationPayload, 'other', 'approved'); ?> > 
                                                <label class="verify-btn approve-btn" for="other_approve"> Approved </label>
                                                <input type="radio" name="verification_status[other]" id="other_reject" class="reject_reason" value="rejected" <?php // isChecked($verificationPayload, 'other', 'rejected'); ?> > 
                                                <label class="verify-btn reject-btn" for="other_reject"> Rejected </label>
                                            </div>
                                            <?php //} ?>
                                        </div>
										<div class="upload-card" data-title="Other Document">
											<input type="file" class="file-input" accept="image/*,.pdf">
											<div class="upload-content">
												<div class="upload-icon">
													<i class="fa-solid fa-file-invoice"></i>
												</div>
												<h6>Other Document</h6>
												<p>Click to upload<br>or drag and drop</p>
												<small>(JPG, PNG, PDF)</small>
											</div>
										</div>
									</div>
								</div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-center mb-4">
							<div class="col-lg-12">
                                <div class="d-flex justify-content-end gap-4 submitBtnBackground">
                                    <!-- <button class="btn btn-primary submit-btn submit-btn1 px-5 py-2" id="saveDraftAdd">Save as Draft</button> -->
                                    <button class="btn btn-primary submit-btn submit-btn1 px-5 py-2" id="editChiefTechnoEnterprise">Submit</button>
                                </div>
                            </div>
						</div>
                        <!-- <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <form> -->
                                            <!-- <h3>Edit Chief Techno Enterprise</h3> -->

                                                <!-- Attachments -->
                                                <!-- <h4 class="my-2">Attachments</h4>
                                                <div class="col-md-6 col-sm-6">  
                                                    <div class="input-block mb-3">
                                                        <div class="verify-field">
                                                            <label class="col-form-label">Profile Picture
                                                            <?php
                                                                if ($profile_pic) {
                                                                    
                                                            ?>
                                                                <a href="<?php echo '../../uploading/' . $profile_pic; ?>" download class="ms-3" title="Download">
                                                                    <i class="fa fa-download fa-1x" aria-hidden="true"></i>
                                                                </a>
                                                            <?php
                                                                }
                                                            ?>
                                                            </label>
                                                            <?php if ($status == 2) { ?>
                                                            <div class="verify-toggle">
                                                                <input type="radio" name="verification_status[profile_pic]" id="profile_pic_approve" class="approve_reason" value="approved" <?php // isChecked($verificationPayload, 'profile_pic', 'approved'); ?> >
                                                                <label class="verify-btn approve-btn" for="profile_pic_approve"> Approved </label>
                                                                <input type="radio" name="verification_status[profile_pic]" id="profile_pic_reject" class="reject_reason" value="rejected" <?php // isChecked($verificationPayload, 'profile_pic', 'rejected'); ?> >
                                                                <label class="verify-btn reject-btn" for="profile_pic_reject"> Rejected </label>
                                                            </div>
                                                            <?php } ?>
                                                        </div>
                                                        <input class="form-control" type="file" name="file1" id="upload_file1">
                                                    </div>
                                                    <input type="hidden" id="img_path1" value="<?php echo $profile_pic;?>">
                                                    <div id="preview1" >
                                                        <div id="image_preview1">
                                                            <?php
                                                                if($profile_pic ==''){
                                                                    echo '<img src="../../uploading/not_uploaded.png" alt="Preview" id="img_pre1" class="imgSize">';
                                                                }else{
                                                                    echo '<img src="../../uploading/'.$profile_pic.'" alt="Preview" id="img_pre1" class="imgSize">';?>
                                                                    
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div> 
                                                <div class="col-md-6 col-sm-6">  
                                                    <div class="input-block mb-3">
                                                        <div class="verify-field">
                                                            <label class="col-form-label">Aadhaar Card
                                                            <?php
                                                                if ($aadhar_card) {
                                                                    
                                                            ?>
                                                                <a href="<?php echo '../../uploading/' . $aadhar_card; ?>" download class="ms-3" title="Download">
                                                                    <i class="fa fa-download fa-1x" aria-hidden="true"></i>
                                                                </a>
                                                            <?php
                                                                }
                                                            ?>
                                                            </label>
                                                            <?php if ($status == 2) { ?>
                                                            <div class="verify-toggle">
                                                                <input type="radio" name="verification_status[aadhar_card]" id="aadhar_card_approve" class="approve_reason" value="approved" <?php // isChecked($verificationPayload, 'aadhar_card', 'approved'); ?> >
                                                                <label class="verify-btn approve-btn" for="aadhar_card_approve"> Approved </label>
                                                                <input type="radio" name="verification_status[aadhar_card]" id="aadhar_card_reject" class="reject_reason" value="rejected" <?php // isChecked($verificationPayload, 'aadhar_card', 'rejected'); ?>>
                                                                <label class="verify-btn reject-btn" for="aadhar_card_reject"> Rejected </label>
                                                            </div>
                                                            <?php } ?>
                                                        </div>
                                                        <input class="form-control" type="file" name="file2" id="upload_file2">
                                                    </div>
                                                    <input type="hidden" id="img_path2" value="<?php echo $aadhar_card;?>">
                                                    <div id="preview2" >
                                                        <div id="image_preview2">
                                                            <?php
                                                                if($aadhar_card ==''){
                                                                    echo '<img src="../../uploading/not_uploaded.png" alt="Preview" id="img_pre2" class="imgSize">';
                                                                }else{
                                                                    echo '<img src="../../uploading/'.$aadhar_card.'" alt="Preview" id="img_pre2" class="imgSize">';?>
                                                                    
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div> 
                                                <div class="col-md-6 col-sm-6">  
                                                    <div class="input-block mb-3">
                                                        <div class="verify-field">
                                                            <label class="col-form-label">Pan Card
                                                            <?php
                                                                if ($pan_card) {
                                                                    
                                                            ?>
                                                                <a href="<?php echo '../../uploading/' . $pan_card; ?>" download class="ms-3" title="Download">
                                                                    <i class="fa fa-download fa-1x" aria-hidden="true"></i>
                                                                </a>
                                                            <?php
                                                                }
                                                            ?>
                                                            </label>
                                                            <?php if ($status == 2) { ?>
                                                            <div class="verify-toggle">
                                                                <input type="radio" name="verification_status[pan_card]" id="pan_card_approve" class="approve_reason" value="approved" <?php // isChecked($verificationPayload, 'pan_card', 'approved'); ?> >
                                                                <label class="verify-btn approve-btn" for="pan_card_approve"> Approved </label>
                                                                <input type="radio" name="verification_status[pan_card]" id="pan_card_reject" class="reject_reason" value="rejected" <?php // isChecked($verificationPayload, 'pan_card', 'rejected'); ?> >
                                                                <label class="verify-btn reject-btn" for="pan_card_reject"> Rejected </label>
                                                            </div>
                                                            <?php } ?>
                                                        </div>
                                                        <input class="form-control" type="file"name="file3" id="upload_file3">
                                                    </div>
                                                    <input type="hidden" id="img_path3" value="<?php echo $pan_card;?>">
                                                    <div id="preview3" >
                                                        <div id="image_preview3">
                                                            <?php
                                                                if($pan_card ==''){
                                                                    echo '<img src="../../uploading/not_uploaded.png" alt="Preview" id="img_pre3" class="imgSize">';
                                                                }else{
                                                                    echo '<img src="../../uploading/'.$pan_card.'" alt="Preview" id="img_pre3" class="imgSize">';?>
                                                                    
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div> 
                                                <div class="col-md-6 col-sm-6">  
                                                    <div class="input-block mb-3">
                                                        <div class="verify-field">
                                                            <label class="col-form-label">Bank Passbook
                                                            <?php
                                                                if ($cancelled_cheque_bank_passbook) {
                                                                    
                                                            ?>
                                                                <a href="<?php echo '../../uploading/' . $cancelled_cheque_bank_passbook; ?>" download class="ms-3" title="Download">
                                                                    <i class="fa fa-download fa-1x" aria-hidden="true"></i>
                                                                </a>
                                                            <?php
                                                                }
                                                            ?>
                                                            </label>
                                                            <?php if ($status == 2) { ?>
                                                            <div class="verify-toggle">
                                                                <input type="radio" name="verification_status[bank_passbook]" id="bank_passbook_approve" class="approve_reason" value="approved" <?php // isChecked($verificationPayload, 'bank_passbook', 'approved'); ?> >
                                                                <label class="verify-btn approve-btn" for="bank_passbook_approve"> Approved </label>
                                                                <input type="radio" name="verification_status[bank_passbook]" id="bank_passbook_reject" class="reject_reason" value="rejected" <?php // isChecked($verificationPayload, 'bank_passbook', 'rejected'); ?> >
                                                                <label class="verify-btn reject-btn" for="bank_passbook_reject"> Rejected </label>
                                                            </div>
                                                            <?php } ?>
                                                        </div>
                                                        <input class="form-control" type="file" name="file4" id="upload_file4">
                                                    </div>
                                                    <input type="hidden" id="img_path4" value="<?php echo $cancelled_cheque_bank_passbook;?>">
                                                    <div id="preview3" >
                                                        <div id="image_preview4">
                                                            <?php
                                                                if($cancelled_cheque_bank_passbook ==''){
                                                                    echo '<img src="../../uploading/not_uploaded.png" alt="Preview" id="img_pre4" class="imgSize">';
                                                                }else{
                                                                    echo '<img src="../../uploading/'.$cancelled_cheque_bank_passbook.'" alt="Preview" id="img_pre4" class="imgSize">';?>
                                                                   
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div> 
                                                <div class="col-md-6 col-sm-6">  
                                                    <div class="input-block mb-3">
                                                        <div class="verify-field">
                                                            <label class="col-form-label">Resume / CV
                                                            <?php
                                                                if ($resume_cv) {
                                                                    
                                                            ?>
                                                                <a href="<?php echo '../../uploading/' . $resume_cv; ?>" download class="ms-3" title="Download">
                                                                    <i class="fa fa-download fa-1x" aria-hidden="true"></i>
                                                                </a>
                                                            <?php
                                                                }
                                                            ?>
                                                            </label>
                                                            <?php if ($status == 2) { ?>
                                                            <div class="verify-toggle">
                                                                <input type="radio" name="verification_status[resume_cv]" id="resume_cv_approve" class="approve_reason" value="approved" <?php // isChecked($verificationPayload, 'resume_cv', 'approved'); ?> >
                                                                <label class="verify-btn approve-btn" for="resume_cv_approve"> Approved </label>
                                                                <input type="radio" name="verification_status[resume_cv]" id="resume_cv_reject" class="reject_reason" value="rejected" <?php // isChecked($verificationPayload, 'resume_cv', 'rejected'); ?> >
                                                                <label class="verify-btn reject-btn" for="resume_cv_reject"> Rejected </label>
                                                            </div>
                                                            <?php } ?>
                                                        </div>
                                                        <input class="form-control" type="file" name="file5" id="upload_file5">
                                                    </div>
                                                    <input type="hidden" id="img_path5" value="<?php echo $resume_cv;?>">
                                                    <div id="preview3" >
                                                        <div id="image_preview5">
                                                            <?php
                                                                if($resume_cv ==''){
                                                                    echo '<img src="../../uploading/not_uploaded.png" alt="Preview" id="img_pre5" class="imgSize">';
                                                                }else{
                                                                    echo '<img src="../../uploading/'.$resume_cv.'" alt="Preview" id="img_pre5" class="imgSize">';?>
                                                                    
                                                            <?php } ?>
                                                            
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-sm-6">  
                                                    <div class="input-block mb-3">
                                                        <div class="verify-field">
                                                            <label class="col-form-label">Address Proof
                                                            <?php
                                                                if ($address_proof) {
                                                                    
                                                            ?>
                                                                <a href="<?php echo '../../uploading/' . $address_proof; ?>" download class="ms-3" title="Download">
                                                                    <i class="fa fa-download fa-1x" aria-hidden="true"></i>
                                                                </a>
                                                            <?php
                                                                }
                                                            ?>
                                                            </label>
                                                            <?php if ($status == 2) { ?>
                                                            <div class="verify-toggle">
                                                                <input type="radio" name="verification_status[address_proof]" id="address_proof_approve" class="approve_reason" value="approved" <?php // isChecked($verificationPayload, 'address_proof', 'approved'); ?>>
                                                                <label class="verify-btn approve-btn" for="address_proof_approve"> Approved </label>
                                                                <input type="radio" name="verification_status[address_proof]" id="address_proof_reject" class="reject_reason" value="rejected" <?php // isChecked($verificationPayload, 'address_proof', 'rejected'); ?>>
                                                                <label class="verify-btn reject-btn" for="address_proof_reject"> Rejected </label>
                                                            </div>
                                                            <?php } ?>
                                                        </div>
                                                        <input class="form-control" type="file" name="file6" id="upload_file6">
                                                    </div>
                                                    <input type="hidden" id="img_path6" value="<?php echo $address_proof;?>">
                                                    <div id="preview3" >
                                                        <div id="image_preview6">
                                                            <?php
                                                                if($address_proof ==''){
                                                                    echo '<img src="../../uploading/not_uploaded.png" alt="Preview" id="img_pre6" class="imgSize">';
                                                                }else{
                                                                    echo '<img src="../../uploading/'.$address_proof.'" alt="Preview" id="img_pre6" class="imgSize">';?>
                                                                    
                                                            <?php } ?>
                                                            
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-sm-6">  
                                                    <div class="input-block mb-3">
                                                        <div class="verify-field">
                                                            <label class="col-form-label">Professional Profile
                                                            <?php
                                                                if ($professional_profile) {
                                                                    
                                                            ?>
                                                                <a href="<?php echo '../../uploading/' . $professional_profile; ?>" download class="ms-3" title="Download">
                                                                    <i class="fa fa-download fa-1x" aria-hidden="true"></i>
                                                                </a>
                                                            <?php
                                                                }
                                                            ?>
                                                            </label>
                                                            <?php if ($status == 2) { ?>
                                                            <div class="verify-toggle">
                                                                <input type="radio" name="verification_status[professional_profile]" id="professional_profile_approve" class="approve_reason" value="approved" <?php // isChecked($verificationPayload, 'professional_profile', 'approved'); ?>>
                                                                <label class="verify-btn approve-btn" for="professional_profile_approve"> Approved </label>
                                                                <input type="radio" name="verification_status[professional_profile]" id="professional_profile_reject" class="reject_reason" value="rejected" <?php // isChecked($verificationPayload, 'professional_profile', 'rejected'); ?>>
                                                                <label class="verify-btn reject-btn" for="professional_profile_reject"> Rejected </label>
                                                            </div>
                                                            <?php } ?>
                                                        </div>
                                                        <input class="form-control" type="file" name="file7" id="upload_file7">
                                                    </div>
                                                    <input type="hidden" id="img_path7" value="<?php echo $professional_profile;?>">
                                                    <div id="preview3" >
                                                        <div id="image_preview7">
                                                            <?php
                                                                if($professional_profile ==''){
                                                                    echo '<img src="../../uploading/not_uploaded.png" alt="Preview" id="img_pre7" class="imgSize">';
                                                                }else{
                                                                    echo '<img src="../../uploading/'.$professional_profile.'" alt="Preview" id="img_pre7" class="imgSize">';?>
                                                                    
                                                            <?php } ?>
                                                            
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-sm-6">  
                                                    <div class="input-block mb-3">
                                                        <div class="verify-field">
                                                            <label class="col-form-label">Business Profile
                                                            <?php
                                                                if ($business_profile) {
                                                                    
                                                            ?>
                                                                <a href="<?php echo '../../uploading/' . $business_profile; ?>" download class="ms-3" title="Download">
                                                                    <i class="fa fa-download fa-1x" aria-hidden="true"></i>
                                                                </a>
                                                            <?php
                                                                }
                                                            ?>
                                                            </label>
                                                            <?php if ($status == 2) { ?>
                                                            <div class="verify-toggle">
                                                                <input type="radio" name="verification_status[business_profile]" id="business_profile_approve" class="approve_reason" value="approved" <?php // isChecked($verificationPayload, 'business_profile', 'approved'); ?> >
                                                                <label class="verify-btn approve-btn" for="business_profile_approve"> Approved </label>
                                                                <input type="radio" name="verification_status[business_profile]" id="business_profile_reject" class="reject_reason" value="rejected" <?php // isChecked($verificationPayload, 'business_profile', 'rejected'); ?>>
                                                                <label class="verify-btn reject-btn" for="business_profile_reject"> Rejected </label>
                                                            </div>
                                                            <?php } ?>

                                                        </div>
                                                        <input class="form-control" type="file" name="file8" id="upload_file8">
                                                    </div>
                                                    <input type="hidden" id="img_path8" value="<?php echo $business_profile;?>">
                                                    <div id="preview3" >
                                                        <div id="image_preview8">
                                                            <?php
                                                                if($business_profile ==''){
                                                                    echo '<img src="../../uploading/not_uploaded.png" alt="Preview" id="img_pre8" class="imgSize">';
                                                                }else{
                                                                    echo '<img src="../../uploading/'.$business_profile.'" alt="Preview" id="img_pre8" class="imgSize">';?>
                                                                    
                                                            <?php } ?>
                                                            
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-sm-6">  
                                                    <div class="input-block mb-3">
                                                        <div class="verify-field">
                                                            <label class="col-form-label">Income Proof
                                                            <?php
                                                                if ($income_proof) {
                                                                    
                                                            ?>
                                                                <a href="<?php echo '../../uploading/' . $income_proof; ?>" download class="ms-3" title="Download">
                                                                    <i class="fa fa-download fa-1x" aria-hidden="true"></i>
                                                                </a>
                                                            <?php
                                                                }
                                                            ?>
                                                            </label>
                                                            <?php if ($status == 2) { ?>
                                                            <div class="verify-toggle">
                                                                <input type="radio" name="verification_status[income_proof]" id="income_proof_approve" class="approve_reason" value="approved" <?php // isChecked($verificationPayload, 'income_proof', 'approved'); ?> >
                                                                <label class="verify-btn approve-btn" for="income_proof_approve"> Approved </label>
                                                                <input type="radio" name="verification_status[income_proof]" id="income_proof_reject" class="reject_reason" value="rejected" <?php // isChecked($verificationPayload, 'income_proof', 'rejected'); ?> >
                                                                <label class="verify-btn reject-btn" for="income_proof_reject"> Rejected </label>
                                                            </div>
                                                            <?php } ?>
                                                        </div>
                                                        <input class="form-control" type="file" name="file9" id="upload_file9">
                                                    </div>
                                                    <input type="hidden" id="img_path9" value="<?php echo $income_proof;?>">
                                                    <div id="preview3" >
                                                        <div id="image_preview9">
                                                            <?php
                                                                if($income_proof ==''){
                                                                    echo '<img src="../../uploading/not_uploaded.png" alt="Preview" id="img_pre9" class="imgSize">';
                                                                }else{
                                                                    echo '<img src="../../uploading/'.$income_proof.'" alt="Preview" id="img_pre9" class="imgSize">';?>
                                                                    
                                                            <?php } ?>
                                                            
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-sm-6">  
                                                    <div class="input-block mb-3">
                                                        <div class="verify-field">
                                                            <label class="col-form-label">Other Document
                                                            <?php
                                                                if ($other_document) {
                                                                    
                                                            ?>
                                                                <a href="<?php echo '../../uploading/' . $other_document; ?>" download class="ms-3" title="Download">
                                                                    <i class="fa fa-download fa-1x" aria-hidden="true"></i>
                                                                </a>
                                                            <?php
                                                                }
                                                            ?>
                                                            </label>
                                                            <?php if ($status == 2) { ?>
                                                            <div class="verify-toggle">
                                                                <input type="radio" name="verification_status[other_document]" id="other_document_approve" class="approve_reason" value="approved" <?php // isChecked($verificationPayload, 'other_document', 'approved'); ?> >
                                                                <label class="verify-btn approve-btn" for="other_document_approve"> Approved </label>
                                                                <input type="radio" name="verification_status[other_document]" id="other_document_reject" class="reject_reason" value="rejected" <?php // isChecked($verificationPayload, 'other_document', 'rejected'); ?>>
                                                                <label class="verify-btn reject-btn" for="other_document_reject"> Rejected </label>
                                                            </div>
                                                            <?php } ?>
                                                        </div>
                                                        <input class="form-control" type="file" name="file10" id="upload_file10">
                                                    </div>
                                                    <input type="hidden" id="img_path10" value="<?php echo $other_document;?>">
                                                    <div id="preview3" >
                                                        <div id="image_preview10">
                                                            <?php
                                                                if($other_document ==''){
                                                                    echo '<img src="../../uploading/not_uploaded.png" alt="Preview" id="img_pre10" class="imgSize">';
                                                                }else{
                                                                    echo '<img src="../../uploading/'.$other_document.'" alt="Preview" id="img_pre10" class="imgSize">';?>
                                                                    
                                                            <?php } ?>
                                                            
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-12 col-sm-12 <?php // empty($rejection_reason) ? 'd-none' : '' ?> " >
                                                    <div class="input-block mb-3">
                                                        <label class="col-form-label" for="flex_amount">Previous Rejection Reason<span class="text-danger">*</span></label>
                                                        <textarea class="form-control"  rows="4" cols="50" readonly><?php // $rejection_reason ?> </textarea>
                                                    </div>
                                                </div>
                                                <div class="col-md-12 col-sm-12 d-none" id="rejectReasonDiv">
                                                    <div class="input-block mb-3">
                                                        <label class="col-form-label" for="flex_amount">Reject Reason<span class="text-danger">*</span></label>
                                                        <textarea class="form-control" id="reject_reason" rows="4" cols="50"></textarea>
                                                    </div>
                                                </div> -->
                                            <!-- </div> -->

                                            <!-- for edit data page -->
                                            <!-- <input type="hidden" id="ref_id" name="ref_id" value="<?php echo $reference_no;?>"> CBD240001 -->
                                            <!-- <input type="hidden" id="editfor" name="editfor" value="<?php echo $editfor;?>"> registered -->
                                            <!-- <input type="hidden" id="id" name="id" value="<?php echo $id;?>"> BM250001 -->
                                            <!-- <input type="hidden" id="registered" name="registered" value="<?php echo $usertype;?>"> BM250001 -->
                                            <!-- <input type="hidden" id="testValue" name="testValue" value="<?php echo $testValue; ?>"> Business mentor -->
                                            <!-- <input type="hidden" id="applicationId" name="applicationId" value="<?php echo $application_id; ?>"> applicationId will be use to update multiple tables for CTE,ETE,STE -->

                                            <!-- <div class="submit-section d-flex  mb-4">
                                                <?php if($status == 4){ ?>
                                                <div class="col-md-4 col-sm-6">
                                                    <button class="btn btn-primary submit-btn submit-btn1 px-5 py-2" id="saveDraftEdit">Save as Draft</button>
                                                </div>
                                                <?php } ?>
                                                <div class="col-md-4 col-sm-6">    
                                                    <button class="btn btn-primary submit-btn submit-btn1 px-5 py-2" id="editChiefTechnoEnterprise">Submit</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div> -->

                    </div>
                <!-- container-fluid -->
                </div>
                <!-- End Page-content -->
                <?php 
                    if ($userType == 34) {
                        include_once(__DIR__ . '/chief_techno_footer.php');
                    }else{

                        include_once "chief_techno_footer.php"; 
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
        <script src="<?php // $base_url ?>../assets/libs/jsvectormap/js/jsvectormap.min.js"></script>
        <script src="<?php // $base_url ?>../assets/libs/jsvectormap/maps/world-merc.js"></script>

        <!--Swiper slider js-->
        <script src="<?php // $base_url ?>../assets/libs/swiper/swiper-bundle.min.js"></script>
        <?php
           // }
        ?>

        <!-- App js -->
        <script src="../assets/js/app.js"></script>
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
        <script>
            $('#payment_fee').on('change', function(){
                var payment_fee = $(this).val();
                if(payment_fee == "FOC"){
                    $("#paymentModeBlock").addClass("d-none");
                    $("#paymentFields").addClass("d-none");
                    $("#payProof").addClass("d-none");
                }else if(payment_fee == "null"){
                    $("#paymentModeBlock").addClass("d-none");
                    $("#paymentFields").addClass("d-none");
                    $("#payProof").addClass("d-none");
                }else{
                    $("#paymentModeBlock").removeClass("d-none");
                    $("#paymentFields").removeClass("d-none");
                    $("#payProof").removeClass("d-none");
                }
            });

            $('#paymentMode').on('click', function(){
                var paymentMode = $(".payment:checked").val();
                if(paymentMode == "cheque"){
                    $("#chequeOpt").removeClass("d-none");
                    $("#onlineOpt").addClass("d-none");
                }else if(paymentMode == "online"){
                    $("#onlineOpt").removeClass("d-none");
                    $("#chequeOpt").addClass("d-none");
                } else {
                    $("#chequeOpt").addClass("d-none");
                    $("#onlineOpt").addClass("d-none");
                }
            });
        </script>
        <!-- radio button background color on selected -->
        <script>
            document.querySelectorAll('.payment').forEach(radio => {
                radio.addEventListener('change', function () {

                    // Remove active class from all labels
                    document.querySelectorAll('.payment-label').forEach(label => {
                        label.classList.remove('ptMode');
                    });

                    // Add active class to selected radio's label
                    this.closest('label').classList.add('ptMode');
                });
            });
        </script>
        <script>
            document.querySelectorAll(".file-input").forEach(input => {
                input.addEventListener("change", function () {
                    const file = this.files[0];
                    if (!file) return;
                    const card = this.closest(".upload-card");
                    const title = card.dataset.title;
                    if (file.type.startsWith("image/")) {
                        const reader = new FileReader();
                        reader.onload = function (e) {
                            card.innerHTML = `
                                <input type="file" class="file-input" accept="image/*,.pdf">
                                <div class="preview-wrapper">
                                    <img src="${e.target.result}">
                                    <div class="file-title">
                                        ${title}
                                    </div>
                                </div>
                            `;
                            bindUploadEvents();
                        };
                        reader.readAsDataURL(file);
                    } else {
                        card.innerHTML = `
                            <input type="file" class="file-input" accept="image/*,.pdf">
                            <div class="pdf-preview">
                                <i class="fa-solid fa-file-pdf"></i>
                                <p class="mt-2 mb-0">${file.name}</p>
                                <div class="file-title">
                                    ${title}
                                </div>
                            </div>
                        `;
                        bindUploadEvents();
                    }
                });
            });
            function bindUploadEvents() {
                document.querySelectorAll(".file-input").forEach(input => {
                    if (input.dataset.bound) return;
                    input.dataset.bound = "true";
                    input.addEventListener("change", function () {
                        const event = new Event("change");
                        this.dispatchEvent(event);
                    });
                });
            }
        </script>
        <!-- Buttons -->
        <script>
            document.querySelector(".cancelBtn").addEventListener("click", function () {
                if(confirm("Are you sure you want to cancel?")){
                    window.history.back();
                }
            });
            document.querySelector(".draftBtn").addEventListener("click", function () {
                alert("Draft Saved Successfully");
                // AJAX call here
                // saveDraft();
            });
            document.querySelector(".submitBtn").addEventListener("click", function (e) {
                // Remove if button is inside form
                e.preventDefault();
                alert("Techno Enterprise Submitted Successfully");
                // Submit form
                // document.getElementById('yourForm').submit();
            });
        </script>
    </body>
</html>