<?php
    // only CBD can add BC thats why no conditions require for pending and register tables
    include_once 'dashboard_user_details.php';
?>
<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable">
    <head>

        <meta charset="utf-8" />
        <title>Dashboard | Business Operation Executive</title>
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
        <link href="assets/css/loadingScreen.css" rel="stylesheet" type="text/css" />
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
                                        <h4 class="mb-sm-0">Add Business Operation Executive</h4>
                                        <div class="page-title-right">
                                            <ol class="breadcrumb m-0">
                                                <li class="breadcrumb-item">
                                                    <a href="view_travel_agent.php">View Business Operation Executive</a>
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

                                                    <div class="col-lg-12" id="paymentMode">
                                                        <p>Payment Mode</p>
                                                        <input type="radio" id="cashPayment" class="form-check-input payment" name="payment" value="cash">
                                                        <label for="cashPayment">Cash</label>
                                                        <input type="radio" id="chequePayment"  class="form-check-input payment ms-2" name="payment" value="cheque">
                                                        <label for="chequePayment">Cheque</label>
                                                        <input type="radio" id="onlinePayment"  class="form-check-input payment ms-2" name="payment" value="online">
                                                        <label for="onlinePayment">UPI/NEFT</label>
                                                    </div>

                                                    <div class="col-lg-12 d-none" id="chequeOpt" style="display:flex; justify-content: space-evenly;">
                                                        <div class="col-lg-3 ">
                                                            <div class="form-floating">
                                                                <input type="text" class="form-control" id="chequeNo" placeholder="Enter Cheque Number">
                                                                <label for="chequeNo">Cheque No</label>
                                                            </div>
                                                        </div>

                                                        <div class="col-lg-3 ">
                                                            <div class="form-floating">
                                                                <input type="text" class="form-control" id="chequeDate" placeholder="Enter Date On Cheque">
                                                                <label for="chequeDate">Cheque Date</label>
                                                            </div>
                                                        </div>

                                                        <div class="col-lg-3 ">
                                                            <div class="form-floating">
                                                                <input type="text" class="form-control" id="bankName" placeholder="Enter your Bank Name">
                                                                <label for="bankName">Bank Name</label>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-12 d-none" id="onlineOpt" style="display:flex; justify-content: space-evenly;">
                                                        <div class="col-lg-8">
                                                            <div class="form-floating">
                                                                <input type="text" class="form-control" id="transactionNo" placeholder="Enter your Transaction No.">
                                                                <label for="transactionNo">Transaction No.</label>
                                                            </div>
                                                        </div>
                                                    </div>   

                                                    <div class="col-lg-6">
                                                        <div class="mb-3">
                                                            <label for="file1"><b>PROFILE</b></label><br/>
                                                            <input type="file" name="file1" id="upload_file1">
                                                        </div>
                                                        <input type="hidden" id="img_path1" value="">
                                                        <div id="preview1" style="display: none;">
                                                            <div id="image_preview1">
                                                                <img  alt="Preview" id="img_pre1">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="mb-3">
                                                            <label for="file2"><b>AADHAR CARD</b></label><br/>
                                                            <input type="file" name="file2" id="upload_file2">
                                                        </div>
                                                        <input type="hidden" id="img_path2" value="">
                                                        <div id="preview2" style="display: none;">
                                                            <div id="image_preview2">
                                                                <img  alt="Preview" id="img_pre2">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="col-lg-6">
                                                        <div class="mb-3">
                                                            <label for="file3"><b>PAN CARD</b></label><br/>
                                                            <input type="file" name="file3" id="upload_file3">
                                                        </div>
                                                        <input type="hidden" id="img_path3" value="">
                                                        <div id="preview3" style="display: none;">
                                                            <div id="image_preview3">
                                                                <img  alt="Preview" id="img_pre3">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="mb-3">
                                                            <label for="file4"><b>BANK PASSBOOK</b></label><br/>
                                                            <input type="file" name="file4" id="upload_file4">
                                                        </div>
                                                        <input type="hidden" id="img_path4" value="">
                                                        <div id="preview4" style="display: none;">
                                                            <div id="image_preview4">
                                                                <img  alt="Preview" id="img_pre4">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="col-lg-6">
                                                        <div class="mb-3">
                                                            <label for="file5"><b>VOTING CARD</b></label><br/>
                                                            <input type="file" name="file5" id="upload_file5">
                                                        </div>
                                                        <input type="hidden" id="img_path5" value="">
                                                        <div id="preview5" style="display: none;">
                                                            <div id="image_preview5">
                                                                <img  alt="Preview" id="img_pre5">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- <div class="col-lg-6">
                                                        <div class="mb-3">
                                                            <label for="file6"><b>PAYMENT PROOF</b></label><br/>
                                                            <input type="file" name="file6" id="upload_file6">
                                                        </div>
                                                        <input type="hidden" id="img_path6" value="">
                                                        <div id="preview6" style="display: none;">
                                                            <div id="image_preview6">
                                                                <img  alt="Preview" id="img_pre6">
                                                            </div>
                                                        </div>
                                                    </div> -->

                                                    <input type="hidden" id="testValue" name="testValue" value="20"> <!-- business_operation_executive-->
                                                    
                                                    <div class="col-lg-12">
                                                        <div class="text-start">
                                                            <button type="submit" class="btn btn-primary" id="add-business-operation-executive">Submit</button>
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

        <!-- file upload code js file -->
        <script src="../uploading/uploadUser.js"></script>

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
            // $('#designation').on('change', function() {
            //     var designation = $('#designation').val();
            //     // console.log(designation);
            //     $.ajax({
            //         type:'POST',
            //         url:'agents/get_user_Franchisee.php',
            //         data: "designation="+designation,
            //         success:function (e) {
            //             // console.log(e);
            //             $('#user_id_name').html(e); 
            //         },
            //         error: function(err){
            //             console.log(err);
            //         },
            //     });
            // });

            // fetch User based on selected designation
            $('#user_id_name').on('change', function(){
                var user_id_name = $(this).val();
                // console.log(user_id_name);

                var designation = 'corporate_agency';
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

            $('#paymentMode').on('click', function(){
                var paymentMode = $(".payment:checked").val();
                // console.log(paymentMode);
                if(paymentMode == "cheque"){
                    $("#chequeOpt").removeClass("d-none");
                    $("#onlineOpt").addClass("d-none");
                }else if(paymentMode == "online"){
                    $("#onlineOpt").removeClass("d-none");
                    $("#chequeOpt").addClass("d-none");
                } else {
                    $("#chequeOpt").addClass("d-none");
                    $("#onlineOpt").addClass("d-none");
                }
            });
        </script>
    </body>
</html>