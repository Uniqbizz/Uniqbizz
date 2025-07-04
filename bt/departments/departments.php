<?php
session_start();

if(!isset($_SESSION['username'])){
    echo '<script>location.href = "../login.php";</script>';
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Departments</title>
        <!-- App favicon -->
        <link rel="shortcut icon" href="../assets/images/fav.png">
        <!-- custom css file -->
        <!-- <link href="../assets/css/styles.css" rel="stylesheet" type="text/css" /> -->
        <!-- Bootstrap Css -->
        <link href="../assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
        <!-- Icons Css -->
        <link href="../assets/css/icons.min.css" rel="stylesheet" type="text/css" />
        <!-- App Css-->
        <link href="../assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />
        <!-- App js -->
        <!-- <script src="assets/js/plugin.js"></script> --> 
        <!-- DataTables -->
        <link href="../assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />

        <!-- Responsive datatable examples -->
        <link href="../assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />  
        
    </head>
    <body data-sidebar="dark">
        <div class="layout-wrapper">
            <?php 
                // top header logo, hamberger menu, fullscreen icon, profile
                include_once '../header.php';

                // sidebar navigation menu 
                include_once '../sidebar.php';
            ?>
            <div class="layout-wrapper">
                <div class="main-content">
                    <div class="page-content">
                        <div class="container-fluid">
                            <div class="text-end p-3">
                                <!-- return previous page link -->
                                <li class=" badge badge-pill p-2" id="return_to_views_btn" style="width:fit-content; background-color: #0036a2"><a href="../index.php" class="text-white"><i class="fa fa-backward text-white" aria-hidden="true"></i> Back</a></li>
                            </div>  
                            <div class="row">
                                <div class="card">
                                    <div class="col-lg-12 pb-3 pt-3 mb-4" style="border-bottom: 1px solid #DDDDDD">
										<div class="row d-flex justify-content-between">
											<div class="col-lg-3 col-md-4 col-sm-4 col-12">
												<h5 class="mt-3 fw-bold fs-3 text-center">Departments</h5>
											</div>
											<div class="col-lg-3 col-md-4 col-sm-4 col-12">
												<div class="subheader-right text-center">
													<a href="#" class="btn add-btn btn-primary submit-btn submit-btn1 px-2 py-2" data-bs-toggle="modal" data-bs-target="#add_department"><i class="mdi mdi-plus-circle-outline"></i> Add Department</a>
													<!-- <button class="btn btn-primary submit-btn submit-btn1 px-5 py-2" id="add_employee">Submit</button> -->
												</div>
											</div>
										</div>  
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="table-responsive table-desi">
                                            <!-- table roe limit -->
                                        
                                            <table class="table custom-table mb-0 datatable" id="user_table">
												<thead>
													<tr>
														<th class="width-thirty">#</th>
														<th>Department Name</th>
														<th class="text-end">Action</th>
													</tr>
												</thead>
												<tbody>

													<?php
														require '../connect.php';
														$srno = 1;
														$sql = "SELECT * FROM `department` WHERE status = '1' ";
														$stmt = $conn->prepare($sql);
														$stmt -> execute();
														$stmt -> setFetchMode(PDO::FETCH_ASSOC);
														if($stmt -> rowCount()>0){
															foreach( ($stmt -> fetchAll()) as $key => $row ){
																echo'
																	<tr>
																		<td>'.$srno.'</td>
																		<td>'.$row['dept_name'].'</td>
																		<td class="text-end">
																			<div class="dropdown dropdown-action">
																					<a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="mdi mdi-dots-vertical fs-4 text-dark"></i></a>
																				<div class="dropdown-menu dropdown-menu-right">
																					<a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#edit_department" onclick=\'saveDept(" '.$row['id'].' "," '.$row['dept_name'].' "," edit "," '.$row['status'].' ")\'><i class="mdi mdi-pencil font-size-16 text-primary me-1"></i> Edit</a>
																					<a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#delete_department" onclick=\'deleteDept(" '.$row['id'].' "," '.$row['dept_name'].' "," delete "," 0 ")\'><i class="mdi mdi-trash-can font-size-16 text-danger me-1"></i> Delete</a>
																				</div>
																			</div>
																		</td>
																	</tr>
																';
																$srno++;
															}
														}
													?>

												</tbody>
											</table>
                                            <!-- pegination start -->
                                            <div class="center text-center" id="pagination_row"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
							<!-- Designation -->
							<div class="row">
                                <div class="card">
                                    <div class="col-lg-12 pb-3 pt-3 mb-4" style="border-bottom: 1px solid #DDDDDD">
										<div class="row d-flex justify-content-between">
											<div class="col-lg-3 col-md-4 col-sm-4 col-12">
												<h5 class="mt-3 fw-bold fs-3 text-center">Designation</h5>
											</div>
											<div class="col-lg-3 col-md-4 col-sm-4 col-12">
												<div class="subheader-right text-center">
													<a href="#" class="btn add-btn btn-primary submit-btn submit-btn1 px-2 py-2" data-bs-toggle="modal" data-bs-target="#add_designation"><i class="mdi mdi-plus-circle-outline"></i> Add Designation</a>
													<!-- <button class="btn btn-primary submit-btn submit-btn1 px-5 py-2" id="add_employee">Submit</button> -->
												</div>
											</div>
										</div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="table-responsive table-desi">
                                            <!-- table roe limit -->
											<table class="table custom-table mb-0 datatable" id="user_table1">
												<thead>
													<tr>
														<th class="width-thirty">#</th>
														<th>Designation </th>
														<th>Department </th>
														<th class="text-end">Action</th>
													</tr>
												</thead>
												<tbody>
													<?php
														require '../connect.php';
														$srno = '1';
														$stmt2 = $conn->prepare(" SELECT * FROM `designation` WHERE status='1' ");
														$stmt2 -> execute();
														$stmt2 -> setFetchMode(PDO::FETCH_ASSOC);
														if( $stmt2 -> rowCount()>0 ){
															foreach( ( $stmt2 -> fetchALL() ) as $key2 => $row2 ){
																echo'
																	<tr>
																		<td>'.$srno.'</td>
																		<td>'.$row2['designation_name'].'</td>
																		<td>'.$row2['dept_name'].'</td>
																		<td class="text-end">
																			<div class="dropdown dropdown-action">
																				<a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="mdi mdi-dots-vertical fs-4 text-dark"></i></a>
																				<div class="dropdown-menu dropdown-menu-end">
																					<a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#edit_designation" onclick=\'saveDesig(" '.$row2['id'].' "," '.$row2['designation_name'].' "," '.$row2['dept_id'].' "," '.$row2['dept_name'].' "," edit "," '.$row2['status'].' ")\'><i class="mdi mdi-pencil font-size-16 text-primary me-1"></i> Edit</a>
																					<a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#delete_designation" onclick=\'deleteDesig(" '.$row2['id'].' "," '.$row2['designation_name'].' "," '.$row2['dept_id'].' "," '.$row2['dept_name'].' "," delete "," 0 ")\'><i class="mdi mdi-trash-can font-size-16 text-danger me-1"></i> Delete</a>
																				</div>
																			</div>
																		</td>
																	</tr>
																';
																$srno++;
															}
														}
													?>
													
												</tbody>
											</table>
                                            <!-- pegination start -->
                                            <div class="center text-center" id="pagination_row"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
					
					<!-- Designation PopUp start -->
						<!-- Add Designation Modal -->
						<div id="add_designation" class="modal custom-modal fade" role="dialog">
							<div class="modal-dialog modal-dialog-centered" role="document">
								<div class="modal-content">
									<div class="modal-header">
										<h5 class="modal-title">Add Designation</h5>
										<button type="button" class="btn-close" data-bs-dismiss="modalAdd" aria-label="Close">
											<!-- <span aria-hidden="true">&times;</span> -->
										</button>
									</div>
									<div class="modal-body">
										<form>
											<div class="input-block mb-3">
												<label class="col-form-label">Designation Name <span class="text-danger">*</span></label>
												<input class="form-control" type="text" id="desig_name">
											</div>
											<div class="input-block mb-3">
												<label class="col-form-label">Department <span class="text-danger">*</span></label>
												<select class="form-select" id="dept_id">
													<option value="">Select Department</option>
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
											<div class="submit-section d-flex justify-content-center align-items-center mt-4 mb-2">
												<button class="btn btn-primary submit-btn" id="submitAdd">Submit</button>
											</div>
										</form>
									</div>
								</div>
							</div>
						</div>
						<!-- /Add Designation Modal -->
						
						<!-- Edit Designation Modal -->
						<div id="edit_designation" class="modal custom-modal fade" role="dialog">
							<div class="modal-dialog modal-dialog-centered" role="document">
								<div class="modal-content">
									<div class="modal-header">
										<h5 class="modal-title">Edit Designation</h5>
										<button type="button" class="btn-close" data-bs-dismiss="modalEdit" aria-label="Close">
											<!-- <span aria-hidden="true">&times;</span> -->
										</button>
									</div>
									<div class="modal-body">
										<form>
											<div class="input-block mb-3">
												<label class="col-form-label">Designation Name <span class="text-danger">*</span></label>
												<input class="form-control" type="text" id="save_desig_name">
											</div>
											<div class="input-block mb-3">
												<label class="col-form-label">Department Asigned<span class="text-danger">*</span></label>
												<input class="form-control" type="text" id="dept_saved" readonly>
											</div>
											<div class="input-block mb-3">
												<label class="col-form-label">Department <span class="text-danger">*</span></label>
												<select class="form-select" id="dept_id_save">
													<option value="">Select Department</option>
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
											<div class="submit-section d-flex justify-content-center align-items-center mt-4 mb-2">
												<button class="btn btn-primary submit-btn" id="submitEdit">Save</button>
											</div>
										</form>
									</div>
								</div>
							</div>
						</div>
						<!-- /Edit Designation Modal -->
						
						<!-- Delete Designation Modal -->
						<div class="modal custom-modal fade" id="delete_designation" role="dialog">
							<div class="modal-dialog modal-dialog-centered">
								<div class="modal-content">
									<div class="modal-body">
										<div class="form-header">
											<h3>Delete Designation</h3>
											<p>Are you sure want to delete?</p>
										</div>
										<div class="modal-btn delete-action">
											<div class="row">
												<div class="col-6">
													<a href="javascript:void(0);" class="btn btn-primary continue-btn" id="submitDelete">Delete</a>
												</div>
												<div class="col-6">
													<a href="javascript:void(0);" data-bs-dismiss="modalDelete" class="btn btn-primary cancel-btn">Cancel</a>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<!-- /Delete Designation Modal -->	
					<!-- Designation PopUp end -->

					<!-- Department PopUp start -->
					 	<!-- Add Department Modal -->
						<div id="add_department" class="modal custom-modal fade" role="dialog">
							<div class="modal-dialog modal-dialog-centered" role="document">
								<div class="modal-content">
									<div class="modal-header">
										<h5 class="modal-title">Add Department</h5>
										<button type="button" class="btn-close" data-bs-dismiss="modalAdd" aria-label="Close">
											<!-- <span aria-hidden="true">&times;</span> -->
										</button>
									</div>
									<div class="modal-body">
										<form>
											<div class="input-block mb-3">
												<label class="col-form-label">Department Name <span class="text-danger">*</span></label>
												<input class="form-control" type="text" id="name" class="name">
											</div>
											<div class="submit-section d-flex justify-content-center align-items-center mt-4 mb-2">
												<button class="btn btn-primary submit-btn" id="submit">Submit</button>
											</div>
										</form>
									</div>
								</div>
							</div>
						</div>
						<!-- /Add Department Modal -->
						
						<!-- Edit Department Modal -->
						<div id="edit_department" class="modal custom-modal fade" role="dialog">
							<div class="modal-dialog modal-dialog-centered" role="document">
								<div class="modal-content">
									<div class="modal-header">
										<h5 class="modal-title">Edit Department</h5>
										<button type="button" class="btn-close" data-bs-dismiss="modalEdit" aria-label="Close">
											<!-- <span aria-hidden="true">&times;</span> -->
										</button>
									</div>
									<div class="modal-body">
										<form>
											<div class="input-block mb-3">
												<label class="col-form-label">Department Name <span class="text-danger">*</span></label>
												<input class="form-control" id="save_dept_name" type="text">
											</div>
											<div class="submit-section d-flex justify-content-center align-items-center mt-4 mb-2">
												<button class="btn btn-primary submit-btn" id="submitDept">Save</button>
											</div>
										</form>
									</div>
								</div>
							</div>
						</div>
						<!-- /Edit Department Modal -->

						<!-- Delete Department Modal -->
						<div class="modal custom-modal fade" id="delete_department" role="dialog">
							<div class="modal-dialog modal-dialog-centered">
								<div class="modal-content">
									<div class="modal-body">
										<div class="form-header">
											<h3>Delete Department</h3>
											<p>Are you sure want to delete?</p>
										</div>
										<div class="modal-btn delete-action">
											<div class="row">
												<div class="col-6">
													<a href="javascript:void(0);" class="btn btn-primary continue-btn" id="deleteDept">Delete</a>
												</div>
												<div class="col-6">
													<a href="javascript:void(0);" data-bs-dismiss="modalDelete" class="btn btn-primary cancel-btn">Cancel</a>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<!-- /Delete Department Modal -->
					<!-- Department PopUp end -->
                </div>   
            </div>    
        </div>
        <!-- JAVASCRIPT -->
        <script src="../assets/libs/jquery/jquery.min.js"></script>
        <script src="../assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="../assets/libs/metismenu/metisMenu.min.js"></script>
        <script src="../assets/libs/simplebar/simplebar.min.js"></script>
        <script src="../assets/libs/node-waves/waves.min.js"></script>
        <!-- Required datatable js -->
        <script src="../assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
        <script src="../assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
        
        <!-- Responsive examples -->
        <script src="../assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
        <script src="../assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>

        <!-- App js -->
        <script src="../assets/js/app.js"></script>
        <script>
            $(document).ready(function(){
                $("#user_table").DataTable();
                $("#user_table1").DataTable();
            });
            function showOrderDetails(id)
            {
                window.location.href='order_details.php?vkvbvjfgfikix='+id;  
            }
        </script>

		<!-- Designation PopUp Start -->
		<script>

			//on closing form refresh page values to not pass on next form
			$('[data-bs-dismiss="modalAdd"]').on('click', function(){
				window.location.reload();
			});
			$('[data-bs-dismiss="modalEdit"]').on('click', function(){
				window.location.reload();
			});
			$('[data-bs-dismiss="modalDelete"]').on('click', function(){
				window.location.reload();
			});

			//add Designation
			$('#submitAdd').click(function(e){
				e.preventDefault();

				let desig_name = $('#desig_name').val();
				let dept_id = $('#dept_id').val();

				if(desig_name == '' || dept_id == ''){
					alert('Enter Designation name');
				}else{
					$.ajax({
						type: 'POST',
						url: 'addDesignation.php',
						data: 'desig_name='+desig_name+'&dept_id='+dept_id,
						cache: false,
						success: function(data){
							if(data == 1){
								// console.log("Designation Added");
								alert("Designation Added");
								window.location.reload();
							}else{
								// console.log("Failed To Added");
								alert("Failed To Added");
								window.location.reload();
							}
						}
					});
				}
			});

			//edit Designation
			function saveDesig(id, desig_name, dept_id, dept_name, message, status){

				var id = id;
				var desig_name = desig_name;
				var dept_id = dept_id;
				var dept_name = dept_name;
				var message = message;
				var status = status;

				// var datastring2 = {id,desig_name,dept_id,dept_name,message,status}
				// console.log(datastring2);

				var save_desig_name = document.querySelector('#save_desig_name');
				save_desig_name.value = desig_name;
				var dept_saved_name = document.querySelector('#dept_saved');
				dept_saved_name.value = dept_name;

				$('#submitEdit').click(function(e){
					e.preventDefault();
					let desig_name_save = $('#save_desig_name').val().trim();
					let dept_id_save = $('#dept_id_save').val().trim();

					//both ways work data passing in ajax
					// var datastring = 'id='+id+'&saveDeptName='+saveDeptName+'&message='+message+'&status='+status;
					var datastring = {id,desig_name_save,dept_id_save,message,status}

					$.ajax({
						type: 'POST',
						url: 'editDesignation.php',
						data: datastring,
						cache: false,
						success: function(data){
							if(data == '1'){
								alert('Edit Successful');
								window.location.reload();
							}else{
								alert('Edit Failed');
								window.location.reload();
							}
						}
					});
				});
			}

			//delete Designation
			function deleteDesig(id, desig_name, dept_id, dept_name, message, status){
				var id = id;
				var desig_name = desig_name;
				var dept_id = dept_id;
				var dept_name = dept_name;
				var message = message;
				var status = status;

				$('#submitDelete').click(function(e){
					e.preventDefault();

					var datastring = {id,desig_name,dept_id,dept_name,message,status};

					$.ajax({
						type: 'POST',
						url: 'deleteDesignation.php',
						data: datastring,
						cache: false,
						success: function(data){
							if(data == '1'){
								alert('Edit Successful');
								window.location.reload();
							}else{
								alert('Edit Failed');
								window.location.reload();
							}
						}
					});
				});
			}
		</script>
		<!-- Designation PopUp end -->

		<!-- Department PopUp Start -->
		<script>

			//on closing form refresh page values to not pass on next form
			$('[data-bs-dismiss="modalAdd"]').on('click', function(){
				window.location.reload();
			});
			$('[data-bs-dismiss="modalEdit"]').on('click', function(){
				window.location.reload();
			});
			$('[data-bs-dismiss="modalDelete"]').on('click', function(){
				window.location.reload();
			});

			//add department
			$('#submit').click(function(e){
				e.preventDefault();
				let deptName = $('#name').val();
				if(deptName == ''){
					alert('Enter Department name');
				}else{
					$.ajax({
						type: 'POST',
						url: 'addDepartment.php',
						data: 'name='+deptName,
						cache: false,
						success: function(data){
							if(data == 1){
								// console.log("Department Added");
								alert("Department Added");
								window.location.reload();
							}else{
								// console.log("Failed To Added");
								alert("Failed To Added");
								window.location.reload();
							}
						}
					});
				}
			});

			//edit department
			function saveDept(id, name, message, status){

				var id = id;
				var name = name;
				var message = message;
				var status = status;

				var save_name = document.querySelector('#save_dept_name');
				save_name.value = name;

				$('#submitDept').click(function(e){
					e.preventDefault();
					var saveDeptName = $('#save_dept_name').val().trim();

					//both ways work data passing in ajax
					// var datastring = 'id='+id+'&saveDeptName='+saveDeptName+'&message='+message+'&status='+status;
					var datastring = {id,saveDeptName,message,status}

					$.ajax({
						type: 'POST',
						url: 'editDepartment.php',
						data: datastring,
						cache: false,
						success: function(data){
							if(data == '1'){
								alert('Edit Successful');
								window.location.reload();
							}else{
								alert('Edit Failed');
								window.location.reload();
							}
						}
					});
				});
			}

			//delete Department
			function deleteDept(id, name, message, status){
				var id = id;
				var name = name;
				var message = message;
				var status = status;

				$('#deleteDept').click(function(e){
					e.preventDefault();

					var datastring = {id,name,message,status};

					$.ajax({
						type: 'POST',
						url: 'deleteDepartment.php',
						data: datastring,
						cache: false,
						success: function(data){
							if(data == '1'){
								alert('Edit Successful');
								window.location.reload();
							}else{
								alert('Edit Failed');
								window.location.reload();
							}
						}
					});
				});
			}
		</script>
		<!-- Department PopUp end -->
    </body>
</html>