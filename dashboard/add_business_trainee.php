<?php
    include_once 'dashboard_user_details.php';
?>
<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable">
    <head>

        <meta charset="utf-8" />
        <title>Admin Dashboard | Business Trainee</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- App favicon -->
        <link rel="shortcut icon" href="assets/images/fav.png">

        <!-- jsvectormap css -->
        <link href="assets/libs/jsvectormap/css/jsvectormap.min.css" rel="stylesheet" type="text/css" />

        <!--Swiper slider css-->
        <link href="assets/libs/swiper/swiper-bundle.min.css" rel="stylesheet" type="text/css" />

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
                                <lord-icon src="javascript:void(0);" trigger="loop" colors="primary:#f7b84b,secondary:#f06548" style="width:100px;height:100px"></lord-icon>
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

                <div id="testpho"></div>
                <div id="testemails"></div>

                <div class="page-content">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="col-12"> <!-- Page title -->
                                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                        <h4 class="mb-sm-0">Add Business Trainee</h4>
                                        <div class="page-title-right">
                                            <ol class="breadcrumb m-0">
                                                <li class="breadcrumb-item">
                                                    <a href="view_business_trainee.php">View Business Trainee</a>
                                                </li>
                                                <li class="breadcrumb-item active">Add</li>
                                            </ol>
                                        </div>
                                    </div>
                                </div> <!-- page title end -->
                                <div class="card">
                                    <div class="card-body">
                                        <div class="h-100">
                                            <form>
                                                <div class="row g-3">
                                                    
                                                    <div class="col-lg-6">
                                                        <div class="form-floating">
                                                            <input type="text" class="form-control" id="user_id_name" placeholder="Enter Reference ID" value="<?php echo $userId; ?>" readonly>
                                                            <label for="user_id_name">User Id & Name</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="form-floating">
                                                            <input type="text" class="form-control" id="reference_name" placeholder="Enter Reference Name" value="<?php echo $userFname.' '.$userLname; ?>" readonly>
                                                            <label for="reference_name">Reference Name</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="form-floating">
                                                            <input type="text" class="form-control" id="firstname" placeholder="Enter your firstname">
                                                            <label for="firstname">First Name</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="form-floating">
                                                            <input type="text" class="form-control" id="lastname" placeholder="Enter your Lastname">
                                                            <label for="lastname">Last Name</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="form-floating">
                                                            <input type="text" class="form-control" id="nominee_name" placeholder="Enter Nominee Name">
                                                            <label for="nominee_name">Nominee Name</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="form-floating">
                                                            <input type="text" class="form-control" id="nominee_relation" placeholder="Enter Nominee Relation">
                                                            <label for="nominee_relation">Nominee Relation</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="form-floating">
                                                            <input type="email" class="form-control" id="email" placeholder="email">
                                                            <label for="email">Email Address</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="form-floating">
                                                            <input type="date" class="form-control" id="dob" placeholder="Enter Date">
                                                            <label for="dob">Date</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <p>Gender</p>
                                                        <input type="radio" id="test3" class="form-check-input gender" name="gender" value="male">
                                                        <label for="test3">Male</label>
                                                        <input type="radio" id="test4"  class="form-check-input gender ms-2" name="gender" value="female">
                                                        <label for="test4">Female</label>
                                                        <input type="radio" id="test5"  class="form-check-input gender ms-2" name="gender" value="others">
                                                        <label for="test5">Others</label>
                                                    </div>
                                                    <div class="col-lg-2">
                                                        <div class="form-floating">
                                                            <div class="form-floating">
                                                                <?php
                                                                    $stmt = $conn->prepare("SELECT * FROM countries WHERE status = 1 ORDER BY country_name ASC");
                                                                    $stmt->execute();                                            
                                                                    $stmt->setFetchMode(PDO::FETCH_ASSOC);
                                                                ?>
                                                                <select class="form-select" id="country_cd" aria-label="Floating label select example">
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
                                                                <label for="country_cd">Code</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <div class="form-floating">
                                                            <input type="number" class="form-control" id="phone" placeholder="Enter your Phone Number">
                                                            <label for="phone">Phone Number</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="form-floating">
                                                            <?php
                                                                $stmt = $conn->prepare("SELECT * FROM countries WHERE status = 1 ORDER BY country_name ASC");
                                                                $stmt->execute();                                         
                                                                $stmt->setFetchMode(PDO::FETCH_ASSOC);
                                                            ?>
                                                            <select class="form-select" id="country" aria-label="Floating label select example">
                                                                <option value="" selected>--Select Country--</option>
                                                                <?php 
                                                                    if($stmt->rowCount()>0){
                                                                        foreach (($stmt->fetchAll()) as $key => $row) {  
                                                                            echo '<option value="'.$row['id'].'">'.$row['country_name'].'</option>'; 
                                                                        } 
                                                                    }else{ 
                                                                        echo '<option value="">Country not available</option>'; 
                                                                    } 
                                                                ?>
                                                            </select>
                                                            <label for="country">Country</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="form-floating">
                                                            <select class="form-select" id="mystate" aria-label="Floating label select example">
                                                                <option value="">--Select country first--</option>
                                                            </select>
                                                            <label for="mystate">State</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="form-floating">
                                                            <select class="form-select" id="city" aria-label="Floating label select example">
                                                                <option value="">--Select state first--</option>
                                                            </select>
                                                            <label for="city">City</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="form-floating">
                                                            <input type="text" class="form-control" id="pin" placeholder="Enter your zipcode">
                                                            <label for="pin">Pincode</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <div class="form-floating">
                                                            <input type="text" class="form-control" id="address" placeholder="Enter your Address">
                                                            <label for="address">Address</label>
                                                        </div>
                                                    </div>

                                                    <input type="hidden" id="testValue" name="testValue" value="15"> <!--Business Trainee  -->
                                                    
                                                    <div class="col-lg-12">
                                                        <div class="text-start">
                                                            <button type="submit" class="btn btn-primary" id="add-business-trainee">Submit</button>
                                                        </div>
                                                    </div>

                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> <!-- container-fluid -->
                </div><!-- End Page-content -->
                <footer class="footer">
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
                </footer>   
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
        <!-- <script src="assets/js/pages/plugins/lord-icon-2.1.0.js"></script> -->
        <!-- <script src="assets/js/plugins.js"></script> -->

        <script src="assets/js/submitdata.js"></script>

        <!-- !-- materialdesign icon js- -->
        <script src="assets/js/pages/remix-icons-listing.js"></script>

        <!-- apexcharts -->
        <script src="assets/libs/apexcharts/apexcharts.min.js"></script>

        <!-- Vector map-->
        <script src="assets/libs/jsvectormap/js/jsvectormap.min.js"></script>
        <script src="assets/libs/jsvectormap/maps/world-merc.js"></script>

        <!--Swiper slider js-->
        <script src="assets/libs/swiper/swiper-bundle.min.js"></script>

        <!-- Dashboard init -->
        <!-- <script src="assets/js/pages/dashboard-ecommerce.init.js"></script> -->

        <!-- App js -->
        <script src="assets/js/app.js"></script>

        <!-- Chart JS -->
        <!-- <script src="assets/libs/chart.js/chart.umd.js"></script> -->

        <!-- chartjs init -->
        <!-- <script src="assets/js/pages/chartjs.init.js"></script> -->

         <!-- Dashboard init -->
         <!-- <script src="assets/js/pages/dashboard-job.init.js"></script> -->

        <!-- ** designation user, user name on designation select / get country, state, city, pincode **  -->
        <script>
            //select Designation
            $('#designation').on('change', function() {
                var designation = $('#designation').val();
                // console.log(designation);
                $.ajax({
                    type:'POST',
                    url:'agents/get_user_Franchisee.php',
                    data: "designation="+designation,
                    success:function (e) {
                        // console.log(e);
                        $('#user_id_name').html(e); 
                    },
                    error: function(err){
                        console.log(err);
                    },
                });
            });

            // fetch User based on selected designation
            $('#user_id_name').on('change', function(){
                var user_id_name = $(this).val();
                // console.log(user_id_name);

                var designation = $('#designation').val();
                // console.log(designation);

                $.ajax({
                    type:'POST',
                    url:'agents/getUsers.php',
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
                        url:'address/countrydata.php',
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
                        url:'address/countrydata.php',
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
                        url:'address/pincode.php',
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
        </script>
    </body>
</html>