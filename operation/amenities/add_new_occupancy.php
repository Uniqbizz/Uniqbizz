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
        <title>Add Occupancy</title>
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
        <div id="testpho"></div>
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
                        <div class="text-end p-3">
                            <!-- return previous page link -->
                            <li class="page-back" id="return_to_views_btn" style="display:block; padding-top: 10px"><a href="manage_amenities.php"><i class="fa fa-backward" aria-hidden="true"></i> Back</a></li>
                        </div>
                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12 card">
                                <div class="page-title-box d-sm-flex p-4">
                                    <h4 class="mb-sm-0">Add Occupancy</h4>
                                </div>
                                <div class="col-lg-12 col-md-12 col-12">
                                    <form>
                                        <div class="col-md-12 col-sm-12">
                                            <div class="form-floating mb-3">
                                                <input type="text" class="form-control" id="name" name="name" placeholder="Name">
                                                <label for="name" class="required">Name</label>
                                            </div>
                                        </div> 
                                        <div>
                                            <input type="hidden" id="invalidimage1" name="invalidimage1" >
                                        </div>
                                        <div class="row">
                                            <div class="btn bg-primary col-sm-1 m-4 ms-3" id="addOccupancy">
                                                <a href="#" class="waves-effect waves-light btn-large"  style=" color: white;">Save</a>
                                            </div>
                                        </div>  
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- end page title -->


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

        <!-- App js -->
        <script src="../assets/js/app.js"></script>

        <script type="text/javascript">
   
            $('#addOccupancy').click(function(e){
                    e.preventDefault();

                    var name = $('#name').val();
                


                    var characterLetters = /^[A-Za-z\s]+$/;
                    var specialChar = /[!@#$%^&*]/g;


                    var dataString = 'name='+ name;

                if (name ==='' || !name.match(characterLetters) || name.length <= 2){
                    alert("Enter Proper Name");
                
                }else{
                    $.ajax({
                        type: "POST",
                        url: "occupancy/create",
                        data: dataString,
                        cache: false,
                        success:function(data){
                            if(data == 1){
                                alert("Added Successfuly");
                                location.href = "manage_amenities";
                        }
                        else{

                        alert("Failed");
                        }
                    }
                    });
            
                }

            });

        </script>
    </body>

</html>