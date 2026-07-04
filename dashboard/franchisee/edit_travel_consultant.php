<?php
    include_once (__DIR__.'/../dashboard_user_details.php');
    $id = $_POST['id'] ?? '';
    $status = $_POST['status'] ?? '';
    $edittype = 11;
?>
<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable">
    <head>

        <meta charset="utf-8" />
        <title>Edit Travel Consultant | Dashboard</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
        <!-- Customer Dashboard CSS -->
        <link rel="stylesheet" href="../assets/css/franchisee.css" />
        <link rel="stylesheet" href="../assets/fontawesome/css/all.min.css" />
        <link href="../assets/css/loadingScreen.css" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
        <!-- FontAwesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        
    </head>

    <body>
 
        <!-- Begin page -->
        <div id="layout-wrapper">

            <?php include_once 'franchisee_header.php'; ?>

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

            <?php include_once 'franchisee_sidebar.php'; ?>

            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->
            <div class="main-content">

                <div id="testpho"></div>
                <div id="testemails"></div>

                <div class="page-content">
                    <div class="container-fluid">
                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                    <h4 class="mb-sm-0">Edit Travel Consultant </h4>
                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="travel_consultants_list.php">Travel Consultant</a></li>
                                            <li class="breadcrumb-item active">Edit Travel Consultant</li>
                                        </ol>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end page title -->
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card rounded-4 addTECard">
                                    <div class="d-flex gap-3">
                                        <div class="addTEIconBackground">
                                            <i class="fa-solid fa-user-group addTEIcon"></i>
                                        </div>
                                        <div class="align-content-center">
                                            <h1 class="fw-bolder text-white">Edit Travel Consultant </h1>
                                            <p class="fs-5 text-white mb-0">Fill in the details below to register a new Travel Consultant under your network.</p>
                                        </div>
                                    </div>
                                    <img src="../assets/images/addTechnoFileImage.png" alt="" class="addTEImage">
                                </div>
                            </div>
                        </div>
                        <!-- Card Section 1 -->
                        <div class="card rounded-4 p-3 border-1">
                            <div class="row">
                                <div class="d-flex gap-2">
                                    <p class="fw-bolder addTENum">01</p>
                                    <h4 class="fw-bolder text-dark align-content-center">Personal Information</h4>
                                </div>

                                <div class="col-lg-6 col-md-6 col-sm-6">
                                    <div class="input-block mb-3">
                                        <label class="col-form-label" for="user_id_name">User Id & Name<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="user_id_name" placeholder="Enter Reference ID" value="<?php echo $userId; ?>" readonly>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6">
                                    <div class="input-block mb-3">
                                        <label class="col-form-label" for="reference_name">Reference Name<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="reference_name" placeholder="Enter Reference Name" value="<?php echo $userFname.' '.$userLname; ?>" readonly>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6">
                                    <div class="input-block mb-3">
                                        <label class="col-form-label" for="firstname">First Name<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="firstname" placeholder="Enter your firstname">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6">
                                    <div class="input-block mb-3">
                                        <label class="col-form-label" for="lastname">Last Name<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="lastname" placeholder="Enter your Lastname">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6">
                                    <div class="input-block mb-3">
                                        <label class="col-form-label" for="nominee_name">Nominee Name<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="nominee_name" placeholder="Enter Nominee Name">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6">
                                    <div class="input-block mb-3">
                                        <label class="col-form-label" for="nominee_relation">Nominee Relation<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="nominee_relation" placeholder="Enter Nominee Relation">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6">
                                    <div class="input-block mb-3">
                                        <label class="col-form-label" for="email">Email Address<span class="text-danger">*</span></label>
                                        <input type="email" class="form-control" id="email" placeholder="Enter Email Address">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6">
                                    <div class="input-block mb-3">
                                        <label class="col-form-label" for="dob">Date Of Birth<span class="text-danger">*</span></label>
                                        <input type="date" class="form-control" id="dob" placeholder="Enter Date Of Birth" max="<?= $ageLimit ?>">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group mb-3">
                                        <label class="col-form-label d-block">Gender:<span class="text-danger">*</span></label>
                                        <div class="form-control d-flex justify-content-around">
                                            <label class="radio-inline mb-0 ms-3" for="test3"><input type="radio" id="test3" class="form-check-input gender me-3" name="gender" value="male">Male</label>
                                            <label class="radio-inline mb-0 ms-3" for="test4"><input type="radio" id="test4" class="form-check-input gender me-3" name="gender" value="female">Female</label>
                                            <label class="radio-inline mb-0 ms-3" for="test5"><input type="radio" id="test5" class="form-check-input gender me-3" name="gender" value="others">Others</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12 mb-3">
                                    <div class="row">
                                        <div class="col-md-4 col-sm-4 col-3">
                                            <div class="input-block">
                                                <?php
                                                    $stmt = $conn->prepare("SELECT * FROM countries WHERE status = 1 ORDER BY country_name ASC");
                                                    $stmt->execute();                                            
                                                    $stmt->setFetchMode(PDO::FETCH_ASSOC);
                                                ?>
                                                <label class="col-form-label" for="country_cd">Code</label>
                                                <select class="form-select" id="country_cd">
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
                                                <label class="col-form-label" for="phone">Phone Number<span class="text-danger">*</span></label>
                                                <input type="number" class="form-control" id="phone" placeholder="Enter your Phone Number">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Card Section 2 -->
                        <div class="card rounded-4 p-3 border-1">
                            <div class="row">
                                <div class="d-flex gap-2">
                                    <p class="fw-bolder addTENum">02</p>
                                    <h4 class="fw-bolder text-dark align-content-center">Address Information</h4>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6">
                                    <div class="input-block mb-3">
                                        <?php
                                            $stmt = $conn->prepare("SELECT * FROM countries WHERE status = 1 ORDER BY country_name ASC");
                                            $stmt->execute();                                         
                                            $stmt->setFetchMode(PDO::FETCH_ASSOC);
                                        ?>
                                        <label class="col-form-label" for="country">Country<span class="text-danger">*</span></label>
                                        <select class="form-select" id="country" aria-label="Floating label select example">
                                            <option value="" selected>--Select Country--</option>
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
                                <div class="col-lg-6 col-md-6 col-sm-6">
                                    <div class="input-block mb-3">
                                        <label class="col-form-label" for="mystate">State<span class="text-danger">*</span></label>
                                        <select class="form-select" id="mystate" aria-label="Floating label select example">
                                            <option value="">--Select country first--</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6">
                                    <div class="input-block mb-3">
                                        <label class="col-form-label" for="city">City<span class="text-danger">*</span></label>
                                        <select class="form-select" id="city" aria-label="Floating label select example">
                                            <option value="">--Select state first--</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6">
                                    <div class="input-block mb-3">
                                        <label class="col-form-label" for="pin">Pincode<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="pin" placeholder="Enter your pincode">
                                    </div>
                                </div>
                                <?php if ($userType == 32){ ?>
                                <div class="col-md-6 col-sm-6">
                                    <div class="input-block mb-3">
                                        <label class="col-form-label">Branch <span class="text-danger">*</span></label>
                                        <select class="form-select" id="branch">
                                            <option value=""> ---- Select Branch ---- </option>
                                            <?php
                                                require '../connect.php';
                                                $sql = "SELECT * FROM `branch` WHERE status ='1' ";
                                                $stmt = $conn->prepare($sql);
                                                $stmt->execute();
                                                $stmt->setFetchMode(PDO::FETCH_ASSOC);
                                                if ($stmt->rowCount() > 0) {
                                                    foreach (($stmt->fetchAll()) as $key => $row) {
                                                        echo '<option value="' . $row['id'] . '">' . $row['branch_name'] . '</option>';
                                                    }
                                                } else {
                                                    echo '<option value="">Branch not available</option>';
                                                }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <?php } ?>
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <div class="input-block mb-3">
                                        <label class="col-form-label" for="address">Address<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="address" placeholder="Enter your Address">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Card Section 3 -->
                        <div class="card rounded-4 p-3 border-1">
                            <div class="row">
                                <div class="d-flex gap-2">
                                    <p class="fw-bolder addTENum">03</p>
                                    <h4 class="fw-bolder text-dark align-content-center">Payment Information</h4>
                                </div>
                                <div class="col-md-6 col-sm-6">
                                    <div class="input-block mb-3">
                                        <label class="col-form-label" for="payment_fee">Payment Fee<span class="text-danger">*</span></label>
                                        <select class="form-select" id="payment_fee">
                                            <option value="null" >--Select Payment Fee--</option>
                                            <option value="FOC" selected>Free</option>
                                            <option value="3000"><span>&#8377 </span>3000/-</option> 
                                            <option value="10000"><span>&#8377 </span>10,000/-</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6 d-none" id="paymentModeBlock">
                                    <div class="input-block mb-3">
                                        <label class="fw-bold col-form-label">Payment Mode: <span class="text-danger">*</span></label>
                                        <div class="form-control radioBtn d-flex justify-content-around" id="paymentMode">
                                            <label class="mb-0" for="cashPayment"><input type="radio" id="cashPayment" class="form-check-input payment me-3" name="payment" value="cash">Cash</label>
                                            <label class="mb-0" for="chequePayment"><input type="radio" id="chequePayment"  class="form-check-input payment me-3" name="payment" value="cheque">Cheque</label>
                                            <label class="mb-0" for="onlinePayment"><input type="radio" id="onlinePayment"  class="form-check-input payment me-3" name="payment" value="online">UPI/NEFT</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="pb-3 d-none" id="paymentFields">
                                    <div class="col-md-12 col-sm-12 d-none" id="chequeOpt">
                                        <div class="row d-flex justify-content-center">
                                            <div class="col-md-4 py-1">
                                                <div class="input-block">
                                                    <label class="col-form-label" for="chequeNo">Cheque No<span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" id="chequeNo" placeholder="Enter Cheque Number">
                                                </div>
                                            </div>
                                            <div class="col-md-4 py-1">
                                                <div class="input-block">
                                                    <label class="col-form-label" for="chequeDate">Cheque Date<span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" id="chequeDate" placeholder="Enter Date On Cheque">
                                                </div>
                                            </div>
                                            <div class="col-md-4 py-1">
                                                <div class="input-block">
                                                    <label class="col-form-label" for="bankName">Bank Name<span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" id="bankName" placeholder="Enter your Bank Name">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-sm-12 d-none" id="onlineOpt">
                                        <div class="row d-flex justify-content-center">
                                            <div class="col-md-8">
                                                <div class="input-block">
                                                    <label class="col-form-label" for="transactionNo">Transaction No.<span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" id="transactionNo" placeholder="Enter your Transaction No.">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div> 
                            </div>
                        </div>
                        <!-- Card Section 4 -->
                        <div class="card rounded-4 p-3 border-1">
                            <div class="">
                                <div class="d-flex gap-2">
                                    <p class="fw-bolder addTENum">04</p>
                                    <h4 class="fw-bolder text-dark align-content-center">Payment Information</h4>
                                </div>
                                <div class="row g-3">
                                    <!-- Profile -->
                                    <div class="col-lg-4 col-md-4 col-sm-6 col-12">
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
									<div class="col-lg-4 col-md-4 col-sm-6 col-12">
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
									<div class="col-lg-4 col-md-4 col-sm-6 col-12">
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
									<div class="col-lg-4 col-md-4 col-sm-6 col-12">
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
									<div class="col-lg-4 col-md-4 col-sm-6 col-12">
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
									<div class="col-lg-4 col-md-4 col-sm-6 col-12 d-none" id="payProof">
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
                                    <input type="hidden" id="testValue" name="testValue" value="10"> <!-- customer -->
                                    <input type="hidden" id="register_by" name="register_by" value="<?php echo $userType; ?>"> <!-- User type for table col register_by -->
                                    <input type="hidden" id="registrant_id" name="registrant_id" value="<?php echo $userId; ?>">
                                    <input type="hidden" id="editfor" name="editfor" value="<?php echo $editfor; ?>">
                                    
                                    <!-- new added 14-06-2025 -->
                                    <input type="hidden" id="userType" name="userType" value="<?php echo $userType; ?>"> <!-- 24,25,26 -->
                                    <input type="hidden" id="userId" name="userId" value="<?php echo $userId; ?>"> <!-- BH250001, BM250001 -->
                                    <input type="hidden" id="id" name="id" value="<?php echo $id; ?>"> <!-- BH250001, BM250001 -->
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="d-flex justify-content-end gap-4 submitBtnBackground">
                                    <button type="button" class="btn actionBtn cancelBtn mb-2">Cancel</button>
                                    <?php if($status==4){ ?>
                                    <button type="button" class="btn actionBtn draftBtn mb-2" id="saveDraftedit">Save Draft</button>
                                    <button type="submit" class="btn actionBtn submitBtn mb-2" id="editTravelConsultant">
                                        <i class="fa-regular fa-paper-plane me-2"></i>
                                        Submit Travel Consultant
                                    </button>
                                    <?php } ?>

                                </div>
                            </div>
                        </div>
                    </div> <!-- container-fluid -->
                </div><!-- End Page-content -->
                <?php include_once 'franchisee_footer.php' ?>   
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

        <!-- !-- materialdesign icon js- -->
        <script src="../assets/js/pages/remix-icons-listing.js"></script>

        <!-- apexcharts -->
        <script src="../assets/libs/apexcharts/apexcharts.min.js"></script>

        <!-- Vector map-->
        <script src="../assets/libs/jsvectormap/js/jsvectormap.min.js"></script>
        <script src="../assets/libs/jsvectormap/maps/world-merc.js"></script>

        <!--Swiper slider js-->
        <script src="../assets/libs/swiper/swiper-bundle.min.js"></script>

        <!-- App js -->
        <script src="../assets/js/app.js"></script>
        <script src="js/travel_consultant.js"></script>
        <script src="../../uploading/uploadTechnoDashboard.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <script>

            var register_type = $("#userType").val();
            // console.log(register_type);
            if (register_type === '16' || register_type === '30') {
                // Enable payment fee
                $('#payment_fee').prop('disabled',false);
                $('#branch').prop('disabled', true);
            } else if (register_type === '32') {
                // Disable payment fee
                $('#payment_fee').prop('disabled',true);
                $('#branch').prop('disabled', false);
            }
            
            

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

                const imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

                if (imageExtensions.includes(extension)) {

                    const preview = document.createElement('div');

                    preview.className = 'preview-wrapper';

                    preview.innerHTML = `
                        <img src="../../uploading/${filePath}">
                        <input type="hidden" id="img_path${index}" value="../../uploading/${filePath}">
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

            function ajaxPromise(options) {
                return new Promise(function (resolve, reject) {
                    $.ajax({
                        ...options,
                        success: resolve,
                        error: reject
                    });
                });
            }
            async function loadStates(countryID, selectedState = "") {

                if (!countryID) {
                    $("#mystate").html('<option value="">Select country first</option>');
                    $("#city").html('<option value="">Select state first</option>');
                    return;
                }

                try {

                    const html = await ajaxPromise({
                        type: "POST",
                        url: "../address/countrydata.php",
                        data: {
                            country_id: countryID
                        }
                    });

                    $("#mystate").html(html);

                    if (selectedState) {
                        $("#mystate").val(selectedState);
                    }

                } catch (e) {
                    console.error(e);
                }

            }
            async function loadCities(stateID, selectedCity = "") {

                if (!stateID) {
                    $("#city").html('<option value="">Select state first</option>');
                    return;
                }

                try {

                    const html = await ajaxPromise({
                        type: "POST",
                        url: "../address/countrydata.php",
                        data: {
                            state_id: stateID
                        }
                    });

                    $("#city").html(html);

                    if (selectedCity) {
                        $("#city").val(selectedCity);
                    }

                } catch (e) {
                    console.error(e);
                }

            }
            async function loadPincode(cityID) {

                if (!cityID) {
                    $("#pin").val("");
                    return;
                }

                try {

                    const pin = await ajaxPromise({
                        type: "POST",
                        url: "../address/pincode.php",
                        data: {
                            city_id: cityID
                        }
                    });

                    $("#pin").val($.trim(pin));

                } catch (e) {
                    console.error(e);
                }

            }
            $("#country").on("change", async function () {

                await loadStates($(this).val());

                $("#city").html('<option value="">Select state first</option>');
                $("#pin").val("");

            });

            $("#mystate").on("change", async function () {

                await loadCities($(this).val());

                $("#pin").val("");

            });

            $("#city").on("change", async function () {

                await loadPincode($(this).val());

            });
            async function loadTravelConsultant() {
                const id = '<?= $id ?>';
                const edittype = '<?= $edittype ?>';
                const res = await ajaxPromise({
                    url: "models/travel_consultant/edit_tc_load_data.php",
                    type: "GET",
                    data: {
                        id: id,
                        edittype: edittype
                    },
                    dataType: "json"
                });

                if (!res.status) {
                    alert(res.message);
                    return;
                }

                const data = res.data;

                $("#firstname").val(data.firstname);
                $("#lastname").val(data.lastname);

                $('#nominee_name').val(data.nominee_name);
                $('#nominee_relation').val(data.nominee_relation);
                $('#email').val(data.email);
                $('#phone').val(data.contact_no);
                $('#dob').val(data.date_of_birth);
                $(`input[name="gender"][value="${data.gender}"]`).prop("checked", true);
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

                $("#country").val(data.country);

                await loadStates(data.country, data.state);

                await loadCities(data.state, data.city);

                await loadPincode(data.city);
                bindUploadEvents();
                
                loadExistingFile(
                    '[data-index="1"]',
                    data.profile_pic
                );

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
                    data.bank_passbook
                );

                loadExistingFile(
                    '[data-index="11"]',
                    data.voting_card
                );

                loadExistingFile(
                    '[data-index="12"]',
                    data.payment_proof
                );

            }
            loadTravelConsultant()
      
            $(document).on('input', '#pin', function () {
                this.value = this.value.replace(/\D/g, '');
            });
            document.querySelector(".cancelBtn").addEventListener("click", function () {
                if(confirm("Are you sure you want to cancel?")){
                    location.href = "travel_consultants_list.php";
                }
            });
        </script>
    </body>
</html>