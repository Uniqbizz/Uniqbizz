<?php
session_start();

if (!isset($_SESSION['username'])) {
    echo '<script>location.href = "../login.php";</script>';
}
?>
<!doctype html>
<html lang="en">
<?php include '../../models/ca_customer/edit_customer.php'  ?>

<head>

    <meta charset="utf-8" />
    <title>Edit Customers | Admin Dashboard </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesbrand" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="../assets/images/fav.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- Bootstrap Css -->
    <link href="../../assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="../../assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="../../assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />
    <!-- Loading Screen and Images size css  -->
    <link rel="stylesheet" href="../../assets/css/loadingScreen.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="../../resources/common_resources/edit_log_tooltip_custom.css"></link>
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
        include_once '../../header.php';

        // sidebar navigation menu 
        include_once '../../sidebar.php';
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
                                    <form id="cutomer_form">
                                        <h3>Edit Customers Form</h3>
                                        <?php if ($transfer_check) {?>
                                        <div class="d-flex justify-content-end">
                                            <span class="gap-1 px-2 py-1 bg-info-subtle text-info rounded">
                                                <i class="fa-solid fa-right-left"></i>
                                                Transfer
                                            </span>
                                        </div>
                                        <?php }?>
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
                                            <?php
                                                if($cust_ref_name){
                                            ?>
                                            <div class="col-md-6 col-sm-6">
                                                <div class="input-block mb-3">
                                                    <label class="col-form-label" for="cust_ref_id">Customer Reference Id<span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" id="cust_ref_id" placeholder="Enter First Name" value="<?php echo $cust_ref; ?>" readonly>
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-6 col-sm-6">
                                                <div class="input-block mb-3">
                                                    <label class="col-form-label" for="cust_reference_name">Customer Reference Full Name<span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" id="cust_reference_name" placeholder="Enter Last Name" value="<?php echo $cust_ref_name; ?>" readonly>
                                                </div>
                                            </div>
                                            <?php
                                                }
                                            ?>
                                            
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
                                            <div class="col-md-6 col-sm-6 col-12" id="couponFee">
                                                <div class="input-block mb-3">
                                                    <label class="col-form-label" for="payment_fee">Payment Fee<span class="text-danger">*</span></label>
                                                    <select class="form-select" id="payment_fee" aria-label="Floating label select example" disabled>
                                                        <option value="null">--Select Payment Fee--</option>
                                                        <option value="FOC" <?= $customer_type == "Free" ? 'selected':''; ?>>Free</option>
                                                        <option value="10000" <?= $customer_type == "Prime" ? 'selected' : ''; ?>>Prime: <span>&#8377 </span>10,000/-</option>
                                                        <option value="30000" <?= $customer_type == "Premium" ? 'selected' : ''; ?>>Premium: <span>&#8377 </span>30,000/-</option>
                                                        <option value="35000" <?= $customer_type == "Premium Plus" ? 'selected' : ''; ?>>Premium Plus: <span>&#8377 </span>35,000/-</option>
                                                        <option value="35000" <?= $customer_type == "Premium Select" ? 'selected' : ''; ?>>Premium Select: <span>&#8377 </span>35,000/-</option>
                                                        <option value="21000" <?= $customer_type == "Premium Select Lite" ? 'selected' : ''; ?>>Premium Select Lite: <span>&#8377 </span>21,000/-</option>
                                                        <option value="11000" <?= $customer_type == "Neo Select" ? 'selected' : ''; ?>>Neo Select: <span>&#8377 </span>11,000/-</option>
                                                        <option value="11000" <?= $customer_type == "Neo Select Ultra" ? 'selected' : ''; ?>>Neo Select Ultra: <span>&#8377 </span>11,000/-</option>
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
                                                        <a href="<?php echo '../../../uploading/' . $profile_pic; ?>" download class="ms-3" title="Download">
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
                                                            echo '<img src="../../../uploading/not_uploaded.png" alt="Preview" id="img_pre1">';
                                                        } else {
                                                            echo '<img src="../../../uploading/' . $profile_pic . '" alt="Preview" id="img_pre1">';?>
                                                            
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
                                                        <a href="<?php echo '../../../uploading/' . $aadhar_card; ?>" download class="ms-3" title="Download">
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
                                                            echo '<img src="../../../uploading/not_uploaded.png" alt="Preview" id="img_pre2">';
                                                        } else {
                                                            echo '<img src="../../../uploading/' . $aadhar_card . '" alt="Preview" id="img_pre2">';?>
                                                            
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
                                                        <a href="<?php echo '../../../uploading/' . $pan_card; ?>" download class="ms-3" title="Download">
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
                                                            echo '<img src="../../../uploading/not_uploaded.png" alt="Preview" id="img_pre3">';
                                                        } else {
                                                            echo '<img src="../../../uploading/' . $pan_card . '" alt="Preview" id="img_pre3">';?>
                                                            
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
                                                        <a href="<?php echo '../../../uploading/' . $bank_passbook; ?>" download class="ms-3" title="Download">
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
                                                            echo '<img src="../../../uploading/not_uploaded.png" alt="Preview" id="img_pre4">';
                                                        } else {
                                                            echo '<img src="../../../uploading/' . $bank_passbook . '" alt="Preview" id="img_pre4">';?>
                                                            
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
                                                        <a href="<?php echo '../../../uploading/' . $voting_card; ?>" download class="ms-3" title="Download">
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
                                                            echo '<img src="../../../uploading/not_uploaded.png" alt="Preview" id="img_pre5">';
                                                        } else {
                                                            echo '<img src="../../../uploading/' . $voting_card . '" alt="Preview" id="img_pre5">';?>
                                                           
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
                                                        <a href="<?php echo '../../../uploading/' . $payment_proof; ?>" download class="ms-3" title="Download">
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
                                                            echo '<img src="../../../uploading/not_uploaded.png" alt="Preview" id="img_pre6">';
                                                        } else {
                                                            echo '<img src="../../../uploading/' . $payment_proof . '" alt="Preview" id="img_pre6">';?>
                                                            
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

                                        <div class="submit-section d-flex justify-content-between mb-4">
                                            <button type="submit" class="btn btn-primary px-5 py-2" id="editCustomer">Submit</button>
                                            <button type="button" class="btn btn-primary submit-btn submit-btn1 px-5 py-2" id="close">
                                                Close
                                            </button>
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


        <?php include_once "../../footer.php" ?>
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
    <!-- commom view modals -->
    <?php include '../common_views/edit_reason_modal_view.php'?>
    
    <?php include '../common_views/no_edit_modal.php'?>

    <!-- JAVASCRIPT -->
    <script src="../../assets/libs/jquery/jquery.min.js"></script>
    <script src="../../assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../../assets/libs/metismenu/metisMenu.min.js"></script>
    <script src="../.../assets/libs/simplebar/simplebar.min.js"></script>
    <script src="../../assets/libs/node-waves/waves.min.js"></script>

    <!-- add data to database js file -->
    <script type="text/javascript" src="../../assets/js/submitdata.js"></script>

    <!-- App js -->
    <script src="../../assets/js/app.js"></script>

    <script src="../../../uploading/upload.js"></script>

    <script src="../../resources/common_resources/top_function.js"></script>

    <!-- ** designation user, user name on designation select / get country, state, city, pincode **  -->
    <script src="../../resources/ca_customer/edit_customer_custom.js"></script>
    <script src="../../resources/common_resources/edit_log_tooltip_custom.js"></script>
</body>

</html>