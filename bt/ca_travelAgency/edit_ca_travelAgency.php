<?php
    session_start();

    if(!isset($_SESSION['username'])){
        echo '<script>location.href = "../login.php";</script>';
    }

    require '../connect.php';
    $date = date('Y'); 

    $id = $_GET['vkvbvjfgfikix'];
    $user_id = $_GET['fyfyfregby'];
    $reference_no = $_GET['nohbref'];
    $country_id = $_GET['ncy'];
    $state_id = $_GET['mst'];
    $city_id = $_GET['hct'];

    $editfor = $_GET['editfor'];

    if($editfor == 'pending'){
        // $identifier_id= $_POST["vkvbvjfgfikix"];
        $identifier_name = 'id=';
    }else if($editfor == 'registered') {
        // $identifier_id= $_POST["vkvbvjfgfikix"];
        $identifier_name = 'ca_travelagency_id=';
    }

    $stmt = $conn->prepare("SELECT * FROM `ca_travelagency` where ca_travelagency_id='".$id."' OR id = '".$id."'");
    $stmt->execute();
    // set the resulting array to associative
    $stmt->setFetchMode(PDO::FETCH_ASSOC);

    if($stmt->rowCount()>0){
        foreach (($stmt->fetchAll()) as $key => $row) {
            $fid=$row['id'];
            // $sales_manager_name=$row['fname'];
            $firstname=$row['firstname'];
            // $username=$row['username'];
            $lastname=$row['lastname'];
            $nominee_name=$row['nominee_name'];
            $nominee_relation=$row['nominee_relation'];
            $email=$row['email'];
            $contact_no=$row['contact_no'];
            // $business_package=$row['business_package'];
            $payment_fee=$row['amount'];
            $reference_no = $row['reference_no'];
            // $gst_no=$row['gst_no'];
            $date_of_birth=$row['date_of_birth'];
            $gender=$row['gender'];
            $country=$row['country'];
            $state=$row['state'];
            $city=$row['city'];
            $address=$row['address'];
            // $id_proof=$row['id_proof'];
            $profile_pic=$row['profile_pic'];
            // $kyc=$row['kyc'];
            $pan_card=$row['pan_card'];
            $aadhar_card=$row['aadhar_card'];
            $voting_card=$row['voting_card'];
            $bank_passbook=$row['passbook'];
            $payment_proof=$row['payment_proof'];
            $payment_mode=$row['payment_mode'];
            $cheque_no=$row['cheque_no'];
            $cheque_date=$row['cheque_date'];
            $bank_name=$row['bank_name'];
            $transaction_no=$row['transaction_no'];
            $pincode=$row['pincode'];
            $note=$row['note'];
            // $complimentary=$row['complimentary'];
            // $converted=$row['converted'];

            //get country
            $countries = $conn->prepare("SELECT country_name FROM countries where id='".$country."' and status='1' ");
            $countries->execute();
            $countries->setFetchMode(PDO::FETCH_ASSOC);
            if($countries->rowCount()>0){
                $country = $countries->fetch();
                $countryname = $country['country_name'];
            }

            //get state
            $states = $conn->prepare("SELECT state_name FROM states where id='".$state."' and status='1' ");
            $states->execute();
            $states->setFetchMode(PDO::FETCH_ASSOC);
            if($states->rowCount()>0){
                $state = $states->fetch();
                $statename = $state['state_name'];
            }
            //get city
            $cities = $conn->prepare("SELECT city_name FROM cities where id='".$city."' and status='1' ");
            $cities->execute();
            $cities->setFetchMode(PDO::FETCH_ASSOC);
            if($cities->rowCount()>0){
                $city = $cities->fetch();
                $city_name = $city['city_name'];
            }

            $reference_id = substr($reference_no, 0 , 2);
            if($reference_id == "BM"){
                // business Mentor name
                $business_mentors = $conn->prepare("SELECT firstname, lastname FROM business_mentor where business_mentor_id='".$reference_no."'");
                $business_mentors ->execute();
                $business_mentors ->setFetchMode(PDO::FETCH_ASSOC);
                if(  $business_mentors->rowCount()>0 ){
                    $business_mentor = $business_mentors->fetch();
                    $reference_no_fname = $business_mentor['firstname'];
                    $reference_no_lname = $business_mentor['lastname'];
                }
            }else if($reference_id == "TE"){
                // corporate agency name
                $corporate_agencys = $conn->prepare("SELECT firstname, lastname FROM corporate_agency where corporate_agency_id='".$reference_no."'");
                $corporate_agencys ->execute();
                $corporate_agencys ->setFetchMode(PDO::FETCH_ASSOC);
                if(  $corporate_agencys->rowCount()>0 ){
                    $corporate_agencys = $corporate_agencys->fetch();
                    $reference_no_fname = $corporate_agencys['firstname'];
                    $reference_no_lname = $corporate_agencys['lastname'];
                }
            }
        }
    }
?>
<!doctype html>
<html lang="en">
    <head>
        
        <meta charset="utf-8" />
        <title>Edit Travel Agency | Admin Dashboard </title>
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
                                    <h4 class="mb-sm-0 font-size-18">Travel Agency</h4>
                                </div>
                            </div>
                        </div>

                        <!-- add Travel Agency form start -->
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <form>
                                            <h3>Edit Travel Agency Form</h3>
                                            <div class="row">
                                                <div class="col-md-6 col-sm-6">
                                                    <div class="input-block mb-3">
                                                        <label class="col-form-label" for="user_id_name">Reference Id<span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" id="user_id_name" placeholder="Enter Reference Id" value="<?php echo $reference_no; ?>" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-sm-6">
                                                    <div class="input-block mb-3">
                                                        <label class="col-form-label" for="reference_name">Reference Full Name<span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" id="reference_name" placeholder="Enter Reference Name" value="<?php echo $reference_no_fname .' '. $reference_no_lname ; ?>" readonly>
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
                                                <div class="col-md-6 col-sm-6">
                                                    <div class="input-block mb-3">
                                                        <label class="col-form-label" for="nominee_name">Nominee Name<span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" id="nominee_name" placeholder="Enter Nominee First Name" value=" <?php echo $nominee_name; ?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-sm-6">
                                                    <div class="input-block mb-3">
                                                        <label class="col-form-label" for="nominee_relation">Nominee Relation<span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" id="nominee_relation" placeholder="Enter Nominee Relation" value=" <?php echo $nominee_relation; ?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-sm-6">
                                                    <div class="input-block mb-3">
                                                        <label class="col-form-label" for="email">Email address<span class="text-danger">*</span></label>
                                                        <input type="email" class="form-control" id="email" placeholder="Enter Email address" value="<?php echo$email;?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-sm-6">
                                                    <div class="input-block mb-3">
                                                        <label class="col-form-label" for="dob">Date of Birth<span class="text-danger">*</span></label>
                                                        <input type="date" id="dob" class=" form-control" placeholder="Enter Date of Birth" value="<?php echo $date_of_birth ;?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-sm-12">
                                                    <div class="form-group">
                                                        <label class="col-form-label">Gender:<span class="text-danger">*</span></label>
                                                        <div class="form-control d-flex justify-content-around">
                                                            <label class="radio-inline mb-0 ms-3"><input class="gender form-check-input" type="radio" name="gender" id="test3" value="male" <?php if ($gender == 'male'){echo ' checked ';} ?>>&nbsp;&nbsp;&nbsp;Male</label>
                                                            <label class="radio-inline mb-0 ms-3"><input class="gender form-check-input" type="radio" name="gender" id="test4" value="female" <?php if ($gender == 'female'){echo ' checked ';} ?>>&nbsp;&nbsp;&nbsp;Female</label>
                                                            <label class="radio-inline mb-0 ms-3"><input class="gender form-check-input" type="radio" name="gender" id="test5" value="others" <?php if ($gender == 'others'){echo ' checked ';} ?>>&nbsp;&nbsp;&nbsp;Others</label>
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
                                                                <label class="col-form-label" for="country_cd">Code:</label>
                                                                <select class="form-select" id="country_cd">
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
                                                                <label class="col-form-label">Phone Number<span class="text-danger">*</span></label>
                                                                <input type="text" class="form-control" id="phone" placeholder="Enter Phone Number" value=" <?php echo $contact_no; ?>">
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
                                                        <label class="col-form-label">Country<span class="text-danger">*</span></label>
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
                                                        <label class="col-form-label" for="mystate">State<span class="text-danger">*</span></label>
                                                        <select class="form-select" id="mystate" aria-label="Floating label select example">
                                                            <option value="<?php echo $state_id;?>"><?php echo $statename.' (Already Selected)' ; ?></option>
                                                            <option value="">--Select country first--</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-sm-6">
                                                    <div class="input-block mb-3">
                                                        <label class="col-form-label" for="city">City<span class="text-danger">*</span></label>
                                                        <select class="form-select" id="city" aria-label="Floating label select example">
                                                            <option value="<?php echo $city_id;?>"><?php echo $city_name.' (Already Selected)' ; ?></option>
                                                            <option value="">--Select state first--</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-sm-6">
                                                    <div class="input-block mb-3">
                                                        <label class="col-form-label" for="pin">Pincode<span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" id="pin" placeholder="Pincode" value="<?php echo $pincode; ?>" readonly >
                                                    </div>
                                                </div>
                                                <div class="col-md-12 col-sm-12">
                                                    <div class="input-block mb-3">
                                                        <label class="col-form-label" for="address">Address<span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" id="address" placeholder="Address" value="<?php echo $address ?>" >
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-sm-6">
                                                    <div class="input-block mb-3">
                                                        <label class="col-form-label" for="payment_fee">Payment Fee<span class="text-danger">*</span></label>
                                                        <select class="form-select" id="payment_fee" aria-label="Floating label select example">
                                                            <option value="null" >--Select Payment Fee--</option> 
                                                            <option value="FOC" <?=$payment_fee=='FOC'?'selected':'' ?>>Free</option>
                                                            <option value="3000" <?=$payment_fee=='3000'?'selected':'' ?>><span>&#8377 </span>3,000/-</option>
                                                            <option value="10000" <?=$payment_fee=='10000'?'selected':'' ?>><span>&#8377 </span>10,000/-</option>
                                                            <!-- <option value="5000"><span>&#8377 </span>5000/-</option>
                                                            <option value="15000"><span>&#8377 </span>15,000/-</option> -->
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-md-6 col-sm-6" id="paymentModeBlock">
                                                    <div class="input-block mb-3">
                                                        <label class="fw-bold col-form-label">Payment Mode: <span class="text-danger">*</span></label>
                                                        <div class="form-control radioBtn d-flex justify-content-around" id="paymentMode">
                                                            <label class="mb-0" for="cashPayment"><input type="radio" id="cashPayment" class="form-check-input payment me-3" name="payment" value="cash" <?php if($payment_mode == "cash") {echo 'checked';} ?> >Cash</label>
                                                            <label class="mb-0" for="chequePayment"><input type="radio" id="chequePayment"  class="form-check-input payment me-3" name="payment" value="cheque" <?php if($payment_mode == "cheque") {echo 'checked';} ?> >Cheque</label>
                                                            <label class="mb-0" for="onlinePayment"><input type="radio" id="onlinePayment"  class="form-check-input payment me-3" name="payment" value="online" <?php if($payment_mode == "online") {echo 'checked';} ?> >UPI/NEFT</label>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="pb-3" id="paymentFields">
                                                    <div class="col-md-12 col-sm-12 d-none" id="chequeOpt">
                                                        <div class="row d-flex justify-content-center">
                                                            <div class="col-md-4 py-1">
                                                                <div class="input-block">
                                                                    <label class="col-form-label" for="chequeNo">Cheque No<span class="text-danger">*</span></label>
                                                                    <input type="text" class="form-control" id="chequeNo" placeholder="Enter Cheque Number" value="<?php echo $cheque_no;?>" >
                                                                </div>
                                                            </div>

                                                            <div class="col-md-4 py-1">
                                                                <div class="input-block">
                                                                    <label class="col-form-label" for="chequeDate">Cheque Date<span class="text-danger">*</span></label>
                                                                    <input type="text" class="form-control" id="chequeDate" placeholder="Enter Date On Cheque" value="<?php echo $cheque_date;?>" >
                                                                </div>
                                                            </div>

                                                            <div class="col-md-4 py-1">
                                                                <div class="input-block">
                                                                    <label class="col-form-label" for="bankName">Bank Name<span class="text-danger">*</span></label>
                                                                    <input type="text" class="form-control" id="bankName" placeholder="Enter your Bank Name" value="<?php echo $bank_name;?>" >
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-12 col-sm-12 d-none" id="onlineOpt" >
                                                        <div class="row d-flex justify-content-center">
                                                            <div class="col-lg-8">
                                                                <div class="input-block">
                                                                    <label class="col-form-label" for="transactionNo">Transaction No.<span class="text-danger">*</span></label>
                                                                    <input type="text" class="form-control" id="transactionNo" placeholder="Enter your Transaction No." value="<?php echo $transaction_no;?>" >
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Attachments -->
                                                <h4 class="my-2">Attachments</h4>
                                                <div class="col-md-6 col-sm-6">
                                                    <div class="mb-3">
                                                        <label class="col-form-label">
                                                            <b>Profile Picture</b>
                                                            <?php
                                                                if($profile_pic !=''){
                                                            ?>
                                                            <a href="<?php echo '../../uploading/' . $profile_pic; ?>" download class="ms-3" title="Download">
                                                                <i class="fa fa-download fa-1x" aria-hidden="true"></i>
                                                            </a>
                                                            <?php
                                                                }
                                                            ?>
                                                        </label><br/>
                                                        <input class="form-control" type="file" name="file1" id="upload_file1">
                                                    </div>
                                                    <input type="hidden" id="img_path1" value="<?php echo $profile_pic;?>">
                                                    <div id="preview1" >
                                                        <div id="image_preview1">
                                                            <?php
                                                                if($profile_pic ==''){
                                                                    echo '<img src="../../uploading/not_uploaded.png" alt="Preview" id="img_pre1">';
                                                                }else{
                                                                    echo '<img src="../../uploading/'.$profile_pic.'" alt="Preview" id="img_pre1">';?>
                                                                    
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-sm-6">
                                                    <div class="mb-3">
                                                        <label class="col-form-label">
                                                            <b>Aadhaar Card</b>
                                                            <?php
                                                                if($aadhar_card !=''){
                                                            ?>
                                                            <a href="<?php echo '../../uploading/' . $aadhar_card; ?>" download class="ms-3" title="Download">
                                                                <i class="fa fa-download fa-1x" aria-hidden="true"></i>
                                                            </a>
                                                            <?php
                                                                }
                                                            ?>
                                                        </label><br/>
                                                        <input class="form-control" type="file" name="file2" id="upload_file2">
                                                    </div>
                                                    <input type="hidden" id="img_path2" value="<?php echo $aadhar_card;?>">
                                                    <div id="preview2">
                                                        <div id="image_preview2">
                                                            <?php
                                                                if($aadhar_card ==''){
                                                                    echo '<img src="../../uploading/not_uploaded.png" alt="Preview" id="img_pre2">';
                                                                }else{
                                                                    echo '<img src="../../uploading/'.$aadhar_card.'" alt="Preview" id="img_pre2">';?>
                                                                    
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-sm-6">
                                                    <div class="mb-3">
                                                        <label class="col-form-label">
                                                            <b>Pan Card</b>
                                                            <?php
                                                                if($pan_card !=''){
                                                            ?>
                                                            <a href="<?php echo '../../uploading/' . $pan_card; ?>" download class="ms-3" title="Download">
                                                                <i class="fa fa-download fa-1x" aria-hidden="true"></i>
                                                            </a>
                                                            <?php
                                                                }
                                                            ?>
                                                        </label><br/>
                                                        <input class="form-control" type="file" name="file3" id="upload_file3">
                                                    </div>
                                                    <input type="hidden" id="img_path3" value="<?php echo $pan_card;?>">
                                                    <div id="preview3">
                                                        <div id="image_preview3">
                                                            <?php
                                                                if($pan_card ==''){
                                                                    echo '<img src="../../uploading/not_uploaded.png" alt="Preview" id="img_pre3">';
                                                                }else{
                                                                    echo '<img src="../../uploading/'.$pan_card.'" alt="Preview" id="img_pre3">';?>
                                                                    
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-sm-6">
                                                    <div class="mb-3">
                                                        <label class="col-form-label">
                                                            <b>Bank Passbook</b>
                                                            <?php
                                                                if($bank_passbook !=''){
                                                            ?>
                                                            <a href="<?php echo '../../uploading/' . $bank_passbook; ?>" download class="ms-3" title="Download">
                                                                <i class="fa fa-download fa-1x" aria-hidden="true"></i>
                                                            </a>
                                                            <?php
                                                                }
                                                            ?>
                                                        </label><br/>
                                                        <input class="form-control" type="file" name="file4" id="upload_file4">
                                                    </div>
                                                    <input type="hidden" id="img_path4" value="<?php echo $bank_passbook;?>">
                                                    <div id="preview4">
                                                        <div id="image_preview4">
                                                            <?php
                                                                if($bank_passbook ==''){
                                                                    echo '<img src="../../uploading/not_uploaded.png" alt="Preview" id="img_pre4">';
                                                                }else{
                                                                    echo '<img src="../../uploading/'.$bank_passbook.'" alt="Preview" id="img_pre4">';?>
                                                                    
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-sm-6">
                                                    <div class="mb-3">
                                                        <label class="col-form-label">
                                                            <b>Voting Card</b>
                                                            <?php
                                                                if($voting_card !=''){
                                                            ?>
                                                            <a href="<?php echo '../../uploading/' . $voting_card; ?>" download class="ms-3" title="Download">
                                                                <i class="fa fa-download fa-1x" aria-hidden="true"></i>
                                                            </a>
                                                            <?php
                                                                }
                                                            ?>
                                                        </label><br/>
                                                        <input class="form-control" type="file" name="file5" id="upload_file5">
                                                    </div>
                                                    <input type="hidden" id="img_path5" value="<?php echo $voting_card;?>">
                                                    <div id="preview5">
                                                        <div id="image_preview5">
                                                            <?php
                                                                if($voting_card ==''){
                                                                    echo '<img src="../../uploading/not_uploaded.png" alt="Preview" id="img_pre5">';
                                                                }else{
                                                                    echo '<img src="../../uploading/'.$voting_card.'" alt="Preview" id="img_pre5">';?>
                                                                    
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-sm-6 d-none" id="payProof">
                                                    <div class="mb-3">
                                                        <label class="col-form-label">
                                                            <b>Payment Proof</b>
                                                            <?php
                                                                if($payment_proof !=''){
                                                            ?>
                                                            <a href="<?php echo '../../uploading/' . $payment_proof; ?>" download class="ms-3" title="Download">
                                                                <i class="fa fa-download fa-1x" aria-hidden="true"></i>
                                                            </a>
                                                            <?php
                                                                }
                                                            ?>
                                                        </label><br/>
                                                        <input class="form-control" type="file" name="file6" id="upload_file6" disabled>
                                                    </div>
                                                    <input type="hidden" id="img_path6" value="<?php echo $payment_proof;?>">
                                                    <div id="preview6">
                                                        <div id="image_preview6">
                                                            <?php
                                                                if($payment_proof ==''){
                                                                    echo '<img src="../../uploading/not_uploaded.png" alt="Preview" id="img_pre6">';
                                                                }else{
                                                                    echo '<img src="../../uploading/'.$payment_proof.'" alt="Preview" id="img_pre6">';?>
                                                                    
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
                                            <input type="hidden" id="testValue" name="testValue" value="11"> <!-- CA Travel Agent -->
                                            <input type="hidden" id="ref_id" name="ref_id" value="<?php echo $reference_no;?>">
                                            <input type="hidden" id="editfor" name="editfor" value="<?php echo $editfor;?>">
                                            <input type="hidden" id="id" name="id" value="<?php echo $id;?>">

                                            <div class="submit-section d-flex justify-content-center mb-4">
                                                <button type="submit" class="btn btn-primary px-5 py-2" id="edit_ca_travelagency">Submit</button>
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
            }
            );

        </script>

        <!-- ** designation user, user name on designation select / get country, state, city, pincode **  -->
        <script>
            $(document).ready(function(){
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

                
                var payment_fee = $("#payment_fee").val();
                // console.log(payment_fee);
                if(payment_fee == "FOC"){
                    $("#paymentModeBlock").addClass("d-none");
                    $("#paymentFields").addClass("d-none");
                    $("#payProof").addClass("d-none");
                }else if(payment_fee == "null"){
                    $("#paymentModeBlock").addClass("d-none");
                    $("#paymentFields").addClass("d-none");
                    $("#payProof").addClass("d-none");
                }else{
                    $("#paymentModeBlock").removeClass("d-none");
                    $("#paymentFields").removeClass("d-none");
                    $("#payProof").removeClass("d-none");
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
                // console.log(user_id_name);

                var designation = $('#designation').val();
                // console.log(designation);

                $.ajax({
                    type:'POST',
                    url:'../agents/getUsers.php',
                    data: 'user_id_name=' + user_id_name + '&designation=' + designation ,
                    success:function(response){
                    // console.log(response);
                        // $('#pin').html(response);
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
                // if(stateID==6){
                //     //paymentFee.value = "10000";
                //     $('#payProof').removeClass('d-none');   
                //     $('#paymentFields').removeClass('d-none');   
                //     $('#paymentModeBlock').removeClass('d-none'); 
                //     paymentFee.setAttribute("disabled", "true");
                // } else {
                //     //paymentFee.value = "null";
                //     $('#payProof').addClass('d-none');   
                //     $('#paymentFields').addClass('d-none');   
                //     $('#paymentModeBlock').addClass('d-none');
                //     paymentFee.removeAttribute("disabled");
                // }
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
            $('#payment_fee').on('change', function(){
                var payment_fee = $(this).val();
                // console.log(payment_fee);
                if(payment_fee == "FOC"){
                    $("#paymentModeBlock").addClass("d-none");
                    $("#paymentFields").addClass("d-none");
                    $('#payProof').addClass('d-none');  
                }else if(payment_fee == "null"){
                    $("#paymentModeBlock").addClass("d-none");
                    $("#paymentFields").addClass("d-none");
                    $('#payProof').addClass('d-none');  
                }else{
                    $("#paymentModeBlock").removeClass("d-none");
                    $("#paymentFields").removeClass("d-none");
                    $('#payProof').removeClass('d-none');  
                }
            });
            $('#paymentMode').on('click', function(){
                var paymentMode = $(".payment:checked").val();
                // console.log(paymentMode);
                if(paymentMode == "cheque"){
                    $("#chequeOpt").removeClass("d-none");
                    $("#onlineOpt").addClass("d-none");
                    $('#transactionNo').val('');
                    // $("#allOpt").removeClass("d-none");
                }else if(paymentMode == "online"){
                    $("#onlineOpt").removeClass("d-none");
                    $("#chequeOpt").addClass("d-none");
                    $('#chequeNo').val('');
                    $('#chequeDate').val('');
                    $('#bankName').val('');
                    // $("#allOpt").removeClass("d-none");
                } else {
                    $("#chequeOpt").addClass("d-none");
                    $("#onlineOpt").addClass("d-none");
                    $('#chequeNo').val('');
                    $('#chequeDate').val('');
                    $('#bankName').val('');
                    $('#transactionNo').val('');
                    // $("#allOpt").removeClass("d-none");
                }
            });
        </script>
    </body>

</html>