<?php
include_once 'dashboard_user_details.php';

$id = $_GET['vkvbvjfgfikix'];
$country_id = $_GET['cty'];
$state_id = $_GET['st'];
$city_id = $_GET['ct'];
$zone_id = $_GET['zn'];
$branch_id = $_GET['br'];
$editfor = $_GET['editfor'];

if ($editfor == 'pending') {
    // $identifier_id= $_POST["vkvbvjfgfikix"];
    $identifier_name = 'id=';
} else if ($editfor == 'registered') {
    // $identifier_id= $_POST["vkvbvjfgfikix"];
    $identifier_name = 'business_mentor_id=';
}

$stmt = $conn->prepare("SELECT * FROM `business_mentor` where business_mentor_id='" . $id . "' OR id = '" . $id . "'");
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
        // $business_package=$row['business_package'];
        $paid_amount=$row['paid_amount'];
        $reference_no = $row['reference_no'];
        // $gst_no=$row['gst_no'];
        $date_of_birth = $row['date_of_birth'];
        $gender = $row['gender'];
        $country = $row['country'];
        $state = $row['state'];
        $city = $row['city'];
        $address = $row['address'];
        $zone = $row['zone'];
        $branch = $row['branch'];
        // $id_proof=$row['id_proof'];
        $profile_pic = $row['profile_pic'];
        // $kyc=$row['kyc'];
        $payment_mode = $row['payment_mode'];
        $payment_proof = $row['payment_proof'];
        $pan_card = $row['pan_card'];
        $aadhar_card = $row['aadhar_card'];
        $voting_card = $row['voting_card'];
        $bank_passbook = $row['bank_passbook'];
        $pincode = $row['pincode'];
        $cheque_no = $row['cheque_no'];
        $cheque_date = $row['cheque_date'];
        $bank_name = $row['bank_name'];
        $transaction_no = $row['transaction_no'];
        // $complimentary=$row['complimentary'];
        // $converted=$row['converted'];

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

        //get zone
        $zones = $conn->prepare("SELECT zone_name FROM zone where id='" . $zone . "' and status='1' ");
        $zones->execute();
        $zones->setFetchMode(PDO::FETCH_ASSOC);
        if ($zones->rowCount() > 0) {
            $zone = $zones->fetch();
            $zone_name = $zone['zone_name'];
        }

        //get branch
        $branchs = $conn->prepare("SELECT branch_name FROM branch where id='" . $branch . "' and status='1' ");
        $branchs->execute();
        $branchs->setFetchMode(PDO::FETCH_ASSOC);
        if ($branchs->rowCount() > 0) {
            $branch = $branchs->fetch();
            $branch_name = $branch['branch_name'];
        }

        // Business Channel manager name 
        $business_channel_managers = $conn->prepare("SELECT name, reporting_manager FROM employees where employee_id='" . $reference_no . "'");
        $business_channel_managers->execute();
        $business_channel_managers->setFetchMode(PDO::FETCH_ASSOC);
        if ($business_channel_managers->rowCount() > 0) {
            $business_channel_manager = $business_channel_managers->fetch();
            $reference_no_fname = $business_channel_manager['name'];
            // $reference_no_lname = $business_channel_manager['lastname'];
            // $business_trainees_reference_no = $business_trainee['reference_no'];
        }
    }
}
?>
<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable">

<head>

    <meta charset="utf-8" />
    <title>Edit Business Mentor | Dashboard</title>
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
                            <!-- Page title -->
                            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                <h4 class="mb-sm-0">Edit Business Mentor</h4>
                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item">
                                            <a href="view_business_mentor.php">View Business Mentor</a>
                                        </li>
                                        <li class="breadcrumb-item active">Add</li>
                                    </ol>
                                </div>
                            </div>
                            <!-- page title end -->
                            <div class="card">
                                <div class="card-body">
                                    <div class="h-100">
                                        <form>
                                            <div class="row">
                                                <!-- Personal Details -->

                                                <!-- <div class="col-lg-6 col-md-6 col-sm-6">
                                                        <div class="input-block mb-3">
                                                            <label class="col-form-label">Designation<span class="text-danger">*</span></label>
                                                            <select id="designation" class="form-select">
                                                                <option value="">--Select Designation--</option>
                                                                <option value="sales_manager">Sales Manager</option>
                                                                <option value="channel_business_director">Channel Business Director</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-lg-6 col-md-6 col-sm-6">
                                                        <div class="input-block mb-3">
                                                            <label class="col-form-label">User ID & Name<span class="text-danger">*</span></label>
                                                            <select id="user_id_name" class="form-select"> 
                                                                <option value="">--Select Designation First--</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                                        <div class="input-block mb-3">
                                                            <label class="col-form-label">Referance Name<span class="text-danger">*</span></label>
                                                            <input type="text" class="form-control" id="reference_name" placeholder="No Referance selected for the user" readonly>
                                                        </div>    
                                                    </div> -->
                                                <div class="col-lg-6 col-md-6 col-sm-6">
                                                    <div class="input-block mb-3">
                                                        <label class="col-form-label">Reference Id<span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" id="user_id_name" placeholder="Enter First Name" value="<?php echo $reference_no; ?>" readonly>

                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-6 col-sm-6">
                                                    <div class="input-block mb-3">
                                                        <label class="col-form-label">Reference Full Name <span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" id="reference_name" placeholder="Enter Last Name" value="<?php echo $reference_no_fname; ?>" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-6 col-sm-6">
                                                    <div class="input-block mb-3">
                                                        <label class="col-form-label">First Name <span class="text-danger">*</span></label>
                                                        <input class="form-control" type="text" id="firstname" value="<?php echo $firstname; ?>">
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-6 col-sm-6">
                                                    <div class="input-block mb-3">
                                                        <label class="col-form-label">Last Name <span class="text-danger">*</span></label>
                                                        <input class="form-control" type="text" id="lastname" value=" <?php echo $lastname; ?>">
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-6 col-sm-6">
                                                    <div class="input-block mb-3">
                                                        <label class="col-form-label">Nominee Name<span class="text-danger">*</span></label>
                                                        <input class="form-control" type="text" id="nominee_name" value=" <?php echo $nominee_name; ?>">
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-6 col-sm-6">
                                                    <div class="input-block mb-3">
                                                        <label class="col-form-label">Nominee Relation<span class="text-danger">*</span></label>
                                                        <input class="form-control" type="text" id="nominee_relation" value=" <?php echo $nominee_relation; ?>">
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-6 col-sm-6">
                                                    <div class="input-block mb-3">
                                                        <label class="col-form-label">Email Address<span class="text-danger">*</span></label>
                                                        <input class="form-control" type="email" id="email" value="<?php echo $email; ?>">
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-6 col-sm-6">
                                                    <div class="input-block mb-3">
                                                        <label class="col-form-label">Date of Birth <span class="text-danger">*</span></label>
                                                        <input class="form-control" type="date" id="dob" value="<?php echo $date_of_birth; ?>">
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-6 col-sm-12">
                                                    <div class="form-group">
                                                        <label class="col-form-label">Gender <span class="text-danger">*</span></label>
                                                        <div class="form-control d-flex justify-content-around">
                                                            <label class="radio-inline mb-0 ms-3"><input type="radio" name="gender" class="gender form-check-input" id="test3" value="male" <?php if ($gender == 'male') {
                                                                                                                                                                            echo ' checked ';
                                                                                                                                                                        } ?>>&nbsp;&nbsp;&nbsp;Male</label>
                                                            <label class="radio-inline mb-0 ms-3"><input type="radio" name="gender" class="gender form-check-input" id="test4" value="female" <?php if ($gender == 'female') {
                                                                                                                                                                            echo ' checked ';
                                                                                                                                                                        } ?>>&nbsp;&nbsp;&nbsp;Female</label>
                                                            <label class="radio-inline mb-0 ms-3"><input type="radio" name="gender" class="gender form-check-input" id="test5" value="others" <?php if ($gender == 'others') {
                                                                                                                                                                            echo ' checked ';
                                                                                                                                                                        } ?>>&nbsp;&nbsp;&nbsp;Other</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-2 col-md-2 col-sm-4 col-4">
                                                    <div class="input-block mb-3">
                                                        <?php
                                                        require '../connect.php';
                                                        $stmt = $conn->prepare("SELECT * FROM countries WHERE status = 1 ORDER BY country_name ASC");
                                                        $stmt->execute();
                                                        $stmt->setFetchMode(PDO::FETCH_ASSOC);
                                                        ?>
                                                        <label for="country_cd" class="col-form-label">Code:</label>
                                                        <select class="form-control" id="country_cd">
                                                            <?php
                                                            if ($stmt->rowCount() > 0) {
                                                                foreach (($stmt->fetchAll()) as $key => $row) {
                                                                    echo '<option value="' . $row['country_code'] . '">+' . $row['country_code'] . ' (' . $row['sortname'] . ')</option>';
                                                                }
                                                            } else {
                                                                echo '<option value="">Country not available</option>';
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-md-4 col-sm-8 col-8">
                                                    <div class="input-block mb-3">
                                                        <label class="col-form-label">Phone Number <span class="text-danger">*</span></label>
                                                        <input class="form-control" type="text" id="phone" value=" <?php echo $contact_no; ?>">
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-6 col-sm-6">
                                                    <div class="input-block mb-3">
                                                        <?php
                                                        $stmt = $conn->prepare("SELECT * FROM countries WHERE status = 1 ORDER BY country_name ASC");
                                                        $stmt->execute();
                                                        $stmt->setFetchMode(PDO::FETCH_ASSOC);
                                                        ?>
                                                        <label class="col-form-label">Country <span class="text-danger">*</span></label>
                                                        <select class="form-select" id="country">
                                                            <option value="<?php echo $country_id; ?>"><?php echo $countryname . ' (Already Selected)'; ?></option>
                                                            <?php
                                                            if ($stmt->rowCount() > 0) {
                                                                foreach (($stmt->fetchAll()) as $key => $row) {
                                                                    echo '<option value="' . $row['id'] . '">' . $row['country_name'] . '</option>';
                                                                }
                                                            } else {
                                                                echo '<option value="">Country not available</option>';
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-6 col-sm-6">
                                                    <div class="input-block mb-3">
                                                        <label class="col-form-label">State<span class="text-danger">*</span></label>
                                                        <select class="form-select" id="mystate" aria-label="Floating label select example">
                                                            <option value="<?php echo $state_id; ?>"><?php echo $statename . ' (Already Selected)'; ?></option>
                                                            <option value="">--Select country first--</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-6 col-sm-6">
                                                    <div class="input-block mb-3">
                                                        <label class="col-form-label">City<span class="text-danger">*</span></label>
                                                        <select class="form-select" id="city" aria-label="Floating label select example">
                                                            <option value="<?php echo $city_id; ?>"><?php echo $city_name . ' (Already Selected)'; ?></option>
                                                            <option value="">--Select state first--</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-6 col-sm-6">
                                                    <div class="input-block mb-3">
                                                        <label class="col-form-label">Pincode<span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" id="pin" placeholder="Pincode" value="<?php echo $pincode; ?>" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12 col-md-12 col-sm-12">
                                                    <div class="input-block mb-3">
                                                        <label class="col-form-label">Address<span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" id="address" value="<?php echo $address ?>" placeholder="Address" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-sm-6">
                                                    <div class="input-block mb-3">
                                                        <label class="col-form-label">Zone <span class="text-danger">*</span></label>
                                                        <select class="form-select" id="zone">
                                                            <option value="<?php echo $zone_id; ?>"><?php echo $zone_name . ' (Already Selected)'; ?></option>
                                                            <option value=""> ---- Select Zone ---- </option>
                                                            <?php
                                                            require '../connect.php';
                                                            $sql = "SELECT * FROM `zone` WHERE status ='1' ";
                                                            $stmt = $conn->prepare($sql);
                                                            $stmt->execute();
                                                            $stmt->setFetchMode(PDO::FETCH_ASSOC);
                                                            if ($stmt->rowCount() > 0) {
                                                                foreach (($stmt->fetchAll()) as $key => $row) {
                                                                    echo '
                                                                                <option value="' . $row['id'] . '">' . $row['zone_name'] . '</option>
                                                                            ';
                                                                }
                                                            } else {
                                                                echo '<option value="">Department not available</option>';
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-sm-6">
                                                    <div class="input-block mb-3">
                                                        <label class="col-form-label">Branch <span class="text-danger">*</span></label>
                                                        <select class="form-select" id="branch">
                                                            <option value="<?php echo $branch_id; ?>"><?php echo $branch_name . ' (Already Selected)'; ?></option>
                                                            <option value=""> ---- Select Zone First ---- </option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-sm-6">
                                                    <div class="input-block mb-3">
                                                        <label for="payment_fee" class="col-form-label">Payment Fee</label>
                                                        <select class="form-select" id="payment_fee" disabled>
                                                            <option value="null">--Select Payment Fee--</option>
                                                            <option value="FOC" <?= $paid_amount == 'FOC'?'selected':''?>>Free</option>
                                                            <option value="5000"<?=$paid_amount == '5000'?'selected':''?>><span>&#8377 </span> 5000/-</option>
                                                            <option value="12000"<?= $paid_amount != 'Free'?'selected':''?>><span>&#8377 </span>12000/-</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-sm-6 <?=$payment_mode == 'Free'?'d-none':''?>" id="paymentModeBlock">
                                                    <div class="input-block mb-3">
                                                        <label class="col-form-label">Payment Mode: <span class="text-danger">*</span></label>
                                                        <div class="form-control radioBtn d-flex justify-content-around" id="paymentMode">
                                                            <label class="mb-0" for="cashPayment"><input type="radio" id="cashPayment" class="form-check-input payment me-3" name="payment" value="cash"
                                                                <?php if ($payment_mode == "cash") {
                                                                    echo 'checked';
                                                                } ?> disabled>Cash</label>
                                                            <label class="mb-0" for="chequePayment"><input type="radio" id="chequePayment" class="form-check-input payment me-3" name="payment" value="cheque"
                                                                <?php if ($payment_mode == "cheque") {
                                                                    echo 'checked';
                                                                } ?> disabled>Cheque</label>
                                                            <label class="mb-0" for="onlinePayment"><input type="radio" id="onlinePayment" class="form-check-input payment me-3" name="payment" value="online"
                                                                <?php if ($payment_mode == "online") {
                                                                    echo 'checked';
                                                                } ?> disabled>UPI/NEFT</label>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="pb-3 <?=$payment_mode == 'Free'?'d-none':''?>" id="paymentFields">
                                                    <div class="col-md-12 col-sm-12 d-none" id="chequeOpt">
                                                        <div class="row d-flex justify-content-center">
                                                            <div class="col-md-4 py-1">
                                                                <div class="input-block">
                                                                    <label class="col-form-label" for="chequeNo">Cheque No<span class="text-danger">*</span></label>
                                                                    <input type="text" class="form-control" id="chequeNo" placeholder="Enter Cheque Number" value="<?= isset($cheque_no) && !empty($cheque_no) ? $cheque_no : ''; ?> " readonly>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-4 py-1">
                                                                <div class="input-block">
                                                                    <label class="col-form-label" for="chequeDate">Cheque Date<span class="text-danger">*</span></label>
                                                                    <input type="text" class="form-control" id="chequeDate" placeholder="Enter Date On Cheque" value="<?= isset($cheque_date) && !empty($cheque_date) ? $cheque_date : ''; ?>" readonly>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-4 py-1">
                                                                <div class="input-block">
                                                                    <label class="col-form-label" for="bankName">Bank Name<span class="text-danger">*</span></label>
                                                                    <input type="text" class="form-control" id="bankName" placeholder="Enter your Bank Name" value="<?= isset($bank_name) && !empty($bank_name) ? $bank_name : ''; ?>" readonly>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 col-sm-12 d-none" id="onlineOpt">
                                                        <div class="row d-flex justify-content-center">
                                                            <div class="col-md-8">
                                                                <div class="input-block">
                                                                    <label class="col-form-label" for="transactionNo">Transaction No.<span class="text-danger">*</span>
                                                                    <input type="text" class="form-control" id="transactionNo" placeholder="Enter your Transaction No." value="<?= isset($transaction_no) && !empty($transaction_no) ? $transaction_no : ''; ?>" readonly>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Attachments -->
                                                <h4 class="my-2">Attachments</h4>
                                                <div class="col-md-6 col-sm-6">
                                                    <div class="input-block mb-3">
                                                        <label class="col-form-label">Profile Picture
                                                        <?php
                                                            if ($profile_pic) {
                                                                
                                                        ?>
                                                            <a href="<?php echo '../uploading/' . $profile_pic; ?>" download class="ms-3" title="Download">
                                                                <i class="fa fa-download fa-1x" aria-hidden="true"></i>
                                                            </a>
                                                        <?php
                                                            }
                                                        ?>
                                                        </label>
                                                        <input class="form-control" type="file" name="file1" id="upload_file1">
                                                    </div>
                                                    <input type="hidden" id="img_path1" value="<?php echo $profile_pic; ?>">
                                                    <div id="preview1">
                                                        <div id="image_preview1">
                                                            <?php
                                                            if ($profile_pic == '') {
                                                                echo '<img src="../uploading/not_uploaded.png" alt="Preview" id="img_pre1" class="imgSize">';
                                                            } else {
                                                                echo '<img src="../uploading/' . $profile_pic . '" alt="Preview" id="img_pre1" class="imgSize">';
                                                            }
                                                            ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-sm-6">
                                                    <div class="input-block mb-3">
                                                        <label class="col-form-label">Aadhaar Card
                                                        <?php
                                                            if ($aadhar_card) {
                                                                
                                                        ?>
                                                            <a href="<?php echo '../uploading/' . $aadhar_card; ?>" download class="ms-3" title="Download">
                                                                <i class="fa fa-download fa-1x" aria-hidden="true"></i>
                                                            </a>
                                                        <?php
                                                            }
                                                        ?>
                                                        </label>
                                                        <input class="form-control" type="file" name="file2" id="upload_file2">
                                                    </div>
                                                    <input type="hidden" id="img_path2" value="<?php echo $aadhar_card; ?>">
                                                    <div id="preview2">
                                                        <div id="image_preview2">
                                                            <?php
                                                            if ($aadhar_card == '') {
                                                                echo '<img src="../uploading/not_uploaded.png" alt="Preview" id="img_pre2" class="imgSize">';
                                                            } else {
                                                                echo '<img src="../uploading/' . $aadhar_card . '" alt="Preview" id="img_pre2" class="imgSize">';
                                                            }
                                                            ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-sm-6">
                                                    <div class="input-block mb-3">
                                                        <label class="col-form-label">Pan Card
                                                        <?php
                                                            if ($pan_card) {
                                                                
                                                        ?>
                                                            <a href="<?php echo '../uploading/' . $pan_card; ?>" download class="ms-3" title="Download">
                                                                <i class="fa fa-download fa-1x" aria-hidden="true"></i>
                                                            </a>
                                                        <?php
                                                            }
                                                        ?>
                                                        </label>
                                                        <input class="form-control" type="file" name="file3" id="upload_file3">
                                                    </div>
                                                    <input type="hidden" id="img_path3" value="<?php echo $pan_card; ?>">
                                                    <div id="preview3">
                                                        <div id="image_preview3">
                                                            <?php
                                                            if ($pan_card == '') {
                                                                echo '<img src="../uploading/not_uploaded.png" alt="Preview" id="img_pre3" class="imgSize">';
                                                            } else {
                                                                echo '<img src="../uploading/' . $pan_card . '" alt="Preview" id="img_pre3" class="imgSize">';
                                                            }
                                                            ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-sm-6">
                                                    <div class="input-block mb-3">
                                                        <label class="col-form-label">Bank Passbook
                                                        <?php
                                                            if ($bank_passbook) {
                                                                
                                                        ?>
                                                            <a href="<?php echo '../uploading/' . $bank_passbook; ?>" download class="ms-3" title="Download">
                                                                <i class="fa fa-download fa-1x" aria-hidden="true"></i>
                                                            </a>
                                                        <?php
                                                            }
                                                        ?>
                                                        </label>
                                                        <input class="form-control" type="file" name="file4" id="upload_file4">
                                                    </div>
                                                    <input type="hidden" id="img_path4" value="<?php echo $bank_passbook; ?>">
                                                    <div id="preview4">
                                                        <div id="image_preview4">
                                                            <?php
                                                            if ($bank_passbook == '') {
                                                                echo '<img src="../uploading/not_uploaded.png" alt="Preview" id="img_pre4" class="imgSize">';
                                                            } else {
                                                                echo '<img src="../uploading/' . $bank_passbook . '" alt="Preview" id="img_pre4" class="imgSize">';
                                                            }
                                                            ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-sm-6">
                                                    <div class="input-block mb-3">
                                                        <label class="col-form-label">Voting Card
                                                        <?php
                                                            if ($voting_card) {
                                                                
                                                        ?>
                                                            <a href="<?php echo '../uploading/' . $voting_card; ?>" download class="ms-3" title="Download">
                                                                <i class="fa fa-download fa-1x" aria-hidden="true"></i>
                                                            </a>
                                                        <?php
                                                            }
                                                        ?>
                                                        </label>
                                                        <input class="form-control" type="file" name="file5" id="upload_file5">
                                                    </div>
                                                    <input type="hidden" id="img_path5" value="<?php echo $voting_card; ?>">
                                                    <div id="preview5">
                                                        <div id="image_preview5">
                                                            <?php
                                                            if ($voting_card == '') {
                                                                echo '<img src="../uploading/not_uploaded.png" alt="Preview" id="img_pre5" class="imgSize">';
                                                            } else {
                                                                echo '<img src="../uploading/' . $voting_card . '" alt="Preview" id="img_pre5" class="imgSize">';
                                                            }
                                                            ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-sm-6 <?=$payment_mode == 'Free'?'d-none':''?>" id="payProof">
                                                    <div class="input-block mb-3">
                                                        <label class="col-form-label" for="file6"><b>PAYMENT PROOF</b>
                                                        <?php
                                                            if ($payment_proof) {
                                                                
                                                        ?>
                                                            <a href="<?php echo '../uploading/' . $payment_proof; ?>" download class="ms-3" title="Download">
                                                                <i class="fa fa-download fa-1x" aria-hidden="true"></i>
                                                            </a>
                                                        <?php
                                                            }
                                                        ?>
                                                        </label><br />
                                                        <input class="form-control" type="file" name="file6" id="upload_file6" disabled>
                                                    </div>
                                                    <input type="hidden" id="img_path6" value="<?php echo $payment_proof; ?>">
                                                    <div id="preview6">
                                                        <div id="image_preview6">
                                                            <?php
                                                            if ($payment_proof == '') {
                                                                echo '<img src="../uploading/not_uploaded.png" alt="Preview" id="img_pre6">';
                                                            } else {
                                                                echo '<img src="../uploading/' . $payment_proof . '" alt="Preview" id="img_pre6">';
                                                            }
                                                            ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- for edit data page -->
                                            <!-- <input type="hidden" id="empID" name="empID" value="<?php echo $id; ?>"> Emp ID edit ref -->

                                            <!-- for edit data page -->
                                            <input type="hidden" id="ref_id" name="ref_id" value="<?php echo $reference_no; ?>"> <!--BM240001 -->
                                            <input type="hidden" id="editfor" name="editfor" value="<?php echo $editfor; ?>"> <!--registered -->
                                            <!-- new added 14-06-2025 -->
                                            <input type="hidden" id="userType" name="userType" value="<?php echo $userType; ?>"> <!-- 24,25,26 -->
											<input type="hidden" id="userId" name="userId" value="<?php echo $userId; ?>"> <!-- BH250001, BM250001 -->
                                            
                                            <input type="hidden" id="id" name="id" value="<?php echo $id; ?>"> <!--BM250001 -->
                                            <input type="hidden" id="testValue" name="testValue" value="26"> <!-- Business mentor -->

                                            <div class="submit-section d-flex justify-content-center mb-4">
                                                <button class="btn btn-primary submit-btn submit-btn1 px-5 py-2" id="editBuisnessMentor">Submit</button>
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
        $(document).ready(function() {
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
        $('#paymentMode').on('click', function() {
            var paymentMode = $(".payment:checked").val();
            // console.log(paymentMode);
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
        //select Designation
        $('#designation').on('change', function() {
            var designation = $('#designation').val();
            console.log(designation);
            $.ajax({
                type: 'POST',
                url: 'agents/get_user_Franchisee.php',
                data: "designation=" + designation,
                success: function(e) {
                    console.log(e);
                    $('#user_id_name').html(e);
                },
                error: function(err) {
                    console.log(err);
                },
            });
        });

        // fetch User based on selected designation
        $('#user_id_name').on('change', function() {
            var user_id_name = $(this).val();
            var designation = $('#designation').val();
            console.log(user_id_name);

            // var designation = 'franchisee';
            // console.log(designation);

            $.ajax({
                type: 'POST',
                url: 'agents/getUsers.php',
                data: 'user_id_name=' + user_id_name + '&designation=' + designation,
                success: function(response) {
                    // console.log(response);
                    $('#pin').html(response);
                    $('#reference_name').val(response);
                }
            });

        });

        $('#country').on('change', function() {
            var countryID = $(this).val();
            if (countryID) {
                $.ajax({
                    type: 'POST',
                    url: 'address/countrydata.php',
                    data: 'country_id=' + countryID,
                    success: function(htmll) {
                        $('#mystate').html(htmll);
                        $('#city').html('<option value="">Select state first</option>');
                    }
                });
            } else {
                $('#mystate').html('<option value="">Select country first</option>');
                $('#city').html('<option value="">Select state first</option>');
                $('#pin').val('');
            }
        });

        $('#mystate').on('change', function() {
            // alert();
            var stateID = $(this).val();
            if (stateID) {
                $.ajax({
                    type: 'POST',
                    url: 'address/countrydata.php',
                    data: 'state_id=' + stateID,
                    success: function(html) {
                        $('#city').html(html);
                    }
                });
            } else {
                $('#city').html('<option value="">Select state first</option>');
                $('#pin').val('');
            }
        });

        $('#city').on('change', function() {
            var cityID = $(this).val();
            if (cityID) {
                $.ajax({
                    type: 'POST',
                    url: 'address/pincode.php',
                    data: 'city_id=' + cityID,
                    success: function(response) {
                        // $('#pin').html(response);
                        $('#pin').val(response);
                    }
                });
            } else {
                $('#city').html('<option value="">Select state first</option>');
                $('#pin').val('');
            }
        });

        // on zone change get branch associated with that zone
        $('#zone').on('change', function() {
            var zone_id = $(this).val();
            $.ajax({
                url: 'assets/get_data/get_branch.php',
                type: 'POST',
                data: {
                    zone_id: zone_id
                },
                success: function(data) {
                    $('#branch').html(data);
                }
            });
        });
    </script>
</body>

</html>