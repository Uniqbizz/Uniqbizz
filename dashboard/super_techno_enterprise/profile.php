<?php
    include_once (__DIR__.'/../dashboard_user_details.php');

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
            
            // Common for userType 10, 11, and others
            $fname = $value['firstname'];
            $lname = $value['lastname'];
            $phone_no = $value['contact_no'];
            
            $country = $value['country'];
            $state = $value['state'];
            $city = $value['city'];
            $pincode = $value['pincode'];
            $email=$value['email']??'NA';
            $dob=$value['date_of_birth']??'NA';
            $gender=$value['gender']??'NA';
            $address =$value['address']??'NA';
            $applicationID=$value['application_id'];
            $register_date =$value['register_date'];
            $approved_by = "Admin";
            $approval_date ="";
            $updated_by ="";
            $remarks =$value['notes'];
            // Get names from IDs
            $countryname = getNameById($conn, 'countries', 'country_name', $country);
            $statename = getNameById($conn, 'states', 'state_name', $state);
            $cityname = getNameById($conn, 'cities', 'city_name', $city);

            //profs
            $stmtprof = $conn->prepare("SELECT * FROM professional_and_educational WHERE application_id = ?");
            $stmtprof->execute([$applicationID]);
            if ($stmtprof->rowCount() > 0) {
                $resultprof = $stmtprof->fetch(PDO::FETCH_ASSOC);
                $occupation = $resultprof['current_occupation'];
                $business_name="NA";
                $experience =$resultprof['current_experience'];
                $income=$resultprof['current_income'];
                $industry="NA";
                $leadership_exp="NA";
            }
            //nominiee details
            $stmtnom = $conn->prepare("SELECT * FROM nominee_details WHERE application_id = ?");
            $stmtnom->execute([$applicationID]);
            if ($stmtnom->rowCount() > 0) {
                $resultnom = $stmtnom->fetch(PDO::FETCH_ASSOC);
                $nominee_name = $resultnom['nominee_name'];
                $nominee_relation = $resultnom['nominee_relation'];
                $nominee_mobile = '+'.$resultnom['nominee_contact_cd'].$resultnom['nominee_contact_no'];
                $nominee_dob =$resultnom['nominee_date_of_birth'];
                $nominee_address = $resultnom['nominee_address'];
            }
            //bank details
            $stmtbank = $conn->prepare("SELECT * FROM bank_details WHERE application_id = ?");
            $stmtbank->execute([$applicationID]);
            if ($stmtbank->rowCount() > 0) {
                $resultbank = $stmtbank->fetch(PDO::FETCH_ASSOC);
                $account_holder = $resultbank['account_holder_name'];
                $bank_name = $resultbank['bank_name'];
                $account_no = $resultbank['account_number'];
                $ifsc_code =$resultbank['ifsc_code'];
                $branch_name = $resultbank['branch_name'];
                $upi_id = "NA";
            }
            //documents
            $stmtdoc = $conn->prepare("SELECT * FROM documents WHERE application_id = ?");
            $stmtdoc->execute([$applicationID]);
            if ($stmtdoc->rowCount() > 0) {
                $resultdoc = $stmtdoc->fetch(PDO::FETCH_ASSOC);
                $profile_pic = $resultdoc['profile_pic'];
                $aadhaar_card = $resultdoc['aadhar_card'];
                $pan_card = $resultdoc['pan_card'];
                $passbook =$resultdoc['cancelled_cheque_bank_passbook'];
                $resume = $resultdoc['resume_cv'];
                $address_proof = $resultdoc['address_proof'];
                $professional_profile = $resultdoc['professional_profile'];
                $business_profile = $resultdoc['business_profile'];
                $income_proof = $resultdoc['income_proof'];
                $payment_proof = $resultdoc['payment_proof'];
                $other_document = $resultdoc['other_document'];
            }
            $networking='NA';
            $public_speaking ="NA"; 
        }
    }
?>

<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable">

<head>

    <meta charset="utf-8" />
    <title>Dashboard | Uniqbizz</title>
    <!-- App favicon -->
    <link rel="shortcut icon" href="../assets/images/fav.png">

    <!-- jsvectormap css -->
    <link href="../assets/libs/jsvectormap/css/jsvectormap.min.css" rel="stylesheet" type="text/css" />

    <!--Swiper slider css-->
    <link href="../assets/libs/swiper/swiper-bundle.min.css" rel="stylesheet" type="text/css" />

    <!-- DataTables -->
    <link href="../assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <!-- Responsive datatable examples -->
    <link href="../assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />  

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
    <!-- font-awesome -->
    <link rel="stylesheet" href="../assets/fontawesome/css/all.min.css" />
    
    <!-- Customer Dashboard CSS -->
    <link rel="stylesheet" href="../assets/css/super_techno_enterprise.css" />
    <link rel="stylesheet" href="css/profile.css">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- add on 10-06-2026 by SV -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css">
    
    

</head>

<body>
    <!-- Begin page -->
    <div id="layout-wrapper">

        <?php 

            include_once 'super_techno_header.php'; 
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

        <?php 

                include_once 'super_techno_sidebar.php'; 
        ?>

        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">

            <div class="page-content">
                <div class="container-fluid ">
                    <form>
                        <div class="travel-hero">

                            <div class="travel-overlay"></div>

                            <div class="container-fluid position-relative h-100">

                                <div class="row align-items-center h-100">

                                    <div class="col-xl-8 col-lg-7">

                                        <div class="d-flex align-items-center gap-2 mb-3">

                                            <span class="elite-badge">
                                                <i class="fa-solid fa-crown"></i>
                                                Super Techno Enterprise
                                            </span>

                                            <span class="badge bg-success px-3 py-2">
                                                <i class="fa-solid fa-circle-check me-1"></i>
                                                Verified
                                            </span>

                                        </div>

                                        <h1 class="hero-name">
                                            <?php echo $fname.' '.$lname; ?>
                                        </h1>

                                        <p class="hero-tagline">
                                            Building Dreams • Exploring Destinations • Creating Leaders
                                        </p>

                                        <div class="row mt-4 g-3">

                                            <div class="col-md-4">
                                                <div class="hero-info text-light bolder">
                                                    <small>STE ID</small>
                                                    <h6 class="text-light"><?php echo $userId; ?></h6>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="hero-info text-light bolder">
                                                    <small>Application ID</small>
                                                    <h6 class="text-light"><?php echo $applicationID; ?></h6>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="hero-info text-light bolder">
                                                    <small>Email</small>
                                                    <h6 class="text-light"><?php echo $email; ?></h6>
                                                </div>
                                            </div>

                                        </div>

                                    </div>

                                    <div class="col-xl-4 col-lg-5 text-center">

                                        <div class="hero-image-wrapper">

                                            <img src="<?php echo $profile_pic; ?>"
                                                class="hero-avatar">

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                        <!-- Statistics -->

                        <div class="row g-4">

                            <!-- Personal Information -->

                            <div class="col-lg-6">

                                <div class="profile-card">

                                    <div class="card-header-custom">

                                        <h4>
                                            <i class="fa-solid fa-id-card"></i>
                                            Personal Information
                                        </h4>

                                    </div>

                                    <div class="card-body">

                                        <div class="row g-4">

                                            <div class="col-md-6">
                                                <label>First Name</label>
                                                <p><?php echo $fname; ?></p>
                                            </div>

                                            <div class="col-md-6">
                                                <label>Last Name</label>
                                                <p><?php echo $lname; ?></p>
                                            </div>

                                            <div class="col-md-6">
                                                <label>Date Of Birth</label>
                                                <p><?php echo $dob; ?></p>
                                            </div>

                                            <div class="col-md-6">
                                                <label>Gender</label>
                                                <p><?php echo $gender; ?></p>
                                            </div>

                                            <div class="col-md-6">
                                                <label>Email</label>
                                                <p><?php echo $email; ?></p>
                                            </div>

                                            <div class="col-md-6">
                                                <label>Mobile</label>
                                                <p><?php echo $phone_no; ?></p>
                                            </div>

                                        </div>

                                    </div>

                                </div>

                            </div>

                            <!-- Address -->

                            <div class="col-lg-6">

                                <div class="profile-card">

                                    <div class="card-header-custom">

                                        <h4>
                                            <i class="fa-solid fa-location-dot"></i>
                                            Residential Address
                                        </h4>

                                    </div>

                                    <div class="card-body">

                                        <div class="row g-4">

                                            <div class="col-12">
                                                <label>Address</label>
                                                <p><?php echo $address; ?></p>
                                            </div>

                                            <div class="col-md-6">
                                                <label>City</label>
                                                <p><?php echo $city; ?></p>
                                            </div>

                                            <div class="col-md-6">
                                                <label>State</label>
                                                <p><?php echo $state; ?></p>
                                            </div>

                                            <div class="col-md-6">
                                                <label>Country</label>
                                                <p><?php echo $country; ?></p>
                                            </div>

                                            <div class="col-md-6">
                                                <label>Pincode</label>
                                                <p><?php echo $pincode; ?></p>
                                            </div>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                        <div class="row g-4 mt-1">

                            <!-- Professional Details -->

                            <div class="col-xl-7">

                                <div class="profile-card h-100">

                                    <div class="card-header-custom">

                                        <h4>
                                            <i class="fa-solid fa-briefcase"></i>
                                            Professional Details
                                        </h4>

                                    </div>

                                    <div class="card-body">

                                        <div class="row g-4">

                                            <div class="col-md-6">

                                                <div class="detail-box">

                                                    <span class="detail-label">
                                                        Occupation
                                                    </span>

                                                    <h6>
                                                        <?php echo $occupation; ?>
                                                    </h6>

                                                </div>

                                            </div>

                                            <div class="col-md-6">

                                                <div class="detail-box">

                                                    <span class="detail-label">
                                                        Organization / Business
                                                    </span>

                                                    <h6>
                                                        <?php echo $business_name; ?>
                                                    </h6>

                                                </div>

                                            </div>

                                            <div class="col-md-6">

                                                <div class="detail-box">

                                                    <span class="detail-label">
                                                        Designation
                                                    </span>

                                                    <h6>
                                                        <?php echo $designation; ?>
                                                    </h6>

                                                </div>

                                            </div>

                                            <div class="col-md-6">

                                                <div class="detail-box">

                                                    <span class="detail-label">
                                                        Experience
                                                    </span>

                                                    <h6>
                                                        <?php echo $experience; ?> Years
                                                    </h6>

                                                </div>

                                            </div>

                                            <div class="col-md-6">

                                                <div class="detail-box">

                                                    <span class="detail-label">
                                                        Monthly Income
                                                    </span>

                                                    <h6>
                                                        ₹ <?php echo number_format($income); ?>
                                                    </h6>

                                                </div>

                                            </div>

                                            <div class="col-md-6">

                                                <div class="detail-box">

                                                    <span class="detail-label">
                                                        Industry
                                                    </span>

                                                    <h6>
                                                        <?php echo $industry; ?>
                                                    </h6>

                                                </div>

                                            </div>

                                            <div class="col-12">

                                                <div class="detail-box">

                                                    <span class="detail-label">
                                                        Professional Summary
                                                    </span>

                                                    <p class="mb-0">
                                                        <?php echo $professional_summary ??'NA'; ?>
                                                    </p>

                                                </div>

                                            </div>

                                        </div>

                                    </div>

                                </div>

                            </div>

                            <!-- Leadership Assessment -->

                            <div class="col-xl-5">

                                <div class="profile-card h-100">

                                    <div class="card-header-custom">

                                        <h4>
                                            <i class="fa-solid fa-trophy"></i>
                                            Leadership Assessment
                                        </h4>

                                    </div>

                                    <div class="card-body">

                                        <div class="row g-3">

                                            <div class="col-6">

                                                <div class="achievement-card">

                                                    <i class="fa-solid fa-users"></i>

                                                    <h3>
                                                        <?php echo $team_capacity??0; ?>
                                                    </h3>

                                                    <p>
                                                        Team Capacity
                                                    </p>

                                                </div>

                                            </div>

                                            <div class="col-6">

                                                <div class="achievement-card">

                                                    <i class="fa-solid fa-user-tie"></i>

                                                    <h3>
                                                        <?php echo $leadership_exp; ?>
                                                    </h3>

                                                    <p>
                                                        Leadership
                                                    </p>

                                                </div>

                                            </div>

                                            <div class="col-6">

                                                <div class="achievement-card">

                                                    <i class="fa-solid fa-bullhorn"></i>

                                                    <h3>
                                                        <?php echo $public_speaking; ?>
                                                    </h3>

                                                    <p>
                                                        Public Speaking
                                                    </p>

                                                </div>

                                            </div>

                                            <div class="col-6">

                                                <div class="achievement-card">

                                                    <i class="fa-solid fa-handshake"></i>

                                                    <h3>
                                                        <?php echo $networking; ?>
                                                    </h3>

                                                    <p>
                                                        Networking
                                                    </p>

                                                </div>

                                            </div>

                                        </div>

                                        <hr>

                                        <div class="leadership-score">

                                            <div class="d-flex justify-content-between mb-2">
                                                <span>Leadership Index</span>
                                                <strong>85%</strong>
                                            </div>

                                            <div class="progress leadership-progress">

                                                <div class="progress-bar"
                                                    style="width:85%">
                                                </div>

                                            </div>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>
                        <div class="row g-4 mt-1">

                            <!-- Nominee Details -->

                            <div class="col-xl-6">

                                <div class="profile-card h-100">

                                    <div class="card-header-custom">

                                        <h4>
                                            <i class="fa-solid fa-user-group"></i>
                                            Nominee Details
                                        </h4>

                                    </div>

                                    <div class="card-body">

                                        <div class="row g-4">

                                            <div class="col-md-6">

                                                <div class="detail-box">

                                                    <span class="detail-label">
                                                        Nominee Name
                                                    </span>

                                                    <h6>
                                                        <?php echo $nominee_name; ?>
                                                    </h6>

                                                </div>

                                            </div>

                                            <div class="col-md-6">

                                                <div class="detail-box">

                                                    <span class="detail-label">
                                                        Relationship
                                                    </span>

                                                    <h6>
                                                        <?php echo $nominee_relation; ?>
                                                    </h6>

                                                </div>

                                            </div>

                                            <div class="col-md-6">

                                                <div class="detail-box">

                                                    <span class="detail-label">
                                                        Mobile Number
                                                    </span>

                                                    <h6>
                                                        <?php echo $nominee_mobile; ?>
                                                    </h6>

                                                </div>

                                            </div>

                                            <div class="col-md-6">

                                                <div class="detail-box">

                                                    <span class="detail-label">
                                                        Date Of Birth
                                                    </span>

                                                    <h6>
                                                        <?php echo $nominee_dob; ?>
                                                    </h6>

                                                </div>

                                            </div>

                                            <div class="col-12">

                                                <div class="detail-box">

                                                    <span class="detail-label">
                                                        Address
                                                    </span>

                                                    <p class="mb-0">
                                                        <?php echo $nominee_address; ?>
                                                    </p>

                                                </div>

                                            </div>

                                        </div>

                                    </div>

                                </div>

                            </div>

                            <!-- Bank Details -->

                            <div class="col-xl-6">

                                <div class="profile-card h-100">

                                    <div class="card-header-custom">

                                        <h4>
                                            <i class="fa-solid fa-building-columns"></i>
                                            Banking Information
                                        </h4>

                                    </div>

                                    <div class="card-body">

                                        <div class="row g-4">

                                            <div class="col-md-6">

                                                <div class="detail-box">

                                                    <span class="detail-label">
                                                        Account Holder
                                                    </span>

                                                    <h6>
                                                        <?php echo $account_holder; ?>
                                                    </h6>

                                                </div>

                                            </div>

                                            <div class="col-md-6">

                                                <div class="detail-box">

                                                    <span class="detail-label">
                                                        Bank Name
                                                    </span>

                                                    <h6>
                                                        <?php echo $bank_name; ?>
                                                    </h6>

                                                </div>

                                            </div>

                                            <div class="col-md-6">

                                                <div class="detail-box">

                                                    <span class="detail-label">
                                                        Account Number
                                                    </span>

                                                    <h6>
                                                        <?php echo $account_no; ?>
                                                    </h6>

                                                </div>

                                            </div>

                                            <div class="col-md-6">

                                                <div class="detail-box">

                                                    <span class="detail-label">
                                                        IFSC Code
                                                    </span>

                                                    <h6>
                                                        <?php echo $ifsc_code; ?>
                                                    </h6>

                                                </div>

                                            </div>

                                            <div class="col-md-6">

                                                <div class="detail-box">

                                                    <span class="detail-label">
                                                        Branch
                                                    </span>

                                                    <h6>
                                                        <?php echo $branch_name; ?>
                                                    </h6>

                                                </div>

                                            </div>

                                            <div class="col-md-6">

                                                <div class="detail-box">

                                                    <span class="detail-label">
                                                        UPI ID
                                                    </span>

                                                    <h6>
                                                        <?php echo $upi_id; ?>
                                                    </h6>

                                                </div>

                                            </div>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>
                        <div class="profile-card mt-4">

                            <div class="card-header-custom">

                                <h4>
                                    <i class="fa-solid fa-folder-open"></i>
                                    Documents Gallery
                                </h4>

                            </div>

                            <div class="card-body">

                                <div class="row g-4">

                                    <!-- Profile Photo -->

                                    <div class="col-xl-4 col-md-6">

                                        <div class="document-card">

                                            <div class="verified-ribbon">
                                                Verified
                                            </div>

                                            <img src="<?php echo '../../uploading/'.$profile_pic; ?>"
                                                class="document-image">

                                            <div class="document-footer">

                                                <h6>Profile Photo</h6>

                                                <div class="document-actions">

                                                    <a href="<?php echo '../../uploading/'.$profile_pic; ?>"
                                                        target="_blank"
                                                        class="btn btn-view">

                                                        <i class="fa-solid fa-eye"></i>

                                                    </a>

                                                    <a href="<?php echo '../../uploading/'.$profile_pic; ?>"
                                                        download
                                                        class="btn btn-download">

                                                        <i class="fa-solid fa-download"></i>

                                                    </a>

                                                </div>

                                            </div>

                                        </div>

                                    </div>

                                    <!-- Aadhaar -->

                                    <div class="col-xl-4 col-md-6">

                                        <div class="document-card">

                                            <div class="verified-ribbon">
                                                Verified
                                            </div>

                                            <img src="<?php echo '../../uploading/'.$aadhaar_card; ?>"
                                                class="document-image">

                                            <div class="document-footer">

                                                <h6>Aadhaar Card</h6>

                                                <div class="document-actions">

                                                    <a href="<?php echo '../../uploading/'.$aadhaar_card; ?>"
                                                        target="_blank"
                                                        class="btn btn-view">

                                                        <i class="fa-solid fa-eye"></i>

                                                    </a>

                                                    <a href="<?php echo '../../uploading/'.$aadhaar_card; ?>"
                                                        download
                                                        class="btn btn-download">

                                                        <i class="fa-solid fa-download"></i>

                                                    </a>

                                                </div>

                                            </div>

                                        </div>

                                    </div>

                                    <!-- PAN -->

                                    <div class="col-xl-4 col-md-6">

                                        <div class="document-card">

                                            <div class="verified-ribbon">
                                                Verified
                                            </div>

                                            <img src="<?php echo '../../uploading/'.$pan_card; ?>"
                                                class="document-image">

                                            <div class="document-footer">

                                                <h6>PAN Card</h6>

                                                <div class="document-actions">

                                                    <a href="<?php echo '../../uploading/'.$pan_card; ?>"
                                                        target="_blank"
                                                        class="btn btn-view">

                                                        <i class="fa-solid fa-eye"></i>

                                                    </a>

                                                    <a href="<?php echo '../../uploading/'.$pan_card; ?>"
                                                        download
                                                        class="btn btn-download">

                                                        <i class="fa-solid fa-download"></i>

                                                    </a>

                                                </div>

                                            </div>

                                        </div>

                                    </div>

                                    <!-- Passbook -->

                                    <div class="col-xl-4 col-md-6">

                                        <div class="document-card">

                                            <div class="pdf-preview">

                                                <i class="fa-solid fa-file-pdf"></i>

                                            </div>

                                            <div class="document-footer">

                                                <h6>Bank Passbook</h6>

                                                <div class="document-actions">

                                                    <a href="<?php echo '../../uploading/'.$passbook; ?>"
                                                        target="_blank"
                                                        class="btn btn-view">

                                                        <i class="fa-solid fa-eye"></i>

                                                    </a>

                                                    <a href="<?php echo '../../uploading/'.$passbook; ?>"
                                                        download
                                                        class="btn btn-download">

                                                        <i class="fa-solid fa-download"></i>

                                                    </a>

                                                </div>

                                            </div>

                                        </div>

                                    </div>

                                    <!-- Voting Card -->

                                    <div class="col-xl-4 col-md-6">

                                        <div class="document-card">

                                            <img src="<?php echo '../../uploading/'.$resume; ?>"
                                                class="document-image">

                                            <div class="document-footer">

                                                <h6>Voting Card</h6>

                                                <div class="document-actions">

                                                    <a href="<?php echo '../../uploading/'.$resume; ?>"
                                                        target="_blank"
                                                        class="btn btn-view">

                                                        <i class="fa-solid fa-eye"></i>

                                                    </a>

                                                    <a href="<?php echo '../../uploading/'.$resume; ?>"
                                                        download
                                                        class="btn btn-download">

                                                        <i class="fa-solid fa-download"></i>

                                                    </a>

                                                </div>

                                            </div>

                                        </div>

                                    </div>

                                    <!-- Payment Proof -->

                                    <div class="col-xl-4 col-md-6">

                                        <div class="document-card">

                                            <img src="<?php echo '../../uploading/'.$payment_proof; ?>"
                                                class="document-image">

                                            <div class="document-footer">

                                                <h6>Payment Proof</h6>

                                                <div class="document-actions">

                                                    <a href="<?php echo '../../uploading/'.$payment_proof; ?>"
                                                        target="_blank"
                                                        class="btn btn-view">

                                                        <i class="fa-solid fa-eye"></i>

                                                    </a>

                                                    <a href="<?php echo '../../uploading/'.$payment_proof; ?>"
                                                        download
                                                        class="btn btn-download">

                                                        <i class="fa-solid fa-download"></i>

                                                    </a>

                                                </div>

                                            </div>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>
                        <div class="row g-4 mt-2">

                            <!-- Verification Center -->

                            <div class="col-xl-5">

                                <div class="profile-card h-100">

                                    <div class="card-header-custom">

                                        <h4>
                                            <i class="fa-solid fa-shield-check"></i>
                                            Verification Center
                                        </h4>

                                    </div>

                                    <div class="card-body">

                                        <div class="verification-list">

                                            <div class="verification-item success">

                                                <div class="verification-icon">
                                                    <i class="fa-solid fa-user"></i>
                                                </div>

                                                <div class="verification-content">
                                                    <h6>Profile Photo</h6>
                                                    <small>Verified Successfully</small>
                                                </div>

                                                <span class="status-badge verified">
                                                    Verified
                                                </span>

                                            </div>

                                            <div class="verification-item success">

                                                <div class="verification-icon">
                                                    <i class="fa-regular fa-id-card"></i>
                                                </div>

                                                <div class="verification-content">
                                                    <h6>Aadhaar Card</h6>
                                                    <small>Verified Successfully</small>
                                                </div>

                                                <span class="status-badge verified">
                                                    Verified
                                                </span>

                                            </div>

                                            <div class="verification-item success">

                                                <div class="verification-icon">
                                                    <i class="fa-regular fa-credit-card"></i>
                                                </div>

                                                <div class="verification-content">
                                                    <h6>PAN Card</h6>
                                                    <small>Verified Successfully</small>
                                                </div>

                                                <span class="status-badge verified">
                                                    Verified
                                                </span>

                                            </div>

                                            <div class="verification-item pending">

                                                <div class="verification-icon">
                                                    <i class="fa-solid fa-building-columns"></i>
                                                </div>

                                                <div class="verification-content">
                                                    <h6>Bank Verification</h6>
                                                    <small>Pending Review</small>
                                                </div>

                                                <span class="status-badge pending">
                                                    Pending
                                                </span>

                                            </div>

                                            <div class="verification-item success">

                                                <div class="verification-icon">
                                                    <i class="fa-solid fa-file-invoice"></i>
                                                </div>

                                                <div class="verification-content">
                                                    <h6>Payment Proof</h6>
                                                    <small>Verified Successfully</small>
                                                </div>

                                                <span class="status-badge verified">
                                                    Verified
                                                </span>

                                            </div>

                                        </div>

                                    </div>

                                </div>

                            </div>

                            <!-- Timeline -->

                            <div class="col-xl-7">

                                <div class="profile-card h-100">

                                    <div class="card-header-custom">

                                        <h4>
                                            <i class="fa-solid fa-clock-rotate-left"></i>
                                            Registration Timeline
                                        </h4>

                                    </div>

                                    <div class="card-body">

                                        <div class="timeline">

                                            <div class="timeline-item">

                                                <div class="timeline-dot bg-success"></div>

                                                <div class="timeline-content">

                                                    <h6>
                                                        Application Generated
                                                    </h6>

                                                    <p>
                                                        STE Registration Application Created
                                                    </p>

                                                    <small>
                                                        10 Jan 2026 - 09:15 AM
                                                    </small>

                                                </div>

                                            </div>

                                            <div class="timeline-item">

                                                <div class="timeline-dot bg-primary"></div>

                                                <div class="timeline-content">

                                                    <h6>
                                                        Draft Saved
                                                    </h6>

                                                    <p>
                                                        Personal Information Submitted
                                                    </p>

                                                    <small>
                                                        10 Jan 2026 - 10:20 AM
                                                    </small>

                                                </div>

                                            </div>

                                            <div class="timeline-item">

                                                <div class="timeline-dot bg-info"></div>

                                                <div class="timeline-content">

                                                    <h6>
                                                        Documents Uploaded
                                                    </h6>

                                                    <p>
                                                        All Required Documents Submitted
                                                    </p>

                                                    <small>
                                                        10 Jan 2026 - 11:40 AM
                                                    </small>

                                                </div>

                                            </div>

                                            <div class="timeline-item">

                                                <div class="timeline-dot bg-warning"></div>

                                                <div class="timeline-content">

                                                    <h6>
                                                        Verification Started
                                                    </h6>

                                                    <p>
                                                        Admin Review Initiated
                                                    </p>

                                                    <small>
                                                        11 Jan 2026 - 08:30 AM
                                                    </small>

                                                </div>

                                            </div>

                                            <div class="timeline-item">

                                                <div class="timeline-dot bg-success"></div>

                                                <div class="timeline-content">

                                                    <h6>
                                                        Registration Approved
                                                    </h6>

                                                    <p>
                                                        Approved By Administrator
                                                    </p>

                                                    <small>
                                                        11 Jan 2026 - 12:15 PM
                                                    </small>

                                                </div>

                                            </div>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>
                        <div class="profile-card mt-4">

                            <div class="card-header-custom">

                                <h4>
                                    <i class="fa-solid fa-user-shield"></i>
                                    Administrative Information
                                </h4>

                            </div>

                            <div class="card-body">

                                <div class="row g-4">

                                    <div class="col-lg-3 col-md-6">

                                        <div class="detail-box">

                                            <span class="detail-label">
                                                Registration Date
                                            </span>

                                            <h6>
                                                <?php echo $register_date; ?>
                                            </h6>

                                        </div>

                                    </div>

                                    <div class="col-lg-3 col-md-6">

                                        <div class="detail-box">

                                            <span class="detail-label">
                                                Approved By
                                            </span>

                                            <h6>
                                                <?php echo $approved_by; ?>
                                            </h6>

                                        </div>

                                    </div>

                                    <div class="col-lg-3 col-md-6">

                                        <div class="detail-box">

                                            <span class="detail-label">
                                                Approval Date
                                            </span>

                                            <h6>
                                                <?php echo $approval_date; ?>
                                            </h6>

                                        </div>

                                    </div>

                                    <div class="col-lg-3 col-md-6">

                                        <div class="detail-box">

                                            <span class="detail-label">
                                                Last Updated By
                                            </span>

                                            <h6>
                                                <?php echo $updated_by; ?>
                                            </h6>

                                        </div>

                                    </div>

                                    <div class="col-12">

                                        <div class="detail-box">

                                            <span class="detail-label">
                                                Remarks
                                            </span>

                                            <p class="mb-0">
                                                <?php echo $remarks; ?>
                                            </p>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>
                        <!--end row-->
                    </form>

                </div>
                <!-- container-fluid -->
            </div><!-- End Page-content -->

            <?php 
                include_once "super_techno_footer.php"; 
            ?>
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
    <script src="../assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/libs/simplebar/simplebar.min.js"></script>
    <script src="../assets/libs/node-waves/waves.min.js"></script>
    <script src="../assets/libs/feather-icons/feather.min.js"></script>
    <script src="../assets/js/jquery/jquery-3.7.1.min.js"></script>

    <!-- Required datatable js -->
    <script src="../assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="../assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
    
    <!-- Responsive examples -->
    <script src="../assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="../assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>
    <!-- !-- materialdesign icon js- -->
    <script src="../assets/js/pages/remix-icons-listing.js"></script>
    

    <!-- App js -->
    <script src="../assets/js/app.js"></script>
    <!-- add on 10-06-2026 by SV -->
    <script src="https://cdn.jsdelivr.net/npm/moment/min/moment.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
        <!-- add on 10-06-2026 by SV END-->

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
                url: '../updatedata/edit_profile_data.php',
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
    <script>
        // Toggle password visibility (default: visible, type="text")
        function togglePassword(fieldId, btn) {
            const input = document.getElementById(fieldId);
            const icon = btn.querySelector('i');
            const isVisible = input.type === "text";

            input.type = isVisible ? "password" : "text";
            icon.classList.toggle('fa-eye', isVisible);
            icon.classList.toggle('fa-eye-slash', !isVisible);
            btn.title = isVisible ? "Show Password" : "Hide Password";
        }

        // Password validation
        function validatePasswordDetails(password) {
            return {
                lengthCheck: password.length >= 8,
                letterCheck: /[A-Za-z]/.test(password),
                numberCheck: /\d/.test(password),
                symbolCheck: /[^A-Za-z0-9]/.test(password),
            };
        }

        function updatePasswordFeedback(checks) {
            updateFeedbackItem('lengthCheck', checks.lengthCheck, 'At least 8 characters');
            updateFeedbackItem('letterCheck', checks.letterCheck, 'At least one letter (a-z, A-Z)');
            updateFeedbackItem('numberCheck', checks.numberCheck, 'At least one number (0–9)');
            updateFeedbackItem('symbolCheck', checks.symbolCheck, 'At least one symbol (!@#$%^&*)');
        }

        function updateFeedbackItem(id, passed, message) {
            const el = document.getElementById(id);
            el.innerHTML = passed
                ? '✔️ <span style="color:green;">' + message + '</span>'
                : '❌ <span style="color:red;">' + message + '</span>';
        }

        document.getElementById('newPassword').addEventListener('input', function () {
            const password = this.value;
            const checks = validatePasswordDetails(password);
            updatePasswordFeedback(checks);
        });

        $('#edit_password').on('click', function (event) {
            event.preventDefault();

            const currentPassword = $('#currentPassword').val().trim();
            const newPassword = $('#newPassword').val().trim();
            const confirmPassword = $('#confirmPassword').val().trim();
            const user_type = $('#user_type').val().trim();
            const user_id = $('#user_id').val().trim();

            const checks = validatePasswordDetails(newPassword);
            const allPassed = Object.values(checks).every(Boolean);

            if (!allPassed) {
                alert(' Password must be at least 8 characters long and include a letter, a number, and a symbol.');
                return;
            }

            if (newPassword !== confirmPassword) {
                alert(' New Password and Confirm Password do not match.');
                return;
            }

            const formData = new FormData();
            formData.append('currentPassword', currentPassword);
            formData.append('newPassword', newPassword);
            formData.append('confirmPassword', confirmPassword);
            formData.append('user_type', user_type);
            formData.append('user_id', user_id);

            $.ajax({
                url: '../updatedata/reset_password_data.php',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    switch (response.trim()) {
                        case 'success':
                            alert(' Password changed successfully.');
                            location.reload();
                            break;
                        case 'mismatch':
                            alert(' Current Password is incorrect.');
                            break;
                        case 'invalid':
                            alert(' Password validation failed on server.');
                            break;
                        default:
                            alert(' Unknown error occurred. Please try again.');
                            break;
                    }
                },
                error: function (xhr, status, error) {
                    alert(' AJAX Error: ' + error);
                }
            });
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