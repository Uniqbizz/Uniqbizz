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

$id = $_GET['vkvbvjfgfikix'];
$user_id = $_GET['fyfyfregby'];
$reference_no = $_GET['nohbref'];
$dept = $_GET['dept'];
$desig = $_GET['desig'];
$zn = $_GET['zn'];
$br = $_GET['br'];

$editfor = $_GET['editfor'];

if ($editfor == 'pending') {
    // $identifier_id= $_POST["vkvbvjfgfikix"];
    $identifier_name = 'id=';
} else if ($editfor == 'registered') {
    // $identifier_id= $_POST["vkvbvjfgfikix"];
    $identifier_name = 'employee_id=';
}

$stmt = $conn->prepare("SELECT * FROM `employees` where employee_id='" . $id . "' OR id = '" . $id . "'");
$stmt->execute();
// set the resulting array to associative
$stmt->setFetchMode(PDO::FETCH_ASSOC);

if ($stmt->rowCount() > 0) {
    foreach (($stmt->fetchAll()) as $key => $row) {
        $fid = $row['id'];
        $name = $row['name'];
        $email = $row['email'];
        $contact = $row['contact'];
        $reporting_manager_id = $row['reporting_manager'];
        $date_of_birth = $row['date_of_birth'];
        $date_of_joining = $row['date_of_joining'];
        $gender = $row['gender'];
        $department = $row['department'];
        $designation = $row['designation'];
        $zone = $row['zone'];
        $branch = $row['branch'];
        $address = $row['address'];
        $profile_pic = $row['profile_pic'];
        $id_proof = $row['id_proof'];
        $bank_details = $row['bank_details'];
        $register_by = $row['register_by'];
        $user_type = $row['user_type'];
        $register_date = $row['register_date'];
        $note = $row['note'];

        //get country
        $departments = $conn->prepare("SELECT dept_name FROM department where id='" . $dept . "' and status='1' ");
        $departments->execute();
        $departments->setFetchMode(PDO::FETCH_ASSOC);
        if ($departments->rowCount() > 0) {
            $department = $departments->fetch();
            $departmentname = $department['dept_name'];
        }

        //get state
        $designations = $conn->prepare("SELECT designation_name FROM designation where id='" . $desig . "' and status='1' ");
        $designations->execute();
        $designations->setFetchMode(PDO::FETCH_ASSOC);
        if ($designations->rowCount() > 0) {
            $designation = $designations->fetch();
            $designationname = $designation['designation_name'];
        }
        //get city
        $zones = $conn->prepare("SELECT zone_name FROM zone where id='" . $zn . "' and status='1' ");
        $zones->execute();
        $zones->setFetchMode(PDO::FETCH_ASSOC);
        if ($zones->rowCount() > 0) {
            $zone = $zones->fetch();
            $zone_name = $zone['zone_name'];
        }

        //get city
        $branchs = $conn->prepare("SELECT branch_name FROM branch where id='" . $br . "' and status='1' ");
        $branchs->execute();
        $branchs->setFetchMode(PDO::FETCH_ASSOC);
        if ($branchs->rowCount() > 0) {
            $branch = $branchs->fetch();
            $branch_name = $branch['branch_name'];
        }

        //get city
        $employees = $conn->prepare("SELECT name FROM employees where employee_id='" . $reference_no . "' and status='1' ");
        $employees->execute();
        $employees->setFetchMode(PDO::FETCH_ASSOC);
        if ($employees->rowCount() > 0) {
            $employee = $employees->fetch();
            $employee_name = $employee['name'];
        }

        // Get Reporting Manager Name
        if ($reporting_manager_id == 'null') {
            $reporting_manager_name = 'Not Selected';
        } else {
            $reporting_managers = $conn->prepare("SELECT * FROM employees WHERE employee_id = :reporting_manager");
            $reporting_managers->execute(['reporting_manager' => $reporting_manager_id]);
            $reporting_managers->setFetchMode(PDO::FETCH_ASSOC);
            if ($reporting_managers->rowCount() > 0) {
                $reporting_manager = $reporting_managers->fetch();
                $reporting_manager_name = $reporting_manager['name'];
            }
        }
    }
}

?>

<head>

    <meta charset="utf-8" />
    <title>Edit Employee | Admin Dashboard </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- App favicon -->
    <link rel="shortcut icon" href="../assets/images/fav.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

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
                                <h4 class="mb-sm-0 font-size-18">Employee</h4>
                            </div>
                        </div>
                    </div>

                    <!-- add customer form start -->
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <form>
                                        <h3>Edit Employee</h3>
                                        <div class="row">
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
                                                            require '../connect.php';
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
                                                        <?php
                                                        require '../connect.php';
                                                        $sql = "SELECT * FROM `department` WHERE status ='1' ";
                                                        $stmt = $conn->prepare($sql);
                                                        $stmt->execute();
                                                        $stmt->setFetchMode(PDO::FETCH_ASSOC);
                                                        if ($stmt->rowCount() > 0) {
                                                            foreach (($stmt->fetchAll()) as $key => $row) {
                                                                echo '
                                                                            <option value="' . $row['id'] . '">' . $row['dept_name'] . '</option>
                                                                        ';
                                                            }
                                                        } else {
                                                            echo '<option value="">Department not available</option>';
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-6">
                                                <div class="input-block mb-3">
                                                    <label class="col-form-label">Designation <span class="text-danger">*</span></label>
                                                    <select class="form-select" id="designation">
                                                        <option value="<?php echo $desig; ?>"><?php echo $designationname . ' (Already Selected)'; ?></option>
                                                        <?php
                                                        require '../connect.php';
                                                        $sql = "SELECT * FROM `designation` WHERE status ='1' ";
                                                        $stmt = $conn->prepare($sql);
                                                        $stmt->execute();
                                                        $stmt->setFetchMode(PDO::FETCH_ASSOC);
                                                        if ($stmt->rowCount() > 0) {
                                                            foreach (($stmt->fetchAll()) as $key => $row) {
                                                                echo '
                                                                            <option value="' . $row['id'] . '">' . $row['designation_name'] . '</option>
                                                                        ';
                                                            }
                                                        } else {
                                                            echo '<option value="">Designation not available</option>';
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-6 col-sm-6">
                                                <div class="input-block mb-3">
                                                    <label class="col-form-label">Zone <span class="text-danger">*</span></label>
                                                    <select class="form-select" id="zone">
                                                        <option value="<?php echo $zn; ?>"><?php echo $zone_name . ' (Already Selected)'; ?></option>
                                                        <?php
                                                        require '../connect.php';
                                                        $sql = "SELECT * FROM `zone` WHERE status ='1' ";
                                                        $stmt = $conn->prepare($sql);
                                                        $stmt->execute();
                                                        $stmt->setFetchMode(PDO::FETCH_ASSOC);
                                                        if ($stmt->rowCount() > 0) {
                                                            foreach (($stmt->fetchAll()) as $key => $row) {
                                                                echo '
                                                                            <option value="' . $row['id'] . '">' . $row['zone_name'] . '</option>
                                                                        ';
                                                            }
                                                        } else {
                                                            echo '<option value="">Zone not available</option>';
                                                        }
                                                        ?>
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
                                                        <?php
                                                        // require '../connect.php';
                                                        $sql = "SELECT * FROM `employees` WHERE status ='1' ";
                                                        $stmt = $conn->prepare($sql);
                                                        $stmt->execute();
                                                        $stmt->setFetchMode(PDO::FETCH_ASSOC);
                                                        if ($stmt->rowCount() > 0) {
                                                            foreach (($stmt->fetchAll()) as $key => $row) {
                                                                echo '
                                                                                <option value="' . $row['employee_id'] . '">' . $row['name'] . '</option>
                                                                            ';
                                                            }
                                                        } else {
                                                            echo '<option value="">Manager not available</option>';
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <!-- Attachments -->
                                            <h4 class="my-2">Attachments</h4>
                                            <div class="col-md-6 col-sm-6 mb-2">
                                                <div class="input-block mb-3">
                                                    <label class="col-form-label">Profile Picture</label>
                                                    <input class="form-control" type="file" id="profile_pic">
                                                </div>
                                                <input type="hidden" id="img_path1" value="<?php echo $profile_pic; ?>">
                                                <div id="preview1">
                                                    <div id="image_preview1">
                                                        <?php
                                                        if ($profile_pic == '') {
                                                            echo '<img src="../../uploading/not_uploaded.png" alt="Preview" id="img_pre1" class="imgSize">';
                                                        } else {
                                                            echo '<img src="../../uploading/' . $profile_pic . '" alt="Preview" id="img_pre1" class="imgSize">';?>
                                                            <a href="<?php echo '../../uploading/' . $profile_pic; ?>" download class="ms-3" title="Download">
                                                                <i class="fa fa-download fa-1x" aria-hidden="true"></i>
                                                            </a>
                                                    <?php } ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-6 mb-2">
                                                <div class="input-block mb-3">
                                                    <label class="col-form-label">ID Proof (Aadhaar/PAN/Passport)</label>
                                                    <input class="form-control" type="file" id="id_proof">
                                                </div>
                                                <input type="hidden" id="img_path2" value="<?php echo $id_proof; ?>">
                                                <div id="preview2">
                                                    <div id="image_preview2">
                                                        <?php
                                                        if ($id_proof == '') {
                                                            echo '<img src="../../uploading/not_uploaded.png" alt="Preview" id="img_pre2" class="imgSize">';
                                                        } else {
                                                            echo '<img src="../../uploading/' . $id_proof . '" alt="Preview" id="img_pre2" class="imgSize">';?>
                                                            <a href="<?php echo '../../uploading/' . $id_proof; ?>" download class="ms-3" title="Download">
                                                                <i class="fa fa-download fa-1x" aria-hidden="true"></i>
                                                            </a>
                                                    <?php } ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-6 ">
                                                <div class="input-block mb-3">
                                                    <label class="col-form-label">Bank Details for Salary Transfer</label>
                                                    <input class="form-control" type="file" id="bank_details">
                                                </div>
                                                <input type="hidden" id="img_path3" value="<?php echo $bank_details; ?>">
                                                <div id="preview3">
                                                    <div id="image_preview3">
                                                        <?php
                                                            if ($bank_details == '') {
                                                                echo '<img src="../../uploading/not_uploaded.png" alt="Preview" id="img_pre3" class="imgSize">';
                                                            } else {
                                                                echo '<img src="../../uploading/' . $bank_details . '" alt="Preview" id="img_pre3" class="imgSize">'; ?>
                                                                <a href="<?php echo '../../uploading/' . $bank_details; ?>" download class="ms-3" title="Download">
                                                                    <i class="fa fa-download fa-1x" aria-hidden="true"></i>
                                                                </a>
                                                        <?php } ?>
                                                            
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
        // $(document).ready(function(){
        //     var paymentMode = $(".payment:checked").val();
        //     if(paymentMode == "cheque"){
        //         $("#chequeOpt").removeClass("d-none");
        //         $("#onlineOpt").addClass("d-none");
        //     }else if(paymentMode == "online"){
        //         $("#onlineOpt").removeClass("d-none");
        //         $("#chequeOpt").addClass("d-none");
        //     } else {
        //         $("#chequeOpt").addClass("d-none");
        //         $("#onlineOpt").addClass("d-none");
        //     }
        // });
        // //select Designation
        // $('#designation').on('change', function() {
        //     var designation = $('#designation').val();
        //     // console.log(designation);
        //     $.ajax({
        //         type:'POST',
        //         url:'../agents/get_user_Franchisee.php',
        //         data: "designation="+designation,
        //         success:function (e) {
        //             // console.log(e);
        //             $('#user_id_name').html(e); 
        //         },
        //         error: function(err){
        //             console.log(err);
        //         },
        //     });
        // });

        // // fetch User based on selected designation
        // $('#user_id_name').on('change', function(){
        //     var user_id_name = $(this).val();
        //     // console.log(user_id_name);

        //     var designation = $('#designation').val();
        //     // console.log(designation);

        //     $.ajax({
        //         type:'POST',
        //         url:'../agents/getUsers.php',
        //         data: 'user_id_name=' + user_id_name + '&designation=' + designation ,
        //         success:function(response){
        //         // console.log(response);
        //             // $('#pin').html(response);
        //             $('#reference_name').val(response); 
        //         }
        //     }); 

        // }); 

        // $('#country').on('change', function(){
        //     var countryID = $(this).val();
        //     if(countryID){
        //         $.ajax({
        //             type:'POST',
        //             url:'../address/countrydata.php',
        //             data:'country_id='+countryID,
        //             success:function(htmll){
        //                 $('#mystate').html(htmll); 
        //                 $('#city').html('<option value="">Select state first</option>'); 
        //             }
        //         }); 
        //     }else{
        //         $('#mystate').html('<option value="">Select country first</option>');
        //         $('#city').html('<option value="">Select state first</option>');
        //         $('#pin').val('');   
        //     }
        // });

        // $('#mystate').on('change', function(){
        //     // alert();
        //     var stateID = $(this).val();
        //     if(stateID){
        //         $.ajax({
        //             type:'POST',
        //             url:'../address/countrydata.php',
        //             data:'state_id='+stateID,
        //             success:function(html){
        //                 $('#city').html(html);
        //             }
        //         }); 
        //     }else{
        //         $('#city').html('<option value="">Select state first</option>');
        //         $('#pin').val('');   
        //     }
        // });

        // $('#city').on('change', function(){
        //     var cityID = $(this).val();
        //     if(cityID){
        //         $.ajax({
        //             type:'POST',
        //             url:'../address/pincode.php',
        //             data:'city_id='+cityID,
        //             success:function(response){
        //                 // $('#pin').html(response);
        //                 $('#pin').val(response); 
        //             }
        //         }); 
        //     }else{
        //         $('#city').html('<option value="">Select state first</option>');
        //         $('#pin').val('');
        //     }
        // });

        // // $('#business_package_amount').on('change', function(){
        // //     var business_package_amount = $(this).val();
        // //     $('#flex_amount').val(business_package_amount);
        // // });

        // $('#paymentMode').on('click', function(){
        //     var paymentMode = $(".payment:checked").val();
        //     // console.log(paymentMode);
        //     if(paymentMode == "cheque"){
        //         $("#chequeOpt").removeClass("d-none");
        //         $("#onlineOpt").addClass("d-none");
        //     }else if(paymentMode == "online"){
        //         $("#onlineOpt").removeClass("d-none");
        //         $("#chequeOpt").addClass("d-none");
        //     } else {
        //         $("#chequeOpt").addClass("d-none");
        //         $("#onlineOpt").addClass("d-none");
        //     }
        // });

        // select Designation disable Reporting Manager
        $('#designation').on('change', function() {
            var designation = $('#designation').val();
            // console.log(designation);
            if (designation == 1) {
                $('#reporting_manager').prop('disabled', true);
            } else {
                $('#reporting_manager').prop('disabled', false);
            }
        });

        // on zone change get branch associated with that zone
        $('#zone').on('change', function() {
            var zone_id = $(this).val();
            $.ajax({
                url: '../assets/get_data/get_branch.php',
                type: 'POST',
                data: {
                    zone_id: zone_id
                },
                success: function(data) {
                    $('#branch').html(data);
                }
            });
        });
    </script>
</body>

</html>