<?php
    include (__DIR__.'/urls.php');
    include_once(__DIR__ . '/../dashboard_user_details.php');

    $id = $_GET['vkvbvjfgfikix'] ?? '';
    $taId = $_GET['taId'] ?? '';
    $country_id = $_GET['ncy'] ?? '';
    $state_id = $_GET['mst'] ?? '';
    $city_id = $_GET['hct'] ?? '';
    $editfor = $_GET['editfor'] ?? '';

    if ($editfor == 'addreff') {
        $stmt1 = $conn->prepare(" SELECT firstname, lastname FROM ca_customer WHERE ca_customer_id = '" . $id . "' ");
        $stmt1->execute();
        $cu_name = $stmt1->fetch();
        $cuName = $cu_name['firstname'] . ' ' . $cu_name['lastname'];
    }
    if ($userType == 10) {
        $stmt11 = $conn->prepare(" SELECT ta_reference_no,customer_type FROM ca_customer WHERE ca_customer_id = '" . $userId . "' ");
        $stmt11->execute();
        $tc = $stmt11->fetch();
        $tcId = $tc['ta_reference_no'];
        $customer_type = $tc['customer_type'];

        if(substr($tcId,0,2) == 'TA'){
            $stmt12 = $conn->prepare(" SELECT firstname, lastname FROM ca_travelagency WHERE ca_travelagency_id = '" . $tcId . "' ");
            $stmt12->execute();
            $tcName = $stmt12->fetch();
            $tcFullName = $tcName['firstname'] . ' ' . $tcName['lastname'];
        }else if(substr($tcId,0,2) == 'IB'){
            $stmt12 = $conn->prepare(" SELECT firstname, lastname FROM institution_branch_manager WHERE institution_branch_manager_id = '" . $tcId . "' ");
            $stmt12->execute();
            $tcName = $stmt12->fetch();
            $tcFullName = $tcName['firstname'] . ' ' . $tcName['lastname'];
        }

    }
?>
<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable">
    <head>
        <meta charset="utf-8" />
        <title>Dashboard | Customer</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- App favicon -->
        <link rel="shortcut icon" href="../assets/images/fav.png">

        <!-- jsvectormap css -->
        <link href="../assets/libs/jsvectormap/css/jsvectormap.min.css" rel="stylesheet" type="text/css" />

        <!--Swiper slider css-->
        <link href="../assets/libs/swiper/swiper-bundle.min.css" rel="stylesheet" type="text/css" />

        <!-- Layout config Js -->
        <script src="../assets/js/layout.js"></script>
        <!-- Bootstrap Css -->
        <link href="../assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <!-- Icons Css -->
        <link href="../assets/css/icons.min.css" rel="stylesheet" type="text/css" />
        <!-- App Css-->
        <link href="../assets/css/app.min.css" rel="stylesheet" type="text/css" />
        <!-- custom Css-->
        <link href="../assets/css/custom.min.css" rel="stylesheet" type="text/css" />
        <!-- custom Css developer-->
        <link rel="stylesheet" href="../assets/css/custom.css" />
        <link href="../assets/css/loadingScreen.css" rel="stylesheet" type="text/css" />
        
        <!-- Customer Dashboard CSS -->
        <link rel="stylesheet" href="../assets/css/travel_consultant.css" />
        <!-- FontAwesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    </head>
    <body>
        <!-- Begin page -->
        <div id="layout-wrapper">

            <?php 
                include_once(__DIR__ . '/travel_consultant_header.php');
            ?>

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

            <?php 
                include_once(__DIR__ . '/travel_consultant_sidebar.php');
            ?>

            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->
            <div class="main-content">

                <div id="testpho"></div>
                <div id="testemails"></div>

                <div class="page-content">
                    <div class="container-fluid">
                        <!-- start page title -->
						<div class="row">
							<div class="col-12">
                                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                    <h4 class="mb-sm-0">Add Customer</h4>
                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="customers_list.php">View Customer</a></li>
                                            <li class="breadcrumb-item active">Add Super Techno Enterprise</li>
                                        </ol>
                                    </div>
                                </div>
                            </div>
						</div>
                        <!-- add customer form start -->
						<div class="row">
							<div class="col-lg-12">
                                <div class="card rounded-4 addTECard">
                                    <div class="d-flex gap-3">
                                        <div class="addTEIconBackground">
                                            <i class="fa-solid fa-user-group addTEIcon"></i>
                                        </div>
                                        <div class="align-content-center">
                                            <h1 class="fw-bolder text-white">Add Customer</h1>
                                            <p class="fs-5 text-white mb-0">Fill in the details below to register a new customer under your network.</p>
                                        </div>
                                    </div>
                                    <img src="../assets/images/addTechnoFileImage.png" alt="" class="addTEImage">
                                </div>
                            </div>
						</div>
                        <!-- Card section 1 -->
                        <div class="card rounded-4 p-3 border-1">
							<div class="row">
                                <div class="d-flex gap-2">
                                    <p class="fw-bolder addTENum">01</p>
                                    <h4 class="fw-bolder text-dark align-content-center">Personal Information</h4>
                                </div>
                                <?php if ($editfor == 'addreff') { ?>
                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                        <div class="input-block mb-3">
                                            <label class="col-form-label" for="cu_ref_id">Customer Reference Id <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="cu_ref_id" placeholder="Enter Reference ID" value="<?php echo $id; ?>" readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                        <div class="input-block mb-3">
                                            <label class="col-form-label" for="cu_ref_name">Customer Reference Name <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="cu_ref_name" placeholder="Enter Reference Name" value="<?php echo $cuName; ?>" readonly>
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                        <div class="input-block mb-3">
                                            <label class="col-form-label" for="user_id_name">TA Reference ID <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="user_id_name" placeholder="Enter Reference ID" value="<?php echo $userId; ?>" readonly>
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                        <div class="input-block mb-3">
                                            <label class="col-form-label" for="reference_name">TA Reference Name <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="reference_name" placeholder="Enter Reference Name" value="<?php echo $userFname . ' ' . $userLname; ?>" readonly>
                                        </div>
                                    </div>
                                <?php } else if ($userType == '11' || $userType == "33") { ?>
                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                        <div class="input-block mb-3">
                                            <label class="col-form-label" for="user_id_name">TA Reference ID <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="user_id_name" placeholder="Enter Reference ID" value="<?php echo $userId; ?>" readonly>
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                        <div class="input-block mb-3">
                                            <label class="col-form-label" for="reference_name">TA Reference Name <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="reference_name" placeholder="Enter Reference Name" value="<?php echo $userFname . ' ' . $userLname; ?>" readonly>
                                        </div>
                                    </div>
                                <?php } else if ($userType == '10') { ?>
                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                        <div class="input-block mb-3">
                                            <label class="col-form-label" for="user_id_name">Customer Reference Id  <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="cu_ref_id" placeholder="Enter Reference ID" value="<?php echo $userId; ?>" readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                        <div class="input-block mb-3">
                                            <label class="col-form-label" for="reference_name">Customer Reference Name <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="cu_ref_name" placeholder="Enter Reference Name" value="<?php echo  $userFname . ' ' . $userLname; ?>" readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                        <div class="input-block mb-3">
                                            <label class="col-form-label" for="user_id_name">TA Reference ID <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="user_id_name" placeholder="Enter Reference ID" value="<?php echo $tcId; ?>" readonly>
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                        <div class="input-block mb-3">
                                            <label class="col-form-label" for="reference_name">TA Reference Name <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="reference_name" placeholder="Enter Reference Name" value="<?php echo $tcFullName; ?>" readonly>
                                        </div>
                                    </div>
                                <?php } else if ($userType == '3') { ?>
                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                        <div class="input-block mb-3">
                                            <label class="col-form-label" for="country">User Id & Name <span class="text-danger">*</span></label>
                                            <select class="form-select" id="user_id_name" aria-label="Floating label select example">
                                                <option value="">--Select Name First--</option>';
                                                <?php
                                                $stmt2 = $conn->prepare("SELECT * FROM `corporate_agency` WHERE reference_no = ? AND status='1'");
                                                $stmt2->execute([$userId]);
                                                $referrals = $stmt2->fetchAll(PDO::FETCH_ASSOC);

                                                foreach ($referrals as $referral) {
                                                    $userCA = $referral['corporate_agency_id'];
                                                    // echo $userCA;

                                                    $stmt4 = $conn->prepare("SELECT * FROM ca_travelagency WHERE reference_no = ? AND status='1'");
                                                    $stmt4->execute([$referral['corporate_agency_id']]);

                                                    if ($stmt4->rowCount() > 0) {
                                                        $userCATAs = $stmt4->fetchAll(PDO::FETCH_ASSOC);
                                                        foreach ($userCATAs as $userCATA) {
                                                            $userTA = $userCATA['ca_travelagency_id'];
                                                            echo '<option value="' . $userCATA['ca_travelagency_id'] . '">' . $userCATA['ca_travelagency_id'] . ' (' . $userCATA['firstname'] . ' ' . $userCATA['lastname'] . ')</option>';
                                                        }
                                                    } else {
                                                        echo '<option value=""> No User </option>';
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                        <div class="input-block mb-3">
                                            <label class="col-form-label" for="reference_name">TA Reference Name <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="reference_name" placeholder="Enter Reference Name" value="" readonly>
                                        </div>
                                    </div>
                                <?php } ?>

                                <div class="col-lg-6 col-md-6 col-sm-6">
                                    <div class="input-block mb-3">
                                        <label class="col-form-label" class="col-form-label" for="firstname">First Name <span class="text-danger">*</span> <span class="text-danger"></span></label>
                                        <input type="text" class="form-control" id="firstname" placeholder="Enter your firstname">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6">
                                    <div class="input-block mb-3">
                                        <label class="col-form-label" for="lastname">Last Name <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="lastname" placeholder="Enter your Lastname">
                                    </div>
                                </div>
                                
                                <div class="col-lg-6 col-md-6 col-sm-6">
                                    <div class="input-block mb-3">
                                        <label class="col-form-label" for="email">Email Address <span class="text-danger">*</span></label>
                                        <input type="email" class="form-control" id="email" placeholder="email">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6">
                                    <div class="input-block mb-3">
                                        <label class="col-form-label" for="dob">Date Of Birth <span class="text-danger">*</span></label>
                                        <input type="date" class="form-control" id="dob" placeholder="Enter Date" max="<?= $ageLimit ?>">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label class="col-form-label">Gender <span class="text-danger">*</span></label>
                                        <div class="form-control d-flex justify-content-around mt-1">
                                            <label class="radio-inline mb-0 ms-3" for="test3"><input type="radio" id="test3" class="gender" name="gender" value="male"/>&nbsp;&nbsp;&nbsp;Male</label>
                                            <label class="radio-inline mb-0 ms-3" for="test4"><input type="radio" id="test4" class="gender" name="gender" value="female"/>&nbsp;&nbsp;&nbsp;Female</label>
                                            <label class="radio-inline mb-0 ms-3" for="test5"><input type="radio" id="test5" class="gender" name="gender" value="others"/>&nbsp;&nbsp;&nbsp;Others</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-2 col-sm-4 col-4">
                                    <div class="input-block mb-3">
                                        <div class="input-block mb-3">
                                            <?php
                                            $stmt = $conn->prepare("SELECT * FROM countries WHERE status = 1 ORDER BY country_name ASC");
                                            $stmt->execute();
                                            $stmt->setFetchMode(PDO::FETCH_ASSOC);
                                            ?>
                                            <label class="col-form-label" for="country_cd">Code</label>
                                            <select class="form-select" id="country_cd" aria-label="Floating label select example">
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
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-8 col-8">
                                    <div class="input-block mb-3">
                                        <label class="col-form-label" for="phone">Phone Number <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control" id="phone" placeholder="Enter your Phone Number">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Card section 2 -->
						<div class="card rounded-4 p-3 border-1">
							<div class="row">
                                <div class="d-flex gap-2">
                                    <p class="fw-bolder addTENum">02</p>
                                    <h4 class="fw-bolder text-dark align-content-center">Residential Information</h4>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6">
                                    <div class="input-block mb-3">
                                        <?php
                                        $stmt = $conn->prepare("SELECT * FROM countries WHERE status = 1 ORDER BY country_name ASC");
                                        $stmt->execute();
                                        $stmt->setFetchMode(PDO::FETCH_ASSOC);
                                        ?>
                                        <label class="col-form-label" for="country">Country <span class="text-danger">*</span></label>
                                        <select class="form-select" id="country" aria-label="Floating label select example">
                                            <option value="" selected>--Select Country--</option>
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
                                        <label class="col-form-label" for="mystate">State <span class="text-danger">*</span></label>
                                        <select class="form-select" id="mystate" aria-label="Floating label select example">
                                            <option value="">--Select country first--</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6">
                                    <div class="input-block mb-3">
                                        <label class="col-form-label" for="city">City <span class="text-danger">*</span></label>
                                        <select class="form-select" id="city" aria-label="Floating label select example">
                                            <option value="">--Select state first--</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6">
                                    <div class="input-block mb-3">
                                        <label class="col-form-label" for="pin">Pincode <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="pin" placeholder="Enter your zipcode">
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <div class="input-block mb-3">
                                        <label class="col-form-label" for="address">Address <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="address" placeholder="Enter your Address">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Card section 3 -->
						<div class="card rounded-4 p-3 border-1">
							<div class="row">
                                <div class="d-flex gap-2">
                                    <p class="fw-bolder addTENum">03</p>
                                    <h4 class="fw-bolder text-dark align-content-center">Payment Information</h4>
                                </div>
                                <?php if ($userType == 11 || $userType == 10 || $userType == 33) { ?>
                                    <div class="col-md-6 col-sm-6 col-12" id="couponFee">
                                        <div class="input-block mb-3">
                                            <label for="payment_fee" class="col-form-label">Payment Fee<span class="text-danger">*</span></label>
                                            <select class="form-select" id="payment_fee" aria-label="Floating label select example">
                                                <option value="null">--Select Payment Fee--</option>
                                                <!-- <option value="FOC" selected>Free</option>
                                                <option value="10000">Prime: <span>&#8377 </span>10,000/-</option>
                                                <option value="30000">Premium: <span>&#8377 </span>30,000/-</option>
                                                <option value="35000">Premium Plus: <span>&#8377 </span>35,000/-</option>
                                                <option value="35000">Premium Select: <span>&#8377 </span>35,000/-</option>
                                                <option value="21000">Premium Select Lite: <span>&#8377 </span>21,000/-</option> -->
                                                <option value="11000">Neo Select: <span>&#8377 </span>11,000/-</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-6 d-none" id="paymentMode">
                                        <label class="fw-bold col-form-label">Payment Mode: <span class="text-danger">*</span></label>
                                        <div class="form-control radioBtn d-flex justify-content-around">
                                            <label class="mb-0" for="cashPayment"><input type="radio" id="cashPayment" class="form-check-input payment me-3" name="payment" value="cash">Cash</label>
                                            <label class="mb-0" for="chequePayment"><input type="radio" id="chequePayment" class="form-check-input payment me-3" name="payment" value="cheque">Cheque</label>
                                            <label class="mb-0" for="onlinePayment"><input type="radio" id="onlinePayment" class="form-check-input payment me-3" name="payment" value="online">UPI/NEFT</label>
                                        </div>
                                    </div>
                                    <div class="d-none" id="payOpt">
                                        <div class="col-md-12 col-sm-12 d-none" id="chequeOpt">
                                            <div class="row d-flex justify-content-center">
                                                <div class="col-md-4">
                                                    <div class="input-block mb-3">
                                                        <label class="col-form-label" for="chequeNo">Cheque No <span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" id="chequeNo" placeholder="Enter Cheque Number">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="input-block mb-3">
                                                        <label class="col-form-label" for="chequeDate">Cheque Date <span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" id="chequeDate" placeholder="Enter Date On Cheque">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="input-block mb-3">
                                                        <label class="col-form-label" for="bankName">Bank Name <span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" id="bankName" placeholder="Enter your Bank Name">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12 col-sm-12 d-none" id="onlineOpt">
                                            <div class="row d-flex justify-content-center">
                                                <div class="col-md-8">
                                                    <div class="input-block mb-3">
                                                        <label class="col-form-label" for="transactionNo">Transaction No. <span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" id="transactionNo" placeholder="Enter your Transaction No.">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                        <!-- Card section 4 -->
						<div class="card rounded-4 p-3 border-1">
							<div class="">
                                <div class="d-flex gap-2">
                                    <p class="fw-bolder addTENum">04</p>
                                    <h4 class="fw-bolder text-dark align-content-center">Upload Documents</h4>
                                </div>
								<div class="row g-3">
                                    <!-- Profile -->
                                    <div class="col-lg-4 col-md-4 col-sm-6 col-12">
                                        <div class="upload-card" data-title="Profile Photo" data-index="1">
                                            <input type="hidden" id="img_path1" value="">
                                            <input type="file" class="file-input" accept="image/*,.pdf" id="upload_file1">
                                            <div class="upload-content">
                                                <div class="upload-icon">
                                                    <i class="fa-solid fa-user"></i>
                                                </div>
                                                <h6>Profile Photo</h6>
                                                <p>Click to upload<br>or drag and drop</p>
                                                <small>(JPG, PNG, PDF)</small>
                                            </div>
                                        </div>
                                    </div>
									<!-- Aadhaar -->
									<div class="col-lg-4 col-md-4 col-sm-6 col-12">
										<div class="upload-card" data-title="Aadhaar Card" data-index="2">
											<input type="hidden" id="img_path2" value="">
											<input type="file" class="file-input" accept="image/*,.pdf" id="upload_file2">
											<div class="upload-content">
												<div class="upload-icon">
													<i class="fa-regular fa-id-card"></i>
												</div>
												<h6>Aadhaar Card</h6>
												<p>Click to upload<br>or drag and drop</p>
												<small>(JPG, PNG, PDF)</small>
											</div>
										</div>
									</div>
                                    <!-- PAN -->
									<div class="col-lg-4 col-md-4 col-sm-6 col-12">
										<div class="upload-card" data-title="PAN Card" data-index="3">
											<input type="hidden" id="img_path3" value="">
											<input type="file" class="file-input" accept="image/*,.pdf" id="upload_file3">
											<div class="upload-content">
												<div class="upload-icon">
													<i class="fa-regular fa-credit-card"></i>
												</div>
												<h6>PAN Card</h6>
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
									<!-- Voting Card -->
									<div class="col-lg-4 col-md-4 col-sm-6 col-12">
										<div class="upload-card" data-title="Voting Card" data-index="4">
											<input type="hidden" id="img_path4" value="">
											<input type="file" class="file-input" accept="image/*,.pdf" id="upload_file5">
											<div class="upload-content">
												<div class="upload-icon">
													<i class="fa-solid fa-building-columns"></i>
												</div>
												<h6>Voting Card</h6>
												<p>Click to upload<br>or drag and drop</p>
												<small>(JPG, PNG, PDF)</small>
											</div>
										</div>
									</div>
									<!-- Payment Proof -->
									<div class="col-lg-4 col-md-4 col-sm-6 col-12 d-none" id="payProof">
										<div class="upload-card" data-title="Payment Proof" data-index="4">
											<input type="hidden" id="img_path4" value="">
											<input type="file" class="file-input" accept="image/*,.pdf" id="upload_file5">
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
                                    <input type="hidden" id="testValue" name="testValue" value="10"> <!-- customer -->
                                    <input type="hidden" id="register_by" name="register_by" value="<?php echo $userType; ?>"> <!-- User type for table col register_by -->
                                    <input type="hidden" id="registrant_id" name="registrant_id" value="<?php echo $userId; ?>">
                                    <input type="hidden" id="editfor" name="editfor" value="<?php echo $editfor; ?>">
                                    
                                    <!-- new added 14-06-2025 -->
                                    <input type="hidden" id="userType" name="userType" value="<?php echo $userType; ?>"> <!-- 24,25,26 -->
                                    <input type="hidden" id="userId" name="userId" value="<?php echo $userId; ?>"> <!-- BH250001, BM250001 -->
                                    <input type="hidden" id="customer_type" name="customer_type" value="<?php echo $customer_type; ?>"> <!-- BH250001, BM250001 -->
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
                    </div> <!-- container-fluid -->
                </div><!-- End Page-content -->
                <?php 
                    include_once(__DIR__ . '/travel_consultant_footer.php');
                ?>
            </div><!-- end main content-->
        </div><!-- END layout-wrapper -->

        <!--start back-to-top-->
        <button onclick="topFunction()" class="scrollToTop scroll-btn show btn" id="back-to-top">
            <i class="ri-arrow-up-line"></i>
        </button>
        <!--end back-to-top-->
        <?php include (__DIR__ .'/../contact_modal.php') ?>

        <!-- JAVASCRIPT -->
        <script src="../assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="../assets/libs/simplebar/simplebar.min.js"></script>
        <script src="../assets/libs/node-waves/waves.min.js"></script>
        <script src="../assets/libs/feather-icons/feather.min.js"></script>
        <script src="../assets/js/jquery/jquery-3.7.1.min.js"></script>

        <script src="../assets/js/submitdata.js"></script>

        <!-- file upload code js file -->
        <script src="../../uploading/uploadUser.js"></script>

        <!-- !-- materialdesign icon js- -->
        <script src="../assets/js/pages/remix-icons-listing.js"></script>
        
        <!-- Vector map-->
        <script src="../assets/libs/jsvectormap/js/jsvectormap.min.js"></script>
        <script src="../assets/libs/jsvectormap/maps/world-merc.js"></script>

        <!--Swiper slider js-->
        <script src="../assets/libs/swiper/swiper-bundle.min.js"></script>
        

        <!-- apexcharts -->
        <script src="../assets/libs/apexcharts/apexcharts.min.js"></script>

        <!-- Vector map-->
        <script src="../assets/libs/jsvectormap/js/jsvectormap.min.js"></script>
        <script src="../assets/libs/jsvectormap/maps/world-merc.js"></script>

        <!--Swiper slider js-->
        <script src="../assets/libs/swiper/swiper-bundle.min.js"></script>

        <!-- App js -->
        <script src="../assets/js/app.js"></script>

        <script>
            // fetch User based on selected designation
            $('#user_id_name').on('change', function() {
                var user_id_name = $(this).val();

                var designation = 'CA_Travel_Agent';

                $.ajax({
                    type: 'POST',
                    url: '../agents/getUsers.php',
                    data: 'user_id_name=' + user_id_name + '&designation=' + designation,
                    success: function(response) {
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
                //coupon applicable logic for goa
                
            });

            function toggleDiv(show) {
                document.getElementById("paymentMode").classList.toggle("d-none", !show);
                document.getElementById("payOpt").classList.toggle("d-none", !show);
                document.getElementById("payProof").classList.toggle("d-none", !show);
                let paymentFee = document.getElementById("payment_fee");
                paymentFee.value = show ? "10000" : "FOC";

            }
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

            $('#city').on('change', function() {
                var cityID = $(this).val();
                if (cityID) {
                    $.ajax({
                        type: 'POST',
                        url: 'address/pincode.php',
                        data: 'city_id=' + cityID,
                        success: function(response) {
                            $('#pin').val(response);
                        }
                    });
                } else {
                    $('#city').html('<option value="">Select state first</option>');
                    $('#pin').val('');
                }
            });
        </script>
        <!-- dialer logic scripts -->
        <script>
            document.addEventListener("DOMContentLoaded", function () {

                const callBtn = document.getElementById("callBtn");

                if (callBtn) {
                    callBtn.addEventListener("click", function(e) {

                        let isMobile = /iPhone|iPad|iPod|Android/i.test(navigator.userAgent);

                        if (!isMobile) {
                            e.preventDefault();

                            alert("📞 Calling works only on mobile devices.\nPlease dial 8010892265 from your phone.");
                            location.reload();

                            // Optional clipboard copy (safe fallback)
                            if (navigator.clipboard) {
                                navigator.clipboard.writeText("8010892265");
                            }
                        }
                    });
                }

            });
        </script>

        <script>
            var modal = document.getElementById('staticBackdrop');

            // Store the element that opened the modal
            let lastFocusedElement;

            document.addEventListener('click', function(e) {
                if (e.target.closest('[data-bs-toggle="modal"]')) {
                    lastFocusedElement = e.target;
                }
            });

            modal.addEventListener('hidden.bs.modal', function () {
                if (lastFocusedElement) {
                    lastFocusedElement.focus();
                } else {
                    document.body.focus();
                }
            });
        </script>
        <!-- end dialer logic scripts -->
    </body>
</html>