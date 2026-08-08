<?php
    include_once (__DIR__.'/../dashboard_user_details.php');
?>
<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable">
    <head>

        <meta charset="utf-8" />
        <title>Add Executive Techno Enterprise | Customer</title>
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
        <!-- custom Css-->
        <link href="../assets/css/custom.min.css" rel="stylesheet" type="text/css" />
        <!-- App Css-->
        <link href="../assets/css/app.min.css" rel="stylesheet" type="text/css" />
        <!-- custom Css developer-->
        <link rel="stylesheet" href="../assets/css/custom.css" />
        <!-- font-awesome -->
        <link rel="stylesheet" href="../assets/fontawesome/css/all.min.css" />
        
        <!-- Customer Dashboard CSS -->
        <link rel="stylesheet" href="../assets/css/chief_techno_enterprise.css" />
        <!-- FontAwesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
		<link rel="stylesheet" href="../assets/css/validation.css" />
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
                                            <li class="breadcrumb-item"><a href="executive_techno_enterprise_list.php">View Executive Techno Enterprise</a></li>
                                            <li class="breadcrumb-item active">Add Executive Techno Enterprise</li>
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
                                            <h1 class="fw-bolder text-white">Add Executive Techno Enterprise</h1>
                                            <p class="fs-5 text-white mb-0">Fill in the details below to register a new Executive Techno Enterprise under your network.</p>
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
												<label class="col-form-label">First Name <span class="text-danger">*</span></label>
												<input class="form-control" type="text" id="firstname">
												<small class="error-message" id="firstname_error"></small>
											</div>
										</div>
										<div class="col-lg-6 col-md-6 col-sm-6 col-12">
											<div class="input-block mb-3">
												<label class="col-form-label">Last Name <span class="text-danger">*</span></label>
												<input class="form-control" type="text" id="lastname">
												<small class="error-message" id="lastname_error"></small>
											</div>
										</div>
										<div class="col-lg-6 col-md-6 col-sm-6 col-12">
											<div class="input-block mb-3">
												<label class="col-form-label">Father / Spouse Name <span class="text-danger">*</span></label>
												<input class="form-control" type="text" id="father_spouse_name">
												<small class="error-message" id="father_spouse_name_error"></small>
											</div>
										</div>
										<div class="col-lg-6 col-md-6 col-sm-6 col-12">
											<div class="input-block mb-3">
												<label class="col-form-label">Email Address<span class="text-danger">*</span></label>
												<input class="form-control" type="email" id="email">
												<small class="error-message" id="email_error"></small>
											</div>
										</div>
										<div class="col-lg-6 col-md-6 col-sm-6 col-12">
											<div class="input-block mb-3">
												<label class="col-form-label">Date of Birth <span class="text-danger">*</span></label>
												<input class="form-control" type="date" id="dob" max="<?php echo $ageLimit; ?>">
												<small class="error-message" id="dob_error"></small>
											</div>
										</div>
										<div class="col-md-6 col-sm-12">
											<div class="form-group">
												<label class="col-form-label">Gender <span class="text-danger">*</span></label>
												<div class="form-control d-flex justify-content-around gender-wrapper" id="gender_wrapper">
													<label class="radio-inline mb-0 ms-3"><input type="radio" name="gender" class="gender" id="test3" value="male">&nbsp;&nbsp;&nbsp;Male</label>
													<label class="radio-inline mb-0 ms-3"><input type="radio" name="gender" class="gender" id="test4" value="female">&nbsp;&nbsp;&nbsp;Female</label>
													<label class="radio-inline mb-0 ms-3"><input type="radio" name="gender" class="gender" id="test5" value="others">&nbsp;&nbsp;&nbsp;Other</label>
												</div>
												<small class="error-message" id="gender_error"></small>
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
															if ($stmt->rowCount() > 0) {
																foreach (($stmt->fetchAll()) as $key => $row) {
																	echo '<option value="' . $row['country_code'] . '">+' . $row['country_code'] . ' (' . $row['sortname'] . ')</option>';
																}
															} else {
																echo '<option value="">Country not available</option>';
															}
															?>
														</select>
														<small class="error-message" id="country_cd_error"></small>
													</div>
												</div>
												<div class="col-md-8 col-sm-8 col-9">
													<div class="input-block">
														<label class="col-form-label">Phone Number <span class="text-danger">*</span></label>
														<input class="form-control" type="number" id="phone" placeholder="Enter Phone Number">
														<small class="error-message" id="phone_error"></small>
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
															if ($stmt->rowCount() > 0) {
																foreach (($stmt->fetchAll()) as $key => $row) {
																	echo '<option value="' . $row['country_code'] . '">+' . $row['country_code'] . ' (' . $row['sortname'] . ')</option>';
																}
															} else {
																echo '<option value="">Country not available</option>';
															}
															?>
														</select>
														<small class="error-message" id="country_cd_alt_error"></small>
													</div>
												</div>
												<div class="col-md-8 col-sm-8 col-9">
													<div class="input-block">
														<label class="col-form-label">Alt Phone Number <span class="text-danger">*</span></label>
														<input class="form-control" type="number" id="altPhone" placeholder="Enter Alternative Phone Number">
														<small class="error-message" id="altPhone_error"></small>
													</div>
												</div>
											</div>
										</div>
										<div class="col-md-6 col-sm-6">
											<div class="input-block mb-3">
												<label class="col-form-label">Aadhar No<span class="text-danger">*</span></label>
												<input class="form-control" type="text" id="aadharNo">
												<small class="error-message" id="aadharNo_error"></small>
											</div>
										</div>
										<div class="col-md-6 col-sm-6">
											<div class="input-block mb-3">
												<label class="col-form-label">PAN No<span class="text-danger">*</span></label>
												<input class="form-control" type="text" id="panNo">
												<small class="error-message" id="panNo_error"></small>
											</div>
										</div>
									</div>
								</div>
								<div class="col-lg-3">
									<div class="row">
										<div class="col-lg-12">
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
											<option value="" selected>--Select Country--</option>
											<?php
											if ($stmt->rowCount() > 0) {
												foreach (($stmt->fetchAll()) as $key => $row) {
													echo '<option value="' . $row['id'] . '">' . $row['country_name'] . '</option>';
												}
											} else {
												echo '<option value="">Country not available</option>';
											}
											?>
										</select>
										<small class="error-message" id="country_error"></small>
									</div>
								</div>
								<div class="col-md-6 col-sm-6">
									<div class="input-block mb-3">
										<label class="col-form-label">State<span class="text-danger">*</span></label>
										<select class="form-select" id="mystate" aria-label="Floating label select example">
											<option value="">--Select country first--</option>
										</select>
										<small class="error-message" id="mystate_error"></small>
									</div>
								</div>
								<div class="col-md-6 col-sm-6">
									<div class="input-block mb-3">
										<label class="col-form-label">City<span class="text-danger">*</span></label>
										<select class="form-select" id="city" aria-label="Floating label select example">
											<option value="">--Select state first--</option>
										</select>
										<small class="error-message" id="city_error"></small>
									</div>
								</div>
								<div class="col-md-6 col-sm-6">
									<div class="input-block mb-3">
										<label class="col-form-label">Pincode<span class="text-danger">*</span></label>
										<input type="text" class="form-control" id="pin" placeholder="Pincode" readonly>
										<small class="error-message" id="pin_error"></small>
									</div>
								</div>
								<div class="col-md-12 col-sm-12">
									<div class="input-block mb-3">
										<label class="col-form-label">Address<span class="text-danger">*</span></label>
										<textarea class="form-control" type="text" id="address" rows="3" placeholder="Enter complete address"></textarea>
										<small class="error-message" id="address_error"></small>
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
                                </div>
								<div class="col-md-6 col-sm-6">
									<div class="input-block mb-3">
										<label class="col-form-label">Current Occupation / Business<span class="text-danger">*</span></label>
										<input class="form-control" type="text" id="occupation">
										<small class="error-message" id="occupation_error"></small>
									</div>
								</div>
								<div class="col-md-6 col-sm-6">
									<div class="input-block mb-3">
										<label class="col-form-label">Total Experience<span class="text-danger">*</span></label>
										<input class="form-control" type="text" id="experience">
										<small class="error-message" id="experience_error"></small>
									</div>
								</div>
								<div class="col-md-6 col-sm-6">
									<div class="input-block mb-3">
										<label class="col-form-label">Current Annual Income<span class="text-danger">*</span></label>
										<input class="form-control" type="text" id="annual_income">
										<small class="error-message" id="annual_income_error"></small>
									</div>
								</div>
								<div class="col-md-6 col-sm-12">
									<div class="form-group">
										<label class="col-form-label">Have You Managed teams Previously <span class="text-danger">*</span></label>
										<div class="form-control d-flex justify-content-around gender-wrapper" id="teamManaged_wrapper">
											<label class="radio-inline mb-0 ms-3"><input type="radio" name="teamManaged" class="teamManaged" id="teamManagedYes" value="yes">&nbsp;&nbsp;&nbsp;Yes</label>
											<label class="radio-inline mb-0 ms-3"><input type="radio" name="teamManaged" class="teamManaged" id="teamManagedNo" value="no">&nbsp;&nbsp;&nbsp;No</label>
										</div>
										<small class="error-message" id="teamManaged_error"></small>
									</div>
								</div>
								<div class="col-md-6 col-sm-6">
									<div class="input-block mb-3">
										<label class="col-form-label">If Yes, Team size<span class="text-danger">*</span></label>
										<textarea class="form-control" id="teamSize" rows="4" cols="50"> </textarea>
										<small class="error-message" id="teamSize_error"></small>
									</div>
								</div>
								<div class="col-md-6 col-sm-6">
									<div class="input-block mb-3">
										<label class="col-form-label">
											Leadership Experience <span class="text-danger">*</span>
										</label>

										<div class="row mt-2">
											<!-- Left Column -->
											<div class="col-md-6 gender-wrapper" id="leadership_wrapper">
												<div class="mb-2">
													<input type="checkbox" id="lead1" name="leadership[]" value="Sales Leadership">
													<label for="lead1">Sales Leadership</label>
												</div>

												<div class="mb-2">
													<input type="checkbox" id="lead2" name="leadership[]" value="Business Development">
													<label for="lead2">Business Development</label>
												</div>

												<div class="mb-2">
													<input type="checkbox" id="lead3" name="leadership[]" value="Team Management">
													<label for="lead3">Team Management</label>
												</div>
												<div class="mb-2">
													<input type="checkbox" id="lead4" name="leadership[]" value="Enterpreneurship">
													<label for="lead4">Enterpreneurship</label>
												</div>

												<div class="mb-2">
													<input type="checkbox" id="lead5" name="leadership[]" value="Corporate Leader">
													<label for="lead5">Corporate Leader</label>
												</div>

												<div class="mb-2">
													<input type="checkbox" id="lead6" name="leadership[]" value="other">
													<label for="lead6">Other(Please Specify)</label>
													<input type="text" name="other_leadership" id="otherLead" class="form-control mt-2" style="display:none;">
												</div>
												<input type="hidden" name="leadership_json" id="leadership_json">
											</div>
											<small class="error-message" id="leadership_error"></small>
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
                                </div>
								<div class="col-md-6 col-sm-6">
									<div class="input-block mb-3">
										<label class="col-form-label">Educational Qualification<span class="text-danger">*</span></label>
										<input class="form-control" type="text" id="qualification">
										<small class="error-message" id="qualification_error"></small>
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
                                </div>
								<div class="col-md-12 col-sm-12">
									<div class="input-block mb-3">
										<label class="col-form-label">Why You want to become a Chief Techno Enterprise?<span class="text-danger">*</span></label>
										<textarea class="form-control" id="career_objective" rows="4" cols="50"> </textarea>
										<small class="error-message" id="career_objective_error"></small>
									</div>
								</div>
								<div class="col-md-6 col-sm-12">
									<div class="input-block mb-3">
										<label class="col-form-label">
											Expected Team Building Capacity(Within 12 Months) <span class="text-danger">*</span>
										</label>
										
										<div class="row mt-2">
											<div class="col-md-6 gender-wrapper" id="teamCap_wrapper">
												<div class="mb-2">
													<input type="radio" id="expected1" name="teamExpected" class="teamExpected" value="5">
													<label for="expected1">5 Techno Enterprise</label>
												</div>

												<div class="mb-2">
													<input type="radio" id="expected2" name="teamExpected" class="teamExpected" value="10">
													<label for="expected2">10 Techno Enterprise</label>
												</div>

												<div class="mb-2">
													<input type="radio" id="expected3" name="teamExpected" class="teamExpected" value="15">
													<label for="expected3">15 Techno Enterprise</label>
												</div>
												<div class="mb-2">
													<input type="radio" id="expected4" name="teamExpected" class="teamExpected" value="25+">
													<label for="expected4">25+ Techno Enterprise</label>
												</div>
											</div>
											<small class="error-message" id="teamCap_error"></small>
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
										<small class="error-message" id="OperatingState_error"></small>
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
												<label class="col-form-label">Nominee Name<span class="text-danger">*</span></label>
												<input class="form-control" type="text" id="nomineeName">
												<small class="error-message" id="nomineeName_error"></small>
											</div>
										</div>
										<div class="col-md-6 col-sm-6">
											<div class="input-block mb-3">
												<label class="col-form-label">Nominee Relation<span class="text-danger">*</span></label>
												<input class="form-control" type="text" id="nomineeRelation">
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
														<small class="error-message" id="countryCdNominee_error"></small>
													</div>
												</div>
												<div class="col-md-8 col-sm-8 col-9">
													<div class="input-block">
														<label class="col-form-label">Nominee Phone Number <span class="text-danger">*</span></label>
														<input class="form-control" type="number" id="nomineePhone" placeholder="Enter Nominee Phone Number">
														<small class="error-message" id="nomineePhone_error"></small>
													</div>
												</div>
											</div>
										</div>
										<div class="col-md-6 col-sm-6">
											<div class="input-block mb-3">
												<label class="col-form-label">Date of Birth <span class="text-danger">*</span></label>
												<input class="form-control" type="date" id="nomineeDob" max="<?php echo $ageLimit; ?>">
												<small class="error-message" id="nomineeDob_error"></small>
											</div>
										</div>
										<div class="col-md-12 col-sm-6">
											<div class="input-block mb-3">
												<label class="col-form-label">Nominee Address<span class="text-danger">*</span></label>
												<textarea class="form-control" type="text" id="nomineeAddress" rows="3" placeholder="Enter nominee address"></textarea>
												<small class="error-message" id="nomineeAddress_error"></small>
											</div>
										</div>
									</div>
								</div>
								<div class="col-lg-3">
									<div class="row">
										<div class="col-lg-12">
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
										<label class="col-form-label">Account Holder Name<span class="text-danger">*</span></label>
										<input class="form-control" type="text" id="accHolderName">
										<small class="error-message" id="accHolderName_error"></small>
									</div>
								</div>
								<div class="col-md-6 col-sm-6">
									<div class="input-block mb-3">
										<label class="col-form-label">Bank Name<span class="text-danger">*</span></label>
										<input class="form-control" type="text" id="bankName">
										<small class="error-message" id="bankName_error"></small>
									</div>
								</div>
								<div class="col-md-6 col-sm-6">
									<div class="input-block mb-3">
										<label class="col-form-label">Account Number<span class="text-danger">*</span></label>
										<input class="form-control" type="text" id="accountNumber">
										<small class="error-message" id="accountNumber_error"></small>
									</div>
								</div>
								<div class="col-md-6 col-sm-6">
									<div class="input-block mb-3">
										<label class="col-form-label">Confirm Account Number<span class="text-danger">*</span></label>
										<input class="form-control" type="text" id="confirmAccountNumber">
										<small class="error-message" id="confirmAccountNumber_error"></small>
									</div>
								</div>
								<div class="col-md-6 col-sm-6">
									<div class="input-block mb-3">
										<label class="col-form-label">IFSC Code<span class="text-danger">*</span></label>
										<input class="form-control" type="text" id="ifscCode">
										<small class="error-message" id="ifscCode_error"></small>
									</div>
								</div>
								<div class="col-md-6 col-sm-6">
									<div class="input-block mb-3">
										<label class="col-form-label">Branch Name<span class="text-danger">*</span></label>
										<input class="form-control" type="text" id="branchName">
										<small class="error-message" id="branchName_error"></small>
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
						<div class="row">
                            <div class="col-lg-12">
                                <div class="d-flex justify-content-end gap-4 submitBtnBackground">
                                    <button type="button" class="btn actionBtn cancelBtn mb-2">Cancel</button>
                                    <button type="button" class="btn actionBtn draftBtn mb-2" id="saveDraftAdd">Save Draft</button>
                                    <button type="submit" class="btn actionBtn submitBtn mb-2" id="addExecutiveTechnoEnterprise">
                                        <i class="fa-regular fa-paper-plane me-2"></i>
                                        Submit Execitive Techno Enterprise
                                    </button>

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
        <script src="js/executive_techno_enterprise.js"></script>

        <!-- App js -->
        <script src="../assets/js/app.js"></script>
		<script src="../../uploading/uploadTechnoDashboard.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <!-- dialer logic scripts -->
        
         <script>
            
            function bindUploadEvents() {

                document.querySelectorAll('.file-input').forEach(input => {

                    if (input.dataset.bound) return;

                    input.dataset.bound = "true";

                    input.addEventListener('change', function () {

                        const file = this.files[0];

                        if (!file) return;
						clearFileError(this.id);
                        const card = this.closest('.upload-card');
                        const title = card.dataset.title;
						const index = card.dataset.index;

						const hiddenField = document.getElementById('img_path' + index);

						if (hiddenField) {
							hiddenField.value = '../../uploading/'+file.name;
						}

                        if (file.type.startsWith('image/')) {

                            const reader = new FileReader();

                            reader.onload = function (e) {

                                card.querySelector('.upload-content, .preview-wrapper, .pdf-preview')?.remove();

                                let preview = card.querySelector('.preview-wrapper');

                                if (!preview) {

                                    preview = document.createElement('div');
                                    preview.className = 'preview-wrapper';

                                    preview.innerHTML = `
                                        <img src="${e.target.result}">
                                        
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

            document.addEventListener('DOMContentLoaded', function () {
                bindUploadEvents();
            });
            $('#country').on('change', function(){
                var countryID = $(this).val();
                if(countryID){
                    $.ajax({
                        type:'POST',
                        url:'../address/countrydata.php',
                        data:'country_id='+countryID,
                        success:function(htmll){
                            $('#mystate').html(htmll); 
                            $('#city').html('<option value="">Select state first</option>'); 
                        }
                    }); 
                }else{
                    $('#mystate').html('<option value="">Select country first</option>');
                    $('#city').html('<option value="">Select state first</option>');
                    $('#pin').val('');   
                }
            });
                
            $('#mystate').on('change', function(){
                var stateID = $(this).val();
                if(stateID){
                    $.ajax({
                        type:'POST',
                        url:'../address/countrydata.php',
                        data:'state_id='+stateID,
                        success:function(html){
                            $('#city').html(html);
                        }
                    }); 
                }else{
                    $('#city').html('<option value="">Select state first</option>');
                    $('#pin').val('');   
                }
            });

            $('#city').on('change', function(){
                var cityID = $(this).val();
                if(cityID){
                    $.ajax({
                        type:'POST',
                        url:'../address/pincode.php',
                        data:'city_id='+cityID,
                        success:function(response){
                            $('#pin').val(response); 
                        }
                    }); 
                }else{
                    $('#city').html('<option value="">Select state first</option>');
                    $('#pin').val('');
                }
            });
            $(document).on('input', '#pin', function () {
                this.value = this.value.replace(/\D/g, '');
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
            // document.querySelector(".draftBtn").addEventListener("click", function () {
            //     alert("Draft Saved Successfully");
            //     // AJAX call here
            //     // saveDraft();
            // });
            // document.querySelector(".submitBtn").addEventListener("click", function (e) {
            //     // Remove if button is inside form
            //     e.preventDefault();
            //     alert("Techno Enterprise Submitted Successfully");
            //     // Submit form
            //     // document.getElementById('yourForm').submit();
            // });
        </script>
		<!-- Sidebar Start -->
        <script>
            document.addEventListener("DOMContentLoaded", function () {

                const sidebar = document.querySelector(".navbar-menu");
                const hamburger = document.getElementById("topnav-hamburger-icon");
                const hamburgerIcon = document.querySelector(".hamburger-icon");
                const overlay = document.querySelector(".vertical-overlay");

                if (window.innerWidth > 1024) {
                    sidebar.classList.remove("sidebar-hidden");
                }

                hamburger.addEventListener("click", function () {

                    if (window.innerWidth <= 1024) {

                        /* BELOW 767 - YOUR ORIGINAL WORKING LOGIC */
                        if (window.innerWidth <= 767) {

                            sidebar.classList.toggle("sidebar-mobile-show");
                            hamburgerIcon.classList.toggle("open");

                            if (overlay) {
                                overlay.classList.toggle("active");
                            }
                        }

                        /* 768px TO 1024px */
                        else {

                            if (!sidebar.classList.contains("sidebar-mobile-show")) {

                                sidebar.classList.add("sidebar-mobile-show");

                                if (overlay) {
                                    overlay.classList.add("active");
                                }

                                /* SHOW 3 LINES */
                                hamburgerIcon.classList.add("open");

                            } else {

                                sidebar.classList.remove("sidebar-mobile-show");

                                if (overlay) {
                                    overlay.classList.remove("active");
                                }

                                /* SHOW ARROW */
                                hamburgerIcon.classList.remove("open");
                            }
                        }

                    } else {

                        /* DESKTOP */
                        sidebar.classList.toggle("sidebar-hidden");
                    }
                });

                if (overlay) {

                    overlay.addEventListener("click", function () {

                        sidebar.classList.remove("sidebar-mobile-show");
                        overlay.classList.remove("active");
                        hamburgerIcon.classList.remove("open");

                    });
                }

            });
        </script>
        <!-- Sidebar End -->
    </body>
</html>