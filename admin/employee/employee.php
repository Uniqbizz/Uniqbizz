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
        <title>Employee | Admin Dashboard </title>
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
        <link rel="stylesheet" href="../assets/css/loadingScreen.css" rel="stylesheet" type="text/css" />
        <!-- App js -->
        <!-- <script src="../assets/js/plugin.js"></script> -->
        <!-- Font awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />            

        <style>
            /* dataTable, action col, dropdown align right  */

            @media screen and (max-width: 1191px) {
                .dropdown-menu-end-1[style] {
                    left: 25%!important;
                    right: 25%!important;
                }
            }
            @media screen and (max-width: 991px) and (min-width: 941px) {
                .dropdown-menu-end-1[style] {
                    left: -250%!important;
                    right: -250%!important;
                    width: 80px !important;
                }
            }
            @media screen and (max-width: 1345px) and (min-width: 1264px) {
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
                                    <h4 class="mb-sm-0 font-size-18">Employee</h4>

                                    <!-- <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Ecommerce</a></li>
                                            <li class="breadcrumb-item active">Customers</li>
                                        </ol> -->
                                    <!-- </div> -->

                                </div>
                            </div>
                        </div>
                        <!-- end page title -->

                         <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row mb-2">
                                            <div class="col-sm-6">
                                                <div class="search-box me-2 mb-2 d-inline-block">
                                                    <div class="position-relative">
                                                        <h4>Pending Employee List</h4>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- <div class="col-sm-6">
                                                <div class="text-sm-end">
                                                    <button type="button" data-bs-toggle="modal" data-bs-target="#newCorporateAgencyModal" class="btn btn-success btn-rounded waves-effect waves-light mb-2 me-2 addCorporateAgencymodal"><i class="mdi mdi-plus me-1"></i> New Corporate Agency</button>
                                                </div>
                                            </div> -->
                                        </div>

                                        <div class="table-responsive">
                                            <table class="table align-middle table-nowrap dt-responsive nowrap w-100" id="pendingCustomerList-table">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th>Id</th>
                                                        <th>Full Name</th>
                                                        <!-- <th>Reference ID / Name</th> -->
                                                        <th>Phone / Email</th>
                                                        <th>Address</th>
                                                        <th>Joining Date</th>
                                                        <th>Status</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                        $sql = "SELECT * FROM `employees` WHERE status = '2' OR status = '0' ORDER BY employee_id ASC ";
                                                        $stmt = $conn -> prepare($sql);
                                                        $stmt -> execute();
                                                        $stmt -> setFetchMode(PDO::FETCH_ASSOC);
                                                        if($stmt->rowCount()>0){
                                                            foreach(($stmt->fetchAll()) as $key => $row) {
                                                                $bd= new DateTime($row['date_of_birth']);
                                                                $bdate= $bd->format('d-m-Y');

                                                                $rd= new DateTime($row['added_on']);
                                                                $rdate= $rd->format('d-m-Y');

                                                                echo'<tr>
                                                                    <td>'.$row['id'].'</td>
                                                                    <td>'.$row['name'].'</td>
                                                                    <td>
                                                                        <p class="mb-1">+'.$row['country_code'].' '.$row['contact'].'</p>
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
                                                                                <ul class="dropdown-menu dropdown-menu-left dropdown-menu-left-1">
                                                                                    <li><a href="#" onclick=\'editfuncCust("' .$row["id"]. '","' .$row["reporting_manager"]. '","' .$row["register_by"]. '","' .$row["department"]. '","' .$row["designation"]. '","' .$row["zone"]. '"," '.$row['branch'].' ","pending")\' class="dropdown-item" data-bs-toggle="modal" ><i class="mdi mdi-pencil font-size-16 text-primary me-1"></i> Edit</a></li>
                                                                                    <li><a href="#" onclick=\'deletefunc("' .$row["id"]. '","","pending","' .$row['user_type']. '")\' class="dropdown-item" data-bs-toggle="modal" ><i class="mdi mdi-trash-can font-size-16 text-danger me-1"></i> Delete</a></li>
                                                                                    <li><a href="#" onclick=\'confirmfunc("' .$row["id"]. '","' .$row["email"]. '")\' class="dropdown-item" data-bs-toggle="modal" ><i class="fas fa-check-circle font-size-16 text-success me-1"></i> Confirm</a></li>
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
                                                                                <ul class="dropdown-menu dropdown-menu-left dropdown-menu-left-1">
                                                                                    <li><a href="#" onclick=\'deletefunc("' .$row["id"]. '","","deleted","' .$row['user_type']. '")\' class="dropdown-item" data-bs-toggle="modal" ><i class="mdi mdi-file-restore font-size-16 text-success me-1"></i> Restore</a></li>
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
                                                        <h4>Registered Employee List</h4>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- <div class="col-sm-8">
                                                <div class="text-sm-end">
                                                    <button type="button" data-bs-toggle="modal" data-bs-target="#newCustomerModal" class="btn btn-success btn-rounded waves-effect waves-light mb-2 me-2 addCustomers-modal"><i class="mdi mdi-plus me-1"></i> New Customers</button>
                                                </div>
                                            </div> -->
                                            <!-- end col-->
                                        </div>
                                        
                                        <div class="table-responsive">
                                            <table class="table align-middle table-nowrap dt-responsive nowrap w-100" id="registeredCustomerList-table">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th>Employee Id</th>
                                                        <th>Designation</th> 
                                                        <th>Full Name</th>
                                                        <th>Reference ID / Name</th>
                                                        <th>Phone / Email</th>
                                                        <th>Joining Date</th>
                                                        <th>status</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                        $sql = "SELECT * FROM `employees` WHERE status = '1' OR status = '3' ORDER BY employee_id ASC ";
                                                        $stmt = $conn -> prepare($sql);
                                                        $stmt -> execute();
                                                        $stmt -> setFetchMode(PDO::FETCH_ASSOC);
                                                        if($stmt->rowCount()>0){
                                                            foreach(($stmt->fetchAll()) as $key => $row) {

                                                                //date formate 
                                                                $bd= new DateTime($row['date_of_birth']);
                                                                $bdate= $bd->format('d-m-Y');

                                                                //date formate
                                                                $rd= new DateTime($row['register_date']);
                                                                $rdate= $rd->format('d-m-Y');

                                                                //get reporting manager name
                                                                if($row['reporting_manager'] == 'null' || $row['reporting_manager'] == ''){
                                                                    $reporting_manager_name = 'N/A';
                                                                }else{
                                                                    $stmt2 = $conn -> prepare("SELECT * FROM `employees` WHERE employee_id = '".$row['reporting_manager']."' ");
                                                                    $stmt2 -> execute();
                                                                    $stmt2 -> setFetchMode(PDO::FETCH_ASSOC);
                                                                    if($stmt2->rowCount()>0){
                                                                        foreach(($stmt2->fetchAll()) as $key2 => $row2) {
                                                                            $reporting_manager_name = $row2['name'];
                                                                        }
                                                                    }
                                                                }

                                                                echo'<tr>
                                                                    <td>'.$row['employee_id'].'</td>
                                                                    <td>';
                                                                        if($row['user_type'] == '24'){
                                                                            echo "BCM";
                                                                        }else{
                                                                            echo "BDM";
                                                                        }
                                                                    echo'</td>
                                                                    <td>'.$row['name'].'</td>
                                                                    <td><p class="mb-1">'.$row['reporting_manager'].'</p>
                                                                        <p class="mb-0">'.$reporting_manager_name.'</p>
                                                                    </td>
                                                                    <td>
                                                                        <p class="mb-1">+'.$row['country_code'].' '.$row['contact'].'</p>
                                                                        <p class="mb-0">'.$row['email'].'</p>
                                                                    </td>
                                                                    <td>'.$rdate.'</td>';
                                                                    if($row['status']== '1'){
                                                                        echo'<td><span class="badge text-bg-success">Active</span></td>
                                                                        <td>
                                                                            <div class="dropdown">
                                                                                <a href="#" class="dropdown-toggle card-drop" data-bs-toggle="dropdown" aria-expanded="false">
                                                                                    <i class="mdi mdi-dots-horizontal font-size-18"></i>
                                                                                </a>
                                                                                <ul class="dropdown-menu dropdown-menu-left dropdown-menu-left-2">
                                                                                    <li><a href="#" onclick=\'overviewPage("'.$row["employee_id"]. '","' .$row["reporting_manager"]. '","' .$row["department"]. '","' .$row["designation"]. '","' .$row["zone"]. '"," '.$row['branch'].' ","employees",'.$row["user_type"].')\' class="dropdown-item" data-bs-toggle="modal" ><i class="mdi mdi-eye font-size-16 text-info me-1"></i> View</a></li>
                                                                                    <li><a href="#" onclick=\'editfuncCust("'.$row["employee_id"]. '","' .$row["reporting_manager"]. '","' .$row["register_by"]. '","' .$row["department"]. '","' .$row["designation"]. '","' .$row["zone"]. '"," '.$row['branch'].' ","registered")\' class="dropdown-item" data-bs-toggle="modal" ><i class="mdi mdi-pencil font-size-16 text-primary me-1"></i> Edit</a></li>
                                                                                    <li><a href="#" onclick=\'deletefunc("' .$row["id"]. '","'.$row["employee_id"]. '","registered","' .$row['user_type']. '")\' class="dropdown-item" data-bs-toggle="modal" ><i class="mdi mdi-trash-can font-size-16 text-danger me-1"></i> Delete</a></li>
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
                                                                                <ul class="dropdown-menu dropdown-menu-left dropdown-menu-left-2">
                                                                                    <li><a href="#" onclick=\'deletefunc("' .$row["id"]. '","'.$row["employee_id"]. '","deactivate","' .$row['user_type']. '")\' class="dropdown-item" data-bs-toggle="modal" ><i class="mdi mdi-file-restore font-size-16 text-success me-1"></i> Restore</a></li>
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
        <div class="btn" data-bs-toggle="modal" data-bs-target="#newBusinessOperationExecutiveModal" style="width: 25px; height: 25px; padding: 0px; position: fixed; bottom: 120px; right: 43px; border-radius: 50%;">
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
        <div class="modal fade" id="newBusinessOperationExecutiveModal" tabindex="-1" aria-hidden="true">
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
                            <button type="button" class="btn btn-success" id="add-item"><a href="addEmployee.php"><span style="color: white;">Add Now</span></a></button>
                            <button type="button" class="btn btn-secondary" id="close-newBusinessOperationExecutiveModal" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end newBusinessOperationExecutiveModal -->

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
            
            function editfuncCust(id,refno,regby,dept,desig,zn,br,editfor){ 
                window.location.href='editEmployee.php?vkvbvjfgfikix='+id+'&nohbref='+refno+'&fyfyfregby='+regby+'&dept='+dept+'&desig='+desig+'&zn='+zn+'&br='+br+'&editfor='+editfor;
            };

            function deletefunc(id,fid,action,userType){ 
                var dataString = 'id='+id+'&fid='+fid+'&action='+action+'&userType='+userType;

                $.ajax({
                type: "POST",
                url: "deleteEmployee.php",
                data: dataString,
                cache: false,
                    success:function(data){
                        // console.log('data'+data);
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

            function confirmfunc(id,email){ 

                var dataString = 'id='+ id+'&uname='+email;
                $("#loading-overlay").show(); //loading screen
                $.ajax({
                    type: "POST",
                    url: "confirmEmployee.php",
                    data: dataString,
                    cache: false,
                    success:function(data){
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

            function overviewPage(id,ref,dept,desig,zn,br,message,userType){
                if (userType == 24) {
                    var designation = 'business_chanel_manager';
                    message='business_chanel_manager';
                }else{
                    var designation = 'business_developement_manager';
                    message='business_developement_manager';
                }
                window.location.href='../overview_profile/overview.php?id='+id+'&ref='+ref+'&dept='+dept+'&desig='+desig+'&zn='+zn+'&br='+br+'&message='+message+'&designation='+designation;
            }
        </script>

    </body>

</html>
