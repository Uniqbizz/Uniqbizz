<?php
session_start();

if (!isset($_SESSION['username'])) {
    echo '<script>location.href = "../login.php";</script>';
}
?>
<!doctype html>
<html lang="en">
<?php

require '../connect.php';
$date = date('Y');

$id = $_GET['vkvbvjfgfikix'];
$user_id = $_GET['fyfyfregby'];
$reference_no = $_GET['nohbref'];
$country_id = $_GET['ncy'];
$state_id = $_GET['mst'];
$city_id = $_GET['hct'];

$editfor = $_GET['editfor'];

if ($editfor == 'pending') {
    // $identifier_id= $_POST["vkvbvjfgfikix"];
    $identifier_name = 'id=';
} else if ($editfor == 'registered') {
    // $identifier_id= $_POST["vkvbvjfgfikix"];
    $identifier_name = 'ca_customer_id=';
}

$stmt = $conn->prepare("SELECT * FROM `ca_customer` where ca_customer_id='" . $id . "' OR id = '" . $id . "'");
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
        // $nominee_name = $row['nominee_name'];
        // $nominee_relation = $row['nominee_relation'];
        $email = $row['email'];
        $contact_no = $row['contact_no'];
        // $business_package=$row['business_package'];
        // $amount=$row['amount'];

        $reference_no = $row['ta_reference_no'];
        if (!$reference_no) {
            $reference_no = $row['reference_no'];
        }

        // $gst_no=$row['gst_no'];
        $date_of_birth = $row['date_of_birth'];
        $gender = $row['gender'];
        $country = $row['country'];
        $state = $row['state'];
        $city = $row['city'];
        $address = $row['address'];
        // $id_proof=$row['id_proof'];
        $profile_pic = $row['profile_pic'];
        // $kyc=$row['kyc'];
        $pan_card = $row['pan_card'];
        $aadhar_card = $row['aadhar_card'];
        $voting_card = $row['voting_card'];
        $bank_passbook = $row['passbook'];
        $payment_proof = $row['payment_proof'];
        $payment_mode = $row['payment_mode'];
        $customer_type = $row['customer_type'];
        $cheque_no = $row['cheque_no'];
        $cheque_date = $row['cheque_date'];
        $bank_name = $row['bank_name'];
        $transaction_no = $row['transaction_no'];
        $pincode = $row['pincode'];
        $status = $row['status'];
        $comp_check=$row['comp_chek'];
        $note = $row['note'];
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

        $reference_id = substr($reference_no, 0, 2);
        if ($reference_id == "TA") {
            $caTravelAgencys = $conn->prepare("SELECT firstname, lastname, reference_no FROM ca_travelagency WHERE ca_travelagency_id='" . $reference_no . "'");
            $caTravelAgencys->execute();
            $caTravelAgencys->setFetchMode(PDO::FETCH_ASSOC);
            if ($caTravelAgencys->rowCount() > 0) {
                $caTravelAgency = $caTravelAgencys->fetch();
                $reference_no_fname = $caTravelAgency['firstname'];
                $reference_no_lname = $caTravelAgency['lastname'];
            }
        } else {
            $cacustomers = $conn->prepare("SELECT firstname, lastname, reference_no FROM ca_customer WHERE ca_customer_id='" . $reference_no . "'");
            $cacustomers->execute();
            $cacustomers->setFetchMode(PDO::FETCH_ASSOC);
            if ($cacustomers->rowCount() > 0) {
                $cacustomer = $cacustomers->fetch();
                $reference_no_fname = $cacustomer['firstname'];
                $reference_no_lname = $cacustomer['lastname'];
            }
        }
    }
}
?>

<head>

    <meta charset="utf-8" />
    <title>Edit Customers | Admin Dashboard </title>
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
    <link rel="stylesheet" href="../assets/css/loadingScreen.css" rel="stylesheet" type="text/css" />
    <!-- App js -->
    <!-- <script src="../assets/js/plugin.js"></script> -->

    <!-- Plugins css -->
    <!-- <link href="../assets/libs/dropzone/dropzone.css" rel="stylesheet" type="text/css" /> -->

    <style>
        @media screen and (max-width: 420px) {
            .radioBtn {
                display: flex !important;
            }

            .radioBtn input {
                margin-right: 5px !important;
            }

            .radioBtn label {
                margin-right: 10px !important;
            }
        }
    </style>

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
                                <h4 class="mb-sm-0 font-size-18">Customers</h4>
                            </div>
                        </div>
                    </div>

                    <!-- edit customer form start -->
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <form>
                                        <h3>Edit Customers Form</h3>
                                        <div class="row">
                                            <div class="col-md-12 col-sm-12 d-flex justify-content-end">
                                                <div class="input-block mb-3 form-check">
                                                    <input class="form-check-input" type="checkbox" id="is_complementary" <?=$comp_check==1?'checked':''?> disabled>
                                                    <label class="form-check-label" for="is_complementary">
                                                        Complementary
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
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
                                                    <input type="text" class="form-control" id="reference_name" placeholder="Enter Last Name" value="<?php echo $reference_no_fname . ' ' . $reference_no_lname; ?>" readonly>
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
                                            <!--<div class="col-md-6 col-sm-6">-->
                                            <!--    <div class="input-block mb-3">-->
                                            <!--        <label class="col-form-label" for="nominee_name">Nominee Name<span class="text-danger">*</span></label>-->
                                            <!--        <input type="text" class="form-control" id="nominee_name" placeholder="Enter Nominee First Name" value=" <?php echo $nominee_name; ?>">-->
                                            <!--    </div>-->
                                            <!--</div>-->
                                            <!--<div class="col-md-6 col-sm-6">-->
                                            <!--    <div class="input-block mb-3">-->
                                            <!--        <label class="col-form-label" for="nominee_relation">Nominee Relation<span class="text-danger">*</span></label>-->
                                            <!--        <input type="text" class="form-control" id="nominee_relation" placeholder="Enter Nominee Relation" value=" <?php echo $nominee_relation; ?>">-->
                                            <!--    </div>-->
                                            <!--</div>-->
                                            <div class="col-md-6 col-sm-6">
                                                <div class="input-block mb-3">
                                                    <label class="col-form-label" for="email">Email address<span class="text-danger">*</span></label>
                                                    <input type="email" class="form-control" id="email" placeholder="Enter Email address" value="<?php echo $email; ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-6">
                                                <div class="input-block mb-3">
                                                    <label class="col-form-label" for="dob">Birthdate<span class="text-danger">*</span></label>
                                                    <input type="date" id="dob" class=" form-control" value="<?php echo $date_of_birth; ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-12">
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
                                            <div class="col-md-6 col-sm-12 mb-3">
                                                <div class="row">
                                                    <div class="col-md-4 col-sm-4 col-3">
                                                        <div class="input-block">
                                                            <?php
                                                            $stmt = $conn->prepare("SELECT * FROM countries WHERE status = 1 ORDER BY country_name ASC");
                                                            $stmt->execute();
                                                            $stmt->setFetchMode(PDO::FETCH_ASSOC);
                                                            ?>
                                                            <label for="country_cd" class="col-form-label">Code:</label>
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
                                                            <label for="phone" class="col-form-label">Phone Number<span class="text-danger">*</span></label>
                                                            <input type="text" class="form-control" id="phone" value=" <?php echo $contact_no; ?>">
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
                                                    <input type="text" class="form-control" id="pin" value="<?php echo $pincode; ?>" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-12 col-sm-12">
                                                <div class="input-block mb-3">
                                                    <label class="col-form-label" for="address">Address<span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" id="address" value="<?php echo $address ?>" placeholder="Enter Address">
                                                </div>
                                            </div>
                                            <!-- <div class="col-md-12 col-sm-12 col-12 d-none" id="pay">
                                                <p class="mt-2 mb-0"><span class="fw-bold me-3">Would you like to become a prime customer and receive a coupon worth 10,000?</span>
                                                    <div>
                                                    <input type="radio" id="yes" name="topUp" value="yes" onclick="toggleDiv(true)"
                                                        >
                                                    <label for="yes">Yes</label>

                                                    <input type="radio" id="no" class="ms-2" name="topUp" value="no" onclick="toggleDiv(false)"
                                                        >
                                                    <label for="no">No</label>
                                                    </div>
                                                </p>
                                            </div> -->
                                            <div class="col-md-6 col-sm-6 col-12" id="couponFee">
                                                <div class="input-block mb-3">
                                                    <label class="col-form-label" for="payment_fee">Payment Fee<span class="text-danger">*</span></label>
                                                    <select class="form-select" id="payment_fee" aria-label="Floating label select example" disabled>
                                                        <option value="null">--Select Payment Fee--</option>
                                                        <option value="FOC" <?= $customer_type == "Free" ? 'selected':''; ?>>Free</option>
                                                        <option value="10000" <?= $customer_type == "Prime" ? 'selected' : ''; ?>>Prime: <span>&#8377 </span>10,000/-</option>
                                                        <option value="30000" <?= $customer_type == "Premium" ? 'selected' : ''; ?>>Premium: <span>&#8377 </span>30,000/-</option>
                                                        <option value="35000" <?= $customer_type == "Premium Plus" ? 'selected' : ''; ?>>Premium Plus: <span>&#8377 </span>35,000/-</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-6 <?=$payment_mode != 'Free'?'':'d-none'?>" id="paymentMode">
                                                <div class="input-block mb-3">
                                                    <label class="fw-bold col-form-label">Payment Mode: <span class="text-danger">*</span></label>
                                                    <div class="form-control radioBtn d-flex justify-content-around">
                                                        <label class="mb-0" for="cashPayment">
                                                            <input type="radio" id="cashPayment" class="form-check-input payment me-3" name="payment" value="cash" <?=$payment_mode == "cash"?' checked':''?> disabled>
                                                                Cash
                                                        </label>
                                                        <label class="mb-0" for="chequePayment"><input type="radio" id="chequePayment" class="form-check-input payment me-3" name="payment" value="cheque"
                                                                <?=$payment_mode == "cheque"?' checked':'' ?> disabled>Cheque</label>
                                                        <label class="mb-0" for="onlinePayment"><input type="radio" id="onlinePayment" class="form-check-input payment me-3" name="payment" value="online"
                                                                <?=$payment_mode == "online"?' checked':'' ?> disabled>UPI/NEFT</label>
                                                    </div>
                                                    
                                                </div>
                                            </div>
                                            <div class="pb-3 <?=$payment_mode != 'Free'?'':'d-none'?>" id="payOpt">
                                                <div class="col-md-12 col-sm-12 d-none" id="chequeOpt">
                                                    <div class="row d-flex justify-content-center">
                                                        <div class="col-md-4">
                                                            <div class="input-block">
                                                                <label class="col-form-label" for="chequeNo">Cheque No<span class="text-danger">*</span></label>
                                                                <input type="text" class="form-control" id="chequeNo" placeholder="Enter Cheque Number" value="<?php echo $cheque_no; ?>" disabled>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-4">
                                                            <div class="input-block">
                                                                <label class="col-form-label" for="chequeDate">Cheque Date<span class="text-danger">*</span></label>
                                                                <input type="text" class="form-control" id="chequeDate" placeholder="Enter Date On Cheque" value="<?php echo $cheque_date; ?>" disabled>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-4">
                                                            <div class="input-block">
                                                                <label class="col-form-label" for="bankName">Bank Name<span class="text-danger">*</span></label>
                                                                <input type="text" class="form-control" id="bankName" placeholder="Enter your Bank Name" value="<?php echo $bank_name; ?>" disabled>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-12 col-sm-12 d-none" id="onlineOpt">
                                                    <div class="row d-flex justify-content-center">
                                                        <div class="col-md-8">
                                                            <div class="input-block">
                                                                <label class="col-form-label" for="transactionNo">Transaction No<span class="text-danger">*</span></label>
                                                                <input type="text" class="form-control" id="transactionNo" placeholder="Enter your Transaction No." value="<?php echo $transaction_no; ?>" disabled>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <h4 class="my-2">Attachments</h4>
                                            <div class="col-md-6 col-sm-6">
                                                <div class="mb-3">
                                                    <label class="col-form-label" for="file1"><b>PROFILE</b>
                                                    <?php
                                                        if ($profile_pic) {
                                                            
                                                    ?>
                                                        <a href="<?php echo '../../uploading/' . $profile_pic; ?>" download class="ms-3" title="Download">
                                                            <i class="fa fa-download fa-1x" aria-hidden="true"></i>
                                                        </a>
                                                    <?php
                                                        }
                                                    ?>
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
                                                            echo '<img src="../../uploading/' . $profile_pic . '" alt="Preview" id="img_pre1">';?>
                                                            
                                                    <?php } ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-6">
                                                <div class="mb-3">
                                                    <label class="col-form-label" for="file2"><b>AADHAR CARD</b>
                                                    <?php
                                                        if ($aadhar_card) {
                                                            
                                                    ?>
                                                        <a href="<?php echo '../../uploading/' . $aadhar_card; ?>" download class="ms-3" title="Download">
                                                            <i class="fa fa-download fa-1x" aria-hidden="true"></i>
                                                        </a>
                                                    <?php
                                                        }
                                                    ?>
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
                                                            echo '<img src="../../uploading/' . $aadhar_card . '" alt="Preview" id="img_pre2">';?>
                                                            
                                                    <?php } ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-6">
                                                <div class="mb-3">
                                                    <label class="col-form-label" for="file3"><b>PAN CARD</b>
                                                    <?php
                                                        if ($pan_card) {
                                                            
                                                    ?>
                                                        <a href="<?php echo '../../uploading/' . $pan_card; ?>" download class="ms-3" title="Download">
                                                            <i class="fa fa-download fa-1x" aria-hidden="true"></i>
                                                        </a>
                                                    <?php
                                                        }
                                                    ?>
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
                                                            echo '<img src="../../uploading/' . $pan_card . '" alt="Preview" id="img_pre3">';?>
                                                            
                                                    <?php } ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-6">
                                                <div class="mb-3">
                                                    <label class="col-form-label" for="file4"><b>BANK PASSBOOK</b>
                                                    <?php
                                                        if ($bank_passbook) {
                                                            
                                                    ?>
                                                        <a href="<?php echo '../../uploading/' . $bank_passbook; ?>" download class="ms-3" title="Download">
                                                            <i class="fa fa-download fa-1x" aria-hidden="true"></i>
                                                        </a>
                                                    <?php
                                                        }
                                                    ?>
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
                                                            echo '<img src="../../uploading/' . $bank_passbook . '" alt="Preview" id="img_pre4">';?>
                                                            
                                                    <?php } ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-6">
                                                <div class="mb-3">
                                                    <label class="col-form-label" for="file5"><b>VOTING CARD</b>
                                                    <?php
                                                        if ($voting_card) {
                                                            
                                                    ?>
                                                        <a href="<?php echo '../../uploading/' . $voting_card; ?>" download class="ms-3" title="Download">
                                                            <i class="fa fa-download fa-1x" aria-hidden="true"></i>
                                                        </a>
                                                    <?php
                                                        }
                                                    ?>
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
                                                            echo '<img src="../../uploading/' . $voting_card . '" alt="Preview" id="img_pre5">';?>
                                                           
                                                    <?php } ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-6 <?=$payment_proof!='none' ?'':'d-none'?>" id="payProof">
                                                <div class="mb-3">
                                                    <label class="col-form-label" for="file6"><b>PAYMENT PROOF</b>
                                                    <?php
                                                        if ($payment_proof!='none') {
                                                            
                                                    ?>
                                                        <a href="<?php echo '../../uploading/' . $payment_proof; ?>" download class="ms-3" title="Download">
                                                            <i class="fa fa-download fa-1x" aria-hidden="true"></i>
                                                        </a>
                                                    <?php
                                                        }
                                                    ?>
                                                    </label><br />
                                                    <input class="form-control" type="file" name="file6" id="upload_file6" disabled>
                                                </div>
                                                <input type="hidden" id="img_path6" value="<?php echo $payment_proof; ?>">
                                                <div id="preview6" style="margin-bottom: 50px;">
                                                    <div id="image_preview6">
                                                        <?php
                                                        if ($payment_proof =='none') {
                                                            echo '<img src="../../uploading/not_uploaded.png" alt="Preview" id="img_pre6">';
                                                        } else {
                                                            echo '<img src="../../uploading/' . $payment_proof . '" alt="Preview" id="img_pre6">';?>
                                                            
                                                    <?php } ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12 col-sm-12">
                                                <div class="input-block mb-3">
                                                    <label class="col-form-label" for="flex_amount">Extra Notes<span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" id="note" placeholder="Enter Note" value="<?php echo $note; ?>">
                                                </div>
                                            </div>
                                        </div>
                                        <!-- for edit data page -->
                                        <input type="hidden" id="testValue" name="testValue" value="10"> <!-- Customer -->
                                        <input type="hidden" id="ref_id" name="ref_id" value="<?php echo $reference_no; ?>">
                                        <input type="hidden" id="editfor" name="editfor" value="<?php echo $editfor; ?>">
                                        <input type="hidden" id="id" name="id" value="<?php echo $id; ?>">

                                        <div class="submit-section d-flex justify-content-center mb-4">
                                            <button type="submit" class="btn btn-primary px-5 py-2" id="editCustomer">Submit</button>
                                        </div>
                                    </form>
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
            const paymentMode1 = <?= json_encode($payment_mode) ?>;
            console.log(paymentMode1);
            var paymentMode = $(".payment:checked").val();
            var payment_fee = $('#payment_fee').val()
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
            var state = $('#mystate').val();
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

        // function toggleDiv(show) {
        //     document.getElementById("paymentMode").classList.toggle("d-none", !show);
        //     document.getElementById("payOpt").classList.toggle("d-none", !show);
        //     document.getElementById("payProof").classList.toggle("d-none", !show);
            
        //     // let paymentFee = document.getElementById("payment_fee");

        //     // if (show) {
        //     //     // Default to "10000" when showing the fields (you can change this if needed)
        //     //     paymentFee.value != "FOC";
        //     // } else {
        //     //     // Default to "FOC" when hiding the fields
        //     //     paymentFee.value = "FOC";
        //     // }

        //     // // Trigger change event if you want to update UI elsewhere
        //     // paymentFee.dispatchEvent(new Event('change'));
        // }

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
        //payment type
         $('#payment_fee').on('change', function() {
            var payval=$(this).val();
            if (payval != 'FOC') {
                $('#paymentMode').removeClass('d-none');
                $('#payProof').removeClass('d-none');
                $('#payOpt').removeClass('d-none');
            }else{
                $('#paymentMode').addClass('d-none');
                $('#payProof').addClass('d-none');
                $('#payOpt').addClass('d-none');
            }
        });
        // payment mode
        $('#paymentMode').on('click', function() {
            var paymentMode = $(".payment:checked").val();
            // console.log(paymentMode);
            if (paymentMode == "cheque") {
                $("#chequeOpt").removeClass("d-none");
                $("#onlineOpt").addClass("d-none");
                $("#transactionNo").val("");
            } else if (paymentMode == "online") {
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
</body>

</html>