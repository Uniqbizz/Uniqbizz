<!-- New Card Template Start -->
<div class="row">
    <div class="<?= $userType == '33' ? 'col-xl-4':'col-xl-3' ?> col-lg-6 col-md-6 col-sm-6 col-12">
        <div class="card rounded-3 pt-3 pb-2 px-4 cardBg1">
            <div>
                <p class="text-white fw-bold">Registered Customer</p>
            </div>
            <div class="d-flex justify-content-between align-items-center mb-1">
                <span class="">
                    <i class="fa-regular fa-user fa-2xl" style="color: #ffffff;"></i>
                </span>
                <div class="ms-4">
                    <?php
                    $sql3 = "SELECT COUNT(ca_customer_id) as id FROM ca_customer WHERE ta_reference_no = '" . $userId . "' AND status = '1'";
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
                $sql3 = "SELECT COUNT(ca_customer_id) as id FROM ca_customer WHERE ta_reference_no = '" . $userId . "' AND YEAR(register_date) = '" . $DateYear . "' AND MONTH(register_date) = '" . $DateMonth . "'  AND status = '1'";
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
    <div class="<?= $userType == '33' ? 'col-xl-4':'col-xl-3' ?> col-lg-6 col-md-6 col-sm-6 col-12">
        <div class="card rounded-3 pt-3 pb-2 px-4 cardBg2">
            <div>
                <p class="text-white fw-bold">Completed Tours</p>
            </div>
            <div class="d-flex justify-content-between align-items-center mb-1">
                <span class="">
                    <i class="fa-regular fa-map fa-2xl" style="color: #ffffff;"></i>
                </span>
                <div class="ms-4">
                    <?php
                    $stmt = $conn->prepare("SELECT COUNT(ta_id) as completedTour FROM product_payout WHERE ta_id = ? AND end_date < NOW()");
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
                $stmt = $conn->prepare("SELECT COUNT(ta_id) as completedTourThisMonth FROM product_payout WHERE ta_id = ? AND end_date < NOW() AND  YEAR(end_date) = '" . $DateYear . "' AND MONTH(end_date) = '" . $DateMonth . "'");
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
    <div class="<?= $userType == '33' ? 'col-xl-4':'col-xl-3' ?> col-lg-6 col-md-6 col-sm-6 col-12">
        <div class="card rounded-3 pt-3 pb-2 px-4 cardBg3">
            <div>
                <p class="text-white fw-bold">Upcoming Tours</p>
            </div>
            <div class="d-flex justify-content-between align-items-center mb-1">
                <span class="">
                    <i class="fa-solid fa-clock-rotate-left fa-2xl" style="color: #ffffff;"></i>
                </span>
                <div class="ms-4">
                    <?php
                    $stmt = $conn->prepare("SELECT COUNT(ta_id) as upcomingTour FROM product_payout WHERE ta_id = ? AND start_date > NOW()");
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
                $stmt = $conn->prepare("SELECT COUNT(ta_id) as upcomingTourThisMonth FROM product_payout WHERE ta_id = ? AND start_date > NOW() AND  YEAR(start_date) = '" . $DateYear . "' AND MONTH(start_date) = '" . $DateMonth . "'");
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
    <?php if($userType != '33'){  ?>
    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-12">
        <div class="card rounded-3 pt-3 pb-2 px-4 cardBg4">
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
                    $sqlCAP = $conn->prepare("SELECT SUM(ta_amt) as taProductAmt FROM product_payout WHERE ta_id = '" . $userId . "' AND ta_status='2' ");
                    $sqlCAP->execute();
                    $sqlCAP->setFetchMode(PDO::FETCH_ASSOC);
                    if ($sqlCAP->rowCount() > 0) {
                        foreach (($sqlCAP->fetchAll()) as $key => $row) {
                            $PendingAmt = $row['taProductAmt'];
                        }
                    }
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

<!-- New Card Template end -->
<?php
    } 
?>