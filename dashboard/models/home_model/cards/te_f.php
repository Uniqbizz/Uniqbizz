<!-- New Card Template Start -->
    <?php
    if ( $userType == '29') {
        if($fran_upgrade_status == 2){
    ?>
    <!-- upgrade card -->
<div class="row">
    <div class="col-12">
        <div class="upgrade-card card border-0 rounded-4 p-4">
            <div class="row align-items-center">
                
                <!-- Left Content -->
                <div class="col-lg-8 col-md-7 col-12">
                    <div class="d-flex align-items-start">
                        <img src="../assets/images/customer/popperImg.png" 
                            alt="Popper" 
                            class="me-3 upgrade-icon">

                        <div>
                            <h2 class="fw-bold mb-2">
                                Congratulations! 
                                <span class="highlight-upgrade">You've Upgraded 🎉</span>
                            </h2>
                            <p class="text-muted fs-5 mb-3">
                                Your new incentive and commission percentage is now active.
                            </p>

                            <a href="view_upgrade_history.php" class="btn upgrade-btn px-4 py-2">
                                View Details
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Right Image -->
                <div class="col-lg-4 col-md-5 col-12 text-center mt-4 mt-md-0">
                    <img src="../assets/images/user-illustarator-2.png"
                        class="img-fluid floating-img"
                        alt="Illustration">
                </div>

            </div>
        </div>
    </div>
</div>

    <?php
        } else if($fran_amount != '500000'){
    ?>
<div class="row">
    <div class="col-12">
        <div class="pre-upgrade-card card border-0 rounded-4 p-4">
            <div class="row align-items-center">

                <!-- Left Content -->
                <div class="col-lg-8 col-md-7 col-12">
                    <div class="d-flex align-items-start">
                        <img src="../assets/images/customer/upgrade-icon.png"
                            alt="Upgrade"
                            class="me-3 pre-icon">

                        <div>
                            <h2 class="fw-bold mb-2">
                                Unlock Higher Earnings 🚀
                            </h2>

                            <p class="text-muted fs-5 mb-3">
                                Upgrade! to increase your incentive
                                and commission percentage instantly.
                            </p>

                            <ul class="upgrade-benefits mb-3">
                                <li>Higher Commission Percentage</li>
                                <li>Priority Payout Processing</li>
                                <li>Access to Premium Benefits</li>
                            </ul>

                            <a class="btn upgrade-now-btn px-4 py-2" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                                Contact Admin for UPGRADE
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Right Image -->
                <div class="col-lg-4 col-md-5 col-12 text-center mt-4 mt-md-0">
                    <img src="../assets/images/upgrade-illustration.png"
                        class="img-fluid pulse-img"
                        alt="Upgrade Illustration">
                </div>

            </div>
        </div>
    </div>
</div>

    <?php
        }
    }
    ?>
    
<div class="row">

    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12">
        <div class="card rounded-3 pt-3 pb-2 px-4 cardBg1">
            <div>
                <p class="text-white fw-bold">Travel Consultant</p>
            </div>
            <div class="d-flex justify-content-between align-items-center mb-1">
                <span class="">
                    <i class="fa-regular fa-user fa-2xl" style="color: #ffffff;"></i>
                </span>
                <div class="ms-4">
                    <?php
                    if($userType == '16'){
                        $sql3 = "SELECT COUNT(DISTINCT ca.ca_travelagency_id) AS id
                                    FROM ca_travelagency ca
                                    LEFT JOIN tc_mapping tm 
                                        ON tm.tc_id = ca.ca_travelagency_id 
                                        AND tm.te_id = '" . $userId . "' 
                                        AND tm.map_status = 1
                                    WHERE (ca.reference_no = '" . $userId . "' OR tm.te_id = '" . $userId . "') 
                                    AND ca.status = '1'";
                        $stmt3 = $conn->prepare($sql3);
                        $stmt3->execute();
                        $stmt3->setFetchMode(PDO::FETCH_ASSOC);
                        if ($stmt3->rowCount() > 0) {
                            foreach (($stmt3->fetchAll()) as $key => $row) {
                                $id = $row['id'];
                                echo '<h1 class="mb-0 text-white">' . $id . '</h1>';
                            }
                        }
                    
                    }else if($userType == '32'){
                        $sql3 = "SELECT COUNT(DISTINCT ca.institution_branch_manager_id) AS id
                                    FROM institution_branch_manager ca
                                    WHERE ca.reference_no = '" . $userId . "' 
                                    AND ca.status = '1'";
                        $stmt3 = $conn->prepare($sql3);
                        $stmt3->execute();
                        $stmt3->setFetchMode(PDO::FETCH_ASSOC);
                        if ($stmt3->rowCount() > 0) {
                            foreach (($stmt3->fetchAll()) as $key => $row) {
                                $id = $row['id'];
                                echo '<h1 class="mb-0 text-white">' . $id . '</h1>';
                            }
                        }
                    
                    }else{
                        $sql3 = "SELECT COUNT(ca_travelagency_id) as id FROM ca_travelagency WHERE reference_no = '" . $userId . "' AND status = '1'";
                        $stmt3 = $conn->prepare($sql3);
                        $stmt3->execute();
                        $stmt3->setFetchMode(PDO::FETCH_ASSOC);
                        if ($stmt3->rowCount() > 0) {
                            foreach (($stmt3->fetchAll()) as $key => $row) {
                                $id = $row['id'];
                                echo '<h1 class="mb-0 text-white">' . $id . '</h1>';
                            }
                        }
                    }
                    ?>
                    <!-- <h1 class="mb-0 text-white">486</h1> -->
                </div>
            </div>
            <div class="d-flex justify-content-between">
                <p class="text-white">This Month</p>
                <?php
                if($userType == '16'){
                    $sql3 = "SELECT COUNT(DISTINCT ca.ca_travelagency_id) AS id
                                FROM ca_travelagency ca
                                LEFT JOIN tc_mapping tm
                                    ON tm.tc_id = ca.ca_travelagency_id
                                    AND tm.te_id = '" . $userId . "'
                                    AND YEAR(tm.map_date) = '" . $DateYear . "'
                                    AND MONTH(tm.map_date) = '" . $DateMonth . "'
                                    AND tm.map_status = 1
                                WHERE (ca.reference_no = '" . $userId . "' OR tm.te_id = '" . $userId . "')
                                AND ca.user_type = '11'
                                AND YEAR(ca.register_date) = '" . $DateYear . "'
                                AND MONTH(ca.register_date) = '" . $DateMonth . "'
                                AND ca.status = '1'";

                    $stmt3 = $conn->prepare($sql3);
                    $stmt3->execute();
                    
                    $stmt3->setFetchMode(PDO::FETCH_ASSOC);
                    if ($stmt3->rowCount() > 0) {
                        foreach (($stmt3->fetchAll()) as $key => $row) {
                            $id = $row['id'];
                            echo '<p class="text-white">' . $id . '</p>';
                        }
                    }
                }else if($userType == '32'){
                    $sql3 = "SELECT COUNT(institution_branch_manager_id) as id FROM institution_branch_manager WHERE reference_no = '" . $userId . "' AND user_type = '11' AND YEAR(register_date) = '" . $DateYear . "' AND MONTH(register_date) = '" . $DateMonth . "' AND status = '1'";
                    $stmt3 = $conn->prepare($sql3);
                    $stmt3->execute();
                    $stmt3->setFetchMode(PDO::FETCH_ASSOC);
                    if ($stmt3->rowCount() > 0) {
                        foreach (($stmt3->fetchAll()) as $key => $row) {
                            $id = $row['id'];
                            echo '<p class="text-white">' . $id . '</p>';
                        }
                    }
                }else{
                    $sql3 = "SELECT COUNT(ca_travelagency_id) as id FROM ca_travelagency WHERE reference_no = '" . $userId . "' AND user_type = '11' AND YEAR(register_date) = '" . $DateYear . "' AND MONTH(register_date) = '" . $DateMonth . "' AND status = '1'";
                    $stmt3 = $conn->prepare($sql3);
                    $stmt3->execute();
                    $stmt3->setFetchMode(PDO::FETCH_ASSOC);
                    if ($stmt3->rowCount() > 0) {
                        foreach (($stmt3->fetchAll()) as $key => $row) {
                            $id = $row['id'];
                            echo '<p class="text-white">' . $id . '</p>';
                        }
                    }
                }
                ?>

            </div>
        </div>
    </div>

    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12">
        <div class="card rounded-3 pt-3 pb-2 px-4 cardBg2">
            <div>
                <p class="text-white fw-bold">Customers</p>
            </div>
            <div class="d-flex justify-content-between align-items-center mb-1">
                <span class="">
                    <i class="fa-regular fa-user fa-2xl" style="color: #ffffff;"></i>
                </span>
                <div class="ms-4">
                    <?php
                    $stmt2 = $conn->prepare("SELECT ca_travelagency_id AS user_id FROM `ca_travelagency` WHERE reference_no = ? 
                                             UNION ALL
                                             SELECT institution_branch_manager_id AS user_id FROM `institution_branch_manager` WHERE reference_no = ?");
                    $stmt2->execute([$userId,$userId]);
                    $referrals = $stmt2->fetchAll(PDO::FETCH_ASSOC);

                    $count = 0; // Initialize count

                    foreach ($referrals as $referral) {
                        $userCA = $referral['user_id'];

                        $stmt4 = $conn->prepare("SELECT ca_customer_id FROM ca_customer WHERE ta_reference_no = ? AND status = '1'");
                        $stmt4->execute([$referral['user_id']]);
                        $stmt4->setFetchMode(PDO::FETCH_ASSOC);
                        if ($stmt4->rowCount() > 0) {
                            foreach (($stmt4->fetchAll()) as $userCATAs => $userCATA) {
                                $userTA = $userCATA['ca_customer_id'] . ' ';
                                $count++; // Increment count for each user_id
                            } //CATA foreach ends
                        } //CATA if loop ends
                    } //CA foreach ends 

                    echo '<h1 class="mb-0 text-white">' . $count . '</h1>';
                    ?>
                </div>
            </div>
            <div class="d-flex justify-content-between">
                <p class="text-white">This Month</p>
                <?php
                $stmt2 = $conn->prepare("SELECT ca_travelagency_id AS user_id FROM `ca_travelagency` WHERE reference_no = ? 
                                         UNION ALL
                                         SELECT institution_branch_manager_id AS user_id FROM `institution_branch_manager` WHERE reference_no = ? ");
                $stmt2->execute([$userId,$userId]);
                $referrals = $stmt2->fetchAll(PDO::FETCH_ASSOC);

                $count2 = 0; // Initialize count

                foreach ($referrals as $referral) {
                    $userBM = $referral['user_id'];

                    $stmt4 = $conn->prepare("SELECT ca_customer_id FROM ca_customer WHERE ta_reference_no = ? AND YEAR(register_date) = '" . $DateYear . "' AND MONTH(register_date) = '" . $DateMonth . "' AND status = '1'");
                    $stmt4->execute([$userBM]);
                    $stmt4->setFetchMode(PDO::FETCH_ASSOC);
                    if ($stmt4->rowCount() > 0) {
                        foreach (($stmt4->fetchAll()) as $userTEs => $userTE) {
                            $userTECHNO = $userTE['ca_customer_id'] . ' ';
                            $count2++; // Increment count for each user_id
                        } //CATA foreach ends
                    } //CATA if loop ends
                } //CA foreach ends 
                echo '<p class="text-white"> ' . $count2 . '</p>';
                ?>
            </div>
        </div>
    </div>

    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12">
        <div class="card rounded-3 pt-3 pb-2 px-4 cardBg4">
            <div>
                <p class="text-white fw-bold">Commission Earned</p>
            </div>
            <div class="d-flex justify-content-between align-items-center mb-1">
                <span class="">
                    <i class="fa-regular fa-money-bill-1 fa-2xl" style="color: #ffffff;"></i>
                </span>
                <?php

                //pending amount
                //status = 1 Confirm,  2 pending
                $sqlCAP = $conn->prepare("SELECT SUM(te_amt) as teProductAmt FROM product_payout WHERE te_id = '" . $userId . "' AND te_status='2' ");
                $sqlCAP->execute();
                $sqlCAP->setFetchMode(PDO::FETCH_ASSOC);
                if ($sqlCAP->rowCount() > 0) {
                    foreach (($sqlCAP->fetchAll()) as $key => $row) {
                        $PendingAmt = $row['teProductAmt'];
                    }
                }
                //status = 1 pending,  2 confirm
                $sqlTAP = $conn->prepare("SELECT SUM(commision_te) as teCommiAmt FROM ca_ta_payout WHERE techno_enterprise = '" . $userId . "' AND status_te = '2' ");
                $sqlTAP->execute();
                $sqlTAP->setFetchMode(PDO::FETCH_ASSOC);
                if ($sqlTAP->rowCount() > 0) {
                    foreach (($sqlTAP->fetchAll()) as $key => $row) {
                        $PendingComm = $row['teCommiAmt'];
                    }
                }

                $AmtTotalPending = $PendingAmt + $PendingComm;
                $tdsAmtPending = $AmtTotalPending * $tdsPercentage;
                $walletBalPending = $AmtTotalPending - $tdsAmtPending;
                $truncatedWalletBalP = floor($walletBalPending * 100) / 100;
                $finalAmtP = number_format($truncatedWalletBalP, 2);

                //confirm amount
                //status = 1 Confirm,  2 pending
                $sqlCAP = $conn->prepare("SELECT SUM(te_amt) as teProductAmt FROM product_payout WHERE te_id = '" . $userId . "' AND te_status='1' ");
                $sqlCAP->execute();
                $sqlCAP->setFetchMode(PDO::FETCH_ASSOC);
                if ($sqlCAP->rowCount() > 0) {
                    foreach (($sqlCAP->fetchAll()) as $key => $row) {
                        $ConfirmAmt = $row['teProductAmt'];
                    }
                }
                //status = 1 pending,  2 confirm
                $sqlTAP = $conn->prepare("SELECT SUM(commision_te) as teCommiAmt FROM ca_ta_payout WHERE techno_enterprise = '" . $userId . "' AND status_te = '1' ");
                $sqlTAP->execute();
                $sqlTAP->setFetchMode(PDO::FETCH_ASSOC);
                if ($sqlTAP->rowCount() > 0) {
                    foreach (($sqlTAP->fetchAll()) as $key => $row) {
                        $ConfirmComm = $row['teCommiAmt'];
                    }
                }

                $AmtTotalConfirm = $ConfirmAmt + $ConfirmComm;
                $tdsAmtConfirm = $AmtTotalConfirm * $tdsPercentage;
                $walletBalConfirm = $AmtTotalConfirm - $tdsAmtConfirm;
                $truncatedWalletBalC = floor($walletBalConfirm * 100) / 100;
                $finalAmtC = number_format($truncatedWalletBalC, 2);


                ?>
                <div class="ms-4">
                    <h1 class="mb-0 text-white">&#8377;<?php echo $finalAmtC  ?></h1>
                </div>
            </div>
            <div class="d-flex justify-content-between">
                <p class="text-white">Pending</p>
                <p class="text-white">&#8377;<?php echo $finalAmtP; ?></p>
            </div>
        </div>
    </div>

</div>
<!-- New Card Template end -->