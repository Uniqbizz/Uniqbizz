<?php
    include_once (__DIR__.'/../dashboard_user_details.php');
?>
<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable">
    <head>

        <meta charset="utf-8" />
        <title> Techno Enterprise | Franchisee List</title>
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
    </head>
    <body>
        <div id="testemails"></div>
        <!-- Begin page -->
        <div id="layout-wrapper">

            <?php 
                include_once 'executive_techno_header.php'; 
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

                include_once 'executive_techno_sidebar.php'; 
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
                                    <h4 class="mb-sm-0">Add Techno Enterprise | Franchisee</h4>
                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="techno_enterprise_list.php">Techno Enterprise | Franchisee</a></li>
                                            <li class="breadcrumb-item active">Add Techno Enterprise | Franchisee</li>
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
                                            <h1 class="fw-bolder text-white">Add Techno Enterprise | Franchisee</h1>
                                            <p class="fs-5 text-white mb-0">Fill in the details below to register a new Techno Enterprise under your network.</p>
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
                                <div class="col-lg-3 col-md-4 col-sm-6 col-12">
                                    <div class="mb-3">
                                        <label for="gender" class="form-label fw-bold">Register As <span class="text-danger fw-bolder">*</span></label>
                                        <select class="form-select genderSelect" id="registerAs" required>
                                            <option value="" selected>Select Register As</option>
                                            <option value="16">Techno Eneterprise</option>
                                            <option value="29">Franchisee</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-4 col-sm-6 col-12">
                                    <div class="mb-3">
                                        <label for="firstname" class="form-label fw-bold">First Name <span class="text-danger fw-bolder">*</span></label>
                                        <input type="text" class="form-control" id="firstname" placeholder="Enter full name" required>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-4 col-sm-6 col-12">
                                    <div class="mb-3">
                                        <label for="lastname" class="form-label fw-bold">Last Name <span class="text-danger fw-bolder">*</span></label>
                                        <input type="text" class="form-control" id="lastname" placeholder="Enter last name" required>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-4 col-sm-6 col-12">
                                    <div class="mb-3 dateBirth">
                                        <label for="dob" class="form-label fw-bold">Date of Birth <span class="text-danger fw-bolder">*</span></label>
                                        <input type="date" class="form-control" id="dob" placeholder="dd-mm-yyyy"onfocus="this.type='date'" onblur="if(!this.value)this.type='text'" required>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-4 col-sm-6 col-12">
                                    <div class="mb-3">
                                        <label for="gender" class="form-label fw-bold">Gender <span class="text-danger fw-bolder">*</span></label>
                                        <select class="form-select genderSelect" id="gender" required>
                                            <option value="" selected>Select gender</option>
                                            <option value="male">Male</option>
                                            <option value="female">Female</option>
                                            <option value="others">Others</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-4 col-sm-6 col-12">
                                    <div class="mb-3">
                                        <label for="email" class="form-label fw-bold">Email address <span class="text-danger fw-bolder">*</span></label>
                                        <input type="email" class="form-control" id="email" placeholder="Enter email address" required>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-4 col-sm-6 col-12">
                                    <div class="mb-3">
                                        <label for="nominee_name" class="form-label fw-bold">Nominee name <span class="text-danger fw-bolder">*</span></label>
                                        <input type="text" class="form-control" id="nominee_name" placeholder="Enter nominee name" required>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-4 col-sm-6 col-12">
                                    <div class="mb-3">
                                        <label for="nominee_relation" class="form-label fw-bold">Nominee Relation <span class="text-danger fw-bolder">*</span></label>
                                        <input type="email" class="form-control" id="nominee_relation" placeholder="Enter relation" required>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-2 col-sm-6 col-12">
                                    <?php
                                        $stmt = $conn->prepare("SELECT * FROM countries WHERE status = 1 ORDER BY country_name ASC");
                                        $stmt->execute();                                            
                                        $stmt->setFetchMode(PDO::FETCH_ASSOC);
                                    ?>
                                    <label class="form-label fw-bold" for="country_cd">Code</label>
                                    <select class="form-select" id="country_cd" aria-label="Floating label select example">
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
                                <div class="col-lg-3 col-md-3 col-sm-6 col-12">
                                    <div class="mb-3">
                                        <label for="phone" class="form-label fw-bold">Mobile Number <span class="text-danger fw-bolder">*</span></label>
                                        <input type="number" class="form-control" id="phone" placeholder="Enter mobile number" required>
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
                                <div class="col-lg-3 col-md-4 col-sm-6 col-12">
                                    <div class="mb-3">
                                        <?php
                                            $stmt = $conn->prepare("SELECT * FROM countries WHERE status = 1 ORDER BY country_name ASC");
                                            $stmt->execute();                                         
                                            $stmt->setFetchMode(PDO::FETCH_ASSOC);
                                        ?>
                                        <label for="country" class="form-label fw-bold">Country <span class="text-danger fw-bolder">*</span></label>
                                        <select class="form-select genderSelect" id="country" required>
                                            <option value="" selected >Select country </option>
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
                                <div class="col-lg-3 col-md-4 col-sm-6 col-12">
                                    <div class="mb-3">
                                        <label for="mystate" class="form-label fw-bold">State <span class="text-danger fw-bolder">*</span></label>
                                        <select class="form-select genderSelect" id="mystate" required>
                                            <option value="">--Select country first--</option>   
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-4 col-sm-6 col-12">
                                    <div class="mb-3">
                                        <label for="city" class="form-label fw-bold">City<span class="text-danger fw-bolder">*</span></label>
                                        <select class="form-select genderSelect " id="city" required>
                                            <option value="">--Select state first--</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-4 col-sm-6 col-12">
                                    <div class="mb-3">
                                        <label for="pin" class="form-label fw-bold">Pincode<span class="text-danger fw-bolder">*</span></label>
                                        <input type="text" class="form-control" id="pin" placeholder="Enter pincode">
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                                    <div class="mb-3">
                                        <label for="address" class="form-label fw-bold">Address<span class="text-danger fw-bolder">*</span></label>
                                        <textarea class="form-control" id="address" rows="3" placeholder="Enter complete address"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Card Section 3 -->
                        <div class="card rounded-4 p-3 border-1">
                            <div class="row">
                                <div class="d-flex gap-2">
                                    <p class="fw-bolder addTENum">03</p>
                                    <h4 class="fw-bolder text-dark align-content-center">Business Information</h4>
                                </div>
                                <div class="col-lg-3 col-md-4 col-sm-6 col-12">
                                    <div class="mb-3">
                                        <label for="businessPackage" class="form-label fw-bold">Business Package / Amount <span class="text-danger fw-bolder">*</span></label>
                                        <select class="form-select genderSelect" id="businessPackage" required>
                                            <option value="" selected disabled>Select business package </option>
                                            <option value="200000">&#8377 2,00,000</option>
                                            <option value="300000">&#8377 3,00,000</option>
                                            <option value="500000">&#8377 5,00,000</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-4 col-sm-6 col-12">
                                    <div class="mb-3">
                                        <label for="flex_amount" class="form-label fw-bold">Amount <span class="text-danger fw-bolder">*</span></label>
                                        <input type="text" class="form-control" id="flex_amount" placeholder="Enter amount" required>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-4 col-sm-6 col-12">
                                    <div class="mb-3">
                                        <label for="gst_no" class="form-label fw-bold">GST No </label>
                                        <input type="text" class="form-control" id="gst_no" placeholder="Enter GST number">
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
                                <div class="col-lg-12">
                                    <div class="radioBtn row" id="paymentMode">
                                        <div class="col-lg-4 col-md-4 col-sm-6 col-12">
                                            <label class="form-control py-3 text-center fw-bold payment-label ptMode" for="cashPayment">
                                                <i class="fa-regular fa-money-bill-1 fa-2xl me-3"></i> Cash 
                                                <input type="radio" id="cashPayment" class="form-check-input payment ms-3" name="payment" value="cash" checked>
                                            </label>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-6 col-12">
                                            <label class="form-control py-3 text-center fw-bold payment-label" for="onlinePayment">
                                                <i class="fa-solid fa-forward fa-2xl me-3"></i>UPI / NEFT
                                                <input type="radio" id="onlinePayment" class="form-check-input payment ms-3" name="payment" value="online">
                                            </label>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-6 col-12">
                                            <label class="form-control py-3 text-center fw-bold payment-label" for="chequePayment">
                                                <i class="fa-solid fa-money-check fa-2xl me-3"></i> Cheque 
                                                <input type="radio" id="chequePayment" class="form-check-input payment ms-3" name="payment" value="cheque">
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="row" id="paymentFields">
                                        <div class="col-md-12 col-sm-12 d-none" id="chequeOpt">
                                            <div class="row">
                                                <div class="col-md-4 col-sm-6 col-12 py-1">
                                                    <div class="input-block">
                                                        <label class="col-form-label" for="chequeNo">Cheque No<span class="text-danger">*</span></label>
                                                        <input type="number" class="form-control" id="chequeNo" placeholder="Enter Cheque Number">
                                                    </div>
                                                </div>

                                                <div class="col-md-4 col-sm-6 col-12 py-1">
                                                    <div class="input-block">
                                                        <label class="col-form-label" for="chequeDate">Cheque Date<span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" id="chequeDate" placeholder="Enter Date On Cheque">
                                                    </div>
                                                </div>

                                                <div class="col-md-4 col-sm-6 col-12 py-1">
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
                        </div>
                        <!-- Card Section 5 -->
                        <div class="card rounded-4 p-3 border-1">
                            <div class="d-flex gap-2">
                                <p class="fw-bolder addTENum">05</p>
                                <h4 class="fw-bolder text-dark align-content-center">Upload Documents</h4>
                            </div>
                            <div class="row g-3">
                                <!-- Profile Photo -->
                                <div class="col-lg-2 col-md-4 col-6">
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
                                <div class="col-lg-2 col-md-4 col-6">
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
                                <div class="col-lg-2 col-md-4 col-6">
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
                                <div class="col-lg-2 col-md-4 col-6">
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
                                <div class="col-lg-2 col-md-4 col-6">
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

                                <!-- Payment Proof -->
                                <div class="col-lg-2 col-md-4 col-6">
                                    <div class="upload-card" data-title="Payment Proof" data-index="12">
                                        <input type="file" class="file-input" accept="image/*,.pdf" id="upload_file12">
                                        <div class="upload-content">
                                            <div class="upload-icon">
                                                <i class="fa-solid fa-file-invoice"></i>
                                            </div>
                                            <h6>Payment Proof</h6>
                                            <p>Click to upload<br>or drag and drop</p>
                                            <small>(JPG, PNG, PDF)</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Card Section 6 -->
                        <!-- <div class="card rounded-4 p-3 border-1">
                            <div class="d-flex gap-2">
                                <p class="fw-bolder addTENum">06</p>
                                <h4 class="fw-bolder text-dark align-content-center">Additional Notes</h4>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="mb-3">
                                        <label for="note" class="form-label fw-bold">Extra Notes</label>
                                        <textarea class="form-control" id="note" rows="3" placeholder="Enter any additional note"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div> -->
                        <input type="hidden" id="testValue" name="testValue" value="16"> <!-- CA -->
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="d-flex justify-content-end gap-4 submitBtnBackground">
                                    <button type="button" class="btn actionBtn cancelBtn mb-2">Cancel</button>
                                    <button type="button" class="btn actionBtn draftBtn mb-2" id="saveDraftAdd">Save Draft</button>
                                    <button type="submit" class="btn actionBtn submitBtn mb-2" id="addTechnoEnterprise">
                                        <i class="fa-regular fa-paper-plane me-2"></i>
                                        Submit Techno Enterprise | Franchisee
                                    </button>

                                </div>
                            </div>
                        </div>
                    </div> <!-- container-fluid -->
                </div><!-- End Page-content -->
                <?php

                    include_once "executive_techno_footer.php"; 
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
        <script src="js/techno_enterprise.js"></script>
       

        <!-- App js -->
        <script src="../assets/js/app.js"></script>
        <script src="../../uploading/uploadTechnoDashboard.js"></script>
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

        <!-- end dialer logic scripts -->
        <script>
            $('#businessPackage').on('change', function(){
                var business_package_amount = $(this).val();
                $('#flex_amount').val(business_package_amount);
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

                                    preview = document.createElement('div');
                                    preview.className = 'preview-wrapper';

                                    preview.innerHTML = `
                                        <img src="${e.target.result}">
                                        <input type="hidden" id="img_path${index}" value="../../uploading/${file.name}">
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
            document.querySelector(".cancelBtn").addEventListener("click", function () {
                if(confirm("Are you sure you want to cancel?")){
                    location.href = "techno_enterprise_list";
                }
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