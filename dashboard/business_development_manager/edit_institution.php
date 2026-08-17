<?php
    include_once(__DIR__ . '/../dashboard_user_details.php');
    //current full date
    $today = date('Y-m-d');

    //current year
    $date = date('Y'); 

    // Calculate 20 years before the current date
    $dateTwentyYearsAgo = strtotime("-20 years");

    // Format the result as a human-readable date
    $ageLimit = date("Y-m-d", $dateTwentyYearsAgo);  // Outputs the date 20 years before today

    $id = $_POST['id']; //institution ID
    $status = $_POST['status']; //registered by 1 = admin, 34 = ETE, 26 = BM, 28 = MF, 30 = SF
    $edittype = $_POST['edittype']; //edit type

    $stmt = $conn->prepare("SELECT * FROM `institution` where institution_id='" . $id . "' OR id = '" . $id . "'");
    $stmt->execute();
    // set the resulting array to associative
    $stmt->setFetchMode(PDO::FETCH_ASSOC);

    if ($stmt->rowCount() > 0) {
        foreach (($stmt->fetchAll()) as $key => $row) {
            $fid = $row['id'];
            $name = $row['name'];
            $no_of_branches = $row['no_of_branches'];
            $types_of_institution = $row['types_of_institution'];
            $incorporation_date = $row['incorporation_date'];
            $institution_pan=$row['institution_pan'];
            $email = $row['email'];
            $contact_no = $row['contact_no'];
            $country_id = $row['country'];
            $state_id = $row['state'];
            $city_id = $row['city'];
            $pincode = $row['pincode'];
            $address = $row['address'];
            $account_name = $row['account_name'];
            $account_number = $row['account_number'];
            $ifsc_code = $row['ifsc_code'];
            $bank_and_branch_name = $row['bank_and_branch_name'];
            $amount = $row['amount'];
            $comm_per=$row['current_commission_per']??null;
            $ins_per=$row['current_incentive_per']??null;
            $payment_mode = $row['payment_mode'];
            $cheque_no = $row['cheque_no'];
            $cheque_date = $row['cheque_date'];
            $bank_name = $row['bank_name'];
            $transaction_no = $row['transaction_no'];
            $certificate_of_incorporation = $row['certificate_of_incorporation'];
            $gstin = $row['gstin'];
            $pan_card = $row['pan_card'];
            $address_proof = $row['address_proof'];
            $board_resolution = $row['board_resolution'];
            $bank_passbook = $row['bank_passbook'];
            $payment_proof = $row['payment_proof'];
            $reference_no = $row['reference_no'];
            $status=$row['status'];
            $f_status=$row['status'];

            if($f_status == '1'){
                // franchisee upgrade
                $f_upgrade = $conn->prepare("
                    SELECT upgrade_amt, new_commission_per, new_incentive_per 
                    FROM institution_upgrade 
                    WHERE institution_id = :id AND upgrade_status = '1' 
                    ORDER BY id DESC 
                    LIMIT 1
                ");
                $f_upgrade->execute([':id' => $id]);
                $f_upgrade->setFetchMode(PDO::FETCH_ASSOC);

                if ($f_upgrade->rowCount() > 0) {
                    $upgrade_f = $f_upgrade->fetch();

                    $amount   = $upgrade_f['upgrade_amt'];
                    $comm_per = $upgrade_f['new_commission_per'];
                    $ins_per  = $upgrade_f['new_incentive_per'];
                }
            }

            //get country
            $countries = $conn->prepare("SELECT country_name FROM countries where id='" . $country_id . "' and status='1' ");
            $countries->execute();
            $countries->setFetchMode(PDO::FETCH_ASSOC);
            if ($countries->rowCount() > 0) {
                $country = $countries->fetch();
                $countryname = $country['country_name'];
            }

            //get state
            $states = $conn->prepare("SELECT state_name FROM states where id='" . $state_id . "' and status='1' ");
            $states->execute();
            $states->setFetchMode(PDO::FETCH_ASSOC);
            if ($states->rowCount() > 0) {
                $state = $states->fetch();
                $statename = $state['state_name'];
            }
            //get city
            $cities = $conn->prepare("SELECT city_name FROM cities where id='" . $city_id . "' and status='1' ");
            $cities->execute();
            $cities->setFetchMode(PDO::FETCH_ASSOC);
            if ($cities->rowCount() > 0) {
                $city = $cities->fetch();
                $city_name = $city['city_name'];
            }

            $reference_id = substr($reference_no, 0, 2);
            if ($reference_id == "MF") {
                // business Mentor name
                $business_mentors = $conn->prepare("SELECT firstname, lastname, reference_no FROM master_franchisee where master_franchisee_id='" . $reference_no . "'");
                $business_mentors->execute();
                //print_r($business_mentors);
                $business_mentors->setFetchMode(PDO::FETCH_ASSOC);
                if ($business_mentors->rowCount() > 0) {
                    $business_mentor = $business_mentors->fetch();
                    $reference_no_fname = $business_mentor['firstname'];
                    $reference_no_lname = $business_mentor['lastname'];
                    // $business_trainees_reference_no = $business_trainee['reference_no'];
                }
            } else if ($reference_id == "SF") {
                // business development manger name
                $business_development_manager = $conn->prepare("SELECT firstname, lastname FROM sponsor_franchisee where sponsor_franchisee_id='" . $reference_no . "'");
                $business_development_manager->execute();
                $business_development_manager->setFetchMode(PDO::FETCH_ASSOC);
                if ($business_development_manager->rowCount() > 0) {
                    $business_development_manager = $business_development_manager->fetch();
                    $reference_no_fname = $business_development_manager['firstname'];
                    $reference_no_lname = $business_development_manager['lastname'];
                    // $business_trainees_reference_no = $business_trainee['reference_no'];
                }
            } 
            // else if ($reference_id == "BH") {
            //     // business development manger name
            //     $business_development_manager = $conn->prepare("SELECT name, employee_id FROM employees where employee_id='" . $reference_no . "'");
            //     $business_development_manager->execute();
            //     $business_development_manager->setFetchMode(PDO::FETCH_ASSOC);
            //     if ($business_development_manager->rowCount() > 0) {
            //         $business_development_manager = $business_development_manager->fetch();
            //         $reference_no_name = $business_development_manager['name'];
            //         // $business_trainees_reference_no = $business_trainee['reference_no'];
            //     }
            // }
             else if ($reference_id == "BM") {
                // business development manger name
                $business_development_manager = $conn->prepare("SELECT firstname, lastname FROM business_mentor where business_mentor_id='" . $reference_no . "'");
                $business_development_manager->execute();
                $business_development_manager->setFetchMode(PDO::FETCH_ASSOC);
                if ($business_development_manager->rowCount() > 0) {
                    $business_development_manager = $business_development_manager->fetch();
                    $reference_no_fname = $business_development_manager['firstname'];
                    $reference_no_lname = $business_development_manager['lastname'];
                    // $business_trainees_reference_no = $business_trainee['reference_no'];
                }
            }
            else if ($reference_id == "ET") {
                // business development manger name
                $business_development_manager = $conn->prepare("SELECT firstname, lastname FROM executive_techno_enterprise where executive_techno_enterprise_id='" . $reference_no . "'");
                $business_development_manager->execute();
                $business_development_manager->setFetchMode(PDO::FETCH_ASSOC);
                if ($business_development_manager->rowCount() > 0) {
                    $business_development_manager = $business_development_manager->fetch();
                    $reference_no_fname = $business_development_manager['firstname'];
                    $reference_no_lname = $business_development_manager['lastname'];
                    // $business_trainees_reference_no = $business_trainee['reference_no'];
                }
            }
        }
    }
?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Edit Institution | Admin Dashboard </title>
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
        <!-- custom Css-->
        <link href="../assets/css/custom.min.css" rel="stylesheet" type="text/css" />
        <!-- custom Css developer-->
        <link rel="stylesheet" href="../assets/css/custom.css" />
        <!-- Form CSS -->
        <link href="../assets/css/form.css" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" href="../assets/css/business_development_manager.css" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
        <link rel="stylesheet" href="../assets/css/validation.css" />
    </head>
    <body data-sidebar="dark">
        <div id="testemails"></div>
        <!-- <body data-layout="horizontal" data-topbar="dark"> -->
        <!-- Begin page -->
        <div id="layout-wrapper">
            <?php 
                // top header logo, hamberger menu, fullscreen icon, profile
                include_once 'business_development_manager_header.php';
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
            <?php
                // sidebar navigation menu 
                include_once 'business_development_manager_sidebar.php'; 
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
                                    <h4 class="mb-sm-0">Edit Institution </h4>
                                </div>
                            </div>
                        </div>
                        <!-- end page title -->
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card rounded-4 addTECard">
                                    <div class="d-flex gap-3">
                                        <div class="addTEIconBackground">
                                            <i class="fa-solid fa-user-group addTEIcon"></i>
                                        </div>
                                        <div class="align-content-center">
                                            <h1 class="fw-bolder text-white">Edit Institution </h1>
                                            <p class="fs-5 text-white mb-0">Edit the details below of register Institution under your network.</p>
                                        </div>
                                    </div>
                                    <img src="../assets/images/addTechnoFileImage.png" alt="" class="addTEImage">
                                </div>
                            </div>
                        </div>
                        <!-- Card Section 1 -->
                        <div class="card rounded-4 p-3 border-1">
                            <div class="row">
                                <div class="d-flex gap-2">
                                    <p class="fw-bolder addTENum">01</p>
                                    <h4 class="fw-bolder text-dark align-content-center">Personal Information</h4>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6">
                                    <div class="input-block mb-3">
                                        <label class="col-form-label" for="name">Institution Name<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="name" placeholder="Enter your name" value="<?= $name; ?>">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6">
                                    <div class="input-block mb-3">
                                        <label class="col-form-label" for="numberBranch">No of Branches<span class="text-danger">*</span></label>
                                        <input type="number" class="form-control" id="numberBranch" placeholder="Enter No of Branches" value="<?= $no_of_branches; ?>">
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <div class="form-group mb-3">
                                        <label class="col-form-label d-block">Types of Institution<span class="text-danger">*</span></label>
                                        <div class="form-control">
                                            <div class="row">
                                                <div class="col-lg-4 col-4 col-sm-6 col-12">
                                                    <label class="radio-inline mb-0 ms-3" for="test3"><input type="radio" id="test3" class="form-check-input instituteType me-3" name="instituteType" value="bank" <?= ($types_of_institution == "bank") ? 'checked disabled' : ''; ?> >Bank</label>
                                                </div>
                                                <div class="col-lg-4 col-4 col-sm-6 col-12">
                                                    <label class="radio-inline mb-0 ms-3" for="test4"><input type="radio" id="test4" class="form-check-input instituteType me-3" name="instituteType" value="nbfc" <?= ($types_of_institution == "nbfc") ? 'checked disabled' : ''; ?> >NBFC</label>
                                                </div>
                                                <div class="col-lg-4 col-4 col-sm-6 col-12">
                                                    <label class="radio-inline mb-0 ms-3" for="test5"><input type="radio" id="test5" class="form-check-input instituteType me-3" name="instituteType" value="corperative_bank" <?= ($types_of_institution == "corperative_bank") ? 'checked disabled' : ''; ?> >Corperative Bank</label>
                                                </div>
                                                <div class="col-lg-4 col-4 col-sm-6 col-12">
                                                    <label class="radio-inline mb-0 ms-3" for="test6"><input type="radio" id="test6" class="form-check-input instituteType me-3" name="instituteType" value="society" <?= ($types_of_institution == "society") ? 'checked disabled' : ''; ?> >Society</label>
                                                </div>
                                                <div class="col-lg-4 col-4 col-sm-6 col-12">
                                                    <label class="radio-inline mb-0 ms-3" for="test7"><input type="radio" id="test7" class="form-check-input instituteType me-3" name="instituteType" value="trust" <?= ($types_of_institution == "trust") ? 'checked disabled' : ''; ?> >Trust</label>
                                                </div>
                                                <div class="col-lg-4 col-4 col-sm-6 col-12">
                                                    <label class="radio-inline mb-0 ms-3" for="test8"><input type="radio" id="test8" class="form-check-input instituteType me-3" name="instituteType" value="other" <?= (!empty($types_of_institution) && !in_array(strtolower($types_of_institution), ['bank', 'nbfc', 'corperative_bank', 'society', 'trust'])) ? 'checked disabled' : ''; ?> >Others</label>
                                                </div>
                                            </div>
                                            <input type="text" name="instituteTypeOther" id="instituteTypeOther" class="form-control mt-2" value="<?= $types_of_institution ?>" <?= (!empty($types_of_institution) && !in_array(strtolower($types_of_institution), ['bank', 'nbfc', 'corperative_bank', 'society', 'trust'])) ? 'style="display:block;"' : 'style="display:none;"' ; ?> readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6">
                                    <div class="input-block mb-3">
                                        <label class="col-form-label" for="incorporationDate">Incorporation Date<span class="text-danger">*</span></label>
                                        <input type="date"
                                            class="form-control"
                                            id="incorporationDate"
                                            placeholder="Enter Incorporation Date"
                                            value="<?= (!empty($incorporation_date) && $incorporation_date != '0000-00-00') ? htmlspecialchars($incorporation_date) : '' ?>">
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
                                                <select class="form-control" id="country_cd">
                                                    <?php
                                                        if ($stmt->rowCount() > 0) {
                                                            foreach ($stmt->fetchAll() as $row) {

                                                                $countryCode = $row['country_code'] ?? '';
                                                                $sortName    = $row['sortname'] ?? 'N/A';

                                                                echo '<option value="' . htmlspecialchars($countryCode) . '">'
                                                                    . ($countryCode !== '' ? '+' . htmlspecialchars($countryCode) : 'N/A')
                                                                    . ' (' . htmlspecialchars($sortName) . ')</option>';
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
                                                <label class="col-form-label" for="phone">Phone Number<span class="text-danger">*</span></label>
                                                <input type="number" class="form-control" id="phone" placeholder="Enter your Phone Number" value="<?= $contact_no; ?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6">
                                    <div class="input-block mb-3">
                                        <label class="col-form-label" for="institutionPAN">Institution PAN<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="institutionPAN" placeholder="Enter Institution PAN" value="<?= $institution_pan; ?>">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6">
                                    <div class="input-block mb-3">
                                        <label class="col-form-label" for="email">Email Address<span class="text-danger">*</span></label>
                                        <input type="email" class="form-control" id="email" placeholder="Enter Email Address" value="<?= $email; ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Card Section 2 -->
                        <div class="card rounded-4 p-3 border-1">
                            <div class="row">
                                <div class="d-flex gap-2">
                                    <p class="fw-bolder addTENum">02</p>
                                    <h4 class="fw-bolder text-dark align-content-center">Registered Office Address:</h4>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6">
                                    <div class="input-block mb-3">
                                        
                                        <?php
                                            $stmt = $conn->prepare("SELECT * FROM countries WHERE status = 1 ORDER BY country_name ASC");
                                            $stmt->execute();                                         
                                            $stmt->setFetchMode(PDO::FETCH_ASSOC);
                                        ?>
                                        <label for="country" class="form-label fw-bold">Country <span class="text-danger fw-bolder">*</span></label>
                                        <select class="form-select" id="country" aria-label="Floating label select example" required>
                                            <option value="" selected >Select country </option>
                                            <?php 
                                                if($stmt->rowCount()>0){
                                                    foreach (($stmt->fetchAll()) as $key => $row) {  
                                                        echo '<option value="'.$row['id'].'">'.$row['country_name'].'</option>'; 
                                                    } 
                                                }else{ 
                                                    echo '<option value="">Country not available</option>'; 
                                                } 
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6">
                                    <div class="input-block mb-3">
                                        <label class="col-form-label" for="mystate">State<span class="text-danger">*</span></label>
                                        <select class="form-select" id="mystate" aria-label="Floating label select example">
                                            
                                            <option value="">--Select country first--</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6">
                                    <div class="input-block mb-3">
                                        <label class="col-form-label" for="city">City<span class="text-danger">*</span></label>
                                        <select class="form-select" id="city" aria-label="Floating label select example">
                                            
                                            <option value="">--Select state first--</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6">
                                    <div class="input-block mb-3">
                                        <label class="col-form-label" for="pin">Pincode<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="pin" placeholder="Enter your pincode" value="<?php echo $pincode; ?>">
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <div class="input-block mb-3">
                                        <label class="col-form-label" for="address">Address<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="address" placeholder="Enter your Address" value="<?php echo $address; ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Card Section 3 -->
                        <div class="card rounded-4 p-3 border-1">
                            <div class="row">
                                <div class="d-flex gap-2">
                                    <p class="fw-bolder addTENum">03</p>
                                    <h4 class="fw-bolder text-dark align-content-center">Bank Details:</h4>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6">
                                    <div class="input-block mb-3">
                                        <label class="col-form-label" for="accountName">Account Name<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="accountName" placeholder="Enter your Account Name" value="<?php echo $account_name; ?>" >
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6">
                                    <div class="input-block mb-3">
                                        <label class="col-form-label" for="accountNumber">Account Number<span class="text-danger">*</span></label>
                                        <input type="number" class="form-control" id="accountNumber" placeholder="Enter your Account Number" value="<?php echo $account_number; ?>" >
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6">
                                    <div class="input-block mb-3">
                                        <label class="col-form-label" for="ifscCode">IFSC Code<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="ifscCode" placeholder="Enter your IFSC Code" value="<?php echo $ifsc_code; ?>" >
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6">
                                    <div class="input-block mb-3">
                                        <label class="col-form-label" for="branchName">Bank & Branch Name<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="branchName" placeholder="Enter your Bank & Branch Name" value="<?php echo $bank_and_branch_name; ?>" >
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Card Section 4 -->
                        <div class="card rounded-4 p-3 border-1">
                            <div class="row">
                                <div class="d-flex gap-2">
                                    <p class="fw-bolder addTENum">04</p>
                                    <h4 class="fw-bolder text-dark align-content-center">Payment Information</h4>
                                </div>
                                <div class="col-md-6 col-sm-6">
                                    <div class="input-block mb-3">
                                        <label class="col-form-label" for="activationPlan">Activation Plan<span class="text-danger">*</span></label>
                                        <select id="activationPlan" class="form-select" > 
                                            <option value="<?php echo $amount; ?>"><?php echo $amount; ?></option>
                                            <option value="">--Select Activation Plan--</option> 
                                            <option value="FOC">FOC</option> 
                                            <option value="200000">2,00,000/-</option> 
                                            <option value="300000">3,00,000/-</option> 
                                            <option value="400000">4,00,000/-</option> 
                                            <option value="500000">5,00,000/-</option> 
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6 " id="paymentMode">
                                    <label class="fw-bold col-form-label">Payment Mode: <span class="text-danger">*</span></label>
                                    <div class="form-control radioBtn d-flex justify-content-around" >
                                        <label class="mb-0" for="cashPayment"><input type="radio" id="cashPayment" class="form-check-input payment me-3" name="payment" value="cash" <?php if ($payment_mode == "cash") { echo 'checked disabled'; } ?>  >Cash</label>
                                        <label class="mb-0" for="chequePayment"><input type="radio" id="chequePayment"  class="form-check-input payment me-3" name="payment" value="cheque" <?php if ($payment_mode == "cheque") { echo 'checked disabled'; } ?>  >Cheque</label>
                                        <label class="mb-0" for="onlinePayment"><input type="radio" id="onlinePayment"  class="form-check-input payment me-3" name="payment" value="online" <?php if ($payment_mode == "online") { echo 'checked disabled'; } ?>  >UPI/NEFT</label>
                                    </div>
                                </div>
                                <div class="pb-3">
                                    <div class="col-md-12 col-sm-12 d-none" id="chequeOpt">
                                        <div class="row d-flex justify-content-center">
                                            <div class="col-md-4 py-1">
                                                <div class="input-block">
                                                    <label class="col-form-label" for="chequeNo">Cheque No<span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" id="chequeNo" placeholder="Enter Cheque Number" value="<?= $cheque_no; ?>" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-4 py-1">
                                                <div class="input-block">
                                                    <label class="col-form-label" for="chequeDate">Cheque Date<span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" id="chequeDate" placeholder="Enter Date On Cheque" value="<?= $cheque_date; ?>" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-4 py-1">
                                                <div class="input-block">
                                                    <label class="col-form-label" for="bankName">Bank Name<span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" id="bankName" placeholder="Enter your Bank Name" value="<?= $bank_name; ?>" readonly>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-sm-12 d-none" id="onlineOpt">
                                        <div class="row d-flex justify-content-center">
                                            <div class="col-md-8">
                                                <div class="input-block">
                                                    <label class="col-form-label" for="transactionNo">Transaction No<span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" id="transactionNo" placeholder="Enter your Transaction No." value="<?= $transaction_no; ?>" readonly>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Card Section 5 -->
                        <div class="card rounded-4 p-3 border-1">
                            <div class="">
                                <div class="d-flex gap-2">
                                    <p class="fw-bolder addTENum">05</p>
                                    <h4 class="fw-bolder text-dark align-content-center">Upload Information</h4>
                                </div>
                                <div class="row g-3">
                                    <!-- Certificate of Incorporation -->
                                    <div class="col-lg-4 col-md-4 col-sm-6 col-12">
                                        <div class="upload-card"
                                            data-title="Certificate of Incorporation"
                                            data-index="11"
                                            data-folder="certificate_of_incorporation"
                                            data-existing="<?= htmlspecialchars($certificate_of_incorporation ?? '') ?>">

                                            <input type="file" class="file-input" accept="image/*,.pdf" id="upload_file11">

                                            <input type="hidden"
                                                id="img_path11"
                                                name="img_path11"
                                                value="<?= htmlspecialchars($certificate_of_incorporation ?? '') ?>">

                                            <div class="upload-content">
                                                <div class="upload-icon">
                                                    <i class="fa-solid fa-user"></i>
                                                </div>
                                                <h6>Certificate of Incorporation</h6>
                                                <p>Click to upload<br>or drag and drop</p>
                                                <small>(JPG, PNG, PDF)</small>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- GSTIN -->
                                    <div class="col-lg-4 col-md-4 col-sm-6 col-12">
                                        <div class="upload-card"
                                            data-title="GSTIN"
                                            data-index="12"
                                            data-folder="gstin"
                                            data-existing="<?= htmlspecialchars($gstin ?? '') ?>">

                                            <input type="file" class="file-input" accept="image/*,.pdf" id="upload_file12">

                                            <input type="hidden"
                                                id="img_path12"
                                                name="img_path12"
                                                value="<?= htmlspecialchars($gstin ?? '') ?>">

                                            <div class="upload-content">
                                                <div class="upload-icon">
                                                    <i class="fa-regular fa-id-card"></i>
                                                </div>
                                                <h6>GSTIN</h6>
                                                <p>Click to upload<br>or drag and drop</p>
                                                <small>(JPG, PNG, PDF)</small>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Board Resolution -->
                                    <div class="col-lg-4 col-md-4 col-sm-6 col-12">
                                        <div class="upload-card"
                                            data-title="Board Resolution"
                                            data-index="13"
                                            data-folder="board_resolution"
                                            data-existing="<?= htmlspecialchars($board_resolution ?? '') ?>">

                                            <input type="file" class="file-input" accept="image/*,.pdf" id="upload_file13">

                                            <input type="hidden"
                                                id="img_path13"
                                                name="img_path13"
                                                value="<?= htmlspecialchars($board_resolution ?? '') ?>">

                                            <div class="upload-content">
                                                <div class="upload-icon">
                                                    <i class="fa-regular fa-credit-card"></i>
                                                </div>
                                                <h6>Board Resolution</h6>
                                                <p>Click to upload<br>or drag and drop</p>
                                                <small>(JPG, PNG, PDF)</small>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Bank Passbook -->
                                    <div class="col-lg-4 col-md-4 col-sm-6 col-12">
                                        <div class="upload-card"
                                            data-title="Bank Passbook"
                                            data-index="4"
                                            data-folder="passbook"
                                            data-existing="<?= htmlspecialchars($bank_passbook ?? '') ?>">

                                            <input type="file" class="file-input" accept="image/*,.pdf" id="upload_file4">

                                            <input type="hidden"
                                                id="img_path4"
                                                name="img_path4"
                                                value="<?= htmlspecialchars($bank_passbook ?? '') ?>">

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

                                    <!-- PAN Card -->
                                    <div class="col-lg-4 col-md-4 col-sm-6 col-12">
                                        <div class="upload-card"
                                            data-title="PAN Card"
                                            data-index="3"
                                            data-folder="pancard"
                                            data-existing="<?= htmlspecialchars($pan_card ?? '') ?>">

                                            <input type="file" class="file-input" accept="image/*,.pdf" id="upload_file3">

                                            <input type="hidden"
                                                id="img_path3"
                                                name="img_path3"
                                                value="<?= htmlspecialchars($pan_card ?? '') ?>">

                                            <div class="upload-content">
                                                <div class="upload-icon">
                                                    <i class="fa-solid fa-building-columns"></i>
                                                </div>
                                                <h6>PAN Card</h6>
                                                <p>Click to upload<br>or drag and drop</p>
                                                <small>(JPG, PNG, PDF)</small>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Address Proof -->
                                    <div class="col-lg-4 col-md-4 col-sm-6 col-12" id="addressProof">
                                        <div class="upload-card"
                                            data-title="Address Proof"
                                            data-index="6"
                                            data-folder="address_proof"
                                            data-existing="<?= htmlspecialchars($address_proof ?? '') ?>">

                                            <input type="file" class="file-input" accept="image/*,.pdf" id="upload_file6">

                                            <input type="hidden"
                                                id="img_path6"
                                                name="img_path6"
                                                value="<?= htmlspecialchars($address_proof ?? '') ?>">

                                            <div class="upload-content">
                                                <div class="upload-icon">
                                                    <i class="fa-solid fa-building-columns"></i>
                                                </div>
                                                <h6>Address Proof</h6>
                                                <p>Click to upload<br>or drag and drop</p>
                                                <small>(JPG, PNG, PDF)</small>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Payment Proof -->
                                    <div class="col-lg-4 col-md-4 col-sm-6 col-12 " id="payProof">
                                        <div class="upload-card"
                                            data-title="Payment Proof"
                                            data-index="14"
                                            data-folder="payment"
                                            data-existing="<?= htmlspecialchars($payment_proof ?? '') ?>">

                                            <input type="file" class="file-input" accept="image/*,.pdf" id="upload_file14">

                                            <input type="hidden"
                                                id="img_path14"
                                                name="img_path14"
                                                value="<?= htmlspecialchars($payment_proof ?? '') ?>">

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
                                </div>
                            </div>
                        </div>

                        <!-- for edit data page -->
                        <input type="hidden" id="ref_id" name="ref_id" value="<?php echo $reference_no; ?>">
                        <input type="hidden" id="editfor" name="editfor" value="<?php echo $editfor; ?>">
                        <input type="hidden" id="id" name="id" value="<?php echo $id; ?>">
                        <input type="hidden" id="registered" name="registered" value="<?php echo $user_type; ?>">
                        <input type="hidden" id="testValue" name="testValue" value="32"> <!-- institution -->
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="d-flex justify-content-end gap-4 submitBtnBackground">
                                    <button type="button" class="btn actionBtn cancelBtn mb-2">Cancel</button>
                                    <?php if($status == 4){ ?>
                                    <button type="button" class="btn actionBtn draftBtn mb-2" id="saveDraftEdit">Save Draft</button>
                                    <button type="submit" class="btn actionBtn submitBtn mb-2" id="editInstitution">
                                        <i class="fa-regular fa-paper-plane me-2"></i>
                                        Submit Institution
                                    </button>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <!-- container-fluid -->
                </div>
                <!-- End Page-content -->
                <?php include_once "../footer.php" ?>
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
        <!-- JAVASCRIPT -->
        <script src="../assets/libs/jquery/jquery.min.js"></script>
        <script src="../assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="../assets/libs/metismenu/metisMenu.min.js"></script>
        <script src="../assets/libs/simplebar/simplebar.min.js"></script>
        <script src="../assets/libs/node-waves/waves.min.js"></script>
        <script src="../assets/libs/feather-icons/feather.min.js"></script>
        <script src="../assets/libs/node-waves/waves.min.js"></script>

        <!-- add data to database js file -->
        <script type="text/javascript" src="js/institution.js"></script>

        <!-- apexcharts -->
        <!-- <script src="../assets/libs/apexcharts/apexcharts.min.js"></script> -->

        <!-- dashboard init -->
        <!-- <script src="assets/js/pages/dashboard.init.js"></script> -->

        <!-- App js -->
        <script src="../assets/js/app.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <!-- file upload code js file -->
        <script src="../../uploading/uploadTechnoAdmin.js"></script>

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
            }
            );

        </script>
        <!-- ** designation user, user name on designation select / get country, state, city, pincode **  -->
        <script>
             
            var selectedState = "<?= $state_id ?? '' ?>";
            var selectedCity = "<?= $city_id ?? '' ?>";
            var selectedCountry = "<?= $country_id ?? '' ?>";

            //Activation Plan
            $('#activationPlan').on('change', function() {
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

            // Payment Mode
            $('#paymentMode').on('click', function(){
                var paymentMode = $(".payment:checked").val();
                // console.log(paymentMode);
                if(paymentMode == "cheque"){
                    $("#chequeOpt").removeClass("d-none");
                    $("#onlineOpt").addClass("d-none");
                    $("#transactionNo").val("");
                }else if(paymentMode == "online"){
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

            // type of institution other radio button option to show text box
            $(".instituteType").change(function () {
                if ($("#test8").is(":checked")) {
                    $("#instituteTypeOther").slideDown();
                } else {
                    $("#instituteTypeOther").slideUp();
                    $("#instituteTypeOther").val("");
                }
            });

            const uploadBasePath = "../../uploading/";
            const adminuploadUrl = "../../uploading/uploadAdminUsers.php";

            function bindUploadEvents() {

                $(".file-input").off("change").on("change", function () {

                    let input = this;

                    if (!input.files.length) {
                        return;
                    }

                    let file = input.files[0];

                    let card = $(input).closest(".upload-card");

                    let title = card.data("title");
                    let index = card.data("index");
                    let folder = card.data("folder");

                    let formData = new FormData();
                    formData.append("file", file);
                    formData.append("folder", folder);

                    $.ajax({

                        url: adminuploadUrl,
                        type: "POST",
                        data: formData,
                        processData: false,
                        contentType: false,

                        success: function (response) {

                            response = response.trim();

                            if (response == "1") {
                                alert("Upload Failed");
                                input.value = "";
                                return;
                            }

                            if (response == "2") {
                                alert("Invalid File Extension");
                                input.value = "";
                                return;
                            }

                            if (response == "3") {
                                alert("Please Select File");
                                input.value = "";
                                return;
                            }

                            if (response == "4") {
                                alert("File size exceeds 2 MB");
                                input.value = "";
                                return;
                            }

                            // Remove previous preview
                            card.find(".upload-content, .preview-wrapper, .pdf-preview").remove();

                            // Update hidden field
                            $("#img_path" + index).val(response);

                            // Update current file
                            card.attr("data-existing", response);

                            let extension = response.split(".").pop().toLowerCase();

                            if (["jpg","jpeg","png","gif","jfif","webp"].includes(extension)) {

                                card.append(`
                                    <div class="preview-wrapper">
                                        <img src="${uploadBasePath}${response}?v=${Date.now()}" class="img-fluid">
                                        <div class="file-title">${title}</div>
                                    </div>
                                `);

                            } else {

                                card.append(`
                                    <div class="pdf-preview">
                                        <i class="fa-solid fa-file-pdf fa-3x text-danger"></i>
                                        <div class="file-title">${title}</div>
                                    </div>
                                `);

                            }

                        },

                        error: function () {

                            alert("Upload Failed.");

                        }

                    });

                });

            }

            function loadExistingFiles() {

                $(".upload-card").each(function () {

                    let card = $(this);

                    let file = card.attr("data-existing");

                    if (!file) {
                        return;
                    }

                    // Skip placeholder images if desired
                    // Uncomment if you don't want to preview placeholder files:
                    // if (file.includes("not_uploaded")) return;

                    let title = card.attr("data-title");

                    card.find(".upload-content").remove();

                    let extension = file.split(".").pop().toLowerCase();

                    if (["jpg","jpeg","png","gif","jfif","webp"].includes(extension)) {

                        card.append(`
                            <div class="preview-wrapper">
                                <img src="${uploadBasePath}${file}?v=${Date.now()}" class="img-fluid">
                                <div class="file-title">${title}</div>
                            </div>
                        `);

                    } else {

                        card.append(`
                            <div class="pdf-preview">
                                <i class="fa-solid fa-file-pdf fa-3x text-danger"></i>
                                <div class="file-title">${title}</div>
                            </div>
                        `);

                    }

                });

            }

            $(document).ready(function () {

                loadExistingFiles();

                bindUploadEvents();

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
                selectedCountry = "<?= $country_id ?>";
                selectedState   = "<?= $state_id ?>";
                selectedCity    = "<?= $city_id ?>";

                
                // Address Information
                $('#country').on('change', function () {

                    var countryID = $(this).val();

                    if (countryID) {

                        $.ajax({
                            type: 'POST',
                            url: '../address/countrydata.php',
                            data: {
                                country_id: countryID
                            },
                            success: function (html) {

                                $('#mystate').html(html);

                                if (selectedState != '') {

                                    $('#mystate option').each(function () {

                                        if ($(this).val() == selectedState) {
                                            $(this).prop('selected', true);
                                        }

                                    });

                                    $('#mystate').trigger('change');
                                }

                            }
                        });

                    } else {

                        $('#mystate').html('<option value="">Select country first</option>');
                        $('#city').html('<option value="">Select state first</option>');
                        $('#pin').val('');
                    }
                });
                    
                $('#mystate').on('change', function () {

                    var stateID = $(this).val();

                    if (stateID) {

                        $.ajax({
                            type: 'POST',
                            url: '../address/countrydata.php',
                            data: {
                                state_id: stateID
                            },
                            success: function (html) {

                                $('#city').html(html);

                                if (selectedCity != '') {

                                    $('#city option').each(function () {

                                        if ($(this).val() == selectedCity) {
                                            $(this).prop('selected', true);
                                        }

                                    });

                                    $('#city').trigger('change');
                                }

                            }
                        });

                    } else {

                        $('#city').html('<option value="">Select state first</option>');
                        $('#pin').val('');
                    }
                });

                $('#city').on('change', function () {

                    var cityID = $(this).val();

                    if (cityID) {

                        $.ajax({
                            type: 'POST',
                            url: '../address/pincode.php',
                            data: {
                                city_id: cityID
                            },
                            success: function (response) {

                                response = $.trim(response);

                                $('#pin').val(response || '');

                            },
                            error: function () {

                                $('#pin').val('');

                            }
                        });

                    } else {

                        $('#pin').val('');

                    }
                });
                $('#country').val(selectedCountry).trigger('change');
                $('#pin').val(<?= json_encode($pincode) ?>);
                
            });
            $(".cancelBtn").on("click", function () {

				Swal.fire({
					title: "Are you sure?",
					text: "You will be redirected to list page.",
					icon: "warning",
					showCancelButton: true,
					confirmButtonColor: "#d63030",
					cancelButtonColor: "#1b721bf2",
					confirmButtonText: "Yes, Cancel",
					cancelButtonText: "Continue Editing",
					reverseButtons: true,
					focusCancel: true
				}).then((result) => {

					if (result.isConfirmed) {

						window.location.href = "institution_list.php";

					}

				});

			});
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