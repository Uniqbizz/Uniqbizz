<!-- New Card Template Start -->
<div class="row">
    <?php
        if ($userType == '26'){
    ?>

    <div class="col-xl-3 col-lg-4 col-md-4 col-sm-12 col-12">
        <div class="card rounded-3 pt-3 pb-2 px-4 cardBg1">
            <div>
                <p class="text-white fw-bold">Techno Enterprise</p>
            </div>
            <div class="d-flex justify-content-between align-items-center mb-1">
                <span class="">
                    <i class="fa-regular fa-user fa-2xl" style="color: #ffffff;"></i>
                </span>
                <div class="ms-4">
                    <?php
                        $sql3 = "SELECT COUNT(corporate_agency_id) as id FROM corporate_agency WHERE reference_no = '" . $userId . "' AND user_type = '16' AND status = '1'";
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
                    $sql3 = "SELECT COUNT(corporate_agency_id) as id FROM corporate_agency WHERE reference_no = '" . $userId . "' AND user_type = '16' AND YEAR(register_date) = '" . $DateYear . "' AND MONTH(register_date) = '" . $DateMonth . "' AND status = '1'";
                    $stmt3 = $conn->prepare($sql3);
                    $stmt3->execute();
                    $stmt3->setFetchMode(PDO::FETCH_ASSOC);
                    if ($stmt3->rowCount() > 0) {
                        foreach (($stmt3->fetchAll()) as $key => $row) {
                            $id = $row['id'];
                            echo '<p class="text-white">' . $id . '</p>';
                        }
                    }
                ?>

            </div>
        </div>
    </div>
    
    <?php
        }
        else if ($userType == '28' || $userType == '30') {
    ?>
    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
        <div class="card rounded-3 pt-3 pb-2 px-4 cardBg1">
            <div>
                <p class="text-white fw-bold">Franchisee</p>
            </div>
            <div class="d-flex justify-content-between align-items-center mb-1">
                <span class="">
                    <i class="fa-regular fa-user fa-2xl" style="color: #ffffff;"></i>
                </span>
                <div class="ms-4">
                    <?php
                        $sql3 = "SELECT COUNT(sub_franchisee_id) as id FROM sub_franchisee WHERE reference_no = '" . $userId . "' AND user_type = '29' AND status = '1'";
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
                    $sql3 = "SELECT COUNT(sub_franchisee_id) as id FROM sub_franchisee WHERE reference_no = '" . $userId . "' AND user_type = '29' AND YEAR(register_date) = '" . $DateYear . "' AND MONTH(register_date) = '" . $DateMonth . "' AND status = '1'";
                    $stmt3 = $conn->prepare($sql3);
                    $stmt3->execute();
                    $stmt3->setFetchMode(PDO::FETCH_ASSOC);
                    if ($stmt3->rowCount() > 0) {
                        foreach (($stmt3->fetchAll()) as $key => $row) {
                            $id = $row['id'];
                            echo '<p class="text-white">' . $id . '</p>';
                        }
                    }
                ?>

            </div>
        </div>
    </div>
    
    <?php        
        }
    ?>
    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
        <div class="card rounded-3 pt-3 pb-2 px-4 cardBg5">
            <div>
                <p class="text-white fw-bold">Institution</p>
            </div>
            <div class="d-flex justify-content-between align-items-center mb-1">
                <span class="">
                    <i class="fa-regular fa-user fa-2xl" style="color: #ffffff;"></i>
                </span>
                <div class="ms-4">
                    <?php
                        $sql3 = "SELECT COUNT(institution_id) as id FROM institution WHERE reference_no = '" . $userId . "' AND user_type = '29' AND status = '1'";
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
                    $sql3 = "SELECT COUNT(institution_id) as id FROM institution WHERE reference_no = '" . $userId . "' AND user_type = '29' AND YEAR(register_date) = '" . $DateYear . "' AND MONTH(register_date) = '" . $DateMonth . "' AND status = '1'";
                    $stmt3 = $conn->prepare($sql3);
                    $stmt3->execute();
                    $stmt3->setFetchMode(PDO::FETCH_ASSOC);
                    if ($stmt3->rowCount() > 0) {
                        foreach (($stmt3->fetchAll()) as $key => $row) {
                            $id = $row['id'];
                            echo '<p class="text-white">' . $id . '</p>';
                        }
                    }
                ?>

            </div>
        </div>
    </div>
    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
        <div class="card rounded-3 pt-3 pb-2 px-4 cardBg6">
            <div>
                <p class="text-white fw-bold">Institution Branch Manager</p>
            </div>
            <div class="d-flex justify-content-between align-items-center mb-1">
                <span class="">
                    <i class="fa-regular fa-user fa-2xl" style="color: #ffffff;"></i>
                </span>
                <div class="ms-4">
                    <?php
                        $sql3 = "SELECT COUNT(institution_branch_manager_id) as id FROM institution_branch_manager WHERE reference_no = '" . $userId . "' AND user_type = '29' AND status = '1'";
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
                    $sql3 = "SELECT COUNT(institution_branch_manager_id) as id FROM institution_branch_manager WHERE reference_no = '" . $userId . "' AND user_type = '29' AND YEAR(register_date) = '" . $DateYear . "' AND MONTH(register_date) = '" . $DateMonth . "' AND status = '1'";
                    $stmt3 = $conn->prepare($sql3);
                    $stmt3->execute();
                    $stmt3->setFetchMode(PDO::FETCH_ASSOC);
                    if ($stmt3->rowCount() > 0) {
                        foreach (($stmt3->fetchAll()) as $key => $row) {
                            $id = $row['id'];
                            echo '<p class="text-white">' . $id . '</p>';
                        }
                    }
                ?>

            </div>
        </div>
    </div>
    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
        <div class="card rounded-3 pt-3 pb-2 px-4 cardBg2">
            <div>
                <p class="text-white fw-bold">Travel Consultant</p>
            </div>
            <div class="d-flex justify-content-between align-items-center mb-1">
                <span class="">
                    <i class="fa-regular fa-user fa-2xl" style="color: #ffffff;"></i>
                </span>
                <div class="ms-4">
                    <?php
                        $count = 0;

                        if ($userType == '28') {
                            // First: TCs directly referred by Master Franchisee
                            $stmtDirect = $conn->prepare("SELECT ca_travelagency_id FROM ca_travelagency WHERE reference_no = ? AND status = '1'");
                            $stmtDirect->execute([$userId]);
                            $directTCs = $stmtDirect->fetchAll(PDO::FETCH_ASSOC);
                            foreach ($directTCs as $tc) {
                                $userTECHNO = $tc['ca_travelagency_id'] . ' ';
                                $count++;
                            }

                            // Second: TCs referred through Sub Franchisees
                            $stmt2 = $conn->prepare("SELECT sub_franchisee_id FROM `sub_franchisee` WHERE reference_no = ? AND user_type = '29'");
                            $stmt2->execute([$userId]);
                            $referrals = $stmt2->fetchAll(PDO::FETCH_ASSOC);

                            foreach ($referrals as $referral) {
                                $subFranchiseeId = $referral['sub_franchisee_id'];

                                $stmt4 = $conn->prepare("SELECT ca_travelagency_id FROM ca_travelagency WHERE reference_no = ? AND status = '1'");
                                $stmt4->execute([$subFranchiseeId]);
                                $tcList = $stmt4->fetchAll(PDO::FETCH_ASSOC);

                                foreach ($tcList as $tc) {
                                    $userTECHNO = $tc['ca_travelagency_id'] . ' ';
                                    $count++;
                                }
                            }
                        } else if ($userType == '30') {
                            
                            //TCs referred through Sub Franchisees
                            $stmt2 = $conn->prepare("SELECT sub_franchisee_id FROM `sub_franchisee` WHERE reference_no = ? AND user_type = '29'");
                            $stmt2->execute([$userId]);
                            $referrals = $stmt2->fetchAll(PDO::FETCH_ASSOC);

                            foreach ($referrals as $referral) {
                                $subFranchiseeId = $referral['sub_franchisee_id'];

                                $stmt4 = $conn->prepare("SELECT ca_travelagency_id FROM ca_travelagency WHERE reference_no = ? AND status = '1'");
                                $stmt4->execute([$subFranchiseeId]);
                                $tcList = $stmt4->fetchAll(PDO::FETCH_ASSOC);

                                foreach ($tcList as $tc) {
                                    $userTECHNO = $tc['ca_travelagency_id'] . ' ';
                                    $count++;
                                }
                            }
                        }else{
                            // For other user types, check through Corporate Agencies
                            $stmt2 = $conn->prepare("SELECT corporate_agency_id FROM `corporate_agency` WHERE reference_no = ? AND user_type = '16'");
                            $stmt2->execute([$userId]);
                            $referrals = $stmt2->fetchAll(PDO::FETCH_ASSOC);

                            foreach ($referrals as $referral) {
                                $corporateAgencyId = $referral['corporate_agency_id'];

                                $stmt4 = $conn->prepare("SELECT ca_travelagency_id FROM ca_travelagency WHERE reference_no = ? AND status = '1'");
                                $stmt4->execute([$corporateAgencyId]);
                                $tcList = $stmt4->fetchAll(PDO::FETCH_ASSOC);

                                foreach ($tcList as $tc) {
                                    $userTECHNO = $tc['ca_travelagency_id'] . ' ';
                                    $count++;
                                }
                            }
                        }


                        echo '<h1 class="mb-0 text-white">' . $count . '</h1>';
                    ?>
                </div>
            </div>
            <div class="d-flex justify-content-between">
                <p class="text-white">This Month</p>
                <?php
                    $count = 0; // Initialize count

                    if ($userType == '28') {
                        // 1. Count TCs directly referred by Master Franchisee
                        $stmtDirect = $conn->prepare("SELECT ca_travelagency_id FROM ca_travelagency 
                                                    WHERE reference_no = ? 
                                                    AND YEAR(register_date) = ? 
                                                    AND MONTH(register_date) = ? 
                                                    AND status = '1'");
                        $stmtDirect->execute([$userId, $DateYear, $DateMonth]);
                        $directTCs = $stmtDirect->fetchAll(PDO::FETCH_ASSOC);

                        foreach ($directTCs as $tc) {
                            $userTECHNO = $tc['ca_travelagency_id'] . ' ';
                            $count++;
                        }

                        // 2. Find Sub Franchisees under this Master Franchisee
                        $stmt2 = $conn->prepare("SELECT sub_franchisee_id FROM sub_franchisee 
                                                WHERE reference_no = ? AND user_type = '29'");
                        $stmt2->execute([$userId]);
                        $subFranchisees = $stmt2->fetchAll(PDO::FETCH_ASSOC);

                        foreach ($subFranchisees as $referral) {
                            $subFranchiseeId = $referral['sub_franchisee_id'];

                            $stmt4 = $conn->prepare("SELECT ca_travelagency_id FROM ca_travelagency 
                                                    WHERE reference_no = ? 
                                                    AND YEAR(register_date) = ? 
                                                    AND MONTH(register_date) = ? 
                                                    AND status = '1'");
                            $stmt4->execute([$subFranchiseeId, $DateYear, $DateMonth]);
                            $refTCs = $stmt4->fetchAll(PDO::FETCH_ASSOC);

                            foreach ($refTCs as $tc) {
                                $userTECHNO = $tc['ca_travelagency_id'] . ' ';
                                $count++;
                            }
                        }
                    }if ($userType == '30') {
                        
                        // Find Sub Franchisees under this Master Franchisee
                        $stmt2 = $conn->prepare("SELECT sub_franchisee_id FROM sub_franchisee 
                                                WHERE reference_no = ? AND user_type = '29'");
                        $stmt2->execute([$userId]);
                        $subFranchisees = $stmt2->fetchAll(PDO::FETCH_ASSOC);

                        foreach ($subFranchisees as $referral) {
                            $subFranchiseeId = $referral['sub_franchisee_id'];

                            $stmt4 = $conn->prepare("SELECT ca_travelagency_id FROM ca_travelagency 
                                                    WHERE reference_no = ? 
                                                    AND YEAR(register_date) = ? 
                                                    AND MONTH(register_date) = ? 
                                                    AND status = '1'");
                            $stmt4->execute([$subFranchiseeId, $DateYear, $DateMonth]);
                            $refTCs = $stmt4->fetchAll(PDO::FETCH_ASSOC);

                            foreach ($refTCs as $tc) {
                                $userTECHNO = $tc['ca_travelagency_id'] . ' ';
                                $count++;
                            }
                        }
                    } else {
                        // For other user types: count TCs via Corporate Agencies
                        $stmt2 = $conn->prepare("SELECT corporate_agency_id FROM corporate_agency 
                                                WHERE reference_no = ? AND user_type = '16'");
                        $stmt2->execute([$userId]);
                        $referrals = $stmt2->fetchAll(PDO::FETCH_ASSOC);

                        foreach ($referrals as $referral) {
                            $userBM = $referral['corporate_agency_id'];

                            $stmt4 = $conn->prepare("SELECT ca_travelagency_id FROM ca_travelagency 
                                                    WHERE reference_no = ? 
                                                    AND YEAR(register_date) = ? 
                                                    AND MONTH(register_date) = ? 
                                                    AND status = '1'");
                            $stmt4->execute([$userBM, $DateYear, $DateMonth]);
                            $userTEs = $stmt4->fetchAll(PDO::FETCH_ASSOC);

                            foreach ($userTEs as $userTE) {
                                $userTECHNO = $userTE['ca_travelagency_id'] . ' ';
                                $count++;
                            }
                        }
                    }

                    echo '<p class="text-white">' . $count . '</p>';

                ?>
            </div>
        </div>
    </div>
    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
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
                $sqlCAP = $conn->prepare("SELECT SUM(bm_amt) as bmProductAmt FROM product_payout WHERE bm_id = '" . $userId . "' AND bm_status='2' ");
                $sqlCAP->execute();
                $sqlCAP->setFetchMode(PDO::FETCH_ASSOC);
                if ($sqlCAP->rowCount() > 0) {
                    foreach (($sqlCAP->fetchAll()) as $key => $row) {
                        $PendingAmt = $row['bmProductAmt'];
                    }
                }
                //status = 1 pending,  2 confirm
                $sqlTAP = $conn->prepare("SELECT SUM(payout_amount) as bmSlabAmt FROM bm_payout_history WHERE bm_user_id = '" . $userId . "' AND payout_status = '1' ");
                $sqlTAP->execute();
                $sqlTAP->setFetchMode(PDO::FETCH_ASSOC);
                if ($sqlTAP->rowCount() > 0) {
                    foreach (($sqlTAP->fetchAll()) as $key => $row) {
                        $PendingComm = $row['bmSlabAmt'];
                    }
                }
                //status = 1 pending,  2 confirm
                $sqlTAP = $conn->prepare("SELECT SUM(commision_bm) as bmSlabAmt FROM ca_ta_payout WHERE business_mentor = '" . $userId . "' AND status = '1' ");
                $sqlTAP->execute();
                $sqlTAP->setFetchMode(PDO::FETCH_ASSOC);
                if ($sqlTAP->rowCount() > 0) {
                    foreach (($sqlTAP->fetchAll()) as $key => $row) {
                        $PendingTAComm = $row['bmSlabAmt'];
                    }
                }

                $AmtTotalPending = $PendingAmt + $PendingComm+$PendingTAComm;
                $tdsAmtPending = $AmtTotalPending * $tdsPercentage;
                $walletBalPending = $AmtTotalPending - $tdsAmtPending;
                $truncatedWalletBalP = floor($walletBalPending * 100) / 100;
                $finalAmtP = number_format($truncatedWalletBalP, 2);

                //confirm amount
                //status = 1 Confirm,  2 pending
                $sqlCAP2 = $conn->prepare("SELECT SUM(bm_amt) as bmProductAmt FROM product_payout WHERE bm_id = '" . $userId . "' AND bm_status='1' ");
                $sqlCAP2->execute();
                $sqlCAP2->setFetchMode(PDO::FETCH_ASSOC);
                if ($sqlCAP2->rowCount() > 0) {
                    foreach (($sqlCAP2->fetchAll()) as $key => $row) {
                        $ConfirmAmt = $row['bmProductAmt'];
                    }
                }
                //status = 1 pending,  2 confirm
                $sqlTAP2 = $conn->prepare("SELECT SUM(payout_amount) as bmSlabAmt FROM bm_payout_history WHERE bm_user_id = '" . $userId . "' AND payout_status = '2' ");
                $sqlTAP2->execute();
                $sqlTAP2->setFetchMode(PDO::FETCH_ASSOC);
                if ($sqlTAP2->rowCount() > 0) {
                    foreach (($sqlTAP2->fetchAll()) as $key => $row) {
                        $ConfirmComm = $row['bmSlabAmt'];
                    }
                }
                //status = 1 pending,  2 confirm
                $sqlTAP = $conn->prepare("SELECT SUM(commision_bm) as bmSlabAmt FROM ca_ta_payout WHERE business_mentor = '" . $userId . "' AND status = '2' ");
                $sqlTAP->execute();
                $sqlTAP->setFetchMode(PDO::FETCH_ASSOC);
                if ($sqlTAP->rowCount() > 0) {
                    foreach (($sqlTAP->fetchAll()) as $key => $row) {
                        $ConfirmTAComm = $row['bmSlabAmt'];
                    }
                }

                $AmtTotalConfirm = $ConfirmAmt + $ConfirmComm+$ConfirmTAComm;
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