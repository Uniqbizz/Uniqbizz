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
        <title>Channel Business Director Add | Admin Dashboard </title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- App favicon -->
        <link rel="shortcut icon" href="../assets/images/fav.png">

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

        <!-- Plugins css -->
        <!-- <link href="../assets/libs/dropzone/dropzone.css" rel="stylesheet" type="text/css" /> -->

    </head>

    <body data-sidebar="dark">

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

                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                    <p class="mb-sm-0 head text-uppercase fw-bold">Channel Business Director</p>

                                    <!-- <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboards</a></li>
                                            <li class="breadcrumb-item active">Dashboard</li>
                                        </ol>
                                    </div> -->

                                </div>
                            </div>
                        </div>

                        <!-- add customer form start -->
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row mb-3">
                                            <div class="col-sm-6">
                                                <div class="search-box me-2 mb-2 d-inline-block">
                                                    <div class="position-relative">
                                                        <h4 class="head text-uppercase fw-bold">Add Channel Business Director Form</h4>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- <div class="col-sm-8">
                                                <div class="text-sm-end">
                                                    <button type="button" data-bs-toggle="modal" data-bs-target="#newCustomerModal" class="btn btn-success btn-rounded waves-effect waves-light mb-2 me-2 addCustomers-modal"><i class="mdi mdi-plus me-1"></i> New Customers</button>
                                                </div>
                                            </div> -->
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-12">
                                                <form>

                                                    <!-- <div class="row">
                                                        <div class="col-md-6 col-sm-12">
                                                            <div class="form-floating mb-3">
                                                                <select id="user_id_name" class="form-select">
                                                                    <option value="">--Select Name First--</option> 
                                                                    <?php
                                                                        // $sql = "SELECT * FROM `franchisee` WHERE status ='1' ORDER BY franchisee_id ASC ";
                                                                        // $stmt = $conn -> prepare($sql);
                                                                        // $stmt -> execute();
                                                                        // $stmt->setFetchMode(PDO::FETCH_ASSOC);
                                                                        // if($stmt -> rowCount()>0){
                                                                        //     foreach (($stmt->fetchAll()) as $key => $row) {
                                                                        //         echo '<option value="'.$row['franchisee_id'].'">'.$row['franchisee_id'].' ('.$row['firstname'].' '.$row['lastname'].')</option>';
                                                                        //     }
                                                                        // }
                                                                    ?>
                                                                </select>
                                                                <label for="user_id_name">User Id & Name</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-sm-12">
                                                            <div class="form-floating mb-3">
                                                                <input type="text" class="form-control" id="reference_name" placeholder="No Referance selected for the user" readonly>
                                                                <label for="reference_name">Reference Name </label>
                                                            </div>
                                                        </div>
                                                    </div> -->

                                                    <div class="row">
                                                        <div class="col-md-6 col-sm-12">
                                                            <div class="form-floating mb-3">
                                                                <input type="text" class="form-control" id="firstname" placeholder="Enter First Name">
                                                                <label for="firstname">First Name</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-sm-12">
                                                            <div class="form-floating mb-3">
                                                                <input type="text" class="form-control" id="lastname" placeholder="Enter Last Name">
                                                                <label for="lastname">Last Name</label>
                                                            </div>
                                                        </div>
                                                    </div>

                                                     <div class="row">
                                                        <div class="col-md-6 col-sm-12">
                                                            <div class="form-floating mb-3">
                                                                <input type="text" class="form-control" id="nominee_name" placeholder="Enter Nominee First Name">
                                                                <label for="nominee_name">Nominee Name</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-sm-12">
                                                            <div class="form-floating mb-3">
                                                                <input type="text" class="form-control" id="nominee_relation" placeholder="Enter Nominee Relation">
                                                                <label for="nominee_relation">Nominee Relation</label>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-6 col-sm-12">
                                                            <div class="form-floating mb-3">
                                                                <input type="email" class="form-control" id="email" placeholder="Enter Email address">
                                                                <label for="email">Email address</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-sm-12">
                                                            <div class="form-floating mb-3">
                                                                <input type="date" class="form-control" id="dob" placeholder="Enter Email address">
                                                                <label for="dob">Date</label>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- <div class="row">
                                                        <div class="col-md-6 col-sm-12">
                                                            <div class="form-floating mb-3">
                                                                <select id="business_package_amount" class="form-select">
                                                                    <option value="">--Select Business Package/Amount--</option> 
                                                                    <option value="Free Of Cost">Free Of Cost</option> 
                                                                    <option value="590000">5,00,000 + 18% GST = 5,90,000/-</option> 
                                                                </select>
                                                                <label for="business_package_amount">Business Package/Amount</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-sm-12">
                                                            <div class="form-floating mb-3">
                                                                <input type="text" class="form-control" id="gst_no" placeholder="GST NO">
                                                                <label for="gst_no">GST No</label>
                                                            </div>
                                                        </div>
                                                    </div> -->

                                                    <div class="row">
                                                        <div class="col-md-6 col-sm-12">
                                                            <div class="form-floating mb-3">
                                                                <div class="mb-3">
                                                                    <label class="d-block mb-3">Gender :</label>
                                                                    <div class="form-check form-check-inline">
                                                                        <input class="form-check-input gender" type="radio" name="gender" id="test3" value="male">
                                                                        <label class="form-check-label" for="test3">Male</label>
                                                                    </div>
                                                                    <div class="form-check form-check-inline">
                                                                        <input class="form-check-input gender" type="radio" name="gender" id="test4" value="female">
                                                                        <label class="form-check-label" for="test4">Female</label>
                                                                    </div>       
                                                                    <div class="form-check form-check-inline">
                                                                        <input class="form-check-input gender" type="radio" name="gender" id="test5" value="others">
                                                                        <label class="form-check-label" for="test5">Others</label>
                                                                    </div>                                                          
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-6 col-sm-12 code-mobile" style="display: flex; justify-content: space-between; ">
                                                            
                                                            <div class="form-floating  col-sm-3">
                                                                <?php
                                                                    $stmt = $conn->prepare("SELECT * FROM countries WHERE status = 1 ORDER BY country_name ASC");
                                                                    $stmt->execute();                                            
                                                                    $stmt->setFetchMode(PDO::FETCH_ASSOC);
                                                                ?>
                                                                <select class="form-select" id="country_cd">
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
                                                                <label for="country_cd">Code:</label>
                                                            </div>
                                                            <div class="form-floating  col-sm-8" >
                                                                <input type="text" class="form-control" id="phone" placeholder="Enter Phone Number" >
                                                                <label for="firstname">Phone Number</label>
                                                            </div>  
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-6 col-sm-12">
                                                            <div class="form-floating mb-3">
                                                                <?php
                                                                    $stmt = $conn->prepare("SELECT * FROM countries WHERE status = 1 ORDER BY country_name ASC");
                                                                    $stmt->execute();                                         
                                                                    $stmt->setFetchMode(PDO::FETCH_ASSOC);
                                                                ?>
                                                                <select class="form-select" id="country">
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
                                                        <div class="col-md-6 col-sm-12">
                                                            <div class="form-floating mb-3">
                                                                <select class="form-select" id="mystate" aria-label="Floating label select example">
                                                                    <option value="">--Select country first--</option>
                                                                </select>
                                                                <label for="mystate">State</label>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-6 col-sm-12">
                                                            <div class="form-floating mb-3">
                                                                <select class="form-select" id="city" aria-label="Floating label select example">
                                                                    <option value="">--Select state first--</option>
                                                                </select>
                                                                <label for="city">City</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-sm-12">
                                                            <div class="form-floating mb-3">
                                                                <input type="text" class="form-control" id="pin" placeholder="Pincode" readonly >
                                                                <label for="pin">Pincode</label>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-12 col-sm-12">
                                                            <div class="form-floating mb-3">
                                                                    <input type="text" class="form-control" id="address" placeholder="Enter First Name" >
                                                                    <label for="address">Address</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-6 col-sm-12">
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
                                                        <div class="col-md-6 col-sm-12">
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
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-6 col-sm-12">
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
                                                        <div class="col-md-6 col-sm-12">
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
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-6 col-sm-12">
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
                                                    </div>
                                                                  
                                                    <input type="hidden" id="testValue" name="testValue" value="18"> <!-- CBD -->

                                                    <div>
                                                        <button type="submit" class="btn btn-primary w-md mt-3" id="addChannelBusinessDirector">Submit</button>
                                                    </div>

                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                <!-- container-fluid -->
                </div>
                <!-- End Page-content -->


                <footer class="footer">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-sm-6">
                                <?php echo $date; ?> © Uniqbizz.
                            </div>
                            <div class="col-sm-6">
                                <div class="text-sm-end d-none d-sm-block">
                                    Design & Develop by MirthCon
                                </div>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
            <!-- end main content-->

        </div>

        <!-- loading screen -->
        <div id="loading-overlay">
            <div class="loading-icon"></div>
        </div>
        <!--start back-to-top-->
        <button onclick="topFunction()" class="scrollToTop scroll-btn show btn" id="back-to-top">
            <i class="mdi mdi-arrow-up"></i>
        </button>
        <!--end back-to-top-->
        
        <!-- JAVASCRIPT -->
        <script src="../assets/libs/jquery/jquery.min.js"></script>
        <script src="../assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="../assets/libs/metismenu/metisMenu.min.js"></script>
        <script src="../assets/libs/simplebar/simplebar.min.js"></script>
        <script src="../assets/libs/node-waves/waves.min.js"></script>

        <!-- add data to database js file -->
        <script type="text/javascript" src="../assets/js/submitdata.js"></script>

        <!-- apexcharts -->
        <!-- <script src="../assets/libs/apexcharts/apexcharts.min.js"></script> -->

        <!-- dashboard init -->
        <!-- <script src="assets/js/pages/dashboard.init.js"></script> -->

        <!-- App js -->
        <script src="../assets/js/app.js"></script>

        <script src="../../uploading/upload.js"></script>

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

        <!-- ** designation user, user name on designation select / get country, state, city, pincode **  -->
        <script>
            //select Designation
            // $('#designation').on('change', function() {
            //     var designation = $('#designation').val();
            //     // console.log(designation);
            //     $.ajax({
            //         type:'POST',
            //         url:'../agents/get_user_Franchisee.php',
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
                // var designation = $('#designation').val();
                // console.log(user_id_name);

                var designation = 'franchisee';
                // console.log(designation);

                $.ajax({
                    type:'POST',
                    url:'../agents/getUsers.php',
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
                        url:'../address/countrydata.php',
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
                        url:'../address/countrydata.php',
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
                        url:'../address/pincode.php',
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