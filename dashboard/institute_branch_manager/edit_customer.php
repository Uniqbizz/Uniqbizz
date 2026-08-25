<?php
    include (__DIR__.'/urls.php');
    include_once(__DIR__ . '/../dashboard_user_details.php');

    $id = $_POST['id'];
    $editfor = $_POST['status'];
    $status = $_POST['status'];
?>

<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable">
    <head>
        <meta charset="utf-8" />
        <title> Edit Customer </title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

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
        <!-- custom Css-->
        <link href="../assets/css/custom.min.css" rel="stylesheet" type="text/css" />
        <!-- App Css-->
        <link href="../assets/css/app.min.css" rel="stylesheet" type="text/css" />
        <!-- custom Css developer-->
        <link rel="stylesheet" href="../assets/css/custom.css" />
        <link rel="stylesheet" href="../assets/fontawesome/css/all.min.css" />
        <link href="../assets/css/loadingScreen.css" rel="stylesheet" type="text/css" />
        <!-- Customer Dashboard CSS -->
        <link rel="stylesheet" href="../assets/css/travel_consultant.css" />
        <!-- FontAwesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
        <link rel="stylesheet" href="../assets/css/validation.css" />
    </head>
    <body>
        <!-- Begin page -->
        <div id="layout-wrapper">

            <?php 
                include_once(__DIR__ . '/ibr_header.php');
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
                                <lord-icon src="javascript:void(0);" trigger="loop" colors="primary:#f7b84b,secondary:#f06548" style="width:100px;height:100px"></lord-icon>
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
                include_once(__DIR__ . '/ibr_sidebar.php');
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
                                    <h4 class="mb-sm-0">Edit Customer</h4>
                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="customers_list.php">View Customer</a></li>
                                            <li class="breadcrumb-item active">Edit</li>
                                        </ol>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- edit customer form start -->
						<div class="row">
							<div class="col-lg-12">
                                <div class="card rounded-4 addTECard">
                                    <div class="d-flex gap-3">
                                        <div class="addTEIconBackground">
                                            <i class="fa-solid fa-user-group addTEIcon"></i>
                                        </div>
                                        <div class="align-content-center">
                                            <h1 class="fw-bolder text-white">Edit Customer</h1>
                                            <p class="fs-5 text-white mb-0">Fill in the details below to register a new Edit Customer under your network.</p>
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
                                <div class="col-lg-6 col-md-6 col-sm-6 referenceSection">
                                    <div class="input-block mb-3">
                                        <label class="col-form-label" for="cu_ref_id">Customer Reference Id<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="cu_ref_id" placeholder="Enter Reference ID" value="" readonly>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 referenceSection">
                                    <div class="input-block mb-3">
                                        <label class="col-form-label" for="cu_ref_name">Customer Reference Name<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="cu_ref_name" placeholder="Enter Reference Name" value="" readonly>
                                    </div>
                                </div>
                                
                                
                                <div class="col-lg-6 col-md-6 col-sm-6">
                                    <div class="input-block mb-3">
                                        <label class="col-form-label" for="user_id_name">TA Reference ID<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="user_id_name" placeholder="Enter Reference ID" value=""readonly>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6">
                                    <div class="input-block mb-3">
                                        <label class="col-form-label" for="reference_name">TA Reference Name<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="reference_name" placeholder="Enter Reference Name" value="" readonly>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6">
                                    <div class="input-block mb-3">
                                        <label class="col-form-label" for="firstname">First Name<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="firstname" placeholder="Enter your Firstname" value="">
                                        <small class="error-message" id="firstname_error"></small>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6">
                                    <div class="input-block mb-3">
                                        <label class="col-form-label" for="lastname">Last Name<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="lastname" placeholder="Enter your Lastname" value="">
                                        <small class="error-message" id="lastname_error"></small>
                                    </div>
                                </div>
                                
                                <div class="col-lg-6 col-md-6 col-sm-6">
                                    <div class="input-block mb-3">
                                        <label class="col-form-label" for="email">Email Address<span class="text-danger">*</span></label>
                                        <input type="email" class="form-control" id="email" placeholder="Enter your Email" value="">
                                        <small class="error-message" id="email_error"></small>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6">
                                    <div class="input-block mb-3">
                                        <label class="col-form-label" for="dob">Date Of Birth<span class="text-danger">*</span></label>
                                        <input type="date" class="form-control" id="dob" placeholder="Enter Date" value="">
                                        <small class="error-message" id="dob_error"></small>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label class="col-form-label">Gender <span class="text-danger">*</span></label>
                                        <div class="form-control d-flex justify-content-around mt-1gender-wrapper" id="gender_wrapper">
                                            <label class="radio-inline mb-0 ms-3"><input type="radio" id="test3" name="gender" class="gender" value="male" />&nbsp;&nbsp;&nbsp;Male</label>
                                            <label class="radio-inline mb-0 ms-3"><input type="radio" id="test4" name="gender" class="gender" value="female" />&nbsp;&nbsp;&nbsp;Female</label>
                                            <label class="radio-inline mb-0 ms-3"><input type="radio" id="test5" name="gender" class="gender" value="others" />&nbsp;&nbsp;&nbsp;Others</label>
                                        </div>
                                        <small class="error-message" id="gender_error"></small>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-2 col-sm-4 col-4">
                                    <div class="input-block mb-3">
                                        <label class="col-form-label" for="country_cd">Code</label>
                                        <select class="form-select" id="country_cd" aria-label="Floating label select example">
                                            <?php
                                            $stmt = $conn->prepare("SELECT * FROM countries WHERE status = 1 ORDER BY country_name ASC");
                                            $stmt->execute();
                                            $stmt->setFetchMode(PDO::FETCH_ASSOC);
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
                                <div class="col-lg-4 col-md-4 col-sm-8 col-8">
                                    <div class="input-block mb-3">
                                        <label class="col-form-label" for="phone">Phone Number<span class="text-danger">*</span></label>
                                        <input type="number" class="form-control" id="phone" placeholder="Enter your zipcode" value="">
                                        <small class="error-message" id="phone_error"></small>
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
                                <div class="col-lg-6 col-md-6 col-sm-6">
                                    <div class="input-block mb-3">
                                        <label class="col-form-label" for="country">Country<span class="text-danger">*</span></label>
                                        <select class="form-select" id="country" aria-label="Floating label select example">
                                            
                                            <?php
                                            $stmt = $conn->prepare("SELECT * FROM countries WHERE status = 1 ORDER BY country_name ASC");
                                            $stmt->execute();
                                            $stmt->setFetchMode(PDO::FETCH_ASSOC);
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
                                <div class="col-lg-6 col-md-6 col-sm-6">
                                    <div class="input-block mb-3">
                                        <label class="col-form-label" for="mystate">State<span class="text-danger">*</span></label>
                                        <select class="form-select" id="mystate" aria-label="Floating label select example">
                                            
                                            <option value="">--Select country first--</option>
                                        </select>
                                        <small class="error-message" id="state_error"></small>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6">
                                    <div class="input-block mb-3">
                                        <label class="col-form-label" for="city">City<span class="text-danger">*</span></label>
                                        <select class="form-select" id="city" aria-label="Floating label select example">
                                            
                                            <option value="">--Select state first--</option>
                                        </select>
                                        <small class="error-message" id="city_error"></small>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6">
                                    <div class="input-block mb-3">
                                        <label class="col-form-label" for="pin">Pincode<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="pin" placeholder="Enter your zipcode" value="">
                                        <small class="error-message" id="pin_error"></small>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="input-block mb-3">
                                        <label class="col-form-label" for="address">Address<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="address" placeholder="Enter your Address" value="">
                                        
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
                                    <h4 class="fw-bolder text-dark align-content-center">Payment Information</h4>
                                </div>
                                <div class="col-md-6 col-sm-6 col-12" id="couponFee">
                                    <div class="input-block mb-3">
                                        <label class="col-form-label" for="payment_fee">Payment Fee<span class="text-danger">*</span></label>
                                        <select class="form-select" id="payment_fee" aria-label="Floating label select example">
                                            <option value="" seleted>--Select Payment Fee--</option>
                                            <option value="FOC" >Free</option>
                                            <option value="10000" >Prime: <span>&#8377 </span>10,000/-</option>
                                            <option value="30000" >Premium: <span>&#8377 </span>30,000/-</option>
                                            <option value="35000" >Premium Plus: <span>&#8377 </span>35,000/-</option>
                                            <option value="35000" >Premium Select: <span>&#8377 </span>35,000/-</option>
                                            <option value="21000" >Premium Select Lite: <span>&#8377 </span>21,000/-</option>
                                            <option value="21000" >Neo Select: <span>&#8377 </span>11,000/-</option>
                                            <option value="21000" >Neo Select Ultra: <span>&#8377 </span>11,000/-</option>
                                            <small class="error-message" id="payment_fee_error"></small>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6" id="paymentMode">
                                    <div class="input-block mb-3">
                                        <label class="fw-bold col-form-label">Payment Mode: <span class="text-danger">*</span></label>
                                        <div class="form-control radioBtn d-flex justify-content-around payment-mode-wrapper" id="payment-mode_wrapper">
                                            <label class="mb-0" for="cashPayment"><input type="radio" id="cashPayment" class="form-check-input payment me-3" name="payment" value="cash"
                                                     disabled>
                                                    Cash
                                            </label>
                                            <label class="mb-0" for="chequePayment"><input type="radio" id="chequePayment" class="form-check-input payment me-3" name="payment" value="cheque"
                                                     disabled>
                                                    Cheque
                                            </label>
                                            <label class="mb-0" for="onlinePayment"><input type="radio" id="onlinePayment" class="form-check-input payment me-3" name="payment" value="online"
                                                     disabled>
                                                    UPI/NEFT
                                            </label>
                                        </div>
                                        <small class="error-message" id="payment-mode_error"></small>
                                    </div>
                                </div>
                                <div class="pb-3" id="payOpt">
                                    <div class="col-md-12 col-sm-12 d-none" id="chequeOpt">
                                        <div class="row d-flex justify-content-center">
                                            <div class="col-md-4">
                                                <div class="input-block">
                                                    <label class="col-form-label" for="chequeNo">Cheque No<span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" id="chequeNo" placeholder="Enter Cheque Number" value="">
                                                    <small class="error-message" id="chequeNo_error"></small>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="input-block">
                                                    <label class="col-form-label" for="chequeDate">Cheque Date<span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" id="chequeDate" placeholder="YYYY-MM-DD" maxlength="10" autocomplete="off">
                                                    <small class="error-message" id="chequeDate_error"></small>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="input-block">
                                                    <label class="col-form-label" for="bankName">Bank Name<span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" id="bankName" placeholder="Enter your Bank Name" value="">
                                                    <small class="error-message" id="bankName_error"></small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12 col-sm-12 d-none" id="onlineOpt">
                                        <div class="row d-flex justify-content-center">
                                            <div class="col-md-8">
                                                <div class="input-block">
                                                    <label class="col-form-label" for="transactionNo">Transaction No<span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" id="transactionNo" placeholder="Enter your Transaction No." value="">
                                                    <small class="error-message" id="transactionNo_error"></small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Card section 4 -->
						<div class="card rounded-4 p-3 border-1">
							<div class="">
                                <div class="d-flex gap-2">
                                    <p class="fw-bolder addTENum">04</p>
                                    <h4 class="fw-bolder text-dark align-content-center">Upload Documents</h4>
                                </div>
                                <div class="row g-3">
									<!-- Profile -->
									<div class="col-lg-4 col-md-4 col-12">
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
									<!-- Aadhaar -->
									<div class="col-lg-4 col-md-4 col-12">
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
									<div class="col-lg-4 col-md-4 col-12">
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
									<div class="col-lg-4 col-md-4 col-12">
										<div class="upload-card" data-title="Bank Passbook" data-index="4">
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
									<!-- Voting Card -->
									<div class="col-lg-4 col-md-4 col-12">
										<div class="upload-card" data-title="Voting Card" data-index="11">
											<input type="file" class="file-input" accept="image/*,.pdf" id="upload_file11">
											<div class="upload-content">
												<div class="upload-icon">
													<i class="fa-solid fa-building-columns"></i>
												</div>
												<h6>Voting Card</h6>
												<p>Click to upload<br>or drag and drop</p>
												<small>(JPG, PNG, PDF)</small>
											</div>
										</div>
									</div>
									<!-- Payment Proof -->
									<div class="col-lg-4 col-md-4 col-12" id="payProof">
										<div class="upload-card" data-title="Payment Proof" data-index="12">
											<input type="file" class="file-input" accept="image/*,.pdf" id="upload_file12">
											<div class="upload-content">
												<div class="upload-icon">
													<i class="fa-solid fa-building-columns"></i>
												</div>
												<h6>Payment Proof</h6>
												<p>Click to upload<br>or drag and drop</p>
												<small>(JPG, PNG, PDF)</small>
											</div>
										</div>
									</div>
                                </div>
                                <!-- for edit data page -->
                                <input type="hidden" id="editfor" name="editfor" value="<?php echo $editfor; ?>">
                                <input type="hidden" id="id" name="id" value="<?php echo $id; ?>">
                                <input type="hidden" id="registrant_id" name="registrant_id" value="<?php echo $userId; ?>">
                                <input type="hidden" id="register_by" name="register_by" value="<?php echo $userType; ?>"> <!-- User type for table col register_by -->

                                <!-- new added 14-06-2025 -->
                                <input type="hidden" id="userType" name="userType" value="<?php echo $userType; ?>"> <!-- 24,25,26 -->
                                <input type="hidden" id="userId" name="userId" value="<?php echo $userId; ?>"> <!-- BH250001, BM250001 -->
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="d-flex justify-content-end gap-4 submitBtnBackground">
                                    <button type="button" class="btn actionBtn cancelBtn mb-2">Cancel</button>
                                    <?php
                                        if ($status == 4) {
                                    ?>
                                    <button type="button" class="btn actionBtn draftBtn mb-2" id="saveDraftEdit">Save Draft</button>
                                    <button type="submit" class="btn actionBtn submitBtn mb-2" id="editCustomer">
                                        <i class="fa-regular fa-paper-plane me-2"></i>
                                        Submit Customer 
                                    </button>
                                    <?php
                                        }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div> <!-- container-fluid -->
                </div><!-- End Page-content -->
                <?php 
                    include_once(__DIR__ . '/ibr_footer.php');
                ?>
            </div><!-- end main content-->
        </div><!-- END layout-wrapper -->

        <!--start back-to-top-->
        <button onclick="topFunction()" class="scrollToTop scroll-btn show btn" id="back-to-top">
            <i class="ri-arrow-up-line"></i>
        </button>
        <!--end back-to-top-->
        <?php include (__DIR__ .'/../contact_modal.php') ?>
        <!-- JAVASCRIPT -->
        <script src="../assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="../assets/libs/simplebar/simplebar.min.js"></script>
        <script src="../assets/libs/node-waves/waves.min.js"></script>
        <script src="../assets/libs/feather-icons/feather.min.js"></script>
        <!-- jquery -->
        <script src="../assets/js/jquery/jquery-3.7.1.min.js"></script>

        <!-- !-- materialdesign icon js- -->
        <script src="../assets/js/pages/remix-icons-listing.js"></script>
        
        <!-- Vector map-->
        <script src="../assets/libs/jsvectormap/js/jsvectormap.min.js"></script>
        <script src="../assets/libs/jsvectormap/maps/world-merc.js"></script>

        <!--Swiper slider js-->
        <script src="../assets/libs/swiper/swiper-bundle.min.js"></script>
        

        <!-- apexcharts -->
        <script src="../assets/libs/apexcharts/apexcharts.min.js"></script>

        <!-- Vector map-->
        <script src="../assets/libs/jsvectormap/js/jsvectormap.min.js"></script>
        <script src="../assets/libs/jsvectormap/maps/world-merc.js"></script>

        <!--Swiper slider js-->
        <script src="../assets/libs/swiper/swiper-bundle.min.js"></script>

        <!-- App js -->
        <script src="../assets/js/app.js"></script>

        <script src="../../uploading/uploadTechnoDashboard.js"></script>
        <script>
            const id='<?= $id ?>';
            const status='<?= $status ?>';
        </script>
        <!-- end dialer logic scripts -->
        <script src="js/customer.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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