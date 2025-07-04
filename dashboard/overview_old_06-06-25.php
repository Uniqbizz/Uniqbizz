<?php

    include_once 'dashboard_user_details.php';

    $id = $_GET['id'];
    $ref = $_GET['ref'];
    // $country = $_GET['cut'];
    // $state = $_GET['st'];
    // $city = $_GET['ct'];
    $DBtable = $_GET['message'];
    $designations = $_GET['designation'];
    // echo $id;
    // echo $ref;
    // echo $country;
    // echo $state;
    // echo $city;
    // echo $DBtable;
    // if($DBtable == 'business_consultant'){
    //     $sql = "SELECT * FROM business_consultant WHERE business_consultant_id = '".$id."' AND status = '1'";
    // }else if($DBtable == 'business_trainee'){
    //     $sql = "SELECT * FROM business_trainee WHERE business_trainee_id = '".$id."' AND status = '1'";
    // }else if($DBtable == 'techno_enterprise'){
    //     $sql = "SELECT * FROM corporate_agency WHERE corporate_agency_id = '".$id."' AND status = '1'";
    // }else if($DBtable == 'ca_travelagency'){
    //     $sql = "SELECT * FROM ca_travelagency WHERE ca_travelagency_id = '".$id."' AND status = '1'";
    // }else if($DBtable == 'channel_business_director'){
    //     $sql = "SELECT * FROM channel_business_director WHERE channel_business_director_id = '".$id."' AND status = '1'";
    // }else{
    //     $sql = "SELECT * FROM ca_customer WHERE ca_customer_id = '".$id."' AND status = '1'";
    // }
    if ($DBtable == 'business_consultant') { // 3
        $sql = "SELECT * FROM business_consultant WHERE business_consultant_id = '" . $id . "' AND status = '1'";
    } else if ($DBtable == 'business_trainee') { // 15
        $sql = "SELECT * FROM business_trainee WHERE business_trainee_id = '" . $id . "' AND status = '1'";
    } else if ($DBtable == 'corporate_agency') { // 16
        $sql = "SELECT * FROM corporate_agency WHERE corporate_agency_id = '" . $id . "' AND status = '1'";
    } else if ($DBtable == 'ca_travelagency') { // 11
        $sql = "SELECT * FROM ca_travelagency WHERE ca_travelagency_id = '" . $id . "' AND status = '1'";
    } else if ($DBtable == 'channel_business_director') { // 18
        $sql = "SELECT * FROM channel_business_director WHERE channel_business_director_id = '" . $id . "' AND status = '1'";
    } else if ($DBtable == 'ca_customer') { // 10
        $sql = "SELECT * FROM ca_customer WHERE ca_customer_id = '" . $id . "' AND status = '1'";
    } else if ($DBtable == 'business_chanel_manager') { // 24,
        $sql = "SELECT * FROM employees WHERE employee_id = '" . $id . "' AND status = '1' AND user_type=24";
    } else if ($DBtable == 'business_developement_manager') { // 25
        $sql = "SELECT * FROM employees WHERE employee_id = '" . $id . "' AND status = '1' AND user_type=25";
    } 
    else if ($DBtable == 'business_mentor') { // 26
        $sql = "SELECT * FROM business_mentor WHERE business_mentor_id = '" . $id . "' AND status = '1'";
    }
    $stmt = $conn -> prepare($sql);
    $stmt -> execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $reporting_manager_name = '';
    $reference_no='';
    $nominee_name='';
    $nominee_relation='';
    $countryname='';
    if ($stmt->rowCount() > 0) {
        foreach (($stmt->fetchAll()) as $key => $row) {
            if ($DBtable == 'business_developement_manager' || $DBtable == 'business_chanel_manager') {
                $fid = $row['id'];
                $name = $row['name'];
                $email = $row['email'];
                $country_code = $row['country_code'];
                $contact = $row['contact'];
                $reporting_manager_id = $row['reporting_manager'];
                $date_of_birth = $row['date_of_birth'];
                $date_of_joining = $row['date_of_joining'];
                $gender = $row['gender'];
                $department = $row['department'];
                $design = $row['designation'];
                $zone = $row['zone'];
                $branch = $row['branch'];
                $address = $row['address'];
                $profile_pic = $row['profile_pic'];
                $id_proof = $row['id_proof'];
                $bank_details = $row['bank_details'];
                $register_by = $row['register_by'];
                $user_type = $row['user_type'];
                // $register_date=$row['register_date'];
                $rd = new DateTime($row['register_date']);
                $rdate = $rd->format('d-m-Y');

                //get country
                $departments = $conn->prepare("SELECT dept_name FROM department where id='" . $department . "' and status='1' ");
                $departments->execute();
                $departments->setFetchMode(PDO::FETCH_ASSOC);
                if ($departments->rowCount() > 0) {
                    $department = $departments->fetch();
                    $departmentname = $department['dept_name'];
                }

                //get state
                $designations = $conn->prepare("SELECT designation_name FROM designation where id='" . $design . "' and status='1' ");
                $designations->execute();
                $designations->setFetchMode(PDO::FETCH_ASSOC);
                if ($designations->rowCount() > 0) {
                    $desig = $designations->fetch();
                    $designation = $desig['designation_name'];
                }
                //get city
                $zones = $conn->prepare("SELECT zone_name FROM zone where id='" . $zone . "' and status='1' ");
                $zones->execute();
                $zones->setFetchMode(PDO::FETCH_ASSOC);
                if ($zones->rowCount() > 0) {
                    $zone = $zones->fetch();
                    $zone_name = $zone['zone_name'];
                }

                //get city
                $branchs = $conn->prepare("SELECT branch_name FROM branch where id='" . $branch . "' and status='1' ");
                $branchs->execute();
                $branchs->setFetchMode(PDO::FETCH_ASSOC);
                if ($branchs->rowCount() > 0) {
                    $branch = $branchs->fetch();
                    $branch_name = $branch['branch_name'];
                }

                //get city
                $employees = $conn->prepare("SELECT name FROM employees where employee_id='" . $reporting_manager_id . "' and status='1' ");
                $employees->execute();
                $employees->setFetchMode(PDO::FETCH_ASSOC);
                if ($employees->rowCount() > 0) {
                    $employee = $employees->fetch();
                    $employee_name = $employee['name'];
                }

                // Get Reporting Manager Name

                if (is_null($reporting_manager_id)) {
                    $reporting_manager_name = 'Not Applicable';
                } else {
                    $reporting_managers = $conn->prepare("SELECT * FROM employees WHERE employee_id = :reporting_manager");
                    $reporting_managers->execute(['reporting_manager' => $reporting_manager_id]);
                    $reporting_managers->setFetchMode(PDO::FETCH_ASSOC);
                    if ($reporting_managers->rowCount() > 0) {
                        $reporting_manager = $reporting_managers->fetch();
                        $reporting_manager_name = $reporting_manager['name'];
                    }
                }
            } else {
                $rd = new DateTime($row['register_date']);
                $rdate = $rd->format('d-m-Y');
                $fid = $row['id'];
                $firstname = $row['firstname'];
                $lastname = $row['lastname'];
                $nominee_name = $row['nominee_name'];
                $nominee_relation = $row['nominee_relation'];
                $email = $row['email'];
                $contact_no = $row['country_code'] . $row['contact_no'];
                $reference_no = $row['reference_no'];
                $registrant = $row['registrant'];
                $date_of_birth = $row['date_of_birth'];
                $gender = $row['gender'];
                $country = $row['country'];
                $state = $row['state'];
                $city = $row['city'];
                $address = $row['address'];
                $profile_pic = $row['profile_pic'];
                $pan_card = $row['pan_card'];
                $aadhar_card = $row['aadhar_card'];
                $voting_card = $row['voting_card'];
                // bank passbook field name changed in ca_travelagency table
                if ($DBtable == 'ca_travelagency' || $DBtable == 'ca_customer') {
                    $bank_passbook = $row['passbook'];
                } else {
                    $bank_passbook = $row['bank_passbook'];
                }

                if ($DBtable == 'corporate_agency' || $DBtable == 'ca_travelagency' || $DBtable == 'ca_customer') {
                    $payment_proof = $row['payment_proof'];
                    $payment_mode = $row['payment_mode'];
                    $cheque_no = $row['cheque_no'];
                    $cheque_date = $row['cheque_date'];
                    $bank_name = $row['bank_name'];
                    $transaction_no = $row['transaction_no'];
                }
                if ($DBtable == 'ca_customer') {
                    $ta_ref_no = $row['ta_reference_no'];
                    $ta_name = $row['ta_reference_name'];
                }

                $pincode = $row['pincode'];
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
                    $cityname = $city['city_name'];
                }
            }
        }
    }
    $User_name = ($DBtable == 'business_developement_manager' || $DBtable == 'business_chanel_manager') ? $name : $firstname . ' ' . $lastname;

    
?>
<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable">


<!-- Mirrored from themesbrand.com/velzon/html/material/apps-projects-overview.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 06 Dec 2023 11:37:57 GMT -->
<head>

    <meta charset="utf-8" />
    <title>Overview Profile | Admin Uniqbizz</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- App favicon -->
    <link rel="shortcut icon" href="assets/images/fav.png">
    

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
    <!-- accordian css -->
    <link href="assets/css/custom.css" rel="stylesheet" type="text/css" />
    <!-- DataTables -->
    <link href="assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <!-- Responsive datatable examples -->
    <link href="assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="assets/css/custom.css"/>
    <link rel="stylesheet" href="assets/fontawesome/css/all.min.css" />
        <style>
            #image_preview1{
                height: 150px;
                width: 150px;
            }
            #preview1 img{
                width: 100%;
                height: auto;
            }

            #image_preview2{
                height: 150px;
                width: 150px;
            }
            #preview2 img{
                width: 100%;
                height: auto;
            }
            
            #image_preview3{
                height: 150px;
                width: 150px;
            }
            #preview3 img{
                width: 100%;
                height: auto;
            }

            #image_preview4{
                height: 150px;
                width: 150px;
            }
            #preview4 img{
                width: 100%;
                height: auto;
            }

            #image_preview5{
                height: 150px;
                width: 150px;
            }
            #preview5 img{
                width: 100%;
                height: auto;
            }

            #image_preview6{
                height: 150px;
                width: 150px;
            }
            #preview6 img{
                width: 100%;
                height: auto;
            }

            input::file-selector-button {
                background-color: #f1b44c;
                background-size: 150%;
                border: 0;
                border-radius: 8px;
                color: #fff;
                padding: 1rem 1.25rem;
                text-shadow: 0 1px 1px #333;
                transition: all 0.25s;
                color: white;
            }
            input::file-selector-button:hover {
                background-color: #ffca04;
            }

        </style>
</head>

<body>

    <!-- Begin page -->
    <div id="layout-wrapper">
    <?php include_once "header.php" ?>

    <!-- ========== App Menu ========== -->

    <?php include_once "sidebar.php" ?>
    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->
        <div class="main-content">

            <div class="page-content">
                <div class="container-fluid">

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card mt-n4 mx-n4">
                                <div class="bg-warning-subtle">
                                    <div class="card-body pb-0 px-4">
                                        <div class="row mb-3">
                                            <div class="col-md">
                                                <div class="row align-items-center g-3">
                                                    <div class="col-md-auto pt-2">
                                                        <div class="avatar-md">
                                                            <div class="avatar-title bg-white rounded-circle">
                                                                <?php
                                                                    if($profile_pic){
                                                                        echo '<img src="../uploading/'.$profile_pic.'" alt="Preview" class="avatar-md rounded-circle">';
                                                                    }else{
                                                                        echo '<img src="../uploading/not_uploaded.png" alt="Preview" class="avatar-md rounded-circle">';
                                                                    }
                                                                ?>
                                                                <!-- <img src="<?php echo '../../uploading/'.$profile_pic; ?>" alt="" class="avatar-md rounded-circle"> -->
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md">
                                                        <div class="row">
                                                            <h4 class="fw-bol mt-2 me-0"><?php echo $firstname.' '.$lastname.' '.$id ; ?></h4>
                                                            <div class="hstack gap-3 flex-wrap">
                                                                <div><i class="ri-building-line align-bottom me-1"></i> <?php echo $designation; ?></div>
                                                                <div class="vr"></div>
                                                                <div>Create Date : <span class="fw-medium"><?php echo $rdate; ?></span></div>
                                                                <div class="vr"></div>
                                                                <!-- <div>
                                                                    <a class="btn btn-primary badge rounded-pill fs-15" href="#project-overview">Payout</a> 
                                                                </div>    -->
                                                            </div>    
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <ul class="nav nav-tabs-custom border-bottom-0" role="tablist">
                                                <li class="nav-item">
                                                    <a class="nav-link active fw-semibold" data-bs-toggle="tab" href="#project-overview" role="tab">
                                                        Overview
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link fw-semibold" data-bs-toggle="tab" href="#project-activities" role="tab">
                                                        Activities
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link fw-semibold" data-bs-toggle="tab" href="#project-team" role="tab">
                                                        Team
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link fw-semibold" data-bs-toggle="tab" href="#project-payout" role="tab">
                                                        Payout
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div><!-- end card body -->
                                </div>
                            </div><!-- end card -->
                        </div>
                        <!-- end col -->
                    </div>
                    <!-- end row -->
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="tab-content">
                                <div class="tab-pane fade show active" id="project-overview" role="tabpanel">
                                    <div class="card p-4">
                                        <div class="card-body">
                                            <form>
                                                <?php
                                                if($reference_no){
                                                    echo'<div class="row">
                                                        <div class="col-md-6 col-sm-12">
                                                            <div class="form-floating mb-3">
                                                                <input type="text" class="form-control" id="reference_name" placeholder="Enter User NAme and Id" value=" '.$reference_no.' " readonly>
                                                                <label for="user_id_name">User Id & Name </label>   
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-sm-12">
                                                            <div class="form-floating mb-3">
                                                                <input type="text" class="form-control" id="reference_name" placeholder="No Referance selected for the user" value=" '.$registrant.' " readonly>
                                                                <label for="reference_name">Reference Name </label>
                                                            </div>
                                                        </div>
                                                    </div>';
                                                }else{
                                                    echo '<div class="row">
                                                                <div class="col-md-6 col-sm-12">
                                                                    <div class="form-floating mb-3">
                                                                        <input type="text" class="form-control" id="reference_name" placeholder="Enter User Name and Id" value="' . 
                                                                            (isset($row['ta_reference_no']) ? $row['ta_reference_no'] : (isset($row['ta_reference_name']) ? $row['ta_reference_name'] : "NA")) . 
                                                                        '" readonly>
                                                                        <label for="user_id_name">User Id & Name </label>   
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6 col-sm-12">
                                                                    <div class="form-floating mb-3">
                                                                        <input type="text" class="form-control" id="reference_name" placeholder="No Reference selected for the user" value="' . 
                                                                            (!empty($row['ta_reference_name']) ? $row['ta_reference_name'] : "NA") . 
                                                                        '" readonly>
                                                                        <label for="reference_name">Reference Name </label>
                                                                    </div>
                                                                </div>
                                                            </div>';
                                                }
                                                ?>
                                                <div class="row">
                                                    <div class="col-md-6 col-sm-12">
                                                        <div class="form-floating mb-3">
                                                            <input type="text" class="form-control" id="firstname" placeholder="Enter First Name" value="<?php echo $firstname; ?>" readonly>
                                                            <label for="firstname">First Name</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-sm-12">
                                                        <div class="form-floating mb-3">
                                                            <input type="text" class="form-control" id="lastname" placeholder="Enter Last Name" value="<?php echo $lastname; ?>" readonly>
                                                            <label for="lastname">Last Name</label>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-6 col-sm-12">
                                                        <div class="form-floating mb-3">
                                                            <input type="text" class="form-control" id="nominee_name" placeholder="Enter Nominee First Name" value="<?php echo $nominee_name ? $nominee_name : 'No Nominee Added'; ?>" readonly>
                                                            <label for="nominee_name">Nominee Name</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-sm-12">
                                                        <div class="form-floating mb-3">
                                                            <input type="text" class="form-control" id="nominee_relation" placeholder="Enter Nominee Relation" value="<?php echo $nominee_relation ? $nominee_relation : 'No Nominee Added'; ?>" readonly>
                                                            <label for="nominee_relation">Nominee Relation</label>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-6 col-sm-12">
                                                        <div class="form-floating mb-3">
                                                            <input type="email" class="form-control" id="email" placeholder="Enter Email address" value="<?php echo $email; ?>"readonly>
                                                            <label for="email">Email address</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-sm-12">
                                                        <div class="form-floating mb-3">
                                                            <input type="date" class="form-control" id="dob" placeholder="Enter date" value="<?php echo $date_of_birth; ?>" readonly>
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
                                                                    <input class="form-check-input gender" type="radio" name="gender" id="test3" value="male" <?php if ($gender == 'male'){echo ' checked ';} ?> readonly>
                                                                    <label class="form-check-label" for="test3">Male</label>
                                                                </div>
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input gender" type="radio" name="gender" id="test4" value="female" <?php if ($gender == 'female'){echo ' checked ';} ?>readonly>
                                                                    <label class="form-check-label" for="test4">Female</label>
                                                                </div>       
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input gender" type="radio" name="gender" id="test5" value="others" <?php if ($gender == 'others'){echo ' checked ';} ?>readonly>
                                                                    <label class="form-check-label" for="test5">Others</label>
                                                                </div>                                                          
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6 col-sm-12 code-mobile">
                                                        <div class="form-floating  col-sm-12" >
                                                            <input type="number" class="form-control" id="phone" placeholder="Enter Phone Number" value="<?php echo $contact_no; ?>" readonly>
                                                            <label for="phone">Phone Number</label>
                                                        </div>  
                                                    </div>
                                                </div>

                                                <div class="row <?=$DBtable == 'business_developement_manager' || $DBtable == 'business_chanel_manager'?'d-none':''?>">
                                                    <div class="col-md-6 col-sm-12">
                                                        <div class="form-floating mb-3">
                                                            <input type="text" class="form-control" id="country" placeholder="Enter country" value="<?php echo $countryname; ?>" readonly>
                                                            <label for="country">Country</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-sm-12">
                                                        <div class="form-floating mb-3">
                                                            <input type="text" class="form-control" id="mystate" placeholder="Enter state" value="<?php echo $statename; ?>" readonly>
                                                            <label for="mystate">State</label>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row <?=$DBtable == 'business_developement_manager' || $DBtable == 'business_chanel_manager'?'d-none':''?>">
                                                    <div class="col-md-6 col-sm-12">
                                                        <div class="form-floating mb-3">
                                                            <input type="text" class="form-control" id="city" placeholder="Enter city" value="<?php echo $cityname; ?>" readonly>
                                                            <label for="city">City</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-sm-12">
                                                        <div class="form-floating mb-3">
                                                            <input type="text" class="form-control" id="pin" placeholder="Pincode" value="<?php echo $pincode; ?>" readonly>
                                                            <label for="pin">Pincode</label>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-12 col-sm-12">
                                                        <div class="form-floating mb-3">
                                                            <input type="text" class="form-control" id="address" placeholder="Enter First Name" value="<?php echo $address; ?>" readonly>
                                                            <label for="address">Address</label>
                                                        </div>
                                                    </div>
                                                </div>

                                                <?php if($DBtable == 'techno_enterprise' ){ ?>
                                                    <div class="row py-3">
                                                        <div class="col-lg-12" id="paymentMode">
                                                            <p>Payment Mode</p>
                                                            <input type="radio" id="cashPayment" class="form-check-input payment" name="payment" value="cash" <?php if($row['payment_mode'] == "cash") {echo 'checked';} ?> disabled>
                                                            <label for="cashPayment">Cash</label>
                                                            <input type="radio" id="chequePayment"  class="form-check-input payment ms-2" name="payment" value="cheque" <?php if($row['payment_mode'] == "cheque") {echo 'checked';} ?> disabled>
                                                            <label for="chequePayment">Cheque</label>
                                                            <input type="radio" id="onlinePayment"  class="form-check-input payment ms-2" name="payment" value="online" <?php if($row['payment_mode'] == "online") {echo 'checked';} ?> disabled>
                                                            <label for="onlinePayment">UPI/NEFT</label>
                                                        </div>

                                                        <div class="col-lg-12 d-none" id="chequeOpt" style="display:flex; justify-content: space-evenly;">
                                                            <div class="col-lg-3 ">
                                                                <div class="form-floating">
                                                                    <input type="text" class="form-control" id="chequeNo" placeholder="Enter Cheque Number" value="<?php echo $row['cheque_no'];?>" readonly>
                                                                    <label for="chequeNo">Cheque No</label>
                                                                </div>
                                                            </div>

                                                            <div class="col-lg-3 ">
                                                                <div class="form-floating">
                                                                    <input type="text" class="form-control" id="chequeDate" placeholder="Enter Date On Cheque" value="<?php echo $row['cheque_date'];?>" readonly>
                                                                    <label for="chequeDate">Cheque Date</label>
                                                                </div>
                                                            </div>

                                                            <div class="col-lg-3 ">
                                                                <div class="form-floating">
                                                                    <input type="text" class="form-control" id="bankName" placeholder="Enter your Bank Name" value="<?php echo $row['bank_name'];?>" readonly>
                                                                    <label for="bankName">Bank Name</label>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-lg-12 d-none" id="onlineOpt" style="display:flex; justify-content: space-evenly;">
                                                            <div class="col-lg-8">
                                                                <div class="form-floating">
                                                                    <input type="text" class="form-control" id="transactionNo" placeholder="Enter your Transaction No." value="<?php echo $row['transaction_no'];?>" readonly>
                                                                    <label for="transactionNo">Transaction No.</label>
                                                                </div>
                                                            </div>
                                                        </div>   
                                                    </div>
                                                <?php } ?>

                                                <div class="row">
                                                    <div class="col-md-6 col-sm-12">
                                                        <div class="mb-3">
                                                            <label for="file1"><b>PROFILE</b></label><br/>
                                                        </div>
                                                        <div id="preview1" >
                                                            <div id="image_preview1">
                                                                <?php
                                                                    if($profile_pic ==''){
                                                                        echo '<img src="../uploading/not_uploaded.png" alt="Preview" id="img_pre1">';
                                                                    }else{
                                                                        echo '<img src="../uploading/'.$profile_pic.'" alt="Preview" id="img_pre1">';
                                                                    }
                                                                ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-sm-12 ">
                                                        <div class="mb-3">
                                                            <label for="file2"><b>AADHAR CARD</b></label><br/>
                                                        </div>
                                                        <div id="preview2" >
                                                            <div id="image_preview2">
                                                                <?php
                                                                    if($aadhar_card ==''){
                                                                        echo '<img src="../uploading/not_uploaded.png" alt="Preview" id="img_pre2">';
                                                                    }else{
                                                                        echo '<img src="../uploading/'.$aadhar_card.'" alt="Preview" id="img_pre2">';
                                                                    }
                                                                ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row mt-5">
                                                    <div class="col-md-6 col-sm-12">
                                                        <div class="mb-3">
                                                            <label for="file3"><b>PAN CARD</b></label><br/>
                                                        </div>
                                                        <div id="preview3" >
                                                            <div id="image_preview3">
                                                                <?php
                                                                    if($pan_card ==''){
                                                                        echo '<img src="../uploading/not_uploaded.png" alt="Preview" id="img_pre3">';
                                                                    }else{
                                                                        echo '<img src="../uploading/'.$pan_card.'" alt="Preview" id="img_pre3">';
                                                                    }
                                                                ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-sm-12">
                                                        <div class="mb-3">
                                                            <label for="file4"><b>BANK PASSBOOK</b></label><br/>
                                                        </div>
                                                        <div id="preview4" >
                                                            <div id="image_preview4">
                                                                <?php
                                                                    if($bank_passbook ==''){
                                                                        echo '<img src="../uploading/not_uploaded.png" alt="Preview" id="img_pre4">';
                                                                    }else{
                                                                        echo '<img src="../uploading/'.$bank_passbook.'" alt="Preview" id="img_pre4">';
                                                                    }
                                                                ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row mt-5" >
                                                    <div class="col-md-6 col-sm-12">
                                                        <div class="mb-3">
                                                            <label for="file5"><b>VOTING CARD</b></label><br/>
                                                        </div>
                                                        <div id="preview5" >
                                                            <div id="image_preview5">
                                                                <?php
                                                                    if($voting_card ==''){
                                                                        echo '<img src="../uploading/not_uploaded.png" alt="Preview" id="img_pre5">';
                                                                    }else{
                                                                        echo '<img src="../uploading/'.$voting_card.'" alt="Preview" id="img_pre5">';
                                                                    }
                                                                ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php if($DBtable == 'ca_travelagency' || $DBtable == 'corporate_agency'){ ?>
                                                        <div class="col-md-6 col-sm-12">
                                                            <div class="mb-3">
                                                                <label for="file6"><b>PAYMENT PROOF</b></label><br/>
                                                            </div>
                                                            <div id="preview6" >
                                                                <div id="image_preview6">
                                                                    <?php
                                                                        if($payment_proof ==''){
                                                                            echo '<img src="../uploading/not_uploaded.png" alt="Preview" id="img_pre5">';
                                                                        }else{
                                                                            echo '<img src="../uploading/'.$payment_proof.'" alt="Preview" id="img_pre5">';
                                                                        }
                                                                    ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php } ?>
                                                </div>                
                                                <!-- <div>
                                                    <button type="submit" class="btn btn-primary w-md mt-3" id="addBusinessConsultant">Submit</button>
                                                </div> -->
                                            </form>  
                                        </div> <!-- end card-body -->     
                                    </div><!-- ene card --> 
                                    <!-- end row -->
                                </div>
                                <!-- end tab pane -->
                                <div class="tab-pane fade" id="project-activities" role="tabpanel">
                                    <div class="card">
                                        <div class="card-body">
                                            <h5 class="card-title pt-3">Activities</h5>
                                            <div class="acitivity-timeline py-3">
                                                   
                                                <?php
                                                    $sqlquery = "SELECT * FROM `logs` WHERE reference_no = '".$id."' ORDER BY `id` DESC";
                                                    $stmtQuery = $conn -> prepare($sqlquery);
                                                    $stmtQuery -> execute();
                                                    $stmtQuery -> setFetchMode(PDO::FETCH_ASSOC);
                                                    if( $stmtQuery -> rowCount()>0){
                                                        foreach( ($stmtQuery -> fetchAll()) as $key => $row ){

                                                            $rd= new DateTime($row['register_date']);
                                                            $rdate= $rd->format('d-m-Y');
                                                            
                                                            echo '<div class="acitivity-item py-3 d-flex">
                                                                <div class="flex-shrink-0">
                                                                    <img src=" ../uploading/'.$profile_pic.' " alt="" class="avatar-xs rounded-circle acitivity-avatar shadow" />
                                                                </div>
                                                                <div class="flex-grow-1 ms-3">
                                                                    <h4 class="mb-1">'.$row['title'].'</h4>
                                                                    <p class="text-muted mb-2" style="font-size: 14px;">'.$row['message'].'</p>
                                                                    <small class="mb-0 text-muted">'.$rdate.'</small>
                                                                </div>
                                                            </div>';
                                                        }
                                                    }else{
                                                        echo'
                                                            <div class="acitivity-item py-3 d-flex">
                                                                <div class="flex-shrink-0">
                                                                    <img src=" ../../uploading/'.$profile_pic.' " alt="" class="avatar-xs rounded-circle acitivity-avatar shadow" />
                                                                </div>
                                                                <div class="flex-grow-1 ms-3">
                                                                    <h4 class="mb-1"> No Data Found</h4>
                                                                    <p class="text-muted mb-2" style="font-size: 14px;">No Data Found</p>
                                                                    <small class="mb-0 text-muted">No Data Found</small>
                                                                </div>
                                                            </div>
                                                        ';
                                                    }
                                                ?>
                                            </div>
                                        </div>
                                        <!--end card-body-->
                                    </div>
                                    <!--end card-->
                                </div>
                                <!-- end tab pane -->
                                <div class="tab-pane fade" id="project-team" role="tabpanel">
                                
                                    <?php
                                        if($DBtable == 'channel_business_director'){
                                            $stmt = $conn -> prepare(" SELECT * FROM business_consultant WHERE reference_no = ? AND status = '1' ORDER BY business_consultant_id ASC");
                                            $stmt -> execute([$id]);
                                            $referrals = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                            foreach($referrals as $referral){
                                            $bcs_id = $referral['business_consultant_id'];
                                            echo'<div class="team-list list-view-filter">
                                                <button class="accordion">
                                                    <div class="card team-box">
                                                        <div class="card-body px-4">
                                                            <div class="row align-items-center team-row">
                                                                <div class="col-lg-4 col">
                                                                    <div class="team-profile-img">
                                                                        <div class="avatar-lg img-thumbnail rounded-circle shadow">
                                                                            <div class="avatar-title bg-danger-subtle text-danger rounded-circle">
                                                                                <img src="../uploading/'.$referral['profile_pic'].'" alt="" class="img-fluid d-block rounded-circle" />
                                                                            </div>
                                                                        </div>
                                                                        <div class="team-content">
                                                                            <a href="javascript:void(0)" class="d-block">
                                                                                <h5 class="fs-16 mb-1">'.$referral['firstname'].' '.$referral['lastname'].' '.$bcs_id.'</h5>
                                                                            </a>
                                                                            <p class="text-muted mb-0">Business Consultant</p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-2 col">
                                                                    <h5 class="mb-1">Phone No</h5>
                                                                    <p class="text-muted mb-0">'.$referral['contact_no'].'</p>
                                                                </div>
                                                                <div class="col-lg-4 col">
                                                                    <div class="row text-muted text-center">';
                                                                    $countCA = "SELECT COUNT(corporate_agency_id) AS CAcount FROM corporate_agency WHERE reference_no='".$bcs_id."' ";
                                                                    $caCount = $conn -> prepare($countCA);
                                                                    $caCount -> execute();
                                                                    $caCount -> setFetchMode(PDO::FETCH_ASSOC);
                                                                    if( $caCount -> rowCount()>0 ){
                                                                    foreach( ($caCount -> fetchAll()) as $keyCA => $rowCA ){
                                                                        $CACount = $rowCA['CAcount'];
                                                                        echo'<div class="col-6 border-end border-end-dashed">
                                                                            <h5 class="mb-1">'.$CACount.'</h5>
                                                                            <p class="text-muted mb-0">Total Team Member</p>
                                                                        </div>';
                                                                    }
                                                                    }
                                                                    $countPAC = "SELECT COUNT(bc_id) AS PECcount FROM product_payout WHERE bc_id='".$bcs_id."' ";
                                                                    $pecCount = $conn -> prepare($countPAC);
                                                                    $pecCount -> execute();
                                                                    $pecCount -> setFetchMode(PDO::FETCH_ASSOC);
                                                                    if( $pecCount -> rowCount()>0 ){
                                                                    foreach( ($pecCount -> fetchAll()) as $keyPec => $rowPec ){
                                                                        $PecCount = $rowPec['PECcount'];
                                                                        echo'<div class="col-6">
                                                                            <h5 class="mb-1">'.$PecCount.'</h5>
                                                                            <p class="text-muted mb-0">Total Packages</p>
                                                                        </div>';
                                                                    }
                                                                    }
                                                                    echo'</div>
                                                                </div>
                                                                <div class="col-lg-2 col">
                                                                    <div class="text-end">
                                                                        <a class="btn btn-light view-btn" onclick=\'overviewPage("'.$referral["business_consultant_id"]. '","' .$referral["reference_no"]. '","' .$referral["country"]. '","' .$referral["state"]. '","' .$referral["city"]. '","business_consultant")\'>View Profile</a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </button>
                                                <div class="panel">';
                                                $stmt2 = $conn -> prepare(" SELECT * FROM corporate_agency WHERE reference_no = ? AND status = '1' ORDER BY corporate_agency_id ASC");
                                                $stmt2 -> execute([$bcs_id]);
                                                $referrals2 = $stmt2->fetchAll(PDO::FETCH_ASSOC);
                                                foreach($referrals2 as $referral2){
                                                    $cas_id = $referral2['corporate_agency_id'];
                                                    echo'<button class="accordion">
                                                        <div class="card team-box">
                                                            <div class="card-body px-4">
                                                                <div class="row align-items-center team-row">
                                                                    <div class="col-lg-4 col">
                                                                        <div class="team-profile-img">
                                                                            <div class="avatar-lg img-thumbnail rounded-circle shadow">
                                                                                <div class="avatar-title bg-danger-subtle text-danger rounded-circle">
                                                                                    <img src="../uploading/'.$referral2['profile_pic'].'" alt="" class="img-fluid d-block rounded-circle" />
                                                                                </div>
                                                                            </div>
                                                                            <div class="team-content">
                                                                                <a href="javascript:void(0)" class="d-block">
                                                                                    <h5 class="fs-16 mb-1">'.$referral2['firstname'].' '.$referral2['lastname'].' '.$cas_id.'</h5>
                                                                                </a>
                                                                                <p class="text-muted mb-0">Corporate Agency</p>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-2 col">
                                                                        <h5 class="mb-1">Phone No</h5>
                                                                        <p class="text-muted mb-0">'.$referral2['contact_no'].'</p>
                                                                    </div>
                                                                    <div class="col-lg-4 col">
                                                                        <div class="row text-muted text-center">';
                                                                        $countCATA = "SELECT COUNT(ca_travelagency_id) AS CATAcount FROM ca_travelagency WHERE reference_no='".$cas_id."' ";
                                                                        $cataCount = $conn -> prepare($countCATA);
                                                                        $cataCount -> execute();
                                                                        $cataCount -> setFetchMode(PDO::FETCH_ASSOC);
                                                                        if( $cataCount -> rowCount()>0 ){
                                                                        foreach( ($cataCount -> fetchAll()) as $keyCATA => $rowCATA ){
                                                                            $CATACount = $rowCATA['CATAcount'];
                                                                            echo'<div class="col-6 border-end border-end-dashed">
                                                                                <h5 class="mb-1">'.$CATACount.'</h5>
                                                                                <p class="text-muted mb-0">Total Team Member</p>
                                                                            </div>';
                                                                        }
                                                                        }
                                                                        $countPAC = "SELECT COUNT(ca_id) AS PECcount FROM product_payout WHERE ca_id='".$cas_id."' ";
                                                                        $pecCount = $conn -> prepare($countPAC);
                                                                        $pecCount -> execute();
                                                                        $pecCount -> setFetchMode(PDO::FETCH_ASSOC);
                                                                        if( $pecCount -> rowCount()>0 ){
                                                                        foreach( ($pecCount -> fetchAll()) as $keyPec => $rowPec ){
                                                                            $PecCount = $rowPec['PECcount'];
                                                                            echo'<div class="col-6">
                                                                                <h5 class="mb-1">'.$PecCount.'</h5>
                                                                                <p class="text-muted mb-0">Total Packages</p>
                                                                            </div>';
                                                                        }
                                                                        }
                                                                        echo'</div>
                                                                    </div>
                                                                    <div class="col-lg-2 col">
                                                                        <div class="text-end">
                                                                            <a class="btn btn-light view-btn" onclick=\'overviewPage("'.$referral2["corporate_agency_id"]. '","' .$referral2["reference_no"]. '","' .$referral2["country"]. '","' .$referral2["state"]. '","' .$referral2["city"]. '","corporate_agency")\'>View Profile</a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </button>
                                                    <div class="panel">';
                                                    $stmt3 = $conn -> prepare(" SELECT * FROM ca_travelagency WHERE reference_no = ? AND status = '1' ORDER BY ca_travelagency_id ASC");
                                                    $stmt3 -> execute([$cas_id]);
                                                    $referrals3 = $stmt3->fetchAll(PDO::FETCH_ASSOC);
                                                    foreach($referrals3 as $referral3){
                                                        $catas_id = $referral3['ca_travelagency_id'];
                                                        echo'<button class="accordion">
                                                            <div class="card team-box">
                                                                <div class="card-body px-4">
                                                                    <div class="row align-items-center team-row">
                                                                        <div class="col-lg-4 col">
                                                                            <div class="team-profile-img">
                                                                                <div class="avatar-lg img-thumbnail rounded-circle shadow">
                                                                                    <div class="avatar-title bg-danger-subtle text-danger rounded-circle">
                                                                                        <img src="../uploading/'.$referral3['profile_pic'].'" alt="" class="img-fluid d-block rounded-circle" />
                                                                                    </div>
                                                                                </div>
                                                                                <div class="team-content">
                                                                                    <a href="javascript:void(0)" class="d-block">
                                                                                        <h5 class="fs-16 mb-1">'.$referral3['firstname'].' '.$referral3['lastname'].' '.$catas_id.'</h5>
                                                                                    </a>
                                                                                    <p class="text-muted mb-0">Travel Agency</p>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-2 col">
                                                                            <h5 class="mb-1">Phone No</h5>
                                                                            <p class="text-muted mb-0">'.$referral3['contact_no'].'</p>
                                                                        </div>
                                                                        <div class="col-lg-4 col">
                                                                            <div class="row text-muted text-center">';
                                                                            $countCACU = "SELECT COUNT(ca_customer_id) AS CACUcount FROM ca_customer WHERE ta_reference_no='".$catas_id."' ";
                                                                            $cacuCount = $conn -> prepare($countCACU);
                                                                            $cacuCount -> execute();
                                                                            $cacuCount -> setFetchMode(PDO::FETCH_ASSOC);
                                                                            if( $cacuCount -> rowCount()>0 ){
                                                                            foreach( ($cacuCount -> fetchAll()) as $keyCACU => $rowCACU ){
                                                                                $CACUCount = $rowCACU['CACUcount'];
                                                                                echo'<div class="col-6 border-end border-end-dashed">
                                                                                    <h5 class="mb-1">'.$CACUCount.'</h5>
                                                                                    <p class="text-muted mb-0">Total Team Member</p>
                                                                                </div>';
                                                                            }
                                                                            }
                                                                            $countPAC = "SELECT COUNT(ca_ta_id) AS PECcount FROM product_payout WHERE ca_ta_id='".$catas_id."' ";
                                                                            $pecCount = $conn -> prepare($countPAC);
                                                                            $pecCount -> execute();
                                                                            $pecCount -> setFetchMode(PDO::FETCH_ASSOC);
                                                                            if( $pecCount -> rowCount()>0 ){
                                                                            foreach( ($pecCount -> fetchAll()) as $keyPec => $rowPec ){
                                                                                $PecCount = $rowPec['PECcount'];
                                                                                echo'<div class="col-6">
                                                                                    <h5 class="mb-1">'.$PecCount.'</h5>
                                                                                    <p class="text-muted mb-0">Total Packages</p>
                                                                                </div>';
                                                                            }
                                                                            }
                                                                            echo'</div>
                                                                        </div>
                                                                        <div class="col-lg-2 col">
                                                                            <div class="text-end">
                                                                                <a class="btn btn-light view-btn" onclick=\'overviewPage("'.$referral3["ca_travelagency_id"]. '","' .$referral3["reference_no"]. '","' .$referral3["country"]. '","' .$referral3["state"]. '","' .$referral3["city"]. '","ca_travelagency")\'>View Profile</a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </button>
                                                        <div class="panel">';
                                                        $stmt4 = $conn -> prepare(" SELECT * FROM ca_customer WHERE ta_reference_no = ? AND status = '1' ORDER BY ca_customer_id ASC");
                                                        $stmt4 -> execute([$catas_id]);
                                                        $referrals4 = $stmt4->fetchAll(PDO::FETCH_ASSOC);
                                                        foreach($referrals4 as $referral4){
                                                            $cacus_id = $referral4['ca_customer_id'];
                                                            echo'<button class="accordion">
                                                                <div class="card team-box">
                                                                    <div class="card-body px-4">
                                                                        <div class="row align-items-center team-row">
                                                                            <div class="col-lg-4 col">
                                                                                <div class="team-profile-img">
                                                                                    <div class="avatar-lg img-thumbnail rounded-circle shadow">
                                                                                        <div class="avatar-title bg-danger-subtle text-danger rounded-circle">
                                                                                            <img src="../uploading/'.$referral4['profile_pic'].'" alt="" class="img-fluid d-block rounded-circle" />
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="team-content">
                                                                                        <a href="javascript:void(0)" class="d-block">
                                                                                            <h5 class="fs-16 mb-1">'.$referral4['firstname'].' '.$referral4['lastname'].' '.$cacus_id.'</h5>
                                                                                        </a>
                                                                                        <p class="text-muted mb-0">Customer</p>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-lg-2 col">
                                                                                <h5 class="mb-1">Phone No</h5>
                                                                                <p class="text-muted mb-0">'.$referral4['contact_no'].'</p>
                                                                            </div>
                                                                            <div class="col-lg-4 col">
                                                                                <div class="row text-muted text-center">';
                                                                                $countCATACU = "SELECT COUNT(ca_customer_id) AS CATACUcount FROM ca_customer WHERE reference_no='".$cacus_id."' ";
                                                                                $catacuCount = $conn -> prepare($countCATACU);
                                                                                $catacuCount -> execute();
                                                                                $catacuCount -> setFetchMode(PDO::FETCH_ASSOC);
                                                                                if( $catacuCount -> rowCount()>0 ){
                                                                                foreach( ($catacuCount -> fetchAll()) as $keyCATACU => $rowCATACU ){
                                                                                    $CATACUCount = $rowCATACU['CATACUcount'];
                                                                                    echo'<div class="col-6 border-end border-end-dashed">
                                                                                        <h5 class="mb-1">'.$CATACUCount.'</h5>
                                                                                        <p class="text-muted mb-0">Total Team Member</p>
                                                                                    </div>';
                                                                                }
                                                                                }
                                                                                $countPAC = "SELECT COUNT(cu_id) AS PECcount FROM product_payout WHERE cu_id='".$cacus_id."' ";
                                                                                $pecCount = $conn -> prepare($countPAC);
                                                                                $pecCount -> execute();
                                                                                $pecCount -> setFetchMode(PDO::FETCH_ASSOC);
                                                                                if( $pecCount -> rowCount()>0 ){
                                                                                foreach( ($pecCount -> fetchAll()) as $keyPec => $rowPec ){
                                                                                    $PecCount = $rowPec['PECcount'];
                                                                                    echo'<div class="col-6">
                                                                                        <h5 class="mb-1">'.$PecCount.'</h5>
                                                                                        <p class="text-muted mb-0">Total Packages</p>
                                                                                    </div>';
                                                                                }
                                                                                }
                                                                                echo'</div>
                                                                            </div>
                                                                            <div class="col-lg-2 col">
                                                                                <div class="text-end">
                                                                                    <a class="btn btn-light view-btn" onclick=\'overviewPage("'.$referral4["ca_customer_id"]. '","' .$referral4["reference_no"]. '","' .$referral4["country"]. '","' .$referral4["state"]. '","' .$referral4["city"]. '","ca_customer")\'>View Profile</a>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </button>
                                                            <div class="panel">';
                                                            $stmt5 = $conn -> prepare(" SELECT * FROM ca_customer WHERE reference_no = ? AND status = '1' ORDER BY ca_customer_id ASC");
                                                            $stmt5 -> execute([$cacus_id]);
                                                            $referrals5 = $stmt5->fetchAll(PDO::FETCH_ASSOC);
                                                            foreach($referrals5 as $referral5){
                                                                $customer_id = $referral5['ca_customer_id'];
                                                                echo'<button class="accordion">
                                                                    <div class="card team-box">
                                                                        <div class="card-body px-4">
                                                                            <div class="row align-items-center team-row">
                                                                                <div class="col-lg-4 col">
                                                                                    <div class="team-profile-img">
                                                                                        <div class="avatar-lg img-thumbnail rounded-circle shadow">
                                                                                            <div class="avatar-title bg-danger-subtle text-danger rounded-circle">
                                                                                                <img src="../uploading/'.$referral5['profile_pic'].'" alt="" class="img-fluid d-block rounded-circle" />
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="team-content">
                                                                                            <a href="javascript:void(0)" class="d-block">
                                                                                                <h5 class="fs-16 mb-1">'.$referral5['firstname'].' '.$referral5['lastname'].' '.$customer_id.'</h5>
                                                                                            </a>
                                                                                            <p class="text-muted mb-0">Customer</p>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-lg-2 col">
                                                                                    <h5 class="mb-1">Phone No</h5>
                                                                                    <p class="text-muted mb-0">'.$referral5['contact_no'].'</p>
                                                                                </div>
                                                                                <div class="col-lg-4 col">
                                                                                    <div class="row text-muted text-center">';
                                                                                    $countCU = "SELECT COUNT(ca_customer_id) AS CATAcount FROM ca_customer WHERE reference_no='".$customer_id."' ";
                                                                                    $cuCount = $conn -> prepare($countCU);
                                                                                    $cuCount -> execute();
                                                                                    $cuCount -> setFetchMode(PDO::FETCH_ASSOC);
                                                                                    if( $cuCount -> rowCount()>0 ){
                                                                                    foreach( ($cuCount -> fetchAll()) as $keycu => $rowcu ){
                                                                                        $cuCount = $rowcu['CATAcount'];
                                                                                        echo'<div class="col-6 border-end border-end-dashed">
                                                                                            <h5 class="mb-1">'.$cuCount.'</h5>
                                                                                            <p class="text-muted mb-0">Total Team Member</p>
                                                                                        </div>';
                                                                                    }
                                                                                    }
                                                                                    $countPAC = "SELECT COUNT(cu_id) AS PECcount FROM product_payout WHERE cu_id='".$customer_id."' ";
                                                                                    $pecCount = $conn -> prepare($countPAC);
                                                                                    $pecCount -> execute();
                                                                                    $pecCount -> setFetchMode(PDO::FETCH_ASSOC);
                                                                                    if( $pecCount -> rowCount()>0 ){
                                                                                    foreach( ($pecCount -> fetchAll()) as $keyPec => $rowPec ){
                                                                                        $PecCount = $rowPec['PECcount'];
                                                                                        echo'<div class="col-6">
                                                                                            <h5 class="mb-1">'.$PecCount.'</h5>
                                                                                            <p class="text-muted mb-0">Total Packages</p>
                                                                                        </div>';
                                                                                    }
                                                                                    }
                                                                                    echo'</div>
                                                                                </div>
                                                                                <div class="col-lg-2 col">
                                                                                    <div class="text-end">
                                                                                        <a class="btn btn-light view-btn" onclick=\'overviewPage("'.$referral5["ca_customer_id"]. '","' .$referral5["reference_no"]. '","' .$referral5["country"]. '","' .$referral5["state"]. '","' .$referral5["city"]. '","ca_customer")\'>View Profile</a>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </button>
                                                                <div class="panel">';
                                                                $stmt6 = $conn -> prepare(" SELECT * FROM ca_customer WHERE reference_no = ? AND status = '1' ORDER BY ca_customer_id ASC");
                                                                $stmt6 -> execute([$customer_id]);
                                                                $referrals6 = $stmt6->fetchAll(PDO::FETCH_ASSOC);
                                                                foreach($referrals6 as $referral6){
                                                                    $customer_id2 = $referral6['ca_customer_id'];
                                                                    echo'<button class="accordion">
                                                                        <div class="card team-box">
                                                                            <div class="card-body px-4">
                                                                                <div class="row align-items-center team-row">
                                                                                    <div class="col-lg-4 col">
                                                                                        <div class="team-profile-img">
                                                                                            <div class="avatar-lg img-thumbnail rounded-circle shadow">
                                                                                                <div class="avatar-title bg-danger-subtle text-danger rounded-circle">
                                                                                                    <img src="../uploading/'.$referral6['profile_pic'].'" alt="" class="img-fluid d-block rounded-circle" />
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="team-content">
                                                                                                <a href="javascript:void(0)" class="d-block">
                                                                                                    <h5 class="fs-16 mb-1">'.$referral6['firstname'].' '.$referral6['lastname'].' '.$customer_id2.'</h5>
                                                                                                </a>
                                                                                                <p class="text-muted mb-0">Customer</p>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-lg-2 col">
                                                                                        <h5 class="mb-1">Phone No</h5>
                                                                                        <p class="text-muted mb-0">'.$referral6['contact_no'].'</p>
                                                                                    </div>
                                                                                    <div class="col-lg-4 col">
                                                                                        <div class="row text-muted text-center">';
                                                                                        $countCU2 = "SELECT COUNT(ca_customer_id) AS CATAcount FROM ca_customer WHERE reference_no='".$customer_id2."' ";
                                                                                        $cuCount2 = $conn -> prepare($countCU2);
                                                                                        $cuCount2 -> execute();
                                                                                        $cuCount2 -> setFetchMode(PDO::FETCH_ASSOC);
                                                                                        if( $cuCount2 -> rowCount()>0 ){
                                                                                        foreach( ($cuCount2 -> fetchAll()) as $keycu2 => $rowcu2 ){
                                                                                            $cu2Count = $rowcu2['CATAcount'];
                                                                                            echo'<div class="col-6 border-end border-end-dashed">
                                                                                                <h5 class="mb-1">'.$cu2Count.'</h5>
                                                                                                <p class="text-muted mb-0">Total Team Member</p>
                                                                                            </div>';
                                                                                        }
                                                                                        }
                                                                                        $countPAC2 = "SELECT COUNT(cu_id) AS PECcount FROM product_payout WHERE cu_id='".$customer_id2."' ";
                                                                                        $pecCount2 = $conn -> prepare($countPAC2);
                                                                                        $pecCount2 -> execute();
                                                                                        $pecCount2 -> setFetchMode(PDO::FETCH_ASSOC);
                                                                                        if( $pecCount2 -> rowCount()>0 ){
                                                                                        foreach( ($pecCount2 -> fetchAll()) as $keyPec2 => $rowPec2 ){
                                                                                            $PecCount2 = $rowPec2['PECcount'];
                                                                                            echo'<div class="col-6">
                                                                                                <h5 class="mb-1">'.$PecCount2.'</h5>
                                                                                                <p class="text-muted mb-0">Total Packages</p>
                                                                                            </div>';
                                                                                        }
                                                                                        }
                                                                                        echo'</div>
                                                                                    </div>
                                                                                    <div class="col-lg-2 col">
                                                                                        <div class="text-end">
                                                                                            <a class="btn btn-light view-btn" onclick=\'overviewPage("'.$referral6["ca_customer_id"]. '","' .$referral6["reference_no"]. '","' .$referral6["country"]. '","' .$referral6["state"]. '","' .$referral6["city"]. '","ca_customer")\'>View Profile</a>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </button>';
                                                                }
                                                                echo'</div>'; //panel div
                                                            }
                                                            echo'</div>'; //panel div
                                                        }
                                                        echo'</div>'; //panel div
                                                    }
                                                    echo'</div>'; //panel div
                                                }
                                                echo'</div> '; //panel div
                                            echo'</div>'; //Main div
                                            }
                                        }else if($DBtable == 'business_consultant'){
                                            
                                            $stmt2 = $conn -> prepare(" SELECT * FROM corporate_agency WHERE reference_no = ? AND status = '1' ORDER BY corporate_agency_id ASC");
                                            $stmt2 -> execute([$id]);
                                            $referrals2 = $stmt2->fetchAll(PDO::FETCH_ASSOC);
                                            foreach($referrals2 as $referral2){
                                                $cas_id = $referral2['corporate_agency_id'];
                                                echo'<div class="team-list list-view-filter">
                                                    <button class="accordion">
                                                        <div class="card team-box">
                                                            <div class="card-body px-4">
                                                                <div class="row align-items-center team-row">
                                                                    <div class="col-lg-4 col">
                                                                        <div class="team-profile-img">
                                                                            <div class="avatar-lg img-thumbnail rounded-circle shadow">
                                                                                <div class="avatar-title bg-danger-subtle text-danger rounded-circle">
                                                                                    <img src="../uploading/'.$referral2['profile_pic'].'" alt="" class="img-fluid d-block rounded-circle" />
                                                                                </div>
                                                                            </div>
                                                                            <div class="team-content">
                                                                                <a href="javascript:void(0)" class="d-block">
                                                                                    <h5 class="fs-16 mb-1">'.$referral2['firstname'].' '.$referral2['lastname'].' '.$cas_id.'</h5>
                                                                                </a>
                                                                                <p class="text-muted mb-0">Corporate Agency</p>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-2 col">
                                                                        <h5 class="mb-1">Phone No</h5>
                                                                        <p class="text-muted mb-0">'.$referral2['contact_no'].'</p>
                                                                    </div>
                                                                    <div class="col-lg-4 col">
                                                                        <div class="row text-muted text-center">';
                                                                        $countCATA = "SELECT COUNT(ca_travelagency_id) AS CATAcount FROM ca_travelagency WHERE reference_no='".$cas_id."' ";
                                                                        $cataCount = $conn -> prepare($countCATA);
                                                                        $cataCount -> execute();
                                                                        $cataCount -> setFetchMode(PDO::FETCH_ASSOC);
                                                                        if( $cataCount -> rowCount()>0 ){
                                                                        foreach( ($cataCount -> fetchAll()) as $keyCATA => $rowCATA ){
                                                                            $CATACount = $rowCATA['CATAcount'];
                                                                            echo'<div class="col-6 border-end border-end-dashed">
                                                                                <h5 class="mb-1">'.$CATACount.'</h5>
                                                                                <p class="text-muted mb-0">Total Team Member</p>
                                                                            </div>';
                                                                        }
                                                                        }
                                                                        $countPAC = "SELECT COUNT(ca_id) AS PECcount FROM product_payout WHERE ca_id='".$cas_id."' ";
                                                                        $pecCount = $conn -> prepare($countPAC);
                                                                        $pecCount -> execute();
                                                                        $pecCount -> setFetchMode(PDO::FETCH_ASSOC);
                                                                        if( $pecCount -> rowCount()>0 ){
                                                                        foreach( ($pecCount -> fetchAll()) as $keyPec => $rowPec ){
                                                                            $PecCount = $rowPec['PECcount'];
                                                                            echo'<div class="col-6">
                                                                                <h5 class="mb-1">'.$PecCount.'</h5>
                                                                                <p class="text-muted mb-0">Total Packages</p>
                                                                            </div>';
                                                                        }
                                                                        }
                                                                        echo'</div>
                                                                    </div>
                                                                    <div class="col-lg-2 col">
                                                                        <div class="text-end">
                                                                            <a class="btn btn-light view-btn" onclick=\'overviewPage("'.$referral2["corporate_agency_id"]. '","' .$referral2["reference_no"]. '","' .$referral2["country"]. '","' .$referral2["state"]. '","' .$referral2["city"]. '","corporate_agency")\'>View Profile</a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </button>
                                                    <div class="panel">';
                                                    $stmt3 = $conn -> prepare(" SELECT * FROM ca_travelagency WHERE reference_no = ? AND status = '1' ORDER BY ca_travelagency_id ASC");
                                                    $stmt3 -> execute([$cas_id]);
                                                    $referrals3 = $stmt3->fetchAll(PDO::FETCH_ASSOC);
                                                    foreach($referrals3 as $referral3){
                                                        $catas_id = $referral3['ca_travelagency_id'];
                                                        echo'<button class="accordion">
                                                            <div class="card team-box">
                                                                <div class="card-body px-4">
                                                                    <div class="row align-items-center team-row">
                                                                        <div class="col-lg-4 col">
                                                                            <div class="team-profile-img">
                                                                                <div class="avatar-lg img-thumbnail rounded-circle shadow">
                                                                                    <div class="avatar-title bg-danger-subtle text-danger rounded-circle">
                                                                                        <img src="../uploading/'.$referral3['profile_pic'].'" alt="" class="img-fluid d-block rounded-circle" />
                                                                                    </div>
                                                                                </div>
                                                                                <div class="team-content">
                                                                                    <a href="javascript:void(0)" class="d-block">
                                                                                        <h5 class="fs-16 mb-1">'.$referral3['firstname'].' '.$referral3['lastname'].' '.$catas_id.'</h5>
                                                                                    </a>
                                                                                    <p class="text-muted mb-0">Travel Agency</p>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-2 col">
                                                                            <h5 class="mb-1">Phone No</h5>
                                                                            <p class="text-muted mb-0">'.$referral3['contact_no'].'</p>
                                                                        </div>
                                                                        <div class="col-lg-4 col">
                                                                            <div class="row text-muted text-center">';
                                                                            $countCACU = "SELECT COUNT(ca_customer_id) AS CACUcount FROM ca_customer WHERE ta_reference_no='".$catas_id."' ";
                                                                            $cacuCount = $conn -> prepare($countCACU);
                                                                            $cacuCount -> execute();
                                                                            $cacuCount -> setFetchMode(PDO::FETCH_ASSOC);
                                                                            if( $cacuCount -> rowCount()>0 ){
                                                                            foreach( ($cacuCount -> fetchAll()) as $keyCACU => $rowCACU ){
                                                                                $CACUCount = $rowCACU['CACUcount'];
                                                                                echo'<div class="col-6 border-end border-end-dashed">
                                                                                    <h5 class="mb-1">'.$CACUCount.'</h5>
                                                                                    <p class="text-muted mb-0">Total Team Member</p>
                                                                                </div>';
                                                                            }
                                                                            }
                                                                            $countPAC = "SELECT COUNT(ca_ta_id) AS PECcount FROM product_payout WHERE ca_ta_id='".$catas_id."' ";
                                                                            $pecCount = $conn -> prepare($countPAC);
                                                                            $pecCount -> execute();
                                                                            $pecCount -> setFetchMode(PDO::FETCH_ASSOC);
                                                                            if( $pecCount -> rowCount()>0 ){
                                                                            foreach( ($pecCount -> fetchAll()) as $keyPec => $rowPec ){
                                                                                $PecCount = $rowPec['PECcount'];
                                                                                echo'<div class="col-6">
                                                                                    <h5 class="mb-1">'.$PecCount.'</h5>
                                                                                    <p class="text-muted mb-0">Total Packages</p>
                                                                                </div>';
                                                                            }
                                                                            }
                                                                            echo'</div>
                                                                        </div>
                                                                        <div class="col-lg-2 col">
                                                                            <div class="text-end">
                                                                                <a class="btn btn-light view-btn" onclick=\'overviewPage("'.$referral3["ca_travelagency_id"]. '","' .$referral3["reference_no"]. '","' .$referral3["country"]. '","' .$referral3["state"]. '","' .$referral3["city"]. '","ca_travelagency")\'>View Profile</a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </button>
                                                        <div class="panel">';
                                                        $stmt4 = $conn -> prepare(" SELECT * FROM ca_customer WHERE ta_reference_no = ? AND status = '1' ORDER BY ca_customer_id ASC");
                                                        $stmt4 -> execute([$catas_id]);
                                                        $referrals4 = $stmt4->fetchAll(PDO::FETCH_ASSOC);
                                                        foreach($referrals4 as $referral4){
                                                            $cacus_id = $referral4['ca_customer_id'];
                                                            echo'<button class="accordion">
                                                                <div class="card team-box">
                                                                    <div class="card-body px-4">
                                                                        <div class="row align-items-center team-row">
                                                                            <div class="col-lg-4 col">
                                                                                <div class="team-profile-img">
                                                                                    <div class="avatar-lg img-thumbnail rounded-circle shadow">
                                                                                        <div class="avatar-title bg-danger-subtle text-danger rounded-circle">
                                                                                            <img src="../uploading/'.$referral4['profile_pic'].'" alt="" class="img-fluid d-block rounded-circle" />
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="team-content">
                                                                                        <a href="javascript:void(0)" class="d-block">
                                                                                            <h5 class="fs-16 mb-1">'.$referral4['firstname'].' '.$referral4['lastname'].' '.$cacus_id.'</h5>
                                                                                        </a>
                                                                                        <p class="text-muted mb-0">Customer</p>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-lg-2 col">
                                                                                <h5 class="mb-1">Phone No</h5>
                                                                                <p class="text-muted mb-0">'.$referral4['contact_no'].'</p>
                                                                            </div>
                                                                            <div class="col-lg-4 col">
                                                                                <div class="row text-muted text-center">';
                                                                                $countCATACU = "SELECT COUNT(ca_customer_id) AS CATACUcount FROM ca_customer WHERE reference_no='".$cacus_id."' ";
                                                                                $catacuCount = $conn -> prepare($countCATACU);
                                                                                $catacuCount -> execute();
                                                                                $catacuCount -> setFetchMode(PDO::FETCH_ASSOC);
                                                                                if( $catacuCount -> rowCount()>0 ){
                                                                                foreach( ($catacuCount -> fetchAll()) as $keyCATACU => $rowCATACU ){
                                                                                    $CATACUCount = $rowCATACU['CATACUcount'];
                                                                                    echo'<div class="col-6 border-end border-end-dashed">
                                                                                        <h5 class="mb-1">'.$CATACUCount.'</h5>
                                                                                        <p class="text-muted mb-0">Total Team Member</p>
                                                                                    </div>';
                                                                                }
                                                                                }
                                                                                $countPAC = "SELECT COUNT(cu_id) AS PECcount FROM product_payout WHERE cu_id='".$cacus_id."' ";
                                                                                $pecCount = $conn -> prepare($countPAC);
                                                                                $pecCount -> execute();
                                                                                $pecCount -> setFetchMode(PDO::FETCH_ASSOC);
                                                                                if( $pecCount -> rowCount()>0 ){
                                                                                foreach( ($pecCount -> fetchAll()) as $keyPec => $rowPec ){
                                                                                    $PecCount = $rowPec['PECcount'];
                                                                                    echo'<div class="col-6">
                                                                                        <h5 class="mb-1">'.$PecCount.'</h5>
                                                                                        <p class="text-muted mb-0">Total Packages</p>
                                                                                    </div>';
                                                                                }
                                                                                }
                                                                                echo'</div>
                                                                            </div>
                                                                            <div class="col-lg-2 col">
                                                                                <div class="text-end">
                                                                                    <a class="btn btn-light view-btn" onclick=\'overviewPage("'.$referral4["ca_customer_id"]. '","' .$referral4["reference_no"]. '","' .$referral4["country"]. '","' .$referral4["state"]. '","' .$referral4["city"]. '","ca_customer")\'>View Profile</a>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </button>
                                                            <div class="panel">';
                                                            $stmt5 = $conn -> prepare(" SELECT * FROM ca_customer WHERE reference_no = ? AND status = '1' ORDER BY ca_customer_id ASC");
                                                            $stmt5 -> execute([$cacus_id]);
                                                            $referrals5 = $stmt5->fetchAll(PDO::FETCH_ASSOC);
                                                            foreach($referrals5 as $referral5){
                                                                $customer_id = $referral5['ca_customer_id'];
                                                                echo'<button class="accordion">
                                                                    <div class="card team-box">
                                                                        <div class="card-body px-4">
                                                                            <div class="row align-items-center team-row">
                                                                                <div class="col-lg-4 col">
                                                                                    <div class="team-profile-img">
                                                                                        <div class="avatar-lg img-thumbnail rounded-circle shadow">
                                                                                            <div class="avatar-title bg-danger-subtle text-danger rounded-circle">
                                                                                                <img src="../uploading/'.$referral5['profile_pic'].'" alt="" class="img-fluid d-block rounded-circle" />
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="team-content">
                                                                                            <a href="javascript:void(0)" class="d-block">
                                                                                                <h5 class="fs-16 mb-1">'.$referral5['firstname'].' '.$referral5['lastname'].' '.$customer_id.'</h5>
                                                                                            </a>
                                                                                            <p class="text-muted mb-0">Customer</p>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-lg-2 col">
                                                                                    <h5 class="mb-1">Phone No</h5>
                                                                                    <p class="text-muted mb-0">'.$referral5['contact_no'].'</p>
                                                                                </div>
                                                                                <div class="col-lg-4 col">
                                                                                    <div class="row text-muted text-center">';
                                                                                    $countCU = "SELECT COUNT(ca_customer_id) AS CATAcount FROM ca_customer WHERE reference_no='".$customer_id."' ";
                                                                                    $cuCount = $conn -> prepare($countCU);
                                                                                    $cuCount -> execute();
                                                                                    $cuCount -> setFetchMode(PDO::FETCH_ASSOC);
                                                                                    if( $cuCount -> rowCount()>0 ){
                                                                                    foreach( ($cuCount -> fetchAll()) as $keycu => $rowcu ){
                                                                                        $cuCount = $rowcu['CATAcount'];
                                                                                        echo'<div class="col-6 border-end border-end-dashed">
                                                                                            <h5 class="mb-1">'.$cuCount.'</h5>
                                                                                            <p class="text-muted mb-0">Total Team Member</p>
                                                                                        </div>';
                                                                                    }
                                                                                    }
                                                                                    $countPAC = "SELECT COUNT(cu_id) AS PECcount FROM product_payout WHERE cu_id='".$customer_id."' ";
                                                                                    $pecCount = $conn -> prepare($countPAC);
                                                                                    $pecCount -> execute();
                                                                                    $pecCount -> setFetchMode(PDO::FETCH_ASSOC);
                                                                                    if( $pecCount -> rowCount()>0 ){
                                                                                    foreach( ($pecCount -> fetchAll()) as $keyPec => $rowPec ){
                                                                                        $PecCount = $rowPec['PECcount'];
                                                                                        echo'<div class="col-6">
                                                                                            <h5 class="mb-1">'.$PecCount.'</h5>
                                                                                            <p class="text-muted mb-0">Total Packages</p>
                                                                                        </div>';
                                                                                    }
                                                                                    }
                                                                                    echo'</div>
                                                                                </div>
                                                                                <div class="col-lg-2 col">
                                                                                    <div class="text-end">
                                                                                        <a class="btn btn-light view-btn" onclick=\'overviewPage("'.$referral5["ca_customer_id"]. '","' .$referral5["reference_no"]. '","' .$referral5["country"]. '","' .$referral5["state"]. '","' .$referral5["city"]. '","ca_customer")\'>View Profile</a>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </button>
                                                                <div class="panel">';
                                                                $stmt6 = $conn -> prepare(" SELECT * FROM ca_customer WHERE reference_no = ? AND status = '1' ORDER BY ca_customer_id ASC");
                                                                $stmt6 -> execute([$customer_id]);
                                                                $referrals6 = $stmt6->fetchAll(PDO::FETCH_ASSOC);
                                                                foreach($referrals6 as $referral6){
                                                                    $customer_id2 = $referral6['ca_customer_id'];
                                                                    echo'<button class="accordion">
                                                                        <div class="card team-box">
                                                                            <div class="card-body px-4">
                                                                                <div class="row align-items-center team-row">
                                                                                    <div class="col-lg-4 col">
                                                                                        <div class="team-profile-img">
                                                                                            <div class="avatar-lg img-thumbnail rounded-circle shadow">
                                                                                                <div class="avatar-title bg-danger-subtle text-danger rounded-circle">
                                                                                                    <img src="../uploading/'.$referral6['profile_pic'].'" alt="" class="img-fluid d-block rounded-circle" />
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="team-content">
                                                                                                <a href="javascript:void(0)" class="d-block">
                                                                                                    <h5 class="fs-16 mb-1">'.$referral6['firstname'].' '.$referral6['lastname'].' '.$customer_id2.'</h5>
                                                                                                </a>
                                                                                                <p class="text-muted mb-0">Customer</p>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-lg-2 col">
                                                                                        <h5 class="mb-1">Phone No</h5>
                                                                                        <p class="text-muted mb-0">'.$referral6['contact_no'].'</p>
                                                                                    </div>
                                                                                    <div class="col-lg-4 col">
                                                                                        <div class="row text-muted text-center">';
                                                                                        $countCU2 = "SELECT COUNT(ca_customer_id) AS CATAcount FROM ca_customer WHERE reference_no='".$customer_id2."' ";
                                                                                        $cuCount2 = $conn -> prepare($countCU2);
                                                                                        $cuCount2 -> execute();
                                                                                        $cuCount2 -> setFetchMode(PDO::FETCH_ASSOC);
                                                                                        if( $cuCount2 -> rowCount()>0 ){
                                                                                        foreach( ($cuCount2 -> fetchAll()) as $keycu2 => $rowcu2 ){
                                                                                            $cu2Count = $rowcu2['CATAcount'];
                                                                                            echo'<div class="col-6 border-end border-end-dashed">
                                                                                                <h5 class="mb-1">'.$cu2Count.'</h5>
                                                                                                <p class="text-muted mb-0">Total Team Member</p>
                                                                                            </div>';
                                                                                        }
                                                                                        }
                                                                                        $countPAC2 = "SELECT COUNT(cu_id) AS PECcount FROM product_payout WHERE cu_id='".$customer_id2."' ";
                                                                                        $pecCount2 = $conn -> prepare($countPAC2);
                                                                                        $pecCount2 -> execute();
                                                                                        $pecCount2 -> setFetchMode(PDO::FETCH_ASSOC);
                                                                                        if( $pecCount2 -> rowCount()>0 ){
                                                                                        foreach( ($pecCount2 -> fetchAll()) as $keyPec2 => $rowPec2 ){
                                                                                            $PecCount2 = $rowPec2['PECcount'];
                                                                                            echo'<div class="col-6">
                                                                                                <h5 class="mb-1">'.$PecCount2.'</h5>
                                                                                                <p class="text-muted mb-0">Total Packages</p>
                                                                                            </div>';
                                                                                        }
                                                                                        }
                                                                                        echo'</div>
                                                                                    </div>
                                                                                    <div class="col-lg-2 col">
                                                                                        <div class="text-end">
                                                                                            <a class="btn btn-light view-btn" onclick=\'overviewPage("'.$referral6["ca_customer_id"]. '","' .$referral6["reference_no"]. '","' .$referral6["country"]. '","' .$referral6["state"]. '","' .$referral6["city"]. '","ca_customer")\'>View Profile</a>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </button>';
                                                                }
                                                                echo'</div>'; //panel div
                                                            }
                                                            echo'</div>'; //panel div
                                                        }
                                                        echo'</div>'; //panel div
                                                    }
                                                echo'</div>'; //panel div
                                                echo'</div>'; //Main div
                                            }
                                            
                                        }else if($DBtable == 'corporate_agency'){
                                            
                                            $stmt3 = $conn -> prepare(" SELECT * FROM ca_travelagency WHERE reference_no = ? AND status = '1' ORDER BY ca_travelagency_id ASC");
                                            $stmt3 -> execute([$id]);
                                            $referrals3 = $stmt3->fetchAll(PDO::FETCH_ASSOC);
                                            foreach($referrals3 as $referral3){
                                                $catas_id = $referral3['ca_travelagency_id'];
                                                echo'<div class="team-list list-view-filter">
                                                <button class="accordion">
                                                    <div class="card team-box">
                                                        <div class="card-body px-4">
                                                            <div class="row align-items-center team-row">
                                                                <div class="col-lg-4 col">
                                                                    <div class="team-profile-img">
                                                                        <div class="avatar-lg img-thumbnail rounded-circle shadow">
                                                                            <div class="avatar-title bg-danger-subtle text-danger rounded-circle">
                                                                                <img src="../uploading/'.$referral3['profile_pic'].'" alt="" class="img-fluid d-block rounded-circle" />
                                                                            </div>
                                                                        </div>
                                                                        <div class="team-content">
                                                                            <a href="javascript:void(0)" class="d-block">
                                                                                <h5 class="fs-16 mb-1">'.$referral3['firstname'].' '.$referral3['lastname'].' '.$catas_id.'</h5>
                                                                            </a>
                                                                            <p class="text-muted mb-0">Travel Agency</p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-2 col">
                                                                    <h5 class="mb-1">Phone No</h5>
                                                                    <p class="text-muted mb-0">'.$referral3['contact_no'].'</p>
                                                                </div>
                                                                <div class="col-lg-4 col">
                                                                    <div class="row text-muted text-center">';
                                                                    $countCACU = "SELECT COUNT(ca_customer_id) AS CACUcount FROM ca_customer WHERE ta_reference_no='".$catas_id."' ";
                                                                    $cacuCount = $conn -> prepare($countCACU);
                                                                    $cacuCount -> execute();
                                                                    $cacuCount -> setFetchMode(PDO::FETCH_ASSOC);
                                                                    if( $cacuCount -> rowCount()>0 ){
                                                                    foreach( ($cacuCount -> fetchAll()) as $keyCACU => $rowCACU ){
                                                                        $CACUCount = $rowCACU['CACUcount'];
                                                                        echo'<div class="col-6 border-end border-end-dashed">
                                                                            <h5 class="mb-1">'.$CACUCount.'</h5>
                                                                            <p class="text-muted mb-0">Total Team Member</p>
                                                                        </div>';
                                                                    }
                                                                    }
                                                                    $countPAC = "SELECT COUNT(ca_ta_id) AS PECcount FROM product_payout WHERE ca_ta_id='".$catas_id."' ";
                                                                    $pecCount = $conn -> prepare($countPAC);
                                                                    $pecCount -> execute();
                                                                    $pecCount -> setFetchMode(PDO::FETCH_ASSOC);
                                                                    if( $pecCount -> rowCount()>0 ){
                                                                    foreach( ($pecCount -> fetchAll()) as $keyPec => $rowPec ){
                                                                        $PecCount = $rowPec['PECcount'];
                                                                        echo'<div class="col-6">
                                                                            <h5 class="mb-1">'.$PecCount.'</h5>
                                                                            <p class="text-muted mb-0">Total Packages</p>
                                                                        </div>';
                                                                    }
                                                                    }
                                                                    echo'</div>
                                                                </div>
                                                                <div class="col-lg-2 col">
                                                                    <div class="text-end">
                                                                        <a class="btn btn-light view-btn" onclick=\'overviewPage("'.$referral3["ca_travelagency_id"]. '","' .$referral3["reference_no"]. '","' .$referral3["country"]. '","' .$referral3["state"]. '","' .$referral3["city"]. '","ca_travelagency")\'>View Profile</a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </button>
                                                <div class="panel">';
                                                $stmt4 = $conn -> prepare(" SELECT * FROM ca_customer WHERE ta_reference_no = ? AND status = '1' ORDER BY ca_customer_id ASC");
                                                $stmt4 -> execute([$catas_id]);
                                                $referrals4 = $stmt4->fetchAll(PDO::FETCH_ASSOC);
                                                foreach($referrals4 as $referral4){
                                                    $cacus_id = $referral4['ca_customer_id'];
                                                    echo'<button class="accordion">
                                                        <div class="card team-box">
                                                            <div class="card-body px-4">
                                                                <div class="row align-items-center team-row">
                                                                    <div class="col-lg-4 col">
                                                                        <div class="team-profile-img">
                                                                            <div class="avatar-lg img-thumbnail rounded-circle shadow">
                                                                                <div class="avatar-title bg-danger-subtle text-danger rounded-circle">
                                                                                    <img src="../uploading/'.$referral4['profile_pic'].'" alt="" class="img-fluid d-block rounded-circle" />
                                                                                </div>
                                                                            </div>
                                                                            <div class="team-content">
                                                                                <a href="javascript:void(0)" class="d-block">
                                                                                    <h5 class="fs-16 mb-1">'.$referral4['firstname'].' '.$referral4['lastname'].' '.$cacus_id.'</h5>
                                                                                </a>
                                                                                <p class="text-muted mb-0">Customer</p>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-2 col">
                                                                        <h5 class="mb-1">Phone No</h5>
                                                                        <p class="text-muted mb-0">'.$referral4['contact_no'].'</p>
                                                                    </div>
                                                                    <div class="col-lg-4 col">
                                                                        <div class="row text-muted text-center">';
                                                                        $countCATACU = "SELECT COUNT(ca_customer_id) AS CATACUcount FROM ca_customer WHERE reference_no='".$cacus_id."' ";
                                                                        $catacuCount = $conn -> prepare($countCATACU);
                                                                        $catacuCount -> execute();
                                                                        $catacuCount -> setFetchMode(PDO::FETCH_ASSOC);
                                                                        if( $catacuCount -> rowCount()>0 ){
                                                                        foreach( ($catacuCount -> fetchAll()) as $keyCATACU => $rowCATACU ){
                                                                            $CATACUCount = $rowCATACU['CATACUcount'];
                                                                            echo'<div class="col-6 border-end border-end-dashed">
                                                                                <h5 class="mb-1">'.$CATACUCount.'</h5>
                                                                                <p class="text-muted mb-0">Total Team Member</p>
                                                                            </div>';
                                                                        }
                                                                        }
                                                                        $countPAC = "SELECT COUNT(cu_id) AS PECcount FROM product_payout WHERE cu_id='".$cacus_id."' ";
                                                                        $pecCount = $conn -> prepare($countPAC);
                                                                        $pecCount -> execute();
                                                                        $pecCount -> setFetchMode(PDO::FETCH_ASSOC);
                                                                        if( $pecCount -> rowCount()>0 ){
                                                                        foreach( ($pecCount -> fetchAll()) as $keyPec => $rowPec ){
                                                                            $PecCount = $rowPec['PECcount'];
                                                                            echo'<div class="col-6">
                                                                                <h5 class="mb-1">'.$PecCount.'</h5>
                                                                                <p class="text-muted mb-0">Total Packages</p>
                                                                            </div>';
                                                                        }
                                                                        }
                                                                        echo'</div>
                                                                    </div>
                                                                    <div class="col-lg-2 col">
                                                                        <div class="text-end">
                                                                            <a class="btn btn-light view-btn" onclick=\'overviewPage("'.$referral4["ca_customer_id"]. '","' .$referral4["reference_no"]. '","' .$referral4["country"]. '","' .$referral4["state"]. '","' .$referral4["city"]. '","ca_customer")\'>View Profile</a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </button>
                                                    <div class="panel">';
                                                    $stmt5 = $conn -> prepare(" SELECT * FROM ca_customer WHERE reference_no = ? AND status = '1' ORDER BY ca_customer_id ASC");
                                                    $stmt5 -> execute([$cacus_id]);
                                                    $referrals5 = $stmt5->fetchAll(PDO::FETCH_ASSOC);
                                                    foreach($referrals5 as $referral5){
                                                        $customer_id = $referral5['ca_customer_id'];
                                                        echo'<button class="accordion">
                                                            <div class="card team-box">
                                                                <div class="card-body px-4">
                                                                    <div class="row align-items-center team-row">
                                                                        <div class="col-lg-4 col">
                                                                            <div class="team-profile-img">
                                                                                <div class="avatar-lg img-thumbnail rounded-circle shadow">
                                                                                    <div class="avatar-title bg-danger-subtle text-danger rounded-circle">
                                                                                        <img src="../uploading/'.$referral5['profile_pic'].'" alt="" class="img-fluid d-block rounded-circle" />
                                                                                    </div>
                                                                                </div>
                                                                                <div class="team-content">
                                                                                    <a href="javascript:void(0)" class="d-block">
                                                                                        <h5 class="fs-16 mb-1">'.$referral5['firstname'].' '.$referral5['lastname'].' '.$customer_id.'</h5>
                                                                                    </a>
                                                                                    <p class="text-muted mb-0">Customer</p>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-2 col">
                                                                            <h5 class="mb-1">Phone No</h5>
                                                                            <p class="text-muted mb-0">'.$referral5['contact_no'].'</p>
                                                                        </div>
                                                                        <div class="col-lg-4 col">
                                                                            <div class="row text-muted text-center">';
                                                                            $countCU = "SELECT COUNT(ca_customer_id) AS CATAcount FROM ca_customer WHERE reference_no='".$customer_id."' ";
                                                                            $cuCount = $conn -> prepare($countCU);
                                                                            $cuCount -> execute();
                                                                            $cuCount -> setFetchMode(PDO::FETCH_ASSOC);
                                                                            if( $cuCount -> rowCount()>0 ){
                                                                            foreach( ($cuCount -> fetchAll()) as $keycu => $rowcu ){
                                                                                $cuCount = $rowcu['CATAcount'];
                                                                                echo'<div class="col-6 border-end border-end-dashed">
                                                                                    <h5 class="mb-1">'.$cuCount.'</h5>
                                                                                    <p class="text-muted mb-0">Total Team Member</p>
                                                                                </div>';
                                                                            }
                                                                            }
                                                                            $countPAC = "SELECT COUNT(cu_id) AS PECcount FROM product_payout WHERE cu_id='".$customer_id."' ";
                                                                            $pecCount = $conn -> prepare($countPAC);
                                                                            $pecCount -> execute();
                                                                            $pecCount -> setFetchMode(PDO::FETCH_ASSOC);
                                                                            if( $pecCount -> rowCount()>0 ){
                                                                            foreach( ($pecCount -> fetchAll()) as $keyPec => $rowPec ){
                                                                                $PecCount = $rowPec['PECcount'];
                                                                                echo'<div class="col-6">
                                                                                    <h5 class="mb-1">'.$PecCount.'</h5>
                                                                                    <p class="text-muted mb-0">Total Packages</p>
                                                                                </div>';
                                                                            }
                                                                            }
                                                                            echo'</div>
                                                                        </div>
                                                                        <div class="col-lg-2 col">
                                                                            <div class="text-end">
                                                                                <a class="btn btn-light view-btn" onclick=\'overviewPage("'.$referral5["ca_customer_id"]. '","' .$referral5["reference_no"]. '","' .$referral5["country"]. '","' .$referral5["state"]. '","' .$referral5["city"]. '","ca_customer")\'>View Profile</a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </button>
                                                        <div class="panel">';
                                                        $stmt6 = $conn -> prepare(" SELECT * FROM ca_customer WHERE reference_no = ? AND status = '1' ORDER BY ca_customer_id ASC");
                                                        $stmt6 -> execute([$customer_id]);
                                                        $referrals6 = $stmt6->fetchAll(PDO::FETCH_ASSOC);
                                                        foreach($referrals6 as $referral6){
                                                            $customer_id2 = $referral6['ca_customer_id'];
                                                            echo'<button class="accordion">
                                                                <div class="card team-box">
                                                                    <div class="card-body px-4">
                                                                        <div class="row align-items-center team-row">
                                                                            <div class="col-lg-4 col">
                                                                                <div class="team-profile-img">
                                                                                    <div class="avatar-lg img-thumbnail rounded-circle shadow">
                                                                                        <div class="avatar-title bg-danger-subtle text-danger rounded-circle">
                                                                                            <img src="../uploading/'.$referral6['profile_pic'].'" alt="" class="img-fluid d-block rounded-circle" />
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="team-content">
                                                                                        <a href="javascript:void(0)" class="d-block">
                                                                                            <h5 class="fs-16 mb-1">'.$referral6['firstname'].' '.$referral6['lastname'].' '.$customer_id2.'</h5>
                                                                                        </a>
                                                                                        <p class="text-muted mb-0">Customer</p>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-lg-2 col">
                                                                                <h5 class="mb-1">Phone No</h5>
                                                                                <p class="text-muted mb-0">'.$referral6['contact_no'].'</p>
                                                                            </div>
                                                                            <div class="col-lg-4 col">
                                                                                <div class="row text-muted text-center">';
                                                                                $countCU2 = "SELECT COUNT(ca_customer_id) AS CATAcount FROM ca_customer WHERE reference_no='".$customer_id2."' ";
                                                                                $cuCount2 = $conn -> prepare($countCU2);
                                                                                $cuCount2 -> execute();
                                                                                $cuCount2 -> setFetchMode(PDO::FETCH_ASSOC);
                                                                                if( $cuCount2 -> rowCount()>0 ){
                                                                                foreach( ($cuCount2 -> fetchAll()) as $keycu2 => $rowcu2 ){
                                                                                    $cu2Count = $rowcu2['CATAcount'];
                                                                                    echo'<div class="col-6 border-end border-end-dashed">
                                                                                        <h5 class="mb-1">'.$cu2Count.'</h5>
                                                                                        <p class="text-muted mb-0">Total Team Member</p>
                                                                                    </div>';
                                                                                }
                                                                                }
                                                                                $countPAC2 = "SELECT COUNT(cu_id) AS PECcount FROM product_payout WHERE cu_id='".$customer_id2."' ";
                                                                                $pecCount2 = $conn -> prepare($countPAC2);
                                                                                $pecCount2 -> execute();
                                                                                $pecCount2 -> setFetchMode(PDO::FETCH_ASSOC);
                                                                                if( $pecCount2 -> rowCount()>0 ){
                                                                                foreach( ($pecCount2 -> fetchAll()) as $keyPec2 => $rowPec2 ){
                                                                                    $PecCount2 = $rowPec2['PECcount'];
                                                                                    echo'<div class="col-6">
                                                                                        <h5 class="mb-1">'.$PecCount2.'</h5>
                                                                                        <p class="text-muted mb-0">Total Packages</p>
                                                                                    </div>';
                                                                                }
                                                                                }
                                                                                echo'</div>
                                                                            </div>
                                                                            <div class="col-lg-2 col">
                                                                                <div class="text-end">
                                                                                    <a class="btn btn-light view-btn" onclick=\'overviewPage("'.$referral6["ca_customer_id"]. '","' .$referral6["reference_no"]. '","' .$referral6["country"]. '","' .$referral6["state"]. '","' .$referral6["city"]. '","ca_customer")\'>View Profile</a>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </button>';
                                                        }
                                                        echo'</div>'; //panel div
                                                    }
                                                    echo'</div>'; //panel div
                                                }
                                                echo'</div>'; //panel div
                                                echo'</div>'; //Main div
                                            }
                                        
                                        }else if($DBtable == 'ca_travelagency'){

                                            $stmt4 = $conn -> prepare(" SELECT * FROM ca_customer WHERE ta_reference_no = ? AND status = '1' ORDER BY ca_customer_id ASC");
                                            $stmt4 -> execute([$id]);
                                            $referrals4 = $stmt4->fetchAll(PDO::FETCH_ASSOC);
                                            foreach($referrals4 as $referral4){
                                                $cacus_id = $referral4['ca_customer_id'];
                                                echo'<div class="team-list list-view-filter">
                                                <button class="accordion">
                                                    <div class="card team-box">
                                                        <div class="card-body px-4">
                                                            <div class="row align-items-center team-row">
                                                                <div class="col-lg-4 col">
                                                                    <div class="team-profile-img">
                                                                        <div class="avatar-lg img-thumbnail rounded-circle shadow">
                                                                            <div class="avatar-title bg-danger-subtle text-danger rounded-circle">
                                                                                <img src="../uploading/'.$referral4['profile_pic'].'" alt="" class="img-fluid d-block rounded-circle" />
                                                                            </div>
                                                                        </div>
                                                                        <div class="team-content">
                                                                            <a href="javascript:void(0)" class="d-block">
                                                                                <h5 class="fs-16 mb-1">'.$referral4['firstname'].' '.$referral4['lastname'].' '.$cacus_id.'</h5>
                                                                            </a>
                                                                            <p class="text-muted mb-0">Customer</p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-2 col">
                                                                    <h5 class="mb-1">Phone No</h5>
                                                                    <p class="text-muted mb-0">'.$referral4['contact_no'].'</p>
                                                                </div>
                                                                <div class="col-lg-4 col">
                                                                    <div class="row text-muted text-center">';
                                                                    $countCATACU = "SELECT COUNT(ca_customer_id) AS CATACUcount FROM ca_customer WHERE reference_no='".$cacus_id."' ";
                                                                    $catacuCount = $conn -> prepare($countCATACU);
                                                                    $catacuCount -> execute();
                                                                    $catacuCount -> setFetchMode(PDO::FETCH_ASSOC);
                                                                    if( $catacuCount -> rowCount()>0 ){
                                                                    foreach( ($catacuCount -> fetchAll()) as $keyCATACU => $rowCATACU ){
                                                                        $CATACUCount = $rowCATACU['CATACUcount'];
                                                                        echo'<div class="col-6 border-end border-end-dashed">
                                                                            <h5 class="mb-1">'.$CATACUCount.'</h5>
                                                                            <p class="text-muted mb-0">Total Team Member</p>
                                                                        </div>';
                                                                    }
                                                                    }
                                                                    $countPAC = "SELECT COUNT(cu_id) AS PECcount FROM product_payout WHERE cu_id='".$cacus_id."' ";
                                                                    $pecCount = $conn -> prepare($countPAC);
                                                                    $pecCount -> execute();
                                                                    $pecCount -> setFetchMode(PDO::FETCH_ASSOC);
                                                                    if( $pecCount -> rowCount()>0 ){
                                                                    foreach( ($pecCount -> fetchAll()) as $keyPec => $rowPec ){
                                                                        $PecCount = $rowPec['PECcount'];
                                                                        echo'<div class="col-6">
                                                                            <h5 class="mb-1">'.$PecCount.'</h5>
                                                                            <p class="text-muted mb-0">Total Packages</p>
                                                                        </div>';
                                                                    }
                                                                    }
                                                                    echo'</div>
                                                                </div>
                                                                <div class="col-lg-2 col">
                                                                    <div class="text-end">
                                                                        <a class="btn btn-light view-btn" onclick=\'overviewPage("'.$referral4["ca_customer_id"]. '","' .$referral4["reference_no"]. '","' .$referral4["country"]. '","' .$referral4["state"]. '","' .$referral4["city"]. '","ca_customer")\'>View Profile</a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </button>
                                                <div class="panel">';
                                                $stmt5 = $conn -> prepare(" SELECT * FROM ca_customer WHERE reference_no = ? AND status = '1' ORDER BY ca_customer_id ASC");
                                                $stmt5 -> execute([$cacus_id]);
                                                $referrals5 = $stmt5->fetchAll(PDO::FETCH_ASSOC);
                                                foreach($referrals5 as $referral5){
                                                    $customer_id = $referral5['ca_customer_id'];
                                                    echo'<button class="accordion">
                                                        <div class="card team-box">
                                                            <div class="card-body px-4">
                                                                <div class="row align-items-center team-row">
                                                                    <div class="col-lg-4 col">
                                                                        <div class="team-profile-img">
                                                                            <div class="avatar-lg img-thumbnail rounded-circle shadow">
                                                                                <div class="avatar-title bg-danger-subtle text-danger rounded-circle">
                                                                                    <img src="../uploading/'.$referral5['profile_pic'].'" alt="" class="img-fluid d-block rounded-circle" />
                                                                                </div>
                                                                            </div>
                                                                            <div class="team-content">
                                                                                <a href="javascript:void(0)" class="d-block">
                                                                                    <h5 class="fs-16 mb-1">'.$referral5['firstname'].' '.$referral5['lastname'].' '.$customer_id.'</h5>
                                                                                </a>
                                                                                <p class="text-muted mb-0">Customer</p>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-2 col">
                                                                        <h5 class="mb-1">Phone No</h5>
                                                                        <p class="text-muted mb-0">'.$referral5['contact_no'].'</p>
                                                                    </div>
                                                                    <div class="col-lg-4 col">
                                                                        <div class="row text-muted text-center">';
                                                                        $countCU = "SELECT COUNT(ca_customer_id) AS CATAcount FROM ca_customer WHERE reference_no='".$customer_id."' ";
                                                                        $cuCount = $conn -> prepare($countCU);
                                                                        $cuCount -> execute();
                                                                        $cuCount -> setFetchMode(PDO::FETCH_ASSOC);
                                                                        if( $cuCount -> rowCount()>0 ){
                                                                        foreach( ($cuCount -> fetchAll()) as $keycu => $rowcu ){
                                                                            $cuCount = $rowcu['CATAcount'];
                                                                            echo'<div class="col-6 border-end border-end-dashed">
                                                                                <h5 class="mb-1">'.$cuCount.'</h5>
                                                                                <p class="text-muted mb-0">Total Team Member</p>
                                                                            </div>';
                                                                        }
                                                                        }
                                                                        $countPAC = "SELECT COUNT(cu_id) AS PECcount FROM product_payout WHERE cu_id='".$customer_id."' ";
                                                                        $pecCount = $conn -> prepare($countPAC);
                                                                        $pecCount -> execute();
                                                                        $pecCount -> setFetchMode(PDO::FETCH_ASSOC);
                                                                        if( $pecCount -> rowCount()>0 ){
                                                                        foreach( ($pecCount -> fetchAll()) as $keyPec => $rowPec ){
                                                                            $PecCount = $rowPec['PECcount'];
                                                                            echo'<div class="col-6">
                                                                                <h5 class="mb-1">'.$PecCount.'</h5>
                                                                                <p class="text-muted mb-0">Total Packages</p>
                                                                            </div>';
                                                                        }
                                                                        }
                                                                        echo'</div>
                                                                    </div>
                                                                    <div class="col-lg-2 col">
                                                                        <div class="text-end">
                                                                            <a class="btn btn-light view-btn" onclick=\'overviewPage("'.$referral5["ca_customer_id"]. '","' .$referral5["reference_no"]. '","' .$referral5["country"]. '","' .$referral5["state"]. '","' .$referral5["city"]. '","ca_customer")\'>View Profile</a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </button>
                                                    <div class="panel">';
                                                    $stmt6 = $conn -> prepare(" SELECT * FROM ca_customer WHERE reference_no = ? AND status = '1' ORDER BY ca_customer_id ASC");
                                                    $stmt6 -> execute([$customer_id]);
                                                    $referrals6 = $stmt6->fetchAll(PDO::FETCH_ASSOC);
                                                    foreach($referrals6 as $referral6){
                                                        $customer_id2 = $referral6['ca_customer_id'];
                                                        echo'<button class="accordion">
                                                            <div class="card team-box">
                                                                <div class="card-body px-4">
                                                                    <div class="row align-items-center team-row">
                                                                        <div class="col-lg-4 col">
                                                                            <div class="team-profile-img">
                                                                                <div class="avatar-lg img-thumbnail rounded-circle shadow">
                                                                                    <div class="avatar-title bg-danger-subtle text-danger rounded-circle">
                                                                                        <img src="../uploading/'.$referral6['profile_pic'].'" alt="" class="img-fluid d-block rounded-circle" />
                                                                                    </div>
                                                                                </div>
                                                                                <div class="team-content">
                                                                                    <a href="javascript:void(0)" class="d-block">
                                                                                        <h5 class="fs-16 mb-1">'.$referral6['firstname'].' '.$referral6['lastname'].' '.$customer_id2.'</h5>
                                                                                    </a>
                                                                                    <p class="text-muted mb-0">Customer</p>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-2 col">
                                                                            <h5 class="mb-1">Phone No</h5>
                                                                            <p class="text-muted mb-0">'.$referral6['contact_no'].'</p>
                                                                        </div>
                                                                        <div class="col-lg-4 col">
                                                                            <div class="row text-muted text-center">';
                                                                            $countCU2 = "SELECT COUNT(ca_customer_id) AS CATAcount FROM ca_customer WHERE reference_no='".$customer_id2."' ";
                                                                            $cuCount2 = $conn -> prepare($countCU2);
                                                                            $cuCount2 -> execute();
                                                                            $cuCount2 -> setFetchMode(PDO::FETCH_ASSOC);
                                                                            if( $cuCount2 -> rowCount()>0 ){
                                                                            foreach( ($cuCount2 -> fetchAll()) as $keycu2 => $rowcu2 ){
                                                                                $cu2Count = $rowcu2['CATAcount'];
                                                                                echo'<div class="col-6 border-end border-end-dashed">
                                                                                    <h5 class="mb-1">'.$cu2Count.'</h5>
                                                                                    <p class="text-muted mb-0">Total Team Member</p>
                                                                                </div>';
                                                                            }
                                                                            }
                                                                            $countPAC2 = "SELECT COUNT(cu_id) AS PECcount FROM product_payout WHERE cu_id='".$customer_id2."' ";
                                                                            $pecCount2 = $conn -> prepare($countPAC2);
                                                                            $pecCount2 -> execute();
                                                                            $pecCount2 -> setFetchMode(PDO::FETCH_ASSOC);
                                                                            if( $pecCount2 -> rowCount()>0 ){
                                                                            foreach( ($pecCount2 -> fetchAll()) as $keyPec2 => $rowPec2 ){
                                                                                $PecCount2 = $rowPec2['PECcount'];
                                                                                echo'<div class="col-6">
                                                                                    <h5 class="mb-1">'.$PecCount2.'</h5>
                                                                                    <p class="text-muted mb-0">Total Packages</p>
                                                                                </div>';
                                                                            }
                                                                            }
                                                                            echo'</div>
                                                                        </div>
                                                                        <div class="col-lg-2 col">
                                                                            <div class="text-end">
                                                                                <a class="btn btn-light view-btn" onclick=\'overviewPage("'.$referral6["ca_customer_id"]. '","' .$referral6["reference_no"]. '","' .$referral6["country"]. '","' .$referral6["state"]. '","' .$referral6["city"]. '","ca_customer")\'>View Profile</a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </button>';
                                                    }
                                                    echo'</div>'; //panel div
                                                }
                                                echo'</div>'; //panel div
                                                echo'</div>'; //Main div
                                            }
                                                

                                        }else if($DBtable == 'ca_customer'){

                                            $stmt5 = $conn -> prepare(" SELECT * FROM ca_customer WHERE reference_no = ? AND status = '1' ORDER BY ca_customer_id ASC");
                                            $stmt5 -> execute([$id]);
                                            $referrals5 = $stmt5->fetchAll(PDO::FETCH_ASSOC);
                                            foreach($referrals5 as $referral5){
                                                $customer_id = $referral5['ca_customer_id'];
                                                echo'<div class="team-list list-view-filter">
                                                <button class="accordion">
                                                    <div class="card team-box">
                                                        <div class="card-body px-4">
                                                            <div class="row align-items-center team-row">
                                                                <div class="col-lg-4 col">
                                                                    <div class="team-profile-img">
                                                                        <div class="avatar-lg img-thumbnail rounded-circle shadow">
                                                                            <div class="avatar-title bg-danger-subtle text-danger rounded-circle">
                                                                                <img src="../uploading/'.$referral5['profile_pic'].'" alt="" class="img-fluid d-block rounded-circle" />
                                                                            </div>
                                                                        </div>
                                                                        <div class="team-content">
                                                                            <a href="javascript:void(0)" class="d-block">
                                                                                <h5 class="fs-16 mb-1">'.$referral5['firstname'].' '.$referral5['lastname'].' '.$customer_id.'</h5>
                                                                            </a>
                                                                            <p class="text-muted mb-0">Customer</p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-2 col">
                                                                    <h5 class="mb-1">Phone No</h5>
                                                                    <p class="text-muted mb-0">'.$referral5['contact_no'].'</p>
                                                                </div>
                                                                <div class="col-lg-4 col">
                                                                    <div class="row text-muted text-center">';
                                                                    $countCU = "SELECT COUNT(ca_customer_id) AS CATAcount FROM ca_customer WHERE reference_no='".$customer_id."' ";
                                                                    $cuCount = $conn -> prepare($countCU);
                                                                    $cuCount -> execute();
                                                                    $cuCount -> setFetchMode(PDO::FETCH_ASSOC);
                                                                    if( $cuCount -> rowCount()>0 ){
                                                                    foreach( ($cuCount -> fetchAll()) as $keycu => $rowcu ){
                                                                        $cuCount = $rowcu['CATAcount'];
                                                                        echo'<div class="col-6 border-end border-end-dashed">
                                                                            <h5 class="mb-1">'.$cuCount.'</h5>
                                                                            <p class="text-muted mb-0">Total Team Member</p>
                                                                        </div>';
                                                                    }
                                                                    }
                                                                    $countPAC = "SELECT COUNT(cu_id) AS PECcount FROM product_payout WHERE cu_id='".$customer_id."' ";
                                                                    $pecCount = $conn -> prepare($countPAC);
                                                                    $pecCount -> execute();
                                                                    $pecCount -> setFetchMode(PDO::FETCH_ASSOC);
                                                                    if( $pecCount -> rowCount()>0 ){
                                                                    foreach( ($pecCount -> fetchAll()) as $keyPec => $rowPec ){
                                                                        $PecCount = $rowPec['PECcount'];
                                                                        echo'<div class="col-6">
                                                                            <h5 class="mb-1">'.$PecCount.'</h5>
                                                                            <p class="text-muted mb-0">Total Packages</p>
                                                                        </div>';
                                                                    }
                                                                    }
                                                                    echo'</div>
                                                                </div>
                                                                <div class="col-lg-2 col">
                                                                    <div class="text-end">
                                                                        <a class="btn btn-light view-btn" onclick=\'overviewPage("'.$referral5["ca_customer_id"]. '","' .$referral5["reference_no"]. '","' .$referral5["country"]. '","' .$referral5["state"]. '","' .$referral5["city"]. '","ca_customer")\'>View Profile</a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </button>
                                                <div class="panel">';
                                                $stmt6 = $conn -> prepare(" SELECT * FROM ca_customer WHERE reference_no = ? AND status = '1' ORDER BY ca_customer_id ASC");
                                                $stmt6 -> execute([$customer_id]);
                                                $referrals6 = $stmt6->fetchAll(PDO::FETCH_ASSOC);
                                                foreach($referrals6 as $referral6){
                                                    $customer_id2 = $referral6['ca_customer_id'];
                                                    echo'<button class="accordion">
                                                        <div class="card team-box">
                                                            <div class="card-body px-4">
                                                                <div class="row align-items-center team-row">
                                                                    <div class="col-lg-4 col">
                                                                        <div class="team-profile-img">
                                                                            <div class="avatar-lg img-thumbnail rounded-circle shadow">
                                                                                <div class="avatar-title bg-danger-subtle text-danger rounded-circle">
                                                                                    <img src="../uploading/'.$referral6['profile_pic'].'" alt="" class="img-fluid d-block rounded-circle" />
                                                                                </div>
                                                                            </div>
                                                                            <div class="team-content">
                                                                                <a href="javascript:void(0)" class="d-block">
                                                                                    <h5 class="fs-16 mb-1">'.$referral6['firstname'].' '.$referral6['lastname'].' '.$customer_id2.'</h5>
                                                                                </a>
                                                                                <p class="text-muted mb-0">Customer</p>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-2 col">
                                                                        <h5 class="mb-1">Phone No</h5>
                                                                        <p class="text-muted mb-0">'.$referral6['contact_no'].'</p>
                                                                    </div>
                                                                    <div class="col-lg-4 col">
                                                                        <div class="row text-muted text-center">';
                                                                        $countCU2 = "SELECT COUNT(ca_customer_id) AS CATAcount FROM ca_customer WHERE reference_no='".$customer_id2."' ";
                                                                        $cuCount2 = $conn -> prepare($countCU2);
                                                                        $cuCount2 -> execute();
                                                                        $cuCount2 -> setFetchMode(PDO::FETCH_ASSOC);
                                                                        if( $cuCount2 -> rowCount()>0 ){
                                                                        foreach( ($cuCount2 -> fetchAll()) as $keycu2 => $rowcu2 ){
                                                                            $cu2Count = $rowcu2['CATAcount'];
                                                                            echo'<div class="col-6 border-end border-end-dashed">
                                                                                <h5 class="mb-1">'.$cu2Count.'</h5>
                                                                                <p class="text-muted mb-0">Total Team Member</p>
                                                                            </div>';
                                                                        }
                                                                        }
                                                                        $countPAC2 = "SELECT COUNT(cu_id) AS PECcount FROM product_payout WHERE cu_id='".$customer_id2."' ";
                                                                        $pecCount2 = $conn -> prepare($countPAC2);
                                                                        $pecCount2 -> execute();
                                                                        $pecCount2 -> setFetchMode(PDO::FETCH_ASSOC);
                                                                        if( $pecCount2 -> rowCount()>0 ){
                                                                        foreach( ($pecCount2 -> fetchAll()) as $keyPec2 => $rowPec2 ){
                                                                            $PecCount2 = $rowPec2['PECcount'];
                                                                            echo'<div class="col-6">
                                                                                <h5 class="mb-1">'.$PecCount2.'</h5>
                                                                                <p class="text-muted mb-0">Total Packages</p>
                                                                            </div>';
                                                                        }
                                                                        }
                                                                        echo'</div>
                                                                    </div>
                                                                    <div class="col-lg-2 col">
                                                                        <div class="text-end">
                                                                            <a class="btn btn-light view-btn" onclick=\'overviewPage("'.$referral6["ca_customer_id"]. '","' .$referral6["reference_no"]. '","' .$referral6["country"]. '","' .$referral6["state"]. '","' .$referral6["city"]. '","ca_customer")\'>View Profile</a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </button>';
                                                }
                                                echo'</div>'; //panel div
                                                echo'</div>'; //Main div
                                            }

                                        }else{
                                            echo'<div class="row align-items-center team-row mt-5">
                                                    <div class="col-12 ">
                                                        <div class="card team-box p-2">
                                                            <div class="card-body px-4">
                                                                <div class="row align-items-center team-row text-center">
                                                                    <h1> No Team Found</h1>
                                                                </div>
                                                            </div>
                                                        </div>            
                                                    </div>   
                                                </div>';
                                        }
                                    ?>
                                    
                                </div><!-- tab div -->
                                <!-- end tab pane -->

                                <div class="tab-pane fade" id="project-payout" role="tabpanel">   
                                    <div class="team-list list-view-filter">
                                        <div class="statement">
                                            <h2 class="statement-of-transection mb-3"> Payout For <?php echo $designations; ?></h2>
                                        </div>
                                        
                                        <?php
                                            // date, message, amount, status important for to show payout
                                            if($DBtable == 'channel_business_director'){
                                                $sqlUnion = "SELECT 'Channel Business Director' as title, cbd_id, cbd_name, payout_type, user_id, user_name, message, amount,  created_date as date, status FROM `cbd_payout` WHERE cbd_id = '".$id."' ORDER BY date DESC ";

                                            }else if($DBtable == 'business_consultant'){
                                                $sqlUnion ="SELECT 'Contracting' as title, business_consultant, message, comm_amt as amount, created_date as date, status FROM `ca_payout` 
                                                            WHERE business_consultant = '".$id."' UNION 

                                                            SELECT 'Recruitment' as title, business_consultant, message_bc as message, commision_bc as amount, created_date as date, status_bc as status FROM `ca_ta_payout` 
                                                            WHERE business_consultant = '".$id."' UNION 

                                                            SELECT 'Product' as title, bc_id, bc_message as message, bc_amt as amount, created_date as date, bc_status as status FROM `product_payout`
                                                            WHERE bc_id = '".$id."' ORDER BY date DESC ";
                                                        
                                            }else if($DBtable == 'corporate_agency'){
                                                $sqlUnion = "SELECT 'Recruitment' as title, corporate_agency, message_ca as message, commision_ca as amount,  created_date as date , status_ca as status FROM `ca_ta_payout` 
                                                             WHERE corporate_agency = '".$id."' UNION 

                                                             SELECT 'Product' as title, ca_id, ca_message as message, ca_amt as amount, created_date as date, ca_status as status FROM `product_payout` 
                                                             WHERE ca_id = '".$id."' ORDER BY date DESC ";

                                            }else if($DBtable == 'ca_travelagency'){
                                                $sqlUnion = "SELECT 'Product' as title, ca_ta_id, ca_ta_message as message, ca_ta_amt as amount,  created_date as date , ca_ta_status as status FROM `product_payout` 
                                                             WHERE ca_ta_id = '".$id."' ORDER BY date DESC ";

                                            }else if($DBtable == 'ca_customer'){
                                                $sqlUnion = "SELECT 'Product 1' as title, ca_cu1_id, ca_cu1_message as message, ca_cu1_amt as amount,  created_date as date , ca_cu1_status as status FROM `product_payout` 
                                                             WHERE ca_cu1_id = '".$id."' UNION

                                                            SELECT 'Product 2' as title, ca_cu2_id, ca_cu2_message as message, ca_cu2_amt as amount,  created_date as date , ca_cu2_status as status FROM `product_payout` 
                                                            WHERE ca_cu2_id = '".$id."' UNION
                                                            
                                                            SELECT 'Product 3' as title, ca_cu3_id, ca_cu3_message as message, ca_cu3_amt as amount,  created_date as date , ca_cu3_status as status FROM `product_payout` 
                                                            WHERE ca_cu3_id = '".$id."' ORDER BY date DESC";
                                            }
                                           
                                            $stmtUnion = $conn-> prepare($sqlUnion);
                                            $stmtUnion -> execute();
                                            $stmtUnion -> setFetchMode(PDO::FETCH_ASSOC);
                                            if( $stmtUnion-> rowCount()>0 ){
                                                foreach( ($stmtUnion->fetchAll()) as $key => $row ){
                                                    $cd= new DateTime($row['date']);
                                                    $cdate= $cd->format('d-m-Y');

                                                    // replace dot at end of the line with break statement
                                                    $message1 = $row['message'];
                                                    $message1 =  str_replace('.','<br>',$message1); 
                                                    
                                                    $amount = $row['amount'] ;

                                                    if($amount ==  'null'){
                                                        $tds = '0';
                                                        $total = '0';
                                                    }else{
                                                        $tds = $amount * 5 / 100 ;
                                                        $total = $amount - $tds ;
                                                    }
                                                   
                                                    $status = $row['status'] == '2' ? 'Pending' : 'Paid';

                                                    echo'<div class="row align-items-center team-row">
                                                        <div class="col-12 ">
                                                            <div class="card team-box p-2">
                                                                <div class="card-body px-4">
                                                                    <div class="row align-items-center team-row">
                                                                        <div class="col">
                                                                            <div class="team-profile-img">
                                                                                <div class="team-content col-lg-2">
                                                                                    <h5>Date</h5>
                                                                                    <p class="text-muted mb-0">'.$cdate.'</p>
                                                                                </div>
                                                                                <div class="team-content col-lg-9">
                                                                                    <a href="#" class="d-block">
                                                                                        <h5 class="fs-16 mb-1"> '.$row['title'].' Payouts Details</h5>
                                                                                    </a>
                                                                                    <p class="text-muted mb-0">'.$message1.'</p>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-1 col">
                                                                            <h5 class="mb-1">Amount</h5>
                                                                            <p class="text-muted mb-0">'.$amount.'</p>
                                                                        </div>
                                                                        <div class="col-lg-3 col">
                                                                            <div class="row text-muted text-center">
                                                                                <div class="col-6">
                                                                                    <h5 class="mb-1">TDS</h5>
                                                                                    <p class="text-muted mb-0">'.$tds.'</p>
                                                                                </div>
                                                                                <div class="col-6">
                                                                                    <h5 class="mb-1">Total Payable</h5>
                                                                                    <p class="text-muted mb-0">'.$total.'</p>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-1 col">
                                                                            <div class="text-end">
                                                                                <h5 class="mb-1">Status</h5>
                                                                                <p class="text-muted mb-0">'.$status.'</p>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>            
                                                        </div>   
                                                    </div>';
                                                }
                                            }else{
                                                echo '
                                                    <div class="row align-items-center team-row mt-5">
                                                        <div class="col-12 ">
                                                            <div class="card team-box p-2">
                                                                <div class="card-body px-4">
                                                                    <div class="row align-items-center team-row text-center">
                                                                        <h1> No Payouts Found</h1>
                                                                    </div>
                                                                </div>
                                                            </div>            
                                                        </div>   
                                                    </div>
                                                ';
                                            }
                                            
                                        ?>
                                    </div>
                                    <!-- end team list -->
                                </div>
                                <!-- end tab pane -->
                            </div>
                        </div>
                        <!-- end col -->
                    </div>
                    <!-- end row -->
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
    <!-- END layout-wrapper -->

    <!--start back-to-top-->
    <button onclick="topFunction()" class="scrollToTop scroll-btn show btn" id="back-to-top">
        <i class="ri-arrow-up-line"></i>
    </button>
    <!--end back-to-top-->
                                            
    <!--preloader-->
    <!-- <div id="preloader">
        <div id="status">
            <div class="spinner-border text-primary avatar-sm" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
    </div> -->

    <script>
        var acc = document.getElementsByClassName("accordion");
        var i;

        for (i = 0; i < acc.length; i++) {
        acc[i].addEventListener("click", function() {
            this.classList.toggle("active");
            var panel = this.nextElementSibling;
            if (panel.style.display === "block") {
            panel.style.display = "none";
            } else {
            panel.style.display = "block";
            }
        });
        }
    </script>

    <!-- JAVASCRIPT -->
    <script src="assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/libs/simplebar/simplebar.min.js"></script>
    <script src="assets/libs/node-waves/waves.min.js"></script>
    <script src="assets/libs/feather-icons/feather.min.js"></script>
    <script src="assets/js/pages/plugins/lord-icon-2.1.0.js"></script>
    <script src="assets/js/jquery/jquery-3.7.1.min.js"></script>
    
    
    <!-- Required datatable js -->
    <script src="assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
    
    <!-- Responsive examples -->
    <script src="assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>

    <!-- <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script> -->
    <!-- <script src="https://code.jquery.com/jquery-3.7.0.js"></script> -->
    <!-- <script src="assets/js/plugins.js"></script> -->

    <!-- <script src="assets/js/pages/project-overview.init.js"></script> -->

    <!-- App js -->
    <script src="assets/js/app.js"></script>
    <script>
        $(document).ready(function(){
            $("#payoutDetailsTable").DataTable();

            var paymentMode = $(".payment:checked").val();
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

        function overviewPage(id,ref,cut,st,ct,message){
            if(message == 'business_consultant'){
                var designation = 'Business Consultant';
            }else if(message == 'corporate_agency'){
                var designation = 'Corporate Agency';
            }else if(message == 'ca_travelagency'){
                var designation = 'Travel Agency';
            }else if(message == 'ca_customer'){
                var designation = 'Customer';
            }
            window.location.href='overview.php?id='+id+'&ref='+ref+'&cut='+cut+'&st='+st+'&ct='+ct+'&message='+message+'&designation='+designation;
        }
    </script>

    
</body>


</html>