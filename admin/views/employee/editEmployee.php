<?php
session_start();

if (!isset($_SESSION['username'])) {
    echo '<script>location.href = "../../login.php";</script>';
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
<?php include '../../models/employee/edit_employee.php' ?>

<head>

    <meta charset="utf-8" />
    <title>Edit Employee | Admin Dashboard </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- App favicon -->
    <link rel="shortcut icon" href="../../assets/images/fav.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- Bootstrap Css -->
    <link href="../../assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="../../assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="../../assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />
    <!-- Loading Screen and Images size css  -->
    <link rel="stylesheet" href="../../assets/css/loadingScreen.css" rel="stylesheet" type="text/css" />

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
                                <h4 class="mb-sm-0 font-size-18">Employee / Zonal Manager</h4>
                            </div>
                        </div>
                    </div>

                    <!-- add customer form start -->
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <form>
                                        <h3>Edit Employee / Zonal Manager</h3>
                                        <div class="row" id="formParent">
                                            <!-- Personal Details -->
                                            <h4 class="my-2">Personal Details</h4>
                                            <div class="col-md-6 col-sm-6">
                                                <div class="input-block mb-3">
                                                    <label class="col-form-label">Full Name <span class="text-danger">*</span></label>
                                                    <input class="form-control" type="text" id="fullName" value="<?php echo $name; ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-6">
                                                <div class="input-block mb-3">
                                                    <label class="col-form-label">Date of Birth <span class="text-danger">*</span></label>
                                                    <input class="form-control" type="date" id="birth_date" value="<?php echo $date_of_birth; ?>" max="<?php echo $ageLimit; ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-12 mb-3">
                                                <div class="row">
                                                    <div class="col-md-4 col-sm-4 col-3">
                                                        <div class="input-block">
                                                            <?php
                                                            require '../../connect.php';
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
                                                    <div class="col-md-8 col-sm-8 col-9">
                                                        <div class="input-block">
                                                            <label class="col-form-label">Contact Number <span class="text-danger">*</span></label>
                                                            <input class="form-control" type="number" id="contact" value="<?php echo $contact; ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-6">
                                                <div class="input-block mb-3">
                                                    <label class="col-form-label">Email <span class="text-danger">*</span></label>
                                                    <input class="form-control" type="email" id="email" value="<?php echo $email; ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-6">
                                                <div class="input-block mb-3">
                                                    <label class="col-form-label">Address <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" id="address" value="<?php echo $address; ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-12">
                                                <div class="form-group">
                                                    <label class="col-form-label">Gender <span class="text-danger">*</span></label>
                                                    <div class="form-control d-flex justify-content-around">
                                                        <label class="radio-inline mb-0 ms-3"><input type="radio" name="gender" class="gender form-check-input" id="test1" value="male" <?php if ($gender == "male") {
                                                                                                                                                                            echo "checked";
                                                                                                                                                                        } ?>>&nbsp;&nbsp;&nbsp;Male</label>
                                                        <label class="radio-inline mb-0 ms-3"><input type="radio" name="gender" class="gender form-check-input" id="test2" value="female" <?php if ($gender == "female") {
                                                                                                                                                                                echo "checked";
                                                                                                                                                                            } ?>>&nbsp;&nbsp;&nbsp;Female</label>
                                                        <label class="radio-inline mb-0 ms-3"><input type="radio" name="gender" class="gender form-check-input" id="test3" value="others" <?php if ($gender == "others") {
                                                                                                                                                                                echo "checked";
                                                                                                                                                                            } ?>>&nbsp;&nbsp;&nbsp;Other</label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-12 col-sm-12" id="emp_block">
                                                <div class="row" id="employee">
                                                    <!-- Employment Details -->
                                                    <h4 class="my-2">Employment Details</h4>
                                                    <div class="col-md-6 col-sm-6">
                                                        <div class="input-block mb-3">
                                                            <label class="col-form-label">Joining Date <span class="text-danger">*</span></label>
                                                            <input class="form-control" type="date" id="joining_date" value="<?php echo $date_of_joining; ?>" max="<?php echo $today; ?>" min="<?php echo $ageLimit; ?> ">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-sm-6">
                                                        <div class="input-block mb-3">
                                                            <label class="col-form-label">Department <span class="text-danger">*</span></label>
                                                            <select class="form-select" id="department">
                                                                <option value="<?php echo $dept; ?>"><?php echo $departmentname . ' (Already Selected)'; ?></option>
                                                                <!-- data load from models file -->
                                                                <?php include '../../models/common_models/department.php' ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-sm-6">
                                                        <div class="input-block mb-3">
                                                            <label class="col-form-label">Designation <span class="text-danger">*</span></label>
                                                            <select class="form-select" id="designation">
                                                                <option value="<?php echo $desig; ?>"><?php echo $designationname . ' (Already Selected)'; ?></option>
                                                                <!-- data load from models file -->
                                                                <?php include '../../models/common_models/designation.php' ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-sm-6">
                                                        <div class="input-block mb-3">
                                                            <label class="col-form-label">Zone <span class="text-danger">*</span></label>
                                                            <select class="form-select" id="zone">
                                                                <option value="<?php echo $zn; ?>"><?php echo $zone_name . ' (Already Selected)'; ?></option>
                                                                <!-- data load from models file -->
                                                                <?php include '../../models/common_models/zones.php' ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-sm-6">
                                                        <div class="input-block mb-3">
                                                            <label class="col-form-label">Branch <span class="text-danger">*</span></label>
                                                            <select class="form-select" id="branch">
                                                                <option value="<?php echo $br; ?>"> <?php echo $branch_name . ' (Already Selected)'; ?> </option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-sm-6">
                                                        <div class="input-block mb-3">
                                                            <label class="col-form-label">Reporting Manager <span class="text-danger">*</span></label>
                                                            <select class="form-select" id="reporting_manager">
                                                                <option value="<?php echo $reporting_manager_id; ?>"> <?php echo $reporting_manager_name . ' (Already Selected)'; ?> </option>
                                                                <!-- data load on models file -->
                                                                <?php include '../../models/common_models/reporting_manager.php' ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <!-- Attachments -->
                                                    <h4 class="my-2">Attachments</h4>
                                                    <div class="col-md-6 col-sm-6 mb-2">
                                                        <div class="input-block mb-3">
                                                            <label class="col-form-label">Profile Picture
                                                                <?php
                                                                    if($profile_pic!='none' && $profile_pic !=''){
                                                                ?>
                                                                <a href="<?php echo '../../../uploading/' . $profile_pic; ?>" download class="ms-3" title="Download">
                                                                        <i class="fa fa-download fa-1x" aria-hidden="true"></i>
                                                                </a>
                                                                <?php
                                                                    }
                                                                ?>
                                                            </label>
                                                            <input class="form-control" type="file" id="profile_pic">
                                                        </div>
                                                        <input type="hidden" id="img_path1" value="<?php echo $profile_pic; ?>">
                                                        <div id="preview1">
                                                            <div id="image_preview1">
                                                                <?php
                                                                if ($profile_pic == '') {
                                                                    echo '<img src="../../../uploading/not_uploaded.png" alt="Preview" id="img_pre1" class="imgSize">';
                                                                } else {
                                                                    echo '<img src="../../../uploading/' . $profile_pic . '" alt="Preview" id="img_pre1" class="imgSize">';?>
                                                                    
                                                            <?php } ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-sm-6 mb-2">
                                                        <div class="input-block mb-3">
                                                            <label class="col-form-label">ID Proof (Aadhaar/PAN/Passport)
                                                                <?php
                                                                    if ($id_proof !='none' && $id_proof !='') {
                                                                ?>
                                                                <a href="<?php echo '../../../uploading/' . $id_proof; ?>" download class="ms-3" title="Download">
                                                                    <i class="fa fa-download fa-1x" aria-hidden="true"></i>
                                                                </a>
                                                                <?php
                                                                    }
                                                                ?>
                                                            </label>
                                                            <input class="form-control" type="file" id="id_proof">
                                                        </div>
                                                        <input type="hidden" id="img_path2" value="<?php echo $id_proof; ?>">
                                                        <div id="preview2">
                                                            <div id="image_preview2">
                                                                <?php
                                                                if ($id_proof == '') {
                                                                    echo '<img src="../../../uploading/not_uploaded.png" alt="Preview" id="img_pre2" class="imgSize">';
                                                                } else {
                                                                    echo '<img src="../../../uploading/' . $id_proof . '" alt="Preview" id="img_pre2" class="imgSize">';?>
                                                                    
                                                            <?php } ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-sm-6 ">
                                                        <div class="input-block mb-3">
                                                            <label class="col-form-label">Bank Details for Salary Transfer
                                                                <?php
                                                                    if ($bank_details !='none' && $bank_details !='') {
                                                                ?>
                                                                <a href="<?php echo '../../../uploading/' . $bank_details; ?>" download class="ms-3" title="Download">
                                                                    <i class="fa fa-download fa-1x" aria-hidden="true"></i>
                                                                </a>
                                                                <?php
                                                                    }
                                                                ?>
                                                            </label>
                                                            <input class="form-control" type="file" id="bank_details">
                                                        </div>
                                                        <input type="hidden" id="img_path3" value="<?php echo $bank_details; ?>">
                                                        <div id="preview3">
                                                            <div id="image_preview3">
                                                                <?php
                                                                    if ($bank_details == '') {
                                                                        echo '<img src="../../../uploading/not_uploaded.png" alt="Preview" id="img_pre3" class="imgSize">';
                                                                    } else {
                                                                        echo '<img src="../../../uploading/' . $bank_details . '" alt="Preview" id="img_pre3" class="imgSize">'; ?>
                                                                        
                                                                <?php } ?>
                                                                    
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12 col-sm-12" id="zm_block">
                                                <div class="row" id="zonal_manager">
                                                    <!-- Zonal Manager Details -->
                                                    <h4 class="my-2">Zonal Manager Details</h4>
                                                    <div class="col-md-6 col-sm-6">
                                                        <div class="input-block mb-3">
                                                            <?php
                                                            $stmt = $conn->prepare("SELECT * FROM countries WHERE status = 1 ORDER BY country_name ASC");
                                                            $stmt->execute();
                                                            $stmt->setFetchMode(PDO::FETCH_ASSOC);
                                                            ?>
                                                            <label class="col-form-label">Country <span class="text-danger">*</span></label>
                                                            <select class="form-select" id="country">
                                                                <option value="">--Select Country--</option>
                                                                <?php
                                                                if ($stmt->rowCount() > 0) {
                                                                    foreach (($stmt->fetchAll()) as $key => $row) {
                                                                        echo '<option value="' . $row['id'] . '"' . ($country_id == $row['id'] ? ' selected' : '') . '>' . $row['country_name'] . ($country_id == $row['id'] ? ' (Already selected)' : '') . '</option>';
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
                                                            <?php
                                                                $stmt = $conn->prepare("SELECT * FROM states WHERE status = 1 ORDER BY state_name ASC");
                                                                $stmt->execute();
                                                                $stmt->setFetchMode(PDO::FETCH_ASSOC);
                                                            ?>
                                                            <label class="col-form-label">State<span class="text-danger">*</span></label>
                                                            <select class="form-select" id="mystate" aria-label="Floating label select example">
                                                                <option value="">--Select country first--</option>
                                                                <?php
                                                                    if ($stmt->rowCount() > 0) {
                                                                        foreach (($stmt->fetchAll()) as $key => $row) {
                                                                            echo '<option value="' . $row['id'] . '"' . ($state_id == $row['id'] ? ' selected' : '') . '>' . $row['state_name'] . ($state_id == $row['id'] ? ' (Already selected)' : '') . '</option>';
                                                                        }
                                                                    } else {
                                                                        echo '<option value="">State not available</option>';
                                                                    }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-sm-6">
                                                        <div class="input-block mb-3">
                                                            <?php
                                                                $stmt = $conn->prepare("SELECT * FROM cities WHERE status = 1 ORDER BY city_name ASC");
                                                                $stmt->execute();
                                                                $stmt->setFetchMode(PDO::FETCH_ASSOC);
                                                            ?>
                                                            <label class="col-form-label">City<span class="text-danger">*</span></label>
                                                            <select class="form-select" id="city" aria-label="Floating label select example">
                                                                <option value="">--Select state first--</option>
                                                                <?php
                                                                    if ($stmt->rowCount() > 0) {
                                                                        foreach (($stmt->fetchAll()) as $key => $row) {
                                                                            echo '<option value="' . $row['id'] . '"' . ($city_id == $row['id'] ? ' selected' : '') . '>' . $row['city_name'] . ($city_id == $row['id'] ? ' (Already selected)' : '') . '</option>';
                                                                        }
                                                                    } else {
                                                                        echo '<option value="">City not available</option>';
                                                                    }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-sm-6">
                                                        <div class="input-block mb-3">
                                                            <label class="col-form-label">Pincode<span class="text-danger">*</span></label>
                                                            <input type="text" class="form-control" id="pin" placeholder="Pincode" readonly value="<?=$pincode?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-sm-6">
                                                        <div class="input-block mb-3">
                                                            <?php
                                                                $stmt = $conn->prepare("SELECT * FROM zonal WHERE status = 1 ORDER BY zone ASC");
                                                                $stmt->execute();
                                                                $stmt->setFetchMode(PDO::FETCH_ASSOC);
                                                            ?>
                                                            <label class="col-form-label">Zone<span class="text-danger">*</span></label>
                                                            <select class="form-select" id="zonal" aria-label="Floating label select example">
                                                                <option value="">--Select state first--</option>
                                                                <?php
                                                                    if ($stmt->rowCount() > 0) {
                                                                        foreach (($stmt->fetchAll()) as $key => $row) {
                                                                            echo '<option value="' . $row['id'] . '"' . ($zone_id == $row['id'] ? ' selected' : '') . '>' . $row['zone'] . ($zone_id == $row['id'] ? ' (Already selected)' : '') . '</option>';
                                                                        }
                                                                    } else {
                                                                        echo '<option value="">Zone not available</option>';
                                                                    }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <!-- Attachments -->
                                                    <h4 class="my-2">Attachments</h4>
                                                    <div class="col-md-6 col-sm-6 mb-2">
                                                        <div class="input-block mb-3">
                                                            <label class="col-form-label">
                                                                Profile Picture
                                                                <?php
                                                                    if($profile_pic!='none' && $profile_pic !=''){
                                                                ?>
                                                                <a href="<?php echo '../../../uploading/' . $profile_pic; ?>" download class="ms-3" title="Download">
                                                                        <i class="fa fa-download fa-1x" aria-hidden="true"></i>
                                                                </a>
                                                                <?php
                                                                    }
                                                                ?>
                                                            </label>
                                                            <input class="form-control" type="file" id="profile_pic">
                                                        </div>
                                                        <input type="hidden" id="img_path1" value="<?php echo $profile_pic; ?>">
                                                        <div id="preview1">
                                                            <div id="image_preview1">
                                                                <?php
                                                                if ($profile_pic == '') {
                                                                    echo '<img src="../../../uploading/not_uploaded.png" alt="Preview" id="img_pre1" class="imgSize">';
                                                                } else {
                                                                    echo '<img src="../../../uploading/' . $profile_pic . '" alt="Preview" id="img_pre1" class="imgSize">';?>
                                                                    
                                                            <?php } ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-sm-6">
                                                        <div class="input-block mb-3">
                                                            <label class="col-form-label">Aadhaar Card
                                                                 <?php
                                                                    if ($aadhar_card !='none' && $aadhar_card !='') {
                                                                ?>
                                                                <a href="<?php echo '../../../uploading/' . $aadhar_card; ?>" download class="ms-3" title="Download">
                                                                    <i class="fa fa-download fa-1x" aria-hidden="true"></i>
                                                                </a>
                                                                <?php
                                                                    }
                                                                ?>
                                                            </label>
                                                            <input class="form-control" type="file" name="file2" id="upload_file2">
                                                        </div>
                                                        <input type="hidden" id="img_path2" value="<?=$aadhar_card?>">
                                                        <div id="preview2">
                                                            <?php
                                                                if ($aadhar_card == '') {
                                                                    echo '<img src="../../../uploading/not_uploaded.png" alt="Preview" id="img_pre2" class="imgSize">';
                                                                } else {
                                                                    echo '<img src="../../../uploading/' . $aadhar_card . '" alt="Preview" id="img_pre2" class="imgSize">'; ?>
                                                                    
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-sm-6">
                                                        <div class="input-block mb-3">
                                                            <label class="col-form-label">Pan Card
                                                                <?php
                                                                    if ($pan_card !='none' && $pan_card !='') {
                                                                ?>
                                                                <a href="<?php echo '../../../uploading/' . $pan_card; ?>" download class="ms-3" title="Download">
                                                                    <i class="fa fa-download fa-1x" aria-hidden="true"></i>
                                                                </a>
                                                                <?php
                                                                    }
                                                                ?>
                                                            </label>
                                                            <input class="form-control" type="file" name="file3" id="upload_file3">
                                                        </div>
                                                        <input type="hidden" id="img_path3" value="<?=$pan_card?>">
                                                        <div id="preview3">
                                                            <div id="image_preview3">
                                                            <?php
                                                                if ($pan_card == '') {
                                                                    echo '<img src="../../../uploading/not_uploaded.png" alt="Preview" id="img_pre3" class="imgSize">';
                                                                } else {
                                                                    echo '<img src="../../../uploading/' . $pan_card . '" alt="Preview" id="img_pre3" class="imgSize">'; ?>
                                                                    
                                                            <?php } ?>
                                                                
                                                        </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="col-md-6 col-sm-6 ">
                                                    <div class="input-block mb-3">
                                                        <label class="col-form-label">Bank Details
                                                            <?php
                                                                if ($bank_details !='none' && $bank_details !='') {
                                                            ?>
                                                            <a href="<?php echo '../../../uploading/' . $bank_details; ?>" download class="ms-3" title="Download">
                                                                <i class="fa fa-download fa-1x" aria-hidden="true"></i>
                                                            </a>
                                                            <?php
                                                                }
                                                            ?>
                                                        </label>
                                                        <input class="form-control" type="file" id="bank_details">
                                                    </div>
                                                    <input type="hidden" id="img_path4" value="<?php echo $bank_details; ?>">
                                                    <div id="preview3">
                                                        <div id="image_preview4">
                                                            <?php
                                                                if ($bank_details == '') {
                                                                    echo '<img src="../../../uploading/not_uploaded.png" alt="Preview" id="img_pre4" class="imgSize">';
                                                                } else {
                                                                    echo '<img src="../../../uploading/' . $bank_details . '" alt="Preview" id="img_pre4" class="imgSize">'; ?>
                                                                    
                                                            <?php } ?>
                                                                
                                                        </div>
                                                    </div>
                                                </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12 col-sm-12">
                                                <div class="input-block mb-3 mt-2">
                                                    <label class="col-form-label" for="flex_amount">Extra Notes<span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" id="note" placeholder="Enter Note" value="<?php echo $note; ?>">
                                                </div>
                                            </div>

                                        </div>
                                        <!-- for edit data page -->
                                        <input type="hidden" id="empID" name="empID" value="<?php echo $id; ?>"> <!-- Emp ID edit ref -->
                                        <input type="hidden" id="testValue" name="testValue" value="2425"> <!-- BCM/BDM -->
                                        <input type="hidden" id="ref_id" name="ref_id" value="<?php echo $reference_no; ?>">
                                        <input type="hidden" id="editfor" name="editfor" value="<?php echo $editfor; ?>">
                                        <input type="hidden" id="registered" name="registered" value="<?php echo $usertype; ?>">
                                        <div class="submit-section d-flex justify-content-center mb-4">
                                            <button class="btn btn-primary submit-btn submit-btn1 px-5 py-2" id="edit_employee">Submit</button>
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


            <?php include_once "../../footer.php" ?>
        </div>
        <!-- end main content-->

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

    <!-- ** designation user, user name on designation select / get country, state, city, pincode **  -->
    <script src="../../resources/employee/edit_employee_custom.js"></script>
</body>

</html>