<?php
    include_once (__DIR__.'/../dashboard_user_details.php');
?>
<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable">
    <head>

        <meta charset="utf-8" />
        <title>Add Business Mentor | Customer</title>
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
        <link rel="stylesheet" href="../assets/css/business_development_manager.css" />
        <!-- FontAwesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
        <link rel="stylesheet" href="../assets/css/validation.css" />
    </head>
    <body>
 
        <!-- Begin page -->
        <div id="layout-wrapper">
			<div id="testpho"></div>
            <div id="testemails"></div>
            <?php 
                    include_once 'business_development_manager_header.php'; 
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
                    include_once 'business_development_manager_sidebar.php'; 
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
                                    <h4 class="mb-sm-0">Business Mentor</h4>
                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="business_mentor_list.php">View Business Mentor</a></li>
                                            <li class="breadcrumb-item active">Add Business Mentor</li>
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
                                            <h1 class="fw-bolder text-white">Add Business Mentor</h1>
                                            <p class="fs-5 text-white mb-0">Fill in the details below to register a new Business Mentor under your network.</p>
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
												<label class="col-form-label">Nominee Name <span class="text-danger">*</span></label>
												<input class="form-control" type="text" id="nominee_name">
                                                <small class="error-message" id="nominee_name_error"></small>
                                            </div>
										</div>
										<div class="col-lg-6 col-md-6 col-sm-6 col-12">
											<div class="input-block mb-3">
												<label class="col-form-label">Nominee Relation <span class="text-danger">*</span></label>
												<input class="form-control" type="text" id="nominee_relation">
                                                <small class="error-message" id="nominee_relation_error"></small>
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
									</div>
								</div>
								<div class="col-lg-3">
									<div class="row">
										<div class="col-lg-12">
											<div class="upload-card" data-title="Profile Photo" data-index="1">
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
                                    <h4 class="fw-bolder text-dark align-content-center">Business Information</h4>
                                </div>
								<div class="col-md-6 col-sm-6">
									<div class="input-block mb-3">
										<label class="col-form-label">Zone <span class="text-danger">*</span></label>
										<select class="form-select" id="zone">
											<option value=""> ---- Select Zone ---- </option>
											<?php
											$sql = "SELECT * FROM `zone` WHERE status ='1' ";
											$stmt = $conn->prepare($sql);
											$stmt->execute();
											$stmt->setFetchMode(PDO::FETCH_ASSOC);
											if ($stmt->rowCount() > 0) {
												foreach (($stmt->fetchAll()) as $key => $row) {
													echo '
																<option value="' . $row['id'] . '">' . $row['zone_name'] . '</option>
															';
												}
											} else {
												echo '<option value="">Department not available</option>';
											}
											?>
										</select>
                                        <small class="error-message" id="payment_fee_error"></small>
									</div>
								</div>
								<div class="col-md-6 col-sm-6">
									<div class="input-block mb-3">
										<label class="col-form-label">Branch <span class="text-danger">*</span></label>
										<select class="form-select" id="branch">
											<option value=""> ---- Select Zone First ---- </option>
										</select>
                                        <small class="error-message" id="branch_error"></small>
									</div>
								</div>
							</div>
						</div>
						
						<!-- Card section 4 -->
						<div class="card rounded-4 p-3 border-1">
                            <div class="d-flex gap-2">
                                <p class="fw-bolder addTENum">04</p>
                                <h4 class="fw-bolder text-dark align-content-center">Upload Documents</h4>
                            </div>
                            <div class="row g-3">

                                <!-- Aadhaar -->
                                <div class="col-lg-3 col-md-4 col-6">
                                    <div class="upload-card" data-title="Aadhaar Card" data-index="2">
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
                                <div class="col-lg-3 col-md-4 col-6">
                                    <div class="upload-card" data-title="PAN Card" data-index="3">
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
                                <div class="col-lg-3 col-md-4 col-6">
                                    <div class="upload-card" data-title="Bank Passbook" data-index="4">
                                        <input type="file" class="file-input" accept="image/*,.pdf" id="upload_file4">
                                        <div class="upload-content">
                                            <div class="upload-icon">
                                                <i class="fa-solid fa-building-columns"></i>
                                            </div>
                                            <h6>Bank Passbook</h6>
                                            <p>Click to upload<br>or drag and drop</p>
                                            <small>(JPG, PNG, PDF)</small>
                                        </div>
                                    </div>
                                </div>

                                <!-- Voting -->
                                <div class="col-lg-3 col-md-4 col-6">
                                    <div class="upload-card" data-title="Voting Card" data-index="11">
                                        <input type="file" class="file-input" accept="image/*,.pdf" id="upload_file11">
                                        <div class="upload-content">
                                            <div class="upload-icon">
                                                <i class="fa-regular fa-address-card"></i>
                                            </div>
                                            <h6>Voting Card</h6>
                                            <p>Click to upload<br>or drag and drop</p>
                                            <small>(JPG, PNG, PDF)</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
						<div class="row">
                            <div class="col-lg-12">
								<input type="hidden" id="testValue" name="testValue" value="26"> <!-- Business mentor -->
								<!-- new added 14-06-2025 -->
								<input type="hidden" id="userType" name="userType" value="<?php echo $userType; ?>"> <!-- 24,25,26 -->
								<input type="hidden" id="userId" name="userId" value="<?php echo $userId; ?>"> 
                                <div class="d-flex justify-content-end gap-4 submitBtnBackground">
                                    <button type="button" class="btn actionBtn cancelBtn mb-2">Cancel</button>
                                    <button type="button" class="btn actionBtn draftBtn mb-2" id="saveDraftAdd">Save Draft</button>
                                    <button type="submit" class="btn actionBtn submitBtn mb-2" id="addBusinessMentor">
                                        <i class="fa-regular fa-paper-plane me-2"></i>
                                        Submit Business Mentor
                                    </button>

                                </div>
                            </div>
                        </div>
					</div>
					<!-- container-fluid -->
				</div>
				<!-- End Page-content -->
                <?php 
                        include_once "business_development_manager_footer.php"; 
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
        <script src="js/business_mentor.js"></script>

        <!-- App js -->
        <script src="../assets/js/app.js"></script>
		<script src="../../uploading/uploadTechnoDashboard.js"></script>
        <!-- dialer logic scripts -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
         <script>
			 // on zone change get branch associated with that zone
			$('#zone').on('change', function() {
				var zone_id = $(this).val();
				$.ajax({
					url: '../assets/get_data/get_branch.php',
					type: 'POST',
					data: {
						zone_id: zone_id
					},
					success: function(data) {
						$('#branch').html(data);
					}
				});
			});
            
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
                                        <input type="hidden" id="img_path${index}" value="${e.target.result}">
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
								<input type="hidden" id="img_path${index}" value="../../uploading/${file.name}">
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
                    alert('Age must be at least 20 years.');
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

						window.location.href = "business_mentor_list.php";

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
    </body>
</html>