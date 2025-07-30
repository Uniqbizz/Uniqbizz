<?php
    session_start();

    if(!isset($_SESSION['username'])){
        echo '<script>location.href = "../login.php";</script>';
    }

    require '../connect.php';
    $date = date('Y'); 
?>
<!doctype html>
<html lang="en">

    <head>
        
        <meta charset="utf-8" />
        <title>Business Operation Executive Add | Admin Dashboard </title>
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
        <link rel="stylesheet" href="../assets/css/loadingScreen.css" rel="stylesheet" type="text/css" />
        <!-- App js -->
        <!-- <script src="../assets/js/plugin.js"></script> -->

        <!-- Plugins css -->
        <!-- <link href="../assets/libs/dropzone/dropzone.css" rel="stylesheet" type="text/css" /> -->

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
                include_once '../header.php';

                // sidebar navigation menu 
                include_once '../sidebar.php';
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
                                    <h4 class="mb-sm-0 font-size-18">Business Mentor</h4>

                                    <!-- <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboards</a></li>
                                            <li class="breadcrumb-item active">Dashboard</li>
                                        </ol>
                                    </div> -->

                                </div>
                            </div>
                        </div>

                        <!-- add customer form start -->
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
										<form>
											<h3 class="m-4">Add Employee</h3>
											<div class="row m-4">
												<!-- Personal Details -->
												<h4 class="mb-2">Personal Details</h4>
												<div class="col-sm-6">
													<div class="input-block mb-3">
														<label class="col-form-label">Full Name <span class="text-danger">*</span></label>
														<input class="form-control" type="text" id="fullName" >
													</div>
												</div>
												<div class="col-sm-6">
													<div class="input-block mb-3">
														<label class="col-form-label">Date of Birth <span class="text-danger">*</span></label>
														<input class="form-control" type="date" id="birth_date">
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
														<input class="form-control" type="number" id="contact">
													</div>
												</div>
												<div class="col-sm-6">
													<div class="input-block mb-3">
														<label class="col-form-label">Email <span class="text-danger">*</span></label>
														<input class="form-control" type="email" id="email">
													</div>
												</div>
												<div class="col-sm-6">  
													<div class="input-block mb-3">
														<label class="col-form-label">Address <span class="text-danger">*</span></label>
														<input type="text" class="form-control" id="address">
													</div>
												</div>
												<div class="col-sm-6">
													<div class="form-group">
														<label class="col-form-label">Gender <span class="text-danger">*</span></label>
														<div class="form-control mt-1">
															<label class="radio-inline ms-3"><input type="radio" name="gender" class="gender" id="test1" value="male">&nbsp;&nbsp;&nbsp;Male</label>
															<label class="radio-inline ms-3"><input type="radio" name="gender" class="gender" id="test2" value="female">&nbsp;&nbsp;&nbsp;Female</label>
															<label class="radio-inline ms-3"><input type="radio" name="gender" class="gender" id="test3" value="others">&nbsp;&nbsp;&nbsp;Other</label>
														</div>
													</div>
												</div>

												<!-- Employment Details -->
												<h4 class="my-2">Employment Details</h4>
												<div class="col-sm-6">  
													<div class="input-block mb-3">
														<label class="col-form-label">Joining Date <span class="text-danger">*</span></label>
														<input class="form-control" type="date" id="joining_date">
													</div>
												</div>
												<div class="col-md-6">
													<div class="input-block mb-3">
														<label class="col-form-label">Department <span class="text-danger">*</span></label>
														<select class="form-select" id="department">
															<option value=""> ---- Select Department ---- </option>
															<?php
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
															?>
														</select>
													</div>
												</div>
												<div class="col-md-6">
													<div class="input-block mb-3">
														<label class="col-form-label">Designation <span class="text-danger">*</span></label>
														<select class="form-select" id="designation">
															<option value=""> ---- Select Designation ---- </option>
															<?php
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
																	echo '<option value="">Department not available</option>'; 
																}
															?>
														</select>
													</div>
												</div>
												
												<div class="col-md-6">
													<div class="input-block mb-3">
														<label class="col-form-label">Zone <span class="text-danger">*</span></label>
														<select class="form-select" id="zone">
															<option value=""> ---- Select Zone ---- </option>
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
																	echo '<option value="">Department not available</option>'; 
																}
															?>
														</select>
													</div>
												</div>
												<div class="col-md-6">
													<div class="input-block mb-3">
														<label class="col-form-label">Branch <span class="text-danger">*</span></label>
														<select class="form-select" id="branch">
															<option value=""> ---- Select Zone First ---- </option>
														</select>
													</div>
												</div>
												<div class="col-md-6">
													<div class="input-block mb-3">
														<label class="col-form-label">Reporting Manager <span class="text-danger">*</span></label>
														<select class="form-select" id="reporting_manager">
															<option value=""> ---- Select Manager ---- </option>
																<?php 
																	// require '../connect.php';
																	$sql = "SELECT * FROM `employees` WHERE user_type = '24' AND status ='1' ";
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
																?>
														</select>
													</div>
												</div>

												<!-- Attachments -->
												<h4 class="my-2">Attachments</h4>
												<div class="col-sm-6">  
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
												<div class="col-sm-6">  
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
												<div class="col-sm-6">  
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


                <footer class="footer">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-sm-6">
                                <?php echo $date; ?> © Uniqbizz.
                            </div>
                            <div class="col-sm-6">
                                <div class="text-sm-end d-none d-sm-block">
                                    Design & Develop by MirthCon
                                </div>
                            </div>
                        </div>
                    </div>
                </footer>
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

        <!-- add data to database js file -->
        <script type="text/javascript" src="../assets/js/submitdata.js"></script>

        <!-- apexcharts -->
        <!-- <script src="../assets/libs/apexcharts/apexcharts.min.js"></script> -->

        <!-- dashboard init -->
        <!-- <script src="assets/js/pages/dashboard.init.js"></script> -->

        <!-- App js -->
        <script src="../assets/js/app.js"></script>

        <!-- file upload code js file -->
        <script src="../../uploading/upload.js"></script>
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
            //select Designation
            // $('#designation').on('change', function() {
            //     var designation = $('#designation').val();
            //     // console.log(designation);
            //     $.ajax({
            //         type:'POST',
            //         url:'../agents/get_user_Franchisee.php',
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
            $('#user_id_name').on('change', function(){
                var user_id_name = $(this).val();
                var designation = 'ca_franchisee';
                // console.log(user_id_name);

                // var designation = 'travel_agent';
                // console.log(designation);

                $.ajax({
                    type:'POST',
                    url:'../agents/getUsers.php',
                    data: 'user_id_name=' + user_id_name + '&designation=' + designation ,
                    success:function(response){
                    // console.log(response);
                        // $('#pin').html(response);
                        $('#reference_name').val(response); 
                    }
                }); 
               
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

            // $('#business_package_amount').on('change', function(){
            //     var business_package_amount = $(this).val();
            //     $('#flex_amount').val(business_package_amount);
            // });

            $('#paymentMode').on('click', function(){
                var paymentMode = $(".payment:checked").val();
                // console.log(paymentMode);
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
        
    </body>

</html>