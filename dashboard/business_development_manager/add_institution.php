<?php
    include_once (__DIR__.'/../dashboard_user_details.php');
?>
<?php
    //current full date
    $today = date('Y-m-d');

    //current year
    $date = date('Y'); 

    // Calculate 20 years before the current date
    $dateTwentyYearsAgo = strtotime("-20 years");

    // Format the result as a human-readable date
    $ageLimit = date("Y-m-d", $dateTwentyYearsAgo);  // Outputs the date 20 years before today
?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Add Institution | Admin Dashboard </title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- App favicon -->
        <link rel="shortcut icon" href="../assets/images/fav.png">

        <!-- Bootstrap Css -->
        <link href="../assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
        <!-- Icons Css -->
        <link href="../assets/css/icons.min.css" rel="stylesheet" type="text/css" />
        <!-- App Css-->
        <link href="../assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />
        <!-- Loading Screen and Images size css  -->
        <link href="../assets/css/loadingScreen.css" rel="stylesheet" type="text/css" />
        <!-- custom Css-->
        <link href="../assets/css/custom.min.css" rel="stylesheet" type="text/css" />
        <!-- custom Css developer-->
        <link rel="stylesheet" href="../assets/css/custom.css" />
        <!-- Form CSS -->
        <link href="../assets/css/form.css" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" href="../assets/css/business_development_manager.css" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
        <link rel="stylesheet" href="../assets/css/validation.css" />
    </head>
    <body data-sidebar="dark">
        <div id="testpho"></div>
        <div id="testemails"></div>
        <!-- <body data-layout="horizontal" data-topbar="dark"> -->
        <!-- Begin page -->
        <div id="layout-wrapper">
            <?php 
                // top header logo, hamberger menu, fullscreen icon, profile
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
            <?php
                // sidebar navigation menu 
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
                                    <h4 class="mb-sm-0">Add Institution </h4>
                                    <!-- <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="view_institution.php">Institution</a></li>
                                            <li class="breadcrumb-item active">Add Institution</li>
                                        </ol>
                                    </div> -->
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
                                            <h1 class="fw-bolder text-white">Add Institution </h1>
                                            <p class="fs-5 text-white mb-0">Fill in the details below to register a new Institution under your network.</p>
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
                                        <label class="col-form-label" for="name">Institution Name<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="name" placeholder="Enter your name">
                                        <small class="error-message" id="name_error"></small>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6">
                                    <div class="input-block mb-3">
                                        <label class="col-form-label" for="numberBranch">No of Branches<span class="text-danger">*</span></label>
                                        <input type="number" class="form-control" id="numberBranch" placeholder="Enter No of Branches">
                                        <small class="error-message" id="numberBranch_error"></small>
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <div class="form-group mb-3">
                                        <label class="col-form-label d-block">Types of Institution<span class="text-danger">*</span></label>
                                        <div class="form-control">
                                            <div class="row ins-type-wrapper" id="ins-type_wrapper">
                                                <div class="col-lg-4 col-4 col-sm-6 col-12">
                                                    <label class="radio-inline mb-0 ms-3" for="test3"><input type="radio" id="test3" class="form-check-input instituteType me-3" name="instituteType" value="bank">Bank</label>
                                                </div>
                                                <div class="col-lg-4 col-4 col-sm-6 col-12">
                                                    <label class="radio-inline mb-0 ms-3" for="test4"><input type="radio" id="test4" class="form-check-input instituteType me-3" name="instituteType" value="nbfc">NBFC</label>
                                                </div>
                                                <div class="col-lg-4 col-4 col-sm-6 col-12">
                                                    <label class="radio-inline mb-0 ms-3" for="test5"><input type="radio" id="test5" class="form-check-input instituteType me-3" name="instituteType" value="corperative_bank">Corperative Bank</label>
                                                </div>
                                                <div class="col-lg-4 col-4 col-sm-6 col-12">
                                                    <label class="radio-inline mb-0 ms-3" for="test6"><input type="radio" id="test6" class="form-check-input instituteType me-3" name="instituteType" value="society">Society</label>
                                                </div>
                                                <div class="col-lg-4 col-4 col-sm-6 col-12">
                                                    <label class="radio-inline mb-0 ms-3" for="test7"><input type="radio" id="test7" class="form-check-input instituteType me-3" name="instituteType" value="trust">Trust</label>
                                                </div>
                                                <div class="col-lg-4 col-4 col-sm-6 col-12">
                                                    <label class="radio-inline mb-0 ms-3" for="test8"><input type="radio" id="test8" class="form-check-input instituteType me-3" name="instituteType" value="other">Others</label>
                                                </div>
                                            </div>
                                            <small class="error-message" id="ins-type_error"></small>
                                            <input type="text" name="instituteTypeOther" id="instituteTypeOther" class="form-control mt-2" value="" style="display:none;">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6">
                                    <div class="input-block mb-3">
                                        <label class="col-form-label" for="incorporationDate">Incorporation Date<span class="text-danger">*</span></label>
                                        <input type="date" class="form-control" id="incorporationDate" placeholder="Enter Incorporation Date">
                                        <small class="error-message" id="incorporationDate_error"></small>
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
                                                <label class="col-form-label" for="country_cd">Code:</label>
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
                                                <small class="error-message" id="country_code_error"></small>
                                            </div> 
                                        </div>
                                        <div class="col-md-8 col-sm-8 col-9">
                                            <div class="input-block">
                                                <label class="col-form-label" for="phone">Phone Number<span class="text-danger">*</span></label>
                                                <input type="number" class="form-control" id="phone" placeholder="Enter your Phone Number">
                                                <small class="error-message" id="phone_error"></small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6">
                                    <div class="input-block mb-3">
                                        <label class="col-form-label" for="institutionPAN">Institution PAN<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="institutionPAN" placeholder="Enter Institution PAN">
                                        <small class="error-message" id="institutionPAN_error"></small>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6">
                                    <div class="input-block mb-3">
                                        <label class="col-form-label" for="email">Email Address<span class="text-danger">*</span></label>
                                        <input type="email" class="form-control" id="email" placeholder="Enter Email Address">
                                        <small class="error-message" id="email_error"></small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Card Section 2 -->
                        <div class="card rounded-4 p-3 border-1">
                            <div class="row">
                                <div class="d-flex gap-2">
                                    <p class="fw-bolder addTENum">02</p>
                                    <h4 class="fw-bolder text-dark align-content-center">Registered Office Address:</h4>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6">
                                    <div class="input-block mb-3">
                                        <?php
                                            $stmt = $conn->prepare("SELECT * FROM countries WHERE status = 1 ORDER BY country_name ASC");
                                            $stmt->execute();                                         
                                            $stmt->setFetchMode(PDO::FETCH_ASSOC);
                                        ?>
                                        <label class="col-form-label" for="country">Country<span class="text-danger">*</span></label>
                                        <select class="form-select" id="country">
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
                                        <small class="error-message" id="country_error"></small>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6">
                                    <div class="input-block mb-3">
                                        <label class="col-form-label" for="mystate">State<span class="text-danger">*</span></label>
                                        <select class="form-select" id="mystate" aria-label="Floating label select example">
                                            <option value="">--Select country first--</option>
                                        </select>
                                        <small class="error-message" id="mystate_error"></small>
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
                                        <input type="text" class="form-control" id="pin" placeholder="Enter your pincode">
                                        <small class="error-message" id="pin_error"></small>
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <div class="input-block mb-3">
                                        <label class="col-form-label" for="address">Address<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="address" placeholder="Enter your Address">
                                        <small class="error-message" id="address_error"></small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Card Section 3 -->
                        <div class="card rounded-4 p-3 border-1">
                            <div class="row">
                                <div class="d-flex gap-2">
                                    <p class="fw-bolder addTENum">03</p>
                                    <h4 class="fw-bolder text-dark align-content-center">Bank Details:</h4>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6">
                                    <div class="input-block mb-3">
                                        <label class="col-form-label" for="accountName">Account Name<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="accountName" placeholder="Enter your Account Name">
                                        <small class="error-message" id="accountName_error"></small>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6">
                                    <div class="input-block mb-3">
                                        <label class="col-form-label" for="accountNumber">Account Number<span class="text-danger">*</span></label>
                                        <input type="number" class="form-control" id="accountNumber" placeholder="Enter your Account Number">
                                        <small class="error-message" id="accountNumber_error"></small>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6">
                                    <div class="input-block mb-3">
                                        <label class="col-form-label" for="ifscCode">IFSC Code<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="ifscCode" placeholder="Enter your IFSC Code">
                                        <small class="error-message" id="ifscCode_error"></small>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6">
                                    <div class="input-block mb-3">
                                        <label class="col-form-label" for="branchName">Bank & Branch Name<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="branchName" placeholder="Enter your Bank & Branch Name">
                                        <small class="error-message" id="branchName_error"></small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Card Section 4 -->
                        <div class="card rounded-4 p-3 border-1">
                            <div class="row">
                                <div class="d-flex gap-2">
                                    <p class="fw-bolder addTENum">04</p>
                                    <h4 class="fw-bolder text-dark align-content-center">Payment Information</h4>
                                </div>
                                <div class="col-md-6 col-sm-6">
                                    <div class="input-block mb-3">
                                        <label class="col-form-label" for="activationPlan">Activation Plan<span class="text-danger">*</span></label>
                                        <select id="activationPlan" class="form-select"> 
                                            <option value="">--Select Activation Plan--</option> 
                                            <option value="FOC">FOC</option> 
                                            <option value="200000">2,00,000/-</option> 
                                            <option value="300000">3,00,000/-</option> 
                                            <option value="400000">4,00,000/-</option> 
                                            <option value="500000">5,00,000/-</option> 
                                        </select>
                                        <small class="error-message" id="activationPlan_error"></small>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6 d-none" id="paymentMode">
                                    <label class="fw-bold col-form-label">Payment Mode: <span class="text-danger">*</span></label>
                                    <div class="form-control radioBtn d-flex justify-content-around payment-mode-wrapper" id="payment-mode_wrapper">
                                        <label class="mb-0" for="cashPayment"><input type="radio" id="cashPayment" class="form-check-input payment me-3" name="payment" value="cash">Cash</label>
                                        <label class="mb-0" for="chequePayment"><input type="radio" id="chequePayment"  class="form-check-input payment me-3" name="payment" value="cheque">Cheque</label>
                                        <label class="mb-0" for="onlinePayment"><input type="radio" id="onlinePayment"  class="form-check-input payment me-3" name="payment" value="online">UPI/NEFT</label>
                                    </div>
                                    <small class="error-message" id="payment-mode_error"></small>
                                </div>
                                <div class="pb-3">
                                    <div class="col-md-12 col-sm-12 d-none" id="chequeOpt">
                                        <div class="row d-flex justify-content-center">
                                            <div class="col-md-4 py-1">
                                                <div class="input-block">
                                                    <label class="col-form-label" for="chequeNo">Cheque No<span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" id="chequeNo" placeholder="Enter Cheque Number">
                                                    <small class="error-message" id="chequeNo_error"></small>
                                                </div>
                                            </div>
                                            <div class="col-md-4 py-1">
                                                <div class="input-block">
                                                    <label class="col-form-label" for="chequeDate">Cheque Date<span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" id="chequeDate" placeholder="YYYY-MM-DD" maxlength="10" autocomplete="off">
                                                    <small class="error-message" id="chequeDate_error"></small>
                                                </div>
                                            </div>
                                            <div class="col-md-4 py-1">
                                                <div class="input-block">
                                                    <label class="col-form-label" for="bankName">Bank Name<span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" id="bankName" placeholder="Enter your Bank Name">
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
                                                    <input type="text" class="form-control" id="transactionNo" placeholder="Enter your Transaction No.">
                                                    <small class="error-message" id="transactionNo_error"></small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Card Section 5 -->
                        <div class="card rounded-4 p-3 border-1">
                            <div class="">
                                <div class="d-flex gap-2">
                                    <p class="fw-bolder addTENum">05</p>
                                    <h4 class="fw-bolder text-dark align-content-center">Upload Information</h4>
                                </div>
                                <div class="row g-3">
                                    <!-- Certificate of Incorporation -->
                                    <div class="col-lg-4 col-md-4 col-sm-6 col-12">
                                        <div class="upload-card" data-title="Certificate of Incorporation" data-index="14" data-folder="certificate_of_incorporation">
                                            <input type="file" class="file-input" accept="image/*,.pdf" id="upload_file14">
                                            <div class="upload-content">
                                                <div class="upload-icon">
                                                    <i class="fa-solid fa-user"></i>
                                                </div>
                                                <h6>Certificate of Incorporation</h6>
                                                <p>Click to upload<br>or drag and drop</p>
                                                <small>(JPG, PNG, PDF)</small>
                                            </div>
                                        </div>
                                    </div>
									<!-- GSTIN -->
									<div class="col-lg-4 col-md-4 col-sm-6 col-12">
										<div class="upload-card" data-title="GSTIN" data-index="15" data-folder="gstin">
											<input type="file" class="file-input" accept="image/*,.pdf" id="upload_file15">
											<div class="upload-content">
												<div class="upload-icon">
													<i class="fa-regular fa-id-card"></i>
												</div>
												<h6>GSTIN</h6>
												<p>Click to upload<br>or drag and drop</p>
												<small>(JPG, PNG, PDF)</small>
											</div>
										</div>
									</div>
                                    <!-- Board Resolution -->
									<div class="col-lg-4 col-md-4 col-sm-6 col-12">
										<div class="upload-card" data-title="Board Resolution" data-index="16" data-folder="board_resolution">
											<input type="file" class="file-input" accept="image/*,.pdf" id="upload_file16">
											<div class="upload-content">
												<div class="upload-icon">
													<i class="fa-regular fa-credit-card"></i>
												</div>
												<h6>Board Resolution</h6>
												<p>Click to upload<br>or drag and drop</p>
												<small>(JPG, PNG, PDF)</small>
											</div>
										</div>
									</div>
									<!-- Bank Passbook -->
									<div class="col-lg-4 col-md-4 col-sm-6 col-12">
										<div class="upload-card" data-title="Bank Passbook" data-index="4" data-folder="passbook">
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
									<!-- PAN Card -->
									<div class="col-lg-4 col-md-4 col-sm-6 col-12">
										<div class="upload-card" data-title="PAN Card" data-index="3" data-folder="pancard">
											<input type="file" class="file-input" accept="image/*,.pdf" id="upload_file3">
											<div class="upload-content">
												<div class="upload-icon">
													<i class="fa-solid fa-building-columns"></i>
												</div>
												<h6>PAN Card</h6>
												<p>Click to upload<br>or drag and drop</p>
												<small>(JPG, PNG, PDF)</small>
											</div>
										</div>
									</div>
									<!-- Address Proof -->
									<div class="col-lg-4 col-md-4 col-sm-6 col-12" id="addressProof">
										<div class="upload-card" data-title="Address Proof" data-index="6" data-folder="address_proof">
											<input type="file" class="file-input" accept="image/*,.pdf" id="upload_file6">
											<div class="upload-content">
												<div class="upload-icon">
													<i class="fa-solid fa-building-columns"></i>
												</div>
												<h6>Address Proof</h6>
												<p>Click to upload<br>or drag and drop</p>
												<small>(JPG, PNG, PDF)</small>
											</div>
										</div>
									</div>
									<!-- Payment Proof -->
									<div class="col-lg-4 col-md-4 col-sm-6 col-12 d-none" id="payProof">
										<div class="upload-card" data-title="Payment Proof" data-index="12" data-folder="payment">
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
                            </div>
                        </div>
                        <input type="hidden" id="testValue" name="testValue" value="32"> <!-- institution -->
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="d-flex justify-content-end gap-4 submitBtnBackground">
                                    <button type="button" class="btn actionBtn cancelBtn mb-2">Cancel</button>
                                    <button type="button" class="btn actionBtn draftBtn mb-2" id="saveDraftAdd">Save Draft</button>
                                    <button type="submit" class="btn actionBtn submitBtn mb-2" id="addInstitution">
                                        <i class="fa-regular fa-paper-plane me-2"></i>
                                        Submit Institution
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                <!-- container-fluid -->
                </div>
                <!-- End Page-content -->
                <?php include_once "business_development_manager_footer.php"; ?>
            </div>
            <!-- end main content-->

        </div>

        <!-- loading screen -->
        <div id="loading-overlay">
            <div class="loading-icon"></div>
        </div>
        <!--start back-to-top-->
        <button onclick="topFunction()" class="scrollToTop scroll-btn show btn" id="back-to-top">
            <i class="mdi mdi-arrow-up"></i>
        </button>
        <!--end back-to-top-->

        <!-- JAVASCRIPT -->
        <script src="../assets/libs/jquery/jquery.min.js"></script>
        <script src="../assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="../assets/libs/metismenu/metisMenu.min.js"></script>
        <script src="../assets/libs/simplebar/simplebar.min.js"></script>
        <script src="../assets/libs/node-waves/waves.min.js"></script>
        <script src="../assets/libs/feather-icons/feather.min.js"></script>
        <script src="../assets/libs/node-waves/waves.min.js"></script>

        <!-- add data to database js file -->
        <script type="text/javascript" src="js/institution.js"></script>

        <!-- apexcharts -->
        <!-- <script src="../assets/libs/apexcharts/apexcharts.min.js"></script> -->

        <!-- dashboard init -->
        <!-- <script src="assets/js/pages/dashboard.init.js"></script> -->

        <!-- App js -->
        <script src="../assets/js/app.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <!-- file upload code js file -->
        <!-- <script src="../../uploading/uploadTechnoAdmin.js"></script> -->

        <script>
            var mybutton = document.getElementById("back-to-top");
            function scrollFunction() {
                100 < document.body.scrollTop || 100 < document.documentElement.scrollTop ? mybutton.style.display = "block" : mybutton.style.display = "none"
            }
            function topFunction() {
                document.body.scrollTop = 0,
                document.documentElement.scrollTop = 0
            }
            mybutton && (window.onscroll = function() {
                scrollFunction()
            }
            );

        </script>
        <!-- ** designation user, user name on designation select / get country, state, city, pincode **  -->
        <script>
            
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
                // alert();
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
                            // $('#pin').html(response);
                            $('#pin').val(response); 
                        }
                    }); 
                }else{
                    $('#city').html('<option value="">Select state first</option>');
                    $('#pin').val('');
                }
            });

            //Activation Plan
            $('#activationPlan').on('change', function() {
                var payval=$(this).val();
                if (payval != 'FOC') {
                    $('#paymentMode').removeClass('d-none');
                    $('#payProof').removeClass('d-none');
                    $('#payOpt').removeClass('d-none');
                }else{
                    $('#paymentMode').addClass('d-none');
                    $('#payProof').addClass('d-none');
                    $('#payOpt').addClass('d-none');
                }
            });

            // Payment Mode
            $('#paymentMode').on('click', function(){
                var paymentMode = $(".payment:checked").val();
                // console.log(paymentMode);
                if(paymentMode == "cheque"){
                    $("#chequeOpt").removeClass("d-none");
                    $("#onlineOpt").addClass("d-none");
                    $("#transactionNo").val("");
                }else if(paymentMode == "online"){
                    $("#onlineOpt").removeClass("d-none");
                    $("#chequeOpt").addClass("d-none");
                    $("#chequeNo").val("");
                    $("#chequeDate").val("");
                    $("#bankName").val("");
                } else {
                    $("#chequeOpt").addClass("d-none");
                    $("#onlineOpt").addClass("d-none");
                    $("#chequeNo").val("");
                    $("#chequeDate").val("");
                    $("#bankName").val("");
                    $("#transactionNo").val("");
                }
            });

            // type of institution other radio button option to show text box
            $(".instituteType").change(function () {
                if ($("#test8").is(":checked")) {
                    $("#instituteTypeOther").slideDown();
                } else {
                    $("#instituteTypeOther").slideUp();
                    $("#instituteTypeOther").val("");
                }
            });

            //New file upload code
            const uploadBasePath = "../../uploading/";
            const uploadUrl = "../../uploading/uploadAdminUsers.php";   // your upload file

            function bindUploadEvents() {

                $(".file-input").off("change").on("change", function () {

                    let input = this;

                    if (!input.files.length)
                        return;

                    let file = input.files[0];

                    let card = $(input).closest(".upload-card");

                    let title = card.data("title");

                    let index = card.data("index");

                    let folder = card.data("folder");

                    let formData = new FormData();

                    formData.append("file", file);
                    formData.append("folder", folder);

                    $.ajax({

                        url: uploadUrl,

                        type: "POST",

                        data: formData,

                        processData: false,

                        contentType: false,

                        success: function (response) {

                            response = response.trim();

                            if (response == "1") {
                                alert("Upload Failed");
                                input.value = "";
                                return;
                            }

                            if (response == "2") {
                                alert("Invalid File Extension");
                                input.value = "";
                                return;
                            }

                            if (response == "3") {
                                alert("Please Select File");
                                input.value = "";
                                return;
                            }

                            if (response == "4") {
                                alert("File size exceeds 2 MB");
                                input.value = "";
                                return;
                            }

                            card.find(".upload-content").remove();
                            card.find(".preview-wrapper").remove();
                            card.find(".pdf-preview").remove();

                            let hiddenInput = $("#img_path" + index);

                            if (!hiddenInput.length) {

                                hiddenInput = $("<input>", {

                                    type: "hidden",

                                    id: "img_path" + index,

                                    name: "img_path" + index

                                });

                                card.append(hiddenInput);

                            }

                            hiddenInput.val(response);

                            let extension = response.split('.').pop().toLowerCase();

                            if (["jpg", "jpeg", "png", "gif", "jfif"].includes(extension)) {

                                card.append(`
                                    <div class="preview-wrapper">

                                        <img src="${uploadBasePath}${response}" class="img-fluid">

                                        <div class="file-title">
                                            ${title}
                                        </div>

                                    </div>
                                `);

                            } else {

                                card.append(`
                                    <div class="pdf-preview">

                                        <i class="fa-solid fa-file-pdf fa-3x"></i>

                                        <div class="file-title">
                                            ${title}
                                        </div>

                                    </div>
                                `);

                            }

                        },

                        error: function () {

                            alert("Upload Failed.");

                        }

                    });

                });

            }

            $(function () {

                bindUploadEvents();

            });
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

						window.location.href = "institution_list.php";

					}

				});

			});

        </script>
    </body>
</html>