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
        <title>Travel Consultant View | Admin Dashboard </title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- App favicon -->
        <link rel="shortcut icon" href="../assets/images/fav.png">

        <!-- bootstrap-datepicker css -->
        <link href="../assets/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css">

        <!-- DataTables -->
        <link href="../assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />

        <!-- Responsive datatable examples -->
        <link href="../assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />  

        <!-- Bootstrap Css -->
        <link href="../assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
        <!-- Icons Css -->
        <link href="../assets/css/icons.min.css" rel="stylesheet" type="text/css" />
        <!-- App Css-->
        <link href="../assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />
        <!-- Loading Screen and Images size css  -->
        <link href="../assets/css/loadingScreen.css" rel="stylesheet" type="text/css" />
        <!-- App js -->
        <!-- <script src="../assets/js/plugin.js"></script> -->
        <!-- Font awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <!-- Date Range Picker CSS Start -->
        <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
        <!-- Select2 CSS -->
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <style>
            /* dataTable, action col, dropdown align right  */
            @media screen and (max-width: 992px) and (min-width: 914px) {
                .dropdown-menu-end-1[style] {
                    left: 25%!important;
                    right: 25%!important;
                }
            } 
            @media screen and (max-width: 1256px) and (min-width: 1176px) {
                .dropdown-menu-end-1[style] {
                    left: 25%!important;
                    right: 25%!important;
                }
            }
            @media screen and (max-width: 1405px) and (min-width: 1264px) {
                .dropdown-menu-end-2[style] {
                    left: 25%!important;
                    right: 25%!important;
                }
            }

        </style>

    </head>

    <body data-sidebar="dark">

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
                                    <h4 class="mb-sm-0 font-size-18">Travel Consultant</h4>

                                    <!-- <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Ecommerce</a></li>
                                            <li class="breadcrumb-item active">Customers</li>
                                        </ol> -->
                                    </div>

                                </div>
                            </div>
                        </div>
                        <!-- end page title -->
                        <!-- Pending list -->
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row mb-2">
                                            <div class="col-sm-6">
                                                <div class="search-box me-2 mb-2 d-inline-block">
                                                    <div class="position-relative">
                                                        <h4>Pending Travel Consultant List</h4>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- <div class="col-sm-6">
                                                <div class="text-sm-end">
                                                    <button type="button" data-bs-toggle="modal" data-bs-target="#newTravelAgencyModal" class="btn btn-success btn-rounded waves-effect waves-light mb-2 me-2 addTravelAgencymodal"><i class="mdi mdi-plus me-1"></i> New Travel Consultant</button>
                                                </div>
                                            </div> -->
                                        </div>

                                        <div class="table-responsive">
                                            <table class="table align-middle table-nowrap dt-responsive nowrap w-100" id="pendingCustomerList-table">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th>Id</th>
                                                        <th>Full Name</th>
                                                        <th>Reference ID / Name</th>
                                                        <th>Phone / Email</th>
                                                        <th>Address</th>
                                                        <th>Joining Date</th>
                                                        <th>status</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                        $sql = "SELECT * FROM `ca_travelagency` WHERE status = '2' OR status = '0' ORDER BY id ASC ";
                                                        $stmt = $conn -> prepare($sql);
                                                        $stmt -> execute();
                                                        $stmt -> setFetchMode(PDO::FETCH_ASSOC);
                                                        if($stmt->rowCount()>0){
                                                            foreach(($stmt->fetchAll()) as $key => $row) {
                                                                $bd= new DateTime($row['date_of_birth']);
                                                                $bdate= $bd->format('d-m-Y');

                                                                $rd= new DateTime($row['register_date']);
                                                                $rdate= $rd->format('d-m-Y');

                                                                echo'<tr>
                                                                    <td>'.$row['id'].'</td>
                                                                    <td>'.$row['firstname'].' '.$row['lastname'].'</td>
                                                                    <td><p class="mb-1">'.$row['reference_no'].'</p>
                                                                        <p class="mb-0">'.$row['registrant'].'</p>
                                                                    </td>
                                                                    <td>
                                                                        <p class="mb-1">+'.$row['country_code'].' '.$row['contact_no'].'</p>
                                                                        <p class="mb-0">'.$row['email'].'</p>
                                                                    </td>
                                                                    
                                                                    <td>'.$row['address'].'</td>
                                                                    <td>'.$rdate.'</td>';
                                                                    if($row['status']== '2'){
                                                                        echo'<td><span class="badge text-bg-warning">Pending</span></td>
                                                                        <td>
                                                                            <div class="dropdown">
                                                                                <a href="#" class="dropdown-toggle card-drop" data-bs-toggle="dropdown" aria-expanded="false">
                                                                                    <i class="mdi mdi-dots-horizontal font-size-18"></i>
                                                                                </a>
                                                                                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-end-1">
                                                                                    <li><a href="#" onclick=\'editfuncCust("' .$row["id"]. '","' .$row["reference_no"]. '","' .$row["register_by"]. '","' .$row["country"]. '","' .$row["state"]. '","' .$row["city"]. '","pending")\' class="dropdown-item" data-bs-toggle="modal" ><i class="mdi mdi-pencil font-size-16 text-primary me-1"></i> Edit</a></li>
                                                                                    <li><a href="#" onclick=\'deletefunc("' .$row["id"]. '","","pending")\' class="dropdown-item" data-bs-toggle="modal" ><i class="mdi mdi-trash-can font-size-16 text-danger me-1"></i> Delete</a></li>
                                                                                    <li><a href="#" onclick=\'confirmfunc("' .$row["id"]. '","' .$row["email"]. '","' .$row["reference_no"]. '")\' class="dropdown-item" data-bs-toggle="modal" ><i class="fas fa-check-circle font-size-16 text-success me-1"></i> Confirm</a></li>
                                                                                </ul>
                                                                            </div>
                                                                        </td>';
                                                                    }else{
                                                                        echo'<td><span class="badge text-bg-danger">Delete</span></td>
                                                                        <td>
                                                                            <div class="dropdown">
                                                                                <a href="#" class="dropdown-toggle card-drop" data-bs-toggle="dropdown" aria-expanded="false">
                                                                                    <i class="mdi mdi-dots-horizontal font-size-18"></i>
                                                                                </a>
                                                                                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-end-1">
                                                                                    <li><a href="#" onclick=\'deletefunc("' .$row["id"]. '","","deleted")\' class="dropdown-item" data-bs-toggle="modal" ><i class="mdi mdi-file-restore font-size-16 text-success me-1"></i> Restore</a></li>
                                                                                </ul>
                                                                            </div>
                                                                        </td>';
                                                                    }
                                                                echo'</tr>';
                                                            }
                                                        }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end row -->

                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row mb-2">
                                            <div class="col-sm-6">
                                                <div class="search-box me-2 mb-2 d-inline-block">
                                                    <div class="position-relative">
                                                        <h4>Registered Travel Consultant List</h4>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- <div class="col-sm-8">
                                                <div class="text-sm-end">
                                                    <button type="button" data-bs-toggle="modal" data-bs-target="#newCustomerModal" class="btn btn-success btn-rounded waves-effect waves-light mb-2 me-2 addCustomers-modal"><i class="mdi mdi-plus me-1"></i> New Customers</button>
                                                </div>
                                            </div> -->
                                            <!-- end col-->

                                            <!-- Search Filter -->
                                             <div class="row filter-row p-2">
                                                <!--<div class="col-sm-6 col-md-6"> 
                                                    <div class="input-block mb-3">
                                                        <label class="col-form-label"><span>State</span></label>
                                                        <select class="form-control" id="filter_state" aria-label="Floating label select example"> 
                                                            <option value="0">--- Select ---</option>
                                                            <?php
                                                                // require '../connect.php';
                                                                // $sql = "SELECT * FROM `states` WHERE status ='1' ";
                                                                // $stmt = $conn->prepare($sql);
                                                                // $stmt -> execute();
                                                                // $stmt -> setFetchMode(PDO::FETCH_ASSOC);
                                                                // if($stmt-> rowCount()>0 ){
                                                                //     foreach( ($stmt -> fetchAll()) as $key => $row ){
                                                                //         echo'
                                                                //             <option value="'.$row['id'].'">'.$row['state_name'].'</option>
                                                                //         ';
                                                                //     }
                                                                // }else{
                                                                //     echo '<option value="">Department not available</option>'; 
                                                                // }
                                                            ?>
                                                        </select>
                                                        
                                                    </div>
                                                </div> -->

                                                
                                                <!-- <div class="col-sm-4 col-md-2">
                                                    <div class="d-grid ">
                                                        <a href="#" id="filterBranch" class="btn btn-success w-100 "> Search </a>  
                                                    </div>  
                                                </div> -->
                                                <!-- designation -->
                                                <div class="col-sm-3 col-md-3"> 
                                                    <div class="input-block">
                                                        <label class="col-form-label" for="designation"><span>Designation</span></label>
                                                        <select id="designation" name="designation" class="form-select">
                                                            <option value="" disabled selected>-- Select Designation --</option>
                                                            <option value="24">Business Channel Manager (BCM)</option>
                                                            <option value="25">Business Development Manager (BDM)</option>
                                                            <option value="26">Business Mentor (BM)</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <!-- user ids -->
                                                <div class="col-sm-3 col-md-3"> 
                                                    <div class="input-block">
                                                        <label class="col-form-label " for="userIdSelect"><span>User</span></label>
                                                        <select id="userIdSelect" class="form-select filter_items">
                                                            <option value="" selected>-- Select User --</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <!-- date range -->
                                                <div class="col-md-3 col-sm-3">
                                                    <label class="col-form-label" for=""><span>Count</span></label>
                                                    <div id="reportrange" class="filter_items input-block text-dark px-3 py-2 w-100 text-center dateRange " style="background-color:#e5e5e5; border-radius: 6px;">
                                                        <i class="fa fa-calendar"></i>&nbsp;
                                                        <span id='selectedDate'></span> <i class="fa-solid fa-angle-down"></i>
                                                    </div>
                                                </div>
                                                
                                                <div class="col-sm-3 col-md-3"> 
                                                    <div class="input-block">
                                                        <label class="col-form-label" for=""><span>Count</span></label>
                                                        <input type="text" name="" id="filterCount" class="form-control" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Search Filter -->

                                        </div>
                                        
                                        <div class="table-responsive" id="tcView">
                                            <table class="table align-middle table-nowrap dt-responsive nowrap w-100" id="registeredCustomerList-table">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th>Travel Consultant Id</th>
                                                        <th>Full Name</th>
                                                        <th>Reference ID / Name</th>
                                                        <th>Referal Ref ID/ Name</th>
                                                        <th>Phone / Email</th>
                                                        <th>Address</th>
                                                        <th>Joining Date</th>
                                                        <th>Status</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                        $sql = "SELECT * FROM `ca_travelagency` WHERE status = '1' OR status = '3' ORDER BY ca_travelagency_id ASC ";
                                                        $stmt = $conn -> prepare($sql);
                                                        $stmt -> execute();
                                                        $stmt -> setFetchMode(PDO::FETCH_ASSOC);
                                                        if($stmt->rowCount()>0){
                                                            foreach(($stmt->fetchAll()) as $key => $row) {
                                                                $bd= new DateTime($row['date_of_birth']);
                                                                $bdate= $bd->format('d-m-Y');

                                                                $rd= new DateTime($row['register_date']);
                                                                $rdate= $rd->format('d-m-Y');


                                                                $reference_no = substr($row['reference_no'], 0, 2);
			                                                    if ($reference_no == "TE" || $reference_no == "CA") {
                                                                    $sql2 = "SELECT * FROM `corporate_agency` WHERE corporate_agency_id = '".$row['reference_no']."' AND (status = '1' OR status = '3') ORDER BY corporate_agency_id ASC ";
                                                                    $stmt2 = $conn -> prepare($sql2);
                                                                    $stmt2 -> execute();
                                                                    $stmt2 -> setFetchMode(PDO::FETCH_ASSOC);
                                                                    if($stmt2->rowCount()>0){
                                                                        foreach(($stmt2->fetchAll()) as $key2 => $row2){
                                                                            $name = $row2['registrant'];
                                                                            $id = $row2['reference_no'];
                                                                        }
                                                                    }
                                                                }else if($reference_no == "BM"){
                                                                    $sql2 = "SELECT * FROM `business_mentor` WHERE business_mentor_id = '".$row['reference_no']."' AND (status = '1' OR status = '3') ORDER BY business_mentor_id ASC ";
                                                                    $stmt2 = $conn -> prepare($sql2);
                                                                    $stmt2 -> execute();
                                                                    $stmt2 -> setFetchMode(PDO::FETCH_ASSOC);
                                                                    if($stmt2->rowCount()>0){
                                                                        foreach(($stmt2->fetchAll()) as $key2 => $row2){
                                                                            $name = $row2['registrant'];
                                                                            $id = $row2['reference_no'];
                                                                        }
                                                                    }
                                                                }


                                                                echo'<tr>
                                                                    <td>'.$row['ca_travelagency_id'].'</td>
                                                                    <td>'.$row['firstname'].' '.$row['lastname'].'</td>
                                                                    <td><p class="mb-1">'.$row['reference_no'].'</p>
                                                                        <p class="mb-0">'.$row['registrant'].'</p>
                                                                    </td>
                                                                    <td><p class="mb-1">'.$id.'</p>
                                                                        <p class="mb-0">'.$name.'</p>
                                                                    </td>
                                                                    <td>
                                                                        <p class="mb-1">+'.$row['country_code'].' '.$row['contact_no'].'</p>
                                                                        <p class="mb-0">'.$row['email'].'</p>
                                                                    </td>
                                                                    <td>'.$row['address'].'</td>
                                                                    <td>'.$rdate.'</td>';
                                                                    if($row['status']== '1'){
                                                                        echo'<td><span class="badge text-bg-success">Active</span></td>
                                                                        <td>
                                                                            <div class="dropdown">
                                                                                <a href="#" class="dropdown-toggle card-drop" data-bs-toggle="dropdown" aria-expanded="false">
                                                                                    <i class="mdi mdi-dots-horizontal font-size-18"></i>
                                                                                </a>
                                                                                <ul class="dropdown-menu dropdown-menu-right dropdown-menu-right-2">
                                                                                    <li><a href="#" onclick=\'overviewPage("'.$row["ca_travelagency_id"]. '","' .$row["reference_no"]. '","' .$row["country"]. '","' .$row["state"]. '","' .$row["city"]. '","ca_travelagency")\' class="dropdown-item" data-bs-toggle="modal" ><i class="mdi mdi-eye font-size-16 text-info me-1"></i> View</a></li>
                                                                                    <li><a href="#" onclick=\'editfuncCust("'.$row["ca_travelagency_id"]. '","' .$row["reference_no"]. '","' .$row["register_by"]. '","' .$row["country"]. '","' .$row["state"]. '","' .$row["city"]. '","registered")\' class="dropdown-item" data-bs-toggle="modal" ><i class="mdi mdi-pencil font-size-16 text-primary me-1"></i> Edit</a></li>
                                                                                    <li><a href="#" onclick=\'deletefunc("' .$row["id"]. '","'.$row["ca_travelagency_id"]. '","registered")\' class="dropdown-item" data-bs-toggle="modal" ><i class="mdi mdi-trash-can font-size-16 text-danger me-1"></i> Delete</a></li>
                                                                                </ul>
                                                                            </div>
                                                                        </td>';
                                                                    }else{
                                                                        echo'<td><span class="badge text-bg-danger">Deactive</span></td>
                                                                        <td>
                                                                            <div class="dropdown">
                                                                                <a href="#" class="dropdown-toggle card-drop" data-bs-toggle="dropdown" aria-expanded="false">
                                                                                    <i class="mdi mdi-dots-horizontal font-size-18"></i>
                                                                                </a>
                                                                                <ul class="dropdown-menu dropdown-menu-right dropdown-menu-right-2">
                                                                                    <li><a href="#" onclick=\'deletefunc("' .$row["id"]. '","'.$row["ca_travelagency_id"]. '","deactivate")\' class="dropdown-item" data-bs-toggle="modal" ><i class="mdi mdi-file-restore font-size-16 text-success me-1"></i> Restore</a></li>
                                                                                </ul>
                                                                            </div>
                                                                        </td>';
                                                                    }
                                                                echo'</tr>';
                                                            }
                                                        }
                                                    ?>
                                                </tbody>
                                            </table>
                                            <!-- end table -->
                                        </div>
                                        
                                        <!-- end table responsive -->
                                    </div>
                                    <!-- end card body -->
                                </div>
                                <!-- end card -->
                            </div>
                            <!-- end col -->
                        </div>
                        <!-- end row -->

                    </div> <!-- container-fluid -->
                </div> <!-- End Page-content -->

                
                <footer class="footer">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-sm-6">
                                <?php echo $date; ?> © Uniqbizz.
                            </div>
                            <div class="col-sm-6">
                                <div class="text-sm-end d-none d-sm-block">
                                    Design & Develop by MirthCon.
                                </div>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
            <!-- end main content-->

        </div>
        <!-- END layout-wrapper -->

        <!-- loading screen -->
        <div id="loading-overlay">
            <div class="loading-icon"></div>
        </div>
        <!-- Add button icon -->
        <div class="btn" data-bs-toggle="modal" data-bs-target="#newTravelAgencyModal" style="width: 25px; height: 25px; padding: 0px; position: fixed; bottom: 120px; right: 43px; border-radius: 50%;">
            <a style="display: flex; justify-content: center; align-items: center; height: -webkit-fill-available;">
                <i class="fa-solid fa-circle-plus fa-beat-fade fa-3x" style="color: #4b38b3;"></i>
            </a>
        </div>
        <!--start back-to-top-->
        <button onclick="topFunction()" class="scrollToTop scroll-btn show btn" id="back-to-top">
            <i class="mdi mdi-arrow-up"></i>
        </button>
        <!--end back-to-top--> 

        <!-- Modal -->
        <div class="modal fade" id="newTravelAgencyModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-sm">
                <div class="modal-content">
                    <div class="modal-body px-4 py-5 text-center">
                        <button type="button" class="btn-close position-absolute end-0 top-0 m-3" data-bs-dismiss="modal" aria-label="Close"></button>
                        <div class="avatar-sm mb-4 mx-auto">
                            <div class="avatar-title bg-primary text-primary bg-opacity-10 font-size-20 rounded-3">
                                <span class="avatar-title">
                                    <i class="fas fa-user-alt font-size-24"></i>
                                </span>
                            </div>
                        </div>
                        <p class="text-muted font-size-16 mb-4">Are you Sure You want to Add New User ?</p>
                        
                        <div class="hstack gap-2 justify-content-center mb-0">
                            <button type="button" class="btn btn-success" id="add-item"><a href="add_ca_travelAgency.php"><span style="color: white;">Add Now</span></a></button>
                            <button type="button" class="btn btn-secondary" id="close-newTravelAgencyModal" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end newTravelAgencyModal -->

        <!-- Modal -->
        <div class="modal fade" id="removeItemModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-sm">
                <div class="modal-content">
                    <div class="modal-body px-4 py-5 text-center">
                        <button type="button" class="btn-close position-absolute end-0 top-0 m-3" data-bs-dismiss="modal" aria-label="Close"></button>
                        <div class="avatar-sm mb-4 mx-auto">
                            <div class="avatar-title bg-primary text-primary bg-opacity-10 font-size-20 rounded-3">
                                <i class="mdi mdi-trash-can-outline"></i>
                            </div>
                        </div>
                        <p class="text-muted font-size-16 mb-4">Are you Sure You want to Remove this User ?</p>
                        
                        <div class="hstack gap-2 justify-content-center mb-0">
                            <button type="button" class="btn btn-danger" id="remove-item">Remove Now</button>
                            <button type="button" class="btn btn-secondary" id="close-removeCustomerModal" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end removeItemModal -->

        <!-- Modal -->
        <div class="modal fade" id="confirmItemModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-sm">
                <div class="modal-content">
                    <div class="modal-body px-4 py-5 text-center">
                        <button type="button" class="btn-close position-absolute end-0 top-0 m-3" data-bs-dismiss="modal" aria-label="Close"></button>
                        <div class="avatar-sm mb-4 mx-auto">
                            <div class="avatar-title bg-primary text-primary bg-opacity-10 font-size-20 rounded-3">
                                <i class="fas fa-check-circle text-success"></i>
                            </div>
                        </div>
                        <p class="text-muted font-size-16 mb-4">Are you Sure You want to Cofirm this User ?</p>
                        
                        <div class="hstack gap-2 justify-content-center mb-0">
                            <button type="button" class="btn btn-success" id="remove-item">Confirm Now</button>
                            <button type="button" class="btn btn-secondary" id="close-confirmItemModal" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end confirmItemModal -->

        <!-- Modal -->
        <!-- <div class="modal fade" id="editItemModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-sm">
                <div class="modal-content">
                    <div class="modal-body px-4 py-5 text-center">
                        <button type="button" class="btn-close position-absolute end-0 top-0 m-3" data-bs-dismiss="modal" aria-label="Close"></button>
                        <div class="avatar-sm mb-4 mx-auto">
                            <div class="avatar-title bg-primary text-primary bg-opacity-10 font-size-20 rounded-3">
                                <i class="fas fa-user-edit text-primary"></i>
                            </div>
                        </div>
                        <p class="text-muted font-size-16 mb-4">Are you Sure You want to Edit this User ?</p>
                        
                        <div class="hstack gap-2 justify-content-center mb-0">
                            <button type="button" class="btn btn-success" id="remove-item">Edit Now</button>
                            <button type="button" class="btn btn-secondary" id="close-editItemModal" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </div> -->
        <!-- end editItemModal -->

        <!-- JAVASCRIPT -->
        <script src="../assets/libs/jquery/jquery.min.js"></script>
        <script src="../assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="../assets/libs/metismenu/metisMenu.min.js"></script>
        <script src="../assets/libs/simplebar/simplebar.min.js"></script>
        <script src="../assets/libs/node-waves/waves.min.js"></script>
        <!-- bootstrap-datepicker js -->
        <script src="../assets/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>

        <!-- Required datatable js -->
        <script src="../assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
        <script src="../assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
        
        <!-- Responsive examples -->
        <script src="../assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
        <script src="../assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>
        
        <!-- ecommerce-customer-list init -->
        <!-- <script src="../assets/js/pages/ecommerce-customer-list.init.js"></script> -->
        <!-- Date Range Picker Script Start -->
        <!-- <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script> -->
        <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
        <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
        <!-- Date Range Picker Script End -->
        
        <!-- App js -->
        <script src="../assets/js/app.js"></script>

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

        <!-- dataTable -->
        <script>
            $(document).ready(function(){
                $("#pendingCustomerList-table").DataTable();
                $("#registeredCustomerList-table").DataTable();
            });
            
            function editfuncCust(id,refno,regby,cut,st,ct,editfor){ 
                window.location.href='edit_ca_travelAgency.php?vkvbvjfgfikix='+id+'&nohbref='+refno+'&fyfyfregby='+regby+'&ncy='+cut+'&mst='+st+'&hct='+ct+'&editfor='+editfor;
            };

            function deletefunc(id,fid,action){ 
                var dataString = 'id='+id+'&refid='+fid+'&action='+action;

                $.ajax({
                type: "POST",
                url: "delete_ca_travelAgency.php",
                data: dataString,
                cache: false,
                    success:function(data){
                        console.log('data'+data);
                        if( data == 0 ){
                            alert("Deleted Succesfully");
                            window.location.reload();
                        }else if( data == 1 ){
                            alert("User Activated Succesfully");
                            window.location.reload();
                        }else if( data == 2 ){
                            alert("User Restored Succesfully");
                            window.location.reload();
                        }else if( data == 3 ){
                            alert("User Deactivated Succesfully");
                            window.location.reload();
                        } else {
                            alert("Request Failed !!");
                        }
                    }
                });
                
            };

            function confirmfunc(id,email,ref){ 

                var dataString = 'id='+ id+'&uname='+email+'&ref='+ref;
                $("#loading-overlay").show(); //loading screen
                $.ajax({
                    type: "POST",
                    url: "confirm_ca_travelAgency.php",
                    data: dataString,
                    cache: false,
                    success:function(data){
                        console.log(data);
                        if(data == 1){
                            $("#loading-overlay").hide(); //loading screen
                            alert("Email and Password sent via sms and email");
                            window.location.reload();
                        }
                        else{
                            $("#loading-overlay").hide(); //loading screen
                            alert("Failed to confirm");
                        }
                    }
                });
                
            };

            $('#filter_state').on('change', function(){
				// e.preventDefault();
				// alert('Hello');
				// let filterEmpID = $('#bmId').val() ;
				// let filterEmpName = $('#bmName').val();
				let filterState = $('#filter_state').val();
				// console.log(filterEmpID +' '+ filterEmpName +' '+ filterState);

                if(!filterState){
                    alert("Select State First");
                }else{

                    let dataString = 'state='+filterState;

                    $.ajax({
                        type: 'POST',
                        url: 'filterTC.php',
                        data: dataString,
                        cache: false,
                        success: function(data){
                            if(data){
                                console.log('success'+' '+data);
                                $('#tcView').html(data);
                                $("#registeredCustomerList-tableFilter").DataTable();
                                var totalRows = $("#registeredCustomerList-tableFilter").DataTable().rows().count();
                                $('#filterCount').val(totalRows);
                                // console.log("Total DataTable rows:", totalRows);
                            }else{
                                console.log('unsuccess'+' '+data);
                                $('#tcView').html(data);
                            }
                        }
                    });
                }
			});

            $('#designation').on('change', function () {
                const designation = $(this).val();

                if (designation) {
                    $.ajax({
                        url: '../assets/submit/get_users_by_designation.php',
                        type: 'POST',
                        data: { designation: designation },
                        dataType: 'json',
                        success: function (response) {
                            let options = `<option value="" selected>-- Select User --</option>`;
                            response.forEach(user => {
                                options += `<option value="${user.user_id}">${user.fullname}</option>`;
                            });
                            $('#userIdSelect').html(options);
                        },
                        error: function () {
                            alert('Error fetching users.');
                        }
                    });
                } else {
                    $('#userIdSelect').html('<option value="" selected>-- Select User --</option>');
                }
            });


            let dateRangeChanged = false; // Flag to track if date range was changed

            function loadFilteredTCData() {
                const userId = $('#userIdSelect').val()?.trim() || '';
                const designation = $('#designation').val()?.trim() || '';
                const state = $('#filter_state').val()?.trim() || '';

                let fromDate = '', toDate = '';

                if (dateRangeChanged) {
                    const dateRange = $('#selectedDate').text().trim();
                    if (dateRange.includes(' to ')) {
                        [fromDate, toDate] = dateRange.split(' to ');
                    }
                }

                const dataString = {
                    userId: userId,
                    designation: designation,
                    state: state
                };

                if (dateRangeChanged) {
                    dataString.fromDate = fromDate;
                    dataString.toDate = toDate;
                }

                $.ajax({
                    type: 'POST',
                    url: 'filterTC.php',
                    data: dataString,
                    success: function (data) {
                        if (data) {
                            $('#tcView').html(data);
                            $("#registeredCustomerList-tableFilter").DataTable();
                            const totalRows = $("#registeredCustomerList-tableFilter").DataTable().rows().count();
                            $('#filterCount').val(totalRows);
                        } else {
                            $('#tcView').html('<tr><td colspan="9">No data found</td></tr>');
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error('AJAX Error:', error);
                    }
                });
            }

            // 🔁 Change handler for dropdowns (user/state/designation)
            $('.filter_items').on('change', function () {
                loadFilteredTCData();
            });

            // 📅 When date range changes, update flag and reload
            $('#reportrange').on('apply.daterangepicker', function (ev, picker) {
                dateRangeChanged = true;
                const formatted = picker.startDate.format('DD-MM-YYYY') + ' to ' + picker.endDate.format('DD-MM-YYYY');
                $('#selectedDate').text(formatted);
                loadFilteredTCData();
            });

            function overviewPage(id,ref,cut,st,ct,message){
                var designation = 'Travel Consultant';
                window.location.href='../overview_profile/overview.php?id='+id+'&ref='+ref+'&cut='+cut+'&st='+st+'&ct='+ct+'&message='+message+'&designation='+designation;
            }
        </script>
        <!-- Date Range Script -->
        <script type="text/javascript">
            $(function() {

                var start = moment().subtract(29, 'days');
                var end = moment();

                function cb(start, end) {
                    $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
                }

                $('#reportrange').daterangepicker({
                    startDate: start,
                    endDate: end,
                    ranges: {
                        'Today': [moment(), moment()],
                        'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                        'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                        'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                        'This Month': [moment().startOf('month'), moment().endOf('month')],
                        'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                    }
                }, cb);

                cb(start, end);

            });
        </script>
        <!-- Date Range Script -->

    </body>

</html>
