<?php
session_start();

if (!isset($_SESSION['username'])) {
	echo '<script>location.href = "../login.php";</script>';
}

require '../connect.php';

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
	<title>Add Super Techno Enterprise | Admin Dashboard </title>
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
								<h4 class="mb-sm-0 font-size-18">Super Techno Enterprise</h4>
							</div>
						</div>
					</div>

					<!-- add customer form start -->
					<div class="row">
						<div class="col-12">
							<div class="card">
								<div class="card-body">
									<form>
										<h3>Add Super Techno Enterprise</h3>
										<div class="row">
											<!-- Personal Details -->
											<h4>Personal Details</h4>
											<div class="col-md-4 col-sm-12">
												<div class="input-block mb-3">
													<label class="col-form-label">Designation<span class="text-danger">*</span></label>
													<select id="designation" class="form-select">
														<option value="">--Select Designation--</option>
														<option value="executive_techno_enterprise">Executive Techno Enterprise</option>
													</select>
												</div>
											</div>
											<div class="form-group col-md-4 col-sm-12">
												<div class="input-block mb-3">
													<label class="col-form-label">User ID & Name<span class="text-danger">*</span></label>
													<select id="user_id_name" class="form-select">
														<option value="">--Select Designation First--</option>
													</select>
												</div>
											</div>
											<div class="col-md-4 col-sm-12">
												<div class="input-block mb-3">
													<label class="col-form-label">Referance Name<span class="text-danger">*</span></label>
													<input type="text" class="form-control" id="reference_name" placeholder="No Referance selected for the user" value="" readonly>
												</div>
											</div>
											<div class="col-md-6 col-sm-6">
												<div class="input-block mb-3">
													<label class="col-form-label">First Name <span class="text-danger">*</span></label>
													<input class="form-control" type="text" id="firstname">
												</div>
											</div>
											<div class="col-md-6 col-sm-6">
												<div class="input-block mb-3">
													<label class="col-form-label">Last Name <span class="text-danger">*</span></label>
													<input class="form-control" type="text" id="lastname">
												</div>
											</div>
											<div class="col-md-6 col-sm-6">
												<div class="input-block mb-3">
													<label class="col-form-label">Father / Spouse Name <span class="text-danger">*</span></label>
													<input class="form-control" type="text" id="father_spouse_name">
												</div>
											</div>
											<div class="col-md-6 col-sm-6">
												<div class="input-block mb-3">
													<label class="col-form-label">Email Address<span class="text-danger">*</span></label>
													<input class="form-control" type="email" id="email">
												</div>
											</div>
											<div class="col-md-6 col-sm-6">
												<div class="input-block mb-3">
													<label class="col-form-label">Date of Birth <span class="text-danger">*</span></label>
													<input class="form-control" type="date" id="dob" max="<?php echo $ageLimit; ?>">
												</div>
											</div>
											<div class="col-md-6 col-sm-12">
												<div class="form-group">
													<label class="col-form-label">Gender <span class="text-danger">*</span></label>
													<div class="form-control d-flex justify-content-around">
														<label class="radio-inline mb-0 ms-3"><input type="radio" name="gender" class="gender" id="test3" value="male">&nbsp;&nbsp;&nbsp;Male</label>
														<label class="radio-inline mb-0 ms-3"><input type="radio" name="gender" class="gender" id="test4" value="female">&nbsp;&nbsp;&nbsp;Female</label>
														<label class="radio-inline mb-0 ms-3"><input type="radio" name="gender" class="gender" id="test5" value="others">&nbsp;&nbsp;&nbsp;Other</label>
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
															<label class="col-form-label">Phone Number <span class="text-danger">*</span></label>
															<input class="form-control" type="number" id="phone" placeholder="Enter Phone Number">
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
														</div>
													</div>
													<div class="col-md-8 col-sm-8 col-9">
														<div class="input-block">
															<label class="col-form-label">Alt Phone Number <span class="text-danger">*</span></label>
															<input class="form-control" type="number" id="altPhone" placeholder="Enter Alternative Phone Number">
														</div>
													</div>
												</div>
											</div>
											<div class="col-md-6 col-sm-6">
												<div class="input-block mb-3">
													<label class="col-form-label">Aadhar No<span class="text-danger">*</span></label>
													<input class="form-control" type="text" id="aadharNo">
												</div>
											</div>
											<div class="col-md-6 col-sm-6">
												<div class="input-block mb-3">
													<label class="col-form-label">PAN No<span class="text-danger">*</span></label>
													<input class="form-control" type="text" id="panNo">
												</div>
											</div>

											<h3>Residential Address</h3>
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
											<div class="col-md-12 col-sm-12">
												<div class="input-block mb-3">
													<label class="col-form-label">Address<span class="text-danger">*</span></label>
													<input type="text" class="form-control" id="address" placeholder="Address">
												</div>
											</div>

											<h3>Professional Details</h3>
											<div class="col-md-6 col-sm-6">
												<div class="input-block mb-3">
													<label class="col-form-label">Current Occupation / Business<span class="text-danger">*</span></label>
													<input class="form-control" type="text" id="occupation">
												</div>
											</div>
											<div class="col-md-6 col-sm-6">
												<div class="input-block mb-3">
													<label class="col-form-label">Total Experience<span class="text-danger">*</span></label>
													<input class="form-control" type="text" id="experience">
												</div>
											</div>
											<div class="col-md-6 col-sm-6">
												<div class="input-block mb-3">
													<label class="col-form-label">Current Annual Income<span class="text-danger">*</span></label>
													<input class="form-control" type="text" id="annual_income">
												</div>
											</div>
											<div class="col-md-6 col-sm-12">
												<div class="form-group">
													<label class="col-form-label">Have You Managed teams Previously <span class="text-danger">*</span></label>
													<div class="form-control d-flex justify-content-around">
														<label class="radio-inline mb-0 ms-3"><input type="radio" name="teamManaged" class="teamManaged" id="teamManagedYes" value="yes">&nbsp;&nbsp;&nbsp;Yes</label>
														<label class="radio-inline mb-0 ms-3"><input type="radio" name="teamManaged" class="teamManaged" id="teamManagedNo" value="no">&nbsp;&nbsp;&nbsp;No</label>
													</div>
												</div>
											</div>
											<div class="col-md-6 col-sm-6">
												<div class="input-block mb-3">
													<label class="col-form-label">If Yes, Team size<span class="text-danger">*</span></label>
													<textarea class="form-control" id="teamSize" rows="4" cols="50"> </textarea>
												</div>
											</div>
											<div class="col-md-6 col-sm-6">
												<div class="input-block mb-3">
													<label class="col-form-label">
														Leadership Experience <span class="text-danger">*</span>
													</label>

													<div class="row mt-2">
														<!-- Left Column -->
														<div class="col-md-4">
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
														</div>

														<!-- Right Column -->
														<div class="col-md-8">
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
														</div>
														<input type="hidden" name="leadership_json" id="leadership_json">
													</div>
												</div>
											</div>

											<h4 class="my-2">Educational Details</h4>
											<div class="col-md-6 col-sm-6">
												<div class="input-block mb-3">
													<label class="col-form-label">Educational Qualification<span class="text-danger">*</span></label>
													<input class="form-control" type="text" id="qualification">
												</div>
											</div>

											<h4 class="my-2">Leadership Assessment</h4>
											<div class="col-md-4 col-sm-6">
												<div class="input-block mb-3">
													<label class="col-form-label">Why You want to become a Super Techno Enterprise?<span class="text-danger">*</span></label>
													<textarea class="form-control" id="career_objective" rows="4" cols="50"> </textarea>
												</div>
											</div>
											<div class="col-md-4 col-sm-6">
												<div class="input-block mb-3">
													<label class="col-form-label">
														Expected Team Building Capacity(Within 12 Months) <span class="text-danger">*</span>
													</label>
													
													<div class="row mt-2">
														<div class="col-md-6">
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

														</div>

														<!-- Right Column -->
														<div class="col-md-6">
															<div class="mb-2">
																<input type="radio" id="expected4" name="teamExpected" class="teamExpected" value="25+">
																<label for="expected4">25+ Techno Enterprise</label>
															</div>
														</div>
													</div>
												</div>
											</div>
											<div class="col-md-4 col-sm-6">
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

											<h4 class="my-2">Nominee Details</h4>
											<div class="col-md-6 col-sm-6">
												<div class="input-block mb-3">
													<label class="col-form-label">Nominee Name<span class="text-danger">*</span></label>
													<input class="form-control" type="text" id="nomineeName">
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
														</div>
													</div>
													<div class="col-md-8 col-sm-8 col-9">
														<div class="input-block">
															<label class="col-form-label">Nominee Phone Number <span class="text-danger">*</span></label>
															<input class="form-control" type="number" id="nomineePhone" placeholder="Enter Nominee Phone Number">
														</div>
													</div>
												</div>
											</div>
											<div class="col-md-6 col-sm-6">
												<div class="input-block mb-3">
													<label class="col-form-label">Date of Birth <span class="text-danger">*</span></label>
													<input class="form-control" type="date" id="nomineeDob" max="<?php echo $ageLimit; ?>">
												</div>
											</div>
											<div class="col-md-12 col-sm-6">
												<div class="input-block mb-3">
													<label class="col-form-label">Nominee Address<span class="text-danger">*</span></label>
													<input class="form-control" type="text" id="nomineeAddress">
												</div>
											</div>

											<h4 class="my-2">Bank Details</h4>
											<div class="col-md-6 col-sm-6">
												<div class="input-block mb-3">
													<label class="col-form-label">Account Holder Name<span class="text-danger">*</span></label>
													<input class="form-control" type="text" id="accHolderName">
												</div>
											</div>
											<div class="col-md-6 col-sm-6">
												<div class="input-block mb-3">
													<label class="col-form-label">Bank Name<span class="text-danger">*</span></label>
													<input class="form-control" type="text" id="bankName">
												</div>
											</div>
											<div class="col-md-6 col-sm-6">
												<div class="input-block mb-3">
													<label class="col-form-label">Account Number<span class="text-danger">*</span></label>
													<input class="form-control" type="text" id="accountNumber">
												</div>
											</div>
											<div class="col-md-6 col-sm-6">
												<div class="input-block mb-3">
													<label class="col-form-label">Confirm Account Number<span class="text-danger">*</span></label>
													<input class="form-control" type="text" id="confirmAccountNumber">
												</div>
											</div>
											<div class="col-md-6 col-sm-6">
												<div class="input-block mb-3">
													<label class="col-form-label">IFSC Code<span class="text-danger">*</span></label>
													<input class="form-control" type="text" id="ifscCode">
												</div>
											</div>
											<div class="col-md-6 col-sm-6">
												<div class="input-block mb-3">
													<label class="col-form-label">Branch Name<span class="text-danger">*</span></label>
													<input class="form-control" type="text" id="branchName">
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
													<label class="col-form-label">Cancelled Cheque / Bank Passbook</label>
													<input class="form-control" type="file" name="file4" id="upload_file4">
												</div>
												<input type="hidden" id="img_path4" value="">
												<div id="preview4" style="display: none;">
													<div id="image_preview4">
														<img alt="Preview" class="imgSize" id="img_pre4">
													</div>
												</div>
											</div>
											<div class="col-md-6 col-sm-6">
												<div class="input-block mb-3">
													<label class="col-form-label">Resume / CV</label>
													<input class="form-control" type="file" name="file5" id="upload_file5">
												</div>
												<input type="hidden" id="img_path5" value="">
												<div id="preview5" style="display: none;">
													<div id="image_preview5">
														<img alt="Preview" class="imgSize" id="img_pre5">
													</div>
												</div>
											</div>
											<div class="col-md-6 col-sm-6">
												<div class="input-block mb-3">
													<label class="col-form-label">Address Proof</label>
													<input class="form-control" type="file" name="file6" id="upload_file6">
												</div>
												<input type="hidden" id="img_path6" value="">
												<div id="preview6" style="display: none;">
													<div id="image_preview6">
														<img alt="Preview" class="imgSize" id="img_pre6">
													</div>
												</div>
											</div>
											<div class="col-md-6 col-sm-6">
												<div class="input-block mb-3">
													<label class="col-form-label">Professional Profile</label>
													<input class="form-control" type="file" name="file7" id="upload_file7">
												</div>
												<input type="hidden" id="img_path7" value="">
												<div id="preview7" style="display: none;">
													<div id="image_preview7">
														<img alt="Preview" class="imgSize" id="img_pre7">
													</div>
												</div>
											</div>
											<div class="col-md-6 col-sm-6">
												<div class="input-block mb-3">
													<label class="col-form-label">Business Profile</label>
													<input class="form-control" type="file" name="file8" id="upload_file8">
												</div>
												<input type="hidden" id="img_path8" value="">
												<div id="preview8" style="display: none;">
													<div id="image_preview8">
														<img alt="Preview" class="imgSize" id="img_pre8">
													</div>
												</div>
											</div>
											<div class="col-md-6 col-sm-6">
												<div class="input-block mb-3">
													<label class="col-form-label">Income Proof</label>
													<input class="form-control" type="file" name="file9" id="upload_file9">
												</div>
												<input type="hidden" id="img_path9" value="">
												<div id="preview9" style="display: none;">
													<div id="image_preview9">
														<img alt="Preview" class="imgSize" id="img_pre9">
													</div>
												</div>
											</div>
											<div class="col-md-6 col-sm-6">
												<div class="input-block mb-3">
													<label class="col-form-label">Other Document</label>
													<input class="form-control" type="file" name="file10" id="upload_file10">
												</div>
												<input type="hidden" id="img_path10" value="">
												<div id="preview10" style="display: none;">
													<div id="image_preview10">
														<img alt="Preview" class="imgSize" id="img_pre10">
													</div>
												</div>
											</div>

										</div>
										<input type="hidden" id="testValue" name="testValue" value="35"> <!-- Super TE -->
										<div class="d-flex justify-content-center mb-4">
											<button type="submit" class="btn btn-primary px-5 py-2" id="addSuperTechnoEnterprise">Submit</button>
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


			<?php include_once "../footer.php" ?>
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
	<script type="text/javascript" src="super_techno_enterprise.js"></script>

	<!-- App js -->
	<script src="../assets/js/app.js"></script>

	<!-- upload js file made only for CTE,ETE and STE users -->
	<script src="../../uploading/uploadTechnoAdmin.js"></script>

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
		});
	</script>

	<!-- ** designation user, user name on designation select / get country, state, city, pincode **  -->
	<script>
		
		//select Designation
		$('#designation').on('change', function() {
			var designation = $('#designation').val();
			// console.log(designation);
			$.ajax({
				type: 'POST',
				url: '../agents/get_user_Franchisee.php',
				data: "designation=" + designation,
				success: function(e) {
					// console.log(e);
					$('#user_id_name').html(e);
				},
				error: function(err) {
					console.log(err);
				},
			});
		});

		// fetch User based on selected designation
		$('#user_id_name').on('change', function() {
			var user_id_name = $(this).val();
			var designation = $('#designation').val();
			$.ajax({
				type: 'POST',
				url: '../agents/getUsers.php',
				data: 'user_id_name=' + user_id_name + '&designation=' + designation,
				success: function(response) {
					$('#pin').html(response);
					$('#reference_name').val(response);
				}
			});

		});

		$('#country').on('change', function() {
			var countryID = $(this).val();
			if (countryID) {
				$.ajax({
					type: 'POST',
					url: '../address/countrydata.php',
					data: 'country_id=' + countryID,
					success: function(htmll) {
						$('#mystate').html(htmll);
						$('#city').html('<option value="">Select state first</option>');
					}
				});
			} else {
				$('#mystate').html('<option value="">Select country first</option>');
				$('#city').html('<option value="">Select state first</option>');
				$('#pin').val('');
			}
		});

		$('#mystate').on('change', function() {
			var stateID = $(this).val();
			if (stateID) {
				$.ajax({
					type: 'POST',
					url: '../address/countrydata.php',
					data: 'state_id=' + stateID,
					success: function(html) {
						$('#city').html(html);
					}
				});
			} else {
				$('#city').html('<option value="">Select state first</option>');
				$('#pin').val('');
			}
		});

		$('#city').on('change', function() {
			var cityID = $(this).val();
			if (cityID) {
				$.ajax({
					type: 'POST',
					url: '../address/pincode.php',
					data: 'city_id=' + cityID,
					success: function(response) {
						$('#pin').val(response);
					}
				});
			} else {
				$('#city').html('<option value="">Select state first</option>');
				$('#pin').val('');
			}
		});

		$("#lead6").change(function () {

			if ($(this).is(":checked")) {
				$("#otherLead").slideDown();
			} else {
				$("#otherLead").slideUp();
				$("#otherLead").val("");
			}

		});
	</script>
</body>

</html>