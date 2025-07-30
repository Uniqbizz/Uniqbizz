<?php
    include_once 'dashboard_user_details.php';

    $id = $_GET['vkvbvjfgfikix'];
    $country_id = $_GET['ncy'];
    $state_id = $_GET['mst'];
    $city_id = $_GET['hct'];
    $editfor = $_GET['editfor'];

    $stmt = $conn->prepare("SELECT * FROM `channel_business_director` WHERE channel_business_director_id='".$id."' ");
    $stmt->execute();
    // set the resulting array to associative
    $stmt->setFetchMode(PDO::FETCH_ASSOC);

    if($stmt->rowCount()>0){
        foreach (($stmt->fetchAll()) as $key => $row) {
            $fid=$row['id'];
            // $sales_manager_name=$row['fname'];
            $firstname=$row['firstname'];
            // $username=$row['username'];
            $lastname=$row['lastname'];
            $nominee_name=$row['nominee_name'];
            $nominee_relation=$row['nominee_relation'];
            $email=$row['email'];
            $contact_no=$row['contact_no'];
            // $business_package=$row['business_package'];
            // $amount=$row['amount'];
            $reference_no = $row['reference_no'];
            $registrant = $row['registrant'];
            // $gst_no=$row['gst_no'];
            $date_of_birth=$row['date_of_birth'];
            $gender=$row['gender'];
            $country=$row['country'];
            $state=$row['state'];
            $city=$row['city'];
            $address=$row['address'];
            // $id_proof=$row['id_proof'];
            // $profile_pic=$row['profile_pic'];
            // $kyc=$row['kyc'];
            // $pan_card=$row['pan_card'];
            // $aadhar_card=$row['aadhar_card'];
            // $voting_card=$row['voting_card'];
            // $bank_passbook=$row['passbook'];
            $pincode=$row['pincode'];
            // $complimentary=$row['complimentary'];
            // $converted=$row['converted'];

            //get country
            $countries = $conn->prepare("SELECT country_name FROM countries where id='".$country."' and status='1' ");
            $countries->execute();
            $countries->setFetchMode(PDO::FETCH_ASSOC);
            if($countries->rowCount()>0){
                $country = $countries->fetch();
                $countryname = $country['country_name'];
            }

            //get state
            $states = $conn->prepare("SELECT state_name FROM states where id='".$state."' and status='1' ");
            $states->execute();
            $states->setFetchMode(PDO::FETCH_ASSOC);
            if($states->rowCount()>0){
                $state = $states->fetch();
                $statename = $state['state_name'];
            }
            //get city
            $cities = $conn->prepare("SELECT city_name FROM cities where id='".$city."' and status='1' ");
            $cities->execute();
            $cities->setFetchMode(PDO::FETCH_ASSOC);
            if($cities->rowCount()>0){
                $city = $cities->fetch();
                $city_name = $city['city_name'];
            }

            // $reference_id = substr($reference_no, 0 , 2);
            // if($reference_id == "BT"){
            //     // business trainee name
            //     $business_trainees = $conn->prepare("SELECT firstname, lastname, reference_no FROM business_trainee where business_trainee_id='".$reference_no."'");
            //     $business_trainees ->execute();
            //     $business_trainees ->setFetchMode(PDO::FETCH_ASSOC);
            //     if(  $business_trainees->rowCount()>0 ){
            //         $business_trainee = $business_trainees->fetch();
            //         $reference_no_fname = $business_trainee['firstname'];
            //         $reference_no_lname = $business_trainee['lastname'];
            //         // $business_trainees_reference_no = $business_trainee['reference_no'];

            //     }

            // }else{
            //     // Travel agent name
            //     $travel_agents = $conn->prepare("SELECT firstname, lastname FROM travel_agent where travel_agent_id='".$reference_no."'");
            //     $travel_agents ->execute();
            //     $travel_agents ->setFetchMode(PDO::FETCH_ASSOC);
            //     if(  $travel_agents->rowCount()>0 ){
            //         $travel_agents = $travel_agents->fetch();
            //         $reference_no_fname = $travel_agents['firstname'];
            //         $reference_no_lname = $travel_agents['lastname'];
            //     }
            // } 
        }
    }
?>

<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable">
    <head>

        <meta charset="utf-8" />
        <title>Admin Dashboard | Channel Business Director</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
        <meta content="Themesbrand" name="author" />
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

           <?php include_once "header.php"; ?>
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

            <?php include_once "sidebar.php"; ?>
            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->
            <div class="main-content">

                <div class="page-content">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="col-12"> <!-- Page title -->
                                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                        <p class="mb-sm-0 head fw-bold text-uppercase">Edit Channel Business Director</p>
                                        <div class="page-title-right sub-title">
                                            <ol class="breadcrumb m-0">
                                                <li class="breadcrumb-item">
                                                    <a href="view_business_consultant.php">View Channel Business Director</a>
                                                </li>
                                                <li class="breadcrumb-item active">Edit</li>
                                            </ol>
                                        </div>
                                    </div>
                                </div> <!-- page title end -->
                                <div class="card">
                                    <div class="card-body">
                                        <div class="h-100">
                                            <form action="#">
                                                <div class="row g-3">
                                                    <!-- <div class="col-lg-4">
                                                        <div class="form-floating">
                                                            <div class="form-floating">
                                                                <select class="form-select" id="floatingSelect" aria-label="Floating label select example">
                                                                  <option selected>--Select Id First--</option>
                                                                  <option value="1">#12334</option>
                                                                  <option value="2">#12335</option>
                                                                  <option value="3">#12336</option>
                                                                  <option value="4">#12337</option>
                                                                </select>
                                                                <label for="floatingSelect">Designation </label>
                                                            </div>
                                                        </div>
                                                    </div> -->
                                                    <div class="col-lg-6">
                                                        <div class="form-floating">
                                                            <input type="text" class="form-control" id="firstname" placeholder="Enter your Firstname" value="<?php echo $firstname; ?>">
                                                            <label for="firstname">First Name</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="form-floating">
                                                            <input type="text" class="form-control" id="lastname" placeholder="Enter your Lastname" value="<?php echo $lastname ?>">
                                                            <label for="lastname">Last Name</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="form-floating">
                                                            <input type="text" class="form-control" id="nominee_name" placeholder="Enter Nominee Name" value="<?php echo $nominee_name;?>">
                                                            <label for="nominee_name">Nominee Name</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="form-floating">
                                                            <input type="text" class="form-control" id="nominee_relation" placeholder="Enter Nominee Relation" value="<?php echo $nominee_relation;?>">
                                                            <label for="nominee_relation">Nominee Relation</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="form-floating">
                                                            <input type="email" class="form-control" id="email" placeholder="Enter your Email" value="<?php echo $email;?>">
                                                            <label for="email">Email Address</label>
                                                        </div>
                                                     </div>
                                                    <div class="col-lg-6">
                                                        <div class="form-floating">
                                                            <input type="date" class="form-control" id="dob" placeholder="Enter Date" value="<?php echo $date_of_birth;?>">
                                                            <label for="dob">Date</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <p>Gender</p>
                                                        <input type="radio" id="test3" class="form-check-input gender" name="gender" value="male" <?php if($gender == "male") {echo 'checked';} ?> />
                                                        <label for="test3">Male</label>
                                                        <input type="radio" id="test4"  class="form-check-input gender ms-2" name="gender" value="female" <?php if($gender == "female") {echo 'checked';} ?> />
                                                        <label for="test4">Female</label>
                                                        <input type="radio" id="test5"  class="form-check-input gender ms-2" name="gender" value="others" <?php if($gender == "others") {echo 'checked';} ?> />
                                                        <label for="test5">Others</label>
                                                    </div>
                                                    <div class="col-lg-2">
                                                        <div class="form-floating">
                                                            <div class="form-floating">
                                                                <select class="form-select" id="country_cd" aria-label="Floating label select example">
                                                                    <?php
                                                                        require 'connect.php';
                                                                        $stmt = $conn->prepare("SELECT * FROM countries WHERE status = 1 ORDER BY country_name ASC");
                                                                        $stmt->execute();                                                  
                                                                        $stmt->setFetchMode(PDO::FETCH_ASSOC);
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
                                                            <input type="number" class="form-control" id="phone" placeholder="Enter your zipcode" value="<?php echo $contact_no;?>">
                                                            <label for="phone">Phone Number</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="form-floating">
                                                            <select class="form-select" id="country" aria-label="Floating label select example">
                                                                <option value="<?php echo $country_id;?>"><?php echo $countryname.' (Already Selected)' ; ?></option>
                                                                <?php
                                                                    $stmt = $conn->prepare("SELECT * FROM countries WHERE status = 1 ORDER BY country_name ASC");
                                                                    $stmt->execute();                                         
                                                                    $stmt->setFetchMode(PDO::FETCH_ASSOC);
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
                                                                <option value="<?php echo $state_id;?>"><?php echo $statename.' (Already Selected)' ; ?></option>
                                                                <option value="">--Select country first--</option>
                                                            </select>
                                                            <label for="mystate">State</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="form-floating">
                                                            <select class="form-select" id="city" aria-label="Floating label select example">
                                                                <option value="<?php echo $city_id;?>"><?php echo $city_name.' (Already Selected)' ; ?></option>
                                                                <option value="">--Select state first--</option>
                                                            </select>
                                                            <label for="city">City</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="form-floating">
                                                            <input type="text" class="form-control" id="pin" placeholder="Enter your zipcode" value="<?php echo $pincode;?>">
                                                            <label for="pin">Pincode</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <div class="form-floating">
                                                            <input type="text" class="form-control" id="address" placeholder="Enter your Address" value="<?php echo $address;?>">
                                                            <label for="address">Address</label>
                                                        </div>
                                                    </div>

                                                     <!-- for edit data page -->
                                                    <input type="hidden" id="ref_id" name="ref_id" value="<?php echo $reference_no;?>">
                                                    <input type="hidden" id="editfor" name="editfor" value="<?php echo $editfor;?>">
                                                    <input type="hidden" id="id" name="id" value="<?php echo $id;?>">

                                                    <div class="col-lg-12">
                                                        <div class="text-start">
                                                            <button type="submit" class="btn btn-primary sub-title" id="edit_cbd">Submit</button>
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
        <!-- <script src="assets/js/pages/plugins/lord-icon-2.1.0.js"></script> -->
        <!-- <script src="assets/js/plugins.js"></script> -->
        <!-- jquery -->
        <script src="assets/js/jquery/jquery-3.7.1.min.js"></script>

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
            // $('#user_id_name').on('change', function(){
            //     var user_id_name = $(this).val();
            //     // console.log(user_id_name);

            //     var designation = $('#designation').val();
            //     // console.log(designation);

            //     $.ajax({
            //         type:'POST',
            //         url:'agents/getUsers.php',
            //         data: 'user_id_name=' + user_id_name + '&designation=' + designation ,
            //         success:function(response){
            //         // console.log(response);
            //             // $('#pin').html(response);
            //             $('#reference_name').val(response); 
            //         }
            //     }); 
               
            // }); 

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