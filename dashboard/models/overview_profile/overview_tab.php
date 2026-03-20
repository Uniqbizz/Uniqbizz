<div class="tab-pane fade show active" id="overview" role="tabpanel">
    <div class="card rounded-4">
        <div class="card-body">
            <?php if ($DBtable == 'business_developement_manager' || $DBtable == 'business_chanel_manager') { ?>
                <form>
                    <div class="row">
                        <!-- Personal Details -->
                        <div class="col-sm-6">
                            <div class="input-block mb-3">
                                <label class="col-form-label">Full Name: <span class="ms-2"><?php echo $name; ?></span></label>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="input-block mb-3">
                                <label class="col-form-label">Date of Birth: <span class="ms-2"><?php echo $date_of_birth; ?></span></label>
                            </div>
                        </div>
                        <div class="col-sm-6 " style="display: flex; justify-content: space-between; ">
                            <div class="input-block mb-3 col-sm-9">
                                <label class="col-form-label">Contact Number: <span class="ms-2"><?php echo '+' . $country_code . '' . $contact ?></span></label>
                            </div>

                        </div>
                        <div class="col-sm-6">
                            <div class="input-block mb-3">
                                <label class="col-form-label">Email: <span class="ms-2"><?php echo $email; ?></span></label>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="input-block mb-3">
                                <label class="col-form-label">Address: <span class="ms-2"><?php echo $address; ?></span></label>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="col-form-label">Gender:
                                    <span class="ms-2">
                                        <?php
                                        if ($gender == "male") {
                                            echo 'Male';
                                        } else if ($gender == "female") {
                                            echo 'Female';
                                        } else if ($gender == "other") {
                                            echo 'Other';
                                        }
                                        ?>
                                    </span>
                                </label>
                            </div>
                        </div>

                        <!-- Employment Details -->
                        <h4 class="my-2">Employment Details</h4>
                        <div class="col-sm-6">
                            <div class="input-block mb-3">
                                <label class="col-form-label">Joining Date: <span class="ms-2"><?php echo $date_of_joining; ?></span></label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="input-block mb-3">
                                <label class="col-form-label">Department: <span class="ms-2"><?= $departmentname ?></span></label>
                                
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="input-block mb-3">
                                <label class="col-form-label">Designation: <span class="ms-2"><?= $designation1 ?></span></label>
                                
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="input-block mb-3">
                                <label class="col-form-label">Zone: <span class="ms-2"><?= $zone_name ?></span></label>
                                
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="input-block mb-3">
                                <label class="col-form-label">Branch: <span class="ms-2"><?= $branch_name ?></span></label>
                                
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="input-block mb-3">
                                <label class="col-form-label">Reporting Manager: <span class="ms-2"><?= $reporting_manager_name ?></span></label>
                                
                            </div>
                        </div>

                        <!-- Attachments -->
                        <h4 class="mt-2 mb-0">Attachments</h4>
                        <div class="col-sm-6">
                            <div class="input-block mt-1">
                                <label class="col-form-label">
                                    Profile Picture 
                                    <a href="<?php echo '../../uploading/' . $profile_pic; ?>" download class="ms-3" title="Download">
                                            <i class="fa fa-download fa-1x" aria-hidden="true"></i>
                                    </a>
                                </label>
                            </div>
                            <input type="hidden" id="img_path1" value="<?php echo $profile_pic; ?>">
                            <div id="preview1">
                                <div id="image_preview1">
                                    <?php
                                    if ($profile_pic == '') {
                                        echo '<img src="../../uploading/not_uploaded.png" alt="Preview" id="img_pre1" class="imgSize">';
                                    } else {
                                        echo '<img src="../../uploading/' . $profile_pic . '" alt="Preview" id="img_pre1" class="imgSize">';
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="input-block mt-1">
                                <label class="col-form-label">
                                    ID Proof (Aadhaar/PAN/Passport)
                                    <a href="<?php echo '../../uploading/' . $id_proof; ?>" download class="ms-3" title="Download">
                                            <i class="fa fa-download fa-1x" aria-hidden="true"></i>
                                    </a>
                                </label>
                            </div>
                            <input type="hidden" id="img_path2" value="<?php echo $id_proof; ?>">
                            <div id="preview2">
                                <div id="image_preview2">
                                    <?php
                                    if ($id_proof == '') {
                                        echo '<img src="../../uploading/not_uploaded.png" alt="Preview" id="img_pre2" class="imgSize">';
                                    } else {
                                        echo '<img src="../../uploading/' . $id_proof . '" alt="Preview" id="img_pre2" class="imgSize">';
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 mb-3">
                            <div class="input-block mt-3">
                                <label class="col-form-label">
                                    Bank Details for Salary Transfer
                                    <a href="<?php echo '../../uploading/' . $bank_details; ?>" download class="ms-3" title="Download">
                                            <i class="fa fa-download fa-1x" aria-hidden="true"></i>
                                    </a>
                                </label>
                            </div>
                            <input type="hidden" id="img_path3" value="<?php echo $bank_details; ?>">
                            <div id="preview3">
                                <div id="image_preview3">
                                    <?php
                                    if ($bank_details == '') {
                                        echo '<img src="../../uploading/not_uploaded.png" alt="Preview" id="img_pre3" class="imgSize">';
                                    } else {
                                        echo '<img src="../../uploading/' . $bank_details . '" alt="Preview" id="img_pre3" class="imgSize">';
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            <?php } else { ?>
                <form>
                    <?php if ($DBtable == 'ca_customer') { ?>
                        <!-- need to check this condtion donot uncomment this for now -->
                        <div class="row">
                            <div class="col-md-6 col-sm-12">
                                <div class="input-block mb-3">
                                    <label class="col-form-label" for="user_id_name">TA User Id & Name: <span class="ms-2"><?= $ta_ref_no ?></span></label>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="input-block mb-3">
                                    <label class="col-form-label" for="reference_name">TA Reference Name: <span class="ms-2"></span><?= $ta_name ?></label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-sm-12">
                                <div class="input-block mb-3">
                                    <label class="col-form-label" for="user_id_name">CU User Id & Name: <span class="ms-2"><?= $reference_no ?></span> </label>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="input-block mb-3">
                                    <label class="col-form-label" for="reference_name">CU Reference Name: <span class="ms-2"><?= $registrant ?></span> </label>
                                </div>
                            </div>
                        </div>
                    <?php } else { ?>
                        <div class="row">
                            <div class="col-md-6 col-sm-12">
                                <div class="input-block mb-3">
                                    <label class="col-form-label" for="user_id_name">User Id & Name: <span class="ms-2"><?= $reference_no ?></span> </label>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="input-block mb-3">
                                    <label class="col-form-label" for="reference_name">Reference Name: <span class="ms-2"><?= $registrant ?></span> </label>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                    <div class="row">
                        <div class="col-md-6 col-sm-12">
                            <div class="input-block mb-3">
                                <label class="col-form-label" for="firstname">First Name: <span class="ms-2"><?php echo $firstname; ?></span></label>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <div class="input-block mb-3">
                                <label class="col-form-label" for="lastname">Last Name: <span class="ms-2"><?php echo $lastname; ?></span></label>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 col-sm-12">
                            <div class="input-block mb-3">
                                <label class="col-form-label" for="nominee_name">Nominee Name: <span class="ms-2"><?php echo $nominee_name ? $nominee_name : 'No Nominee Added'; ?></span></label>
                                
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <div class="input-block mb-3">
                                <label class="col-form-label" for="nominee_relation">Nominee Relation: <span class="ms-2"><?php echo $nominee_relation ? $nominee_relation : 'No Nominee Added'; ?></span></label>
                                
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 col-sm-12">
                            <div class="input-block mb-3">
                                <label class="col-form-label" for="email">Email address: <span class="ms-2"><?php echo $email; ?></span></label>
                                
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <div class="input-block mb-3">
                                <label class="col-form-label" for="dob">Date: <span class="ms-2"><?php echo $date_of_birth; ?></span></label>
                                
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-sm-12">
                            <div class="form-group mb-3">
                                <label class="col-form-label">Gender:
                                    <span class="ms-2">
                                        <?php
                                        if ($gender == "male") {
                                            echo 'Male';
                                        } else if ($gender == "female") {
                                            echo 'female';
                                        } else if ($gender == "other") {
                                            echo 'Other';
                                        }
                                        ?>
                                    </span></label>
                            </div>
                        </div>

                        <div class="col-md-6 col-sm-12 code-mobile">
                            <div class="input-block  col-sm-12">
                                <label for="phone">Phone Number: <span class="ms-2">+<?php echo $contact_no; ?></span></label>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 col-sm-12">
                            <div class="input-block mb-3">
                                <label for="country">Country: <span class="ms-2"><?php echo $countryname; ?></span></label>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <div class="input-block mb-3">
                                <label for="mystate">State: <span class="ms-2"><?php echo $statename; ?></span></label>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 col-sm-12">
                            <div class="input-block mb-3">
                                <label for="city">City: <span class="ms-2"><?php echo $cityname; ?></span></label>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <div class="input-block mb-3">
                                <label for="pin">Pincode: <span class="ms-2"><?php echo $pincode; ?></span></label>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <div class="input-block mb-3">
                                <label for="address">Address: <span class="ms-2"><?php echo $address; ?></span></label>
                            </div>
                        </div>
                    </div>

                    <?php if ($DBtable == 'corporate_agency' || $DBtable == 'ca_travelagency' || $DBtable == 'ca_customer') { ?>
                        <div class="row py-3">
                            <div class="col-lg-12" id="paymentMode">
                                <p>Payment Mode: <span>
                                        <?php
                                        if ($payment_mode == "cash") {
                                            echo 'Cash';
                                        } else if ($payment_mode == "cheque") {
                                            echo 'Cheque';
                                        } else if ($payment_mode == "online") {
                                            echo 'UPI/NEFT';
                                        } else if ($payment_mode == "FOC") {
                                            echo 'Free';
                                        }
                                        ?>
                                    </span></p>
                                <div class='d-none'>
                                    <input type="radio" id="cashPayment" class="form-check-input payment" name="payment" value="cash" <?php if ($payment_mode == "cash") {
                                                                                                                                            echo 'checked';
                                                                                                                                        } ?> disabled>
                                    <label for="cashPayment">Cash</label>
                                    <input type="radio" id="chequePayment" class="form-check-input payment ms-2" name="payment" value="cheque" <?php if ($payment_mode == "cheque") {
                                                                                                                                                    echo 'checked';
                                                                                                                                                } ?> disabled>
                                    <label for="chequePayment">Cheque</label>
                                    <input type="radio" id="onlinePayment" class="form-check-input payment ms-2" name="payment" value="online" <?php if ($payment_mode == "online") {
                                                                                                                                                    echo 'checked';
                                                                                                                                                } ?> disabled>
                                    <label for="onlinePayment">UPI/NEFT</label>
                                </div>
                            </div>

                            <div class="col-lg-12 d-none" id="chequeOpt" style="display:flex; justify-content: space-between;">
                                <div class="col-lg-3 ">
                                    <div class="input-block">
                                        <label for="chequeNo">Cheque No: <span class="ms-2"><?php echo $cheque_no; ?></span></label>
                                    </div>
                                </div>

                                <div class="col-lg-3 ">
                                    <div class="input-block">
                                        <label for="chequeDate">Cheque Date: <span class="ms-2"><?php echo $cheque_date; ?></span></label>
                                    </div>
                                </div>

                                <div class="col-lg-3 ">
                                    <div class="input-block">
                                        <label for="bankName">Bank Name: <span class="ms-2"><?php echo $bank_name; ?></span></label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-12 d-none" id="onlineOpt" style="display:flex; justify-content: space-between;">
                                <div class="col-lg-8">
                                    <div class="input-block">
                                        <label for="transactionNo">Transaction No: <span class="ms-2"><?php echo $transaction_no; ?></span></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>

                    <div class="row mt-3">
                        <div class="col-md-6 col-sm-12">
                            <div class="mb-0">
                                <label for="file1">
                                    <b>PROFILE</b>
                                    <a href="<?php echo '../../uploading/' . $profile_pic; ?>" download class="ms-3" title="Download">
                                            <i class="fa fa-download fa-1x" aria-hidden="true"></i>
                                    </a>
                                </label><br />
                            </div>
                            <div id="preview1">
                                <div id="image_preview1">
                                    <?php
                                    if ($profile_pic == '') {
                                        echo '<img src="../../uploading/not_uploaded.png" alt="Preview" id="img_pre1">';
                                    } else {
                                        echo '<img src="../../uploading/' . $profile_pic . '" alt="Preview" id="img_pre1">';
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12 ">
                            <div class="mb-0">
                                <label for="file2">
                                    <b>AADHAR CARD</b>
                                    <a href="<?php echo '../../uploading/' . $aadhar_card; ?>" download class="ms-3" title="Download">
                                            <i class="fa fa-download fa-1x" aria-hidden="true"></i>
                                    </a>
                                </label><br />
                            </div>
                            <div id="preview2">
                                <div id="image_preview2">
                                    <?php
                                    if ($aadhar_card == '') {
                                        echo '<img src="../../uploading/not_uploaded.png" alt="Preview" id="img_pre2">';
                                    } else {
                                        echo '<img src="../../uploading/' . $aadhar_card . '" alt="Preview" id="img_pre2">';
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-md-6 col-sm-12">
                            <div class="mb-0">
                                <label for="file3">
                                    <b>PAN CARD</b>
                                    <a href="<?php echo '../../uploading/' . $pan_card; ?>" download class="ms-3" title="Download">
                                            <i class="fa fa-download fa-1x" aria-hidden="true"></i>
                                    </a>
                                </label><br />
                            </div>
                            <div id="preview3">
                                <div id="image_preview3">
                                    <?php
                                    if ($pan_card == '') {
                                        echo '<img src="../../uploading/not_uploaded.png" alt="Preview" id="img_pre3">';
                                    } else {
                                        echo '<img src="../../uploading/' . $pan_card . '" alt="Preview" id="img_pre3">';
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <div class="mb-0">
                                <label for="file4">
                                    <b>BANK PASSBOOK</b>
                                    <a href="<?php echo '../../uploading/' . $bank_passbook; ?>" download class="ms-3" title="Download">
                                            <i class="fa fa-download fa-1x" aria-hidden="true"></i>
                                    </a>
                                </label><br />
                            </div>
                            <div id="preview4">
                                <div id="image_preview4">
                                    <?php
                                    if ($bank_passbook == '') {
                                        echo '<img src="../../uploading/not_uploaded.png" alt="Preview" id="img_pre4">';
                                    } else {
                                        echo '<img src="../../uploading/' . $bank_passbook . '" alt="Preview" id="img_pre4">';
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4 mb-3">
                        <div class="col-md-6 col-sm-12">
                            <div class="mb-0">
                                <label for="file5">
                                    <b>VOTING CARD</b>
                                    <a href="<?php echo '../../uploading/' . $voting_card; ?>" download class="ms-3" title="Download">
                                            <i class="fa fa-download fa-1x" aria-hidden="true"></i>
                                    </a>
                                </label><br />
                            </div>
                            <div id="preview5">
                                <div id="image_preview5">
                                    <?php
                                    if ($voting_card == '') {
                                        echo '<img src="../../uploading/not_uploaded.png" alt="Preview" id="img_pre5">';
                                    } else {
                                        echo '<img src="../../uploading/' . $voting_card . '" alt="Preview" id="img_pre5">';
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                        <?php if ($DBtable == 'corporate_agency' || $DBtable == 'ca_travelagency' || $DBtable == 'ca_customer') { ?>
                            <div class="col-md-6 col-sm-12">
                                <div class="mb-0">
                                    <label for="file6">
                                        <b>PAYMENT PROOF</b>
                                        <a href="<?php echo '../../uploading/' . $payment_proof; ?>" download class="ms-3" title="Download">
                                            <i class="fa fa-download fa-1x" aria-hidden="true"></i>
                                    </a>
                                    </label><br />
                                </div>
                                <div id="preview6">
                                    <div id="image_preview6">
                                        <?php
                                        if ($payment_proof == '') {
                                            echo '<img src="../../uploading/not_uploaded.png" alt="Preview" id="img_pre6">';
                                        } else {
                                            echo '<img src="../../uploading/' . $payment_proof . '" alt="Preview" id="img_pre6">';
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </form>
            <?php } ?>
        </div>
    </div>
</div>