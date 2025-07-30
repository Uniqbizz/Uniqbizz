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
        <title>Category | Admin</title>
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
        <style>
            .table{
                margin-bottom: 0rem !important;
                vertical-align: bottom !important;
            }
            .table-responsive{
                padding: 25px;
                padding-top: 0px;
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
                        <!-- <div class="row">
                            <div class="col-12">
                                <div class="page-title-box d-sm-flex p-4 card text-white" style="background-color: #0036A2;">
                                    <h4 class="mb-sm-0">Manage Categories</h4>
                                </div>
                            </div>
                        </div> -->
                        <!-- end page title -->

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <div class="card">
                                            <div class="col-lg-12 d-flex justify-content-between pb-3 pt-3 ps-3 mb-4" style="border-bottom: 1px solid #DDDDDD">
                                                <h5 class="mt-3 fw-bold fs-3">Manage Categories</h5>
                                                <div class="dropdown mt-">
                                                    <a class="" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false"><i class="mdi mdi-dots-vertical-circle-outline mdi-36px pe-3" style="color: grey;"></i></a>
                                                    <div class="dropdown-menu" id="dr-users" aria-labelledby="dropdownMenuButton">
                                                        <a class="dropdown-item" href="add_new_category.php">Add New Category</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="table-responsive table-desi">
                                                    <table class="table table-hover" id="user_table">
                                                        <thead class="p-3">
                                                            <tr style="border-bottom: 2px solid #ddd;" class="text-uppercase">
                                                                <th class="ps-4">Category Name</th>
                                                                <!-- <th> Name</th> -->
                                                                <th>Edit</th>
                                                                <th>Delete</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                                require '../connect.php';
                                                                
                                                                $stmt = $conn->prepare("SELECT * FROM category where status='1' ");
                                                                $stmt->execute();

                                                                    // set the resulting array to associative
                                                                $stmt->setFetchMode(PDO::FETCH_ASSOC);

                                                                if($stmt->rowCount()>0){
                                                                    foreach (($stmt->fetchAll()) as $key => $row) {
                                                                        $cat_id= $row['id'];
                                                                        $category_name= $row['category_name'];
                                                                    
                                                                        echo 
                                                                        '<tr>
                                                                            <td class="ps-4 fw-bolder"><span class="list-enq-name">'.$category_name.'</span></td>
                                                                            
                                                                            <td>
                                                                                <a onclick=\'editfuncCat("' .$cat_id. '")\'><i class="mdi mdi-pencil text-success mdi-24px" aria-hidden="true"></i></a>
                                                                            </td>
                                                                            <td>
                                                                                <a href="#" onclick=\'deletefunc("' .$cat_id. '")\'><i class="mdi mdi-trash-can text-danger mdi-24px" aria-hidden="true"></i></a>
                                                                            </td>
                                                                        </tr>';
                                                                    }
                                                                } else{
                                                                        echo 
                                                                            '<tr>
                                                                                <td colspan="4">No Category Available
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
        
            function editfuncCat(id)
            { 
                window.location.href='edit_category?vkvbvjfgfikix='+id;  
            };

            function editfuncSubCat(id)
            { 
                window.location.href='edit_sub_category?vkvbvjfgfikix='+id;  
            };

            function deletefunc(id)
            { 

                var dataString = 'id='+ id;

                var r = confirm("Do you want to delete the Category?");
                if (r == true) {

                        $.ajax({
                        type: "POST",
                        url: "delete_category",
                        data: dataString,
                        cache: false,
                        success:function(data){
                            if(data == 1){

                            alert("Delete Succesfully");
                            window.location.reload();
                        }
                        else{

                        alert("Deletion Failed");
                        }
                    }
                    });
                    
                } else {
                    
                }   
            };


            function deletefuncSub(id)
            { 

                var dataString = 'id='+ id;

                var r = confirm("Do you want to delete the Sub Category?");
                if (r == true) {

                        $.ajax({
                        type: "POST",
                        url: "delete_sub_category.php",
                        data: dataString,
                        cache: false,
                        success:function(data){
                            if(data == 1){

                            alert("Delete Succesfully");
                            window.location.reload();
                        }
                        else{

                        alert("Deletion Failed");
                        }
                    }
                    });
                    
                } else {
                    
                }   
                
            };

        </script>
    </body>

</html>