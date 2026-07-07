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

    $id = $_GET['vkvbvjfgfikix'];
    $user_id = $_GET['fyfyfregby'];
    $reference_no = $_GET['nohbref'];
    $country_id = $_GET['ncy'];
    $state_id = $_GET['mst'];
    $city_id = $_GET['hct'];
    $reference_id = '';
    $user_type=$_GET['usertype'];
    $editfor = $_GET['editfor'];

    $stmt = $conn->prepare("SELECT * FROM `institution` where institution_id='" . $id . "' OR id = '" . $id . "'");
    $stmt->execute();
    // set the resulting array to associative
    $stmt->setFetchMode(PDO::FETCH_ASSOC);

    if ($stmt->rowCount() > 0) {
        foreach (($stmt->fetchAll()) as $key => $row) {
            $fid = $row['id'];
            // $sales_manager_name=$row['fname'];
            $firstname = $row['firstname'];
            // $username=$row['username'];
            $lastname = $row['lastname'];
            $nominee_name = $row['nominee_name'];
            $nominee_relation = $row['nominee_relation'];
            $email = $row['email'];
            $contact_no = $row['contact_no'];
            $note=$row['note'];
            $converted = $row['converted'];
            $amount = $row['amount'];
            $amtGST = $row['amtGST'];
            $reference_no = $row['reference_no'];
            $gst_no = $row['gst_no'];
            $date_of_birth = $row['date_of_birth'];
            $gender = $row['gender'];
            $country = $row['country'];
            $state = $row['state'];
            $city = $row['city'];
            $address = $row['address'];
            $payment_mode = $row['payment_mode'];
            $cheque_no = $row['cheque_no'];
            $cheque_date = $row['cheque_date'];
            $bank_name = $row['bank_name'];
            $transaction_no = $row['transaction_no'];
            // $id_proof=$row['id_proof'];
            $profile_pic = $row['profile_pic'];
            // $kyc=$row['kyc'];
            $pan_card = $row['pan_card'];
            $aadhar_card = $row['aadhar_card'];
            $voting_card = $row['voting_card'];
            $bank_passbook = $row['bank_passbook'];
            $payment_proof = $row['payment_proof'];
            $pincode = $row['pincode'];
            $status=$row['status'];
            $assign_status=$row['tc_assign_status']??null;
            $assign_TCs=$row['no_tc_alloted']??null;
            $assign_tenure=$row['repay_tenure']??null;
            $assign_roi=$row['roi']??null;
            $assign_tax=$row['tax']??null;
            $assign_repay_amount=$row['repay_amount']??null;
            $comm_per=$row['current_commission_per']??null;
            $ins_per=$row['current_incentive_per']??null;
            $f_status=$row['status'];
            // $complimentary=$row['complimentary'];
            // $converted=$row['converted'];

            if($f_status == '1'){
                // franchisee upgrade
                $f_upgrade = $conn->prepare("
                    SELECT upgrade_amt, new_commission_per, new_incentive_per 
                    FROM institution_upgrade 
                    WHERE institution_id = :id AND upgrade_status = '1' 
                    ORDER BY id DESC 
                    LIMIT 1
                ");
                $f_upgrade->execute([':id' => $id]);
                $f_upgrade->setFetchMode(PDO::FETCH_ASSOC);

                if ($f_upgrade->rowCount() > 0) {
                    $upgrade_f = $f_upgrade->fetch();

                    $amount   = $upgrade_f['upgrade_amt'];
                    $comm_per = $upgrade_f['new_commission_per'];
                    $ins_per  = $upgrade_f['new_incentive_per'];
                }
            }

            //get country
            $countries = $conn->prepare("SELECT country_name FROM countries where id='" . $country . "' and status='1' ");
            $countries->execute();
            $countries->setFetchMode(PDO::FETCH_ASSOC);
            if ($countries->rowCount() > 0) {
                $country = $countries->fetch();
                $countryname = $country['country_name'];
            }

            //get state
            $states = $conn->prepare("SELECT state_name FROM states where id='" . $state . "' and status='1' ");
            $states->execute();
            $states->setFetchMode(PDO::FETCH_ASSOC);
            if ($states->rowCount() > 0) {
                $state = $states->fetch();
                $statename = $state['state_name'];
            }
            //get city
            $cities = $conn->prepare("SELECT city_name FROM cities where id='" . $city . "' and status='1' ");
            $cities->execute();
            $cities->setFetchMode(PDO::FETCH_ASSOC);
            if ($cities->rowCount() > 0) {
                $city = $cities->fetch();
                $city_name = $city['city_name'];
            }

            //#3
            $reference_id = substr($reference_no, 0, 2);
            if ($reference_id == "MF") {
                // business Mentor name
                $business_mentors = $conn->prepare("SELECT firstname, lastname, reference_no FROM master_franchisee where master_franchisee_id='" . $reference_no . "'");
                $business_mentors->execute();
                //print_r($business_mentors);
                $business_mentors->setFetchMode(PDO::FETCH_ASSOC);
                if ($business_mentors->rowCount() > 0) {
                    $business_mentor = $business_mentors->fetch();
                    $reference_no_fname = $business_mentor['firstname'];
                    $reference_no_lname = $business_mentor['lastname'];
                    // $business_trainees_reference_no = $business_trainee['reference_no'];
                }
            } else if ($reference_id == "SF") {
                // business development manger name
                $business_development_manager = $conn->prepare("SELECT firstname, lastname FROM sponsor_franchisee where sponsor_franchisee_id='" . $reference_no . "'");
                $business_development_manager->execute();
                $business_development_manager->setFetchMode(PDO::FETCH_ASSOC);
                if ($business_development_manager->rowCount() > 0) {
                    $business_development_manager = $business_development_manager->fetch();
                    $reference_no_fname = $business_development_manager['firstname'];
                    $reference_no_lname = $business_development_manager['lastname'];
                    // $business_trainees_reference_no = $business_trainee['reference_no'];
                }
            } else if ($reference_id == "BH") {
                // business development manger name
                $business_development_manager = $conn->prepare("SELECT name, employee_id FROM employees where employee_id='" . $reference_no . "'");
                $business_development_manager->execute();
                $business_development_manager->setFetchMode(PDO::FETCH_ASSOC);
                if ($business_development_manager->rowCount() > 0) {
                    $business_development_manager = $business_development_manager->fetch();
                    $reference_no_name = $business_development_manager['name'];
                    // $business_trainees_reference_no = $business_trainee['reference_no'];
                }
            }
             else if ($reference_id == "BM") {
                // business development manger name
                $business_development_manager = $conn->prepare("SELECT firstname, lastname FROM business_mentor where business_mentor_id='" . $reference_no . "'");
                $business_development_manager->execute();
                $business_development_manager->setFetchMode(PDO::FETCH_ASSOC);
                if ($business_development_manager->rowCount() > 0) {
                    $business_development_manager = $business_development_manager->fetch();
                    $reference_no_fname = $business_development_manager['firstname'];
                    $reference_no_lname = $business_development_manager['lastname'];
                    // $business_trainees_reference_no = $business_trainee['reference_no'];
                }
            }
            else if ($reference_id == "ET") {
                // business development manger name
                $business_development_manager = $conn->prepare("SELECT firstname, lastname FROM executive_techno_enterprise where executive_techno_enterprise_id='" . $reference_no . "'");
                $business_development_manager->execute();
                $business_development_manager->setFetchMode(PDO::FETCH_ASSOC);
                if ($business_development_manager->rowCount() > 0) {
                    $business_development_manager = $business_development_manager->fetch();
                    $reference_no_fname = $business_development_manager['firstname'];
                    $reference_no_lname = $business_development_manager['lastname'];
                    // $business_trainees_reference_no = $business_trainee['reference_no'];
                }
            }
        }
    }
?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Edit Institution | Admin Dashboard </title>
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
        <!-- Form CSS -->
        <link href="../assets/css/form.css" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
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
                                    <h4 class="mb-sm-0">Edit Institution </h4>
                                    <!-- <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="view_institution.php">Institution</a></li>
                                            <li class="breadcrumb-item active">Edit Institution</li>
                                        </ol>
                                    </div> -->
                                </div>
                            </div>
                        </div>
                        <!-- end page title -->
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card rounded-4 addTECard">
                                    <div class="d-flex gap-3">
                                        <div class="addTEIconBackground">
                                            <i class="fa-solid fa-user-group addTEIcon"></i>
                                        </div>
                                        <div class="align-content-center">
                                            <h1 class="fw-bolder text-white">Edit Institution </h1>
                                            <p class="fs-5 text-white mb-0">Fill in the details below to register a new Institution under your network.</p>
                                        </div>
                                    </div>
                                    <img src="../assets/images/addTechnoFileImage.png" alt="" class="addTEImage">
                                </div>
                            </div>
                        </div>
                        <!-- Card Section 1 -->
                        <div class="card rounded-4 p-3 border-1">
                            <div class="row">
                                <div class="d-flex gap-2">
                                    <p class="fw-bolder addTENum">01</p>
                                    <h4 class="fw-bolder text-dark align-content-center">Personal Information</h4>
                                </div>
                                <div class="col-md-4 col-sm-6">
                                    <div class="input-block mb-3">
                                        <label class="col-form-label" for="designation"> Designation<span class="text-danger">*</span></label>
                                        <select id="designation" class="form-select">
                                            <option value="">--Select Designation--</option>
                                            <option value="business_development_manager">Business Development Manager </option>
                                            <option value="business_mentor">Business Mentor</option>
                                            <option value="corporate_agency">Techno Enterprise</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group col-md-4 col-sm-6">
                                    <div class="input-block mb-3">
                                        <label class="col-form-label">User ID & Name<span class="text-danger">*</span></label>
                                        <select id="user_id_name" class="form-select"> 
                                            <option value="">--Select Designation First--</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-6">
                                    <div class="input-block mb-3">
                                        <label class="col-form-label" for="reference_name"> Referance Name <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="reference_name" placeholder="No Referance selected for the user" readonly>
                                    </div>    
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6">
                                    <div class="input-block mb-3">
                                        <label class="col-form-label" for="firstname">Institution Name<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="firstname" placeholder="Enter your firstname">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6">
                                    <div class="input-block mb-3">
                                        <label class="col-form-label" for="numberBranch">No of Branches<span class="text-danger">*</span></label>
                                        <input type="number" class="form-control" id="numberBranch" placeholder="Enter No of Branches">
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <div class="form-group mb-3">
                                        <label class="col-form-label d-block">Types of Institution<span class="text-danger">*</span></label>
                                        <div class="form-control">
                                            <div class="row">
                                                <div class="col-lg-4 col-4 col-sm-6 col-12">
                                                    <label class="radio-inline mb-0 ms-3" for="test3"><input type="radio" id="test3" class="form-check-input instituteType me-3" name="instituteType" value="male">Bank</label>
                                                </div>
                                                <div class="col-lg-4 col-4 col-sm-6 col-12">
                                                    <label class="radio-inline mb-0 ms-3" for="test4"><input type="radio" id="test4" class="form-check-input instituteType me-3" name="instituteType" value="female">NBFC</label>
                                                </div>
                                                <div class="col-lg-4 col-4 col-sm-6 col-12">
                                                    <label class="radio-inline mb-0 ms-3" for="test5"><input type="radio" id="test5" class="form-check-input instituteType me-3" name="instituteType" value="others">Corperative Bank</label>
                                                </div>
                                                <div class="col-lg-4 col-4 col-sm-6 col-12">
                                                    <label class="radio-inline mb-0 ms-3" for="test6"><input type="radio" id="test6" class="form-check-input instituteType me-3" name="instituteType" value="others">Society</label>
                                                </div>
                                                <div class="col-lg-4 col-4 col-sm-6 col-12">
                                                    <label class="radio-inline mb-0 ms-3" for="test7"><input type="radio" id="test7" class="form-check-input instituteType me-3" name="instituteType" value="others">Trust</label>
                                                </div>
                                                <div class="col-lg-4 col-4 col-sm-6 col-12">
                                                    <label class="radio-inline mb-0 ms-3" for="test8"><input type="radio" id="test8" class="form-check-input instituteType me-3" name="instituteType" value="others">Others</label>
                                                </div>
                                            </div>
                                            <input type="text" name="other_leadership" id="otherLead" class="form-control mt-2" style="display:none;">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6">
                                    <div class="input-block mb-3">
                                        <label class="col-form-label" for="incorporationDate">Incorporation Date<span class="text-danger">*</span></label>
                                        <input type="date" class="form-control" id="incorporationDate" placeholder="Enter Incorporation Date">
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12 mb-3">
                                    <div class="row">
                                        <div class="col-md-4 col-sm-4 col-3">
                                            <div class="input-block">
                                                <label class="col-form-label" for="country_cd">Code</label>
                                                <select class="form-select" id="country_cd"></select>
                                            </div>
                                        </div>
                                        <div class="col-md-8 col-sm-8 col-9">
                                            <div class="input-block">
                                                <label class="col-form-label" for="phone">Phone Number<span class="text-danger">*</span></label>
                                                <input type="number" class="form-control" id="phone" placeholder="Enter your Phone Number">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6">
                                    <div class="input-block mb-3">
                                        <label class="col-form-label" for="institutionPAN">Institution PAN<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="institutionPAN" placeholder="Enter Institution PAN">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6">
                                    <div class="input-block mb-3">
                                        <label class="col-form-label" for="email">Email Address<span class="text-danger">*</span></label>
                                        <input type="email" class="form-control" id="email" placeholder="Enter Email Address">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Card Section 2 -->
                        <div class="card rounded-4 p-3 border-1">
                            <div class="row">
                                <div class="d-flex gap-2">
                                    <p class="fw-bolder addTENum">02</p>
                                    <h4 class="fw-bolder text-dark align-content-center">Registered Office Address:</h4>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6">
                                    <div class="input-block mb-3">
                                        <label class="col-form-label" for="country">Country<span class="text-danger">*</span></label>
                                        <select class="form-select" id="country" aria-label="Floating label select example">
                                            <option value="" selected>--Select Country--</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6">
                                    <div class="input-block mb-3">
                                        <label class="col-form-label" for="mystate">State<span class="text-danger">*</span></label>
                                        <select class="form-select" id="mystate" aria-label="Floating label select example">
                                            <option value="">--Select country first--</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6">
                                    <div class="input-block mb-3">
                                        <label class="col-form-label" for="city">City<span class="text-danger">*</span></label>
                                        <select class="form-select" id="city" aria-label="Floating label select example">
                                            <option value="">--Select state first--</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6">
                                    <div class="input-block mb-3">
                                        <label class="col-form-label" for="pin">Pincode<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="pin" placeholder="Enter your pincode">
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <div class="input-block mb-3">
                                        <label class="col-form-label" for="address">Address<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="address" placeholder="Enter your Address">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Card Section 3 -->
                        <div class="card rounded-4 p-3 border-1">
                            <div class="row">
                                <div class="d-flex gap-2">
                                    <p class="fw-bolder addTENum">03</p>
                                    <h4 class="fw-bolder text-dark align-content-center">Bank Details:</h4>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6">
                                    <div class="input-block mb-3">
                                        <label class="col-form-label" for="accountName">Account Name<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="accountName" placeholder="Enter your Account Name">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6">
                                    <div class="input-block mb-3">
                                        <label class="col-form-label" for="accountNumber">Account Number<span class="text-danger">*</span></label>
                                        <input type="number" class="form-control" id="accountNumber" placeholder="Enter your Account Number">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6">
                                    <div class="input-block mb-3">
                                        <label class="col-form-label" for="ifscCode">IFSC Code<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="ifscCode" placeholder="Enter your IFSC Code">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6">
                                    <div class="input-block mb-3">
                                        <label class="col-form-label" for="branchName">Bank & Branch Name<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="branchName" placeholder="Enter your Bank & Branch Name">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Card Section 4 -->
                        <div class="card rounded-4 p-3 border-1">
                            <div class="row">
                                <div class="d-flex gap-2">
                                    <p class="fw-bolder addTENum">04</p>
                                    <h4 class="fw-bolder text-dark align-content-center">Payment Information</h4>
                                </div>
                                <div class="col-md-6 col-sm-6">
                                    <div class="input-block mb-3">
                                        <label class="col-form-label" for="activationPlan">Activation Plan<span class="text-danger">*</span></label>
                                        <select id="activationPlan" class="form-select"> 
                                            <option value="">--Select Activation Plan--</option> 
                                            <option value="FOC">FOC</option> 
                                            <option value="200000">2,00,000/-</option> 
                                            <option value="300000">3,00,000/-</option> 
                                            <option value="400000">4,00,000/-</option> 
                                            <option value="500000">5,00,000/-</option> 
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6">
                                    <label class="fw-bold col-form-label">Payment Mode: <span class="text-danger">*</span></label>
                                    <div class="form-control radioBtn d-flex justify-content-around" id="paymentMode">
                                        <label class="mb-0" for="cashPayment"><input type="radio" id="cashPayment" class="form-check-input payment me-3" name="payment" value="cash">Cash</label>
                                        <label class="mb-0" for="chequePayment"><input type="radio" id="chequePayment"  class="form-check-input payment me-3" name="payment" value="cheque">Cheque</label>
                                        <label class="mb-0" for="onlinePayment"><input type="radio" id="onlinePayment"  class="form-check-input payment me-3" name="payment" value="online">UPI/NEFT</label>
                                    </div>
                                </div>
                                <div class="pb-3">
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
                                                    <label class="col-form-label" for="transactionNo">Transaction No<span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" id="transactionNo" placeholder="Enter your Transaction No.">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Card Section 5 -->
                        <div class="card rounded-4 p-3 border-1">
                            <div class="">
                                <div class="d-flex gap-2">
                                    <p class="fw-bolder addTENum">05</p>
                                    <h4 class="fw-bolder text-dark align-content-center">Upload Information</h4>
                                </div>
                                <div class="row g-3">
                                    <!-- Certificate of Incorporation -->
                                    <div class="col-lg-4 col-md-4 col-sm-6 col-12">
                                        <div class="upload-card" data-title="Certificate of Incorporation" data-index="1">
                                            <input type="hidden" id="img_path1" value="">
                                            <input type="file" class="file-input" accept="image/*,.pdf" id="upload_file1">
                                            <div class="upload-content">
                                                <div class="upload-icon">
                                                    <i class="fa-solid fa-user"></i>
                                                </div>
                                                <h6>Certificate of Incorporation</h6>
                                                <p>Click to upload<br>or drag and drop</p>
                                                <small>(JPG, PNG, PDF)</small>
                                            </div>
                                        </div>
                                    </div>
									<!-- GSTIN -->
									<div class="col-lg-4 col-md-4 col-sm-6 col-12">
										<div class="upload-card" data-title="GSTIN" data-index="2">
											<input type="hidden" id="img_path2" value="">
											<input type="file" class="file-input" accept="image/*,.pdf" id="upload_file2">
											<div class="upload-content">
												<div class="upload-icon">
													<i class="fa-regular fa-id-card"></i>
												</div>
												<h6>GSTIN</h6>
												<p>Click to upload<br>or drag and drop</p>
												<small>(JPG, PNG, PDF)</small>
											</div>
										</div>
									</div>
                                    <!-- Board Resolution -->
									<div class="col-lg-4 col-md-4 col-sm-6 col-12">
										<div class="upload-card" data-title="Board Resolution" data-index="3">
											<input type="hidden" id="img_path3" value="">
											<input type="file" class="file-input" accept="image/*,.pdf" id="upload_file3">
											<div class="upload-content">
												<div class="upload-icon">
													<i class="fa-regular fa-credit-card"></i>
												</div>
												<h6>Board Resolution</h6>
												<p>Click to upload<br>or drag and drop</p>
												<small>(JPG, PNG, PDF)</small>
											</div>
										</div>
									</div>
									<!-- Bank Passbook -->
									<div class="col-lg-4 col-md-4 col-sm-6 col-12">
										<div class="upload-card" data-title="Bank Passbook" data-index="4">
											<input type="hidden" id="img_path4" value="">
											<input type="file" class="file-input" accept="image/*,.pdf" id="upload_file4">
											<div class="upload-content">
												<div class="upload-icon">
													<i class="fa-solid fa-building-columns"></i>
												</div>
												<h6>Cancelled Cheque / Bank Passbook</h6>
												<p>Click to upload<br>or drag and drop</p>
												<small>(JPG, PNG, PDF)</small>
											</div>
										</div>
									</div>
									<!-- PAN Card -->
									<div class="col-lg-4 col-md-4 col-sm-6 col-12">
										<div class="upload-card" data-title="PAN Card" data-index="4">
											<input type="hidden" id="img_path4" value="">
											<input type="file" class="file-input" accept="image/*,.pdf" id="upload_file5">
											<div class="upload-content">
												<div class="upload-icon">
													<i class="fa-solid fa-building-columns"></i>
												</div>
												<h6>PAN Card</h6>
												<p>Click to upload<br>or drag and drop</p>
												<small>(JPG, PNG, PDF)</small>
											</div>
										</div>
									</div>
									<!-- Address Proof -->
									<div class="col-lg-4 col-md-4 col-sm-6 col-12" id="addressProof">
										<div class="upload-card" data-title="Address Proof" data-index="4">
											<input type="hidden" id="img_path4" value="">
											<input type="file" class="file-input" accept="image/*,.pdf" id="upload_file6">
											<div class="upload-content">
												<div class="upload-icon">
													<i class="fa-solid fa-building-columns"></i>
												</div>
												<h6>Address Proof</h6>
												<p>Click to upload<br>or drag and drop</p>
												<small>(JPG, PNG, PDF)</small>
											</div>
										</div>
									</div>
									<!-- Payment Proof -->
									<div class="col-lg-4 col-md-4 col-sm-6 col-12" id="payProof">
										<div class="upload-card" data-title="Payment Proof" data-index="4">
											<input type="hidden" id="img_path4" value="">
											<input type="file" class="file-input" accept="image/*,.pdf" id="upload_file7">
											<div class="upload-content">
												<div class="upload-icon">
													<i class="fa-solid fa-building-columns"></i>
												</div>
												<h6>Payment Proof</h6>
												<p>Click to upload<br>or drag and drop</p>
												<small>(JPG, PNG, PDF)</small>
											</div>
										</div>
									</div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="d-flex justify-content-end gap-4 submitBtnBackground">
                                    <button type="button" class="btn actionBtn cancelBtn mb-2">Cancel</button>
                                    <button type="button" class="btn actionBtn draftBtn mb-2" id="saveDraftAdd">Save Draft</button>
                                    <button type="submit" class="btn actionBtn submitBtn mb-2" id="addCustomer">
                                        <i class="fa-regular fa-paper-plane me-2"></i>
                                        Submit Customer
                                    </button>
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

        <!-- file upload code js file -->
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
            //select Register as
            $('#registered').on('change',function(){
                var register_type=$(this).val();
                if(register_type == 'corporate_agency'){
                    $('#designation1').prop('disabled', false);
                    $('#designation1').removeClass('d-none');
                    $('#designation2').addClass('d-none');
                    $('#business_package_amount1').prop('disabled', false);
                    $('#business_package_amount1').removeClass('d-none');
                    $('#business_package_amount2').addClass('d-none');
                    $('.gender').prop('disabled', false);
                }else if(register_type == 'sub_franchisee'){
                    $('#designation1').addClass('d-none');
                    $('#designation2').removeClass('d-none');
                    $('#business_package_amount2').removeClass('d-none');
                    $('#business_package_amount1').addClass('d-none');
                    $('.gender').prop('disabled', false);
                    // var business_package_amount = $('#business_package_amount2').val();
                    // $('#flex_amount').val(business_package_amount);
                }else if(register_type == 'institution'){
                    $('#designation1').addClass('d-none');
                    $('#designation2').removeClass('d-none');
                    $('#business_package_amount2').removeClass('d-none');
                    $('#business_package_amount1').addClass('d-none');
                    const val = $("#test5").val();

                    $('.gender[value="' + val + '"]').prop('checked', true);
                    $('.gender').prop('disabled', true);
                }
                    
            });
            
            //select Designation
            $('#designation1').on('change', function() {
                var designation = $('#designation1').val();
                console.log(designation);
                $.ajax({
                    type:'POST',
                    url:'../agents/get_user_Franchisee.php',
                    data: "designation="+designation,
                    success:function (e) {
                        console.log(e);
                        $('#user_id_name').html(e); 
                    },
                    error: function(err){
                        console.log(err);
                    },
                });
            });

            $('#designation2').on('change', function() {
                var designation = $('#designation2').val();
                console.log(designation);
                $.ajax({
                    type:'POST',
                    url:'../agents/get_user_Franchisee.php',
                    data: "designation="+designation,
                    success:function (e) {
                        console.log(e);
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
                var designation = !$('#designation1').hasClass('d-none') 
                ? $('#designation1').val() 
                : $('#designation2').val();
                console.log(user_id_name);

                // var designation = 'franchisee';
                // console.log(designation);

                $.ajax({
                    type:'POST',
                    url:'../agents/getUsers.php',
                    data: 'user_id_name=' + user_id_name + '&designation=' + designation ,
                    success:function(response){
                    // console.log(response);
                        $('#pin').html(response);
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

            $('#business_package_amount1').on('change', function(){
                var business_package_amount = $(this).val();
                $('#flex_amount').val(business_package_amount);
            });
            
            $('#business_package_amount2').on('change', function(){
                var business_package_amount = $(this).val();
                $('#flex_amount').val(business_package_amount);
            });
            

            $('#paymentMode').on('click', function(){
                var paymentMode = $(".payment:checked").val();
                // console.log(paymentMode);
                if(paymentMode == "cheque"){
                    $("#chequeOpt").removeClass("d-none");
                    $("#onlineOpt").addClass("d-none");
                    $("#transactionNo").val("");
                }else if(paymentMode == "online"){
                    $("#onlineOpt").removeClass("d-none");
                    $("#chequeOpt").addClass("d-none");
                    $("#chequeNo").val("");
                    $("#chequeDate").val("");
                    $("#bankName").val("");
                } else {
                    $("#chequeOpt").addClass("d-none");
                    $("#onlineOpt").addClass("d-none");
                    $("#chequeNo").val("");
                    $("#chequeDate").val("");
                    $("#bankName").val("");
                    $("#transactionNo").val("");
                }
            });
        </script>
        <script>
            $(".instituteType").change(function () {
                if ($("#test8").is(":checked")) {
                    $("#otherLead").slideDown();
                } else {
                    $("#otherLead").slideUp();
                    $("#otherLead").val("");
                }
            });
        </script>
    </body>
</html>