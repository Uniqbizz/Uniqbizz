<?php
    session_start();

    if(!isset($_SESSION['username'])){
        echo '<script>location.href = "../login.php";</script>';
    }

    require '../connect.php';
    //current full date
    $today = date('Y-m-d');

    //current year
    $date = date('Y'); 

    // Calculate 20 years before the current date
    $dateTwentyYearsAgo = strtotime("-20 years");

    // Format the result as a human-readable date
    $ageLimit = date("Y-m-d", $dateTwentyYearsAgo);  // Outputs the date 20 years before today
?>
<!doctype html>
<html lang="en">

    <head>
        
        <meta charset="utf-8" />
        <title>Add Travel Consultant | Admin Dashboard </title>
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
                                    <h4 class="mb-sm-0 font-size-18">Travel Consultant</h4>
                                </div>
                            </div>
                        </div>

                        <!-- add customer form start -->
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <form>
                                            <h3>Add Travel Consultant Form</h3>
                                            <div class="row">
                                                <!-- <div class="col-md-6 col-sm-6">
                                                    <div class="input-block mb-3">
                                                        <label class="col-form-label" for="user_id_name">User Id & Name<span class="text-danger">*</span></label>
                                                        <select id="user_id_name" class="form-select">
                                                            <option value="">--Select Name First--</option> 
                                                            <?php
                                                                $sql = "SELECT * FROM `corporate_agency` WHERE status ='1' ORDER BY corporate_agency_id ASC ";
                                                                $stmt = $conn -> prepare($sql);
                                                                $stmt -> execute();
                                                                $stmt->setFetchMode(PDO::FETCH_ASSOC);
                                                                if($stmt -> rowCount()>0){
                                                                    foreach (($stmt->fetchAll()) as $key => $row) {
                                                                        echo '<option value="'.$row['corporate_agency_id'].'">'.$row['corporate_agency_id'].' ('.$row['firstname'].' '.$row['lastname'].')</option>';
                                                                    }
                                                                }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-sm-6">
                                                    <div class="input-block mb-3">
                                                        <label class="col-form-label" for="reference_name">Reference Name <span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" id="reference_name" placeholder="No Referance selected for the user" readonly>
                                                    </div>
                                                </div> -->

                                                <div class="col-md-4 col-sm-12">
                                                    <div class="input-block mb-3">
                                                        <label class="col-form-label">Designation<span class="text-danger">*</span></label>
                                                        <select id="designation" class="form-select">
                                                            <option value="">--Select Designation--</option>
                                                            <option value="business_mentor">Business Mentor</option>
                                                            <option value="corporate_agency">Techno Enterprise</option>
                                                            <!-- <option value="channel_business_director">Channel Business Director</option> -->
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-4 col-sm-12">
                                                    <div class="input-block mb-3">
                                                        <label class="col-form-label">User ID & Name<span class="text-danger">*</span></label>
                                                        <select id="user_id_name" class="form-select">
                                                            <option value="">--Select Designation First--</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-sm-12">
                                                    <div class="input-block mb-3">
                                                        <label class="col-form-label">Referance Name<span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" id="reference_name" placeholder="No Referance selected for the user" readonly>
                                                    </div>
                                                </div>

                                                <div class="col-md-6 col-sm-6">
                                                    <div class="input-block mb-3">
                                                        <label class="col-form-label" for="firstname">First Name<span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" id="firstname" placeholder="Enter First Name">
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-sm-6">
                                                    <div class="input-block mb-3">
                                                        <label class="col-form-label" for="lastname">Last Name<span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" id="lastname" placeholder="Enter Last Name">
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-sm-6">
                                                    <div class="input-block mb-3">
                                                        <label class="col-form-label" for="nominee_name">Nominee Name<span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" id="nominee_name" placeholder="Enter Nominee First Name">
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-sm-6">
                                                    <div class="input-block mb-3">
                                                        <label class="col-form-label" for="nominee_relation">Nominee Relation<span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" id="nominee_relation" placeholder="Enter Nominee Relation">
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-sm-6">
                                                    <div class="input-block mb-3">
                                                        <label class="col-form-label" for="email">Email address<span class="text-danger">*</span></label>
                                                        <input type="email" class="form-control" id="email" placeholder="Enter Email address">
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-sm-6">
                                                    <div class="input-block mb-3">
                                                        <label class="col-form-label" for="dob">Date of Birth<span class="text-danger">*</span></label>
                                                        <input type="date" class="form-control" id="dob" max="<?php echo $ageLimit; ?>" placeholder="Enter Date of Birth">
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-sm-12">
                                                    <div class="form-group mb-3">
                                                        <label class="col-form-label d-block">Gender:<span class="text-danger">*</span></label>
                                                        <div class="form-control d-flex justify-content-around">
                                                            <label class="radio-inline mb-0 ms-3" for="test3"><input class="gender form-check-input" type="radio" name="gender" id="test3" value="male">&nbsp;&nbsp;&nbsp;Male</label>
                                                            <label class="radio-inline mb-0 ms-3" for="test4"><input class="gender form-check-input" type="radio" name="gender" id="test4" value="female">&nbsp;&nbsp;&nbsp;Female</label>
                                                            <label class="radio-inline mb-0 ms-3" for="test5"><input class="gender form-check-input" type="radio" name="gender" id="test5" value="others">&nbsp;&nbsp;&nbsp;Others</label>
                                                        </div> 
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-sm-12 mb-3">
                                                    <div class="row">
                                                        <div class="col-md-4 col-sm-4 col-3">
                                                            <div class="input-block">
                                                                <?php
                                                                    $stmt = $conn->prepare("SELECT * FROM countries WHERE status = 1 ORDER BY country_name ASC");
                                                                    $stmt->execute();                                            
                                                                    $stmt->setFetchMode(PDO::FETCH_ASSOC);
                                                                ?>
                                                                <label class="col-form-label" for="country_cd">Code:</label>
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
                                                            </div>
                                                        </div>
                                                        <div class="col-md-8 col-sm-8 col-9">
                                                            <div class="input-block">
                                                                <label class="col-form-label" for="phone">Phone Number<span class="text-danger">*</span></label>
                                                                <input type="text" class="form-control" id="phone" placeholder="Enter Phone Number" >
                                                            </div> 
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-sm-6">
                                                    <div class="input-block mb-3">
                                                        <?php
                                                            $stmt = $conn->prepare("SELECT * FROM countries WHERE status = 1 ORDER BY country_name ASC");
                                                            $stmt->execute();                                         
                                                            $stmt->setFetchMode(PDO::FETCH_ASSOC);
                                                        ?>
                                                        <label class="col-form-label" for="country">Country<span class="text-danger">*</span></label>
                                                        <select class="form-select" id="country">
                                                            <option selected value="">--Select Country--</option>
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
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-sm-6">
                                                    <div class="input-block mb-3">
                                                        <label class="col-form-label" for="mystate">State<span class="text-danger">*</span></label>
                                                        <select class="form-select" id="mystate" aria-label="Floating label select example">
                                                            <option value="">--Select country first--</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-sm-6">
                                                    <div class="input-block mb-3">
                                                        <label class="col-form-label" for="city">City<span class="text-danger">*</span></label>
                                                        <select class="form-select" id="city" aria-label="Floating label select example">
                                                            <option value="">--Select state first--</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-sm-6">
                                                    <div class="input-block mb-3">
                                                        <label class="col-form-label" for="pin">Pincode<span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" id="pin" placeholder="Pincode" readonly >
                                                    </div>
                                                </div>
                                                <div class="col-md-12 col-sm-12">
                                                    <div class="input-block mb-3">
                                                        <label class="col-form-label" for="address">Address<span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" id="address" placeholder="Address"  >
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-sm-6">
                                                    <div class="input-block mb-3">
                                                        <label class="col-form-label" for="payment_fee">Payment Fee<span class="text-danger">*</span></label>
                                                        <select class="form-select" id="payment_fee" aria-label="Floating label select example">
                                                            <option value="null" selected>--Select Payment Fee--</option>
                                                            <option value="FOC" >Free</option>
                                                            <option value="3000"><span>&#8377 </span>3000/-</option>
                                                            <option value="10000" selected><span>&#8377 </span>10,000/-</option>
                                                            <!-- <option value="5000"><span>&#8377 </span>5000/-</option>
                                                            <option value="15000"><span>&#8377 </span>15,000/-</option> -->
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-sm-6" id="paymentModeBlock">
                                                    <div class="input-block mb-3">
                                                        <label class="fw-bold col-form-label">Payment Mode: <span class="text-danger">*</span></label>
                                                        <div class="form-control radioBtn d-flex justify-content-around" id="paymentMode">
                                                            <label for="cashPayment" class="mb-0"><input type="radio" id="cashPayment" class="form-check-input payment me-3" name="payment" value="cash">Cash</label>
                                                            <label for="chequePayment" class="mb-0"><input type="radio" id="chequePayment" class="form-check-input payment me-3" name="payment" value="cheque">Cheque</label>
                                                            <label for="onlinePayment" class="mb-0"><input type="radio" id="onlinePayment" class="form-check-input payment me-3" name="payment" value="online">UPI/NEFT</label>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- <div class="row">
                                                    <div class="col-md-12 col-sm-12 mt-3">
                                                        <p style="font-weight:800; font-size:16px;">New Travel Consultant will pay 5,000/-</p>
                                                    </div>
                                                </div>   -->

                                                <div class="pb-3" id="paymentFields">
                                                    <div class="col-md-12 col-sm-12 d-none" id="chequeOpt">
                                                        <div class="row d-flex justify-content-center">
                                                            <div class="col-md-4 py-1">
                                                                <div class="input-block">
                                                                    <label class="col-form-label" for="chequeNo">Cheque No<span class="text-danger">*</span></label>
                                                                    <input type="text" class="form-control" id="chequeNo" placeholder="Enter Cheque Number">
                                                                </div>
                                                            </div>

                                                            <div class="col-md-4 py-1">
                                                                <div class="input-block">
                                                                    <label class="col-form-label" for="chequeDate">Cheque Date<span class="text-danger">*</span></label>
                                                                    <input type="text" class="form-control" id="chequeDate" placeholder="Enter Date On Cheque">
                                                                    <!-- added by savio -->
                                                                    <div id="specificMessage" class="message">Please enter the date in yyyy-mm-dd format.</div> 

                                                                </div>
                                                            </div>

                                                            <div class="col-md-4 py-1">
                                                                <div class="input-block">
                                                                    <label class="col-form-label" for="bankName">Bank Name<span class="text-danger">*</span></label>
                                                                    <input type="text" class="form-control" id="bankName" placeholder="Enter your Bank Name">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 col-sm-12 d-none" id="onlineOpt">
                                                        <div class="row d-flex justify-content-center">    
                                                            <div class="col-md-8">
                                                                <div class="input-block">
                                                                    <label class="col-form-label" for="transactionNo">Transaction No.<span class="text-danger">*</span></label>
                                                                    <input type="text" class="form-control" id="transactionNo" placeholder="Enter your Transaction No.">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- <div class="col-md-12 col-sm-12  mt-2" id="allOpt" style="display:flex; justify-content: center;">
                                                        <div class="col-md-6 col-sm-12">
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
                                                        </div>
                                                    </div> -->
                                                </div>

                                                <!-- Attachments -->
												<h4 class="my-2">Attachments</h4>
                                                <div class="col-md-6 col-sm-6">
                                                    <div class="mb-3">
                                                        <label class="col-form-label"><b>Profile Picture</b></label><br/>
                                                        <input class="form-control" type="file" name="file1" id="upload_file1">
                                                    </div>
                                                    <input type="hidden" id="img_path1" value="">
                                                    <div id="preview1" style="display: none;">
                                                        <div id="image_preview1">
                                                            <img  alt="Preview" class="imgSize" id="img_pre1">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-sm-6">
                                                    <div class="mb-3">
                                                        <label class="col-form-label"><b>Aadhaar Card</b></label><br/>
                                                        <input class="form-control" type="file" name="file2" id="upload_file2">
                                                    </div>
                                                    <input type="hidden" id="img_path2" value="">
                                                    <div id="preview2" style="display: none;">
                                                        <div id="image_preview2">
                                                            <img  alt="Preview" class="imgSize" id="img_pre2">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-sm-6">
                                                    <div class="mb-3">
                                                        <label class="col-form-label"><b>Pan Card</b></label><br/>
                                                        <input class="form-control" type="file" name="file3" id="upload_file3">
                                                    </div>
                                                    <input type="hidden" id="img_path3" value="">
                                                    <div id="preview3" style="display: none;">
                                                        <div id="image_preview3">
                                                            <img  alt="Preview" class="imgSize" id="img_pre3">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-sm-6">
                                                    <div class="mb-3">
                                                        <label class="col-form-label"><b>Bank Passbook</b></label><br/>
                                                        <input class="form-control" type="file" name="file4" id="upload_file4">
                                                    </div>
                                                    <input type="hidden" id="img_path4" value="">
                                                    <div id="preview4" style="display: none;">
                                                        <div id="image_preview4">
                                                            <img  alt="Preview" class="imgSize" id="img_pre4">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-sm-6">
                                                    <div class="mb-3">
                                                        <label class="col-form-label"><b>Voting Card</b></label><br/>
                                                        <input class="form-control" type="file" name="file5" id="upload_file5">
                                                    </div>
                                                    <input type="hidden" id="img_path5" value="">
                                                    <div id="preview5" style="display: none;">
                                                        <div id="image_preview5">
                                                            <img  alt="Preview" class="imgSize" id="img_pre5">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-sm-6" id="payProof">
                                                    <div class="mb-3">
                                                        <label class="col-form-label"><b>Payment Proof</b></label><br/>
                                                        <input class="form-control" type="file" name="file6" id="upload_file6">
                                                    </div>
                                                    <input type="hidden" id="img_path6" value="">
                                                    <div id="preview6" style="display: none;">
                                                        <div id="image_preview6">
                                                            <img  alt="Preview" class="imgSize" id="img_pre6">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-12 col-sm-12">
                                                <div class="input-block mb-3">
                                                    <label class="col-form-label" for="flex_amount">Extra Notes<span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" id="note" placeholder="Enter Note">
                                                </div>
                                            </div>
                                            
                                            <input type="hidden" id="testValue" name="testValue" value="11"> <!-- CA Travel Agent -->
                                            <div class="d-flex justify-content-center mb-4">
                                                <button type="submit" class="btn btn-primary px-5 py-2" id="add_ca_travelagency">Submit</button>
                                            </div>
                                        </form>
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
            // $(document).ready(function(){
            //     $('#payment_fee').on('change', function(){
            //         var payment_fee = $('#payment_fee').val();
            //         if (payment_fee == "FOC") {
            //             console.log(payment_fee);
            //         } else if(payment_fee == 'null'){
            //             alert("Select Payment Fee Option");
            //         } else{
            //             var paymentProof = $(':hidden#img_path6').val();
            //             if (!paymentProof) {
            //                 alert("Payment Proof Required");
            //             }
            //         }
            //     });
            // });

            // select Designation
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

                var designation = 'corporate_agency';
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
                let paymentFee = document.getElementById("payment_fee");
                // if(stateID==6){
                //     paymentFee.value = "10000";
                //     $('#payProof').removeClass('d-none');   
                //     $('#paymentFields').removeClass('d-none');   
                //     $('#paymentModeBlock').removeClass('d-none'); 
                //     paymentFee.setAttribute("disabled", "true");
                // } else {
                //     paymentFee.value = "null";
                //     $('#payProof').addClass('d-none');   
                //     $('#paymentFields').addClass('d-none');   
                //     $('#paymentModeBlock').addClass('d-none');
                //     paymentFee.removeAttribute("disabled");
                // }
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

            $('#payment_fee').on('change', function(){
                var payment_fee = $(this).val();
                // console.log(payment_fee);
                if(payment_fee == "FOC"){
                    $("#paymentModeBlock").addClass("d-none");
                    $("#paymentFields").addClass("d-none");
                    $('#payProof').addClass('d-none');  
                }else if(payment_fee == "null"){
                    $("#paymentModeBlock").addClass("d-none");
                    $("#paymentFields").addClass("d-none");
                    $('#payProof').addClass('d-none');  
                }else{
                    $("#paymentModeBlock").removeClass("d-none");
                    $("#paymentFields").removeClass("d-none");
                    $('#payProof').removeClass('d-none');  
                }
            });

            $('#paymentMode').on('click', function(){
                var paymentMode = $(".payment:checked").val();
                // console.log(paymentMode);
                if(paymentMode == "cheque"){
                    $("#chequeOpt").removeClass("d-none");
                    $("#onlineOpt").addClass("d-none");
                    $('#transactionNo').val('');
                    // $("#allOpt").removeClass("d-none");
                }else if(paymentMode == "online"){
                    $("#onlineOpt").removeClass("d-none");
                    $("#chequeOpt").addClass("d-none");
                    $('#chequeNo').val('');
                    $('#chequeDate').val('');
                    $('#bankName').val('');
                    // $("#allOpt").removeClass("d-none");
                } else {
                    $("#chequeOpt").addClass("d-none");
                    $("#onlineOpt").addClass("d-none");
                    $('#chequeNo').val('');
                    $('#chequeDate').val('');
                    $('#bankName').val('');
                    $('#transactionNo').val('');
                    // $("#allOpt").removeClass("d-none");
                }
            });
            //for valid check date --SV
            $('#chequeDate').on('input', function () {
                let value = $(this).val();

                // Allow only digits and hyphens, and match pattern yyyy-mm-dd (partial allowed)
                value = value.replace(/[^0-9\-]/g, ''); // Remove non-digit and non-hyphen chars

                // Optional: restrict to yyyy-mm-dd format (prevent too many characters)
                if (value.length > 10) {
                    value = value.slice(0, 10);
                }

                // Optional: add hyphens automatically as the user types
                if (/^\d{4}$/.test(value)) {
                    value += '-';
                } else if (/^\d{4}-\d{2}$/.test(value)) {
                    value += '-';
                }

                $(this).val(value);
            });
             // Target the specific input and message
            const specificInput = document.getElementById("chequeDate");
            const specificMessage = document.getElementById("specificMessage");
            // Show message only for this input on focus
            specificInput.addEventListener("focus", () => {
                specificMessage.style.display = "block"; // Show the message
            });

            // Hide message on blur
            specificInput.addEventListener("blur", () => {
                specificMessage.style.display = "none"; // Hide the message
            });
            //for valid check date --SV --end 
            //for valid cheque number --SV
            $('#chequeNo').on('input', function () {
                this.value = this.value.replace(/\D/g, ''); // Remove any non-digit characters
            });
            //for valid cheque number --SV end

            // $('#upload_file1').on('focus', function(){
            //     var payment_fee = $('#payment_fee').val();
            //     if(payment_fee == "FOC"){
            //         console.log("pass");
            //     }else{
            //         var paymentProof = $(':hidden#img_path6').val();
            //         alert("Payment Proof Required");
            //     }  
            // });

            // $('#add_ca_travelagency').on('click', function() {
            //     var payment_fee = $('#payment_fee').val();
            //     if (payment_fee == "FOC") {
            //         console.log(payment_fee);
            //     } else if(payment_fee == 'null'){
            //         alert("Select Payment Fee Option");
            //     } else{
            //         var paymentProof = $(':hidden#img_path6').val();
            //         if (!paymentProof) {
            //             alert("Payment Proof Required");
            //         }
            //     }
            // });

        </script>
    </body>
</html>