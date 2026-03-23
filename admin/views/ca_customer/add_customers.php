<?php
session_start();

include '../../models/common_models/session_check.php';

require '../../connect.php';
//current full date
$today = date('Y-m-d');

//current year
$date = date('Y');

$cust_ref_id = isset($_GET['id']) ? $_GET['id'] : '';
$ta_ref_id = isset($_GET['taRef']) ? $_GET['taRef'] : '';
$cust_ref_name = isset($_GET['fullname']) ? $_GET['fullname'] : '';
$cust_type = isset($_GET['status']) ? $_GET['status'] : '0';

// Calculate 20 years before the current date
$dateTwentyYearsAgo = strtotime("-18 years");

// Format the result as a human-readable date
$ageLimit = date("Y-m-d", $dateTwentyYearsAgo);  // Outputs the date 20 years before today
?>
<!doctype html>
<html lang="en">

<head>

    <meta charset="utf-8" />
    <title>Add Customers | Admin Dashboard </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesbrand" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="../../assets/images/fav.png">

    <!-- Bootstrap Css -->
    <link href="../../assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="../../assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="../../assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />
    <!-- Loading Screen and Images size css  -->
    <link rel="stylesheet" href="../../assets/css/loadingScreen.css" rel="stylesheet" type="text/css" />
    <!-- App js -->
    <!-- <script src="../../assets/js/plugin.js"></script> -->

    <!-- Plugins css -->
    <!-- <link href="../../assets/libs/dropzone/dropzone.css" rel="stylesheet" type="text/css" /> -->

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

                    <!-- add customer form start -->
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <form>
                                        <h3>Add Customers Form</h3>
                                        <div class="row">
                                            <div class="col-md-12 col-sm-12 d-flex justify-content-end">
                                                <div class="input-block mb-3 form-check">
                                                    <input class="form-check-input" type="checkbox" id="is_complementary">
                                                    <label class="form-check-label" for="is_complementary">
                                                        Complementary
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 col-sm-6">
                                                <div class="input-block mb-3">
                                                    <label class="col-form-label" for="user_id_name">User Id & Name<span class="text-danger">*</span></label>
                                                    <select id="user_id_name" class="form-select">
                                                        <option value="">--Select Name First--</option>
                                                        <?php
                                                        $sql = "SELECT * FROM `ca_travelagency` WHERE status ='1' ORDER BY ca_travelagency_id ASC ";
                                                        $stmt = $conn->prepare($sql);
                                                        $stmt->execute();
                                                        $stmt->setFetchMode(PDO::FETCH_ASSOC);
                                                        if ($stmt->rowCount() > 0) {
                                                            foreach ($stmt->fetchAll() as $row) {
                                                                // Check if current row matches the $ta_ref_id
                                                                $selected = ($ta_ref_id == $row['ca_travelagency_id']) ? 'selected' : '';
                                                                echo '<option value="' . $row['ca_travelagency_id'] . '" ' . $selected . '>'
                                                                    . $row['ca_travelagency_id'] .' - '. $row['firstname'] .' '. $row['lastname'] . '</option>';
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
                                            </div>

                                            <div class="col-md-6 col-sm-6" id="indirect_add_cust_id">
                                                <div class="input-block mb-3">
                                                    <label class="col-form-label" for="cust_ref_id">Customer Reference Id <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" id="cust_ref_id" placeholder="Customer Id" readonly value="<?php echo $cust_ref_id; ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-6" id="indirect_add_cust_name">
                                                <div class="input-block mb-3">
                                                    <label class="col-form-label" for="cust_ref_name">Customer Reference Name <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" id="cust_ref_name" placeholder="Customer Name" value="<?php echo $cust_ref_name; ?>" readonly>
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
                                                    <label class="col-form-label" for="email">Email address<span class="text-danger">*</span></label>
                                                    <input type="email" class="form-control" id="email" placeholder="Enter Email address">
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-6">
                                                <div class="input-block mb-3">
                                                    <label class="col-form-label" for="dob">Birthdate<span class="text-danger">*</span></label>
                                                    <input type="date" class="form-control" id="dob" placeholder="Enter Email address" max="<?= $ageLimit ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-12">
                                                <div class="form-group">
                                                    <label class="col-form-label">Gender <span class="text-danger">*</span></label>
                                                    <div class="form-control d-flex justify-content-around mt-1">
                                                        <label class="radio-inline mb-0 ms-3"><input type="radio" name="gender" class="gender form-check-input" id="test3" value="male">&nbsp;&nbsp;&nbsp;Male</label>
                                                        <label class="radio-inline mb-0 ms-3"><input type="radio" name="gender" class="gender form-check-input" id="test4" value="female">&nbsp;&nbsp;&nbsp;Female</label>
                                                        <label class="radio-inline mb-0 ms-3"><input type="radio" name="gender" class="gender form-check-input" id="test5" value="others">&nbsp;&nbsp;&nbsp;Other</label>
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
                                                            <input type="text" class="form-control" id="phone" placeholder="Enter Phone Number">
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
                                                    <label class="col-form-label" for="country">Country <span class="text-danger">*</span></label>
                                                    <select class="form-select" id="country">
                                                        <option selected>--Select Country--</option>
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
                                                    <input type="text" class="form-control" id="pin" placeholder="Pincode" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-12 col-sm-12">
                                                <div class="input-block mb-3">
                                                    <label class="col-form-label" for="address">Address<span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" id="address" placeholder="Enter Address">
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-6 col-12" id="couponFee">
                                                <div class="input-block mb-3">
                                                    <label for="payment_fee" class="col-form-label">Payment Fee<span class="text-danger">*</span></label>
                                                    <select class="form-select" id="payment_fee" aria-label="Floating label select example">
                                                        <option value="null">--Select Payment Fee--</option>
                                                        <option value="FOC" selected>Free</option>
                                                        <option value="10000">Prime: <span>&#8377 </span>10,000/-</option>
                                                        <option value="30000">Premium: <span>&#8377 </span>30,000/-</option>
                                                        <option value="35000">Premium Plus: <span>&#8377 </span>35,000/-</option>
                                                        <option value="35000">Premium Select: <span>&#8377 </span>35,000/-</option>
                                                        <option value="21000">Premium Select Lite: <span>&#8377 </span>21,000/-</option>
                                                        <option value="11000">Neo Select: <span>&#8377 </span>11,000/-</option>
                                                        <option value="11000">Neo Select Ultra: <span>&#8377 </span>11,000/-</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-6 d-none" id="paymentMode">
                                                <div class="input-block mb-3">
                                                    <label class="fw-bold col-form-label">Payment Mode: <span class="text-danger">*</span></label>
                                                    <div class="form-control radioBtn d-flex justify-content-around">
                                                        <label class="mb-0" for="cashPayment"><input type="radio" id="cashPayment" class="form-check-input payment me-3" name="payment" value="cash">Cash</label>
                                                        <label class="mb-0" for="chequePayment"><input type="radio" id="chequePayment" class="form-check-input payment me-3" name="payment" value="cheque">Cheque</label>
                                                        <label class="mb-0" for="onlinePayment"><input type="radio" id="onlinePayment" class="form-check-input payment me-3" name="payment" value="online">UPI/NEFT</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="pb-3 d-none" id="payOpt">
                                                <div class="col-md-12 col-sm-12 d-none" id="chequeOpt">
                                                    <div class="row d-flex justify-content-center">
                                                        <div class="col-md-4">
                                                            <div class="input-block">
                                                                <label class="col-form-label" for="chequeNo">Cheque No<span class="text-danger">*</span></label>
                                                                <input type="text" class="form-control" id="chequeNo" placeholder="Enter Cheque Number">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="input-block">
                                                                <label class="col-form-label" for="chequeDate">Cheque Date<span class="text-danger">*</span></label>
                                                                <input type="text" class="form-control" id="chequeDate" placeholder="Enter Date On Cheque">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
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
                                            <h4 class="my-2">Attachments</h4>
                                            <div class="col-md-6 col-sm-6">
                                                <div class="mb-3">
                                                    <label class="col-form-label" for="file1"><b>PROFILE</b></label><br />
                                                    <input class="form-control" type="file" name="file1" id="upload_file1">
                                                </div>
                                                <input type="hidden" id="img_path1" value="">
                                                <div id="preview1" style="display: none;">
                                                    <div id="image_preview1">
                                                        <img alt="Preview" id="img_pre1">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-6">
                                                <div class="mb-3">
                                                    <label class="col-form-label" for="file2"><b>AADHAR CARD</b></label><br />
                                                    <input class="form-control" type="file" name="file2" id="upload_file2">
                                                </div>
                                                <input type="hidden" id="img_path2" value="">
                                                <div id="preview2" style="display: none;">
                                                    <div id="image_preview2">
                                                        <img alt="Preview" id="img_pre2">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-6">
                                                <div class="mb-3">
                                                    <label class="col-form-label" for="file3"><b>PAN CARD</b></label><br />
                                                    <input class="form-control" type="file" name="file3" id="upload_file3">
                                                </div>
                                                <input type="hidden" id="img_path3" value="">
                                                <div id="preview3" style="display: none;">
                                                    <div id="image_preview3">
                                                        <img alt="Preview" id="img_pre3">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-6">
                                                <div class="mb-3">
                                                    <label class="col-form-label" for="file4"><b>BANK PASSBOOK</b></label><br />
                                                    <input class="form-control" type="file" name="file4" id="upload_file4">
                                                </div>
                                                <input type="hidden" id="img_path4" value="">
                                                <div id="preview4" style="display: none;">
                                                    <div id="image_preview4">
                                                        <img alt="Preview" id="img_pre4">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-6">
                                                <div class="mb-3">
                                                    <label class="col-form-label" for="file5"><b>VOTING CARD</b></label><br />
                                                    <input class="form-control" type="file" name="file5" id="upload_file5">
                                                </div>
                                                <input type="hidden" id="img_path5" value="">
                                                <div id="preview5" style="display: none;">
                                                    <div id="image_preview5">
                                                        <img alt="Preview" id="img_pre5">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-6 d-none" id="payProof">
                                                <div class="mb-3">
                                                    <label class="col-form-label" for="file6"><b>PAYMENT PROOF</b></label><br />
                                                    <input class="form-control" type="file" name="file6" id="upload_file6">
                                                </div>
                                                <input type="hidden" id="img_path6" value="">
                                                <div id="preview6" style="display: none;">
                                                    <div id="image_preview6">
                                                        <img alt="Preview" id="img_pre6">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12 col-sm-12">
                                                <div class="input-block mb-3">
                                                    <label class="col-form-label" for="flex_amount">Extra Notes<span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" id="note" placeholder="Enter Note">
                                                </div>
                                            </div>
                                        </div>
                                        <input type="hidden" id="testValue" name="testValue" value="10"> <!-- Customer -->
                                        <div class="submit-section d-flex justify-content-center mb-4">
                                            <button type="submit" class="btn btn-primary px-5 py-2" id="addCustomer">Submit</button>
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

    <!-- JAVASCRIPT -->
    <script src="../../assets/libs/jquery/jquery.min.js"></script>
    <script src="../../assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../../assets/libs/metismenu/metisMenu.min.js"></script>
    <script src="../../assets/libs/simplebar/simplebar.min.js"></script>
    <script src="../../assets/libs/node-waves/waves.min.js"></script>

    <!-- add data to database js file -->
    <script type="text/javascript" src="../../assets/js/submitdata.js"></script>

    <!-- App js -->
    <script src="../../assets/js/app.js"></script>

    <script src="../../../uploading/upload.js"></script>

    <script src="../../resources/common_resources/top_function.js"></script>
    <script src="../../resources/ca_customer/add_customer_custom.js"></script>
    <!-- due to php mixed with js this has to be in this js code needs to be on the same file -->
    <script>
        var customer_type;
        $(document).ready(function() {
            customer_type = <?php echo json_encode($cust_type, JSON_HEX_TAG); ?>;
            
            if(customer_type == 0 ){
                document.getElementById('indirect_add_cust_id').style.display = 'none';
                document.getElementById('indirect_add_cust_name').style.display = 'none';
            }else{
                document.getElementById('indirect_add_cust_id').style.display = 'block';
                document.getElementById('indirect_add_cust_name').style.display = 'block';
            }
        });
    </script>
    

</body>

</html>