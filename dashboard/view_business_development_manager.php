<?php
    // only CBD can add BC thats why no conditions require for pending and register tables
    include_once 'dashboard_user_details.php';
?>
<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable">
    <head>

        <meta charset="utf-8" />
        <title> Dashboard | Business Development Manager</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- App favicon -->
        <link rel="shortcut icon" href="assets/images/fav.png">

        <!-- jsvectormap css -->
        <link href="assets/libs/jsvectormap/css/jsvectormap.min.css" rel="stylesheet" type="text/css" />

        <!--Swiper slider css-->
        <link href="assets/libs/swiper/swiper-bundle.min.css" rel="stylesheet" type="text/css" />

        <!-- DataTables -->
        <link href="assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
        <!-- Responsive datatable examples -->
        <link href="assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />  

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
    </head>

    <body>
 
        <!-- Begin page -->
        <div id="layout-wrapper">

            <?php include_once 'header.php'; ?>

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
           
            <?php include_once 'sidebar.php'; ?>

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
                                <h4 class="mb-sm-0">View Business Development Manager</h4> 
                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="index.php">Dashboard </a></li>
                                        <li class="breadcrumb-item active">View Business Development Manager</li>
                                    </ol>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- end page title -->

                        <div class="row">
                            <div class="col">

                                <div class="h-100">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="card">
                                                <div class="card-header border-bottom-dashed">
                                                    <div class="row g-4 align-items-center">
                                                        <div class="col-sm">
                                                            <div>
                                                                <h5 class="card-title mb-0">Pending List</h5>
                                                            </div>
                                                        </div>
                                                    </div>   
                                                </div>    
                                                <div class="card-body">
                                                    <table id="example-dataTable" class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%">
                                                        <thead>
                                                            <tr>
                                                                <th data-ordering="false">SR No.</th>
                                                                <th data-ordering="false">Name</th>
                                                                <th data-ordering="false">Reference</th>
                                                                <th data-ordering="false">Phone</th>
                                                                <th data-ordering="false">Joining Date</th>
                                                                <th data-ordering="false">Status</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                                $sql = "SELECT * FROM `employees` WHERE reporting_manager = '".$userId."' AND (status = '0' OR status = '2')";
                                                                $stmt = $conn -> prepare($sql);
                                                                $stmt -> execute();
                                                                $stmt -> setFetchMode(PDO::FETCH_ASSOC);
                                                                if($stmt -> rowCount()>0){
                                                                    foreach(($stmt -> fetchAll()) as $key => $row){
                                                                        $bd= new DateTime($row['date_of_birth']);
                                                                        $bdate= $bd->format('d-m-Y');
                                                                        $dt= new DateTime($row['register_date']);
                                                                        $datev= $dt->format('d-m-Y'); 
                                                                        $reporting_manager_id = $row['reporting_manager'];

                                                                        $stmt2 = $conn->prepare( "SELECT name FROM employees WHERE employee_id = ? AND status = '1' " );
                                                                        $stmt2 -> execute([$reporting_manager_id]);
                                                                        $stmt2 -> setFetchMode(PDO::FETCH_ASSOC);
                                                                        if($stmt2-> rowCount()>0){
                                                                            foreach( ($stmt2->fetchAll()) as $key2 => $row2 ){
                                                                                $reporting_manager_name = $row2['name'];
                                                                            }
                                                                        }
                                                                        echo'<tr>
                                                                            <td>'.$row['id'].'</td>
                                                                            <td>'.$row['name'].'</td>
                                                                            <td>
                                                                                <p>'.$reporting_manager_id.'</p>
                                                                                <p>'.$reporting_manager_name.'</p>
                                                                            </td>
                                                                            <td>'.$row['contact'].'</td>
                                                                            <td>'.$datev.'</td>';
                                                                            if($row['status'] == '2')
                                                                                echo'<td><span class="badge bg-warning">Pending</span></td>';
                                                                            else{
                                                                                echo'<td><span class="badge bg-danger">Deleted</span></td>';
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

                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="card">
                                                <div class="card-header">
                                                    <h5 class="card-title mb-0">Registered List</h5>
                                                </div>
                                                <div class="card-body">
                                                    <table id="example-dataTable-2" class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%">
                                                        <thead>
                                                            <tr>
                                                                <th data-ordering="false">BDM ID & Name</th>
                                                                <th data-ordering="false">Reporting Manager ID </th>
                                                                <th data-ordering="false">Phone</th>
                                                                <th data-ordering="false">Joining Date</th>
                                                                <th data-ordering="false">Status</th>
                                                                <th data-ordering="false">Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                                $sql = "SELECT * FROM `employees` WHERE reporting_manager = ? AND (status = '1' OR status = '3')";
                                                                $stmt = $conn -> prepare($sql);
                                                                $stmt -> execute([$userId]);
                                                                $stmt -> setFetchMode(PDO::FETCH_ASSOC);
                                                                if($stmt -> rowCount()>0){
                                                                    foreach(($stmt -> fetchAll()) as $key => $row){
                                                                        $bd= new DateTime($row['date_of_birth']);
                                                                        $bdate= $bd->format('d-m-Y');
                                                                        $dt= new DateTime($row['register_date']);
                                                                        $datev= $dt->format('d-m-Y'); 

                                                                        $reporting_manager = $row['reporting_manager'];
                                                                        $stmt2 = $conn->prepare(' SELECT name FROM employees WHERE employee_id = ? ');
                                                                        $stmt2 -> execute([$reporting_manager]);
                                                                        $stmt2 -> setFetchMode(PDO::FETCH_ASSOC);
                                                                        if($stmt2-> rowCount()>0){
                                                                            foreach(($stmt2 -> fetchAll()) as $row2 => $key2){
                                                                                $reporting_manager_name = $key2['name'];
                                                                            }
                                                                        }
                                                                        echo'<tr>
                                                                            <td>
                                                                                <p>'.$row['employee_id'].'</p>
                                                                                <p>'.$row['name'].'</p>
                                                                            </td>
                                                                            <td>
                                                                                <p>'.$reporting_manager.'</p>
                                                                                <p>'.$reporting_manager_name.'</p>
                                                                            </td>
                                                                            <td>'.$row['contact'].'</td>
                                                                            <td>'.$datev.'</td>';
                                                                            
                                                                            if($row['status'] == '3')
                                                                                echo'<td><span class="badge bg-danger">Deactive</span></td>';
                                                                            else{
                                                                                echo'<td><span class="badge bg-success">Active</span></td>';
                                                                            }
                                                                            if($row['status'] == '1'){
                                                                                echo'<td>
                                                                                    <div class="dropdown d-inline-block">
                                                                                        <button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                                                            <i class="ri-more-fill align-middle"></i>
                                                                                        </button>
                                                                                        <ul class="dropdown-menu dropdown-menu-end">
                                                                                            <li><a class="dropdown-item edit-item-btn" onclick=\'overviewPage("'.$row["employee_id"]. '","' .$row["reporting_manager"]. '","' .$row["department"]. '","' .$row["designation"]. '","' .$row["zone"]. '", "'.$row['branch'].'","business_developement_manager")\'><i class="ri-eye-fill align-bottom me-2 text-muted"></i> Overview</a></li>
                                                                                            <li><a class="dropdown-item edit-item-btn" onclick=\'editfunc("' .$row["employee_id"]. '","' .$row["department"]. '","' .$row["designation"]. '","' .$row["zone"]. '", "'.$row['branch'].'","registered")\'><i class="ri-pencil-fill align-bottom me-2 text-muted"></i> Edit</a></li>
                                                                                            <li><a class="dropdown-item remove-item-btn" onclick=\'deletefunc("'.$row["id"].'","'.$row["employee_id"].'","registered","'.$userId.'","'.$userType.'")\'><i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i> Delete</a></li>
                                                                                        </ul>
                                                                                    </div>
                                                                                </td>';
                                                                            }else{
                                                                                echo'<td>
                                                                                <div class="dropdown d-inline-block">
                                                                                    <button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                                                        <i class="ri-more-fill align-middle"></i>
                                                                                    </button>
                                                                                    <ul class="dropdown-menu dropdown-menu-end">
                                                                                        <li><a class="dropdown-item remove-item-btn" onclick=\'deletefunc("'.$row["id"].'","'.$row["employee_id"].'","deactivate","'.$userId.'","'.$userType.'")\'><i class="ri-arrow-go-back-fill align-bottom me-2 text-muted"></i> Restore</a></li>
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
                            
                            </div>

                        </div>
                        
                        <?php if($userType == '24'){ ?> 
                            <div class="btn" style="width: 25px; height: 25px; padding: 0px; position: fixed; bottom: 120px; right: 35px; border-radius: 50%;">
                                <a href="add_business_development_manager.php" style="display: flex; justify-content: center; align-items: center; height: -webkit-fill-available;">
                                    <i class="fa-solid fa-circle-plus fa-beat-fade fa-3x" style="color: #4b38b3;"></i>
                                </a>
                            </div>
                        <?php } ?> 
                    </div> <!-- container-fluid -->

                </div><!-- End Page-content -->

                <footer class="footer"> <!-- footer start -->
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
                </footer> <!-- footer end -->
                
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
        <script src="assets/js/jquery/jquery-3.7.1.min.js"></script>

        <!-- Required datatable js -->
        <script src="assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
        <script src="assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
        
        <!-- Responsive examples -->
        <script src="assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
        <script src="assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>

    <!-- <script src="assets/js/pages/datatables.init.js"></script> -->

        <!-- <script src="assets/js/pages/plugins/lord-icon-2.1.0.js"></script> -->
        <!-- <script src="assets/js/plugins.js"></script> -->

        <!-- !-- materialdesign icon js- -->
        <script src="assets/js/pages/remix-icons-listing.js"></script>

        <!-- apexcharts -->
        <!-- <script src="assets/libs/apexcharts/apexcharts.min.js"></script> -->
<!--  -->
        <!-- Vector map-->
        <!-- <script src="assets/libs/jsvectormap/js/jsvectormap.min.js"></script> -->
        <!-- <script src="assets/libs/jsvectormap/maps/world-merc.js"></script> -->

        <!--Swiper slider js-->
        <!-- <script src="assets/libs/swiper/swiper-bundle.min.js"></script> -->

        <!-- Dashboard init -->
        <!-- <script src="assets/js/pages/dashboard-ecommerce.init.js"></script> -->

        <!-- App js -->
        <script src="assets/js/app.js"></script>

        <!-- Chart JS -->
        <!-- <script src="assets/libs/chart.js/chart.umd.js"></script>// -->

        <!-- chartjs init -->
        <!-- <script src="assets/js/pages/chartjs.init.js"></script>// -->

         <!-- Dashboard init -->
         <!-- <script src="assets/js/pages/dashboard-job.init.js"></script> -->

         <script>
            $(document).ready(function(){
                $("#example-dataTable").DataTable();
                $("#example-dataTable-2").DataTable();
            });

            function editfunc(id,dept,desig,zn,br,editfor){
                window.location.href='edit_business_development_manager.php?vkvbvjfgfikix='+id+'&dept='+dept+'&desig='+desig+'&zn='+zn+'&br='+br+'&editfor='+editfor;
            };

            function deletefunc(id,fid,action,userId,userType){
                var dataString = 'id='+id+'&fid='+fid+'&action='+action+'&userId='+userId+'&userType='+userType;

                $.ajax({
                    type: "POST",
                    url: "business_development_manager/delete_business_development_manager_data.php",
                    data: dataString,
                    cache: false,
                    success:function(data){
                        console.log(data);
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

            function overviewPage(id,ref,dept,desig,zn,br,message){
                var designation = 'business_developement_manager';
                //alert("Under Maintenance");
                window.location.href='overview.php?id='+id+'&ref='+ref+'&dept='+dept+'&desig='+desig+'&zn='+zn+'&br='+br+'&message='+message+'&designation='+designation;
            }
        </script>
    </body>
</html>