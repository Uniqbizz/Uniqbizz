<?php
include_once 'dashboard_user_details.php';

//get profile col data (img link) to display in header
$stmt = $conn->prepare($sql2);
$stmt->execute();
$stmt->setFetchMode(PDO::FETCH_ASSOC);

function getNameById($conn, $table, $column, $id)
{
    $stmt = $conn->prepare("SELECT {$column} FROM {$table} WHERE id = ? AND status = '1'");
    $stmt->execute([$id]);
    if ($stmt->rowCount() > 0) {
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result[$column];
    }
    return '';
}

if ($stmt->rowCount() > 0) {
    foreach ($stmt->fetchAll() as $key => $value) {
        $profile_pic = $value['profile_pic'];

        // Default values
        $n_name = '';
        $n_relation = '';
        $countryname = '';
        $statename = '';
        $cityname = '';
        $country = '';
        $state = '';
        $city = '';
        $pincode = '';
        $middle = '';
        $bank_passbook='';
        if ($userType == '25' || $userType == '24') {
            $id_proof = $value['id_proof'];
            $bank_passbook = $value['bank_details'];
            $phone_no = $value['contact'];

            // Handle name split safely
            $nameParts = explode(' ', trim($value['name']));
            $fname = $nameParts[0] ?? '';
            $lname = end($nameParts) ?? '';
            // Extract middle names (excluding first and last)
            
            if (count($nameParts) > 2) {
                $middle = implode(' ', array_slice($nameParts, 1, -1));
            }
        } else {
            // Common for userType 10, 11, and others
            $fname = $value['firstname'];
            $lname = $value['lastname'];
            $phone_no = $value['contact_no'];
            $bank_passbook = ($userType == '10' || $userType == '11' || $userType == '33') ? $value['passbook'] : $value['bank_passbook'];
            $pan_card = $value['pan_card'] ?? '';
            $aadhar_card = $value['aadhar_card'] ?? '';
            $voting_card = $value['voting_card'] ?? '';
            $country = $value['country'];
            $state = $value['state'];
            $city = $value['city'];
            $pincode = $value['pincode'];
            $customer_type=$userType == 10?$value['customer_type']:'NA';
            // Get names from IDs
            $countryname = getNameById($conn, 'countries', 'country_name', $country);
            $statename = getNameById($conn, 'states', 'state_name', $state);
            $cityname = getNameById($conn, 'cities', 'city_name', $city);
        }
    }
}
?>

<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable">

    <head>
        <meta charset="utf-8" />
        <title>Dashboard | Uniqbizz</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
        <meta content="Themesbrand" name="author" />
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
        <!-- custom Css-->
        <link href="assets/css/custom.min.css" rel="stylesheet" type="text/css" />
        <!-- App Css-->
        <link href="assets/css/app.min.css" rel="stylesheet" type="text/css" />
        <!-- custom Css developer-->
        <link rel="stylesheet" href="assets/css/custom.css" />
        <link rel="stylesheet" href="assets/fontawesome/css/all.min.css" />
        <!-- <link rel="stylesheet" href="../assets/css/customer_dashboard.css" /> -->
        <!-- FontAwesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <style>
            .upload-documents {
                display: flex !important;
                justify-content: space-between !important;
            }

            .top-space {
                margin-top: 60px;
            }

            @media (max-width: 768px) {
                .upload-documents {
                    width: 100%;
                    display: block !important;
                }
            }

            @media (min-width: 1400px) {
                .upload-documents {
                    display: block !important;
                    margin-top: 135px;
                }

                .column {
                    margin-top: -530px;
                }
            }
        </style>

    </head>

    <body>
        <!-- Begin page -->
        <div id="layout-wrapper">

            <?php include_once "customer_header.php" ?>

            <!-- removeNotificationModal -->
            <div id="removeNotificationModal" class="modal fade zoomIn" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="NotificationModalbtn-close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mt-2 text-center">
                                <lord-icon src="../../../../cdn.lordicon.com/gsqxdxog.json" trigger="loop" colors="primary:#f7b84b,secondary:#f06548" style="width:100px;height:100px"></lord-icon>
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

            <?php include_once "customer_sidebar.php" ?>

            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->
            <div class="main-content">

                <div class="page-content">
                    <div class="container-fluid ">
                        <form>
                            <div class="row">
                                <div class="col-xxl-3 ">
                                    <div class="card z-1">
                                        <div class="card-body p-4">
                                            <div class="text-center">
                                                <div class="profile-user position-relative d-inline-block mx-auto mb-4">
                                                    <!-- Preview image -->
                                                    <img id="img_pre1" src="<?php echo "../../uploading/" . $profile_pic; ?>" class="rounded-circle avatar-xl img-thumbnail user-profile-image shadow" alt="user-profile-image">

                                                    <div class="avatar-xs p-0 rounded-circle profile-photo-edit position-absolute bottom-0 end-0">
                                                        <!-- File input: ID must be profile_pic to match your JS -->
                                                        <input id="pupload_file1" type="file" class="d-none profile-img-file-input" disabled>

                                                        <!-- Hidden input for filename after upload -->
                                                        <input id="img_path1" type="hidden" value="<?= $profile_pic ?>">

                                                        <!-- Label triggers file input -->
                                                        <label for="pupload_file1" class="avatar-xs rounded-circle bg-light text-body shadow d-flex align-items-center justify-content-center" style="cursor: pointer; width: 32px; height: 32px;">
                                                            <i class="ri-camera-fill"></i>
                                                        </label>
                                                    </div>
                                                </div>
                                                <h5 class="fs-16 mb-1"><?php echo $fname . ' ' . $middle . ($middle ? ' ' : '') . $lname; ?></h5>
                                                <p class="text-muted mb-0 fs-16 ">Profile Pic</p>
                                            </div>
                                        </div>
                                    </div>
                                    <!--end card-->
                                    <!-- Upload-Document -->

                                    <!-- End-Upload-Document -->
                                    
                                </div>
                                <!--end col-->
                                <div class="col-xxl-9">
                                    <div class="card">
                                        <div class="card-header">
                                            <ul class="nav nav-tabs-custom rounded card-header-tabs border-bottom-0" role="tablist">
                                                <li class="nav-item">
                                                    <a class="nav-link active" data-bs-toggle="tab" href="#personalDetails" role="tab">
                                                        <i class="fas fa-home"></i> Personal Details
                                                    </a>
                                                </li>
                                                <?php
                                                    if($userType == '10'){
                                                ?>

                                                <li class="nav-item">
                                                    <a class="nav-link" data-bs-toggle="tab" href="#coupons" role="tab">
                                                        <i class="far fa-user"></i> Coupons
                                                    </a>
                                                </li>
                                                <?php
                                                    }
                                                ?>
                                            
                                            </ul>
                                        </div>
                                        <div class="card-body p-4">
                                            <div class="tab-content">
                                                <div class="tab-pane active" id="personalDetails" role="tabpanel">
                                                    <div class="row mt-4">
                                                        <?php  if($userType == '10'){ ?>
                                                        <div class="col-lg-12">
                                                            <?php 
                                                                if($value['comp_chek'] == '1'){
                                                            ?>
                                                                <div class="alert alert-secondary" role="alert">
                                                                    Complimentary Membership
                                                                </div>
                                                            <?php 
                                                                } 
                                                            ?>
                                                        </div>
                                                        <?php  } ?>
                                                        <div class="col-lg-6">
                                                            <div class="mb-4 form-floating">
                                                                <input type="hidden" id="user_type" value="<?php echo $userType; ?>">
                                                                <input type="hidden" id="user_id" value="<?php echo $userId; ?>">
                                                                <input type="text" class="form-control" id="firstname" placeholder="Enter your firstname" value="<?php echo $fname; ?>">
                                                                <label for="firstnameInput" class="form-label">First Name</label>
                                                            </div>
                                                        </div>
                                                        <!--end col-->
                                                        <div class="col-lg-6">
                                                            <div class="mb-4 form-floating">
                                                                <input type="text" class="form-control" id="lastname" placeholder="Enter your lastname" value="<?php echo $lname; ?> ">
                                                                <label for="lastnameInput" class="form-label">Last Name</label>
                                                            </div>
                                                        </div>
                                                        <!--end col-->
                                                    
                                                        <div class="col-lg-6">
                                                            <div class="mb-4 form-floating">
                                                                <input type="text" class="form-control" id="phone" placeholder="Enter your phone number" value="<?php echo $phone_no ?> ">
                                                                <label for="phonenumberInput" class="form-label">Phone Number</label>
                                                            </div>
                                                        </div>
                                                        <!--end col-->
                                                        <div class="col-lg-6">
                                                            <div class="mb-4 form-floating">
                                                                <input type="email" class="form-control" id="email" placeholder="Enter your email" value="<?php echo $value['email']; ?> ">
                                                                <label for="emailInput" class="form-label">Email Address</label>
                                                            </div>
                                                        </div>
                                                        <!--end col-->
                                                        <div class="col-lg-6" style="padding-left: 20px;">
                                                            <h5 class="mt-2 pe-3">Gender</h5>
                                                            <label class="radio-inline mb-0" for="radios1"><input class="radio form-check-input" type="radio" name="gender" value="male" <?php echo $value['gender'] == 'male' ? 'checked' : ''; ?>> Male</label>
                                                            <label class="radio-inline mb-0" for="radios1"><input class="radio form-check-input" type="radio" name="gender" value="female" <?php echo $value['gender'] == 'female' ? 'checked' : ''; ?>> Female</label>
                                                            <label class="radio-inline mb-0" for="radios1"><input class="radio form-check-input" type="radio" name="gender" value="others" <?php echo $value['gender'] == 'others' ? 'checked' : ''; ?>> Others</label>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="mb-4 form-floating">
                                                                <input type="date" class="form-control" id="bdate" placeholder="Enter your D.O.B" value="<?php echo $value['date_of_birth']; ?>">
                                                                <label for="dateInput" class="form-label">Date of Birth</label>
                                                            </div>
                                                        </div>
                                                        <!--end col-->
                                                        <div class="col-lg-6 mb-4 <?= $userType == '25' || $userType == '24' ? 'd-none' : '' ?>">
                                                            <div class="form-floating">
                                                                
                                                                <select class="form-select" id="country" aria-label="Floating label select example">
                                                                    <option value="<?= $country ?>" selected><?php echo $countryname; ?></option>
                                                                </select>
                                                                <label for="country">Country</label>
                                                            </div>
                                                        </div>
                                                        <!--end col-->
                                                        <div class="col-lg-6 mb-4 <?= $userType == '25' || $userType == '24' ? 'd-none' : '' ?>">
                                                            <div class="form-floating">
                                                                <select class="form-select" id="mystate" aria-label="Floating label select example">
                                                                    <option value="<?= $state ?>"><?php echo $statename; ?></option>
                                                                </select>
                                                                <label for="mystate">State</label>
                                                            </div>
                                                        </div>
                                                        <!--end col-->
                                                        <div class="col-lg-6 mb-4 <?= $userType == '25' || $userType == '24' ? 'd-none' : '' ?>">
                                                            <div class="form-floating">
                                                                <select class="form-select" id="city" aria-label="Floating label select example">
                                                                    <option value="<?= $city ?>"><?php echo $cityname; ?></option>
                                                                </select>
                                                                <label for="city">City</label>
                                                            </div>
                                                        </div>
                                                        <!--end col-->
                                                        <div class="col-lg-6 <?= $userType == '25' || $userType == '24' ? 'd-none' : '' ?>">
                                                            <div class="mb-4 form-floating">
                                                                <input type="text" class="form-control" minlength="5" maxlength="6" id="zipcode" placeholder="Enter zipcode" value="<?php echo $pincode ?>">
                                                                <label for="zipcodeInput" class="form-label">Zip Code</label>
                                                            </div>
                                                        </div>
                                                        <!--end col-->
                                                        <div class="col-lg-12">
                                                            <div class="mb-4 pb-2">
                                                                <label for="address" class="form-label">Full Address</label>
                                                                <input type="text" class="form-control" id="address" placeholder="Enter your Address" value="<?php echo $value['address']; ?>">
                                                            </div>
                                                        </div>
                                                        <!--end col-->
                                                        
                                                    </div>
                                                    <!--end row-->

                                                </div>
                                                <div class="tab-pane" id="coupons" role="tabpanel">
                                                    <div class="row">
                                                        <div>
                                                            <?php
                                                                require 'connect.php';
                                                                $sql='SELECT * FROM cu_coupons WHERE user_id=:fid';
                                                                $stmt = $conn->prepare($sql);
                                                                $stmt->execute([':fid' => $userId]);
                                                                $coupons = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                                                //print_r($coupons);
                                                                if(count($coupons) > 0){   
                                                            ?>
                                                            <div class="pt-1 pb-2">
                                                                <h5>Available Coupons</h5>
                                                            </div>
                                                            <?php }else{?>
                                                            <div class="pt-1 pb-2">
                                                                <h5>No Coupons Available </h5>
                                                            </div>
                                                            
                                                            <?php }?>
                                                        </div>
                                                    </div>
                                                    <?php
                                                        require 'connect.php';
                                                        $sql='SELECT * FROM cu_coupons WHERE user_id=:fid';
                                                        $stmt = $conn->prepare($sql);
                                                        $stmt->execute([':fid' => $userId]);
                                                        $coupons = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                                        //print_r($coupons);
                                                        if(count($coupons) == 0){   
                                                    ?>
                                                    
                                                    <?php
                                                        }
                                                    ?>
                                                    <div class="table-responsive">
                                                        <table class="table table-bordered table-hover align-middle mb-0" id="couponsTable">
                                                            <thead class="table-light">
                                                                <tr>
                                                                    <th>Coupon Code</th>
                                                                    <th>Coupon</th>
                                                                    <th>Coupon Amt</th>
                                                                    <th>Date</th>
                                                                    <th>Expiry Date</th>
                                                                    <th>Status</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                            <?php foreach ($coupons as $coupon): ?>
                                                                <?php
                                                                    $createdDate = new DateTime($coupon['created_date']);
                                                                    $expiryDate = new DateTime($coupon['expiry_date']);
                                                                    $now = new DateTime();
                                                                ?>
                                                                <tr>
                                                                    <td><?= htmlspecialchars($coupon['code']) ?></td>
                                                                    <td>
                                                                        <?php if ($customer_type === 'Premium Select Lite' && $coupon['bonus_check'] == 1): ?>
                                                                            <label style="color: #28a745; font-weight: 600; font-size: 14px; display:inline-block; margin-bottom:4px;">
                                                                                Bonus Coupon
                                                                            </label><br>
                                                                            <?= htmlspecialchars($customer_type) ?>
                                                                        <?php else: ?>
                                                                            <?= htmlspecialchars($customer_type) ?>
                                                                        <?php endif; ?>
                                                                    </td>

                                                                    <td>&#8377;<?= $coupon['coupon_amt']?></td>
                                                                    <td><?= date('d-m-Y', strtotime($coupon['created_date'])) ?></td>
                                                                    <td><?= date('d-m-Y', strtotime($coupon['expiry_date'])) ?></td>
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
                                                                
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end col-->
                            </div>
                            <!--end row-->

                            <div class="row">
                                <div class="col-xxl-3 column">
                                    <div class="upload-documents" <?= $userType == '25' || $userType == '24' ? 'style="margin-top: 154px;"' : '' ?>>
                                        <!-- Pan Card -->
                                        <?php if ($userType != '25' && $userType != '24') { ?>
                                        <div class="card">
                                            <div class="card-body p-5">
                                                <div class="text-center">
                                                    <div class="profile-user position-relative d-inline-block mx-auto mb-4">
                                                        <?php if ($pan_card) {
                                                            echo '<img id="img_pre3" src="../uploading/' . $pan_card . '" class="avatar-xl img-thumbnail user-profile-image shadow" alt="user-pan-card">';
                                                        } else {
                                                            echo '<img id="img_pre3" src="../uploading/not_uploaded.png" class="avatar-xl img-thumbnail user-profile-image shadow" alt="user-pan-card">';
                                                        } ?>
                                                        <div class="avatar-xs p-0 profile-photo-edit">
                                                            <input id="pupload_file3" type="file" class="profile-img-file-input" disabled>
                                                            <input id="img_path3" type="hidden" value="<?= $pan_card ?>">
                                                            <label for="pupload_file3" class="profile-photo-edit avatar-xs">
                                                                <span class="avatar-title bg-light text-body shadow">
                                                                    <i class="ri-camera-fill"></i>
                                                                </span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <h5 class="fs-16 mb-1">Pan Card</h5>
                                                </div>
                                            </div>
                                        </div>
                                        <?php } ?>

                                        <!-- Bank Passbook -->
                                        <?php
                                            if ($userType == '25' && $userType == '24'){
                                        ?>
                                        <div class="card">
                                            <div class="card-body p-4">
                                                <div class="text-center">
                                                    <div class="profile-user position-relative d-inline-block mx-auto mb-4">
                                                        
                                                        <?php if ($bank_passbook) {
                                                            echo '<img id="pimg_pre3" src="../uploading/' . $bank_passbook . '" class="avatar-xl img-thumbnail user-profile-image shadow" alt="user-bank-passbook">';
                                                        } else {
                                                            echo '<img id="pimg_pre3" src="../uploading/not_uploaded.png" class="avatar-xl img-thumbnail user-profile-image shadow" alt="user-bank-passbook">';
                                                        } ?>
                                                        
                                                        <div class="avatar-xs p-0 profile-photo-edit">
                                                            <input id="pbank_passbook" type="file" class="profile-img-file-input" disabled>
                                                            <input id="pimg_path3" type="hidden" value="<?= $bank_passbook ?>">
                                                            <label for="pbank_passbook" class="profile-photo-edit avatar-xs">
                                                                <span class="avatar-title bg-light text-body shadow">
                                                                    <i class="ri-camera-fill"></i>
                                                                </span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <h5 class="fs-16 mb-1">Pass Book</h5>
                                                </div>
                                            </div>
                                        </div>
                                        <?php 
                                            } else{
                                        ?>
                                        <div class="card">
                                            <div class="card-body p-4">
                                                <div class="text-center">
                                                    <div class="profile-user position-relative d-inline-block mx-auto mb-4">
                                                        
                                                        <?php if ($bank_passbook) {
                                                            echo '<img id="img_pre4" src="../uploading/' . $bank_passbook . '" class="avatar-xl img-thumbnail user-profile-image shadow" alt="user-bank-passbook">';
                                                        } else {
                                                            echo '<img id="img_pre4" src="../uploading/not_uploaded.png" class="avatar-xl img-thumbnail user-profile-image shadow" alt="user-bank-passbook">';
                                                        } ?>
                                                    
                                                        <div class="avatar-xs p-0 profile-photo-edit">
                                                            <input id="pupload_file4" type="file" class="profile-img-file-input" disabled>
                                                            <input id="img_path4" type="hidden" value="<?= $bank_passbook ?>">
                                                            <label for="pupload_file4" class="profile-photo-edit avatar-xs">
                                                                <span class="avatar-title bg-light text-body shadow">
                                                                    <i class="ri-camera-fill"></i>
                                                                </span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <h5 class="fs-16 mb-1">Pass Book</h5>
                                                </div>
                                            </div>
                                        </div>
                                        <?php 
                                            }
                                        ?>
                                        <!-- Aadhar Card -->
                                        <?php if ($userType != '25' && $userType != '24') { ?>
                                        <div class="card">
                                            <div class="card-body p-4">
                                                <div class="text-center">
                                                    <div class="profile-user position-relative d-inline-block mx-auto mb-4">
                                                        
                                                        <?php if ($aadhar_card) {
                                                            echo '<img id="aimg_pre2" src="../uploading/' . $aadhar_card . '" class="avatar-xl img-thumbnail user-profile-image shadow" alt="user-aadhar">';
                                                        } else {
                                                            echo '<img id="aimg_pre2" src="../uploading/not_uploaded.png" class="avatar-xl img-thumbnail user-profile-image shadow" alt="user-aadhar">';
                                                        } ?>
                                                        
                                                        <div class="avatar-xs p-0 profile-photo-edit">
                                                            <input id="pupload_file2" type="file" class="profile-img-file-input" disabled>
                                                            <input id="aimg_path2" type="hidden" value="<?= $aadhar_card ?>">
                                                            <label for="pupload_file2" class="profile-photo-edit avatar-xs">
                                                                <span class="avatar-title bg-light text-body shadow">
                                                                    <i class="ri-camera-fill"></i>
                                                                </span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <h5 class="fs-16 mb-1">Aadhar Card</h5>
                                                </div>
                                            </div>
                                        </div>
                                        <?php } ?>

                                        <!-- Voting Card -->
                                        <?php if ($userType != '25' && $userType != '24') { ?>
                                        <div class="card">
                                            <div class="card-body p-4">
                                                <div class="text-center">
                                                    <div class="profile-user position-relative d-inline-block mx-auto mb-4">
                                                        
                                                        <?php if ($voting_card) {
                                                            echo '<img id="img_pre5" src="../uploading/' . $voting_card . '" class="avatar-xl img-thumbnail user-profile-image shadow" alt="user-voting-card">';
                                                        } else {
                                                            echo '<img id="img_pre5" src="../uploading/not_uploaded.png" class="avatar-xl img-thumbnail user-profile-image shadow" alt="user-voting-card">';
                                                        } ?>
                                                        
                                                        <div class="avatar-xs p-0 profile-photo-edit">
                                                            <input id="pupload_file5" type="file" class="profile-img-file-input" disabled>
                                                            <input id="img_path5" type="hidden" value="<?= $voting_card ?>">
                                                            <label for="pupload_file5" class="profile-photo-edit avatar-xs">
                                                                <span class="avatar-title bg-light text-body shadow">
                                                                    <i class="ri-camera-fill"></i>
                                                                </span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <h5 class="fs-16 mb-1">Voting Card</h5>
                                                </div>
                                            </div>
                                        </div>
                                        <?php } ?>

                                        <!-- ID Proof -->
                                        <?php if ($userType == '25' || $userType == '24') { ?>
                                        <div class="card">
                                            <div class="card-body p-4">
                                                <div class="text-center">
                                                    <div class="profile-user position-relative d-inline-block mx-auto mb-4">
                                                        
                                                        <?php if ($id_proof) {
                                                            echo '<img id="pimg_pre2" src="../uploading/' . $id_proof . '" class="avatar-xl img-thumbnail user-profile-image shadow" alt="user-id-proof">';
                                                        } else {
                                                            echo '<img id="pimg_pre2" src="../uploading/not_uploaded.png" class="avatar-xl img-thumbnail user-profile-image shadow" alt="user-id-proof">';
                                                        } ?>
                                                        
                                                        <div class="avatar-xs p-0 profile-photo-edit">
                                                            <input id="pid_proof" type="file" class="profile-img-file-input" disabled>
                                                            <input id="pimg_path2" type="hidden" value="<?= $id_proof ?>">
                                                            <label for="pid_proof" class="profile-photo-edit avatar-xs">
                                                                <span class="avatar-title bg-light text-body shadow">
                                                                    <i class="ri-camera-fill"></i>
                                                                </span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <h5 class="fs-16 mb-1">Id Proof</h5>
                                                </div>
                                            </div>
                                        </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </form>

                    </div>
                    <!-- container-fluid -->
                </div><!-- End Page-content -->

                <?php include_once "customer_footer.php" ?>
            </div>
            <!-- end main content-->

        </div>
        <!-- END layout-wrapper -->

        <!--start back-to-top-->
        <button onclick="topFunction()" class="scrollToTop scroll-btn show btn" id="back-to-top">
            <i class="ri-arrow-up-line"></i>
        </button>
        <!--end back-to-top-->
        <!-- Theme Settings -->

        <!-- JAVASCRIPT -->
        <script src="assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="assets/libs/simplebar/simplebar.min.js"></script>
        <script src="assets/libs/node-waves/waves.min.js"></script>
        <script src="assets/libs/feather-icons/feather.min.js"></script>
        <script src="assets/js/jquery/jquery-3.7.1.min.js"></script>

        <!-- App js -->
        <script src="assets/js/app.js"></script>
        <!-- file upload code js file -->
        <script src="../uploading/upload.js"></script>

        <script>
        
        $('#edit_profile').on('click', function (event) {
                event.preventDefault();

                // Create a FormData object
                var formData = new FormData();

                // Append input values
                formData.append('user_type', $('#user_type').val());
                formData.append('user_id', $('#user_id').val());
                formData.append('firstname', $('#firstname').val());
                formData.append('lastname', $('#lastname').val());
                formData.append('nominee_name', $('#nominee_name').val());
                formData.append('nominee_relation', $('#nominee_relation').val());
                formData.append('phone', $('#phone').val());
                formData.append('email', $('#email').val());
                formData.append('gender', $('input[name="gender"]:checked').val());
                formData.append('bdate', $('#bdate').val());
                formData.append('country', $('#country').val());
                formData.append('mystate', $('#mystate').val());
                formData.append('city', $('#city').val());
                formData.append('zipcode', $('#zipcode').val());
                formData.append('address', $('#address').val());

                // Append files only if selected
                formData.append('pan_card', $('#img_path3').val());
                formData.append('voting_card', $('#img_path5').val());
                formData.append('profile_pic', $('#img_path1').val());
                formData.append('bank_passbook', $('#pimg_path3').val() || $('#img_path4').val());
                formData.append('aadhar_card', $('#aimg_path2').val());
                formData.append('id_proof', $('#pimg_path2').val());

                // AJAX call with multipart/form-data
                $.ajax({
                    url: 'updatedata/edit_profile_data.php',
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        if (response == '1') {
                            alert('Edit Successful');
                            location.reload();
                        } else {
                            alert('Edit Error!!');
                        }
                    },
                    error: function (xhr, status, error) {
                        alert('AJAX Error: ' + error);
                    }
                });
            });

            //handle file uploads

        </script>
        <!-- Sidebar Start -->
        <script>
            document.addEventListener("DOMContentLoaded", function () {

                const sidebar = document.querySelector(".navbar-menu");
                const hamburger = document.getElementById("topnav-hamburger-icon");
                const hamburgerIcon = document.querySelector(".hamburger-icon");
                const overlay = document.querySelector(".vertical-overlay");

                if (window.innerWidth > 1024) {
                    sidebar.classList.remove("sidebar-hidden");
                }

                hamburger.addEventListener("click", function () {

                    if (window.innerWidth <= 1024) {

                        /* BELOW 767 - YOUR ORIGINAL WORKING LOGIC */
                        if (window.innerWidth <= 767) {

                            sidebar.classList.toggle("sidebar-mobile-show");
                            hamburgerIcon.classList.toggle("open");

                            if (overlay) {
                                overlay.classList.toggle("active");
                            }
                        }

                        /* 768px TO 1024px */
                        else {

                            if (!sidebar.classList.contains("sidebar-mobile-show")) {

                                sidebar.classList.add("sidebar-mobile-show");

                                if (overlay) {
                                    overlay.classList.add("active");
                                }

                                /* SHOW 3 LINES */
                                hamburgerIcon.classList.add("open");

                            } else {

                                sidebar.classList.remove("sidebar-mobile-show");

                                if (overlay) {
                                    overlay.classList.remove("active");
                                }

                                /* SHOW ARROW */
                                hamburgerIcon.classList.remove("open");
                            }
                        }

                    } else {

                        /* DESKTOP */
                        sidebar.classList.toggle("sidebar-hidden");
                    }
                });

                if (overlay) {

                    overlay.addEventListener("click", function () {

                        sidebar.classList.remove("sidebar-mobile-show");
                        overlay.classList.remove("active");
                        hamburgerIcon.classList.remove("open");

                    });
                }

            });
        </script>
        <!-- Sidebar End -->
    </body>
</html>