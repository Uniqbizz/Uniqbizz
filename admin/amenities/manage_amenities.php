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
        <title>MarkUp | Admin</title>
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
        <!-- App js -->
        <!-- <script src="../assets/js/plugin.js"></script> -->

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
                                <div class="page-title-box d-sm-flex p-4 card text-white" style="background-color: #0036A2;">
                                    <h4 class="mb-sm-0">Amenities</h4>
                                </div>
                            </div>
                        </div>
                        <!-- end page title -->

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="card">
                                            <div class="col-lg-12 d-flex justify-content-between pb-3 pt-3 ps-3 mb-4" style="border-bottom: 1px solid #DDDDDD">
                                                <h5 class="mt-3 fw-bold fs-3">Manage Stay Types</h5>
                                                <div class="dropdown mt-">
                                                    <a class="" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false"><i class="mdi mdi-dots-vertical-circle-outline mdi-36px pe-3" style="color: grey;"></i></a>
                                                    <div class="dropdown-menu" id="dr-users" aria-labelledby="dropdownMenuButton">
                                                        <a class="dropdown-item" href="add_new_stay_types.php">Add Stay Types</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="table-responsive table-desi">
                                                    <table class="table table-hover" id="user_table">
                                                        <thead>
                                                            <tr>
                                                                <th>Sr No</th>
                                                                <th> Name</th>
                                                                <th>Edit</th>
                                                                <th>Delete</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                                require '../connect.php';
                                                                $stmt = $conn->prepare("SELECT * FROM category_hotel where status='1'");
                                                                $stmt->execute();
                                                                $stmt->setFetchMode(PDO::FETCH_ASSOC);
                                                                if($stmt->rowCount()>0){
                                                                    foreach (($stmt->fetchAll()) as $key => $row) {
                                                                        $id= $row['id'];
                                                                        $name= $row['name'];
                                                                        echo '
                                                                        <tr>
                                                                            <td><span class="fw-bold">'.++$key.'</span></td>
                                                                            <td><span class="fw-bold">'.$name.'</span></td>
                                                                            <td>
                                                                                <a href="#" onclick=\'editfuncHotel("' .$id. '")\'><i class="mdi mdi-pencil text-success mdi-24px" aria-hidden="true"></i></a>
                                                                            </td>
                                                                            <td>
                                                                                <a href="#" onclick=\'deletefuncHotel("' .$id. '")\'><i class="mdi mdi-trash-can text-danger mdi-24px" aria-hidden="true"></i></a>
                                                                            </td>
                                                                        </tr>';
                                                                    }
                                                                }else{
                                                                    echo '<tr>
                                                                            <td colspan="4">No Category Avaiable</td>
                                                                    <tr>';
                                                                }
                                                            ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="card">
                                            <div class="col-lg-12 d-flex justify-content-between pb-3 pt-3 ps-3 mb-4" style="border-bottom: 1px solid #DDDDDD">
                                                <h5 class="mt-3 fw-bold fs-3">Manage Meals</h5>
                                                <div class="dropdown mt-">
                                                    <a class="" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false"><i class="mdi mdi-dots-vertical-circle-outline mdi-36px pe-3" style="color: grey;"></i></a>
                                                    <div class="dropdown-menu" id="dr-users" aria-labelledby="dropdownMenuButton">
                                                        <a class="dropdown-item" href="add_new_meals.php">Add Meals</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="table-responsive table-desi">
                                                    <table class="table table-hover" id="user_table">
                                                        <thead>
                                                            <tr>
                                                                <th>Sr No</th>
                                                                <th> Name</th>
                                                                <th>Edit</th>
                                                                <th>Delete</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                                require '../connect.php';
                                                                $stmt = $conn->prepare("SELECT * FROM category_meal where status='1' ");
                                                                $stmt->execute();
                                                                $stmt->setFetchMode(PDO::FETCH_ASSOC);
                                                                if($stmt->rowCount()>0){
                                                                    foreach (($stmt->fetchAll()) as $key => $row) {
                                                                        $id= $row['id'];
                                                                        $name= $row['name'];
                                                                        echo '<tr>
                                                                                <td><span class="fw-bold">'.++$key.'</span></td>
                                                                                <td><span class="fw-bold">'.$name.'</span></td>
                                                                                <td>
                                                                                    <a href="#" onclick=\'editfuncMeal("' .$id. '")\'><i class="mdi mdi-pencil text-success mdi-24px" aria-hidden="true"></i></a>
                                                                                </td>
                                                                                <td>
                                                                                    <a href="#" onclick=\'deletefuncMeal("' .$id. '")\'><i class="mdi mdi-trash-can text-danger mdi-24px" aria-hidden="true"></i></a>
                                                                                </td>
                                                                            </tr>';
                                                                    }
                                                                }else{
                                                                    echo '<tr>
                                                                    <td colspan="4">No Category Avaiable
                                                                    </td>
                                                                    <tr>';
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
                        <!-- end row -->
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="card">
                                            <div class="col-lg-12 d-flex justify-content-between pb-3 pt-3 ps-3 mb-4" style="border-bottom: 1px solid #DDDDDD">
                                                <h5 class="mt-3 fw-bold fs-3">Manage Vehicle</h5>
                                                <div class="dropdown mt-">
                                                    <a class="" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false"><i class="mdi mdi-dots-vertical-circle-outline mdi-36px pe-3" style="color: grey;"></i></a>
                                                    <div class="dropdown-menu" id="dr-users" aria-labelledby="dropdownMenuButton">
                                                        <a class="dropdown-item" href="add_new_vehicle.php">Add Vehicles</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="table-responsive table-desi">
                                                    <table class="table table-hover" id="user_table">
                                                        <thead>
                                                            <tr>
                                                                <th>Sr No</th>
                                                                <th> Name</th>
                                                                <th>Edit</th>
                                                                <th>Delete</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                                require '../connect.php';
                                                                $stmt = $conn->prepare("SELECT * FROM category_vehicle where status='1' ");
                                                                $stmt->execute();
                                                                $stmt->setFetchMode(PDO::FETCH_ASSOC);
                                                                if($stmt->rowCount()>0){
                                                                    foreach (($stmt->fetchAll()) as $key => $row) {
                                                                        $id= $row['id'];
                                                                        $name= $row['name'];
                                                                        echo '<tr>
                                                                                <td><span class="fw-bold">'.++$key.'</span></td>
                                                                                <td><span class="fw-bold">'.$name.'</span></td>
                                                                                <td>
                                                                                    <a href="#" onclick=\'editfuncVehicle("' .$id. '")\'><i class="mdi mdi-pencil text-success mdi-24px" aria-hidden="true"></i></a>
                                                                                </td>
                                                                                <td>
                                                                                    <a href="#" onclick=\'deletefuncVehicle("' .$id. '")\'><i class="mdi mdi-trash-can text-danger mdi-24px" aria-hidden="true"></i></a>
                                                                                </td>
                                                                            </tr>';
                                                                    }
                                                                }else{
                                                                    echo '<tr>
                                                                    <td colspan="4">No Category Avaiable
                                                                    </td>
                                                                    <tr>';
                                                                }
                                                            ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="card">
                                            <div class="col-lg-12 d-flex justify-content-between pb-3 pt-3 ps-3 mb-4" style="border-bottom: 1px solid #DDDDDD">
                                                <h5 class="mt-3 fw-bold fs-3">Manage Occupancy</h5>
                                                <div class="dropdown mt-">
                                                    <a class="" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false"><i class="mdi mdi-dots-vertical-circle-outline mdi-36px pe-3" style="color: grey;"></i></a>
                                                    <div class="dropdown-menu" id="dr-users" aria-labelledby="dropdownMenuButton">
                                                        <a class="dropdown-item" href="add_new_occupancy.php">Add Occupancy</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="table-responsive table-desi">
                                                    <table class="table table-hover" id="user_table">
                                                        <thead>
                                                            <tr>
                                                                <th>Sr No</th>
                                                                <th> Name</th>
                                                                <th>Edit</th>
                                                                <th>Delete</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                                require '../connect.php';
                                                                $stmt = $conn->prepare("SELECT * FROM category_occupancy where status='1' ");
                                                                $stmt->execute();
                                                                $stmt->setFetchMode(PDO::FETCH_ASSOC);
                                                                if($stmt->rowCount()>0){
                                                                    foreach (($stmt->fetchAll()) as $key => $row) {
                                                                        $id= $row['id'];
                                                                        $name= $row['name'];
                                                                        echo '<tr>
                                                                                <td><span class="fw-bold">'.++$key.'</span></td>
                                                                                <td><span class="fw-bold">'.$name.'</span></td>
                                                                                <td>
                                                                                    <a href="#" onclick=\'editfuncOccupancy("' .$id. '")\'><i class="mdi mdi-pencil text-success mdi-24px" aria-hidden="true"></i></a>
                                                                                </td>
                                                                                <td>
                                                                                    <a href="#" onclick=\'deletefuncOccupancy("' .$id. '")\'><i class="mdi mdi-trash-can text-danger mdi-24px" aria-hidden="true"></i></a>
                                                                                </td>
                                                                            </tr>';
                                                                    }
                                                                }else{
                                                                    echo '<tr>
                                                                    <td colspan="4">No Category Avaiable
                                                                    </td>
                                                                    <tr>';
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

        <!-- JAVASCRIPT -->
        <script src="../assets/libs/jquery/jquery.min.js"></script>
        <script src="../assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="../assets/libs/metismenu/metisMenu.min.js"></script>
        <script src="../assets/libs/simplebar/simplebar.min.js"></script>
        <script src="../assets/libs/node-waves/waves.min.js"></script>
        <!-- bootstrap-datepicker js -->
        <script src="../assets/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
        
        <!-- ecommerce-customer-list init -->
        <!-- <script src="../assets/js/pages/ecommerce-customer-list.init.js"></script> -->
        
        <!-- App js -->
        <script src="../assets/js/app.js"></script>
        
        <script type="text/javascript">
            // edit hotel function
            function editfuncHotel(id)
            {
                window.location.href='edit_stay_types?vkvbvjfgfikix='+id;
            };

            // delete hotel function
            function deletefuncHotel(id)
            {
                var dataString = 'id='+ id;
                var r = confirm("You are about to delete a Stay Type.\nDo you want to delete the Stay Type?");

                if (r == true) {
                        $.ajax({
                        type: "POST",
                        url: "delete_stay_types",
                        data: dataString,
                        cache: false,
                            success:function(data){
                                if(data == 1){
                                    alert("Delete Succesfully");
                                    window.location.reload();
                                }else{
                                    alert("Deletion Failed");
                                }
                            }
                        });
                };
            }

            // edit meals function
            function editfuncMeal(id)
            {
                window.location.href='edit_meals?vkvbvjfgfikix='+id;
            };

            // delete meals function
            function deletefuncMeal(id)
            {
                var dataString = 'id='+ id;
                var r = confirm("You are about to delete a Meal.\nDo you want to delete the Meal?");

                if (r == true) {
                        $.ajax({
                        type: "POST",
                        url: "delete_meals",
                        data: dataString,
                        cache: false,
                            success:function(data){
                                if(data == 1){
                                    alert("Delete Succesfully");
                                    window.location.reload();
                                }else{
                                    alert("Deletion Failed");
                                }
                            }
                        });
                };
            }


            // edit vehicle function
            function editfuncVehicle(id)
                {
                    window.location.href='edit_vehicle?vkvbvjfgfikix='+id;
                };

            // delete vehicle function
            function deletefuncVehicle(id)
            {
                var dataString = 'id='+ id;
                var r = confirm("You are about to delete a Vehicle.\nDo you want to delete the Vehicle?");

                if (r == true) {
                        $.ajax({
                        type: "POST",
                        url: "delete_vehicle",
                        data: dataString,
                        cache: false,
                            success:function(data){
                                if(data == 1){
                                    alert("Delete Succesfully");
                                    window.location.reload();
                                }else{
                                    alert("Deletion Failed");
                                }
                            }
                        });
                };
            }

            // edit occupancy function
            function editfuncOccupancy(id)
            {
                window.location.href='edit_occupancy?vkvbvjfgfikix='+id;
            };

            // delete occupancy function
            function deletefuncOccupancy(id)
            {
                var dataString = 'id='+ id;
                var r = confirm("You are about to delete a Occupancy.\nDo you want to delete the Occupancy?");

                if (r == true) {
                        $.ajax({
                        type: "POST",
                        url: "delete_occupancy",
                        data: dataString,
                        cache: false,
                            success:function(data){
                                if(data == 1){
                                    alert("Delete Succesfully");
                                    window.location.reload();
                                }else{
                                    alert("Deletion Failed");
                                }
                            }
                        });
                };
            }

        </script>
    </body>

</html>