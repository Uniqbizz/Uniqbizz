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
        $date = date('Y'); 

        $id = $_GET['id']; //id 11
        $user_id = $_GET['regby']; //regby 1-admin or other user in this case 34-chief Techno Enterprise (Not in use)
        $reference_no = $_GET['refno']; //refno ETE260001
        $country_id = $_GET['country']; // country
        $state_id = $_GET['state']; // state
        $city_id = $_GET['city']; // city
        $editfor = $_GET['editfor']; // pending or confirm
        $usertype = $_GET['usertype']; // 'STE' for Chief Techno Enterprise

        if ($editfor == 'pending') {
            $identifier_name = 'id=';
        } else if ($editfor == 'registered') {
            $identifier_name = 'chief_techno_enterprise_id=';
        }

        $testValue = '35';

        $stmt = $conn->prepare("SELECT * FROM `chief_techno_enterprise` WHERE chief_techno_enterprise_id='" . $id . "' OR id = '" . $id . "'");
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        if ($stmt->rowCount() > 0) {
            foreach (($stmt->fetchAll()) as $row) {
                $fid = $row['id'];
                $application_id = $row['application_id'];
                $firstname = $row['firstname'];
                $lastname = $row['lastname'];
                $father_spouse_name = $row['father_spouse_name'];
                $email = $row['email'];
                $country_code = $row['country_code'];
                $contact_no = $row['contact_no'];
                $alternative_country_code = $row['alternative_country_code'];
                $alternative_contact_no = $row['alternative_contact_no'];
                $aadhar_no = $row['aadhar_no'];
                $pan_no = $row['pan_no'];
                $reference_no = $row['reference_no'];
                $date_of_birth = $row['date_of_birth'];
                $gender = $row['gender'];
                $country = $row['country'];
                $state = $row['state'];
                $city = $row['city'];
                $address = $row['address'];
                $pincode = $row['pincode'];

                // Get country name
                $countries = $conn->prepare("SELECT country_name FROM countries WHERE id='$country' AND status='1'");
                $countries->execute();
                if ($countries->rowCount() > 0) {
                    $countryname = $countries->fetch()['country_name'];
                }

                // Get state name
                $states = $conn->prepare("SELECT state_name FROM states WHERE id='$state' AND status='1'");
                $states->execute();
                if ($states->rowCount() > 0) {
                    $statename = $states->fetch()['state_name'];
                }

                // Get city name
                $cities = $conn->prepare("SELECT city_name FROM cities WHERE id='$city' AND status='1'");
                $cities->execute();
                if ($cities->rowCount() > 0) {
                    $city_name = $cities->fetch()['city_name'];
                }

                // Get reporting manager (BM or ZM)
                if ($reference_no == "Not Applicable") {
                    $reference_no_fname = "Not Applicable";
                } else {
                    $stmt_manager = $conn->prepare("SELECT firstname, lastname FROM chief_techno_enterprise WHERE chief_techno_enterprise_id = :ref");
                    $stmt_manager->execute([':ref' => $reference_no]);

                    if ($stmt_manager->rowCount() > 0) {
                        $manager = $stmt_manager->fetch(PDO::FETCH_ASSOC);
                        $reference_no_fname = $manager['firstname'] . ' ' . $manager['lastname'];
                    } else {
                        $reference_no_fname = "Unknown";
                    }
                }

                // professional_and_educational
                $stmt2 = $conn->prepare("SELECT * FROM `professional_and_educational` WHERE application_id= :application_id");
                $stmt2->execute([':application_id' => $application_id]);
                $stmt2->setFetchMode(PDO::FETCH_ASSOC);

                if ($stmt2->rowCount() > 0) {
                    foreach (($stmt2->fetchAll()) as $row2) {
                        $current_occupation = $row2['current_occupation'];
                        $current_experience = $row2['current_experience'];
                        $current_income = $row2['current_income'];
                        $managed_team = $row2['managed_team'];
                        $team_description = $row2['team_description'];
                        $leadership_experience = $row2['leadership_experience'];
                        $leadership_experience_other = $row2['leadership_experience_other'];
                        $educational_qualification = $row2['educational_qualification'];
                    }
                }
                $selectedLeadership = json_decode($leadership_experience, true);
                        
                // leadership_assessment
                $stmt3 = $conn->prepare("SELECT * FROM `leadership_assessment` WHERE application_id= :application_id");
                $stmt3->execute([':application_id' => $application_id]);
                $stmt3->setFetchMode(PDO::FETCH_ASSOC);

                if ($stmt3->rowCount() > 0) {
                    foreach (($stmt3->fetchAll()) as $row3) {
                        $career_objective = $row3['career_objective'];
                        $team_expected = $row3['team_expected'];
                        $operating_region = $row3['operating_region'];

                        // Get state name
                        $statesLeader = $conn->prepare("SELECT state_name FROM states WHERE id='$operating_region' AND status='1'");
                        $statesLeader->execute();
                        if ($statesLeader->rowCount() > 0) {
                            $statenameLeader = $statesLeader->fetch()['state_name'];
                        }
                    }
                }

                // nominee_details
                $stmt4 = $conn->prepare("SELECT * FROM `nominee_details` WHERE application_id= :application_id");
                $stmt4->execute([':application_id' => $application_id]);
                $stmt4->setFetchMode(PDO::FETCH_ASSOC);

                if ($stmt4->rowCount() > 0) {
                    foreach (($stmt4->fetchAll()) as $row4) {
                        $nominee_name = $row4['nominee_name'];
                        $nominee_relation = $row4['nominee_relation'];
                        $nominee_contact_cd = $row4['nominee_contact_cd'];
                        $nominee_contact_no = $row4['nominee_contact_no'];
                        $nominee_date_of_birth = $row4['nominee_date_of_birth'];
                        $nominee_address = $row4['nominee_address'];
                    }
                }

                // bank_details
                $stmt5 = $conn->prepare("SELECT * FROM `bank_details` WHERE application_id= :application_id");
                $stmt5->execute([':application_id' => $application_id]);
                $stmt5->setFetchMode(PDO::FETCH_ASSOC);

                if ($stmt5->rowCount() > 0) {
                    foreach (($stmt5->fetchAll()) as $row5) {
                        $account_holder_name = $row5['account_holder_name'];
                        $bank_name = $row5['bank_name'];
                        $account_number = $row5['account_number'];
                        $ifsc_code = $row5['ifsc_code'];
                        $branch_name = $row5['branch_name'];
                    }
                }

                // documents
                $stmt4 = $conn->prepare("SELECT * FROM `documents` WHERE application_id= :application_id");
                $stmt4->execute([':application_id' => $application_id]);
                $stmt4->setFetchMode(PDO::FETCH_ASSOC);

                if ($stmt4->rowCount() > 0) {
                    foreach (($stmt4->fetchAll()) as $row4) {
                        $profile_pic = $row4['profile_pic'];
                        $aadhar_card = $row4['aadhar_card'];
                        $pan_card = $row4['pan_card'];
                        $cancelled_cheque_bank_passbook = $row4['cancelled_cheque_bank_passbook'];
                        $resume_cv = $row4['resume_cv'];
                        $address_proof = $row4['address_proof'];
                        $professional_profile = $row4['professional_profile'];
                        $business_profile = $row4['business_profile'];
                        $income_proof = $row4['income_proof'];
                        $other_document = $row4['other_document'];
                    }
                }
            }
        }

    ?>

    <head>
        
        <meta charset="utf-8" />
        <title>Edit Chief Techno Enterprise | Admin Dashboard </title>
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
        <link rel="stylesheet" href="../assets/css/loadingScreen.css" rel="stylesheet" type="text/css" />
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
                                    <h4 class="mb-sm-0 font-size-18">Chief Techno Enterprise</h4>
                                </div>
                            </div>
                        </div>

                        <!-- add customer form start -->
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <form>
                                            <h3>Edit Chief Techno Enterprise</h3>
                                            <div class="row">
                                                <!-- Personal Details -->

                                                <!-- <div class="col-md-6 col-sm-6">
                                                    <div class="input-block mb-3">
                                                        <label class="col-form-label">Reference Id<span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" id="user_id_name" placeholder="Enter First Name" value="<?php echo $reference_no; ?>" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-sm-6">
                                                    <div class="input-block mb-3">
                                                    <label class="col-form-label">Reference Full Name <span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" id="reference_name" placeholder="Enter Last Name" value="<?php echo $reference_no_fname  ; ?>" readonly>
                                                    </div>
                                                </div> -->
                                                <div class="col-md-6 col-sm-6">
                                                    <div class="input-block mb-3">
                                                        <label class="col-form-label">First Name <span class="text-danger">*</span></label>
                                                        <input class="form-control" type="text" id="firstname" value="<?php echo $firstname; ?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-sm-6">
                                                    <div class="input-block mb-3">
                                                        <label class="col-form-label">Last Name <span class="text-danger">*</span></label>
                                                        <input class="form-control" type="text" id="lastname" value=" <?php echo $lastname; ?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-sm-6">
                                                    <div class="input-block mb-3">
                                                        <label class="col-form-label">Father / Spouse Name<span class="text-danger">*</span></label>
                                                        <input class="form-control" type="text" id="father_spouse_name" value=" <?php echo $father_spouse_name; ?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-sm-6">
                                                    <div class="input-block mb-3">
                                                        <label class="col-form-label">Email Address<span class="text-danger">*</span></label>
                                                        <input class="form-control" type="email" id="email" value="<?php echo $email;?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-sm-6">
                                                    <div class="input-block mb-3">
                                                        <label class="col-form-label">Date of Birth <span class="text-danger">*</span></label>
                                                        <input class="form-control" type="date" id="dob" value="<?php echo $date_of_birth ;?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-sm-12">
                                                    <div class="form-group">
                                                        <label class="col-form-label">Gender <span class="text-danger">*</span></label>
                                                        <div class="form-control d-flex justify-content-around">
                                                            <label class="radio-inline mb-0 ms-3"><input type="radio" name="gender" class="gender form-check-input" id="test3" value="male" <?php if ($gender == 'male'){echo ' checked ';} ?>>&nbsp;&nbsp;&nbsp;Male</label>
                                                            <label class="radio-inline mb-0 ms-3"><input type="radio" name="gender" class="gender form-check-input" id="test4" value="female" <?php if ($gender == 'female'){echo ' checked ';} ?>>&nbsp;&nbsp;&nbsp;Female</label>
                                                            <label class="radio-inline mb-0 ms-3"><input type="radio" name="gender" class="gender form-check-input" id="test5" value="others" <?php if ($gender == 'others'){echo ' checked ';} ?>>&nbsp;&nbsp;&nbsp;Other</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-sm-12 mb-3">
                                                    <div class="row">
                                                        <div class="col-md-4 col-sm-4 col-3">
                                                            <div class="input-block">
                                                                <?php
                                                                    require '../connect.php';
                                                                    $stmt = $conn->prepare("SELECT * FROM countries WHERE status = 1 ORDER BY country_name ASC");
                                                                    $stmt->execute();                                            
                                                                    $stmt->setFetchMode(PDO::FETCH_ASSOC);
                                                                ?>
                                                                <label for="country_cd" class="col-form-label">Code:</label>
                                                                <select class="form-control" id="country_cd">
                                                                    <?php 
                                                                        if($stmt->rowCount()>0){
                                                                            foreach (($stmt->fetchAll()) as $key => $row) {  
                                                                                echo '<option value="'.$row['country_code'].'">+'.$row['country_code'].' ('.$row['sortname'].')</option>'; 
                                                                            } 
                                                                        }else{ 
                                                                            echo '<option value="">Country not available</option>'; 
                                                                        } 
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-8 col-sm-8 col-9">
                                                            <div class="input-block">
                                                                <label class="col-form-label">Phone Number <span class="text-danger">*</span></label>
                                                                <input class="form-control" type="text" id="phone" value=" <?php echo $contact_no; ?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-sm-12 mb-3">
                                                    <div class="row">
                                                        <div class="col-md-4 col-sm-4 col-3">
                                                            <div class="input-block">
                                                                <?php
                                                                    require '../connect.php';
                                                                    $stmt = $conn->prepare("SELECT * FROM countries WHERE status = 1 ORDER BY country_name ASC");
                                                                    $stmt->execute();                                            
                                                                    $stmt->setFetchMode(PDO::FETCH_ASSOC);
                                                                ?>
                                                                <label for="country_cd_alt" class="col-form-label">Code:</label>
                                                                <select class="form-control" id="country_cd_alt">
                                                                    <?php 
                                                                        if($stmt->rowCount()>0){
                                                                            foreach (($stmt->fetchAll()) as $key => $row) {  
                                                                                echo '<option value="'.$row['country_code'].'">+'.$row['country_code'].' ('.$row['sortname'].')</option>'; 
                                                                            } 
                                                                        }else{ 
                                                                            echo '<option value="">Country not available</option>'; 
                                                                        } 
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-8 col-sm-8 col-9">
                                                            <div class="input-block">
                                                                <label class="col-form-label">Alt Phone Number <span class="text-danger">*</span></label>
                                                                <input class="form-control" type="text" id="altPhone" value=" <?php echo $alternative_contact_no; ?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-sm-6">
                                                    <div class="input-block mb-3">
                                                        <label class="col-form-label">Aadhar No<span class="text-danger">*</span></label>
                                                        <input class="form-control" type="text" id="aadharNo" value=" <?php echo $aadhar_no; ?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-sm-6">
                                                    <div class="input-block mb-3">
                                                        <label class="col-form-label">PAN No<span class="text-danger">*</span></label>
                                                        <input class="form-control" type="text" id="panNo" value=" <?php echo $pan_no; ?>">
                                                    </div>
                                                </div>

                                                <h3>Residential Address</h3>
                                                <div class="col-md-6 col-sm-6">
                                                    <div class="input-block mb-3">
                                                        <?php
                                                            $stmt = $conn->prepare("SELECT * FROM countries WHERE status = 1 ORDER BY country_name ASC");
                                                            $stmt->execute();                                         
                                                            $stmt->setFetchMode(PDO::FETCH_ASSOC);
                                                        ?>
                                                        <label class="col-form-label">Country <span class="text-danger">*</span></label>
                                                        <select class="form-select" id="country">
                                                            <option value="<?php echo $country_id;?>"><?php echo $countryname.' (Already Selected)' ; ?></option>
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
                                                <div class="col-md-6 col-sm-6">
                                                    <div class="input-block mb-3">
                                                        <label class="col-form-label">State<span class="text-danger">*</span></label>
                                                        <select class="form-select" id="mystate" aria-label="Floating label select example">
                                                            <option value="<?php echo $state_id;?>"><?php echo $statename.' (Already Selected)' ; ?></option>
                                                            <option value="">--Select country first--</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-sm-6">
                                                    <div class="input-block mb-3">
                                                        <label class="col-form-label">City<span class="text-danger">*</span></label>
                                                        <select class="form-select" id="city" aria-label="Floating label select example">
                                                            <option value="<?php echo $city_id;?>"><?php echo $city_name.' (Already Selected)' ; ?></option>
                                                            <option value="">--Select state first--</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-sm-6">  
                                                    <div class="input-block mb-3">
                                                        <label class="col-form-label">Pincode<span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" id="pin" placeholder="Pincode" value="<?php echo $pincode; ?>" readonly >
                                                    </div>
                                                </div>
                                                <div class="col-md-12 col-sm-12">  
                                                    <div class="input-block mb-3">
                                                        <label class="col-form-label">Address<span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" id="address" value="<?php echo $address ?>" placeholder="Address" readonly >
                                                    </div>
                                                </div>
                                                
                                                <h3>Professional Details</h3>
                                                <div class="col-md-6 col-sm-6">
                                                    <div class="input-block mb-3">
                                                        <label class="col-form-label">Current Occupation / Business<span class="text-danger">*</span></label>
                                                        <input class="form-control" type="text" id="occupation" value=" <?php echo $current_occupation; ?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-sm-6">
                                                    <div class="input-block mb-3">
                                                        <label class="col-form-label">Total Experience<span class="text-danger">*</span></label>
                                                        <input class="form-control" type="text" id="experience" value=" <?php echo $current_experience; ?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-sm-6">
                                                    <div class="input-block mb-3">
                                                        <label class="col-form-label">Current Annual Income<span class="text-danger">*</span></label>
                                                        <input class="form-control" type="text" id="annual_income" value=" <?php echo $current_income; ?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-sm-12">
                                                    <div class="form-group">
                                                        <label class="col-form-label">Have You Managed teams Previously <span class="text-danger">*</span></label>
                                                        <div class="form-control d-flex justify-content-around">
                                                            <label class="radio-inline mb-0 ms-3"><input type="radio" name="teamManaged" class="teamManaged" id="teamManagedYes" value="yes" <?php if ($managed_team == 'yes'){echo ' checked ';} ?> >&nbsp;&nbsp;&nbsp;Yes</label>
                                                            <label class="radio-inline mb-0 ms-3"><input type="radio" name="teamManaged" class="teamManaged" id="teamManagedNo" value="no" <?php if ($managed_team == 'no'){echo ' checked ';} ?> >&nbsp;&nbsp;&nbsp;No</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-sm-6">
                                                    <div class="input-block mb-3">
                                                        <label class="col-form-label">If Yes, Team size<span class="text-danger">*</span></label>
                                                        <textarea class="form-control" id="teamSize" rows="4" cols="50"> <?php echo htmlspecialchars($team_description); ?> </textarea>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-sm-6">
                                                    <div class="input-block mb-3">
                                                        <label class="col-form-label">
                                                            Leadership Experience <span class="text-danger">*</span>
                                                        </label>

                                                        <div class="row mt-2">
                                                            <!-- Left Column -->
                                                            <div class="col-md-4">
                                                                <div class="mb-2">
                                                                    <input type="checkbox" id="lead1" name="leadership[]" value="Sales Leadership" <?= in_array('Sales Leadership', $selectedLeadership ?? []) ? 'checked' : '' ?>>
                                                                    <label for="lead1">Sales Leadership</label>
                                                                </div>

                                                                <div class="mb-2">
                                                                    <input type="checkbox" id="lead2" name="leadership[]" value="Business Development" <?= in_array('Business Development', $selectedLeadership ?? []) ? 'checked' : '' ?>>
                                                                    <label for="lead2">Business Development</label>
                                                                </div>

                                                                <div class="mb-2">
                                                                    <input type="checkbox" id="lead3" name="leadership[]" value="Team Management" <?= in_array('Team Management', $selectedLeadership ?? []) ? 'checked' : '' ?>>
                                                                    <label for="lead3">Team Management</label>
                                                                </div>
                                                            </div>

                                                            <!-- Right Column -->
                                                            <div class="col-md-8">
                                                                <div class="mb-2">
                                                                    <input type="checkbox" id="lead4" name="leadership[]" value="Enterpreneurship" <?= in_array('Enterpreneurship', $selectedLeadership ?? []) ? 'checked' : '' ?>>
                                                                    <label for="lead4">Enterpreneurship</label>
                                                                </div>

                                                                <div class="mb-2">
                                                                    <input type="checkbox" id="lead5" name="leadership[]" value="Corporate Leader" <?= in_array('Corporate Leader', $selectedLeadership ?? []) ? 'checked' : '' ?>>
                                                                    <label for="lead5">Corporate Leader</label>
                                                                </div>

                                                                <div class="mb-2">
                                                                    <input type="checkbox" id="lead6" name="leadership[]" value="other" <?= in_array('other', $selectedLeadership ?? []) ? 'checked' : '' ?>>
                                                                    <label for="lead6">Other(Please Specify)</label>
                                                                    <input type="text" name="other_leadership" id="otherLead" class="form-control mt-2" <?php in_array('other', $selectedLeadership ?? []) ? 'style="display:block;' : 'style="display:none;' ?> " value="<?= $leadership_experience_other; ?>">
                                                                </div>
                                                            </div>
                                                            <input type="hidden" name="leadership_json" id="leadership_json">
                                                        </div>
                                                    </div>
                                                </div>

                                                <h4 class="my-2">Educational Details</h4>
                                                <div class="col-md-6 col-sm-6">
                                                    <div class="input-block mb-3">
                                                        <label class="col-form-label">Educational Qualification<span class="text-danger">*</span></label>
                                                        <input class="form-control" type="text" id="qualification" value="<?= $educational_qualification; ?>">
                                                    </div>
                                                </div>

                                                <h4 class="my-2">Leadership Assessment</h4>
                                                <div class="col-md-4 col-sm-6">
                                                    <div class="input-block mb-3">
                                                        <label class="col-form-label">Why You want to become a Chief Techno Enterprise?<span class="text-danger">*</span></label>
                                                        <textarea class="form-control" id="career_objective" rows="4" cols="50"> <?= $career_objective; ?></textarea>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-sm-6">
                                                    <div class="input-block mb-3">
                                                        <label class="col-form-label">
                                                            Expected Team Building Capacity(Within 12 Months) <span class="text-danger">*</span>
                                                        </label>
                                                        
                                                        <div class="row mt-2">
                                                            <div class="col-md-6">
                                                                <div class="mb-2">
                                                                    <input type="radio" id="expected1" name="teamExpected" class="teamExpected" value="5" <?php if ($team_expected == '5'){echo ' checked ';} ?>>
                                                                    <label for="expected1">5 Techno Enterprise</label>
                                                                </div>

                                                                <div class="mb-2">
                                                                    <input type="radio" id="expected2" name="teamExpected" class="teamExpected" value="10" <?php if ($team_expected == '10'){echo ' checked ';} ?>>
                                                                    <label for="expected2">10 Techno Enterprise</label>
                                                                </div>

                                                                <div class="mb-2">
                                                                    <input type="radio" id="expected3" name="teamExpected" class="teamExpected" value="15" <?php if ($team_expected == '15'){echo ' checked ';} ?>>
                                                                    <label for="expected3">15 Techno Enterprise</label>
                                                                </div>

                                                            </div>

                                                            <!-- Right Column -->
                                                            <div class="col-md-6">
                                                                <div class="mb-2">
                                                                    <input type="radio" id="expected4" name="teamExpected" class="teamExpected" value="25+" <?php if ($team_expected == '25+'){echo ' checked ';} ?>>
                                                                    <label for="expected4">25+ Techno Enterprise</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-sm-6">
                                                    <div class="input-block mb-3">
                                                        <label class="col-form-label">Preferred Operating Region <span class="text-danger">*</span></label>
                                                        <select class="form-select" id="OperatingState">
                                                            <?php   
                                                                if($operating_region == ''){
                                                                    echo '<option value=""> Operating Region Not Selected </option>';
                                                                }else{
                                                                    echo '<option value=" '.$operating_region.' "> '.$statenameLeader. ' (Already Selected) </option>';
                                                                }
                                                                
                                                            ?>
                                                            <option value=""> ---- Select State ---- </option>
                                                            <?php
                                                            require '../connect.php';
                                                            $sql = "SELECT * FROM `states` WHERE status ='1' ";
                                                            $stmt = $conn->prepare($sql);
                                                            $stmt->execute();
                                                            $stmt->setFetchMode(PDO::FETCH_ASSOC);
                                                            if ($stmt->rowCount() > 0) {
                                                                foreach (($stmt->fetchAll()) as $key => $row) {
                                                                    echo '
                                                                                <option value="' . $row['id'] . '">' . $row['state_name'] . '</option>
                                                                            ';
                                                                }
                                                            } else {
                                                                echo '<option value="">Department not available</option>';
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>

                                                <h4 class="my-2">Nominee Details</h4>
                                                <div class="col-md-6 col-sm-6">
                                                    <div class="input-block mb-3">
                                                        <label class="col-form-label">Nominee Name<span class="text-danger">*</span></label>
                                                        <input class="form-control" type="text" id="nomineeName" value="<?= $nominee_name; ?>" >
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-sm-6">
                                                    <div class="input-block mb-3">
                                                        <label class="col-form-label">Nominee Relation<span class="text-danger">*</span></label>
                                                        <input class="form-control" type="text" id="nomineeRelation" value="<?= $nominee_relation; ?>" >
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-sm-12 mb-3">
                                                    <div class="row">
                                                        <div class="col-md-4 col-sm-4 col-3">
                                                            <div class="input-block">
                                                                <?php
                                                                require '../connect.php';
                                                                $stmt = $conn->prepare("SELECT * FROM countries WHERE status = 1 ORDER BY country_name ASC");
                                                                $stmt->execute();
                                                                $stmt->setFetchMode(PDO::FETCH_ASSOC);
                                                                ?>
                                                                <label for="countryCdNominee" class="col-form-label">Code:</label>
                                                                <select class="form-control" id="countryCdNominee">
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
                                                                <label class="col-form-label">Nominee Phone Number <span class="text-danger">*</span></label>
                                                                <input class="form-control" type="number" id="nomineePhone" placeholder="Enter Nominee Phone Number" value="<?= $nominee_contact_no; ?>" >
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-sm-6">
                                                    <div class="input-block mb-3">
                                                        <label class="col-form-label">Date of Birth <span class="text-danger">*</span></label>
                                                        <input class="form-control" type="date" id="nomineeDob" value="<?php echo $nominee_date_of_birth; ?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-12 col-sm-6">
                                                    <div class="input-block mb-3">
                                                        <label class="col-form-label">Nominee Address<span class="text-danger">*</span></label>
                                                        <input class="form-control" type="text" id="nomineeAddress" value="<?= $nominee_address; ?>" >
                                                    </div>
                                                </div>

                                                <h4 class="my-2">Bank Details</h4>
                                                <div class="col-md-6 col-sm-6">
                                                    <div class="input-block mb-3">
                                                        <label class="col-form-label">Account Holder Name<span class="text-danger">*</span></label>
                                                        <input class="form-control" type="text" id="accHolderName" value="<?= $account_holder_name;  ?>" >
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-sm-6">
                                                    <div class="input-block mb-3">
                                                        <label class="col-form-label">Bank Name<span class="text-danger">*</span></label>
                                                        <input class="form-control" type="text" id="bankName" value="<?= $bank_name;  ?>" >
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-sm-6">
                                                    <div class="input-block mb-3">
                                                        <label class="col-form-label">Account Number<span class="text-danger">*</span></label>
                                                        <input class="form-control" type="text" id="accountNumber" value="<?= $account_number;  ?>" >
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-sm-6">
                                                    <div class="input-block mb-3">
                                                        <label class="col-form-label">Confirm Account Number<span class="text-danger">*</span></label>
                                                        <input class="form-control" type="text" id="confirmAccountNumber" value="<?= $account_number;  ?>" >
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-sm-6">
                                                    <div class="input-block mb-3">
                                                        <label class="col-form-label">IFSC Code<span class="text-danger">*</span></label>
                                                        <input class="form-control" type="text" id="ifscCode" value="<?= $ifsc_code;  ?>" >
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-sm-6">
                                                    <div class="input-block mb-3">
                                                        <label class="col-form-label">Branch Name<span class="text-danger">*</span></label>
                                                        <input class="form-control" type="text" id="branchName" value="<?= $branch_name;  ?>" >
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
                                                            <a href="<?php echo '../../uploading/' . $profile_pic; ?>" download class="ms-3" title="Download">
                                                                <i class="fa fa-download fa-1x" aria-hidden="true"></i>
                                                            </a>
                                                        <?php
                                                            }
                                                        ?>
                                                        </label>
                                                        <input class="form-control" type="file" name="file1" id="upload_file1">
                                                    </div>
                                                    <input type="hidden" id="img_path1" value="<?php echo $profile_pic;?>">
                                                    <div id="preview1" >
                                                        <div id="image_preview1">
                                                            <?php
                                                                if($profile_pic ==''){
                                                                    echo '<img src="../../uploading/not_uploaded.png" alt="Preview" id="img_pre1" class="imgSize">';
                                                                }else{
                                                                    echo '<img src="../../uploading/'.$profile_pic.'" alt="Preview" id="img_pre1" class="imgSize">';?>
                                                                    
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div> 
                                                <div class="col-md-6 col-sm-6">  
                                                    <div class="input-block mb-3">
                                                        <label class="col-form-label">Aadhaar Card
                                                        <?php
                                                            if ($aadhar_card) {
                                                                
                                                        ?>
                                                            <a href="<?php echo '../../uploading/' . $aadhar_card; ?>" download class="ms-3" title="Download">
                                                                <i class="fa fa-download fa-1x" aria-hidden="true"></i>
                                                            </a>
                                                        <?php
                                                            }
                                                        ?>
                                                        </label>
                                                        <input class="form-control" type="file" name="file2" id="upload_file2">
                                                    </div>
                                                    <input type="hidden" id="img_path2" value="<?php echo $aadhar_card;?>">
                                                    <div id="preview2" >
                                                        <div id="image_preview2">
                                                            <?php
                                                                if($aadhar_card ==''){
                                                                    echo '<img src="../../uploading/not_uploaded.png" alt="Preview" id="img_pre2" class="imgSize">';
                                                                }else{
                                                                    echo '<img src="../../uploading/'.$aadhar_card.'" alt="Preview" id="img_pre2" class="imgSize">';?>
                                                                    
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div> 
                                                <div class="col-md-6 col-sm-6">  
                                                    <div class="input-block mb-3">
                                                        <label class="col-form-label">Pan Card
                                                        <?php
                                                            if ($pan_card) {
                                                                
                                                        ?>
                                                            <a href="<?php echo '../../uploading/' . $pan_card; ?>" download class="ms-3" title="Download">
                                                                <i class="fa fa-download fa-1x" aria-hidden="true"></i>
                                                            </a>
                                                        <?php
                                                            }
                                                        ?>
                                                        </label>
                                                        <input class="form-control" type="file"name="file3" id="upload_file3">
                                                    </div>
                                                    <input type="hidden" id="img_path3" value="<?php echo $pan_card;?>">
                                                    <div id="preview3" >
                                                        <div id="image_preview3">
                                                            <?php
                                                                if($pan_card ==''){
                                                                    echo '<img src="../../uploading/not_uploaded.png" alt="Preview" id="img_pre3" class="imgSize">';
                                                                }else{
                                                                    echo '<img src="../../uploading/'.$pan_card.'" alt="Preview" id="img_pre3" class="imgSize">';?>
                                                                    
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div> 
                                                <div class="col-md-6 col-sm-6">  
                                                    <div class="input-block mb-3">
                                                        <label class="col-form-label">Bank Passbook
                                                        <?php
                                                            if ($cancelled_cheque_bank_passbook) {
                                                                
                                                        ?>
                                                            <a href="<?php echo '../../uploading/' . $cancelled_cheque_bank_passbook; ?>" download class="ms-3" title="Download">
                                                                <i class="fa fa-download fa-1x" aria-hidden="true"></i>
                                                            </a>
                                                        <?php
                                                            }
                                                        ?>
                                                        </label>
                                                        <input class="form-control" type="file" name="file4" id="upload_file4">
                                                    </div>
                                                    <input type="hidden" id="img_path4" value="<?php echo $cancelled_cheque_bank_passbook;?>">
                                                    <div id="preview3" >
                                                        <div id="image_preview4">
                                                            <?php
                                                                if($cancelled_cheque_bank_passbook ==''){
                                                                    echo '<img src="../../uploading/not_uploaded.png" alt="Preview" id="img_pre4" class="imgSize">';
                                                                }else{
                                                                    echo '<img src="../../uploading/'.$cancelled_cheque_bank_passbook.'" alt="Preview" id="img_pre4" class="imgSize">';?>
                                                                   
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div> 
                                                <div class="col-md-6 col-sm-6">  
                                                    <div class="input-block mb-3">
                                                        <label class="col-form-label">Resume / CV
                                                        <?php
                                                            if ($resume_cv) {
                                                                
                                                        ?>
                                                            <a href="<?php echo '../../uploading/' . $resume_cv; ?>" download class="ms-3" title="Download">
                                                                <i class="fa fa-download fa-1x" aria-hidden="true"></i>
                                                            </a>
                                                        <?php
                                                            }
                                                        ?>
                                                        </label>
                                                        <input class="form-control" type="file" name="file5" id="upload_file5">
                                                    </div>
                                                    <input type="hidden" id="img_path5" value="<?php echo $resume_cv;?>">
                                                    <div id="preview3" >
                                                        <div id="image_preview5">
                                                            <?php
                                                                if($resume_cv ==''){
                                                                    echo '<img src="../../uploading/not_uploaded.png" alt="Preview" id="img_pre5" class="imgSize">';
                                                                }else{
                                                                    echo '<img src="../../uploading/'.$resume_cv.'" alt="Preview" id="img_pre5" class="imgSize">';?>
                                                                    
                                                            <?php } ?>
                                                            
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-sm-6">  
                                                    <div class="input-block mb-3">
                                                        <label class="col-form-label">Address Proof
                                                        <?php
                                                            if ($address_proof) {
                                                                
                                                        ?>
                                                            <a href="<?php echo '../../uploading/' . $address_proof; ?>" download class="ms-3" title="Download">
                                                                <i class="fa fa-download fa-1x" aria-hidden="true"></i>
                                                            </a>
                                                        <?php
                                                            }
                                                        ?>
                                                        </label>
                                                        <input class="form-control" type="file" name="file6" id="upload_file6">
                                                    </div>
                                                    <input type="hidden" id="img_path6" value="<?php echo $address_proof;?>">
                                                    <div id="preview3" >
                                                        <div id="image_preview6">
                                                            <?php
                                                                if($address_proof ==''){
                                                                    echo '<img src="../../uploading/not_uploaded.png" alt="Preview" id="img_pre6" class="imgSize">';
                                                                }else{
                                                                    echo '<img src="../../uploading/'.$address_proof.'" alt="Preview" id="img_pre6" class="imgSize">';?>
                                                                    
                                                            <?php } ?>
                                                            
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-sm-6">  
                                                    <div class="input-block mb-3">
                                                        <label class="col-form-label">Professional Profile
                                                        <?php
                                                            if ($professional_profile) {
                                                                
                                                        ?>
                                                            <a href="<?php echo '../../uploading/' . $professional_profile; ?>" download class="ms-3" title="Download">
                                                                <i class="fa fa-download fa-1x" aria-hidden="true"></i>
                                                            </a>
                                                        <?php
                                                            }
                                                        ?>
                                                        </label>
                                                        <input class="form-control" type="file" name="file7" id="upload_file7">
                                                    </div>
                                                    <input type="hidden" id="img_path7" value="<?php echo $professional_profile;?>">
                                                    <div id="preview3" >
                                                        <div id="image_preview7">
                                                            <?php
                                                                if($professional_profile ==''){
                                                                    echo '<img src="../../uploading/not_uploaded.png" alt="Preview" id="img_pre7" class="imgSize">';
                                                                }else{
                                                                    echo '<img src="../../uploading/'.$professional_profile.'" alt="Preview" id="img_pre7" class="imgSize">';?>
                                                                    
                                                            <?php } ?>
                                                            
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-sm-6">  
                                                    <div class="input-block mb-3">
                                                        <label class="col-form-label">Business Profile
                                                        <?php
                                                            if ($business_profile) {
                                                                
                                                        ?>
                                                            <a href="<?php echo '../../uploading/' . $business_profile; ?>" download class="ms-3" title="Download">
                                                                <i class="fa fa-download fa-1x" aria-hidden="true"></i>
                                                            </a>
                                                        <?php
                                                            }
                                                        ?>
                                                        </label>
                                                        <input class="form-control" type="file" name="file8" id="upload_file8">
                                                    </div>
                                                    <input type="hidden" id="img_path8" value="<?php echo $business_profile;?>">
                                                    <div id="preview3" >
                                                        <div id="image_preview8">
                                                            <?php
                                                                if($business_profile ==''){
                                                                    echo '<img src="../../uploading/not_uploaded.png" alt="Preview" id="img_pre8" class="imgSize">';
                                                                }else{
                                                                    echo '<img src="../../uploading/'.$business_profile.'" alt="Preview" id="img_pre8" class="imgSize">';?>
                                                                    
                                                            <?php } ?>
                                                            
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-sm-6">  
                                                    <div class="input-block mb-3">
                                                        <label class="col-form-label">Income Proof
                                                        <?php
                                                            if ($income_proof) {
                                                                
                                                        ?>
                                                            <a href="<?php echo '../../uploading/' . $income_proof; ?>" download class="ms-3" title="Download">
                                                                <i class="fa fa-download fa-1x" aria-hidden="true"></i>
                                                            </a>
                                                        <?php
                                                            }
                                                        ?>
                                                        </label>
                                                        <input class="form-control" type="file" name="file9" id="upload_file9">
                                                    </div>
                                                    <input type="hidden" id="img_path9" value="<?php echo $income_proof;?>">
                                                    <div id="preview3" >
                                                        <div id="image_preview9">
                                                            <?php
                                                                if($income_proof ==''){
                                                                    echo '<img src="../../uploading/not_uploaded.png" alt="Preview" id="img_pre9" class="imgSize">';
                                                                }else{
                                                                    echo '<img src="../../uploading/'.$income_proof.'" alt="Preview" id="img_pre9" class="imgSize">';?>
                                                                    
                                                            <?php } ?>
                                                            
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-sm-6">  
                                                    <div class="input-block mb-3">
                                                        <label class="col-form-label">Other Document
                                                        <?php
                                                            if ($other_document) {
                                                                
                                                        ?>
                                                            <a href="<?php echo '../../uploading/' . $other_document; ?>" download class="ms-3" title="Download">
                                                                <i class="fa fa-download fa-1x" aria-hidden="true"></i>
                                                            </a>
                                                        <?php
                                                            }
                                                        ?>
                                                        </label>
                                                        <input class="form-control" type="file" name="file10" id="upload_file10">
                                                    </div>
                                                    <input type="hidden" id="img_path10" value="<?php echo $other_document;?>">
                                                    <div id="preview3" >
                                                        <div id="image_preview10">
                                                            <?php
                                                                if($other_document ==''){
                                                                    echo '<img src="../../uploading/not_uploaded.png" alt="Preview" id="img_pre10" class="imgSize">';
                                                                }else{
                                                                    echo '<img src="../../uploading/'.$other_document.'" alt="Preview" id="img_pre10" class="imgSize">';?>
                                                                    
                                                            <?php } ?>
                                                            
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                            </div>

                                            <!-- for edit data page -->
                                            <input type="hidden" id="ref_id" name="ref_id" value="<?php echo $reference_no;?>"> <!--CBD240001 -->
                                            <input type="hidden" id="editfor" name="editfor" value="<?php echo $editfor;?>"> <!--registered -->
                                            <input type="hidden" id="id" name="id" value="<?php echo $id;?>"> <!--BM250001 -->
                                            <input type="hidden" id="registered" name="registered" value="<?php echo $usertype;?>"> <!--BM250001 -->
                                            <input type="hidden" id="testValue" name="testValue" value="<?php echo $testValue; ?>"> <!-- Business mentor -->
                                            <input type="hidden" id="applicationId" name="applicationId" value="<?php echo $application_id; ?>"> <!-- applicationId will be use to update multiple tables for CTE,ETE,STE -->

                                            <div class="submit-section d-flex justify-content-center mb-4">
                                                <button class="btn btn-primary submit-btn submit-btn1 px-5 py-2" id="editChiefTechnoEnterprise">Submit</button>
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


                <?php include_once "../footer.php" ?>
            </div>
            <!-- end main content-->

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

        <!-- edit data to database js file -->
        <script type="text/javascript" src="chief_techno_enterprise.js"></script>

        <!-- apexcharts -->
        <!-- <script src="../assets/libs/apexcharts/apexcharts.min.js"></script> -->

        <!-- dashboard init -->
        <!-- <script src="assets/js/pages/dashboard.init.js"></script> -->

        <!-- App js -->
        <script src="../assets/js/app.js"></script>

        <!-- upload js file made only for CTE,ETE and STE users -->
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

            $(document).ready(function(){
                var registered = $("#registered").val();
                if(registered == 'bm'){
                    // $('#designation1').prop('disabled',false);
                    // $('#designation1').removeClass('d-none');
                    // $('#designation2').addClass('d-none');
                    // $('#payment_fee').prop('disabled',false);
                    $('#payment_fee').removeClass('d-none');
                    $('#payment_fee2').addClass('d-none');
                }else if(registered == 'mf'){
                //     $('#designation2').removeClass('d-none');
                //     $('#designation2').prop('disabled',false);
                //     $('#designation1').addClass('d-none');
                    $('#payment_fee').addClass('d-none');
                    $('#payment_fee2').removeClass('d-none');
                }else if(registered == 'sf'){
                    // $('#designation1').prop('disabled',true);
                    // $('#designation2').prop('disabled',true);
                    $('#payment_fee').addClass('d-none');
                    $('#payment_fee2').removeClass('d-none');
                }else if(registered == 'ete'){
                    $('#payment_fee').removeClass('d-none');
                    $('#payment_fee2').addClass('d-none');
                }
                
                var paymentMode = $(".payment:checked").val();
                if(paymentMode == "cheque"){
                    $("#chequeOpt").removeClass("d-none");
                    $("#onlineOpt").addClass("d-none");
                }else if(paymentMode == "online"){
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
                // console.log(designation);
                $.ajax({
                    type:'POST',
                    url:'../agents/get_user_Franchisee.php',
                    data: "designation="+designation,
                    success:function (e) {
                        // console.log(e);
                        $('#user_id_name').html(e); 
                    },
                    error: function(err){
                        console.log(err);
                    },
                });
            });

            // fetch User based on selected designation
            $('#user_id_name').on('change', function(){
                var user_id_name = $(this).val();
                var designation = $('#designation').val();
                // console.log(user_id_name);

                // var designation = $('#designation').val();
                // console.log(designation);

                $.ajax({
                    type:'POST',
                    url:'../agents/getUsers.php',
                    data: 'user_id_name=' + user_id_name + '&designation=' + designation ,
                    success:function(response){
                    // console.log(response);
                        $('#pin').html(response);
                        $('#reference_name').val(response); 
                    }
                }); 
               
            }); 

            $('#country').on('change', function(){
                var countryID = $(this).val();
                if(countryID){
                    $.ajax({
                        type:'POST',
                        url:'../address/countrydata.php',
                        data:'country_id='+countryID,
                        success:function(htmll){
                            $('#mystate').html(htmll); 
                            $('#city').html('<option value="">Select state first</option>'); 
                        }
                    }); 
                }else{
                    $('#mystate').html('<option value="">Select country first</option>');
                    $('#city').html('<option value="">Select state first</option>');
                    $('#pin').val('');   
                }
            });
                
            $('#mystate').on('change', function(){
                // alert();
                var stateID = $(this).val();
                if(stateID){
                    $.ajax({
                        type:'POST',
                        url:'../address/countrydata.php',
                        data:'state_id='+stateID,
                        success:function(html){
                            $('#city').html(html);
                        }
                    }); 
                }else{
                    $('#city').html('<option value="">Select state first</option>');
                    $('#pin').val('');   
                }
            });

            $('#city').on('change', function(){
                var cityID = $(this).val();
                if(cityID){
                    $.ajax({
                        type:'POST',
                        url:'../address/pincode.php',
                        data:'city_id='+cityID,
                        success:function(response){
                            // $('#pin').html(response);
                            $('#pin').val(response); 
                        }
                    }); 
                }else{
                    $('#city').html('<option value="">Select state first</option>');
                    $('#pin').val('');
                }
            });
            
            //to hide show payment sections
            $('#payment_fee').on('change', function(){
                var paytype=$('#payment_fee').val();
                if (paytype !='FOC') {
                    $('#paymentModeBlock').removeClass("d-none"); 
                    $('#payProof').removeClass("d-none"); 
                }else {
                    $('#paymentModeBlock').addClass("d-none"); 
                    $('#payProof').addClass("d-none"); 
                }
            });
            //to hide show payment sections
            $('#payment_fee2').on('change', function(){
                var paytype=$('#payment_fee2').val();
                if (paytype !='FOC') {
                    $('#paymentModeBlock').removeClass("d-none"); 
                    $('#payProof').removeClass("d-none"); 
                }else {
                    $('#paymentModeBlock').addClass("d-none"); 
                    $('#payProof').addClass("d-none"); 
                }
            });
            //payment details
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

            $("#lead6").change(function () {

                if ($(this).is(":checked")) {
                    $("#otherLead").slideDown();
                } else {
                    $("#otherLead").slideUp();
                    $("#otherLead").val("");
                }

            });
        </script>
    </body>

</html>