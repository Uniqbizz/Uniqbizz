<?php
    include_once (__DIR__.'/../dashboard_user_details.php');
    $id = $_POST['id'] ?? '';
    $status = $_POST['status'] ?? '';
    $edittype = $_POST['edittype'] ?? '';
?>
<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable">
    <head>

        <meta charset="utf-8" />
        <title>Edit Executive Techno Enterprise List</title>
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
        <link rel="stylesheet" href="../assets/css/verification.css"/>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    </head>
    <body>
 
        <!-- Begin page -->
        <div id="layout-wrapper">

            <?php 
                include_once 'chief_techno_header.php'; 
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
                    include_once 'chief_techno_sidebar.php'; 
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
                                            <li class="breadcrumb-item"><a href="super_techno_enterprise_list.php">View Executive Techno Enterprise</a></li>
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
                                                        <input type="radio" name="verification_status[firstname]" id="firstname_pending" class="pending_reason" value="pending" <?php // isChecked($verificationPayload, 'firstname', 'rejected'); ?> > 
                                                        <label class="verify-btn pending-btn" for="firstname_pending"> Pending </label>
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
                                                        <input type="radio" name="verification_status[lastname]" id="lastname_pending" class="pending_reason" value="pending" <?php // isChecked($verificationPayload, 'lastname', 'rejected'); ?>>
                                                        <label class="verify-btn pending-btn" for="lastname_pending"> Pending </label>
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
                                                        <input type="radio" name="verification_status[father_spouse_name]" id="father_spouse_name_pending" class="pending_reason" value="pending" <?php // isChecked($verificationPayload, 'father_spouse_name', 'rejected'); ?>>
                                                        <label class="verify-btn pending-btn" for="father_spouse_name_pending"> Pending </label>
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
                                                        <input type="radio" name="verification_status[email]" id="email_pending" class="pending_reason" value="pending" <?php // isChecked($verificationPayload, 'email', 'rejected'); ?>>
                                                        <label class="verify-btn pending-btn" for="email_pending"> Pending </label>
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
                                                        <input type="radio" name="verification_status[dob]" id="dob_pending" class="pending_reason" value="pending" <?php // isChecked($verificationPayload, 'dob', 'rejected'); ?>>
                                                        <label class="verify-btn pending-btn" for="dob_pending"> Pending </label>
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
                                                        <input type="radio" name="verification_status[gender]" id="gender_pending" class="pending_reason" value="pending" <?php // isChecked($verificationPayload, 'gender', 'rejected'); ?>>
                                                        <label class="verify-btn pending-btn" for="gender_pending"> Pending </label>
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
                                                                <input type="radio" name="verification_status[phone]" id="phone_pending" class="pending_reason" value="pending" <?php // isChecked($verificationPayload, 'phone', 'rejected'); ?>>
                                                                <label class="verify-btn pending-btn" for="phone_pending"> Pending </label>
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
                                                            <label class="col-form-label">Alt Phone No <span class="text-danger">*</span></label>
                                                            <?php //if ($status == 2) { ?>
                                                            <div class="verify-toggle">
                                                                <input type="radio" name="verification_status[altPhone]" id="altPhone_approve" class="approve_reason" value="approved" <?php // isChecked($verificationPayload, 'altPhone', 'approved'); ?>>
                                                                <label class="verify-btn approve-btn" for="altPhone_approve"> Approved </label>
                                                                <input type="radio" name="verification_status[altPhone]" id="altPhone_reject" class="reject_reason" value="rejected" <?php // isChecked($verificationPayload, 'altPhone', 'rejected'); ?>>
                                                                <label class="verify-btn reject-btn" for="altPhone_reject"> Rejected </label>
                                                                <input type="radio" name="verification_status[altPhone]" id="altPhone_pending" class="pending_reason" value="pending" <?php // isChecked($verificationPayload, 'altPhone', 'rejected'); ?>>
                                                                <label class="verify-btn pending-btn" for="altPhone_pending"> Pending </label>
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
                                                        <input type="radio" name="verification_status[aadharNo]" id="aadharNo_pending" class="pending_reason" value="pending" <?php // isChecked($verificationPayload, 'aadharNo', 'rejected'); ?>>
                                                        <label class="verify-btn pending-btn" for="aadharNo_pending"> Pending </label>
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
                                                        <input type="radio" name="verification_status[panNo]" id="panNo_pending" class="pending_reason" value="pending" <?php // isChecked($verificationPayload, 'panNo', 'rejected'); ?>>
                                                        <label class="verify-btn pending-btn" for="panNo_pending"> Pending </label>
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
                                                    <input type="radio" name="verification_status[profile]" id="profile_pending" class="pending_reason" value="pending" <?php // isChecked($verificationPayload, 'profile', 'rejected'); ?> > 
                                                    <label class="verify-btn pending-btn" for="profile_pending"> Pending </label>
                                                </div>
                                                <?php //} ?>
                                            </div>
											<div class="upload-card" data-title="Profile Photo" data-index="1">
                                                <input type="hidden" id="img_path1" value="">
												<input type="file" class="file-input" accept="image/*,.pdf" id="upload_file1">
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
                                            <input type="radio" name="verification_status[residential]" id="residential_pending" class="pending_reason" value="pending" <?php // isChecked($verificationPayload, 'residential', 'rejected'); ?>>
                                            <label class="verify-btn pending-btn" for="residential_pending"> Pending </label>
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
                                            <input type="radio" name="verification_status[professional]" id="professional_pending" class="pending_reason" value="pending" <?php // isChecked($verificationPayload, 'professional', 'rejected'); ?>>
                                            <label class="verify-btn pending-btn" for="professional_pending"> Pending </label>
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
                                                    <input type="checkbox" class="leadership" id="lead1" name="leadership[]" value="Sales Leadership" <?php // in_array('Sales Leadership', $selectedLeadership ?? []) ? 'checked' : '' ?>>
                                                    <label for="lead1">Sales Leadership</label>
                                                </div>

                                                <div class="mb-2">
                                                    <input type="checkbox" class="leadership" id="lead2" name="leadership[]" value="Business Development" <?php // in_array('Business Development', $selectedLeadership ?? []) ? 'checked' : '' ?>>
                                                    <label for="lead2">Business Development</label>
                                                </div>

                                                <div class="mb-2">
                                                    <input type="checkbox" class="leadership" id="lead3" name="leadership[]" value="Team Management" <?php // in_array('Team Management', $selectedLeadership ?? []) ? 'checked' : '' ?>>
                                                    <label for="lead3">Team Management</label>
                                                </div>
                                                <div class="mb-2">
                                                    <input type="checkbox" class="leadership" id="lead4" name="leadership[]" value="Enterpreneurship" <?php // in_array('Enterpreneurship', $selectedLeadership ?? []) ? 'checked' : '' ?>>
                                                    <label for="lead4">Enterpreneurship</label>
                                                </div>

                                                <div class="mb-2">
                                                    <input type="checkbox" class="leadership" id="lead5" name="leadership[]" value="Corporate Leader" <?php // in_array('Corporate Leader', $selectedLeadership ?? []) ? 'checked' : '' ?>>
                                                    <label for="lead5">Corporate Leader</label>
                                                </div>

                                                <div class="mb-2">
                                                    <input type="checkbox" class="leadership" id="lead6" name="leadership[]" value="other" <?php // in_array('other', $selectedLeadership ?? []) ? 'checked' : '' ?>>
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
                                            <input type="radio" name="verification_status[education]" id="education_pending" class="pending_reason" value="pending" <?php // isChecked($verificationPayload, 'education', 'rejected'); ?>>
                                            <label class="verify-btn pending-btn" for="education_pending"> Pending </label>
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
                                            <input type="radio" name="verification_status[leadership]" id="leadership_pending" class="pending_reason" value="pending" <?php // isChecked($verificationPayload, 'leadership', 'rejected'); ?> >
                                            <label class="verify-btn pending-btn" for="leadership_pending"> Pending </label>
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
                                                        <input type="radio" name="verification_status[nominee_name]" id="nominee_name_pending" class="pending_reason" value="pending" <?php // isChecked($verificationPayload, 'educnominee_nameation', 'rejected'); ?> >
                                                        <label class="verify-btn pending-btn" for="nominee_name_pending"> Pending </label>
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
                                                        <input type="radio" name="verification_status[nominee_relation]" id="nominee_relation_pending" class="pending_reason" value="pending" <?php // isChecked($verificationPayload, 'nominee_relation', 'rejected'); ?> >
                                                        <label class="verify-btn pending-btn" for="nominee_relation_pending"> Pending </label>
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
                                                                <input type="radio" name="verification_status[nominee_phone]" id="nominee_phone_pending" class="pending_reason" value="pending" <?php // isChecked($verificationPayload, 'nominee_phone', 'rejected'); ?> >
                                                                <label class="verify-btn pending-btn" for="nominee_phone_pending"> Pending </label>
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
                                                        <input type="radio" name="verification_status[nominee_dob]" id="nominee_dob_pending" class="pending_reason" value="pending" <?php // isChecked($verificationPayload, 'nominee_dob', 'rejected'); ?> >
                                                        <label class="verify-btn pending-btn" for="nominee_dob_pending"> Pending </label>
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
                                                        <input type="radio" name="verification_status[nominee_address]" id="nominee_address_pending" class="pending_reason" value="pending" <?php // isChecked($verificationPayload, 'nominee_address', 'rejected'); ?> >
                                                        <label class="verify-btn pending-btn" for="nominee_address_pending"> Pending </label>
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
                                                    <input type="radio" name="verification_status[nominee]" id="nominee_pending" class="pending_reason" value="pending" <?php // isChecked($verificationPayload, 'nominee', 'rejected'); ?> > 
                                                    <label class="verify-btn pending-btn" for="nominee_pending"> Pending </label>
                                                </div>
                                                <?php //} ?>
                                            </div>
											<div class="upload-card" data-title="Nominee Profile Photo" data-index="13">
                                                <input type="hidden" id="img_path13" value="">
												<input type="file" class="file-input" accept="image/*,.pdf" id="upload_file13">
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
                                                <input type="radio" name="verification_status[account_holder]" id="account_holder_pending" class="pending_reason" value="pending" <?php // isChecked($verificationPayload, 'account_holder', 'rejected'); ?>>
                                                <label class="verify-btn pending-btn" for="account_holder_pending"> Pending </label>
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
                                                <input type="radio" name="verification_status[bank_name]" id="bank_name_pending" class="pending_reason" value="pending" <?php // isChecked($verificationPayload, 'bank_name', 'rejected'); ?> >
                                                <label class="verify-btn pending-btn" for="bank_name_pending"> Pending </label>
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
                                                <input type="radio" name="verification_status[account_number]" id="account_number_pending" class="pending_reason" value="pending" <?php // isChecked($verificationPayload, 'account_number', 'rejected'); ?>>
                                                <label class="verify-btn pending-btn" for="account_number_pending"> Pending </label>
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
                                                <input type="radio" name="verification_status[ifsc_code]" id="ifsc_code_pending" class="pending_reason" value="pending" <?php // isChecked($verificationPayload, 'ifsc_code', 'rejected'); ?> >
                                                <label class="verify-btn pending-btn" for="ifsc_code_pending"> Pending </label>
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
                                                <input type="radio" name="verification_status[branch_name]" id="branch_name_pending" class="pending_reason" value="pending" <?php // isChecked($verificationPayload, 'branch_name', 'rejected'); ?> >
                                                <label class="verify-btn pending-btn" for="branch_name_pending"> Pending </label>
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
                                                <input type="radio" name="verification_status[aadhar]" id="aadhar_pending" class="pending_reason" value="pending" <?php // isChecked($verificationPayload, 'aadhar', 'rejected'); ?> > 
                                                <label class="verify-btn pending-btn" for="aadhar_pending"> Pending </label>
                                            </div>
                                            <?php //} ?>
                                        </div>
										<div class="upload-card" data-title="Aadhaar Card" data-index="2">
                                            <input type="hidden" id="img_path2" value="">
											<input type="file" class="file-input" accept="image/*,.pdf" id="upload_file2">
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
                                                <input type="radio" name="verification_status[pan]" id="pan_pending" class="pending_reason" value="pending" <?php // isChecked($verificationPayload, 'pan', 'rejected'); ?> > 
                                                <label class="verify-btn pending-btn" for="pan_pending"> Pending </label>
                                            </div>
                                            <?php //} ?>
                                        </div>
										<div class="upload-card" data-title="PAN Card" data-index="3">
                                            <input type="hidden" id="img_path3" value="">
											<input type="file" class="file-input" accept="image/*,.pdf" id="upload_file3">
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
                                                <input type="radio" name="verification_status[bank]" id="bank_pending" class="pending_reason" value="pending" <?php // isChecked($verificationPayload, 'bank', 'rejected'); ?> > 
                                                <label class="verify-btn pending-btn" for="bank_pending"> Pending </label>
                                            </div>
                                            <?php //} ?>
                                        </div>
										<div class="upload-card" data-title="Bank Passbook" data-index="4">
                                            <input type="hidden" id="img_path4" value="">
											<input type="file" class="file-input" accept="image/*,.pdf" id="upload_file4">
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
                                                <input type="radio" name="verification_status[resume]" id="resume_pending" class="pending_reason" value="pending" <?php // isChecked($verificationPayload, 'resume', 'rejected'); ?> > 
                                                <label class="verify-btn pending-btn" for="resume_pending"> Pending </label>
                                            </div>
                                            <?php //} ?>
                                        </div>
										<div class="upload-card" data-title="Resume / CV" data-index="5">
                                            <input type="hidden" id="img_path5" value="">
											<input type="file" class="file-input" accept="image/*,.pdf" id="upload_file5">
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
                                                <input type="radio" name="verification_status[address]" id="address_pending" class="pending_reason" value="pending" <?php // isChecked($verificationPayload, 'address', 'rejected'); ?> > 
                                                <label class="verify-btn pending-btn" for="address_pending"> pending </label>
                                            </div>
                                            <?php //} ?>
                                        </div>
										<div class="upload-card" data-title="Address Proof" data-index="6">
                                            <input type="hidden" id="img_path6" value="">
											<input type="file" class="file-input" accept="image/*,.pdf" id="upload_file6">
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
                                                <input type="radio" name="verification_status[profile2]" id="profile2_pending" class="pending_reason" value="pending" <?php // isChecked($verificationPayload, 'profile2', 'rejected'); ?> > 
                                                <label class="verify-btn pending-btn" for="profile2_pending"> Pending </label>
                                            </div>
                                            <?php //} ?>
                                        </div>
										<div class="upload-card" data-title="Professional Profile" data-index="7">
                                            <input type="hidden" id="img_path7" value="">
											<input type="file" class="file-input" accept="image/*,.pdf" id="upload_file7">
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
                                                <input type="radio" name="verification_status[business]" id="business_pending" class="pending_reason" value="pending" <?php // isChecked($verificationPayload, 'business', 'rejected'); ?> > 
                                                <label class="verify-btn pending-btn" for="business_pending"> Pending </label>
                                            </div>
                                            <?php //} ?>
                                        </div>
										<div class="upload-card" data-title="Business Profile" data-index="8">
                                            <input type="hidden" id="img_path8" value="">
											<input type="file" class="file-input" accept="image/*,.pdf" id="upload_file8">
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
                                                <input type="radio" name="verification_status[income]" id="income_pending" class="pending_reason" value="pending" <?php // isChecked($verificationPayload, 'income', 'rejected'); ?> > 
                                                <label class="verify-btn pending-btn" for="income_pending"> Pending </label>
                                            </div>
                                            <?php //} ?>
                                        </div>
										<div class="upload-card" data-title="Income Proof" data-index="9">
                                            <input type="hidden" id="img_path9" value="">
											<input type="file" class="file-input" accept="image/*,.pdf" id="upload_file9">
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
                                                <input type="radio" name="verification_status[other]" id="other_pending" class="pending_reason" value="pending" <?php // isChecked($verificationPayload, 'other', 'rejected'); ?> > 
                                                <label class="verify-btn pending-btn" for="other_pending"> Pending </label>
                                            </div>
                                            <?php //} ?>
                                        </div>
										<div class="upload-card" data-title="Other Document" data-index="10">
                                            <input type="hidden" id="img_path10" value="">
											<input type="file" class="file-input" accept="image/*,.pdf" id="upload_file10">
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
                        <input type="hidden" id="editfor" name="editfor" value="<?= $edittype ?>">
                        <input type="hidden" id="applicationId" name="applicationId" value="<?= $id ?>">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="d-flex justify-content-end gap-4 submitBtnBackground">
                                    <button type="button" class="btn actionBtn cancelBtn mb-2">Cancel</button>
                                </div>
                            </div>
                        </div>

                    </div>
                <!-- container-fluid -->
                </div>
                <!-- End Page-content -->
                <?php 
                        include_once "chief_techno_footer.php"; 
                ?>
            </div><!-- end main content-->
        </div><!-- END layout-wrapper -->

        <!--start back-to-top-->
        <button onclick="topFunction()" class="scrollToTop scroll-btn show btn" id="back-to-top">
            <i class="ri-arrow-up-line"></i>
        </button>
        <!--end back-to-top-->
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
        <script src="js/executive_techno_enterprise.js"></script>
        <script src="../../uploading/uploadTechnoDashboard.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
    
        <!-- Buttons -->
        <script>
            document.querySelector(".cancelBtn").addEventListener("click", function () {
                if(confirm("Are you sure you want to cancel?")){
                    window.history.back();
                }
            });
        </script>
        <script>
            function bindUploadEvents() {

                document.querySelectorAll('.file-input').forEach(input => {

                    if (input.dataset.bound) return;

                    input.dataset.bound = "true";

                    input.addEventListener('change', function () {

                        const file = this.files[0];

                        if (!file) return;

                        const card = this.closest('.upload-card');
                        const title = card.dataset.title;
                        const index = card.dataset.index;

                        if (file.type.startsWith('image/')) {

                            const reader = new FileReader();

                            reader.onload = function (e) {

                                card.querySelector('.upload-content, .preview-wrapper, .pdf-preview')?.remove();

                                let preview = card.querySelector('.preview-wrapper');

                                if (!preview) {
                                    $()
                                    preview = document.createElement('div');
                                    preview.className = 'preview-wrapper';

                                    preview.innerHTML = `
                                        <img src="${e.target.result}" id="img_path${index}">
                                        <input type="hidden" id="img_path${index}" value="../../uploading/${filePath}">
                                        <div class="file-title">
                                            ${title}
                                        </div>
                                    `;

                                    card.appendChild(preview);

                                } else {

                                    preview.querySelector('img').src = e.target.result;
                                }
                            };

                            reader.readAsDataURL(file);

                        } else {

                            card.querySelector('.upload-content, .preview-wrapper, .pdf-preview')?.remove();

                            let preview = document.createElement('div');

                            preview.className = 'pdf-preview';

                            preview.innerHTML = `
                                <i class="fa-solid fa-file-pdf"></i>
                                <p class="mt-2 mb-0">${file.name}</p>
                                <div class="file-title">
                                    ${title}
                                </div>
                            `;

                            card.appendChild(preview);
                        }

                        

                    });

                });

            }
            function loadExistingFile(cardSelector, filePath)
            {
                if (!filePath) return;

                const card = document.querySelector(cardSelector);

                if (!card) return;

                const title = card.dataset.title;
                const index = card.dataset.index;
                card.querySelector(
                    '.upload-content, .preview-wrapper, .pdf-preview'
                )?.remove();

                const extension = filePath.split('.').pop().toLowerCase();

                const imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'pdf','jfif'];

                if (imageExtensions.includes(extension)) {

                    const preview = document.createElement('div');

                    preview.className = 'preview-wrapper';

                    preview.innerHTML = `
                        <img src="../../uploading/${filePath}">
                        
                        <div class="file-title">
                            ${title}
                        </div>
                    `;

                    card.appendChild(preview);
                    const status =<?= $status ?>;
                    if (status == 4) {
                        $('.file-input').prop('disabled', false);
                    }else{
                        $('.file-input').prop('disabled', true);
                    }

                } else {

                    const preview = document.createElement('div');

                    preview.className = 'pdf-preview';

                    preview.innerHTML = `
                        <i class="fa-solid fa-file-pdf"></i>
                        <p class="mt-2 mb-0">${filePath.split('/').pop()}</p>
                        <div class="file-title">
                            ${title}
                        </div>
                    `;

                    card.appendChild(preview);
                }
            }

            document.addEventListener('DOMContentLoaded', function () {
                bindUploadEvents();
                const id = '<?= $id ?>';
                const edittype = '<?= $edittype ?>';
                $.ajax({
                    url: 'models/executive_techno_enterprise/edit_te_load_data.php',
                    type: 'GET',
                    data: {
                        id: id,
                        edittype: edittype
                    },
                    dataType: 'json',
                    success: function(res)
                    {
                        if(!res.status){
                            alert(res.message);
                            return;
                        }

                        const data = res.data;
                        // Personal Information
                        $('#applicationId').val(data.application_id);
                        $('#firstname').val(data.firstname);
                        $('#lastname').val(data.lastname);
                        $('#email').val(data.email);
                        $('#phone').val(data.contact_no);
                        $('#dob').val(data.date_of_birth);
                        
                        $('#nominee_name').val(data.nominee_name);
                        $('#nominee_relation').val(data.nominee_relation);
                        $('#businessPackage').val(data.amount);

                        // Business Information
                        $('#amount').val(data.amount);
                        $('#gstNo').val(data.gst_no);

                        // Address Information
                        // Store for later use
                        window.selectedState = data.state;
                        window.selectedCity = data.city;

                        // Start chain
                        $('#country').val(data.country).trigger('change');
                        $('#pincode').val(data.pincode);
                        $('#address').val(data.address);

                        // Payment Information
                        if(data.payment_mode === 'cash'){
                            $('#cashPayment').prop('checked', true).trigger('change');
                        }

                        if(data.payment_mode === 'online'){
                            $('#onlinePayment').prop('checked', true).trigger('change');
                            $('#transactionNo').val(data.transaction_no);
                            $('#onlineOpt').removeClass('d-none');
                        }

                        if(data.payment_mode === 'cheque'){
                            $('#chequePayment').prop('checked', true).trigger('change');

                            $('#chequeNo').val(data.cheque_no);
                            $('#chequeDate').val(data.cheque_date);
                            $('#bankName').val(data.bank_name);

                            $('#chequeOpt').removeClass('d-none');
                        }

                        // Update radio button styling
                        $('.payment-label').removeClass('ptMode');
                        $('.payment:checked').closest('label').addClass('ptMode');
                        $('#note').val(data.note);
                        $('#father_spouse_name').val(data.father_spouse_name);
                        $('#aadharNo').val(data.aadhar_no);
                        $('#panNo').val(data.pan_no);
                        $('#country_cd_alt').val(data.alternative_country_code);
                        $('#altPhone').val(data.alternative_contact_no);
                        $('#occupation').val(data.current_occupation);
                        $('#experience').val(data.current_experience);
                        $('#annual_income').val(data.current_income);
                        if (data.managed_team === 'yes') {
                            $('#teamManagedYes').prop('checked', true);
                        } else if (data.managed_team === 'no') {
                            $('#teamManagedNo').prop('checked', true);
                        }
                        if (data.gender === 'male') {
                            $('#test3').prop('checked', true);
                        } else if (data.gender === 'female') {
                            $('#test4').prop('checked', true);
                        }else if (data.gender === 'others') {
                            $('#test5').prop('checked', true);
                        }
                        $('#teamSize').text(data.team_description);
                        $('.leadership').prop('checked', false);

                        if (Array.isArray(data.leadership_experience)) {

                            $('.leadership').each(function () {

                                if (data.leadership_experience.includes($(this).val())) {

                                    $(this).prop('checked', true);

                                }

                            });

                        }
                        $('#qualification').val(data.educational_qualification);
                        loadExistingFile(
                            '[data-index="1"]',
                            data.profile_pic
                        );
                        $('#career_objective').val(data.career_objective);
                        $('.teamExpected').prop('checked', false);

                        $('input[name="teamExpected"][value="' + data.team_expected + '"]')
                            .prop('checked', true);

                        $('#OperatingState').val(data.operating_region);

                        $('#nomineeName').val(data.nominee_name)
                        $('#nomineeRelation').val(data.nominee_relation)
                        $('#countryCdNominee').val(data.nominee_contact_cd)
                        $('#nomineePhone').val(data.nominee_contact_no)
                        $('#nomineeDob').val(data.nominee_date_of_birth)
                        $('#nomineeAddress').val(data.nominee_address)
                        $('#accHolderName').val(data.account_holder_name)
                        $('#bankName').val(data.bank_name)
                        $('#accountNumber').val(data.account_number)
                        $('#confirmAccountNumber').val(data.account_number)
                        $('#ifscCode').val(data.ifsc_code)
                        $('#branchName').val(data.branch_name)
                        loadExistingFile(
                            '[data-index="2"]',
                            data.aadhar_card
                        );

                        loadExistingFile(
                            '[data-index="3"]',
                            data.pan_card
                        );

                        loadExistingFile(
                            '[data-index="4"]',
                            data.cancelled_cheque_bank_passbook
                        );

                        loadExistingFile(
                            '[data-index="5"]',
                            data.resume_cv
                        );
                        loadExistingFile(
                            '[data-index="6"]',
                            data.address_proof
                        );

                        loadExistingFile(
                            '[data-index="7"]',
                            data.professional_profile
                        );

                        loadExistingFile(
                            '[data-index="8"]',
                            data.business_profile
                        );

                        loadExistingFile(
                            '[data-index="9"]',
                            data.income_proof
                        );

                        loadExistingFile(
                            '[data-index="10"]',
                            data.other_document
                        );
                        loadExistingFile(
                            '[data-index="13"]',
                            data.nominee_profile
                        );
                        // -------------------------
                        // Parse payload safely
                        // -------------------------
                        let payload = {};
                        let rejectionReason = {};

                        try {
                            if (data.payload) {
                                payload = JSON.parse(data.payload);

                                // Treat empty array/object as no payload
                                if (
                                    (Array.isArray(payload) && payload.length === 0) ||
                                    (typeof payload === "object" &&
                                        !Array.isArray(payload) &&
                                        Object.keys(payload).length === 0)
                                ) {
                                    payload = {};
                                }
                            }
                        } catch (e) {
                            payload = {};
                        }

                        try {
                            if (data.rejection_reason) {
                                rejectionReason = JSON.parse(data.rejection_reason);

                                if (
                                    (Array.isArray(rejectionReason) && rejectionReason.length === 0) ||
                                    (typeof rejectionReason === "object" &&
                                        !Array.isArray(rejectionReason) &&
                                        Object.keys(rejectionReason).length === 0)
                                ) {
                                    rejectionReason = {};
                                }
                            }
                        } catch (e) {
                            rejectionReason = {};
                        }


                        // -------------------------
                        // Set Verification Status
                        // -------------------------
                        $('.verify-toggle').each(function () {

                            const $toggle = $(this);
                            const $radios = $toggle.find('input[type="radio"]');

                            if (!$radios.length) return;

                            const field = $radios.first().attr('name').match(/\[(.*?)\]/)[1];

                            // If payload is empty or field doesn't exist, default to pending
                            const status = Object.prototype.hasOwnProperty.call(payload, field)
                                ? payload[field]
                                : 'pending';

                            const $selectedRadio = $radios.filter('[value="' + status + '"]');
                            $selectedRadio.prop('checked', true);

                            $radios.each(function () {
                                const $radio = $(this);
                                const $label = $('label[for="' + this.id + '"]');

                                if ($radio.val() !== status) {
                                    $radio.hide();
                                    $label.hide();
                                }
                            });

                            $radios.prop('disabled', true);

                            if (
                                status === 'rejected' &&
                                rejectionReason[field] &&
                                rejectionReason[field].trim() !== ''
                            ) {
                                const $label = $('label[for="' + $selectedRadio.attr('id') + '"]');

                                $label
                                    .attr('title', rejectionReason[field])
                                    .attr('data-bs-toggle', 'tooltip')
                                    .attr('data-bs-placement', 'top');

                                const existing = bootstrap.Tooltip.getInstance($label[0]);
                                if (existing) {
                                    existing.dispose();
                                }

                                new bootstrap.Tooltip($label[0]);
                            }

                        });
                    }
                });
                // Address Information
                $('#country').on('change', function () {

                    var countryID = $(this).val();

                    if (countryID) {

                        $.ajax({
                            type: 'POST',
                            url: '../address/countrydata.php',
                            data: {
                                country_id: countryID
                            },
                            success: function (html) {

                                $('#mystate').html(html);

                                if (window.selectedState) {

                                    $('#mystate')
                                        .val(window.selectedState)
                                        .trigger('change');

                                    window.selectedState = null;
                                } else {

                                    $('#city').html('<option value="">Select state first</option>');
                                }
                            }
                        });

                    } else {

                        $('#mystate').html('<option value="">Select country first</option>');
                        $('#city').html('<option value="">Select state first</option>');
                        $('#pin').val('');
                    }
                });
                    
                $('#mystate').on('change', function () {

                    var stateID = $(this).val();

                    if (stateID) {

                        $.ajax({
                            type: 'POST',
                            url: '../address/countrydata.php',
                            data: {
                                state_id: stateID
                            },
                            success: function (html) {

                                $('#city').html(html);

                                if (window.selectedCity) {

                                    $('#city')
                                        .val(window.selectedCity)
                                        .trigger('change');

                                    window.selectedCity = null;
                                }
                            }
                        });

                    } else {

                        $('#city').html('<option value="">Select state first</option>');
                        $('#pin').val('');
                    }
                });

                $('#city').on('change', function () {

                    var cityID = $(this).val();

                    if (cityID) {

                        $.ajax({
                            type: 'POST',
                            url: '../address/pincode.php',
                            data: {
                                city_id: cityID
                            },
                            success: function (response) {

                                response = $.trim(response);

                                $('#pin').val(response || '');

                            },
                            error: function () {

                                $('#pin').val('');

                            }
                        });

                    } else {

                        $('#pin').val('');

                    }
                });
            });
            $(document).on('input', '#pin', function () {
                this.value = this.value.replace(/\D/g, '');
            });
        </script>
        <!-- Buttons -->
        <script>
            $(".cancelBtn").on("click", function () {

				Swal.fire({
					title: "Are you sure?",
					text: "You will be redirected to list page.",
					icon: "warning",
					showCancelButton: true,
					confirmButtonColor: "#d63030",
					cancelButtonColor: "#1b721bf2",
					confirmButtonText: "Yes, Cancel",
					cancelButtonText: "Continue Editing",
					reverseButtons: true,
					focusCancel: true
				}).then((result) => {

					if (result.isConfirmed) {

						window.location.href = "executive_techno_enterprise_list.php";

					}

				});

			});
            $('#businessPackage').on('change', function(){
                var business_package_amount = $(this).val();
                $('#amount').val(business_package_amount);
            });
            let today = new Date();

            $(document).ready(function () {

                let today = new Date();

                // Calculate date 18 years ago
                let maxDate = new Date(
                    today.getFullYear() - 20,
                    today.getMonth(),
                    today.getDate()
                );

                // Format YYYY-MM-DD
                let formattedDate = maxDate.toISOString().split('T')[0];

                $('#dob').attr('max', formattedDate);

            });
            $('#dob').on('change', function () {

                const selectedDate = new Date(this.value);

                const maxDate = new Date();
                maxDate.setFullYear(maxDate.getFullYear() - 20);

                if (selectedDate > maxDate) {
                    alert('Age must be at least 18 years.');
                    $(this).val('');
                }

            });
        </script>
    </body>
</html>