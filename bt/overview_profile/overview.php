<?php

session_start();

if (!isset($_SESSION['username'])) {
    echo '<script>location.href = "../login.php";</script>';
}

require '../connect.php';
$date = date('Y');

$id = $_GET['id'];
$ref = $_GET['ref'];
// $country = $_GET['cut'];
// $state = $_GET['st'];
// $city = $_GET['ct'];
$DBtable = $_GET['message'];
$designation = $_GET['designation'];
// echo $id;
// echo $ref;
// echo $country;
// echo $state;
// echo $city;
// echo $DBtable;
// Pen : BC => 3, CBD => 18.
// App :  EMP => 10, CU => 11, TE => 16, BCM => 24, BDM => 25, BM => 26.
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
$stmt = $conn->prepare($sql);
$stmt->execute();

$stmt->setFetchMode(PDO::FETCH_ASSOC);
$reporting_manager_name = '';
$customer_type='';
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
            $customer_type= $DBtable == 'ca_customer'?$row['customer_type']:'';
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

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Overview</title>
    <!-- App favicon -->
    <link rel="shortcut icon" href="../assets/images/fav.png">
    <!-- custom css file -->
    <!-- <link href="../assets/css/styles.css" rel="stylesheet" type="text/css" /> -->
    <!-- Bootstrap Css -->
    <link href="../assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="../assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="../assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />
    <!-- Css-->
    <link href="../assets/css/loadingScreen.css" id="app-style" rel="stylesheet" type="text/css" />
    <!-- App js -->
    <!-- <script src="assets/js/plugin.js"></script> -->
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Date Range Picker CSS Start -->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <!-- Date Range Picker CSS End -->
    <!-- DataTables -->
    <link href="../assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <!-- Responsive datatable examples -->
    <link href="../assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />

    <style>
        #image_preview1 {
            height: 180px;
            width: 180px;
        }

        #preview1 img {
            width: 180px;
            height: 180px;
        }

        #image_preview2 {
            height: 180px;
            width: 180px;
        }

        #preview2 img {
            width: 180px;
            height: 180px;
        }

        #image_preview3 {
            height: 180px;
            width: 180px;
        }

        #preview3 img {
            width: 180px;
            height: 180px;
        }

        #image_preview4 {
            height: 180px;
            width: 180px;
        }

        #preview4 img {
            width: 180px;
            height: 180px;
        }

        #image_preview5 {
            height: 180px;
            width: 180px;
        }

        #preview5 img {
            width: 180px;
            height: 180px;
        }

        #image_preview6 {
            height: 180px;
            width: 180px;
        }

        #preview6 img {
            width: 180px;
            height: 180px;
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

        .cardHover:hover {
            background-color: #556ee6 !important;
            border-radius: 6px !important;
            /* padding: 4px !important; */
            border: none !important;
        }

        .faIcon {
            padding: 21px 17px 21px 17px !important;
        }

        .faIcon:hover {
            color: #fff !important
        }

        .pera {
            font-size: 10px !important;
            font-weight: 500 !important;
        }

        .dateRange {
            border-radius: 14px !important;
        }

        .peraPadding {
            padding-left: .75rem !important;
        }

        /* Accordion */
        .accordion {
            cursor: pointer;
            width: 100%;
            border: none;
        }

        .panel {
            padding: 0 0 0 15px;
            display: none;
            overflow: hidden;
        }

        @media screen and (min-width: 993px) and (max-width: 1180px) {
            .cardText {
                font-size: 12px !important;
            }

            .cardProPic {
                width: 35px !important;
                height: 35px !important;
            }

            .card-Img1 {
                width: 70px !important;
                height: 55px !important;
            }

        }

        @media screen and (min-width: 768px) and (max-width: 960px) {
            .cardText {
                font-size: 12px !important;
            }

            .cardProPic {
                width: 35px !important;
                height: 35px !important;
            }

            .card-Img1 {
                width: 70px !important;
                height: 55px !important;
            }
        }

        @media screen and (min-width: 320px) and (max-width: 485px) {
            .cardText {
                font-size: 11px !important;
            }

            .cardProPic {
                width: 35px !important;
                height: 35px !important;
            }

            .card-Img1 {
                width: 65px !important;
                height: 50px !important;
            }
        }

        @media only screen and (max-width: 1180px) {
            .rowAlign {
                display: block !important;
            }

            .dateRangeAlign {
                display: flex !important;
                justify-content: left !important;
            }

        }

        /* Activities */
        .borderAlign {
            border-bottom: 2px solid #919191;
            position: absolute;
            left: 141px;
            top: 15px;
            width: 90px;
        }

        .borderAlignLeft {
            border-left: 2px solid #919191 !important;
            width: 89px;
            position: absolute;
            height: 95px;
            left: 140px;
            top: -32px;
            border: none;
        }

        .position {
            position: relative;
        }
    </style>
</head>

<body data-sidebar="dark">
    <div class="layout-wrapper">
        <?php
        // top header logo, hamberger menu, fullscreen icon, profile
        include_once '../header.php';

        // sidebar navigation menu 
        include_once '../sidebar.php';
        ?>
        <div class="layout-wrapper">
            <div class="main-content">
                <div class="page-content">
                    <div class="container-fluid">
                        <div class="card p-3 rounded-4">
                            <div class="row">
                                <div class="col-xl-1 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <!-- <img src="../assets/images/users/avatar-5.jpg" width="75" height="75" alt="" class="rounded-circle"> -->
                                    <?php
                                    if ($profile_pic) {
                                        echo '<img src="../../uploading/' . $profile_pic . '" alt="Preview" class="avatar-md rounded-circle">';
                                    } else {
                                        echo '<img src="../../uploading/not_uploaded.png" alt="Preview" class="avatar-md rounded-circle">';
                                    }
                                    ?>
                                </div>
                                <div class="col-xl-11 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <div class="row mt-3">
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                            <h4><?= $User_name ?><span> <?= $id ?></span></h4>
                                        </div>
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                            <div class="row">
                                                <div class="<?=$customer_type== 'Premium Plus'?'col-xl-3 col-lg-3':'col-xl-4 col-lg-4'?> col-md-12 col-sm-12 col-12 pe-0">
                                                    <p><span><i class="fa-solid fa-user-tie pe-2"></i></span><?= $designation; ?></p>
                                                </div>
                                                <div class="<?=$customer_type== 'Premium Plus'?'col-xl-3 col-lg-3':'col-xl-3 col-lg-3'?> col-md-12 col-sm-12 col-12 px-0">
                                                    <p class="peraPadding"> Create Date: <span class="fw-bold"><?= $rdate; ?></span></p>
                                                </div>
                                                <?php
                                                    if($customer_type){
                                                        if($customer_type == 'Premium Plus'){
                                                ?>
                                                <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12 col-12">
                                                    <p>Wallet Balance: <span class="fw-bold py-1 px-2 rounded-3 bg-success-subtle text-success-emphasis border-success-subtle">&#8377;10000 </span></p>
                                                </div>
                                                <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12 col-12">
                                                    <p>Booking Points: <span class="fw-bold py-1 px-2 rounded-3 bg-success-subtle text-success-emphasis border-success-subtle">&#8377;10000 </span></p>
                                                </div>
                                                <?php
                                                        }else{
                                                ?>
                                                <div class="col-xl-5 col-lg-5 col-md-12 col-sm-12 col-12">
                                                    <p>Wallet Balance: <span class="fw-bold py-1 px-2 rounded-3 bg-success-subtle text-success-emphasis border-success-subtle">&#8377;10000 </span></p>
                                                </div>
                                                <?php
                                                        }
                                                    } else{
                                                ?>
                                                <div class="col-xl-5 col-lg-5 col-md-12 col-sm-12 col-12">
                                                    <p>Commission Earned: <span class="fw-bold py-1 px-2 rounded-3 bg-success-subtle text-success-emphasis border-success-subtle">&#8377; </span></p>
                                                </div>
                                                <?php
                                                    }
                                                ?>
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <nav role="navigation">
                                <ul class="nav nav-underline " role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" data-bs-toggle="tab" role="tab" href="#overview">Overview</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-bs-toggle="tab" role="tab" href="#activities">Activities</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-bs-toggle="tab" role="tab" href="#teams">Team</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-bs-toggle="tab" role="tab" href="#payout">Payout</a>
                                    </li>
                                    <?php 
                                        if($DBtable == 'ca_customer'){
                                    ?>
                                    <li class="nav-item">
                                        <a class="nav-link" data-bs-toggle="tab" role="tab" href="#Coupon">Coupons</a>
                                    </li>
                                    <?php 
                                        } 
                                    ?>
                                </ul>
                            </nav>
                        </div>
                        <div class="tab-content">
                            <!-- Overview Start -->
                            <div class="tab-pane fade show active" id="overview" role="tabpanel">
                                <div class="card rounded-4">
                                    <div class="card-body">
                                        <?php if ($DBtable == 'business_developement_manager' || $DBtable == 'business_chanel_manager') { ?>
                                            <form>
                                                <div class="row">
                                                    <!-- Personal Details -->
                                                    <div class="col-sm-6">
                                                        <div class="input-block mb-3">
                                                            <label class="col-form-label">Full Name: <span class="ms-2"><?php echo $name; ?></span></label>
                                                            <!-- <input class="form-control" type="text" id="fullName" value="<?php echo $name; ?>" readonly> -->
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="input-block mb-3">
                                                            <label class="col-form-label">Date of Birth: <span class="ms-2"><?php echo $date_of_birth; ?></span></label>
                                                            <!-- <input class="form-control" type="date" id="birth_date" value="<?php echo $date_of_birth; ?>" readonly> -->
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6 " style="display: flex; justify-content: space-between; ">
                                                        <div class="input-block mb-3 col-sm-9">
                                                            <label class="col-form-label">Contact Number: <span class="ms-2"><?php echo '+' . $country_code . '' . $contact ?></span></label>
                                                        </div>

                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="input-block mb-3">
                                                            <label class="col-form-label">Email: <span class="ms-2"><?php echo $email; ?></span></label>
                                                            <!-- <input class="form-control" type="email" id="email" value="<?php //echo $email; 
                                                                                                                            ?>" readonly> -->
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="input-block mb-3">
                                                            <label class="col-form-label">Address: <span class="ms-2"><?php echo $address; ?></span></label>
                                                            <!-- <input type="text" class="form-control" id="address" value="<?php //echo $address; 
                                                                                                                                ?>" readonly> -->
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label class="col-form-label">Gender:
                                                                <span class="ms-2">
                                                                    <?php
                                                                    if ($gender == "male") {
                                                                        echo 'Male';
                                                                    } else if ($gender == "female") {
                                                                        echo 'Female';
                                                                    } else if ($gender == "other") {
                                                                        echo 'Other';
                                                                    }
                                                                    ?>
                                                                </span>
                                                            </label>
                                                            <!-- <div class="form-control mt-1">
                                                                    
                                                                    <label class="radio-inline ms-3"><input type="radio" name="gender" class="gender" id="test1" value="male" <?php //if($gender == "male"){ echo "checked"; } 
                                                                                                                                                                                ?> disabled>&nbsp;&nbsp;&nbsp;Male</label>
                                                                    <label class="radio-inline ms-3"><input type="radio" name="gender" class="gender" id="test2" value="female" <?php //if($gender == "female"){ echo "checked"; } 
                                                                                                                                                                                ?> disabled>&nbsp;&nbsp;&nbsp;Female</label>
                                                                    <label class="radio-inline ms-3"><input type="radio" name="gender" class="gender" id="test3" value="others" <?php //if($gender == "others"){ echo "checked"; } 
                                                                                                                                                                                ?> disabled>&nbsp;&nbsp;&nbsp;Other</label>
                                                                </div> -->
                                                        </div>
                                                    </div>

                                                    <!-- Employment Details -->
                                                    <h4 class="my-2">Employment Details</h4>
                                                    <div class="col-sm-6">
                                                        <div class="input-block mb-3">
                                                            <label class="col-form-label">Joining Date: <span class="ms-2"><?php echo $date_of_joining; ?></span></label>
                                                            <!-- <input class="form-control" type="date" id="joining_date" value="<?php //echo $date_of_joining; 
                                                                                                                                    ?>" readonly> -->
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="input-block mb-3">
                                                            <label class="col-form-label">Department: <span class="ms-2"><?= $departmentname ?></span></label>
                                                            <!-- <select class="form-select" id="department">
                                                                    <option value="<?php //echo $department_id;
                                                                                    ?>"><?php //echo $department_name.' (Already Selected)' ; 
                                                                                                                    ?></option>
                                                                    <?php
                                                                    // require '../connect.php';
                                                                    // $sql = "SELECT * FROM `department` WHERE status ='1' ";
                                                                    // $stmt = $conn->prepare($sql);
                                                                    // $stmt -> execute();
                                                                    // $stmt -> setFetchMode(PDO::FETCH_ASSOC);
                                                                    // if($stmt-> rowCount()>0 ){
                                                                    //     foreach( ($stmt -> fetchAll()) as $key => $row ){
                                                                    //         echo'
                                                                    //             <option value="'.$row['id'].'">'.$row['dept_name'].'</option>
                                                                    //         ';
                                                                    //     }
                                                                    // }else{
                                                                    //     echo '<option value="">Department not available</option>'; 
                                                                    // }
                                                                    ?>
                                                                </select> -->
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="input-block mb-3">
                                                            <label class="col-form-label">Designation: <span class="ms-2"><?= $designation ?></span></label>
                                                            <!-- <select class="form-select" id="designation">
                                                                    <option value="<?php //echo $designation_id;
                                                                                    ?>"><?php //echo $designation_name.' (Already Selected)' ; 
                                                                                                                    ?></option>
                                                                    <?php
                                                                    // require '../connect.php';
                                                                    // $sql = "SELECT * FROM `designation` WHERE status ='1' ";
                                                                    // $stmt = $conn->prepare($sql);
                                                                    // $stmt -> execute();
                                                                    // $stmt -> setFetchMode(PDO::FETCH_ASSOC);
                                                                    // if($stmt-> rowCount()>0 ){
                                                                    //     foreach( ($stmt -> fetchAll()) as $key => $row ){
                                                                    //         echo'
                                                                    //             <option value="'.$row['id'].'">'.$row['designation_name'].'</option>
                                                                    //         ';
                                                                    //     }
                                                                    // }else{
                                                                    //     echo '<option value="">Designation not available</option>'; 
                                                                    // }
                                                                    ?>
                                                                </select> -->
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="input-block mb-3">
                                                            <label class="col-form-label">Zone: <span class="ms-2"><?= $zone_name ?></span></label>
                                                            <!-- <select class="form-select" id="zone">
                                                                    <option value="<?php //echo $zone_id;
                                                                                    ?>"><?php //echo $zone_name.' (Already Selected)' ; 
                                                                                                                ?></option>
                                                                    <?php
                                                                    // require '../connect.php';
                                                                    // $sql = "SELECT * FROM `zone` WHERE status ='1' ";
                                                                    // $stmt = $conn->prepare($sql);
                                                                    // $stmt -> execute();
                                                                    // $stmt -> setFetchMode(PDO::FETCH_ASSOC);
                                                                    // if($stmt-> rowCount()>0 ){
                                                                    //     foreach( ($stmt -> fetchAll()) as $key => $row ){
                                                                    //         echo'
                                                                    //             <option value="'.$row['id'].'">'.$row['zone_name'].'</option>
                                                                    //         ';
                                                                    //     }
                                                                    // }else{
                                                                    //     echo '<option value="">Zone not available</option>'; 
                                                                    // }
                                                                    ?>
                                                                </select> -->
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="input-block mb-3">
                                                            <label class="col-form-label">Branch: <span class="ms-2"><?= $branch_name ?></span></label>
                                                            <!-- <select class="form-select" id="branch">
                                                                    <option value="<?php //echo $branch_id; 
                                                                                    ?>"> <?php //echo $branch_name.' (Already Selected)' ; 
                                                                                                                    ?> </option>
                                                                </select> -->
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="input-block mb-3">
                                                            <label class="col-form-label">Reporting Manager: <span class="ms-2"><?= $reporting_manager_name ?></span></label>
                                                            <!-- <select class="form-select" id="reporting_manager">
                                                                    <option value="<?php //echo $reporting_manager_id ; 
                                                                                    ?>"> <?php //echo $reporting_manager_name.' (Already Selected)' ; 
                                                                                                                                ?> </option>
                                                                        <?php
                                                                        // // require '../connect.php';
                                                                        // $sql = "SELECT * FROM `employees` WHERE status ='1' ";
                                                                        // $stmt = $conn->prepare($sql);
                                                                        // $stmt -> execute();
                                                                        // $stmt -> setFetchMode(PDO::FETCH_ASSOC);
                                                                        // if($stmt-> rowCount()>0 ){
                                                                        //     foreach( ($stmt -> fetchAll()) as $key => $row ){
                                                                        //         echo'
                                                                        //             <option value="'.$row['employee_id'].'">'.$row['name'].'</option>
                                                                        //         ';
                                                                        //     }
                                                                        // }else{
                                                                        //     echo '<option value="">Manager not available</option>'; 
                                                                        // }	
                                                                        ?>
                                                                </select> -->
                                                        </div>
                                                    </div>

                                                    <!-- Attachments -->
                                                    <h4 class="mt-2 mb-0">Attachments</h4>
                                                    <div class="col-sm-6">
                                                        <div class="input-block mt-1">
                                                            <label class="col-form-label">
                                                                Profile Picture 
                                                                <a href="<?php echo '../../uploading/' . $profile_pic; ?>" download class="ms-3" title="Download">
                                                                        <i class="fa fa-download fa-1x" aria-hidden="true"></i>
                                                                </a>
                                                            </label>
                                                        </div>
                                                        <input type="hidden" id="img_path1" value="<?php echo $profile_pic; ?>">
                                                        <div id="preview1">
                                                            <div id="image_preview1">
                                                                <?php
                                                                if ($profile_pic == '') {
                                                                    echo '<img src="../../uploading/not_uploaded.png" alt="Preview" id="img_pre1" class="imgSize">';
                                                                } else {
                                                                    echo '<img src="../../uploading/' . $profile_pic . '" alt="Preview" id="img_pre1" class="imgSize">';
                                                                }
                                                                ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="input-block mt-1">
                                                            <label class="col-form-label">
                                                                ID Proof (Aadhaar/PAN/Passport)
                                                                <a href="<?php echo '../../uploading/' . $id_proof; ?>" download class="ms-3" title="Download">
                                                                        <i class="fa fa-download fa-1x" aria-hidden="true"></i>
                                                                </a>
                                                            </label>
                                                        </div>
                                                        <input type="hidden" id="img_path2" value="<?php echo $id_proof; ?>">
                                                        <div id="preview2">
                                                            <div id="image_preview2">
                                                                <?php
                                                                if ($id_proof == '') {
                                                                    echo '<img src="../../uploading/not_uploaded.png" alt="Preview" id="img_pre2" class="imgSize">';
                                                                } else {
                                                                    echo '<img src="../../uploading/' . $id_proof . '" alt="Preview" id="img_pre2" class="imgSize">';
                                                                }
                                                                ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="input-block mt-3">
                                                            <label class="col-form-label">
                                                                Bank Details for Salary Transfer
                                                                <a href="<?php echo '../../uploading/' . $bank_details; ?>" download class="ms-3" title="Download">
                                                                        <i class="fa fa-download fa-1x" aria-hidden="true"></i>
                                                                </a>
                                                            </label>
                                                        </div>
                                                        <input type="hidden" id="img_path3" value="<?php echo $bank_details; ?>">
                                                        <div id="preview3">
                                                            <div id="image_preview3">
                                                                <?php
                                                                if ($bank_details == '') {
                                                                    echo '<img src="../../uploading/not_uploaded.png" alt="Preview" id="img_pre3" class="imgSize">';
                                                                } else {
                                                                    echo '<img src="../../uploading/' . $bank_details . '" alt="Preview" id="img_pre3" class="imgSize">';
                                                                }
                                                                ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        <?php } else { ?>
                                            <form>
                                                <?php if ($DBtable == 'ca_customer') { ?>
                                                    <!-- need to check this condtion donot uncomment this for now -->
                                                    <div class="row">
                                                        <div class="col-md-6 col-sm-12">
                                                            <div class="input-block mb-3">
                                                                <label class="col-form-label" for="user_id_name">TA User Id & Name: <span class="ms-2"><?= $ta_ref_no ?></span></label>
                                                                <!-- <input type="text" class="form-control" id="reference_name" placeholder="Enter User NAme and Id" value="" readonly> -->
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-sm-12">
                                                            <div class="input-block mb-3">
                                                                <label class="col-form-label" for="reference_name">TA Reference Name: <span class="ms-2"></span><?= $ta_name ?></label>
                                                                <!-- <input type="text" class="form-control" id="reference_name" placeholder="No Referance selected for the user" value="  " readonly> -->
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6 col-sm-12">
                                                            <div class="input-block mb-3">
                                                                <label class="col-form-label" for="user_id_name">CU User Id & Name: <span class="ms-2"><?= $reference_no ?></span> </label>
                                                                <!-- <input type="text" class="form-control" id="reference_name" placeholder="Enter User NAme and Id" value=" '.$reference_no.' " readonly> -->
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-sm-12">
                                                            <div class="input-block mb-3">
                                                                <label class="col-form-label" for="reference_name">CU Reference Name: <span class="ms-2"><?= $registrant ?></span> </label>
                                                                <!-- <input type="text" class="form-control" id="reference_name" placeholder="No Referance selected for the user" value=" '.$registrant.' " readonly> -->
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php } else { ?>
                                                    <div class="row">
                                                        <div class="col-md-6 col-sm-12">
                                                            <div class="input-block mb-3">
                                                                <label class="col-form-label" for="user_id_name">User Id & Name: <span class="ms-2"><?= $reference_no ?></span> </label>
                                                                <!-- <input type="text" class="form-control" id="reference_name" placeholder="Enter User NAme and Id" value=" '.$reference_no.' " readonly> -->
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-sm-12">
                                                            <div class="input-block mb-3">
                                                                <label class="col-form-label" for="reference_name">Reference Name: <span class="ms-2"><?= $registrant ?></span> </label>
                                                                <!-- <input type="text" class="form-control" id="reference_name" placeholder="No Referance selected for the user" value=" '.$registrant.' " readonly> -->
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php } ?>
                                                <div class="row">
                                                    <div class="col-md-6 col-sm-12">
                                                        <div class="input-block mb-3">
                                                            <label class="col-form-label" for="firstname">First Name: <span class="ms-2"><?php echo $firstname; ?></span></label>
                                                            <!-- <input type="text" class="form-control" id="firstname" placeholder="Enter First Name" value="<?php echo $firstname; ?>" readonly> -->
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-sm-12">
                                                        <div class="input-block mb-3">
                                                            <label class="col-form-label" for="lastname">Last Name: <span class="ms-2"><?php echo $lastname; ?></span></label>
                                                            <!-- <input type="text" class="form-control" id="lastname" placeholder="Enter Last Name" value="<?php echo $lastname; ?>" readonly> -->
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-6 col-sm-12">
                                                        <div class="input-block mb-3">
                                                            <label class="col-form-label" for="nominee_name">Nominee Name: <span class="ms-2"><?php echo $nominee_name ? $nominee_name : 'No Nominee Added'; ?></span></label>
                                                            <!-- <input type="text" class="form-control" id="nominee_name" placeholder="Enter Nominee First Name" value="<?php echo $nominee_name ? $nominee_name : 'No Nominee Added'; ?>" readonly> -->
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-sm-12">
                                                        <div class="input-block mb-3">
                                                            <label class="col-form-label" for="nominee_relation">Nominee Relation: <span class="ms-2"><?php echo $nominee_relation ? $nominee_relation : 'No Nominee Added'; ?></span></label>
                                                            <!-- <input type="text" class="form-control" id="nominee_relation" placeholder="Enter Nominee Relation" value="<?php echo $nominee_relation ? $nominee_relation : 'No Nominee Added'; ?>" readonly> -->
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-6 col-sm-12">
                                                        <div class="input-block mb-3">
                                                            <label class="col-form-label" for="email">Email address: <span class="ms-2"><?php echo $email; ?></span></label>
                                                            <!-- <input type="email" class="form-control" id="email" placeholder="Enter Email address" value="<?php echo $email; ?>"readonly> -->
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-sm-12">
                                                        <div class="input-block mb-3">
                                                            <label class="col-form-label" for="dob">Date: <span class="ms-2"><?php echo $date_of_birth; ?></span></label>
                                                            <!-- <input type="date" class="form-control" id="dob" placeholder="Enter date" value="<?php echo $date_of_birth; ?>" readonly> -->
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6 col-sm-12">
                                                        <div class="form-group mb-3">
                                                            <label class="col-form-label">Gender:
                                                                <span class="ms-2">
                                                                    <?php
                                                                    if ($gender == "male") {
                                                                        echo 'Male';
                                                                    } else if ($gender == "female") {
                                                                        echo 'female';
                                                                    } else if ($gender == "other") {
                                                                        echo 'Other';
                                                                    }
                                                                    ?>
                                                                </span></label>
                                                            <!-- <div class="form-control mt-1">
                                                                    <label class="radio-inline ms-3"><input type="radio" name="gender" class="gender" id="test1" value="male" <?php //if($gender == "male"){ echo "checked"; } 
                                                                                                                                                                                ?> disabled>&nbsp;&nbsp;&nbsp;Male</label>
                                                                    <label class="radio-inline ms-3"><input type="radio" name="gender" class="gender" id="test2" value="female" <?php //if($gender == "female"){ echo "checked"; } 
                                                                                                                                                                                ?> disabled>&nbsp;&nbsp;&nbsp;Female</label>
                                                                    <label class="radio-inline ms-3"><input type="radio" name="gender" class="gender" id="test3" value="others" <?php //if($gender == "others"){ echo "checked"; } 
                                                                                                                                                                                ?> disabled>&nbsp;&nbsp;&nbsp;Other</label>
                                                                </div> -->
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6 col-sm-12 code-mobile">
                                                        <div class="input-block  col-sm-12">
                                                            <label for="phone">Phone Number: <span class="ms-2">+<?php echo $contact_no; ?></span></label>
                                                            <!-- <input type="number" class="form-control" id="phone" placeholder="Enter Phone Number" value="<?php //echo $contact_no; 
                                                                                                                                                                ?>" readonly> -->
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-6 col-sm-12">
                                                        <div class="input-block mb-3">
                                                            <label for="country">Country: <span class="ms-2"><?php echo $countryname; ?></span></label>
                                                            <!-- <input type="text" class="form-control" id="country" placeholder="Enter country" value="<?php //echo $countryname; 
                                                                                                                                                            ?>" readonly> -->
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-sm-12">
                                                        <div class="input-block mb-3">
                                                            <label for="mystate">State: <span class="ms-2"><?php echo $statename; ?></span></label>
                                                            <!-- <input type="text" class="form-control" id="mystate" placeholder="Enter state" value="<?php //echo $statename; 
                                                                                                                                                        ?>" readonly> -->
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-6 col-sm-12">
                                                        <div class="input-block mb-3">
                                                            <label for="city">City: <span class="ms-2"><?php echo $cityname; ?></span></label>
                                                            <!-- <input type="text" class="form-control" id="city" placeholder="Enter city" value="<?php //echo $cityname; 
                                                                                                                                                    ?>" readonly> -->
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-sm-12">
                                                        <div class="input-block mb-3">
                                                            <label for="pin">Pincode: <span class="ms-2"><?php echo $pincode; ?></span></label>
                                                            <!-- <input type="text" class="form-control" id="pin" placeholder="Pincode" value="<?php //echo $pincode; 
                                                                                                                                                ?>" readonly> -->
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-12 col-sm-12">
                                                        <div class="input-block mb-3">
                                                            <label for="address">Address: <span class="ms-2"><?php echo $address; ?></span></label>
                                                            <!-- <input type="text" class="form-control" id="address" placeholder="Enter First Name" value="<?php //echo $address; 
                                                                                                                                                            ?>" readonly> -->
                                                        </div>
                                                    </div>
                                                </div>

                                                <?php if ($DBtable == 'corporate_agency' || $DBtable == 'ca_travelagency' || $DBtable == 'ca_customer') { ?>
                                                    <div class="row py-3">
                                                        <div class="col-lg-12" id="paymentMode">
                                                            <label>Payment Mode: <span class="ms-2">
                                                                    <?php
                                                                    if ($payment_mode == "cash") {
                                                                        echo 'Cash';
                                                                    } else if ($payment_mode == "cheque") {
                                                                        echo 'Cheque';
                                                                    } else if ($payment_mode == "online") {
                                                                        echo 'UPI/NEFT';
                                                                    } else if ($payment_mode == "FOC") {
                                                                        echo 'Free';
                                                                    }
                                                                    ?>
                                                                </span></label>
                                                            <div class='d-none'>
                                                                <input type="radio" id="cashPayment" class="form-check-input payment" name="payment" value="cash" <?php if ($payment_mode == "cash") {
                                                                                                                                                                        echo 'checked';
                                                                                                                                                                    } ?> disabled>
                                                                <label for="cashPayment">Cash</label>
                                                                <input type="radio" id="chequePayment" class="form-check-input payment ms-2" name="payment" value="cheque" <?php if ($payment_mode == "cheque") {
                                                                                                                                                                                echo 'checked';
                                                                                                                                                                            } ?> disabled>
                                                                <label for="chequePayment">Cheque</label>
                                                                <input type="radio" id="onlinePayment" class="form-check-input payment ms-2" name="payment" value="online" <?php if ($payment_mode == "online") {
                                                                                                                                                                                echo 'checked';
                                                                                                                                                                            } ?> disabled>
                                                                <label for="onlinePayment">UPI/NEFT</label>
                                                            </div>
                                                        </div>

                                                        <div class="col-lg-12 d-none" id="chequeOpt" style="display:flex; justify-content: space-between;">
                                                            <div class="col-lg-3 ">
                                                                <div class="input-block">
                                                                    <label for="chequeNo">Cheque No: <span class="ms-2"><?php echo $cheque_no; ?></span></label>
                                                                    <!-- <input type="text" class="form-control" id="chequeNo" placeholder="Enter Cheque Number" value="<?php echo $cheque_no; ?>" readonly> -->
                                                                </div>
                                                            </div>

                                                            <div class="col-lg-3 ">
                                                                <div class="input-block">
                                                                    <label for="chequeDate">Cheque Date: <span class="ms-2"><?php echo $cheque_date; ?></span></label>
                                                                    <!-- <input type="text" class="form-control" id="chequeDate" placeholder="Enter Date On Cheque" value="<?php echo $cheque_date; ?>" readonly> -->
                                                                </div>
                                                            </div>

                                                            <div class="col-lg-3 ">
                                                                <div class="input-block">
                                                                    <label for="bankName">Bank Name: <span class="ms-2"><?php echo $bank_name; ?></span></label>
                                                                    <!-- <input type="text" class="form-control" id="bankName" placeholder="Enter your Bank Name" value="<?php echo $bank_name; ?>" readonly> -->
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-lg-12 d-none" id="onlineOpt" style="display:flex; justify-content: space-between;">
                                                            <div class="col-lg-8">
                                                                <div class="input-block">
                                                                    <label for="transactionNo">Transaction No: <span class="ms-2"><?php echo $transaction_no; ?></span></label>
                                                                    <!-- <input type="text" class="form-control" id="transactionNo" placeholder="Enter your Transaction No." value="<?php echo $transaction_no; ?>" readonly> -->
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php } ?>

                                                <div class="row mt-3">
                                                    <div class="col-md-6 col-sm-12">
                                                        <div class="mb-0">
                                                            <label for="file1">
                                                                <b>PROFILE</b>
                                                                <a href="<?php echo '../../uploading/' . $profile_pic; ?>" download class="ms-3" title="Download">
                                                                        <i class="fa fa-download fa-1x" aria-hidden="true"></i>
                                                                </a>
                                                            </label><br />
                                                        </div>
                                                        <div id="preview1">
                                                            <div id="image_preview1">
                                                                <?php
                                                                if ($profile_pic == '') {
                                                                    echo '<img src="../../uploading/not_uploaded.png" alt="Preview" id="img_pre1">';
                                                                } else {
                                                                    echo '<img src="../../uploading/' . $profile_pic . '" alt="Preview" id="img_pre1">';
                                                                }
                                                                ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-sm-12 ">
                                                        <div class="mb-0">
                                                            <label for="file2">
                                                                <b>AADHAR CARD</b>
                                                                <a href="<?php echo '../../uploading/' . $aadhar_card; ?>" download class="ms-3" title="Download">
                                                                        <i class="fa fa-download fa-1x" aria-hidden="true"></i>
                                                                </a>
                                                            </label><br />
                                                        </div>
                                                        <div id="preview2">
                                                            <div id="image_preview2">
                                                                <?php
                                                                if ($aadhar_card == '') {
                                                                    echo '<img src="../../uploading/not_uploaded.png" alt="Preview" id="img_pre2">';
                                                                } else {
                                                                    echo '<img src="../../uploading/' . $aadhar_card . '" alt="Preview" id="img_pre2">';
                                                                }
                                                                ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row mt-4">
                                                    <div class="col-md-6 col-sm-12">
                                                        <div class="mb-0">
                                                            <label for="file3">
                                                                <b>PAN CARD</b>
                                                                <a href="<?php echo '../../uploading/' . $pan_card; ?>" download class="ms-3" title="Download">
                                                                        <i class="fa fa-download fa-1x" aria-hidden="true"></i>
                                                                </a>
                                                            </label><br />
                                                        </div>
                                                        <div id="preview3">
                                                            <div id="image_preview3">
                                                                <?php
                                                                if ($pan_card == '') {
                                                                    echo '<img src="../../uploading/not_uploaded.png" alt="Preview" id="img_pre3">';
                                                                } else {
                                                                    echo '<img src="../../uploading/' . $pan_card . '" alt="Preview" id="img_pre3">';
                                                                }
                                                                ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-sm-12">
                                                        <div class="mb-0">
                                                            <label for="file4">
                                                                <b>BANK PASSBOOK</b>
                                                                <a href="<?php echo '../../uploading/' . $bank_passbook; ?>" download class="ms-3" title="Download">
                                                                        <i class="fa fa-download fa-1x" aria-hidden="true"></i>
                                                                </a>
                                                            </label><br />
                                                        </div>
                                                        <div id="preview4">
                                                            <div id="image_preview4">
                                                                <?php
                                                                if ($bank_passbook == '') {
                                                                    echo '<img src="../../uploading/not_uploaded.png" alt="Preview" id="img_pre4">';
                                                                } else {
                                                                    echo '<img src="../../uploading/' . $bank_passbook . '" alt="Preview" id="img_pre4">';
                                                                }
                                                                ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row mt-4 mb-2">
                                                    <div class="col-md-6 col-sm-12">
                                                        <div class="mb-0">
                                                            <label for="file5">
                                                                <b>VOTING CARD</b>
                                                                <a href="<?php echo '../../uploading/' . $voting_card; ?>" download class="ms-3" title="Download">
                                                                        <i class="fa fa-download fa-1x" aria-hidden="true"></i>
                                                                </a>
                                                            </label><br />
                                                        </div>
                                                        <div id="preview5">
                                                            <div id="image_preview5">
                                                                <?php
                                                                if ($voting_card == '') {
                                                                    echo '<img src="../../uploading/not_uploaded.png" alt="Preview" id="img_pre5">';
                                                                } else {
                                                                    echo '<img src="../../uploading/' . $voting_card . '" alt="Preview" id="img_pre5">';
                                                                }
                                                                ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php if ($DBtable == 'corporate_agency' || $DBtable == 'ca_travelagency' || $DBtable == 'ca_customer') { ?>
                                                        <div class="col-md-6 col-sm-12 <?=$payment_proof == 'none'?'d-none':''?>">
                                                            <div class="mb-0">
                                                                <label for="file6">
                                                                    <b>PAYMENT PROOF</b>
                                                                    <?php
                                                                        if ($payment_proof == 'none') {
                                                                    ?>
                                                                    <a href="<?php echo '../../uploading/' . $payment_proof; ?>" download class="ms-3" title="Download">
                                                                        <i class="fa fa-download fa-1x" aria-hidden="true"></i>
                                                                    <?php
                                                                        }
                                                                    ?>
                                                                </a>
                                                                </label><br />
                                                            </div>
                                                            <div id="preview6">
                                                                <div id="image_preview6">
                                                                    <?php
                                                                    if ($payment_proof == 'none') {
                                                                        echo '<img src="../../uploading/not_uploaded.png" alt="Preview" id="img_pre6">';
                                                                    } else {
                                                                        echo '<img src="../../uploading/' . $payment_proof . '" alt="Preview" id="img_pre6">';
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
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                            <!-- Overview End -->

                            <!-- Activities Start -->
                            <div class="tab-pane fade card px-3 rounded-4" id="activities" role="tabpanel">
                               <?php
                                    // Fetch logs where user is either actor or target
                                    $stmt = $conn->prepare("SELECT * FROM `logs` WHERE reference_no = :id ORDER BY `id` DESC");
                                    $stmt->execute(['id' => $id]);
                                    $stmt->setFetchMode(PDO::FETCH_ASSOC);

                                    // Function to determine user type and fetch user name + ID + profile pic
                                    function getUserDetails($conn, $title, $ref_id) {
                                        $table = '';
                                        $condition = '';
                                        $selectField = 'firstname, lastname, profile_pic';
                                        $idField = '';

                                        switch (true) {
                                            case strpos($title, 'Business Mentor') !== false:
                                                $table = 'business_mentor';
                                                $condition = 'reference_no = :ref_id';
                                                $selectField .= ', business_mentor_id';
                                                $idField = 'business_mentor_id';
                                                break;
                                            case strpos($title, 'Travel Consultant') !== false:
                                                $table = 'ca_travelagency';
                                                $condition = 'reference_no = :ref_id';
                                                $selectField .= ', ca_travelagency_id';
                                                $idField = 'ca_travelagency_id';
                                                break;
                                            case strpos($title, 'Customer') !== false:
                                                $table = 'ca_customer';
                                                // Use COALESCE to select either reference_no or ta_reference_no based on which is NOT NULL
                                                $condition = 'COALESCE(reference_no, ta_reference_no) = :ref_id';
                                                $selectField .= ', ca_customer_id';
                                                $idField = 'ca_customer_id';
                                                break;
                                            case strpos($title, 'Business Consultant') !== false:
                                                $table = 'business_consultant';
                                                $condition = 'reference_no = :ref_id';
                                                $selectField .= ', business_consultant_id';
                                                $idField = 'business_consultant_id';
                                                break;
                                            case strpos($title, 'Techno Enterprise') !== false:
                                                $table = 'corporate_agency';
                                                $condition = 'reference_no = :ref_id';
                                                $selectField .= ', corporate_agency_id';
                                                $idField = 'corporate_agency_id';
                                                break;
                                            case strpos($title, 'Business Development Manager') !== false:
                                                $table = 'employees';
                                                $condition = 'reference_no = :ref_id AND user_type = 25';
                                                $selectField = 'name, employee_id, profile_pic';
                                                $idField = 'employee_id';
                                                break;
                                            default:
                                                return ['name' => 'Unknown User', 'profile_pic' => 'not_uploaded.png'];
                                        }

                                        $stmtUser = $conn->prepare("SELECT $selectField FROM $table WHERE $condition");
                                        $stmtUser->execute(['ref_id' => $ref_id]);
                                        $user = $stmtUser->fetch(PDO::FETCH_ASSOC);

                                        if (!$user || !isset($user[$idField])) {
                                            return ['name' => 'Unknown User', 'profile_pic' => 'not_uploaded.png'];
                                        }

                                        // Compose user name
                                        $name = ($table === 'employees')
                                            ? $user['name'] . ' (' . $user[$idField] . ')'
                                            : trim($user['firstname'] . ' ' . $user['lastname']) . ' (' . $user[$idField] . ')';

                                        $profilePic = (!empty($user['profile_pic']) && file_exists("../../uploading/" . $user['profile_pic']))
                                            ? $user['profile_pic']
                                            : 'not_uploaded.png';

                                        return ['name' => $name, 'profile_pic' => $profilePic];
                                    }

                                    // Display logs
                                    if ($stmt->rowCount() > 0) {
                                        foreach ($stmt->fetchAll() as $row) {
                                            $rd = new DateTime($row['register_date']);
                                            $rdate = $rd->format('d-m-Y');

                                            // Get user details
                                            $user = getUserDetails($conn, $row['title'], $row['reference_no']);

                                            echo '<div class="row pt-3">
                                                    <div class="col-md-2">
                                                        <div class="d-flex align-items-center justify-content-center p-3 position">
                                                            <img src="../../uploading/' . htmlspecialchars($user['profile_pic']) . '" width="50" height="50" class="rounded-circle ms-3" />
                                                        </div>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <div class="">
                                                            <div class="card bg-light p-2 mt-2">
                                                                <div class="d-flex justify-content-between">
                                                                    <h4 class="">' . htmlspecialchars($row['title']) . ' - ' . htmlspecialchars($user['name']) . '</h4>
                                                                    <p class="d-inline">' . $rdate . '</p>
                                                                </div>
                                                                <p class="my-0 cardText">' . htmlspecialchars($row['message']) . '</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>';
                                        }
                                    } else {
                                        echo '<div class="row pt-3">
                                                <div class="col-md-2">
                                                    <div class="d-flex align-items-center justify-content-center p-3 position">
                                                        <img src="../../uploading/not_uploaded.png" width="50" height="50" class="rounded-circle ms-3" />
                                                    </div>
                                                </div>
                                                <div class="col-md-9">
                                                    <div class="">
                                                        <div class="card bg-light p-2 mt-2">
                                                            <div class="d-flex justify-content-between">
                                                                <h4 class="">-----</h4>
                                                                <p class="d-inline">--/--/----</p>
                                                            </div>
                                                            <p class="my-0 cardText">No Activities Found</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>';
                                    }
                                ?>

                                <?php
                                    // $stmt = $conn->prepare(" SELECT * FROM `logs` WHERE reference_no = '" . $id . "' ORDER BY `id` DESC ");
                                    // $stmt->execute();
                                    // $stmt->setFetchMode(PDO::FETCH_ASSOC);
                                    // if ($stmt->rowCount() > 0) {
                                    //     foreach (($stmt->fetchAll()) as $key => $row) {
                                    //         $rd = new DateTime($row['register_date']);
                                    //         $rdate = $rd->format('d-m-Y');
                                    //         echo '<div class="row pt-3">
                                    //                     <div class="col-md-2">
                                    //                         <div class="d-flex align-items-center justify-content-center p-3 position">
                                    //                             <img src="../../uploading/' . $profile_pic . '" width="50" height="50" class="rounded-circle ms-3" />
                                    //                         </div>
                                    //                     </div>
                                    //                     <div class="col-md-9">
                                    //                         <div class="">
                                    //                             <div class="card bg-light p-2 mt-2">
                                    //                                 <div class="d-flex justify-content-between">
                                    //                                     <h4 class="">' . $row['title'] . '</h4>
                                    //                                     <p class="d-inline">' . $rdate . '</p>
                                    //                                 </div>
                                    //                                 <p class="my-0 cardText">' . $row['message'] . '</p>
                                    //                             </div>
                                    //                         </div>
                                    //                     </div>
                                    //                 </div>';
                                    //     }
                                    // } else {
                                    //     echo '<div class="row pt-3">
                                    //                     <div class="col-md-2">
                                    //                         <div class="d-flex align-items-center justify-content-center p-3 position">
                                    //                             <img src="../../uploading/not_uploaded.png" width="50" height="50" class="rounded-circle ms-3" />
                                    //                         </div>
                                    //                     </div>
                                    //                     <div class="col-md-9">
                                    //                         <div class="">
                                    //                             <div class="card bg-light p-2 mt-2">
                                    //                                 <div class="d-flex justify-content-between">
                                    //                                     <h4 class="">-----</h4>
                                    //                                     <p class="d-inline">--/--/---- --:--</p>
                                    //                                 </div>
                                    //                                 <p class="my-0 cardText">No Activities Found</p>
                                    //                             </div>
                                    //                         </div>
                                    //                     </div>
                                    //                 </div>';
                                    // }
                                ?>
                                <!-- <div class="row pt-3">
                                        <div class="col-md-2">
                                            <div class="d-flex align-items-center justify-content-center p-3 position">
                                                <img src="../assets/images/users/avatar-12.jpg" width="50" height="50" class="rounded-circle ms-3" />
                                            </div>
                                        </div>
                                        <div class="col-md-9">
                                            <div class="">
                                                <div class="card bg-light p-2 mt-2">
                                                    <div class="d-flex justify-content-between">
                                                        <h4 class="">Booked</h4>
                                                        <p class="d-inline">13/03/2025 03:15</p>
                                                    </div>
                                                    <p class="my-0 cardText"><span class="fw-bold">Savio Vaz</span> has <span class="fw-bold">Booked</span> the package for <span class="fw-bold">kerala 4N 5D</span> with <span class="fw-bold">Package ID: #23435545</span></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row pt-3">
                                        <div class="col-md-2">
                                            <div class="d-flex align-items-center justify-content-center p-3 position">
                                                <img src="../assets/images/users/avatar-5.jpg" width="50" height="50" class="rounded-circle ms-3" />
                                            </div>
                                        </div>
                                        <div class="col-md-9">
                                            <div class="">
                                                <div class="card bg-light p-2 mt-2">
                                                    <div class="d-flex justify-content-between">
                                                        <h4 class="">Booked</h4>
                                                        <p class="d-inline">13/03/2025 03:15</p>
                                                    </div>
                                                    <p class="my-0 cardText"><span class="fw-bold">Savio Vaz</span> has <span class="fw-bold">Booked</span> the package for <span class="fw-bold">kerala 4N 5D</span> with <span class="fw-bold">Package ID: #23435545</span></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div> -->
                            </div>
                            <!-- Activities End -->

                            <!-- Team Start -->
                            <div class="tab-pane fade rounded-4" id="teams" role="tabpanel">
                                <div>
                                    <!-- all bmds -->
                                    <?php
                                    if ($DBtable == 'business_chanel_manager') {
                                        $stmt = $conn->prepare(" SELECT * FROM employees WHERE reporting_manager = '".$id."' 
                                        and user_type=25 AND status = '1' ORDER BY employee_id ASC");
                                        $stmt->execute();
                                        $stmt -> setFetchMode(PDO::FETCH_ASSOC);
                                        if($stmt -> rowCount() ==0){
                                    ?>
                                    <div class="row pt-3">
                                        <div class="col-md-2">
                                            <div class="d-flex align-items-center justify-content-center p-3 position">
                                                <img src="../../uploading/not_uploaded.png" width="50" height="50" class="rounded-circle ms-3" />
                                            </div>
                                        </div>
                                        <div class="col-md-9">
                                            <div class="">
                                                <div class="card bg-light p-2 mt-2">
                                                    <div class="d-flex justify-content-between">
                                                        <h4 class="">-----</h4>
                                                        <p class="d-inline">--/--/----</p>
                                                    </div>
                                                    <p class="my-0 cardText">No Team memebers found</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php        
                                        }else{
                                            $referrals = $stmt->fetchAll();
                                            foreach ($referrals as $referral) { 
                                                $bdms_id = $referral['employee_id'];?>
                                                <button class="accordion p-0">
                                                    <div class="card mb-0 rounded-0">
                                                        <div class="card-body p-2">
                                                            <div class="row align-items-center">
                                                                <div class="col-lg-4 col-md-4 col-sm-12 col-12 py-2">
                                                                    <div class="team-profile-img d-flex align-items-center justify-content-around">
                                                                        <div class="avatar-md img-thumbnail rounded float-start rounded-circle">
                                                                            <img src="../../uploading/<?=$referral['profile_pic']?>" alt="" class="img-fluid d-block rounded-circle" />
                                                                        </div>
                                                                        <div>
                                                                            <a href="#" class="d-block">
                                                                                <h5 class="fs-5 mb-1"><?=$referral['name'].' '.$bdms_id?></h5>
                                                                            </a>
                                                                            <p class="text-muted mb-0">Business Development Manager</p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-4 col-md-4 col-sm-12 col-12 py-2">
                                                                    <div class="row text-center">
                                                                        <div class="col-6 border-end">
                                                                            <?php
                                                                                $countQuery = "SELECT 
                                                                                                (
                                                                                                    SELECT COUNT(business_mentor_id) 
                                                                                                    FROM business_mentor 
                                                                                                    WHERE 
                                                                                                        reference_no = :bdms_id 
                                                                                                        AND status = 1 
                                                                                                        AND business_mentor_id IS NOT NULL 
                                                                                                        AND business_mentor_id != ''
                                                                                                ) AS bmcount,
                                                                                                (
                                                                                                    SELECT COUNT(corporate_agency_id) 
                                                                                                    FROM corporate_agency 
                                                                                                    WHERE 
                                                                                                        reference_no = :bdms_id 
                                                                                                        AND status = 1 
                                                                                                        AND corporate_agency_id IS NOT NULL 
                                                                                                        AND corporate_agency_id != ''
                                                                                                ) AS cacount";
    
                                                                                //$debugQuery = str_replace(':bdms_id', $bdms_id, $countQuery);
                                                                                //echo "<pre>Debug SQL:\n$debugQuery</pre>";  
                                                                                $stmt = $conn->prepare($countQuery);
                                                                                $stmt->bindParam(':bdms_id', $bdms_id, PDO::PARAM_STR);
                                                                                $stmt->execute();
                                                                                
                                                                                if ($stmt->rowCount() > 0) {
                                                                                    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                                                                    //print_r($results); // ✅ This will show the actual result array
    
                                                                                    foreach ($results as $row) {
                                                                                        $BMCount = (int)$row['bmcount'];
                                                                                        $CACount = (int)$row['cacount'];
                                                                                        $total_bdm_mem = $BMCount + $CACount; 
                                                                                        echo "<script>
                                                                                                console.log('total bdm mem count:'+".$total_bdm_mem.");
                                                                                              </script>";
                                                                            ?>    
                                                                            <h5 class="mb-1"><?= $total_bdm_mem ?></h5>
                                                                            <?php   }
                                                                                }
                                                                            ?>
                                                                            <p class="text-muted mb-0">Total Team Member</p>
                                                                        </div>
                                                                        <div class="col-6">
                                                                            <?php
                                                                                $countPAC = "SELECT COUNT(bdm_id) AS PECcount FROM product_payout WHERE bdm_id='".$bdms_id."' ";
                                                                                $pecCount = $conn -> prepare($countPAC);
                                                                                $pecCount -> execute();
                                                                                $pecCount -> setFetchMode(PDO::FETCH_ASSOC);
                                                                                if( $pecCount -> rowCount()>0 ){
                                                                                    foreach( ($pecCount -> fetchAll()) as $keyPec => $rowPec ){
                                                                                        $PecCount = $rowPec['PECcount'];
                                                                            ?>
                                                                            <h5 class="mb-1"><?=$PecCount?></h5>
                                                                            <?php   }
                                                                                }
                                                                            ?>
                                                                            <p class="text-muted mb-0">Total Packages</p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-2 col-md-2 col-sm-6 col-6 py-2">
                                                                    <h5 class="mb-1">Phone No</h5>
                                                                    <p class="text-muted mb-0"><?= $referral['contact']?></p>
                                                                </div>
                                                                <div class="col-lg-2 col-md-2 col-sm-6 col-6 py-2">
                                                                    <div class="text-center">
                                                                        <a href="#" onclick="overviewPage('<?= $referral['employee_id'] . ','.' ,'.' ,'.' ,' . $referral['reporting_manager'] . ',business_development_manager' ?>')" class="btn btn-primary view-btn">View Profile</a>
    
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </button>
                                                <!-- all BM and TE  -->
                                                <div class="panel">
                                                    <?php
                                                        $stmt2 = $conn -> prepare(" SELECT * FROM business_mentor WHERE reference_no = ? AND status = '1' ORDER BY business_mentor_id ASC");
                                                        $stmt2 -> execute([$bdms_id]);
                                                        $referrals2 = $stmt2->fetchAll(PDO::FETCH_ASSOC);
                                                        foreach($referrals2 as $referral2){
                                                            $bms_id = $referral2['business_mentor_id']; 
                                                    ?>
                                                    <button class="accordion p-0">
                                                        <div class="card mb-0 rounded-0">
                                                            <div class="card-body p-2">
                                                                <div class="row align-items-center">
                                                                    <div class="col-lg-4 col-md-4 col-sm-12 col-12 py-2">
                                                                        <div class="team-profile-img d-flex align-items-center justify-content-around">
                                                                            <div class="avatar-md img-thumbnail rounded float-start rounded-circle">
                                                                                <img src="../../uploading/<?=$referral2['profile_pic']?>" alt="" class="img-fluid d-block rounded-circle" />
                                                                            </div>
                                                                            <div>
                                                                                <a href="#" class="d-block">
                                                                                    <h5 class="fs-5 mb-1"><?=$referral2['firstname'].' '.$referral2['lastname'].' '.$bms_id?></h5>
                                                                                </a>
                                                                                <p class="text-muted mb-0">Business Mentor</p>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-4 col-md-4 col-sm-12 col-12 py-2">
                                                                        <div class="row text-center">
                                                                            <div class="col-6 border-end">
                                                                                <?php
                                                                                    $countQuery1 = "SELECT 
                                                                                                    (
                                                                                                        SELECT COUNT(ca_travelagency_id) 
                                                                                                        FROM ca_travelagency 
                                                                                                        WHERE 
                                                                                                            reference_no = :bms_id 
                                                                                                            AND status = 1 
                                                                                                            AND ca_travelagency_id IS NOT NULL 
                                                                                                            AND ca_travelagency_id != ''
                                                                                                    ) AS tacount,
                                                                                                    (
                                                                                                        SELECT COUNT(corporate_agency_id) 
                                                                                                        FROM corporate_agency 
                                                                                                        WHERE 
                                                                                                            reference_no = :bms_id 
                                                                                                            AND status = 1 
                                                                                                            AND corporate_agency_id IS NOT NULL 
                                                                                                            AND corporate_agency_id != ''
                                                                                                    ) AS cacount";
    
                                                                                    //$debugQuery = str_replace(':bdms_id', $bdms_id, $countQuery);
                                                                                    //echo "<pre>Debug SQL:\n$debugQuery</pre>";  
                                                                                    $stmt1_1 = $conn->prepare($countQuery1);
                                                                                    $stmt1_1->bindParam(':bms_id', $bms_id, PDO::PARAM_STR);
                                                                                    $stmt1_1->execute();
                                                                                    
                                                                                    if ($stmt1_1->rowCount() > 0) {
                                                                                        $results1_1 = $stmt1_1->fetchAll(PDO::FETCH_ASSOC);
                                                                                        //print_r($results1_1); // ✅ This will show the actual result array
    
                                                                                        foreach ($results1_1 as $row) {
                                                                                            $TACount = (int)$row['tacount'];
                                                                                            $CACount = (int)$row['cacount'];
                                                                                            $total_bm_mem = $TACount + $CACount; 
                                                                                            echo "<script>
                                                                                                    console.log('total bm mem count:".$total_bm_mem." of ".$bms_id."');
                                                                                                </script>";
                                                                                
                                                                                ?>
                                                                                <h5 class="mb-1"><?=$total_bm_mem?></h5>
                                                                                <?php
                                                                                        }
                                                                                    }
                                                                                ?>
                                                                                <p class="text-muted mb-0">Total Team Member</p>
                                                                            </div>
                                                                            <div class="col-6">
                                                                                <?php
                                                                                    $countPAC1 = "SELECT COUNT(bdm_id) AS PECcount FROM product_payout WHERE bm_id='".$bdms_id."' ";
                                                                                    $pecCount1 = $conn -> prepare($countPAC1);
                                                                                    $pecCount1 -> execute();
                                                                                    $pecCount1 -> setFetchMode(PDO::FETCH_ASSOC);
                                                                                    if( $pecCount1 -> rowCount()>0 ){
                                                                                        foreach( ($pecCount1 -> fetchAll()) as $keyPec => $rowPec ){
                                                                                            $PecCount1 = $rowPec['PECcount'];
                                                                                ?>
                                                                                <h5 class="mb-1"><?=$PecCount1?></h5>
                                                                                <?php
                                                                                        }
                                                                                    }
                                                                                ?>
                                                                                <p class="text-muted mb-0">Total Packages</p>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-2 col-md-2 col-sm-6 col-6 py-2">
                                                                        <h5 class="mb-1">Phone No</h5>
                                                                        <p class="text-muted mb-0"><?=$referral2['contact_no']?></p>
                                                                    </div>
                                                                    <div class="col-lg-2 col-md-2 col-sm-6 col-6 py-2">
                                                                        <div class="text-center">
                                                                            <a href="#" onclick="overviewPage('<?= $referral2['business_mentor_id'] .  $referral2['reference_no'] . ',' .$referral2['country']. ',' .$referral2['state']. ',' .$referral2['city']. ',business_mentor' ?>')" class="btn btn-primary view-btn">View Profile</a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </button>
                                                    <!-- all TE under given BM -->
                                                    <div class="panel">
                                                        <?php
                                                            $stmt2_3 = $conn -> prepare(" SELECT * FROM corporate_agency WHERE reference_no = ? AND status = '1' ORDER BY corporate_agency_id ASC");
                                                            $stmt2_3 -> execute([$bms_id]);
                                                            $referrals2_3 = $stmt2_3->fetchAll(PDO::FETCH_ASSOC);
                                                            foreach($referrals2_3 as $referral2){
                                                                $cas_id = $referral2['corporate_agency_id'];
                                                        ?>
                                                        <button class="accordion p-0">
                                                            <div class="card mb-0 rounded-0">
                                                                <div class="card-body p-2">
                                                                    <div class="row align-items-center">
                                                                        <div class="col-lg-4 col-md-4 col-sm-12 col-12 py-2">
                                                                            <div class="team-profile-img d-flex align-items-center justify-content-around">
                                                                                <div class="avatar-md img-thumbnail rounded float-start rounded-circle">
                                                                                    <img src="../../uploading/<?=$referral2['profile_pic']?>" alt="" class="img-fluid d-block rounded-circle" />
                                                                                </div>
                                                                                <div>
                                                                                    <a href="#" class="d-block">
                                                                                        <h5 class="fs-5 mb-1"><?=$referral2['firstname'].' '.$referral2['lastname'].' '.$cas_id?></h5>
                                                                                    </a>
                                                                                    <p class="text-muted mb-0">Techno Enterprise</p>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-4 col-md-4 col-sm-12 col-12 py-2">
                                                                            <div class="row text-center">
                                                                                <div class="col-6 border-end">
                                                                                    <?php
                                                                                        $countCATA2_3 = "SELECT COUNT(ca_travelagency_id) AS CATAcount FROM ca_travelagency WHERE reference_no='".$cas_id."' ";
                                                                                        $cataCount2_3 = $conn -> prepare($countCATA2_3);
                                                                                        $cataCount2_3 -> execute();
                                                                                        $cataCount2_3 -> setFetchMode(PDO::FETCH_ASSOC);
                                                                                        if( $cataCount2_3 -> rowCount()>0 ){
                                                                                            foreach( ($cataCount2_3 -> fetchAll()) as $keyCATA => $rowCATA ){
                                                                                                $CATACount3 = $rowCATA['CATAcount']; 
                                                                                    ?>
                                                                                    <h5 class="mb-1"><?=$CATACount3?></h5>
                                                                                    <?php
                                                                                            }
                                                                                        }
                                                                                    ?>
                                                                                    <p class="text-muted mb-0">Total Team Member</p>
                                                                                </div>
                                                                                <div class="col-6">
                                                                                    <?php
                                                                                        $countPAC2_3 = "SELECT COUNT(te_id) AS PECcount FROM product_payout WHERE te_id='".$cas_id."' ";
                                                                                        $pecCount2_3 = $conn -> prepare($countPAC2_3);
                                                                                        $pecCount2_3 -> execute();
                                                                                        $pecCount2_3 -> setFetchMode(PDO::FETCH_ASSOC);
                                                                                        if( $pecCount2_3 -> rowCount()>0 ){
                                                                                            foreach( ($pecCount2_3 -> fetchAll()) as $keyPec => $rowPec ){
                                                                                                $PecCount2_3 = $rowPec['PECcount'];
                                                                                    ?>
                                                                                    <h5 class="mb-1"><?=$PecCount2_3?></h5>
                                                                                    <?php
                                                                                            }
                                                                                        }
                                                                                    ?>
                                                                                    <p class="text-muted mb-0">Total Packages</p>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-2 col-md-2 col-sm-6 col-6 py-2">
                                                                            <h5 class="mb-1">Phone No</h5>
                                                                            <p class="text-muted mb-0"><?=$referral2['contact_no']?></p>
                                                                        </div>
                                                                        <div class="col-lg-2 col-md-2 col-sm-6 col-6 py-2">
                                                                            <div class="text-center">
                                                                                <a href="#" onclick="overviewPage('<?= $referral2['corporate_agency_id'] .','.  $referral2['reference_no'] . ',' .$referral2['country']. ',' .$referral2['state']. ',' .$referral2['city']. ',corporate_agency' ?>')" class="btn btn-primary view-btn">View Profile</a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </button>
                                                        <!-- all TC recruted by TE -->
                                                        <div class="panel">
                                                            <?php
                                                                $stmt3 = $conn -> prepare(" SELECT * FROM ca_travelagency WHERE reference_no = ? AND status = '1' ORDER BY ca_travelagency_id ASC");
                                                                $stmt3 -> execute([$cas_id]);
                                                                $referrals3 = $stmt3->fetchAll(PDO::FETCH_ASSOC);
                                                                foreach($referrals3 as $referral3){
                                                                    $catas_id = $referral3['ca_travelagency_id'];
                                                            ?>
                                                            <button class="accordion p-0">
                                                                <div class="card mb-0 rounded-0">
                                                                    <div class="card-body p-2">
                                                                        <div class="row align-items-center">
                                                                            <div class="col-lg-4 col-md-4 col-sm-12 col-12 py-2">
                                                                                <div class="team-profile-img d-flex align-items-center justify-content-around">
                                                                                    <div class="avatar-md img-thumbnail rounded float-start rounded-circle">
                                                                                        <img src="../../uploading/<?=$referral3['profile_pic']?>" alt="" class="img-fluid d-block rounded-circle" />
                                                                                    </div>
                                                                                    <div>
                                                                                        <a href="#" class="d-block">
                                                                                            <h5 class="fs-5 mb-1"><?=$referral3['firstname'].' '.$referral3['lastname'].' '.$catas_id?></h5>
                                                                                        </a>
                                                                                        <p class="text-muted mb-0">Travel Consultant</p>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-lg-4 col-md-4 col-sm-12 col-12 py-2">
                                                                                <div class="row text-center">
                                                                                    <div class="col-6 border-end">
                                                                                        <?php
                                                                                            $countCACU = "SELECT COUNT(ca_customer_id) AS CACUcount FROM ca_customer WHERE ta_reference_no='".$catas_id."' ";
                                                                                            $cacuCount = $conn -> prepare($countCACU);
                                                                                            $cacuCount -> execute();
                                                                                            $cacuCount -> setFetchMode(PDO::FETCH_ASSOC);
                                                                                            if( $cacuCount -> rowCount()>0 ){
                                                                                                foreach( ($cacuCount -> fetchAll()) as $keyCACU => $rowCACU ){
                                                                                                    $CACUCount = $rowCACU['CACUcount'];
                                                                                        ?>
                                                                                        <h5 class="mb-1"><?= $CACUCount ?></h5>
                                                                                        <?php
                                                                                                }
                                                                                            }
                                                                                        ?>
                                                                                        <p class="text-muted mb-0">Total Team Member</p>
                                                                                    </div>
                                                                                    <div class="col-6">
                                                                                        <?php
                                                                                            $countPAC = "SELECT COUNT(ta_id) AS PECcount FROM product_payout WHERE ta_id='".$catas_id."' ";
                                                                                            $pecCount = $conn -> prepare($countPAC);
                                                                                            $pecCount -> execute();
                                                                                            $pecCount -> setFetchMode(PDO::FETCH_ASSOC);
                                                                                            if( $pecCount -> rowCount()>0 ){
                                                                                                foreach( ($pecCount -> fetchAll()) as $keyPec => $rowPec ){
                                                                                                    $PecCount = $rowPec['PECcount'];
                                                                                        ?>
                                                                                        <h5 class="mb-1"><?=$PecCount?></h5>
                                                                                        <?php
                                                                                                }
                                                                                            }
                                                                                        ?>
                                                                                        <p class="text-muted mb-0">Total Packages</p>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-lg-2 col-md-2 col-sm-6 col-6 py-2">
                                                                                <h5 class="mb-1">Phone No</h5>
                                                                                <p class="text-muted mb-0"><?php $referral3['contact_no'] ?></p>
                                                                            </div>
                                                                            <div class="col-lg-2 col-md-2 col-sm-6 col-6 py-2">
                                                                                <div class="text-center">
                                                                                    <a href="#" onclick="overviewPage('<?= $referral3['ca_travelagency_id'] .','.  $referral3['reference_no'] . ',' .$referral3['country']. ',' .$referral3['state']. ',' .$referral3['city']. ',travel_consultant' ?>')" class="btn btn-primary view-btn">View Profile</a>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </button>
                                                            <!-- all Customers onboarded by TC -->
                                                            <div class="panel">
                                                                <?php
                                                                    $stmt4 = $conn -> prepare(" SELECT * FROM ca_customer WHERE ta_reference_no = ? AND reference_no IS NUll AND status = '1' ORDER BY ca_customer_id ASC");
                                                                    $stmt4 -> execute([$catas_id]);
                                                                    $referrals4 = $stmt4->fetchAll(PDO::FETCH_ASSOC);
                                                                    foreach($referrals4 as $referral4){
                                                                        $cacus_id = $referral4['ca_customer_id'];
                                                                ?>
                                                                <button class="accordion p-0">
                                                                    <div class="card mb-0 rounded-0">
                                                                        <div class="card-body p-2">
                                                                            <div class="row align-items-center">
                                                                                <div class="col-lg-4 col-md-4 col-sm-12 col-12 py-2">
                                                                                    <div class="team-profile-img d-flex align-items-center justify-content-around">
                                                                                        <div class="avatar-md img-thumbnail rounded float-start rounded-circle">
                                                                                            <img src="../../uploading/<?=$referral4['profile_pic']?>" alt="" class="img-fluid d-block rounded-circle" />
                                                                                        </div>
                                                                                        <div>
                                                                                            <a href="#" class="d-block">
                                                                                                <h5 class="fs-5 mb-1"><?=$referral4['firstname'].' '.$referral4['lastname'].' '.$cacus_id?></h5>
                                                                                            </a>
                                                                                            <p class="text-muted mb-0">Customer</p>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-lg-4 col-md-4 col-sm-12 col-12 py-2">
                                                                                    <div class="row text-center">
                                                                                        <div class="col-6 border-end">
                                                                                            <?php
                                                                                                $countCATACU = "SELECT COUNT(ca_customer_id) AS CATACUcount FROM ca_customer WHERE reference_no='".$cacus_id."' ";
                                                                                                $catacuCount = $conn -> prepare($countCATACU);
                                                                                                $catacuCount -> execute();
                                                                                                $catacuCount -> setFetchMode(PDO::FETCH_ASSOC);
                                                                                                if( $catacuCount -> rowCount()>0 ){
                                                                                                    foreach( ($catacuCount -> fetchAll()) as $keyCATACU => $rowCATACU ){
                                                                                                        $CATACUCount = $rowCATACU['CATACUcount'];
                                                                                            ?>
                                                                                            <h5 class="mb-1"><?=$CATACUCount?></h5>
                                                                                            <?php
                                                                                                    }
                                                                                                }
                                                                                            ?>
                                                                                            <p class="text-muted mb-0">Total Refered Customers</p>
                                                                                        </div>
                                                                                        <div class="col-6">
                                                                                            <?php
                                                                                                $countPAC = "SELECT COUNT(cu_id) AS PECcount FROM product_payout WHERE cu_id='".$cacus_id."' ";
                                                                                                $pecCount = $conn -> prepare($countPAC);
                                                                                                $pecCount -> execute();
                                                                                                $pecCount -> setFetchMode(PDO::FETCH_ASSOC);
                                                                                                if( $pecCount -> rowCount()>0 ){
                                                                                                    foreach( ($pecCount -> fetchAll()) as $keyPec => $rowPec ){
                                                                                                        $PecCount = $rowPec['PECcount'];
                                                                                            ?>
                                                                                            <h5 class="mb-1"><?=$PecCount?></h5>
                                                                                            <?php
                                                                                                    }
                                                                                                }
                                                                                            ?>
                                                                                            <p class="text-muted mb-0">Total Packages</p>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-lg-2 col-md-2 col-sm-6 col-6 py-2">
                                                                                    <h5 class="mb-1">Phone No</h5>
                                                                                    <p class="text-muted mb-0"><?=$referral4['contact_no']?></p>
                                                                                </div>
                                                                                <div class="col-lg-2 col-md-2 col-sm-6 col-6 py-2">
                                                                                    <div class="text-center">
                                                                                        <a href="#" onclick="overviewPage('<?= $referral4['ca_customer_id'] .','.  $referral4['reference_no'] . ',' .$referral4['country']. ',' .$referral4['state']. ',' .$referral4['city']. ',customer' ?>')" class="btn btn-primary view-btn">View Profile</a>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </button>
                                                                <!-- customer ref level 1 -->
                                                                <div class="panel">
                                                                    <?php
                                                                        $stmt5 = $conn -> prepare(" SELECT * FROM ca_customer WHERE reference_no = ? AND status = '1' ORDER BY ca_customer_id ASC");
                                                                        $stmt5 -> execute([$cacus_id]);
                                                                        $referrals5 = $stmt5->fetchAll(PDO::FETCH_ASSOC);
                                                                        foreach($referrals5 as $referral5){
                                                                            $customer_id = $referral5['ca_customer_id'];
                                                                    ?>
                                                                    <button class="accordion p-0">
                                                                        <div class="card mb-0 rounded-0">
                                                                            <div class="card-body p-2">
                                                                                <div class="row align-items-center">
                                                                                    <div class="col-lg-4 col-md-4 col-sm-12 col-12 py-2">
                                                                                        <div class="team-profile-img d-flex align-items-center justify-content-around">
                                                                                            <div class="avatar-md img-thumbnail rounded float-start rounded-circle">
                                                                                                <img src="../../uploading/<?=$referral5['profile_pic']?>" alt="" class="img-fluid d-block rounded-circle" />
                                                                                            </div>
                                                                                            <div>
                                                                                                <a href="#" class="d-block">
                                                                                                    <h5 class="fs-5 mb-1"><?=$referral5['firstname'].' '.$referral5['lastname'].' '.$customer_id?></h5>
                                                                                                </a>
                                                                                                <p class="text-muted mb-0">Customer</p>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-lg-4 col-md-4 col-sm-12 col-12 py-2">
                                                                                        <div class="row text-center">
                                                                                            <div class="col-6 border-end">
                                                                                                <?php
                                                                                                    $countCU = "SELECT COUNT(ca_customer_id) AS CATAcount FROM ca_customer WHERE reference_no='".$customer_id."' ";
                                                                                                    $cuCount = $conn -> prepare($countCU);
                                                                                                    $cuCount -> execute();
                                                                                                    $cuCount -> setFetchMode(PDO::FETCH_ASSOC);
                                                                                                    if( $cuCount -> rowCount()>0 ){
                                                                                                        foreach( ($cuCount -> fetchAll()) as $keycu => $rowcu ){
                                                                                                            $cuCount = $rowcu['CATAcount'];
                                                                                                ?>
                                                                                                <h5 class="mb-1"><?=$cuCount?></h5>
                                                                                                <?php
                                                                                                        }
                                                                                                    }
                                                                                                ?>
                                                                                                <p class="text-muted mb-0">Total Refered Customers</p>
                                                                                            </div>
                                                                                            <div class="col-6">
                                                                                                <?php
                                                                                                    $countPAC = "SELECT COUNT(cu_id) AS PECcount FROM product_payout WHERE cu_id='".$customer_id."' ";
                                                                                                    $pecCount = $conn -> prepare($countPAC);
                                                                                                    $pecCount -> execute();
                                                                                                    $pecCount -> setFetchMode(PDO::FETCH_ASSOC);
                                                                                                    if( $pecCount -> rowCount()>0 ){
                                                                                                        foreach( ($pecCount -> fetchAll()) as $keyPec => $rowPec ){
                                                                                                            $PecCount = $rowPec['PECcount'];
                                                                                                ?>
                                                                                                <h5 class="mb-1">20</h5>
                                                                                                <?php
                                                                                                        }
                                                                                                    }
                                                                                                ?>
                                                                                                <p class="text-muted mb-0">Total Packages</p>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-lg-2 col-md-2 col-sm-6 col-6 py-2">
                                                                                        <h5 class="mb-1">Phone No</h5>
                                                                                        <p class="text-muted mb-0"><?=$referral5['contact_no']?></p>
                                                                                    </div>
                                                                                    <div class="col-lg-2 col-md-2 col-sm-6 col-6 py-2">
                                                                                        <div class="text-center">
                                                                                            <a href="#" onclick="overviewPage('<?= $referral5['ca_customer_id'] .','.  $referral5['reference_no'] . ',' .$referral5['country']. ',' .$referral5['state']. ',' .$referral5['city']. ',customer' ?>')" class="btn btn-primary view-btn">View Profile</a>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </button>
                                                                    <!-- cumtomer ref level 2 -->
                                                                    <div class="panel">
                                                                        <?php
                                                                            $stmt6 = $conn -> prepare(" SELECT * FROM ca_customer WHERE reference_no = ? AND status = '1' ORDER BY ca_customer_id ASC");
                                                                            $stmt6 -> execute([$customer_id]);
                                                                            $referrals6 = $stmt6->fetchAll(PDO::FETCH_ASSOC);
                                                                            foreach($referrals6 as $referral6){
                                                                                $customer_id2 = $referral6['ca_customer_id'];
                                                                        ?>
                                                                        <button class="accordion p-0">
                                                                            <div class="card mb-0 rounded-0">
                                                                                <div class="card-body p-2">
                                                                                    <div class="row align-items-center">
                                                                                        <div class="col-lg-4 col-md-4 col-sm-12 col-12 py-2">
                                                                                            <div class="team-profile-img d-flex align-items-center justify-content-around">
                                                                                                <div class="avatar-md img-thumbnail rounded float-start rounded-circle">
                                                                                                    <img src="../../uploading/<?=$referral6['profile_pic']?>" alt="" class="img-fluid d-block rounded-circle" />
                                                                                                </div>
                                                                                                <div>
                                                                                                    <a href="#" class="d-block">
                                                                                                        <h5 class="fs-5 mb-1"><?=$referral6['firstname'].' '.$referral6['lastname'].' '.$customer_id2?></h5>
                                                                                                    </a>
                                                                                                    <p class="text-muted mb-0">Customer</p>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="col-lg-4 col-md-4 col-sm-12 col-12 py-2">
                                                                                            <div class="row text-center">
                                                                                                <div class="col-6 border-end">
                                                                                                    <?php
                                                                                                        $countCU2 = "SELECT COUNT(ca_customer_id) AS CATAcount FROM ca_customer WHERE reference_no='".$customer_id2."' ";
                                                                                                        $cuCount2 = $conn -> prepare($countCU2);
                                                                                                        $cuCount2 -> execute();
                                                                                                        $cuCount2 -> setFetchMode(PDO::FETCH_ASSOC);
                                                                                                        if( $cuCount2 -> rowCount()>0 ){
                                                                                                            foreach( ($cuCount2 -> fetchAll()) as $keycu2 => $rowcu2 ){
                                                                                                                $cu2Count = $rowcu2['CATAcount'];
                                                                                                    ?>
                                                                                                    <h5 class="mb-1"><?= $cu2Count?></h5>
                                                                                                    <?php
                                                                                                            }
                                                                                                        }
                                                                                                    ?>
                                                                                                    <p class="text-muted mb-0">Total Refered Customers</p>
                                                                                                </div>
                                                                                                <div class="col-6">
                                                                                                    <?php
                                                                                                        $countPAC2 = "SELECT COUNT(cu_id) AS PECcount FROM product_payout WHERE cu_id='".$customer_id2."' ";
                                                                                                        $pecCount2 = $conn -> prepare($countPAC2);
                                                                                                        $pecCount2 -> execute();
                                                                                                        $pecCount2 -> setFetchMode(PDO::FETCH_ASSOC);
                                                                                                        if( $pecCount2 -> rowCount()>0 ){
                                                                                                            foreach( ($pecCount2 -> fetchAll()) as $keyPec2 => $rowPec2 ){
                                                                                                                $PecCount2 = $rowPec2['PECcount'];
                                                                                                    ?>
                                                                                                    <h5 class="mb-1"><?=$PecCount2?></h5>
                                                                                                    <?php
                                                                                                            }
                                                                                                        }
                                                                                                    ?>
                                                                                                    <p class="text-muted mb-0">Total Packages</p>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="col-lg-2 col-md-2 col-sm-6 col-6 py-2">
                                                                                            <h5 class="mb-1">Phone No</h5>
                                                                                            <p class="text-muted mb-0"><?=$referral6['contact_no']?></p>
                                                                                        </div>
                                                                                        <div class="col-lg-2 col-md-2 col-sm-6 col-6 py-2">
                                                                                            <div class="text-center">
                                                                                                <a href="#" onclick="overviewPage('<?= $referral6['ca_customer_id'] .','.  $referral6['reference_no'] . ',' .$referral6['country']. ',' .$referral6['state']. ',' .$referral6['city']. ',customer' ?>')" class="btn btn-primary view-btn">View Profile</a>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </button>
                                                                        <!-- cumtomer ref level 3 -->
                                                                        <div class="panel">
                                                                            <?php
                                                                                $stmt6 = $conn -> prepare(" SELECT * FROM ca_customer WHERE reference_no = ? AND status = '1' ORDER BY ca_customer_id ASC");
                                                                                $stmt6 -> execute([$customer_id2]);
                                                                                $referrals6 = $stmt6->fetchAll(PDO::FETCH_ASSOC);
                                                                                foreach($referrals6 as $referral6){
                                                                                    $customer_id3 = $referral6['ca_customer_id'];
                                                                            ?>
                                                                            <button class="accordion p-0">
                                                                                <div class="card mb-0 rounded-0">
                                                                                    <div class="card-body p-2">
                                                                                        <div class="row align-items-center">
                                                                                            <div class="col-lg-4 col-md-4 col-sm-12 col-12 py-2">
                                                                                                <div class="team-profile-img d-flex align-items-center justify-content-around">
                                                                                                    <div class="avatar-md img-thumbnail rounded float-start rounded-circle">
                                                                                                        <img src="../../uploading/<?=$referral6['profile_pic']?>" alt="" class="img-fluid d-block rounded-circle" />
                                                                                                    </div>
                                                                                                    <div>
                                                                                                        <a href="#" class="d-block">
                                                                                                            <h5 class="fs-5 mb-1"><?=$referral6['firstname'].' '.$referral6['lastname'].' '.$customer_id3?></h5>
                                                                                                        </a>
                                                                                                        <p class="text-muted mb-0">Customer</p>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="col-lg-4 col-md-4 col-sm-12 col-12 py-2">
                                                                                                <div class="row text-center">
                                                                                                    <div class="col-6 border-end">
                                                                                                        <?php
                                                                                                            $countCU2 = "SELECT COUNT(ca_customer_id) AS CATAcount FROM ca_customer WHERE reference_no='".$customer_id3."' ";
                                                                                                            $cuCount2 = $conn -> prepare($countCU2);
                                                                                                            $cuCount2 -> execute();
                                                                                                            $cuCount2 -> setFetchMode(PDO::FETCH_ASSOC);
                                                                                                            if( $cuCount2 -> rowCount()>0 ){
                                                                                                                foreach( ($cuCount2 -> fetchAll()) as $keycu2 => $rowcu2 ){
                                                                                                                    $cu2Count = $rowcu2['CATAcount'];
                                                                                                        ?>
                                                                                                        <h5 class="mb-1"><?=$cu2Count?></h5>
                                                                                                        <?php
                                                                                                                }
                                                                                                            }
                                                                                                        ?>
                                                                                                        <p class="text-muted mb-0">Total Refered Customers</p>
                                                                                                    </div>
                                                                                                    <div class="col-6">
                                                                                                        <?php
                                                                                                            $countPAC2 = "SELECT COUNT(cu_id) AS PECcount FROM product_payout WHERE cu_id='".$customer_id3."' ";
                                                                                                            $pecCount2 = $conn -> prepare($countPAC2);
                                                                                                            $pecCount2 -> execute();
                                                                                                            $pecCount2 -> setFetchMode(PDO::FETCH_ASSOC);
                                                                                                            if( $pecCount2 -> rowCount()>0 ){
                                                                                                                foreach( ($pecCount2 -> fetchAll()) as $keyPec2 => $rowPec2 ){
                                                                                                                    $PecCount2 = $rowPec2['PECcount'];
                                                                                                        ?>
                                                                                                        <h5 class="mb-1"><?=$PecCount2?></h5>
                                                                                                        <?php
                                                                                                                }
                                                                                                            }
                                                                                                        ?>
                                                                                                        <p class="text-muted mb-0">Total Packages</p>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="col-lg-2 col-md-2 col-sm-6 col-6 py-2">
                                                                                                <h5 class="mb-1">Phone No</h5>
                                                                                                <p class="text-muted mb-0"><?=$referral6['contact_no']?></p>
                                                                                            </div>
                                                                                            <div class="col-lg-2 col-md-2 col-sm-6 col-6 py-2">
                                                                                                <div class="text-center">
                                                                                                    <a href="#" onclick="overviewPage('<?= $referral6['ca_customer_id'] .','.  $referral6['reference_no'] . ',' .$referral6['country']. ',' .$referral6['state']. ',' .$referral6['city']. ',customer' ?>')" class="btn btn-primary view-btn">View Profile</a>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </button>
                                                                            <?php
                                                                                }
                                                                            ?>
                                                                        </div>
                                                                        <?php
                                                                            }
                                                                        ?>
                                                                        <!-- end cumtomer ref level 3 -->
                                                                    </div>
                                                                    <!-- end cumtomer ref level 2 -->
                                                                    <?php
                                                                        }
                                                                    ?>
                                                                </div>
                                                                <!-- end customer ref level 1 -->
                                                                <?php
                                                                    }
                                                                ?>
                                                            </div>
                                                            <!-- end all Customers onboarded by TC -->
                                                            <?php
                                                                }
                                                            ?>
                                                        </div>
                                                        <!-- end all TC recruted by TE -->
                                                        <?php
                                                            }
                                                        ?>
                                                        <!-- TC recruted by BM -->
                                                        <?php
                                                            $stmt2_3 = $conn -> prepare(" SELECT * FROM ca_travelagency WHERE reference_no = ? AND status = '1' ORDER BY ca_travelagency_id ASC");
                                                            $stmt2_3 -> execute([$bms_id]);
                                                            $referrals2_3 = $stmt2_3->fetchAll(PDO::FETCH_ASSOC);
                                                            foreach($referrals2_3 as $referral2){
                                                                $cas_id = $referral2['ca_travelagency_id'];
                                                        ?>
                                                        <button class="accordion p-0">
                                                            <div class="card mb-0 rounded-0">
                                                                <div class="card-body p-2">
                                                                    <div class="row align-items-center">
                                                                        <div class="col-lg-4 col-md-4 col-sm-12 col-12 py-2">
                                                                            <div class="team-profile-img d-flex align-items-center justify-content-around">
                                                                                <div class="avatar-md img-thumbnail rounded float-start rounded-circle">
                                                                                    <img src="../../uploading/<?=$referral2['profile_pic']?>" alt="" class="img-fluid d-block rounded-circle" />
                                                                                </div>
                                                                                <div>
                                                                                    <a href="#" class="d-block">
                                                                                        <h5 class="fs-5 mb-1"><?=$referral2['firstname'].' '.$referral2['lastname'].' '.$cas_id?></h5>
                                                                                    </a>
                                                                                    <p class="text-muted mb-0">Travel Consultant</p>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-4 col-md-4 col-sm-12 col-12 py-2">
                                                                            <div class="row text-center">
                                                                                <div class="col-6 border-end">
                                                                                    <?php
                                                                                        $countCACU2 = "SELECT COUNT(ca_customer_id) AS CACUcount FROM ca_customer WHERE ta_reference_no='".$cas_id."' ";
                                                                                        $cacuCount2 = $conn -> prepare($countCACU2);
                                                                                        $cacuCount2 -> execute();
                                                                                        $cacuCount2 -> setFetchMode(PDO::FETCH_ASSOC);
                                                                                        if( $cacuCount2 -> rowCount()>0 ){
                                                                                            foreach( ($cacuCount2 -> fetchAll()) as $keyCACU => $rowCACU ){
                                                                                                $CACUCount2 = $rowCACU['CACUcount'];
                                                                                    ?>
                                                                                    <h5 class="mb-1"><?=$CACUCount2?></h5>
                                                                                    <?php
                                                                                            }
                                                                                        }
                                                                                    ?>
                                                                                    <p class="text-muted mb-0">Total Team Member</p>
                                                                                </div>
                                                                                <div class="col-6">
                                                                                    <?php
                                                                                        $countPAC3 = "SELECT COUNT(ta_id) AS PECcount FROM product_payout WHERE ta_id='".$cas_id."' ";
                                                                                        $pecCount3 = $conn -> prepare($countPAC3);
                                                                                        $pecCount3 -> execute();
                                                                                        $pecCount3 -> setFetchMode(PDO::FETCH_ASSOC);
                                                                                        if( $pecCount3 -> rowCount()>0 ){
                                                                                            foreach( ($pecCount3 -> fetchAll()) as $keyPec => $rowPec ){
                                                                                                $PecCount3 = $rowPec['PECcount'];
                                                                                    ?>
                                                                                    <h5 class="mb-1"><?=$PecCount3?></h5>
                                                                                    <?php
                                                                                            }
                                                                                        }
                                                                                    ?>
                                                                                    <p class="text-muted mb-0">Total Packages</p>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-2 col-md-2 col-sm-6 col-6 py-2">
                                                                            <h5 class="mb-1">Phone No</h5>
                                                                            <p class="text-muted mb-0"><?=$referral2['contact_no']?></p>
                                                                        </div>
                                                                        <div class="col-lg-2 col-md-2 col-sm-6 col-6 py-2">
                                                                            <div class="text-center">
                                                                                <a href="#" onclick="overviewPage('<?= $referral2['ca_travelagency_id'] .','.  $referral2['reference_no'] . ',' .$referral2['country']. ',' .$referral2['state']. ',' .$referral2['city']. ',travel_consultant' ?>')" class="btn btn-primary view-btn">View Profile</a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </button>
                                                        <!-- all Customers onboarded by TC -->
                                                            <div class="panel">
                                                                <?php
                                                                    $stmt4 = $conn -> prepare(" SELECT * FROM ca_customer WHERE ta_reference_no = ? AND reference_no IS NUll AND status = '1' ORDER BY ca_customer_id ASC");
                                                                    $stmt4 -> execute([$cas_id]);
                                                                    $referrals4 = $stmt4->fetchAll(PDO::FETCH_ASSOC);
                                                                    foreach($referrals4 as $referral4){
                                                                        $cacus_id = $referral4['ca_customer_id'];
                                                                ?>
                                                                <button class="accordion p-0">
                                                                    <div class="card mb-0 rounded-0">
                                                                        <div class="card-body p-2">
                                                                            <div class="row align-items-center">
                                                                                <div class="col-lg-4 col-md-4 col-sm-12 col-12 py-2">
                                                                                    <div class="team-profile-img d-flex align-items-center justify-content-around">
                                                                                        <div class="avatar-md img-thumbnail rounded float-start rounded-circle">
                                                                                            <img src="../../uploading/<?=$referral4['profile_pic']?>" alt="" class="img-fluid d-block rounded-circle" />
                                                                                        </div>
                                                                                        <div>
                                                                                            <a href="#" class="d-block">
                                                                                                <h5 class="fs-5 mb-1"><?=$referral4['firstname'].' '.$referral4['lastname'].' '.$cacus_id?></h5>
                                                                                            </a>
                                                                                            <p class="text-muted mb-0">Customer</p>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-lg-4 col-md-4 col-sm-12 col-12 py-2">
                                                                                    <div class="row text-center">
                                                                                        <div class="col-6 border-end">
                                                                                            <?php
                                                                                                $countCATACU = "SELECT COUNT(ca_customer_id) AS CATACUcount FROM ca_customer WHERE reference_no='".$cacus_id."' ";
                                                                                                $catacuCount = $conn -> prepare($countCATACU);
                                                                                                $catacuCount -> execute();
                                                                                                $catacuCount -> setFetchMode(PDO::FETCH_ASSOC);
                                                                                                if( $catacuCount -> rowCount()>0 ){
                                                                                                    foreach( ($catacuCount -> fetchAll()) as $keyCATACU => $rowCATACU ){
                                                                                                        $CATACUCount = $rowCATACU['CATACUcount'];
                                                                                            ?>
                                                                                            <h5 class="mb-1"><?=$CATACUCount?></h5>
                                                                                            <?php
                                                                                                    }
                                                                                                }
                                                                                            ?>
                                                                                            <p class="text-muted mb-0">Total Refered Customers</p>
                                                                                        </div>
                                                                                        <div class="col-6">
                                                                                            <?php
                                                                                                $countPAC = "SELECT COUNT(cu_id) AS PECcount FROM product_payout WHERE cu_id='".$cacus_id."' ";
                                                                                                $pecCount = $conn -> prepare($countPAC);
                                                                                                $pecCount -> execute();
                                                                                                $pecCount -> setFetchMode(PDO::FETCH_ASSOC);
                                                                                                if( $pecCount -> rowCount()>0 ){
                                                                                                    foreach( ($pecCount -> fetchAll()) as $keyPec => $rowPec ){
                                                                                                        $PecCount = $rowPec['PECcount'];
                                                                                            ?>
                                                                                            <h5 class="mb-1"><?=$PecCount?></h5>
                                                                                            <?php
                                                                                                    }
                                                                                                }
                                                                                            ?>
                                                                                            <p class="text-muted mb-0">Total Packages</p>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-lg-2 col-md-2 col-sm-6 col-6 py-2">
                                                                                    <h5 class="mb-1">Phone No</h5>
                                                                                    <p class="text-muted mb-0"><?=$referral4['contact_no']?></p>
                                                                                </div>
                                                                                <div class="col-lg-2 col-md-2 col-sm-6 col-6 py-2">
                                                                                    <div class="text-center">
                                                                                        <a href="#" onclick="overviewPage('<?= $referral4['ca_customer_id'] .','.  $referral4['reference_no'] . ',' .$referral4['country']. ',' .$referral4['state']. ',' .$referral4['city']. ',customer' ?>')" class="btn btn-primary view-btn">View Profile</a>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </button>
                                                                <!-- customer ref level 1 -->
                                                                <div class="panel">
                                                                    <?php
                                                                        $stmt5 = $conn -> prepare(" SELECT * FROM ca_customer WHERE reference_no = ? AND status = '1' ORDER BY ca_customer_id ASC");
                                                                        $stmt5 -> execute([$cacus_id]);
                                                                        $referrals5 = $stmt5->fetchAll(PDO::FETCH_ASSOC);
                                                                        foreach($referrals5 as $referral5){
                                                                            $customer_id = $referral5['ca_customer_id'];
                                                                    ?>
                                                                    <button class="accordion p-0">
                                                                        <div class="card mb-0 rounded-0">
                                                                            <div class="card-body p-2">
                                                                                <div class="row align-items-center">
                                                                                    <div class="col-lg-4 col-md-4 col-sm-12 col-12 py-2">
                                                                                        <div class="team-profile-img d-flex align-items-center justify-content-around">
                                                                                            <div class="avatar-md img-thumbnail rounded float-start rounded-circle">
                                                                                                <img src="../../uploading/<?=$referral5['profile_pic']?>" alt="" class="img-fluid d-block rounded-circle" />
                                                                                            </div>
                                                                                            <div>
                                                                                                <a href="#" class="d-block">
                                                                                                    <h5 class="fs-5 mb-1"><?=$referral5['firstname'].' '.$referral5['lastname'].' '.$customer_id?></h5>
                                                                                                </a>
                                                                                                <p class="text-muted mb-0">Customer</p>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-lg-4 col-md-4 col-sm-12 col-12 py-2">
                                                                                        <div class="row text-center">
                                                                                            <div class="col-6 border-end">
                                                                                                <?php
                                                                                                    $countCU = "SELECT COUNT(ca_customer_id) AS CATAcount FROM ca_customer WHERE reference_no='".$customer_id."' ";
                                                                                                    $cuCount = $conn -> prepare($countCU);
                                                                                                    $cuCount -> execute();
                                                                                                    $cuCount -> setFetchMode(PDO::FETCH_ASSOC);
                                                                                                    if( $cuCount -> rowCount()>0 ){
                                                                                                        foreach( ($cuCount -> fetchAll()) as $keycu => $rowcu ){
                                                                                                            $cuCount = $rowcu['CATAcount'];
                                                                                                ?>
                                                                                                <h5 class="mb-1"><?=$cuCount?></h5>
                                                                                                <?php
                                                                                                        }
                                                                                                    }
                                                                                                ?>
                                                                                                <p class="text-muted mb-0">Total Refered Customers</p>
                                                                                            </div>
                                                                                            <div class="col-6">
                                                                                                <?php
                                                                                                    $countPAC = "SELECT COUNT(cu_id) AS PECcount FROM product_payout WHERE cu_id='".$customer_id."' ";
                                                                                                    $pecCount = $conn -> prepare($countPAC);
                                                                                                    $pecCount -> execute();
                                                                                                    $pecCount -> setFetchMode(PDO::FETCH_ASSOC);
                                                                                                    if( $pecCount -> rowCount()>0 ){
                                                                                                        foreach( ($pecCount -> fetchAll()) as $keyPec => $rowPec ){
                                                                                                            $PecCount = $rowPec['PECcount'];
                                                                                                ?>
                                                                                                <h5 class="mb-1">20</h5>
                                                                                                <?php
                                                                                                        }
                                                                                                    }
                                                                                                ?>
                                                                                                <p class="text-muted mb-0">Total Packages</p>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-lg-2 col-md-2 col-sm-6 col-6 py-2">
                                                                                        <h5 class="mb-1">Phone No</h5>
                                                                                        <p class="text-muted mb-0"><?=$referral5['contact_no']?></p>
                                                                                    </div>
                                                                                    <div class="col-lg-2 col-md-2 col-sm-6 col-6 py-2">
                                                                                        <div class="text-center">
                                                                                            <a href="#" onclick="overviewPage('<?= $referral5['ca_customer_id'] .','.  $referral5['reference_no'] . ',' .$referral5['country']. ',' .$referral5['state']. ',' .$referral5['city']. ',customer' ?>')" class="btn btn-primary view-btn">View Profile</a>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </button>
                                                                    <!-- cumtomer ref level 2 -->
                                                                    <div class="panel">
                                                                        <?php
                                                                            $stmt6 = $conn -> prepare(" SELECT * FROM ca_customer WHERE reference_no = ? AND status = '1' ORDER BY ca_customer_id ASC");
                                                                            $stmt6 -> execute([$customer_id]);
                                                                            $referrals6 = $stmt6->fetchAll(PDO::FETCH_ASSOC);
                                                                            foreach($referrals6 as $referral6){
                                                                                $customer_id2 = $referral6['ca_customer_id'];
                                                                        ?>
                                                                        <button class="accordion p-0">
                                                                            <div class="card mb-0 rounded-0">
                                                                                <div class="card-body p-2">
                                                                                    <div class="row align-items-center">
                                                                                        <div class="col-lg-4 col-md-4 col-sm-12 col-12 py-2">
                                                                                            <div class="team-profile-img d-flex align-items-center justify-content-around">
                                                                                                <div class="avatar-md img-thumbnail rounded float-start rounded-circle">
                                                                                                    <img src="../../uploading/<?=$referral6['profile_pic']?>" alt="" class="img-fluid d-block rounded-circle" />
                                                                                                </div>
                                                                                                <div>
                                                                                                    <a href="#" class="d-block">
                                                                                                        <h5 class="fs-5 mb-1"><?=$referral6['firstname'].' '.$referral6['lastname'].' '.$customer_id2?></h5>
                                                                                                    </a>
                                                                                                    <p class="text-muted mb-0">Customer</p>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="col-lg-4 col-md-4 col-sm-12 col-12 py-2">
                                                                                            <div class="row text-center">
                                                                                                <div class="col-6 border-end">
                                                                                                    <?php
                                                                                                        $countCU2 = "SELECT COUNT(ca_customer_id) AS CATAcount FROM ca_customer WHERE reference_no='".$customer_id2."' ";
                                                                                                        $cuCount2 = $conn -> prepare($countCU2);
                                                                                                        $cuCount2 -> execute();
                                                                                                        $cuCount2 -> setFetchMode(PDO::FETCH_ASSOC);
                                                                                                        if( $cuCount2 -> rowCount()>0 ){
                                                                                                            foreach( ($cuCount2 -> fetchAll()) as $keycu2 => $rowcu2 ){
                                                                                                                $cu2Count = $rowcu2['CATAcount'];
                                                                                                    ?>
                                                                                                    <h5 class="mb-1"><?= $cu2Count?></h5>
                                                                                                    <?php
                                                                                                            }
                                                                                                        }
                                                                                                    ?>
                                                                                                    <p class="text-muted mb-0">Total Refered Customers</p>
                                                                                                </div>
                                                                                                <div class="col-6">
                                                                                                    <?php
                                                                                                        $countPAC2 = "SELECT COUNT(cu_id) AS PECcount FROM product_payout WHERE cu_id='".$customer_id2."' ";
                                                                                                        $pecCount2 = $conn -> prepare($countPAC2);
                                                                                                        $pecCount2 -> execute();
                                                                                                        $pecCount2 -> setFetchMode(PDO::FETCH_ASSOC);
                                                                                                        if( $pecCount2 -> rowCount()>0 ){
                                                                                                            foreach( ($pecCount2 -> fetchAll()) as $keyPec2 => $rowPec2 ){
                                                                                                                $PecCount2 = $rowPec2['PECcount'];
                                                                                                    ?>
                                                                                                    <h5 class="mb-1"><?=$PecCount2?></h5>
                                                                                                    <?php
                                                                                                            }
                                                                                                        }
                                                                                                    ?>
                                                                                                    <p class="text-muted mb-0">Total Packages</p>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="col-lg-2 col-md-2 col-sm-6 col-6 py-2">
                                                                                            <h5 class="mb-1">Phone No</h5>
                                                                                            <p class="text-muted mb-0"><?=$referral6['contact_no']?></p>
                                                                                        </div>
                                                                                        <div class="col-lg-2 col-md-2 col-sm-6 col-6 py-2">
                                                                                            <div class="text-center">
                                                                                                <a href="#" onclick="overviewPage('<?= $referral6['ca_customer_id'] .','.  $referral6['reference_no'] . ',' .$referral6['country']. ',' .$referral6['state']. ',' .$referral6['city']. ',customer' ?>')" class="btn btn-primary view-btn">View Profile</a>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </button>
                                                                        <!-- cumtomer ref level 3 -->
                                                                        <div class="panel">
                                                                            <?php
                                                                                $stmt6 = $conn -> prepare(" SELECT * FROM ca_customer WHERE reference_no = ? AND status = '1' ORDER BY ca_customer_id ASC");
                                                                                $stmt6 -> execute([$customer_id2]);
                                                                                $referrals6 = $stmt6->fetchAll(PDO::FETCH_ASSOC);
                                                                                foreach($referrals6 as $referral6){
                                                                                    $customer_id3 = $referral6['ca_customer_id'];
                                                                            ?>
                                                                            <button class="accordion p-0">
                                                                                <div class="card mb-0 rounded-0">
                                                                                    <div class="card-body p-2">
                                                                                        <div class="row align-items-center">
                                                                                            <div class="col-lg-4 col-md-4 col-sm-12 col-12 py-2">
                                                                                                <div class="team-profile-img d-flex align-items-center justify-content-around">
                                                                                                    <div class="avatar-md img-thumbnail rounded float-start rounded-circle">
                                                                                                        <img src="../../uploading/<?=$referral6['profile_pic']?>" alt="" class="img-fluid d-block rounded-circle" />
                                                                                                    </div>
                                                                                                    <div>
                                                                                                        <a href="#" class="d-block">
                                                                                                            <h5 class="fs-5 mb-1"><?=$referral6['firstname'].' '.$referral6['lastname'].' '.$customer_id3?></h5>
                                                                                                        </a>
                                                                                                        <p class="text-muted mb-0">Customer</p>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="col-lg-4 col-md-4 col-sm-12 col-12 py-2">
                                                                                                <div class="row text-center">
                                                                                                    <div class="col-6 border-end">
                                                                                                        <?php
                                                                                                            $countCU2 = "SELECT COUNT(ca_customer_id) AS CATAcount FROM ca_customer WHERE reference_no='".$customer_id3."' ";
                                                                                                            $cuCount2 = $conn -> prepare($countCU2);
                                                                                                            $cuCount2 -> execute();
                                                                                                            $cuCount2 -> setFetchMode(PDO::FETCH_ASSOC);
                                                                                                            if( $cuCount2 -> rowCount()>0 ){
                                                                                                                foreach( ($cuCount2 -> fetchAll()) as $keycu2 => $rowcu2 ){
                                                                                                                    $cu2Count = $rowcu2['CATAcount'];
                                                                                                        ?>
                                                                                                        <h5 class="mb-1"><?=$cu2Count?></h5>
                                                                                                        <?php
                                                                                                                }
                                                                                                            }
                                                                                                        ?>
                                                                                                        <p class="text-muted mb-0">Total Refered Customers</p>
                                                                                                    </div>
                                                                                                    <div class="col-6">
                                                                                                        <?php
                                                                                                            $countPAC2 = "SELECT COUNT(cu_id) AS PECcount FROM product_payout WHERE cu_id='".$customer_id3."' ";
                                                                                                            $pecCount2 = $conn -> prepare($countPAC2);
                                                                                                            $pecCount2 -> execute();
                                                                                                            $pecCount2 -> setFetchMode(PDO::FETCH_ASSOC);
                                                                                                            if( $pecCount2 -> rowCount()>0 ){
                                                                                                                foreach( ($pecCount2 -> fetchAll()) as $keyPec2 => $rowPec2 ){
                                                                                                                    $PecCount2 = $rowPec2['PECcount'];
                                                                                                        ?>
                                                                                                        <h5 class="mb-1"><?=$PecCount2?></h5>
                                                                                                        <?php
                                                                                                                }
                                                                                                            }
                                                                                                        ?>
                                                                                                        <p class="text-muted mb-0">Total Packages</p>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="col-lg-2 col-md-2 col-sm-6 col-6 py-2">
                                                                                                <h5 class="mb-1">Phone No</h5>
                                                                                                <p class="text-muted mb-0"><?=$referral6['contact_no']?></p>
                                                                                            </div>
                                                                                            <div class="col-lg-2 col-md-2 col-sm-6 col-6 py-2">
                                                                                                <div class="text-center">
                                                                                                    <a href="#" onclick="overviewPage('<?= $referral6['ca_customer_id'] .','.  $referral6['reference_no'] . ',' .$referral6['country']. ',' .$referral6['state']. ',' .$referral6['city']. ',customer' ?>')" class="btn btn-primary view-btn">View Profile</a>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </button>
                                                                            <?php
                                                                                }
                                                                            ?>
                                                                        </div>
                                                                        <?php
                                                                            }
                                                                        ?>
                                                                        <!-- end cumtomer ref level 3 -->
                                                                    </div>
                                                                    <!-- end cumtomer ref level 2 -->
                                                                    <?php
                                                                        }
                                                                    ?>
                                                                </div>
                                                                <!-- end customer ref level 1 -->
                                                                <?php
                                                                    }
                                                                ?>
                                                            </div>
                                                         <!-- end all Customers onboarded by TC -->
                                                        <?php
                                                            }
                                                        ?>
                                                        <!-- end TC recruted by BM -->
                                                        
                                                    </div>
                                                    <!-- end all TE under given BM -->
                                                    <?php
                                                        }
                                                    ?>
                                                    <?php
                                                        $stmt2_1 = $conn -> prepare(" SELECT * FROM corporate_agency WHERE reference_no = ? AND status = '1' ORDER BY corporate_agency_id ASC");
                                                        $stmt2_1 -> execute([$bdms_id]);
                                                        $referrals2_1 = $stmt2_1->fetchAll(PDO::FETCH_ASSOC);
                                                        foreach($referrals2_1 as $referral2_1){
                                                            $tes_id = $referral2_1['corporate_agency_id']; 
                                                    ?>
                                                    <button class="accordion p-0">
                                                        <div class="card mb-0 rounded-0">
                                                            <div class="card-body p-2">
                                                                <div class="row align-items-center">
                                                                    <div class="col-lg-4 col-md-4 col-sm-12 col-12 py-2">
                                                                        <div class="team-profile-img d-flex align-items-center justify-content-around">
                                                                            <div class="avatar-md img-thumbnail rounded float-start rounded-circle">
                                                                                <img src="../../uploading/<?=$referral2_1['profile_pic']?>" alt="" class="img-fluid d-block rounded-circle" />
                                                                            </div>
                                                                            <div>
                                                                                <a href="#" class="d-block">
                                                                                    <h5 class="fs-5 mb-1"><?=$referral2_1['firstname'].' '.$referral2_1['lastname'].' '.$tes_id?></h5>
                                                                                </a>
                                                                                <p class="text-muted mb-0">Techno Enterprise</p>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-4 col-md-4 col-sm-12 col-12 py-2">
                                                                        <div class="row text-center">
                                                                            <div class="col-6 border-end">
                                                                                <?php
                                                                                    $countCATA2 = "SELECT COUNT(ca_travelagency_id) AS CATAcount FROM ca_travelagency WHERE reference_no='".$tes_id."' ";
                                                                                    $cataCount2 = $conn -> prepare($countCATA2);
                                                                                    $cataCount2 -> execute();
                                                                                    $cataCount2 -> setFetchMode(PDO::FETCH_ASSOC);
                                                                                    if( $cataCount2 -> rowCount()>0 ){
                                                                                        foreach( ($cataCount2 -> fetchAll()) as $keyCATA => $rowCATA ){
                                                                                            $CATACount2 = $rowCATA['CATAcount']; 
                                                                                ?>
                                                                                <h5 class="mb-1"><?=$CATACount2?></h5>
                                                                                <?php
                                                                                        }
                                                                                    }
                                                                                ?>
                                                                                <p class="text-muted mb-0">Total Team Member</p>
                                                                            </div>
                                                                            <div class="col-6">
                                                                                <?php
                                                                                    $countPAC2 = "SELECT COUNT(te_id) AS PECcount FROM product_payout WHERE te_id='".$tes_id."' ";
                                                                                    $pecCount2 = $conn -> prepare($countPAC2);
                                                                                    $pecCount2 -> execute();
                                                                                    $pecCount2 -> setFetchMode(PDO::FETCH_ASSOC);
                                                                                    if( $pecCount2 -> rowCount()>0 ){
                                                                                        foreach( ($pecCount2 -> fetchAll()) as $keyPec => $rowPec ){
                                                                                            $PecCount2 = $rowPec['PECcount'];
                                                                                ?>
                                                                                <h5 class="mb-1"><?=$PecCount2?></h5>
                                                                                <?php
                                                                                        }
                                                                                    }
                                                                                ?>
                                                                                <p class="text-muted mb-0">Total Packages</p>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-2 col-md-2 col-sm-6 col-6 py-2">
                                                                        <h5 class="mb-1">Phone No</h5>
                                                                        <p class="text-muted mb-0"><?=$referral2_1['contact_no']?></p>
                                                                    </div>
                                                                    <div class="col-lg-2 col-md-2 col-sm-6 col-6 py-2">
                                                                        <div class="text-center">
                                                                            <a href="#" onclick="overviewPage('<?= $referral2_1['corporate_agency_id'] .','.  $referral2_1['reference_no'] . ',' .$referral2_1['country']. ',' .$referral2_1['state']. ',' .$referral2_1['city']. ',corporate_agency' ?>')" class="btn btn-primary view-btn">View Profile</a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </button>
                                                    <!-- TC under the given TE -->
                                                    <div class="panel">
                                                        <?php
                                                            $stmt2_3 = $conn -> prepare(" SELECT * FROM ca_travelagency WHERE reference_no = ? AND status = '1' ORDER BY ca_travelagency_id ASC");
                                                            $stmt2_3 -> execute([$tes_id]);
                                                            $referrals2_3 = $stmt2_3->fetchAll(PDO::FETCH_ASSOC);
                                                            foreach($referrals2_3 as $referral2){
                                                                $cas_id = $referral2['ca_travelagency_id'];
                                                        ?>
                                                        <button class="accordion p-0">
                                                            <div class="card mb-0 rounded-0">
                                                                <div class="card-body p-2">
                                                                    <div class="row align-items-center">
                                                                        <div class="col-lg-4 col-md-4 col-sm-12 col-12 py-2">
                                                                            <div class="team-profile-img d-flex align-items-center justify-content-around">
                                                                                <div class="avatar-md img-thumbnail rounded float-start rounded-circle">
                                                                                    <img src="../../uploading/<?=$referral2['profile_pic']?>" alt="" class="img-fluid d-block rounded-circle" />
                                                                                </div>
                                                                                <div>
                                                                                    <a href="#" class="d-block">
                                                                                        <h5 class="fs-5 mb-1"><?=$referral2['firstname'].' '.$referral2['lastname'].' '.$cas_id?></h5>
                                                                                    </a>
                                                                                    <p class="text-muted mb-0">Travel Consultant</p>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-4 col-md-4 col-sm-12 col-12 py-2">
                                                                            <div class="row text-center">
                                                                                <div class="col-6 border-end">
                                                                                    <?php
                                                                                        $countCACU2 = "SELECT COUNT(ca_customer_id) AS CACUcount FROM ca_customer WHERE ta_reference_no='".$cas_id."' ";
                                                                                        $cacuCount2 = $conn -> prepare($countCACU2);
                                                                                        $cacuCount2 -> execute();
                                                                                        $cacuCount2 -> setFetchMode(PDO::FETCH_ASSOC);
                                                                                        if( $cacuCount2 -> rowCount()>0 ){
                                                                                            foreach( ($cacuCount2 -> fetchAll()) as $keyCACU => $rowCACU ){
                                                                                                $CACUCount2 = $rowCACU['CACUcount'];
                                                                                    ?>
                                                                                    <h5 class="mb-1"><?=$CACUCount2?></h5>
                                                                                    <?php
                                                                                            }
                                                                                        }
                                                                                    ?>
                                                                                    <p class="text-muted mb-0">Total Team Member</p>
                                                                                </div>
                                                                                <div class="col-6">
                                                                                    <?php
                                                                                        $countPAC3 = "SELECT COUNT(ta_id) AS PECcount FROM product_payout WHERE ta_id='".$cas_id."' ";
                                                                                        $pecCount3 = $conn -> prepare($countPAC3);
                                                                                        $pecCount3 -> execute();
                                                                                        $pecCount3 -> setFetchMode(PDO::FETCH_ASSOC);
                                                                                        if( $pecCount3 -> rowCount()>0 ){
                                                                                            foreach( ($pecCount3 -> fetchAll()) as $keyPec => $rowPec ){
                                                                                                $PecCount3 = $rowPec['PECcount'];
                                                                                    ?>
                                                                                    <h5 class="mb-1"><?=$PecCount3?></h5>
                                                                                    <?php
                                                                                            }
                                                                                        }
                                                                                    ?>
                                                                                    <p class="text-muted mb-0">Total Packages</p>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-2 col-md-2 col-sm-6 col-6 py-2">
                                                                            <h5 class="mb-1">Phone No</h5>
                                                                            <p class="text-muted mb-0"><?=$referral2['contact_no']?></p>
                                                                        </div>
                                                                        <div class="col-lg-2 col-md-2 col-sm-6 col-6 py-2">
                                                                            <div class="text-center">
                                                                                <a href="#" onclick="overviewPage('<?= $referral2['ca_travelagency_id'] .','.  $referral2['reference_no'] . ',' .$referral2['country']. ',' .$referral2['state']. ',' .$referral2['city']. ',travel_consultant' ?>')" class="btn btn-primary view-btn">View Profile</a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </button>
                                                        <!-- all Customers onboarded by TC -->
                                                            <div class="panel">
                                                                <?php
                                                                    $stmt4 = $conn -> prepare(" SELECT * FROM ca_customer WHERE ta_reference_no = ? AND reference_no IS NUll AND status = '1' ORDER BY ca_customer_id ASC");
                                                                    $stmt4 -> execute([$cas_id]);
                                                                    $referrals4 = $stmt4->fetchAll(PDO::FETCH_ASSOC);
                                                                    foreach($referrals4 as $referral4){
                                                                        $cacus_id = $referral4['ca_customer_id'];
                                                                ?>
                                                                <button class="accordion p-0">
                                                                    <div class="card mb-0 rounded-0">
                                                                        <div class="card-body p-2">
                                                                            <div class="row align-items-center">
                                                                                <div class="col-lg-4 col-md-4 col-sm-12 col-12 py-2">
                                                                                    <div class="team-profile-img d-flex align-items-center justify-content-around">
                                                                                        <div class="avatar-md img-thumbnail rounded float-start rounded-circle">
                                                                                            <img src="../../uploading/<?=$referral4['profile_pic']?>" alt="" class="img-fluid d-block rounded-circle" />
                                                                                        </div>
                                                                                        <div>
                                                                                            <a href="#" class="d-block">
                                                                                                <h5 class="fs-5 mb-1"><?=$referral4['firstname'].' '.$referral4['lastname'].' '.$cacus_id?></h5>
                                                                                            </a>
                                                                                            <p class="text-muted mb-0">Customer</p>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-lg-4 col-md-4 col-sm-12 col-12 py-2">
                                                                                    <div class="row text-center">
                                                                                        <div class="col-6 border-end">
                                                                                            <?php
                                                                                                $countCATACU = "SELECT COUNT(ca_customer_id) AS CATACUcount FROM ca_customer WHERE reference_no='".$cacus_id."' ";
                                                                                                $catacuCount = $conn -> prepare($countCATACU);
                                                                                                $catacuCount -> execute();
                                                                                                $catacuCount -> setFetchMode(PDO::FETCH_ASSOC);
                                                                                                if( $catacuCount -> rowCount()>0 ){
                                                                                                    foreach( ($catacuCount -> fetchAll()) as $keyCATACU => $rowCATACU ){
                                                                                                        $CATACUCount = $rowCATACU['CATACUcount'];
                                                                                            ?>
                                                                                            <h5 class="mb-1"><?=$CATACUCount?></h5>
                                                                                            <?php
                                                                                                    }
                                                                                                }
                                                                                            ?>
                                                                                            <p class="text-muted mb-0">Total Refered Customers</p>
                                                                                        </div>
                                                                                        <div class="col-6">
                                                                                            <?php
                                                                                                $countPAC = "SELECT COUNT(cu_id) AS PECcount FROM product_payout WHERE cu_id='".$cacus_id."' ";
                                                                                                $pecCount = $conn -> prepare($countPAC);
                                                                                                $pecCount -> execute();
                                                                                                $pecCount -> setFetchMode(PDO::FETCH_ASSOC);
                                                                                                if( $pecCount -> rowCount()>0 ){
                                                                                                    foreach( ($pecCount -> fetchAll()) as $keyPec => $rowPec ){
                                                                                                        $PecCount = $rowPec['PECcount'];
                                                                                            ?>
                                                                                            <h5 class="mb-1"><?=$PecCount?></h5>
                                                                                            <?php
                                                                                                    }
                                                                                                }
                                                                                            ?>
                                                                                            <p class="text-muted mb-0">Total Packages</p>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-lg-2 col-md-2 col-sm-6 col-6 py-2">
                                                                                    <h5 class="mb-1">Phone No</h5>
                                                                                    <p class="text-muted mb-0"><?=$referral4['contact_no']?></p>
                                                                                </div>
                                                                                <div class="col-lg-2 col-md-2 col-sm-6 col-6 py-2">
                                                                                    <div class="text-center">
                                                                                        <a href="#" onclick="overviewPage('<?= $referral4['ca_customer_id'] .','.  $referral4['reference_no'] . ',' .$referral4['country']. ',' .$referral4['state']. ',' .$referral4['city']. ',customer' ?>')" class="btn btn-primary view-btn">View Profile</a>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </button>
                                                                <!-- customer ref level 1 -->
                                                                <div class="panel">
                                                                    <?php
                                                                        $stmt5 = $conn -> prepare(" SELECT * FROM ca_customer WHERE reference_no = ? AND status = '1' ORDER BY ca_customer_id ASC");
                                                                        $stmt5 -> execute([$cacus_id]);
                                                                        $referrals5 = $stmt5->fetchAll(PDO::FETCH_ASSOC);
                                                                        foreach($referrals5 as $referral5){
                                                                            $customer_id = $referral5['ca_customer_id'];
                                                                    ?>
                                                                    <button class="accordion p-0">
                                                                        <div class="card mb-0 rounded-0">
                                                                            <div class="card-body p-2">
                                                                                <div class="row align-items-center">
                                                                                    <div class="col-lg-4 col-md-4 col-sm-12 col-12 py-2">
                                                                                        <div class="team-profile-img d-flex align-items-center justify-content-around">
                                                                                            <div class="avatar-md img-thumbnail rounded float-start rounded-circle">
                                                                                                <img src="../../uploading/<?=$referral5['profile_pic']?>" alt="" class="img-fluid d-block rounded-circle" />
                                                                                            </div>
                                                                                            <div>
                                                                                                <a href="#" class="d-block">
                                                                                                    <h5 class="fs-5 mb-1"><?=$referral5['firstname'].' '.$referral5['lastname'].' '.$customer_id?></h5>
                                                                                                </a>
                                                                                                <p class="text-muted mb-0">Customer</p>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-lg-4 col-md-4 col-sm-12 col-12 py-2">
                                                                                        <div class="row text-center">
                                                                                            <div class="col-6 border-end">
                                                                                                <?php
                                                                                                    $countCU = "SELECT COUNT(ca_customer_id) AS CATAcount FROM ca_customer WHERE reference_no='".$customer_id."' ";
                                                                                                    $cuCount = $conn -> prepare($countCU);
                                                                                                    $cuCount -> execute();
                                                                                                    $cuCount -> setFetchMode(PDO::FETCH_ASSOC);
                                                                                                    if( $cuCount -> rowCount()>0 ){
                                                                                                        foreach( ($cuCount -> fetchAll()) as $keycu => $rowcu ){
                                                                                                            $cuCount = $rowcu['CATAcount'];
                                                                                                ?>
                                                                                                <h5 class="mb-1"><?=$cuCount?></h5>
                                                                                                <?php
                                                                                                        }
                                                                                                    }
                                                                                                ?>
                                                                                                <p class="text-muted mb-0">Total Refered Customers</p>
                                                                                            </div>
                                                                                            <div class="col-6">
                                                                                                <?php
                                                                                                    $countPAC = "SELECT COUNT(cu_id) AS PECcount FROM product_payout WHERE cu_id='".$customer_id."' ";
                                                                                                    $pecCount = $conn -> prepare($countPAC);
                                                                                                    $pecCount -> execute();
                                                                                                    $pecCount -> setFetchMode(PDO::FETCH_ASSOC);
                                                                                                    if( $pecCount -> rowCount()>0 ){
                                                                                                        foreach( ($pecCount -> fetchAll()) as $keyPec => $rowPec ){
                                                                                                            $PecCount = $rowPec['PECcount'];
                                                                                                ?>
                                                                                                <h5 class="mb-1">20</h5>
                                                                                                <?php
                                                                                                        }
                                                                                                    }
                                                                                                ?>
                                                                                                <p class="text-muted mb-0">Total Packages</p>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-lg-2 col-md-2 col-sm-6 col-6 py-2">
                                                                                        <h5 class="mb-1">Phone No</h5>
                                                                                        <p class="text-muted mb-0"><?=$referral5['contact_no']?></p>
                                                                                    </div>
                                                                                    <div class="col-lg-2 col-md-2 col-sm-6 col-6 py-2">
                                                                                        <div class="text-center">
                                                                                            <a href="#" onclick="overviewPage('<?= $referral5['ca_customer_id'] .','.  $referral5['reference_no'] . ',' .$referral5['country']. ',' .$referral5['state']. ',' .$referral5['city']. ',customer' ?>')" class="btn btn-primary view-btn">View Profile</a>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </button>
                                                                    <!-- cumtomer ref level 2 -->
                                                                    <div class="panel">
                                                                        <?php
                                                                            $stmt6 = $conn -> prepare(" SELECT * FROM ca_customer WHERE reference_no = ? AND status = '1' ORDER BY ca_customer_id ASC");
                                                                            $stmt6 -> execute([$customer_id]);
                                                                            $referrals6 = $stmt6->fetchAll(PDO::FETCH_ASSOC);
                                                                            foreach($referrals6 as $referral6){
                                                                                $customer_id2 = $referral6['ca_customer_id'];
                                                                        ?>
                                                                        <button class="accordion p-0">
                                                                            <div class="card mb-0 rounded-0">
                                                                                <div class="card-body p-2">
                                                                                    <div class="row align-items-center">
                                                                                        <div class="col-lg-4 col-md-4 col-sm-12 col-12 py-2">
                                                                                            <div class="team-profile-img d-flex align-items-center justify-content-around">
                                                                                                <div class="avatar-md img-thumbnail rounded float-start rounded-circle">
                                                                                                    <img src="../../uploading/<?=$referral6['profile_pic']?>" alt="" class="img-fluid d-block rounded-circle" />
                                                                                                </div>
                                                                                                <div>
                                                                                                    <a href="#" class="d-block">
                                                                                                        <h5 class="fs-5 mb-1"><?=$referral6['firstname'].' '.$referral6['lastname'].' '.$customer_id2?></h5>
                                                                                                    </a>
                                                                                                    <p class="text-muted mb-0">Customer</p>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="col-lg-4 col-md-4 col-sm-12 col-12 py-2">
                                                                                            <div class="row text-center">
                                                                                                <div class="col-6 border-end">
                                                                                                    <?php
                                                                                                        $countCU2 = "SELECT COUNT(ca_customer_id) AS CATAcount FROM ca_customer WHERE reference_no='".$customer_id2."' ";
                                                                                                        $cuCount2 = $conn -> prepare($countCU2);
                                                                                                        $cuCount2 -> execute();
                                                                                                        $cuCount2 -> setFetchMode(PDO::FETCH_ASSOC);
                                                                                                        if( $cuCount2 -> rowCount()>0 ){
                                                                                                            foreach( ($cuCount2 -> fetchAll()) as $keycu2 => $rowcu2 ){
                                                                                                                $cu2Count = $rowcu2['CATAcount'];
                                                                                                    ?>
                                                                                                    <h5 class="mb-1"><?= $cu2Count?></h5>
                                                                                                    <?php
                                                                                                            }
                                                                                                        }
                                                                                                    ?>
                                                                                                    <p class="text-muted mb-0">Total Refered Customers</p>
                                                                                                </div>
                                                                                                <div class="col-6">
                                                                                                    <?php
                                                                                                        $countPAC2 = "SELECT COUNT(cu_id) AS PECcount FROM product_payout WHERE cu_id='".$customer_id2."' ";
                                                                                                        $pecCount2 = $conn -> prepare($countPAC2);
                                                                                                        $pecCount2 -> execute();
                                                                                                        $pecCount2 -> setFetchMode(PDO::FETCH_ASSOC);
                                                                                                        if( $pecCount2 -> rowCount()>0 ){
                                                                                                            foreach( ($pecCount2 -> fetchAll()) as $keyPec2 => $rowPec2 ){
                                                                                                                $PecCount2 = $rowPec2['PECcount'];
                                                                                                    ?>
                                                                                                    <h5 class="mb-1"><?=$PecCount2?></h5>
                                                                                                    <?php
                                                                                                            }
                                                                                                        }
                                                                                                    ?>
                                                                                                    <p class="text-muted mb-0">Total Packages</p>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="col-lg-2 col-md-2 col-sm-6 col-6 py-2">
                                                                                            <h5 class="mb-1">Phone No</h5>
                                                                                            <p class="text-muted mb-0"><?=$referral6['contact_no']?></p>
                                                                                        </div>
                                                                                        <div class="col-lg-2 col-md-2 col-sm-6 col-6 py-2">
                                                                                            <div class="text-center">
                                                                                                <a href="#" onclick="overviewPage('<?= $referral6['ca_customer_id'] .','.  $referral6['reference_no'] . ',' .$referral6['country']. ',' .$referral6['state']. ',' .$referral6['city']. ',customer' ?>')" class="btn btn-primary view-btn">View Profile</a>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </button>
                                                                        <!-- cumtomer ref level 3 -->
                                                                        <div class="panel">
                                                                            <?php
                                                                                $stmt6 = $conn -> prepare(" SELECT * FROM ca_customer WHERE reference_no = ? AND status = '1' ORDER BY ca_customer_id ASC");
                                                                                $stmt6 -> execute([$customer_id2]);
                                                                                $referrals6 = $stmt6->fetchAll(PDO::FETCH_ASSOC);
                                                                                foreach($referrals6 as $referral6){
                                                                                    $customer_id3 = $referral6['ca_customer_id'];
                                                                            ?>
                                                                            <button class="accordion p-0">
                                                                                <div class="card mb-0 rounded-0">
                                                                                    <div class="card-body p-2">
                                                                                        <div class="row align-items-center">
                                                                                            <div class="col-lg-4 col-md-4 col-sm-12 col-12 py-2">
                                                                                                <div class="team-profile-img d-flex align-items-center justify-content-around">
                                                                                                    <div class="avatar-md img-thumbnail rounded float-start rounded-circle">
                                                                                                        <img src="../../uploading/<?=$referral6['profile_pic']?>" alt="" class="img-fluid d-block rounded-circle" />
                                                                                                    </div>
                                                                                                    <div>
                                                                                                        <a href="#" class="d-block">
                                                                                                            <h5 class="fs-5 mb-1"><?=$referral6['firstname'].' '.$referral6['lastname'].' '.$customer_id3?></h5>
                                                                                                        </a>
                                                                                                        <p class="text-muted mb-0">Customer</p>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="col-lg-4 col-md-4 col-sm-12 col-12 py-2">
                                                                                                <div class="row text-center">
                                                                                                    <div class="col-6 border-end">
                                                                                                        <?php
                                                                                                            $countCU2 = "SELECT COUNT(ca_customer_id) AS CATAcount FROM ca_customer WHERE reference_no='".$customer_id3."' ";
                                                                                                            $cuCount2 = $conn -> prepare($countCU2);
                                                                                                            $cuCount2 -> execute();
                                                                                                            $cuCount2 -> setFetchMode(PDO::FETCH_ASSOC);
                                                                                                            if( $cuCount2 -> rowCount()>0 ){
                                                                                                                foreach( ($cuCount2 -> fetchAll()) as $keycu2 => $rowcu2 ){
                                                                                                                    $cu2Count = $rowcu2['CATAcount'];
                                                                                                        ?>
                                                                                                        <h5 class="mb-1"><?=$cu2Count?></h5>
                                                                                                        <?php
                                                                                                                }
                                                                                                            }
                                                                                                        ?>
                                                                                                        <p class="text-muted mb-0">Total Refered Customers</p>
                                                                                                    </div>
                                                                                                    <div class="col-6">
                                                                                                        <?php
                                                                                                            $countPAC2 = "SELECT COUNT(cu_id) AS PECcount FROM product_payout WHERE cu_id='".$customer_id3."' ";
                                                                                                            $pecCount2 = $conn -> prepare($countPAC2);
                                                                                                            $pecCount2 -> execute();
                                                                                                            $pecCount2 -> setFetchMode(PDO::FETCH_ASSOC);
                                                                                                            if( $pecCount2 -> rowCount()>0 ){
                                                                                                                foreach( ($pecCount2 -> fetchAll()) as $keyPec2 => $rowPec2 ){
                                                                                                                    $PecCount2 = $rowPec2['PECcount'];
                                                                                                        ?>
                                                                                                        <h5 class="mb-1"><?=$PecCount2?></h5>
                                                                                                        <?php
                                                                                                                }
                                                                                                            }
                                                                                                        ?>
                                                                                                        <p class="text-muted mb-0">Total Packages</p>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="col-lg-2 col-md-2 col-sm-6 col-6 py-2">
                                                                                                <h5 class="mb-1">Phone No</h5>
                                                                                                <p class="text-muted mb-0"><?=$referral6['contact_no']?></p>
                                                                                            </div>
                                                                                            <div class="col-lg-2 col-md-2 col-sm-6 col-6 py-2">
                                                                                                <div class="text-center">
                                                                                                    <a href="#" onclick="overviewPage('<?= $referral6['ca_customer_id'] .','.  $referral6['reference_no'] . ',' .$referral6['country']. ',' .$referral6['state']. ',' .$referral6['city']. ',customer' ?>')" class="btn btn-primary view-btn">View Profile</a>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </button>
                                                                            <?php
                                                                                }
                                                                            ?>
                                                                        </div>
                                                                        <?php
                                                                            }
                                                                        ?>
                                                                        <!-- end cumtomer ref level 3 -->
                                                                    </div>
                                                                    <!-- end cumtomer ref level 2 -->
                                                                    <?php
                                                                        }
                                                                    ?>
                                                                </div>
                                                                <!-- end customer ref level 1 -->
                                                                <?php
                                                                    }
                                                                ?>
                                                            </div>
                                                         <!-- end all Customers onboarded by TC -->
                                                        <?php
                                                            }
                                                        ?>
                                                        <!-- end TC under the given TE -->
                                                        </div>
                                                    <?php
                                                        }
                                                    ?>
                                                    
                                                    
                                                    
                                                </div>
                                                <!-- end all BM and TE -->
                                             <?php 
                                            }
                                        }
                                    
                                    
                                    ?>
                                    <!-- end all bdms -->
                                     <!-- all bmds -->
                                    <?php
                                    } else if ($DBtable == 'business_developement_manager') {
                                        $stmt2 = $conn -> prepare(" SELECT * FROM business_mentor WHERE reference_no = ? AND status = '1' ORDER BY business_mentor_id ASC");
                                        $stmt2 -> execute([$id]);
                                        $stmt2 -> setFetchMode(PDO::FETCH_ASSOC);
                                        if($stmt2 -> rowCount() == 0){
                                    ?>

                                    <?php
                                        }else{

                                            $referrals2 = $stmt2->fetchAll();
                                           // print_r($stmt2);
                                            foreach($referrals2 as $referral2){
                                                $bms_id = $referral2['business_mentor_id']; 
                                        ?>
                                        <button class="accordion p-0">
                                            <div class="card mb-0 rounded-0">
                                                <div class="card-body p-2">
                                                    <div class="row align-items-center">
                                                        <div class="col-lg-4 col-md-4 col-sm-12 col-12 py-2">
                                                            <div class="team-profile-img d-flex align-items-center justify-content-around">
                                                                <div class="avatar-md img-thumbnail rounded float-start rounded-circle">
                                                                    <img src="../../uploading/<?=$referral2['profile_pic']?>" alt="" class="img-fluid d-block rounded-circle" />
                                                                </div>
                                                                <div>
                                                                    <a href="#" class="d-block">
                                                                        <h5 class="fs-5 mb-1"><?=$referral2['firstname'].' '.$referral2['lastname'].' '.$bms_id?></h5>
                                                                    </a>
                                                                    <p class="text-muted mb-0">Business Mentor</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4 col-md-4 col-sm-12 col-12 py-2">
                                                            <div class="row text-center">
                                                                <div class="col-6 border-end">
                                                                    <?php
                                                                        $countQuery1 = "SELECT 
                                                                                        (
                                                                                            SELECT COUNT(ca_travelagency_id) 
                                                                                            FROM ca_travelagency 
                                                                                            WHERE 
                                                                                                reference_no = :bms_id 
                                                                                                AND status = 1 
                                                                                                AND ca_travelagency_id IS NOT NULL 
                                                                                                AND ca_travelagency_id != ''
                                                                                        ) AS tacount,
                                                                                        (
                                                                                            SELECT COUNT(corporate_agency_id) 
                                                                                            FROM corporate_agency 
                                                                                            WHERE 
                                                                                                reference_no = :bms_id 
                                                                                                AND status = 1 
                                                                                                AND corporate_agency_id IS NOT NULL 
                                                                                                AND corporate_agency_id != ''
                                                                                        ) AS cacount";
    
                                                                        //$debugQuery = str_replace(':bdms_id', $bdms_id, $countQuery);
                                                                        //echo "<pre>Debug SQL:\n$debugQuery</pre>";  
                                                                        $stmt1_1 = $conn->prepare($countQuery1);
                                                                        $stmt1_1->bindParam(':bms_id', $bms_id, PDO::PARAM_STR);
                                                                        $stmt1_1->execute();
                                                                        
                                                                        if ($stmt1_1->rowCount() > 0) {
                                                                            $results1_1 = $stmt1_1->fetchAll(PDO::FETCH_ASSOC);
                                                                            //print_r($results1_1); // ✅ This will show the actual result array
    
                                                                            foreach ($results1_1 as $row) {
                                                                                $TACount = (int)$row['tacount'];
                                                                                $CACount = (int)$row['cacount'];
                                                                                $total_bm_mem = $TACount + $CACount; 
                                                                                echo "<script>
                                                                                        console.log('total bm mem count:".$total_bm_mem." of ".$bms_id."');
                                                                                    </script>";
                                                                    
                                                                    ?>
                                                                    <h5 class="mb-1"><?=$total_bm_mem?></h5>
                                                                    <?php
                                                                            }
                                                                        }
                                                                    ?>
                                                                    <p class="text-muted mb-0">Total Team Member</p>
                                                                </div>
                                                                <div class="col-6">
                                                                    <?php
                                                                        $countPAC1 = "SELECT COUNT(bdm_id) AS PECcount FROM product_payout WHERE bm_id='".$bms_id."' ";
                                                                        $pecCount1 = $conn -> prepare($countPAC1);
                                                                        $pecCount1 -> execute();
                                                                        $pecCount1 -> setFetchMode(PDO::FETCH_ASSOC);
                                                                        if( $pecCount1 -> rowCount()>0 ){
                                                                            foreach( ($pecCount1 -> fetchAll()) as $keyPec => $rowPec ){
                                                                                $PecCount1 = $rowPec['PECcount'];
                                                                    ?>
                                                                    <h5 class="mb-1"><?=$PecCount1?></h5>
                                                                    <?php
                                                                            }
                                                                        }
                                                                    ?>
                                                                    <p class="text-muted mb-0">Total Packages</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-2 col-md-2 col-sm-6 col-6 py-2">
                                                            <h5 class="mb-1">Phone No</h5>
                                                            <p class="text-muted mb-0"><?=$referral2['contact_no']?></p>
                                                        </div>
                                                        <div class="col-lg-2 col-md-2 col-sm-6 col-6 py-2">
                                                            <div class="text-center">
                                                                <a href="#" onclick="overviewPage('<?= $referral2['business_mentor_id'] .  $referral2['reference_no'] . ',' .$referral2['country']. ',' .$referral2['state']. ',' .$referral2['city']. ',business_mentor' ?>')" class="btn btn-primary view-btn">View Profile</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </button>
                                        <!-- all TE under given BM -->
                                        <div class="panel">
                                            <?php
                                                $stmt2_3 = $conn -> prepare(" SELECT * FROM corporate_agency WHERE reference_no = ? AND status = '1' ORDER BY corporate_agency_id ASC");
                                                $stmt2_3 -> execute([$bms_id]);
                                                $referrals2_3 = $stmt2_3->fetchAll(PDO::FETCH_ASSOC);
                                                foreach($referrals2_3 as $referral2){
                                                    $cas_id = $referral2['corporate_agency_id'];
                                            ?>
                                            <button class="accordion p-0">
                                                <div class="card mb-0 rounded-0">
                                                    <div class="card-body p-2">
                                                        <div class="row align-items-center">
                                                            <div class="col-lg-4 col-md-4 col-sm-12 col-12 py-2">
                                                                <div class="team-profile-img d-flex align-items-center justify-content-around">
                                                                    <div class="avatar-md img-thumbnail rounded float-start rounded-circle">
                                                                        <img src="../../uploading/<?=$referral2['profile_pic']?>" alt="" class="img-fluid d-block rounded-circle" />
                                                                    </div>
                                                                    <div>
                                                                        <a href="#" class="d-block">
                                                                            <h5 class="fs-5 mb-1"><?=$referral2['firstname'].' '.$referral2['lastname'].' '.$cas_id?></h5>
                                                                        </a>
                                                                        <p class="text-muted mb-0">Techno Enterprise</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4 col-md-4 col-sm-12 col-12 py-2">
                                                                <div class="row text-center">
                                                                    <div class="col-6 border-end">
                                                                        <?php
                                                                            $countCATA2_3 = "SELECT COUNT(ca_travelagency_id) AS CATAcount FROM ca_travelagency WHERE reference_no='".$cas_id."' ";
                                                                            $cataCount2_3 = $conn -> prepare($countCATA2_3);
                                                                            $cataCount2_3 -> execute();
                                                                            $cataCount2_3 -> setFetchMode(PDO::FETCH_ASSOC);
                                                                            if( $cataCount2_3 -> rowCount()>0 ){
                                                                                foreach( ($cataCount2_3 -> fetchAll()) as $keyCATA => $rowCATA ){
                                                                                    $CATACount3 = $rowCATA['CATAcount']; 
                                                                        ?>
                                                                        <h5 class="mb-1"><?=$CATACount3?></h5>
                                                                        <?php
                                                                                }
                                                                            }
                                                                        ?>
                                                                        <p class="text-muted mb-0">Total Team Member</p>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <?php
                                                                            $countPAC2_3 = "SELECT COUNT(te_id) AS PECcount FROM product_payout WHERE te_id='".$cas_id."' ";
                                                                            $pecCount2_3 = $conn -> prepare($countPAC2_3);
                                                                            $pecCount2_3 -> execute();
                                                                            $pecCount2_3 -> setFetchMode(PDO::FETCH_ASSOC);
                                                                            if( $pecCount2_3 -> rowCount()>0 ){
                                                                                foreach( ($pecCount2_3 -> fetchAll()) as $keyPec => $rowPec ){
                                                                                    $PecCount2_3 = $rowPec['PECcount'];
                                                                        ?>
                                                                        <h5 class="mb-1"><?=$PecCount2_3?></h5>
                                                                        <?php
                                                                                }
                                                                            }
                                                                        ?>
                                                                        <p class="text-muted mb-0">Total Packages</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-2 col-md-2 col-sm-6 col-6 py-2">
                                                                <h5 class="mb-1">Phone No</h5>
                                                                <p class="text-muted mb-0"><?=$referral2['contact_no']?></p>
                                                            </div>
                                                            <div class="col-lg-2 col-md-2 col-sm-6 col-6 py-2">
                                                                <div class="text-center">
                                                                    <a href="#" onclick="overviewPage('<?= $referral2['corporate_agency_id'] .','.  $referral2['reference_no'] . ',' .$referral2['country']. ',' .$referral2['state']. ',' .$referral2['city']. ',corporate_agency' ?>')" class="btn btn-primary view-btn">View Profile</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </button>
                                            <!-- all TC recruted by TE -->
                                            <div class="panel">
                                                <?php
                                                    $stmt3 = $conn -> prepare(" SELECT * FROM ca_travelagency WHERE reference_no = ? AND status = '1' ORDER BY ca_travelagency_id ASC");
                                                    $stmt3 -> execute([$cas_id]);
                                                    $referrals3 = $stmt3->fetchAll(PDO::FETCH_ASSOC);
                                                    foreach($referrals3 as $referral3){
                                                        $catas_id = $referral3['ca_travelagency_id'];
                                                ?>
                                                <button class="accordion p-0">
                                                    <div class="card mb-0 rounded-0">
                                                        <div class="card-body p-2">
                                                            <div class="row align-items-center">
                                                                <div class="col-lg-4 col-md-4 col-sm-12 col-12 py-2">
                                                                    <div class="team-profile-img d-flex align-items-center justify-content-around">
                                                                        <div class="avatar-md img-thumbnail rounded float-start rounded-circle">
                                                                            <img src="../../uploading/<?=$referral3['profile_pic']?>" alt="" class="img-fluid d-block rounded-circle" />
                                                                        </div>
                                                                        <div>
                                                                            <a href="#" class="d-block">
                                                                                <h5 class="fs-5 mb-1"><?=$referral3['firstname'].' '.$referral3['lastname'].' '.$catas_id?></h5>
                                                                            </a>
                                                                            <p class="text-muted mb-0">Travel Consultant</p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-4 col-md-4 col-sm-12 col-12 py-2">
                                                                    <div class="row text-center">
                                                                        <div class="col-6 border-end">
                                                                            <?php
                                                                                $countCACU = "SELECT COUNT(ca_customer_id) AS CACUcount FROM ca_customer WHERE ta_reference_no='".$catas_id."' ";
                                                                                $cacuCount = $conn -> prepare($countCACU);
                                                                                $cacuCount -> execute();
                                                                                $cacuCount -> setFetchMode(PDO::FETCH_ASSOC);
                                                                                if( $cacuCount -> rowCount()>0 ){
                                                                                    foreach( ($cacuCount -> fetchAll()) as $keyCACU => $rowCACU ){
                                                                                        $CACUCount = $rowCACU['CACUcount'];
                                                                            ?>
                                                                            <h5 class="mb-1"><?= $CACUCount ?></h5>
                                                                            <?php
                                                                                    }
                                                                                }
                                                                            ?>
                                                                            <p class="text-muted mb-0">Total Team Member</p>
                                                                        </div>
                                                                        <div class="col-6">
                                                                            <?php
                                                                                $countPAC = "SELECT COUNT(ta_id) AS PECcount FROM product_payout WHERE ta_id='".$catas_id."' ";
                                                                                $pecCount = $conn -> prepare($countPAC);
                                                                                $pecCount -> execute();
                                                                                $pecCount -> setFetchMode(PDO::FETCH_ASSOC);
                                                                                if( $pecCount -> rowCount()>0 ){
                                                                                    foreach( ($pecCount -> fetchAll()) as $keyPec => $rowPec ){
                                                                                        $PecCount = $rowPec['PECcount'];
                                                                            ?>
                                                                            <h5 class="mb-1"><?=$PecCount?></h5>
                                                                            <?php
                                                                                    }
                                                                                }
                                                                            ?>
                                                                            <p class="text-muted mb-0">Total Packages</p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-2 col-md-2 col-sm-6 col-6 py-2">
                                                                    <h5 class="mb-1">Phone No</h5>
                                                                    <p class="text-muted mb-0"><?php $referral3['contact_no'] ?></p>
                                                                </div>
                                                                <div class="col-lg-2 col-md-2 col-sm-6 col-6 py-2">
                                                                    <div class="text-center">
                                                                        <a href="#" onclick="overviewPage('<?= $referral3['ca_travelagency_id'] .','.  $referral3['reference_no'] . ',' .$referral3['country']. ',' .$referral3['state']. ',' .$referral3['city']. ',travel_consultant' ?>')" class="btn btn-primary view-btn">View Profile</a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </button>
                                                <!-- all Customers onboarded by TC -->
                                                <div class="panel">
                                                    <?php
                                                        $stmt4 = $conn -> prepare(" SELECT * FROM ca_customer WHERE ta_reference_no = ? AND reference_no IS NUll AND status = '1' ORDER BY ca_customer_id ASC");
                                                        $stmt4 -> execute([$catas_id]);
                                                        $referrals4 = $stmt4->fetchAll(PDO::FETCH_ASSOC);
                                                        foreach($referrals4 as $referral4){
                                                            $cacus_id = $referral4['ca_customer_id'];
                                                    ?>
                                                    <button class="accordion p-0">
                                                        <div class="card mb-0 rounded-0">
                                                            <div class="card-body p-2">
                                                                <div class="row align-items-center">
                                                                    <div class="col-lg-4 col-md-4 col-sm-12 col-12 py-2">
                                                                        <div class="team-profile-img d-flex align-items-center justify-content-around">
                                                                            <div class="avatar-md img-thumbnail rounded float-start rounded-circle">
                                                                                <img src="../../uploading/<?=$referral4['profile_pic']?>" alt="" class="img-fluid d-block rounded-circle" />
                                                                            </div>
                                                                            <div>
                                                                                <a href="#" class="d-block">
                                                                                    <h5 class="fs-5 mb-1"><?=$referral4['firstname'].' '.$referral4['lastname'].' '.$cacus_id?></h5>
                                                                                </a>
                                                                                <p class="text-muted mb-0">Customer</p>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-4 col-md-4 col-sm-12 col-12 py-2">
                                                                        <div class="row text-center">
                                                                            <div class="col-6 border-end">
                                                                                <?php
                                                                                    $countCATACU = "SELECT COUNT(ca_customer_id) AS CATACUcount FROM ca_customer WHERE reference_no='".$cacus_id."' ";
                                                                                    $catacuCount = $conn -> prepare($countCATACU);
                                                                                    $catacuCount -> execute();
                                                                                    $catacuCount -> setFetchMode(PDO::FETCH_ASSOC);
                                                                                    if( $catacuCount -> rowCount()>0 ){
                                                                                        foreach( ($catacuCount -> fetchAll()) as $keyCATACU => $rowCATACU ){
                                                                                            $CATACUCount = $rowCATACU['CATACUcount'];
                                                                                ?>
                                                                                <h5 class="mb-1"><?=$CATACUCount?></h5>
                                                                                <?php
                                                                                        }
                                                                                    }
                                                                                ?>
                                                                                <p class="text-muted mb-0">Total Refered Customers</p>
                                                                            </div>
                                                                            <div class="col-6">
                                                                                <?php
                                                                                    $countPAC = "SELECT COUNT(cu_id) AS PECcount FROM product_payout WHERE cu_id='".$cacus_id."' ";
                                                                                    $pecCount = $conn -> prepare($countPAC);
                                                                                    $pecCount -> execute();
                                                                                    $pecCount -> setFetchMode(PDO::FETCH_ASSOC);
                                                                                    if( $pecCount -> rowCount()>0 ){
                                                                                        foreach( ($pecCount -> fetchAll()) as $keyPec => $rowPec ){
                                                                                            $PecCount = $rowPec['PECcount'];
                                                                                ?>
                                                                                <h5 class="mb-1"><?=$PecCount?></h5>
                                                                                <?php
                                                                                        }
                                                                                    }
                                                                                ?>
                                                                                <p class="text-muted mb-0">Total Packages</p>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-2 col-md-2 col-sm-6 col-6 py-2">
                                                                        <h5 class="mb-1">Phone No</h5>
                                                                        <p class="text-muted mb-0"><?=$referral4['contact_no']?></p>
                                                                    </div>
                                                                    <div class="col-lg-2 col-md-2 col-sm-6 col-6 py-2">
                                                                        <div class="text-center">
                                                                            <a href="#" onclick="overviewPage('<?= $referral4['ca_customer_id'] .','.  $referral4['reference_no'] . ',' .$referral4['country']. ',' .$referral4['state']. ',' .$referral4['city']. ',customer' ?>')" class="btn btn-primary view-btn">View Profile</a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </button>
                                                    <!-- customer ref level 1 -->
                                                    <div class="panel">
                                                        <?php
                                                            $stmt5 = $conn -> prepare(" SELECT * FROM ca_customer WHERE reference_no = ? AND status = '1' ORDER BY ca_customer_id ASC");
                                                            $stmt5 -> execute([$cacus_id]);
                                                            $referrals5 = $stmt5->fetchAll(PDO::FETCH_ASSOC);
                                                            foreach($referrals5 as $referral5){
                                                                $customer_id = $referral5['ca_customer_id'];
                                                        ?>
                                                        <button class="accordion p-0">
                                                            <div class="card mb-0 rounded-0">
                                                                <div class="card-body p-2">
                                                                    <div class="row align-items-center">
                                                                        <div class="col-lg-4 col-md-4 col-sm-12 col-12 py-2">
                                                                            <div class="team-profile-img d-flex align-items-center justify-content-around">
                                                                                <div class="avatar-md img-thumbnail rounded float-start rounded-circle">
                                                                                    <img src="../../uploading/<?=$referral5['profile_pic']?>" alt="" class="img-fluid d-block rounded-circle" />
                                                                                </div>
                                                                                <div>
                                                                                    <a href="#" class="d-block">
                                                                                        <h5 class="fs-5 mb-1"><?=$referral5['firstname'].' '.$referral5['lastname'].' '.$customer_id?></h5>
                                                                                    </a>
                                                                                    <p class="text-muted mb-0">Customer</p>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-4 col-md-4 col-sm-12 col-12 py-2">
                                                                            <div class="row text-center">
                                                                                <div class="col-6 border-end">
                                                                                    <?php
                                                                                        $countCU = "SELECT COUNT(ca_customer_id) AS CATAcount FROM ca_customer WHERE reference_no='".$customer_id."' ";
                                                                                        $cuCount = $conn -> prepare($countCU);
                                                                                        $cuCount -> execute();
                                                                                        $cuCount -> setFetchMode(PDO::FETCH_ASSOC);
                                                                                        if( $cuCount -> rowCount()>0 ){
                                                                                            foreach( ($cuCount -> fetchAll()) as $keycu => $rowcu ){
                                                                                                $cuCount = $rowcu['CATAcount'];
                                                                                    ?>
                                                                                    <h5 class="mb-1"><?=$cuCount?></h5>
                                                                                    <?php
                                                                                            }
                                                                                        }
                                                                                    ?>
                                                                                    <p class="text-muted mb-0">Total Refered Customers</p>
                                                                                </div>
                                                                                <div class="col-6">
                                                                                    <?php
                                                                                        $countPAC = "SELECT COUNT(cu_id) AS PECcount FROM product_payout WHERE cu_id='".$customer_id."' ";
                                                                                        $pecCount = $conn -> prepare($countPAC);
                                                                                        $pecCount -> execute();
                                                                                        $pecCount -> setFetchMode(PDO::FETCH_ASSOC);
                                                                                        if( $pecCount -> rowCount()>0 ){
                                                                                            foreach( ($pecCount -> fetchAll()) as $keyPec => $rowPec ){
                                                                                                $PecCount = $rowPec['PECcount'];
                                                                                    ?>
                                                                                    <h5 class="mb-1">20</h5>
                                                                                    <?php
                                                                                            }
                                                                                        }
                                                                                    ?>
                                                                                    <p class="text-muted mb-0">Total Packages</p>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-2 col-md-2 col-sm-6 col-6 py-2">
                                                                            <h5 class="mb-1">Phone No</h5>
                                                                            <p class="text-muted mb-0"><?=$referral5['contact_no']?></p>
                                                                        </div>
                                                                        <div class="col-lg-2 col-md-2 col-sm-6 col-6 py-2">
                                                                            <div class="text-center">
                                                                                <a href="#" onclick="overviewPage('<?= $referral5['ca_customer_id'] .','.  $referral5['reference_no'] . ',' .$referral5['country']. ',' .$referral5['state']. ',' .$referral5['city']. ',customer' ?>')" class="btn btn-primary view-btn">View Profile</a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </button>
                                                        <!-- cumtomer ref level 2 -->
                                                        <div class="panel">
                                                            <?php
                                                                $stmt6 = $conn -> prepare(" SELECT * FROM ca_customer WHERE reference_no = ? AND status = '1' ORDER BY ca_customer_id ASC");
                                                                $stmt6 -> execute([$customer_id]);
                                                                $referrals6 = $stmt6->fetchAll(PDO::FETCH_ASSOC);
                                                                foreach($referrals6 as $referral6){
                                                                    $customer_id2 = $referral6['ca_customer_id'];
                                                            ?>
                                                            <button class="accordion p-0">
                                                                <div class="card mb-0 rounded-0">
                                                                    <div class="card-body p-2">
                                                                        <div class="row align-items-center">
                                                                            <div class="col-lg-4 col-md-4 col-sm-12 col-12 py-2">
                                                                                <div class="team-profile-img d-flex align-items-center justify-content-around">
                                                                                    <div class="avatar-md img-thumbnail rounded float-start rounded-circle">
                                                                                        <img src="../../uploading/<?=$referral6['profile_pic']?>" alt="" class="img-fluid d-block rounded-circle" />
                                                                                    </div>
                                                                                    <div>
                                                                                        <a href="#" class="d-block">
                                                                                            <h5 class="fs-5 mb-1"><?=$referral6['firstname'].' '.$referral6['lastname'].' '.$customer_id2?></h5>
                                                                                        </a>
                                                                                        <p class="text-muted mb-0">Customer</p>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-lg-4 col-md-4 col-sm-12 col-12 py-2">
                                                                                <div class="row text-center">
                                                                                    <div class="col-6 border-end">
                                                                                        <?php
                                                                                            $countCU2 = "SELECT COUNT(ca_customer_id) AS CATAcount FROM ca_customer WHERE reference_no='".$customer_id2."' ";
                                                                                            $cuCount2 = $conn -> prepare($countCU2);
                                                                                            $cuCount2 -> execute();
                                                                                            $cuCount2 -> setFetchMode(PDO::FETCH_ASSOC);
                                                                                            if( $cuCount2 -> rowCount()>0 ){
                                                                                                foreach( ($cuCount2 -> fetchAll()) as $keycu2 => $rowcu2 ){
                                                                                                    $cu2Count = $rowcu2['CATAcount'];
                                                                                        ?>
                                                                                        <h5 class="mb-1"><?= $cu2Count?></h5>
                                                                                        <?php
                                                                                                }
                                                                                            }
                                                                                        ?>
                                                                                        <p class="text-muted mb-0">Total Refered Customers</p>
                                                                                    </div>
                                                                                    <div class="col-6">
                                                                                        <?php
                                                                                            $countPAC2 = "SELECT COUNT(cu_id) AS PECcount FROM product_payout WHERE cu_id='".$customer_id2."' ";
                                                                                            $pecCount2 = $conn -> prepare($countPAC2);
                                                                                            $pecCount2 -> execute();
                                                                                            $pecCount2 -> setFetchMode(PDO::FETCH_ASSOC);
                                                                                            if( $pecCount2 -> rowCount()>0 ){
                                                                                                foreach( ($pecCount2 -> fetchAll()) as $keyPec2 => $rowPec2 ){
                                                                                                    $PecCount2 = $rowPec2['PECcount'];
                                                                                        ?>
                                                                                        <h5 class="mb-1"><?=$PecCount2?></h5>
                                                                                        <?php
                                                                                                }
                                                                                            }
                                                                                        ?>
                                                                                        <p class="text-muted mb-0">Total Packages</p>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-lg-2 col-md-2 col-sm-6 col-6 py-2">
                                                                                <h5 class="mb-1">Phone No</h5>
                                                                                <p class="text-muted mb-0"><?=$referral6['contact_no']?></p>
                                                                            </div>
                                                                            <div class="col-lg-2 col-md-2 col-sm-6 col-6 py-2">
                                                                                <div class="text-center">
                                                                                    <a href="#" onclick="overviewPage('<?= $referral6['ca_customer_id'] .','.  $referral6['reference_no'] . ',' .$referral6['country']. ',' .$referral6['state']. ',' .$referral6['city']. ',customer' ?>')" class="btn btn-primary view-btn">View Profile</a>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </button>
                                                            <!-- cumtomer ref level 3 -->
                                                            <div class="panel">
                                                                <?php
                                                                    $stmt6 = $conn -> prepare(" SELECT * FROM ca_customer WHERE reference_no = ? AND status = '1' ORDER BY ca_customer_id ASC");
                                                                    $stmt6 -> execute([$customer_id2]);
                                                                    $referrals6 = $stmt6->fetchAll(PDO::FETCH_ASSOC);
                                                                    foreach($referrals6 as $referral6){
                                                                        $customer_id3 = $referral6['ca_customer_id'];
                                                                ?>
                                                                <button class="accordion p-0">
                                                                    <div class="card mb-0 rounded-0">
                                                                        <div class="card-body p-2">
                                                                            <div class="row align-items-center">
                                                                                <div class="col-lg-4 col-md-4 col-sm-12 col-12 py-2">
                                                                                    <div class="team-profile-img d-flex align-items-center justify-content-around">
                                                                                        <div class="avatar-md img-thumbnail rounded float-start rounded-circle">
                                                                                            <img src="../../uploading/<?=$referral6['profile_pic']?>" alt="" class="img-fluid d-block rounded-circle" />
                                                                                        </div>
                                                                                        <div>
                                                                                            <a href="#" class="d-block">
                                                                                                <h5 class="fs-5 mb-1"><?=$referral6['firstname'].' '.$referral6['lastname'].' '.$customer_id3?></h5>
                                                                                            </a>
                                                                                            <p class="text-muted mb-0">Customer</p>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-lg-4 col-md-4 col-sm-12 col-12 py-2">
                                                                                    <div class="row text-center">
                                                                                        <div class="col-6 border-end">
                                                                                            <?php
                                                                                                $countCU2 = "SELECT COUNT(ca_customer_id) AS CATAcount FROM ca_customer WHERE reference_no='".$customer_id3."' ";
                                                                                                $cuCount2 = $conn -> prepare($countCU2);
                                                                                                $cuCount2 -> execute();
                                                                                                $cuCount2 -> setFetchMode(PDO::FETCH_ASSOC);
                                                                                                if( $cuCount2 -> rowCount()>0 ){
                                                                                                    foreach( ($cuCount2 -> fetchAll()) as $keycu2 => $rowcu2 ){
                                                                                                        $cu2Count = $rowcu2['CATAcount'];
                                                                                            ?>
                                                                                            <h5 class="mb-1"><?=$cu2Count?></h5>
                                                                                            <?php
                                                                                                    }
                                                                                                }
                                                                                            ?>
                                                                                            <p class="text-muted mb-0">Total Refered Customers</p>
                                                                                        </div>
                                                                                        <div class="col-6">
                                                                                            <?php
                                                                                                $countPAC2 = "SELECT COUNT(cu_id) AS PECcount FROM product_payout WHERE cu_id='".$customer_id3."' ";
                                                                                                $pecCount2 = $conn -> prepare($countPAC2);
                                                                                                $pecCount2 -> execute();
                                                                                                $pecCount2 -> setFetchMode(PDO::FETCH_ASSOC);
                                                                                                if( $pecCount2 -> rowCount()>0 ){
                                                                                                    foreach( ($pecCount2 -> fetchAll()) as $keyPec2 => $rowPec2 ){
                                                                                                        $PecCount2 = $rowPec2['PECcount'];
                                                                                            ?>
                                                                                            <h5 class="mb-1"><?=$PecCount2?></h5>
                                                                                            <?php
                                                                                                    }
                                                                                                }
                                                                                            ?>
                                                                                            <p class="text-muted mb-0">Total Packages</p>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-lg-2 col-md-2 col-sm-6 col-6 py-2">
                                                                                    <h5 class="mb-1">Phone No</h5>
                                                                                    <p class="text-muted mb-0"><?=$referral6['contact_no']?></p>
                                                                                </div>
                                                                                <div class="col-lg-2 col-md-2 col-sm-6 col-6 py-2">
                                                                                    <div class="text-center">
                                                                                        <a href="#" onclick="overviewPage('<?= $referral6['ca_customer_id'] .','.  $referral6['reference_no'] . ',' .$referral6['country']. ',' .$referral6['state']. ',' .$referral6['city']. ',customer' ?>')" class="btn btn-primary view-btn">View Profile</a>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </button>
                                                                <?php
                                                                    }
                                                                ?>
                                                            </div>
                                                            <?php
                                                                }
                                                            ?>
                                                            <!-- end cumtomer ref level 3 -->
                                                        </div>
                                                        <!-- end cumtomer ref level 2 -->
                                                        <?php
                                                            }
                                                        ?>
                                                    </div>
                                                    <!-- end customer ref level 1 -->
                                                    <?php
                                                        }
                                                    ?>
                                                </div>
                                                <!-- end all Customers onboarded by TC -->
                                                <?php
                                                    }
                                                ?>
                                            </div>
                                            <!-- end all TC recruted by TE -->
                                            <?php
                                                }
                                            ?>
                                            <!-- TC recruted by BM -->
                                            <?php
                                                $stmt2_3 = $conn -> prepare(" SELECT * FROM ca_travelagency WHERE reference_no = ? AND status = '1' ORDER BY ca_travelagency_id ASC");
                                                $stmt2_3 -> execute([$bms_id]);
                                                $referrals2_3 = $stmt2_3->fetchAll(PDO::FETCH_ASSOC);
                                                foreach($referrals2_3 as $referral2){
                                                    $cas_id = $referral2['ca_travelagency_id'];
                                            ?>
                                            <button class="accordion p-0">
                                                <div class="card mb-0 rounded-0">
                                                    <div class="card-body p-2">
                                                        <div class="row align-items-center">
                                                            <div class="col-lg-4 col-md-4 col-sm-12 col-12 py-2">
                                                                <div class="team-profile-img d-flex align-items-center justify-content-around">
                                                                    <div class="avatar-md img-thumbnail rounded float-start rounded-circle">
                                                                        <img src="../../uploading/<?=$referral2['profile_pic']?>" alt="" class="img-fluid d-block rounded-circle" />
                                                                    </div>
                                                                    <div>
                                                                        <a href="#" class="d-block">
                                                                            <h5 class="fs-5 mb-1"><?=$referral2['firstname'].' '.$referral2['lastname'].' '.$cas_id?></h5>
                                                                        </a>
                                                                        <p class="text-muted mb-0">Travel Consultant</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4 col-md-4 col-sm-12 col-12 py-2">
                                                                <div class="row text-center">
                                                                    <div class="col-6 border-end">
                                                                        <?php
                                                                            $countCACU2 = "SELECT COUNT(ca_customer_id) AS CACUcount FROM ca_customer WHERE ta_reference_no='".$cas_id."' ";
                                                                            $cacuCount2 = $conn -> prepare($countCACU2);
                                                                            $cacuCount2 -> execute();
                                                                            $cacuCount2 -> setFetchMode(PDO::FETCH_ASSOC);
                                                                            if( $cacuCount2 -> rowCount()>0 ){
                                                                                foreach( ($cacuCount2 -> fetchAll()) as $keyCACU => $rowCACU ){
                                                                                    $CACUCount2 = $rowCACU['CACUcount'];
                                                                        ?>
                                                                        <h5 class="mb-1"><?=$CACUCount2?></h5>
                                                                        <?php
                                                                                }
                                                                            }
                                                                        ?>
                                                                        <p class="text-muted mb-0">Total Team Member</p>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <?php
                                                                            $countPAC3 = "SELECT COUNT(ta_id) AS PECcount FROM product_payout WHERE ta_id='".$cas_id."' ";
                                                                            $pecCount3 = $conn -> prepare($countPAC3);
                                                                            $pecCount3 -> execute();
                                                                            $pecCount3 -> setFetchMode(PDO::FETCH_ASSOC);
                                                                            if( $pecCount3 -> rowCount()>0 ){
                                                                                foreach( ($pecCount3 -> fetchAll()) as $keyPec => $rowPec ){
                                                                                    $PecCount3 = $rowPec['PECcount'];
                                                                        ?>
                                                                        <h5 class="mb-1"><?=$PecCount3?></h5>
                                                                        <?php
                                                                                }
                                                                            }
                                                                        ?>
                                                                        <p class="text-muted mb-0">Total Packages</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-2 col-md-2 col-sm-6 col-6 py-2">
                                                                <h5 class="mb-1">Phone No</h5>
                                                                <p class="text-muted mb-0"><?=$referral2['contact_no']?></p>
                                                            </div>
                                                            <div class="col-lg-2 col-md-2 col-sm-6 col-6 py-2">
                                                                <div class="text-center">
                                                                    <a href="#" onclick="overviewPage('<?= $referral2['ca_travelagency_id'] .','.  $referral2['reference_no'] . ',' .$referral2['country']. ',' .$referral2['state']. ',' .$referral2['city']. ',travel_consultant' ?>')" class="btn btn-primary view-btn">View Profile</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </button>
                                            <!-- all Customers onboarded by TC -->
                                                <div class="panel">
                                                    <?php
                                                        $stmt4 = $conn -> prepare(" SELECT * FROM ca_customer WHERE ta_reference_no = ? AND reference_no IS NUll AND status = '1' ORDER BY ca_customer_id ASC");
                                                        $stmt4 -> execute([$cas_id]);
                                                        $referrals4 = $stmt4->fetchAll(PDO::FETCH_ASSOC);
                                                        foreach($referrals4 as $referral4){
                                                            $cacus_id = $referral4['ca_customer_id'];
                                                    ?>
                                                    <button class="accordion p-0">
                                                        <div class="card mb-0 rounded-0">
                                                            <div class="card-body p-2">
                                                                <div class="row align-items-center">
                                                                    <div class="col-lg-4 col-md-4 col-sm-12 col-12 py-2">
                                                                        <div class="team-profile-img d-flex align-items-center justify-content-around">
                                                                            <div class="avatar-md img-thumbnail rounded float-start rounded-circle">
                                                                                <img src="../../uploading/<?=$referral4['profile_pic']?>" alt="" class="img-fluid d-block rounded-circle" />
                                                                            </div>
                                                                            <div>
                                                                                <a href="#" class="d-block">
                                                                                    <h5 class="fs-5 mb-1"><?=$referral4['firstname'].' '.$referral4['lastname'].' '.$cacus_id?></h5>
                                                                                </a>
                                                                                <p class="text-muted mb-0">Customer</p>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-4 col-md-4 col-sm-12 col-12 py-2">
                                                                        <div class="row text-center">
                                                                            <div class="col-6 border-end">
                                                                                <?php
                                                                                    $countCATACU = "SELECT COUNT(ca_customer_id) AS CATACUcount FROM ca_customer WHERE reference_no='".$cacus_id."' ";
                                                                                    $catacuCount = $conn -> prepare($countCATACU);
                                                                                    $catacuCount -> execute();
                                                                                    $catacuCount -> setFetchMode(PDO::FETCH_ASSOC);
                                                                                    if( $catacuCount -> rowCount()>0 ){
                                                                                        foreach( ($catacuCount -> fetchAll()) as $keyCATACU => $rowCATACU ){
                                                                                            $CATACUCount = $rowCATACU['CATACUcount'];
                                                                                ?>
                                                                                <h5 class="mb-1"><?=$CATACUCount?></h5>
                                                                                <?php
                                                                                        }
                                                                                    }
                                                                                ?>
                                                                                <p class="text-muted mb-0">Total Refered Customers</p>
                                                                            </div>
                                                                            <div class="col-6">
                                                                                <?php
                                                                                    $countPAC = "SELECT COUNT(cu_id) AS PECcount FROM product_payout WHERE cu_id='".$cacus_id."' ";
                                                                                    $pecCount = $conn -> prepare($countPAC);
                                                                                    $pecCount -> execute();
                                                                                    $pecCount -> setFetchMode(PDO::FETCH_ASSOC);
                                                                                    if( $pecCount -> rowCount()>0 ){
                                                                                        foreach( ($pecCount -> fetchAll()) as $keyPec => $rowPec ){
                                                                                            $PecCount = $rowPec['PECcount'];
                                                                                ?>
                                                                                <h5 class="mb-1"><?=$PecCount?></h5>
                                                                                <?php
                                                                                        }
                                                                                    }
                                                                                ?>
                                                                                <p class="text-muted mb-0">Total Packages</p>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-2 col-md-2 col-sm-6 col-6 py-2">
                                                                        <h5 class="mb-1">Phone No</h5>
                                                                        <p class="text-muted mb-0"><?=$referral4['contact_no']?></p>
                                                                    </div>
                                                                    <div class="col-lg-2 col-md-2 col-sm-6 col-6 py-2">
                                                                        <div class="text-center">
                                                                            <a href="#" onclick="overviewPage('<?= $referral4['ca_customer_id'] .','.  $referral4['reference_no'] . ',' .$referral4['country']. ',' .$referral4['state']. ',' .$referral4['city']. ',customer' ?>')" class="btn btn-primary view-btn">View Profile</a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </button>
                                                    <!-- customer ref level 1 -->
                                                    <div class="panel">
                                                        <?php
                                                            $stmt5 = $conn -> prepare(" SELECT * FROM ca_customer WHERE reference_no = ? AND status = '1' ORDER BY ca_customer_id ASC");
                                                            $stmt5 -> execute([$cacus_id]);
                                                            $referrals5 = $stmt5->fetchAll(PDO::FETCH_ASSOC);
                                                            foreach($referrals5 as $referral5){
                                                                $customer_id = $referral5['ca_customer_id'];
                                                        ?>
                                                        <button class="accordion p-0">
                                                            <div class="card mb-0 rounded-0">
                                                                <div class="card-body p-2">
                                                                    <div class="row align-items-center">
                                                                        <div class="col-lg-4 col-md-4 col-sm-12 col-12 py-2">
                                                                            <div class="team-profile-img d-flex align-items-center justify-content-around">
                                                                                <div class="avatar-md img-thumbnail rounded float-start rounded-circle">
                                                                                    <img src="../../uploading/<?=$referral5['profile_pic']?>" alt="" class="img-fluid d-block rounded-circle" />
                                                                                </div>
                                                                                <div>
                                                                                    <a href="#" class="d-block">
                                                                                        <h5 class="fs-5 mb-1"><?=$referral5['firstname'].' '.$referral5['lastname'].' '.$customer_id?></h5>
                                                                                    </a>
                                                                                    <p class="text-muted mb-0">Customer</p>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-4 col-md-4 col-sm-12 col-12 py-2">
                                                                            <div class="row text-center">
                                                                                <div class="col-6 border-end">
                                                                                    <?php
                                                                                        $countCU = "SELECT COUNT(ca_customer_id) AS CATAcount FROM ca_customer WHERE reference_no='".$customer_id."' ";
                                                                                        $cuCount = $conn -> prepare($countCU);
                                                                                        $cuCount -> execute();
                                                                                        $cuCount -> setFetchMode(PDO::FETCH_ASSOC);
                                                                                        if( $cuCount -> rowCount()>0 ){
                                                                                            foreach( ($cuCount -> fetchAll()) as $keycu => $rowcu ){
                                                                                                $cuCount = $rowcu['CATAcount'];
                                                                                    ?>
                                                                                    <h5 class="mb-1"><?=$cuCount?></h5>
                                                                                    <?php
                                                                                            }
                                                                                        }
                                                                                    ?>
                                                                                    <p class="text-muted mb-0">Total Refered Customers</p>
                                                                                </div>
                                                                                <div class="col-6">
                                                                                    <?php
                                                                                        $countPAC = "SELECT COUNT(cu_id) AS PECcount FROM product_payout WHERE cu_id='".$customer_id."' ";
                                                                                        $pecCount = $conn -> prepare($countPAC);
                                                                                        $pecCount -> execute();
                                                                                        $pecCount -> setFetchMode(PDO::FETCH_ASSOC);
                                                                                        if( $pecCount -> rowCount()>0 ){
                                                                                            foreach( ($pecCount -> fetchAll()) as $keyPec => $rowPec ){
                                                                                                $PecCount = $rowPec['PECcount'];
                                                                                    ?>
                                                                                    <h5 class="mb-1">20</h5>
                                                                                    <?php
                                                                                            }
                                                                                        }
                                                                                    ?>
                                                                                    <p class="text-muted mb-0">Total Packages</p>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-2 col-md-2 col-sm-6 col-6 py-2">
                                                                            <h5 class="mb-1">Phone No</h5>
                                                                            <p class="text-muted mb-0"><?=$referral5['contact_no']?></p>
                                                                        </div>
                                                                        <div class="col-lg-2 col-md-2 col-sm-6 col-6 py-2">
                                                                            <div class="text-center">
                                                                                <a href="#" onclick="overviewPage('<?= $referral5['ca_customer_id'] .','.  $referral5['reference_no'] . ',' .$referral5['country']. ',' .$referral5['state']. ',' .$referral5['city']. ',customer' ?>')" class="btn btn-primary view-btn">View Profile</a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </button>
                                                        <!-- cumtomer ref level 2 -->
                                                        <div class="panel">
                                                            <?php
                                                                $stmt6 = $conn -> prepare(" SELECT * FROM ca_customer WHERE reference_no = ? AND status = '1' ORDER BY ca_customer_id ASC");
                                                                $stmt6 -> execute([$customer_id]);
                                                                $referrals6 = $stmt6->fetchAll(PDO::FETCH_ASSOC);
                                                                foreach($referrals6 as $referral6){
                                                                    $customer_id2 = $referral6['ca_customer_id'];
                                                            ?>
                                                            <button class="accordion p-0">
                                                                <div class="card mb-0 rounded-0">
                                                                    <div class="card-body p-2">
                                                                        <div class="row align-items-center">
                                                                            <div class="col-lg-4 col-md-4 col-sm-12 col-12 py-2">
                                                                                <div class="team-profile-img d-flex align-items-center justify-content-around">
                                                                                    <div class="avatar-md img-thumbnail rounded float-start rounded-circle">
                                                                                        <img src="../../uploading/<?=$referral6['profile_pic']?>" alt="" class="img-fluid d-block rounded-circle" />
                                                                                    </div>
                                                                                    <div>
                                                                                        <a href="#" class="d-block">
                                                                                            <h5 class="fs-5 mb-1"><?=$referral6['firstname'].' '.$referral6['lastname'].' '.$customer_id2?></h5>
                                                                                        </a>
                                                                                        <p class="text-muted mb-0">Customer</p>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-lg-4 col-md-4 col-sm-12 col-12 py-2">
                                                                                <div class="row text-center">
                                                                                    <div class="col-6 border-end">
                                                                                        <?php
                                                                                            $countCU2 = "SELECT COUNT(ca_customer_id) AS CATAcount FROM ca_customer WHERE reference_no='".$customer_id2."' ";
                                                                                            $cuCount2 = $conn -> prepare($countCU2);
                                                                                            $cuCount2 -> execute();
                                                                                            $cuCount2 -> setFetchMode(PDO::FETCH_ASSOC);
                                                                                            if( $cuCount2 -> rowCount()>0 ){
                                                                                                foreach( ($cuCount2 -> fetchAll()) as $keycu2 => $rowcu2 ){
                                                                                                    $cu2Count = $rowcu2['CATAcount'];
                                                                                        ?>
                                                                                        <h5 class="mb-1"><?= $cu2Count?></h5>
                                                                                        <?php
                                                                                                }
                                                                                            }
                                                                                        ?>
                                                                                        <p class="text-muted mb-0">Total Refered Customers</p>
                                                                                    </div>
                                                                                    <div class="col-6">
                                                                                        <?php
                                                                                            $countPAC2 = "SELECT COUNT(cu_id) AS PECcount FROM product_payout WHERE cu_id='".$customer_id2."' ";
                                                                                            $pecCount2 = $conn -> prepare($countPAC2);
                                                                                            $pecCount2 -> execute();
                                                                                            $pecCount2 -> setFetchMode(PDO::FETCH_ASSOC);
                                                                                            if( $pecCount2 -> rowCount()>0 ){
                                                                                                foreach( ($pecCount2 -> fetchAll()) as $keyPec2 => $rowPec2 ){
                                                                                                    $PecCount2 = $rowPec2['PECcount'];
                                                                                        ?>
                                                                                        <h5 class="mb-1"><?=$PecCount2?></h5>
                                                                                        <?php
                                                                                                }
                                                                                            }
                                                                                        ?>
                                                                                        <p class="text-muted mb-0">Total Packages</p>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-lg-2 col-md-2 col-sm-6 col-6 py-2">
                                                                                <h5 class="mb-1">Phone No</h5>
                                                                                <p class="text-muted mb-0"><?=$referral6['contact_no']?></p>
                                                                            </div>
                                                                            <div class="col-lg-2 col-md-2 col-sm-6 col-6 py-2">
                                                                                <div class="text-center">
                                                                                    <a href="#" onclick="overviewPage('<?= $referral6['ca_customer_id'] .','.  $referral6['reference_no'] . ',' .$referral6['country']. ',' .$referral6['state']. ',' .$referral6['city']. ',customer' ?>')" class="btn btn-primary view-btn">View Profile</a>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </button>
                                                            <!-- cumtomer ref level 3 -->
                                                            <div class="panel">
                                                                <?php
                                                                    $stmt6 = $conn -> prepare(" SELECT * FROM ca_customer WHERE reference_no = ? AND status = '1' ORDER BY ca_customer_id ASC");
                                                                    $stmt6 -> execute([$customer_id2]);
                                                                    $referrals6 = $stmt6->fetchAll(PDO::FETCH_ASSOC);
                                                                    foreach($referrals6 as $referral6){
                                                                        $customer_id3 = $referral6['ca_customer_id'];
                                                                ?>
                                                                <button class="accordion p-0">
                                                                    <div class="card mb-0 rounded-0">
                                                                        <div class="card-body p-2">
                                                                            <div class="row align-items-center">
                                                                                <div class="col-lg-4 col-md-4 col-sm-12 col-12 py-2">
                                                                                    <div class="team-profile-img d-flex align-items-center justify-content-around">
                                                                                        <div class="avatar-md img-thumbnail rounded float-start rounded-circle">
                                                                                            <img src="../../uploading/<?=$referral6['profile_pic']?>" alt="" class="img-fluid d-block rounded-circle" />
                                                                                        </div>
                                                                                        <div>
                                                                                            <a href="#" class="d-block">
                                                                                                <h5 class="fs-5 mb-1"><?=$referral6['firstname'].' '.$referral6['lastname'].' '.$customer_id3?></h5>
                                                                                            </a>
                                                                                            <p class="text-muted mb-0">Customer</p>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-lg-4 col-md-4 col-sm-12 col-12 py-2">
                                                                                    <div class="row text-center">
                                                                                        <div class="col-6 border-end">
                                                                                            <?php
                                                                                                $countCU2 = "SELECT COUNT(ca_customer_id) AS CATAcount FROM ca_customer WHERE reference_no='".$customer_id3."' ";
                                                                                                $cuCount2 = $conn -> prepare($countCU2);
                                                                                                $cuCount2 -> execute();
                                                                                                $cuCount2 -> setFetchMode(PDO::FETCH_ASSOC);
                                                                                                if( $cuCount2 -> rowCount()>0 ){
                                                                                                    foreach( ($cuCount2 -> fetchAll()) as $keycu2 => $rowcu2 ){
                                                                                                        $cu2Count = $rowcu2['CATAcount'];
                                                                                            ?>
                                                                                            <h5 class="mb-1"><?=$cu2Count?></h5>
                                                                                            <?php
                                                                                                    }
                                                                                                }
                                                                                            ?>
                                                                                            <p class="text-muted mb-0">Total Refered Customers</p>
                                                                                        </div>
                                                                                        <div class="col-6">
                                                                                            <?php
                                                                                                $countPAC2 = "SELECT COUNT(cu_id) AS PECcount FROM product_payout WHERE cu_id='".$customer_id3."' ";
                                                                                                $pecCount2 = $conn -> prepare($countPAC2);
                                                                                                $pecCount2 -> execute();
                                                                                                $pecCount2 -> setFetchMode(PDO::FETCH_ASSOC);
                                                                                                if( $pecCount2 -> rowCount()>0 ){
                                                                                                    foreach( ($pecCount2 -> fetchAll()) as $keyPec2 => $rowPec2 ){
                                                                                                        $PecCount2 = $rowPec2['PECcount'];
                                                                                            ?>
                                                                                            <h5 class="mb-1"><?=$PecCount2?></h5>
                                                                                            <?php
                                                                                                    }
                                                                                                }
                                                                                            ?>
                                                                                            <p class="text-muted mb-0">Total Packages</p>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-lg-2 col-md-2 col-sm-6 col-6 py-2">
                                                                                    <h5 class="mb-1">Phone No</h5>
                                                                                    <p class="text-muted mb-0"><?=$referral6['contact_no']?></p>
                                                                                </div>
                                                                                <div class="col-lg-2 col-md-2 col-sm-6 col-6 py-2">
                                                                                    <div class="text-center">
                                                                                        <a href="#" onclick="overviewPage('<?= $referral6['ca_customer_id'] .','.  $referral6['reference_no'] . ',' .$referral6['country']. ',' .$referral6['state']. ',' .$referral6['city']. ',customer' ?>')" class="btn btn-primary view-btn">View Profile</a>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </button>
                                                                <?php
                                                                    }
                                                                ?>
                                                            </div>
                                                            <?php
                                                                }
                                                            ?>
                                                            <!-- end cumtomer ref level 3 -->
                                                        </div>
                                                        <!-- end cumtomer ref level 2 -->
                                                        <?php
                                                            }
                                                        ?>
                                                    </div>
                                                    <!-- end customer ref level 1 -->
                                                    <?php
                                                        }
                                                    ?>
                                                </div>
                                                <!-- end all Customers onboarded by TC -->
                                            <?php
                                                }
                                            ?>
                                            <!-- end TC recruted by BM -->
                                            
                                        </div>
                                        <!-- end all TE under given BM -->
                                        <?php
                                            }
                                        
                                            $stmt2_1 = $conn -> prepare(" SELECT * FROM corporate_agency WHERE reference_no = ? AND status = '1' ORDER BY corporate_agency_id ASC");
                                            $stmt2_1 -> execute([$bms_id]);
                                            $referrals2_1 = $stmt2_1->fetchAll(PDO::FETCH_ASSOC);
                                            foreach($referrals2_1 as $referral2_1){
                                                $tes_id = $referral2_1['corporate_agency_id']; 
                                        ?>
                                        <button class="accordion p-0">
                                            <div class="card mb-0 rounded-0">
                                                <div class="card-body p-2">
                                                    <div class="row align-items-center">
                                                        <div class="col-lg-4 col-md-4 col-sm-12 col-12 py-2">
                                                            <div class="team-profile-img d-flex align-items-center justify-content-around">
                                                                <div class="avatar-md img-thumbnail rounded float-start rounded-circle">
                                                                    <img src="../../uploading/<?=$referral2_1['profile_pic']?>" alt="" class="img-fluid d-block rounded-circle" />
                                                                </div>
                                                                <div>
                                                                    <a href="#" class="d-block">
                                                                        <h5 class="fs-5 mb-1"><?=$referral2_1['firstname'].' '.$referral2_1['lastname'].' '.$tes_id?></h5>
                                                                    </a>
                                                                    <p class="text-muted mb-0">Techno Enterprise</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4 col-md-4 col-sm-12 col-12 py-2">
                                                            <div class="row text-center">
                                                                <div class="col-6 border-end">
                                                                    <?php
                                                                        $countCATA2 = "SELECT COUNT(ca_travelagency_id) AS CATAcount FROM ca_travelagency WHERE reference_no='".$tes_id."' ";
                                                                        $cataCount2 = $conn -> prepare($countCATA2);
                                                                        $cataCount2 -> execute();
                                                                        $cataCount2 -> setFetchMode(PDO::FETCH_ASSOC);
                                                                        if( $cataCount2 -> rowCount()>0 ){
                                                                            foreach( ($cataCount2 -> fetchAll()) as $keyCATA => $rowCATA ){
                                                                                $CATACount2 = $rowCATA['CATAcount']; 
                                                                    ?>
                                                                    <h5 class="mb-1"><?=$CATACount2?></h5>
                                                                    <?php
                                                                            }
                                                                        }
                                                                    ?>
                                                                    <p class="text-muted mb-0">Total Team Member</p>
                                                                </div>
                                                                <div class="col-6">
                                                                    <?php
                                                                        $countPAC2 = "SELECT COUNT(te_id) AS PECcount FROM product_payout WHERE te_id='".$tes_id."' ";
                                                                        $pecCount2 = $conn -> prepare($countPAC2);
                                                                        $pecCount2 -> execute();
                                                                        $pecCount2 -> setFetchMode(PDO::FETCH_ASSOC);
                                                                        if( $pecCount2 -> rowCount()>0 ){
                                                                            foreach( ($pecCount2 -> fetchAll()) as $keyPec => $rowPec ){
                                                                                $PecCount2 = $rowPec['PECcount'];
                                                                    ?>
                                                                    <h5 class="mb-1"><?=$PecCount2?></h5>
                                                                    <?php
                                                                            }
                                                                        }
                                                                    ?>
                                                                    <p class="text-muted mb-0">Total Packages</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-2 col-md-2 col-sm-6 col-6 py-2">
                                                            <h5 class="mb-1">Phone No</h5>
                                                            <p class="text-muted mb-0"><?=$referral2_1['contact_no']?></p>
                                                        </div>
                                                        <div class="col-lg-2 col-md-2 col-sm-6 col-6 py-2">
                                                            <div class="text-center">
                                                                <a href="#" onclick="overviewPage('<?= $referral2_1['corporate_agency_id'] .','.  $referral2_1['reference_no'] . ',' .$referral2_1['country']. ',' .$referral2_1['state']. ',' .$referral2_1['city']. ',corporate_agency' ?>')" class="btn btn-primary view-btn">View Profile</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </button>
                                        <!-- TC under the given TE -->
                                        <div class="panel">
                                            <?php
                                                $stmt2_3 = $conn -> prepare(" SELECT * FROM ca_travelagency WHERE reference_no = ? AND status = '1' ORDER BY ca_travelagency_id ASC");
                                                $stmt2_3 -> execute([$tes_id]);
                                                $referrals2_3 = $stmt2_3->fetchAll(PDO::FETCH_ASSOC);
                                                foreach($referrals2_3 as $referral2){
                                                    $cas_id = $referral2['ca_travelagency_id'];
                                            ?>
                                            <button class="accordion p-0">
                                                <div class="card mb-0 rounded-0">
                                                    <div class="card-body p-2">
                                                        <div class="row align-items-center">
                                                            <div class="col-lg-4 col-md-4 col-sm-12 col-12 py-2">
                                                                <div class="team-profile-img d-flex align-items-center justify-content-around">
                                                                    <div class="avatar-md img-thumbnail rounded float-start rounded-circle">
                                                                        <img src="../../uploading/<?=$referral2['profile_pic']?>" alt="" class="img-fluid d-block rounded-circle" />
                                                                    </div>
                                                                    <div>
                                                                        <a href="#" class="d-block">
                                                                            <h5 class="fs-5 mb-1"><?=$referral2['firstname'].' '.$referral2['lastname'].' '.$cas_id?></h5>
                                                                        </a>
                                                                        <p class="text-muted mb-0">Travel Consultant</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4 col-md-4 col-sm-12 col-12 py-2">
                                                                <div class="row text-center">
                                                                    <div class="col-6 border-end">
                                                                        <?php
                                                                            $countCACU2 = "SELECT COUNT(ca_customer_id) AS CACUcount FROM ca_customer WHERE ta_reference_no='".$cas_id."' ";
                                                                            $cacuCount2 = $conn -> prepare($countCACU2);
                                                                            $cacuCount2 -> execute();
                                                                            $cacuCount2 -> setFetchMode(PDO::FETCH_ASSOC);
                                                                            if( $cacuCount2 -> rowCount()>0 ){
                                                                                foreach( ($cacuCount2 -> fetchAll()) as $keyCACU => $rowCACU ){
                                                                                    $CACUCount2 = $rowCACU['CACUcount'];
                                                                        ?>
                                                                        <h5 class="mb-1"><?=$CACUCount2?></h5>
                                                                        <?php
                                                                                }
                                                                            }
                                                                        ?>
                                                                        <p class="text-muted mb-0">Total Team Member</p>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <?php
                                                                            $countPAC3 = "SELECT COUNT(ta_id) AS PECcount FROM product_payout WHERE ta_id='".$cas_id."' ";
                                                                            $pecCount3 = $conn -> prepare($countPAC3);
                                                                            $pecCount3 -> execute();
                                                                            $pecCount3 -> setFetchMode(PDO::FETCH_ASSOC);
                                                                            if( $pecCount3 -> rowCount()>0 ){
                                                                                foreach( ($pecCount3 -> fetchAll()) as $keyPec => $rowPec ){
                                                                                    $PecCount3 = $rowPec['PECcount'];
                                                                        ?>
                                                                        <h5 class="mb-1"><?=$PecCount3?></h5>
                                                                        <?php
                                                                                }
                                                                            }
                                                                        ?>
                                                                        <p class="text-muted mb-0">Total Packages</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-2 col-md-2 col-sm-6 col-6 py-2">
                                                                <h5 class="mb-1">Phone No</h5>
                                                                <p class="text-muted mb-0"><?=$referral2['contact_no']?></p>
                                                            </div>
                                                            <div class="col-lg-2 col-md-2 col-sm-6 col-6 py-2">
                                                                <div class="text-center">
                                                                    <a href="#" onclick="overviewPage('<?= $referral2['ca_travelagency_id'] .','.  $referral2['reference_no'] . ',' .$referral2['country']. ',' .$referral2['state']. ',' .$referral2['city']. ',travel_consultant' ?>')" class="btn btn-primary view-btn">View Profile</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </button>
                                            <!-- all Customers onboarded by TC -->
                                                <div class="panel">
                                                    <?php
                                                        $stmt4 = $conn -> prepare(" SELECT * FROM ca_customer WHERE ta_reference_no = ? AND reference_no IS NUll AND status = '1' ORDER BY ca_customer_id ASC");
                                                        $stmt4 -> execute([$cas_id]);
                                                        $referrals4 = $stmt4->fetchAll(PDO::FETCH_ASSOC);
                                                        foreach($referrals4 as $referral4){
                                                            $cacus_id = $referral4['ca_customer_id'];
                                                    ?>
                                                    <button class="accordion p-0">
                                                        <div class="card mb-0 rounded-0">
                                                            <div class="card-body p-2">
                                                                <div class="row align-items-center">
                                                                    <div class="col-lg-4 col-md-4 col-sm-12 col-12 py-2">
                                                                        <div class="team-profile-img d-flex align-items-center justify-content-around">
                                                                            <div class="avatar-md img-thumbnail rounded float-start rounded-circle">
                                                                                <img src="../../uploading/<?=$referral4['profile_pic']?>" alt="" class="img-fluid d-block rounded-circle" />
                                                                            </div>
                                                                            <div>
                                                                                <a href="#" class="d-block">
                                                                                    <h5 class="fs-5 mb-1"><?=$referral4['firstname'].' '.$referral4['lastname'].' '.$cacus_id?></h5>
                                                                                </a>
                                                                                <p class="text-muted mb-0">Customer</p>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-4 col-md-4 col-sm-12 col-12 py-2">
                                                                        <div class="row text-center">
                                                                            <div class="col-6 border-end">
                                                                                <?php
                                                                                    $countCATACU = "SELECT COUNT(ca_customer_id) AS CATACUcount FROM ca_customer WHERE reference_no='".$cacus_id."' ";
                                                                                    $catacuCount = $conn -> prepare($countCATACU);
                                                                                    $catacuCount -> execute();
                                                                                    $catacuCount -> setFetchMode(PDO::FETCH_ASSOC);
                                                                                    if( $catacuCount -> rowCount()>0 ){
                                                                                        foreach( ($catacuCount -> fetchAll()) as $keyCATACU => $rowCATACU ){
                                                                                            $CATACUCount = $rowCATACU['CATACUcount'];
                                                                                ?>
                                                                                <h5 class="mb-1"><?=$CATACUCount?></h5>
                                                                                <?php
                                                                                        }
                                                                                    }
                                                                                ?>
                                                                                <p class="text-muted mb-0">Total Refered Customers</p>
                                                                            </div>
                                                                            <div class="col-6">
                                                                                <?php
                                                                                    $countPAC = "SELECT COUNT(cu_id) AS PECcount FROM product_payout WHERE cu_id='".$cacus_id."' ";
                                                                                    $pecCount = $conn -> prepare($countPAC);
                                                                                    $pecCount -> execute();
                                                                                    $pecCount -> setFetchMode(PDO::FETCH_ASSOC);
                                                                                    if( $pecCount -> rowCount()>0 ){
                                                                                        foreach( ($pecCount -> fetchAll()) as $keyPec => $rowPec ){
                                                                                            $PecCount = $rowPec['PECcount'];
                                                                                ?>
                                                                                <h5 class="mb-1"><?=$PecCount?></h5>
                                                                                <?php
                                                                                        }
                                                                                    }
                                                                                ?>
                                                                                <p class="text-muted mb-0">Total Packages</p>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-2 col-md-2 col-sm-6 col-6 py-2">
                                                                        <h5 class="mb-1">Phone No</h5>
                                                                        <p class="text-muted mb-0"><?=$referral4['contact_no']?></p>
                                                                    </div>
                                                                    <div class="col-lg-2 col-md-2 col-sm-6 col-6 py-2">
                                                                        <div class="text-center">
                                                                            <a href="#" onclick="overviewPage('<?= $referral4['ca_customer_id'] .','.  $referral4['reference_no'] . ',' .$referral4['country']. ',' .$referral4['state']. ',' .$referral4['city']. ',customer' ?>')" class="btn btn-primary view-btn">View Profile</a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </button>
                                                    <!-- customer ref level 1 -->
                                                    <div class="panel">
                                                        <?php
                                                            $stmt5 = $conn -> prepare(" SELECT * FROM ca_customer WHERE reference_no = ? AND status = '1' ORDER BY ca_customer_id ASC");
                                                            $stmt5 -> execute([$cacus_id]);
                                                            $referrals5 = $stmt5->fetchAll(PDO::FETCH_ASSOC);
                                                            foreach($referrals5 as $referral5){
                                                                $customer_id = $referral5['ca_customer_id'];
                                                        ?>
                                                        <button class="accordion p-0">
                                                            <div class="card mb-0 rounded-0">
                                                                <div class="card-body p-2">
                                                                    <div class="row align-items-center">
                                                                        <div class="col-lg-4 col-md-4 col-sm-12 col-12 py-2">
                                                                            <div class="team-profile-img d-flex align-items-center justify-content-around">
                                                                                <div class="avatar-md img-thumbnail rounded float-start rounded-circle">
                                                                                    <img src="../../uploading/<?=$referral5['profile_pic']?>" alt="" class="img-fluid d-block rounded-circle" />
                                                                                </div>
                                                                                <div>
                                                                                    <a href="#" class="d-block">
                                                                                        <h5 class="fs-5 mb-1"><?=$referral5['firstname'].' '.$referral5['lastname'].' '.$customer_id?></h5>
                                                                                    </a>
                                                                                    <p class="text-muted mb-0">Customer</p>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-4 col-md-4 col-sm-12 col-12 py-2">
                                                                            <div class="row text-center">
                                                                                <div class="col-6 border-end">
                                                                                    <?php
                                                                                        $countCU = "SELECT COUNT(ca_customer_id) AS CATAcount FROM ca_customer WHERE reference_no='".$customer_id."' ";
                                                                                        $cuCount = $conn -> prepare($countCU);
                                                                                        $cuCount -> execute();
                                                                                        $cuCount -> setFetchMode(PDO::FETCH_ASSOC);
                                                                                        if( $cuCount -> rowCount()>0 ){
                                                                                            foreach( ($cuCount -> fetchAll()) as $keycu => $rowcu ){
                                                                                                $cuCount = $rowcu['CATAcount'];
                                                                                    ?>
                                                                                    <h5 class="mb-1"><?=$cuCount?></h5>
                                                                                    <?php
                                                                                            }
                                                                                        }
                                                                                    ?>
                                                                                    <p class="text-muted mb-0">Total Refered Customers</p>
                                                                                </div>
                                                                                <div class="col-6">
                                                                                    <?php
                                                                                        $countPAC = "SELECT COUNT(cu_id) AS PECcount FROM product_payout WHERE cu_id='".$customer_id."' ";
                                                                                        $pecCount = $conn -> prepare($countPAC);
                                                                                        $pecCount -> execute();
                                                                                        $pecCount -> setFetchMode(PDO::FETCH_ASSOC);
                                                                                        if( $pecCount -> rowCount()>0 ){
                                                                                            foreach( ($pecCount -> fetchAll()) as $keyPec => $rowPec ){
                                                                                                $PecCount = $rowPec['PECcount'];
                                                                                    ?>
                                                                                    <h5 class="mb-1">20</h5>
                                                                                    <?php
                                                                                            }
                                                                                        }
                                                                                    ?>
                                                                                    <p class="text-muted mb-0">Total Packages</p>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-2 col-md-2 col-sm-6 col-6 py-2">
                                                                            <h5 class="mb-1">Phone No</h5>
                                                                            <p class="text-muted mb-0"><?=$referral5['contact_no']?></p>
                                                                        </div>
                                                                        <div class="col-lg-2 col-md-2 col-sm-6 col-6 py-2">
                                                                            <div class="text-center">
                                                                                <a href="#" onclick="overviewPage('<?= $referral5['ca_customer_id'] .','.  $referral5['reference_no'] . ',' .$referral5['country']. ',' .$referral5['state']. ',' .$referral5['city']. ',customer' ?>')" class="btn btn-primary view-btn">View Profile</a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </button>
                                                        <!-- cumtomer ref level 2 -->
                                                        <div class="panel">
                                                            <?php
                                                                $stmt6 = $conn -> prepare(" SELECT * FROM ca_customer WHERE reference_no = ? AND status = '1' ORDER BY ca_customer_id ASC");
                                                                $stmt6 -> execute([$customer_id]);
                                                                $referrals6 = $stmt6->fetchAll(PDO::FETCH_ASSOC);
                                                                foreach($referrals6 as $referral6){
                                                                    $customer_id2 = $referral6['ca_customer_id'];
                                                            ?>
                                                            <button class="accordion p-0">
                                                                <div class="card mb-0 rounded-0">
                                                                    <div class="card-body p-2">
                                                                        <div class="row align-items-center">
                                                                            <div class="col-lg-4 col-md-4 col-sm-12 col-12 py-2">
                                                                                <div class="team-profile-img d-flex align-items-center justify-content-around">
                                                                                    <div class="avatar-md img-thumbnail rounded float-start rounded-circle">
                                                                                        <img src="../../uploading/<?=$referral6['profile_pic']?>" alt="" class="img-fluid d-block rounded-circle" />
                                                                                    </div>
                                                                                    <div>
                                                                                        <a href="#" class="d-block">
                                                                                            <h5 class="fs-5 mb-1"><?=$referral6['firstname'].' '.$referral6['lastname'].' '.$customer_id2?></h5>
                                                                                        </a>
                                                                                        <p class="text-muted mb-0">Customer</p>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-lg-4 col-md-4 col-sm-12 col-12 py-2">
                                                                                <div class="row text-center">
                                                                                    <div class="col-6 border-end">
                                                                                        <?php
                                                                                            $countCU2 = "SELECT COUNT(ca_customer_id) AS CATAcount FROM ca_customer WHERE reference_no='".$customer_id2."' ";
                                                                                            $cuCount2 = $conn -> prepare($countCU2);
                                                                                            $cuCount2 -> execute();
                                                                                            $cuCount2 -> setFetchMode(PDO::FETCH_ASSOC);
                                                                                            if( $cuCount2 -> rowCount()>0 ){
                                                                                                foreach( ($cuCount2 -> fetchAll()) as $keycu2 => $rowcu2 ){
                                                                                                    $cu2Count = $rowcu2['CATAcount'];
                                                                                        ?>
                                                                                        <h5 class="mb-1"><?= $cu2Count?></h5>
                                                                                        <?php
                                                                                                }
                                                                                            }
                                                                                        ?>
                                                                                        <p class="text-muted mb-0">Total Refered Customers</p>
                                                                                    </div>
                                                                                    <div class="col-6">
                                                                                        <?php
                                                                                            $countPAC2 = "SELECT COUNT(cu_id) AS PECcount FROM product_payout WHERE cu_id='".$customer_id2."' ";
                                                                                            $pecCount2 = $conn -> prepare($countPAC2);
                                                                                            $pecCount2 -> execute();
                                                                                            $pecCount2 -> setFetchMode(PDO::FETCH_ASSOC);
                                                                                            if( $pecCount2 -> rowCount()>0 ){
                                                                                                foreach( ($pecCount2 -> fetchAll()) as $keyPec2 => $rowPec2 ){
                                                                                                    $PecCount2 = $rowPec2['PECcount'];
                                                                                        ?>
                                                                                        <h5 class="mb-1"><?=$PecCount2?></h5>
                                                                                        <?php
                                                                                                }
                                                                                            }
                                                                                        ?>
                                                                                        <p class="text-muted mb-0">Total Packages</p>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-lg-2 col-md-2 col-sm-6 col-6 py-2">
                                                                                <h5 class="mb-1">Phone No</h5>
                                                                                <p class="text-muted mb-0"><?=$referral6['contact_no']?></p>
                                                                            </div>
                                                                            <div class="col-lg-2 col-md-2 col-sm-6 col-6 py-2">
                                                                                <div class="text-center">
                                                                                    <a href="#" onclick="overviewPage('<?= $referral6['ca_customer_id'] .','.  $referral6['reference_no'] . ',' .$referral6['country']. ',' .$referral6['state']. ',' .$referral6['city']. ',customer' ?>')" class="btn btn-primary view-btn">View Profile</a>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </button>
                                                            <!-- cumtomer ref level 3 -->
                                                            <div class="panel">
                                                                <?php
                                                                    $stmt6 = $conn -> prepare(" SELECT * FROM ca_customer WHERE reference_no = ? AND status = '1' ORDER BY ca_customer_id ASC");
                                                                    $stmt6 -> execute([$customer_id2]);
                                                                    $referrals6 = $stmt6->fetchAll(PDO::FETCH_ASSOC);
                                                                    foreach($referrals6 as $referral6){
                                                                        $customer_id3 = $referral6['ca_customer_id'];
                                                                ?>
                                                                <button class="accordion p-0">
                                                                    <div class="card mb-0 rounded-0">
                                                                        <div class="card-body p-2">
                                                                            <div class="row align-items-center">
                                                                                <div class="col-lg-4 col-md-4 col-sm-12 col-12 py-2">
                                                                                    <div class="team-profile-img d-flex align-items-center justify-content-around">
                                                                                        <div class="avatar-md img-thumbnail rounded float-start rounded-circle">
                                                                                            <img src="../../uploading/<?=$referral6['profile_pic']?>" alt="" class="img-fluid d-block rounded-circle" />
                                                                                        </div>
                                                                                        <div>
                                                                                            <a href="#" class="d-block">
                                                                                                <h5 class="fs-5 mb-1"><?=$referral6['firstname'].' '.$referral6['lastname'].' '.$customer_id3?></h5>
                                                                                            </a>
                                                                                            <p class="text-muted mb-0">Customer</p>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-lg-4 col-md-4 col-sm-12 col-12 py-2">
                                                                                    <div class="row text-center">
                                                                                        <div class="col-6 border-end">
                                                                                            <?php
                                                                                                $countCU2 = "SELECT COUNT(ca_customer_id) AS CATAcount FROM ca_customer WHERE reference_no='".$customer_id3."' ";
                                                                                                $cuCount2 = $conn -> prepare($countCU2);
                                                                                                $cuCount2 -> execute();
                                                                                                $cuCount2 -> setFetchMode(PDO::FETCH_ASSOC);
                                                                                                if( $cuCount2 -> rowCount()>0 ){
                                                                                                    foreach( ($cuCount2 -> fetchAll()) as $keycu2 => $rowcu2 ){
                                                                                                        $cu2Count = $rowcu2['CATAcount'];
                                                                                            ?>
                                                                                            <h5 class="mb-1"><?=$cu2Count?></h5>
                                                                                            <?php
                                                                                                    }
                                                                                                }
                                                                                            ?>
                                                                                            <p class="text-muted mb-0">Total Refered Customers</p>
                                                                                        </div>
                                                                                        <div class="col-6">
                                                                                            <?php
                                                                                                $countPAC2 = "SELECT COUNT(cu_id) AS PECcount FROM product_payout WHERE cu_id='".$customer_id3."' ";
                                                                                                $pecCount2 = $conn -> prepare($countPAC2);
                                                                                                $pecCount2 -> execute();
                                                                                                $pecCount2 -> setFetchMode(PDO::FETCH_ASSOC);
                                                                                                if( $pecCount2 -> rowCount()>0 ){
                                                                                                    foreach( ($pecCount2 -> fetchAll()) as $keyPec2 => $rowPec2 ){
                                                                                                        $PecCount2 = $rowPec2['PECcount'];
                                                                                            ?>
                                                                                            <h5 class="mb-1"><?=$PecCount2?></h5>
                                                                                            <?php
                                                                                                    }
                                                                                                }
                                                                                            ?>
                                                                                            <p class="text-muted mb-0">Total Packages</p>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-lg-2 col-md-2 col-sm-6 col-6 py-2">
                                                                                    <h5 class="mb-1">Phone No</h5>
                                                                                    <p class="text-muted mb-0"><?=$referral6['contact_no']?></p>
                                                                                </div>
                                                                                <div class="col-lg-2 col-md-2 col-sm-6 col-6 py-2">
                                                                                    <div class="text-center">
                                                                                        <a href="#" onclick="overviewPage('<?= $referral6['ca_customer_id'] .','.  $referral6['reference_no'] . ',' .$referral6['country']. ',' .$referral6['state']. ',' .$referral6['city']. ',customer' ?>')" class="btn btn-primary view-btn">View Profile</a>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </button>
                                                                <?php
                                                                    }
                                                                ?>
                                                            </div>
                                                            <?php
                                                                }
                                                            ?>
                                                            <!-- end cumtomer ref level 3 -->
                                                        </div>
                                                        <!-- end cumtomer ref level 2 -->
                                                        <?php
                                                            }
                                                        ?>
                                                    </div>
                                                    <!-- end customer ref level 1 -->
                                                    <?php
                                                        }
                                                    ?>
                                                </div>
                                                <!-- end all Customers onboarded by TC -->
                                            <?php
                                                }
                                            ?>
                                            <!-- end TC under the given TE -->
                                            </div>
                                        <?php
                                            }
                                        }
                                    ?>
                                    
                                    
                                    
                                </div>
                                <!-- end all BM and TE -->
                                <?php 
                                        
                                    }else if($DBtable == 'business_mentor'){
                                        
                                        $stmt2_3 = $conn -> prepare(" SELECT * FROM corporate_agency WHERE reference_no = ? AND status = '1' ORDER BY corporate_agency_id ASC");
                                        $stmt2_3 -> execute([$id]);
                                        $stmt2_3_3 = $conn -> prepare(" SELECT * FROM ca_travelagency WHERE reference_no = ? AND status = '1' ORDER BY ca_travelagency_id ASC");
                                        $stmt2_3_3 -> execute([$id]);
                                        $stmt2_3 -> setFetchMode(PDO::FETCH_ASSOC);
                                        $stmt2_3_3 -> setFetchMode(PDO::FETCH_ASSOC);

                                        if($stmt2_3 -> rowCount() == 0 && $stmt2_3_3 -> rowCount() == 0){
                                ?>
                                <div class="row pt-3">
                                    <div class="col-md-2">
                                        <div class="d-flex align-items-center justify-content-center p-3 position">
                                            <img src="../../uploading/not_uploaded.png" width="50" height="50" class="rounded-circle ms-3" />
                                        </div>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="">
                                            <div class="card bg-light p-2 mt-2">
                                                <div class="d-flex justify-content-between">
                                                    <h4 class="">-----</h4>
                                                    <p class="d-inline">--/--/----</p>
                                                </div>
                                                <p class="my-0 cardText">No Team memebers found</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php  
                                        }else{
                                            $referrals2_3 = $stmt2_3->fetchAll();
                                            foreach($referrals2_3 as $referral2){
                                                $cas_id = $referral2['corporate_agency_id'];
                                            ?>
                                            <button class="accordion p-0">
                                                <div class="card mb-0 rounded-0">
                                                    <div class="card-body p-2">
                                                        <div class="row align-items-center">
                                                            <div class="col-lg-4 col-md-4 col-sm-12 col-12 py-2">
                                                                <div class="team-profile-img d-flex align-items-center justify-content-around">
                                                                    <div class="avatar-md img-thumbnail rounded float-start rounded-circle">
                                                                        <img src="../../uploading/<?=$referral2['profile_pic']?>" alt="" class="img-fluid d-block rounded-circle" />
                                                                    </div>
                                                                    <div>
                                                                        <a href="#" class="d-block">
                                                                            <h5 class="fs-5 mb-1"><?=$referral2['firstname'].' '.$referral2['lastname'].' '.$cas_id?></h5>
                                                                        </a>
                                                                        <p class="text-muted mb-0">Techno Enterprise</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4 col-md-4 col-sm-12 col-12 py-2">
                                                                <div class="row text-center">
                                                                    <div class="col-6 border-end">
                                                                        <?php
                                                                            $countCATA2_3 = "SELECT COUNT(ca_travelagency_id) AS CATAcount FROM ca_travelagency WHERE reference_no='".$cas_id."' ";
                                                                            $cataCount2_3 = $conn -> prepare($countCATA2_3);
                                                                            $cataCount2_3 -> execute();
                                                                            $cataCount2_3 -> setFetchMode(PDO::FETCH_ASSOC);
                                                                            if( $cataCount2_3 -> rowCount()>0 ){
                                                                                foreach( ($cataCount2_3 -> fetchAll()) as $keyCATA => $rowCATA ){
                                                                                    $CATACount3 = $rowCATA['CATAcount']; 
                                                                        ?>
                                                                        <h5 class="mb-1"><?=$CATACount3?></h5>
                                                                        <?php
                                                                                }
                                                                            }
                                                                        ?>
                                                                        <p class="text-muted mb-0">Total Team Member</p>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <?php
                                                                            $countPAC2_3 = "SELECT COUNT(te_id) AS PECcount FROM product_payout WHERE te_id='".$cas_id."' ";
                                                                            $pecCount2_3 = $conn -> prepare($countPAC2_3);
                                                                            $pecCount2_3 -> execute();
                                                                            $pecCount2_3 -> setFetchMode(PDO::FETCH_ASSOC);
                                                                            if( $pecCount2_3 -> rowCount()>0 ){
                                                                                foreach( ($pecCount2_3 -> fetchAll()) as $keyPec => $rowPec ){
                                                                                    $PecCount2_3 = $rowPec['PECcount'];
                                                                        ?>
                                                                        <h5 class="mb-1"><?=$PecCount2_3?></h5>
                                                                        <?php
                                                                                }
                                                                            }
                                                                        ?>
                                                                        <p class="text-muted mb-0">Total Packages</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-2 col-md-2 col-sm-6 col-6 py-2">
                                                                <h5 class="mb-1">Phone No</h5>
                                                                <p class="text-muted mb-0"><?=$referral2['contact_no']?></p>
                                                            </div>
                                                            <div class="col-lg-2 col-md-2 col-sm-6 col-6 py-2">
                                                                <div class="text-center">
                                                                    <a href="#" onclick="overviewPage('<?= $referral2['corporate_agency_id'] .','.  $referral2['reference_no'] . ',' .$referral2['country']. ',' .$referral2['state']. ',' .$referral2['city']. ',corporate_agency' ?>')" class="btn btn-primary view-btn">View Profile</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </button>
                                            <!-- all TC recruted by TE -->
                                            <div class="panel">
                                                <?php
                                                    $stmt3 = $conn -> prepare(" SELECT * FROM ca_travelagency WHERE reference_no = ? AND status = '1' ORDER BY ca_travelagency_id ASC");
                                                    $stmt3 -> execute([$cas_id]);
                                                    $referrals3 = $stmt3->fetchAll(PDO::FETCH_ASSOC);
                                                    foreach($referrals3 as $referral3){
                                                        $catas_id = $referral3['ca_travelagency_id'];
                                                ?>
                                                <button class="accordion p-0">
                                                    <div class="card mb-0 rounded-0">
                                                        <div class="card-body p-2">
                                                            <div class="row align-items-center">
                                                                <div class="col-lg-4 col-md-4 col-sm-12 col-12 py-2">
                                                                    <div class="team-profile-img d-flex align-items-center justify-content-around">
                                                                        <div class="avatar-md img-thumbnail rounded float-start rounded-circle">
                                                                            <img src="../../uploading/<?=$referral3['profile_pic']?>" alt="" class="img-fluid d-block rounded-circle" />
                                                                        </div>
                                                                        <div>
                                                                            <a href="#" class="d-block">
                                                                                <h5 class="fs-5 mb-1"><?=$referral3['firstname'].' '.$referral3['lastname'].' '.$catas_id?></h5>
                                                                            </a>
                                                                            <p class="text-muted mb-0">Travel Consultant</p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-4 col-md-4 col-sm-12 col-12 py-2">
                                                                    <div class="row text-center">
                                                                        <div class="col-6 border-end">
                                                                            <?php
                                                                                $countCACU = "SELECT COUNT(ca_customer_id) AS CACUcount FROM ca_customer WHERE ta_reference_no='".$catas_id."' ";
                                                                                $cacuCount = $conn -> prepare($countCACU);
                                                                                $cacuCount -> execute();
                                                                                $cacuCount -> setFetchMode(PDO::FETCH_ASSOC);
                                                                                if( $cacuCount -> rowCount()>0 ){
                                                                                    foreach( ($cacuCount -> fetchAll()) as $keyCACU => $rowCACU ){
                                                                                        $CACUCount = $rowCACU['CACUcount'];
                                                                            ?>
                                                                            <h5 class="mb-1"><?= $CACUCount ?></h5>
                                                                            <?php
                                                                                    }
                                                                                }
                                                                            ?>
                                                                            <p class="text-muted mb-0">Total Team Member</p>
                                                                        </div>
                                                                        <div class="col-6">
                                                                            <?php
                                                                                $countPAC = "SELECT COUNT(ta_id) AS PECcount FROM product_payout WHERE ta_id='".$catas_id."' ";
                                                                                $pecCount = $conn -> prepare($countPAC);
                                                                                $pecCount -> execute();
                                                                                $pecCount -> setFetchMode(PDO::FETCH_ASSOC);
                                                                                if( $pecCount -> rowCount()>0 ){
                                                                                    foreach( ($pecCount -> fetchAll()) as $keyPec => $rowPec ){
                                                                                        $PecCount = $rowPec['PECcount'];
                                                                            ?>
                                                                            <h5 class="mb-1"><?=$PecCount?></h5>
                                                                            <?php
                                                                                    }
                                                                                }
                                                                            ?>
                                                                            <p class="text-muted mb-0">Total Packages</p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-2 col-md-2 col-sm-6 col-6 py-2">
                                                                    <h5 class="mb-1">Phone No</h5>
                                                                    <p class="text-muted mb-0"><?php $referral3['contact_no'] ?></p>
                                                                </div>
                                                                <div class="col-lg-2 col-md-2 col-sm-6 col-6 py-2">
                                                                    <div class="text-center">
                                                                        <a href="#" onclick="overviewPage('<?= $referral3['ca_travelagency_id'] .','.  $referral3['reference_no'] . ',' .$referral3['country']. ',' .$referral3['state']. ',' .$referral3['city']. ',travel_consultant' ?>')" class="btn btn-primary view-btn">View Profile</a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </button>
                                                <!-- all Customers onboarded by TC -->
                                                <div class="panel">
                                                    <?php
                                                        $stmt4 = $conn -> prepare(" SELECT * FROM ca_customer WHERE ta_reference_no = ? AND reference_no IS NUll AND status = '1' ORDER BY ca_customer_id ASC");
                                                        $stmt4 -> execute([$catas_id]);
                                                        $referrals4 = $stmt4->fetchAll(PDO::FETCH_ASSOC);
                                                        foreach($referrals4 as $referral4){
                                                            $cacus_id = $referral4['ca_customer_id'];
                                                    ?>
                                                    <button class="accordion p-0">
                                                        <div class="card mb-0 rounded-0">
                                                            <div class="card-body p-2">
                                                                <div class="row align-items-center">
                                                                    <div class="col-lg-4 col-md-4 col-sm-12 col-12 py-2">
                                                                        <div class="team-profile-img d-flex align-items-center justify-content-around">
                                                                            <div class="avatar-md img-thumbnail rounded float-start rounded-circle">
                                                                                <img src="../../uploading/<?=$referral4['profile_pic']?>" alt="" class="img-fluid d-block rounded-circle" />
                                                                            </div>
                                                                            <div>
                                                                                <a href="#" class="d-block">
                                                                                    <h5 class="fs-5 mb-1"><?=$referral4['firstname'].' '.$referral4['lastname'].' '.$cacus_id?></h5>
                                                                                </a>
                                                                                <p class="text-muted mb-0">Customer</p>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-4 col-md-4 col-sm-12 col-12 py-2">
                                                                        <div class="row text-center">
                                                                            <div class="col-6 border-end">
                                                                                <?php
                                                                                    $countCATACU = "SELECT COUNT(ca_customer_id) AS CATACUcount FROM ca_customer WHERE reference_no='".$cacus_id."' ";
                                                                                    $catacuCount = $conn -> prepare($countCATACU);
                                                                                    $catacuCount -> execute();
                                                                                    $catacuCount -> setFetchMode(PDO::FETCH_ASSOC);
                                                                                    if( $catacuCount -> rowCount()>0 ){
                                                                                        foreach( ($catacuCount -> fetchAll()) as $keyCATACU => $rowCATACU ){
                                                                                            $CATACUCount = $rowCATACU['CATACUcount'];
                                                                                ?>
                                                                                <h5 class="mb-1"><?=$CATACUCount?></h5>
                                                                                <?php
                                                                                        }
                                                                                    }
                                                                                ?>
                                                                                <p class="text-muted mb-0">Total Refered Customers</p>
                                                                            </div>
                                                                            <div class="col-6">
                                                                                <?php
                                                                                    $countPAC = "SELECT COUNT(cu_id) AS PECcount FROM product_payout WHERE cu_id='".$cacus_id."' ";
                                                                                    $pecCount = $conn -> prepare($countPAC);
                                                                                    $pecCount -> execute();
                                                                                    $pecCount -> setFetchMode(PDO::FETCH_ASSOC);
                                                                                    if( $pecCount -> rowCount()>0 ){
                                                                                        foreach( ($pecCount -> fetchAll()) as $keyPec => $rowPec ){
                                                                                            $PecCount = $rowPec['PECcount'];
                                                                                ?>
                                                                                <h5 class="mb-1"><?=$PecCount?></h5>
                                                                                <?php
                                                                                        }
                                                                                    }
                                                                                ?>
                                                                                <p class="text-muted mb-0">Total Packages</p>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-2 col-md-2 col-sm-6 col-6 py-2">
                                                                        <h5 class="mb-1">Phone No</h5>
                                                                        <p class="text-muted mb-0"><?=$referral4['contact_no']?></p>
                                                                    </div>
                                                                    <div class="col-lg-2 col-md-2 col-sm-6 col-6 py-2">
                                                                        <div class="text-center">
                                                                            <a href="#" onclick="overviewPage('<?= $referral4['ca_customer_id'] .','.  $referral4['reference_no'] . ',' .$referral4['country']. ',' .$referral4['state']. ',' .$referral4['city']. ',customer' ?>')" class="btn btn-primary view-btn">View Profile</a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </button>
                                                    <!-- customer ref level 1 -->
                                                    <div class="panel">
                                                        <?php
                                                            $stmt5 = $conn -> prepare(" SELECT * FROM ca_customer WHERE reference_no = ? AND status = '1' ORDER BY ca_customer_id ASC");
                                                            $stmt5 -> execute([$cacus_id]);
                                                            $referrals5 = $stmt5->fetchAll(PDO::FETCH_ASSOC);
                                                            foreach($referrals5 as $referral5){
                                                                $customer_id = $referral5['ca_customer_id'];
                                                        ?>
                                                        <button class="accordion p-0">
                                                            <div class="card mb-0 rounded-0">
                                                                <div class="card-body p-2">
                                                                    <div class="row align-items-center">
                                                                        <div class="col-lg-4 col-md-4 col-sm-12 col-12 py-2">
                                                                            <div class="team-profile-img d-flex align-items-center justify-content-around">
                                                                                <div class="avatar-md img-thumbnail rounded float-start rounded-circle">
                                                                                    <img src="../../uploading/<?=$referral5['profile_pic']?>" alt="" class="img-fluid d-block rounded-circle" />
                                                                                </div>
                                                                                <div>
                                                                                    <a href="#" class="d-block">
                                                                                        <h5 class="fs-5 mb-1"><?=$referral5['firstname'].' '.$referral5['lastname'].' '.$customer_id?></h5>
                                                                                    </a>
                                                                                    <p class="text-muted mb-0">Customer</p>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-4 col-md-4 col-sm-12 col-12 py-2">
                                                                            <div class="row text-center">
                                                                                <div class="col-6 border-end">
                                                                                    <?php
                                                                                        $countCU = "SELECT COUNT(ca_customer_id) AS CATAcount FROM ca_customer WHERE reference_no='".$customer_id."' ";
                                                                                        $cuCount = $conn -> prepare($countCU);
                                                                                        $cuCount -> execute();
                                                                                        $cuCount -> setFetchMode(PDO::FETCH_ASSOC);
                                                                                        if( $cuCount -> rowCount()>0 ){
                                                                                            foreach( ($cuCount -> fetchAll()) as $keycu => $rowcu ){
                                                                                                $cuCount = $rowcu['CATAcount'];
                                                                                    ?>
                                                                                    <h5 class="mb-1"><?=$cuCount?></h5>
                                                                                    <?php
                                                                                            }
                                                                                        }
                                                                                    ?>
                                                                                    <p class="text-muted mb-0">Total Refered Customers</p>
                                                                                </div>
                                                                                <div class="col-6">
                                                                                    <?php
                                                                                        $countPAC = "SELECT COUNT(cu_id) AS PECcount FROM product_payout WHERE cu_id='".$customer_id."' ";
                                                                                        $pecCount = $conn -> prepare($countPAC);
                                                                                        $pecCount -> execute();
                                                                                        $pecCount -> setFetchMode(PDO::FETCH_ASSOC);
                                                                                        if( $pecCount -> rowCount()>0 ){
                                                                                            foreach( ($pecCount -> fetchAll()) as $keyPec => $rowPec ){
                                                                                                $PecCount = $rowPec['PECcount'];
                                                                                    ?>
                                                                                    <h5 class="mb-1">20</h5>
                                                                                    <?php
                                                                                            }
                                                                                        }
                                                                                    ?>
                                                                                    <p class="text-muted mb-0">Total Packages</p>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-2 col-md-2 col-sm-6 col-6 py-2">
                                                                            <h5 class="mb-1">Phone No</h5>
                                                                            <p class="text-muted mb-0"><?=$referral5['contact_no']?></p>
                                                                        </div>
                                                                        <div class="col-lg-2 col-md-2 col-sm-6 col-6 py-2">
                                                                            <div class="text-center">
                                                                                <a href="#" onclick="overviewPage('<?= $referral5['ca_customer_id'] .','.  $referral5['reference_no'] . ',' .$referral5['country']. ',' .$referral5['state']. ',' .$referral5['city']. ',customer' ?>')" class="btn btn-primary view-btn">View Profile</a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </button>
                                                        <!-- cumtomer ref level 2 -->
                                                        <div class="panel">
                                                            <?php
                                                                $stmt6 = $conn -> prepare(" SELECT * FROM ca_customer WHERE reference_no = ? AND status = '1' ORDER BY ca_customer_id ASC");
                                                                $stmt6 -> execute([$customer_id]);
                                                                $referrals6 = $stmt6->fetchAll(PDO::FETCH_ASSOC);
                                                                foreach($referrals6 as $referral6){
                                                                    $customer_id2 = $referral6['ca_customer_id'];
                                                            ?>
                                                            <button class="accordion p-0">
                                                                <div class="card mb-0 rounded-0">
                                                                    <div class="card-body p-2">
                                                                        <div class="row align-items-center">
                                                                            <div class="col-lg-4 col-md-4 col-sm-12 col-12 py-2">
                                                                                <div class="team-profile-img d-flex align-items-center justify-content-around">
                                                                                    <div class="avatar-md img-thumbnail rounded float-start rounded-circle">
                                                                                        <img src="../../uploading/<?=$referral6['profile_pic']?>" alt="" class="img-fluid d-block rounded-circle" />
                                                                                    </div>
                                                                                    <div>
                                                                                        <a href="#" class="d-block">
                                                                                            <h5 class="fs-5 mb-1"><?=$referral6['firstname'].' '.$referral6['lastname'].' '.$customer_id2?></h5>
                                                                                        </a>
                                                                                        <p class="text-muted mb-0">Customer</p>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-lg-4 col-md-4 col-sm-12 col-12 py-2">
                                                                                <div class="row text-center">
                                                                                    <div class="col-6 border-end">
                                                                                        <?php
                                                                                            $countCU2 = "SELECT COUNT(ca_customer_id) AS CATAcount FROM ca_customer WHERE reference_no='".$customer_id2."' ";
                                                                                            $cuCount2 = $conn -> prepare($countCU2);
                                                                                            $cuCount2 -> execute();
                                                                                            $cuCount2 -> setFetchMode(PDO::FETCH_ASSOC);
                                                                                            if( $cuCount2 -> rowCount()>0 ){
                                                                                                foreach( ($cuCount2 -> fetchAll()) as $keycu2 => $rowcu2 ){
                                                                                                    $cu2Count = $rowcu2['CATAcount'];
                                                                                        ?>
                                                                                        <h5 class="mb-1"><?= $cu2Count?></h5>
                                                                                        <?php
                                                                                                }
                                                                                            }
                                                                                        ?>
                                                                                        <p class="text-muted mb-0">Total Refered Customers</p>
                                                                                    </div>
                                                                                    <div class="col-6">
                                                                                        <?php
                                                                                            $countPAC2 = "SELECT COUNT(cu_id) AS PECcount FROM product_payout WHERE cu_id='".$customer_id2."' ";
                                                                                            $pecCount2 = $conn -> prepare($countPAC2);
                                                                                            $pecCount2 -> execute();
                                                                                            $pecCount2 -> setFetchMode(PDO::FETCH_ASSOC);
                                                                                            if( $pecCount2 -> rowCount()>0 ){
                                                                                                foreach( ($pecCount2 -> fetchAll()) as $keyPec2 => $rowPec2 ){
                                                                                                    $PecCount2 = $rowPec2['PECcount'];
                                                                                        ?>
                                                                                        <h5 class="mb-1"><?=$PecCount2?></h5>
                                                                                        <?php
                                                                                                }
                                                                                            }
                                                                                        ?>
                                                                                        <p class="text-muted mb-0">Total Packages</p>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-lg-2 col-md-2 col-sm-6 col-6 py-2">
                                                                                <h5 class="mb-1">Phone No</h5>
                                                                                <p class="text-muted mb-0"><?=$referral6['contact_no']?></p>
                                                                            </div>
                                                                            <div class="col-lg-2 col-md-2 col-sm-6 col-6 py-2">
                                                                                <div class="text-center">
                                                                                    <a href="#" onclick="overviewPage('<?= $referral6['ca_customer_id'] .','.  $referral6['reference_no'] . ',' .$referral6['country']. ',' .$referral6['state']. ',' .$referral6['city']. ',customer' ?>')" class="btn btn-primary view-btn">View Profile</a>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </button>
                                                            <!-- cumtomer ref level 3 -->
                                                            <div class="panel">
                                                                <?php
                                                                    $stmt6 = $conn -> prepare(" SELECT * FROM ca_customer WHERE reference_no = ? AND status = '1' ORDER BY ca_customer_id ASC");
                                                                    $stmt6 -> execute([$customer_id2]);
                                                                    $referrals6 = $stmt6->fetchAll(PDO::FETCH_ASSOC);
                                                                    foreach($referrals6 as $referral6){
                                                                        $customer_id3 = $referral6['ca_customer_id'];
                                                                ?>
                                                                <button class="accordion p-0">
                                                                    <div class="card mb-0 rounded-0">
                                                                        <div class="card-body p-2">
                                                                            <div class="row align-items-center">
                                                                                <div class="col-lg-4 col-md-4 col-sm-12 col-12 py-2">
                                                                                    <div class="team-profile-img d-flex align-items-center justify-content-around">
                                                                                        <div class="avatar-md img-thumbnail rounded float-start rounded-circle">
                                                                                            <img src="../../uploading/<?=$referral6['profile_pic']?>" alt="" class="img-fluid d-block rounded-circle" />
                                                                                        </div>
                                                                                        <div>
                                                                                            <a href="#" class="d-block">
                                                                                                <h5 class="fs-5 mb-1"><?=$referral6['firstname'].' '.$referral6['lastname'].' '.$customer_id3?></h5>
                                                                                            </a>
                                                                                            <p class="text-muted mb-0">Customer</p>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-lg-4 col-md-4 col-sm-12 col-12 py-2">
                                                                                    <div class="row text-center">
                                                                                        <div class="col-6 border-end">
                                                                                            <?php
                                                                                                $countCU2 = "SELECT COUNT(ca_customer_id) AS CATAcount FROM ca_customer WHERE reference_no='".$customer_id3."' ";
                                                                                                $cuCount2 = $conn -> prepare($countCU2);
                                                                                                $cuCount2 -> execute();
                                                                                                $cuCount2 -> setFetchMode(PDO::FETCH_ASSOC);
                                                                                                if( $cuCount2 -> rowCount()>0 ){
                                                                                                    foreach( ($cuCount2 -> fetchAll()) as $keycu2 => $rowcu2 ){
                                                                                                        $cu2Count = $rowcu2['CATAcount'];
                                                                                            ?>
                                                                                            <h5 class="mb-1"><?=$cu2Count?></h5>
                                                                                            <?php
                                                                                                    }
                                                                                                }
                                                                                            ?>
                                                                                            <p class="text-muted mb-0">Total Refered Customers</p>
                                                                                        </div>
                                                                                        <div class="col-6">
                                                                                            <?php
                                                                                                $countPAC2 = "SELECT COUNT(cu_id) AS PECcount FROM product_payout WHERE cu_id='".$customer_id3."' ";
                                                                                                $pecCount2 = $conn -> prepare($countPAC2);
                                                                                                $pecCount2 -> execute();
                                                                                                $pecCount2 -> setFetchMode(PDO::FETCH_ASSOC);
                                                                                                if( $pecCount2 -> rowCount()>0 ){
                                                                                                    foreach( ($pecCount2 -> fetchAll()) as $keyPec2 => $rowPec2 ){
                                                                                                        $PecCount2 = $rowPec2['PECcount'];
                                                                                            ?>
                                                                                            <h5 class="mb-1"><?=$PecCount2?></h5>
                                                                                            <?php
                                                                                                    }
                                                                                                }
                                                                                            ?>
                                                                                            <p class="text-muted mb-0">Total Packages</p>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-lg-2 col-md-2 col-sm-6 col-6 py-2">
                                                                                    <h5 class="mb-1">Phone No</h5>
                                                                                    <p class="text-muted mb-0"><?=$referral6['contact_no']?></p>
                                                                                </div>
                                                                                <div class="col-lg-2 col-md-2 col-sm-6 col-6 py-2">
                                                                                    <div class="text-center">
                                                                                        <a href="#" onclick="overviewPage('<?= $referral6['ca_customer_id'] .','.  $referral6['reference_no'] . ',' .$referral6['country']. ',' .$referral6['state']. ',' .$referral6['city']. ',customer' ?>')" class="btn btn-primary view-btn">View Profile</a>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </button>
                                                                <?php
                                                                    }
                                                                ?>
                                                            </div>
                                                            <?php
                                                                }
                                                            ?>
                                                            <!-- end cumtomer ref level 3 -->
                                                        </div>
                                                        <!-- end cumtomer ref level 2 -->
                                                        <?php
                                                            }
                                                        ?>
                                                    </div>
                                                    <!-- end customer ref level 1 -->
                                                    <?php
                                                        }
                                                    ?>
                                                </div>
                                                <!-- end all Customers onboarded by TC -->
                                                <?php
                                                    }
                                                ?>
                                            </div>
                                            <!-- end all TC recruted by TE -->
                                            <?php
                                                }
                                            ?>
                                            <!-- TC recruted by BM -->
                                            <?php
                                                $stmt2_3 = $conn -> prepare(" SELECT * FROM ca_travelagency WHERE reference_no = ? AND status = '1' ORDER BY ca_travelagency_id ASC");
                                                $stmt2_3 -> execute([$id]);
                                                $referrals2_3 = $stmt2_3->fetchAll(PDO::FETCH_ASSOC);
                                                foreach($referrals2_3 as $referral2){
                                                    $cas_id = $referral2['ca_travelagency_id'];
                                            ?>
                                            <button class="accordion p-0">
                                                <div class="card mb-0 rounded-0">
                                                    <div class="card-body p-2">
                                                        <div class="row align-items-center">
                                                            <div class="col-lg-4 col-md-4 col-sm-12 col-12 py-2">
                                                                <div class="team-profile-img d-flex align-items-center justify-content-around">
                                                                    <div class="avatar-md img-thumbnail rounded float-start rounded-circle">
                                                                        <img src="../../uploading/<?=$referral2['profile_pic']?>" alt="" class="img-fluid d-block rounded-circle" />
                                                                    </div>
                                                                    <div>
                                                                        <a href="#" class="d-block">
                                                                            <h5 class="fs-5 mb-1"><?=$referral2['firstname'].' '.$referral2['lastname'].' '.$cas_id?></h5>
                                                                        </a>
                                                                        <p class="text-muted mb-0">Travel Consultant</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4 col-md-4 col-sm-12 col-12 py-2">
                                                                <div class="row text-center">
                                                                    <div class="col-6 border-end">
                                                                        <?php
                                                                            $countCACU2 = "SELECT COUNT(ca_customer_id) AS CACUcount FROM ca_customer WHERE ta_reference_no='".$cas_id."' ";
                                                                            $cacuCount2 = $conn -> prepare($countCACU2);
                                                                            $cacuCount2 -> execute();
                                                                            $cacuCount2 -> setFetchMode(PDO::FETCH_ASSOC);
                                                                            if( $cacuCount2 -> rowCount()>0 ){
                                                                                foreach( ($cacuCount2 -> fetchAll()) as $keyCACU => $rowCACU ){
                                                                                    $CACUCount2 = $rowCACU['CACUcount'];
                                                                        ?>
                                                                        <h5 class="mb-1"><?=$CACUCount2?></h5>
                                                                        <?php
                                                                                }
                                                                            }
                                                                        ?>
                                                                        <p class="text-muted mb-0">Total Team Member</p>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <?php
                                                                            $countPAC3 = "SELECT COUNT(ta_id) AS PECcount FROM product_payout WHERE ta_id='".$cas_id."' ";
                                                                            $pecCount3 = $conn -> prepare($countPAC3);
                                                                            $pecCount3 -> execute();
                                                                            $pecCount3 -> setFetchMode(PDO::FETCH_ASSOC);
                                                                            if( $pecCount3 -> rowCount()>0 ){
                                                                                foreach( ($pecCount3 -> fetchAll()) as $keyPec => $rowPec ){
                                                                                    $PecCount3 = $rowPec['PECcount'];
                                                                        ?>
                                                                        <h5 class="mb-1"><?=$PecCount3?></h5>
                                                                        <?php
                                                                                }
                                                                            }
                                                                        ?>
                                                                        <p class="text-muted mb-0">Total Packages</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-2 col-md-2 col-sm-6 col-6 py-2">
                                                                <h5 class="mb-1">Phone No</h5>
                                                                <p class="text-muted mb-0"><?=$referral2['contact_no']?></p>
                                                            </div>
                                                            <div class="col-lg-2 col-md-2 col-sm-6 col-6 py-2">
                                                                <div class="text-center">
                                                                    <a href="#" onclick="overviewPage('<?= $referral2['ca_travelagency_id'] .','.  $referral2['reference_no'] . ',' .$referral2['country']. ',' .$referral2['state']. ',' .$referral2['city']. ',travel_consultant' ?>')" class="btn btn-primary view-btn">View Profile</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </button>
                                            <!-- all Customers onboarded by TC -->
                                                <div class="panel">
                                                    <?php
                                                        $stmt4 = $conn -> prepare(" SELECT * FROM ca_customer WHERE ta_reference_no = ? AND reference_no IS NUll AND status = '1' ORDER BY ca_customer_id ASC");
                                                        $stmt4 -> execute([$cas_id]);
                                                        $referrals4 = $stmt4->fetchAll(PDO::FETCH_ASSOC);
                                                        foreach($referrals4 as $referral4){
                                                            $cacus_id = $referral4['ca_customer_id'];
                                                    ?>
                                                    <button class="accordion p-0">
                                                        <div class="card mb-0 rounded-0">
                                                            <div class="card-body p-2">
                                                                <div class="row align-items-center">
                                                                    <div class="col-lg-4 col-md-4 col-sm-12 col-12 py-2">
                                                                        <div class="team-profile-img d-flex align-items-center justify-content-around">
                                                                            <div class="avatar-md img-thumbnail rounded float-start rounded-circle">
                                                                                <img src="../../uploading/<?=$referral4['profile_pic']?>" alt="" class="img-fluid d-block rounded-circle" />
                                                                            </div>
                                                                            <div>
                                                                                <a href="#" class="d-block">
                                                                                    <h5 class="fs-5 mb-1"><?=$referral4['firstname'].' '.$referral4['lastname'].' '.$cacus_id?></h5>
                                                                                </a>
                                                                                <p class="text-muted mb-0">Customer</p>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-4 col-md-4 col-sm-12 col-12 py-2">
                                                                        <div class="row text-center">
                                                                            <div class="col-6 border-end">
                                                                                <?php
                                                                                    $countCATACU = "SELECT COUNT(ca_customer_id) AS CATACUcount FROM ca_customer WHERE reference_no='".$cacus_id."' ";
                                                                                    $catacuCount = $conn -> prepare($countCATACU);
                                                                                    $catacuCount -> execute();
                                                                                    $catacuCount -> setFetchMode(PDO::FETCH_ASSOC);
                                                                                    if( $catacuCount -> rowCount()>0 ){
                                                                                        foreach( ($catacuCount -> fetchAll()) as $keyCATACU => $rowCATACU ){
                                                                                            $CATACUCount = $rowCATACU['CATACUcount'];
                                                                                ?>
                                                                                <h5 class="mb-1"><?=$CATACUCount?></h5>
                                                                                <?php
                                                                                        }
                                                                                    }
                                                                                ?>
                                                                                <p class="text-muted mb-0">Total Refered Customers</p>
                                                                            </div>
                                                                            <div class="col-6">
                                                                                <?php
                                                                                    $countPAC = "SELECT COUNT(cu_id) AS PECcount FROM product_payout WHERE cu_id='".$cacus_id."' ";
                                                                                    $pecCount = $conn -> prepare($countPAC);
                                                                                    $pecCount -> execute();
                                                                                    $pecCount -> setFetchMode(PDO::FETCH_ASSOC);
                                                                                    if( $pecCount -> rowCount()>0 ){
                                                                                        foreach( ($pecCount -> fetchAll()) as $keyPec => $rowPec ){
                                                                                            $PecCount = $rowPec['PECcount'];
                                                                                ?>
                                                                                <h5 class="mb-1"><?=$PecCount?></h5>
                                                                                <?php
                                                                                        }
                                                                                    }
                                                                                ?>
                                                                                <p class="text-muted mb-0">Total Packages</p>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-2 col-md-2 col-sm-6 col-6 py-2">
                                                                        <h5 class="mb-1">Phone No</h5>
                                                                        <p class="text-muted mb-0"><?=$referral4['contact_no']?></p>
                                                                    </div>
                                                                    <div class="col-lg-2 col-md-2 col-sm-6 col-6 py-2">
                                                                        <div class="text-center">
                                                                            <a href="#" onclick="overviewPage('<?= $referral4['ca_customer_id'] .','.  $referral4['reference_no'] . ',' .$referral4['country']. ',' .$referral4['state']. ',' .$referral4['city']. ',customer' ?>')" class="btn btn-primary view-btn">View Profile</a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </button>
                                                    <!-- customer ref level 1 -->
                                                    <div class="panel">
                                                        <?php
                                                            $stmt5 = $conn -> prepare(" SELECT * FROM ca_customer WHERE reference_no = ? AND status = '1' ORDER BY ca_customer_id ASC");
                                                            $stmt5 -> execute([$cacus_id]);
                                                            $referrals5 = $stmt5->fetchAll(PDO::FETCH_ASSOC);
                                                            foreach($referrals5 as $referral5){
                                                                $customer_id = $referral5['ca_customer_id'];
                                                        ?>
                                                        <button class="accordion p-0">
                                                            <div class="card mb-0 rounded-0">
                                                                <div class="card-body p-2">
                                                                    <div class="row align-items-center">
                                                                        <div class="col-lg-4 col-md-4 col-sm-12 col-12 py-2">
                                                                            <div class="team-profile-img d-flex align-items-center justify-content-around">
                                                                                <div class="avatar-md img-thumbnail rounded float-start rounded-circle">
                                                                                    <img src="../../uploading/<?=$referral5['profile_pic']?>" alt="" class="img-fluid d-block rounded-circle" />
                                                                                </div>
                                                                                <div>
                                                                                    <a href="#" class="d-block">
                                                                                        <h5 class="fs-5 mb-1"><?=$referral5['firstname'].' '.$referral5['lastname'].' '.$customer_id?></h5>
                                                                                    </a>
                                                                                    <p class="text-muted mb-0">Customer</p>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-4 col-md-4 col-sm-12 col-12 py-2">
                                                                            <div class="row text-center">
                                                                                <div class="col-6 border-end">
                                                                                    <?php
                                                                                        $countCU = "SELECT COUNT(ca_customer_id) AS CATAcount FROM ca_customer WHERE reference_no='".$customer_id."' ";
                                                                                        $cuCount = $conn -> prepare($countCU);
                                                                                        $cuCount -> execute();
                                                                                        $cuCount -> setFetchMode(PDO::FETCH_ASSOC);
                                                                                        if( $cuCount -> rowCount()>0 ){
                                                                                            foreach( ($cuCount -> fetchAll()) as $keycu => $rowcu ){
                                                                                                $cuCount = $rowcu['CATAcount'];
                                                                                    ?>
                                                                                    <h5 class="mb-1"><?=$cuCount?></h5>
                                                                                    <?php
                                                                                            }
                                                                                        }
                                                                                    ?>
                                                                                    <p class="text-muted mb-0">Total Refered Customers</p>
                                                                                </div>
                                                                                <div class="col-6">
                                                                                    <?php
                                                                                        $countPAC = "SELECT COUNT(cu_id) AS PECcount FROM product_payout WHERE cu_id='".$customer_id."' ";
                                                                                        $pecCount = $conn -> prepare($countPAC);
                                                                                        $pecCount -> execute();
                                                                                        $pecCount -> setFetchMode(PDO::FETCH_ASSOC);
                                                                                        if( $pecCount -> rowCount()>0 ){
                                                                                            foreach( ($pecCount -> fetchAll()) as $keyPec => $rowPec ){
                                                                                                $PecCount = $rowPec['PECcount'];
                                                                                    ?>
                                                                                    <h5 class="mb-1">20</h5>
                                                                                    <?php
                                                                                            }
                                                                                        }
                                                                                    ?>
                                                                                    <p class="text-muted mb-0">Total Packages</p>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-2 col-md-2 col-sm-6 col-6 py-2">
                                                                            <h5 class="mb-1">Phone No</h5>
                                                                            <p class="text-muted mb-0"><?=$referral5['contact_no']?></p>
                                                                        </div>
                                                                        <div class="col-lg-2 col-md-2 col-sm-6 col-6 py-2">
                                                                            <div class="text-center">
                                                                                <a href="#" onclick="overviewPage('<?= $referral5['ca_customer_id'] .','.  $referral5['reference_no'] . ',' .$referral5['country']. ',' .$referral5['state']. ',' .$referral5['city']. ',customer' ?>')" class="btn btn-primary view-btn">View Profile</a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </button>
                                                        <!-- cumtomer ref level 2 -->
                                                        <div class="panel">
                                                            <?php
                                                                $stmt6 = $conn -> prepare(" SELECT * FROM ca_customer WHERE reference_no = ? AND status = '1' ORDER BY ca_customer_id ASC");
                                                                $stmt6 -> execute([$customer_id]);
                                                                $referrals6 = $stmt6->fetchAll(PDO::FETCH_ASSOC);
                                                                foreach($referrals6 as $referral6){
                                                                    $customer_id2 = $referral6['ca_customer_id'];
                                                            ?>
                                                            <button class="accordion p-0">
                                                                <div class="card mb-0 rounded-0">
                                                                    <div class="card-body p-2">
                                                                        <div class="row align-items-center">
                                                                            <div class="col-lg-4 col-md-4 col-sm-12 col-12 py-2">
                                                                                <div class="team-profile-img d-flex align-items-center justify-content-around">
                                                                                    <div class="avatar-md img-thumbnail rounded float-start rounded-circle">
                                                                                        <img src="../../uploading/<?=$referral6['profile_pic']?>" alt="" class="img-fluid d-block rounded-circle" />
                                                                                    </div>
                                                                                    <div>
                                                                                        <a href="#" class="d-block">
                                                                                            <h5 class="fs-5 mb-1"><?=$referral6['firstname'].' '.$referral6['lastname'].' '.$customer_id2?></h5>
                                                                                        </a>
                                                                                        <p class="text-muted mb-0">Customer</p>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-lg-4 col-md-4 col-sm-12 col-12 py-2">
                                                                                <div class="row text-center">
                                                                                    <div class="col-6 border-end">
                                                                                        <?php
                                                                                            $countCU2 = "SELECT COUNT(ca_customer_id) AS CATAcount FROM ca_customer WHERE reference_no='".$customer_id2."' ";
                                                                                            $cuCount2 = $conn -> prepare($countCU2);
                                                                                            $cuCount2 -> execute();
                                                                                            $cuCount2 -> setFetchMode(PDO::FETCH_ASSOC);
                                                                                            if( $cuCount2 -> rowCount()>0 ){
                                                                                                foreach( ($cuCount2 -> fetchAll()) as $keycu2 => $rowcu2 ){
                                                                                                    $cu2Count = $rowcu2['CATAcount'];
                                                                                        ?>
                                                                                        <h5 class="mb-1"><?= $cu2Count?></h5>
                                                                                        <?php
                                                                                                }
                                                                                            }
                                                                                        ?>
                                                                                        <p class="text-muted mb-0">Total Refered Customers</p>
                                                                                    </div>
                                                                                    <div class="col-6">
                                                                                        <?php
                                                                                            $countPAC2 = "SELECT COUNT(cu_id) AS PECcount FROM product_payout WHERE cu_id='".$customer_id2."' ";
                                                                                            $pecCount2 = $conn -> prepare($countPAC2);
                                                                                            $pecCount2 -> execute();
                                                                                            $pecCount2 -> setFetchMode(PDO::FETCH_ASSOC);
                                                                                            if( $pecCount2 -> rowCount()>0 ){
                                                                                                foreach( ($pecCount2 -> fetchAll()) as $keyPec2 => $rowPec2 ){
                                                                                                    $PecCount2 = $rowPec2['PECcount'];
                                                                                        ?>
                                                                                        <h5 class="mb-1"><?=$PecCount2?></h5>
                                                                                        <?php
                                                                                                }
                                                                                            }
                                                                                        ?>
                                                                                        <p class="text-muted mb-0">Total Packages</p>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-lg-2 col-md-2 col-sm-6 col-6 py-2">
                                                                                <h5 class="mb-1">Phone No</h5>
                                                                                <p class="text-muted mb-0"><?=$referral6['contact_no']?></p>
                                                                            </div>
                                                                            <div class="col-lg-2 col-md-2 col-sm-6 col-6 py-2">
                                                                                <div class="text-center">
                                                                                    <a href="#" onclick="overviewPage('<?= $referral6['ca_customer_id'] .','.  $referral6['reference_no'] . ',' .$referral6['country']. ',' .$referral6['state']. ',' .$referral6['city']. ',customer' ?>')" class="btn btn-primary view-btn">View Profile</a>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </button>
                                                            <!-- cumtomer ref level 3 -->
                                                            <div class="panel">
                                                                <?php
                                                                    $stmt6 = $conn -> prepare(" SELECT * FROM ca_customer WHERE reference_no = ? AND status = '1' ORDER BY ca_customer_id ASC");
                                                                    $stmt6 -> execute([$customer_id2]);
                                                                    $referrals6 = $stmt6->fetchAll(PDO::FETCH_ASSOC);
                                                                    foreach($referrals6 as $referral6){
                                                                        $customer_id3 = $referral6['ca_customer_id'];
                                                                ?>
                                                                <button class="accordion p-0">
                                                                    <div class="card mb-0 rounded-0">
                                                                        <div class="card-body p-2">
                                                                            <div class="row align-items-center">
                                                                                <div class="col-lg-4 col-md-4 col-sm-12 col-12 py-2">
                                                                                    <div class="team-profile-img d-flex align-items-center justify-content-around">
                                                                                        <div class="avatar-md img-thumbnail rounded float-start rounded-circle">
                                                                                            <img src="../../uploading/<?=$referral6['profile_pic']?>" alt="" class="img-fluid d-block rounded-circle" />
                                                                                        </div>
                                                                                        <div>
                                                                                            <a href="#" class="d-block">
                                                                                                <h5 class="fs-5 mb-1"><?=$referral6['firstname'].' '.$referral6['lastname'].' '.$customer_id3?></h5>
                                                                                            </a>
                                                                                            <p class="text-muted mb-0">Customer</p>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-lg-4 col-md-4 col-sm-12 col-12 py-2">
                                                                                    <div class="row text-center">
                                                                                        <div class="col-6 border-end">
                                                                                            <?php
                                                                                                $countCU2 = "SELECT COUNT(ca_customer_id) AS CATAcount FROM ca_customer WHERE reference_no='".$customer_id3."' ";
                                                                                                $cuCount2 = $conn -> prepare($countCU2);
                                                                                                $cuCount2 -> execute();
                                                                                                $cuCount2 -> setFetchMode(PDO::FETCH_ASSOC);
                                                                                                if( $cuCount2 -> rowCount()>0 ){
                                                                                                    foreach( ($cuCount2 -> fetchAll()) as $keycu2 => $rowcu2 ){
                                                                                                        $cu2Count = $rowcu2['CATAcount'];
                                                                                            ?>
                                                                                            <h5 class="mb-1"><?=$cu2Count?></h5>
                                                                                            <?php
                                                                                                    }
                                                                                                }
                                                                                            ?>
                                                                                            <p class="text-muted mb-0">Total Refered Customers</p>
                                                                                        </div>
                                                                                        <div class="col-6">
                                                                                            <?php
                                                                                                $countPAC2 = "SELECT COUNT(cu_id) AS PECcount FROM product_payout WHERE cu_id='".$customer_id3."' ";
                                                                                                $pecCount2 = $conn -> prepare($countPAC2);
                                                                                                $pecCount2 -> execute();
                                                                                                $pecCount2 -> setFetchMode(PDO::FETCH_ASSOC);
                                                                                                if( $pecCount2 -> rowCount()>0 ){
                                                                                                    foreach( ($pecCount2 -> fetchAll()) as $keyPec2 => $rowPec2 ){
                                                                                                        $PecCount2 = $rowPec2['PECcount'];
                                                                                            ?>
                                                                                            <h5 class="mb-1"><?=$PecCount2?></h5>
                                                                                            <?php
                                                                                                    }
                                                                                                }
                                                                                            ?>
                                                                                            <p class="text-muted mb-0">Total Packages</p>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-lg-2 col-md-2 col-sm-6 col-6 py-2">
                                                                                    <h5 class="mb-1">Phone No</h5>
                                                                                    <p class="text-muted mb-0"><?=$referral6['contact_no']?></p>
                                                                                </div>
                                                                                <div class="col-lg-2 col-md-2 col-sm-6 col-6 py-2">
                                                                                    <div class="text-center">
                                                                                        <a href="#" onclick="overviewPage('<?= $referral6['ca_customer_id'] .','.  $referral6['reference_no'] . ',' .$referral6['country']. ',' .$referral6['state']. ',' .$referral6['city']. ',customer' ?>')" class="btn btn-primary view-btn">View Profile</a>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </button>
                                                                <?php
                                                                    }
                                                                ?>
                                                            </div>
                                                            <?php
                                                                }
                                                            ?>
                                                            <!-- end cumtomer ref level 3 -->
                                                        </div>
                                                        <!-- end cumtomer ref level 2 -->
                                                        <?php
                                                            }
                                                        ?>
                                                    </div>
                                                    <!-- end customer ref level 1 -->
                                                    <?php
                                                        }
                                                    ?>
                                                </div>
                                                <!-- end all Customers onboarded by TC -->
                                            <?php
                                                 }
                                        }
                                        ?>
                                        <!-- end TC recruted by BM -->
                                        
                                    </div>
                                    <!-- end all TE under given BM -->
                                    <!-- end all bms -->
                                    <!-- all TC recruted by TE -->
                                    <?php 
                                    }else if($DBtable == 'corporate_agency'){
                                        $stmt2_3 = $conn -> prepare(" SELECT * FROM ca_travelagency WHERE reference_no = ? AND status = '1' ORDER BY ca_travelagency_id ASC");
                                        $stmt2_3 -> execute([$id]);
                                        $stmt2_3 ->setFetchMode(PDO::FETCH_ASSOC);
                                        if ($stmt2_3 -> rowCount() == 0) {
                                    ?>
                                    <div class="row pt-3">
                                        <div class="col-md-2">
                                            <div class="d-flex align-items-center justify-content-center p-3 position">
                                                <img src="../../uploading/not_uploaded.png" width="50" height="50" class="rounded-circle ms-3" />
                                            </div>
                                        </div>
                                        <div class="col-md-9">
                                            <div class="">
                                                <div class="card bg-light p-2 mt-2">
                                                    <div class="d-flex justify-content-between">
                                                        <h4 class="">-----</h4>
                                                        <p class="d-inline">--/--/----</p>
                                                    </div>
                                                    <p class="my-0 cardText">No Team memebers found</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php        
                                        }else{

                                            $referrals2_3 = $stmt2_3->fetchAll(PDO::FETCH_ASSOC);
                                            foreach($referrals2_3 as $referral2){
                                                $cas_id = $referral2['ca_travelagency_id'];
                                        ?>
                                        <button class="accordion p-0">
                                            <div class="card mb-0 rounded-0">
                                                <div class="card-body p-2">
                                                    <div class="row align-items-center">
                                                        <div class="col-lg-4 col-md-4 col-sm-12 col-12 py-2">
                                                            <div class="team-profile-img d-flex align-items-center justify-content-around">
                                                                <div class="avatar-md img-thumbnail rounded float-start rounded-circle">
                                                                    <img src="../../uploading/<?=$referral2['profile_pic']?>" alt="" class="img-fluid d-block rounded-circle" />
                                                                </div>
                                                                <div>
                                                                    <a href="#" class="d-block">
                                                                        <h5 class="fs-5 mb-1"><?=$referral2['firstname'].' '.$referral2['lastname'].' '.$cas_id?></h5>
                                                                    </a>
                                                                    <p class="text-muted mb-0">Travel Consultant</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4 col-md-4 col-sm-12 col-12 py-2">
                                                            <div class="row text-center">
                                                                <div class="col-6 border-end">
                                                                    <?php
                                                                        $countCACU2 = "SELECT COUNT(ca_customer_id) AS CACUcount FROM ca_customer WHERE ta_reference_no='".$cas_id."' ";
                                                                        $cacuCount2 = $conn -> prepare($countCACU2);
                                                                        $cacuCount2 -> execute();
                                                                        $cacuCount2 -> setFetchMode(PDO::FETCH_ASSOC);
                                                                        if( $cacuCount2 -> rowCount()>0 ){
                                                                            foreach( ($cacuCount2 -> fetchAll()) as $keyCACU => $rowCACU ){
                                                                                $CACUCount2 = $rowCACU['CACUcount'];
                                                                    ?>
                                                                    <h5 class="mb-1"><?=$CACUCount2?></h5>
                                                                    <?php
                                                                            }
                                                                        }
                                                                    ?>
                                                                    <p class="text-muted mb-0">Total Team Member</p>
                                                                </div>
                                                                <div class="col-6">
                                                                    <?php
                                                                        $countPAC3 = "SELECT COUNT(ta_id) AS PECcount FROM product_payout WHERE ta_id='".$cas_id."' ";
                                                                        $pecCount3 = $conn -> prepare($countPAC3);
                                                                        $pecCount3 -> execute();
                                                                        $pecCount3 -> setFetchMode(PDO::FETCH_ASSOC);
                                                                        if( $pecCount3 -> rowCount()>0 ){
                                                                            foreach( ($pecCount3 -> fetchAll()) as $keyPec => $rowPec ){
                                                                                $PecCount3 = $rowPec['PECcount'];
                                                                    ?>
                                                                    <h5 class="mb-1"><?=$PecCount3?></h5>
                                                                    <?php
                                                                            }
                                                                        }
                                                                    ?>
                                                                    <p class="text-muted mb-0">Total Packages</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-2 col-md-2 col-sm-6 col-6 py-2">
                                                            <h5 class="mb-1">Phone No</h5>
                                                            <p class="text-muted mb-0"><?=$referral2['contact_no']?></p>
                                                        </div>
                                                        <div class="col-lg-2 col-md-2 col-sm-6 col-6 py-2">
                                                            <div class="text-center">
                                                                <a href="#" onclick="overviewPage('<?= $referral2['ca_travelagency_id'] .','.  $referral2['reference_no'] . ',' .$referral2['country']. ',' .$referral2['state']. ',' .$referral2['city']. ',travel_consultant' ?>')" class="btn btn-primary view-btn">View Profile</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </button>
                                        <!-- all Customers onboarded by TC -->
                                            <div class="panel">
                                                <?php
                                                    $stmt4 = $conn -> prepare(" SELECT * FROM ca_customer WHERE ta_reference_no = ? AND reference_no IS NUll AND status = '1' ORDER BY ca_customer_id ASC");
                                                    $stmt4 -> execute([$cas_id]);
                                                    $referrals4 = $stmt4->fetchAll(PDO::FETCH_ASSOC);
                                                    foreach($referrals4 as $referral4){
                                                        $cacus_id = $referral4['ca_customer_id'];
                                                ?>
                                                <button class="accordion p-0">
                                                    <div class="card mb-0 rounded-0">
                                                        <div class="card-body p-2">
                                                            <div class="row align-items-center">
                                                                <div class="col-lg-4 col-md-4 col-sm-12 col-12 py-2">
                                                                    <div class="team-profile-img d-flex align-items-center justify-content-around">
                                                                        <div class="avatar-md img-thumbnail rounded float-start rounded-circle">
                                                                            <img src="../../uploading/<?=$referral4['profile_pic']?>" alt="" class="img-fluid d-block rounded-circle" />
                                                                        </div>
                                                                        <div>
                                                                            <a href="#" class="d-block">
                                                                                <h5 class="fs-5 mb-1"><?=$referral4['firstname'].' '.$referral4['lastname'].' '.$cacus_id?></h5>
                                                                            </a>
                                                                            <p class="text-muted mb-0">Customer</p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-4 col-md-4 col-sm-12 col-12 py-2">
                                                                    <div class="row text-center">
                                                                        <div class="col-6 border-end">
                                                                            <?php
                                                                                $countCATACU = "SELECT COUNT(ca_customer_id) AS CATACUcount FROM ca_customer WHERE reference_no='".$cacus_id."' ";
                                                                                $catacuCount = $conn -> prepare($countCATACU);
                                                                                $catacuCount -> execute();
                                                                                $catacuCount -> setFetchMode(PDO::FETCH_ASSOC);
                                                                                if( $catacuCount -> rowCount()>0 ){
                                                                                    foreach( ($catacuCount -> fetchAll()) as $keyCATACU => $rowCATACU ){
                                                                                        $CATACUCount = $rowCATACU['CATACUcount'];
                                                                            ?>
                                                                            <h5 class="mb-1"><?=$CATACUCount?></h5>
                                                                            <?php
                                                                                    }
                                                                                }
                                                                            ?>
                                                                            <p class="text-muted mb-0">Total Refered Customers</p>
                                                                        </div>
                                                                        <div class="col-6">
                                                                            <?php
                                                                                $countPAC = "SELECT COUNT(cu_id) AS PECcount FROM product_payout WHERE cu_id='".$cacus_id."' ";
                                                                                $pecCount = $conn -> prepare($countPAC);
                                                                                $pecCount -> execute();
                                                                                $pecCount -> setFetchMode(PDO::FETCH_ASSOC);
                                                                                if( $pecCount -> rowCount()>0 ){
                                                                                    foreach( ($pecCount -> fetchAll()) as $keyPec => $rowPec ){
                                                                                        $PecCount = $rowPec['PECcount'];
                                                                            ?>
                                                                            <h5 class="mb-1"><?=$PecCount?></h5>
                                                                            <?php
                                                                                    }
                                                                                }
                                                                            ?>
                                                                            <p class="text-muted mb-0">Total Packages</p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-2 col-md-2 col-sm-6 col-6 py-2">
                                                                    <h5 class="mb-1">Phone No</h5>
                                                                    <p class="text-muted mb-0"><?=$referral4['contact_no']?></p>
                                                                </div>
                                                                <div class="col-lg-2 col-md-2 col-sm-6 col-6 py-2">
                                                                    <div class="text-center">
                                                                        <a href="#" onclick="overviewPage('<?= $referral4['ca_customer_id'] .','.  $referral4['reference_no'] . ',' .$referral4['country']. ',' .$referral4['state']. ',' .$referral4['city']. ',customer' ?>')" class="btn btn-primary view-btn">View Profile</a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </button>
                                                <!-- customer ref level 1 -->
                                                <div class="panel">
                                                    <?php
                                                        $stmt5 = $conn -> prepare(" SELECT * FROM ca_customer WHERE reference_no = ? AND status = '1' ORDER BY ca_customer_id ASC");
                                                        $stmt5 -> execute([$cacus_id]);
                                                        $referrals5 = $stmt5->fetchAll(PDO::FETCH_ASSOC);
                                                        foreach($referrals5 as $referral5){
                                                            $customer_id = $referral5['ca_customer_id'];
                                                    ?>
                                                    <button class="accordion p-0">
                                                        <div class="card mb-0 rounded-0">
                                                            <div class="card-body p-2">
                                                                <div class="row align-items-center">
                                                                    <div class="col-lg-4 col-md-4 col-sm-12 col-12 py-2">
                                                                        <div class="team-profile-img d-flex align-items-center justify-content-around">
                                                                            <div class="avatar-md img-thumbnail rounded float-start rounded-circle">
                                                                                <img src="../../uploading/<?=$referral5['profile_pic']?>" alt="" class="img-fluid d-block rounded-circle" />
                                                                            </div>
                                                                            <div>
                                                                                <a href="#" class="d-block">
                                                                                    <h5 class="fs-5 mb-1"><?=$referral5['firstname'].' '.$referral5['lastname'].' '.$customer_id?></h5>
                                                                                </a>
                                                                                <p class="text-muted mb-0">Customer</p>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-4 col-md-4 col-sm-12 col-12 py-2">
                                                                        <div class="row text-center">
                                                                            <div class="col-6 border-end">
                                                                                <?php
                                                                                    $countCU = "SELECT COUNT(ca_customer_id) AS CATAcount FROM ca_customer WHERE reference_no='".$customer_id."' ";
                                                                                    $cuCount = $conn -> prepare($countCU);
                                                                                    $cuCount -> execute();
                                                                                    $cuCount -> setFetchMode(PDO::FETCH_ASSOC);
                                                                                    if( $cuCount -> rowCount()>0 ){
                                                                                        foreach( ($cuCount -> fetchAll()) as $keycu => $rowcu ){
                                                                                            $cuCount = $rowcu['CATAcount'];
                                                                                ?>
                                                                                <h5 class="mb-1"><?=$cuCount?></h5>
                                                                                <?php
                                                                                        }
                                                                                    }
                                                                                ?>
                                                                                <p class="text-muted mb-0">Total Refered Customers</p>
                                                                            </div>
                                                                            <div class="col-6">
                                                                                <?php
                                                                                    $countPAC = "SELECT COUNT(cu_id) AS PECcount FROM product_payout WHERE cu_id='".$customer_id."' ";
                                                                                    $pecCount = $conn -> prepare($countPAC);
                                                                                    $pecCount -> execute();
                                                                                    $pecCount -> setFetchMode(PDO::FETCH_ASSOC);
                                                                                    if( $pecCount -> rowCount()>0 ){
                                                                                        foreach( ($pecCount -> fetchAll()) as $keyPec => $rowPec ){
                                                                                            $PecCount = $rowPec['PECcount'];
                                                                                ?>
                                                                                <h5 class="mb-1">20</h5>
                                                                                <?php
                                                                                        }
                                                                                    }
                                                                                ?>
                                                                                <p class="text-muted mb-0">Total Packages</p>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-2 col-md-2 col-sm-6 col-6 py-2">
                                                                        <h5 class="mb-1">Phone No</h5>
                                                                        <p class="text-muted mb-0"><?=$referral5['contact_no']?></p>
                                                                    </div>
                                                                    <div class="col-lg-2 col-md-2 col-sm-6 col-6 py-2">
                                                                        <div class="text-center">
                                                                            <a href="#" onclick="overviewPage('<?= $referral5['ca_customer_id'] .','.  $referral5['reference_no'] . ',' .$referral5['country']. ',' .$referral5['state']. ',' .$referral5['city']. ',customer' ?>')" class="btn btn-primary view-btn">View Profile</a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </button>
                                                    <!-- cumtomer ref level 2 -->
                                                    <div class="panel">
                                                        <?php
                                                            $stmt6 = $conn -> prepare(" SELECT * FROM ca_customer WHERE reference_no = ? AND status = '1' ORDER BY ca_customer_id ASC");
                                                            $stmt6 -> execute([$customer_id]);
                                                            $referrals6 = $stmt6->fetchAll(PDO::FETCH_ASSOC);
                                                            foreach($referrals6 as $referral6){
                                                                $customer_id2 = $referral6['ca_customer_id'];
                                                        ?>
                                                        <button class="accordion p-0">
                                                            <div class="card mb-0 rounded-0">
                                                                <div class="card-body p-2">
                                                                    <div class="row align-items-center">
                                                                        <div class="col-lg-4 col-md-4 col-sm-12 col-12 py-2">
                                                                            <div class="team-profile-img d-flex align-items-center justify-content-around">
                                                                                <div class="avatar-md img-thumbnail rounded float-start rounded-circle">
                                                                                    <img src="../../uploading/<?=$referral6['profile_pic']?>" alt="" class="img-fluid d-block rounded-circle" />
                                                                                </div>
                                                                                <div>
                                                                                    <a href="#" class="d-block">
                                                                                        <h5 class="fs-5 mb-1"><?=$referral6['firstname'].' '.$referral6['lastname'].' '.$customer_id2?></h5>
                                                                                    </a>
                                                                                    <p class="text-muted mb-0">Customer</p>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-4 col-md-4 col-sm-12 col-12 py-2">
                                                                            <div class="row text-center">
                                                                                <div class="col-6 border-end">
                                                                                    <?php
                                                                                        $countCU2 = "SELECT COUNT(ca_customer_id) AS CATAcount FROM ca_customer WHERE reference_no='".$customer_id2."' ";
                                                                                        $cuCount2 = $conn -> prepare($countCU2);
                                                                                        $cuCount2 -> execute();
                                                                                        $cuCount2 -> setFetchMode(PDO::FETCH_ASSOC);
                                                                                        if( $cuCount2 -> rowCount()>0 ){
                                                                                            foreach( ($cuCount2 -> fetchAll()) as $keycu2 => $rowcu2 ){
                                                                                                $cu2Count = $rowcu2['CATAcount'];
                                                                                    ?>
                                                                                    <h5 class="mb-1"><?= $cu2Count?></h5>
                                                                                    <?php
                                                                                            }
                                                                                        }
                                                                                    ?>
                                                                                    <p class="text-muted mb-0">Total Refered Customers</p>
                                                                                </div>
                                                                                <div class="col-6">
                                                                                    <?php
                                                                                        $countPAC2 = "SELECT COUNT(cu_id) AS PECcount FROM product_payout WHERE cu_id='".$customer_id2."' ";
                                                                                        $pecCount2 = $conn -> prepare($countPAC2);
                                                                                        $pecCount2 -> execute();
                                                                                        $pecCount2 -> setFetchMode(PDO::FETCH_ASSOC);
                                                                                        if( $pecCount2 -> rowCount()>0 ){
                                                                                            foreach( ($pecCount2 -> fetchAll()) as $keyPec2 => $rowPec2 ){
                                                                                                $PecCount2 = $rowPec2['PECcount'];
                                                                                    ?>
                                                                                    <h5 class="mb-1"><?=$PecCount2?></h5>
                                                                                    <?php
                                                                                            }
                                                                                        }
                                                                                    ?>
                                                                                    <p class="text-muted mb-0">Total Packages</p>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-2 col-md-2 col-sm-6 col-6 py-2">
                                                                            <h5 class="mb-1">Phone No</h5>
                                                                            <p class="text-muted mb-0"><?=$referral6['contact_no']?></p>
                                                                        </div>
                                                                        <div class="col-lg-2 col-md-2 col-sm-6 col-6 py-2">
                                                                            <div class="text-center">
                                                                                <a href="#" onclick="overviewPage('<?= $referral6['ca_customer_id'] .','.  $referral6['reference_no'] . ',' .$referral6['country']. ',' .$referral6['state']. ',' .$referral6['city']. ',customer' ?>')" class="btn btn-primary view-btn">View Profile</a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </button>
                                                        <!-- cumtomer ref level 3 -->
                                                        <div class="panel">
                                                            <?php
                                                                $stmt6 = $conn -> prepare(" SELECT * FROM ca_customer WHERE reference_no = ? AND status = '1' ORDER BY ca_customer_id ASC");
                                                                $stmt6 -> execute([$customer_id2]);
                                                                $referrals6 = $stmt6->fetchAll(PDO::FETCH_ASSOC);
                                                                foreach($referrals6 as $referral6){
                                                                    $customer_id3 = $referral6['ca_customer_id'];
                                                            ?>
                                                            <button class="accordion p-0">
                                                                <div class="card mb-0 rounded-0">
                                                                    <div class="card-body p-2">
                                                                        <div class="row align-items-center">
                                                                            <div class="col-lg-4 col-md-4 col-sm-12 col-12 py-2">
                                                                                <div class="team-profile-img d-flex align-items-center justify-content-around">
                                                                                    <div class="avatar-md img-thumbnail rounded float-start rounded-circle">
                                                                                        <img src="../../uploading/<?=$referral6['profile_pic']?>" alt="" class="img-fluid d-block rounded-circle" />
                                                                                    </div>
                                                                                    <div>
                                                                                        <a href="#" class="d-block">
                                                                                            <h5 class="fs-5 mb-1"><?=$referral6['firstname'].' '.$referral6['lastname'].' '.$customer_id3?></h5>
                                                                                        </a>
                                                                                        <p class="text-muted mb-0">Customer</p>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-lg-4 col-md-4 col-sm-12 col-12 py-2">
                                                                                <div class="row text-center">
                                                                                    <div class="col-6 border-end">
                                                                                        <?php
                                                                                            $countCU2 = "SELECT COUNT(ca_customer_id) AS CATAcount FROM ca_customer WHERE reference_no='".$customer_id3."' ";
                                                                                            $cuCount2 = $conn -> prepare($countCU2);
                                                                                            $cuCount2 -> execute();
                                                                                            $cuCount2 -> setFetchMode(PDO::FETCH_ASSOC);
                                                                                            if( $cuCount2 -> rowCount()>0 ){
                                                                                                foreach( ($cuCount2 -> fetchAll()) as $keycu2 => $rowcu2 ){
                                                                                                    $cu2Count = $rowcu2['CATAcount'];
                                                                                        ?>
                                                                                        <h5 class="mb-1"><?=$cu2Count?></h5>
                                                                                        <?php
                                                                                                }
                                                                                            }
                                                                                        ?>
                                                                                        <p class="text-muted mb-0">Total Refered Customers</p>
                                                                                    </div>
                                                                                    <div class="col-6">
                                                                                        <?php
                                                                                            $countPAC2 = "SELECT COUNT(cu_id) AS PECcount FROM product_payout WHERE cu_id='".$customer_id3."' ";
                                                                                            $pecCount2 = $conn -> prepare($countPAC2);
                                                                                            $pecCount2 -> execute();
                                                                                            $pecCount2 -> setFetchMode(PDO::FETCH_ASSOC);
                                                                                            if( $pecCount2 -> rowCount()>0 ){
                                                                                                foreach( ($pecCount2 -> fetchAll()) as $keyPec2 => $rowPec2 ){
                                                                                                    $PecCount2 = $rowPec2['PECcount'];
                                                                                        ?>
                                                                                        <h5 class="mb-1"><?=$PecCount2?></h5>
                                                                                        <?php
                                                                                                }
                                                                                            }
                                                                                        ?>
                                                                                        <p class="text-muted mb-0">Total Packages</p>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-lg-2 col-md-2 col-sm-6 col-6 py-2">
                                                                                <h5 class="mb-1">Phone No</h5>
                                                                                <p class="text-muted mb-0"><?=$referral6['contact_no']?></p>
                                                                            </div>
                                                                            <div class="col-lg-2 col-md-2 col-sm-6 col-6 py-2">
                                                                                <div class="text-center">
                                                                                    <a href="#" onclick="overviewPage('<?= $referral6['ca_customer_id'] .','.  $referral6['reference_no'] . ',' .$referral6['country']. ',' .$referral6['state']. ',' .$referral6['city']. ',customer' ?>')" class="btn btn-primary view-btn">View Profile</a>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </button>
                                                            <?php
                                                                }
                                                            ?>
                                                        </div>
                                                        <?php
                                                            }
                                                        ?>
                                                        <!-- end cumtomer ref level 3 -->
                                                    </div>
                                                    <!-- end cumtomer ref level 2 -->
                                                    <?php
                                                        }
                                                    ?>
                                                </div>
                                                <!-- end customer ref level 1 -->
                                                <?php
                                                    }
                                                ?>
                                            </div>
                                        <!-- end all Customers onboarded by TC -->
                                        <!-- end TC recruted by TE -->
                                        <!-- all Customers onboarded by TC -->
                                    <?php
                                            }
                                        }
                                    }else if ($DBtable == 'ca_travelagency'){
                                    
                                        $stmt4 = $conn -> prepare(" SELECT * FROM ca_customer WHERE ta_reference_no = ? AND reference_no IS NUll AND status = '1' ORDER BY ca_customer_id ASC");
                                        $stmt4 -> execute([$id]);
                                        $stmt4 -> setFetchMode(PDO::FETCH_ASSOC);
                                        if ($stmt4 -> rowCount() == 0) {
                                        ?>
                                        <div class="row pt-3">
                                            <div class="col-md-2">
                                                <div class="d-flex align-items-center justify-content-center p-3 position">
                                                    <img src="../../uploading/not_uploaded.png" width="50" height="50" class="rounded-circle ms-3" />
                                                </div>
                                            </div>
                                            <div class="col-md-9">
                                                <div class="">
                                                    <div class="card bg-light p-2 mt-2">
                                                        <div class="d-flex justify-content-between">
                                                            <h4 class="">-----</h4>
                                                            <p class="d-inline">--/--/----</p>
                                                        </div>
                                                        <p class="my-0 cardText">No Team memebers found</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php   
                                        }else{

                                            $referrals4 = $stmt4->fetchAll(PDO::FETCH_ASSOC);
                                            foreach($referrals4 as $referral4){
                                                $cacus_id = $referral4['ca_customer_id'];
                                        ?>
                                        <button class="accordion p-0">
                                            <div class="card mb-0 rounded-0">
                                                <div class="card-body p-2">
                                                    <div class="row align-items-center">
                                                        <div class="col-lg-4 col-md-4 col-sm-12 col-12 py-2">
                                                            <div class="team-profile-img d-flex align-items-center justify-content-around">
                                                                <div class="avatar-md img-thumbnail rounded float-start rounded-circle">
                                                                    <img src="../../uploading/<?=$referral4['profile_pic']?>" alt="" class="img-fluid d-block rounded-circle" />
                                                                </div>
                                                                <div>
                                                                    <a href="#" class="d-block">
                                                                        <h5 class="fs-5 mb-1"><?=$referral4['firstname'].' '.$referral4['lastname'].' '.$cacus_id?></h5>
                                                                    </a>
                                                                    <p class="text-muted mb-0">Customer</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4 col-md-4 col-sm-12 col-12 py-2">
                                                            <div class="row text-center">
                                                                <div class="col-6 border-end">
                                                                    <?php
                                                                        $countCATACU = "SELECT COUNT(ca_customer_id) AS CATACUcount FROM ca_customer WHERE reference_no='".$cacus_id."' ";
                                                                        $catacuCount = $conn -> prepare($countCATACU);
                                                                        $catacuCount -> execute();
                                                                        $catacuCount -> setFetchMode(PDO::FETCH_ASSOC);
                                                                        if( $catacuCount -> rowCount()>0 ){
                                                                            foreach( ($catacuCount -> fetchAll()) as $keyCATACU => $rowCATACU ){
                                                                                $CATACUCount = $rowCATACU['CATACUcount'];
                                                                    ?>
                                                                    <h5 class="mb-1"><?=$CATACUCount?></h5>
                                                                    <?php
                                                                            }
                                                                        }
                                                                    ?>
                                                                    <p class="text-muted mb-0">Total Refered Customers</p>
                                                                </div>
                                                                <div class="col-6">
                                                                    <?php
                                                                        $countPAC = "SELECT COUNT(cu_id) AS PECcount FROM product_payout WHERE cu_id='".$cacus_id."' ";
                                                                        $pecCount = $conn -> prepare($countPAC);
                                                                        $pecCount -> execute();
                                                                        $pecCount -> setFetchMode(PDO::FETCH_ASSOC);
                                                                        if( $pecCount -> rowCount()>0 ){
                                                                            foreach( ($pecCount -> fetchAll()) as $keyPec => $rowPec ){
                                                                                $PecCount = $rowPec['PECcount'];
                                                                    ?>
                                                                    <h5 class="mb-1"><?=$PecCount?></h5>
                                                                    <?php
                                                                            }
                                                                        }
                                                                    ?>
                                                                    <p class="text-muted mb-0">Total Packages</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-2 col-md-2 col-sm-6 col-6 py-2">
                                                            <h5 class="mb-1">Phone No</h5>
                                                            <p class="text-muted mb-0"><?=$referral4['contact_no']?></p>
                                                        </div>
                                                        <div class="col-lg-2 col-md-2 col-sm-6 col-6 py-2">
                                                            <div class="text-center">
                                                                <a href="#" onclick="overviewPage('<?= $referral4['ca_customer_id'] .','.  $referral4['reference_no'] . ',' .$referral4['country']. ',' .$referral4['state']. ',' .$referral4['city']. ',customer' ?>')" class="btn btn-primary view-btn">View Profile</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </button>
                                        <!-- customer ref level 1 -->
                                        <div class="panel">
                                            <?php
                                                $stmt5 = $conn -> prepare(" SELECT * FROM ca_customer WHERE reference_no = ? AND status = '1' ORDER BY ca_customer_id ASC");
                                                $stmt5 -> execute([$cacus_id]);
                                                $referrals5 = $stmt5->fetchAll(PDO::FETCH_ASSOC);
                                                foreach($referrals5 as $referral5){
                                                    $customer_id = $referral5['ca_customer_id'];
                                            ?>
                                            <button class="accordion p-0">
                                                <div class="card mb-0 rounded-0">
                                                    <div class="card-body p-2">
                                                        <div class="row align-items-center">
                                                            <div class="col-lg-4 col-md-4 col-sm-12 col-12 py-2">
                                                                <div class="team-profile-img d-flex align-items-center justify-content-around">
                                                                    <div class="avatar-md img-thumbnail rounded float-start rounded-circle">
                                                                        <img src="../../uploading/<?=$referral5['profile_pic']?>" alt="" class="img-fluid d-block rounded-circle" />
                                                                    </div>
                                                                    <div>
                                                                        <a href="#" class="d-block">
                                                                            <h5 class="fs-5 mb-1"><?=$referral5['firstname'].' '.$referral5['lastname'].' '.$customer_id?></h5>
                                                                        </a>
                                                                        <p class="text-muted mb-0">Customer</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4 col-md-4 col-sm-12 col-12 py-2">
                                                                <div class="row text-center">
                                                                    <div class="col-6 border-end">
                                                                        <?php
                                                                            $countCU = "SELECT COUNT(ca_customer_id) AS CATAcount FROM ca_customer WHERE reference_no='".$customer_id."' ";
                                                                            $cuCount = $conn -> prepare($countCU);
                                                                            $cuCount -> execute();
                                                                            $cuCount -> setFetchMode(PDO::FETCH_ASSOC);
                                                                            if( $cuCount -> rowCount()>0 ){
                                                                                foreach( ($cuCount -> fetchAll()) as $keycu => $rowcu ){
                                                                                    $cuCount = $rowcu['CATAcount'];
                                                                        ?>
                                                                        <h5 class="mb-1"><?=$cuCount?></h5>
                                                                        <?php
                                                                                }
                                                                            }
                                                                        ?>
                                                                        <p class="text-muted mb-0">Total Refered Customers</p>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <?php
                                                                            $countPAC = "SELECT COUNT(cu_id) AS PECcount FROM product_payout WHERE cu_id='".$customer_id."' ";
                                                                            $pecCount = $conn -> prepare($countPAC);
                                                                            $pecCount -> execute();
                                                                            $pecCount -> setFetchMode(PDO::FETCH_ASSOC);
                                                                            if( $pecCount -> rowCount()>0 ){
                                                                                foreach( ($pecCount -> fetchAll()) as $keyPec => $rowPec ){
                                                                                    $PecCount = $rowPec['PECcount'];
                                                                        ?>
                                                                        <h5 class="mb-1">20</h5>
                                                                        <?php
                                                                                }
                                                                            }
                                                                        ?>
                                                                        <p class="text-muted mb-0">Total Packages</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-2 col-md-2 col-sm-6 col-6 py-2">
                                                                <h5 class="mb-1">Phone No</h5>
                                                                <p class="text-muted mb-0"><?=$referral5['contact_no']?></p>
                                                            </div>
                                                            <div class="col-lg-2 col-md-2 col-sm-6 col-6 py-2">
                                                                <div class="text-center">
                                                                    <a href="#" onclick="overviewPage('<?= $referral5['ca_customer_id'] .','.  $referral5['reference_no'] . ',' .$referral5['country']. ',' .$referral5['state']. ',' .$referral5['city']. ',customer' ?>')" class="btn btn-primary view-btn">View Profile</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </button>
                                            <!-- cumtomer ref level 2 -->
                                            <div class="panel">
                                                <?php
                                                    $stmt6 = $conn -> prepare(" SELECT * FROM ca_customer WHERE reference_no = ? AND status = '1' ORDER BY ca_customer_id ASC");
                                                    $stmt6 -> execute([$customer_id]);
                                                    $referrals6 = $stmt6->fetchAll(PDO::FETCH_ASSOC);
                                                    foreach($referrals6 as $referral6){
                                                        $customer_id2 = $referral6['ca_customer_id'];
                                                ?>
                                                <button class="accordion p-0">
                                                    <div class="card mb-0 rounded-0">
                                                        <div class="card-body p-2">
                                                            <div class="row align-items-center">
                                                                <div class="col-lg-4 col-md-4 col-sm-12 col-12 py-2">
                                                                    <div class="team-profile-img d-flex align-items-center justify-content-around">
                                                                        <div class="avatar-md img-thumbnail rounded float-start rounded-circle">
                                                                            <img src="../../uploading/<?=$referral6['profile_pic']?>" alt="" class="img-fluid d-block rounded-circle" />
                                                                        </div>
                                                                        <div>
                                                                            <a href="#" class="d-block">
                                                                                <h5 class="fs-5 mb-1"><?=$referral6['firstname'].' '.$referral6['lastname'].' '.$customer_id2?></h5>
                                                                            </a>
                                                                            <p class="text-muted mb-0">Customer</p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-4 col-md-4 col-sm-12 col-12 py-2">
                                                                    <div class="row text-center">
                                                                        <div class="col-6 border-end">
                                                                            <?php
                                                                                $countCU2 = "SELECT COUNT(ca_customer_id) AS CATAcount FROM ca_customer WHERE reference_no='".$customer_id2."' ";
                                                                                $cuCount2 = $conn -> prepare($countCU2);
                                                                                $cuCount2 -> execute();
                                                                                $cuCount2 -> setFetchMode(PDO::FETCH_ASSOC);
                                                                                if( $cuCount2 -> rowCount()>0 ){
                                                                                    foreach( ($cuCount2 -> fetchAll()) as $keycu2 => $rowcu2 ){
                                                                                        $cu2Count = $rowcu2['CATAcount'];
                                                                            ?>
                                                                            <h5 class="mb-1"><?= $cu2Count?></h5>
                                                                            <?php
                                                                                    }
                                                                                }
                                                                            ?>
                                                                            <p class="text-muted mb-0">Total Refered Customers</p>
                                                                        </div>
                                                                        <div class="col-6">
                                                                            <?php
                                                                                $countPAC2 = "SELECT COUNT(cu_id) AS PECcount FROM product_payout WHERE cu_id='".$customer_id2."' ";
                                                                                $pecCount2 = $conn -> prepare($countPAC2);
                                                                                $pecCount2 -> execute();
                                                                                $pecCount2 -> setFetchMode(PDO::FETCH_ASSOC);
                                                                                if( $pecCount2 -> rowCount()>0 ){
                                                                                    foreach( ($pecCount2 -> fetchAll()) as $keyPec2 => $rowPec2 ){
                                                                                        $PecCount2 = $rowPec2['PECcount'];
                                                                            ?>
                                                                            <h5 class="mb-1"><?=$PecCount2?></h5>
                                                                            <?php
                                                                                    }
                                                                                }
                                                                            ?>
                                                                            <p class="text-muted mb-0">Total Packages</p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-2 col-md-2 col-sm-6 col-6 py-2">
                                                                    <h5 class="mb-1">Phone No</h5>
                                                                    <p class="text-muted mb-0"><?=$referral6['contact_no']?></p>
                                                                </div>
                                                                <div class="col-lg-2 col-md-2 col-sm-6 col-6 py-2">
                                                                    <div class="text-center">
                                                                        <a href="#" onclick="overviewPage('<?= $referral6['ca_customer_id'] .','.  $referral6['reference_no'] . ',' .$referral6['country']. ',' .$referral6['state']. ',' .$referral6['city']. ',customer' ?>')" class="btn btn-primary view-btn">View Profile</a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </button>
                                                <!-- cumtomer ref level 3 -->
                                                <div class="panel">
                                                    <?php
                                                        $stmt6 = $conn -> prepare(" SELECT * FROM ca_customer WHERE reference_no = ? AND status = '1' ORDER BY ca_customer_id ASC");
                                                        $stmt6 -> execute([$customer_id2]);
                                                        $referrals6 = $stmt6->fetchAll(PDO::FETCH_ASSOC);
                                                        foreach($referrals6 as $referral6){
                                                            $customer_id3 = $referral6['ca_customer_id'];
                                                    ?>
                                                    <button class="accordion p-0">
                                                        <div class="card mb-0 rounded-0">
                                                            <div class="card-body p-2">
                                                                <div class="row align-items-center">
                                                                    <div class="col-lg-4 col-md-4 col-sm-12 col-12 py-2">
                                                                        <div class="team-profile-img d-flex align-items-center justify-content-around">
                                                                            <div class="avatar-md img-thumbnail rounded float-start rounded-circle">
                                                                                <img src="../../uploading/<?=$referral6['profile_pic']?>" alt="" class="img-fluid d-block rounded-circle" />
                                                                            </div>
                                                                            <div>
                                                                                <a href="#" class="d-block">
                                                                                    <h5 class="fs-5 mb-1"><?=$referral6['firstname'].' '.$referral6['lastname'].' '.$customer_id3?></h5>
                                                                                </a>
                                                                                <p class="text-muted mb-0">Customer</p>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-4 col-md-4 col-sm-12 col-12 py-2">
                                                                        <div class="row text-center">
                                                                            <div class="col-6 border-end">
                                                                                <?php
                                                                                    $countCU2 = "SELECT COUNT(ca_customer_id) AS CATAcount FROM ca_customer WHERE reference_no='".$customer_id3."' ";
                                                                                    $cuCount2 = $conn -> prepare($countCU2);
                                                                                    $cuCount2 -> execute();
                                                                                    $cuCount2 -> setFetchMode(PDO::FETCH_ASSOC);
                                                                                    if( $cuCount2 -> rowCount()>0 ){
                                                                                        foreach( ($cuCount2 -> fetchAll()) as $keycu2 => $rowcu2 ){
                                                                                            $cu2Count = $rowcu2['CATAcount'];
                                                                                ?>
                                                                                <h5 class="mb-1"><?=$cu2Count?></h5>
                                                                                <?php
                                                                                        }
                                                                                    }
                                                                                ?>
                                                                                <p class="text-muted mb-0">Total Refered Customers</p>
                                                                            </div>
                                                                            <div class="col-6">
                                                                                <?php
                                                                                    $countPAC2 = "SELECT COUNT(cu_id) AS PECcount FROM product_payout WHERE cu_id='".$customer_id3."' ";
                                                                                    $pecCount2 = $conn -> prepare($countPAC2);
                                                                                    $pecCount2 -> execute();
                                                                                    $pecCount2 -> setFetchMode(PDO::FETCH_ASSOC);
                                                                                    if( $pecCount2 -> rowCount()>0 ){
                                                                                        foreach( ($pecCount2 -> fetchAll()) as $keyPec2 => $rowPec2 ){
                                                                                            $PecCount2 = $rowPec2['PECcount'];
                                                                                ?>
                                                                                <h5 class="mb-1"><?=$PecCount2?></h5>
                                                                                <?php
                                                                                        }
                                                                                    }
                                                                                ?>
                                                                                <p class="text-muted mb-0">Total Packages</p>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-2 col-md-2 col-sm-6 col-6 py-2">
                                                                        <h5 class="mb-1">Phone No</h5>
                                                                        <p class="text-muted mb-0"><?=$referral6['contact_no']?></p>
                                                                    </div>
                                                                    <div class="col-lg-2 col-md-2 col-sm-6 col-6 py-2">
                                                                        <div class="text-center">
                                                                            <a href="#" onclick="overviewPage('<?= $referral6['ca_customer_id'] .','.  $referral6['reference_no'] . ',' .$referral6['country']. ',' .$referral6['state']. ',' .$referral6['city']. ',customer' ?>')" class="btn btn-primary view-btn">View Profile</a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </button>
                                                    <?php
                                                        }
                                                    ?>
                                                </div>
                                                <?php
                                                    }
                                                ?>
                                                <!-- end cumtomer ref level 3 -->
                                            </div>
                                            <!-- end cumtomer ref level 2 -->
                                            <?php
                                                }
                                            ?>
                                        </div>
                                        <!-- end customer ref level 1 -->
                                        <?php
                                            }
                                        }
                                        ?>
                                    </div>
                                    <?php
                                    }else if ($DBtable == 'ca_customer'){
                                    ?>
                                    <?php
                                        $stmt5 = $conn -> prepare(" SELECT * FROM ca_customer WHERE reference_no = ? AND status = '1' ORDER BY ca_customer_id ASC");
                                        $stmt5 -> execute([$id]);
                                        $stmt5 -> setFetchMode(PDO::FETCH_ASSOC);
                                        if ($stmt5 -> rowCount()==0) {
                                    ?>
                                    <div class="row pt-3">
                                        <div class="col-md-2">
                                            <div class="d-flex align-items-center justify-content-center p-3 position">
                                                <img src="../../uploading/not_uploaded.png" width="50" height="50" class="rounded-circle ms-3" />
                                            </div>
                                        </div>
                                        <div class="col-md-9">
                                            <div class="">
                                                <div class="card bg-light p-2 mt-2">
                                                    <div class="d-flex justify-content-between">
                                                        <h4 class="">-----</h4>
                                                        <p class="d-inline">--/--/----</p>
                                                    </div>
                                                    <p class="my-0 cardText">No Team memebers found</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                        }else{

                                            $referrals5 = $stmt5->fetchAll();
                                            foreach($referrals5 as $referral5){
                                                $customer_id = $referral5['ca_customer_id'];
                                        ?>
                                        <button class="accordion p-0">
                                            <div class="card mb-0 rounded-0">
                                                <div class="card-body p-2">
                                                    <div class="row align-items-center">
                                                        <div class="col-lg-4 col-md-4 col-sm-12 col-12 py-2">
                                                            <div class="team-profile-img d-flex align-items-center justify-content-around">
                                                                <div class="avatar-md img-thumbnail rounded float-start rounded-circle">
                                                                    <img src="../../uploading/<?=$referral5['profile_pic']?>" alt="" class="img-fluid d-block rounded-circle" />
                                                                </div>
                                                                <div>
                                                                    <a href="#" class="d-block">
                                                                        <h5 class="fs-5 mb-1"><?=$referral5['firstname'].' '.$referral5['lastname'].' '.$customer_id?></h5>
                                                                    </a>
                                                                    <p class="text-muted mb-0">Customer</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4 col-md-4 col-sm-12 col-12 py-2">
                                                            <div class="row text-center">
                                                                <div class="col-6 border-end">
                                                                    <?php
                                                                        $countCU = "SELECT COUNT(ca_customer_id) AS CATAcount FROM ca_customer WHERE reference_no='".$customer_id."' ";
                                                                        $cuCount = $conn -> prepare($countCU);
                                                                        $cuCount -> execute();
                                                                        $cuCount -> setFetchMode(PDO::FETCH_ASSOC);
                                                                        if( $cuCount -> rowCount()>0 ){
                                                                            foreach( ($cuCount -> fetchAll()) as $keycu => $rowcu ){
                                                                                $cuCount = $rowcu['CATAcount'];
                                                                    ?>
                                                                    <h5 class="mb-1"><?=$cuCount?></h5>
                                                                    <?php
                                                                            }
                                                                        }
                                                                    ?>
                                                                    <p class="text-muted mb-0">Total Refered Customers</p>
                                                                </div>
                                                                <div class="col-6">
                                                                    <?php
                                                                        $countPAC = "SELECT COUNT(cu_id) AS PECcount FROM product_payout WHERE cu_id='".$customer_id."' ";
                                                                        $pecCount = $conn -> prepare($countPAC);
                                                                        $pecCount -> execute();
                                                                        $pecCount -> setFetchMode(PDO::FETCH_ASSOC);
                                                                        if( $pecCount -> rowCount()>0 ){
                                                                            foreach( ($pecCount -> fetchAll()) as $keyPec => $rowPec ){
                                                                                $PecCount = $rowPec['PECcount'];
                                                                    ?>
                                                                    <h5 class="mb-1">20</h5>
                                                                    <?php
                                                                            }
                                                                        }
                                                                    ?>
                                                                    <p class="text-muted mb-0">Total Packages</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-2 col-md-2 col-sm-6 col-6 py-2">
                                                            <h5 class="mb-1">Phone No</h5>
                                                            <p class="text-muted mb-0"><?=$referral5['contact_no']?></p>
                                                        </div>
                                                        <div class="col-lg-2 col-md-2 col-sm-6 col-6 py-2">
                                                            <div class="text-center">
                                                                <a href="#" onclick="overviewPage('<?= $referral5['ca_customer_id'] .','.  $referral5['reference_no'] . ',' .$referral5['country']. ',' .$referral5['state']. ',' .$referral5['city']. ',customer' ?>')" class="btn btn-primary view-btn">View Profile</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </button>
                                        <!-- cumtomer ref level 2 -->
                                        <div class="panel">
                                            <?php
                                                $stmt6 = $conn -> prepare(" SELECT * FROM ca_customer WHERE reference_no = ? AND status = '1' ORDER BY ca_customer_id ASC");
                                                $stmt6 -> execute([$customer_id]);
                                                $referrals6 = $stmt6->fetchAll(PDO::FETCH_ASSOC);
                                                foreach($referrals6 as $referral6){
                                                    $customer_id2 = $referral6['ca_customer_id'];
                                            ?>
                                            <button class="accordion p-0">
                                                <div class="card mb-0 rounded-0">
                                                    <div class="card-body p-2">
                                                        <div class="row align-items-center">
                                                            <div class="col-lg-4 col-md-4 col-sm-12 col-12 py-2">
                                                                <div class="team-profile-img d-flex align-items-center justify-content-around">
                                                                    <div class="avatar-md img-thumbnail rounded float-start rounded-circle">
                                                                        <img src="../../uploading/<?=$referral6['profile_pic']?>" alt="" class="img-fluid d-block rounded-circle" />
                                                                    </div>
                                                                    <div>
                                                                        <a href="#" class="d-block">
                                                                            <h5 class="fs-5 mb-1"><?=$referral6['firstname'].' '.$referral6['lastname'].' '.$customer_id2?></h5>
                                                                        </a>
                                                                        <p class="text-muted mb-0">Customer</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4 col-md-4 col-sm-12 col-12 py-2">
                                                                <div class="row text-center">
                                                                    <div class="col-6 border-end">
                                                                        <?php
                                                                            $countCU2 = "SELECT COUNT(ca_customer_id) AS CATAcount FROM ca_customer WHERE reference_no='".$customer_id2."' ";
                                                                            $cuCount2 = $conn -> prepare($countCU2);
                                                                            $cuCount2 -> execute();
                                                                            $cuCount2 -> setFetchMode(PDO::FETCH_ASSOC);
                                                                            if( $cuCount2 -> rowCount()>0 ){
                                                                                foreach( ($cuCount2 -> fetchAll()) as $keycu2 => $rowcu2 ){
                                                                                    $cu2Count = $rowcu2['CATAcount'];
                                                                        ?>
                                                                        <h5 class="mb-1"><?= $cu2Count?></h5>
                                                                        <?php
                                                                                }
                                                                            }
                                                                        ?>
                                                                        <p class="text-muted mb-0">Total Refered Customers</p>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <?php
                                                                            $countPAC2 = "SELECT COUNT(cu_id) AS PECcount FROM product_payout WHERE cu_id='".$customer_id2."' ";
                                                                            $pecCount2 = $conn -> prepare($countPAC2);
                                                                            $pecCount2 -> execute();
                                                                            $pecCount2 -> setFetchMode(PDO::FETCH_ASSOC);
                                                                            if( $pecCount2 -> rowCount()>0 ){
                                                                                foreach( ($pecCount2 -> fetchAll()) as $keyPec2 => $rowPec2 ){
                                                                                    $PecCount2 = $rowPec2['PECcount'];
                                                                        ?>
                                                                        <h5 class="mb-1"><?=$PecCount2?></h5>
                                                                        <?php
                                                                                }
                                                                            }
                                                                        ?>
                                                                        <p class="text-muted mb-0">Total Packages</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-2 col-md-2 col-sm-6 col-6 py-2">
                                                                <h5 class="mb-1">Phone No</h5>
                                                                <p class="text-muted mb-0"><?=$referral6['contact_no']?></p>
                                                            </div>
                                                            <div class="col-lg-2 col-md-2 col-sm-6 col-6 py-2">
                                                                <div class="text-center">
                                                                    <a href="#" onclick="overviewPage('<?= $referral6['ca_customer_id'] .','.  $referral6['reference_no'] . ',' .$referral6['country']. ',' .$referral6['state']. ',' .$referral6['city']. ',customer' ?>')" class="btn btn-primary view-btn">View Profile</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </button>
                                            <!-- cumtomer ref level 3 -->
                                            <div class="panel">
                                                <?php
                                                    $stmt6 = $conn -> prepare(" SELECT * FROM ca_customer WHERE reference_no = ? AND status = '1' ORDER BY ca_customer_id ASC");
                                                    $stmt6 -> execute([$customer_id2]);
                                                    $referrals6 = $stmt6->fetchAll(PDO::FETCH_ASSOC);
                                                    foreach($referrals6 as $referral6){
                                                        $customer_id3 = $referral6['ca_customer_id'];
                                                ?>
                                                <button class="accordion p-0">
                                                    <div class="card mb-0 rounded-0">
                                                        <div class="card-body p-2">
                                                            <div class="row align-items-center">
                                                                <div class="col-lg-4 col-md-4 col-sm-12 col-12 py-2">
                                                                    <div class="team-profile-img d-flex align-items-center justify-content-around">
                                                                        <div class="avatar-md img-thumbnail rounded float-start rounded-circle">
                                                                            <img src="../../uploading/<?=$referral6['profile_pic']?>" alt="" class="img-fluid d-block rounded-circle" />
                                                                        </div>
                                                                        <div>
                                                                            <a href="#" class="d-block">
                                                                                <h5 class="fs-5 mb-1"><?=$referral6['firstname'].' '.$referral6['lastname'].' '.$customer_id3?></h5>
                                                                            </a>
                                                                            <p class="text-muted mb-0">Customer</p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-4 col-md-4 col-sm-12 col-12 py-2">
                                                                    <div class="row text-center">
                                                                        <div class="col-6 border-end">
                                                                            <?php
                                                                                $countCU2 = "SELECT COUNT(ca_customer_id) AS CATAcount FROM ca_customer WHERE reference_no='".$customer_id3."' ";
                                                                                $cuCount2 = $conn -> prepare($countCU2);
                                                                                $cuCount2 -> execute();
                                                                                $cuCount2 -> setFetchMode(PDO::FETCH_ASSOC);
                                                                                if( $cuCount2 -> rowCount()>0 ){
                                                                                    foreach( ($cuCount2 -> fetchAll()) as $keycu2 => $rowcu2 ){
                                                                                        $cu2Count = $rowcu2['CATAcount'];
                                                                            ?>
                                                                            <h5 class="mb-1"><?=$cu2Count?></h5>
                                                                            <?php
                                                                                    }
                                                                                }
                                                                            ?>
                                                                            <p class="text-muted mb-0">Total Refered Customers</p>
                                                                        </div>
                                                                        <div class="col-6">
                                                                            <?php
                                                                                $countPAC2 = "SELECT COUNT(cu_id) AS PECcount FROM product_payout WHERE cu_id='".$customer_id3."' ";
                                                                                $pecCount2 = $conn -> prepare($countPAC2);
                                                                                $pecCount2 -> execute();
                                                                                $pecCount2 -> setFetchMode(PDO::FETCH_ASSOC);
                                                                                if( $pecCount2 -> rowCount()>0 ){
                                                                                    foreach( ($pecCount2 -> fetchAll()) as $keyPec2 => $rowPec2 ){
                                                                                        $PecCount2 = $rowPec2['PECcount'];
                                                                            ?>
                                                                            <h5 class="mb-1"><?=$PecCount2?></h5>
                                                                            <?php
                                                                                    }
                                                                                }
                                                                            ?>
                                                                            <p class="text-muted mb-0">Total Packages</p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-2 col-md-2 col-sm-6 col-6 py-2">
                                                                    <h5 class="mb-1">Phone No</h5>
                                                                    <p class="text-muted mb-0"><?=$referral6['contact_no']?></p>
                                                                </div>
                                                                <div class="col-lg-2 col-md-2 col-sm-6 col-6 py-2">
                                                                    <div class="text-center">
                                                                        <a href="#" onclick="overviewPage('<?= $referral6['ca_customer_id'] .','.  $referral6['reference_no'] . ',' .$referral6['country']. ',' .$referral6['state']. ',' .$referral6['city']. ',customer' ?>')" class="btn btn-primary view-btn">View Profile</a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </button>
                                                <?php
                                                    }
                                                ?>
                                            </div>
                                            <?php
                                                }
                                            ?>
                                            <!-- end cumtomer ref level 3 -->
                                        </div>
                                        <!-- end cumtomer ref level 2 -->
                                    <?php
                                            }
                                        }
                                    }
                                    ?>
                                    <!-- end all Customers onboarded by TC -->
                                    


                                    <!--end card-->

                                    <!-- <button class="accordion p-0">
                                        <div class="card mb-0 rounded-0">
                                            <div class="card-body p-2">
                                                <div class="row align-items-center">
                                                    <div class="col-lg-4 col-md-4 col-sm-12 col-12 py-2">
                                                        <div class="team-profile-img d-flex align-items-center justify-content-around">
                                                            <div class="avatar-md img-thumbnail rounded float-start rounded-circle">
                                                                <img src="../assets/images/users/avatar-2.jpg" alt="" class="img-fluid d-block rounded-circle" />
                                                            </div>
                                                            <div>
                                                                <a href="#" class="d-block">
                                                                    <h5 class="fs-5 mb-1">Nancy Martino</h5>
                                                                </a>
                                                                <p class="text-muted mb-0">Team Leader & HR</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4 col-md-4 col-sm-12 col-12 py-2">
                                                        <div class="row text-center">
                                                            <div class="col-6 border-end">
                                                                <h5 class="mb-1">10</h5>
                                                                <p class="text-muted mb-0">Total Team Member</p>
                                                            </div>
                                                            <div class="col-6">
                                                                <h5 class="mb-1">20</h5>
                                                                <p class="text-muted mb-0">Total Packages</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-2 col-md-2 col-sm-6 col-6 py-2">
                                                        <h5 class="mb-1">Phone No</h5>
                                                        <p class="text-muted mb-0">8965458645</p>
                                                    </div>
                                                    <div class="col-lg-2 col-md-2 col-sm-6 col-6 py-2">
                                                        <div class="text-center">
                                                            <a href="#" class="btn btn-primary view-btn">View Profile</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </button>
                                    <div class="panel">
                                        <button class="accordion p-0">
                                            <div class="card mb-0 rounded-0">
                                                <div class="card-body p-2">
                                                    <div class="row align-items-center">
                                                        <div class="col-lg-4 col-md-4 col-sm-12 col-12 py-2">
                                                            <div class="team-profile-img d-flex align-items-center justify-content-around">
                                                                <div class="avatar-md img-thumbnail rounded float-start rounded-circle">
                                                                    <img src="../assets/images/users/avatar-2.jpg" alt="" class="img-fluid d-block rounded-circle" />
                                                                </div>
                                                                <div>
                                                                    <a href="#" class="d-block">
                                                                        <h5 class="fs-5 mb-1">Nancy Martino</h5>
                                                                    </a>
                                                                    <p class="text-muted mb-0">Team Leader & HR</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4 col-md-4 col-sm-12 col-12 py-2">
                                                            <div class="row text-center">
                                                                <div class="col-6 border-end">
                                                                    <h5 class="mb-1">10</h5>
                                                                    <p class="text-muted mb-0">Total Team Member</p>
                                                                </div>
                                                                <div class="col-6">
                                                                    <h5 class="mb-1">20</h5>
                                                                    <p class="text-muted mb-0">Total Packages</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-2 col-md-2 col-sm-6 col-6 py-2">
                                                            <h5 class="mb-1">Phone No</h5>
                                                            <p class="text-muted mb-0">8965458645</p>
                                                        </div>
                                                        <div class="col-lg-2 col-md-2 col-sm-6 col-6 py-2">
                                                            <div class="text-center">
                                                                <a href="#" class="btn btn-primary view-btn">View Profile</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </button>
                                        <div class="panel">
                                            <button class="accordion p-0">
                                                <div class="card mb-0 rounded-0">
                                                    <div class="card-body p-2">
                                                        <div class="row align-items-center">
                                                            <div class="col-lg-4 col-md-4 col-sm-12 col-12 py-2">
                                                                <div class="team-profile-img d-flex align-items-center justify-content-around">
                                                                    <div class="avatar-md img-thumbnail rounded float-start rounded-circle">
                                                                        <img src="../assets/images/users/avatar-2.jpg" alt="" class="img-fluid d-block rounded-circle" />
                                                                    </div>
                                                                    <div>
                                                                        <a href="#" class="d-block">
                                                                            <h5 class="fs-5 mb-1">Nancy Martino</h5>
                                                                        </a>
                                                                        <p class="text-muted mb-0">Team Leader & HR</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4 col-md-4 col-sm-12 col-12 py-2">
                                                                <div class="row text-center">
                                                                    <div class="col-6 border-end">
                                                                        <h5 class="mb-1">10</h5>
                                                                        <p class="text-muted mb-0">Total Team Member</p>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <h5 class="mb-1">20</h5>
                                                                        <p class="text-muted mb-0">Total Packages</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-2 col-md-2 col-sm-6 col-6 py-2">
                                                                <h5 class="mb-1">Phone No</h5>
                                                                <p class="text-muted mb-0">8965458645</p>
                                                            </div>
                                                            <div class="col-lg-2 col-md-2 col-sm-6 col-6 py-2">
                                                                <div class="text-center">
                                                                    <a href="#" class="btn btn-primary view-btn">View Profile</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </button>
                                            <div class="panel">
                                                <button class="accordion p-0">
                                                    <div class="card mb-0 rounded-0">
                                                        <div class="card-body p-2">
                                                            <div class="row align-items-center">
                                                                <div class="col-lg-4 col-md-4 col-sm-12 col-12 py-2">
                                                                    <div class="team-profile-img d-flex align-items-center justify-content-around">
                                                                        <div class="avatar-md img-thumbnail rounded float-start rounded-circle">
                                                                            <img src="../assets/images/users/avatar-2.jpg" alt="" class="img-fluid d-block rounded-circle" />
                                                                        </div>
                                                                        <div>
                                                                            <a href="#" class="d-block">
                                                                                <h5 class="fs-5 mb-1">Nancy Martino</h5>
                                                                            </a>
                                                                            <p class="text-muted mb-0">Team Leader & HR</p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-4 col-md-4 col-sm-12 col-12 py-2">
                                                                    <div class="row text-center">
                                                                        <div class="col-6 border-end">
                                                                            <h5 class="mb-1">10</h5>
                                                                            <p class="text-muted mb-0">Total Team Member</p>
                                                                        </div>
                                                                        <div class="col-6">
                                                                            <h5 class="mb-1">20</h5>
                                                                            <p class="text-muted mb-0">Total Packages</p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-2 col-md-2 col-sm-6 col-6 py-2">
                                                                    <h5 class="mb-1">Phone No</h5>
                                                                    <p class="text-muted mb-0">8965458645</p>
                                                                </div>
                                                                <div class="col-lg-2 col-md-2 col-sm-6 col-6 py-2">
                                                                    <div class="text-center">
                                                                        <a href="#" class="btn btn-primary view-btn">View Profile</a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </button>
                                                <div class="panel">
                                                    <button class="accordion p-0">
                                                        <div class="card mb-0 rounded-0">
                                                            <div class="card-body p-2">
                                                                <div class="row align-items-center">
                                                                    <div class="col-lg-4 col-md-4 col-sm-12 col-12 py-2">
                                                                        <div class="team-profile-img d-flex align-items-center justify-content-around">
                                                                            <div class="avatar-md img-thumbnail rounded float-start rounded-circle">
                                                                                <img src="../assets/images/users/avatar-2.jpg" alt="" class="img-fluid d-block rounded-circle" />
                                                                            </div>
                                                                            <div>
                                                                                <a href="#" class="d-block">
                                                                                    <h5 class="fs-5 mb-1">Nancy Martino</h5>
                                                                                </a>
                                                                                <p class="text-muted mb-0">Team Leader & HR</p>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-4 col-md-4 col-sm-12 col-12 py-2">
                                                                        <div class="row text-center">
                                                                            <div class="col-6 border-end">
                                                                                <h5 class="mb-1">10</h5>
                                                                                <p class="text-muted mb-0">Total Team Member</p>
                                                                            </div>
                                                                            <div class="col-6">
                                                                                <h5 class="mb-1">20</h5>
                                                                                <p class="text-muted mb-0">Total Packages</p>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-2 col-md-2 col-sm-6 col-6 py-2">
                                                                        <h5 class="mb-1">Phone No</h5>
                                                                        <p class="text-muted mb-0">8965458645</p>
                                                                    </div>
                                                                    <div class="col-lg-2 col-md-2 col-sm-6 col-6 py-2">
                                                                        <div class="text-center">
                                                                            <a href="#" class="btn btn-primary view-btn">View Profile</a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </button>
                                                    <div class="panel">
                                                        <button class="accordion p-0">
                                                            <div class="card mb-0 rounded-0">
                                                                <div class="card-body p-2">
                                                                    <div class="row align-items-center">
                                                                        <div class="col-lg-4 col-md-4 col-sm-12 col-12 py-2">
                                                                            <div class="team-profile-img d-flex align-items-center justify-content-around">
                                                                                <div class="avatar-md img-thumbnail rounded float-start rounded-circle">
                                                                                    <img src="../assets/images/users/avatar-2.jpg" alt="" class="img-fluid d-block rounded-circle" />
                                                                                </div>
                                                                                <div>
                                                                                    <a href="#" class="d-block">
                                                                                        <h5 class="fs-5 mb-1">Nancy Martino</h5>
                                                                                    </a>
                                                                                    <p class="text-muted mb-0">Team Leader & HR</p>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-4 col-md-4 col-sm-12 col-12 py-2">
                                                                            <div class="row text-center">
                                                                                <div class="col-6 border-end">
                                                                                    <h5 class="mb-1">10</h5>
                                                                                    <p class="text-muted mb-0">Total Team Member</p>
                                                                                </div>
                                                                                <div class="col-6">
                                                                                    <h5 class="mb-1">20</h5>
                                                                                    <p class="text-muted mb-0">Total Packages</p>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-2 col-md-2 col-sm-6 col-6 py-2">
                                                                            <h5 class="mb-1">Phone No</h5>
                                                                            <p class="text-muted mb-0">8965458645</p>
                                                                        </div>
                                                                        <div class="col-lg-2 col-md-2 col-sm-6 col-6 py-2">
                                                                            <div class="text-center">
                                                                                <a href="#" class="btn btn-primary view-btn">View Profile</a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </button>
                                                        <div class="panel">
                                                            <button class="accordion p-0">
                                                                <div class="card mb-0 rounded-0">
                                                                    <div class="card-body p-2">
                                                                        <div class="row align-items-center">
                                                                            <div class="col-lg-4 col-md-4 col-sm-12 col-12 py-2">
                                                                                <div class="team-profile-img d-flex align-items-center justify-content-around">
                                                                                    <div class="avatar-md img-thumbnail rounded float-start rounded-circle">
                                                                                        <img src="../assets/images/users/avatar-2.jpg" alt="" class="img-fluid d-block rounded-circle" />
                                                                                    </div>
                                                                                    <div>
                                                                                        <a href="#" class="d-block">
                                                                                            <h5 class="fs-5 mb-1">Nancy Martino</h5>
                                                                                        </a>
                                                                                        <p class="text-muted mb-0">Team Leader & HR</p>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-lg-4 col-md-4 col-sm-12 col-12 py-2">
                                                                                <div class="row text-center">
                                                                                    <div class="col-6 border-end">
                                                                                        <h5 class="mb-1">10</h5>
                                                                                        <p class="text-muted mb-0">Total Team Member</p>
                                                                                    </div>
                                                                                    <div class="col-6">
                                                                                        <h5 class="mb-1">20</h5>
                                                                                        <p class="text-muted mb-0">Total Packages</p>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-lg-2 col-md-2 col-sm-6 col-6 py-2">
                                                                                <h5 class="mb-1">Phone No</h5>
                                                                                <p class="text-muted mb-0">8965458645</p>
                                                                            </div>
                                                                            <div class="col-lg-2 col-md-2 col-sm-6 col-6 py-2">
                                                                                <div class="text-center">
                                                                                    <a href="#" class="btn btn-primary view-btn">View Profile</a>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </button>
                                                            <div class="panel">
                                                                <button class="accordion p-0">
                                                                    <div class="card mb-0 rounded-0">
                                                                        <div class="card-body p-2">
                                                                            <div class="row align-items-center">
                                                                                <div class="col-lg-4 col-md-4 col-sm-12 col-12 py-2">
                                                                                    <div class="team-profile-img d-flex align-items-center justify-content-around">
                                                                                        <div class="avatar-md img-thumbnail rounded float-start rounded-circle">
                                                                                            <img src="../assets/images/users/avatar-2.jpg" alt="" class="img-fluid d-block rounded-circle" />
                                                                                        </div>
                                                                                        <div>
                                                                                            <a href="#" class="d-block">
                                                                                                <h5 class="fs-5 mb-1">Nancy Martino</h5>
                                                                                            </a>
                                                                                            <p class="text-muted mb-0">Team Leader & HR</p>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-lg-4 col-md-4 col-sm-12 col-12 py-2">
                                                                                    <div class="row text-center">
                                                                                        <div class="col-6 border-end">
                                                                                            <h5 class="mb-1">10</h5>
                                                                                            <p class="text-muted mb-0">Total Team Member</p>
                                                                                        </div>
                                                                                        <div class="col-6">
                                                                                            <h5 class="mb-1">20</h5>
                                                                                            <p class="text-muted mb-0">Total Packages</p>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-lg-2 col-md-2 col-sm-6 col-6 py-2">
                                                                                    <h5 class="mb-1">Phone No</h5>
                                                                                    <p class="text-muted mb-0">8965458645</p>
                                                                                </div>
                                                                                <div class="col-lg-2 col-md-2 col-sm-6 col-6 py-2">
                                                                                    <div class="text-center">
                                                                                        <a href="#" class="btn btn-primary view-btn">View Profile</a>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div> -->
                                    <!--end card-->
                                </div>
                            </div>
                            <!-- Team End -->

                            <!-- Payout Start -->
                            <div class="tab-pane fade card px-3 rounded-4" id="payout" role="tabpanel">
                                <div class="row">
                                    <div class="d-flex justify-content-end">
                                        <div class="pt-3 pb-2 col-md-7">
                                            <h5>Payout</h5>
                                        </div>
                                        <div class="pt-3 pb-2 col-md-5">
                                            <div class="row d-flex justify-content-end">
                                                <input type="text" id="rangeDate" name="daterange" value="" class="col-md-6 bg-secondary-subtle rounded-3 border-0" />
                                                <div class="ms-3 col-md-3">
                                                    <a href="">
                                                        <button class="bg-success text-white border-0 rounded-3 fw-bold">Download</button>
                                                    </a>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <!-- Table -->
                                <div class="table-responsive table-desi pb-2" id="filterTable">
                                    <!-- table roe limit -->
                                    <table class="table table-hover" id="payoutDetailsTable">
                                        <thead>
                                            <tr>
                                                <th class="ceterText fw-semibold fs-6">Date</th>
                                                <th class="ceterText fw-semibold fs-6">Title</th>
                                                <th class="ceterText fw-semibold fs-6">Payout Details</th>
                                                <th class="ceterText fw-semibold fs-6">Amount</th>
                                                <th class="ceterText fw-semibold fs-6">TDS</th>
                                                <th class="ceterText fw-semibold fs-6">Total Payable</th>
                                                <th class="ceterText fw-semibold fs-6">Status</th>
                                            </tr>
                                        </thead>
                                        <tbody id="payoutDetails">
                                            <!-- BCM payout = slab payout / employee payout , users = BCM -->
                                            <!-- BDM payout = slab payout / employee payout , users = BDM -->
                                            <!-- Product payout = Packages sold to customer , users = BCM-BDM-BM-TE-TA-CU -->
                                            <!-- TC payout = When Travel Consultant joins by paying 10k , users = BM-TE-TA -->
                                            <!-- CU payout = When Customer joins by paying 10k , users = TE-TA-CU -->
                                            <?php
                                            // if ($DBtable == 'business_developement_manager' || $DBtable == 'business_chanel_manager') {
                                            //     if ($user_type == 24) {
                                            //         $sqlUnion = "SELECT 'BCM Payout' as title, bcm_user_id, message_bcm as message, payout_amount as amount, payout_date as date, payout_status as status FROM `bcm_payout_history` 
                                            //                         WHERE bcm_user_id = '" . $id . "' UNION 

                                            //                         SELECT 'Product Payout' as title, bch_id, bch_mess as message, bch_amt as amount, created_date as date, bch_status as status FROM `product_payout`
                                            //                         WHERE bch_id = '" . $id . "' ORDER BY date DESC ";
                                            //     } else if ($user_type == 25) {
                                            //         $sqlUnion = "SELECT 'BDM Payout' as title, bdm_user_id, message_bdm as message, payout_amount as amount, payout_date as date, payout_status as status FROM `bdm_payout_history` 
                                            //                         WHERE bdm_user_id = '" . $id . "' UNION 

                                            //                         SELECT 'Product Payout' as title, bdm_id, bdm_mess as message, bdm_amt as amount, created_date as date, bdm_status as status FROM `product_payout`
                                            //                         WHERE bdm_id = '" . $id . "' ORDER BY date DESC ";
                                            //     }
                                            // } else if ($DBtable == 'business_mentor') {
                                            //     $sqlUnion = "SELECT 'BM Payout' as title, bm_user_id, message_bm as message, payout_amount as amount, payout_date as date, payout_status as status FROM `bm_payout_history` 
                                            //                         WHERE bm_user_id = '" . $id . "' UNION 

                                            //                         SELECT 'TC Payout' as title, business_consultant, message_bc as message, commision_bc as amount, created_date as date, status_bc as status FROM `ca_ta_payout` 
                                            //                         WHERE business_consultant = '" . $id . "' UNION 
                                            

                                            //                         SELECT 'Product Payout' as title, bm_id, bm_mess as message, bm_amt as amount, created_date as date, bm_status as status FROM `product_payout`
                                            //                         WHERE bm_id = '" . $id . "' ORDER BY date DESC ";
                                            // } else if ($DBtable == 'corporate_agency') { // techno enterprise
                                            //     $sqlUnion = "SELECT 'TC Payout' as title, corporate_agency, message_ca as message, commision_ca as amount, created_date as date, status_ca as status FROM `ca_ta_payout` 
                                            //                         WHERE corporate_agency = '" . $id . "' UNION 

                                            //                         SELECT 'CU Payout' as title, techno_enterprise, message_te as message, commision_te as amount, created_date as date, status_te as status FROM `ca_cu_payout` 
                                            //                         WHERE techno_enterprise = '" . $id . "' UNION 
                                           

                                            //                         SELECT 'Product Payout' as title, te_id, te_mess as message, te_amt as amount, created_date as date, te_status as status FROM `product_payout`
                                            //                         WHERE te_id = '" . $id . "' ORDER BY date DESC ";
                                            // } else if ($DBtable == 'ca_travelagency') {
                                            //     $sqlUnion = "SELECT 'CU Payout' as title, travel_consultant, message_tc as message, commision_tc as amount, created_date as date, status_tc as status FROM `ca_cu_payout` 
                                            //                         WHERE travel_consultant = '" . $id . "' UNION 

                                            //                         SELECT 'Product Payout' as title, ta_id, ta_mess as message, ta_amt as amount, created_date as date, ta_status as status FROM `product_payout`
                                            //                         WHERE ta_id = '" . $id . "' ORDER BY date DESC ";
                                            // } else if ($DBtable == 'ca_customer') {
                                            //     $sqlUnion = "SELECT 'Product Payout cu1 col' as title, cu1_id, cu1_mess as message, cu1_amt as amount, created_date as date, cu1_status as status FROM `product_payout`
                                            //                         WHERE cu1_id = '" . $id . "' UNION
                                                                    
                                            //                         SELECT 'Product Payout cu2 col' as title, cu2_id, cu2_mess as message, cu2_amt as amount, created_date as date, cu2_status as status FROM `product_payout`
                                            //                         WHERE cu2_id = '" . $id . "' UNION
                                                                    
                                            //                         SELECT 'Product Payout cu3 col' as title, cu3_id, cu3_mess as message, cu3_amt as amount, created_date as date, cu3_status as status FROM `product_payout`
                                            //                         WHERE cu3_id = '" . $id . "'  ORDER BY date DESC ";
                                            // }
                                            //  if ($sqlUnion) {
                                            //     $stmtUnion = $conn->prepare($sqlUnion);
                                            //     $stmtUnion->execute();
                                            //     $stmtUnion->setFetchMode(PDO::FETCH_ASSOC);
                                            //     if ($stmtUnion->rowCount() > 0) {
                                            //         foreach (($stmtUnion->fetchAll()) as $key => $row) {
                                            //             $cd = new DateTime($row['date']);
                                            //             $cdate = $cd->format('d-m-Y');

                                            //             // replace dot at end of the line with break statement
                                            //             $message = $row['message'];
                                            //             // $message1 =  str_replace('.','<br>',$message1); 

                                            //             $amount = $row['amount'];

                                            //             if ($amount ==  'null') {
                                            //                 $tds = '0';
                                            //                 $total = '0';
                                            //             } else {
                                            //                 $tds = $amount * 2 / 100;
                                            //                 $total = $amount - $tds;
                                            //             }

                                            //             $status = $row['status'];
                                            //             $title = $row['title'];
                                            //             echo '<tr>
                                            //                         <td>' . $cdate . '</td>
                                            //                         <td>' . $title . '</td>
                                            //                         <td style="width: 350px;">' . $message . '</td>
                                            //                         <td>' . $amount . '</td>
                                            //                         <td>' . $tds . '</td>
                                            //                         <td>
                                            //                             <span>' . $total . '</span>
                                            //                             <a href="">
                                            //                                 <i class="bx bx-download" style="font-size: 18px; color: black; padding-left: 5px;"></i>
                                            //                             </a>
                                            //                         </td>
                                            //                         <td>';
                                            //             if ($status == 1) {
                                            //                 echo '<span class="badge badge-pill badge-soft-success font-size-10 fw-bold ms-4">Paid</span>';
                                            //             } else if ($status == 2) {
                                            //                 echo '<span class="badge badge-pill badge-soft-warning font-size-10 fw-bold ms-4">Pending</span>';
                                            //             } else if ($status == 3) {
                                            //                 echo '<span class="badge badge-pill badge-soft-danger font-size-10 fw-bold ms-4">Rejected</span>';
                                            //             }
                                            //             echo '</td>
                                            //                     </tr>
                                            //                     ';
                                            //         }
                                            //     }
                                            // }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- Payout End -->
                            <?php 
                                if($DBtable == 'ca_customer'){
                            ?>
                                <!-- coupons only for customers -->
                                <div class="tab-pane fade show" id="Coupon" role="tabpanel">
                                    <div class="card rounded-4">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="d-flex justify-content-between">
                                                    <?php
                                                        require '../connect.php';
                                                        $sql='SELECT * FROM cu_coupons WHERE user_id=:fid';
                                                        $stmt = $conn->prepare($sql);
                                                        $stmt->execute([':fid' => $id]);
                                                        $coupons = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                                        //print_r($coupons);
                                                        if(count($coupons) > 0){   
                                                    ?>
                                                    <div class="pt-3 pb-2 col-md-7">
                                                        <h5>Available Coupons</h5>
                                                    </div>
                                                    <?php }else{?>
                                                    <div class="pt-3 pb-2 col-md-7">
                                                        <h5>No Coupons Available </h5>
                                                    </div>
                                                    <div class="pt-3 pb-2 col-md-5">
                                                        <div class="row">
                                                            <!-- Generate Coupons Button -->
                                                            <div class="col-12 d-flex align-items-end justify-content-end">
                                                                <button type="button" class="bg-success text-white border-0 rounded-3 fw-bold px-3 py-2" id="generate_coupons">
                                                                    Generate Coupons
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php }?>
                                                </div>
                                            </div>
                                            <?php
                                                require '../connect.php';
                                                $sql='SELECT * FROM cu_coupons WHERE user_id=:fid';
                                                $stmt = $conn->prepare($sql);
                                                $stmt->execute([':fid' => $id]);
                                                $coupons = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                                //print_r($coupons);
                                                if(count($coupons) == 0){   
                                            ?>
                                            <div class="row">
                                                <div class="col-md-6 col-sm-6" id="couponFee">
                                                    <div class="input-block mb-3">
                                                        <label for="payment_fee" class="col-form-label">Payment Fee<span class="text-danger">*</span></label>
                                                        <select class="form-select" id="payment_fee" aria-label="Floating label select example">
                                                            <option value="null" selected disabled>--Select Payment Fee--</option>
                                                            <option value="10000">Prime: <span>&#8377 </span>10,000/-</option>
                                                            <option value="30000">Premium: <span>&#8377 </span>30,000/-</option>
                                                            <option value="35000">Premium Plus: <span>&#8377 </span>35,000/-</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-sm-6" id="paymentMode1">
                                                    <div class="input-block mb-3">
                                                        <label class="fw-bold col-form-label">Payment Mode: <span class="text-danger">*</span></label>
                                                        <div class="form-control radioBtn d-flex justify-content-around">
                                                            <label class="mb-0" for="cashPayment"><input type="radio" id="cashPayment" class="form-check-input payment1 me-3" name="payment" value="cash">Cash</label>
                                                            <label class="mb-0" for="chequePayment"><input type="radio" id="chequePayment" class="form-check-input payment1 me-3" name="payment" value="cheque">Cheque</label>
                                                            <label class="mb-0" for="onlinePayment"><input type="radio" id="onlinePayment" class="form-check-input payment1 me-3" name="payment" value="online">UPI/NEFT</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="pb-3 d-none" id="payOpt">
                                                <div class="col-md-12 col-sm-12 d-none" id="chequeOpt1">
                                                    <div class="row d-flex justify-content-center">
                                                        <div class="col-md-4">
                                                            <div class="input-block">
                                                                <label class="col-form-label" for="chequeNo1">Cheque No<span class="text-danger">*</span></label>
                                                                <input type="text" class="form-control" id="chequeNo1" placeholder="Enter Cheque Number">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="input-block">
                                                                <label class="col-form-label" for="chequeDate1">Cheque Date<span class="text-danger">*</span></label>
                                                                <input type="date" class="form-control" id="chequeDate1" placeholder="Enter Date On Cheque">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="input-block">
                                                                <label class="col-form-label" for="bankName1">Bank Name<span class="text-danger">*</span></label>
                                                                <input type="text" class="form-control" id="bankName1" placeholder="Enter your Bank Name">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12 col-sm-12 d-none" id="onlineOpt1">
                                                    <div class="row d-flex justify-content-center">
                                                        <div class="col-md-8">
                                                            <div class="input-block">
                                                                <label class="col-form-label" for="transactionNo1">Transaction No<span class="text-danger">*</span></label>
                                                                <input type="text" class="form-control" id="transactionNo1" placeholder="Enter your Transaction No.">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6 col-sm-6 d-none" id="payProof">
                                                    <div class="mb-3">
                                                        <label class="col-form-label" for="file6">Payment Proof</label><br />
                                                        <input class="form-control" type="file" name="file6" id="upload_file61">
                                                    </div>
                                                    <input type="hidden" id="img_path61" value="">
                                                    <div id="preview61" style="display: none;">
                                                        <div id="image_preview61">
                                                            <img alt="Preview" id="img_pre61">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-sm-6">
                                                    <div class="input-block mb-3">
                                                        <label for="comp_chek" class="col-form-label">Complementary Type<span class="text-danger">*</span></label>
                                                        <select class="form-select" id="comp_chek" aria-label="Floating label select example">
                                                            <option value="null" selected disabled>--Select Complementary Tpe--</option>
                                                            <option value="2">Non Complementary</option>
                                                            <option value="1">Complementary</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php
                                                }
                                            ?>
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-hover align-middle mb-0" id="couponsTable">
                                                    <thead class="table-light">
                                                        <tr>
                                                            <th>Coupon Code</th>
                                                            <th>Coupon</th>
                                                            <th>Date</th>
                                                            <th>Expiry Date</th>
                                                            <th>Status</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    <?php foreach ($coupons as $coupon): ?>
                                                        <?php
                                                            $createdDate = new DateTime($coupon['created_date']);
                                                            $expiryDate = (clone $createdDate)->modify('+5 years');
                                                            $now = new DateTime();
                                                        ?>
                                                        <tr>
                                                            <td><?= htmlspecialchars($coupon['code']) ?></td>
                                                            <td><?= $customer_type?></td>
                                                            <td><?= date('d-m-Y', strtotime($coupon['created_date'])) ?></td>
                                                            <td><?= $expiryDate->format('d-m-Y') ?></td>
                                                            <td>
                                                                <?php
                                                                if ($coupon['usage_status'] == 1) {
                                                                    echo '<span class="badge bg-danger">Used</span> on ' . date('d-m-Y', strtotime($coupon['used_date']));
                                                                } elseif  ($now > $expiryDate) {
                                                                    echo '<span class="badge bg-secondary">Expired</span> on ' . $expiryDate->format('d-m-Y');
                                                                } else {
                                                                    echo '<span class="badge bg-success">Unused</span>';
                                                                }
                                                                ?>
                                                            </td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                        <!-- Example rows, replace with PHP/JS data dynamically -->
                                                        <!-- <tr>
                                                            <td>WELCOME10</td>
                                                            <td>Premium</td>
                                                            <td>01-06-2025</td>
                                                            <td>30-06-2025</td>
                                                            <td><span class="badge bg-success">Unused</span></td>
                                                        </tr>
                                                        <tr>
                                                            <td>SUMMER20</td>
                                                            <td>Premium</td>
                                                            <td>15-05-2025</td>
                                                            <td>17-06-2025</td>
                                                            <td><span class="badge bg-danger">Used</span> on 15-06-2025</td>
                                                        </tr>
                                                        <tr>
                                                            <td>SUMMER21</td>
                                                            <td>Premium</td>
                                                            <td>15-05-2025</td>
                                                            <td>15-06-2025</td>
                                                            <td><span class="badge bg-secondary">Expired</span> on 15-06-2025</td>
                                                        </tr> -->
                                                        <!-- Add more rows dynamically -->
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- coupons only for customers end -->
                            <?php 
                                } 
                            ?>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
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
    <input type="hidden" name="user_id" id="user_id" value="<?php echo $id; ?>">
    <input type="hidden" name="user_type" id="user_type" value="<?php echo $user_type??''; ?>">
    <input type="hidden" name="DBtable" id="DBtable" value="<?php echo $DBtable; ?>">
    <!-- END layout-wrapper -->
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
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <!-- Required datatable js -->
    <script src="../assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="../assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>

    <!-- Responsive examples -->
    <script src="../assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="../assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>

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
        });
    </script>
    <script>
        $(document).ready(function() {
            // $("#user_table1").DataTable();
            // $("#user_table2").DataTable();
            // $("#user_table3").DataTable();
            // $("#user_table4").DataTable();
            // $("#user_table5").DataTable();
            if($('#DBtable').val() == 'ca_customer'){
                $("#couponsTable").DataTable();
            }
            $("#payoutDetailsTable").DataTable();

            var paymentMode = $(".payment:checked").val();
            if (paymentMode == "cheque") {
                $("#chequeOpt").removeClass("d-none");
                $("#onlineOpt").addClass("d-none");
            } else if (paymentMode == "online") {
                $("#onlineOpt").removeClass("d-none");
                $("#chequeOpt").addClass("d-none");
            } else {
                $("#chequeOpt").addClass("d-none");
                $("#onlineOpt").addClass("d-none");
            }
        });

        function showOrderDetails(id) {
            window.location.href = 'order_details.php?vkvbvjfgfikix=' + id;
        }

        function downloadInvoice(id) {
            window.location.href = 'download_invoice?vkvbvjfgfikix=' + id;
        }
    </script>
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
    <script>
        $(function() {
            $('input[name="daterange"]').daterangepicker({
                opens: 'left'
            }, function(start, end, label) {
                // Callback function when the user selects a new date range

                // Log the selected date range to the console
                console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));

                // Extract the selected start and end dates as strings in 'YYYY-MM-DD' format
                var startDate = start.format('YYYY-MM-DD');
                var endDate = end.format('YYYY-MM-DD');
                var id = $('#user_id').val();
                var DBtable = $('#DBtable').val(); //user designation
                var user_type = $('#user_type').val(); //user type
                // Make the AJAX request with the selected date range
                $.ajax({
                    url: 'forms/payout_overview.php', // Replace with your actual endpoint URL
                    type: 'POST', // or 'POST' depending on your API
                    data: {
                        id: id,
                        DBtable: DBtable,
                        user_type: user_type,
                        start_date: startDate, // Send the start date
                        end_date: endDate // Send the end date
                    },
                    success: function(response) {
                        // Handle the response from the server (success callback)
                        console.log('Success:', response);
                        // Optionally update the UI based on the server response
                        $('#payoutDetailsTable').html(response);
                        $("#payoutDetailsTable2").DataTable();
                    },
                    error: function(xhr, status, error) {
                        // Handle any errors that occur during the AJAX request
                        console.log('Error:', error);
                    }
                });
            });
        });

        //comemted for temp reason
        function overviewPage(id,ref,cut,st,ct,message){
            if(message == 'business_consultant'){
                var designation = 'Business Consultant';
            }else if(message == 'corporate_agency'){
                var designation = 'Corporate Agency';
            }else if(message == 'ca_travelagency'){
                var designation = 'Travel Agency';
            }else if(message == 'ca_customer'){
                var designation = 'Customer';
            }else if(message == 'employees'){
                var designation = 'Employees';
            }else if(message == 'business_mentor'){
                var designation = 'Business Mentor';
            }
            window.location.href='overview.php?id='+id+'&ref='+ref+'&cut='+cut+'&st='+st+'&ct='+ct+'&message='+message+'&designation='+designation;
        }
        //payment type
         $('#payment_fee').on('change', function() {
            var payval=$(this).val();
            console.log(payval);
            
            if (payval != 'FOC') {
                $('#paymentMode1').removeClass('d-none');
                $('#payProof').removeClass('d-none');
                $('#payOpt').removeClass('d-none');
            }else{
                $('#paymentMode1').addClass('d-none');
                $('#payProof').addClass('d-none');
                $('#payOpt').addClass('d-none');
            }
        });
        // payment mode
        $('#paymentMode1').on('click', function() {
            var paymentMode = $(".payment1:checked").val();
            // console.log(paymentMode);
            if (paymentMode == "cheque") {
                $("#chequeOpt1").removeClass("d-none");
                $("#onlineOpt1").addClass("d-none");
                $("#transactionNo1").val("");
            } else if (paymentMode == "online") {
                $("#onlineOpt1").removeClass("d-none");
                $("#chequeOpt1").addClass("d-none");
                $("#chequeNo1").val("");
                $("#chequeDate1").val("");
                $("#bankName1").val("");
            } else {
                $("#chequeOpt1").addClass("d-none");
                $("#onlineOpt1").addClass("d-none");
                $("#chequeNo1").val("");
                $("#chequeDate1").val("");
                $("#bankName1").val("");
                $("#transactionNo1").val("");
            }
        });
        
        // $('#img_path6').on('change',function(){
        //     $("#preview6").show();
        //     $("#img_pre6").attr("src","../../uploading/"+data);
        //     $("#img_path6").val(data);
        // })

        $('#generate_coupons').on('click', function () {
            var id = <?= json_encode($id) ?>;
            var customer_type = <?= json_encode($customer_type) ?>;

            var chequeNo = $("#chequeNo1").val().trim();
            var chequeDate = $("#chequeDate1").val().trim();
            var bankName = $("#bankName1").val().trim();
            var transactionNo = $("#transactionNo1").val().trim();
            let payment_fee =$('#payment_fee').val();
            let payment_text = $("#payment_fee option:selected").text().trim();
            var paymentMode = $(".payment1:checked").val();
            let payment_label = payment_text.includes(":")
                ? payment_text.split(":")[0].trim()
                : payment_text;
            let allowed_labels = ["Prime", "Premium", "Premium Plus"];
            let comp_check=$('#comp_chek option:selected').val();

            if (!allowed_labels.includes(payment_label)) {
                alert("Please select a valid Payment Type: Prime, Premium, or Premium Plus.");
                return;
            }
            var payment_proof;
            if (payment_fee === "FOC" || payment_fee === "null") {
                payment_proof = "none";
            } else {
                payment_proof = $("#img_path61").val().trim(); // hidden input
            }
            // Validate payment mode (Cheque or Online)
            if (!paymentMode) {
                alert("Please select a Payment Mode.");
                return;
            }

            // Conditional validation based on payment mode
            if (payment_fee === "Cheque") {
                if (!chequeNo) {
                    alert("Please enter the Cheque Number.");
                    return;
                }
                if (!chequeDate) {
                    alert("Please enter the Cheque Date.");
                    return;
                }
                if (!bankName) {
                    alert("Please enter the Bank Name.");
                    return;
                }
            } else if (payment_fee === "Online") {
                if (!transactionNo) {
                    alert("Please enter the Transaction Number.");
                    return;
                }
            }

            // Payment proof (optional logic)
            if (payment_fee === "FOC" || payment_fee === "null") {
                payment_proof = "none";
            } else {
                payment_proof = $("#img_path61").val().trim();
                if (!payment_proof) {
                    alert("Please upload the Payment Proof.");
                    return;
                }
            }

            // Validate complementary type
            if (!comp_check || comp_check === "null") {
                alert("Please select a Complementary Type.");
                return;
            }

            var data= {
                    id: id,
                    customer_type: customer_type,
                    cheque_no: chequeNo,
                    cheque_date: chequeDate,
                    bank_name: bankName,
                    transaction_no: transactionNo,
                    payment_proof: payment_proof,
                    payment_label: payment_label,
                    payment_fee:payment_fee,
                    paymentMode:paymentMode,
                    comp_chek:comp_check
                }
            //console.log(data);
            
            $.ajax({
                url: 'generate_coupons.php',
                type: 'POST',
                data: data,
                dataType: 'json',
                success: function (response) {
                    if (response==1) {
                        alert('Coupon generated successfully!');
                        location.reload();
                    } else {
                        alert('Failed: ' + response.message);
                    }
                },
                error: function (xhr, status, error) {
                    console.error(error);
                    alert('An error occurred. Check console.');
                }
            });
        });

        //------------- end of comemted for temp reason


        // $('#daterange').on('change', function(){
        //     let fulldate = $('#daterange').val();
        //     console.log(fulldate);
        // });
        //payment type
         $('#payment_fee').on('change', function() {
            var payval=$(this).val();
            console.log(payval);
            
            if (payval != 'FOC') {
                $('#paymentMode1').removeClass('d-none');
                $('#payProof').removeClass('d-none');
                $('#payOpt').removeClass('d-none');
            }else{
                $('#paymentMode1').addClass('d-none');
                $('#payProof').addClass('d-none');
                $('#payOpt').addClass('d-none');
            }
        });
        // payment mode
        $('#paymentMode1').on('click', function() {
            var paymentMode = $(".payment1:checked").val();
            // console.log(paymentMode);
            if (paymentMode == "cheque") {
                $("#chequeOpt1").removeClass("d-none");
                $("#onlineOpt1").addClass("d-none");
                $("#transactionNo1").val("");
            } else if (paymentMode == "online") {
                $("#onlineOpt1").removeClass("d-none");
                $("#chequeOpt1").addClass("d-none");
                $("#chequeNo1").val("");
                $("#chequeDate1").val("");
                $("#bankName1").val("");
            } else {
                $("#chequeOpt1").addClass("d-none");
                $("#onlineOpt1").addClass("d-none");
                $("#chequeNo1").val("");
                $("#chequeDate1").val("");
                $("#bankName1").val("");
                $("#transactionNo1").val("");
            }
        });
    </script>
</body>

</html>