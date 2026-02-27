<?php
    session_start();

    if(!isset($_SESSION['username'])){
        echo '<script>location.href = "../../login.php";</script>';
    }

    require '../../connect.php';

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
        <title>Add Employee | Admin Dashboard </title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- App favicon -->
        <link rel="shortcut icon" href="../../assets/images/fav.png">

        <!-- Bootstrap Css -->
        <link href="../../assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
        <!-- Icons Css -->
        <link href="../../assets/css/icons.min.css" rel="stylesheet" type="text/css" />
        <!-- App Css-->
        <link href="../../assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />
        <!-- Loading Screen and Images size css  -->
        <link rel="stylesheet" href="../../assets/css/loadingScreen.css" rel="stylesheet" type="text/css" />

        <style>
            
            @media screen and (max-width: 767px) {
                .code-mobile{
                    margin-bottom: 20px;
                }
            }
        </style>

    </head>

    <body data-sidebar="dark">

        <div id="testemails"></div>

        <!-- <body data-layout="horizontal" data-topbar="dark"> -->

        <!-- Begin page -->
        <div id="layout-wrapper">

            <?php 
                // top header logo, hamberger menu, fullscreen icon, profile
                include_once '../../header.php';

                // sidebar navigation menu 
                include_once '../../sidebar.php';
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
                                    <h4 class="mb-sm-0 font-size-18">Employee / Zonal Manager</h4>
                                </div>
                            </div>
                        </div>

                        <!-- add customer form start -->
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
										<form>
											<h3>Add Employee / Zonal Manager</h3>
											<div class="row" id="formParent">
												<!-- Personal Details -->
												<h4 class="my-2">Personal Details</h4>
                                                <div class="col-md-4 col-sm-6 col-12">
                                                    <div class="input-block mb-3">
                                                        <label class="col-form-label" for="registered">Registering As<span class="text-danger">*</span></label>
                                                        <select id="registered" class="form-select">
                                                            <option value="">--Select --</option>
                                                            <option value="employee">Employee</option>
                                                            <option value="zonal_manager">Zonal Manager</option>
                                                        </select>
                                                    </div>
                                                </div>
												<div class="col-md-4 col-sm-6">
													<div class="input-block mb-3">
														<label class="col-form-label">Full Name <span class="text-danger">*</span></label>
														<input class="form-control" type="text" id="fullName" >
													</div>
												</div>
												<div class="col-md-4 col-sm-6">
													<div class="input-block mb-3">
														<label class="col-form-label">Date of Birth <span class="text-danger">*</span></label>
														<input class="form-control" type="date" id="birth_date" max="<?php echo $ageLimit; ?>">
													</div>
												</div>
												<div class="col-md-6 col-sm-12 mb-3">
                                                    <div class="row">
                                                        <div class="col-md-4 col-sm-4 col-3">
                                                            <div class="input-block">
                                                                <?php
                                                                    require '../../connect.php';
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
                                                                <label class="col-form-label">Contact Number <span class="text-danger">*</span></label>
                                                                <input class="form-control" type="number" id="contact">
                                                            </div>
                                                        </div>
													</div>
												</div>
												<div class="col-md-6 col-sm-6">
													<div class="input-block mb-3">
														<label class="col-form-label">Email <span class="text-danger">*</span></label>
														<input class="form-control" type="email" id="email">
													</div>
												</div>
												<div class="col-md-6 col-sm-6">  
													<div class="input-block mb-3">
														<label class="col-form-label">Address <span class="text-danger">*</span></label>
														<input type="text" class="form-control" id="address">
													</div>
												</div>
												<div class="col-md-6 col-sm-12">
													<div class="form-group mb-3">
														<label class="col-form-label d-block">Gender <span class="text-danger">*</span></label>
														<div class="form-control d-flex justify-content-around">
															<label class="radio-inline mb-0 ms-3"><input type="radio" name="gender form-check-input" class="gender" id="test1" value="male">&nbsp;&nbsp;&nbsp;Male</label>
															<label class="radio-inline mb-0 ms-3"><input type="radio" name="gender form-check-input" class="gender" id="test2" value="female">&nbsp;&nbsp;&nbsp;Female</label>
															<label class="radio-inline mb-0 ms-3"><input type="radio" name="gender form-check-input" class="gender" id="test3" value="others">&nbsp;&nbsp;&nbsp;Other</label>
														</div>
													</div>
												</div>
												<div class="col-md-12 col-sm-12" id="emp_block">
													<div class="row" id="employee">
                                                        <!-- Employment Details -->
                                                        <h4 class="my-2">Employment Details</h4>
                                                        <div class="col-md-6 col-sm-6">  
                                                            <div class="input-block mb-3">
                                                                <label class="col-form-label">Joining Date <span class="text-danger">*</span></label>
                                                                <input class="form-control" type="date" id="joining_date" max="<?php echo $today; ?>" min="<?php echo $ageLimit; ?> ">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-sm-6">
                                                            <div class="input-block mb-3">
                                                                <label class="col-form-label">Department <span class="text-danger">*</span></label>
                                                                <select class="form-select" id="department">
                                                                    <option value=""> ---- Select Department ---- </option>
                                                                    <?php include '../../models/common_models/department.php'?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-sm-6">
                                                            <div class="input-block mb-3">
                                                                <label class="col-form-label">Designation <span class="text-danger">*</span></label>
                                                                <select class="form-select" id="designation">
                                                                    <option value=""> ---- Select Designation ---- </option>
                                                                    <?php include '../../models/common_models/designation.php'?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="col-md-6 col-sm-6">
                                                            <div class="input-block mb-3">
                                                                <label class="col-form-label">Zone <span class="text-danger">*</span></label>
                                                                <select class="form-select" id="zone">
                                                                    <option value=""> ---- Select Zone ---- </option>
                                                                    <?php include '../../models/common_models/zones.php'?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-sm-6">
                                                            <div class="input-block mb-3">
                                                                <label class="col-form-label">Branch <span class="text-danger">*</span></label>
                                                                <select class="form-select" id="branch">
                                                                    <option value=""> ---- Select Zone First ---- </option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-sm-6">
                                                            <div class="input-block mb-3">
                                                                <label class="col-form-label">Reporting Manager <span class="text-danger">*</span></label>
                                                                <select class="form-select" id="reporting_manager">
                                                                    <option value="null"> ---- Select Manager ---- </option>
                                                                        <?php include '../../models/common_models/reporting_manager.php'?>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <!-- Attachments -->
                                                        <h4 class="my-2">Attachments</h4>
                                                        <div class="col-md-6 col-sm-6">  
                                                            <div class="input-block mb-3">
                                                                <label class="col-form-label">Profile Picture</label>
                                                                <input class="form-control" type="file" id="profile_pic">
                                                            </div>
                                                            <input type="hidden" id="img_path1" value="">
                                                            <div id="preview1" style="display: none;">
                                                                <div id="image_preview1">
                                                                    <img  alt="Preview" class="imgSize" id="img_pre1">
                                                                </div>
                                                            </div>
                                                        </div> 
                                                        <div class="col-md-6 col-sm-6">  
                                                            <div class="input-block mb-3">
                                                                <label class="col-form-label">ID Proof (Aadhaar/PAN/Passport)</label>
                                                                <input class="form-control" type="file" id="id_proof">
                                                            </div>
                                                            <input type="hidden" id="img_path2" value="">
                                                            <div id="preview2" style="display: none;">
                                                                <div id="image_preview2">
                                                                    <img  alt="Preview" class="imgSize" id="img_pre2">
                                                                </div>
                                                            </div>
                                                        </div> 
                                                        <div class="col-md-6 col-sm-6">  
                                                            <div class="input-block mb-3">
                                                                <label class="col-form-label">Bank Details for Salary Transfer</label>
                                                                <input class="form-control" type="file" id="bank_details">
                                                            </div>
                                                            <input type="hidden" id="img_path3" value="">
                                                            <div id="preview3" style="display: none;">
                                                                <div id="image_preview3">
                                                                    <img  alt="Preview" class="imgSize" id="img_pre3">
                                                                </div>
                                                            </div>
                                                        </div> 
                                                    </div>
												</div>
                                                
                                                <div class="col-md-12 col-sm-12 d-none" id="zm_block">
													<div class="row" id="zonal_manager">
                                                        <!-- Zonal Manager Details -->
                                                        <h4 class="my-2">Zonal Manager Details</h4>
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
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-sm-6">
                                                            <div class="input-block mb-3">
                                                                <label class="col-form-label">State<span class="text-danger">*</span></label>
                                                                <select class="form-select" id="mystate" aria-label="Floating label select example">
                                                                    <option value="">--Select country first--</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-sm-6">
                                                            <div class="input-block mb-3">
                                                                <label class="col-form-label">City<span class="text-danger">*</span></label>
                                                                <select class="form-select" id="city" aria-label="Floating label select example">
                                                                    <option value="">--Select state first--</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-sm-6">
                                                            <div class="input-block mb-3">
                                                                <label class="col-form-label">Pincode<span class="text-danger">*</span></label>
                                                                <input type="text" class="form-control" id="pin" placeholder="Pincode" readonly>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-sm-6">
                                                            <div class="input-block mb-3">
                                                                <label class="col-form-label">Zone<span class="text-danger">*</span></label>
                                                                <select class="form-select" id="zonal" aria-label="Floating label select example">
                                                                    <option value="">--Select state first--</option>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <!-- Attachments -->
                                                        <h4 class="my-2">Attachments</h4>
                                                        <div class="col-md-6 col-sm-6">
                                                            <div class="input-block mb-3">
                                                                <label class="col-form-label">Profile Picture</label>
                                                                <input class="form-control" type="file" name="file1" id="upload_file1">
                                                            </div>
                                                            <input type="hidden" id="img_path1" value="">
                                                            <div id="preview1" style="display: none;">
                                                                <div id="image_preview1">
                                                                    <img alt="Preview" class="imgSize" id="img_pre1">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-sm-6">
                                                            <div class="input-block mb-3">
                                                                <label class="col-form-label">Aadhaar Card</label>
                                                                <input class="form-control" type="file" name="file2" id="upload_file2">
                                                            </div>
                                                            <input type="hidden" id="img_path2" value="">
                                                            <div id="preview2" style="display: none;">
                                                                <div id="image_preview2">
                                                                    <img alt="Preview" class="imgSize" id="img_pre2">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-sm-6">
                                                            <div class="input-block mb-3">
                                                                <label class="col-form-label">Pan Card</label>
                                                                <input class="form-control" type="file" name="file3" id="upload_file3">
                                                            </div>
                                                            <input type="hidden" id="img_path3" value="">
                                                            <div id="preview3" style="display: none;">
                                                                <div id="image_preview3">
                                                                    <img alt="Preview" class="imgSize" id="img_pre3">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-sm-6">
                                                            <div class="input-block mb-3">
                                                                <label class="col-form-label">Bank Passbook</label>
                                                                <input class="form-control" type="file" name="file4" id="upload_file4">
                                                            </div>
                                                            <input type="hidden" id="img_path4" value="">
                                                            <div id="preview4" style="display: none;">
                                                                <div id="image_preview4">
                                                                    <img alt="Preview" class="imgSize" id="img_pre4">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                               

                                                <div class="col-md-12 col-sm-12">
                                                    <div class="input-block mb-3">
                                                        <label class="col-form-label" for="flex_amount">Extra Notes<span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" id="note" placeholder="Enter Note">
                                                    </div>
                                                </div>
                                            
											</div>
											<input type="hidden" id="testValue" name="testValue" value="2425"> <!-- BCM/BDM -->
											<div class="submit-section d-flex justify-content-center mb-4">
												<button class="btn btn-primary submit-btn submit-btn1 px-5 py-2" id="add_employee">Submit</button>
											</div>
										</form>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                <!-- container-fluid -->
                </div>
                <!-- End Page-content -->


                <?php include_once "../../footer.php" ?>
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
        <script src="../../assets/libs/jquery/jquery.min.js"></script>
        <script src="../../assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="../../assets/libs/metismenu/metisMenu.min.js"></script>
        <script src="../../assets/libs/simplebar/simplebar.min.js"></script>
        <script src="../../assets/libs/node-waves/waves.min.js"></script>

        <!-- add data to database js file -->
        <script type="text/javascript" src="../../assets/js/submitdata.js"></script>

        <!-- apexcharts -->
        <!-- <script src="../../assets/libs/apexcharts/apexcharts.min.js"></script> -->

        <!-- dashboard init -->
        <!-- <script src="assets/js/pages/dashboard.init.js"></script> -->

        <!-- App js -->
        <script src="../../assets/js/app.js"></script>

        <!-- file upload code js file -->
        <script src="../../../uploading/upload.js"></script>
        <script src="../../resources/common_resources/top_function.js"></script>

        <!-- ** designation user, user name on designation select / get country, state, city, pincode **  -->
        <script src="../../resources/employee/add_employee_custom.js"></script>
        
    </body>

</html>