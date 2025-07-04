<?php
session_start();

if (!isset($_SESSION['username'])) {
    echo '<script>location.href = "../login.php";</script>';
}

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
<?php

require '../connect.php';

$id = $_GET['vkvbvjfgfikix'];
$user_id = $_GET['fyfyfregby'];
$reference_no = $_GET['nohbref'];
$country_id = $_GET['ncy'];
$state_id = $_GET['mst'];
$city_id = $_GET['hct'];
$reference_id = '';

$editfor = $_GET['editfor'];

if ($editfor == 'pending') {
    // $identifier_id= $_POST["vkvbvjfgfikix"];
    $identifier_name = 'id=';
} else if ($editfor == 'registered') {
    // $identifier_id= $_POST["vkvbvjfgfikix"];
    $identifier_name = 'corporate_agency_id=';
}

$stmt = $conn->prepare("SELECT * FROM `corporate_agency` where corporate_agency_id='" . $id . "' OR id = '" . $id . "'");
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
        $assign_status=$row['tc_assign_status'];
        $assign_TCs=$row['no_tc_alloted'];
        $assign_tenure=$row['repay_tenure'];
        $assign_roi=$row['roi'];
        $assign_tax=$row['tax'];
        $assign_repay_amount=$row['repay_amount'];
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

        // business_consultant name #2
        // $business_consultants = $conn->prepare("SELECT firstname, lastname FROM business_consultant where business_consultant_id='".$reference_no."'");
        // $business_consultants ->execute();
        // $business_consultants ->setFetchMode(PDO::FETCH_ASSOC);
        // if(  $business_consultants->rowCount()>0 ){
        //     $business_consultants = $business_consultants->fetch();
        //     $reference_no_fname = $business_consultants['firstname'];
        //     $reference_no_lname = $business_consultants['lastname'];
        // }

        // $reference_id = substr($reference_no, 0 , 2); #1
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

        //#3
        $reference_id = substr($reference_no, 0, 2);
        if ($reference_id == "BM") {
            // business Mentor name
            $business_mentors = $conn->prepare("SELECT firstname, lastname, reference_no FROM business_mentor where business_mentor_id='" . $reference_no . "'");
            $business_mentors->execute();
            $business_mentors->setFetchMode(PDO::FETCH_ASSOC);
            if ($business_mentors->rowCount() > 0) {
                $business_mentor = $business_mentors->fetch();
                $reference_no_fname = $business_mentor['firstname'];
                $reference_no_lname = $business_mentor['lastname'];
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
        } else {
            // business_consultant name
            $business_consultants = $conn->prepare("SELECT firstname, lastname FROM business_consultant where business_consultant_id='" . $reference_no . "'");
            $business_consultants->execute();
            $business_consultants->setFetchMode(PDO::FETCH_ASSOC);
            if ($business_consultants->rowCount() > 0) {
                $business_consultants = $business_consultants->fetch();
                $reference_no_fname = $business_consultants['firstname'];
                $reference_no_lname = $business_consultants['lastname'];
            }
        }
    }
}

?>

<head>

    <meta charset="utf-8" />
    <title>Edit Techno Enterprise | Admin Dashboard </title>
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
                                <h4 class="mb-sm-0 font-size-18">Techno Enterprise</h4>
                            </div>
                        </div>
                    </div>

                    <!-- add customer form start -->
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <form>
                                        <h3>Edit Techno Enterprise Form</h3>
                                        <div class="row">
                                            <div class="col-md-6 col-sm-6">
                                                <div class="input-block mb-3">
                                                    <label class="col-form-label" for="user_id_name">Reference Id<span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" id="user_id_name" placeholder="Enter First Name" value="<?php echo $reference_no; ?>" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-6">
                                                <div class="input-block mb-3">
                                                    <label class="col-form-label" for="reference_name">Reference Full Name<span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" id="reference_name" placeholder="Enter Last Name" value="<?= $reference_id == "BH" ? $reference_no_name : $reference_no_fname . ' ' . $reference_no_lname; ?>" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-6">
                                                <div class="input-block mb-3">
                                                    <label class="col-form-label" for="firstname">First Name<span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" id="firstname" placeholder="Enter First Name" value=" <?php echo $firstname; ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-6">
                                                <div class="input-block mb-3">
                                                    <label class="col-form-label" for="lastname">Last Name<span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" id="lastname" placeholder="Enter Last Name" value=" <?php echo $lastname; ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-6">
                                                <div class="input-block mb-3">
                                                    <label class="col-form-label" for="nominee_name">Nominee Name<span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" id="nominee_name" placeholder="Enter Nominee First Name" value=" <?php echo $nominee_name; ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-6">
                                                <div class="input-block mb-3">
                                                    <label class="col-form-label" for="nominee_relation">Nominee Relation<span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" id="nominee_relation" placeholder="Enter Nominee Relation" value=" <?php echo $nominee_relation; ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-6">
                                                <div class="input-block mb-3">
                                                    <label class="col-form-label" for="email">Email address<span class="text-danger">*</span></label>
                                                    <input type="email" class="form-control" id="email" placeholder="Enter Email address" value="<?php echo $email; ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-6">
                                                <div class="input-block mb-3">
                                                    <label class="col-form-label" for="dob">Date Of Birth<span class="text-danger">*</span></label>
                                                    <input type="date" id="dob" class=" form-control" max="<?php echo $ageLimit; ?>" value="<?php echo $date_of_birth; ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-sm-12">
                                                <div class="input-block mb-3">
                                                    <label class="col-form-label" for="business_package_amount">Business Package/Amount<span class="text-danger">*</span></label>
                                                    <select id="business_package_amount" class="form-select" disabled>
                                                        <option value="<?php echo $amount; ?>"><?php echo $amount; ?></option>
                                                        <option value="">--Select Business Package/Amount--</option>
                                                        <option value="200000">2,00,000/-</option>
                                                        <option value="300000">3,00,000/-</option>
                                                        <option value="500000">5,00,000/-</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-sm-12">
                                                <div class="input-block mb-3">
                                                    <label class="col-form-label" for="flex_amount">Enter Amount<span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" id="flex_amount" placeholder="Enter Amount" value="<?php echo $amount; ?>" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-sm-12">
                                                <div class="input-block mb-3">
                                                    <label class="col-form-label" for="gst_no">GST No</label>
                                                    <input type="text" class="form-control" id="gst_no" placeholder="GST NO" value="<?php echo $gst_no; ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-12">
                                                <div class="input-block mb-3">
                                                    <div class="mb-3">
                                                        <label class="col-form-label" class="d-block mb-3">Gender :<span class="text-danger">*</span></label>
                                                        <div class="form-control d-flex justify-content-around">
                                                            <label class="radio-inline mb-0 ms-3" for="test3"><input class="gender form-check-input" type="radio" name="gender" id="test3" value="male" <?php if ($gender == 'male') {
                                                                                                                                                                                                            echo ' checked ';
                                                                                                                                                                                                        } ?>>&nbsp;&nbsp;&nbsp;Male</label>
                                                            <label class="radio-inline mb-0 ms-3" for="test4"><input class="gender form-check-input" type="radio" name="gender" id="test4" value="female" <?php if ($gender == 'female') {
                                                                                                                                                                                                                echo ' checked ';
                                                                                                                                                                                                            } ?>>&nbsp;&nbsp;&nbsp;Female</label>
                                                            <label class="radio-inline mb-0 ms-3" for="test5"><input class="gender form-check-input" type="radio" name="gender" id="test5" value="others" <?php if ($gender == 'others') {
                                                                                                                                                                                                                echo ' checked ';
                                                                                                                                                                                                            } ?>>&nbsp;&nbsp;&nbsp;Others</label>
                                                        </div>
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
                                                    <div class="col-md-8 col-sm-8 col-9">
                                                        <div class="input-block">
                                                            <label class="col-form-label">Phone Number<span class="text-danger">*</span></label>
                                                            <input type="text" class="form-control" id="phone" placeholder="Enter Phone Number" value=" <?php echo $contact_no; ?>">
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
                                            <div class="col-md-6 col-sm-6">
                                                <div class="input-block mb-3">
                                                    <label class="col-form-label" for="mystate">State<span class="text-danger">*</span></label>
                                                    <select class="form-select" id="mystate" aria-label="Floating label select example">
                                                        <option value="<?php echo $state_id; ?>"><?php echo $statename . ' (Already Selected)'; ?></option>
                                                        <option value="">--Select country first--</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-6">
                                                <div class="input-block mb-3">
                                                    <label class="col-form-label" for="city">City<span class="text-danger">*</span></label>
                                                    <select class="form-select" id="city" aria-label="Floating label select example">
                                                        <option value="<?php echo $city_id; ?>"><?php echo $city_name . ' (Already Selected)'; ?></option>
                                                        <option value="">--Select state first--</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-6">
                                                <div class="input-block mb-3">
                                                    <label class="col-form-label" for="pin">Pincode<span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" id="pin" placeholder="Pincode" value="<?php echo $pincode; ?>" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-12 col-sm-12">
                                                <div class="input-block mb-3">
                                                    <label class="col-form-label" for="address">Address<span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" id="address" value="<?php echo $address ?>" placeholder="Enter First Name">
                                                </div>
                                            </div>

                                            <div class="col-md-6 col-sm-6">
                                                <label class="fw-bold col-form-label">Payment Mode: <span class="text-danger">*</span></label>
                                                <div class="form-control radioBtn d-flex justify-content-around" id="paymentMode">
                                                    <label class="mb-0" for="cashPayment"><input type="radio" id="cashPayment" class="form-check-input payment me-3" name="payment" value="cash" <?php if ($payment_mode == "cash") {
                                                                                                                                                                                                        echo 'checked';
                                                                                                                                                                                                    } ?> disabled>Cash</label>
                                                    <label class="mb-0" for="chequePayment"><input type="radio" id="chequePayment" class="form-check-input payment me-3" name="payment" value="cheque" <?php if ($payment_mode == "cheque") {
                                                                                                                                                                                                            echo 'checked';
                                                                                                                                                                                                        } ?> disabled>Cheque</label>
                                                    <label class="mb-0" for="onlinePayment"><input type="radio" id="onlinePayment" class="form-check-input payment me-3" name="payment" value="online" <?php if ($payment_mode == "online") {
                                                                                                                                                                                                            echo 'checked';
                                                                                                                                                                                                        } ?> disabled>UPI/NEFT</label>
                                                </div>
                                            </div>
                                            <div class="pb-3">
                                                <div class="col-md-12 col-sm-12 d-none" id="chequeOpt">
                                                    <div class="row d-flex justify-content-center">
                                                        <div class="col-md-4 py-1">
                                                            <div class="input-block">
                                                                <label class="col-form-label" for="chequeNo">Cheque No<span class="text-danger">*</span></label>
                                                                <input type="text" class="form-control" id="chequeNo" placeholder="Enter Cheque Number" value="<?php echo $cheque_no; ?>" readonly>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4 py-1">
                                                            <div class="input-block">
                                                                <label class="col-form-label" for="chequeDate">Cheque Date<span class="text-danger">*</span></label>
                                                                <input type="text" class="form-control" id="chequeDate" placeholder="Enter Date On Cheque" value="<?php echo $cheque_date; ?>" readonly>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4 py-1">
                                                            <div class="input-block">
                                                                <label class="col-form-label" for="bankName">Bank Name<span class="text-danger">*</span></label>
                                                                <input type="text" class="form-control" id="bankName" placeholder="Enter your Bank Name" value="<?php echo $bank_name; ?>" readonly>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-12 col-sm-12 d-none" id="onlineOpt">
                                                    <div class="row d-flex justify-content-center">
                                                        <div class="col-lg-8">
                                                            <div class="input-block">
                                                                <label class="col-form-label" for="transactionNo">Transaction No<span class="text-danger">*</span></label>
                                                                <input type="text" class="form-control" id="transactionNo" placeholder="Enter your Transaction No." value="<?php echo $transaction_no; ?>" readonly>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Attachments -->
                                            <h4 class="my-2">Attachments</h4>
                                            <div class="col-md-6 col-sm-6">
                                                <div class="input-block mb-3">
                                                    <label class="col-form-label"><b>Profile Picture</b> 
                                                        <a href="<?php echo '../../uploading/' . $profile_pic; ?>" download class="ms-3" title="Download">
                                                            <i class="fa fa-download fa-1x" aria-hidden="true"></i>
                                                        </a>
                                                    </label><br />
                                                    <input class="form-control" type="file" name="file1" id="upload_file1">
                                                </div>
                                                <input type="hidden" id="img_path1" value="<?php echo $profile_pic; ?>">
                                                <div id="preview1">
                                                    <div id="image_preview1" style="margin-bottom: 50px;">
                                                        <?php
                                                        if ($profile_pic == '') {
                                                            echo '<img src="../../uploading/not_uploaded.png" alt="Preview" id="img_pre1">';
                                                        } else {
                                                            echo '<img src="../../uploading/' . $profile_pic . '" alt="Preview" id="img_pre1">'; ?>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-6">
                                                <div class="input-block mb-3">
                                                    <label class="col-form-label"><b>Aadhaar Card</b>
                                                        <a href="<?php echo '../../uploading/' . $aadhar_card; ?>" download class="ms-3" title="Download">
                                                            <i class="fa fa-download fa-1x" aria-hidden="true"></i>
                                                        </a>
                                                    </label><br />
                                                    <input class="form-control" type="file" name="file2" id="upload_file2">
                                                </div>
                                                <input type="hidden" id="img_path2" value="<?php echo $aadhar_card; ?>">
                                                <div id="preview2" style="margin-bottom: 50px;">
                                                    <div id="image_preview2">
                                                        <?php
                                                        if ($aadhar_card == '') {
                                                            echo '<img src="../../uploading/not_uploaded.png" alt="Preview" id="img_pre2">';
                                                        } else {
                                                            echo '<img src="../../uploading/' . $aadhar_card . '" alt="Preview" id="img_pre2">'; ?>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-6">
                                                <div class="input-block mb-3">
                                                    <label class="col-form-label"><b>Pan Card</b>
                                                        <a href="<?php echo '../../uploading/' . $pan_card; ?>" download class="ms-3" title="Download">
                                                            <i class="fa fa-download fa-1x" aria-hidden="true"></i>
                                                        </a>
                                                    </label><br />
                                                    <input class="form-control" type="file" name="file3" id="upload_file3">
                                                </div>
                                                <input type="hidden" id="img_path3" value="<?php echo $pan_card; ?>">
                                                <div id="preview3" style="margin-bottom: 50px;">
                                                    <div id="image_preview3">
                                                        <?php
                                                        if ($pan_card == '') {
                                                            echo '<img src="../../uploading/not_uploaded.png" alt="Preview" id="img_pre3">';
                                                        } else {
                                                            echo '<img src="../../uploading/' . $pan_card . '" alt="Preview" id="img_pre3">'; ?>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-6">
                                                <div class="input-block mb-3">
                                                    <label class="col-form-label"><b>Bank Passbook</b>
                                                        <a href="<?php echo '../../uploading/' . $bank_passbook; ?>" download class="ms-3" title="Download">
                                                            <i class="fa fa-download fa-1x" aria-hidden="true"></i>
                                                        </a>
                                                    </label><br />
                                                    <input class="form-control" type="file" name="file4" id="upload_file4">
                                                </div>
                                                <input type="hidden" id="img_path4" value="<?php echo $bank_passbook; ?>">
                                                <div id="preview4" style="margin-bottom: 50px;">
                                                    <div id="image_preview4">
                                                        <?php
                                                        if ($bank_passbook == '') {
                                                            echo '<img src="../../uploading/not_uploaded.png" alt="Preview" id="img_pre4">';
                                                        } else {
                                                            echo '<img src="../../uploading/' . $bank_passbook . '" alt="Preview" id="img_pre4">'; ?>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-6">
                                                <div class="input-block mb-3">
                                                    <label class="col-form-label"><b>Voting Card</b>
                                                        <a href="<?php echo '../../uploading/' . $voting_card; ?>" download class="ms-3" title="Download">
                                                            <i class="fa fa-download fa-1x" aria-hidden="true"></i>
                                                        </a>
                                                    </label><br />
                                                    <input class="form-control" type="file" name="file5" id="upload_file5">
                                                </div>
                                                <input type="hidden" id="img_path5" value="<?php echo $voting_card; ?>">
                                                <div id="preview5" style="margin-bottom: 50px;">
                                                    <div id="image_preview5">
                                                        <?php
                                                        if ($voting_card == '') {
                                                            echo '<img src="../../uploading/not_uploaded.png" alt="Preview" id="img_pre5">';
                                                        } else {
                                                            echo '<img src="../../uploading/' . $voting_card . '" alt="Preview" id="img_pre5">'; ?>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-6">
                                                <div class="input-block mb-3">
                                                    <label class="col-form-label"><b>Payment Proof</b>
                                                        <a href="<?php echo '../../uploading/' . $payment_proof; ?>" download class="ms-3" title="Download">
                                                            <i class="fa fa-download fa-1x" aria-hidden="true"></i>
                                                        </a>
                                                    </label><br />
                                                    <input class="form-control" type="file" name="file6" id="upload_file6" disabled>
                                                </div>
                                                <input type="hidden" id="img_path6" value="<?php echo $payment_proof; ?>">
                                                <div id="preview6" style="margin-bottom: 50px;">
                                                    <div id="image_preview6">
                                                        <?php
                                                        if ($payment_proof == '') {
                                                            echo '<img src="../../uploading/not_uploaded.png" alt="Preview" id="img_pre6">';
                                                        } else {
                                                            echo '<img src="../../uploading/' . $payment_proof . '" alt="Preview" id="img_pre6">'; ?>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12 col-sm-12">
                                                <div class="input-block mb-3">
                                                    <label class="col-form-label" for="flex_amount">Extra Notes<span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" id="note" placeholder="Enter Note">
                                                </div>
                                            </div>
                                            <div class="col-md-12 col-sm-12 <?= $status != 1 ?'d-none':''?>">
                                                <div class="input-block mb-3">
                                                    <h4>Official Purpose:</h4>
                                                    <!-- radio in a row -->
                                                    <div class="d-flex flex-column gap-2 mb-2" id="tcallotment">
                                                        <label class="form-label fw-bolder">TC Allotment: <span class="text-danger">*</span></label>
                                                        <div class="d-flex gap-3 flex-wrap">
                                                            <div class="form-check me-3">
                                                                <input class="form-check-input" type="radio" id="purpose0" name="official_purpose" value="0" <?=$assign_TCs ==0 ? 'checked':'' ?><?=$assign_status == 1 ? ' disabled':''?>>
                                                                <label class="form-check-label" for="purpose0">0</label>
                                                            </div>
                                                            <div class="form-check me-3">
                                                                <input class="form-check-input" type="radio" id="purpose1" name="official_purpose" value="1" <?= $assign_TCs == 1 ? 'checked':'' ?><?=$assign_status == 1 ? ' disabled':''?>>
                                                                <label class="form-check-label" for="purpose1">1</label>
                                                            </div>
                                                            <div class="form-check me-3">
                                                                <input class="form-check-input" type="radio" id="purpose2" name="official_purpose" value="2" <?=$assign_TCs ==2 ? 'checked':'' ?><?=$assign_status == 1 ? ' disabled':''?>>
                                                                <label class="form-check-label" for="purpose2">2</label>
                                                            </div>
                                                            <div class="form-check me-3">
                                                                <input class="form-check-input" type="radio" id="purpose3" name="official_purpose" value="3" <?=$assign_TCs ==3 ? 'checked':'' ?><?=$assign_status == 1 ? ' disabled':''?>>
                                                                <label class="form-check-label" for="purpose3">3</label>
                                                            </div>
                                                            <div class="form-check me-3">
                                                                <input class="form-check-input" type="radio" id="purpose4" name="official_purpose" value="5" <?=$assign_TCs ==5 ? 'checked':'' ?><?=$assign_status == 1 ? ' disabled':''?>>
                                                                <label class="form-check-label" for="purpose4">5</label>
                                                            </div>
                                                            <div class="form-check me-3">
                                                                <input class="form-check-input" type="radio" id="purpose5" name="official_purpose" value="7" <?=$assign_TCs ==7 ? 'checked':'' ?><?=$assign_status == 1 ? 'disabled':''?>>
                                                                <label class="form-check-label" for="purpose5">7</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div id="availableTCs" class="mt-3 <?=$assign_status == 1 ? 'd-none' : ''?>">
                                                        <div class="mb-2">
                                                            <strong>Selected: <span id="selectedCount">0</span>/<span id="allowedCount">0</span></strong>
                                                        </div>
                                                        <div id="tcListContainer" style="max-height: 250px; overflow-y: auto;">
                                                            <!-- TC checkboxes will be injected here -->
                                                        </div>
                                                        <input type="hidden" name="selected_tc_ids" id="selectedTCsInput">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12 col-sm-12 <?= $status != 1 ?'d-none':''?>">
                                                <div class="input-block mb-3">
                                                    <h4>Repayment:</h4>

                                                    <!-- Tenure radio buttons -->
                                                    <div class="d-flex gap-3 mb-2">
                                                        <h6>Tenure:</h6>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="tenure" id="tenure2" value="2" <?=$assign_tenure == 2 ? 'checked':''?> <?=$assign_status == 1 ? ' disabled':''?>>
                                                            <label class="form-check-label" for="tenure2">2 Years</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="tenure" id="tenure3" value="3" <?=$assign_tenure == 3 ? 'checked':''?><?=$assign_status == 1 ? ' disabled':''?>>
                                                            <label class="form-check-label" for="tenure3">3 Years</label>
                                                        </div>
                                                    </div>
                                                    <!-- ROI -->
                                                    <div class="d-flex gap-3 mb-2">
                                                        <h6>ROI:</h6>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="roi" id="tenure2" value="12"<?=$assign_roi == 12 ? ' checked':''?><?=$assign_status == 1 ? ' disabled':''?>>
                                                            <label class="form-check-label" for="tenure2">12%</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="roi" id="tenure3" value="15"<?=$assign_roi == 15 ? ' checked':''?><?=$assign_status == 1 ? ' disabled':''?>>
                                                            <label class="form-check-label" for="tenure3">15%</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="roi" id="tenure2" value="18"<?=$assign_roi == 18 ? ' checked':''?><?=$assign_status == 1 ? ' disabled':''?>>
                                                            <label class="form-check-label" for="tenure2">18%</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="roi" id="tenure3" value="20"<?=$assign_roi == 20 ? ' checked':''?><?=$assign_status == 1 ? ' disabled':''?>>
                                                            <label class="form-check-label" for="tenure3">20%</label>
                                                        </div>
                                                    </div>

                                                    <!-- Tax After Deduction -->
                                                    <div class="row g-3 align-items-end mb-3">
                                                        <div class="col-md-4 col-sm-6 col-12">
                                                            <div class="col-auto">
                                                                <label for="taxAfterDeduction" class="form-label">Tax: </label>
                                                            </div>
                                                            <div class="col-auto">
                                                                <input type="number" step="0.01" class="form-control" id="taxAfterDeduction" name="taxAfterDeduction" placeholder="Enter tax amount" value="<?= $assign_tax ?? ''?>" <?=$assign_status == 1 ? 'readonly':''?> >
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4 col-sm-6 col-12">
                                                            <div class="col-auto">
                                                                <label for="repayAmount" class="form-label">Repay Amount:</label>
                                                            </div>
                                                            <div class="col-auto">
                                                                <input type="number" step="0.01" class="form-control" id="repayAmount" name="repayAmount" placeholder="Enter repay amount" value="<?= $assign_repay_amount ?? ''?>" <?=$assign_status == 1 ? 'readonly':''?> >
                                                            </div>
                                                        </div>
                                                    </div>

                                                   
                                                </div>
                                            </div>
                                        </div>
                                        <!-- for edit data page -->
                                        <input type="hidden" id="testValue" name="testValue" value="16"> <!-- CA -->
                                        <input type="hidden" id="ref_id" name="ref_id" value="<?php echo $reference_no; ?>">
                                        <input type="hidden" id="editfor" name="editfor" value="<?php echo $editfor; ?>">
                                        <input type="hidden" id="id" name="id" value="<?php echo $id; ?>">

                                        <div class="submit-section d-flex justify-content-center mb-4">
                                            <button type="submit" class="btn btn-primary px-5 py-2" id="editCorporateAgency">Submit</button>
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
        });
    </script>

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
        //select Designation
        $('#designation').on('change', function() {
            var designation = $('#designation').val();
            // console.log(designation);
            $.ajax({
                type: 'POST',
                url: '../agents/get_user_Franchisee.php',
                data: "designation=" + designation,
                success: function(e) {
                    // console.log(e);
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
            // console.log(user_id_name);

            var designation = $('#designation').val();
            // console.log(designation);

            $.ajax({
                type: 'POST',
                url: '../agents/getUsers.php',
                data: 'user_id_name=' + user_id_name + '&designation=' + designation,
                success: function(response) {
                    // console.log(response);
                    // $('#pin').html(response);
                    $('#reference_name').val(response);
                }
            });

        });

        $('#country').on('change', function() {
            var countryID = $(this).val();
            if (countryID) {
                $.ajax({
                    type: 'POST',
                    url: '../address/countrydata.php',
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
                    url: '../address/countrydata.php',
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
                    url: '../address/pincode.php',
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

        $('#business_package_amount').on('change', function() {
            var business_package_amount = $(this).val();
            $('#flex_amount').val(business_package_amount);
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

        //const checkbox = document.getElementById('showTCAlot');
        let allowedCount = 0;

        // Bind official_purpose change ONCE (outside the checkbox toggle)
        $('input[name="official_purpose"]').on('change', function() {
            allowedCount = parseInt($(this).val());
            $('#allowedCount').text(allowedCount);
            $('#selectedCount').text(0);
            $('#selectedTCsInput').val('');

            let reference_no = $('#user_id_name').val();

            $.ajax({
                url: 'get_available_tcs.php',
                type: 'POST',
                data: {
                    tc_count: allowedCount,
                    reference_no: reference_no
                },
                success: function(response) {
                    $('#tcListContainer').html(response);
                    $('#availableTCs').removeClass('d-none');

                    // Attach event to checkboxes inside response
                    $('#tcListContainer').on('change', '.tc-checkbox', function() {
                        let selected = $('.tc-checkbox:checked').length;
                        if (selected > allowedCount) {
                            this.checked = false;
                            alert('You can only select ' + allowedCount + ' TC(s).');
                            return;
                        }
                        $('#selectedCount').text(selected);

                        let selectedIds = [];
                        $('.tc-checkbox:checked').each(function() {
                            selectedIds.push($(this).val());
                        });

                        $('#selectedTCsInput').val(selectedIds.join(','));
                    });
                }
            });
        });

        // checkbox.addEventListener('change', function() {
        //     if (this.checked) {
        //         $('#tcallotment').removeClass('d-none');
        //         $('#availableTCs').removeClass('d-none');
        //     } else {
        //         $('#tcallotment').addClass('d-none');
        //         $('#availableTCs').addClass('d-none');

        //         // Reset all radios
        //         $('input[name="official_purpose"]').prop('checked', false);

        //         // Clear TC list and counts
        //         $('#tcListContainer').html('');
        //         $('#selectedCount').text('0');
        //         $('#allowedCount').text('0');
        //         $('#selectedTCsInput').val('');
        //     }
        // });
    </script>
</body>

</html>