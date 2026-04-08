<div class="row">
    <div class="col-xl-1 col-lg-12 col-md-12 col-sm-12 col-12">
        <!-- <img src="../assets/images/users/avatar-5.jpg" width="75" height="75" alt="" class="rounded-circle"> -->
        <?php
        if ($profile_pic) {
            echo '<img src="../../../uploading/' . $profile_pic . '" alt="Preview" class="avatar-md rounded-circle">';
        } else {
            echo '<img src="../../../uploading/not_uploaded.png" alt="Preview" class="avatar-md rounded-circle">';
        }
        ?>
    </div>
    <div class="col-xl-11 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="row mt-3">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <h4><?= $User_name ?><span id='user_id'> <?= $id ?></span></h4>
            </div>
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="row">
                    <div class="<?=$customer_type== 'Premium Plus'?'col-xl-3 col-lg-3':'col-xl-4 col-lg-4'?> col-md-12 col-sm-12 col-12 pe-0">
                        <p><span><i class="fa-solid fa-user-tie pe-2"></i></span><?= $designation; ?></p>
                    </div>
                    <div class="<?=$customer_type== 'Premium Plus'?'col-xl-3 col-lg-3':'col-xl-3 col-lg-3'?> col-md-12 col-sm-12 col-12 px-0">
                        <p class="peraPadding"> Create Date: <span class="fw-bold"><?= $rdate; ?></span></p>
                    </div>
                    <?php
                        if($customer_type){
                            if($customer_type == 'Premium Plus'){
                    ?>
                    <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12 col-12">
                        <p>Wallet Balance: <span class="fw-bold py-1 px-2 rounded-3 bg-success-subtle text-success-emphasis border-success-subtle">&#8377;0</span></p>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12 col-12">
                        <p>Booking Points: <span class="fw-bold py-1 px-2 rounded-3 bg-success-subtle text-success-emphasis border-success-subtle">&#8377;0</span></p>
                    </div>
                    <?php
                            }else{
                    ?>
                    <div class="col-xl-5 col-lg-5 col-md-12 col-sm-12 col-12">
                        <p>Wallet Balance: <span class="fw-bold py-1 px-2 rounded-3 bg-success-subtle text-success-emphasis border-success-subtle">&#8377;0</span></p>
                    </div>
                    <?php
                            }
                        } else{
                    ?>
                    <div class="col-xl-5 col-lg-5 col-md-12 col-sm-12 col-12">
                        <p>
                            Commission Earned:
                            <span id="commissionTotal" class="fw-bold py-1 px-2 rounded-3 bg-success-subtle text-success-emphasis border-success-subtle">
                                ₹ 0
                            </span>
                        </p>
                    </div>
                    <?php
                        }
                    ?>
                    <?php
                        if($DBtable != 'ca_customer' && $DBtable != 'institution'){//institution and customer account are non transferable
                    ?>
                    <div class="row">
                        <div class="col-xl-5 col-lg-5 col-md-12 col-sm-12 col-12">
                            <button class="btn btn-warning btn-sm edit-btn"
                                data-user='<?= json_encode($edit_arr) ?>'>
                                <i class="fa-solid fa-right-left me-1"></i> Transfer
                            </button>
                        </div>
                    </div>
                    <?php
                        }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>