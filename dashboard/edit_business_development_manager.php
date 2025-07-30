<?php
    include_once 'dashboard_user_details.php';
    
    $id = $_GET['vkvbvjfgfikix'];
    $dept = $_GET['dept'];
    $desig = $_GET['desig'];
    $zn = $_GET['zn'];
    $br = $_GET['br'];
    $editfor = $_GET['editfor'];

    $stmt = $conn->prepare("SELECT * FROM employees WHERE employee_id = :id");
	$stmt->execute(['id' => $id]);			
	$stmt->setFetchMode(PDO::FETCH_ASSOC);
	if($stmt->rowCount() > 0){
		foreach(($stmt->fetchAll()) as $key => $row) { 
			// $id = $row['id']; declered above
			$name = $row['name'];
			$employee_id = $row['employee_id'];
			$name = $row['name'];
			$date_of_birth = $row['date_of_birth'];
			$country_code = $row['country_code'];
			$contact = $row['contact'];
			$email = $row['email']; 
			$address = $row['address'];
			$gender = $row['gender'];
			$department_id = $row['department'];
			$designation_id = $row['designation'];
			$zone_id = $row['zone'];
			$branch_id = $row['branch'];
			$reporting_manager_id = $row['reporting_manager'];
			$date_of_joining = $row['date_of_joining'];
			$profile_pic = $row['profile_pic'];
			$id_proof = $row['id_proof'];
			$bank_details = $row['bank_details'];
			$register_by = $row['register_by'];
			$user_type = $row['user_type'];
			$status = $row['status']; 

			// Get Department Name
			$departments = $conn->prepare("SELECT * FROM department WHERE id = :department");
			$departments->execute(['department' => $department_id]);
			$departments->setFetchMode(PDO::FETCH_ASSOC);
			if($departments->rowCount() > 0){
				$department = $departments->fetch();
                $department_name = $department['dept_name'];
			}

			// Get Designation Name
			$designationss = $conn->prepare("SELECT * FROM designation WHERE id = :designation");
			$designationss->execute(['designation' => $designation_id]);
			$designationss->setFetchMode(PDO::FETCH_ASSOC);
			if($designationss->rowCount() > 0){
				$designations = $designationss->fetch();
                $designation_name = $designations['designation_name'];
			}

			// Get Zone Name
			$zones = $conn->prepare("SELECT * FROM zone WHERE id = :zone");
			$zones->execute(['zone' => $zone_id]);
			$zones->setFetchMode(PDO::FETCH_ASSOC);
			if($zones->rowCount() > 0){
				$zone = $zones->fetch();
				$zone_name = $zone['zone_name'];
			}

			// Get Branch Name
			$branches = $conn->prepare("SELECT * FROM branch WHERE id = :branch");
			$branches->execute(['branch' => $branch_id]);
			$branches->setFetchMode(PDO::FETCH_ASSOC);
			if($branches->rowCount() > 0){
				$branch = $branches->fetch();
				$branch_name = $branch['branch_name'];
			}

			// Get Reporting Manager Name
			if($reporting_manager_id == 'null'){
				$reporting_manager_name = 'Not Selected';
			}else{	
				$reporting_managers = $conn->prepare("SELECT * FROM employees WHERE employee_id = :reporting_manager");
				$reporting_managers->execute(['reporting_manager' => $reporting_manager_id]);
				$reporting_managers->setFetchMode(PDO::FETCH_ASSOC);
				if($reporting_managers->rowCount() > 0){
					$reporting_manager = $reporting_managers->fetch();
					$reporting_manager_name = $reporting_manager['name'];
				}
			}
		}

	}
?>

<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable">
    <head>

        <meta charset="utf-8" />
        <title>Dashboard | Business Development Manager</title>
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
        <link href="assets/css/loadingScreen.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/loadingScreen.css" rel="stylesheet" type="text/css" />
    </head>

    <body>
        <div id="testpho"></div>
        <div id="testemails"></div>
 
        <!-- Begin page -->
        <div id="layout-wrapper">

           <?php include_once "header.php"; ?>
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

            <?php include_once "sidebar.php"; ?>
            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->
            <div class="main-content">

                <div class="page-content">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="col-12"> <!-- Page title -->
                                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                        <h4 class="mb-sm-0">Edit Business Development Manager</h4>
                                        <div class="page-title-right">
                                            <ol class="breadcrumb m-0">
                                                <li class="breadcrumb-item">
                                                    <a href="view_business_development_manager.php">View Business Development Manager</a>
                                                </li>
                                                <li class="breadcrumb-item active">Edit</li>
                                            </ol>
                                        </div>
                                    </div>
                                </div> <!-- page title end -->
                                <div class="card">
                                    <div class="card-body">
                                        <div class="h-100">
                                            <form>
                                                <h3 class="m-4">Edit Employee</h3>
                                                <div class="row m-4">
                                                    <!-- Personal Details -->
                                                    <h4 class="mb-2">Personal Details</h4>
                                                    <div class="col-sm-6">
                                                        <div class="input-block mb-3">
                                                            <label class="col-form-label">Full Name <span class="text-danger">*</span></label>
                                                            <input class="form-control" type="text" id="fullName" value="<?php echo $name; ?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="input-block mb-3">
                                                            <label class="col-form-label">Date of Birth <span class="text-danger">*</span></label>
                                                            <input class="form-control" type="date" id="birth_date" value="<?php echo $date_of_birth; ?>" max="<?php echo $ageLimit; ?> ">
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6 " style="display: flex; justify-content: space-between; ">
                                                        <div class="input-block mb-3 col-sm-2">
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
                                                        <div class="input-block mb-3 col-sm-9">
                                                            <label class="col-form-label">Contact Number <span class="text-danger">*</span></label>
                                                            <input class="form-control" type="number" id="contact" value="<?php echo $contact; ?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="input-block mb-3">
                                                            <label class="col-form-label">Email <span class="text-danger">*</span></label>
                                                            <input class="form-control" type="email" id="email" value="<?php echo $email; ?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">  
                                                        <div class="input-block mb-3">
                                                            <label class="col-form-label">Address <span class="text-danger">*</span></label>
                                                            <input type="text" class="form-control" id="address" value="<?php echo $address; ?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label class="col-form-label">Gender <span class="text-danger">*</span></label>
                                                            <div class="form-control mt-1">
                                                                <label class="radio-inline ms-3"><input type="radio" name="gender" class="gender" id="test1" value="male" <?php if($gender == "male"){ echo "checked"; } ?>>&nbsp;&nbsp;&nbsp;Male</label>
                                                                <label class="radio-inline ms-3"><input type="radio" name="gender" class="gender" id="test2" value="female" <?php if($gender == "female"){ echo "checked"; } ?>>&nbsp;&nbsp;&nbsp;Female</label>
                                                                <label class="radio-inline ms-3"><input type="radio" name="gender" class="gender" id="test3" value="others" <?php if($gender == "others"){ echo "checked"; } ?>>&nbsp;&nbsp;&nbsp;Other</label>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Employment Details -->
                                                    <h4 class="my-2">Employment Details</h4>
                                                    <div class="col-sm-6">  
                                                        <div class="input-block mb-3">
                                                            <label class="col-form-label">Joining Date <span class="text-danger">*</span></label>
                                                            <input class="form-control" type="date" id="joining_date" value="<?php echo $date_of_joining; ?>" max="<?php echo $today; ?>" min="<?php echo $ageLimit; ?> ">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="input-block mb-3">
                                                            <label class="col-form-label">Department <span class="text-danger">*</span></label>
                                                            <select class="form-select" id="department">
                                                                <option value="<?php echo $department_id;?>"><?php echo $department_name.' (Already Selected)' ; ?></option>
                                                                <!-- <?php
                                                                    require '../connect.php';
                                                                    $sql = "SELECT * FROM `department` WHERE status ='1' ";
                                                                    $stmt = $conn->prepare($sql);
                                                                    $stmt -> execute();
                                                                    $stmt -> setFetchMode(PDO::FETCH_ASSOC);
                                                                    if($stmt-> rowCount()>0 ){
                                                                        foreach( ($stmt -> fetchAll()) as $key => $row ){
                                                                            echo'
                                                                                <option value="'.$row['id'].'">'.$row['dept_name'].'</option>
                                                                            ';
                                                                        }
                                                                    }else{
                                                                        echo '<option value="">Department not available</option>'; 
                                                                    }
                                                                ?> -->
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="input-block mb-3">
                                                            <label class="col-form-label">Designation <span class="text-danger">*</span></label>
                                                            <select class="form-select" id="designation">
                                                                <option value="<?php echo $designation_id;?>"><?php echo $designation_name.' (Already Selected)' ; ?></option>
                                                                <!-- <?php
                                                                    require '../connect.php';
                                                                    $sql = "SELECT * FROM `designation` WHERE status ='1' ";
                                                                    $stmt = $conn->prepare($sql);
                                                                    $stmt -> execute();
                                                                    $stmt -> setFetchMode(PDO::FETCH_ASSOC);
                                                                    if($stmt-> rowCount()>0 ){
                                                                        foreach( ($stmt -> fetchAll()) as $key => $row ){
                                                                            echo'
                                                                                <option value="'.$row['id'].'">'.$row['designation_name'].'</option>
                                                                            ';
                                                                        }
                                                                    }else{
                                                                        echo '<option value="">Designation not available</option>'; 
                                                                    }
                                                                ?> -->
                                                            </select>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="col-md-6">
                                                        <div class="input-block mb-3">
                                                            <label class="col-form-label">Zone <span class="text-danger">*</span></label>
                                                            <select class="form-select" id="zone">
                                                                <option value="<?php echo $zone_id;?>"><?php echo $zone_name.' (Already Selected)' ; ?></option>
                                                                <?php
                                                                    require '../connect.php';
                                                                    $sql = "SELECT * FROM `zone` WHERE status ='1' ";
                                                                    $stmt = $conn->prepare($sql);
                                                                    $stmt -> execute();
                                                                    $stmt -> setFetchMode(PDO::FETCH_ASSOC);
                                                                    if($stmt-> rowCount()>0 ){
                                                                        foreach( ($stmt -> fetchAll()) as $key => $row ){
                                                                            echo'
                                                                                <option value="'.$row['id'].'">'.$row['zone_name'].'</option>
                                                                            ';
                                                                        }
                                                                    }else{
                                                                        echo '<option value="">Zone not available</option>'; 
                                                                    }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="input-block mb-3">
                                                            <label class="col-form-label">Branch <span class="text-danger">*</span></label>
                                                            <select class="form-select" id="branch">
                                                                <option value="<?php echo $branch_id; ?>"> <?php echo $branch_name.' (Already Selected)' ; ?> </option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="input-block mb-3">
                                                            <label class="col-form-label">Reporting Manager <span class="text-danger">*</span></label>
                                                            <select class="form-select" id="reporting_manager">
                                                                <option value="<?php echo $reporting_manager_id ; ?>"> <?php echo $reporting_manager_name.' (Already Selected)' ; ?> </option>
                                                                    <!-- <?php 
                                                                        // require '../connect.php';
                                                                        $sql = "SELECT * FROM `employees` WHERE status ='1' ";
                                                                        $stmt = $conn->prepare($sql);
                                                                        $stmt -> execute();
                                                                        $stmt -> setFetchMode(PDO::FETCH_ASSOC);
                                                                        if($stmt-> rowCount()>0 ){
                                                                            foreach( ($stmt -> fetchAll()) as $key => $row ){
                                                                                echo'
                                                                                    <option value="'.$row['employee_id'].'">'.$row['name'].'</option>
                                                                                ';
                                                                            }
                                                                        }else{
                                                                            echo '<option value="">Manager not available</option>'; 
                                                                        }	
                                                                    ?> -->
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <!-- Attachments -->
                                                    <h4 class="my-2">Attachments</h4>
                                                    <div class="col-sm-6">  
                                                        <div class="input-block mb-3">
                                                            <label class="col-form-label">Profile Picture
                                                            <?php
                                                                if ($profile_pic) {
                                                                    
                                                            ?>
                                                                <a href="<?php echo '../uploading/' . $profile_pic; ?>" download class="ms-3" title="Download">
                                                                    <i class="fa fa-download fa-1x" aria-hidden="true"></i>
                                                                </a>
                                                            <?php
                                                                }
                                                            ?>
                                                            </label>
                                                            <input class="form-control" type="file" id="profile_pic">
                                                        </div>
                                                        <input type="hidden" id="img_path1" value="<?php echo $profile_pic; ?>">
                                                        <div id="preview1" >
                                                            <div id="image_preview1">
                                                                <?php
                                                                    if($profile_pic ==''){
                                                                        echo '<img src="../uploading/not_uploaded.png" alt="Preview" id="img_pre1" class="imgSize">';
                                                                    }else{
                                                                        echo '<img src="../uploading/'.$profile_pic.'" alt="Preview" id="img_pre1" class="imgSize">';
                                                                    }
                                                                ?>
                                                            </div>
                                                        </div>
                                                    </div> 
                                                    <div class="col-sm-6">  
                                                        <div class="input-block mb-3">
                                                            <label class="col-form-label">ID Proof (Aadhaar/PAN/Passport)
                                                            <?php
                                                                if ($id_proof) {
                                                                    
                                                            ?>
                                                                <a href="<?php echo '../uploading/' . $id_proof; ?>" download class="ms-3" title="Download">
                                                                    <i class="fa fa-download fa-1x" aria-hidden="true"></i>
                                                                </a>
                                                            <?php
                                                                }
                                                            ?>
                                                            </label>
                                                            <input class="form-control" type="file" id="id_proof">
                                                        </div>
                                                        <input type="hidden" id="img_path2" value="<?php echo $id_proof; ?>">
                                                        <div id="preview2">
                                                            <div id="image_preview2">
                                                                <?php
                                                                    if($id_proof ==''){
                                                                        echo '<img src="../uploading/not_uploaded.png" alt="Preview" id="img_pre2" class="imgSize">';
                                                                    }else{
                                                                        echo '<img src="../uploading/'.$id_proof.'" alt="Preview" id="img_pre2" class="imgSize">';
                                                                    }
                                                                ?>
                                                            </div>
                                                        </div>
                                                    </div> 
                                                    <div class="col-sm-6">  
                                                        <div class="input-block mb-3">
                                                            <label class="col-form-label">Bank Details for Salary Transfer
                                                            <?php
                                                                if ($bank_details) {
                                                                    
                                                            ?>
                                                                <a href="<?php echo '../uploading/' . $bank_details; ?>" download class="ms-3" title="Download">
                                                                    <i class="fa fa-download fa-1x" aria-hidden="true"></i>
                                                                </a>
                                                            <?php
                                                                }
                                                            ?>
                                                            </label>
                                                            <input class="form-control" type="file" id="bank_details">
                                                        </div>
                                                        <input type="hidden" id="img_path3" value="<?php echo $bank_details; ?>">
                                                        <div id="preview3">
                                                            <div id="image_preview3">
                                                                <?php
                                                                    if($bank_details ==''){
                                                                        echo '<img src="../uploading/not_uploaded.png" alt="Preview" id="img_pre3" class="imgSize">';
                                                                    }else{
                                                                        echo '<img src="../uploading/'.$bank_details.'" alt="Preview" id="img_pre3" class="imgSize">';
                                                                    }
                                                                ?>
                                                            </div>
                                                        </div>
                                                    </div> 
                                                </div>
                                                <!-- for edit data page -->
                                                <input type="hidden" id="testValue" name="testValue" value="2425"> <!-- BCM/BDM -->
                                                <!-- new added 14-06-2025 -->
                                                <input type="hidden" id="userType" name="userType" value="<?php echo $userType; ?>"> <!-- 24,25,26 -->
											    <input type="hidden" id="userId" name="userId" value="<?php echo $userId; ?>"> <!-- BH250001, BM250001 -->
                                                
                                                <input type="hidden" id="ref_id" name="ref_id" value="<?php echo $reporting_manager_id;?>">
                                                <input type="hidden" id="editfor" name="editfor" value="<?php echo $editfor;?>">
                                                <input type="hidden" id="empID" name="empID" value="<?php echo $id; ?>"> <!-- Emp ID edit ref -->
                                                <div class="submit-section d-flex justify-content-center mb-4">
                                                    <button class="btn btn-primary submit-btn submit-btn1 px-5 py-2" id="edit_bdm">Submit</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> <!-- container-fluid -->
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
            </div><!-- end main content-->
        </div><!-- END layout-wrapper -->

        <!--start back-to-top-->
        <button onclick="topFunction()" class="scrollToTop scroll-btn show btn" id="back-to-top">
            <i class="ri-arrow-up-line"></i>
        </button>
        <!--end back-to-top-->
        
        <!-- JAVASCRIPT -->
        <script src="assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="assets/libs/simplebar/simplebar.min.js"></script>
        <script src="assets/libs/node-waves/waves.min.js"></script>
        <script src="assets/libs/feather-icons/feather.min.js"></script>
        <!-- <script src="assets/js/pages/plugins/lord-icon-2.1.0.js"></script> -->
        <!-- <script src="assets/js/plugins.js"></script> -->
        <!-- jquery -->
        <script src="assets/js/jquery/jquery-3.7.1.min.js"></script>

        <script src="assets/js/submitdata.js"></script>
        
        <!-- !-- materialdesign icon js- -->
        <script src="assets/js/pages/remix-icons-listing.js"></script>

        <!-- apexcharts -->
        <script src="assets/libs/apexcharts/apexcharts.min.js"></script>

        <!-- Vector map-->
        <script src="assets/libs/jsvectormap/js/jsvectormap.min.js"></script>
        <script src="assets/libs/jsvectormap/maps/world-merc.js"></script>

        <!--Swiper slider js-->
        <script src="assets/libs/swiper/swiper-bundle.min.js"></script>

        <!-- Dashboard init -->
        <!-- <script src="assets/js/pages/dashboard-ecommerce.init.js"></script> -->

        <!-- App js -->
        <script src="assets/js/app.js"></script>

        <!-- file upload code js file -->
        <script src="../uploading/uploadUser.js"></script>

        <!-- Chart JS -->
        <!-- <script src="assets/libs/chart.js/chart.umd.js"></script> -->

        <!-- chartjs init -->
        <!-- <script src="assets/js/pages/chartjs.init.js"></script> -->

         <!-- Dashboard init -->
         <!-- <script src="assets/js/pages/dashboard-job.init.js"></script> -->
         <!-- ** designation user, user name on designation select / get country, state, city, pincode **  -->
        <script>

            // on zone change get branch associated with that zone
			$('#zone').on('change', function(){
				var zone_id = $(this).val();
				$.ajax({
					url: 'assets/get_data/get_branch.php',
					type: 'POST',
					data: {zone_id:zone_id},
					success: function(data){
						$('#branch').html(data);
					}
				});
			});
            // $(document).ready(function(){
            //     var paymentMode = $(".payment:checked").val();
            //     if(paymentMode == "cheque"){
            //         $("#chequeOpt").removeClass("d-none");
            //         $("#onlineOpt").addClass("d-none");
            //     }else if(paymentMode == "online"){
            //         $("#onlineOpt").removeClass("d-none");
            //         $("#chequeOpt").addClass("d-none");
            //     } else {
            //         $("#chequeOpt").addClass("d-none");
            //         $("#onlineOpt").addClass("d-none");
            //     }
            // });
            //select Designation
            // $('#designation').on('change', function() {
            //     var designation = $('#designation').val();
            //     // console.log(designation);
            //     $.ajax({
            //         type:'POST',
            //         url:'agents/get_user_Franchisee.php',
            //         data: "designation="+designation,
            //         success:function (e) {
            //             // console.log(e);
            //             $('#user_id_name').html(e); 
            //         },
            //         error: function(err){
            //             console.log(err);
            //         },
            //     });
            // });

            // fetch User based on selected designation
            // $('#user_id_name').on('change', function(){
            //     var user_id_name = $(this).val();
            //     // console.log(user_id_name);

            //     var designation = $('#designation').val();
            //     // console.log(designation);

            //     $.ajax({
            //         type:'POST',
            //         url:'agents/getUsers.php',
            //         data: 'user_id_name=' + user_id_name + '&designation=' + designation ,
            //         success:function(response){
            //         // console.log(response);
            //             // $('#pin').html(response);
            //             $('#reference_name').val(response); 
            //         }
            //     }); 
               
            // }); 

            // $('#country').on('change', function(){
            //     var countryID = $(this).val();
            //     if(countryID){
            //         $.ajax({
            //             type:'POST',
            //             url:'address/countrydata.php',
            //             data:'country_id='+countryID,
            //             success:function(htmll){
            //                 $('#mystate').html(htmll); 
            //                 $('#city').html('<option value="">Select state first</option>'); 
            //             }
            //         }); 
            //     }else{
            //         $('#mystate').html('<option value="">Select country first</option>');
            //         $('#city').html('<option value="">Select state first</option>');
            //         $('#pin').val('');   
            //     }
            // });
                
            // $('#mystate').on('change', function(){
            //     // alert();
            //     var stateID = $(this).val();
            //     if(stateID){
            //         $.ajax({
            //             type:'POST',
            //             url:'address/countrydata.php',
            //             data:'state_id='+stateID,
            //             success:function(html){
            //                 $('#city').html(html);
            //             }
            //         }); 
            //     }else{
            //         $('#city').html('<option value="">Select state first</option>');
            //         $('#pin').val('');   
            //     }
            // });

            // $('#city').on('change', function(){
            //     var cityID = $(this).val();
            //     if(cityID){
            //         $.ajax({
            //             type:'POST',
            //             url:'address/pincode.php',
            //             data:'city_id='+cityID,
            //             success:function(response){
            //                 // $('#pin').html(response);
            //                 $('#pin').val(response); 
            //             }
            //         }); 
            //     }else{
            //         $('#city').html('<option value="">Select state first</option>');
            //         $('#pin').val('');
            //     }
            // });

            // $('#paymentMode').on('click', function(){
            //     var paymentMode = $(".payment:checked").val();
            //     // console.log(paymentMode);
            //     if(paymentMode == "cheque"){
            //         $("#chequeOpt").removeClass("d-none");
            //         $("#onlineOpt").addClass("d-none");
            //     }else if(paymentMode == "online"){
            //         $("#onlineOpt").removeClass("d-none");
            //         $("#chequeOpt").addClass("d-none");
            //     } else {
            //         $("#chequeOpt").addClass("d-none");
            //         $("#onlineOpt").addClass("d-none");
            //     }
            // });
        </script>
    </body>
</html>