<div class="row">
    <div class="col-xl-1 col-lg-12 col-md-12 col-sm-12 col-12">
        <!-- <img src="../assets/images/users/avatar-5.jpg" width="75" height="75" alt="" class="rounded-circle"> -->
        <?php
        if ($profile_pic_img) {
            echo '<img src="../../uploading/' . $profile_pic_img . '" alt="Preview" class="avatar-md rounded-circle img-fluid">';
        } else {
            echo '<img src="../../uploading/not_uploaded.png" alt="Preview" class="avatar-md rounded-circle img-fluid">';
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
                    <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12 pe-0">
                        <p><span><i class="fa-solid fa-user-tie pe-2"></i></span><?= $designation1; ?></p>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12 col-12 px-0">
                        <p class="peraPadding"> Create Date: <span class="fw-bold"><?= $rdate; ?></span></p>
                    </div>
                    <div class="col-xl-5 col-lg-5 col-md-12 col-sm-12 col-12">
                        <p>Commission Earned: <span class="fw-bold py-1 px-2 rounded-3 bg-success-subtle text-success-emphasis border-success-subtle"></span></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>