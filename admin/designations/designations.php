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
        <title>Designation</title>
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
                                    <div class="col-lg-12 d-flex justify-content-between pb-3 pt-3 mb-4" style="border-bottom: 1px solid #DDDDDD">
                                        <h5 class="mt-3 fw-bold fs-3">Designation</h5>
                                        <!-- <div class="dropdown mt-">
                                            <a class="" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false"><i class="mdi mdi-dots-vertical-circle-outline mdi-24px" style="color: grey;"></i></a>
                                            <div class="dropdown-menu" id="dr-users" aria-labelledby="dropdownMenuButton">
                                                <a class="dropdown-item" href="#">Download</a>
                                            </div>
                                        </div> -->
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="table-responsive table-desi">
                                            <!-- table roe limit -->
											<table class="table custom-table mb-0 datatable" id="user_table">
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
            });
            function showOrderDetails(id)
            {
                window.location.href='order_details.php?vkvbvjfgfikix='+id;  
            }
        </script>
    </body>
</html>