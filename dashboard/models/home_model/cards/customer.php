<!-- Upgrade section  -->
<!-- Customer -->
<div class="row">
    <div class="col-12">
        <div>
            <?php
                require '../connect.php';
                $cuponstmt = $conn->prepare("SELECT * FROM cu_coupons WHERE user_id = :id");
                $cuponstmt->execute(['id' => $userId]);
                $cupon = $cuponstmt->fetch(PDO::FETCH_ASSOC);
                
                // to get the query ouput in console
                // $debugQuery = "SELECT * FROM cu_coupons WHERE user_id = '" . $userId."'";
                
                // echo '<script>console.log("Prepared Query: ' . $debugQuery . '");</script>';
                
                // echo '<script>console.log("Coupon:", ' . json_encode($cupon) . ');</script>';
                
                if ($cupon) {
                    if($customerType == 'Prime'){
            ?>
            <div class="card p-3 rounded-4">
                <div class="row d-flex justify-content-evenly">
                    <div class="col-lg-8 col-md-7 col-sm-12 col-12">
                        <div class="d-flex">
                            <div>
                                <img src="../assets/images/customer/popperImg.png" alt="Popper Image" width="85px" height="85px">
                            </div>
                            <div class="mt-3">
                                <h2>Congratulations! <span class="hightlightTextGreen">You're a Prime Member</span></h2>
                                <p class="mt-2 fs-5">Discover handpicked standard holiday packages made just for you.</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-10 col-md-12 col-sm-12 col-12 d-flex justify-content-evenly mt-3">
                                <a class="btn primeBtnGreen" href="#" role="button">Browse Prime Deals</a>
                                <a class="btn primeBtnGreen" href="#" role="button">View Your Packages</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-5 col-5 imageAvatar">
                        <img src="../assets/images/user-illustarator-2.png" alt="" width="260px" height="170px">
                    </div>
                </div>
            </div>
            <?php
                    } else if($customerType == 'Premium'){
            ?>
            <div class="card p-3 rounded-4">
                <div class="row d-flex justify-content-evenly">
                    <div class="col-lg-8 col-md-7 col-sm-12 col-12">
                        <div class="d-flex">
                            <div>
                                <img src="../assets/images/customer/multistarImg.png" alt="Popper Image" width="85px" height="85px">
                            </div>
                            <div class="mt-3">
                                <h2>Welcome, <span class="hightlightTextBlue">Premium Member!</span></h2>
                                <p class="mt-2 fs-5">Unlock luxury escapes and curated travel experiences.</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-10 col-md-12 col-sm-12 col-12 d-flex justify-content-evenly mt-3">
                                <a class="btn primeBtnBlue" href="#" role="button">Explore Premium Packages</a>
                                <a class="btn primeBtnBlue" href="#" role="button">Check Your Bookings</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-5 col-5 imageAvatar">
                        <img src="../assets/images/user-illustarator-2.png" alt="" width="260px" height="170px">
                    </div>
                </div>
            </div>
            <?php
                    }else if($customerType == 'Premium Plus'){
            ?>
            <div class="card p-3 rounded-4">
                <div class="row d-flex justify-content-evenly">
                    <div class="col-lg-8 col-md-7 col-sm-12 col-12">
                        <div class="d-flex">
                            <div>
                                <img src="../assets/images/customer/trophyImg.png" alt="Popper Image" width="85px" height="85px">
                            </div>
                            <div class="mt-3">
                                <h2>You're a <span class="hightlightTextPurple">Premium Plus Member</span></h2>
                                <p class="mt-2 fs-5">Access elite travel support, premium destinations, and concierge service.</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-10 col-md-12 col-sm-12 col-12 d-flex justify-content-evenly mt-3">
                                <a class="btn primeBtnPurple" href="#" role="button">Access Premium Plus Offers</a>
                                <a class="btn primeBtnPurple" href="#" role="button">My Travel Portfolio</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-5 col-5 imageAvatar">
                        <img src="../assets/images/user-illustarator-2.png" alt="" width="260px" height="170px">
                    </div>
                </div>
            </div>
            <?php
                    }else if($customerType == 'Premium Select'){
            ?>
            <div class="card p-3 rounded-4">
                <div class="row d-flex justify-content-evenly">
                    <div class="col-lg-8 col-md-7 col-sm-12 col-12">
                        <div class="d-flex">
                            <div>
                                <img src="../assets/images/customer/starImg.png" alt="Popper Image" width="85px" height="85px">
                            </div>
                            <div class="mt-3">
                                <h2>Congratulations! <span class="hightlightTextOrange">You're a Premium Select Member</span></h2>
                                <p class="mt-2 fs-5">Use points and vouchers to unlock premium & standard travel experiences.</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-10 col-md-12 col-sm-12 col-12 d-flex justify-content-evenly mt-3">
                                <a class="btn primeBtnOrange" href="#" role="button">Premium Select Deals</a>
                                <a class="btn primeBtnOrange" href="#" role="button">View Your Packages</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-5 col-5 imageAvatar">
                        <img src="../assets/images/user-illustarator-2.png" alt="" width="260px" height="170px">
                    </div>
                </div>
            </div>
            <?php
                    }else if($customerType == 'Premium Select Lite'){
            ?>
            <div class="card p-3 rounded-4">
                <div class="row d-flex justify-content-evenly">
                    <div class="col-lg-8 col-md-7 col-sm-12 col-12">
                        <div class="d-flex">
                            <div>
                                <img src="../assets/images/customer/starImg.png" alt="Popper Image" width="85px" height="85px">
                            </div>
                            <div class="mt-3">
                                <h2>Congratulations! <span class="hightlightTextRed">You're a Premium Select Lite Member</span></h2>
                                <p class="mt-2 fs-5">Use points and vouchers to unlock premium & standard travel experiences.</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-10 col-md-12 col-sm-12 col-12 d-flex justify-content-evenly mt-3">
                                <a class="btn primeBtnRed" href="#" role="button">Premium Select Lite</a>
                                <a class="btn primeBtnRed" href="#" role="button">View Your Packages</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-5 col-5 imageAvatar">
                        <img src="../assets/images/user-illustarator-2.png" alt="" width="260px" height="170px">
                    </div>
                </div>
            </div>
            <?php
                    }else if($customerType == 'Neo Select'){
            ?>
            <div class="card p-3 border borderColorRed rounded-4 border-3">
                <div class="row d-flex justify-content-evenly">
                    <div class="col-lg-8 col-md-7 col-sm-12 col-12">
                        <div class="d-flex">
                            <div>
                                <img src="../assets/images/customer/starImg.png" alt="Popper Image" width="85px" height="85px">
                            </div>
                            <div class="mt-3">
                                <h2>Congratulations! <span class="hightlightTextRed">You're a Neo Select Member</span></h2>
                                <p class="mt-2 fs-5">Use points and vouchers to unlock premium & standard travel experiences.</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-10 col-md-12 col-sm-12 col-12 d-flex justify-content-evenly mt-3">
                                <a class="btn primeBtnRed" href="#" role="button">Neo Select</a>
                                <a class="btn primeBtnRed" href="#" role="button">View Your Packages</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-5 col-5 imageAvatar">
                        <img src="../assets/images/user-illustarator-2.png" alt="" width="260px" height="170px">
                    </div>
                </div>
            </div>
            <?php
                    }
                } else {
            ?>
            <div class="card p-3">
                <div class="alert alert-warning border-0 rounded-0 m-0 d-flex align-items-center" role="alert">
                    <i data-feather="alert-triangle" class="text-warning me-2 icon-sm"></i>
                    <div class="flex-grow-1 text-truncate">
                        Upgrade to prime membership.
                    </div>
                    <!-- <div class="flex-shrink-0">
                        <a href="pages-pricing.html" class="text-reset text-decoration-underline"><b>Upgrade</b></a>
                    </div> -->
                </div>

                <div class="row align-items-end">
                    <div class="col-sm-8">
                        <div class="p-3">
                            <p class="fs-16 lh-base">Unlock more value – <span class="fw-semibold">Upgrade now</span> to become a <span class="fw-semibold">Prime Customer!</span> Enjoy exclusive benefits, faster support, and premium features tailored just for you.</p>
                            <!--<div class="mt-3">-->
                            <!--    <a href="pages-pricing.html" class="btn btn-success waves-effect waves-light">Upgrade</a>-->
                            <!--</div>-->
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="px-3">
                            <img src="../assets/images/user-illustarator-2.png" class="img-fluid" alt="">
                        </div>
                    </div>
                </div>
            </div> <!-- end card-body-->
            <?php
                }
            ?>
        </div>
    </div> <!-- end col-->
</div> <!-- end row-->

<div class="row">
    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-12">
        <div class="card rounded-4 pt-3 pb-2 px-4 cardBg1">
            <div>
                <p class="text-white fw-bold">Registered Customer</p>
            </div>
            <div class="d-flex justify-content-between align-items-center mb-1">
                <span class="">
                    <i class="fa-regular fa-user fa-2xl" style="color: #ffffff;"></i>
                </span>
                <div class="ms-4">
                    <?php
                    $sql3 = "SELECT COUNT(ca_customer_id) as id FROM ca_customer WHERE reference_no = '" . $userId . "' AND status = '1'";
                    $stmt3 = $conn->prepare($sql3);
                    $stmt3->execute();
                    $stmt3->setFetchMode(PDO::FETCH_ASSOC);
                    if ($stmt3->rowCount() > 0) {
                        foreach (($stmt3->fetchAll()) as $key => $row) {
                            $id = $row['id'];
                            echo '<h1 class="mb-0 text-white">' . $id . '</h1>';
                        }
                    }
                    ?>
                </div>
            </div>
            <div class="d-flex justify-content-between">
                <p class="text-white">This Month</p>
                <?php
                $sql3 = "SELECT COUNT(ca_customer_id) as id FROM ca_customer WHERE reference_no = '" . $userId . "' AND YEAR(register_date) = '" . $DateYear . "' AND MONTH(register_date) = '" . $DateMonth . "'  AND status = '1'";
                $stmt3 = $conn->prepare($sql3);
                $stmt3->execute();
                $stmt3->setFetchMode(PDO::FETCH_ASSOC);
                if ($stmt3->rowCount() > 0) {
                    foreach (($stmt3->fetchAll()) as $key => $row) {
                        $id2 = $row['id'];
                        echo '<p class="text-white">' . $id2 . '</p>';
                    }
                }
                ?>

            </div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-12">
        <div class="card rounded-4 pt-3 pb-2 px-4 cardBg2">
            <div>
                <p class="text-white fw-bold">Completed Tours</p>
            </div>
            <div class="d-flex justify-content-between align-items-center mb-1">
                <span class="">
                    <i class="fa-regular fa-map fa-2xl" style="color: #ffffff;"></i>
                </span>
                <div class="ms-4">
                    <?php
                    $stmt = $conn->prepare("SELECT COUNT(cu_id) as completedTour FROM product_payout WHERE cu_id = ? AND end_date < NOW()");
                    $stmt->execute([$userId]);
                    $stmt->setFetchMode(PDO::FETCH_ASSOC);
                    if ($stmt->rowCount() > 0) {
                        foreach (($stmt->fetchAll()) as $key => $row) {
                            $completedTour = $row['completedTour'];
                            echo '<h1 class="mb-0 text-white">' . $completedTour . '</h1>';
                        }
                    }
                    ?>

                </div>
            </div>
            <div class="d-flex justify-content-between">
                <p class="text-white">This Month</p>
                <?php
                $stmt = $conn->prepare("SELECT COUNT(cu_id) as completedTourThisMonth FROM product_payout WHERE cu_id = ? AND end_date < NOW() AND  YEAR(end_date) = '" . $DateYear . "' AND MONTH(end_date) = '" . $DateMonth . "'");
                $stmt->execute([$userId]);
                $stmt->setFetchMode(PDO::FETCH_ASSOC);
                if ($stmt->rowCount() > 0) {
                    foreach (($stmt->fetchAll()) as $key => $row) {
                        $completedTourThisMonth = $row['completedTourThisMonth'];
                        echo '<p class="text-white">' . $completedTourThisMonth . '</p>';
                    }
                }
                ?>

            </div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-12">
        <div class="card rounded-4 pt-3 pb-2 px-4 cardBg3">
            <div>
                <p class="text-white fw-bold">Upcoming Tours</p>
            </div>
            <div class="d-flex justify-content-between align-items-center mb-1">
                <span class="">
                    <i class="fa-solid fa-clock-rotate-left fa-2xl" style="color: #ffffff;"></i>
                </span>
                <div class="ms-4">
                    <?php
                    $stmt = $conn->prepare("SELECT COUNT(cu_id) as upcomingTour FROM product_payout WHERE cu_id = ? AND start_date > NOW()");
                    $stmt->execute([$userId]);
                    $stmt->setFetchMode(PDO::FETCH_ASSOC);
                    if ($stmt->rowCount() > 0) {
                        foreach (($stmt->fetchAll()) as $key => $row) {
                            $upcomingTour = $row['upcomingTour'];
                            echo '<h1 class="mb-0 text-white">' . $upcomingTour . '</h1>';
                        }
                    }
                    ?>
                </div>
            </div>
            <div class="d-flex justify-content-between">
                <p class="text-white">This Month</p>
                <?php
                $stmt = $conn->prepare("SELECT COUNT(cu_id) as upcomingTourThisMonth FROM product_payout WHERE cu_id = ? AND start_date > NOW() AND  YEAR(start_date) = '" . $DateYear . "' AND MONTH(start_date) = '" . $DateMonth . "'");
                $stmt->execute([$userId]);
                $stmt->setFetchMode(PDO::FETCH_ASSOC);
                if ($stmt->rowCount() > 0) {
                    foreach (($stmt->fetchAll()) as $key => $row) {
                        $upcomingTourThisMonth = $row['upcomingTourThisMonth'];
                        echo '<p class="text-white">' . $upcomingTourThisMonth . '</p>';
                    }
                }
                ?>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-12">
        <div class="card rounded-4 pt-3 pb-2 px-4 cardBg4">
            <div>
                <p class="text-white fw-bold">Commission Earned</p>
            </div>
            <div class="d-flex justify-content-between align-items-center mb-1">
                <span class="">
                    <i class="fa-regular fa-money-bill-1 fa-2xl" style="color: #ffffff;"></i>
                </span>
                <div class="ms-4">

                    <?php

                    //pending amount
                    //status = 1 Confirm,  2 pending
                    $cust_ids = ['cu1', 'cu2', 'cu2'];  // Customer IDs array
                    foreach ($cust_ids as $cust_id) {
                        // Prepare the dynamic column name for the query
                        // Note: In this case, we're assuming that $cust_id values are safe and predefined
                        $column_id = $cust_id . '_id';  // Example: 'cu1_id' or 'cu2_id'
                        $column_status = $cust_id . '_status';  // Example: 'cu1_status' or 'cu2_status'
                        $column_amt = $cust_id . '_amt';

                        // Prepare the SQL query using placeholders for security
                        $sqlCAP = $conn->prepare("SELECT SUM($column_amt) as cuAmt FROM product_payout WHERE $column_id = :userId ");

                        // Bind the userId parameter
                        $sqlCAP->bindParam(':userId', $userId, PDO::PARAM_STR);

                        // Output the SQL query for debugging purposes (just for your understanding, not to be done in production)
                        // echo "Executing query for $cust_id: ";
                        // echo "SELECT SUM($column_amt) as cuAmt FROM product_payout WHERE $column_id = '$userId' AND $column_status = '2'<br>";


                        // Execute the query
                        $sqlCAP->execute();

                        // Check if there are results and fetch the amount
                        if ($sqlCAP->rowCount() > 0) {
                            $row = $sqlCAP->fetch(PDO::FETCH_ASSOC);
                            $PendingAmt = $row['cuAmt'];
                            // Do something with $PendingAmt
                        }
                    }
                    // $cust_ids=['cu1','cu2','cu2'];
                    // foreach ( $cust_ids as $key =>  $cust_id) {

                    //     $sqlCAP = $conn -> prepare("SELECT SUM(".$cust_id."_id) as cuAmt FROM product_payout WHERE ".$cust_id."_id = '".$userId."' AND ".$cust_id."_status='2' ");
                    //     $sqlCAP -> execute();
                    //     $sqlCAP -> setFetchMode(PDO::FETCH_ASSOC);
                    //     if( $sqlCAP -> rowCount()>0 ){
                    //         foreach( ( $sqlCAP -> fetchAll() ) as $key => $row ){
                    //             $PendingAmt = $row['cuAmt'];
                    //         }
                    //     }
                    // }

                    //status = 1 pending,  2 confirm
                    // $sqlTAP = $conn -> prepare("SELECT SUM(commision_ca) as teCommiAmt FROM ca_ta_payout WHERE corporate_agency = '".$userId."' AND status_ca = '2' ");
                    // $sqlTAP -> execute();
                    // $sqlTAP -> setFetchMode(PDO::FETCH_ASSOC);
                    // if( $sqlTAP -> rowCount()>0 ){
                    //     foreach( ( $sqlTAP -> fetchAll() ) as $key => $row ){
                    //         $PendingComm = $row['teCommiAmt'];
                    //     }
                    // }

                    // $AmtTotalPending = $PendingAmt + $PendingComm;
                    $tdsAmtPending = $PendingAmt * $tdsPercentage;
                    $walletBalPending = $PendingAmt - $tdsAmtPending;
                    $truncatedWalletBalP = floor($walletBalPending * 100) / 100;
                    $finalAmtP = number_format($truncatedWalletBalP, 2);

                    //confirm amount
                    //status = 1 Confirm,  2 pending
                    $sqlCAP = $conn->prepare("SELECT SUM(ta_amt) as taProductAmt FROM product_payout WHERE ta_id = '" . $userId . "' AND ta_status='1' ");
                    $sqlCAP->execute();
                    $sqlCAP->setFetchMode(PDO::FETCH_ASSOC);
                    if ($sqlCAP->rowCount() > 0) {
                        foreach (($sqlCAP->fetchAll()) as $key => $row) {
                            $ConfirmAmt = $row['taProductAmt'];
                        }
                    }
                    //status = 1 pending,  2 confirm
                    // $sqlTAP = $conn -> prepare("SELECT SUM(commision_ca) as teCommiAmt FROM ca_ta_payout WHERE corporate_agency = '".$userId."' AND status_ca = '1' ");
                    // $sqlTAP -> execute();
                    // $sqlTAP -> setFetchMode(PDO::FETCH_ASSOC);
                    // if( $sqlTAP -> rowCount()>0 ){
                    //     foreach( ( $sqlTAP -> fetchAll() ) as $key => $row ){
                    //         $ConfirmComm = $row['teCommiAmt'];
                    //     }
                    // }

                    // $AmtTotalConfirm = $ConfirmAmt + $ConfirmComm;
                    $tdsAmtConfirm = $ConfirmAmt * $tdsPercentage;
                    $walletBalConfirm = $ConfirmAmt - $tdsAmtConfirm;
                    $truncatedWalletBalC = floor($walletBalConfirm * 100) / 100;
                    $finalAmtC = number_format($truncatedWalletBalC, 2);

                    ?>
                    <h1 class="mb-0 text-white">&#8377;<?php echo $finalAmtC; ?></h1>
                </div>
            </div>
            <div class="d-flex justify-content-between">
                <p class="text-white">Pending</p>
                <p class="text-white">&#8377;<?php echo $finalAmtP; ?></p>
            </div>
        </div>
    </div>
</div>
<?php
    if($customerType == 'Premium'){
?>
<!-- Progress Bar Start -->
<div class="d-flex justify-content-center">
    <div class="rounded-pill bg-primary couponCount">
        <h5 class="text-white text-center mb-0">Coupons Unlocked: <span>
            <?php 
                require '../connect.php';
                $cuponsusedtmt = $conn->prepare("SELECT COUNT(*) as used_count FROM cu_coupons WHERE user_id = :id AND usage_status =1");
                $cuponsusedtmt->execute(['id' => $userId]);
                $cupon = $cuponsusedtmt->fetch(PDO::FETCH_ASSOC);
                $usedCount = (int)$cupon['used_count'] > 3 ? 3:(int)$cupon['used_count'];
            ?>
        </span> <?= $usedCount??0 ?>/ <span>3</span></h5>
    </div>
</div>

<div class="row d-flex justify-content-center">
    <div class="col-md-8 col-sm-10 col-12 py-3">
        <div class="progress border border-2" role="progressbar" aria-label="Animated striped example" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100">
            <div class="progress-bar progressColor" style="width: <?= ($usedCount == 1) ? '25%' : (($usedCount == 2) ? '50%' : (($usedCount == 3) ? '100%' : '0%')) ?>"></div>
        </div>
    </div>
</div>
<!-- Progress Bar end -->
<!-- Coupon card start -->
<div class="row" id="couponRow">
    <!-- Coupon 1 -->
    <div class="col-md-3 col-sm-6 col-6 d-flex justify-content-center" id="coupon_card1">
        <div class="card rounded-4 w-75 cardCoupon1 position-relative">
            <div class="d-flex justify-content-center pt-3">
                <p class="rounded-circle text-center cardCouponIcon"></p>
                <i class="fa-solid fa-tag fa-2xl text-white couponIcon"></i>
            </div>
            <p class="fw-bolder text-center mb-0 text-white">Coupon 1</p>
            <div class="d-flex justify-content-center">
                <p class="rounded-pill py-1 px-3 cardCouponButton"></p>
                <p class="couponButton text-white fw-bold">Used</p>
            </div>

            <!-- Lock overlay -->
            <div class="cardCouponLock" id="cardCouponLockId">
                <div class="card rounded-4 w-100 h-100 couponLock">
                    <i class="ri-lock-line text-white fs-1 d-flex justify-content-center align-items-center h-100"></i>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Coupon card end -->

<?php   }?>