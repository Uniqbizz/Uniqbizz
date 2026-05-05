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

    // Calculate 18 years before the current date
    $dateEighteenYearsAgo = strtotime("-18 years");

    // Format the result as a human-readable date
    $ageLimit = date("Y-m-d", $dateEighteenYearsAgo);  // Outputs the date 18 years before today
?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Add Visa | Admin Dashboard </title>
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
                                    <h4 class="mb-sm-0 font-size-18">Visa</h4>
                                </div>
                            </div>
                        </div>

                        <!-- add visa form start -->
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <form>
                                            <h3>Add Visa Form</h3>
                                            <div class="row">
                                                <div class="col-md-6 col-sm-6">
                                                    <div class="input-block mb-3">
                                                        <label class="col-form-label" for="countryname">Country Name<span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" id="countryname" placeholder="Enter First Name">
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-sm-6">
                                                    <div class="input-block mb-3">
                                                        <label class="col-form-label" for="title">Title<span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" id="title" placeholder="Enter Title">
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-sm-12">
                                                    <div class="input-block mb-3">
                                                        <label class="col-form-label">Visa Type<span class="text-danger">*</span></label>
                                                        <select id="designation" class="form-select">
                                                            <option value="NA">--Select Visa Type--</option>
                                                            <option value="visa_free">Visa Free</option>
                                                            <option value="visa_required">Visa Required</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-6 col-sm-12">
                                                    <div class="input-block mb-3">
                                                        <label class="col-form-label">Visa Category<span class="text-danger">*</span></label>
                                                        <select id="user_id_name" class="form-select">
                                                            <option value="NA">--Select Visa Category--</option>
                                                            <option value="on_arrival">On Arrival</option>
                                                            <option value="E_visa">E-Visa</option>
                                                            <option value="Stamp_visa">Stamp Visa</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-sm-6">
                                                    <div class="input-block mb-3">
                                                        <label class="col-form-label" for="processing_time">Tourist Processing Time<span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" id="processing_time" placeholder="Enter Tourist Processing Time">
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-sm-6">
                                                    <div class="input-block mb-3">
                                                        <label class="col-form-label" for="tourist_validity">Tourist Validity<span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" id="tourist_validity" placeholder="Enter Tourist Validity">
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-sm-6">
                                                    <div class="input-block mb-3">
                                                        <label class="col-form-label" for="business_processing_time">Business Processing Time<span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" id="business_processing_time" placeholder="Enter Business Processing Time">
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-sm-6">
                                                    <div class="input-block mb-3">
                                                        <label class="col-form-label" for="business_validity">Business Validity<span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" id="business_validity" placeholder="Enter Business Validity">
                                                    </div>
                                                </div>
                                                <!-- Dynamic sections -->
                                                <h5>Documents Required</h5>
                                                <div class="col-md-12 col-sm-12">
                                                    <div id="documents_required_section">
                                                        <input class="form-control mb-2 doc-input" placeholder="Enter document">
                                                    </div>
                                                    <button type="button" class="btn btn-secondary mb-2" onclick="addDocField('documents_required_section','doc-input')">Add More</button>
                                                </div>

                                                <h5>Supporting Documents</h5>
                                                <div class="col-md-12 col-sm-12">
                                                    <div id="supporting_docs_section">
                                                        <input class="form-control mb-2 supdoc-input" placeholder="Enter supporting document">
                                                    </div>
                                                    <button type="button" class="btn btn-secondary mb-2" onclick="addDocField('supporting_docs_section','supdoc-input')">Add More</button>
                                                </div>

                                                <h5>Remarks / Special Notes</h5>
                                                <div class="col-md-12 col-sm-12">
                                                    <div id="remarks_section">
                                                        <input class="form-control mb-2 remark-input" placeholder="Enter remark">
                                                    </div>
                                                    <button type="button" class="btn btn-secondary mb-2" onclick="addDocField('remarks_section','remark-input')">Add More</button>
                                                </div>

                                                <h5>FAQs</h5>
                                                <div class="col-md-12 col-sm-12">
                                                    <div id="faqs_section">
                                                        <input class="form-control mb-2 faq-question" placeholder="Enter question">
                                                    <input class="form-control mb-2 faq-answer" placeholder="Enter answer">
                                                    </div>
                                                    <button type="button" class="btn btn-secondary mb-2" onclick="addFaqField()">Add More FAQ</button>
                                                </div>

                                                <!-- Attachments -->
												<h4 class="my-2">Attachments</h4>
                                                <div class="col-md-12 col-sm-12">
                                                    <div class="mb-3" id="attachments_section">
                                                        <input class="form-control mb-2" type="file" name="file1" id="upload_file1" accept=".pdf,.png,.jpg">
                                                    </div>
                                                    <input type="hidden" id="img_path1" value="">
                                                    <div id="preview1" style="display: none;">
                                                        <div id="image_preview1">
                                                            <img  alt="Preview" class="imgSize" id="img_pre1">
                                                        </div>
                                                    </div>
                                                    <button type="button" class="btn btn-secondary mb-2" onclick="addAttachField()">Add More Attachment</button>
                                                </div>
                                            </div>
                                            <input type="hidden" id="testValue" name="testValue" value="11"> 
                                            <div class="d-flex justify-content-center mb-4">
                                                <button type="submit" class="btn btn-primary px-5 py-2" id="#">Submit</button>
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
                <?php include_once "../footer.php" ?>
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
            //On page load hide payment Mode and Payment proof if value selected is FOC or Null
            $(document).ready(function(){
                var payment_fee = $("#payment_fee").val();
                console.log(payment_fee);
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
            // on country change populate state values
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
        </script>
        <script>
            // Add dynamic input fields
            function addDocField(sectionId, className){
                let div = document.getElementById(sectionId);
                let input = document.createElement('input');
                input.className = `form-control mb-2 ${className}`;
                input.placeholder = "Enter document";
                div.appendChild(input);
            }

            function addFaqField(){
                let div = document.getElementById('faqs_section');
                let q = document.createElement('input');
                q.className='form-control mb-2 faq-question';
                q.placeholder='Enter question';
                let a = document.createElement('input');
                a.className='form-control mb-2 faq-answer';
                a.placeholder='Enter answer';
                div.appendChild(q); div.appendChild(a);
            }
            function addAttachField(){
                let div = document.getElementById('attachments_section');
                let input = document.createElement('input');
                input.type='file';
                input.className='form-control mb-2 attach-input';
                input.accept=".pdf,.png,.jpg";
                div.appendChild(input);
            }
        </script>
    </body>
</html>