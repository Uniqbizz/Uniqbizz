<?php
session_start();

if(!isset($_SESSION['username'])){
    echo '<script>location.href = "../login";</script>';
}

$date = date('Y'); 

$id = $_GET['vkvbvjfgfikix'];
// $user_id = $_GET['jdjdfdjs'];
$reference_no = $_GET['nohbref'];
$country = $_GET['ncy'];
$state = $_GET['mst'];
$city = $_GET['hct'];

$zone = $_GET['zdfds'];
$region = $_GET['rdsfdsf'];
$branch = $_GET['bdfdsf'];

$editfor = $_GET['editfor'];

if($editfor == 'pending'){
    // $identifier_id= $_POST["vkvbvjfgfikix"];
    $identifier_name = 'id=';
}else if($editfor == 'registered') {
    // $identifier_id= $_POST["vkvbvjfgfikix"];
    $identifier_name = 'zonal_manager_id=';
}


    require '../connect.php';


    $stmt = $conn->prepare("SELECT *, (select zone_name from zone where id = '".$zone."') as zone_name, (select region_name from region where id = '".$region."') as region_name,(select branch_name from branch where id = '".$branch."') as branch_name, (select state_name from states where id = '".$state."') as statename, (select city_name from cities where id = '".$city."') as city_name,(select country_name from countries where id = '".$country."') as countryname FROM `zonal_manager` where $identifier_name'".$id."'");
    $stmt->execute();
     // set the resulting array to associative
    $stmt->setFetchMode(PDO::FETCH_ASSOC);

    if($stmt->rowCount()>0){
    foreach (($stmt->fetchAll()) as $key => $row) {
        // $fid=$row['id'];

        $ref_id = $row['reference_no'];
        $ref_name = $row['registrant'];
        $zonal_manager_id=$row['zonal_manager_id'];
        $branch_name=$row['branch_name'];
        $zone_name=$row['zone_name'];
        $region_name=$row['region_name'];
        $firstname=$row['firstname'];
        // $username=$row['username'];
        $lastname=$row['lastname'];
        $email=$row['email'];
        $contact_no=$row['contact_no'];
        $date_of_birth=$row['date_of_birth'];
        $gender=$row['gender'];
        $address=$row['address'];
        // $id_proof=$row['id_proof'];
        $profile_pic=$row['profile_pic'];
        $kyc=$row['kyc'];
        $pan_card=$row['pan_card'];
        $aadhar_card=$row['aadhar_card'];
        $voting_card=$row['voting_card'];
        $bank_passbook=$row['bank_passbook'];

        $city_name=$row['city_name'];
        $statename=$row['statename'];
        $countryname=$row['countryname'];
        $pincode=$row['pincode'];
 
    }
    }                                                      
    else{
                                                            
    }

?>
<!doctype html>
<html lang="en">
    <head>
        
        <meta charset="utf-8" />
        <title>Branch Manager Edit | Admin Dashboard </title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
        <meta content="Themesbrand" name="author" />
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
                                    <h4 class="mb-sm-0 font-size-18">Zonal Manager</h4>

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
                                            <div class="col-sm-4">
                                                <div class="search-box me-2 mb-2 d-inline-block">
                                                    <div class="position-relative">
                                                        <h4>Edit Zonal Manager Form</h4>
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

                                                    <div class="row">
                                                        <div class="col-md-6 col-sm-12">
                                                            <div class="form-floating mb-3">
                                                                <input type="text" class="form-control" id="ref_id" placeholder="Enter First Name" value=" <?php echo $ref_id; ?>" readonly>
                                                                <label for="ref_id">Reference ID</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-sm-12">
                                                            <div class="form-floating mb-3">
                                                                <input type="text" class="form-control" id="ref_name" placeholder="Enter Last Name" value=" <?php echo $ref_name; ?>" readonly>
                                                                <label for="ref_name">Reference Name</label>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-6 col-sm-12">
                                                            <div class="form-floating mb-3">
                                                                <input type="text" class="form-control" id="firstname" placeholder="Enter First Name" value=" <?php echo $firstname; ?>">
                                                                <label for="firstname">First Name</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-sm-12">
                                                            <div class="form-floating mb-3">
                                                                <input type="text" class="form-control" id="lastname" placeholder="Enter Last Name" value=" <?php echo $lastname; ?>">
                                                                <label for="lastname">Last Name</label>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-6 col-sm-12">
                                                            <div class="form-floating mb-3">
                                                                <input type="email" class="form-control" id="email" placeholder="Enter Email address" value="<?php echo$email;?>">
                                                                <label for="email">Email address</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-sm-12">
                                                            <div class="form-floating mb-3">
                                                                <!-- <input type="date" class="form-control" id="dob"  value=" <?php echo $pddt; ?>"> -->
                                                                <input type="date" id="dob" class=" form-control" value="<?php echo $date_of_birth ;?>">
                                                                <label for="dob">Date</label>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-6 col-sm-12">
                                                            <div class="form-floating mb-3">
                                                                <div class="mb-3">
                                                                    <label class="d-block mb-3">Gender :</label>
                                                                    <div class="form-check form-check-inline">
                                                                        <input class="form-check-input gender" type="radio" name="gender" id="test3" value="male" <?php if ($gender == 'male'){echo ' checked ';} ?>>
                                                                        <label class="form-check-label" for="test3">Male</label>
                                                                    </div>
                                                                    <div class="form-check form-check-inline">
                                                                        <input class="form-check-input gender" type="radio" name="gender" id="test4" value="female" <?php if ($gender == 'female'){echo ' checked ';} ?>>
                                                                        <label class="form-check-label" for="test4">Female</label>
                                                                    </div>       
                                                                    <div class="form-check form-check-inline">
                                                                        <input class="form-check-input gender" type="radio" name="gender" id="test5" value="others" <?php if ($gender == 'others'){echo ' checked ';} ?>>
                                                                        <label class="form-check-label" for="test5">Others</label>
                                                                    </div>                                                          
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-6 col-sm-12" style="display: flex; justify-content: space-between; ">
                                                            
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
                                                                <input type="text" class="form-control" id="phone" placeholder="Enter Phone Number" value=" <?php echo $contact_no; ?>">
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
                                                                    <option value="<?php echo $country;?>"><?php echo $countryname.' (Already Selected)' ; ?></option>
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
                                                                    <option value="<?php echo $state;?>"><?php echo $statename.' (Already Selected)' ; ?></option>
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
                                                                    <option value="<?php echo $city;?>"><?php echo $city_name.' (Already Selected)' ; ?></option>
                                                                    <option value="">--Select state first--</option>
                                                                </select>
                                                                <label for="city">City</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-sm-12">
                                                            <div class="form-floating mb-3">
                                                                <input type="text" class="form-control" id="pin" placeholder="Pincode" value="<?php echo $pincode; ?>" readonly >
                                                                <label for="pin">Pincode</label>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-12 col-sm-12">
                                                            <div class="form-floating mb-3">
                                                                    <input type="text" class="form-control" id="address" value="<?php echo $address ?>" placeholder="Enter First Name" >
                                                                    <label for="address">Address</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-6 col-sm-12">
                                                            <div class="form-floating mb-3">
                                                                <?php
                                                                    $stmt = $conn->prepare("SELECT * FROM zone WHERE status = 1 ORDER BY zone_name ASC");
                                                                    $stmt->execute();                                         
                                                                    $stmt->setFetchMode(PDO::FETCH_ASSOC);
                                                                ?>
                                                                <select class="form-select" id="zone_name">
                                                                    <option value="<?php echo $zone;?>"><?php echo $zone_name.' (Already Selected)' ; ?></option>
                                                                    <option value="">--Select state first--</option>
                                                                    <?php 
                                                                        if($stmt->rowCount()>0){
                                                                            foreach (($stmt->fetchAll()) as $key => $row) {  
                                                                                echo '<option value="'.$row['id'].'">'.$row['zone_name'].'</option>'; 
                                                                            } 
                                                                        }else{ 
                                                                            echo '<option value="">Zone not available</option>'; 
                                                                        } 
                                                                    ?>
                                                                </select>
                                                                <label for="zone_name">Zone</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-sm-12">
                                                            <div class="form-floating mb-3">
                                                                <select class="form-select" id="region_name" aria-label="Floating label select example">
                                                                    <option value="<?php echo $region;?>"><?php echo $region_name.' (Already Selected)' ; ?></option>
                                                                    <option value="">--Select Zone first--</option>
                                                                </select>
                                                                <label for="mystate">Region</label>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-6 col-sm-12">
                                                            <div class="form-floating mb-3">
                                                                <select class="form-select" id="branch_name" aria-label="Floating label select example">
                                                                    <option value="<?php echo $branch;?>"><?php echo $branch_name.' (Already Selected)' ; ?></option>
                                                                    <option value="">--Select region first--</option>
                                                                </select>
                                                                <label for="mystate">Branch</label>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-6 col-sm-12">
                                                            <div class="mb-3">
                                                                <label for="file1"><b>PROFILE</b></label><br/>
                                                                <input type="file" name="file1" id="upload_file1">
                                                            </div>
                                                            <input type="hidden" id="img_path1" value="<?php echo $profile_pic;?>">
                                                            <div id="preview1" >
                                                                <div id="image_preview1" style="margin-bottom: 50px;">
                                                                    <?php
                                                                        if($profile_pic ==''){
                                                                            echo '<img src="../../uploading/not_uploaded.png" alt="Preview" id="img_pre1">';
                                                                        }else{
                                                                            echo '<img src="../../uploading/'.$profile_pic.'" alt="Preview" id="img_pre1">';
                                                                        }
                                                                    ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-sm-12">
                                                            <div class="mb-3">
                                                                <label for="file2"><b>AADHAR CARD</b></label><br/>
                                                                <input type="file" name="file2" id="upload_file2">
                                                            </div>
                                                            <input type="hidden" id="img_path2" value="<?php echo $aadhar_card;?>">
                                                            <div id="preview2" style="margin-bottom: 50px;">
                                                                <div id="image_preview2">
                                                                    <?php
                                                                        if($aadhar_card ==''){
                                                                            echo '<img src="../../uploading/not_uploaded.png" alt="Preview" id="img_pre2">';
                                                                        }else{
                                                                            echo '<img src="../../uploading/'.$aadhar_card.'" alt="Preview" id="img_pre2">';
                                                                        }
                                                                    ?>
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
                                                            <input type="hidden" id="img_path3" value="<?php echo $pan_card;?>">
                                                            <div id="preview3" style="margin-bottom: 50px;">
                                                                <div id="image_preview3">
                                                                    <?php
                                                                        if($pan_card ==''){
                                                                            echo '<img src="../../uploading/not_uploaded.png" alt="Preview" id="img_pre3">';
                                                                        }else{
                                                                            echo '<img src="../../uploading/'.$pan_card.'" alt="Preview" id="img_pre3">';
                                                                        }
                                                                    ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-sm-12">
                                                            <div class="mb-3">
                                                                <label for="file4"><b>BANK PASSBOOK</b></label><br/>
                                                                <input type="file" name="file4" id="upload_file4">
                                                            </div>
                                                            <input type="hidden" id="img_path4" value="<?php echo $bank_passbook;?>">
                                                            <div id="preview4" style="margin-bottom: 50px;">
                                                                <div id="image_preview4">
                                                                    <?php
                                                                        if($bank_passbook ==''){
                                                                            echo '<img src="../../uploading/not_uploaded.png" alt="Preview" id="img_pre4">';
                                                                        }else{
                                                                            echo '<img src="../../uploading/'.$bank_passbook.'" alt="Preview" id="img_pre4">';
                                                                        }
                                                                    ?>
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
                                                            <input type="hidden" id="img_path5" value="<?php echo $voting_card;?>">
                                                            <div id="preview5" style="margin-bottom: 50px;">
                                                                <div id="image_preview5">
                                                                    <?php
                                                                        if($voting_card ==''){
                                                                            echo '<img src="../../uploading/not_uploaded.png" alt="Preview" id="img_pre5">';
                                                                        }else{
                                                                            echo '<img src="../../uploading/'.$voting_card.'" alt="Preview" id="img_pre5">';
                                                                        }
                                                                    ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- for edit data page -->
                                                    <input type="hidden" id="testValue" name="testValue" value="14"> <!-- Zonal Manager -->
                                                    <input type="hidden" id="ref_id" name="ref_id" value="<?php echo $reference_no;?>">
                                                    <input type="hidden" id="editfor" name="editfor" value="<?php echo $editfor;?>">
                                                    <input type="hidden" id="testiod" name="testiod" value="<?php echo $id;?>">

                                                    <div>
                                                        <button type="submit" class="btn btn-primary w-md mt-3" id="editZonalManager">Submit</button>
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

        <!-- get zone name, region_name -->
        <script type="text/javascript" src="../assets/js/office.js"></script>

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
            $('#designation').on('change', function() {
                var designation = $('#designation').val();
                // console.log(designation);
                $.ajax({
                    type:'POST',
                    url:'../agents/get_user_Franchisee.php',
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
